
@extends('layouts.app')

@section('content')      
<!-- Modal-->
<div id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!--<h5 id="exampleModalLabel" class="modal-title">Sign Up For Free Trial</h5>-->
                <h5 id="exampleModalLabel" class="modal-title">Sign Up</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="signupform" class="landing-form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="col-sm-12">
                            <label for="first_name">Doctor's Name</label>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" placeholder="First Name" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"  autofocus>
                            @if ($errors->has('first_name'))
                            <div id="first_name-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('first_name') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" >
                            @if ($errors->has('last_name'))
                            <div id="last_name-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('last_name') }}</div>
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label for="email">Doctor's Email<small> - used to log in</small></label>
                            <input type="email" placeholder="John@email.com" name="email" id="email" value="{{ old('email') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" >
                            @if ($errors->has('email'))
                            <div id="email-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label for="password">Password</label>
                            <input type="password" placeholder="6 to 12 characters long" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" >
                            @if ($errors->has('password'))
                            <div id="password-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('password') }}</div>
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label for="clinic_name">Clinic Name</label>
                            <input type="text" placeholder="Smily Dental" name="clinic_name" id="clinic_name" value="{{ old('clinic_name') }}" class="form-control{{ $errors->has('clinic_name') ? ' is-invalid' : '' }}" >
                            @if ($errors->has('clinic_name'))
                            <div id="clinic_name-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('clinic_name') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                            <!-- country codes (ISO 3166) and Dial codes. -->
                            <label for="country_code">Country</label>
                            <select name="country_code" id="country_code" class="form-control{{ $errors->has('country_code') ? ' is-invalid' : '' }}">
                                <option disabled selected value>select a country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['code'] }}" {{ old('country_code') == $country['code'] ? 'selected' : '' }}>{{ $country['name'] }} (+{{ $country['code'] }})</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_code'))
                            <div id="country_code-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('country_code') }}</div>
                            @endif
                        </div>
                        <div class="col-sm-12 new-patient d-none">
                            <label for="mobile_number">Mobile Number<small> - used to contact you</small></label>
                        </div>
                        <div class="form-group col-md-3">
                            <input id="display_country_code" type="text" class="form-control" value="" disabled>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" placeholder="1005214486" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}" class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" >
                            @if ($errors->has('mobile_number'))
                            <div id="mobile_number-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('mobile_number') }}</div>
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label for="price_plan_id">Price Plan</label>
                            <select name="price_plan_id" id="price_plan_id" class="form-control{{ $errors->has('price_plan_id') ? ' is-invalid' : '' }}">
                                <option disabled selected value>select a plan</option>
                                @foreach($pricePlans as $pricePlan)
                                <option value="{{ $pricePlan->id }}" {{ old('price_plan_id') == $pricePlan->id ? 'selected' : '' }}>{{ $pricePlan->name }} {{ $pricePlan->number_of_reminders_per_appointment }} SMS/appt - monthly plan (${{$pricePlan->price}}) - {{ $pricePlan->sms_total }} SMS</option>
                                @endforeach
                            </select>
                            @if ($errors->has('price_plan_id'))
                            <div id="price_plan_id-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('price_plan_id') }}</div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="submit btn btn-primary btn-shadow btn-gradient pull-right">Signup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">Sign In To Your Account</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="loginform" class="landing-form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="email">Email</label>
                            <input type="email" placeholder="John@email.com" name="email" id="email" value="{{ old('email') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" >
                            @if ($errors->has('email'))
                            <div id="email-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" >
                            @if ($errors->has('password'))
                            <div id="password-error" class="invalid-feedback animated fadeInDown">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="submit btn btn-primary btn-shadow btn-gradient pull-right">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--HERO-->
<section id="hero" class="hero bg-gray">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-5 text order-2 order-lg-1">
                <h1>Reduce no-shows and last minute cancellations</h1>
                <p class="hero-text">Remind your patients automatically with a simple SMS</p>
                <div class="CTA">
                    <a href="#how-it-works" class="btn btn-primary btn-shadow btn-gradient link-scroll">Discover More</a>
                    <!--<a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-primary">Sign Up Now For Free</a>-->
                    <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-primary">Sign Up Now</a>
                </div>
            </div>
            <!--<div class="col-lg-6 order-1 order-lg-2 text-center"><img src="img/sms-sample-2.png" alt="..." class="img-fluid"></div>-->
            <!--<div class="col-lg-7 order-1 order-lg-2 text-center"><img src="img/Image-1_iphone6_silver_portrait.png" alt="..." class="img-fluid"></div>-->
            <div class="col-lg-7 order-1 order-lg-2 text-center"><img src="img/Image-1_iphone8plussilver_portrait.png" alt="..." class="img-fluid"></div>
        </div>
    </div>
