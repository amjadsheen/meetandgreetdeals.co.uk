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
    .btn-wrapper {
        margin: 15px 0px 40px;
    }
    .medium-btn a {
        font-size: 20px;
        font-weight: normal;
        padding: 8px 25px;
    }
</style>

    <section id="car-list-area" class="section-padding" style="padding-top: 50px;">
        <div class="container ">
<div class="row">
    <div class="col-sm-8">
        <div class="section-title  text-center">
            <?php if(isset($_GET['payment_status']) && $_GET['payment_status'] == 'cancel'){ ?>
                <h2>BOOKING DETAILS</h2>
           <?php }else { ?>
                <h2>BOOKING CONFIRMATION</h2>
            <?php } ?>
            <span class="title-line"><img src="/storage/uploads/{{$domain->website_logo}}"  class="img-responsive" style="width:50%" /></span>
        </div>
        <img style="width: 100px;" src="/storage/qrcodes/{{$bk_details->id}}.png" align="right"  alt="{{$domain->website_name}}">

        <div class="single-service">
            <div class="media">
                <div class="media-body">
                    <h2 style="color:green;">BOOKING REFERENCE: {{$bk_details->bk_ref}}</h2>
                    <br/>
                    @if($bk_details->bk_payment_method == 1)
                    <h6 style="color:red;">TOTAL PAYABLE AMOUNT:
                        {!! $total_price_html !!} ( before flight departure )
                    </h6>
                    @else
                        <h3 style="color:red;">TOTAL AMOUNT:
                            {!! $total_price_html !!}
                        </h3>
                    @endif
                    
                    <?php if(isset($_GET['payment_status'])  && $_GET['payment_status'] == 'cancel'){ ?>
                        <hr>
                        <h6 style="color:red;">Payment Status: Pending </h6>
                    <?php } ?>
                </div>
            </div>
        </div>
        <hr/>
        <div class="single-service">
            <div class="media">
                <div class="media-body">
                    <h6> Dear <strong> {{$bk_details->cus_name}}</strong>,<br></h6>
                    <p><img class="alignright size-medium wp-image-3655" src="/storage/uploads/email/image_right.png" alt="off-airport-meet-n-greet-1" width="93" height="300" srcset="/storage/uploads/email/image_right.png 319w" sizes="(max-width: 93px) 100vw, 93px">Your booking has been completed<?php if(isset($_GET['payment_status']) &&  $_GET['payment_status'] == 'cancel'){ ?>, <span style="color:red;"> (not confirmed) Payment Status is Pending </span> <?php } ?> and you will receive an email or phone call shortly within 24 hours.</p>
                    <p>If you do not receive anything in 24 hours then give us a call on our booking office numbers below:</p>

                    <p style="text-align: center;">
                    </p><h5>
                    @if (trim($domain->contact_num)  !== '' || trim($domain->alternate_contact_num)  !== '' )
                            @if (trim($domain->contact_num) !== '') <span><i class="fa fa-phone" ></i><a style="padding: 11px; font-size: 16px;" href="tel:{{$domain->contact_num}}">{{$domain->contact_num}}</a>  @endif  @if (trim($domain->alternate_contact_num) !== '')  | <i class="fa fa-phone" ></i><a style="padding: 11px; font-size: 16px;" href="tel:{{$domain->alternate_contact_num}}">{{$domain->alternate_contact_num}}</a></span>@endif
                    @endif (CALL 9AM TO 5PM)
                    </h5>
                    <h5 style="padding: 20px;">Thank you very much for booking with us.</h5>
                </div>
            </div>
        </div>
        <div class="single-service">
            <div class="media">
                <div class="media-body">
                    {!! $special_promo !!}
                </div>
            </div>
        </div>

    </div>




    <div class="col-sm-4" align="center">
        <!--<div class="btn-wrapper simple-btn medium-btn">
            <a style="background-color: rgb(10, 101, 12); color: rgb(255, 255, 255);" href="{{$domain->website_url}}/my-bookings">My Bookings</a>
        </div>-->
        <div class="btn-wrapper simple-btn medium-btn">
            <a style="background-color: rgb(10, 101, 12); color: rgb(255, 255, 255);" href="{{$domain->website_url}}">New Booking</a>
        </div>
        @if($bk_details->bk_payment_method == 1)
            <div class="btn-wrapper simple-btn medium-btn">
                <a style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);" href="{{$domain->website_url}}/pay-later ">Pay Later Customer</a>
            </div>
        @endif
    </div>
</div>
<?php  unset($_COOKIE["bk_id"]); ?>
</div>
    </section>
@endsection
