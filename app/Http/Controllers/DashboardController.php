<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddAppointmentWithPatientRequest;
use App\Patient;
use App\Appointment;
use App\Sms;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller {

    /**
     * Get dashboard view.
     * 
     * @return type
     */
    public function getDashboard()
    {

        $patients = $this->authUser->clinic->patients;
        $appointments = $this->authUser->clinic->appointments()->whereDate('time', '>=', Carbon::today())->orderBy('time', 'ASC')->get();
        $countryCode = $this->authUser->country_code;
        return view('dashboard', compact('appointments', 'patients', 'countryCode'));
    }

    public function addAppointmentWithPatient(AddAppointmentWithPatientRequest $request)
    {
        $patient = null;

        $patient_id = $request->get('patient_id');

        if (empty($patient_id)) {
            $patient = Patient::create([
                        'first_name' => $request->get('first_name'),
                        'last_name' => $request->get('last_name'),
                        'mobile_number' => $request->get('mobile_number'),
                        'clinic_id' => $this->authUser->clinic_id
            ]);
        } else {
            $patient = Patient::find($patient_id);
        }

        if (!$this->authUser->clinic->billing_agreement_active) {
            Session::flash('error-message', 'You need to setup your billing first before creating an appointment.');
            return redirect()->to('/billing');
        }

        $totalSMSEligibleThisMonth = $this->authUser->clinic->price_plan->sms_total;
        $totalSMSUsedThisMonth = Sms::join('appointments', 'sms.appointment_id', '=', 'appointments.id')
                ->join('patients', 'appointments.patient_id', '=', 'patients.id')
                ->whereRaw('MONTH(sms.send_at) = ?', [date('m')])
                ->where('patients.clinic_id', '=', $this->authUser->clinic->id)
                ->where('sms.sent', '=', true)
                ->count();

        if ($totalSMSUsedThisMonth >= $totalSMSEligibleThisMonth) {
            Session::flash('error-message', 'You have exceeded your monthly quota. Please Contact us to solve this issue.');
            return redirect()->back();
        }

        $appointment = Appointment::create([
                    'time' => Carbon::createFromFormat('M d Y h:i A', $request->get('time'))->toDateTimeString(),
                    'patient_id' => $patient->id
        ]);

        $numberOfReminders = $this->authUser->clinic->number_of_reminders_per_appointment;
        $template = $this->authUser->clinic->sms_template;
        $template = str_replace('{patient_first_name}', $patient->first_name, $template);

        $countryCode = '+' . $this->authUser->country_code;

        $from_number = $countryCode . $this->authUser->mobile_number;
        $from_name = $this->truncate($this->authUser->clinic->name, 11, '');
        $to = $countryCode . $patient->mobile_number;

        for ($i = 1; $i <= $numberOfReminders; $i++) {
            switch ($i) {
                case 3:
                    $send_at = $appointment->time->subDay()->hour(21)->minute(00)->second(0);
                    $content = str_replace('{day_relation}', 'tomorrow', $template);
                    $content = str_replace('{date}', $appointment->time->format('D d-M-Y'), $content);
                    $content = str_replace('{time}', $appointment->time->format('h:i A'), $content);
                    break;
                case 2:
                    $send_at = $appointment->time->hour(9)->minute(00)->second(0);
                    $content = str_replace('{day_relation}', 'today', $template);
                    $content = str_replace('{date}', $appointment->time->format('D d-M-Y'), $content);
                    $content = str_replace('{time}', $appointment->time->format('h:i A'), $content);
                    break;
                case 1:
                    $send_at = $appointment->time->subHours(3);
                    $content = str_replace('{day_relation}', 'today', $template);
                    $content = str_replace('{date}', $appointment->time->format('D d-M-Y'), $content);
                    $content = str_replace('{time}', $appointment->time->format('h:i A'), $content);
                    break;
            }
            if ($send_at < Carbon::now()) {
                continue;
            }
            Sms::create([
                'content' => $content,
                'from_number' => $from_number,
                'from_name' => $from_name,
                'to' => $to,
                'send_at' => $send_at->subHours(2), // For EG timezone
                'appointment_id' => $appointment->id
            ]);
        }

        return redirect()->route('dashboard');
    }

    function truncate($string, $length, $dots = "...")
    {
        return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
    }

//    protected function truncate($string, $length = 100, $append = "&hellip;")
//    {
//        $string = trim($string);
//
//        if (strlen($string) > $length) {
//            $string = wordwrap($string, $length);
//            $string = explode("\n", $string, 2);
//            $string = $string[0] . $append;
//        }
//
//        return $string;
//    }

    public function deleteAppointment(Appointment $appointment)
    {
//        dd($appointment);
        $appointment->delete();
        return redirect()->route('dashboard');
    }

}
