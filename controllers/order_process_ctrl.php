<?php

require_once CLASSES_PATH . 'class_shopping_cart_bll.php';
require_once CLASSES_PATH . 'class_order_process_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

/**
 * Site OrderProcessPageCtrl Class
 *
 * This is the OrderProcessPageCtrl class that will used on Website.
 *
 * DateCreated 5th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class OrderProcessPageCtrl {
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
//        die('43');
        /* Code to detect mobile */
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $ismobile = 0;
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
            $ismobile = 1;
        }
//        print_r($_SESSION);
        /* End of Code to detect mobile */
        if ((!isset($_SESSION['sessUserInfo']['type']) || $_SESSION['sessUserInfo']['type'] <> 'customer') && !($ismobile)) {
            
            header('location:' . SITE_ROOT_URL);
        }
        $objCore = new Core();
       
//pre($_POST);
    }

    /**
     * function pageLoad
     *
     * This function Will be called on each page load and will check for any form submission.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters 0
     *
     * @return string $arrData
     */
    public function pageLoad($CustomerID, $txnID, $paymentAmount, $paymentInfoArry = null, $shippingInfoId = null) {
        //die($CustomerID);
        $objShoppingCart = new ShoppingCart();
        $objOrderProcess = new OrderProcess();
        global $objCore;
        global $objGeneral;
       
         $objGeneral=new General();
// global $objOrderProcess;

        $myCart = $objOrderProcess->getCartDetails($CustomerID);
        $_SESSION['MyCart'] = $myCart;
//pre($_SESSION['MyCart']);
//        pre($_SESSION['MyCart']['arrReward']['singleDeductionAmount']);
        //print_r($paymentInfoArry);
        //Get country and regionId from TBL_ADMIN where  adminemail

        foreach ($paymentInfoArry as $key => $val) {

            $GetAdminEmail[$val->receiver->email] = $objOrderProcess->GetAdminEmail($val->receiver->email);
            //if($val->receiver->email == )
            $GetAdminEmail[$val->receiver->email]['trnsId'] = $val->transactionId;
        }
        //print_r($GetAdminEmail);
        foreach ($GetAdminEmail as $kk => $vv) {
            $newcountry[$vv[0]['AdminCountry']] = $vv['trnsId'];
        }
        //print_r($newcountry);
        if (isset($_SESSION['MyCart'])) {

            $arrCustomerDetails = $objOrderProcess->CustomerDetails($CustomerID);

            if ($_SESSION['RunShippingID'] == 1 || $shippingInfoId == 2) {

                $arrCustomerDetails[0]['ShippingFirstName'] = $arrCustomerDetails[0]['1_ShippingFirstName'];
                $arrCustomerDetails[0]['ShippingLastName'] = $arrCustomerDetails[0]['1_ShippingLastName'];
                $arrCustomerDetails[0]['ShippingOrganizationName'] = $arrCustomerDetails[0]['1_ShippingOrganizationName'];
                $arrCustomerDetails[0]['ShippingAddressLine1'] = $arrCustomerDetails[0]['1_ShippingAddressLine1'];
                $arrCustomerDetails[0]['ShippingAddressLine2'] = $arrCustomerDetails[0]['1_ShippingAddressLine2'];
                $arrCustomerDetails[0]['ShippingCountry'] = $arrCustomerDetails[0]['1_ShippingCountry'];
                $arrCustomerDetails[0]['ShippingPostalCode'] = $arrCustomerDetails[0]['1_ShippingPostalCode'];
                $arrCustomerDetails[0]['ShippingPhone'] = $arrCustomerDetails[0]['1_ShippingPhone'];
            } else if ($_SESSION['RunShippingID'] == 2 || $shippingInfoId == 3) {

                $arrCustomerDetails[0]['ShippingFirstName'] = $arrCustomerDetails[0]['2_ShippingFirstName'];
                $arrCustomerDetails[0]['ShippingLastName'] = $arrCustomerDetails[0]['2_ShippingLastName'];
                $arrCustomerDetails[0]['ShippingOrganizationName'] = $arrCustomerDetails[0]['2_ShippingOrganizationName'];
                $arrCustomerDetails[0]['ShippingAddressLine1'] = $arrCustomerDetails[0]['2_ShippingAddressLine1'];
                $arrCustomerDetails[0]['ShippingAddressLine2'] = $arrCustomerDetails[0]['2_ShippingAddressLine2'];
                $arrCustomerDetails[0]['ShippingCountry'] = $arrCustomerDetails[0]['2_ShippingCountry'];
                $arrCustomerDetails[0]['ShippingPostalCode'] = $arrCustomerDetails[0]['2_ShippingPostalCode'];
                $arrCustomerDetails[0]['ShippingPhone'] = $arrCustomerDetails[0]['2_ShippingPhone'];
            } else {

                $arrCustomerDetails[0]['ShippingFirstName'] = $arrCustomerDetails[0]['ShippingFirstName'];
                $arrCustomerDetails[0]['ShippingLastName'] = $arrCustomerDetails[0]['ShippingLastName'];
                $arrCustomerDetails[0]['ShippingOrganizationName'] = $arrCustomerDetails[0]['ShippingOrganizationName'];
                $arrCustomerDetails[0]['ShippingAddressLine1'] = $arrCustomerDetails[0]['ShippingAddressLine1'];
                $arrCustomerDetails[0]['ShippingAddressLine2'] = $arrCustomerDetails[0]['ShippingAddressLine2'];
                $arrCustomerDetails[0]['ShippingCountry'] = $arrCustomerDetails[0]['ShippingCountry'];
                $arrCustomerDetails[0]['ShippingPostalCode'] = $arrCustomerDetails[0]['ShippingPostalCode'];
                $arrCustomerDetails[0]['ShippingPhone'] = $arrCustomerDetails[0]['ShippingPhone'];
            }
            $varOrderID = $objOrderProcess->addOrder($arrCustomerDetails[0], $txnID, $paymentAmount);

            if ($varOrderID > 0) {

// for Order comment
                if ($_SESSION['MyCart']['OrderComment']) {
                    $arrCommentCols = array(
                        'fkOrderID' => $varOrderID,
                        'CommentedBy' => 'customer',
                        'CommentedID' => $CustomerID,
                        'Comment' => $_SESSION['MyCart']['OrderComment'],
                        'CommentDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                    );
                    $objOrderProcess->addOrderComment($arrCommentCols);
                }


                $this->arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
             //   pre($this->arrData['arrCartDetails']);
// for product
                if ($_SESSION['MyCart']['Product']) {
                    foreach ($this->arrData['arrCartDetails']['Product'] as $key => $val) {

                        $varQty = $val['qty'];
                        $varShippCost = $val['AppliedShipping']['ShippingCost'];
                        $varShippingid = $val['AppliedShipping']['ShippingId'];

                        $varSubTotal = ($val['FinalPrice'] * $varQty) + $varShippCost - $val['Discount'];


                        $arrItemDetails = array(
                            '0' => array(
                                'pkProductID' => $val['pkProductID'],
                                'ProductRefNo' => $val['ProductRefNo'],
                                'ProductName' => $val['ProductName']
                            )
                        );

                        $jsonItemDetails = json_encode($arrItemDetails);
                        $varSubOrderID = $varOrderID . '-' . $val['fkWholesalerID']; // use str_pad to fixed integer val

                        $countryId = $objOrderProcess->GetWhCountry($val['fkWholesalerID']);
                        //pre($countryId);
                        $wholesalercountryportalid= $objOrderProcess->wholesalercountryportalfront($countryId['CompanyCountry']);
                        $portalid=$wholesalercountryportalid[0]['pkAdminID'];
                       
                        $gatwaymailid=$objOrderProcess->getwaymailidusingportalfront($portalid,$varShippingid);
                         $portalmail=$gatwaymailid[0]['gatewayEmail'];
                         
                         $gatwaynamearray=$objGeneral->getshippingcompanyname($varShippingid);
                                    	$gatwayname= $gatwaynamearray[0]['ShippingTitle'];
                         // pre($gatwayname);
                       // pre($countryId.$portalid.$portalmail);
                         $this->logisticmailfunctiona($varOrderID,$portalmail,$gatwayname,$val['fkWholesalerID']);
                        foreach ($newcountry as $cid => $tid) {
                            if ($cid == $countryId['CompanyCountry']) {
                                $transID = $tid;
                            }
                        }
                        //print_r($newcountry);
                        //echo $transID;
                        $arrProductCols = array(
                            'fkOrderID' => $varOrderID,
                            'SubOrderID' => $varSubOrderID,
                            'ItemType' => 'product',
                            'fkItemID' => $val['pkProductID'],
                            'ItemName' => $val['ProductName'],
                            'ItemImage' => $val['ImageName'],
                            'fkWholesalerID' => $val['fkWholesalerID'],
                            'fkShippingIDs' => $val['AppliedShipping']['ShippingId'],
                            'fkMethodID' => $val['AppliedShipping']['MethodId'],
                            'PriceCategory' => $val['PriceCategory'],
                            'ItemACPrice' => $val['ACPrice'],
                            'ItemPrice' => $val['ItemPrice'],
                            'Weight' => $val['Weight'],
                            'WeightUnit' => $val['WeightUnit'],
                             'Length' => $val['Length'],
                        	 'Width' => $val['Width'],
                        	  'Height' => $val['Height'],
                        	 'DimensionUnit' => $val['DimensionUnit'],
                            'Quantity' => $varQty,
                            'SingleDeductionValue' => $_SESSION['MyCart']['arrReward']['singleDeductionAmount'],
                            'ItemSubTotal' => $val['ItemPrice'] * $varQty,
                            'AttributePrice' => $val['attributePrice'] * $varQty,
                            'ShippingPrice' => $varShippCost,
                            'DiscountPrice' => $val['Discount'],
                            'ItemTotalPrice' => $varSubTotal,
                            'ItemDetails' => $jsonItemDetails,
                            'Status' => 'Pending',
                            'transaction_ID' => $transID,
                            'ItemDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                        );

                        $arrOptions = $_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['attribute'];

                        $varOrderItemID = $objOrderProcess->addOrderItems($arrProductCols, $arrOptions);


                        $arrlogisticCols = array(
                            'fkOrderID' => $varOrderID,
                            'fkOrderitemID' => $varOrderItemID,
                            'fkSubOrderID' => $varSubOrderID,
                            'fkWholesalerID' => $val['fkWholesalerID'],
                            'CustomerID' => $CustomerID,
                            'fkShippingGatewaysID' => $val['AppliedShipping']['ShippingId'],
                            'shippingAmount' => $varShippCost,
                            'Status' => 'Pending',
                            'shippingDate' => '',
                            'customerfullname' => $arrCustomerDetails[0]['CustomerFirstName'] . ' ' . $arrCustomerDetails[0]['CustomerLastName'],
                            'InvoiceFileName' => '',
                            //'ProductFinalPrice' => $val['FinalPrice'],
                            'AdminMarginProduct' => $val['AdminMarginProduct'],
                            'AdminCommissionProduct' => $val['AdminCommissionProduct'],
                            'AdminPortalID' => $val['CompanyCountry'],
                            'OrderDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                        );
                        $varlogistic = $objOrderProcess->addlogisticinvoice($arrlogisticCols, $arrOptions);


                        if ($arrOptions) {
                            foreach ($arrOptions as $OPTk => $OPTv) {
                                $arrAtt = explode(':', $OPTv);

                                $arrAttributeDetails = $objOrderProcess->attributeDetails($arrAtt[0]);



                                if ($arrAttributeDetails[0]['AttributeInputType'] == 'radio' || $arrAttributeDetails[0]['AttributeInputType'] == 'select' || $arrAttributeDetails[0]['AttributeInputType'] == 'image' || $arrAttributeDetails[0]['AttributeInputType'] == 'image' || $arrAttributeDetails[0]['AttributeInputType'] == 'checkbox') {

                                    $arrAttributeOptDetails = $objOrderProcess->attributeOptDetails($val['pkProductID'], $arrAtt[1]);
                                    $OptionValue = $arrAttributeOptDetails[0]['OptionValue'];
                                    $OptionPrice = $arrAttributeOptDetails[0]['OptionExtraPrice'];
                                } else {
                                    $OptionValue = $arrAtt[2];
                                    $OptionPrice = 0;
                                }

                                $arrOptionCols = array(
                                    'fkOrderItemID' => $varOrderItemID,
                                    'fkProductID' => $val['pkProductID'],
                                    'fkAttributeID' => $arrAttributeDetails['0']['pkAttributeID'],
                                    'AttributeLabel' => $arrAttributeDetails['0']['AttributeLabel'],
                                    'OptionValue' => $OptionValue,
                                    'OptionPrice' => $OptionPrice
                                );

                                $objOrderProcess->addOrderOption($arrOptionCols);
                            }
                        }
                    }
                }


// for package
                if ($_SESSION['MyCart']['Package']) {

                    foreach ($this->arrData['arrCartDetails']['Package'] as $key => $val) {

                        $varQt = $val['qty'];
                        $varShippingCost = $val['AppliedShipping']['ShippingCost'];

                        $varSubTotal = ($val['PackagePrice'] * $varQt) + $varShippingCost;

                        $varPIDS = implode(',', array_keys($val['product']));

                        $arrProductDetails = $objOrderProcess->productDetails($varPIDS);


                        $jsonItemDetails = json_encode($arrProductDetails);

                        /*
                          $arrShippingIDs = array();
                          foreach ($arrProductDetails as $a => $b) {
                          $arrShippingIDs[] = $b['fkShippingID'];
                          }

                          $fkShippingIDs = implode(',', $arrShippingIDs);
                         */

                        $varSubOrderID = $varOrderID . '-' . $val['fkWholesalerID']; // use str_pad to fixed integer val

                        $arrPackageCols = array(
                            'fkOrderID' => $varOrderID,
                            'SubOrderID' => $varSubOrderID,
                            'ItemType' => 'package',
                            'fkItemID' => $val['pkPackageId'],
                            'ItemName' => $val['PackageName'],
                            'ItemImage' => $val['PackageImage'],
                            'fkWholesalerID' => $val['fkWholesalerID'],
                            'fkShippingIDs' => $val['AppliedShipping']['ShippingId'],
                            'fkMethodID' => $val['AppliedShipping']['MethodId'],
                            'PriceCategory' => 'Price',
                            'ItemACPrice' => $val['PackageACPrice'],
                            'ItemPrice' => $val['PackagePrice'],
                            'Quantity' => $varQt,
                            'ItemSubTotal' => $val['PackagePrice'] * $varQt,
                            'ShippingPrice' => $varShippingCost,
                            'ItemTotalPrice' => $varSubTotal,
                            'ItemDetails' => $jsonItemDetails,
                            'Status' => 'Pending',
                            'ItemDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                        );

                        $varOrderItemID = $objOrderProcess->addOrderItems($arrPackageCols, $val['product']);

                        foreach ($val['product'] AS $prodId => $arrAttribute) {


                            if ($arrAttribute) {
                                foreach ($arrAttribute as $OPTk => $OPTv) {
                                    $arrAtt = explode(':', $OPTv);


                                    $arrAttributeDetails = $objOrderProcess->attributeDetails($arrAtt[0]);

                                    if ($arrAttributeDetails[0]['AttributeInputType'] == 'radio' || $arrAttributeDetails[0]['AttributeInputType'] == 'select' || $arrAttributeDetails[0]['AttributeInputType'] == 'image' || $arrAttributeDetails[0]['AttributeInputType'] == 'checkbox') {

                                        $arrAttributeOptDetails = $objOrderProcess->attributeOptDetails($prodId, $arrAtt[1]);
                                        $OptionValue = $arrAttributeOptDetails[0]['OptionValue'];
                                    } else {
                                        $OptionValue = $arrAtt[2];
                                    }

                                    $arrOptionCols = array(
                                        'fkOrderItemID' => $varOrderItemID,
                                        'fkProductID' => $prodId,
                                        'fkAttributeID' => $arrAttributeDetails['0']['pkAttributeID'],
                                        'AttributeLabel' => $arrAttributeDetails['0']['AttributeLabel'],
                                        'OptionValue' => $OptionValue
                                    );

                                    $objOrderProcess->addOrderOption($arrOptionCols);
                                }
                            }
                        }
                    }
                }



// for Add to gift Cart
                if ($_SESSION['MyCart']['GiftCard']) {
                    foreach ($_SESSION['MyCart']['GiftCard'] as $key => $val) {

                        $varSubTotal = $val['amount'] * $val['qty'];

                        $arrGiftCardCols = array(
                            'GiftCardCode' => '',
                            'NameFrom' => $val['fromName'],
                            'EmailFrom' => $arrCustomerDetails[0]['CustomerEmail'],
                            'NameTo' => $val['toName'],
                            'EmailTo' => $val['toEmail'],
                            'Message' => $val['message'],
                            'Amount' => $val['amount'],
                            'Quantity' => $val['qty'],
                            'TotalAmount' => $varSubTotal,
                            'BalanceAmount' => $varSubTotal,
                            'GiftCardDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                        );

                        $varGiftCardID = $objOrderProcess->addGiftCard($arrGiftCardCols, $val['mailDeliveryDate']);

                        $arrGiftCardDetails = array(
                            'NameFrom' => $val['fromName'],
                            'NameTo' => $val['toName'],
                            'EmailTo' => $val['toEmail'],
                            'Message' => $val['message'],
                        );

                        $jsonItemDetails = json_encode($arrGiftCardDetails);
                        $varSubOrderID = $varOrderID . '-' . '0'; // use str_pad to fixed integer val

                        $arrGiftOrderCols = array(
                            'fkOrderID' => $varOrderID,
                            'SubOrderID' => $varSubOrderID,
                            'ItemType' => 'gift-card',
                            'fkItemID' => $varGiftCardID,
                            'ItemName' => $val['toName'],
                            'ItemImage' => '',
                            'PriceCategory' => 'Price',
                            'ItemACPrice' => $val['amount'],
                            'ItemPrice' => $val['amount'],
                            'Quantity' => $val['qty'],
                            'ItemSubTotal' => $val['amount'] * $val['qty'],
                            'ItemTotalPrice' => $varSubTotal,
                            'ItemDetails' => $jsonItemDetails,
                            'Status' => 'Completed',
                            'ItemDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                        );

                        $objOrderProcess->addOrderItems($arrGiftOrderCols);
                    }
                }

                $arrTotal = $objOrderProcess->orderTotal($varOrderID);
                //pre($arrTotal);


                if (isset($_SESSION['MyCart']['Product']) || isset($_SESSION['MyCart']['Package'])) {

// for Sub total

                    $arrSubtotalCols = array('fkOrderID' => $varOrderID, 'Code' => 'sub-total', 'Title' => 'Sub Total', 'Amount' => $arrTotal['sub-total'], 'SortOrder' => '1');
                    $objOrderProcess->addOrderTotal($arrSubtotalCols);


// for Shipping total

                    $arrShippingCols = array('fkOrderID' => $varOrderID, 'Code' => 'shipping', 'Title' => 'Shipping Charge', 'Amount' => $arrTotal['shipping'], 'SortOrder' => '2');
                    $objOrderProcess->addOrderTotal($arrShippingCols);
                }


                // for Discount coupon

                if (isset($_SESSION['MyCart']['CouponCode'])) {
                    $arrCouponCols = array('fkOrderID' => $varOrderID, 'Code' => 'coupon', 'Title' => 'Discount Coupon(' . $_SESSION['MyCart']['CouponCode'] . ')', 'Amount' => '-' . $arrTotal['coupon'], 'SortOrder' => '3');
                    $objOrderProcess->addOrderTotal($arrCouponCols);
                }

                $varGrantTotalPrice = $arrTotal['sub-total'] + $arrTotal['shipping'] - $arrTotal['coupon'];



                // for Redeem Gift card

                if (isset($_SESSION['MyCart']['GiftCardCode']) && $_SESSION['MyCart']['GiftCardCode'][0] <> '') {


                    $varGiftCardCode = $_SESSION['MyCart']['GiftCardCode'][0];
                    $varGiftCardPrice = $_SESSION['MyCart']['GiftCardCode'][2];

                    $arrGiftCard = $objOrderProcess->getGiftCartByCode($varGiftCardCode);
                    if (count($arrGiftCard) > 0) {
                        /*
                          if ($arrGiftCard['BalanceAmount'] >= $varGrantTotalPrice) {
                          $varBalanceAmount = $arrGiftCard['BalanceAmount'] - $varGrantTotalPrice;
                          $varGiftCardPrice = $varGrantTotalPrice;
                          } else {
                          $varBalanceAmount = 0;
                          $varGiftCardPrice = $arrGiftCard['BalanceAmount'];
                          } */

                        $varBalanceAmount = $_SESSION['MyCart']['GiftCardCode'][1] - $_SESSION['MyCart']['GiftCardCode'][2];
                        $varGiftCardPrice = $_SESSION['MyCart']['GiftCardCode'][2];

                        $varGrantTotalPrice -= $varGiftCardPrice;



                        $arrGiftCartCols = array('fkOrderID' => $varOrderID, 'Code' => 'gift-card', 'Title' => 'Gift Card(' . $varGiftCardCode . ')', 'Amount' => '-' . $varGiftCardPrice, 'SortOrder' => '4');
                        $objOrderProcess->addOrderTotal($arrGiftCartCols);
                        $arrUpCols = array('BalanceAmount' => $varBalanceAmount);
                        $objOrderProcess->updateGiftCart($arrUpCols, $varGiftCardCode);
                    }
                }

                // for Redeem Rewards points

                if (isset($_SESSION['MyCart']['arrReward']) && $_SESSION['MyCart']['arrReward']['RewardValue'] > 0) {

                    $varRewardPoints = $_SESSION['MyCart']['arrReward']['RewardPoints'];
                    $varRewardValue = $_SESSION['MyCart']['arrReward']['RewardValue'];

                    $varGrantTotalPrice -= $varRewardValue;
                    $arrGiftCartCols = array('fkOrderID' => $varOrderID, 'Code' => 'reward-points', 'Title' => 'Reward Points(' . $varRewardPoints . ')', 'Amount' => '-' . $varRewardValue, 'SortOrder' => '5');
                    $objOrderProcess->addOrderTotal($arrGiftCartCols);
                    $objGeneral->addRewards($CustomerID, 'Redeem Rewards on order', $varRewardPoints, 'debit');
                }

// no of days


                $arrTotalCols = array('fkOrderID' => $varOrderID, 'Code' => 'total', 'Title' => 'Total', 'Amount' => $varGrantTotalPrice, 'SortOrder' => '6');
                $objOrderProcess->addOrderTotal($arrTotalCols);


                //           $objGeneral->addRewards($CustomerID, 'Place an order', (int) $arrTotal['OrderTotalPoints']);
                if (isset($_SESSION['MyCart']['arrReward']) && $_SESSION['MyCart']['arrReward']['RewardValue'] > 0) {

                    $varRewardPoints = $_SESSION['MyCart']['arrReward']['RewardPoints'];
                    $varRewardValue = $_SESSION['MyCart']['arrReward']['RewardValue'];
                } else {

                    $varRewardValue = 0;
                }

//                 $arrTotal = $objOrderProcess->orderTotal($varOrderID);

                $sub_total = $arrTotal['sub-total'];
                $objGeneral->addRewards($CustomerID, 'Place an order', (int) ($sub_total - $varRewardValue), '', '', $varOrderID);

                $products = $_SESSION['MyCart']['Product'];

                if (is_array($products)) {

                    foreach ($products as $key => $productsValues) {

                        $getProductDetails = $objOrderProcess->productDetailsWithId($key);

                        if (is_array($getProductDetails)) {

//pre($getProductDetails);

                            foreach ($getProductDetails as $key => $getProductDetailsValues) {

                                if ($getProductDetailsValues['Quantity'] <= $getProductDetailsValues['QuantityAlert']) {

                                    $this->quantityNotificationToWholeSaler($getProductDetailsValues['fkWholesalerID'], $getProductDetailsValues['ProductName'], $getProductDetailsValues['Quantity'], $getProductDetailsValues['ProductImage']);
                                }
                            }
                        }
                    }
                }

//pre($_SESSION['MyCart']);
                //$objGeneral->addRewards($CustomerID, 'RewardOnOrder');

                $this->sendGiftCardNotifyToRecipient($varOrderID);
                $this->orderEmailNotification($varOrderID);


//exit;
                $objOrderProcess->deleteFromCart($CustomerID);
                unset($_SESSION['MyCart']);
                $objOrderProcess->deleteCartDetails($CustomerID);
//header('location:' . SITE_ROOT_URL . 'payment_success.php');
// end of page load
            } /* else {
              header('location:' . SITE_ROOT_URL);
              } */
        }
    }

    /**
     * function orderEmailNotification
     *
     * This function Will be called on order Email Notification.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $varOrderID
     *
     * @return none
     */
    function orderEmailNotification($varOrderID) {
        $objOrderProcess = new OrderProcess();
        $arrOrderDetail = $objOrderProcess->GetOrderDetails($varOrderID);

        $this->SentEmailToCustomer($arrOrderDetail[0]);
        $this->SentEmailToWholesaler($arrOrderDetail[0]);
         //$this->SentEmailToLogisticcompany($arrOrderDetail[0]);
        $this->SentEmailToCountryPortal($arrOrderDetail[0]);
        $this->SentEmailToSuperAdmin($arrOrderDetail[0]);
//exit;
    }
    function logisticmailfunctiona($varOrderID,$portalmail,$gatwayname,$wholesalerid)
    {
        //pre($varOrderID);
        $objOrderProcess = new OrderProcess();
        $arrOrderDetail = $objOrderProcess->GetOrderDetails($varOrderID);
       $this->SentEmailToLogisticcompany($arrOrderDetail[0],$portalmail,$gatwayname,$wholesalerid); 
    }

    /**
     * function SentEmailToCustomer
     *
     * This function Will be called on Sent Email To Customer.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SentEmailToCustomer($arrOrderDetail) {
        global $objCore;
        global $arrProductImageResizes;
        $objOrderProcess = new OrderProcess();
        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";
        $arrOrderItems = $objOrderProcess->GetItemDetails($varWhr);

        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";
        $arrOrderItemTotal = $objOrderProcess->GetTotalDetails($varWhr);
        $arrOrderComments = $objOrderProcess->getOrderComments($varWhr);

        $varCustomerName = $arrOrderDetail['CustomerFirstName'] . ' ' . $arrOrderDetail['CustomerLastName'];

        $varCustomerEmail = $arrOrderDetail['CustomerEmail'];

        $varEmailOrderDetails = '<table width="622" cellspacing="0" cellpadding="5" border="0" align="center"><tr><td style="font:700 17px arial;">Congrats ' . $varCustomerName . ',</td></tr><tr><td height="50" style="font:400 15px/17px arial;">Here is the summary of your order. You can also find your order details in <a href="' . SITE_ROOT_URL . 'my_orders.php" style="color:#ff0000"><b>My Orders</b></a> when you log into your Telamela account.</td></tr></table>';

        $varEmailOrderDetails .= '<table width="622" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#fff" style="background:white; border:3px solid #ffb422; -webkit-border-radius:3px;-moz-border-radius:3px;-ms-border-radius:3px;-o-border-radius:3px;border-radius:3px;">
                        <tr>
                            <td width="20"></td>
                            <td width="278" style="">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top:32px; border:1px solid #d8d8d8;">
                                    <tr>
                                        <th width="45" align="left" bgcolor="#e43137"><img src="' . IMAGES_URL . 'red-corner-info.png" alt=""></th>
                                        <th bgcolor="#e43137" width="233" align="left" style="font-size:17px;"><font color="#fff" face="Arial">Account Information</font></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table cellpadding="0" cellspacing="0" border="0" style="margin:15px 0;">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Your Name</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $varCustomerName . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Your Email</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial"><a href="mailto:' . $varCustomerEmail . '">' . $varCustomerEmail . '</a></font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Mobile</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['CustomerPhone'] . '</font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="20"></td>
                            
                        </tr>
                        <tr>
                            <td colspan="5" height="28">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="20"></td>
                            <td width="278" style="border:1px solid #d8d8d8;">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <th width="45" align="left" bgcolor="#006feb"><img src="' . IMAGES_URL . 'blue-corner-info.png" alt=""></th>
                                        <th bgcolor="#006feb" width="233" align="left" style="font-size:17px;"><font color="#fff" face="Arial">Billing Information</font></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table cellpadding="0" cellspacing="0" border="0" style="margin:15px 0;">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Your Name</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['BillingFirstName'] . ' ' . $arrOrderDetail['BillingLastName'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Address</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['BillingAddressLine1'] . ' ' . $arrOrderDetail['BillingAddressLine2'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Country</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['BillingCountryName'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Postal Code</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['BillingPostalCode'] . '</font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="20"></td>
                            <td width="278" style="border:1px solid #d8d8d8;">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <th width="45" align="left" bgcolor="#362223"><img src="' . IMAGES_URL . 'gray-corner-info.png" alt=""></th>
                                        <th bgcolor="#362223" width="233" align="left" style="font-size:17px;"><font color="#fff" face="Arial">Shipping Information</font></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table cellpadding="0" cellspacing="0" border="0" style="margin:15px 0;">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Your Name</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['ShippingFirstName'] . ' ' . $arrOrderDetail['ShippingLastName'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Address</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['ShippingAddressLine1'] . ' ' . $arrOrderDetail['ShippingAddressLine2'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Country</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['ShipingCountryName'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Postal Code</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['ShippingPostalCode'] . '</font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="20"></td>
                        </tr>
                        <tr>
                            <td colspan="5" height="28">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <th width="104" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Sub Order Id</font></th>
                                        <th width="117" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Items Ordered</font></th>
                                        <th width="113" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Item Image</font></th>
                                        <th width="53" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Price</font></th>
                                        <th width="37" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Qty.</font></th>
                                        <th width="68" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Shipping</font></th>
                                        <th width="66" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Discount</font></th>
                                        <th width="64" bgcolor="#fa990e" height="43" style="font-size:11px;"><font color="#fff" face="Arial" size="2">Total</font></th>
                                    </tr>';



        foreach ($arrOrderItems as $k => $v) {
            if ($v['ItemType'] == 'product') {
                $path = 'products/' . $arrProductImageResizes['default'];
            } else if ($v['ItemType'] == 'package') {
                $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
            } else {
                $path = 'gift_card';
            }

            $varSrc = $objCore->getImageUrl($v['ItemImage'], $path);

            $bgcolor = $k % 2 == 0 ? '#ffe7b9' : '#fffcf5';
            $ItemPrice = $v['ItemPrice'] + ($v['AttributePrice'] / $v['Quantity']);

            $varEmailOrderDetails .='<tr>
                                        <td width="104" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ucwords($v['SubOrderID']) . '</font></td>
                                        <td width="117" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial"><strong style="font-size:13px;">' . $v['ItemName'] . '</strong><br />' . $v['OptionDet'] . '</font></td>
                                        <td width="113" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial"><img src="' . $varSrc . '" alt="' . $v['ItemName'] . '" /></font></td>
                                        <td width="53" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format($ItemPrice, 2) . '</font></td>
                                        <td width="37" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . $v['Quantity'] . '</font></td>
                                        <td width="68" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format($v['ShippingPrice'], 2) . '</font></td>
                                        <td width="66" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format(-$v['DiscountPrice'], 2) . '</font></td>
                                        <td width="64" bgcolor="' . $bgcolor . '" height="80" align="center" style="font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format($v['ItemTotalPrice'], 2) . '</font></td>
                                    </tr>';
        }

        $varEmailOrderDetails .= '<tr>
                                        <td colspan="8">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom:52px;">
                                                <tr>
                                                    <td height="50" colspan="5">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td width="20" height="118">&nbsp;</td>
                                                    <td width="278" align="left" valign="top" bgcolor="#fff3e0" style="border:1px solid #cac7c8;" height="118">
                                                        <table cellpadding="0" cellspacing="0" align="center" border="0" width="86%; height:118px; ">
                                                            <tr>
                                                                <td style="margin:0;padding:10px 0 3px 13px;font-size:17px;color:#000;font-family:arial;font-weight:normal;">Comment History</td>
                                                            </tr>';

        $varEmailOrderDetails .='<tr><td style="margin:0;padding:13px;color:#000;font-family:arial;font-weight:normal;font-size:13px;background:#ffffff;">';

        foreach ($arrOrderComments as $key => $val) {
            $varEmailOrderDetails .= '<br/>' . $val['Comment'] . '<br /><p style = "font-weight: bold;text-align: right;font-size:14px;">' . $val[$val['CommentedBy'] . 'Name'] . ' (' . ucwords($val['CommentedBy']) . ')</p>';
        }


        $varEmailOrderDetails .= '</td></tr></table></td>
                                                    <td width="20" height="118">&nbsp;</td>
                                                    <td width="278" height="118" align="left" valign="top" bgcolor="#fff3e0" style="border:1px solid #cac7c8;padding: 0;">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="80%" align="center" height="118">
                                                        <tr><td align="left"><font color="#222" face="Arial" style="font-size:14px;">&nbsp;</font></td><td align="right"><font color="#222" face="Arial" style="font-size:14px;">&nbsp;</font></td></tr>';


        foreach ($arrOrderItemTotal as $val) {

            if ($val['Code'] <> 'total') {
                $varEmailOrderDetails .= '<tr><td height="30" align="left" ><font color="#222" face="Arial" style="font-size:14px;">' . $val['Title'] . '</font></td><td height="30" align="right"><font color="#222" face="Arial" style="font-size:14px;">' . ADMIN_CURRENCY_SYMBOL . number_format($val['Amount'], 2) . '</font></td></tr>';
            } else {
                $varEmailOrderDetails .= '<tr><td align="left"><font color="#222" face="Arial" style="font-size:14px;">&nbsp;</font></td><td align="right"><font color="#222" face="Arial" style="font-size:14px;">&nbsp;</font></td></tr><tr><td colspan="2" style="border-top:1px dashed #000;" height="20"></td></tr><tr><td height="50" valign="top" !important align="left"><font color="#222" face="Arial" style="font-size:18px;">' . GRAND_TOTAL . '</font></td><td height="50" align="right" valign="top"><font color="#fa990e" face="Arial" style="font-size:18px;">' . ADMIN_CURRENCY_SYMBOL . number_format($val['Amount'], 2) . '</font></td></tr>';
            }
        }

        $varEmailOrderDetails .= '</table></td><td width="20" height="118">&nbsp;</td></tr></table></td></tr></table></td></tr></table>';

        $varFrom = SITE_EMAIL_ADDRESS;
        $varSubject = ORDER_DETAILS;
        $varHeading = 'Order Confirmation';
        // $EmailTemplates = '';//$this->SentEmailTemplates();
        //$varKeyword = array('{CSS}', '{HEADING}', '{EMAIL}', '{EMAILDETAILS}');
        //$varKeywordValues = array($varCSS, $varHeading, $varCustomerName, $varEmailOrderDetails);
		//$varCustomerEmail = 'antima.gupta@planetwebsolution.com' ;
        $varEmailMessage = $varEmailOrderDetails; //str_replace($varKeyword, $varKeywordValues, $EmailTemplates);
        //$varCustomerEmail='avinesh.mathur@planetwebsolution.com';
// Calling mail function
        $objCore->sendMail($varCustomerEmail, $varFrom, $varSubject, $varEmailMessage);
    }

    /**
     * function quantityNotificationToWholeSaler
     *
     * This function Will be called on Sent Email To Wholesaler for quantity less then aleart quantityField.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function quantityNotificationToWholeSaler($wholesalerID = '', $productName = '', $quantity = '', $productImage = '') {

        global $objCore;

        $objOrderProcess = new OrderProcess();

        $varCSS = '';
        $varEmailOrderDetails = '';
        $varEmailOrderDetails.= '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>' . QUANTITY_NOTIFICATION . ': </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';

        $arrWholesalerDetails = $objOrderProcess->GetWholesalerDetailsWithId($wholesalerID);

        $EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{CSS}', '{HEADING}', '{EMAIL}', '{EMAILDETAILS}');
        $varSubject = QUANTITY_NOTIFICATION_SUBJECT;
        $varHeading = '';
        $varFrom = SITE_NAME;

        $varEmailOrderDetails = '<link rel="stylesheet" type="text/css" href="' . SITE_ROOT_URL . '/common/css/layout.css"/><link rel="stylesheet" type="text/css" href="' . SITE_ROOT_URL . '/common/css/layout1.css"/>';
        $varEmailOrderDetails .= '<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td>Here is the summary of your order. You can also find your order details in <a href="' . SITE_ROOT_URL . 'my_orders.php">My Orders</a> when you log into your Telamela account.</td></tr></table>';
        $varEmailOrderDetails .= '
    <div class="add_edit_pakage order_details">
        <div class="boxes1">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th align="center">' . ITEM . '</th>
                    <th align="center" class="last">' . QUANTITY . '</th>
                </tr>';

        $varEmailOrderDetails .='
                    <tr>
                        <td align="center" class="border_left"><b>' . $productName . '</b></td>
                        <td align="center" class="last">' . $quantity . '</td>
                    </tr>';

        $varEmailOrderDetails .='</table>
            <div class="last_box"></div></div></div>';


        $varName = $arrWholesalerDetails[0]['CompanyName'];
        $varEmail = $arrWholesalerDetails[0]['CompanyEmail'];

        $varKeywordValues = array($varCSS, $varHeading, $varName, $varEmailOrderDetails);
        $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

// Calling mail function
        $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
    }

    /**
     * function SentEmailToWholesaler
     *
     * This function Will be called on Sent Email To Wholesaler.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SentEmailToWholesaler($arrOrderDetail) {

        global $objCore;
        global $objGeneral;
        global $arrProductImageResizes;
         $objGeneral=new General();

        $objOrderProcess = new OrderProcess();

        $arrWholesalerDetails = $objOrderProcess->GetWholesalerDetails($arrOrderDetail['pkOrderID']);
        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";
        $arrOrderComments = $objOrderProcess->getOrderComments($varWhr);

        //$EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{EMAIL}');
        $varSubject = $varSubject = ORDER_DETAILS;
        $varHeading = '';
        $varFrom = SITE_NAME;

        $varEmailOrderDetails = '<table width="622" cellspacing="0" cellpadding="5" border="0" align="center"><tr><td style="font:700 17px arial;">Congrats {EMAIL},</td></tr><tr><td height="50" style="font:400 15px/17px arial;">' . PLACE_ORDER . '</td></tr></table>';
        $varEmailOrderDetails .= '<table width="622" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#fff" style="border:3px solid #ffb422;-webkit-border-radius:3px;-moz-border-radius:3px;-ms-border-radius:3px;-o-border-radius:3px;border-radius:3px;padding-top:32px;padding-bottom:52px;">
                        <tr>
                            <td width="20"></td>
                            <td width="278" style="border:1px solid #d8d8d8;">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <th width="45" align="left" bgcolor="#e43137"><img src="' . IMAGES_URL . 'red-corner-info.png" alt=""></th>
                                        <th bgcolor="#e43137" width="233" align="left" style="font-size:17px;"><font color="#fff" face="Arial">Account Information</font></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table cellpadding="0" cellspacing="0" border="0" style="margin:15px 0;">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Name</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['CustomerFirstName'] . ' ' . $arrOrderDetail['CustomerLastName'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Email</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial"><a href="mailto:' . $arrOrderDetail['CustomerEmail'] . '">' . $arrOrderDetail['CustomerEmail'] . '</a></font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Mobile</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['CustomerPhone'] . '</font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="20"></td>
                            <td width="278">&nbsp;</td>
                            <td width="20"></td>
                        </tr>
                        <tr>
                            <td colspan="5" height="28">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="20"></td>
                            <td width="278" style="border:1px solid #d8d8d8;">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <th width="45" align="left" bgcolor="#006feb"><img src="' . IMAGES_URL . 'blue-corner-info.png" alt=""></th>
                                        <th bgcolor="#006feb" width="233" align="left" style="font-size:17px;"><font color="#fff" face="Arial">Billing Information</font></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table cellpadding="0" cellspacing="0" border="0" style="margin:15px 0;">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Name</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['BillingFirstName'] . ' ' . $arrOrderDetail['BillingLastName'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Address</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['BillingAddressLine1'] . ' ' . $arrOrderDetail['BillingAddressLine2'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Country</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['BillingCountryName'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Postal Code</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['BillingPostalCode'] . '</font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="20"></td>
                            <td width="278" style="border:1px solid #d8d8d8;">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <th width="45" align="left" bgcolor="#362223"><img src="' . IMAGES_URL . 'gray-corner-info.png" alt=""></th>
                                        <th bgcolor="#362223" width="233" align="left" style="font-size:17px;"><font color="#fff" face="Arial">Shipping Information</font></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table cellpadding="0" cellspacing="0" border="0" style="margin:15px 0;">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Name</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['ShippingFirstName'] . ' ' . $arrOrderDetail['ShippingLastName'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Address</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['ShippingAddressLine1'] . ' ' . $arrOrderDetail['ShippingAddressLine2'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Country</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['ShipingCountryName'] . '</font></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="77" height="30" style="font-size:12px;"><b><font color="#333" face="Arial">Postal Code</font></b></td>
                                                    <td width="10" height="30" style="font-size:12px;">:</td>
                                                    <td width="181" height="30" style="font-size:12px;"><font color="#333" face="Arial">' . $arrOrderDetail['ShippingPostalCode'] . '</font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="20"></td>
                        </tr>
                        <tr>
                            <td colspan="5" height="28">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <th width="104" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Sub Order Id</font></th>
                                        <th width="117" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Items Ordered</font></th>
                                        <th width="113" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Item Image</font></th>
                                        <th width="53" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Price</font></th>
                                        <th width="37" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Qty.</font></th>
                                        <th width="68" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Shipping</font></th>
                                        <th width="68" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Shipping Company</font></th>
                                        <th width="66" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Discount</font></th>
                                        <th width="64" bgcolor="#fa990e" height="43" style="font-size:11px;"><font color="#fff" face="Arial" size="2">Total</font></th>
                                    </tr>';


        foreach ($arrWholesalerDetails as $k => $v) {

            $varWhre = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' AND fkWholesalerID = '" . $v['fkWholesalerID'] . "'";
            $arrOrderItems = $objOrderProcess->GetItemDetails($varWhre);

            $varEmailOrderDetail = '';
            $varTotal = 0;

            foreach ($arrOrderItems as $k2 => $v2) {
                $varTotal += $v2['ItemTotalPrice'];
                $ItemPrice = $v2['ItemPrice'] + ($v2['AttributePrice'] / $v2['Quantity']);

                if ($v2['ItemType'] == 'product') {
                    $path = 'products/' . $arrProductImageResizes['default'];
                } else if ($v2['ItemType'] == 'package') {
                    $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                } else {
                    $path = 'gift_card';
                }

                $varSrc = $objCore->getImageUrl($v2['ItemImage'], $path);
                $bgcolor = $k % 2 == 0 ? '#ffe7b9' : '#fffcf5';
                    $shippingcompanyname= $objGeneral->getshippingcompanyname($v2['fkShippingIDs']);
                    $shippingtitle=$shippingcompanyname[0]['ShippingTitle'];
                $varEmailOrderDetail .='<tr>
                                        <td width="104" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ucwords($v2['SubOrderID']) . '</font></td>
                                        <td width="117" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial"><strong style="font-size:13px;">' . $v2['ItemName'] . '</strong><br />' . $v2['OptionDet'] . '</font></td>
                                        <td width="113" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial"><img src="' . $varSrc . '" alt="' . $v2['ItemName'] . '" /></font></td>
                                        <td width="53" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format($ItemPrice, 2) . '</font></td>
                                        <td width="37" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . $v2['Quantity'] . '</font></td>
                                        <td width="68" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format($v2['ShippingPrice'], 2) . '</font></td>
                                        <td width="68" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . $shippingtitle . '</font></td>
                                        <td width="66" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format(-$v2['DiscountPrice'], 2) . '</font></td>
                                        <td width="64" bgcolor="' . $bgcolor . '" height="80" align="center" style="font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format($v2['ItemTotalPrice'], 2) . '</font></td>
                                    </tr>';
            }


            $varEmailOrderDetail .= '<tr>
                                        <td colspan="8">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td height="50" colspan="5">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td width="20" height="118">&nbsp;</td>
                                                    <td width="278" align="left" valign="top" bgcolor="#fff3e0" style="border:1px solid #cac7c8;" height="118">
                                                        <table cellpadding="0" cellspacing="0" align="center" border="0" width="86%; height:118px; ">
                                                            <tr>
                                                                <td style="margin:0;padding:10px 0 3px 13px;font-size:17px;color:#000;font-family:arial;font-weight:normal;">Comment History</td>
                                                            </tr>
                                                            <tr><td style="margin:0;padding:13px;color:#000;font-family:arial;font-weight:normal;font-size:13px;background:#ffffff;">';

            foreach ($arrOrderComments as $key => $val) {
                $varEmailOrderDetail .='<br/>' . $val['Comment'] . '<br /><p style = "font-weight: bold;text-align: right;font-size:14px;">' . $val[$val['CommentedBy'] . 'Name'] . ' (' . ucwords($val['CommentedBy']) . ')</p>';
            }

            $varEmailOrderDetail .= '</td></tr></table></td>
                                                    <td width="20" height="118">&nbsp;</td>
                                                    <td width="278" height="118" align="left" valign="top" bgcolor="#fff3e0" style="border:1px solid #cac7c8;padding: 0;">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="80%" align="center" height="118">';

            $varEmailOrderDetail .= '<tr><td height="60" align="left"><font color="#222" face="Arial" style="font-size:14px;">SubTotal</font></td><td height="60" align="right"><font color="#222" face="Arial" style="font-size:14px;">' . ADMIN_CURRENCY_SYMBOL . number_format($varTotal, 2) . '</font></td></tr>';

            $varEmailOrderDetail .= '<tr><td colspan="2" style="border-top:1px dashed #000;" height="20"></td></tr><tr><td height="50" align="left" valign="top"><font color="#222" face="Arial" style="font-size:18px;">' . GRAND_TOTAL . '</font></td><td height="50" align="right" valign="top"><font color="#fa990e" face="Arial" style="font-size:18px;">' . ADMIN_CURRENCY_SYMBOL . number_format($varTotal, 2) . '</font></td></tr>';
            $varEmailOrderDetail .= '</table></td><td width="20" height="118">&nbsp;</td></tr></table></td></tr></table></td></tr></table>';

            $varEmailOrderDetailss = $varEmailOrderDetails . $varEmailOrderDetail;

            $varName = $v['CompanyName'];
            $varEmail = $v['CompanyEmail'];

            $varKeywordValues = array($varName);
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $varEmailOrderDetailss);
            //$varEmail='avinesh.mathur@planetwebsolution.com';
            //pre($varEmailMessage);
// Calling mail function
            $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
        }
    }
    
     function SentEmailToLogisticcompany($arrOrderDetail,$portalmail,$gatwayname,$wholesalerid) {

        global $objCore;
        global $objGeneral;
        global $arrProductImageResizes;
         $objGeneral=new General();

        $objOrderProcess = new OrderProcess();
       // pre($arrOrderDetail);
        $arrWholesalerDetails = $objOrderProcess->GetWholesalerDetailsWithId($wholesalerid);
        //pre($wholesalerid);
       // $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";
        $CompanyName = $arrWholesalerDetails[0]['CompanyName'];
            $CompanyEmail = $arrWholesalerDetails[0]['CompanyEmail'];
        //$arrOrderComments = $objOrderProcess->getOrderComments($varWhr);

        //$EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{EMAIL}');
        $varSubject = $varSubject = 'New Order';
        $varHeading = '';
        $varFrom = SITE_NAME;

        $varEmailOrderDetails = '<table width="622" cellspacing="0" cellpadding="5" border="0" align="center"><tr><td style="font:700 17px arial;">Congrats {EMAIL},</td></tr><tr><td height="50" style="font:400 15px/17px arial;">' . PLACE_ORDER . '</td></tr></table>';
        $varEmailOrderDetails .= '<table width="622" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#fff" style="border:3px solid #ffb422;-webkit-border-radius:3px;-moz-border-radius:3px;-ms-border-radius:3px;-o-border-radius:3px;border-radius:3px;padding-top:32px;padding-bottom:52px;">
                        
                        <tr>
                            <td colspan="5">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <th width="104" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Sub Order Id</font></th>
                                        <th width="117" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Items Ordered</font></th>
                                        <th width="113" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Item Image</font></th>
                                        <th width="53" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Price</font></th>
                                        <th width="37" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Qty.</font></th>
                                        <th width="68" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Shipping</font></th>
                                        <th width="68" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Shipping Company</font></th>
                                        <th width="66" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Discount</font></th>
                                        <th width="64" bgcolor="#fa990e" height="43" style="font-size:11px;"><font color="#fff" face="Arial" size="2">Total</font></th>
                                    </tr>';

//$varEmailMessage="hello test '.$portalmail.'";
$varEmailMessage='
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" style="height:20px;">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top" style="background:#fff; border:3px solid #ffb422; padding:20px; font-size:14px; font-family:Verdana, Geneva, sans-serif"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top" colspan="2" style="font-size:14px; font-family:Verdana, Geneva, sans-serif"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; margin-bottom:10px; display:block">Dear '.$gatwayname.',</span>
                  </td>
              </tr>
              <tr>
                <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif" colspan="2" ><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-indent:20px;display:block"> Order No:-'.$arrOrderDetail['pkOrderID'].' has now booked by following wholesaler:</span> <br />
                  </td>
              </tr>
        
              <tr>
                  <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif; width:25%"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;text-indent:20px;"><strong>Company Name</strong></span>
                  <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;text-indent:20px;"><strong>'.$CompanyName. '</strong></span>
                  </td>
              </tr>
              <tr>
                  <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif" width:25%;><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;text-indent:20px;"><strong>Company Email</strong></span>
                  <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;text-indent:20px;"><strong>'.$CompanyEmail. '</strong></span>
                  </td>
              </tr>
        
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
		';


            //$varKeywordValues = array($varName);
           // $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $varEmailOrderDetailss);
           // $portalmail='avinesh.mathur@planetwebsolution.com';
		   //$portalmail='antima.gupta@planetwebsolution.com';
		   
            //pre($varEmailMessage);
// Calling mail function
            $objCore->sendMail($portalmail, $varFrom, $varSubject, $varEmailMessage);
       
    }

    /**
     * function SentEmailToCountryPortal
     *
     * This function Will be called on Sent Sent Email To Country Portal.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SentEmailToCountryPortal($arrOrderDetail) {

        global $objCore;
        global $arrProductImageResizes;
        $objOrderProcess = new OrderProcess();
        $varCSS = '';
        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>' . PLACE_ORDER . ' : </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
        $varEmailOrderDetails .= '<tr><th>' . ORDER_ID . '</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>' . TRANJECTION_ID . '</th><td colspan="2">&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="5">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>' . SUB_ORDER_ID . '</th><th>' . ITEM . '</th><th>' . ITEM_IMAGE . '</th><th>' . QUANTITY . '</th><th>' . PRICE . '</th></tr>';

        $arrWholesalerDetails = $objOrderProcess->GetWholesalerDetails($arrOrderDetail['pkOrderID']);

        $EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{CSS}', '{HEADING}', '{EMAIL}', '{EMAILDETAILS}');
        $varSubject = ORDER_DETAILS;
        $varHeading = '';
        $varFrom = SITE_NAME;

        foreach ($arrWholesalerDetails as $k => $v) {
            $varWhre = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' AND fkWholesalerID = '" . $v['fkWholesalerID'] . "'";
            $arrOrderItems = $objOrderProcess->GetItemDetails($varWhre);


            $varEmailOrderDetail = '';
            $varTotal = 0;
            foreach ($arrOrderItems as $k2 => $v2) {
                $varTotal += $v2['ItemTotalPrice'];

                if ($v2['ItemType'] == 'product') {
                    $path = 'products/' . $arrProductImageResizes['default'];
                } else if ($v2['ItemType'] == 'package') {
                    $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                } else {
                    $path = 'gift_card';
                }

                $varSrc = $objCore->getImageUrl($v2['ItemImage'], $path);

                $varEmailOrderDetails .= '<tr><td align="center">' . $v2['SubOrderID'] . '</td><td align="center"><b>' . $v2['ItemName'] . '</b><br />' . $v2['OptionDet'] . '</td>';
                $varEmailOrderDetails .='<td align="center"><img src="' . $varSrc . '" alt="' . $v2['ItemName'] . '"></td>';
                $varEmailOrderDetails .='<td align="center">' . $v2['Quantity'] . '</td><td align="center">$ ' . number_format($v2['ItemTotalPrice'], 2, '.', ',') . '</td></tr>';
            }
            $varWhere = "AdminCountry = '" . $v['CompanyCountry'] . "'";

            $AdminData = $objOrderProcess->adminList($varWhere);
            $varCtr = 0;

            foreach ($AdminData as $val) {

                if ($val['AdminRegion'] == $v['CompanyRegion']) {
                    $varEmail = $val['AdminEmail'];
                    $varName = $val['AdminUserName'];
                    $varCtr = $varCtr++;
                } else if ($val['AdminCountry'] == $v['CompanyCountry'] && $varCtr == 0) {
                    $varEmail = $val['AdminEmail'];
                    $varName = $val['AdminUserName'];
                } else {
                    continue;
                }

                $varEmailOrderDetailss = $varEmailOrderDetails . $varEmailOrderDetail . '<tr bgcolor="#cccccc"><th colspan="4" align="right">' . GRAND_TOTAL . '</th><td align="center">&nbsp;&nbsp;$&nbsp;' . number_format($varTotal, 2, ".", ",") . '</td></tr>';

                $varEmailOrderDetailss .='</table>';

                $varKeywordValues = array($varCSS, $varHeading, $varName, $varEmailOrderDetailss);
                $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

// Calling mail function
                $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
            }
        }
    }

    /**
     * function SentEmailToSuperAdmin
     *
     * This function Will be called on Sent Email To SuperAdmin.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SentEmailToSuperAdmin($arrOrderDetail) {

        global $objCore;
        global $arrProductImageResizes;
        $objOrderProcess = new OrderProcess();
        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";
        $arrOrderItems = $objOrderProcess->GetItemDetails($varWhr);

        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' AND Code='total' ";
        $arrOrderItemTotal = $objOrderProcess->GetTotalDetails($varWhr);
        $varCSS = '';
        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>' . PLACE_ORDER . ' : </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
        $varEmailOrderDetails .= '<tr><th>' . ORDER_ID . '</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>' . TRANJECTION_ID . '</th><td colspan="2">&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="5">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>' . SUB_ORDER_ID . '</th><th>' . ITEM . '</th><th>' . ITEM_IMAGE . '</th><th>' . QUANTITY . '</th><th>' . PRICE . '</th></tr>';

        foreach ($arrOrderItems as $k => $v) {

            $varEmailOrderDetails .= '<tr><td align="center">' . $v['SubOrderID'] . '</td><td align="center"><b>' . $v['ItemName'] . '</b><br />' . $v['OptionDet'] . '</td>';

            if ($v['ItemType'] == 'product') {
                $path = 'products/' . $arrProductImageResizes['default'];
            } else if ($v['ItemType'] == 'package') {
                $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
            } else {
                $path = 'gift_card';
            }

            $varSrc = $objCore->getImageUrl($v['ItemImage'], $path);
            $varEmailOrderDetails .='<td align="center"><img src="' . $varSrc . '" alt="' . $v['ItemName'] . '"></td>';

            $varEmailOrderDetails .='<td align="center">' . $v['Quantity'] . '</td><td align="center">$ ' . number_format($v['ItemTotalPrice'], 2, '.', ',') . '</td></tr>';
        }

        $varEmailOrderDetails .= '<tr bgcolor="#cccccc"><th colspan="4" align="right">' . GRAND_TOTAL . '</th><td align="center">&nbsp;&nbsp;$ ' . number_format($arrOrderItemTotal[0]['Amount'], 2, ".", ",") . '</td></tr>';

        $varEmailOrderDetails .='</table>';

        $varWhre = "AdminType = 'super-admin' ";
        $arrAdminDetails = $objOrderProcess->GetAdminDetails($varWhre);

        $EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{CSS}', '{HEADING}', '{EMAIL}', '{EMAILDETAILS}');
        $varSubject = 'Order details';
        $varHeading = '';
        $varFrom = SITE_NAME;
        foreach ($arrAdminDetails as $admink => $adminv) {

            $varName = $adminv['AdminUserName'];
            $varEmail = $adminv['AdminEmail'];


            $varKeywordValues = array($varCSS, $varHeading, $varName, $varEmailOrderDetails);
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

// Calling mail function
            $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
        }
    }

    /**
     * function sendGiftCardNotifyToRecipient
     *
     * This function Will be called on Sent Email To Customer.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function sendGiftCardNotifyToRecipient($orderID) {
        global $objCore;
        $objOrderProcess = new OrderProcess();
        $objTemplate = new EmailTemplate();

        $arrGiftCard = $objOrderProcess->getGiftCardDetails($orderID);

        $fromUserName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'GiftCardNotification' AND EmailTemplateStatus = 'Active' ";
        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));


        foreach ($arrGiftCard as $key => $val) {

            $varSubTo = 'Gift Card notification ';
            $varSubFrom = 'Gift Card notification Email sent to ' . $val['NameTo'];

            $varKeyword = array('{SUBJECT}', '{CODE}', '{NAMEFROM}', '{NAMETO}', '{MESSAGE}', '{TOTALAMOUNT}', '{BALANCEAMOUNT}', '{SITE_NAME}');

            $varKeywordValues = array($varSubTo, $val['GiftCardCode'], $val['NameFrom'], $val['NameTo'], $val['Message'], $val['TotalAmount'], $val['BalanceAmount'], SITE_NAME);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

            // $varOutPutValuesTo = str_replace($varKeyword, $varKeywordValues, $varOutput);
            $objCore->sendMail($val['EmailTo'], $fromUserName, $varSubject, $varOutPutValues);

            $varKeywordValues = array($varSubFrom, $val['GiftCardCode'], $val['NameFrom'], $val['NameTo'], $val['Message'], $val['TotalAmount'], $val['BalanceAmount'], SITE_NAME);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
            //$varOutPutValuesTo = str_replace($varKeyword, $varKeywordValues, $varOutput);
            $objCore->sendMail($val['EmailFrom'], $fromUserName, $varSubject, $varOutPutValues);
        }
    }

    /**
     * function SentEmailToSuperAdmin
     *
     * This function Will be called on Sent Email To SuperAdmin.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters
     *
     * @return String $varEmailTemplate
     */
    function SentEmailTemplates() {
        $varEmailTemplate = '{CSS}
                <table width="100%" cellspacing="0" cellpadding="5" border="0">
                <tr><td width="25">&nbsp;</td><td width="600"><strong>Congrats {EMAIL} ,</strong></td></tr>
                <tr><td width="25">&nbsp;</td><td width="98%">{EMAILDETAILS}</td></tr>
                </table>';
        return $varEmailTemplate;
// Calling mail function
    }

}

?>