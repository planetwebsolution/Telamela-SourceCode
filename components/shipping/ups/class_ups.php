<?php

class UPS {

    var $access = "8CBEFBEBB7C2C816";
    var $userid = "telamela";
    var $passwd = "Scei/5790";

    function getUPSAddressValid($customerInfo) {
        //Configuration
        $accessSchemaFile = COMPONENTS_SOURCE_ROOT_PATH . "shipping/ups/SchemasAddress/AccessRequest.xsd";
        $requestSchemaFile = COMPONENTS_SOURCE_ROOT_PATH . "shipping/ups/SchemasAddress/AVRequest.xsd";
        $responseSchemaFile = COMPONENTS_SOURCE_ROOT_PATH . "shipping/ups/SchemasAddress/AVResponse.xsd";

        $endpointurl = 'https://wwwcie.ups.com/ups.app/xml/AV';
        $outputFileName = SOURCE_ROOT . "common/uploaded_files/files/ups/AV_Tool_SampleResponse.xml";

        $address1 = $customerInfo['ShippingAddressLine1'];
        $address2 = $customerInfo['ShippingAddressLine2'];
        $city = $customerInfo['ShippingCity'];
        $state = $customerInfo['ShippingState'];
        $country = $customerInfo['iso_code_2'];
        $postalcode = $customerInfo['ShippingPostalCode'];

        try {
            //create AccessRequest data object
            $security = $this->getSecurityXML(array('AccessLicenseNumber' => $this->access, "UserId" => $this->userid, "Password" => $this->passwd));
            $request = $this->getAVXML(array("PostalCode" => $postalcode));
            //create Post request
            $form = array
                (
                'http' => array
                    (
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => "$security$request"
                )
            );
            //print form request
            //print_r($form);

            $request = stream_context_create($form);
            $browser = fopen($endpointurl, 'rb', false, $request);
            if (!$browser) {
                throw new Exception("Connection failed.");
            }

            //get response
            $response = stream_get_contents($browser);
            fclose($browser);

            if ($response == false) {
                throw new Exception("Bad data.");
            } else {
                //save request and response to file
                /* $fw = fopen($outputFileName,'w');	  	    	
                  fwrite($fw , "Response: \n" . $response . "\n");
                  fclose($fw); */
                //get response status
                $resp = new SimpleXMLElement($response);
                return $resp->Response->ResponseStatusCode;
            }
        } /* catch (SDOException $sdo) {
          echo $sdo;
          } */ catch (Exception $ex) {
            echo $ex;
        }
    }

