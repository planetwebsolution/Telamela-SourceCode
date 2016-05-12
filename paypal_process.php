<?php
require_once 'common/config/config.inc.php';

//pre($_SESSION);
require_once CLASSES_PATH . 'class_shopping_cart_bll.php';
require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_paypal_email_bll.php';
require_once CLASSES_PATH . 'class_order_process_bll.php';


$objShoppingCart = new ShoppingCart();
$arrCart = $objShoppingCart->myCartDetails();


//echo '<pre>';
//print_r($_SESSION);
//pre($arrCart);
$objOrderProcess = new OrderProcess();
$objCustomer = new Customer();
$objCountryPaypal = new Paypal_email();
global $objGeneral;
//pre($arrCart[newCountry]);die;
//print_r(curl_version());
// print_r($arrCart[newCountry]);
//***************************************************/
require_once 'PPBootStrap.php';
require_once 'common/paypal/Constants.php';
define("DEFAULT_SELECT", "- Select -");

$cancelUrl = SITE_ROOT_URL . "payment_cancel.php";
$memo = "Adaptive Payment - chained Payment";
$actionType = "PAY";
$currencyCode = "USD";


if (count($arrCart['GiftCard']) > 0) {
    $returnUrl = SITE_ROOT_URL . "gift_success.php";
} else {
    $returnUrl = SITE_ROOT_URL . "payment_success.php";
}



//$amount = $_POST['amount'];
//$receiverEmail = array("business1.test@gmail.com", "business2.test@gmail.com");
//$receiverAmount = array("40", "35");
//$primaryReceiver = array("true", "false");
$receiverAmount = array();
$receiverEmail = array();
$primaryReceiver = array();
$receiverEmail = array($arrCart['Common']['SuperAdminPaypal']) ;
$primaryReceiver = array(true); 
$receiverAmount = array($arrCart['Common']['CartTotal']);
//pre($receiverAmount);
//pre($arrCart);
$arrCart[newCountry] = array_values($arrCart[newCountry]);

for ($i = 0; $i < count($arrCart[newCountry]); $i++) {

    $pricewithshipping = $arrCart[newCountry][$i]['PriceWithShipping'];
    $adminmail = $arrCart[newCountry][$i]['PaypalEmailID'];

    if ($pricewithshipping != "" and $adminmail != "") {
		//$pricewithshipping = $pricewithshipping - ($pricewithshipping * 15/100);
        $receiverAmount[] = $pricewithshipping;

        $receiverEmail[] = $adminmail;
		$primaryReceiver[] = false;
    } else {
        echo "Receiver Email id NOT found !!";
        die();
    }
}

// $receiverEmail = array("business1.test@gmail.com", "business2.test@gmail.com","tmtest1@gmail.com", "tmtest2@gmail.com");
// $receiverAmount = array("150", "40","45", "35");
//$primaryReceiver = array("true", "false","false", "false");
//echo "<pre>";
//print_r($receiverAmount);
//print_r($receiverEmail);
//die();	
//aus@telamela.com.au
//india@telamela.com.au

if (isset($receiverEmail)) {
    $receiver = array();
    /*
     * A receiver's email address 
     */
    for ($i = 0; $i < count($receiverEmail); $i++) {
        $receiver[$i] = new Receiver();
        $receiver[$i]->email = $receiverEmail[$i];
        /*
         *  	Amount to be credited to the receiver's account 
         */
        $receiver[$i]->amount = $receiverAmount[$i];

        /* Set to true to indicate a chained payment; only one receiver can be a primary receiver. Omit this field, or set it to false for simple and parallel payments. 
         */
        $receiver[$i]->primary = $primaryReceiver[$i];
    }



    $receiverList = new ReceiverList($receiver);
}

$payRequest = new PayRequest(new RequestEnvelope("en_US"), $actionType, $cancelUrl, $currencyCode, $receiverList, $returnUrl);
// Add optional params
//print_r($payRequest);
//die("OK");
if ($memo != "") {
    $payRequest->memo = $memo;
}
/*
 * 	 ## Creating service wrapper object
  Creating service wrapper object to make API call and loading
  Configuration::getAcctAndConfig() returns array that contains credential and config parameters
 */
$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());

