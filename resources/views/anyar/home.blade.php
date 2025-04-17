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
  .input-group {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.input-group-text {
    width: 250px;
    text-align: right;
    background-color: #40320736;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    padding: .375rem .75rem;
}

.input-group .form-select,
.input-group .form-control {
    width: calc(100% - 250px);
    border-radius: .25rem;
    border: 1px solid #ced4da;
    padding: .375rem .75rem;
}

.datetime {
    border-radius: .25rem;
    border: 1px solid #ced4da;
    padding: .375rem .75rem;
}

.btn-block {
    display: block;
    width: 100%;
}

#displayprice,
#submit-errors {
    margin-top: 1rem;
}

  .custom-popup {
  position: fixed;
  bottom: 3%;
  right: 1%;
  transform: translateY(-50%);
  background-color: #caa500;
  color: white;
  padding: 20px;
  width: 410px;
  box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
  z-index: 10000000;
}

.custom-popup-content {
  position: relative;
}

.custom-close-btn {
    position: absolute;
    top: -23px;
    right: -9px;
    font-size: 29px;
    color: red;
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
 font-size: 18px;
}
.custom-popup-header h6 {
 color:#000;
}
.custom-warning-icon {
  font-size: 20px;
  margin-right: 5px;
  color:red;
}

.custom-description {
  /* display: none; */
}