    function getUPSRate($customerInfo, $arrProduct) {


        if ($this->getUPSAddressValid($customerInfo) == '0')
            return '0';

        //Configuration
        $accessSchemaFile = COMPONENTS_SOURCE_ROOT_PATH . "shipping/ups/SchemasRate/AccessRequest.xsd";
        $requestSchemaFile = COMPONENTS_SOURCE_ROOT_PATH . "shipping/ups/SchemasRate/RateRequest.xsd";
        $responseSchemaFile = COMPONENTS_SOURCE_ROOT_PATH . "shipping/ups/SchemasRate/RateResponse.xsd";

        $endpointurl = 'https://wwwcie.ups.com/ups.app/xml/Rate';
        $outputFileName = SOURCE_ROOT . "common/uploaded_files/files/ups/XOLTResult.xml";

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
        $weightUnit = 'LBS';
        $weight = $this->convertLBS($arrProduct['WeightUnit'], $weightUnit, $arrProduct['Weight']);
        $length = $arrProduct['Length'];
        $width = $arrProduct['Width'];
        $height = $arrProduct['Height'];
        $dimensionUnit = $arrProduct['DimensionUnit'];
        $method = trim($arrProduct['shipping']['methodCode']);

        try {
            //create AccessRequest data object
            $security = $this->getSecurityXML(array('AccessLicenseNumber' => $this->access, "UserId" => $this->userid, "Password" => $this->passwd));
            $request = $this->getRateXML(array("PickupTypeCode" => "07",
                "ShipperName" => "Name",
                "ShipperNumber" => "",
                "ShipperAddressAddressLine1" => $waddress1 . " " . $waddress2,
                "ShipperAddressCity" => $wcity,
                "ShipperAddressStateProvinceCode" => $wstate,
                "ShipperAddressPostalCode" => $wpostcode,
                "ShipperAddressCountryCode" => $wcountry,
                "ShipToAddressAddressLine1" => $address1 . " " . $address2,
                "ShipToAddressPostalCode" => $postalcode,
                "ShipToAddressCountryCode" => $country,
                "ShipFromAddressCompanyName" => $CompanyName,
                "ShipFromAddressAddressLine1" => $waddress1 . " " . $waddress2,
                "ShipFromAddressCity" => $wcity,
                "ShipFromAddressPostalCode" => $wpostcode,
                "ShipFromAddressCountryCode" => $wcountry,
                "ServiceCode" => $method,
                "PackagePackagingTypeCode" => "02",
                "PackagePackagingTypeDescription" => "Customer Supplied",
                "PackagePackageWeightCode" => $weightUnit,
                "PackagePackageWeightWeight" => $weight, "ShipmentServiceOptionsSchedulePickupDay" => "02", "ShipmentServiceOptionsScheduleMethod" => "02"));

            /* $request ='<?xml version="1.0" encoding="UTF-8"?>
              <RatingServiceSelectionRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
              <Request>
              <RequestAction>Rate</RequestAction>
              <RequestOption>Rate</RequestOption>
              </Request>
              <PickupType>
              <Code>07</Code>
              </PickupType>
              <Shipment>
              <Shipper>
              <Name>Name</Name>
              <ShipperNumber>
              </ShipperNumber>
              <Address>
              <AddressLine1>AddressLine1</AddressLine1>
              <City>City</City>
              <StateProvinceCode>NJ</StateProvinceCode>
              <PostalCode>07430</PostalCode>
              <CountryCode>US</CountryCode>
              </Address>
              </Shipper>
              <ShipTo>
              <Address>
              <AddressLine1>Address Line</AddressLine1>
              <City>Corado</City>
              <PostalCode>00646</PostalCode>
              <CountryCode>PR</CountryCode>
              </Address>
              </ShipTo>
              <ShipFrom>
              <Address>
              <PostalCode>33434</PostalCode>
              <CountryCode>US</CountryCode>
              </Address>
              </ShipFrom>
              <Service>
              <Code>03</Code>
              </Service>
              <Package>
              <PackagingType>
              <Code>02</Code>
              <Description>Customer Supplied</Description>
              </PackagingType>
              <PackageWeight>
              <UnitOfMeasurement>
              <Code>LBS</Code>
              </UnitOfMeasurement>
              <Weight>10</Weight>
              </PackageWeight>
              </Package>
              <ShipmentServiceOptions>
              <OnCallAir>
              <Schedule>
              <PickupDay>02</PickupDay>
              <Method>02</Method>
              </Schedule>
              </OnCallAir>
              </ShipmentServiceOptions>
              </Shipment>
              </RatingServiceSelectionRequest>
              '; */
            //create Post request
            $form = array
                (
                'http' => array
                    (
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => "$security$request"
                )
            );
            //print form request
            //print_r($form);


            $request = stream_context_create($form);
            $browser = fopen($endpointurl, 'rb', false, $request);
            if (!$browser) {
                throw new Exception("Connection failed.");
            }

            //get response
            $response = stream_get_contents($browser);
            //pre($response);
            fclose($browser);

            if ($response == false) {
                throw new Exception("Bad data.");
            } else {
                //save request and response to file
                /* $fw = fopen($outputFileName,'w');
                  fwrite($fw , "Response: \n" . $response . "\n");
                  fclose($fw); */

                //get response status
                $resp = new SimpleXMLElement($response);


                $arrRes = json_decode(json_encode($resp), true);
                //pre($arrRes['RatedShipment']);



                foreach ($arrRes['RatedShipment'] as $k => $v) {
                    //$arr[$i] = $resp->RatedShipment[$i];
                    $arr[$k]['ServiceType'] = $v['Service']['Code'];
                    $arr[$k]['DeliveryTimestamp'] = '';
                    $arr[$k]['ShippingCost'] = $v['TotalCharges']['MonetaryValue'];
                }
                
                return $arr;
                //return $resp->RatedShipment->TotalCharges->MonetaryValue;
            }
        } /* catch (SDOException $sdo) {
          echo $sdo;
          } */ catch (Exception $ex) {
            echo $ex;
        }
    }

