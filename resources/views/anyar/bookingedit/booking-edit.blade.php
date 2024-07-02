@extends('frontend.layouts.app')
@section('content')
@section('sitefavicon')
    <link rel="shortcut icon" href="/storage/uploads/{{$domain->website_favicon}}" type="image/x-icon"/>
@stop
@section('title', $domain->website_name .' | booking edit')
@section('logoheader')
    <a href="/" class="logo">
        <img src="/storage/uploads/{{$domain->website_logo}}" alt="{{$domain->website_name}}">
    </a>
@stop
@section('top-header')
    <!--== Single HeaderTop Start ==-->
    @if (trim($domain->address) !== '')
        <div class="col-lg-3 text-left">
            {{--<i class="fa fa-map-marker"></i>{{trim($domain->address)}}--}}
        </div>
    @endif

    @if (trim($domain->contact_num)  !== '' || trim($domain->alternate_contact_num)  !== '' )
        <div class="col-lg-4 text-center">
            @if (trim($domain->contact_num) !== '')
                <i class="fa fa-mobile"></i> <a href="tel:{{$domain->contact_num}}">{{$domain->contact_num}}</a>  | <a href="tel:{{$domain->alternate_contact_num}}">{{$domain->alternate_contact_num}}</a>
            @endif
        </div>
    @endif

    @if (trim($domain->working_time)  !== '')
        <div class="col-lg-3 text-center">
            <i class="fa fa-clock-o"></i> {{$domain->working_time}}
        </div>
    @endif

    @if (trim($domain->facebook)  !== '' || trim($domain->twitter)  !== '' )
        <div class="col-lg-2 text-right">
            <div class="header-social-icons">
                @if (trim($domain->facebook)  !== '')
                    <a href="{{$domain->facebook}}"><i class="fa fa-facebook"></i></a>
                @endif
                @if (trim($domain->twitter)  !== '')
                    <a href="{{$domain->twitter}}"><i class="fa fa-twitter"></i></a>
                @endif

            </div>
        </div>
    @endif
    <!--== Single HeaderTop End ==-->
