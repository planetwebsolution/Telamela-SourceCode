<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_CTRL;
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';

$objUser = new AdminUser();
$arrPortal = $objUser->getPortal();
foreach ($arrPortal as $k => $v) {
    $PortalIDs[] = $v['AdminCountry'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo WHOL_TITLE; ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="common/css/browse.css"/>
        <script type="text/javascript" src="common/js/browse.js"></script>
        <script>
            jQuery(document).ready(function () {
                // binds form submission and fields to the validation engine
                jQuery("#frmWholesalerRegistration").validationEngine();
            });
        </script>
        <script type="text/javascript">
            var file_html_counter = 3;
            $(function () {
                $('#file1').customFileInput1();
                $('#file2').customFileInput1();
                $('#file3').customFileInput1();
                $('#file4').customFileInput1();
            });
            $(document).ready(function () {
                $('.drop_down1').sSelect();
                $('#frmCompany1Country').change(function () {
                    var cid = parseInt($(this).val());
                    if (cid > 0) {
                        $('.ErrorCompany1Country').css('display', 'none');
                    } else {
                        $('.ErrorCompany1Country').css('display', 'block');
                    }
                    $.ajax({
                        url: "common/ajax/ajax_wholesaler.php",
                        data: {action: 'getRegion', cid: cid},
                        type: 'post',
                        success: function (data) {
                            $('#region_drop').html(data);
                            $('#frmCompany1Region').sSelect();
                        }
                    });
                });
                /*
                 $('#frmCompany1Region').on('change',function(){
                 alert('test');
                 var value = $(this).val();
                 if(value!=0){
                 $('#region_help_link').css('display','block');
                 }
                 });
                 */
                $('.more').click(function (e) {
                    file_html_counter++;
                    file_html_counter1 = file_html_counter + 1;
                    var html = ' <li><label>Document ' + file_html_counter + ' <span>(Optional)</span></label><a href="#" class="delete_icon1"></a><input class="customfile1-input file"  id="file' + file_html_counter1 + '" type="file" name="fileBusinessDoc[]" style="top: -509px; left: 0px!important;"/></li>';
                    $('.left_files').append(html);

                    $('ul.left_files li:even').removeClass('toRight');
                    $('ul.left_files li:odd').addClass('toRight');

                    $('#file' + file_html_counter1).customFileInput1();
                    e.preventDefault();
                });
                
                $('#frmCompany1Country').on('change', function () {
                    var countryid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showCountryState', q: countryid, },
                    }).done(function (data) {
                        console.log(data);
                        $("#frmCompanyState").html(data);
                    });

                });

                $('#frmCompanyState').on('change', function () {
                    var stateid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showStateCity', q: stateid, },
                    }).done(function (data) {
                        $("#frmCompanyCity").html(data);
                    });

                });
                
            });
            $('.delete_icon1').live('click', function (e) {
                e.preventDefault();
                $(this).parent().remove();
                $('ul.left_files li:odd').addClass('toRight');
                $('ul.left_files li:even').removeClass('toRight');

            });
            function validateForm() {
                var contId = $('#frmCompany1Country').val();
                if (contId == '0') {
                    $('.ErrorCompany1Country').css('display', 'block');
                    return false;
                }
            }
        </script>
        <style>
     .customselect{
    background: #FFF;
    color: #3f3e3e;
    /* float: left; */
    height: 37px;
    moz-border-radius: 3px;
    padding: 0 25px 0 10px;
    width: 100%;border:1px solid #dcdcdc}
        </style>
    </head>
    <body>
        <?php //print_r($_POST);die; ?>
        <em>
            <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>
        </em>
        <div class="header">
        </div>
        <?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="">
            <div class="layout">
                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <?php
                        if ($objCore->
                                        displaySessMsg()) {
                            ?>
                            <div style="text-align:center; width: 1000px; color:red">
                                <?php
                                echo $objCore->
                                        displaySessMsg();
                                $objCore->setSuccessMsg('');
                                $objCore->setErrorMsg('');
                                ?>
                            </div>
                        <?php }
                        ?>
                        <h1><?php echo WHOLESALER; ?>
                            <?php echo APP_FORM; ?>
                        </h1>
                    </div>
                    <div class="body_inner_bg radius" id="wholesaler_form">
                        <small class="req_field" style="padding-left:11px">* <?php echo FILED_REQUIRED; ?>
                        </small>
                        <div class="add_edit_pakage aapplication_form">
                            <form onsubmit="return validateForm();" enctype="multipart/form-data" name="frmWholesalerRegistration" id="frmWholesalerRegistration" method="post" action="">
                                <ul class="left_sec myFullWidth">
                                    <li>
                                        <label><?php echo COM_NAME; ?>
                                        </label>
                                        <div class="input_star">
                                            <input type="text" tabindex="1" name="frmCompanyName" id="frmCompanyName" value="<?php echo @$_POST['frmCompanyName'] ?>" class="validate[required] text-input" maxlength="256" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                        </div>
                                    </li>
                                    <li class="toRight">
                                        <label><?php echo BUS_PLAN; ?>
                                            <span><?php echo OPTION_BROW; ?>
                                            </span></label>
                                        <input tabindex="2" class="customfile1-input file" id="file1" type="file" name="fileBusinessPlan" style="top: -509px; left: 0px!important;"/>
                                    </li>
                                    <li>
                                        <label><?php echo ABT_COM; ?>
                                            <span><?php echo MIN_200; ?>
                                            </span></label>
                                        <div class="input_star">
                                            <textarea tabindex="3" name="frmAboutCompany" id="frmAboutCompany" cols="5" rows="5" class="validate[required,minSizeWord[200]]"><?php echo @$_POST['frmAboutCompany'] ?></textarea>
                                            <small class="star_icon" style="right: 0px;margin-top: 0px;"><img src="common/images/star_icon.png" alt=""/></small>
                                        </div>
                                    </li>
                                    <li class="toRight">
                                        <label><?php echo SERV; ?>
                                        </label>
                                        <textarea name="frmServices" id="frmServices" tabindex="4" cols="5" rows="5"><?php echo @$_POST['frmServices'] ?>
                                        </textarea>
                                    </li>
                                </ul>

                                <div class="com_address_sec">
                                    <h3 class="regHeading">
                                        <?php echo COM_ADD; ?>
                                    </h3>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo ADD_1_ADDRESS; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="5" name="frmCompany1Address1" id="frmCompany1Address1" value="<?php echo @$_POST['frmCompany1Address1'] ?>" class="validate[required] text-input" maxlength="256" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo ADD_2_ADDRESS; ?>
                                            </label>
                                            <input type="text" tabindex="6" class=" text-input" name="frmCompany1Address2" id="frmCompany1Address2" value="<?php echo @$_POST['frmCompany1Address2'] ?>" maxlength="256" />
                                        </li>
                                        <li>
                                            <label><?php echo COUNTRY; ?>
                                            </label>
                                            <div class="input_star">
                                                <div class="drop4 dropdown_2">
                                                    <div style="opacity: 0.87; position: absolute; top: 180px; display: none; margin-top: -213px; left:455px;" class="ErrorCompany1Country formError">
                                                        <div class="formErrorContent">
                                                            * <?php echo COUNTRY_REQ_MSG; ?>
                                                            <br>
                                                        </div>
                                                        <div class="formErrorArrow">
                                                            <div class="line10">
                                                                <!-- -->
                                                            </div>
                                                            <div class="line9">
                                                                <!-- -->
                                                            </div>
                                                            <div class="line8">
                                                                <!-- -->
                                                            </div>
                                                            <div class="line7">
                                                                <!-- -->
                                                            </div>
                                                            <div class="line6">
                                                                <!-- -->
                                                            </div>
                                                            <div class="line5">
                                                                <!-- -->
                                                            </div>
                                                            <div class="line4">
                                                                <!-- -->
                                                            </div>
                                                            <div class="line3">
                                                                <!-- -->
                                                            </div>
                                                            <div class="line2">
                                                                <!-- -->
                                                            </div>
                                                            <div class="line1">
                                                                <!-- -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <select name="frmCompany1Country" id="frmCompany1Country" class="drop_down1" tabindex="8">
                                                        <option value="0" ><?php echo SEL_CON; ?></option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $var) {
                                                            if (in_array($var['country_id'], $PortalIDs)) {
                                                                $selected = '';
                                                                if (isset($_POST['frmCompany1Country']) && ( $_POST['frmCompany1Country'] == $var['country_id'])) {
                                                                    $selected = 'selected';
                                                                }
                                                                $selectedC = ($var['country_id'] == $_POST['frmCompany1Country']) ? 'selected' : '';
                                                                echo '<option ' . $selected . '  value="' . $var['country_id'] . '" ' . $selectedc . '>' . $var['name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <small class="star_icon" style="right:0px;margin-top: 1px;"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo CITY; ?>
                                            </label>
                                            <div class="input_star">
                                                <select name="CompanyCity" id="frmCompanyCity" class='select2-me input-large resCheck customselect'>
                                                                                    <option value="0">Select City</option>

                                                                                </select>
<!--                                                <input type="text" tabindex="7" name="frmCompany1City" id="frmCompany1City" value="" class="validate[required] text-input" maxlength="50" /> <<small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>-->
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo POS_CODE; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="9" name="frmCompany1PostalCode" id="frmCompany1PostalCode" value="<?php echo @$_POST['frmCompany1PostalCode'] ?>" maxlength="8" class="validate[required,minSize[4],maxSize[8]] text-input"/> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label>State</label>
                                             <select name="CompanyState" id="frmCompanyState" onchange ="showstate()"class='select2-me input-large resCheck customselect'>
                                                                                    <option value="0">Select State</option>

                                                                                </select> 
<!--                                            <div class="drop4" id="region_drop">
                                                <select name="frmCompany1Region" id="frmCompany1Region" class="drop_down1" tabindex="10">
                                                    <option value="0"><?php echo SEL_REG; ?>
                                                    </option>
                                                </select>
                                                <a href="javascript:void(0);" class="region_help_link" id="region_help_link"><?php echo HELP; ?>
                                                </a>
                                            </div>-->
                                        </li>
                                        
                                        <li class="toRight">
                                            <label><?php echo WB; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="12" name="frmCompany1Website" id="frmCompany1Website" value="<?php echo @$_POST['frmCompany1Website'] ?>" class="validate[required,custom[url]] text-input" maxlength="256" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>

                                        <li>
                                            <label><?php echo LOG_EMAIL; ?>
                                            </label>
                                            <div class="red" id="customerEmailExistsErrorMsg" style="display:none;">
                                                <?php echo FRONT_USER_EMAIL_ALREADY_EXIST; ?>
                                            </div>
                                            <div class="input_star">
                                                <input type="text" tabindex="11" name="frmCompany1Email" id="frmCompany1Email" value="<?php echo @$_POST['frmCompany1Email'] ?>" class="validate[required,custom[email]] text-input"/> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <div class="clear"></div>
                                        <li>
                                            <label><?php echo PASSWORD; ?>:</label>
                                            <div class="input_star">
                                                <input type="password" tabindex="13" name="frmPassword" id="frmPassword" value="" class="validate[required,minSize[6]] text-input" maxlength="50"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo CONFIRM_PASSWORD; ?>
                                                :</label>
                                            <div class="input_star">
                                                <input type="password" tabindex="14" name="frmConfirmPassword" id="frmConfirmPassword" value="" class="validate[required,equals[frmPassword]] text-input" maxlength="50"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PHONE; ?>
                                            </label>
                                            <div class="input_star">
                                                <input tabindex="15" type="text" value="<?php echo @$_POST['frmCompany1Phone'] ?>" name="frmCompany1Phone" id="frmCompany1Phone" class="validate[required,custom[phone]] text-input" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo FEX; ?>
                                            </label>
                                            <input type="text" tabindex="16" name="frmCompany1Fax" id="frmCompany1Fax" value="<?php echo @$_POST['frmCompany1Fax'] ?>" class="validate[custom[integer]] text-input" maxlength="50" /> </li>

                                        <li>
                                            <label><?php echo PAY_EMAIL; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="17" name="frmPaypalEmail" id="frmPaypalEmail" value="<?php echo @$_POST['frmPaypalEmail'] ?>" class="validate[required,custom[email]] text-input"/> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>

                                    <h3 class="regHeading">Company Address2 <span> (Optional)</span></h3>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo ADD_1_ADDRESS; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="19" name="frmCompany2Address1" id="frmCompany2Address1" value="<?php echo @$_POST['frmCompany2Address1'] ?>" class="text-input" maxlength="256" />
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo ADD_2_ADDRESS; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="20" name="frmCompany2Address2" id="frmCompany2Address2" value="<?php echo @$_POST['frmCompany2Address2'] ?>" class="text-input" maxlength="256" />
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo CITY; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="21" name="frmCompany2City" id="frmCompany2City" value="<?php echo @$_POST['frmCompany2City'] ?>" class="text-input" maxlength="50" />
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo COUNTRY; ?>
                                            </label>
                                            <div class="drop4 dropdown_2">
                                                <select name="frmCompany2Country" id="frmCompany2Country" tabindex="22" class="drop_down1">
                                                    <option value="0"><?php echo SEL_CON; ?>
                                                    </option>
                                                    <?php
                                                    foreach ($objPage->arrCountryList as $var) {
                                                        if (in_array($var['country_id'], $PortalIDs)) {
                                                            $selected = '';
                                                            if (isset($_POST['frmCompany2Country']) && ( $_POST['frmCompany2Country'] == $var['country_id'])) {
                                                                $selected = 'selected';
                                                            }
                                                            echo '<option ' . $selected . ' value="' . $var['country_id'] . '">' . $var['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PHONE; ?>
                                            </label>
                                            <div class="input_star">
                                                <input tabindex="23" type="text" value="<?php echo @$_POST['frmCompany2Phone'] ?>" name="frmCompany2Phone" id="frmCompany2Phone" class="validate[custom[phone]] text-input" />
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo WB; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="24" name="frmCompany2Website" id="frmCompany2Website" value="<?php echo @$_POST['frmCompany2Website'] ?>" class="validate[custom[url]] text-input" maxlength="256" />
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo EMAIL; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="25" name="frmCompany2Email" id="frmCompany2Email" value="<?php echo @$_POST['frmCompany2Email'] ?>" class="validate[custom[email]] text-input"/>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo POS_CODE; ?></label>
                                            <div class="input_star">
                                                <input type="text" tabindex="26" name="frmCompany2PostalCode" id="frmCompany2PostalCode" value="<?php echo @$_POST['frmCompany2PostalCode'] ?>" maxlength="8" class="validate[minSize[4],maxSize[8]] text-input"/>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo FEX; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="27" name="frmCompany2Fax" id="frmCompany2Fax" value="<?php echo @$_POST['frmCompany2Fax'] ?>" class="validate[custom[integer]] text-input" maxlength="50" />
                                            </div>
                                        </li>
                                    </ul>

                                    <h3 class="regHeading"><?php echo COM_ADD3; ?>
                                        <span><?php echo OP; ?></span>
                                    </h3>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo ADD_1_ADDRESS; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="28" name="frmCompany3Address1" id="frmCompany3Address1" value="<?php echo @$_POST['frmCompany3Address1'] ?>" class="text-input" maxlength="256" />
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo ADD_2_ADDRESS; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="29" name="frmCompany3Address2" id="frmCompany3Address2" value="<?php echo @$_POST['frmCompany3Address2'] ?>" class="text-input" maxlength="256" />
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo CITY; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="30" name="frmCompany3City" id="frmCompany3City" value="<?php echo @$_POST['frmCompany3City'] ?>" class="text-input" maxlength="50" />
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo COUNTRY; ?>
                                            </label>
                                            <div class="drop4 dropdown_2">
                                                <select name="frmCompany3Country" id="frmCompany3Country" tabindex="31" class="drop_down1">
                                                    <option value="0"><?php echo SEL_CON; ?>
                                                    </option>
                                                    <?php
                                                    foreach ($objPage->arrCountryList as $var) {
                                                        if (in_array($var['country_id'], $PortalIDs)) {
                                                            $selected = '';
                                                            if (isset($_POST['frmCompany3Country']) && ( $_POST['frmCompany3Country'] == $var['country_id'])) {
                                                                $selected = 'selected';
                                                            }
                                                            echo '<option ' . $selected . ' value="' . $var['country_id'] . '"> ' . $var['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo POS_CODE; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="32" name="frmCompany3PostalCode" id="frmCompany3PostalCode" value="<?php echo @$_POST['frmCompany3PostalCode'] ?>" maxlength="8" class="validate[minSize[4],maxSize[8]] text-input"/>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo WB; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="33" name="frmCompany3Website" id="frmCompany3Website" value="<?php echo @$_POST['frmCompany3Website'] ?>" class="validate[custom[url]] text-input" maxlength="256" />
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo EMAIL; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="34" name="frmCompany3Email" id="frmCompany3Email" value="<?php echo @$_POST['frmCompany3Email'] ?>" class="validate[custom[email]] text-input"/>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo PHONE; ?>
                                            </label>
                                            <div class="input_star">
                                                <input tabindex="35" type="text" value="<?php echo @$_POST['frmCompany3Phone'] ?>" name="frmCompany3Phone" id="frmCompany3Phone" class="validate[custom[phone]] text-input" />
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo FEX; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="36" name="frmCompany3Fax" id="frmCompany3Fax" value="<?php echo @$_POST['frmCompany3Fax'] ?>" class="validate[custom[integer]] text-input" maxlength="50" />
                                            </div>
                                        </li>
                                    </ul>

                                    <h3 class="regHeading"><?php echo CON_PERSON; ?>
                                    </h3>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo NAME; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="37" name="frmContactName" id="frmContactName" value="<?php echo @$_POST['frmContactName'] ?>" class="validate[required] text-input" maxlength="50" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo POS; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="38" name="frmContactPosition" id="frmContactPosition" value="<?php echo @$_POST['frmContactPosition'] ?>" class="validate[required] text-input" maxlength="50" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PHONE; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="39" name="frmContactPhone" id="frmContactPhone" value="<?php echo @$_POST['frmContactPhone'] ?>" class="validate[required,custom[phone]] text-input" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo EMAIL; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="40" name="frmContactEmail" id="frmContactEmail" value="<?php echo @$_POST['frmContactEmail'] ?>" class="validate[required,custom[email]] text-input"/> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo POS_ADD; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="41" name="frmContactAddress" id="frmContactAddress" value="<?php echo @$_POST['frmContactAddress'] ?>" class="validate[required] text-input" maxlength="256" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>

                                    <h3 class="regHeading"><?php echo OWNER_INFOR; ?></h3>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo NAME; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="42" name="frmOwnerName" id="frmOwnerName" value="<?php echo @$_POST['frmOwnerName'] ?>" class="validate[required] text-input" maxlength="50" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo PHONE; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="43" name="frmOwnerPhone" id="frmOwnerPhone" value="<?php echo @$_POST['frmOwnerPhone'] ?>" class="validate[required,custom[phone]] text-input" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo EMAIL; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="44" name="frmOwnerEmail" id="frmOwnerEmail" value="<?php echo @$_POST['frmOwnerEmail'] ?>" class="validate[required,custom[email]] text-input"/> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo POS_ADD; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="45" name="frmOwnerAddress" id="frmOwnerAddress" value="<?php echo @$_POST['frmOwnerAddress'] ?>" class="validate[required] text-input" maxlength="256" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>
                                    <h3 class="regHeading"><?php echo TRADE_REF; ?>
                                        <span><?php echo REF_MUST; ?>
                                        </span></h3>
                                    <h4><i class="fa fa-chevron-right"></i><?php echo REF_1; ?></h4>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo NAME; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="46" name="frmRefrence1Name" id="frmRefrence1Name" value="<?php echo @$_POST['frmRefrence1Name'] ?>" class="validate[required] text-input" maxlength="50" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li  class="toRight">
                                            <label><?php echo PHONE; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="47" name="frmRefrence1Phone" id="frmRefrence1Phone" value="<?php echo @$_POST['frmRefrence1Phone'] ?>" class="validate[required,custom[phone]] text-input" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>

                                        <li>
                                            <label><?php echo EMAIL; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="48" name="frmRefrence1Email" id="frmRefrence1Email" value="<?php echo @$_POST['frmRefrence1Email'] ?>" class="validate[required,custom[email]] text-input"/> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li  class="toRight">
                                            <label><?php echo COM_NAME; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="49" name="frmRefrence1CompanyName" id="frmRefrence1CompanyName" value="<?php echo @$_POST['frmRefrence1CompanyName'] ?>" class="validate[required] text-input" maxlength="100" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>

                                        <li>
                                            <label><?php echo COM_ADD; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="50" name="frmRefrence1Address" id="frmRefrence1Address" value="<?php echo @$_POST['frmRefrence1Address'] ?>" class="validate[required] text-input" maxlength="256" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>

                                    <h4><i class="fa fa-chevron-right"></i><?php echo REF_2; ?></h4>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo NAME; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="51" name="frmRefrence2Name" id="frmRefrence2Name" value="<?php echo @$_POST['frmRefrence2Name'] ?>" class="validate[required] text-input" maxlength="50" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li  class="toRight">
                                            <label><?php echo PHONE; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="52" name="frmRefrence2Phone" id="frmRefrence2Phone" value="<?php echo @$_POST['frmRefrence2Phone'] ?>" class="validate[required,custom[phone]] text-input" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo EMAIL; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="53" name="frmRefrence2Email" id="frmRefrence2Email" value="<?php echo @$_POST['frmRefrence2Email'] ?>" class="validate[required,custom[email]] text-input"/> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li  class="toRight">
                                            <label><?php echo COM_NAME; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="54" name="frmRefrence2CompanyName" id="frmRefrence2CompanyName" value="<?php echo @$_POST['frmRefrence2CompanyName'] ?>" class="validate[required] text-input" maxlength="100" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo COM_ADD; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="55" name="frmRefrence2Address" id="frmRefrence2Address" value="<?php echo @$_POST['frmRefrence2Address'] ?>" class="validate[required] text-input" maxlength="256" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>
                                    <h4><i class="fa fa-chevron-right"></i><?php echo REF_3; ?></h4>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo NAME; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="56" name="frmRefrence3Name" id="frmRefrence3Name" value="<?php echo @$_POST['frmRefrence3Name'] ?>" class="validate[required] text-input" maxlength="50" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo PHONE; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="57" name="frmRefrence3Phone" id="frmRefrence3Phone" value="<?php echo @$_POST['frmRefrence3Phone'] ?>" class="validate[required,custom[phone]] text-input" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo EMAIL; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="58" name="frmRefrence3Email" id="frmRefrence3Email" value="<?php echo @$_POST['frmRefrence3Email'] ?>" class="validate[required,custom[email]] text-input"/> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo COM_NAME; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="59" name="frmRefrence3CompanyName" id="frmRefrence3CompanyName" value="<?php echo @$_POST['frmRefrence3CompanyName'] ?>" class="validate[required] text-input" maxlength="100" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo COM_ADD; ?>
                                            </label>
                                            <div class="input_star">
                                                <input type="text" tabindex="60" name="frmRefrence3Address" id="frmRefrence3Address" value="<?php echo @$_POST['frmRefrence3Address'] ?>" class="validate[required] text-input" maxlength="256" /> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>
                                    <h3 class="regHeading"><?php echo BUS_DOC; ?>
                                        <span><?php echo OPTION_BROW_DOC; ?>
                                        </span><a href="#" class="more"><small><?php echo ADD_MORE; ?>
                                            </small> +</a></h3>
                                    <ul class="left_sec left_files myFullWidth">
                                        <li>
                                            <label><?php echo DOC_1; ?>
                                                <span><?php echo BUS_REGIS; ?>
                                                </span></label>
                                            <input class="customfile1-input file" id="file2" tabindex="60" type="file" name="fileBusinessDoc[]" style="top: -509px; left: 0px!important;"/>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo DOC_2; ?>
                                                <span><?php echo OP; ?>
                                                </span></label>
                                            <input class="customfile1-input file" tabindex="61" id="file4" type="file" name="fileBusinessDoc[]" style="top: -509px; left: 0px!important;"/>
                                        </li>
                                        <li>
                                            <label><?php echo DOC_3; ?>
                                                <span><?php echo OP; ?>
                                                </span></label>
                                            <input class="customfile1-input file" tabindex="62" id="file3" type="file" name="fileBusinessDoc[]" style="top: -509px; left: 0px!important;"/>
                                        </li>
                                    </ul>
                                    <ul class="left_sec right right_files">

                                    </ul>
                                </div>
                                <span class="btn registr_btn cstmRegister">
                                    <input class="watch_link" style="float:right; margin-bottom:10px;" type="submit" value="<?php echo submit; ?>"/> </span>
                                <input type="hidden" name="frmHiddenAdd" value="<?php echo ADD; ?>" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>