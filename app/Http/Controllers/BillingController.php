<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use Illuminate\Support\Facades\Log;
use PayPal\Exception\PayPalConnectionException;

class BillingController extends Controller {

    public function getBilling()
    {
        $user = $this->authUser;
        $plan = $user->clinic->price_plan;
        return view('billing', compact('user', 'plan'));
    }

    public function approve()
    {
        $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                config('dentistreminder.paypal.client_id'), // ClientID
                       config('dentistreminder.paypal.client_secret')      // ClientSecret
                )
        );

        $billingPlan = $this->authUser->clinic->price_plan;
        $user = $this->authUser;
        $clinic = $user->clinic;

        $agreement = new Agreement();
        $agreement->setName($billingPlan->name . ' monthly plan ($' . $billingPlan->price . ') - ' . $billingPlan->sms_total . ' SMS')
                ->setDescription('Agreement of ' . $billingPlan->name . ' monthly plan ($' . $billingPlan->price . ') - ' . $billingPlan->sms_total . ' SMS with ' . $clinic->name . ' ID: ' . $clinic->id)
                ->setStartDate(Carbon::now()->endOfDay()->toIso8601String());

// Add Plan ID
// Please note that the plan Id should be only set in this case.
        $plan = new Plan();
        $plan->setId($billingPlan->paypal_plan_id);
        $agreement->setPlan($plan);
// Add Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

//        dd($agreement->toJSON());

        try {
            // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
            $agreement = $agreement->create($apiContext);
            // ### Get redirect url
            // The API response provides the url that you must redirect
            // the buyer to. Retrieve the url from the $agreement->getApprovalLink()
            // method
            $approvalUrl = $agreement->getApprovalLink();

            return redirect()->to($approvalUrl);
        } catch (PayPalConnectionException $ex) {
            Log::error('error occured while approving agreement',
                       [
                'user' => $user,
                'clinic' => $clinic,
                'agreement' => $agreement,
                'exception' => $ex->getData()
            ]);
        }

        Session::flash('error-message', 'Something went wrong. Please try again and if it fails, contact us to solve this issue.');
        return redirect()->back();
    }

}
