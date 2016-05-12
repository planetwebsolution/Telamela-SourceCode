<?php

/**
 * Site ShoppingCart Class
 *
 * This is the ShoppingCart class that will used on website.
 *
 * DateCreated 5th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class ShoppingCart extends Database {
    /*
     * constructor
     */

    function __construct() {
        
    }

    /**
     * function myCartDetails
     *
     * This function is used retrive cart details.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_today_offer, tbl_category, tbl_wholesaler, tbl_coupon, tbl_coupon_to_product, tbl_package
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function myCartDetails($arrCustomer = array()) {

        global $objCore;
        global $objGeneral;
        $isAccess = 0;
//        pre($arrCustomer);
        $varFileName = basename($_SERVER['PHP_SELF']);

        if (isset($_SESSION['sessUserInfo']['type']) && $_SESSION['sessUserInfo']['type'] == 'customer' && in_array($varFileName, array('shipping_charge.php'))) {
            $isAccess = 1;
            //pre();
            //$arrCustomer = $this->select(TABLE_CUSTOMER, array('ShippingCountry'), "pkCustomerID='" . $_SESSION['sessUserInfo']['id'] . "'");
            $varCustomerCountry = $arrCustomer['ShippingCountry'];
        }
//        pre($_SESSION);
        //$arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartData'), "fkCustomerID='" . $_SESSION['sessUserInfo']['id'] . "'");
//        pre($arrCart);
        $varCount = (int) $_SESSION['MyCart']['Total'];
        if ($varCount > 0) {


            /* $varCartIDS = implode(',', array_keys($_SESSION['MyCart']['Product']));
              if ($varCartIDS <> '') {
              echo  $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,OfferPrice,fkShippingID,ProductDescription,ProductImage as ImageName,CategoryName,fkWholesalerID,CompanyName
              FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_PRODUCT_TODAY_OFFER . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_CATEGORY . " ON fkCategoryID = pkCategoryId LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID
              WHERE pkProductID IN (" . $varCartIDS . ")Group By pkProductID";
              $arrRes['Product'] = $this->getArrayResult($varQuery);
              //$arrUserList = $this->select($varQuery);
              } */

            //echo   count($_SESSION['MyCart']['Product']);
//             pre($_SESSION['MyCart']);
            $contt = 0;
            foreach ($_SESSION['MyCart']['Product'] as $key => $val) {
                foreach ($val as $sessIndex => $sessVal) {
                    //echo $sessIndex.'<br>';die;
                    $id = explode('-', $sessIndex);
                    if ($sessIndex != 'ShippingCost') {
                        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,wholesalePrice,FinalPrice,DiscountPrice,Weight,WeightUnit,Length,Width,Height,DimensionUnit,DiscountFinalPrice,OfferACPrice,OfferPrice,Quantity,fkShippingID,ProductDescription,ProductImage as ImageName,CategoryName,fkWholesalerID,CompanyName,CompanyCountry,Commission,wholesalePrice
                    FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_PRODUCT_TODAY_OFFER . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_CATEGORY . " ON fkCategoryID = pkCategoryId INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus<>'deactive')
                    WHERE pkProductID = '" . $key . "' AND ProductStatus='1' Group By pkProductID";

                        $arrRow = $this->getArrayResult($varQuery);
                        //pre($arrRow);
                        //print_r($arrRow);
                        if (count($arrRow) == 0) {
                            (int) $_SESSION['MyCart']['Total']-=1;
                            unset($_SESSION['MyCart']['Product'][$key]);
                        }
                        $arrAttribute = $this->getAttributeName($arrRow[0]['pkProductID'], $sessVal['attribute']);
//pre($arrAttribute);
                        $arrRow[0]['attribute'] = $arrAttribute['details'];
                        $arrRow[0]['attributePrice'] = $arrAttribute['price'];
                        //$arrRow[0]['ImageName'] = $objCore->getvalidImage($arrAttribute['image'], $arrRow[0]['ImageName'], 'products/' . $arrProductImageResizes['default']);
                        //$arrRow[0]['attributeImage'] = $objCore->getvalidImage($arrAttribute['image'], $arrRow[0]['ImageName'], 'products/' . $arrProductImageResizes['default']);

                        $arrRow[0]['attrOptMaxQty'] = (int) $this->getAttributeStock($arrRow[0]['pkProductID'], $sessVal['attribute']);

                        $arrRes['Product'][$sessIndex] = $arrRow[0];
                        $arrRes['Product'][$sessIndex]['qty'] = $_SESSION['MyCart']['Product'][$key][$sessIndex]['qty'];
                       // pre($isAccess);
                        if ($isAccess) {
                           // pre("here");
                            $isDom = ($varCustomerCountry == $arrRow[0]['CompanyCountry']) ? 1 : 0;
                            $arrRes['Product'][$sessIndex]['ShippingDetails'] = $this->getShippingDetailsForProduct($arrRow[0]['pkProductID'], $arrRow[0]['fkShippingID'], $arrRes['Product'][$sessIndex]['qty'], 0, $isDom, $arrCustomer);
                           
                            //Please uncomment while start shwoing logistic on site and comment above line:Raju comment
                            //$arrRes['Product'][$sessIndex]['ShippingDetails'] = $this->getShippingDetailsForProductLogistic($arrRow[0]['fkWholesalerID'],$arrCustomer['pkCustomerID'], $arrRes['Product'][$sessIndex]['qty'],$arrRow[0]['pkProductID']);
                        }
                    //  pre( $arrRes['Product'][$sessIndex]['ShippingDetails']);
//                         $Shipping = array('shippingId' => $val['pkShippingGatewaysID'], 'ShippingTitle' => $val['ShippingTitle']);
//                         //pre($Shipping);
//                         $arrPro = $objShipping->getProductDetailsnew($proID, $qty, $Shipping);
//                         //pre($arrRes['Product'][$sessIndex]['ShippingDetails']);
// 						
                       // pre($arrRes['Product'][$sessIndex]['ShippingDetails']);
//                         pre($arrRes['Product'][$sessIndex]['AppliedShipping']);
                        $arrRes['Product'][$sessIndex]['AppliedShipping'] = $_SESSION['MyCart']['Product'][$key][$sessIndex]['AppliedShipping'];
                    //pre($arrRes['Product'][$sessIndex]['AppliedShipping']);
                        //$arrUserList = $this->select($varQuery);
                        $arrPids[] = $arrRow[0]['pkProductID'];

                        $contt++;
                    }
                }
            }

            $arrSpecialProductPrice = $objGeneral->getAllSpecialProductPrice(implode(',', $arrPids));
        }

//        pre($arrRes);
        //$arrRes['Product'] =  array_reverse($arrRes['Product']);
        foreach ($arrRes['Product'] as $key => $val) {
            if ($val['OfferPrice'] <> '' || $val['OfferPrice'] > 0) {
                $varACPrice = $val['OfferACPrice'];
                $varUsePrice = $val['OfferPrice'];
                $varPriceCategory = 'Offer';
            } else if (isset($arrSpecialProductPrice[$val['pkProductID']])) {
                $varACPrice = $arrSpecialProductPrice[$val['pkProductID']]['SpecialPrice'];
                $varUsePrice = $arrSpecialProductPrice[$val['pkProductID']]['FinalSpecialPrice'];
                $varPriceCategory = 'Offer';
            } else if ($val['DiscountFinalPrice'] > 0) {
                $varACPrice = $val['DiscountPrice'];
                $varUsePrice = $val['DiscountFinalPrice'];
                $varPriceCategory = 'Discount';
            } else {
                $varACPrice = $val['wholesalePrice'];
                $varUsePrice = $val['FinalPrice'];
                $varPriceCategory = 'Price';
            }
            $arrRes['Product'][$key]['DiscountPrice1'] = $val['DiscountPrice'];
            $arrRes['Product'][$key]['DPrice'] = $val['FinalPrice'];
            $arrRes['Product'][$key]['ACPrice'] = $varACPrice;
            $arrRes['Product'][$key]['ItemPrice'] = $varUsePrice;
            $arrRes['Product'][$key]['FinalPrice'] = $varUsePrice + $arrRes['Product'][$key]['attributePrice'];
            $arrRes['Product'][$key]['PriceCategory'] = $varPriceCategory;
            unset($arrRes['Product'][$key]['DiscountPrice'], $arrRes['Product'][$key]['DiscountFinalPrice'], $arrRes['Product'][$key]['OfferACPrice'], $arrRes['Product'][$key]['OfferPrice']);
        }


        foreach ($_SESSION['MyCart']['GiftCard'] as $key => $val) {
            $arrRes['GiftCard'][$key]['amount'] = $val['amount'];
            $arrRes['GiftCard'][$key]['fromName'] = $val['fromName'];
            $arrRes['GiftCard'][$key]['toName'] = $val['toName'];
            $arrRes['GiftCard'][$key]['toEmail'] = $val['toEmail'];
            $arrRes['GiftCard'][$key]['message'] = $val['message'];
            $arrRes['GiftCard'][$key]['qty'] = $val['qty'];
        }

