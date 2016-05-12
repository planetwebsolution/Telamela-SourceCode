<?php

/* * ****************************************

  Module name : AdminLogin

  Parent module : None

  Date created : 17th January 2008

  Date last modified : 17th January 2008

  Author : Vivek Avasthi

  Last modified by : Vivek Avasthi

  Comments : The AdminLogin class is used to maintain admin login system.

 * **************************************** */

class AdminLogin extends Database {
    /*     * ****************************************

      Function name : AdminLogin

      Return type : none

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author : Vivek Avasthi

      Last modified by : Vivek Avasthi

      Comments : Constructor of AdminLogin class. It is automatically call when object is created.

      User instruction : $objAdminLogin = new AdminLogin();

     * **************************************** */

    function AdminLogin() {

        //default constructor
    }

    /*     * ****************************************

      Function Name : doLogin

      Return type : none

      Date created : 7th January 2008

      Date last modified : 7th January 2008

      Author : Vivek Avasthi

      Last modified by : Vivek Avasthi

      Comments : This function is used to check admin login.

      User instruction : $objAdminLogin->doLogin();

     * **************************************** */

    function doAdminLogin($argArrPOST) {

        $objCore = new Core();

        if (isset($argArrPOST)) {

            $varAdminUserName = $argArrPOST['frmAdminUserName'];

            $varAdminPassword = md5($argArrPOST['frmAdminPassword']);

            //*** if errro in server side scripting

            $varReturnValue = $this->getLoginValidation($argArrPOST);

            if (!$varReturnValue) {

                return false;
            }

            //*** check in database for username & Password encode(binary('".$varPassword."'),'vinove')
            //$varWhereCondition = " AND AdminUserName = binary '".$varAdminUserName."' AND AdminPassword = encode(binary ('".$varAdminPassword."'), 'vinove')";

            $varWhereCondition = " AND (AdminUserName = binary '" . addslashes($varAdminUserName) . "' OR AdminEmail = binary '" . addslashes($varAdminUserName) . "') AND AdminPassword = binary ('" . addslashes($varAdminPassword) . "')";




            $varResult = $this->getAdminNumRows($varWhereCondition);


            //** check that user is exists or not

            if ($varResult > 0) {

                $arrClmn = array('pkAdminID', 'AdminUserStatus', 'AdminLastLoginIPAddress');

                $arrAdmin = $this->getAdminInfo($varWhereCondition);
                //pre($arrAdmin);
                $varAdminWholesalers = $this->getAdminWholesalers($arrAdmin[0]['pkAdminID']);
                $varAdminLogisticPoetal = $this->getAdminLogisticUser($arrAdmin[0]['pkAdminID']);
                //pre($varAdminLogisticPoetal);
                // CHECK FOR INACTIVE MODERATORS.

                if ($arrAdmin[0]['AdminUserStatus'] == 'Inactive') {

                    $objCore->setErrorMsg(ADMIN_MODERATOR_INACTIVE_LOGIN);

                    header('location:' . SITE_ROOT_URL . 'admin/index.php');

                    exit;
                }

                // ------------- END OF CHECK----------------

                $_SESSION['sessUser'] = $arrAdmin[0]['pkAdminID'];

                if ($_SESSION['sessUser'] != 0) {
                    $_SESSION['sessAdminUserName'] = $varAdminUserName;

                    $_SESSION['sessAdminPassword'] = md5($varAdminPassword);
                    $_SESSION['sessAdminTitle'] = $arrAdmin[0]['AdminTitle'];
                    $_SESSION['sessAdminEmail'] = $arrAdmin[0]['AdminEmail'];
                    $_SESSION['sessAdminCountry'] = $arrAdmin[0]['AdminCountry'];
                    $_SESSION['sessAdminRegion'] = $arrAdmin[0]['AdminRegion'];
                    $_SESSION['sessAdminTimeZone'] = $arrAdmin[0]['time_zone'];

                    $_SESSION['sessAdminLastLogin'] = $arrAdmin[0]['AdminLastLogin'];

                    $_SESSION['sessAdminLastLoginIP'] = $arrAdmin[0]['AdminLastLoginIPAddress'];

                    $_SESSION['sessAdminPageLimit'] = $arrAdmin[0]['AdminPageLimit'];

                    $_SESSION['sessAdminRoleName'] = $arrAdmin[0]['AdminRoleName'];
                    $_SESSION['sessUserType'] = $arrAdmin[0]['AdminType'];

                    $_SESSION['sessAdminPerMission'] = explode(',', $arrAdmin[0]['AdminRolePermission']);
                    $_SESSION['sessAdminWholesalerIDs'] = $varAdminWholesalers;
                    $_SESSION['sessAdminlogisticIDs'] = $varAdminLogisticPoetal;
                    //** insert entry for last login data

                    $varIpAddress = $_SERVER['REMOTE_ADDR'];

                    $arrColumns = array('AdminLastLogin' => 'now()', 'AdminLastLoginIPAddress' => $varIpAddress, 'AdminForgotPWStatus' => 'Inactive', 'AdminForgotPWCode' => '');

                    $varWhereCondition = "pkAdminID = '" . $_SESSION['sessUser'] . "'";

                    $this->update(TABLE_ADMIN, $arrColumns, $varWhereCondition);

                    $arrColumns = array('fkAdminID' => $_SESSION['sessUser'], 'AdminLastLogin' => 'now()', 'AdminLastLoginIPAddress' => $varIpAddress);

                    $this->insert(TABLE_ADMIN_LASTLOGIN, $arrColumns);

                    //** after successfull login return true to redirect to dashboard


                    if (isset($argArrPOST['remember'])) {
                        setcookie('AdminUserName', $argArrPOST['frmAdminUserName'], time() + 3600);
                        setcookie('AdminPassword', $argArrPOST['frmAdminPassword'], time() + 3600);
                        setcookie('remember', 'yes', time() + 3600);
                    } else {
                        if (isset($_COOKIE['AdminUserName'])) {
                            setcookie('AdminUserName', $argArrPOST['frmAdminUserName'], time() - 3600);
                            setcookie('AdminPassword', $argArrPOST['frmAdminPassword'], time() - 3600);
                            setcookie('remember', 'yes', time() - 3600);
                        }
                    }




                    return true;
                } else {

                    //else return false to redirect to login form page

                    return false;
                }
            }//** end count result
            else {

                $objCore->setErrorMsg(ADMIN_LOGIN_ERROR);

                $_SESSION['sessUser'] = '';

                $_SESSION['sessAdminUserName'] = '';

                $_SESSION['sessAdminPassword'] = '';

                $_SESSION['sessAdminEmail'] = '';

                $_SESSION['sessAdminManageCMS'] = '';

                $_SESSION['sessAdminLastLogin'] = '';

                $_SESSION['sessUserType'] = '';

                unset($_SESSION['sessUser']);

                unset($_SESSION['sessAdminUserName']);

                unset($_SESSION['sessAdminPassword']);

                unset($_SESSION['sessAdminEmail']);

                unset($_SESSION['sessAdminLastLogin']);

                unset($_SESSION['sessUserType']);

                return false;
            }
        } else {

            $objCore->setErrorMsg(ADMIN_LOGIN_ERROR);

            $_SESSION['sessUser'] = '';

            $_SESSION['sessAdminUserName'] = '';

            $_SESSION['sessAdminPassword'] = '';

            $_SESSION['sessAdminEmail'] = '';

            $_SESSION['sessAdminLastLogin'] = '';

            $_SESSION['sessUserType'] = '';


            unset($_SESSION['sessUser']);

            unset($_SESSION['sessAdminUserName']);

            unset($_SESSION['sessAdminPassword']);

            unset($_SESSION['sessAdminEmail']);

            unset($_SESSION['sessAdminLastLogin']);

            unset($_SESSION['sessUserType']);

            return false;
        }
    }

