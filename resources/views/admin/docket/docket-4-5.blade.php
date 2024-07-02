<style>
    <!--
    @page {
        size: landscape;
    }
    a{
        color: #000000;
    }

    -->
    @media all {
        .page-break {
            display: none;
        }

        html, body {
            margin: 0px;

        }
        td{
            vertical-align: top;
        }

        h5,h4,h3,h1,h2 {
            margin-bottom: 4px;
            margin-top: 4px;
        }
        .normal{
            font-weight: 900;
            font-size: 17px;
        }
    }
    h1.blank {
        color: #fff;
    }
    img.noprint {
        display: none;
    }
    hr.noprint {
        display: none;
    }
    .bbb{
        writing-mode: vertical-lr;
    }
    img.hideimage {
        visibility: hidden;
    }
    @media print {

        .noprint {
            visibility: hidden;
        }

        .print1 {
            visibility: hidden;
        }
        img.hideimage {
            visibility: hidden;
        }

        .page-break {
            display: block;
            page-break-before: always;
        }
        h1.blank {
            color: #fff;
        }
        img.noprint {
            display: none;
        }
        hr.noprint {
            display: none;
        }
    }
</style>
<?php
$p = $docket;
$blank = 'blank';
$print1 = "print1";
$print = "";
$hideimage = 'hideimage';
$p1c = "#ffffff";
$color = "";
$tbl_font = "16px";
$lcolor = "#000000";
if (isset($_SERVER['HTTP_USER_AGENT'])) { // detecting browser
    $agent = $_SERVER['HTTP_USER_AGENT'];
}
if (strlen(strstr($agent, 'Firefox')) > 0) { // if browser is firefox
    $p1c = "transparent";
}

if ($bookings->bk_payment_method == 1) {
    $payment_method = "Pay later";
} else if ($bookings->bk_payment_method == 2) {
    $payment_method = "Paypal";
} elseif ($bookings->bk_payment_method == 3) {
    $payment_method = "Worldpay";
} elseif ($bookings->bk_payment_method == 5) {
    $payment_method = "Stripe";
}elseif ($bookings->bk_payment_method == 4) {
    $payment_method = "Other";
}elseif ($bookings->bk_payment_method==7){
    $payment_method = "Cash";
}


