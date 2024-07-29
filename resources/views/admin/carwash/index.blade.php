@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$title}}s
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
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-check"></i>{{ session()->get('success') }}
                        </div>
                    @endif
                    @if(session()->get('warning'))
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fa fa-warning"></i>{{ session()->get('warning') }}
                        </div>
                    @endif
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add New {{$title}}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('carwash.store') }}" enctype="multipart/form-data">
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
                                    <label>VehicalType:</label>
                                    <select class="form-control" name="vehical_type_id" required>
                                        <option value="">Select</option>
                                        @foreach($vehicaltype as $v_typee)
                                            <option value="{{$v_typee->id}}">{{$v_typee->v_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>{{$title}} Type:</label>
                                    <select class="form-control" name="car_wash_type" required>
                                        <option value="">Select</option>
                                        @foreach($wash_types as $key=>$w_type)
                                            <option value="{{$key}}">{{$w_type}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>{{$title}} Price:</label>
                                    <input type="number"  min="0" class="form-control" name="car_wash_price" required>
                                </div>


                                <div class="form-group col-sm-2 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add {{$title}}</button>
                                </div>

                            </form>
                            <form method="post" action="{{ action('Admin\CarWashController@autogenerate') }}">
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
                <div class="col-md-12">
                    <div class="box">
                <section class="content-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <form role="form" action="{{ route('carwash.index') }}">
                                    <div class="form-group">
                                        <select name="filter_website" class="form-control" onchange="this.form.submit()">
                                            <option value="">Select Website</option>
                                            @foreach($websites as $website)
                                                <option {{($filter_website == $website->id) ? 'selected':'' }} value="{{$website->id}}">{{$website->website_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- left column -->

                @foreach($carwash as $key=>$single_carwash)
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{$key}}</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>Website</th>
                                    <th>CarWash Type</th>
                                    <th>CarWash Price</th>
                                    <th>Status</th>
                                </tr>
                                @foreach($single_carwash as $single)
                                    <tr id="row-{{$single->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            {{$single->website_name}}
                                        </td>
                                        <td>
                                            {{$wash_types[$single->car_wash_type]}}
                                        </td>

                                        <td>

                                            <a class="testEdit" data-type="text" data-column="car_wash_price"
                                               data-url="{{route('carwash/updateinline', ['id'=>$single->id])}}"
                                               data-pk="{{$single->id}}" data-title="change"
                                               data-name="car_wash_price"> {{$single->car_wash_price}}
                                            </a>
                                        </td>

                                        <td>
                                            @if($single->status == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":1,"text":"open"},{"value":0,"text":"close"}]' data-column="status"
                                                     data-url="{{route('carwash/updateinline', ['id'=>$single->id])}}" data-pk="{{$single->id}}"
                                                     data-title="change" data-name="status">open
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":0,"text":"close"},{"value":1,"text":"open"}]' data-column="status"
                                                 data-url="{{route('carwash/updateinline', ['id'=>$single->id])}}" data-pk="{{$single->id}}"
                                                 data-title="change" data-name="status">close
                                                 </a>
                                            @endif
                                        </td>

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
