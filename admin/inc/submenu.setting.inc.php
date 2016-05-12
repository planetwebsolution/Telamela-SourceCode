
<div class="content_title"><div id="submenu"><!--submenu start-->
        <ul>
            <li><a <?php if($varFileName=='settings_frm_uil.php'){echo 'class="current"';}else{echo 'href="settings_frm_uil.php"';}?>>Settings</a></li>                                    
 <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>            
            <li><a <?php if($varFileName=='user_roll_manage_uil.php' || $varFileName=='user_roll_add_uil.php'){echo 'class="current"';}else{echo 'href="user_roll_manage_uil.php"';}?>>Role Management</a></li>
            <li><a <?php if($varFileName=='shipping_gateway_manage_uil.php' || $varFileName=='shipping_gateway_add_uil.php' || $varFileName=='shipping_gateway_edit_uil.php'){echo 'class="current"';}else{echo 'href="shipping_gateway_manage_uil.php"';}?>>Shipping Price</a></li>
            <li><a <?php if($varFileName=='shipping_method_manage_uil.php' || $varFileName=='shipping_method_add_uil.php' || $varFileName=='shipping_method_edit_uil.php'){echo 'class="current"';}else{echo 'href="shipping_method_manage_uil.php"';}?>>Shipping Method</a></li>
            <li><a <?php if($varFileName=='paypal_email_manage_uil.php' || $varFileName=='paypal_email_add_uil.php' || $varFileName=='paypal_email_edit_uil.php'){echo 'class="current"';}else{echo 'href="paypal_email_manage_uil.php"';}?>>Paypal Accounts</a></li>
            <li><a <?php if($varFileName=='user_manage_uil.php' || $varFileName=='user_add_uil.php'){echo 'class="current"';}else{echo 'href="user_manage_uil.php"';}?>>Admin Users</a></li>
            
            
       <?php }?>
            <li><a <?php if($varFileName=='region_manage_uil.php' || $varFileName=='region_add_uil.php' || $varFileName=='region_edit_uil'){echo 'class="current"';}else{echo 'href="region_manage_uil.php"';}?>>Regions</a></li>
        </ul>
    </div>
</div>
