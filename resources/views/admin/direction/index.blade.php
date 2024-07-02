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
                            <h3 class="box-title">Add New Direction</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('directions.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Title:</label>
                                    <input type="text" class="form-control" name="title" required>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image">
                                </div>

                                <div class="form-group col-sm-3">
                                    <label>Description:</label>
                                    <textarea type="text" class="form-control" name="content"></textarea>
                                </div>

                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add Direction</button>
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
                            <h3 class="box-title">Directions</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Sort</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>
                                @foreach($directions as $direction)
                                    <tr id="row-{{$direction->id}}">
                                        <td>{{$loop->iteration}}</td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="title"
                                               data-url="{{route('directions/updateinline', ['id'=>$direction->id])}}"
                                               data-pk="{{$direction->id}}" data-title="change"
                                               data-name="title">{{$direction->title}}
                                            </a>
                                        </td>


                                        <td>
                                            <img style="width: 8%" src="{{url('/storage/uploads/'.$direction->image)}}">
                                            {{--<a class="testEdit" data-type="text" data-column="image"--}}
                                               {{--data-url="{{route('directions/updateinline', ['id'=>$direction->id])}}"--}}
                                               {{--data-pk="{{$direction->id}}" data-title="change"--}}
                                               {{--data-name="image">{{$direction->image}}--}}
                                            {{--</a>--}}
                                        </td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="sort"
                                               data-url="{{route('directions/updateinline', ['id'=>$direction->id])}}"
                                               data-pk="{{$direction->id}}" data-title="change"
                                               data-name="sort">{{$direction->sort}}
                                            </a>
                                        </td>

                                        <td>
                                            @if($direction->disable == 1)

                                                <a class="testEdit" data-type="select"
                                                   data-source='[{"value":1,"text":"close"},{"value":0,"text":"open"}]' data-column="disable"
                                                   data-url="{{route('directions/updateinline', ['id'=>$direction->id])}}" data-pk="{{$direction->id}}"
                                                   data-title="change" data-name="disable">close
                                                </a>
                                            @else
                                                <a class="testEdit" data-type="select"
                                                   data-source='[{"value":0,"text":"open"},{"value":1,"text":"close"}]' data-column="disable"
                                                   data-url="{{route('directions/updateinline', ['id'=>$direction->id])}}" data-pk="{{$direction->id}}"
                                                   data-title="change" data-name="disable">open
                                                </a>

                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{action('Admin\DirectionController@edit',$direction->id)}}" class="btn btn-primary">Edit</a>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('directions/delete', ['id'=>$direction->id])}}" data-id="{{ $direction->id }}" >Delete</button>
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