    /*     * ****************************************

      Function Name : checkAdminSession

      Return type : none

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author : Vivek Avasthi

      Last modified by : Vivek Avasthi

      Comments : This function is used to check admin session.

      User instruction : $objAdminLogin->checkAdminSession();

     * **************************************** */

    function checkAdminSession() {

        if (($_SESSION['sessAdminUserName'] != '') && ($_SESSION['sessAdminPassword'] != '')) {

            $varSessAdminUserName = $_SESSION['sessAdminUserName'];

            $varSessAdminPassword = $_SESSION['sessAdminPassword'];



            $varWhereCondition = "AdminUserName = '" . addslashes($varSessAdminUserName) . "' AND AdminPassword = '" . addslashes($varSessAdminPassword) . "' ";

            $result = $this->getNumRows(TABLE_ADMIN, $varWhereCondition);



            if ($result > 0) {

                return true;
            } else {

                $_SESSION['session_msg'] = ADMIN_SESSION_EXPIRED;

                $_SESSION['sessUser'] = '';

                $_SESSION['sessAdminUserName'] = '';

                $_SESSION['sessAdminPassword'] = '';

                $_SESSION['sessAdminEmail'] = '';

                $_SESSION['sessAdminLastLogin'] = '';

                $_SESSION['sessUserType'] = '';

                unset($_SESSION['sessUser']);

                unset($_SESSION['sessAdminUserName']);

                unset($_SESSION['sessAdminPassword']);

                unset($_SESSION['sessAdminEmail']);

                unset($_SESSION['sessAdminLastLogin']);

                unset($_SESSION['sessUserType']);

                return false;
            }
        } else {

            $_SESSION['session_msg'] = ADMIN_SESSION_EXPIRED;

            $_SESSION['sessUser'] = '';

            $_SESSION['sessAdminUserName'] = '';

            $_SESSION['sessAdminPassword'] = '';

            $_SESSION['sessAdminEmail'] = '';

            $_SESSION['sessAdminLastLogin'] = '';

            $_SESSION['sessUserType'] = '';

            unset($_SESSION['sessUser']);

            unset($_SESSION['sessAdminUserName']);

            unset($_SESSION['sessAdminPassword']);

            unset($_SESSION['sessAdminEmail']);

            unset($_SESSION['sessAdminLastLogin']);

            unset($_SESSION['sessUserType']);

            return false;
        }
    }

    /*     * ****************************************

      Function name : isValidAdmin

      Return type : None

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author :  Vivek Avasthi

      Last modified by :Vivek Avasthi

      Comments : Function will redirect to index page if sessio is not exist.

      User instruction : objAdminLogin->isValidAdmin()

     * **************************************** */

    function isValidAdmin() {

        $objCore = new Core();

        $varFileName = basename($_SERVER['PHP_SELF']);

        if (!($this->checkAdminSession())) {

            header('location:' . SITE_ROOT_URL . 'admin/index.php');

            die;
        }
    }

    /*     * ****************************************

      Function name : isValidAdmin

      Return type : None

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author :  Vivek Avasthi

      Last modified by :Vivek Avasthi

      Comments : Function will redirect to index page if sessio is not exist.

      User instruction : objAdminLogin->isValidAdmin()

     * **************************************** */

    function isValidUserResource() {

        $objCore = new Core();

        $varFileName = basename($_SERVER['PHP_SELF']);
    }

    /*     * ****************************************

      Function name : adminLogOut

      Return type : None

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author :  Vivek Avasthi

      Last modified by :Vivek Avasthi

      Comments : Function will expire admin session.

      User instruction : objAdminLogin->adminLogOut()

     * **************************************** */

    function doAdminLogout() {

        if (($_SESSION['sessAdminUserName'] != '') && ($_SESSION['sessAdminPassword'] != '')) {

            $_SESSION['sessUser'] = '';

            $_SESSION['sessAdminUserName'] = '';

            $_SESSION['sessAdminPassword'] = '';

            $_SESSION['sessAdminEmail'] = '';

            $_SESSION['sessAdminLastLogin'] = '';

            unset($_SESSION['sessUser']);

            unset($_SESSION['sessAdminUserName']);

            unset($_SESSION['sessAdminPassword']);

            unset($_SESSION['sessAdminEmail']);

            unset($_SESSION['sessAdminLastLogin']);
            unset($_SESSION['sessAdminTitle']);
            unset($_SESSION['sessAdminCountry']);
            unset($_SESSION['sessAdminRegion']);
            unset($_SESSION['sessAdminTimeZone']);
            unset($_SESSION['sessAdminLastLoginIP']);
            unset($_SESSION['sessAdminPageLimit']);
            unset($_SESSION['sessAdminRoleName']);
            unset($_SESSION['sessUserType']);
            unset($_SESSION['sessAdminPerMission']);
            unset($_SESSION['sessAdminWholesalerIDs']);

           // session_destroy();

            header('location: ' . SITE_ROOT_URL . 'admin/logout.php');

            die;
        }
    }

    /*     * ****************************************

      Function name : getAdminNumRows

      Return type : Number

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author :  Vivek Avasthi

      Last modified by :Vivek Avasthi

      Comments : Function will return admin number of rows.

      User instruction : $objAdminLogin->getAdminNumRows($argWhrCon='')

     * **************************************** */

    function getAdminNumRows($argWhrCon) {

        $varAdminClmn = 'pkAdminID';

        $varNumRows = $this->getNumRows(TABLE_ADMIN, $varAdminClmn, $argWhrCon);

        return $varNumRows;
    }

    /*     * ****************************************

      Function name : changeAdminPassword

      Return type : None

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author :  Vivek Avasthi

      Last modified by : Vivek Avasthi

      Comments : Function will change the admin password and send mail to admin.

      User instruction : objAdminLogin->changeAdminPassword()

     * **************************************** */

