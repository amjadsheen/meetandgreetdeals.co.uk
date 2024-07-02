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
                            <form  action="{{route('checkinout.index')}}">
                            <div class="form-group col-sm-2">
                                <label>Booking ref:</label>
                                <input type="text" class="form-control" placeholder="Code" name="ref"
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
                                <label>Date:</label>
                                <input type="text" class="form-control datepicker" id="hrs" name="hrs"
                                       value="{{$hrs}}">
                            </div>
                            <div class="form-group col-sm-2 topmargin20">
                                <input type="submit" class=" btn btn-primary " onclick="refreshDatackinout();"
                                       value="Search">
                                <a href="{{route('checkinout.index')}}" class=" btn btn-primary ">Reset</a>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom" id="tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#ckin_out" data-toggle="tab" aria-expanded="true">Checkin/Checkout</a>
                            </li>
                            <li class="">
                                <a href="#ckin" data-toggle="tab"  aria-expanded="false">Checkin</a>
                            </li>
                            <li class="">
                                <a href="#ckout" data-toggle="tab" aria-expanded="false">Checkout</a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="ckin_out">
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
                                                        <th>Order date</th>
                                                        <th>Customer name</th>
                                                        <th>Booking ref.</th>
                                                        <th>Color</th>
                                                        <th>Arr. date/time</th>
                                                        <th>Airport</th>
                                                        <th>Cin Terminal</th>
                                                        <th>Cout Terminal</th>
                                                        <th>Reg. number	</th>
                                                        <th>Flight number</th>
                                                        <th>Check In date/time</th>
                                                        <th>Check out date/time</th>
                                                    </tr>
                                                    @foreach($bookings as $booking)
                                                    <tr>
                                                        <td style="width: 10px">{{$loop->iteration}}</td>
                                                        <td>{{$booking->website_name}}</td>
                                                        <td>{{$booking->bk_date}}</td>
                                                        <td>{{$booking->cus_name}} {{$booking->cus_surname}}</td>
                                                        <td>{{$booking->bk_ref}}</td>
                                                        <td>{{$booking->clr_name}}</td>
                                                        <td>{{$booking->bk_to_date}}</td>
                                                        <td>{{$booking->airport_name}}</td>
                                                        <td>{{$booking->ci_ter_name}}</td>
                                                        <td>{{$booking->co_ter_name}}</td>
                                                        <td>{{$booking->bk_re_nu}}</td>
                                                        <td>{{$booking->bk_re_fl_nu}}</td>
                                                        <td style="background-color: yellow">{{$booking->cindatetime}}</td>
                                                        <td style="background-color: greenyellow">{{$booking->coutdatetime}}</td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane " id="ckin">
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
                                                    <th>Order date</th>
                                                    <th>Customer name</th>
                                                    <th>Booking ref.</th>
                                                    <th>Color</th>
                                                    <th>Arr. date/time</th>
                                                    <th>Airport</th>
                                                    <th>Terminal</th>
                                                    <th>Reg. number	</th>
                                                    <th>Flight number</th>
                                                    <th>Check In date/time</th>
                                                </tr>
                                                @foreach($bookings_in as $booking)
                                                    <tr>
                                                        <td style="width: 10px">{{$loop->iteration}}</td>
                                                        <td>{{$booking->website_name}}</td>
                                                        <td>{{$booking->bk_date}}</td>
                                                        <td>{{$booking->cus_name}} {{$booking->cus_surname}}</td>
                                                        <td>{{$booking->bk_ref}}</td>
                                                        <td>{{$booking->clr_name}}</td>
                                                        <td>{{$booking->bk_to_date}}</td>
                                                        <td>{{$booking->airport_name}}</td>
                                                        <td>{{$booking->ci_ter_name}}</td>
                                                        <td>{{$booking->bk_re_nu}}</td>
                                                        <td>{{$booking->bk_re_fl_nu}}</td>
                                                        <td style="background-color: yellow">{{$booking->cindatetime}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="ckout">
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
                                                    <th>Order date</th>
                                                    <th>Customer name</th>
                                                    <th>Booking ref.</th>
                                                    <th>Color</th>
                                                    <th>Arr. date/time</th>
                                                    <th>Airport</th>
                                                    <th>Terminal</th>
                                                    <th>Reg. number	</th>
                                                    <th>Flight number</th>
                                                    <th>Check out date/time</th>
                                                </tr>
                                                @foreach($bookings_out as $booking)
                                                    <tr>
                                                        <td style="width: 10px">{{$loop->iteration}}</td>
                                                        <td>{{$booking->website_name}}</td>
                                                        <td>{{$booking->bk_date}}</td>
                                                        <td>{{$booking->cus_name}} {{$booking->cus_surname}}</td>
                                                        <td>{{$booking->bk_ref}}</td>
                                                        <td>{{$booking->clr_name}}</td>
                                                        <td>{{$booking->bk_to_date}}</td>
                                                        <td>{{$booking->airport_name}}</td>
                                                        <td>{{$booking->co_ter_name}}</td>
                                                        <td>{{$booking->bk_re_nu}}</td>
                                                        <td>{{$booking->bk_re_fl_nu}}</td>
                                                        <td style="background-color: greenyellow">{{$booking->coutdatetime}}</td>
                                                    </tr>
                                                @endforeach
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
