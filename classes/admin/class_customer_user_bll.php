<?php

include_once "class_shopping_cart_bll.php";

/**
 * Site Customer Class
 *
 * This is the Product class that will frequently used on website.
 *
 * DateCreated 18th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class Customer extends Database
{

    function __construct()
    {

//$objCore = new Core();
//default constructor for this class
    }

    /**
     * function countryList
     *
     * This function is used get country list.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function countryList()
    {
        $arrClms = array(
            'country_id',
            'name',
        );
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms);
        return $arrRes;
    }

    /**
     * function wholeSalerList
     *
     * This function is used get wholesaler list.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function wholeSalerList()
    {
        $arrClms = array(
            'pkWholesalerID ',
            'CompanyName',
        );
        $where = "WholesalerStatus='active'";
        $varOrderBy = 'CompanyName ASC ';
        $arrRes = $this->select(TABLE_WHOLESALER, $arrClms, $where, $varOrderBy);
        return $arrRes;
    }

    /**
     * function countryById
     *
     * This function is used country by id.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function countryById($countryId = '')
    {
        $arrClms = array(
            'country_id',
            'name',
            'time_zone',
        );
        $where = "country_id = '" . $countryId . "'";
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms, $where);
//pre($arrRes);
        return $arrRes;
    }

    /**
     * function CustomerDetails
     *
     * This function is used get customer details.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function CustomerDetails($varCustomerId)
    {
        $arrClms = array(
            'ReferalID',
            'CustomerScreenName',
            'CustomerFirstName',
            'CustomerLastName',
            'CustomerEmail',
            'CustomerPassword',
            'BillingFirstName',
            'BillingLastName',
            'BillingOrganizationName',
            'BillingAddressLine1',
            'BillingAddressLine2',
            'BillingCountry',
            'BillingPostalCode',
            'BillingTown',
            'BillingPhone',
            'ShippingFirstName',
            'ShippingLastName',
            'ShippingOrganizationName',
            'ShippingAddressLine1',
            'ShippingAddressLine2',
            'ShippingCountry',
            'ShippingPostalCode',
            'ShippingTown',
            'ShippingPhone',
            'BusinessAddress',
            'BalancedRewardPoints',
            'CustomerDateAdded',
            'ResAddressLine1', 'ResAddressLine2', 'ResPostalCode', 'ResCountry', 'ResTown', 'ResPhone',
            'CustomerWebsiteVisitCount', 'SameShipping'
        );
        $argWhere = "pkCustomerID='" . $varCustomerId . "' ";
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere);



//pre($arrRes);
        return $arrRes;
    }

    /**
     * function CustomerDetailsWithCountryName
     *
     * This function is used get customer details with his country name.
     *
     * Database Tables used in this function are : tbl_customer,tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function CustomerDetailsWithCountryName($varCustomerId)
    {
        $arrClms = array(
            'CustomerFirstName',
            'CustomerLastName',
            'CustomerEmail',
            'CustomerPassword',
            'BillingFirstName',
            'BillingLastName',
            'BillingOrganizationName',
            'BillingAddressLine1',
            'BillingAddressLine2',
            'BillingCountry',
            'bc.name as BillingCountryName',
            'BillingPostalCode',
            'BillingPhone',
            'ShippingFirstName',
            'ShippingLastName',
            'ShippingOrganizationName',
            'ShippingAddressLine1',
            'ShippingAddressLine2',
            'ShippingCountry',
            'sc.name as ShippingCountryName',
            'ShippingPostalCode',
            'ShippingPhone',
            'BusinessAddress',
            'CustomerDateAdded'
        );
        $varTbl = TABLE_CUSTOMER . " LEFT JOIN " . TABLE_COUNTRY . " as bc ON BillingCountry = bc.country_id  LEFT JOIN " . TABLE_COUNTRY . " as sc ON ShippingCountry = sc.country_id";
        $argWhere = "pkCustomerID='" . $varCustomerId . "' ";
        $arrRes = $this->select($varTbl, $arrClms, $argWhere);
        return $arrRes;
    }

    /**
     * function CustomerDetails
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_customer,tbl_country
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrCustomerDetails
     */
    function CustomerDetailsForShipping($varCustomerId)
    {
        $varQuery = "SELECT pkCustomerID,concat(CustomerFirstName,' ',CustomerLastName) AS CustomerName, ShippingAddressLine1,ShippingAddressLine2,ShippingCountry,name,iso_code_2,iso_code_3,zone, ShippingPostalCode,ShippingPhone
            FROM " . TABLE_CUSTOMER . " LEFT JOIN " . TABLE_COUNTRY . " ON ShippingCountry = country_id
            WHERE pkCustomerID  = '" . $varCustomerId . "'";
        $arrCustomerDetails = $this->getArrayResult($varQuery);

        return $arrCustomerDetails[0];
    }
	
	
	/**
     * function getCustomerList
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrCustomerDetails
     */
    function getCustomerList()
    {
        $varQuery = "SELECT pkCustomerID, device_id, user_type
            FROM " . TABLE_CUSTOMER . " WHERE device_id  != 'NODEVICETOKEN'";
        $arrCustomerList = $this->getArrayResult($varQuery);

        return $arrCustomerList;
    }

    /**
     * function addCustomer
     *
     * This function is used to add customer.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     */
    function addCustomer($arrPost)
    { //echo pre($arrPost);
        global $objGeneral;
        $objCore = new Core();
        $varEmail = $arrPost['frmCustomerEmail'];
        $varCustomerWhere = "CustomerEmail='" . $varEmail . "'";
        $arrClms = array('pkCustomerID');
        $arrUserList = $this->select(TABLE_CUSTOMER, $arrClms, $varCustomerWhere);
        if ($arrUserList)
        {
            return 0;
        }
        else
        {
            $arrClms = array(
                'CustomerFirstName' => $objCore->stripTags($arrPost['frmCustomerFirstName']),
                'CustomerLastName' => $objCore->stripTags($arrPost['frmCustomerLastName']),
                'CustomerEmail' => $objCore->stripTags($arrPost['frmCustomerEmail']),
                'CustomerPassword' => md5(trim($arrPost['frmCustomerPassword'])),
                'BillingFirstName' => $objCore->stripTags($arrPost['frmBillingFirstName']),
                'BillingLastName' => $objCore->stripTags($arrPost['frmBillingLastName']),
                'BillingOrganizationName' => $objCore->stripTags($arrPost['frmBillingOrganizationName']),
                'BillingAddressLine1' => $objCore->stripTags($arrPost['frmBillingAddressLine1']),
                'BillingAddressLine2' => $objCore->stripTags($arrPost['frmBillingAddressLine2']),
                'BillingCountry' => $objCore->stripTags($arrPost['frmBillingCountry']),
                'BillingPostalCode' => $objCore->stripTags($arrPost['frmBillingPostalCode']),
                'BillingTown' => $objCore->stripTags($arrPost['frmBillingTown']),
                'BillingPhone' => $objCore->stripTags($arrPost['frmBillingPhone']),
                'ShippingFirstName' => $objCore->stripTags($arrPost['frmShippingFirstName']),
                'ShippingLastName' => $objCore->stripTags($arrPost['frmShippingLastName']),
                'ShippingOrganizationName' => $objCore->stripTags($arrPost['frmShippingOrganizationName']),
                'ShippingAddressLine1' => $objCore->stripTags($arrPost['frmShippingAddressLine1']),
                'ShippingAddressLine2' => $objCore->stripTags($arrPost['frmShippingAddressLine2']),
                'ShippingCountry' => $objCore->stripTags($arrPost['frmShippingCountry']),
                'ShippingPostalCode' => $objCore->stripTags($arrPost['frmShippingPostalCode']),
                'ShippingTown' => $objCore->stripTags($arrPost['frmShippingTown']),
                'ShippingPhone' => $objCore->stripTags($arrPost['frmShippingPhone']),
                'BusinessAddress' => $objCore->stripTags($arrPost['frmBusinessAddress']),
                'ResAddressLine1' => $objCore->stripTags($arrPost['frmResAddressLine1']),
                'ResAddressLine2' => $objCore->stripTags($arrPost['frmResAddressLine2']),
                'ResPostalCode' => $objCore->stripTags($arrPost['frmResPostalCode']),
                'ResCountry' => $objCore->stripTags($arrPost['frmResCountry']),
                'ResTown' => $objCore->stripTags($arrPost['frmResTown']),
                'ResPhone' => $objCore->stripTags($arrPost['frmResPhone']),
                'IsEmailVerified' => '0',
                'ReferBy' => $objCore->stripTags($arrPost['frmReferal']),
                'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $arrAddID = $this->insert(TABLE_CUSTOMER, $arrClms);
            $objGeneral->addRewards($arrAddID, 'RewardOnCustomerRegistration');
            $objGeneral->createReferalId($arrAddID);
            $objTemplate = new EmailTemplate();

            $varUserName = trim(strip_tags($arrPost['frmCustomerEmail']));
            $varFromUser = SITE_NAME;
            $varMessage = $arrPost['frmMessage'];
            $vcode = $objGeneral->getEmailVerificationEncode($arrClms['CustomerEmail'] . ',' . $arrAddID . ',' . $arrClms['CustomerDateAdded']);
            $ref = (isset($_POST['frmRef'])) ? 'checkout.php' : 'index.php';
            $VerificationUrl = $objCore->getUrl('verify_my_email.php', array('action' => md5('customer'), 'vcode' => $vcode, 'ref' => $ref));

            $varSiteName = SITE_NAME;

            $varWhereTemplate = " EmailTemplateTitle= 'Customer Registration' AND EmailTemplateStatus = 'Active' ";

            $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

            $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

            $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

            $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

            $varKeyword = array('{IMAGE_PATH}', '{PASSWORD}', '{SITE_NAME}', '{USER_NAME}', '{CUSTOMER}', '{VERIFICATION_URL}', '{VERIFICATION_URL}');

            $varKeywordValues = array($varPathImage, $arrPost['frmCustomerPassword'], SITE_NAME, $arrPost['frmCustomerEmail'], ucfirst($arrPost['frmCustomerFirstName']), $VerificationUrl, $VerificationUrl);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function


            $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);

//
            return $arrAddID;
        }
    }

    /**
     * function getCustomerfromSocialProvider
     *
     * This function is used to add customer.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     */
    function getCustomerFromSocialProvider($arrPost)
    {
        $objCore = new Core();

        $varCustomerWhere = "CustomerEmail='" . $objCore->getFormatValue($arrPost['email']) . "'";
        $arrClms = array('pkCustomerID', 'CustomerScreenName', 'SocialProvider', 'CustomerEmail', 'BusinessAddress', 'BillingCountry', 'ShippingCountry', 'CustomerStatus', 'IsEmailVerified', 'CustomerWebsiteVisitCount');
        $arrUserList = $this->select(TABLE_CUSTOMER, $arrClms, $varCustomerWhere);
       //echo $arrUserList; die;

        if ($arrUserList[0]['pkCustomerID'] > 0)
        {
            //$returnId = $arrUserList[0]['pkCustomerID'];
        }
        else
        {
            $varCustomerWhere = "SocialProvider='" . $objCore->getFormatValue($arrPost['provider']) . "' AND SocialIdentifier='" . $objCore->getFormatValue($arrPost['identifier']) . "'";

            $arrUserList = $this->select(TABLE_CUSTOMER, $arrClms, $varCustomerWhere);

            if ($arrUserList[0]['pkCustomerID'] > 0)
            {
                //$returnId = $arrUserList[0]['pkCustomerID'];
            }
            else
            {
                $arrUserList[0]['pkCustomerID'] = 0;
            }
        }

        return $arrUserList;
    }

    /**
     * function userLoginFromSocialProvider
     *
     * This function is used to user login.
     *
     * Database Tables used in this function are : tbl_customer,tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    function userLoginFromSocialProvider($arrUserList)
    {

        //pre($arrUserList);
        $objCore = new Core();
        $shoppingCart = new ShoppingCart();

        if ($arrUserList[0]['BusinessAddress'] = "Billing")
        {
            $varCountryId = $arrUserList[0]['BillingCountry'];
        }
        else
        {
            $varCountryId = $arrUserList[0]['ShippingCountry'];
        }
        $arrClms = array('country_id', 'time_zone',);
        $varWhr = "country_id = '" . $varCountryId . "'";
        $arrCustomerZone = $this->select(TABLE_COUNTRY, $arrClms, $varWhr);

        $_SESSION['sessUserInfo']['type'] = 'customer';
        $_SESSION['sessUserInfo']['email'] = $arrUserList[0]['CustomerEmail'];
        $_SESSION['sessUserInfo']['screenName'] = $arrUserList[0]['CustomerScreenName'];
        $_SESSION['sessUserInfo']['id'] = $arrUserList[0]['pkCustomerID'];
        $_SESSION['sessUserInfo']['provider'] = $arrUserList[0]['SocialProvider'];
        $_SESSION['sessUserInfo']['countryid'] = $varCountryId;
        $_SESSION['sessTimeZone'] = $arrCustomerZone[0]['time_zone'];

        $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $arrUserList[0]['pkCustomerID'] . "'");

        //pre($arrCart);

        $row = '';
        foreach ($shoppingCart->myCartDetails() as $ItemType => $cartValues)
        {
            foreach ($cartValues as $cartVal)
            {

                switch ($ItemType)
                {
                    case 'Product':
                        $row.= '
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
                                  <td align="center" valign="top">' . $cartVal['qty']*$cartVal['FinalPrice'] . '</td>
                                 </tr>
                            ';
                        break;
                    case 'GiftCard':
                        $row.= '
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
                        $row.= '
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
        //pre($arrCart);
        if (isset($_SESSION['MyCart']) && $_SESSION['MyCart'] != '')
        { //echo 'hi';die;
            if (count($arrCart) > 0)
            {
                $updateCartData = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));
                //pre($updateCartData);
                $sessionCartProduct = $_SESSION['MyCart']['Product'];
                $sessionCartPackage = $_SESSION['MyCart']['Package'];
                $sessionCartGiftCard = $_SESSION['MyCart']['GiftCard'];
                if ((isset($_SESSION['MyCart']['Product']) && $_SESSION['MyCart']['Product'] <> '') || count($updateCartData['Product']) > 0)
                {
                    foreach ($updateCartData['Product'] as $key => $val)
                    {
                        $sessionCartProduct[$key] = $val;
                    }
                    $_SESSION['MyCart']['Product'] = $sessionCartProduct;
                    $updateCartData1['Product'] = $_SESSION['MyCart']['Product'];
                }
                if ((isset($_SESSION['MyCart']['Package']) && $_SESSION['MyCart']['Package'] <> '') || count($updateCartData['Package']) > 0)
                {
                    foreach ($updateCartData['Package'] as $key => $val)
                    {
                        $sessionCartPackage[$key] = $val;
                    }
                    $_SESSION['MyCart']['Package'] = $sessionCartPackage;
                    $updateCartData1['Package'] = $_SESSION['MyCart']['Package'];
                }
                if ((isset($_SESSION['MyCart']['GiftCard']) && $_SESSION['MyCart']['GiftCard'] <> '') || count($updateCartData['GiftCard']) > 0)
                {
                    foreach ($updateCartData['GiftCard'] as $key => $val)
                    {
                        $sessionCartGiftCard[$key] = $val;
                    }
                    $_SESSION['MyCart']['GiftCard'] = $sessionCartGiftCard;
                    $updateCartData1['GiftCard'] = $_SESSION['MyCart']['GiftCard'];
                }
                $updateCartData1['Total'] = $_SESSION['MyCart']['Total'] + $updateCartData['Total'];

                $row = $row . $arrCart[0]['CartDetails'];
                //pre($updateCartData1);
                $arrClmsUpdate = array(
                    'fkCustomerID' => $arrUserList[0]['pkCustomerID'],
                    'CartDetails' => $row,
                    'CartData' => serialize($updateCartData1),
                    'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
                );
                $argWhere = "fkCustomerID = '" . $arrUserList[0]['pkCustomerID'] . "' ";
                $arrInsertID = $this->update(TABLE_CART, $arrClmsUpdate, $argWhere);
            }
            else
            {
                $arrClmsAdd = array(
                    'fkCustomerID' => $arrUserList[0]['pkCustomerID'],
                    'CartDetails' => $row,
                    'CartData' => serialize($_SESSION['MyCart']),
                    'CartReminderDate' => trim(date(DATE_TIME_FORMAT_DB)),
                    'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
                );
                $arrInsertID = $this->insert(TABLE_CART, $arrClmsAdd);
            }
        }
        $arrCart1 = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $arrUserList[0]['pkCustomerID'] . "'");
        //pre($arrCart1);
        if (isset($arrCart1[0]['fkCustomerID']))
        {
            $_SESSION['MyCart'] = unserialize(html_entity_decode($arrCart1[0]['CartData'], ENT_QUOTES));
            //pre($_SESSION['MyCart']);
        }

        $varWhr = "pkCustomerID = '" . $arrUserList[0]['pkCustomerID'] . "'";
        $arrClms = array('CustomerWebsiteVisitCount' => ($arrUserList[0]['CustomerWebsiteVisitCount'] + 1));
        $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);

        //echo '<script>parent.window.location.href =  "' . $objCore->getUrl('dashboard_customer_account.php') . '";</script>';
    }

    /**
     * function addCustomerFromSocialProvider
     *
     * This function is used to add customer.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     */
    function addCustomerFromSocialProvider($arrPost)
    {
        global $objGeneral;
        $objCore = new Core();


        $password = rand();

        $arrClms = array(
            'SocialProvider' => $objCore->stripTags($arrPost['provider']),
            'SocialIdentifier' => $objCore->stripTags($arrPost['identifier']),
            'CustomerFirstName' => $objCore->stripTags($arrPost['firstName']),
            'CustomerLastName' => $objCore->stripTags($arrPost['lastName']),
            'CustomerEmail' => $objCore->stripTags($arrPost['email']),
            'CustomerPassword' => md5($password),
            'BillingFirstName' => $objCore->stripTags($arrPost['firstName']),
            'BillingLastName' => $objCore->stripTags($arrPost['lastName']),
            'BillingAddressLine1' => $objCore->stripTags($arrPost['address']),
            'BillingCountry' => $objCore->stripTags($arrPost['country']),
            'BillingPostalCode' => $objCore->stripTags($arrPost['zip']),
            'BillingPhone' => $objCore->stripTags($arrPost['phone']),
            'ShippingFirstName' => $objCore->stripTags($arrPost['firstName']),
            'ShippingLastName' => $objCore->stripTags($arrPost['lastName']),
            'ShippingAddressLine1' => $objCore->stripTags($arrPost['address']),
            'ShippingCountry' => $objCore->stripTags($arrPost['country']),
            'ShippingPostalCode' => $objCore->stripTags($arrPost['zip']),
            'ShippingPhone' => $objCore->stripTags($arrPost['phone']),
            'IsEmailVerified' => '1',
            'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );

        //pre($arrPost);
        $arrAddID = $this->insert(TABLE_CUSTOMER, $arrClms);
        $varCustomerWhere = "pkCustomerID='" . $objCore->getFormatValue($arrAddID) . "'";
        $arrClms = array('pkCustomerID', 'CustomerScreenName', 'CustomerEmail', 'BusinessAddress', 'BillingCountry', 'ShippingCountry', 'CustomerStatus', 'IsEmailVerified', 'CustomerWebsiteVisitCount');
        $arrUserList = $this->select(TABLE_CUSTOMER, $arrClms, $varCustomerWhere);

        $objGeneral->addRewards($arrAddID, 'RewardOnCustomerRegistration');
        $objGeneral->createReferalId($arrAddID);

        $objTemplate = new EmailTemplate();

        $varUserName = trim(strip_tags($arrPost['email']));
        $varFromUser = SITE_NAME;
        //$varMessage = $arrPost['frmMessage'];
        //$vcode = $objGeneral->getEmailVerificationEncode($arrClms['CustomerEmail'] . ',' . $arrAddID . ',' . $arrClms['CustomerDateAdded']);
        //$ref = (isset($_POST['frmRef'])) ? 'checkout.php' : 'index.php';
        //$VerificationUrl = $objCore->getUrl('verify_my_email.php', array('action' => md5('customer'), 'vcode' => $vcode, 'ref' => $ref));

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'CustomerRegistrationFromSocial' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{PASSWORD}', '{SITE_NAME}', '{USER_NAME}', '{CUSTOMER}');

        $varKeywordValues = array($varPathImage, $password, SITE_NAME, $arrPost['email'], ucfirst($arrPost['firstName']));

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
        $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);

        return $arrUserList;
    }

    /**
     * function ratingReviewFromSocialProvider
     *
     * This function is used review rating to product.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return 
     */
    function ratingReviewFromSocialProvider($arrPost)
    {

        global $objGeneral;
        $objCore = new Core();

        if (isset($arrPost['pid']) && $arrPost['pid'] <> '')
        {
            if (isset($arrPost['type']) && $arrPost['type'] == 'wish')
            {
                $this->myWishlistAdd($arrPost['pid']);
                $objCore->setSuccessMsg(WISHLIST_PRODUCT_ADD_SUCCUSS_MSG);
            }
            else if (isset($arrPost['type']) && $arrPost['type'] == 'rating')
            {
                $this->myRatingAdd($arrPost);
                $objCore->setSuccessMsg(RATING_PRODUCT_SUCCUSS_MSG);
            }
            else if (isset($arrPost['type']) && $arrPost['type'] == 'review')
            {
                $this->userReviewAdd($arrPost);
                $objCore->setSuccessMsg(FRONT_CUSTOMER_REVIEW_DISPLAY_MSG);
            }
        }
    }

    /**
     * function doCustomerLogout
     *
     * This function is used to customer logout.
     *
     * Database Tables used in this function are :none
     *
     * @access public
     *
     * @parameters 0 string optional
     *
     * @return string Null
     */
    function doCustomerLogout()
    {
        if (isset($_SESSION['sessUserInfo']))
        {
            unset($_SESSION['sessUserInfo']);
            unset($_SESSION['MyCart']);
            setcookie("MyCart", "", time() - 3600);
            unset($_SESSION['MyCompare']);
        }
    }

    /**
     * function updateCustomer
     *
     * This function is used to update customer.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string Null
     */
    function updateCustomer($cid, $arrPost)
    {
        $objCore = new Core();
        $varWhr = "pkCustomerID = '" . $cid . "'";

        $arrClms = array('pkCustomerID');

        $argWhere = "CustomerScreenName = '" . $arrPost['frmCustomerScreenName'] . "' AND pkCustomerID != '" . $cid . "'";
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere);

        if (count($arrRes) > 0)
        {
            $objCore->setErrorMsg(FRONT_USER_SCREEN_NAME_NOT_AVAIL_MSG);
            header('location:edit_my_account.php?&type=edit');
            die;
        }
        else
        {
            $arrClmsUpdate = array(
                'CustomerScreenName' => $objCore->stripTags($arrPost['frmCustomerScreenName']),
                'CustomerFirstName' => $objCore->stripTags($arrPost['frmCustomerFirstName']),
                'CustomerLastName' => $objCore->stripTags($arrPost['frmCustomerLastName']),
                'BillingFirstName' => $objCore->stripTags($arrPost['frmBillingFirstName']),
                'BillingLastName' => $objCore->stripTags($arrPost['frmBillingLastName']),
                'BillingOrganizationName' => $objCore->stripTags($arrPost['frmBillingOrganizationName']),
                'BillingAddressLine1' => $objCore->stripTags($arrPost['frmBillingAddressLine1']),
                'BillingAddressLine2' => $objCore->stripTags($arrPost['frmBillingAddressLine2']),
                'BillingCountry' => $objCore->stripTags($arrPost['frmBillingCountry']),
                'BillingPostalCode' => $objCore->stripTags($arrPost['frmBillingPostalCode']),
                'BillingPhone' => $objCore->stripTags($arrPost['frmBillingPhone']),
                'ShippingFirstName' => $objCore->stripTags($arrPost['frmShippingFirstName']),
                'ShippingLastName' => $objCore->stripTags($arrPost['frmShippingLastName']),
                'ShippingOrganizationName' => $objCore->stripTags($arrPost['frmShippingOrganizationName']),
                'ShippingAddressLine1' => $objCore->stripTags($arrPost['frmShippingAddressLine1']),
                'ShippingAddressLine2' => $objCore->stripTags($arrPost['frmShippingAddressLine2']),
                'ShippingCountry' => $objCore->stripTags($arrPost['frmShippingCountry']),
                'ShippingPostalCode' => $objCore->stripTags($arrPost['frmShippingPostalCode']),
                'ShippingPhone' => $objCore->stripTags($arrPost['frmShippingPhone']),
                'BusinessAddress' => $objCore->stripTags($arrPost['frmBusinessAddress']),
                'BillingTown' => $objCore->stripTags($arrPost['frmBillingTown']),
                'ShippingTown' => $objCore->stripTags($arrPost['frmShippingTown']),
                'ResAddressLine1' => $objCore->stripTags($arrPost['frmResAddressLine1']),
                'ResAddressLine2' => $objCore->stripTags($arrPost['frmResAddressLine2']),
                'ResPostalCode' => $objCore->stripTags($arrPost['frmResPostalCode']),
                'ResCountry' => $objCore->stripTags($arrPost['frmResCountry']),
                'ResTown' => $objCore->stripTags($arrPost['frmResTown']),
                'ResPhone' => $objCore->stripTags($arrPost['frmResPhone']),
            );
            $arrUpdateID = $this->update(TABLE_CUSTOMER, $arrClmsUpdate, $varWhr);

            $_SESSION['sessUserInfo']['screenName'] = $objCore->stripTags($arrPost['frmCustomerScreenName']);

            $objCore->setSuccessMsg(FRONT_USER_UPDATE_SUCCUSS_MSG);
            header('location:dashboard_customer_account.php');
            die;
        }
    }

    /**
     * function updateBillingShippingDetails
     *
     * This function is used update billing and shipping details.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string :
     */
    function updateBillingShippingDetails($arrPost)
    {
        $objCore = new Core();
        $varWhr = 'pkCustomerID = ' . $_SESSION['sessUserInfo']['id'];
        $arrClmsUpdate = array(
            'BillingFirstName' => $arrPost['frmBillingFirstName'],
            'BillingLastName' => $arrPost['frmBillingLastName'],
            'BillingOrganizationName' => $arrPost['frmBillingOrganizationName'],
            'BillingAddressLine1' => $arrPost['frmBillingAddressLine1'],
            'BillingAddressLine2' => $arrPost['frmBillingAddressLine2'],
            'BillingCountry' => $arrPost['frmBillingCountry'],
            'BillingPostalCode' => $arrPost['frmBillingPostalCode'],
            'BillingPhone' => $arrPost['frmBillingPhone'],
            'ShippingFirstName' => ($arrPost['frmShippingFirstName']),
            'ShippingLastName' => $arrPost['frmShippingLastName'],
            'ShippingOrganizationName' => $arrPost['frmShippingOrganizationName'],
            'ShippingAddressLine1' => $arrPost['frmShippingAddressLine1'],
            'ShippingAddressLine2' => $arrPost['frmShippingAddressLine2'],
            'ShippingCountry' => $arrPost['frmShippingCountry'],
            'ShippingPostalCode' => $arrPost['frmShippingPostalCode'],
            'ShippingPhone' => $arrPost['frmShippingPhone'],
            'BusinessAddress' => $arrPost['frmBusinessAddress']
        );

        $arrUpdateID = $this->update(TABLE_CUSTOMER, $arrClmsUpdate, $varWhr);
    }

    /**
     * function changeCustomerPassword
     *
     * This function is used to change password.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    function changeCustomerPassword($argArrPOST)
    {
        $objCore = new Core();
        $arrUserFlds = array('CustomerFirstName', 'CustomerPassword');
        $varUserWhere = ' 1 AND pkCustomerID = \'' . $_SESSION['sessUserInfo']['id'] . '\'';
        $arrUserList = $this->select(TABLE_CUSTOMER, $arrUserFlds, $varUserWhere);
//echo $arrUserList[0]['Password'];echo "<br/>";
//echo $argArrPOST['frmPassword'];die;
        if ($arrUserList[0]['CustomerPassword'] == md5(trim($argArrPOST['frmCurrentCustomerPassword'])))
        {

            if (md5(trim($argArrPOST['frmNewCustomerPassword'])) != md5(trim($argArrPOST['frmCurrentCustomerPassword'])))
            {
                $varUsersWhere = ' pkCustomerID =' . $_SESSION['sessUserInfo']['id'];
                $arrColumnAdd = array(
                    'CustomerPassword' => md5(trim($argArrPOST['frmNewCustomerPassword'])),
                );

                $varCustomerID = $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
//


                $objTemplate = new EmailTemplate();
                $objCore = new Core();
//pre($_SESSION);
                $varUserName = trim(strip_tags($_SESSION['sessUserInfo']['email']));
                $varFromUser = SITE_NAME;

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'Send Change Password to Customer' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}', '{NAME}', '{PASSWORD}', '{SITE_NAME}', '{USER_NAME}');

                $varKeywordValues = array($varPathImage, $arrUserList[0]['CustomerFirstName'], $argArrPOST['frmNewCustomerPassword'], SITE_NAME, $_SESSION['sessUserInfo']['email']);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function


                $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);

//
//$objCore->setSuccessMsg(FRONT_END_PASSWORD_SUCC_CHANGE);
                return true;
            }
            else
            {
                $objCore->setErrorMsg(FRONT_END_INVALID_NEW_PASSWORD);
                header('location:edit_my_password.php');
                die;
            }
        }
        else
        {
            $objCore->setErrorMsg(FRONT_END_INVALID_CURENT_PASSWORD);
            header('location:edit_my_password.php');
            die;
        }
    }

    /**
     * function changeResetPassword
     *
     * This function is used to reset password.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    function changeResetPassword($argArrPOST)
    {
        $objCore = new Core();
        $objCustomer = new Customer();
        $varUsersWhere = "CustomerEmail ='" . $argArrPOST['uid'] . "' ";
        $arrColumnAdd = array('CustomerPassword' => md5(trim($argArrPOST['frmNewCustomerPassword'])));

        $varCustomerID = $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
        $arrUserList = $this->select(TABLE_CUSTOMER, array('CustomerFirstName', 'CustomerLastName'), $varUsersWhere);


        $objTemplate = new EmailTemplate();
        $objCore = new Core();
//pre($_SESSION);
        $varUserName = trim(strip_tags($argArrPOST['uid']));
        $varFromUser = SITE_NAME;
        $name = $arrUserList[0]['CustomerFirstName'] . ' ' . $arrUserList[0]['CustomerLastName'];
        $varWhereTemplate = " EmailTemplateTitle= 'Send Change Password to Customer' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{NAME}', '{PASSWORD}', '{SITE_NAME}', '{USER_NAME}');

        $varKeywordValues = array($varPathImage, $name, $argArrPOST['frmNewCustomerPassword'], SITE_NAME, $argArrPOST['uid']);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function


        $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);
        $objCustomer->insCustomerForgotPWCode('', $varUserName);
//
//$objCore->setSuccessMsg(FRONT_END_PASSWORD_SUCC_CHANGE);
        return true;
    }

    /**
     * function userLogin
     *
     * This function is used to user login.
     *
     * Database Tables used in this function are : tbl_customer,tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    function userLogin($argArrPost)
    {

        $objCore = new Core();
        $shoppingCart = new ShoppingCart();
        $arrUserFlds = array('pkCustomerID', 'CustomerFirstName', 'CustomerScreenName', 'CustomerEmail', 'CustomerPassword', 'BusinessAddress', 'BillingCountry', 'ShippingCountry', 'CustomerStatus', 'IsEmailVerified', 'CustomerWebsiteVisitCount');
        $varUserWhere = " CustomerEmail = '" . stripcslashes(trim($argArrPost['frmUserEmail'])) . "' AND CustomerPassword = '" . md5(trim($argArrPost['frmUserpassword'])) . "'";
//print_r($varUserWhere);exit;

        $arrUserList = $this->select(TABLE_CUSTOMER, $arrUserFlds, $varUserWhere);

        if (count($arrUserList) > 0)
        {
            //pre($argArrPost);
            if ($arrUserList[0]['CustomerStatus'] == "Active" && $arrUserList[0]['IsEmailVerified'] == "1")
            {
                    
                if ($argArrPost['remember_me']=='yes')
                {
                    //echo 'rajuk';
                    
                    setcookie('email_id', $argArrPost['frmUserEmail'], time() + 3600, '/');
                    setcookie('password', $argArrPost['frmUserpassword'], time() + 3600, '/');
                    setcookie('remember_me', 'yes', time() + 3600, '/');
                }
                else
                {
                    
                    if (!empty($_COOKIE['email_id']))
                    {
                        setcookie('email_id', $argArrPost['frmUserEmail'], time() - 3600, '/');
                        setcookie('password', $argArrPost['frmUserpassword'], time() - 3600, '/');
                        setcookie('remember_me', 'yes', time() - 3600, '/');
                    }else{
                        setcookie('email_id', $argArrPost['frmUserEmail'], time() - 3600, '/');
                        setcookie('password', $argArrPost['frmUserpassword'], time() - 3600, '/');
                        setcookie('remember_me', 'yes', time() - 3600, '/');
                    }
                }

                if ($arrUserList[0]['BusinessAddress'] = "Billing")
                {
                    $varCountryId = $arrUserList[0]['BillingCountry'];
                }
                else
                {
                    $varCountryId = $arrUserList[0]['ShippingCountry'];
                }
                /*
                 * There is no need to find the timezone, This will mismatch when countries will be different for Users in support section.
                  $arrClms = array('country_id', 'time_zone',);
                  $varWhr = 'country_id = ' . $varCountryId;
                  $arrCustomerZone = $this->select(TABLE_COUNTRY, $arrClms, $varWhr);
                 */
                $_SESSION['sessUserInfo']['type'] = 'customer';
                $_SESSION['sessUserInfo']['email'] = $arrUserList[0]['CustomerEmail'];
                $_SESSION['sessUserInfo']['screenName'] = ($arrUserList[0]['CustomerScreenName'] == '') ? $arrUserList[0]['CustomerFirstName'] : $arrUserList[0]['CustomerScreenName'];
                $_SESSION['sessUserInfo']['id'] = $arrUserList[0]['pkCustomerID'];
                $_SESSION['sessUserInfo']['countryid'] = $varCountryId;

                // $_SESSION['sessTimeZone'] = $arrCustomerZone[0]['time_zone'];



                $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $arrUserList[0]['pkCustomerID'] . "'");

                //pre($arrCart);

                $row = '';
                foreach ($shoppingCart->myCartDetails() as $ItemType => $cartValues)
                {
                    foreach ($cartValues as $cartVal)
                    {

                        switch ($ItemType)
                        {
                            case 'Product':
                                $row.= '
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
                                  <td align="center" valign="top">' . $cartVal['FinalPrice'] . '</td>
                                 </tr>
                            ';
                                break;
                            case 'GiftCard':
                                $row.= '
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
                                $row.= '
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
                //pre($arrCart);
                if (isset($_SESSION['MyCart']) && $_SESSION['MyCart'] != '')
                { //echo 'hi';die;
                    if (count($arrCart) > 0)
                    {
                        $updateCartData = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));
                        //pre($updateCartData);
                        $sessionCartProduct = $_SESSION['MyCart']['Product'];
                        $sessionCartPackage = $_SESSION['MyCart']['Package'];
                        $sessionCartGiftCard = $_SESSION['MyCart']['GiftCard'];
                        if ((isset($_SESSION['MyCart']['Product']) && $_SESSION['MyCart']['Product'] <> '') || count($updateCartData['Product']) > 0)
                        {
                            foreach ($updateCartData['Product'] as $key => $val)
                            {
                                $sessionCartProduct[$key] = $val;
                            }
                            $_SESSION['MyCart']['Product'] = $sessionCartProduct;
                            $updateCartData1['Product'] = $_SESSION['MyCart']['Product'];
                        }
                        if ((isset($_SESSION['MyCart']['Package']) && $_SESSION['MyCart']['Package'] <> '') || count($updateCartData['Package']) > 0)
                        {
                            foreach ($updateCartData['Package'] as $key => $val)
                            {
                                $sessionCartPackage[$key] = $val;
                            }
                            $_SESSION['MyCart']['Package'] = $sessionCartPackage;
                            $updateCartData1['Package'] = $_SESSION['MyCart']['Package'];
                        }
                        if ((isset($_SESSION['MyCart']['GiftCard']) && $_SESSION['MyCart']['GiftCard'] <> '') || count($updateCartData['GiftCard']) > 0)
                        {
                            foreach ($updateCartData['GiftCard'] as $key => $val)
                            {
                                $sessionCartGiftCard[$key] = $val;
                            }
                            $_SESSION['MyCart']['GiftCard'] = $sessionCartGiftCard;
                            $updateCartData1['GiftCard'] = $_SESSION['MyCart']['GiftCard'];
                        }
                        $updateCartData1['Total'] = $_SESSION['MyCart']['Total'] + $updateCartData['Total'];

                        $row = $row . $arrCart[0]['CartDetails'];
                        //pre($updateCartData1);
                        $arrClmsUpdate = array(
                            'fkCustomerID' => $arrUserList[0]['pkCustomerID'],
                            'CartDetails' => $row,
                            'CartData' => serialize($updateCartData1),
                            'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
                        );
                        $argWhere = "fkCustomerID = '" . $arrUserList[0]['pkCustomerID'] . "' ";
                        $arrInsertID = $this->update(TABLE_CART, $arrClmsUpdate, $argWhere);
                    }
                    else
                    {
                        $arrClmsAdd = array(
                            'fkCustomerID' => $arrUserList[0]['pkCustomerID'],
                            'CartDetails' => $row,
                            'CartData' => serialize($_SESSION['MyCart']),
                            'CartReminderDate' => trim(date(DATE_TIME_FORMAT_DB)),
                            'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
                        );
                        $arrInsertID = $this->insert(TABLE_CART, $arrClmsAdd);
                    }
                }
                $arrCart1 = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $arrUserList[0]['pkCustomerID'] . "'");
                //pre($arrCart1);
                if (isset($arrCart1[0]['fkCustomerID']))
                {
                    $_SESSION['MyCart'] = unserialize(html_entity_decode($arrCart1[0]['CartData'], ENT_QUOTES));
                    //pre($_SESSION['MyCart']);
                }



                $varWhr = "pkCustomerID = '" . $arrUserList[0]['pkCustomerID'] . "'";
                $arrClms = array('CustomerWebsiteVisitCount' => ($arrUserList[0]['CustomerWebsiteVisitCount'] + 1));
                $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);

                if (isset($argArrPost['frmRef']))
                {
                    header('location:shipping_charge.php');
                    die;
                }
                else
                {
                    if (isset($_REQUEST['pid']) && $_REQUEST['pid'] <> '')
                    {
                        if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'wish')
                        {
                            $this->myWishlistAdd($_REQUEST['pid']);
                            $objCore->setSuccessMsg(WISHLIST_PRODUCT_ADD_SUCCUSS_MSG);
                        }
                        else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'rating')
                        {
                            $this->myRatingAdd($_REQUEST);
                            $objCore->setSuccessMsg(RATING_PRODUCT_SUCCUSS_MSG);
                        }
                        else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'review')
                        {
                            $this->userReviewAdd($_REQUEST);
                            $objCore->setSuccessMsg(FRONT_CUSTOMER_REVIEW_DISPLAY_MSG);
                        }

                        echo '
                            <script>
                            // parent.$.fancybox.close();
                            parent.window.location.href =  "' . $objCore->getUrl('product.php', array('id' => $_REQUEST['pid'], 'name' => $_REQUEST['name'], 'refNo' => $_REQUEST['refNo'])) . '";
                            </script>
                             ';
                        die;
                    }
                    else
                    {
                        echo '
                            <script>
                            // parent.$.fancybox.close();
                            parent.window.location.href =  "' . $objCore->getUrl('dashboard_customer_account.php') . '";
                            </script>
                             ';
                    }
                }
            }
            else
            {
//   $objCore->setErrorMsg(FRONT_CUSTOMER_DEACTIVE_ERROR_MSG);
                if ($arrUserList[0]['IsEmailVerified'] == 0)
                {
                    return EMAIL_NOT_VERIFIED_ERROR_MSG;
                }
                else
                {
                    return FRONT_CUSTOMER_DEACTIVE_ERROR_MSG;
                }
            }
        }
        else
        {
// $objCore->setErrorMsg(FRON_END_USER_LOGIN_ERROR);
            if (isset($argArrPost['frmRef']) || isset($_REQUEST['pid']))
            {
                return FRON_END_USER_LOGIN_ERROR1;
            }
            else
            {
                return FRON_END_USER_LOGIN_ERROR;
            }
        }
    }

    /**
     * function customerEmailVerification
     *
     * This function is used to customer email varification.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    function customerEmailVerification($argArrPost)
    {

        global $objGeneral;

        $objCore = new Core();
        $arrUserFlds = array('pkCustomerID', 'IsEmailVerified', 'CustomerPassword', 'CustomerFirstName', 'CustomerEmail', 'ReferBy', 'CustomerDateAdded', 'CustomerWebsiteVisitCount');

        $varData = $objGeneral->getEmailVerificationDecode($argArrPost['vcode']);

        $arrData = explode(',', $varData);

        $varUserWhere = " CustomerEmail = '" . $arrData['0'] . "' AND pkCustomerID = '" . $arrData[1] . "' AND CustomerDateAdded='" . $arrData[2] . "' ";

        $arrUserList = $this->select(TABLE_CUSTOMER, $arrUserFlds, $varUserWhere);

        if (count($arrUserList) > 0)
        {

            if ($arrUserList[0]['IsEmailVerified'] == '0')
            {
                $varWhr = "pkCustomerID = '" . $arrUserList[0]['pkCustomerID'] . "'";
                $arrClms = array('CustomerWebsiteVisitCount' => ($arrUserList[0]['CustomerWebsiteVisitCount'] + 1), 'CustomerStatus' => 'Active', 'IsEmailVerified' => '1');
                $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
                $this->sendEmailVerified($arrUserList[0]);

                $cid = 0;
                if ($arrUserList[0]['ReferBy'] > 0)
                {
                    $arrRefBy = $this->select(TABLE_CUSTOMER, array('pkCustomerID'), "ReferalID='" . $arrUserList[0]['ReferBy'] . "'");
                    $cid = (int) $arrRefBy[0]['pkCustomerID'];
                }
                $objGeneral->addRewards($cid, 'RewardOnReferal');
                // $objCore->setSuccessMsg(FRON_EMAIL_VERIFICATION_SUCCESS);
                return 1;
            }
            else
            {
                return 2;
            }
        }
        else
        {
            return 0;
            //$objCore->setErrorMsg(FRON_EMAIL_VERIFICATION_ERROR);
        }
    }

    /**
     * function sendEmailVerified
     *
     * This function is used display send notification email for verified.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    function sendEmailVerified($arrPost)
    {

        global $objGeneral;
        $objCore = new Core();
        $objTemplate = new EmailTemplate();

        $varUserName = trim(strip_tags($arrPost['CustomerEmail']));
        $varFromUser = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'EmailVerified' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{CUSTOMER}');

        $varKeywordValues = array($varPathImage, SITE_NAME, ucfirst($arrPost['CustomerFirstName']));

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function
        $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);
    }

    /**
     * function supportList
     *
     * This function is used to support list.
     *
     * Database Tables used in this function are : tbl_support_ticket_type
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function supportList()
    {
        $arrClms = array(
            'pkTicketID',
            'TicketTitle',
        );
//$varOrderBy = 'pkTicketID DESC';
        $arrRes = $this->select(TABLE_SUPPORT_TICKET_TYPE, $arrClms);
        return $arrRes;
    }

    /**
     * function addCustomerSupport
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_customer, tbl_admin, tbl_support
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     */
    function addCustomerSupport($arrPost)
    {
//pre($arrPost);
//pre($_SESSION);
        $objCore = new Core();
        global $objGeneral;

        if ($arrPost['frmToUserType'] == "Admin")
        {
            $arrClms = array(
                'BusinessAddress',
                'BillingCountry',
                'ShippingCountry',
            );
            $varWhr = 'pkCustomerID = ' . $_SESSION['sessUserInfo']['id'];
            $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $varWhr);
            if ($arrRes['BusinessAddress'] == "Billing")
            {
                $arrClms2 = array(
                    'pkAdminID',
                );
                $varWhr2 = 'AdminCountry = ' . $arrRes['BillingCountry'];
                $arrRes = $this->select(TABLE_ADMIN, $arrClms2, $varWhr2);
            }
            else if ($arrRes['BusinessAddress'] == "Shipping")
            {
                $arrClms2 = array(
                    'pkAdminID',
                );
                $varWhr2 = 'AdminCountry = ' . $arrRes['ShippingCountry'];
                $arrRes = $this->select(TABLE_ADMIN, $arrClms2, $varWhr2);
            }

            if (count($varfkToUserID) > 0)
            {
                $varfkToUserID = $arrPost['pkAdminID'];
            }
            else
            {
                $varfkToUserID = 1;
            }
        }
        else if ($arrPost['frmToUserType'] == "Wholesaler")
        {
            $varfkToUserID = $arrPost['frmfkToUserID'];
        }
