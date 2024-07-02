<!DOCTYPE html>
<html lang="en-gb" dir="ltr">
<head>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield('sitefavicon')
<title>@yield('title')</title>
@yield('meta')
<link href="{{ asset('heag/assets/css/bootstrap.min.css')}}" rel="stylesheet">
<script src="{{ asset('heag/assets/js/jquery.min.js?e7601a180c22e0a6581f380041f447be')}}"></script>
<script src="{{ asset('heag/assets/js/bootstrap.min.js')}}"></script>
<link href="{{ asset('heag/assets/css/all_new.css')}}" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<link href='//fonts.googleapis.comcss?family=Open+Sans:400,300italic,300,400italic,700,700italic' rel='stylesheet' type='textcss'>
<link href="{{ asset('heag/assets/css/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{ asset('cardo/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
<link href="{{ asset('cardo/assets/validation/css/validationEngine.jquery.css')}}" rel="stylesheet">
<style>
    button.navbar-toggle.collapsed {
    background-color: #3172b2;
}
    .datetimepicker table tr td.disabled{
        color: #cccccc8a;
    }
    .datetimepicker-days span.dh, .datetimepicker-days span.dm { display:none !important;}
    .datetimepicker-hours span.dd, .datetimepicker-hours span.dm { display:none !important;}
    .datetimepicker-minutes span.dd, .datetimepicker-minutes span.dh { display:none !important;}
    span.dd, span.dh, span.dm{
        color: red;
    }
    #top-smaill-header a {
        color:#fff !important;
    }
    div#ja-wrapper {
    margin-bottom: 50px;
}
#mobileonly{
            display: none !important;
        }
@media (max-width: 575px) {
        .hide-mobile{
            display: none !important;
        }
       #mobileonly {
        display: block !important;
        }
        span.mobile-style {
    font-size: 19px;
}

    }
</style>
</head>

<body id="bd" class="fs3 Moz loader-activeaaa">

    
    <div id="ja-wrapper">

        <!-- HEADER -->

        <div id="ja-header" class="wrap">



            <div class="custom">
                <div class="main container">
                    <div class="inner clearfix row">
                        <div class="logo-div col-md-3 col-sm-6">
                        @yield('logoheader')
                        </div>
                        <!-- <div class="slogan col-md-5 hidden-sm hidden-xs"><span>&nbsp;&nbsp;&nbsp;&nbsp;{{ $domain->website_name}} You Can Trust</span><p style="text-align: center; color:#fff !important; font-size: 18px !important;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Airport Parking services</i></p>
                        </div> -->
                        <div class="accreditations col-md-9 col-sm-6 hidden-xs"><img
                                src="{{ asset('cardo/assets/img/new4.gif')}}" alt="Aiport Parking Accreditations"
                                class="img-responsive" style="width:100%;    margin-top: 15px;" />
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- //HEADER -->

        <!-- MAIN NAVIGATION -->

        <div id="ja-mainnav" class="wrap">

            <div class="main">

                <div class="inner clearfix">

                    <div class="ja-megamenu">


                        <nav class="navbar navbar-default">

                            <div class="container">

                                <div class="navbar-header">
                                <span id="mobileonly" style="text-transform: uppercase; font-size: 11px; margin-top: 17px; float: left; margin-left: 10px; color: red; font-weight: bold;"><img src="{{ asset('cardo/assets/img/343.gif')}}"></span>
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                        
                                        <span class="navbar-menu-text">Menu</span>

                                        <span class="sr-only">Toggle navigation</span>

                                        <span class="icon-bars">

                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>

                                        </span>

                                    </button>

                                </div>

                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                                    <ul class="nav navbar-nav menu">

                                        <li><a class="" href="/">Home</a></li>
                                        <li class="dropdown"><a class="item-105 dropdown-toggle" data-toggle="dropdown"
                                                role="button" aria-haspopup="true" aria-expanded="false" href="#"><span
                                                    class="caret"></span>Services</a>
                                            <ul class="dropdown-menu">
                                            @yield('direction_menu')
                                            </ul>
                                        </li>
                                        
                                        <li><a class="item-125"
                                                href="/directions">Directions</a>
                                        </li>
                                        <li><a class="item-125"
                                                href="/reviews">Testimonials</a>
                                        </li>
                                        <li><a href="/about-us">About</a></li>
                            
                                        <li><a href="/terms-conditions">Terms & Conditions</a></li>
                                        <li><a href="/contact-us">Contact us</a></li>
                                        <li><a class="item-239" href="/faq">FAQs</a></li>
                                        <?php  if (isset($_COOKIE["cus_id"])) { ?>
                                        <li class="dropdown"><a class="item-136 dropdown-toggle" data-toggle="dropdown"
                                                role="button" aria-haspopup="true" aria-expanded="false" href="#"><span
                                                    class="caret"></span>Account</a>
                                                    <ul class="dropdown-menu">
                                                    <li><a href="/my-bookings">My Bookings</a></li>
                                                    <li><a href="/profile"> Profile</a>
                                                    <li><a href="/customer-logout">Logout</a></li>
                                            
                                            </ul>
                                        </li>
                                        <?php } else { ?>
                                            <li><a href="/my-bookings">My Bookings</a></li>
                                            <li><a href="/sign-up">SignUp</a></li>
                                        <?php } ?>
                                    </ul>

                                </div>

                            </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- //MAIN NAVIGATION -->