//        pre($arrRes['GiftCard']);
        if (isset($_SESSION['MyCart']['CouponCode']) && $_SESSION['MyCart']['CouponCode'] <> '') {
            $arrRes['Common']['CouponCode'] = $_SESSION['MyCart']['CouponCode'];
            $arrResCoupon = $this->select(TABLE_COUPON, array("pkCouponID", "CouponCode", "Discount", "IsApplyAll"), " CouponCode = '" . $arrRes['Common']['CouponCode'] . "'");


            foreach ($arrRes['Product'] as $key => $val) {

                if ($arrResCoupon[0]['IsApplyAll'] == 1) {
                    $arrRes['Product'][$key]['Discount'] = ($arrResCoupon[0]['Discount'] * $val['FinalPrice'] * $_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['qty']) / 100;
                } else {
                    $varWhr = " AND fkProductID = '" . $val['pkProductID'] . "' AND fkCouponID = '" . $arrResCoupon[0]['pkCouponID'] . "' ";
                    $varNum = $this->getNumRows(TABLE_COUPON_TO_PRODUCT, "fkProductID", $varWhr);

                    if ($varNum > 0) {
                        $arrRes['Product'][$key]['Discount'] = ($arrResCoupon[0]['Discount'] * $val['FinalPrice'] * $_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['qty']) / 100;
                    } else {
                        $arrRes['Product'][$key]['Discount'] = 0.00;
                    }
                }
            }
        } else {
            $arrRes['Common']['CouponCode'] = '';
        }

        $arrRes['Common']['CartCount'] = $varCount;


        // Find Packages Details for products
        if ($_SESSION['MyCart']['Package']) {
            /* $varCartIDS = implode(',', array_keys($_SESSION['MyCart']['Package']));
              $varQuery = "SELECT pkPackageId,fkWholesalerID,CompanyName,PackageName,PackagePrice,PackageImage FROM " . TABLE_PACKAGE . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID  WHERE pkPackageId IN (" . $varCartIDS . ") ";
              $arrRes['Package'] = $this->getArrayResult($varQuery);
             */
            //$packcount = 0;

            foreach ($_SESSION['MyCart']['Package'] as $packkey => $packval) {

                foreach ($packval as $sessIndex => $sessVal) {
                    if ($sessIndex != 'TotalShippingCost' && $sessIndex != 'ProductShippingCost') {
                        $varQuery = "SELECT pkPackageId,pk.fkWholesalerID,CompanyName,CompanyCountry,PackageName,PackageACPrice,PackagePrice,PackageImage,MIN( Quantity ) as Quantity FROM " . TABLE_PACKAGE . " pk LEFT JOIN " . TABLE_WHOLESALER . " w ON fkWholesalerID = w.pkWholesalerID INNER JOIN " . TABLE_PRODUCT_TO_PACKAGE . " x ON pkPackageId = x.fkPackageId
LEFT JOIN " . TABLE_PRODUCT . " p ON p.pkProductID = x.fkProductId WHERE pkPackageId = " . $packkey . " ";
                        $arrPackRow = $this->getArrayResult($varQuery);
                        //pre($arrPackRow);
                        //$getProduct= $this->getProductForPackage($arrPackRow[0]['pkPackageId']); 
                        $arrPackRow[0]['product'] = $sessVal['product'];
                        //$arrPackRow[0]['product']=$arrPackRow[0]['ProductIds'];
                        $arrPackRow[0]['productDetail'] = $this->getPackageProductsDetails($sessVal['product']);
                        //$arrPackRow[0]['productDetail'] = $this->getPackageProductsDetailsNew($arrPackRow[0]['ProductIds']);
                        $arrRes['Package'][$sessIndex] = $arrPackRow[0];

                        if ($isAccess) {
                            $isDom = ($varCustomerCountry == $arrPackRow[0]['CompanyCountry']) ? 1 : 0;

                            $arrRes['Package'][$sessIndex]['ShippingDetails'] = $this->getShippingDetailsForPackage($arrPackRow[0]['fkWholesalerID'], $arrCustomer['pkCustomerID'], $_SESSION['MyCart']['Package'][$packkey][$sessIndex]['qty'], $arrPackRow[0]['pkPackageId']);

                            //Please uncomment while start shwoing logistic on site and comment above line:Raju comment
                            //$arrRes['Package'][$sessIndex]['ShippingDetails'] = $this->getShippingDetailsForProductLogisticForPackage($arrPackRow[0]['fkWholesalerID'],$arrCustomer['pkCustomerID'], $_SESSION['MyCart']['Package'][$packkey][$sessIndex]['qty'],$arrPackRow[0]['pkPackageId']);
                        }

                        $arrRes['Package'][$sessIndex]['qty'] = $_SESSION['MyCart']['Package'][$packkey][$sessIndex]['qty'];
                        $arrRes['Package'][$sessIndex]['AppliedShipping'] = $_SESSION['MyCart']['Package'][$packkey][$sessIndex]['AppliedShipping'];
                        //$packcount++;
                    }
                }
            }


            $arrRes['Package'] = array_reverse($arrRes['Package']);
        }
//        pre($_SESSION['MyCart']['arrReward']['singleDeductionAmount']);
        //calculate Total item No. per including quantity
//        $arrRes['TotalItemCount'] = 0;
//        foreach ($arrRes['Product'] as $key => $value) {
//            $arrRes['TotalItemCount'] += $value['qty'];
//        }
        //For Reward Point 
//            $rewardPrice = 0;
//            if (isset($_SESSION['MyCart']['arrReward']) && $_SESSION['MyCart']['arrReward']['RewardValue'] > 0) {
//                $arrRes['SingleReduceValue'] = $_SESSION['MyCart']['arrReward']['RewardValue'] / $arrRes['TotalItemCount'];
////                $rewardPrice = $_SESSION['MyCart']['arrReward']['RewardValue'];
//            }
//        pre($_SESSION);
//        pre($arrRes);
        $newCountry = array();
        $newWhWithCountry = array();
        $newWhCommision = array();
       
        //$newCountry[$value['CompanyCountry']]['TotalItemCount'] = 0;
        foreach ($arrRes['Product'] as $key => $value) {

            if (array_key_exists($value['CompanyCountry'], $newCountry)) {
                $newCountry[$value['CompanyCountry']]['ProductPrice'] += $value['FinalPrice'] * $value['qty'];
                //$newCountry[$value['CompanyCountry']]['MarginPrice'] += (($value['FinalPrice'] - $value['wholesalePrice']) * $value['qty']);
                $newCountry[$value['CompanyCountry']]['TotalCounryItemCount'] += $value['qty'];
                $newCountry[$value['CompanyCountry']]['FinalPrice'] += $value['FinalPrice'] * $value['qty'] - ($_SESSION['MyCart']['arrReward']['singleDeductionAmount'] * $value['qty']);
                $newCountry[$value['CompanyCountry']]['CompanyEmail'] = $value['CompanyEmail'];
                $newCountry[$value['CompanyCountry']]['ShippingCost'] += $value['AppliedShipping']['ShippingCost'];
                $TotalShipping += $value['AppliedShipping']['ShippingCost'];
                $newCountry[$value['CompanyCountry']]['PriceWithShipping'] = $newCountry[$value['CompanyCountry']]['FinalPrice'] + $newCountry[$value['CompanyCountry']]['ShippingCost'];
            } else {
                $newCountry[$value['CompanyCountry']]['ProductPrice'] = $value['FinalPrice'] * $value['qty'];
                //$newCountry[$value['CompanyCountry']]['MarginPrice'] = ($value['FinalPrice'] - $value['wholesalePrice']) * $value['qty'];
                $newCountry[$value['CompanyCountry']]['TotalCounryItemCount'] = $value['qty'];
                $newCountry[$value['CompanyCountry']]['FinalPrice'] = $value['FinalPrice'] * $value['qty'] - ($_SESSION['MyCart']['arrReward']['singleDeductionAmount'] * $value['qty']);
                $newCountry[$value['CompanyCountry']]['CompanyEmail'] = $value['CompanyEmail'];
                $newCountry[$value['CompanyCountry']]['ShippingCost'] += $value['AppliedShipping']['ShippingCost'];
                $TotalShipping += $value['AppliedShipping']['ShippingCost'];
                $newCountry[$value['CompanyCountry']]['PriceWithShipping'] = $newCountry[$value['CompanyCountry']]['FinalPrice'] + $newCountry[$value['CompanyCountry']]['ShippingCost'];
            }
        }
