<?php

function sendRequest($api_url, $token, $json_request) {
    // Submit curl request

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_USERPWD, $token . ':');
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'json_data=' . $json_request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Telamela API tester 1.0");
    $curl_result = curl_exec($ch);

    echo '<br>';print_r($curl_result);exit;

    if (curl_errno($ch)) {
        //echo 'Curl error: ' . curl_error($ch);
        echo 'Could not connect to the Telamela server. Please try again.';
        exit;
    }
    curl_close($ch);
    return $curl_result;
}

define("LOCAL_MODE", '0');

if (LOCAL_MODE == '0') {  
    //$api_url = 'http://localhost/telamela/api/offline/json/1.0/index.php';
    $api_url = 'http://dothejob.in/telamela/api/mobile/json/1.0/index.php';
    $api_token = '070C30B1CD5E611148BAF5D46884EE80';
} else if (LOCAL_MODE == '1') {
    $api_url = 'http://i.vinove.com/telamela/api/offline/json/1.0/index.php';
    $api_token = '070C30B1CD5E611148BAF5D46884EE80';
} else {       //LIVE
    $api_url = 'http://www.telamela.com.au/api/offline/json/1.0/index.php';
    $api_token = '070C30B1CD5E611148BAF5D46884EE80';
}

//$arrRequest = array('method'=>'loginWholesaler','auth'=>array('email'=>'suraj.maurya@mail.vinove.com','password'=>'123456')); 
//$arrRequest = array('method'=>'getProduct'); 
//$request = json_encode($arrRequest);
$request = json_encode($_REQUEST);
//$request = file_get_contents('json/request/get_all_categories.json');
//print_r($request);
//die();

if ($request != '') {
    $response = sendRequest($api_url, $api_token, $request);
    //print_r($response);
    $response = json_decode($response, true);
    echo '<pre>';
    print_r($response);
    die;
} else {
    echo 'Please check ' . __FILE__;
    die;
}
?>
