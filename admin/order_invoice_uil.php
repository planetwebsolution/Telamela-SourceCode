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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Order Print </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>


    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">

                    <div class="page-header">
                        <div class="pull-left">
                            <h1>View and Send Invoice</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="order_manage_uil.php">Sales</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="order_manage_uil.php">Orders</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
<!--                                <a href="order_view_uil.php?type=edit&soid=<?php echo $_GET['soid']; ?>">View Order</a>-->
                                <span>View Order</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">


                            <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('send-invoices', $_SESSION['sessAdminPerMission']))
                            { ?>



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
    <?php if ($varNum > 0)
    { ?>
                                                    <a id="buttonDecoration" href="order_print_uil.php?type=sendInvoice&soid=<?php echo $_GET['soid']; ?>">
                                                        <input class="btn" type="button" style="float:right; margin:5px 5px 0 0;" value="Send Invoice To Customer" name="btnTagSettings" />
                                                    </a>
                                                    <a href="javaScript:void(0);" onclick="window.open('order_print_uil.php?type=edit&soid=<?php echo $_GET['soid']; ?>','popUpWindow','resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=yes');"><input class="btn" type="button" style="float:right; margin:5px 5px 0 0; width:70px;" value="Print" name="btnTagSettings" /></a>
    <?php } ?>
                                                <a id="buttonDecoration" href="order_manage_uil.php">
                                                    <input class="btn" type="button" style="float:right; margin:5px 5px 0 0; width:107px;" value="<?php echo ADMIN_BACK_BUTTON; ?>" name="btnTagSettings" />
                                                </a>
                                                <h3>
                                                    View and Send Invoice
                                                </h3>
                                            </div>
                                            <div class="box-content nopadding" style="width: 100%; overflow: auto;">

                                                <table width="99%" border="0" cellspacing="0" cellpadding="0" style="float:left;" class="left_content">
    <?php if ($varNum > 0)
    { ?>
                                                        <tr class="content">
                                                            <td width="48%" valign="top" align="left" style="border:none">
                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                        <table cellpadding="0" cellspacing="0" border="0" class="left_content table_border">

                                                                            <div class="box-title nomargin"><h3>Order Details</h3></div>
                                                                            <tr class="content"><td colspan="2">&nbsp;</td></tr>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Order ID:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['pkOrderID']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Order Date:   </label>
                                                                                <div class="controls">
        <?php echo $objCore->localDateTime($arrOrder['OrderDateAdded'], DATE_TIME_FORMAT_SITE); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Order Status:   </label>
                                                                                <div class="controls">
        <?php echo  $arrOrderItem[0]['Status']; ?>
                                                                                </div>
                                                                            </div>

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td width="2%" style="border:none;">&nbsp;</td>
                                                            <td width="48%" valign="top" align="left" style="border:none">
                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                        <table cellpadding="0" cellspacing="0" border="0" class="left_content table_border">

                                                                            <div class="box-title nomargin"><h3>Account Information</h3></div>
                                                                            <tr class="content"><td colspan="2">&nbsp;</td></tr>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Customer Name:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['CustomerFirstName']; ?> <?php echo $arrOrder['CustomerLastName']; ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Email:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['CustomerEmail']; ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Phone:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['CustomerPhone']; ?>
                                                                                </div>
                                                                            </div>

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                        <tr  class="content"><td colspan="3" style="border:none;">&nbsp;</td></tr>

                                                        <tr class="content">
                                                            <td width="48%" valign="top" align="left" style="border:none">
                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                        <table cellpadding="0" cellspacing="0" border="0" class="left_content table_border">

                                                                            <div class="box-title nomargin"><h3>Billing Information</h3></div>
                                                                            <tr class="content"><td colspan="2">&nbsp;</td></tr>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Recipient First Name:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['BillingFirstName']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Recipient Last Name:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['BillingLastName']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Organization Name:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['BillingOrganizationName']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Address Line 1:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['BillingAddressLine1']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Address Line 2:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['BillingAddressLine2']; ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Country:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['BillingCountryName']; ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Post Code or Zip Code:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['BillingPostalCode']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Phone:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['BillingPhone']; ?>
                                                                                </div>
                                                                            </div>

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td width="2%" style="border:none;">&nbsp;</td>
                                                            <td width="48%" valign="top" align="left" style="border:none">
                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                        <table cellpadding="0" cellspacing="0" border="0" class="left_content table_border">

                                                                            <div class="box-title nomargin"><h3>Shipping Information</h3></div>
                                                                            <tr class="content"><td colspan="2">&nbsp;</td></tr>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Recipient First Name:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['ShippingFirstName']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Recipient Last Name:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['ShippingLastName']; ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Organization Name:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['ShippingOrganizationName']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Address Line 1:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['ShippingAddressLine1']; ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Address Line 2:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['ShippingAddressLine2']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Country:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['ShippingCountryName']; ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Post Code or Zip Code:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['ShippingPostalCode']; ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">Phone:   </label>
                                                                                <div class="controls">
        <?php echo $arrOrder['ShippingPhone']; ?>
                                                                                </div>
                                                                            </div>

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                        <tr class="content">
                                                            <td width="48%" colspan="3" valign="top" align="left" style="border:none">
                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                        <table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="width:100%">
                                                                            <tr class="content">
                                                                                <td class="box-title nomargin"><h3>Sub Order Id</h3></td>
                                                                                <td class="box-title nomargin"><h3>Items Ordered</h3></td>
                                                                                <td class="box-title nomargin"><h3>Price</h3></td>
                                                                                <td class="box-title nomargin"><h3>Qty.</h3></td>
                                                                                <td class="box-title nomargin"><h3>SubTotal</h3></td>
                                                                                <td class="box-title nomargin"><h3>Shipping</h3></td>
                                                                                <td class="box-title nomargin"><h3>Discount</h3></td>
                                                                                <td class="box-title nomargin"><h3>Grand Total</h3></td>

                                                                            </tr>
                                                                            <?php
                                                                            $varSubTotal = 0;
                                                                            $varShippingSubTotal = 0;
                                                                            $varTotal = 0;
                                                                            foreach ($arrOrderItem as $item)
                                                                            {
                                                                                $varSubTotal += ($item['ItemSubTotal'] + $item['AttributePrice'] - $item['DiscountPrice']);
                                                                                $varShippingSubTotal += $item['ShippingPrice'];
                                                                                ?>
                                                                                <tr id="tr<?php echo $item['pkOrderItemID']; ?>">
                                                                                    <td style=" padding-left:20px;"><?php echo $item['SubOrderID']; ?></td>
                                                                                    <td style=" padding-left:20px;"><?php echo '<b>' . $item['ItemName'] . '</b><br/>' . $item['OptionDet']; ?></td>
                                                                                    <td style=" padding-left:20px;"><?php echo number_format(($item['ItemPrice'] + ($item['AttributePrice'] / $item['Quantity'])), 2); ?></td>
                                                                                    <td style=" padding-left:20px;"><?php echo $item['Quantity']; ?></td>
                                                                                    <td style=" padding-left:20px;"><?php echo number_format(($item['ItemSubTotal'] + $item['AttributePrice']), 2); ?></td>
                                                                                    <td style=" padding-left:20px;"><?php echo number_format($item['ShippingPrice'], 2); ?></td>
                                                                                    <td style=" padding-left:20px;"><?php echo number_format($item['DiscountPrice'], 2); ?></td>
                                                                                    <td style=" padding-left:20px;">
            <?php echo number_format($item['ItemTotalPrice'], 2); ?>
                                                                                        <input type="hidden" name="frmIsRemoved[<?php echo $item['pkOrderItemID']; ?>]" id="IsRemoved<?php echo $item['pkOrderItemID']; ?>" value="0" />
                                                                                    </td>
                                                                                </tr>
        <?php } ?>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </td>


                                                        </tr>
                                                        <tr  class="content"><td colspan="3" style="border:none;">&nbsp;</td></tr>

                                                        <tr class="content">
                                                            <td width="48%" valign="top" align="left" style="border:none">
                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                        <table cellpadding="0" cellspacing="0" border="0" class="left_content table_border">

                                                                            <div class="box-title nomargin"><h3>Comments History</h3></div>
                                                                            <tr class="content">
                                                                                <td colspan="2">

        <?php
        foreach ($arrOrderComment as $vc)
        {
            echo '<p>' . $vc['Comment'] . '</p><p align="right"><b> - ' . $vc[$vc['CommentedBy'] . 'Name'] . ' (' . ucwords($vc['CommentedBy']) . ') </b></p>';
        }
        ?>
                                                                                    <br />

                                                                                </td>
                                                                            </tr>


                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td width="2%" style="border:none;">&nbsp;</td>
                                                            <td width="48%" valign="top" align="left" style="border:none">
                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                        <table cellpadding="0" cellspacing="0" border="0" class="left_content table_border">

                                                                            <div class="box-title nomargin"><h3>Order Totals</h3></div>
                                                                            <?php
                                                                            $varDescription = '';
                                                                            foreach ($arrOrderTotal as $vTotal)
                                                                            {
                                                                                if ($vTotal['Code'] == 'gift-card')
                                                                                {
                                                                                    $varDescription .= 'Paid By ' . $vTotal['Title'] . ': ' . ADMIN_CURRENCY_SYMBOL . number_format($vTotal['Amount'], 2, ".", ",") . '<br />';
                                                                                }
                                                                                if ($vTotal['Code'] == 'coupon')
                                                                                {
                                                                                    $Title2 = $vTotal['Title'];
                                                                                    $varDescription .= ' ' . $vTotal['Title'] . ': ' . ADMIN_CURRENCY_SYMBOL . number_format($vTotal['Amount'], 2, ".", ",") . '<br />';
                                                                                }
                                                                                if ($vTotal['Code'] == 'reward-points')
                                                                                {
                                                                                    $Title2 = $vTotal['Title'];
                                                                                    $varDescription .= ' ' . $vTotal['Title'] . ': ' . ADMIN_CURRENCY_SYMBOL . number_format($vTotal['Amount'], 2, ".", ",");
                                                                                }
                                                                            }
                                                                            ?>


                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label"><?php echo 'Sub Total'; ?>:   </label>
                                                                                <div class="controls">
        <?php echo ADMIN_CURRENCY_SYMBOL . number_format($varSubTotal, 2, ".", ","); ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label"><?php echo 'Shipping Charge'; ?>:   </label>
                                                                                <div class="controls">
                                                                                    <?php echo ADMIN_CURRENCY_SYMBOL . number_format($varShippingSubTotal, 2, ".", ","); ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label"><?php echo 'Total'; ?>:   </label>
                                                                                <div class="controls">
                                                                                    <?php
                                                                                    $varTotal = ($varSubTotal + $varShippingSubTotal);
                                                                                    echo ADMIN_CURRENCY_SYMBOL . number_format($varTotal, 2, ".", ",");
                                                                                    ?>
                                                                                </div>
                                                                            </div>

        <?php if ($varDescription)
        { ?>
                                                                                <div class="control-group">
                                                                                    <label for="textfield" class="control-label"><?php echo 'Description'; ?>:   </label>
                                                                                    <div class="controls">
            <?php echo $varDescription; ?>
                                                                                    </div>
                                                                                </div>
        <?php } ?>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr  class="content"><td colspan="3" style="border:none;">
                                                                <a id="buttonDecoration" href="order_print_uil.php?type=sendInvoice&soid=<?php echo $_GET['soid']; ?>">
                                                                    <input class="btn btn-blue" type="button" style="float:right; margin:5px 5px 0 0; width:200px;" value="Send Invoice to Customer" name="btnTagSettings" />
                                                                </a></td></tr>
                                                        <tr  class="content"><td colspan="3" style="border:none;">&nbsp;</td></tr>



    <?php }
    else
    { ?>
                                                        <tr class="content">
                                                            <td valign="top" colspan="2" style="text-align: center;"><?php echo ADMIN_NO_RECORD_FOUND; ?></td>
                                                        </tr>
    <?php } ?>

                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    <div >&nbsp;</div> <?php }
else
{ ?>

                                    <table width="100%">
                                        <tr>
                                            <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                                        <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                                    </table>

<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php require_once('inc/footer.inc.php'); ?>
        </div>

    </body>
</html>