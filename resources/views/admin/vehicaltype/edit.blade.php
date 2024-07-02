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
                            <h3 class="box-title">Edit {{$title}}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('vehicaltype.update', $id) }}"
                                  enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT')}}
                            <!-- text input -->
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>{{$title}} Name:</label>
                                        <input type="text" class="form-control" name="v_name"
                                               value="{{$vehicaltype->v_name}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>Image:</label>
                                        <input type="file" class="form-control" name="v_image"
                                               value="{{$vehicaltype->v_image}}">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <img style="width: 50%" src="{{url('/uploads/'.$vehicaltype->v_image)}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-2 topmargin20">
                                        <button type="submit" class="btn btn-primary">Edit {{$title}}</button>
                                    </div>
                                </div>
                            </form>
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
