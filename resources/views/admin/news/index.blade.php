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
                            <form method="post" action="{{ route('news.store') }}">
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

                                <div class="form-group col-sm-4">
                                    <label>News:</label>
                                    <textarea class="form-control" name="news" required></textarea>
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
                @foreach($news as $key=>$news_list)
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{$key}} {{$title}}s</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>News</th>
                                    <th>News</th>
                                    <th>Sort</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>
                                @foreach($news_list as $single_news)
                                    <tr id="row-{{$single_news->id}}">
                                        <td>{{$loop->iteration}}</td>

                                        <td>
                                            <a class="testEdit" data-type="select" data-column="website_id"
                                               data-source='{{$websites_json}}'
                                               data-url="{{route('news/updateinline', ['id'=>$single_news->id])}}"
                                               data-pk="{{$single_news->id}}" data-title="change"
                                               data-name="website_id">{{$single_news->website_name}}
                                            </a>
                                        </td>


                                        <td>
                                            <a class="testEdit" data-type="textarea" data-column="news"
                                               data-url="{{route('news/updateinline', ['id'=>$single_news->id])}}"
                                               data-pk="{{$single_news->id}}" data-title="change"
                                               data-name="news">{{$single_news->news}}
                                            </a>
                                        </td>
                                        
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="sort"
                                               data-url="{{route('news/updateinline', ['id'=>$single_news->id])}}"
                                               data-pk="{{$single_news->id}}" data-title="change"
                                               data-name="sort">{{$single_news->sort}}
                                            </a>
                                        </td>
                                        
                                        <td>
                                            @if($single_news->disable == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":0,"text":"show"},{"value":1,"text":"hide"}]' data-column="disable"
                                                     data-url="{{route('news/updateinline', ['id'=>$single_news->id])}}" data-pk="{{$single_news->id}}"
                                                     data-title="change" data-name="disable">Hide
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":1,"text":"hide"},{"value":0,"text":"show"}]' data-column="disable"
                                                 data-url="{{route('news/updateinline', ['id'=>$single_news->id])}}" data-pk="{{$single_news->id}}"
                                                 data-title="change" data-name="disable">Show
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('news/delete', ['id'=>$single_news->id])}}" data-id="{{ $single_news->id }}" >Delete</button>
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
