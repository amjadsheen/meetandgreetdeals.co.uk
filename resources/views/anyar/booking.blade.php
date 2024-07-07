@extends('anyar.layouts.app')
@section('content')
@section('sitefavicon')
<link rel="shortcut icon" href="/storage/uploads/{{$domain->website_favicon}}" type="image/x-icon" />
@stop
@section('title', $domain->website_name)
@section('logoheader')
<a href="/">
    <img src="/storage/uploads/{{$domain->website_logo}}" alt="logo {{$domain->website_name}}" class="img-responsive" />
</a>
@stop

@section('top-header')

<div class="col-md-3 col-sm-4 contact-details">
    @if (trim($domain->working_time) !== '')
    <span><i class="fa fa-clock-o"></i> {{$domain->working_time}}</span>
    @endif
</div>
<div class="col-md-9 col-sm-8 contact-details">
    <span><i class="fa fa-envelope"></i><a href="mailto:{{$domain->email}}">{{$domain->email}}</a></span> <span><i class="fa fa-envelope"></i><a href="mailto:{{$domain->alternate_email}}">{{$domain->alternate_email}}</a></span>
    @if (trim($domain->contact_num) !== '' || trim($domain->alternate_contact_num) !== '' )
    <span><i class="fa fa-phone"></i> <a href="tel:{{$domain->contact_num}}">{{$domain->contact_num}}</a> | <a href="tel:{{$domain->alternate_contact_num}}">{{$domain->alternate_contact_num}}</a></span>
    @endif
</div>


@stop

@section('meta')
<meta name="title" content="{{$domain->website_meta_title}}">
<meta name="description" content="{{$domain->website_meta_description}}">
<meta name="keywords" content="{{$domain->website_meta_keywords}}">
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{$domain->website_meta_title}}" />
<meta property="og:description" content="{{$domain->website_meta_description}}" />
<meta property="og:url" content="{{$domain->website_url}}" />
<meta property="og:image" content="/storage/uploads/{{$domain->website_logo}}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="{{$domain->website_meta_description}}" />
<meta name="twitter:title" content="{{$domain->website_meta_title}}" />
<meta name="twitter:image" content="/storage/uploads/{{$domain->website_logo}}" />
@stop
@section('direction_menu')
@foreach($services as $service)
<li><a href="/services/{{$service->slug}}">{{$service->service_name}}</a></li>
@endforeach
@stop

<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
    <div class="container">
    </div>