//print_r($service);
//die("OK");
try {
    /* wrap API method calls on the service object with a try catch */
    $response = $service->Pay($payRequest);
    $ack = strtoupper($response->responseEnvelope->ack);
   // echo"<pre>";
  // print_r($ack);
    //die("OK");
    if ($ack == "SUCCESS") {
        $payKey = $response->payKey;
        $_SESSION['pay_key'] = $payKey;
        $_SESSION['ForRewardPopup'] = 1;
        $payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey;
        header('Location:' . $payPalURL);
    }else{
		echo "<h3 id='fail'>Payment - Failed</h3>";
         echo '<p><center>Error msg :- This transaction cannot be processed.</center></p>';
         echo "<div class='back_btn'><a  href='index.php' id= 'btn'><< Back</a></div>";
		}
} catch (Exception $ex) {
    require_once 'common/paypal/Error.php';
    exit;
}
/* Make the call to PayPal to get the Pay token
  If the API call succeded, then redirect the buyer to PayPal
  to begin to authorize payment.  If an error occured, show the
  resulting errors */


//**************************************************

/*
  $arrCustomerInfo = $objCustomer->CustomerDetailsWithCountryName($_SESSION['sessUserInfo']['id']);
  //pre($arrCustomerInfo);die;
  $paypal_id = $objCountryPaypal->getCountryPaypalId($arrCustomerInfo[0]['ShippingCountry']);


  $varGrandPrice = 0;
  foreach ($arrCart['Product'] as $key => $val)
  {
  $varSubTotal = ($val['FinalPrice'] * $_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['qty']) - $val['Discount'];
  $varGrantPrice += ($varSubTotal + $_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['AppliedShipping']['ShippingCost']);
  }

  foreach ($arrCart['Package'] as $key => $val)
  {
  $varSubTotal = $_SESSION['MyCart']['Package'][$val['pkPackageId']][$key]['qty'] * $val['PackagePrice'];
  $varGrantPrice += ($varSubTotal + $_SESSION['MyCart']['Package'][$val['pkPackageId']][$key]['AppliedShipping']['ShippingCost']);
  }

  foreach ($arrCart['GiftCard'] as $key => $val)
  {
  $varSubTotal = $val['qty'] * $val['amount'];
  $varGrantPrice += $varSubTotal;
  }



  $cartTotalPrice = ($varGrantPrice < MINIMUM_ORDER_PRICE) ? MINIMUM_ORDER_PRICE : $varGrantPrice;

  if (isset($_SESSION['MyCart']['GiftCardCode']) && $_SESSION['MyCart']['GiftCardCode'][0] <> '')
  {
  $cartTotalPrice -= $_SESSION['MyCart']['GiftCardCode'][1];
  }

  $rewardPrice = 0;

  if (isset($_SESSION['MyCart']['arrReward']) && $_SESSION['MyCart']['arrReward']['RewardValue'] > 0)
  {

  $cartTotalPrice -=$_SESSION['MyCart']['arrReward']['RewardValue'];
  $rewardPrice = $_SESSION['MyCart']['arrReward']['RewardValue'];
  }

  function amountFormat($amount)
  {
  return number_format($amount, 2, '.', ',');
  }

  //pre($arrCart['Product']);
 */
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>xhtml.css"/>
    </head>
    <body>
        <div id="loading">
            <div id="loader_container">
<!--                <div id="loader_text"><img src="<?php echo SITE_ROOT_URL ?>common/images/loading-blue.gif" width="100px" height="100px"/></div>-->
                <div id="loader_text">Your payment request is being processed...<br/> Please do not refresh page or press back button</div>
            </div>
        </div> 
