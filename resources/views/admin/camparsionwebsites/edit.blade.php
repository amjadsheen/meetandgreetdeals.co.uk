@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Websites
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Websites</li>
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
                            <h3 class="box-title">Edit Website</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('camparsionwebsites.update', $id) }}"
                                  enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT')}}
                            <!-- text input -->
                                <div class="row">
                                <div class="form-group col-sm-3 topmargin20">
                                    <button type="submit" class="btn btn-primary">Edit Website</button>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>Name:</label>
                                        <input type="text" class="form-control" name="website_name"
                                               value="{{$website->website_name}}" required>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label>Url:</label>
                                        <input type="text" class="form-control" name="website_url"
                                               value="{{$website->website_url}}">
                                    </div>


                                    <div class="form-group col-sm-2">
                                        <label>Prefix:</label>
                                        <input type="text" class="form-control" name="website_prefix"
                                               value="{{$website->website_prefix}}" required>
                                    </div>
                                    <?php  $temp =array('coming_soon'=> 'coming_soon','anyar'=> 'anyar')?>
                                    <div class="form-group col-sm-2">
                                        <label>Website Templete:</label>
                                        <select class="form-control" name="website_templete">
                                            @foreach($temp as $key=>$tmp)
                                                <option {{($website->website_templete == $key) ? 'selected':'' }} value="{{$key}}">{{$tmp}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Images</h3>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-2">
                                            <label>Logo:</label>
                                            <input type="file" class="form-control" name="website_logo">
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <img style="width: 60%" src="/storage/uploads/{{$website->website_logo}}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-2">
                                            <label>Home Banner:</label>
                                            <input type="file" class="form-control" name="website_banner">
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <img style="width: 60%" src="/storage/uploads/{{$website->website_banner}}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-2">
                                            <label>Favicon:</label>
                                            <input type="file" class="form-control" name="website_favicon">
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <img style="width: 60%" src="/storage/uploads/{{$website->website_favicon}}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-2">
                                            <label>Email Banner:</label>
                                            <input type="file" class="form-control" name="website_email_banner">
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <img style="width: 60%" src="/storage/uploads/{{$website->website_email_banner}}">
                                        </div>
                                    </div>

                                </div>

                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Emails</h3>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col-sm-4">
                                            <label>Email:</label>
                                            <input type="text" class="form-control" name="email" value="{{$website->email}}">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>Alternate Email:</label>
                                            <input type="text" class="form-control" name="alternate_email" value="{{$website->alternate_email}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Contact</h3>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col-sm-4">
                                            <label>Contact Number:</label>
                                            <input type="text" class="form-control" name="contact_num" value="{{$website->contact_num}}">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>Alternate Contact Number:</label>
                                            <input type="text" class="form-control" name="alternate_contact_num" value="{{$website->alternate_contact_num}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Social</h3>
                                    </div>
                                    <div class="row">

                                        <div class="form-group col-sm-4">
                                            <label>Facebook:</label>
                                            <input type="text" class="form-control" value="{{$website->facebook}}" name="facebook">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>Twitter:</label>
                                            <input type="text" class="form-control" value="{{$website->twitter}}" name="twitter">
                                        </div>
                                    </div>
                                </div>

                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Address</h3>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label>Address:</label>
                                            <textarea type="text" class="form-control" cols="7" rows="7"
                                                      name="address">{{$website->address}}</textarea>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>Working Hours:</label>
                                            <input type="text" class="form-control" value="{{$website->working_time}}" name="working_time">
                                        </div>
                                    </div>
                                </div>


                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Meta Details</h3>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label>Meta Tile:</label>
                                            <input type="text" class="form-control" name="website_meta_title"
                                                   value="{{$website->website_meta_title}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label>Meta Description:</label>
                                            <textarea type="text" class="form-control" cols="7" rows="7"
                                                      name="website_meta_description">{{$website->website_meta_description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label>Key Words:</label>
                                            <textarea type="text" class="form-control"
                                                      name="website_meta_keywords">{{$website->website_meta_keywords}}</textarea>
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