</section>
<!--== Page Title Area End ==-->
<style>
   .price {
    font-size: 28px;
    line-height: 25px;
    margin: 15px 0 6px;
    font-weight: 900;
    text-align: center;
    color: #da0909;
}
.price.small{
    font-size: 22px;
}
    .section-title{
        text-align:left;
        padding-bottom: 10px;
    }
    .section-title h2 {
    font-size: 23px;
}
    .color1 {
    background: #ccc;
    padding: 12px 15px 0px 15px;
}
.color2 {
    background: #5145458a;
    padding: 12px 15px 0px 15px;
}
    .datetime {
        background-color: #fafafa;
        border: 1px solid #eaeaea;
        color: #000;
        padding: 7px 15px;
        resize: none;
        width: 100%;
        border-radius: 3px;
    }

    .maindiv {
        padding-bottom: 18px;
    }

    .faq-details-content hr {
        margin-top: 20px;
        margin-bottom: 20px;
        /*border: 2px solid #f0edef;*/
        /* border: 2px solid red; */
    }

    .mt20 {
        margin-top: 20px;
    }

    .mb20 {
        margin-bottom: 20px;
    }

    #scroll p,
    #scrollpp p {
        font-size: 15px;
    }

    .totalclass {
        font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Charcoal, Helvetica Inserat, Bitstream Vera Sans Bold, Arial Black, "sans serif";
        /*color: #fff;*/
        font-size: 24px;
        text-transform: uppercase;
        line-height: 1;
        font-weight: 500;
    }

    h5 {
        font-size: 2em;
        color: #000;
        font-weight: 900;
        font-family: monospace;
    }

    samll {
        font-size: 9px;
    }

    .card {
        border: transparent;
    }

    .card img {
        margin-bottom: 20px;
        width: 211px;
        margin-left: 15%;
    }

    .funkyradio div {
        clear: both;
        overflow: hidden;
    }

    .funkyradio label {
        width: 100%;
        border-radius: 3px;
        border: 1px solid #D1D3D4;
        font-weight: normal;
    }

    .funkyradio input[type="radio"]:empty,
    .funkyradio input[type="checkbox"]:empty {
        /*display: none;*/
        visibility: hidden;
        float: left;
        position: absolute;
        top: 30px;
    }

    .funkyradio input[type="radio"]:empty~label,
    .funkyradio input[type="checkbox"]:empty~label {
        position: relative;
        line-height: 2.5em;
        text-indent: 3.25em;
        margin-top: 1em;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .funkyradio input[type="radio"]:empty~label:before,
    .funkyradio input[type="checkbox"]:empty~label:before {
        position: absolute;
        display: block;
        top: 0;
        bottom: 0;
        left: 0;
        content: '';
        width: 2.5em;
        background: #D1D3D4;
        border-radius: 3px 0 0 3px;
        visibility: hidden;
    }

    .funkyradio input[type="radio"]:hover:not(:checked)~label,
    .funkyradio input[type="checkbox"]:hover:not(:checked)~label {
        color: #888;
    }

    .funkyradio input[type="radio"]:hover:not(:checked)~label:before,
    .funkyradio input[type="checkbox"]:hover:not(:checked)~label:before {
        content: '\2714';
        text-indent: .9em;
        color: #C2C2C2;
        visibility: hidden;
    }

    .funkyradio input[type="radio"]:checked~label,
    .funkyradio input[type="checkbox"]:checked~label {
        color: #777;
    }

    .funkyradio input[type="radio"]:checked~label:before,
    .funkyradio input[type="checkbox"]:checked~label:before {
        content: '\2714';
        text-indent: .9em;
        color: #333;
        background-color: #ccc;
        visibility: hidden;
    }

    .funkyradio input[type="radio"]:focus~label:before,
    .funkyradio input[type="checkbox"]:focus~label:before {
        box-shadow: 0 0 0 3px #999;
    }

    .funkyradio-default input[type="radio"]:checked~label:before,
    .funkyradio-default input[type="checkbox"]:checked~label:before {
        color: #333;
        background-color: #ccc;
    }

    .funkyradio-primary input[type="radio"]:checked~label:before,
    .funkyradio-primary input[type="checkbox"]:checked~label:before {
        color: #fff;
        background-color: #337ab7;
    }

    .funkyradio-success input[type="radio"]:checked~label:before,
    .funkyradio-success input[type="checkbox"]:checked~label:before {
        color: #fff;
        background-color: #5cb85c;
    }

    .funkyradio-danger input[type="radio"]:checked~label:before,
    .funkyradio-danger input[type="checkbox"]:checked~label:before {
        color: #fff;
        background-color: #d9534f;
    }

    .funkyradio-warning input[type="radio"]:checked~label:before,
    .funkyradio-warning input[type="checkbox"]:checked~label:before {
        color: #fff;
        background-color: #f0ad4e;
    }

    .funkyradio-info input[type="radio"]:checked~label:before,
    .funkyradio-info input[type="checkbox"]:checked~label:before {
        color: #fff;
        background-color: #5bc0de;
    }

    .frb-group {
        margin: 15px 0;
    }

    .frb~.frb {
        margin-top: 15px;
    }

    .frb input[type="radio"]:empty,
    .frb input[type="checkbox"]:empty {
        /*display: none;*/
        visibility: hidden;
        position: absolute;
        top: 35px;
    }

    .frb input[type="radio"]~label:before,
    .frb input[type="checkbox"]~label:before {
        font-family: FontAwesome;
        content: '\f096';
        position: absolute;
        top: 50%;
        margin-top: -11px;
        left: 15px;
        font-size: 22px;
        visibility: hidden;
    }

    .frb input[type="radio"]:checked~label:before,
    .frb input[type="checkbox"]:checked~label:before {
        content: '\f046';
    }

    .frb input[type="radio"]~label,
    .frb input[type="checkbox"]~label {
        position: relative;
        cursor: pointer;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 5px 2px;
    }

    .frb input[type="radio"]~label:focus,
    .frb input[type="radio"]~label:hover,
    .frb input[type="checkbox"]~label:focus,
    .frb input[type="checkbox"]~label:hover {
        box-shadow: 0px 0px 3px #333;
    }

    .frb input[type="radio"]:checked~label,
    .frb input[type="checkbox"]:checked~label {
        color: #fafafa;
    }

    .frb input[type="radio"]:checked~label,
    .frb input[type="checkbox"]:checked~label {
        background-color: #f2f2f2;
    }

    .frb.frb-default input[type="radio"]:checked~label,
    .frb.frb-default input[type="checkbox"]:checked~label {
        color: #333;
    }

    .frb.frb-primary input[type="radio"]:checked~label,
    .frb.frb-primary input[type="checkbox"]:checked~label {
        background-color: #337ab7;
    }

    .frb.frb-success input[type="radio"]:checked~label,
    .frb.frb-success input[type="checkbox"]:checked~label {
        background-color: #5cb85c;
    }

    .frb.frb-info input[type="radio"]:checked~label,
    .frb.frb-info input[type="checkbox"]:checked~label {
        background-color: #5bc0de;
    }

    .frb.frb-warning input[type="radio"]:checked~label,
    .frb.frb-warning input[type="checkbox"]:checked~label {
        background-color: #f0ad4e;
    }

    .frb.frb-danger input[type="radio"]:checked~label,
    .frb.frb-danger input[type="checkbox"]:checked~label {
        background-color: #d9534f;
    }

    .frb input[type="radio"]:empty~label span,
    .frb input[type="checkbox"]:empty~label span {
        display: inline-block;
    }

    .frb input[type="radio"]:empty~label span.frb-title,
    .frb input[type="checkbox"]:empty~label span.frb-title {
        font-size: 16px;
        font-weight: 700;
        margin: 5px 5px 5px 50px;
    }

    .frb input[type="radio"]:empty~label span.frb-description,
    .frb input[type="checkbox"]:empty~label span.frb-description {
        font-weight: normal;
        font-style: italic;
        color: #999;
        margin: 5px 5px 5px 50px;
    }

    .frb input[type="radio"]:empty:checked~label span.frb-description,
    .frb input[type="checkbox"]:empty:checked~label span.frb-description {
        color: #fafafa;
    }

    .frb.frb-default input[type="radio"]:empty:checked~label span.frb-description,
    .frb.frb-default input[type="checkbox"]:empty:checked~label span.frb-description {
        color: #999;
    }

    /* Medium Devices, Desktops */
    @media only screen and (min-width : 992px) {
        /*.fixedElement {*/
        /*    position:fixed;*/
        /*    top: 0px;*/
        /*    right: 9%;*/
        /*    width:auto;*/
        /*    z-index:100;*/
        /*}*/
    }

    #step_2 .error {
        order: 3;
        width: 100%;
        color: red;
        padding: 1vh 0 0 0;
        margin: 0;
    }

    /* Large Devices, Wide Screens */
    @media only screen and (min-width : 1200px) {
        /*.fixedElement {*/
        /*    position:fixed;*/
        /*    top: 0px;*/
        /*    right: 9%;*/
        /*    width:auto;*/
        /*    z-index:100;*/
        /*}*/
    }

    .loader {
        background-image: url("{{ asset('cardo/assets/img/25.gif')}}");
        background-repeat: no-repeat;
        background-position: 50%;
    }

    #continue {
        cursor: pointer;
        text-align: center;
        width: 80%;
        margin: 0 auto;
        padding: 12px;

    }

    .login-form {
        /*background-color: red4f;*/
        padding: 50px 20px 15px;
    }

    .formError .formErrorContent {
        min-width: 175px;
        font-size: 10px;
    }

    .blackPopup .formErrorContent {
        background: #ee0101;
    }

    .usernameformError.parentFormstep_2.formError.blackPopup {
        top: 255px !important;
    }

    .passwrdformError.parentFormstep_2.formError.blackPopup {
        top: 316px !important;
    }

    #final-notice {
        background-image: url("{{ asset('cardo/assets/img/loader-am.gif')}}");
        background-repeat: no-repeat;
        background-position: 50%;
        background-size: 150px;
    }
