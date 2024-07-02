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
                            <h3 class="box-title">Add New Banner</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('banner.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-2">
                                    <label>Website:</label>
                                    <select class="form-control" name="website_id" required>
                                        <!-- <option value="">Select</option> -->
                                        @foreach($websites as $website)
                                            <option value="{{$website->id}}">{{$website->website_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Tag:</label>
                                    <input type="text" class="form-control" name="tag" required>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image" required>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Price:</label>
                                    <input type="text" class="form-control" name="price" required>
                                </div>

                                <div class="form-group col-sm-2 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add Banner</button>
                                </div>

                            </form>

                            <form method="post" action="{{ action('Admin\BannerController@autogenerate') }}">
                            @csrf
                                <div class="form-group col-sm-2 topmargin20">
                                    <button type="submit" class="btn btn-primary">Auto Generate</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- left column -->
                @foreach($banners as $key=>$banner_list)
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{$key}} Banners</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>Title Tag</th>
                                    <th>Website</th>
                                    <th style="width: 200px">Image</th>
                                    <th>Price</th>
                                    <th>Sort</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>
                                @foreach($banner_list as $banner)
                                    <tr id="row-{{$banner->id}}">
                                        <td>{{$loop->iteration}}</td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="tag"
                                               data-url="{{route('banner/updateinline', ['id'=>$banner->id])}}"
                                               data-pk="{{$banner->id}}" data-title="change"
                                               data-name="tag">{{$banner->tag}}
                                            </a>
                                        </td>


                                        <td>
                                            <a class="testEdit" data-type="select" data-column="website_id"
                                               data-source='{{$websites_json}}'
                                               data-url="{{route('banner/updateinline', ['id'=>$banner->id])}}"
                                               data-pk="{{$banner->id}}" data-title="change"
                                               data-name="website_id">{{$banner->website_name}}
                                            </a>
                                        </td>

                                        <td>
                                            <img style="width: 40%" src="{{url('/storage/uploads/'.$banner->image)}}">
                                            {{--<a class="testEdit" data-type="text" data-column="image"--}}
                                               {{--data-url="{{route('banners/updateinline', ['id'=>$banner->id])}}"--}}
                                               {{--data-pk="{{$banner->id}}" data-title="change"--}}
                                               {{--data-name="image">{{$banner->image}}--}}
                                            {{--</a>--}}
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="price"
                                               data-url="{{route('banner/updateinline', ['id'=>$banner->id])}}"
                                               data-pk="{{$banner->id}}" data-title="change"
                                               data-name="price">{{$banner->price}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="sort"
                                               data-url="{{route('banner/updateinline', ['id'=>$banner->id])}}"
                                               data-pk="{{$banner->id}}" data-title="change"
                                               data-name="sort">{{$banner->sort}}
                                            </a>
                                        </td>

                                        <td>
                                            @if($banner->disable == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":1,"text":"open"},{"value":0,"text":"close"}]' data-column="disable"
                                                     data-url="{{route('banner/updateinline', ['id'=>$banner->id])}}" data-pk="{{$banner->id}}"
                                                     data-title="change" data-name="disable">open
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":0,"text":"close"},{"value":1,"text":"open"}]' data-column="disable"
                                                 data-url="{{route('banner/updateinline', ['id'=>$banner->id])}}" data-pk="{{$banner->id}}"
                                                 data-title="change" data-name="disable">close
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{action('Admin\BannerController@edit',$banner->id)}}" class="btn btn-primary">Edit</a>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('banner/delete', ['id'=>$banner->id])}}" data-id="{{ $banner->id }}" >Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
