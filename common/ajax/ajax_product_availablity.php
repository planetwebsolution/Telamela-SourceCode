<?php

require_once '../config/config.inc.php';
require_once CLASSES_PATH . 'class_product_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_database_dbl.php';
$objProduct = new Product();
$objdatabase = new Database();

//Get Posted data
$case = $_POST['action'];
// pre($case);
switch ($case) {
    case 'check_country_availaibility':
        $objCore = new Core();
        // $objCategory = new Category();
        $objProduct = new Product();
        // $objShoppingCart = new ShoppingCart();
        $pid = (int) $_REQUEST['pid'];
        $cid = (int) $_REQUEST["cid"];
        $isFirst = (isset($_REQUEST["isFirst"]) ? true : false);
        // $objHome = new Home();

        $multilpleproductcountry = $objProduct->getmulproductDetails($pid);
        $avalCountry = array();

        if (empty($multilpleproductcountry) || $multilpleproductcountry[0]["producttype"] == "gloabal") {
            $product_type = $wah = "gloabal";
            $status = true;
        } else {
            $product_type = $multilpleproductcountry[0]['producttype'];
            if ($product_type == 'local') {
                $wah = 'local';
                $avalCountry[] = $multilpleproductcountry[0]['country_id'];
            } else if ($product_type == 'multiple') {
                $wah = 'multiple';
                foreach ($multilpleproductcountry as $kc => $vc) {
                    $avalCountry[$kc] = $vc['country_id'];
                }
            }
        }

        if ($wah == "gloabal") {
            $product_type = $wah;
            $status = true;
        } else {
            if (!empty($avalCountry) && in_array($cid, $avalCountry)) {
                $product_type = $wah;
                $status = true;
            } else if (!empty($avalCountry) && $isFirst && in_array($_SESSION["userCountryId"], $avalCountry)) {
                $product_type = $wah;
                $status = true;
            } else {
                $product_type = null;
                $status = false;
            }
        }



        // pre($wholesalerdetail);
        $productdetail = $objProduct->getproductdetailbyidinproducttable($pid);
        //  pre($productdetail);
//
        $wholesalerid = $productdetail[0]['pkWholesalerID'];
        $fragilecostshow = $productdetail[0]['productfragile'];
        $argSID = $productdetail[0]['fkShippingID'];
        $result = getShippingDetailsForProductdetails($pid, $argSID, $cid);
        // pre($result);
        if (!empty($result)) {
            $value.='<table width="100%" cellpadding="0" cellspacing="0" class="shipping-table1"> ';
            $value .='<tr><th> Company Name </th> <th> Method Name </th>'
                    . '<th> Delivery Days </th> <th> Total Shipping Price($) </th></tr>';
            foreach ($result as $keySelect => $valSelect) {
                foreach ($valSelect as $key => $val) {
                    
//                    if ($fragilecostshow == 'fragile') {
//                       $fragilecostvalue=$val['fragilecost'];
//                        }
//                        else
//                        {
//                          $fragilecostvalue=0;  
//                        }
                    $value .='<tr>  ';
                    $value .='<td>' . $val['logisticTitle'] . '</td>';
                    $value .='<td>' . $val['MethodName'] . ' </td>';
                    $value .='<td>' . $val['deliveryday'] . ' </td>';
//                    $value .='<td>' .$fragilecostvalue . ' </td>';
                    $value .='<td>' . $val['ShippingCost'] . ' </td>';

                    $value .='</tr>';
                }
            }
            $value .='</table>';
            $status = true;
        } else {
            $value = '';
            $status = false;
        }

        echo json_encode(array("status" => $status, "product_type" => $product_type, "value" => $value));
        // echo $value;
        die;
        break;
}