//        pre($newCountry);
        //make array wholesaler wise
        foreach ($arrRes['Product'] as $key => $value) {
//            pre($_SESSION);
            if ($_SESSION['MyCart']['arrReward']['RewardStatus'] == 1) {
                $FinalWithRward = (($value['FinalPrice'] * $value['qty']) - ($_SESSION['MyCart']['arrReward']['singleDeductionAmount']) * $value['qty']);
//                print_r($_SESSION['MyCart']['arrReward']['singleDeductionAmount']); echo '<br>';
//                print_r($value['FinalPrice']);echo '<br>';
//                print_r($FinalWithRward);echo '<br>';
            } else {
                $FinalWithRward = $value['FinalPrice'];
            }
            if (array_key_exists($value['fkWholesalerID'], $newWhCommision)) {
                if ((int) $value['DiscountPrice1'] === 0) {
                    $newWhCommision[$value['fkWholesalerID']]['MarginPrice'] += (($value['FinalPrice'] - $value['wholesalePrice']) * $value['qty']);
                } else {
                    $newWhCommision[$value['fkWholesalerID']]['MarginPrice'] += (($value['FinalPrice'] - $value['DiscountPrice1']) * $value['qty']);
                }
                $newWhCommision[$value['fkWholesalerID']]['CompanyCountry'] = $value['CompanyCountry'];
                $newWhCommision[$value['fkWholesalerID']]['AdminCommision'] += ((($FinalWithRward * (100 - $value['Commission'])) / 100) * $value['qty']);
            } else {
                if ((int) $value['DiscountPrice1'] === 0) {

                    //$newWhCommision[$value['fkWholesalerID']]['ProductPrice'] = $value['FinalPrice'] * $value['qty'];
                    $newWhCommision[$value['fkWholesalerID']]['MarginPrice'] = ($value['FinalPrice'] - $value['wholesalePrice']) * $value['qty'];
                } else {
                    //echo $value['wholesalePrice']. '<br>';
                    $newWhCommision[$value['fkWholesalerID']]['MarginPrice'] = ($value['FinalPrice'] - $value['DiscountPrice1']) * $value['qty'];
                }
                $newWhCommision[$value['fkWholesalerID']]['CompanyCountry'] = $value['CompanyCountry'];
                $newWhCommision[$value['fkWholesalerID']]['AdminCommision'] = (($FinalWithRward * (100 - $value['Commission'])) / 100 ) * $value['qty'];
            }
            //add marfin and commission in product array
            $arrRes['Product'][$key]['AdminMarginProduct'] = $newWhCommision[$value['fkWholesalerID']]['MarginPrice'];
            $arrRes['Product'][$key]['AdminCommissionProduct'] = $newWhCommision[$value['fkWholesalerID']]['AdminCommision'];


//            if($value['fkWholesalerID'] == 25){
//            echo "<pre>";
//            print_r($value['FinalPrice']);
//            }
        }
        //pre($newWhCommision);
        foreach ($newWhCommision as $key => $value) {
            if (array_key_exists($value['CompanyCountry'], $newWhWithCountry)) {
                $newWhWithCountry[$value['CompanyCountry']]['MarginPriceSet'] += $value['MarginPrice'];
                $newWhWithCountry[$value['CompanyCountry']]['AdminCommisionPrice'] += $value['AdminCommision'];
            } else {
                $newWhWithCountry[$value['CompanyCountry']]['MarginPriceSet'] = $value['MarginPrice'];
                $newWhWithCountry[$value['CompanyCountry']]['AdminCommisionPrice'] = $value['AdminCommision'];
            }
        }
//        pre($newCountry);
        //pre($newWhWithCountry);
        $varQueryadmin = "SELECT PaypalEmailID FROM " . TABLE_ADMIN . " WHERE AdminType = 'super-admin' ";
        $arrRowadmin = $this->getArrayResult($varQueryadmin);
        $arrRes['Common']['SuperAdminPaypal'] = $arrRowadmin[0]['PaypalEmailID'];

        $arrRes['newCountry'] = $newCountry;
        $arrRes['Common']['CartTotal'] = 0;
        $AdminArray = array();
        $kk = 0;
        foreach ($newCountry as $key => $val) {

            $varQuery1 = "SELECT AdminEmail,PaypalEmailID FROM " . TABLE_ADMIN . " WHERE AdminCountry = " . $key . " AND AdminType = 'user-admin' "; //AND fkAdminRollId = 4
            $arrPackRow1 = $this->getArrayResult($varQuery1);
            $arrRes['newCountry'][$key]['AdminEmail'] = $arrPackRow1[0]['AdminEmail'];
            $arrRes['newCountry'][$key]['PaypalEmailID'] = $arrPackRow1[0]['PaypalEmailID'];
            $arrRes['newCountry'][$key]['MarginPriceSet'] = $newWhWithCountry[$key]['MarginPriceSet'];
            $arrRes['newCountry'][$key]['AdminCommisionPrice'] = $newWhWithCountry[$key]['AdminCommisionPrice'];
            $arrRes['Common']['CartTotal'] += number_format($val['PriceWithShipping'], 2, '.', '');
            //calculate new final value (Reward point)
            //$arrRes['newCountry'][$key]['SingleReduceValueCountry'] = $arrRes['SingleReduceValue'] * $val['TotalCounryItemCount'];
            //$arrRes['newCountry'][$key]['FinalPrice'] = $val['FinalPrice'] - $arrRes['newCountry'][$key]['SingleReduceValueCountry'];
            //$arrRes['newCountry'][$key]['PriceWithShipping'] = $arrRes['newCountry'][$key]['FinalPrice'] + $val['ShippingCost'];


            $kk++;
            //}
        }
        //pre($arrRes['newCountry']);
        foreach ($arrRes['newCountry'] as $key => $val) {
            //echo $val['MarginPriceSet'];
            $arrRes['newCountry'][$key]['PriceWithShipping'] = number_format((float) $val['PriceWithShipping'] - ($val['MarginPriceSet'] + $val['AdminCommisionPrice']), 2, '.', '');
        }
//pre($_SESSION);
//        pre($arrRes);
//        pre($_SESSION['MyCart']);
        //$arrRes = array_reverse($arrRes);