.custom-description p {
  margin: 0;
}

  .ja-content-top.clearfix {
    box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
  }

  #displayprice {
    font-size: 24px;
  }

  .input-group,
  .input-append.date.form_datetime {
    width: 100%;
  }

  .input-append.date.form_datetime input.datetime {
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
  #step_1{
      margin-top: 35px;
    }
  @media (max-width: 991px) {
    .price-box {
      margin-bottom: 20px;
    }
  }
  #bookingformmobile{
      margin-top: 50px;
    }
  @media (max-width: 575px) {
    #bookingformmobile{
      margin-top: 70px;
    }

    .main-heading {
      font-size: 21px;
    }

    .hide-mobile {
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
  .icon { font-size: 2rem; }
    .step-icon { font-size: 2rem; color: #6c757d; }
    .step-box { text-align: center; padding: 20px; }
    .bg-purple { background-color: #6f42c1; }
</style>

<!-- Booking Form Wrapper -->
<section id="icon-boxes" class="icon-boxes" style="padding-top:100px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-lg-12 align-items-stretch mb-5 mb-lg-0" data-aos="fade-up" id="bookingformmobile">
        <div class="icon-box">
            <div class="container" style="margin-bottom: 12px">
                    <div class="row" data-aos="zoom-in">
                        <div class="col-md-4">
                        <img style="margin-top: -36px;" src="{{ asset('anyar/assets/img/am.gif')}}" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                        @if(!empty($homepromo))
                            <div class="booking-form-inner" style="margin-bottom: 15px;padding: 8px 0px 3px 0px;float: none;background: linear-gradient(rgba(101, 2, 171, 0.8), rgba(87, 2, 106, 0.9)) !important;  !important;">
                                <div class="slideshowcontent arrow-pp" style="    text-align: center;">
                                    <h2 style="color:yellow; @isMobile font-size:12px; @else font-size:20px;  @endisMobile margin-top: 0;"><small class="white">VERIFY PROMOTION CODE</small>
                                        {{$homepromo->offer_coupon}}
                                        <small class="white">AND GET</small> {{$homepromo->offer_percentage}}% <small class="white">DISCOUNT BEFORE CHECKOUT</small> </h2>
                                </div>
                            </div>
                        @endif
                        <form method="GET" action="compare-booking" id="step_1">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                              <div class="col-llg-3 col-ssm-12">
                                  <div class="input-group">
                                  <label class="input-group-text" for="country">Select Country</label>
                                  @isMobile
                                    <select id="country" name="country" class="form-select validate[required]" required onchange="getairports()">
                                          <option value="">Select Country</option>
                                          @if(!$countries->isEmpty())
                                              @foreach($countries as $country)
                                                  @if($country->disable == 1)
                                                      <option value="{{$country->id}}" disabled="disabled">{{$country->name}} (booking closed)</option>
                                                  @else
                                                      <option value="{{$country->id}}">{{$country->name}}</option>
                                                  @endif
                                              @endforeach
                                          @endif
                                      </select>
                                  @else
                                    <select id="country" name="country" class="form-select validate[required]" required onchange="getairports()">
                                          <option value="">Select</option>
                                          @if(!$countries->isEmpty())
                                              @foreach($countries as $country)
                                                  @if($country->disable == 1)
                                                      <option value="{{$country->id}}" disabled="disabled">{{$country->name}} (booking closed)</option>
                                                  @else
                                                      <option value="{{$country->id}}">{{$country->name}}</option>
                                                  @endif
                                              @endforeach
                                          @endif
                                      </select>
                                  @endisMobile
                                     
                                      
                                  </div>
                              </div>

                              <div class="col-llg-3 col-ssm-12">
                              <div class="input-group">
                              @isMobile
                                <label class="input-group-text" for="airport1">Airport</label>
                                  <select class="form-select validate[required]" id="airport1" name="airport1" onchange="getTerminals()">
                                      <option value="" selected>Choose @isMobile Airport  @endisMobile</option>
                                      @foreach($airports as $s_airport)
                                          <option value="{{$s_airport->id}}">{{$s_airport->airport_name}}</option>
                                      @endforeach
                                  </select>
                              @else
                                  <label class="input-group-text" for="terminal">Departure Terminals & Hotels</label>
                                  <select class="form-select validate[required]" id="terminal" name="terminal">
                                      <option value="">Select  @isMobile Departure Terminals & Hotels  @endisMobile</option>
                                  </select>
                              @endisMobile
                              </div>
                                  
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="col-llg-3 col-ssm-12">
                                  <div class="input-group">
                                  @isMobile
                                      <label class="input-group-text" for="terminal">Departure Terminals & Hotels</label>
                                      <select class="form-select validate[required]" id="terminal" name="terminal">
                                          <option value="">Select  @isMobile Departure Terminals & Hotels  @endisMobile</option>
                                      </select>
                                  @else

                                      <label class="input-group-text" for="airport1">Airport</label>
                                      <select class="form-select validate[required]" id="airport1" name="airport1" onchange="getTerminals()">
                                          <option value="" selected>Choose @isMobile Airport  @endisMobile</option>
                                          @foreach($airports as $s_airport)
                                              <option value="{{$s_airport->id}}">{{$s_airport->airport_name}}</option>
                                          @endforeach
                                      </select>
                                  @endisMobile
                                      
                                  </div>
                              </div>

                              <div class="col-llg-3 col-ssm-12">
                                  <div class="input-group">
                                  
                                  @isMobile
                                      <label class="input-group-text" for="return_terminal">Return Terminals & Hotels</label>
                                      <select class="form-select validate[required]" id="return_terminal" name="return_terminal" onchange="calculatePrice();">
                                          <option value="">Select @isMobile Return Terminals & Hotels  @endisMobile</option>
                                      </select>
                                  @else
                                    <label class="input-group-text" for="return_terminal">Return Terminals & Hotels</label>
                                      <select class="form-select validate[required]" id="return_terminal" name="return_terminal" onchange="calculatePrice();">
                                          <option value="">Select @isMobile Return Terminals & Hotels  @endisMobile</option>
                                      </select>
                                  @endisMobile
                                     
                                  </div>
                              </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                              <div class="col-llg-3 col-ssm-12">
                                  <div class="input-group">
                                  
                                  @isMobile
                                  <label class="input-group-text" for="service">Service</label>
                                  <select class="form-select validate[required]" id="service" name="service" onchange="calculatePrice();">
                                          <option value="">Select @isMobile Service  @endisMobile</option>
                                          @foreach($services as $service)
                                              @if($service->disable == 1)
                                                  <option disabled="disabled" style="color: orangered" value="{{$service->id}}">{{$service->service_name}} (Not Available)</option>
                                              @else
                                                  <option value="{{$service->id}}">{{$service->service_name}}</option>
                                              @endif
                                          @endforeach
                                  </select>
                                  @else
                                  
                                  <label class="input-group-text" for="date1">Drop Off Date/Time</label>
                                      <input class="datetime form-control validate[required] form_datetime" name="date1" id="date1" type="text" placeholder="Drop off date/time" value onchange="calculatePrice()" readonly>
                                      <span class="add-on"><i class="icon-remove"></i></span>
                                      <span class="add-on"><i class="icon-calendar"></i></span>
                                  @endisMobile
                                      
                                      
                                  </div>
                              </div>

                              <div class="col-llg-3 col-ssm-12">
                                  <div class="input-group">
                                  @isMobile
                                      <label class="input-group-text" for="date1">Drop Off Date/Time</label>
                                      <input class="datetime form-control validate[required] form_datetime" name="date1" id="date1" type="text" placeholder="Drop off date/time" value onchange="calculatePrice()" readonly>
                                      <span class="add-on"><i class="icon-remove"></i></span>
                                      <span class="add-on"><i class="icon-calendar"></i></span>
                                  @else
                                  <label class="input-group-text" for="service">Service</label>
                                  <select class="form-select validate[required]" id="service" name="service" onchange="calculatePrice();">
                                          <option value="">Select @isMobile Service  @endisMobile</option>
                                          @foreach($services as $service)
                                              @if($service->disable == 1)
                                                  <option disabled="disabled" style="color: orangered" value="{{$service->id}}">{{$service->service_name}} (Not Available)</option>
                                              @else
                                                  <option value="{{$service->id}}">{{$service->service_name}}</option>
                                              @endif
                                          @endforeach
                                  </select>
                                  @endisMobile
                                      
                                  </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="col-llg-3 col-ssm-12">
                                  <div class="input-group">
                                  @isMobile
                                      <label class="input-group-text" for="date2">Pick-Up Date/Time</label>
                                      <input class="datetime form-control validate[required] form_datetime" name="date2" id="date2" type="text" placeholder="Pick-Up date/time" value onchange="calculatePrice()" readonly>
                                      <span class="add-on"><i class="icon-remove"></i></span>
                                      <span class="add-on"><i class="icon-calendar"></i></span>
                                  @else
                                  <label class="input-group-text" for="date2">Pick-Up Date/Time</label>
                                      <input class="datetime form-control validate[required] form_datetime" name="date2" id="date2" type="text" placeholder="Pick-Up date/time" value onchange="calculatePrice()" readonly>
                                      <span class="add-on"><i class="icon-remove"></i></span>
                                      <span class="add-on"><i class="icon-calendar"></i></span>
                                  @endisMobile
                                     
                                  </div>
                              </div>

                              <div class="col-llg-3 col-ssm-12" style="display:none">
                                  <div class="input-group">
                                  @isMobile
                                      <label class="input-group-text" for="vehical_num">Vehicle</label>
                                      <select id="vehical_num" name="vehical_num" class="form-select validate[required]">
                                          <!-- <option value="">Select @isMobile Vehicle  @endisMobile </option> -->
                                          @foreach($vehical_selction as $key=>$tso)
                                              <option value="{{$key}}">{{$tso}}</option>
                                          @endforeach
                                      </select>
                                  @else
                                  <label class="input-group-text" for="vehical_num">Vehicle</label>
                                      <select id="vehical_num" name="vehical_num" class="form-select validate[required]">
                                          <!-- <option value="">Select @isMobile Vehicle  @endisMobile </option> -->
                                          @foreach($vehical_selction as $key=>$tso)
                                              <option value="{{$key}}">{{$tso}}</option>
                                          @endforeach
                                      </select>
                                  @endisMobile
                                      
                                  </div>
                              </div>
                            </div>
                        </div>

                        <div class="row mb-3" style="display:none;">
                            @foreach($currencies as $currency)
                                <input name="currency1" id="currency1" type="hidden" value="{{$currency->id}}">
                            @endforeach
                            <input style="border: transparent; background-color: #fff;" class="datetime" id="discount_coupon" name="discount_coupon" type="hidden" value="" readonly>
                            <input type="hidden" id="terminal_parking_fee" name="terminal_parking_fee" value="N">
                            <input type="hidden" id="website_id" name="website_id" value="0">
                            <input type="hidden" id="all_services" name="all_services" value="0">
                            <div class="col-lg-6 col-sm-12">
                                <div id="displayprice" style="text-align:center; color: red;"></div>
                                <div id="submit-errors" style="color: red;"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                        <?php
                        $hide_promo_box_homepage = 1; // Default value
                        if (isset($settings['promo_box_homepage'])) {
                            $hide_promo_box_homepage = $settings['promo_box_homepage'];
                        }
                        ?>
                        @if(!$hide_promo_box_homepage)
                    
                        <div class="col-llg-3 col-ssm-12">
                          <div class="input-group">
                            <label class="input-group-text" for="discount_coupon">Promo Code</label>
                            <input type="text" class="input-text form-control" size="20" name="discount_coupon" placeholder="Enter Promo Code" id="discount_coupon" >
                          </div> 
                        </div>
                        @endif
                            <div class="col-lg-12 col-sm-12">
                           
                                <button id="submit" style="width: 100%;" class="btn btn-block btn-success" type="submit">Compare Airport Parking</button>
                            </div>
                        </div>
                    </form>
                        </div>
                        

                    
                    </div>
                </div>
            
              <!----------------------- NEW BOOKING ----------------->
              

<!----------------------- /NEW BOOKING ----------------->

  </div>
  </div>
  </div>

  </div>
</section>
<!-- /Booking Form Wrapper -->




<div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="text-warning">Why Choose Us?</h1>
            <p>Choosing the right airport parking for your holiday or business travel is crucial for peace of mind. At Meet and Greet Deals, we provide reliable, affordable, and convenient parking solutions across the UK. Our facilities are meticulously maintained and highly secure, ensuring your vehicle remains safe throughout your trip. Strategically located near major airports, our parking sites offer easy access, helping you avoid the stress of missing your flight. We are dedicated to delivering exceptional customer service, guaranteeing a seamless and worry-free parking experience every time.</p>
        </div>
        
        <div class="text-center mb-5">
            <h2 class="text-warning">Easy 4-Step Booking Process</h2>
            <p>Booking with us is simple and straightforward. Just follow these steps:</p>
        </div>
        
        <div class="row">
            <div class="col-md-3">
                <div class="step-box border">
                    <div class="step-icon mb-3">🔍</div>
                    <h4>Search</h4>
                    <p>Choose your airport and enter your travel dates. Click "Find Parking" to view premium car parking options tailored to your needs.</p>
                    <a href="#" class="btn btn-warning">Get a Quote</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="step-box border">
                    <div class="step-icon mb-3">🔄</div>
                    <h4>Compare Options</h4>
                    <p>Review prices, facilities, amenities, and other features. Compare options to find the best fit for your travel requirements.</p>
                    <a href="#" class="btn btn-warning">Compare Now</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="step-box border">
                    <div class="step-icon mb-3">👉</div>
                    <h4>Select Parking</h4>
                    <p>Choose the best parking option for your needs. Click "Book Now" to proceed to the final step of the booking process.</p>
                    <a href="#" class="btn btn-warning">Select Parking Now</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="step-box border">
                    <div class="step-icon mb-3">✅</div>
                    <h4>Booking</h4>
                    <p>Enter your details for a smooth parking experience. Provide your card information and click "Book Now" to confirm your booking and receive a confirmation email.</p>
                    <a href="#" class="btn btn-warning">Book Now</a>
                </div>
            </div>
        </div>
    </div>


<div class="custom-popup" data-aos="zoom-out">
  <div class="custom-popup-content">
    <span class="custom-close-btn">&times;</span>
    <div class="custom-popup-header">
      <h3><span class="custom-warning-icon">&#9888;</span> Check ULEZ compliance for you vehicle</h3>

    </div>
    <div class="custom-description">
      <p>Londons’s ULEZ expanded on 29th August 2023 to operate city-wide
Up to the M25. Use our ULEZ checker to find out if your car meets emissions standards and
What fees you may need to pay</p>
    </div>
  </div>
</div>


<!-- Clients Section -->
<section id="clients" class="clients section">
<div class="text-center mb-5">
  <h1 class="text-warning">Our Partners</h1>
</div>
<div class="container">

  <div class="swiper clients-slider init-swiper">
    <div class="swiper-wrapper  align-items-center">
    @foreach($partners as $website)
      <div class="swiper-slide"><a href="{{$website->website_url}}" target="_blank"><img src="/storage/uploads/{{$website->website_logo}}" class="img-fluid" alt=""></a></div>
    @endforeach
    </div>
  </div>

</div>

</section><!-- /Clients Section -->

<!-- ======= Cta Section ======= -->
<section id="cta" class="cta">
  <div class="container">


    <div class="row" data-aos="zoom-in">
      <div class="col-lg-9 text-center text-lg-start">
        <h3>Contact Us</h3>

        <p> Book online or call Customer Service Number <br> <br><span><a href="tel:{{$domain->contact_num}}">{{$domain->contact_num}}</a> <br><br> <a href="tel:{{$domain->alternate_contact_num}}">{{$domain->alternate_contact_num}}</a></span> </p> <hr> <p> Email Us at <br><a href="mailto:{{$domain->email}}">{{$domain->email}}</a></span> <br><br>  <a href="mailto:{{$domain->alternate_email}}">{{$domain->alternate_email}}</a></p>
        <p>Opening Hours: {{$domain->working_time}}</p>
      </div>
      <div class="col-lg-3 cta-btn-container text-center">
         <a class="cta-btn align-middle" href="/contact-us">Contact Us</a>
      </div>
    </div>

  </div>
</section><!-- End Cta Section -->



<!-- ======= Portfoio Section ======= -->


<!-- //MAIN CONTAINER -->
<script type="text/javascript">
  function updatedservice(id) {
    var selectElement = document.getElementById("terminal");
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
    //getDiscountCouponVip();
  }
  @if($booking_edit === 1)
  window.onload = alertFunction;
  @endif
</script>
<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
    const customPopup = document.querySelector(".custom-popup");
    const customCloseBtn = document.querySelector(".custom-close-btn");
    const customDescription = document.querySelector(".custom-description");
    customCloseBtn.addEventListener("click", function() {
      customPopup.style.display = "none";
    });
  });
</script>
@endsection
