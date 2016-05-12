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
<script type="text/javascript" src="<?php echo FRONT_JS_PATH ?>message.inc.js"></script> 
<script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.searchabledropdown-1.0.8.min.js"></script>
<div id="login_logo" style="border: 0px solid firebrick;">
    <img src="images/logo.png" alt="<?php echo SITE_NAME; ?>" title="<?php echo SITE_NAME; ?>" height="69" style="margin-top:15px; padding-bottom: 20px;" />
    <div class="top_links" style="border: 0px solid firebrick; vertical-align: text-top;">
        <span style="color:#032A7A"><strong>Welcome, </strong> <?php echo $_SESSION['sessAdminUserName']; ?></span>
        <span><a class="setting" <?php
if ($varFileName == 'settings_frm_uil.php' || $varFileName == 'user_roll_manage_uil.php' || $varFileName == 'user_roll_add_uil.php' || $varFileName == 'shipping_gateway_manage_uil.php' || $varFileName == 'shipping_gateway_add_uil.php' || $varFileName == 'shipping_gateway_edit_uil.php') {
    echo 'class="current"';
} else {
    echo 'href="settings_frm_uil.php"';
}
?>>Settings</a> </span>
        <span><a href="logout.php" class="logout" alt="Logout" title="Logout">Logout</a></span>
    </div>
</div>

<div id="menu">
    <ul>
        <li><a <?php
                 if ($varFileName == 'dashboard_uil.php') {
                     echo 'class="current"';
                 } else {
                     echo 'href="dashboard_uil.php"';
                 }
?>>Dashboard</a></li>
        <li><a <?php
                if ($varFileName == 'catalog_manage_uil.php' || $varFileName == 'product_manage_uil.php' || $varFileName == 'product_add_uil.php' || $varFileName == 'product_add_multiple_uil.php' || $varFileName == 'product_edit_uil.php' || $varFileName == 'product_view_uil.php' ||
                        $varFileName == 'category_manage_uil.php' || $varFileName == 'category_add_uil.php' || $varFileName == 'category_edit_uil.php' ||
                        $varFileName == 'package_manage_uil.php' || $varFileName == 'package_add_uil.php' || $varFileName == 'package_edit_uil.php' ||
                        $varFileName == 'attribute_manage_uil.php' || $varFileName == 'attribute_add_uil.php' || $varFileName == 'attribute_edit_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="catalog_manage_uil.php"';
                }
?>>Catalog</a></li>
        <li><a <?php
                if ($varFileName == 'coupon_manage_uil.php' || $varFileName == 'coupon_add_uil.php' || $varFileName == 'coupon_edit_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="coupon_manage_uil.php"';
                }
?>>Discount</a></li>
        <li><a <?php
                if ($varFileName == 'order_manage_uil.php' || $varFileName == 'order_add_uil.php' || $varFileName == 'order_edit_uil.php' || $varFileName == 'order_view_uil.php' || $varFileName == 'order_invoice_uil.php' || $varFileName == 'invoice_manage_uil.php' || $varFileName == 'invoice_view_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="order_manage_uil.php"';
                }
?>>Sales</a></li>
        <li><a <?php
                if ($varFileName == 'cart_manage_uil.php' || $varFileName == 'product_review_manage_uil.php' || $varFileName == 'customer_manage_uil.php' || $varFileName == 'customer_add_uil.php' || $varFileName == 'customer_edit_uil.php' || $varFileName == 'customer_view_uil.php' || $varFileName == 'customer_feedback_uil.php' || $varFileName == 'customer_feedback_view_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="customer_manage_uil.php"';
                }
?>>Customers</a></li>
        <li><a <?php
                if ($varFileName == 'wholesaler_manage_uil.php' || $varFileName == 'wholesaler_application_manage_uil.php' || $varFileName == 'wholesaler_add_uil.php' || $varFileName == 'wholesaler_edit_uil.php' || $varFileName == 'wholesaler_view_uil.php' || $varFileName == 'wholesaler_kpi_manage_uil.php' || $varFileName == 'wholesaler_transaction_manage_uil.php' || $varFileName == 'wholesaler_commission_manage_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="wholesaler_manage_uil.php"';
                }