@stop
@section('meta')
    <meta name="title" content="booking-confirm">
    <meta name="description" content="booking-confirm">
    <meta name="keywords" content="booking-confirm">
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="booking-confirm"/>
    <meta property="og:description" content="booking-confirm"/>
    <meta property="og:url" content="{{$domain->website_url .'/booking-confirm'}}"/>
    <meta property="og:image" content="/storage/uploads/{{$domain->website_logo}}"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:description" content="booking-confirm"/>
    <meta name="twitter:title" content="booking-confirm"/>
    <meta name="twitter:image" content="/storage/uploads/{{$domain->website_logo}}"/>
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
    label {
        font-weight: bold;
    }
    .maindiv {
        padding-bottom: 18px;
    }
    .datetime{
        background-color: #fafafa;
        border: 1px solid #eaeaea;
        color: #000;
        padding: 7px 15px;
        resize: none;
        width: 100%;
        border-radius: 3px;
    }
    #faq-page-area input, #faq-page-area select {
        border: 1px solid #a7b1a878;
        /* width: 100%; */
        background-color: #a7a6a63d;
    }
    #faq-page-area hr {
        margin-top: 20px;
        margin-bottom: 20px;
        /*border: 2px solid #f0edef;*/
        border: 2px solid red;
    }

    .mt20 {
        margin-top: 20px;
    }

    .mb20 {
        margin-bottom: 20px;
    }

    #scroll p, #scrollpp p{
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
        font-size: 1.2em;
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

    .frb ~ .frb {
        margin-top: 15px;
    }

    .frb input[type="radio"]:empty,
    .frb input[type="checkbox"]:empty {
        /*display: none;*/
        visibility: hidden;
        position: absolute;
        top: 35px;
    }

    .frb input[type="radio"] ~ label:before,
    .frb input[type="checkbox"] ~ label:before {
        font-family: FontAwesome;
        content: '\f096';
        position: absolute;
        top: 36%;
        margin-top: -11px;
        left: 15px;
        font-size: 22px;
    }

    .frb input[type="radio"]:checked ~ label:before,
    .frb input[type="checkbox"]:checked ~ label:before {
        content: '\f046';
    }

    .frb input[type="radio"] ~ label,
    .frb input[type="checkbox"] ~ label {
        position: relative;
        cursor: pointer;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f2f2f2;
    }

    .frb input[type="radio"] ~ label:focus,
    .frb input[type="radio"] ~ label:hover,
    .frb input[type="checkbox"] ~ label:focus,
    .frb input[type="checkbox"] ~ label:hover {
        box-shadow: 0px 0px 3px #333;
    }

    .frb input[type="radio"]:checked ~ label,
    .frb input[type="checkbox"]:checked ~ label {
        color: #fafafa;
    }

    .frb input[type="radio"]:checked ~ label,
    .frb input[type="checkbox"]:checked ~ label {
        background-color: #f2f2f2;
    }

    .frb.frb-default input[type="radio"]:checked ~ label,
    .frb.frb-default input[type="checkbox"]:checked ~ label {
        color: #333;
    }

    .frb.frb-primary input[type="radio"]:checked ~ label,
    .frb.frb-primary input[type="checkbox"]:checked ~ label {
        background-color: #337ab7;
    }

    .frb.frb-success input[type="radio"]:checked ~ label,
    .frb.frb-success input[type="checkbox"]:checked ~ label {
        background-color: #5cb85c;
    }

    .frb.frb-info input[type="radio"]:checked ~ label,
    .frb.frb-info input[type="checkbox"]:checked ~ label {
        background-color: #5bc0de;
    }

    .frb.frb-warning input[type="radio"]:checked ~ label,
    .frb.frb-warning input[type="checkbox"]:checked ~ label {
        background-color: #f0ad4e;
    }

    .frb.frb-danger input[type="radio"]:checked ~ label,
    .frb.frb-danger input[type="checkbox"]:checked ~ label {
        background-color: #d9534f;
    }

    .frb input[type="radio"]:empty ~ label span,
    .frb input[type="checkbox"]:empty ~ label span {
        display: inline-block;
    }

    .frb input[type="radio"]:empty ~ label span.frb-title,
    .frb input[type="checkbox"]:empty ~ label span.frb-title {
        font-size: 16px;
        font-weight: 700;
        margin: 5px 5px 5px 50px;
    }

    .frb input[type="radio"]:empty ~ label span.frb-description,
    .frb input[type="checkbox"]:empty ~ label span.frb-description {
        font-weight: normal;
        font-style: italic;
        color: #999;
        margin: 5px 5px 5px 50px;
    }

    .frb input[type="radio"]:empty:checked ~ label span.frb-description,
    .frb input[type="checkbox"]:empty:checked ~ label span.frb-description {
        color: #fafafa;
    }

    .frb.frb-default input[type="radio"]:empty:checked ~ label span.frb-description,
    .frb.frb-default input[type="checkbox"]:empty:checked ~ label span.frb-description {
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

    #continue {
        cursor: pointer;
    }

    .login-form {
        background-color: red4f;
        padding: 50px 20px 15px;
    }

    .formError .formErrorContent {
        min-width: 175px;
        font-size: 10px;
    }

    .blackPopup .formErrorContent {
        background: #ee0101;
    }

    #verify{
        cursor: pointer;
    }
    .single-sidebar h3 {
        background-color: #2d2d2da3 !important;
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

    .funkyradio input[type="radio"]:empty ~ label,
    .funkyradio input[type="checkbox"]:empty ~ label {
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

    .funkyradio input[type="radio"]:empty ~ label:before,
    .funkyradio input[type="checkbox"]:empty ~ label:before {
        position: absolute;
        display: block;
        top: 0;
        bottom: 0;
        left: 0;
        content: '';
        width: 2.5em;
        background: #D1D3D4;
        border-radius: 3px 0 0 3px;
    }

    .funkyradio input[type="radio"]:hover:not(:checked) ~ label,
    .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
        color: #888;
    }

    .funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
    .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
        content: '\2714';
        text-indent: .9em;
        color: #C2C2C2;
    }

    .funkyradio input[type="radio"]:checked ~ label,
    .funkyradio input[type="checkbox"]:checked ~ label {
        color: #777;
    }

    .funkyradio input[type="radio"]:checked ~ label:before,
    .funkyradio input[type="checkbox"]:checked ~ label:before {
        content: '\2714';
        text-indent: .9em;
        color: #333;
        background-color: #ccc;
    }

    .funkyradio input[type="radio"]:focus ~ label:before,
    .funkyradio input[type="checkbox"]:focus ~ label:before {
        box-shadow: 0 0 0 3px #999;
    }

    .funkyradio-default input[type="radio"]:checked ~ label:before,
    .funkyradio-default input[type="checkbox"]:checked ~ label:before {
        color: #333;
        background-color: #ccc;
    }

    .funkyradio-primary input[type="radio"]:checked ~ label:before,
    .funkyradio-primary input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #337ab7;
    }

    .funkyradio-success input[type="radio"]:checked ~ label:before,
    .funkyradio-success input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #5cb85c;
    }

    .funkyradio-danger input[type="radio"]:checked ~ label:before,
    .funkyradio-danger input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #d9534f;
    }

    .funkyradio-warning input[type="radio"]:checked ~ label:before,
    .funkyradio-warning input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #f0ad4e;
    }

    .funkyradio-info input[type="radio"]:checked ~ label:before,
    .funkyradio-info input[type="checkbox"]:checked ~ label:before {
        color: #fff;
        background-color: #5bc0de;
    }
    #final-notice {
        background-image: url("{{ asset('cardo/assets/img/loader-am.gif')}}");
        background-repeat: no-repeat;
        background-position: 50%;
        background-size: 150px;
    }
