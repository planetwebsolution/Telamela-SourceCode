<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_ACNT_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title> <?php echo WHOLESALER_DASHBOARD_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script  type="text/javascript" src="<?php echo JS_PATH ?>customer_feedback.js"></script>
        <script  type="text/javascript" src="<?php echo JS_PATH ?>jquery.checkradios.min.js"></script>
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>jquery.checkradios.min.css" type="text/css"/>
        <!-- CheckRadios Usage Examples -->
        <script>
            $(document).ready(function () {
                $('.checkradios').checkradios();
                $('.company_sec').each(function () {
                    var maxHeight = 0;
                    $(this).find("div.address_sec").each(function () {
                        if ($(this).height() > maxHeight) {
                            maxHeight = $(this).height();
                        }
                    });
                    $(this).find("div.address_sec").height(maxHeight);
                });
                $('#cboxClose').click(function () {
                    //  alert("hello");
                    location.reload();
                });


            });
            function testavi(id, cid) {
                // alert(id);
                //var logisticid= $("#logisticportalid").val()
                jscallZoneCountry('QuickViewZoneCountry');
                // showShippingPortal(cid, 0,"frmShippingGatewayID","frmShippingMultiCountryID");
                showShippingPortal(id, cid, "frmShippingGatewayID", "frmShippingMultiCountryID");
                //alert($("#frmShippingGatewayID").val());
                $('#frmShippingGatewayID [value="20"]').attr('selected', true);
                //$('#frmShippingGatewayID').val(id).change();
//                showdetailsofshippingprice('', '', logisticid);


//                setTimeout(
//                function() 
//                {
//                    $('#frmShippingGatewayID').val(id).change();
//
//                  //do something special
//                }, 100);

            }

        </script>
    </head>
    <body>
        <style type="text/css">.top_company .top_account li label strong{margin-top:0px;}  p{margin:0px !important;}</style>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header" style="border-bottom:none"><div class="layout">

            </div>
        </div><?php include_once INC_PATH . 'header.inc.php'; ?>

        <div id="ouderContainer" class="ouderContainer_1">  <div class="wholesalerHeaderSection"   style="width:100%; border-bottom:1px solid #e7e7e7; height:50px; padding-top:16px; clear:both"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout"> 



                <div class="header1" style="border-bottom:0px solid">

                    <?php
                    if ($objCore->displaySessMsg()) {
                        ?>
                        <div class="successMessage">
                            <?php
                            echo $objCore->displaySessMsg();
                            $objCore->setSuccessMsg('');
                            $objCore->setErrorMsg('');
                            ?>
                        </div>
                    <?php }
                    ?>
                </div>
                <div class="add_pakage_outer">
                    <div class="top_container " style="padding:0px 0 19px 0">

                     <!--   <h2 class="icon6"><?php echo MY; ?>  <span> <?php echo AC; ?></span></h2>-->
                    </div>

                    <div class="body_inner_bg">
                        <div class="add_edit_pakage aapplication_form">

                            <?php
                            $wholesaler_details = $objPage->arrWholesalerDeatails;
                            //pre($wholesaler_details);
                            ?>
                            <div class="top_company ">
                                <ul class="top_account"> 
                                    <div class="top_account_buttons">
                                        <a class="edit2 edit3 change_pass submit3" style="float:right" href="<?php echo $objCore->getUrl('edit_my_password_wholesaler.php'); ?>"><?php echo CHANGE_PS; ?></a> <a class="edit2 edit3 submit3" style="float:right" href="<?php echo $objCore->getUrl('edit_my_account_wholesaler.php'); ?>"><?php echo EDIT_AC; ?></a>

                                    </div>

                                    <li> <label><?php echo COM_NAME; ?></label><span> <?php echo $wholesaler_details['CompanyName'] ?> </span>  </li>
                                    <li> <label><?php echo ABT_COM; ?> </label> <span><?php echo $wholesaler_details['AboutCompany'] ?></span>  </li>
                                    <li> <label><?php echo SERV; ?> </label> <span><?php echo ($wholesaler_details['Services']) ? $wholesaler_details['Services'] : 'NA' ?></span>  </li>
                                </ul>
                                <div class="outer_top_company">
                                    <ul class="profile_right">
                                        <li onclick="window.location.href = 'customer_orders.php'">
                                            <span class="icons"><img alt="sold Item" src="common/images/sold_icon.png"/></span>
                                            <span class="feedbacks">Item Sold</span>
                                            <span class="feeds_no blue_bg"><?php echo ($objPage->arrwholesalerSoldItems[0]['soldItems']) ? $objPage->arrwholesalerSoldItems[0]['soldItems'] : '0'; ?></span>
                                        </li>
                                        <li onclick="window.location.href = 'customer_feedbacks.php'">
                                            <span class="icons"><img alt="Positive Feedbacks " src="common/images/right_icon.png"/></span>
                                            <span class="feedbacks">Positive Feedbacks</span>
                                            <span class="feeds_no"><?php echo ($objPage->arrwholesalerPositiveFeedback[0]['positiveFeedback']) ? $objPage->arrwholesalerPositiveFeedback[0]['positiveFeedback'] : '0'; ?> </span>
                                        </li>
                                        <li onclick="window.location.href = 'customer_feedbacks.php'">
                                            <span class="icons"><img alt="Negative Feedbacks" src="common/images/red_cross.png"></span>
                                            <span class="feedbacks">Negative Feedbacks</span>
                                            <span class="feeds_no red_bg"><?php echo ($objPage->arrwholesalerNegativeFeedback[0]['negativeFeedback']) ? $objPage->arrwholesalerNegativeFeedback[0]['negativeFeedback'] : '0'; ?></span>
                                        </li>

                                    </ul>

                                    <div class="top_company_right">
                                        <h3><?php echo KPI; ?>: <?php echo $objPage->kpi['kpi']; ?></h3>
                                        <!--scroll-pane-->
                                        <!--                                        <div class="" style="overflow: hidden; padding: 0px; width: 221px;">
                                                                                    <div class="jspContainer" style="width: 221px; height: 184px;">
                                                                                        <div class="jspPane" style="padding: 0px; top: 0px; width: 221px;">-->
                                        <div class="right_scroll simple_box">
                                            <strong class="fullStrong"><?php echo WAR; ?></strong>
                                            <?php
                                            if (!empty($objPage->arrWholesalerWarnings)) {
                                                foreach ($objPage->arrWholesalerWarnings as $var) {
                                                    echo '<div class="warningDiv"><p href="#' . $var['pkWarningID'] . '" class="' . $var['pkWarningID'] . ' dash-whl-kpi" onclick="wholesalerWarningPopup(' . $var['pkWarningID'] . ');">' . ucfirst(substr($var['WarningText'], 0, 60)) . ' ...' . '</p>
<small>' . $objCore->localDateTime($var['WarningDateAdded'], DATE_TIME_FORMAT_SITE_FRONT) . '</small></div>';
                                                    echo '<div style="display:none;"><div id="' . $var['pkWarningID'] . '" class="common_popup_box"><div class="div_blank"><p align="justify;">' . html_entity_decode($var['WarningMsg']) . '</p></div></div></div>';
                                                }
                                            } else {
                                                echo NO_WAR;
                                            }
                                            ?>
                                        </div>
                                        <!--                                                </div>
                                                                                    </div>
                                                                                </div>-->
                                    </div>
                                    <div class="commisson_sec">
                                        <h5>Sales Commission of TelaMela : <span><?php echo 100 - $wholesaler_details['Commission']; ?>%</span></h5>
                                        <p>*To be deducted by TelaMela</p>
                                    </div>

                                </div> 
                            </div>
                            <div class="company_sec">

                                <div class="shipp_sec address_sec">
                                    <h3>Choose Logistic Company(s)<?php // echo SEL_SHIPP_GAT;   ?></h3>
                                    <hr class="style-one">
                                        <ul class="left_sec font_style">
                                            <li>
                                                <?php
                                                foreach ($objPage->arrShippingList as $kShip => $vShip) {
                                                    // pre($objPage->arrShippingList);
                                                    // pre($wholesaler_details);
                                                    ?>
                                                    <input disabled="disabled" class="newcheckClass" type="checkbox" name="frmShippingGateway[]" value="<?php echo $vShip['pkShippingGatewaysID']; ?>" <?php
                                                    if (in_array($vShip['logisticportalid'], $wholesaler_details['shippingDetails'])) {
                                                        echo 'checked="checked"';
                                                    }
                                                    ?> onclick="return false;"/>&nbsp;&nbsp;
                                                           <?php
                                                           //pre($_SESSION['sessUserInfo']);
                                                           //logisticportal
                                                           $current_country_id = $_SESSION['sessUserInfo']['countryid'];

                                                           $current_country_portal = $objGeneral->getcurrentCountryPortal($current_country_id);
                                                           //    if (in_array($vShip['pkShippingGatewaysID'], $wholesaler_details['shippingDetails'])) {

                                                           if ($vShip['logisticgatwaytype'] == 'admin') {
                                                               ?>
                                                                        <!--<a class="QuickViewMethods" onclick="jscallCustomeMethods('QuickViewMethods');" href="<?php //echo $objCore->getUrl('methods_quickview.php', array('sgid' => $vShip['pkShippingGatewaysID'], 'action' => 'methodsQuickView'));    ?>" style="text-decoration: none;margin-left:0px;">-->
                                                        <a class="QuickViewZoneCountry" onclick="testavi(<?php echo $vShip['logisticportalid']; ?>,<?php echo $_SESSION['sessUserInfo']['countryid']; ?>);" href="#QuickViewZoneCountry" style="text-decoration: none;margin-left:0px;">
                                                            <input type="hidden" name="logisticportalid" id="logisticportalid" value="<?php echo $vShip['logisticportalid']; ?>"
                                                                   <span style="color: #56A0F2"><?php echo $vShip['logisticTitle'] . "<br/>"; ?></span>
                                                        </a>
                                                        <?php
                                                    } else {
                                                        echo $vShip['logisticTitle'] . "<br/>";
                                                    }
//                                                            } else {
//                                                                echo $vShip['ShippingTitle'] . "<br/>";
//                                                            }
                                                    ?>

                                                <?php } ?>
                                                <br/>
                                                <!--                                                <a class="QuickViewZoneCountry" onclick="jscallZoneCountry('QuickViewZoneCountry');" href="#QuickViewZoneCountry" style="color: #56A0F2;text-decoration: none;margin-left: 0px;">View Zone country list</a>-->
                                            </li>
                                        </ul>
                                </div>
                                <div class="address_sec address_sec2">
                                    <h3><?php echo CON_PERSON; ?></h3>
                                    <hr class="style-one">
                                        <ul class="font_style">
                                            <li><label><?php echo NAME; ?> </label><strong>  : </strong><p><?php echo $wholesaler_details['ContactPersonName'] ?></p></li>
                                            <li><label><?php echo POS; ?> </label> <strong>  : </strong><p><?php echo $wholesaler_details['ContactPersonPosition'] ?> </p></li>

                                            <li><label><?php echo PHONE; ?></label> <strong>  : </strong><p><?php echo $wholesaler_details['ContactPersonPhone'] ?> </p></li>
                                            <li><label><?php echo EMAIL; ?></label> <strong>  : </strong><a href="mailto:<?php echo $wholesaler_details['ContactPersonEmail'] ?>"><?php echo $wholesaler_details['ContactPersonEmail'] ?></a></li>
                                            <li><label><?php echo POS_ADD; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['ContactPersonAddress'] ?> </p></li>

                                        </ul>
                                </div>

                            </div>
                            <div class="company_sec">
                                <div class="address_sec">
                                    <h3><?php echo COM_ADD; ?></h3>
                                    <hr class="style-one">
                                        <ul class="font_style">
                                            <li><label><?php echo ADD1; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['CompanyAddress1'] ?></p></li>
                                            <li><label><?php echo ADD2; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['CompanyAddress2'] ?> </p></li>
                                            <li><label>Country</label> <strong>  : </strong><p><?php
                                            
                                                    $country = $objGeneral->getCountry();
                                                    foreach ($country as $k => $vCT) {
                                                        if ($vCT['country_id'] == $wholesaler_details['CompanyCountry']) {
                                                            echo $vCT['name'];
                                                        }
                                                    }
                                                   // echo $wholesaler_details['CompanyCountry']
                                                    ?></p></li>
                                            <li><label>State</label> <strong>  : </strong><p><?php
                                                    $statearraybycountryid = $objGeneral->statelistbycountryid($wholesaler_details['CompanyCountry']);
                                                    foreach ($statearraybycountryid as $k => $vCT) {
                                                        if ($vCT['id'] == $wholesaler_details['CompanyState']) {
                                                            echo $vCT['name'];
                                                        }
                                                    }
                                                   // echo $wholesaler_details['CompanyState']
                                                    ?></p></li>
                                            <li><label><?php echo CITY; ?></label> <strong>  : </strong><p><?php 
                                           $cityarraybystateid = $objGeneral->countrylistbynewstateid($wholesaler_details['CompanyState']);
                                                    foreach ($cityarraybystateid as $k => $vCT) {
                                                        if ($vCT['id'] == $wholesaler_details['CompanyCity']) {
                                                            echo $vCT['name'];
                                                        }
                                                    }
                                            //echo $wholesaler_details['CompanyCity'] 
                                                    ?></p></li>
                                            <li><label><?php echo POS_CODE; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['CompanyPostalCode'] ?> </p></li>
                                            <li><label><?php echo WB; ?></label><strong>  : </strong><a href="<?php echo $wholesaler_details['CompanyWebsite'] ?>" target="_blank"><?php echo $wholesaler_details['CompanyWebsite'] ?></a></li>
                                            <li><label><?php echo PAY_EMAIL; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['PaypalEmail'] ?></p></li>
                                            <li><label><?php echo PHONE; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['CompanyPhone'] ?> </p></li>
                                            <li><label><?php echo FEX; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['CompanyFax'] ?> </p></li>
                                        </ul>
                                </div>
                                <div class="address_sec address_sec2 address_sec3 dir">
                                    <h3><?php echo OWNER_INFOR; ?></h3>
                                    <hr class="style-one">
                                        <ul class="font_style">
                                            <li><label><?php echo NAME; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['OwnerName'] ?> </p></li>
                                            <li><label><?php echo PHONE; ?> </label><strong>  : </strong><p><?php echo $wholesaler_details['OwnerPhone'] ?> </p></li>
                                            <li><label><?php echo EMAIL; ?></label><strong>  : </strong><a href="mailto:<?php echo $wholesaler_details['OwnerEmail'] ?>"><?php echo $wholesaler_details['OwnerEmail'] ?></a></li>
                                            <li><label><?php echo POS_ADD; ?> </label><strong>  : </strong><p><?php echo $wholesaler_details['OwnerAddress'] ?></p></li>

                                        </ul>
                                </div>
                            </div>
                            <div class="company_sec">                               
                                <div class="address_sec address_sec4 address_sec5 ">
                                    <h3><?php echo TRADE_REF; ?></h3>
                                    <hr class="style-one">
                                        <h4><?php echo REF_1; ?></h4>
                                        <ul class="font_style">
                                            <li><label><?php echo NAME; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['Ref1Name'] ?> </p></li>
                                            <li><label><?php echo PHONE; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['Ref1Phone'] ?> </p></li>
                                            <li><label><?php echo EMAIL; ?></label><strong>  : </strong><a href="mailto:<?php echo $wholesaler_details['Ref1Email'] ?>"><?php echo $wholesaler_details['Ref1Email'] ?></a></li>
                                            <li><label><?php echo COM_NAME; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['Ref1CompanyName'] ?></p></li>
                                            <li><label><?php echo COM_ADD; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['Ref1CompanyAddress'] ?></p></li>

                                        </ul>
                                </div>
                                <div class="address_sec address_sec2 address_sec4 trade ">
                                    <h3><?php echo TRADE_REF; ?></h3>
                                    <hr class="style-one">
                                        <h4><?php echo REF_2; ?></h4>
                                        <ul class="font_style">
                                            <li><label><?php echo NAME; ?> </label><strong>  : </strong><p><?php echo $wholesaler_details['Ref2Name'] ?></p></li>
                                            <li><label><?php echo PHONE; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['Ref2Phone'] ?> </p></li>
                                            <li><label><?php echo EMAIL; ?></label><strong>  : </strong><a href="mailto:<?php echo $wholesaler_details['Ref2Email'] ?>"><?php echo $wholesaler_details['Ref2Email'] ?></a></li>
                                            <li><label><?php echo COM_NAME; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['Ref2CompanyName'] ?></p></li>
                                            <li><label><?php echo COM_ADD; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['Ref2CompanyAddress'] ?></p></li>

                                        </ul>
                                </div>
                            </div>
                            <div class="company_sec company_sec2">

                                <div class="address_sec address_sec4 address_sec5">
                                    <h3><?php echo TRADE_REF; ?></h3>
                                    <hr class="style-one">
                                        <h4><?php echo REF_3; ?></h4>
                                        <ul class="font_style">
                                            <li><label><?php echo NAME; ?>  </label><strong>  : </strong><p><?php echo $wholesaler_details['Ref3Name'] ?></p></li>
                                            <li><label><?php echo PHONE; ?>  </label><strong>  : </strong><p><?php echo $wholesaler_details['Ref3Phone'] ?> </p></li>
                                            <li><label><?php echo EMAIL; ?>  </label><strong>  : </strong><a href="mailto:<?php echo $wholesaler_details['Ref3Email'] ?>"><?php echo $wholesaler_details['Ref3Email'] ?></a></li>
                                            <li><label><?php echo COM_NAME; ?> </label><strong>  : </strong><p><?php echo $wholesaler_details['Ref3CompanyName'] ?></p></li>
                                            <li><label><?php echo COM_ADD; ?></label><strong>  : </strong><p><?php echo $wholesaler_details['Ref3CompanyAddress'] ?></p></li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: none;"> 
            <div class="quick_color" id="QuickViewZoneCountry" style="height: 385px; overflow: auto">
                <table cellspacing="0" cellpadding="0" border="0" width="100%" class="chooseTable">
                    <tbody>
                        <tr class="content">
                            <td> <label for="textarea" class="content1"><span style="color:red;">*</span>Country Portal:</label></td>
                            <td>
                                <?php
                                $abc = $objGeneral->getCountryPortal();
