<?php

ini_set("soap.wsdl_cache_enabled", "0");
// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 4.0.0
require_once(COMPONENTS_SOURCE_ROOT_PATH . "shipping/fedex/ServiceAvailability/library/fedex-common.php");

class FedEx {

    function getFedExRateAvail($customerInfo, $arrProduct) {
    	
        $objFedExCommon = new FedExCommon();

        $customerName = $customerInfo['CustomerName'];
        $address1 = $customerInfo['ShippingAddressLine1'];
        $address2 = $customerInfo['ShippingAddressLine2'];
        $city = $customerInfo['ShippingCity'];
        $state = $customerInfo['ShippingState'];
        $country = $customerInfo['iso_code_2'];
        $postalcode = $customerInfo['ShippingPostalCode'];

        $CompanyName = $arrProduct['CompanyName'];
        $waddress1 = $arrProduct['CompanyAddress1'];
        $waddress2 = $arrProduct['CompanyAddress2'];
        $wcity = $arrProduct['CompanyCity'];
        $wstate = $arrProduct['CompanyState'];
        $wcountry = $arrProduct['iso_code_2'];
        $wpostcode = $arrProduct['CompanyPostalCode'];

        //The WSDL is not included with the sample code.
        //Please include and reference in $path_to_wsdl variable.
        $path_to_wsdl = COMPONENTS_SOURCE_ROOT_PATH . "shipping/fedex/ServiceAvailability/wsdl/PackageMovementInformationService_v5.wsdl";
        
        $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information
        
        $request['WebAuthenticationDetail'] = array(
            'UserCredential' => array(
                'Key' => $objFedExCommon->getProperty('key'),
                'Password' => $objFedExCommon->getProperty('password')
            )
        );
        $request['ClientDetail'] = array(
            'AccountNumber' => $objFedExCommon->getProperty('shipaccount'),
            'MeterNumber' => $objFedExCommon->getProperty('meter')
        );
        $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Service Availability Request v5.1 using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'pmis',
            'Major' => '5',
            'Intermediate' => '1',
            'Minor' => '0'
        );

        $request['Origin'] = array(
            'PostalCode' => $wpostcode, // Origin details
            'CountryCode' => $wcountry
        );
        $request['Destination'] = array(
            'PostalCode' => $postalcode, // Destination details
            'CountryCode' => $country
        );
        $request['ShipDate'] = $objFedExCommon->getProperty('serviceshipdate');
        $request['CarrierCode'] = 'FDXE'; // valid codes FDXE-Express, FDXG-Ground, FDXC-Cargo, FXCC-Custom Critical and FXFR-Freight
        //$request['Service'] = 'INTERNATIONAL_PRIORITY'; // valid code STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
        $request['Packaging'] = 'YOUR_PACKAGING'; // valid code FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
        //pre($request);
        try {
            if ($objFedExCommon->setEndpoint('changeEndpoint')) {
                $newLocation = $client->__setLocation($objFedExCommon->setEndpoint('endpoint'));
            }

            $response = $client->serviceAvailability($request);

            if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') {
                return 1;
                /* echo 'The following service type(s) are available.'. Newline;
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

                  $objFedExCommon->printSuccess($client, $response); */
            } else {
                //$objFedExCommon->printError($client, $response);
            }

