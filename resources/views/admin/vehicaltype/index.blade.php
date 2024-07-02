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
                            <form method="post" action="{{ route('vehicaltype.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- text input -->

                                <div class="form-group col-sm-2">
                                    <label>{{$title}} Name:</label>
                                    <input type="text" class="form-control" name="v_name" required>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="v_image" >
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
                            <h3 class="box-title"> {{$title}}s</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>Name </th>
                                    <th style="width: 200px">Image</th>
                                    <th>Actions</th>

                                </tr>
                                @foreach($vehicaltype as $v_type)
                                    <tr id="row-{{$v_type->id}}">
                                        <td>{{$loop->iteration}}</td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="v_name"
                                               data-url="{{route('vehicaltype/updateinline', ['id'=>$v_type->id])}}"
                                               data-pk="{{$v_type->id}}" data-title="change"
                                               data-name="v_name">{{$v_type->v_name}}
                                            </a>
                                        </td>

                                        <td>
                                            <img style="width: 50%" src="{{url('storage/uploads/'.$v_type->v_image)}}">
                                        </td>

                                        <td>
                                            <a href="{{action('Admin\VehicalTypeController@edit',$v_type->id)}}" class="btn btn-primary">Edit</a>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('vehicaltype/delete', ['id'=>$v_type->id])}}" data-id="{{ $v_type->id }}" >Delete</button>
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
