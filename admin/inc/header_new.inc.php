<?php
/* * ****************************************
  Module name : Header
  Date created : 21 Sep 2011
  Date last modified : 21 Sep 2011
  Author : Ghazala Anjum
  Last modified by : Ghazala Anjum
  Comments : Header of admin panel
  Copyright : Copyright (C) 1999-2011 Vinove Software and Services (P) Ltd.
 * ***************************** */
$varFileName = basename($_SERVER['PHP_SELF']);
?>
<div id="navigation">
    <div class="container-fluid top_nav">
        <a href="<?php echo $_SESSION['sessUser'] != 0 ? 'dashboard_uil.php' : 'index.php'; ?>" id="brand"><img src="img/logo.png"  alt="<?php echo SITE_NAME; ?>" title="<?php echo SITE_NAME; ?>" /></a>

        <div class="user">
            <!--<ul class="icon-nav">

                <li class="dropdown sett">
                    <a href="#" class='dropdown-toggle' data-toggle1="dropdown"><i class="icon-cog"></i></a>
                    <ul class="dropdown-menu pull-right theme-settings">
                        <li>
                            <span>Layout-width</span>
                            <div class="version-toggle">
                                <a href="#" class='set-fixed'>Fixed</a>
                                <a href="#" class="active set-fluid">Fluid</a>
                            </div>
                        </li>
                        <li>
                            <span>Topbar</span>
                            <div class="topbar-toggle">
                                <a href="#" class='set-topbar-fixed'>Fixed</a>
                                <a href="#" class="active set-topbar-default">Default</a>
                            </div>
                        </li>
                        <li>
                            <span>Sidebar</span>
                            <div class="sidebar-toggle">
                                <a href="#" class='set-sidebar-fixed'>Fixed</a>
                                <a href="#" class="active set-sidebar-default">Default</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class='dropdown colo'>
                    <a href="#" class='dropdown-toggle' data-toggle1="dropdown"><i class="icon-tint"></i></a>
                    <ul class="dropdown-menu pull-right theme-colors">
                        <li class="subtitle">
                            Predefined colors
                        </li>
                        <li>
                            <span class='red'></span>
                            <span class='orange'></span>
                            <span class='green'></span>
                            <span class="brown"></span>
                            <span class="blue"></span>
                            <span class='lime'></span>
                            <span class="teal"></span>
                            <span class="purple"></span>
                            <span class="pink"></span>
                            <span class="magenta"></span>
                            <span class="grey"></span>
                            <span class="darkblue"></span>
                            <span class="lightred"></span>
                            <span class="lightgrey"></span>
                            <span class="satblue"></span>
                            <span class="satgreen"></span>
                        </li>
                    </ul>
                </li>

            </ul>-->
            <div class="dropdown">
                <a href="#" class='dropdown-toggle admin' data-toggle="dropdown"><?php echo $_SESSION['sessAdminTitle']; ?> <img src="img/admin.png" alt=""></a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a class="setting" <?php echo ($varFileName == 'settings_frm_uil.php') ? 'class="active"' : 'href="settings_frm_uil.php"'; ?>>Settings</a>
                    </li>
                    <?php if ($_SESSION['sessUserType'] == 'user-admin') { ?>
                        <!--                        <li>
                                                    <a href="shipping_method_manage_uil.php" class="setting">Shipping Method</a>
                                                </li>-->

                    <?php } ?>

                    <!--                    <li>
                                            <a href="ship_price_manage_uil1.php" class="setting">Shipping Price</a>
                                        </li>-->
                    <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>
                        <li>
                            <a href="user_roll_manage_uil.php" class="setting" alt="Role Management" title="Role Management">Role Management</a>
                        </li>
                        <!--                        <li>
                                                    <a href="shipping_gateway_manage_new_uil.php" class="setting">Shipping Price</a>
                                                </li>-->
                        <li>
                            <a href="shipping_method_manage_uil.php" class="setting">Shipping Method</a>
                        </li>
                        <li>
                            <a href="shipping_manage_new_uil.php" class="setting">Shipping Gateways</a>
                        </li>
                        <li>
                            <a href="shipping_countries_uil.php" class="setting">Shipping Countries</a>
                        </li>
                        <li>
                            <a href="paypal_email_manage_uil.php" class="setting">Paypal Accounts</a>
                        </li>
                        <li>
                            <a href="user_manage_uil.php" class="setting">Admin Users</a>
                        </li>
                        <!--                        <li>
                                                    <a href="region_manage_uil.php" class="setting">Regions</a>
                                                </li>-->
                        <li>
                            <a href="send_product_notification.php" class="setting">Send Notification</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="logout.php" class="logout" alt="Logout" title="Logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">

