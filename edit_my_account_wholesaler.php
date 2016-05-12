<?php
require_once 'common/config/config.inc.php';

require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_ACNT_CTRL;
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';

$objUser = new AdminUser();
$arrPortal = $objUser->getPortal();

foreach ($arrPortal as $k => $v) {
    $PortalIDs[] = $v['AdminCountry'];
}

//pre($objPage->arrWholesalerDeatails);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo EDIT_WHOLESALER_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="common/css/browse.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>cropic2.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>croppic.css"/>
        <script type="text/javascript" src="common/js/browse.js"></script>
        <script  type="text/javascript" src="<?php echo JS_PATH ?>customer_feedback.js"></script>
        <script type="text/javascript" src="<?php echo CKEDITOR_URL; ?>ckeditor.js"></script>
        <script  type="text/javascript" src="<?php echo JS_PATH ?>jquery.checkradios.min.js"></script>
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>jquery.checkradios.min.css" type="text/css"/>
        <!-- CheckRadios Usage Examples -->
        <script>
            $(document).ready(function () {
                $('.checkradios').checkradios();

            });
        </script>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                // binds form submission and fields to the validation engine
                jQuery("#frmWholesalerUpdate").validationEngine();
                $('.drop_down1').sSelect();
//                $('.file').customFileInput1();
                $('.file1').customFileInput1();