?>>WholeSalers</a></li> 
        <li><a <?php
                if ($varFileName == 'user_enquiry_action.php' || $varFileName == 'user_enquiry_manage_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="user_enquiry_manage_uil.php"';
                }
?>>Enquiries </a></li>
        <li><a <?php
                if ($varFileName == 'customer_support_enquiry_action.php' || $varFileName == 'customer_support_enquiry_manage_uil.php' || $varFileName == 'customer_support_outbox_manage_uil.php' || $varFileName == 'customer_support_compose_manage_uil.php' || $varFileName == 'customer_support_compose_manage_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="customer_support_enquiry_manage_uil.php"';
                }
?>>Customer Support</a></li>
        <li><a <?php
                if ($varFileName == 'wholesaler_support_enquiry_action.php' || $varFileName == 'wholesaler_support_enquiry_manage_uil.php' || $varFileName == 'wholesaler_support_outbox_manage_uil.php' || $varFileName == 'wholesaler_support_compose_manage_uil.php' || $varFileName == 'wholesaler_support_compose_manage_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="wholesaler_support_enquiry_manage_uil.php"';
                }
?>>Wholesaler Support</a></li>
        <li><a <?php
                if ($varFileName == 'newsletter_manage_uil.php' || $varFileName == 'newsletter_add_uil.php' || $varFileName == 'newsletter_edit_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="newsletter_manage_uil.php"';
                }
?>>Newsletters</a></li>
        <li><a <?php
                if ($varFileName == 'ads_manage_uil.php' || $varFileName == 'ads_add_uil.php' || $varFileName == 'ads_edit_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="ads_manage_uil.php"';
                }
?>>Advertisement</a></li>
        <li><a <?php
                if ($varFileName == 'slider_manage_uil.php' || $varFileName == 'slider_add_uil.php' || $varFileName == 'slider_edit_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="slider_manage_uil.php"';
                }
?>>Home Slider</a></li>
        <li><a <?php
                if ($varFileName == 'region_manage_uil.php' || $varFileName == 'region_add_uil.php' || $varFileName == 'region_edit_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="region_manage_uil.php"';
                }
?>>Regions</a></li>
        <li><a <?php
                if ($varFileName == 'bulk_upload_action.php' || $varFileName == 'bulk_upload_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="bulk_upload_uil.php"';
                }
?>>Bulk Uploads</a></li>
        <li><a <?php
                if ($varFileName == 'cms_manage_uil.php' || $varFileName == 'cms_add_uil.php' || $varFileName == 'cms_edit_uil.php' || $varFileName == 'cms_view_uil.php') {
                    echo 'class="current"';
                } else {
                    echo 'href="cms_manage_uil.php"';
                }
?>>CMS</a></li>
            <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>
            <li><a <?php
            if ($varFileName == 'user_manage_uil.php' || $varFileName == 'user_add_uil.php') {
                echo 'class="current"';
            } else {
                echo 'href="user_manage_uil.php"';
            }
                ?>>Admin Users</a></li>
            <?php } ?>
        <li><a <?php
            if ($varFileName == 'country_portal_manage_uil.php' || $varFileName == 'country_portal_wholesalers_uil.php' || $varFileName == 'country_portal_archive_uil.php' || $varFileName == 'country_portal_commission_manage_uil.php' || $varFileName == 'country_portal_kpi_manage_uil.php' || $varFileName == 'country_portal_order_manage_uil.php' || $varFileName == 'country_portal_order_wholesalers_uil.php' || $varFileName == 'country_portal_invoice_manage_uil.php' || $varFileName == 'country_portal_transaction_manage_uil.php' || $varFileName == 'country_portal_invoice_view_uil.php') {
                echo 'class="current"';
            } else {
                echo 'href="country_portal_manage_uil.php"';
            }
            ?>>Country Portal</a></li>         
    </ul>
</div>
