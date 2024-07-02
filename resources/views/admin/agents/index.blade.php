@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <style>
        hr {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$title}}  <a class="btn btn-sm btn-primary" href="{{route('agents.create')}}"  role="button">Add New</a>
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
                </div>
            </div>

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$title}}s</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>
                                        Mother company name<hr>
                                        Email address<hr>
                                        Company name<hr>
                                        Registration number<hr>
                                        Commision<hr>
                                        Fee

                                    </th>
                                    <th>
                                        Partner 1 Name<hr>
                                        Surname<hr>
                                        Mobile number 1<hr>
                                        Mobile number 2<hr>
                                    </th>
                                    <th>
                                        Partner 2 Name<hr>
                                        Surname<hr>
                                        Mobile number 1<hr>
                                        Mobile number 2<hr>
                                    </th>
                                    <th>
                                        Partner 3 Name<hr>
                                        Surname<hr>
                                        Mobile number 1<hr>
                                        Mobile number 2<hr>
                                    </th>
                                    <th>
                                        Address<hr>
                                        City<hr>
                                        County<hr>
                                        Post Code<hr>
                                        Note<hr>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                                @foreach($agents as $agent)
                                    <tr id="row-{{$agent->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="agt_mcompany"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_mcompany">{{$agent->agt_mcompany}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_email"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_email">{{$agent->agt_email}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_company"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_company">{{$agent->agt_company}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_compreg"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_compreg">{{$agent->agt_compreg}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_commision"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_commision">{{$agent->agt_commision}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_fee"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_fee">{{$agent->agt_fee}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="agt_p1fname"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p1fname">{{$agent->agt_p1fname}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_p1surname"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p1surname">{{$agent->agt_p1surname}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_p1mobile1"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p1mobile1">{{$agent->agt_p1mobile1}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_p1mobile2"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p1mobile2">{{$agent->agt_p1mobile2}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="agt_p2fname"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p2fname">{{$agent->agt_p2fname}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_p2surname"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p2surname">{{$agent->agt_p2surname}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_p2mobile1"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p2mobile1">{{$agent->agt_p2mobile1}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_p2mobile2"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p2mobile2">{{$agent->agt_p2mobile2}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="agt_p3fname"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p3fname">{{$agent->agt_p3fname}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_p3surname"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p3surname">{{$agent->agt_p3surname}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_p3mobile1"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p3mobile1">{{$agent->agt_p3mobile1}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_p3mobile2"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_p3mobile2">{{$agent->agt_p3mobile2}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="agt_address"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_address">{{$agent->agt_address}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_city"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_city">{{$agent->agt_city}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_county"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_county">{{$agent->agt_county}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="agt_postcode"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_postcode">{{$agent->agt_postcode}}
                                            </a><hr>
                                            <a class="testEdit" data-type="textarea" data-column="agt_note"
                                               data-url="{{route('agents/updateinline', ['id'=>$agent->id])}}"
                                               data-pk="{{$agent->id}}" data-title="change"
                                               data-name="agt_note">{{$agent->agt_note}}
                                            </a>
                                        </td>
                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('agents/delete', ['id'=>$agent->id])}}" data-id="{{ $agent->id }}" >Delete</button>
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