    function changeAdminPassword($argArrPOST) {

        $objValid = new Validate_fields;

        $objCore = new Core();

        $objValid->check_4html = true;

        $_SESSION["arrChangePassword"] = array();

        $varOldPassword = $argArrPOST['frmAdminOldPassword'];

        $varNewPassword = $argArrPOST['frmAdminNewPassword'];

        $varConfirmPassword = $argArrPOST['frmAdminConfirmPassword'];

        //*** server side validation will start from here .

        $objValid->add_text_field('Current Password', strip_tags($argArrPOST['frmAdminOldPassword']), 'text', 'y', 100);

        $objValid->add_text_field('New Password', strip_tags($argArrPOST['frmAdminNewPassword']), 'text', 'y', 100);

        $objValid->add_text_field('Confirm New Password', strip_tags($argArrPOST['frmAdminConfirmPassword']), 'text', 'y', 100);



        if ($objValid->validation()) {

            $errorMsgFirst = 'Please enter required fields!';
        } else {

            $errorMsg = $objValid->create_msg();
        }

        if ($varNewPassword != '' && $varConfirmPassword != '') {

            if ($varNewPassword != $varConfirmPassword) {

                $varErrorMessage = "New Password and Confirm New Password must be same.<br />";

                $errorMsg .= $varErrorMessage;
            }
        }

        if ($errorMsg) {

            $_SESSION["arrChangePassword"] = $argArrPOST;

            $objCore->setErrorMsg($errorMsg);

            return false;
        } else {

            //*** server side validation end here

            $varAdminID = $_SESSION['sessUser'];

            //$varWhereCondition = " AND pkAdminID ='".$varAdminID."' AND AdminPassword = binary '".$varOldPassword."'"; encode(binary('".$varPassword."'),'vinove')
            //$varWhereCondition = " AND pkAdminID ='".$varAdminID."' AND AdminPassword = encode(binary('".$varOldPassword."'),'vinove')";

            $varWhereCondition = " AND pkAdminID ='" . addslashes($varAdminID) . "' AND AdminPassword = '" . md5($varOldPassword) . "'"; //binary('".addslashes($varOldPassword)."')";


            $varResultRows = $this->getAdminNumRows($varWhereCondition);

            if ($varResultRows > 0) {

                //check for valid password
                //if(!preg_match("/^[a-zA-Z0-9\!\-\_\#\@]+$/u", $varNewPassword))
                if (!preg_match("/^[a-zA-Z0-9\!\-\_\#\@]+/u", $varNewPassword)) {

                    $_SESSION["arrChangePassword"] = $argArrPOST;

                    $objCore->setErrorMsg(ADMIN_SETTING_PAGE_PASSWORD_CHECK);

                    return false;
                } else {

                    //end check for valid password
                    //$arrColumns = array('AdminPassword'=>$varNewPassword);
                    //$arrColumns = array('AdminPassword'=>'encode(\''.$varNewPassword.'\', \'vinove\')');

                    $arrColumns = array('AdminPassword' => md5($varNewPassword));

                    $varWhere = "pkAdminID ='" . $varAdminID . "'";

                    unset($_SESSION['sessAdminPassword']);

                    $_SESSION['sessAdminPassword'] = '';

                    $_SESSION['sessAdminPassword'] = md5($varNewPassword);

                    $varAffectedRows = $this->update(TABLE_ADMIN, $arrColumns, $varWhere);

                    $this->sendChangePassMailToAdmin($argArrPOST);



                    $objCore->setSuccessMsg(ADMIN_CHANGE_PASSWORD_MSG);

                    return true;
                }
            } else {

                $objCore->setErrorMsg(ADMIN_CHANGE_PASSWORD_ERR);

                return false;
            }
        }
    }

    /*     * ****************************************

      Function name : sendChangePassMailToAdmin

      Return type : None

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author : Vivek Avasthi

      Last modified by : Vivek Avasthi

      Comments : Function is used to sent mail to admin having change password information.

      User instruction : objAdminLogin->sendChangePassMailToAdmin($argArrPOST)

     * **************************************** */

