<?php

//include '../config/config.inc.php';
require_once(dirname(dirname(__FILE__)) . '/config/config.inc.php');
require_once CLASSES_ADMIN_PATH . 'class_shipping_gateway_new_bll.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;

class Update_OrderStatus extends Database {

    function UpdateOrderStatus() {
        $this->UpdateOrderStatusCron();
    }


    function UpdateOrderStatusCron() {
        
        $q = mysql_query("UPDATE tbl_order_items SET Status = 'Completed' WHERE `Status` = 'Delivered' AND `DisputedStatus` != 'Disputed' AND `ItemDateAdded` <= DATE(CURDATE() - INTERVAL 30 day)");
        //$arrRes = mysql_fetch_array($q);
                //or die(mysql_error());
        
        //print_r($q);
        if ($q) {
            echo "Success...";
        } else {
            echo "Update Error...";
        }
    }

}

$objOrderStatus = new Update_OrderStatus();
$objOrderStatus->UpdateOrderStatus();
?>