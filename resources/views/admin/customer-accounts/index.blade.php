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
                            <h3 class="box-title">Add New {{$title}}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('customeraccounts.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-3">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="account_num" required>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label>Status:</label>
                                   <select class="form-control" name="status" required>
                                       <option value="">Select</option>
                                       <option value="1">Enabled</option>
                                       <option value="0">Disabled</option>
                                   </select>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="customer_email" required>
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
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Faq{{$title}}s</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Account Num</th>
                                    <th>Status</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                                @foreach($customer_accounts as $accounts)
                                    <tr id="row-{{$accounts->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="account_num"
                                               data-url="{{route('customeraccounts/updateinline', ['id'=>$accounts->id])}}"
                                               data-pk="{{$accounts->id}}" data-title="change"
                                               data-name="account_num">{{$accounts->account_num}}
                                            </a>
                                        </td>
                                        <td>
                                           
                                           @if($accounts->status == 1)

                                                <a style="color: green" class="testEdit" data-type="select" data-column="status"
                                                   data-source='[{"value":0,"text":"Disable"},{"value":1,"text":"Enable"}]'
                                                   data-url="{{route('customeraccounts/updateinline', ['id'=>$accounts->id])}}"
                                                   data-pk="{{$accounts->id}}" data-title="change"
                                                   data-name="status">Enabled
                                                </a>
                                            @else

                                                <a class="testEdit" data-type="select" data-column="status"
                                                   data-source='[{"value":1,"text":"Enable"},{"value":0,"text":"Disable"}]'
                                                   data-url="{{route('customeraccounts/updateinline', ['id'=>$accounts->id])}}"
                                                   data-pk="{{$accounts->id}}" data-title="change"
                                                   data-name="status">Disabled
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                        <a class="testEdit" data-type="text" data-column="customer_email"
                                               data-url="{{route('customeraccounts/updateinline', ['id'=>$accounts->id])}}"
                                               data-pk="{{$accounts->id}}" data-title="change"
                                               data-name="customer_email">{{$accounts->customer_email}}
                                            </a>
                                        </td>
                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('customeraccounts/delete', ['id'=>$accounts->id])}}" data-id="{{ $accounts->id }}" >Delete</button>
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
