<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_BULK_UPLOAD_CTRL;
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Apple devices fullscreen -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Apple devices fullscreen -->
        <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <title><?php echo ADMIN_PANEL_NAME; ?> : Bulk Uploads </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script>
            function getUploadFieldsList(type){
                $('.uploadType').hide();
                $('#'+type).show();
                if(type == 'product')
                {
                    $('#productImageZip').show();
                    $('#packageImageZip').hide();
                }
                else if(type == 'packages')
                {
                    $('#productImageZip').hide();
                    $('#packageImageZip').show();
                }
                else{
                    $('#productImageZip').hide();
                    $('#packageImageZip').hide();           
                }
                //$('#category').find('.styled').prop("checked", this.checked);
                $('.styled').attr('checked',null);
                $('#checkAllProduct').attr('checked',null);
                $('#checkAllWholesaler').attr('checked',null);
                $('#checkAllCategory').attr('checked',null);
                $('#checkAllCustomers').attr('checked',null);
                $('#checkAllPackages').attr('checked',null);
            }
            $(document).ready(function(){
                
                $('.uploadType').each(function(e){
                    var getId=$.trim($(this).attr('id'));
                    if($('#'+getId).is(':visible')){
                        getUploadFieldsList(getId);
                    }
                });
                
                $('#checkAllProduct').click(function(){
                    if($(this).attr('checked')){$('#product .styled').attr('checked','checked');}
                    else{$('#product .styled').attr('checked',null); }
                });
                $('#checkAllWholesaler').click(function(){
                    if($(this).attr('checked')){$('#wholesalers .styled').attr('checked','checked');}
                    else{$('#wholesalers .styled').attr('checked',null); }
                });
                $('#checkAllCategory').click(function(){
                    if($(this).attr('checked')){$('#category .styled').attr('checked','checked');}
                    else{$('#category .styled').attr('checked',null); }  
                });
                $('#checkAllCustomers').click(function(){
                    if($(this).attr('checked')){$('#customers .styled').attr('checked','checked');}
                    else{$('#customers .styled').attr('checked',null); } 
                });
                $('#checkAllPackages').click(function(){
                    if($(this).attr('checked')){$('#packages .styled').attr('checked','checked');}
                    else{$('#packages .styled').attr('checked',null); }
                });
                
            });
        </script>
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Bulk Uploads </h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><span>Bulk Uploads </span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="row-fluid">						
                        <div class="span12">
                            <div class="tab-pane active" id="tabs-2">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <?php
                                        if ($objCore->displaySessMsg())
                                        {
                                            echo $objCore->displaySessMsg();
                                            $objCore->setSuccessMsg('');
                                            $objCore->setErrorMsg('');
                                        }
                                        ?>
                                        <div class="box box-color box-bordered">
                                            <div class="box-title">
                                                <h3>Bulk Uploads</h3>                                                            
                                            </div>

                                            <div class="box-content nopadding">
                                                <?php require_once('javascript_disable_message.php'); ?>