<!--				<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-reorder"></i></a>-->



        <ul class='main-nav'>

            <?php
            if (in_array($varFileName, array('dashboard_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="dashboard_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Dashboard</span>                    
                </a>
                <ul class="dropdown-menu nodrop" <?php echo $display ?>>
                    <li>&nbsp;</li>
                </ul>
            </li>

            <?php
            if (in_array($varFileName, array('catalog_manage_uil.php', 'product_manage_uil.php', 'product_add_uil.php', 'product_add_multiple_uil.php', 'product_edit_uil.php', 'product_view_uil.php', 'category_manage_uil.php', 'category_add_uil.php', 'category_edit_uil.php', 'package_manage_uil.php', 'package_add_uil.php', 'package_edit_uil.php', 'attribute_manage_uil.php', 'attribute_add_uil.php', 'attribute_edit_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>
            <li <?php echo $class; ?>>
                <a href="catalog_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Catalog</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" <?php echo $display; ?>>
                    <li><a href="category_manage_uil.php" <?php
                        if (in_array($varFileName, array('category_manage_uil.php', 'catalog_manage_uil.php', 'category_add_uil.php', 'category_edit_uil.php'))) {
                            echo 'class="current"';
                        } else {
                            unset($_SESSION['cat']['gcid']);
                        }
                        ?>>Manage Categories</a></li>
                    <li><a href="attribute_manage_uil.php" <?php
                        if ($varFileName == 'attribute_manage_uil.php' || $varFileName == 'attribute_add_uil.php' || $varFileName == 'attribute_edit_uil.php') {
                            echo 'class="current"';
                        }
                        ?>>Manage Attributes</a></li>
                    <li><a href="product_manage_uil.php" <?php
                        if ($varFileName == 'product_manage_uil.php' || $varFileName == 'product_add_uil.php' || $varFileName == 'product_edit_uil.php' || $varFileName == 'product_view_uil.php' || $varFileName == 'product_add_multiple_uil.php') {
                            echo 'class="current"';
                        }
                        ?>>Manage Products</a></li>
                    <li><a href="package_manage_uil.php" <?php
                        if ($varFileName == 'package_manage_uil.php' || $varFileName == 'package_add_uil.php' || $varFileName == 'package_edit_uil.php') {
                            echo 'class="current"';
                        }
                        ?>>Manage Packages</a></li>
                </ul>
            </li>

            <?php
            if ($varFileName == 'coupon_manage_uil.php' || $varFileName == 'coupon_add_uil.php' || $varFileName == 'coupon_edit_uil.php' || $varFileName == 'product_today_offer_uil.php') {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = '';
                $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="coupon_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Discount</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" <?php echo $display; ?>>
                    <li><a href="coupon_manage_uil.php" <?php echo in_array($varFileName, array('coupon_manage_uil.php', 'coupon_add_uil.php', 'coupon_edit_uil.php')) ? 'class="current"' : ''; ?>>Manage Discount Coupons</a></li>
                    <li><a href="product_today_offer_uil.php?type=offer" <?php echo ($varFileName == 'product_today_offer_uil.php') ? 'class="current"' : ''; ?>>Manage Today's Offer</a></li>
                </ul>
            </li>

            <?php
            if (in_array($varFileName, array('order_manage_uil.php', 'order_add_uil.php', 'order_edit_uil.php', 'order_view_uil.php', 'order_invoice_uil.php', 'invoice_manage_uil.php', 'invoice_view_uil.php', 'order_disputed_manage_uil.php', 'invoic_logistic.php', 'commission_manage_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>

            <li <?php echo $class ?>>
                <a href="order_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Sales</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" <?php echo $display ?>>
                    <li><a href="order_manage_uil.php" <?php
                        if ($varFileName == 'order_manage_uil.php' || $varFileName == 'order_edit_uil.php' || $varFileName == 'order_view_uil.php' || $varFileName == 'order_invoice_uil.php') {
                            echo 'class="current"';
                        }
                        ?>>Orders</a></li>
                    <li><a href="invoice_manage_uil.php" <?php
                        if ($varFileName == 'invoice_manage_uil.php' || $varFileName == 'invoice_view_uil.php') {
                            echo 'class="current"';
                        }
                        ?>>Invoice</a></li>

                    <li><a href="invoic_logistic.php" <?php
                        // pre($varFileName);
                        if ($varFileName == 'invoic_logistic.php' || $varFileName == 'invoice_view_uil.php') {
                            echo 'class="current"';
                        }
                        ?>> Logistic Invoice</a></li>

                    <li><a href="commission_manage_uil.php" <?php
                        // pre($varFileName);
                        if ($varFileName == 'commission_manage_uil.php' || $varFileName == 'commission_manage_uil.php') {
                            echo 'class="current"';
                        }
                        ?>> Commission</a></li>

                    <li><a href="order_disputed_manage_uil.php" <?php
                        if ($varFileName == 'order_disputed_manage_uil.php') {
                            echo 'class="current"';
                        }
                        ?>>Disputed Orders</a></li>
                </ul>
            </li>

            <?php
            if (in_array($varFileName, array('customer_support_outbox_view_uil.php', 'customer_support_enquiry_view_uil.php', 'customer_support_compose_manage_uil.php', 'customer_support_outbox_manage_uil.php', 'customer_support_enquiry_manage_uil.php', 'cart_manage_uil.php', 'product_review_manage_uil.php', 'customer_manage_uil.php', 'customer_add_uil.php', 'customer_edit_uil.php', 'customer_view_uil.php', 'customer_feedback_uil.php', 'customer_feedback_view_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="customer_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Customers</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" <?php echo $display ?>>
                    <li><a href="customer_manage_uil.php" <?php echo in_array($varFileName, array('customer_manage_uil.php', 'customer_add_uil.php', 'customer_view_uil.php', 'customer_edit_uil.php')) ? 'class="current"' : ''; ?>>Customer</a></li>
                    <li><a href="customer_feedback_uil.php?frmfeedback=yes" <?php echo in_array($varFileName, array('customer_feedback_uil.php', 'customer_feedback_view_uil.php')) ? 'class="current"' : ''; ?>>Customer Feedback</a></li>
                    <li><a href="product_review_manage_uil.php" <?php echo in_array($varFileName, array('product_review_manage_uil.php')) ? 'class="current"' : ''; ?>>Product Review</a></li>
                    <li><a href="customer_support_enquiry_manage_uil.php" <?php echo in_array($varFileName, array('customer_support_enquiry_manage_uil.php', 'customer_support_enquiry_view_uil.php')) ? 'class="current"' : ''; ?>>Customer Support Inbox</a></li>
                    <li><a href="customer_support_outbox_manage_uil.php" <?php echo in_array($varFileName, array('customer_support_outbox_manage_uil.php', 'customer_support_outbox_view_uil.php')) ? 'class="current"' : ''; ?>>Customer Support Outbox</a></li>
                    <li><a href="customer_support_compose_manage_uil.php" <?php echo in_array($varFileName, array('customer_support_compose_manage_uil.php')) ? 'class="current"' : ''; ?>>Customer Support Compose</a></li>
                </ul>
            </li>

            <?php
            if (in_array($varFileName, array('wholesaler_special_application_manage_uil.php', 'wholesaler_special_application_view_uil.php', 'wholesaler_support_outbox_manage_uil.php', 'wholesaler_support_compose_manage_uil.php', 'wholesaler_commission_manage_uil.php', 'wholesaler_transaction_manage_uil.php', 'wholesaler_support_outbox_view_uil.php', 'wholesaler_support_enquiry_view_uil.php', 'wholesaler_support_compose_manage_uil', 'wholesaler_support_outbox_manage_uil', 'wholesaler_support_enquiry_manage_uil.php', 'wholesaler_manage_uil.php', 'wholesaler_application_manage_uil.php', 'wholesaler_add_uil.php', 'wholesaler_edit_uil.php', 'wholesaler_view_uil.php', 'wholesaler_kpi_manage_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="wholesaler_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>WholeSalers</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" <?php echo $display ?>>
                    <li><a href="wholesaler_manage_uil.php" <?php echo ($varFileName == 'wholesaler_manage_uil.php' || $varFileName == 'wholesaler_add_uil.php' || $varFileName == 'wholesaler_edit_uil.php' || $varFileName == 'wholesaler_view_uil.php') ? 'class="current"' : ''; ?>>Wholesaler</a></li>
                    <li><a href="wholesaler_application_manage_uil.php" <?php echo ($varFileName == 'wholesaler_application_manage_uil.php') ? 'class="current"' : ''; ?>>Applications</a></li>
                    <li><a href="wholesaler_special_application_manage_uil.php" <?php echo in_array($varFileName, array('wholesaler_special_application_manage_uil.php', 'wholesaler_special_application_view_uil.php')) ? 'class="current"' : ''; ?>>Special Applications</a></li>
                    <li><a href="wholesaler_kpi_manage_uil.php" <?php echo in_array($varFileName, array('wholesaler_kpi_manage_uil.php')) ? 'class="current"' : ''; ?>>KPIs</a></li>
                    <li><a href="wholesaler_commission_manage_uil.php" <?php echo ($varFileName == 'wholesaler_commission_manage_uil.php') ? 'class="current"' : ''; ?>>commission [Invoice]</a></li>
                    <li><a href="wholesaler_transaction_manage_uil.php" <?php echo ($varFileName == 'wholesaler_transaction_manage_uil.php') ? 'class="current"' : ''; ?>>Transactions</a></li>
                    <li><a href="wholesaler_support_enquiry_manage_uil.php" <?php echo in_array($varFileName, array('wholesaler_support_enquiry_manage_uil.php', 'wholesaler_support_enquiry_view_uil.php')) ? 'class="current"' : ''; ?>>Support Inbox</a></li>
                    <li><a href="wholesaler_support_outbox_manage_uil.php" <?php echo in_array($varFileName, array('wholesaler_support_outbox_manage_uil.php', 'wholesaler_support_outbox_view_uil.php')) ? 'class="current"' : ''; ?>>Support Outbox</a></li>
                    <li><a href="wholesaler_support_compose_manage_uil.php" <?php echo in_array($varFileName, array('wholesaler_support_compose_manage_uil.php')) ? 'class="current"' : ''; ?>>Support Compose</a></li>
                </ul>
            </li>
            <?php
            if (in_array($varFileName, array('country_portal_transaction_manage_uil.php', 'country_portal_manage_uil.php', 'country_portal_wholesalers_uil.php', 'country_portal_archive_uil.php', 'country_portal_commission_manage_uil.php', 'country_portal_kpi_manage_uil.php', 'country_portal_order_manage_uil.php', 'country_portal_order_wholesalers_uil.php', 'country_portal_invoice_manage_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="country_portal_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Country Portal</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" <?php echo $display; ?>>
                    <li><a href="country_portal_manage_uil.php" <?php echo in_array($varFileName, array('country_portal_manage_uil.php', 'country_portal_wholesalers_uil.php', 'country_portal_archive_uil.php')) ? 'class="current"' : ''; ?>>Country Portal</a></li>
                    <?php if ($_SESSION['sessUserType'] == 'user-admin') { ?>
                        <li><a href="country_portal_order_manage_uil.php" <?php echo in_array($varFileName, array('country_portal_order_manage_uil.php', 'country_portal_order_wholesalers_uil.php')) ? 'class="current"' : ''; ?>>Country Portal Orders</a></li>
                    <?php } ?>
                    <li><a href="country_portal_invoice_manage_uil.php" <?php echo in_array($varFileName, array('country_portal_invoice_manage_uil.php')) ? 'class="current"' : ''; ?>>Country Portal Invoices</a></li>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>
                        <li><a href="country_portal_kpi_manage_uil.php" <?php echo in_array($varFileName, array('country_portal_kpi_manage_uil.php')) ? 'class="current"' : ''; ?>>Country Portal KPIs</a></li>
                        <li><a href="country_portal_commission_manage_uil.php" <?php echo in_array($varFileName, array('country_portal_commission_manage_uil.php')) ? 'class="current"' : ''; ?>>Country Portal Commission</a></li>
                    <?php } ?>
                    <li><a href="country_portal_transaction_manage_uil.php" <?php echo in_array($varFileName, array('country_portal_transaction_manage_uil.php')) ? 'class="current"' : ''; ?>>Country Portal Transactions</a></li>
                </ul>
            </li>

            <?php
//            echo $varFileName;die;
            if ($varFileName == 'logistic_portal_manage_uil.php' || $varFileName == 'ship_price_manage_uil1.php' || $varFileName == 'zone_manage_uil.php' || $varFileName == 'zone_add_uil.php' || $varFileName == 'zone_listing_uil.php'  || $varFileName == 'zone_price_manage_uil.php' || $varFileName == 'zone_price_edit_uil.php' || $varFileName == 'listing_zone_price.php' || $varFileName == 'zone_price_add_uil.php') {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = '';
                $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="logistic_portal_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Logistic Portal</span>                    
                </a>
                <ul class="dropdown-menu nodrop" <?php echo $display ?>>
                    <!--                    <li>&nbsp;</li>-->
                    <li><a href="logistic_portal_manage_uil.php" <?php echo in_array($varFileName, array('logistic_portal_manage_uil.php')) ? 'class="current"' : ''; ?>>Logistic Portal</a></li>
                    <li><a href="ship_price_manage_uil1.php" <?php echo in_array($varFileName, array('ship_price_manage_uil1.php')) ? 'class="current"' : ''; ?>>Logistic Services Application</a></li>
                    <li><a href="zone_manage_uil.php" <?php echo in_array($varFileName, array('zone_manage_uil.php','zone_listing_uil.php')) ? 'class="current"' : ''; ?>>Zone Manager</a></li>
                    <li><a href="zone_price_manage_uil.php" <?php echo in_array($varFileName, array('zone_price_manage_uil.php','zone_price_edit_uil.php','listing_zone_price.php','zone_price_add_uil.php')) ? 'class="current"' : ''; ?>>Shipping Price</a></li>

                </ul>
            </li>

            <?php
            if (in_array($varFileName, array('festival_manage_uil.php', 'festival_add_uil.php', 'festival_edit_uil.php', 'slider_manage_uil.php', 'slider_add_uil.php', 'slider_edit_uil.php', 'special_banner_manage_uil.php', 'special_banner_add_uil.php', 'special_banner_edit_uil.php', 'newsletter_view_uil.php', 'cms_manage_uil.php', 'cms_add_uil.php', 'cms_edit_uil.php', 'cms_view_uil.php', 'newsletter_manage_uil.php', 'newsletter_add_uil.php', 'newsletter_edit_uil.php', 'ads_manage_uil.php', 'ads_add_uil.php', 'ads_edit_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="cms_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Content</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" <?php echo $display ?>>
                    <li><a href="cms_manage_uil.php" <?php echo in_array($varFileName, array('cms_manage_uil.php', 'cms_add_uil.php', 'cms_edit_uil.php', 'cms_view_uil.php')) ? 'class="current"' : ''; ?>>CMS</a></li>
                    <li><a href="newsletter_manage_uil.php" <?php echo in_array($varFileName, array('newsletter_manage_uil.php', 'newsletter_add_uil.php', 'newsletter_view_uil.php')) ? 'class="current"' : ''; ?>>Newsletters</a></li>
                    <li><a href="ads_manage_uil.php" <?php echo in_array($varFileName, array('ads_manage_uil.php', 'ads_add_uil.php', 'ads_edit_uil.php')) ? 'class="current"' : ''; ?>><span>Advertisement</span></a></li>
                    <li><a href="festival_manage_uil.php" <?php echo in_array($varFileName, array('festival_manage_uil.php', 'festival_add_uil.php', 'festival_edit_uil.php')) ? 'class="current"' : ''; ?>>Manage Festival</a></li>
                    <li><a href="slider_manage_uil.php" <?php echo in_array($varFileName, array('slider_manage_uil.php', 'slider_add_uil.php', 'slider_edit_uil.php')) ? 'class="current"' : ''; ?>>Festival Home Banner</a></li>
                    <li><a href="special_banner_manage_uil.php" <?php echo in_array($varFileName, array('special_banner_manage_uil.php', 'special_banner_add_uil.php', 'special_banner_edit_uil.php')) ? 'class="current"' : ''; ?>>Special And Landing Banner</a></li>
                </ul>
            </li>

            <?php
            if (in_array($varFileName, array('dashboard_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>



            <?php
            if (in_array($varFileName, array('user_enquiry_action.php', 'user_enquiry_manage_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="user_enquiry_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Enquiries</span>                    
                </a>
                <ul class="dropdown-menu nodrop" <?php echo $display ?>>
                    <li>&nbsp;</li>
                </ul>
            </li>

            <?php
            if (in_array($varFileName, array('bulk_upload_action.php', 'bulk_upload_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="bulk_upload_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Bulk Uploads</span>                    
                </a>
                <ul class="dropdown-menu nodrop" <?php echo $display ?>>
                    <li>&nbsp;</li>
                </ul>
            </li>

            <?php
            if (in_array($varFileName, array('analytics_uil.php', 'analytics_orders_uil.php', 'analytics_visitors_uil.php', 'analytics_revenue_uil.php', 'analytics_sales_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100; margin-left: 180px;"';
            } else {
                $class = $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="analytics_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Reports & Analytics</span>                    
                </a>
                <ul class="dropdown-menu nodrop" <?php echo $display ?>>
                    <li>&nbsp;</li>
                </ul>
            </li>
        </ul>
    </div>
</div>