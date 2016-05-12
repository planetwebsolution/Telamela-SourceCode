<?php
// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 4.0.0

require_once('../library/fedex-common.php');

//The WSDL is not included with the sample code.
//Please include and reference in $path_to_wsdl variable.
$path_to_wsdl = "../wsdl/PackageMovementInformationService_v5.wsdl";

ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$request['WebAuthenticationDetail'] = array(
	'UserCredential' => array(
		'Key' => getProperty('key'), 
		'Password' => getProperty('password')
	)
);
$request['ClientDetail'] = array(
	'AccountNumber' => getProperty('shipaccount'), 
	'MeterNumber' => getProperty('meter')
);
$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Service Availability Request v5.1 using PHP ***');
$request['Version'] = array(
	'ServiceId' => 'pmis', 
	'Major' => '5', 
	'Intermediate' => '1', 
	'Minor' => '0'
);
$request['Origin'] = array(
	'PostalCode' => '99501', // Origin details
    'CountryCode' => 'US'
);
$request['Destination'] = array(
	'PostalCode' => '99925', // Destination details
 	'CountryCode' => 'US'
 );
$request['ShipDate'] = getProperty('serviceshipdate');
$request['CarrierCode'] = 'FDXE'; // valid codes FDXE-Express, FDXG-Ground, FDXC-Cargo, FXCC-Custom Critical and FXFR-Freight
$request['Service'] = 'PRIORITY_OVERNIGHT'; // valid code STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
$request['Packaging'] = 'YOUR_PACKAGING'; // valid code FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...



try {
	if(setEndpoint('changeEndpoint')){
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}
	
	$response = $client ->serviceAvailability($request);

    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
        echo 'The following service type(s) are available.'. Newline;
        echo '<table border="1">';
        foreach ($response->Options as $optionKey => $option){
        	echo '<tr><td><table>';
        	if(is_string($option)){
				echo '<tr><td>' . $optionKey . '</td><td>' . $option . '</td></tr>';
        	}else{           
				foreach($option as $subKey => $subOption){
					echo '<tr><td>' . $subKey . '</td><td>' . $subOption . '</td></tr>';
				}
        	}
        	echo '</table></td></tr>';
        }
        echo'</table>';
        
    	printSuccess($client, $response);
    }else{
        printError($client, $response);
    } 
    
    writeToLog($client);    // Write to log file   
} catch (SoapFault $exception) {
    printFault($exception, $client);
}
?>
