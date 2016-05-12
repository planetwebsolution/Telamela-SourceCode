<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_REPORTS_CTRL;
require_once CLASSES_SYSTEM_PATH . 'class_session_redirect_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_core_bll.php';
$objCore=new Core;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Reports & Analytics</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" media="all" />
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
            jCal = jQuery.noConflict();
            jCal(function() {
                jCal('.datepicks').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});

            });
        </script>
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>        
        <div class="container-fluid" id="content">
            <?php require_once 'inc/reports_left_menu.php'; ?>
            <div id="main" class="left_align">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Reports & Analytics</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                            <ul>
                                <li>
                                    <a href="dashboard.php">Home</a>
                                    <i class="icon-angle-right"></i>
                                </li>
                                <li>
                                    <a href="analytics_uil.php">Reports & Analytics</a>
                                    <i class="icon-angle-right"></i>
                                </li>

                                <li>
                                    <span>Dashboard</span>
                                </li>
                            </ul>
                            <div class="close-bread">
                                    <a href="#"><i class="icon-remove"></i></a>
                            </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="box box-color">								
                                <div class="box-content nopadding">
                                    <?php //pre($objPage->arrData);?>
                                    <div class="report_analytics">
                                        <ul>
                                            <li>
                                                <div class="customer">
                                                    <p>Customers</p>
                                                    <a href="#"><span>NA</span></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="wholesallers">
                                                    <p>Wholesalers</p>
                                                    <a href="#"><span>NA</span></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="orders">
                                                    <p>Orders</p>
                                                    <a href="analytics_orders_uil.php?section=orders"><span><?php echo $objPage->arrData['content']['ordersCount'];?></span></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="revenue">
                                                    <p>Revenues</p>
                                                    <?php
                                                    if($objPage->arrData['content']['revenueSum'] >0){?>
                                                    <a href="analytics_revenue_uil.php?section=revenue"><span><?php echo $objCore->getPrice($objPage->arrData['content']['revenueSum']);?></span></a>
                                                    <?php
                                                    }else{
                                                        echo "<span>0</span>";
                                                    }
                                                    ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="unique_visitors">
                                                    <p>Unique visitors</p>
                                                    <?php
                                                    if($objPage->arrData['content']['visitorsCount'][0]['count'] >0){?>
                                                    <a href="analytics_visitors_uil.php?section=visitors"><span><?php echo $objPage->arrData['content']['visitorsCount'][0]['count'];?></span></a>
                                                    <?php
                                                    }else{
                                                        echo "<span>0</span>";
                                                    }
                                                    ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="products">
                                                    <p>Products</p>
                                                    <a href="#"><span>NA</span></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="sales">
                                                    <p>Sales</p>
                                                    <?php
                                                    if($objPage->arrData['content']['salesSum'] >0){?>
                                                    <a href="analytics_sales_uil.php?section=visitors"><span><?php echo $objCore->getPrice($objPage->arrData['content']['salesSum']);?></span></a>
                                                    <?php
                                                    }else{
                                                        echo "<span>$0</span>";
                                                    }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <?php require_once('inc/footer.inc.php'); ?>
    </body>
</html>
