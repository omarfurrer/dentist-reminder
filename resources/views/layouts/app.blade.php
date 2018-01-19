<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">


        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="{{{ asset('favicon.ico') }}}">
    </head>
    <body>
        <div id="app" class="fill">
            <!--NAVBAR-->
            <header class="header">
                <nav class="navbar navbar-expand-lg fixed-top"><a href="{{ url('/dashboard') }}" class="navbar-brand text-primary">{{ config('app.name', 'Laravel') }}</a>
                    <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><span></span><span></span><span></span></button>
                    <div id="navbarSupportedContent" class="collapse navbar-collapse">
                        @if (Auth::guest())
                        <ul class="navbar-nav ml-auto align-items-start align-items-lg-center">
                            <li class="nav-item"><a href="#hero" class="nav-link link-scroll">Home</a></li>
                            <li class="nav-item"><a href="#how-it-works" class="nav-link link-scroll">How It Works</a></li>
                            <li class="nav-item"><a href="#extra-features" class="nav-link link-scroll">Features</a></li>
                            <!--<li class="nav-item"><a href="#testimonials" class="nav-link link-scroll">Testimonials</a></li>-->
                            <li class="nav-item"><a href="#pricing" class="nav-link link-scroll">Pricing</a></li>
                            <li class="nav-item"><a href="#contact-us" class="nav-link link-scroll">Contact Us</a></li>
                            <!--<li class="nav-item"><a href="#faq" class="nav-link link-scroll">FAQ</a></li>-->
                        </ul>
                        <div class="navbar-text">   
                            <a href="#" data-toggle="modal" data-target="#loginModal" class="btn btn-primary navbar-btn btn-outline-primary">Sign In</a>
                            <!--<a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary navbar-btn btn-shadow btn-gradient">Sign Up For Free</a>-->
                            <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary navbar-btn btn-shadow btn-gradient">Sign Up</a>
                        </div>
                        @else
                        <ul class="navbar-nav ml-auto align-items-start align-items-lg-center">
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->clinic->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a href="{{ url('billing') }}" class="dropdown-item">
                                        Billing
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('logout') }}" class="dropdown-item"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                        @endif
                    </div>
                </nav>
            </header>

            @if(session()->has('error-message'))
            <div class="container mt-5">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            @if(is_array(session()->get('error-message')))
                            @foreach(session()->get('error-message') as $message)
                            <strong>Error!</strong> {{ $message }}
                            @endforeach
                            @else
                            <strong>Error!</strong> {{ session()->get('error-message') }}
                            @endif
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!--CONTENT-->
            @yield('content')

            <!--FOOTER-->
            <footer class="main-footer">
                <div class="copyrights">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <p>&copy; 2017 {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
                            </div>
                            <div class="col-md-5 text-right">
                                <!--<p>Template By <a href="https://bootstrapious.com/" class="external">Bootstrapious</a>  </p>-->
                                <!-- Please do not remove the backlink to Bootstrapious unless you support us at http://bootstrapious.com/donate. It is part of the license conditions. Thanks for understanding :) -->
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/all.js') }}"></script>
        <script>

                                           function deleteModel(event, form_id, message) {
                                               event.preventDefault();
                                               if (confirm(message)) {
                                                   document.getElementById(form_id).submit();
                                                   return true;
                                               }
                                               return false;
                                           }
        </script>
        @stack('scripts')
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
            (function () {
                var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/5a614c23d7591465c706e4b0/default';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    </body>
</html>
