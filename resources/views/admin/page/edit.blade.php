@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                pages
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">pages</li>
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
                            <h3 class="box-title">Edit page</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('pages.update', $id) }}"
                                  enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT')}}
                            <!-- text input -->
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>title:</label>
                                        <input type="text" class="form-control" name="title"
                                               value="{{$page->title}}" required>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Slug:</label>
                                        <input type="text" class="form-control" name="slug"
                                               value="{{$page->slug}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>Image:</label>
                                        <input type="file" class="form-control" name="image"
                                               value="{{$page->image}}">
                                        <img style="width: 45%" src="{{url('/storage/uploads/'.$page->image)}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label>Description:</label>
                                        <textarea id="textarea" type="text" class="textarea form-control"
                                                  name="content">{{$page->content}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label>Content Left:</label>
                                        <textarea id="textarea" type="text" class="textarea form-control"
                                                  name="content_left">{{$page->content_left}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label>Content Right:</label>
                                        <textarea id="textarea" type="text" class="textarea form-control"
                                                  name="content_right">{{$page->content_right}}</textarea>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>Meta Tile:</label>
                                        <input type="text" class="form-control" name="meta_title"
                                               value="{{$page->meta_title}}">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Meta Description:</label>
                                        <textarea type="text" class="form-control"
                                                  name="meta_description">{{$page->meta_description}}</textarea>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Key Words:</label>
                                        <textarea type="text" class="form-control" name="meta_keywords">{{$page->meta_keywords}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Edit page</button>
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
