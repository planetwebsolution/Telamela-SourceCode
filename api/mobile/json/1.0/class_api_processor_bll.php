<?php

/**
 * Site APIProcessor Class
 *
 * This is the api class is responsible for all telamela API operations.
 *
 * DateCreated 6th May, 2014
 *
 * DateLastModified 6th May, 2014
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class APIProcessor extends Database
{

    /**
     * Constructor sets up
     */
    public function __construct()
    {
        $this->topRatedProductDisplayLimit = 9;
        $this->latestProductDisplayLimit = 10;
    }

    /**
     * This function escape the quoted string and will help to avoid SQL injection and single/double quote error.
     *
     * Date Created: 6th May 2014
     *
     * Date Last Modified: 1st July 2011
     *
     * @param integer|String
     *
     * @return String
     */
    public function quoteSlashes($value)
    {
        $value = addslashes($value);

        return $value;
    }

    /**
     * function login
     *
     * This function is used to get all Login List.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function login($arrReq)
    {

        $varTbl = TABLE_CUSTOMER;

        $arrClms = array(
            'concat(CustomerFirstName," ",CustomerLastName) as name',
            'pkCustomerID',
        	'CustomerEmail',
            'BillingPhone'
        );

        $arrRes[0]['status'] = "invalid";
        $varWhr = "(CustomerEmail='" . $this->quoteSlashes($arrReq['userEmailId']) . "' AND CustomerPassword='" . $this->quoteSlashes(md5($arrReq['password'])) . "' AND IsEmailVerified='1' AND CustomerStatus='Active') ";

        $arrRow = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrRow) > 0)
        {

            $WholesalerAPIKey = $this->generateApiKey($arrRes[0]['pkCustomerID']);
			
            $this->update($varTbl, array('CustomerAPIKey' => $WholesalerAPIKey), "pkCustomerID = '" . $arrRow[0]['pkCustomerID'] . "' ");
            $arrRes[0]['status'] = "valid";
            $arrRes[0]['pkCustomerID'] = $arrRow[0]['pkCustomerID'];
            $arrRes[0]['name'] = $arrRow[0]['name'];
            $arrRes[0]['CustomerEmail'] = $arrRow[0]['CustomerEmail'];
            $arrRes[0]['BillingPhone'] = $arrRow[0]['BillingPhone'];
            $arrRes[0]['CustomerAPIKey'] = $WholesalerAPIKey;
            
            //get cart count
            $argRequest['customerId'] = $arrRow[0]['pkCustomerID'];
            $argRequest['getCount'] = 1;
			
            $cartcnt = $this->cartDetails($argRequest);
            
            $arrRes[0]['cartTotal'] = $cartcnt;
			
			if(isset($arrReq['device_id']) && $arrReq['device_id'] != ''){
			//update device id and user type
				$varUsersWhere = ' pkCustomerID =' . $this->quoteSlashes($arrRow[0]['pkCustomerID']);
				$arrColumnAdd = array(
					'device_id' => trim($arrReq['device_id']),
					'user_type' => trim($arrReq['user_type']),
				);
				$varCustomerID = $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
			}
			
        }

        return $arrRes;
    }

    /**
     * This function used to generated api key.
     *
     * Date Created: 6th May 2014
     *
     * Date Last Modified: 1st July 2011
     *
     * @param integer|String
     *
     * @return String
     */
    function generateApiKey($id)
    {
        $apiToken = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $apiToken = substr(str_shuffle($apiToken), 0, 25);
        $apiToken = $id . $apiToken . $id;
        $apiToken = strtoupper(md5($apiToken));
        return $apiToken;
    }

    /**
     * function getuserId
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getuserId($token)
    {

        $varTbl = TABLE_CUSTOMER;
        $arrClms = array(
            'pkCustomerID'
        );

        $varWhr = "CustomerAPIKey='" . $this->quoteSlashes($token) . "' AND CustomerAPIKey !='' ";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);
        return (int) $arrRes[0]['pkCustomerID'];
    }

    /**
     * function getPassword
     *
     * This function is used to sent password via mail to user.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getPassword($arrReq)
    {
        $objTemplate = new EmailTemplate();
        $objCore = new Core();
        $varTbl = TABLE_CUSTOMER;

        $arrClms = array('pkCustomerID');
        $varWhr = "(CustomerEmail='" . $this->quoteSlashes($arrReq['userEmailId']) . "')";
        $arrUserList = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrUserList) > 0)
        {

            $varToUser = trim(strip_tags($arrReq['userEmailId']));
            $better_token = uniqid(md5(rand()), true);
            $this->insCustomerForgotPWCode($better_token, $varToUser);
            
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
            return FRONT_END_FORGET_PASSWORD_SUCCESS_MSG;

            // echo '<script>parent.window.location.href =  "index.php";</script>';
        }
        else
        {
            return FRONT_END_FORGET_PASSWORD_ERROR_MSG;
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
     * function registerUser
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
    public function registerUser($arrPost)
    {
        global $objGeneral;
        $objCore = new Core();
        $varEmail = $arrPost['userEmailId'];
        $varCustomerWhere = "CustomerEmail='" . $this->quoteSlashes($varEmail) . "'";
        $arrClms = array('pkCustomerID');
        $arrUserList = $this->select(TABLE_CUSTOMER, $arrClms, $varCustomerWhere);
        if ($arrUserList)
        {
        	$arrRes[0]['status'] = "invalid";
        	$arrRes[0]['msg'] = FRONT_USER_NAME_ALREADY_EXIST;
        	return $arrRes;
            //return FRONT_USER_NAME_ALREADY_EXIST;
        }
        else
        {
            $arrClms = array(
                //'CustomerFirstName' => $objCore->stripTags($arrPost['firstName']),
                //'CustomerLastName' => $objCore->stripTags($arrPost['lastName']),
                'CustomerEmail' => $objCore->stripTags($arrPost['userEmailId']),
                'CustomerPassword' => md5(trim($arrPost['password'])),
                'IsEmailVerified' => '1',
                'CustomerStatus' => 'Active',
                'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $arrAddID = $this->insert(TABLE_CUSTOMER, $arrClms);
            $objGeneral->addRewards($arrAddID, 'RewardOnCustomerRegistration');
            $objGeneral->createReferalId($arrAddID);
            $objTemplate = new EmailTemplate();

            $varUserName = trim(strip_tags($arrPost['userEmailId']));
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

            $varKeywordValues = array($varPathImage, $arrPost['password'], SITE_NAME, $arrPost['userEmailId'], ucfirst($arrPost['firstName']), $VerificationUrl, $VerificationUrl);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function


            $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);
            $arrRes[0]['status'] = "valid";
            $arrRes[0]['msg'] = FRONT_USER_ADD_SUCCUSS_MSG;
            return $arrRes;
           //return FRONT_USER_ADD_SUCCUSS_MSG;
        }
    }

    /**
     * function socialRegisterLogin
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
    public function socialRegisterLogin($arrPost)
    {
        global $objGeneral;
        $objCore = new Core();
        $varEmail = $arrPost['userEmailId'];
        $varCustomerWhere = "CustomerEmail='" . $this->quoteSlashes($varEmail) . "' AND IsEmailVerified='1' AND CustomerStatus='Active'";
        $arrClmsLogin = array('concat(CustomerFirstName," ",CustomerLastName) as name', 'pkCustomerID', 'CustomerEmail', 'BillingPhone');
        $arrUserList = $this->select(TABLE_CUSTOMER, $arrClmsLogin, $varCustomerWhere);
		$arrRes[0]['status'] = "invalid";
        if (count($arrUserList) > 0)
        {
            $WholesalerAPIKey = $this->generateApiKey($arrUserList[0]['pkCustomerID']);
            $this->update(TABLE_CUSTOMER, array('CustomerAPIKey' => $WholesalerAPIKey), "pkCustomerID = '" . $arrUserList[0]['pkCustomerID'] . "' ");
            $arrRes[0]['status'] = "valid";
            $arrRes[0]['pkCustomerID'] = $arrUserList[0]['pkCustomerID'];
            $arrRes[0]['name'] = $arrUserList[0]['name'];
            $arrRes[0]['CustomerEmail'] = $arrUserList[0]['CustomerEmail'];
            $arrRes[0]['BillingPhone'] = $arrUserList[0]['BillingPhone'];
            $arrRes[0]['CustomerAPIKey'] = $WholesalerAPIKey;
            
             //get cart count
                    $argRequest['customerId'] = $arrUserList[0]['pkCustomerID'];
                    $argRequest['getCount'] = 1;
                    $cartcnt = $this->cartDetails($argRequest);
                    $arrRes[0]['cartTotal'] = $cartcnt;
        }
        else
        {
            $arrClms = array(
                //'CustomerFirstName' => $objCore->stripTags($arrPost['firstName']),
                //'CustomerLastName' => $objCore->stripTags($arrPost['lastName']),
                'CustomerEmail' => $objCore->stripTags($arrPost['userEmailId']),
                //'CustomerPassword' => md5(rand()),
                'SocialIdentifier' => $arrPost['SocialIdentifier'],
                'SocialProvider' => $arrPost['SocialProvider'],
                'IsEmailVerified' => '1',
                'CustomerStatus' => 'Active',
                'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $arrAddID = $this->insert(TABLE_CUSTOMER, $arrClms);
            if ($arrAddID)
            {
                $objGeneral->addRewards($arrAddID, 'RewardOnCustomerRegistration');
                $objGeneral->createReferalId($arrAddID);
                //Login to customer
                $varCustomerRegWhere = "pkCustomerID='" . $this->quoteSlashes($arrAddID) . "' AND IsEmailVerified='1' AND CustomerStatus='Active'";
                $arrUserList = $this->select(TABLE_CUSTOMER, $arrClmsLogin, $varCustomerRegWhere);
                if (count($arrUserList) > 0)
                {
                    $WholesalerAPIKey = $this->generateApiKey($arrUserList[0]['pkCustomerID']);
                    $this->update(TABLE_CUSTOMER, array('CustomerAPIKey' => $WholesalerAPIKey), "pkCustomerID = '" . $arrUserList[0]['pkCustomerID'] . "' ");
                    $arrRes[0]['status'] = "valid";
                    $arrRes[0]['pkCustomerID'] = $arrUserList[0]['pkCustomerID'];
                    $arrRes[0]['name'] = $arrUserList[0]['name'];
                    $arrRes[0]['CustomerEmail'] = $arrUserList[0]['CustomerEmail'];
                    $arrRes[0]['BillingPhone'] = $arrUserList[0]['BillingPhone'];
                    $arrRes[0]['CustomerAPIKey'] = $WholesalerAPIKey;
                    
                    //get cart count
                    $argRequest['customerId'] = $arrUserList[0]['pkCustomerID'];
                    $argRequest['getCount'] = 1;
                    $cartcnt = $this->cartDetails($argRequest);

                    $arrRes[0]['cartTotal'] = $cartcnt;
                }
            }
        }
		
		if(isset($arrPost['device_id']) && $arrPost['device_id'] != ''){
			//update device id and user type
				$varUsersWhere = ' pkCustomerID =' . $this->quoteSlashes($arrUserList[0]['pkCustomerID']);
				$arrColumnAdd = array(
					'device_id' => trim($arrPost['device_id']),
					'user_type' => trim($arrPost['user_type']),
				);
				$varCustomerID = $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
		}
			
        return $arrRes;
    }

    /**
     * function updatePassword
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
    function updatePassword($argArrPOST)
    {
        $objCore = new Core();
        $arrUserFlds = array('CustomerFirstName', 'CustomerPassword');
        $varUserWhere = ' 1 AND pkCustomerID = \'' . $this->quoteSlashes($argArrPOST['userId']) . '\'';
        $arrUserList = $this->select(TABLE_CUSTOMER, $arrUserFlds, $varUserWhere);
        //$xx=array('userpass'=>$arrUserList[0]['CustomerPassword'],'oldpass'=>trim($argArrPOST['oldPassword']),'custom'=>md5('1234567'),'newPass'=>$argArrPOST['newPassword']);
        //mail('raju.khatak@mail.vinove.com','hi',print_r($xx,1));
        if ($arrUserList[0]['CustomerPassword'] == md5(trim($argArrPOST['oldPassword'])))
        {

            if (md5(trim($argArrPOST['newPassword'])) != md5(trim($argArrPOST['oldPassword'])))
            {
                $varUsersWhere = ' pkCustomerID =' . $this->quoteSlashes($argArrPOST['userId']);
                $arrColumnAdd = array(
                    'CustomerPassword' => md5(trim($argArrPOST['newPassword'])),
                );
                $varCustomerID = $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);

                $objTemplate = new EmailTemplate();
                $objCore = new Core();

                $varUserName = trim(strip_tags($arrUserList[0]['CustomerEmail']));
                $varFromUser = SITE_NAME;

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'Send Change Password to Customer' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}', '{NAME}', '{PASSWORD}', '{SITE_NAME}', '{USER_NAME}');

                $varKeywordValues = array($varPathImage, $arrUserList[0]['CustomerFirstName'], $argArrPOST['newPassword'], SITE_NAME, $argArrPOST['userEmailId']);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);
                return FRONT_END_PASSWORD_SUCC_CHANGE;
            }
            else
            {
                return FRONT_END_INVALID_NEW_PASSWORD;
            }
        }
        else
        {
            return FRONT_END_INVALID_CURENT_PASSWORD;
        }
    }

    /**
     * function getStaticData
     *
     * This function is used to get home page data.
     *
     * Database Tables used in this function are : As per the requirement
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getStaticData($argArrPOST)
    {

        $returnData = array();

        // Offer product fetch process from here

        $tableOffer = TABLE_PRODUCT_TODAY_OFFER . " as offer INNER JOIN " . TABLE_PRODUCT . " as product ON offer.fkProductId=product.pkProductID INNER JOIN " . TABLE_WHOLESALER . "  ON  fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID";
        $arrProductClms = array('pkProductID', 'ProductImage', 'ProductDescription');
        $whereOffer = "product.ProductStatus='1'";
        $orderOffer = "offer.OfferDateUpdated DESC  LIMIT " . $argArrPOST['limit'] . "";
        $getData = $this->select($tableOffer, $arrProductClms, $whereOffer, $orderOffer);

        // Menu/Category fetch process from here

        $tableCategory = TABLE_CATEGORY;
        $arrCategoryClms = array('CategoryName');
        $getCategoryData = $this->select($tableCategory, $arrCategoryClms, $whereOffer = '1');

        // top rating product

        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,ProductImage, avg(Rating) AS Rating,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as pkCategoryId,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID
            WHERE ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' AND RatingApprovedStatus='Allow' Group By pkProductID ORDER BY CategoryHierarchy ASC, Rating DESC LIMIT " . $argArrPOST['limit'] . "";

        $arrResProd = $this->getArrayResult($varQuery);

        // top selling product
        //Get today's offer
        $arrTodayOffer = $this->getTodayOffer();
        $todayOfferProduct = $arrTodayOffer['offer_details']['0']['fkProductId'];
        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,ProductDescription,ProductImage,ProductSliderImage,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent
            FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
            INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') WHERE Sold!=0
            ORDER BY Sold DESC
            LIMIT " . $argArrPOST['limit'] . "";

        $arrTopSellingRes = $this->getArrayResult($varQuery);


        // Top discounted price
        $tableDiscounted = TABLE_PRODUCT . " as product INNER JOIN " . TABLE_WHOLESALER . "  ON  fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID";
        $arrDiscountedClms = array('pkProductID', 'ProductName', 'FinalPrice', 'DiscountFinalPrice', 'ProductImage', 'floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent');
        $whereDiscounted = "product.ProductStatus='1'";
        $orderDiscounted = "discountPercent DESC LIMIT " . $argArrPOST['limit'] . "";

        $getDiscountedData = $this->select($tableDiscounted, $arrDiscountedClms, $whereDiscounted, $orderDiscounted);

        if (count($getData) > 0)
        {
            $returnData['ofrData'] = $getData;
        }
        if (count($getCategoryData) > 0)
        {
            $returnData['menuData'] = $getCategoryData;
        } if (count($arrResProd) > 0)
        {
            $returnData['topRating'] = $arrResProd;
        }
        if (count($arrTopSellingRes) > 0)
        {
            $returnData['topSelling'] = $arrTopSellingRes;
        }
        if (count($getDiscountedData) > 0)
        {
            $returnData['topDiscounted'] = $arrTopSellingRes;
        }
        return $returnData;
    }

    /**
     * function getProducts
     *
     * This function is used to get product details.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getProducts($argArrPOST)
    {

        $tableOffer = TABLE_PRODUCT_TODAY_OFFER . " as offer INNER JOIN " . TABLE_PRODUCT . " as product ON offer.fkProductId=product.pkProductID INNER JOIN " . TABLE_WHOLESALER . "  ON  fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID";
        $arrProductClms = array('pkProductID', 'ProductName', 'FinalPrice', 'DiscountFinalPrice', 'ProductImage', 'floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent');
        $whereOffer = "product.ProductStatus='1' AND offer.TodayOfferID ='" . (int) ($argArrPOST['offerId']) . "'";

        $getData = $this->select($tableOffer, $arrProductClms, $whereOffer);

        if (count($getData) > 0)
        {
            return $getData;
        }
        else
        {
            return NO_PRODUCT;
        }
    }

    /**
     * function getProductSize
     *
     * This function is used to get product details.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getProductSize($argArrPOST)
    {

        $attrId = '(select pkAttributeID from tbl_attribute where AttributeCode="' . $argArrPOST['attr'] . '") as pkAttributeID';
        $tableOffer = TABLE_PRODUCT_TODAY_OFFER . " as offer INNER JOIN " . TABLE_PRODUCT . " as product ON offer.fkProductId=product.pkProductID INNER JOIN " . TABLE_WHOLESALER . "  ON  fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID INNER JOIN " . TABLE_PRODUCT_TO_OPTION . " as op ON product.pkProductID='" . $attrId . "'";
        $arrProductClms = array('pkProductID', 'ProductName', 'FinalPrice', 'DiscountFinalPrice', 'ProductImage', 'floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent', 'op.AttributeOptionValue');
        $whereOffer = " product.ProductStatus='1' AND offer.TodayOfferID ='" . (int) ($argArrPOST['offerId']) . "' AND op.AttributeOptionValue='" . $argArrPOST['Size'] . "'";

        $getData = $this->select($tableOffer, $arrProductClms, $whereOffer);

        if (count($getData) > 0)
        {
            return $getData;
        }
        else
        {
            return NO_PRODUCT;
        }
    }

    /**
     * function getCustomerReview
     *
     * This function is used to get product details.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getCustomerReview($argArrPOST)
    {
    	$argArrPOST['offset'] = ($argArrPOST['offset'])?$argArrPOST['offset']:0;
        $argArrPOST['limit'] = ($argArrPOST['limit'])?$argArrPOST['limit']:200;

        $varWhere = "rat.fkProductID = '" . (int) ($argArrPOST['productsId']) . "' AND ApprovedStatus = 'Allow' AND RatingApprovedStatus = 'Allow'";
        $varQuery = "SELECT pkReviewID,Rating,rat.fkProductID,CustomerFirstName as CustomerName,CustomerScreenName, rev.Reviews,
            ReviewDateAdded,ReviewDateUpdated FROM " . TABLE_PRODUCT_RATING . " as rat LEFT JOIN " . TABLE_CUSTOMER . " ON rat.fkCustomerID=pkCustomerID LEFT JOIN "
                . TABLE_REVIEW . " as rev ON rev.pkReviewID=rat.pkRateID WHERE " . $varWhere . " order by ReviewDateUpdated desc limit ".$argArrPOST['offset'].",".$argArrPOST['limit'];
      
        $arrRes = $this->getArrayResult($varQuery);
        
        //Calculate ratings
        
        $varQuery2 =  "SELECT a.rating, COUNT(b.rating) totalCount FROM(
			SELECT 1 rating UNION SELECT 2 UNION
			      SELECT 3 UNION SELECT 4 UNION
			      SELECT 5
			    ) a
			    LEFT JOIN " . TABLE_PRODUCT_RATING . " b
			      ON a.rating = b.rating and b.fkProductID = '" . (int) ($argArrPOST['productsId']) . "' and b.RatingApprovedStatus = 'Allow' LEFT JOIN " . TABLE_CUSTOMER . " ON b.fkCustomerID=pkCustomerID LEFT JOIN "
                . TABLE_REVIEW . " as rev ON rev.pkReviewID=b.pkRateID and ApprovedStatus = 'Allow'
			GROUP BY a.rating";
        
        $arrRes2 = $this->getArrayResult($varQuery2);
        
        //get basic product details
        $argProductId['productsId'] = $argArrPOST['productsId'];
        $arrRes3 = $this->getProductBasicDetails($argProductId);
        
        return array('productDetails' => $arrRes3,'ratingGraph' => $arrRes2,'customerReviews' => $arrRes);
    }
    
    
    /**
     * function getProductBasicDetails
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image, tbl_category, tbl_wholesaler, tbl_order_option, tbl_product_rating, tbl_special_product, tbl_festival, tbl_product_to_option, tbl_attribute, tbl_attribute_option, tbl_recent_view
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getProductBasicDetails($argProductId)
    {
    	$objCore = new Core();
    	$argProductId = $argProductId['productsId'];
    	$slVal = array('pkProductID');
    	$varWhere = "pkProductID = '" . $argProductId . "' AND ProductStatus='1'";
    	$getVarified = $this->select(TABLE_PRODUCT, $slVal, $varWhere);
    	if (count($getVarified) > 0)
    	{
    		$varQuery = "SELECT pkProductID,p.fkCategoryID,ProductName,
                 (select CAST(avg(Rating) as decimal(10,2)) from " . TABLE_PRODUCT_RATING . " as rat where rat.fkProductID=pkProductID AND RatingApprovedStatus='Allow') AS Rating,
                  (select count(pkReviewID) from " . TABLE_REVIEW . " as rev where rev.fkProductID=pkProductID AND ApprovedStatus='Allow') AS customerReviews
                 FROM " . TABLE_PRODUCT . " as p 
                 WHERE " . $varWhere;
    		$arrRes = $this->getArrayResult($varQuery);
 	
    		return $arrRes;
    	}
    	else
    	{
    
    		return NO_PRODUCT;
    	}
    }
    
    
    /**
     * function applyCode
     *
     * This function is used to get product details with discount applying via code.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function applyCode($argArrPOST)
    {
        $code = trim($argArrPOST['code']);
        $date = date('Y-m-d');
//print_r($argArrPOST['productsId']);die;
        if ($code != '')
        {

            $arrProductClms = array('CouponCode', 'IsApplyAll');
            $where = "CouponCode='" . $code . "' AND (DateStart<='$date' AND DateEnd>='$date')";
            $getData = $this->select(TABLE_COUPON, $arrProductClms, $where);
            //print_r($getData);die;
            if (count($getData) > 0)
            {
                $getData = $getData[0];
                //$arrResp = array();
                $k=0;
                foreach($argArrPOST['productsId'] as $pKey=>$pVal)
                {
                    if ($getData['IsApplyAll'] == 1)
                    {

                        $tableCoupon = TABLE_PRODUCT . " as product INNER JOIN " . TABLE_WHOLESALER . "  ON  fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID CROSS JOIN " . TABLE_COUPON ." as coupon";
                        $arrCouponClms = array('pkProductID', 'Discount');
                        $whereCoupon = "product.ProductStatus='1' AND product.pkProductID='" . $pVal . "' AND coupon.CouponCode='" . $argArrPOST['code'] . "'";

                        $getDataCoupon = $this->select($tableCoupon, $arrCouponClms, $whereCoupon);
                        //print_r($getDataCoupon);
                        $getDataCoupon = count($getDataCoupon) > 0 ? $getDataCoupon : array(array("pkProductID" => $pVal, "Discount" => "0.00"));
                        //return $getDataCoupon;
                        //array_push($arrResp,$getDataCoupon);
                        $arrResp[$k]=$getDataCoupon[0];
                        
                    }
                    else if ($getData['IsApplyAll'] == 0)
                    {

                        $tableCoupon = TABLE_PRODUCT . " as product INNER JOIN " . TABLE_WHOLESALER . "  ON  fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID INNER JOIN " . TABLE_COUPON_TO_PRODUCT . " as coupon ON product.pkProductID=coupon.fkProductID INNER JOIN " . TABLE_COUPON . " as cou ON coupon.fkCouponID=cou.pkCouponID";
                        $arrCouponClms = array('pkProductID', 'Discount');
                        $whereCoupon = "product.ProductStatus='1' AND product.pkProductID='" . $pVal . "'";

                        $getDataCoupon = $this->select($tableCoupon, $arrCouponClms, $whereCoupon);
                        $getDataCoupon = count($getDataCoupon) > 0 ? $getDataCoupon : array(array("pkProductID" => $pVal, "Discount" => "0.00"));
                        //return $getDataCoupon;
                        //array_push($arrResp,$getDataCoupon);
                       // print_r($getDataCoupon);
                        $arrResp[$k]=$getDataCoupon[0];
                        
                    }
                    $k++;
                }
                return $arrResp;
            }
            else
            {
                return 'Coupon Code does not match with record or expired';
            }
        }
        else
        {

            return 'Coupon Code can not be blank';
        }
    }

    /**
     * function getCategories
     *
     * This function is used to get product details via category id.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getCategories($argArrPOST)
    {
        $tableCoupon = TABLE_CATEGORY;
       /* $arrCouponClms = array('pkCategoryId', 'CategoryName');
        $whereCoupon = "CategoryStatus='1' AND CategoryParentId='".$argArrPOST['catId']. "'";

        $getDataCoupon = $this->select($tableCoupon, $arrCouponClms, $whereCoupon);
        $getDataCoupon = count($getDataCoupon) > 0 ? $getDataCoupon : NO_ATTR;
        return $getDataCoupon;*/
        
        $varQuery = "SELECT cat.pkCategoryId,cat.CategoryName,catimg.categoryImage FROM " . TABLE_CATEGORY . " as cat LEFT JOIN tbl_category_images as catimg ON cat.pkCategoryId=catimg.fkCategoryId 
                    WHERE CategoryStatus='1' AND CategoryParentId='".$argArrPOST['catId']. "'";
        //echo $varQuery;die;
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }
    
    
    /**
     * function getCategories
     *
     * This function is used to get product details via category id.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    
    public function getWholeseller($argArrPOST)
    {
        $varQuery = "SELECT pkCategoryId FROM ".TABLE_CATEGORY." where CategoryParentId='".$argArrPOST['catId']."' AND CategoryStatus='1' ";
        $arrResProd = $this->getArrayResult($varQuery);
        $whID = array();
        foreach($arrResProd as $key=>$val)
        {
            $varQuery1 = "SELECT fkWholesalerID FROM ".TABLE_PRODUCT." where fkCategoryID='".$val['pkCategoryId']."' AND ProductStatus='1'  AND Quantity>0";
            $arrResWhid = $this->getArrayResult($varQuery1);
            foreach($arrResWhid as $whKey=>$whVal)
            {
                if(!in_array($whVal['fkWholesalerID'], $whID))
                {
                    array_push($whID, $whVal['fkWholesalerID']);
                }
            }
        }
        //pre($whID);
        $whArr = array();
        $count=0;
        foreach($whID as $whVal)
        {
            $varQuery2 = "SELECT pkWholesalerID,CompanyName FROM ".TABLE_WHOLESALER." where pkWholesalerID='".$whVal."' ";
            $arrResWhdetails = $this->getArrayResult($varQuery2);
            array_push($whArr,$arrResWhdetails);            
        }
        $test = call_user_func_array('array_merge',$whArr);
        return $test;
    }
    
    /**
     * function getProductPrice
     *
     * This function is used to get product details via category id.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getProductPrice($argArrPOST)
    {
        $priceArr = array();
        $varQuery1 = "SELECT FinalPrice FROM ".TABLE_PRODUCT." where fkCategoryID='".$argArrPOST['catId']."' AND ProductStatus='1'  AND Quantity>0";
        $arrResPrice = $this->getArrayResult($varQuery1);
        foreach($arrResPrice as $priceKey=>$priceVal)
        {
            if(!in_array($priceVal['FinalPrice'], $priceArr))
            {
                array_push($priceArr, $priceVal['FinalPrice']);
            }
        }
        sort($priceArr);
        $countNo = count($priceArr);
        if($countNo>1)
        {
            $startPrice = $priceArr[0];
            $lastPrice = $priceArr[$countNo-1];
        }
        //echo "start price ".$startPrice. " and last price ".$lastPrice;
        $price[startPrice]= $startPrice;
        $price[lastPrice]= $lastPrice;
        return $price;
    }
    
    public function filterData($argArrPOST)
    {        
        //echo "<pre>";
        $objCore = new Core();
        $objCategory = new Category();
        $objPaging = new Paging();
        
        if ($argArrPOST['cid'] > 0)
        {            
            $cid = (int) $argArrPOST['cid'];            
            $pcid = $objCore->findcatLavel($cid);
            $this->filterData->categoryDetails = $objCore->findParentcatName($cid);
            $CategoryDetails = $objCategory->getCategoryDetails($cid);
            $this->filterData->CategoryLevel = $CategoryDetails['CategoryLevel'];
            
            if ($whQuery != '')
                $whQuery .= " AND ";
                $whQuery .= '(pkCategoryId:' . $cid . ' OR CategoryParentId:' . $cid . ' OR CategoryGrandParentId:' . $cid . ')';
        }
        
        if ($argArrPOST['wid'] != '')
        {
            $whQueryWhl = '';
            $arrWhl = explode(",", $argArrPOST['wid']);
            foreach ($arrWhl as $whl)
            {
                if ($whQueryWhl != '')
                    $whQueryWhl .= " OR ";
                $whQueryWhl .= "pkWholesalerID:" . $whl;
            }
            if ($whQuery != '')
                $whQuery .= " AND ";
            $whQuery .= "($whQueryWhl)";
        }
        
        if ($this->filterData->CategoryLevel == 2)
        {
            if ($argArrPOST['attr'] != '' && $argArrPOST['action'] != 'SelectLeftPanel')
            {
                $whQueryAttr = "";
                $arrAttr = explode("#", $argArrPOST['attr']);
                foreach ($arrAttr as $strAttr)
                {
                    $arrAttr1 = explode(":", $strAttr);
                    if ($arrAttr1['1'] > 0)
                    {
                        $arrAttr2 = explode(",", $arrAttr1['1']);
                        foreach ($arrAttr2 as $attrb)
                        {
                            if ($whQueryAttr != '')
                                $whQueryAttr .= " OR ";
                            $whQueryAttr .= 'arrAttributes:*' . $attrb . '*';
                        }
                    }
                    if ($whQueryAttr != '')
                    {
                        if ($whQuery != '')
                            $whQuery .= " AND ";
                        $whQuery .= "($whQueryAttr)";
                    }
                    $whQueryAttr = '';
                }
            }
        }
        
        if ($argArrPOST['frmPriceFrom'] > 0 && $argArrPOST['frmPriceTo'] > 0 && $argArrPOST['frmPriceFrom'] != 'all' && is_numeric($argArrPOST['frmPriceFrom']))
        {
            if ($whQuery != '' || $whQueryPrice1 != '')
                $whQueryPrice2 .= " AND ";
                 $whQueryPrice2 .= "( DiscountFinalPrice:[" . $objCore->getRawPrice($argArrPOST['frmPriceFrom']) . " TO " . $objCore->getRawPrice($argArrPOST['frmPriceTo']) . "] OR FinalPrice:[" . $objCore->getRawPrice($argArrPOST['frmPriceFrom']) . " TO " . $objCore->getRawPrice($argArrPOST['frmPriceTo']) . "])";
        }
        else if ($argArrPOST['frmPriceFrom'] > 0 && $argArrPOST['frmPriceFrom'] != 'all' && is_numeric($argArrPOST['frmPriceFrom']))
        {
            if ($whQuery != '' || $whQueryPrice1 != '')
                $whQueryPrice2 .= " AND ";
             $whQueryPrice2 .= "(DiscountFinalPrice:[" . $objCore->getRawPrice($argArrPOST['frmPriceFrom']) . " TO " . FILTER_PRICE_LIMIT . "] OR FinalPrice:[" . $objCore->getRawPrice($argArrPOST['frmPriceFrom']) . " TO " . FILTER_PRICE_LIMIT . "])";
        }
        else if ($argArrPOST['frmPriceTo'] > 0 && $argArrPOST['frmPriceFrom'] != 'all' && is_numeric($argArrPOST['frmPriceFrom']))
        {
            if ($whQuery != '' || $whQueryPrice1 != '' || $whQueryPrice2 != '')
                $whQueryPrice2 .= " AND ";
            $whQueryPrice2 .= "(DiscountFinalPrice:[0 TO " . $objCore->getRawPrice($argArrPOST['frmPriceTo']) . "] OR FinalPrice:[0 TO " . $objCore->getRawPrice($argArrPOST['frmPriceTo']) . "])";
        }else if ($argArrPOST['pid'] != '')
        {
            if ($whQuery != '')
                $whQueryPrice1 .= " AND ";
            $whQueryPrice1 .= "(DiscountFinalPrice:[" . str_replace("-", " TO ", $argArrPOST['pid']) . "] OR FinalPrice:[" . str_replace("-", " TO ", $argArrPOST['pid']) . "])";
        }
        
        $varPage = 0;
        
        $varStPage = ($varPage > 0 ? ($varPage - 1) : 0) * PRODUCT_LISTING_LIMIT_PER_PAGE;
        
        $whQuery=$whQuery.' AND ProductStatus:1';
        
        $this->filterData->filters[0] = getSolrResult($whQuery . $whQueryPrice1 . $whQueryPrice2, $varStPage, PRODUCT_LISTING_LIMIT_PER_PAGE, $arrCat[(int) $cid], 1);
        $this->filterData->products = $this->filterData->filters[0]['productsDetails'];
        $this->filterData->NumberofRows = $this->filterData->filters[0]['ProductsTotal'];
        
        if (!isset($argArrPOST['action']) || $argArrPOST['action'] == 'SelectLeftPanel')
        {
            $this->filterData->filters[0] = getSolrCategoryResult($whQuery . $whQueryPrice1 . $whQueryPrice2, 0, $this->filterData->NumberofRows, $arrCat[(int) $cid]);
            if(count($this->filterData->filters[0]['WholesalerDetails']) >0){
                foreach($this->filterData->filters[0]['WholesalerDetails'] as $wholesaler){
                    $arrWholesaler[]=$wholesaler;
                }
                $this->filterData->filters[0]['wholesalers']=$arrWholesaler;
                unset($this->filterData->filters[0]['WholesalerDetails']);
            }
            
            if(count($this->filterData->filters[0]['arrAttributeDetail']) >0){
                foreach($this->filterData->filters[0]['arrAttributeDetail'] as $arrAttributeDetail){
                    $arrAttr[]=$arrAttributeDetail;
                }
                $this->filterData->filters[0]['attributes']=$arrAttr;
                unset($this->filterData->filters[0]['arrAttributeDetail']);
            }
            
            $this->filterData->filters[0]['CategoryChildList'] = $this->filterData->filters[0]['CategoryChildList'];
            
            if ($argArrPOST['frmPriceFrom'] < 1 && $argArrPOST['frmPriceTo'] < 1)
            {
                if ($whQuery != '')
                    $whQuery .= ' AND ';
                $princeRdif = 50;
                $priceLimit = 100;
                for ($k = 0, $l = -1; $k <= $priceLimit; $k+=$princeRdif, $l++)
                {
                    if ($k > 0)
                    {
                        $PriceRange[$l]['from'] = $p;
                        $PriceRange[$l]['to'] = $k - 1;
                        $PriceRange[$l]['value'] = $p . "-" . ($k - 1);
                        $PriceRange[$l]['productNum'] = getSolrPriceResult($whQuery . "DiscountFinalPrice:[$p TO " . ($k - 0.001) . "]");
                    }
                    $p = $k;
                }
                $PriceRange[$l + 1]['from'] = $priceLimit;
                $PriceRange[$l + 1]['to'] = "";
                $PriceRange[$l + 1]['value'] = $priceLimit . "-" . FILTER_PRICE_LIMIT;
                $PriceRange[$l + 1]['productNum'] = getSolrPriceResult($whQuery . "DiscountFinalPrice:[$priceLimit TO " . FILTER_PRICE_LIMIT . "]");

                $this->filterData->filters[0]['PriceRange'] = $PriceRange;
            }
        }
        $productCid = (int) $argArrPOST['cid'];
        $searchKeyPre = htmlentities($argArrPOST['searchCategoryVal']);
        $productFinalCid=($productCid>0)?$productCid:$searchKeyPre;
        
        //print_r($this->filterData->arrData);
        //print_r($this->filterData);
        //print_r($CategoryDetails);
        //print_r($this->CategoryLevel);
        //die;
        return $this->filterData;
    }
    

    /**
     * function getCategoryProducts
     *
     * This function is used to get product details category bases.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getCategoryProducts($argArrPOST)
    {
    	global $productImgUrl;
    	
    	$argArrPOST['offset'] = ($argArrPOST['offset'])?$argArrPOST['offset']:0;
    	$argArrPOST['limit'] = ($argArrPOST['limit'])?$argArrPOST['limit']:200;
        $argArrPOST['userID'] = ($argArrPOST['userID'])?$argArrPOST['userID']:0;
    	
    	//Get child Categories
    	$resCategories = $this->getCategories($argArrPOST);
    	//print_r($resCategories);
    	if(!empty($resCategories)){
	    	foreach($resCategories as $cat){
	    		$catList[] = $cat['pkCategoryId'];
	    	}
	    	$cat_list = implode(',', $catList);
    	}else{
    		$cat_list = $argArrPOST['catId'];
    	}
    	
    	$tableCoupon = TABLE_PRODUCT . " as product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_WHOLESALER . "  ON  product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID ";
        $arrCouponClms = array('pkProductID',  'trim(ProductName) as ProductName', 'FinalPrice', 'DiscountFinalPrice', 'FinalSpecialPrice', 'ProductImage', 'ProductDateUpdated', 'Sold', 'floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent',
            '(select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = '.$argArrPOST['userID'].') as isWishList',
            '(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice',
            '(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from ' . TABLE_PRODUCT_RATING . ' where fkProductID=pkProductID AND RatingApprovedStatus="Allow") as avgRating');
        $whereCoupon = "product.ProductStatus=1 AND WholesalerStatus = 'active'  AND product.fkCategoryID IN(".$cat_list.") limit ".$argArrPOST['offset'].", ".$argArrPOST['limit'];

        $getDataCoupon = $this->select($tableCoupon, $arrCouponClms, $whereCoupon);
        $getDataCoupon = count($getDataCoupon) > 0 ? $getDataCoupon : array();
        
        //Get total product
        $varQuery1 = "SELECT COUNT(*) as pro_cnt FROM tbl_product as product LEFT JOIN tbl_special_product sProduct ON pkProductID=sProduct.fkProductID INNER JOIN tbl_wholesaler  ON  product.fkWholesalerID = pkWholesalerID INNER JOIN tbl_category ON  pkCategoryId = product.fkCategoryID WHERE product.ProductStatus=1 AND WholesalerStatus = 'active'  AND product.fkCategoryID IN (".$cat_list.")";
        $totalProducts = $this->getArrayResult($varQuery1);
        $totalProCnt  = $totalProducts[0]['pro_cnt'];
        
        return array('productUrl' => $productImgUrl, 'totalProduct' => $totalProCnt, 'productList' => $getDataCoupon);
    }
    
    /**
     * function getSimilarCategoryProducts
     *
     * This function is used to get product details category bases.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getSimilarCategoryProducts($argArrPOST)
    {
    	global $productImgUrl;
    	 
    	$argArrPOST['offset'] = ($argArrPOST['offset'])?$argArrPOST['offset']:0;
    	$argArrPOST['limit'] = ($argArrPOST['limit'])?$argArrPOST['limit']:9;
    	 
    	//Get child Categories
    	$resCategories = $this->getCategories($argArrPOST);
    	//print_r($resCategories);
    	if(!empty($resCategories)){
    		foreach($resCategories as $cat){
    			$catList[] = $cat['pkCategoryId'];
    		}
    		$cat_list = implode(',', $catList);
    	}else{
    		$cat_list = $argArrPOST['catId'];
    	}
    	 
    	$tableCoupon = TABLE_PRODUCT . " as product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_WHOLESALER . "  ON  product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID";
    	$arrCouponClms = array('pkProductID', 'trim(ProductName) as ProductName', 'FinalPrice', 'DiscountFinalPrice', 'FinalSpecialPrice', 'ProductImage', 'ProductDateUpdated', 'Sold', 'floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent',
    			'(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice',
    			'(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from ' . TABLE_PRODUCT_RATING . ' where fkProductID=pkProductID AND RatingApprovedStatus="Allow") as avgRating');
    	$whereCoupon = "product.ProductStatus=1 AND WholesalerStatus = 'active' AND product.pkProductID != ".$argArrPOST['proId']." AND product.fkCategoryID IN(".$cat_list.") order by avgRating DESC limit ".$argArrPOST['offset'].", ".$argArrPOST['limit'];
    
    	$getDataCoupon = $this->select($tableCoupon, $arrCouponClms, $whereCoupon);
    	$getDataCoupon = count($getDataCoupon) > 0 ? $getDataCoupon : array();
    
    
    	return $getDataCoupon;
    }

    /**
     * function getWishList
     *
     * This function is used to get user wishlist product by user id.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getWishList($argArrPOST)
    {
        global $productImgUrl;
        $tableCoupon = TABLE_WISHLIST . " as wish INNER JOIN " . TABLE_PRODUCT . " as product ON product.pkProductID=wish.fkProductId LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_WHOLESALER . " ON  product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID";
        
        $arrCouponClms = array('pkProductID', 'ProductName', 'FinalPrice', 'DiscountFinalPrice', 'FinalSpecialPrice', 'ProductImage', 'floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent',
                               '(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice',
                              '(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from ' . TABLE_PRODUCT_RATING . ' where fkProductID=pkProductID AND RatingApprovedStatus="Allow") as avgRating');
        $whereCoupon = "product.ProductStatus='1' AND wish.fkUserId='" . $argArrPOST['userID'] . "'";

        $getDataCoupon = $this->select($tableCoupon, $arrCouponClms, $whereCoupon);
        $getDataCoupon = count($getDataCoupon) > 0 ? $getDataCoupon : array();
        return array('productUrl' => $productImgUrl, 'wishList' => $getDataCoupon);
        //return $getDataCoupon;
    }
    
    
     /**
     * function getWishList
     *
     * This function is used to get user wishlist product by product id's.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getWishListLocal($argArrPOST)
    {
        global $productImgUrl;
        if(isset($argArrPOST['productID'])):
            $proAttr = implode(',', $argArrPOST['productID']);
            
            $tableCoupon = TABLE_PRODUCT . " as product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_WHOLESALER . " ON  product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID";

            $arrCouponClms = array('pkProductID', 'ProductName', 'FinalPrice', 'DiscountFinalPrice', 'FinalSpecialPrice', 'ProductImage', 'floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent',
                                   '(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice',
                                  '(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from ' . TABLE_PRODUCT_RATING . ' where fkProductID=pkProductID AND RatingApprovedStatus="Allow") as avgRating');
            $whereCoupon = "product.ProductStatus='1' and product.pkProductID IN(".$proAttr.")";

            $getDataCoupon = $this->select($tableCoupon, $arrCouponClms, $whereCoupon);
        else:    
            $getDataCoupon =  array();
        endif;
            $getDataCoupon = count($getDataCoupon) > 0 ? $getDataCoupon : array();
            return array('productUrl' => $productImgUrl, 'wishList' => $getDataCoupon);
        //return $getDataCoupon;
    }
    
    

    /**
     * function contactUs
     *
     * This function is used to send contact us enquiry.
     *
     * Database Tables used in this function are : tbl_enquiry
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function contactUs($arrPost)
    {
        if ($arrPost['emailId'] != '' && $arrPost['message'] != '')
        {
            $objComman = new ClassCommon();
            $objTemplate = new EmailTemplate();
            $objCore = new Core();

            $arrClms = array(
                'EnquirySenderName' => $objCore->stripTags($arrPost['name']),
                'EnquirySenderEmail' => $objCore->stripTags($arrPost['emailId']),
                'EnquiryComment' => $objCore->stripTags($arrPost['message']),
                'EnquirySubject' => $objCore->stripTags($arrPost['subject']),
                'EnquirySenderMobile' => $objCore->stripTags($arrPost['phone']),
                'EnquiryDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $arrAddID = $this->insert(TABLE_ENQUIRY, $arrClms);
            $arrSuperAdmin = $objComman->getSuperAdminDetails();
            $varToUser = $arrSuperAdmin[0]['AdminEmail'];

            $varUserName = trim(strip_tags($arrPost['emailId']));

            $varSiteName = SITE_NAME;

            $varWhereTemplate = " EmailTemplateTitle= 'Contact Us Email By Customer' AND EmailTemplateStatus = 'Active' ";

            $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

            $varMessage = "<strong>" . NAME . ":</strong> " . $arrPost['name'] . "<br/>";
            $varMessage .= "<strong>" . EMAIL_ADDRESS . ":</strong> " . $arrPost['emailId'] . "<br/>";
            $varMessage .= "<strong>" . SUBJECT . ":</strong>  Contact us enquiry <br/>";
            $varMessage .= "<strong>" . MESSAGE . ":</strong> " . $arrPost['message'] . "<br/>";

            $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

            $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

            $varPathImage = '';
            $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

            $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

            $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{USER_NAME}', '{MESSAGE}');

            $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, $varMessage);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

            // Calling mail function


            $objCore->sendMail($varToUser, $varUserName, $varSubject, $varOutPutValues);
            return CONTACT_SUCCUSS_MSG;
        }
        else
        {

            return 'Required field should not be blank';
        }
    }

    /**
     * function getRewards
     *
     * This function is used to send reward summary details.
     *
     * Database Tables used in this function are : tbl_reward_point
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getRewards($arrPost)
    {
        $blank = array();
        /*$blank = array();
        if($arrPost['limit']=="")
        {
            $limit = 100;
        }
        else
        {
            $limit = $arrPost['limit'];
        }
        $table = TABLE_REWARD_POINT;
        $arrRewardsClms = array('pkRewardPointID', 'Points', 'DATE_FORMAT(RewardDateAdded,"%d%M%Y") as RewardDateAdded','Description');
        $whereRewards = "RewardStatus='Approved' AND fkCustomerID='" .$arrPost['userId']. "' LIMIT ".$limit." ";
        $getDataRewards = $this->select($table, $arrRewardsClms, $whereRewards);
        $getDataRewards = count($getDataRewards) > 0 ? $getDataRewards : NO_REWARDS;
        return $getDataRewards;*/
        $table = TABLE_REWARD_POINT;
        $arrRewardsCrClms = array('sum(Points) as CrPoint');
        $whereRewards = "RewardStatus='Approved' AND TransactionType='credit' AND fkCustomerID='" .$arrPost['userId']. "' ";
        $getCreditRewPoints = $this->select($table, $arrRewardsCrClms, $whereRewards);
        $getCreditRewPoints = count($getCreditRewPoints) > 0 ? $getCreditRewPoints : $blank;
        
        $arrRewardsDbClms = array('sum(Points) as DrPoint');
        $whereRewards = "RewardStatus='Approved' AND TransactionType='debit' AND fkCustomerID='" .$arrPost['userId']. "' ";
        $getDebitRewPoints = $this->select($table, $arrRewardsDbClms, $whereRewards);
        $getDebitRewPoints = count($getDebitRewPoints) > 0 ? $getDebitRewPoints : $blank;                
        
        $totalPoint = ($getCreditRewPoints[0]['CrPoint']-$getDebitRewPoints[0]['DrPoint']);      
        
        return $totalPoint;        
    }
    
    /**
     * function getCreditRewards
     *
     * This function is used to send Credit Reward details.
     *
     * Database Tables used in this function are : tbl_reward_point
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    
    public function getCreditRewards($arrPost)
    {
        $blank = array();
        if($arrPost['limit']=="")
        {
            $limit = 100;
        }
        else
        {
            $limit = $arrPost['limit'];
        }
        $table = TABLE_REWARD_POINT;
        $arrRewardsClms = array('pkRewardPointID', 'Points', 'DATE_FORMAT(RewardDateAdded,"%d%M%Y") as RewardDateAdded','Description');
        $whereRewards = "RewardStatus='Approved' AND TransactionType='credit' AND fkCustomerID='" .$arrPost['userId']. "' LIMIT ".$limit." ";

        $getDataRewards = $this->select($table, $arrRewardsClms, $whereRewards);
        $getDataRewards = count($getDataRewards) > 0 ? $getDataRewards : $blank;
        return $getDataRewards;
    }
    
    /**
     * function getDebitRewards
     *
     * This function is used to send Debit Reward details.
     *
     * Database Tables used in this function are : tbl_reward_point
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
        
    public function getDebitRewards($arrPost)
    {
        $blank = array();
        if($arrPost['limit']=="")
        {
            $limit = 100;
        }
        else
        {
            $limit = $arrPost['limit'];
        }
        $table = TABLE_REWARD_POINT;
        $arrRewardsClms = array('pkRewardPointID', 'Points', 'DATE_FORMAT(RewardDateAdded,"%d%M%Y") as RewardDateAdded','Description');
        $whereRewards = "RewardStatus='Approved' AND TransactionType='debit' AND fkCustomerID='" .$arrPost['userId']. "' LIMIT ".$limit." ";

        $getDataRewards = $this->select($table, $arrRewardsClms, $whereRewards);
        $getDataRewards = count($getDataRewards) > 0 ? $getDataRewards : $blank;
        return $getDataRewards;
    }

    /**
     * function getProfile
     *
     * This function is used to get user information.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getProfile($arrPost)
    {

        $varBillingCountry = "(select name from " . TABLE_CUSTOMER . " as c left join " . TABLE_COUNTRY . " as co on co.country_id=c.BillingCountry where pkCustomerID='" . $arrPost['userId'] . "') as BillingCountryName";
        $varShippingCountry = "(select name from " . TABLE_CUSTOMER . " as c left join " . TABLE_COUNTRY . " as co on co.country_id=c.ShippingCountry where pkCustomerID='" . $arrPost['userId'] . "') as ShippingCountryName";
		$varShippingCountry1 = "(select name from " . TABLE_CUSTOMER . " as c left join " . TABLE_COUNTRY . " as co on co.country_id=c.1_ShippingCountry where pkCustomerID='" . $arrPost['userId'] . "') as 1_ShippingCountryName";
		$varShippingCountry2 = "(select name from " . TABLE_CUSTOMER . " as c left join " . TABLE_COUNTRY . " as co on co.country_id=c.2_ShippingCountry where pkCustomerID='" . $arrPost['userId'] . "') as 2_ShippingCountryName";
        $arrClms = array(
            'CustomerScreenName as screenName', 'CustomerFirstName as firstName', 'CustomerLastName as lastName', 'CustomerEmail as emailId',
            'ResPhone as contactNo', 'CustomerDob as dob', 'BillingFirstName', 'BillingLastName',
            'BillingAddressLine1', 'BillingAddressLine2', 'BillingCountry', 'BillingPostalCode', 'BillingTown', 'BillingPhone',
            'ShippingFirstName', 'ShippingLastName', 'ShippingAddressLine1', 'ShippingPhone',
            'ShippingAddressLine2', 'ShippingCountry', 'ShippingPostalCode', 'ShippingTown', '1_ShippingFirstName', '1_ShippingLastName', '1_ShippingAddressLine1', '1_ShippingPhone',
            '1_ShippingAddressLine2', '1_ShippingCountry', '1_ShippingPostalCode', '2_ShippingFirstName', '2_ShippingLastName', '2_ShippingAddressLine1', '2_ShippingPhone',
            '2_ShippingAddressLine2', '2_ShippingCountry', '2_ShippingPostalCode', $varBillingCountry, $varShippingCountry, $varShippingCountry1, $varShippingCountry2
        );
        $argWhere = "pkCustomerID='" . $arrPost['userId'] . "' ";
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }
	
	
	/**
     * function getProfile
     *
     * This function is used to get user information.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getShippingInfo($arrPost)
    {
        $varShippingCountry = "(select name from " . TABLE_CUSTOMER . " as c left join " . TABLE_COUNTRY . " as co on co.country_id=c.ShippingCountry where pkCustomerID='" . $arrPost['userId'] . "') as ShippingCountryName";
		$varShippingCountry1 = "(select name from " . TABLE_CUSTOMER . " as c left join " . TABLE_COUNTRY . " as co on co.country_id=c.1_ShippingCountry where pkCustomerID='" . $arrPost['userId'] . "') as 1_ShippingCountryName";
		$varShippingCountry2 = "(select name from " . TABLE_CUSTOMER . " as c left join " . TABLE_COUNTRY . " as co on co.country_id=c.2_ShippingCountry where pkCustomerID='" . $arrPost['userId'] . "') as 2_ShippingCountryName";
        $arrClms = array(
            'ShippingFirstName', 'ShippingLastName', 'ShippingAddressLine1', 'ShippingPhone',
            'ShippingAddressLine2', 'ShippingCountry', 'ShippingPostalCode', 'ShippingTown', $varShippingCountry,
			'1_ShippingFirstName', '1_ShippingLastName', '1_ShippingAddressLine1', '1_ShippingPhone',
            '1_ShippingAddressLine2', '1_ShippingCountry', '1_ShippingPostalCode', '1_ShippingOrganizationName', $varShippingCountry1,
			'2_ShippingFirstName', '2_ShippingLastName', '2_ShippingAddressLine1', '2_ShippingPhone',
            '2_ShippingAddressLine2', '2_ShippingCountry', '2_ShippingPostalCode', '2_ShippingOrganizationName', $varShippingCountry2,
        );
        $argWhere = "pkCustomerID='" . $arrPost['userId'] . "' ";
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function updateprofile
     *
     * This function is used to update information to user.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function updateprofile($arrPost)
    {
        $objCore = new Core();
        $userId = isset($arrPost['userId']) ? $arrPost['userId'] : '';
        if ($userId)
        {
            $personal = $arrPost['personnelInformation'][0];
            $billingAddress = $arrPost['billingAddress'][0];
            $shippingAddress = $arrPost['shippingAddress'][0];
            //print_r($arrPost);die;
            //update personal info
            if($arrPost['updateTo']=='personalInfo'){
              $varFilterSecreenName=$this->select(TABLE_CUSTOMER,array('pkCustomerID'),'CustomerScreenName="'.$objCore->stripTags($personal['screenName']).'" AND pkCustomerID!="'.$userId.'"');
                
              if(count($varFilterSecreenName)>0){
                  return 'Screen Name you have entered is already exists';  
              }else{  
                $arrColumnAdd = array(
                'CustomerFirstName' => $objCore->stripTags($personal['firstName']),
                'CustomerLastName' => $objCore->stripTags($personal['lastName']),
                'ResPhone' => $objCore->stripTags($personal['contactNo']),
                'CustomerDob' => $objCore->stripTags($personal['dob']),
                'CustomerScreenName' => $objCore->stripTags($personal['screenName']),
                //'CustomerEmail' => $objCore->stripTags($personal['emailId']),
                'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
          
            $varUsersWhere = 'pkCustomerID="' . $userId . '"';
            $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
            return 'Profile has been updated successfully';  
              }
            }
            //update business address
            if($arrPost['updateTo']=='businessAddress'){
               $arrColumnAdd = array(
               
                'BillingAddressLine1' => $objCore->stripTags($billingAddress['addressLine1']),
                'BillingAddressLine2' => $objCore->stripTags($billingAddress['addressLine2']),
                'BillingCountry' => $objCore->stripTags($this->getCountryID($billingAddress['country'])),
                'BillingTown' => $objCore->stripTags($billingAddress['city']),
                'BillingPostalCode' => $objCore->stripTags($billingAddress['zipCode']),
                'BillingFirstName' => $objCore->stripTags($billingAddress['firstName']),
                'BillingLastName' => $objCore->stripTags($billingAddress['lastName']),
                'BillingPhone' => $objCore->stripTags($billingAddress['phone']),
                   
                'ShippingAddressLine1' => $objCore->stripTags($shippingAddress['addressLine1']),
                'ShippingAddressLine2' => $objCore->stripTags($shippingAddress['addressLine2']),
                'ShippingCountry' => $objCore->stripTags($this->getCountryID($shippingAddress['country'])),
                'ShippingTown' => $objCore->stripTags($shippingAddress['city']),
                'ShippingPostalCode' => $objCore->stripTags($shippingAddress['zipCode']),
                'ShippingFirstName' => $objCore->stripTags($shippingAddress['firstName']),
                'ShippingLastName' => $objCore->stripTags($shippingAddress['lastName']),
                'ShippingPhone' => $objCore->stripTags($shippingAddress['phone']),
                   
                'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)   
            );
          
            $varUsersWhere = 'pkCustomerID="' . $userId . '"';
            $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
            return 'Profile has been updated successfully'; 
            }
            
            //update billing address
            if($arrPost['updateTo']=='billingAddress'){
               $arrColumnAdd = array(
               
                'BillingAddressLine1' => $objCore->stripTags($billingAddress['addressLine1']),
                'BillingAddressLine2' => $objCore->stripTags($billingAddress['addressLine2']),
                'BillingCountry' => $objCore->stripTags($this->getCountryID($billingAddress['country'])),
                'BillingTown' => $objCore->stripTags($billingAddress['city']),
                'BillingPostalCode' => $objCore->stripTags($billingAddress['zipCode']),
                'BillingFirstName' => $objCore->stripTags($billingAddress['firstName']),
                'BillingLastName' => $objCore->stripTags($billingAddress['lastName']),
                'BillingPhone' => $objCore->stripTags($billingAddress['phone']),
                'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
          
            $varUsersWhere = 'pkCustomerID="' . $userId . '"';
            $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
            return 'Profile has been updated successfully'; 
            }
            
            //update shipping
            if($arrPost['updateTo']=='shippigAddress'){
               $arrColumnAdd = array(
                'ShippingAddressLine1' => $objCore->stripTags($shippingAddress['addressLine1']),
                'ShippingAddressLine2' => $objCore->stripTags($shippingAddress['addressLine2']),
                'ShippingCountry' => $objCore->stripTags($this->getCountryID($shippingAddress['country'])),
                'ShippingTown' => $objCore->stripTags($shippingAddress['city']),
                'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                'ShippingPostalCode' => $objCore->stripTags($shippingAddress['zipCode']),
                'ShippingFirstName' => $objCore->stripTags($shippingAddress['firstName']),
                'ShippingLastName' => $objCore->stripTags($shippingAddress['lastName']),
                'ShippingPhone' => $objCore->stripTags($shippingAddress['phone'])
                    //'ShippingState' => $objCore->stripTags($shippingAddress['state']),
            );
          
            $varUsersWhere = 'pkCustomerID="' . $userId . '"';
            $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
            return 'Profile has been updated successfully'; 
            }
            
            
        }
        else
        {

            return 'Error while updating profile.';
        }
    }
	
	 /**
     * function updateprofile
     *
     * This function is used to update information to user.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function updateShippingAddress($arrPost)
    {
        $objCore = new Core();
        $userId = isset($arrPost['userId']) ? $arrPost['userId'] : '';
        if ($userId)
        {
            //update shipping
            if($arrPost['updateTo']=='shippigAddress1'){
               $arrColumnAdd = array(
                'ShippingAddressLine1' => $objCore->stripTags($arrPost['addressLine1']),
                'ShippingAddressLine2' => $objCore->stripTags($arrPost['addressLine2']),
                'ShippingCountry' => $objCore->stripTags($this->getCountryID($arrPost['country'])),
                'ShippingPostalCode' => $objCore->stripTags($arrPost['zipCode']),
                'ShippingFirstName' => $objCore->stripTags($arrPost['firstName']),
                'ShippingLastName' => $objCore->stripTags($arrPost['lastName']),
                'ShippingPhone' => $objCore->stripTags($arrPost['phone'])
                );
			}
			if($arrPost['updateTo']=='shippigAddress2'){
               $arrColumnAdd = array(
                '1_ShippingAddressLine1' => $objCore->stripTags($arrPost['addressLine1']),
                '1_ShippingAddressLine2' => $objCore->stripTags($arrPost['addressLine2']),
                '1_ShippingCountry' => $objCore->stripTags($this->getCountryID($arrPost['country'])),
                '1_ShippingPostalCode' => $objCore->stripTags($arrPost['zipCode']),
                '1_ShippingFirstName' => $objCore->stripTags($arrPost['firstName']),
                '1_ShippingLastName' => $objCore->stripTags($arrPost['lastName']),
                '1_ShippingPhone' => $objCore->stripTags($arrPost['phone'])
                );
			}
			if($arrPost['updateTo']=='shippigAddress3'){
               $arrColumnAdd = array(
                '2_ShippingAddressLine1' => $objCore->stripTags($arrPost['addressLine1']),
                '2_ShippingAddressLine2' => $objCore->stripTags($arrPost['addressLine2']),
                '2_ShippingCountry' => $objCore->stripTags($this->getCountryID($arrPost['country'])),
                '2_ShippingPostalCode' => $objCore->stripTags($arrPost['zipCode']),
                '2_ShippingFirstName' => $objCore->stripTags($arrPost['firstName']),
                '2_ShippingLastName' => $objCore->stripTags($arrPost['lastName']),
                '2_ShippingPhone' => $objCore->stripTags($arrPost['phone'])
                );
            }
            $varUsersWhere = 'pkCustomerID="' . $userId . '"';
            $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
            return 'Profile has been updated successfully'; 
            
        }
        else
        {

            return 'Error while updating profile.';
        }
    }
    
    
    /**
     * function updateprofile
     *
     * This function is used to update information to user.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
   /* public function updateprofile($arrPost)
    {
        $objCore = new Core();
        $userId = isset($arrPost['userId']) ? $arrPost['userId'] : '';
        if ($userId)
        {
            $personal = $arrPost['personnelInformation'][0];
            $billingAddress = $arrPost['billingAddress'][0];
            $shippingAddress = $arrPost['shippingAddress'][0];
            //print_r($arrPost);die;
            //update personal info
            if($arrPost['updateTo']=='personalInfo'){
              $varFilterSecreenName=$this->select(TABLE_CUSTOMER,array('pkCustomerID'),'CustomerScreenName="'.$objCore->stripTags($personal['screenName']).'" AND pkCustomerID!="'.$userId.'"');
                
              if(count($varFilterSecreenName)>0){
                  return 'Screen Name you have entered is already exists';  
              }else{  
                $arrColumnAdd = array(
                'CustomerFirstName' => $objCore->stripTags($personal['firstName']),
                'CustomerLastName' => $objCore->stripTags($personal['lastName']),
                'ResPhone' => $objCore->stripTags($personal['contactNo']),
                'CustomerDob' => $objCore->stripTags($personal['dob']),
                'CustomerScreenName' => $objCore->stripTags($personal['screenName']),
                'CustomerEmail' => $objCore->stripTags($personal['emailId']),
                'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
          
            $varUsersWhere = 'pkCustomerID="' . $userId . '"';
            $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
            return 'Profile has been updated successfully';  
              }
            }
            //update billing address
            if($arrPost['updateTo']=='billingAddress'){
               $arrColumnAdd = array(
               
                'BillingAddressLine1' => $objCore->stripTags($billingAddress['addressLine1']),
                'BillingAddressLine2' => $objCore->stripTags($billingAddress['addressLine2']),
                'BillingCountry' => $objCore->stripTags($this->getCountryID($billingAddress['country'])),
                'BillingTown' => $objCore->stripTags($billingAddress['city']),
                'BillingPostalCode' => $objCore->stripTags($billingAddress['zipCode']),
                'BillingFirstName' => $objCore->stripTags($billingAddress['firstName']),
                'BillingLastName' => $objCore->stripTags($billingAddress['lastName']),
                'BillingPhone' => $objCore->stripTags($billingAddress['phone']),
                'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
          
            $varUsersWhere = 'pkCustomerID="' . $userId . '"';
            $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
            return 'Profile has been updated successfully'; 
            }
            //update shipping
            if($arrPost['updateTo']=='shippigAddress'){
               $arrColumnAdd = array(
                'ShippingAddressLine1' => $objCore->stripTags($shippingAddress['addressLine1']),
                'ShippingAddressLine2' => $objCore->stripTags($shippingAddress['addressLine2']),
                'ShippingCountry' => $objCore->stripTags($this->getCountryID($shippingAddress['country'])),
                'ShippingTown' => $objCore->stripTags($shippingAddress['city']),
                'CustomerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                'ShippingPostalCode' => $objCore->stripTags($shippingAddress['zipCode']),
                'ShippingFirstName' => $objCore->stripTags($shippingAddress['firstName']),
                'ShippingLastName' => $objCore->stripTags($shippingAddress['lastName']),
                'ShippingPhone' => $objCore->stripTags($shippingAddress['phone'])
                    //'ShippingState' => $objCore->stripTags($shippingAddress['state']),
            );
          
            $varUsersWhere = 'pkCustomerID="' . $userId . '"';
            $this->update(TABLE_CUSTOMER, $arrColumnAdd, $varUsersWhere);
            return 'Profile has been updated successfully'; 
            }
            
            
        }
        else
        {

            return 'Error while updating profile.';
        }
    }*/

    /**
     * function getHotDeals
     *
     * This function is used to get host deals( top discounted) product.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getHotDeals($arrPost)
    {
    	global $productImgUrl;
    	 
    	$arrPost['offset'] = ($arrPost['offset'])?$arrPost['offset']:0;
    	$arrPost['limit'] = ($arrPost['limit'])?$arrPost['limit']:200;
        $arrPost['userID'] = ($arrPost['userID'])?$arrPost['userID']:0;

        $tableDiscounted = TABLE_PRODUCT . " as product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN "
                . TABLE_WHOLESALER . "  ON  product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID";
        $arrDiscountedClms = array('pkProductID', 'ProductName', 'FinalPrice', 'DiscountFinalPrice', 'FinalSpecialPrice', 'ProductImage', 'floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent',
            '(select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = '.$arrPost['userID'].') as isWishList',
            '(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from ' . TABLE_PRODUCT_RATING . ' where fkProductID=pkProductID AND RatingApprovedStatus="Allow") as avgRating',
            '(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice');
        $whereDiscounted = "product.ProductStatus='1' AND WholesalerStatus = 'active' AND floor( (FinalPrice - DiscountFinalPrice) / FinalPrice *100 ) >20 AND floor( (FinalPrice - DiscountFinalPrice) / FinalPrice *100 ) <=99 ";
        if (isset($arrPost['limit']))
            $orderDiscounted = "discountPercent DESC limit ".$arrPost['offset'].", ".$arrPost['limit'];
        else
            $orderDiscounted = "discountPercent DESC";
        $getDiscountedData = $this->select($tableDiscounted, $arrDiscountedClms, $whereDiscounted, $orderDiscounted);
        
        //Get total product
        $tableDiscounted1 = TABLE_PRODUCT . " as product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN "
        		. TABLE_WHOLESALER . "  ON  product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID";
        $arrDiscountedClms1 = array('count(*) as procnt');
        $whereDiscounted1 = "product.ProductStatus='1' AND WholesalerStatus = 'active' AND floor( (FinalPrice - DiscountFinalPrice) / FinalPrice *100 ) >20 AND floor( (FinalPrice - DiscountFinalPrice) / FinalPrice *100 ) <=99 ";
                
        $countTotalPro = $this->select($tableDiscounted1, $arrDiscountedClms1, $whereDiscounted1);
                
        $totalProCnt = $countTotalPro[0]['procnt'];
        return array('productUrl' => $productImgUrl, 'totalProduct' => $totalProCnt, 'productList' => $getDiscountedData);
        
        //return $getDiscountedData;
    }

    /**
     * function getMostTrending
     *
     * This function is used to get host deals( top rating) product.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getMostTrending($arrPost)
    {
        $arrTodayOffer = $this->getTodayOffer();
        $todayOfferProduct = $arrTodayOffer['offer_details']['0']['fkProductId'];
        $limit = ($arrPost['limit']) ? $arrPost['limit'] : 9;
        $varQuery = "SELECT (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,
            pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,FinalSpecialPrice,
            ProductImage, IFNULL(CAST(avg(Rating) as decimal(10,2)),0) AS avgRating,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as pkCategoryId,
            floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent FROM "
                . TABLE_PRODUCT . " p LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID LEFT JOIN "
                . TABLE_CATEGORY . " ON  pkCategoryId = p.fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON p.fkWholesalerID = pkWholesalerID INNER JOIN "
                . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID
            WHERE ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' AND pkProductID !='$todayOfferProduct' Group By pkProductID ORDER BY CategoryHierarchy ASC, Rating DESC LIMIT " . $limit . "";

        $arrResProd = $this->getArrayResult($varQuery);

        return $arrResProd;
    }

    /**
     * function getRecentlyViewed
     *
     * This function is used to get host deals( top sold) product.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getRecentlyViewed($arrPost)
    {
    	global $productImgUrl;
        //Get today's offer
        $arrTodayOffer = $this->getTodayOffer();
        $todayOfferProduct = $arrTodayOffer['offer_details']['0']['fkProductId'];
        $limit = ($arrPost['limit']) ? $arrPost['limit'] : 9;
        
        $arrPost['offset'] = ($arrPost['offset'])?$arrPost['offset']:0;
        $arrPost['limit'] = ($arrPost['limit'])?$arrPost['limit']:200;
        $arrPost['userID'] = ($arrPost['userID'])?$arrPost['userID']:0;

        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice, DiscountFinalPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,Quantity,ProductDescription,ProductImage,
(select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = ".$arrPost['userID'].") as isWishList,                  
(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating,
                     (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
            FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON (pkCategoryId = product.fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
            INNER JOIN " . TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
            Group By pkProductID ORDER BY LastViewed DESC
            limit ".$arrPost['offset'].", ".$arrPost['limit'];


        $arrTopSellingRes = $this->getArrayResult($varQuery);
        
        //get total product
        $varQuery1 = "SELECT pkProductID  FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON (pkCategoryId = product.fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
                    INNER JOIN " . TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
            Group By pkProductID";
        
        
        $totalProCnt = count($this->getArrayResult($varQuery1));
        
        return array('productUrl' => $productImgUrl, 'totalProduct' => $totalProCnt, 'productList' => $arrTopSellingRes);
        //return $arrTopSellingRes;
    }

    /**
     * function getFestivalBanner
     *
     * This function is used to get the Festival banners set by admin.
     *
     * Database Tables used in this function are : tbl_home_banner
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getFestivalBanner($arrPost)
    {
        global $objCore;
        global $objGeneral;
        //check for limit
        $endLimit = ($arrPost['limit']) ? $arrPost['limit'] : '10';
//Below code commented due to Delay issue
        //$varCountry = $objGeneral->getCountryByIp();

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
        //$varQuery = "SELECT pkBannerID,BannerTitle,BannerImageName,FestivalTitle,pkFestivalID FROM " . TABLE_HOME_BANNER . " INNER JOIN " . TABLE_FESTIVAL . " as f ON fkFestivalID = pkFestivalID  WHERE BannerStatus = '1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' AND FestivalStatus='1' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "' AND FIND_IN_SET('" . $varCountry . "',f.CountryIDs) ORDER BY BannerOrder ASC  limit 0," . $endLimit;
        $varQuery = "SELECT pkBannerID,BannerTitle,BannerImageName,FestivalTitle,pkFestivalID FROM " . TABLE_HOME_BANNER . " INNER JOIN " . TABLE_FESTIVAL . " as f ON fkFestivalID = pkFestivalID  WHERE BannerStatus = '1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' AND FestivalStatus='1' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "' ORDER BY BannerOrder ASC  limit 0," . $endLimit;
        //echo $varQuery;die;
        $arrRes1 = $this->getArrayResult($varQuery);
        if (count($arrRes1) == 0)
        {
            $varQuery = "SELECT pkBannerID,BannerTitle,BannerImageName,FestivalTitle,pkFestivalID FROM " . TABLE_HOME_BANNER . " INNER JOIN " . TABLE_FESTIVAL . " as f ON fkFestivalID = pkFestivalID  WHERE  BannerStatus = '1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' AND FestivalStatus='1' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "' AND FIND_IN_SET('0',f.CountryIDs) ORDER BY BannerOrder ASC  limit 0," . $endLimit;
            
            $arrRes1 = $this->getArrayResult($varQuery);
        }

        $arrRow = array();
        $arrBIds = array();
        foreach ($arrRes1 as $k => $v)
        {
            $arrBIds[] = $v['pkBannerID'];
            $arrRow[$v['pkBannerID']] = $v;
        }

        $ids = implode(',', $arrBIds);
        if ($ids <> '')
        {
            $varQuery = "SELECT fkBannerID,UrlLinks,Offer,linkImagePosition FROM " . TABLE_HOME_BANNER_LINKS . " WHERE  fkBannerID IN(" . $ids . ") ";

            $arrRes2 = $this->getArrayResult($varQuery);

            foreach ($arrRes2 as $val)
            {
                $arrRow[$val['fkBannerID']]['arrLinks'][] = $val;
            }
        }
        
        foreach($arrRow as $key=>$varNew){
        $arrayNewRow[]=$varNew;    
        }
        //pre($arrayNewRow);
        return $arrayNewRow;
    }

    /**
     * function myorders
     *
     * This function is used to get user order details.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function myorders($arrPost)
    {
        $user = isset($arrPost['userId']) ? $arrPost['userId'] : '';
        if ($user != '')
        {
            $tableDiscounted = TABLE_ORDER;
            $arrDiscountedClms = array('pkOrderID', 'TransactionID', 'DATE_FORMAT(OrderDateAdded,"%d-%m-%Y") as date', 'TransactionAmount', 'OrderStatus');
            $whereDiscounted = "fkCustomerID='" . $user . "'";
            $getDiscountedData = $this->select($tableDiscounted, $arrDiscountedClms, $whereDiscounted);
            $getDiscountedData = count($getDiscountedData) > 0 ? $getDiscountedData : NO_PRODUCT;
            return $getDiscountedData;
        }
        else
        {
            return 'No Customer found!';
        }
    }
	

    /**
     * function makeReview
     *
     * This function is used to add review.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function makeReview($arrPost)
    {
             
        $objCore = new Core();
        $user = isset($arrPost['userId']) ? $arrPost['userId'] : '';
        $product = isset($arrPost['productId']) ? $arrPost['productId'] : '';
        if ($product != '' && $user != '')
        {
            $error = 0;
            $review = array('pkReviewID');
            $whereReview = 'fkCustomerID="' . $user . '" AND fkProductID="' . $product . '"';
            $reviewResult = $this->select(TABLE_REVIEW, $review, $whereReview);
            if (count($reviewResult) == 0)
            {

                $addReview = array('fkCustomerID' => $user, 'fkProductID' => $product, 'Reviews' => $objCore->stripTags($arrPost['message']), 'ApprovedStatus' => 'pending', 'ReviewDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
                $this->insert(TABLE_REVIEW, $addReview);
                $error = 1;
            }
            $rate = array('pkRateID');
            $whereRate = 'fkCustomerID="' . $user . '" AND fkProductID="' . $product . '"';
            $rateResult = $this->select(TABLE_PRODUCT_RATING, $rate, $whereRate);
            if (count($rateResult) == 0)
            {

                $addRate = array('fkCustomerID' => $user, 'fkProductID' => $product, 'Rating' => $arrPost['star'], 'RateDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
                $this->insert(TABLE_PRODUCT_RATING, $addRate);
                $error = 1;
            }
            if ($error == 1)
            {
                return 'Your Review has been successfully added';
            }
            else
            {
                return 'You have already reviewed this product';
            }
        }
        else
        {

            return 'Required field should not be blank.';
        }
    }

    /**
     * function makeOrder
     *
     * This function is used to add Order.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function makeOrder($arrPost)
    {

        $objCore = new Core();
        $user = isset($arrPost['userId']) ? $arrPost['userId'] : '';
        if ($user != '')
        {
            $arrClms = array(
                'pkCustomerID',
                'CustomerFirstName',
                'CustomerLastName',
                'CustomerEmail',
                'BillingFirstName',
                'BillingLastName',
                'BillingOrganizationName',
                'BillingAddressLine1',
                'BillingAddressLine2',
                'BillingCountry',
                'BillingPostalCode',
                'BillingPhone',
                'ShippingFirstName',
                'ShippingLastName',
                'ShippingOrganizationName',
                'ShippingAddressLine1',
                'ShippingAddressLine2',
                'ShippingCountry',
                'ShippingPostalCode',
                'ShippingPhone',
                'BusinessAddress'
            );
            $argWhere = "pkCustomerID='" . $user . "' ";
            $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere);

            if (count($arrRes) > 0)
            {
                $arrRes = $arrRes[0];
                $billingAddress = $arrPost['billingAddress'][0];
                $shippingAddress = $arrPost['shippingAddress'][0];
                $products = $arrPost['Products'][0];
                $arrClms = array(
                    'TransactionID' => $arrPost['transactionID'],
                    'TransactionAmount' => $arrPost['transactionAmount'],
                    'fkCustomerID' => $arrPost['userId'],
                    'CustomerFirstName' => $arrRes['CustomerFirstName'],
                    'CustomerLastName' => $arrRes['CustomerLastName'],
                    'CustomerEmail' => $arrRes['CustomerEmail'],
                    'CustomerPhone' => $arrRes['BillingPhone'],
                    'BillingFirstName' => $arrRes['CustomerFirstName'],
                    'BillingLastName' => $arrRes['CustomerLastName'],
                    'BillingAddressLine1' => $billingAddress['addressLine1'],
                    'BillingAddressLine2' => $billingAddress['addressLine2'],
                    'BillingCountry' => $billingAddress['country'],
                    'BillingPostalCode' => $billingAddress['zipCode'],
                    'BillingPhone' => $arrRes['BillingPhone'],
                    'ShippingFirstName' => ($arrRes['CustomerFirstName']),
                    'ShippingLastName' => $arrRes['CustomerLastName'],
                    'ShippingAddressLine1' => $shippingAddress['addressLine1'],
                    'ShippingAddressLine2' => $shippingAddress['addressLine2'],
                    'ShippingCountry' => $shippingAddress['country'],
                    'ShippingPostalCode' => $shippingAddress['ShippingPostalCode'],
                    'ShippingPhone' => $shippingAddress['zipCode'],
                    'OrderDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                );
                $arrAddID = $this->insert(TABLE_ORDER, $arrClms);

                $products = isset($products) ? $products : '';

                if (count($products) > 0)
                {

                    foreach ($products as $key => $val)
                    {
                        $productId = isset($val['id']) ? $val['id'] : 0;
                        $whProduct = "pkProductID='" . $productId . "'";
                        $calms = array('pkProductID', 'fkCategoryID', 'ProductRefNo', 'fkWholesalerID', 'fkShippingID', 'ProductName', 'ProductImage', 'ProductSliderImage', 'wholesalePrice', 'FinalPrice', 'DiscountPrice', 'DiscountFinalPrice', 'DateStart', 'DateEnd', 'Quantity', 'QuantityAlert', 'Weight', 'WeightUnit', 'Length', 'Width', 'Height', 'DimensionUnit', 'fkPackageId', 'ProductDescription', 'ProductTerms', 'YoutubeCode', 'ProductStatus');
                        $productDetails = $this->select(TABLE_PRODUCT, $calms, $whProduct);
                        if (count($productDetails) > 0)
                        {
                            $productDetails = $productDetails[0];
                            $varQty = $productDetails['Quantity'];
                            $varShippCost = $val['shipingCost'];

                            $varSubTotal = ($productDetails['FinalPrice'] * $varQty) + $varShippCost - $productDetails['DiscountPrice'];

                            $arrItemDetails = array(
                                '0' => array(
                                    'pkProductID' => $productDetails['pkProductID'],
                                    'ProductRefNo' => $productDetails['ProductRefNo'],
                                    'ProductName' => $productDetails['ProductName']
                                )
                            );

                            $jsonItemDetails = json_encode($arrItemDetails);
                            $varSubOrderID = $arrAddID . '-' . $productDetails['fkWholesalerID'];

                            $arrProductCols = array(
                                'fkOrderID' => $arrAddID,
                                'SubOrderID' => $varSubOrderID,
                                'ItemType' => 'product',
                                'fkItemID' => $productId,
                                'ItemName' => $productDetails['ProductName'],
                                'ItemImage' => $productDetails['ImageName'],
                                'fkWholesalerID' => $productDetails['fkWholesalerID'],
                                'fkShippingIDs' => $val['shipingId'],
                                'fkMethodID' => $val['shipingMethodId'],
                                'PriceCategory' => $productDetails['fkCategoryID'],
                                'ItemACPrice' => $productDetails['wholesalePrice'],
                                'ItemPrice' => $productDetails['FinalPrice'],
                                'Quantity' => $varQty,
                                'ItemSubTotal' => $val['FinalPrice'] * $varQty,
                                'AttributePrice' => $val['FinalPrice'] * $varQty,
                                'ShippingPrice' => $varShippCost,
                                'DiscountPrice' => $val['DiscountPrice'],
                                'ItemTotalPrice' => $varSubTotal,
                                'ItemDetails' => $jsonItemDetails,
                                'Status' => 'Pending',
                                'ItemDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                            );
                            $arrAddItemID = $this->insert(TABLE_ORDER_ITEMS, $arrProductCols);
                            //$arrOptions = $arrPost[''];

                            if ($arrProductCols['ItemType'] <> 'gift-card')
                            {
                                $this->UpdateProduct($arrProductCols['ItemType'], $arrProductCols['fkItemID'], $arrProductCols['Quantity'], '');
                            }
                        }
                    }
                }

                return 'Your order has been successfully made';
            }
        }
    }

    function UpdateProduct($argItemType, $argItemID, $argQty = 0, $arrOptions = '')
    {
        global $objGeneral;

        if ($argItemType == 'product')
        {
            $varProductIds = $argItemID;
            $arrAtr['product'][$varProductIds] = $arrOptions;
        }
        else if ($argItemType == 'package')
        {
            $query = "SELECT GROUP_CONCAT(fkProductId) as Pids FROM " . TABLE_PRODUCT_TO_PACKAGE . " WHERE fkPackageId = '" . $argItemID . "' GROUP BY fkPackageId";
            $arrRes = $this->getArrayResult($query);
            $varProductIds = $arrRes['0']['Pids'];
        }

        $query = "SELECT pkProductID,Quantity,Sold FROM " . TABLE_PRODUCT . " WHERE pkProductID in (" . $varProductIds . ")";
        $arrRows = $this->getArrayResult($query);

        foreach ($arrRows as $k => $v)
        {

            $varQty = $v['Quantity'] - $argQty;
            $varQt = ($varQty > 0) ? $varQty : 0;

            // $this->update(TABLE_PRODUCT, array('Quantity' => $varQt), " pkProductID = '" . $v['pkProductID'] . "' "); 

            $this->update(TABLE_PRODUCT, array('Quantity' => $varQt, 'Sold' => $v['Sold'] + 1), " pkProductID = '" . $v['pkProductID'] . "' ");
            $this->UpdateAttributeOptids($varProductIds, $argQty, $arrAtr['product'][$v['pkProductID']]);
        }

        $objGeneral->solrProductRemoveAdd("pkProductID in (" . $varProductIds . ")");

        return true;
    }

    function UpdateAttributeOptids($pid, $qty, $arrAttributeOption)
    {

        $arrAttr = array();
        $arrAttrOpt = array();
        $varOptIds = array();
        $objCore = new Core();
        $objShoppingCart = new ShoppingCart();
        foreach ($arrAttributeOption AS $attrOptions)
        {
            $attr = explode(':', $attrOptions);
            if ($attr[0] <> '')
            {
                $arrAttrbVals[] = (int) $attr[0];
                $arrAttrOpt[$attr[0]] = $attr[1];
            }
        }
        if (count($arrAttrbVals) > 0)
        {
            $varAttrIds = implode(',', $arrAttrbVals);
            $varQuery = "SELECT pkAttributeID FROM " . TABLE_ATTRIBUTE . " WHERE pkAttributeID IN (" . $varAttrIds . ") AND AttributeInputType IN ('image','select','radio','checkbox')";
            $arrResultRow = $this->getArrayResult($varQuery);
        }

        if (count($arrResultRow) > 0)
        {
            foreach ($arrResultRow as $val)
            {
                if ($arrAttrOpt[$val['pkAttributeID']] <> '')
                {
                    $varOptIds[] = trim($arrAttrOpt[$val['pkAttributeID']], ',');
                }
            }
            sort($varOptIds);

            $res = implode(',', $varOptIds);
            $varWhr = "fkProductID = '" . $pid . "' AND OptionIDs = '" . $res . "'";
            $varQuery = "SELECT OptionQuantity FROM " . TABLE_PRODUCT_OPTION_INVENTORY . " WHERE " . $varWhr;

            $arrRes = $this->getArrayResult($varQuery);

            $varQty = $arrRes[0]['OptionQuantity'] - $qty;
            $varQt = ($varQty > 0) ? $varQty : 0;
            $this->update(TABLE_PRODUCT_OPTION_INVENTORY, array('OptionQuantity' => $varQt), $varWhr);
        }
        return true;
    }

    /**
     * function getProductDetails
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image, tbl_category, tbl_wholesaler, tbl_order_option, tbl_product_rating, tbl_special_product, tbl_festival, tbl_product_to_option, tbl_attribute, tbl_attribute_option, tbl_recent_view
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getProductDetails($argProductId)
    {
    	global $productImgUrl;
        $userId = ($argProductId['userID'])?$argProductId['userID']:0;
        $objCore = new Core();
        $argProductId = $argProductId['productsId'];
        $slVal = array('pkProductID');
        $varWhere = "pkProductID = '" . $argProductId . "' AND ProductStatus='1'";
        $getVarified = $this->select(TABLE_PRODUCT, $slVal, $varWhere);
        if (count($getVarified) > 0)
        {
            $varQuery = "SELECT pkProductID,p.fkCategoryID,CategoryHierarchy,ProductName,FinalPrice, DiscountFinalPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent, YoutubeCode,FinalSpecialPrice,
                fkPackageId,Quantity,ProductDescription, (select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = ".$userId.") as isWishList, (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,
                 (select CAST(avg(Rating) as decimal(10,2)) from " . TABLE_PRODUCT_RATING . " as rat where rat.fkProductID=pkProductID AND RatingApprovedStatus='Allow') AS Rating,
                  (select count(pkReviewID) from " . TABLE_REVIEW . " as rev where rev.fkProductID=pkProductID AND ApprovedStatus='Allow') AS customerReviews,
                ProductImage as ImageName,count(fkAttributeId) as Attribute,pkWholesalerID FROM " . TABLE_PRODUCT . " as p LEFT JOIN "
                    . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID LEFT JOIN " . TABLE_PRODUCT_IMAGE . " as img ON pkProductID = img.fkProductID INNER JOIN "
                    . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND CategoryIsDeleted = '0' AND CategoryStatus = '1')
                        INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')
                            LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
                              WHERE " . $varWhere;
            $arrRes = $this->getArrayResult($varQuery);
            $varQuery3 = "SELECT ImageName FROM " . TABLE_PRODUCT_IMAGE . " WHERE fkProductID = '" . $argProductId . "' AND ImageName != '".$arrRes[0]['ImageName']."' order by ImageDateAdded DESC";
            $arrRes[0]['arrproductImages'] = $this->getArrayResult($varQuery3);
            $arrRes[0]['arrproductImages2']=$arrRes[0]['ImageName'];
            //echo count($arrRes);
            //echo pre($arrRes);die;
            $default_image =  array('ImageName' => $arrRes[0]['ImageName']);
            
            array_unshift($arrRes[0]['arrproductImages'],$default_image);
            $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
            
            $arrRes[0]['AttrQty'] = $this->getAttrQty($arrRes[0]['pkProductID']);
            
            $varQuery2 = "SELECT pkAttributeId,AttributeLabel,AttributeDesc,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle, GROUP_CONCAT(pkOptionID) as pkOptionID, GROUP_CONCAT(AttributeOptionValue) AS AttributeOptionValue,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice, GROUP_CONCAT(AttributeOptionImage) AS AttributeOptionImage,GROUP_CONCAT(IsImgUploaded) AS IsImgUploaded FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId WHERE fkProductId = '" . $argProductId . "'
             AND `AttributeVisible`='yes' GROUP BY pkAttributeId order by AttributeOrdering ASC";
            $arrRes[0]['productAttribute'] = $this->getArrayResult($varQuery2);
            $arrRes[0]['Quantity'] = (count($arrRes[0]['productAttribute']) > 0) ? $arrRes[0]['AttrQty'] : $arrRes[0]['Quantity'];
            
            //Find product reviews
            $varWhere = "rat.fkProductID = '" . $argProductId . "' AND ApprovedStatus = 'Allow' AND RatingApprovedStatus = 'Allow'";
            $varQuery = "SELECT Rating,CustomerFirstName as CustomerName,CustomerScreenName, rev.Reviews,
            ReviewDateAdded,ReviewDateUpdated FROM " . TABLE_PRODUCT_RATING . " as rat LEFT JOIN " . TABLE_CUSTOMER . " ON rat.fkCustomerID=pkCustomerID LEFT JOIN "
                    . TABLE_REVIEW . " as rev ON rev.pkReviewID=rat.pkRateID WHERE " . $varWhere . " group by pkCustomerID order by ReviewDateUpdated desc limit 0,10";

            $arrRes[0]['Reviews'] = $this->getArrayResult($varQuery);

            if ($_SESSION['sessUserInfo']['type'] == 'customer' && $_SESSION['sessUserInfo']['id'] > 0)
            {
                $arrClms = array(
                    'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
                    'fkProductID' => $argProductId,
                    'ViewDateAdded' => date(DATE_TIME_FORMAT_DB)
                );
                $this->insert(TABLE_RECENT_VIEW, $arrClms);
            }
            $arrId = array('catId' => $arrRes[0]['fkCategoryID'], 'proId' => $arrRes[0]['pkProductID']);
            
            $similarProducts = $this->getSimilarCategoryProducts($arrId);
            //pre($similarProducts);die;
            return array('productUrl' => $productImgUrl,'productDetails' => $arrRes, 'similarProducts' => $similarProducts);
        }
        else
        {

            return NO_PRODUCT;
        }
    }
    
    /**
     * function getProductDetailsForCart
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getProductDetailsForCart($argProductId)
    {
        $objCore = new Core();
        //$slVal = array('pkProductID,ProductName','ProductImage','FinalPrice','DiscountFinalPrice','ProductDescription');
        //$varWhere = "pkProductID = '" . $argProductId . "' AND ProductStatus='1'";
        //$getVarified = $this->select(TABLE_PRODUCT, $slVal, $varWhere);
        /*$varQuery = "SELECT pkProductID,ProductRefNo,ProductName,wholesalePrice,FinalPrice,DiscountPrice,DiscountFinalPrice,OfferACPrice,OfferPrice,Quantity,fkShippingID,ProductDescription,ProductImage,CategoryName,fkWholesalerID,CompanyName,CompanyEmail,PaypalEmailID,CompanyCountry, AdminEmail
                    FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_PRODUCT_TODAY_OFFER . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_CATEGORY . " ON fkCategoryID = pkCategoryId INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus<>'deactive') INNER JOIN " . TABLE_ADMIN . " ON (AdminCountry = CompanyCountry AND fkAdminRollId = 4)
                    WHERE pkProductID = '" . $argProductId. "' AND ProductStatus='1' Group By pkProductID";*/
		$varQuery = "SELECT pkProductID,ProductRefNo,ProductName,wholesalePrice,FinalPrice,DiscountPrice,DiscountFinalPrice,OfferACPrice,OfferPrice,Quantity,fkShippingID,ProductDescription,ProductImage,CategoryName,fkWholesalerID,CompanyName,CompanyEmail,CompanyCountry
                    FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_PRODUCT_TODAY_OFFER . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_CATEGORY . " ON fkCategoryID = pkCategoryId INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus<>'deactive') WHERE pkProductID = '" . $argProductId. "' AND ProductStatus='1' Group By pkProductID";			
                        $getVarified = $this->getArrayResult($varQuery);
        //print_r($varQuery);die;
		//pre($getVarified);
		$varQuery1 = "SELECT AdminEmail,PaypalEmailID FROM " . TABLE_ADMIN . " WHERE AdminCountry = " . $getVarified[0]['CompanyCountry'] . " AND fkAdminRollId = 4";
		//echo $varQuery1;
            $arrPackRow1 = $this->getArrayResult($varQuery1);
			//pre($arrPackRow1);
            $getVarified[0]['AdminEmail'] = $arrPackRow1[0]['AdminEmail'];
            $getVarified[0]['PaypalEmailID'] = $arrPackRow1[0]['PaypalEmailID'];
			//pre($getVarified);
        if (count($getVarified) > 0)
        {
            return $getVarified;
        }
        else
        {
            return NO_PRODUCT;
        }
    }
    

    /**
     * function getMegaMenu
     *
     * This function is used display the categories.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getMegaMenu($argRequest = null)
    {
        //SET THE STATUS TO READd
        $varQueryStatus = "update " . TABLE_CATEGORY_UPDATE_STATUS . " set CategoryUpdateReadByAndroid='0' WHERE 1";
        $this->getArrayResult($varQueryStatus);
        //Parent categories
        $arrClmsParent = " pkCategoryId,CategoryName";
        $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel=0';
        $varOrderBy = 'CategoryLevel ASC,CategoryOrdering ASC, CategoryHierarchy ASC,`CategoryName` ASC';
        $varOrderBySubCat = 'CategoryLevel DESC,CategoryOrdering DESC, CategoryHierarchy DESC,`CategoryName` DESC';
        $varTable = TABLE_CATEGORY;
        $varLimit = "";
        $varQuery = "SELECT " . $arrClmsParent . " FROM " . $varTable . " WHERE " . $varWhere . " ORDER BY " . $varOrderBy . " " . $varLimit;
        $arrRes = $this->getArrayResult($varQuery);
        $arrCat = array();

        //prepare the child array
        $arrClmsChild = " pkCategoryId as childCategoryID,CategoryName as childCategoryName";
        //Prepare childChild Array
        $arrClmsSubChild = " pkCategoryId as childSubCategoryID,CategoryName as childSubCategoryName";

        $arrChildCat = array();
        foreach ($arrRes as $cat)
        {
            $arrCatResult = array();
            //Create the array for main category
            $mainCategory = array('parentCategoryName' => $cat['CategoryName'], 'parentCategoryID' => $cat['pkCategoryId']);
            $varWhereChild = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel=1 AND CategoryParentId="' . $cat['pkCategoryId'] . '"';
            $varQuery = "SELECT " . $arrClmsChild . " FROM " . $varTable . " WHERE " . $varWhereChild . " ORDER BY " . $varOrderBySubCat . " " . $varLimit;
            //Create the array of the child categories
            $arrChildCat = $this->getArrayResult($varQuery);
            foreach ($arrChildCat as $subCat)
            {
                //Child Child categories
                $varWhereSubChild = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel=2 AND CategoryParentId="' . $subCat['childCategoryID'] . '"';
                $varQuery = "SELECT " . $arrClmsSubChild . " FROM " . $varTable . " WHERE " . $varWhereSubChild . " ORDER BY " . $varOrderBySubCat . " " . $varLimit;
                //Create the array of the subcategories
                $arrChildSubCat = $this->getArrayResult($varQuery);
                //Create the array in  the tree structure
                $arrCatResult[] = array(
                    'childCategoryID' => $subCat['childCategoryID'], 'childCategoryName' => $subCat['childCategoryName'], 'ChildSubCategories' => $arrChildSubCat);
            }

            $arrCat[] = array($mainCategory, $arrCatResult);
        }
        //print_r($arrCat);
        //print_r(json_encode($arrCat));die;
        return $arrCat;
    }
    
    
    /**
     * function getMenuByCategoryId
     *
     * This function is used display the categories.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getMenuByCategoryId($argRequest = null)
    {
    	global $categoryUrl;
    	global $childCategoryUrl;
    	global $categoryBannerImgUrl;
    	global $productImgUrl;
    	
    	$catId = $argRequest['catId'];
    	
    	//Get Category Banners
    	$catBanners = $this->getSpecialBanner($argRequest);
    	
    	//SET THE STATUS TO READd
    	$varQueryStatus = "update " . TABLE_CATEGORY_UPDATE_STATUS . " set CategoryUpdateReadByAndroid='0' WHERE 1";
    	$this->getArrayResult($varQueryStatus);
    	//Parent categories with its images
    	$arrClmsParent = " c.pkCategoryId,c.CategoryName, ci.categoryImage";
    	$varWhere = 'c.CategoryIsDeleted = 0 AND c.CategoryStatus = 1 AND c.pkCategoryId = '.$catId;
    	$varOrderBy = 'c.CategoryLevel ASC,c.CategoryOrdering ASC, c.CategoryHierarchy ASC,c.CategoryName ASC';
    	$varOrderBySubCat = 'c.CategoryLevel DESC,c.CategoryOrdering DESC, c.CategoryHierarchy DESC,c.CategoryName DESC';
    	$varTable = TABLE_CATEGORY .' as c LEFT JOIN tbl_category_images as ci ON c.pkCategoryId = ci.fkCategoryId';
    	$varLimit = "";
    	$varQuery = "SELECT " . $arrClmsParent . " FROM " . $varTable . " WHERE " . $varWhere . " ORDER BY " . $varOrderBy . " " . $varLimit;
    	//echo $varQuery;die; 
    	$arrRes = $this->getArrayResult($varQuery);
    	$arrCat = array();
    
    	//prepare the child array
    	$arrClmsChild = " c.pkCategoryId as childCategoryID,c.CategoryName as name, ci.categoryImage as childCategoryImage";
    	//Prepare childChild Array
    	$arrClmsSubChild = " c.pkCategoryId as childSubCategoryID,c.CategoryName as name, ci.categoryImage as image";
    
    	$arrChildCat = array();
    	foreach ($arrRes as $cat)
    	{
    		$arrCatResult = array();
    		//Create the array for main category
    		$mainCategory = array('name' => $cat['CategoryName'], 'parentCategoryID' => $cat['pkCategoryId'], 'level' => '0', 'image' => $cat['categoryImage']);
    		$varWhereChild = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId="' . $cat['pkCategoryId'] . '"';
    		$varQuery = "SELECT " . $arrClmsChild . " FROM " . $varTable . " WHERE " . $varWhereChild . " ORDER BY " . $varOrderBySubCat . " " . $varLimit;
    		//Create the array of the child categories
    		$arrChildCat = $this->getArrayResult($varQuery);
    		foreach ($arrChildCat as $subCat)
    		{
    			//Child Child categories
    			$varWhereSubChild = 'c.CategoryIsDeleted = 0 AND c.CategoryStatus = 1 AND c.CategoryLevel=2 AND c.CategoryParentId="' . $subCat['childCategoryID'] . '"';
    			$varQuery = "SELECT " . $arrClmsSubChild . " FROM " . $varTable . " WHERE " . $varWhereSubChild . " ORDER BY " . $varOrderBySubCat . " " . $varLimit;
    			//Create the array of the subcategories
    			$arrChildSubCat = $this->getArrayResult($varQuery);
    			//Create the array in  the tree structure
    			$arrCatResult[] = array(
    					'childCategoryID' => $subCat['childCategoryID'], 'name' => $subCat['name'], 'level' => '1', 'image'=>$subCat['childCategoryImage'],$arrChildSubCat);
    		}
    		$arrCat[] = array_merge($mainCategory, array($arrCatResult));
    		//$arrCat[] = array($mainCategory, $arrCatResult);
    	}
    	
    	//Get new Arrival by category id
    	$getNewArrival = $this->getLatestProductByCatId($argRequest);
    	
    	//Get Best Sellers
    	$bestSellers = $this->getBestSellerByCatId($argRequest);
    	
    	//Get Top Rated
    	$topRated = $this->getTopRatedById($argRequest);
    	
    	return array('productUrl' => $productImgUrl ,'categoryUrl'=>$childCategoryUrl, 'catBannerUrl'=>$categoryBannerImgUrl, 'catBanners'=>$catBanners, 'menuList'=>$arrCat, 'newArrivals' => $getNewArrival, 'bestSellers' => $bestSellers, 'topRated' => $topRated);
    }
    
    
    /**
     * function Menu
     *
     * This function is used display the categories.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getParentMenu($argRequest = null)
    {
        //SET THE STATUS TO READd
        $varQueryStatus = "update " . TABLE_CATEGORY_UPDATE_STATUS . " set CategoryUpdateReadByAndroid='0' WHERE 1";
        $this->getArrayResult($varQueryStatus);
        //Parent categories
        $arrClmsParent = " pkCategoryId,CategoryName";
        $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel=0';
        $varOrderBy = 'CategoryLevel ASC,CategoryOrdering ASC, CategoryHierarchy ASC,`CategoryName` ASC';
        $varOrderBySubCat = 'CategoryLevel DESC,CategoryOrdering DESC, CategoryHierarchy DESC,`CategoryName` DESC';
        $varTable = TABLE_CATEGORY;
        $varLimit = "";
        $varQuery = "SELECT " . $arrClmsParent . " FROM " . $varTable . " WHERE " . $varWhere . " ORDER BY " . $varOrderBy . " " . $varLimit;
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function getHomeScreenData
     *
     * This function is used display the categories.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    /*function getHomeScreenData($argRequest)
    {
        $limit = '9';
        //Get hot deals
        $tableDiscounted = TABLE_PRODUCT . " as product INNER JOIN " . TABLE_WHOLESALER . "  ON  fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID";
        $arrDiscountedClms = array('pkProductID', 'ProductName', 'FinalPrice', 'DiscountFinalPrice', 'ProductImage', 'floor(DiscountFinalPrice/FinalPrice) as discountPercent');
        $whereDiscounted = "product.ProductStatus='1' AND floor(DiscountFinalPrice / FinalPrice ) >=1 ";
        $orderDiscounted = "discountPercent DESC LIMIT " . $limit . "";
        $getDiscountedData = $this->select($tableDiscounted, $arrDiscountedClms, $whereDiscounted, $orderDiscounted);

        //Get most trending
        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,ProductImage, avg(Rating) AS Rating,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as pkCategoryId,floor(DiscountFinalPrice/FinalPrice) as discountPercent FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID
            WHERE ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' Group By pkProductID ORDER BY CategoryHierarchy ASC, Rating DESC LIMIT " . $limit . "";
        $arrResProd = $this->getArrayResult($varQuery);

        //Get today's offer
        $arrTodayOffer = $this->getTodayOffer();
        $todayOfferProduct = $arrTodayOffer['offer_details']['0']['fkProductId'];
        //Get Recently views
        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,ProductDescription,ProductImage,ProductSliderImage,floor(DiscountFinalPrice/FinalPrice) as discountPercent
            FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
            INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') WHERE Sold!=0
            ORDER BY Sold DESC
            LIMIT " . $limit . "";
        $arrTopSellingRes = $this->getArrayResult($varQuery);
        //Hot deals ->Most Discounted
        //Trending->Top rating        
        return array('getHotDeals' => $getDiscountedData, 'getMostTrending' => $arrResProd, 'getRecentlyViewed' => $arrTopSellingRes);
    }*/
    
    function getHomeScreenData($argRequest)
    {
    	global $categoryUrl;
    	global $bannerImgUrl;
    	global $productImgUrl;
    	global $arrProductImageResizes;
    	$limit = '9';
    	
    	//Get Today's offer
    	$arrTodayOffer = $this->getTodayOffer();
    	$todayOfferProduct = $arrTodayOffer['offer_details']['0']['fkProductId'];
    	
    	//Get Festive Banners
    	$resBanners = $this->getFestivalBanner($limit);
        $resBanners = ($resBanners == null)?array():$resBanners;
    	//Get Categories
    	$resCategories = $this->getCategories();
    	//print_r($resCategories);die;
    
    	//Get hot deals (Discounted data)
    	$tableDiscounted = TABLE_PRODUCT . " as product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN "
    			. TABLE_WHOLESALER . "  ON  product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID";
    	$arrDiscountedClms = array('pkProductID', 'ProductName', 'FinalPrice', 'DiscountFinalPrice', 'FinalSpecialPrice', 'ProductImage', 'floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent',
    			'(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from ' . TABLE_PRODUCT_RATING . ' where fkProductID=pkProductID AND RatingApprovedStatus="Allow") as avgRating',
    		    '(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice');
        $whereDiscounted = "product.ProductStatus='1' AND WholesalerStatus = 'active' AND floor( (FinalPrice - DiscountFinalPrice) / FinalPrice *100 ) >20 AND floor( (FinalPrice - DiscountFinalPrice) / FinalPrice *100 ) <=99 ";
    	$orderDiscounted = "discountPercent DESC LIMIT " . $limit . "";
    	        
    	$getDiscountedData = $this->select($tableDiscounted, $arrDiscountedClms, $whereDiscounted, $orderDiscounted);
        //print_r($getDiscountedData);die;
    	        
    	//Get Best Seller's
    	
    	$objCore = new Core();
    	//$dateAfter = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB, strtotime("-1 month")), DATE_TIME_FORMAT_DB);
    	$dateAfter = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
    	$varQuery = "SELECT p.Sold,p.pkProductID,sum(oi.Quantity) as pnum,p.ProductRefNo,p.ProductName,p.FinalPrice,p.DiscountFinalPrice,FinalSpecialPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,p.Quantity,p.ProductDescription,p.ProductDateAdded,p.ProductImage,count(fkAttributeId) as Attribute,
            (select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating,
                (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
            FROM " . TABLE_PRODUCT . " as p
                LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON  (pkProductID = fkItemID AND ItemDateAdded<= '" . $dateAfter . "' AND ItemType='product')
                    INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
    	                    INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')
                            LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON p.pkProductID = pto.fkProductId
    	
            Group By pkProductID HAVING p.Sold>1 ORDER BY p.Sold DESC
            limit 0," . $limit;
    	
    	$getBestSeller = $this->getArrayResult($varQuery);
    	
    
    	//Get New Arrival
    	$varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,IF(sum(atInv.OptionQuantity)>0,sum(atInv.OptionQuantity),Quantity) as Quantity,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,
             (select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating,
                 (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
          FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN "
                . TABLE_CATEGORY . " ON  (pkCategoryId = product.fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct') INNER JOIN "
                . TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN "
                . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId LEFT JOIN "
                . TABLE_PRODUCT_OPTION_INVENTORY . " as atInv ON pkProductID = atInv.fkProductID
          Group By pkProductID  ORDER BY pkProductID DESC
          limit 0," . $limit;
    	
    	$getNewArrival = $this->getArrayResult($varQuery);
    	
    	//Get getRecentlyViewed
    	
    	$varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice, DiscountFinalPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,Quantity,ProductDescription,ProductImage,
                 (select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating,
                     (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
            FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON (pkCategoryId = product.fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
    	            INNER JOIN " . TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
            Group By pkProductID ORDER BY LastViewed DESC
            limit 0," . $limit . "";
    	//echo $varQuery;die;
    	
    	$getRecentlyViewed = $this->getArrayResult($varQuery);
    	
    	
    	return array('categoryUrl'=>$categoryUrl ,'BannerUrl' => $bannerImgUrl, 'Url' => $productImgUrl, 'Categories'=>$resCategories, 'Banners' => $resBanners, 'getHotDeals' => $getDiscountedData, 'getBestSeller' => $getBestSeller, 'getNewArrival' => $getNewArrival, 'getRecentlyViewed' => $getRecentlyViewed);
    }

    /**
     * function getTodayOffer
     *
     * This function is used display the today's offer.
     *
     * Database Tables used in this function are : TABLE_PRODUCT, TABLE_CATEGORY, TABLE_WHOLESALER
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getTodayOffer($argArrPOST = NULL)
    {
        $argArrPOST['userID'] = ($argArrPOST['userID'])?$argArrPOST['userID']:0;
        $varQuery = "SELECT * FROM `tbl_product_today_offer` ";
        $arrRes['offer_details'] = $this->getArrayResult($varQuery);
        $varQuery2 = "SELECT pkProductID,ProductName,FinalPrice, DiscountFinalPrice, ProductDescription,ProductImage,
(select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = ".$argArrPOST['userID'].") as isWishList,             
(select CAST(avg(Rating) as decimal(10,2)) from " . TABLE_PRODUCT_RATING . " as rat where rat.fkProductID=pkProductID AND RatingApprovedStatus='Allow') AS Rating,
                (select count(pkReviewID) from " . TABLE_REVIEW . " as rev where rev.fkProductID=pkProductID AND ApprovedStatus='Allow') AS customerReviews 
        		FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON (pkCategoryId = fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID = '" . $arrRes['offer_details'][0]['fkProductId'] . "')
            INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')";
        
        $arrRes['product_details'] = $this->getArrayResult($varQuery2);
        return $arrRes;
    }
    
    
    /**
     * function getTodayOffer
     *
     * This function is used display the today's offer.
     *
     * Database Tables used in this function are : TABLE_PRODUCT, TABLE_CATEGORY, TABLE_WHOLESALER
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getTMOffers($argArrPOST = NULL)
    {
    	global $productImgUrl;
    	
    	$objCore = new Core();
    	$curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
    	$argArrPOST['userID'] = ($argArrPOST['userID'])?$argArrPOST['userID']:0;
        
    	$varQuery = "SELECT sp. SpecialPrice, sp.FinalSpecialPrice, p.pkProductID,p.ProductName,p.FinalPrice, p.DiscountFinalPrice, p.ProductDescription,p.ProductImage, p.discountPercent, f.FestivalTitle, f.FestivalStartDate, f.FestivalEndDate, 
(select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = ".$argArrPOST['userID'].") as isWishList,      			
(select CAST(avg(Rating) as decimal(10,2)) from " . TABLE_PRODUCT_RATING . " as rat where rat.fkProductID=pkProductID AND RatingApprovedStatus='Allow') AS Rating,
                (select count(pkReviewID) from " . TABLE_REVIEW . " as rev where rev.fkProductID=pkProductID AND ApprovedStatus='Allow') AS customerReviews 
    			FROM tbl_special_product sp 
    			inner JOIN tbl_product p ON p.pkProductID = sp.fkProductID and p.ProductStatus = 1 
    			inner JOIN tbl_festival f ON (f.pkFestivalID = sp.fkFestivalID and f.FestivalStatus = 1 and f.FestivalStartDate <='" . $curDate . "' AND f.FestivalEndDate>='" . $curDate . "')";
    	//echo $varQuery;die;
    	$arrRes['product_url'] = $productImgUrl;
    	$arrRes['today_offer'] = $this->getTodayOffer($argArrPOST);
    	$arrRes['festival_offers'] = $this->getArrayResult($varQuery);
    	return $arrRes;
    }
    

    /**
     * function getBestSeller
     *
     * This function is used display the Best Saller.
     *
     * Database Tables used in this function are : TABLE_PRODUCT,TABLE_ORDER_ITEMS,TABLE_CATEGORY,TABLE_WHOLESALER,TABLE_PRODUCT_TO_OPTION
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getBestSeller($argRequest)
    {
    	global $productImgUrl;
        $arrTodayOffer = $this->getTodayOffer();

        $todayOfferProduct = $arrTodayOffer['offer_details']['0']['fkProductId'];
        
        $argRequest['offset'] = ($argRequest['offset'])?$argRequest['offset']:0;
        $argRequest['limit'] = ($argRequest['limit'])?$argRequest['limit']:200;
        $argRequest['userID'] = ($argRequest['userID'])?$argRequest['userID']:0;

        $objCore = new Core();
        //$dateAfter = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB, strtotime("-1 month")), DATE_TIME_FORMAT_DB);
        $dateAfter = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
        $varQuery = "SELECT p.Sold,p.pkProductID,sum(oi.Quantity) as pnum,p.ProductRefNo,p.ProductName,p.FinalPrice,p.DiscountFinalPrice,FinalSpecialPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,p.Quantity,p.ProductDescription,p.ProductDateAdded,p.ProductImage,count(fkAttributeId) as Attribute,
            (select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = ".$argRequest['userID'].") as isWishList,
            (select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating,
                (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
            FROM " . TABLE_PRODUCT . " as p
                LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON  (pkProductID = fkItemID AND ItemDateAdded<= '" . $dateAfter . "' AND ItemType='product')
                    INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
                        INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')
                            LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON p.pkProductID = pto.fkProductId

            Group By pkProductID HAVING p.Sold>1 ORDER BY p.Sold DESC
            limit ".$argRequest['offset'].", ".$argRequest['limit'];

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        //Get total product count
        $varQuery1 = "SELECT p.Sold
            FROM " . TABLE_PRODUCT . " as p
                LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON  (pkProductID = fkItemID AND ItemDateAdded<= '" . $dateAfter . "' AND ItemType='product')
                INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
                INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')
                LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON p.pkProductID = pto.fkProductId
        
                Group By pkProductID HAVING p.Sold>1 ";
        $totalProCnt = count($this->getArrayResult($varQuery1));
       // print_r($totalProCnt);die;
        $totalProCnt = $totalProCnt;
        return array('productUrl' => $productImgUrl, 'totalProduct' => $totalProCnt, 'productList' => $arrRes);
        
        
        //return $arrRes;
    }
    
    
    /**
     * function getBestSeller
     *
     * This function is used display the Best Saller.
     *
     * Database Tables used in this function are : TABLE_PRODUCT,TABLE_ORDER_ITEMS,TABLE_CATEGORY,TABLE_WHOLESALER,TABLE_PRODUCT_TO_OPTION
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getBestSellerByCatId($argRequest)
    {
    	$argRequest['limit'] =9;
    	$arrTodayOffer = $this->getTodayOffer();
    	
    	$todayOfferProduct = $arrTodayOffer['offer_details']['0']['fkProductId'];
    
    	$objCore = new Core();
    	//$dateAfter = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB, strtotime("-1 month")), DATE_TIME_FORMAT_DB);
    	$dateAfter = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
    	$varQuery = "SELECT p.Sold,p.pkProductID,sum(oi.Quantity) as pnum,p.ProductRefNo,p.ProductName,p.FinalPrice,p.DiscountFinalPrice,FinalSpecialPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,p.Quantity,p.ProductDescription,p.ProductDateAdded,p.ProductImage,count(fkAttributeId) as Attribute, CategoryName,
            (select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating,
                (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
            FROM " . TABLE_PRODUCT . " as p
                LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON  (pkProductID = fkItemID AND ItemDateAdded<= '" . $dateAfter . "' AND ItemType='product')
                    INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND (CategoryHierarchy like'".$argRequest['catId'].":%' OR CategoryHierarchy ='".$argRequest['catId']."') AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
                        INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')
                            LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON p.pkProductID = pto.fkProductId
    
            Group By pkProductID HAVING p.Sold>1 ORDER BY p.Sold DESC
            limit 0," . $argRequest['limit'];
          //echo $varQuery;die;
                $arrRes = $this->getArrayResult($varQuery);
               //pre($arrRes);die;
                return $arrRes;
    }
    
    /*
     * 
     * 
     */
    function getAllBestSellerByCatId($argRequest)
    {
    	global $productImgUrl;
    	
    	$argRequest['offset'] = ($argRequest['offset'])?$argRequest['offset']:0;
    	$argRequest['limit'] = ($argRequest['limit'])?$argRequest['limit']:200;
    	$argRequest['userID'] = ($argRequest['userID'])?$argRequest['userID']:0;
    	$arrTodayOffer = $this->getTodayOffer();
    	 
    	$todayOfferProduct = $arrTodayOffer['offer_details']['0']['fkProductId'];
    
    	$objCore = new Core();
    	//$dateAfter = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB, strtotime("-1 month")), DATE_TIME_FORMAT_DB);
    	$dateAfter = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
    	$varQuery = "SELECT p.Sold,p.pkProductID,sum(oi.Quantity) as pnum,p.ProductRefNo,p.ProductName,p.FinalPrice,p.DiscountFinalPrice,FinalSpecialPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,p.Quantity,p.ProductDescription,p.ProductDateAdded,p.ProductImage,count(fkAttributeId) as Attribute, CategoryName,
(select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = ".$argRequest['userID'].") as isWishList,              
(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating,
                (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
            FROM " . TABLE_PRODUCT . " as p
                LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON  (pkProductID = fkItemID AND ItemDateAdded<= '" . $dateAfter . "' AND ItemType='product')
                    INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND (CategoryHierarchy like'".$argRequest['catId'].":%' OR CategoryHierarchy ='".$argRequest['catId']."') AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
                        INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')
                            LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON p.pkProductID = pto.fkProductId
    
            Group By pkProductID HAVING p.Sold>1 ORDER BY p.Sold DESC
            limit ".$argRequest['offset']."," . $argRequest['limit'];
          //echo $varQuery;die;
          $arrRes = $this->getArrayResult($varQuery);
          //pre($arrRes);die;
          
          //get total product
          $varQuery1 = "SELECT p.Sold,p.pkProductID,sum(oi.Quantity) as pnum,p.ProductRefNo,p.ProductName,p.FinalPrice,p.DiscountFinalPrice,FinalSpecialPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,p.Quantity,p.ProductDescription,p.ProductDateAdded,p.ProductImage,count(fkAttributeId) as Attribute, CategoryName,
            (select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating,
                (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
            FROM " . TABLE_PRODUCT . " as p
                LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON  (pkProductID = fkItemID AND ItemDateAdded<= '" . $dateAfter . "' AND ItemType='product')
                    INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND (CategoryHierarchy like'".$argRequest['catId'].":%' OR CategoryHierarchy ='".$argRequest['catId']."') AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
                              INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')
                            LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON p.pkProductID = pto.fkProductId
          
            Group By pkProductID HAVING p.Sold>1";
          //echo $varQuery;die;
          $totalProCnt = count($this->getArrayResult($varQuery1));
                      		
          return array('productUrl' => $productImgUrl, 'totalProduct' => $totalProCnt, 'productList' => $arrRes);

    }

    /**
     * function getAllCategories
     *
     * This function is used to find the all categories.
     *
     * Database Tables used in this function are : TABLE_CATEGORY
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrCat
     */
    function getAllCategories($varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1')
    {
    	
        $arrClms = " pkCategoryId, CategoryName, CategoryParentId, CategoryHierarchy, CategoryLevel";
        //$varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1';
        $varOrderBy = 'CategoryLevel ASC, CategoryOrdering ASC, CategoryHierarchy ASC, CategoryName ASC';
        $varTable = TABLE_CATEGORY;
        $varLimit = "";
        $varQuery = "SELECT " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhere . " ORDER BY " . $varOrderBy . " " . $varLimit;
        //die($varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        $arrCat = array();
        foreach ($arrRes as $v)
        {
            $arrCat[$v['CategoryParentId']][] = array('pkCategoryId' => $v['pkCategoryId'], 'CategoryName' => $v['CategoryName'], 'CategoryHierarchy' => $v['CategoryHierarchy'], 'CategoryLevel' => $v['CategoryLevel']);
        }
        return $arrCat;
    }

    /**
     * function getSearchResults
     *
     * This function is used display the data from Solr search.
     *
     * Database Tables used in this function are :Solr search based
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getSearchResults($argRequest)
    {
    	global $productImgUrl;
        //Prepare the array of the all categories
        $objCore = new Core();
        if(isset($argRequest) && $argRequest['catId']!="")
        {
            $arrCat = $this->getAllCategories('CategoryIsDeleted = 0 AND CategoryStatus = 1 AND pkCategoryId ='.$argRequest['catId']);
        }
        else
        {
            $arrCat = $this->getAllCategories('CategoryIsDeleted = 0 AND CategoryStatus = 1');
        }
        $arrCat = $this->getAllCategories();
        $_REQUEST['sortingId']=$argRequest['sortingId'];
        
        $whQuery = '';
        $cid = '';
        $varStartLimit = ($argRequest['startlimit']) ? $argRequest['startlimit'] : 0;
        $varEndLimit = ($argRequest['endlimit']) ? $argRequest['endlimit'] : 200;

        if ($argRequest['searchKey'] != '')
        {
            if ($argRequest['searchKey'] != '')
            {
                //$searchKey = htmlentities($argRequest['searchKey']);
                $searchKey = $argRequest['searchKey'];
                $whQuery .= '(ProductName:"' . $searchKey . '" OR ProductDescription:"' . $searchKey . '" OR CompanyName:"' . $searchKey . '" OR CategoryName:"' . $searchKey . '")';
            }
            if ($argRequest['frmPriceFrom'] > 0 && $argRequest['frmPriceTo'] > 0 && is_numeric($argRequest['frmPriceFrom']))
            {
                     $whQueryPrice2 .= " AND ";
                     $whQueryPrice2 .= "( DiscountFinalPrice:[" . $argRequest['frmPriceFrom'] . " TO " . $argRequest['frmPriceTo']. "])";
            }
            if($argRequest['catId'] != '')
            {
                $catId = $argRequest['catId'];
                $whQueryCat .= " AND ";
                $whQueryCat .= '(pkCategoryId:"' . $catId . '" OR CategoryParentId:"' . $catId . '")';            
            }
            
            //mail('anuj.singh@mail.vinove.com','hi',$whQuery.$whQueryPrice2);
            //print_r($whQuery);die;
            $varResult = getSolrResult($whQuery.$whQueryPrice2.$whQueryCat . ' AND ProductStatus:1', $varStartLimit, $varEndLimit, $arrCat[(int) $cid]);
            //var_dump($arrCat); die();
            //return array('productUrl' => $productImgUrl, $varResult);
            $varResult['productUrl'] = $productImgUrl;
            return $varResult;
        }
    }
    
    
    /**
     * function getFilterResults
     *
     * This function is used display the data from Solr search.
     *
     * Database Tables used in this function are :Solr search based
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getFilterResults1($argRequest)
    {  
        //Prepare the array of the all categories
        $objCore = new Core();
        if(isset($argRequest) && $argRequest['catId']!="")
        {
            $arrCat = $this->getAllCategories('CategoryIsDeleted = 0 AND CategoryStatus = 1 AND pkCategoryId ='.$argRequest['catId']);
        }
        else
        {
            $arrCat = $this->getAllCategories('CategoryIsDeleted = 0 AND CategoryStatus = 1');
        }
        //$arrCat = $this->getAllCategories();
        $_REQUEST['sortingId']=$argRequest['sortingId'];
        
        $whQuery = '';
        $cid = '';
        $varStartLimit = ($argRequest['startlimit']) ? $argRequest['startlimit'] : 0;
        $varEndLimit = ($argRequest['endlimit']) ? $argRequest['endlimit'] : 200;

        if ($argRequest['searchKey'] != '')
        {
            if ($argRequest['searchKey'] != '')
            {
                //$searchKey = htmlentities($argRequest['searchKey']);
                $searchKey = $argRequest['searchKey'];
                $whQuery .= '(ProductName:"' . $searchKey . '" OR ProductDescription:"' . $searchKey . '" OR CompanyName:"' . $searchKey . '" OR CategoryName:"' . $searchKey . '")';
            }
            if ($argRequest['frmPriceFrom'] > 0 && $argRequest['frmPriceTo'] > 0 && is_numeric($argRequest['frmPriceFrom']))
            {
                     $whQueryPrice2 .= " AND ";
                     $whQueryPrice2 .= "( DiscountFinalPrice:[" . $argRequest['frmPriceFrom'] . " TO " . $argRequest['frmPriceTo']. "])";
            }
            
            if($argRequest['wholsId'] != '')
            {
                if(is_array($argRequest['wholsId']))
                {
                    //print_r($argRequest['wholsId']);
                    $whQueryCat .= " AND ";
                    $strCond ="";
                    $i=0;
                    foreach($argRequest['wholsId'] as $kay=>$pId)
                    {
                        if($i==0)
                        {
                            $strCond .= 'pkWholesalerID:"' . $pId . '"';
                        }
                        else
                        {
                            $strCond .= ' OR pkWholesalerID:"' . $pId . '"';
                        }
                        $i++;
                    }
                    $whQueryCat .= '('.$strCond.')';
                }                
                else
                {
                    $wholsId = $argRequest['wholsId'];
                    $whQueryCat .= " AND ";
                    $whQueryCat .= '(pkWholesalerID:"' . $wholsId . '")'; 
                }
                
                if($argRequest['attr'] != '')
                {                
                /* for attr filter start */
                $whQueryAttr = "";
                $arrAttr = explode("#", $_REQUEST['attr']);
                foreach ($arrAttr as $strAttr)
                {
                    $arrAttr1 = explode(":", $strAttr);
                    if ($arrAttr1['1'] > 0)
                    {
                        $arrAttr2 = explode(",", $arrAttr1['1']);
                        foreach ($arrAttr2 as $attrb)
                        {
                            if ($whQueryAttr != '')
                                $whQueryAttr .= " OR ";
                            $whQueryAttr .= 'arrAttributes:*' . $attrb . '*';
                        }
                    }
                    if ($whQueryAttr != '')
                    {
                        if ($whQuery != '')
                            $whQuery .= " AND ";
                        $whQuery .= "($whQueryAttr)";
                    }
                    $whQueryAttr = '';
                }
                /* for attr filter end */
                }
                
            }
            
            //mail('anuj.singh@mail.vinove.com','hi',$whQuery.$whQueryPrice2);
            //echo $whQueryPrice2;die;
            $varResult = getSolrResult($whQuery.$whQueryPrice2.$whQueryCat . ' AND ProductStatus:1', $varStartLimit, $varEndLimit, $arrCat[(int) $cid]);
            //var_dump($arrCat); die();
            return $varResult;
        }
    }
    
    
    function getFilterResults($argRequest)
    {  
        //Prepare the array of the all categories
        //global $arrCat;
        $objCore = new Core();
        $whQuery = '';
        $cid = '';
        
        if(isset($argRequest) && $argRequest['catId']!="")
        {
            $arrCat = $this->getAllCategories('CategoryIsDeleted = 0 AND CategoryStatus = 1 AND pkCategoryId ='.$argRequest['catId']);
        }
        else
        {
            $arrCat = $this->getAllCategories('CategoryIsDeleted = 0 AND CategoryStatus = 1');
        }
        //$arrCat = $this->getAllCategories();
        //$_REQUEST['sortingId']=$argRequest['sortingId'];
        
        if ($argRequest['searchKey'] != '')
            {
                $searchKey = htmlentities($argRequest['searchKey']); 
                if ($whQuery != '')
                    $whQuery .= " AND ";
                $whQuery .= '(ProductName:"' . $searchKey . '" OR ProductDescription:"' . $searchKey . '" OR CompanyName:"' . $searchKey . '" OR CategoryName:"' . $searchKey . '")';
            }
            
        if ($argRequest['catId'] > 0)
        {
            $cid = (int) $argRequest['catId'];
            
            if ($whQuery != '')
                $whQuery .= " AND ";
                $whQuery .= '(pkCategoryId:' . $cid . ' OR CategoryParentId:' . $cid . ' OR CategoryGrandParentId:' . $cid . ')';
        }else
        {
            //$this->CategoryLevel = 0;
        }
        
        if ($argRequest['wholsId'] != '')
        {
            $whQueryWhl = '';
            $arrWhl = explode(",", $argRequest['wholsId']);
            foreach ($arrWhl as $whl)
            {
                if ($whQueryWhl != '')
                    $whQueryWhl .= " OR ";
                $whQueryWhl .= "pkWholesalerID:" . $whl;
            }
            if ($whQuery != '')
                $whQuery .= " AND ";
            $whQuery .= "($whQueryWhl)";
        }
        
        if ($argRequest['attr'] != '')
            {
                $whQueryAttr = "";
                $arrAttr = explode("#", $argRequest['attr']);
                foreach ($arrAttr as $strAttr)
                {
                    $arrAttr1 = explode(":", $strAttr);
                    if ($arrAttr1['1'] > 0)
                    {
                        $arrAttr2 = explode(",", $arrAttr1['1']);
                        foreach ($arrAttr2 as $attrb)
                        {
                            if ($whQueryAttr != '')
                                $whQueryAttr .= " OR ";
                            $whQueryAttr .= 'arrAttributes:*' . $attrb . '*';
                        }
                    }
                    if ($whQueryAttr != '')
                    {
                        if ($whQuery != '')
                            $whQuery .= " AND ";
                        $whQuery .= "($whQueryAttr)";
                    }
                    $whQueryAttr = '';
                }
            }
            
         if ($argRequest['frmPriceFrom'] > 0 && $argRequest['frmPriceTo'] > 0 && $argRequest['frmPriceFrom'] != 'all' && is_numeric($argRequest['frmPriceFrom']))
            {
                if ($whQuery != '' || $whQueryPrice1 != '')
                    $whQueryPrice2 .= " AND ";
                     $whQueryPrice2 .= "( DiscountFinalPrice:[" . $objCore->getRawPrice($argRequest['frmPriceFrom']) . " TO " . $objCore->getRawPrice($argRequest['frmPriceTo']) . "] OR FinalPrice:[" . $objCore->getRawPrice($argRequest['frmPriceFrom']) . " TO " . $objCore->getRawPrice($argRequest['frmPriceTo']) . "])";
            }
            else if ($argRequest['frmPriceFrom'] > 0 && $argRequest['frmPriceFrom'] != 'all' && is_numeric($argRequest['frmPriceFrom']))
            {
                if ($whQuery != '' || $whQueryPrice1 != '')
                    $whQueryPrice2 .= " AND ";
                 $whQueryPrice2 .= "(DiscountFinalPrice:[" . $objCore->getRawPrice($argRequest['frmPriceFrom']) . " TO " . FILTER_PRICE_LIMIT . "] OR FinalPrice:[" . $objCore->getRawPrice($argRequest['frmPriceFrom']) . " TO " . FILTER_PRICE_LIMIT . "])";
            }
            else if ($argRequest['frmPriceTo'] > 0 && $argRequest['frmPriceFrom'] != 'all' && is_numeric($argRequest['frmPriceFrom']))
            {
                if ($whQuery != '' || $whQueryPrice1 != '' || $whQueryPrice2 != '')
                    $whQueryPrice2 .= " AND ";
                $whQueryPrice2 .= "(DiscountFinalPrice:[0 TO " . $objCore->getRawPrice($argRequest['frmPriceTo']) . "] OR FinalPrice:[0 TO " . $objCore->getRawPrice($argRequest['frmPriceTo']) . "])";
            }else if ($argRequest['pid'] != '')
            {
                if ($whQuery != '')
                    $whQueryPrice1 .= " AND ";
                $whQueryPrice1 .= "(DiscountFinalPrice:[" . str_replace("-", " TO ", $argRequest['pid']) . "] OR FinalPrice:[" . str_replace("-", " TO ", $argRequest['pid']) . "])";
            }
            
            
            if (isset($argRequest['page']))
            {
                $varPage = $argRequest['page'];
            }
            else
            {
                $varPage = 0;
            }
            $varStartLimit = ($argRequest['startlimit']) ? $argRequest['startlimit'] : 0;
            $varEndLimit = ($argRequest['endlimit']) ? $argRequest['endlimit'] : 200;

            // echo $pStatus;
            //echo $whQuery . $whQueryPrice1 . $whQueryPrice2.'..'.$varStPage.'..'.PRODUCT_LISTING_LIMIT_PER_PAGE.'..'.$arrCat[(int) $cid]; die;
            $whQuery=$whQuery.' AND ProductStatus:1';
            $varResult = getSolrResult($whQuery . $whQueryPrice1 . $whQueryPrice2, $varStartLimit, $varEndLimit, $arrCat[(int) $cid], 1);
        
            return $varResult;
    }

    /**
     * function getAutoSuggest
     *
     * This function is used for auto suggest based on Solr search.
     *
     * Database Tables used in this function are :Solr search based
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getAutoSuggest($argRequest)
    {
        $keyword = addslashes(trim($argRequest["searchKey"]));
        $cid = trim($argRequest["catid"]);
        $catId = '';
        if ($keyword || $cid)
        {
            if ($cid > 0)
            {
                $catId = 'AND CategoryHierarchy:"|' . $cid . '|"';
            }
            //Search key in the wholesaler
            $whQuery = '(CompanyName:"' . $keyword . '" ' . $catId . ' )';
            $arrRes1 = getSolrWholesalerNameResult($whQuery);
            //Search key in the Category
            $whQuery = '(CategoryName:"' . $keyword . '" ' . $catId . ' )';
            $arrRes2 = getSolrCategoryNameResult($whQuery);
            //Search key in the Product
            $whQuery = '(ProductName:"' . $keyword . '" ' . $catId . ' )';
            $arrRes3 = getSolrProductNameResult($whQuery);


            return array('Wholesaler' => $arrRes1, 'Category' => $arrRes2, 'Product' => $arrRes3);
        }
    }

    /**
     * function cms
     *
     * This function is used to get the Telemela details.
     *
     * Database Tables used in this function are : tbl_cms
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function cms($arrPost)
    {
        $arrClms = array('pkCmsID', 'PageTitle', 'PageDisplayTitle', 'PageContent', 'PageKeywords', 'PageDescription', 'PageOrdering');
        $varTable = TABLE_CMS;
        $argWhere = "PagePrifix='" . $arrPost['PagePrifix'] . "'";
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        return $arrRes;
    }

    /**
     * function wholesaler
     *
     * This function is used to get the Telemela details.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getWholeSalerInfo($arrPost)
    {
    	
    	$varQuery ="SELECT pkWholesalerID,CompanyName,ContactPersonName,ContactPersonPosition,ContactPersonPhone,ContactPersonEmail,Services,AboutCompany, GROUP_CONCAT(CONVERT(fkShippingGatewaysID,CHAR( 8 ))) as shippingId, GROUP_CONCAT(ShippingTitle SEPARATOR ',') as shippingTitle 
    			FROM tbl_wholesaler left join tbl_wholesaler_to_shipping_gateway on pkWholesalerID = fkWholesalerID 
    			left join tbl_shipping_gateways on pkShippingGatewaysID = fkShippingGatewaysID 
    			WHERE pkWholesalerID = '" . $arrPost['wId'] . "' AND WholesalerStatus='active' 
    			GROUP BY fkWholesalerID";
        //$arrClms = array('pkWholesalerID', 'CompanyName', 'ContactPersonName', 'ContactPersonPosition', 'ContactPersonPhone', 'ContactPersonEmail', 'Services', 'AboutCompany');
       // $varWhere = "pkWholesalerID = '" . $arrPost['wId'] . "' AND WholesalerStatus='active'";
       // $arrRes = $this->select(TABLE_WHOLESALER, $arrClms, $varWhere);
    	$arrRes = $this->getArrayResult($varQuery);
    	
    	$varQuery1 = "SELECT ROUND((SUM(IF(IsPositive = 1, 1,0))/count(pkFeedbackID)*100)/20, 1) as avg FROM `tbl_wholesaler_feedback` 
    	WHERE fkWholesalerID = '" . $arrPost['wId'] . "'";
    	$arrRes1 = $this->getArrayResult($varQuery1);
    	 
    	$arrRes[0]['wholesaller_rating'] = $arrRes1[0]['avg'];
    	
    	return $arrRes;
    }

    /**
     * function getCountryList
     *
     * This function is used to get the Telemela details.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getCountryList($arrPost = null)
    {
        $arrClms = array('country_id as CountryId', 'name');
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms, 'status=1', 'name ASC');
        return $arrRes;
    }
	
	 /**
     * function getDisputeList
     *
     * This function is used to get the Telemela details.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getDisputeList($arrPost = null)

    {
        $arrClms = array('CommentID', 'Title');
        $arrRes = $this->select(TABLE_DISPUTED_COMMENT_LIST, $arrClms, '', 'CommentID DESC');
        return $arrRes;
    }
	
	/**
     * function getDisputeHistory
     *
     * This function is used to get the Telemela details.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getDisputeHistory($arrPost = null)

    {
		$objCore = new Core();
        $objCustomer = new Customer();
		$oid = $objCore->getFormatValue($arrPost['oid']);
		$cid = $objCore->getFormatValue($arrPost['cid']);
        $arrRes['orderProducts'] = $objCustomer->getOrderProductsMobile($oid,$cid);
		pre(unserialize($arrRes['orderProducts'][1]['arrDisputedCommentsHistory'][0]['CommentDesc']));
		pre($arrRes);
        return $arrRes;
    }
	
	 /**
     * function addOrderInDispute
     *
     * This function is used to add dispute.
     *
     * Database Tables used in this function are : tbl_order_disputed_comments
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function addOrderInDispute($arrPost)
    {    
	//pre($arrPost);
        $objCore = new Core();
		$objCustomer = new Customer();
		$cid = $arrPost['custId'];
		$oid = $objCore->getFormatValue($arrPost['dispute']['oid']);
		if (isset($arrPost['dispute']['type']) && $arrPost['dispute']['type'] == 'dispute' && $oid <> '') {
			$rewardpoints=$objCustomer->getrewieddetail($oid);
			$rewardid=$rewardpoints[0]['pkRewardPointID'];
			$fkCustomerID=$rewardpoints[0]['fkCustomerID'];
			$Points=$rewardpoints[0]['Points'];
			
			if(!empty($rewardid))
			{
			  $updatereward=$objCustomer->updaterewieddetail($rewardid,$fkCustomerID);  
			  
			}
			 //pre($rewardpoints);
			$objCustomer->markAsDisputed($arrPost['dispute'], $cid);
			return ORDER_DISPUTED_SUCCESS_MESSAGE;
		}else{
			return 'Unable to Dispute this order.';
		}
    }
	
	
	/**
     * function sendSupportMail
     *
     * This function is used to add dispute.
     *
     * Database Tables used in this function are :
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function sendSupportMail($arrPost)
    {    
	//pre($arrPost);
        $objCore = new Core();
        $objCustomer = new Customer();
		
		$this->arrSupportList = $objCustomer->supportList();
        if (isset($arrPost['supportInfo']['frmHidenAdd']) && $arrPost['supportInfo']['frmHidenAdd'] == 'Send') {   // Editing images record
			$objCustomer->addCustomerSupportMobile($arrPost['supportInfo']);
           return "Mail Sent.";
        }else{
			return "Unable to sent mail, please try again later.";
		}
		
    }

    /**
     * function getCountryName
     *
     * This function is used to get the Telemela details.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getCountryID($varCountryName)
    {
        $arrClms = array('country_id');
        $varWhere = "name like '%" . trim(addslashes($varCountryName)) . "' AND status='1'";
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms, $varWhere, 'name ASC');
        return $arrRes[0]['country_id'];
    }

    /**
     * function getLatestProducts
     *
     * This function is used to get host deals( top discounted) product.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getLatestProducts($arrPost)
    {
    	global $productImgUrl;
        //Get today's offer
        $arrTodayOffer = $this->getTodayOffer();
        $limit = ($arrPost['limit']) ? $arrPost['limit'] : 9;
        
        $arrPost['offset'] = ($arrPost['offset'])?$arrPost['offset']:0;
        $arrPost['limit'] = ($arrPost['limit'])?$arrPost['limit']:200;
        $arrPost['userID'] = ($arrPost['userID'])?$arrPost['userID']:0;
        
        $todayOfferProduct = $arrTodayOffer['offer_details']['0']['fkProductId'];
        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,IF(sum(atInv.OptionQuantity)>0,sum(atInv.OptionQuantity),Quantity) as Quantity,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,
(select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = ".$arrPost['userID'].") as isWishList,             
(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating,
                 (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
          FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN "
                . TABLE_CATEGORY . " ON  (pkCategoryId = product.fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct') INNER JOIN "
                . TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN "
                . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId LEFT JOIN "
                . TABLE_PRODUCT_OPTION_INVENTORY . " as atInv ON pkProductID = atInv.fkProductID
          Group By pkProductID  ORDER BY pkProductID DESC
          limit ".$arrPost['offset'].", ".$arrPost['limit'];

        $arrRes = $this->getArrayResult($varQuery);
        //print_r($arrRes);die;
        
        //get total products
        $varQuery1 = "SELECT pkProductID FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN "
                  		. TABLE_CATEGORY . " ON  (pkCategoryId = product.fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct') INNER JOIN "
                  		. TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN "
                  				. TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId LEFT JOIN "
                        . TABLE_PRODUCT_OPTION_INVENTORY . " as atInv ON pkProductID = atInv.fkProductID
          Group By pkProductID";
        
        $totalProCnt = count($this->getArrayResult($varQuery1));
        
        return array('productUrl' => $productImgUrl, 'totalProduct' => $totalProCnt, 'productList' => $arrRes);

       // return $arrRes;
    }

    /**
     * function getMegaMenu
     *
     * This function is used display the categories.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    public function getIphoneMegaMenu($argRequest = null)
    {
        global $catIconUrl;
        //SET THE STATUS TO READd
        $varQueryStatus = "update " . TABLE_CATEGORY_UPDATE_STATUS . " set CategoryUpdateReadByIphone='0' WHERE 1";
        $this->getArrayResult($varQueryStatus);
        //Parent categories
        $arrClmsParent = " pkCategoryId,tbl_category.CategoryName,categoryIconImage";
        $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel=0';
        $varOrderBy = 'CategoryLevel ASC,CategoryOrdering ASC, CategoryHierarchy ASC,tbl_category.CategoryName ASC';
        $varTable = TABLE_CATEGORY;
        $varLimit = "";
        $varQuery = "SELECT " . $arrClmsParent . " FROM " . $varTable . " left join  tbl_category_images on tbl_category.pkCategoryId = tbl_category_images.fkCategoryId  WHERE " . $varWhere . " ORDER BY " . $varOrderBy . " " . $varLimit;
        //echo $varQuery;die;
        $arrRes = $this->getArrayResult($varQuery);
        $arrCat = array();

        //prepare the child array
        $arrClmsChild = " pkCategoryId as childCategoryID,tbl_category.CategoryName as name, categoryIconImage";
        //Prepare childChild Array
        $arrClmsSubChild = " pkCategoryId as childSubCategoryID,tbl_category.CategoryName as name,CategoryLevel as level";

        $arrChildCat = array();
        foreach ($arrRes as $cat)
        {
            $arrCatResult = array();
            //Create the array for main category
            $mainCategory = array('name' => $cat['CategoryName'], 'parentCategoryID' => $cat['pkCategoryId'], 'icon' => $cat['categoryIconImage'], 'level' => '0');
            $varWhereChild = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel=1 AND CategoryParentId="' . $cat['pkCategoryId'] . '"';
            $varQuery = "SELECT " . $arrClmsChild . " FROM " . $varTable . " left join  tbl_category_images on tbl_category.pkCategoryId = tbl_category_images.fkCategoryId WHERE " . $varWhereChild . " ORDER BY " . $varOrderBy . " " . $varLimit;
            //Create the array of the child categories
            $arrChildCat = $this->getArrayResult($varQuery);
            
            foreach ($arrChildCat as $subCat)
            {
                //Child Child categories
                $varWhereSubChild = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel=2 AND CategoryParentId="' . $subCat['childCategoryID'] . '"';
                $varQuery = "SELECT " . $arrClmsSubChild . " FROM " . $varTable . " WHERE " . $varWhereSubChild . " ORDER BY " . $varOrderBy . " " . $varLimit;
                //Create the array of the subcategories
                $arrChildSubCat = $this->getArrayResult($varQuery);
                //Create the array in  the tree structure
                $arrCatResult[] = array(
                    'childCategoryID' => $subCat['childCategoryID'], 'name' => $subCat['name'],'icon' => $cat['categoryIconImage'], 'level' => '1', $arrChildSubCat);
            }

            $arrCat[] = array_merge($mainCategory, array($arrCatResult));
        }
        return array('catIconUrl' => $catIconUrl,'menuList'=>$arrCat);
        //return $arrCat;
    }

    /**
     * function getSupport
     *
     * This function is used display the supperted text.
     *
     * Database Tables used in this function are : tbl_support_ticket_type
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    public function getSupport($argRequest = null)
    {
        $arrClms = array(
            'pkTicketID',
            'TicketTitle',
        );
        $arrRes = $this->select(TABLE_SUPPORT_TICKET_TYPE, $arrClms);
        return $arrRes;
    }

    /**
     * function checkMegaMenuUpdate
     *
     * This function is used to check the category update.
     *
     * Database Tables used in this function are : tbl_category_update_status
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function checkMegaMenuUpdate($argRequest = null)
    {
        $varQueryStatus = "SELECT CategoryUpdateReadByAndroid as androidStatus, CategoryUpdateReadByIphone as IphoneStatus FROM " . TABLE_CATEGORY_UPDATE_STATUS . " WHERE 1 ";
        $arrResStatus = $this->getArrayResult($varQueryStatus);
        return array('IphoneStatus' => $arrResStatus[0]['IphoneStatus'], 'androidStatus' => $arrResStatus[0]['androidStatus']);
    }
    
    /**
     * function cartDetails
     *
     * This function is used to get cart details from live to mobile.
     *
     * Database Tables used in this function are : tbl_cart
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrCart
     */
    function cartDetails($argRequest = null) { 
        global $productImgUrl;
        $arrData = array();
        $objShoppingCart = new ShoppingCart();
		$objCustomer = new Customer();
        //get cart details of the customer
        $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . (int) $argRequest['customerId'] . "'");
		
		//Get Customer Details
		$arrCustomer = $objCustomer->CustomerDetailsForShipping($argRequest['customerId']);
		//pre($arrCustomer);die;
		if($argRequest['shippingInfoId'] == 2){
            $arrCustomer['ShippingFirstName'] = $arrCustomer['1_ShippingFirstName'];
            $arrCustomer['ShippingLastName'] = $arrCustomer['1_ShippingLastName'];
            $arrCustomer['ShippingOrganizationName'] = $arrCustomer['1_ShippingOrganizationName'];
            $arrCustomer['ShippingAddressLine1'] = $arrCustomer['1_ShippingAddressLine1'];
            $arrCustomer['ShippingAddressLine2'] = $arrCustomer['1_ShippingAddressLine2'];
            $arrCustomer['ShippingCountry'] = $arrCustomer['1_ShippingCountry'];
            $arrCustomer['ShippingPostalCode'] = $arrCustomer['1_ShippingPostalCode'];
            $arrCustomer['ShippingPhone'] = $arrCustomer['1_ShippingPhone'];
        } else if($argRequest['shippingInfoId'] == 3){
            $arrCustomer['ShippingFirstName'] = $arrCustomer['2_ShippingFirstName'];
            $arrCustomer['ShippingLastName'] = $arrCustomer['2_ShippingLastName'];
            $arrCustomer['ShippingOrganizationName'] = $arrCustomer['2_ShippingOrganizationName'];
            $arrCustomer['ShippingAddressLine1'] = $arrCustomer['2_ShippingAddressLine1'];
            $arrCustomer['ShippingAddressLine2'] = $arrCustomer['2_ShippingAddressLine2'];
            $arrCustomer['ShippingCountry'] = $arrCustomer['2_ShippingCountry'];
            $arrCustomer['ShippingPostalCode'] = $arrCustomer['2_ShippingPostalCode'];
            $arrCustomer['ShippingPhone'] = $arrCustomer['2_ShippingPhone'];
        } else {
			$arrCustomer['ShippingFirstName'] = $arrCustomer['ShippingFirstName'];
            $arrCustomer['ShippingLastName'] = $arrCustomer['ShippingLastName'];
            $arrCustomer['ShippingOrganizationName'] = $arrCustomer['ShippingOrganizationName'];
            $arrCustomer['ShippingAddressLine1'] = $arrCustomer['ShippingAddressLine1'];
            $arrCustomer['ShippingAddressLine2'] = $arrCustomer['ShippingAddressLine2'];
            $arrCustomer['ShippingCountry'] = $arrCustomer['ShippingCountry'];
            $arrCustomer['ShippingPostalCode'] = $arrCustomer['ShippingPostalCode'];
            $arrCustomer['ShippingPhone'] = $arrCustomer['ShippingPhone'];
		}
        //get CartData into serilize format ..Unserialize cart data to use as an array
        $varCartData = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));
		//echo count($varCartData);die;
        //pre($varCartData);die;
        //storing product,package,giftcard ids in array
        if (count($varCartData) > 0) {
            foreach ($varCartData['Product'] as $key => $cartD) {
                $varProductIds['productIds'][] = $key;
            }
            foreach ($varCartData['Package'] as $key => $cartD) {
                $varProductIds['packageIds'][] = $key;
            }
            foreach ($varCartData['GiftCard'] as $key => $cartD) {
                $varProductIds['giftIds'][] = $key;
            }
        }
        //array merge
        //$varCartData = array_merge($varProductIds, $varCartData);
        //get html format CartDetails from an array
        $dataDetails = $arrCart[0]['CartDetails'];
        //removeing single cots from string
        $dataDetailsRep = str_replace("'", '"', $dataDetails);
        //load dom class
        $dom = new DOMDocument;
        //parse html sting to dom class to convert as html
        $dom->loadHTML($dataDetailsRep);
        $rows = array();
        //logic to get project related data from html
        foreach ($dom->getElementsByTagName('tr') as $tr) {
            $cells = array();
            foreach ($tr->getElementsByTagName('td') as $td) {
                $links = $td->getElementsByTagName('img');
                foreach ($links as $link) {
                    $re = $link->getAttribute('src');
                    $cells[] = str_replace(UPLOADED_FILES_URL . "images/products/85x67/", "", $re);
                }
                if (!empty($td->nodeValue)) {
                    $cells[] = $td->nodeValue;
                }
            }
            $rows[] = $cells;
        }
        
        //define filds array
        $fildsArray = array('image', 'details', '', 'quantity', 'price');
        //define filds blank array
        $fildsArrayBlank = array();
        $lastWord = '';
        //logic to create array as type of cart data like product,package or giftcard
        foreach ($rows as $key => $fildsArrayVal) {
            $secoundArray = $fildsArrayVal;
            foreach ($secoundArray as $key => $fildsVal) {
                //assign type of cart data
                if (!empty($fildsArray[$key])) {
                    if ($key == 1) {
                        $varStr = trim(str_replace("\n", "", $fildsVal));//removing new line space
                        $words = explode(" ", $varStr);//convert string to array
                        $lastWord = array_pop($words);//get last word
                    }
                }
            }
            foreach ($secoundArray as $key => $fildsVal) {
                if (!empty($fildsArray[$key])) {
                    if ($lastWord != '') {
                        //assign cart data to specific type of product
                        $fildsArrayBlank[$lastWord . '_' . $fildsArray[$key]][] = $fildsVal;
                    }
                }
            }
        }
        //pre($fildsArrayBlank);
        $varCartDataNew = array_merge($fildsArrayBlank, $varCartData);
        //echo "<pre>";print_r($varCartData);
        $a=0;
        $total = 0;
        $arrData=array();
        //pre($varCartData);die;
        foreach($varCartData['Product'] as $key=>$val)
        {
            
            foreach($val as $kk=>$kv)
            {          
                $arrOptTemp = array();
                $pDetaisl = $this->getProductDetailsForCart($key);
				//pre($pDetaisl);die;
                //get shipping details
				  $isDom = ($varCustomerCountry == $pDetaisl[0]['CompanyCountry']) ? 1 : 0;
				 $arrData['products'][$a]['ShippingDetails'] = $this->getShippingDetailsForProduct($pDetaisl[0]['pkProductID'], $pDetaisl[0]['fkShippingID'], $kv['qty'], 0, $isDom, $arrCustomer);
				  //pre($pDetaisl);die;
				  
                if ($pDetaisl[0]['OfferPrice'] <> '' || $pDetaisl[0]['OfferPrice'] > 0) {
                    $varUsePrice = $pDetaisl[0]['OfferPrice'];
                    $varPriceCategory = 'Offer';
                }
                else if($pDetaisl[0]['DiscountFinalPrice'] > 0) {
                    $varUsePrice = $pDetaisl[0]['DiscountFinalPrice'];
                    $varPriceCategory = 'Discount';
                } else {
                    $varUsePrice = $pDetaisl[0]['FinalPrice'];
                    $varPriceCategory = 'Price';
                }
                $arrData['products'][$a]['productID']=$pDetaisl[0]['pkProductID'];
                $arrData['products'][$a]['Index']=$kk;
                $arrData['products'][$a]['ProductName']=$pDetaisl[0]['ProductName'];
                $arrData['products'][$a]['ProductImage']=$pDetaisl[0]['ProductImage'];
                $arrData['products'][$a]['ProductFinalPrice']=$pDetaisl[0]['FinalPrice'];
                $arrData['products'][$a]['DiscountFinalPrice']=$pDetaisl[0]['DiscountFinalPrice'];
                $arrData['products'][$a]['ProductDescription']=$pDetaisl[0]['ProductDescription'];
				$arrData['products'][$a]['fkWholesalerID']=$pDetaisl[0]['fkWholesalerID'];
				$arrData['products'][$a]['CompanyCountry']=$pDetaisl[0]['CompanyCountry'];
				$arrData['products'][$a]['AdminEmail']=$pDetaisl[0]['AdminEmail'];
				$arrData['products'][$a]['CompanyEmail']=$pDetaisl[0]['CompanyEmail'];
				$arrData['products'][$a]['PaypalEmailID']=$pDetaisl[0]['PaypalEmailID'];
                $arr=$kv['attribute'];
                $attr = implode("#",$arr);
                //print_r($attr);
               //pre($attr);die;
                //$arrData[$a]['attribute']=$attr;
                $attrArrProvided = explode('#',$attr);
                
                $attr = explode(':', $attrOptions);

                foreach ($attrArrProvided AS $attrOptions) {
                    $attr = explode(':', $attrOptions);
                    if (!empty($attr[1])) {   
                        $arrOptTemp[] = $attr[1];
                        $num = count($arrOptTemp);
                    }
                }
                $optionid = implode(',',$arrOptTemp);
                $arrAttribute = $objShoppingCart->getAttributeName($key, $attrArrProvided);
                
                $arrData['products'][$a]['indexAttribute']=$arrAttribute['details'];
                $arrData['products'][$a]['ProductQuantity']=$kv['qty'];
                $arrData['products'][$a]['FinalPrice'] = $varUsePrice + $arrAttribute['price'];
                $arrData['products'][$a]['optionid']=$optionid;
                $total = ($total+$kv['qty']);
                $a++;
				
            }
			
            $total1 = $total;
        }
		
        $arrData['total']=($total1 != '')?$total1:0;
	//pre($arrData);die;
        if(!isset($arrData['products']))
            $arrData['products'] = array();
        
        if(isset($argRequest['getCount'])):
             return $arrData['total'];
        else:
            return array('productUrl' => $productImgUrl, 'cartDetail' => $arrData);
        endif;
    }
    
    function removeAllCartDetails($id=0){
        $where = "fkCustomerID='".$id."'";
        return $this->delete(TABLE_CART, $where);
    }
    
    
    function myCartDetails($arrCustomer = array()) {
             
        global $objCore;
        global $objGeneral;
        $objShoppingCart=new ShoppingCart;
        
        $varCount = (int) $arrCustomer['Product'];
        if ($varCount > 0) {
            
            $contt = 0;
            foreach ($arrCustomer['Product'] as $key => $val) { 
                foreach ($val as $sessIndex => $sessVal) { //echo $sessIndex.'<br>';
                    $id=explode('-',$sessIndex);
                    //echo "!@";die;
                    
                    $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,wholesalePrice,FinalPrice,DiscountPrice,DiscountFinalPrice,OfferACPrice,OfferPrice,Quantity,fkShippingID,ProductDescription,ProductImage as ImageName,CategoryName,fkWholesalerID,CompanyName,CompanyCountry
                FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_PRODUCT_TODAY_OFFER . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_CATEGORY . " ON fkCategoryID = pkCategoryId INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus<>'deactive')
                WHERE pkProductID = '" . $key. "' AND ProductStatus='1' Group By pkProductID";
                    $arrRow = $this->getArrayResult($varQuery);
                    //pre($arrRow);
                    
                    //if(count($arrRow)==0){
                    //    (int) $_SESSION['MyCart']['Total']-=1;
                    //    unset($_SESSION['MyCart']['Product'][$key]); 
                    //}
                    $attrArrProvided=explode('#',$sessVal['attribute']);
                    //pre($attrArrProvided);
                    $arrAttribute = $objShoppingCart->getAttributeName($arrRow[0]['pkProductID'], $attrArrProvided);
                    //pre($arrAttribute);
                    $arrRow[0]['attribute'] = $arrAttribute['details'];
                    $arrRow[0]['attributePrice'] = $arrAttribute['price'];
                    $arrRow[0]['ImageName'] = $objCore->getvalidImage($arrAttribute['image'], $arrRow[0]['ImageName'], 'products/' . $arrProductImageResizes['default']);
                    
                    //$arrRow[0]['attributeImage'] = $objCore->getvalidImage($arrAttribute['image'], $arrRow[0]['ImageName'], 'products/' . $arrProductImageResizes['default']);
                    
                    $arrRow[0]['attrOptMaxQty'] = (int) $objShoppingCart->getAttributeStock($arrRow[0]['pkProductID'], $sessVal['attribute']);                   
                    $arrRes['Product'][$sessIndex] = $arrRow[0];                   
                    $arrRes['Product'][$sessIndex]['qty'] = $sessVal['qty'];
                    
                    //if ($isAccess) {
                    //    $isDom = ($varCustomerCountry == $arrRow[0]['CompanyCountry']) ? 1 : 0;
                    //  $arrRes['Product'][$sessIndex]['ShippingDetails'] = $this->getShippingDetailsForProduct($arrRow[0]['pkProductID'], $arrRow[0]['fkShippingID'], $arrRes['Product'][$sessIndex]['qty'], 0, $isDom, $arrCustomer);
                    //   
                    //   //Please uncomment while start shwoing logistic on site and comment above line:Raju comment
                    //    //$arrRes['Product'][$sessIndex]['ShippingDetails'] = $this->getShippingDetailsForProductLogistic($arrRow[0]['fkWholesalerID'],$arrCustomer['pkCustomerID'], $arrRes['Product'][$sessIndex]['qty'],$arrRow[0]['pkProductID']);
                    //}

                    //$arrRes['Product'][$sessIndex]['AppliedShipping'] = $_SESSION['MyCart']['Product'][$key][$sessIndex]['AppliedShipping'];
                    //$arrUserList = $this->select($varQuery);
                    $arrPids[] = $arrRow[0]['pkProductID'];

                    $contt++;
                }
            }

            $arrSpecialProductPrice = $objGeneral->getAllSpecialProductPrice(implode(',', $arrPids));
        }

        
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
            $arrRes['Product'][$key]['DiscountPrice1']=$val['DiscountPrice'];
            $arrRes['Product'][$key]['DPrice'] = $val['FinalPrice'];
            $arrRes['Product'][$key]['ACPrice'] = $varACPrice;
            $arrRes['Product'][$key]['ItemPrice'] = $varUsePrice;
            $arrRes['Product'][$key]['FinalPrice'] = $varUsePrice + $arrRes['Product'][$key]['attributePrice'];
            $arrRes['Product'][$key]['PriceCategory'] = $varPriceCategory;
            unset($arrRes['Product'][$key]['wholesalePrice'], $arrRes['Product'][$key]['DiscountPrice'], $arrRes['Product'][$key]['DiscountFinalPrice'], $arrRes['Product'][$key]['OfferACPrice'], $arrRes['Product'][$key]['OfferPrice']);
        }
        
        //foreach ($_SESSION['MyCart']['GiftCard'] as $key => $val) {
        //    $arrRes['GiftCard'][$key]['amount'] = $val['amount'];
        //    $arrRes['GiftCard'][$key]['fromName'] = $val['fromName'];
        //    $arrRes['GiftCard'][$key]['toName'] = $val['toName'];
        //    $arrRes['GiftCard'][$key]['toEmail'] = $val['toEmail'];
        //    $arrRes['GiftCard'][$key]['message'] = $val['message'];
        //    $arrRes['GiftCard'][$key]['qty'] = $val['qty'];
        //}
        
        //pre($arrRes['GiftCard']);
        //if (isset($_SESSION['MyCart']['CouponCode']) && $_SESSION['MyCart']['CouponCode'] <> '') {
        //    $arrRes['Common']['CouponCode'] = $_SESSION['MyCart']['CouponCode'];
        //    $arrResCoupon = $this->select(TABLE_COUPON, array("pkCouponID", "CouponCode", "Discount", "IsApplyAll"), " CouponCode = '" . $arrRes['Common']['CouponCode'] . "'");
        //
        //
        //    foreach ($arrRes['Product'] as $key => $val) {
        //
        //        if ($arrResCoupon[0]['IsApplyAll'] == 1) {
        //            $arrRes['Product'][$key]['Discount'] = ($arrResCoupon[0]['Discount'] * $val['FinalPrice'] * $_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['qty']) / 100;
        //        } else {
        //            $varWhr = " AND fkProductID = '" . $val['pkProductID'] . "' AND fkCouponID = '" . $arrResCoupon[0]['pkCouponID'] . "' ";
        //            $varNum = $this->getNumRows(TABLE_COUPON_TO_PRODUCT, "fkProductID", $varWhr);
        //
        //            if ($varNum > 0) {
        //                $arrRes['Product'][$key]['Discount'] = ($arrResCoupon[0]['Discount'] * $val['FinalPrice'] * $_SESSION['MyCart']['Product'][$val['pkProductID']][$key]['qty']) / 100;
        //            } else {
        //                $arrRes['Product'][$key]['Discount'] = 0.00;
        //            }
        //        }
        //    }
        //} else {
            $arrRes['Common']['CouponCode'] = '';
        //}
        
        $arrRes['Common']['CartCount'] = $varCount;


        // Find Packages Details for products
//        if ($_SESSION['MyCart']['Package']) {
//            /* $varCartIDS = implode(',', array_keys($_SESSION['MyCart']['Package']));
//              $varQuery = "SELECT pkPackageId,fkWholesalerID,CompanyName,PackageName,PackagePrice,PackageImage FROM " . TABLE_PACKAGE . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID  WHERE pkPackageId IN (" . $varCartIDS . ") ";
//              $arrRes['Package'] = $this->getArrayResult($varQuery);
//             */
//            //$packcount = 0;
//
//            foreach ($_SESSION['MyCart']['Package'] as $packkey => $packval) {
//
//                foreach ($packval as $sessIndex => $sessVal) {
//                    if ($sessIndex != 'TotalShippingCost' && $sessIndex != 'ProductShippingCost') {
//                        $varQuery = "SELECT pkPackageId,pk.fkWholesalerID,CompanyName,CompanyCountry,PackageName,PackageACPrice,PackagePrice,PackageImage,MIN( Quantity ) as Quantity FROM " . TABLE_PACKAGE . " pk LEFT JOIN " . TABLE_WHOLESALER . " w ON fkWholesalerID = w.pkWholesalerID INNER JOIN ".TABLE_PRODUCT_TO_PACKAGE." x ON pkPackageId = x.fkPackageId
//LEFT JOIN ".TABLE_PRODUCT." p ON p.pkProductID = x.fkProductId WHERE pkPackageId = " . $packkey . " ";
//                        $arrPackRow = $this->getArrayResult($varQuery);
//                        //pre($arrPackRow);
//                        //$getProduct= $this->getProductForPackage($arrPackRow[0]['pkPackageId']); 
//                        $arrPackRow[0]['product'] = $sessVal['product'];
//                        //$arrPackRow[0]['product']=$arrPackRow[0]['ProductIds'];
//                        $arrPackRow[0]['productDetail'] = $this->getPackageProductsDetails($sessVal['product']);
//                        //$arrPackRow[0]['productDetail'] = $this->getPackageProductsDetailsNew($arrPackRow[0]['ProductIds']);
//                        $arrRes['Package'][$sessIndex] = $arrPackRow[0];
//
//                        if ($isAccess) {
//                            $isDom = ($varCustomerCountry == $arrPackRow[0]['CompanyCountry']) ? 1 : 0;
//                            
//                            $arrRes['Package'][$sessIndex]['ShippingDetails'] = $this->getShippingDetailsForPackage($arrPackRow[0]['fkWholesalerID'],$arrCustomer['pkCustomerID'], $_SESSION['MyCart']['Package'][$packkey][$sessIndex]['qty'],$arrPackRow[0]['pkPackageId']);
//                            
//                            //Please uncomment while start shwoing logistic on site and comment above line:Raju comment
//                            //$arrRes['Package'][$sessIndex]['ShippingDetails'] = $this->getShippingDetailsForProductLogisticForPackage($arrPackRow[0]['fkWholesalerID'],$arrCustomer['pkCustomerID'], $_SESSION['MyCart']['Package'][$packkey][$sessIndex]['qty'],$arrPackRow[0]['pkPackageId']);
//                            
//                            
//                        }
//
//                        $arrRes['Package'][$sessIndex]['qty'] = $_SESSION['MyCart']['Package'][$packkey][$sessIndex]['qty'];
//                        $arrRes['Package'][$sessIndex]['AppliedShipping'] = $_SESSION['MyCart']['Package'][$packkey][$sessIndex]['AppliedShipping'];
//                        //$packcount++;
//                    }
//                }
//            }
//
//
//            $arrRes['Package'] = array_reverse($arrRes['Package']);
//        }
        //pre($_SESSION['MyCart']['Product']);
        //$arrRes = array_reverse($arrRes);
        //pre($arrRes);
        
        return $arrRes;
    }
    
    /**
     * function getStock
     *
     * This function is used to get product stock
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    
    function getStock($argRequest = null){
        $objShoppingCart = new ShoppingCart(); 
        $pid = $argRequest['pid'];
        $optIds = trim($argRequest['optIds'], ',');      

        $arrRows = $objShoppingCart->getStock($pid, $optIds);
        return $arrRows;
    }
	
	
	/**
     * function getStock
     *
     * This function is used to process paypal payment
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    
    function getpaypalUrl($arrCart = null){
		
		$objShoppingCart = new ShoppingCart(); 
        $objClassCommon = new ClassCommon();
		//echo 123;die;
		//pre($arrCart);die;
	/*Update cart data*/
	//$row = "<tr><td align=\"center\" valign=\"top\"><img src=\"http://dothejob.in/telamela-new/common/uploaded_files/images/products/85x67/20150605_052917_536425785.jpg\" /></td><td align=\"left\" valign=\"top\"><strong onclick=\"window.location='product_view_uil.php?type=view&id=8324'\">Hidesign Women's Tote Bag (Pink Aubergine)</strong><br>((:))<br>By : Kumars Warehouse india pvt ltd.111<br>Product</td><td align=\"center\" valign=\"top\">5.65</td><td align=\"center\" valign=\"top\">1</td><td align=\"center\" valign=\"top\">6.22</td></tr><tr><td align=\"center\" valign=\"top\"><img src=\"http://dothejob.in/telamela-new/common/uploaded_files/images/products/85x67/1905593922.jpeg\" /></td><td align=\"left\" valign=\"top\"><strong onclick=\"window.location='product_view_uil.php?type=view&id=8331'\">La Coeur Ring</strong><br>((:))<br>By : DEW private ltd <br>Product</td><td align=\"center\" valign=\"top\">15.00</td><td align=\"center\" valign=\"top\">1</td><td align=\"center\" valign=\"top\">16.5</td></tr>";
		$arrClmsUpdate = array(
                'fkCustomerID' => $arrCart['custId'],
				//'CartDetails' => $row,
                'CartData' => serialize($arrCart['MyCart']),
                'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
            );
//pre($arrClmsUpdate);die;
           
		$argWhere = "fkCustomerID = '" . $arrCart['custId'] . "' ";
		$arrInsertID = $this->update(TABLE_CART, $arrClmsUpdate, $argWhere);
     /*Update cart data*/    
		 
		
		$responseData = "";
        define("DEFAULT_SELECT", "- Select -");
		$cancelUrl = SITE_ROOT_URL."payment_cancel.php";
		$memo = "Adaptive Payment - chained Payment";
		$actionType = "PAY";
		$currencyCode = "USD";

		//if(count($arrCart['GiftCard'])>0){ 
		 //$returnUrl = SITE_ROOT_URL."gift_success.php";
		//}else{
			
		$returnUrl = SITE_ROOT_URL."payment_success_mobile.php?custId=".$arrCart['custId']."&shippingInfoId=".$arrCart['shippingInfoId'];
		//}
		
		//$amount = $_POST['amount'];
		//$receiverEmail = array("business1.test@gmail.com", "business2.test@gmail.com");
		//$receiverAmount = array("40", "35");
		//$primaryReceiver = array("true", "false");
		$receiverAmount = array();
		$receiverEmail = array();

		$arrCart[portalData] = array_values($arrCart[portalData]);

		for ($i =0; $i < count($arrCart[portalData]); $i++){
			$pricewithshipping = $arrCart[portalData][$i]['PriceWithShipping'];
		    $adminmail = $arrCart[portalData][$i]['PaypalEmailID'];
			//$pricewithshipping = $arrCart[portalData][$i]['PriceWithShipping'];
			//$adminmail = $arrCart[portalData][$i]['AdminEmail'];
			
			if($pricewithshipping != "" and $adminmail != ""){
				$receiverAmount[] = $pricewithshipping;
				
				$receiverEmail[] = $adminmail;
			}else{
				$responseData = "Receiver Email id NOT found !!";
				return $responseData;
			}
		}
		// $receiverEmail = array("business1.test@gmail.com", "business2.test@gmail.com","tmtest1@gmail.com", "tmtest2@gmail.com");

		//aus@telamela.com.au
		//india@telamela.com.au

		if (isset($receiverEmail)) {
		$receiver = array();
		/*
		 * A receiver's email address 
		 */
		for ($i = 0; $i < count($receiverEmail); $i++) {
			$receiver[$i] = new Receiver();
			$receiver[$i]->email = $receiverEmail[$i];
			/*
			 *  	Amount to be credited to the receiver's account 
			 */
			$receiver[$i]->amount = $receiverAmount[$i];
			
			/* Set to true to indicate a chained payment; only one receiver can be a primary receiver. Omit this field, or set it to false for simple and parallel payments. 
			 */
			//$receiver[$i]->primary = $primaryReceiver[$i];
			
		}

		 

		$receiverList = new ReceiverList($receiver);

		}
		//pre($receiverList);
		$payRequest = new PayRequest(new RequestEnvelope("en_US"), $actionType, $cancelUrl, $currencyCode, $receiverList, $returnUrl);
		// Add optional params

		//print_r($payRequest);
		//die("OK");
		if ($memo != "") {
		$payRequest->memo = $memo;
		}
		/*
		*## Creating service wrapper object
		Creating service wrapper object to make API call and loading
		Configuration::getAcctAndConfig() returns array that contains credential and config parameters
		*/
		$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());

		//print_r($service);
		//die("OK");
		try {
			/* wrap API method calls on the service object with a try catch */
			$response = $service->Pay($payRequest);
			$ack = strtoupper($response->responseEnvelope->ack);
			//echo"<pre>";
			//print_r($ack);
			//die("OK");
			if ($ack == "SUCCESS") {
				$payKey = $response->payKey;
				/*Save payKey in tbl_cart*/
				$varUsersWhere = ' fkCustomerID =' . $arrCart['custId'];
                $arrColumnAdd = array(
                    'pay_key' => $payKey,
                );
                $this->update(TABLE_CART, $arrColumnAdd, $varUsersWhere);
				
				$payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey;
				$responseData = $payPalURL;
				//header('Location:' . $payPalURL);
			}
			
		} catch (Exception $ex) {
		    $responseData = "error";
		}
		return $responseData;
    }
    
    /**
     * function cartManage
     *
     * This function is used to get saved cart.
     *
     * Database Tables used in this function are : tbl_cart
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    
    function cartManage($argRequest = null){
        $objShoppingCart = new ShoppingCart(); 
        $objClassCommon = new ClassCommon();
        $case =$argRequest['manageType'];    
        $customerId =trim($argRequest['pkCustomerId']);
        $productId =trim($argRequest['pid']);
        switch ($case){
            case 'updateCartOnLogin':
                $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $customerId . "'");
                //pre($arrCart);
                $row = '';
                $arrData=$this->myCartDetails($argRequest);
                
                $quantitiy=0;
                foreach ($arrData as $ItemType => $cartValues)
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
                                        <br>Product
                                      </td>
                                      <td align="center" valign="top">' . $cartVal['ACPrice'] . '</td>
                                      <td align="center" valign="top">' . $cartVal['qty'] . '</td>
                                      <td align="center" valign="top">' . $cartVal['FinalPrice'] . '</td>
                                     </tr>
                                ';
                                $quantitiy+=$cartVal['qty'];
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
                //pre($sessionCartProduct);
                
                
                $sessionCartProduct = $argRequest['Product'];
                
                foreach($sessionCartProduct as $prodKey=>$prodKeyVal){              //Looping Products coming in request                    
                    foreach($prodKeyVal as $key=>$val){                        
                        $attrArrProvided=explode('#',$val['attribute']);                
                        $val['attribute']=$attrArrProvided;
                        $prodKeyVal[$key]=$val;
                    }
                    $sessionCartProduct[$prodKey]=$prodKeyVal;
                    
                }
                
                //print_r($sessionCartProduct);
                //echo "=========SESSION DATA===============";
                if (count($arrCart) > 0)
                {
                    $updateCartData = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));                    
                    
                    //print_r($updateCartData['Product']);
                    //echo "-----------CART DATA------------------";
                    if ((isset($sessionCartProduct) && $sessionCartProduct <> '') || count($updateCartData['Product']) > 0)
                    {
                        $count=0;
                        $arrToappend=array();
                        foreach($sessionCartProduct as $key => $val){
                            
                            $count=0;                            
                            if(isset($updateCartData['Product'][$key])){                                
                                foreach($val as $sessionCartDatakey => $sessionCartDataval){
                                    $found=0;
                                    foreach($updateCartData['Product'][$key] as $updateCartDatakey=> $updateCartDataval){
                                        
                                        if($sessionCartDataval["attribute"]==$updateCartDataval["attribute"]){
                                            //echo $sessionCartDataval['qty'].'==='.$updateCartDataval["qty"];
                                            $updateCartDataval["qty"] += $sessionCartDataval['qty'];
                                            $updateCartData['Total']+=$sessionCartDataval['qty'];
                                            $found=1;                                            
                                            break;
                                            
                                        }
                                        //$updateCartData['Product'][$key][$updateCartDatakey]=$updateCartDataval;
                                    }
                                    $updateCartData['Product'][$key][$updateCartDatakey]=$updateCartDataval;
                                    
                                    if($found==0){
                                        $arrToappend[$key][]=$sessionCartDataval;
                                    }
                                }                                
                            }
                            else{
                                $updateCartData['Product'][$key] = $val;
                                foreach($val as $sessionCartDatakey => $sessionCartDataval){
                                    $updateCartData['Total']+=$sessionCartDataval['qty'];
                                }
                            }
                            
                        }
                        
                        foreach($arrToappend as $arrToappendkey=> $arrToappendval){
                            $arrcount=count($updateCartData['Product'][$arrToappendkey]);
                            foreach($arrToappendval as $childkey=> $childval){                                
                                $updateCartData['Product'][$arrToappendkey][$arrToappendkey .'-'. $arrcount]=$childval;
                                $updateCartData['Total']+=$childval['qty'];
                                $arrcount++;
                            }
                        }
                        $updateCartData1['Product'] = $updateCartData['Product'];
                        
                        //foreach ($updateCartData['Product'] as $key => $val)
                        //{
                        //    if(isset($sessionCartProduct[$key])){                                
                        //        foreach($val as $indexkey=>$indexArray){
                        //            if($sessionCartProduct[$key][$key . "-0"]["attribute"]==$indexArray["attribute"]){
                        //            $indexArray["qty"] += $sessionCartProduct[$key][$key . "-0"]['qty'];
                        //                
                        //            }
                        //            $updateCartData['Total']+=$sessionCartProduct[$key][$key . "-0"]['qty'];
                        //        }
                        //        $val[$indexkey]=$indexArray;
                        //    }
                        //    //pre($val);
                        //    $sessionCartProduct[$key] = $val;
                        //}
                        
                        //$_SESSION['MyCart']['Product'] = $sessionCartProduct;
                        //$updateCartData1['Product'] = $sessionCartProduct;
                    }
                    //echo "<pre>";
                    //echo "<br>-----------Existing CART DATA------------------<br>";
                    //print_r($updateCartData);
                    //echo "<br>-----------SESSION DATA------------------<br>";
                    //print_r($sessionCartProduct);
                    //echo "<br>-----------New DATA------------------<br>";
                    //print_r($updateCartData1);
                    //echo "<br>-----------Data New DATA------------------<br>";
                    //print_r($arrToappend);
                    //die;
                    $updateCartData1['Total'] = $updateCartData['Total'];
                    
                    $row = $row . $arrCart[0]['CartDetails'];
                    //pre($updateCartData1);
                    $arrClmsUpdate = array(
                        'fkCustomerID' => $customerId,
                        'CartDetails' => $row,
                        'CartData' => serialize($updateCartData1),
                        'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
                    );
                    $argWhere = "fkCustomerID = '" . $customerId . "' ";
                    $arrInsertID = $this->update(TABLE_CART, $arrClmsUpdate, $argWhere);
                    //echo "update";
                }
                else
                {
                    $updateCartData1['Product'] = $sessionCartProduct;
                    $updateCartData1['Total'] = $quantitiy;
                    //pre($arrData);
                    //echo serialize($updateCartData1);
                    //echo "insert";
                    //die;
                    $arrClmsAdd = array(
                        'fkCustomerID' => $customerId,
                        'CartDetails' => $row,
                        'CartData' => serialize($updateCartData1),
                        'CartReminderDate' => trim(date(DATE_TIME_FORMAT_DB)),
                        'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
                    );
                    $arrInsertID = $this->insert(TABLE_CART, $arrClmsAdd);
                }
                
                
                //$arrCart1 = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $arrUserList[0]['pkCustomerID'] . "'");
                ////pre($arrCart1);
                //if (isset($arrCart1[0]['fkCustomerID']))
                //{
                //    $_SESSION['MyCart'] = unserialize(html_entity_decode($arrCart1[0]['CartData'], ENT_QUOTES));
                //    //pre($_SESSION['MyCart']);
                //}

                $varWhr = "pkCustomerID = '" . $arrUserList[0]['pkCustomerID'] . "'";
                $arrClms = array('CustomerWebsiteVisitCount' => ($arrUserList[0]['CustomerWebsiteVisitCount'] + 1));
                $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
                
                $data['msg']=PRODUCT_ADD_IN_SHOPING_CART;
                $data['cartTotal']=$updateCartData1['Total'];
                //mail('anuj.singh@mail.vinove.com','response',$data);
                return $data;
                
            break;
        
            case 'addToProductCart':
            $attrFormate = strip_tags($argRequest['attrFormate']);
            //pre($attrFormate);
            $arrAttr = explode("#", $attrFormate);
            $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $argRequest['pkCustomerId'] . "'");
            //pre($arrCart);die;
            if ($objShoppingCart->productInStockApp($argRequest['pid'], $argRequest['qty'], '', $arrAttr, $argRequest['pkCustomerId']))
            {
                //echo "yes";die;
                //pre($objShoppingCart->productInStock($argRequest['pid'], $argRequest['qty'], $argRequest['optIds'], $arrAttr));
                //$arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $argRequest['pkCustomerId'] . "'");
                $row = '';
                $arrRequestData['pkCustomerId']=$argRequest['pkCustomerId'];
                $arrRequestData['Product'][$argRequest['pid']][$argRequest['pid'] . "-0"]['attribute']=$arrAttr;
                $arrRequestData['Product'][$argRequest['pid']][$argRequest['pid'] . "-0"]['qty']=$argRequest['qty'];
                $arrData=$this->myCartDetails($arrRequestData);
                
                
                $quantitiy=0;
                foreach ($arrData as $ItemType => $cartValues)
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
                                        <br>Product
                                      </td>
                                      <td align="center" valign="top">' . $cartVal['ACPrice'] . '</td>
                                      <td align="center" valign="top">' . $cartVal['qty'] . '</td>
                                      <td align="center" valign="top">' . $cartVal['FinalPrice'] . '</td>
                                     </tr>
                                ';
                                $quantitiy+=$cartVal['qty'];
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
                $sessionCartProduct = $arrRequestData['Product'];
                //pre($sessionCartProduct);
                if (count($arrCart) > 0)
                {
                    
                    $updateCartData = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));                    
                    
                    //print_r($updateCartData['Product']);
                    //echo "-----------CART DATA------------------";
                    if ((isset($sessionCartProduct) && $sessionCartProduct <> '') || count($updateCartData['Product']) > 0)
                    {
                        $count=0;
                        $arrToappend=array();
                        foreach($sessionCartProduct as $key => $val){
                            
                            $count=0;                            
                            if(isset($updateCartData['Product'][$key])){                                
                                foreach($val as $sessionCartDatakey => $sessionCartDataval){
                                    $found=0;
                                    foreach($updateCartData['Product'][$key] as $updateCartDatakey=> $updateCartDataval){
                                        
                                        if($sessionCartDataval["attribute"]==$updateCartDataval["attribute"]){
                                            //echo $sessionCartDataval['qty'].'==='.$updateCartDataval["qty"];
                                            $updateCartDataval["qty"] += $sessionCartDataval['qty'];
                                            $updateCartData['Total']+=$sessionCartDataval['qty'];
                                            $found=1;                                            
                                            break;
                                            
                                        }
                                        //$updateCartData['Product'][$key][$updateCartDatakey]=$updateCartDataval;
                                    }
                                    $updateCartData['Product'][$key][$updateCartDatakey]=$updateCartDataval;
                                    
                                    if($found==0){
                                        $arrToappend[$key][]=$sessionCartDataval;
                                    }
                                }                                
                            }
                            else{
                                $updateCartData['Product'][$key] = $val;
                                foreach($val as $sessionCartDatakey => $sessionCartDataval){
                                    $updateCartData['Total']+=$sessionCartDataval['qty'];
                                }
                            }
                            
                        }
                        
                        foreach($arrToappend as $arrToappendkey=> $arrToappendval){
                            $arrcount=count($updateCartData['Product'][$arrToappendkey]);
                            foreach($arrToappendval as $childkey=> $childval){                                
                                $updateCartData['Product'][$arrToappendkey][$arrToappendkey .'-'. $arrcount]=$childval;
                                $updateCartData['Total']+=$childval['qty'];
                                $arrcount++;
                            }
                        }
                        $updateCartData1['Product'] = $updateCartData['Product'];
                        
                        //foreach ($updateCartData['Product'] as $key => $val)
                        //{
                        //    if(isset($sessionCartProduct[$key])){                                
                        //        foreach($val as $indexkey=>$indexArray){
                        //            if($sessionCartProduct[$key][$key . "-0"]["attribute"]==$indexArray["attribute"]){
                        //            $indexArray["qty"] += $sessionCartProduct[$key][$key . "-0"]['qty'];
                        //                
                        //            }
                        //            $updateCartData['Total']+=$sessionCartProduct[$key][$key . "-0"]['qty'];
                        //        }
                        //        $val[$indexkey]=$indexArray;
                        //    }
                        //    //pre($val);
                        //    $sessionCartProduct[$key] = $val;
                        //}
                        
                        //$_SESSION['MyCart']['Product'] = $sessionCartProduct;
                        //$updateCartData1['Product'] = $sessionCartProduct;
                    }
                    //echo "<pre>";
                    //echo "<br>-----------Existing CART DATA------------------<br>";
                    //print_r($updateCartData);
                    //echo "<br>-----------SESSION DATA------------------<br>";
                    //print_r($sessionCartProduct);
                    //echo "<br>-----------New DATA------------------<br>";
                    //print_r($updateCartData1);
                    //echo "<br>-----------Data New DATA------------------<br>";
                    //print_r($arrToappend);
                    //die;
                    $updateCartData1['Total'] = $updateCartData['Total'];
                    
                    $row = $row . $arrCart[0]['CartDetails'];
                    //pre($updateCartData1);
                    $arrClmsUpdate = array(
                        'fkCustomerID' => $customerId,
                        'CartDetails' => $row,
                        'CartData' => serialize($updateCartData1),
                        'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
                    );
                    //pre($arrClmsUpdate);die;
                    $argWhere = "fkCustomerID = '" . $customerId . "' ";
                    $arrInsertID = $this->update(TABLE_CART, $arrClmsUpdate, $argWhere);
                    
                }
                else
                {
                    //echo "2";
                    //die;
                    $updateCartData1['Product'] = $sessionCartProduct;
                    $updateCartData1['Total'] = $quantitiy;
                   // pre($arrData);
                   // echo serialize($updateCartData1);die;
                    //echo "insert";
                    //die;
                    $arrClmsAdd = array(
                        'fkCustomerID' => $customerId,
                        'CartDetails' => $row,
                        'CartData' => serialize($updateCartData1),
                        'CartReminderDate' => trim(date(DATE_TIME_FORMAT_DB)),
                        'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
                    );
                    $arrInsertID = $this->insert(TABLE_CART, $arrClmsAdd);
                }
                
                
                //$arrCart1 = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $arrUserList[0]['pkCustomerID'] . "'");
                ////pre($arrCart1);
                //if (isset($arrCart1[0]['fkCustomerID']))
                //{
                //    $_SESSION['MyCart'] = unserialize(html_entity_decode($arrCart1[0]['CartData'], ENT_QUOTES));
                //    //pre($_SESSION['MyCart']);
                //}

                $varWhr = "pkCustomerID = '" . $arrUserList[0]['pkCustomerID'] . "'";
                $arrClms = array('CustomerWebsiteVisitCount' => ($arrUserList[0]['CustomerWebsiteVisitCount'] + 1));
                $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
                
                $msg = "Product has been added to your cart.";
                $flag = true;
            }
            else
            {
                $msg ='Already added in cart.';
                $flag = false;
                if (count($arrCart) > 0)
                {
                    
                    $updateCartData = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));                    
                    $updateCartData1['Total'] = $updateCartData['Total'];
                }
              
            }
            $data['msg']=$msg;
            $data['flag']=$flag;
            $data['cartTotal']=$updateCartData1['Total'];
            //mail('sandeep.sharma@mail.vinove.com','response',$data);
            return $data;
        break;
        
        case 'RemoveProductFromCart':
        $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $argRequest['pkCustomerId'] . "'");
        $existingCartData = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));   
        //echo "<pre>";
        //echo "<br>-----------REQUEST DATA------------------<br>";
        //print_r($argRequest);
        //echo "<br>-----------EXISTING CART DATA------------------<br>";
        //print_r($existingCartData);
        
        $qty = isset($existingCartData['Product'][$argRequest['pid']][$argRequest['index']]['qty']) ? $existingCartData['Product'][$argRequest['pid']][$argRequest['index']]['qty'] : $argRequest['qty'];


        $existingCartData['Total'] = $existingCartData['Total']-  (int)$qty;

        if (isset($existingCartData['Product'][$argRequest['pid']][$argRequest['index']]))
        {
            //echo 13;die;
            unset($existingCartData['Product'][$argRequest['pid']][$argRequest['index']]);

            if (empty($existingCartData['Product'][$argRequest['pid']]))
            {
                unset($existingCartData['Product'][$argRequest['pid']]);
            }

            if (empty($existingCartData['Product']))
            {
                unset($existingCartData['Product']);
            }
        }
        //print_r($existingCartData);die;
        /*if(isset($existingCartData['Product'][$argRequest['pid']][$argRequest['index']])){
            $existingCartData['Total']-=$existingCartData['Product'][$argRequest['pid']][$argRequest['index']]['qty'];
            unset($existingCartData['Product'][$argRequest['pid']][$argRequest['index']]);
            
            if(empty($existingCartData['Product'][$argRequest['pid']])){
                unset($existingCartData['Product'][$argRequest['pid']]);
            }
        }*/
        //echo "<br>-----------NEW CART DATA------------------<br>";
        //print_r($existingCartData);
        //die;
        
        $arrClmsUpdate = array(
            'CartData' => serialize($existingCartData),
            'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
        );
        $argWhere = "fkCustomerID = '" . $argRequest['pkCustomerId'] . "' ";
        $arrInsertID = $this->update(TABLE_CART, $arrClmsUpdate, $argWhere);
        
        $arrRow = $objClassCommon->getProduct("ProductName", " pkProductID = '" . $argRequest['pid'] . "' ");

        //echo (int) $_SESSION['MyCart']['Total'] . ',' . $arrRow[0]['ProductName'];
        $totel = (isset($existingCartData['Total']) && $existingCartData['Total'] > 0) ? (int) $existingCartData['Total'] : 0;
        $cart=array('Total' => $totel, 'ProductName' => $arrRow[0]['ProductName']);
        return $cart;
        break;
        
        case 'clearCart':
        $this->removeAllCartDetails($customerId);   
        echo 'Cart has been cleared.';    
        break;    
        } 
    }
    
    
    /**
     * function getStockNormalProduct
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image, tbl_category, tbl_wholesaler, tbl_order_option, tbl_product_rating, tbl_special_product, tbl_festival, tbl_product_to_option, tbl_attribute, tbl_attribute_option, tbl_recent_view
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getStockNormalProduct($ProductId)
    {
    	
       $varQuery = "SELECT Quantity FROM " . TABLE_PRODUCT . " WHERE pkProductID =".$ProductId;
       $arrRes = $this->getArrayResult($varQuery);
       $arr['stock'] = $arrRes[0]['Quantity'];
       return $arr;
        
    }
    
    /**
     * function updateCart
     *
     * This function is used to update cart products
     *
     * Database Tables used in this function are : tbl_cart
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return array $arrRes
     */
    function updateCart($arrRequestData = null)
    {
        //print_r($arrRequestData);die;
        $objShoppingCart = new ShoppingCart(); 
        $objClassCommon = new ClassCommon();
        $case =$arrRequestData['manageType'];    
        $customerId =trim($arrRequestData['pkCustomerId']);
        $productId =trim($arrRequestData['pid']);
        $optionId =trim($arrRequestData['optIds']);
        
        if($optionId){
            $arrRows = $objShoppingCart->getStock($productId, $optionId);
        }else{
            $arrRows = $this->getStockNormalProduct($productId);
        }
        if((int)$arrRows['stock'] < (int)$arrRequestData['newQty']):
           $arrRequestData['newQty'] =  $arrRows['stock'];                
        endif;
        
        switch ($case){
            case 'manipulateQty':
                $Qty = 0;
                $pri = 0;
        
                $pri = (int) $arrRequestData['unitPrice'];
                $oldQty = (int) $arrRequestData['oldQty'];
                $arrD = array('frmCustID'=>$customerId,'frmProductId' => $productId, 'frmProductIndex' => $arrRequestData['index'], 'frmProductQuantity' => $arrRequestData['newQty']);
                
                $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $customerId . "'");        
                $existingCartData = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));
                
                if ($this->productInStockShoppingPage($productId, $arrD, $arrRequestData['index']))
                {
                    $varqty = (int) $arrRequestData['newQty'];
                    if ($varqty > 0)
                    {
                        $existingCartData['Product'][$arrRequestData['pid']][$arrRequestData['index']]['qty'] = $varqty;
                        $Qty += $varqty;
                        $msg="Product updated successfully";
                    }
                }
                else
                {
                    //echo '1';die;
                    $Qty += $existingCartData['Product'][$arrRequestData['pid']][$arrRequestData['index']]['qty'];
                    $msg=PRODUCT_ADD_IN_SHOPING_CART_OUT_OF_STOCK;
                }    
                
                $updatePrice = $pri * $existingCartData['Product'][$arrRequestData['pid']][$arrRequestData['index']]['qty'];
                if ($Qty == $oldQty)
                {
                    $existingCartData['Total'] = $existingCartData['Total'];
                }
                else if ($Qty > $oldQty)
                {
                    $existingCartData['Total'] = $existingCartData['Total'] + ($Qty - $oldQty);
                }
                else if ($Qty < $oldQty)
                {
                    $existingCartData['Total'] = $existingCartData['Total'] - ($oldQty - $Qty);
                }
                else
                {
                    $existingCartData['Total'] = $existingCartData['Total'];
                }
                
                $arrClmsUpdate = array(
                    'CartData' => serialize($existingCartData),
                    'CartDateAdded' => date(DATE_TIME_FORMAT_DB)
                );
                $argWhere = "fkCustomerID = '" . $customerId . "' ";
                $arrInsertID = $this->update(TABLE_CART, $arrClmsUpdate, $argWhere);
                $data['msg']=$msg;
                $data['Total']=$existingCartData['Total'];
                $data['updatePrice']=$updatePrice;
                $data['oldVal']=$Qty;       
                $data['flag'] = true;
                $data['stock'] = $arrRows['stock'];
                //pre($data);
            break;
        
        
        }
       
        
        return $data;
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
        $objShoppingCart = new ShoppingCart();
        $arrRow = $this->select(TABLE_PRODUCT, array('pkProductID', 'Quantity'), " pkProductID = '" . $arrPost['frmProductId'] . "'");        
        $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . $arrPost['frmCustID'] . "'");        
        $existingCartData = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));
        //echo '<pre>';
        //print_r($arrRow);        
        //pre($existingCartData['Product'][$pid][$prodIndex]['attribute']);
        if (isset($existingCartData['Product'][$pid][$prodIndex]['attribute'])) {
            $stock = $objShoppingCart->getAttributeStock($arrRow[0]['pkProductID'], $existingCartData['Product'][$pid][$prodIndex]['attribute']);
            //echo $stock;die;
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
    
    
    /**
     * function savelist
     *
     * This function is used to get saved list of customer.
     *
     * Database Tables used in this function are : tbl_category_update_status
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function savelist($argRequest = null)
    {
        
        $limit = ($argRequest['startlimit'] <> '') ? ' LIMIT ' . (int) $argRequest['startlimit'].','.(int) $argRequest['endlimit'] : '';


         $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,Quantity,ProductDescription,fkWholesalerID,CompanyName,ProductImage,OfferPrice, pkWishlistId,WishlistDateAdded, avg(Rating) AS Rating,count(pkReviewID) AS customerReviews
            FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1') INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TODAY_OFFER . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_WISHLIST . " as wl ON pkProductID = wl.fkProductId LEFT JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID LEFT JOIN " . TABLE_REVIEW . " AS rev  ON pkProductID=rev.fkProductID
            WHERE fkUserId='" . (int) $argRequest['userId'] . "'
            Group By pkProductID ORDER BY WishlistDateAdded DESC " . $limit;

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);

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
     * function wholesalerProducts
     *
     * This function is used to get wholesaler products.
     *
     * Database Tables used in this function are : tbl_category_update_status
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function wholesalerProducts($argRequest = null)
    {
        //pre($argRequest);
        $limit = ($argRequest['startlimit'] <> '') ? ' LIMIT ' . (int) $argRequest['startlimit'].','.(int) $argRequest['endlimit'] : '';


         $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,FinalSpecialPrice,FinalPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,DiscountFinalPrice,Quantity,ProductDescription,p.fkWholesalerID,CompanyName,ProductImage,OfferPrice,avg(Rating) AS avgRating,count(pkReviewID) AS customerReviews
            FROM " . TABLE_PRODUCT . " p LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1') INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TODAY_OFFER . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID LEFT JOIN " . TABLE_REVIEW . " AS rev  ON pkProductID=rev.fkProductID
            WHERE p.fkWholesalerID='" . (int) $argRequest['userId'] . "'
            Group By pkProductID ORDER BY pkProductID DESC " . $limit;

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);

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
     * function myRecommendedDetails
     *
     * This function is used to get my recommended details.
     *
     * Database Tables used in this function are : tbl_recommend, tbl_product
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function getAlsoLike($argRequest = null) {
        
        $varSelectCatId =$this->select(TABLE_PRODUCT,array('fkCategoryID'),'pkProductID="'.$argRequest['pkProductID'].'"'); 
        $fkCategoryID=($varSelectCatId[0]['fkCategoryID']!='' || $varSelectCatId[0]['fkCategoryID']!=0)?$varSelectCatId[0]['fkCategoryID']:1;
        
         $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,FinalSpecialPrice,FinalPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,DiscountFinalPrice,Quantity,ProductDescription,p.fkWholesalerID,CompanyName,ProductImage,OfferPrice,avg(Rating) AS avgRating,count(pkReviewID) AS customerReviews
            FROM " . TABLE_PRODUCT . " p LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1') INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TODAY_OFFER . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID LEFT JOIN " . TABLE_REVIEW . " AS rev  ON pkProductID=rev.fkProductID
            WHERE p.fkCategoryID='".$fkCategoryID."' and  pkProductID<>'".$argRequest['pkProductID']."' AND WholesalerStatus<>'deactive'
            Group By pkProductID ORDER BY pkProductID DESC limit 0,15";

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);

        foreach ($arrRes AS $key => $prod)
        {
            $varQuery = "SELECT ImageName FROM " . TABLE_PRODUCT_IMAGE . " WHERE fkProductID = '" . $prod['pkProductID'] . "'";
            $arrProdImg = $this->getArrayResult($varQuery);

            $arrAttributes = $this->getAttributeDetails($prod['pkProductID']);
            $arrRes[$key]['attributes'] = count($arrAttributes);
            $arrRes[$key]['arrproductImages'] = $arrProdImg;
            $arrRes[$key]['arrAttributes'] = $arrAttributes;
        }
        return $arrRes;
    }
    
    /**
     * function savelistAdd
     *
     * This function is used to add my wishlist.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $status
     */
    function savelistAdd($_arrPostId) {
        //echo "<pre>";
        //print_r($_arrPostId);
        //die;
        
        foreach($_arrPostId['data'] as $data){
            $whereWith="fkProductId='".  $data['productID']."' AND fkUserId='".$data['userID']."'";
            $verifyWishlist=$this->select(TABLE_WISHLIST,array('pkWishlistId'),$whereWith);
            if(count($verifyWishlist)==0){
                $arrClms = array(
                    'fkUserId' => $data['userID'],
                    'fkProductId' => $data['productID'],
                    'WishlistDateAdded' => date(DATE_TIME_FORMAT_DB)
                );
                if($this->insert(TABLE_WISHLIST, $arrClms))
                $status='success';
            }else{
                $status='fail';
            }
        }
        
        
        return $status;
    }
    
    /**
     * function savelistAdd
     *
     * This function is used to add multiple product in my wishlist.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $status
     */
    
    function addWishlist($_arrPostId) {
        /*echo "<pre>";
        print_r($_arrPostId);
        die;*/
        $res = "0";
        $status = "";
        $userId = $_arrPostId['userID'];
        if(is_array($_arrPostId['productID']))
        {
            foreach($_arrPostId['productID'] as $kay=>$pId)
            {
                $whereWith="fkProductId='".  $pId."' AND fkUserId='".$userId."'";
                $verifyWishlist=$this->select(TABLE_WISHLIST,array('pkWishlistId'),$whereWith);
                if(count($verifyWishlist)==0){
                    $arrClms = array(
                        'fkUserId' => $userId,
                        'fkProductId' => $pId,
                        'WishlistDateAdded' => date(DATE_TIME_FORMAT_DB)
                    );
                    if($this->insert(TABLE_WISHLIST, $arrClms))
                    $status='success';
                    $res = "1";
                }else{
                    $status='fail';
                }
            }
            
        }
        else
        {
            $whereWith="fkProductId='".  $_arrPostId['productID']."' AND fkUserId='".$_arrPostId['userID']."'";
            $verifyWishlist=$this->select(TABLE_WISHLIST,array('pkWishlistId'),$whereWith);
            if(count($verifyWishlist)==0){
                $arrClms = array(
                    'fkUserId' => $_arrPostId['userID'],
                    'fkProductId' => $_arrPostId['productID'],
                    'WishlistDateAdded' => date(DATE_TIME_FORMAT_DB)
                );
                if($this->insert(TABLE_WISHLIST, $arrClms))
                $status='success';
            }else{
                $status='fail';
            }
        }
        
        if($status=="success" || $res=="1")
        {
            $status="success";
        }
        else
        {
            $status="fail";
        }        
        return $status;
    }
    
    /**
     * function myWishlistDelete
     *
     * This function is used to delete product from wishlist.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $status
     */
    function myWishlistDelete($_arrPostId) {
        //echo "<pre>";
        //print_r($_arrPostId);
        //die;
        
        foreach($_arrPostId['data'] as $data){ 
            $userId = $data['userID'];
            
            $whereWith="fkProductId='".  $data['productID']."' AND fkUserId='".$data['userID']."'";
            $verifyWishlist=$this->select(TABLE_WISHLIST,array('pkWishlistId'),$whereWith);
            if(count($verifyWishlist)!=0){
                $where = "fkUserId='".$data['userID']."' AND  fkProductId='".$data['productID']."'";
                if($this->delete(TABLE_WISHLIST, $where))
                $status='success';
            }else{
                $status='fail';
            }
        }
        
        
        return $status;
    }
    
    /**
     * function myWishlistDelete
     *
     * This function is used to delete product from wishlist.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $status
     */
    function delWishlist($_arrPostId) {
        /*echo "<pre>";
        print_r($_arrPostId);
        die;*/
        $res = "0";
        $status = "";
        $userId = $_arrPostId['userID'];
        if(is_array($_arrPostId['productID']))
        {
            foreach($_arrPostId['productID'] as $key=>$pid)
            {
                $whereWith="fkProductId='".  $pid."' AND fkUserId='".$userId."'";
                $verifyWishlist=$this->select(TABLE_WISHLIST,array('pkWishlistId'),$whereWith);
                if(count($verifyWishlist)!=0){
                    $where = "fkUserId='".$userId."' AND  fkProductId='".$pid."'";
                    if($this->delete(TABLE_WISHLIST, $where))
                    $status='success';
                    $res ="1";
                }else{
                    $status='fail';
                }
            }
        }
        else
        {
            $whereWith="fkProductId='".$_arrPostId['productID']."' AND fkUserId='".$_arrPostId['userID']."'";
            $verifyWishlist=$this->select(TABLE_WISHLIST,array('pkWishlistId'),$whereWith);
            if(count($verifyWishlist)!=0){
                $where = "fkUserId='".$_arrPostId['userID']."' AND  fkProductId='".$_arrPostId['productID']."'";
                if($this->delete(TABLE_WISHLIST, $where))
                $status='success';
            }else{
                $status='fail';
            }
        }
        
        if($status=="success" || $res=="1")
        {
            $status="success";
        }
        else
        {
            $status="fail";
        }
        
        /*mail('deepak.sindhu@mail.vinove.com','request',print_r($_arrPostId,1));
        mail('deepak.sindhu@mail.vinove.com','response',print_r($status,1));*/
        
        return $status;
    }
    
    
    /**
     * function clearWishlist
     *
     * This function is used to delete product from wishlist.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $status
     */
    function clearWishlist($_arrPostId) {
        /*echo "<pre>";
        print_r($_arrPostId);
        die;*/
        $res = "0";
        $status = "";
        $userId = $_arrPostId['userID'];
        if(is_array($_arrPostId['productID']))
        {
            foreach($_arrPostId['productID'] as $key=>$pid)
            {
                $whereWith="fkProductId='".$pid."' AND fkUserId='".$userId."'";
                $verifyWishlist=$this->select(TABLE_WISHLIST,array('pkWishlistId'),$whereWith);
                if(count($verifyWishlist)!=0)
                {
                    $where = "fkUserId='".$userId."' AND  fkProductId='".$pid."'";
                    if($this->delete(TABLE_WISHLIST, $where))
                    {
                        $status='success';
                        $res ="1";
                    }
                    else
                    {   
                        $status='fail';
                    }
                }
            }
        }
        
        return $status;
    }
    
    
    /**
     * function getWishListProductDetails
     *
     * This function is used to show all product details from according to wishlist user id.
     *
     * Database Tables used in this function are : tbl_wishlist and tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $status
     */
    
    function getWishListProductDetails($argProductId)
    {
        $objCore = new Core();
        $argUserId = $argProductId['userId'];
        $slVal = array('fkProductId');
        $varWhere = "fkUserId = '" . $argUserId . "'";
        $getVarified = $this->select(TABLE_WISHLIST, $slVal, $varWhere);
        //print_r($getVarified);
        if (count($getVarified) > 0)
        {
            $varSqlQry = "SELECT p.pkProductID,p.ProductName,p.ProductImage,p.FinalPrice from ".TABLE_WISHLIST." w left join ".TABLE_PRODUCT." p on p.pkProductID=w.fkProductId WHERE w.fkUserId=".$argUserId." order by w.WishlistDateAdded DESC"; 
            $arrRes = $this->getArrayResult($varSqlQry);
            //return(print_r($arrRes));
            $productDetails = array();
            $count=0;
            
            foreach ($arrRes as $val)
            {
                if ($val['pkProductID'] <> '')
                {                    
                    $productDetails[$count][pkProductID] = stripslashes($val['pkProductID']);
                    $productDetails[$count][ProductName] = stripslashes($val['ProductName']);
                    $productDetails[$count][ProductImage] = stripslashes($val['ProductImage']);
                    $productDetails[$count][ProductFinalPrice] = stripslashes($val['FinalPrice']);
                    $count++;
                }
                
            }
            
            return($productDetails);
        }
        else
        {
            return false;
            //return NO_PRODUCT;
        }
    }
    
    
    /**
     * function getLandingPage
     *
     * This function is used to show all product details from .
     *
     * Database Tables used in this function are : tbl_wishlist and tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $status
     */
    
    function getLatestProductByCatId($argProductId)
    {
        
        $limit = ($arrPost['limit']) ? $arrPost['limit'] : 9;
        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,IF(sum(atInv.OptionQuantity)>0,sum(atInv.OptionQuantity),Quantity) as Quantity,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating FROM ".TABLE_PRODUCT." product LEFT JOIN ".TABLE_SPECIAL_PRODUCT." sProduct ON pkProductID=sProduct.fkProductID INNER JOIN ".TABLE_CATEGORY." ON  (pkCategoryId = product.fkCategoryID AND (CategoryHierarchy like'".$argProductId['catId'].":%' OR CategoryHierarchy ='".$argProductId['catId']."') AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' OR pkProductID ='".$argProductId['catId']."') INNER JOIN ".TABLE_WHOLESALER." ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN ".TABLE_PRODUCT_TO_OPTION." as pto ON pkProductID = pto.fkProductId LEFT JOIN ".TABLE_PRODUCT_OPTION_INVENTORY." as atInv ON pkProductID = atInv.fkProductID Group By pkProductID ORDER BY pkProductID DESC LIMIT " . $limit . "";
        //echo $varQuery;die;
        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
    }
    
    /*
     * function getAllLatestProductByCatId
     * 
     * 
     */
    function getAllLatestProductByCatId($argArrPOST)
    {
    
    	global $productImgUrl;
    	
    	$argArrPOST['offset'] = ($argArrPOST['offset'])?$argArrPOST['offset']:0;
    	$argArrPOST['limit'] = ($argArrPOST['limit'])?$argArrPOST['limit']:200;
        $argArrPOST['userID'] = ($argArrPOST['userID'])?$argArrPOST['userID']:0;
    	$limit = ($arrPost['limit']) ? $arrPost['limit'] : 9;
        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,IF(sum(atInv.OptionQuantity)>0,sum(atInv.OptionQuantity),Quantity) as Quantity,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute, (select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = ".$argArrPOST['userID'].") as isWishList, (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating FROM ".TABLE_PRODUCT." product LEFT JOIN ".TABLE_SPECIAL_PRODUCT." sProduct ON pkProductID=sProduct.fkProductID INNER JOIN ".TABLE_CATEGORY." ON  (pkCategoryId = product.fkCategoryID AND (CategoryHierarchy like'".$argArrPOST['catId'].":%' OR CategoryHierarchy ='".$argArrPOST['catId']."') AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' OR pkProductID ='".$argArrPOST['catId']."') INNER JOIN ".TABLE_WHOLESALER." ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN ".TABLE_PRODUCT_TO_OPTION." as pto ON pkProductID = pto.fkProductId LEFT JOIN ".TABLE_PRODUCT_OPTION_INVENTORY." as atInv ON pkProductID = atInv.fkProductID Group By pkProductID ORDER BY pkProductID DESC limit ".$argArrPOST['offset'].", ".$argArrPOST['limit'];
        //echo $varQuery;die;
        $arrRes = $this->getArrayResult($varQuery);
        
        //get total product
        $varQuery1 = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,IF(sum(atInv.OptionQuantity)>0,sum(atInv.OptionQuantity),Quantity) as Quantity,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,(select IFNULL(CAST(avg(Rating) as decimal(10,2)),0) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') as avgRating FROM ".TABLE_PRODUCT." product LEFT JOIN ".TABLE_SPECIAL_PRODUCT." sProduct ON pkProductID=sProduct.fkProductID INNER JOIN ".TABLE_CATEGORY." ON  (pkCategoryId = product.fkCategoryID AND (CategoryHierarchy like'".$argArrPOST['catId'].":%' OR CategoryHierarchy ='".$argArrPOST['catId']."') AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' OR pkProductID ='".$argArrPOST['catId']."') INNER JOIN ".TABLE_WHOLESALER." ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN ".TABLE_PRODUCT_TO_OPTION." as pto ON pkProductID = pto.fkProductId LEFT JOIN ".TABLE_PRODUCT_OPTION_INVENTORY." as atInv ON pkProductID = atInv.fkProductID Group By pkProductID ORDER BY pkProductID DESC";
        //echo $varQuery;die;
        $totalProCnt = count($this->getArrayResult($varQuery1));
        
        //return array('productUrl' => $productImgUrl, 'totalProduct' => $totalProCnt, 'productList' => $getDataCoupon);
        return array('productUrl' => $productImgUrl, 'totalProduct' => $totalProCnt, 'productList' => $arrRes);
    }
    
    /**
     * function getTopRatedById
     *
     * This function is used to show all TopRated Product accourding to product .
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler and tbl_product_rating
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $status
     */
    
    
    function getTopRatedById($argArrPOST, $view = NULL)
    {
    	
    	$argArrPOST['offset'] = ($argArrPOST['offset'])?$argArrPOST['offset']:0;
    	$argArrPOST['limit'] = ($argArrPOST['limit'])?$argArrPOST['limit']:9;
    	$argArrPOST['userID'] = ($argArrPOST['userID'])?$argArrPOST['userID']:0; 
        
        //$limit = ($argProductId['limit']) ? $argProductId['limit'] : 9;
        $arrResProd = array();
        /*$limitCon ="";
        $limit = $argProductId['limit'];
        if($limit!="")
        {
          $limitCon ="limit 0,".$limit;  
        }*/
        $varQuery = "SELECT Quantity,avg(Rating) AS Rating, pkCategoryId,CategoryName,CategoryHierarchy,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as parentCID FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . "  ON (ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND CategoryParentId ='".$argArrPOST['catId']."')  INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') INNER JOIN " . TABLE_PRODUCT_RATING . " AS pr ON pkProductID=pr.fkProductID where RatingApprovedStatus='Allow' Group By parentCID ORDER BY pr.Rating DESC limit 0,10";

        //Create memcache object
        global $oCache;
        //Create object key for cache object
        $varQueryKey = md5($varQuery);
        //Check memcache is enabled or not
        if ($oCache->bEnabled)
        { // if Memcache enabled
            if (!$oCache->getData($varQueryKey))
            {
                $arrResCate = $this->getArrayResult($varQuery);
                $oCache->setData($varQueryKey, serialize($arrResCate));
            }
            else
            {
                $arrResCate = unserialize($oCache->getData($varQueryKey));
            }
        }
        else
        {
            $arrResCate = $this->getArrayResult($varQuery);
        }


        //pre($arrResCate);
        $lim = (count($arrResCate) < 10) ? count($arrResCate) : 10;
        $i = 0;
        $finalResult = array();
        while ($i < $lim)
        {

            $arrResCate[$i]['parentCID'] = $cid <> 0 ? $cid : $arrResCate[$i]['parentCID'];
            $varQuery = "SELECT (select count(pkWishlistId) from tbl_wishlist as wish where wish.fkProductId=pkProductID AND wish.fkUserId = ".$argArrPOST['userID'].") as isWishList,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,floor(IF(DiscountFinalPrice != 0,((FinalPrice-DiscountFinalPrice)/FinalPrice)*100,0)) as discountPercent,ProductImage,Quantity, avg(Rating) AS avgRating,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as pkCategoryId, (SELECT CategoryName from " . TABLE_CATEGORY . " WHERE pkCategoryId = '" . $arrResCate[$i]['parentCID'] . "' ) as CategoryName
            FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID
            WHERE ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' AND pkProductID !='$todayOfferProduct' AND (CategoryHierarchy = '" . $arrResCate[$i]['parentCID'] . "' OR CategoryHierarchy like '" . $arrResCate[$i]['parentCID'] . ":%')
            AND RatingApprovedStatus='Allow' Group By pkProductID ORDER BY avg(Rating) DESC LIMIT ".$argArrPOST['offset']."," . $argArrPOST['limit'] . "";
            
            
            //Get total product
            $varQuery1 = "SELECT (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,floor(((FinalPrice-DiscountFinalPrice)/FinalPrice)*100) as discountPercent,ProductImage,Quantity, avg(Rating) AS avgRating,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as pkCategoryId, (SELECT CategoryName from " . TABLE_CATEGORY . " WHERE pkCategoryId = '" . $arrResCate[$i]['parentCID'] . "' ) as CategoryName
            FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID
            WHERE ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' AND pkProductID !='$todayOfferProduct' AND (CategoryHierarchy = '" . $arrResCate[$i]['parentCID'] . "' OR CategoryHierarchy like '" . $arrResCate[$i]['parentCID'] . ":%')
            AND RatingApprovedStatus='Allow' Group By pkProductID";
            
            
            //Create memcache object
            global $oCache;
            //Create object key for cache object
            $varQueryKey = md5($varQuery);
            //Check memcache is enabled or not
            if ($oCache->bEnabled)
            { // if Memcache enabled
                if (!$oCache->getData($varQueryKey))
                {
                    $arrResProd = $this->getArrayResult($varQuery);
                    $totalProCnt = count($this->getArrayResult($varQuery1));
                    $oCache->setData($varQueryKey, serialize($arrResProd));
                }
                else
                {
                    $arrResProd = unserialize($oCache->getData($varQueryKey));
                }
            }
            else
            {
                $arrResProd = $this->getArrayResult($varQuery);
                $totalProCnt = count($this->getArrayResult($varQuery1));
            }


            //$finalResult[$i] = $arrResProd;
            $i++;
        }
        if($view == 'all')
          $arrResProd['totalProduct'] = $totalProCnt;
        
       return $arrResProd;
    }
    
    /*
     * function getAllTopRatedById
     * 
     */
    
    function getAllTopRatedById($argArrPOST){
    	global $productImgUrl;
    	$arrRes = $this->getTopRatedById($argArrPOST,'all');
    	$totalProCnt = $arrRes['totalProduct'];
    	unset($arrRes['totalProduct']);
    	return array('productUrl' => $productImgUrl, 'totalProduct' => $totalProCnt, 'productList' => $arrRes);
    }
    
    /**
     * function getSpecialBanner
     *
     * This function is used get special page banner.
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    /*function getSpecialBanner($page = 'special',$cId=0) {
        global $objCore;
        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
        $whereCid=$cId!='' || $cId!=0 ?' AND fkCategoryId="'.$cId.'"':''; 
        $varQuery = "SELECT pkBannerID,BannerTitle,BannerImageName,UrlLinks FROM " . TABLE_BANNER . " WHERE BannerStatus='1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' $whereCid AND BannerPage='" . $page . "' ORDER BY BannerOrder ASC,pkBannerID desc LIMIT 10";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }*/
    
    function getSpecialBanner($argCatId) {
        global $objCore;
        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
        $varQuery = "SELECT pkBannerID,BannerTitle,BannerImageName FROM " . TABLE_BANNER . " WHERE BannerStatus='1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' AND fkCategoryId='" . $argCatId['catId'] . "' ORDER BY BannerOrder ASC,pkBannerID desc LIMIT 10";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }
    
    
     /**
     * function getProductDetails
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image, tbl_category, tbl_wholesaler, tbl_order_option, tbl_product_rating, tbl_special_product, tbl_festival, tbl_product_to_option, tbl_attribute, tbl_attribute_option, tbl_recent_view
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getProductDetailsBySubCat($argProductId)
    {
        global $objCore;
        //echo "well doen ".$argProductId['subCatId'];
        $varWhere = "pkProductID = '". $argProductId['subCatId']."' AND ProductStatus='1'";
        $varQuery = "SELECT pkProductID,fkCategoryID,CategoryHierarchy,ProductName,FinalPrice, DiscountFinalPrice,YoutubeCode,fkPackageId,Quantity,ProductDescription,ProductTerms,HtmlEditor,ProductDateAdded,MetaTitle,MetaKeywords,MetaDescription,ImageName,count(fkAttributeId) as Attribute,pkWholesalerID,CompanyName, AboutCompany, fkTemplateId, SUM(Rating) as numRating, count(fkCustomerID) as numCustomer,fkWholesalerID FROM ".TABLE_PRODUCT." LEFT JOIN ".TABLE_PRODUCT_IMAGE." ON pkProductID = fkProductID INNER JOIN ".TABLE_CATEGORY." ON  (pkCategoryId = fkCategoryID AND CategoryIsDeleted = '0' AND CategoryStatus = '1') INNER JOIN ".TABLE_WHOLESALER." ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN ".TABLE_PRODUCT_TO_OPTION." as pto ON pkProductID = pto.fkProductId LEFT JOIN ".TABLE_PRODUCT_RATING." as rat on pkProductID = rat.fkProductID   WHERE ".$varWhere;
        $arrRes = $this->getArrayResult($varQuery);

        $curDate = $objCore->serverDateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);


        $varQuerySpcl = "SELECT FinalSpecialPrice FROM ".TABLE_SPECIAL_PRODUCT." INNER JOIN ".TABLE_FESTIVAL." ON  fkFestivalID = pkFestivalID WHERE fkProductID='" . $argProductId['subCatId']. "' AND FestivalStartDate <='".$curDate."' AND FestivalEndDate>='".$curDate."' Group By fkProductID";
        $arrResSpcl = $this->getArrayResult($varQuerySpcl);
        $arrRes[0]['FinalSpecialPrice'] = $arrResSpcl[0]['FinalSpecialPrice'];

        $arrRes[0]['AttrQty'] = $this->getAttrQty($arrRes[0]['pkProductID']);

        $varQuery2 = "SELECT pkAttributeId,AttributeLabel,AttributeDesc,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle, GROUP_CONCAT(pkOptionID) as pkOptionID, GROUP_CONCAT(AttributeOptionValue) AS AttributeOptionValue,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice, GROUP_CONCAT(AttributeOptionImage) AS AttributeOptionImage,GROUP_CONCAT(IsImgUploaded) AS IsImgUploaded FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId WHERE fkProductId = '" .$argProductId['subCatId']. "'
	AND `AttributeVisible`='yes' GROUP BY pkAttributeId order by AttributeOrdering ASC";
        $arrRes[0]['productAttribute'] = $this->getArrayResult($varQuery2);

        $arrRes[0]['Quantity'] = (count($arrRes[0]['productAttribute']) > 0) ? $arrRes[0]['AttrQty'] : $arrRes[0]['Quantity'];
        return $arrRes;
    }
    
    
    /**
     * function getAttrQty
     *
     * This function is used to get product image.
     *
     * Database Tables used in this function are :  tbl_product_option_inventory
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getAttrQty($pid)
    {
        $arrClms = array(
            'sum(OptionQuantity) as AttrQty'
        );
        $argWhere = "fkProductID = '" . $pid . "' ";

        $varTable = TABLE_PRODUCT_OPTION_INVENTORY;
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        return (int) $arrRes[0]['AttrQty'];
    }
    
    
    /* function addUserReview($_arrPost)
      {

      global $objGeneral;
      global $objCore;
      $arrClms = array(
      'fkCustomerID' => $_arrPost['custId'],
      'fkProductID' => $_arrPost['frmProductId'],
      'Reviews' => strip_tags($_arrPost['frmMessage']),
      'ReviewDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
      'ReviewDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
      );
      //pre($arrPost);

      $arrAddID = $this->insert(TABLE_REVIEW, $arrClms);

      //$objGeneral->addRewards($arrClms['fkCustomerID'], 'RewardOnReviewRatingProduct');
      return $arrAddID;
      } */
    function addCustomerReview($_arrPost)
    {
        global $objGeneral;
        global $objCore;
        $resp ="";
        $varQuery2 = "select pkRateID from " . TABLE_PRODUCT_RATING . " where fkProductID = '" . $_arrPost['frmProductId'] . "' AND fkCustomerID = '" . $_arrPost['custId'] . "' ";
        //echo $varQuery2;
        $arrRes2 = $this->getArrayResult($varQuery2);
        if (count($arrRes2) == 0)
        {
            //Insert Rating data starts from here
            $arrClms1 = array(
                'fkCustomerID' => $_arrPost['custId'],
                'fkProductID' => $_arrPost['frmProductId'],
                'Rating' => $_arrPost['frmRateStar'],
                'RateDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $arrRes = $this->insert(TABLE_PRODUCT_RATING, $arrClms1);
            //Insert Rating data ends here
            //Insert Review data starts from here
            $arrClms2 = array(
                'fkCustomerID' => $_arrPost['custId'],
                'fkProductID' => $_arrPost['frmProductId'],
                'Reviews' => strip_tags($_arrPost['frmMessage']),
                'ReviewDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                'ReviewDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $arrRes = $this->insert(TABLE_REVIEW, $arrClms2);
            //Insert Review data ends here
        }
        else
        {
            //Update the Rating Table
            $varQuery = "UPDATE " . TABLE_PRODUCT_RATING . " set Rating ='" . $_arrPost['frmRateStar'] . "',RatingApprovedStatus ='Pending' where fkProductID = '" . $_arrPost['frmProductId'] . "' AND fkCustomerID = '" . $_arrPost['custId'] . "' ";
            $arrRes = $this->getArrayResult($varQuery);
            //Update the Reviews Table
            $varQuery = "UPDATE " . TABLE_REVIEW . " set Reviews ='" . $_arrPost['frmMessage'] . "',ApprovedStatus ='Pending' ,ReviewDateUpdated ='" . $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB) . "' where fkProductID = '" . $_arrPost['frmProductId'] . "' AND fkCustomerID = '" . $_arrPost['custId'] . "' ";
            $arrRes = $this->getArrayResult($varQuery);
            $arrRes = "udate";
        }
        //$objGeneral->solrProductRemoveAdd("pkProductID='" . $_arrPost['frmProductId'] . "'");
        //$objGeneral->addRewards($_arrPost['custId'], 'RewardOnReviewRatingProduct');
        /*mail('anuj.singh@mail.vinove.com','request',print_r($_arrPost,1));
        mail('anuj.singh@mail.vinove.com','response',print_r($arrRes,1));
        mail('aditya.sharma@mail.vinove.com','request',print_r($argProductId,1));
        mail('aditya.sharma@mail.vinove.com','response',print_r($arrRes,1));*/
        return $arrRes;

        //$objGeneral->addRewards($arrClms['fkCustomerID'], 'RewardOnReviewRatingProduct');
        // return $arrAddID;
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
    function getCustomerOrderlist($_arrPost)
    {
        /*$limit = $_arrPost['limit'] ? "LIMIT {$_arrPost['limit']}" : '';
        $varID = "o.fkCustomerID = '" . $_arrPost['cid'] . "' ";
        $query = "SELECT o.pkOrderID,SubOrderID,o.TransactionID,o.fkCustomerID,o.CustomerFirstName,o.CustomerLastName,o.OrderStatus,o.OrderDateAdded,ot.Amount,Status as status FROM " . TABLE_ORDER . " as o INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON (o.pkOrderID = oi.fkOrderID AND {$varID}) LEFT JOIN " . TABLE_ORDER_TOTAL . " as ot ON (o.pkOrderID = ot.fkOrderID AND ot.Code='total') GROUP BY pkOrderID,Status,fkWholesalerID order by o.pkOrderID desc {$limit}";
        $arrRes = $this->getArrayResult($query);
        foreach ($arrRes as $key => $val)
        {
            $arrRows = $this->getInvoiceDetails($val['pkOrderID'], $_arrPost['cid']);
            $arrRes[$key]['invoice'] = count($arrRows[0]);
            $arrRes[$key]['invoices'] = $arrRows;
            //$arrRes[$key]['status'] = $this->getOrderStatus($val['status']);
        }
pre($arrRes);*/
        $limit = $_arrPost['limit'] ? "LIMIT {$_arrPost['limit']}" : '';
        $varID = "o.fkCustomerID = '" . $_arrPost['cid'] . "' ";
        $query = "SELECT Distinct o.pkOrderID,o.TransactionID, DATE_FORMAT(o.OrderDateAdded, '%d %b %Y') as orderDate, Status as status FROM " . TABLE_ORDER . " as o INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON (o.pkOrderID = oi.fkOrderID AND {$varID}) LEFT JOIN " . TABLE_ORDER_TOTAL . " as ot ON (o.pkOrderID = ot.fkOrderID AND ot.Code='total') GROUP BY pkOrderID,Status,fkWholesalerID order by o.pkOrderID desc {$limit}";
        $arrRes = $this->getArrayResult($query);
		//pre($arrRes);
        return $arrRes;
    }
    
    /**
     * function getCustomerOrderDetails
     *
     * This function is used to get customer order details.
     *
     * Database Tables used in this function are : tbl_order, tbl_country
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function getCustomerOrderDetails($_arrPost)
    {
		global $productImgUrl;
		
        $oid = $_arrPost['orderId'];
        $cid = $_arrPost['clientId'];
        
        $arrClms = array('a.BillingFirstName,a.BillingLastName,a.BillingOrganizationName,a.BillingAddressLine1,a.BillingAddressLine2,a.BillingPostalCode', 'd.name as BillingCountryName','a.ShippingFirstName','a.ShippingLastName','a.ShippingOrganizationName','a.ShippingAddressLine1','a.ShippingAddressLine2','a.ShippingPostalCode', 'e.name as ShippingCountryName');
        $varTable = TABLE_ORDER . ' as a LEFT JOIN ' . TABLE_COUNTRY . ' as d ON d.country_id=a.BillingCountry LEFT JOIN ' . TABLE_COUNTRY . ' as e ON e.country_id=a.ShippingCountry';
        $varID = "pkOrderID = '" . $oid . "' AND fkCustomerID ='" . $cid . "'";
        $billInfo = $this->select($varTable, $arrClms, $varID);
        
        
        
        $arrClms1 = array('pkOrderItemID', 'SubOrderID', 'fkItemID', 'ItemType', 'ItemName', 'ItemImage', 'fkWholesalerID', 'fkOrderID', 'ItemPrice', 'AttributePrice', 'Quantity', 'ItemTotalPrice', 'Status', 'DisputedStatus', 'DiscountPrice', 'ShippingPrice', 'ItemDetails');
        $varTable1 = TABLE_ORDER_ITEMS;
        $varID1 = " fkOrderID = '" . $oid . "' ";
        $arrRes = $this->select($varTable1, $arrClms1, $varID1);
        //pre($arrRes);
        //$cid = $_SESSION['sessUserInfo']['id'];

        //$arrDisputedCommentHistory = $this->disputedCommentsHistory($oid);


        foreach ($arrRes as $k => $v)
        {
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
        }        
        $ordDetails['billingInfo'] = $billInfo;
        $ordDetails['orderInfo'] = $arrRes;
		
		$ordDetails['productUrl'] = $productImgUrl;
        //pre($arrRes);
        return $ordDetails;
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
     * function getShippingDetails
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
    function getShippingDetails($_arrPost)
    {
        $limit = $_arrPost['limit'] ? "LIMIT {$_arrPost['limit']}" : '';
        $varID = "o.fkCustomerID = '" . $_arrPost['cid'] . "' ";
        $query = "SELECT o.pkOrderID,SubOrderID,o.TransactionID,o.fkCustomerID,o.CustomerFirstName,o.CustomerLastName,o.OrderStatus,o.OrderDateAdded,ot.Amount,Status as status FROM " . TABLE_ORDER . " as o INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON (o.pkOrderID = oi.fkOrderID AND {$varID}) LEFT JOIN " . TABLE_ORDER_TOTAL . " as ot ON (o.pkOrderID = ot.fkOrderID AND ot.Code='total') GROUP BY pkOrderID,Status,fkWholesalerID order by o.pkOrderID desc {$limit}";
        $arrRes = $this->getArrayResult($query);
        foreach ($arrRes as $key => $val)
        {
            $arrRows = $this->getInvoiceDetails($val['pkOrderID'], $_arrPost['cid']);
            $arrRes[$key]['invoice'] = count($arrRows[0]);
            $arrRes[$key]['invoices'] = $arrRows;
            //$arrRes[$key]['status'] = $this->getOrderStatus($val['status']);
        }
//pre($arrRes);
        return $arrRes;
    }
    
    /**
     * function checkShippingAvilable
     *
     * This function is used to check checkShipping Availability.
     *
     * Database Tables used in this function are : custom shippn and api(fedex ups and usps)
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function checkShippingAvilable($_arrPost)
    {
       
       require_once CLASSES_PATH . 'class_shipping_price_api.php';
       require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/usps/class_usps.php';
       require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/ups/class_ups.php';
       require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/fedex/class_fedex.php';

        $objShoppingCart = new ShoppingCart();
        $varProductShippingCountry=$_arrPost['shipCountId']; //get customer country id
        $varCheckShippingByPincode=$_arrPost['pincode']; //get customer postal code
        $varCheckShippingByProductId=$_arrPost['shipProdId'];
        $varProductShippingCountryName=$_arrPost['shipCountName'];
        
        
        $getProductShippingDetails=$objShoppingCart->getProductShippingDetails($varCheckShippingByProductId);
        $getProductShippingDetailsR=$getProductShippingDetails[0];
        //pre($getProductShippingDetailsR);
    
        $isDom = ($varProductShippingCountry == $getProductShippingDetails['CompanyCountry']) ? 1 : 0;
        $arrCustomer=array('ShippingPostalCode'=>$varCheckShippingByPincode,'countryName'=>$varProductShippingCountry);
        $arrRes = $objShoppingCart->getShippingDetailsForProduct2($getProductShippingDetailsR['pkProductID'], $getProductShippingDetailsR['fkShippingID'], $getProductShippingDetailsR['Quantity'], 0,$isDom,$arrCustomer);
        if(count($arrRes)>0){
           $msg = "Shipping available"; 
        }else{
            $msg = "Shipping not available";
        }
        //$msg = "well done";
        return $msg;
    }
    
    /**
     * function get currency list
     *
     * This function is used to set selected currency value on web.
     *
     * Database Tables used in this function is tbl_currency_price
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    
    function getCurrencyList($argCurrencyCode = '')
    {
        $arrCurrency = array(
            'American Samoa'=>'USD',
            'United Arab Emirates'=>'AED',
            'Argentina'=>'ARS',
            'Australia'=>'AUD',
            'Bulgaria'=>'BGN',
            'Bolivia'=>'BOB',
            'Brazil'=>'BRL',
            'Canada'=>'CAD',
            'Switzerland'=>'CHF',
            'Chile'=>'CLP',
            'China'=>'CNY',
            'Colombia'=>'COP',
            'Czech Republic'=>'CZK',
            'Faroe Islands'=>'DKK',
            'Egypt'=>'EGP',
            'Spain'=>'EUR',
            'Great Britain - UK'=>'GBP',
            'Hong Kong'=>'HKD',
            'Croatia'=>'HRK',
            'Hungary'=>'HUF',
            'Indonesia'=>'IDR',
            'Israel'=>'ILS',
            'India'=>'INR',
            'Japan'=>'JPY',
            'South Korea'=>'KRW',
            'Kuwait'=>'KWD',
            'Lithuania'=>'LTL',
            'Morocco'=>'MAD',
            'Bolivia'=>'MXN',
            'Malaysia'=>'MYR',
            'Norway'=>'NOK',
            'New Zealand'=>'NZD',
            'Peru'=>'PEN',
            'Philippines'=>'PHP',
            'Pakistan'=>'PKR',
            'Poland'=>'PLN',
            'Romania'=>'RON',
            'Serbia'=>'RSD',
            'Soviet Union'=>'RUB',
            'Saudi Arabia'=>'SAR',
            'Sweden'=>'SEK',
            'Singapore'=>'SGD',
            'Thailand'=>'THB',
            'Taiwan'=>'TWD',
            'Ukraine'=>'UAH',
            'Venezuela'=>'VEF',
            'Vietnam'=>'VND',
            'South Africa'=>'ZAR',
        );
        return $arrCurrency;
    }
    
    /**
     * function changeCurrency
     *
     * This function is used to set selected currency value on web.
     *
     * Database Tables used in this function is tbl_currency_price
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    
    public function changeCurrency($_arrPost)
    {
        $objCore = new Core();
        $resp = $objCore->setCurrencyForMob($_arrPost['currencyCode']);
        return($resp);
    }
    
    /**
     * function leftMenu
     *
     * This function is used to create left filter menu.
     *
     * Database Tables used in this function are
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    
    public function leftMenu($_arrPost)
    {
        
    }
	
    
    /**
     * function cartDetails
     *
     * This function is used to get cart details from live to mobile.
     *
     * Database Tables used in this function are : tbl_cart
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrCart
     */
    function shipping($argRequest = null) {
        $arrCustomer = $this->CustomerDetailsForShipping($argRequest['customerId']);
        $varCustomerCountry = $arrCustomer['ShippingCountry'];
        //pre($arrCustomer);
        $objShoppingCart = new ShoppingCart();
        //get cart details of the customer
        $arrCart = $this->select(TABLE_CART, array('fkCustomerID', 'CartDetails', 'CartData'), "fkCustomerID='" . (int) $argRequest['customerId'] . "'");
        //get CartData into serilize format ..Unserialize cart data to use as an array
        $varCartData = unserialize(html_entity_decode($arrCart[0]['CartData'], ENT_QUOTES));
        
        //pre($varCartData);
        $a=0;
        foreach($varCartData['Product'] as $key=>$val)
        {
            foreach($val as $kk=>$kv)
            {                
                $pDetaisl = $this->getProductDetailsForCart($key);
                $arrData['products'][$a]['productID']=$pDetaisl[0]['pkProductID'];
                $arrData['products'][$a]['Index']=$kk;
                $arrData['products'][$a]['ProductName']=$pDetaisl[0]['ProductName'];
                $arrData['products'][$a]['ProductImage']=$pDetaisl[0]['ProductImage'];
                $arrData['products'][$a]['ProductFinalPrice']=$pDetaisl[0]['FinalPrice'];
                $arrData['products'][$a]['DiscountFinalPrice']=$pDetaisl[0]['DiscountFinalPrice'];
                $arrData['products'][$a]['ProductDescription']=$pDetaisl[0]['ProductDescription'];
                $arr=$kv['attribute'];
                $attr = implode("#",$arr);
                //$arrData[$a]['attribute']=$attr;
                $attrArrProvided = explode('#',$attr);
                $arrAttribute = $objShoppingCart->getAttributeName($key, $attrArrProvided);
                $arrData['products'][$a]['indexAttribute']=$arrAttribute['details'];
                $arrData['products'][$a]['ProductQuantity']=$kv['qty'];
                
                $fkShippingID = $this->getShippingID($pDetaisl[0]['pkProductID']);
                //print_r();
                //echo "fkShipping id ".$fkShippingID['fkShippingID'];
                $shipArr = explode(',',$fkShippingID['fkShippingID']);
                $comCountry = $fkShippingID['CompanyCountry'];
                $i=0;
                foreach($shipArr as $shipK=>$shipV)
                {
                    $isDom = ($varCustomerCountry == $comCountry) ? 1 : 0;
                    $arrData['products'][$a][$i]['ShippingDetails'] = $this->getShippingDetailsForProduct($pDetaisl[0]['pkProductID'], $shipV, $kv['qty'], 0, $isDom, $arrCustomer); 
                    $i++;
                }
                //$arrData['products'][$a]['shippingId']=$fkShippingID;
                               
                
                $total = ($total+$kv['qty']);
                $a++;
            }
            $total1 = $total;
        }
        $arrData['total']=$total1;
        //pre($arrData);
        return $arrData;
        
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
        //echo $proID.'..prod... argSID '.$argSID.'..ship..'.$qty.'...'.$smid.'...'.$isDom.'...'.//pre($arrCustomer).'...';
        require_once CLASSES_PATH . 'class_shipping_price_api.php';
        //require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/usps/class_usps.php';
        require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/ups/class_ups.php';
        require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/fedex/class_fedex.php';
        
        global $objCore;
        $objShipping = new ShippingPrice();

        $arrRes = $this->getShippingDetailsForList($argSID, $smid, $isDom);
        //pre($arrRes);die;
		/*commented on 21 Jan 2016*/
        /*foreach ($arrRes as $key => $val) {
            $Shipping = array('shippingId' => $val['pkShippingGatewaysID'], 'methodId' => $val['Methods'][0]['pkShippingMethod'], 'methodCode' => $val['Methods'][0]['MethodCode']);
            //echo '<pre>';print_r($Shipping);
            $arrPro = $objShipping->getProductDetails($proID, $qty, $Shipping);
        
            if ($val['ShippingType'] <> '') {

                if ($val['ShippingType'] == 'admin') { 
                    
                    $arrShippingMethods = $objShipping->AdminShipping($arrPro, $arrCustomer, $val['Methods']);
                    $arrRes[$key]['Methods'] = $arrShippingMethods;
                } else {
                    //pre($val);
                    //$arrShippingMethods = $objShipping->$val['ShippingAlias']($arrPro, $arrCustomer, $val['Methods']);
                    //$arrRes[$key]['Methods'] = $arrShippingMethods;
                }
            } else {
                //$varShippingCost = DEFAULT_SHIPPING_CHARGE;
            }
        }

        foreach ($arrRes as $k => $val) {
            if (!is_array($val['Methods']) || count($val['Methods']) <= 0) {
                unset($arrRes[$k]);
            }
        }*/
/*commented on 21 Jan 2016*/
        foreach ($arrRes as $key => $val) {
            $Shipping = array('shippingId' => $val['pkShippingGatewaysID'], 'ShippingTitle' => $val['ShippingTitle']);
        	//pre($Shipping);
            $arrPro = $objShipping->getProductDetailsnew($proID, $qty, $Shipping);
           //pre($arrPro);
           
            if ($val['ShippingType'] <> '') {

                if ($val['ShippingType'] == 'admin') {
                    
                    $arrShippingMethods = $objShipping->AdminShippingnew($arrPro, $arrCustomer,$Shipping);
                    $arrRes[$key]['Methods'] = $arrShippingMethods;
                } else {
                    //pre($val);
                    $arrShippingMethods = $objShipping->$val['ShippingAlias']($arrPro, $arrCustomer, $val['method']);
                    $arrRes[$key]['Methods'] = $arrShippingMethods;
                    //pre($arrShippingMethods);
                }
            } else {
                //$varShippingCost = DEFAULT_SHIPPING_CHARGE;
            }
        }
        //echo '<pre>';print_r($val['Methods']);
        //pre($arrRes);
        return $arrRes;
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
    function getShippingDetailsForList($argSID, $smid = 0, $isDomestic = 0) {

       /*$varQuery = "SELECT pkShippingGatewaysID,ShippingType,ShippingTitle,ShippingAlias FROM " . TABLE_SHIPPING_GATEWAYS . " WHERE pkShippingGatewaysID in('" .$argSID . "') AND ShippingStatus='1' ORDER BY ShippingTitle ASC";
        $arrRes = $this->getArrayResult($varQuery);
       $wsmid = ($smid > 0) ? " AND pkShippingMethod='" . $smid . "' " : "";

        foreach ($arrRes as $k => $v) {
            if ($smid == 0) {
                if ($v['ShippingType'] == 'api') {
                    $wsmid .= ($isDomestic == 1) ? " AND MethodService='domestic' " : " AND MethodService='international' ";
                }
            }
            $arrRes[$k]['Methods'] = $this->shippingMethodList("fkShippingGatewayID = '" . $v['pkShippingGatewaysID'] . "' " . $wsmid . " ");
        }
        echo '<pre>';print_r($arrRes);
        return $arrRes;*/
		
		
		/* commented on 20 January 2016*/
		/*$varQuery = "SELECT pkShippingGatewaysID,ShippingType,ShippingTitle,ShippingAlias FROM " . TABLE_SHIPPING_GATEWAYS . " WHERE pkShippingGatewaysID in(" .$argSID . ") AND ShippingStatus='1' ORDER BY ShippingTitle ASC";
        $arrRes = $this->getArrayResult($varQuery);
       $wsmid = ($smid > 0) ? " AND pkShippingMethod='" . $smid . "' " : "";

        foreach ($arrRes as $k => $v) {
            if ($smid == 0) {
                if ($v['ShippingType'] == 'api') {
                    $wsmid .= ($isDomestic == 1) ? " AND MethodService='domestic' " : " AND MethodService='international' ";
                }
            }
            $arrRes[$k]['Methods'] = $this->shippingMethodList("fkShippingGatewayID = '" . $v['pkShippingGatewaysID'] . "' " . $wsmid . " ");
        }
        
        return $arrRes;*/
		/* commented on 20 January 2016*/
		
		$varQuery = "SELECT pkShippingGatewaysID,ShippingType,ShippingTitle,ShippingAlias FROM " . TABLE_SHIP_GATEWAYS . " WHERE pkShippingGatewaysID in(" .$argSID . ") AND ShippingStatus='1' ORDER BY ShippingTitle ASC";
       $arrRes = $this->getArrayResult($varQuery);
	   //pre($arrRes);
	return $arrRes;
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
    
    function getShippingID($varCustomerId)
    {        
        $varQuery = "SELECT fkShippingID,CompanyCountry FROM " . TABLE_PRODUCT . " LEFT JOIN ".TABLE_WHOLESALER." on pkWholesalerID=fkWholesalerID  WHERE pkProductID  = '" . $varCustomerId . "'";
        $arrCustomerDetails = $this->getArrayResult($varQuery);
        //pre($arrCustomerDetails);
        return $arrCustomerDetails[0];
    }
    
}
?>
