<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_COUNTRY_PORTAL_ORDER_CTRL;
//pre($_SESSION);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Country Portal</title>        
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />     
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>	
    </head>
    <body>    	
        <?php require_once 'inc/header_new.inc.php'; ?>        
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Country Portal - Wholesalers</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'user-admin' && in_array('listing-country-office-orders', $_SESSION['sessAdminPerMission']))
                    {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><a href="country_portal_manage_uil.php">Country Portal</a><i class="icon-angle-right"></i></li>
    <!--                                <li><a href="country_portal_order_wholesalers_uil.php?type=view&month=<?php echo @$_GET['month']; ?>">Country Portal Wholesalers</a></li>-->
                                <li><span>Country Portal Wholesalers</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn" style="float:right;"> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                        <?php if ($objPage->Invoice['inv'] > 0)
                                        {
                                            ?>
                                            <a href="<?php echo INVOICE_URL . 'country_portal/' . $objPage->Invoice['InvoiceFileName']; ?>" target="_blank" class="btn" style="float:right; margin-right: 10px;"><?php echo 'View Invoice'; ?></a>
                                        <?php
                                        }
                                        else if ($objPage->arrRows[0]['DiffInv'] > 0)
                                        {
                                            ?>
                                            <a href="country_portal_order_wholesalers_uil.php?type=SendInvoice&month=<?php echo $objPage->arrRows[0]['Dated'] ?>" class="btn"  style="float:right; margin-right: 10px;"/><?php echo 'Sent Invoice to Telamela'; ?></a>
    <?php } ?>
                                        <h3>
                                            Country Portal - Wholesalers
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
    <?php if (count($objPage->arrRows) > 0)
    {
        ?>
                                                <form id="frmCategoryList" name="frmCategoryList" action="customer_action.php" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='hidden-480'>Month Year</th>
                                                                <th class='hidden-480'>Wholesaler Id</th>
                                                                <th>Wholesaler Name</th>
                                                                <th>No. of Sold Products</th>
                                                                <th>Total Sales( <?php echo ADMIN_CURRENCY_SYMBOL; ?>)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val)
                                                            {
                                                                $varTotal +=$val['TotalAmount'];
                                                                ?>
                                                                <tr class="content">
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['Dated'], DATE_FORMAT_MONTH_YEAR_SITE); ?></td>
                                                                    <td class="hidden-480"><?php echo $val['pkWholesalerID']; ?></td>
                                                                    <td><?php echo $val['CompanyName']; ?></td>
                                                                    <td><?php echo $val['TotalQty']; ?></td>
                                                                    <td><?php echo number_format($val['TotalAmount'], 2); ?></td>
                                                                </tr>
            <?php
        }
        ?>
                                                            <tr class="content hidden-480">
                                                                <td colspan="4" style="text-align: right"><strong>Total Of <?php echo $objCore->localDateTime($val['Dated'], DATE_FORMAT_MONTH_YEAR_SITE); ?></strong></td>
                                                                <td><strong><?php echo number_format($varTotal, 2, '.', ','); ?></strong></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><?php
                                                if ($objPage->varNumberPages > 1)
                                                {
                                                    $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                }
                                                ?></div>
                                                </form>
    <?php
    }
    else
    {
        ?>
                                                <table class="table table-hover table-nomargin table-bordered usertable">
                                                    <tr class="content">
                                                        <td colspan="10" style="text-align:center">
                                                            <strong>No record(s) found.</strong>
                                                        </td>
                                                    </tr>
                                                </table>
                    <?php } ?>
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
                            <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th>
                        </tr>
                        <tr>
                            <td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td>
                        </tr>
                    </table>
<?php } ?>
            </div>
<?php require_once('inc/footer.inc.php'); ?>
        </div>
    </body>
</html>