            //$objFedExCommon->writeToLog($client);    // Write to log file
            return 0;
        } catch (SoapFault $exception) {
            //$objFedExCommon->printFault($exception, $client);
        }
    }

    function getFedExRate($customerInfo, $arrProduct) {

        if ($this->getFedExRateAvail($customerInfo, $arrProduct) == '0')
            return '0';

        $objFedExCommon = new FedExCommon();
        $method = trim($arrProduct['shipping']['methodCode']);
       
        
        // Copyright 2009, FedEx Corporation. All rights reserved.
        // Version 12.0.0	
        //The WSDL is not included with the sample code.
        //Please include and reference in $path_to_wsdl variable.
        $path_to_wsdl = COMPONENTS_SOURCE_ROOT_PATH . "shipping/fedex/RateService/wsdl/RateService_v14.wsdl";

        $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

        $request['WebAuthenticationDetail'] = array(
            'UserCredential' => array(
                'Key' => $objFedExCommon->getProperty('key'),
                'Password' => $objFedExCommon->getProperty('password')
            )
        );
        $request['ClientDetail'] = array(
            'AccountNumber' => $objFedExCommon->getProperty('shipaccount'),
            'MeterNumber' => $objFedExCommon->getProperty('meter')
        );
        $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request v14 using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'crs',
            'Major' => '14',
            'Intermediate' => '0',
            'Minor' => '0'
        );
        $request['ReturnTransitAndCommit'] = true;
        $request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
        $request['RequestedShipment']['ShipTimestamp'] = date('c');
        //$request['RequestedShipment']['ServiceType'] = $method; //'INTERNATIONAL_PRIORITY'; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
        $request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
        $request['RequestedShipment']['TotalInsuredValue'] = array(
            'Ammount' => 100,
            'Currency' => 'USD'
        );
        $request['RequestedShipment']['Shipper'] = $this->addShipper($arrProduct);
        $request['RequestedShipment']['Recipient'] = $this->addRecipient($customerInfo);
        $request['RequestedShipment']['ShippingChargesPayment'] = $this->addShippingChargesPayment();
        //$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT';
        $request['RequestedShipment']['RateRequestTypes'] = 'LIST';
        $request['RequestedShipment']['PackageCount'] = '1';
        $request['RequestedShipment']['RequestedPackageLineItems'] = $this->addPackageLineItem1($arrProduct);

        try {
            if ($objFedExCommon->setEndpoint('changeEndpoint')) {
                $newLocation = $client->__setLocation($objFedExCommon->setEndpoint('endpoint'));
            }
            //echo '<pre>';print_r($request);echo '</pre>';
            $response = $client->getRates($request);

            if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') {
                $rateReply = $response->RateReplyDetails;

                //pre($response->RateReplyDetails);
                $arr = array();
                foreach ($rateReply as $k => $v) {
                    $arr[$k]['ServiceType'] = $v->ServiceType;
                    $arr[$k]['DeliveryTimestamp'] = $v->DeliveryTimestamp;
                    $arr[$k]['ShippingCost'] = $v->RatedShipmentDetails[2]->ShipmentRateDetail->TotalNetCharge->Amount;
                }

                return $arr;
                //return number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount, 2, ".", ",");
                /* echo '<table border="1">';
                  echo '<tr><td>Service Type</td><td>Amount</td><td>Delivery Date</td></tr><tr>';
                  $serviceType = '<td>'.$rateReply -> ServiceType . '</td>';
                  $amount = '<td>$' . number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") . '</td>';
                  if(array_key_exists('DeliveryTimestamp',$rateReply)){
                  $deliveryDate= '<td>' . $rateReply->DeliveryTimestamp . '</td>';
                  }else if(array_key_exists('TransitTime',$rateReply)){
                  $deliveryDate= '<td>' . $rateReply->TransitTime . '</td>';
                  }else {
                  $deliveryDate='<td>&nbsp;</td>';
                  }
                  echo $serviceType . $amount. $deliveryDate;
                  echo '</tr>';
                  echo '</table>';

                  printSuccess($client, $response); */
            } else {
                return 0;
                //$objFedExCommon->printError($client, $response);
            }

            $objFedExCommon->writeToLog($client);    // Write to log file   
            return 0;
        } catch (SoapFault $exception) {
            //$objFedExCommon->printFault($exception, $client);
        }
    }

    function addShipper($arrProduct) {
        $CompanyName = $arrProduct['CompanyName'];
        $waddress1 = $arrProduct['CompanyAddress1'];
        $waddress2 = $arrProduct['CompanyAddress2'];
        $wcity = $arrProduct['CompanyCity'];
        $wstate = $arrProduct['CompanyState'];
        $wcountry = $arrProduct['iso_code_2'];
        $wpostcode = $arrProduct['CompanyPostalCode'];
        $shipper = array(
            'Contact' => array(
                'PersonName' => $CompanyName,
                'CompanyName' => $CompanyName,
                'PhoneNumber' => ''
            ),
            'Address' => array(
                'StreetLines' => array($waddress1 . " " . $waddress2),
                'City' => $wcity,
                'PostalCode' => $wpostcode,
                'CountryCode' => $wcountry
            )
        );
        return $shipper;
    }

    function addRecipient($customerInfo) {
        $customerName = $customerInfo['CustomerName'];
        $address1 = $customerInfo['ShippingAddressLine1'];
        $address2 = $customerInfo['ShippingAddressLine2'];
        $city = $customerInfo['ShippingCity'];
        $state = $customerInfo['ShippingState'];
        $country = $customerInfo['iso_code_2'];
        $postalcode = $customerInfo['ShippingPostalCode'];
        $recipient = array(
            'Contact' => array(
                'PersonName' => $customerName,
                'CompanyName' => '',
                'PhoneNumber' => ''
            ),
            'Address' => array(
                'StreetLines' => array($address1 . "," . $address2),
                'City' => $city,
                'PostalCode' => $postalcode,
                'CountryCode' => $country,
                'Residential' => false
            )
        );
        return $recipient;
    }

    function addShippingChargesPayment() {
        $objFedExCommon = new FedExCommon();
        $shippingChargesPayment = array(
            'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
            'Payor' => array(
                'ResponsibleParty' => array(
                    'AccountNumber' => $objFedExCommon->getProperty('billaccount'),
                    'CountryCode' => 'AU'
                )
            )
        );
        return $shippingChargesPayment;
    }

    function addLabelSpecification() {
        $labelSpecification = array(
            'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
            'ImageType' => 'PDF', // valid values DPL, EPL2, PDF, ZPLII and PNG
            'LabelStockType' => 'PAPER_7X4.75'
        );
        return $labelSpecification;
    }

    function addSpecialServices() {
        $specialServices = array(
            'SpecialServiceTypes' => array('COD'),
            'CodDetail' => array(
                'CodCollectionAmount' => array(
                    'Currency' => 'USD',
                    'Amount' => 150
                ),
                'CollectionType' => 'ANY' // ANY, GUARANTEED_FUNDS
            )
        );
        return $specialServices;
    }

    function addPackageLineItem1($arrProduct) {
        $weightUnit = 'LB';
        $weight = $this->convertLBS($arrProduct['WeightUnit'], $weightUnit, $arrProduct['Weight']);

        $dimensionUnit = "IN"; //$arrProduct['DimensionUnit'];
        $length = $this->convertInch($arrProduct['DimensionUnit'], $dimensionUnit, $arrProduct['Length']);
        $width = $this->convertInch($arrProduct['DimensionUnit'], $dimensionUnit, $arrProduct['Width']);
        $height = $this->convertInch($arrProduct['DimensionUnit'], $dimensionUnit, $arrProduct['Height']);

        $method = trim($arrProduct['shipping']['methodCode']);
        $packageLineItem = array(
            'SequenceNumber' => 1,
            'GroupPackageCount' => 1,
            'Weight' => array(
                'Value' => $weight,
                'Units' => $weightUnit
            ),
            'Dimensions' => array(
                'Length' => $length,
                'Width' => $width,
                'Height' => $height,
                'Units' => $dimensionUnit
            )
        );
        return $packageLineItem;
    }

    function convertLBS($from, $to, $weight) {
        global $objGeneral;
        $varWeight = $objGeneral->massConverter($from, $to, $weight);

        return $varWeight;
    }

    function convertInch($from, $to, $length) {
        global $objGeneral;
        $varLength = $objGeneral->lengthConverter($from, $to, $length);

        return $varLength;
    }

}

?>