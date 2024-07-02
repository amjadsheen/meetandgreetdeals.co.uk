@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$title}}
                <small>Booking - {{$title}}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">{{$title}}</li>
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
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add New Currency</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('currencies.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-2">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" placeholder="Name" name="cur_name" required>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Code:</label>
                                    <input type="text" class="form-control" placeholder="Code" name="cur_code" required>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Symbol:</label>
                                    <input type="text" class="form-control" placeholder="Symbol" name="cur_symbol" required>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Rate:</label>
                                    <input type="text" class="form-control" placeholder="Rate" name="cur_rate" required>
                                </div>
                                <div class="form-group col-sm-2 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add Currency</button>
                                </div>

                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Currencies</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Symbol</th>
                                    <th>Rate</th>
                                    <th>cur_sort</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>
                                @foreach($currencies as $currency)
                                    <tr id="row-{{$currency->id}}">
                                        <td>{{$loop->iteration}}</td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="cur_name"
                                               data-url="{{route('currencies/updateinline', ['id'=>$currency->id])}}"
                                               data-pk="{{$currency->id}}" data-title="change"
                                               data-name="cur_name">{{$currency->cur_name}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="cur_code"
                                               data-url="{{route('currencies/updateinline', ['id'=>$currency->id])}}"
                                               data-pk="{{$currency->id}}" data-title="change"
                                               data-name="cur_code">{{$currency->cur_code}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="cur_symbol"
                                               data-url="{{route('currencies/updateinline', ['id'=>$currency->id])}}"
                                               data-pk="{{$currency->id}}" data-title="change"
                                               data-name="cur_symbol">{{$currency->cur_symbol}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="cur_rate"
                                               data-url="{{route('currencies/updateinline', ['id'=>$currency->id])}}"
                                               data-pk="{{$currency->id}}" data-title="change"
                                               data-name="cur_rate">{{$currency->cur_rate}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="cur_sort"
                                               data-url="{{route('currencies/updateinline', ['id'=>$currency->id])}}"
                                               data-pk="{{$currency->id}}" data-title="change"
                                               data-name="cur_sort">{{$currency->cur_sort}}
                                            </a>
                                        </td>

                                        <td>
                                            @if($currency->cur_disable == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":0,"text":"open"},{"value":1,"text":"close"}]' data-column="cur_disable"
                                                     data-url="{{route('currencies/updateinline', ['id'=>$currency->id])}}" data-pk="{{$currency->id}}"
                                                     data-title="change" data-name="cur_disable">close
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":1,"text":"close"},{"value":0,"text":"open"}]' data-column="cur_disable"
                                                 data-url="{{route('currencies/updateinline', ['id'=>$currency->id])}}" data-pk="{{$currency->id}}"
                                                 data-title="change" data-name="cur_disable">open
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('currencies/delete', ['id'=>$currency->id])}}" data-id="{{ $currency->id }}" >Delete</button>
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


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