//          pre($arrRes);
        return $arrRes;
    }

    /**
     * function getShippingDetailsForProduct
     *
     * This function is used to get shipping details for package.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getShippingDetailsForProduct($proID, $argSID, $qty, $smid = 0, $isDom, $arrCustomer) {
        //echo $isDom;
//        echo $proID.'..prod...'.$argSID.'..ship..'.$qty.'...'.$smid.'...'.$isDom.'...';
//        pre($arrCustomer);

        global $objCore;
        $objShipping = new ShippingPrice();

        if ($argSID != '') {
            $inCondition = "logisticportalid in(" . $argSID . ") AND";

            $varQuery = "SELECT logisticportalid,logisticgatwaytype,logisticTitle,logisticStatus "
                    . " FROM " . TABLE_LOGISTICPORTAL . ""
                    . " WHERE " . $inCondition . " logisticStatus='1' ORDER BY logisticTitle ASC";
            $arrRes = $this->getArrayResult($varQuery);
        } else {
            $inCondition = '';
            $arrRes = array();
        }
//        $varQuery = "SELECT logisticportalid,logisticgatwaytype,logisticTitle,logisticStatus "
//                . " FROM " . TABLE_LOGISTICPORTAL . ""
//                . " WHERE " . $inCondition . " logisticStatus='1' ORDER BY logisticTitle ASC";
//        $arrRes = $this->getArrayResult($varQuery);
//        pre($proID);
        //$arrRes = $this->getShippingDetails($argSID, $smid, $isDom);
//        echo '3453';
//        pre($arrRes);
        foreach ($arrRes as $key => $val) {
//             $Shipping = array('shippingId' => $val['pkShippingGatewaysID'], 'methodId' => $val['Methods'][0]['pkShippingMethod'], 'methodCode' => $val['Methods'][0]['MethodCode']);
            //echo '<pre>';print_r($Shipping);die;
            $Shipping = array('logisticportalid' => $val['logisticportalid']);

            $arrPro = $objShipping->getProductDetailsnew($proID, $qty, $Shipping);
//            echo '<pre>';
//            pre($arrPro);

            if ($val['logisticgatwaytype'] <> '') {

                if ($val['logisticgatwaytype'] == 'admin') {

                    $arrShippingMethods = $objShipping->AdminShippingnew($arrPro, $arrCustomer, $Shipping);
                    //echo '<pre>';
//                    pre($arrShippingMethods);
                    //if(empty($$arrShippingMethods[0]['pkShippingPriceID'])){
                    //  continue;
                    //}
                    $arrRes[$key]['Methods'] = $arrShippingMethods;
                } else {
                    //pre($val);
//                    echo $objShipping->$val['ShippingAlias']($arrPro, $arrCustomer, $val['method']);
//                   die;
                    $arrShippingMethods = $objShipping->$val['ShippingAlias']($arrPro, $arrCustomer, $val['method']);
                    $arrRes[$key]['Methods'] = $arrShippingMethods;
                    //pre($arrShippingMethods);
                }
            } else {
                // $varShippingCost = DEFAULT_SHIPPING_CHARGE;
            }
        }
//        pre($arrRes);
        foreach ($arrRes as $k => $v) {
            //pre($v['Methods'][0]['ShippingType']);
//            if (!empty($v['Methods'][0]['pkpriceid']) || !empty($v['Methods'][0]['ServiceType'])) {
            if (!empty($v['Methods']) || !empty($v['Methods'])) {
                $newarrRes[] = $v;
            }
        }
//        pre($newarrRes);
        return $newarrRes;
    }

    /**
     * function getRightCartContent
     *
     * This function is used to get cart content of right panel.
     *
     * Database Tables used in this function are :
     *
     * @access public
     *
     * @parameters 0
     *
     * @return string $html
     */
    function getRightCartContent() {
        /* $objCore = new Core();
          $varCartTotal = 0;
          $varCartSubTotal = 0;
          $arrData['arrCartDetails'] = $this->myCartDetails();
          ?>
          <div class="my_cart">
          <h5>My <span>Cart</span></h5>
          <div class="my_cart_inner">
          <div <?php if(count($arrData['arrCartDetails']['Product'])+count($arrData['arrCartDetails']['Package'])+count($arrData['arrCartDetails']['GiftCard'])>LIST_CART_BOX_LIMIT) {?> class="scroll-pane" <?php } ?>>
          <ul>
          <?php
          $i=0;
          foreach ($arrData['arrCartDetails']['Product'] as $kCart => $valCart) {
          $varCartSubTotal = $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$i]['qty'] * $valCart['FinalPrice'];
          ?>
          <li id="cart<?php echo $valCart['pkProductID']; ?>">
          <div class="bottom_border">
          <?php
          if ($valCart['ImageName'] <> '') {
          $varSrc = UPLOADED_FILES_URL . '/images/products/70x70/' . $valCart['ImageName'];
          } else {
          $varSrc = UPLOADED_FILES_URL . '/images/products/70x70/no-image.jpeg';
          }
          ?>
          <div class="image"><a href="<?php echo $objCore->getUrl('product.php',array('id'=>$valCart['pkProductID'],'name'=>$valCart['ProductName'],'refNo'=>$valCart['pkProductID']));?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['ProductName']; ?>" width="40" height="38" /></a>

          </div>
          <div class="details">
          <a href="<?php echo $objCore->getUrl('product.php',array('id'=>$valCart['pkProductID'],'name'=>$valCart['ProductName'],'refNo'=>$valCart['pkProductID']));?>"><?php echo ucfirst($valCart['ProductName']); ?></a><br />
          <span class="amt_qty"><?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$i]['qty']; ?> x <?php echo $objCore->getPrice($valCart['FinalPrice']); ?></span>
          <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
          </div></div>
          <div class="delete"><a href="#" onclick="RemoveProductFromCart(<?php echo $valCart['pkProductID']; ?>,<?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']]['qty']; ?>);"><img src="<?php echo IMAGE_FRONT_PATH_URL ;?>close.png" alt="Close" /></a></div>
          </li>
          <?php
          $varCartTotal += $varCartSubTotal;
          $i++;
          }


          foreach ($arrData['arrCartDetails']['Package'] as $kPKG => $vPKG) {
          $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']]['qty'] * $vPKG['PackagePrice'];
          ?>
          <li id="cart<?php echo $vPKG['pkProductID']; ?>">
          <div class="bottom_border">
          <?php
          if(!empty($vPKG['PackageImage'])){$varPackageSrc = UPLOADED_FILES_URL . 'images/package/73x73/'.$vPKG['PackageImage'];}
          else{$varPackageSrc = UPLOADED_FILES_URL . 'images/package/73x73/no-image.jpeg';}
          ?>
          <div class="image"><img src="<?php echo $varPackageSrc; ?>" alt="<?php echo $vPKG['PackageName']; ?>" width="40" height="38" />

          </div>
          <div class="details">
          <a href="product.php?pid=<?php echo $vPKG['pkPackageId']; ?>"><?php echo ucfirst($vPKG['PackageName']); ?></a><br />
          <span class="amt_qty"><?PHP echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']]['qty']; ?> x <?php echo $objCore->getPrice($vPKG['PackagePrice']); ?></span>
          <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
          </div></div>
          <div class="delete"><a href="#" onclick="RemovePackageFromCart(<?php echo $vPKG['pkPackageId']; ?>,<?PHP echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']]['qty']; ?>);"><img src="<?php echo IMAGE_FRONT_PATH_URL ;?>close.png" alt="Close" /></a></div>
          </li>
          <?php
          $varCartTotal += $varCartSubTotal;
          }

          foreach($arrData['arrCartDetails']['GiftCard'] as $key => $valGiftCards){
          $varCartSubTotal = $valGiftCards['qty'] * $valGiftCards['amount'];
          ?>
          <li id="RemoveGiftCard<?php echo $key;?>">
          <div class="bottom_border">
          <?php
          $varSrc = UPLOADED_FILES_URL . 'images/package/73x73/no-image.jpeg';
          ?>
          <div class="image"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valGiftCards['message']; ?>" width="40" height="38" />

          </div>
          <div class="details">
          <?php echo ucfirst($valGiftCards['message']);?><br />
          <span class="amt_qty"><?php echo $valGiftCards['qty'];?> x <?php echo $valGiftCards['amount'];?></span>
          <h5><?php echo $objCore->getPrice($varCartSubTotal);?></h5>
          </div></div>
          <div class="delete"><a href="javascript:void(0);" onclick="RemoveGiftCardFromCart('<?php echo $key;?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL ;?>close.png" alt="Close" /></a></div>
          </li>
          <?php
          $varCartTotal += $varCartSubTotal;
          }
          ?>



          </ul>

          </div>
          </div>
          <div class="checkout_cart">
          <div class="subtotal">
          SUBTOTAL
          <span><?php echo $objCore->getPrice($varCartTotal); ?></span>
          </div>
          <a href="<?php echo $objCore->getUrl('shopping_cart.php')?>" class="checkout_button">Checkout</a>
          </div>
          </div>
          <?php */
    }

    /**
     * function getAttributeOption
     *
     * This function is used to get attribute option.
     *
     * Database Tables used in this function are : tbl_product_to_option
     *
     * @access public
     *
     * @parameters 2 integer
     *
     * @return array $arrRes
     */
    function getAttributeOption($pid, $valOptId) {
        $varQuery = "SELECT AttributeOptionValue,OptionExtraPrice,AttributeOptionImage FROM " . TABLE_PRODUCT_TO_OPTION . " WHERE fkProductId='" . $pid . "' AND fkAttributeOptionId = '" . $valOptId . "'";
        $arrPackRow = $this->getArrayResult($varQuery);
        return $arrPackRow[0];
    }

    /**
     * function getAttributeLabel
     *
     * This function is used to get attribute label.
     *
     * Database Tables used in this function are : tbl_attribute
     *
     * @access public
     *
     * @parameters 1 integer
     *
     * @return string $AttributeLabel
     */
    function getAttributeLabel($attribID) {
        $varQuery = "SELECT AttributeLabel FROM " . TABLE_ATTRIBUTE . " WHERE pkAttributeID = '" . $attribID . "'";
        $arrPackRow = $this->getArrayResult($varQuery);
        return $arrPackRow[0]['AttributeLabel'];
    }

    /**
     * function getAttributeName
     *
     * This function is used to get attribute name.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 integer, 1 array
     *
     * @return array $arrAttrDetails
     */
    function getAttributeName($pid, $arrAttributeOption) {


        $attrbVals = "";
        $arrAttrDetails = array();
        $varOptPrice = 0;
        $objCore = new Core();

        foreach ($arrAttributeOption AS $attrOptions) {
            $attr = explode(':', $attrOptions);


            if (empty($attr[1])) {
                $attrbVals .= $this->getAttributeLabel($attr[0]) . ": ";
                $attrbVals .=$attr[2];
            } else {
                $attrbVals .= $this->getAttributeLabel($attr[0]) . ": ";
                $arrOptTemp = explode(',', $attr[1]);
                $num = count($arrOptTemp);
                $i = 1;
                foreach ($arrOptTemp as $attrOpt) {
                    if ($attrOpt > 0) {
                        $arrAttrbTempVals = $this->getAttributeOption($pid, $attrOpt);
                        $attrbVals .= $arrAttrbTempVals['AttributeOptionValue'];
                        if ($i < $num)
                            $attrbVals .=', ';
                        $varOptPrice += $arrAttrbTempVals['OptionExtraPrice'];
                        if ($arrAttrbTempVals['AttributeOptionImage'] <> '') {
                            $image = $arrAttrbTempVals['AttributeOptionImage'];
                        }
                    }
                    $i++;
                }
            }
            $attrbVals .= " | ";
        }



        if (!empty($attrbVals)) {
            $attrbVals = "(" . rtrim($attrbVals, "| ") . ")";
        }




        $arrAttrDetails['details'] = $attrbVals;
        $arrAttrDetails['price'] = $varOptPrice;
        $arrAttrDetails['image'] = $image;
        //pre($arrAttrDetails);
        return $arrAttrDetails;
    }

    /**
     * function getAttributeStock
     *
     * This function is used to get attribute stock.
     *
     * Database Tables used in this function are : tbl_attribute
     *
     * @access public
     *
     * @parameters 1 integer, 1 array
     *
     * @return int $arrRes
     */
    function getAttributeStock($pid, $arrAttributeOption) {

        $arrAttr = array();
        $arrAttrOpt = array();

        $objCore = new Core();
        $objShoppingCart = new ShoppingCart();
        foreach ($arrAttributeOption AS $attrOptions) {
            $attr = explode(':', $attrOptions);
            if ($attr[0] <> '') {
                $arrAttrbVals[] = (int) $attr[0];
                $arrAttrOpt[$attr[0]] = $attr[1];
            }
        }
        if (count($arrAttrbVals) > 0) {
            $varAttrIds = implode(',', $arrAttrbVals);
            $varQuery = "SELECT pkAttributeID FROM " . TABLE_ATTRIBUTE . " WHERE pkAttributeID IN (" . $varAttrIds . ") AND AttributeInputType IN ('image','select','radio','checkbox')";
            $arrResultRow = $this->getArrayResult($varQuery);
        }

        if (count($arrResultRow) > 0) {
            foreach ($arrResultRow as $val) {
                if ($arrAttrOpt[$val['pkAttributeID']] <> '') {
                    $varOptIds .= trim($arrAttrOpt[$val['pkAttributeID']], ',') . ',';
                }
            }

            $res = $this->getStock($pid, trim($varOptIds, ','));
        } else {
            $res = $this->getQuantity($pid);
        }

        return $res['stock'];
    }

    /**
     * function getPackageProductsDetails
     *
     * This function is used to get package detials.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string $arrRes
     */
    function getPackageProductsDetails($productsDetails) {
        $productsDetails = '';
        foreach ($arrPackageProducts AS $pid => $attributes) {
            $productName = $this->getProductById($pid);
            $arrAttribute = $this->getAttributeName($pid, $attributes);
            $attrVals = $arrAttribute['details'];
            $prodDetail = $productName . "<br/>" . $attrVals;
            $productsDetails .= $prodDetail . "<br/>";
        }
        return $productsDetails;
    }

    /**
     * function getProductById
     *
     * This function is used to get product name.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getProductById($valProductID) {
        $varQuery = "SELECT ProductName FROM " . TABLE_PRODUCT . " WHERE pkProductID = '" . $valProductID . "'";
        $arrResultRow = $this->getArrayResult($varQuery);
        return $arrResultRow[0]['ProductName'];
    }

    /**
     * function getProductQuantityById
     *
     * This function is used to get product quantity.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getProductQuantityById($valProductID) {
        $varQuery = "SELECT Quantity FROM " . TABLE_PRODUCT . " WHERE pkProductID in (" . $valProductID . ")";
        $arrResultRow = $this->getArrayResult($varQuery);
        return $arrResultRow[0];
    }

    /**
     * function getShippingDetails
     *
     * This function is used to get shipping details for product.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getShippingDetails($argSID = 0, $smid = 0, $isDomestic = 0) {

//        $varQuery = "SELECT pkShippingGatewaysID,ShippingType,ShippingTitle,ShippingAlias FROM " . TABLE_SHIPPING_GATEWAYS . " WHERE pkShippingGatewaysID in(" .$argSID . ") AND ShippingStatus='1' ORDER BY ShippingTitle ASC";
        $varQuery = "SELECT pkShippingGatewaysID,ShippingType,ShippingTitle,ShippingAlias FROM " . TABLE_SHIP_GATEWAYS . " WHERE pkShippingGatewaysID in(" . $argSID . ") AND ShippingStatus='1' ORDER BY ShippingTitle ASC";
        $arrRes = $this->getArrayResult($varQuery);
//        $wsmid = ($smid > 0) ? " AND pkShippingMethod='" . $smid . "' " : "";
//         //pre($arrRes);
//         foreach ($arrRes as $k => $v) {
//             if ($smid == 0) {
//                 if ($v['ShippingType'] == 'api') {
//                     $wsmid .= ($isDomestic == 1) ? " AND MethodService='domestic' " : " AND MethodService='international' ";
//                 }
//             }
//            $arrRes[$k]['Methods'] = $this->shippingMethodList("fkShippingGatewayID = '" . $v['pkShippingGatewaysID'] . "' " . $wsmid . " ");
//         }
        //echo '<pre>';print_r($arrRes);die;
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function custom_intersect
     *
     * This function is used to get common shipping ids.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return array 1 string
     */
    function custom_intersect($arrays) {

        $arrCommon = array();
        $i = 0;
        foreach ($arrays as $key => $val) {

            if ($i == 0) {
                $arrCommon = $val;
            } else {
                $arrCommon = array_intersect($arrCommon, $val);
            }
            $i++;
        }
        $result = implode(',', $arrCommon);
        return $result;
    }

    /**
     * function getShippingDetailsForPackage
     *
     * This function is used to get shipping details for package.
     *
     * Database Tables used in this function are : tbl_product_to_package, tbl_product, tbl_package, tbl_wholesaler_to_shipping_gateway
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getShippingDetailsForProductLogisticForPackage($wholID = null, $cusID = null, $qty = null, $pId = null) {
        global $objCore;
        $varQuery = "SELECT fkShippingID, fkProductId  FROM " . TABLE_PRODUCT_TO_PACKAGE . " as ptp left Join " . TABLE_PRODUCT . " as p ON p.pkProductID = ptp.fkProductId WHERE ptp.fkPackageId in(" . $pId . ")  GROUP BY pkProductID";
        $arrTemp = $this->getArrayResult($varQuery);
        //pre($arrTemp);
        $arrRow = array();
        $weightkg = 0;
        $weightPound = 0;
        foreach ($arrTemp as $key => $val) {
            $productFeilds = array('( CASE WHEN WeightUnit ="g" THEN (Weight/1000) WHEN weightUnit = "lb" THEN (Weight * 0.45359237) WHEN weightUnit = "oz" THEN (Weight * 0.0283495231) ELSE Weight END ) AS weightKg,( CASE WHEN WeightUnit ="g" THEN (Weight/453.59237) WHEN weightUnit = "kg" THEN (Weight/0.45359237) WHEN weightUnit = "oz" THEN (Weight/16) ELSE Weight END ) AS weightPound');
            $productDetails = $this->select(TABLE_PRODUCT, $productFeilds, 'pkProductID="' . (int) $val['fkProductId'] . '"');
            $weightkg+=$productDetails[0]['weightKg'];
            $weightPound+=$productDetails[0]['weightPound'];
        }
        $wholesalerDetails = $this->select(TABLE_WHOLESALER, array('CompanyCountry,CompanyCity'), 'pkWholesalerID="' . (int) $wholID . '"');
        $custometDetails = $this->select(TABLE_CUSTOMER, array('ShippingCountry,ShippingTown'), 'pkCustomerID="' . (int) $cusID . '"');
        //pre($qty);
        if (count($wholesalerDetails) > 0 && count($custometDetails) > 0) {
            $whereShipping = "b.fromCountry='" . (int) $wholesalerDetails[0]['CompanyCountry'] . "' AND b.fromCity='" . trim($wholesalerDetails[0]['CompanyCity']) . "' AND b.toCountry='" . (int) $custometDetails[0]['ShippingCountry'] . "' AND b.toCity='" . trim($custometDetails[0]['ShippingTown']) . "'";
            $shippingQuery = "SELECT * FROM ( SELECT pkLogisticID, CompanyName, AboutCompany, logisticLogo, ( CASE WHEN weightDefineUnit ='kg' THEN  (CASE WHEN $weightkg > 0 AND $weightkg <= 5 THEN (price*$qty) WHEN $weightkg >= 6 AND $weightkg <= 10 THEN (price2*$qty) WHEN $weightkg >= 11 AND $weightkg <= 15 THEN (price3*$qty) WHEN $weightkg >= 16 AND $weightkg <= 20 THEN (price6*$qty) WHEN $weightkg >= 21 AND $weightkg <= 25 THEN (price4*$qty) ELSE price5 END ) ELSE  CASE WHEN weightDefineUnit ='lb' THEN  (CASE WHEN $weightPound > 0 AND $weightPound <= 5 THEN (price*$qty) WHEN $weightPound >= 6 AND $weightPound <= 10 THEN (price2*$qty) WHEN $weightPound >= 11 AND $weightPound <= 15 THEN (price3*$qty) WHEN $weightPound >= 16 AND $weightPound <= 20 THEN (price6*$qty) WHEN $weightPound >= 21 AND $weightPound <= 25 THEN (price4*$qty) ELSE price5 END ) END END ) AS price FROM tbl_logistic a INNER JOIN tbl_logistic_zonewise_price b ON a.pkLogisticID = b.logisticPartnerID WHERE {$whereShipping} ) AS tab1 WHERE price >0 ORDER BY price ASC";
            $shippingData = $this->getArrayResult($shippingQuery);
        }
        return $shippingData;
    }

    function getShippingDetailsForPackage($pkgID, $sid = 0, $smid = 0, $isDom, $arrCustomer) {
        //die("abc");
        $objShipping = new ShippingPrice();
        if (empty($pkgID))
            $pkgID = "''";
        $varQuery = "SELECT fkShippingID, fkProductId  FROM " . TABLE_PRODUCT_TO_PACKAGE . " as ptp left Join " . TABLE_PRODUCT . " as p ON p.pkProductID = ptp.fkProductId WHERE ptp.fkPackageId in(" . $pkgID . ")  GROUP BY pkProductID";
        $arrTemp = $this->getArrayResult($varQuery);

        $arrRow = array();
        foreach ($arrTemp as $key => $val) {
            $arrPids[] = $val['fkProductId'];
            $shipids = explode(',', $val['fkShippingID']);
            $arrRow[$val['fkProductId']] = $shipids;
        }

        $result = $this->custom_intersect($arrRow);
        if ($result == '') {
            $varQuery = "SELECT GROUP_CONCAT(fkShippingGatewaysID) as Sids  FROM " . TABLE_PACKAGE . " as p INNER JOIN " . TABLE_WHOLESALER_TO_SHIPPING_GATEWAY . " as wsg ON p.fkWholesalerID = wsg.fkWholesalerID WHERE p.pkPackageId in(" . $pkgID . ")";
            $arrTemp = $this->getArrayResult($varQuery);
            $result = $arrTemp[0]['Sids'];
        }
        if ($result == '') {
            $result = '0';
        }

        $sgid = ($sid == 0) ? $result : $sid;

        $arrRes = $this->getShippingDetails($sgid, $smid, $isDom);

        foreach ($arrRes as $key => $val) {

            $Shipping = array('shippingId' => $val['pkShippingGatewaysID'], 'methodId' => $val['Methods'][0]['pkShippingMethod'], 'methodCode' => $val['Methods'][0]['MethodCode']);

            $pids = $arrPids; //explode(',', $arrPids);
            $varShippingCost = 0;

            $arrShippingMethods = array();
            foreach ($pids as $pk => $pv) {

                $arrPro = $objShipping->getProductDetails($pv, 1, $Shipping);

                if ($val['ShippingType'] <> '') {

                    if ($val['ShippingType'] == 'admin') {
                        $arrShippingMethods[] = $objShipping->AdminShipping($arrPro, $arrCustomer, $val['Methods']);
                        //print_r($arrShippingMethods);
                    } else {
                        $arrShippingMethods[] = $objShipping->$val['ShippingAlias']($arrPro, $arrCustomer, $val['Methods']);
                        //print_r($arrShippingMethods);
                    }
                }
            }
            //pre($arrShippingMethods);

            $i = 0;
            $arrShippingMthd = array();
            foreach ($arrShippingMethods as $vv) {

                if ($i == 0) {
                    $arrShippingMthd = $vv;
                } else {
                    $j = 0;
                    foreach ($vv as $vvv) {
                        $arrShippingMthd[$j]['ShippingCost'] += $vvv['ShippingCost'];
                        $j++;
                    }
                }
                $i++;
            }
            //pre($arrShippingMthd);
            $arrRes[$key]['Methods'] = $arrShippingMthd;
        }
        foreach ($arrRes as $k => $val) {
            if (!is_array($val['Methods']) || count($val['Methods']) <= 0) {
                unset($arrRes[$k]);
            }
        }
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getShippingDetailsForProduct
     *
     * This function is used to get shipping details for package.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getShippingDetailsForProductLogistic($wholID = null, $cusID = null, $qty = null, $pId = null) {
        global $objCore;
        $productFeilds = array('( CASE WHEN WeightUnit ="g" THEN (Weight/1000) WHEN weightUnit = "lb" THEN (Weight * 0.45359237) WHEN weightUnit = "oz" THEN (Weight * 0.0283495231) ELSE Weight END ) AS weightKg,( CASE WHEN WeightUnit ="g" THEN (Weight/453.59237) WHEN weightUnit = "kg" THEN (Weight/0.45359237) WHEN weightUnit = "oz" THEN (Weight/16) ELSE Weight END ) AS weightPound');
        $productDetails = $this->select(TABLE_PRODUCT, $productFeilds, 'pkProductID="' . (int) $pId . '"');
        $wholesalerDetails = $this->select(TABLE_WHOLESALER, array('CompanyCountry,CompanyCity'), 'pkWholesalerID="' . (int) $wholID . '"');
        $custometDetails = $this->select(TABLE_CUSTOMER, array('ShippingCountry,ShippingTown'), 'pkCustomerID="' . (int) $cusID . '"');

        if (count($wholesalerDetails) > 0 && count($custometDetails) > 0 && count($productDetails) > 0) {
            $weightkg = $productDetails[0]['weightKg'];
            $weightPound = $productDetails[0]['weightPound'];
            $whereShipping = "b.fromCountry='" . (int) $wholesalerDetails[0]['CompanyCountry'] . "' AND b.fromCity='" . trim($wholesalerDetails[0]['CompanyCity']) . "' AND b.toCountry='" . (int) $custometDetails[0]['ShippingCountry'] . "' AND b.toCity='" . trim($custometDetails[0]['ShippingTown']) . "'";

            $shippingQuery = "SELECT * FROM ( SELECT pkLogisticID, CompanyName, AboutCompany, logisticLogo, ( CASE WHEN weightDefineUnit ='kg' THEN  (CASE WHEN $weightkg > 0 AND $weightkg <= 5 THEN (price*$qty) WHEN $weightkg >= 6 AND $weightkg <= 10 THEN (price2*$qty) WHEN $weightkg >= 11 AND $weightkg <= 15 THEN (price3*$qty) WHEN $weightkg >= 16 AND $weightkg <= 20 THEN (price6*$qty) WHEN $weightkg >= 21 AND $weightkg <= 25 THEN (price4*$qty) ELSE price5 END ) ELSE  CASE WHEN weightDefineUnit ='lb' THEN  (CASE WHEN $weightPound > 0 AND $weightPound <= 5 THEN (price*$qty) WHEN $weightPound >= 6 AND $weightPound <= 10 THEN (price2*$qty) WHEN $weightPound >= 11 AND $weightPound <= 15 THEN (price3*$qty) WHEN $weightPound >= 16 AND $weightPound <= 20 THEN (price6*$qty) WHEN $weightPound >= 21 AND $weightPound <= 25 THEN (price4*$qty) ELSE price5 END ) END END ) AS price FROM tbl_logistic a INNER JOIN tbl_logistic_zonewise_price b ON a.pkLogisticID = b.logisticPartnerID WHERE {$whereShipping} ) AS tab1 WHERE price >0 ORDER BY price ASC";
            $shippingData = $this->getArrayResult($shippingQuery);
        }
        //pre($shippingData);
        return $shippingData;
    }

    /**
     * function getShippingDetailsForProduct
     *
     * This function is used to get shipping details for package.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getShippingDetailsForProduct2($proID, $argSID, $qty, $smid = 0, $isDom, $arrCustomer) {
        //echo $isDom;
        //echo $proID.'..prod...'.$argSID.'..ship..'.$qty.'...'.$smid.'...'.$isDom.'...'.pre($arrCustomer).'...';

        global $objCore;
        $objShipping = new ShippingPrice();

        $arrRes = $this->getShippingDetails($argSID, $smid, $isDom);
        //pre($arrRes);
        foreach ($arrRes as $key => $val) {
            $Shipping = array('shippingId' => $val['pkShippingGatewaysID'], 'methodId' => $val['Methods'][0]['pkShippingMethod'], 'methodCode' => $val['Methods'][0]['MethodCode']);
            //echo '<pre>';print_r($Shipping);
            $arrPro = $objShipping->getProductDetails($proID, $qty, $Shipping);

            if ($val['ShippingType'] <> '') {

                if ($val['ShippingType'] == 'admin') {
                    $getZoneCountry = $objCore->getZoneCountry();
                    //pre($arrCustomer);
                    foreach ($getZoneCountry as $key => $v) {
                        $zone = explode(',', $v[$key]['Countries']);
                        if (in_array($arrCustomer['countryName'], $zone)) {
                            $arrShippingMethods = $objShipping->AdminShipping($arrPro, $arrCustomer, $val['Methods']);
                            $arrRes[$key]['Methods'] = $arrShippingMethods;
                        }
                    }
                } else {
                    //pre($val);
                    $arrShippingMethods = $objShipping->$val['ShippingAlias']($arrPro, $arrCustomer, $val['Methods']);
                    $arrRes[$key]['Methods'] = $arrShippingMethods;
                }
            } else {
                //$varShippingCost = DEFAULT_SHIPPING_CHARGE;
            }
        }

        foreach ($arrRes as $k => $val) {
            if (!is_array($val['Methods']) || count($val['Methods']) <= 0) {
                unset($arrRes[$k]);
            }
        }

        //echo '<pre>';print_r($val['Methods']);

        return $arrRes;
    }

    /**
     * function updateCart
     *
     * This function is used to add values of cart into database.
     *
     * Database Tables used in this function are : tbl_cart
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string null
     */
    function updateCart() {
        //pre("hello");
        if (isset($_SESSION['MyCart']) && $_SESSION['sessUserInfo']['id'] > 0) {
            //$argWhere = "fkCustomerID = '" . $_SESSION['sessUserInfo']['id'] . "' ";
            //$arrInsertID = $this->delete(TABLE_CART, $argWhere);

            $row = '';
            foreach ($this->myCartDetails() as $ItemType => $cartValues) {
                foreach ($cartValues as $cartVal) {

                    switch ($ItemType) {
                        case 'Product':
                            $row .= '
                                <tr>
                                <td align="center" valign="top"><img src="' . UPLOADED_FILES_URL . 'images/products/85x67/' . ($cartVal['ImageName'] <> '' ? $cartVal['ImageName'] : 'no-image.jpeg') . '" /></td>
                                 <td align="left" valign="top">
                                    <strong onclick="window.location=\'product_view_uil.php?type=view&id=' . $cartVal['pkProductID'] . '\'">' . $cartVal['ProductName'] . '</strong>
                                    <br>(' . $cartVal['attribute'] . ')
                                    <br>By : ' . $cartVal['CompanyName'] . '
                                    <br>' . $ItemType . '
                                  </td>
                                  <td align="center" valign="top">' . $cartVal['ACPrice'] . '</td>
                                  <td align="center" valign="top">' . $cartVal['qty'] . '</td>
                                  <td align="center" valign="top">' . $cartVal['qty'] * $cartVal['FinalPrice'] . '</td>
                                 </tr>
                            ';
                            break;
                        case 'GiftCard':
                            $row .= '
                                <tr>
                                <td align="center" valign="top"><img src="' . UPLOADED_FILES_URL . 'images/products/85x67/no-image.jpeg" /></div>
                                <td align="left" valign="top">
                                    <strong >' . $cartVal['message'] . '</strong>
                                    <br>By : ' . $cartVal['fromName'] . '
                                    <br>' . $ItemType . '
                                  </td>
                                  <td align="center" valign="top">' . $cartVal['amount'] . '</td>
                                  <td align="center" valign="top">' . $cartVal['qty'] . '</td>
                                  <td align="center" valign="top">' . ($cartVal['qty'] * $cartVal['amount']) . '</td>
                                 </tr>
                            ';
                            break;
                        case 'Package':
                            $row .= '
                                <tr>
                                <td align="center" valign="top"><img src="' . UPLOADED_FILES_URL . 'images/products/85x67/' . ($cartVal['PackageImage'] <> '' ? $cartVal['PackageImage'] : 'no-image.jpeg') . '" /></td>
                                 <td align="left" valign="top">
                                    <strong onclick="window.location=\'package_edit_uil.php?type=edit&pkgid=12=' . $cartVal['pkPackageId'] . '\'">' . $cartVal['PackageName'] . '</strong>
                                   <br>(' . $cartVal['productDetail'] . ')
                                    <br>By : ' . $cartVal['CompanyName'] . '
                                    <br>' . $ItemType . '
                                  </td>
                                  <td align="center" valign="top">' . $cartVal['PackageACPrice'] . '</td>
                                  <td align="center" valign="top">' . $cartVal['qty'] . '</td>
                                  <td align="center" valign="top">' . $cartVal['PackagePrice'] . '</td>
                                 </tr>
                            ';
                            break;
                    }
                }
            }
            $arrClms = array('fkCustomerID');
            $argWhere = "fkCustomerID = '" . $_SESSION['sessUserInfo']['id'] . "' ";
            $arrRes = $this->select(TABLE_CART, $arrClms, $argWhere);
            //pre($row);
            $arrClmsAdd = array(
                'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
                'CartDetails' => $row,
                'CartData' => serialize($_SESSION['MyCart']),
                'CartReminderDate' => trim(date(DATE_TIME_FORMAT_DB)),
                'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
            );
            $arrClmsUpdate = array(
                'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
                'CartDetails' => $row,
                'CartData' => serialize($_SESSION['MyCart']),
                'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
            );

            if (count($arrRes) > 0) {
                $argWhere = "fkCustomerID = '" . $_SESSION['sessUserInfo']['id'] . "' ";
                $arrInsertID = $this->update(TABLE_CART, $arrClmsUpdate, $argWhere);
            } else {
                $arrInsertID = $this->insert(TABLE_CART, $arrClmsAdd);
            }
        }
    }

    /**
     * function shippingMethodList
     *
     * This function is used to retrive shippingMethodList.
     *
     * Database Tables used in this function are : tbl_shipping_method
     *
     * @access public
     *
     * @parameters 2 $string(optional), $string(optional)
     *
     * @return array $arrRes
     */
    function shippingMethodList($argWhere = '') {
        $arrClms = array(
            'pkShippingMethod',
            'MethodName',
            'MethodCode',
            'fkShippingGatewayID'
        );
        $varOrderBy = " MethodName ASC";
        $varTable = TABLE_SHIPPING_METHOD;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function productInStock
     *
     * This function is used to check productInStock.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 2 $string(optional), $string(optional)
     *
     * @return array $arrRes
     */
    function productInStock($pid, $qty, $optIds = '', $arrAttr = array()) {

        $arrRow = $this->select(TABLE_PRODUCT, array('pkProductID', 'Quantity'), " pkProductID = '" . $pid . "'");

        if ($optIds <> '') {
            $optIds = $optIds <> '' ? $optIds : trim($_REQUEST['optIds'], ',');
            $arrRows = $this->getStock($pid, $optIds);
            $stock = (int) $arrRows['stock'];
        }

        if ($arrRow[0]['pkProductID'] > 0) {

            if (isset($stock)) {
                $qtyInStock = $stock;
            } else {
                $qtyInStock = $arrRow[0]['Quantity'];
            }

            //pre($_SESSION['MyCart']['Product']);
            $arrCartData = $_SESSION['MyCart']['Product'][$arrRow[0]['pkProductID']];

            $varAddedQty = $qty;

            foreach ($arrCartData as $k => $v) {
                if ($v['attribute'] == $arrAttr) {
                    $varAddedQty += $v['qty'];
                }
            }

            $res = ($varAddedQty > $qtyInStock) ? FALSE : TRUE;
        } else {
            $res = FALSE;
        }
        return $res;
    }

    /**
     * function productInStock
     *
     * This function is used to check productInStock.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 2 $string(optional), $string(optional)
     *
     * @return array $arrRes
     */
    function productInStockApp($pid, $qty, $optIds = '', $arrAttr = array(), $cutId) {

        $arrRow = $this->select(TABLE_PRODUCT, array('pkProductID', 'Quantity'), " pkProductID = '" . $pid . "'");

        if ($optIds <> '') {
            $optIds = $optIds <> '' ? $optIds : trim($_REQUEST['optIds'], ',');
            $arrRows = $this->getStock($pid, $optIds);
            $stock = (int) $arrRows['stock'];
        }

        if ($arrRow[0]['pkProductID'] > 0) {

            if (isset($stock)) {
                $qtyInStock = $stock;
            } else {
                $qtyInStock = $arrRow[0]['Quantity'];
            }

            //pre($_SESSION['MyCart']['Product']);
            //get cart details of the customer
            $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . (int) $cutId . "'");
            //get CartData into serilize format ..Unserialize cart data to use as an array
            $arrCartData1 = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));
            $arrCartData = $arrCartData1['Product'][$arrRow[0]['pkProductID']];
            //$arrCartData = $_SESSION['MyCart']['Product'][$arrRow[0]['pkProductID']];
