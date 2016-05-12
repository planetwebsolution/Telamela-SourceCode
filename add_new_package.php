<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_MANAGE_PACKAGE_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo ADD_PACKAGE_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
<!--        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>browse.css"/> -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>cropic2.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>croppic.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>browse.js"></script>
        <script type="text/javascript">
            ImageExist='<?php echo count($objPage->arrPackageDetail[0]['PackageImage']); ?>';
        </script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
        <script type="text/javascript" src="<?php echo JS_PATH ?>bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>croppic.min.product.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>main.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>package_add_edit.js"></script> 
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>           
        <script src="<?php echo JS_PATH ?>select2.min.js"></script>
        <script>
            jQuery(document).ready(function() {
                // binds form submission and fields to the validation engine
                jQuery("#add_package").validationEngine();
                $(".select2-me").select2();
            });
        </script>
        <style>.edit_left_sec.edit_left_sec1{ position:relative }
            .offer_price h4{ padding-right:16px;}
            .add_pakage_with .edit_left_sec2{ position:relative}
            .customfile1-feedback-populated{ color:#000000 !important; background:#FFF}
            #s2id_frmCategoryId{ width:414px;}
            .add_pakage_with li{ width:101%}
        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"></div>

            <?php include_once INC_PATH . 'header.inc.php'; ?>
        </div>

        <div id="ouderContainer" class="ouderContainer_1">
        <div style="width:100%; height:50px; padding-top:16px;">
        <div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">


                <div class="add_pakage_outer">
                    <div class="top_container" style="padding-bottom:0px;">
                        <div class="top_header border_bottom">
                            <h1><?php echo CREATE; ?>  <?php echo A_NEW_PACK; ?></h1>
                        </div>

                        <?php
                        if ($objCore->displaySessMsg())
                        {
                            ?>  
                            <div style="text-align:center; width: 1000px; color:red">
                                <?php
                                echo $objCore->displaySessMsg();
                                $objCore->setSuccessMsg('');
                                $objCore->setErrorMsg('');
                                ?>
                            </div>
                        <?php }
                        ?>
                    </div>

                    <div class="body_inner_bg" id="styles">
                    <?php
                    /**
                     * To show an error if package is created already.
                     *
                     * @author : Krishna Gupta
                     *
                     * @created : 29-10-2015
                     */
                    if($objPage->checkUniquePackage) { ?>
                    	<span style="color: red; margin-left: 500px;"> <b>This package is created already.</b> </span>
                    <?php } ?>
                        <form id="add_package" name="packageUpdate" onsubmit="return validatePackageForm();" action="" method="POST" enctype="multipart/form-data">
                            <div class="add_pakage add_pakage_with" style="margin-top:0px; padding:0px;">
                                <!--<div class="back_ankar_sec" style="padding-top:0px;"><a href="<?php //echo $objCore->getUrl('manage_packages.php');        ?>" class="back"><span><?php // echo BACK;        ?></span></a></div>-->
                                <ul class="add_pakage_inner add_pakage_with">
                                    <small class="req_field" style=" float:left !important; clear:both;padding-bottom:20px;">* <?php echo FILED_REQUIRED; ?> </small>

                                    <li  class="first">
                                        <div class="edit_left_sec edit_left_sec1">
                                            <h3><?php echo SEL_PRO_1; ?><span class="price" style=" padding-right: 50px;" ><?php echo ORG_PRICE; ?> <span style="color:#F00">*</span></span></h3>
                                            <div class="drop21 dropd2own_2" style="width:423px; float: left">
                                                <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmCategoryId[]', '', array(0), SEL_CAT, 0, 'onchange="ShowProductForPackage(this.value,1);" class="select2-me" style="width:415px"', '1', '1'); ?>
                                            </div>

                                            <div class="drop1 dropdown_4 product_selected_box my_sel_box" id="product1">
                                                <select class="drop_down1">
                                                    <option value="0">Select Product</option> 
                                                </select>
                                            </div>
                                            <input id="price1" class="text1 validate[required]" readonly="true" name="frmPrice[]" type="text" value="" style=" margin-right:-9px"/>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="edit_left_sec edit_left_sec1">
                                            <h3><?php echo SEL_PRO_2; ?><span class="price" style="padding-right:50px;" ><?php echo ORG_PRICE; ?> <span style="color:#F00">*</span></span></h3>
                                            <div class="drsop1 drsopdown_2" style="width:423px; float: left">
                                                <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmCategoryId[]', '', array(0), SEL_CAT, 0, 'onchange="ShowProductForPackage(this.value,2);" class="select2-me" style="width:415px"', '1', '1'); ?>
                                            </div>
                                            <div class="drop1 dropdown_4 product_selected_box my_sel_box" id="product2">
                                                <select class="drop_down1"><option value="0">Select Product</option> 

                                                </select> 
                                            </div>
                                            <input id="price2"  style=" margin-right:-9px" class="text1 validate[required]" readonly="true" name="frmPrice[]" type="text" value=""/>
                                        </div></li>

                                    <li class="last">
                                        <div class="edit_left_sec edit_left_sec2">

                                            <div class="offer_price right">
                                                <h4><?php echo TOTAL_PRICE; ?></h4>
                                                <input id="frmTotalPrice" readonly="true" type="text" value="" class="frmTotalPrice_input"/>
                                                <a href="#" class="add_product"><?php echo ADD_MORE_PRODUCT; ?></a>
                                            </div>

                                            <div class="offer_price" style="position: relative">
                                                <h4><?php echo OFF_PRICE; ?> <span style="color:#F00">*</span></span></h4>
                                                <div class="msgOffer" style="float: left; width: 146px;">
                                                    <input type="text" value="" style="text-align: left; width: 100%; float: left;" name="frmOfferPrice" class="validate[required,custom[integer],min[1],lessThan[frmTotalPrice]]" numericonly="yes">
                                                    
                                                </div>
                                                <span style="width: 100%; float: left; margin-top: 10px; font-weight: 600; font-size: 11px;">Note : Offer price should included with margin cost</span>
                                            </div>
                                
                                        </div>

                                    </li>
                                    <li>
                                        <div style="position: relative">
                                            <h3><?php echo PACKAGE_NAME; ?><span style="color:#F00">*</span></span></h3>
                                            <input class="validate[required] txt_orange" name="frmPackageName" id="frmPackageName" package="0" oldP="" type="text" value=""/>
                                        </div>
                                    </li>
                                    <li>
                                        <h3  class="simpleBox"><?php echo UPLOAD_PACKAGE_IMAGE; ?><strong> (600x600)</strong></h3>
                                        
                                        <div class="uploadImageouter" style="width:100%; float:left;">
                                                <a href="#cropimg_1" onclick="jCroppicPopupOpen('cropimg',1)" class="cropimg" style="z-index:9999999">Upload Image</a>
                                                <div id="cropimg_1" style="display:none;"></div>    
                                                <input type="hidden" name="frmPackageImage" id="after_cropimg_1" value=""/>
                                                <span class="myImgSpan" style="margin-left: 15px;"></span>
                                                </div>
                                    </li>
                                    <li class="create_cancle_btn">
                                        <input type="submit" value="Create" class="submit3" style="margin-top:0px; float:left;" />
                                        <input type="hidden" name="frmWholesalerId" id="frmWholesalerId" value="<?php echo $_SESSION['sessUserInfo']['id']; ?>" />
                                        <input type="hidden" value="add" name="action" />
                                        <input type="hidden" name="pkid" value="" />
                                        <!--<a href="<?php echo $objCore->getUrl('manage_packages.php'); ?>">-->
                                            <input onclick="window.location.href='<?php echo $objCore->getUrl('manage_packages.php'); ?>'" type="button" value="Cancel" class="cancel"/>
                                        <!--</a>-->
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
         <script type="text/javascript" src="<?php echo JS_PATH ?>crop.js"></script> 
    </body>
</html> 