    function convertLBS($from, $to, $weight) {
        global $objGeneral;

        $varWeight = $objGeneral->massConverter($from, $to, $weight);

        return $varWeight;
    }

    function getSecurityXML($var) {
        $xmlStr = '<?xml version="1.0" encoding="UTF-8"?>
<AccessRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<AccessLicenseNumber>' . $var['AccessLicenseNumber'] . '</AccessLicenseNumber>
	<UserId>' . $var['UserId'] . '</UserId>
	<Password>' . $var['Password'] . '</Password>
</AccessRequest>	
		';
        return $xmlStr;
    }

    function getAVXML($var) {
        $xmlStr = '<?xml version="1.0" encoding="UTF-8"?>
<AddressValidationRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<Request>
		<RequestAction>AV</RequestAction>
	</Request>
	<Address>
		<PostalCode>' . $var['PostalCode'] . '</PostalCode>
	</Address>
</AddressValidationRequest>
		';
        return $xmlStr;
    }

    function getRateXML($var) {
        $xmlStr = '<?xml version="1.0" encoding="UTF-8"?>
<RatingServiceSelectionRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<Request>
		<RequestAction>Rate</RequestAction>
		<RequestOption>Shop</RequestOption>
	</Request>
	<PickupType>
		<Code>' . $var['PickupTypeCode'] . '</Code>
	</PickupType>
	<Shipment>
		<Shipper>
			<Name>' . $var['ShipperName'] . '</Name>
			<ShipperNumber>' . $var['ShipperNumber'] . '</ShipperNumber>
			<Address>
				<AddressLine1>' . $var['ShipperAddressAddressLine1'] . '</AddressLine1>
				<City>' . $var['ShipperAddressCity'] . '</City>
				<StateProvinceCode>' . $var['ShipperAddressStateProvinceCode'] . '</StateProvinceCode>
				<PostalCode>' . $var['ShipperAddressPostalCode'] . '</PostalCode>
				<CountryCode>' . $var['ShipperAddressCountryCode'] . '</CountryCode>
			</Address>
		</Shipper>
		<ShipTo>
			<Address>
				<AddressLine1>' . $var['ShipToAddressAddressLine1'] . '</AddressLine1>
				<City xsi:nil="true"/>
				<PostalCode>' . $var['ShipToAddressPostalCode'] . '</PostalCode>
				<CountryCode>' . $var['ShipToAddressCountryCode'] . '</CountryCode>
			</Address>
		</ShipTo>
		<ShipFrom>
			<CompanyName>' . $var['ShipFromAddressCompanyName'] . '</CompanyName>
			<Address>
				<AddressLine1>' . $var['ShipFromAddressAddressLine1'] . '</AddressLine1>
				<City>' . $var['ShipFromAddressCity'] . '</City>
				<StateProvinceCode xsi:nil="true"/>
				<PostalCode>' . $var['ShipFromAddressPostalCode'] . '</PostalCode>
				<CountryCode>' . $var['ShipFromAddressCountryCode'] . '</CountryCode>
			</Address>
		</ShipFrom>
		<Service>
			<Code>' . $var['ServiceCode'] . '</Code>
		</Service>
		<Package>
			<PackagingType>
				<Code>' . $var['PackagePackagingTypeCode'] . '</Code>
				<Description>' . $var['PackagePackagingTypeDescription'] . '</Description>
			</PackagingType>
			<PackageWeight>
				<UnitOfMeasurement>
					<Code>' . $var['PackagePackageWeightCode'] . '</Code>
				</UnitOfMeasurement>
				<Weight>' . $var['PackagePackageWeightWeight'] . '</Weight>
			</PackageWeight>
		</Package>
		<ShipmentServiceOptions>
			<OnCallAir>
				<Schedule>
					<PickupDay>' . $var['ShipmentServiceOptionsSchedulePickupDay'] . '</PickupDay>
					<Method>' . $var['ShipmentServiceOptionsScheduleMethod'] . '</Method>
				</Schedule>
			</OnCallAir>
		</ShipmentServiceOptions>
	</Shipment>
</RatingServiceSelectionRequest>
		';
        return $xmlStr;
    }

}

?>
