<?php

/**
 * Site ShippingPrice Class
 *
 * This is the ShippingPrice class that will used on website to calculate Shipping Price.
 *
 * DateCreated 5th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class ShippingPrice extends Database {

    function __construct() {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function ShippingDetails
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_shipping_gateways, tbl_product_to_package, tbl_product
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $varTotalShippingCost
     */
    function ShippingDetails($arrRows) {

        $varTotalShippingCost = 0;
        foreach ($arrRows['Product'] as $k => $v) {
            $val = $this->getProductDetails($v['pkProductID'], $v['qty']);

            $val['fkShippingID'] = (int) $val['fkShippingID'];

            if ($val['fkShippingID'] > 0) {
                $arrShippingRes = $this->select(TABLE_SHIPPING_GATEWAYS, array('ShippingType', 'ShippingAlias'), "pkShippingGatewaysID = '" . $val['fkShippingID'] . "'");

                if ($arrShippingRes[0]['ShippingType'] == 'admin') {

                    $varShippingCost = $this->AdminShipping($val);
                } else {
                    $varShippingCost = $this->$arrShippingRes[0]['ShippingAlias']($val);
                }
            } else {
                $varShippingCost = DEFAULT_SHIPPING_CHARGE;
            }
            $_SESSION['MyCart']['Product'][$val['pkProductID']][$k]['ShippingCost'] = $varShippingCost;
            $varTotalShippingCost += (float) $varShippingCost;
        }





        foreach ($arrRows['Package'] as $k => $v) {

            $varQuery = "SELECT ptp.fkPackageId as fkPackageId,group_concat(fkProductId) as ProductIds,group_concat(fkShippingID) as ShippingIDs
                FROM " . TABLE_PRODUCT_TO_PACKAGE . " as ptp LEFT JOIN " . TABLE_PRODUCT . " p ON p.pkProductID = ptp.fkProductId  WHERE ptp.fkPackageId =  '" . $v['pkPackageId'] . "' group by ptp.fkPackageId";
            $arrRes = $this->getArrayResult($varQuery);
            $val = $arrRes[0];
            $val['qty'] = $v['qty'];

            $arrProductIds = explode(',', $val['ProductIds']);
            $arrShippingIDs = explode(',', $val['ShippingIDs']);
            $varShippingCost = 0;
            foreach ($arrProductIds as $kk => $vv) {

                if ($arrShippingIDs[$kk] > 0) {
                    $arrShippingRes = $this->select(TABLE_SHIPPING_GATEWAYS, array('ShippingType', 'ShippingAlias'), "pkShippingGatewaysID = " . $arrShippingIDs[$kk]);

                    if ($arrShippingRes[0]['ShippingType'] == 'admin') {

                        $varCost = $this->AdminShipping($val);
                    } else {
                        $varCost = $this->$arrShippingRes[0]['ShippingAlias']($val);
                    }
                } else {
                    $varCost = DEFAULT_SHIPPING_CHARGE;
                }
                $varShippingCost += $varCost;
                $_SESSION['MyCart']['Package'][$val['fkPackageId']][$k]['ProductShippingCost'][$vv] = $varCost;
            }
            $varTotalShippingCost += $varShippingCost;
            $_SESSION['MyCart']['Package'][$val['fkPackageId']][$k]['TotalShippingCost'] = $varShippingCost;
        }

        // pre($_SESSION['MyCart']);
        return $varTotalShippingCost;
    }

    /**
     * function AdminShipping
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_shipping_gateways_pricelist
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $ShippingCost
     */
    function AdminShipping($arrProduct, $arrCustomerDetails, $arrMethods) {
        //Shipping delivery Details
        //$arrCustomerDetails = $this->CustomerDetails();
        //pre($arrCustomerDetails);
        foreach ($arrMethods as $key => $val) {

            $varQuery = "(SELECT pkWeightPriceID,fkShippingGatewaysID,fkShippingMethodID,Weight,ZoneA as ShippingCost,ZoneB,ZoneC,ZoneD,ZoneE,ZoneF,ZoneG,ZoneH,ZoneI,ZoneD,ZoneK FROM tbl_shipping_gateways_pricelist" . TABLE_SHIPPING_GATEWAYS_PRICELIST . " WHERE fkShippingMethodID = '" . $val['pkShippingMethod'] . "' AND Weight >= '" . $arrProduct['Weight'] . "' ORDER BY Weight ASC limit 0,1)
union (SELECT pkWeightPriceID,fkShippingGatewaysID,fkShippingMethodID,max(Weight) as Weight ,ZoneA,ZoneB,ZoneC,ZoneD,ZoneE,ZoneF,ZoneG,ZoneH,ZoneI,ZoneD,ZoneK FROM " . TABLE_SHIPPING_GATEWAYS_PRICELIST . " WHERE fkShippingMethodID = '" . $val['pkShippingMethod'] . "' HAVING pkWeightPriceID>0)";
            $arrRes = $this->getArrayResult($varQuery);
            $ShippingCost = (float) ($arrRes['0']['ShippingCost'] * $arrProduct['qty']);

            if ($ShippingCost > 0) {
                $arrMethods[$key]['ShippingCost'] = $ShippingCost;
                $arrMethods[$key]['DeliveryTimestamp'] = '';
            } else {
                unset($arrMethods[$key]);
            }
        }

        //pre($arrMethods);
        return $arrMethods;
    }

    function AdminShippingnew($arrProduct, $arrCustomerDetails, $arrMethods) {
//        pre($arrProduct);
        $objGeneral = new General();
        $objProduct = new Product();

        //fetch product availability array - globle, local or multiple countries
        $productAval = $objProduct->productmulcountrydetailAdmin($arrProduct['pkProductID']);
//        pre($productAval);
        //Convert Weight To KG
        $convertweight = $objGeneral->convertproductweight($arrProduct['WeightUnit'], $arrProduct['Weight']);
        $arrProduct['Weight'] = $convertweight;
        $arrProduct['WeightUnit'] = 'kg';

        //Convert Weight To CM
        if ($arrProduct['DimensionUnit'] != 'cm') {
            $arrProduct['Length'] = $objGeneral->convertproductdimention($arrProduct['DimensionUnit'], $arrProduct['Length']);
            $arrProduct['Width'] = $objGeneral->convertproductdimention($arrProduct['DimensionUnit'], $arrProduct['Width']);
            $arrProduct['Height'] = $objGeneral->convertproductdimention($arrProduct['DimensionUnit'], $arrProduct['Height']);
            $arrProduct['DimensionUnit'] = 'cm';
        }
        //Calculate Volumetric weight 
        if ($arrProduct['DimensionUnit'] == 'cm') {
            $volumetricWt = ($arrProduct['Length'] * $arrProduct['Width'] * $arrProduct['Height']) / 5000;

            if ($volumetricWt > $arrProduct['Weight']) {
                $WeightPro = ceil($volumetricWt);
            } else {
                $WeightPro = ceil($arrProduct['Weight']);
            }
        }
//        pre($WeightPro);
        if (!empty($arrCustomerDetails['ShippingCountry'])) {

            $toCountryArray = array();
            foreach ($productAval as $cval) {
                if ($cval['producttype'] != 'gloabal') {
                    array_push($toCountryArray, $cval['country_id']);
                } else {
//                    $toCountryArray = array();
                    array_push($toCountryArray, $arrCustomerDetails['ShippingCountry']);
                }
            }

            if (!empty($toCountryArray)) {
                $toCountryArrayValue = join(',', $toCountryArray);
                $CondForToCntry = " AND tocountry IN(" . $toCountryArrayValue . ")";
                $CondForToState = " AND (tostate = " . $arrCustomerDetails['ShippingState'] . " AND tostate != 0)";
                $CondForToCity = " AND (tocity = " . $arrCustomerDetails['ShippingCity'] . " AND tocity != 0)";
            } else {
                $CondForToCntry = '';
                $CondForToState = '';
                $CondForToCity = '';
            }



//            echo '<pre>';
//            print_r($toCountryArray);


            $TimeZone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $arrCustomerDetails['iso_code_2']);
            date_default_timezone_set($TimeZone[0]);
            $date = date('Y-m-d');
//            $varQuery = "SELECT * from " . TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . " "
//                    . " where fkShippingGatewaysID=" . $arrMethods['shippingId'] . " AND DATE(currentDate) <= '" . $date . "'"
//                    . $portalCondition . " and fkShippingCountryID = " . $arrCustomerDetails['ShippingCountry'] . " "
//                    . " and minWeight <= " . $arrProduct['Weight'] . " and maxWeight >= " . $arrProduct['Weight'] . ""
//                    . " and fkShippingPortalID = " . $arrProduct['WhPortalID'] . ""
//                    . " order by date(`currentDate`) desc";
            $varQuery = "SELECT * from " . TABLE_ZONEPRICE . ""
                    . " LEFT JOIN " . TABLE_SHIPPING_METHOD . " ON shippingmethod = pkShippingMethod "
                    //. " LEFT JOIN " . TABLE_ZONEDETAIL . " ON zonetitleid = fkzoneid"
//                    . " LEFT JOIN " . TABLE_ZONEDETAIL . " ON fkzonedetailid = id"
                    . " where fklogisticidvalue =" . $arrMethods['logisticportalid'] . " "
                    . " AND DATE(created) = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE "
                    . " fklogisticidvalue =" . $arrMethods['logisticportalid'] . " AND newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid "
                    . " AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod AND DATE(created) <= '" . $date . "' )"
                    . " AND minkg <= " . $arrProduct['Weight'] . " and maxkg >= " . $arrProduct['Weight'] . ""
//                    . $CondForToCntry . $CondForToState . $CondForToCity
//                    . " AND fromcountry =" . $arrProduct['CompanyCountry'] . ""
                    . " AND maxlength >=" . $arrProduct['Length'] . ""
                    . " AND maxwidth >=" . $arrProduct['Width'] . ""
                    . " AND maxheight >=" . $arrProduct['Height'] . ""
                    . " AND DATE(created) <= '" . $date . "' "
                    . " AND pricestatus = 1"
                    . " group by pkpriceid order by date(`created`) desc";
            $arrRes = $this->getArrayResult($varQuery);
//            pre($arrCustomerDetails);
//            echo '<pre>';
//            print_r($arrRes);
//                $varQuery33 =  "SELECT *, if(tostate != 0, tostate, null) st,
//                if(tocity != 0, tocity, null) ct
//                FROM `tbl_zonedetail`
//                having id IN (" . $arrRes[0]['fkzonedetailid'] . ") AND
//                (
//                (st = " . $arrCustomerDetails['ShippingState'] . " or ct = " . $arrCustomerDetails['ShippingCity'] . ") "
//                        . "or (st = " . $arrCustomerDetails['ShippingState'] . " and ct = " . $arrCustomerDetails['ShippingCity'] . ")
//                )";
//                        
////                echo $varQuery33 = "SELECT * FROM " . TABLE_ZONEDETAIL . ""
////                . " WHERE id = " . $vv . " " . $CondForToState . "";
//                $arrRes23 = $this->getArrayResult($varQuery33);
//            echo $arrCustomerDetails['ShippingCity'];die;
//            pre($arrProduct);
            foreach ($arrRes as $kk => $valuee) {



                $ShippingCostByKg = (float) ($WeightPro * $valuee['costperkg']);
                $ShippingCost = (float) ($ShippingCostByKg * $arrProduct['qty']);
//                pre($ShippingCost);
                $arrRes[$kk]['ShippingCost'] = $ShippingCost;
                if ($arrProduct['productfragile'] == 'fragile') {
                    $arrRes[$kk]['ShippingCost'] = $arrRes[$kk]['ShippingCost'] + ($valuee['fragilecost'] * $arrProduct['qty']);
                }
            }
//            pre($arrCustomerDetails);
//            echo '<pre>';
//            print_r($arrRes);
//            pre($arrProduct);


            foreach ($arrRes as $kk1 => $valuee1) {

                $multipleIds = explode(',', $valuee1['fkzonedetailid']);
                $rancom_var = false;
                $rancom_var1 = false;
                foreach ($multipleIds as $k => $v) {

                    $q = "SELECT * FROM tbl_zonedetail where id = " . $v . " ";
                    $a = $this->getArrayResult($q);
//                    echo '<pre>';
//                    print_r($a);
                    //check for "From" country, state and city
                    //echo $a[0]['tostate'] .'=='. $arrCustomerDetails['ShippingState'];
                    if ($a[0]['fromcountry'] == $arrProduct['CompanyCountry']) {
                        if ($a[0]['fromstate'] != 0) {
                            if ($a[0]['fromstate'] == $arrProduct['CompanyState']) {


                                if ($a[0]['fromcity'] != 0) {
                                    if ($a[0]['fromcity'] == $arrProduct['CompanyCity']) {

                                        $rancom_var = true;
                                        //break;
                                    } else {
                                        $rancom_var = false;
                                    }
                                } else {

                                    $rancom_var = true;
                                    //break;
                                }
                            } else {
                                $rancom_var = false;
                            }
                        } else {
                            $rancom_var = true;
                            //break;
                        }
                    }else{
                        $rancom_var = false;
                    }

                    //check for "To" country, state and city
                    if ($a[0]['tocountry'] == $arrCustomerDetails['ShippingCountry']) {
                       
                        if ($a[0]['tostate'] != 0) {
                            if ($a[0]['tostate'] == $arrCustomerDetails['ShippingState']) {

                                if ($a[0]['tocity'] != 0) {
                                    if ($a[0]['tocity'] == $arrCustomerDetails['ShippingCity']) {
                                        $rancom_var1 = true;
                                        //break;
                                    } else {
                                        $rancom_var1 = false;
                                    }
                                } else {
                                    $rancom_var1 = true;
                                    //break;
                                }
                            } else {
                                 
                                $rancom_var1 = false;
                            }
                        } else {
                            $rancom_var1 = true;
                            //break;
                        }
                    } else{
                        $rancom_var1 = false;
                    }

//                    echo '<pre>';
//                    echo $rancom_var . '=====' . $rancom_var1;
//                    echo 'id='.$a[0]['id'].'<br>';
                    
                    if ($rancom_var && $rancom_var1) {
                        break;
                    }
                }

//                echo $rancom_var . '&&' . $rancom_var1 . ',kk1=' . $kk1;
//                echo '<pre>';
//                print_r($arrRes[$kk1]);
                if (!$rancom_var || !$rancom_var1) {


                    unset($arrRes[$kk1]);
                }
            }
//            pre($arrRes);
//            foreach ($arrRes as $kk1 => $valuee1) {
//
//                $multipleIds = explode(',', $valuee1['fkzonedetailid']);
//                $rancom_var = false;
//                foreach ($multipleIds as $k => $v) {
//
//                    $q = "SELECT * FROM tbl_zonedetail where id = " . $v . " ";
//                    $a = $this->getArrayResult($q);
//                    if ($a[0]['fromcountry'] == $arrProduct['CompanyCountry']) {
//                        if ($a[0]['fromstate'] != 0) {
//                            if ($a[0]['fromstate'] == $arrProduct['CompanyState']) {
//
//                                if ($a[0]['fromcity'] != 0) {
//                                    if ($a[0]['fromcity'] == $arrProduct['CompanyCity']) {
//                                        $rancom_var = true;
//                                        break;
//                                    } else {
//                                        $rancom_var = false;
//                                    }
//                                } else {
//
//                                    $rancom_var = true;
//                                    break;
//                                }
//                            } else {
//                                $rancom_var = false;
//                            }
//                        } else {
//                            $rancom_var = true;
//                            break;
//                        }
//                    }
//                }
//                if (!$rancom_var) {
//                    unset($arrRes[$kk1]);
//                }
//            }
//            foreach ($arrRes as $kk1 => $valuee1) {
//
//                $multipleIds = explode(',', $valuee1['fkzonedetailid']);
//
//                $rancom_var1 = false;
//                foreach ($multipleIds as $k => $v) {
//
//                    $q = "SELECT * FROM tbl_zonedetail where id = " . $v . " ";
//                    $a = $this->getArrayResult($q);
//                    if ($a[0]['tocountry'] == $arrCustomerDetails['ShippingCountry']) {
//
//                        if ($a[0]['tostate'] != 0) {
//                            if ($a[0]['tostate'] == $arrCustomerDetails['ShippingState']) {
//
//                                if ($a[0]['tocity'] != 0) {
//                                    if ($a[0]['tocity'] == $arrCustomerDetails['ShippingCity']) {
//                                        $rancom_var1 = true;
//                                        break;
//                                    } else {
//                                        $rancom_var1 = false;
//                                    }
//                                } else {
//                                    $rancom_var1 = true;
//                                    break;
//                                }
//                            } else {
//                                $rancom_var1 = false;
//                            }
//                        } else {
//                            $rancom_var1 = true;
//                            break;
//                        }
//                    }
//                }
//                if (!$rancom_var1) {
//                    unset($arrRes[$kk1]);
//                }
//            }
            //code by gaurav for mobile
//            if (!$ShippingCost) {
//                $arrRes[0]['fkShippingGatewaysID'] = 0;
//            }
//            
//            if ($cval['producttype'] == 'multiple') {
//                    array_push($toCountryArray, $cval['country_id']);
//                } else if ($cval['producttype'] != 'local') {
//                    
//                } else {
//                    $toCountryArray = array();
//                }
//                
//                
            //end of code by gaurav for mobile
//            print_r($arrRes);
            return $arrRes;
        } else
            return $arrRes = array();
    }

    /**
     * function DHL
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : no Table 
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $ShippingCost
     */
    function DHL($arrProduct, $arrCustomerDetails) {
        //$arrCustomerDetails = $this->CustomerDetails();
        $ShippingCost = 5;
        return $ShippingCost;
    }

    /**
     * function Fedex
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : no Table 
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $ShippingCost
     */
    function Fedex($arrProduct, $arrCustomerDetails, $arrMethods) {
        //pre($arrProduct);
        //$arrCustomerDetails = $this->CustomerDetails();
        $objFedEx = new FedEx();
        //pre($arrCustomerDetails);
        $arrRes = $objFedEx->getFedExRate($arrCustomerDetails, $arrProduct);
        //pre($arrRes);
//         foreach ($arrMethods as $key => $val) {
//             $arrMethod[$val['MethodCode']] = $val;
//         }

        $arrRow = array();
//         foreach ($arrRes as $key => $val) {
//             if ($arrMethod[$val['ServiceType']]) {
//                 $arrRow[$key] = $arrMethod[$val['ServiceType']];
//                 $arrRow[$key]['ShippingCost'] = $arrProduct['qty'] * $val['ShippingCost'];
//                 $arrRow[$key]['DeliveryTimestamp'] = $val['DeliveryTimestamp'];
//             }
//         }
        foreach ($arrRes as $key => $val) {

            $arrRow[$key]['ServiceType'] = $val['ServiceType'];
            $arrRow[$key]['ShippingCost'] = $arrProduct['qty'] * $val['ShippingCost'];
            $arrRow[$key]['DeliveryTimestamp'] = $val['DeliveryTimestamp'];
        }
        // pre($arrRow);
        return $arrRow;
    }

    /**
     * function UPS
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : no Table 
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $ShippingCost
     */
    function UPS($arrProduct, $arrCustomerDetails, $arrMethods) {
        //pre($arrCustomerDetails);
        // $arrCustomerDetails = $this->CustomerDetails();
        //pre($arrCustomerDetails);
        $objUPS = new UPS();

        $arrRes = $objUPS->getUPSRate($arrCustomerDetails, $arrProduct);
        //pre($arrRes);
//         foreach ($arrMethods as $key => $val) {
//             $arrMethod[$val['MethodCode']] = $val;
//         }
        //echo '<pre>';print_r($arrRes);
        $arrRow = array();
//         foreach ($arrRes as $key => $val) {
//             if ($arrMethod[$val['ServiceType']]) {
//                 $arrRow[$key] = $arrMethod[$val['ServiceType']];
//                 $arrRow[$key]['ShippingCost'] = $arrProduct['qty'] * $val['ShippingCost'];
//                 $arrRow[$key]['DeliveryTimestamp'] = $val['DeliveryTimestamp'];
//             }
//         }
        $methodname = array(
            "11" => "UPS Standard",
            "03" => "UPS Ground",
            "12" => "UPS 3 Day Select",
            "02" => "UPS 2nd Day Air",
            "59" => "UPS 2nd Day Air AM",
            "13" => "UPS Next Day Air Saver",
            "01" => "UPS Next Day Air",
            "14" => "UPS Next Day Air Early A.M.",
            "07" => "UPS Worldwide Express",
            "54" => "UPS Worldwide Express Plus",
            "08" => "UPS Worldwide Expedited",
            "65" => "UPS World Wide Saver"
        );
        foreach ($arrRes as $key => $val) {

            $arrRow[$key]['ServiceType'] = $methodname[$val['ServiceType']];
            $arrRow[$key]['ShippingCost'] = $arrProduct['qty'] * $val['ShippingCost'];
            $arrRow[$key]['DeliveryTimestamp'] = $val['DeliveryTimestamp'];
        }


        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function USPS
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : no Table 
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $ShippingCost
     */
    function USPS($arrProduct, $arrCustomerDetails, $arrMethods) {
        //pre($arrCustomerDetails);
        //$arrCustomerDetails = $this->CustomerDetails();
        $objUSPS = new USPS();
        $objUSPS->setUserName("599PRECI6619");    # USPS Username
        $objUSPS->setPass("818VX99OC468");        # USPS Password


        $arrRes = $objUSPS->getPrice($arrCustomerDetails, $arrProduct, $arrMethods);

        /*
          $str = "INSERT INTO " . TABLE_SHIPPING_METHOD . " (fkShippingGatewayID,MethodName,MethodCode,MethodService,ShippingDays,MethodDescription) values";

          foreach ($arrRes as $key => $val) {
          $met = $val['ServiceType'];
          $str .= "('4','" . $met . "','" . $met . "','international','7','".$met."'),";
          }
          echo $str;
          pre($arrRes);
         */
        foreach ($arrMethods as $key => $val) {
            $arrMethod[$val['MethodCode']] = $val;
        }
        //pre($arrMethod);
        $arrRow = array();
        foreach ($arrRes as $key => $val) {
            if ($arrMethod[$val['ServiceType']]) {
                $arrRow[$key] = $arrMethod[$val['ServiceType']];
                $arrRow[$key]['ShippingCost'] = $arrProduct['qty'] * $val['ShippingCost'];
                $arrRow[$key]['DeliveryTimestamp'] = $val['DeliveryTimestamp'];
            }
        }

        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function CustomerDetails
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_customer, tbl_country
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $ShippingCost
     */
    function CustomerDetails() {
        $varQuery = "SELECT pkCustomerID,concat(CustomerFirstName,' ',CustomerLastName) AS CustomerName, ShippingAddressLine1,ShippingAddressLine2,ShippingCountry,name,iso_code_2,iso_code_3,zone, ShippingPostalCode,ShippingPhone
            FROM " . TABLE_CUSTOMER . " LEFT JOIN " . TABLE_COUNTRY . " ON ShippingCountry = country_id
            WHERE pkCustomerID  = '" . $_SESSION['sessUserInfo']['id'] . "'";
        $arrCustomerDetails = $this->getArrayResult($varQuery);

        return $arrCustomerDetails[0];
    }

    /**
     * function getProductDetails
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product, tbl_wholesaler, tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $ShippingCost
     */
    function getProductDetails($pid, $qty, $shipping) {
        $varQuery = "SELECT pkProductID,fkWholesalerID,CompanyName, CompanyAddress1,CompanyAddress2,CompanyCity,CompanyCountry,
       		name,iso_code_2,iso_code_3,zone,CompanyRegion,CompanyPostalCode,fkShippingID, Weight, WeightUnit, 
       		Length, Width, Height, DimensionUnit, FinalPrice
            FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID=pkWholesalerID LEFT JOIN 
            		" . TABLE_COUNTRY . " ON CompanyCountry = country_id
            WHERE pkProductID = '" . $pid . "'";

        $arrRes = $this->getArrayResult($varQuery);
        $arrRes[0]['qty'] = $qty;
        $arrRes[0]['shipping'] = $shipping;
        // pre($arrRes[0]);

        return $arrRes[0];
    }

    function getProductDetailsnew($pid, $qty, $shipping) {
//        $varQuery = "SELECT pkProductID,fkWholesalerID,CompanyName, CompanyAddress1,CompanyAddress2,CompanyCity,CompanyCountry,
//       		name,iso_code_2,iso_code_3,zone,CompanyRegion,CompanyPostalCode,fkShippingID, Weight, WeightUnit,
//       		Length, Width, Height, DimensionUnit, FinalPrice
//            FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID=pkWholesalerID LEFT JOIN
//            		" . TABLE_COUNTRY . " ON CompanyCountry = country_id
//            WHERE pkProductID = '" . $pid . "'";

        $varQuery = "SELECT TA.pkAdminID as WhPortalID, pkProductID,productfragile,fkWholesalerID,CompanyName, CompanyAddress1,CompanyAddress2,CompanyState,CompanyCity,CompanyCountry,
       		name,iso_code_2,iso_code_3,zone,CompanyRegion,CompanyPostalCode,fkShippingID, Weight, WeightUnit,
       		Length, Width, Height, DimensionUnit, FinalPrice
            FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_WHOLESALER . " as TW ON fkWholesalerID=TW.pkWholesalerID LEFT JOIN
            " . TABLE_COUNTRY . " ON CompanyCountry = country_id LEFT JOIN " .
                TABLE_ADMIN . " as TA ON TA.AdminCountry = TW.CompanyCountry"
                . " WHERE pkProductID = '" . $pid . "' AND TA.AdminType = 'user-admin' ";

        //pre($varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        $arrRes[0]['qty'] = $qty;
        //$arrRes[0]['shipping'] = $shipping;
//        pre($arrRes);

        return $arrRes[0];
    }

    /**
     * function appliedShipping
     *
     * This function is used to set shipping price in session 
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $ShippingCost
     */
    function appliedShipping($shipping, $id, $key, $type) {

        $arrShip = explode('-', $shipping);
        //pre($arrShip);
        $arrRes = array('ShippingId' => $arrShip[0], 'MethodId' => $arrShip[1], 'ShippingCost' => $arrShip[2]);
        //pre($arrRes);
        // $arrRes = array('ShippingCost' => $arrShip[2]);

        /*
          $varTbl = TABLE_SHIPPING_METHOD." INNER JOIN ".TABLE_SHIPPING_GATEWAYS." ON fkShippingGatewayID = pkShippingGatewaysID";
          $arrRow = $this->select($varTbl,array('ShippingTitle','MethodName'),"pkShippingMethod='".$arrRes['MethodId']."'");
          $arrRes['ShippingTitle'] = $arrRow[0]['ShippingTitle'];
          $arrRes['MethodName'] = $arrRow[0]['MethodName'];
         */
        $_SESSION['MyCart'][$type][$id][$key]['AppliedShipping'] = $arrRes;


        return $arrRes;
    }

}

?>