// pre($arrRes2);
        //echo date(DATE_TIME_FORMAT_DB);
        $arrClms = array(
            'FromUserType' => "customer",
            'fkFromUserID' => $_SESSION['sessUserInfo']['id'],
            'ToUserType' => $objCore->stripTags($arrPost['frmToUserType']),
            'fkToUserID' => $varfkToUserID,
            'SupportType' => $objCore->stripTags($arrPost['frmSupportType']),
            'Subject' => $objCore->stripTags($arrPost['frmSubject']),
            'Message' => $objCore->stripTags($arrPost['frmMessage']),
            'SupportDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
//pre($arrClms);

        $arrAddID = $this->insert(TABLE_SUPPORT, $arrClms);
        $this->update(TABLE_SUPPORT, array('fkParentID' => $arrAddID), " pkSupportID='" . $arrAddID . "'");

        $objGeneral->sendSupportEmail($arrAddID);

        $objCore->setSuccessMsg(FRONT_SUPPORT_SUCCUSS_MSG);
        return $arrAddID;
    }

    /**
     * function customerOutboxSupportList
     *
     * This function is used to get customer outbox support list.
     *
     * Database Tables used in this function are : tbl_support, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrAddID
     */
    function customerOutboxSupportList()
    {
        $arrClms = array(
            'fkParentID',
            'pkSupportID',
            'SupportType',
            'Subject',
            'Message',
            'CompanyName', 'SupportDateAdded'
        );
        $argWhere = "fkFromUserID='" . $_SESSION['sessUserInfo']['id'] . "' AND ToUserType <> 'customer' AND DeletedBy!=fkFromUserID";
        $varOrderBy = 'pkSupportID DESC';
        $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkToUserID = pkWholesalerID ";
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
// pre($arrRes);
//pre($arrRes);
        return $arrRes;
    }

    /**
     * function givMessageRead
     *
     * This function is used to change the message status for read ,unread.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $VarRst
     */
    function givMessageRead($mgsid)
    {

        $varID = "pkSupportID ='" . $mgsid . "'";
        $varTable = TABLE_SUPPORT;
        $varArrUpdate = array('IsRead' => '1');

        $VarRst = $this->update($varTable, $varArrUpdate, $varID);

        return $VarRst;
    }

    /**
     * function customerOutboxSupportList
     *
     * This function is used to get customer inbox support list.
     *
     * Database Tables used in this function are : tbl_support, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function customerInboxSupportList()
    {
        $arrClms = array(
            'fkParentID',
            'pkSupportID',
            'SupportType',
            'Subject',
            'Message',
            'CompanyName',
            'FromUserType', 'IsRead', 'SupportDateAdded'
        );
        $argWhere = "fkToUserID='" . $_SESSION['sessUserInfo']['id'] . "' AND ToUserType = 'customer' AND DeletedBy!=fkToUserID";
        $varOrderBy = 'pkSupportID DESC';
        $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkFromUserID = pkWholesalerID ";
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);

//pre($arrRes);
        return $arrRes;
    }

    /**
     * function messageRemove
     *
     * This function is used remove message.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varAffected
     */
    function messageRemove($argPostIDs, $cid)
    {
        $core = new Core();
        if ($core->messageDeleteRequired($argPostIDs['frmID']) == true)
        {

            $varWhereSdelete = " pkSupportID = '" . $argPostIDs['frmID'] . "' AND ((ToUserType='customer' AND fkToUserID = '" . $cid . "') OR (FromUserType='customer' AND fkFromUserID = '" . $cid . "'))";
            $varAffected = $this->delete(TABLE_SUPPORT, $varWhereSdelete);
            return $varAffected;
        }
        else
        {
            $arr = array('DeletedBy' => $cid);
            $varWhereSdelete = "pkSupportID = '" . $argPostIDs['frmID'] . "'";
            $varAffected = $this->update(TABLE_SUPPORT, $arr, $varWhereSdelete);
            return $varAffected;
        }
    }

    /**
     * function outboxMessageViewById
     *
     * This function is used display output message.
     *
     * Database Tables used in this function are : tbl_support, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function outboxMessageViewById($argPostIDs, $cid)
    {
        $arrClms = array(
            'pkSupportID',
            'fkParentID',
            'SupportType',
            'Subject',
            'Message',
            'CompanyName',
            'FromUserType',
            'fkFromUserID',
            'ToUserType',
            'fkToUserID',
            'SupportDateAdded',
        );
        $argWhere = "pkSupportID='" . $argPostIDs . "' AND FromUserType = 'customer' AND fkFromUserID='" . $cid . "'";
        $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkToUserID = pkWholesalerID ";
        $arrRes = $this->select($varTable, $arrClms, $argWhere);

        if ($arrRes[0]['fkParentID'] > 0)
        {
            $varWhere = " (fkParentID = " . $arrRes[0]['fkParentID'] . " OR pkSupportID =" . $arrRes[0]['fkParentID'] . ") AND pkSupportID <=" . $argPostIDs . " ";
            $varOrderBy = "SupportDateAdded DESC";
            $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkToUserID = pkWholesalerID ";
            $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy);
        }
        return $arrRes;
    }

    /**
     * function inboxMessageViewById
     *
     * This function is used get inbox messages viewed.
     *
     * Database Tables used in this function are : tbl_support, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function inboxMessageViewById($argPostIDs, $cid)
    {
        $arrClms = array(
            'pkSupportID',
            'fkParentID',
            'SupportType',
            'Subject',
            'Message',
            'CompanyName',
            'FromUserType',
            'fkFromUserID',
            'ToUserType',
            'fkToUserID',
            'SupportDateAdded',
        );

        $argWhere = "pkSupportID='" . $argPostIDs . "' AND ToUserType = 'customer' AND fkToUserID = '" . $cid . "'";

        $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkFromUserID = pkWholesalerID ";
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        if ($arrRes[0]['fkParentID'] > 0)
        {
            $varWhere = " (fkParentID = " . $arrRes[0]['fkParentID'] . " OR pkSupportID =" . $arrRes[0]['fkParentID'] . ") AND pkSupportID <='" . $argPostIDs . "' ";
            $varOrderBy = "SupportDateAdded DESC";
            $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkFromUserID = pkWholesalerID ";
            $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy);
        }

//pre($arrRes);
        return $arrRes;
    }

    /**
     * function getWishlistProducts
     *
     * This function is used get wishlist products.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_today_offer, tbl_product_rating, tbl_review, tbl_wishlist,
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function getWishlistProducts($cid, $limit = '')
    {

        $limit = ($limit <> '') ? ' LIMIT ' . $limit : '';


        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,Quantity,ProductDescription,fkWholesalerID,CompanyName,ProductImage,OfferPrice, pkWishlistId,WishlistDateAdded, avg(Rating) AS Rating,count(pkReviewID) AS customerReviews
            FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1') INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TODAY_OFFER . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_WISHLIST . " as wl ON pkProductID = wl.fkProductId LEFT JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID LEFT JOIN " . TABLE_REVIEW . " AS rev  ON pkProductID=rev.fkProductID
            WHERE fkUserId='" . $cid . "'
            Group By pkProductID ORDER BY WishlistDateAdded DESC " . $limit;

        $arrRes = $this->getArrayResult($varQuery);


        foreach ($arrRes AS $key => $prod)
        {
            $varQuery = "SELECT ImageName FROM " . TABLE_PRODUCT_IMAGE . " WHERE fkProductID = '" . $prod['pkProductID'] . "'";
            $arrProdImg = $this->getArrayResult($varQuery);

            $arrAttributes = $this->getAttributeDetails($prod['pkProductID']);
            $arrRes[$key]['attributes'] = count($arrAttributes);
            $arrRes[$key]['arrproductImages'] = $arrProdImg;
            $arrRes[$key]['arrAttributes'] = $arrAttributes;
        }
//pre($arrRes);

        return $arrRes;
    }

    /**
     * function getAttributeDetails
     *
     * This function is used to get Attribute Details for products.
     *
     * Database Tables used in this function are : tbl_product_to_option ,tbl_attribute, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getAttributeDetails($argPId = 0)
    {
        $varQuery2 = "SELECT pkAttributeId,AttributeLabel,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle, GROUP_CONCAT(pkOptionID) as pkOptionID, AttributeOptionValue FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId WHERE fkProductId = '" . $argPId . "' AND `AttributeVisible`='yes' GROUP BY pkAttributeId ASC";
        $arrRes = $this->getArrayResult($varQuery2);
        return $arrRes;
    }

    /**
     * function addWishToCart
     *
     * This function is used add wishlist product to the cart.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function addWishToCart($pid, $wishId)
    {
        if (isset($_SESSION['MyCart']['Product'][$pid]))
        {
            $_SESSION['MyCart']['Product'][$pid]['qty'] += 1;
        }
        else
        {
            $_SESSION['MyCart']['Product'][$pid]['qty'] = 1;
        }
        $_SESSION['MyCart']['Total'] += 1;

        $varWhereSdelete = " pkWishlistId =" . $wishId;
        $varAffected = $this->delete(TABLE_WISHLIST, $varWhereSdelete);
        return $varAffected;
    }

    /**
     * function getCustomerOrderlist
     *
     * This function is used to get customer order list.
     *
     * Database Tables used in this function are : tbl_order, tbl_order_items, tbl_order_total
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function getCustomerOrderlist($cid, $limit)
    {
      //  echo "hii";die;
        $limit = $limit ? "LIMIT {$limit}" : '';
        $varID = "o.fkCustomerID = '" . $cid . "' ";
       // $query = "SELECT o.pkOrderID,SubOrderID,o.TransactionID,o.fkCustomerID,o.CustomerFirstName,o.CustomerLastName,o.OrderStatus,o.OrderDateAdded,ot.Amount,Status as status FROM " . TABLE_ORDER . " as o INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON (o.pkOrderID = oi.fkOrderID AND {$varID}) LEFT JOIN " . TABLE_ORDER_TOTAL . " as ot ON (o.pkOrderID = ot.fkOrderID AND ot.Code='total') GROUP BY pkOrderID,Status,fkWholesalerID order by o.pkOrderID desc {$limit}";
        $query = "SELECT o.pkOrderID,SubOrderID,o.TransactionID,o.fkCustomerID,o.CustomerFirstName,o.CustomerLastName,o.OrderStatus,o.OrderDateAdded,oi.ItemTotalPrice as Amount,Status as status FROM " . TABLE_ORDER . " as o INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON (o.pkOrderID = oi.fkOrderID AND {$varID}) LEFT JOIN " . TABLE_ORDER_TOTAL . " as ot ON (o.pkOrderID = ot.fkOrderID ) GROUP BY pkOrderID,Status,fkWholesalerID order by o.pkOrderID desc {$limit}";
      //  echo $query;die;
        //SELECT o.pkOrderID, SubOrderID, o.TransactionID, o.fkCustomerID, o.CustomerFirstName, o.CustomerLastName, o.OrderStatus, oi.ItemTotalPrice, o.OrderDateAdded, 
//STATUS AS 
//STATUS FROM tbl_order AS o
//INNER JOIN tbl_order_items AS oi ON ( o.pkOrderID = oi.fkOrderID
//AND o.fkCustomerID =  '98' ) 
//LEFT JOIN tbl_order_total AS ot ON ( o.pkOrderID = ot.fkOrderID ) 
//GROUP BY pkOrderID, 
//STATUS , fkWholesalerID
//ORDER BY o.pkOrderID DESC 
//LIMIT 0 , 12
        $arrRes = $this->getArrayResult($query);
//        echo "<pre>";
//        print_r($arrRes);die;
        foreach ($arrRes as $key => $val)
        {
            $arrRows = $this->getInvoiceDetails($val['pkOrderID'], $cid);
            $arrRes[$key]['invoice'] = count($arrRows[0]);
            $arrRes[$key]['invoices'] = $arrRows;
            //$arrRes[$key]['status'] = $this->getOrderStatus($val['status']);
        }

        return $arrRes;
    }
    

    /**
     * function getCustomerOrderNum
     *
     * This function is used to get num of records.
     *
     * Database Tables used in this function are : tbl_order, tbl_order_total
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function getCustomerOrderNum($cid)
    {
       // echo "yes";die;
        $varID = "o.fkCustomerID = '" . $cid . "' ";
        $query = "SELECT count(o.pkOrderID) as numRows FROM " . TABLE_ORDER . " as o LEFT JOIN " . TABLE_ORDER_TOTAL . " as ot ON o.pkOrderID = ot.fkOrderID WHERE {$varID} AND Code='total'";
        $arrRes = $this->getArrayResult($query);
        return $arrRes[0]['numRows'];
    }

    /**
     * function getOrderStatus
     *
     * This function is used to get current status of an order.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function getOrderStatus($status)
    {

        $arrSt = explode(',', $status);
        $varNum = count($arrSt);
        $arrStUni = array_unique($arrSt);
        $varUniNum = count($arrStUni);
        if ($varNum == $varUniNum)
        {
            rsort($arrStUni);
            $varSt = $arrStUni[0];
        }
        else
        {
            $varSt = ($varUniNum == 1) ? $arrStUni[0] : 'Partial Completed';
        }
        return $varSt;
    }

    /**
     * function getOrderProducts
     *
     * This function is used get order product details.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getOrderProducts($oid)
    {
        /* $arrClms1 = array('c.pkOrderItemID,c.SubOrderID,c.fkItemID', 'ItemType', 'c.ItemName', 'c.ItemImage', 'c.fkWholesalerID', 'c.fkOrderID', 'c.ItemPrice', 'AttributePrice', 'c.Quantity', 'c.ItemTotalPrice', 'c.Status', 'c.DisputedStatus', 'c.DiscountPrice', 'c.ShippingPrice', 'ItemDetails');
          $varTable1 = TABLE_ORDER_ITEMS . ' as c'; */
        $arrClms1 = array('pkOrderItemID', 'SubOrderID', 'fkItemID', 'ItemType', 'ItemName', 'ItemImage', 'fkWholesalerID', 'fkOrderID', 'ItemPrice', 'AttributePrice', 'Quantity', 'ItemTotalPrice', 'Status', 'DisputedStatus', 'DiscountPrice', 'ShippingPrice', 'ItemDetails');
        $varTable1 = TABLE_ORDER_ITEMS;
        $varID1 = " fkOrderID = '" . $oid . "' ";
        $arrRes = $this->select($varTable1, $arrClms1, $varID1);
        $cid = $_SESSION['sessUserInfo']['id'];

        $arrDisputedCommentHistory = $this->disputedCommentsHistory($oid);


        foreach ($arrRes as $k => $v)
        {
            $varFD = $this->checkCustomerFedback($cid, $v);
            $arrRes[$k]['pkFeedbackID'] = $varFD[0];
            $arrRes[$k]['FeedbackPIDs'] = $varFD[1];

            $arrRes[$k]['arrDisputedCommentsHistory'] = $arrDisputedCommentHistory[$v['SubOrderID']];

            if ($v['ItemType'] <> 'gift-card')
            {
                $jsonDet = json_decode(html_entity_decode($v['ItemDetails']));
                $varDet = '';
                foreach ($jsonDet as $jk => $jv)
                {
                    $varDet .= $jv->ProductName;
                    $arrCols = array('AttributeLabel', 'OptionValue');
                    $argWhr = " fkOrderItemID = '" . $v['pkOrderItemID'] . "' AND fkProductID = '" . $jv->pkProductID . "'";
                    $arrOpt = $this->select(TABLE_ORDER_OPTION, $arrCols, $argWhr);
                    $num = count($arrOpt);
                    if ($num > 0)
                    {
                        $varDet .= ' (';
                        $i = 1;
                        foreach ($arrOpt as $ok => $ov)
                        {

                            $varDet .= $ov['AttributeLabel'] . ': ' . str_replace('@@@', ',', $ov['OptionValue']);
                            if ($i < $num)
                                $varDet .=' | ';
                            $i++;
                        }

                        $varDet .= ')';
                        $varDet .= '<br />';
                    } else
                    {
                        $varDet = '';
                    }
                }
                $arrRes[$k]['OptionDet'] = $varDet;
            }
            else
            {
                $arrRes[$k]['OptionDet'] = 'Gift Card';
            }

            $arrRes[$k]['ShipTrackDetail'] = $this->getShipmentDetails($v['pkOrderItemID']);
        }
