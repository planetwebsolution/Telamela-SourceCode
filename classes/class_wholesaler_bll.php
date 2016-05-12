<?php

/**
 * Site Wholesaler Class
 *
 * This is the Wholesaler class that will used on website for front Wholesaler pannel.
 *
 * DateCreated 1th August, 2013
 *
 * DateLastModified 1st Sept, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class Wholesaler extends Database {

    function __construct() {

        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function countryList
     *
     * This function is used to retrive country List.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function countryList() {
        $arrClms = array(
            'country_id',
            'name',
        );
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms);
        return $arrRes;
    }

    /**
     * function adminList
     *
     * This function is used to retrive admin user List.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 $string
     *
     * @return array $arrRes
     */
    function adminList($argWhr) {
        $arrClms = array(
            'pkAdminID',
            'AdminType',
            'AdminUserName',
            'AdminEmail',
            'AdminCountry',
            'AdminRegion'
        );

        $varOrderBy = 'AdminUserName ASC ';
        $arrRes = $this->select(TABLE_ADMIN, $arrClms, $argWhr);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function wholeSalerList
     *
     * This function is used to retrive wholeSaler List.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function wholeSalerList() {
        $arrClms = array(
            'pkWholesalerID ',
            'CompanyName',
        );
        $where = "";
        $varOrderBy = 'CompanyName ASC ';
        $arrRes = $this->select(TABLE_WHOLESALER, $arrClms, $where, $varOrderBy);
        return $arrRes;
    }

    /**
     * function countryById
     *
     * This function is used to retrive Single Country.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 $string
     *
     * @return array $arrRes
     */
    function countryById($countryId = '') {
        $arrClms = array(
            'country_id',
            'name',
        );
        $where = "country_id = '" . $countryId . "'";
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms, $where);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function wholesalerLogin
     *
     * This function is used for Wholesaler login.
     *
     * Database Tables used in this function are : tbl_wholesaler,tbl_country
     *
     * @access public
     *
     * @parameters 1 $array
     *
     * @return true false
     */
    function wholesalerLogin($argArrPost) {
        $objCore = new Core();
        $arrUserFlds = array('pkWholesalerID', 'CompanyEmail', 'CompanyPassword', 'CompanyAddress1', 'CompanyCountry', 'WholesalerStatus', 'IsEmailVerified');
        $varUserWhere = " CompanyEmail = '" . stripcslashes(trim($argArrPost['frmUserEmail'])) . "' AND CompanyPassword = '" . md5(trim($argArrPost['frmUserpassword'])) . "'";
        $arrUserList = $this->select(TABLE_WHOLESALER, $arrUserFlds, $varUserWhere);
        if (count($arrUserList) > 0) {
            if ($arrUserList[0]['WholesalerStatus'] == "active" && $arrUserList[0]['IsEmailVerified'] == 1) {


                if (!empty($argArrPost['remember_me'])) {
                    setcookie('wemail_id', $argArrPost['frmUserEmail'], time() + 3600, '/');
                    setcookie('wpassword', $argArrPost['frmUserpassword'], time() + 3600, '/');
                    setcookie('remember_me', 'yes', time() + 3600, '/');
                } else {
                    if (!empty($_COOKIE['wemail_id'])) {
                        setcookie('wemail_id', $argArrPost['frmUserEmail'], time() - 3600, '/');
                        setcookie('wpassword', $argArrPost['frmUserpassword'], time() - 3600, '/');
                        setcookie('remember_me', 'yes', time() - 3600, '/');
                    }
                }



                /* There is no need to find the timezone, This will mismatch when countries will be different for Users in support section.
                 *  $varCountryId = $arrUserList[0]['CompanyCountry'];
                  $arrClms = array('country_id', 'time_zone',);
                  $varWhr = 'country_id = ' . $varCountryId;
                  $arrCustomerZone = $this->select(TABLE_COUNTRY, $arrClms, $varWhr);
                 */
                if (count($arrUserList) > 0) {
                    $_SESSION['sessUserInfo']['type'] = 'wholesaler';
                    $_SESSION['sessUserInfo']['email'] = $arrUserList[0]['CompanyEmail'];
                    $_SESSION['sessUserInfo']['id'] = $arrUserList[0]['pkWholesalerID'];
                    $_SESSION['sessUserInfo']['countryid'] = $arrUserList[0]['CompanyCountry'];

                    //$_SESSION['sessTimeZone'] = $arrCustomerZone[0]['time_zone'];
                    echo '<script>parent.window.location.href =  "' . SITE_ROOT_URL . 'dashboard_wholesaler_account.php";</script>';
                }
            } else {
                if ($arrUserList[0]['IsEmailVerified'] == 0) {
                    //return EMAIL_NOT_VERIFIED_ERROR_MSG;
                    return EMAIL_NOT_VERIFIED_ERROR_MSGWHOLSALER;
                } else if ($arrUserList[0]['WholesalerStatus'] == "reject") {
                    return FRONT_CUSTOMER_REJECT_ERROR_MSG;
                } else if ($arrUserList[0]['WholesalerStatus'] == 'deactive') {
                    return FRONT_CUSTOMER_DEACTIVE_ERROR_MSG;
                } else if ($arrUserList[0]['WholesalerStatus'] == 'suspend') {
                    return FRONT_CUSTOMER_SUSPEND_ERROR_MSG;
                } else {
                    return FRONT_CUSTOMER_PENDING_ERROR_MSG;
                }
            }
        } else {
            return FRON_END_USER_LOGIN_ERROR;
        }
    }

    /**
     * function doWholesalerLogout
     *
     * This function is used for logout.
     *
     * Database Tables used in this function are :none
     *
     * @access public
     *
     * @parameters
     *
     * @return
     */
    function doWholesalerLogout() {
        if (isset($_SESSION['sessUserInfo'])) {
            unset($_SESSION['sessUserInfo']);
            unset($_SESSION['MyCart']);
            setcookie("MyCart", "", time() - 3600);
        }
    }

    /**
     * function getWholesalersCommission
     *
     * This function is used for get wholesaler commission information .
     *
     * Database Tables used in this function are : tbl_default_commission
     *
     * @access public
     *
     * @parameters 0
     *
     * @return $varQuery
     */
    function getWholesalersCommission() {

        $arrField = array('Wholesalers');
        $varTable = TABLE_DEFAULT_COMMISSION;
        $varQuery = $this->select($varTable, $arrField, '1');
        return $varQuery;
    }

    /**
     * function shippingGatewayList
     *
     * This function is used for get shipping getway information.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 0
     *
     * @return $arrRes
     */
    function shippingGatewayList($currentcountryid) {
        //         $arrClms = array(
//             'pkShippingGatewaysID',
//             'ShippingTitle',
//             'ShippingType'
//         );
//         $argWhere = "ShippingStatus='1'";
//         $varOrderBy = "ShippingType ASC,ShippingTitle ASC ";
//         $arrRes = $this->select(TABLE_SHIP_GATEWAYS, $arrClms, $argWhere);
        //new code avinesh
//        $arrClms = array(
//        		'pkShippingGatewaysID',
//        		'ShippingTitle',
//        		'ShippingType'
//        );
//        $varOrderBy = "";
//        $varQuery = "SELECT * FROM tbl_ship_gateways LEFT JOIN tbl_gateway_portal ON fkgatewayID = pkShippingGatewaysID WHERE " . $argWhere;
//        //pre($varQuery);
//        $arrRes = $this->getArrayResult($varQuery);
////       
//        return $arrRes;
//        $varClms = " zonetitleid,pkpriceid,fklogisticidvalue,shippingmethod,maxlength,maxwidth,maxheight,minkg,maxkg,costperkg,handlingcost,fragilecost,deliveryday,cubicweight,title,MethodName";
//        $varTable = TABLE_ZONEPRICE . " LEFT JOIN " . TABLE_ZONE . " ON zonetitleid = zoneid " . " LEFT JOIN " . TABLE_SHIPPING_METHOD . " ON shippingmethod = pkShippingMethod ";
//        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
//        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";
//
//        // $varOrderBy = "GROUP BY fkShippingMethodID ORDER BY ShippingType ASC,ShippingTitle ASC";
//
//        $this->getSortColumn($_REQUEST);
//        $sortable = $this->orderOptions;
//        // pre($sortable);
//        if (!empty($sortable)) {
//            $varOrderBy = "ORDER BY " . $sortable;
//        } else {
//            $varOrderBy = " ORDER BY pkpriceid DESC";
//        }
//        // pre($varOrderBy);
//        //$varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy ." " . $sortable. " " . $varLimit;
//        $varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy . " " . $varLimit;
////pre($varQuery);
//        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        // return $arrRes;
        //new code for logistic company avinesh

        $varClms = "logisticportalid,logisticTitle,logisticgatwaytype";

        $varTable = TABLE_LOGISTICPORTAL . " LEFT JOIN " . TABLE_ZONEPRICE . " ON logisticportalid = fklogisticidvalue ";
        $argWhere = "logisticportal = " . $currentcountryid . " AND pricestatus=1 AND logisticStatus=1";
        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";

        // $varOrderBy = "GROUP BY fkShippingMethodID ORDER BY ShippingType ASC,ShippingTitle ASC";
        $varOrderBy = "GROUP BY logisticTitle ORDER BY logisticTitle ASC";

        $varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy . "  " . $varLimit;
        // pre($varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function templateList
     *
     * This function is used for get wholesaler template list.
     *
     * Database Tables used in this function are : tbl_wholesaler_template
     *
     * @access public
     *
     * @parameters 0
     *
     * @return $arrRes
     */
    function templateList() {
        $arrClms = array('pkTemplateId', 'templateName', 'templateDisplayName', 'templateDefault');
        $argWhere = " templateDefault='0' OR templateDefault='1'";
        $varOrderBy = "";
        $arrRes = $this->select(TABLE_WHOLESALER_TEMPLATE, $arrClms, $argWhere);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function wholesalerSliderList
     *
     * This function is used for get wholesaler slider images list.
     *
     * Database Tables used in this function are : tbl_wholesaler_slider_images
     *
     * @access public
     *
     * @parameters 0
     *
     * @return $arrRes  	 	
     */
    function wholesalerSliderList($wid) {
        $arrClms = array('pkSliderId,sliderImage');
        $argWhere = " fkWholesalerId = '$wid'";
        $varOrderBy = " pkSliderId DESC";
        $arrRes = $this->select(TABLE_WHOLESALER_SLIDER_IMAGE, $arrClms, $argWhere);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function wholesalerDocumentList
     *
     * This function is used for get wholesaler document list.
     *
     * Database Tables used in this function are : tbl_documents
     *
     * @access public
     *
     * @parameters 0
     *
     * @return $arrRes  	 	
     */
    function wholesalerDocumentList($wid) {
        $arrClms = array('pkDocumentID,DocumentName,FileName');
        $argWhere = " fkWholesalerID = '$wid' AND DocumentType='1'";
        $varOrderBy = " pkDocumentID DESC";
        $arrRes = $this->select(TABLE_WHOLESALER_DOCUMENTS, $arrClms, $argWhere);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function addWholesaler
     *
     * This function is used for wholesaler registration and send email to wholesaler.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 $array
     *
     * @return $string
     */
    function addWholesaler($arrPost) {
        global $objGeneral;
        $objCore = new Core();
        $varEmail = $arrPost['frmCompany1Email'];
        $varWholesalerWhere = "CompanyEmail='" . $varEmail . "'";
        $arrClms = array('pkWholesalerID');
        $arrUserList = $this->select(TABLE_WHOLESALER, $arrClms, $varWholesalerWhere);
        if ($arrUserList) {
            $objCore->setErrorMsg(FRONT_WHOLESALER_EMAIL_ALREADY_EXIST);
            return false;
        } else {
            if ($_FILES['fileBusinessPlan']['name'] || $_FILES['fileBusinessDoc']['name'][0]) {
                if (!$this->checkValidFiles($_FILES)) {
                    $objCore->setErrorMsg(FRONT_WHOLESALER_DOCUMENT_INVALID);
                    return false;
                }
            }
            $varCommission = $this->getWholesalersCommission();

            $arrClms = array(
                'CompanyName' => $objCore->stripTags($arrPost['frmCompanyName']),
                'AboutCompany' => $objCore->stripTags($arrPost['frmAboutCompany']),
                'Services' => $objCore->stripTags($arrPost['frmServices']),
                'Commission' => $objCore->stripTags($varCommission[0]['Wholesalers']),
                'CompanyAddress1' => $objCore->stripTags($arrPost['frmCompany1Address1']),
                'CompanyAddress2' => $objCore->stripTags($arrPost['frmCompany1Address2']),
                'CompanyCity' => $objCore->stripTags($arrPost['CompanyCity']),
                'CompanyCountry' => $objCore->stripTags($arrPost['frmCompany1Country']),
                'CompanyState' => $objCore->stripTags($arrPost['CompanyState']),
                'CompanyRegion' => $objCore->stripTags($arrPost['frmCompany1Region']),
                'CompanyPostalCode' => $objCore->stripTags($arrPost['frmCompany1PostalCode']),
                'CompanyWebsite' => $objCore->stripTags($arrPost['frmCompany1Website']),
                'CompanyEmail' => $objCore->stripTags($arrPost['frmCompany1Email']),
                'CompanyPassword' => md5(trim($arrPost['frmPassword'])),
                'PaypalEmail' => $objCore->stripTags($arrPost['frmPaypalEmail']),
                'CompanyPhone' => $objCore->stripTags($arrPost['frmCompany1Phone']),
                'CompanyFax' => $objCore->stripTags($arrPost['frmCompany1Fax']),
                'Opt1CompanyAddress1' => $objCore->stripTags($arrPost['frmCompany2Address1']),
                'Opt1CompanyAddress2' => $objCore->stripTags($arrPost['frmCompany2Address2']),
                'Opt1CompanyCity' => $objCore->stripTags($arrPost['frmCompany2City']),
                'Opt1CompanyCountry' => $objCore->stripTags($arrPost['frmCompany2Country']),
                'Opt1CompanyPostalCode' => $objCore->stripTags($arrPost['frmCompany2PostalCode']),
                'Opt1CompanyWebsite' => $objCore->stripTags($arrPost['frmCompany2Website']),
                'Opt1CompanyEmail' => $objCore->stripTags($arrPost['frmCompany2Email']),
                'Opt1Companyphone' => $objCore->stripTags($arrPost['frmCompany2Phone']),
                'Opt1CompanyFax' => $objCore->stripTags($arrPost['frmCompany2Fax']),
                'Opt2CompanyAddress1' => $objCore->stripTags($arrPost['frmCompany3Address1']),
                'Opt2CompanyAddress2' => $objCore->stripTags($arrPost['frmCompany3Address2']),
                'Opt2CompanyCity' => $objCore->stripTags($arrPost['frmCompany3City']),
                'Opt2CompanyCountry' => $objCore->stripTags($arrPost['frmCompany3Country']),
                'Opt2CompanyPostalCode' => $objCore->stripTags($arrPost['frmCompany3PostalCode']),
                'Opt2CompanyWebsite' => $objCore->stripTags($arrPost['frmCompany3Website']),
                'Opt2CompanyEmail' => $objCore->stripTags($arrPost['frmCompany3Email']),
                'Opt2Companyphone' => $objCore->stripTags($arrPost['frmCompany3Phone']),
                'Opt2CompanyFax' => $objCore->stripTags($arrPost['frmCompany3Fax']),
                'ContactPersonName' => $objCore->stripTags($arrPost['frmContactName']),
                'ContactPersonPosition' => $objCore->stripTags($arrPost['frmContactPosition']),
                'ContactPersonPhone' => $objCore->stripTags($arrPost['frmContactPhone']),
                'ContactPersonEmail' => $objCore->stripTags($arrPost['frmContactEmail']),
                'ContactPersonAddress' => $objCore->stripTags($arrPost['frmContactAddress']),
                'OwnerName' => $objCore->stripTags($arrPost['frmOwnerName']),
                'OwnerPhone' => $objCore->stripTags($arrPost['frmOwnerPhone']),
                'OwnerEmail' => $objCore->stripTags($arrPost['frmOwnerEmail']),
                'OwnerAddress' => $objCore->stripTags($arrPost['frmOwnerAddress']),
                'Ref1Name' => $objCore->stripTags($arrPost['frmRefrence1Name']),
                'Ref1Phone' => $objCore->stripTags($arrPost['frmRefrence1Phone']),
                'Ref1Email' => $objCore->stripTags($arrPost['frmRefrence1Email']),
                'Ref1CompanyName' => $objCore->stripTags($arrPost['frmRefrence1CompanyName']),
                'Ref1CompanyAddress' => $objCore->stripTags($arrPost['frmRefrence1Address']),
                'Ref2Name' => $objCore->stripTags($arrPost['frmRefrence2Name']),
                'Ref2Phone' => $objCore->stripTags($arrPost['frmRefrence2Phone']),
                'Ref2Email' => $objCore->stripTags($arrPost['frmRefrence2Email']),
                'Ref2CompanyName' => $objCore->stripTags($arrPost['frmRefrence2CompanyName']),
                'Ref2CompanyAddress' => $objCore->stripTags($arrPost['frmRefrence2Address']),
                'Ref3Name' => $objCore->stripTags($arrPost['frmRefrence3Name']),
                'Ref3Phone' => $objCore->stripTags($arrPost['frmRefrence3Phone']),
                'Ref3Email' => $objCore->stripTags($arrPost['frmRefrence3Email']),
                'Ref3CompanyName' => $objCore->stripTags($arrPost['frmRefrence3CompanyName']),
                'Ref3CompanyAddress' => $objCore->stripTags($arrPost['frmRefrence3Address']),
                'WholesalerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                'WholesalerDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $arrAddID = $this->insert(TABLE_WHOLESALER, $arrClms);



            if ($_FILES['fileBusinessPlan']['name'] || $_FILES['fileBusinessDoc']['name'][0]) {
                $file = $this->uploadDocuments($_FILES, $arrAddID);
            }

            if ($arrAddID > 0) {
                $objTemplate = new EmailTemplate();

                $varFrom = SITE_NAME;
                $varSiteName = SITE_NAME;

                $vcode = $objGeneral->getEmailVerificationEncode($arrClms['CompanyEmail'] . ',' . $arrAddID . ',' . $arrClms['WholesalerDateAdded']);
                $VerificationUrl = $objCore->getUrl('verify_my_email.php', array('action' => md5('wholesaler'), 'vcode' => $vcode, 'ref' => 'index.php'));

                /*
                 * Sent email to wholesaler
                 */

                $varTo = trim(strip_tags($arrPost['frmCompany1Email']));
                $varUserName = $varTo;
                $varPassword = trim(strip_tags($arrPost['frmPassword']));

                $varWhereTemplate = " EmailTemplateTitle= 'WholeSalerRegistration' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{SITE_NAME}', '{USER_NAME}', '{PASSWORD}', '{VERIFICATION_URL}', '{VERIFICATION_URL}', '{SITE_NAME}');

                $varKeywordValues = array($varPathImage, $arrPost['frmCompanyName'], SITE_NAME, $varUserName, $varPassword, $VerificationUrl, $VerificationUrl, SITE_NAME);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                $objCore->sendMail($varTo, $varFrom, $varSubject, $varOutPutValues);

                /*
                 * Sent email to country portal and Supar Admin
                 *
                 */


                $varWhereTemplate = " EmailTemplateTitle= 'WholeSalerRegistrationNotification' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varWhere = "AdminCountry = '" . $arrClms['CompanyCountry'] . "' || AdminType = 'super-admin'";
                $AdminData = $this->adminList($varWhere);
                $varCtr = 0;

                foreach ($AdminData as $val) {

                    if ($val['AdminType'] == 'super-admin') {
                        $varCC = $val['AdminEmail'];
                    } else if ($val['AdminRegion'] == $arrClms['CompanyRegion']) {
                        $varCC = $val['AdminEmail'];
                        $varCtr = $varCtr++;
                    } else if ($val['AdminCountry'] == $arrClms['CompanyCountry'] && $varCtr == 0) {
                        $varCC = $val['AdminEmail'];
                    } else {

                        continue;
                    }


                    $varKeyword = array('{IMAGE_PATH}', '{ADMIN}', '{SITE_NAME}', '{SITE_NAME}');
                    $varKeywordValues = array($varPathImage, $val['AdminUserName'], SITE_NAME, SITE_NAME);

                    $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                    $objCore->sendMail($varCC, $varFrom, $varSubject, $varOutPutValues);
                }
            }

            return $arrAddID;
        }
    }

    function wholesalerResendlink($argArrPost) {
        global $objGeneral;
        $objCore = new Core();
        // pre($argArrPost);
        $wholsaleremail = $argArrPost['frmUserEmail'];
        $wholsalerpassword = $argArrPost['frmUserpassword'];
        // pre($wholsalerpassword);
        //$arrAddID = $this->insert(TABLE_WHOLESALER, $arrClms);
        $arrClms = array('pkWholesalerID,CompanyEmail,WholesalerDateAdded,CompanyName,CompanyCountry,CompanyRegion');
        $argWhere = " CompanyEmail = '$wholsaleremail'";
        $arrRes = $this->select(TABLE_WHOLESALER, $arrClms, $argWhere);
        $arrAddID = $arrRes[0]['pkWholesalerID'];
        //pre($arrRes[0]);
        //return $arrRes;
//            if ($_FILES['fileBusinessPlan']['name'] || $_FILES['fileBusinessDoc']['name'][0])
//            {
//                $file = $this->uploadDocuments($_FILES, $arrAddID);
//            }

        if ($arrAddID > 0) {
            $objTemplate = new EmailTemplate();

            $varFrom = SITE_NAME;
            $varSiteName = SITE_NAME;

            $vcode = $objGeneral->getEmailVerificationEncode($arrRes[0]['CompanyEmail'] . ',' . $arrAddID . ',' . $arrRes[0]['WholesalerDateAdded']);
            $VerificationUrl = $objCore->getUrl('verify_my_email.php', array('action' => md5('wholesaler'), 'vcode' => $vcode, 'ref' => 'index.php'));

            /*
             * Sent email to wholesaler
             */

            //$varTo = trim(strip_tags($arrPost['frmCompany1Email']));
            $varTo = trim(strip_tags($wholsaleremail));
//            $varUserName = $varTo;
//            $varPassword = trim(strip_tags($wholsalerpassword));

            $varWhereTemplate = " EmailTemplateTitle= 'WholeSalerRegistrationreactivation' AND EmailTemplateStatus = 'Active' ";

            $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

            $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

            $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

            $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

            $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

            $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{SITE_NAME}', '{USER_NAME}', '{PASSWORD}', '{VERIFICATION_URL}', '{VERIFICATION_URL}', '{SITE_NAME}');

            $varKeywordValues = array($varPathImage, $arrRes[0]['CompanyName'], SITE_NAME, $varUserName, $varPassword, $VerificationUrl, $VerificationUrl, SITE_NAME);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
            // pre($varOutPutValues);

            $objCore->sendMail($varTo, $varFrom, $varSubject, $varOutPutValues);

            /*
             * Sent email to country portal and Supar Admin
             *
             */


            $varWhereTemplate = " EmailTemplateTitle= 'WholeSalerRegistrationNotification' AND EmailTemplateStatus = 'Active' ";

            $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

            $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

            $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

            $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

            $varWhere = "AdminCountry = '" . $arrRes[0]['CompanyCountry'] . "' || AdminType = 'super-admin'";
            $AdminData = $this->adminList($varWhere);
            $varCtr = 0;

            foreach ($AdminData as $val) {

                if ($val['AdminType'] == 'super-admin') {
                    $varCC = $val['AdminEmail'];
                } else if ($val['AdminRegion'] == $arrRes[0]['CompanyRegion']) {
                    $varCC = $val['AdminEmail'];
                    $varCtr = $varCtr++;
                } else if ($val['AdminCountry'] == $arrRes[0]['CompanyCountry'] && $varCtr == 0) {
                    $varCC = $val['AdminEmail'];
                } else {

                    continue;
                }


                $varKeyword = array('{IMAGE_PATH}', '{ADMIN}', '{SITE_NAME}', '{SITE_NAME}');
                $varKeywordValues = array($varPathImage, $val['AdminUserName'], SITE_NAME, SITE_NAME);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                $objCore->sendMail($varCC, $varFrom, $varSubject, $varOutPutValues);
            }
        }

        return "<b style='color:green !important;'> Please check your mail !! Reactivation link has been sent successfully.</b>";

//        header('location:reactivationlink_message_wholesaler.php');
//                die;
    }

    /**
     * function wholesalerEmailVerification
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    function wholesalerEmailVerification($argArrPost) {

        global $objGeneral;

        $objCore = new Core();
        $arrUserFlds = array('pkWholesalerID', 'IsEmailVerified', 'CompanyName', 'CompanyEmail', 'WholesalerDateAdded');

        $varData = $objGeneral->getEmailVerificationDecode($argArrPost['vcode']);

        $arrData = explode(',', $varData);

        $varUserWhere = " CompanyEmail = '" . $arrData['0'] . "' AND pkWholesalerID = '" . $arrData[1] . "' AND WholesalerDateAdded='" . $arrData[2] . "' ";

        $arrUserList = $this->select(TABLE_WHOLESALER, $arrUserFlds, $varUserWhere);
        //pre($arrUserList);

        if (count($arrUserList) > 0) {
            if ($arrUserList[0]['IsEmailVerified'] == '0') {
                $varWhr = "pkWholesalerID = '" . $arrUserList[0]['pkWholesalerID'] . "'";
                $arrClms = array('IsEmailVerified' => '1');
                $this->update(TABLE_WHOLESALER, $arrClms, $varWhr);
                $this->sendEmailVerified($arrUserList[0]);
                // $objCore->setSuccessMsg(FRON_EMAIL_VERIFICATION_SUCCESS);
                return 1;
            } else {
                return 2;
            }
        } else {
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
    function sendEmailVerified($arrPost) {

        global $objGeneral;
        $objCore = new Core();
        $objTemplate = new EmailTemplate();

        $varUserName = trim(strip_tags($arrPost['CompanyEmail']));
        $varFromUser = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'EmailVerified' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

        $varKeyword = array('{SITE_NAME}', '{IMAGE_PATH}', '{SITE_NAME}', '{CUSTOMER}', '{SITE_NAME}', '{SITE_NAME}');

        $varKeywordValues = array(SITE_NAME, $varPathImage, SITE_NAME, ucfirst($arrPost['CompanyName']), SITE_NAME, SITE_NAME);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

        // Calling mail function
        $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);
    }

    /**
     * function updateWholesaler
     *
     * This function is used for update wholesaler profile .
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_wholesaler_to_shipping_gateway
     *
     * @access public
     *
     * @parameters 1 $array
     *
     * @return $string
     */
    function updateWholesaler($arrPost) {
        //pre($arrPost);
        $objCore = new Core();
        $varWhr = 'pkWholesalerID = ' . $_SESSION['sessUserInfo']['id'];
        if ($_FILES['fileBusinessPlan']['name'] || $_FILES['fileBusinessDoc']['name'][0]) {
            if (!$this->checkValidFiles($_FILES)) {
                $_POST['error_msg'] = FRONT_WHOLESALER_DOCUMENT_INVALID;
                return false;
            }
        }
        $varWhLogo = $objCore->stripTags($arrPost['fileLogo']);
        $arrClmsUpdate = array(
            'CompanyName' => $objCore->stripTags($arrPost['frmCompanyName']),
            'AboutCompany' => $objCore->stripTags($arrPost['frmAboutCompany']),
            'Services' => $objCore->stripTags($arrPost['frmServices']),
            'CompanyAddress1' => $objCore->stripTags($arrPost['frmCompany1Address1']),
            'CompanyAddress2' => $objCore->stripTags($arrPost['frmCompany1Address2']),
            'CompanyCity' => $objCore->stripTags($arrPost['frmCompany1City']),
            'CompanyCountry' => $objCore->stripTags($arrPost['frmCompany1Country']),
            'CompanyRegion' => $objCore->stripTags($arrPost['frmCompany1Region']),
            'CompanyPostalCode' => $objCore->stripTags($arrPost['frmCompany1PostalCode']),
            'CompanyWebsite' => $objCore->stripTags($arrPost['frmCompany1Website']),
            'CompanyEmail' => $objCore->stripTags($arrPost['frmCompany1Email']),
            'PaypalEmail' => $objCore->stripTags($arrPost['frmPaypalEmail']),
            'CompanyPhone' => $objCore->stripTags($arrPost['frmCompany1Phone']),
            'CompanyFax' => $objCore->stripTags($arrPost['frmCompany1Fax']),
            'Opt1CompanyAddress1' => $objCore->stripTags($arrPost['frmCompany2Address1']),
            'Opt1CompanyAddress2' => $objCore->stripTags($arrPost['frmCompany2Address2']),
            'Opt1CompanyCity' => $objCore->stripTags($arrPost['frmCompany2City']),
            'Opt1CompanyCountry' => $objCore->stripTags($arrPost['frmCompany2Country']),
            'Opt1CompanyPostalCode' => $objCore->stripTags($arrPost['frmCompany2PostalCode']),
            'Opt1CompanyWebsite' => $objCore->stripTags($arrPost['frmCompany2Website']),
            'Opt1CompanyEmail' => $objCore->stripTags($arrPost['frmCompany2Email']),
            'Opt1Companyphone' => $objCore->stripTags($arrPost['frmCompany2Phone']),
            'Opt1CompanyFax' => $objCore->stripTags($arrPost['frmCompany2Fax']),
            'Opt2CompanyAddress1' => $objCore->stripTags($arrPost['frmCompany3Address1']),
            'Opt2CompanyAddress2' => $objCore->stripTags($arrPost['frmCompany3Address2']),
            'Opt2CompanyCity' => $objCore->stripTags($arrPost['frmCompany3City']),
            'Opt2CompanyCountry' => $objCore->stripTags($arrPost['frmCompany3Country']),
            'Opt2CompanyPostalCode' => $objCore->stripTags($arrPost['frmCompany3PostalCode']),
            'Opt2CompanyWebsite' => $objCore->stripTags($arrPost['frmCompany3Website']),
            'Opt2CompanyEmail' => $objCore->stripTags($arrPost['frmCompany3Email']),
            'Opt2Companyphone' => $objCore->stripTags($arrPost['frmCompany3Phone']),
            'Opt2CompanyFax' => $objCore->stripTags($arrPost['frmCompany3Fax']),
            'ContactPersonName' => $objCore->stripTags($arrPost['frmContactName']),
            'ContactPersonPosition' => $objCore->stripTags($arrPost['frmContactPosition']),
            'ContactPersonPhone' => $objCore->stripTags($arrPost['frmContactPhone']),
            'ContactPersonEmail' => $objCore->stripTags($arrPost['frmContactEmail']),
            'ContactPersonAddress' => $objCore->stripTags($arrPost['frmContactAddress']),
            'OwnerName' => $objCore->stripTags($arrPost['frmOwnerName']),
            'OwnerPhone' => $objCore->stripTags($arrPost['frmOwnerPhone']),
            'OwnerEmail' => $objCore->stripTags($arrPost['frmOwnerEmail']),
            'OwnerAddress' => $objCore->stripTags($arrPost['frmOwnerAddress']),
            'Ref1Name' => $objCore->stripTags($arrPost['frmRefrence1Name']),
            'Ref1Phone' => $objCore->stripTags($arrPost['frmRefrence1Phone']),
            'Ref1Email' => $objCore->stripTags($arrPost['frmRefrence1Email']),
            'Ref1CompanyName' => $objCore->stripTags($arrPost['frmRefrence1CompanyName']),
            'Ref1CompanyAddress' => $objCore->stripTags($arrPost['frmRefrence1Address']),
            'Ref2Name' => $objCore->stripTags($arrPost['frmRefrence2Name']),
            'Ref2Phone' => $objCore->stripTags($arrPost['frmRefrence2Phone']),
            'Ref2Email' => $objCore->stripTags($arrPost['frmRefrence2Email']),
            'Ref2CompanyName' => $objCore->stripTags($arrPost['frmRefrence2CompanyName']),
            'Ref2CompanyAddress' => $objCore->stripTags($arrPost['frmRefrence2Address']),
            'Ref3Name' => $objCore->stripTags($arrPost['frmRefrence3Name']),
            'Ref3Phone' => $objCore->stripTags($arrPost['frmRefrence3Phone']),
            'Ref3Email' => $objCore->stripTags($arrPost['frmRefrence3Email']),
            'Ref3CompanyName' => $objCore->stripTags($arrPost['frmRefrence3CompanyName']),
            'Ref3CompanyAddress' => $objCore->stripTags($arrPost['frmRefrence3Address']),
            'fkTemplateId' => $arrPost['frmTemplate'],
            'WholesalerDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        if ($varWhLogo != '')
            $arrClmsUpdate['wholesalerLogo'] = $varWhLogo;

        $arrUpdateID = $this->update(TABLE_WHOLESALER, $arrClmsUpdate, $varWhr);
        $this->delete(TABLE_WHOLESALER_TO_SHIPPING_GATEWAY, " fkWholesalerID = " . $_SESSION['sessUserInfo']['id']);
        foreach ($arrPost['frmShippingGateway'] as $key => $val) {
            $arrCls = array(
                'fkWholesalerID' => $_SESSION['sessUserInfo']['id'],
                'fkShippingGatewaysID' => $val
            );
            $this->insert(TABLE_WHOLESALER_TO_SHIPPING_GATEWAY, $arrCls);
        }
        if ($_FILES['fileBusinessPlan']['name'] || isset($_FILES['fileBusinessDoc']['name'])) {
            $file = $this->updateDocument($_FILES, $_SESSION['sessUserInfo']['id']);
        }

        if (isset($_POST['fileSliderImage'][0]) && $_POST['fileSliderImage'][0] != '') {
            foreach ($_POST['fileSliderImage'] as $file_name) {
                $arrClmsUpdate = array('fkWholesalerId' => $_SESSION['sessUserInfo']['id'], 'sliderImage' => $file_name);
                $arrID = $this->insert(TABLE_WHOLESALER_SLIDER_IMAGE, $arrClmsUpdate);
            }

            //$file = $this->uploadSliderImage($_POST['fileSliderImage']);
        }
        return $arrUpdateID;
    }

    /**
     * function checkValidFiles
     *
     * This function is used to validate wholesaler doc.
     *
     * Database Tables used in this function are :none
     *
     * @access public
     *
     * @parameters 1 $array
     *
     * @return boolean
     */
    function checkValidFiles($FILES) {
        $allowedExts = array("jpg", "jpeg", "gif", "png", "doc", "docx", "ods", "pdf", "xls", "xlsx");
        $temp = explode(".", $_FILES["fileBusinessPlan"]["name"]);
        $extension = strtolower(end($temp));
        if ($_FILES["fileBusinessPlan"]["name"]) {

            if (($_FILES["fileBusinessPlan"]["size"] < 99999999) && in_array($extension, $allowedExts)) {
                
            } else {
                return false;
            }
        }
        foreach ($FILES['fileBusinessDoc']['name'] as $key => $val) {
            if ($val) {
                $temp = explode(".", $_FILES["fileBusinessDoc"]["name"][$key]);
                $extension = strtolower(end($temp));
                if (($_FILES["fileBusinessDoc"]["size"][$key] < 99999999) && in_array($extension, $allowedExts)) {
                    
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * function updateDocument
     *
     * This function is used to update wholesaler doc.
     *
     * Database Tables used in this function are : tbl_wholesaler_documents
     *
     * @access public
     *
     * @parameters 2 $array, $string
     *
     * @return boolean
     */
    function updateDocument($FILES, $arrAddID) {
        $allowedExts = array("jpg", "jpeg", "gif", "png", "doc", "docx", "ods", "pdf", "xls", "xlsx");
        $temp = explode(".", $_FILES["fileBusinessPlan"]["name"]);
        $extension = strtolower(end($temp));
        if ($_FILES["fileBusinessPlan"]["name"]) {
            if (($_FILES["fileBusinessPlan"]["size"] < 99999999) && in_array($extension, $allowedExts)) {
                if ($_FILES["fileBusinessPlan"]["error"] > 0) {
                    return $_FILES["fileBusinessPlan"]["error"];
                } else {
                    $file_name = md5(time() . rand(10, 99)) . '.' . end($temp);
                    move_uploaded_file($_FILES["fileBusinessPlan"]["tmp_name"], UPLOADED_FILES_SOURCE_PATH . "files/wholesaler/" . $file_name);

                    $this->delete(TABLE_WHOLESALER_DOCUMENTS, " fkWholesalerID = " . $_SESSION['sessUserInfo']['id'] . " AND DocumentType=1");

                    //$varWhr = 'fkWholesalerID = ' . $_SESSION['sessUserInfo']['id'] . ' AND DocumentType=1';
                    $arrClmsUpdate = array('DocumentName' => $file_name, 'FileName' => $_FILES["fileBusinessPlan"]["name"], 'fkWholesalerID' => $_SESSION['sessUserInfo']['id'], 'DocumentType' => '1');
                    $arrID = $this->insert(TABLE_WHOLESALER_DOCUMENTS, $arrClmsUpdate);
                }
            } else {
                return false;
            }
        }
    }

    /**
     * function uploadSliderImage
     *
     * This function is used to update wholesaler slider.
     *
     * Database Tables used in this function are : tbl_wholesaler_slider_image
     *
     * @access public
     *
     * @parameters 2 $array, $string
     *
     * @return boolean
     */
    function uploadSliderImage($FILES) {
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        for ($i = 0; $i < count($FILES['fileSliderImage']['name']); $i++) {
            $temp = explode(".", $FILES['fileSliderImage']['name'][$i]);
            $extension = strtolower(end($temp));
            if ($FILES['fileSliderImage']['name'][$i]) {
                if (($FILES['fileSliderImage']['name'][$i] < 99999999) && in_array($extension, $allowedExts)) {
                    if ($FILES['fileSliderImage']['error'][$i] > 0) {
                        return $FILES['fileSliderImage']['error'][$i];
                    } else {
                        $file_name = md5(time() . rand(10, 99)) . '.' . end($temp);
                        move_uploaded_file($_FILES["fileSliderImage"]["tmp_name"][$i], UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_slider/" . $file_name);
                        //Create the Slider Thumbnail
//                        $objUpload = new upload();
//                        $objUpload->setThumbnailName('320x310/');
//                        $objUpload->createThumbnail();
//                        $objUpload->setThumbnailSize('320', '310');
                        //$varWhr = 'fkWholesalerID = ' . $_SESSION['sessUserInfo']['id'];
                        $arrClmsUpdate = array('fkWholesalerId' => $_SESSION['sessUserInfo']['id'], 'sliderImage' => $file_name);
                        $arrID = $this->insert(TABLE_WHOLESALER_SLIDER_IMAGE, $arrClmsUpdate);
                    }
                }
            }
        }
    }

    /**
     * function uploadDocuments
     *
     * This function is used to update wholesaler doc.
     *
     * Database Tables used in this function are : tbl_wholesaler_documents
     *
     * @access public
     *
     * @parameters 2 $array, $string
     *
     * @return boolean
     */
    function uploadDocuments($FILES, $arrAddID) {
        global $objCore;

        $allowedExts = array("jpg", "jpeg", "gif", "png", "doc", "docx", "ods", "pdf", "xls", "xlsx");
        $temp = explode(".", $_FILES["fileBusinessPlan"]["name"]);
        $extension = strtolower(end($temp));
        if ($_FILES["fileBusinessPlan"]["name"]) {
            if (($_FILES["fileBusinessPlan"]["size"] < 99999999) && in_array($extension, $allowedExts)) {
                if ($_FILES["fileBusinessPlan"]["error"] > 0) {
                    return $_FILES["fileBusinessPlan"]["error"];
                } else {
                    $file_name = md5(time() . rand(10, 99)) . '.' . end($temp);
                    move_uploaded_file($_FILES["fileBusinessPlan"]["tmp_name"], UPLOADED_FILES_SOURCE_PATH . "files/wholesaler/" . $file_name);
                    $arrClms = array('fkWholesalerID' => $arrAddID, 'DocumentName' => $file_name, 'FileName' => $_FILES["fileBusinessPlan"]["name"], 'DocumentType' => 1, 'DateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
                    $arrID = $this->insert(TABLE_WHOLESALER_DOCUMENTS, $arrClms);
                }
            } else {
                return false;
            }
        }

        foreach ($FILES['fileBusinessDoc']['name'] as $key => $val) {
            if ($val) {
                $temp = explode(".", $_FILES["fileBusinessDoc"]["name"][$key]);
                $extension = strtolower(end($temp));
                if (($_FILES["fileBusinessDoc"]["size"][$key] < 99999999) && in_array($extension, $allowedExts)) {
                    if ($_FILES["file"]["error"][$key] > 0) {
                        return $_FILES["file"]["error"][$key];
                    } else {
                        $file_name = md5(time() . rand(10, 99)) . '.' . end($temp);
                        move_uploaded_file($_FILES["fileBusinessDoc"]["tmp_name"][$key], UPLOADED_FILES_SOURCE_PATH . "files/wholesaler/" . $file_name);
                        $arrClms = array('fkWholesalerID' => $arrAddID, 'DocumentName' => $file_name, 'FileName' => $_FILES["fileBusinessDoc"]["name"][$key], 'DocumentType' => 2, 'DateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
                        $arrID = $this->insert(TABLE_WHOLESALER_DOCUMENTS, $arrClms);
                    }
                } else {
                    return false;
                }
            }
        }
    }

    /**
     * function regionList
     *
     * This function is used to retrive region List.
     *
     * Database Tables used in this function are : tbl_region
     *
     * @access public
     *
     * @parameters 1 countryid
     *
     * @return array $arrRes
     */
    function regionList($countryID) {
        $arrClms = array('pkRegionID', 'RegionName', 'Image');
        $where = "fkCountryId = '" . $countryID . "'";
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_REGION, $arrClms, $where);
        return $arrRes;
    }

    /**
     * function regionList
     *
     * This function is used to retrive region List.
     *
     * Database Tables used in this function are : tbl_region
     *
     * @access public
     *
     * @parameters 1 countryid
     *
     * @return array $arrRes
     */
    function zoneList($countryID) {
        $arrClms = array('country_id', 'name', 'time_zone');
        $where = "country_id = '" . $countryID . "'";
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms, $where);
        return $arrRes;
    }

    /**
     * function WholesalerDetails
     *
     * This function is used to retrive Wholesaler Details.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_country, tbl_region, tbl_wholesaler_to_shipping_gateway
     *
     * @access public
     *
     * @parameters 1 WholesalerId
     *
     * @return array $arrRes
     */
    function WholesalerDetails($id) {

        $arrClms = array(
            'pkWholesalerID',
            'CompanyName',
            'AboutCompany',
            'Services',
            'Commission',
            'CompanyAddress1',
            'CompanyAddress2',
            'CompanyCity',
            'CompanyCountry',
            'CompanyState',
            'c1.name as CompanyCountryName',
            'CompanyRegion',
            'RegionName',
            'CompanyPostalCode',
            'CompanyWebsite',
            'CompanyEmail',
            'CompanyPassword',
            'PaypalEmail',
            'CompanyPhone',
            'CompanyFax',
            'ContactPersonName',
            'ContactPersonPosition',
            'ContactPersonPhone',
            'ContactPersonEmail',
            'ContactPersonAddress',
            'OwnerName',
            'OwnerPhone',
            'OwnerEmail',
            'OwnerAddress',
            'Ref1Name',
            'Ref1Phone',
            'Ref1Email',
            'Ref1CompanyName',
            'Ref1CompanyAddress',
            'Ref2Name',
            'Ref2Phone',
            'Ref2Email',
            'Ref2CompanyName',
            'Ref2CompanyAddress',
            'Ref3Name',
            'Ref3Phone',
            'Ref3Email',
            'Ref3CompanyName',
            'Ref3CompanyAddress',
            'WholesalerStatus',
            'fkTemplateId',
            'wholesalerLogo'
        );
        $varWhr = "pkWholesalerID='" . (int) $id . "' AND WholesalerStatus='active'";
        $varWhere = "fkWholesalerId='" . (int) $id . "'";

        $varTable = TABLE_WHOLESALER . " LEFT JOIN " . TABLE_COUNTRY . " as c1 ON CompanyCountry = country_id LEFT JOIN " . TABLE_REGION . " ON CompanyRegion = pkRegionID ";
        $arrRes = $this->select($varTable, $arrClms, $varWhr);
        $arrShippingDetails = $this->getArrayResult("SELECT GROUP_CONCAT(fkShippingGatewaysID) as ShippingGateway FROM " . TABLE_WHOLESALER_TO_SHIPPING_GATEWAY . " where fkWholesalerID= '" . $id . "' GROUP BY fkWholesalerID");
        $arrRes[0]['shippingDetails'] = explode(',', $arrShippingDetails[0]['ShippingGateway']);
        $wholesaler_slider_image = $this->getArrayResult("SELECT sliderImage FROM " . TABLE_WHOLESALER_SLIDER_IMAGE . " WHERE $varWhere ORDER BY pkSliderId DESC LIMIT 3");
        $arrRes[0]['Sliderimage'] = $wholesaler_slider_image;

        $varWhereTest = "p.fkWholesalerID = '" . $id . "' AND r.ApprovedStatus='Allow'";
        $wholesaler_product_review = $this->getArrayResult("SELECT r.Reviews,concat(c.CustomerFirstName,' ',c.CustomerLastName) AS customerName FROM " . TABLE_REVIEW . " AS r INNER JOIN " . TABLE_PRODUCT . " AS p ON (r.fkProductID=p.pkProductID) INNER JOIN " . TABLE_CUSTOMER . " AS c ON(r.fkCustomerID=c.pkCustomerID) WHERE $varWhereTest ORDER BY r.fkCustomerID DESC LIMIT 10");
        $arrRes[0]['Testimonial'] = $wholesaler_product_review;
        //        $arrRes = $this->getArrayResult($q);
        //pre($arrRes);
        return $arrRes[0];
    }

    /**
     * function wholesalerWarnings
     *
     * This function is used to retrive Wholesaler Warnings.
     *
     * Database Tables used in this function are : tbl_wholesaler_warning
     *
     * @access public
     *
     * @parameters 2 String, String
     *
     * @return array $arrRes
     */
    function wholesalerWarnings($id, $varlimit) {
        $arrClms = array('WarningText', 'WarningDateAdded', 'pkWarningID', 'WarningMsg');
        $where = "fkWholesalerID = '" . $id . "'";
        $varOrderBy = 'WarningDateAdded DESC ';
        $arrRes = $this->select(TABLE_WHOLESALER_WARNING, $arrClms, $where, $varOrderBy, $varlimit);
        return $arrRes;
    }

    /**
     * function getFullWarning
     *
     * This function is used to retrive Wholesaler Warnings.
     *
     * Database Tables used in this function are : tbl_wholesaler_warning
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getFullWarning($wid) {
        $arrClms = array('WarningText', 'WarningDateAdded', 'pkWarningID');
        $where = "pkWarningID = '" . $wid . "'";
        $arrRes = $this->select(TABLE_WHOLESALER_WARNING, $arrClms, $where);
        echo $arrRes[0]['WarningText'];
        die;
    }

    /**
     * function productList
     *
     * This function is used to retrive Wholesaler Products.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
    function productList($wid, $limit) {
        global $objCore;

        $varWhere = "pkWholesalerID='" . $wid . "' ";
        $oderColumn = $_POST['sort_column'] ? $_POST['sort_column'] : 'pkProductID';
        $oderDir = $_POST['sort_order'] ? $_POST['sort_order'] : 'DESC';
        $varOrderBy = $oderColumn . ' ' . $oderDir;
        $arrClms = array('count(TodayOfferID) as offer', 'pkProductID', 'Quantity', 'ProductRefNo', 'ProductName', 'CategoryName', 'CategoryIsDeleted', 'CompanyName', 'WholesalePrice', 'FinalPrice', 'ProductStatus', 'DiscountFinalPrice', 'DiscountPrice');
        if ($_POST['frmHidden'] && $_POST['frmHidden'] == 'search') {
            $varWhere.= $_POST['frmCategory'] ? " AND fkCategoryID ='" . $objCore->getFormatValue($_POST['frmCategory']) . "'" : '';
            $varWhere.= $_POST['frmInStock'] ? " AND Quantity >0" : " AND Quantity = 0";
            $varWhere.= $_POST['frmProductRef'] ? " AND ProductRefNo LIKE '%" . $objCore->getFormatValue($_POST['frmProductRef']) . "%' " : '';
            $varWhere.= $_POST['frmProductName'] ? " AND ProductName LIKE '%" . $objCore->getFormatValue($_POST['frmProductName']) . "%' " : '';
        }
        //echo $varOrderBy;die;
        $varTable = TABLE_PRODUCT . ' LEFT JOIN ' . TABLE_CATEGORY . ' ON fkCategoryID=pkCategoryId LEFT JOIN ' . TABLE_WHOLESALER . ' ON fkWholesalerID = pkWholesalerID LEFT JOIN ' . TABLE_PRODUCT_TODAY_OFFER . ' ON pkProductID =fkProductId';

        if ($limit <> '') {
            //echo $varWhere;
            $arrRes = $this->select($varTable, $arrClms, $varWhere . ' group by pkProductID', $varOrderBy, $limit);
            //pre($arrRes);
            // Check this product will included in iny package or not for product delete
            foreach ($arrRes as $k => $val) {
                $varSql = "SELECT distinct(fkPackageId) as pkgid FROM " . TABLE_PRODUCT_TO_PACKAGE . " where fkProductId = '" . $val['pkProductID'] . "' GROUP BY fkProductId";
                $arrPTP = $this->getArrayResult($varSql);
                $arrRes[$k]['pkgid'] = $arrPTP[0]['pkgid'];
            }
        } else {
            $varWhere = " AND " . $varWhere;
            $arrRes = $this->getNumRows($varTable, "pkProductID", $varWhere);
        }
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function CategoryList
     *
     * This function is used to retrive all Category.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRows
     */
    function CategoryList() {
        $arrClms = array('pkCategoryId', 'CategoryName', 'CategoryParentId');
        $varWhr = 'CategoryParentId=0 AND CategoryIsDeleted=0 ';
        $arrRes = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
        $arrRows = array();

        foreach ($arrRes as $v) {
            $arrRows[$v['pkCategoryId']] = $v['CategoryName'];
            $varWhr = 'CategoryParentId = ' . $v['pkCategoryId'] . " AND CategoryIsDeleted=0";

            $arr = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
            foreach ($arr as $sv) {
                $arrRows[$sv['pkCategoryId']] = '&nbsp;&nbsp;&nbsp;' . $sv['CategoryName'];
                $varWhr = 'CategoryParentId = ' . $sv['pkCategoryId'] . ' AND CategoryIsDeleted=0';
                $arrCatgoryL2 = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
                foreach ($arrCatgoryL2 as $ssv) {
                    $arrRows[$ssv['pkCategoryId']] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $ssv['CategoryName'];
                }
            }
        }
        //pre($arrRows);die;
        return $arrRows;
    }

    /**
     * function deleteProduct
     *
     * This function is used to delete Wholesaler Products.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image, tbl_product_rating, tbl_product_to_option, tbl_product_to_package, tbl_recommend, tbl_review, tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varAffected
     */
    function deleteProduct($pid, $wid) {
        global $objGeneral;

        $varWhereSdelete = " pkProductID = '" . $pid . "' AND fkWholesalerID='" . $wid . "'";
        $objGeneral->solrProductRemoveAdd($varWhereSdelete);
        $this->insert(TABLE_WHOLESALER_PRODUCT_DELETE, array('fkProductID' => $pid, 'fkWholesalerID' => $wid));


        $varAffected = $this->delete(TABLE_PRODUCT, $varWhereSdelete);
        if ($varAffected) {
            $varWhr = " fkProductID = '" . $pid . "' ";

            $this->delete(TABLE_PRODUCT_IMAGE, $varWhr);
            $this->delete(TABLE_PRODUCT_RATING, $varWhr);
            $this->delete(TABLE_PRODUCT_TO_OPTION, $varWhr);
            $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWhr);
            $this->delete(TABLE_RECOMMEND, $varWhr);
            $this->delete(TABLE_REVIEW, $varWhr);
            $this->delete(TABLE_WISHLIST, $varWhr);
            $this->delete(TABLE_SPECIAL_PRODUCT, $varWhr);
        }
        global $oCache;
        //Check memcache is enabled or not
        if ($oCache->bEnabled) {
            //Flush memcache data
            $oCache->flushData();
        }
        return $varAffected;
    }

    /**
     * function getShippingGatwayList
     *
     * This function is used to retrive ShippingGatway List.
     *
     * Database Tables used in this function are : tbl_wholesaler_to_shipping_gateway, tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRow
     */
    function getShippingGatwayList($wid) {

        $varID = 'fkWholesalerID =' . $wid;
        $arrClms = array(
            'GROUP_CONCAT(fkShippingGatewaysID) as ids'
        );
        $varTable = TABLE_WHOLESALER_TO_SHIPPING_GATEWAY;
        $arrRow = $this->select($varTable, $arrClms, $varID);
        if ($arrRow[0]['ids']) {
            $varID = "ShippingStatus=1 AND pkShippingGatewaysID IN ({$arrRow[0]['ids']})";
        } else {
            $varID = "";
        }

        $arrClms = array(
            'ShippingTitle', 'pkShippingGatewaysID'
        );
        // $varTable = TABLE_SHIPPING_GATEWAYS;
        $varTable = TABLE_SHIP_GATEWAYS;
        $arrRow = $this->select($varTable, $arrClms, $varID);

        return $arrRow;
    }

    /**
     * function productDetail
     *
     * This function is used to retrive product Detail.
     *
     * Database Tables used in this function are : tbl_product, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRow
     */
    function productDetail($argID, $wid) {
        $varID = "pkProductID ='" . $argID . "' AND fkWholesalerID='" . $wid . "'";
        $arrClms = array(
            'pkProductID',
            'fkCategoryID',
            'ProductRefNo',
            'fkShippingID',
            'fkWholesalerID',
            'CompanyCountry',
            'ProductName',
            'ProductImage',
            'ProductSliderImage',
            'WholesalePrice',
            'DiscountFinalPrice',
            'DiscountPrice',
            'FinalPrice',
            'DateStart',
            'DateEnd',
            'Quantity',
            'QuantityAlert',
            'Weight',
            'WeightUnit',
            'Length',
            'Width',
            'Height',
            'DimensionUnit',
            'fkPackageId',
            'ProductDescription',
            'ProductTerms',
            'YoutubeCode',
            'HtmlEditor',
            'MetaTitle',
            'MetaKeywords',
            'MetaDescription',
            'productdangerous',
            'productfragile',
            'IsFeatured'
        );
        $varTable = TABLE_PRODUCT . ' LEFT JOIN ' . TABLE_WHOLESALER . ' ON  fkWholesalerID=pkWholesalerID ';
        $arrRow = $this->select($varTable, $arrClms, $varID);
        //pre($arrRow);
        return $arrRow;
    }

    function productmulcountrydetail($pid) {
        $varID = "fkproduct_id ='" . $pid . "'";
        $arrClms = array(
            'fkproduct_id',
            'country_id',
            'producttype',
        );
        $varTable = tbl_productmulcountry;
        $arrRow = $this->select($varTable, $arrClms, $varID);
        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function PackageFullDropDownList
     *
     * This function is used to retrive Package List.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function PackageFullDropDownList($wid) {
        $arrClms = array('pkPackageId', 'PackageName');
        $varWhr = "fkWholesalerID='" . $wid . "' AND PackageStatus='1'";
        $varOrderBy = 'PackageName ASC ';
        $arrRes = $this->select(TABLE_PACKAGE, $arrClms, $varWhr, $varOrderBy);
        //pre($arrRes);die;
        return $arrRes;
    }

    /**
     * function productImages
     *
     * This function is used to retrive product Images.
     *
     * Database Tables used in this function are : tbl_product_image
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function productImages($argpid) {
        $arrClms = array(
            'pkImageID',
            'ImageName'
        );
        $argWhere = "fkProductID = '" . $argpid . "'";
        $varOrderBy = 'ImageDateAdded DESC';
        $varTable = TABLE_PRODUCT_IMAGE;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
        return $arrRes;
    }

    /**
     * function CategoryToAttribute
     *
     * This function is used to retrive Attribute List  .
     *
     * Database Tables used in this function are : tbl_attribute_to_category, tbl_attribute, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRows
     */
    function CategoryToAttribute($argcatid) {
        $arrClms = array('fkCategoryID', 'fkAttributeID');
        $varWhere = 'fkCategoryid=' . $argcatid;
        $varOrderBy = 'fkAttributeID ASC';
        $varTable = TABLE_ATTRIBUTE_TO_CATEGORY;
        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy);
        $arrRows = array();
        foreach ($arrRes as $val) {
            $arrClms = array('pkAttributeID', 'AttributeCode', 'AttributeLabel', 'AttributeInputType');
            $varOrderBy = 'pkAttributeID DESC';
            $varWher = 'pkAttributeID = ' . $val['fkAttributeID'];
            $arrRow = $this->select(TABLE_ATTRIBUTE, $arrClms, $varWher, $varOrderBy);
            $arrRows[$val['fkAttributeID']]['pkAttributeID'] = $arrRow[0]['pkAttributeID'];
            $arrRows[$val['fkAttributeID']]['AttributeCode'] = $arrRow[0]['AttributeCode'];
            $arrRows[$val['fkAttributeID']]['AttributeLabel'] = $arrRow[0]['AttributeLabel'];
            $arrRows[$val['fkAttributeID']]['AttributeInputType'] = $arrRow[0]['AttributeInputType'];

            $arrClmsOpt = array('pkOptionID', 'OptionTitle');
            $varOrderByOpt = 'pkOptionID ASC';
            $varWherOpt = 'fkAttributeID = ' . $val['fkAttributeID'];
            $arrOpt = $this->select(TABLE_ATTRIBUTE_OPTION, $arrClmsOpt, $varWherOpt, $varOrderByOpt);
            $arrRows[$val['fkAttributeID']]['OptionsData'] = $arrOpt;
            $arrRows[$val['fkAttributeID']]['OptionsRows'] = count($arrOpt);
        }
        //print_r($arrRow);
        return $arrRows;
    }

    /**
     * function ProductToOptions
     *
     * This function is used to retrive product's Attribute options.
     *
     * Database Tables used in this function are : tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function ProductToOptions($argpid) {
        $varSql = "SELECT GROUP_CONCAT(AttributeOptionValue) as optval,GROUP_CONCAT(fkAttributeOptionId) as optid,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice,GROUP_CONCAT(AttributeOptionValue SEPARATOR ';;') as AttributeOptionValue,GROUP_CONCAT(AttributeOptionImage) as optimg FROM " . TABLE_PRODUCT_TO_OPTION . " where fkProductId = '" . $argpid . "' GROUP BY fkProductId";
        $arrRes = $this->getArrayResult($varSql);
        return $arrRes;
    }

    /**
     * function productToAttributeOptions
     *
     * This function is used to display Product To Options.
     *
     * Database Tables used in this function are : tbl_attribute, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function productToAttributeOptions($argpid, $wid) {
        $varSql = "SELECT pkAttributeID,AttributeCode,AttributeLabel,AttributeInputType FROM " . TABLE_ATTRIBUTE . " INNER JOIN " . TABLE_PRODUCT_TO_OPTION . " ON (fkAttributeId = pkAttributeID AND fkProductId = '" . $argpid . "') GROUP BY fkAttributeId";
        $arrRes = $this->getArrayResult($varSql);
        $arrInputType = array('radio', 'image', 'checkbox', 'select');
        $arrRows = array();

        $arrInputType = array('radio', 'image', 'checkbox', 'select');
        $i = 0;
        foreach ($arrRes as $key => $val) {
            if (in_array($val['AttributeInputType'], $arrInputType)) {
                $arrRows[$i] = $val;
                $arrRows[$i]['options'] = $this->getAttrOptions($argpid, $val['pkAttributeID']);
                $i++;
            }
        }

        return $arrRows;
    }

    /**
     * function productToAttributeOptionsQty
     *
     * This function is used to display Product To Options.
     *
     * Database Tables used in this function are : tbl_product_option_inventory, tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function productToAttributeOptionsQty($argpid, $wid) {
        $varSql = "SELECT OptionIDs,OptionQuantity FROM " . TABLE_PRODUCT_OPTION_INVENTORY . " LEFT JOIN " . TABLE_PRODUCT . " ON fkProductID=pkProductID WHERE fkProductID = '" . $argpid . "' AND fkWholesalerID='" . $wid . "'";
        $arrRes = $this->getArrayResult($varSql);
        $arrRows = array();
        foreach ($arrRes as $key => $val) {
            $arrRows[$val['OptionIDs']] = $val['OptionQuantity'];
        }
        //pre($arrRows);
        return $arrRows;
    }

    /**
     * function getAttrOptions
     *
     * This function is used to display Product To Options.
     *
     * Database Tables used in this function are : tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function getAttrOptions($argpid, $argaid) {
        $varSql = "SELECT pkProductAttributeId,fkAttributeOptionId,OptionExtraPrice,OptionIsDefault,AttributeOptionValue FROM " . TABLE_PRODUCT_TO_OPTION . " WHERE  fkAttributeId = '" . $argaid . "' AND fkProductId = '" . $argpid . "' ";
        $arrRes = $this->getArrayResult($varSql);
        return $arrRes;
    }

    /**
     * function updateProductOptPrice
     *
     * This function is used to update product status.
     *
     * Database Tables used in this function are : tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objProduct->updateProductStatus($argPost)
     */
    function updateProductOptPrice($pid, $argPost) {
        global $objCore;
        $num = 1;

        foreach ($argPost['frmPrice'] as $key => $val) {
            $default = $argPost['default_' . $key];

            foreach ($val as $k => $v) {
                $def = ($default == $k) ? 1 : 0;

                $varWhr = "pkProductAttributeId = '" . $k . "'";

                $arrClms = array(
                    'OptionExtraPrice' => $v,
                    'OptionIsDefault' => $def
                );

                $varUpdate = $this->update(TABLE_PRODUCT_TO_OPTION, $arrClms, $varWhr);
                $num +=$varUpdate;
            }
        }
        $arrClmsUpdate = array(
            'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        $varWhrUpdate = "pkProductID = '" . $pid . "'";
        $this->update(TABLE_PRODUCT, $arrClmsUpdate, $varWhrUpdate);
        return $num;
    }

    /**
     * function updateProductOptInventory
     *
     * This function is used to update product status.
     *
     * Database Tables used in this function are : tbl_product_option_inventory, tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objProduct->updateProductStatus($argPost)
     */
    function updateProductOptInventory($pid, $argPost) {
        //pre($argPost);
        global $objCore;
        $num = 1;

        $varWhr = "fkProductID = '" . $pid . "'";

        $this->delete(TABLE_PRODUCT_OPTION_INVENTORY, $varWhr);
        $qty = 0;
        foreach ($argPost['frmOptIds'] as $key => $val) {
            $tempArr = explode(',', $val);
            sort($tempArr);

            $optIds = implode(',', $tempArr);

            $qty +=$argPost['frmQuantity'][$key];

            $arrClms = array(
                'fkProductID' => $pid,
                'OptionIDs' => $optIds,
                'OptionQuantity' => $argPost['frmQuantity'][$key]
            );
            $varUpdate = $this->insert(TABLE_PRODUCT_OPTION_INVENTORY, $arrClms);
            $num +=$varUpdate;
        }

        $arrClms = array(
            'Quantity' => $qty,
            'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );

        $varWhr = "pkProductID = '" . $pid . "'";
        $this->update(TABLE_PRODUCT, $arrClms, $varWhr);
        return $num;
    }

    /**
     * function updateProduct
     *
     * This function is used to update Product details.
     *
     * Database Tables used in this function are : tbl_product, tbl_special_product, tbl_product_image ,tbl_product_to_option
     *
     * @access public
     *
     * @parameters 2 array, array
     *
     * @return string
     */
    function updateProduct($arrPost, $arrFileName, $arrFileNameAttr, $wid, $productDiscountPercent) {

        $objCore = new Core();
        // $varDateStart = $objCore->defaultDateTime($arrPost['DateStart'], DATE_FORMAT_DB);
        //$varDateEnd = $objCore->defaultDateTime($arrPost['DateEnd'], DATE_FORMAT_DB);
        //$IsFeatured = (isset($arrPost['IsFeatured'])) ? '1' : '0';
        $frmShippingGateway = implode(',', $arrPost['frmShippingGateway']);
        $varProductImage = $arrPost['default'];

        $arrClms = array(
            'fkCategoryID' => $arrPost['fkCategoryID'],
            'fkShippingID' => $frmShippingGateway,
            'ProductName' => $arrPost['ProductName'],
            'ProductRefNo' => $arrPost['ProductRefNo'],
            'ProductImage' => $varProductImage,
            'ProductSliderImage' => $arrPost['ProductSliderImage'],
            'FinalPrice' => $arrPost['FinalPrice'],
            'WholesalePrice' => $arrPost['WholesalePrice'],
            'DiscountPrice' => $arrPost['DiscountPrice'],
            'DiscountFinalPrice' => $arrPost['DiscountFinalPrice'],
            'discountPercent' => $productDiscountPercent,
            'Quantity' => $arrPost['Quantity'],
            'QuantityAlert' => $arrPost['QuantityAlert'],
            'Weight' => $arrPost['Weight'],
            'WeightUnit' => $arrPost['WeightUnit'],
            'Length' => $arrPost['Length'],
            'Width' => $arrPost['Width'],
            'Height' => $arrPost['Height'],
            'DimensionUnit' => $arrPost['DimensionUnit'],
            'fkPackageId' => $arrPost['fkPackageId'],
            'ProductDescription' => $arrPost['ProductDescription'],
            'ProductTerms' => $arrPost['ProductTerms'],
            'YoutubeCode' => $arrPost['YoutubeCode'],
            // 'HtmlEditor' => $arrPost['HtmlEditor'],
            'MetaTitle' => $arrPost['frmMetaTitle'],
            'MetaKeywords' => $arrPost['frmMetaKeywords'],
            'MetaDescription' => $arrPost['frmMetaDescription'],
            'productdangerous' => $arrPost['dangerous'],
            'productfragile' => $arrPost['fragile'],
            'UpdatedBy' => 'wholesaler',
            'fkUpdatedID' => $_SESSION['sessUserInfo']['id'],
            'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );

        $varWhr = 'pkProductID = ' . $_POST['pid'];
        $this->update(TABLE_PRODUCT, $arrClms, $varWhr);

        $arrAddID = $_POST['pid'];
        if ($arrAddID > 0) {

            $this->delete(TABLE_SPECIAL_PRODUCT, "fkProductID='" . $arrAddID . "'");

            if (isset($arrPost['frmSpecialEvents'])) {
                $arrCols = array(
                    'fkProductID' => $arrAddID,
                    'fkCategoryID' => $arrPost['fkCategoryID'],
                    'fkWholesalerID' => $wid,
                    'fkFestivalID' => $arrPost['frmSpecialEvents'],
                    'SpecialPrice' => $arrPost['SpecialEventsPrice'],
                    'FinalSpecialPrice' => $arrPost['FinalSpecialEventsPrice'],
                    'DateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                );
                $this->insert(TABLE_SPECIAL_PRODUCT, $arrCols);
            }

            $this->delete(tbl_productmulcountry, "fkproduct_id='" . $arrAddID . "'");
            if (isset($arrPost['radio'])) {

                if (($arrPost['radio'] != 'gloabal') && ($arrPost['radio'] != 'local')) {
                    foreach ($arrPost['name'] as $name) {
                        $arrCols = array(
                            'fkproduct_id' => $arrAddID,
                            'country_id' => $name,
                            'producttype' => $arrPost['radio'],
                        );
                        $this->insert(tbl_productmulcountry, $arrCols);
                    }
                } else {
                    if ($arrPost['radio'] == 'local') {
                        $arrCols = array(
                            'fkproduct_id' => $arrAddID,
                            'country_id' => $arrPost['CompanyCountry'],
                            'producttype' => $arrPost['radio'],
                        );
                    } else {
                        $arrCols = array(
                            'fkproduct_id' => $arrAddID,
                            'producttype' => $arrPost['radio'],
                        );
                    }

                    $this->insert(tbl_productmulcountry, $arrCols);
                }
            }

            //Insert Images for products
            if (isset($arrFileName)) {
                foreach ($arrFileName as $valueImg) {
                    $arrClmsImg = array(
                        'fkProductID' => $arrAddID,
                        'ImageName' => $valueImg,
                        'ImageDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                    );

                    $this->insert(TABLE_PRODUCT_IMAGE, $arrClmsImg);
                }
            }

            // Delete attribute for this products
            $varWhereCondition = " fkProductId = '" . $arrAddID . "'";
            $this->delete(TABLE_PRODUCT_TO_OPTION, $varWhereCondition);

            // Add attribute for this products
            if (isset($arrPost['frmAttribute'])) {
                foreach ($arrPost['frmAttribute'] as $keyAttr => $valueAttr) {
                    foreach ($valueAttr as $keyOpt => $valueOpt) {
                        $imgNm = isset($arrFileNameAttr[$valueOpt]['imgnm']) ? $arrFileNameAttr[$valueOpt]['imgnm'] : '';
                        $isImgUploaded = isset($arrFileNameAttr[$valueOpt]['isImgUploaded']) ? $arrFileNameAttr[$valueOpt]['isImgUploaded'] : 0;
                        $varOptionCaption = $arrPost['frmOptCaption'][$valueOpt];
                        $OptionExtraPrice = (float) $arrPost['frmOptExtraPrice'][$valueOpt];
                        $defaultPrice = ($OptionExtraPrice > 0) ? 0 : 1;


                        $arrClmsOpt = array(
                            'fkProductId' => $arrAddID,
                            'fkAttributeId' => $keyAttr,
                            'fkAttributeOptionId' => $valueOpt,
                            'OptionExtraPrice' => $OptionExtraPrice,
                            'OptionIsDefault' => $defaultPrice,
                            'AttributeOptionValue' => $varOptionCaption,
                            'AttributeOptionImage' => $imgNm,
                            'IsImgUploaded' => $isImgUploaded
                        );

                        $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsOpt);
                    }
                }
            }

            if (isset($arrPost['frmAttributeText'])) {
                foreach ($arrPost['frmAttributeText'] as $keyTextOpt => $valuetextOpt) {
                    $atrOpt = explode('-', $keyTextOpt);

                    $arrClmsTextOpt = array(
                        'fkProductId' => $arrAddID,
                        'fkAttributeId' => $atrOpt[0],
                        'fkAttributeOptionId' => $atrOpt[1],
                        'AttributeOptionValue' => $valuetextOpt
                    );

                    $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextOpt);
                }
            }
            if (isset($arrPost['frmAttributeTextArea'])) {

                foreach ($arrPost['frmAttributeTextArea'] as $keyTextAreaOpt => $valuetextAreaOpt) {
                    $atrOpt = explode('-', $keyTextAreaOpt);

                    $arrClmsTextAreaOpt = array(
                        'fkProductId' => $arrAddID,
                        'fkAttributeId' => $atrOpt[0],
                        'fkAttributeOptionId' => $atrOpt[1],
                        'AttributeOptionValue' => $valuetextAreaOpt,
                    );
                    $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextAreaOpt);
                }
            }
        }
        return 1;
    }

    /**
     * function addProduct
     *
     * This function is used to add Products.
     *
     * Database Tables used in this function are : tbl_product, tbl_special_product, tbl_product_image ,tbl_product_to_option
     *
     * @access public
     *
     * @parameters 2 array, array
     *
     * @return string
     */
    function addProduct($arrPost, $arrFileName, $arrFileNameAttr, $wid, $productDiscountPercent) {
        // pre("inthis");
        // pre($arrPost);
        $objCore = new Core();
        //$varDateStart = $objCore->defaultDateTime($arrPost['DateStart'], DATE_FORMAT_DB);
        //$varDateEnd = $objCore->defaultDateTime($arrPost['DateEnd'], DATE_FORMAT_DB);
        //$IsFeatured = (isset($arrPost['IsFeatured'])) ? '1' : '0';
        $varWhereNum = "and ProductRefNo = '" . addslashes($arrPost['ProductRefNo']) . "' ";
        $varRefNum = $this->getNumRows(TABLE_PRODUCT, 'ProductRefNo', $varWhereNum);
        $frmShippingGateway = implode(',', $arrPost['frmShippingGateway']);
        $varProductImage = $arrPost['default'];

        if ($varRefNum == 0) {
            $arrClms = array(
                'fkCategoryID' => $arrPost['fkCategoryID'],
                'ProductRefNo' => $arrPost['ProductRefNo'],
                'fkWholesalerID' => $arrPost['fkWholesalerID'],
                'fkShippingID' => $frmShippingGateway,
                'ProductName' => $arrPost['ProductName'],
                'ProductImage' => $varProductImage,
                'ProductSliderImage' => $arrPost['ProductSliderImage'],
                'FinalPrice' => $arrPost['FinalPrice'],
                'WholesalePrice' => $arrPost['WholesalePrice'],
                'DiscountPrice' => $arrPost['DiscountPrice'],
                'DiscountFinalPrice' => $arrPost['DiscountFinalPrice'],
                'discountPercent' => $productDiscountPercent,
                'Quantity' => $arrPost['Quantity'],
                'QuantityAlert' => $arrPost['QuantityAlert'],
                'Weight' => $arrPost['Weight'],
                'WeightUnit' => $arrPost['WeightUnit'],
                'Length' => $arrPost['Length'],
                'Width' => $arrPost['Width'],
                'Height' => $arrPost['Height'],
                'DimensionUnit' => $arrPost['DimensionUnit'],
                'fkPackageId' => $arrPost['fkPackageId'],
                'ProductDescription' => $arrPost['ProductDescription'],
                'ProductTerms' => $arrPost['ProductTerms'],
                'YoutubeCode' => $arrPost['YoutubeCode'],
                // 'HtmlEditor' => $arrPost['HtmlEditor'],
                'MetaTitle' => $arrPost['frmMetaTitle'],
                'MetaKeywords' => $arrPost['frmMetaKeywords'],
                'MetaDescription' => $arrPost['frmMetaDescription'],
                'productdangerous' => $arrPost['dangerous'],
                'productfragile' => $arrPost['fragile'],
                'CreatedBy' => 'wholesaler',
                'fkCreatedID' => $_SESSION['sessUserInfo']['id'],
                'LastViewed' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                'ProductDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $arrAddID = $this->insert(TABLE_PRODUCT, $arrClms);


            if ($arrAddID > 0) {

                if (isset($arrPost['frmSpecialEvents'])) {
                    $arrCols = array(
                        'fkProductID' => $arrAddID,
                        'fkCategoryID' => $arrPost['fkCategoryID'],
                        'fkWholesalerID' => $wid,
                        'fkFestivalID' => $arrPost['frmSpecialEvents'],
                        'SpecialPrice' => $arrPost['SpecialEventsPrice'],
                        'FinalSpecialPrice' => $arrPost['FinalSpecialEventsPrice'],
                        'DateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                    );
                    $this->insert(TABLE_SPECIAL_PRODUCT, $arrCols);
                }

                if (isset($arrPost['radio'])) {

                    if (($arrPost['radio'] != 'gloabal') && ($arrPost['radio'] != 'local')) {
                        foreach ($arrPost['name'] as $name) {
                            $arrCols = array(
                                'fkproduct_id' => $arrAddID,
                                'country_id' => $name,
                                'producttype' => $arrPost['radio'],
                            );
                            $this->insert(tbl_productmulcountry, $arrCols);
                        }
                    } else {
                        if ($arrPost['radio'] == 'local') {
                            $arrCols = array(
                                'fkproduct_id' => $arrAddID,
                                'country_id' => $arrPost['CompanyCountry'],
                                'producttype' => $arrPost['radio'],
                            );
                        } else {
                            $arrCols = array(
                                'fkproduct_id' => $arrAddID,
                                'producttype' => $arrPost['radio'],
                            );
                        }

                        $this->insert(tbl_productmulcountry, $arrCols);
                    }
                }



                //Insert Images for products
                if (isset($arrFileName)) {
                    foreach ($arrFileName as $valueImg) {
                        $arrClmsImg = array(
                            'fkProductID' => $arrAddID,
                            'ImageName' => $valueImg,
                            'ImageDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                        );
                        $this->insert(TABLE_PRODUCT_IMAGE, $arrClmsImg);
                    }
                }


                // Add attribute for this products
                if (isset($arrPost['frmAttribute'])) {
                    foreach ($arrPost['frmAttribute'] as $keyAttr => $valueAttr) {
                        foreach ($valueAttr as $keyOpt => $valueOpt) {
                            $imgNm = isset($arrFileNameAttr[$valueOpt]['imgnm']) ? $arrFileNameAttr[$valueOpt]['imgnm'] : '';
                            $isImgUploaded = isset($arrFileNameAttr[$valueOpt]['isImgUploaded']) ? $arrFileNameAttr[$valueOpt]['isImgUploaded'] : 0;
                            $varOptionCaption = $arrPost['frmOptCaption'][$valueOpt];

                            $arrClmsOpt = array(
                                'fkProductId' => $arrAddID,
                                'fkAttributeId' => $keyAttr,
                                'fkAttributeOptionId' => $valueOpt,
                                'AttributeOptionValue' => $varOptionCaption,
                                'AttributeOptionImage' => $imgNm,
                                'IsImgUploaded' => $isImgUploaded
                            );

                            $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsOpt);
                        }
                    }
                }

                if (isset($arrPost['frmAttributeText'])) {
                    foreach ($arrPost['frmAttributeText'] as $keyTextOpt => $valuetextOpt) {
                        $atrOpt = explode('-', $keyTextOpt);

                        $arrClmsTextOpt = array(
                            'fkProductId' => $arrAddID,
                            'fkAttributeId' => $atrOpt[0],
                            'fkAttributeOptionId' => $atrOpt[1],
                            'AttributeOptionValue' => $valuetextOpt
                        );

                        $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextOpt);
                    }
                }
                if (isset($arrPost['frmAttributeTextArea'])) {

                    foreach ($arrPost['frmAttributeTextArea'] as $keyTextAreaOpt => $valuetextAreaOpt) {
                        $atrOpt = explode('-', $keyTextAreaOpt);

                        $arrClmsTextAreaOpt = array(
                            'fkProductId' => $arrAddID,
                            'fkAttributeId' => $atrOpt[0],
                            'fkAttributeOptionId' => $atrOpt[1],
                            'AttributeOptionValue' => $valuetextAreaOpt,
                        );
                        $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextAreaOpt);
                    }
                }
            }
            global $oCache;
            //Check memcache is enabled or not
            if ($oCache->bEnabled) {
                //Flush memcache data
                $oCache->flushData();
            }
            return $arrAddID;
        } else {
            return 0;
        }
    }

    /**
     * function addMultipleProduct
     *
     * This function is used to add multiple Products.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image ,tbl_product_to_option
     *
     * @access public
     *
     * @parameters 2 array, array
     *
     * @return string
     */
    function addMultipleProduct($arrPost, $arrFileName, $arrFileNameAttr) {
        $objCore = new Core();
        //   pre($arrPost);
        $i = 0;
        foreach ($arrPost['frmProductName'] as $key => $value) {

            $varWhereNum = "and ProductRefNo = '" . addslashes($arrPost['frmProductRefNo'][$key]) . "' ";
            $varRefNum = $this->getNumRows(TABLE_PRODUCT, 'ProductRefNo', $varWhereNum);
            $frmShippingGateway = implode(',', $arrPost['frmShippingGateway'][$key]);
            $productDiscountPercent = $objCore->getProductDiscount(trim($arrPost['frmProductPrice'][$key]), trim($arrPost['frmDiscountFinalPrice'][$key]), trim($arrPost['FinalSpecialEventsPrice'][$key]));
            if ($varRefNum == 0) {
                $i++;

                $varProductImage = $arrPost['default'][$i];

                $arrClms = array(
                    'fkCategoryID' => $arrPost['frmfkCategoryID'][$key],
                    'ProductRefNo' => $arrPost['frmProductRefNo'][$key],
                    'fkWholesalerID' => $arrPost['frmfkWholesalerID'],
                    'fkShippingID' => $frmShippingGateway,
                    'ProductName' => $arrPost['frmProductName'][$key],
                    'ProductImage' => $varProductImage,
                    'WholesalePrice' => $arrPost['frmWholesalePrice'][$key],
                    'DiscountPrice' => $arrPost['frmDiscountPrice'][$key],
                    'FinalPrice' => $arrPost['frmProductPrice'][$key],
                    'DiscountFinalPrice' => $arrPost['frmDiscountFinalPrice'][$key],
                    'discountPercent' => $productDiscountPercent,
                    'Quantity' => $arrPost['frmQuantity'][$key],
                    'QuantityAlert' => $arrPost['frmQuantityAlert'][$key],
                    'fkPackageId' => $arrPost['frmfkPackageId'][$key],
                    'WeightUnit' => $arrPost['frmWeightUnit'][$key],
                    'Weight' => $arrPost['frmWeight'][$key],
                    'DimensionUnit' => $arrPost['frmDimensionUnit'][$key],
                    'Length' => $arrPost['frmLength'][$key],
                    'Width' => $arrPost['frmWidth'][$key],
                    'Height' => $arrPost['frmHeight'][$key],
                    'ProductDescription' => $arrPost['frmProductDescription'][$key],
                    'ProductTerms' => $arrPost['frmProductTerms'][$key],
                    'YoutubeCode' => $arrPost['frmYoutubeCode'][$key],
                    'HtmlEditor' => $arrPost['frmHtmlEditor'][$key],
                    'MetaTitle' => $arrPost['frmMetaTitle'][$key],
                    'MetaKeywords' => $arrPost['frmMetaKeywords'][$key],
                    'MetaDescription' => $arrPost['frmMetaDescription'][$key],
                    'CreatedBy' => 'wholesaler',
                    'fkCreatedID' => $_SESSION['sessUserInfo']['id'],
                    'LastViewed' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                    'ProductDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                    'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                );
                $arrAddID = $this->insert(TABLE_PRODUCT, $arrClms);

                if ($arrAddID > 0) {
                    //Add Images for products
                    if (isset($arrFileName)) {
                        foreach ($arrFileName[$i] as $kimg => $vimg) {

                            $arrClmsImg = array(
                                'fkProductID' => $arrAddID,
                                'ImageName' => $vimg,
                                'ImageDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                            );
                            if ($vimg <> '') {
                                $this->insert(TABLE_PRODUCT_IMAGE, $arrClmsImg);
                            }
                        }
                    }


                    // Add attribute for this products
                    if (isset($arrPost['frmAttribute'])) {
                        foreach ($arrPost['frmAttribute'][$key] as $keyAttr => $valueAttr) {
                            foreach ($valueAttr as $keyOpt => $valueOpt) {
                                $imgNm = isset($arrFileNameAttr[$key][$valueOpt]['imgnm']) ? $arrFileNameAttr[$key][$valueOpt]['imgnm'] : '';
                                $isImgUploaded = isset($arrFileNameAttr[$key][$valueOpt]['isImgUploaded']) ? $arrFileNameAttr[$key][$valueOpt]['isImgUploaded'] : 0;
                                $varOptionCaption = $arrPost['frmOptCaption'][$key][$valueOpt];

                                $arrClmsOpt = array(
                                    'fkProductId' => $arrAddID,
                                    'fkAttributeId' => $keyAttr,
                                    'fkAttributeOptionId' => $valueOpt,
                                    'AttributeOptionValue' => $varOptionCaption,
                                    'AttributeOptionImage' => $imgNm,
                                    'IsImgUploaded' => $isImgUploaded
                                );

                                $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsOpt);
                            }
                        }
                    }

                    if (isset($arrPost['frmAttributeText'][$key])) {
                        foreach ($arrPost['frmAttributeText'][$key] as $keyTextOpt => $valuetextOpt) {
                            $atrOpt = explode('-', $keyTextOpt);

                            $arrClmsTextOpt = array(
                                'fkProductId' => $arrAddID,
                                'fkAttributeId' => $atrOpt[0],
                                'fkAttributeOptionId' => $atrOpt[1],
                                'AttributeOptionValue' => $valuetextOpt
                            );

                            $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextOpt);
                        }
                    }
                    if (isset($arrPost['frmAttributeTextArea'][$key])) {

                        foreach ($arrPost['frmAttributeTextArea'][$key] as $keyTextAreaOpt => $valuetextAreaOpt) {
                            $atrOpt = explode('-', $keyTextAreaOpt);

                            $arrClmsTextAreaOpt = array(
                                'fkProductId' => $arrAddID,
                                'fkAttributeId' => $atrOpt[0],
                                'fkAttributeOptionId' => $atrOpt[1],
                                'AttributeOptionValue' => $valuetextAreaOpt,
                            );
                            $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextAreaOpt);
                        }
                    }
                }
            }
        }
        return $i;
    }

    /**
     * function wholesalerPackageList
     *
     * This function is used to retrive package details.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
    function wholesalerPackageList($wid, $limit) { //echo '<pre>';print_r($_POST);die;
        $objCore = new Core();
        $oderColumn = $_POST['sort_column'] ? $_POST['sort_column'] : 'pkPackageId';
        $oderDir = $_POST['sort_order'] ? $_POST['sort_order'] : 'DESC';
        $varOrderBy = 'ORDER BY ' . $oderColumn . ' ' . $oderDir;
        if ($_POST['PackageName'] && $_POST['PackageName'] != '') {
            $varID = " AND PackageName like '%" . $objCore->getFormatValue($_POST['PackageName']) . "%'";
        }
        if ($_POST['ProductName'] && $_POST['ProductName'] != '') {
            $varID.= " AND ProductName like '%" . $objCore->getFormatValue($_POST['ProductName']) . "%'";
        }

        $varID = $varID != '' ? $varID . " AND tp.fkWholesalerID ='" . $wid . "'" : " AND tp.fkWholesalerID ='" . $wid . "'";
        $varLimit = ($limit <> '') ? ' LIMIT ' . $limit : '';

        //SELECT pkPackageId,PackageName,group_concat(ProductName) as ProductName FROM tbl_package inner join tbl_product_to_package on  left join tbl_product on  group by pkPackageId

        $varSql = "SELECT pkPackageId,PackageName,PackagePrice,PackageDateAdded,group_concat(ProductName) as ProductName FROM " . TABLE_PACKAGE . " tp INNER JOIN " . TABLE_PRODUCT_TO_PACKAGE . " ON pkPackageId=fkPackageId LEFT JOIN " . TABLE_PRODUCT . "  ON  fkProductId=pkProductID WHERE 1 $varID group by pkPackageId " . $varOrderBy . $varLimit;
        $arrRes = $this->getArrayResult($varSql);
        return $arrRes;
    }

    /**
     * function wholesalerDeletePackage
     *
     * This function is used to delete packages.
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function wholesalerDeletePackage($pkid, $wid) {
        /* To remove deleted package id from that products by Krishna Gupta (04-11-2015) starts */
        $productsIncludedInPackage = $this->getArrayResult("select fkProductId from tbl_product_to_package where fkPackageId=" . $pkid . "");
        foreach ($productsIncludedInPackage as $val) {
            $data = $this->getArrayResult("select fkPackageId from tbl_product where pkProductID=" . $val['fkProductId'] . "");
            $packages = explode(',', $data[0]['fkPackageId']);
            foreach ($packages as $package) {
                if ($package != $pkid) {
                    $updatedPackageId .= $package . ',';
                }
            }
            $updatedPackage = rtrim($updatedPackageId, ',');
            $query = mysql_query("Update tbl_product set fkPackageId=" . "'" . $updatedPackage . "'" . " where pkProductID=" . $val['fkProductId'] . "");
        }
        /* To remove deleted package id from that products by Krishna Gupta (04-11-2015) ends */

        $varWhereSdelete = " pkPackageId  = '" . $pkid . "' AND fkWholesalerID='" . $wid . "'";
        $varAffected1 = $this->delete(TABLE_PACKAGE, $varWhereSdelete);
        $this->insert(TABLE_WHOLESALER_PACKAGE_DELETE, array('fkPackageId' => $pkid, 'fkWholesalerID' => $wid));



        if ($varAffected1 > 0) {
            $varWhereSdelete = " fkPackageId  = '" . $pkid . "'";
            $varAffected2 = $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWhereSdelete);
            $varWhereAttrOPtion = "packageId = '" . $pkid . "'";
            $this->delete(TABLE_PACKAGE_PRODUCT_ATTRIBUTE_OPTION, $varWhereAttrOPtion);
        }
        $varAffected = $varAffected1 + $varAffected2;
        global $oCache;
        //Check memcache is enabled or not
        if ($oCache->bEnabled) {
            //Flush memcache data
            $oCache->flushData();
        }
        return $varAffected;
    }

    /**
     * function wholesalerPackageProductList
     *
     * This function is used to retrive products for package.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function wholesalerPackageProductList($pkid) {
        $varSql = "SELECT pkProductID,fkCategoryID,FinalPrice FROM " . TABLE_PRODUCT . " WHERE pkProductID IN (SELECT fkProductId FROM " . TABLE_PRODUCT_TO_PACKAGE . " WHERE fkPackageId='" . $pkid . "') order by pkProductID ASC";
        $arrRes = $this->getArrayResult($varSql);
        return $arrRes;
    }

    function packageToProductSelected($pkid) {
        $varQuery = "SELECT ProductName,fkCategoryID,ProductRefNo,pkProductID,pkPackageID,ProductDescription,PackageName,DiscountFinalPrice,FinalPrice,PackagePrice,ProductImage as ImageName, PackageImage,GROUP_CONCAT(AttributeLabel) as AttributeLabel,GROUP_CONCAT(AttributeOptionValue) as OptionTitle,GROUP_CONCAT(optionColorCode) as optionColorCode,GROUP_CONCAT(AttributeOptionImage) as OptionImage,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice,GROUP_CONCAT(proOp.fkAttributeId) AS fkAttributeId,GROUP_CONCAT(attrbuteOptionId) AS attrbuteOptionId FROM tbl_package inner join tbl_product_to_package pp on pkPackageId=pp.fkPackageId left join tbl_package_product_attribute_option attrOp on (productId=fkProductId and packageId=pp.fkPackageId) left join tbl_attribute on attributeId=pkAttributeID left join tbl_attribute_option on attrbuteOptionId=pkOptionID left join tbl_product_to_option proOp on (productId=proOp.fkProductId and attributeId=proOp.fkAttributeId and attrbuteOptionId=proOp.fkAttributeOptionId) inner join tbl_product tp on pp.fkProductId = pkProductID where pkPackageId='" . $pkid . "' AND PackageStatus = '1' group by pkProductID order by pkProductID ASC";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function wholesalerPackageDetail
     *
     * This function is used to retrive package details.
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function wholesalerPackageDetail($pkid, $wid) {
        $varSql = "SELECT pkPackageId,PackageName,PackagePrice,PackageImage,PackageDateAdded FROM " . TABLE_PACKAGE . " WHERE pkPackageId ='" . $pkid . "' AND fkWholesalerID ='" . $wid . "'";
        $arrRes = $this->getArrayResult($varSql);
        return $arrRes;
    }

    /**
     * function CategoryProductList
     *
     * This function is used to retrive products.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function CategoryProductList($cid) {
        $varSql = "SELECT pkProductID,ProductName FROM " . TABLE_PRODUCT . " WHERE fkCategoryID ={$cid}";
        $arrRes = $this->getArrayResult($varSql);
        return $arrRes;
    }

    /**
     * function updatePackage
     *
     * This function is used to update Package .
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 array()
     *
     * @return string
     */
    function updatePackage($arrPost) {


        /**
         * Update package id for already existing product for that perticular package
         * 
         * @author : Krishna Gupta
         * 
         * @Created : 22-10-2015
         * 
         * @Modified : 05-11-2015
         */
        $col = 'fkPackageId';
        $checkExistacyOfPackage = mysql_query("select pkProductID, fkPackageId from tbl_product where find_in_set (" . $arrPost['pkid'] . ' , ' . $col . ")");

        $updatedPackages = '';
        while ($result = mysql_fetch_assoc($checkExistacyOfPackage)) {
            $alreadyExistingProducts[] = $result['pkProductID'];

            /* Condition if product is existing in updated package then no need to update anything. */
            if (in_array($result['pkProductID'], $arrPost['frmProductId'])) {
                $query = mysql_query("Update tbl_product set fkPackageId = " . "'" . $updatedPackage . "'" . " where pkProductID=" . $result['pkProductID'] . "");
            }
            /* Condition if product is not existing ( removed after updation ) in updated package */ else {
                /* Make an array of packages for that particular removed product from package */
                $package = explode(',', $result['fkPackageId']);
                foreach ($package as $packages) {
                    $updatedPackages = '';
                    /* If package id is not equals to updated package. */
                    if ($packages == $arrPost['pkid']) {
                        $updatedPackages .= $packages . ',';
                    }
                }
                /* echo '<pre>'; print_r($arrPost);
                  echo $updatedPackages.'<br><br>';
                  pre($packages); */
                /* Update data into db */
                if (isset($updatedPackages) && !empty($updatedPackages)) {
                    if ($updatedPackages === '') {
                        $updatedPackage = '';
                        $query = mysql_query("Update tbl_product set fkPackageId = " . "'" . $updatedPackage . "'" . " where pkProductID=" . $result['pkProductID'] . "");
                    } else {
                        $updatedPackage = rtrim($updatedPackages, ',');
                        $query = mysql_query("Update tbl_product set fkPackageId = " . "'" . $updatedPackage . "'" . " where pkProductID=" . $result['pkProductID'] . "");
                    }
                }
            }
        }


        foreach ($arrPost['frmProductId'] as $newproducts) {
            /* Condition if updated package product's are already existing ( not changed ) then no need to update anything. */
            if (in_array($newproducts, $alreadyExistingProducts)) {
                //$query=mysql_query("Update tbl_product set fkPackageId = " ."'". $updatedPackage ."'". " where pkProductID=".$newproducts."");
            }
            /* If some new products are added or replaced in package then update values. */ else {
                $newProductsPackage = mysql_query("select fkPackageId from tbl_product where pkProductID = " . $newproducts . "");
                $result = mysql_fetch_assoc($newProductsPackage);
                $updatedPackageIds = $result['fkPackageId'] . ',' . $arrPost['pkid'];
                $query = mysql_query("Update tbl_product set fkPackageId = " . "'" . $updatedPackageIds . "'" . " where pkProductID=" . $newproducts . "");
            }
        }
        /* Ends */


        global $objCore;
        $varWhr = 'pkPackageId = ' . $arrPost['pkid'];

        $objClassCommon = new ClassCommon();
        $varPackageACPrice = $objClassCommon->getAcCostForPackage($arrPost['frmOfferPrice']);

        $arrClms = array(
            'PackageName' => $arrPost['frmPackageName'],
            'PackageACPrice' => $varPackageACPrice,
            'PackagePrice' => $arrPost['frmOfferPrice'],
            'PackageImage' => $arrPost['frmPackageImage'],
            'imgSync' => '0',
            'packageDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );

        $arrUpdateID = $this->update(TABLE_PACKAGE, $arrClms, $varWhr);
        $varWheresD = "fkPackageId = " . $arrPost['pkid'] . " ";
        $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWheresD);

        $varWh = "packageId = " . $arrPost['pkid'] . " ";
        $this->delete(TABLE_PACKAGE_PRODUCT_ATTRIBUTE_OPTION, $varWh);
        $cu = 1;
        foreach ($arrPost['frmProductId'] as $val) {
            if ($val) {
                $arrClmsPro = array(
                    'fkPackageId' => $arrPost['pkid'],
                    'fkProductId' => $val
                );

                /**
                 * This query is used update package id for mantioned products in package in product table.
                 *
                 * @author : Krishna Gupta
                 *
                 * @Created : 22-10-2015
                 */
                // $checkExistacyOfPackage = mysql_query("select pkProductID from tbl_product where fkPackageId = " . "");

                $includedInAnyPackage = $this->getArrayResult("select fkPackageId from tbl_product where pkProductID=" . $arrClmsPro['fkProductId'] . "");

                //echo '<pre>'; print_r($includedInAnyPackage); die;
                if ($includedInAnyPackage[0]['fkPackageId'] == 0) {

                    $query = mysql_query("Update tbl_product set fkPackageId=" . $arrClmsPro['fkPackageId'] . " where pkProductID=" . $arrClmsPro['fkProductId'] . "");
                } else {
                    $packageId = $includedInAnyPackage[0]['fkPackageId'] . ',' . $arrClmsPro['fkPackageId'];
                    $query = mysql_query("Update tbl_product set fkPackageId=" . "'" . $packageId . "'" . " where pkProductID=" . $arrClmsPro['fkProductId'] . "");
                }


                //$query=mysql_query("Update tbl_product set fkPackageId=".$arrClmsPro['fkPackageId']." where pkProductID=".$arrClmsPro['fkProductId']."");
                /* Ends */

                $this->insert(TABLE_PRODUCT_TO_PACKAGE, $arrClmsPro);
                $frmAttribute = count($_POST['pattribute_' . $cu]);
                // Add product wise attribute with attribute option
                if ($frmAttribute > 0) {
                    foreach ($_POST['pattribute_' . $cu] as $key => $valOption) {
                        $getAttr = explode("_", $key);
                        $getAttr = $getAttr[0];
                        $getAttrOptionId = $_POST['frmAttribute_' . $key];
                        $arrClmsProPack = array(
                            'packageId' => $arrPost['pkid'],
                            'productId' => $val,
                            'attributeId' => $getAttr,
                            'attrbuteOptionId' => $getAttrOptionId
                        );
                        $this->insert(TABLE_PACKAGE_PRODUCT_ATTRIBUTE_OPTION, $arrClmsProPack);
                    }
                }
            }
            $cu++;
        }
        global $oCache;
        //Check memcache is enabled or not
        if ($oCache->bEnabled) {
            //Flush memcache data
            $oCache->flushData();
        }
        return 1;
    }

    public function customerPasswordChange() {
        // echo "hii"; die;
        // print_r($_POST);die;
        $objCore = new Core();
        $objCustomer = new Wholesaler();
        // echo "there";die;
        if (isset($_POST['frmHidenWholesalerPasswordEdit'])) {   // Editing images record
            if ($_POST['frmNewWholesalerPassword'] == $_POST['frmConfirmNewWholesalerPassword']) {
                //  echo "here";die;
                $objCore->setSuccessMsg(FRONT_END_PASSWORD_SUCC_CHANGE);
                // $objCustomer->changeCustomerPassword($_POST);
                $objCustomer->changeWholesalerResetPassword($_POST);
                header('location:dashboard_wholesaler_account.php');
                die;
            } else {
                // echo "heres";die;
                $objCore->setErrorMsg(FRONT_END_INVALID_CURENT_PASSWORD);
                //header('location:edit_my_password.php?type=edit');
                header('location:edit_my_password_wholesaler.php');
                die;
            }
        } else if (isset($_POST['frmHidenCustomerPasswordEdit']) && $_POST['frmHidenCustomerPasswordEdit'] == 'Cancel') {
            $objCore->setSuccessMsg("Account update successfully.");
            header('location:dashboard_wholesaler_account.php');
            die;
        }
    }

    /**
     * function addPackage
     *
     * This function is used for add Package .
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 array()
     *
     * @return string
     */
    function addPackage($arrPost) {
        global $objCore;
        $objClassCommon = new ClassCommon();
        $varPackageACPrice = $objClassCommon->getAcCostForPackage($arrPost['frmOfferPrice']);

        $arrClms = array(
            'fkWholesalerID' => $arrPost['frmWholesalerId'],
            'PackageName' => $arrPost['frmPackageName'],
            'PackageACPrice' => $varPackageACPrice,
            'PackagePrice' => $arrPost['frmOfferPrice'],
            'PackageImage' => $arrPost['frmPackageImage'],
            'PackageDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_PACKAGE, $arrClms);
        if ($arrAddID > 0) {
            $cu = 1;

            foreach ($arrPost['frmProductId'] as $val) {
                if ($val) {
                    $arrClmsPro = array(
                        'fkPackageId' => $arrAddID,
                        'fkProductId' => $val
                    );

                    //$query = mysql_query( " Update tbl_product set fkPackageId = " . $arrClmsPro['fkPackageId']. " where pkProductID = " . $arrClmsPro['fkProductId'] );

                    /**
                     * This query is used update package id for mantioned products in package in product table.
                     * 
                     * @author : Krishna Gupta
                     * 
                     * @Created : 22-10-2015
                     * 
                     * @Modified : 04-11-2015
                     */
                    $includedInAnyPackage = $this->getArrayResult("select fkPackageId from tbl_product where pkProductID=" . $arrClmsPro['fkProductId'] . "");
                    //echo $arrClmsPro['fkProductId'].'<br>'; print_r($includedInAnyPackage); die;
                    if ($includedInAnyPackage[0]['fkPackageId'] == 0) {

                        $query = mysql_query("Update tbl_product set fkPackageId=" . $arrClmsPro['fkPackageId'] . " where pkProductID=" . $arrClmsPro['fkProductId'] . "");
                    } else {
                        $packageId = $includedInAnyPackage[0]['fkPackageId'] . ',' . $arrClmsPro['fkPackageId'];
                        $query = mysql_query("Update tbl_product set fkPackageId=" . "'" . $packageId . "'" . " where pkProductID=" . $arrClmsPro['fkProductId'] . "");
                    }
                    /* Ends */

                    $this->insert(TABLE_PRODUCT_TO_PACKAGE, $arrClmsPro);
                    $frmAttribute = count($_POST['pattribute_' . $cu]);
                    // Add product wise attribute with attribute option
                    if ($frmAttribute > 0) {
                        foreach ($_POST['pattribute_' . $cu] as $key => $valOption) {
                            $getAttr = explode("_", $key);
                            $getAttr = $getAttr[0];
                            $getAttrOptionId = $_POST['frmAttribute_' . $key];
                            $arrClmsProPack = array(
                                'packageId' => $arrAddID,
                                'productId' => $val,
                                'attributeId' => $getAttr,
                                'attrbuteOptionId' => $getAttrOptionId
                            );
                            $this->insert(TABLE_PACKAGE_PRODUCT_ATTRIBUTE_OPTION, $arrClmsProPack);
                        }
                    }
                }
                $cu++;
            }
        }
        global $oCache;
        //Check memcache is enabled or not
        if ($oCache->bEnabled) {
            //Flush memcache data
            $oCache->flushData();
        }
        return $arrAddID;
    }

    /**
     * function getWholesalerInbox
     *
     * This function is used to retrive support inbox message.
     *
     * Database Tables used in this function are : tbl_support, tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getWholesalerInbox($wid, $limit) {

        $varID = "ToUserType='wholesaler' AND fkToUserID ='" . $wid . "' AND DeletedBy!=fkToUserID";
        $varOrderBy = 'SupportDateAdded DESC ';
        $arrClms = array('fkParentID', 'Subject', 'Message', 'fkFromUserID', 'SupportType', 'pkSupportID', 'FromUserType', 'IsRead', 'SupportDateAdded', 'CustomerFirstName as FromName');
        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID ";
        $arrRes = $this->select($varTable, $arrClms, $varID, $varOrderBy, $limit);

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getUserName
     *
     * This function is used to retrive user details for inbox message.
     *
     * Database Tables used in this function are : tbl_admin, tbl_customer
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
    function getUserName($uid, $utype) {
        if ($utype == 'admin') {
            $varID = 'pkAdminID =' . $uid;
            $arrClms = array(
                'AdminUserName as name'
            );
            $varTable = TABLE_ADMIN;
            $arrRes = $this->select($varTable, $arrClms, $varID);
        } elseif ($utype == 'customer') {
            $varID = 'pkCustomerID =' . $uid;
            $arrClms = array(
                'CustomerFirstName as name'
            );
            $varTable = TABLE_CUSTOMER;
            $arrRes = $this->select($varTable, $arrClms, $varID);
        }

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
    function givMessageRead($mgsid, $wid) {

        $varID = "pkSupportID ='" . $mgsid . "' AND ToUserType = 'wholesaler' AND fkToUserID ='" . $wid . "'";
        $varTable = TABLE_SUPPORT;
        $varArrUpdate = array('IsRead' => '1');

        $VarRst = $this->update($varTable, $varArrUpdate, $varID);

        return $VarRst;
    }

    /**
     * function getMessageDetail
     *
     * This function is used to retrive message details.
     *
     * Database Tables used in this function are : tbl_support, tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRow
     */
    function getMessageDetail($mgsid, $wid) {

        $varID = "pkSupportID ='" . $mgsid . "' AND ToUserType = 'wholesaler' AND fkToUserID ='" . $wid . "'";
        $arrClms = array(
            'fkParentID', 'Subject', 'Message', 'fkFromUserID', 'SupportDateAdded', 'pkSupportID', 'FromUserType', 'ToUserType', 'SupportType', 'pkSupportID', 'CustomerFirstName', 'CustomerLastName',
        );
        $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID ";
        $arrRow = $this->select($varTable, $arrClms, $varID);

        //pre($arrRow);die;
        if ($arrRow[0]['fkParentID'] > 0) {
            $varWhere = " (fkParentID = " . $arrRow[0]['fkParentID'] . " OR pkSupportID =" . $arrRow[0]['fkParentID'] . ") AND pkSupportID <=" . $mgsid . " ";
            $varOrderBy = "pkSupportID DESC";
            $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID ";
            $arrRow = $this->select($varTable, $arrClms, $varWhere, $varOrderBy);
        }

        //pre($arrRow);
        return $arrRow;
    }

//    function getMessageDetail($mgsid, $wid) {
//        //$arrRowFinal=array();
//        $varID = "pkSupportID ='" . $mgsid . "' AND ToUserType = 'wholesaler' AND fkToUserID ='" . $wid . "'";
//        $arrClms = array(
//            'fkParentID', 'Subject', 'Message', 'fkFromUserID', 'SupportDateAdded', 'pkSupportID', 'FromUserType', 'ToUserType', 'SupportType', 'pkSupportID', 'CustomerFirstName', 'CustomerLastName',
//        );
//        $arrClmsWhol = array(
//            'fkParentID', 'Subject', 'Message', 'fkFromUserID', 'SupportDateAdded', 'pkSupportID', 'FromUserType', 'ToUserType', 'SupportType', 'pkSupportID', 'CompanyName');
//        $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID ";
//        $arrRow = $this->select($varTable, $arrClms, $varID);
//        if(count($arrRow)>0){
//        //pre($arrRow);die;
//        if ($arrRow[0]['fkParentID'] > 0) {
//            $varWhere = " (fkParentID = " . $arrRow[0]['fkParentID'] . " OR pkSupportID =" . $arrRow[0]['fkParentID'] . ") AND pkSupportID <=" . $mgsid . " ";
//            $varOrderBy = "pkSupportID DESC";
//            $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID ";
//            $arrRow = $this->select($varTable, $arrClms, $varWhere, $varOrderBy);
//            $query='';
//            if(count($arrRow)>0){
//                foreach($arrRow as $key=>$v){
//                    if($v['FromUserType']=='customer'){
//                        $varWhereCus="fkFromUserID='".$v['fkFromUserID']."'";
//                        $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID ";
//                        $query[]= $this->select($varTable, $arrClms, $varWhereCus);
//                    }else if($v['FromUserType']=='wholesaler'){
//                        $varWhereCus="fkFromUserID='".$v['fkFromUserID']."'";
//                        $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkFromUserID = pkWholesalerID ";
//                        $query[]= $this->select($varTable, $arrClmsWhol, $varWhereCus);
//                    }
//                }
//                
//            }
//            $arrRowFinal=$query;
//        }
//        }else{
//            $arrRowFinal=$arrRow;
//        }
//        pre($arrRowFinal);
//        return $arrRowFinal;
//    }

    /**
     * function getMessageThread
     *
     * This function is used to retrive message reply details.
     *
     * Database Tables used in this function are : tbl_support_reply
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRow
     */
    function getMessageThread($mgsid) {
        $varID = 'fkSupportID =' . $mgsid;
        $varOrderBy = 'ReplyDateAdded ASC ';
        $arrClms = array(
            'ReplySubject', 'ReplyMessage', 'pkReplyID', 'fkFromID', 'fkToID', 'fkSupportID', 'ReplyDateAdded'
        );
        $varTable = TABLE_SUPPORT_REPLY;
        $arrRow = $this->select($varTable, $arrClms, $varID, $varOrderBy);
        foreach ($arrRow as $key => $var) {
            $udetail = $this->getUserName($var['fkFromID'], 'admin');
            $arrRow[$key]['FromName'] = $udetail[0]['name'];
        }
        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function getMessageOutboxDetail
     *
     * This function is used to retrive outbox message details.
     *
     * Database Tables used in this function are : tbl_support, tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRow
     */
    function getMessageOutboxDetail($mgsid, $wid) {
        $varID = "FromUserType = 'wholesaler' AND fkFromUserID ='" . $wid . "' AND pkSupportID ='" . $mgsid . "'";

        $arrClms = array('fkParentID', 'Subject', 'Message', 'fkFromUserID', 'SupportDateAdded', 'pkSupportID', 'FromUserType', 'fkToUserID', 'ToUserType', 'CustomerFirstName', 'CustomerLastName');
        $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkToUserID = pkCustomerID ";
        $arrRow = $this->select($varTable, $arrClms, $varID);

        /* foreach ($arrRow as $key => $var) {
          $udetail = $this->getUserName($var['fkToUserID'], $var['ToUserType']);
          $arrRow[$key]['ToName'] = $udetail[0]['name'];
          } */
        if ($arrRes[0]['fkParentID'] > 0) {
            $varID = " (fkParentID = " . $arrRes[0]['fkParentID'] . " OR pkSupportID =" . $arrRes[0]['fkParentID'] . ") AND pkSupportID <=" . $argPostIDs . " ";
            $varOrderBy = "SupportDateAdded DESC";
            $varTable = "" . TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID ";
            $arrRow = $this->select($varTable, $arrClms, $varID, $varOrderBy);
        }
        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function getWholesalerOutbox
     *
     * This function is used to retrive outbox message List.
     *
     * Database Tables used in this function are : tbl_support, tbl_customer
     *
     * @access public
     *
     * @parameters 1 string(optional)
     *
     * @return array $arrRes
     */
    function getWholesalerOutbox($wid, $limit = '') {
        $varID = "FromUserType = 'wholesaler' AND fkFromUserID ='" . $wid . "' AND DeletedBy!=fkFromUserID";
        $varOrderBy = 'SupportDateAdded DESC ';
        $arrClms = array('fkParentID', 'Subject', 'Message', 'fkFromUserID', 'SupportType', 'pkSupportID', 'fkToUserID', 'ToUserType', 'SupportDateAdded', 'CustomerFirstName as ToName');
        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkToUserID = pkCustomerID ";
        $arrRes = $this->select($varTable, $arrClms, $varID, $varOrderBy, $limit);

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getMessageTypeList
     *
     * This function is used to retrive message Subject.
     *
     * Database Tables used in this function are : tbl_support_ticket_type
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getMessageTypeList() {
        $arrClms = array(
            'TicketTitle', 'pkTicketID'
        );
        $varTable = TABLE_SUPPORT_TICKET_TYPE;
        $arrRes = $this->select($varTable, $arrClms);
        return $arrRes;
    }

    /**
     * function sendMessage
     *
     * This function is used to send messages.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return boolian
     */
    function sendMessage($arrPost) {
        $wid = $_SESSION['sessUserInfo']['id'];
        $objCore = new Core();
        global $objGeneral;
        if ($arrPost['frmToUserType'] == "customer" || $arrPost['frmToUserType'] == "0") {
            $varfkToUserID = $this->getMessageRecipientUser($arrPost['frmToUserType'], $arrPost['frmMessageTo']);
            if ($varfkToUserID == 0) {
                return 0;
            }
        }
        if ($arrPost['frmToUserType'] == "admin") {
            $varfkToUserID = 1;
        }
        $arrClms = array(
            'FromUserType' => 'wholesaler',
            'fkFromUserID' => $_SESSION['sessUserInfo']['id'],
            'fkToUserID' => $varfkToUserID,
            'ToUserType' => $arrPost['frmToUserType'],
            'SupportType' => $arrPost['frmMessageType'],
            'Subject' => $arrPost['frmSubject'],
            'Message' => $arrPost['frmMessage'],
            'SupportDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );

        $arrAddID = $this->insert(TABLE_SUPPORT, $arrClms);
        $this->update(TABLE_SUPPORT, array('fkParentID' => $arrAddID), " pkSupportID='" . $arrAddID . "'");
        $objGeneral->sendSupportEmail($arrAddID);
        return 1;
    }

    /**
     * function getWholesalerAdmin
     *
     * This function is used to retrive admin details for wholesaler.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_admin
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getWholesalerAdmin($wid) {
        $varWhere = "pkWholesalerID = {$wid}";
        $arrClms = array('CompanyCountry', 'CompanyRegion');
        $varTable = TABLE_WHOLESALER;
        $arrRes = $this->select($varTable, $arrClms, $varWhere);

        $varWhere = "AdminRegion = {$arrRes[0]['CompanyRegion']}";
        $arrClms = array('pkAdminID');
        $varTable = TABLE_ADMIN;
        $arrRes = $this->select($varTable, $arrClms, $varWhere);
        if (empty($arrRes)) {
            $varWhere = "AdminCountry = {$arrRes[0]['CompanyCountry']}";
            $arrClms = array('pkAdminID');
            $varTable = TABLE_ADMIN;
            $arrRes = $this->select($varTable, $arrClms, $varWhere);
            if (empty($arrRes)) {
                $arrRes[0]['pkAdminID'] = 1;
            }
        }
        return $arrRes[0]['pkAdminID'];
    }

    /**
     * function replyMessage
     *
     * This function is used to send replies.
     *
     * Database Tables used in this function are : tbl_support_reply
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return boolean

      function replyMessage($arrPost) {
      $arrClms = array(
      'fkFromID' => $_SESSION['sessUserInfo']['id'],
      'fkSupportID' => $arrPost['fkSupportID'],
      'fkToID' => $arrPost['fkToUserID'],
      'ReplySubject' => $arrPost['frmSubject'],
      'ReplyMessage' => $arrPost['frmMessage'],
      'ReplyDateAdded' => date(DATE_TIME_FORMAT_DB)
      );
      $arrAddID = $this->insert(TABLE_SUPPORT_REPLY, $arrClms);
      return TRUE;
      }

      /**
     * function replyMessage
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string TRUE
     */
    function replyMessage($arrPost) {
        global $objCore;

        if ($arrPost['fkParentID'] == 0) {
            $varParent = $arrPost['fkSupportID'];
        } else {
            $varParent = $arrPost['fkParentID'];
        }

        $arrClms = array(
            'fkFromUserID' => $_SESSION['sessUserInfo']['id'],
            'fkParentID' => $varParent,
            'fkToUserID' => $arrPost['fkToUserID'],
            'FromUserType' => 'wholesaler',
            'Subject' => $arrPost['frmSubject'],
            'Message' => $arrPost['frmMessage'],
            'SupportType' => $arrPost['frmMessageType'],
            'ToUserType' => $arrPost['frmToUserType'],
            'SupportDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_SUPPORT, $arrClms);
        return TRUE;
    }

    /**
     * function getMessageRecipientUser
     *
     * This function is used to get message for Recipient user.
     *
     * Database Tables used in this function are : tbl_customer, tbl_admin
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
    function getMessageRecipientUser($userType, $email) {
        if ($userType == 'customer') {
            $varID = "CustomerEmail LIKE '" . $email . "'";
            $arrClms = array(
                'pkCustomerID'
            );
            $varTable = TABLE_CUSTOMER;
            $arrRes = $this->select($varTable, $arrClms, $varID);
            if (empty($arrRes)) {
                return 0;
            } else {
                return $arrRes[0]['pkCustomerID'];
            }
        } elseif ($userType == 'admin') {
            $varID = "AdminEmail LIKE '" . $email . "'";
            $arrClms = array(
                'pkAdminID'
            );
            $varTable = TABLE_ADMIN;
            $arrRes = $this->select($varTable, $arrClms, $varID);
            if (empty($arrRes)) {
                return 0;
            } else {
                return $arrRes[0]['pkAdminID'];
            }
        }
    }

    /**
     * function deleteMessage
     *
     * This function is used to delete Messages.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function deleteMessage($mgsid, $wid) {
        $core = new Core();
        if ($core->messageDeleteRequired($mgsid) == true) {
            $varWhereSdelete = " pkSupportID = '" . $mgsid . "' AND ((ToUserType='wholesaler' AND fkToUserID = '" . $wid . "') OR (FromUserType='wholesaler' AND fkFromUserID = '" . $wid . "'))";
            $varAffected = $this->delete(TABLE_SUPPORT, $varWhereSdelete);
            return $varAffected;
        } else {
            $arr = array('DeletedBy' => $wid);
            $varWhereSdelete = "pkSupportID = '" . $mgsid . "'";
            $varAffected = $this->update(TABLE_SUPPORT, $arr, $varWhereSdelete);
            return $varAffected;
        }
    }

    /**
     * function bulkUploadProduct
     *
     * This function is used for Product bulk Upload .
     *
     * Database Tables used in this function are : tbl_product, tbl_product_to_option, tbl_product_option_inventory, tbl_product_image, tbl_package, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 3 array , array ,array
     *
     * @return string
     */
    function bulkUploadProduct($argData, $argType, $argAtrributes, $argAttributesInventory, $argImages, $imagePath) {
        global $objCore;
//        pre($argData);
        if ($argType == 'products') {

            $arrPData = $this->select(TABLE_PRODUCT, array('pkProductID'), "ProductRefNo='" . $argData['ProductRefNo'] . "' ");
//            pre($arrPData);
            if ($arrPData) {
                
            } else {
//                pre($argData);
                $arrAddID = $this->insert(TABLE_PRODUCT, $argData);


                if (count($argAtrributes) > 0) {
                    $arrInventory = array();
                    $attrData['fkProductId'] = $arrAddID;
//                    pre($argAtrributes);
                    foreach ($argAtrributes as $key => $attrValues) {


                        $attrData['fkAttributeId'] = $key;

                        //$attrValues['options'] = explode('|', $attrValues['options']);
                        foreach ($attrValues['options'] as $oKey => $oVal) {

                            if ($attrValues['AttributeInputType'] == 'image') {
                                $imageNm = '';
                                if ($oVal['newImage'] <> '') {
                                    $imageNm = $this->processedProductImageName($oVal['newImage']);
                                    mkdir(dirname(UPLOADED_FILES_SOURCE_PATH . 'images/products/'), 0777, true);
                                    //rename($imagePath . $Image, UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $imageName);                        
                                    copy($imagePath . $oVal['newImage'], UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $imageNm);

                                    $this->imageUpload($imageNm);
                                }
                                $attrData['AttributeOptionImage'] = ($imageNm == '') ? $oVal['OptionImage'] : $imageNm;
                                $attrData['IsImgUploaded'] = ($imageNm == '') ? 0 : 1;
                            } else {
                                $attrData['AttributeOptionImage'] = '';
                            }
                            $attrOptId = $oKey;
                            $attrType = $attrValues['AttributeInputType'];

                            if (!empty($attrOptId)) {


                                $attrData['fkAttributeOptionId'] = $attrOptId;

                                $attrData['OptionExtraPrice'] = $oVal['price'];

                                if ($oVal['price'] > 0) {
                                    $def = 0;
                                } else {
                                    $def = 1;
                                }

                                $attrData['OptionIsDefault'] = $def;
                                $attrData['AttributeOptionValue'] = $oVal['OptionTitle'];

                                /* if ($attrType == 'textarea' || $attrType == 'text' || $attrType == 'date') {
                                  $attrData['AttributeOptionValue'] = $oVal['OptionTitle'];
                                  } else {
                                  $attrData['AttributeOptionValue'] = '';
                                  } */

                                $arrAttrAddID = $this->insert(TABLE_PRODUCT_TO_OPTION, $attrData);
                            }
                        }
                    }

                    $arrInventory = $this->processInventory($argAttributesInventory, $argAtrributes);

                    foreach ($arrInventory as $kInv => $vInv) {
                        $vInv['fkProductID'] = $arrAddID;
                        $arrInvAddID = $this->insert(TABLE_PRODUCT_OPTION_INVENTORY, $vInv);
                    }
                }
            }

//            pre($argImages);
            if (!empty($argImages)) {
                foreach ($argImages as $kImg => $Image) {
                    if (!empty($Image)) {
//                        echo $imagePath;die;
                        $imageName = $this->processedProductImageName($Image);
                        mkdir(dirname(UPLOADED_FILES_SOURCE_PATH . 'images/products/'), 0777, true);
                        copy($imagePath . $Image, UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $imageName);
                        $this->imageUpload($imageName);

                        if ($kImg == 0) {
                            $arrProImgField = array('0' => 'ProductImage');
                            $arrProImg = array($arrProImgField[$kImg] => $imageName);
                            $this->update(TABLE_PRODUCT, $arrProImg, " pkProductID='" . $arrAddID . "' ");
                        }
                        $attrData = array('fkProductId' => $arrAddID, 'ImageName' => $imageName, 'ImageDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
                        $arrAttrAddID = $this->insert(TABLE_PRODUCT_IMAGE, $attrData);
                    }
                }
            }
        } elseif ($argType == 'packages') {
            //pre($argData['ProductIdAttribute']);
            $pkgData = $argData;
            unset($pkgData['ProductIds']);
            unset($pkgData['ProductIdAttribute']);
            $arrAddID = $this->insert(TABLE_PACKAGE, $pkgData);
            foreach ($argData['ProductIds'] as $pid) {
                $arrPkgProductId = $this->insert(TABLE_PRODUCT_TO_PACKAGE, array('fkPackageId' => $arrAddID, 'fkProductId' => $pid['pkProductID']));
                $frmAttribute = count($argData['ProductIdAttribute']);
                // Add product wise attribute with attribute option
                if ($frmAttribute > 0) {
                    foreach ($argData['ProductIdAttribute'] as $key => $valOption) {
                        if ($pid['pkProductID'] == $key) {
                            foreach ($valOption as $valOptions) {
                                $arrClmsProPack = array(
                                    'packageId' => $arrAddID,
                                    'productId' => $pid['pkProductID'],
                                    'attributeId' => $valOptions['pkAttributeID'],
                                    'attrbuteOptionId' => $valOptions['pkOptionID']
                                );
                                $this->insert(TABLE_PACKAGE_PRODUCT_ATTRIBUTE_OPTION, $arrClmsProPack);
                            }
                        }
                    }
                }
            }

            if (!empty($argImages)) {
                // pre($argImages);
                $imageName = $this->processedProductImageName($argImages);

                mkdir(dirname(UPLOADED_FILES_SOURCE_PATH . 'images/package/'), 0777, true);
                copy($imagePath . $argImages, UPLOADED_FILES_SOURCE_PATH . 'images/package/' . $imageName);
                $this->imageUploadPkg($imageName);
                $attrData = array('PackageImage' => $imageName);
                $varId = "pkPackageId = '" . $arrAddID . "'";
                $this->update(TABLE_PACKAGE, $attrData, $varId);
            }
        }
        return $arrAddID;
    }

    /**
     * function attributeCategory
     *
     * This function is used for check attribute category.
     *
     * Database Tables used in this function are : tbl_attribute_to_category
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return boolean
     */
    function attributeCategory($atrrId, $catId) {
        $arrClms = array('pkID');
        $varWher = "fkAttributeId = '" . $atrrId . "' AND fkCategoryID='" . $catId . "'";
        $varTable = TABLE_ATTRIBUTE_TO_CATEGORY;
        $arrRes = $this->select($varTable, $arrClms, $varWher);
        if (!empty($arrRes[0]['pkID'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * function processInventory
     *
     * This function is used to get the attribute Category.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string true
     *
     * User instruction: $objBulkUpload->attributeCategory($atrrId, $catId)
     */
    function processInventory($argAttributesInventory, $argAtrributes) {

        $arrAttrInv = explode(';', $argAttributesInventory);

        foreach ($arrAttrInv as $key => $val) {

            if ($val) {
                $arrOptQty = explode('=', $val);

                $qty = (int) $arrOptQty[1];
                $optIds = array();
                $arrAttr = explode('|', $arrOptQty[0]);

                foreach ($arrAttr as $k1 => $v1) {
                    list($attr, $opt) = explode('#', $v1);

                    foreach ($argAtrributes as $kA => $vA) {

                        if (strtolower($attr) == strtolower($vA['AttributeCode'])) {
                            foreach ($vA['options'] as $kO => $vO) {

                                if (strtolower($opt) == strtolower($vO['OptionTitle'])) {
                                    $optIds[] = $vO['pkOptionID'];
                                }
                            }
                        }
                    }
                }
                if (count($optIds) > 0) {
                    sort($optIds);
                    $strOptIds = implode(',', $optIds);
                    $arrAttrInventory[$key] = array('OptionQuantity' => $qty, 'OptionIDs' => $strOptIds);
                }
            }
        }

        //pre($arrAttrInventory);
        return $arrAttrInventory;
    }

    /**
     * function getAttributesList
     *
     * This function is used for get attribute list.
     *
     * Database Tables used in this function are : tbl_attribute
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getAttributesList() {
        $arrClms = array('pkAttributeID', 'AttributeLabel', 'AttributeCode');
        $varTable = TABLE_ATTRIBUTE;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes;
    }

    /**
     * function getProductsFromRefNo
     *
     * This function is used for get product .
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return array $arrRes
     */
    function getProductsFromRefNo($argArray) {
        //$argArray = implode(',',$argArray);
        // echo '<pre>';print_r($argArray);
        $arrClms = array('pkProductID');
        $varID = "ProductRefNo IN(";
        foreach ($argArray as $val) {
            $varID1.= "'{$val}',";
        }
        $varID.= substr($varID1, 0, -1) . ") AND fkWholesalerID = '" . $_SESSION['sessUserInfo']['id'] . "'";
        $varTable = TABLE_PRODUCT;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes;
    }

    function getAdminProductsFromRefNo($argArray) {
        //$argArray = implode(',',$argArray);
        // echo '<pre>';print_r($argArray);
        $arrClms = array('pkProductID');
        $varID = "ProductRefNo IN(";
        foreach ($argArray as $val) {
            $varID1.= "'{$val}',";
        }
        $varID.= substr($varID1, 0, -1) . ")";
        $varTable = TABLE_PRODUCT;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes;
    }

    /**
     * function getAttributeId
     *
     * This function is used to get Attribute Id .
     *
     * Database Tables used in this function are : tbl_attribute_to_category, tbl_attribute
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function getAttributeId($attributeCode, $cid) {
        $arrClms = array('pkAttributeID', 'AttributeInputType', 'AttributeCode');
        $varID = " AttributeCode='" . $attributeCode . "' AND fkCategoryID='" . $cid . "'";
        $varTable = TABLE_ATTRIBUTE_TO_CATEGORY . " INNER JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeID";
        $arrRes = $this->select($varTable, $arrClms, $varID);

        return $arrRes[0];
    }

    /**
     * function getAttributeOptionId
     *
     * This function is used to get Attribute option Id .
     *
     * Database Tables used in this function are : tbl_attribute_option
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $result
     */
    function getAttributeOptionId($arrAttr, $attrOption) {
        $arrClms = array('pkOptionID', 'OptionTitle', 'OptionImage');
        $attrType = $arrAttr['AttributeInputType'];
        if ($attrType == 'textarea' || $attrType == 'text' || $attrType == 'date') {
            $varID = " fkAttributeId='" . $arrAttr['pkAttributeID'] . "'";
        } else {
            $varID = " fkAttributeId='" . $arrAttr['pkAttributeID'] . "' AND TRIM(OptionTitle) = '" . addslashes(html_entity_decode(trim($attrOption), ENT_QUOTES)) . "'";
        }
        $varTable = TABLE_ATTRIBUTE_OPTION;
        $arrRes = $this->select($varTable, $arrClms, $varID);

        return $arrRes[0];
    }

    /**
     * function checkAttributeType
     *
     * This function is used to get Attribute Type .
     *
     * Database Tables used in this function are : tbl_attribute
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function checkAttributeType($attrId) {
        $arrClms = array('AttributeInputType');
        $varID = " pkAttributeID='" . $attrId . "'";
        $varTable = TABLE_ATTRIBUTE;
        $arrRes = $this->select($varTable, $arrClms, $varID);

        return $arrRes[0]['AttributeInputType'];
    }

    /**
     * function findCategory
     *
     * This function is used to get Category .
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
//     function findCategory($argCat)
//     {
//         $varID = "TRIM(CategoryName) = '" . addslashes(html_entity_decode(trim($argCat), ENT_QUOTES)) . "' AND CategoryLevel='2'";
//         $arrClms = array('pkCategoryId');
//         $varTable = TABLE_CATEGORY;
//         $arrRes = $this->select($varTable, $arrClms, $varID);
//         return $arrRes[0]['pkCategoryId'];
//     }
    function findCategory($argCat) {
        //$varID = "TRIM(CategoryName) = '" . addslashes(html_entity_decode(trim($argCat), ENT_QUOTES)) . "' AND CategoryLevel='2'";
        $varID = "TRIM(CategoryName) = '" . addslashes(html_entity_decode(trim($argCat), ENT_QUOTES)) . "'";
        $arrClms = array('pkCategoryId');
        $varTable = TABLE_CATEGORY;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        //        $arrRes = $this->select($varTable, $arrClms, $varID, "", "", "",true);
        //  echo $arrRes; die;
        return $arrRes[0]['pkCategoryId'];
    }

    /**
     * function findShippingGateway
     *
     * This function is used to get ShippingGateway .
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function findShippingGateway($argShipping) {
        global $objCore;
        $varID = "ShippingTitle IN('" . str_replace(',', "','", $argShipping) . "') AND ShippingStatus = '1'";
        $arrClms = array("group_concat(`pkShippingGatewaysID`) AS pkShippingGatewaysID");
        $varTable = TABLE_SHIPPING_GATEWAYS;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['pkShippingGatewaysID'];
    }

    /**
     * function newsleterList
     *
     * This function is used to get newsleter List .
     *
     * Database Tables used in this function are : tbl_newsletters
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return $arrRes
     */
    function newsleterList($wid, $limit) {
        global $objCore;

        $varID = "CreatedBy = 'Wholesaler' AND CreatedID ='" . $wid . "'";
        $varOrderBy = "DeliveryDate DESC";
        if ($_POST['Title'] && $_POST['Title'] != '') {
            $varID.= " AND Title LIKE '%" . $_POST['Title'] . "%'";
        }
        if ($_POST['NewsletterStatus'] && $_POST['NewsletterStatus'] != '') {
            $varID.= " AND DeliveryStatus = '" . $_POST['NewsletterStatus'] . "'";
        }
        if ($_POST['StartDate'] && $_POST['StartDate'] != '') {
            $varID.= " AND DATE(DeliveryDate) >= '" . date('Y-m-d', strtotime($_POST['StartDate'])) . "'";
        }
        if ($_POST['EndDate'] && $_POST['EndDate'] != '') {
            $varID.= " AND DATE(DeliveryDate) <= '" . date('Y-m-d', strtotime($_POST['EndDate'])) . "'";
        }
        //echo $varID;die;
        $arrClms = array('pkNewsLetterID', 'Title', 'DeliveryDate', 'DeliveryStatus', 'ApprovedStatus', 'NewsLetterDateAdded');
        $varTable = TABLE_NEWSLETTER;
        $arrRes = $this->select($varTable, $arrClms, $varID, $varOrderBy, $limit);
        return $arrRes;
    }

    /**
     * function newsleterDetail
     *
     * This function is used to get newsleter details .
     *
     * Database Tables used in this function are : tbl_newsletters, tbl_newsletters_recipient
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     */
    function newsleterDetail($nlid, $wid) {
        $varID = "CreatedBy='Wholesaler' AND CreatedID= '" . $wid . "' AND pkNewsletterID ='" . $nlid . "'";
        $arrClms = array('pkNewsletterID', 'GROUP_CONCAT(SendToID) as recipients', 'Title', 'Template', 'NewsLetterType', 'Content', 'DeliveryDate', 'DeliveryStatus', 'ApprovedStatus', 'NewsLetterDateAdded');
        $varTable = TABLE_NEWSLETTER . ' LEFT JOIN ' . TABLE_NEWSLETTER_RECEPIENT . ' ON pkNewsletterID=fkNewsLetterID';
        $arrRes = $this->select($varTable, $arrClms, $varID);
        $recipients = $this->newsleterRecipients($arrRes[0]['recipients']);
        $arrRes[0]['Recipients'] = $recipients;
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function newsleterRecipients
     *
     * This function is used to get newsleter Recipients details .
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     */
    function newsleterRecipients($uids) {
        if ($uids) {
            $varID = "pkCustomerID IN ({$uids})";
            $varOrderBy = "CustomerFirstName ASC";
            $arrClms = array('CustomerFirstName', 'CustomerEmail');
            $varTable = TABLE_CUSTOMER;
            $arrRes = $this->select($varTable, $arrClms, $varID, $varOrderBy);
            return $arrRes;
        } else {
            return array();
        }
    }

    /**
     * function recipientList
     *
     * This function is used to get recipient List.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 0
     *
     * @return $arrRes
     */
    function recipientList() {

        $varOrderBy = $_POST['sort_by'] ? "{$_POST['sort_by']} ASC" : "CustomerFirstName ASC";
        $arrClms = array('pkCustomerID', 'CustomerFirstName', 'CustomerEmail', 'CustomerLastName', 'CustomerDateAdded');
        $varTable = TABLE_CUSTOMER;
        $arrRes = $this->select($varTable, $arrClms, $varID, $varOrderBy);
        return $arrRes;
    }

    /**
     * function saveNewsLetter
     *
     * This function is used to save NewsLetter details.
     *
     * Database Tables used in this function are : tbl_newsletters, tbl_newsletters_recipient
     *
     * @access public
     *
     * @parameters array
     *
     * @return boolean
     */
    function saveNewsLetter($arrData, $wid) {
        global $objCore;
        $date = date('Y-m-d', strtotime($_POST['DeliveryDate']));
        $date = $date . " {$arrData['hours']}:{$arrData['minutes']}:00";

        /**
         * To save newsletter only text format, only image and textAndImage both
         * 
         * @author : Krishna Gupta
         * 
         * @created : 28-10-2015
         */
        if (!empty($arrData['Content']) && !empty($_FILES['template']['name'])) {
            $type = 'ContentAndTemplate';
            $teplate = $this->uploadNewsleterDoc($_FILES);
        } else {
            $type = (empty($_FILES['template']['name'])) ? 'content' : 'template';
            if (!empty($_FILES['template']['name'])) {
                $teplate = $this->uploadNewsleterDoc($_FILES);
            } else {
                $teplate = '';
            }
        }
        $arrClms = array(
            'Title' => $arrData['Title'],
            'NewsLetterType' => $type,
            'Content' => $arrData['Content'],
            'Template' => $teplate,
            'CreatedBy' => 'Wholesaler',
            'CreatedID' => $wid,
            'DeliveryStatus' => 'Pending',
            'DeliveryDate' => $date,
            'ApprovedStatus' => 0,
            'NewsLetterDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_NEWSLETTER, $arrClms);
        foreach ($arrData['recipienId'] as $val) {
            $arrClms2 = array(
                'fkNewsLetterID' => $arrAddID,
                'SendTo' => 'customer',
                'IsDelivered' => 0,
                'SendToID' => $val
            );
            $arrAddID1 = $this->insert(TABLE_NEWSLETTER_RECEPIENT, $arrClms2);
        }
        return true;
    }

    /**
     * function uploadNewsleterDoc
     *
     * This function is used to  upload Newsleter Doc.
     *
     * Database Tables used in this function are :none
     *
     * @access public
     *
     * @parameters array
     *
     * @return boolean
     */
    function uploadNewsleterDoc($FILES) {
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $temp = explode(".", $_FILES["template"]["name"]);
        $extension = strtolower(end($temp));
        if ($_FILES["template"]["name"]) {
            if (($_FILES["template"]["size"] < 2000000) && in_array($extension, $allowedExts)) {
                if ($_FILES["template"]["error"] > 0) {
                    return $_FILES["template"]["error"];
                } else {
                    $file_name = md5(time() . rand(10, 99)) . '.' . end($temp);
                    move_uploaded_file($_FILES["template"]["tmp_name"], UPLOADED_FILES_SOURCE_PATH . "images/newsletter/" . $file_name);
                    return $file_name;
                }
            } else {
                return false;
            }
        }
    }

    /**
     * function getWholesalerOrders
     *
     * This function is used to get Orders List.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
    function getWholesalerOrders($wid, $limit) {
        global $objCore;

        $varOrderBy = $_POST['sort_by'] ? "{$_POST['sort_by']} ASC" : "OrderDateAdded ASC";
        $varID = "oi.fkWholesalerID ='" . $wid . "' ";
        if ($_POST['pkOrderID'] && $_POST['pkOrderID'] != '') {
            $varID.= " AND oi.SubOrderID ='" . $objCore->getFormatValue($_POST['pkOrderID']) . "'";
        }
        if ($_POST['CustomerFirstName'] && $_POST['CustomerFirstName'] != '') {
            $varID.= " AND o.CustomerFirstName LIKE '%" . $objCore->getFormatValue($_POST['CustomerFirstName']) . "%' OR o.CustomerLastName LIKE '%" . $objCore->getFormatValue($_POST['CustomerFirstName']) . "%'";
        }
        if ($_POST['OrderStatus'] && $_POST['OrderStatus'] != '') {
            $varID.= " AND oi.Status ='" . $objCore->getFormatValue($_POST['OrderStatus']) . "'";
        }
        if ($_POST['StartDate'] && $_POST['StartDate'] != '') {
            $varID.= " AND DATE(o.OrderDateAdded) >= '" . date(DATE_FORMAT_DB, strtotime($objCore->getFormatValue($_POST['StartDate']))) . "'";
        }
        if ($_POST['EndDate'] && $_POST['EndDate'] != '') {
            $varID.= " AND DATE(o.OrderDateAdded) <= '" . date(DATE_FORMAT_DB, strtotime($objCore->getFormatValue($_POST['EndDate']))) . "'";
        }

        //$query = "SELECT oi.fkOrderID,oi.SubOrderID,oi.ItemName,o.fkCustomerID,concat(o.CustomerFirstName,' ',o.CustomerLastName) as CustomerName,sum(((ItemACPrice*Quantity)+ShippingPrice)-DiscountPrice) as ACTotal,  oi.Status,oi.DisputedStatus, o.OrderDateAdded, sum(oi.ItemTotalPrice) as total FROM " . TABLE_ORDER_ITEMS . " as oi LEFT JOIN " . TABLE_ORDER . " as o ON oi.fkOrderID = o.pkOrderID WHERE " . $varID . " GROUP BY oi.SubOrderID order by oi.pkOrderItemID DESC" . $limit;
        $query = "SELECT oi.pkOrderItemID,oi.fkShippingIDs,oi.fkOrderID,oi.SubOrderID,GROUP_CONCAT( oi.ItemName ) AS ItemName,o.fkCustomerID,concat(o.CustomerFirstName,' ',o.CustomerLastName) as CustomerName,sum(((ItemACPrice*Quantity)+ShippingPrice)-DiscountPrice) as ACTotal,  oi.Status,oi.DisputedStatus, o.OrderDateAdded, sum(oi.ItemTotalPrice) as total FROM " . TABLE_ORDER_ITEMS . " as oi LEFT JOIN " . TABLE_ORDER . " as o ON oi.fkOrderID = o.pkOrderID WHERE " . $varID . " GROUP BY oi.SubOrderID order by oi.pkOrderItemID DESC" . $limit;
        //echo $query;die;
        $arrRes = $this->getArrayResult($query);
        //pre($arrRes);
        return $arrRes;
    }

    function wholesaleridshippingidfront($pkOrderItemID) {

        $varArr = array('fkWholesalerID,fkShippingIDs');

        $where = "pkOrderItemID='" . trim($pkOrderItemID) . "'";
        $table = tbl_order_items;

        //$table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';

        $query = $this->select($table, $varArr, $where);

        return $query;
    }

    function wholesalercountryfront($wholesalerid) {

        $varArr = array('CompanyCountry');

        $where = "pkWholesalerID='" . trim($wholesalerid) . "'";
        $table = TABLE_WHOLESALER;

        //$table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';

        $query = $this->select($table, $varArr, $where);

        return $query;
    }

    function wholesalercountryportalfront($countryid) {

        $varArr = array('pkAdminID');

        $where = "AdminCountry='" . trim($countryid) . "'";
        $table = TABLE_ADMIN;

        //$table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';

        $query = $this->select($table, $varArr, $where);

        return $query;
    }

    function getwaymailidusingportalfront($portalid, $shippingid) {

        $varArr = array('gatewayEmail');

        $where = "fkportalID='" . trim($portalid) . "' And fkgatewayID = '" . $shippingid . "'";
        $table = TABLE_GATEWAYS_PORTAL;

        //$table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';

        $query = $this->select($table, $varArr, $where);

        return $query;
    }

    /**
     * function getOrderDetail
     *
     * This function is used to get Orders details.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_shipping_gateways, tbl_order, tbl_country, tbl_order_comments, tbl_customer, tbl_wholesaler, tbl_admin, tbl_order_total, tbl_invoice, tbl_order_option
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
    function getOrderDetail($oid, $wid) {

        $arrClms1 = array('c.pkOrderItemID', 'c.fkOrderID', 'c.SubOrderID', 'c.fkItemID', 'c.ItemType', 'c.ItemName', 'c.ItemImage', 'c.fkWholesalerID', 'ShippingTitle', 'c.fkShippingIDs', 'c.ItemACPrice', 'c.ItemPrice', 'c.Quantity', '(c.ItemACPrice*c.Quantity) as ItemACSubTotal', 'DiscountPrice', 'c.ItemSubTotal', 'AttributePrice', 'c.ItemTotalPrice', 'c.ShippingPrice', 'c.ItemDetails,c.Status,c.DisputedStatus');
        //$varTable1 = TABLE_ORDER_ITEMS . ' as c LEFT JOIN ' . TABLE_SHIPPING_GATEWAYS . " ON c.fkShippingIDs=pkShippingGatewaysID";
        $varTable1 = TABLE_ORDER_ITEMS . ' as c LEFT JOIN ' . TABLE_SHIP_GATEWAYS . " ON c.fkShippingIDs=pkShippingGatewaysID";

        $varID1 = "SubOrderID = '" . $oid . "' AND fkWholesalerID='" . $wid . "' ";
        $arrRes1 = $this->select($varTable1, $arrClms1, $varID1);
        //pre($arrRes1);
        $varID = "pkOrderID = '" . $arrRes1[0]['fkOrderID'] . "' ";
        $arrClms = array('a.*', 'd.name as BillingCountryName', 'e.name as ShipingCountryName');
        $varTable = TABLE_ORDER . ' as a LEFT JOIN ' . TABLE_COUNTRY . ' as d ON d.country_id=a.BillingCountry LEFT JOIN ' . TABLE_COUNTRY . ' as e ON e.country_id=a.ShippingCountry';
        $arrRes = $this->select($varTable, $arrClms, $varID);


        $varID2 = " fkOrderID = '" . $arrRes1[0]['fkOrderID'] . "' ";
        $arrClms2 = array('pkOrderCommentID', 'CommentedBy', 'CommentedID', 'Comment', 'CommentDateAdded', 'AdminUserName as adminName', 'CompanyName as wholesalerName', 'CustomerFirstName as customerName');
        $varOrder2 = " pkOrderCommentID ASC";
        $varTable2 = TABLE_ORDER_COMMENTS . " LEFT JOIN " . TABLE_CUSTOMER . " ON CommentedID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON CommentedID = pkWholesalerID LEFT JOIN " . TABLE_ADMIN . " ON CommentedID=pkAdminID";
        $arrRes2 = $this->select($varTable2, $arrClms2, $varID2, $varOrder2);

        $arrClms3 = array('pkOrderTotalID', 'fkOrderID', 'Code', 'Title', 'Amount');
        $varTable3 = TABLE_ORDER_TOTAL;
        $varID3 = " fkOrderID = '" . $arrRes1[0]['fkOrderID'] . "' ";
        $arrRes3 = $this->select($varTable3, $arrClms3, $varID3, 'SortOrder ASC');

        $varID4 = "fkSubOrderID = '" . $oid . "' AND fkWholesalerID='" . $wid . "' AND FromUserType='wholesaler' ";
        $arrRes4 = $this->select(TABLE_INVOICE, array('pkInvoiceID'), $varID4);

        $data['customer_detail'] = $arrRes[0];
        $data['product_detail'] = $arrRes1;
        $data['product_comments'] = $arrRes2;
        $data['Order_Total'] = $arrRes3;
        $data['IsInvoiceSent'] = ($arrRes4) ? 1 : 0;

        $data['arrDisputedCommentsHistory'] = $this->disputedCommentsHistory($oid);

        foreach ($data['product_detail'] as $k => $v) {

            if ($v['ItemType'] <> 'gift-card') {
                $jsonDet = json_decode(html_entity_decode($v['ItemDetails']));
                $varDet = '';
                foreach ($jsonDet as $jk => $jv) {
                    $varDet .= $jv->ProductName;
                    $arrCols = array('AttributeLabel', 'OptionValue');
                    $argWhr = " fkOrderItemID = '" . $v['pkOrderItemID'] . "' AND fkProductID = '" . $jv->pkProductID . "'";
                    $arrOpt = $this->select(TABLE_ORDER_OPTION, $arrCols, $argWhr);
                    $num = count($arrOpt);
                    if ($num > 0) {
                        $varDet .= ' (';
                        $i = 1;
                        foreach ($arrOpt as $ok => $ov) {
                            $varDet .= $ov['AttributeLabel'] . ': ' . str_replace('@@@', ',', $ov['OptionValue']);
                            if ($i < $num)
                                $varDet .=' | ';
                            $i++;
                        }

                        $varDet .= ')';
                        $varDet .= '<br />';
                    } else {
                        $varDet = '';
                    }
                }
                $data['product_detail'][$k]['OptionDet'] = $varDet;
            }

            $data['product_detail'][$k]['Shipments'] = $this->shipmentRow($v['pkOrderItemID']);
        }
        //pre($data);
        return $data;
    }

    /**
     * function disputeFeedback
     *
     * This function is used to update order status as disputed.
     *
     * Database Tables used in this function are :tbl_order, tbl_order_disputed_comments
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $string
     */
    function disputeFeedback($arrPost, $id) {
        global $objGeneral;
        global $objCore;

        $oid = $arrPost['oid'];
        $soid = $arrPost['soid'];
        $arrClms = array('pkOrderID', 'fkCustomerID', 'TransactionID', 'CustomerFirstName', 'CustomerLastName', 'CustomerEmail', 'CustomerPhone');

        $argWhere = "pkOrderID='" . $oid . "' ";
        $arrOrder = $this->select(TABLE_ORDER, $arrClms, $argWhere);

        if (count($arrOrder) > 0) {

            $arrClms = array(
                'fkOrderID' => $arrPost['oid'],
                'fkSubOrderID' => $arrPost['soid'],
                'CommentedBy' => 'wholesaler',
                'CommentedID' => $id,
                'CommentOn' => 'Feedback',
                'AdditionalComments' => $arrPost['frmFeedback'],
                'CommentDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $arrRow = $this->insert(TABLE_ORDER_DISPUTED_COMMENTS, $arrClms);

            $arrOrder[0]['SubOrderId'] = $soid;
            $arrOrder[0]['EmailSubject'] = ORDER_DISPUTED_FEEDBACK_BY_WHOLESALER . '<br/>' . ORDER_DETAILS_TITLE;
            $objGeneral->sendDisputedEmail($arrOrder[0], 1);
        }
    }

    /**
     * function disputedCommentsHistory
     *
     * This function is used to insert disputed comments.
     *
     * Database Tables used in this function are :tbl_order_disputed_comments, tbl_customer, tbl_wholesaler, tbl_admin
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return null
     */
    function disputedCommentsHistory($soid) {
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
        $varWhr = " fkSubOrderID ='" . $soid . "' ";
        $varOrd = " CommentDateAdded ASC ";
        $varTable = TABLE_ORDER_DISPUTED_COMMENTS . " LEFT JOIN " . TABLE_CUSTOMER . " ON CommentedID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON CommentedID=pkWholesalerID LEFT JOIN " . TABLE_ADMIN . " ON CommentedID=pkAdminID";
        $arrRes = $this->select($varTable, $arrClms, $varWhr, $varOrd);

        return $arrRes;
    }

    /**
     * function addShipment
     *
     * This function is used to insert Shipment details.
     *
     * Database Tables used in this function are : tbl_shipment
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string
     */
    function addShipment($arrPost) {
        global $objCore;
        //$arrPost['orderDateAdded'],
        $rrField = array(
            'fkSubOrderID' => trim($arrPost['shipment_suborderid']),
            'fkShippingCarrierID' => trim($arrPost['snipat_career']),
            'TransactionNo' => trim($arrPost['tranjection_id']),
            'ShippingStatus' => trim($arrPost['spnipat_status']),
            'OrderDate' => $objCore->serverDateTime($arrPost['iDateFrom'], DATE_TIME_FORMAT_DB),
            'ShippedDate' => $objCore->serverDateTime($arrPost['iDateTo'], DATE_TIME_FORMAT_DB),
            'DateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        if ($rrField['TransactionNo'] <> '') {
            $insert = $this->insert(TABLE_SHIPMENT, $rrField);
            if ($insert) {
                $objCore->setSuccessMsg(SHIPMENT_ADD_SUCCESS);
                return true;
            }
        } else {
            $objCore->setErrorMsg("Transaction Id required !");
            return false;
        }
    }

    /**
     * function shipmentRow
     *
     * This function is used to get shipment details.
     *
     * Database Tables used in this function are : tbl_shipment, tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function shipmentRow($itemId) {
        global $objCore;

        $varArr = array('pkShipmentID', 'fkShippingCarrierID', 'TransactionNo', 'ship.ShippingStatus', 'OrderDate', 'ShippedDate', 'pkShippingGatewaysID', 'ShippingTitle');

        $where = "fkOrderItemID='" . $itemId . "' ";

        $table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';

        $query = $this->select($table, $varArr, $where);

        return $query[0];
    }

    /**
     * function deleteShipment
     *
     * This function is used to delete Shipment.
     *
     * Database Tables used in this function are : tbl_shipment
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function deleteShipment($sId) {

        global $objCore;

        $table = TABLE_SHIPMENT;
        $where = "pkShipmentID='" . trim($sId) . "'";
        $query = $this->delete($table, $where);

        if ($query) {

            $objCore->setSuccessMsg(SHIPMENT_DELETE_SUCCESS);
            return true;
        }
    }

    /**
     * function editShipment
     *
     * This function is used to update Shipment.
     *
     * Database Tables used in this function are : tbl_shipment
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string
     */
    function updateShipment($arrPost) {
        //pre($arrPost);
        global $objCore;

        $arrCols = array(
            'fkOrderItemID' => $arrPost['frmOrderItemID'],
            'fkShippingCarrierID' => $arrPost['frmShipmentGatways'],
            'TransactionNo' => $arrPost['frmTransactionNo'],
            'ShippingStatus' => $arrPost['frmShippingStatus'],
            'OrderDate' => $objCore->serverDateTime($arrPost['frmOrderDateAdded'], DATE_TIME_FORMAT_DB),
            'ShipStartDate' => $objCore->serverDateTime($arrPost['frmDateFrom'], DATE_TIME_FORMAT_DB),
            'ShippedDate' => $objCore->serverDateTime($arrPost['frmDateTo'], DATE_TIME_FORMAT_DB)
        );


        if ($arrPost['frmShipmentID'] <> '') {
            $varWhr = "pkShipmentID='" . $arrPost['frmShipmentID'] . "' ";
            $varNum = $this->update(TABLE_SHIPMENT, $arrCols, $varWhr);
            if ($varNum > 0) {
                $objCore->setSuccessMsg(SHIPMENT_UPDATE_SUCCESS);
            } else {
                $objCore->setErrorMsg(SHIPMENT_UPDATE_ERROR);
            }
        } else {
            $varNum = $this->insert(TABLE_SHIPMENT, $arrCols);
            if ($varNum > 0) {
                $objCore->setSuccessMsg(SHIPMENT_ADD_SUCCESS);
            } else {
                $objCore->setErrorMsg(SHIPMENT_ADD_ERROR);
            }
        }
    }

    /**
     * function updateOrderStatus
     *
     * This function is used to update Order Status.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return string
     */
    function updateOrderStatus($oid, $status) {
        global $objGeneral;
        global $objCore;
        $arrRes2 = $this->select(TABLE_ORDER_ITEMS, array('fkOrderID', 'SubOrderID', 'Status'), "SubOrderID = '" . $oid . "' ");

        $arrClmsUpdate = array('Status' => $status);
        $varWhr = "SubOrderID ='" . $oid . "' ";
        $arrUpdateID = $this->update(TABLE_ORDER_ITEMS, $arrClmsUpdate, $varWhr);


        $varID1 = "fkOrderID = '" . $arrRes2[0]['fkOrderID'] . "' AND Status ='Pending' ";
        $arrRes1 = $this->select(TABLE_ORDER_ITEMS, array('Status'), $varID1);

        if (count($arrRes1) == 0) {
            $arrClmsUpdate1 = array('OrderStatus' => $status, 'OrderDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
            $varWhr1 = "pkOrderID ='" . $arrRes2[0]['fkOrderID'] . "'";
            $arrUpdateID = $this->update(TABLE_ORDER, $arrClmsUpdate1, $varWhr1);

            $varID3 = "pkOrderID = '" . $arrRes2[0]['fkOrderID'] . "'";
            $arrRes3 = $this->select(TABLE_ORDER, array('pkOrderID,TransactionID,TransactionAmount,fkCustomerID,CustomerFirstName,CustomerLastName,CustomerEmail,CustomerPhone,BillingFirstName,BillingLastName,BillingOrganizationName,BillingAddressLine1,BillingAddressLine2,BillingCountry,BillingPostalCode,BillingPhone,ShippingFirstName,ShippingLastName,ShippingOrganizationName,ShippingAddressLine1,ShippingAddressLine2,ShippingCountry,ShippingPostalCode,ShippingPhone,OrderStatus'), $varID3);

            $arrRes3[0]['SubOrderId'] = $arrRes2[0]['SubOrderID'];
            $arrRes3[0]['EmailSubject'] = "Following are your Order Status";
            //pre($arrRes3[0]);
            $objGeneral->SendOrderStatusEmailToCustomer($arrRes3[0]);
        }

        if ($status == 'Disputed' || $status == 'Canceled') {
            $arrRes2[0]['Status'] = $status;
            $this->markAsDisputed($arrRes2[0], $status);
        }

        //echo 'updated';
        die;
    }

    /**
     * function markAsDisputed
     *
     * This function is used to update order status as disputed.
     *
     * Database Tables used in this function are : tbl_order, tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $string
     */
    function markAsDisputed($arrOrd, $status) {
        global $objGeneral;
        $arrClms = array('pkOrderID', 'fkCustomerID', 'TransactionID', 'CustomerFirstName', 'CustomerLastName', 'CustomerEmail', 'CustomerPhone');

        $argWhere = "pkOrderID='" . $arrOrd['fkOrderID'] . "' ";
        $arrOrder = $this->select(TABLE_ORDER, $arrClms, $argWhere);

        if (count($arrOrder) > 0) {

            $varWhr = "fkSubOrderID ='" . $arrOrd['fkSubOrderID'] . "' AND fkOrderID !='' AND fkSubOrderID !=''";
            $this->update(TABLE_INVOICE, array('TransactionStatus' => $status), $varWhr);

            $arrOrder[0]['SubOrderId'] = $arrOrd['SubOrderID'];
            $arrOrder[0]['EmailSubject'] = "Order Status change as " . $arrOrd['Status'] . " By Wholesaler. " . ORDER_DETAILS_TITLE;

            $objGeneral->sendDisputedEmail($arrOrder[0]);
        }
    }

    /**
     * function getWholesalerProductReviews
     *
     * This function is used to get Product Reviews list.
     *
     * Database Tables used in this function are : tbl_review, tbl_product, tbl_category
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return $arrRes
     */
    function getWholesalerProductReviews($wid, $limit) {
        $limit = $limit ? "LIMIT {$limit}" : '';
        if ($_POST['frmHidden'] && $_POST['frmHidden'] == 'search') {
            $varWhere.= $_POST['frmCategory'] ? " AND fkCategoryID ='" . trim($_POST['frmCategory']) . "'" : '';
            $varWhere.= $_POST['frmProductName'] ? " AND ProductName ='" . trim(addslashes($_POST['frmProductName'])) . "'" : '';
            $varWhere.= $_POST['frmProductID'] ? " AND pkProductID ='" . trim($_POST['frmProductID']) . "'" : '';
        }
        $query = "SELECT a.pkReviewID,p.ProductName,p.pkProductID,ReviewWholesaler,c.CategoryName FROM "
                . TABLE_REVIEW . " as a LEFT JOIN " . TABLE_PRODUCT . " as p ON p.pkProductID=a.fkProductID LEFT JOIN " .
                TABLE_CATEGORY . " as c ON c.pkCategoryId=p.fkCategoryID
                    WHERE p.fkWholesalerID={$wid} {$varWhere} GROUP BY a.fkProductID ORDER BY a.ReviewDateAdded DESC {$limit}";

        $arrRes = $this->getArrayResult($query);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function getWholesalerProductReviewsDetail
     *
     * This function is used to get Product Reviews details.
     *
     * Database Tables used in this function are :  tbl_review, tbl_product, tbl_customer
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return $arrRes
     */
    /*   function getWholesalerProductReviewsDetail($wid, $pid, $limit)
      {
      $arrClms = array('pkReviewID', 'fkProductID', 'Reviews', 'ApprovedStatus', 'ReviewDateAdded', 'CustomerFirstName');
      $varID = " fkProductID = '" . $pid . "' AND fkWholesalerID ='" . $wid . "'";
      $order = " ReviewDateAdded DESC";
      $varTable = TABLE_REVIEW . " INNER JOIN " . TABLE_PRODUCT . " ON fkProductID = pkProductID LEFT JOIN " . TABLE_CUSTOMER . " ON pkCustomerID=fkCustomerID ";
      $arrRes = $this->select($varTable, $arrClms, $varID, $order, $limit);
      return $arrRes;
      }
     */
    function getWholesalerProductReviewsDetail($wid, $pid, $limit) {
        $arrClms = array('pkReviewID', 'rat.fkProductID', 'Rating', 'pkRateID', 'Reviews', 'ApprovedStatus', 'ReviewDateAdded', 'CustomerFirstName');
        $varID = " rat.fkProductID = '" . $pid . "' AND fkWholesalerID ='" . $wid . "'  ";
        $order = " ReviewDateAdded DESC";
        $varTable = TABLE_REVIEW . " as rev INNER JOIN " . TABLE_PRODUCT . " ON fkProductID = pkProductID LEFT JOIN "
                . TABLE_CUSTOMER . " ON pkCustomerID=fkCustomerID LEFT JOIN " . TABLE_PRODUCT_RATING . " as rat on rat.pkRateID=rev.pkreviewID";
        $arrRes = $this->select($varTable, $arrClms, $varID, $order, $limit);
        return $arrRes;
    }

    /**
     * function updateReviewStatus
     *
     * This function is used to update Product Reviews status.
     *
     * Database Tables used in this function are :  tbl_review
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return string
     */
    /*  function updateReviewStatus($id, $status)
      {
      global $objGeneral;

      $arrClmsUpdate = array('ApprovedStatus' => $status);
      $varWhr = "pkReviewID ='" . $id . "'";
      $arrUpdateID = $this->update(TABLE_REVIEW, $arrClmsUpdate, $varWhr);

      if ($status == 'Allow')
      {
      $varArray = array('fkCustomerID');
      $list = $this->select(TABLE_REVIEW, $varArray, $varWhr);
      if ($list[0]['fkCustomerID'] > 0)
      $objGeneral->addRewards($list[0]['fkCustomerID'], 'RewardOnReviewRatingProduct');
      }

      return $arrUpdateID;
      } */

    function updateReviewStatus($id, $status, $varRateID) {
        global $objGeneral;

        $arrClmsUpdate = array('ApprovedStatus' => $status);
        $varWhr1 = "pkReviewID ='" . $id . "'";
        $arrUpdateID = $this->update(TABLE_REVIEW, $arrClmsUpdate, $varWhr1);

        $varWhr2 = "pkRateID ='" . $varRateID . "'";
        $this->update(TABLE_PRODUCT_RATING, array('RatingApprovedStatus' => $status), $varWhr2);

        if ($status == 'Allow') {
            $varArray = array('fkCustomerID');
            $list = $this->select(TABLE_REVIEW, $varArray, $varWhr1);
            if ($list[0]['fkCustomerID'] > 0)
                $objGeneral->addRewards($list[0]['fkCustomerID'], 'RewardOnReviewRatingProduct');
        }

        return $arrUpdateID;
    }

    /**
     * function deleteReview
     *
     * This function is used to delete Product Review.
     *
     * Database Tables used in this function are :  tbl_review
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function deleteReview($id, $varRateID) {
        $varWhereSdelete1 = " pkReviewID = '" . $id . "'";
        $varAffected = $this->delete(TABLE_REVIEW, $varWhereSdelete1);

        $varWhereSdelete2 = " pkRateID = '" . $varRateID . "'";
        $this->delete(TABLE_PRODUCT_RATING, $varWhereSdelete2);
        return $varAffected;
    }

    /**
     * function getWholesalerProductFeedbacksCount
     *
     * This function is used to get Product Feedbacks list.
     *
     * Database Tables used in this function are :  tbl_wholesaler_feedback, tbl_customer
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return string
     */
    function getWholesalerProductFeedbacksCount($wid) {
        $arrClms = array('a.fkCustomerID', 'a.pkFeedbackID', 'a.fkProductID', 'a.FeedbackDateAdded', 'b.CustomerFirstName');
        $varID = "fkWholesalerID = '" . $wid . "'";
        $order = " a.FeedbackDateAdded DESC";
        $varTable = TABLE_WHOLESALER_FEEDBACK . ' as a LEFT JOIN ' . TABLE_CUSTOMER . ' as b ON b.pkCustomerID=a.fkCustomerID';
        $arrRes = $this->select($varTable, $arrClms, $varID);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getWholesalerProductFeedbacks
     *
     * This function is used to get Product Feedbacks list.
     *
     * Database Tables used in this function are :  tbl_wholesaler_feedback, tbl_customer
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return string
     */
    function getWholesalerProductFeedbacks($wid, $limit) {
        $arrClms = array('fkCustomerID', 'pkFeedbackID', 'feedbackUpdate', 'fkProductID', 'FeedbackDateAdded', 'CustomerFirstName', 'Question1', 'Question2', 'Question3', 'IsPositive', 'Comment');
        $varID = "fkWholesalerID = '" . $wid . "' ";
        $order = " FeedbackDateAdded DESC";
        $varTable = TABLE_WHOLESALER_FEEDBACK . ' LEFT JOIN ' . TABLE_CUSTOMER . ' ON pkCustomerID=fkCustomerID';
        $arrRes = $this->select($varTable, $arrClms, $varID, $order, $limit);

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getFeedbackDetails
     *
     * This function is used to get Product Feedbacks details.
     *
     * Database Tables used in this function are :  tbl_wholesaler_feedback
     *
     * @access public
     *
     * @parameters 1  string
     *
     * @return string
     */
    function getFeedbackDetails($fbid) {
        $arrClms = array('Question1', 'Question2', 'Question3', 'Comment');
        $varID = "pkFeedbackID = {$fbid}";
        $varTable = TABLE_WHOLESALER_FEEDBACK;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        // $arrRes1['data'] = $arrRes[0];
        return $arrRes[0];
        // echo json_encode($arrRes1);
        //die;
    }

    /**
     * function sendEnquiry
     *
     * This function is used to send Enquiry email.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1  array
     *
     * @return boolean
     */
    function sendEnquiry($arrPost) {



        /* $objCore = new Core();

          $varToUser = trim(strip_tags($arrPost['frmWholeSalerEmailID']));
          $varFromUser = SITE_NAME . '<' . $_SESSION['sessUserInfo']['email'] . '>';
          $varSiteName = SITE_NAME;
          $varPathImage = '';
          $varPathImage = '<img src="'.SITE_ROOT_URL.'common/images/logo.png" >';

          $varSubject = $arrPost['frmSubject'];
          $varOutPutValues = $varPathImage."<br/><br/><p>".ucfirst($arrPost['frmMessage'])."</p>";
          // Calling mail function


          $objCore->sendMail($varFromUser, $varToUser, $varSubject, $varOutPutValues);
         */

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $varUserName = trim(strip_tags($arrPost['frmWholeSalerEmailID']));
        $varFromUser = trim(strip_tags($arrPost['frmEmail']));
        $varMessage = $arrPost['frmMessage'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'SendWholeSalerEnquiry' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrPost['frmSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{SITE_NAME}', '{MESSAGE}', '{CUSTOMER}', '{EMAIL}');

        $varKeywordValues = array($varPathImage, $arrPost['frmWholeSalerEmailName'], SITE_NAME, $varMessage, ucfirst($arrPost['frmName']), $arrPost['frmEmail']);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

        // Calling mail function


        $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);
        //return $arrAddID;
    }

    /**
     * function wholesalerFeedback
     *
     * This function is used to get wholesaler Feedback.
     *
     * Database Tables used in this function are :  tbl_order_items, tbl_wholesaler_feedback
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function wholesalerFeedback($argId) {

        //$varQuery = "select (select count(Quantity) from " . TABLE_ORDER_ITEMS . " where fkWholesalerID='" . $argId . "') as itemSold ,(SELECT count(pkFeedbackID) FROM " . TABLE_WHOLESALER_FEEDBACK . " where fkWholesalerID='" . $argId . "' and IsPositive='1') as postiveFeedback, (SELECT count(pkFeedbackID) FROM " . TABLE_WHOLESALER_FEEDBACK . " where fkWholesalerID='" . $argId . "' and IsPositive='0') as negativeFeedback from  " . TABLE_WHOLESALER_FEEDBACK . " where fkWholesalerID='" . $argId . "' group by fkWholesalerID";
        $varQuery = "select (select sum(Quantity) from " . TABLE_ORDER_ITEMS . " where fkWholesalerID='" . $argId . "'  AND ItemType<>'gift-card') as itemSold ,(SELECT count(pkFeedbackID) FROM " . TABLE_WHOLESALER_FEEDBACK . " where fkWholesalerID='" . $argId . "' and IsPositive='1') as postiveFeedback, (SELECT count(pkFeedbackID) FROM " . TABLE_WHOLESALER_FEEDBACK . " where fkWholesalerID='" . $argId . "' and IsPositive='0') as negativeFeedback";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function regionName
     *
     * This function is used to get region details.
     *
     * Database Tables used in this function are :  tbl_region
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function regionName($regionID) {
        $arrClms = array('pkRegionID', 'RegionName');
        $where = "pkRegionID = '" . $regionID . "'";
        $arrRes = $this->select(TABLE_REGION, $arrClms, $where);
        return $arrRes;
    }

    /**
     * function sendForgotPasswordEmailWholesaler
     *
     * This function is used to send email for Forgot Password .
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return array boolean
     */
    function sendForgotPasswordEmailWholesaler($argArrPOST) {

        $arrUserFlds = array('pkWholesalerID', 'CompanyName');
        $varUserWhere = "CompanyEmail = '" . stripcslashes($argArrPOST['frmUserEmail']) . "' AND WholesalerStatus = 'active' ";
        //print_r($varUserWhere);exit;
        $arrUserList = $this->select(TABLE_WHOLESALER, $arrUserFlds, $varUserWhere);
        $objTemplate = new EmailTemplate();
        $objCore = new Core();
        if (count($arrUserList) > 0) {


            $varToUser = trim(strip_tags($argArrPOST['frmUserEmail']));
            $better_token = uniqid(md5(rand()), true);
            $this->insWholesalerForgotPWCode($better_token, $varToUser);
            //$varForgotPasswordCode = $objGeneral->getValidRandomKey(TABLE_ADMIN, array('pkAdminID'), 'AdminForgotPWCode', '25');
            //echo $varForgotPasswordCode;die;
            $varForgotPasswordLink = '<a href="' . SITE_ROOT_URL . 'reset_password.php?wid=' . $varToUser . '&code=' . $better_token . '">' . SITE_ROOT_URL . 'reset_password.php?wid=' . $varToUser . '&code=' . $better_token . '</a>';

            $varFromUser = SITE_NAME;
            $name = $arrUserList[0]['CompanyName'];

            $varWhereTemplate = ' EmailTemplateTitle= binary \'Wholesaler forgot password\' AND EmailTemplateStatus = \'Active\' ';

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
            //$objCore->setSuccessMsg('<span>' . FRONT_END_FORGET_PASSWORD_SUCCESS_MSG . '</span>');
            /* echo '<script>parent.window.location.href =  "' . SITE_ROOT_URL . 'index.php";</script>'; */
            die;
        } else {
            echo 0;
            //echo FRONT_END_FORGET_PASSWORD_ERROR_MSG;
        }
    }

    /**
     * function insWholesalerForgotPWCode
     *
     * This function is used Forgot Password request.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return null
     */
    function insWholesalerForgotPWCode($varToken = '', $varEmailId = '') {
        $varWhr = "CompanyEmail = '" . $varEmailId . "' ";

        $arrClmsUpdate = array(
            'WholesalerForgotPWCode' => $varToken,
        );
        $arrUpdateID = $this->update(TABLE_WHOLESALER, $arrClmsUpdate, $varWhr);
    }

    /**
     * function checkWholesalerForgotPWCode
     *
     * This function is used to check Forgot Password code.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRow
     */
    function checkWholesalerForgotPWCode($argArrPOST) {
        $arrUserFlds = array('pkWholesalerID');
        $varUserWhere = " 1 AND CompanyEmail = '" . $argArrPOST['wid'] . "' AND WholesalerForgotPWCode = '" . $argArrPOST['code'] . "' AND WholesalerStatus = 'active' ";
        //print_r($varUserWhere);exit;
        $arrUserList = $this->select(TABLE_WHOLESALER, $arrUserFlds, $varUserWhere);
        $arrRow = count($arrUserList);
        return $arrRow;
    }

    /**
     * function changeWholesalerResetPassword
     *
     * This function is used to change wholesaler Password and send mail to wholesaler.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return array $arrRow
     */
    function changeWholesalerResetPassword($argArrPOST) {
        //print_r($argArrPOST);die;
        $objCore = new Core();
        $varUsersWhere = "CompanyEmail ='" . $argArrPOST['wid'] . "' ";
        $arrColumnAdd = array('CompanyPassword' => md5(trim($argArrPOST['frmNewWholesalerPassword'])));

        $varCustomerID = $this->update(TABLE_WHOLESALER, $arrColumnAdd, $varUsersWhere);
        $arrUserList = $this->select(TABLE_WHOLESALER, array('CompanyName'), $varUsersWhere);


        $objTemplate = new EmailTemplate();
        $objCore = new Core();
        //pre($_SESSION);
        $varUserName = trim(strip_tags($argArrPOST['wid']));
        $varFromUser = SITE_NAME;

        $name = $arrUserList[0]['CompanyName'];

        $varWhereTemplate = " EmailTemplateTitle= 'Send Change Password to Wholesaler' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{NAME}', '{PASSWORD}', '{SITE_NAME}', '{USER_NAME}');

        $varKeywordValues = array($varPathImage, $name, $argArrPOST['frmNewWholesalerPassword'], SITE_NAME, $argArrPOST['wid']);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

        // Calling mail function
//25d55ad283aa400af464c76d713c07ad
        // echo $varOutPutValues;die;
        $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);
        $this->insWholesalerForgotPWCode('', $varUserName);
        //
        //$objCore->setSuccessMsg(FRONT_END_PASSWORD_SUCC_CHANGE);
        return true;
    }

    /**
     * function getInvoiceId
     *
     * This function is used to get invoice by id.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return array $arrRow
     */
    function getInvoiceId($fkSubOrderID = '') {

        $varArr = array('pkInvoiceID', 'InvoiceFileName');

        $varWhere = "fkSubOrderID='" . $fkSubOrderID . "' AND FromUserType='wholesaler'";
        $varTable = TABLE_INVOICE;


        $query = $this->select($varTable, $varArr, $varWhere);
        //pre($query);
        return $query;
    }

    /**
     * function sendInvoiceToTelaMela
     *
     * This function is used to Send invoice to admin.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return array $arrRow
     */
    function sendInvoiceToTelaMela($soID, $wid) {

        global $objCore;
        global $arrProductImageResizes;

        $arrRow = $this->getOrderDetail($soID, $wid);
        //pre($arrRow['product_detail']);die;
        $arrOrderItem = $arrRow['product_detail'];
        $arrOrder = $arrRow['customer_detail'];

        $arrOrderComment = $arrRow['product_comments'];
        $arrOrderTotal = $arrRow['arrOrderTotal'];
        if (count($arrOrder) > 0) {


            //insert invoice in table

            $varCustomerName = $arrOrder['CustomerFirstName'] . '' . $arrOrder['CustomerLastName'];
            $varCustomerEmail = $arrOrder['CustomerEmail'];

            $arrWholesaler = $this->WholesalerDetails($wid);
            $arrCols = array(
                'fkOrderID' => $arrOrder['pkOrderID'],
                'fkSubOrderID' => $arrOrderItem[0]['SubOrderID'],
                'fkWholesalerID' => $arrOrderItem[0]['fkWholesalerID'],
                'FromUserType' => $_SESSION['sessUserInfo']['type'],
                'FromUserID' => $_SESSION['sessUserInfo']['id'],
                'ToUserType' => 'super-admin',
                'ToUserID' => '1',
                'CustomerName' => $varCustomerName,
                'CustomerEmail' => $varCustomerEmail,
                'Amount' => $varTotal,
                'AmountPayable' => $AmountPayable,
                'AmountDue' => $AmountPayable,
                //'TransactionStatus' => 'Pending',
                'TransactionStatus' => $arrOrderItem[0]['Status'],
                'InvoiceDetails' => $varEmailOrderDetails,
                'OrderDateAdded' => $arrOrder['OrderDateAdded'],
                'InvoiceDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $varInvoiceDate = $objCore->serverDateTime($arrCols['InvoiceDateAdded'], DATE_FORMAT_SITE_FRONT);
            $varInvoiceId = $this->insert(TABLE_INVOICE, $arrCols);

            $varEmailOrderDetails = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
     <link rel="shortcut icon" href="' . IMAGES_URL . '/favicon.ico" />
        <title>Wholesaler:Tax Invoice/Statement</title>
        <link rel="shortcut icon" href="' . IMAGE_FRONT_PATH_URL . 'favicon.ico" />
        <link href="' . CSS_PATH . 'invoices.css" rel="stylesheet" />
    </head>
    <body>
        <div class="main-div">
        <div class="no-print print_button"><span onclick="window.print()">Print</span></div>
            <div class="rgt-main-div">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td width="50%">
                            <span class="adr bld f20">Wholesaler</span>
                            <br/>
                            <span class="adr" id="custName">' . $arrWholesaler['CompanyName'] . '</span>
                            <br/>
                            <span class="adr" id="custName">' . $arrWholesaler['CompanyCountryName'] . '</span>
                            <br/>
                        </td>
                        <td width="50%" class="vtop tc" valign="top">
                            <span class="c-name">INVOICE</span>
                        </td>
                    </tr>
                    <tr><td colspan="2"><hr /></td></tr>
                </table>
                <ul>
                    <li class="adr-lft">
                        <span class="bill-to bld">Bill To:</span>
                        <br/>
                        <span class="adr">' . SITE_NAME . '</span>
                        <br/>';
            /*
              <span class="adr">Clients Address</span>
              <br />
              <span class="adr">City, State Zip</span>
              <br/>
              <span class="adr">Country</span>
              <br/> */
            $varEmailOrderDetails .='</li>
                    <li class="adr-rgt">
                        <table cellspacing="0" cellpadding="0" width="100%" class="bill">
                            <tr>
                                <td width="40%" class="lft-txt">
                                    <span class="bld">Invoice#</span>
                                </td>
                                <td>
                                    <span class="span">' . $varInvoiceId . '</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="lft-txt">
                                    <span class="bld">Invoice Date</span>
                                </td>
                                <td>
                                    <span class="span">' . $varInvoiceDate . '</span>
                                </td>
                            </tr>

                        </table>
                    </li>
                </ul>

                <div style="margin-top:30px;float:left;width:99%;">
                    <span class="adr">&nbsp;</span>
                </div>
                <div style="clear:both;">
                </div>
                <div class="lineItemDIV" style="width: 99%">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="column">
                        <tr class="hd">
                            <td><b>Sub Order Id</b></td>
                            <td><b>Item Description</b></td>
                            <td><b>Item Image</b></td>
                            <td><b>Price</b></td>
                            <td><b>Qty</b></td>
                            <td><b>Discount</b></td>
                            <td><b>Sales</b></td>
                            <td><b>Commission</b></td>
                        </tr>';
            $varSubTotal = 0;
            $varShippingSubTotal = 0;
            $varTotal = 0;
            $varAmountPayable = 0;
            $varSubCommision = 0;
            foreach ($arrOrderItem as $item) {

                if ($item['ItemType'] == 'product') {
                    $path = 'products/' . $arrProductImageResizes['default'];
                } else if ($item['ItemType'] == 'package') {
                    $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                } else {
                    $path = 'gift_card';
                }

                $varSrc = $objCore->getImageUrl($item['ItemImage'], $path);

                $varSubTotal = (($item['ItemACPrice'] * $item['Quantity']) + $item['AttributePrice'] - $item['DiscountPrice']);
                $varAmountPayable +=(($item['ItemACPrice'] * $item['Quantity']) - $item['DiscountPrice']);
                $varSubCommision = (($arrWholesaler['Commission'] / 100) * $varSubTotal);
                $varTotal += $varSubCommision;
                $varEmailOrderDetails .= '<tr class="row-item">
                            <td>' . $item['SubOrderID'] . '</td>
                            <td>' . '<b>' . $item['ItemName'] . '</b><br/>' . $item['OptionDet'] . '</td>
                            <td><img src="' . $varSrc . '" alt="' . $item['ItemName'] . '" style="float:none;" /></td>
                            <td>' . number_format(($item['ItemACPrice'] + ($item['AttributePrice'] / $item['Quantity'])), 2, '.', '') . '</td>
                            <td>' . $item['Quantity'] . '</td>
                            <td>' . number_format($item['DiscountPrice'], 2, '.', '') . '</td>
                            <td>' . number_format($varSubTotal, 2, '.', '') . '</td>
                            <td>' . number_format($varSubCommision, 2, '.', '') . '</td>
                        </tr>';
            }

            $varEmailOrderDetails .= '<tr class="tot">
                            <td colspan="6">&nbsp;</td>
                            <td class="total">
                                TOTAL
                            </td>
                            <td>
                                <span class="amount bld">US' . ADMIN_CURRENCY_SYMBOL . number_format($varTotal, 2, '.', '') . '</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>';

            //echo $varEmailOrderDetails;


            $varDir = INVOICE_PATH . 'wholesaler/';
            if (!is_dir($varDir)) {
                mkdir($varDir, 0777);
            }
            $fileName = 'inv_' . $varInvoiceId . '.html';
            $varFileName = $varDir . $fileName;


            $fh = fopen($varFileName, 'w');
            fwrite($fh, $varEmailOrderDetails);
            fclose($fh);


            $AmountPayable = (($arrWholesaler['Commission'] / 100) * $varAmountPayable);

            $arrCols = array(
                'Amount' => $varTotal,
                'AmountPayable' => $AmountPayable,
                'AmountDue' => $AmountPayable,
                'InvoiceFileName' => $fileName
            );

            $varInvoiceId = $this->update(TABLE_INVOICE, $arrCols, "pkInvoiceID='" . $varInvoiceId . "'");


            /*
              $varSubject = 'Order invoice details';
              $varFrom = SITE_NAME;
              $EmailTemplates = $this->SentEmailTemplates();
              $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');

              $varKeywordValues = array($varCustomerName, $varEmailOrderDetails);

              $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

              // Calling mail function
              $objCore->sendMail($varCustomerEmail, $varFrom, $varSubject, $varEmailMessage);

             */

            return 1;
        } else {
            return 0;
        }
    }

    /**
     * function getWholesalerInvoices
     *
     * This function is used to get Invoice List.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
    function getWholesalerInvoices($wid, $limit) {

        global $objCore;

        $varOrderBy = $_POST['sort_by'] ? "{$_POST['sort_by']} ASC " : "InvoiceDateAdded DESC ";
        $varID = " FromUserType = 'wholesaler' AND FromUserID = '" . $wid . "' ";

        if ($_POST['pkInvoiceID'] && $_POST['pkInvoiceID'] != '') {
            $varID.= " AND pkInvoiceID ='" . $objCore->getFormatValue($_POST['pkInvoiceID']) . "'";
        }
        if ($_POST['fkSubOrderID'] && $_POST['fkSubOrderID'] != '') {
            $varID.= " AND fkSubOrderID = '" . $objCore->getFormatValue($_POST['fkSubOrderID']) . "'";
        }
        if ($_POST['OrderStartDate'] && $_POST['OrderStartDate'] != '') {
            $varID.= " AND DATE(OrderDateAdded) >='" . date(DATE_FORMAT_DB, strtotime($objCore->getFormatValue($_POST['OrderStartDate']))) . "'";
        }
        if ($_POST['OrderEndDate'] && $_POST['OrderEndDate'] != '') {
            $varID.= " AND DATE(OrderDateAdded) <= '" . date(DATE_FORMAT_DB, strtotime($objCore->getFormatValue($_POST['OrderEndDate']))) . "'";
        }
        if ($_POST['InvoiceStartDate'] && $_POST['InvoiceStartDate'] != '') {
            $varID.= " AND DATE(InvoiceDateAdded) >= '" . date(DATE_FORMAT_DB, strtotime($objCore->getFormatValue($_POST['InvoiceStartDate']))) . "'";
        }
        if ($_POST['InvoiceEndDate'] && $_POST['InvoiceEndDate'] != '') {
            $varID.= " AND DATE(InvoiceDateAdded) <= '" . date(DATE_FORMAT_DB, strtotime($objCore->getFormatValue($_POST['InvoiceEndDate']))) . "'";
        }
        if ($_POST['AmountPayableStart'] && $_POST['AmountPayableStart'] != '') {
            $varID.= " AND AmountPayable >= '" . $objCore->getFormatValue($_POST['AmountPayableStart']) . "'";
        }
        if ($_POST['AmountPayableEnd'] && $_POST['AmountPayableEnd'] != '') {
            $varID.= " AND AmountPayable <= '" . $objCore->getFormatValue($_POST['AmountPayableEnd']) . "'";
        }
        if ($_POST['TransactionStatus'] && $_POST['TransactionStatus'] != '') {
            $varID.= " AND TransactionStatus = '" . $objCore->getFormatValue($_POST['TransactionStatus']) . "'";
        }

        $query = "SELECT pkInvoiceID,fkOrderID,fkSubOrderID,fkWholesalerID,Amount,AmountPayable,AmountDue,InvoiceFileName,TransactionStatus,OrderDateAdded,InvoiceDateAdded FROM " . TABLE_INVOICE . "  WHERE " . $varID . " ORDER BY " . $varOrderBy . $limit;

        $arrRes = $this->getArrayResult($query);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getInvoiceDetails
     *
     * This function is used get invoice datails for customer.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $arrRes
     */
    function getInvoiceDetails($oid) {
        $arrClms1 = array(
            'pkInvoiceID',
            'fkOrderID',
            'fkSubOrderID',
            'fkWholesalerID',
            'Amount',
            'InvoiceDetails'
        );
        $varTable1 = TABLE_INVOICE;
        $varWhere = " pkInvoiceID = '" . $oid . "'";
        $arrRes = $this->select($varTable1, $arrClms1, $varWhere);
        return $arrRes;
    }

    function getwholesalercountry_id($wid) {
        $arrClms1 = array(
            'CompanyCountry',
        );
        $varTable1 = TABLE_WHOLESALER;
        $varWhere = " pkWholesalerID = '" . $wid . "'";
        $arrRes = $this->select($varTable1, $arrClms1, $varWhere);
        return $arrRes;
    }

    /**
     * function processedProductImageName
     *
     * This function is used get product Image.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $ImageName
     */
    function processedProductImageName($argName) {
        //echo 'test';
        //echo $argName;die;
        $infoExt = pathinfo($argName);
        $arrName = basename($argName, '.' . $infoExt['extension']);
        //$ImageName = preg_replace('/\s\s+/', '_', $arrName);
        $ImageName = date('Ymd_his') . '_' . rand() . '.' . $infoExt['extension'];
        return $ImageName;
    }

    /**
     * function imageUpload
     *
     * This function is used to upload image.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     */
    function imageUpload($argFile) {
        global $arrProductImageResizes;
        //pre($argFile);
        $objCore = new Core();
        $objUpload = new upload();

        $ImageName = $argFile;

        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/products/';

        //pre($varDirLocation);
        // Set Directory
        $objUpload->setDirectory($varDirLocation);
        // CHECKING FILE TYPE.
        $arrValidImg = array("jpg", "jpeg", "gif", "png");
        $arrExt = explode(".", $ImageName);


        $varIsImage = strtolower(end($arrExt));
        //$objUpload->IsImageValid($varDirLocation.$ImageName);

        if (in_array($varIsImage, $arrValidImg)) {
            $varImageExists = 'yes';
        } else {
            $varImageExists = 'no';
            return;
        }


        if ($varImageExists == 'yes') {

            $objUpload->setFileName($ImageName);
            // Start Copy Process
            $objUpload->startCopy();
            // If there is error write the error message
            // resizing the file
            //$objUpload->resize();

            $varFileName = $objUpload->userFileName;


            // Set a thumbnail name

            $thumbnailName = 'original' . '/';
            $objUpload->setThumbnailName($thumbnailName);
            // create thumbnail
            $objUpload->createThumbnail();
            // change thumbnail size
            // $objUpload->setThumbnailSize($width, $height);
            // Set a thumbnail name

            $crop = $arrProductImageResizes['detailHover'] . '/';
            list($width, $height) = explode('x', $arrProductImageResizes['detailHover']);

            $objUpload->setThumbnailName();
            $objUpload->createThumbnail();
            $objUpload->setThumbnailSizeNew($width, $height);

            foreach ($arrProductImageResizes as $key => $val) {
                $thumbnailName = $val . '/';
                list($width, $height) = explode('x', $val);
                $objUpload->setThumbnailName($thumbnailName);
                // create thumbnail
                $objUpload->createThumbnail();
                // change thumbnail size
                $objUpload->setThumbnailSizeNew($width, $height);
            }

            //Get file name from the class public variable
            //Get file extention
            $varExt = substr(strrchr($varFileName, "."), 1);
            $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));
            //Create thumb file name
            $varThumbFileName = $varThumbFileNameNoExt . '.' . $varExt;
            return $varFileName;
        }
    }

    /**
     * function getInvoiceDetails
     *
     * This function is used upload package images.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $arrRes
     */
    function imageUploadPkg($argFile) {


        //pre($argFile);
        $objCore = new Core();
        $objUpload = new upload();

        $ImageName = $argFile;

        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/package/';

        //pre($varDirLocation);
        // Set Directory
        $objUpload->setDirectory($varDirLocation);
        // CHECKING FILE TYPE.
        $arrValidImg = array("jpg", "jpeg", "gif", "png");
        $arrExt = explode(".", $ImageName);


        $varIsImage = strtolower(end($arrExt));
        //$objUpload->IsImageValid($varDirLocation.$ImageName);

        if (in_array($varIsImage, $arrValidImg)) {
            $varImageExists = 'yes';
        } else {
            $varImageExists = 'no';
            return;
        }


        if ($varImageExists == 'yes') {

            $objUpload->setFileName($ImageName);
            // Start Copy Process
            $objUpload->startCopy();
            // If there is error write the error message
            // resizing the file
            $objUpload->resize();

            $varFileName = $objUpload->userFileName;

            // Set a thumbnail name
            // 73x73 and 68x68

            $thumbnailName1 = PACKAGE_IMAGE_RESIZE1 . '/';
            list($width, $height) = explode('x', PACKAGE_IMAGE_RESIZE1);
            $objUpload->setThumbnailName($thumbnailName1);
            // create thumbnail
            $objUpload->createThumbnail();
            // change thumbnail size
            $objUpload->setThumbnailSize($width, $height);


            //Get file name from the class public variable
            //Get file extention
            $varExt = substr(strrchr($varFileName, "."), 1);
            $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));
            //Create thumb file name
            $varThumbFileName = $varThumbFileNameNoExt . '.' . $varExt;
            return $varFileName;
        }
    }

    /**
     * function recursiveRemoveDirectory
     *
     * This function remove all the files in a given directory.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $arrRes
     *
     * User instruction : $objClass->recursiveRemoveDirectory();
     */
    function recursiveRemoveDirectory($directory = null) {
        if (!empty($directory)) {
            foreach (glob("{$directory}/*") as $file) {
                if (is_dir($file)) {
                    $this->recursiveRemoveDirectory($file);
                } else {
                    unlink($file);
                }
            }
        }
    }

    /* function recursiveRemoveDirectory($directory) {
      foreach (glob("{$directory}/*") as $file) {
      if (is_dir($file)) {
      $this->recursiveRemoveDirectory($file);
      } else {
      unlink($file);
      }
      }
      //rmdir($directory);
      } */

    /**
     * function processedPackageProducts
     *
     * This function get the id of the products by using their reference number and returns a array of product IDs in the package.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $tempArr
     *
     * User instruction : $objClass->processedPackageProducts();
     */
    function processedPackageProducts($argProductsReferenceNumbers) {
        $arrProductsReferenceNumbers = explode("|", $argProductsReferenceNumbers);
        $tempArr = array();
        $i = 0;
        foreach ($arrProductsReferenceNumbers AS $productsReferenceNumbers) {
            $arrClms = array('pkProductID');
            $varID = "TRIM(ProductRefNo)='" . trim($productsReferenceNumbers) . "'";
            $varTable = TABLE_PRODUCT;
            $arrRes = $this->select($varTable, $arrClms, $varID);
            if (!empty($arrRes[0]['pkProductID'])) {
                $tempArr[$i++] = $arrRes[0]['pkProductID'];
            }
        }
        unset($i);
        return $tempArr;
    }

    /**
     * function processedPackageProductsPrice
     *
     * This function get the package price of the products by using their reference number and returns a array of product IDs in the package.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return price $totalPrice
     *
     * User instruction : $objClass->processedPackageProductsPrice();
     */
    function processedPackageProductsPrice($argProductsReferenceNumbers) {
        $arrProductsReferenceNumbers = explode("|", $argProductsReferenceNumbers);
        $tempArr = array();
        $i = 0;
        $totalPrice = 0;
        foreach ($arrProductsReferenceNumbers AS $productsReferenceNumbers) {
            $arrClms = array('FinalPrice');
            $varID = "TRIM(ProductRefNo)='" . trim($productsReferenceNumbers) . "'";
            $varTable = TABLE_PRODUCT;
            $arrRes = $this->select($varTable, $arrClms, $varID);
            if (!empty($arrRes[0]['FinalPrice'])) {
                $totalPrice = $totalPrice + $arrRes[0]['FinalPrice'];
            }
        }
        unset($i);
        return $totalPrice;
    }

    /**
     * function findPackage
     *
     * This function return the package id of a given package name .
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return ID $pkPackageId
     *
     * User instruction : $objClass->findPackage();
     */
    function findPackage($argPackageName) {
        $arrClms = array('pkPackageId');
        $varID = "TRIM(PackageName)='" . trim($argPackageName) . "'";
        $varTable = TABLE_PACKAGE;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['pkPackageId'];
    }

    /**
     * function getEvent
     *
     * This function is used to retrive country List.
     *
     * Database Tables used in this function are :  tbl_festival
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getEvent($countryId = 0) {
        global $objCore;
        $arrClms = array(
            'pkFestivalID',
            'FestivalTitle',
        );

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

        $varWhr = " (FIND_IN_SET('" . $countryId . "',CountryIDs) OR CountryIDs='0') AND FestivalStatus='1' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate >='" . $curDate . "' ";
        $varOrderBy = 'FestivalTitle ASC ';
        $arrRes = $this->select(TABLE_FESTIVAL, $arrClms, $varWhr, $varOrderBy);
        return $arrRes;
    }

    /**
     * function getEventDate
     *
     * This function is used to retrive getEventDate.
     *
     * Database Tables used in this function are :  tbl_festival
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getEventDate($bannerId = 0) {
        $arrClms = array(
            'FestivalStartDate',
            'FestivalEndDate'
        );
        $varWhr = "pkFestivalID= '" . $bannerId . "' AND FestivalStatus='1'";

        $arrRes = $this->select(TABLE_FESTIVAL, $arrClms, $varWhr);
        return $arrRes[0];
    }

    /**
     * function getEventCategory
     *
     * This function is used to retrive getEventDate.
     *
     * Database Tables used in this function are :  tbl_festival, tbl_category
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    function getEventCategory($bannerId = 0) {
        $arrClms = array(
            'CategoryIDs'
        );

        $varWhr = "pkFestivalID= '" . $bannerId . "' AND FestivalStatus='1'";
        $arrRes = $this->select(TABLE_FESTIVAL, $arrClms, $varWhr);
        $arrCat = array();
        if ($arrRes[0]['CategoryIDs'] == 0 || $arrRes[0]['CategoryIDs'] > 0) {
            $arrClms = array(
                'CategoryParentId',
                'pkCategoryId',
                'CategoryName',
                'CategoryLevel'
            );
            if ($arrRes[0]['CategoryIDs'] == 0) {
                $varWhr = "CategoryStatus='1'";
            } else {
                $varWhr = "CategoryStatus='1' AND CategoryIsDeleted='0' AND (pkCategoryId IN (" . $arrRes[0]['CategoryIDs'] . ")";
            }

            $arrCt = explode(',', $arrRes[0]['CategoryIDs']);

            foreach ($arrCt as $v) {

                $varWhr .= " OR CategoryHierarchy Like '" . $v . ":%'";
            }
            if ($arrRes[0]['CategoryIDs'] > 0) {
                $varWhr .=")";
            }


            $arrRows = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);

            foreach ($arrRows as $v) {
                $arrCat[$v['CategoryParentId']][] = array('pkCategoryId' => $v['pkCategoryId'], 'CategoryName' => $v['CategoryName'], 'CategoryHierarchy' => $v['CategoryHierarchy'], 'CategoryLevel' => $v['CategoryLevel']);
            }
        }


        return $arrCat;
    }

    /**
     * function addApplicationForm
     *
     * This function is used to add Special Application Form.
     *
     * Database Tables used in this function are :  tbl_special_application,tbl_special_application_to_category
     *
     * @access public
     *
     * @parameters 2 array string
     *
     * @return string
     */
    function addApplicationForm($arrPost, $wid) {
        global $objCore;
        global $objGeneral;

        $arrSetting = $objGeneral->getSetting();


        foreach ($arrPost['frmCountry'] as $key => $val) {

            $varTotalAmount = 0;


            $varTotalAmount +=$arrSetting['SpecialApplicationPrice']['SettingValue'];

            foreach ($arrPost['frmCategory'][$key] as $k => $v) {
                $catQty++;
                $proQty += (int) $arrPost['frmProductQty'][$key][$k];
            }

            $varTotalAmount += $arrSetting['SpecialApplicationCategoryPrice']['SettingValue'] * $catQty;
            $varTotalAmount += $arrSetting['SpecialApplicationProductPrice']['SettingValue'] * $proQty;

            $arrClms = array(
                'fkWholesalerID' => $wid,
                'fkFestivalID' => $arrPost['frmEvent'][$key],
                'fkCountryID' => $val,
                'TotalAmount' => $varTotalAmount,
                'ApplicatonDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );


            $insertId = $this->insert(TABLE_SPECIAL_APPLICATION, $arrClms);
            if ($insertId > 0) {
                foreach ($arrPost['frmCategory'][$key] as $k => $v) {
                    $arrClms = array(
                        'fkApplicationID' => $insertId,
                        'fkCategoryID' => $v,
                        'ProductQty' => $arrPost['frmProductQty'][$key][$k]
                    );

                    $this->insert(TABLE_SPECIAL_APPLICATION_TO_CATEGORY, $arrClms);
                }
            }
            $arrRes[] = $insertId;
        }

        $ids = implode(',', $arrRes);
        return $ids;
    }

    /**
     * function updateApplicationPayment
     *
     * This function is used to update Application Payment after payment.
     *
     * Database Tables used in this function are :  tbl_special_application
     *
     * @access public
     *
     * @parameters 2 array string
     *
     * @return string
     */
    function updateApplicationPayment($ApplicationIds, $txn_id, $payment_amount) {

        $arrData = explode(',', $ApplicationIds);

        foreach ($arrData as $key => $val) {
            $varWhr = "pkApplicationID='" . $val . "'";

            $arrClms = array(
                'TransactionID' => $txn_id,
                'TransactionAmount' => $payment_amount,
                'IsPaid' => 1
            );

            $this->update(TABLE_SPECIAL_APPLICATION, $arrClms, $varWhr);
        }
    }

    /**
     * function getSpecialEvents
     *
     * This function is used to get recipient List.
     *
     * Database Tables used in this function are : tbl_special_application, tbl_special_application_to_category, tbl_festival, tbl_special_product
     *
     * @access public
     *
     * @parameters 0
     *
     * @return $arrRes
     */
    function getSpecialEvents($cid, $wid) {
        global $objCore;

        $arrClms = "pkApplicationID,sa.fkFestivalID,sum(ProductQty) as ProductQty,fkCountryID,FestivalTitle";
        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

        $varWhr = "fkWholesalerID = '" . $wid . "' AND " . "fkCategoryID ='" . $cid . "' AND IsPaid='1' AND IsApproved='Approved' AND FestivalStatus='1' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "'";
        $varTable = TABLE_SPECIAL_APPLICATION . " as sa INNER JOIN " . TABLE_SPECIAL_APPLICATION_TO_CATEGORY . " ON pkApplicationID = fkApplicationID LEFT JOIN " . TABLE_FESTIVAL . " ON sa.fkFestivalID = pkFestivalID ";

        $varQuery = "Select " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhr . " GROUP BY pkApplicationID";
        $arrRows = $this->getArrayResult($varQuery);

        $varQuery = "Select count(pkSpecialID) as usedQty,pkApplicationID FROM " . TABLE_SPECIAL_PRODUCT . " as sp INNER JOIN " . TABLE_SPECIAL_APPLICATION . " as sa ON sp.fkFestivalID=sa.fkFestivalID WHERE sp.fkCategoryID = '" . $cid . "' AND sp.fkWholesalerID='" . $wid . "' AND IsPaid='1' AND IsApproved='Approved' GROUP BY pkApplicationID";
        $arrRows1 = $this->getArrayResult($varQuery);

        //echo "<pre>";
        //print_r($arrRows);
        //print_r($arrRows1);
        //die;

        $arrRes1 = array();
        foreach ($arrRows1 as $k => $v) {
            $arrRes1[$v['pkApplicationID']] = $v['usedQty'];
        }
        //pre($arrRes1);

        foreach ($arrRows as $k => $v) {
            $arrRows[$k]['ProductQty'] = (int) $v['ProductQty'] - (int) $arrRes1[$v['pkApplicationID']];
            //echo $arrRows[$k]['ProductQty'];die;

            if ($arrRows[$k]['ProductQty'] <= 0) {
                unset($arrRows[$k]);
            } else if (((int) $arrRes1[$v['pkApplicationID']] == (int) $v['ProductQty']) && (int) $arrRes1[$v['pkApplicationID']] == 1) {
                return $arrRows;
            }
        }
        //pre($arrRows);
        return $arrRows;
    }

    /**
     * function getSpecialProductDetails
     *
     * This function is used to get recipient List.
     *
     * Database Tables used in this function are : tbl_special_product
     *
     * @access public
     *
     * @parameters 0
     *
     * @return $arrRes
     */
    function getSpecialProductDetails($pid) {
        global $objCore;

        $arrClms = "fkProductID,fkFestivalID,SpecialPrice,FinalSpecialPrice";

        $varWhr = "fkProductID = '" . $pid . "' ";
        $varTable = TABLE_SPECIAL_PRODUCT;

        $varQuery = "Select " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhr;
        $arrRows = $this->getArrayResult($varQuery);

        return $arrRows[0];
    }

    /**
     * function wholesalerSpecialList
     *
     * This function is used to retrive special aplication history.
     *
     * Database Tables used in this function are : tbl_special_application_to_category, tbl_special_application, tbl_category
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
//    function wholesalerSpecialList($wid, $limit)
//    {
//        $oderColumn = $_POST['sort_column'] ? $_POST['sort_column'] : 'pkApplicationID';
//        $oderDir = $_POST['sort_order'] ? $_POST['sort_order'] : 'DESC';
//        $varOrderBy = 'ORDER BY ' . $oderColumn . ' ' . $oderDir;
//
//        $varLimit = ($limit <> '') ? ' LIMIT ' . $limit : '';
//
//        $varSql = "SELECT fkWholesalerID,pkApplicationID,TotalAmount,IsPaid,IsApproved,fkCategoryID,CategoryName,ProductQty FROM " . TABLE_SPECIAL_APPLICATION_TO_CATEGORY . " INNER JOIN " . TABLE_SPECIAL_APPLICATION . " ON pkApplicationID = fkApplicationID LEFT JOIN " . TABLE_CATEGORY . " ON fkCategoryID=pkCategoryID WHERE fkWholesalerID='" . $wid . "' AND IsPaid='1' " . $varOrderBy . " " . $varLimit;
//        $arrRes = $this->getArrayResult($varSql);
//
//        //pre($arrRes);
//        return $arrRes;
//    }

    function wholesalerSpecialList($wid = '', $limit = '') {
        $where = '';
        if (isset($_POST['frmHidden']) && (string) $_POST['frmHidden'] == 'search') {
            if ($_POST['frmFestivalTitle'] != '') {
                $where.=" AND FestivalTitle like '%" . $_POST['frmFestivalTitle'] . "%'";
            }
            if ($_POST['fkCountryID'] != 'Select Country') {
                $where.=" AND fkCountryID='" . $_POST['fkCountryID'] . "'";
            }
            if ($_POST['IsApproved'] != 'Select Status') {
                $where.=" AND IsApproved='" . $_POST['IsApproved'] . "'";
            }
            //echo $where;
            //pre($_POST);
        }
        $oderColumn = $_POST['sort_column'] ? $_POST['sort_column'] : 'pkApplicationID';
        $oderDir = $_POST['sort_order'] ? $_POST['sort_order'] : 'DESC';
        $varOrderBy = $oderColumn . ' ' . $oderDir;

        $varLimit = ($limit <> '') ? ' LIMIT ' . $limit : '';


        // WHERE fkWholesalerID='5' AND IsPaid='1' order by pkApplicationID DESC
        $varSql = "SELECT ApplicatonDateAdded,pkFestivalID,FestivalStartDate,FestivalEndDate,CompanyName,CompanyEmail,FestivalTitle,name as CountryName,fkCategoryID,CategoryName,TransactionID,TransactionAmount,fkWholesalerID,pkApplicationID,TotalAmount,IsPaid,IsApproved,ProductQty FROM tbl_special_application_to_category INNER JOIN tbl_special_application sa ON pkApplicationID = fkApplicationID LEFT JOIN tbl_category ON fkCategoryID=pkCategoryID LEFT JOIN tbl_festival ON sa.fkFestivalID = pkFestivalID LEFT JOIN tbl_wholesaler ON fkWholesalerID = pkWholesalerID LEFT JOIN tbl_country ON fkCountryID=country_id WHERE fkWholesalerID='" . $wid . "' $where AND IsPaid='1'  order by " . $varOrderBy . " " . $varLimit;
        $arrRes = $this->getArrayResult($varSql);
        // pre($arrRes);
//        $arrClms = "pkApplicationID,fkWholesalerID,sa.fkFestivalID,fkCountryID,TotalAmount,TransactionID,TransactionAmount,IsPaid,ProductQty,IsApproved,ApplicatonDateAdded,FestivalStartDate,FestivalEndDate,CompanyName,CompanyEmail,FestivalTitle,name as CountryName,fkCategoryID,CategoryName";
//         echo $varSql = "SELECT fkWholesalerID,pkApplicationID,TotalAmount,IsPaid,IsApproved,fkCategoryID,CategoryName,ProductQty FROM " . TABLE_SPECIAL_APPLICATION_TO_CATEGORY . " INNER JOIN " . TABLE_SPECIAL_APPLICATION . " ON pkApplicationID = fkApplicationID LEFT JOIN " . TABLE_CATEGORY . " ON fkCategoryID=pkCategoryID WHERE fkWholesalerID='" . $wid . "' AND IsPaid='1' " . $varOrderBy . " " . $varLimit;  
//        $varWhr = "fkWholesalerID='" . $wid . "' AND IsPaid='1' $where";
//        $argLimit = ($varLimit <> '') ? $varLimit : '';
//        $varOrder = $varOrderBy;
//        $varTable = TABLE_SPECIAL_APPLICATION . " as sa LEFT JOIN " . TABLE_FESTIVAL . " ON sa.fkFestivalID = pkFestivalID LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID LEFT JOIN " . TABLE_COUNTRY . " ON fkCountryID=country_id LEFT JOIN " . TABLE_CATEGORY . " ON sa.fkFestivalID=pkCategoryID INNER JOIN " . TABLE_SPECIAL_APPLICATION_TO_CATEGORY . " ON pkApplicationID = fkApplicationID";
//       
//        $varQuery = "Select " . $arrClms . " FROM " . $varTable . " WHERE 1 1  " . $varWhr . " ORDER BY " . $varOrder . $argLimit;
//        $arrRes = $this->getArrayResult($varQuery);
//        pre($arrRes);
        return $arrRes;
    }

    /**
     * function getQuickViewMethods
     *
     * This function is used to retrive special aplication history.
     *
     * Database Tables used in this function are :  tbl_shipping_method, tbl_shipping_gateways, tbl_shipping_gateways_pricelist
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
    function getQuickViewMethods($sgid = 0) {

        $varSql = "SELECT pkShippingGatewaysID,ShippingTitle,pkShippingMethod,fkShippingGatewayID,MethodName, MethodCode FROM " . TABLE_SHIPPING_GATEWAYS . " INNER JOIN " . TABLE_SHIPPING_METHOD . " ON pkShippingGatewaysID = fkShippingGatewayID WHERE pkShippingGatewaysID = '" . $sgid . "' AND ShippingType='admin' ";
        $arrRes = $this->getArrayResult($varSql);
        $arrRows['ShippingTitle'] = $arrRes['0']['ShippingTitle'];
        foreach ($arrRes as $key => $val) {
            $varSql = "SELECT Weight,ZoneA,ZoneB, ZoneC,ZoneD,ZoneE,ZoneF,ZoneG,ZoneH,ZoneI,ZoneJ,ZoneK FROM " . TABLE_SHIPPING_GATEWAYS_PRICELIST . " WHERE fkShippingMethodID = '" . $val['pkShippingMethod'] . "' ";
            $arrR = $this->getArrayResult($varSql);

            if (count($arrR) > 0) {

                $arrRows['methods'][$key]['MethodName'] = $val['MethodName'];
                $arrRows['methods'][$key]['MethodCode'] = $val['MethodCode'];
                $arrRows['methods'][$key]['methodsPrice'] = $arrR;
            }
        }

        //pre($arrRows);
        return $arrRows;
    }

    /**
     * function getZoneCountry
     *
     * This function is used to remove the shipping.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 0
     *
     * @return true
     *
     * User instruction: $objShippingGateway->getZoneCountry()
     */
    function getZoneCountry() {

        $varQuery = "SELECT zone,group_concat(' ',name) as Countries FROM " . TABLE_COUNTRY . " WHERE status='1' AND zone!='' GROUP BY(zone) ASC";

        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function reviewsDone
     *
     * This function is used to decease the notification for review section.
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
    function reviewsDone($rid = '', $pid = '') {
        $arrUpdate = array('ReviewWholesaler' => 1);
        $whrReviewUpdate = "fkProductID='" . (int) $pid . "'";
        $qryUpdate = $this->update(TABLE_REVIEW, $arrUpdate, $whrReviewUpdate);
        return $qryUpdate;
    }

    /**
     * function varifyDuplicatePackage
     *
     * This function is used to decease the notification for review section.
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
    function varifyDuplicatePackage($where = '') {
        $table = TABLE_PACKAGE;
        $array = array('pkPackageId');
        $varifyDuplicatePackage = $this->select($table, $array, $where);
        if (count($varifyDuplicatePackage) > 0) {
            return 1;
        } else {
            return 2;
        }
    }

    /**
     * function changeWholesalerResetPassword2
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
    function changeWholesalerResetPassword2($argArrPOST) {
        $objCore = new Core();
        $varUsersWhere = "pkWholesalerID ='" . $_SESSION['sessUserInfo']['id'] . "' ";
        $arrColumnAdd = array('CompanyPassword' => md5(trim($argArrPOST['frmNewCustomerPassword'])));

        $varCustomerID = $this->update(TABLE_WHOLESALER, $arrColumnAdd, $varUsersWhere);
        $arrUserList = $this->select(TABLE_WHOLESALER, array('CompanyName'), $varUsersWhere);


        $objTemplate = new EmailTemplate();
        $objCore = new Core();
        //pre($_SESSION);
        $varUserName = trim($_SESSION['sessUserInfo']['email']);
        $varFromUser = SITE_NAME;

        $name = $arrUserList[0]['CompanyName'];

        $varWhereTemplate = " EmailTemplateTitle= 'Send Change Password to Wholesaler' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{NAME}', '{PASSWORD}', '{SITE_NAME}', '{USER_NAME}');

        $varKeywordValues = array($varPathImage, $name, $argArrPOST['frmNewCustomerPassword'], SITE_NAME, $argArrPOST['wid']);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

        // Calling mail function


        $objCore->sendMail($varUserName, $varFromUser, $varSubject, $varOutPutValues);
        $this->insWholesalerForgotPWCode('', $varUserName);
        //
        //$objCore->setSuccessMsg(FRONT_END_PASSWORD_SUCC_CHANGE);
        return true;
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
    public function varifyCurrentPassword($pass) {
        $arr = array('pkWholesalerID');
        $where = "CompanyPassword='" . md5($pass) . "' and pkWholesalerID='" . $_SESSION['sessUserInfo']['id'] . "'";
        $varifyCurrentP = $this->select(TABLE_WHOLESALER, $arr, $where);
        if (count($varifyCurrentP) > 0) {
            return 1;
        } else {
            return 2;
        }
    }

    public function removeShipp($shipId = 0) {

        $arr = array('pkProductID', 'fkShippingID');
        $where = "fkShippingID like '%" . $shipId . "%' and fkWholesalerID='" . $_SESSION['sessUserInfo']['id'] . "'";
        $varifyCurrentP = $this->select(TABLE_PRODUCT, $arr, $where);
        if (count($varifyCurrentP) > 0) {
            foreach ($varifyCurrentP as $key => $value) {
                $update = strtr($value['fkShippingID'], array('' . $shipId . ',' => '', ',' . $shipId . '' => '', '' . $shipId . '' => ''));
                $arr2 = array('fkShippingID' => $update);
                $where2 = "pkProductID ='" . $value['pkProductID'] . "' and fkWholesalerID='" . $_SESSION['sessUserInfo']['id'] . "'";
                $this->update(TABLE_PRODUCT, $arr2, $where2);
            }
        }
    }

    /**
     * function getAttributeId
     *
     * This function is used to get Attribute Id .
     *
     * Database Tables used in this function are : tbl_attribute_to_category, tbl_attribute
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function getPackageAttributeId($attributeCode) {
        $arrClms = array('pkAttributeID');
        $varID = " AttributeCode='" . $attributeCode . "'";
        $varTable = TABLE_ATTRIBUTE;
        $arrRes = $this->select($varTable, $arrClms, $varID);

        return $arrRes[0];
    }

    /**
     * function getAttributeId
     *
     * This function is used to get Attribute Id .
     *
     * Database Tables used in this function are : tbl_attribute_to_category, tbl_attribute
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string
     */
    function getPackageAttributeOptionId($attributeId, $optionTitle) {
        $arrClms = array('pkOptionID');
        $varID = " fkAttributeId='" . $attributeId['pkAttributeID'] . "' AND OptionTitle='" . $optionTitle . "'";
        $varTable = TABLE_ATTRIBUTE_OPTION;
        $arrRes = $this->select($varTable, $arrClms, $varID);

        return $arrRes[0];
    }

    function categoryLatestPoducts($wid, $arrMainCat) {

        $arrRow = array();
        //pre($arrMainCat);
        //echo $wid;

        foreach ($arrMainCat as $key => $val) {
            //pre($val);
            ////pre($val[$key]['pkCategoryId']);
            //$categoryIds= is_array($val['pkCategoryId'])?$val['pkCategoryId']:$val;
            $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,IF(sum(atInv.OptionQuantity)>0,sum(atInv.OptionQuantity),Quantity) as Quantity,discountPercent,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
          FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = product.fkCategoryID AND (CategoryHierarchy like'" . $val['pkCategoryId'] . ":%' OR CategoryHierarchy ='" . $val['pkCategoryId'] . "') AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1') INNER JOIN " . TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active' AND product.fkWholesalerID='{$wid}') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_PRODUCT_OPTION_INVENTORY . " as atInv ON pkProductID = atInv.fkProductID
          Group By pkProductID  ORDER BY pkProductID DESC
          limit 0,12";
            //Create memcache object
            global $oCache;
            //Create object key for cache object
            $varQueryKey = md5($varQuery);
            //Check memcache is enabled or not
            if ($oCache->bEnabled) { // if Memcache enabled
                if (!$oCache->getData($varQueryKey)) {
                    $arrRes = $this->getArrayResult($varQuery);
                    $oCache->setData($varQueryKey, serialize($arrRes));
                } else {
                    $arrRes = unserialize($oCache->getData($varQueryKey));
                }
            } else {
                $arrRes = $this->getArrayResult($varQuery);
            }

            if ($arrRes) {
                $arrRow[$val['pkCategoryId']]['arrCategory'] = $val;
                $arrRow[$val['pkCategoryId']]['arrProducts'] = $arrRes;
            }
        }

        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function getTopSellingProducts
     *
     * This function is used to get Top Selling Products Details.
     *
     * Database Tables used in this function are : tbl_product, tbl_order_items, tbl_category, tbl_wholesaler, tbl_product_to_option, tbl_product_rating
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getTopSellingProducts($wid, $todayOfferProduct) {
        global $objCore;

        $dateAfter = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
        $varQuery = "SELECT p.Sold,p.pkProductID,sum(oi.Quantity) as pnum,p.ProductRefNo,p.ProductName,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,p.FinalPrice,FinalSpecialPrice,p.DiscountFinalPrice,discountPercent,p.Quantity,p.ProductDescription,p.ProductDateAdded,p.ProductImage
            FROM " . TABLE_PRODUCT . " as p LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID
                INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON  (pkProductID = fkItemID AND ItemDateAdded<= '" . $dateAfter . "' AND ItemType='product')
                    INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1')
                        INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active' AND p.fkWholesalerID='{$wid}')
                            LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON p.pkProductID = pto.fkProductId
                                
            Group By pkProductID HAVING p.Sold>1 ORDER BY p.Sold DESC
            limit 0,12";

        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
    }

    /**
     * function getAllHotDeals
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
    public function getAllHotDeals($wid, $arrMainCat) {
        //get category wise product
        //$arrMainCat all parent category array
        //pre($arrMainCat);
        foreach ($arrMainCat as $key => $val) {
            $tableDiscounted = TABLE_PRODUCT . " as product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_WHOLESALER . "  ON  ( product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active' AND product.fkWholesalerID='{$wid}') INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID";
            $arrDiscountedClms = array('pkProductID', 'Quantity', 'ProductName', 'FinalPrice', 'FinalSpecialPrice', 'DiscountFinalPrice', 'ProductImage', 'discountPercent');
            $whereDiscounted = "product.ProductStatus='1' AND floor( (FinalPrice - DiscountFinalPrice) / FinalPrice *100 ) >20 AND floor( (FinalPrice - DiscountFinalPrice) / FinalPrice *100 ) <=99 AND (CategoryHierarchy like'" . $val['pkCategoryId'] . ":%' OR CategoryHierarchy ='" . $val['pkCategoryId'] . "')";
            $orderDiscounted = "discountPercent DESC limit 10";
            $getDiscountedData = $this->select($tableDiscounted, $arrDiscountedClms, $whereDiscounted, $orderDiscounted);
            if ($getDiscountedData) {
                $arrRow[$val['pkCategoryId']]['arrCategory'] = $val;
                $arrRow[$val['pkCategoryId']]['arrProducts'] = $getDiscountedData;
            }
        }
        return $arrRow;
    }

    /**
     * function wholeSalerSoldItems
     *
     * This function is used to get sold items count.
     *
     * Database Tables used in this function are : tbl_order_items
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     * 
     * @author : Krishna Gupta
     * 
     * @Created : 27-10-2015
     */
    public function wholeSalerSoldItems($wholeSalerId) {
        $condition = '(Status = "Completed" OR Status = "Pending") AND DisputedStatus != "Disputed" AND fkWholesalerID = ' . $wholeSalerId;
        $varQuery = " select count(*) as soldItems from tbl_order_items where " . $condition;
        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
    }

    /**
     * function wholeSalerPositiveFeedback
     *
     * This function is used to get sold items count.
     *
     * Database Tables used in this function are : tbl_wholesaler_feedback
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     *
     * @author : Krishna Gupta
     *
     * @Created : 27-10-2015
     */
    public function wholeSalerPositiveFeedback($wholeSalerId) {
        $varQuery = " select count(*) as positiveFeedback from tbl_wholesaler_feedback where IsPositive = 1 AND fkWholesalerID = " . $wholeSalerId;
        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
    }

    /**
     * function wholeSalerPositiveFeedback
     *
     * This function is used to get sold items count.
     *
     * Database Tables used in this function are : tbl_wholesaler_feedback
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     *
     * @author : Krishna Gupta
     *
     * @Created : 27-10-2015
     */
    public function wholeSalerNegativeFeedback($wholeSalerId) {
        $varQuery = " select count(*) as negativeFeedback from tbl_wholesaler_feedback where IsPositive = 0 AND fkWholesalerID = " . $wholeSalerId;
        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
    }

    /**
     * function getNewsletterRecipientList
     *
     * This function is used to view the newsLetter Recipient List .
     *
     * Database Tables used in this function are : tbl_newsletters_recipient, tbl_customer, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $ObjNewsLetter->getNewsletterRecipientList($_argNewsLetterID)
     */
    function getNewsletterRecipientList($_argNewsLetterID) {
        $arrClms2 = array('SendTo', 'CustomerFirstName', 'CustomerEmail', 'CompanyName', 'CompanyEmail');
        $argWhere2 = "fkNewsLetterID = '" . $_argNewsLetterID . "' AND IsDelivered='0' ";
        $varOrderBy3 = " pkSendID ";
        $varTable2 = TABLE_NEWSLETTER_RECEPIENT . " LEFT JOIN " . TABLE_CUSTOMER . " ON SendToID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON SendToID = pkWholesalerID";
        $arrRes = $this->select($varTable2, $arrClms2, $argWhere2, $varOrderBy3);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function CheckExistancyOfPackage
     *
     * This function is used to to check that new package is already existing or not.
     *
     * Database Tables used in this function are : tbl_package_product_attribute_option
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return boolean
     *
     * User instruction: $objWholesaler->CheckExistancyOfPackage($condition, $count)
     * 
     * @author : Krishna Gupta
     * 
     * @created : 29-10-2015
     * 
     * @Modified : 05-11-2015
     */
    function CheckExistancyOfPackage($ids, $count, $action) {
        if ($action == 'add') {
            $cond = $ids;
        } else {
            $cond = $ids . ' AND fkPackageId != ' . $_REQUEST['pkid'];
        }
        //tbl_product_to_package
        $varQuery = "SELECT group_concat(fkProductId) as productId, count(fkProductId) as total,fkPackageId FROM `tbl_product_to_package` group by fkPackageId HAVING 1=1 AND " . $cond;
        //$varQuery = "SELECT group_concat(productId), count(productId) as total,packageId FROM `tbl_package_product_attribute_option` group by packageId HAVING 1=1 AND " . $ids;
        $arrRes = $this->getArrayResult($varQuery);


        foreach ($arrRes as $data) {
            //pre($data);
            if ($data['total'] == $count) {
                return true;
            }
        }
        return false;
    }

}

?>
