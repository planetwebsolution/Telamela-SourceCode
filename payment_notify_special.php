<?php

require_once 'common/config/config.inc.php';
//require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_SPECIAL_FORM_CTRL;
require_once CLASSES_PATH . 'class_wholesaler_bll.php';


// STEP 1: read POST data
// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
// Instead, read raw POST data from the input stream. 
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
    $keyval = explode('=', $keyval);
    if (count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
$req = 'cmd=_notify-validate';
if (function_exists('get_magic_quotes_gpc')) {
    $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
    if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
    } else {
        $value = urlencode($value);
    }
    $req .= "&$key=$value";
}
//mail("amlana.pattanayak@mail.vinove.com","Notify","$req");
// Step 2: POST IPN data back to PayPal to validate

$ch = curl_init(PAYPAL_URL);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
if (DEBUG == true) {
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

// In wamp-like environments that do not come bundled with root authority certificates,
// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
// the directory path of the certificate as shown below:
// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
$res = curl_exec($ch);
if (curl_errno($ch) != 0) { // cURL error
    if (DEBUG == true) {
        //mail("suraj.maurya@mail.vinove.com", "Can't connect to PayPal", "Can't connect to PayPal");
        error_log(date('[Y-m-d H:i e] ') . "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
    }
    curl_close($ch);
    exit;
} else { // Log the entire HTTP response if debug is switched on.
    if (DEBUG == true) {
        //mail("amlana.pattanayak@mail.vinove.com"," connect to PayPal"," connect to PayPal");
        error_log(date('[Y-m-d H:i e] ') . "HTTP request of validation request:" . curl_getinfo($ch, CURLINFO_HEADER_OUT) . " for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
        error_log(date('[Y-m-d H:i e] ') . "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);

        // Split response headers and payload
        list($headers, $res) = explode("\r\n\r\n", $res, 2);
    }
    curl_close($ch);
}
//mail("suraj.maurya@mail.vinove.com", "RES", "$res");
// Inspect IPN validation result and act accordingly
if (strstr($res, "VERIFIED") != '') {
    // check whether the payment_status is Completed
    // check that txn_id has not been previously processed
    // check that receiver_email is your PayPal email
    // check that payment_amount/payment_currency are correct
    // process payment and mark item as paid.
    // assign posted variables to local variables
    //$item_name = $_POST['item_name'];
    //$item_number = $_POST['item_number'];
    //$payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    //$payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    //$receiver_email = $_POST['receiver_email'];
    //$payer_email = $_POST['payer_email'];
     //mail("raju.khatak@mail.vinove.com", "post", print_r($_POST,1));
     //mail("raju.khatak@mail.vinove.com", "payment", $payment_amount);

    $ApplicationIds = str_replace('ApplicationIds-', '', base64_decode($_POST['custom']));
//mail("raju.khatak@mail.vinove.com", "paymentAppId", $ApplicationIds);
    if ($ApplicationIds <> '')
        paymentProcess($ApplicationIds, $txn_id, $payment_amount);

    if (DEBUG == true) {
        error_log(date('[Y-m-d H:i e] ') . "Verified IPN: $req " . PHP_EOL, 3, LOG_FILE);
    }
} else if (strstr($res, "INVALID") != '') {
    // log for manual investigation
    // Add business logic here which deals with invalid IPN messages
    //mail("amlana.pattanayak@mail.vinove.com","Invalid IPN","Invalid IPN");
    if (DEBUG == true) {
        error_log(date('[Y-m-d H:i e] ') . "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
    }
}

function paymentProcess($applicationIds, $txn_id, $payment_amount) {
    $objWholesaler = new Wholesaler();
    global $objGeneral;
    $objWholesaler->updateApplicationPayment($applicationIds, $txn_id, $payment_amount);
    
    $arrSubject = array(
        'adminSubject' => 'An special application form submitted by wholsaler.',
        'wholesalerSubject' => 'Thank you for placing your application.'
    );
    
    $objGeneral->sendSpecialFormNotificationEmail($applicationIds,$arrSubject);
}

?>