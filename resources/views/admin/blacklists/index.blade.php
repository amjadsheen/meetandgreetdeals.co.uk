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
                            <h3 class="box-title">Add New {{$title}}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('blacklists.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Email/ Mobiles / vrn:</label>
                                    <input type="text" class="form-control" name="bl_data" required>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label>Type:</label>
                                   <select class="form-control" name="bl_type" required>
                                       <option value="">Select</option>
                                       <option value="1">Email</option>
                                       <option value="2">Mobiles</option>
                                       <option value="3">Vrn</option>
                                   </select>
                                </div>


                                <div class="form-group col-sm-4">
                                    <label>Remarks:</label>
                                    <textarea type="text"  cols="50" rows="2" class="form-control" name="bl_remarks" required></textarea>
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
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Faq{{$title}}s</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Value</th>
                                    <th>Type</th>
                                    <th>Remarks</th>
                                    <th>Date</th>
                                    <th>Actions</th>

                                </tr>
                                @foreach($blacklists as $blacklist)
                                    <tr id="row-{{$blacklist->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="bl_data"
                                               data-url="{{route('blacklists/updateinline', ['id'=>$blacklist->id])}}"
                                               data-pk="{{$blacklist->id}}" data-title="change"
                                               data-name="bl_data">{{$blacklist->bl_data}}
                                            </a>
                                        </td>

                                        <td>
                                           @if($blacklist->bl_type == 1)
                                               Email
                                           @endif
                                           @if($blacklist->bl_type == 2)
                                               Mobile
                                           @endif
                                           @if($blacklist->bl_type == 3)
                                                Vrn
                                           @endif
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="bl_remarks"
                                               data-url="{{route('blacklists/updateinline', ['id'=>$blacklist->id])}}"
                                               data-pk="{{$blacklist->id}}" data-title="change"
                                               data-name="bl_remarks">{{$blacklist->bl_remarks}}
                                            </a>
                                        </td>

                                        <td>
                                            {{$blacklist->bl_datetime}}
                                        </td>
                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('blacklists/delete', ['id'=>$blacklist->id])}}" data-id="{{ $blacklist->id }}" >Delete</button>
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
