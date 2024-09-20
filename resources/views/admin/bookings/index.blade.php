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
                {{$title}}  <a class="btn btn-sm btn-primary" href="{{route('manualbooking.index')}}"  role="button">Add New</a>
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
                    <div class="box box-warning">
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form  action="{{route('bookings.index')}}">
                                @csrf
                                <div class="form-group col-sm-2">
                                    <label>From date:</label>
                                    <input type="date" class="form-control datepickerfilterxxx" name="date1" value="{{$search_filter['date1']}}" />
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>To date:</label>
                                    <input type="date" class="form-control date1 datepickerfilterxxx" name="date2" value="{{$search_filter['date2']}}" />
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Booking Ref:</label>
                                    <input type="text" class="form-control" name="bk_ref"  value="{{$search_filter['bk_ref']}}">
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Email:</label>
                                    <input type="text" class="form-control" name="email"  value="{{$search_filter['email']}}" />
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Mobile number:</label>
                                    <input type="text" class="form-control" name="cell" value="{{$search_filter['cell']}}" />
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" name="cus_name"  value="{{$search_filter['cus_name']}}" />
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>SurName:</label>
                                    <input type="text" class="form-control" name="surname" value="{{$search_filter['surname']}}"  />
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Payment method:</label>
                                    <select class="form-control" name="payment_method">
                                        <option value="0" {{($search_filter['payment_method'] == 0) ? 'selected':'' }}>Any method</option>
                                        <option value="1" {{($search_filter['payment_method'] == 1) ? 'selected':'' }}>Pay later</option>
                                        <option value="2" {{($search_filter['payment_method'] == 2) ? 'selected':'' }}>PayPal</option>
                                        <option value="3" {{($search_filter['payment_method'] == 3) ? 'selected':'' }}>Worldpay</option>
                                        <option value="5" {{($search_filter['payment_method'] == 5) ? 'selected':'' }}>Stripe</option>
                                        <option value="6" {{($search_filter['payment_method'] == 6) ? 'selected':'' }}>Bank Transfer</option>
                                        <option value="7" {{($search_filter['payment_method'] == 7) ? 'selected':'' }}>Cash</option>
                                        <option value="4" {{($search_filter['payment_method'] == 4) ? 'selected':'' }}>other</option>
                                        <option value="8" {{($search_filter['payment_method'] == 8) ? 'selected':'' }}>Credit/Debit Card</option>
                                        <option value="9" {{($search_filter['payment_method'] == 9) ? 'selected':'' }}>Tide link</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Order Status:</label>
                                    <select class="form-control" name="bk_status">
                                        <option value="0" {{($search_filter['bk_status'] == 0) ? 'selected':'' }} >Any status</option>
                                        <option value="1" {{($search_filter['bk_status'] == 1) ? 'selected':'' }}>Pending...</option>
                                        <option value="2" {{($search_filter['bk_status'] == 2) ? 'selected':'' }}>Confirmed</option>
                                        <option value="3" {{($search_filter['bk_status'] == 3) ? 'selected':'' }}>Completed</option>
                                        <option value="4" {{($search_filter['bk_status'] == 4) ? 'selected':'' }}>Cancelled</option>
                                        <option value="5" {{($search_filter['bk_status'] == 5) ? 'selected':'' }}>Account job pending</option>
                                        <option value="6" {{($search_filter['bk_status'] == 6) ? 'selected':'' }}>Account job complete</option>
                                        <option value="7" {{($search_filter['bk_status'] == 7) ? 'selected':'' }}>Account job refund</option>
                                        <option value="8" {{($search_filter['bk_status'] == 8) ? 'selected':'' }}>Pay later payment done</option>
                                        <option value="9" {{($search_filter['bk_status'] == 9) ? 'selected':'' }}>Complaint</option>
                                        <option value="10" {{($search_filter['bk_status'] == 10) ? 'selected':'' }}>Special discount</option>
                                        <option value="11" {{($search_filter['bk_status'] == 11) ? 'selected':'' }}>Staff discount</option>
                                        <option value="12" {{($search_filter['bk_status'] == 12) ? 'selected':'' }}>Staff free</option>
                                        <option value="13" {{($search_filter['bk_status'] == 13) ? 'selected':'' }}>Customer free</option>
                                        <option value="14" {{($search_filter['bk_status'] == 14) ? 'selected':'' }}>Special customers</option>
                                        <option value="15" {{($search_filter['bk_status'] == 15) ? 'selected':'' }}>Park and Ride</option>
                                        <option value="16" {{($search_filter['bk_status'] == 16) ? 'selected':'' }}>Not paid</option>
                                        <option value="17" {{($search_filter['bk_status'] == 17) ? 'selected':'' }}>Free for late customer</option>
                                        <option value="18" {{($search_filter['bk_status'] == 18) ? 'selected':'' }}>No Show</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Company:</label>
                                    <input type="text" class="form-control" name="company"  value="{{$search_filter['company']}}"  />
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Veh. Reg. Num:</label>
                                    <input type="text" class="form-control" name="vehicle_number"  value="{{$search_filter['vehicle_number']}}"  />
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Outbound flight:</label>
                                    <input type="text" class="form-control" name="outbound_flight"  value="{{$search_filter['outbound_flight']}}" />
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Inbound flight:</label>
                                    <input type="text" class="form-control" name="inbound_flight"  value="{{$search_filter['inbound_flight']}}" />
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Airport:</label>
                                    <select class="form-control" name="airport_id">
                                        <option value="">Select</option>
                                        @foreach($allairports as $airport)
                                            <option value="{{$airport->id}}" {{($search_filter['airport_id'] == $airport->id) ? 'selected':'' }}>{{$airport->airport_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Website:</label>
                                    <select class="form-control" name="website_id">
                                        <option value="">Select</option>
                                        @foreach($websites as $website)
                                            <option value="{{$website->id}}" {{($search_filter['website_id'] == $website->id) ? 'selected':'' }}>{{$website->website_name}}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="form-group col-sm-2">
                                    <label>Show deleted:</label>
                                    <select class="form-control" name="is_del">
                                        <option {{($search_filter['is_del'] == 0) ? 'selected':'' }} value="0" >Not deleted</option>
                                        <option {{($search_filter['is_del'] == 1) ? 'selected':'' }} value="1" >Deleted only</option>
                                        <option {{($search_filter['is_del'] == 2) ? 'selected':'' }} value="2" >All orders</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-2 topmargin20">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{route('bookings.index')}}" class="btn btn-primary">Reset Filters</a>
                                </div>

                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
            <style>
                .modified, .normal{
                    width: 20px;
                    height: 20px;
                    padding: 2px;
                    color: #fff;
                }
                .modified{
                    background: orangered;
                    margin: 0 50px;
                }
                .normal{
                    background: #178e17; margin: 0 50px;
                }
            </style>
            <div class="row" id="booking-print">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$title}} <span class="modified">Modified</span> <span class="normal">Normal</span></h3>
                            <div class="box-tools pull-right">
                                <!-- Buttons, labels, and many other things can be placed here! -->
                                <!-- Here is a label for example -->
                                <button class="btn btn-default btn-xs" onclick="printDiv('booking-print')">Print</button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                <tr>
                                    <td >Sr.#</td>
                                    <td>
                                        <strong>Basic info</strong><hr>
                                        Country<hr>
                                        Website<hr>
                                        Date<hr>
                                        Booking ref.<hr>
                                        Qrcode<hr>
                                        Service<hr>
                                    </td>
                                    <td>
                                        <strong>Customer info</strong><hr>
                                        Name/SurName<hr>
                                        Email /
                                        Email 1<hr>
                                        Company<hr>
                                        Cell number<hr>
                                        No. of passengers<hr>
                                    </td>
                                    <td>
                                        <strong>Booking info</strong><hr>
                                        Airport<hr>
                                        Departure date/time<hr>
                                        Arrival date/time<hr>
                                        Duration<hr>
                                    </td>
                                    <td>
                                        <strong>Flight info</strong><hr>
                                        Outbound fight<hr>
                                        Outbound terminal<hr>
                                        Inbound flight<hr>
                                        Inbound terminal<hr>
                                    </td>
                                    <td>
                                        <strong>Vehicle info</strong><hr>
                                        Registration number<hr>
                                        Vehicle make<hr>
                                        Vehicle model<hr>
                                        Vehicle colour<hr>
                                        Drop off date/time<hr>
                                        Pick up date/time<hr>
                                    </td>

                                    <td>
                                        <strong>Pricing</strong><hr>
                                        Gross price<hr>
                                        Discount amount<hr>
                                        Access fee<hr>
                                        Net price<hr>
                                        Promotion<hr>
                                        Carwash<hr>
                                        NWH'S / LMB / Termainl Shift Charges<hr>
                  
                                        Total amount<hr>
                                    </td>
                                    <td>
                                        <strong>Status</strong><hr>
                                        Order Type<hr>
                                        Payment method<hr>
                                        Order Status<hr>
                                        D1 | P1 | P2 | D3 |P3<hr>
                                        Del / Purge/ UnDel<hr>
                                        Re-send Email<hr>
                                    </td>
                                    <td>
                                        <strong>Agent Info</strong><hr>
                                        Agent<hr>
                                        FWD agent<hr>
                                    </td>
                                </tr>
                                @foreach($bookings as $booking)
                                    <tr id="row-{{$booking->booking_id}}">
                                        <?php
                                        if($booking->checkin_status == 0 && $booking->checkout_status == 0){
                                            $bg_color = "background-color:red; color:#fff;";
                                        }else if($booking->checkin_status == 1 && $booking->checkout_status == 0){
                                            $bg_color = "background-color:yellow; color:#fff;";
                                        }else if($booking->checkin_status == 1 && $booking->checkout_status == 1){
                                            $bg_color = "background-color:greenyellow; color:#fff;";
                                        }
                                        ?>
                                        <td style="{{$bg_color}}">{{$loop->iteration}}</td>
                                        <td>{{$booking->website_name}}
                                            <hr>
                                            <a class="testEdit" data-type="select" data-column="country_id"
                                               data-source='{{$country_json}}'
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               data-title="change"
                                               data-value="{{$booking->countryid}}"
                                               data-name="country_id">{{$booking->countryname}}
                                            </a>
                                            <hr>
                                            <a class="testEdit" data-type="date" data-column="bk_date"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="bk_date">{{$booking->bk_date}}
                                            </a><hr>
                                            <a class="requiredfieldEdit" data-type="text" data-column="bk_ref"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="bk_ref">{{$booking->bk_ref}}
                                            </a><hr>
                                            <a class="requiredfieldEdit" data-type="text" data-column="refrence_num_extra"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="refrence_num_extra">{{$booking->refrence_num_extra}}
                                            </a><hr>

                                            <span >{{$booking->service_name}}</span><hr>
                                            
                                            <img style="width: 65px;" src="{{url('/storage/qrcodes/'.$booking->booking_id)}}.png" align="left" >

                                        </td>
                                        <td>
                                            {{$booking->cus_title}}
                                            <a class="testEdit" data-type="text" data-column="cus_name"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="cus_name">{{$booking->cus_name}}
                                            </a>/
                                            <a class="testEdit" data-type="text" data-column="cus_surname"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="cus_surname">{{$booking->cus_surname}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="cus_email"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->cus_id])}}"
                                               data-pk="{{$booking->cus_id}}" data-title="change"
                                               data-name="cus_email">{{$booking->cus_email}}
                                            </a> <hr>
                                            <a class="testEdit" data-type="text" data-column="cus_email_1"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->cus_id])}}"
                                               data-pk="{{$booking->cus_id}}" data-title="change"
                                               data-name="cus_email_1">{{$booking->cus_email_1}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="cus_cell"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->cus_id])}}"
                                               data-pk="{{$booking->cus_id}}" data-title="change"
                                               data-name="cus_cell">{{$booking->cus_cell}}
                                            </a><hr>
                                            <a class="testEdit" data-type="number" data-column="bk_nop"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="bk_nop">{{$booking->bk_nop}}
                                            </a><hr>
                                            Note: <a class="testEdit" data-type="textarea" data-column="bk_note"
                                                     data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                                     data-pk="{{$booking->booking_id}}"
                                                     data-title="change"
                                                     data-name="bk_note">{{$booking->bk_note}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="select" data-column="airport_id"
                                               data-source='{{$airport_json}}'
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               data-title="change"
                                               data-value="{{$booking->selected_airport_id}}"
                                               data-name="airport_id">{{$booking->airport_name}}
                                            </a>
                                            <hr>

                                            <a class="testEdit" data-type="datetime" data-column="bk_from_date"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                                {{-- data-value="{{$booking->bk_from_date}}"--}}
                                               data-title="change"
                                               data-name="bk_from_date">{{$booking->bk_from_date}}
                                            </a><hr>
                                            <a class="testEdit" data-type="datetime" data-column="bk_to_date"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                                {{--data-value="{{$booking->bk_to_date}}"--}}
                                               data-title="change"
                                               data-name="bk_to_date">{{$booking->bk_to_date}}
                                            </a><hr>
                                            {{$booking->bk_days}}  days  {{$booking->bk_hours}}  hours  {{$booking->bk_mins}} mins
                                            <hr>
                                            <button type="button" class="btn  btn-default btn-sm modal-ckin-ajax" data-url="{{route('bookings/add_check_in', ['id'=>$booking->booking_id])}}"  data-id="{{ $booking->booking_id }}" data-toggle="modal">
                                                Checkin <i style="color: {{($booking->checkin_status == 1) ? '#2bbe2beb':'red' }}" class="icon fa {{($booking->checkin_status == 1) ? 'fa-check':'fa-remove' }} "></i>
                                            </button><hr>
                                            <button type="button" class="btn  btn-default btn-sm modal-ckout-ajax" data-url="{{route('bookings/add_check_out', ['id'=>$booking->booking_id])}}"  data-id="{{ $booking->booking_id }}" data-toggle="modal">
                                                Checkout  <i style="color: {{($booking->checkout_status == 1) ? '#2bbe2beb':'red' }}" class="icon fa {{($booking->checkout_status == 1) ? 'fa-check':'fa-remove' }} "></i>
                                            </button>
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="bk_ou_fl_nu"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="bk_ou_fl_nu">{{$booking->bk_ou_fl_nu}}
                                            </a><hr>


                                            <a class="testEdit" data-type="select" data-column="bk_ou_te"
                                               data-source='{{$terminals_json}}'
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               data-title="change"
                                               data-value="{{$booking->ter_id1}}"
                                               data-name="bk_ou_te">{{$booking->ter_name1}}
                                            </a>


                                            <hr>
                                            <a class="testEdit" data-type="text" data-column="bk_re_fl_nu"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="bk_re_fl_nu">{{$booking->bk_re_fl_nu}}
                                            </a><hr>

                                            <a class="testEdit" data-type="select" data-column="bk_re_te"
                                               data-source='{{$terminals_json}}'
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               data-title="change"
                                               data-value="{{$booking->ter_id2}}"
                                               data-name="bk_re_te">{{$booking->ter_name2}}
                                            </a>

                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="text" data-column="bk_re_nu"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="bk_re_nu">{{$booking->bk_re_nu}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="bk_ve_ma"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="bk_ve_ma">{{$booking->bk_ve_ma}}
                                            </a><hr>
                                            <a class="testEdit" data-type="text" data-column="bk_ve_mo"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}" data-title="change"
                                               data-name="bk_ve_mo">{{$booking->bk_ve_mo}}
                                            </a><hr>

                                            <a class="testEdit" data-type="select" data-column="bk_ve_co"
                                               data-source='{{$colors_json}}'
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               data-title="change"
                                               data-value="{{$booking->bk_ve_co}}"
                                               data-name="bk_ve_co">{{$booking->clr_name}}
                                            </a>
                                            <hr>
                                            <a class="testEdit" data-type="datetime" data-column="bk_ve_do_dt"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               {{-- data-value="{{$booking->bk_ve_do_dt}}"--}}
                                               data-title="change"
                                               data-name="bk_ve_do_dt">{{$booking->bk_ve_do_dt}}
                                            </a><hr>
                                            <a class="testEdit" data-type="datetime" data-column="bk_ve_pu_dt"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               {{--data-value="{{$booking->bk_ve_pu_dt}}"--}}
                                               data-title="change"
                                               data-name="bk_ve_pu_dt">{{$booking->bk_ve_pu_dt}}
                                            </a><hr>
                                        </td>
                                        <td>
                                            <?php echo $booking->cur_symbol." ".number_format($booking->bk_gross_price, 2, '.', '');?>
                                            <hr>
                                            <?php echo $booking->cur_symbol." ".number_format($booking->bk_discount_amount, 2, '.', '');?>
                                            <hr>
                                            <?php echo $booking->cur_symbol." ".number_format($booking->bk_access_fee, 2, '.', '');?>
                                            <hr>

                                                <a class="testEdit" data-type="text" data-column="bk_total_amount"
                                                   data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                                   data-pk="{{$booking->booking_id}}" data-title="change"
                                                   data-name="bk_total_amount"><?php echo $booking->cur_symbol." ".number_format($booking->bk_total_amount, 2, '.', '');?>
                                                </a>
                                            <hr>
                                            <?php echo "(".$booking->bk_discount_offer_value." %) ".$booking->cur_symbol." ".number_format($booking->bk_discount_offer_amount, 2, '.', '');?>
                                             <hr>
                                             <?php $carwash = $booking->carwash_in_and_out + $booking->carwash_out_only + $booking->carwash_in_only; ?>
                                             <?php echo $booking->cur_symbol." ".number_format($carwash, 2, '.', '');?>
                                            <hr>
                                            <?php echo $booking->cur_symbol." ".number_format($booking->not_working_hours, 2, '.', '');?>
                                            <?php echo " / " . $booking->cur_symbol." ".number_format($booking->last_min_booking, 2, '.', '');?>
                                            <?php echo " / " . $booking->cur_symbol." ".number_format($booking->terminal_extra_charges, 2, '.', '');?>
                                                <hr />
                                                <?php
                                                 $ipntag = "";
                                                if (!empty($booking->txn_id)){
                                                    $ipntag = '<i style="color: #fff" class="icon fa fa-check"></i>';
                                                }
                                                $pricecolor = "#178e17";
                                                if ($booking->bk_amount_b4_update != 0){
                                                    $pricecolor = "orangered";
                                                }
                                                
                                                $bk_final_amount = $booking->bk_total_amount + $carwash + $booking->not_working_hours +  $booking->last_min_booking +  $booking->terminal_extra_charges + $booking->charging_service_charges + $booking->charging;
                                                echo '<span style="background: '.$pricecolor.'; color:#fff; padding: 4px 4px;">'.$booking->cur_symbol." ".number_format($bk_final_amount, 2, '.', '') . ' ' . $ipntag .' </span>';
                                                $supplier_cost = "";
        
                                                if ($booking->supplier_cost_type != 'none' && $booking->supplier_cost_value > 0) {
                                                    if ($booking->supplier_cost_type == 'percentage') {
                                                        // Calculate supplier cost as a percentage of the total payable amount
                                                        $supplier_cost = ($booking->supplier_cost_value / 100) * $bk_final_amount;
                                                    } else {
                                                        // Supplier cost is a fixed value
                                                        $supplier_cost = $bk_final_amount - $booking->supplier_cost_value; 
                                                    }
                                                }
                                                if(!empty($supplier_cost)){ 
                                                    $supplier_cost = number_format($supplier_cost, 2, '.', '');
                                                    echo '<br><br>Service Provider Cost: <span style="background: orangered; color:#fff; padding: 4px 4px;">'.$booking->cur_symbol." ". $supplier_cost . ' </span>';
                                                }
                                                
                                                ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($booking->bk_payment_method==1){
                                                $payment_method = "Pay later";
                                            }else if ($booking->bk_payment_method==2){
                                                $payment_method = "Paypal";
                                            }elseif ($booking->bk_payment_method==3){
                                                $payment_method = "Worldpay";
                                            }elseif ($booking->bk_payment_method==4){
                                                $payment_method = "other";
                                            }elseif ($booking->bk_payment_method==5){
                                                $payment_method = "Stripe";
                                            }elseif ($booking->bk_payment_method==6){
                                                $payment_method = "Bank Transfer";
                                            }elseif ($booking->bk_payment_method==7){
                                                $payment_method = "Cash";
                                            }elseif ($booking->bk_payment_method==8){
                                                $payment_method = "Credit/Debit Card";
                                            }elseif ($booking->bk_payment_method==9){
                                                $payment_method = "Tide link";
                                            }


                                            if ($booking->cus_oneoff==0){
                                                $cus_oneoff = "Registered";
                                            }else if ($booking->cus_oneoff==1){
                                                $cus_oneoff = "One-Off";
                                            }

                                            ?>
                                            {{$cus_oneoff}}
                                            <hr>
                                            <a class="testEdit" data-type="select" data-column="bk_payment_method"
                                               data-source='{{$payment_method_json}}'
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               data-title="change"
                                               data-value="{{$booking->bk_payment_method}}"
                                               data-name="bk_payment_method">{{$payment_method}}
                                            </a>
                                            <?php if ($booking->bk_payment_method==6){ ?>
                                            <br>
                                            Transition Ref No: 
                                            <a class="testEdit" data-type="text" data-column="bank_transition_refernce"
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               {{--data-value="{{$booking->bank_transition_refernce}}"--}}
                                               data-title="change"
                                               data-name="bank_transition_refernce">{{$booking->bank_transition_refernce}}
                                            </a>
                                            
                                            <br>
                                            <a style="cursor: pointer;color: #f19408;" class="ConfirmBooking" data-url="{{route('bookings/confirmbookingbanktransfer', ['id'=>$booking->booking_id])}}"  data-id="{{ $booking->booking_id }}">Confirm Booking</a>
                                            <?php } ?>
                                            <hr>
                                            <?php
                                            if ($booking->bk_payment_method==1){
                                                echo "Booking Status: <span style='color:red;'>Pending (Not Paid Yet)</span>";
                                            }else if ($booking->bk_payment_method==2){
                                                if ($booking->payment_status_ipn== 'Refunded'){
                                                    echo "Booking Status:  <span style='color:orangered;'>(Cancelled)</span>";
                                                }else{
                                                    echo "Booking Status:  <span style='color:#24d124;'>(Active)</span>";
                                                }
                                            }?>
                                            <hr>
                                                <?php
                                                if ($booking->bk_status==1){
                                                    $status = "Pending";}
                                                else if ($booking->bk_status==2){
                                                    $status = "Confirmed";}
                                                else if ($booking->bk_status==3){
                                                    $status = "Completed";}
                                                else if ($booking->bk_status==4){
                                                    $status = "Cancelled";}
                                                else if ($booking->bk_status==5){
                                                    $status = "Account job pending";}
                                                else if ($booking->bk_status==6){
                                                    $status = "Account job complete";}
                                                else if ($booking->bk_status==7){
                                                    $status = "Account job refund";}
                                                else if ($booking->bk_status==8){
                                                    $status = "Pay later payment done";}
                                                else if ($booking->bk_status==9){
                                                    $status = "Complaint";}
                                                else if ($booking->bk_status==10){
                                                    $status = "Special discount";}
                                                else if ($booking->bk_status==11){
                                                    $status = "Staff discount";}
                                                else if ($booking->bk_status==12){
                                                    $status = "Staff free";}
                                                else if ($booking->bk_status==13){
                                                    $status = "Customer free";}
                                                else if ($booking->bk_status==14){
                                                    $status = "Special customers";}
                                                else if ($booking->bk_status==15){
                                                    $status = "Park and Ride";}
                                                else if ($booking->bk_status==16){
                                                    $status = "Not paid";}
                                                else if ($booking->bk_status==17){
                                                    $status = "Free for late customer";}
                                                else if ($booking->bk_status==18){
                                                    $status = "No Show";}
                                                ?>

                                                <a class="testEdit" data-type="select" data-column="bk_status"
                                                   data-source='{{$status_json}}'
                                                   data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                                   data-pk="{{$booking->booking_id}}"
                                                   data-title="change"
                                                   data-value="{{$booking->bk_status}}"
                                                   data-name="bk_status">{{$status}}
                                                </a>


                                                <hr>
                                                <a href="/admin/docket?id=<?php echo $booking->booking_id; ?>&print=3&docket=1&hide_label=1" target="_new">EP</a>
                                                  | <a href="/admin/docket?id=<?php echo $booking->booking_id; ?>&print=3&docket=1" target="_new">D1</a>
                                                  | <a href="/admin/docket?id=<?php echo $booking->booking_id; ?>&print=3&docket=22" target="_new">D2</a>
                                                  |  <a href="/admin/docket?id=<?php echo $booking->booking_id; ?>&print=3&docket=22-p" target="_new">D2-P</a>
                                                | <a href="/admin/docket?id=<?php echo $booking->booking_id; ?>&print=3&docket=0" target="_new">P1</a>
                                                | <a href="/admin/docket?id=<?php echo $booking->booking_id; ?>&print=3&docket=2" target="_new">P2</a>
                                                | <a href="/admin/docket?id=<?php echo $booking->booking_id; ?>&docket=5" target="_new">D5</a>
                                                | <a href="/admin/docket?id=<?php echo $booking->booking_id; ?>&docket=5&hide_label=1" target="_new">D5-E</a>
                                                | <a href="/admin/docket?id=<?php echo $booking->booking_id; ?>&docket=6" target="_new">D6</a>
                                                <hr>

                                                @if ($booking->bk_is_del == 0 )
                                                    <a style="color:red;cursor: pointer" data-url="{{route('bookings/delete', ['id'=>$booking->booking_id])}}"  data-id="{{ $booking->booking_id }}" class="delthisbooking" > Delete </a>
                                                @endif

                                                @if($booking->bk_is_del == 1 )
                                                </div>
                                                <a style="color:red; cursor: pointer;" data-url="{{route('bookings/purge', ['id'=>$booking->booking_id])}}"  data-id="{{ $booking->booking_id }}" class="purgeThis" > Purge </a> |
                                                <a style="color:red;cursor: pointer" data-url="{{route('bookings/undelete', ['id'=>$booking->booking_id])}}"  data-id="{{ $booking->booking_id }}" class="undelThis" > Un-Delete </a>
                                                @endif

                                                <hr>
                                                <a style="cursor: pointer;color: #f19408;" class="ResendEmail" data-url="{{route('bookings/send_email_to_customer', ['id'=>$booking->booking_id])}}"  data-id="{{ $booking->booking_id }}">Re-Send Email</a>
                                                @if($booking->bk_email_flag == 1 )
                                                        <i style="color: #2bbe2beb" class="icon fa fa-check"></i>
                                                 @else
                                                        <i style="color: #2bbe2beb; display: none" id="res{{ $booking->booking_id }}" class="icon fa fa-check"></i>
                                                @endif
                                               <br>
                                                <a style="display:none;cursor: pointer; color: #f19408;"  class="ResendEmailPayment"  data-url="{{route('bookings/send_payment_email', ['id'=>$booking->booking_id])}}"  data-id="{{ $booking->booking_id }}"  id="res-pay{{ $booking->booking_id }}">Re-Send Payment Email</a>
                                                <br>
                                                <a style="cursor: pointer;color: #f19408;"  class="printdone"  data-url="{{route('bookings/printdone', ['id'=>$booking->booking_id])}}"  data-id="{{ $booking->booking_id }}" >Print Done</a>
                                                @if($booking->bk_print_flag == 1 )
                                                        <i style="color: #2bbe2beb" class="icon fa fa-check"></i>
                                                @else
                                                    <i style="color: #2bbe2beb; display: none;"  id="print{{ $booking->booking_id }}" class="icon fa fa-check"></i>
                                                @endif
                                        </td>
                                        <td>
                                            <a class="testEdit" data-type="select" data-column="agent_id"
                                               data-source='{{$agents_json}}'
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               data-title="change"
                                               data-value="{{$booking->agt1_id}}"
                                               data-name="agent_id">{{$booking->agt1_company}}
                                            </a>

                                            <hr>
                                            <a class="testEdit" data-type="select" data-column="fwd_agt_id"
                                               data-source='{{$agents_json}}'
                                               data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                               data-pk="{{$booking->booking_id}}"
                                               data-title="change"
                                               data-value="{{$booking->fagt_id}}"
                                               data-name="fwd_agt_id">{{$booking->fagt_company}}
                                            </a>
                                            <hr>

                                            Agent Note:<a class="testEdit" data-type="textarea" data-column="bk_agtnote"
                                                          data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                                          data-pk="{{$booking->booking_id}}"
                                                          data-title="change"
                                                          data-name="bk_agtnote">{{$booking->bk_agtnote}}
                                            </a>
                                            <hr>
                                            Fwd Agent Note:<a class="testEdit" data-type="textarea" data-column="bk_fagtnote"
                                                              data-url="{{route('bookings/updateinline', ['id'=>$booking->booking_id])}}"
                                                              data-pk="{{$booking->booking_id}}"
                                                              data-title="change"
                                                              data-name="bk_fagtnote">{{$booking->bk_fagtnote}}
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
{{--                            {{ $bookings->links() }}--}}
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-ckout" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        ###
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <form role="form" id="ckinoutform">
                        <input type="hidden" id="ckin_ckout_bk_id" name="ckin_ckout_bk_id" value="">
                        <input type="hidden" id="cin_out_table" name="cin_out_table"  value="">
                        <input type="hidden" id="ckin_ckout_route" value="">
                        <div class="form-group showhide">
                            <label for="exampleInputEmail1">
                                Select a driver:</label>
                            <select class="form-control" name="drv_id" id="drv_id" required>
                                <option value=""> ----- Select one ----- </option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">{{$driver->drv_firstname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group showhide">
                            <label for="exampleInputEmail1">
                                <span class="ctype">Checkin</span>  point type:</label>
                            <select class="form-control" name="ck_in_out_type" id="ck_in_out_type" onChange="getcotlocs();">
                                <option value=""> ----- Select one ----- </option>
                                <option value=1>Terminal</option>
                                <option value=2>Hotel</option>
                            </select>
                        </div>
                        <div class="form-group showhide">
                            <label for="exampleInputEmail1">
                                <span class="ctype">Checkin</span> points:</label>
                            <select class="form-control" name="ck_in_out_point" id="ck_in_out_point">
                                <option value=""> ----- Select one ----- </option>
                            </select>
                        </div>
                        <div class="form-group showhide">
                            <label for="exampleInputEmail1">
                                Date/Time:</label>
                            <input type="text" id="cot_datetime" name="cot_datetime" value="{{date('Y-m-d H:i')}}" class="form-control datepickertime">
                        </div>
                        <div class="form-group showhide">
                            <label for="exampleInputEmail1">
                                Remarks:</label>
                            <textarea class="form-control" name="cot_remarks" id="cot_remarks" ></textarea>
                            <div style="text-align: center; color: red" id="ckin_out_error"></div>
                            <div style="text-align: center; color: green" id="ckin_out_success"></div>
                        </div>
                    </form>


                </div>

                <!-- Modal Footer -->
                <div class="modal-footer showhide">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" data-url="{{route('bookings/add_ckin_ckou_form')}}" id="docheckout">
                        Add <span class="ctype">Checkin</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content-wrapper -->
@endsection
