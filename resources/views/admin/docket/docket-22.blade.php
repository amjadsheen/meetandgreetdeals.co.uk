<style>
    <!--
    @page {
        size: landscape;
    }

    td span {
        line-height: 18px;
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
    td
    {
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
    .normal
    {
    font-weight:
    900;
    font-size:
    17px;
    }
    .large
    {
    font-weight:
    900;
    font-size:
    23px;
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
    .bbb
    {
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
    }
    .borderline
    {
    border-bottom:
    1px
    solid;
    margin-top:
    5px;
    }
    td.tdline
    {
    border-bottom:
    1px
    solid;
    width:
    300px
    }
    td.borderline{
        border-bottom: 1px solid;
    }
    .borderline- {
    margin-top: 5px;
}
</style>
<?php
$docket = $_GET['docket'];
$print1 = "print1";
$print = "";
$hideimage = 'hideimage';
$p1c = "#ffffff";
if ($docket == '22-p') {
    $p1c = "";
}

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
} elseif ($bookings->bk_payment_method == 4) {
    $payment_method = "Other";
}elseif ($bookings->bk_payment_method==7){
    $payment_method = "Cash";
}


$rh = 45;
$rh1 = 20;
$mtw = 1200;
$qrcode = $bookings->booking_id;
?>
<table align="center" width="<?php echo $mtw ?>" border="0" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
    <tr>



        <!--SECOND COLUMN START PAGE 1-->
        <td width="50%" valign="top" style="padding-left:6px; padding-right:6px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="0" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr>
                    <td colspan="2">
                        <div style="font-size:16px; text-align:center"><strong>
                                <span style="margin-left: 2px;"><img align="middle" width="200" src="/storage/uploads/{{$domain->website_logo}}" alt="{{$bookings->website_name}}" /></span>
                                <span style="float: righet;">
                                    @if (trim($bookings->whatsapp_num) !== '')
                                    Whats'app Your Details to {{ $bookings->whatsapp_num}}
                                    @endif
                                </span>
                            </strong>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">
                        <table width="270px">
                            <tr>
                                <td width="40px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Name:</div>
                                    </span></td>
                                <td width="300px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->cus_title) . " " . strtoupper($bookings->cus_name); ?> &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="95px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Sur Name:</div>
                                    </span></td>
                                <td class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->cus_surname); ?> &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">
                        <table>
                            <tr>
                            <td width="40px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Email:</div>
                                    </span></td>
                            <td width="300px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->cus_email); ?></div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <table>
                            <tr>
                                <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Mobile:</div>
                                    </span></td>
                                <td class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal">
                                            <?php echo strtoupper($bookings->cus_cell); ?>&nbsp;
                                            <?php if (!empty($bookings->cus_cell2)) {
                                                echo " /" . strtoupper($bookings->cus_cell2);
                                            } ?>
                                        </div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                <td class="emptytd borderline" colsp="2">&nbsp;</td>
                    <td class="emptytd borderline" colsp="2">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div class="borderline-" style="font-size:16px; color:;"><strong>DEPRTURE DETAILS:</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class="emptytd" colsp="2">&nbsp;</td>
                </tr>

                <tr>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="158px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Deprture Date:</div>
                                    </span></td>
                                <td class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal">
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
                                            &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="173px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Deprture Flight:</div>
                                    </span></td>
                                <td class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->bk_ou_fl_nu); ?> &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>


                </tr>
                <tr>
                <td class="emptytd borderline" colsp="2">&nbsp;</td>
                    <td class="emptytd borderline" colsp="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="borderline-" style="font-size:16px; color:;"><strong>ARRIVAL DETAILS:</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class="emptytd" colsp="2">&nbsp;</td>
                </tr>

                <tr>
                    <td>
                        <table width="250px">
                            <tr>
                                <td width="199px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Arrival Date:</div>
                                    </span></td>
                                <td width="250px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="large"><?php
                                                            if ($bookings->bk_to_date != '') {
                                                                $timestamp = strtotime($bookings->bk_to_date);
                                                                if ($timestamp != '') {
                                                                    echo date("d/m/Y", $timestamp);
                                                                } else {
                                                                    $date =  explode(' ', $bookings->bk_to_date);
                                                                    echo $date[0];
                                                                }
                                                            } else {
                                                                echo 'Not Set';
                                                            }
                                                            ?> &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="163px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Arrival Flight:</div>
                                    </span></td>
                                <td width="170px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="large"><?php echo strtoupper($bookings->bk_re_fl_nu); ?> &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="185px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Arrival Termainal:</div>
                                    </span></td>
                                <td width="170px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="large"><?php echo strtoupper($bookings->ter_name2); ?>
                                    </span>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="135px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Arrival Time:</div>
                                    </span></td>
                                <td width="170px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="large">
                                            <?php
                                            if ($bookings->bk_to_date != '') {
                                                $timestamp = strtotime($bookings->bk_to_date);
                                                if ($timestamp != '') {
                                                    echo date("H:i", $timestamp);
                                                } else {
                                                    $date =  explode(' ', $bookings->bk_to_date);
                                                    echo $date[1];
                                                }
                                            } else {
                                                echo 'Not Set';
                                            }
                                            ?>
                                        </div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                <td class="emptytd borderline" colsp="2">&nbsp;</td>
                    <td class="emptytd borderline" colsp="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="borderline-" style="font-size:16px; color:;"><strong>VEHICLE DETAILS:</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class="emptytd" colsp="2">&nbsp;</td>
                </tr>

                <tr>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="124px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Vehicle Reg:</div>
                                    </span></td>
                                <td width="220px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->bk_re_nu); ?> &nbsp; &nbsp;
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="145px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Vehicle Color:</div>
                                    </span>
                                </td>
                                <td width="170px" class="tdline">
                                    <div class="normal">
                                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                            <?php
                                            if ($bookings->bk_ve_co == 'Other colour') {
                                                echo '`';
                                            } else {
                                                echo strtoupper($bookings->clr_name);
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td>
                        <table width="325px">
                            <tr>
                                <td width="145px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Customer Name:</div>
                                    </span></td>
                                <td width="200px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->cus_title) . " " . strtoupper($bookings->cus_name) . " " . strtoupper($bookings->cus_surname); ?></div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="225px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Customer Signature:</div>
                                    </span>
                                </td>
                                <td width="170px" class="tdline">
                                    <span style="font-size: 11px;float: right;"></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="emptytd">&nbsp;</td>
                    <td class="emptytd"><span style="float:right;font-size: 11px;float: right;"><small><i>I Agree With {{ str_replace('.co.uk', '', $bookings->website_name) }} T&C's</i></small></span></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div  style="font-size:16px; color:;">
                            <p class="borderline" style="width: 110px; display: inline-block;"><strong>Agreed Price £</strong></p>
                            <p class="borderline" style="width: 50%; display: inline-block; float:right">for full T&C's visit {{ str_replace('https://', '', $bookings->website_url) }} </p>
                        </div>
                        <p style="margin-top: 5px; margin-bottom: 5px;"><u>Please Note:</u></p>
                        <ul style="padding-left: 16px;margin-top: 5px;">
                            <li>Call below number as soon as you land to dispatch and receive your vehicle.</li>
                            <li>Customer needs to pick up their vehicle within 1 hour after their flight has landed any delay the customer must inform the duty controller immediately.</li>
                            <li>If you are collecting your vehicle after midnight there will be a cost of £30 per hour.</li>
                            <li>Payment has to be made within 24 hours.</li>
                        </ul>

                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div style="font-size:16px; text-align:center"><strong>{{ str_replace('https://', '', $bookings->website_url) }}
                            </strong>

                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div style="font-size:16px; text-align:center;">
                            <strong style="text-transform: capitalize;">{{ str_replace('.co.uk', '', $bookings->website_name) }}
                                Contact Number
                                @if (trim($bookings->contact_num) !== '')
                                {{ $bookings->contact_num}}
                                @endif @if (trim($bookings->alternate_contact_num) !== '')
                                |
                                {{ $bookings->alternate_contact_num}}
                                @endif
                            </strong>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="font-size:16px; text-align:center"><strong>
                                <span style="margin-left: 2px;"><img align="middle" width="200" src="/storage/uploads/{{$domain->website_logo}}" alt="{{$bookings->website_name}}" /></span>
                                <span style="float: righet;">
                                    @if (trim($bookings->whatsapp_num) !== '')
                                    Whats'app Your Details to {{ $bookings->whatsapp_num}}
                                    @endif
                                </span>
                            </strong>
                        </div>
                    </td>
                </tr>
            </table>


        </td>

        <!-- ttt COPY SENSON HERE -->
        <td width="50%" valign="top" style="padding-left:6px; padding-right:6px; border-right:thin; border-right-style:dashed; border-color:#A0A0A4;">
            <table style="font-size:<?php echo $tbl_font; ?>;" width="100%" border="0" cellpadding="2" cellspacing="0" bordercolor="<?php echo $color ?>">
                <tr>
                    <td colspan="2">
                        <div style="font-size:16px; text-align:center"><strong>
                                <span style="margin-left: 2px;"><img align="middle" width="200" src="/storage/uploads/{{$domain->website_logo}}" alt="{{$bookings->website_name}}" /></span>
                                <span style="float: righet;">
                                    @if (trim($bookings->whatsapp_num) !== '')
                                    Whats'app Your Details to {{ $bookings->whatsapp_num}}
                                    @endif
                                </span>
                            </strong>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">
                        <table width="270px">
                            <tr>
                                <td width="40px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Name:</div>
                                    </span></td>
                                <td width="300px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->cus_title) . " " . strtoupper($bookings->cus_name); ?> &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="95px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Sur Name:</div>
                                    </span></td>
                                <td class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->cus_surname); ?> &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">
                        <table>
                            <tr>
                                <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Email:</div>
                                    </span></td>
                                <td class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->cus_email); ?></div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <table>
                            <tr>
                                <td><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Mobile:</div>
                                    </span></td>
                                <td class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal">
                                            <?php echo strtoupper($bookings->cus_cell); ?>&nbsp;
                                            <?php if (!empty($bookings->cus_cell2)) {
                                                echo " /" . strtoupper($bookings->cus_cell2);
                                            } ?>
                                        </div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="emptytd borderline" colsp="2">&nbsp;</td>
                    <td class="emptytd borderline" colsp="2">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div class="borderline-" style="font-size:16px; color:;"><strong>DEPRTURE DETAILS:</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class="emptytd" colsp="2">&nbsp;</td>
                </tr>

                <tr>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="158px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Deprture Date:</div>
                                    </span></td>
                                <td class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal">
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
                                            &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="173px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Deprture Flight:</div>
                                    </span></td>
                                <td class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->bk_ou_fl_nu); ?> &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>


                </tr>
                <tr>
                    <td class="emptytd borderline" colsp="2">&nbsp;</td>
                    <td class="emptytd borderline" colsp="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="borderline-" style="font-size:16px; color:;"><strong>ARRIVAL DETAILS:</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class="emptytd" colsp="2">&nbsp;</td>
                </tr>

                <tr>
                    <td>
                        <table width="250px">
                            <tr>
                                <td width="199px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Arrival Date:</div>
                                    </span></td>
                                <td width="250px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="large"><?php
                                                            if ($bookings->bk_to_date != '') {
                                                                $timestamp = strtotime($bookings->bk_to_date);
                                                                if ($timestamp != '') {
                                                                    echo date("d/m/Y", $timestamp);
                                                                } else {
                                                                    $date =  explode(' ', $bookings->bk_to_date);
                                                                    echo $date[0];
                                                                }
                                                            } else {
                                                                echo 'Not Set';
                                                            }
                                                            ?> &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="163px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Arrival Flight:</div>
                                    </span></td>
                                <td width="170px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="large"><?php echo strtoupper($bookings->bk_re_fl_nu); ?> &nbsp;</div>
                                    </span>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="185px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Arrival Termainal:</div>
                                    </span></td>
                                <td width="170px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="large"><?php echo strtoupper($bookings->ter_name2); ?>
                                    </span>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="135px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Arrival Time:</div>
                                    </span></td>
                                <td width="170px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="large">
                                            <?php
                                            if ($bookings->bk_to_date != '') {
                                                $timestamp = strtotime($bookings->bk_to_date);
                                                if ($timestamp != '') {
                                                    echo date("H:i", $timestamp);
                                                } else {
                                                    $date =  explode(' ', $bookings->bk_to_date);
                                                    echo $date[1];
                                                }
                                            } else {
                                                echo 'Not Set';
                                            }
                                            ?>
                                        </div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                <td class="emptytd borderline" colsp="2">&nbsp;</td>
                    <td class="emptytd borderline" colsp="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="borderline-" style="font-size:16px; color:;"><strong>VEHICLE DETAILS:</strong></div>
                    </td>
                </tr>
                <tr>
                    <td class="emptytd" colsp="2">&nbsp;</td>
                </tr>

                <tr>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="124px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Vehicle Reg:</div>
                                    </span></td>
                                <td width="220px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->bk_re_nu); ?> &nbsp; &nbsp;
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="145px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Vehicle Color:</div>
                                    </span>
                                </td>
                                <td width="170px" class="tdline">
                                    <div class="normal">
                                        <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                            <?php
                                            if ($bookings->bk_ve_co == 'Other colour') {
                                                echo '`';
                                            } else {
                                                echo strtoupper($bookings->clr_name);
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td>
                        <table width="325px">
                            <tr>
                                <td width="145px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Customer Name:</div>
                                    </span></td>
                                <td width="200px" class="tdline">
                                    <span class="<?php echo $print1; ?>" style="color:<?php echo $p1c; ?>;">
                                        <div class="normal"><?php echo strtoupper($bookings->cus_title) . " " . strtoupper($bookings->cus_name) . " " . strtoupper($bookings->cus_surname); ?></div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table width="270px">
                            <tr>
                                <td width="225px"><span class="<?php echo $print; ?>" style="color:<?php echo $color ?>;">
                                        <div>Customer Signature:</div>
                                    </span>
                                </td>
                                <td width="170px" class="tdline">
                                    <span style="font-size: 11px;float: right;"></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="emptytd">&nbsp;</td>
                    <td class="emptytd"><span style="float:right;font-size: 11px;float: right;"><small><i>I Agree With {{ str_replace('.co.uk', '', $bookings->website_name) }} T&C's</i></small></span></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div  style="font-size:16px; color:;">
                            <p class="borderline" style="width: 110px; display: inline-block;"><strong>Agreed Price £</strong></p>
                            <p class="borderline" style="width: 50%; display: inline-block; float:right">for full T&C's visit {{ str_replace('https://', '', $bookings->website_url) }} </p>
                        </div>
                        <p style="margin-top: 5px; margin-bottom: 5px;"><u>Please Note:</u></p>
                        <ul style="padding-left: 16px;margin-top: 5px;">
                            <li>Call below number as soon as you land to dispatch and receive your vehicle.</li>
                            <li>Customer needs to pick up their vehicle within 1 hour after their flight has landed any delay the customer must inform the duty controller immediately.</li>
                            <li>If you are collecting your vehicle after midnight there will be a cost of £30 per hour.</li>
                            <li>Payment has to be made within 24 hours.</li>
                        </ul>

                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div style="font-size:16px; text-align:center"><strong>{{ str_replace('https://', '', $bookings->website_url) }}
                            </strong>

                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div style="font-size:16px; text-align:center;">
                            <strong style="text-transform: capitalize;">{{ str_replace('.co.uk', '', $bookings->website_name) }}
                                Contact Number
                                @if (trim($bookings->contact_num) !== '')
                                {{ $bookings->contact_num}}
                                @endif @if (trim($bookings->alternate_contact_num) !== '')
                                |
                                {{ $bookings->alternate_contact_num}}
                                @endif
                            </strong>

                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div style="font-size:16px; text-align:center"><strong>
                                <span style="margin-left: 2px;"><img align="middle" width="200" src="/storage/uploads/{{$domain->website_logo}}" alt="{{$bookings->website_name}}" /></span>
                                <span style="float: righet;">
                                    @if (trim($bookings->whatsapp_num) !== '')
                                    Whats'app Your Details to {{ $bookings->whatsapp_num}}
                                    @endif
                                </span>
                            </strong>
                        </div>
                    </td>
                </tr>
            </table>


        </td>
        <!--/ ttt -->

        </td>


    </tr>
</table>
</table>
<div class="page-breaks"></div>