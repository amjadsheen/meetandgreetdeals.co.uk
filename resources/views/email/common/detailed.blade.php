<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 10px 0;
        }
        .header img {
            width: 100px;
        }
        .content {
            margin-top: 20px;
        }
        .content h2 {
            color: #ff6600;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
        }
        .content table, .content th, .content td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        .content th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888888;
        }
        .center{
            text-align: center !important;
        }
        .zero{
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
        <img style="width:25%" src="{{$website_logo}}" alt="Logo">
        </div>
        <div class="content">
            

            <p class="center zero">{{ $refrence_num_extra }}</p>
            <table>
                <tr><td class="center"><h2 style="padding: 2px 0;">Reservation Code: {{ $bk_ref }}</h2>
                     @if($refrence_num_common)
                        {{$refrence_num_common}}
                    @endif
                </td></tr>
            </table>
            <table>
                <tr>
                    <th>Booking Date:</th>
                    <td>{{$bk_date}} </td>
                </tr>
                <tr>
                    <th>Airport</th>
                    <td>{{$airport_name}}</td>
                </tr>
                <tr>
                    <th>Service</th>
                    <td>{{$service_name}}</td>
                </tr>
                <tr>
                    <th>Departure date/time</th>
                    <td>{{$bk_from_date}}</td>
                </tr>
                <tr>
                    <th>Landing date/time</th>
                    <td>{{$bk_to_date}}</td>
                </tr>
                <tr>
                    <th>Outbound Flight:</th>
                    <td>{{$bk_ou_fl_nu}}</td>
                </tr>
                <tr>
                    <th>Outbound Terminal</th>
                    <td>{{$ter_name1}}</td>
                </tr>
                <tr>
                    <th>Return Flight</th>
                    <td>{{$bk_re_fl_nu}}</td>
                </tr>
                <tr>
                    <th>Return Terminal</th>
                    <td>{{$ter_name2}}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{$cus_title}} {{$cus_surname}}  {{$cus_name}}</td>
                </tr>
                <tr>
                    <th>Mobile number</th>
                    <td>
                        @if($customer_contact)
                            {{$customer_contact}}
                        @else
                            {{$cus_cell}}
                        @endif    
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$cus_email}}</td>
                </tr>
                @if($account_num)
                <tr>
                    <th>Account#</th>
                    <td>{{ $account_num }}</td>
                </tr>
                @endif
                
                <tr>
                    <th>Registration Number</th>
                    <td>{{$bk_re_nu}}</td>
                </tr>
                <tr>
                    <th>Vehicle Make</th>
                    <td>{{$bk_ve_ma}}</td>
                </tr>
                <tr>
                    <th>Vehicle Model</th>
                    <td>{{$bk_ve_mo}}</td>
                </tr>
                <tr>
                    <th>Vehicle Colour</th>
                    <td>{{$bk_ve_co}}</td>
                </tr>
                <tr>
                    <th>Drop off date/time</th>
                    <td>{{$bk_ve_do_dt}}</td>
                </tr>
                <tr>
                    <th>Pick up date/time</th>
                    <td>{{$bk_ve_pu_dt}}</td>
                </tr>
                
                <tr>
                    <th>Number of Passengers</th>
                    <td>{{$bk_nop}}</td>
                </tr>
                
                <tr>
                    <th>Luggage</th>
                    <td>{{$luggage}}</td>
                </tr>
                <tr>
                    <th>Ulze Checked</th>
                    <td>{{$ulze}}</td>
                </tr>
                
                <tr>
                    <th>Payment option</th>
                    <td>{!! $payment_option !!}</td>
                </tr>
                <tr>
                    <th>Booking Status</th>
                    <td>{!! $current_booking_status !!}</td>
                </tr>
                {!! $amount_detail !!}
            </table>
        </div>
        
        <div class="footer">
           
        </div>
    </div>
</body>
</html>
