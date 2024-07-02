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
        <section class="content-header">
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
                            [Note * Try to Create Max 50 promotion codes at a Time]
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form method="post" action="{{ route('promotion-offers.store') }}">
                            @csrf
                            <!-- text input -->
                                <div class="form-group col-sm-2">
                                    <label>Website:</label>
                                    <select class="form-control"  name="website_id" required>
                                        <!-- <option value="">--None--</option> -->
                                        @foreach($websites as $website)
                                            <option value="{{$website->id}}">{{$website->website_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Company:</label>
                                    <select class="form-control"  name="promotion_company_id">
                                        <option value="0">--None--</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Start Date:</label>
                                    <?php $today = date("Y-m-d"); ?>
                                    <input type="date" class=" form-control"  value="{{$today}}" name="offer_date1" required>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>End Date:</label>
                                    <?php $tomorrow = date("Y-m-d", strtotime("+ 7 days")); ?>
                                    <input type="date" class=" form-control"  value="{{$tomorrow}}" name="offer_date2" required>
                                </div>
                                <div class="form-group col-sm-1">
                                    <label>Percentage:</label>
                                    <input type="text" class="form-control"  name="offer_percentage" required>
                                </div>
                                <div class="form-group col-sm-1">
                                    <label>Coupons#:</label>
                                    <input type="number" min="1" class="form-control"  name="num_of_coupon" required>
                                </div>
                                <div class="form-group col-sm-2 topmargin20">
                                    <button type="submit" class="btn btn-primary">Generate</button>
                                </div>

                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>

        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                @foreach($promotions as $key=>$single_promo)
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Promotion Offers</h3>
                        </div>
                        <div class="box-header with-border">
                            <form role="form" action="{{ route('promotion-offers.index') }}">
                                <div class="form-group">
                                    <select name="filter_website" class="form-control" onchange="this.form.submit()">
                                         <!-- <option value="">Select</option>-->
                                        @foreach($websites as $website)
                                            <option {{($filter_website == $website->id) ? 'selected':'' }} value="{{$website->id}}">{{$website->website_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Website</th>
                                    <th>Company</th>
                                    <th>Coupon</th>
                                    <th>Percentage %</th>
                                    <th width="85px">Start Date</th>
                                    <th width="85px">End Date</th>
                                    <th>Home Page</th>
                                    <th>Special (email)</th>
                                    <th>Status</th>
                                    <th>Auto Deactivate</th>
                                    <th>UsedBy</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($single_promo as $promotion)
                                    <tr id="row-{{$promotion->id}}">
                                        <td>{{$loop->iteration}}</td>

                                        <td>
                                            <a class="testEdit" data-type="select" data-column="website_id"
                                               data-source='{{$websites_json}}'
                                               data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                               data-pk="{{$promotion->id}}" data-title="change"
                                               data-name="website_id">{{$promotion->website_name}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="select" data-column="promotion_company_id"
                                               data-source="{{$company_json}}"
                                               data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                               data-pk="{{$promotion->id}}" data-title="change"
                                               data-name="promotion_company_id">{{$promotion->company_name}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="offer_coupon"
                                               data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                               data-pk="{{$promotion->id}}" data-title="change"
                                               data-name="offer_coupon">{{$promotion->offer_coupon}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="offer_percentage"
                                               data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                               data-pk="{{$promotion->id}}"
                                               data-title="change"
                                               data-name="offer_percentage">{{$promotion->offer_percentage}}

                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="date" data-column="offer_date1"
                                               data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                               data-pk="{{$promotion->id}}" data-title="change"
                                               data-name="offer_date1">{{$promotion->offer_date1}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="date" data-column="offer_date2"
                                               data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                               data-pk="{{$promotion->id}}" data-title="change"
                                               data-name="offer_date2">{{$promotion->offer_date2}}
                                            </a>
                                        </td>
                                        <td>
                                            @if($promotion->offer_home == 1)

                                            <a class="special" data-type="select" data-column="offer_home"
                                                   data-source='[{"value":0,"text":"Unset HomePage"}]'
                                                   data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                                   data-pk="{{$promotion->id}}" data-title="change"
                                                   data-website="{{$filter_website}}"
                                                   data-name="offer_home">Unset
                                                </a>

                                            @else

                                                <a class="special" data-type="select" data-column="offer_home"
                                                   data-source='[{"value":1,"text":"Set HomePage"}]'
                                                   data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                                   data-pk="{{$promotion->id}}" data-title="change"
                                                   data-website="{{$filter_website}}"
                                                   data-name="offer_home">Set
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($promotion->offer_special == 1)

                                            <a class="special" data-type="select" data-column="offer_special"
                                                   data-source='[{"value":0,"text":"Remove Special"}]'
                                                   data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                                   data-pk="{{$promotion->id}}" data-title="change"
                                                   data-website="{{$filter_website}}"
                                                   data-name="offer_special">Unset
                                                </a>
                                            @else

                                                <a class="special" data-type="select" data-column="offer_special"
                                                   data-source='[{"value":1,"text":"Set Special"}]'
                                                   data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                                   data-pk="{{$promotion->id}}" data-title="change"
                                                   data-website="{{$filter_website}}"
                                                   data-name="offer_special">Set
                                                </a>
                                            @endif

                                        </td>
                                        <td>

                                            @if($promotion->offer_active == 1)

                                                <a style="color: green" class="testEdit" data-type="select" data-column="offer_active"
                                                   data-source='[{"value":0,"text":"Disable"},{"value":1,"text":"Enable"}]'
                                                   data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                                   data-pk="{{$promotion->id}}" data-title="change"
                                                   data-name="offer_active">Enabled
                                                </a>
                                            @else

                                                <a class="testEdit" data-type="select" data-column="offer_active"
                                                   data-source='[{"value":1,"text":"Enable"},{"value":0,"text":"Disable"}]'
                                                   data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                                   data-pk="{{$promotion->id}}" data-title="change"
                                                   data-name="offer_active">Disabled
                                                </a>
                                            @endif

                                        </td>
                                        <td>
                                            @if($promotion->offer_auto_deactivate == 1)

                                                <a class="testEdit" data-type="select" data-column="offer_auto_deactivate"
                                                   data-source='[{"value":0,"text":"Disable"},{"value":1,"text":"Enable"}]'
                                                   data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                                   data-pk="{{$promotion->id}}" data-title="change"
                                                   data-name="offer_auto_deactivate">Enabled
                                                </a>
                                            @else

                                                <a class="testEdit" data-type="select" data-column="offer_auto_deactivate"
                                                   data-source='[{"value":1,"text":"Enable"},{"value":0,"text":"Disable"}]'
                                                   data-url="{{route('promotion-offers/updateinline', ['id'=>$promotion->id])}}"
                                                   data-pk="{{$promotion->id}}" data-title="change"
                                                   data-name="offer_auto_deactivate">Disabled
                                                </a>
                                            @endif

                                        </td>
                                        <td>
                                            @if($promotion->used_count == 0)
                                                N/A
                                            @else
                                                <button data-url="{{route('promotion-offers/getcustomers', ['id'=>$promotion->id])}}"  data-id="{{ $promotion->id }}" type="button" class="btn btn-primary label-success showdetails">
                                                    View Details <span class="badge badge-light "> {{$promotion->used_count}} </span>
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('promotion-offers/delete', ['id'=>$promotion->id])}}" data-id="{{ $promotion->id }}" >Delete</button>
                                        </td>

                                    </tr>
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
    <div id="classModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <h4 class="modal-title" id="classModalLabel">
                       Detail view
                    </h4>
                </div>
                <div class="modal-body">
                    <table id="classTable" class="table table-bordered">
                        <thead>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Booking Ref#</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Contact# </td>
                            <td>Contact# </td>
                            <td>Reg#</td>
                            <td>Date</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
