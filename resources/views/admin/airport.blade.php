@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$title}}
                <small>Booking - Airports</small>
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
                            <h3 class="box-title">Add New Airports</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('airport.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Country:</label>
                                    <select class="form-control" name="country_id" required>
                                        <option value="">Select</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Code:</label>
                                    <input type="text" class="form-control" placeholder="Code" name="airport_nick" required>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" placeholder="Name" name="airport_name" required>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Directions page:</label>
                                    <input type="text" class="form-control" placeholder="Directions" name="airport_directions">
                                </div>
                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add Airport</button>
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
                            <h3 class="box-title">Airports</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Country</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Direcitons</th>
                                    <th>Status</th>

                                    <th>Actions</th>

                                </tr>
                                @foreach($airports as $airport)
                                    <tr id="row-{{$airport->id}}">
                                        <td>{{$loop->iteration}}</td>

                                        <td>
                                            <a class="testEdit" data-type="select" data-column="country_id"
                                               data-source='{{$countries_json}}'
                                               data-url="{{route('airport/updateinline', ['id'=>$airport->id])}}"
                                               data-pk="{{$airport->id}}" data-title="change"
                                               data-name="country_id">{{$airport->country_name}}
                                            </a>
                                        </td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="airport_nick"
                                               data-url="{{route('airport/updateinline', ['id'=>$airport->id])}}"
                                               data-pk="{{$airport->id}}" data-title="change"
                                               data-name="airport_nick">{{$airport->airport_nick}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="airport_name"
                                               data-url="{{route('airport/updateinline', ['id'=>$airport->id])}}"
                                               data-pk="{{$airport->id}}" data-title="change"
                                               data-name="airport_name">{{$airport->airport_name}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="select" data-column="airport_directions"
                                               data-source='{{$directions_json}}'
                                               data-url="{{route('airport/updateinline', ['id'=>$airport->id])}}"
                                               data-pk="{{$airport->id}}" data-title="change"
                                               data-name="airport_directions">{{$airport->airport_directions}}
                                            </a>
                                        </td>
                                        <td>
                                            @if($airport->airport_disable == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":0,"text":"open"},{"value":1,"text":"close"}]' data-column="airport_disable"
                                                     data-url="{{route('airport/updateinline', ['id'=>$airport->id])}}" data-pk="{{$airport->id}}"
                                                     data-title="change" data-name="airport_disable">close
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":1,"text":"close"},{"value":0,"text":"open"}]' data-column="airport_disable"
                                                 data-url="{{route('airport/updateinline', ['id'=>$airport->id])}}" data-pk="{{$airport->id}}"
                                                 data-title="change" data-name="airport_disable">open
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('airport/delete', ['id'=>$airport->id])}}" data-id="{{ $airport->id }}" >Delete</button>
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
