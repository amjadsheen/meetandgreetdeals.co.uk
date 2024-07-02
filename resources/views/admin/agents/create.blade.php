@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Add new booking {{$title}}</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Add new booking {{$title}}</li>
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
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('agents.store') }}" >
                            @csrf
                            <!-- text input -->
                                <div class="row">
                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-success">Add {{$title}}</button>
                                </div>
                                </div>
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Company information:</h3>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label>Mother company name: *</label>
                                            <input type="text" class="form-control" name="agt_mcompany" value="" required>
                                        </div>


                                        <div class="form-group col-sm-3">
                                            <label>Email address: *</label>
                                            <input type="text" class="form-control" name="agt_email" value="" required>
                                        </div>


                                        <div class="form-group col-sm-3">
                                            <label>Company name: *</label>
                                            <input type="text" class="form-control" name="agt_company" value="" required>
                                        </div>


                                        <div class="form-group col-sm-2">
                                            <label>Registration number:</label>
                                            <input type="text" class="form-control" name="agt_compreg" value="" >
                                        </div>

                                    </div>
                                </div>


                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Partner 1 information:</h3>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label>Name:</label>
                                            <input type="text" class="form-control" name="agt_p1fname" value="" >
                                        </div>


                                        <div class="form-group col-sm-3">
                                            <label>Surname:</label>
                                            <input type="text" class="form-control" name="agt_p1surname" value="" >
                                        </div>


                                        <div class="form-group col-sm-3">
                                            <label>Mobile number 1:</label>
                                            <input type="text" class="form-control" name="agt_p1mobile1" value="" >
                                        </div>


                                        <div class="form-group col-sm-2">
                                            <label>Mobile number 2:</label>
                                            <input type="text" class="form-control" name="agt_p1mobile2" value="" >
                                        </div>

                                    </div>
                                </div>

                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Partner 2 information:</h3>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label>Name:</label>
                                            <input type="text" class="form-control" name="agt_p2fname" value="" >
                                        </div>


                                        <div class="form-group col-sm-3">
                                            <label>Surname:</label>
                                            <input type="text" class="form-control" name="agt_p2surname" value="" >
                                        </div>


                                        <div class="form-group col-sm-3">
                                            <label>Mobile number 1:</label>
                                            <input type="text" class="form-control" name="agt_p2mobile1" value="" >
                                        </div>


                                        <div class="form-group col-sm-2">
                                            <label>Mobile number 2:</label>
                                            <input type="text" class="form-control" name="agt_p2mobile2" value="" >
                                        </div>

                                    </div>
                                </div>

                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Partner 3 information:</h3>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label>Name:</label>
                                            <input type="text" class="form-control" name="agt_p3fname" value="" >
                                        </div>


                                        <div class="form-group col-sm-3">
                                            <label>Surname:</label>
                                            <input type="text" class="form-control" name="agt_p3surname" value="" >
                                        </div>


                                        <div class="form-group col-sm-3">
                                            <label>Mobile number 1:</label>
                                            <input type="text" class="form-control" name="agt_p3mobile1" value="" >
                                        </div>


                                        <div class="form-group col-sm-2">
                                            <label>Mobile number 2:</label>
                                            <input type="text" class="form-control" name="agt_p3mobile2" value="" >
                                        </div>

                                    </div>
                                </div>

                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Agent address information:</h3>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label>Address:</label>
                                            <input type="text" class="form-control" name="agt_address" value="" >
                                        </div>


                                        <div class="form-group col-sm-3">
                                            <label>City:</label>
                                            <input type="text" class="form-control" name="agt_city" value="" >
                                        </div>


                                        <div class="form-group col-sm-3">
                                            <label>County:</label>
                                            <input type="text" class="form-control" name="agt_county" value="" >
                                        </div>


                                        <div class="form-group col-sm-2">
                                            <label>Post code:</label>
                                            <input type="text" class="form-control" name="agt_postcode" value="" >
                                        </div>

                                    </div>
                                </div>


                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Additional notes:</h3>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label>Additional notes::</label>
                                            <textarea type="text" class="form-control" cols="7" rows="7"  name="agt_note"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
