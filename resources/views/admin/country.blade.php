@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$title}}
                <small>Booking - {{$title}}</small>
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
                            <h3 class="box-title">Add New Country</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('country.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" required>
                                </div>
                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add Country</button>
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
                            <h3 class="box-title">Countries</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Contact#</th>
                                    <th>Status</th>

                                    <th>Actions</th>

                                </tr>
                                @foreach($countries as $country)
                                    <tr id="row-{{$country->id}}">
                                        <td>{{$loop->iteration}}</td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="name"
                                               data-url="{{route('country/updateinline', ['id'=>$country->id])}}"
                                               data-pk="{{$country->id}}" data-title="change"
                                               data-name="name">{{$country->name}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="contact_numbers"
                                               data-url="{{route('country/updateinline', ['id'=>$country->id])}}"
                                               data-pk="{{$country->id}}" data-title="change"
                                               data-name="contact_numbers">{{$country->contact_numbers}}
                                            </a>
                                        </td>

                                        <td>
                                            @if($country->disable == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":1,"text":"open"},{"value":0,"text":"close"}]' data-column="disable"
                                                     data-url="{{route('country/updateinline', ['id'=>$country->id])}}" data-pk="{{$country->id}}"
                                                     data-title="change" data-name="disable">open
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":0,"text":"close"},{"value":1,"text":"open"}]' data-column="disable"
                                                 data-url="{{route('country/updateinline', ['id'=>$country->id])}}" data-pk="{{$country->id}}"
                                                 data-title="change" data-name="disable">close
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('country/delete', ['id'=>$country->id])}}" data-id="{{ $country->id }}" >Delete</button>
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
