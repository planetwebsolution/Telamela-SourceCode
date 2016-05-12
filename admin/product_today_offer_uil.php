<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CMS_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Offer</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script type="text/javascript">
            function showCurrentPrice(str){   //alert(str);     
                //var p = new Array();
                var p = [];
                if(str==0){
                    p[0] = '0';
                    p[1] = '0.0000';            
                }else{
                    p = str.split('vss');
                }
                //alert(p[1]);
                var str = p[1].toString();
                document.getElementById('currentPrice').innerHTML = str;
                document.getElementById('frmOfferPrice').value="";
            } 
    
            function validateProductOffer(){
                //var RegDecimal = /^[-+]?[0-9]+(\.[0-9]+)?$/;
                var RegDecimal = /^[0-9]+(\.[0-9]+)?$/;
                var frmWholesaler = document.getElementById('frmWholesaler');
                var frmProductId = document.getElementById('frmProductId');
                var frmOfferPrice = document.getElementById('frmOfferPrice');
        
                if(frmWholesaler.value==0 || frmWholesaler.value==''){
                    alert('Please select Wholesaler !');
                    frmWholesaler.focus();
                    return false;            
                }else if(frmProductId.value==0 || frmProductId.value==''){
                    alert('Please select Product !');
                    frmProductId.focus();
                    return false;
            
                }else if(frmOfferPrice.value==''){
                    alert('Please enter offer Price !');
                    frmOfferPrice.focus(); 
                    return false;
                }else if(!RegDecimal.test(frmOfferPrice.value)){
                    alert('Please enter Numeric or Decimal Value !');
                    frmOfferPrice.select();
                    return false;            
                }else if(frmOfferPrice.value !='')
                {
                    var offerPrice=parseFloat(frmOfferPrice.value).toFixed(2);
                    //alert($('#currentPrice').html()+'=='+offerPrice);
                    if(parseFloat($('#currentPrice').html()) <= offerPrice)
                    {
                        alert('Offer price can not be greater then Current price !');
                        return false;
                    }
                }
        
            }
    
            function ajaxWhosaler(id){
        
                var t = 'fkWholesalerID='+id+'&action=getAjaxProductDetails';
                var data = t;
    
                $.ajax({type: "POST",cache: false,url: 'ajax.php',data: data,success: function(data){
                        $('#frmProductId').html(data);
                    }
                });        
            }    
        </script>
    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>


        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Manage Offer</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="coupon_manage_uil.php">Discount</a><i class="icon-angle-right"></i></li>
                            <li><span>Manage Offer</span></li>
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
<?php //<a id="buttonDecoration" href="category_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; </a> ?>
                                                <h3>
                                                    Manage Offer
                                                </h3>                                                            
                                            </div>

                                            <div class="box-content nopadding"> 

<?php require_once('javascript_disable_message.php'); ?>


<?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-cms', $_SESSION['sessAdminPerMission']))
{ ?>  

                                                    <form action=""  method="post" id="frm_page" onsubmit="return validateProductOffer();" >
                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Wholesaler List:   </label>
                                                                    <div class="controls">
                                                                        <select name="frmWholesaler" id="frmWholesaler" onchange="return ajaxWhosaler(this.value);" class='select2-me input-large'>
                                                                            <option value="">Select Wholesaler</option>

                                                                            <?php
                                                                            foreach ($objPage->varWholesalerList as $valWholesalerList)
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $valWholesalerList['pkWholesalerID']; ?>" <?php
                                                                        if ($valWholesalerList['pkWholesalerID'] == $objPage->arrOffer[1][0]['fkWholesalerID'])
                                                                        {
                                                                            echo 'selected="selected"';
                                                                        };
                                                                        ?>><?php echo $valWholesalerList['CompanyName']; ?></option>
    <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Choose Product: </label>
                                                                    <div class="controls" id="ShowProducts">
                                                                        <select name="frmProductId" id="frmProductId" onchange="showCurrentPrice(this.value);" class='select2-me input-large'>
                                                                            <option value="0">Select Product</option>
                                                                            <?php foreach ($objPage->arrProduct as $key => $value)
                                                                            { ?>
                                                                                <option value="<?php echo $value['pkProductID'] . 'vss' . $value['FinalPrice'] .'vss' . $value['DiscountFinalPrice']; ?>" <?php
                                                                                if ($value['pkProductID'] == $objPage->arrOffer[0]['fkProductId'])
                                                                                {
                                                                                    echo 'selected=selected';
                                                                                }
                                                                                ?>><?php echo $value['ProductName']; ?></option>        
    <?php } ?>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Current Price( in USD):  </label>
                                                                    <div class="controls">
                                                                        $ <span id="currentPrice"><?php echo $objCore->price_format($objPage->arrOffer[0]['CurrentPrice']); ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">*Offer Price( in USD):<br>Note:<span style="font-size:11px;">Offer price should include margin price also</span></label>
                                                                    <div class="controls">

                                                                        $<input name="frmOfferPrice" id="frmOfferPrice" type="text" value="<?php echo number_format($objPage->arrOffer[0]['OfferPrice'], 2, '.', ''); ?>" class="input-large" />

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">Description:</label>
                                                                    <div class="controls">
                                                                        <textarea maxlength="28" name="frmDescription" rows="2" class="input-block-level"><?php echo $objPage->arrOffer[0]['Description']; ?></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="note">Note : * Indicates mandatory fields.</div>
                                                                <div class="form-actions">
                                                                    <input type="submit" class="btn btn-blue" name="btnPage" value="Update"/>
                                                                    <a id="buttonDecoration" href="coupon_manage_uil.php">
                                                                        <input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" /></a>
                                                                    <input type="hidden" name="frmHidenOffer" value="offer" />

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