</section>

<!--HOW IT WORKS-->
<section id="how-it-works" class="how-it-works">
    <div class="container">
        <div class="row d-flex justify-content-center"> 
            <div class="col-lg-8 text-center">
                <h2 class="h3">How it works</h2>
                <p class="mb-5">It takes less than 2 minutes</p>
            </div>
        </div>
        <div id="myTab" role="tablist" class="nav nav-tabs">
            <div class="row">
                <div class="col-md-4">
                    <a id="nav-first-tab" aria-expanded="true" class="nav-item nav-link"> 
                        <span class="number">1</span>
                        <h4>Sign Up</h4>
                        Enter basic information about your clinic 
                    </a>
                </div>
                <div class="col-md-4">
                    <a id="nav-second-tab" class="nav-item nav-link">
                        <span class="number">2</span>
                        <h4>Setup</h4>
                        Easily add your appointments to your account
                    </a>
                </div>
                <div class="col-md-4">
                    <a id="nav-third-tab" class="nav-item nav-link">
                        <span class="number">3</span>
                        <h4>Start Sending</h4>
                        That's it, the system will automatically send reminders to your patients
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!--FEATURES-->
<section id="extra-features" class="extra-features bg-primary">
    <div class="container text-center">
        <header>
            <h2>Great Features</h2>
            <div class="row">
                <p class="lead col-lg-8 mx-auto">Doctor Reminder has some great features to help your patients never miss another appointment</p>
            </div>
        </header>
        <div class="grid row">
            <div class="item col-lg-4 col-md-6">
                <div class="icon"> <i class="icon-gears"></i></div>
                <h3 class="h5">Painless Setup</h3>
                <p>Easy Configuration and setup for busy doctors.</p>
            </div>
            <div class="item col-lg-4 col-md-6">
                <div class="icon"> <i class="icon-notification"></i></div>
                <h3 class="h5">Upto 3 reminders</h3>
                <p>Send upto 3 SMS reminders per appointment.</p>
            </div>
            <div class="item col-lg-4 col-md-6">
                <div class="icon"> <i class="icon-quality"></i></div>
                <h3 class="h5">Preserve Your Branding</h3>
                <p>Your brand name is important, that's why all SMS reminders are sent with your Clinic Name.</p>
            </div>
            <div class="item col-lg-4 col-md-6">
                <div class="icon"> <i class="icon-profits"></i></div>
                <h3 class="h5">Flexible Pricing</h3>
                <p>Different pricing packages enusres you get the best value.</p>
            </div>
            <div class="item col-lg-4 col-md-6">
                <div class="icon"> <i class="icon-worldwide"></i></div>
                <h3 class="h5">International SMS Support</h3>
                <p>Our tool can send SMS reminders anywhere in the world.</p>
            </div>
            <div class="item col-lg-4 col-md-6">
                <div class="icon"> <i class="icon-support"></i></div>
                <h3 class="h5">Reliable Customer Support</h3>
                <p>We offer our customers reliable support with a high response rate.</p>
            </div>

        </div>
    </div>
</section>

<!--PRICING-->
<section class="bg-dark" id="pricing">
    <div class="container text-center">
        <header class="text-white">
            <h2>Pricing</h2>
            <div class="row">
                <!--<p class="lead col-lg-8 mx-auto">All plans include a 2 weeks trial</p>--> 
                <!--free-->
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-md-3">
                    <label for="number_of_reminders">Customize your plan</label>
                    <select name="number_of_reminders" id="number_of_reminders" class="form-control text-center">
                        <option value="1" selected>1 SMS per appointment</option>
                        <option value="2">2 SMS per appointment</option>
                        <option value="3">3 SMS per appointment</option>
                    </select>
                </div>
            </div>
        </header>
        <div class="row d-md-flex mt-5 text-center">
            <div class="col-sm-4 mt-1">
                <div id="basic-pricing-card" class="card card-outline-primary">
                    <div class="card-body">
                        <h5 class="card-title pt-4 text-orange">Basic</h5>
                        <h3 class="card-title text-orange pt-4"><sup>$</sup> <span class="price-value">16.99</span></h3>
                        <p class="card-text text-muted pb-3 border-bottom">per month</p>
                        <ul class="list-unstyled pricing-list">
                            <li><b>3</b> appointments / day</li>
                            <li>Max of <b class="sms-number-value">66</b> SMS / month</li>
                            <li><b>Basic</b> Support</li>
                        </ul>
                        <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-radius btn-gradient signup-pricing-link" data-price-plan-id="1">Sign Up</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-1 wow fadeIn">
                <div id="standard-pricing-card" class="card card-outline-primary bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title pt-4 text-white">Standard</h5>
                        <h3 class="card-title text-orange pt-4"><sup>$</sup> <span class="price-value">24.99</span></h3>
                        <p class="card-text text-muted pb-3 border-bottom">per month</p>
                        <ul class="list-unstyled pricing-list">
                            <li><b>5</b> appointments / day</li>
                            <li>Max of <b class="sms-number-value">110</b> SMS / month</li>
                            <li><b>Priority</b> Support</li>
                        </ul>
                        <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-white btn-radius signup-pricing-link" data-price-plan-id="2">Sign Up</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-1 wow fadeIn">
                <div id="advanced-pricing-card" class="card card-outline-primary">
                    <div class="card-body">
                        <h5 class="card-title pt-4 text-orange">Advanced</h5>
                        <h3 class="card-title text-primary pt-4"><sup>$</sup> <span class="price-value">37.99</span></h3>
                        <p class="card-text text-muted pb-3 border-bottom">per month</p>
                        <ul class="list-unstyled pricing-list">
                            <li><b>10</b> appointments / day</li>
                            <li>Max of <b class="sms-number-value">220</b> SMS / month</li>
                            <li><b>Premium</b> Support</li>
                        </ul>
                        <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-radius btn-gradient signup-pricing-link" data-price-plan-id="3">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!--CONTACT US-->
