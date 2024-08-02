<style>
    <!--
    @page {
        size: landscape;
    }

    a {
        color: #000000;
    }
    -->
    @media
    all
    {
    .page-break
    {
    display:
    none;
    }
    html,
    body
    {
    margin:
    0px;
    }
    td {
    vertical-align:
    top;
    }
    h5,
    h4,
    h3,
    h1,
    h2
    {
    margin-bottom:
    4px;
    margin-top:
    4px;
    }
    .normal {
    font-weight:
    900;
    font-size:
    17px;
    }
    }
    h1.blank
    {
    color:
    #fff;
    }
    img.noprint
    {
    display:
    none;
    }
    hr.noprint
    {
    display:
    none;
    }
    .bbb {
    writing-mode:
    vertical-lr;
    }
    img.hideimage
    {
    visibility:
    hidden;
    }
    @media
    print
    {
    .noprint
    {
    visibility:
    hidden;
    }
    .print1
    {
    visibility:
    hidden;
    }
    img.hideimage
    {
    visibility:
    hidden;
    }
    .page-break
    {
    display:
    block;
    page-break-before:
    always;
    }
    h1.blank
    {
    color:
    #fff;
    }
    img.noprint,
    .hideprint
    {
    display:
    none;
    }
    hr.noprint
    {
    display:
    none;
    }
    }
</style>
<?php


$p = $_GET["print"];
$ext = "";
$visible = "";
$lcolor = "#000000";
$tbl_font = "16px";
$color = "";
$hideimage = '';
$print1 = "";
$p1c = "";
if ((isset($_GET["print"]) && ($_GET["print"] == 3)) && (isset($_GET["docket"]) &&  ($_GET["docket"] == 1))) {
    $blank = 'blank';
    $print1 = "print1";
    $hideimage = 'hideimage';
    $p1c = "#ffffff";
    if (isset($_SERVER['HTTP_USER_AGENT'])) { // detecting browser
        $agent = $_SERVER['HTTP_USER_AGENT'];
    }
    if (strlen(strstr($agent, 'Firefox')) > 0) { // if browser is firefox
        $p1c = "transparent";
    }
} else if ((isset($_GET["print"]) && ($_GET["print"] == 3)) && (isset($_GET["docket"]) &&  ($_GET["docket"] == 2))) {
    $blank = '';
    $ext = "";
    $print = "";
    $color = "";

    if (isset($_SERVER['HTTP_USER_AGENT'])) { // detecting browser
        $agent = $_SERVER['HTTP_USER_AGENT'];
    }
    if (strlen(strstr($agent, 'Firefox')) > 0) { // if browser is firefox
        $color = "";
    }
    $lcolor = $color;
} else if ((isset($_GET["print"]) && ($_GET["print"] == 3)) && (isset($_GET["docket"]) &&  ($_GET["docket"] == 0))) {
    $blank = '';
    $ext = "-blank";
    $print = "noprint";
    $color = "#ffffff";

    if (isset($_SERVER['HTTP_USER_AGENT'])) { // detecting browser
        $agent = $_SERVER['HTTP_USER_AGENT'];
    }
    if (strlen(strstr($agent, 'Firefox')) > 0) { // if browser is firefox
        $color = "transparent";
    }
    $lcolor = $color;
}



$is_payment_done = "";
if(empty($bookings->payment_status_ipn)){
    $is_payment_done = " -N";
}
if ($bookings->bk_payment_method == 1) {
    $payment_method = "Pay later";
} else if ($bookings->bk_payment_method == 2) {
    $payment_method = "Paypal" . $is_payment_done ;
} elseif ($bookings->bk_payment_method == 3) {
    $payment_method = "Worldpay" . $is_payment_done ;
} elseif ($bookings->bk_payment_method == 5) {
    $payment_method = "Stripe" . $is_payment_done ;
} elseif ($bookings->bk_payment_method == 4) {
    $payment_method = "Other";
}elseif ($bookings->bk_payment_method==6){
    $payment_method = "Bank Transfer";
}elseif ($bookings->bk_payment_method==7){
    $payment_method = "Cash";
}


