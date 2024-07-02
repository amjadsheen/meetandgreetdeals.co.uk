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
        <section class="content" id="print">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">List of vehicles over parked</h3>
                            <button class="btn btn-default btn-xs" onclick="printDiv('print')">Print</button>
                        </div>
                        <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Customer name</th>
                                <th>Booking ref.</th>
                                <th>Departure date/time</th>
                                <th>Airport</th>
                                <th>Terminal</th>
                                <th>Registration number</th>
                                <th>Fligh number</th>
                            </tr>
                            @foreach($bookings as $booking)

                                <tr>
                                    <td style="width: 10px">{{$loop->iteration}}</td>
                                    <td>{{$booking->cus_title}} {{$booking->cus_surname}}</td>
                                    <td>{{$booking->bk_ref}}</td>
                                    <td>{{$booking->bk_to_date}}</td>
                                    <td>{{$booking->airport_name}}</td>
                                    <td>{{$booking->ter_name2}}</td>
                                    <td>{{$booking->bk_re_nu}}</td>
                                    <td>{{$booking->bk_re_fl_nu}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    </div>
                </div>
            </div>
        </section>

    </div>
    <!-- /.content-wrapper -->
@endsection
