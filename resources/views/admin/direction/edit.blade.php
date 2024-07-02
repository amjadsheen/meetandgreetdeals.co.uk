@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Directions
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Directions</li>
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
                            <h3 class="box-title">Edit Direction</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('directions.update', $id) }}"
                                  enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT')}}
                            <!-- text input -->
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>title:</label>
                                        <input type="text" class="form-control" name="title"
                                               value="{{$direction->title}}" required>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Slug:</label>
                                        <input type="text" readonly class="form-control" name="slug" value="{{$direction->slug}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>Image:</label>
                                        <input type="file" class="form-control" name="image"
                                               value="{{$direction->image}}">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <span><img style="width: 50%" src="{{url('/storage/uploads/'.$direction->image)}}"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <label>Description:</label>
                                        <textarea id="editor1" type="text" class="textarea form-control"
                                                  name="content">{{$direction->content}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <label>Terminal 1:</label>
                                        <textarea id="editor1" type="text" class="textarea form-control"
                                                  name="terminal_1">{{$direction->terminal_1}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <label>Terminal 2:</label>
                                        <textarea id="editor1" type="text" class="textarea form-control"
                                                  name="terminal_2">{{$direction->terminal_2}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <label>Terminal 3:</label>
                                        <textarea id="editor1" type="text" class="textarea form-control"
                                                  name="terminal_3">{{$direction->terminal_3}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <label>Terminal 4:</label>
                                        <textarea id="editor1" type="text" class="textarea form-control"
                                                  name="terminal_4">{{$direction->terminal_4}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <label>Terminal 5:</label>
                                        <textarea id="editor1" type="text" class="textarea form-control"
                                                  name="terminal_5">{{$direction->terminal_5}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Meta Tile:</label>
                                        <input type="text" class="form-control" name="meta_title"
                                               value="{{$direction->meta_title}}">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-sm-6">
                                        <label>Meta Description:</label>
                                        <textarea type="text" class="form-control"
                                                  name="meta_description">{{$direction->meta_description}}</textarea>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Key Words:</label>
                                        <textarea type="text" class="form-control" name="meta_keywords">{{$direction->meta_keywords}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Edit Direction</button>
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
