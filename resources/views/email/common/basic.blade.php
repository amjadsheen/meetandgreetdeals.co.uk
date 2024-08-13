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
    </style>
    
</head>
<body>
    <div class="container">
        <div class="header">
        <img style="width:50%; background: linear-gradient(#dc3545ed, #c6890f) !important;" src="{{$website_logo}}" alt="Logo"><br>
        <span class="common"><i class="bi bi-envelope-fill"></i><a href="mailto:{{$campare_site_email}}">{{$campare_site_email}}</a>&nbsp;</span>
          <span class="common"><i class="bi bi-envelope-fill"></i><a href="mailto:{{$campare_alternate_email}}">{{$campare_alternate_email}}</a></span>
        <p>{{$campare_working_time}}</p>
        </div>
        <div class="content">
            <table>
                <tr>
                    <td class="b1" colspan="2">Booking Details</h2></td>
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
                    <td  colspan="2" class="b1">Parking</h2></td>
                </tr>
                
                <tr>
                <td style="text-align:center"><img style="width: 80%; " src="{{$campare_website_logo}}" alt="Logo"></td>
                <td>
                    {{ $website_name }}
                    {{ $airport_name }}  <a href="{{$directions}}" target="_blank">directions</a><br>
                    <p>Upon departure please cal the service provide minutes 40 mins before you arrive to the terminal dropping your car off. </P>
                    <span><a style="color: #000;" href="tel:{{$contact_num}}">{{$contact_num}}</a> / <a style="color: #000;" href="tel:{{$alternate_contact_num}}">{{$alternate_contact_num}}</a></span>
                    <p>Upon arrival please call above  numbers to the service provider, first call when you land and the second call when you have collected all your luggage.</p>
                   
                </td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <p style="text-align: left;"><strong>Please note:</strong></p>
                <ul style="text-align:left;">
                    <li>Drop-off Procedure Please call {{ $website_name }} Please look out for your chauffeur who will be wearing a {{ $website_name }} Hi Visibility jacket and carrying ID. Please make sure that the driver has all the correct booking details that you have given when booking. Please note that your specified meet time. appointed. If you should arrive before or after this time this may result in a delay. As a car park provider, {{ $website_name }} will pay up to the first 15 minutes of parking, and the customer responsible for the extra exit fee if 15 minutes is over. </li>
                    <li>Directions Terminal 2: When you have exited the tunnel for all terminals follow the sign of terminal 2 keep to the right passing the central bus station. Continue to keep right as the road to Terminal 2 will move away from the building before turning back as the road ramps up to Terminal 2 Departures and the short stay 2 car park on Constellation Way. On the ramp continue to keep right because the ramp will lead directly into the Short stay car park entry barriers. When you enter the car park on level 4 continue left down the spiral to meet and greet area. One of level 2 following the signs for off airport parking and park your vehicle uniformed chauffeurs will meet you at your car with a your booking detail. </li>
                    <li>Post Code: TW6 1EW Terminal 3: When Entering Heathrow Airport, following signs for Terminal 3, "Valet drop off point". Park your vehicle in Lane 5 (furthest lane away from the Terminal Building). You will see a sign on the floor marked Permit Holders on the left hand side, park your vehicle there. One of uniformed chauffeurs willa meet you at your car with all your booking detail.</li>
                    <li>Terminal 4: When Entering Heathrow Airport, following signs for Terminal 4, "Departure Passenger Drop Off". As you go on the ramp towards Terminal 4, keep your vehicle in the left hand lane. Enter into Lane A (lane 3), which is the furthest lane away from the Terminal. Park your vehicle there, one of uniformed chauffeurs will meet you at your car with all your booking detail. </li>
                    <li>Post Code: TW6 3XA Terminal 5: Follow the signs for Short stay Car Park found on the right hand side of the ramp as your enter the exit for Terminal 5 roundabout. After following the signs for Short Stay Car Park, you will see sign on the left-hand lane marked "LEVEL 4". Stay in this lane which will take you straight to a set of barriers (last barrier).Take the ticket from the barrier and make your way to Zones R or S. Park your vehicle in these designated areas which is sign posted in these zones as Meet and Greet or Off Airport. One of uniformed chauffeurs will meet you at your car with all your booking details. Post Code: TW6 2GA </li>
                    <li>Return Procedure Please call {{ $website_name }} on {{$contact_num}} / {{$alternate_contact_num}} As soon as you arrive from your trip give {{ $website_name }} a call when you have landed and a second call when you have collected all the bags/luggage. </li>
                    <li>TERMINAL - 2: Once you have collected your luggage and are about to clear Customs, call the number given when your car was collected. Make your way to the same place where you dropped your vehicle which was the Level 2 short stay car park and you will meet our driver in meet and greet Off Airport Meet and Greet with your vehicle.</li>
                    <li>TERMINAL -3: Once you have collected your luggage and are about to clear Customs, call the number given when your car was collected. As you arrive at the arrivals in Terminal 3, just before the exit door on the Right Hand Side, take the lift to level 1. Walk across the tunnel to the short stay car park, take another lift to level 3 Short Stay Car Park, ROW "A". Your vehicle will be returned where the Black and White signs say Off Airport Meet and Greet in row A </li>
                    <li>TERMINAL - 4: Once you have collected your luggage and are about to clear Customs, call the number given when your car was collected. As you exit the arrival Hall, cross the road directly towards the Short Stay Car park and take a lift to level 2. Your vehicle will be returned where the Black and White signs say Off-airport Meet and Greet at the furthest point of the car park away from the Terminal building on the Right-hand side. </li>
                    <li>TERMINAL - 5: Once you have collected your luggage and are about to clear Customs, call the number given when your car was collected. Make your way to the same place where you dropped the vehicle off; Level 4 short-stay car park. The vehicle will be parked in Row R OR S. (The same place where you dropped your vehicle off). </li>
                    <li>Important Information Please do not leave any valuables inside the vehicle, if you do on your own risk then please take a Please note that may result in a delay. As a car park provider, {{ $website_name }} will pay up to the first 15 minutes of parking, receipt from the driver. your specified meet time is appointed. If you should arrive before or after this time and the customer is responsible for the extra exit fee if 15 minutes is over. Ultra Low Emission Zone (ULEZ) is expanding across all London boroughs, including Heathrow Airport, starting 29 August 2023. If you drive anywhere within the ULEZ, including the Heathrowa Airport, from 29 August 2023, and your vehicle does meet the emissions standards, you must pay £12.50.</li>
                </ul>
                <p style="text-align: left;"><strong>Meet and Greet Deals Airport Parking Terms & Conditions (short Manage My Booking(s) version):</strong></p>
                <ul style="text-align:left;">
                    <p> Booking Ref. is AZP-77878 View, re-send & download booking confirmation Amend booking at no extra cost (except date change) Get 15% life time Discount Click Here to Manage Booking(s). Customer Support Meet and Greet Deals Airport Parking Ltd is booking agent for the featured Car Parks and customers will be contracting with {{ $website_name }} Limited and will be subject to their terms and conditions which contain certain exemption clauses and limit each company's liability. You need to call {{ $website_name }} Limited on youra Departure (Drop-off) and Return (Pick-up) day. Any claims by the customer in respect of parking services e.g collection, delivery of the vehicle, damage the vehicle etc must be made against {{ $website_name }} Limited and subject to their terms and conditions. As a booking agent for the Car Park, Meet and Greet Deals Airport Parking LTD is liable to the customer only for losses directly arising from any negligence of the company in processing a booking.</p>
                    <p style="text-align: left;"><strong>Manage My Bookings</strong></p>
                    Only booking related issues. Cancellation request Extend booking (24hrs before departure date) Parking service related issue or complaints must be discuss / deal with {{ $website_name }} Limited Full Meet and Greet Deals Terms & Conditions Click Here for Customer Support.</p>
                    <p>Meet and Greet Deals Airport Parking Ltd's full Terms & Conditions Amount (GBP) £ 150.00 £ 0.00 £ 30.00 £ 1.95 £ 1.99 Booking Quote / Optional Service /Discount /VAT Invoice Booking Quote * Airport Levy Charges * Discount Amount Booking Fee * Optional Charges (Cancellation Cover, SMS Service) Total Paid Amount £ 123.94 Meet and Greet Deals Airport Parking Ltd., 
                    Unit 1 Railway House, 14 Chertsey Road, Woking, Surrey, GU21 5AH. This confirmation can also be used as VAT Receipt</p>
                    
                </ul>
        </div>
    </div>
</body>
</html>