    function sendChangePassMailToAdmin($argArrPOST) {

        $objTemplate = new EmailTemplate();

        $objCore = new Core();

        $varPath = "";
//        $varPath = "<img src = ".SITE_ROOT_URL.'admin/images/logo.png'.">";

        $varAdminUserName = $_SESSION['sessAdminUserName'];

        $varAdminUserPass = $argArrPOST['frmAdminNewPassword'];

        $varWhere = "AND AdminUserName = '" . $_SESSION['sessAdminUserName'] . "' ";



        $arrAdminInfo = $this->getAdminInfo($varWhere);

        $varToAdmin = $arrAdminInfo[0]['AdminEmail'];



        $varFrom = $varToAdmin;

        $varSiteName = SITE_NAME;

        $varWhereTemplate = ' EmailTemplateTitle = binary \'Send Change Password\' AND EmailTemplateStatus = \'Active\' ';

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));



        $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{USER_NAME}', '{PASSWORD}');

        $varKeywordValues = array($varPath, $varSiteName, $varAdminUserName, $varAdminUserPass);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

        $varSubject = str_replace('{SITE_NAME}', $varSiteName, $varSubject);

        //send email

        $objCore->sendMail($varToAdmin, $varFrom, $varSubject, $varOutPutValues);
    }

    /*     * ****************************************

      Function name : changeAdminPageLimit

      Return type : None

      Date created : 05May2011

      Date last modified : 05May2011

      Author :  Deepesh Pathak

      Last modified by : Deepesh Pathak

      Comments : Function will change the admin page settings.

      User instruction : objAdminLogin->changeAdminPageLimit()

     * **************************************** */

    function changeAdminPageLimit($argArrPOST) {
        $objCore = new Core();

        $varPageLimit = (int) $argArrPOST['frmRecordPerpage'];

        if ($varPageLimit < 5) {
            $objCore->setErrorMsg(ADMIN_PAGE_LIMIT_LESSER_MSG);
        } else {
            $arrColumns = array('AdminPageLimit ' => $varPageLimit);


            $varWhere = 'pkAdminID=' . $_SESSION['sessUser'];

            $this->update(TABLE_ADMIN, $arrColumns, $varWhere);

            unset($_SESSION['sessAdminPageLimit']);

            $_SESSION['sessAdminPageLimit'] = '';

            $_SESSION['sessAdminPageLimit'] = $varPageLimit;

            $objCore->setSuccessMsg(ADMIN_PAGE_LIMIT_CHANGE_MSG);
        }
    }

    /*     * ****************************************

      Function name : changeSupportTicket

      Return type : None

      Date created : 05May2011

      Date last modified : 05May2011

      Author :  Deepesh Pathak

      Last modified by : Deepesh Pathak

      Comments : Function will change the admin Support ticket type.

      User instruction : objAdminLogin->changeSupportTicket()

     * **************************************** */

    function changeSupportTicket($argArrPOST) {
        $objCore = new Core();
        $where = 'pkTicketID > 0';
        $this->delete(TABLE_SUPPORT_TICKET_TYPE, $where);
        foreach ($argArrPOST['frmSupportTicket'] as $val) {
            $arrColumns = array('TicketTitle' => $val);
            if ($val <> '') {
                $this->insert(TABLE_SUPPORT_TICKET_TYPE, $arrColumns);
            }
        }

        $objCore->setSuccessMsg(ADMIN_SUPPORT_TICKET_TYPE_MSG);
    }

    /*     * ****************************************

      Function name : changeDisputedCommentTitle

      Return type : None

      Date created : 05May2011

      Date last modified : 05May2011

      Author :  Deepesh Pathak

      Last modified by : Deepesh Pathak

      Comments : Function will change the admin Support ticket type.

      User instruction : objAdminLogin->changeDisputedCommentTitle()

     * **************************************** */

    function changeDisputedCommentTitle($argArrPOST) {
        $objCore = new Core();
        $where = 'CommentID > 0';
        $this->delete(TABLE_DISPUTED_COMMENT_LIST, $where);
        foreach ($argArrPOST['frmDisputedCommentTitle'] as $val) {
            $arrColumns = array('Title' => $val);
            if ($val <> '') {
                $this->insert(TABLE_DISPUTED_COMMENT_LIST, $arrColumns);
            }
        }

        $objCore->setSuccessMsg(ADMIN_DISPUTED_COMMENT_LIST_MSG);
    }

    /*     * ****************************************

      Function name : changeKPISetting

      Return type : None

      Date created : 05May2011

      Date last modified : 05May2011

      Author :  Deepesh Pathak

      Last modified by : Deepesh Pathak

      Comments : Function will change the admin Support ticket type.

      User instruction : objAdminLogin->changeKPISetting()

     * **************************************** */

    function changeKPISetting($argArrPOST) {
        $objCore = new Core();

        $where = 'fkCountryID > 0';
        $this->delete(TABLE_KPI_SETTING, $where);
        foreach ($argArrPOST['frmCountryId'] as $key => $val) {

            if ($key == 0 && $val == 0) {
                $arrColumns = array(
                    'KPIValue' => $argArrPOST['frmKPIVal'][$key]
                );
                $varWhr = ' fkCountryID = 0 ';
                $this->update(TABLE_KPI_SETTING, $arrColumns, $varWhr);
            } else if ($val <> 0) {
                $arrColumns = array(
                    'fkCountryID' => $val,
                    'KPIValue' => $argArrPOST['frmKPIVal'][$key]
                );
                $this->insert(TABLE_KPI_SETTING, $arrColumns);
            }
        }

        $objCore->setSuccessMsg(ADMIN_KPI_SETTING_UPDATE_MSG);
    }

    /*     * ****************************************

      Function name : changeDefaultTemplate

      Return type : None

      Date created : 04Sep2014

      Date last modified : 04Sep2014

      Author :  Amlana pattanayak

      Last modified by : Amlana pattanayak

      Comments : Function will change the wholesaler default template.

      User instruction : objAdminLogin->changeKPISetting()

     * **************************************** */

    function changeDefaultTemplate($argArrPOST) {
        $objCore = new Core();
        //$arrClms = array('pkTemplateId', 'templateName', 'templateDisplayName', 'templateDefault');

        $arrColumns = array('templateDefault' => '0');
        $varWhr = ' 1';
        $this->update(TABLE_WHOLESALER_TEMPLATE, $arrColumns, $varWhr);

        $arrColumns = array('templateDefault' => '1');
        $varWhr = ' pkTemplateId = ' . $argArrPOST['frmTemplateId'];
        $this->update(TABLE_WHOLESALER_TEMPLATE, $arrColumns, $varWhr);

        $objCore->setSuccessMsg(ADMIN_WHOLESALER_TEMPLATE_SETTING_UPDATE_MSG);
    }

    /**     * ***************************************

      Function name : changeDelayTime

      Return type : None

      Date created : 05May2011

      Date last modified : 05May2011

      Author :  Deepesh Pathak

      Last modified by : Deepesh Pathak

      Comments : Function will change the admin Default Commission And Margin.

      User instruction : objAdminLogin->changeDefaultCommission($argArrPOST)

     * **************************************** */
    function changeDelayTime($argArrPOST) {
        $objCore = new Core();
        $where = "SettingAliasName='" . $argArrPOST['frmSettingAlias'] . "'";
        $arrColumns = array(
            'SettingValue' => $argArrPOST['frmDelayTime']
        );
        $this->update(TABLE_SETTING, $arrColumns, $where);
        $objCore->setSuccessMsg(ADMIN_DELAY_TIME_MSG);
    }

    /**     * ***************************************

      Function name : changeSpecialApplicationPrice

      Return type : None

      Date created : 05May2011

      Date last modified : 05May2011

      Author :  Deepesh Pathak

      Last modified by : Deepesh Pathak

      Comments : Function will change the admin Default Commission And Margin.

      User instruction : objAdminLogin->changeSpecialApplicationPrice($argArrPOST)

     * **************************************** */
    function changeSpecialApplicationPrice($argArrPOST) {
        $objCore = new Core();
        $this->update(TABLE_SETTING, array('SettingValue' => (float) $argArrPOST['SpecialApplicationPrice']), "SettingAliasName='SpecialApplicationPrice'");
        $this->update(TABLE_SETTING, array('SettingValue' => (float) $argArrPOST['SpecialApplicationCategoryPrice']), "SettingAliasName='SpecialApplicationCategoryPrice'");
        $this->update(TABLE_SETTING, array('SettingValue' => (float) $argArrPOST['SpecialApplicationProductPrice']), "SettingAliasName='SpecialApplicationProductPrice'");

        $objCore->setSuccessMsg(ADMIN_SPECIAL_APPLICATION_UPDATED_MSG);
    }

    /**
     * function lastLogin
     *
     * This function is used to update setting values.
     *
     * Database Tables used in this function are : tbl_setting
     *
     * @access public
     *
     * @parameters 1 array $argArrPOST
     *
     * @return string none
     *
     * User instruction: $objAdminLogin->changeRewardPoints()
     */
    function changeRewardPoints($argArrPOST) {
        // pre($argArrPOST);         

        $objCore = new Core();
        unset($argArrPOST['btnRewardPointsUpdate']);
        //  pre($argArrPOST);         
        foreach ($argArrPOST as $k => $v) {
            $this->update(TABLE_SETTING, array('SettingValue' => $v), "SettingAliasName='" . $k . "'");
        }

        $objCore->setSuccessMsg(ADMIN_REWARD_POINTS_UPDATED_MSG);
    }

    /**     * ***************************************

      Function name : changeDefaultCommission

      Return type : None

      Date created : 05May2011

      Date last modified : 05May2011

      Author :  Deepesh Pathak

      Last modified by : Deepesh Pathak

      Comments : Function will change the admin Default Commission And Margin.

      User instruction : objAdminLogin->changeDefaultCommission($argArrPOST)

     * **************************************** */
    function changeDefaultCommission($argArrPOST) {
        $objCore = new Core();
        $where = "pkCommissionID='" . $argArrPOST['frmCommissionId'] . "'";
        $arrColumns = array(
            'Wholesalers' => $argArrPOST['frmWholesalerSalesCommission'],
            'AdminUsers' => $argArrPOST['frmAdminUsersCommission'],
            'SalesPeriod' => $argArrPOST['frmAdminUsersPeriod']
        );
        $this->update(TABLE_DEFAULT_COMMISSION, $arrColumns, $where);
        $objCore->setSuccessMsg(ADMIN_DEFAULT_COMMISSION_MSG);
    }

    /**     * ***************************************

      Function name : changMarginCost

      Return type : None

      Date created : 05May2011

      Date last modified : 05May2011

      Author :  Deepesh Pathak

      Last modified by : Deepesh Pathak

      Comments : Function will change the admin Default Commission And Margin.

      User instruction : objAdminLogin->changMarginCost($argArrPOST)

     * **************************************** */
    function changeMarginCost($argArrPOST) {
        $objCore = new Core();
        $where = 'pkCommissionID=' . $argArrPOST['frmCommissionId'];
        $arrColumns = array('MarginCast' => $argArrPOST['frmMarginCost']);
        $this->update(TABLE_DEFAULT_COMMISSION, $arrColumns, $where);

        $arrClmsUpdate = array('id' => $argArrPOST['frmCommissionId'], 'name' => 'margincost', 'action' => 'edit', 'type' => 'shippingcost');
        $arrClmsUpdateReturn = $this->insert(TABLE_UPDATE_CATEGORY_ATTR_SHIPPING, $arrClmsUpdate);
        $sendUpdateToWholesaler = array('pkWholesalerID', 'CompanyEmail', 'CompanyName');
        $whrereSendUpdateToWholesaler = "WholesalerAPIKey<>''";
        $sendUpdateToWholesalerReturn = $this->select(TABLE_WHOLESALER, $sendUpdateToWholesaler, $whrereSendUpdateToWholesaler);
        if (count($sendUpdateToWholesalerReturn) > 0) {

            foreach ($sendUpdateToWholesalerReturn as $key => $whlMail) {

                $objTemplate = new EmailTemplate();
                $objCore = new Core();

                $varUserName = trim(strip_tags($whlMail['CompanyName']));
                $varPassword = trim(strip_tags($arrPost['frmPassword']));
                //pre($varUserName);
                $varToUser = $whlMail['CompanyEmail']; //'raju.khatak@mail.vinove.com';

                $varFromUser = $_SESSION['sessAdminEmail'];

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'Margin Cost has been updated' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '';
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $argArrPOST['frmMarginCost']);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function

                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
            }
        }

        $objCore->setSuccessMsg(ADMIN_MARGIN_COST_MSG);
    }

    /*     * ****************************************

      Function name : changeAdminSettings

      Return type : None

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author :  Vivek Avasthi

      Last modified by : Vivek Avasthi

      Comments : Function will change the admin settings.

      User instruction : objAdminLogin->changeAdminSettings()

     * **************************************** */

    function changeAdminEmail($argArrPOST) {
        $varAdminID = $_SESSION['sessUser'];
        $objValid = new Validate_fields;

        $objCore = new Core();

        $objValid->check_4html = true;

        $_SESSION["arrPost"] = array();


        $objValid->add_text_field('Admin E-mail', strip_tags($argArrPOST['frmAdminEmail']), 'email', 'y', 100);

        if ($argArrPOST['frmSupportEmail'] != '') {


            $objValid->add_text_field('Support E-mail', strip_tags($argArrPOST['frmSupportEmail']), 'email', 'y', 30);
        }

        if ($objValid->validation()) {

            $errorMsgFirst = 'Please enter required fields!';
        } else {

            $errorMsg = $objValid->create_msg();
        }

        if ($errorMsg) {

            $_SESSION["arrPost"] = $argArrPOST;

            $objCore->setErrorMsg($errorMsg);

            return false;
        } else {

            $arrColumns = array('AdminEmail' => $argArrPOST['frmAdminEmail']);

            //$varWhere = "pkAdminID = '".$argArrPOST['AdminID']."'";
            $varWhere = "pkAdminID ='" . $varAdminID . "'";

            $this->update(TABLE_ADMIN, $arrColumns, $varWhere);

            unset($_SESSION['sessAdminEmail']);

            $_SESSION['sessAdminEmail'] = '';

            $_SESSION['sessAdminEmail'] = $argArrPOST['frmAdminEmail'];

            $objCore->setSuccessMsg(ADMIN_EMAIL_CHANGE_MSG);

            return true;
        }
    }

    /*     * ****************************************

      Function Name : getAdminInfo

      Return type : array

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author : Vivek Avasthi

      Last modified by : Vivek Avasthi

      Comments : This is used to return admin information.

      User instruction : objAdminLogin->getAdminInfo($argWhere)

     * **************************************** */

    function getAdminInfo($argWhere) {

        $arrClms = array('pkAdminID', 'AdminType', 'fkAdminRollId', 'AdminUserName', 'AdminLastLoginIPAddress', 'AdminPassword', 'AdminEmail', 'PaypalEmailID', 'AdminTitle', 'AdminCountry', 'AdminRegion', 'Commission', 'SalesTarget', 'SalesTargetStartDate', 'SalesTargetEndDate', 'AdminLastLogin', 'AdminStatus', 'AdminForgotPWStatus', 'AdminForgotPWCode', 'AdminPageLimit', 'AdminOldPass', 'AdminRoleName', 'AdminRolePermission', 'time_zone');
        $varTable = TABLE_ADMIN . ' LEFT JOIN ' . TABLE_ADMIN_ROLL . '  ON pkAdminRoleId = fkAdminRollId LEFT JOIN ' . TABLE_COUNTRY . ' ON country_id = AdminCountry';
        $varWhere = '1 ' . $argWhere;

        $arrAdminResults = $this->select($varTable, $arrClms, $varWhere);

        return $arrAdminResults;
    }

    /*     * ****************************************

      Function Name : getAdminWholesalers

      Return type : string

      Date created : 15th Oct 2013

      Date last modified : 15th Oct 2013

      Author : Suraj Kumar Maurya

      Last modified by : Suraj Kumar Maurya

      Comments : This is used to return wholesalers ids.

      User instruction : objAdminLogin->getAdminWholesalers($adminID)

     * **************************************** */

    function getAdminWholesalers($argId) {

        $arrClms = array('AdminType', 'AdminCountry', 'AdminRegion');
        $varTable = TABLE_ADMIN;
        $varWhere = "pkAdminID = '" . $argId . "' ";

        $arrAdminRes = $this->select($varTable, $arrClms, $varWhere);

        $varWholesalerIDs = '';

        if ($arrAdminRes[0]['AdminRegion'] > 0) {
            $varWhere = "CompanyRegion = '" . $arrAdminRes[0]['AdminRegion'] . "' ";
        } else if ($arrAdminRes[0]['AdminCountry']) {
            $varWhere = "CompanyCountry = '" . $arrAdminRes[0]['AdminCountry'] . "' ";
        } else {
            $varWhere = "";
        }

        if ($varWhere) {
            $varQuery = "SELECT group_concat(pkWholesalerID) as WIDs  FROM " . TABLE_WHOLESALER . " WHERE " . $varWhere;
            $arrRes = $this->getArrayResult($varQuery);
            if (!empty($arrRes[0]['WIDs'])) {
                $varWholesalerIDs = $arrRes[0]['WIDs'];
            } else {
                $varWholesalerIDs = 999999999;
            }
            //
        }
        //pre($varWholesalerIDs);
        return $varWholesalerIDs;
    }
    function getAdminLogisticUser($argId) {

        $arrClms = array('AdminType', 'AdminCountry', 'AdminRegion');
        $varTable = TABLE_ADMIN;
        $varWhere = "pkAdminID = '" . $argId . "' ";

        $arrAdminRes = $this->select($varTable, $arrClms, $varWhere);

        $varLogisticIDs = '';

        if ($arrAdminRes[0]['AdminCountry']) {
            $varWhere = "logisticportal = '" . $arrAdminRes[0]['AdminCountry'] . "' ";
        } else {
            $varWhere = "";
        }
        
        if ($varWhere) {
            $varQuery = "SELECT group_concat(logisticportalid) as LIDs  FROM " . TABLE_LOGISTICPORTAL . " WHERE " . $varWhere;
           // pre($varQuery);
            $arrRes = $this->getArrayResult($varQuery);
            if (!empty($arrRes[0]['LIDs'])) {
                $varLogisticIDs = $arrRes[0]['LIDs'];
            } else {
                $varLogisticIDs = 999999999;
            }
            //
        }
//        pre($varLogisticIDs);
        return $varLogisticIDs;
    }

    /*     * ****************************************

      Function Name : getLoginValidation

      Return type : none

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author : Vivek Avasthi

      Last modified by : Vivek Avasthi

      Comments : This is used to server side validate login.

      User instruction : objAdminLogin->getLoginValidation($argArrPOST)

     * **************************************** */

    function getLoginValidation($argArrPOST) {

        $objValid = new Validate_fields;

        $objCore = new Core();

        $objValid->check_4html = true;

        $_SESSION["arrLogin"] = array();



        $objValid->add_text_field('Username (Email)', strip_tags($argArrPOST['frmAdminUserName']), 'text', 'y');

        $objValid->add_text_field('Password', strip_tags($argArrPOST['frmAdminPassword']), 'text', 'y');



        if ($objValid->validation()) {

            $errorMsgFirst = 'Please enter required fields!';
        } else {

            $errorMsg = $objValid->create_msg();
        }



        if ($errorMsg) {

            $_SESSION["arrLoginDetails"] = $argArrPOST;

            $objCore->setErrorMsg($errorMsg);

            return false;
        } else {

            return true;
        }
    }