$rh = 45;
$rh1 = 20;
$mtw = 1200;
$qrcode = $bookings->booking_id;
?>
<table align="center" width="<?php echo $mtw ?>" border="0" cellpadding="2" cellspacing="0"
       bordercolor="<?php echo $color ?>">
    <tr>
    <?php if(isset($docket) && ($docket == 5 )){  ?>


    <!-- FIRST COLUMN START PAGE 1 -->
        <td width="30%" valign="top"
            style="padding-right: 6px; padding-left: 6px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <div style="float:left;">
                <img align="middle" width="300" src="/storage/uploads/{{$bookings->website_logo}}" alt="{{$bookings->website_name}}" />
            </div>
            <div style="float:right;">
                <img width="50" class="<?php echo $hideimage; ?>" src="/storage/qrcodes/{{$bookings->booking_id}}.png"  />
            </div>
            <br/><br/><br/><br/><br/>
            <!-- CUSTOMER  -->
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               CUSTOMER
                            </span>
                    </td>
                    <td width="29%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">NAME:</div>
                            </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->cus_title) . " " . strtoupper($bookings->cus_name); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">SURNAME:</div>
                            </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->cus_surname); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="40%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">BOOKING REF:</div></span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style=""><?php echo strtoupper($bookings->bk_ref); ?> &nbsp;</div>
                            </span>
                    </td>
                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;"><div style="font-size:15px">MOBILE 1:</div></span>
                        <span class="<?php echo $print1; ?>"
                              style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->cus_cell); ?> &nbsp;</div></span>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"
                                  style="color:<?php echo $color ?>;"><div style="font-size:15px">MOBILE 2:</div></span>
                        <span class="<?php echo $print1; ?>"
                              style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->cus_cell2); ?></div> &nbsp;</span>
                    </td>
                    <td width="40%">
                        <?php if ($bookings->bk_payment_method != '') { ?>
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                    <div style="font-size:15px">PAYMENT STATUS:</div>
                                </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">
                                    <?php
                                    echo '<span style="font-size: 14px;">'.strtoupper($payment_method).'</span>';?>
                                    <?php if ($bookings->bk_payment_method == 1) { ?>
                                        (- <?php echo $bookings->cur_symbol; ?>
                                    <?php
                                    //  if ($bookings->bk_discount_offer_value == 0) {
                                    //     $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                    //     $TOTAL_PAYABLE_AMOUNT = $bookings->bk_total_amount + $carwash + $bookings->not_working_hours + $bookings->last_min_booking + $bookings->charging_service_charges + $bookings->charging;
                                    //     echo number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                                    // }else{
                                    //     $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                    //     $TOTAL_PAYABLE_AMOUNT = $bookings->bk_final_amount + $carwash + $bookings->not_working_hours + $bookings->last_min_booking + $bookings->charging_service_charges + $bookings->charging;
                                    //     echo number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                                    // }
                                    $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                    $TOTAL_PAYABLE_AMOUNT = $bookings->bk_total_amount + $carwash + $bookings->not_working_hours + $bookings->last_min_booking + $bookings->charging_service_charges + $bookings->charging;
                                    echo number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                                    ?>)
                                        &nbsp;<?php } ?>

                                </div>

                                </span>
                        <?php } ?>
                    </td>
                </tr>
            </table>

            <!-- /CUSTOMER  -->
            <div style="margin-bottom: 6px"></div>
            <!-- VEHICLE  -->
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               VEHICLE
                            </span>
                    </td>
                    <td width="39%">
                            <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">CAR REG:</div></span>
                        <span class="<?php echo $print1; ?>"
                              style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_re_nu); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">MAKE:</div></span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_ve_ma); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">MODEL:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_ve_mo); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="40%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">COLOUR:</div></span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">
                                    <?php
                                    if($bookings->bk_ve_co == 'Other colour'){
                                        echo '`';
                                    }else{
                                        echo strtoupper($bookings->clr_name);
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">IN MILEAGE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">&nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">OUT MILEAGE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">&nbsp;</div>
                            </span>
                    </td>

                </tr>

            </table>
            <!-- /VEHICLE  -->

            <div style="margin-bottom: 6px"></div>
            <!-- DEPRTURE DETAILS  -->

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>" >
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               DEPRTURE
                            </span>
                    </td>
                    <td width="59%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">DROP OFF DATE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php

                                    if($bookings->bk_ve_do_dt != '') {
                                        $timestamp = strtotime($bookings->bk_ve_do_dt);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_ve_do_dt;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            //echo date("d/m/Y", $timestamp);
                                            $date =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            //echo $date[0];
                                            //echo date("d/m/Y", $date[0]);
                                            echo date("d/m/Y", strtotime($date[0]));
                                        }else{
                                            $date =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            //echo $date[0];
                                            //echo date("d/m/Y", $date[0]);
                                            echo date("d/m/Y", strtotime($date[0]));
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>
                    <td width="">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">TERMINAL:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->ter_name1); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="60%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">DROP OFF TIME:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php

                                    if($bookings->bk_ve_do_dt != '') {
                                        $timestamp = strtotime($bookings->bk_ve_do_dt);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_ve_do_dt;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            // echo date("H:i", $timestamp);
                                            $date =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            echo $date[1];
                                        }else{
                                            $hr =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[1];
                                            echo $hr[1];
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }


                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>

                    <td width="40%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">OUTBOUND FLIGHT:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->bk_ou_fl_nu); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>

            </table>
            <!-- /DEPRTURE DETAILS  -->

            <div style="margin-bottom: 6px"></div>
            <!-- CAR WASH  -->
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" style="vertical-align: middle;">
                            <span class="<?php echo $print; ?> bbbb" style="color:<?php echo $color ?>;">
                               CAR<span style="visibility: hidden">-</span>WASH
                            </span>
                    </td>
                    <td width="59%">

                        <?php

                        if (trim($bookings->carwash_in_and_out) != 0) {

                            $title = '<span style="font-weight: 100; font-size: 17px;">ADD FULL CAR WASH (IN AND OUT)</span>';
                        } elseif (trim($bookings->carwash_out_only) != 0) {
                            $title = '<span style="font-weight: 100; font-size: 17px;">ADD CAR WASH (ONLY OUTSIDE) </span>';
                        } elseif (trim($bookings->carwash_in_only) != 0) {
                            $title = '<span style="font-weight: 100; font-size: 17px;">ADD CAR WASH (ONLY INSIDE)</span>';
                        }else{
                            $title = 'CAR WASH';
                        }
                        ?>

                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php
                                    $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                    if($carwash != 0) {
                                        echo $title .' '. $bookings->cur_symbol." ".number_format($carwash, 2, '.', '');
                                    }else {
                                        echo 'N/A';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>


                </tr>


            </table>
            <!-- /CAR WASH  -->

            <div style="margin-bottom: 6px"></div>
            <!-- ARRIVAL DETAILS  -->

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               ARRIVAL
                            </span>
                    </td>
                    <td width="59%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">ARRIVAL DATE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php
                                    if($bookings->bk_to_date != '') {
                                        $timestamp = strtotime($bookings->bk_to_date);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_to_date;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            echo date("d/m/Y", $timestamp);
                                            //$date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            //echo $date[0];
                                        }else{
                                            //echo $bookings->bk_to_date;
                                            $date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            echo $date[0];
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>
                    <td width="">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">TERMINAL:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->ter_name2); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                <td width="60%">
                <table style="height: 100px;">
                        <tr>
                            <td style="width:55%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">ARRIVAL TIME:</div>
                            </span>
                    <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php
                                    if($bookings->bk_to_date != '') {
                                        $timestamp = strtotime($bookings->bk_to_date);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_to_date;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            echo date("H:i", $timestamp);
                                            //$date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            // echo $date[1];
                                        }else{
                                            //echo $bookings->bk_to_date;
                                            $date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            echo $date[1];
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                            </td>
                            <td style="border-right: 1px solid; width:5%">&nbsp;</td>
                            <td style="width:45%;text-align: right;">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;"><p style="text-align: center;">LUGGAGE:</p></div>
                            </span>
                    <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="small" style="font-size: 12px;">
                                   <p style="text-align: center;">{{ $bookings->luggage }}</p>
                                    &nbsp;
                                </div>
                            </span>
                            </td>
                        </tr>
                    </table>
                    </td>

                    <td width="">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">INBOUND FLIGHT:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->bk_re_fl_nu); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>

            </table>
            <!-- /ARRIVAL DETAILS  -->







            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Vehicle Departure Declaration</h5>

            <div style="font-size:10px; color:<?php echo $color ?>;" class="<?php echo $print; ?>">
                By signing this document I agree that I have read the terms and conditions of Link Airport Parking and agree
                to the damage noted to my car. I further agree that the damage noted is not an accurate reflection
                of the condition of the car due to time constraints and location. Please ensure that all belongings
                such as satnavs, loose cash and other valuable items are not present in the vehicle as we cannot
                verify that these items were left in your vehicle.
                The customer must take a clear picture of the vehicle showing date, time and location when the driver is present.
            </div>
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">SIGN.<br/> CUST.:</span>
                    </td>
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">NAME CUSTOMER:</span><br/><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><?php // echo strtoupper($bookings->cus_title)." ".strtoupper($bookings->cus_name) ;?></span>
                    </td>
                </tr>
            </table>
            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Vehicle Arrival Declaration</h5>

            <div style="font-size:10px; color:<?php echo $color ?>;" class="<?php echo $print; ?>">
                I have accepted my car back and I have checked my car to ensure that it is exactly how I left it and
                I am satisfied with the condition of my car and the service I have received.
            </div>
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">SIGN.<br/> CUST.:</span>
                    </td>
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">NAME CUSTOMER:</span><br/><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><?php // echo strtoupper($bookings->cus_title)." ".strtoupper($bookings->cus_name) ;?></span>
                    </td>
                </tr>
            </table>
            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Note:</h5>
            <?php if ($docket != "2") { ?>
            <hr class="<?php echo $print; ?>" style="margin-bottom: 0;"/><?php } ?>
            <br>

        </td>
        <!-- END FIRST COLUMN PAGE 1-->
        <!-- FIRST COLUMN START PAGE 1 -->
        <td width="30%" valign="top"
            style="padding-right: 6px; padding-left: 6px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <div style="float:left;">
                <img align="middle"  width="300" src="/storage/uploads/{{$bookings->website_logo}}" alt="{{$bookings->website_name}}" />
            </div>
            <div style="float:right;"><img width="50" class="<?php echo $hideimage; ?>" src="/storage/qrcodes/{{$bookings->booking_id}}.png"/></div>
            <br/><br/><br/><br/><br/>
            <!-- CUSTOMER  -->
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               CUSTOMER
                            </span>
                    </td>
                    <td width="29%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">NAME:</div>
                            </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->cus_title) . " " . strtoupper($bookings->cus_name); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">SURNAME:</div>
                            </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->cus_surname); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="40%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">BOOKING REF:</div></span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style=""><?php echo strtoupper($bookings->bk_ref); ?> &nbsp;</div>
                            </span>
                    </td>
                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;"><div style="font-size:15px">MOBILE 1:</div></span>
                        <span class="<?php echo $print1; ?>"
                              style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->cus_cell); ?> &nbsp;</div></span>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"
                                  style="color:<?php echo $color ?>;"><div style="font-size:15px">MOBILE 2:</div></span>
                        <span class="<?php echo $print1; ?>"
                              style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->cus_cell2); ?></div> &nbsp;</span>
                    </td>
                    <td width="40%">
                        <?php if ($bookings->bk_payment_method != '') { ?>
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                    <div style="font-size:15px">PAYMENT STATUS:</div>
                                </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">
                                    <?php
                                    echo '<span style="font-size: 14px;">'.strtoupper($payment_method).'</span>';?>
                                    <?php if ($bookings->bk_payment_method == 1) { ?>
                                        (- <?php echo $bookings->cur_symbol; ?>
                                    <?php
                                     if ($bookings->bk_discount_offer_value == 0) {
                                        $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                        $TOTAL_PAYABLE_AMOUNT = $bookings->bk_total_amount + $carwash + $bookings->not_working_hours + $bookings->last_min_booking + $bookings->charging_service_charges + $bookings->charging;
                                        echo number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                                    }else{
                                        $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                        $TOTAL_PAYABLE_AMOUNT = $bookings->bk_final_amount + $carwash + $bookings->not_working_hours + $bookings->last_min_booking + $bookings->charging_service_charges + $bookings->charging;
                                        echo number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                                    }
                                    ?>)
                                        &nbsp;<?php } ?>

                                </div>

                                </span>
                        <?php } ?>
                    </td>
                </tr>
            </table>

            <!-- /CUSTOMER  -->
            <div style="margin-bottom: 6px"></div>
            <!-- VEHICLE  -->
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               VEHICLE
                            </span>
                    </td>
                    <td width="39%">
                            <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">CAR REG:</div></span>
                        <span class="<?php echo $print1; ?>"
                              style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_re_nu); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">MAKE:</div></span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_ve_ma); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">MODEL:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_ve_mo); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="40%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">COLOUR:</div></span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">
                                    <?php
                                    if($bookings->bk_ve_co == 'Other colour'){
                                        echo '`';
                                    }else{
                                        echo strtoupper($bookings->bk_ve_co);
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">IN MILEAGE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">&nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">OUT MILEAGE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">&nbsp;</div>
                            </span>
                    </td>

                </tr>

            </table>
            <!-- /VEHICLE  -->

            <div style="margin-bottom: 6px"></div>
            <!-- DEPRTURE DETAILS  -->

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>" >
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               DEPRTURE
                            </span>
                    </td>
                    <td width="59%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">DROP OFF DATE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php

                                    if($bookings->bk_ve_do_dt != '') {
                                        $timestamp = strtotime($bookings->bk_ve_do_dt);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_ve_do_dt;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            //echo date("d/m/Y", $timestamp);
                                            $date =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            //echo $date[0];
                                            //echo date("d/m/Y", $date[0]);
                                            echo date("d/m/Y", strtotime($date[0]));
                                        }else{
                                            $date =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            //echo $date[0];
                                            //echo date("d/m/Y", $date[0]);
                                            echo date("d/m/Y", strtotime($date[0]));
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>
                    <td width="">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">TERMINAL:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->ter_name1); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="60%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">DROP OFF TIME:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php

                                    if($bookings->bk_ve_do_dt != '') {
                                        $timestamp = strtotime($bookings->bk_ve_do_dt);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_ve_do_dt;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            // echo date("H:i", $timestamp);
                                            $date =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            echo $date[1];
                                        }else{
                                            $hr =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[1];
                                            echo $hr[1];
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }


                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>

                    <td width="40%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">OUTBOUND FLIGHT:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->bk_ou_fl_nu); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>

            </table>
            <!-- /DEPRTURE DETAILS  -->
            <div style="margin-bottom: 6px"></div>


            <!-- CAR WASH  -->
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" style="vertical-align: middle;">
                            <span class="<?php echo $print; ?> bbbb" style="color:<?php echo $color ?>;">
                               CAR<span style="visibility: hidden">-</span>WASH
                            </span>
                    </td>
                    <td width="59%">

                        <?php
                        if (trim($bookings->carwash_in_and_out) != 0) {

                            $title = '<span style="font-weight: 100; font-size: 17px;">ADD FULL CAR WASH (IN AND OUT)</span>';
                        } elseif (trim($bookings->carwash_out_only) != 0) {
                            $title = '<span style="font-weight: 100; font-size: 17px;">ADD CAR WASH (ONLY OUTSIDE) </span>';
                        } elseif (trim($bookings->carwash_in_only) != 0) {
                            $title = '<span style="font-weight: 100; font-size: 17px;">ADD CAR WASH (ONLY INSIDE)</span>';
                        }else{
                            $title = 'CAR WASH';
                        }
                        ?>

                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php
                                    $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                    if($carwash != 0) {
                                        echo $title .' '. $bookings->cur_symbol." ".number_format($carwash, 2, '.', '');
                                    }else {
                                        echo 'N/A';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>


                </tr>


            </table>
            <!-- /CAR WASH  -->
            <div style="margin-bottom: 6px"></div>

            <!-- ARRIVAL DETAILS  -->

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               ARRIVAL
                            </span>
                    </td>
                    <td width="59%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">ARRIVAL DATE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php
                                    if($bookings->bk_to_date != '') {
                                        $timestamp = strtotime($bookings->bk_to_date);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_to_date;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            echo date("d/m/Y", $timestamp);
                                            //$date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            //echo $date[0];
                                        }else{
                                            //echo $bookings->bk_to_date;
                                            $date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            echo $date[0];
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>
                    <td width="">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">TERMINAL:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->ter_name2); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                <td width="60%">
                <table style="height: 100px;">
                        <tr>
                            <td style="width:55%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">ARRIVAL TIME:</div>
                            </span>
                    <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php
                                    if($bookings->bk_to_date != '') {
                                        $timestamp = strtotime($bookings->bk_to_date);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_to_date;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            echo date("H:i", $timestamp);
                                            //$date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            // echo $date[1];
                                        }else{
                                            //echo $bookings->bk_to_date;
                                            $date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            echo $date[1];
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                            </td>
                            <td style="border-right: 1px solid; width:5%">&nbsp;</td>
                            <td style="width:45%;text-align: right;">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;"><p style="text-align: center;">LUGGAGE:</p></div>
                            </span>
                    <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="small" style="font-size: 12px;">
                                   <p style="text-align: center;">{{ $bookings->luggage }}</p>
                                    &nbsp;
                                </div>
                            </span>
                            </td>
                        </tr>
                    </table>
                    </td>

                    <td width="">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">INBOUND FLIGHT:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->bk_re_fl_nu); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>

            </table>
            <!-- /ARRIVAL DETAILS  -->







            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Vehicle Departure Declaration</h5>

            <div style="font-size:10px; color:<?php echo $color ?>;" class="<?php echo $print; ?>">
                By signing this document I agree that I have read the terms and conditions of edenparking and agree
                to the damage noted to my car. I further agree that the damage noted is not an accurate reflection
                of the condition of the car due to time constraints and location. Please ensure that all belongings
                such as satnavs, loose cash and other valuable items are not present in the vehicle as we cannot
                verify that these items were left in your vehicle.
                The customer must take a clear picture of the vehicle showing date, time and location when the driver is present.
            </div>
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">SIGN.<br/> CUST.:</span>
                    </td>
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">NAME CUSTOMER:</span><br/><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><?php // echo strtoupper($bookings->cus_title)." ".strtoupper($bookings->cus_name) ;?></span>
                    </td>
                </tr>
            </table>
            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Vehicle Arrival Declaration</h5>

            <div style="font-size:10px; color:<?php echo $color ?>;" class="<?php echo $print; ?>">
                I have accepted my car back and I have checked my car to ensure that it is exactly how I left it and
                I am satisfied with the condition of my car and the service I have received.
            </div>
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">SIGN.<br/> CUST.:</span>
                    </td>
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">NAME CUSTOMER:</span><br/><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><?php // echo strtoupper($bookings->cus_title)." ".strtoupper($bookings->cus_name) ;?></span>
                    </td>
                </tr>
            </table>
            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Note:</h5>
            <?php if ($docket != "2") { ?>
            <hr class="<?php echo $print; ?>" style="margin-bottom: 0;"/><?php } ?>
            <br>
        </td>
        <!-- END FIRST COLUMN PAGE 1-->
        <!-- FIRST COLUMN START PAGE 1 -->
        <td width="30%" valign="top"
            style="padding-right: 6px; padding-left: 6px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <div style="float:left;">
                <img align="middle"  width="300"  src="/storage/uploads/{{$bookings->website_logo}}" alt="{{$bookings->website_name}}" />
            </div>
            <div style="float:right;"><img width="50" class="<?php echo $hideimage; ?>" src="/storage/qrcodes/{{$bookings->booking_id}}.png"/></div>
            <br/><br/><br/><br/><br/>
            <!-- CUSTOMER  -->
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               CUSTOMER
                            </span>
                    </td>
                    <td width="29%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">NAME:</div>
                            </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->cus_title) . " " . strtoupper($bookings->cus_name); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">SURNAME:</div>
                            </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->cus_surname); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="40%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">BOOKING REF:</div></span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style=""><?php echo strtoupper($bookings->bk_ref); ?> &nbsp;</div>
                            </span>
                    </td>
                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;"><div style="font-size:15px">MOBILE 1:</div></span>
                        <span class="<?php echo $print1; ?>"
                              style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->cus_cell); ?> &nbsp;</div></span>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"
                                  style="color:<?php echo $color ?>;"><div style="font-size:15px">MOBILE 2:</div></span>
                        <span class="<?php echo $print1; ?>"
                              style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->cus_cell2); ?></div> &nbsp;</span>
                    </td>
                    <td width="40%">
                        <?php if ($bookings->bk_payment_method != '') { ?>
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                    <div style="font-size:15px">PAYMENT STATUS:</div>
                                </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">
                                    <?php
                                    echo '<span style="font-size: 14px;">'.strtoupper($payment_method).'</span>';?>
                                    <?php if ($bookings->bk_payment_method == 1) { ?>
                                        (- <?php echo $bookings->cur_symbol; ?>
                                    <?php
                                     if ($bookings->bk_discount_offer_value == 0) {
                                        $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                        $TOTAL_PAYABLE_AMOUNT = $bookings->bk_total_amount + $carwash + $bookings->not_working_hours + $bookings->last_min_booking + $bookings->charging_service_charges + $bookings->charging;
                                        echo number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                                    }else{
                                        $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                        $TOTAL_PAYABLE_AMOUNT = $bookings->bk_final_amount + $carwash + $bookings->not_working_hours + $bookings->last_min_booking + $bookings->charging_service_charges + $bookings->charging;
                                        echo number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                                    }
                                    ?>)
                                        &nbsp;<?php } ?>

                                </div>

                                </span>
                        <?php } ?>
                    </td>
                </tr>
            </table>

            <!-- /CUSTOMER  -->
            <div style="margin-bottom: 6px"></div>
            <!-- VEHICLE  -->
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               VEHICLE
                            </span>
                    </td>
                    <td width="39%">
                            <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">CAR REG:</div></span>
                        <span class="<?php echo $print1; ?>"
                              style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_re_nu); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">MAKE:</div></span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_ve_ma); ?> &nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">MODEL:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_ve_mo); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="40%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">COLOUR:</div></span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">
                                    <?php
                                    if($bookings->bk_ve_co == 'Other colour'){
                                        echo '`';
                                    }else{
                                        echo strtoupper($bookings->bk_ve_co);
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">IN MILEAGE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">&nbsp;</div>
                            </span>
                    </td>
                    <td width="30%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">OUT MILEAGE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal">&nbsp;</div>
                            </span>
                    </td>

                </tr>

            </table>
            <!-- /VEHICLE  -->

            <div style="margin-bottom: 6px"></div>
            <!-- DEPRTURE DETAILS  -->

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>" >
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               DEPRTURE
                            </span>
                    </td>
                    <td width="59%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">DROP OFF DATE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php

                                    if($bookings->bk_ve_do_dt != '') {
                                        $timestamp = strtotime($bookings->bk_ve_do_dt);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_ve_do_dt;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            //echo date("d/m/Y", $timestamp);
                                            $date =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            //echo $date[0];
                                            //echo date("d/m/Y", $date[0]);
                                            echo date("d/m/Y", strtotime($date[0]));
                                        }else{
                                            $date =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            //echo $date[0];
                                            //echo date("d/m/Y", $date[0]);
                                            echo date("d/m/Y", strtotime($date[0]));
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>
                    <td width="">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">TERMINAL:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->ter_name1); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="60%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">DROP OFF TIME:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php

                                    if($bookings->bk_ve_do_dt != '') {
                                        $timestamp = strtotime($bookings->bk_ve_do_dt);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_ve_do_dt;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            // echo date("H:i", $timestamp);
                                            $date =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            echo $date[1];
                                        }else{
                                            $hr =  explode(' ',$bookings->bk_ve_do_dt);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[1];
                                            echo $hr[1];
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }


                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>

                    <td width="40%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">OUTBOUND FLIGHT:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->bk_ou_fl_nu); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>

            </table>
            <!-- /DEPRTURE DETAILS  -->
            <div style="margin-bottom: 6px"></div>



            <!-- CAR WASH  -->
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" style="vertical-align: middle;">
                            <span class="<?php echo $print; ?> bbbb" style="color:<?php echo $color ?>;">
                               CAR<span style="visibility: hidden">-</span>WASH
                            </span>
                    </td>
                    <td width="59%">

                        <?php
                        if (trim($bookings->carwash_in_and_out) != 0) {

                            $title = '<span style="font-weight: 100; font-size: 17px;">ADD FULL CAR WASH (IN AND OUT)</span>';
                        } elseif (trim($bookings->carwash_out_only) != 0) {
                            $title = '<span style="font-weight: 100; font-size: 17px;">ADD CAR WASH (ONLY OUTSIDE) </span>';
                        } elseif (trim($bookings->carwash_in_only) != 0) {
                            $title = '<span style="font-weight: 100; font-size: 17px;">ADD CAR WASH (ONLY INSIDE)</span>';
                        }else{
                            $title = 'CAR WASH';
                        }
                        ?>

                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php
                                    $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                    if($carwash != 0) {
                                        echo $title .' '. $bookings->cur_symbol." ".number_format($carwash, 2, '.', '');
                                    }else {
                                        echo 'N/A';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>


                </tr>


            </table>
            <!-- /CAR WASH  -->

            <div style="margin-bottom: 6px"></div>

            <!-- ARRIVAL DETAILS  -->

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                            <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                               ARRIVAL
                            </span>
                    </td>
                    <td width="59%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">ARRIVAL DATE:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php
                                    if($bookings->bk_to_date != '') {
                                        $timestamp = strtotime($bookings->bk_to_date);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_to_date;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            echo date("d/m/Y", $timestamp);
                                            //$date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            //echo $date[0];
                                        }else{
                                            //echo $bookings->bk_to_date;
                                            $date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            echo $date[0];
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                    </td>
                    <td width="">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">TERMINAL:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->ter_name2); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                <td width="60%">
                <table style="height: 100px;">
                        <tr>
                            <td style="width:55%">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">ARRIVAL TIME:</div>
                            </span>
                    <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;">
                                    <?php
                                    if($bookings->bk_to_date != '') {
                                        $timestamp = strtotime($bookings->bk_to_date);
                                        if($timestamp != '') {
                                            //echo $bookings->bk_to_date;
                                            //echo '<br>';
                                            //echo $timestamp;
                                            // echo '<br>';
                                            echo date("H:i", $timestamp);
                                            //$date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            // echo $date[1];
                                        }else{
                                            //echo $bookings->bk_to_date;
                                            $date =  explode(' ',$bookings->bk_to_date);
                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                            echo $date[1];
                                        }
                                    }else {
                                        echo 'Not Set';
                                    }
                                    ?>
                                    &nbsp;
                                </div>
                            </span>
                            </td>
                            <td style="border-right: 1px solid; width:5%">&nbsp;</td>
                            <td style="width:45%;text-align: right;">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;"><p style="text-align: center;">LUGGAGE:</p></div>
                            </span>
                    <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="small" style="font-size: 12px;">
                                   <p style="text-align: center;">{{ $bookings->luggage }}</p>
                                    &nbsp;
                                </div>
                            </span>
                            </td>
                        </tr>
                    </table>
                    </td>

                    <td width="">
                            <span class="<?php echo $print; ?>"style="color:<?php echo $color ?>;">
                                <div style="font-size: 14px;">INBOUND FLIGHT:</div>
                            </span>
                        <span class="<?php echo $print1; ?>"style="color:<?php echo $p1c; ?>;">
                                <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->bk_re_fl_nu); ?> &nbsp;</div>
                            </span>
                    </td>

                </tr>

            </table>
            <!-- /ARRIVAL DETAILS  -->







            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Vehicle Departure Declaration</h5>

            <div style="font-size:10px; color:<?php echo $color ?>;" class="<?php echo $print; ?>">
                By signing this document I agree that I have read the terms and conditions of edenparking and agree
                to the damage noted to my car. I further agree that the damage noted is not an accurate reflection
                of the condition of the car due to time constraints and location. Please ensure that all belongings
                such as satnavs, loose cash and other valuable items are not present in the vehicle as we cannot
                verify that these items were left in your vehicle.
                The customer must take a clear picture of the vehicle showing date, time and location when the driver is present.
            </div>
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">SIGN.<br/> CUST.:</span>
                    </td>
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">NAME CUSTOMER:</span><br/><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><?php // echo strtoupper($bookings->cus_title)." ".strtoupper($bookings->cus_name) ;?></span>
                    </td>
                </tr>
            </table>
            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Vehicle Arrival Declaration</h5>

            <div style="font-size:10px; color:<?php echo $color ?>;" class="<?php echo $print; ?>">
                I have accepted my car back and I have checked my car to ensure that it is exactly how I left it and
                I am satisfied with the condition of my car and the service I have received.
            </div>
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">SIGN.<br/> CUST.:</span>
                    </td>
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>"
                                                       style="color:<?php echo $color ?>;">NAME CUSTOMER:</span><br/><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><?php // echo strtoupper($bookings->cus_title)." ".strtoupper($bookings->cus_name) ;?></span>
                    </td>
                </tr>
            </table>
            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Note:</h5>
            <?php if ($docket != "2") { ?>
            <hr class="<?php echo $print; ?>" style="margin-bottom: 0;"/><?php } ?>
            <br>
            <!--                <img  class="--><?php //echo $print ?><!--" style="margin-top: 27px;" align="middle" width="96%" src="http://--><?php //echo $_SERVER["SERVER_NAME"] . home_url('/', $scheme = relative); ?><!--wp-content/uploads/2015/06/vcon--><?php //echo $ext ?><!--.png"/><br/>-->
        </td>
        <!-- END FIRST COLUMN PAGE 1-->


    <?php } else if(isset($docket) && ($docket == 6 )){ ?>


    <!--SECOND COLUMN START PAGE 1-->
        <td width="30%" valign="top" style="padding-left:6px; padding-right:6px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <div style="float:left;"><img align="middle" width="300" src="/storage/uploads/{{$bookings->website_logo}}" alt="{{$bookings->website_name}}" />
            </div>
            <div style="float:right;"><img width="100" class="<?php echo $hideimage; ?>" src="/storage/qrcodes/{{$bookings->booking_id}}.png"/></div>
            <br/><br/><br/><br/><br/><br/><br/><br/>

            <div style="float:right;" class="<?php echo $print; ?>">
                <div align="center" style="font-size:20px;color:<?php echo $color ?>;"><strong>Customer service
                        numbers</strong><br/></div>
                <div align="center" style="font-size:20px; color:<?php echo $color ?>;">020 3921 0616 / 033 0341 1767<br/></div>

                <div align="center"><a  href="http://www.moonparking.co.uk" class="<?php echo $print; ?>"
                                        style="color:<?php echo $lcolor; ?>;">www.moonparking.co.uk</a>
                    &nbsp;
                    
                    <br>
                    <a href="mailto:info@linkairportparking.co.uk" class="<?php echo $print; ?>"
                       style="color:<?php echo $lcolor; ?>;;">info@linkairportparking.co.uk</a>
                    &nbsp;
                    <a href="mailto:linkairportparking@hotmail.com" class="<?php echo $print; ?>"
                       style="color:<?php echo $lcolor; ?>;;">linkairportparking@hotmail.com</a>
                </div>
                <br/>

                <div style="font-size:14px; color:<?php echo $color ?>;">1. Call below number, one hour before
                    arriving at the terminal to deliver your vehicle.<br/></div>
                <div style="font-size:14px; color:<?php echo $color ?>;">2. Call below number as soon as you land to
                    dispatch and receive your vehicle.<br/><br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Heathrow)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">020 3921 0616 / 033 0341 1767<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Gatwick)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Luton)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Stansted)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller (City)</strong><br/>
                </div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Birmingham)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon</div>
                <br/>

                <div style="font-size:<?php echo $tbl_font; ?>; color:<?php echo $color ?>;"><strong><u>DON'T
                            FORGET:</u></strong><br/>TICKETS, PASSPORTS, PHONES, CURRENCY, CHARGERS & OTHER VALUABLE
                    ITEMS.<br/><br/></div>
            </div>

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>BOOKING REFERENCE:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->bk_ref); ?></span></td>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;"><div>CAR REG:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->bk_re_nu); ?>&nbsp;</div></span>
                    </td>
                </tr>
                <tr>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>MAKE/MODEL/COLOUR:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_ve_ma); ?>
                                    / <?php echo strtoupper($bookings->bk_ve_mo); ?>
                                    / <?php
                                    //echo strtoupper($bookings->bk_ve_co);
                                    if($bookings->bk_ve_co == 'Other colour'){
                                        echo '`';
                                    }else{
                                        echo strtoupper($bookings->bk_ve_co);
                                    }
                                    ?></div>&nbsp;</span></td>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>RETURN DATE/TIME:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo date("d/m/Y H:i", strtotime($bookings->bk_to_date)); ?>&nbsp;</div></span>
                    </td>
                </tr>
                <tr>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;"><div>RETURN FLIGHT NUMBER:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->bk_re_fl_nu); ?>&nbsp;</div></span>
                    </td>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>TERMINAL:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->ter_name2); ?>&nbsp;</div></span>
                    </td>
                </tr>

            </table>
            <br>

        </td>
        </td> <!--END SECOND COLUMN PAGE 1-->
        <!--SECOND COLUMN START PAGE 1-->
        <td width="30%" valign="top" style="padding-left:6px; padding-right:6px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <div style="float:left;"><img align="middle" width="300" src="/storage/uploads/{{$bookings->website_logo}}" alt="{{$bookings->website_name}}" />
            </div>
            <div style="float:right;"><img width="100" class="<?php echo $hideimage; ?>" src="/storage/qrcodes/'{{$bookings->booking_id}}.png"/></div>
            <br/><br/><br/><br/><br/><br/><br/><br/>

            <div style="float:right;" class="<?php echo $print; ?>">
                <div align="center" style="font-size:20px;color:<?php echo $color ?>;"><strong>Customer service
                        numbers</strong><br/></div>
                <div align="center" style="font-size:20px; color:<?php echo $color ?>;">020 3921 0616 / 033 0341 1767<br/></div>

                <div align="center"><a  href="http://www.moonparking.co.uk" class="<?php echo $print; ?>"
                                        style="color:<?php echo $lcolor; ?>;">www.moonparking.co.uk</a>
                    <br>
                    <a href="mailto:info@linkairportparking.co.uk" class="<?php echo $print; ?>"
                       style="color:<?php echo $lcolor; ?>;;">info@linkairportparking.co.uk</a>
                    &nbsp;
                    <a href="mailto:linkairportparking@hotmail.com" class="<?php echo $print; ?>"
                       style="color:<?php echo $lcolor; ?>;;">linkairportparking@hotmail.com</a>
                </div>
                <br/>

                <div style="font-size:14px; color:<?php echo $color ?>;">1. Call below number, one hour before
                    arriving at the terminal to deliver your vehicle.<br/></div>
                <div style="font-size:14px; color:<?php echo $color ?>;">2. Call below number as soon as you land to
                    dispatch and receive your vehicle.<br/><br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Heathrow)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">020 3921 0616 / 033 0341 1767<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Gatwick)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Luton)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Stansted)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller (City)</strong><br/>
                </div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Birmingham)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon</div>
                <br/>

                <div style="font-size:<?php echo $tbl_font; ?>; color:<?php echo $color ?>;"><strong><u>DON'T
                            FORGET:</u></strong><br/>TICKETS, PASSPORTS, PHONES, CURRENCY, CHARGERS & OTHER VALUABLE
                    ITEMS.<br/><br/></div>
            </div>

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>BOOKING REFERENCE:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->bk_ref); ?></span></td>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;"><div>CAR REG:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->bk_re_nu); ?>&nbsp;</div></span>
                    </td>
                </tr>
                <tr>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>MAKE/MODEL/COLOUR:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_ve_ma); ?>
                                    / <?php echo strtoupper($bookings->bk_ve_mo); ?>
                                    / <?php
                                    //echo strtoupper($bookings->bk_ve_co);
                                    if($bookings->bk_ve_co == 'Other colour'){
                                        echo '`';
                                    }else{
                                        echo strtoupper($bookings->bk_ve_co);
                                    }
                                    ?></div>&nbsp;</span></td>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>RETURN DATE/TIME:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo date("d/m/Y H:i", strtotime($bookings->bk_to_date)); ?>&nbsp;</div></span>
                    </td>
                </tr>
                <tr>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;"><div>RETURN FLIGHT NUMBER:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->bk_re_fl_nu); ?>&nbsp;</div></span>
                    </td>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>TERMINAL:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->ter_name2); ?>&nbsp;</div></span>
                    </td>
                </tr>

            </table>
            <br>

        </td>
        </td> <!--END SECOND COLUMN PAGE 1-->
        <!--SECOND COLUMN START PAGE 1-->
        <td width="30%" valign="top" style="padding-left:6px; padding-right:6px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <div style="float:left;"><img align="middle" width="300" src="/storage/uploads/{{$bookings->website_logo}}" alt="{{$bookings->website_name}}" />
            </div>
            <div style="float:right;"><img width="100" class="<?php echo $hideimage; ?>" src="/storage/qrcodes/'{{$bookings->booking_id}}.png"/></div>
            <br/><br/><br/><br/><br/><br/><br/><br/>

            <div style="float:right;" class="<?php echo $print; ?>">
                <div align="center" style="font-size:20px;color:<?php echo $color ?>;"><strong>Customer service
                        numbers</strong><br/></div>
                <div align="center" style="font-size:20px; color:<?php echo $color ?>;">020 3921 0616 / 033 0341 1767<br/></div>

                <div align="center"><a  href="http://www.moonparking.co.uk" class="<?php echo $print; ?>"
                                        style="color:<?php echo $lcolor; ?>;">www.moonparking.co.uk</a>
                    <br>
                    <a href="mailto:info@linkairportparking.co.uk" class="<?php echo $print; ?>"
                       style="color:<?php echo $lcolor; ?>;;">info@linkairportparking.co.uk</a>
                    &nbsp;
                    <a href="mailto:linkairportparking@hotmail.com" class="<?php echo $print; ?>"
                       style="color:<?php echo $lcolor; ?>;;">linkairportparking@hotmail.com</a>
                </div>
                <br/>

                <div style="font-size:14px; color:<?php echo $color ?>;">1. Call below number, one hour before
                    arriving at the terminal to deliver your vehicle.<br/></div>
                <div style="font-size:14px; color:<?php echo $color ?>;">2. Call below number as soon as you land to
                    dispatch and receive your vehicle.<br/><br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Heathrow)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">020 3921 0616 / 033 0341 1767<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Gatwick)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Luton)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Stansted)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller (City)</strong><br/>
                </div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br/></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Birmingham)</strong><br/></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon</div>
                <br/>

                <div style="font-size:<?php echo $tbl_font; ?>; color:<?php echo $color ?>;"><strong><u>DON'T
                            FORGET:</u></strong><br/>TICKETS, PASSPORTS, PHONES, CURRENCY, CHARGERS & OTHER VALUABLE
                    ITEMS.<br/><br/></div>
            </div>

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2"
                   cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>BOOKING REFERENCE:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->bk_ref); ?></span></td>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;"><div>CAR REG:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->bk_re_nu); ?>&nbsp;</div></span>
                    </td>
                </tr>
                <tr>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>MAKE/MODEL/COLOUR:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;">
                                <div class="normal"><?php echo strtoupper($bookings->bk_ve_ma); ?>
                                    / <?php echo strtoupper($bookings->bk_ve_mo); ?>
                                    / <?php
                                    //echo strtoupper($bookings->bk_ve_co);
                                    if($bookings->bk_ve_co == 'Other colour'){
                                        echo '`';
                                    }else{
                                        echo strtoupper($bookings->bk_ve_co);
                                    }
                                    ?></div>&nbsp;</span></td>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>RETURN DATE/TIME:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo date("d/m/Y H:i", strtotime($bookings->bk_to_date)); ?>&nbsp;</div></span>
                    </td>
                </tr>
                <tr>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;"><div>RETURN FLIGHT NUMBER:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->bk_re_fl_nu); ?>&nbsp;</div></span>
                    </td>
                    <td><span class="<?php echo $print; ?>"
                              style="color:<?php echo $color ?>;"><div>TERMINAL:</div></span><span
                            class="<?php echo $print1; ?>"
                            style="color:<?php echo $p1c; ?>;"><div class="normal"><?php echo strtoupper($bookings->ter_name2); ?>&nbsp;</div></span>
                    </td>
                </tr>

            </table>
            <br>

        </td>
        </td> <!--END SECOND COLUMN PAGE 1-->

    <?php } ?>


    </tr>
