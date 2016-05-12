<div class="content_title">
    <div id="submenu">
        <ul>
            <li><a <?php if ($varFileName == 'country_portal_manage_uil.php' || $varFileName == 'country_portal_wholesalers_uil.php' || $varFileName=='country_portal_archive_uil.php') {echo 'class="current"';}else{ echo 'href="country_portal_manage_uil.php"';}?> >Country Portal</a></li>
            <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>
            <li><a <?php if ($varFileName == 'country_portal_commission_manage_uil.php') {echo 'class="current"';}else{ echo 'href="country_portal_commission_manage_uil.php"';}?> >Country Portal Commission</a></li>
            <li><a <?php if ($varFileName == 'country_portal_kpi_manage_uil.php') { echo 'class="current"'; }else{echo 'href="country_portal_kpi_manage_uil.php"';}?>>Country Portal KPIs</a></li>
             <?php } if ($_SESSION['sessUserType'] == 'user-admin') { ?>
            <li><a <?php if ($varFileName == 'country_portal_order_manage_uil.php' || $varFileName=='country_portal_order_wholesalers_uil.php') { echo 'class="current"'; }else{echo 'href="country_portal_order_manage_uil.php"';}?>>Country Portal Orders</a></li>
            <?php }?>
            <li><a <?php if ($varFileName == 'country_portal_invoice_manage_uil.php' || $varFileName=='country_portal_invoice_view_uil.php') { echo 'class="current"'; }else{echo 'href="country_portal_invoice_manage_uil.php"';}?>>Country Portal Invoices</a></li>
            <li><a <?php if ($varFileName == 'country_portal_transaction_manage_uil.php') { echo 'class="current"'; }else{echo 'href="country_portal_transaction_manage_uil.php"';}?>>Country Portal Transactions</a></li>
        </ul>
    </div>
</div>