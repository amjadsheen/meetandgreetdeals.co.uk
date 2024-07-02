@extends('admin.layouts.app')

@section('content')
<style>
select[multiple], select[size] {
    min-height: 170px;
    overflow: scroll;
}
</style>
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
            <form method="post" style="float: right" action="{{ action('Admin\ReqularPricesController@autogenerate') }}">
                @csrf
                <div class="form-group col-sm-2 topmargin20">
                    <button type="submit" class="btn btn-success">Auto Generate Missing Prices</button>
                </div>
            </form>
        </section>
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <div class="box-body">
                                <form method="post"  action="{{ action('Admin\ReqularPricesController@autogeneratefixedprices') }}">
                                @csrf
                                <!-- text input -->
                                    <div class="form-group col-sm-2">
                                        <label>Website</label>
                                        <select class="form-control" name="website" required>
                                           <!-- <option value="">Select</option>-->
                                            @foreach($websites as $website)
                                                <option value="{{$website->id}}">{{$website->website_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label>Country</label>
                                        <select class="form-control" id="country" name="country" onchange="getairportsPricing()" required>
                                            <option value="">Select</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label>Airport</label>
                                        <select class="form-control" id="airport" name="airport" onchange="getTerminalsPricing()" required>
                                            <option value="">Select</option>
                                            {{--                                            @foreach($airports as $airport)--}}
                                            {{--                                                <option value="{{$airport->id}}">{{$airport->airport_name}}</option>--}}
                                            {{--                                            @endforeach--}}
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label>Terminal</label>
                                        <select class="form-control" id="terminal" name="terminal[]" required multiple>
                                            <!-- <option value="">Select</option> -->
                                            {{--                                            @foreach($allterminal as $terminal)--}}
                                            {{--                                                <option value="{{$terminal->id}}">{{$terminal->ter_name}}</option>--}}
                                            {{--                                            @endforeach--}}
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label>Service</label>
                                        <select  id="servicesselect" name="service[]" required multiple>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}">{{$service->service_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-1">
                                        <label>Days</label>
                                        <select name="start_day[]" id='dayselect' multiple required>
                                            <?php for($i=1; $i<=30; $i++){ ?>
                                            <option value='cal_d<?php echo $i;?>'>D.<?php echo $i;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-1">
                                        <label>Price</label>
                                        <input type="number" min="0" class="form-control" name="fixed_price" required>
                                    </div>


                                    <div class="form-group col-sm-12">
                                        <button type="submit" style="float:right;" class="btn btn-primary">Set Price</button>
                                    </div>

                                </form>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
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
            .tab__content.websites{
                padding-top: 3px;
            }
            .tab__content.terminals{
                padding-top: 3px;
            }
            .tab__header>div.tab__header--active {
                background: orange;
                color: #000;
            }

            .tab__header.websites .head-websites, .tab__header.terminals .head-terminals{
                margin-left: 5px;
            }
            .tab__header.websites .head-websites:first-child, .tab__header.terminals .head-terminals:first-child {
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
{{--                                                                                <th>Website</th>--}}
                                                                                <th>Terminal</th>
                                                                                <th>Service</th>
                                                                                <th>D.1</th>
                                                                                <th>D.2</th>
                                                                                <th>D.3</th>
                                                                                <th>D.4</th>
                                                                                <th>D.5</th>
                                                                                <th>D.6</th>
                                                                                <th>D.7</th>
                                                                                <th>D.8</th>
                                                                                <th>D.9</th>
                                                                                <th>D.10</th>
                                                                                <th>D.11</th>
                                                                                <th>D.12</th>
                                                                                <th>D.13</th>
                                                                                <th>D.14</th>
                                                                                <th>D.15</th>
                                                                                <th>D.16</th>
                                                                                <th>D.17</th>
                                                                                <th>D.18</th>
                                                                                <th>D.19</th>
                                                                                <th>D.20</th>
                                                                                <th>D.21</th>
                                                                                <th>D.22</th>
                                                                                <th>D.23</th>
                                                                                <th>D.24</th>
                                                                                <th>D.25</th>
                                                                                <th>D.26</th>
                                                                                <th>D.27</th>
                                                                                <th>D.28</th>
                                                                                <th>D.29</th>
                                                                                <th>D.30</th>
                                                                                <th>Fix rate</th>
                                                                                <th>Access fee</th>
                                                                                <th>VAT %</th>
                                                                                <th>Online Fee %</th>
                                                                                <th>Booking Fee</th>
                                                                            </tr>
                                                                    @foreach($Prices[$website->id][$airport][$single_terminal->id] as $key=>$price)

                                                                        <tr id="row-{{$price->id}}">
                                                                            <td>{{$loop->iteration}}</td>
{{--                                                                            <td>--}}
{{--                                                                                {{$price->website_name}}--}}
{{--                                                                            </td>--}}
                                                                            <td>
                                                                                {{$price->ter_name}}
                                                                            </td>
                                                                            <td>
                                                                                {{$price->service_name}}
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d1"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d1">{{$price->cal_d1}}
                                                                                </a>
                                                                            </td>

                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d2"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d2">{{$price->cal_d2}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d3"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d3">{{$price->cal_d3}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d4"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d4">{{$price->cal_d4}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d5"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d5">{{$price->cal_d5}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d6"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d6">{{$price->cal_d6}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d7"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d7">{{$price->cal_d7}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d8"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d8">{{$price->cal_d8}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d9"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d9">{{$price->cal_d9}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d10"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d10">{{$price->cal_d10}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d11"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d11">{{$price->cal_d11}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d12"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d12">{{$price->cal_d12}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d13"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d13">{{$price->cal_d13}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d14"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d14">{{$price->cal_d14}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d15"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d15">{{$price->cal_d15}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d16"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d16">{{$price->cal_d16}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d17"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d17">{{$price->cal_d17}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d18"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d18">{{$price->cal_d18}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d19"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d19">{{$price->cal_d19}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d20"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d20">{{$price->cal_d20}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d21"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d21">{{$price->cal_d21}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d22"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d22">{{$price->cal_d22}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d23"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d23">{{$price->cal_d23}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d24"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d24">{{$price->cal_d24}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d25"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d25">{{$price->cal_d25}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d26"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d26">{{$price->cal_d26}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d27"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d27">{{$price->cal_d27}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d28"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d28">{{$price->cal_d28}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d29"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d29">{{$price->cal_d29}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_d30"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_d30">{{$price->cal_d30}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_fix_rate"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_fix_rate">{{$price->cal_fix_rate}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_access_fee"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_access_fee">{{$price->cal_access_fee}}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_vat"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_vat">{{$price->cal_vat}}
                                                                                </a>%
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_online_fee"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_online_fee">{{$price->cal_online_fee}}
                                                                                </a>%
                                                                            </td>
                                                                            <td>
                                                                                <a class="testEdit" data-type="text" data-column="cal_booking_fee"
                                                                                   data-url="{{route('regular-prices/updateinline', ['id'=>$price->id])}}"
                                                                                   data-pk="{{$price->id}}" data-title="change"
                                                                                   data-name="cal_booking_fee">{{$price->cal_booking_fee}}
                                                                                </a>
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
 <!-- mutiselect -->
<script src="{{ asset('js/admin/multiselect/js/multiselect.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('js/admin/multiselect/css/multiselect.css') }}">
<!-- /mutiselect -->   
<script>
	    document.multiselect('#dayselect')
		.setCheckBoxClick("checkboxAll", function(target, args) {
			console.log("Checkbox 'Select All' was clicked and got value ", args.checked);
		})
        document.multiselect('#servicesselect')
		.setCheckBoxClick("checkboxAll", function(target, args) {
			console.log("Checkbox 'Select All' was clicked and got value ", args.checked);
		})
		.setCheckBoxClick("1", function(target, args) {
			console.log("Checkbox for item with value '1' was clicked and got value ", args.checked);
		});
</script>
@endsection