//print_r($arrAttr);
//print_r($arrCartData);die;
            $varAddedQty = 0;

            foreach ($arrCartData as $k => $v) {
                //print_r($v['attribute']);
                if ($v['attribute'] == $arrAttr) {
                    $varAddedQty = 1;
                }
            }
            $res = ($varAddedQty > 0) ? FALSE : TRUE;
        } else {
            $res = FALSE;
        }

        return $res;
    }

    /**
     * function getStock *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product_option_inventory
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     */
    function getStock($pid, $OptIds) {

        $varWhr = " fkProductID = '" . $pid . "' AND OptionQuantity>0 ";
        $arrTemp = explode(',', $OptIds);
        sort($arrTemp);
        //$varOptIds = implode(',', $arrTemp);        

        foreach ($arrTemp as $val) {
            $varWhr .= ($val <> '') ? " AND FIND_IN_SET('" . $val . "', OptionIDs) " : "";
        }
        $varQuery = "SELECT OptionIDs,OptionQuantity as stock FROM " . TABLE_PRODUCT_OPTION_INVENTORY . " WHERE " . $varWhr;

        $arrRes = $this->getArrayResult($varQuery);

        $qty = 0;
        $arrOpts = array();

        foreach ($arrRes as $v) {
            $qty += $v['stock'];
            $arrOpts[] = $v['OptionIDs'];
        }


        $arrOpts = implode(',', $arrOpts);
        $arrOptions = explode(',', trim($arrOpts, ','));
        $arrOptions = array_unique($arrOptions);


        // $arrOptions = explode(',', trim($arrRes[0]['OptionIDs'], ','));
        // $arrOptions = array_unique($arrOptions);
        $str = implode(',', $arrOptions);

        if ($str <> '') {
            $varWhr = " fkProductId = '" . $pid . "' AND fkAttributeOptionId IN(" . $str . ")";

            $varQuery1 = "SELECT fkAttributeId,fkAttributeOptionId,AttributeInputType FROM " . TABLE_PRODUCT_TO_OPTION . " INNER JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeID WHERE  " . $varWhr;
            $arrRes1 = $this->getArrayResult($varQuery1);
            foreach ($arrRes1 as $v) {
                $arrOpt[$v['fkAttributeOptionId']] = $v;
            }
        }

        $arrRow = array('stock' => $qty, 'opt' => $arrOpt);

        return $arrRow;
    }

    /**
     * function getQuantity *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     */
    function getQuantity($pid) {
        $varQuery = "SELECT Quantity as stock FROM " . TABLE_PRODUCT . " WHERE pkProductID = '" . $pid . "'";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes[0];
    }

    /**
     * function productInStockShoppingPage
     *
     * This function is used to check productInStock.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 2 $string(optional), $string(optional)
     *
     * @return array $arrRes
     */
    function productInStockShoppingPage($pid, $arrPost, $prodIndex) {
        //echo pre($arrPost);
        //echo $pid;die;
        $arrRow = $this->select(TABLE_PRODUCT, array('pkProductID', 'Quantity'), " pkProductID = '" . $pid . "'");

        if (isset($_SESSION['MyCart']['Product'][$pid][$prodIndex]['attribute'])) {
            $stock = $this->getAttributeStock($arrRow[0]['pkProductID'], $_SESSION['MyCart']['Product'][$pid][$prodIndex]['attribute']);
        }

        if ($arrRow[0]['pkProductID'] > 0) {
            $arrCartData = $arrPost['frmProductId'];
            if (isset($stock)) {
                $varQty = $stock;
            } else {
                $varQty = $arrRow[0]['Quantity'];
            }

            $varAddedQty = 0;

            foreach ($arrCartData as $k => $v) {

                if ($v == $pid && $arrPost['frmProductIndex'][$k] == $prodIndex)
                    $varAddedQty += $arrPost['frmProductQuantity'][$k];
            }

            $res = ($varAddedQty > $varQty) ? 0 : 1;
        } else {
            $res = 0;
        }
        //echo $res;exit;
        return $res;
    }

    function removeAllCartDetails($id = 0) {
        $where = "fkCustomerID='" . $id . "'";
        return $this->delete(TABLE_CART, $where);
    }

    function getProductShippingDetails($pId = 0) {
        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,wholesalePrice,FinalPrice,DiscountPrice,DiscountFinalPrice,OfferACPrice,OfferPrice,Quantity,fkShippingID,ProductDescription,ProductImage as ImageName,CategoryName,fkWholesalerID,CompanyName,CompanyCountry
                    FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_PRODUCT_TODAY_OFFER . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_CATEGORY . " ON fkCategoryID = pkCategoryId LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID
                    WHERE pkProductID = '" . $pId . "'";
        $arrRow = $this->getArrayResult($varQuery);
        return $arrRow;
    }

}

?>
