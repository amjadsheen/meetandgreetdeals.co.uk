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
                        <div class="box-body">
                            <form method="post" action="{{ route('drivers.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-2">
                                    <label>User Name:</label>
                                    <input type="text" class="form-control" name="drv_username" required>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Password:</label>
                                    <input type="text" class="form-control" name="drv_password">
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Select Driver's photo:</label>
                                    <input type="file" class="form-control" name="drv_photo" >
                                </div>

                                <div class="form-group col-sm-2">
                                    <label> Select License's photo:</label>
                                    <input type="file" class="form-control" name="drv_licensephoto">
                                </div>


                                <div class="form-group col-sm-2 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add {{$title}}</button>
                                </div>

                            </form>
                        </div>
                        </div>
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
                                        Picture<hr>
                                        License's photo
                                    </th>
                                    <th>
                                        F Name/S Name/Fm. name<hr>
                                        DOB<hr>
                                        NIN<hr>
                                        DIDN<hr>
                                    </th>
                                    <th>
                                        User Name<hr>
                                        Password<hr>
                                        Email address<hr>
                                    </th>
                                    <th>
                                        Mobile 1<hr>
                                        Mobile 2<hr>
                                        Land line<hr>
                                    </th>
                                    <th>
                                        Address<hr>
                                        City / County <hr>
                                        Post Code<hr>
                                    </th>
                                    <th>
                                        DLN<hr>
                                        Issue date<hr>
                                        Expiry date<hr>
                                    </th>
                                    <th>
                                        NOK F.Name/S.Name/Fm.Name<hr>
                                        Mobile 1 / Mobile 2<hr>
                                        land Line<hr>
                                        Email address<hr>
                                    </th>
                                    <th>
                                        NOK Address<hr>
                                        City / County <hr>
                                        Post code<hr>
                                        Relation<hr>
                                    </th>


                                    <th>Actions</th>
                                </tr>
                                @foreach($drivers as $driver)
                                    <tr id="row-{{$driver->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>
{{--                                            <img style="width: 8%" src="{{url('/uploads/'.$driver->drv_photo)}}"><hr>--}}
{{--                                            <img style="width: 8%" src="{{url('/uploads/'.$driver->drv_licensephoto)}}">--}}
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="drv_firstname"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_firstname">{{$driver->drv_firstname}}
                                            </a> /
                                            <a class="testEdit" data-type="text" data-column="drv_surname"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_surname">{{$driver->drv_surname}}
                                            </a> /
                                            <a class="testEdit" data-type="text" data-column="drv_familyname"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_familyname">{{$driver->drv_familyname}}
                                            </a><hr>

                                            <a class="testEdit" data-type="date" data-column="drv_dob"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_dob">{{$driver->drv_dob}}
                                            </a><hr>

                                            <a class="testEdit" data-type="text" data-column="drv_nin"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nin">{{$driver->drv_nin}}
                                            </a><hr>

                                            <a class="testEdit" data-type="text" data-column="drv_didn"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_didn">{{$driver->drv_didn}}
                                            </a>

                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="drv_username"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_username">{{$driver->drv_username}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="drv_password"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_password">{{$driver->drv_password}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="drv_email"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_email">{{$driver->drv_email}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="drv_mobile1"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_mobile1">{{$driver->drv_mobile1}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="drv_mobile2"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_mobile2">{{$driver->drv_mobile2}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="drv_landline"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_landline">{{$driver->drv_landline}}
                                            </a>

                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="drv_address"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_address">{{$driver->drv_address}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="drv_city"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_city">{{$driver->drv_city}}
                                            </a> /
                                            <a class="testEdit" data-type="text" data-column="drv_county"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_county">{{$driver->drv_county}}
                                            </a> <hr>
                                            <a class="testEdit" data-type="text" data-column="drv_postcode"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_postcode">{{$driver->drv_postcode}}
                                            </a>
                                        </td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="drv_dln"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_dln">{{$driver->drv_dln}}
                                            </a><hr>
                                            <a class="testEdit" data-type="date" data-column="drv_issuedate"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_issuedate">{{$driver->drv_issuedate}}
                                            </a><hr>
                                            <a class="testEdit" data-type="date" data-column="drv_ed"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_ed">{{$driver->drv_ed}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="drv_nok_firstname"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_firstname">{{$driver->drv_nok_firstname}}
                                            </a> /
                                            <a class="testEdit" data-type="text" data-column="drv_nok_surname"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_surname">{{$driver->drv_nok_surname}}
                                            </a> /
                                            <a class="testEdit" data-type="text" data-column="drv_nok_familyname"
                                                   data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                                   data-pk="{{$driver->id}}" data-title="change"
                                                   data-name="drv_nok_familyname">{{$driver->drv_nok_familyname}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="drv_nok_mobile1"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_mobile1">{{$driver->drv_nok_mobile1}}
                                            </a> /
                                            <a class="testEdit" data-type="text" data-column="drv_nok_mobile2"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_mobile2">{{$driver->drv_nok_mobile2}}
                                            </a><hr>

                                            <a class="testEdit" data-type="text" data-column="drv_nok_landline"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_landline">{{$driver->drv_nok_landline}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="drv_nok_email"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_email">{{$driver->drv_nok_email}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="drv_nok_address"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_address">{{$driver->drv_nok_address}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="drv_nok_city"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_city">{{$driver->drv_nok_city}}
                                            </a> /
                                            <a class="testEdit" data-type="text" data-column="drv_nok_county"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_county">{{$driver->drv_nok_county}}
                                            </a> <hr>
                                            <a class="testEdit" data-type="text" data-column="drv_nok_postcode"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_postcode">{{$driver->drv_nok_postcode}}
                                            </a> <hr>
                                            <a class="testEdit" data-type="text" data-column="drv_nok_relation"
                                               data-url="{{route('drivers/updateinline', ['id'=>$driver->id])}}"
                                               data-pk="{{$driver->id}}" data-title="change"
                                               data-name="drv_nok_relation">{{$driver->drv_nok_relation}}
                                            </a>
                                        </td>

                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('drivers/delete', ['id'=>$driver->id])}}" data-id="{{ $driver->id }}" >Delete</button>
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
