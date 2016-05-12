<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_BULK_UPLOAD_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo BULK_UPLOAD_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>browse.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>browse.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>bulk_upload.js"></script>
		<style>.stylish-select .drop4 .newListSelected{ width:424px; height:39px;}
		.customfile1-button{ width:87px; padding-left:5px }
		.stylish-select .drop4 .selectedTxt {
    background: url("common/images/select2.png") no-repeat scroll 113% 8px #fff; width: 382px;}
				.check_box small{ line-height:19px;}
	.customfile1-button{ margin-left:332px }

   
		
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
      
        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%;height:50px; padding-top:16px;	  border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">
               <div id="my_gray_bg" class="add_pakage_outer">
                    <div class="top_container">
                      
                    </div>
                 
                    <div class="body_inner_bg">
                        <form action="" onsubmit="return validate()" name="bulk_upload" method="post" enctype="multipart/form-data" >
                            <div class="add_pakage bulk_sec">
                                <?php
                                if (isset($_POST['error_mgs']) && $_POST['error_mgs'] != '') {
                                    echo '<p class="req_field">' . $_POST['error_mgs'] . '</p><br/>';
                                    $_POST['error_mgs'] = '';
                                } else {
                                    echo '<p class="req_field">*' . FILED_REQUIRED . '</p>';
                                }
                                ?>
                                <ul class="bulk_inner">
                                    <li>
                                        <label><?php echo SEL_WANT_UPLOAD; ?></label>
                                        <div class="drop4">
                                            <select class="drop_down1" id="upload_type" name="upload_type">
                                                <option value=''><?php echo 'Select'; ?></option>
                                                <option value="products"><?php echo PRODUCTS; ?></option>
                                                <option value="packages"><?php echo PACKAGE1; ?></option>
                                            </select>
                                        </div>
                                        <p class="req_field"></p>
                                    </li>
                                    <li>
                                        <div class="product_options" style="display:none;">
                                            <div style="text-align: left; line-height:30px"><small><?php echo DOWNLOAD; ?>: 
                                                    <a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/telamela.zip">Sample Product or Package Csv & Xls zip file</a>
<!--                                                    <a href="<?php echo $objCore->getUrl('download.php',array('files'=>'wholesaler_product_uploads.csv')); ?>" target="_blank"><?php echo CSV_SAM; ?></a>&nbsp;&nbsp;<a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/wholesaler_product_uploads.xls" target="_blank"><?php echo XLS_SAM; ?></a>-->
                                                </small></div>
                                            <div class="check_box" onclick="checkAll('product_options')"><input id="product_options" name="checkAllProduct" type="checkbox" class="styled"  /> <small>Select All<?php //echo 'Check All'; ?></small></div>
                                            <div class="check_box"><input name="fields[]" id="field1" req="yes" type="checkbox" value="ProductRefNo" class="styled"/> <small><?php echo PRO_REF_NO; ?><strong>*</strong></small></div>
                                            <div class="check_box"><input name="fields[]" req="yes" type="checkbox" value="ProductName" class="styled"/> <small><?php echo PROD_NAME; ?><strong>*</strong></small></div>
                                            <div class="check_box"><input name="fields[]" req="yes" type="checkbox" value="WholesalePrice" class="styled"/> <small><?php echo WHOL_PRICE; ?><strong>*</strong></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="DiscountPrice" class="styled"/> <small><?php echo DIS_PRICE; ?></small></div>
                                            <div class="check_box forsmall_txt"><input name="fields[]" req="yes" type="checkbox" value="fkCategoryID" class="styled"/> <small><span><?php echo CATEGORY_TITLE; ?><strong>*</strong></span> <span style="color: red;" class="word_break"><?php echo 'Product will be added only third level category (Sub-sub-category)'; ?></span></small></div>
                                            <div class="check_box"><input name="fields[]" req="yes" type="checkbox" value="fkShippingID" class="styled"/> <small><?php echo SHIPP_METHOD; ?><strong>*</strong></small></div>
                                            <div class="check_box"><input name="fields[]" req="yes" type="checkbox" value="Quantity" class="styled"/> <small><?php echo ST_QUAN; ?><strong>*</strong></small></div>
                                            <div class="check_box"><input name="fields[]" req="yes" type="checkbox" value="QuantityAlert" class="styled"/> <small><?php echo ALERT_ON_QUAN; ?><strong>*</strong></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="DimensionUnit" class="styled"/><small><span><?php echo DIMEN_UNIT; ?></span> <span style="color: red;"><?php echo DIMEN_HELP_UNIT; ?></span></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="Length" class="styled"/> <small><?php echo LENG; ?></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="Width" class="styled"/> <small><?php echo HEIGHT; ?></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="Height" class="styled"/> <small><?php echo WIDTH; ?></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="WeightUnit" class="styled"/><small><span><?php echo WEIGHT_UNIT; ?></span> <span style="color: red;"><?php echo WEIGHT_HELP_UNIT; ?></span></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="Weight" class="styled"/> <small><?php echo WAIGHT; ?></small></div>
                                            <div class="check_box forsmall_txt"><input name="fields[]" type="checkbox" value="Attribute" class="styled"/> <small><span><?php echo ATTR; ?></span> <span style="color: red;"><?php echo ATTR_SHOULD; ?></span></small></div>                                            
                                            <div class="check_box forsmall_txt"><input name="fields[]" type="checkbox" value="AttributeInventory" class="styled"/> <small style="width: 93%"><?php echo ATTR_INVTRY; ?> <span style="color: red;" class="word_break"><?php echo ATTR_INVTRY_SHOULD; ?></span></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="ProductDescription" class="styled"/> <small><?php echo PRO_DES; ?></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="ProductTerms" class="styled"/> <small><?php echo PRO_TERMS;?></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="YoutubeCode" class="styled"/> <small><?php echo YOUTUBE_CODE; ?></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="HtmlEditor" class="styled"/> <small><?php echo HTML_EDI;?></small></div>                                            
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="ProductImage" class="styled"/> <small><?php echo PRO_DEF_IMG; ?></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="ImageName" class="styled"/> <small><?php echo PRO_IMG; ?></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="MetaTitle" class="styled"/> <small><?php echo META_TITLE; ?></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="MetaKeywords" class="styled"/> <small><?php echo META_KEY; ?></small></div>
                                            <div class="check_box"><input name="fields[]" type="checkbox" value="MetaDescription" class="styled"/> <small><?php echo META_DES; ?></small></div>
                                        </div>
                                        <div class="package_options" style="display:none;">
                                            <div style="text-align: left; line-height:30px"><small><?php echo DOWNLOAD; ?>: <a href="<?php echo $objCore->getUrl('download.php',array('files'=>'wholesaler_package_uploads.csv')); ?>" target="_blank"><?php echo CSV_SAM; ?></a>&nbsp;&nbsp;<a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/wholesaler_package_uploads.xls" target="_blank"><?php echo XLS_SAM; ?></a></small></div>
                                            <div class="check_box" onclick="checkAll('package_options')"><input name="checkAllPackage" id="package_options" type="checkbox" class="styled"/> <small>Select All<?php //echo 'Check All'; ?></small></div>
                                            <div class="check_box"><input name="fields[]" req="no" type="checkbox" value="PackageName" class="styled"/> <small><?php echo PACKAGE_NAME; ?><strong>*</strong></small></div>
                                            <div class="check_box forsmall_txt"><input name="fields[]" req="no" type="checkbox" value="ProductRefNo" class="styled"/> <small><span><?php echo PRO_REF_NO; ?><strong>*</strong></span> <span style="color: red;"> (Ex: Product Ref No should be:: Ref1|Ref2|Ref3|Ref4)</span></small></div>
                                            <div class="check_box"><input name="fields[]" req="no" type="checkbox" value="ProductAttribute" class="styled"/><small><span>Product Attribute</span></small></div>
                                            <div class="check_box"><input name="fields[]" req="no" type="checkbox" value="PackagePrice" class="styled"/> <small><?php echo PACK_PRICE; ?><strong>*</strong></small></div>
                                            <div class="check_box"><input name="fields[]" req="no" type="checkbox" value="PackageImage" class="styled"/> <small><?php echo PACK_IMG; ?><strong>*</strong></small></div>
                                        </div>
                                    </li>

                                    <li>
                                        <label><?php echo BR_CSV; ?></label>
                                        <div class="browse_file">
                                            <input class="customfile1-input file" type="file" name="file1" id="file1" style="top: 0px; left: 0px!important;"/>
                                        </div>
                                        <label><?php echo BR_IMG; ?></label>
                                        <div class="browse_file">
                                            <input class="customfile1-input file" type="file" name="frmImages" id="frmImages" style="top: 0px; left: 0px!important;" />
                                            <br/>
                                            <div class="check_box"><input type="checkbox" name="skip_first" value="skip" checked="checked" class="styled" /><small><?php echo SKIP_ROW; ?></small></div>
                                        </div>


                                    </li>
                                    <li>
                                        <div class="bulk_note">Note : <span style="color:#FF0000">*</span> Data in CSV file must be separated by comma (,). [For example:- <span class="red">"Product Ref No","Product Name"</span>]</div>
                                        <div class="bulk_note">Note : <span style="color:#FF0000">*</span> Product or Package images must be inside the zip file and names of images must be in the CSV or XLS file [<a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/telamela.zip">Sample</a>]</div>										  
                                    </li>                         
                                </ul>
                                <span class="btn">
                                    <input type="hidden" value="<?php echo $objPage->wid ?>" name="frmkfWholesalerID" class="continue_btn upload"/>
                                    <input type="hidden" value="upload" name="frmHiddenAdd" class="continue_btn upload"/>
                                    <input type="submit" value="Upload" name="submit" class="continue_btn upload submit3"/>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>