//                $('.file2').customFileInput1();
                $('#frmCompany1Country').change(function () {
                    var cid = $(this).val();
                    $.ajax({
                        url: SITE_ROOT_URL + "common/ajax/ajax_wholesaler.php",
                        data: {action: 'getRegion', cid: cid},
                        type: 'post',
                        success: function (data) {
                            $('#region_drop').html(data);
                            $('#frmCompany1Region').sSelect();
                        }
                    });
                });

                //check whether the shipping exists to other products or not
                $('.checkradios').click(function (e) {
                    //e.preventDefault();
                    var cls = $(this).attr('class');
                    if (cls.toString().indexOf('unchecked') > -1) {
                        var c = confirm("Are you sure you want to remove this shipping gateway? Make sure if you remove this shipping gateway then it will be remove from all your associated products.");
                        if (c == false) {
                            $(this).attr('class', 'checkradios-checkbox checkradios icon-checkradios-checkmark checked');
                            $(this).children().attr('checked', true);
                        }
                        if (c == true) {
                            var removeShip = $(this).children().val();
                            $.ajax({
                                url: SITE_ROOT_URL + "common/ajax/ajax_wholesaler.php",
                                data: {action: 'removeShip', cid: removeShip},
                                type: 'post',
                                beforeSend: function () {
                                    $('#cboxOverlayId').show();
                                },
                                success: function (data) {
                                    $('#cboxOverlayId').hide();
                                }
                            });
                        }
                    }
                });
                //Add more functionality
                var image_counter = 3;
                var limit = 4;
                $('.more_images').click(function (e) {
                    if (image_counter > limit)
                    {
                        return false;
                    }
                    console.log(image_counter);
                    image_counter++;
                    // alert(image_counter);
                    var element2 = '<div class="new-slider"><a href="#cropimg_' + image_counter + '" onclick="jCroppicPopupOpen(\'cropimg\',\'' + image_counter + '\',\'croppicSlider\')" class="cropimg" style="z-index:9999999;float:left;clear:both;margin-top:10px;">Upload another slider image</a><div id="cropimg_' + image_counter + '" style="display:none;"></div><input type="hidden" name="fileSliderImage[]" id="sliderimage_' + image_counter + '" value=""/><div class="afterCropLogo_' + image_counter + '" style="float:left;"></div><a title="Remove" style="width:42px;" href="javascript:void(0)" class="delete_icon3"></a></div>';
                    $('.add-more').append(element2);
                    //$('#sliderimage'+image_counter).customFileInput1();
                    e.preventDefault();
                });
                $('.delete_icon3').live('click', function (e) {
                    image_counter = image_counter - 1;
                    $(this).parent().remove();
                    e.preventDefault();
                });
            });
            function deleteSliderImage(str) {
                if (str == '') {
                    $('#img' + str).html(INVALID_ACTION);
                } else {
                    $.post(SITE_ROOT_URL + "common/ajax/ajax_wholesaler.php", {
                        action: 'deleteWholesalerSliderImage',
                        ajax_request: 'valid',
                        id: str
                    }, function (data) {
                        $('#img' + str).html(data);

                        setTimeout(function () {
                            $('#img' + str).remove();
                        }, 3000);
                    });
                }
            }
            //Validate image field
            var url = window.URL || window.webkitURL;
            function checkImages(obj) {
                if (obj.id == 'logo')
                {
                    var hgt = '90';
                    var wth = '180';
                } else
                {
                    var hgt = '310';
                    var wth = '820';
                }


                if (obj.disabled) {
                    alert('Your browser does not support File upload.');
                } else {
                    var chosen = obj.files[0];
                    var image = new Image();
                    image.onload = function () {
                        if (this.height != hgt || this.width != wth) {
                            alert('Please upload image of (' + wth + ')px width and (' + hgt + ')px height!');
                            $('#' + obj.id).prev('span').html('')
                            $('#' + obj.id).val('');
                            obj.focus();
                        }

                    }
                    image.onerror = function () {
                        alert('Accepted Image formats are: jpg, jpeg, gif, png ');
                        $('#' + obj.id).prev('span').html('')
                        $('#' + obj.id).val('');
                        obj.focus();
                    };
                    image.src = url.createObjectURL(chosen);
                }
            }
        </script>
        <style>
            .divbox{height:33px;width: 50px; }
            .stylish-select .drop4 .newListSelected{ width:100%}
            .input_star .star_icon{ right:1px;}
            .customfile1-button{ padding-left:2px}
            .ship_left ul li{ line-height:30px;}
            .add_edit_pakage label{ width:100%;}
            .com_address_sec{float: left; font-size:14px;width: 100%;padding-top: 20px;}
            .customfile1-button{width:92px;}
            textarea{border:1px solid #dcdcdc; width:465px; padding:8px; box-sizing:border-box;}
            .f_rite{float:left;}
            @media screen and (-webkit-min-device-pixel-ratio:0) {.customfile1-input{width:100%} ::i-block-chrome,.customfile1-input {width:auto}}
            #cboxOverlayId {
                background: url("<?php echo IMAGE_PATH_URL; ?>overlay.jpg") repeat scroll 0 0 #000 !important;
                cursor: default !important; 
                height: 100%;
                position: fixed;
                width: 100%;
                z-index:2147483647; 
            }
            .ship_left ul li .hoverClass:hover{text-decoration: underline !important;}

            .uploadImageouter{margin-top:20px;}
            .cropContainerHeaderButton{width:auto}
        </style>
        <script type="text/javascript" src="<?php echo JS_PATH ?>bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>croppic.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>main.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>wholesaler_edit.js"></script>
    </head>
    <body>
        <div id="cboxOverlayId" style="display: block; opacity: 0.9; cursor: pointer;text-align:center;display:none"><img src="<?php echo IMAGE_PATH_URL; ?>loading_all.gif" style="margin-top:350px"/></div>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"></div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%;height:50px; padding-top:16px;border-bottom:1px solid #e7e7e7;" class="wholesalerHeaderSection"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_container">

                    </div>

                    <div class="body_inner_bg" style="">
                        <?php $wholesaler_details = $objPage->arrWholesalerDeatails; ?>
                        <form enctype="multipart/form-data" name="frmWholesalerUpdate" id="frmWholesalerUpdate" method="post" action="">
                            <div class="add_edit_pakage aapplication_form" style="background:none">
                                <?php
                                if ($_POST['error_msg']) {
                                    ?>
                                    <div>
                                        <?php
                                        echo $_POST['error_msg'];
                                        $_POST['error_msg'] = '';
                                        ?>
                                    </div>
                                <?php }
                                ?>

                                <ul class="left_sec myFullWidth">
                                    <li>
                                        <label><?php echo COM_NAME; ?></label>
                                        <div class="input_star input_boxes"><input type="text" tabindex="1" name="frmCompanyName" id="frmCompanyName" value="<?php echo $_POST['frmCompanyName'] ? $_POST['frmCompanyName'] : $wholesaler_details['CompanyName'] ?>"  class="validate[required] text-input" maxlength="100" />
                                            <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                        </div>
                                    </li>
                                    <li class="f_rite toRight">
                                        <label><?php echo SERV; ?></label>
                                        <textarea name="frmServices" id="frmServices" tabindex="2" cols="52" rows="5" style="width:100%"><?php echo @$_POST['frmServices'] ? $_POST['frmServices'] : $wholesaler_details['Services'] ?></textarea>
                                    </li>

                                    <div class="clear"></div>

                                    <li>
                                        <label><?php echo ABT_COM; ?><span><?php echo MIN_200; ?></span> </label>
                                        <textarea name="frmAboutCompany" id="frmAboutCompany" cols="56" rows="5" tabindex="3"><?php echo @$_POST['frmAboutCompany'] ? $_POST['frmAboutCompany'] : $wholesaler_details['AboutCompany'] ?></textarea>
                                    </li>                                    
                                    <li class="f_rite toRight">
                                        <?php
                                        foreach ($objPage->arrDocumentList as $document) {
                                            if (file_exists(UPLOADED_FILES_SOURCE_PATH . "files/wholesaler/" . $document['DocumentName'])) {
                                                ?>
                                                <div class="item divmatterbox"><a href="<?php echo UPLOADED_FILES_URL . "files/wholesaler/" . $document['DocumentName']; ?>" target="_blank"><?php echo $document['FileName']; ?></a>
                                                                        <!-- <span style="cursor: pointer;" class="deleteimgright" onclick="deleteImage(<?php echo $document['pkDocumentID']; ?>)">
                                                        <img src="<?php echo SITE_ROOT_URL . 'admin/images/cross.png'; ?>" alt="Delete" title="Delete" />
                                                        </span> -->
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <label><?php echo BUS_PLAN; ?><span><?php echo OPTION_BROW; ?></span> </label>
                                        <input class="customfile1-input file1"  id="file1" type="file" name="fileBusinessPlan" style="top: -509px; left: 0px!important;" tabindex="4"/>
                                    </li> 
                                    <div class="clear"></div>
                                    <li>
                                        <div class="uploadImageouter" style="width:100%; float:left;">
                                            <label><?php echo WH_LOGO; ?><span><?php echo WH_LOGO_HEIGHT_WIDTH; ?></span> </label>
                                            <a href="#cropimg_1" onclick="jCroppicPopupOpen('cropimg', 1, 'croppicLogo')" class="cropimg" style="z-index:9999999;float:left;">Upload Logo Image</a>
                                            <div id="cropimg_1" style="display:none;"></div>    
                                            <input type="hidden" name="fileLogo" id="fileLogo" value=""/>
                                            <div class="afterCropLogo" style="float:left;">
                                                <?php
                                                if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_logo/" . $wholesaler_details['wholesalerLogo'])) {
                                                    ?>
                                                    <img src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_logo/" . $wholesaler_details['wholesalerLogo']; ?>" alt="<?php echo $wholesaler_details['wholesalerLogo']; ?>" style="height:93px;background-color:#1C6CA1;"  />
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="f_rite toRight">
                                        <span>
                                            <?php
                                            foreach ($objPage->arrsliderImagesList as $slider) {
                                                if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_slider/" . $slider['sliderImage'])) {
                                                    ?>
                                                    <div class="item divbox" id="img<?php echo $slider['pkSliderId']; ?>"><a target="blank" href="<?php echo UPLOADED_FILES_URL . "images/wholesaler_slider/" . $slider['sliderImage']; ?>"><img src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_slider/" . $slider['sliderImage']; ?>"  alt="<?php echo $slider['sliderImage']; ?>" style="width:50px;height: 33px;" /></a>
                                                        <span style="cursor: pointer;" class="deleteimg" onclick="deleteSliderImage(<?php echo $slider['pkSliderId']; ?>)">
                                                            <img src="<?php echo SITE_ROOT_URL . 'admin/images/cross.png'; ?>" alt="Delete" title="Delete" />
                                                        </span>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </span>
                                        <label><?php echo WH_SLIDER_IMAGE; ?><span><?php echo WH_SLIDER_IMAGE_HEIGHT_WIDTH; ?></span> </label>

                                        <div class="add-more simpleBox">
                                            <a href="#cropimg_2" onclick="jCroppicPopupOpen('cropimg', 2, 'croppicSlider')" class="cropimg" style="z-index:9999999;float:left;">Upload Slider Image</a>
                                            <div id="cropimg_2" style="display:none;"></div>    
                                            <input type="hidden" name="fileSliderImage[]" id="sliderimage_2" value=""/>
                                            <div class="afterCropLogo_2" style="float:left;"></div>
                                        <!--<input class="customfile1-input file2" onchange="checkImages(this)"  id="sliderimage" type="file" name="fileSliderImage[]" style="top: -509px; left: 0px!important;" tabindex="6"/>-->
                                            <a title="add more" style="padding-top: 0px;padding-bottom:10px;" href="javascript:void(0)" class="more more_images"><img src="common/images/plus_shopping.jpg" alt="add more" /></a>
                                        </div>
                                    </li>  


                                    <!-- <li>
<label><?php echo PRIVACY_POLICY; ?><span></span> </label>
<textarea name="frmPrivacyPolicy" id="frmPrivacyPolicy" tabindex="" cols="5" rows="5"><?php echo @$_POST['frmPrivacyPolicy'] ? $_POST['frmPrivacyPolicy'] : $wholesaler_details['wholesalerPrivacyPolicy'] ?></textarea>
     </li> -->
                                </ul>

                                <div class="com_address_sec">
                                    <div class="ship_left">
                                        <h3 class="title_txt_box regHeading"><?php echo SEL_SHIPP_GAT; ?>:</h3>

                                        <ul class="left_sec" style="width: 100%" >
                                            <li>
                                                <?php
                                               // pre($objPage->arrShippingList);
                                                foreach ($objPage->arrShippingList as $kShip => $vShip) {
                                                    ?>
                                                <input disabled="disabled" tabindex="7" class="checkradios1 newcheckClass" type="checkbox" name="frmShippingGateway[]" value="<?php echo $vShip['logisticportalid']; ?>" <?php
                                                    if (in_array($vShip['logisticportalid'], $wholesaler_details['shippingDetails'])) {
                                                        echo 'checked="checked"';
                                                    }
                                                    ?> />&nbsp;&nbsp;
                                                           <?php
                                                           if ($vShip['logisticgatwaytype'] == 'admin') {
                                                               ?>
                                                    <span style="color: #56A0F2"><?php echo $vShip['logisticTitle']; ?></span>
<!--                                                        <a class="QuickViewMethods" onclick="jscallCustomeMethods('QuickViewMethods');" href="<?php echo $objCore->getUrl('methods_quickview.php', array('sgid' => $vShip['logisticportalid'], 'action' => 'methodsQuickView')); ?>" style="text-decoration: none">
                                                            
                                                        </a>-->
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <?php echo $vShip['logisticTitle']; ?>
                                                    <?php } ?>

                                                    <br/>
                                                <?php } ?>
                                                <br/>
<!--                                                <a class="QuickViewZoneCountry" onclick="jscallZoneCountry('QuickViewZoneCountry');" href="#QuickViewZoneCountry" style="color: #56A0F2;text-decoration: none">View Zone country list</a>-->
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="ship_left rightship">
                                        <h3 class="title_txt_box regHeading"><?php echo SEL_TEMPLATE_DEFAULT; ?>:</h3>

                                        <ul class="left_sec" style="width:100%" >
                                            <li>
                                                <?php
                                                $varCounterTemplate = 1;
                                                foreach ($objPage->arrTemplateList as $template) {
                                                    ?>
                                                    <input tabindex="8" class="checkradios" type="radio" name="frmTemplate" value="<?php echo $template['pkTemplateId']; ?>" <?php
                                                    if ($template['pkTemplateId'] == $wholesaler_details['fkTemplateId']) {
                                                        echo 'checked="checked"';
                                                    }
                                                    ?> />&nbsp;&nbsp;
                                                    <a title="click here for view" target="_new" class="QuickViewMethods hoverClass" href="<?php echo $objCore->getUrl('wholesaler_template' . $varCounterTemplate . '.php', array('tmpid' => $template['pkTemplateId'])); ?>" style="text-decoration: none;">
                                                        <span style="color: #56A0F2"><?php echo $template['templateDisplayName']; ?></span>
                                                    </a>
                                                    <br/>
                                                    <?php
                                                    $varCounterTemplate++;
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                        <div class="cb"></div>
                                    </div>
                                    <div class="cb"></div>
                                    <h3 class="title_txt_box regHeading"><?php echo COM_ADD; ?></h3>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo ADD1; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="9"  name="frmCompany1Address1" id="frmCompany1Address1" value="<?php echo @$_POST['frmCompany1Address1'] ? $_POST['frmCompany1Address1'] : $wholesaler_details['CompanyAddress1'] ?>"  class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">

                                            <label><?php echo ADD2; ?></label>
                                            <div class="input_star input_boxes">

                                                <input type="text" tabindex="10" name="frmCompany1Address2" id="frmCompany1Address2" value="<?php echo @$_POST['frmCompany1Address2'] ? $_POST['frmCompany1Address2'] : $wholesaler_details['CompanyAddress2'] ?>"  class="" maxlength="256" />
                                            </div>
                                        </li>
<!--                                        <li>
                                            <label><?php echo CITY; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="11" name="frmCompany1City" id="frmCompany1City" value="<?php echo @$_POST['frmCompany1City'] ? $_POST['frmCompany1City'] : $wholesaler_details['CompanyCity'] ?>"  class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>-->
<!--                                        <li class="toRight">
                                            <label><?php echo COUNTRY; ?></label>
                                            <div class="input_star input_boxes">
                                                <div class="drop4 dropdown_2">
                                                    <select name="frmCompany1Country" id="frmCompany1Country" class="drop_down1" tabindex="12">
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $var) {
                                                            if (in_array($var['country_id'], $PortalIDs)) {
                                                                $selected = $var['country_id'] == $wholesaler_details['CompanyCountry'] ? 'selected' : '';
                                                                echo '<option ' . $selected . ' value="' . $var['country_id'] . '">' . $var['name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div> <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>-->
                                        <li>
                                            <label><?php echo POS_CODE; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="13" name="frmCompany1PostalCode" id="frmCompany1PostalCode" value="<?php echo @$_POST['frmCompany1PostalCode'] ? $_POST['frmCompany1PostalCode'] : $wholesaler_details['CompanyPostalCode'] ?>" maxlength="8" class="validate[required,minSize[4],maxSize[8]]"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
<!--                                        <li class="toRight">
                                            <label><?php echo REGION; ?></label>
                                            <div class="input_star input_boxes">

                                                <div class="drop4 dropdown_2" id="region_drop">
                                                    <select name="frmCompany1Region" id="frmCompany1Region" class="drop_down1" tabindex="14">
                                                        <option value="0"><?php //echo SEL_REG; ?></option>
                                                        <?php
//                                                        foreach ($objPage->regionList as $var) {
//                                                            $selected = $var['pkRegionID'] == $wholesaler_details['CompanyRegion'] ? 'selected' : '';
//                                                            echo '<option ' . $selected . ' value="' . $var['pkRegionID'] . '">' . $var['RegionName'] . '</option>';
//                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </li>-->
                                        <li class="toRight">
                                            <label><?php echo COMP_EMAIL; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="15" name="frmCompany1Email" id="frmCompany1Email" value="<?php echo @$_POST['frmCompany1Email'] ? $_POST['frmCompany1Email'] : $wholesaler_details['CompanyEmail'] ?>"  class="validate[required,custom[email]] text-input"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li >
                                            <label><?php echo WB; ?></label>
                                            <div class="input_star input_boxes">
                                                <input type="text" tabindex="16" name="frmCompany1Website" id="frmCompany1Website" value="<?php echo @$_POST['frmCompany1Website'] ? $_POST['frmCompany1Website'] : $wholesaler_details['CompanyWebsite'] ?>"/>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo PAY_EMAIL; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="17" name="frmPaypalEmail" id="frmPaypalEmail" value="<?php echo @$_POST['frmPaypalEmail'] ? $_POST['frmPaypalEmail'] : $wholesaler_details['PaypalEmail'] ?>"  class="validate[required,custom[email]] text-input"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li >
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star input_boxes"><input tabindex="18" type="text" value="<?php echo @$_POST['frmCompany1Phone'] ? $_POST['frmCompany1Phone'] : $wholesaler_details['CompanyPhone'] ?>" name="frmCompany1Phone" id="frmCompany1Phone" class="validate[required,custom[phone],minSize[10]] text-input" maxlength="15" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo FEX; ?></label>                                           
                                            <div class="input_star input_boxes">
                                                <input type="text" tabindex="19" name="frmCompany1Fax" id="frmCompany1Fax" value="<?php echo @$_POST['frmCompany1Fax'] ? $_POST['frmCompany1Fax'] : $wholesaler_details['CompanyFax'] ?>"  maxlength="100" />
                                            </div>
                                        </li>
                                    </ul>

                                    <h3 class="title_txt_box regHeading"><?php echo CON_PERSON; ?></h3>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo NAME; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="20" name="frmContactName" id="frmContactName" value="<?php echo @$_POST['frmContactName'] ? $_POST['frmContactName'] : $wholesaler_details['ContactPersonName'] ?>"  class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo POS; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="21" name="frmContactPosition" id="frmContactPosition" value="<?php echo @$_POST['frmContactPosition'] ? $_POST['frmContactPosition'] : $wholesaler_details['ContactPersonPosition'] ?>"  class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star input_boxes"><input tabindex="22" type="text" name="frmContactPhone" id="frmContactPhone" value="<?php echo @$_POST['frmContactPhone'] ? $_POST['frmContactPhone'] : $wholesaler_details['ContactPersonPhone'] ?>"  class="validate[required,custom[phone],minSize[10]] text-input" maxlength="15" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo EMAIL; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="23" name="frmContactEmail" id="frmContactEmail" value="<?php echo @$_POST['frmContactEmail'] ? $_POST['frmContactEmail'] : $wholesaler_details['ContactPersonEmail'] ?>"  class="validate[required,custom[email]] text-input"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label> <?php echo POS_ADD; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="24" name="frmContactAddress" id="frmContactAddress" value="<?php echo @$_POST['frmContactAddress'] ? $_POST['frmContactAddress'] : $wholesaler_details['ContactPersonAddress'] ?>"  class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="cb"></div>
                                    <h3 class="title_txt_box regHeading"><?php echo OWNER_INFOR; ?></h3>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo NAME; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="25" name="frmOwnerName" id="frmOwnerName" value="<?php echo @$_POST['frmOwnerName'] ? $_POST['frmOwnerName'] : $wholesaler_details['OwnerName'] ?>"  class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li  class="toRight">
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="26" name="frmOwnerPhone" id="frmOwnerPhone" value="<?php echo @$_POST['frmOwnerPhone'] ? $_POST['frmOwnerPhone'] : $wholesaler_details['OwnerPhone'] ?>"  class="validate[required,custom[phone],minSize[10]] text-input" maxlength="15" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo EMAIL; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="27" name="frmOwnerEmail" id="frmOwnerEmail" value="<?php echo @$_POST['frmOwnerEmail'] ? $_POST['frmOwnerEmail'] : $wholesaler_details['OwnerEmail'] ?>"  class="validate[required,custom[email]] text-input"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li  class="toRight">
                                            <label><?php echo POS_ADD; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="28" name="frmOwnerAddress" id="frmOwnerAddress" value="<?php echo @$_POST['frmOwnerAddress'] ? $_POST['frmOwnerAddress'] : $wholesaler_details['OwnerAddress'] ?>"  class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="cb"></div>
                                    <h3 class="title_txt_box regHeading"><?php echo TRADE_REF; ?><span><?php echo REF_MUST; ?></span></h3>
                                    <h4 class="ref"><?php echo REF_1; ?></h4>
                                    <ul class="left_sec myFullWidth">

                                        <li>
                                            <label><?php echo NAME; ?> </label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="29" name="frmRefrence1Name" id="frmRefrence1Name" value="<?php echo @$_POST['frmRefrence1Name'] ? $_POST['frmRefrence1Name'] : $wholesaler_details['Ref1Name'] ?>"  class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="30" name="frmRefrence1Phone" id="frmRefrence1Phone" value="<?php echo @$_POST['frmRefrence1Phone'] ? $_POST['frmRefrence1Phone'] : $wholesaler_details['Ref1Phone'] ?>"  class="validate[required,custom[phone],minSize[10]] text-input" maxlength="15" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>

                                        <li>
                                            <label><?php echo EMAIL; ?> </label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="31" name="frmRefrence1Email" id="frmRefrence1Email" value="<?php echo @$_POST['frmRefrence1Email'] ? $_POST['frmRefrence1Email'] : $wholesaler_details['Ref1Email'] ?>"  class="validate[required,custom[email]] text-input"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label> <?php echo COM_NAME; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="32" name="frmRefrence1CompanyName" id="frmRefrence1CompanyName" value="<?php echo @$_POST['frmRefrence1CompanyName'] ? $_POST['frmRefrence1CompanyName'] : $wholesaler_details['Ref1CompanyName'] ?>"  class="validate[required] text-input" maxlength="100" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>

                                        <li>
                                            <label><?php echo COM_ADD; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="33" name="frmRefrence1Address" id="frmRefrence1Address" value="<?php echo @$_POST['frmRefrence1Address'] ? $_POST['frmRefrence1Address'] : $wholesaler_details['Ref1CompanyAddress'] ?>"  class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>

                                    <h4 class="ref"><?php echo REF_2; ?></h4>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo NAME; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="34" name="frmRefrence2Name" id="frmRefrence2Name" value="<?php echo @$_POST['frmRefrence2Name'] ? $_POST['frmRefrence2Name'] : $wholesaler_details['Ref2Name'] ?>"  class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="35" name="frmRefrence2Phone" id="frmRefrence2Phone" value="<?php echo @$_POST['frmRefrence2Phone'] ? $_POST['frmRefrence2Phone'] : $wholesaler_details['Ref2Phone'] ?>"  class="validate[required,custom[phone],minSize[10]] text-input" maxlength="15" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo EMAIL; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="36" name="frmRefrence2Email" id="frmRefrence2Email" value="<?php echo @$_POST['frmRefrence2Email'] ? $_POST['frmRefrence2Email'] : $wholesaler_details['Ref2Email'] ?>"  class="validate[required,custom[email]] text-input"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo COM_NAME; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="37" name="frmRefrence2CompanyName" id="frmRefrence2CompanyName" value="<?php echo @$_POST['frmRefrence2CompanyName'] ? $_POST['frmRefrence2CompanyName'] : $wholesaler_details['Ref2CompanyName'] ?>"  class="validate[required] text-input" maxlength="100" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo COM_ADD; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="38" name="frmRefrence2Address" id="frmRefrence2Address" value="<?php echo @$_POST['frmRefrence2Address'] ? $_POST['frmRefrence2Address'] : $wholesaler_details['Ref2CompanyAddress'] ?>"  class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>

                                    <h4 class="ref"><?php echo REF_3; ?></h4>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo NAME; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="39" name="frmRefrence3Name" id="frmRefrence3Name" value="<?php echo @$_POST['frmRefrence3Name'] ? $_POST['frmRefrence3Name'] : $wholesaler_details['Ref3Name'] ?>"  class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="40" name="frmRefrence3Phone" id="frmRefrence3Phone" value="<?php echo @$_POST['frmRefrence3Phone'] ? $_POST['frmRefrence3Phone'] : $wholesaler_details['Ref3Phone'] ?>"  class="validate[required,custom[phone],minSize[10]] text-input" maxlength="15" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo EMAIL; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="41" name="frmRefrence3Email" id="frmRefrence3Email" value="<?php echo @$_POST['frmRefrence3Email'] ? $_POST['frmRefrence3Email'] : $wholesaler_details['Ref3Email'] ?>"  class="validate[required,custom[email]] text-input"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo COM_NAME; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="42" name="frmRefrence3CompanyName" id="frmRefrence3CompanyName" value="<?php echo @$_POST['frmRefrence3CompanyName'] ? $_POST['frmRefrence3CompanyName'] : $wholesaler_details['Ref3CompanyName'] ?>"  class="validate[required] text-input" maxlength="100" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo COM_ADD; ?></label>
                                            <div class="input_star input_boxes"><input type="text" tabindex="43" name="frmRefrence3Address" id="frmRefrence3Address" value="<?php echo @$_POST['frmRefrence3Address'] ? $_POST['frmRefrence3Address'] : $wholesaler_details['Ref3CompanyAddress'] ?>"  class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="edit_wholesaler create_cancle_btn cb">
                                        <input style="margin-top:0px;float:left;" type="submit" value="<?php echo UPDATE; ?>" class="submit3" tabindex="43" />
                                        <input type="hidden" name="frmHidenEdit" value="Update" />
                                        <input type="hidden" name="pkWholesalerID" value="<?php echo $wholesaler_details['pkWholesalerID'] ?>" />
                                        <!--<a href="<?php echo $objCore->getUrl('dashboard_wholesaler_account.php'); ?>">-->
                                        <input onclick="window.location.href = '<?php echo $objCore->getUrl('dashboard_wholesaler_account.php'); ?>'" tabindex="44" type="button" style="float:left;" value="<?php echo CANCEL; ?>" class="cancel"/>
                                        <!--</a>-->
                                    </div>
                                </div></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: none;">
            <div class="quick_color" id="QuickViewZoneCountry" style="height: 385px; overflow: auto">
                <table cellspacing="0" cellpadding="0" border="0" style="width:100%">
                    <tbody>
                        <?php
                        foreach ($objPage->arrZoneCountry as $val) {
                            ?>
                            <tr class="content">
                                <td colspan="12"><b><?php echo 'Zone ' . $val['zone']; ?></b></td>
                            </tr>
                            <tr class="content">
                                <td colspan="12">
                                    <div class="zonelist"><?php echo str_replace(',', '</div><div class="zonelist">', $val['Countries']); ?></div>
                                </td>
                            </tr>
                            <tr class="content">
                                <td colspan="12">&nbsp;</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
        <script>
            function jCroppicPopupOpen(str, con, clss) {    //alert(str);return false;    
                $('#cropimg_' + con).show();
                var htmlCrop = '<div class="col-lg-6 cropHeaderWrapper"><div id="croppic' + con + '" class="' + clss + '"></div><span class="btn cropContainerHeaderButton" id="cropContainerHeaderButton' + con + '" style="cursor:pointer;">Upload Image</span></div>';
                $('#cropimg_' + con).html(htmlCrop);
                $("." + str).colorbox({
                    inline: true
                });
                var croppicHeaderOptions = {
                    //uploadUrl:'img_save_to_file.php',
                    cropData: {"dummyData": 1, "dummyData2": "asdas"},
                    cropUrl: 'img_crop_to_file.php',
                    customUploadButtonId: 'cropContainerHeaderButton' + con + '',
                    modal: false,
                    processInline: true,
                    loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
                    onBeforeImgUpload: function () {
                        console.log('onBeforeImgUpload')
                    },
                    onAfterImgUpload: function () {
                        console.log('onAfterImgUpload')
                    },
                    onImgDrag: function () {
                        console.log('onImgDrag')
                    },
                    onImgZoom: function () {
                        console.log('onImgZoom')
                    },
                    onBeforeImgCrop: function () {
                        console.log('onBeforeImgCrop')
                    },
                    onAfterImgCrop: function () {
                        console.log('onAfterImgCrop')
                    },
                    onError: function (errormessage) {
                        console.log('onError:' + errormessage)
                    }
                }
                var croppic = new Croppic('croppic' + con + '', croppicHeaderOptions);


                var croppicContainerModalOptions = {
                    uploadUrl: 'img_save_to_file.php',
                    cropUrl: 'img_crop_to_file.php',
                    modal: true,
                    imgEyecandyOpacity: 0.4,
                    loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
                }
                var cropContainerModal = new Croppic('cropContainerModal', croppicContainerModalOptions);


                var croppicContaineroutputOptions = {
                    uploadUrl: 'img_save_to_file.php',
                    cropUrl: 'img_crop_to_file.php',
                    outputUrlId: 'cropOutput',
                    modal: false,
                    loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
                }
                var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);

                var croppicContainerEyecandyOptions = {
                    uploadUrl: 'img_save_to_file.php',
                    cropUrl: 'img_crop_to_file.php',
                    imgEyecandy: false,
                    loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
                }
                var cropContainerEyecandy = new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);

                var croppicContaineroutputMinimal = {
                    uploadUrl: 'img_save_to_file.php',
                    cropUrl: 'img_crop_to_file.php',
                    modal: false,
                    doubleZoomControls: false,
                    rotateControls: false,
                    loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
                }
                var cropContaineroutput = new Croppic('cropContainerMinimal', croppicContaineroutputMinimal);

                var croppicContainerPreloadOptions = {
                    uploadUrl: 'img_save_to_file.php',
                    cropUrl: 'img_crop_to_file.php',
                    loadPicture: 'assets/img/night.jpg',
                    enableMousescroll: true,
                    loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
                }
                var cropContainerPreload = new Croppic('cropContainerPreload', croppicContainerPreloadOptions);

                $('#cboxClose,#cboxOverlay').click(function () {
                    $('#cropimg_' + con).hide();
                    parent.jQuery.fn.colorbox.close();
                });


            }
        </script>




    </body>



</html>