@yield('content')

<!-- FOOTER -->

<div id="ja-footer">
<div class="copyright-bottom">
    <div class="ja-copyright container">
        <div class="row">
            <div class="col-md-7">
                <p class="company-info">
                    {{ $domain->address}}
                   
                   <br>
                   &copy; 2023  All rights reserved. <a href="/terms-conditions" target="_blank">Privacy Policy</a> 
                </p>
            </div>
            <div class="col-md-5">
                <p class="links-right">
                    <a href="/">{{ $domain->website_name}}</a> | <a href="/avout-us">About Us</a> | <a href="/terms-conditions">Terms & Conditions</a>
                </p>
                <p class="links-right">@if (trim($domain->email) !== '') <span><i class="fa fa-envelope" ></i><a style="color: #fff;" href="mailto:{{$domain->email}}">{{$domain->email}}</a></span></p>  @endif  @if (trim($domain->alternate_email) !== '')  <p class="links-right"><span><i class="fa fa-envelope" ></i><a style="color: #fff;" href="mailto:{{$domain->alternate_email}}">{{$domain->alternate_email}}</a></span>@endif </p>
                    @if (trim($domain->contact_num)  !== '' || trim($domain->alternate_contact_num)  !== '' )
                            <p class="links-right">@if (trim($domain->contact_num) !== '') <span><i class="fa fa-phone" ></i><a style="color: #fff;" href="tel:{{$domain->contact_num}}">{{$domain->contact_num}}</a>  @endif  @if (trim($domain->alternate_contact_num) !== '')  | <i class="fa fa-phone" ></i><a style="color: #fff;" href="tel:{{$domain->alternate_contact_num}}">{{$domain->alternate_contact_num}}</a></span>@endif</p>
                    @endif
                
            </div>
        </div>
        <div>
        <div class="col-md-12 col-sm-12">
                <img alt="Park Mark" src="{{ asset('cardo/assets/img/offers/new-cards.png')}}" class="img-responsive">
            </div>
        </div>
    </div>
</div>
</div>
<!-- //FOOTER -->
<script type="text/javascript">
jQuery(document).ready(function ($) {

    var stickyNavTop = $('#ja-mainnav').offset().top;
    var stickyNav = function () {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > stickyNavTop) {
            $('#ja-mainnav').addClass('sticky');
        } else {
            $('#ja-mainnav').removeClass('sticky');
        }
    };
    stickyNav();
    $(window).scroll(function () {
        stickyNav();
    });
});
</script>


<!--=== Common Js ===-->
<!--=== Jquery Min Js ===-->
<script src="{{ asset('cardo/assets/js/jquery-3.2.1.min.js')}}"></script>
<!--=== Jquery Migrate Min Js ===-->
<script src="{{ asset('cardo/assets/js/jquery-migrate.min.js')}}"></script>
<script src="{{ asset('cardo/assets/js/plugins/gijgo.js')}}"></script>
<script src="{{ asset('cardo/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{ asset('cardo/assets/validation/js/languages/jquery.validationEngine-en.js')}}"></script>
<script src="{{ asset('cardo/assets/validation/js/jquery.validationEngine.min.js')}}"></script>
<script src="{{ asset('cardo/assets/js/validate.js')}}"></script>
<script src="{{ asset('cardo/assets/js/main.js')}}?t=<?php echo time(); ?>"></script>
<script src="{{ asset('cardo/assets/js/min10.js')}}?t=<?php echo time(); ?>"></script>
<!-- <script src="{{ asset('/template/assets/js/main.js') }} "></script> -->
<script src="{{ asset('/template/assets/js/jquery-ui.js') }} "></script>
<!--=== Commom Js ===-->
</div>

</body>

</html>