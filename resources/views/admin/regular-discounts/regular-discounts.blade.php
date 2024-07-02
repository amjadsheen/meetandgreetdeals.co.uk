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
        @if(session()->get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-check"></i>{{ session()->get('success') }}
        </div>
        @endif
        <form method="post" style="float: right" action="{{ action('Admin\RegularDiscountsController@autogenerate') }}">
            @csrf
            <div class="form-group col-sm-2 topmargin20">
                <button type="submit" class="btn btn-success">Auto Generate Missing Discounts</button>
            </div>
        </form>
    </section>

    <!-- Main content -->
    <style>
        .tab__content {
            max-width: 100%;
        }

        .tab__content>div {
            width: 100%;
        }

        .tab__header.airports>div {
            padding: 10px 7px;
            font-size: 11px;
        }

        .tab__content.websites {
            padding-top: 3px;
        }

        .tab__content.terminals {
            padding-top: 3px;
        }

        .tab__header>div.tab__header--active {
            background: orange;
            color: #000;
        }

        .tab__header.websites .head-websites,
        .tab__header.terminals .head-terminals {
            margin-left: 5px;
        }

        .tab__header.websites .head-websites:first-child,
        .tab__header.terminals .head-terminals:first-child {
            margin-left: 0;
        }
    </style>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="tabs">
                    <div class="tab__header websites">
                        @foreach($websites as $website)
                        <div class="head-websites tab__header-{{$loop->iteration}} tab__header--{{ $loop->iteration === 1 ? "active" : "nnn" }}">{{$website->website_name}}</div>
                        @endforeach
                    </div>
                    <div class="tab__content websites">
                        @foreach($websites as $website)
                        <div class="tab__content-{{$loop->iteration}} tab__content--{{ $loop->iteration === 1 ? "active" : "nnn" }}">
                            <div class="tab">
                                <div class="tab__header airports">
                                    @foreach($airports as $airport)
                                    <div class="head-airports tab__header-{{$loop->iteration}} tab__header--{{ $loop->iteration === 1 ? "active" : "nnn" }}">{{$airport->airport_name}}</div>
                                    @endforeach
                                </div>
                                <div class="tab__content terminals">
                                    @foreach($terminals as $airport=>$terminal)
                                    <div class="tab__content-{{$loop->iteration}} tab__content--{{ $loop->iteration === 1 ? "active" : "nnn" }}">
                                        <div class="tab">
                                            <div class="tab__header terminals">
                                                @foreach($terminal as $single_terminal)
                                                <div class="head-terminals tab__header-{{$loop->iteration}} tab__header--{{ $loop->iteration === 1 ? "active" : "nnn" }}">{{$single_terminal->ter_name}}</div>
                                                @endforeach
                                            </div>
                                            <div class="tab__content">
                                                @foreach($terminal as $single_terminal)
                                                <div class="tab__content-{{$loop->iteration}} tab__content--{{ $loop->iteration === 1 ? "active" : "nnn" }}">
                                                    <div class="box">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">{{$website->website_name}}</h3>
                                                        </div>
                                                    </div>
                                                    <div class="box-body table-responsive" style="overflow-x:auto;">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Terminal</th>
                                                                    <th>Service</th>
                                                                    <!-- <th>Website</th> -->
                                                                    <th>Coupon</th>
                                                                    <th>Value</th>
                                                                    <th>Active</th>
                                                                </tr>
                                                                @foreach($Prices[$website->id][$airport][$single_terminal->id] as $key=>$discount)

                                                                <tr id="row-{{$discount->id}}">
                                                                    <td>{{$loop->iteration}}</td>
                                                                    <td>
                                                                        {{$discount->ter_name}}
                                                                    </td>
                                                                    <td>
                                                                        {{$discount->service_name}}
                                                                    </td>
                                                                    <!-- <td>
                                                                        {{$discount->website_name}}
                                                                    </td> -->

                                                                    <td>
                                                                        <a class="testEdit" data-type="text" data-column="dis_coupon" data-url="{{route('regular-discounts/updateinline', ['id'=>$discount->id])}}" data-pk="{{$discount->id}}" data-title="change" data-name="dis_coupon">{{$discount->dis_coupon}}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <a class="testEdit" data-type="text" data-column="dis_value" data-url="{{route('regular-discounts/updateinline', ['id'=>$discount->id])}}" data-pk="{{$discount->id}}" data-title="change" data-name="dis_value">{{$discount->dis_value}}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        @if($discount->dis_active == 1)
                                                                        <a class="testEdit" data-type="select" data-source='[{"value":1,"text":"Active"},{"value":0,"text":"Not-Active"}]' data-column="dis_active" data-url="{{route('regular-discounts/updateinline', ['id'=>$discount->id])}}" data-pk="{{$discount->id}}" data-title="change" data-name="dis_active">Active
                                                                        </a>
                                                                        @else
                                                                        <a style="color:red;" class="testEdit" data-type="select" data-source='[{"value":0,"text":"Not-Active"},{"value":1,"text":"Active"}]' data-column="dis_active" data-url="{{route('regular-discounts/updateinline', ['id'=>$discount->id])}}" data-pk="{{$discount->id}}" data-title="change" data-name="dis_active">Not-Active
                                                                        </a>
                                                                        @endif
                                                                    </td>
                                                                </tr>

                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection