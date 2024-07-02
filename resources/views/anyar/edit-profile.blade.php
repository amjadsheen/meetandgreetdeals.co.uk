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
        /*border: 2px solid red;*/
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
    li.nav-item{
        margin: 0 10px;
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
                            <a class="nav-link " href="/profile">PROFILE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/my-bookings">MY BOOKINGS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/edit-profile">EDIT PROFILE</a>
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

                <form method="post" action="#" id="update_user_profile">
                    <input type="hidden" name="redirect" id="redirect" value="{{$redirect}}">
                    <div class="login-form" style="background-color: #fff;">
                        <div class="row">
                            <div class="col-md-12 mb20">
                                <button  class="btn btn-block btn-success" id="update-customer" type="submit"><i class="fa fa-sign-in"></i> Update Profile</button>
                                <hr>
                            </div>
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
                                        <option {{($customer->cus_title == "Mr.") ? 'selected':'' }} value="Mr.">Mr.</option>
                                        <option {{($customer->cus_title == "Mrs.") ? 'selected':'' }} value="Mrs.">Mrs.</option>
                                        <option {{($customer->cus_title == "Miss.") ? 'selected':'' }} value="Miss.">Miss.</option>
                                        <option {{($customer->cus_title == "Dr.") ? 'selected':'' }} value="Dr.">Dr.</option>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>First Name
                                        <small class="req text-lowercase"></small>
                                    </label>
                                    <input class="input-text form-control validate[required]" name="name1"  id="name1" type="text" value="{{$customer->cus_name}}">
                                    <span for="name1" class="bferror"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Surname:
                                        <small class="req text-lowercase"></small>
                                    </label>
                                    <input class="input-text form-control validate[required]" name="surname" id="surname" type="text" value="{{$customer->cus_surname}}">
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
                                    <input class="input-text form-control validate[required,custom[email]]"   type="email" name="email" id="Email" value="{{$customer->cus_email}}">
                                    <span for="email" class="bferror"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Email 2
                                        <small class="req text-lowercase"></small>
                                    </label>
                                    <input class="input-text form-control" type="email" name="email_1" id="email_1"   value="{{$customer->cus_email_1}}" >
                                    <span for="email_1" class="bferror"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Company
                                        <small class="req text-lowercase"></small>
                                    </label>
                                    <input type="text" class="input-text form-control" name="company" id="company"   value="{{$customer->cus_company}}" >
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
                                    <input type="text" class="input-text form-control" name="tel" id="tel"  value="{{$customer->cus_tel}}" >
                                    <span for="tel" class="bferror"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Mobile Number:
                                        <small class="req text-lowercase"></small>
                                    </label>
                                    <input type="text" class="input-text form-control validate[required]" name="cell" id="cell"   value="{{$customer->cus_cell}}" >
                                    <span for="cell" class="bferror"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Mobile Number 2:
                                        <small class="req text-lowercase"></small>
                                    </label>
                                    <input type="text" class="input-text form-control" name="cell2" id="cell2" value="{{$customer->cus_cell2}}" >
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
                                    <input type="text" class="input-text form-control validate[required]" name="homename" id="homename"   value="{{$customer->cus_homename}}" >
                                    <span for="homename" class="bferror"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Address:
                                        <small class="req text-lowercase"></small>
                                    </label>
                                    <input type="text" class="input-text form-control" name="address" id="address"   value="{{$customer->cus_address}}" >
                                    <span for="address" class="bferror"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Town/City:
                                        <small class="req text-lowercase"></small>
                                    </label>
                                    <input type="text" class="input-text form-control" name="town" id="town"   value="{{$customer->cus_town}}" >
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
                                    <input type="text" class="input-text form-control" name="county" id="county"   value="{{$customer->cus_county}}" >
                                    <span for="county" class="bferror"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Post Code:
                                        <small class="req text-lowercase"></small>
                                    </label>
                                    <input type="text" class="input-text form-control validate[required]" name="postcode" id="postcode"   value="{{$customer->cus_postcode}}" >
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


                        </div>
                    </div>
                </form>

                <!-- Car List Content End -->


            </div>
        </div>
</section>
@endsection
