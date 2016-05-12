<?php

require_once CLASSES_PATH . 'class_shopping_cart_bll.php';
require_once CLASSES_PATH . 'class_order_process_bll.php';

/**
 * Site OrderPageCtrl Class
 *
 * This is the OrderPageCtrl class that will used on Payment Page.
 *
 * DateCreated 5th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class OrderPageCtrl {
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
        if (!isset($_SESSION['sessUserInfo']['type']) || $_SESSION['sessUserInfo']['type'] <> 'customer' || $_SESSION['MyCart']['Total'] < 1) {
            header('location:' . SITE_ROOT_URL);
        }
//        pre($_SESSION);
        $objCore = new Core();
        $objCore->setCurrencyPrice();
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
    public function pageLoad() {

        $objCore = new Core();
        global $objGeneral;
        $objShoppingCart = new ShoppingCart();
        $objOrderProcess = new OrderProcess();

        if (isset($_POST['frmComment'])) {
            $_SESSION['MyCart']['OrderComment'] = strip_tags($_POST['frmComment']);
        }



        $this->arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();

        //pre($this->arrData['arrCartDetails']);

        $varGrandPrice = 0;
        foreach ($this->arrData['arrCartDetails']['Product'] as $key => $val) {
            $varSubTotal = ($val['FinalPrice'] * $_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['qty']) - $val['Discount'];
            $varGrantPrice += ($varSubTotal + $_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['AppliedShipping']['ShippingCost']);
            $grantvarSubTotal +=$varSubTotal;
        }

        foreach ($this->arrData['arrCartDetails']['Package'] as $key => $val) {
            $varSubTotal = $_SESSION['MyCart']['Package'][$val['pkPackageId']][$key]['qty'] * $val['PackagePrice'];
            $varGrantPrice += ($varSubTotal + $_SESSION['MyCart']['Package'][$val['pkPackageId']][$key]['AppliedShipping']['ShippingCost']);
            $grantvarSubTotal +=$varSubTotal;
        }

        foreach ($this->arrData['arrCartDetails']['GiftCard'] as $key => $val) {
            $varSubTotal = $val['qty'] * $val['amount'];
            $varGrantPrice += $varSubTotal;
            $grantvarSubTotal +=$varSubTotal;
        }

        //$this->arrData['CartTotalPrice'] = $varGrantPrice;



        $this->arrData['CartTotalPrice'] = ($varGrantPrice < MINIMUM_ORDER_PRICE) ? MINIMUM_ORDER_PRICE : $varGrantPrice;

        $this->arrData['CartTotalBalancedPrice'] = $this->arrData['CartTotalPrice'];
        $this->arrData['Cartsubtotoal'] = $grantvarSubTotal;

        if (isset($_POST['frmCardName']) && $_POST['frmBtnApply'] == 'Apply') {// Process Gift Card
            $this->arrData['CartTotalBalancedPrice'] = $this->arrData['CartTotalPrice'] - $_SESSION['MyCart']['arrReward']['RewardValue'];

            $ApplyGiftCard = $objOrderProcess->ApplyGiftCard($_POST['frmCardName'], $this->arrData['CartTotalBalancedPrice'], $_SESSION['sessUserInfo']['email']);

            //pre($ApplyGiftCard);

            if ($ApplyGiftCard['isValid'] == 1) {
                //$this->arrData['CartTotalPrice'] = $ApplyGiftCard['GrandTotal'];
                //$this->arrData['CartTotalBalancedPrice'] = $ApplyGiftCard['GrandTotal'];                
                $this->arrData['setMsg'] = '<span style="color:green;">' . SUCCESS_MESSAGE_GIFTCARD_APPLIED . '</span>';
            } else {
                $this->arrData['setMsg'] = '<span style="color:red;">' . ERROR_MESSAGE_GIFTCARD_NOT_EXIST . '</span>';
            }
        }

        if (isset($_POST['frmBtnRemove']) && $_POST['frmBtnRemove'] == 'Remove') {// remove Gift Card            
            unset($_SESSION['MyCart']['GiftCardCode']);
        }


        if (isset($_POST['frmBtnApplyRewards']) && $_POST['frmBtnApplyRewards'] == 'Apply') {

            // Process Rewards points
            $arrSett = $arrRewardList = $objGeneral->getSetting('thresholdlimit');
            $arrReward = $objGeneral->getRewardAndValues($_SESSION['sessUserInfo']['id']);
           // pre($_SESSION);
		//pre($arrReward);
            $rewardpoints = $arrReward['RewardPoints'];
            $thresholdlimit = $arrSett['thresholdlimit']['SettingValue'];
            if ($rewardpoints >= $thresholdlimit) {
                //pre($arrReward); 
                $this->arrData['CartTotalBalancedPrice'] = $this->arrData['CartTotalPrice'] - $_SESSION['MyCart']['GiftCardCode']['2'];

                //$this->arrData['arrReward'] = $objGeneral->getAppliedPoints($arrReward, $this->arrData['CartTotalBalancedPrice']);
                $this->arrData['arrReward'] = $objGeneral->getAppliedPoints($arrReward, $this->arrData['Cartsubtotoal'], $this->arrData);

                $_SESSION['MyCart']['arrReward'] = $this->arrData['arrReward'];
            //pre($this->arrData['arrReward']);
                if ($this->arrData['arrReward']['RewardValue'] > 0) {
                    $this->arrData['setMsg'] = '<span style="color:green;">' . SUCCESS_MESSAGE_REWARDS_APPLIED . '</span>';
                } else {
                    $this->arrData['setMsg'] = '<span style="color:red;">' . ERROR_MESSAGE_REWARDS_NOT_APPLIED . '</span>';
                }
            } else {

                $this->arrData['setMsg'] = '<span style="color:red;">You must have atleast ' . $thresholdlimit . ' reward points to Redeem. </span>';
            }
        }
        //pre($this->arrData['CartTotalBalancedPrice']);

        if (isset($_POST['frmBtnRemoveReward']) && $_POST['frmBtnRemoveReward'] == 'Remove') {// remove Rewards points                 
            unset($_SESSION['MyCart']['arrReward']);
        }

        $this->arrData['arrGiftCard'] = $_SESSION['MyCart']['GiftCardCode'];
        $this->arrData['arrReward'] = $_SESSION['MyCart']['arrReward'];

        if ($this->arrData['arrReward']['RewardValue'] <= 0) {
            $arrReward = $objGeneral->getRewardAndValues($_SESSION['sessUserInfo']['id']);
            $this->arrData['arrReward'] = $objGeneral->getRemovedAppliedPoints($arrReward);
        }

        $this->arrData['CartTotalBalancedPrice'] = $this->arrData['CartTotalPrice'] - ($_SESSION['MyCart']['GiftCardCode']['2'] + $_SESSION['MyCart']['arrReward']['RewardValue']);

        //$arrReward = $objGeneral->getRewardAndValues($_SESSION['sessUserInfo']['id']);
        //$this->arrData['arrReward'] = $objGeneral->getAppliedPoints($arrReward, $this->arrData['CartTotalPrice']);
        //pre($this->arrData);

        $objShoppingCart->updateCart();
        // end of page load
    }

}

$objPage = new OrderPageCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
