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
                            <form method="post" action="{{ route('locations.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Select Airport:</label>
                                   <select class="form-control" id="airport_id"  onchange="get_yards(this);" required>
                                       <option value="">Select</option>
                                       @foreach($airports as $airport)
                                           <option value="{{$airport->id}}">{{$airport->airport_name}}</option>
                                       @endforeach
                                   </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Select Yard:</label>
                                    <select class="form-control" name="yard_id"  id="yard_id" required style="visibility: hidden">
                                        <option value="">Select</option>

                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Location Name:</label>
                                    <input type="text" class="form-control" name="loc_name" required>
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

                @foreach($locations as $key=>$location_airport)
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$key}} - ( {{$title}} )</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            @foreach($location_airport as $keyinner=>$location_yard)
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">{{$keyinner}}</h3>
                                    </div>

                                <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>
                                @foreach($location_yard as $s_location)
                                    <tr id="row-{{$s_location->loc_id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="loc_name"
                                               data-url="{{route('yards/updateinline', ['id'=>$s_location->loc_id])}}"
                                               data-pk="{{$s_location->loc_id}}" data-title="change"
                                               data-name="loc_name">{{$s_location->loc_name}}
                                            </a>
                                        </td>

                                        <td>
                                            @if($s_location->loc_disable == 1)
                                                <a class="testEdit" data-type="select"
                                                   data-source='[{"value":1,"text":"disable"},{"value":0,"text":"enable"}]' data-column="loc_disable"
                                                   data-url="{{route('locations/updateinline', ['id'=>$s_location->loc_id])}}" data-pk="{{$s_location->loc_id}}"
                                                   data-title="change" data-name="loc_disable">disabled
                                                </a>
                                            @else
                                                <a class="testEdit" data-type="select"
                                                   data-source='[{"value":0,"text":"enable"},{"value":1,"text":"disable"}]' data-column="loc_disable"
                                                   data-url="{{route('locations/updateinline', ['id'=>$s_location->loc_id])}}" data-pk="{{$s_location->loc_id}}"
                                                   data-title="change" data-name="loc_disable">enabled
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('locations/delete', ['id'=>$s_location->loc_id])}}" data-id="{{ $s_location->loc_id }}" >Delete</button>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                                </div>
                            </div>
                            @endforeach

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
