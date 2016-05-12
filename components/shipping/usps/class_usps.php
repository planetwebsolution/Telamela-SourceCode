<?php

class USPS {

    var $server = "";
    var $user = "";
    var $pass = "";
    var $service = "";
    var $dest_zip;
    var $orig_zip;
    var $pounds;
    var $ounces;
    var $container = "Variable";
    var $size = "Regular";
    var $machinable = "True";
    var $dest_country = "";
    var $item_price = "";

    function setServer($server = "Production.ShippingAPIs.com/ShippingAPI.dll") {
        $this->server = $server;
    }

    function setUserName($user) {
        $this->user = $user;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setService($service) {

        if ($service == "USPSBPM") {
            $service = "BPM";
        } elseif ($service == "USPSFCM") {
            $service = "First Class";
        } elseif ($service == "USPSMM") {
            $service = "Media";
        }

        $this->service = $service;
    }

    function setDestZip($sending_zip) {
        /* Must be 5 digit zip (No extension) */
        $sending_zip = str_replace("-", "", $sending_zip);
        $sending_zip = substr($sending_zip, 0, 5);
        $this->dest_zip = $sending_zip;
    }

    function setOrigZip($orig_zip) {
        $this->orig_zip = $orig_zip;
    }

    function setWeight($pounds = 1, $ounces = 0) {
        /* Must weight less than 70 lbs. */

        $this->pounds = floor($pounds);
        $this->ounces = ceil(($pounds - floor($pounds)) * 16);

        if (($this->pounds == 0) && ($this->ounces == 0)) {
            $this->pounds = 1;
        }
    }

    function setContainer($cont) {
        /*
          Valid Containers
          Package Name             Description
          Express Mail
          None                For someone using their own package
          0-1093 Express Mail         Box, 12.25 x 15.5 x
          0-1094 Express Mail         Tube, 36 x 6
          EP13A Express Mail         Cardboard Envelope, 12.5 x 9.5
          EP13C Express Mail         Tyvek Envelope, 12.5 x 15.5
          EP13F Express Mail         Flat Rate Envelope, 12.5 x 9.5

          Priority Mail
          None                For someone using their own package
          0-1095 Priority Mail        Box, 12.25 x 15.5 x 3
          0-1096 Priority Mail         Video, 8.25 x 5.25 x 1.5
          0-1097 Priority Mail         Box, 11.25 x 14 x 2.25
          0-1098 Priority Mail         Tube, 6 x 38
          EP14 Priority Mail         Tyvek Envelope, 12.5 x 15.5
          EP14F Priority Mail         Flat Rate Envelope, 12.5 x 9.5

          Parcel Post
          None                For someone using their own package
         */

        $this->container = $cont;
    }

    function setSize($size) {
        /* Valid Sizes 
          Package Size                Description        Service(s) Available
          Regular package length plus girth     (84 inches or less)    Parcel Post
          Priority Mail
          Express Mail

          Large package length plus girth        (more than 84 inches but    Parcel Post
          not more than 108 inches)    Priority Mail
          Express Mail

          Oversize package length plus girth   (more than 108 but        Parcel Post
          not more than 130 inches)

         */
        $this->size = $size;
    }

    function setMachinable($mach) {
        /* Required for Parcel Post only, set to True or False */
        $this->machinable = "True";
    }

    function setHeight($val) {
        $this->height = $val;
    }

    function setLength($val) {
        $this->length = $val;
    }

    function setWidth($val) {
        $this->width = $val;
    }

    function getPrice($arrCustomerDetails, $arrProduct, $arrMethods) {
        //echo '<pre>';print_r($arrProduct);echo '</pre>';die;

        $this->setOrigZip($arrProduct['CompanyPostalCode']);                 # Origin Zip Code
        $this->setDestZip($arrCustomerDetails['ShippingPostalCode']);        # Destination Zip Code
        // $objUSPS->setOrigZip('85705');                 # Origin Zip Code
        //$objUSPS->setDestZip('85705');        # Destination Zip Code     

        $weightUnit = 'LB';
        $weight = $this->convertLBS($arrProduct['WeightUnit'], $weightUnit, $arrProduct['Weight']);

        $dimensionUnit = "IN"; //$arrProduct['DimensionUnit'];
        $length = $this->convertInch($arrProduct['DimensionUnit'], $dimensionUnit, $arrProduct['Length']);
        $width = $this->convertInch($arrProduct['DimensionUnit'], $dimensionUnit, $arrProduct['Width']);
        $height = $this->convertInch($arrProduct['DimensionUnit'], $dimensionUnit, $arrProduct['Height']);

        $this->setWeight($weight);       # weight
        $this->setLength($length);       # Length
        $this->setHeight($height);       # Height
        $this->setWidth($width);       # Width

        $this->setService('Priority');
        $this->dest_country = $arrCustomerDetails['name'];
        $this->item_price = $arrProduct['FinalPrice'];


        if ($arrProduct['CompanyCountry'] == $arrCustomerDetails['ShippingCountry']) {
            $arrRes = $this->getPriceDom();
        } else {
            $arrRes = $this->getPriceIntl();
        }

        return $arrRes;
    }

    function getPriceDom() {

        // pre($arrMethods);
        // may need to urlencode xml portion 		
        if ($this->server == "" || is_null($this->server))
            $this->server = "http://Production.ShippingAPIs.com/ShippingAPI.dll";
        if ($this->user == "" || is_null($this->user))
            $this->user = "599PRECI6619";
        if ($this->pass == "" || is_null($this->pass))
            $this->pass = "818VX99OC468";
        $packageArray = array(
            array('Container' => 'VARIABLE', 'Service' => 'MEDIA'),
            array('Container' => 'VARIABLE', 'Service' => 'PARCEL'),
            array('Container' => 'VARIABLE', 'Service' => 'PRIORITY COMMERCIAL'),
            array('Container' => 'FLAT RATE ENVELOPE', 'Service' => 'PRIORITY COMMERCIAL'),
            array('Container' => 'LEGAL FLAT RATE ENVELOPE', 'Service' => 'PRIORITY COMMERCIAL'),
            array('Container' => 'PADDED FLAT RATE ENVELOPE', 'Service' => 'PRIORITY COMMERCIAL'),
            array('Container' => 'SM FLAT RATE BOX', 'Service' => 'PRIORITY COMMERCIAL'),
            array('Container' => 'MD FLAT RATE BOX', 'Service' => 'PRIORITY COMMERCIAL'),
            array('Container' => 'LG FLAT RATE BOX', 'Service' => 'PRIORITY COMMERCIAL'),
            array('Container' => 'REGIONALRATEBOXA', 'Service' => 'PRIORITY COMMERCIAL'),
            array('Container' => 'REGIONALRATEBOXB', 'Service' => 'PRIORITY COMMERCIAL'),
            array('Container' => 'REGIONALRATEBOXC', 'Service' => 'PRIORITY COMMERCIAL'),
            array('Container' => 'VARIABLE', 'Service' => 'EXPRESS COMMERCIAL'),
            array('Container' => 'FLAT RATE ENVELOPE', 'Service' => 'EXPRESS COMMERCIAL'),
            array('Container' => 'LEGAL FLAT RATE ENVELOPE', 'Service' => 'EXPRESS COMMERCIAL'),
            array('Container' => 'FLAT RATE BOX', 'Service' => 'EXPRESS COMMERCIAL'));
        $requestDomXML = '
<RateV4Request USERID="' . $this->user . '">
	<Revision>2</Revision>
	';
        foreach ($packageArray as $key => $val) {
            $requestDomXML .='
	<Package ID="' . $key . '">
		<Service>' . $val['Service'] . '</Service>
		<ZipOrigination>' . $this->orig_zip . '</ZipOrigination>
		<ZipDestination>' . $this->dest_zip . '</ZipDestination>
		<Pounds>' . $this->pounds . '</Pounds>
		<Ounces>' . $this->ounces . '</Ounces>
		<Container>' . $val['Container'] . '</Container>
		<Size>REGULAR</Size>
		<Value>' . $this->item_price . '</Value>
		<SpecialServices>
			<SpecialService>1</SpecialService>
			<SpecialService>11</SpecialService>
			<SpecialService>13</SpecialService>
		</SpecialServices>
		<Machinable>FALSE</Machinable>
	</Package>';
        }
        $requestDomXML .='	
</RateV4Request>
';

        $request = 'API=RateV4&XML=' . urlencode($requestDomXML);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server);
        curl_setopt($ch, CURLOPT_REFERER, SITE_ROOT_URL);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Tela mela');

        $body = curl_exec($ch);
        $info = @curl_getinfo($ch);
        curl_close($ch);

        $body_array = simplexml_load_string($body);
        $body_content = json_decode(json_encode($body_array), TRUE);

        foreach ($body_content['Package'] as $usps) {
            if ((float) $usps['Postage']['CommercialRate'] > 0)
                $arr[] = array('ServiceType' => $usps['Postage']['MailService'], 'DeliveryTimestamp' => $usps['Postage']['CommitmentName'], 'ShippingCost' => $usps['Postage']['CommercialRate']);
        }
        //pre($arr);
        return $arr;
    }