<?php
//$paypal_id='lwsell_1361846732_biz@gmail.com'; // Business email ID
/*
if ($cartTotalPrice > 0 && $_POST['frmButtonPaypal'] == PAYMENT_PAYNOW_BUTTON) { // Process Gift Card
    $discount = $_SESSION['MyCart']['GiftCardCode'][1] + $rewardPrice;
    // pre($discount);
    $varGrandTotal = 0;
    $varTotalDiscount = 0;
    ?>
            <form action="<?php echo PAYPAL_URL; ?>" method="post" name="frmPayPal1">
                <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="upload" value="1">
            <?php
            $cnt = 1;

            foreach ($arrCart['Product'] as $key => $val) {

                $total = ($val['FinalPrice'] * $val['qty']) + $_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['AppliedShipping']['ShippingCost'];
                $varGrandTotal +=$total;
                $varTotalDiscount+=$val['Discount'];

                $amt = $val['FinalPrice'];
                ?>
                    <input type="hidden" name="item_name_<?php echo $cnt ?>" value="<?php echo $val['ProductName']; ?>">
                    <input type="hidden" name="amount_<?php echo $cnt ?>" value="<?php echo amountFormat($amt); ?>">
                    <input type="hidden" name="quantity_<?php echo $cnt ?>" value="<?php echo $val['qty']; ?>">

                    <?php
                    /*
                     * NOTE: we are avoiding to send seprate shipping value with this form because it will occuer issues when redeem points or use gift coupon
                     *  so we are adding shipping charge with product price;
                     * /
                    ?>

                    <input type="hidden" name="shipping_<?php echo $cnt ?>" value="<?php echo amountFormat($_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['AppliedShipping']['ShippingCost']); ?>">


                    <?php
                    $cnt++;
                }
                foreach ($arrCart['Package'] as $key => $val) {
                    $total = ($val['PackagePrice'] * $val['qty']) + $_SESSION['MyCart']['Package'][$val['pkPackageId']][$key]['AppliedShipping']['TotalShippingCost'];
                    $varGrandTotal +=$total;
                    $amt = $val['PackagePrice'] + $_SESSION['MyCart']['Package'][$val['pkPackageId']][$key]['AppliedShipping']['TotalShippingCost'] - $val['Discount'];
                    ?>
                    <input type="hidden" name="item_name_<?php echo $cnt ?>" value="<?php echo $val['PackageName']; ?> [Package]">
                    <input type="hidden" name="amount_<?php echo $cnt ?>" value="<?php echo amountFormat($amt); ?>">
                    <input type="hidden" name="quantity_<?php echo $cnt ?>" value="<?php echo $val['qty']; ?>">
                    <input type="hidden" name="shipping_<?php echo $cnt ?>" value="<?php echo amountFormat($_SESSION['MyCart']['Package'][$val['pkPackageId']][$key]['AppliedShipping']['ShippingCost']); ?>">

                    <?php
                    $cnt++;
                }
                foreach ($arrCart['GiftCard'] as $key => $val) {
                    $total = ($val['amount'] * $val['qty']);
                    $varGrandTotal +=$total;
                    ?>
                    <input type="hidden" name="item_name_<?php echo $cnt ?>" value="<?php echo $val['toName']; ?> [Gift Card]">
                    <input type="hidden" name="amount_<?php echo $cnt ?>" value="<?php echo amountFormat($val['amount']); ?>">
                    <input type="hidden" name="quantity_<?php echo $cnt ?>" value="<?php echo $val['qty']; ?>">
                    <?php
                    $cnt++;
                }
                ?>
                <?php
                if ($discount > 0) {
                    ?>
                    <input type="hidden" name="discount_amount_cart" value="<?php echo amountFormat($discount); ?>">
        <?php
    } else {
        ?>
                    <input type="hidden" name="discount_amount_cart" value="<?php echo amountFormat($varTotalDiscount); ?>">
                <?php } ?>

                <?php
                if (isset($_SESSION['MyCart']['Common']['IsMinimum'])) {
                    $minimum = MINIMUM_ORDER_PRICE - ($varGrandTotal + $discount);
                    ?>
                    <input type="hidden" name="handling_cart" value="<?php echo amountFormat($minimum); ?>">
                <?php } ?>

                <input type="hidden" name="cpp_header_image" value="<?php echo SITE_ROOT_URL; ?>common/images/logo.png">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="rm" value="2">
                <input type="hidden" name="cbt" value="<?php echo RETURN_TO_TELAMELA; ?>">
                <input type="hidden" name="custom" value='<?php echo base64_encode("CustomerID-" . $_SESSION['sessUserInfo']['id'] . ""); ?>'>
                <input type="hidden" name="notify_url" value="<?php echo SITE_ROOT_URL; ?>payment_notify.php" />
                <input type="hidden" name="cancel_return" value="<?php echo SITE_ROOT_URL; ?>payment_cancel.php">
                <?php if (count($arrCart['GiftCard']) > 0) { ?>
                    <input type="hidden" name="return" value="<?php echo SITE_ROOT_URL; ?>gift_success.php">   
                <?php } else {
                    ?>
                    <input type="hidden" name="return" value="<?php echo SITE_ROOT_URL; ?>payment_success.php">
                <?php } ?>
            </form>
            <script>
                document.frmPayPal1.submit();
            </script>
    <?php
} else {
    ?>
            <form action="order_process.php" method="post" name="frmOrderProcess">
                <input type="hidden" name="PayByGiftCard" value="PayByGiftCard" />
            </form>
            <script>
                document.frmOrderProcess.submit();
            </script>
                <?php
//header("location:shopping_cart.php");exit();
            } */
            ?>
    </body>
</html>