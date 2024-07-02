@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{{$title}}</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">{{$title}}</li>
            </ol>
        </section>
        <style>
            td, th {
                padding: 5px 0;
            }
        </style>
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
                            <form method="post" id="mbooking" action="{{ route('manualbooking.store') }}">
                            @csrf
                            <!-- text input -->

                                <table  class="table">
                                    <tbody>
                                    <tr>
                                        <td valign="top" style="width: 40%;">
                                            <h2>Booking information:</h2>
                                            <table border="0" cellpadding="4" cellspacing="4">
                                                <tbody>
                                                <tr>
                                                    <td>Order date:</td>
                                                    <td><input size="10" type="text" name="bk_date" id="bk_date"
                                                               value="{{date('d/m/Y')}}" readonly="readonly"
                                                               class="form-control datepickerspecial"></td>
                                                </tr>
                                                <tr>
                                                    <td>Booking Ref number:</td>
                                                    <td><input size="16" type="text" name="bk_ref" id="bk_ref"
                                                               class="form-control">
                                                        <div id="bk_ref_err"></div>
                                                    </td>
                                                </tr>




                                                <tr>
                                                    <td>Website:</td>
                                                    <td><select class="form-control" name="website_id" required>
                                                          
                                                            @foreach($websites as $website)
                                                                <option value="{{$website->id}}">{{$website->website_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                
                                                <tr>
                                                    <td>Select Country:</td>
                                                    <td>
                                                        <select id="country" name="country" id="country" class="form-control" onchange="getairports()" required>
                                                            <option value="0">---Select an Country---</option>
                                                            @if(!$countries->isEmpty())
                                                                @foreach($countries as $country)
                                                                    @if($country->disable == 1)
                                                                        <option value="{{$country->id}}" disabled="disabled">{{$country->name}} (booking closed) </option>
                                                                    @else
                                                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Select an airport:</td>
                                                    <td>
                                                        <select class="form-control" name="airport_id" id="airport_id" onchange="getTerminals()" required>
                                                            <option value="0"> ----- Select one -----</option>
                                                        </select>
                                                        <div id="airport_id_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Departure terminal:</td>
                                                    <td valign="middle" align="left">
                                                        <select name="bk_ou_te" id="bk_ou_te" class="form-control" required>
                                                            <option value="0"> ----- Select terminal -----</option>
                                                        </select>
                                                        <div id="bk_ou_te_pro" style="float:left;"></div>
                                                        <div id="bk_ou_te_err"></div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Landing terminal:</td>
                                                    <td valign="middle" align="left">
                                                        <select name="bk_re_te" id="bk_re_te" class="form-control" required>
                                                            <option value="0"> ----- Select terminal -----</option>
                                                        </select>
                                                        <div id="bk_re_te_pro" style="float:left;"></div>
                                                        <div id="bk_re_te_err"></div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td valign="top">Departure date/time:</td>
                                                    <td>

                                                        <input size="14" type="text" name="bk_from_date"
                                                               id="bk_from_date" value="{{date("d/m/Y H:i")}}"
                                                               readonly="readonly"
                                                               onchange="document.getElementById('bk_ve_do_dt').value=this.value;"
                                                               class="form-control datepickertimespecial">
                                                        <div id="bk_from_date_err"></div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td valign="top">Landing date/time:</td>
                                                    <td>
                                                        <input type="text" name="bk_to_date" id="bk_to_date" size="14"
                                                               value="{{date("d/m/Y H:i", strtotime("+7 days"))}}" readonly="readonly"
                                                               onchange="document.getElementById('bk_ve_pu_dt').value=this.value;"
                                                               class="form-control datepickertimespecial">
                                                        <div id="bk_to_date_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Service:</td>
                                                    <td><select id="service" required name="service" class="form-control" onchange="GetTef();">
                                                            <option value="0">---Select Service---</option>
                                                            @foreach($services as $service)
                                                                <option value="{{$service->id}}">{{$service->service_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                
                                                <tr>
                                                    <td>
                                                        Select currency:
                                                    </td>
                                                    <td valign="middle" align="left">
                                                        <select name="cur_id" id="cur_id" class="form-control">
                                                            @foreach($currencies as $currency)
                                                                <option value="{{$currency->id}}">Pay in {{$currency->cur_name}} {{$currency->cur_symbol}}</option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                </tr>
                                                <tr>
                                                <td>Terminal Access Fee £</td>

                                                
                                                
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Terminal Access Fee:
                                                    </td>
                                                    <td>
                                                        <input onchange="updatePricefinal();" name="bk_access_fee" type="text" id="bk_access_fee"
                                                               style="font-size:24px;" class="form-control"
                                                                size="6"
                                                               maxlength="6">
                                                        <div id="bk_access_fee_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Order Amount:
                                                    </td>
                                                    <td>
                                                        <input onchange="updatePricefinal();" name="bk_total_amount" type="text" id="bk_total_amount"
                                                               style="font-size:24px;" class="form-control"
                                                               size="6"
                                                               maxlength="6" placeholder="">
                                                        <div id="bk_total_amount_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Total Amount:
                                                    </td>
                                                    <td>
                                                        <input readonly name="bk_total_amount_final" type="text" id="bk_total_amount_final"
                                                               style="font-size:24px;" class="form-control"
                                                                size="6"
                                                               maxlength="6" placeholder="">
                                                        <div id="bk_total_amount_final_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Payment method:
                                                    </td>
                                                    <td valign="middle" align="left">
                                                        <select name="bk_payment_method" class="form-control" id="bk_payment_method">
                                                            <option value="1">Pay later</option>
                                                            <option value="2">Paypal</option>
                                                            <option value="3">Credit Card</option>
                                                            <option value="5">Stripe</option>
                                                            <option value="6">Bank Transfer</option>
                                                            <option value="7">Cash</option>
                                                            <option value="4">Other</option>

                                                        </select></td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td valign="top" style="width: 24%">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td colspan="2" align="left"><h2> Passenger information</h2></td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td>Number of Passengers:</td>
                                                    <td>
                                                        <select name="bk_nop" class="form-control" id="bk_nop">
                                                            <option value="1">1 Passenger</option>
                                                            <option value="2">2 Passengers</option>
                                                            <option value="3">3 Passengers</option>
                                                            <option value="4">4 Passengers</option>
                                                            <option value="5">5 Passengers</option>
                                                            <option value="6">6 Passengers</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="left"><br>
                                                        <h2>Flight Detail</h2></td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td>Outbound Flight Number:</td>
                                                    <td><input name="bk_ou_fl_nu" type="text" class="form-control" id="bk_ou_fl_nu">
                                                        <div id="bk_ou_fl_nu_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Return Flight Number:</td>
                                                    <td><input name="bk_re_fl_nu" type="text" class="form-control" id="bk_re_fl_nu">
                                                        <div id="bk_re_fl_nu_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="left"><br>
                                                        <h2>Vehicle Detail</h2></td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Registration Number:</td>
                                                    <td><input name="bk_re_nu" type="text" class="form-control" id="bk_re_nu">
                                                        <div id="bk_re_nu_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Vehicle Make:</td>
                                                    <td><input name="bk_ve_ma" type="text"  class="form-control" id="bk_ve_ma">
                                                        <div id="bk_ve_ma_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Vehicle Model:</td>
                                                    <td><input name="bk_ve_mo" type="text" class="form-control" id="bk_ve_mo">
                                                        <div id="bk_ve_mo_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Vehicle Colour:</td>
                                                    <td>

                                                        <select name="bk_ve_co" class="form-control" id="bk_ve_co">
                                                            <option value="0" >-- Select vehicle color --</option>
                                                            @foreach($colors as $color)
                                                                <option value="{{$color->clr_name}}" {{ $color->clr_name == 'Other colour' ? "selected" : "" }} >{{$color->clr_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="bk_ve_co_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                    <td valign="top">Drop off date/time:</td>
                                                    <td>
                                                        <input size="14" type="text" name="bk_ve_do_dt" class="form-control datepickertimespecial" id="bk_ve_do_dt"
                                                               value="{{date("d/m/Y H:i")}}" readonly="readonly"
                                                               >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">Pick up date/time:</td>
                                                    <td>
                                                        <input size="14" type="text" name="bk_ve_pu_dt" class="form-control datepickertimespecial" id="bk_ve_pu_dt"
                                                                value="{{date("d/m/Y H:i", strtotime("+7 days"))}}" readonly="readonly"
                                                               >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>

                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td valign="top" style="width: 30%">
                                            <h2>Customer information</h2>
                                            <table border="0">

                                                <tbody>
                                                <tr>
                                                    <td>Title:</td>
                                                    <td>
                                                        <select name="cus_title" class="form-control" id="cus_title">
                                                            <option value="0">--- Select one ---</option>
                                                            <option value="Mr." selected="selected">Mr.</option>
                                                            <option value="Ms.">Ms.</option>
                                                            <option value="Mrs.">Mrs.</option>
                                                            <option value="Miss.">Miss.</option>
                                                            <option value="Dr.">Dr.</option>
                                                            <option value="">Other.</option>
                                                        </select>
                                                        <div id="cus_title_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>First Name:*</td>
                                                    <td><input name="cus_name" type="text"class="form-control" id="cus_name">
                                                        <div id="cus_name_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Surname:</td>
                                                    <td><input name="cus_surname" type="text" class="form-control" id="cus_surname">
                                                        <div id="cus_surname_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>E-mail:</td>
                                                    <td><input name="cus_email" type="text" class="form-control" id="cus_email">
                                                        <div id="cus_email_err"></div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Company:</td>
                                                    <td><input name="cus_company" type="text" class="form-control" id="cus_company"></td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Tel Number:</td>
                                                    <td><input name="cus_tele" type="text" class="form-control" id="cus_tele"></td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Mobile Number:</td>
                                                    <td><input name="cus_cell" type="text" class="form-control" id="cus_cell">
                                                        <div id="cus_cell_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Mobile Number 2:</td>
                                                    <td><input name="cus_cell2" type="text" class="form-control" id="cus_cell2"></td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Door Number / House Name:</td>
                                                    <td><input name="cus_homename" type="text" class="form-control" id="cus_homename">
                                                        <div id="cus_homename_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Address:</td>
                                                    <td><input name="cus_address" type="text" class="form-control" id="cus_address"></td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Town/City:</td>
                                                    <td><input name="cus_town" type="text" class="form-control" id="cus_town"></td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>County:</td>
                                                    <td><input name="cus_county" type="text" class="form-control" id="cus_county"></td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Post Code:</td>
                                                    <td><input name="cus_postcode" type="text" class="form-control" id="cus_postcode">
                                                        <div id="cus_postcode_err"></div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                <tr>
                                                    <td>Country:</td>
                                                    <td><input type="text" name="cus_country" class="form-control" id="cus_country"
                                                               value="United Kingdom" readonly=""></td>
                                                </tr>
                                                <tr>

                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        </tr>
                                    <tr>
                                        <td valign="top">
                                            <h2>CarWash</h2>
                                            <table>
                                                <tbody>

                                                <tr>
                                                    <td>

                                                        <select class="form-control validate[required]" name="vehical_type_id" id="vehical_type_id" onchange="getcarwashhtml()" >
                                                            <option value="">---Select Vehicle Type---</option>
                                                            @foreach($vehicaltype as $vtype)
                                                                <option value="{{$vtype->id}}">{{$vtype->v_name}} </option>
                                                            @endforeach
                                                            <option value="0"> No Thanks</option>
                                                        </select>

                                                        <div id="carwash-radio-options">
                                                        </div>

                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                        <td valign="top">
                                            Additional notes:<br>
                                            <textarea name="bk_note" class="form-control" id="bk_note" cols="80" rows="10"></textarea>
                                        </td>
                                        <td valign="top">
                                            <h2>Agent information</h2>

                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="agt_id" class="form-control" id="agt_id">
                                                            <option value="0">-- Select one or leave for no agent --
                                                            </option>
                                                            @foreach($agents as $agent)
                                                                <option value="{{$agent->id}}">{{$agent->agt_company}} </option>
                                                            @endforeach
                                                        </select>
                                                        <div id="agt_data"></div>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>

                                        </td>
                                    </tr>


                                    <tr>

                                    </tr>


                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="checkbox" name="email_to_client" id="email_to_client" value="1"> Send
                                            email to client
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" name="email_to_admins" id="email_to_admins"
                                                   value="1"> Send email to admins
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <div id="prog"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <a class=" btn btn-primary " href="{{route('manualbooking.index')}}">Reset </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="submit" class=" btn btn-succes" name="submit" id="submit" value="Submit">
                                            <div class="error" id="formerror"></div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
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