    function getPriceIntl() {
        // may need to urlencode xml portion 		
        if ($this->server == "" || is_null($this->server))
            $this->server = "http://Production.ShippingAPIs.com/ShippingAPI.dll";
        if ($this->user == "" || is_null($this->user))
            $this->user = "599PRECI6619";
        if ($this->pass == "" || is_null($this->pass))
            $this->pass = "818VX99OC468";

        $requestIntXML = '
<IntlRateV2Request USERID="' . $this->user . '">
	<Revision>2</Revision>
	<Package ID="0">
		<Pounds>' . $this->pounds . '</Pounds>
		<Ounces>' . $this->ounces . '</Ounces>
		<MailType>All</MailType>
		<GXG>
			<POBoxFlag>N</POBoxFlag>
			<GiftFlag>N</GiftFlag>
		</GXG>
		<ValueOfContents>' . $this->item_price . '</ValueOfContents>
		<Country>' . $this->dest_country . '</Country>
		<Container>RECTANGULAR</Container>
		<Size>REGULAR</Size>
		<Width>' . $this->width . '</Width>
		<Length>' . $this->length . '</Length>
		<Height>' . $this->height . '</Height>
		<Girth>0</Girth>
		<OriginZip>' . $this->orig_zip . '</OriginZip>
		<CommercialFlag>Y</CommercialFlag>
		<ExtraServices>
			<ExtraService>0</ExtraService>
			<ExtraService>1</ExtraService>
			<ExtraService>2</ExtraService>
			<ExtraService>3</ExtraService>
			<ExtraService>5</ExtraService>
			<ExtraService>6</ExtraService>
		</ExtraServices>
	</Package>
</IntlRateV2Request>
';
        
        
        $request = 'API=IntlRateV2&XML=' . urlencode($requestIntXML);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server);
        curl_setopt($ch, CURLOPT_REFERER, SITE_ROOT_URL);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Tela mela');

