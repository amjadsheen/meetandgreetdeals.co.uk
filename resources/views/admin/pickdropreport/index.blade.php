@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <style>
        td {
            font-size: 12px;
        }
        @media print {
            body {-webkit-print-color-adjust: exact;}
            tr.c-yellow{
                background-color: yellow !important;;
                color: #FF0000;
            }
            c-#FF0000{
                background-color: #FF0000 !important;
                color: #FFFFFF;
            }
        }

    </style>
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
                            <form  action="{{route('pickdrop.index')}}">
                            <div class="form-group col-sm-2">
                                <label>Booking ref:</label>
                                <input type="text" class="form-control"  name="ref"
                                       id="ref" value="{{$ref}}">
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Terminal:</label>
                                <select class="form-control" id="terminal" name="terminal">
                                    <option value="">All Terminal</option>
                                    @foreach($terminals_json as $terminals)
                                        <option
                                            {{($terminal == $terminals['value']) ? 'selected':'' }}  value="{{$terminals['value']}}">{{$terminals['text']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label>Start Date:</label>
                                <input type="text" class="form-control datepicker" id="start_date" name="start_date"
                                       value="{{$start_date}}" readonly>
                            </div>
                                <div class="form-group col-sm-2">
                                    <label>End Date:</label>
                                    <input type="text" class="form-control datepicker" id="end_date" name="end_date"
                                           value="{{$end_date}}" readonly>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Hilight hours:</label>
                                    <input type="text" class="form-control" id="highlight" name="highlight"
                                           value="{{$highlight}}">
                                </div>
                            <div class="form-group col-sm-2 topmargin20">
                                <input type="submit" class=" btn btn-primary "
                                       value="Filter">
                                <a href="{{route('pickdrop.index')}}" class=" btn btn-primary ">Reset</a>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom" id="tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#arrdep" data-toggle="tab" aria-expanded="true"> Arrivals / Departures </a>
                            </li>
                            <li class="">
                                <a href="#arrival" data-toggle="tab"  aria-expanded="false"> Arrivals </a>
                            </li>
                            <li class="">
                                <a href="#departures" data-toggle="tab" aria-expanded="false"> Departures </a>
                            </li>
                            <li class="">
                                <a style="color: darkred">
                                    Showing Results For Dates Between {{date('d/m/Y', strtotime($start_date))}} ----- and -----  {{date('d/m/Y', strtotime($end_date))}}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="arrdep">
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-12">
                                        <!-- .box -->
                                        <div class="box">
                                            <div class="box-header with-border" style="background: yellow; text-align: center;">
                                                <h3 class="box-title">Arrivals </h3>
                                                <div class="box-tools pull-right">
                                                    <!-- Buttons, labels, and many other things can be placed here! -->
                                                    <!-- Here is a label for example -->
                                                    <span class="label label-primary"> <button class="btn btn-default btn-xs" onclick="printDiv('arrdep')">Print</button></span>
                                                </div>
                                                <!-- /.box-tools -->
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">
                                                <div class="box-body">
                                                    <table class="table table-bordered" id="arrivalb">
                                                        <tbody>
                                                        <tr>
                                                            <th style="width: 10px">#</th>
                                                            <th>Website</th>
                                                            <th>Order date</th>
                                                            {{--                                                    <th>BkStatus</th>--}}
                                                            <th>Customer name</th>
                                                            <th>Booking ref.</th>
                                                            <th>Color</th>
                                                            <th>Airport</th>
                                                            <th>Agent</th>
                                                            <th>Fwd Agent</th>
                                                            <th>O Terminal</th>
                                                            <th>I Terminal</th>
                                                            <th>Reg. number	</th>
                                                            <th>Flight number</th>
                                                            <th>Veh.Pick Date/time</th>
                                                            {{--<th>Veh.Drop Date/time</th>--}}
                                                        </tr>
                                                        @foreach($bookings_arrivals as $booking)
                                                            <?php
                                                            $bgcolor = "";
                                                            $textcolor = "";
                                                            $trcolor = "";
                                                            $crdatetime = date("Y-m-d H:i:s");
                                                            $datetime36 = date("Y-m-d H:i:s", strtotime($booking->bk_to_dateh."-$highlight hour"));
                                                            //echo "<br />";
                                                            if ( (strtotime($crdatetime) >= strtotime($datetime36)) and (strtotime($crdatetime) <= strtotime($booking->bk_to_dateh)) ){
                                                                $bgcolor = "#FF0000"; // RED
                                                                $textcolor = "#FFFFFF"; //WHITE
                                                                $trcolor = "yellow";
                                                            }
                                                            ?>
                                                            <tr class="c-{{$trcolor}}" style="background-color: {{$trcolor}}; color: {{$bgcolor}}">
                                                                <td style="width: 10px">{{$loop->iteration}}</td>
                                                                <td>{{$booking->website_name}} </td>
                                                                <td>{{$booking->bk_date}}</td>
                                                                {{--                                                        <td>{{$booking->bk_status}} / {{$booking->bk_is_del}}</td>--}}
                                                                <td>{{$booking->cus_title}} {{$booking->cus_name}}</td>
                                                                <td>{{$booking->bk_ref}}</td>
                                                                <td>{{$booking->clr_name}}</td>
                                                                <td>{{$booking->airport_name}}</td>
                                                                <td>{{$booking->agt1_company}}</td>
                                                                <td>{{$booking->fagt_company}}</td>
                                                                <td>{{$booking->ter_name1}}</td>
                                                                <td>{{$booking->ter_name2}}</td>
                                                                <td>{{$booking->bk_re_nu}}</td>
                                                                <td>{{$booking->bk_re_fl_nu}}</td>
                                                                <td>{{$booking->bk_ve_pu_dt}}</td>
                                                                {{--  <td>{{$booking->bk_from_date}}</td>--}}
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box -->

                                        <!-- .box -->
                                        <div class="box">
                                            <div class="box-header with-border"  style="background: red; text-align: center;">
                                                <h3 class="box-title" style="color: #fff">Departures </h3>
                                                <div class="box-tools pull-right">
                                                    <!-- Buttons, labels, and many other things can be placed here! -->
                                                    <!-- Here is a label for example -->
                                                    <span class="label label-primary"> <button class="btn btn-default btn-xs" onclick="printDiv('arrdep')">Print</button></span>
                                                </div>
                                                <!-- /.box-tools -->
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">
                                                <div class="box-body">
                                                    <table class="table table-bordered" id="depb">
                                                        <tbody>
                                                        <tr>
                                                            <th style="width: 10px">#</th>
                                                            <th>Website</th>
                                                            <th>Order date</th>
                                                            {{--                                                    <th>BkStatus</th>--}}
                                                            <th>Customer name</th>
                                                            <th>Booking ref.</th>
                                                            <th>Color</th>
                                                            <th>Airport</th>
                                                            <th>Agent</th>
                                                            <th>Fwd Agent</th>
                                                            <th>O Terminal</th>
                                                            <th>I Terminal</th>
                                                            <th>Reg. number	</th>
                                                            <th>Flight number</th>
                                                            {{--<th>Veh.Pick Date/time</th>--}}
                                                            <th>Veh.Drop Date/time</th>
                                                        </tr>
                                                        @foreach($bookings_departures as $booking)
                                                            <?php
                                                            $bgcolor = "";
                                                            $textcolor = "";
                                                            $trcolor = "";
                                                            $crdatetime = date("Y-m-d H:i:s");
                                                            $datetime36 = date("Y-m-d H:i:s", strtotime($booking->bk_from_dateh."-$highlight hour"));
                                                            //echo "<br />";
                                                            if ( (strtotime($crdatetime) >= strtotime($datetime36)) and (strtotime($crdatetime) <= strtotime($booking->bk_from_dateh)) ){
                                                                $bgcolor = "#FFFFFF"; // RED
                                                                $textcolor = "#FFFFFF"; //WHITE
                                                                $trcolor = "#FF0000";
                                                            }
                                                            ?>
                                                            <tr class="c-{{$trcolor}}" style="background-color: {{$trcolor}}; color: {{$bgcolor}}">
                                                                <td style="width: 10px">{{$loop->iteration}}</td>
                                                                <td>{{$booking->website_name}} </td>
                                                                <td>{{$booking->bk_date}}</td>
                                                                {{--                                                        <td>{{$booking->bk_status}} / {{$booking->bk_is_del}}</td>--}}
                                                                <td>{{$booking->cus_title}} {{$booking->cus_name}}</td>
                                                                <td>{{$booking->bk_ref}}</td>
                                                                <td>{{$booking->clr_name}}</td>
                                                                <td>{{$booking->airport_name}}</td>
                                                                <td>{{$booking->agt1_company}}</td>
                                                                <td>{{$booking->fagt_company}}</td>
                                                                <td>{{$booking->ter_name1}}</td>
                                                                <td>{{$booking->ter_name2}}</td>
                                                                <td>{{$booking->bk_re_nu}}</td>
                                                                <td>{{$booking->bk_re_fl_nu}}</td>
                                                                {{--<td>{{$booking->bk_to_date}}</td>--}}
                                                                <td style="">{{$booking->bk_ve_do_dt}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box -->

                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane " id="arrival">
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-12">
                                        <!-- .box -->
                                        <div class="box">
                                            <div class="box-header with-border" style="background: yellow; text-align: center;">
                                                <h3 class="box-title">Arrivals </h3>
                                                <div class="box-tools pull-right">
                                                    <!-- Buttons, labels, and many other things can be placed here! -->
                                                    <!-- Here is a label for example -->
                                                    <span class="label label-primary"> <button class="btn btn-default btn-xs" onclick="printDiv('arrival')">Print</button></span>
                                                </div>
                                                <!-- /.box-tools -->
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">
                                                <div class="box-body">
                                                    <table class="table table-bordered" id="arrivalo">
                                                        <tbody>
                                                        <tr>
                                                            <th style="width: 10px">#</th>
                                                            <th>Website</th>
                                                            <th>Order date</th>
                                                            {{--                                                    <th>BkStatus</th>--}}
                                                            <th>Customer name</th>
                                                            <th>Booking ref.</th>
                                                            <th>Color</th>
                                                            <th>Airport</th>
                                                            <th>Agent</th>
                                                            <th>Fwd Agent</th>
                                                            <th>O Terminal</th>
                                                            <th>I Terminal</th>
                                                            <th>Reg. number	</th>
                                                            <th>Flight number</th>
                                                            <th>Veh.Pick Date/time</th>
                                                            {{--<th>Veh.Drop Date/time</th>--}}
                                                        </tr>
                                                        @foreach($bookings_arrivals as $booking)
                                                            <?php
                                                            $bgcolor = "";
                                                            $textcolor = "";
                                                            $trcolor = "";
                                                            $crdatetime = date("Y-m-d H:i:s");
                                                            $datetime36 = date("Y-m-d H:i:s", strtotime($booking->bk_to_dateh."-$highlight hour"));
                                                            //echo "<br />";
                                                            if ( (strtotime($crdatetime) >= strtotime($datetime36)) and (strtotime($crdatetime) <= strtotime($booking->bk_to_dateh)) ){
                                                                $bgcolor = "#FF0000"; // RED
                                                                $textcolor = "#FFFFFF"; //WHITE
                                                                $trcolor = "yellow";
                                                            }
                                                            ?>
                                                            <tr class="c-{{$trcolor}}" style="background-color: {{$trcolor}}; color: {{$bgcolor}}">
                                                                <td style="width: 10px">{{$loop->iteration}}</td>
                                                                <td>{{$booking->website_name}} </td>
                                                                <td>{{$booking->bk_date}}</td>
                                                                {{--                                                        <td>{{$booking->bk_status}} / {{$booking->bk_is_del}}</td>--}}
                                                                <td>{{$booking->cus_title}} {{$booking->cus_name}}</td>
                                                                <td>{{$booking->bk_ref}}</td>
                                                                <td>{{$booking->clr_name}}</td>
                                                                <td>{{$booking->airport_name}}</td>
                                                                <td>{{$booking->agt1_company}}</td>
                                                                <td>{{$booking->fagt_company}}</td>
                                                                <td>{{$booking->ter_name1}}</td>
                                                                <td>{{$booking->ter_name2}}</td>
                                                                <td>{{$booking->bk_re_nu}}</td>
                                                                <td>{{$booking->bk_re_fl_nu}}</td>
                                                                <td>{{$booking->bk_ve_pu_dt}}</td>
                                                                {{--  <td>{{$booking->bk_from_date}}</td>--}}
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="departures">
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-12">
                                        <!-- .box -->
                                        <div class="box">
                                            <div class="box-header with-border"  style="background: red; text-align: center;">
                                                <h3 class="box-title" style="color: #fff">Departures </h3>
                                                <div class="box-tools pull-right">
                                                    <!-- Buttons, labels, and many other things can be placed here! -->
                                                    <!-- Here is a label for example -->
                                                    <span class="label label-primary"> <button class="btn btn-default btn-xs" onclick="printDiv('departures')">Print</button></span>
                                                </div>
                                                <!-- /.box-tools -->
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">
                                                <div class="box-body">
                                                    <table class="table table-bordered" id="depto">
                                                        <tbody>
                                                        <tr>
                                                            <th style="width: 10px">#</th>
                                                            <th>Website</th>
                                                            <th>Order date</th>
                                                            {{--                                                    <th>BkStatus</th>--}}
                                                            <th>Customer name</th>
                                                            <th>Booking ref.</th>
                                                            <th>Color</th>
                                                            <th>Airport</th>
                                                            <th>Agent</th>
                                                            <th>Fwd Agent</th>
                                                            <th>O Terminal</th>
                                                            <th>I Terminal</th>
                                                            <th>Reg. number	</th>
                                                            <th>Flight number</th>
                                                            {{--<th>Veh.Pick Date/time</th>--}}
                                                            <th>Veh.Drop Date/time</th>
                                                        </tr>
                                                        @foreach($bookings_departures as $booking)
                                                            <?php
                                                            $bgcolor = "";
                                                            $textcolor = "";
                                                            $trcolor = "";
                                                            $crdatetime = date("Y-m-d H:i:s");
                                                            $datetime36 = date("Y-m-d H:i:s", strtotime($booking->bk_from_dateh."-$highlight hour"));
                                                            //echo "<br />";
                                                            if ( (strtotime($crdatetime) >= strtotime($datetime36)) and (strtotime($crdatetime) <= strtotime($booking->bk_from_dateh)) ){
                                                                $bgcolor = "#FFFFFF"; // RED
                                                                $textcolor = "#FFFFFF"; //WHITE
                                                                $trcolor = "#FF0000";
                                                            }
                                                            ?>
                                                            <tr class="c-{{$trcolor}}" style="background-color: {{$trcolor}}; color: {{$bgcolor}}">
                                                                <td style="width: 10px">{{$loop->iteration}}</td>
                                                                <td>{{$booking->website_name}} </td>
                                                                <td>{{$booking->bk_date}}</td>
                                                                {{--                                                        <td>{{$booking->bk_status}} / {{$booking->bk_is_del}}</td>--}}
                                                                <td>{{$booking->cus_title}} {{$booking->cus_name}}</td>
                                                                <td>{{$booking->bk_ref}}</td>
                                                                <td>{{$booking->clr_name}}</td>
                                                                <td>{{$booking->airport_name}}</td>
                                                                <td>{{$booking->agt1_company}}</td>
                                                                <td>{{$booking->fagt_company}}</td>
                                                                <td>{{$booking->ter_name1}}</td>
                                                                <td>{{$booking->ter_name2}}</td>
                                                                <td>{{$booking->bk_re_nu}}</td>
                                                                <td>{{$booking->bk_re_fl_nu}}</td>
                                                                {{--<td>{{$booking->bk_to_date}}</td>--}}
                                                                <td style="">{{$booking->bk_ve_do_dt}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box -->
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
