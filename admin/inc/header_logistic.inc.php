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
if (!$_SESSION['sessLogistictype']) {
   header('location: ' . SITE_ROOT_URL . 'logistic/index.php');
    exit();
}
//pre($varFileName);
?>

<div id="navigation">
    <div class="container-fluid top_nav">
        <a href="<?php echo $_SESSION['sessUser'] != 0 ? 'dashboard_uil.php' : 'index.php'; ?>" id="brand"><img src="../admin/img/logo.png"  alt="<?php echo SITE_NAME; ?>" title="<?php echo SITE_NAME; ?>" /></a>
        
        <div class="user">
            
            <div class="dropdown">
                <a href="#" class='dropdown-toggle admin' data-toggle="dropdown"><?php echo $_SESSION['sessLogisticTitle']; ?> <img src="../admin/img/admin.png" alt=""></a>
                <ul class="dropdown-menu pull-right">
<!--                    <li>
                        <a class="setting" <?php echo ($varFileName == 'settings_frm_uil.php') ? 'class="active"' : 'href="settings_frm_uil.php"'; ?>>Settings</a>
                    </li>-->
                    <?php if ($_SESSION['sessLogistictype'] == 'logistic-admin') { ?>
<!--                         <li>
                            <a href="shipping_method_manage_uil.php" class="setting">Shipping Method</a>
                        </li>-->
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
            if (in_array($varFileName, array('setup_manage_uil.php', 'product_add_uil.php','zone_add_uil.php','zone_edit_uil.php','price_manage_uil.php','price_add_uil.php','price_edit_uil.php'))) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = $display = '';
            }
            ?>
            <li <?php echo $class; ?>>
                <a href="setup_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>SetUp</span>
                    <span class="caret"></span>
                </a>
                
                <ul class="dropdown-menu" <?php echo $display; ?>>
                    <li><a href="setup_manage_uil.php" 
                        
                        <?php
            if (in_array($varFileName, array('setup_manage_uil.php',  'zone_add_uil.php', 'zone_edit_uil.php'))) {
                echo 'class="current"';
            } else {
               // unset($_SESSION['cat']['gcid']);
            }
            ?>>Manage Zone</a></li>
            
                    <li><a href="price_manage_uil.php" <?php
                           if ($varFileName == 'price_manage_uil.php' || $varFileName == 'price_add_uil.php' || $varFileName == 'price_edit_uil.php') {
                               echo 'class="current"';
                           }
            ?>>Manage Price</a></li>
                    
                </ul>
            </li>

            <?php
            if ($varFileName == 'invoic_manage_uil.php' ) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = '';
                $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="invoic_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Invoices</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" <?php echo $display; ?>>
                    <li><a href="#" <?php echo in_array($varFileName, array('invoice_detail_uil.php')) ? 'class="current"' : ''; ?>>Invoice Details</a></li>
                     </ul>
            </li>
            
            <?php
            if ($varFileName == 'logisticorder_manage_uil.php' ) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = '';
                $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="logisticorder_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Orders</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" <?php echo $display; ?>>
                    <li><a href="#" <?php echo in_array($varFileName, array('logisticorder_detail_uil.php')) ? 'class="current"' : ''; ?>>Invoice Details</a></li>
                     </ul>
            </li>
            
            <?php
            if ($varFileName == 'notification_manage_uil.php' ) {
                $class = 'class="active open"';
                $display = 'style="display: block; z-index:100;"';
            } else {
                $class = '';
                $display = '';
            }
            ?>
            <li <?php echo $class ?>>
                <a href="notification_manage_uil.php" data-toggle1="dropdown" class='dropdown-toggle'>
                    <span>Notification</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" <?php echo $display; ?>>
                    <li><a href="#" <?php echo in_array($varFileName, array('notifyorderupdate_uil.php')) ? 'class="current"' : ''; ?>>Order Updates</a></li>
                    <li><a href="#" <?php echo in_array($varFileName, array('notifyuserquery.php')) ? 'class="current"' : ''; ?>>Users Queries</a></li>
                     </ul>
            </li>

        </ul>
    </div>
</div>