        $body = curl_exec($ch);
        $info = @curl_getinfo($ch);
        curl_close($ch);

        $body_array = simplexml_load_string($body);
        $body_content = json_decode(json_encode($body_array), TRUE);

        foreach ($body_content['Package']['Service'] as $usps) {
            if ((float) $usps['CommercialPostage'] > 0)
                $arr[] = array('ServiceType' => $usps['SvcDescription'], 'DeliveryTimestamp' => $usps['SvcCommitments'], 'ShippingCost' => $usps['CommercialPostage']);
        }
        //pre($body_content);
        return $arr;
    }

    function trackPackage($ids) {

        if ($this->server == "" || is_null($this->server))
            $this->server = "http://Production.ShippingAPIs.com/ShippingAPI.dll";
        if ($this->user == "" || is_null($this->user))
            $this->user = "599PRECI6619";
        if ($this->pass == "" || is_null($this->pass))
            $this->pass = "818VX99OC468";


        $url = "$this->server?API=Track&XML=";
        $xml = "<TrackRequest USERID=\"$this->user\" PASSWORD=\"$this->pass\">";

        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            $xml .= "<TrackID ID='$id'></TrackID>";
        }

        $xml .= "</TrackRequest>";
        $xml = urlencode($xml);
        $url = $url . $xml;

        $fp = fopen($url, "r");


        while (!feof($fp)) {
            $str .= fread($fp, 80);
        }
        fclose($fp);

        $cnt = 0;

        $text = explode("<TrackInfo ID=", $str);
        for ($i = 0; $i < count($text); $i++) {
            if (preg_match("/<TrackSummary>(.+)</TrackSummary>/", $text[$i], $regs)) {
                $values["eta"] = $regs[1];
                if (preg_match("/delivered/i", $values["eta"])) {
                    $values["eta"] = "Delivered";
                } else {
                    $values["eta"] = "In Transit";
                }
                $cnt++;
            }
        }
        $values["type"] = "Priority Mail";

        return $values;
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