//pre($arrRes);
        return $arrRes;
    }

    /**
     * function getDisputedCommentList
     *
     * This function is used to get disputted comments.
     *
     * Database Tables used in this function are : tbl_disputed_comment_list
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getDisputedCommentList()
    {
        $arrClms = array('CommentID', 'Title');
        $varID = "1";
        $varOrderBy = 'CommentID ASC ';
        $arrRes = $this->select(TABLE_DISPUTED_COMMENT_LIST, $arrClms, $varID, $varOrderBy);
        return $arrRes;
    }

    /**
     * function getOrderTotal
     *
     * This function is used to get order total.
     *
     * Database Tables used in this function are : tbl_order_total
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getOrderTotal($oid)
    {
        $arrClms = array('Code', 'Title', 'Amount');
        $varTable = TABLE_ORDER_TOTAL;
        $varID = "fkOrderID = '" . $oid . "'";
        $varOrderBy = 'SortOrder ASC ';
        $arrRes = $this->select($varTable, $arrClms, $varID, $varOrderBy);
//        /pre($arrRes);
        return $arrRes;
    }

    /**
     * function getCustomerDetails
     *
     * This function is used customer details.
     *
     * Database Tables used in this function are : tbl_order, tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getCustomerDetails($oid, $cid)
    {
        $arrClms = array('a.*', 'd.name as BillingCountryName', 'e.name as ShipingCountryName');
        $varTable = TABLE_ORDER . ' as a LEFT JOIN ' . TABLE_COUNTRY . ' as d ON d.country_id=a.BillingCountry LEFT JOIN ' . TABLE_COUNTRY . ' as e ON e.country_id=a.ShippingCountry';
        $varID = "pkOrderID = '" . $oid . "' AND fkCustomerID ='" . $cid . "'";
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes;
    }

    /**
     * function getOrderComments
     *
     * This function is used to get order comments.
     *
     * Database Tables used in this function are : tbl_order_comments, tbl_customer, tbl_wholesaler, tbl_admin
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function getOrderComments($oid)
    {
        $varID = "fkOrderID = '" . (int) $oid . "' ";
        $arrClms = array('pkOrderCommentID', 'CommentedBy', 'CommentedID', 'Comment', 'CommentDateAdded', 'AdminUserName as adminName', 'CompanyName as wholesalerName', 'CustomerFirstName as customerName');
        $varOrder = " pkOrderCommentID ASC";
        $varTable = TABLE_ORDER_COMMENTS . " LEFT JOIN " . TABLE_CUSTOMER . " ON CommentedID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON CommentedID = pkWholesalerID LEFT JOIN " . TABLE_ADMIN . " ON CommentedID=pkAdminID";
        $arrRes = $this->select($varTable, $arrClms, $varID, $varOrder);
        return $arrRes;
    }

    /**
     * function checkCustomerFedback
     *
     * This function is used to check customer feedbacks.
     *
     * Database Tables used in this function are : tbl_wholesaler_feedback
     *
     * @access public
     *
     * @parameters 3 string
     *
     * @return string $arrRes
     */
    function checkCustomerFedback($cid, $arrV, $pid = 0, $oid = 0)
    {

        if ($arrV['ItemType'] <> 'gift-card')
        {
            $arrItemDetails = json_decode(html_entity_decode($arrV['ItemDetails']));

            $varPIDS = array();

            foreach ($arrItemDetails as $v)
            {
                $varPIDS[] = $v->pkProductID;
            }

            $pid = implode(',', $varPIDS);

            $arrClms1 = array('pkFeedbackID');
            $varTable1 = TABLE_WHOLESALER_FEEDBACK;
            $varID1 = "fkCustomerID = '" . $cid . "'  AND fkProductID in (" . $pid . ") AND fkOrderID='" . $arrV['fkOrderID'] . "' ";
            $arrRes1 = $this->select($varTable1, $arrClms1, $varID1);
            $varIs[0] = empty($arrRes1) ? 0 : 1;
            $varIs[1] = $pid;
        }
        else
        {
            $varIs = array(1, 0);
        }

        return $varIs;
    }

    /**
     * function postCustomerFeedback
     *
     * This function is used to get customer feedbacks.
     *
     * Database Tables used in this function are : tbl_wholesaler_feedback
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrAddID
     */
    function postCustomerFeedback()
    {
        global $objCore;
        global $objGeneral;

        $cid = $_SESSION['sessUserInfo']['id'];
        $wid = $_POST['wholesalerID'];
       // $logid = $_POST['logisticID'];
        $pid = $_POST['productID'];
        $feedbackType = 0;
        $counter=0;
        if ($_POST['Question1']){
        $counter+=1;    
        }
        if ($_POST['Question2']){
        $counter+=1;    
        }
        if ($_POST['Question3']){
        $counter+=1;    
        }
        if ($counter>=2)
        {
            $feedbackType = 1;
        }
        else
        {

            $this->sendWarnigEmail($_POST['wholesalerID']);
        }

        $arrPids = explode(',', $pid);
        foreach ($arrPids as $v)
        {
            $arrClms = array(
                'fkWholesalerID' => $wid,
                'fkCustomerID' => $cid,
                'fkProductID' => $v,
                'fkOrderID' => $_POST['orderID'],
                'Question1' => $_POST['Question1'],
                'Question2' => $_POST['Question2'],
                'Question3' => $_POST['Question3'],
                'Comment' => $objCore->stripTags($_POST['comments']),
                'IsPositive' => $feedbackType,
                'FeedbackDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $arrAddID = $this->insert(TABLE_WHOLESALER_FEEDBACK, $arrClms);
        }

        $objGeneral->addRewards($arrClms['fkCustomerID'], 'RewardOnOrderFeedback');

        return $arrAddID;
    }

    /**
     * function sendWarnigEmail
     *
     * This function is used to send warning emails.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_wholesaler_warning
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string :
     */
    function sendWarnigEmail($argToID)
    {

        global $objGeneral;


        $arrUserFlds = array('CompanyEmail', 'CompanyName', 'CompanyCountry');
        $varUserWhere = " pkWholesalerID = '" . $argToID . "' ";
        $arrUserList = $this->select(TABLE_WHOLESALER, $arrUserFlds, $varUserWhere);

        $arrWarningList = $this->select(TABLE_WHOLESALER_WARNING, array('pkWarningID'), "  fkWholesalerID='" . $argToID . "'");
        $varNumWarn = count($arrWarningList) + 1;
        $varkpi = $objGeneral->wholesalerKpi($argToID);
        $kpi = $varkpi['kpi'];

        if ($varNumWarn < 4 && $kpi == 'N/A')
        {

            $objTemplate = new EmailTemplate();
            $objCore = new Core();
            $objCustomer = new Customer();
            if (count($arrUserList) > 0)
            {

                $arrClms = array('fkWholesalerID' => $argToID, 'WarningText' => $varNumWarn . ' Warning Letter', 'WarningDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
                $arrAddID = $this->insert(TABLE_WHOLESALER_WARNING, $arrClms);

                $varToUser = trim(strip_tags($arrUserList[0]['CompanyEmail']));

                $varFromUser = SITE_NAME;

                $varSiteName = SITE_NAME;
                $varWhereTemplate = " EmailTemplateTitle= '" . $varNumWarn . "WarningToWholesalerByAdmin' AND EmailTemplateStatus = 'Active'";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));


                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
                $varSendDate = $objCore->serverDateTime(date('d-m-Y'), DATE_FORMAT_SITE);

                $varKeyword = array('{IMAGE_PATH}', '{SENDDATE}', '{WHOLESALER}', '{WHOLESALER}', '{CURRENTKPI}', '{SITE_NAME}');

                $varKeywordValues = array($varPathImage, $varSendDate, $arrUserList[0]['CompanyName'], $arrUserList[0]['CompanyName'], $kpi, SITE_NAME);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function
                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
            }
        }
    }

    /**
     * function sendWholesalerWarning
     *
     * This function is used send warning emails.
     *
     * Database Tables used in this function are : tbl_wholesaler_warning
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     */
    function sendWholesalerWarning($wid)
    {
        global $objCore;
        $arrClms = array('fkWholesalerID' => $wid, 'WarningText' => '', 'WarningDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
        $arrAddID = $this->insert(TABLE_WHOLESALER_WARNING, $arrClms);
        return $arrAddID;
    }

    /**
     * function customerReoder
     *
     * This function is used to reorder customer product.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function customerReoder($pid)
    {
        if (isset($_SESSION['MyCart']['Product'][$pid]))
        {
            $_SESSION['MyCart']['Product'][$pid]['qty'] += 1;
        }
        else
        {
            $_SESSION['MyCart']['Product'][$pid]['qty'] = 1;
        }
        $_SESSION['MyCart']['Total'] += 1;
        return $arrRes;
    }

    /**
     * function replyMessage
     *
     * This function is used to reply message.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string TRUE
     */
    function replyMessage($arrPost)
    {
        $objCore = new Core();
        if ($arrPost['fkParentID'] == 0)
        {
            $varParent = $arrPost['fkSupportID'];
        }
        else
        {
            $varParent = $arrPost['fkParentID'];
        }

        $arrClms = array(
            'fkFromUserID' => $_SESSION['sessUserInfo']['id'],
            'fkParentID' => $varParent,
            'fkToUserID' => $objCore->stripTags($arrPost['fkToUserID']),
            'FromUserType' => 'customer',
            'Subject' => $objCore->stripTags($arrPost['frmSubject']),
            'Message' => $objCore->stripTags($arrPost['frmMessage']),
            'SupportType' => $objCore->stripTags($arrPost['frmMessageType']),
            'ToUserType' => $objCore->stripTags($arrPost['frmToUserType']),
            'SupportDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_SUPPORT, $arrClms);
        $objCore->setSuccessMsg(FRONT_SUPPORT_SUCCUSS_MSG);
        return TRUE;
    }

    /**
     * function getMessageThread
     *
     * This function is used to get message thread.
     *
     * Database Tables used in this function are : tbl_support_reply
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRow
     */
    function getMessageThread($mgsid)
    {
        $varID = 'fkSupportID =' . $mgsid;
        $varOrderBy = 'ReplyDateAdded ASC ';
        $arrClms = array(
            'ReplySubject', 'ReplyMessage', 'pkReplyID', 'fkFromID', 'fkToID', 'fkSupportID', 'ReplyDateAdded'
        );
        $varTable = TABLE_SUPPORT_REPLY;
        $arrRow = $this->select($varTable, $arrClms, $varID, $varOrderBy);
        return $arrRow;
    }

    /**
     * function sendForgotPasswordEmail
     *
     * This function is used send forgot password emails.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string :
     */
    function sendForgotPasswordEmail($argArrPOST)
    {
        //pre($argArrPOST);
        $arrUserFlds = array('pkCustomerID', 'CustomerFirstName', 'CustomerLastName');
        $varUserWhere = "CustomerEmail = '" . stripcslashes($argArrPOST['frmUserEmail']) . "' AND CustomerStatus = 'active'  ";
        $arrUserList = $this->select(TABLE_CUSTOMER, $arrUserFlds, $varUserWhere);
        $objTemplate = new EmailTemplate();
        $objCore = new Core();
        $objCustomer = new Customer();
        if (count($arrUserList) > 0)
        {

            $varToUser = trim(strip_tags($argArrPOST['frmUserEmail']));
            $better_token = uniqid(md5(rand()), true);
            $objCustomer->insCustomerForgotPWCode($better_token, $varToUser);

            $varForgotPasswordLink = '<a href="' . SITE_ROOT_URL . 'reset_password.php?uid=' . $varToUser . '&code=' . $better_token . '">' . SITE_ROOT_URL . 'reset_password.php?uid=' . $varToUser . '&code=' . $better_token . '</a>';

            $varFromUser = SITE_NAME;
            $name = $arrUserList[0]['CustomerFirstName'] . ' ' . $arrUserList[0]['CustomerLastName'];
            $varWhereTemplate = ' EmailTemplateTitle= binary \'Customer forgot password\' AND EmailTemplateStatus = \'Active\' ';

            $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

            $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));


            $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));
            $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

            $varSubject = str_replace('{PROJECT_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

            $varKeyword = array('{SITE_NAME}', '{IMAGE_PATH}', '{NAME}', '{PROJECT_NAME}', '{FORGOT_PWD_LINK}');

            $varKeywordValues = array(SITE_NAME, $varPathImage, $name, SITE_NAME, $varForgotPasswordLink);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

            $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
            echo 1;
            //echo FRONT_END_FORGET_PASSWORD_SUCCESS_MSG;
            //$objCore->setSuccessMsg('<span>' . FRONT_END_FORGET_PASSWORD_SUCCESS_MSG . '</span>');
            //echo '<script>parent.window.location.href = "'.SITE_ROOT_URL.'index.php";</script>';
            die;
        }
        else
        {
            echo 0;
            //echo FRONT_END_FORGET_PASSWORD_ERROR_MSG;
        }
    }

    /**
     * function insCustomerForgotPWCode
     *
     * This function is used get forgot password code.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 2 string optional
     *
     * @return string :
     */
    function insCustomerForgotPWCode($varToken = '', $varEmailId = '')
    {
        $varWhr = "CustomerEmail = '" . $varEmailId . "' ";

        $arrClmsUpdate = array(
            'CustomerForgotPWCode' => $varToken,
        );
        $arrUpdateID = $this->update(TABLE_CUSTOMER, $arrClmsUpdate, $varWhr);
    }

    /**
     * function checkCustomerForgotPWCode
     *
     * This function is used check customer frgot password code.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string optional
     *
     * @return string $arrRow
     */
    function checkCustomerForgotPWCode($argArrPOST)
    {
        $arrUserFlds = array('pkCustomerID');
        $varUserWhere = " 1 AND CustomerEmail = '" . $argArrPOST['uid'] . "' AND CustomerForgotPWCode = '" . $argArrPOST['code'] . "' AND CustomerStatus = 'active' ";
//print_r($varUserWhere);exit;
        $arrUserList = $this->select(TABLE_CUSTOMER, $arrUserFlds, $varUserWhere);
        $arrRow = count($arrUserList);
        return $arrRow;
    }

    /**
     * function myWishlistAdd
     *
     * This function is used to add my wishlist.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string optional
     *
     * @return string $arrAddID
     */
    function myWishlistAdd($_arrPostId)
    {
//pre($_SESSION);
        global $objCore;
        $whereWith = "fkProductId='" . $_arrPostId . "' AND fkUserId='" . $_SESSION['sessUserInfo']['id'] . "'";
        $verifyWishlist = $this->select(TABLE_WISHLIST, array('pkWishlistId'), $whereWith);
        if (count($verifyWishlist) == 0)
        {
            $arrClms = array(
                'fkUserId' => $_SESSION['sessUserInfo']['id'],
                'fkProductId' => $_arrPostId,
                'WishlistDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $arrAddID = $this->insert(TABLE_WISHLIST, $arrClms);
        }
        return $arrAddID;
    }

    /**
     * function myRatingAdd
     *
     * This function is used to add my ratings.
     *
     * Database Tables used in this function are : tbl_product_rating
     *
     * @access public
     *
     * @parameters 1 string optional
     *
     * @return string $arrRes
     */
    function myRatingAdd($_arrPost)
    {
        global $objCore;
        $varQuery2 = "select pkRateID from " . TABLE_PRODUCT_RATING . " where fkProductID = " . $_arrPost['pid'] . " AND fkCustomerID = " . $_SESSION['sessUserInfo']['id'] . "";
        $arrRes2 = $this->getArrayResult($varQuery2);
        if (count($arrRes2) == 0)
        {
            $arrClms = array(
                'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
                'fkProductID' => $_arrPost['pid'],
                'Rating' => $_arrPost['frmval'],
                'RateDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
//pre($arrPost);

            $arrRes = $this->insert(TABLE_PRODUCT_RATING, $arrClms);
            return $arrRes;
        }
        else
        {
            $varQuery = "UPDATE " . TABLE_PRODUCT_RATING . " set Rating ='" . $_arrPost['frmval'] . "' where fkProductID = " . $_arrPost['pid'] . " AND fkCustomerID = " . $_SESSION['sessUserInfo']['id'] . "";
            $arrRes = $this->getArrayResult($varQuery);
//pre($arrRes);
            return $arrRes;
        }
    }

    /**
     * function userReviewAdd
     *
     * This function is used to add user reviews.
     *
     * Database Tables used in this function are : tbl_review
     *
     * @access public
     *
     * @parameters 1 string optional
     *
     * @return string $arrAddID
     */
    function userReviewAdd($_arrPost)
    {
//pre($_SESSION);
        global $objCore;
        $arrClms = array(
            'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
            'fkProductID' => $_arrPost['pid'],
            'Reviews' => $objCore->stripTags($_arrPost['frmval']),
            'ReviewDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
            'ReviewDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
//pre($arrPost);

        $arrAddID = $this->insert(TABLE_REVIEW, $arrClms);
        return $arrAddID;
    }

    /**
     * function userReviewAdd
     *
     * This function is used to delete product from wishlist.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string optional
     *
     * @return string $arrAddID
     */
    function deleteProductFromWishlist($cid, $pid)
    {
//pre($_SESSION);
        $varWhereSdelete = " fkUserId = '" . $cid . "' AND `fkProductId` = '" . $pid . "'";
        $varAffected = $this->delete(TABLE_WISHLIST, $varWhereSdelete);
        return $varAffected;
    }

    /**
     * function getInvoiceDetails
     *
     * This function is used get invoice datails for customer.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $arrRes
     */
    function getInvoiceDetails($oid, $cid)
    {
       // $oid='163-36';
        $arrSubOrder = $this->select(TABLE_ORDER_ITEMS, array('distinct(SubOrderID)'), "fkOrderID='" . $oid . "'");

        foreach ($arrSubOrder as $k => $v)
        {
            $arrClms1 = array(
                'pkInvoiceID',
                'fkOrderID',
                'fkSubOrderID',
                'fkWholesalerID',
                'Amount',
                'InvoiceFileName',
                'InvoiceDetails'
            );
            $varTable1 = TABLE_INVOICE;
            $varWhere = " fkSubOrderID = '" . $v['SubOrderID'] . "' AND ToUserType = 'customer' AND ToUserID='" . $cid . "'";
            $arrRow = $this->select($varTable1, $arrClms1, $varWhere, " InvoiceDateAdded desc ");
            $arrRes[$k] = $arrRow[0];
        }

        return $arrRes;
    }

    /**
     * function markAsDisputed
     *
     * This function is used to update order status as disputed.
     *
     * Database Tables used in this function are : tbl_order, tbl_order_items, tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $string
     */
    function markAsDisputed($arrPost, $cid)
    {
        global $objGeneral;

        $oid = $arrPost['oid'];
        $soid = $arrPost['soid'];


        $arrClms = array('pkOrderID', 'fkCustomerID', 'TransactionID', 'CustomerFirstName', 'CustomerLastName', 'CustomerEmail', 'CustomerPhone');

        $argWhere = "pkOrderID='" . $oid . "' ";
        $arrOrder = $this->select(TABLE_ORDER, $arrClms, $argWhere);

        if (count($arrOrder) > 0)
        {

            $varWhr = " fkCustomerID = '" . $cid . "' AND pkOrderID ='" . $oid . "'";
            $this->update(TABLE_ORDER, array('OrderStatus' => 'Disputed'), $varWhr);


            $varWhr = "fkOrderID ='" . $oid . "' ";
            if ($soid <> '')
            {
                $varWhr .= " AND SubOrderID ='" . $soid . "' ";
            }

            $this->update(TABLE_ORDER_ITEMS, array('DisputedStatus' => 'Disputed'), $varWhr);

            $varWhr = "fkSubOrderID ='" . $soid . "' AND fkSubOrderID !=''";
            $this->update(TABLE_INVOICE, array('TransactionStatus' => 'Disputed'), $varWhr);
            $this->disputedComments($arrPost, $cid);

            $arrOrder[0]['SubOrderId'] = $soid;
            $arrOrder[0]['EmailSubject'] = ORDER_DISPUTED_BY_CUSTOMER . '<br/>' . ORDER_DETAILS_TITLE;

            $objGeneral->sendDisputedEmail($arrOrder[0], 1);
        }
    }

    /**
     * function disputeFeedback
     *
     * This function is used to update order status as disputed.
     *
     * Database Tables used in this function are : tbl_order, tbl_order_disputed_comments
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $string
     */
    function disputeFeedback($arrPost, $cid)
    {
        global $objGeneral;
        global $objCore;

        $oid = $arrPost['oid'];
        $soid = $arrPost['soid'];
        $arrClms = array('pkOrderID', 'fkCustomerID', 'TransactionID', 'CustomerFirstName', 'CustomerLastName', 'CustomerEmail', 'CustomerPhone');

        $argWhere = "pkOrderID='" . $oid . "' ";
        $arrOrder = $this->select(TABLE_ORDER, $arrClms, $argWhere);

        if (count($arrOrder) > 0)
        {

            $arrClms = array(
                'fkOrderID' => $arrPost['oid'],
                'fkSubOrderID' => $arrPost['soid'],
                'CommentedBy' => 'customer',
                'CommentedID' => $cid,
                'CommentOn' => 'Feedback',
                'AdditionalComments' => $objCore->stripTags($arrPost['frmFeedback']),
                'CommentDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $arrRow = $this->insert(TABLE_ORDER_DISPUTED_COMMENTS, $arrClms);

            $arrOrder[0]['SubOrderId'] = $soid;
            $arrOrder[0]['EmailSubject'] = ORDER_DISPUTED_FEEDBACK_BY_CUSTOMER . '<br/>' . ORDER_DETAILS_TITLE;
            $objGeneral->sendDisputedEmail($arrOrder[0], 1);
        }
    }

    /**
     * function disputedCommentsHistory
     *
     * This function is used to display disputed comments.
     *
     * Database Tables used in this function are : tbl_order_disputed_comments, tbl_customer, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return null
     */
    function disputedCommentsHistory($oid)
    {
        global $objCore;
        $arrClms = array(
            'pkDisputedID',
            'fkOrderID',
            'fkSubOrderID',
            'CommentedBy',
            'CommentedID',
            'CustomerFirstName as customer',
            'CompanyName wholesaler',
            'AdminTitle admin',
            'CommentOn',
            'CommentDesc',
            'AdditionalComments',
            'CommentDateAdded'
        );
        $varWhr = " fkOrderID='" . $oid . "' ";
        $varOrd = " CommentDateAdded ASC ";
        $varTable = TABLE_ORDER_DISPUTED_COMMENTS . " LEFT JOIN " . TABLE_CUSTOMER . " ON CommentedID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON CommentedID=pkWholesalerID LEFT JOIN " . TABLE_ADMIN . " ON CommentedID=pkAdminID";
        $arrRow = $this->select($varTable, $arrClms, $varWhr, $varOrd);
        $arrRes = array();
        foreach ($arrRow as $k => $v)
        {
            $arrRes[$v['fkSubOrderID']][] = $v;
        }
//pre($arrRes);
        return $arrRes;
    }

    /**
     * function disputedComments
     *
     * This function is used to insert disputed comments.
     *
     * Database Tables used in this function are : tbl_order_disputed_comments
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return null
     */
    function disputedComments($arrPost, $cid)
    {
        global $objCore;

        $arrComment = array(
            'Q1' => $arrPost['Q1']
        );
        if ($arrPost['Q1'] == 'A11')
        {
            $arrComment['Q11'] = $arrPost['Q11'];
            $additionalComments = $arrPost['Q12'];
        }
        else
        {
            $Q21 = implode(',', $arrPost['Q21']);
            $arrComment['Q21'] = trim($Q21, ',');
            $arrComment['Q22'] = $arrPost['Q22'];
            $arrComment['Q23'] = $arrPost['Q23'];
            $additionalComments = $arrPost['Q24'];
        }

        $CommentDesc = serialize($arrComment);

        $arrClms = array(
            'fkOrderID' => $arrPost['oid'],
            'fkSubOrderID' => $arrPost['soid'],
            'CommentedBy' => 'customer',
            'CommentedID' => $cid,
            'CommentDesc' => $objCore->stripTags($CommentDesc),
            'AdditionalComments' => $objCore->stripTags($additionalComments),
            'CommentDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        $arrRow = $this->insert(TABLE_ORDER_DISPUTED_COMMENTS, $arrClms);
    }

    /**
     * function getCouponNum
     *
     * This function is used to get num of coupons records.
     *
     * Database Tables used in this function are : tbl_order_total, tbl_order
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function getCouponNum($cid)
    {
        $varID = "o.fkCustomerID = '" . $cid . "' ";
        $query = "SELECT count(ot.pkOrderTotalID) as numRows FROM " . TABLE_ORDER_TOTAL . " as ot INNER JOIN " . TABLE_ORDER . " as o ON o.pkOrderID = ot.fkOrderID WHERE {$varID} AND Code='coupon'";
        $arrRes = $this->getArrayResult($query);
        return $arrRes[0]['numRows'];
    }

    /**
     * function getCouponlist
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_order, tbl_order_total
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function getCouponlist($cid, $limit)
    {
        $limit = $limit ? "LIMIT {$limit}" : '';
        $varID = "o.fkCustomerID = '" . $cid . "' ";
        $query = "SELECT o.pkOrderID, ot.Title, ot.Amount, o.TransactionID, o.OrderStatus,o.OrderDateAdded FROM " . TABLE_ORDER . " as o INNER JOIN " . TABLE_ORDER_TOTAL . " as ot ON o.pkOrderID = ot.fkOrderID WHERE {$varID} AND Code='coupon' ORDER BY pkOrderID desc {$limit}";
        $arrRes = $this->getArrayResult($query);
        foreach ($arrRes as $key => $val)
        {
            $arrRows = $this->getInvoiceDetails($val['pkOrderID'], $cid);
            $arrRes[$key]['status'] = $this->getOrderStatus($val['OrderStatus']);
        }
//pre($arrRes);
        return $arrRes;
    }

    /**
     * function getGiftNum
     *
     * This function is used to get num of records.
     *
     * Database Tables used in this function are : tbl_order_total, tbl_order
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function getGiftNum($cid)
    {
        $varID = "o.fkCustomerID = '" . $cid . "' ";
        $query = "SELECT count(ot.pkOrderTotalID) as numRows FROM " . TABLE_ORDER_TOTAL . " as ot INNER JOIN " . TABLE_ORDER . " as o ON o.pkOrderID = ot.fkOrderID WHERE {$varID} AND Code='gift-card'";
        $arrRes = $this->getArrayResult($query);
        return $arrRes[0]['numRows'];
    }

    /**
     * function getGiftList
     *
     * This function is used to get gift list.
     *
     * Database Tables used in this function are : tbl_order, tbl_order_total
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function getGiftList($cid, $limit)
    {
        $limit = $limit ? "LIMIT {$limit}" : '';
        $varID = "o.fkCustomerID = '" . $cid . "' ";
        $query = "SELECT o.pkOrderID, ot.Title, ot.Amount, o.TransactionID, o.OrderStatus,o.OrderDateAdded FROM " . TABLE_ORDER . " as o INNER JOIN " . TABLE_ORDER_TOTAL . " as ot ON o.pkOrderID = ot.fkOrderID LEFT JOIN " . TABLE_ORDER_ITEMS . " AS oi ON(oi.fkOrderID=o.pkOrderID AND oi.ItemType='gift-card') WHERE {$varID} GROUP BY oi.fkOrderID ORDER BY pkOrderID desc {$limit}";
        $arrRes = $this->getArrayResult($query);
        foreach ($arrRes as $key => $val)
        {
            $arrRows = $this->getInvoiceDetails($val['pkOrderID'], $cid);
            $arrRes[$key]['status'] = $this->getOrderStatus($val['OrderStatus']);
        }
//pre($arrRes);
        return $arrRes;
    }

    /**
     * function getShipmentDetails
     *
     * This function is used display get Shipment details.
     *
     * Database Tables used in this function are : tbl_shipment, tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getShipmentDetails($oItemID)
    {
        $arrClms = array('pkShipmentID', 'fkShippingCarrierID', 'ShippingAlias','ShippingTitle','ShippingType', 'TransactionNo', 's.ShippingStatus', 'OrderDate', 'ShippedDate', 'DateAdded');
        $varTable = TABLE_SHIPMENT . " as s LEFT JOIN tbl_shipping_gateways as sg ON fkShippingCarrierID = sg.pkShippingGatewaysID";
        $varID = "fkOrderItemID = '" . $oItemID . "'";
        $arrRes = $this->select($varTable, $arrClms, $varID);
//pre($arrRes);
        return $arrRes[0];
    }

    /**
     * function getRewardsSummery
     *
     * This function is used get wishlist products.
     *
     * Database Tables used in this function are : tbl_reward_point
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function getRewardsSummery($argWhere, $limit = '')
    {

        $limit = ($limit <> '') ? $limit : '';

        $arrClms = array(
            'pkRewardPointID',
            'TransactionType',
            'Description',
            'Points',
            'RewardDateAdded'
        );

        $varOrderBy = " pkRewardPointID DESC ";

        $arrRes = $this->select(TABLE_REWARD_POINT, $arrClms, $argWhere, $varOrderBy, $limit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function sendReferalToFriends
     *
     * This function is used send send referal link.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string $arrRes
     */
    function sendReferalToFriends($arrPost, $arrCustomer)
    {
        // pre($arrCustomer);
        $objTemplate = new EmailTemplate();
        $objCore = new Core();
        //pre($_SESSION);
        $varUserName = trim(strip_tags($arrPost['frmFriendEmail']));

        $arrFriendsEmails = explode(',', $varUserName);

        $varFromUser = $arrPost['CustomerEmail'];


        $varSiteName = SITE_NAME;
        $proUrl = $objCore->getUrl('registration_customer.php', array('type' => 'add', 'ref' => $arrCustomer['ReferalID']));

        $varWhereTemplate = " EmailTemplateTitle= 'SendReferalLink' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" style="margin-left:10px;">';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));


        // Calling mail function


        foreach ($arrFriendsEmails as $email)
        {
            $email = trim($email);

            $proUrlEm = $proUrl . '&email=' . $email;

            $varKeyword = array('{IMAGE_PATH}', '{EMAIL}', '{SITE_NAME}', '{CUSTOMER}', '{LINK}', '{SITE_ROOT_URL}');
            $varKeywordValues = array($varPathImage, '', SITE_NAME, ucfirst($arrCustomer['CustomerFirstName']), $proUrlEm, SITE_ROOT_URL);
            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
            $objCore->sendMail($email, $varFromUser, $varSubject, $varOutPutValues);
        }
    }

    /**
     * function checkScreenName
     *
     * This function is used to check Screen Name.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 2 staring, array
     *
     * @return string $varStr
     */
    function checkScreenName($cid, $arrPost)
    {
        $arrClms = array(
            'pkCustomerID'
        );

        $argWhere = "CustomerScreenName = '" . $arrPost['q'] . "' AND pkCustomerID != '" . $cid . "'";
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere);

        if (count($arrRes) > 0)
        {
            $varStr = '<span class="red">' . FRONT_USER_SCREEN_NAME_NOT_AVAIL_MSG . '<span>';
        }
        else
        {
            $varStr = '<span class="green">' . FRONT_USER_SCREEN_NAME_AVAIL_MSG . '<span>';
        }
        return $varStr;
    }

    /**
     * function userLoginToSaveProduct
     *
     * This function is used to user login.
     *
     * Database Tables used in this function are : tbl_customer,tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    function userLoginToSaveProduct($argArrPost)
    { //echo 'hi';
//pre($argArrPost);
        $objCore = new Core();
        $shoppingCart = new ShoppingCart();
        $arrUserFlds = array('pkCustomerID', 'CustomerFirstName', 'CustomerScreenName', 'CustomerEmail', 'CustomerPassword', 'BusinessAddress', 'BillingCountry', 'ShippingCountry', 'CustomerStatus', 'IsEmailVerified', 'CustomerWebsiteVisitCount');
        $varUserWhere = " CustomerEmail = '" . stripcslashes(trim($argArrPost['frmUserEmail'])) . "' AND CustomerPassword = '" . md5(trim($argArrPost['frmUserpassword'])) . "'";
//print_r($varUserWhere);exit;

        $arrUserList = $this->select(TABLE_CUSTOMER, $arrUserFlds, $varUserWhere);
        //pre($arrUserList);
        if (count($arrUserList) > 0)
        {
// pre($arrUserList);
            if ($arrUserList[0]['CustomerStatus'] == "Active" && $arrUserList[0]['IsEmailVerified'] == 1)
            {
                //pre($arrUserList);
                if (!empty($argArrPost['remember_me']))
                {
                    setcookie('email_id', $argArrPost['frmUserEmail'], time() + 3600, '/');
                    setcookie('password', $argArrPost['frmUserpassword'], time() + 3600, '/');
                    setcookie('remember_me', 'yes', time() + 3600, '/');
                }
                else
                {
                    if (!empty($_COOKIE['email_id']))
                    {
                        setcookie('email_id', $argArrPost['frmUserEmail'], time() - 3600, '/');
                        setcookie('password', $argArrPost['frmUserpassword'], time() - 3600, '/');
                        setcookie('remember_me', 'yes', time() - 3600, '/');
                    }
                }

                if ($arrUserList[0]['BusinessAddress'] = "Billing")
                {
                    $varCountryId = $arrUserList[0]['BillingCountry'];
                }
                else
                {
                    $varCountryId = $arrUserList[0]['ShippingCountry'];
                }
                $arrClms = array('country_id', 'time_zone',);
                $varWhr = 'country_id = ' . $varCountryId;
                $arrCustomerZone = $this->select(TABLE_COUNTRY, $arrClms, $varWhr);

                $_SESSION['sessUserInfo']['type'] = 'customer';
                $_SESSION['sessUserInfo']['email'] = $arrUserList[0]['CustomerEmail'];
                $_SESSION['sessUserInfo']['screenName'] = ($arrUserList[0]['CustomerScreenName'] == '') ? $arrUserList[0]['CustomerFirstName'] : $arrUserList[0]['CustomerScreenName'];
                $_SESSION['sessUserInfo']['id'] = $arrUserList[0]['pkCustomerID'];
                $_SESSION['sessUserInfo']['countryid'] = $varCountryId;
                $_SESSION['sessTimeZone'] = $arrCustomerZone[0]['time_zone'];

                $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $arrUserList[0]['pkCustomerID'] . "'");

                $varWhr = "pkCustomerID = '" . $arrUserList[0]['pkCustomerID'] . "'";
                $arrClms = array('CustomerWebsiteVisitCount' => ($arrUserList[0]['CustomerWebsiteVisitCount'] + 1));
                $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
                if (isset($_REQUEST['pid']) && $_REQUEST['pid'] <> '')
                {
                    $varWhereWishDeatils = "fkUserId='" . (int) $arrUserList[0]['pkCustomerID'] . "' AND fkProductId='" . (int) $_REQUEST['pid'] . "'";
                    $varCheckList = $this->select(TABLE_WISHLIST, array('pkWishlistId'), $varWhereWishDeatils);
                    if (count($varCheckList) == 0)
                    {
                        $this->myWishlistAdd($_REQUEST['pid']);
                    }
                }
                return 1;
            }
            else
            {
//   $objCore->setErrorMsg(FRONT_CUSTOMER_DEACTIVE_ERROR_MSG);
                if ($arrUserList[0]['IsEmailVerified'] == 0)
                {
                    return EMAIL_NOT_VERIFIED_ERROR_MSG;
                }
                else
                {
                    return FRONT_CUSTOMER_DEACTIVE_ERROR_MSG;
                }
            }
        }
        else
        {
// $objCore->setErrorMsg(FRON_END_USER_LOGIN_ERROR);
            if (isset($argArrPost['frmRef']) || isset($_REQUEST['pid']))
            {
                return FRON_END_USER_LOGIN_ERROR1;
            }
            else
            {
                return FRON_END_USER_LOGIN_ERROR;
            }
        }
    }

    /**
     * function sameShippingAddess
     *
     * This function is used to update same shipping address.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    function sameShippingAddess($array)
    {
        $where = "pkCustomerID='" . (int) $_SESSION['sessUserInfo']['id'] . "'";
        $updateQuery = $this->update(TABLE_CUSTOMER, $array, $where);
        return $updateQuery;
    }
    
    /**
     * function varifyCurrentPassword
     *
     * This function is used to change wholesaler password.
     *
     * Database Tables used in this function are : tbl_review
     *
     * @access public
     *
     * @parameters 1
     *
     * @return array
     *
     */
    public function varifyCurrentPassword($pass)
    {
    	//echo $_SESSION['sessUserInfo']['type']; die;
        $arr = array('pkCustomerID');
    	$where = "CustomerPassword='" . md5($pass) . "' and pkCustomerID='" . $_SESSION['sessUserInfo']['id'] . "'";
        $varifyCurrentP = $this->select(TABLE_CUSTOMER, $arr, $where);
        if (count($varifyCurrentP) > 0)
        {
            return 1;
        }
        else
        {
            return 2;
        }
    }

}

?>