$rh = 45;
$rh1 = 20;
$mtw = 1200;
//$qrcode = ( $bk_id * 5 ) + 5 ;
if ($p == 1) {
    $qrcode = "blank";
}

$qrcode = $bookings->booking_id;
//$bookings->bk_date
?>
<table align="center" width="<?php echo $mtw ?>" border="0" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
    <tr>
        <!-- FIRST COLUMN START PAGE 1 -->
        <td width="40%" valign="top" style="position:relative;padding-right: 12px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">            <div style="float:left;">
                <img align="middle" width="140" src="/storage/uploads/{{$domain->website_logo}}" alt="{{$domain->website_name}}" />
                <?php if ((isset($_GET["print"]) && ($_GET["print"] == 3)) && (isset($_GET["docket"]) &&  ($_GET["docket"] != 1))) { ?>
                    <span style="padding: 2px 40px;float: right;margin-top: 33px;"><span><?php echo date('d/m/Y', strtotime($bookings->bk_date)); ?></span> ( <span><?php echo $booking_count; ?> ) </span></span>
                <?php } ?>
            </div>
            <div style="float:right;">
                <img width="50" class="<?php echo $hideimage; ?>" src="/storage/qrcodes/{{$bookings->booking_id}}.png" />
            </div>
            <br /><br />
            <?php if(!empty($bookings->refrence_num_extra)){  ?>
                <p style="position: absolute; top: -5px; right: 77px; font-size: 14px;"> <?php echo $bookings->refrence_num_extra ?></p>
            <?php }else{ ?>
                <br />
            <?php } ?>

            <!-- CUSTOMER  -->
            <p style="font-size: 11px;margin: 2px 0;clear:both">When you park then make sure windows are closed and lights are off</p>
            <p style="font-size: 11px; margin:0;margin-bottom:2px;">Don’t put Petrol or Diesel in the customer car</p>
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                        <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                            CUSTOMER
                        </span>
                    </td>
                    <td width="29%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">NAME:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->cus_title) . " " . strtoupper($bookings->cus_name); ?> &nbsp;</div>
                        </span>
                    </td>
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">SURNAME:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->cus_surname); ?> &nbsp;</div>
                        </span>
                    </td>
                    <td width="40%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">BOOKING REF:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal" style=""><?php echo strtoupper($bookings->bk_ref); ?> &nbsp;</div>
                        </span>
                    </td>
                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">MOBILE 1:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->cus_cell); ?> &nbsp;</div>
                        </span>
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">MOBILE 2:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->cus_cell2); ?></div> &nbsp;
                        </span>
                    </td>
                    <td width="40%">
                        <?php if ($bookings->bk_payment_method != '') { ?>
                            <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                <div style="font-size:15px">PAYMENT STATUS:</div>
                            </span>
                            <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                <div class="normal">
                                    <?php
                                    echo '<span style="font-size: 15px;">' . strtoupper($payment_method) . '</span>'; ?>


                                        <?php if ($bookings->bk_payment_method == 1 || (strpos($payment_method, "-N") !== false)) { ?>
                                        <?php echo $bookings->cur_symbol; ?>
                                        <?php
                                        // if ($bookings->bk_discount_offer_value == 0) {
                                        //     $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                        //     $TOTAL_PAYABLE_AMOUNT = $bookings->bk_total_amount + $carwash + $bookings->not_working_hours + $bookings->last_min_booking + $bookings->charging_service_charges + $bookings->charging;
                                        //     //echo number_format($bookings->bk_total_amount, 2, '.', '');
                                        //     echo number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                                        // } else {
                                        //     $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                        //     $TOTAL_PAYABLE_AMOUNT = $bookings->bk_final_amount + $carwash + $bookings->not_working_hours + $bookings->last_min_booking + $bookings->charging_service_charges + $bookings->charging;
                                        //     //echo number_format($bookings->bk_final_amount, 2, '.', '');
                                        //     echo number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                                        // }
                                        $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                        $TOTAL_PAYABLE_AMOUNT = $bookings->bk_total_amount + $carwash + $bookings->not_working_hours + $bookings->last_min_booking + $bookings->charging_service_charges + $bookings->charging;
                                        //echo number_format($bookings->bk_total_amount, 2, '.', '');
                                        echo number_format($TOTAL_PAYABLE_AMOUNT, 2, '.', '');
                                        ?>
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
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                        <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                            VEHICLE
                        </span>
                    </td>
                    <td width="39%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">CAR REG:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->bk_re_nu); ?> &nbsp;</div>
                        </span>
                    </td>
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">MAKE:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->bk_ve_ma); ?> &nbsp;</div>
                        </span>
                    </td>
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">MODEL:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->bk_ve_mo); ?> &nbsp;</div>
                        </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">COLOUR:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal">
                                <?php
                                if ($bookings->bk_ve_co == 'Other colour') {
                                    echo '`';
                                } else {
                                    echo strtoupper($bookings->clr_name);
                                }
                                ?>
                                &nbsp;
                            </div>
                        </span>
                    </td>
                    

                    <td colspan="2" style="width: 100%;text-align:center;line-height: 17px;">
                        <span class="<?php echo $print; ?> bbbb" style="color:<?php echo $color ?>;">
                        <strong>CAR<span style="visibility: hidden">-</span>WASH </strong>
                        </span>
                        <?php
                        if (trim($bookings->carwash_in_and_out) != 0) {

                            $title = '<span style="font-weight: 100; font-size: 13px;">FULL CAR WASH (IN AND OUT)</span>';
                        } elseif (trim($bookings->carwash_out_only) != 0) {
                            $title = '<span style="font-weight: 100; font-size: 13px;">CAR WASH (ONLY OUTSIDE) </span>';
                        } elseif (trim($bookings->carwash_in_only) != 0) {
                            $title = '<span style="font-weight: 100; font-size: 13px;">CAR WASH (ONLY INSIDE)</span>';
                        } else {
                            $title = 'CAR WASH';
                        }
                        ?>

                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal" style="font-size: 23px; margin-top: -2px; padding: 2px;">
                                <?php
                                $carwash = $bookings->carwash_in_and_out + $bookings->carwash_out_only + $bookings->carwash_in_only;
                                if ($carwash != 0) {
                                    echo $title . ' <span style="font-size:15px" class="hideprint">' . $bookings->cur_symbol . " " . number_format($carwash, 2, '.', '') . '</span>';
                                } else {
                                    echo ' ';
                                }
                                ?>
                                &nbsp;
                            </div>
                        </span>
                    </td>

                </tr>

            </table>
            <!-- /VEHICLE  -->

            <div style="margin-bottom: 6px"></div>
            <!-- DEPRTURE DETAILS  -->

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                        <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                            DEPRTURE
                        </span>
                    </td>
                    <td>
                    <table>
                        <tbody>
                            <tr>
                                <td style="width:50%">
                                    <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div style="font-size: 15px;">DROP OFF DATE:</div>
                                    </span>
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal" style="font-size: 20px;">
                                            <?php

                                            if ($bookings->bk_ve_do_dt != '') {
                                                $timestamp = date('Y/m/d', strtotime($bookings->bk_ve_do_dt));
                                                if ($timestamp != '') {
                                                    $date =  explode(' ', $bookings->bk_ve_do_dt);
                                                    echo date("d/m/Y", strtotime($date[0]));
                                                } else {
                                                    $date =  explode(' ', $bookings->bk_ve_do_dt);
                                                    echo date("d/m/Y", strtotime($date[0]));
                                                }
                                            } else {
                                                echo 'Not Set';
                                            }
                                            ?>
                                            &nbsp;
                                        </div>
                                    </span>
                                </td>
                                <td style="border-right: 1px solid; width:5%">&nbsp;</td>
                                <td style="width:40%;text-align: right;">
                                    <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div style="font-size: 15px;">
                                            <p style="text-align: center;">Ulez Checked:</p>
                                        </div>
                                    </span>
                                    <span class="<?php echo $print1; ?>" style="line-height: 10px;color:<?php echo $p1c; ?>;">
                                        <div class="small" style="font-size: 12px;">
                                            <p style="margin-bottom: 0px; margin-top: -10px;text-align:center;font-size: 18px;font-weight: 700;">
                                            <?php echo $bookings->ulze ?>
                                            </p>
                                            &nbsp;
                                        </div>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                    <td width="" style="text-align: center;">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size: 15px;">TERMINAL:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal" style="font-size: 20px;"><?php echo strtoupper($bookings->ter_name1); ?> &nbsp;</div>
                        </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                    
                        
                    
                        <!----- IF CHARGING ----->
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="width:50%">
                                            <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                                <div style="font-size: 15px;">DROP OFF TIME:</div>
                                            </span>
                                            <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                                <div class="normal" style="font-size: 20px;">
                                                    <?php
                                                    if ($bookings->bk_ve_do_dt != '') {
                                                        $timestamp = date('H:i', strtotime($bookings->bk_ve_do_dt));

                                                        if ($timestamp != '') {
                                                            //echo $bookings->bk_ve_do_dt;
                                                            //echo '<br>';
                                                            //echo $timestamp;
                                                            // echo '<br>';
                                                            // echo date("H:i", $timestamp);
                                                            //$date =  explode(' ',$bookings->bk_ve_do_dt);
                                                            //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                                            echo $timestamp;
                                                        } else {
                                                            $hr =  explode(' ', $bookings->bk_ve_do_dt);
                                                            //echo $bookings->bk_ve_do_dt.''.$hr[1];
                                                            echo $hr[1];
                                                        }
                                                    } else {
                                                        echo 'Not Set';
                                                    }


                                                    ?>
                                                    &nbsp;
                                                </div>
                                            </span>
                                        </td>
                                        <td style="border-right: 1px solid; width:5%">&nbsp;</td>
                                        <td style="width:40%;text-align: right;">
                                            <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                                <div style="font-size: 15px;">
                                                    <p style="text-align: center;">CHARGING:</p>
                                                </div>
                                            </span>
                                            <span class="<?php echo $print1; ?>" style="line-height: 9px;color:<?php echo $p1c; ?>;">
                                                <div class="small" style="font-size: 12px;">
                                                    <p style="margin-bottom: 0px; margin-top: -10px;text-align:center;font-size: 20px;font-weight: 700;">
                                                    <?php if ($bookings->charging > 0) { ?>
                                                    £&nbsp;{{$bookings->charging}}
                                                    <?php } ?>
                                                    </p>
                                                    &nbsp;
                                                </div>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <!----- /IF CHARGING ----->
                    <td width="">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size: 15px;">OUTBOUND FLIGHT:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal" style="font-size: 20px;"><?php echo strtoupper($bookings->bk_ou_fl_nu); ?> &nbsp;</div>
                        </span>
                    </td>

                </tr>

            </table>
            <!-- /DEPRTURE DETAILS  -->

            <!-- CAR WASH  -->
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td style="width: 30%;text-align:center;line-height: 17px;">
                        <span class="<?php echo $print; ?> bbbb" style="color:<?php echo $color ?>;">
                           <strong>BOOKING DAYS</strong>
                        </span><br>
                        <span class="<?php echo $print; ?> bbbb" style="font-size:24px;font-weight: 900; color:<?php echo $color ?>;">
                        <?php echo $bookings->bk_days; ?> 
                        </span> Days
                    </td>
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">IN MILEAGE:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal">&nbsp;</div>
                        </span>
                    </td>
                    <td width="30%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size:15px">OUT MILEAGE:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal">&nbsp;</div>
                        </span>
                    </td>
                </tr>
            </table>
            <!-- /CAR WASH  -->
            <div style="margin-bottom: 6px"></div>



            <div style="margin-bottom: 6px"></div>

            <!-- ARRIVAL DETAILS  -->

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="1%" rowspan="2">
                        <span class="<?php echo $print; ?> bbb" style="color:<?php echo $color ?>;">
                            ARRIVAL
                        </span>
                    </td>
                    <td width="59%">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size: 15px;">ARRIVAL DATE:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal" style="font-size: 29px;">
                                <?php
                                if ($bookings->bk_to_date != '') {
                                    $timestamp = strtotime($bookings->bk_to_date);
                                    if ($timestamp != '') {
                                        //echo $bookings->bk_to_date;
                                        //echo '<br>';
                                        //echo $timestamp;
                                        // echo '<br>';
                                        echo date("d/m/Y", $timestamp);
                                        //$date =  explode(' ',$bookings->bk_to_date);
                                        //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                        //echo $date[0];
                                    } else {
                                        //echo $bookings->bk_to_date;
                                        $date =  explode(' ', $bookings->bk_to_date);
                                        //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                        echo $date[0];
                                    }
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                &nbsp;
                            </div>
                        </span>
                    </td>
                    <td width="">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size: 15px;">TERMINAL:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->ter_name2); ?> &nbsp;</div>
                        </span>
                    </td>

                </tr>
                <tr height="<?php echo $rh1; ?>">
                    <td width="" 60%">
                        <table>
                            <tr>
                                <td style="width:50%">
                                    <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div style="font-size: 15px;">ARRIVAL TIME:</div>
                                    </span>
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal" style="font-size: 29px;">
                                            <?php
                                            if ($bookings->bk_to_date != '') {
                                                $timestamp = strtotime($bookings->bk_to_date);
                                                if ($timestamp != '') {
                                                    //echo $bookings->bk_to_date;
                                                    //echo '<br>';
                                                    //echo $timestamp;
                                                    // echo '<br>';
                                                    echo date("H:i", $timestamp);
                                                    //$date =  explode(' ',$bookings->bk_to_date);
                                                    //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                                    // echo $date[1];
                                                } else {
                                                    //echo $bookings->bk_to_date;
                                                    $date =  explode(' ', $bookings->bk_to_date);
                                                    //echo $bookings->bk_ve_do_dt.''.$hr[0];
                                                    echo $date[1];
                                                }
                                            } else {
                                                echo 'Not Set';
                                            }
                                            ?>
                                            &nbsp;
                                        </div>
                                    </span>
                                </td>
                                <td style="border-right: 1px solid; width:5%">&nbsp;</td>
                                <td style="width:20%;text-align: right;">
                                    <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div style="font-size: 15px;">
                                            <p style="text-align: center;">BAGS:</p>
                                        </div>
                                    </span>
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="small" style="font-size: 12px;">
                                            <p style="margin-bottom: 0px; margin-top: -10px;text-align: center;">{{ $bookings->luggage }}</p>
                                            &nbsp;
                                        </div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td width="">
                        <span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div style="font-size: 15px;">INBOUND FLIGHT:</div>
                        </span>
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal" style="font-size: 29px;"><?php echo strtoupper($bookings->bk_re_fl_nu); ?> &nbsp;</div>
                        </span>
                    </td>

                </tr>

            </table>
            <!-- /ARRIVAL DETAILS  -->







            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Vehicle Departure Declaration</h5>

            <div style="font-size:10px; color:<?php echo $color ?>;" class="<?php echo $print; ?>">
                By signing this document I agree that I have read the terms and conditions of {{$bookings->website_name}} and agree
                to the damage noted to my car. I further agree that the damage noted is not an accurate reflection
                of the condition of the car due to time constraints and location. Please ensure that all belongings
                such as satnavs, loose cash and other valuable items are not present in the vehicle as we cannot
                verify that these items were left in your vehicle.
                The customer must take a clear picture of the vehicle showing date, time and location when the driver is present.
                {{$bookings->website_name}} is not responsible for natural dirt caused by birds and weather.
            </div>
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">SIGN.<br /> CUST.:</span>
                    </td>
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">NAME CUSTOMER:</span><br /><span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;"><?php // echo strtoupper($bookings->cus_title)." ".strtoupper($bookings->cus_name) ;
                                                                                                                                                                                                                            ?></span>
                    </td>
                </tr>
            </table>
            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Vehicle Arrival Declaration</h5>

            <div style="font-size:10px; color:<?php echo $color ?>;" class="<?php echo $print; ?>">
                I have accepted my car back and I have checked my car to ensure that it is exactly how I left it and
                I am satisfied with the condition of my car and the service I have received.
            </div>
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh1; ?>">
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">SIGN.<br /> CUST.:</span>
                    </td>
                    <td width="50%" valign="top"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">NAME CUSTOMER:</span><br /><span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;"><?php // echo strtoupper($bookings->cus_title)." ".strtoupper($bookings->cus_name) ;
                                                                                                                                                                                                                            ?></span>
                    </td>
                </tr>
            </table>
            <h5 class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">Note:</h5>
            <?php if ($p != "2") { ?>
                <hr class="<?php echo $print; ?>" style="margin-bottom: 0;" /><?php } ?>
            <br>
        </td>
        <!-- END FIRST COLUMN PAGE 1-->
        <!--SECOND COLUMN START PAGE 1-->
        <td width="40%" valign="top" style="padding-left:12px; padding-right:12px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <div style="float:left;">
                <img align="middle" width="300" src="/storage/uploads/{{$domain->website_logo}}" alt="{{$domain->website_name}}" />
            </div>
            <div style="float:right;"><img width="100" class="<?php echo $hideimage; ?>" src="/storage/qrcodes/{{$bookings->booking_id}}.png" />
            </div>

            <br /><br /><br /><br /><br /><br /><br /><br />

            <div style="float:left1;" class="<?php echo $print; ?>">
                <div align="center" style="font-size:20px;color:<?php echo $color ?>;"><strong>Customer service
                        numbers</strong><br /></div>
                <div align="center" style="font-size:20px; color:<?php echo $color ?>;">{{$bookings->contact_num}} @if (trim($bookings->alternate_contact_num) !== '') / {{$bookings->alternate_contact_num}} @endif<br /></div>

                <div align="center">
                    <a href="mailto:{{$bookings->email}}" class="<?php echo $print; ?>" style="color:<?php echo $lcolor; ?>;;">{{$bookings->email}}</a>
                    &nbsp;
                    <a href="mailto:{{$bookings->alternate_email}}" class="<?php echo $print; ?>" style="color:<?php echo $lcolor; ?>;;">{{$bookings->alternate_email}}</a>
                </div>
                <br />

                <div style="font-size:14px; color:<?php echo $color ?>;">1. Call below number, one hour before
                    arriving at the terminal to deliver your vehicle.<br /></div>
                <div style="font-size:14px; color:<?php echo $color ?>;">2. Call below number as soon as you land to
                    dispatch and receive your vehicle.<br /><br /></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Heathrow)</strong><br /></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">{{$bookings->contact_num}} @if (trim($bookings->alternate_contact_num) !== '') / {{$bookings->alternate_contact_num}} @endif<br /></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Gatwick)</strong><br /></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br /></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Luton)</strong><br /></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br /></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Stansted)</strong><br /></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br /></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller (City)</strong><br />
                </div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon<br /></div>
                <div style="font-size:16px;color:<?php echo $color ?>;"><strong>Duty Controller
                        (Birmingham)</strong><br /></div>
                <div align="center" style="font-size:16px; color:<?php echo $color ?>;">Coming Soon</div>
                <br />

                <div style="font-size:<?php echo $tbl_font; ?>; color:<?php echo $color ?>;"><strong><u>DON'T
                            FORGET:</u></strong><br />TICKETS, PASSPORTS, PHONES, CURRENCY, CHARGERS & OTHER VALUABLE
                    ITEMS.<br /><br /></div>
            </div>

            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div>BOOKING REFERENCE:</div>
                        </span><span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->bk_ref); ?>
                        </span></td>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div>CAR REG:</div>
                        </span><span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->bk_re_nu); ?>&nbsp;</div>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div>MAKE/MODEL/COLOUR:</div>
                        </span><span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->bk_ve_ma); ?>
                                / <?php echo strtoupper($bookings->bk_ve_mo); ?>
                                / <?php
                                    //echo strtoupper($bookings->bk_ve_co);
                                    if ($bookings->bk_ve_co == 'Other colour') {
                                        echo '`';
                                    } else {
                                        echo strtoupper($bookings->bk_ve_co);
                                    }
                                    ?></div>&nbsp;
                        </span></td>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div>RETURN DATE/TIME:</div>
                        </span><span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo date("d/m/Y H:i", strtotime($bookings->bk_to_date)); ?>&nbsp;</div>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div>RETURN FLIGHT NUMBER:</div>
                        </span><span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->bk_re_fl_nu); ?>&nbsp;</div>
                        </span>
                    </td>
                    <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                            <div>TERMINAL:</div>
                        </span><span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <div class="normal"><?php echo strtoupper($bookings->ter_name2); ?>&nbsp;</div>
                        </span>
                    </td>
                </tr>

            </table>
            <br>

        </td>
        </td> <!--END SECOND COLUMN PAGE 1-->
        <!--THIRD COLUMN START PAGE 1-->
        <td width="20%" valign="top" style="padding-right: 6px; padding-left:12px;">
            <div align="center">
                <img width="100" class="<?php echo $hideimage; ?>" src="/storage/qrcodes/{{$bookings->booking_id}}.png" />
            </div>
            <div align="center"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                    <h2>CAR REG</h2>
                </span></div>
            <table style="font-size:29px;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh; ?>">
                    <td align="center">
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <h2 class="<?php echo $blank; ?>"><?php echo strtoupper($bookings->bk_re_nu); ?></h2>
                        </span>
                    </td>
                </tr>
            </table>
            <br>
            <div align="center"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                    <h2>TERMINAL</h2>
                </span></div>
            <table style="font-size:29px;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh; ?>">
                    <td align="center">
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <h1 class="<?php echo $blank; ?>"><?php echo strtoupper($bookings->ter_name2); ?></h1>
                        </span>
                    </td>
                </tr>
            </table>
            <br>

            <div align="center"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                    <h2>FLIGHT NUMBER</h2< /span>
            </div>
            <table style="font-size:29px;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh; ?>">
                    <td align="center">
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <h1 class="<?php echo $blank; ?>"><?php echo $bookings->bk_re_fl_nu; ?></h1>
                        </span>
                    </td>
                </tr>
            </table>
            <br />

            <div align="center"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                    <h2>DATE OF ARRIVAL</h2>
                </span></div>
            <table style="font-size:29px;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh; ?>">
                    <td align="center">
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <h1 class="<?php echo $blank; ?>"> <?php echo date("d/m/Y", strtotime($bookings->bk_to_date)); ?></h1>
                        </span>
                    </td>
                </tr>
            </table>
            <br />

            <div align="center"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                    <h2>TIME OF ARRIVAL</h2< /span>
            </div>
            <table style="font-size:29px;" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr height="<?php echo $rh; ?>">
                    <td align="center">
                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                            <h1 class="<?php echo $blank; ?>"><?php echo date("H:i", strtotime($bookings->bk_to_date)); ?></h1>
                        </span>
                    </td>
                </tr>
            </table>
            <br />




            <!--END THIRD COLUMN PAGE 1-->
    </tr>
