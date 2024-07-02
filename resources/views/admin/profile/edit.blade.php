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
                            <h3 class="box-title">Edit {{$title}}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('profile.update', $id) }}"
                                  enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT')}}
                            <!-- text input -->
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>Name:</label>
                                        <input type="text" class="form-control" name="name"
                                               value="{{$user->name}}" required>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Email:</label>
                                        <input type="text" class="form-control" name="email"
                                               value="{{$user->email}}">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <button type="button" class="form-control btn btn-success" id="changepass">Change Password</button>
                                    </div>
                                </div>
                                <div class="row" id="passdiv" style="display: none">
                                    <div class="form-group col-sm-3">
                                        <label>Password:</label>
                                        <input type="text" class="form-control" name="pass" id="pass" disabled>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Confrim Password:</label>
                                        <input type="text" class="form-control" name="con_pass" id="con_pass" disabled>
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
