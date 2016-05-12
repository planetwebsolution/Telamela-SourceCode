<?php
require_once 'common/config/config.inc.php';
require_once CLASSES_PATH . 'class_order_process_bll.php';
require_once CONTROLLERS_PATH . FILENAME_ORDERPROCESSS_CTRL;

if (!isset($_SESSION['sessUserInfo']['type']) || $_SESSION['sessUserInfo']['type'] <> 'customer' || $_SESSION['MyCart']['Total'] < 1) {
    header('location:' . SITE_ROOT_URL);
}

if (isset($_SESSION['MyCart'])) {
    unset($_SESSION['MyCart']);
}
$_SESSION['MyCart'] = array();
//pre($_SESSION['MyCart']);
//$objOrderProcessPage = new OrderProcessPageCtrl();
$objOrderProcess = new OrderProcess();

$shippedDays = $objOrderProcess->getMaxShippedDays($_SESSION['sessUserInfo']['id']);
$shippedDays = (int) $shippedDays;

//******************************************************

require_once 'PPBootStrap.php';

/*
 *  # PaymentDetails API
  Use the PaymentDetails API operation to obtain information about a payment. You can identify the payment by your tracking ID, the PayPal transaction ID in an IPN message, or the pay key associated with the payment.
  This sample code uses AdaptivePayments PHP SDK to make API call
 */
/*
 * 
  PaymentDetailsRequest which takes,
  `Request Envelope` - Information common to each API operation, such
  as the language in which an error message is returned.
 */
$requestEnvelope = new RequestEnvelope("en_US");
/*
 * 		 PaymentDetailsRequest which takes,
  `Request Envelope` - Information common to each API operation, such
  as the language in which an error message is returned.
 */
$paymentDetailsReq = new PaymentDetailsRequest($requestEnvelope);
/*
 * 		 You must specify either,

 * `Pay Key` - The pay key that identifies the payment for which you want to retrieve details. This is the pay key returned in the PayResponse message.
 * `Transaction ID` - The PayPal transaction ID associated with the payment. The IPN message associated with the payment contains the transaction ID.
  `paymentDetailsRequest.setTransactionId(transactionId)`
 * `Tracking ID` - The tracking ID that was specified for this payment in the PayRequest message.
  `paymentDetailsRequest.setTrackingId(trackingId)`
 */
if ($_SESSION['pay_key'] != "") {
    $paymentDetailsReq->payKey = $_SESSION['pay_key'];
}
/*
 * 	 ## Creating service wrapper object
  Creating service wrapper object to make API call and loading
  Configuration::getAcctAndConfig() returns array that contains credential and config parameters
 */
$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());

//*****************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thanks for Payment</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.drop_down1').sSelect();
            });
        </script>
    </head>
    <body>
        <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header"><div class="layout">

            </div>
        </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">

                <?php
                try {
                    /* wrap API method calls on the service object with a try catch */

                    $response = $service->PaymentDetails($paymentDetailsReq);
                    //print_r($response);
                    if ($response->status == 'COMPLETED') {

                        /* wrap API method calls on the service object with a try catch */
                        $response = $service->PaymentDetails($paymentDetailsReq);
                        for ($i = 0; $i < count($response->paymentInfoList->paymentInfo); $i++) {
                            $transaction_id = $response->paymentInfoList->paymentInfo[$i]->transactionId . ", " . $transaction_id;

                            if ($response->paymentInfoList->paymentInfo[$i]->receiver->primary == "true") {
                                $totalamount = $response->paymentInfoList->paymentInfo[$i]->receiver->amount;
                                echo '<span style="color:black;" id="primary"></span>.00';
                            } else {
                                $secondry_total = $secondry_total + $response->paymentInfoList->paymentInfo[$i]->receiver->amount;
                                $totalamount = $totalamount + $response->paymentInfoList->paymentInfo[$i]->receiver->amount;
                            }
                        }
                        //die;
                        $CustomerID = (int) $_SESSION['sessUserInfo']['id'];

                        $objPage = new OrderProcessPageCtrl();
                        if ($CustomerID > 0)
                            $objPage->pageLoad($CustomerID, $transaction_id, $totalamount, $response->paymentInfoList->paymentInfo);
                        ?>
                        <div class="add_pakage_outer">
                            <div class="top_header border_bottom">
                                <h1>Thank You</h1>

                            </div>            
                            <div class="body_inner_bg radius">
                                <div class="thans_sec">
                                    <h1>Congratulations</h1>
                                    <p><strong>Thank you for placing the order.</strong></p>
        <!--                            <p style="font-weight: bold;">Your order will be shipped in <?php echo ($shippedDays > 0) ? $shippedDays : 2; ?> days.</p>-->
                                    <span style="padding-top: 43px"><img src="common/images/right_img.png" alt=""/></span>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else if ($response->status == 'INCOMPLETE') {
                        echo "<h3 id='fail'>Payment - Failed</h3>";
                        echo '<p><center>Error msg :- This transaction cannot be processed.</center></p>';
                        echo "<div class='back_btn'><a  href='index.php' id= 'btn'><< Back</a></div>";
                    } else if ($response->status == 'ERROR') {
                        echo "<h3 id='fail'>Payment - Failed</h3>";
                        echo '<p><center>Error msg :- The payment failed and all attempted transfers failed</center></p>';
                        echo "<div class='back_btn'><a  href='index.php' id= 'btn'><< Back</a></div>";
                    } else if ($response->status == 'PENDING') {
                        echo "<h3 id='fail'>Payment - PENDING</h3>";
                        echo '<p><center>Error msg :- The payment is awaiting processing</center></p>';
                        echo "<div class='back_btn'><a  href='index.php' id= 'btn'><< Back</a></div>";
                    } else if ($response->status == 'CREATED') {
                        echo "<h3 id='fail'>Payment - CREATED</h3>";
                        echo '<p><center>Error msg :- The payment request was received; funds will be transferred once the payment is approved</center></p>';
                        echo "<div class='back_btn'><a  href='index.php' id= 'btn'><< Back</a></div>";
                    } else {
                        echo "<h3 id='fail'>Payment - Failed</h3>";
                        echo '<p><center>Error msg :- This transaction cannot be processed.</center></p>';
                        echo "<div class='back_btn'><a  href='index.php' id= 'btn'><< Back</a></div>";
                    }
                } catch (Exception $ex) {
                    require_once 'common/paypal/Error.php';
                    exit;
                }
                ?>                


            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php';
        ?>

    </body>
</html> 


<script type="text/javascript">
    $(document).ready(function () {

        $.post(SITE_ROOT_URL + "common/ajax/ajax_cart.php", {
            action: "CartPopupForSuccess"
        }, function (e) {
            $(".RewardPop").text(e);
            $("#activity").css('display','block');
        })

    });

</script>
