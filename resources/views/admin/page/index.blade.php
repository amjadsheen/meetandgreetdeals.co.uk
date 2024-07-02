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
                            <h3 class="box-title">Add New page</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('pages.store') }}" enctype="multipart/form-data">
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
                                    <button type="submit" class="btn btn-primary">Add page</button>
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
                            <h3 class="box-title">pages</h3>
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
                                @foreach($pages as $page)
                                    <tr id="row-{{$page->id}}">
                                        <td>{{$loop->iteration}}</td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="title"
                                               data-url="{{route('pages/updateinline', ['id'=>$page->id])}}"
                                               data-pk="{{$page->id}}" data-title="change"
                                               data-name="title">{{$page->title}}
                                            </a>
                                        </td>


                                        <td>
                                            <img style="width: 8%" src="/storage/uploads/{{$page->image}}">
                                            {{--<a class="testEdit" data-type="text" data-column="image"--}}
                                               {{--data-url="{{route('pages/updateinline', ['id'=>$page->id])}}"--}}
                                               {{--data-pk="{{$page->id}}" data-title="change"--}}
                                               {{--data-name="image">{{$page->image}}--}}
                                            {{--</a>--}}
                                        </td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="sort"
                                               data-url="{{route('pages/updateinline', ['id'=>$page->id])}}"
                                               data-pk="{{$page->id}}" data-title="change"
                                               data-name="sort">{{$page->sort}}
                                            </a>
                                        </td>

                                        <td>
                                            @if($page->disable == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":1,"text":"open"},{"value":0,"text":"close"}]' data-column="disable"
                                                     data-url="{{route('pages/updateinline', ['id'=>$page->id])}}" data-pk="{{$page->id}}"
                                                     data-title="change" data-name="disable">open
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":0,"text":"close"},{"value":1,"text":"open"}]' data-column="disable"
                                                 data-url="{{route('pages/updateinline', ['id'=>$page->id])}}" data-pk="{{$page->id}}"
                                                 data-title="change" data-name="disable">close
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{action('Admin\PageController@edit',$page->id)}}" class="btn btn-primary">Edit</a>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('pages/delete', ['id'=>$page->id])}}" data-id="{{ $page->id }}" >Delete</button>
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