<?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('manage-products', $_SESSION['sessAdminPerMission']))
{ ?>
                                                    <form action="" method="post" id="frm_page" onsubmit="return validateBulkUpload('frm_page');" enctype="multipart/form-data">
                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Select upload:  </label>
                                                                    <div class="controls">
                                                                        <select name="frmContentName" id="frmContentName" onchange="getUploadFieldsList(this.value);" class='select2-me input-xlarge'>
                                                                            <option value="">Select</option>
                                                                            <option value="product" <?php
    if ($_GET['type'] == 'product')
    {
        echo "selected";
    }
    ?>>Products</option>
                                                                            <option value="customers" <?php
                                                                        if ($_GET['type'] == 'customers')
                                                                        {
                                                                            echo "selected";
                                                                        }
    ?>>Customers</option>
                                                                            <option value="category" <?php
                                                                        if ($_GET['type'] == 'category')
                                                                        {
                                                                            echo "selected";
                                                                        }
    ?>>Category</option>
                                                                            <option value="wholesalers" <?php
                                                                                if ($_GET['type'] == 'wholesalers')
                                                                                {
                                                                                    echo "selected";
                                                                                }
                                                                                ?>>Wholesalers</option>
                                                                            <option value="packages" <?php
                                                                                if ($_GET['type'] == 'packages')
                                                                                {
                                                                                    echo "selected";
                                                                                }
    ?>>Packages</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="uploadType" id="product" <?php
                                                            if (isset($_GET['type']) && $_GET['type'] == 'product')
                                                            {
                                                                echo 'style=display:block';
                                                            }
                                                            else
                                                            {
                                                                echo 'style=display:none';
                                                            }
                                                            ?>>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Choose fields: </label>
                                                                        <div class="controls">
                                                                            <div style="float: right;"><small><?php echo DOWNLOAD; ?>: <a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/product_uploads.csv"><?php echo CSV_SAM; ?></a>&nbsp;&nbsp;<a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/product_uploads.xls"><?php echo XLS_SAM; ?></a></small></div>
                                                                            <input type="checkbox" id="checkAllProduct" />CheckAll<br/><br/><br/>
                                                                            <input name="fields[]" id="field1" req="yes" type="checkbox" value="ProductRefNo" type="checkbox" class="styled requiredUploadFields"/>Product Ref No<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="yes" type="checkbox" value="ProductName" class="styled requiredUploadFields"/>Product Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="yes" type="checkbox" value="fkWholesalerID" class="styled requiredUploadFields"/>Company Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="yes" type="checkbox" value="WholesalePrice" class="styled requiredUploadFields"/>Wholesale Price<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" type="checkbox" value="DiscountPrice" class="styled"/>Discount Price<br /><br />
                                                                            <input name="fields[]" req="yes" type="checkbox" value="fkCategoryID" class="styled requiredUploadFields"/>Category<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="yes" type="checkbox" value="fkShippingID" class="styled requiredUploadFields"/>Shipping Method<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="yes" type="checkbox" value="Quantity" class="styled requiredUploadFields"/>Stock Quanity<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="yes" type="checkbox" value="QuantityAlert" class="styled requiredUploadFields"/>Aleret on Quanity<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" type="checkbox" value="DimensionUnit" class="styled"/>Dimension Unit<br /><br />
                                                                            <input name="fields[]" type="checkbox" value="Length" class="styled"/>Length<br /><br />
                                                                            <input name="fields[]" type="checkbox" value="Height" class="styled"/>Width<br /><br />
                                                                            <input name="fields[]" type="checkbox" value="Width" class="styled"/>Height<br /><br />
                                                                            <input name="fields[]" type="checkbox" value="WeightUnit" class="styled"/>Weight Unit<br /><br />
                                                                            <input name="fields[]" type="checkbox" value="Weight" class="styled"/>Weight<br /><br />
                                                                            <input name="fields[]" type="checkbox" value="Attribute" class="styled requiredUploadFields" />Attributes options, options price and option images<span class="req">* (Ex: Attributes should be:: AttrCode1#Opt1=price1=img1|Opt2=price2=img2;AttrCode2#Opt1=price1|Opt2=price2)</span><br /><br />
                                                                            <input name="fields[]" type="checkbox" value="AttributeInventory" class="styled requiredUploadFields" />Attributes Inventory<span class="req">* (Ex: should be:: AttrCode1#Opt1|AttrCode2#Opt1=qty1;AttrCode1#Opt1|AttrCode2#Opt2=qty2;AttrCode1#Opt2|AttrCode2#Opt1=qty3;AttrCode1#Opt2|AttrCode2#Opt2=qty4)</span><br /><br />
                                                                            <input name="fields[]" type="checkbox" value="ProductDescription" class="styled"/>Product Description<br /><br />
                                                                            <input name="fields[]" type="checkbox" value="ProductTerms" class="styled"/>Product Terms<br /><br />
                                                                            <input name="fields[]" type="checkbox" value="YoutubeCode" class="styled"/>Youtube Code<br /><br />
                                                                            <input name="fields[]" type="checkbox" value="HtmlEditor" class="styled"/>More Details<br /><br />
                                                                            <input name="fields[]" req="yes" type="checkbox" value="ProductImage" class="styled"/>Default Image (600x600)<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" type="checkbox" value="ImageName" class="styled"/>Product Images (600x600)<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="MetaTitle" class="styled"/>Meta Title<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="MetaKeywords" class="styled"/>Meta Keyword<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="MetaDescription" class="styled"/>Meta Description<br /><br />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="uploadType" id="wholesalers" <?php
                                                            if (isset($_GET['type']) && $_GET['type'] == 'wholesalers')
                                                            {
                                                                echo 'style=display:block';
                                                            }
                                                            else
                                                            {
                                                                echo 'style=display:none';
                                                            }
                                                            ?>>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Choose fields: </label>
                                                                        <div class="controls">
                                                                            <div style="float: right;"><small><?php echo DOWNLOAD; ?>: <a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/wholesaler_uploads.csv" ><?php echo CSV_SAM; ?></a>&nbsp;&nbsp;<a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/wholesaler_uploads.xls" ><?php echo XLS_SAM; ?></a></small></div>
                                                                            <input type="checkbox" id="checkAllWholesaler" />CheckAll<br/><br/><br/>
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyName" class="styled requiredUploadFields"/>Company Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="AboutCompany" class="styled requiredUploadFields"/>About Company<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Services" class="styled"/>Services<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Commission" class="styled requiredUploadFields"/>Commission<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyAddress1" class="styled requiredUploadFields"/>Company Address1<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyAddress2" class="styled requiredUploadFields"/>Company Address2<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyCity" class="styled requiredUploadFields"/>Company City<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyCountry" class="styled requiredUploadFields"/>Company Country<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyRegion" class="styled"/>Company Region<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyPostalCode" class="styled requiredUploadFields"/>Company Postal Code<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyWebsite" class="styled requiredUploadFields"/>Company Website<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyEmail" class="styled requiredUploadFields"/>Company Email<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="PaypalEmail" class="styled requiredUploadFields"/>Paypal Email<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyPhone" class="styled requiredUploadFields"/>Company Phone<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CompanyFax" class="styled requiredUploadFields"/>Company Fax<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt1CompanyAddress1" class="styled"/>Optional Company Address1<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt1CompanyAddress2" class="styled"/>Optional Company Address2<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt1CompanyCity" class="styled"/>Opt1CompanyCity<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt1CompanyCountry" class="styled"/>Opt1CompanyCountry<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt1CompanyPostalCode" class="styled"/>Opt1CompanyPostalCode<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt1CompanyWebsite" class="styled"/>Opt1CompanyWebsite<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt1CompanyEmail" class="styled"/>Opt1CompanyEmail<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt1Companyphone" class="styled"/>Opt1Companyphone<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt1CompanyFax" class="styled"/>Opt1CompanyFax<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt2CompanyAddress1" class="styled"/>Opt2CompanyAddress1<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt2CompanyAddress2" class="styled"/>Opt2CompanyAddress2<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt2CompanyCity" class="styled"/>Opt2CompanyCity<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt2CompanyCountry" class="styled"/>Opt2CompanyCountry<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt2CompanyPostalCode" class="styled"/>Opt2CompanyPostalCode<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt2CompanyWebsite" class="styled"/>Opt2CompanyWebsite<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt2CompanyEmail" class="styled"/>Opt2CompanyEmail<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt2Companyphone" class="styled"/>Opt2Companyphone<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Opt2CompanyFax" class="styled"/>Opt2CompanyFax<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ContactPersonName" class="styled  requiredUploadFields"/>ContactPersonName<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ContactPersonPosition" class="styled requiredUploadFields"/>ContactPersonPosition<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ContactPersonPhone" class="styled requiredUploadFields"/>ContactPersonPhone<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ContactPersonEmail" class="styled requiredUploadFields"/>ContactPersonEmail<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ContactPersonAddress" class="styled requiredUploadFields"/>ContactPersonAddress<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="OwnerName" class="styled requiredUploadFields"/>OwnerName<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="OwnerPhone" class="styled requiredUploadFields"/>OwnerPhone<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="OwnerEmail" class="styled requiredUploadFields"/>OwnerEmail<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="OwnerAddress" class="styled requiredUploadFields"/>OwnerAddress<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref1Name" class="styled requiredUploadFields"/>Ref1Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref1Phone" class="styled requiredUploadFields"/>Ref1Phone<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref1Email" class="styled requiredUploadFields"/>Ref1Email<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref1CompanyName" class="styled requiredUploadFields"/>Ref1CompanyName<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref1CompanyAddress" class="styled requiredUploadFields"/>Ref1CompanyAddress<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref2Name" class="styled requiredUploadFields"/>Ref2Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref2Phone" class="styled requiredUploadFields"/>Ref2Phone<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref2Email" class="styled requiredUploadFields"/>Ref2Email<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref2CompanyName" class="styled requiredUploadFields"/>Ref2CompanyName<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref2CompanyAddress" class="styled requiredUploadFields"/>Ref2CompanyAddress<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref3Name" class="styled requiredUploadFields"/>Ref3Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref3Phone" class="styled requiredUploadFields"/>Ref3Phone<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref3Email" class="styled requiredUploadFields"/>Ref3Email<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref3CompanyName" class="styled requiredUploadFields"/>Ref3CompanyName<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="Ref3CompanyAddress" class="styled requiredUploadFields"/>Ref3CompanyAddress<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="shippingMethod" class="styled requiredUploadFields"/>Shipping Method<span class="req">*</span><br /><br />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="uploadType" id="category" <?php
                                                            if (isset($_GET['type']) && $_GET['type'] == 'category')
                                                            {
                                                                echo 'style=display:block';
                                                            }
                                                            else
                                                            {
                                                                echo 'style=display:none';
                                                            }
                                                            ?>>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Choose fields: </label>
                                                                        <div class="controls">
                                                                            <div style="float: right;"><small><?php echo DOWNLOAD; ?>: <a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/category_uploads.csv" ><?php echo CSV_SAM; ?></a>&nbsp;&nbsp;<a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/category_uploads.xls" ><?php echo XLS_SAM; ?></a></small></div>
                                                                            <input type="checkbox" id="checkAllCategory" />CheckAll<br/><br/><br/>
                                                                            <input name="fields[]" req="no" type="checkbox" value="CategoryName" class="styled requiredUploadFields"/>Category Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CategoryDescription" class="styled"/>Description<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="parentCategory1" class="styled"/>Parent Category1<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="parentCategory2" class="styled"/>Parent Category2<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="parentCategory3" class="styled"/>Parent Category3<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CategoryOrdering" class="styled"/>Menu Display Order<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CategoryMetaTitle" class="styled"/>Category Meta Title<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CategoryMetaKeywords" class="styled"/>Category Meta Keyword<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CategoryMetaDescription" class="styled"/>Category Meta Description<br /><br />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="uploadType" id="customers" <?php
                                                            if (isset($_GET['type']) && $_GET['type'] == 'customers')
                                                            {
                                                                echo 'style=display:block';
                                                            }
                                                            else
                                                            {
                                                                echo 'style=display:none';
                                                            }
                                                            ?>>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Choose fields: </label>
                                                                        <div class="controls">
                                                                            <div style="float: right;"><small><?php echo DOWNLOAD; ?>: <a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/customer_uploads.csv" ><?php echo CSV_SAM; ?></a>&nbsp;&nbsp;<a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/customer_uploads.xls" ><?php echo XLS_SAM; ?></a></small></div>
                                                                            <input type="checkbox" id="checkAllCustomers" />CheckAll<br/><br/><br/>
                                                                            <input name="fields[]" req="no" type="checkbox" value="CustomerFirstName" class="styled requiredUploadFields"/>Customer First Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CustomerLastName" class="styled"/>Customer Last Name<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CustomerEmail" class="styled requiredUploadFields"/>Customer Email<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CustomerPassword" class="styled requiredUploadFields"/>Customer Password<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ResAddressLine1" class="styled requiredUploadFields"/>Residential Address Line1<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ResAddressLine2" class="styled"/>Residential Address Line2<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ResTown" class="styled"/>Residential Town<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ResCountry" class="styled requiredUploadFields"/>Residential Country<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ResPostalCode" class="styled requiredUploadFields"/>Residential Postal Code<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ResPhone" class="styled requiredUploadFields"/>Residential Phone<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="BillingFirstName" class="styled requiredUploadFields"/>Billing First Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="BillingLastName" class="styled"/>Billing Last Name<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="BillingOrganizationName" class="styled requiredUploadFields"/>Billing Organization Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="BillingAddressLine1" class="styled requiredUploadFields"/>Billing Address Line1<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="BillingAddressLine2" class="styled"/>Billing Address Line2<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="BillingTown" class="styled"/>Billing Town<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="BillingCountry" class="styled requiredUploadFields"/>Billing Country<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="BillingPostalCode" class="styled requiredUploadFields"/>Billing Postal Code<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="BillingPhone" class="styled requiredUploadFields"/>Billing Phone<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ShippingFirstName" class="styled requiredUploadFields"/>Shipping First Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ShippingLastName" class="styled"/>Shipping Last Name<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ShippingOrganizationName" class="styled"/>Shipping Organization Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ShippingAddressLine1" class="styled requiredUploadFields"/>Shipping Address Line1<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ShippingAddressLine2" class="styled"/>Shipping Address Line2<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ShippingTown" class="styled"/>Shipping Town<br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ShippingCountry" class="styled requiredUploadFields"/>Shipping Country<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ShippingPostalCode" class="styled requiredUploadFields"/>Shipping Postal Code<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ShippingPhone" class="styled requiredUploadFields"/>Shipping Phone<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="BusinessAddress" class="styled requiredUploadFields"/>Business Address<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="CustomerStatus" class="styled requiredUploadFields"/>Customer Status<span class="req">*</span><br /><br />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="uploadType" id="packages" <?php
                                                            if (isset($_GET['type']) && $_GET['type'] == 'packages')
                                                            {
                                                                echo 'style=display:block';
                                                            }
                                                            else
                                                            {
                                                                echo 'style=display:none';
                                                            }
                                                            ?>>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Choose fields: </label>
                                                                        <div class="controls">
                                                                            <div style="float: right;"><small><?php echo DOWNLOAD; ?>: <a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/package_uploads.csv" ><?php echo CSV_SAM; ?></a>&nbsp;&nbsp;<a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/package_uploads.xls" ><?php echo XLS_SAM; ?></a></small></div>
                                                                            <input type="checkbox" id="checkAllPackages" />CheckAll<br/><br/><br/>
                                                                            <input name="fields[]" req="no" type="checkbox" value="PackageName" class="styled requiredUploadFields"/>Package Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="fkWholesalerID" class="styled requiredUploadFields"/>Wholesaler Name<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="PackagePrice" class="styled requiredUploadFields"/>Package Price<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="PackageImage" class="styled requiredUploadFields"/>Package Image<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ProductsReferenceNumbers" class="styled requiredUploadFields"/>Products Reference Number<span class="req">*</span><br /><br />
                                                                            <input name="fields[]" req="no" type="checkbox" value="ProductAttribute" class="styled"/><small><span>Product Attribute</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <div class="controls">
                                                                        <strong>Browse XLS or CSV <span class="req">*</span></strong><br />
                                                                        <input type="file" name="frmFile" id="frmFile" /><br /><br />
                                                                        <div id="productImageZip" style="display:none;">
                                                                            <strong>Please upload a zip file of images <span class="req">*</span></strong>
                                                                            <br/><input type="file" name="frmImages" id="frmImages" /><br /><br />
                                                                        </div>
                                                                        <div id="packageImageZip" <?php
                                                                    if (isset($_GET['type']) && (($_GET['type'] == 'product') || ($_GET['type'] == 'customers') || ($_GET['type'] == 'wholesalers') || ($_GET['type'] == 'packages')))
                                                                    {
                                                                        echo 'style=display:block';
                                                                    }
                                                                    else
                                                                    {
                                                                        echo 'style=display:none';
                                                                    }
                                                                    ?>>
                                                                            <strong>Please upload a zip file of images <span class="req">*</span></strong>
                                                                            <br/><input type="file" name="frmPackageImages" id="frmPackageImages" /><br /><br />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="note">Note : * Data in CSV file must be separated by comma (,). [For example:- <span class="req">"Company Name","Company Details"</span>]</div>
                                                                <div class="note">Note : * Product or Package images must be inside the zip file and names of images must be in the CSV or XLS file [<a href="<?php echo UPLOADED_FILES_URL; ?>files/bulk_upload_sample/telamela.zip">sample</a>]</div>
                                                                <div class="note">Note : * Indicates mandatory fields.</div>
                                                                <div class="form-actions">
                                                                    <button name="btnPage" type="submit" class="btn btn-blue" style="width:80px;"  value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                    <a id="buttonDecoration" href="bulk_upload_uil.php"><button name="frmCancel" type="button" value="Cancel" style="width:80px;"  class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>
                                                                    <input type="hidden" name="frmHidenUpload" value="Upload" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

<?php }
else
{ ?> 
                        <table width="100%">
                            <tr>
                                <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                            <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                        </table>

<?php }
?>


                </div>
            </div>

<?php require_once('inc/footer.inc.php'); ?>
        </div>

    </body>
</html>
