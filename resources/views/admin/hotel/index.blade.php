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
                            <h3 class="box-title">Add New  {{$title}}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('hotels.store') }}">
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
                                    <input type="text" class="form-control" placeholder="Name" name="htl_name" required>
                                </div>
                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add  {{$title}}</button>
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
                            <h3 class="box-title"> {{$title}}s</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Airport</th>
                                    <th>Hotel</th>
                                    <th>Status</th>

                                </tr>
                                @foreach($hotels as $hotel)
                                    <tr id="row-{{$hotel->id}}">
                                        <td>{{$loop->iteration}}</td>

                                        <td>
                                            <a class="testEdit" data-type="select"
                                               data-source='{{$airport_json}}' data-column="airport_id"
                                               data-url="{{route('hotels/updateinline', ['id'=>$hotel->id])}}" data-pk="{{$hotel->id}}"
                                               data-title="change"  data-value="{{$hotel->airport_id}}"
                                               data-name="airport_id">{{$hotel->airport_name}}
                                            </a>
                                        </td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="htl_name"
                                               data-url="{{route('hotels/updateinline', ['id'=>$hotel->id])}}"
                                               data-pk="{{$hotel->id}}" data-title="change"
                                               data-name="htl_name">{{$hotel->htl_name}}
                                            </a>
                                        </td>
                                    <?php
                                    if ($hotel->htl_disable == 0){
                                        $opt = '[{"value":0,"text":"open"},{"value":1,"text":"close"}]';
                                    }else{
                                        $opt = '[{"value":1,"text":"close"},{"value":0,"text":"open"}]';
                                    }
                                    ?>

                                        <td>
                                            <a class="testEdit" data-type="select"
                                               data-source='{{$opt}}' data-column="htl_disable"
                                               data-url="{{route('hotels/updateinline', ['id'=>$hotel->id])}}" data-pk="{{$hotel->id}}"
                                               data-title="change"  data-value="{{$hotel->htl_disable}}"
                                               data-name="htl_disable">{{ $hotel->htl_disable === 1 ? "close" : "open" }}
                                            </a>
                                        </td>

                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('hotels/delete', ['id'=>$hotel->id])}}" data-id="{{ $hotel->id }}" >Delete</button>
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
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
