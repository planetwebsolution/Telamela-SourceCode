<?php
/**
 * LoginUser class 
 *
 * The LoginUser class contains all the functions that are commonly used in different modules.
 *
 * @DateCreated 23th March 2013
 * 
 * @DateLastModified  07 May, 2013
 *
 * @copyright Copyright (C) 2013-2014 Vinove Software and Services
 *
 * @version  1.1
 */
Class LoginUser extends Database {

    /** This array holds the job titles */
    function LoginUser() {
        //default constructor
    }

    /**
      *
      * Function name:getUsersList
      *
      * Return type: Associated array
      *
      * Date created : 20th April 2013
      *
      * Date last modified : 20th April 2013
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: show listing of Users
      *
      * User instruction: $objUsers->getUsersList($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '')
      *
      */ 

    function getBillingAgreementsDetailsText($userBillingAgreements) {
        //echo '<pre>'; print_r($userBillingAgreements);echo '</pre>';exit;
        // $res = htmlentities($userBillingAgreements);

        $res = str_replace("&lt;", "", $userBillingAgreements);
        $res = str_replace("&gt;", "", $res);
        $res = str_replace("&quot;", '', $res);
        $res = str_replace("&amp;", '', $res);
        $res = str_replace("&amp;", '', $res);
        $res = str_replace("<p>", '', $res);
        $res = str_replace("</p>", '', $res);
        $res = str_replace("<b>", '', $res);
        $res = str_replace("</b>", '', $res);
        $res = strip_tags($res);

        return $res;
    }

    function getUserList($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '') {
        if (count($argArrRequest) > 0) {
            $arrUserFlds = $argArrRequest;
        } else {
            $arrUserFlds = array();
        }
        //Call getSortColumn function to get column name and sort option $this->orderOptions;
        $this->getSortColumn($_REQUEST);

        //Prepare where condition
        $varUserWhere = ' 1 ' . $argVarSearchWhere;

        $arrUserList = $this->select($argVarTable, $arrUserFlds, $varUserWhere, $this->orderOptions, $argVarEndLimit);

        //return all record
        return $arrUserList;
    }

    /**
      *
      * Function name:getSortColumn
      *
      * Return type: String
      *
      * Date created : 20th April 2013
      *
      * Date last modified : 20th April 2013
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: sort coloum for Users
      *
      * User instruction: $objUsers->getSortColumn($argVarSortOrder)
      *
      */

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
            $varSortBy = 'UserDateAdded';
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
        $objOrder->addColumn('User Name', 'UserFirstName');
        $objOrder->addColumn('Email', 'UserEmail');
        $objOrder->addColumn('Registered Date', 'UserDateAdded');
        $objOrder->addColumn('Date Modified', 'UserDateUpdated');
        $objOrder->addColumn('Status', 'UserStatus');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
      *
      * Function Name: getUserString
      *
      * Return type: String
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: Generates a querystring for the Users table that will be used in judge search where condition.
      *
      * User instruction: objClient->getClientString($argArrPost)
      *
      */

    function getLoginUserString($argArrPost) {
        //print_r($argArrPost); die;
        $varSearchWhere = ' ';
        if ($argArrPost['frmSearchUserNameResult'] != '') {
            $varSearchWhere .= 'AND UserEmail LIKE \'%' . trim(addslashes($argArrPost['frmSearchUserNameResult'])) . '%\'';
        }

        if ($argArrPost['frmSearchUserStatus'] != '') {
            $varSearchWhere .= 'AND UserStatus = \'' . $argArrPost['frmSearchUserStatus'] . '\'';
        }
        if ($argArrPost['frmDate'] != '' && $argArrPost['frmDate'] != 'From') {

            $varFromDate = $argArrPost['frmDate'];
            $varSearchWhere .= ' AND (DATE_FORMAT(UserDateAdded, \'%Y-%m-%d\') >= STR_TO_DATE(\'' . $varFromDate . '\', \'%Y-%m-%d\')';
            if ($argArrPost['frmToDate'] != '' && $argArrPost['frmToDate'] != 'To') {
                $varToDate = $argArrPost['frmToDate'];
                $varSearchWhere .= ' AND DATE_FORMAT(UserDateAdded, \'%Y-%m-%d\') <= STR_TO_DATE(\'' . $varToDate . '\',\'%Y-%m-%d\'))';
            } else {
                $varSearchWhere .= ')';
            }
        }
        if ($argArrPost['frmDate'] == '' || $argArrPost['frmDate'] == 'From') {
            if ($argArrPost['frmToDate'] != '' && $argArrPost['frmToDate'] != 'To') {
                $varToDate = $argArrPost['frmToDate'];
                $varSearchWhere .= ' AND DATE_FORMAT(UserDateAdded, \'%Y-%m-%d\') <= STR_TO_DATE(\'' . $varToDate . '\',\'%Y-%m-%d\')';
            }
        }
        return $varSearchWhere;
    }

    /**
      *
      * Function name: getUsersInfo
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: general Users function
      *
      * User instruction: $objUsers->getUsersInfo$argVarTable, $argArrClm = array(), $argVarWhere = '')
      *
      */ 

    function getLoginUserInfo($argVarTable, $argArrClm = array(), $argVarWhere = '') {
        if (count($argArrClm) > 0) {
            $arrFlds = $argArrClm;
        } else {
            $arrFlds = array();
        }
        $arrList = $this->select($argVarTable, $arrFlds, $argVarWhere);
        return $arrList;
    }

   /**
      *
      * Function name: checkUsersValidation
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: check Users server side validation
      *
      * User instruction: $objUsers->checkUsersValidation($argArrPost)
      *
      */

    function checkUserValidation($argArrPost) {

        $objValid = new Validate_fields;
        $objCore = new Core();
        $objValid->check_4html = true;
        $_SESSION['sessArrUsers'] = array();
        $objValid->add_text_field('First Name', strip_tags($argArrPost['frmFirstName']), 'text', 'y', 100);

        if ($argArrPost['frmProcess'] != 'EditUser') {
            $objValid->add_text_field('User Email', strip_tags($argArrPost['frmUserEmail']), 'text', 'y', 200);
            $objValid->add_text_field('Password', strip_tags($argArrPost['frmPassword']), 'text', 'y', 20);
        }


        if ($objValid->validation()) {
            $varErrorMsgFirst = 'Please enter required fields!';
        } else {
            $varErrorMsg = $objValid->create_msg();
        }
        if ($varErrorMsg) {
            $_SESSION['sessArrUsers'] = $argArrPost;
            $objCore->setErrorMsg($varErrorMsg);
            return false;
        } else {
            return true;
        }
    }

    /**
      *
      * Function name: editUser
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: edit Users
      *
      * User instruction: $objUser->editUsers($argArrPost)
      *
      */ 

    function editLoginUser($argArrPost) {
        //@extract($argArrPost);

        $objCore = new Core;
        $objGeneral = new General();
        $_SESSION['sessArrUsers'] = array();
        if (!$this->checkUserValidation($argArrPost)) {
            $_SESSION['sessArrUsers'] = $argArrPost;
            return false;
        } else {

            $arrUserFlds = array('pkUserID');
            $varUserWhere = ' 1 AND UserEmail = \'' . $argArrPost['frmUserEmail'] . '\' AND pkUserID!=\'' . $argArrPost['frmUserID'] . '\'';
            $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);
            if ($arrUserList) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg(ADMIN_USER_PRIMARY_EMAIL_ALREADY_EXIST);
                return false;
            } else {


                if ($argArrPost['frmBillingAgreementsContent']) {
                    $varUserBillingAgreements = $argArrPost['frmBillingAgreementsContent'];
                } else {
                    $arrAdminCol = array('AdminUserBillingAgreements');
                    $arrAdminBillinAgreement = $this->select(TABLE_ADMIN, $arrAdminCol);
                    $varUserBillingAgreements = $arrAdminBillinAgreement[0]['AdminUserBillingAgreements'];
                }

                $arrColumnAdd = array(
                    'UserFirstName' => $argArrPost['frmFirstName'],
                    'UserMiddleName' => $argArrPost['frmMiddleName'],
                    'UserLastName' => $argArrPost['frmLastName'],
                    'UserEmail' => $argArrPost['frmUserEmail'],
                    'UserGender' => $argArrPost['frmGender'],
                    'UserStatus' => $argArrPost['frmUserStatus'],
                    'UserType' => $argArrPost['frmUserType'],
                    'UserBillingAgreements' => $varUserBillingAgreements,
                    'UserMinimumProductPurchase' => $argArrPost['frmMinimumProductPurchase'],
                    'UserDateAdded' => 'now()',
                    'UserDateUpdated' => 'now()'
                );

                $varUsersWhere = ' pkUserID =' . $argArrPost['frmUserID'];

                $this->update(TABLE_USERS, $arrColumnAdd, $varUsersWhere);


                $objCore->setSuccessMsg(ADMIN_USER_UPDATE_SUCCUSS);
                return true;
            }
        }
    }

    /**
      *
      * Function name: addUser
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: add Users
      *
      * User instruction: $objUser->addUsers($argArrPost)
      *
      */

    function addUser($argArrPost) {
        //echo '<pre>';print_r($argArrPost); die;
        //@extract($argArrPost);
        $objCore = new Core;
        $_SESSION['sessArrUsers'] = array();
        if (!$this->checkUserValidation($argArrPost)) {
            $_SESSION['sessArrUsers'] = $argArrPost;
            return false;
        } else {
            $arrUserFlds = array('pkUserID');
            $varUserWhere = ' 1 AND UserEmail = \'' . $argArrPost['frmUserEmail'] . '\'';
            $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);

            if ($arrUserList) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg(ADMIN_USER_PRIMARY_EMAIL_ALREADY_EXIST);
                return false;
            } else {

                if ($argArrPost['frmBillingAgreementsContent']) {
                    $varUserBillingAgreements = $argArrPost['frmBillingAgreementsContent'];
                } else {
                    $arrAdminCol = array('AdminUserBillingAgreements');
                    $arrAdminBillinAgreement = $this->select(TABLE_ADMIN, $arrAdminCol);
                    $varUserBillingAgreements = $arrAdminBillinAgreement[0]['AdminUserBillingAgreements'];
                }


                $arrColumnAdd = array(
                    'UserFirstName' => $argArrPost['frmFirstName'],
                    'UserMiddleName' => $argArrPost['frmMiddleName'],
                    'UserLastName' => $argArrPost['frmLastName'],
                    'UserEmail' => $argArrPost['frmUserEmail'],
                    'UserPassword' => $argArrPost['frmPassword'],
                    'UserGender' => $argArrPost['frmGender'],
                    'UserStatus' => $argArrPost['frmUserStatus'],
                    'UserType' => $argArrPost['frmUserType'],
                    'UserBillingAgreements' => $varUserBillingAgreements,
                    'UserMinimumProductPurchase' => $argArrPost['frmMinimumProductPurchase'],
                    'UserDateAdded' => 'now()',
                    'UserDateUpdated' => 'now()'
                );

                $varUserID = $this->insert(TABLE_USERS, $arrColumnAdd);


                //Send Mail Ti User

                $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png' . '"/>';

                $varToUser = $argArrPost['frmUserEmail'];
                $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
                $varSubject = 'Venueset::Login Details';
                $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/admin_user_registration.html');

                $arrBodyKeywords = array('{USER}', '{USER_NAME}', '{PASSWORD}', '{SITE_NAME}');
                $arrBodyKeywordsValues = array($argArrPost['frmFirstName'], $argArrPost['frmUserEmail'], $argArrPost['frmPassword'], SITE_NAME);
                $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
                //echo $varToUser;echo $varBody;die;
                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);

                $objCore->setSuccessMsg(ADMIN_USER_ADD_SUCCUSS_MSG);
                return true;
            }
        }
    }

    /**
      *
      * Function name: checkUserBillingAddressValidation
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: check Users server side validation
      *
      * User instruction: $objUsers->checkUserBillingAddressValidation($argArrPost)
      *
      */ 

    function checkUserBillingAddressValidation($argArrPost) {
        //print_r($argArrPost);die;
        $objValid = new Validate_fields;
        $objCore = new Core();
        $objValid->check_4html = true;
        $_SESSION['sessArrUsers'] = array();

        $objValid->add_text_field('Business Address', strip_tags($argArrPost['frmAddressLine1']), 'text', 'y', 300);
        $objValid->add_text_field('Country', strip_tags($argArrPost['frmCountry']), 'text', 'y', 200);
        $objValid->add_text_field('State', strip_tags($argArrPost['frmState']), 'text', 'y', 200);
        $objValid->add_text_field('City', strip_tags($argArrPost['frmCity']), 'text', 'y', 200);
        $objValid->add_text_field('Zip Code', strip_tags($argArrPost['frmZipCode']), 'text', 'y', 200);


        if ($objValid->validation()) {
            $varErrorMsgFirst = 'Please enter required fields!';
        } else {
            $varErrorMsg = $objValid->create_msg();
        }


        if ($varErrorMsg) {
            $_SESSION['sessArrUsers'] = $argArrPost;
            $objCore->setErrorMsg($varErrorMsg);
            return false;
        } else {
            return true;
        }
    }

    /**
      *
      * Function name: addUserBillingAddress
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: add Users
      *
      * User instruction: $objUser->addUserBillingAddress($argArrPost)
      *
      */ 

    function addUserBillingAddress($argArrPost) {
        //echo '<pre>';print_r($argArrPost); die;
        //@extract($argArrPost);
        $objCore = new Core;
        $_SESSION['sessArrUsers'] = array();
        if (!$this->checkUserBillingAddressValidation($argArrPost)) {
            $_SESSION['sessArrUsers'] = $argArrPost;
            return false;
        } else {


            if ($argArrPost['frmDefaultAddress'] == 'Yes') {
                //update all other address as 'No'
                $arrUpdateData = array('UserBillingAddressDefault' => 'No');
                $varWhereClause = ' fkUserID = ' . $argArrPost['frmUserID'];
                $this->update(TABLE_USER_BILLING_ADDRESS, $arrUpdateData, $varWhereClause);
            }



            $arrColumnAdd = array(
                'fkUserID' => $argArrPost['frmUserID'],
                'UserBusinessName' => $argArrPost['frmBusinessName'],
                'UserBillingAddressLine1' => $argArrPost['frmAddressLine1'],
                'UserBillingAddressLine2' => $argArrPost['frmAddressLine2'],
                'UserBillingAddressCity' => $argArrPost['frmCity'],
                'fkStateID' => $argArrPost['frmState'],
                'fkCountryID' => $argArrPost['frmCountry'],
                'UserBillingAddressZipCode' => $argArrPost['frmZipCode'],
                'UserBillingAddressFederalTaxID' => $argArrPost['frmFederalTaxID'],
                'UserBillingAddressPhone' => $argArrPost['frmPhone'],
                'UserBillingAddressFax' => $argArrPost['frmFax'],
                'UserBillingAddressWebsite' => $argArrPost['frmWebsite'],
                'UserBillingAddressDefault' => $argArrPost['frmDefaultAddress'],
                'UserBillingAddressStatus' => $argArrPost['frmBillingAddressStatus'],
                'UserBillingAddressDateAdded' => 'now()',
            );

            $this->insert(TABLE_USER_BILLING_ADDRESS, $arrColumnAdd);



            $objCore->setSuccessMsg(ADMIN_USER_BILLING_ADDRESS_ADD_SUCCUSS_MSG);
            return true;
        }
    }

    /**
      *
      * Function name: addUserShippingAddress
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: add Users
      *
      * User instruction: $objUser->addUserBillingAddress($argArrPost)
      *
      */ 

    function addUserShippingAddress($argArrPost) {
        //echo '<pre>';print_r($argArrPost); 
        //@extract($argArrPost);
        $objCore = new Core;
        $_SESSION['sessArrShippingAddress'] = array();
        if (!$this->checkUserBillingAddressValidation($argArrPost)) {
            $_SESSION['sessArrShippingAddress'] = $argArrPost;
            return false;
        } else {
            if ($argArrPost['frmDefaultAddress'] == 'Yes') {
                //update all other address as 'No'
                $arrUpdateData = array('UserShippingAddressDefault' => 'No');
                $varWhereClause = ' fkUserID = ' . $argArrPost['frmUserID'];
                $this->update(TABLE_USER_SHIPPING_ADDRESS, $arrUpdateData, $varWhereClause);
            }



            $arrColumnAdd = array(
                'fkUserID' => $argArrPost['frmUserID'],
                'UserShippingAddressLine1' => $argArrPost['frmAddressLine1'],
                'UserShippingAddressLine2' => $argArrPost['frmAddressLine2'],
                'UserShippingAddressCity' => $argArrPost['frmCity'],
                'fkStateID' => $argArrPost['frmState'],
                'fkCountryID' => $argArrPost['frmCountry'],
                'UserShippingAddressZipCode' => $argArrPost['frmZipCode'],
                'UserShippingAddressPhone' => $argArrPost['frmPhone'],
                'UserShippingAddressFax' => $argArrPost['frmFax'],
                'UserShippingAddressDefault' => $argArrPost['frmDefaultAddress'],
                'UserShippingAddressStatus' => $argArrPost['frmShippingAddressStatus'],
                'UserShippingAddressDateAdded' => 'now()'
            );
            //print_r($arrColumnAdd);die;		       
            $this->insert(TABLE_USER_SHIPPING_ADDRESS, $arrColumnAdd);



            $objCore->setSuccessMsg(ADMIN_USER_SHIPPING_ADDRESS_ADD_SUCCUSS_MSG);
            return true;
        }
    }

   /**
      *
      * Function name: editUser
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: edit Users
      *
      * User instruction: $objUser->editUsers($argArrPost)
      *
      */

    function editUserShippingAddress($argArrPost) {
        //@extract($argArrPost);

        $objCore = new Core;
        $objGeneral = new General();
        $_SESSION['sessArrShippingAddress'] = array();
        if (!$this->checkUserBillingAddressValidation($argArrPost)) {
            $_SESSION['sessArrShippingAddress'] = $argArrPost;
            return false;
        } else {

            if ($argArrPost['frmDefaultAddress'] == 'Yes') {
                //update all other address as 'No'
                $arrUpdateData = array('UserShippingAddressDefault' => 'No');
                $varWhereClause = ' fkUserID = ' . $argArrPost['frmUserID'];
                $this->update(TABLE_USER_SHIPPING_ADDRESS, $arrUpdateData, $varWhereClause);
            }



            $arrColumnAdd = array(
                'fkUserID' => $argArrPost['frmUserID'],
                'UserShippingAddressLine1' => $argArrPost['frmAddressLine1'],
                'UserShippingAddressLine2' => $argArrPost['frmAddressLine2'],
                'UserShippingAddressCity' => $argArrPost['frmCity'],
                'fkStateID' => $argArrPost['frmState'],
                'fkCountryID' => $argArrPost['frmCountry'],
                'UserShippingAddressZipCode' => $argArrPost['frmZipCode'],
                'UserShippingAddressPhone' => $argArrPost['frmPhone'],
                'UserShippingAddressFax' => $argArrPost['frmFax'],
                'UserShippingAddressDefault' => $argArrPost['frmDefaultAddress'],
                'UserShippingAddressStatus' => $argArrPost['frmShippingAddressStatus'],
                'UserShippingAddressDateUpdated' => 'now()'
            );

            $varUsersWhere = 'pkUserShippingAddressID = ' . $argArrPost['frmShippingID'];
            $this->update(TABLE_USER_SHIPPING_ADDRESS, $arrColumnAdd, $varUsersWhere);


            $objCore->setSuccessMsg(ADMIN_USER_SHIPPING_ADDRESS_UPDATE_SUCCUSS_MSG);
            return true;
        }
    }

    /**
      *
      * Function name: editUser
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: edit Users
      *
      * User instruction: $objUser->editUsers($argArrPost)
      *
      */

    function editUserBillingAddress($argArrPost) {
        //@extract($argArrPost);

        $objCore = new Core;
        $objGeneral = new General();
        $_SESSION['sessArrBillingAddress'] = array();
        if (!$this->checkUserBillingAddressValidation($argArrPost)) {
            $_SESSION['sessArrBillingAddress'] = $argArrPost;
            return false;
        } else {


            if ($argArrPost['frmDefaultAddress'] == 'Yes') {
                //update all other address as 'No'
                $arrUpdateData = array('UserBillingAddressDefault' => 'No');
                $varWhereClause = ' fkUserID = ' . $argArrPost['frmUserID'];
                $this->update(TABLE_USER_BILLING_ADDRESS, $arrUpdateData, $varWhereClause);
            }


            $arrColumnAdd = array(
                'fkUserID' => $argArrPost['frmUserID'],
                'UserBusinessName' => $argArrPost['frmBusinessName'],
                'UserBillingAddressLine1' => $argArrPost['frmAddressLine1'],
                'UserBillingAddressLine2' => $argArrPost['frmAddressLine2'],
                'UserBillingAddressCity' => $argArrPost['frmCity'],
                'fkStateID' => $argArrPost['frmState'],
                'fkCountryID' => $argArrPost['frmCountry'],
                'UserBillingAddressZipCode' => $argArrPost['frmZipCode'],
                'UserBillingAddressFederalTaxID' => $argArrPost['frmFederalTaxID'],
                'UserBillingAddressPhone' => $argArrPost['frmPhone'],
                'UserBillingAddressFax' => $argArrPost['frmFax'],
                'UserBillingAddressWebsite' => $argArrPost['frmWebsite'],
                'UserBillingAddressDefault' => $argArrPost['frmDefaultAddress'],
                'UserBillingAddressStatus' => $argArrPost['frmBillingAddressStatus'],
                'UserBillingAddressDateAdded' => 'now()',
            );

            $varUsersWhere = 'pkUserBillingAddressID = ' . $argArrPost['frmBillingID'];
            $this->update(TABLE_USER_BILLING_ADDRESS, $arrColumnAdd, $varUsersWhere);


            $objCore->setSuccessMsg(ADMIN_USER_BILLING_ADDRESS_UPDATE_SUCCUSS_MSG);
            return true;
        }
    }
    /**
      *
      * Function name: ValidUser
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: valid Users
      *
      * User instruction: $objUser->ValidUser()
      *
      */
    function ValidUser() {
        if (isset($_SESSION['ASP_UserName']) && $_SESSION['ASP_UserName'] != '') {

            $arrUserFlds = array('FirstName', 'MiddleName', 'LastName', 'UserName', 'Password', 'PrimaryEmailAddress', 'SecondaryEmailAddress', 'Mobile', 'PhoneFirst', 'PhoneSecond', 'Fax', 'AddressLineFirst', 'AddressLineSecond', 'City', 'State', 'Country', 'ZipCode');
            $varUserWhere = ' 1 AND UserName = \'' . $_SESSION['ASP_UserName'] . '\'';
            $arrUserDetail = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);
            return $arrUserDetail;
        } else {
            return false;
        }
    }

     /**
      *
      * Function name: addFrontEndUser
      *
      * Return type : Boolean
      *
      * Date created : 09th May 2011
      *
      * Date last modified :  09th May 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: add Users
      *
      * User instruction: $objUser->addFrontEndUser($argArrPost)
      *
      */

    function addFrontEndUser($argArrPost) {
        //echo '<pre>';print_r($argArrPost); //die;
        $objCore = new Core;
        $_SESSION['sessArrUsers'] = array();
        if (!$this->checkFrontUserValidation($argArrPost)) {
            $_SESSION['sessArrUsers'] = $argArrPost;
            return false;
        } else {
            $arrUserFlds = array('pkUserID');
            $varUserWhere = ' 1 AND UserEmail = \'' . $argArrPost['frmUserEmail'] . '\'';
            $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);

            if ($arrUserList) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg(FRONT_USER_EMAIL_ALREADY_EXIST);
                return false;
            } else {

                $arrColumnAdd = array(
                    'UserFirstName' => $argArrPost['frmUserFirstName'],
                    'UserLastName' => $argArrPost['frmUserLastName'],
                    'UserEmail' => $argArrPost['frmUserEmail'],
                    'UserPassword' => trim($argArrPost['frmUserPassword']),
                    'UserGender' => $argArrPost['frmUserGender'],
                    'UserType' => $argArrPost['frmHiddenUserType'],
                    'UserStatus' => 'Active',
                    'UserDateAdded' => 'now()',
                    'UserDateUpdated' => 'now()'
                );

                $varUserID = $this->insert(TABLE_USERS, $arrColumnAdd);


                if ($argArrPost['frmHiddenUserType'] == 'Member') {

                    $arrFavouriteFragrance = array();
                    for ($i = 1; $i <= 4; $i++) {
                        if ($argArrPost['frmFavouriteFragrance_' . $i] <> '') {
                            $arrFavouriteFragrance[] = $argArrPost['frmFavouriteFragrance_' . $i];
                        }
                    }

                    $varFavouriteFragrance = base64_encode(json_encode($arrFavouriteFragrance));

                    /* $s=json_decode(base64_decode($varFavouriteFragrance),true);
                      print_r($s);die; */

                    $arrColumnAdd = array(
                        'fkUserID' => $varUserID,
                        'MemberDetailsEmailOption' => $argArrPost['frmUserEmailOptions'],
                        'MemberDetailsAddress1' => $argArrPost['frmUserAddress1'],
                        'MemberDetailsAddress2' => $argArrPost['frmUserAddress2'],
                        'fkCountryID' => $argArrPost['frmUserCountry'],
                        'MemberDetailsCity' => $argArrPost['frmUserCity'],
                        'MemberDetailsZipCode' => $argArrPost['frmUserZipCode'],
                        'MemberDetailsPhone' => $argArrPost['frmUserPhone'],
                        'fkStateID' => $argArrPost['frmUserState'],
                        'MemberDetailsFavouriteFragrances' => $varFavouriteFragrance,
                        'MemberDetailsDateAdded' => 'now()',
                    );

                    $this->insert(TABLE_MEMBER_OTHER_DETAILS, $arrColumnAdd);
                }

                if ($argArrPost['frmHiddenUserType'] == 'WholeSaler') {

                    $arrColumnAdd = array(
                        'fkUserID' => $varUserID,
                        'UserBusinessName' => $argArrPost['frmBusinessName'],
                        'UserBillingAddressLine1' => $argArrPost['frmBusinessAddress1'],
                        'UserBillingAddressLine2' => $argArrPost['frmBusinessAddress2'],
                        'UserBillingAddressCity' => $argArrPost['frmCity'],
                        'fkStateID' => $argArrPost['frmState'],
                        'fkCountryID' => $argArrPost['frmCountry'],
                        'UserBillingAddressZipCode' => $argArrPost['frmZipCode'],
                        'UserBillingAddressFederalTaxID' => $argArrPost['frmFederalTaxID'],
                        'UserBillingAddressPhone' => $argArrPost['frmBusinessPhone'],
                        'UserBillingAddressFax' => $argArrPost['frmBusiNessFax'],
                        'UserBillingAddressWebsite' => $argArrPost['frmBusinessWebsite'],
                        'UserBillingAddressDateAdded' => 'now()',
                    );

                    $this->insert(TABLE_USER_BILLING_ADDRESS, $arrColumnAdd);
                }





                //Send Mail To User

                $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png' . '"/>';

                $varToUser = $argArrPost['frmUserEmail'];
                $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
                $varSubject = 'Venueset::Login Details';
                $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/admin_user_registration.html');

                $arrBodyKeywords = array('{USER}', '{USER_NAME}', '{PASSWORD}', '{SITE_NAME}');
                $arrBodyKeywordsValues = array($argArrPost['frmUserFirstName'], $argArrPost['frmUserEmail'], trim($argArrPost['frmUserPassword']), SITE_NAME);
                $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
                //echo $varToUser;echo $varBody;die;
                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);

                // Send Mail to admin

                $varNewUserSubject = 'Venueset::New User Registered';
                $varNewUserRegistrationOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/user_registration.html');
                $arrNewUserRegistrationBodyKeywords = array('{USER_FIRST_NAME}', '{LAST_NAME}', '{USER_EMAIL}', '{USER_TYPE}', '{USER_REGISTRATION_DATE}', '{SITE_NAME}');
                $registrationDate = date('Y-m-d');
                $arrNewUserRegistrationBodyKeywordsValues = array($argArrPost['frmUserFirstName'], $argArrPost['frmUserEmail'], $argArrPost['frmHiddenUserType'], $argArrPost['frmUserEmail'], date('d-m-Y'), SITE_NAME);
                $varNewUserRegistrationBody = str_replace($arrNewUserRegistrationBodyKeywords, $arrNewUserRegistrationBodyKeywordsValues, $varNewUserRegistrationOutput);
                //echo $varToUser;echo $varNewUserRegistrationBody;die;
                $objCore->sendMail(ADMIN_CONTACT_EMAIL, $varFromUser, $varNewUserSubject, $varNewUserRegistrationBody);

                $objCore->setSuccessMsg(FRONT_USER_ADD_SUCCUSS_MSG);
                return true;
            }
        }
    }

    /**
      *
      * Function name: checkUpdateFrontUserValidation
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: check Users server side validation
      *
      * User instruction: $objUsers->checkUpdateFrontUserValidation($argArrPost)
      *
      */ 

    function checkFrontUserValidation($argArrPost) {
        //print_r($argArrPost);die;
        $objValid = new Validate_fields;
        $objCore = new Core();
        $objValid->check_4html = true;
        $_SESSION['sessArrUsers'] = array();
        $objValid->add_text_field('Email Address', strip_tags($argArrPost['frmUserEmail']), 'email', 'y', 100);
        $objValid->add_text_field('First Name', strip_tags($argArrPost['frmUserFirstName']), 'text', 'y', 100);
        $objValid->add_text_field('Password', strip_tags($argArrPost['frmUserPassword']), 'text', 'y', 100);

        if ($argArrPost['frmHiddenUserType'] == 'WholeSaler') {
            $objValid->add_text_field('Business Name', strip_tags($argArrPost['frmBusinessName']), 'text', 'y', 200);
            $objValid->add_text_field('Business Address', strip_tags($argArrPost['frmBusinessAddress1']), 'text', 'y', 300);
            $objValid->add_text_field('Country', strip_tags($argArrPost['frmCountry']), 'text', 'y', 200);
            $objValid->add_text_field('State', strip_tags($argArrPost['frmState']), 'text', 'y', 200);
            $objValid->add_text_field('City', strip_tags($argArrPost['frmCity']), 'text', 'y', 200);
            $objValid->add_text_field('Zip Code', strip_tags($argArrPost['frmZipCode']), 'text', 'y', 200);
        }


        if ($objValid->validation()) {
            $varErrorMsgFirst = 'Please enter required fields!';
        } else {
            $varErrorMsg = $objValid->create_msg();
        }

        if ($argArrPost['frmHiddenUserType'] == 'WholeSaler') {
            if ($argArrPost['frmCaptcha'] != $_SESSION['security_code']) {
                $varErrorMsg .= REGISTRATION_CAPTCHA_ERROR;
            }
        }

        if ($varErrorMsg) {
            $_SESSION['sessArrUsers'] = $argArrPost;
            $objCore->setErrorMsg($varErrorMsg);
            return false;
        } else {
            return true;
        }
    }

    /**
      *
      * Function name: editFrontEndUserDetail
      *
      * Return type : Boolean
      *
      * Date created : 09th May 2011
      *
      * Date last modified :  09th May 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: add Users
      *
      * User instruction: $objUser->editFrontEndUserDetail($argArrPost)
      *
      */ 

    function editFrontEndUserDetail($argArrPost) {
        //echo '<pre>';print_r($argArrPost); die;
        @extract($argArrPost);
        $objCore = new Core;
        $_SESSION['sessArrUsers'] = array();
        if (!$this->checkUpdateFrontUserValidation($argArrPost)) {
            $_SESSION['sessArrUsers'] = $argArrPost;
            return false;
        } else {
            $varUsersWhere = ' pkUserID =' . $_SESSION['ASP_UserID'];
            $arrColumnAdd = array(
                'FirstName' => $frmFirstName,
                'MiddleName' => $frmMiddleName,
                'LastName' => $frmLastName,
                'SecondaryEmailAddress' => $frmSecondaryEmailAddress,
                'Mobile' => $frmMobile,
                'PhoneFirst' => $frmPhoneFirst,
                'PhoneSecond' => $frmPhoneSecond,
                'Fax' => $frmFax,
                'AddressLineFirst' => $frmAddressLineFirst,
                'AddressLineSecond' => $frmAddressLineSecond,
                'City' => $frmCity,
                'State' => $frmState,
                'Country' => $frmCountry,
                'ZipCode' => $frmZipCode,
                'UserModifiedDate' => 'now()'
            );

            $varUserID = $this->update(TABLE_USERS, $arrColumnAdd, $varUsersWhere);


            $arrColumnAdd = array(
                'BAddressLineFirst' => $frmBAddressLineFirst,
                'BAddressLineSecond' => $frmBAddressLineSecond,
                'BCity' => $frmBCity,
                'BState' => $frmBState,
                'BCountry' => $frmBCountry,
                'BZipCode' => $frmBZipCode,
                'BModifiedDate' => 'now()'
            );
            $varUsersWhere = ' fkUserID =' . $_SESSION['ASP_UserID'];
            $this->update(TABLE_USERS_BILLING, $arrColumnAdd, $varUsersWhere);

            $arrColumnAdd = array(
                'SAddressLineFirst' => $frmSAddressLineFirst,
                'SAddressLineSecond' => $frmSAddressLineSecond,
                'SCity' => $frmSCity,
                'SState' => $frmSState,
                'SCountry' => $frmSCountry,
                'SZipCode' => $frmSZipCode,
                'SModifiedDate' => 'now()'
            );
            $varUsersWhere = ' fkUserID =' . $_SESSION['ASP_UserID'];
            $this->update(TABLE_USERS_SHIPPING, $arrColumnAdd, $varUsersWhere);

            $objCore->setSuccessMsg(FRONT_USER_UPDATE_SUCCUSS_MSG);
            return true;
        }
    }
    /**
      *
      * Function name: changeUserPassword
      *
      * Return type : Boolean
      *
      * Date created : 09th May 2011
      *
      * Date last modified :  09th May 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: change Users Password
      *
      * User instruction: $objUser->changeUserPassword($argArrPost)
      *
      */ 
    function changeUserPassword($argArrPOST) {
        //print_r($argArrPOST);
        $objValid = new Validate_fields;
        $objCore = new Core();
        $objValid->check_4html = true;

        $objValid->add_text_field('Current Password', $argArrPOST['frmPassword'], 'text', 'y', 20);
        $objValid->add_text_field('New Password', strip_tags($argArrPOST['frmNewPassword']), 'text', 'y', 20);
        $objValid->add_text_field('Confirm New password', strip_tags($argArrPOST['frmNewConfPassword']), 'text', 'y', 20);

        if ($objValid->validation()) {
            $varErrorMsgFirst = 'Please enter required fields!';
        } else {
            $varErrorMsg = $objValid->create_msg();
        }

        if ($varErrorMsg) {
            $objCore->setErrorMsg($varErrorMsg);
            return false;
        }

        $arrUserFlds = array('Password');
        $varUserWhere = ' 1 AND pkUserID = \'' . $_SESSION['ASP_UserID'] . '\'';
        $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);
        //echo $arrUserList[0]['Password'];echo "<br/>";
        //echo $argArrPOST['frmPassword'];die;
        if ($arrUserList[0]['Password'] == trim($argArrPOST['frmPassword'])) {
            $varUsersWhere = ' pkUserID =' . $_SESSION['ASP_UserID'];
            $arrColumnAdd = array(
                'Password' => trim($argArrPOST['frmNewPassword']),
                'UserModifiedDate' => 'now()'
            );

            $varUserID = $this->update(TABLE_USERS, $arrColumnAdd, $varUsersWhere);

            $objCore->setSuccessMsg(FRONT_END_PASSWORD_SUCC_CHANGE);
            return true;
        } else {
            $objCore->setErrorMsg(FRONT_END_INVALID_CURENT_PASSWORD);
            return false;
        }
    }

    /**
      *
      * Function name: setUserStatus
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: Change User status.
      *
      * User instruction: $objUser->setUserStatus($argArrPOST)
      *
      */ 

    function setUserStatus($argArrPOST) {
        $objCore = new Core();
        $varMessage = '';
        foreach ($argArrPOST['frmUsersID'] as $varUsersID) {
            /* To get the page status */

            //Listing related child category
            $varUsersWhereCon = 'pkUserID = \'' . $varUsersID . '\'';
            $arrUsersClms = array('UserStatus' => $argArrPOST['frmChangeAction'], 'UserDateUpdated' => 'now()');
            $varaffectedRecord = $this->update(TABLE_USERS, $arrUsersClms, $varUsersWhereCon);
        }
        if ($argArrPOST['frmChangeAction'] == 'Active') {
            $objCore->setSuccessMsg(ADMIN_USER_ACTIVATE_MESSAGE);
            return true;
        } else {
            $objCore->setSuccessMsg(ADMIN_USER_DEACTIVETED_MESSAGE);

            return true;
        }
    }

    /**
      *
      * Function name : removeUserInformation
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments : Remove Users information.
      *
      * User instruction :  $objUser->removeUsersInformation($argArrPOST)
      *
      */ 

    function removeUserInformation($argArrPOST) {
        $objCore = new Core();
        $objGeneral = new General();
        $varMessage = '';
        foreach ($argArrPOST['frmUsersID'] as $varDeleteUsersID) {

            $varWhereCondition = ' pkUserID = \'' . $varDeleteUsersID . '\'';

            //Listing related child category
            $this->delete(TABLE_USERS, $varWhereCondition);
        }

        $objCore->setSuccessMsg(ADMIN_USER_DELETE_MESSAGE);


        return true;
    }

    /**
      *
      * Function name: sendUserForgotPassword
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: Change User status.
      *
      * User instruction: $objUser->sendUserForgotPassword($argArrPOST)
      *
      */

    function sendUserForgotPassword($argArrPOST) {

        @extract($argArrPost);
        $objValid = new Validate_fields;
        $objCore = new Core();
        $objValid->check_4html = true;

        $objValid->add_text_field('Email', strip_tags($argArrPOST['frmUserLoginEmail']), 'email', 'y');

        if ($objValid->validation()) {
            $errorMsgFirst = 'Please enter valid email address!';
        } else {
            $errorMsg = $objValid->create_msg();
        }
        if ($errorMsg) {
            $objCore->setErrorMsg($errorMsg);
            return false;
        } else {
            $arrUserFlds = array('pkUserID', 'UserFirstName', 'UserEmail', 'UserPassword');
            $varUserWhere = ' 1 AND UserEmail = \'' . trim($argArrPOST['frmUserLoginEmail']) . '\'';
            $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);
            if ($arrUserList) {
                //update the random key in the database

                $varRandomKey = md5(uniqid(microtime()));
                $arrUpdateArray = array('UserAuthorizationToken' => $varRandomKey);
                $varaffectedRecord = $this->update(TABLE_USERS, $arrUpdateArray, $varUserWhere);


                $argUserName = $arrUserList[0]['UserEmail'];
                $argPassword = $arrUserList[0]['UserPassword'];
                $argFirstName = $arrUserList[0]['UserFirstName'];

                //Send forget Password To User
                $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png' . '"/>';

                $varToUser = $argArrPOST['frmUserLoginEmail'];
                $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
                $varSubject = 'Venueset::Login Details';
                $varResetPasswordlink = '<a href="' . SITE_ROOT_URL . 'reset_password.php?userId=' . $arrUserList[0]['pkUserID'] . '&authorizationToken=' . base64_encode($varRandomKey) . '">Reset Password</a>';
                $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/user_forget_password.html');

                $arrBodyKeywords = array('{USER_FIRST_NAME}', '{USER_NAME}', '{USER_PASSWORD}', '{IMAGE_PATH}', '{SITE_NAME}', '{RESET_PASSWORD_LINK}');

                $arrBodyKeywordsValues = array($argFirstName, $argUserName, $argPassword, $varPath, SITE_NAME, $varResetPasswordlink);
                $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);

                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);
                $objCore->setSuccessMsg(FRON_END_USER_FORGET_PASSWORD_SEND);
                return true;
            } else {
                $objCore->setErrorMsg(FRON_END_USER_EMAIL_EXIST_ERROR);
                return false;
            }
        }
    }

    /**
      *
      * Function name: userLogin
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: Change User status.
      *
      * User instruction: $objUser->userLogin($argArrPOST)
      *
      */

    function userLogin($argArrPost) {
        //echo '<pre>';print_r($argArrPost);exit;
        //@extract($argArrPost);
        $objValid = new Validate_fields;
        $objCore = new Core();
        $arrUserFlds = array('pkUserID', 'UserEmail', 'UserPassword');
        $varUserWhere = ' 1 AND UserEmail = \'' . $argArrPost['frmUserLoginEmail'] . '\' AND UserPassword = \'' . trim($argArrPost['frmUserLoginPassword']) . '\'';
        //echo '<pre>';print_r($varUserWhere);exit;
        $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);


        if (count($arrUserList) > 0) {
//			$_SESSION['VenusetP_UserEmail'] = $arrUserList[0]['UserEmail'];
//			$_SESSION['VenusetP_UserID'] = $arrUserList[0]['pkUserID'];

            $_SESSION['VenusetP_UserEmail'] = $arrUserList[0]['UserEmail'];
            $_SESSION['VenusetP_UserID'] = $arrUserList[0]['pkUserID'];
            return true;
        } else {
            $objCore->setErrorMsg(FRON_END_USER_LOGIN_ERROR);
            return false;
        }
    }

    /**
      *
      * Function name: checkUserAuthorization
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: Change User status.
      *
      * User instruction: $objUser->userLogin($argArrPOST)
      *
      */

    function checkUserAuthorization($argUserID, $argAuthorizationToken) {
        $varUserAuthorizationToken = base64_decode($argAuthorizationToken);

        $objCore = new Core();
        $arrUserFlds = array('pkUserID');
        $varUserWhere = ' 1 AND pkUserID = \'' . $argUserID . '\' AND UserAuthorizationToken = \'' . $varUserAuthorizationToken . '\'';
        $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);
        //echo '<pre>';print_r($arrUserList);
        if (count($arrUserList) > 0) {
            //blank the authorization token
            $varUsersWhere = ' pkUserID =' . $argUserID;
            $arrColumn = array(
                'UserAuthorizationToken' => ''
            );

            $varUserID = $this->update(TABLE_USERS, $arrColumn, $varUsersWhere);
            return true;
        } else {
            $objCore->setErrorMsg('You are not the authorized user or your authorization token has been expired.');
            header('location:forgot_password.php');
            exit;
        }
    }

    /**
      *
      * Function name: checkUserAuthorization
      *
      * Return type : Boolean
      *
      * Date created : 20th April 2011
      *
      * Date last modified : 20th April 2011
      *
      * Author : Deepesh Pathak
      *
      * Last modified by : Deepesh Pathak
      *
      * Comments: Change User status.
      *
      * User instruction: $objUser->userLogin($argArrPOST)
      *
      */

    function resetUserPassword($argArrPOST) {
        //print_r($argArrPOST);
        $objValid = new Validate_fields;
        $objCore = new Core();
        $objValid->check_4html = true;

        $objValid->add_text_field('Current Password', $argArrPOST['frmUserOldPassword'], 'text', 'y', 20);
        $objValid->add_text_field('New Password', strip_tags($argArrPOST['frmUserNewPassword']), 'text', 'y', 20);
        $objValid->add_text_field('Confirm New password', strip_tags($argArrPOST['frmUserConfirmPassword']), 'text', 'y', 20);

        if ($objValid->validation()) {
            $varErrorMsgFirst = 'Please enter required fields!';
        } else {
            $varErrorMsg = $objValid->create_msg();
        }

        if ($varErrorMsg) {
            $objCore->setErrorMsg($varErrorMsg);
            return false;
        }

        $arrUserFlds = array('UserPassword');
        $varUserWhere = ' 1 AND pkUserID = \'' . $argArrPOST['frmHiddenUserID'] . '\'';
        $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);
        //echo $arrUserList[0]['Password'];echo "<br/>";
        //echo $argArrPOST['frmPassword'];die;
        if ($arrUserList[0]['UserPassword'] == trim($argArrPOST['frmUserOldPassword'])) {
            $varUsersWhere = ' pkUserID =' . $argArrPOST['frmHiddenUserID'];
            $arrColumnAdd = array(
                'UserPassword' => trim($argArrPOST['frmUserNewPassword']),
                'UserDateUpdated' => 'now()'
            );

            $varUserID = $this->update(TABLE_USERS, $arrColumnAdd, $varUsersWhere);

            $objCore->setSuccessMsg(FRONT_END_PASSWORD_SUCC_CHANGE);
            return true;
        } else {
            $objCore->setErrorMsg(FRONT_END_INVALID_CURENT_PASSWORD);
            return false;
        }
    }
    
}

?>
