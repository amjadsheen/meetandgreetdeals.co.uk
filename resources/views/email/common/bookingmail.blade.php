<style type='text/css'>
    h1 {
        font-size: 22px;
    }

    h2 {
        font-size: 18px;
    }
</style>
<table width='800' align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
    <tr>
        <td align="center" width="200"><img style="width:25%" src="{{$website_logo}}"></td>
        <!--<td align="center" width="600"><img src="{{$website_email_banner}}" width="600" height="90"></td>-->
    </tr>
    <tr valign="middle">
        <td colspan="2" align="center" width="800" height="50">
            <h1 style="color: green;">ORDER DETAIL - Booking Reference: {{ $bk_ref }}</h1>
            @if($refrence_num_extra)
            <p>{{ $refrence_num_extra }}</p>
            @endif
        </td>
    </tr>
    <tr valign='middle'>
        <td colspan='2' widh='800' align='center' valign='top'>
            <table width='800' border='0'>
                <tr>
                    <td width='500' rowspan='3' align='left' valign='top'>
                        <h2>Customer information</h2>
                        First name: {{$cus_title}} {{$cus_name}}<br />
                        Surname: {{$cus_surname}}<br />
                        Mobile number: {{$cus_cell}}<br />
                        Order Date: {{$bk_date}}
                        @if($total_bookings_count > 0)
                        [ {{ $total_bookings_count }} ]
                        @endif
                        <br />
                        Airport: {{$airport_name}} [<a href="{{$directions}}">directions</a>]<br />
                        Service: {!! str_replace('Moon Parking', $website_name, $service_name) !!} <br />
                        Departure date/time: {{$bk_from_date}}<br />
                        Landing date/time: {{$bk_to_date}}<br />
                        <h2>Flight detail</h2>
                        Outbound Flight Number: {{$bk_ou_fl_nu}}<br />
                        Outbound Terminal: {{$ter_name1}}<br />
                        Return Flight Number: {{$bk_re_fl_nu}}<br />
                        Return Terminal: {{$ter_name2}}
                        <h2>Vehicle detail</h2>
                        <p>Registration Number: {{$bk_re_nu}}<br />
                        Vehicle Make: {{$bk_ve_ma}}<br />
                        Vehicle Model: {{$bk_ve_mo}}<br />
                        Vehicle Colour: {{$bk_ve_co}}<br />
                        Drop off date/time: {{$bk_ve_do_dt}}<br />
                        Pick up date/time: {{$bk_ve_pu_dt}}</p>
                        <h2>Passenger information</h2>
                        Number of Passengers: {{$bk_nop}}<br />
                        @if($account_num)
                        Account#: {{ $account_num }}<br />
                        @endif
                        @if(!empty($luggage))
                        Luggage: {{$luggage}}<br />
                        @endif
                        @if(!empty($ulze))
                        Ulez Checked: {{$ulze}}<br />
                        @endif
                        <h2>Booking detail</h2>
                        
                        Email: {{$cus_email}}<br />
                        {!! str_replace('Moon Parking', $website_name, $amount_detail) !!} <br />
                        Payment option: {!! $payment_option !!}
                        Booking Status: {!! $current_booking_status !!}
                        {!! $payment_links !!}
                        
                        
                        <br>
                        @if(!empty($special_promo))
                        {!! $special_promo !!}
                        @endif
                        <strong>Please note:</strong>
                        <ul>
                            <li>Overstaying will lead to £30 charge per day or part of the day.</li>
                            <li>If the customer comes 24 hours before they are scheduled to collect their vehicle without calling {{ $website_name }} Parking will result in a £30 charge.</li>
                            <li>Any amendments made after the booking is first completed will cost £30.</li>
                            <li>We are not responsible for any electric devices, flat battery, flat tyres and any scratches on the alloys.</li>
                            <li>Driver will adjust steering, mirrors and seat so they can safely drive your vehicle.</li>
                            <li>We do not cover any wind screen scratches or damages.</li>
                            <li>To avoid any technical problems please inform us of any tracker or any other extra security device that may be fitted to your vehicle.</li>
                            <li>Check you vehicle before you leave the terminal, after you have left the terminal we are not responsible for anything.</li>
                            <li>If you are unsure if the driver is part of the {{ $website_name }} Parking team take note of their name and number and immediately give us a call and we will look into it. Do not hand the vehicle over until we confirm.</li>
                            <li>if you leave any devices or anything valuable in your car please confirm with {{ $website_name }} Parking office as we are not responsible for any item that is lost.</li>
                            <li>Keep spare vehicle key to yourself and the other key to the driver. The driver will only accept the vehicle key.</li>
                            <li>customers that don't call 40 minutes before arriving at the terminal they will
                                have to pay the terminal access fee.</li>
                            <li>customers that book via third parties must pay terminal access fee.</li>
                            <li>The customer must take pictures at the terminal of their vehicle when the driver is present in regards to damages.
                                Failure to show a clear picture showing date, time and location we will not accept any claim.
                                The customer must take a clear picture showing date, time and location of the full vehicle when the driver delivers the vehicle back to the customer at the terminal.
                                This is in case of any damages that the customer may claim. Failure to show a clear picture we will not accept any claim. </li>
                            <li>{{ $website_name }} Parking has the right to cancel any bookings at any time within 24 hours or after 24 hours whether direct or from any third party with reason or without reason.</li>
                            <li>If a customer arrives for departure without informing {{ $website_name }} Parking, the customer will have to wait longer than usual and they are responsible to pay the car park fee. We are not responsible for missed flights or any other damages that may have been caused due to customer not notifying us letting u know that they are 40 to 60 minutes away from the terminal.</li>
                            <li>If a customer arrives from their trip without notifying {{ $website_name }} Parking they will have to wait a minimum 2 hours and they will be charged £30. The customer will have to notify {{ $website_name }} Parking beforehand so we can deliver the vehicle upon arrival on time. We will not be responsible for any loses due not notifying {{ $website_name }} Parking on time so they we can deliver the vehicle. </li>
                            <li>{{ $website_name }} Parking is not responsible for natural dirt caused by birds and weather.</li>
                            <li>Customers that use {{ $website_name }} Paring meet and greet service between the time 23:00 to 5:00 for reasons such as delayed arrival and departure flights or for any other reasons will be charged £30 plus the booking price.</li>
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
                    </td>
                    <td width='300' align='left' valign='top'>
                        <div align='center'>
                            <h2>Booking Reference Qr Code</h2>
                            <!--<img style="width: 100px;" src='{{$booking_qr_code}}'  />-->
                            <img style="width: 100px;" src='{{url('/storage/qrcodes/'.$booking_id)}}.png' />

                        </div>
                        <h2>Customer service numbers:</h2>
                        <h2><a style="color: #000;" href="tel:{{$contact_num}}">{{$contact_num}}</a> / <a style="color: #000;" href="tel:{{$alternate_contact_num}}">{{$alternate_contact_num}}</a></h2>
                        1. Call the number below, one hour before arriving at the terminal to deliver your vehicle.<br />
                        2. Call the number below as soon as you land to dispatch and receive your vehicle.<br>
                        <br>
                        <strong>Duty Controller (Heathrow)</strong><br>
                        <a style="color: #000;" href="tel:{{$contact_num}}">{{$contact_num}}</a> / <a style="color: #000;" href="tel:{{$alternate_contact_num}}">{{$alternate_contact_num}}</a><br>
                        <strong>Duty Controller (Gatwick)</strong><br>
                        Coming Soon<br>
                        <strong>Duty Controller (Luton)</strong><br>
                        @if ($airport_name == 'London Luton')
                        07772412225
                        @else
                        Coming Soon
                        @endif

                        <br>
                        <strong>Duty Controller (Stansted)</strong><br>
                        Coming Soon<br>
                        <strong>Duty Controller (City)</strong><br>
                        Not Available at the moment<br>
                        <strong>Duty Controller (Birmingham)</strong><br>
                        Coming Soon</p>
                        <h2>Other Enquires:</h2>

                        <table>
                            <tr>
                                <td>
                                    <a href="https://wa.me/+447375884916 "><img height="45" width="45" style='position: relative; left: -8px; top: 14px;' src='https://www.edenparking.co.uk/cardo/assets/img/ww.png'></a>
                                </td>
                                <td>
                                    <h2><a href="https://wa.me/+447375884916 ">07375 884916 </a></h2>
                                </td>
                            </tr>
                        </table>
                        {!! str_replace('Moon Parking', $website_name, $Park_and_Ride_Service) !!}
                    </td>
                </tr>
                <tr>
                    <td width='300' align='center' valign='top'>
                        <p style="display: none;"><strong>]]</strong></p>
                        <p style="display: none;"><img src='{{$qr_co_uk}}' width='98' height='90' /></p>
                    </td>
                </tr>
                <tr>
                    <td style="display: none;" width='300' align='center' valign='top'>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan='2'>

                        <table border='0'>
                            <tr>
                                <td class='banner' style='text-align: center; vertical-align: top;' colspan='3'><img style="width:25%"  class='logo' src='{{$website_logo}}'></td>
                            </tr>
                            <tr>
                                <!--<td class='banner' style='text-align: center; vertical-align: top;' colspan='3'><img  src='{{$website_email_banner}}'></td>-->
                            </tr>
                            <tr>
                                <td align='right' style='vertical-align: top;'><img class='logo1' style='vertical-align: top;' src='{{$image_left}}'></td>
                                <td style='vertical-align: top;'>
                                    @if($airport_name == 'London Luton')
                                    <p class='pp large' style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .9em;font-weight: 900;'><strong>DIRECTIONS FOR LUTON AIRPORT DROP AND PICK YOUR VECHICLE OFF AIRPORT MEET AND GREET AREA</strong></p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .9em;font-weight: 900;'>Drop off information:</p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>1.Please call Express on 07772 412225 when you are 30 minutes from the airport - if you are running earlier or late then the time on your booking from you need to inform
                                        us.<strong>Please do not arrive at the airport without advance notice.</strong></p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>2.Park in the Short Term car park in the Off-site Meet and Greet area - you'll need to press
                                        for a ticket at the barrier.</p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>3.Pull into a bay and hand your ticket to the Meet and Greet driver.
                                        They will check the mileage and note any damage on the paperwork which you will sign.</p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>4.follow sign to the terminal-<strong>it's about a 5-7 minute walk</strong></p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .9em;font-weight: 900;'>Return Information:</p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em;font-weight: 600;'>1.Please call Express on 07772 412225 when you are ready to exit the Terminal.Your driver will bring your car back to the Short Term car park while you make your way outside.
                                        <strong>You will need to pay the 7. exit fee</strong>.
                                    </p>
                                    @else
                                    <p class='pp large' style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .9em;font-weight: 900;'><strong>DIRECTIONS FOR HEATHROW ALL TERMINALS (OFF AIRPORT MEET AND GREET ) DROP AND PICK YOUR VECHICLE OFF AIRPORT MEET AND GREET AREA</strong></p>
                                    <p class='pp' style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>T2-HEATHROW-SHORT STAY CAR PARK-LEVEL-4-ROW-A AND B OFF AIRPORT MEET AND GREET AREA</p>
                                    <p class='pp' style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>T3-HEATHROW-SHORT STAY CAR PARK3-LEVEL-4-ROW-A,B,C OFF AIRPORT MEET AND GREET AREA</p>
                                    <p class='pp' style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>T4-HEATHROW-SHORT STAY CAR PARK4-LEVEL-2-ROW-E AND F OFF AIRPORT MEET AND GREET AREA</p>
                                    <p class='pp' style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>T5-HEATHROW-SHORT STAY CAR PARKI-LEVEL-4-ROW-R AND S OFF AIRPORT MEET AND GREET AREA</p>
                                    @endif
                                    <p style='color:red; margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .9em;font-weight: 900;'><strong>HEIGHT IS RESTRICTED AT 2 METERS (BARE IN MIND)</strong></p>
                                    <p style='color:red; margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .9em;font-weight: 900;'><strong>During the holiday period allow us extra time to pick & deliver your car please</strong></p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>If a customer arrives in terminal without calling half an hour before departure and arrival they are responsible to pay the terminal ticket.</p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .9em;font-weight: 900;'><strong>Overstaying will lead to £30 charge per day or part of the day.</strong></p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>If the customer comes 24 hours before they are scheduled to collect their vehicle without calling {{ $website_name }} Parking will result in a £30 charge.</p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .7em; font-weight: 600;'>Any amendments made after the booking is first completed will cost £30.</p>
                                    <p style='margin: 0px; padding-bottom: 7px; padding-left: 10px; padding-right: 5px; font-size: .9em;font-weight: 900;'><strong>{{ $website_name }} Parking is a trading name of Extra Enterprise Ltd. Registration Number 13317269</strong></p>
                                </td>
                                <td align='right' style='vertical-align: top;'><img class='logo1' src='{{$image_right}}'></td>
                            </tr>

                        </table>
                        <hr>
                        <div align='center'>Print this page to show upon departure and arrival.<br />Keep this for your record and receipt.</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

</table>