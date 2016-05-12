<?php

function sendRequest($api_url, $token, $json_request)
{
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

    //echo '<br>';
    print_r($curl_result);
    exit;

    if (curl_errno($ch))
    {
        //echo 'Curl error: ' . curl_error($ch);
        echo 'Could not connect to the Telamela server. Please try again.';
        exit;
    }
    curl_close($ch);
    return $curl_result;
}

define("LOCAL_MODE", 1);
if (LOCAL_MODE)
{
    //die('local');
    //$api_url = 'http://localhost/telamela/api/mobile/json/1.0/index.php';
    $api_url = 'http://dothejob.in/telamela-new/api/mobile/json/1.0/index.php';
    $api_token = 'AE313BB0633E8935DF43A5F5E9DAD48E';
}
else
{
    //die('s');
    $api_url = 'http://www.telamela.com.au/api/mobile/json/1.0/index.php';

    $api_token = 'AE313BB0633E8935DF43A5F5E9DAD48E';
}
//print_r($_REQUEST);
//print_r(json_decode($_REQUEST['personnelInformation']));die;
$jsonBuilt = array();
foreach($_REQUEST as $key=>$makearray){
	if(json_decode($makearray)){
	     $jsonBuilt[$key] =  json_decode($makearray);
    }else{
    	$jsonBuilt[$key] =  $makearray;
    }
}
//print_r($jsonBuilt);die;
$request = json_encode($jsonBuilt);
//$request = file_get_contents('json/request/shipping.json');
//print_r($request);die;

//echo $objCore->getImageUrl($objPage->arrData['arrTodayOfferProduct']['product_details'][0]['ProductImage'], 'products/' . $arrProductImageResizes['cart']); 

if ($request != '')
{
    $response = sendRequest($api_url, $api_token, $request);
    print_r($response);
    $response = json_decode($response, true);
//    echo '<pre>';
//    print_r($response);
//    die;
}
else
{
    echo 'Please check ' . __FILE__;
    die;
}



?>