</style>
<!--== FAQ Area Start ==-->
<section id="faq-page-area" class="section-padding">
    <div class="container">
        <div class="row mb20 pb-5" >
            <!-- Car List Content Start -->
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-sm bg-dark navbar-dark ">

                    <!-- Links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link " href="/profile">PROFILE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/my-bookings">MY BOOKINGS</a>
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
        <form method="post" action="{{ route('bookingedit.update', $bk_details->booking_id) }}" id="update_booking_1">
            @csrf
            {{ method_field('PUT')}}
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sidebar-content-wrap">
                        <!-- Single Sidebar Start -->
                        <div class="single-sidebar" style="background: #fff;">
                            <h3> EDIT BOOKING {{ $bk_details->bk_ref }} </h3>
                            <div class="sidebar-body">
                    <!----------------------- EDIT BOOKING ----------------->

                        <div class="form-row">

                            <div class="col-lg-3 sm-12">
                                <label for="country">Select Country</label>
                                <select id="country" name="country" class="custom-select custom-select-lg mb-3 datetime" onchange="getairports()">
                                    <option value="0">---Select an Country---</option>
                                    @if(!$countries->isEmpty())
                                        @foreach($countries as $country)
                                            @if($country->disable == 1)
                                                <option value="{{$country->id}}" disabled="disabled">{{$country->name}} (booking closed) </option>
                                            @else
                                                <option {{($bk_details->country_id == $country->id) ? 'selected':'' }} value="{{$country->id}}">{{$country->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-3 sm-12">
                                <label for="validationDefault01">Select an airport</label>
                                <select id="airport1" name="airport1" class="custom-select custom-select-lg mb-3 datetime" onchange="getTerminals()">
                                    <option value="0">---Select an airport---</option>
                                    @foreach($selected_airport as $s_airport)
                                        @if($s_airport->airport_disable == 1)
                                            <option value="{{$s_airport->id}}" disabled="disabled">{{$s_airport->airport_name}} (booking closed) </option>
                                        @else
                                            <option {{($bk_details->airport_id == $s_airport->id) ? 'selected':'' }} value="{{$s_airport->id}}">{{$s_airport->airport_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 sm-12">
                                <label for="validationDefault02">Select Departure Terminal:</label>
                                <select id="terminal" name="terminal" class="custom-select custom-select-lg mb-3 datetime" onchange="getDiscountCouponVip();">
                                    <option value="0">---select departure terminal---</option>
                                    @foreach($selected_terminals as $selected_terminal)
                                        @if($selected_terminal->ter_disable == 1)
                                            <option value="{{$selected_terminal->id}}" disabled="disabled">{{$selected_terminal->ter_name}} (booking closed) </option>
                                        @else
                                            <option {{($bk_details->bk_ou_te == $selected_terminal->id) ? 'selected':'' }} value="{{$selected_terminal->id}}">{{$selected_terminal->ter_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div id="terpro"></div>
                            </div>
                            <div class="col-lg-3 sm-12">
                                <label for="validationDefault02">Select Return Terminal:</label>
                                <select id="return_terminal" name="return_terminal" class="custom-select custom-select-lg mb-3 datetime" onchange="calculatePrice();">
                                    <option value="0">---select return terminal---</option>
                                    <option value="0">---select departure terminal---</option>
                                    @foreach($selected_terminals as $selected_terminal)
                                        @if($selected_terminal->ter_disable == 1)
                                            <option value="{{$selected_terminal->id}}" disabled="disabled">{{$selected_terminal->ter_name}} (booking closed) </option>
                                        @else
                                            <option {{($bk_details->bk_re_te == $selected_terminal->id) ? 'selected':'' }} value="{{$selected_terminal->id}}">{{$selected_terminal->ter_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-3 sm-12 ">
                                <label for="validationDefault02">Service</label>
                                <select id="service" name="service" class="custom-select custom-select-lg mb-3 datetime" onchange="calculatePrice();">
                                    <option value="0">---Select Service---</option>
                                    @foreach($services as $service)
                                        <option {{($bk_details->service_id == $service->id) ? 'selected':'' }} value="{{$service->id}}">{{$service->service_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 sm-12">
                                <label for="validationDefaultUsername">Vehicle drop off time</label>
                                <div class="input-group">

                                    <div class="input-append date form_datetime" >
                                        <input class="datetime validate[required]" name="date1" id="date1" type="text" placeholder="Vehicle drop off time" value="{{$bk_details->bk_from_date}}" onchange="calculatePrice()" readonly>
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 sm-12">
                                <label for="validationDefaultUsername">Arrival date/time</label>
                                <div class="input-group">

                                    <div class="input-append date form_datetime" >
                                        <input class="datetime validate[required]"  name="date2" id="date2" type="text"  placeholder="Arrival date/time" onchange="calculatePrice()" value="{{$bk_details->bk_to_date}}" readonly>
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-2 sm-12">
                                <label for="terminal_parking_fee">Terminal Access Fee £</label>
                                <select id="terminal_parking_fee" name="terminal_parking_fee" class="custom-select custom-select-lg mb-3 datetime" onchange="calculatePrice();" disabled> -->
                                    <!--<option value="none">--- Please Select ---</option>-->
                                    <!-- @foreach($terminal_access_options as $key=>$tso)
                                       <option {{($bk_details->terminal_parking_fee ==  $key) ? 'selected':'' }}  value="{{$key}}">{{$tso}}</option>
                                    @endforeach -->
                                <!-- </select>
                            </div> -->
                            <!--<div class="col-lg-5 sm-12">
                                <div class="custom-control custom-radio custom-control-inlineo">
                                    <input style="margin: 6px;" type="radio" name="vip" id="vip1" value="0" {{($bk_details->bk_vip == 0) ? 'checked':'' }}  onchange="getDiscountCouponVip()">
                                    <label style="cursor: pointer;" for="vip1" class="custom-control-label" >Regular Booking</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input style="margin: 6px;" type="radio" name="vip" id="vip2" value="1"  {{($bk_details->bk_vip == 1) ? 'checked':'' }} onchange="getDiscountCouponVip()">
                                    <label style="cursor: pointer;" for="vip2" class="custom-control-label" >VIP / Business Booking</label>
                                </div>
                            </div>-->
                            <input  id="bookingeditpage"   type="hidden" value="{{$bk_details->id}}">
                            <input  id="bkcurrency"   type="hidden" value="{{$settings['currency']}}">
                        </div>

                        <div class="form-row">
                            <div class="col-lg-6 sm-12 " style="{{ $settings['eden_discount_box'] == 1 ? "display:none" : "" }}" >
                                <label for="validationDefaultUsername">{{ $bk_detail->website_name}} auto discount:	</label>
                                <input style="border: transparent; background-color: #fff;" class="datetime" id="discount_coupon"   name="discount_coupon"   type="text" value="" readonly>
                                <span id="discount_value"></span>
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="col-lg-3 sm-12">
                                <select style="" name="currency1" id="currency1"  onchange="calculatePrice();" class="custom-select custom-select-lg mb-3">
                                    {{--                                        <option value="1">Pay in British Pound £ </option>--}}
                                    @foreach($currencies as $currency)
                                        <option {{($bk_details->currency_id == $currency->id) ? 'selected':'' }} value="{{$currency->id}}">Pay in {{$currency->cur_name}} {{$currency->cur_symbol}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-lg-5 sm-12">
                                <div id="displayprice" style=""><span style='color:green;'>
                                        <strong>
                                            <?php $carwash = $bk_details->carwash_in_and_out + $bk_details->carwash_out_only + $bk_details->carwash_in_only; ?>
                                            <?php echo $bk_details->cur_symbol . " " . number_format($bk_details->bk_total_amount - $bk_details->bk_discount_offer_amount + $carwash, 2, '.', ''); ?>
                                        </strong></span></div>
                                <div id="submit-errors" style=" font-size: 21px; color: red;"></div>
                            </div>
                            <div class="col-lg-4 sm-12">
{{--                                <button id="submit" disabled="disabled" class="btn btn-block btn-success" type="submit">Update Booking</button>--}}
                            </div>
                        </div>

                    <!----------------------- /EDIT BOOKING----------------->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <hr>

        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <div class="sidebar-content-wrap">
                        <!-- Single Sidebar Start -->
                        <div class="single-sidebar" style="background: #fff;">
                            <h3> EDIT PASSENGER / FLIGHT DETAILS </h3>
                            <div class="sidebar-body">
                                <ul>
                                    <li>
                                        <div class="form-group">
                                            <label for="nop">Number of Passengers:
                                                <small class="req text-lowercase"></small>
                                            </label>
                                            <select class="form-control validate[required]" name="nop" id="nop">
                                                <option value="1" {{ $bk_details->bk_nop == 1 ? "selected" : "" }} >1 Passenger</option>
                                                <option value="2" {{ $bk_details->bk_nop == 2 ? "selected" : "" }} >2 Passengers</option>
                                                <option value="3" {{ $bk_details->bk_nop == 3 ? "selected" : "" }} >3 Passengers</option>
                                                <option value="4" {{ $bk_details->bk_nop == 4 ? "selected" : "" }} >4 Passengers</option>
                                                <option value="5" {{ $bk_details->bk_nop == 5 ? "selected" : "" }} >5 Passengers</option>
                                                <option value="6" {{ $bk_details->bk_nop == 6 ? "selected" : "" }} >6 Passengers</option>
                                            </select>
                                        </div>

                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <label for="OutboundFlightNumber">Outbound Flight Number:
                                                <small class="req text-lowercase"></small>
                                            </label>
                                            <input type="text"  class="input-text form-control validate[required]"  name="OutboundFlightNumber" id="OutboundFlightNumber" value="{{ $bk_details->bk_ou_fl_nu }}">
                                            <span for="OutboundFlightNumber" class="bferror"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <label for="ReturnFlightNumber">Return Flight Number:
                                                <small class="req text-lowercase"></small>
                                            </label>
                                            <input type="text" name="ReturnFlightNumber" id="ReturnFlightNumber" class="input-text form-control validate[required]" value="{{ $bk_details->bk_re_fl_nu }}" >
                                            <span for="Model" class="bferror"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Single Sidebar End -->
                    </div>
                    
                </div>
                <div class="col-lg-6">
                    <div class="sidebar-content-wrap">
                        <!-- Single Sidebar Start -->
                        <div class="single-sidebar" style="background: #fff;">
                            <h3>EDIT VEHICLE DETAILS</h3>
                            <div class="sidebar-body">
                                <ul>
                                    <li>
                                        <div class="form-group">
                                            <label for="DepartureTerminal">Registration Number:
                                                <small class="req text-lowercase"></small>
                                            </label>
                                            <input type="text" name="RegistrationNumber" id="RegistrationNumber" class="input-text form-control validate[required]" value="{{ $bk_details->bk_re_nu }}" placeholder="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <label for="ArrivalTerminal">Vehicle Make:
                                                <small class="req text-lowercase"></small>
                                            </label>
                                            <input type="text" name="VehicleMake" id="VehicleMake" class="input-text form-control validate[required]" value="{{ $bk_details->bk_ve_ma }}" placeholder="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <label>Vehicle Model:
                                                <small class="text-lowercase"></small>
                                            </label>
                                            <input type="text" name="VehicleModel" id="VehicleModel" class="input-text form-control validate[required]" value="{{ $bk_details->bk_ve_mo }}" placeholder="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <label for="Color">Vehicle Colour:
                                                <small class="req text-lowercase"></small>
                                            </label>
                                            <select class="form-control validate[required]" name="VehicleColour" id="VehicleColour" >
                                                <option value="">---Select Colour---</option>
                                                @foreach($colors as $color)
                                                    <option value="{{$color->clr_name}}" {{ $bk_details->bk_ve_co == $color->clr_name ? "selected" : "" }} >{{$color->clr_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                        <div class="col-lg-6 sm-12">
                                            <div class="form-group">
                                            <label for="validationDefaultUsername" style="color: red;">Drop off date/time:</label>
                                            <div class="input-group">
                                                <div class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
                                                    @if (!empty($bk_details->bk_ve_mo) && !empty($bk_details->bk_ve_co))
                                                        <input class="datetime validate[required]" name="bk_ve_do_dt" id="bk_ve_do_dt" type="text" value="{{$bk_details->bk_ve_do_dt}}"  readonly>
                                                    @else
                                                        <input class="datetime validate[required]" name="bk_ve_do_dt" id="bk_ve_do_dt" type="text" value="{{$bk_details->bk_from_date}}"  readonly>
                                                    @endif
                                                    <span class="add-on"><i class="icon-remove"></i></span>
                                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-lg-6 sm-12">
                                            <div class="form-group">
                                            <label for="validationDefaultUsername" style="color: red;">Pick up date/time:</label>
                                            <div class="input-group">
                                                <div class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
                                                    @if (!empty($bk_details->bk_ve_mo) && !empty($bk_details->bk_ve_co))
                                                        <input class="datetime validate[required]"  name="bk_ve_pu_dt" id="bk_ve_pu_dt" type="text" value="{{$bk_details->bk_ve_pu_dt}}" readonly>
                                                    @else
                                                        <input class="datetime validate[required]"  name="bk_ve_pu_dt" id="bk_ve_pu_dt" type="text" value="{{$bk_details->bk_to_date}}" readonly>
                                                    @endif

                                                    <span class="add-on"><i class="icon-remove"></i></span>
                                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                    </li>
                                    <li>

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Single Sidebar End -->
                    </div>
                </div>
            </div>
        </div>
        <hr >

        <div class="col-lg-12" style="background: #fff;padding: 20px;">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Single FAQ Subject  Start -->
                    <div class="booking-section travelo-box borderbox">
                        <div class="row" id="edit-payment-methods" style="display: none">
                            <div class="col-md-12 mb20">
                                <h6>Payment Method</h6>
                            </div>
                            <div class="col-sm-12 col-md-12">

                                <div class="frb-group">
                                    <!--<div class="frb frb-success">
                                        <input type="radio" id="radio-button-1" {{($bk_details->bk_payment_method == 3) ? 'checked':'' }} name="payment_option" value="3"
                                               class="validate[required] radio">
                                        <label for="radio-button-1">
                                            <span class="frb-title">Pay by WorldPay</span>
                                            <span class="frb-description">&nbsp;</span>
                                        </label>
                                    </div>-->
                                    <div class="frb frb-success">
                                        <input type="radio" id="radio-button-2" {{($bk_details->bk_payment_method == 2) ? 'checked':'' }} name="payment_option" value="2"
                                               class="validate[required] radio">
                                        <label for="radio-button-2">
                                            <span class="frb-title">Pay by PayPal  </span>
                                            <span class="frb-description">&nbsp;</span>
                                        </label>
                                    </div>
                                    <div class="frb frb-success">
                                        <input type="radio" id="radio-button-3" {{($bk_details->bk_payment_method == 1) ? 'checked':'' }} name="payment_option" value="1"
                                               class="validate[required] radio">
                                        <label for="radio-button-3">
                                            <span class="frb-title">Pay Later</span>
                                            <span class="frb-description"> ACCOUNT HOLDER COMPANIES ONLY</span>
                                        </label>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="row" id="sticky-button" >

                            <div class="col-sm-12 col-md-12">
                            <div id="displaypricebottom" style="">
                                    <span style='color:green;'>
                                        <strong>
                                            <?php $carwash = $bk_details->carwash_in_and_out + $bk_details->carwash_out_only + $bk_details->carwash_in_only; ?>
                                            <?php echo $bk_details->cur_symbol . " " . number_format($bk_details->bk_total_amount - $bk_details->bk_discount_offer_amount + $carwash, 2, '.', ''); ?>
                                        </strong>
                                    </span>
                            </div>
                            </div>
                            <div class="col-sm-6 col-md-12 mt20">
                                <div class="input-submit" style="text-align: center" >
                                    <button type="submit"  class="btn  btn btn-success btn-xs btn-block " name="continue" id="continue">
                                      Update Booking
                                    </button>
                                </div>
                                <div style="color:#fff" class="alert  final-notice mt20" id="final-notice" >

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
             </div>
        </div>


        </form>
    </div>
</section>
<!--== FAQ Area End ==-->
<script type="text/javascript">
    function alertFunction() {
        //alert('ok');
        //calculatePrice();
        //getDiscountCouponVip();
    }
    window.onload = alertFunction;
</script>

@endsection