//end of function



    /*     * ****************************************

      Function Name : getAdminSettingValidation

      Return type : none

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author : Vivek Avasthi

      Last modified by : Vivek Avasthi

      Comments : This is used to server side validate login.

      User instruction : objAdminLogin->getAdminSettingValidation($argArrPOST)

     * **************************************** */

    function getAdminSettingValidation($argArrPOST) {

        $objValid = new Validate_fields;

        $objCore = new Core();

        $objValid->check_4html = true;

        $_SESSION["arrAdminSetting"] = array();



        $objValid->add_text_field('Old Password', strip_tags($argArrPOST['frmOldPassword']), 'text', 'y', 30);

        $objValid->add_text_field('New Password', strip_tags($argArrPOST['frmNewPassword']), 'text', 'y', 20);

        $objValid->add_text_field('Confirm Password', strip_tags($argArrPOST['frmConfirmPassword']), 'text', 'y', 20);



        if ($objValid->validation()) {

            $errorMsgFirst = 'Please enter required fields!';
        } else {

            $errorMsg = $objValid->create_msg();
        }



        if ($errorMsg) {

            $_SESSION["arrAdminSettingDetails"] = $argArrPOST;

            $objCore->setErrorMsg($errorMsg);

            return false;
        } else {

            return true;
        }
    }