</style>
<style>
    .maindiv {
        padding-bottom: 18px;
    }

    #faq-page-area hr {
        margin-top: 20px;
        margin-bottom: 20px;
        /*border: 2px solid #f0edef;*/
        /* border: 2px solid red; */
    }

    .mt20 {
        margin-top: 20px;
    }

    .mb20 {
        margin-bottom: 20px;
    }

    #scroll p,
    #scrollpp p {
        font-size: 15px;
    }

    .totalclass {
        font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Charcoal, Helvetica Inserat, Bitstream Vera Sans Bold, Arial Black, "sans serif";
        /*color: #fff;*/
        font-size: 24px;
        text-transform: uppercase;
        line-height: 1;
        font-weight: 500;
    }



    samll {
        font-size: 9px;
    }

    .card {
        border: transparent;
    }

    .card img {
        margin-bottom: 20px;
        width: 211px;
        margin-left: 15%;
    }


    .frb-group {
        margin: 15px 0;
    }

    .frb~.frb {
        margin-top: 15px;
    }

    .frb input[type="radio"]:empty,
    .frb input[type="checkbox"]:empty {
        /*display: none;*/
        visibility: hidden;
        position: absolute;
        top: 35px;
    }

    .frb input[type="radio"]~label:before,
    .frb input[type="checkbox"]~label:before {
        font-family: FontAwesome;
        content: '\f096';
        position: absolute;
        top: 52%;
        margin-top: -11px;
        left: 15px;
        font-size: 22px;
    }

    .frb input[type="radio"]:checked~label:before,
    .frb input[type="checkbox"]:checked~label:before {
        content: '\f046';
    }

    .frb input[type="radio"]~label,
    .frb input[type="checkbox"]~label {
        position: relative;
        cursor: pointer;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f2f2f2;
    }

    .frb input[type="radio"]~label:focus,
    .frb input[type="radio"]~label:hover,
    .frb input[type="checkbox"]~label:focus,
    .frb input[type="checkbox"]~label:hover {
        box-shadow: 0px 0px 3px #333;
    }

    .frb input[type="radio"]:checked~label,
    .frb input[type="checkbox"]:checked~label {
        color: #fafafa;
    }

    .frb input[type="radio"]:checked~label,
    .frb input[type="checkbox"]:checked~label {
        background-color: #f2f2f2;
    }

    .frb.frb-default input[type="radio"]:checked~label,
    .frb.frb-default input[type="checkbox"]:checked~label {
        color: #333;
    }

    .frb.frb-primary input[type="radio"]:checked~label,
    .frb.frb-primary input[type="checkbox"]:checked~label {
        background-color: #337ab7;
    }

    .frb.frb-success input[type="radio"]:checked~label,
    .frb.frb-success input[type="checkbox"]:checked~label {
        background-color: #5cb85c;
    }

    .frb.frb-info input[type="radio"]:checked~label,
    .frb.frb-info input[type="checkbox"]:checked~label {
        background-color: #5bc0de;
    }

    .frb.frb-warning input[type="radio"]:checked~label,
    .frb.frb-warning input[type="checkbox"]:checked~label {
        background-color: #f0ad4e;
    }

    .frb.frb-danger input[type="radio"]:checked~label,
    .frb.frb-danger input[type="checkbox"]:checked~label {
        background-color: #d9534f;
    }

    .frb input[type="radio"]:empty~label span,
    .frb input[type="checkbox"]:empty~label span {
        display: inline-block;
    }

    .frb input[type="radio"]:empty~label span.frb-title,
    .frb input[type="checkbox"]:empty~label span.frb-title {
        font-size: 16px;
        font-weight: 700;
        margin: 5px 5px 5px 50px;
    }

    .frb input[type="radio"]:empty~label span.frb-description,
    .frb input[type="checkbox"]:empty~label span.frb-description {
        font-weight: normal;
        font-style: italic;
        color: #ed0505;
        margin: 5px 5px 5px 50px;
    }

    .frb input[type="radio"]:empty:checked~label span.frb-description,
    .frb input[type="checkbox"]:empty:checked~label span.frb-description {
        color: #fafafa;
    }

    .frb.frb-default input[type="radio"]:empty:checked~label span.frb-description,
    .frb.frb-default input[type="checkbox"]:empty:checked~label span.frb-description {
        color: #999;
    }

    /* Medium Devices, Desktops */
    @media only screen and (min-width: 992px) {
        /*.fixedElement {*/
        /*    position: fixed;*/
        /*    top: 0px;*/
        /*    right: 9%;*/
        /*    width: auto;*/
        /*    z-index: 100;*/
        /*}*/
    }

    #step_3 .error {
        order: 3;
        width: 100%;
        color: red;
        padding: 1vh 0 0 0;
        margin: 0;
    }

    /* Large Devices, Wide Screens */
    @media only screen and (min-width: 1200px) {
        /*.fixedElement {*/
        /*    position: fixed;*/
        /*    top: 0px;*/
        /*    right: 9%;*/
        /*    width: auto;*/
        /*    z-index: 100;*/
        /*}*/
    }

    .loader {
        background-image: url("{{ asset('cardo/assets/img/25.gif')}}");
        background-repeat: no-repeat;
        background-position: 50%;
    }

    #final-notice {
        background-image: url("{{ asset('cardo/assets/img/loader-am.gif')}}");
        background-repeat: no-repeat;
        background-position: 50%;
        background-size: 150px;
    }

    #continue {
        cursor: pointer;
    }

    .login-form {
        background-color: #red4f;
        padding: 50px 20px 15px;
    }

    .formError .formErrorContent {
        min-width: 175px;
        font-size: 10px;
    }

    .blackPopup .formErrorContent {
        background: #ee0101;
    }

    #verify {
        cursor: pointer;
    }

    .single-sidebar {
        padding-top: 14px;
        box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
        background: #cccccc1a;
        margin-top: 15px;
        /* padding: 20px 10px; */
    }

    #cart-content {
        padding-bottom: 14px;
    }

    #cart-content p,
    .card .box-title,
    .totalclass h3 {
        margin: 0 0 2px !important;
        padding: 0 19px;
    }

    p span {
        color: #da0909 !important;
        font-weight: 900;
    }

    .luggage-lable {
        width: 25%;
        cursor: pointer;
        font-weight: 900;
        font-size: 16px;
    }

    .input-text-luggage {
        cursor: pointer;
    }

    .luggage-lable span {
        margin-left: 10px;
    }
    .funkyradio input[type="radio"]:checked~label, .frb.frb-success input[type="checkbox"]:checked~label {
    background: orangered;
    color: #fff;
}
#mcart{
    padding: 0 50px;
}
@media (max-width: 575px) {
    .luggage-lable{
        width: 100%;
    }
    #mcart{
    padding: 0 20px;
}
    .price.small {
    font-size: 17px;
}
}
</style>
<!--== FAQ Area Start ==-->
<div class="container-fluid">
<section id="faq-page-area" class="section-padding">

        <div class="row">
            <div class="col-lg-8">

                <form method="post"  id="step_2" data-stripe-publishable-key="{{ $skey }}">
                @csrf
                    <input type="hidden" name="step_single" value="1">
                    <div class="faq-details-content require-validation">
                        <!-- Single FAQ Subject  Start -->
                        <div class="booking-section travelo-box borderbox">

                            <div class="maindiv">


                                @if($show_login == 1)
                                <!-- contact details start here -->
                                <div class="row mt20">
                                    <div class="col-md-12 section-title">
                                        <hr>
                                        <h2 class="section-title__title mb-2">CUSTOMER INFO</h2>
                                    </div>
                                </div>
                                <div id="customer-login-section">
                                    <div class="choose-content-wrap">
                                        <!-- Choose Area Tab Menu -->
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="one_off_tab-tab" data-bs-toggle="tab" data-bs-target="#shared_tab_content" type="button" role="tab" aria-controls="shared_tab_content" aria-selected="true">One Off Booking</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="sign-in-tab" data-bs-toggle="tab" data-bs-target="#sign_in_tab_content" type="button" role="tab" aria-controls="sign_in_tab_content" aria-selected="false">Sign In</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#shared_tab_content" type="button" role="tab" aria-controls="shared_tab_content" aria-selected="false">Register</button>
                                            </li>
                                        </ul>



                                        <!-- Choose Area Tab Menu -->

                                        <!-- Choose Area Tab content -->
                                        <div class="tab-content" id="myTabContent">

                                            <!-- Newest Cars Tab Start -->
                                            <div class="tab-pane fade show active" id="shared_tab_content" role="tabpanel" aria-labelledby="one_off_tab-tab">
                                                <!-- Newest Cars Content Wrapper Start -->

                                                <div class="login-form">
                                                    <div class="row">
                                                        <div class="col-md-12 mb20">
                                                            <h6><strong>Personal information</strong></h6>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">

                                                            <div class="input-group mb-3">
                                                                <label class="input-group-text" for="title">Title</label>
                                                                <select class="form-select " name="title" id="title">
                                                                    <option value="">Select</option>
                                                                    <option value="Mr.">Mr.</option>
                                                                    <option value="Mrs.">Mrs.</option>
                                                                    <option value="Miss.">Miss.</option>
                                                                    <option value="Dr.">Dr.</option>
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">
                                                                <label class="input-group-text" for="name1">First Name</label>
                                                                <input class="input-text form-control validate[required]" name="name1" id="name1" type="text" value="">
                                                                <span for="name1" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="surname">Surname</label>
                                                                <input class="input-text form-control " name="surname" id="surname" type="text" value="">
                                                                <span for="surname" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mb20">
                                                            <h6><strong>Contact Information</strong></h6>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="email">Email</label>
                                                                <input class="input-text form-control validate[required,custom[email]]" type="email" name="email" id="Email" value="">
                                                                <span for="email" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="email_1">Email 2</label>
                                                                <input class="input-text form-control" type="email" name="email_1" id="email_1" value="">
                                                                <span for="email_1" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="company">Company</label>
                                                                <input type="text" class="input-text form-control" name="company" id="company" value="">
                                                                <span for="company" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="tel">Tel Number</label>
                                                                <input type="text" class="input-text form-control" name="tel" id="tel" value="">
                                                                <span for="tel" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="tel">Mobile Number</label>
                                                                <input type="text" class="input-text form-control validate[required]" name="cell" id="cell" value="">
                                                                <span for="cell" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="cell2">Mobile Number 2</label>
                                                                <input type="text" class="input-text form-control" name="cell2" id="cell2" value="">
                                                                <span for="cell2" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mb20">
                                                            <h6><strong>Address Information</strong></h6>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="homename">Door Number / House Name</label>
                                                                <input type="text" class="input-text form-control " name="homename" id="homename" value="">
                                                                <span for="homename" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="address">Address</label>
                                                                <input type="text" class="input-text form-control" name="address" id="address" value="">
                                                                <span for="address" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="town">Town/City</label>
                                                                <input type="text" class="input-text form-control" name="town" id="town" value="">
                                                                <span for="town" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="county">County</label>
                                                                <input type="text" class="input-text form-control" name="county" id="county" value="">
                                                                <span for="county" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="postcode">Post Code</label>
                                                                <input type="text" class="input-text form-control " name="postcode" id="postcode" value="">
                                                                <span for="postcode" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group mb-3">

                                                                <label class="input-group-text" for="country">Country</label>
                                                                <input type="text" class="input-text form-control" name="country" id="country" value="United Kingdom">
                                                                <span for="country" class="bferror"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Newest Cars Content Wrapper End -->
                                            </div>
                                            <!-- Newest Cars Tab End -->

                                            <!-- Popular Cars Tab Start -->
                                            <div class="tab-pane fade" id="sign_in_tab_content" role="tabpanel" aria-labelledby="sign-in-tab">

                                                <!-- Popular Cars Content Wrapper Start -->
                                                <div class="login-form">
                                                    <input type="hidden" name="redirect" id="redirect" value="samepage">
                                                    <div class="username">
                                                        <input type="text" class="input-text form-control" name="username" id="username" placeholder="Email or Username">
                                                        <span id="error-username" class="error"></span>
                                                    </div>
                                                    <br>
                                                    <div class="password">
                                                        <input type="password" class="input-text form-control" name="passwrd" id="passwrd" placeholder="Password">
                                                        <span id="error-passwrd" class="error"></span>
                                                    </div>
                                                    <br>
                                                    <div class="log-btn">
                                                        <button type="button" id="login-customer" class="btn btn-success"><i class="fa fa-sign-in"></i> Log In</button>
                                                    </div>
                                                    <!-- <div class="create-ac">
                                                    <a href="#" style="color: orangered" data-target="#pwdModal" data-toggle="modal">Forgot My password?</a>
                                                </div> -->
                                                </div>
                                                <!-- Popular Cars Content Wrapper End -->
                                                <div id="loginerror" style="text-align: center">&nbsp;</div>
                                            </div>
                                            <!-- Popular Cars Tab End -->
                                        </div>
                                        <!-- Choose Area Tab content -->
                                    </div>
                                </div>
                                @endif
                                <!-- contact details end here -->



                                <div id="bookingStep1" class="active" style="display: block;">
                                    <!-- contact details start here -->
                                    <div class="row mt20">
                                        <div class="col-md-12  section-title">
                                            <hr>
               
                                            <h2 class="section-title__title mb-2">PASSENGER INFORMATION</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-2">
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="date1">Number of Passengers</label>
                                                    <select class="form-select validate[required]" name="bk_nop" id="bk_nop">
                                                        <option value="1" {{ $prepared_session_data['bk_nop'] == 1 ? "selected" : "" }}>1 Passenger</option>
                                                        <option value="2" {{ $prepared_session_data['bk_nop'] == 2 ? "selected" : "" }}>2 Passengers</option>
                                                        <option value="3" {{ $prepared_session_data['bk_nop'] == 3 ? "selected" : "" }}>3 Passengers</option>
                                                        <option value="4" {{ $prepared_session_data['bk_nop'] == 4 ? "selected" : "" }}>4 Passengers</option>
                                                        <option value="5" {{ $prepared_session_data['bk_nop'] == 5 ? "selected" : "" }}>5 Passengers</option>
                                                        <option value="6" {{ $prepared_session_data['bk_nop'] == 6 ? "selected" : "" }}>6 Passengers</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mt20">
                                        <div class="col-lg-12 col-md-2">
                                            <div class="form-group">
                                                <label for="Title">Luggage:<small class="req text-lowercase"></small></label>
                                            </div>
                                            <div class="form-group mt20">
                                                <label class="luggage-lable" for="luggagecollection"><input type="radio" class="input-text-luggage" name="luggage" id="luggagecollection" value="Luggage to collect" {{ $prepared_session_data['luggage'] == "Luggage to collect" ? "checked" : "" }}><span>Luggage to collect</span>
                                                </label>
                                                <label class="luggage-lable" for="handcarry"><input type="radio" class="input-text-luggage" name="luggage" id="handcarry" value="Hand carry only" {{ $prepared_session_data['luggage'] == "Hand carry only" ? "checked" : "" }}><span>Hand carry only</span>
                                                </label>
                                                <label class="luggage-lable" for="notsure"><input type="radio" class="input-text-luggage" name="luggage" id="notsure" value="Not sure" {{ $prepared_session_data['luggage'] == "Not sure" ? "checked" : "" }}><span>Not sure</span>
                                                </label>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row mt20">
                                        <div class="col-lg-12 col-md-2">
                                            <div class="form-group">
                                                <label for="Title">Ulze Checked:
                                                    <small class="req text-lowercase"></small>
                                                </label>
                                            </div>
                                            <div class="form-group mt20">
                                                <label class="luggage-lable" for="ulze-no"><input type="radio" class="input-text-luggage" name="ulze" id="ulze-no" value="No" {{ $prepared_session_data['ulze'] == "No" ? "checked" : "" }}><span>No</span>
                                                </label>
                                                <label class="luggage-lable" for="ulze-yes"><input type="radio" class="input-text-luggage" name="ulze" id="ulze-yes" value="Yes" {{ $prepared_session_data['ulze'] == "Yes" ? "checked" : "" }}><span>Yes</span>
                                                </label>
                                                <label class="luggage-lable" for="ulze-notsure"><input type="radio" class="input-text-luggage" name="ulze" id="ulze-notsure" value="Not sure" {{ $prepared_session_data['ulze'] == "Not sure" ? "checked" : "" }}><span>Not sure</span>
                                                </label>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- contact details end here -->



                                    <!-- vehicle details start here -->
                                    <div class="row mt20">
                                        <div class="col-md-12  section-title">
                                            <hr>
                                            <h2 class="section-title__title mb-2">FLIGHT DETAIL</h2>
                                        </div>
                                    </div>
                                    <div id="vehicle">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">

                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="OutboundFlightNumber">Outbound Flight Number</label>
                                                    <input type="text" class="input-text form-control " name="OutboundFlightNumber" id="OutboundFlightNumber" value="{{ $prepared_session_data['bk_ou_fl_nu'] }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">

                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="ReturnFlightNumber">Return Flight Number</label>
                                                    <input type="text" name="ReturnFlightNumber" id="ReturnFlightNumber" class="input-text form-control" value="{{ $prepared_session_data['bk_re_fl_nu'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- vehicle details end here -->

                                    <!-- flight information start here -->
                                    <div class="row mt20">
                                        <div class="col-md-12  section-title">
                                            <hr>
                                            <h2 class="section-title__title mb-2">VEHICLE DETAIL</h2>
                                        </div>
                                    </div>
                                    <?php
                                        $bgcolors = ['color1', 'color2'];
                                        $vehical_count = count($prepared_session_data['vehicles']);
                                        $required_fileds = "";
                                        $required_icon = "";
                                        if ($vehical_count > 1) {
                                            $required_fileds = "validate[required]";
                                            $required_icon = "<span style='color:red'>*</span>";
                                        }
                                        //dd($prepared_session_data);
                                    foreach ($prepared_session_data['vehicles'] as $veh => $veh_data) {?>
                                    <div class="col-md-12 mb20">
                                            <hr>
                                            <h6>VEHICLE ({{ $veh }}) </h6>
                                        </div>
                                    <div class="row {{ $bgcolors[$veh % 2] }}" >
                                        <div class="col-lg-3 sm-12">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text " for="bk_re_nu-{{ $veh }}">Vehicle Reg &nbsp;<strong>({{ $veh }})<span style="color:red">*</span></strong> </label>
                                                <input type="text " name="bk_re_nu[{{ $veh }}]" id="bk_re_nu-{{ $veh }}" class="input-text form-control {{ $required_fileds }}" value="{{ $veh_data['bk_re_nu'] }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 sm-12">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="bk_ve_ma-{{ $veh }}">Vehicle Make &nbsp;<strong>({{ $veh }})</strong></label>
                                                <input type="text" name="bk_ve_ma[{{ $veh }}]" id="bk_ve_ma-{{ $veh }}" class="input-text form-control " value="{{ $veh_data['bk_ve_ma'] }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 sm-12">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="-bk_ve_mo{{ $veh }}">Vehicle Model &nbsp;<strong>({{ $veh }})</strong></label>
                                                <input type="text" name="bk_ve_mo[{{ $veh }}]" id="bk_ve_mo-{{ $veh }}" class="input-text form-control " value="{{ $veh_data['bk_ve_mo'] }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 sm-12">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="bk_ve_co-{{ $veh }}">Vehicle Colour &nbsp;<strong>({{ $veh }})</strong></label>
                                                <select class="form-select " name="bk_ve_co[{{ $veh }}]" id="bk_ve_co-{{ $veh }}">
                                                    <option value=""> Select </option>
                                                    @foreach($colors as $color)
                                                    <option value="{{$color->clr_name}}" {{ $veh_data['bk_ve_co'] == $color->clr_name ? "selected" : "" }}>{{$color->clr_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row {{ $bgcolors[$veh % 2] }}">

                                        <div class="col-lg-4 sm-12">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="v_contact_num-{{ $veh }}">Contact Number &nbsp;<strong>({{ $veh }}){!! $required_icon !!}</strong></label>
                                                <input type="text" name="v_contact_num[{{ $veh }}]" id="v_contact_num-{{ $veh }}" class="input-text form-control {{ $required_fileds }}" value="{{ $veh_data['v_contact_num'] }}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 sm-12">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="date1-{{ $veh }}">
                                                    Drop Off Date/Time &nbsp;<strong>({{ $veh }})<span style="color:red">*</span></strong>
                                                </label>
                                                <input class="form-control validate[required] form_datetime" name="date1[{{ $veh }}]" id="date1-{{ $veh }}" type="text" value="{{ $veh_data['date1'] }}" onchange="VehicleDatesUpdated(this)" data-veh="{{ $veh }}" >
                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 sm-12">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="date2-{{ $veh }}">
                                                    Pick up Date/Time &nbsp;<strong>({{ $veh }})<span style="color:red">*</span></strong>
                                                </label>
                                                <input class="form-control validate[required] form_datetime" name="date2[{{ $veh }}]" id="date2-{{ $veh }}" type="text" value="{{ $veh_data['date2'] }}" onchange="VehicleDatesUpdated(this)" data-veh="{{ $veh }} ">
                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                    <?php }?>
                                    <!-- flight information end here -->


                                    @if($settings['carwash_box'] == 1 && ($prepared_session_data['vehical_num'] == 1))
                                    <div class="row">
                                        <div class="col-md-12  section-title">
                                            <hr>
                                            <h2 class="section-title__title mb-2">Add Car Wash ?</h2>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                                    <div class="input-group mb-3">
                                                    <div class="toggle">
                                                    <input type="radio" name="showhideveh" id="showhideveh" onclick="showveh();" />
                                                    <label for="showhideveh" style="width: 120px; padding: 18px;font-size: 23px; font-weight: 900;">Yes </label>
                                                </div>
                                                    </div>
                                            </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <div class="input-group">
                                                    <input type="radio" id="ww-0"  class="form-controwl validate[required] ccheck" name="vehical_type_id" onclick="getcarwashhtml()" value="0" {{ $prepared_session_data['vehical_type_id'] == 0 ? "" : "" }}>
                                                        <label class="form-label" style="padding: 18px; font-size: 23px; font-weight: 900;" for="ww-0" class="cclabel {{ $prepared_session_data['vehical_type_id'] == 0 ? "active-nn" : "" }} ">
                                                            No Thanks
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="vehicaldiv" style="background:#cccccc2e; display: {{ $prepared_session_data['vehical_type_id'] == '0' ? "none" : "flex"  }}">

                                                @foreach($vehicaltype as $vtype)

                                                <div class="col-lg-4 sm-12">
                                                    <div class="input-group">
                                                        <label class="form-label" for="ww-{{$vtype->id}}" class="cclabel {{ $prepared_session_data['vehical_type_id'] == $vtype->id ? "active-w" : "" }} ">
                                                            <input type="radio" id="ww-{{$vtype->id}}" class="form-controlw validate[required] ccheck" name="vehical_type_id" onclick="getcarwashhtml()" value="{{$vtype->id}}" {{ $prepared_session_data['vehical_type_id'] == $vtype->id ? "checked" : "" }}>
                                                            <img src="/storage/uploads/{{$vtype->v_image}}">
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>

                                            <div class="form-group">
                                                <div class="funkyradio" id="carwash-radio-options">
                                                    @if($prepared_session_data['vehical_type_id'] != 0)
                                                    <div class="funkyradio-success">
                                                        <input type="radio" value="0" id="carwash_in_and_out" onclick="addcarwash();" class="validate[required] radio {{ $prepared_session_data['carwash_in_and_out'] != 0 ? "checked" : "" }}" name="cwash" {{ $prepared_session_data['carwash_in_and_out'] != 0 ? "checked" : "" }}>
                                                        <label class="form-label" for="carwash_in_and_out">FULL CAR WASH (IN AND OUT) ( {{ $settings['currency'] }} {{ $carwash_selected['carwash_in_and_out'] }} )</label>
                                                    </div>

                                                    <div class="funkyradio-success">
                                                        <input type="radio" value="1" id="carwash_out_only" onclick="addcarwash();" class="validate[required] radio {{ $prepared_session_data['carwash_out_only'] != 0 ? "checked" : "" }}" name="cwash" {{ $prepared_session_data['carwash_out_only'] != 0 ? "checked" : "" }}>
                                                        <label class="form-label" for="carwash_out_only">CAR WASH (ONLY OUTSIDE) ( {{ $settings['currency'] }} {{ $carwash_selected['carwash_out_only'] }} )</label>
                                                    </div>
                                                    <div class="funkyradio-success">
                                                        <input type="radio" value="0" id="carwash_in_only" onclick="addcarwash();" class="validate[required] radio {{ $prepared_session_data['carwash_in_only'] != 0 ? "checked" : "" }}" name="cwash" {{ $prepared_session_data['carwash_in_only'] != 0 ? "checked" : "" }}>
                                                        <label class="form-label" for="carwash_in_only">CAR WASH (ONLY INSIDE) ( {{ $settings['currency'] }} {{ $carwash_selected['carwash_in_only'] }} )</label>
                                                    </div>

                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Single FAQ Subject End -->
                    </div>
                    <div class="booking-section travelo-box borderbox">
                    <div class="row">
                            <div class="col-lg-12 section-title">
                                <h2 class="section-title__title mb-2">Terminal Access Fee £<span id="tef"></span></h2>
                                    <select id="terminal_parking_fee" name="terminal_parking_fee" class="form-select " onchange="GetTef();">
                                            @foreach($terminal_access_options as $key=>$tso)
                                                <?php
                                                if ($key == "P") {
                                                    $span = "style=color:red";
                                                } else {
                                                    $span = "";
                                                }
                                                ?>
                                                <option {{ $span}} value="{{$key}}">{{$tso}}</option>
                                            @endforeach
                                        </select>
                            </div>
                    </div>
                    </div>


                    <?php
                    $hide_eden_promo_box = 1;
                    $hide_eden_promo_box = $settings['eden_promo_box'];
                    ?>
                    @if(!$hide_eden_promo_box)
                    <hr>
                    <div class="booking-section travelo-box borderbox">
                        <div class="row">
                            <div class="col-lg-12 section-title">
                                <h2 class="section-title__title mb-2">PromoCode</h2>
                                <div class="sidebar-body">
                                    <p><small>Do you have a promotion code? Enter it here.</small></p>
                                    <!-- <form onsubmit="javascript:applypromotion();return false;"> -->
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="date1">Promo Code</label>
                                        <input type="text" class="input-text form-control" size="20" name="promotion_code" id="promotion_code" onkeyup="javascript:checkverify();" value="">
                                         <input class="btn-success btn-small btn" type="button" value="VERIFY" name="verify" id="verify" onclick="applypromotion();" disabled="disabled">
                                    </div>
                                    <!-- </form> -->
                                    <div id="apc"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <hr>
                    @endif
                    <div class="booking-section travelo-box borderbox">
                        <div class="row">
                            <div class="col-md-12  section-title">
                                <h2 class="section-title__title mb-2">Payment Method</h2>
                            </div>
                            <div class="col-sm-12 col-md-12">

                                <div class="frb-group">

                                    <div class="frb frb-success" style="position:relative">
                                        <input type="radio" id="radio-button-2" name="payment_option" value="2" class="validate[required] radio">
                                        <label for="radio-button-2" onclick="hidebothpands();">
                                            <span class="frb-title">Pay by PayPal </span>
                                            <span class="frb-description">&nbsp;</span>
                                        </label>
                                    </div>

                                    <div class="frb frb-success" style="position:relative; display:none;">
                                        <input type="radio" id="radio-button-3" name="payment_option" value="1" class="validate[required] radio">
                                        <label for="radio-button-3" onclick="showspaylater();">
                                            <span class="frb-title">Pay Later</span>
                                            <span class="frb-description" style="font-size: 16px;"> ACCOUNT HOLDER COMPANIES ONLY</span>
                                        </label>
                                        <div id="paylaterdiv" style="display:none;">

                                        <div class="row">
                                            <div class="col-lg-12 form-group">
                                                <label>Account Number</label>
                                                <input autocomplete="off" class="input-text form-control validate[required]" size="20" type="text" id="account_num" value="" name="account_num">
                                                <div class="alert alert-danger" style="display:none" id="paylaterexceptionmsg"></div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>


                                    <div class="frb frb-success" style="position:relative">
                                        <input type="radio" id="radio-button-5" name="payment_option" value="5" class="validate[required] radio">
                                        <label for="radio-button-5" onclick="showstripe();">
                                            <span class="frb-title">Pay by Strpie </span>
                                            <span class="frb-description">&nbsp;</span>
                                        </label>
                                        <div id="stripediv" style="display:none;">

                                            <div class="row">
                                                <div class="col-lg-12 form-group">
                                                    <label>Number of Card</label>
                                                    <input autocomplete="off" class="input-text form-control validate[required] card-number" size="20" type="text" id="card_no" name="card_no">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 form-group">
                                                    <label>CVC</label>
                                                    <input autocomplete="off" class="input-text form-control validate[required] card-cvc" placeholder="ex. 311" size="3" type="text" id="cvv" name="cvv">
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label>Expiration month</label>
                                                    <input class="input-text form-control validate[required] card-expiry-month" placeholder="MM" size="2" type="text" id="expiry_month" name="expiry_month">
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label>Expiration year</label>
                                                    <input class="input-text form-control validate[required] card-expiry-year" placeholder="YYYY" size="4" type="text" id="expiry_year" name="expiry_year">
                                                    <input type="hidden" name="stripeToken" id="stripeToken" value="">
                                                    <input type="hidden" name="usestripe" id="usestripe" value="0">
                                                </div>
                                            </div>
                                            <div class="alert alert-danger" style="display:none" id="cardexceptionmsg">

                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-12 mt20 mb20">
                                <div class="input-submit" style="text-align: center">
                                    <div id="mini-cart" class="price">{!! $mini_cart !!}</div>
                                    <button type="submit" class="btn  btn btn-success btn-xs btn-block " name="continue" id="continue">
                                        Confirm and Checkout now
                                    </button>
                                </div>
                                <div class="alert final-notice mt20 " id="final-notice" style="display:none;"></div>
                                <!-- {!! $html !!} -->
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </div>

                </form>

            </div>
            <div class="col-lg-4" id="mcart">

                <div class="sidebar-content-wrap m-t-50">
                    <!-- Single Sidebar Start -->
                    <div class="single-sidebar" style="background: #fff; padding: 20px;">
                        <h3 style="font-weight: 800; text-align:center;">Your Booking Summary</h3>
                        <div class="sidebar-body">
                            <figure class="clearfix">
                                <div class="card" style="text-align:center;">
                                    <img style="margin: 0 auto;" class="middle-item" src="/storage/uploads/{{$comparison_website->website_logo}}" alt="{{$comparison_website->website_name}}">
                                </div>
                                <div class="card">
                                    <p class="box-title">{{$comparison_website->website_name}}</p>
                                    <div id="cart-content">
                                    {!! $cart !!}
                                    </div>
                                </div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>
</div>
<script>

    function VehicleDatesUpdated(input) {
        // Get the vehicle index from the data attribute
        const veh = input.getAttribute('data-veh');
        // Get the input name (date1 or date2)
        const name = input.getAttribute('name').split('[')[0];
        // Get the new value
        const value = input.value;

        // Make an AJAX call to update the session
        fetch('/update-vehicle-date', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for Laravel
            },
            body: JSON.stringify({
                veh: veh,
                name: name,
                value: value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Date updated successfully');
                window.location.reload();
            } else {
                window.location.reload();
                console.error('Failed to update date');
            }
        })
        .catch(error => console.error('Error:', error));

    }

   function showstripe(){
    document.getElementById("usestripe").value = 1;
    var x = document.getElementById("stripediv");
    if (x.style.display === "none") {
        x.style.display = "block";
    }
    hidepaylater();
}
function hidestripe(){
    document.getElementById("usestripe").value = 0;
    var x = document.getElementById("stripediv");
    if (x.style.display === "block") {
        x.style.display = "none";
    }
    //document.getElementById("stripediv").style.display = 'hide';
}
function showspaylater(){
    document.getElementById("usestripe").value = 0;
    var x = document.getElementById("paylaterdiv");
    if (x.style.display === "none") {
        x.style.display = "block";
    }
    hidestripe()
}
function hidepaylater(){
    console.log("hide");
    var x = document.getElementById("paylaterdiv");
    if (x.style.display === "block") {
        x.style.display = "none";
    }
}
function hidebothpands(){
    hidepaylater();
    hidestripe();
}
</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!--== FAQ Area End ==-->


@endsection