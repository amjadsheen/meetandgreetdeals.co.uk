@extends('anyar.layouts.app')
@section('content')
@section('sitefavicon')
<link rel="shortcut icon" href="/storage/uploads/{{$domain->website_favicon}}" type="image/x-icon" />
@stop
@section('title', $domain->website_name)
@section('logoheader')
<a href="index.html" class="logo">
    <img src="/storage/uploads/{{$domain->website_logo}}" alt="logo {{$domain->website_name}}" class="img-fluid">
</a>
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

<!--== Slider Area Start ==-->

<style>
    .custom-popup {
  position: fixed;
  top: 50%;
  right: 1%;
  transform: translateY(-50%);
  background-color: rgb(0 0 0 / 96%);
  color: white;
  padding: 20px;
  width: 380px;
  box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
  z-index: 10000000;
}

.custom-popup-content {
  position: relative;
}

.custom-close-btn {
    position: absolute;
    top: -13px;
    right: -2px;
    font-size: 29px;
    cursor: pointer;
}

.custom-close-btn:hover {
  color: red;
}

.custom-popup-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.custom-popup-header h3 {
 color:#ffd000 !important;
}
.custom-warning-icon {
  font-size: 20px;
  margin-right: 5px;
}
    .ja-content-top.clearfix {
        box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
}
    #displayprice {
        font-size: 24px;
    }
    .input-group, .input-append.date.form_datetime {
        width: 100%;
    }
    .input-append.date.form_datetime input.datetime{
        width: 85% !important;
    }
    .form-row {
        width: 93%;
    }

    .single-service.mb-3 {
        margin: 30px 0;
    }

    .benefits-section ul li i {
        background: #da0909;
    }

    .single-service ul,
    .single-service li,
    .single-service p {
        margin-left: 0 !important;
        padding-left: 0 !important;
    }

    card::after {
        display: block;
        position: absolute;
        bottom: -10px;
        left: 20px;
        width: calc(100% - 40px);
        height: 35px;
        /* background-color: #fff; */
        background-color: #cccccc36;
        -webkit-box-shadow: 0 19px 28px 5px rgba(64, 64, 64, 0.09);
        box-shadow: 0 19px 28px 5px rgba(64, 64, 64, 0.09);
        content: '';
        z-index: -1;
    }

    .pt-3 {
        padding-top: 30px;
    }

    .pb-5 {
        padding-bottom: 50px;
    }

    .mb-3 {
        margin-bottom: 30px;
    }

    a.card {
        text-decoration: none;
    }

    .card {
        position: relative;
        border: 0;
        border-radius: 0;
        background-color: #fff;
        -webkit-box-shadow: 0 12px 20px 1px rgba(64, 64, 64, 0.09);
        box-shadow: 0 12px 20px 1px rgba(64, 64, 64, 0.09);
    }

    .card {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: .25rem;
    }

    .box-shadow {
        -webkit-box-shadow: 0 12px 20px 1px rgba(64, 64, 64, 0.09) !important;
        box-shadow: 0 12px 20px 1px rgba(64, 64, 64, 0.09) !important;
    }

    .ml-auto,
    .mx-auto {
        margin-left: auto !important;
    }

    .mr-auto,
    .mx-auto {
        margin-right: auto !important;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    .bg-white {
        background-color: #fff !important;
    }

    .ml-auto,
    .mx-auto {
        margin-left: auto !important;
    }

    .mr-auto,
    .mx-auto {
        margin-right: auto !important;
    }

    .d-block {
        display: block !important;
    }

    img,
    figure {
        max-width: 100%;
        height: auto;
        vertical-align: middle;
    }

    .card-text {
        padding-top: 12px;
        color: #8c8c8c;
    }

    .text-sm {
        font-size: 12px !important;
    }

    p,
    .p {
        margin: 0 0 16px;
    }

    .card-title {
        margin: 0;
        font-family: "Montserrat", sans-serif;
        font-size: 18px;
        font-weight: 900;
    }

    .pt-1,
    .py-1 {
        padding-top: .25rem !important;
    }

    .head-icon {
        margin-top: 18px;
        color: #FF4500
    }
</style>
<style>
    .price-sec-wrap {}

    .main-heading {
        text-align: center;
        font-weight: 600;
        padding-bottom: 15px;
        position: relative;
        text-transform: capitalize;
        font-size: 24px;
        margin-bottom: 25px;
    }

    .price-box {
       
        /* padding: 20px 11px; */
        padding: 0px 0px 4px 0px;
        background: #fff;
        border-radius: 4px;
        background: #cccccc1a;
        box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
    }

    .shadow-box {
        box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
        background: #cccccc1a;
        padding: 20px 10px;
    }

    .price-box ul {
        padding: 5px 12px;
        margin: 2px 0 9px 0px;
        list-style: none;
        /* border-top: solid 1px #e9e9e9; */
        /* border-bottom: solid 1px #e9e9e9; */
        min-height: 350px;
    }

    .price-box ul li {
        padding: 1px 0;
        font-size: 12px;
        color: #333;
        text-align: left;
        font-size: 15px;
    }

    #ajaxservice .col-lg-4 .price-box ul {
        min-height: 370px;
    }

    ul.info.non-flex li,
    ul.info.gold li {
        color: #fff;
    }

    #ajaxservice .col-lg-12 {
        margin-top: 15px;
    }

    .price-label {
        font-size: 16px;
        font-weight: 600;
        line-height: 1.34;
        margin-bottom: 0;
        padding: 6px 15px;
        display: inline-block;
        border-radius: 3px;
        width: 100%;
        text-align: center;
        color: #fff;
        text-transform: uppercase;
        box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
    }

    .price-label.non-flux {
        /* color: #FF5722; */
    }

    .price {
        font-size: 28px;
        line-height: 25px;
        margin: 15px 0 6px;
        font-weight: 900;
        text-align: center;
        color: green;
    }

    .price-info {
        font-size: 14px;
        font-weight: 400;
        line-height: 1.67;
        color: inherit;
        width: 100%;
        margin: 0;
        color: #989898;
    }

    .plan-btn {
        text-transform: uppercase;
        font-weight: 600;
        display: block;
        padding: 11px 30px;
        /* border: 2px solid #b3b3b3; */
        color: #000;
        margin-top: 5px;
        overflow: hidden;
        position: relative;
        z-index: 1;
        margin: 0;
        border-radius: 5px;
        text-decoration: none;
        width: 100%;
        text-align: center;
        font-size: 14px;
        background: #000;
    }

    .plan-btn::after {
        position: absolute;
        left: -100%;
        top: 0;
        content: "";
        height: 100%;
        width: 100%;
        background: #000;
        z-index: -1;
        transition: all 0.35s ease-in-out;
    }

    .plan-btn:hover::after {
        left: 0;
    }

    .plan-btn:focus {
        text-decoration: none;
        color: green;
        border: 2px solid #000;
    }

    .info li {
        list-style: none;
    }

    .info {
        padding: 10px 5px;
        margin-bottom: 5px;
    }
    div#ja-wrapper {
    margin-bottom: 15px;
}
small.white {
    color: #fff;
}

    @media (max-width: 991px) {
        .price-box {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 575px) {
        .main-heading {
            font-size: 21px;
        }
        .hide-mobile{
            display: none;
        }
        .price-box {
            margin-bottom: 20px;
        }

        .col-md-4 {
            margin-top: 19px;
        }

        .benefits-section ul li {
            font-size: 12px;
        }
    }
</style>
<div id="ja-container" class="wrap ja-r1 container">

    <div class="main clearfix row">

        <div id="ja-mainbody" class="col-sm-12">

            <!-- CONTENT -->

            <div id="ja-main">

                <div class="inner clearfix">

                    <div id="ja-contentwrap" class="">

                        <div id="ja-content" class="column">
                            @if(!empty($homepromo))
                            <div id="ja-current-content" class="column">
                                <div class="ja-content-top clearfix" style="margin-bottom: 10px;padding: 10px;">
                                    <div class="ja-moduletable moduletable  clearfix" id="Mod51" style="    background: #000;">
                                        <div class="container-fluid" style="margin-bottom: 12px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="booking-form-inner" style="padding: 8px 0px 3px 0px;">
                                                        <div class="slideshowcontent arrow-pp" style="    text-align: center;">
                                                            <h2 style="font-size: 25px; margin-top: 0; text-align: center; margin: 0; color: #ff0606 !important;"><small class="white">VERIFY PROMOTION CODE</small>
                                                                {{$homepromo->offer_coupon}}
                                                                <small class="white">AND GET</small> {{$homepromo->offer_percentage}}% <small class="white">DISCOUNT BEFORE CHECKOUT</small>
                                                            </h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div id="ja-current-content" class="column">
                                <div class="ja-content-top clearfix">
                                    <div class="ja-moduletable moduletable  clearfix" id="Mod51">
                                        <div class="ja-box-ct clearfix">
                                            <div id="khpark2-booking-step-1">
                                                <!--== Book A Car Area Start ==-->
                                                <div id="book-a-car">
                                                    <div class="container">
                                                        <div class="row">

                                                            <div class="col-lg-12" style="padding:10px;">
                                                                <div class="booka-car-content " id="loader">

                                                                    @if ($booking_edit === 1)
                                                                    <!----------------------- EDIT BOOKING ----------------->
                                                                    <form method="post" action="#" id="step_1">
                                                                        @csrf
                                                                        <div class="form-row">
                                                                            <input type="hidden" name="redirect" id="redirect" value="{{$redirect}}">
                                                                            <div class="col-lg-3 sm-12">
                                                                                <label for="country">Select
                                                                                    Country</label>
                                                                                <select id="country" name="country" class="custom-select custom-select-lg mb-3 datetime" style="width:100%" onchange="getairports()">
                                                                                    <option value="0">---Select an
                                                                                        Country---</option>
                                                                                    @if(!$countries->isEmpty())
                                                                                    @foreach($countries as $country)
                                                                                    @if($country->disable == 1)
                                                                                    <option value="{{$country->id}}" disabled="disabled">
                                                                                        {{$country->name}} (booking
                                                                                        closed)
                                                                                    </option>
                                                                                    @else
                                                                                    <option {{($bk_details->country_id == $country->id) ? 'selected':'' }} value="{{$country->id}}">
                                                                                        {{$country->name}}
                                                                                    </option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-3 sm-12">
                                                                                <label for="validationDefault01">Select
                                                                                    an airport</label>
                                                                                <select id="airport1" name="airport1" class="custom-select custom-select-lg mb-3 datetime" onchange="getTerminals()">
                                                                                    <option value="0">---Select an
                                                                                        airport---</option>
                                                                                    @foreach($selected_airport as
                                                                                    $s_airport)
                                                                                    @if($s_airport->airport_disable ==
                                                                                    1)
                                                                                    <option value="{{$s_airport->id}}" disabled="disabled">
                                                                                        {{$s_airport->airport_name}}
                                                                                        (booking closed)
                                                                                    </option>
                                                                                    @else
                                                                                    <option {{($bk_details->airport_id == $s_airport->id) ? 'selected':'' }} value="{{$s_airport->id}}">
                                                                                        {{$s_airport->airport_name}}
                                                                                    </option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-3 sm-12">
                                                                                <label for="validationDefault02">Select
                                                                                    Departure Terminal:</label>
                                                                                <select id="terminal" name="terminal" class="custom-select custom-select-lg mb-3 datetime" onchange="getDiscountCouponVip();">
                                                                                    <option value="0">---select
                                                                                        departure terminal---</option>
                                                                                    @foreach($selected_terminals as
                                                                                    $selected_terminal)
                                                                                    @if($selected_terminal->ter_disable
                                                                                    == 1)
                                                                                    <option value="{{$selected_terminal->id}}" disabled="disabled">
                                                                                        {{$selected_terminal->ter_name}}
                                                                                        (booking closed)
                                                                                    </option>
                                                                                    @else
                                                                                    <option {{($bk_details->bk_ou_te == $selected_terminal->id) ? 'selected':'' }} value="{{$selected_terminal->id}}">
                                                                                        {{$selected_terminal->ter_name}}
                                                                                    </option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                                <div id="terpro"></div>
                                                                            </div>
                                                                            <div class="col-lg-3 sm-12">
                                                                                <label for="validationDefault02">Select
                                                                                    Return Terminal:</label>
                                                                                <select id="return_terminal" name="return_terminal" class="custom-select custom-select-lg mb-3 datetime" onchange="calculatePrice();">
                                                                                    <option value="0">---select return
                                                                                        terminal---</option>
                                                                                    <option value="0">---select
                                                                                        departure terminal---</option>
                                                                                    @foreach($selected_terminals as
                                                                                    $selected_terminal)
                                                                                    @if($selected_terminal->ter_disable
                                                                                    == 1)
                                                                                    <option value="{{$selected_terminal->id}}" disabled="disabled">
                                                                                        {{$selected_terminal->ter_name}}
                                                                                        (booking closed)
                                                                                    </option>
                                                                                    @else
                                                                                    <option {{($bk_details->bk_re_te == $selected_terminal->id) ? 'selected':'' }} value="{{$selected_terminal->id}}">
                                                                                        {{$selected_terminal->ter_name}}
                                                                                    </option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="col-lg-4 sm-12 ">
                                                                                <label for="validationDefault02">Service</label>
                                                                                <select id="service" name="service" style="width:100%" class="custom-select custom-select-lg mb-3 datetime" onchange="calculatePrice();">
                                                                                    <option value="0">---Select
                                                                                        Service---</option>
                                                                                    @foreach($services as $service)
                                                                                    @if($service->disable == 1)
                                                                                    <option style="color: orangered" {{($bk_details->service_id == $service->id) ? 'selected':'' }} value="{{$service->id}}">
                                                                                        {{$service->service_name}} (Not
                                                                                        Available)
                                                                                    </option>
                                                                                    @else
                                                                                    <option {{($bk_details->service_id == $service->id) ? 'selected':'' }} value="{{$service->id}}">
                                                                                        {{$service->service_name}}
                                                                                    </option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-4 sm-12">
                                                                                <label for="validationDefaultUsername">Drop
                                                                                    off date/time</label>
                                                                                <div class="input-group">

                                                                                    <div class="input-append date form_datetime">
                                                                                        <input class="datetime validate[required]" name="date1" id="date1" type="text" placeholder="Drop off date/time" value="{{$bk_details->bk_from_date}}" onchange="calculatePrice()" readonly>
                                                                                        <span class="add-on"><i class="icon-remove"></i></span>
                                                                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 sm-12">
                                                                                <label for="validationDefaultUsername">Arrival
                                                                                    date/time</label>
                                                                                <div class="input-group">

                                                                                    <div class="input-append date form_datetime">
                                                                                        <input class="datetime validate[required]" name="date2" id="date2" type="text" placeholder="Arrival date/time" onchange="calculatePrice()" value="{{$bk_details->bk_to_date}}" readonly>
                                                                                        <span class="add-on"><i class="icon-remove"></i></span>
                                                                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            

                                                                            <input id="bookingeditpage" type="hidden" value="0">
                                                                        </div>



                                                                        <div class="form-row" style="clear:both;">
                                                                            <div class="col-lg-3 sm-12 " style="{{ $settings['eden_discount_box'] == 1 ? "display:none" : "" }}">
                                                                                <label for="validationDefaultUsername">Auto discount: </label>
                                                                                <input style="border: transparent; background-color: #fff;" class="datetime" id="discount_coupon" name="discount_coupon" type="text" value="" readonly>
                                                                                <span id="discount_value"></span>
                                                                            </div>
                                                                            <div class="col-lg-3 sm-12">

                                                                                <select style="" name="currency1" id="currency1" onchange="calculatePrice();" class="custom-select custom-select-lg mb-3">
                                                                                    {{-- <option value="1">Pay in British Pound £ </option>--}}
                                                                                    @foreach($currencies as $currency)
                                                                                    <option {{($bk_details->currency_id == $currency->id) ? 'selected':'' }} value="{{$currency->id}}">Pay in
                                                                                        {{$currency->cur_name}}
                                                                                        {{$currency->cur_symbol}}
                                                                                    </option>
                                                                                    @endforeach
                                                                                </select>

                                                                            </div>
                                                                            <div class="col-lg-6 sm-12">

                                                                                <div id="displayprice" style=""></div>
                                                                                <div id="submit-errors" style=" font-size: 21px; color: red;">
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-row" style="clear:both;">
                                                                            <div class="col-lg-6 sm-12">&nbsp;</div>
                                                                            <div class="col-lg-6 sm-12">
                                                                                <button id="submit" disabled="disabled" class="btn btn-block btn-success" type="submit">Continue
                                                                                    Booking</button>
                                                                            </div>
                                                                        </div>

                                                                    </form>
                                                                    <!----------------------- /EDIT BOOKING----------------->
                                                                    @else
                                                                    <!----------------------- NEW BOOKING ----------------->
                                                                    <form method="post" action="#" id="step_1">
                                                                        @csrf
                                                                        <div class="form-row">
                                                                            <input type="hidden" name="redirect" id="redirect" value="{{$redirect}}">
                                                                            <div class="col-lg-3 sm-12">
                                                                                <label for="country">Select
                                                                                    Country</label>
                                                                                <select id="country" name="country" class="custom-select custom-select-lg mb-3 datetime" style="width:100%" onchange="getairports()">
                                                                                    <option value="0">---Select an
                                                                                        Country---</option>
                                                                                    @if(!$countries->isEmpty())
                                                                                    @foreach($countries as $country)
                                                                                    @if($country->disable == 1)
                                                                                    <option value="{{$country->id}}" disabled="disabled">
                                                                                        {{$country->name}} (booking
                                                                                        closed)
                                                                                    </option>
                                                                                    @else
                                                                                    <option value="{{$country->id}}">
                                                                                        {{$country->name}}
                                                                                    </option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-3 sm-12">
                                                                                <label for="validationDefault01">Select
                                                                                    an airport</label>
                                                                                <select id="airport1" name="airport1" class="custom-select custom-select-lg mb-3 datetime" style="width:100%" onchange="getTerminals()">
                                                                                    <option value="0">---Select an
                                                                                        airport---</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-3 sm-12">
                                                                                <label for="validationDefault02">Select
                                                                                    Departure Terminal:</label>
                                                                                <select id="terminal" name="terminal" class="custom-select custom-select-lg mb-3 datetime" style="width:100%" onchange="getDiscountCouponVip();">
                                                                                    <option value="0">---select
                                                                                        departure terminal---</option>
                                                                                </select>
                                                                                <div id="terpro"></div>
                                                                            </div>
                                                                            <div class="col-lg-3 sm-12">
                                                                                <label for="validationDefault02">Select
                                                                                    Return Terminal:</label>
                                                                                <select id="return_terminal" name="return_terminal" class="custom-select custom-select-lg mb-3 datetime" style="width:100%" onchange="calculatePrice();">
                                                                                    <option value="0">---select return
                                                                                        terminal---</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="col-lg-4 sm-12 ">
                                                                                <label for="validationDefault02">Service</label>
                                                                                <select id="service" name="service" class="custom-select custom-select-lg mb-3 datetime" style="width:100%" onchange="calculatePrice();">
                                                                                    <option value="0">---Select
                                                                                        Service---</option>
                                                                                    @foreach($services as $service)
                                                                                    @if($service->disable == 1)
                                                                                    <option style="color: orangered" value="{{$service->id}}">
                                                                                        {{$service->service_name}} (Not
                                                                                        Available)
                                                                                    </option>
                                                                                    @else
                                                                                    <option value="{{$service->id}}">
                                                                                        {{$service->service_name}}
                                                                                    </option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-4 sm-12">
                                                                                <label for="validationDefaultUsername">Drop
                                                                                    off date/time</label>
                                                                                <div class="input-group">

                                                                                    <div class="input-append date form_datetime">
                                                                                        <input class="datetime validate[required]" name="date1" id="date1" type="text" placeholder="Drop off date/time" value="" onchange="calculatePrice()" readonly>
                                                                                        <span class="add-on"><i class="icon-remove"></i></span>
                                                                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 sm-12">
                                                                                <label for="validationDefaultUsername">Arrival
                                                                                    date/time</label>
                                                                                <div class="input-group">

                                                                                    <div class="input-append date form_datetime">
                                                                                        <input class="datetime validate[required]" name="date2" id="date2" type="text" placeholder="Arrival date/time" onchange="calculatePrice()" value="" readonly>
                                                                                        <span class="add-on"><i class="icon-remove"></i></span>
                                                                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            

                                                                            <input id="bookingeditpage" type="hidden" value="0">
                                                                        </div>



                                                                        <div class="form-row" style="clear:both;">
                                                                            <div class="col-lg-3 sm-12 " style="{{ $settings['eden_discount_box'] == 1 ? "display:none" : "" }}">
                                                                                <label for="validationDefaultUsername">Eden
                                                                                    auto discount: </label>
                                                                                <input style="border: transparent; background-color: #fff;" class="datetime" id="discount_coupon" name="discount_coupon" type="text" value="" readonly>
                                                                                <span id="discount_value"></span>
                                                                            </div>
                                                                            <div class="col-lg-3 sm-12">

                                                                                <select style="display: none" name="currency1" id="currency1" onchange="calculatePrice();" class="custom-select custom-select-lg mb-3">
                                                                                    {{-- <option value="1">Pay in British Pound £ </option>--}}
                                                                                    @foreach($currencies as $currency)
                                                                                    <option value="{{$currency->id}}">
                                                                                        Pay in {{$currency->cur_name}}
                                                                                        {{$currency->cur_symbol}}
                                                                                    </option>
                                                                                    @endforeach
                                                                                </select>

                                                                            </div>
                                                                            <div class="col-lg-6 sm-12">
                                                                                <label for="validationDefaultUsername">&nbsp;</label>
                                                                                <div id="displayprice" style="  color: red;"></div>
                                                                                <div id="submit-errors" style=" color: red;"></div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-row" style="clear:both;">
                                                                            <div class="col-lg-6 sm-12">&nbsp;</div>
                                                                            <div class="col-lg-6 sm-12">
                                                                                <button id="submit" disabled="disabled" class="btn btn-block btn-success" type="submit">BOOK NOW</button>
                                                                            </div>
                                                                        </div>

                                                                    </form>
                                                                    <!----------------------- /NEW BOOKING ----------------->
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--== Book A Car Area End ==-->


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ja-content-main clearfix">


                                    <div class="price-sec-wrap">
                                        <div class="container-fluid">
                                            <div class="row" id="ajaxservice" style="text-align:center;">

                                                <!-- <img src="/storage/uploads/load-100.gif" class="loader-100" /> -->
                                                <?php
                                                $html = "";
                                                foreach ($services as $key => $service) {

                                                    $bg_color = "#fff";
                                                    $color = "#da0909";
                                                    if ($service->slug == 'gold') {
                                                        $bg_color = "green";
                                                        $color = "#fff";
                                                    } else if ($service->slug == 'platinum') {
                                                        $bg_color = "#D4AF37";
                                                    } else if ($service->slug == 'flex') {
                                                        $bg_color = "yellow";
                                                    } else if ($service->slug == 'non-flex') {
                                                        $bg_color = "#bc0404";
                                                        $color = "#fff";
                                                    }
                                                    //$price_with_symbol =  $cur_symbol . "" . number_format($net_price, 2, '.', '');
                                                    //$price_with_symbol = "<span style='color:$color; font-size:25px;'>Select " . $price_with_symbol . "</span>";
                                                    // $services_response_array[] = array(
                                                    //     'price' => $price_with_symbol,
                                                    //     'sercice_id' => $service->id,
                                                    //     'service_name' => $service->service_name,
                                                    //     'service_image' => $service->service_image,
                                                    //     'service_details' => $service->service_details,
                                                    //     'service_prefix' => $service->service_prefix,
                                                    // );
                                                    if ($key >= 3) {
                                                        $row = "12";
                                                    } else {
                                                        $row = "4";
                                                    }


                                                    $html .= '<div class="col-lg-' . $row . '">';
                                                    $html .= '<div class="price-box" style="background: ' . $bg_color . ';">';
                                                    $html .= '<div class="">';
                                                    $html .= '<div class="price-label ' . $service->slug . '">';
                                                    $html .= '<img src="/storage/uploads/' . $service->service_image . '" style="width:33px;" class="w-100" />';
                                                    $html .= '&nbsp;&nbsp;' . $service->service_name . '';
                                                    $html .= '</div>';
                                                    $html .= '</div>';
                                                    $html .= '<ul class="info ' . $service->slug . '">';
                                                    $html .= '' . $service->service_details . '';
                                                    if ($service->disable == 0) {
                                                        //$html .= '<a style="cursor:pointer;" onclick="updatedservice(' . $service->id . ');"  class="plan-btn">'.$price_with_symbol.'</a>';

                                                    }
                                                    $html .= '</ul>';
                                                    $html .= '</div>';
                                                    $html .= '</div>';
                                                }
                                                ?>
                                                <?php echo $html; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ja-content-main clearfix">
                                    <div class="benefits-section shadow-box">
                                        {!! $whyus->content !!}
                                    </div>
                                </div>


                                <!--== Services Area Start ==-->


                                <!-- <div class="ja-content-main clearfix">
                                    <div class="row pt-5 mt-30">
                                        @foreach($services as $service)
                                        <div class="col-lg-6 col-sm-6 mb-30 pb-5">
                                            <div class="card">
                                                <div class="box-shadow bg-white rounded-circle mx-auto text-center" style="width: 90px; height: 90px; margin-top: -45px;"><img src="/storage/uploads/{{$service->service_image}}"></div>
                                                <div class="card-body text-center single-service" style="padding: 0 9px;">
                                                    <h3 style="margin-top:30px !important;" class="card-title pt-1">{{$service->service_name}}</h3>
                                                    {{!! $service->service_details !!}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div> -->

                                <!--== Services Area End ==-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //CONTENT -->

            <div style="clear: both;"></div>



        </div>



    </div>

</div>
<div class="custom-popup">
  <div class="custom-popup-content">
    <span class="custom-close-btn">&times;</span>
    <div class="custom-popup-header">
      <h3><span class="custom-warning-icon">&#9888;</span> Ultra Low Emission Zone (ULEZ)</h3>
     
    </div>
    <div class="custom-description">
      <p>Heathrow is scheduled to become part of the expanded Ultra Low Emission Zone (ULEZ) starting 29 August 2023. All vehicles entering the ULEZ must meet specific emissions standards to avoid paying a daily charge. 
        <br><br><a target="_blank" href="https://tfl.gov.uk/modes/driving/ultra-low-emission-zone/ulez-expansion-2023">Find out more</a></p>
    </div>
  </div>
</div>
<!-- //MAIN CONTAINER -->
<script type="text/javascript">
    function updatedservice(id) {
        var selectElement = document.getElementById("service");
        if (selectElement) {
            selectElement.value = id;
        }
        alertFunction();
        var div = document.getElementById('loader');
        div.scrollIntoView({
            behavior: 'smooth'
        });

        document.getElementById('submit').click();
    }

    function alertFunction() {
        //alert('ok');
        calculatePrice();
        getDiscountCouponVip();
    }
    @if($booking_edit === 1)
    window.onload = alertFunction;
    @endif
</script>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function () {
  const customPopup = document.querySelector(".custom-popup");
  const customCloseBtn = document.querySelector(".custom-close-btn");
  const customDescription = document.querySelector(".custom-description");
  customCloseBtn.addEventListener("click", function () {
    customPopup.style.display = "none";
  });
});
</script>
@endsection