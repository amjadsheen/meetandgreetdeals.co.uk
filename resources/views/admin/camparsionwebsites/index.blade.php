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
                            <h3 class="box-title">Add New Camparsion Website</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('camparsionwebsites.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-2">
                                    <label>Website:</label>
                                    <input type="text" class="form-control" name="website_name" required>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Url:</label>
                                    <input type="text" class="form-control" name="website_url" required>
                                </div>

                                <!-- <div class="form-group col-sm-2">
                                    <label>Prefix:</label>
                                    <input type="text" class="form-control" name="website_prefix" required>
                                </div> -->

                                <div class="form-group col-sm-2">
                                    <label>Logo:</label>
                                    <input type="file" class="form-control" name="website_logo" >
                                </div>

                                <!-- <div class="form-group col-sm-2">
                                    <label>Favicon:</label>
                                    <input type="file" class="form-control" name="website_favicon" >
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Email Banner:</label>
                                    <input type="file" class="form-control" name="website_email_banner" >
                                </div> -->

                                <div class="form-group col-sm-2 topmargin20">
                                    <button type="submit" class="btn btn-primary">Add Website</button>
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
                            <h3 class="box-title">Camparsion Websites</h3>
                        </div>
                        <!-- /.box-header -->
                        <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 2%">#</th>
                                    <th style="width: 10%">Name</th>
                                    <th>Url</th>
                                    <!-- <th>Prefix</th> -->
                                    <th>Logo</th>
                                    <th style="width: 10%;">Supplier Cost Type</th>
                                    <th style="width: 10%;">Supplier Cost Value</th>
                                    <th>Status</th>
                                    <th style="width: 10%;">Show HomePage</th>
                                    <th>Show Link</th>
                                    <th>Actions</th>

                                </tr>
                                @if($websites->count() > 0)
                                @foreach($websites as $website)
                                    <tr id="row-{{$website->id}}">
                                        <td>{{$loop->iteration}}</td>



                                        <td>
                                            <a class="testEdit" data-type="text" data-column="website_name"
                                               data-url="{{route('websites/updateinline', ['id'=>$website->id])}}"
                                               data-pk="{{$website->id}}" data-title="change"
                                               data-name="website_name">{{$website->website_name}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="website_url"
                                               data-url="{{route('websites/updateinline', ['id'=>$website->id])}}"
                                               data-pk="{{$website->id}}" data-title="change"
                                               data-name="website_url">{{$website->website_url}}
                                            </a>
                                        </td>

                                        <!-- <td>
                                            <a class="testEdit" data-type="text" data-column="website_prefix"
                                               data-url="{{route('websites/updateinline', ['id'=>$website->id])}}"
                                               data-pk="{{$website->id}}" data-title="change"
                                               data-name="website_prefix">{{$website->website_prefix}}
                                            </a>
                                        </td> -->

                                        <td>
                                            <img style="width: 8%" src="/storage/uploads/{{$website->website_logo}}">
                                            {{--<a class="testEdit" data-type="text" data-column="image"--}}
                                               {{--data-url="{{route('banners/updateinline', ['id'=>$website->id])}}"--}}
                                               {{--data-pk="{{$website->id}}" data-title="change"--}}
                                               {{--data-name="image">{{$website->image}}--}}
                                            {{--</a>--}}
                                        </td>
                                        

                                       



                                        <td>
                                            <a class="testEdit" data-type="select"
                                            data-source='[{"value":"percentage","text":"percentage"},{"value":"fixed","text":"fixed"},{"value":"none","text":"none"}]' 
                                            data-column="supplier_cost_type"
                                            data-url="{{ route('websites/updateinline', ['id' => $website->id]) }}" 
                                            data-pk="{{ $website->id }}"
                                            data-title="Change Status" 
                                            data-name="supplier_cost_type">
                                            {{ $website->supplier_cost_type }}
                                            </a>
                                        </td>


                                        <td>
                                            <a class="testEdit" data-type="text" data-column="supplier_cost_valuepercentage"
                                               data-url="{{route('websites/updateinline', ['id'=>$website->id])}}"
                                               data-pk="{{$website->id}}" data-title="change"
                                               data-name="supplier_cost_value">{{$website->supplier_cost_value}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="select"
                                            data-source='[{"value":1,"text":"Disable"},{"value":0,"text":"Enable"}]' 
                                            data-column="disable"
                                            data-url="{{ route('websites/updateinline', ['id' => $website->id]) }}" 
                                            data-pk="{{ $website->id }}"
                                            data-title="Change Status" 
                                            data-name="disable">
                                            {{ $website->disable == 1 ? 'Disabled' : 'Enabled' }}
                                            </a>
                                        </td>

                                        <td>
                                            @if($website->show_homepage == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":1,"text":"show"},{"value":0,"text":"hide"}]' data-column="show_homepage"
                                                     data-url="{{route('websites/updateinline', ['id'=>$website->id])}}" data-pk="{{$website->id}}"
                                                     data-title="change" data-name="show_homepage">show
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":0,"text":"hide"},{"value":1,"text":"show"}]' data-column="show_homepage"
                                                 data-url="{{route('websites/updateinline', ['id'=>$website->id])}}" data-pk="{{$website->id}}"
                                                 data-title="change" data-name="show_homepage">hide
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
                                            @if($website->show_link == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":1,"text":"show"},{"value":0,"text":"hide"}]' data-column="show_link"
                                                     data-url="{{route('websites/updateinline', ['id'=>$website->id])}}" data-pk="{{$website->id}}"
                                                     data-title="change" data-name="show_link">show
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":0,"text":"hide"},{"value":1,"text":"show"}]' data-column="show_link"
                                                 data-url="{{route('websites/updateinline', ['id'=>$website->id])}}" data-pk="{{$website->id}}"
                                                 data-title="change" data-name="show_link">hide
                                                 </a>
                                            @endif
                                        </td>

                                        <!-- <td>
                                            {{$website->website_templete}}
                                        </td> -->

                                        <td>
                                            <a href="{{action('Admin\CamparsionWebsiteController@edit',$website->id)}}" class="btn btn-primary">Edit</a>
                                            @if($website->id == 99)
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('websites/delete', ['id'=>$website->id])}}" data-id="{{ $website->id }}" >Delete</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
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
