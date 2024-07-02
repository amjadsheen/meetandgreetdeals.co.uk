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
                            <h3 class="box-title">Add New Promotion Company</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('promotion-companies.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" placeholder="Name" name="company_name" required>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Contact:</label>
                                    <input type="text" class="form-control" placeholder="Name" name="company_contact" required>
                                </div>
                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add Company</button>
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
                            <h3 class="box-title">Companies</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Actions</th>

                                </tr>
                                @foreach($promotion_companies as $company)
                                    <tr id="row-{{$company->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="company_name"
                                               data-url="{{route('promotion-companies/updateinline', ['id'=>$company->id])}}"
                                               data-pk="{{$company->id}}" data-title="change"
                                               data-name="company_name">{{$company->company_name}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="company_contact"
                                               data-url="{{route('promotion-companies/updateinline', ['id'=>$company->id])}}"
                                               data-pk="{{$company->id}}" data-title="change"
                                               data-name="company_contact">{{$company->company_contact}}
                                            </a>
                                        </td>
                                        

                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('promotion-companies/delete', ['id'=>$company->id])}}" data-id="{{ $company->id }}" >Delete</button>
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
