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
            text-align: left;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Ensures equal column width */
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
        .b1{
            background-color: #d7cdc5a3;
        }
        .b3{
            background-color: #c2bdb942;
        }
        .hidecustomer{ display:none;}
    </style>
    
</head>
<body>
    <div class="container">
        <div class="header">
        <img style="width:50%; background: linear-gradient(#dc3545ed, #c6890f) !important;" src="{{$website_logo}}" alt="Logo"><br>
        <p><a href="{{ $main_website_url }}" target="_blank">{{ $main_website_url }}</a></p>
        </div>
        <div class="content">
            <table>
                <tr>
                    <td  colspan="2" class="b133" style="text-align: center;padding: 0; line-height: 1px;background: #dcd8d4;"><h3 style="color: rgb(237, 92, 87);">Service Provider</h3></td>
                </tr>
                <tr>
                    <td  colspan="2" class="b133" style="text-align: center;">
                        <img style="width: 100%; max-width: 300px;" src="{{$campare_website_logo}}" alt="Logo">
                    </td>
                </tr>
                <tr>
                <td colspan="2" style="text-align:center">
                    {{ $website_name }} {{$service_name}}<br>
                    <p style="color: rgb(237, 92, 87);">Important note (For departure)</p>
                    <p>Upon departure for dropping your car off please call the service provider (on the number below) 40 minutes before you arrive to the terminal.</p>
                    <p><strong><a style="color: #000;" href="tel:{{$contact_num}}">{{$contact_num}}</a></strong></p> 
                    <p><strong><a style="color: #000;" href="tel:{{$alternate_contact_num}}">{{$alternate_contact_num}}</a></strong></p> 

                </td>
                </tr>
                <tr>
                    <td  colspan="2" class="b133" style="text-align: center;">&nbsp;</td>
                </tr>
                <tr>
                    <td  colspan="2" class="b133" style="text-align: center;padding: 0; line-height: 1px;background: #dcd8d4;"><h3 style="color: rgb(237, 92, 87);">Booking Details</h3></td>
                </tr>
                <tr>
                    <td class="b32">Booking Code:</td>
                    <td class="b32">{{ $bk_ref }} </td>
                </tr>
                <tr>
                    <td class="b32">Name:</td>
                    <td class="b32">{{$cus_title}} {{$cus_surname}}  {{$cus_name}} </td>
                </tr>
                <tr>   
                    <td class="b32">Mobile number:</td>
                        <td class="b32">@if($customer_contact)
                            {{$customer_contact}}
                        @else
                            {{$cus_cell}}
                        @endif   </td>
                </tr>
                <tr>
                    <td class="b32">Registration No:</td>
                    <td class="b32">{{$bk_re_nu}}</td>
                </tr>
                <tr>
                    <td class="b32">Vehicle Colour: </td>
                    <td class="b32">{{$bk_ve_co}}</td>
                </tr>
                    
                <tr>
                    <td class="b32">Departure:</td>
                    <td class="b32">{{$bk_from_date}}</td>
                </tr>
                <tr>
                    <td class="b32">Arrival:</td>
                    <td class="b32">{{$bk_to_date}}</td>
                </tr>
                
                <tr>
                    <td class="b32">Booking Status:</td>
                    <td class="b32">{!! $current_booking_status !!}</td>
                </tr>
                {!! $amount_detail !!}
                
                <tr>
                    <th>Ulez Checked</th>
                    <td>{{$ulze}}</td>
                </tr>
                <tr>
                    <td colspan="2"><span style="color:red"> We are not liable to cover any ULEZ charges. You will have to arrange yourself to pay the charge.</span></td>
                </tr>
                
                
                <tr>
                
                <td colspan="2" style="text-align:center">
                   
                    
                    <p style="color: rgb(237, 92, 87);">Important note (For Arrival)</p>
                    <p>Upon arrival for picking your car please call the number above, first call when you land and the second call when you have collected all your luggage.
                    (Any changes between your trip inform the service provider immediately)</p>
                   
                </td>
                </tr>
            </table>
        </div>
        
        <div class="content ">
            <table>
            <tr>
                <td style="text-align:center">
                    <p><strong>Heathrow Airport TERMINAL 1 – SAT-NAVIGATION POSTCODE: TW6 1AP</strong></p>
                    <p style="color: rgb(237, 92, 87);">Heathrow Airport Terminal 1 – Closed</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    <p><strong>Heathrow Airport TERMINAL 2 – SAT-NAVIGATION POSTCODE: TW6 1EW</strong></p>
                    <p>Terminal 2 short stay car park 2 level 4 row A or B.</p>
                    <p>(Take the ticket from barrier number 6 (right hand barrier) From the barrier follow the sign “off airport meet and greet parking” and park your car there.</p>
                    <p style="color: rgb(237, 92, 87);">NOTE: Be cautious there are height restrictions.</p>
                    <p style="display:none"><strong>Directions - Inner Ring E, Hounslow TW6 1EW</strong></p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    <p><strong>Heathrow Airpot TERMINAL 3- SAT-NAVIGATION POSTCODE: TW6 3QG</strong></p>
                    <p>Terminal 3 short stay car park 3 level 4 row A or B</p>
                    <p>(follow the sign off airport meet and greet parking)</p>
                    <p style="color: rgb(237, 92, 87);">NOTE: Be cautious there are height restrictions.</p>
                    <p style="display:none"><strong>Directions – Hounslow TW6 1SX</strong></p>
                    
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    <p style="display:none"><strong>Heathrow Airport TERMINAL 4- SAT-NAVIGATION POSTCODE: TW6 3XA</strong></p>
                    <p>Terminal 4 short stay car park 4 level 2 row E or F</p>
                    <p>From the barrier follow the sign “off airport meet and greet parking” and park you car there.</p>
                    <p style="color: rgb(237, 92, 87);">NOTE: Be cautious there are height restrictions.</p>
                    <p style="display:none"><strong>Directors - Hounslow TW6 3XA</strong></p>
                    
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    <p><strong>Heathrow Airport TERMINAL 5- SAT-NAVIGATION POSTCODE: TW6 2GA</strong></p>
                    <p>Terminal 5 short stay car park 5 level 4 row R or S.</p>
                    <p>From the barrier follow the sign “off airport meet and greet parking” and park you car there.</p>
                    <p style="color: rgb(237, 92, 87);">NOTE: Be cautious there are height restrictions.</p>
                    <p style="display:none"><strong>Directors –  Hounslow TW6 2GB<p><strong>
                </td>
            </tr>
           
            </table>
        </div>
    </div>
</body>
</html>
