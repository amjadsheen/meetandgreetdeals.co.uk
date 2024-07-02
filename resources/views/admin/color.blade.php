@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Color
                <small>Vehical - Color</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
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
                            <h3 class="box-title">Add New Color</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('color.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" placeholder="Name" name="clr_name" required>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Sort:</label>
                                    <input type="number" class="form-control" placeholder="sort" name="clr_sort" required>
                                </div>

                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add Color</button>
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
                            <h3 class="box-title">Colors</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Sort</th>
                                    <th>Status</th>

                                    <th>Actions</th>

                                </tr>
                                @foreach($colors as $color)
                                    <tr id="row-{{$color->id}}">
                                        <td>{{$loop->iteration}}</td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="clr_name"
                                               data-url="{{route('color/updateinline', ['id'=>$color->id])}}"
                                               data-pk="{{$color->id}}" data-title="change"
                                               data-name="clr_name">{{$color->clr_name}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="clr_sort"
                                               data-url="{{route('color/updateinline', ['id'=>$color->id])}}"
                                               data-pk="{{$color->id}}" data-title="change"
                                               data-name="clr_sort">{{$color->clr_sort}}
                                            </a>
                                        </td>
                                        <td>
                                            @if($color->clr_disable == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":0,"text":"open"},{"value":1,"text":"close"}]' data-column="clr_disable"
                                                     data-url="{{route('color/updateinline', ['id'=>$color->id])}}" data-pk="{{$color->id}}"
                                                     data-title="change" data-name="clr_disable">close
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":1,"text":"close"},{"value":0,"text":"open"}]' data-column="clr_disable"
                                                 data-url="{{route('color/updateinline', ['id'=>$color->id])}}" data-pk="{{$color->id}}"
                                                 data-title="change" data-name="clr_disable">open
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('color/delete', ['id'=>$color->id])}}" data-id="{{ $color->id }}" >Delete</button>
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
