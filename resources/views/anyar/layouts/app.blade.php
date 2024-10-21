<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="shortcut icon" href="{{ asset('anyar/assets/img/ms-icon-310x310.png')}}" type="image/x-icon" />
  <title>@yield('title')</title>
  @yield('meta')
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->

  <link href="{{ asset('anyar/assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{ asset('anyar/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('anyar/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('anyar/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('anyar/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset('anyar/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('anyar/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{ asset('anyar/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link href="{{ asset('cardo/assets/css/font-awesome.css')}}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{ asset('anyar/assets/css/style.css')}}?{{time()}}" rel="stylesheet">
  <link href="{{ asset('cardo/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
  <link href="{{ asset('cardo/assets/validation/css/validationEngine.jquery.css')}}" rel="stylesheet">
</head>
<style>
 
  .datetimepicker-days span.dh,
  .datetimepicker-days span.dm {
    display: none !important;
  }

  .datetimepicker-hours span.dd,
  .datetimepicker-hours span.dm {
    display: none !important;
  }

  .datetimepicker-minutes span.dd,
  .datetimepicker-minutes span.dh {
    display: none !important;
  }

  span.dd,
  span.dh,
  span.dm {
    color: red;
  }
  @media (max-width: 575px){
    .custom-popup{
      bottom: 3% !important;
      width: 100% !important;
      height: 200px;
      left:0;
    }
    .custom-popup h3 {
      font-size: calc(0.9rem + .6vw) !important;
    }
    #bookingformmobile label.input-group-text {
      display: none;
    }

    #hero {
    height: 30vh;
  }
    #topbar {
      height: 40px;
      font-size: 12px;
    }
    #header {
      top: 40px;
    }
    #header #header-container {
      justify-content: space-evenly;
    }
    span.contact_nums, span.emails{
      padding: 0 1px;
    }
    #topbar .contact-info i{
      font-size: 8px;
      margin-right: 3px;
    }
    #topbar .contact-info .phone-icon {
    margin-left: 0;
    }
    .common{
      width: 100%;
      display: inline-block;
    }

}
@isMobile
label.input-group-text {
    width: 100%;
    border-radius: 0;
}
@endisMobile
</style>