</table>
</table>

<table align="center" width="1200" border="0" cellpadding="2" cellspacing="0" bordercolor="" <?php echo 'KKKKK-'.$docket. '-KKKKKK'; ?>>
    <tr>
        <?php if($docket == 5){  ?>
        <td width="33%" valign="top" style="padding-right: 30px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <img  class="<?php echo $print ?>" style=""  width="100%" src="/storage/uploads/docket/vcon.png"/><br/>
        </td>
        <td width="33%" valign="top" style="padding-right: 30px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <img  class="<?php echo $print ?>" style=""  width="100%" src="/storage/uploads/docket/vcon.png"/><br/>
        </td>
        <td width="33%" valign="top" style="padding-right: 30px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <img  class="<?php echo $print ?>" style=""  width="100%" src="/storage/uploads/docket/vcon.png"/><br/>
        </td>
        <?php } else if($docket == 6 ){  ?>

        <td width="33%" valign="top" style="padding-right: 30px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <img  class="<?php echo $print ?>" style="    margin-left: 18px; "  src="/storage/uploads/docket/col1page4.png"/><br/>
        </td>
        <td width="33%" valign="top" style="padding-right: 30px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <img  class="<?php echo $print ?>" style="    margin-left: 18px; "  src="/storage/uploads/docket/col1page4.png"/><br/>
        </td>
        <td width="33%" valign="top" style="padding-right: 30px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <img  class="<?php echo $print ?>" style="    margin-left: 18px; "  src="/storage/uploads/docket/col1page4.png"/><br/>
        </td>
        <?php } ?>
    </tr>
</table>

<div class="page-breaks"></div>
