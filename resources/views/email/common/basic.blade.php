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
        <img style="width:50%; background: linear-gradient(#dc3545ed, #c6890f) !important;" src="{{$website_logo}}" alt="Logo">
        </div>
        <div class="content">
            <table>
                <tr>
                    <td class="b1" colspan="4">Booking Details</h2></td>
                </tr>
                <tr>
                    <td style="padding: 0;" colspan="4">&nbsp;</h2></td>
                </tr>
                <tr>
                    <td class="b3">Booking Code:</td>
                    <td class="b3">{{ $bk_ref }} </td>
                    <td class="b3">Booking Date:</td>
                    <td class="b3">{{$bk_date}} </td>
                </tr>
                <tr>
                    <td class="b3">Name:</td>
                    <td class="b3">{{$cus_title}} {{$cus_surname}}  {{$cus_name}} </td>
                    <td class="b3">Mobile number:</td>
                    <td class="b3">
                        @if($customer_contact)
                            {{$customer_contact}}
                        @else
                            {{$cus_cell}}
                        @endif   </td>
                </tr>
                <tr>
                    <td class="b3">Registration No:</td>
                    <td class="b3">{{$bk_re_nu}}</td>
                    <td class="b3">Vehicle Colour:</td>
                    <td class="b3">{{$bk_ve_co}}</td>
                </tr>
                <tr>
                    <td class="b3">Departure:</td>
                    <td class="b3">{{$bk_from_date}}</td>
                    <td class="b3">Landing:</td>
                    <td class="b3">{{$bk_to_date}}</td>
                </tr>
                <tr>
                    <td class="b3">Total Payable Amount:</td>
                    <td class="b3">{{$total_payable_amount}}</td>
                    <td class="b3">Booking Status:</td>
                    <td class="b3">{!! $current_booking_status !!}</td>
                </tr>
                
                <tr>
                    <td style="padding: 0;" colspan="4">&nbsp;</h2></td>
                </tr>
                <tr>
                    <td class="b1" colspan="4">Parking</h2></td>
                </tr>
                <tr>
                    <td style="padding: 0;" colspan="4">&nbsp;</h2></td>
                </tr>
                <tr>
                <td><img style="width: 100%; background: linear-gradient(#dc3545ed, #c6890f) !important;" src="{{$website_logo}}" alt="Logo"></td>
                <td colspan="3">
                    {{ $website_name }} <br>Parking is a trading name of Extra Enterprise Ltd. Registration Number 13317269
                    <a href="{{$directions}}" target="_blank">directions</a><br>
                    Opening hours: The car park is always open (24/7)
                </td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <p style="text-align: left;"><strong>Please note:</strong></p>
        <ul style="text-align:left;">
                <li>Overstaying will lead to £30 charge per day or part of the day.</li>
                <li>If the customer comes 24 hours before they are scheduled to collect their vehicle without calling Heathrow Airport Meet and Greet Parking Parking will result in a £30 charge.</li>
                <li>Any amendments made after the booking is first completed will cost £30.</li>
                <li>We are not responsible for any electric devices, flat battery, flat tyres and any scratches on the alloys.</li>
                <li>Driver will adjust steering, mirrors and seat so they can safely drive your vehicle.</li>
                <li>We do not cover any wind screen scratches or damages.</li>
                <li>To avoid any technical problems please inform us of any tracker or any other extra security device that may be fitted to your vehicle.</li>
                <li>Check you vehicle before you leave the terminal, after you have left the terminal we are not responsible for anything.</li>
                <li>If you are unsure if the driver is part of the Heathrow Airport Meet and Greet Parking Parking team take note of their name and number and immediately give us a call and we will look into it. Do not hand the vehicle over until we confirm.</li>
                <li>if you leave any devices or anything valuable in your car please confirm with Heathrow Airport Meet and Greet Parking Parking office as we are not responsible for any item that is lost.</li>
                <li>Keep spare vehicle key to yourself and the other key to the driver. The driver will only accept the vehicle key.</li>
                <li>customers that don't call 40 minutes before arriving at the terminal they will
                    have to pay the terminal access fee.</li>
                <li>customers that book via third parties must pay terminal access fee.</li>
                <li>The customer must take pictures at the terminal of their vehicle when the driver is present in regards to damages.
                    Failure to show a clear picture showing date, time and location we will not accept any claim.
                    The customer must take a clear picture showing date, time and location of the full vehicle when the driver delivers the vehicle back to the customer at the terminal.
                    This is in case of any damages that the customer may claim. Failure to show a clear picture we will not accept any claim. </li>
                <li>Heathrow Airport Meet and Greet Parking Parking has the right to cancel any bookings at any time within 24 hours or after 24 hours whether direct or from any third party with reason or without reason.</li>
                <li>If a customer arrives for departure without informing Heathrow Airport Meet and Greet Parking Parking, the customer will have to wait longer than usual and they are responsible to pay the car park fee. We are not responsible for missed flights or any other damages that may have been caused due to customer not notifying us letting u know that they are 40 to 60 minutes away from the terminal.</li>
                <li>If a customer arrives from their trip without notifying Heathrow Airport Meet and Greet Parking Parking they will have to wait a minimum 2 hours and they will be charged £30. The customer will have to notify Heathrow Airport Meet and Greet Parking Parking beforehand so we can deliver the vehicle upon arrival on time. We will not be responsible for any loses due not notifying Heathrow Airport Meet and Greet Parking Parking on time so they we can deliver the vehicle. </li>
                <li>Heathrow Airport Meet and Greet Parking Parking is not responsible for natural dirt caused by birds and weather.</li>
                <li>Customers that use Heathrow Airport Meet and Greet Parking Paring meet and greet service between the time 23:00 to 5:00 for reasons such as delayed arrival and departure flights or for any other reasons will be charged £30 plus the booking price.</li>
                <li>Upon departure and arrival the customer must call the number provided on the website or on the paperwork</li>
                <li>Customers that change their terminal details when landing can incur a cost of £30.</li>
                <li>Customers that do not provide correct details such as flight numbers, return and depart can incur a minimum wait of 2 hours and a £30 fee.
                </li>
                <li>Please read Terms and Conditions for full explanation.</li>
                <li>Customer needs to pick up their vehicle within 1 hour after their flight has landed any delay the customer must inform the duty controller immediately.</li>
                <li>If you are collecting your vehicle after midnight there will be a cost of £30 per hour.</li>
                <li>If you are bring an electric vehicle - it must be fully charged, if not fully charged and you would like it to be charged by us you will need to show the driver how to charge it and you will have to pay £30 for the charge per hours and £30 per hour for the waiting time this payment has to be made by cash when you are dropping your vehicle off.</li>
                <li>If the customer takes their car whilst it is parked with us, without our acknowledgement we will have to report the car as stolen to the police and produce to court as we will consider as a crime.</li>
            </ul>
        </div>
    </div>
</body>
</html>
