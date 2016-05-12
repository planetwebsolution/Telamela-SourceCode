<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_SPECIAL_FORM_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo SPECIAL_APPLICATION_FORM_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH ?>special_form.js"></script>
        <script type='text/javascript' src='<?php echo JS_PATH . "jquery.autocomplete.js"; ?>'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH . 'jquery.autocomplete.css'; ?>" />
        
        <!-- By Krishna Gupta starts to show datepicker-->
        <link type="text/css"  rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
			$(function() {
				//$('#fromDate0').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="common/images/calendar.gif" alt="Popup" class="trigger">',onSelect:calEqual,minDate: new Date()});
	            $('#fromDate0').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="common/images/calendar.gif",onSelect:calEqual,minDate: new Date()});
	
	            //$('#toDate0').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="common/images/calendar.gif" alt="Popup" class="trigger">', onSelect:calDateCompare,minDate: new Date()});
	            $('#toDate0').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="common/images/calendar.gif", onSelect:calDateCompare,minDate: new Date()});
			});

			function calEqual(stDt,enDt) {
				$('#toDate0').val($('#fromDate0').val());
			}
			function calDateCompare(SelectedDates) {
				var d = new Date(SelectedDates);
				var d_formatted = d.getDate() + '-' + d.getMonth() +'-' + d.getFullYear();
                var sdate = d_formatted.split("-");

                var StartDate = $('#fromDate0').val();
                var CurrDate  = StartDate.split("-");
                /*********************** From Date *****************/
                var CY = parseInt(CurrDate[2]);  //Year
                var CM = parseInt(CurrDate[1]);  //Month
                var CD = parseInt(CurrDate[0]);  //Date
                /******************* To Date *********************/

                var sY=parseInt(sdate[2]);  //Year
                var sM=parseInt(sdate[1])+1;  //Month
                var sD=parseInt(sdate[0]);  //Date

                var ctr=0;

                if(sY<CY){
                	ctr=1;
				}else if(sY==CY && sM<CM){
                	ctr=1;
				}else if(sY==CY && sM==CM && sD<CD){
                	ctr=1;
				}
                if(ctr==1){
                	$('#toDate0').val(StartDate);
                    alert('End Date should be less than or equal to Start Date');
				}
			}
		</script>
        <!-- By Krishna Gupta ends -->
          
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>           
        <script src="<?php echo JS_PATH ?>select2.min.js"></script>
        <style>
            .input_sec{ float:left }.spcial_app_frm{margin-top:20px;}
            .input_sec span{padding:0px;}/* .datepick-trigger{margin: 31px 0 0 -19px; position: relative;} */ .dashboard_title{background:#60494A; color: rgb(255, 255, 255); padding: 0px 9px; border-radius: 4px 4px 4px 4px; margin: 0px 0px 9px; width: 114%;}
            .add_edit_pakage label{ width:140px;}
            #cboxLoadedContent{margin-top:-2px !important;} .imgimg{ float: left;}.input_sec .select2-choice span{padding: 3px;}
            .input_star .star_icon{ right:1px;} .stylish-select .drop4 .newListSelected{width:422px !important;}

            .stylish-select .drop4 .selectedTxt {    background: url("common/images/select2.png") no-repeat scroll 110% 7px #fff;    width: 381px;}
            .select2-container .select2-choice span{ background: url("common/images/select2.png") no-repeat scroll 110% 3px #fff;width: 412px;}
            .cat{float:left;}
            .stylish-select .drop4 .newListSelected{ height:38px}
            .special_remove_event {
                border: 0 solid red; float: right;
                margin-right: 0px;text-align: left;width: 550px;            }
            .stylish-select .drop4 .selectedTxt{ height:31px}

            .delete_icon3 {
                background:url(common/images/cross-hover.png) no-repeat 0 0;
                float: left;
                height: 41px;
                margin: 6px -41px 6px 1px;
                width: 38px;

            }
            .delete_icon3:hover{ background:url(common/images/cross-hover.png) no-repeat 0 0;
            }
            .mandatory {color: red;}
#liId0 .frmrow{border: 0px solid #ff0000; float: left; width:100%;}
#cat .drop14 .dropdown_12, #cat .select2-me{width:429px;}
#pricpakage ul{}
#pricpakage ul li{border-left: 1px solid #ccc; border-right:1px solid #ccc;
    border-top: 1px solid #ccc;
    box-sizing: border-box;
    clear: both;
    display: block;
    float: left;
    /*padding: 5px 0 10px 10px;*/
    width: 100%;}
#pricpakage ul li label{background-color: #eee; border-right:1px solid #ccc;
    color: #222;
    margin: 0 10px 0 0;
    padding: 14px;}	
#pricpakage ul li.create_cancle_btn{margin-top:0px !important;border-left:none !important;border-right:none !important;}	
#pricpakage ul li .cancel,#pricpakage ul li .submit3{margin-top:14px !important;}
#pricpakage ul li:first-child {background-color: #eee; font:700 14px/18px "Open Sans",sans-serif;}

@media screen and (max-width: 980px){
.stylish-select .drop4 .newListSelected{width: 100% !important;}
#aplication_special .drop14,   #aplication_special .dropdown_12,  .select2-container .select2-container-active{width: 100% !important;}
#cat .drop14 .dropdown_12, #cat .select2-me{width:100%;}
.frmrow .input_sec, #aplication_special .input_sec{width: 100%; clear: both;}
.rightfixeddiv1{width: 100%; white-space: nowrap;}
.input_sec .app_txt{max-width: 100%;}
.add_edit_pakage .create_cancle_btn{float: right;}
.add_edit_pakage label{width:auto;}
}

        </style>
        <script src="<?php echo JS_PATH ?>jquery.dd.js"></script>
                   
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"> </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%;height:50px; padding-top:16px;border-bottom:1px solid #e7e7e7;" class="wholesalerHeaderSection"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">
                <div class="add_pakage_outer">
                    <div class="top_container">
                        <div class="top_header border_bottom"><h1><?php echo SPECIAL; ?> <?php echo APPLICATION; ?></h1></div>
                    </div>

                    <?php $product = $objPage->productDetail[0]; ?>
                    <div class="body_inner_bg">
                        <?php
                        //pre($_POST['frmCountry'][0]);
                        if (isset($_POST['submit'])) {
                            $varGrandTotal = 0;
                            $specialQty = 0;
                            $catQty = 0;
                            $proQty = 0;
                            $varStr = '';
                            foreach ($_POST['frmInd'] as $key => $val) {
                                $specialQty++;

                                $varStr .= '<input type="hidden" name="frmCountry[' . $key . ']" value="' . $_POST['frmCountry'][$key] . '"/>';
                                $varStr .= '<input type="hidden" name="frmEvent[' . $key . ']" value="' . $_POST['frmEvent'][$key] . '" />';

                                foreach ($_POST['frmCategory_' . $val] as $k => $v) {
                                    $catQty++;
                                    $proQty += (int) $_POST['frmProduct_' . $val][$k];

                                    $varStr .= '<input type="hidden" name="frmCategory[' . $key . '][' . $k . ']" value="' . $v . '"/>';
                                    $varStr .= '<input type="hidden" name="frmProductQty[' . $key . '][' . $k . ']" value="' . $_POST['frmProduct_' . $key][$k] . '"/>';
                                }
                            }
                            ?>
                            <form action="paypal_special_form_process.php" method="post" class="form_section" enctype="multipart/form-data">
                                <div id="pricpakage" class="add_edit_pakage">
                                   
                                    <ul class="left_sec">
                                        <li>
                                            <label><b><?php echo 'Payment Section'; ?></b></label>
                                            <div class="input_sec" style="padding-top: 12px; padding-right:10px; float:right;">1 US$=<?php echo $_SESSION['SiteCurrencySign'] .' '.$_SESSION['SiteCurrencyPrice']*1?></div>
                                        </li>
                                        <li>
                                            <label><?php echo 'Events'; ?><strong>:</strong></label>
                                            <div class="input_sec" style="padding-top: 12px;">
                                    <?php
                                    $subTotal = $objPage->arrSetting['SpecialApplicationPrice']['SettingValue'] * $specialQty;
                                    $varGrandTotal += $subTotal;
                                    echo 'US$ ' . $objPage->arrSetting['SpecialApplicationPrice']['SettingValue'] . ' x ' . $specialQty . ' = ' . $objCore->getPrice($subTotal, 2);
                                    ?>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo 'Categories'; ?><strong>:</strong></label>
                                            <div class="input_sec" style="padding-top: 12px;">
                                    <?php
                                    $subTotal = $objPage->arrSetting['SpecialApplicationCategoryPrice']['SettingValue'] * $catQty;
                                    $varGrandTotal += $subTotal;
                                    echo 'US$ '. $objPage->arrSetting['SpecialApplicationCategoryPrice']['SettingValue'] . ' x ' . $catQty . ' = ' . $objCore->getPrice($subTotal, 2);
                                    ?>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo 'Products'; ?><strong>:</strong></label>
                                            <div class="input_sec" style="padding-top: 12px;">
                                    <?php
                                    $subTotal = $objPage->arrSetting['SpecialApplicationProductPrice']['SettingValue'] * $proQty;
                                    $varGrandTotal += $subTotal;
                                    echo 'US$ ' . $objPage->arrSetting['SpecialApplicationProductPrice']['SettingValue'] . ' x ' . $proQty . ' = ' . $objCore->getPrice($subTotal);
                                    ?>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo 'Total'; ?><strong>:</strong></label>
                                            <div class="input_sec" style="padding-top: 12px;">
                                    <?php
                                    echo $objCore->getPrice($varGrandTotal);
                                    ?>
                                            </div>
                                        </li>
                                        <li class="create_cancle_btn">
                                            <label style="visibility: hidden">.</label>
                                    <?php echo $varStr; ?>
                                            <input type="hidden" name="action" value="finalSubmit" />
                                            <input type="submit" name="frmButtonPaypal" value="<?php echo PAYMENT_PAYNOW_BUTTON ?>" class="submit3" style="width: 140px; margin-top:20px;" />
                                            <!--<a href="<?php echo $objCore->getUrl('manage_special_application.php'); ?>">-->
                                            <input onclick="window.location.href='<?php echo $objCore->getUrl('manage_special_application.php'); ?>'" type="button" value="Cancel" class="cancel" style="margin-top:20px;"/>
                                            <!--</a>-->
                                        </li>
                                    </ul>
                                   
                                    <div class="right_sec" style=" width:208px;">
<!--                                        <a href="<?php echo $objCore->getUrl('bulk_uploads.php'); ?>" class="update submit3"><?php echo UP_PRODUCTS; ?></a>-->
                                        <div class="clear_gap" style=""></div>
<!--                                        <a href="<?php echo $objCore->getUrl('add_multi_product.php', array('action' => 'addMutiple')); ?>" class="add_m_product update"><?php echo ADD_MULTI_PRODUCT; ?></a>-->
                                    </div>
                                   
                                </div>
                            </form>
                        <?php } else { ?>

                            <form name="add_edit_product" id="add_edit_product" onsubmit="return ValidateEventForm();" action="" method="POST" enctype="multipart/form-data">
                                <div class="add_edit_pakage spcial_app_frm">
                                    <!--<div class="back_ankar_sec"><a href="<?php echo $objCore->getUrl('manage_products.php'); ?>" class="back"><span><?php echo BACK; ?></span></a></div>-->

                                    <ul id="aplication_special"><!--class="left_sec"-->

                                        <li>
                                            <label><?php echo WHOLESALER; ?><strong>:</strong></label>
                                            <div class="input_sec">
                                                <input class=" app_txt" type="text" value="<?php echo $objPage->arrWholesalerDetails['CompanyName']; ?>" readonly />
                                            </div>
                                        </li>
                                        <li>&nbsp;</li>
                                        <li style="border: 0px solid #7FBC3C;" id="liId0">
                                            <input type="hidden" name="frmInd[]" value="0" />
                                            <div class="frmrow">
                                                <label><?php echo COUNTRY; ?><strong>:</strong></label>

                                                <div class="input_sec input_star">
                                                    <div class="drop4 dropdown_2" id="country0">
                                                        <div class="errors" style="display: block;"></div>
                                                        <select name="frmCountry[]" class="select2-me" id="countrySelect0" onchange="showEvent(this.value, '0');">
                                                            <option value="0"><?php echo SEL_CON; ?></option>
                                                            <?php
                                                            foreach ($objPage->arrCountryList as $key => $val) {
                                                                echo '<option value="' . $val['country_id'] . '">' . $val['name'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                </div>
                                                
                                                
                                            </div>
                                            <br/><br/><br/>
                                            <div class="frmrow">
                                                <label><?php echo SPECIAL_EVENT; ?><strong>:</strong></label>
                                                <div class="input_sec input_star">
                                                    <div class="drop4 dropdown_2" id="event0">
                                                        <div class="errors" style="display: block;"></div>
                                                        <select name="frmEvent[]" id="frmEvent0" class="drop_down1" onchange="showDates(this.value, '0');">
                                                            <option value="0"><?php echo SEL_EVENT_FRM; ?></option>
                                                        </select>
                                                    </div>
                                                    <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                </div>
                                            </div>
                                            <br/><br/><br/>
                                             <div class="frmrow">
                                                <label><?php echo SPECIAL_DATE; ?><strong>:</strong></label>
                                                <div class="input_sec">
                                                    <span style="float: left;margin: 10px 2px 0 0;">From</span>
                                                    <input style="width: 113px; float: left;" type="text" name="fromDate[]" id="fromDate0" readonly value="" />
                                                    <span style="float: left;margin: 10px 2px 0 0px;padding:0px 10px 0px 10px">To</span>
                                                    <input style="width: 113px; float: left;" type="text" name="toDate[]" id="toDate0" readonly value="" />
                                                </div>
                                            </div>
                                            <br/><br/><br/>                                            
                                            <div class="cat">
                                                <ul>
                                                </ul>
                                                <a class="more more_cat" href="#" row="0" style="width:210px"><small>Add more category</small> +</a>
                                            </div>

                                        </li>
                                        <li>
                                            <div class="rightfixeddiv1">
                                                <a class="more more_fest more more_cat" href="#" row="1" style="width:150px"><small>Add more event</small> +</a>
                                            </div>
                                        </li>
                                        <li class="create_cancle_btn">
                                            <input type="hidden" name="action" value="submit" />
                                            <label style="visibility: hidden">.</label>
                                            <input type="submit" name="submit" value="Submit" class="submit3"/>
                                            <!--<a href="<?php echo $objCore->getUrl('manage_special_application.php'); ?>">-->
                                                <input onclick="window.location.href='<?php echo $objCore->getUrl('manage_special_application.php'); ?>'" type="button" value="Cancel" class="cancel"/>
                                            <!--</a>-->
                                        </li>
                                    </ul>
                                    <!--
                                    <div class="right_sec">
                                        <a href="<?php echo $objCore->getUrl('bulk_uploads.php'); ?>" class="update"><?php echo UP_PRODUCTS; ?></a>
                                        <div class="clear_gap" style=""></div>
                                        <a href="<?php echo $objCore->getUrl('add_multi_product.php', array('action' => 'addMutiple')); ?>" class="add_m_product update"><?php echo ADD_MULTI_PRODUCT; ?></a>
                                    </div>
                                    -->
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
        <div id="cat" style="display: none;">
            <div>
                <label><?php echo CATEGORY_TITLE; ?> <strong>:</strong></label>
                <div class="input_sec input_star">
                    <div class="drop14 dropdown_12">
                        <div class="errors" style="display: block;"></div>
                        <select name="frmCategory[]" class="select2-me">
                            <option value="0"><?php echo SEL_CAT; ?></option>
                        </select>
<!--                        <div class="errorsP" style="display: block;"></div>-->

                        <small class="star_icon special_qty" style=" right:0;"><img src="common/images/star_icon.png" alt=""/></small>
                    </div>
                    <div class="input_sec input_star" style="float:right;">
                        <div class="errorsP" style="display: block;"></div>
                        <input type="text"name="frmProduct[]" value="" id="inputhundred" style="width: 100px; margin-top: 8px; margin-bottom:20px; float: right;" />
                        <span style="float: right;margin: 14px;">Products</span>
                        <small class="star_icon" style=" right:0; top:8px;"><img src="common/images/star_icon.png" alt=""/></small>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>