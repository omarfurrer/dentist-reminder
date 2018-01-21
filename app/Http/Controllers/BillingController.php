<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Sms;
use Illuminate\Support\Facades\App;
use Twocheckout;
use Twocheckout_Error;
use Twocheckout_Charge;

class BillingController extends Controller {

    public function getBilling()
    {
        $user = $this->authUser;
        $plan = $user->clinic->price_plan;
        // Check for year as well
        $smsUsed = Sms::join('appointments', 'sms.appointment_id', '=', 'appointments.id')
                ->join('patients', 'appointments.patient_id', '=', 'patients.id')
                ->whereRaw('MONTH(sms.send_at) = ?', [date('m')])
                ->where('patients.clinic_id', '=', $this->authUser->clinic->id)
                ->where('sms.sent', '=', true)
                ->count();
        $tcAccountNumber = config('dentistreminder.two_checkout.account_number');
        $tcPublicKey = config('dentistreminder.two_checkout.public_key');
        $tcEnviorement = App::environment('production') ? 'production' : 'sandbox';
        return view('billing', compact('user', 'plan', 'smsUsed', 'tcAccountNumber', 'tcPublicKey', 'tcEnviorement'));
    }

    public function activate(Request $request)
    {
        $tcAccountNumber = config('dentistreminder.two_checkout.account_number');
        $tcPublicKey = config('dentistreminder.two_checkout.public_key');
        $tcPrivateKey = config('dentistreminder.two_checkout.private_key');
        $tcEnviorement = App::environment('production') ? 'production' : 'sandbox';

        Twocheckout::privateKey($tcPrivateKey);
        Twocheckout::sellerId($tcAccountNumber);
        $sandbox = false;
        if ($tcEnviorement != 'production') {
            $sandbox = true;
            // If you want to turn off SSL verification (Please don't do this in your production environment)
            Twocheckout::verifySSL(false);  // this is set to true by default
            // To use your sandbox account set sandbox to true
            Twocheckout::sandbox(true);
        }

        $billingPlan = $this->authUser->clinic->price_plan;

        try {
            $charge = Twocheckout_Charge::auth(array(
                        "sellerId" => $tcAccountNumber,
                        "merchantOrderId" => $this->authUser->id,
                        "token" => $request->token,
                        "currency" => 'USD',
//                        "total" => $billingPlan->price,
                        "lineItems" => [[
                        "type" => "product",
                        "name" => $billingPlan->name . ' monthly plan ($' . $billingPlan->price . ')',
                        "quantity" => 1,
                        "price" => $billingPlan->price,
                        "tangible" => 'N',
                        "productId" => $billingPlan->id,
                        "recurrence" => "1 Month",
                        "duration" => "Forever"]
                        ],
                        "billingAddr" => array(
                            "name" => $sandbox ? 'Joe Flagster' : $request->card_name,
                            "addrLine1" => $sandbox ? '123 Main Street' : $request->address_line_1,
                            "addrLine2" => $sandbox ? '' : $request->address_line_2,
                            "city" => $sandbox ? 'Townsville' : $request->city,
                            "state" => $sandbox ? 'Ohio' : $request->state,
                            "zipCode" => $sandbox ? '43206' : $request->zip_code,
                            "country" => $sandbox ? 'USA' : 'EG',
                            "email" => $this->authUser->email,
                            "phoneNumber" => $this->authUser->mobile_number
                        ),
            ));
            $data = $charge['response'];
            $transactionID = $data['transactionId'];
            $orderNumber = $data['orderNumber'];
            $responseMsg = $data['responseMsg'];
            $responseCode = $data['responseCode'];
            $total = $data['total'];

            $this->authUser->clinic->transactions()->create([
                'transaction_id' => $transactionID,
                'order_number' => $orderNumber,
                'response_msg' => $responseMsg,
                'response_code' => $responseCode,
                'total' => $total,
                'data' => $data
            ]);

            if ($responseCode == 'APPROVED') {
                $this->authUser->clinic->billing_agreement_active = 1;
                $this->authUser->clinic->save();
                Session::flash('success-message', 'Congratulations. Your payment has been successful.');
                return redirect()->back();
            }
        } catch (Twocheckout_Error $e) {
            Log::error('Error while activating billing', [
                'errorMsg' => $e->getMessage(),
                'user_id' => $this->authUser->id
            ]);

            Session::flash('error-message', 'Something went wrong. Please try again and if it fails, contact us to solve this issue.');
            return redirect()->back();
        }

        Log::error('Error while activating billing. No exception.',
                   [
            'errorMsg' => $e->getMessage(),
            'user_id' => $this->authUser->id,
            'charge' => $charge
        ]);

        Session::flash('error-message', 'Something went wrong. Please try again and if it fails, contact us to solve this issue.');
        return redirect()->back();
    }

}