//pre($_SESSION['sessUserInfo']['countryid']);
                                $current_country_id = $_SESSION['sessUserInfo']['countryid'];
                                $current_country_portal = $objGeneral->getcurrentCountryPortal($current_country_id);
//pre($current_country_portal);
                                foreach ($current_country_portal as $kk => $vv) {
                                    $SelectedCountry[$kk] = $vv['pkAdminID'];
                                }
//pre($SelectedCountry);
//$html_entity = "onchange='showShippingPortal(this.value, 0, " . '"frmShippingGatewayID"' . ", " . '"frmShippingMultiCountryID"' . " );' class='select2-me input-xlarge newdemo' style='width:auto' ";
//echo $objGeneral->CountryPortalHtml($abc, 'CountryPortalID', 'pkAdminID', $SelectedCountry = array(), 'Select Country Portal', 0, $html_entity, '1', '1');
                                ?>
                                <label><?php echo $current_country_portal[0]['AdminUserName'] ?> </label>
                            </td>
                        </tr>

                        <tr class="content">
                            <td> <label for="textarea" class="content1"><span style="color:red;">*</span>Please Select Shipping Method:</label></td>
                            <td>
                                <input type="hidden" name="UpdatedPortalID" id="showShippingPortal" />
                                <select name="frmShippingGatewayID" onchange="showdetailsofshippingprice(this.value, <?php echo $current_country_id; ?>, this);" logisticCmpId="" id="frmShippingGatewayID" class='select2-me input-large'>
                                    <option value="0">Select Shipping Geteway</option>
                                </select>
                            </td>
                        </tr>


                        <?php
//                         foreach ($objPage->arrZoneCountry as $val)
//                         {
//                             
                        ?>
<!--                             <tr class="content"> -->
                        <td colspan="12"><b><?php //echo 'Zone ' . $val['zone'];     ?></b></td>
                        <!--                             </tr> -->
                        <!--                             <tr class="content"> -->
                        <!--                                 <td colspan="12"> -->
                        <!--<div class="zonelist">--><?php //echo str_replace(',', '</div><div class="zonelist">', $val['Countries']);     ?><!--</div>-->
                        <!--                                 </td> -->
                        <!--                             </tr> -->
                        <!--                             <tr class="content"> -->
                        <!--                                 <td colspan="12">&nbsp;</td> -->
                        <!--                             </tr> -->
                        <?php //}  ?>
                    </tbody>
                </table>
                <p class="Allpricedata"></p>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>