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
    .login-form hr {
        margin-top: 20px;
        margin-bottom: 20px;
        /* border: 2px solid #f0edef; */
        border: 2px solid red;
    }
     button {
        background-color: transparent;
        border: 1px solid #555;
        color: #000;
        margin: 10px 0;
        padding: 10px 20px;
        -webkit-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
        width: 100%;
         cursor: pointer;
    }
    .error {
        order: 3;
        width: 100%;
        color: red;
        padding: 1vh 0 0 0;
        margin: 0;
    }
    button:hover {
        background-color: #222;
        border-color: #222;
        color: #fff;
    }
    .formError .formErrorContent {
        min-width: 175px;
        font-size: 10px;
    }
</style>
<div id="lgoin-page-wrap" class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>SignUp</h2>
                    <span class="title-line"><i class="fa fa-user"></i></span>
                </div>
            </div>
            <!-- Section Title End -->
        </div>
        <div class="row">

            <div class="col-lg-12 col-md-12 m-auto">

                <form method="post" action="#" id="register-customer">
                        <div class="login-form" style="background-color: #fff;">
                            <div class="row">
                                <div class="col-md-12 mb20">
                                    <h6>Personal information</h6>
                                    <hr>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="Title">Title
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <select class="form-control validate[required]" name="title" id="title" >
                                            <option value="">--- Select one ---</option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Miss.">Miss.</option>
                                            <option value="Dr.">Dr.</option>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>First Name
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input class="input-text form-control validate[required]" name="name1"  id="name1" type="text" value="">
                                        <span for="name1" class="bferror"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Surname:
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input class="input-text form-control validate[required]" name="surname" id="surname" type="text" value="">
                                        <span for="surname" class="bferror"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb20">
                                    <h6>Contact Information</h6>
                                    <hr>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Email
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input class="input-text form-control validate[required,custom[email]]"   type="email" name="email" id="Email" value="">
                                        <span for="email" class="bferror"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Email 2
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input class="input-text form-control" type="email" name="email_1" id="email_1"   value="" >
                                        <span for="email_1" class="bferror"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Company
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input type="text" class="input-text form-control" name="company" id="company"   value="" >
                                        <span for="company" class="bferror"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Tel Number:
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input type="text" class="input-text form-control" name="tel" id="tel"  value="" >
                                        <span for="tel" class="bferror"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number:
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input type="text" class="input-text form-control validate[required]" name="cell" id="cell"   value="" >
                                        <span for="cell" class="bferror"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number 2:
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input type="text" class="input-text form-control" name="cell2" id="cell2" value="" >
                                        <span for="cell2" class="bferror"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb20">
                                    <h6>Address Information</h6>
                                    <hr>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Door Number / House Name:
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input type="text" class="input-text form-control validate[required]" name="homename" id="homename"   value="" >
                                        <span for="homename" class="bferror"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Address:
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input type="text" class="input-text form-control" name="address" id="address"   value="" >
                                        <span for="address" class="bferror"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Town/City:
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input type="text" class="input-text form-control" name="town" id="town"   value="" >
                                        <span for="town" class="bferror"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>County:
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input type="text" class="input-text form-control" name="county" id="county"   value="" >
                                        <span for="county" class="bferror"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Post Code:
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input type="text" class="input-text form-control validate[required]" name="postcode" id="postcode"   value="" >
                                        <span for="postcode" class="bferror"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Country:
                                            <small class="req text-lowercase"></small>
                                        </label>
                                        <input type="text" class="input-text form-control" name="country" id="country"   value="United Kingdom" >
                                        <span for="country" class="bferror"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <button  class="btn btn-block btn-success" id="register-customer" type="submit"><i class="fa fa-sign-in"></i> Sign-Up</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                </form>
                        <!-- Newest Cars Content Wrapper End -->

            </div>



        </div>
    </div>
</div>
@endsection