</table>
</table>
<table align="center" width="1200" border="0" cellpadding="2" cellspacing="0" bordercolor="">
    <tr>
        <td width="37.25%" valign="top" style="padding-right: 30px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <img class="<?php echo $print ?>" style="" width="100%" src="/storage/uploads/docket/vcon.png" /><br />
            <?php
            if ((isset($_GET["print"]) && ($_GET["print"] == 3)) && (isset($_GET["docket"]) &&  ($_GET["docket"] == 2))) {
                $REGNUM = trim(strtoupper($bookings->bk_re_nu));
                $merged = '';
                for ($i = 0; $i < strlen($REGNUM); $i++) {
                    if ($i == 1 || $i == 3) {
                        $space = '<span style="margin-left: 10px;"></span>';
                    } else {
                        $space = '';
                    }
                    $merged .= $REGNUM[$i] . $space;
                }
            ?>
                <h1 style="text-align: center;-webkit-transform: rotate(-180deg);-moz-transform: rotate(-180deg);"><?php echo $merged; ?> </h1>
            <?php } ?>
        </td>
        <td width="37.5%" valign="top" style="padding-right: 30px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <img class="<?php echo $print ?>" style="margin-left: 52px;" src="/storage/uploads/docket/col1page4.png" /><br />
        </td>
        <td width="23.85%" valign="top" style="padding-right: 12px;"></td>
    </tr>
</table>

<div class="page-break"></div>