<body>
  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="fixed-top d-flex align-items-center topbar-inner-pages">
    <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <span class="contact_nums">
          
          @isMobile
          <span class="common"><i class="bi bi-phone-fill phone-icon"></i><a href="tel:{{$domain->contact_num}}">{{$domain->contact_num}}</a> &nbsp;</span>
          @else
          <span class="common"><i class="bi bi-envelope-fill"></i><a href="mailto:{{$domain->email}}">{{$domain->email}}</a>&nbsp;</span>
          <span class="common"><i class="bi bi-envelope-fill"></i><a href="mailto:{{$domain->alternate_email}}">{{$domain->alternate_email}}</a></span>
          @endisMobile
        </span>

        @if (trim($domain->contact_num) !== '' || trim($domain->alternate_contact_num) !== '' )
        <span class="emails">
        @isMobile
           <span class="common"><i class="bi bi-phone-fill phone-icon"></i><a href="tel:{{$domain->alternate_contact_num}}">{{$domain->alternate_contact_num}}</a><span><i style="margin-left: 5px;" class="bi bi-clock-fill clock-icon"></i> {{$domain->working_time}}</span></span>
        @else
          <span class="common"><i class="bi bi-phone-fill phone-icon"></i><a href="tel:{{$domain->contact_num}}">{{$domain->contact_num}}</a> &nbsp;</span>
          <span class="common"><i class="bi bi-phone-fill phone-icon"></i><a href="tel:{{$domain->alternate_contact_num}}">{{$domain->alternate_contact_num}}</a></span>
        @endisMobile
          
        </span>
        @endif
        
      </div>
      <div class="cta d-none d-md-block">
        @if (trim($domain->working_time) !== '')
        <span><i class="fa fa-clock-o"></i> {{$domain->working_time}}</span>
        @endif
      </div>
    </div>
  </div>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center align-items-start" id="header-container">
      <a href="/" class="logo">
        <img src="/storage/uploads/{{$domain->website_logo}}" alt="logo {{$domain->website_name}}" class="img-fluid">
      </a>
      <nav id="navbar" class="navbar">
        <ul>
        <li>
            <a class="nav-link scrollto {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
        </li>
        <li>
            <a class="nav-link scrollto {{ Request::is('about-us') ? 'active' : '' }}" href="/about-us">About</a>
        </li>
        <li>
            <a class="nav-link scrollto {{ Request::is('services') ? 'active' : '' }}" href="/services">Services</a>
        </li>
        <li>
            <a class="nav-link scrollto {{ Request::is('directions') ? 'active' : '' }}" href="/directions">Directions</a>
        </li>
        <li>
            <a class="nav-link scrollto {{ Request::is('reviews') ? 'active' : '' }}" href="/reviews">Testimonials</a>
        </li>
        <li>
            <a class="nav-link scrollto {{ Request::is('terms-conditions') ? 'active' : '' }}" href="/terms-conditions">Terms & Conditions</a>
        </li>
        <li>
            <a class="nav-link scrollto {{ Request::is('contact-us') ? 'active' : '' }}" href="/contact-us">Contact Us</a>
        </li>
        <li>
            <a class="nav-link scrollto {{ Request::is('faq') ? 'active' : '' }}" href="/faq">FAQs</a>
        </li>

          <?php  if (isset($_COOKIE["cus_id"])) { ?>

          <?php } else { ?>
          <li><a class="nav-link" href="/customer-login">Login</a></li>
          <li><a class="nav-link" href="/sign-up">Register</a></li>
          <?php } ?>
          <li class="dropdown"><a href="#"><span>&nbsp;</span> <i class="bi bi-person"></i></a>
            <ul>
              <?php if (isset($_COOKIE["cus_id"])) { ?>
                <li><a href="/my-bookings">My Bookings</a></li>
                <li><a href="/profile">Profile</a></li>
                <li><a href="/customer-logout">Logout</a></li>
              <?php } else { ?>
                <li><a href="/my-bookings">My Bookings</a></li>
                <li><a href="/sign-up">SignUp</a></li>
              <?php } ?>
            </ul>
          </li>
         
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->

  @if(!Request::is('/'))
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-cntent-center align-items-center" style="@if(Request::is('/'))  @else  height: 30vh; @endif">
    <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">
      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="carousel-container">
        </div>
      </div>
    </div>
  </section><!-- End Hero -->
  @endif
  <main id="main">
    <!------------- page content start --------------->
    @yield('content')
    <!------------- /page content start end --------------->
  </main>
  <!-- End #main -->
  <div class="container d-flex align-items-center align-items-start" id="footer-container" style="padding-bottom: 10px;">
      <div class="row row-cols-lg-12" style="padding-top: 15px;">
        <div class="col-md-6 col-sm-12 col-12">
          <img style="" src="{{ asset('anyar/assets/img/gb/13.png')}}" alt="" class="img-fluid">
          
        </div>
        <div class="col-md-6 col-sm-12 col-12">

          <img style="" src="{{ asset('anyar/assets/img/gb/new-cards.png')}}" alt="" class="img-fluid">
        </div>
      </div>
  </div>
  <!-- ======= Footer ======= -->
  <footer id="footer">
    <!-- <div class="container d-flex align-items-center align-items-start" id="footer-container" style="padding-bottom: 10px;">
      <div class="row row-cols-lg-6" style="padding-top: 25px;">
        <div class="col-md-4 col-sm-6 col-6">
          <img style="" src="{{ asset('anyar/assets/img/gb/01.jpg')}}" alt="" class="img-fluid">
        </div>
        <div class="col-md-4 col-sm-6 col-6">
          <img style="" src="{{ asset('anyar/assets/img/gb/02.jpg')}}" alt="" class="img-fluid">
        </div>
        <div class="col-md-4 col-sm-6 col-6">
          <img style="" src="{{ asset('anyar/assets/img/gb/03.jpg')}}" alt="" class="img-fluid">
        </div>
        <div class="col-md-4 col-sm-6 col-6">
          <img style="" src="{{ asset('anyar/assets/img/gb/04.jpg')}}" alt="" class="img-fluid">
        </div>
        <div class="col-md-4 col-sm-6 col-6">
          <img style="" src="{{ asset('anyar/assets/img/gb/05.jpg')}}" alt="" class="img-fluid">
        </div>
        <div class="col-md-4 col-sm-6 col-6">
          <img style="" src="{{ asset('anyar/assets/img/gb/06.jpg')}}" alt="" class="img-fluid">
        </div>
      </div>
    </div> -->
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-info">
            <h3>About </h3>
            <p> {{ $domain->address}}</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <!-- <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a> -->
            </div>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>HELPFUL LINKS</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="/">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="/reviews">Testimonials</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="/services">Services</a></li>

            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>DISCOVER</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="/services">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="/directions">Directions</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="/faq">Faqs</a></li>

            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links" style="border-right: none;">
            <h4>OUR COMPANY</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="/about-us">About</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="/terms-conditions">Terms & Conditions</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="/contact-us">Contact us</a></li>

            </ul>
          </div>
        </div>
      </div>
    </div>

      

    <div class="container" style="background-image: linear-gradient(90deg,#f76b1c,#ffd000); height: 4px;">
      <div>
        <div class="copyright">
          &copy; Copyright @2023 <strong><span>{{ $domain->website_name}}</span></strong>. All Rights Reserved
        </div>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->

  <script src="{{ asset('anyar/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('anyar/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('anyar/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('anyar/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('anyar/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{ asset('anyar/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('anyar/assets/js/main.js')}}"></script>
  <!--=== Jquery Min Js ===-->
  <script src="{{ asset('cardo/assets/js/jquery-3.2.1.min.js')}}"></script>
  <!--=== Jquery Migrate Min Js ===-->
  <script src="{{ asset('cardo/assets/js/jquery-migrate.min.js')}}"></script>
  <script src="{{ asset('cardo/assets/js/plugins/gijgo.js')}}"></script>
  <script src="{{ asset('cardo/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
  <script src="{{ asset('cardo/assets/validation/js/languages/jquery.validationEngine-en.js')}}"></script>
  <script src="{{ asset('cardo/assets/validation/js/jquery.validationEngine.min.js')}}"></script>
  <script src="{{ asset('cardo/assets/js/validate.js')}}"></script>
  <script src="{{ asset('cardo/assets/js/main.js')}}?t=<?php echo time(); ?>"></script>
  <script src="{{ asset('cardo/assets/js/min10.js')}}?t=<?php echo time(); ?>"></script>

</body>

</html>