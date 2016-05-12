<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CUSTOMER_CTRL;
//echo "<pre>";
//print_r($objPage);
//die;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Customer </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <style>
            .control-group{
                margin:0px;
            }
            .form-vertical.form-bordered .control-group{
                padding: 15px 20px;
            }

        </style>
        <script>
            function jscall_wishlist(id){
                $('#modal-1').show();
            }
            function jscall_cart(){
                $('#modal-2').show();
            }
            function deleteFromWishlist(pid,wishId)
            {
                $.post('<?php echo SITE_ROOT_URL; ?>common/ajax/ajax_customer.php',{pid:pid,wishId:wishId, action: "deleteFromWishlist"}, function(data){
                    if(data){
                        $('#wishlist_item'+pid).hide();
                    }
                });
            }
            function popupClose1(){

                $('#modal-1').hide();
                $('#modal-2').hide();
                return false;

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
                            <h1>View Customer</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="customer_manage_uil.php">Customer</a><i class="icon-angle-right"></i></li>
<!--                            <li><a href="customer_view_uil.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>">View Customer</a></li>-->
                            <li><span>View Customer</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('view-customers', $_SESSION['sessAdminPerMission']))
                    {
                        ?>


                        <div class="row-fluid">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <a id="buttonDecoration" href="<?php echo SITE_ROOT_URL; ?>admin/customer_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                        <h3>View Customer  </h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form action="#" method="POST">
                                            <div class="span8 form-horizontal form-bordered">
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">First Name:  </label>
                                                    <div class="controls">
                                                        <?php echo $objPage->arrRow[0]['CustomerFirstName']; ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="" class="control-label">Last Name:</label>
                                                    <div class="controls">
                                                        <?php echo $objPage->arrRow[0]['CustomerLastName']; ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="" class="control-label">  Email:</label>
                                                    <div class="controls">
                                                        <?php echo $objPage->arrRow[0]['CustomerEmail']; ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="" class="control-label">  Address Line 1: </label>
                                                    <div class="controls">
                                                        <?php echo $objPage->arrRow[0]['ResAddressLine1']; ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="" class="control-label">  Address Line 2:</label>
                                                    <div class="controls">
                                                        <?php echo $objPage->arrRow[0]['ResAddressLine2']; ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="" class="control-label">  Country:</label>
                                                    <div class="controls">
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT)
                                                        {
                                                            if ($vCT['country_id'] == $objPage->arrRow[0]['ResCountry'])
                                                            {
                                                                echo $vCT['name'];
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="" class="control-label"> Suburb/Town:</label>
                                                    <div class="controls">
                                                        <?php echo $objPage->arrRow[0]['ResTown']; ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="" class="control-label">  Zip Code:</label>
                                                    <div class="controls">
                                                        <?php echo $objPage->arrRow[0]['ResPostalCode']; ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="" class="control-label">  Phone :</label>
                                                    <div class="controls">
                                                        <?php echo $objPage->arrRow[0]['ResPhone']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="span4 form-vertical form-bordered right-side">

                                                <div class="control-group">
                                                    <div class="controls">
                                                             <!--a href="customer_order_list.php?id=<?php echo $objPage->arrRow[0]['pkCustomerID']; ?>&type=orderList">Orders made by the Customer</a-->
                                                        <a href="order_manage_uil.php?frmCustId=<?php echo $objPage->arrRow[0]['pkCustomerID'] . "&frmSearchPressed=Yes&frmDateFrom=00-00-0000&frmDateTo=00-00-0000"; ?>">Orders made by the Customer</a>

                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <a href="#savelist_details1" class="wishlist cboxElement" onclick="return jscall_wishlist()">Saved List</a>
                                                        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1()">X</button>
                                                                <h3 id="myModalLabel">Saved List</h3>
                                                            </div>
                                                            <div id='savelist_details1' style="overflow-x:hidden; overflow-y:scroll;">
                                                                <table border="1" id="colorBox_table" cellspacing=0 cellpadding=4 valign="middle" style="width:100%">
                                                                    <tr class="heading">
                                                                        <td align="center"><strong>Ref No.</strong></td>
                                                                        <td align="center"><strong>Product Name</strong></td>
                                                                        <td align="center"><strong>Price</strong></td>
                                                                        <td align="center"><strong>Action</strong></td>
                                                                    </tr>
                                                                    <?php
                                                                    if (count($objPage->wishlistItem) > 0)
                                                                    {
                                                                        foreach ($objPage->wishlistItem AS $item)
                                                                        {
                                                                            ?>
                                                                            <tr id="wishlist_item<?php echo $item['fkProductId']; ?>">
                                                                                <td align="center"><?php echo $item['ProductRefNo']; ?></td>
                                                                                <td align="center"><?php echo $item['ProductName']; ?></td>
                                                                                <td align="center">
                                                                                    <?php
                                                                                    if ($item['OfferPrice'] <> '' && $item['OfferPrice'] > 0)
                                                                                    {
                                                                                        echo $objCore->getPrice($item['OfferPrice']);
                                                                                    }
                                                                                    else if ($item['DiscountFinalPrice'] > 0)
                                                                                    {
                                                                                        echo $objCore->getPrice($item['DiscountFinalPrice']);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        echo $objCore->getPrice($item['FinalPrice']);
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td align="center"><a href="javascript:void(0);" onclick="if(confirm('Are you sure you want to delete this product from savelist?')){deleteFromWishlist('<?php echo $item['fkProductId']; ?>','<?php echo $item['pkWishlistId']; ?>');}">Delete</a></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <tr><td colspan="4" align="center">No Product in Saved list!</td></tr>
                                                                    <?php } ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <a href="product_review_manage_uil.php?id=<?php echo $objPage->arrRow[0]['pkCustomerID']; ?>">Product Reviews</a>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <a href="#cart_details1" class="cart cboxElement" onclick="return jscall_cart()">Cart</a>
                                                        <div id="modal-2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1()">X</button>
                                                                <h3 id="myModalLabel">Cart</h3>
                                                            </div>
                                                            <div id='wishlist_details1' style="overflow-x:hidden; overflow-y:scroll;height:500px;">
                                                                <div id='cart_details1' >
                                                                    <table border="1" id="colorBox_table" cellspacing=0 cellpadding=4 valign="middle" style="width:100%">
                                                                        <tr class="heading">
                                                                            <td align="center"><strong>Item</strong></td>
                                                                            <td align="center" style="width:300px"><strong>Details</strong></td>
                                                                            <td align="center"><strong>Unit Price</strong></td>
                                                                            <td align="center"><strong>Quantity</strong></td>
                                                                            <td align="center"><strong>Subtotal</strong></td>
                                                                        </tr>
                                                                        <?php
                                                                        
                                                                        if (count($objPage->cartItems) > 0)
                                                                        {
                                                                            ?>
                                                                            <?php echo html_entity_decode($objPage->cartItems[0]['CartDetails']); ?>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <tr><td colspan="4" align="center">No Product in Cart!</td></tr>
                                                                        <?php } ?>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <a href="product_manage_uil.php?id=<?php echo $objPage->arrRow[0]['pkCustomerID'] ?>&filter=d">Recently Viewed Product</a>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <a href="javascript:void(0)" style="color:#555;text-decoration: none;cursor: default;font-weight: bold">Visits on the Website</a><span>:&nbsp;&nbsp;<?php echo $objPage->arrRow[0]['CustomerWebsiteVisitCount']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <a href="javascript:void(0)" style="color:#555;text-decoration: none;cursor: default;font-weight: bold">Total Amount Spent</a><span>:&nbsp;&nbsp;<?php echo '$' . $objCore->price_format($objPage->arrRow[0]['CustomerTotalAmountSpent']); ?></span>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row-fluid">
                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                    <div class="box-title nomargin"><h3>Billing Address</h3></div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Recipient First Name:  </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['BillingFirstName']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Recipient Last Name: </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['BillingLastName']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Organization Name:  </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['BillingOrganizationName']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Address Line 1:  </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['BillingAddressLine1']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Address Line 2:  </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['BillingAddressLine2']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Country:  </label>
                                                        <div class="controls">
                                                            <?php
                                                            foreach ($objPage->arrCountryList as $vCT)
                                                            {
                                                                if ($vCT['country_id'] == $objPage->arrRow[0]['BillingCountry'])
                                                                {
                                                                    echo $vCT['name'];
                                                                }
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Post Code or Zip Code: </label>
                                                        <div class="controls">
                                                            <?php echo $objPage->arrRow[0]['BillingPostalCode']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone:  </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['BillingPhone']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <?php ($objPage->arrRow[0]['BusinessAddress'] == "billing") ? 'This is a Business Address' : '' ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                    <div class="box-title nomargin"><h3>Shipping Address</h3></div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Recipient First Name:  </label>
                                                        <div class="controls">
                                                            <?php echo $objPage->arrRow[0]['ShippingFirstName']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Recipient Last Name: </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['ShippingLastName']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Organization Name:  </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['ShippingOrganizationName']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Address Line 1:  </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['ShippingAddressLine1']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Address Line 2:  </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['ShippingAddressLine2']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Country:  </label>
                                                        <div class="controls">
                                                            <?php
                                                            foreach ($objPage->arrCountryList as $vCT)
                                                            {
                                                                if ($vCT['country_id'] == $objPage->arrRow[0]['ShippingCountry'])
                                                                {
                                                                    echo $vCT['name'];
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Post Code or Zip Code: </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['ShippingPostalCode']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone:  </label>
                                                        <div class="controls">

                                                            <?php echo $objPage->arrRow[0]['ShippingPhone']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <?php ($objPage->arrRow[0]['BusinessAddress'] == "shipping") ? 'This is a Business Address' : '' ?>
                                                        </div>
                                                    </div>

                                                    <div class="box-title nomargin"><h3>Others</h3></div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Total Purchase: </label>
                                                        <div class="controls">
                                                            <?php echo isset($objPage->arrTotalPurchase[0]['customerorder']) ? $objPage->arrTotalPurchase[0]['customerorder'] : 0; 
                                                            	/* By Krishna Gupta ( 27-10-2015 ) starts */
                                                               // pre($objPage->arrTotalPurchase);


                                                            	// if (isset($objPage->arrTotalPurchase) && ($objPage->arrTotalPurchase != '') ) {
                                                            	// 	echo $objPage->arrTotalPurchase;	
                                                            	// } else {
                                                            	// 	echo 0;	
                                                            	// }
                                                            	/* By Krishna Gupta ( 27-10-2015 ) ends */
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Total Reward Points:  </label>
                                                        <div class="controls">
                                                            <?php
                                                            //pre($objPage->arrTotalReward);
                                                            /* By Krishna Gupta ( 27-10-2015 ) starts */
                                                                    //pre($objPage);
//                                                                    if (isset($objPage->arrTotalReward[0]['point']) && ($objPage->arrTotalReward[0]['point'] != '') ) {
//                                                                            echo $objPage->arrTotalReward[0]['point'];
//                                                                    } else {
//                                                                            echo 0;
//                                                                    }
                                                            /* By Krishna Gupta ( 27-10-2015 ) ends */
	                                                           // echo isset($objPage->arrRow[0]['BalancedRewardPoints']) ? $objPage->arrRow[0]['BalancedRewardPoints'] : 0; 
	                                                            echo isset($objPage->arrTotalReward[0]['BalancedRewardPoints']) ? $objPage->arrTotalReward[0]['BalancedRewardPoints'] : 0; 
                                                            ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </form>
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