//end of function



    /*     * ****************************************

      Function Name : getValidationAdminNotificationID

      Return type : none

      Date created : 17th January 2008

      Date last modified : 17th January 2008

      Author : Vivek Avasthi

      Last modified by : Vivek Avasthi

      Comments : This is used to server side validate login.

      User instruction : objAdminLogin->getValidationAdminNotificationID($argArrPOST)

     * **************************************** */

    function getValidationAdminNotificationID($argArrPOST) {

        $objValid = new Validate_fields;

        $objCore = new Core();

        $objValid->check_4html = true;

        $_SESSION["arrAdminSetting"] = array();



        $objValid->add_text_field('Notification Email ID', strip_tags($argArrPOST['frmAdminEmail']), 'text', 'y', 30);



        if ($objValid->validation()) {

            $errorMsgFirst = 'Please enter required fields!';
        } else {

            $errorMsg = $objValid->create_msg();
        }



        //Check for the duplicate Email ID

        $varWhereCondition = " AND AdminUserName = '" . $argArrPOST['frmAdminEmail'] . "' OR AdminEmail = '" . $argArrPOST['frmAdminEmail'] . "' AND pkAdminID != '" . $argArrPOST['pkAdminID'] . "'";



        $varResult = $this->getAdminNumRows($varWhereCondition);

        if ($varResult > 0) {

            //$_SESSION["arrAgentDetails"] = $argArrPOST;

            if (trim($errorMsg) == '') {

                $errorMsg = 'Please correct the following error(s) :<br />';
            }

            $errorEmail = '<br />Email already exists.';



            $errorMsg .= $errorEmail;
        }

        if ($errorMsg) {

            $_SESSION["arrAdminSettingDetails"] = $argArrPOST;

            $objCore->setErrorMsg($errorMsg);

            return false;
        } else {

            return true;
        }
    }

