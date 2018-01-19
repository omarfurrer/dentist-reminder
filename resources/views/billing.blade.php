@extends('layouts.app')

@section('content')  
<div class="container">
    <div class="row mt-5">
        <div class="col-sm-12">
            <h3 class="text-primary">Billing Setup</h3>
        </div>
    </div>

    <table class="table text-center mt-2">
        <thead>
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Appointments per day</th>
                <th scope="col">SMS per appointment</th>
                <th scope="col">Monthly SMS quota</th>
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
                <td>{{ $plan->support }}</td>
                <td>${{ $plan->price }} billed monthly</td>
                <td class="{{$user->clinic->billing_agreement_active ? 'text-success' : 'text-danger'}}">{{ $user->clinic->billing_agreement_active ? 'Active' : 'Inactive' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="row text-center">
        <div class="col-sm-12">
            @if(!$user->clinic->billing_agreement_active)
            <a class="btn btn-primary" href="{{ url('/billing/approve') }}">Activate (${{ $plan->price }} billed monthly)</a>
            @else
            <a class="btn btn-danger" href="{{ url('/billing/cancel') }}">Activate (${{ $plan->price }} billed monthly)</a>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(function () {


    });
</script>
@endpush

