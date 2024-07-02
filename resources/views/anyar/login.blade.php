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

<section id="page-title-area" class="section-padding overlay">
    <div class="container">
    </div>
</section>
<style>
    .login-form input, .login-form button {
        background-color: transparent;
        border: 1px solid #555;
        color: #000;
        margin: 10px 0;
        padding: 10px 20px;
        -webkit-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
        width: 100%;
    }
    .error {
        order: 3;
        width: 100%;
        color: red;
        padding: 1vh 0 0 0;
        margin: 0;
    }
    .log-btn button:hover {
        background-color: #222;
        border-color: #222;
        color: #fff;
    }
</style>
<div id="lgoin-page-wrap" class="section-padding">
    <div class="container">
        <div class="row">
        <!-- Section Title Start -->
        <div class="col-lg-12">
            <div class="section-title  text-center">
                <h2>WELCOME BACK!</h2>
                <span class="title-line"><i class="fa fa-user"></i></span>
            </div>
        </div>
        <!-- Section Title End -->
    </div>
        <div class="row">

            <div class="col-lg-4 col-md-8 m-auto">
                <div class="login-page-content">
                    <div class="login-form" style="background-color: #fff;">
                            <div class="username">
                                <input type="hidden" name="redirect" id="redirect" value="profile">
                                <input type="text"  name="username" id="username"  placeholder="Email or Username">
                                <span id="error-username" class="error"></span>
                            </div>
                            <div class="password">
                                <input type="password" name="passwrd" id="passwrd" placeholder="Password">
                                <span id="error-passwrd" class="error"></span>
                            </div>
                            <div class="log-btn">
                                <button   id="login-customer" type="submit"><i class="fa fa-sign-in"></i> Log In</button>
                            </div>
                        <div id="loginerror" style="text-align: center">&nbsp;</div>
                        <div class="create-ac">
                            <a href="#" style="color: orangered" data-target="#pwdModal" data-toggle="modal">Forgot My password?</a>
                        </div>
                    </div>
                    <div class="create-ac">
                        <p>Don't have an account? <a href="/sign-up">Sign Up</a></p>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
