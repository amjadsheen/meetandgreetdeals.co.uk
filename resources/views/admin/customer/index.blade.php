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
                <li class="active">{{$title}}</li>
            </ol>
        </section>


        <section class="content">
            <div class="row">
                <div class="col-md-12">

                    <div class="nav-tabs-custom" id="tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#registered" data-toggle="tab" aria-expanded="true">Registered Customers</a>
                            </li>
                            <li class="">
                                <a href="#oneoff" data-toggle="tab" aria-expanded="false">OneOff</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="registered">
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-12">
                                        <!-- /.box-header -->
                                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                                        <div class="box-body" style="overflow-x:auto;">
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th style="width: 200px;">Name</th>
                                                    <th>SurName</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Company</th>
                                                    <th>Cell#</th>
                                                    {{--                                    <th>Home</th>--}}
                                                    {{--                                    <th>Address</th>--}}
                                                    {{--                                    <th>Town</th>--}}
                                                    {{--                                    <th>County</th>--}}
                                                    {{--                                    <th>Postcode</th>--}}
                                                    {{--                                    <th>Country</th>--}}
                                                    <th>OneOFF</th>
                                                    <th>view</th>
                                                    {{--                                    <th>Status</th>--}}
                                                </tr>
                                                @foreach($customers_registered as $customer)
                                                    <tr id="row-{{$customer->id}}">
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$customer->cus_title}}</td>
                                                        <td>{{$customer->cus_name}}</td>
                                                        <td>{{$customer->cus_surname}}</td>
                                                        <td>{{$customer->cus_email}}<br>{{$customer->cus_email_1}}</td>
                                                        <td>{{$customer->cus_company}}</td>
                                                        <td>{{$customer->cus_tele}}</td>
                                                        <td>{{$customer->cus_cell}}<br>{{$customer->cus_cell2}}</td>
                                                        <td>
                                                            @if($customer->cus_oneoff == 1)
                                                                Yes
                                                            @else
                                                                No
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button data-url="{{route('customers/getcustomer', ['id'=>$customer->id])}}"  data-id="{{ $customer->id }}" type="button" class="btn btn-primary label-success customerdetails">
                                                                View Details
                                                            </button>
                                                        </td>
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
                            <div class="tab-pane " id="oneoff">
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-12">
                                        <!-- /.box-header -->
                                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                                        <div class="box-body" style="overflow-x:auto;">
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th style="width: 200px;">Name</th>
                                                    <th>SurName</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Company</th>
                                                    <th>Cell#</th>
                                                    <th>OneOFF</th>
                                                    <th>view</th>
                                                </tr>
                                                @foreach($customers_oneoff as $customer)
                                                    <tr id="row-{{$customer->id}}">
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$customer->cus_title}}</td>
                                                        <td>{{$customer->cus_name}}</td>
                                                        <td>{{$customer->cus_surname}}</td>
                                                        <td>{{$customer->cus_email}}<br>{{$customer->cus_email_1}}</td>
                                                        <td>{{$customer->cus_company}}</td>
                                                        <td>{{$customer->cus_tele}}</td>
                                                        <td>{{$customer->cus_cell}}<br>{{$customer->cus_cell2}}</td>
                                                        <td>
                                                            @if($customer->cus_oneoff == 1)
                                                                Yes
                                                            @else
                                                                No
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button data-url="{{route('customers/getcustomer', ['id'=>$customer->id])}}"  data-id="{{ $customer->id }}" type="button" class="btn btn-primary label-success customerdetails">
                                                                View Details
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </section>


    </div>
    <div id="classModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <h4 class="modal-title" id="classModalLabel">
                        Customer Details
                    </h4>
                </div>
                <div class="modal-body" id="CustomerTableRes">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