//end of function



    /*     * ****************************************

      Function Name : forgotPasswordMail

      Return type : None

      Date created : 14th November 2007

      Date last modified : 14th November 2007

      Author : Charanjeet Singh

      Modified BY : Charanjeet Singh

      Comments : This is used to send a forgot passwor mail to the admin.

      User instruction : $objAdminLogin->forgotPasswordMail($argArr);

     * **************************************** */

    function forgotPasswordMail($argArrPOST) {

        $objTemplate = new EmailTemplate();

        $objValid = new Validate_fields;

        $objCore = new Core();

        $objGeneral = new General();



        $objValid->check_4html = true;



        $_SESSION['sessForgotValues'] = array();



        $objValid->add_text_field('E-mail Address ', strip_tags($argArrPOST['frmUserName']), 'email', 'y', 255);

//    	$objValid->add_text_field('Verification Code', strip_tags($argArrPOST['frmSecurityCode']), 'text', 'y',255);



        if ($objValid->validation()) {

            $errorMsgFirst = REQUIRED_FIELD;
        } else {

            $errorMsg = $objValid->create_msg();
        }

        if ($errorMsg) {

            $_SESSION['sessForgotValues'] = $argArrPOST;

            $objCore->setErrorMsg($errorMsg);

            return false;
        } else {

//			if(($_SESSION['security_code'] == $argArrPOST['frmSecurityCode']) && (!empty($_SESSION['security_code'])))
//            if(!empty($_SESSION['security_code']))
//			{

            $varWhereCond = " AND AdminEmail ='" . $argArrPOST['frmUserName'] . "'";

            $userRecords = $this->getAdminNumRows($varWhereCond);

            //print_r($userRecords);
            //exit;

            $userInfo = $this->getAdminInfo($varWhereCond);

            //print_r($userInfo);
            //exit;
            //if($userRecords > 0 && $userInfo['0']['AdminForgotPWStatus'] == 'Inactive')

            if ($userRecords > 0) {

                $varAdminID = $userInfo['0']['pkAdminID'];

                //print_r($varAdminID);
                //exit;
                //memberdata contain member username

                $varMemberData = trim(strip_tags($argArrPOST['frmUserName']));

                $varForgotPasswordCode = $objGeneral->getValidRandomKey(TABLE_ADMIN, array('pkAdminID'), 'AdminForgotPWCode', '25');
                //echo $varForgotPasswordCode;die;
                $varForgotPasswordLink = '<a href="' . SITE_ROOT_URL . 'admin/reset_password.php?mid=' . $varAdminID . '&code=' . $varForgotPasswordCode . '">' . SITE_ROOT_URL . 'admin/reset_password.php?mid=' . $varAdminID . '&code=' . $varForgotPasswordCode . '</a>';

                $arrColumns = array('AdminForgotPWStatus' => 'Active', 'AdminForgotPWCode' => $varForgotPasswordCode);

                $varWhereCondition = 'pkAdminID = \'' . $varAdminID . '\'';

                $this->update(TABLE_ADMIN, $arrColumns, $varWhereCondition);

                $varAdminEmail = $userInfo[0]['AdminEmail'];

                $varToUser = $varAdminEmail;

                $varFromUser = SITE_NAME;

                $varSiteName = SITE_NAME;

                $varWhereTemplate = ' EmailTemplateTitle= binary \'Admin forgot password\' AND EmailTemplateStatus = \'Active\' ';

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));


                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                /*                 * ***** */

                $varPathImage = '';
//                  $varPathImage = '<img src="'.SITE_ROOT_URL.'admin/images/logo.png" >';

                $varSubject = str_replace('{PROJECT_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}', '{MEMBER}', '{PROJECT_NAME}', '{USER_DATA}', '{FORGOT_PWD_LINK}', '{SITE_NAME}');

                $varKeywordValues = array($varPathImage, 'Admin', SITE_NAME, $varMemberData, $varForgotPasswordLink, SITE_NAME);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function

                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);

                $_SESSION['sessForgotValues'] = '';

                $objCore->setSuccessMsg(ADMIN_FORGOT_PASSWORD_CONFIRM_MSG);

                return true;
            } else {

                $_SESSION['sessForgotValues'] = $argArrPOST;

                $objCore->setErrorMsg(EMAIL_NOT_EXIST_MSG);

                return true;
            }

