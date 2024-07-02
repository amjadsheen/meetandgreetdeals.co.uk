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
    hr {
        margin-top: 20px;
        margin-bottom: 20px;
        /* border: 2px solid #f0edef; */
        border: 2px solid red;
    }
    li.nav-item{
        margin: 0 10px;
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
    .widget-body a {
        color: red;
    }
</style>
<section id="car-list-area" class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Car List Content Start -->
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-sm bg-dark navbar-dark ">

                    <!-- Links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="/profile">PROFILE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/my-bookings">MY BOOKINGS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/edit-profile">EDIT PROFILE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/customer-logout">LOGOUT</a>
                        </li>
                    </ul>

                </nav>
            </div>
        </div>

        <div class="row section-padding">
            <!-- Car List Content Start -->
            <div class="col-lg-12">

                <div class="pricing-details-content">
                    <div class="row">
                        <!-- Single Pricing Table -->
                        <div class="col-lg-4 col-md-6 text-center">
                            <div class="single-pricing-table">
                                <h3>Personal information</h3>
                                <ul class="package-list">
                                    <li>Title: {{$customer->cus_title}}</li>
                                    <li>First Name: {{$customer->cus_name}}</li>
                                    <li>Surname: {{$customer->cus_surname}}</li>
                                </ul>
                            </div>
                        </div>
                        <!-- Single Pricing Table -->

                        <!-- Single Pricing Table -->
                        <div class="col-lg-4 col-md-6 text-center">
                            <div class="single-pricing-table">
                                <h3>Contact Information</h3>
                                <ul class="package-list">
                                    <li>Email: {{$customer->cus_email}}</li>
                                    <li>Email 2: {{$customer->cus_email_1}}</li>
                                    <li>Company: {{$customer->cus_company}}</li>
                                    <li>Tel Number: {{$customer->cus_tel}}</li>
                                    <li>Mobile Number: {{$customer->cus_cell}}</li>
                                    <li>Mobile Number 2: {{$customer->cus_cell2}}</li>
                                </ul>
                            </div>
                        </div>
                        <!-- Single Pricing Table -->

                        <!-- Single Pricing Table -->
                        <div class="col-lg-4 col-md-6 text-center">
                            <div class="single-pricing-table">
                                <h3>Address Information</h3>
                                <ul class="package-list">
                                    <li>Door Number / House Name: {{$customer->cus_homename}}</li>
                                    <li>Address: {{$customer->cus_address}}</li>
                                    <li>Town/City: {{$customer->cus_town}}</li>
                                    <li>County: {{$customer->cus_county}}</li>
                                    <li>Post Code: {{$customer->cus_postcode}}</li>
                                    <li>Country: {{$customer->cus_country}}</li>
                                </ul>
                            </div>
                        </div>
                        <!-- Single Pricing Table -->
                    </div>
                </div>

                <!-- Car List Content End -->


            </div>
        </div>
</section>

@endsection
