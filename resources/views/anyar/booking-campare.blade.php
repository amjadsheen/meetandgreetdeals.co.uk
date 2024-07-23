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
  .card.card-custom {
    /* box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px; */
    /* box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 25px, rgba(0, 0, 0, 0.05) 0px 5px 10px; */
    box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;
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
    color: #000;
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
  section#hero {
    display: none !important;
}
  .icon-boxes {
    padding-top: 100px;
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
  span.badge.badge-primary {
    background-color: #963c8f;
    color: #495057;
    margin-right: 5px;
    font-size: 0.75rem;
    color: #fff;
}
span.badge.badge-sec {
    background-color: orangered;
    color: #495057;
    margin-right: 5px;
    font-size: 0.75rem;
    color: #fff;
}
span.badge.badge-sec-text {
    margin-right: 5px;
    font-size: 0.75rem;
    color: orangered;
}

a.btn.btn-success.book-btn {
    width: 100%;
}
.card-body{ text-align:center;}
</style>

<!-- Booking Form Wrapper -->
<section id="icon-boxes" class="icon-boxes">


<div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-lg-12 align-items-stretch mb-5 mb-lg-0" data-aos="fade-up" id="bookingformmobile">
        <div class="icon-box">
            <div class="section-title text-center">
              <h2 class="section-title__title mb-2">Compare Parking Deals</h2>
              <p class="project-page-02__top-text d-none">From Wed, 15 May 2024 12:00 To Sun, 19 May 2024 12:00            </p>
            </div>
            <!----------------------- EDIT BOOKING ----------------->
            <div class="booka-car-content " id="loader">
              <!----------------------- NEW BOOKING ----------------->
              <form method="GET" action="compare-booking" id="step_1">
                @csrf
                <div class="row">
                  <div class="col-lg-3 sm-12">
                      <div class="input-group mb-3">
                          <label class="input-group-text " for="country">Select Country</label>
                          <select id="country" name="country" class="form-select validate[required]" require onchange="getairports()">
                              <option value="">Select</option>
                              @if(!$countries->isEmpty())
                                  @foreach($countries as $country)
                                      @if($country->disable == 1)
                                          <option value="{{$country->id}}" disabled="disabled">{{$country->name}} (booking closed) </option>
                                      @else
                                          <option {{($requset_data['country'] == $country->id) ? 'selected':'' }} value="{{$country->id}}">{{$country->name}}</option>
                                      @endif
                                  @endforeach
                              @endif
                          </select>
                        </div>
                  </div>

                  <div class="col-lg-3 sm-12">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="airport1">Airport</label>
                      <select class="form-select validate[required]" id="airport1" name="airport1" onchange="getTerminals()">
                        <option value="" selected>Choose @isMobile Airport  @endisMobile</option>
                        @foreach($airports as $s_airport)
                        <option {{($requset_data['airport1'] == $s_airport->id) ? 'selected':'' }} value="{{$s_airport->id}}">{{$s_airport->airport_name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-3 sm-12">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="terminal">Departure Terminals & Hotels</label>
                      <select class="form-select validate[required]" id="terminal" name="terminal">
                        <option value=""> Select @isMobile Departure Terminals & Hotels  @endisMobile</option>
                        @foreach($selected_terminals as
                        $selected_terminal)
                        @if($selected_terminal->ter_disable
                        == 1)
                        <option value="{{$selected_terminal->id}}" disabled="disabled">
                          {{$selected_terminal->ter_name}}
                          (booking closed)
                        </option>
                        @else
                        <option {{($requset_data['terminal'] == $selected_terminal->id) ? 'selected':'' }} value="{{$selected_terminal->id}}">
                          {{$selected_terminal->ter_name}}
                        </option>
                        @endif
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-3 sm-12">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="return_terminal">Return Terminals & Hotels</label>
                      <select class="form-select validate[required]" id="return_terminal" name="return_terminal" onchange="calculatePrice();">
                        <option value=""> Select @isMobile Return Terminals & Hotels  @endisMobile</option>
                        @foreach($selected_terminals as $selected_terminal)
                        @if($selected_terminal->ter_disable
                        == 1)
                        <option value="{{$selected_terminal->id}}" disabled="disabled">
                          {{$selected_terminal->ter_name}}
                          (booking closed)
                        </option>
                        @else
                        <option {{($requset_data['return_terminal'] == $selected_terminal->id) ? 'selected':'' }} value="{{$selected_terminal->id}}">
                          {{$selected_terminal->ter_name}}
                        </option>
                        @endif
                        @endforeach
                      </select>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-lg-4 sm-12 ">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="service">Service</label>
                      <select class="form-select validate[required]" id="service" name="service" onchange="calculatePrice();">
                        <option value> Select Service </option>
                        @foreach($services as $service)
                          @if($service->disable == 1)
                          <option disabled="disabled" style="color: orangered" value="{{$service->id}}">
                            {{$service->service_name}} (Not
                            Available)
                          </option>
                          @else
                          <option {{($requset_data['service'] == $service->id) ? 'selected':'' }} value="{{$service->id}}">
                            {{$service->service_name}}
                          </option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-4 sm-12">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="date1">Drop Off Date/Time</label>
                      <input class="datetime form-control validate[required] form_datetime" name="date1" id="date1" type="text" placeholder="Drop off date/time" value="{{$requset_data['date1']}}" onchange="calculatePrice()" readonly>
                      <span class="add-on"><i class="icon-remove"></i></span>
                      <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                  </div>
                  <div class="col-lg-4 sm-12">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="date2">Arrival Date/Time</label>
                      <input class="datetime form-control validate[required] form_datetime" name="date2" id="date2" type="text" placeholder="Arrival date/time" value="{{$requset_data['date2']}}" onchange="calculatePrice()" readonly>
                      <span class="add-on"><i class="icon-remove"></i></span>
                      <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                  </div>
                </div>
               <div class="row">
                  @foreach($currencies as $currency)
                          <input name="currency1" id="currency1" type="hidden" value="{{$requset_data['currency1']}}">
                    @endforeach
                  <input style="border: transparent; background-color: #fff;" class="datetime" id="discount_coupon" name="discount_coupon" type="hidden" value="" readonly>
                  <div class="col-lg-4 sm-12" id="terminal_parking_fee_div">
                    <input type="hidden" id="terminal_parking_fee" name="terminal_parking_fee" value="N" >
                    <input type="hidden" id="website_id" name="website_id" value="0" >
                    <input type="hidden" id="all_services" name="all_services" value="{{ $requset_data['all_services'] }}" >
                      <div class="input-group mb-3">
                        <label class="input-group-text" for="vehical_num">Vehical<span id="tef"></label>
                        <select id="vehical_num" name="vehical_num" class="form-select validate[required]">
                          <option value> Select </option>
                          @foreach($vehical_selction as $key=>$tso)
                            <option {{($requset_data['vehical_num'] == $key) ? 'selected':'' }} value="{{$key}}">{{$tso}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="col-lg-4 sm-12">
                    <div id="displayprice" style=" text-align:center;  color: red;">{!! $Err !!} </div>
                    <div id="submit-errors" style=" color: red;">
                    
                    </div>
                  </div>
                  <div class="col-lg-4 sm-12">
                    <button id="submitfrom" style="width: 100%;" class="btn btn-block btn-success" type="submit">Update Search</button>
                  </div>
                </div>
              </form>
              <!----------------------- /NEW BOOKING ----------------->
            <!-- ======= Services Section ======= -->
            </div>
            </div>
            </div>
            </div>
</div>
<div class="container">
<section id="services" class="services" style="padding-top:20px;">
  <div class="container" data-aos="fade-up">
    <?php //echo "<pre>"; print_r($booking_data);  echo "</pre>"; ?>
    <?php //echo "<pre>"; print_r($services_terminals_prices);  echo "</pre>"; ?>
    
    <div class="row" id="ajaxservice">
      
    </div>
    <div class="row" id="ajaxservicehd">

      <!-- @foreach($services_terminals_prices as $service)
      <div class="col-md-3 d-flex align-items-stretch mt-4 mt-md-0">
          <div class="icon-box" style="background: {{ $service['bg_color'] }};">
              <h4>{{ $service['website_name'] }} 
                <span style="font-size: 30px; margin-left: 4px;">{{ $service['terminal_name'] }} -- {{ $service['service_name'] }}</span>
              </h4>
              <a style="cursor:pointer;" onclick="updatedservice({{ $service['terminal_id'] }}, {{ $service['website_id'] }});" class="plan-btn">
                  <span style="color:#fff; font-size:15px;">Select {{ $service['cur_symbol'] }} {{ $service['net_price'] }}</span>
              </a>
          </div>
      </div>
    @endforeach -->

    @foreach($services_terminals_prices as $service)
            <div class="col-md-4 mb-4">
                <div class="card card-custom" style="background: {{ $service['bg_color'] }};">
                    <div class="card-header" style="max-height: 106px; min-height: 106px;">
                        <div><img src="/storage/uploads/{{$service['website_logo']}}" class="card-img-top" alt="Service Logo" style="width: 150px;">
                        <span class="badge badge-sec-text">{{ $service['website_name'] }}</span></div>
                        <div style="text-align:center;margin-top: 5px;"><span class="badge badge-primary">{{ $service['service_name'] }}</span></div>
                        
                        
                    </div>
                    
                    <div class="card-body">
                        <span class="badge badge-sec">Terminal {{ $service['terminal_name'] }}</span>
                        <p class="price">{{ $service['cur_symbol'] }} {{ $service['net_price'] }}</p>
                        <a href="#" onclick="updatedservice({{ $service['terminal_id'] }}, {{ $service['website_id'] }});" class="btn btn-success book-btn">
                            Select Parking
                        </a>
                        {!! $service['promo']!!}
                    </div>
                </div>
            </div>
        @endforeach

    </div>
  </div>
</section>
</div>
<!-- /End Services Section -->


<!-- ======= Cta Section ======= -->
<section id="cta" class="cta">
  <div class="container">


    <div class="row" data-aos="zoom-in">
      <div class="col-lg-9 text-center text-lg-start">
        <h3>Contact Us</h3>

        <p> Book online or call Customer Service Number <br> {{$domain->working_time}}  <br><br><span><a href="tel:{{$domain->contact_num}}">{{$domain->contact_num}}</a> <br><br> <a href="tel:{{$domain->alternate_contact_num}}">{{$domain->alternate_contact_num}}</a></span> </p> <hr> <p> Email Us at <br><a href="mailto:{{$domain->email}}">{{$domain->email}}</a></span> <br><br>  <a href="mailto:{{$domain->alternate_email}}">{{$domain->alternate_email}}</a></p>
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
  function updatedservice(id, websiteid) {
    var selectElement = document.getElementById("return_terminal");
    if (selectElement) {
      selectElement.value = id;
    }
    var website = document.getElementById("website_id");
    if (website) {
      website.value = websiteid;
    }
    document.getElementById('step_1').action = "/confirm-booking";
    // Get the form element by its ID
    document.getElementById('submitfrom').click();
    
  }
</script>

@endsection