function getShippingDetailsForProductdetails($pid, $argSID, $cid) {

    global $objCore;
    global $objGeneral;
    $objProduct = new Product();
    $objdatabase = new Database();
    $productdetail = $objProduct->getproductdetailbyidinproducttable($pid);
//pre($productdetail);
//
    $wholesalerid = $productdetail[0]['fkWholesalerID'];
    $argSID = $productdetail[0]['fkShippingID'];
    $weightunit = $productdetail[0]['WeightUnit'];
    $Weight = $productdetail[0]['Weight'];
    $DimensionUnit = $productdetail[0]['DimensionUnit'];
    $Lengthvalue = $productdetail[0]['Length'];
    $Widthvalue = $productdetail[0]['Width'];
    $Heightvalue = $productdetail[0]['Height'];
    $fragilecost = $productdetail[0]['productfragile'];

    $wholesalerdetail = $objProduct->getonlywholesalerbyproductid($wholesalerid);

    //pre($wholesalerdetail);
    $wholesalercountryid = $wholesalerdetail[0]['CompanyCountry'];


    if ($argSID != '') {
        $inCondition = "logisticportalid in(" . $argSID . ") AND";
    } else {
        $inCondition = '';
    }
    $varQuery = "SELECT logisticportalid,logisticgatwaytype,logisticTitle,logisticStatus "
            . " FROM " . TABLE_LOGISTICPORTAL . ""
            . " WHERE " . $inCondition . " logisticStatus='1' ORDER BY logisticTitle ASC";

    $arrRes1 = $objdatabase->getArrayResult($varQuery);
 //pre($arrRes);
    foreach ($arrRes1 as $key => $val) {
        $Shipping = array('logisticportalid' => $val['logisticportalid']);
        if ($val['logisticgatwaytype'] <> '') {

            if ($val['logisticgatwaytype'] == 'admin') {

                //Convert Weight To KG     
                $convertweight = $objGeneral->convertproductweight($weightunit, $Weight);
                $arrProduct['Weight'] = $convertweight;
                $arrProduct['WeightUnit'] = 'kg';
                //pre($DimensionUnit);
                if ($DimensionUnit == 'cm') {
                    $arrProduct['Length'] = $Lengthvalue;
                    $arrProduct['Width'] = $Widthvalue;
                    $arrProduct['Height'] = $Heightvalue;
                }
                //Convert Weight To CM
                if ($DimensionUnit != 'cm') {
                    $arrProduct['Length'] = $objGeneral->convertproductdimention($DimensionUnit, $Lengthvalue);
                    $arrProduct['Width'] = $objGeneral->convertproductdimention($DimensionUnit, $Widthvalue);
                    $arrProduct['Height'] = $objGeneral->convertproductdimention($DimensionUnit, $Heightvalue);
                    //$arrProduct['DimensionUnit'] = 'cm';
                    $DimensionUnit = 'cm';
                }

                //Calculate Volumetric weight 
                if ($DimensionUnit == 'cm') {

                    $volumetricWt = ($arrProduct['Length'] * $arrProduct['Width'] * $arrProduct['Height']) / 5000;

                    if ($volumetricWt > $arrProduct['Weight']) {
                        $WeightPro = ceil($volumetricWt);
                    } else {
                        $WeightPro = ceil($arrProduct['Weight']);
                    }
                    //pre($WeightPro);
                }

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
                        . " LEFT JOIN " . TABLE_ZONEDETAIL . " ON zonetitleid = fkzoneid"
                        . " LEFT JOIN " . TABLE_LOGISTICPORTAL . " ON fklogisticidvalue = logisticportalid"
                        . " where fklogisticidvalue =" . $Shipping['logisticportalid'] . " "
                        . " AND DATE(created) = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE "
                        . " fklogisticidvalue =" . $Shipping['logisticportalid'] . " AND newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid "
                        . " AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod AND DATE(created) <= '" . $date . "')"
                        . " AND minkg <= " . $arrProduct['Weight'] . " and maxkg >= " . $arrProduct['Weight'] . ""
                        . " AND fromcountry =" . $wholesalercountryid . ""
                        . " AND tocountry =" . $cid . ""
                        . " AND maxlength >=" . $arrProduct['Length'] . ""
                        . " AND maxwidth >=" . $arrProduct['Width'] . ""
                        . " AND maxheight >=" . $arrProduct['Height'] . ""
                        . " AND pricestatus = 1"
                        . " group by pkpriceid ";
                //. " group by pkpriceid order by date(`created`) desc";
                // pre($varQuery);
                $arrRes = $objdatabase->getArrayResult($varQuery);
//                 echo "<pre>";
//                print_r($arrRes);

                foreach ($arrRes as $kk => $valuee) {

                    $arrProduct['qty'] = 1;

                    $ShippingCostByKg = (float) ($WeightPro * $valuee['costperkg']);
                    $ShippingCost = (float) ($ShippingCostByKg * $arrProduct['qty']);
                    $arrRes[$kk]['ShippingCost'] = $ShippingCost;

                    if ($fragilecost == 'fragile') {
                        $arrProduct['qty'] = 1;
                        $arrRes[$kk]['ShippingCost'] = $arrRes[$kk]['ShippingCost'] + ($valuee['fragilecost'] * $arrProduct['qty']);
                    }
                    $arrRes2[$key][$kk] = $arrRes[$kk];
                }


//                echo "<pre>";
//                print_r($arrRes);
                //return $arrRes;
//                    $arrShippingMethods = $objShipping->AdminShippingnew($arrPro, $arrCustomer, $Shipping);
//                   
//                    $arrRes[$key]['Methods'] = $arrShippingMethods;
            } else {

//                    $arrShippingMethods = $objShipping->$val['ShippingAlias']($arrPro, $arrCustomer, $val['method']);
//                    $arrRes[$key]['Methods'] = $arrShippingMethods;
            }
        }
    }
    //pre($arrRes2);
    return $arrRes2;
}

?>