<?php
/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_customer_user_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class ShippingCtrl extends Paging {
    /*
     * Variable declaration begins
     *
     * holds the heading of the page
     */

    public $varHeading = '';

    /*
     * constructor
     */

    public function __construct() {
        /*
         * Checking valid login session
         */
        //$objCore = new Core();
        //echo $objCore->setSuccessMsg();
        $objAdminLogin = new AdminLogin();
        //check admin session
        $objAdminLogin->isValidAdmin();
        //************ Get Admin Email here
    }


    /**
     * function pageLoads
     *
     * This function Will be called on each page load and will check for any form submission.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $objPage->pageLoad();
     *
     * @access public
     *
     * @return void
     */
    public function pageLoad() {
        $objCore = new Core();
		$objCustomer = new Customer();
		
		$msg = $_REQUEST['frmnotificationTitle'];
		$text_message = $_REQUEST['frmnotificationDescription'];
		$url = $_REQUEST['frmnotificationUrl'];
		
		$arrRes = $objCustomer->getCustomerList();
        foreach($arrRes as $val){
			if($val['user_type'] == 'a'){
				$this->simplePushNotificationA($msg,$text_message,$url,$val['device_id'], 'Admin');
			}
			if($val['user_type'] == 'i'){
				$this->simplePushNotificationI($msg,$text_message,$url,$val['device_id'], 'Admin');
			}
		}
		$objCore->setSuccessMsg('Notification sent successfully.');
       
    }
	
	/**
     * Function
     *
     * @author 		Gaurav Bansal
     * @uses		Function used To send push notification in iphone
     * @access		--
     * @created by	Gaurav Bansal
     * @created on	03 Mar 2015
     */
    public static function simplePushNotificationI($msg = NULL, $text_message = NULL, $url = NULL, $device_id = NULL, $type = NULL) {
//echo WWW_ROOT;
        // Put your device token here (without spaces):
        //$deviceToken = '89fc830f0574ac6d05fdc85d4c2a5fbaa22bf1547ba5eb7c2d1ed4c71f98b2ce';
        $deviceToken = $device_id;
        // Put your private key's passphrase here:
        $passphrase = '12345';

        // Put your alert message here:
        $message = $msg;


        ////////////////////////////////////////////////////////////////////////////////

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', '/home/livemark/telamela-new/Certificates.pem'); 
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase); 

        // Open a connection to the APNS server
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 120, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        
        if (!$fp) {
           // exit("Failed to connect: $err $errstr" . PHP_EOL);
        }
       // echo 'Connected to APNS' . PHP_EOL;
        // Create the payload body
        $body['aps'] = array(
            'alert' => $message.':-'.$text_message,
            'type' => $type,
			'url' => $url,
            'sound' => 'default'
        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        if (!$result)
       //echo 'Message not delivered' . PHP_EOL;
            return 0;
        else
        //echo 'Message successfully delivered' . PHP_EOL;
            return 1;
        // Close the connection to the server
        die;
        fclose($fp);
        exit;
    }
	
	/**
     * Function
     *
     * @author 		Gaurav Bansal
     * @uses		Function used To send push notification in Android
     * @access		--
     * @created by	Gaurav Bansal
     * @created on	03 Mar 2015
     */
    public static function simplePushNotificationA($msg = NULL, $text_message = NULL, $url = NULL, $device_id = NULL, $type = NULL) {

        define('API_ACCESS_KEY', 'AIzaSyC3hZoodkY5kQ8QKtlkLqdgqCkVf3WRSig');


        $registrationIds = array($device_id);

        // prep the bundle
        $msg = array
            (
            'title' => $msg,
            'vibrate' => 1,
            'type' => $type,
            'message' => $text_message,
			'url' => $url,
            'sound' => 1
        );

        $fields = array
            (
            'registration_ids' => $registrationIds,
            'data' => $msg
        );

        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        if (!$result)
        //echo 'Message not delivered' . PHP_EOL;
            return 0;
        else
        //echo 'Message successfully delivered' . PHP_EOL;
            return 1;
        exit;
    }

// end of page load
}

$objPage = new ShippingCtrl();
$objPage->pageLoad();
?>
