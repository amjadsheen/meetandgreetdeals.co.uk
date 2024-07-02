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
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <div class="box box-warning">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">SELECT WEBSITE</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <form role="form" action="{{ route('settings.index') }}">
                                            <div class="form-group">
                                                <select name="filter_website" class="form-control" onchange="this.form.submit()">
                                                    @foreach($websites as $website)
                                                        <option {{($filter_website == $website->id) ? 'selected':'' }} value="{{$website->id}}">{{$website->website_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">NOT WORKING HOURS</a></li>
                            <li><a href="#tab_2" data-toggle="tab" aria-expanded="false">CAR WASH</a></li>                            <li ><a href="#tab_4" data-toggle="tab" aria-expanded="false">PROMO BOX</a></li>
                            <li><a href="#tab_6" data-toggle="tab" aria-expanded="false">LAST MINUTES BOOKING</a></li>
                            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <section class="content">
                                    <div class="row">
                                <div class="col-md-12">
                                    <!-- Horizontal Form -->
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Not Working Hours</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                            <form class="form-horizontal" method="post" action="{{ route('settings.store') }}">
                                                @csrf
                                            <div class="box-body">
                                                <table class="table">
                                                    <tr><th>Start Time</th><th>End Time</th><th>Price</th></tr>
                                                @foreach($nwhrs as $nhr)

                                                   <tr>
                                                    <td>
                                                    <a class="testEdit" data-type="text" data-column="not_working_start_time"
                                                    data-url="{{route('settings/updateinline', ['id'=>$nhr->id])}}"
                                                    data-pk="{{$nhr->id}}" data-title="change"
                                                    data-name="not_working_start_time">{{$nhr->not_working_start_time}}
                                                    </a>
                                                    </td>
                                                    <td>
                                                    <a class="testEdit" data-type="text" data-column="not_working_end_time"
                                                    data-url="{{route('settings/updateinline', ['id'=>$nhr->id])}}"
                                                    data-pk="{{$nhr->id}}" data-title="change"
                                                    data-name="not_working_end_time">{{$nhr->not_working_end_time}}
                                                    </a>
                                                    </td>
                                                    <td> 
                                                    <a class="testEdit" data-type="text" data-column="charges"
                                                    data-url="{{route('settings/updateinline', ['id'=>$nhr->id])}}"
                                                    data-pk="{{$nhr->id}}" data-title="change"
                                                    data-name="charges">{{$nhr->charges}}
                                                    </a>
                                                    </td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                        </form>
                                    </div>
                                    <!-- /.box -->
                                </div>
                                    </div>
                                </section>
                            </div>
                            <div class="tab-pane" id="tab_6">
                                <section class="content">
                                    <div class="row">
                                <div class="col-md-12">
                                    <!-- Horizontal Form -->
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">LAST MINUTES BOOKING</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                            <form class="form-horizontal" method="post" action="{{ route('settings.store') }}">
                                                @csrf
                                            <div class="box-body">
                                                <table class="table">
                                                    <tr><th>Hour</th><th>Price</th></tr>
                                                @foreach($lmb as $nhr)

                                                   <tr>
                                                    <td>
                                                    <a class="testEdit" data-type="text" data-column="hour"
                                                    data-url="{{route('settings/updateinline_lastminutebookings', ['id'=>$nhr->id])}}"
                                                    data-pk="{{$nhr->id}}" data-title="change"
                                                    data-name="hour">{{$nhr->hour}}
                                                    </a>
                                                    </td>
                                                    <td>
                                                    <a class="testEdit" data-type="text" data-column="charges"
                                                    data-url="{{route('settings/updateinline_lastminutebookings', ['id'=>$nhr->id])}}"
                                                    data-pk="{{$nhr->id}}" data-title="change"
                                                    data-name="charges">{{$nhr->charges}}
                                                    </a>
                                                    </td>
                                                    
                                                    </tr>
                                                @endforeach
                                                </table>
                                        </form>
                                    </div>
                                    <!-- /.box -->
                                </div>
                                    </div>
                                </section>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Horizontal Form -->
                                            <div class="box box-info">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Car Wash</h3>
                                                </div>
                                                <!-- /.box-header -->
                                                <!-- form start -->
                                                <form class="form-horizontal" method="post" action="{{ route('settings.store') }}">
                                                    @csrf
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">FULL CAR WASH (IN AND OUT) </label>
                                                            <div class="col-sm-6">
                                                                <input type="number" min="0" class="form-control speciald"   value="<?php echo $settings_array['carwash_in_and_out']?>" name="option_name[{{$filter_website}}][carwash_in_and_out]" autocomplete="off" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">CAR WASH (ONLY OUTSIDE)</label>
                                                            <div class="col-sm-6">
                                                                <input type="number" min="0" class="form-control speciald"   value="<?php echo $settings_array['carwash_out_only']?>" name="option_name[{{$filter_website}}][carwash_out_only]" autocomplete="off" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">CAR WASH (WATER SPRAY ONLY)</label>
                                                            <div class="col-sm-6">
                                                                <input type="number" min="0" class="form-control speciald"   value="<?php echo $settings_array['carwash_spray']?>" name="option_name[{{$filter_website}}][carwash_spray]" autocomplete="off" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">Show Carwash BOX</label>
                                                            <div class="col-sm-6">
                                                                <select class="form-control speciald" name="option_name[{{$filter_website}}][carwash_box]">
                                                                    <option value="0" <?php if ($settings_array['carwash_box'] == "0") {echo "selected";} ?>>No</option>
                                                                    <option value="1" <?php if ($settings_array['carwash_box'] == "1") {echo "selected";} ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
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

                            

                            
                            
                            <div class="tab-pane" id="tab_4">
                                <section class="content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Horizontal Form -->
                                            <div class="box box-info">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">EDEN PROMO BOX</h3>
                                                </div>
                                                <!-- /.box-header -->
                                                <!-- form start -->
                                                <form class="form-horizontal" method="post" action="{{ route('settings.store') }}">
                                                    @csrf
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" left col-sm-6 control-label">HIDE EDEN PROMO BOX </label>
                                                            <div class="col-sm-6">
                                                                <select class="form-control speciald" style="width: 200px;" name="option_name[{{$filter_website}}][eden_promo_box]">
                                                                    <?php if(isset($settings_array['eden_promo_box'])) { ?>
                                                                        <option value="0" <?php if ($settings_array['eden_promo_box'] == "0") {echo "selected";} ?>>No</option>
                                                                        <option value="1" <?php if ($settings_array['eden_promo_box'] == "1") {echo "selected";} ?>>Yes</option>
                                                                    <?php } else { ?>
                                                                        <option value="1">No</option>
                                                                        <option value="0" selected >Yes</option>
                                                                    <?php } ?>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
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
