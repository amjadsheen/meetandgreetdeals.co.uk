<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
      <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link href="{{ asset('css/admin/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('css/admin/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

  <!-- Ionicons -->
  <link href="{{ asset('css/admin/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">

  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> -->
  <link href="{{ asset('css/admin/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/admin/summernote/summernote-bs4.css') }}" rel="stylesheet">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <!-- <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css"> -->
  <link href="{{ asset('css/admin/skins/_all-skins.min.css') }}" rel="stylesheet">

  <!-- jvectormap -->
  <!-- <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css"> -->
  <link href="{{ asset('css/admin/jvectormap/jquery-jvectormap.css') }}" rel="stylesheet">

  <!-- Date Picker -->
  <!-- <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"> -->
  <link href="{{ asset('css/admin/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
  <link href="{{ asset('js/admin/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') }}" rel="stylesheet">

    <link href="{{ asset('css/admin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
  <!-- Daterange picker -->
  <!-- <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css"> -->
  <link href="{{ asset('css/admin/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="css/admin/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>



  <![endif]-->

    <link rel="stylesheet" href="{{ asset('js/admin/tabs/dist/css/jquery-multitabs.min.css') }}">
<style>
    .topmargin20{
        margin-top: 20px;
    }
</style>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="skin-blue sidebar-mini wysihtml5-supported">
<div class="wrapper">
    <header class="main-header">
    <!-- Logo -->
    <a href="/admin" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Admin</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b></b>Admin</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('img/user.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">Admin</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('img/user.png') }}" class="img-circle" alt="User Image">

                <p>
                  Admin
                  {{--<small>Member since Nov. 2012</small>--}}
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">

              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/admin/profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('img/user.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>


      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
          <li class="treeview menu-open">
              <a href="#">
                  <i class="fa fa-gear"></i>
                  <span>Settings</span>
                  <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
              </a>
              <ul class="treeview-menu" style="display: block;">
                  <li><a href="{{route('globalsettings.index')}}"><i class="fa fa-mail-forward"></i> Email Settings</a></li>
                  <li><a href="{{route('settings.index')}}"><i class="fa fa-gear"></i> Other Settings</a></li>
              </ul>
          </li>

          <li class="treeview menu-open">
              <a href="#">
                  <i class="fa fa-gear"></i>
                  <span>Bookings</span>
                  <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
              </a>
              <ul class="treeview-menu" style="display: block;">
                  <li><a href="{{route('bookings.index')}}"><i class="fa  fa-list"></i> Bookings </a></li>
                  <li><a href="{{route('customers.index')}}"><i class="fa  fa-users"></i> Customers </a></li>
                  <li><a href="{{route('checkinout.index')}}"><i class="fa  fa-sign-out"></i> Checkin/Checkout </a></li>
                  <li><a href="{{route('pickdrop.index')}}"><i class="fa  fa-dropbox"></i> Arrival/Departure </a></li>
                  <li><a href="{{route('overparked.index')}}"><i class="fa  fa-list"></i> Vehicles Over Parked </a></li>
                  <li><a href="{{route('agentreports.index')}}"><i class="fa  fa-list"></i> Agents Reports </a></li>
                  <li><a href="{{route('manualbooking.index')}}"><i class="fa  fa-list"></i> Manual Order </a></li>
                  <li><a href="{{route('customeraccounts.index')}}"><i class="fa  fa-list"></i> Customer Accounts </a></li>

              </ul>
          </li>


        <li class="treeview menu-open">
          <a href="#">
            <i class="fa fa-plane"></i>
            <span>Booking Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            <li><a href="{{route('websites.index')}}"><i class="fa fa-internet-explorer"></i> Website Setting</a></li>
            <li><a href="{{route('camparsionwebsites.index')}}"><i class="fa fa-internet-explorer"></i> Camparsion Website</a></li>
            <li><a href="{{route('country.index')}}"><i class="fa fa-globe"></i> Countries</a></li>
              <li><a href="{{route('currencies.index')}}"><i class="fa fa-dollar"></i> Currencies</a></li>
              <li><a href="{{route('services.index')}}"><i class="fa fa-building"></i> Hotels</a></li>
            <li><a href="{{route('services.index')}}"><i class="fa fa-cubes"></i> Services </a></li>
            <li><a href="{{route('airport.index')}}"><i class="fa fa-building-o"></i> Airports</a></li>
            <li><a href="{{route('terminal.index')}}"><i class="fa fa-terminal"></i> Terminals</a></li>
            <li><a href="{{route('color.index')}}"><i class="fa fa-spinner"></i> Color</a></li>
              <li><a href="{{route('booking-edit-fix-prices.index')}}"><i class="fa fa-th"></i> Edit Fixed Prices</a></li>
            <li><a href="{{route('regular-prices.index')}}"><i class="fa fa-th"></i> Pricing</a></li>
            <!-- <li><a href="{{route('vip-prices.index')}}"><i class="fa fa-th-list"></i> Pricing VIP/Business</a></li> -->
            <li><a href="{{route('regular-discounts.index')}}"><i class="fa fa-tag"></i> Discounts</a></li>
            <!-- <li><a href="{{route('vip-discounts.index')}}"><i class="fa fa-tags"></i> Discounts VIP</a></li> -->
            <li><a href="{{route('promotion-companies.index')}}"><i class="fa  fa-university"></i> Promotion Companies</a></li>
            <li><a href="{{route('promotion-offers.index')}}"><i class="fa fa-diamond"></i> Promotion Offers</a></li>


              <li><a href="{{route('blacklists.index')}}"><i class="fa fa-unlock-alt"></i> Blacklists</a></li>
              <li><a href="{{route('yards.index')}}"><i class="fa fa-area-chart"></i> Yards (Movements)</a></li>
              <li><a href="{{route('locations.index')}}"><i class="fa fa-sitemap"></i> Locations (Movements)</a></li>
              <li><a href="{{route('agents.index')}}"><i class="fa fa-user-secret"></i> Agents</a></li>
              <li><a href="{{route('drivers.index')}}"><i class="fa fa-user-plus"></i> Drivers</a></li>


              <li><a href="{{route('carwash.index')}}"><i class="fa fa-user-secret"></i> Carwash</a></li>
              <li><a href="{{route('vehicaltype.index')}}"><i class="fa fa-user-plus"></i> Vehical Type</a></li>
               <li><a href="{{route('paymentlink.index')}}"><i class="fa fa-money"></i> Direct Payment Link </a></li>

          </ul>
        </li>



        <li class="treeview menu-open">
          <a href="#">
              <i class="fa fa-book"></i>
              <span>Site Content</span>
              <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            <li><a href="{{route('news.index')}}"><i class="fa  fa-television"></i> News </a></li>
              <li><a href="{{route('faqs.index')}}"><i class="fa fa-list-ul"></i> Faqs </a></li>
              <li><a href="{{route('banner.index')}}"><i class="fa  fa-play-circle-o"></i> Banners </a></li>
              <li><a href="{{route('directions.index')}}"><i class="fa fa-arrows"></i> Directions </a></li>
            <li><a href="{{route('pages.index')}}"><i class="fa  fa-folder-open"></i> Pages </a></li>
              <li><a href="{{route('reviews.index')}}"><i class="fa fa-star"></i> Reviews </a></li>
          </ul>
        </li>
        {{--<li><a  href="{{route('airport.index')}}"><i class="fa fa-book"></i> <span>Airport</span></a></li>--}}
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

        <main class="py-4">
            @yield('content')
        </main>
        <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- jQuery 3 -->
<!-- <script src="bower_components/jquery/dist/jquery.min.js"></script> -->
<script src="{{ asset('js/admin/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('js/admin/tabs/dist/js/jquery-multitabs.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<!-- <script src="bower_components/jquery-ui/jquery-ui.min.js"></script> -->
<script src="{{ asset('js/admin/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
  (function () {
      $('.tabs').multitabs();
  })();
</script>
<!-- Bootstrap 3.3.7 -->
<!-- <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<script src="{{ asset('js/admin/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- jvectormap -->
<!-- <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
{{--<script src="{{ asset('js/admin/jquery.min.js') }}"></script>--}}

<!-- Sparkline -->
<!-- <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script> -->
<script src="{{ asset('js/admin/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>



<!-- <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
<!-- <script src="{{ asset('js/admin/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script> -->

<!-- jQuery Knob Chart -->
<!-- <script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script> -->
<script src="{{ asset('js/admin/jquery-knob/dist/jquery.knob.min.js') }}"></script>


<!-- Bootstrap WYSIHTML5 -->
<!-- <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->
<script src="{{ asset('js/admin/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

<!-- Slimscroll -->
<!-- <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->
<script src="{{ asset('js/admin/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- FastClick -->
<!-- <script src="bower_components/fastclick/lib/fastclick.js"></script> -->
<script src="{{ asset('js/admin/fastclick/lib/fastclick.js') }}"></script>

<!-- AdminLTE App -->
<!-- <script src="dist/js/adminlte.min.js"></script> -->
<script src="{{ asset('js/admin/adminlte.min.js') }}"></script>
<script src="{{ asset('js/admin/bootstrap3-editable/js/bootstrap-editable.js') }}"></script>
<script src="{{ asset('js/admin/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('css/admin/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('css/admin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard.js"></script> -->
{{--<script src="{{ asset('js/admin/pages/dashboard.js') }}"></script>--}}

<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
{{--<script src="{{ asset('js/admin/demo.js') }}"></script>--}}

<script src="{{ asset('js/admin/ajax-edit-inline.js') }}?t=<?php echo time(); ?>"></script>

</body>
</html>
