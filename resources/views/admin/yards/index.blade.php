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
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-check"></i>{{ session()->get('success') }}
                        </div>
                    @endif
                    @if(session()->get('warning'))
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-warning"></i>{{ session()->get('warning') }}
                        </div>
                    @endif
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add New {{$title}}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('yards.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Select Airport:</label>
                                   <select class="form-control" name="airport_id" required>
                                       <option value="">Select</option>
                                       @foreach($airports as $airport)
                                           <option value="{{$airport->id}}">{{$airport->airport_name}}</option>
                                       @endforeach
                                   </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Yard Name:</label>
                                    <input type="text" class="form-control" name="yrd_name" required>
                                </div>
                                <div class="form-group col-sm-2 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add {{$title}}</button>
                                </div>

                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- left column -->
                @foreach($yards as $key=>$yard)
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$key}} - ( {{$title}} )</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>
                                @foreach($yard as $s_yard)
                                    <tr id="row-{{$s_yard->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="yrd_name"
                                               data-url="{{route('yards/updateinline', ['id'=>$s_yard->id])}}"
                                               data-pk="{{$s_yard->id}}" data-title="change"
                                               data-name="yrd_name">{{$s_yard->yrd_name}}
                                            </a>
                                        </td>

                                        <td>
                                            @if($s_yard->yrd_disable == 1)
                                                <a class="testEdit" data-type="select"
                                                   data-source='[{"value":1,"text":"disable"},{"value":0,"text":"enable"}]' data-column="yrd_disable"
                                                   data-url="{{route('yards/updateinline', ['id'=>$s_yard->id])}}" data-pk="{{$s_yard->id}}"
                                                   data-title="change" data-name="yrd_disable">disabled
                                                </a>
                                            @else
                                                <a class="testEdit" data-type="select"
                                                   data-source='[{"value":0,"text":"enable"},{"value":1,"text":"disable"}]' data-column="yrd_disable"
                                                   data-url="{{route('yards/updateinline', ['id'=>$s_yard->id])}}" data-pk="{{$s_yard->id}}"
                                                   data-title="change" data-name="yrd_disable">enabled
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('yards/delete', ['id'=>$s_yard->id])}}" data-id="{{ $s_yard->id }}" >Delete</button>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                @endforeach

            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
