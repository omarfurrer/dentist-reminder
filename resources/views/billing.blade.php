@extends('layouts.app')

@section('content')  
<div class="container">
    <div class="row mt-5">
        <div class="col-sm-12">
            <h4 class="text-primary text-center">Billing Setup</h4>
        </div>
    </div>
    <div class="table-responsive">

        <table class="table text-center mt-2">
            <thead>
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">Appointments per day</th>
                    <th scope="col">SMS per appointment</th>
                    <th scope="col">Monthly SMS quota</th>
                    <th scope="col">Used This Month</th>
                    <th scope="col">Support</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="text-capitalize" scope="row">{{ $plan->name }} monthly</th>
                    <td>{{ $plan->number_of_appointments_per_day }}</td>
                    <td>{{ $plan->number_of_reminders_per_appointment }}</td>
                    <td>{{ $plan->sms_total }}</td>
                    <td>{{ $smsUsed }}</td>
                    <td>{{ $plan->support }}</td>
                    <td>${{ $plan->price }} billed monthly</td>
                    <td class="{{$user->clinic->billing_agreement_active ? 'text-success' : 'text-danger'}}">{{ $user->clinic->billing_agreement_active ? 'Active' : 'Inactive' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@if(!$user->clinic->billing_agreement_active)
    <div class="row card p-5">
        <div class="col-sm-12">
            <form id="myCCForm" action="{{ url('billing/activate') }}" method="post">
                <input name="token" type="hidden" value="" />
                {{ csrf_field() }}
                <h4 class="text-center">Card Information</h4>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="ccNo">Card Number</label>
                        <input id="ccNo" type="text" value="" autocomplete="off" required class="form-control" >
                    </div>
                    <div class="col-md-12">
                        <label>Expiration Date (MM/YYYY)</label>
                    </div>
                    <div class="form-group col-md-6">
                        <input id="expMonth" type="text" size="2" required class="form-control" >
                    </div>
                    <div class="form-group col-md-6">
                        <input id="expYear" type="text" size="4" required class="form-control" >
                    </div>
                    <div class="form-group col-md-12">
                        <label for="cvv">CVC</label>
                        <input id="cvv" type="text" value="" autocomplete="off" required class="form-control" >
                    </div>
                </div>

                <h4 class="text-center">Billing Address Information</h4>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="card_name">Card holder’s name</label>
                        <input id="card_name" type="text" name="card_name" required class="form-control" >
                    </div>

                    <div class="form-group col-md-12">
                        <label for="address_line_1">Address Line 1</label>
                        <input id="address_line_1" type="text" name="address_line_1" required class="form-control" >
                    </div>

                    <div class="form-group col-md-12">
                        <label for="address_line_2">Address Line 2</label>
                        <input id="address_line_2" type="text" name="address_line_2" class="form-control" >
                    </div>

                    <div class="form-group col-md-12">
                        <label for="city">City</label>
                        <input id="city" type="text" name="city" required class="form-control" >
                    </div>

                    <div class="form-group col-md-12">
                        <label for="state">State</label>
                        <input id="state" type="text" name="state" class="form-control" >
                    </div>

                    <div class="form-group col-md-12">
                        <label for="zip_code">Zip Code</label>
                        <input id="zip_code" type="text" name="zip_code" class="form-control" >
                    </div>

                    <!--EMAIL/COUNTRY/PHONE IN DB-->


                </div>

                <input type="submit" class="btn btn-primary pull-right" value="Submit Payment (${{ $plan->price }} billed monthly)" />
            </form>
        </div>
    </div>
@endif

</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<script type="text/javascript">

// Called when token created successfully.
var successCallback = function (data) {
var myForm = document.getElementById('myCCForm');
// Set the token as the value for the token input
myForm.token.value = data.response.token.token;
// IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
myForm.submit();
};
// Called when token creation fails.
var errorCallback = function (data) {
if (data.errorCode === 200) {
// This error code indicates that the ajax call failed. We recommend that you retry the token request.
} else {
alert(data.errorMsg);
}
};
var tokenRequest = function () {
// Setup token request arguments
var args = {
sellerId: {!!json_encode($tcAccountNumber)!!},
        publishableKey: {!!json_encode($tcPublicKey)!!},
        ccNo: $("#ccNo").val(),
        cvv: $("#cvv").val(),
        expMonth: $("#expMonth").val(),
        expYear: $("#expYear").val()
};
// Make the token request
TCO.requestToken(successCallback, errorCallback, args);
};
$(function () {
// Pull in the public encryption key for our environment
TCO.loadPubKey({!!json_encode($tcEnviorement)!!});
$("#myCCForm").submit(function (e) {
// Call our token request function
tokenRequest();
// Prevent form from submitting
return false;
});
});

</script>
@endpush