//			}
//			else
//
//			{
//
//				$_SESSION['sessForgotValues'] = $argArrPOST;
//
//				$objCore->setErrorMsg(INVALID_SECURITY_CODE_MSG);
//
//				return false;
//
//			}
        }
    }

    /*     * ****************************************

      Function Name : getAdminEmail

      Return type : array

      Date created : 15th November 2007

      Date last modified : 15th November 2007

      Author : vivek avasthi

      Last modified by : vivek avasthi

      Comments : This is used to return a array of admin records.

      User instruction : $objCore->getAdminEmail($argWhere)

     * **************************************** */

    function getAdminEmail($argVarWhereCon = '') {

        $arrClms = array('pkAdminID', 'fkAdminRollId', 'AdminUserName', 'AdminPassword', 'AdminPageLimit', 'AdminEmail', 'AdminStatus');

        $varWhere = ' 1 ' . $argVarWhereCon;

        $arrAdminRecords = $this->select(TABLE_ADMIN, $arrClms, $varWhere);

        return $arrAdminRecords;
    }

    /*     * ****************************************

      Function Name : getSupportTicket

      Return type : array

      Date created : 15th November 2007

      Date last modified : 15th November 2007

      Author : vivek avasthi

      Last modified by : vivek avasthi

      Comments : This is used to return a array of Support tickets.

      User instruction : $objCore->getSupportTicket()

     * **************************************** */

    function getSupportTicket() {

        $arrClms = array('pkTicketID', 'TicketTitle');
        $varWhere = ' 1 ';
        $arrSupportTicketRecords = $this->select(TABLE_SUPPORT_TICKET_TYPE, $arrClms, $varWhere, 'TicketTitle ASC');
        return $arrSupportTicketRecords;
    }

    /*     * ****************************************

      Function Name : getKPISetting

      Return type : array

      Date created : 15th November 2007

      Date last modified : 15th November 2007

      Author : vivek avasthi

      Last modified by : vivek avasthi

      Comments : This is used to return a array of Support tickets.

      User instruction : $objCore->getKPISetting()

     * **************************************** */

    function getKPISetting() {

        $arrClms = array('fkCountryID', 'KPIValue');
        $varWhere = ' 1 ';
        $arrRowsRecords = $this->select(TABLE_KPI_SETTING, $arrClms, $varWhere, 'fkCountryID ASC');
        $arrRows = array();
        foreach ($arrRowsRecords as $valKPI) {
            $arrRows[$valKPI['fkCountryID']] = $valKPI['KPIValue'];
        }
        return $arrRows;
    }

    /*     * ****************************************

      Function Name : getKPISetting

      Return type : array

      Date created : 15th November 2007

      Date last modified : 15th November 2007

      Author : vivek avasthi

      Last modified by : vivek avasthi

      Comments : This is used to return a array of Support tickets.

      User instruction : $objCore->getKPISetting()

     * **************************************** */

    function getWholesalerTemplatesSetting() {

        $arrClms = array('pkTemplateId', 'templateName', 'templateDisplayName', 'templateDefault');
        $varWhere = ' 1 ';
        $arrRowsRecords = $this->select(TABLE_WHOLESALER_TEMPLATE, $arrClms, $varWhere, 'templateName ASC');
        /* $arrRows = array();
          foreach ($arrRowsRecords as $valKPI) {
          $arrRows[$valKPI['fkCountryID']] = $valKPI['KPIValue'];
          } */
        return $arrRowsRecords;
    }

    /*     * ****************************************

      Function Name : getDisputedCommentList

      Return type : array

      Date created : 15th November 2007

      Date last modified : 15th November 2007

      Author : vivek avasthi

      Last modified by : vivek avasthi

      Comments : This is used to return a array of Support tickets.

      User instruction : $obj->getDisputedCommentList()

     * **************************************** */

    function getDisputedCommentList() {

        $arrClms = array('CommentID', 'Title');
        $varWhere = ' 1 ';
        $arrRows = $this->select(TABLE_DISPUTED_COMMENT_LIST, $arrClms, $varWhere, 'CommentID ASC');
        return $arrRows;
    }

    /*     * ****************************************

      Function Name : getDefaultCommission

      Return type : array

      Date created : 15th November 2007

      Date last modified : 15th November 2007

      Author : vivek avasthi

      Last modified by : vivek avasthi

      Comments : This is used to return a array of Default Commission and Margin.

      User instruction : $objCore->getDefaultCommission($argWhere)

     * **************************************** */

    function getDefaultCommission($argWhere = '') {

        $arrClms = array('pkCommissionID', 'Wholesalers', 'AdminUsers', 'MarginCast', 'SalesPeriod');
        $varWhere = ' 1 AND pkCommissionID = ' . $argWhere;
        $arrRow = $this->select(TABLE_DEFAULT_COMMISSION, $arrClms, $varWhere);
        return $arrRow;
    }

    function getSetting($argWhere = '') {

        $arrClms = array('pkSettingID', 'SettingAliasName', 'SettingValue');
        $varWhere = ($argWhere <> '') ? "SettingAliasName = '" . $argWhere . "'" : "";
        $arrRow = $this->select(TABLE_SETTING, $arrClms, $varWhere);
        return $arrRow;
    }

    function getAllSetting() {

        $arrClms = array('pkSettingID', 'SettingAliasName', 'SettingValue');
        $arrRow = $this->select(TABLE_SETTING, $arrClms);
        foreach ($arrRow as $v) {
            $arrRes[$v['SettingAliasName']] = $v;
        }
        return $arrRes;
    }

    function getAdminUserList($argVarWhereCon = '', $varLimit = '') {

        $arrClms = array('pkAdminID', 'AdminTitle', 'AdminUserName', 'AdminType', 'fkAdminRollId', 'AdminPageLimit', 'AdminEmail', 'AdminStatus', 'AdminRoleName');
        $varTable = TABLE_ADMIN . ' LEFT JOIN ' . TABLE_ADMIN_ROLL . '  ON pkAdminRoleId=fkAdminRollId';
        $varWhere = ' 1 ' . $argVarWhereCon;
        $this->getSortColumn($_REQUEST);
        $arrAdminRecords = $this->select($varTable, $arrClms, $varWhere, $this->orderOptions, $varLimit);
        //pre($arrAdminRecords);
        return $arrAdminRecords;
    }

    /*     * ****************************************

      Function name : resetPassword

      Return type : None

      Date created : 23rd September 2008

      Date last modified : 23rd September 2008

      Author :  Ashok Singh Negi

      Last modified by : Ashok Singh Negi

      Comments : Function will change the admin password.

      User instruction : objAdminLogin->resetPassword()

     * **************************************** */

    function resetPassword($argArrPOST) {



        $objValid = new Validate_fields;

        $objCore = new Core();

        $objValid->check_4html = true;

        //$_SESSION["arrChangePassword"] = array();



        $varNewPassword = $argArrPOST['frmNewPassword'];

        $varConfirmPassword = $argArrPOST['frmConfirmNewPassword'];

        //*** server side validation will start from here .

        $objValid->add_text_field('New Password', strip_tags($argArrPOST['frmNewPassword']), 'text', 'y', 100);

        $objValid->add_text_field('Confirm New Password', strip_tags($argArrPOST['frmConfirmNewPassword']), 'text', 'y', 100);



        if ($objValid->validation()) {

            $errorMsgFirst = REQUIRED_FIELD;
        } else {

            $errorMsg = $objValid->create_msg();
        }

        if ($varNewPassword != '' && $varConfirmPassword != '') {

            if ($varNewPassword != $varConfirmPassword) {

                $varErrorMessage = ADMIN_PASS_NEW_PASS;

                $errorMsg .= $varErrorMessage;
            }
        }

        if ($errorMsg) {

            $_SESSION["arrChangePassword"] = $argArrPOST;

            $objCore->setErrorMsg($errorMsg);

            return false;
        } else {

            //*** server side validation end here
            //$varAdminID = $argArrPOST['frmMember'];
            //$varWhereCondition = " AND pkAdminID ='".$varAdminID."' AND AdminPassword = binary '".$varOldPassword."'";
            //$varResultRows = $this->getAdminNumRows($varWhereCondition);
            //if($varResultRows > 0)
            //{
            //check for valid password

            if (!preg_match("/^[a-zA-Z0-9\!\-\_\#\@]+$/u", $varNewPassword)) {

                $_SESSION["arrChangePassword"] = $argArrPOST;

                $objCore->setErrorMsg(ADMIN_SETTING_PAGE_PASSWORD_CHECK);

                return false;
            } else {



                $arrColumns = array('AdminPassword' => md5($varNewPassword), 'AdminForgotPWStatus' => 'Inactive', 'AdminForgotPWCode' => '');



                $varWhereCondition = 'pkAdminID = \'' . addslashes($argArrPOST['frmMember']) . '\' AND AdminForgotPWCode = \'' . addslashes($argArrPOST['frmCode']) . '\'';

                $this->update(TABLE_ADMIN, $arrColumns, $varWhereCondition);







                //end check for valid password

                /* $arrColumns = array('AdminPassword'=>$varNewPassword);

                  $varWhere = "pkAdminID ='".$varAdminID."'";

                  unset($_SESSION['sessAdminPassword']);

                  $_SESSION['sessAdminPassword'] = '';

                  $_SESSION['sessAdminPassword'] = $varNewPassword;

                  $varAffectedRows = $this->update(TABLE_ADMIN, $arrColumns, $varWhere);

                  $this->sendChangePassMailToAdmin($argArrPOST);

                  $objCore->setSuccessMsg(ADMIN_CHANGE_PASSWORD_MSG); */

                return true;
            }

            //}
            //else
            //{
            //$objCore->setErrorMsg(ADMIN_CHANGE_PASSWORD_ERR);
            //return false;
            //}
        }
    }

    /*     * ****************************************
      Function name:getSortColumn
      Return type: String
      Author : Aditya Pratap Singh
      Last modified by : Aditya Pratap Singh
      Comments: sort coloum for Enquiries
      User instruction: $objEnquiries->getSortColumn($argVarSortOrder)
     * **************************************** */

    function getSortColumn($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'pkAdminID';
        } else {
            $varSortBy = $argVarSortOrder['sortBy'];
        }
        //Create sort class object
        $objOrder = new CreateOrder($varSortBy, $varOrderBy);
        unset($argVarSortOrder['PHPSESSID']);
        //This function return  query  string. When we will array.
        $varQryStr = $objCore->sortQryStr($argVarSortOrder, $varOrderBy, $varSortBy);
        //print_r($varQryStr);
        //Pass query string in extra function for add in sorting
        $objOrder->extra($varQryStr);
        //Prepage sorting heading
        $objOrder->append(' ');
        $objOrder->addColumn('User Title', 'Admintitle', '', 'hidden-480');
        $objOrder->addColumn('User Name', 'AdminUserName');
        $objOrder->addColumn('Email', 'AdminEmail', '', 'hidden-480');
        $objOrder->addColumn('Role', 'AdminRoleName', '', 'hidden-350');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

}

//end of class
?>
