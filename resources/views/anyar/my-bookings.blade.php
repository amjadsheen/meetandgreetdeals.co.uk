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

    .car-details-info hr {
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
    .widget-body a {
        color: red;
    }
    .table td, .table th {
        padding: .45rem;
        font-size: 12px;
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

     <div class="row section-padding">
       <div class="col-lg-12">
           <div class="car-details-info">
               @if(session()->get('success'))
                   <div class="alert alert-success alert-dismissible">
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                       <i class="icon fa fa-check"></i>{{ session()->get('success') }}
                   </div>
               @endif
               @if(session()->get('warning'))
                   <div class="alert alert-warning alert-dismissible">
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                       <i class="icon fa fa-warning"></i>{{ session()->get('warning') }}
                   </div>
               @endif
               <h4>BOOKINGS</h4>
               <div class="technical-info">
                   <div class="row">
                       <div class="col-lg-12">
                           <div class="tech-info-table" style="background-color: #fff;">
                               <table class="table table-bordered">
                                   <thead>

                                   <tr>
                                       <th scope="col" >Sr#</th>
                                       <th scope="col" >Date</th>
                                       <th scope="col" >Booking Ref</th>
                                       <th scope="col" >Country</th>
                                       <th scope="col" >Airport</th>
                                       <th scope="col" >Outbound terminal</th>
                                       <th scope="col" >Inbound terminal</th>
                                       <th scope="col" >Vehicle drop off time</th>
                                       <th scope="col" >Arrival date/time</th>

                                       <th>Duration</th>
                                       <th>Total amount</th>
                                      <!-- <th>Action</th> -->
                                   </tr>
                                   </thead>
                                   <tbody>
                                   @foreach($allbookings as $booking)
                                   <tr>
                                       <td scope="row">{{$loop->iteration}}</td>
                                       <td>{{$booking->bk_date}} </td>
                                       <td>{{$booking->bk_ref}}</td>
                                       <td>{{$booking->cus_country}}</td>
                                       <td>{{$booking->airport_name}}</td>
                                       <td>{{$booking->ter_name1}}</td>
                                       <td>{{$booking->ter_name2}}</td>
                                       <td>{{$booking->bk_from_date}}</td>
                                       <td>{{$booking->bk_to_date}}</td>
                                       <td>{{$booking->bk_days}} Days</td>
                                       <td>{{$booking->total_amount_special}}</td>
                                      <!-- <td>
                                           @if($booking->days_left > 0 && $booking->days_left >= 12)
                                            <a href="{{action('Frontend\BookingEditController@edit',$booking->booking_id)}}" class="btn btn-primary">Edit</a>
                                           @endif
                                       </td>-->
                                   </tr>
                                   @endforeach
                                   </tbody>
                                   </table>
                           </div>
                       </div>
                   </div>
               </div>

           </div>
        </div>
    </div>
</section>

@endsection
