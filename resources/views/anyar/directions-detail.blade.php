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

<div class="contact-page-wrao section-padding">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>{{$direction->title}}</h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                </div>
            </div>
            <!-- Section Title End -->
        </div>
        <div class="row">

            <!-- Sidebar Area Start -->
            <div class="col-lg-4">
                <div class="sidebar-content-wrap m-t-50">
                    <!-- Single Sidebar Start -->
                    <div class="single-sidebar">
                        <img style="width: 100%;" src="/storage/uploads/{{$direction->image}}" alt="edenparking">
                    </div>
                    <!-- Single Sidebar End -->
                </div>
            </div>
            <!-- Sidebar Area End -->
            <!-- Car List Content Start -->
            <div class="col-lg-8">
                <div class="car-details-content">
                    <div class="car-details-info blog-content">
                        {!!$direction->content !!}
                    </div>
                </div>
            </div>
            <!-- Car List Content End -->

        </div>
    </div>
</div>

<!--== Help Desk Page Content Start ==-->
<section id="help-desk-page-wrap" class="section-padding" style="padding: 10px 0 50px 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="team-content">
                    <div class="row">
                        <!-- Team Tab Menu start -->
                        <div class="col-lg-4">
                            @if (trim($direction->terminal_1) !== '' ||  (trim($direction->terminal_2) !== '') ||  (trim($direction->terminal_3) !== '') ||  (trim($direction->terminal_4) !== '') ||  (trim($direction->terminal_5) !== '') )
                            <div class="team-tab-menu">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                    @if (trim($direction->terminal_1) !== '')
                                        <li class="nav-item">
                                            <a class="nav-link active" id="terminal_1" data-toggle="tab"
                                               href="#team_member_1" role="tab" aria-selected="true">
                                                <div class="team-mem-icon">

                                                </div>
                                                @if (trim($direction->slug) == 'gatwick-airport-directions')
                                                    <h5>South Terminal</h5>
                                                @else
                                                    <h5>Terminal 1</h5>
                                                @endif
                                            </a>
                                        </li>
                                    @endif

                                    @if (trim($direction->terminal_2) !== '')
                                        <li class="nav-item">
                                            <a class="nav-link" id="terminal_2" data-toggle="tab" href="#team_member_2"
                                               role="tab" aria-selected="true">
                                                <div class="team-mem-icon">

                                                </div>
                                                @if (trim($direction->slug) == 'gatwick-airport-directions')
                                                    <h5>North Terminal</h5>
                                                @else
                                                    <h5>Terminal 2</h5>
                                                @endif
                                            </a>
                                        </li>
                                    @endif

                                    @if (trim($direction->terminal_3) !== '')
                                        <li class="nav-item">
                                            <a class="nav-link" id="terminal_3" data-toggle="tab" href="#team_member_3"
                                               role="tab" aria-selected="true">
                                                <div class="team-mem-icon">

                                                </div>
                                                <h5>Terminal 3</h5>
                                            </a>
                                        </li>
                                    @endif

                                    @if (trim($direction->terminal_4) !== '')
                                        <li class="nav-item">
                                            <a class="nav-link" id="terminal_4" data-toggle="tab" href="#team_member_4"
                                               role="tab" aria-selected="true">
                                                <div class="team-mem-icon">

                                                </div>
                                                <h5>Terminal 4</h5>
                                            </a>
                                        </li>
                                    @endif
                                    @if (trim($direction->terminal_5) !== '')
                                        <li class="nav-item">
                                            <a class="nav-link" id="terminal_5" data-toggle="tab" href="#team_member_5"
                                               role="tab" aria-selected="true">
                                                <div class="team-mem-icon">

                                                </div>
                                                <h5>Terminal 5</h5>
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                            @endif
                        </div>
                        <!-- Team Tab Menu End -->

                        <!-- Team Tab Content start -->
                        <div class="col-lg-8">
                            <div class="tab-contente" id="myTabContente">
                            @if (trim($direction->terminal_1) !== '')
                                <!-- Single Team  start -->
                                    <div class="tab-pane fade in active show" id="team_member_1" role="tabpanel"
                                         aria-labelledby="terminal_1">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="team-member-info text-center">
                                                    {!! $direction->terminal_1 !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Team  End -->
                            @endif

                            @if (trim($direction->terminal_2) !== '')
                                <!-- Single Team  start -->
                                    <div class="tab-pane fade show" id="team_member_2" role="tabpanel"
                                         aria-labelledby="terminal_2">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="team-member-info text-center">
                                                    {!! $direction->terminal_2 !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Team  End -->
                            @endif

                            @if (trim($direction->terminal_3) !== '')
                                <!-- Single Team  start -->
                                    <div class="tab-pane fade show" id="team_member_3" role="tabpanel"
                                         aria-labelledby="terminal_3">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="team-member-info text-center">
                                                    {!! $direction->terminal_3 !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Team  End -->
                            @endif

                            @if (trim($direction->terminal_4) !== '')
                                <!-- Single Team  start -->
                                    <div class="tab-pane fade show" id="team_member_4" role="tabpanel"
                                         aria-labelledby="terminal_4">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="team-member-info text-center">
                                                    {!! $direction->terminal_4 !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Team  End -->
                            @endif

                            @if (trim($direction->terminal_5) !== '')
                                <!-- Single Team  start -->
                                    <div class="tab-pane fade show" id="team_member_5" role="tabpanel"
                                         aria-labelledby="terminal_5">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="team-member-info text-center">
                                                    {!! $direction->terminal_5 !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Team  End -->
                                @endif
                            </div>
                        </div>
                        <!-- Team Tab Content End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== Help Desk Page Content End ==-->

@endsection
