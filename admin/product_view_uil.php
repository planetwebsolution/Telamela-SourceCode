<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PRODUCT_CTRL;
$varNum = count($objPage->arrRow['0']['pkProductID']);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Product Edit</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css"  rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <script>
            $(document).ready(function(){
                $('#cancel').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            });
            function jscall(){
                $(".delete").colorbox({inline:true, width:"650px", height:"530px"});
                $('#cancel').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmDelete').click(function(){
                    var frmPackageName = document.getElementById('frmPackageName');
                    var frmWholesalerId = document.getElementById('frmWholesalerId');
                    var frmCategoryId = document.getElementsByName('frmCategoryId[]');
                    var frmProductId = document.getElementsByName('frmProductId[]');
                    var frmOfferPrice = document.getElementById('frmOfferPrice');

                    //   alert();

                    if(frmPackageName.value==''){
                        alert('Package Name is Required!');
                        frmPackageName.focus();
                        return false;
                    } if(frmWholesalerId.value=='0'){
                        alert('Please Select wholesaler!');
                        frmWholesalerId.focus();
                        return false;
                    }

                    for (var i = 0; i < frmCategoryId.length; i++) {

                        if(frmCategoryId[i].value==0){
                            alert('Please Select Category!');
                            frmCategoryId[i].focus();
                            return false;
                        }else if(frmProductId[i].value==0){
                            alert('Please Select Product!');
                            frmProductId[i].focus();
                            return false;
                        }
                    }

                    if(frmOfferPrice.value==''){
                        alert('Offer Price is Required!');
                        frmOfferPrice.focus();
                        return false;
                    }else if(AcceptDecimal(frmOfferPrice.value)==false){
                        alert("Please Enter numeric or decimal value!");
                        frmOfferPrice.focus();
                        return false;
                    }

                    var proids = '';
                    for (var i = 0; i < frmProductId.length; i++) {
                        proids = proids+'-vss-'+frmProductId[i].value;
                    }
                    $.post("ajax.php",{action:'AddPackage',pkgnm:frmPackageName.value,whid:frmWholesalerId.value,pids:proids,offerprice:frmOfferPrice.value},
                    function(data)
                    {
                        $('#packages').html(data);
                    }
                );
                    parent.jQuery.fn.colorbox.close();

                });
            }
        </script>
        <script type="text/javascript">
            $(function() {
                var addDiv = $('#addinput');
                var i = $('#addinput p').size() + 1;

                $('#addNew').live('click', function() {
                    $('#addinput p span').html('');
                    $('<p>Image'+i+' <input type="file" name="frmProductImg['+i+']" value="" class="prod_img"/><input type="hidden" name="image_error" value="0" class="image_error" id="image_error'+i+'"><span>&nbsp;<a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></p>').appendTo(addDiv);
                    i++;
                    return false;
                });

                $('#remNew').live('click', function() {
                    if( i > 2 ) {
                        $(this).parents('p').remove();
                        i--;
                        $("#addinput p:last span").html('<span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>');

                    }
                    return false;
                });
            });
        </script>
        <script type="text/javascript">
            function hideInputType(Id){
                document.getElementById(Id).innerHTML = '';
            }
        </script>
        <script type="text/javascript">
            function ShowWholesaler(str) {

                $.post("ajax.php",{action:'ShowWholesaler',ctid:str},
                function(data)
                {
                    $('#frmfkWholesalerID').html(data);
                }
            );
            }

            function ShowWholesalerShippingGateway(str) {
                if(str=='0' || str==''){
                    $('#shippingGateways').html('Please Select Wholesaler');
                }else{
                    $.post("ajax.php",{action:'ShowWholesalerShippingGateway',wid:str},
                    function(data){
                        $('#shippingGateways').html(data);
                    });
                }
            }
        </script>
        <script type="text/javascript">
            function showPackageProduct(str) {
                $('#showPackageProduct').css('display', 'none');
                if(str==0){
                    $('#showPackageProduct').html('');
                    $('#shwhde').html('');
                    return;
                }
                $('#shwhde').html('Please wait...');
                $.post("ajax.php",{action:'showPackageProduct',pkgid:str},
                function(data)
                {
                    $('#showPackageProduct').html(data);
                    $('#shwhde').html(' <a href="javascript:void(0)" onclick="showPkgDet()">Show Package Detail</a>');
                }
            );
            }
        </script>
        <script type="text/javascript">
            var MAX_PRODUCT_IMAGE_SIZE = '<?php echo MAX_PRODUCT_IMAGE_SIZE; ?>';
            var MIN_PRODUCT_IMAGE_WIDTH = '<?php echo MIN_PRODUCT_IMAGE_WIDTH; ?>';
            var MIN_PRODUCT_IMAGE_HEIGHT = '<?php echo MIN_PRODUCT_IMAGE_HEIGHT; ?>';
            var MAX_PRODUCT_IMAGE_WIDTH = '<?php echo MAX_PRODUCT_IMAGE_WIDTH; ?>';
            var MAX_PRODUCT_IMAGE_HEIGHT = '<?php echo MAX_PRODUCT_IMAGE_HEIGHT; ?>';

            var MIN_PRODUCT_SLIDER_IMAGE_WIDTH = '<?php echo MIN_PRODUCT_SLIDER_IMAGE_WIDTH; ?>';
            var MIN_PRODUCT_SLIDER_IMAGE_HEIGHT = '<?php echo MIN_PRODUCT_SLIDER_IMAGE_HEIGHT; ?>';
            var MIN_PRODUCT_DETAIL_IMAGE_HEIGHT = '<?php echo MIN_PRODUCT_DETAIL_IMAGE_HEIGHT; ?>';
            var url = window.URL || window.webkitURL;
            //var prod_img = document.getElementsByClassName("prod_img");
            $(document).ready(function(){
                $('.prod_img').live('change',function(){
                    var dd = $(this);
                    var name = dd.attr('name');
                    if( this.disabled ){
                        alert('Your browser does not support File upload.');
                    }else{
                        var chosen = this.files[0];
                        var image = new Image();
                        image.onload = function() {
                            if(name=='frmProductSliderImg' && (this.width < MIN_PRODUCT_SLIDER_IMAGE_WIDTH || this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE) ){
                                alert('Please upload image in between ('+MIN_PRODUCT_SLIDER_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
                                dd.parent().find('.image_error').val('0');
                                this.focus();

                            } else if (name=='frmProductDefaultImg' && (this.width < MIN_PRODUCT_IMAGE_WIDTH || this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE)){
                                alert('Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
                                dd.parent().find('.image_error').val('0');
                                this.focus();
                                //$('#image_error').val(parseInt($('#image_error').val())+1);
                                //return false;
                            }else if (name.substr(0,13)=='frmProductImg' && (this.width < MIN_PRODUCT_IMAGE_WIDTH || this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE)){
                                alert('Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
                                dd.parent().find('.image_error').val('0');
                                this.focus();
                                //$('#image_error').val(parseInt($('#image_error').val())+1);
                                //return false;
                            }
                            else
                            {
                                dd.parent().find('.image_error').val('1');
                            }
                        };
                        image.onerror = function() {
                            alert('Not a valid file type: '+ chosen.type);
                            dd.parent().find('.image_error').val('0');
                        };
                        image.src = url.createObjectURL(chosen);
                    }

                });
            });
        </script>
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php';
       //  pre($objPage->arrRow[0]);
        ?>

        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>View- Product</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="catalog_manage_uil.php">Catalog</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="product_manage_uil.php">Manage Product</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <span>view - Product</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <?php
                            if ($objCore->displaySessMsg() <> '')
                            {
                                echo $objCore->displaySessMsg();

                                $objCore->setSuccessMsg('');
                                $objCore->setErrorMsg('');
                            }
                           
                            ?>
                            <div class="tab-pane active" id="tabs-2">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="box box-color box-bordered">
                                            <div class="box-title">
                                                <h3>View - Product</h3>
                                            </div>
                                            <div class="box-content nopadding">
                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php
                                                if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-products', $_SESSION['sessAdminPerMission']))
                                                {
                                                    ?>
                                                    <?php $httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER']; ?>
                                                    <?php
                                                    if ($varNum > 0)
                                                    {
                                                        ?>
                                                        <form action=""  method="post" id="frm_page" onsubmit="return validateProductAddForm(this);" enctype="multipart/form-data" >
                                                            <div class="span8 form-horizontal form-bordered">
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Product Name:</label>
                                                                    <div class="controls">
                                                                        <?php echo $objPage->arrRow[0]['ProductName']; ?>
                                                                    </div>
                                                                </div><div class="control-group">
                                                                    <label for="textfield" class="control-label">Product Ref No:</label>
                                                                    <div class="controls">
                                                                        <?php echo $objPage->arrRow['0']['ProductRefNo']; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Wholesaler Name:</label>
                                                                    <div class="controls">
                                                                        <?php echo $objPage->arrRow['0']['CompanyName']; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Stock Quantity:</label>
                                                                    <div class="controls">
                                                                        <?php echo $objPage->arrRow['0']['Quantity']; ?>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="span4 form-vertical form-bordered right-side">

                                                                <div class="control-group">
                                                                    <div class="controls">
                                                                        <strong>Stock Quantity:</strong> &nbsp;<?php
                                                                echo $objPage->arrRow['0']['Quantity'];
                                                                echo '<br />In Stock&nbsp;&nbsp;';
                                                                if ($objPage->arrRow['0']['Quantity'] > 0)
                                                                {
                                                                    echo 'Yes';
                                                                }
                                                                else
                                                                {
                                                                    echo 'No';
                                                                }
                                                                        ?>
                                                                        <br /><strong>Product Status:</strong> &nbsp;<?php
                                                                if ($objPage->arrRow['0']['ProductStatus'] == 1)
                                                                {
                                                                    echo 'Active';
                                                                }
                                                                else
                                                                {
                                                                    echo 'Deactive';
                                                                }
                                                                        ?>
                                                                        <?php
                                                                        if ($objPage->arrRow[0]['IsFeatured'] == 1)
                                                                        {
                                                                            ?>
                                                                            <?php
                                                                            $varDateStart = $objCore->localDateTime($objPage->arrRow['0']['DateStart'], DATE_FORMAT_SITE);
                                                                            $varDateEnd = $objCore->localDateTime($objPage->arrRow['0']['DateEnd'], DATE_FORMAT_SITE);
                                                                            echo '<br /><strong>From:</strong> ' . $varDateStart . ' <strong>To:</strong> ' . $varDateEnd;
                                                                            ?>
                                                                            <br />
                                                                            <span class="green">Featured Product</span> <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <div class="controls">
                                                                        <strong>Last Update:</strong> <?php echo $objPage->arrRow['0']['ProductDateUpdated'] != '0000-00-00 00:00:00' ? date(DATE_TIME_FORMAT_SITE, strtotime($objPage->arrRow['0']['ProductDateUpdated'])) : ''; ?>
                                                                        <br />
                                                                        <b>Created By:</b> <?php echo $objPage->arrRow['0']['CreatedByName']; ?>
                                                                        <br />
                                                                        <b>Updated By:</b> <?php echo $objPage->arrRow['0']['UpdatedByName']; ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row-fluid">
                                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                    <div class="box-title nomargin"><h3>&nbsp;</h3></div>


                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Category:</label>
                                                                        <div class="controls">
                                                                            <?php
                                                                            //echo $objProduct->getCategoryHierarchy($objPage->arrRow['0']['CategoryHierarchy']);
                                                                            echo $objPage->arrRow['0']['CategoryName'];
                                                                            ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Attribute:</label>
                                                                        <div class="controls">
                                                                            <?php
                                                                            foreach ($objPage->arrRow['0']['productAttribute'] as $keyAttr => $valueAttr)
                                                                            {

                                                                                echo '<p><b>' . $valueAttr['AttributeLabel'] . '</b>: ';
                                                                                if ($valueAttr['AttributeInputType'] == 'input' || $valueAttr['AttributeInputType'] == 'textarea')
                                                                                {
                                                                                    echo $valueAttr['AttributeOptionValue'];
                                                                                }
                                                                                else if ($valueAttr['AttributeInputType'] == 'image')
                                                                                {
                                                                                    echo '<br/>';
                                                                                    $imgAttr = explode(',', $valueAttr['AttributeOptionImage']);
                                                                                    foreach ($imgAttr as $vopt)
                                                                                    {
                                                                                        echo (!empty($vopt)) ? '<img width="35px" height="35px" src="' . $objCore->getImageUrl($vopt, 'products/' . $arrProductImageResizes['default']) . '" title="' . $valueAttr['OptionTitle'] . '" /> ': '';
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo $valueAttr['OptionTitle'];
                                                                                }
                                                                                echo '</p>';
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Weight:</label>
                                                                        <div class="controls">
                                                                            <?php echo $objPage->arrRow['0']['Weight'] . ' ' . $objPage->arrRow['0']['WeightUnit']; ?>
                                                                        </div>
                                                                    </div>


                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Dimensions (L x W x H):</label>
                                                                        <div class="controls">
                                                                            <?php echo $objPage->arrRow['0']['Length'] . ' x ' . $objPage->arrRow['0']['Width'] . ' x ' . $objPage->arrRow['0']['Height'] . ' (  ' . $objPage->arrRow['0']['DimensionUnit'] . ' )'; ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Wholesale Price/Final Product Price:</label>
                                                                        <div class="controls">
                                                                            <?php echo ADMIN_CURRENCY_SYMBOL . $objCore->price_format($objPage->arrRow['0']['WholesalePrice']); ?> /  <?php echo ADMIN_CURRENCY_SYMBOL . $objCore->price_format($objPage->arrRow['0']['FinalPrice']); ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Discount Price:</label>
                                                                        <div class="controls">
                                                                            <?php echo ADMIN_CURRENCY_SYMBOL . $objCore->price_format($objPage->arrRow['0']['DiscountPrice']); ?> / <?php echo ADMIN_CURRENCY_SYMBOL . $objCore->price_format($objPage->arrRow['0']['DiscountFinalPrice'], 2); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Shipping Gateway:</label>
                                                                        <div class="controls">
                                                                            <div id="shippingGateways">
                                                                                <?php
                                                                                $arrShipping = explode(',', $objPage->arrRow['0']['fkShippingID']);

                                                                                foreach ($objPage->arrShippingGateway as $valShipping)
                                                                                {

                                                                                    if (in_array($valShipping['pkShippingGatewaysID'], $arrShipping))
                                                                                    {
                                                                                        echo $valShipping['ShippingTitle'] . '<br/>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">Default Image (600x600):</label>
                                                                        <div class="controls">
                                                                            <a href="<?php echo UPLOADED_FILES_URL; ?>images/products/<?php echo $arrProductImageResizes['default'] ?>/<?php echo $objPage->arrRow['0']['ProductImage']; ?>" target="blank" ><img src="<?php echo UPLOADED_FILES_URL; ?>images/products/<?php echo $arrProductImageResizes['default'] ?>/<?php echo $objPage->arrRow['0']['ProductImage']; ?>" height="70" border="0" /></a><br/><br/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">Product Image (600x600):</label>
                                                                        <div class="controls">
                                                                            <?php
                                                                            foreach ($objPage->arrImageRows as $vImg)
                                                                            {
                                                                                if ($vImg['ImageName'] <> '')
                                                                                {
                                                                                    ?>
                                                                                    <?php /*<a href="<?php echo UPLOADED_FILES_URL; ?>images/products/<?php echo $arrProductImageResizes['default'] ?>/<?php echo $objPage->arrRow['0']['ImageName']; ?>" target="blank" ></a> */ ?>
                                                                                    <img src="<?php echo UPLOADED_FILES_URL; ?>images/products/<?php echo $arrProductImageResizes['default'] ?>/<?php echo $vImg['ImageName']; ?>" height="50" border="0" />
                                                                                    
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Select Package:</label>
                                                                        <div class="controls">
                                                                            <a href="package_edit_uil.php?pkgid=<?php echo $objPage->arrRow['0']['fkPackageId']; ?>&type=edit" target="blank"><?php echo $objPage->arrRow['0']['PackageName']; ?></a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">Details: <br />
                                                                            <span class="req" style="font-size: 10px;">Max 250 character</span></label>
                                                                        <div class="controls">
                                                                            <?php echo $objPage->arrRow['0']['ProductDescription']; ?>&nbsp;
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label"> Terms & Condition:</label>
                                                                        <div class="controls">
                                                                            <?php echo nl2br($objPage->arrRow['0']['ProductTerms']); ?>&nbsp;
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Youtube Embedd Code:</label>
                                                                        <div class="controls">
                                                                            <?php echo $objPage->arrRow['0']['YoutubeCode']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">  Html Editor:</label>
                                                                        <div class="controls">
                                                                            <?php echo html_entity_decode(stripslashes($objPage->arrRow['0']['HtmlEditor'])); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label"> Meta Title:</label>
                                                                        <div class="controls">
                                                                            <?php echo $objPage->arrRow[0]['MetaTitle']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">Meta Keywords:</label>
                                                                        <div class="controls">
                                                                            <?php echo $objPage->arrRow[0]['MetaKeywords']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">Meta Description:</label>
                                                                        <div class="controls">
                                                                            <?php echo $objPage->arrRow[0]['MetaDescription']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                    <label for="textarea" class="control-label">Product Type:</label>
                                                                    <div class="controls">
                                                                        <input type="checkbox" name="dangerous" disabled="" value="dangerous" <?php echo ($objPage->arrRow[0]['productdangerous'] == 'dangerous') ? 'checked' : ''; ?>  class="a mulcountryClass">Dangerous &nbsp;&nbsp;
<!--                                                                        <input type="checkbox" name="good" value="good" class="a mulcountryClass">Good &nbsp;&nbsp;-->
                                                                        <input type="checkbox" name="fragile" disabled="" value="fragile" <?php echo ($objPage->arrRow[0]['productfragile'] == 'fragile') ? 'checked' : ''; ?> > Fragile


                                                                    </div>
                                                                </div>
                                                                    <div class="form-actions">
                                                                        <a id="buttonDecoration" href="product_edit_uil.php?type=edit&id=<?php echo $_GET['id']; ?>"><button name="btnPage" type="button" class="btn btn-blue" style="width:80px;"  value="<?php echo 'Edit'; ?>" ><?php echo 'Edit'; ?></button></a>
                                                                        <a id="buttonDecoration" href="<?php echo $httpRef; ?>"><button name="frmCancel" type="button" value="Cancel" style="width:80px;"  class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>


                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </form>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <div class="control-group">
                                                            <div class="controls" style="text-align: center;">
                                                                <?php echo ADMIN_NO_RECORD_FOUND; ?>
                                                            </div>
                                                        </div>

                                                    <?php } ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    else
                    {
                        ?>
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