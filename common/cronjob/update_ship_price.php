<?php

//include '../config/config.inc.php';
require_once(dirname(dirname(__FILE__)) . '/config/config.inc.php');
require_once CLASSES_ADMIN_PATH . 'class_shipping_gateway_new_bll.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;

class Update_ShipPrice extends Database {
    /*     * ****************************************
      Function name : runCron
      Comments : This function call the cron functions one by one.
      User instruction : $res = $objClass->runCron();
     * **************************************** */

    function UpdatePrice() {
        $this->UpdatePriceCron();
    }

    /*     * ****************************************
      Function name : runrunNewsletterCron
      Comments : This function send newsletter to customer & wholesaler.
      User instruction : $res = $objClass->runNewsletterCron();
     * **************************************** */

    function UpdatePriceCron() {
        //mysql_query('insert into abc (`name`) values (NOW())');
        $objShipPrice = new Update_ShipPrice();

        $q = "TRUNCATE tbl_shipping_gateways_new_pricelist_cron";
        $arrRes = mysql_query($q);
        if ($arrRes) {
            $arrRes1 = mysql_query("INSERT tbl_shipping_gateways_new_pricelist_cron SELECT * FROM tbl_shipping_gateways_new_pricelist;");
            if ($arrRes1) {
                echo "Success...";
            } else{
                echo "Update Error...";
            }
        } else {
            echo "Truncate Error...";
        }
    }

}

$objShipPrice = new Update_ShipPrice();
$objShipPrice->UpdatePrice();
?>