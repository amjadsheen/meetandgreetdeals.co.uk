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
                            <h3 class="box-title">Add New Faq</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('faqs.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Question:</label>
                                    <input type="text" class="form-control" name="question" required>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Answer:</label>
                                    <textarea type="text"  cols="50" rows="2" class="form-control" name="answer" required></textarea>
                                </div>
                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add Faq</button>
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
                            <h3 class="box-title">Faqs</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>sort</th>
                                    <th>Status</th>

                                    <th>Actions</th>

                                </tr>
                                @foreach($faqs as $faq)
                                    <tr id="row-{{$faq->id}}">
                                        <td>{{$loop->iteration}}</td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="question"
                                               data-url="{{route('faqs/updateinline', ['id'=>$faq->id])}}"
                                               data-pk="{{$faq->id}}" data-title="change"
                                               data-name="question">{{$faq->question}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="textarea" data-column="answer"
                                               data-url="{{route('faqs/updateinline', ['id'=>$faq->id])}}"
                                               data-pk="{{$faq->id}}" data-title="change"
                                               data-name="answer">{{$faq->answer}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="sort"
                                               data-url="{{route('faqs/updateinline', ['id'=>$faq->id])}}"
                                               data-pk="{{$faq->id}}" data-title="change"
                                               data-name="sort">{{$faq->sort}}
                                            </a>
                                        </td>
                                        <td>
                                            @if($faq->disable == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":1,"text":"disable"},{"value":0,"text":"enable"}]' data-column="disable"
                                                     data-url="{{route('faqs/updateinline', ['id'=>$faq->id])}}" data-pk="{{$faq->id}}"
                                                     data-title="change" data-name="disable">disabled
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":0,"text":"enable"},{"value":1,"text":"disable"}]' data-column="disable"
                                                 data-url="{{route('faqs/updateinline', ['id'=>$faq->id])}}" data-pk="{{$faq->id}}"
                                                 data-title="change" data-name="disable">enabled
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('faqs/delete', ['id'=>$faq->id])}}" data-id="{{ $faq->id }}" >Delete</button>
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
