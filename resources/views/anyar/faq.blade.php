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

<!--== FAQ Area Start ==-->
<section id="faq-page-area" class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>Faq's</h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                </div>
            </div>
            <!-- Section Title End -->
        </div>
        <div class="row">
            <!-- FAQ Content Start -->
            <?php //dd($faqs);?>
            <div class="col-lg-8">
                <div class="faq-details-content">
                    <!-- Single FAQ Subject  Start -->
                    <div class="single-faq-sub">
                        <div class="single-faq-sub-content">
                            <div id="accordion">



                            @foreach($faqs as $faq)
                                <!-- Single FAQ Start -->
                                <div class="card">
                                    <div class="card-header" id="heading{{$loop->iteration}}">
                                        <h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$loop->iteration}}" aria-expanded="{{ $loop->iteration === 1 ? "true" : "false" }}" aria-controls="collapseOne">
                                                <span>{{$faq->question}}</span>
                                                <i class="fa fa-angle-down"></i>
                                                <i class="fa fa-angle-up"></i>
                                            </button></h5>
                                    </div>
                                    <div id="collapse{{$loop->iteration}}" class="collapse {{ $loop->iteration === 1 ? "show" : "" }}" aria-labelledby="heading{{$loop->iteration}}" data-parent="#accordion">
                                        <div class="card-body">
                                            {{$faq->answer}}
                                        </div>
                                    </div>
                                </div>
                                <!-- Single FAQ End -->
                                @endforeach



                            </div>
                        </div>
                    </div>
                    <!-- Single FAQ Subject End -->
                </div>
            </div>
            <!-- FAQ Content End -->

            <!-- Sidebar Area Start -->
            <div class="col-lg-4">
                <div class="sidebar-content-wrap m-t-50">
                    <!-- Single Sidebar Start -->
                    <div class="single-sidebar">
                        <h3>For More Informations</h3>

                        <div class="sidebar-body">
                            @if (trim($domain->contact_num)  !== '' || trim($domain->alternate_contact_num)  !== '' )
                            <p><i class="fa fa-mobile"></i> <a href="tel:{{$domain->contact_num}}">{{$domain->contact_num}}</a>  | <a href="tel:{{$domain->alternate_contact_num}}">{{$domain->alternate_contact_num}}</a></p>
                            @endif
                                @if (trim($domain->working_time)  !== ''  )
                            <p><i class="fa fa-clock-o"></i> {{$domain->working_time}}</p>
                                @endif
                        </div>
                    </div>
                    <!-- Single Sidebar End -->

                    <!-- Single Sidebar Start -->

                @if (trim($domain->facebook)  !== '' || trim($domain->twitter)  !== '' )
                    <!-- Single Sidebar Start -->
                    <div class="single-sidebar">
                        <h3>Connect with Us</h3>

                        <div class="sidebar-body">
                            <div class="social-icons text-center">
                                @if (trim($domain->facebook)  !== '')
                                    <a href="{{$domain->facebook}}" target="_blank"><i class="fa fa-facebook"></i></a>
                                @endif
                                @if (trim($domain->twitter)  !== '')
                                    <a href="{{$domain->twitter}}" target="_blank"><i class="fa fa-twitter"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Single Sidebar End -->
                    @endif
                </div>
            </div>
            <!-- Sidebar Area End -->
        </div>
    </div>
</section>
<!--== FAQ Area End ==-->


@endsection
