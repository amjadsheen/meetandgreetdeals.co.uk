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
                            <h3 class="box-title">Add New Terminal</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('terminal.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Airport *:</label>
                                    <select class="form-control"  name="airport_id" required>
                                        @foreach($airports as $airport)
                                        <option value="{{$airport->id}}">{{$airport->airport_name}}</option>
                                         @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Name *:</label>
                                    <input type="text" class="form-control" placeholder="Name" name="ter_name" required>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Cap *:</label>
                                    <input type="text" class="form-control" placeholder="Cap" name="ter_cap" required>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Interval (hours) *:</label>
                                    <input type="text" class="form-control" placeholder="interval" name="ter_interval" required>
                                </div>
                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add Terminal</button>
                                </div>

                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- left column -->
                @foreach($terminals as $key=>$single_terminal)
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Airport: {{$key}}</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Cap</th>
                                    <th>Interval (hours)</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>
                                @foreach($single_terminal as $terminal)
                                    <tr id="row-{{$terminal->id}}">
                                        <td>{{$loop->iteration}}</td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="ter_name"
                                               data-url="{{route('terminal/updateinline', ['id'=>$terminal->id])}}"
                                               data-pk="{{$terminal->id}}" data-title="change"
                                               data-name="ter_name">{{$terminal->ter_name}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="ter_cap"
                                               data-url="{{route('terminal/updateinline', ['id'=>$terminal->id])}}"
                                               data-pk="{{$terminal->id}}" data-title="change"
                                               data-name="ter_cap">{{$terminal->ter_cap}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="ter_interval"
                                               data-url="{{route('terminal/updateinline', ['id'=>$terminal->id])}}"
                                               data-pk="{{$terminal->id}}" data-title="change"
                                               data-name="ter_interval">{{$terminal->ter_interval}}
                                            </a>
                                        </td>
                                        <td>
                                            @if($terminal->ter_disable == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":0,"text":"open"},{"value":1,"text":"close"}]' data-column="ter_disable"
                                                     data-url="{{route('terminal/updateinline', ['id'=>$terminal->id])}}" data-pk="{{$terminal->id}}"
                                                     data-title="change" data-name="ter_disable">close
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":1,"text":"close"},{"value":0,"text":"open"}]' data-column="ter_disable"
                                                 data-url="{{route('terminal/updateinline', ['id'=>$terminal->id])}}" data-pk="{{$terminal->id}}"
                                                 data-title="change" data-name="ter_disable">open
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('terminal/delete', ['id'=>$terminal->id])}}" data-id="{{ $terminal->id }}" >Delete</button>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">

                        </div>
                    </div>
                </div>
                @endforeach
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
