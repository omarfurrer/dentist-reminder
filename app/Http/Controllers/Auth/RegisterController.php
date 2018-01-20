<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers {
        register as protected parentRegister;
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/billing';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data,
                               [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|between:6,12',
                    'clinic_name' => 'required|string|max:255',
                    'country_code' => 'required|string',
                    'mobile_number' => 'required|string|max:255',
                    'price_plan_id' => 'required|exists:price_plans,id'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $pricePlan = \App\PricePlan::find($data['price_plan_id']);
        $clinic = \App\Clinic::create([
                    'name' => $data['clinic_name'],
                    'sms_template' => "Dear {patient_first_name}, this is a reminder for your dental's appointment {day_relation} {date} at {time}.",
                    'price_plan_id' => $data['price_plan_id'],
                    'number_of_reminders_per_appointment' => $pricePlan->number_of_reminders_per_appointment
        ]);
        return User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'country_code' => $data['country_code'],
                    'mobile_number' => $data['mobile_number'],
                    'clinic_id' => $clinic->id
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(\Illuminate\Http\Request $request)
    {
        \Illuminate\Support\Facades\Session::flash('registration_redirect', true);
        return $this->parentRegister($request);
    }

}
