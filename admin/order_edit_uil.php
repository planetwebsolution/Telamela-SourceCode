<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ORDER_CTRL;

$arrOrder = $objPage->arrRow['arrOrder'][0];
$arrCountryList = $objPage->arrRow['arrCountryList'];
$arrOrderItem = $objPage->arrRow['arrOrderItems'];
$arrOrderComment = $objPage->arrRow['arrOrderComments'];
$arrOrderTotal = $objPage->arrRow['arrOrderTotal'];
$httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER'];
$varNum = count($arrOrder);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Edit Orders</title>

        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript">
            function hideItem(id) {
                $('#IsRemoved' + id).val('1');
                $('#tr' + id).hide();
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
                            <h1>Edit Orders</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="order_manage_uil.php">Orders</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
<!--                                <a href="order_edit_uil.php?type=edit&soid=<?php echo $_GET['soid']; ?>">Edit Orders</a>-->
                                <span>Edit Orders</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <?php
                            if ($objCore->displaySessMsg()) {
                                echo $objCore->displaySessMsg();
                                $objCore->setSuccessMsg('');
                                $objCore->setErrorMsg('');
                            }
                            ?>
                            <div class="box box-color box-bordered">
                                <div class="box-title">
                                    <a id="buttonDecoration" href="<?php echo $httpRef; ?>">
                                        <input class="btn" type="button" style="float:right; margin:6px 2px 0 0; width:107px;" value="<?php echo ADMIN_BACK_BUTTON; ?>" name="btnTagSettings" />
                                    </a>
                                    <h3>
                                        Edit Orders
                                    </h3>
                                </div>
                                <div class="box-content nopadding" style=/*"width: 100%;*/overflow: auto">

                                     <?php require_once('javascript_disable_message.php'); ?>

                                     <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-orders', $_SESSION['sessAdminPerMission'])) {
                                         ?>

                                         <form action="" method="post" id="frm_page">
                                            <table class="table table-hover table-nomargin table-bordered usertable">
                                                <?php if ($varNum > 0) {
                                                    ?>
                                                    <tbody>
                                                        <tr>

                                                            <td colspan="3" width="48%" valign="top" align="left" style="border:none;">
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" colspan="3">
                                                                    <tr>
                                                                        <td colspan="2" class="detailshead">Account Information</td>
                                                                    </tr>
                                                                    <tr><td colspan="2">&nbsp;</td></tr>


                                                                    <tr>
                                                                        <td><span class="req">*</span>First Name:</td>
                                                                        <td>
                                                                            <input name="CustomerFirstName" id="CustomerFirstName" type="text" class="input-large" value="<?php echo $arrOrder['CustomerFirstName']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Last Name:</td>
                                                                        <td>
                                                                            <input name="CustomerLastName" id="CustomerLastName" type="text" class="input-large" value="<?php echo $arrOrder['CustomerLastName']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td style="width:20%;"><span class="req">*</span>Email:</td>
                                                                        <td>
                                                                            <input name="CustomerEmail" id="CustomerEmail" type="text" class="input-large" value="<?php echo $arrOrder['CustomerEmail']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><span class="req">*</span>Mobile:</td>
                                                                        <td>
                                                                            <input name="CustomerPhone" id="CustomerPhone" type="text" class="input-large" value="<?php echo $arrOrder['CustomerPhone']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                </table>
                                                            </td>
                                                        </tr>


                                                        <tr><td colspan="3" style="border:none;">&nbsp;</td></tr>

                                                        <tr>
                                                            <td width="48%" valign="top" align="left" style="border:none">
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td colspan="2" class="detailshead">Billing Information</td>
                                                                    </tr>
                                                                    <tr><td colspan="2">&nbsp;</td></tr>

                                                                    <tr>
                                                                        <td><span>*</span>Recipient First Name:</td>
                                                                        <td>
                                                                            <input name="BillingFirstName" id="BillingFirstName" type="text" class="input-large" value="<?php echo $arrOrder['BillingFirstName']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><span>*</span>Recipient Last Name:</td>
                                                                        <td>
                                                                            <input name="BillingLastName" id="BillingLastName" type="text" class="input-large" value="<?php echo $arrOrder['BillingLastName']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Organization Name:</td>
                                                                        <td>
                                                                            <input name="BillingOrganizationName" id="BillingOrganizationName" type="text" class="input-large" value="<?php echo $arrOrder['BillingOrganizationName']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><span>*</span>Address Line 1:</td>
                                                                        <td>
                                                                            <input name="BillingAddressLine1" id="BillingAddressLine1" type="text" class="input-large" value="<?php echo $arrOrder['BillingAddressLine1']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Address Line 2</td>
                                                                        <td>
                                                                            <input name="BillingAddressLine2" id="BillingAddressLine2" type="text" class="input-large" value="<?php echo $arrOrder['BillingAddressLine2']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><span>*</span>Country</td>
                                                                        <td>
                                                                            <select name="BillingCountry" id="BillingCountry" class='select2-me input-large nomargin' style="width:225px">
                                                                                <option value="0">Select</option>
                                                                                <?php foreach ($arrCountryList as $vCT) {
                                                                                    ?>
                                                                                    <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                        if ($arrOrder['BillingCountry'] == $vCT['country_id']) {
                                                                            echo 'selected="selected"';
                                                                        }
                                                                                    ?>><?php echo $vCT['name']; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><span>*</span>Post Code or Zip Code:</td>
                                                                        <td>
                                                                            <input name="BillingPostalCode" id="BillingPostalCode" type="text" class="input-large" value="<?php echo $arrOrder['BillingPostalCode']; ?>" />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span>*</span>Phone:</td>
                                                                        <td>
                                                                            <input name="BillingPhone" id="BillingPhone" type="text" class="input-large" value="<?php echo $arrOrder['BillingPhone']; ?>" />
                                                                        </td>
                                                                    </tr>


                                                                </table>
                                                            </td>
                                                            <td width="2%" style="border:none;">&nbsp;</td>
                                                            <td width="48%" valign="top" align="left" style="border:none">
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td colspan="2" class="detailshead">Shipping Information</td>
                                                                    </tr>
                                                                    <tr><td colspan="2">&nbsp;</td></tr>


                                                                    <tr>
                                                                        <td><span class="req">*</span>Recipient First Name:</td>
                                                                        <td>
                                                                            <input name="ShippingFirstName" id="ShippingFirstName" type="text" class="input-large" value="<?php echo $arrOrder['ShippingFirstName']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><span class="req">*</span>Recipient Last Name:</td>
                                                                        <td>
                                                                            <input name="ShippingLastName" id="ShippingLastName" type="text" class="input-large" value="<?php echo $arrOrder['ShippingLastName']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Organization Name:</td>
                                                                        <td>
                                                                            <input name="ShippingOrganizationName" id="ShippingOrganizationName" type="text" class="input-large" value="<?php echo $arrOrder['ShippingOrganizationName']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><span class="req">*</span>Address Line 1:</td>
                                                                        <td>
                                                                            <input name="ShippingAddressLine1" id="ShippingAddressLine1" type="text" class="input-large" value="<?php echo $arrOrder['ShippingAddressLine1']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Address Line 2</td>
                                                                        <td>
                                                                            <input name="ShippingAddressLine2" id="ShippingAddressLine2" type="text" class="input-large" value="<?php echo $arrOrder['ShippingAddressLine2']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><span class="req">*</span>Country</td>
                                                                        <td>
                                                                            <select name="ShippingCountry" id="ShippingCountry" class='select2-me input-large nomargin' style="width:225px">
                                                                                <option value="0">Select</option>
        <?php foreach ($arrCountryList as $vCT) {
            ?>
                                                                                    <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                                    if ($arrOrder['ShippingCountry'] == $vCT['country_id']) {
                                                                                        echo 'selected="selected"';
                                                                                    }
                                                                                    ?>><?php echo $vCT['name']; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><span class="req">*</span>Post Code or Zip Code:</td>
                                                                        <td>
                                                                            <input name="ShippingPostalCode" id="ShippingPostalCode" type="text" class="input-large" value="<?php echo $arrOrder['ShippingPostalCode']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><span class="req">*</span>Phone:</td>
                                                                        <td>
                                                                            <input name="ShippingPhone" id="ShippingPhone" type="text" class="input-large" value="<?php echo $arrOrder['ShippingPhone']; ?>" />
                                                                        </td>
                                                                    </tr>

                                                                </table>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td width="48%" colspan="3" valign="top" align="left" style="border:none">
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td class="detailshead">Sub Order Id</td>
                                                                        <td class="detailshead">Items Ordered</td>
                                                                        <td class="detailshead">Price</td>
                                                                        <td class="detailshead">Qty.</td>
                                                                        <td class="detailshead">SubTotal</td>
                                                                        <td class="detailshead">Shipping</td>
                                                                        <td class="detailshead">Discount</td>
                                                                        <td class="detailshead">Reward Point Discount</td>
                                                                        <td class="detailshead">Grand Total</td>
                                                                        <td class="detailshead">#</td>

                                                                    </tr>
        <?php
        $varSubTotal = 0;
        $varShippingSubTotal = 0;
        $varTotal = 0;
//                                                                pre($arrOrderItem);
        foreach ($arrOrderItem as $item) {
            $varSubTotal += ($item['ItemSubTotal'] + $item['AttributePrice'] - $item['DiscountPrice']);
            $varShippingSubTotal += $item['ShippingPrice'];
            ?>
                                                                        <tr id="tr<?php echo $item['pkOrderItemID']; ?>">
                                                                            <td><?php echo $item['SubOrderID']; ?></td>
                                                                            <td><?php echo '<b>' . $item['ItemName'] . '</b><br/>' . $item['OptionDet']; ?></td>
                                                                            <td><?php echo number_format(($item['ItemPrice'] + ($item['AttributePrice'] / $item['Quantity'])), 2); ?></td>
                                                                            <td><?php echo $item['Quantity']; ?></td>
                                                                            <td><?php echo number_format(($item['ItemSubTotal'] + $item['AttributePrice']), 2); ?></td>
                                                                            <td><?php echo number_format($item['ShippingPrice'], 2); ?></td>
                                                                            <td><?php echo number_format($item['DiscountPrice'], 2); ?></td>
                                                                            <td><?php echo number_format(($item['SingleDeductionValue'] * $item['Quantity']), 2); ?></td>
                                                                            <td>
            <?php echo number_format($item['ItemTotalPrice'], 2); ?>
                                                                                <input type="hidden" name="frmIsRemoved[<?php echo $item['pkOrderItemID']; ?>]" id="IsRemoved<?php echo $item['pkOrderItemID']; ?>" value="0" />
                                                                            </td>

                                                                            <td><a href="javascript:void(0);" onclick="hideItem(<?php echo $item['pkOrderItemID']; ?>)">Remove</a></td>
                                                                        </tr>
        <?php } ?>
                                                                </table>
                                                            </td>


                                                        </tr>



                                                        <tr><td colspan="3" style="border:none;">&nbsp;</td></tr>

                                                        <tr>
                                                            <td width="48%" valign="top" align="left" style="border:none;vertical-align:initial;">
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td colspan="2" class="detailshead">Comments History</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2">
        <?php
        foreach ($arrOrderComment as $vc) {
            echo '<p>' . $vc['Comment'] . '</p><p align="right"><b> - ' . $vc[$vc['CommentedBy'] . 'Name'] . ' (' . ucwords($vc['CommentedBy']) . ') </b></p>';
        }
        ?>
                                                                            <br />
                                                                            <textarea name="frmComment" class="input-large" rows="3" style="width:500px"></textarea>
                                                                        </td>
                                                                    </tr>


                                                                </table>
                                                            </td>
                                                            <td width="2%" style="border:none;">&nbsp;</td>
                                                            <td width="48%" valign="top" align="left" style="border:none">
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td colspan="2" class="detailshead">Order Totals</td>
                                                                    </tr>
                                                                                    <?php
                                                                            $varDescription = '';
                                                                            foreach ($arrOrderTotal as $vTotal) {
                                                                                if ($vTotal['Code'] == 'gift-card') {
                                                                                    $varDescription .= 'Paid By ' . $vTotal['Title'] . ': ' . ADMIN_CURRENCY_SYMBOL . number_format($vTotal['Amount'], 2, ".", ",") . '<br />';
                                                                                }
                                                                                if ($vTotal['Code'] == 'coupon') {
                                                                                    $Title2 = $vTotal['Title'];
                                                                                    $varDescription .= ' ' . $vTotal['Title'] . ': ' . ADMIN_CURRENCY_SYMBOL . number_format($vTotal['Amount'], 2, ".", ",") . '<br />';
                                                                                }
                                                                                if ($vTotal['Code'] == 'reward-points') {
                                                                                    // $Title2 = $vTotal['Title'];
                                                                                    // $varDescription .= ' ' . $vTotal['Title'] . ': ' . ADMIN_CURRENCY_SYMBOL . number_format($vTotal['Amount'], 2, ".", ",");
                                                                                    $Title2 = $vTotal['Title'];
                                                                                    $AmountSingle = 0;
                                                                                    foreach ($arrOrderItem as $item) {
                                                                                        if(!empty($item['SingleDeductionValue'])){
                                                                                            $AmountSingle += $item['SingleDeductionValue'];
                                                                                        }
                                                                                    }
                                                                                    $varDescription .= ' ' . 'Reward Value' . ': ' . ADMIN_CURRENCY_SYMBOL . number_format(($AmountSingle * $item['Quantity']), 2, ".", ",");
                                                                                }
                                                                            }
                                                                            ?>

                                                                    <tr>
                                                                        <td>Sub Total</td>
                                                                        <td><?php echo ADMIN_CURRENCY_SYMBOL . number_format($varSubTotal, 2, ".", ","); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Shipping Charge</td>
                                                                        <td><?php echo ADMIN_CURRENCY_SYMBOL . number_format($varShippingSubTotal, 2, ".", ","); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Total</td>
                                                                        <td>
                                                                                    <?php
                                                                                    $varTotal = ($varSubTotal + $varShippingSubTotal);
                                                                                    echo ADMIN_CURRENCY_SYMBOL . number_format($varTotal, 2, ".", ",");
                                                                                    ?>
                                                                        </td>
                                                                    </tr>

        <?php if ($varDescription) {
            ?>
                                                                        <tr>
                                                                            <td><?php echo 'Description'; ?></td>
                                                                            <td><?php echo $varDescription; ?></td>
                                                                        </tr>
        <?php } ?>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr><td colspan="3">&nbsp;</td></tr>
                                                        <tr>
                                                            <td colspan="2">&nbsp;</td>
                                                            <td style="text-align:left; padding-left:7px;">Note : <span class="req">*</span> Indicates mandatory fields.</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">&nbsp;</td>
                                                            <td width="100%">
                                                                <input type="hidden" name="httpRef" value="<?php echo $httpRef; ?>"/>
                                                                <input type="hidden" name="oid" value="<?php echo $arrOrder['pkOrderID']; ?>"/>
                                                                <input type="submit" class="btn btn-blue" name="btnPage" value="Update" style="float:left; margin:5px 15px 0 0; width:80px;"/>
                                                                <a id="buttonDecoration" href="order_manage_uil.php">
                                                                    <input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="float:left; margin:5px 5px 0 0; width:80px;"/></a>
                                                                <input type="hidden" name="frmHidenEdit" value="edit" />
                                                            </td>
                                                        </tr>

    <?php
    } else {
        ?>
                                                        <tr>
                                                            <td><?php echo ADMIN_NO_RECORD_FOUND; ?></td>
                                                        </tr>
    <?php } ?>

                                                </tbody>

                                            </table>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>

<?php
} else {
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