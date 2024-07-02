@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$title}}
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">{{$title}}s</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-warning">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form  action="{{route('agentreports.index')}}">
                                <div class="form-group col-sm-2">
                                    <label>Booking Ref:</label>
                                    <input type="text" class="form-control" id="agent_booking_ref" name="agent_booking_ref" value="{{$agent_booking_ref}}">
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Agent:</label>
                                    <select class="form-control" id="cagent" name="cagent">
                                        <option value="0">Select Agent</option>
                                        <option {{($cagent == 0) ? 'selected':'' }} value="0">Eden</option>
                                        @foreach($agents_ss as $key=>$agent)
                                            <option {{($cagent ==$key) ? 'selected':'' }}  value="{{$key}}">{{$agent}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            <div class="form-group col-sm-2">
                                <label>Start Date:</label>
                                <input type="date" class="form-control " id="start_date" name="start_date"
                                       value="{{$start_date}}" >
                            </div>
                                <div class="form-group col-sm-2">
                                    <label>End Date:</label>
                                    <input type="date" class="form-control " id="end_date" name="end_date"
                                           value="{{$end_date}}" >
                                </div>
                            <div class="form-group col-sm-2 topmargin20">
                                <input type="submit" class=" btn btn-primary "
                                       value="Filter">
                                <a href="{{route('agentreports.index')}}" class=" btn btn-primary ">Reset</a>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom" id="tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#agt" style="background: #fae3e3d1;" data-toggle="tab"  aria-expanded="true">Agents </a>
                            </li>
                            <li class="">
                                <a href="#fagt" style="background: #fae3e3d1;"  data-toggle="tab" aria-expanded="false"> Fwd Agents </a>
                            </li>
                            <li class="">
                                <a style="color: darkred">
                                    Showing Results For Dates Between {{$start_date}} ----- and -----  {{$end_date}}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="agt">
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-12">
                                        <!-- /.box-header -->
                                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Website</th>
                                                    <th>Date:</th>
                                                    <th>Customer</th>
                                                    <th>Booking Reference:</th>
                                                    <th>Vehicle registration #</th>
                                                    <th>Drop off date/time</th>
                                                    <th>Pickup date/time:</th>
                                                    <th>Main Agent</th>
                                                    <th>Forwarded Agent</th>
                                                    <th>Total amount</th>
                                                    <th>Commission | Fee</th>
                                                    <th>Discount amount</th>
                                                </tr>
                                                <?php
                                                $Total = 0;
                                                $C_Total = 0;
                                                ?>
                                                @foreach($bookings_agt as $booking)
                                                    <?php
                                                    $C_Total =  $booking->C_Total;
                                                    $Total =  $booking->agt_final_bk_total;
                                                    if($booking->checkin_status == 0 && $booking->checkout_status == 0){
                                                        $bg_color = "background:red; color:#fff";
                                                    }else if($booking->checkin_status == 1 && $booking->checkout_status == 0){
                                                        $bg_color = "background:yellow; color:#0f0202";
                                                    }else if($booking->checkin_status == 1 && $booking->checkout_status == 1){
                                                        $bg_color = "background:greenyellow; color:#0f0202";
                                                    }
                                                    ?>
                                                    <tr style="{{$bg_color}}">
                                                        <td style="width: 10px">{{$loop->iteration}}</td>
                                                        <td>{{$booking->website_name}} </td>
                                                        <td>{{$booking->bk_date}}</td>
                                                        <td>{{$booking->cus_title}} {{$booking->cus_name}} {{$booking->cus_surname}}</td>
                                                        <td>{{$booking->bk_ref}}</td>
                                                        <td>{{$booking->bk_re_nu}}</td>
                                                        <td>{{$booking->bk_ve_do_dt}}</td>
                                                        <td>{{$booking->bk_ve_pu_dt}}</td>
                                                        <td>{{$booking->agt1_company}}</td>
                                                        <td>{{$booking->fagt_company}}</td>
                                                        <td>{{$booking->bk_total_amount}}</td>
                                                        <td>{{$booking->agt_commision}} | {{$booking->agt_fee}} = ( {{$booking->agt_commision_plus_fee}} %)</td>
                                                        <td>{{$booking->agt_commision_final}}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td  class="totalllll" colspan='12' style='text-align: right'>Total:</td>
                                                    <td><?php echo $Total; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan='12' style='text-align: right'>Total with Comisson:</td>
                                                    <td><?php echo $C_Total; ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="fagt">
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-12">
                                        <!-- /.box-header -->
                                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Website</th>
                                                    <th>Date:</th>
                                                    <th>Customer</th>
                                                    <th>Booking Reference:</th>
                                                    <th>Vehicle registration #</th>
                                                    <th>Drop off date/time</th>
                                                    <th>Pickup date/time:</th>
                                                    <th>Main Agent</th>
                                                    <th>Forwarded Agent</th>
                                                    <th>Total amount</th>
                                                    <th>Commission | Fee</th>
                                                    <th>Discount amount</th>
                                                </tr>
                                                @foreach($bookings_fagt as $booking)
                                                    <?php

                                                    $C_Total =  $booking->C_Total;
                                                    $Total =  $booking->agt_final_bk_total;
                                                    if($booking->checkin_status == 0 && $booking->checkout_status == 0){
                                                        $bg_color = "background:red; color:#fff";
                                                    }else if($booking->checkin_status == 1 && $booking->checkout_status == 0){
                                                        $bg_color = "background:yellow; color:#0f0202";
                                                    }else if($booking->checkin_status == 1 && $booking->checkout_status == 1){
                                                        $bg_color = "background:greenyellow; color:#0f0202";
                                                    }
                                                    ?>
                                                    <tr style="{{$bg_color}}">
                                                        <td style="width: 10px">{{$loop->iteration}}</td>
                                                        <td>{{$booking->website_name}} </td>
                                                        <td>{{$booking->bk_date}}</td>
                                                        <td>{{$booking->cus_title}} {{$booking->cus_name}} {{$booking->cus_surname}}</td>
                                                        <td>{{$booking->bk_ref}}</td>
                                                        <td>{{$booking->bk_re_nu}}</td>
                                                        <td>{{$booking->bk_ve_do_dt}}</td>
                                                        <td>{{$booking->bk_ve_pu_dt}}</td>
                                                        <td>{{$booking->agt1_company}}</td>
                                                        <td>{{$booking->fagt_company}}</td>
                                                        <td>{{$booking->bk_total_amount}}</td>
                                                        <td>{{$booking->agt_commision}} | {{$booking->agt_fee}} = ( {{$booking->agt_commision_plus_fee}} %)</td>
                                                        <td>{{$booking->agt_commision_final}}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan='12' style='text-align: right'>Total:</td>
                                                    <td><?php echo $Total; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan='12' style='text-align: right'>Total with Comisson:</td>
                                                    <td><?php echo $C_Total; ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
