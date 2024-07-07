@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$title}}s
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">{{$title}}s</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br/>
                    @endif

                </div>
            </div>
            <style>
                .speciald{
                    display: inline-block;
                    width: 25%;
                }
                .left{
                    text-align: left !important;
                }
            </style>
            <div class="row">
                <div class="col-md-12">
                    <section class="content" style="min-height: 167px;">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li ><a href="#tab_4" data-toggle="tab" aria-expanded="true">Email Settings</a></li>
                            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_4">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Horizontal Form -->
                                            <div class="box box-info">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Email Settings</h3>
                                                </div>
                                                <!-- /.box-header -->
                                                <!-- form start -->
                                                <form class="form-horizontal" method="post" action="{{ route('globalsettings.store') }}">
                                                    @csrf
                                                    <div class="box-body">

                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">Paypal email</label>
                                                            <div class="col-sm-12">
                                                                <?php $st_paypal_email = ""; ?>
                                                                @isset($settings_array['st_paypal_email'])
                                                                    <?php $st_paypal_email = $settings_array['st_paypal_email']; ?>
                                                                @endisset
                                                                <input type="email" class="form-control" name="option_name[st_paypal_email]" value="{{$st_paypal_email}}" required>                                                        </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">Admin Name</label>
                                                            <div class="col-sm-12">
                                                                <?php $st_admin_name = ""; ?>
                                                                @isset($settings_array['st_admin_name'])
                                                                    <?php $st_admin_name = $settings_array['st_admin_name']; ?>
                                                                @endisset
                                                                <input type="text" class="form-control" name="option_name[st_admin_name]" value="{{$st_admin_name}}" required>                                                        </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">New Booking Subject</label>
                                                            <div class="col-sm-12">
                                                                <?php $st_new_booking_subject = ""; ?>
                                                                @isset($settings_array['st_new_booking_subject'])
                                                                    <?php $st_new_booking_subject = $settings_array['st_new_booking_subject']; ?>
                                                                @endisset
                                                                <input type="text" class="form-control" name="option_name[st_new_booking_subject]" value="{{$st_new_booking_subject}}" required>                                                        </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">Edit Booking Subject</label>
                                                            <div class="col-sm-12">
                                                                <?php $st_edit_booking_subject = ""; ?>
                                                                @isset($settings_array['st_edit_booking_subject'])
                                                                    <?php $st_edit_booking_subject = $settings_array['st_edit_booking_subject']; ?>
                                                                @endisset
                                                                <input type="text" class="form-control" name="option_name[st_edit_booking_subject]" value="{{$st_edit_booking_subject}}" required>                                                        </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">Admin From Email</label>
                                                            <div class="col-sm-12">
                                                                <?php $st_admin_from_email = ""; ?>
                                                                @isset($settings_array['st_admin_from_email'])
                                                                    <?php $st_admin_from_email = $settings_array['st_admin_from_email']; ?>
                                                                @endisset
                                                                <input type="text" class="form-control" name="option_name[st_admin_from_email]" value="{{$st_admin_from_email}}" required>                                                        </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">Admin Email [New Booking]</label>
                                                            <div class="col-sm-12">
                                                                <?php $st_admin_email = ""; ?>
                                                                @isset($settings_array['st_admin_email'])
                                                                    <?php $st_admin_email = $settings_array['st_admin_email']; ?>
                                                                @endisset
                                                                <input type="text" class="form-control" name="option_name[st_admin_email]" value="{{$st_admin_email}}" required>                                                        </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">Notification Emails ( use ; as separator for multiple email ) [after booking confirmation]</label>
                                                            <div class="col-sm-12">
                                                                <?php $st_notification_email = ""; ?>
                                                                @isset($settings_array['st_notification_email'])
                                                                    <?php $st_notification_email = $settings_array['st_notification_email']; ?>
                                                                @endisset
                                                                <input type="text" class="form-control" name="option_name[st_notification_email]" value="{{$st_notification_email}}" required>                                                        </div>
                                                        </div>

                                                    <!-- /.box-body -->
                                                    <div class="box-footer">
                                                        <button type="submit" class="btn btn-block btn-success pull-right">Save</button>
                                                    </div>
                                                    <!-- /.box-footer -->
                                                </form>
                                            </div>
                                            <!-- /.box -->
                                        </div>
                                    </div>
                                </section>
                            </div>

                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                    </section>
                </div>

            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
