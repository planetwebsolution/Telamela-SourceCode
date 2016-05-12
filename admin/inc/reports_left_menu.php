<?php $varFileName = basename($_SERVER['PHP_SELF']);?>
<div id="left" class="top_margin">
    <div class="subnav">
        <div class="subnav-title">
            <a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Reports</span></a>
        </div>
        <ul class="subnav-menu">
            <!--<li class='dropdown'>
                <a href="#" data-toggle="dropdown"></a>
                <ul class="dropdown-menu">
                        <li>
                                <a href="#">Action #1</a>
                        </li>
                        <li>
                                <a href="#">Antoher Link</a>
                        </li>
                        <li class='dropdown-submenu'>
                                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>Go to level 3</a>
                                <ul class="dropdown-menu">
                                        <li>
                                                <a href="#">This is level 3</a>
                                        </li>
                                        <li>
                                                <a href="#">Unlimited levels</a>
                                        </li>
                                        <li>
                                                <a href="#">Easy to use</a>
                                        </li>
                                </ul>
                        </li>
                </ul>
            </li>-->
            <li>
                
                <a <?php echo ($varFileName == 'analytics_uil.php') ? 'class="analytics_left_menu_active"' : ''; ?> href="analytics_uil.php">Dashboard</a>
            </li>
            <li>
                <a <?php echo ($varFileName == 'analytics_orders_uil.php') ? 'class="analytics_left_menu_active"' : ''; ?> href="analytics_orders_uil.php?section=orders">Orders</a>
            </li>
            <li>
                <a <?php echo ($varFileName == 'analytics_visitors_uil.php') ? 'class="analytics_left_menu_active"' : ''; ?> href="analytics_visitors_uil.php?section=visitors">Visitors</a>
            </li>
            <li>
                <a <?php echo ($varFileName == 'analytics_revenue_uil.php') ? 'class="analytics_left_menu_active"' : ''; ?> href="analytics_revenue_uil.php?section=revenue">Revenues</a>
            </li>
            <li>
                <a <?php echo ($varFileName == 'analytics_sales_uil.php') ? 'class="analytics_left_menu_active"' : ''; ?> href="analytics_sales_uil.php?section=sales">Sales</a>
            </li>
        </ul>
    </div>    
</div>