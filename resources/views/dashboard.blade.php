@extends('layouts.app')

@section('content')  
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <button type="button" data-toggle="modal" data-target="#new-appointment-modal" class="btn btn-outline-primary pull-right"><i class="fa fa-plus"></i> New Appointment</button>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <ul class="list-group">
                @foreach($appointments as $appointment)
                <li class="list-group-item d-flex align-items-center{{$appointment->time->isToday()?' is-today' : ''}}">
                    <div class="col-md-3">
                        {{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name  }}
                    </div>
                    <div class="col-md-4">
                        {{ $appointment->time->isToday() ?( 'Today @ '. $appointment->time->format('h:i A') ) : $appointment->time->format('D d M @ h:i A') }}
                    </div>
                    <div class="col-md-4">
                        <!--<span class="badge badge-primary badge-pill">0 / 3 sent</span>-->
                        <ul class="sms-status-list">
                            @foreach($appointment->sms()->orderBy('send_at','ASC')->get() as $sms)
                            <li><i class="fa fa-circle {{'is-'.($sms->status == NULL ? 'queued' : $sms->status)}}"></i> {{ BladeHelpers::addOrdinalNumberSuffix($loop->iteration).' sms' }} {{ $sms->status == NULL ? 'queued' : $sms->status  }}</li>
                            @endforeach
                        </ul>
                        <!--<span class="badge badge-primary badge-pill">1 / {{ $appointment->sms()->count() }} delivery failed</span>-->
                    </div>
                    <div class="col-md-1 d-flex justify-content-end">
                        <a 
                            onclick="return deleteModel(event,'delete-form-{{$appointment->id}}', 'Are you sure you want to delete this appointment ? The patient will not receive SMS reminders.');">
                            <i class="fa fa-trash text-danger"></i></a>
                        <form id="delete-form-{{$appointment->id}}" action="/dashboard/appointments/{{ $appointment->id }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </div>
                    <!--<span class="badge badge-primary badge-pill">{{ $appointment->time->format('M d Y h:i A') }}</span>-->
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


<!-- Modal-->
<div id="new-appointment-modal" tabindex="-1" role="dialog" aria-labelledby="newAppointmentModalLabel" aria-hidden="true" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="newAppointmentModalLabel" class="modal-title">New Appointment</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="new-appointment-form" class="landing-form" method="POST" action="{{ url('/dashboard/appointments') }}">
                    {{ csrf_field() }}
                    <div class="form-row">

                        <div class="col-sm-12 new-patient d-none">
                            <label>New Patient's Name <a id="old-patient-toggle" class="pull-right"><i class="fa fa-arrow-left"></i> Existing Patient</a></label>
                        </div>
                        <div class="form-group col-md-6 new-patient d-none">
                            <input type="text" placeholder="First Name" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"  autofocus>
                            @if ($errors->has('first_name'))
                            <div id="first_name-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('first_name') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6 new-patient d-none">
                            <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" >
                            @if ($errors->has('last_name'))
                            <div id="last_name-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('last_name') }}</div>
                            @endif
                        </div>
                        <div class="col-sm-12 new-patient d-none">
                            <label for="mobile_number">New Patient's Mobile Number</label>
                        </div>
                        <div class="form-group col-md-3 new-patient d-none">
                            <input type="text" class="form-control" value="+{{ $countryCode }}" disabled>
                        </div>
                        <div class="form-group col-md-9 new-patient d-none">
                            <input type="text" placeholder="Mobile Number" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}" class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" >
                            @if ($errors->has('mobile_number'))
                            <div id="last_name-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('mobile_number') }}</div>
                            @endif
                        </div>

                        <div class="form-group col-md-12 old-patient">
                            <label>Existing Patient <a id="new-patient-toggle" class="pull-right"><i class="fa fa-plus"></i> New Patient</a></label>
                            <select name="patient_id" id="patient_id" class="form-control{{ $errors->has('patient_id') ? ' is-invalid' : '' }}">
                                <option disabled selected value>select a patient</option>
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->first_name . ' ' . $patient->last_name  }}
                            </option>
                            @endforeach
                        </select>
                        @if ($errors->has('patient_id'))
                        <div id="patient_id-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('patient_id') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="time">Appointment Time</label>
                        <input type="text" placeholder="Choose Appointment Time" name="time" id="time" value="{{ old('time') }}" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" >
                        @if ($errors->has('time'))
                        <div id="time-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('time') }}</div>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="submit btn btn-primary btn-shadow btn-gradient pull-right">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
    jQuery('#time').datetimepicker({
    minDate: 0,
            step: 30,
            formatTime: 'h:i A',
            format: 'M d Y h:i A',
            startDate: new Date,
            validateOnBlur: false
    });
    $('#new-patient-toggle,#old-patient-toggle').click(function () {
    $('.new-patient').toggleClass('d-none');
    $('.old-patient').toggleClass('d-none');
    });
    @if (Session::has('add_appointment_redirection'))
            $('#new-appointment-modal').modal({show: true});
    @endif

    });
</script>
@endpush

