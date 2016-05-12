<?php

require_once '../config/config.inc.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_PATH . 'class_shopping_cart_bll.php';
require_once CLASSES_PATH . 'class_shipping_price_api.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/usps/class_usps.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/ups/class_ups.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/fedex/class_fedex.php';


$objClassCommon = new ClassCommon();
$objShoppingCart = new ShoppingCart();
$objCore = new Core();

$objCustomer = new Customer();
$arrCustomer = $objCustomer->CustomerDetailsForShipping($_SESSION['sessUserInfo']['id']);
//Get Posted data
$case = $_REQUEST['action'];

//sleep(3);
switch ($case) {

    case 'showShippingMethod':

        $varWholeSalerDrop = '';
       
        if ($_REQUEST['type'] == 'pkg') {
            $arrRes = $objShoppingCart->getShippingDetailsForPackage($_REQUEST['pid'], $_REQUEST['q'],$arrCustomer);
            $type = "'package'";
            $name = 'pkg';
        } else {
            $arrRes = $objShoppingCart->getShippingDetailsForProduct($_REQUEST['pid'], $_REQUEST['q'], $_REQUEST['qty'],$arrCustomer);
            $type = "'product'";
            $name = 'pro';
        }
        $name .= '[' . $_REQUEST['name'] . ']';

        $arrRows = $arrRes[0]['Methods'];
        foreach ($arrRows as $keySelect => $valSelect) {
            $smCost = '';
            $checked = '';
            $smCostUSD = '';
            if ($keySelect == 0) {
                $checked = 'checked="checked"';
                $smCost = $objCore->getPrice($valSelect['ShippingCost']);
                $smCostUSD = $valSelect['ShippingCost'];
            }

            $varWholeSalerDrop .='<li><label>
                <input type="radio" class="styledd" name="' . $name . '" value="' . $valSelect['fkShippingGatewayID'] . '-' . $valSelect['pkShippingMethod'] . '-' . $smCostUSD . '" 
                onclick="showShippingPrice(this,' . $valSelect['fkShippingGatewayID'] . ',' . $valSelect['pkShippingMethod'] . ',' . $type . ',' . $_REQUEST['pid'] . ',' . $_REQUEST['qty'] . ');"' . $checked . ' />' .
                    $valSelect['MethodName'] . '<span class="amt">' . $smCost . '</span></label></li>';
        }
        echo $varWholeSalerDrop;

        break;

    case 'showShippingPrice':
 
        if ($_REQUEST['type'] == 'package') {
            $arrRes = $objShoppingCart->getShippingDetailsForPackage($_REQUEST['pid'], $_REQUEST['q'], $_REQUEST['smId'],0,$arrCustomer);
        } else {
            
            $arrRes = $objShoppingCart->getShippingDetailsForProduct($_REQUEST['pid'], $_REQUEST['q'], $_REQUEST['qty'], $_REQUEST['smId'],0,$arrCustomer);
        }

        $varStr = $objCore->getPrice($arrRes[0]['Methods'][0]['ShippingCost']) . 'skm' . $arrRes[0]['Methods'][0]['ShippingCost'];

        echo $varStr;

        break;
        
    case 'checkShippingAvilable':
        //pre($_REQUEST);
        $varProductShippingCountry=$_REQUEST['productShippingCountry']; //get customer country id
        $varCheckShippingByPincode=$_REQUEST['checkShippingByPincode']; //get customer postal code
        $varCheckShippingByProductId=$_REQUEST['checkShippingByProductId'];
        $varProductShippingCountryName=$_REQUEST['productShippingCountryName'];
        
        
        $getProductShippingDetails=$objShoppingCart->getProductShippingDetails($varCheckShippingByProductId);
        $getProductShippingDetailsR=$getProductShippingDetails[0];
    
        $isDom = ($varProductShippingCountry == $getProductShippingDetails['CompanyCountry']) ? 1 : 0;
        $arrCustomer=array('ShippingPostalCode'=>$varCheckShippingByPincode,'countryName'=>$varProductShippingCountry);
        $arrRes = $objShoppingCart->getShippingDetailsForProduct2($getProductShippingDetailsR['pkProductID'], $getProductShippingDetailsR['fkShippingID'], $getProductShippingDetailsR['Quantity'], 0,$isDom,$arrCustomer);
        if(count($arrRes)>0){
         echo 'available';   
        }else{
         echo 'notAvailable';     
        }
        
    break;    
}
?>
