@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Banners
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Banners</li>
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
                            <h3 class="box-title">Edit Banner</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('banner.update', $id) }}" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT')}}
                            <!-- text input -->
                                <div class="form-group col-sm-2">
                                    <label>Website:</label>
                                    <select class="form-control" name="website_id" required>
                                        <option value="">Select</option>
                                        @foreach($websites as $website)
                                            <option {{($banner->website_id == $website->id) ? 'selected':'' }} value="{{$website->id}}">{{$website->website_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Tag:</label>
                                    <input type="text" class="form-control" name="tag" value="{{$banner->tag}}" required>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image" value="{{$banner->image}}">
                                    <img style="width: 45%" src="{{url('/storage/uploads/'.$banner->image)}}">
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Price:</label>
                                    <input type="text" class="form-control" name="price" value="{{$banner->price}}" required>
                                </div>

                                <div class="form-group col-sm-2 topmargin20">
                                    <button type="submit" class="btn btn-primary">Edit Banner</button>
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
