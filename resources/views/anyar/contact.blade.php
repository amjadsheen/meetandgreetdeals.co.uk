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
                <h2>Contact Us</h2>
                <span class="title-line"><i class="fa fa-car"></i></span>
            </div>
        </div>
        <!-- Section Title End -->
    </div>
        <div class="row">

            <div class="col-lg-8">
                <div class="contact-form">
                    <form action="/contact-us" method="post">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6 col-md-6">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                    @if(session()->get('success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('success') }}
                                        </div><br/>
                                    @endif
                                <div class="website-input">
                                    <input class="input-text form-control"  type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Full Name">
                                    {{--                                    <div>{{ $error->first('full_name') }}</div>--}}
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="subject-input">
                                    <input class="input-text form-control"  type="email" name="email" value="{{ old('email') }}" placeholder="Email Address">
                                    {{--                                    <div>{{ $error->first('email') }}</div>--}}
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="subject-input">
                                    <input  class="input-text form-control" type="text"name="subject"  value="{{ old('subject') }}" placeholder="Subject">
                                    {{--                                    <div>{{ $error->first('subject') }}</div>--}}
                                </div>
                            </div>
                        </div>
<br>
                        <div class="message-input">
                            <textarea class="input-text form-control"  name="message" cols="30" rows="10" placeholder="Message">{{ old('message') }}</textarea>
                            {{--                            <div>{{ $error->first('message') }}</div>--}}
                        </div>
                        <br>
                        <div class="input-submit">
                            <button type="submit">Submit Message</button>

                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Area Start -->
            <div class="col-lg-4">
                <div class="sidebar-content-wrap m-t-50">

                    <!-- Single Sidebar Start -->
                    <div class="single-sidebar">
                        <h3>FOR MORE INFORMATIONS</h3>

                        <div class="sidebar-body">
                            {!! $page->content_left !!}
                            {!! $page->content_right !!}
                        </div>
                    </div>
                    <!-- Single Sidebar End -->

                    <!-- Single Sidebar Start -->
                </div>
            </div>
            <!-- Sidebar Area End -->




        </div>
    </div>
</div>
@endsection