<section id="contact-us" class="contact-us bg-gray">
    <div class="container text-center">
        <h2>Contact Us</h2>
        <p class="lead">For larger packages and inquiries please contact us using the link below</p>
        <a class="btn btn-primary btn-gradient" href="mailto:support@dentistreminder.com">Contact Us</a>
        <p>or send us an email <b>support@dentistreminder.com</b></p>
    </div>
</section>

<!--SCROLL TO TOP-->
<div id="scrollTop">
    <div class="d-flex align-items-center justify-content-end"><i class="fa fa-long-arrow-up"></i>To Top</div>
</div>

@endsection

@push('scripts')
<script>
    @if (Session::has('registration_redirect'))
            $('#exampleModal').modal({show: true});
    @endif
            @if (Session::has('login_redirect'))
    $('#loginModal').modal({show: true});
    @endif

            $(function() {
            var pricing = {
                'basic-pricing-card': {
                    1: {price_plan_id: 1, sms: 66, price: 16.99},
                    2: {price_plan_id: 4, sms: 132, price: 21.99},
                    3: {price_plan_id: 7, sms: 198, price: 25.99}
                },
                'standard-pricing-card': {
                    1: {price_plan_id: 2, sms: 110, price: 24.99},
                    2: {price_plan_id: 5, sms: 220, price: 32.99},
                    3: {price_plan_id: 8, sms: 330, price: 40.99}
                },
                'advanced-pricing-card': {
                    1: {price_plan_id: 3, sms: 220, price: 37.99},
                    2: {price_plan_id: 6, sms: 440, price: 53.99},
                    3: {price_plan_id: 9, sms: 660, price: 68.99}
                }
            };
            $('#number_of_reminders').on('change', function () {
                var numberOfReminders = this.value;
                $('#basic-pricing-card .sms-number-value').text(pricing['basic-pricing-card'][numberOfReminders]['sms']);
                $('#basic-pricing-card .price-value').text(pricing['basic-pricing-card'][numberOfReminders]['price']);
                $('#basic-pricing-card a').attr('data-price-plan-id', pricing['basic-pricing-card'][numberOfReminders]['price_plan_id']);
                $('#standard-pricing-card .sms-number-value').text(pricing['standard-pricing-card'][numberOfReminders]['sms']);
                $('#standard-pricing-card .price-value').text(pricing['standard-pricing-card'][numberOfReminders]['price']);
                $('#standard-pricing-card a').attr('data-price-plan-id', pricing['standard-pricing-card'][numberOfReminders]['price_plan_id']);
                $('#advanced-pricing-card .sms-number-value').text(pricing['advanced-pricing-card'][numberOfReminders]['sms']);
                $('#advanced-pricing-card .price-value').text(pricing['advanced-pricing-card'][numberOfReminders]['price']);
                $('#advanced-pricing-card a').attr('data-price-plan-id', pricing['advanced-pricing-card'][numberOfReminders]['price_plan_id']);
            });
            $('.signup-pricing-link').on('click', function () {
                var pricingPlanID = $(this).attr('data-price-plan-id');
                $('#price_plan_id option[value="' + pricingPlanID + '"]').attr("selected", "selected");
            });

            $('#country_code').on('change', function () {
            var code = '+' + this.value;
                    $('#display_country_code').val(code);
            });
            }
            );
</script>
@endpush

