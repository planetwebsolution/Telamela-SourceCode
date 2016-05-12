<?php

Class AdminUser extends Database {

    /** This array holds the job titles */
    //public $arrJobTitles = array('Manager'=>'Manager', 'Assistant Manager'=>'Assistant Manager');

    public $arrJobTitles = array('Business' => 'Business Owner', 'Owner Manager' => 'Store Manager', 'Assistant Manager');
    var $arrUserSearchAlphabets = array('A' => 'a', 'B' => 'b', 'C' => 'c', 'D' => 'd', 'E' => 'e', 'F' => 'f', 'G' => 'g', 'H' => 'h', 'I' => 'i', 'J' => 'j', 'K' => 'k', 'L' => 'l', 'M' => 'm', 'N' => 'n', 'O' => 'o', 'P' => 'p', 'Q' => 'q', 'R' => 'r', 'S' => 's', 'T' => 't', 'U' => 'u', 'V' => 'v', 'W' => 'w', 'X' => 'x', 'Y' => 'y', 'Z' => 'z');

    function AdminUser() {
        
        //default constructor
    }

    /*     * ****************************************
      Function name:getUsersList
      Return type: Associated array
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: show listing of Users
      User instruction: $objUsers->getUsersList($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '')
     * **************************************** */

    function getUserList($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '', $orderby = '') {
        if (count($argArrRequest) > 0) {
            $arrUserFlds = $argArrRequest;
        } else {
            $arrUserFlds = array();
        }
        //Call getSortColumn function to get column name and sort option $this->orderOptions;
        $this->getSortColumn($_REQUEST);

        //Prepare where condition
        $varUserWhere = ' 1 ' . $argVarSearchWhere;

        if ($orderby != '') {
            $this->orderOptions = $orderby;
        }

        $arrUserList = $this->select($argVarTable, $arrUserFlds, $varUserWhere, $this->orderOptions, $argVarEndLimit);

        //return all record
        return $arrUserList;
    }

    /*     * ****************************************
      Function name:getSortColumn
      Return type: String
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: sort coloum for Users
      User instruction: $objUsers->getSortColumn($argVarSortOrder)
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
        $objOrder->addColumn('Name', 'UserFirstName');
//			$objOrder->addColumn('User Type', 'UserType');
        $objOrder->addColumn('Email', 'UserEmail');
        $objOrder->addColumn('Venues');
        $objOrder->addColumn('Date Added', 'UserDateAdded');
        $objOrder->addColumn('Status', 'UserStatus');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /*     * ****************************************
      Function Name: getUserString
      Return type: String
      Date created : 20th April 2011
      Date last modified : 12th October 2012
      Author : Deepesh Pathak
      Last modified by : Aditya Pratap Singh
      Comments: Generates a querystring for the Users table that will be used in judge search where condition.
      User instruction: objClient->getClientString($argArrPost)
     * **************************************** */

    function getUserString($argArrPost) {
        //print_r($argArrPost); die;
        $varSearchWhere = ' ';
        if ($argArrPost['frmSearchUserNameResult'] != '') {
            $varSearchWhere .= 'AND UserFirstName LIKE \'%' . trim(addslashes($argArrPost['frmSearchUserNameResult'])) . '%\'';
        }

        if ($argArrPost['frmSearchUserMailResult'] != '') {
            $varSearchWhere .= 'AND UserEmail LIKE \'%' . trim(addslashes($argArrPost['frmSearchUserMailResult'])) . '%\'';
        }

        if ($argArrPost['frmSearchUserStatus'] != '') {
            $varSearchWhere .= 'AND UserStatus = \'' . $argArrPost['frmSearchUserStatus'] . '\'';
        }
        // date wise selection query string 


        /* 			if($argArrPost['frmDate'] != '' && $argArrPost['frmDate'] != 'From')
          {

          $varFromDate = $argArrPost['frmDate'];
          $varSearchWhere .= ' AND (DATE_FORMAT(UserDateAdded, \'%Y-%m-%d\') >= STR_TO_DATE(\''.$varFromDate.'\', \'%Y-%m-%d\')';
          if($argArrPost['frmToDate'] != '' && $argArrPost['frmToDate'] != 'To')
          {
          $varToDate = $argArrPost['frmToDate'];
          $varSearchWhere .= ' AND DATE_FORMAT(UserDateAdded, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$varToDate.'\',\'%Y-%m-%d\'))';
          }
          else
          {
          $varSearchWhere .= ')';
          }
          }
          if($argArrPost['frmDate'] == '' || $argArrPost['frmDate'] == 'From')
          {
          if($argArrPost['frmToDate'] != '' && $argArrPost['frmToDate'] != 'To')
          {
          $varToDate = $argArrPost['frmToDate'];
          $varSearchWhere .= ' AND DATE_FORMAT(UserDateAdded, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$varToDate.'\',\'%Y-%m-%d\')';
          }
          }
         */
        return $varSearchWhere;
    }

    /*     * ****************************************
      Function name: ArchiveUser
      Return type : Boolean
      Date created : 19 Oct 2012
      Date last modified : 19 Oct 2012
      Author : Aditya Pratap Singh
      Last modified by : Aditya Pratap Singh
      Comments: archive user records and users assosiated venues
      User instruction: $obj->ArchiveUser($argArrPost)
     * **************************************** */

    function ArchiveUser($argArrPOST) {
        $objCore = new Core();
        $objCommon = new ClassCommon();
        $objVenue = new Venue();


        $varID = $argArrPOST['frmUserID'];

        $checksql = "Select pkUserID from " . TABLE_ARCHIVE_USERS . " where pkUserID = " . $varID;
        $num_rows = mysql_num_rows($this->query($checksql));

        $venues = $this->getUserVenues("venues", "pkVenueID, VenueName", "fkuserID = $varID");
//            $venues = $venues[0];
        foreach ($venues as $venue) {
            $arr['frmVenueID'] = $venue['pkVenueID'];
            $objVenue->ArchiveVenue($arr);
        }

        $varWhere = 'pkUserID = \'' . $varID . '\'';

        if ($num_rows <= 0) {

            $sql = 'INSERT INTO ' . TABLE_ARCHIVE_USERS . ' SELECT * FROM ' . TABLE_USERS . ' WHERE  ' . $varWhere;

            $this->query($sql);
            $responce = mysql_affected_rows();

            //Listing related child category
            $this->delete(TABLE_USERS, $varWhere);
//                $this->deleteVenue($argArrPOST);
        } else {
            $this->delete(TABLE_USERS, $varWhere);
//                $this->deleteVenue($argArrPOST);
            $responce = mysql_affected_rows();
        }

        if ($responce) {
            $objCore->setSuccessMsg(USER_ARCHIVED_SUCCESSFULLY);
            return true;
        } else {
            $objCore->setErrorMsg(USER_ARCHIVED_FAILED);
            return true;
        }
    }

    /*     * ****************************************
      Function name: getUsersInfo
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: general Users function
      User instruction: $objUsers->getUsersInfo$argVarTable, $argArrClm = array(), $argVarWhere = '')
     * **************************************** */

    function getUserInfo($argVarTable, $argArrClm = array(), $argVarWhere = '') {
        if (count($argArrClm) > 0) {
            $arrFlds = $argArrClm;
        } else {
            $arrFlds = array();
        }
        $arrList = $this->select($argVarTable, $arrFlds, $argVarWhere);
        return $arrList;
    }

    /*     * ****************************************
      Function name: checkUsersValidation
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: check Users server side validation
      User instruction: $objUsers->checkUsersValidation($argArrPost)
     * **************************************** */

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

    /*     * ****************************************
      Function name: editUser
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: edit Users
      User instruction: $objUser->editUsers($argArrPost)
     * **************************************** */

    function editUser($argArrPost) {
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
                $arrColumnAdd = array(
                    'UserFirstName' => $argArrPost['frmFirstName'],
                    'UserMiddleName' => $argArrPost['frmMiddleName'],
                    'UserLastName' => $argArrPost['frmLastName'],
                    'UserEmail' => $argArrPost['frmUserEmail'],
                    'UserGender' => $argArrPost['frmGender'],
                    'UserStatus' => $argArrPost['frmUserStatus'],
                    'UserType' => $argArrPost['frmUserType'],
                    'UserBillingAgreements' => $varUserBillingAgreements,
//										'UserDateAdded' => 'now()',
                    'UserDateUpdated' => 'now()'
                );

                $varUsersWhere = ' pkUserID =' . $argArrPost['frmUserID'];

                $this->update(TABLE_USERS, $arrColumnAdd, $varUsersWhere);


                if ($argArrPost['frmUserType'] == 'Member') {
                    $arrColumnUpdate = array(
                        'MemberDetailsAddress1' => $argArrPost['frmMemberAddressLine1'],
                        'MemberDetailsAddress2' => $argArrPost['frmMemberAddressLine2'],
                        'MemberDetailsDateUpdated' => 'now()'
                    );


                    $varUsersWhere = ' fkUserID =' . $argArrPost['frmUserID'];

                    $this->update(TABLE_MEMBER_OTHER_DETAILS, $arrColumnUpdate, $varUsersWhere);
                }


                $objCore->setSuccessMsg(ADMIN_USER_UPDATE_SUCCUSS);
                return true;
            }
        }
    }

    /*     * ****************************************
      Function name: addUser
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: add Users
      User instruction: $objUser->addUsers($argArrPost)
     * **************************************** */

    function addUser($argArrPost) {
        //echo '<pre>';print_r($argArrPost); die;

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

                if ($argArrPost['addedDate'] != '' && $argArrPost['addedDate'] != 'Select Date') {
                    $varToDate = $argArrPost['addedDate'];
                    $varAddedDate = $varToDate;
                } else {
                    $varAddedDate = 'now()';
                }

                $varRandomKey = md5(uniqid(microtime()));
                $arrColumnAdd = array(
                    'UserFirstName' => $argArrPost['frmFirstName'],
                    'UserMiddleName' => $argArrPost['frmMiddleName'],
                    'UserLastName' => $argArrPost['frmLastName'],
                    'UserEmail' => $argArrPost['frmUserEmail'],
                    'UserPassword' => md5(trim($argArrPost['frmPassword'])),
                    'UserGender' => $argArrPost['frmGender'],
                    'UserStatus' => $argArrPost['frmUserStatus'],
                    'UserType' => $argArrPost['frmUserType'],
                    'UserBillingAgreements' => $varUserBillingAgreements,
                    'UserAccountActivationToken' => $varRandomKey,
                    'UserDateAdded' => $varAddedDate,
                    'UserDateUpdated' => $varAddedDate
                );

                $varUserID = $this->insert(TABLE_USERS, $arrColumnAdd);



                //Send Mail To User

                $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo2.png' . '"/>';

                $varToUser = $argArrPost['frmUserEmail'];
                $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
                $varSubject = SITE_NAME . ':Login Details';
                $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/admin_user_registration.html');
                $varUnsubscribeLink = 'Click <a href="' . SITE_ROOT_URL . 'unsubscribe.php?user=' . md5($argArrPost['frmUserEmail']) . '" target="_blank">here</a> to unsubscribe.';

                if ($argArrPost['frmUserType'] == 'Member') {
                    if ($argArrPost['frmUserStatus'] == 'Inactive') {
                        $varActivationLink = 'Click <a href="' . SITE_ROOT_URL . 'login.php?uid=' . $varUserID . '&token=' . base64_encode($varRandomKey) . '">here</a> to activate and login to your account.';
                    } else {
                        $varActivationLink = '';
                    }
                } else {
                    //$varActivationLink = 'Click <a href="'.SITE_ROOT_URL.'registration.php?uid='.$varUserID.'&token='.base64_encode($varRandomKey).'">here</a> to activate and login to your account.';
                    $varActivationLink = '';
                }

                $arrBodyKeywords = array('{USER}', '{USER_NAME}', '{PASSWORD}', '{SITE_NAME}', '{ACTIVATION_LINK}', '{IMAGE_PATH}', '{UNSUBSCRIBE_LINK}');
                $arrBodyKeywordsValues = array($argArrPost['frmFirstName'], $argArrPost['frmUserEmail'], $argArrPost['frmPassword'], SITE_NAME, $varActivationLink, $varPath, $varUnsubscribeLink);
                $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
                //echo $varToUser;echo $varBody;die;
                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);

                $objCore->setSuccessMsg(ADMIN_USER_ADD_SUCCUSS_MSG);
                return true;
            }
        }
    }

    /*     * ****************************************
      Function name: removeUserFavoriteVenue
      Return type : Boolean
      Date created : 10th Oct 2012
      Date last modified : 10th Oct 2012
      Author : Aditya Pratap Singh
      Last modified by : Aditya Pratap Singh
      Comments: Change User Favorite Venues status.
      User instruction: $objUser->removeUserFavoriteVenue($venueID)
     * **************************************** */

    function removeUserFavoriteVenue($venueID, $userid) {
        $objCore = new Core();
        $varMessage = '';
        if ($venueID != '') {
            $varfavVenuesWhereCon = 'fkVenueID = \'' . $venueID . '\' AND fkUserID = \'' . $userid . '\'';
            $arrfavVenuesClms = array('	RequestStatus' => 'Inactive', 'DateUpdated ' => 'now()');
            $varaffectedRecord = $this->update(TABLE_FAVORITE_VENUES, $arrfavVenuesClms, $varfavVenuesWhereCon);
        }
    }

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
        if ($arrUserList[0]['Password'] == md5(trim($argArrPOST['frmPassword']))) {
            $varUsersWhere = ' pkUserID =' . $_SESSION['ASP_UserID'];
            $arrColumnAdd = array(
                'Password' => md5(trim($argArrPOST['frmNewPassword'])),
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

    /*     * ****************************************
      Function name: setUserStatus
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: Change User status.
      User instruction: $objUser->setUserStatus($argArrPOST)
     * **************************************** */

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

    /*     * ****************************************
      Function name : removeUserInformation
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments : Remove Users information.
      User instruction :  $objUser->removeUsersInformation($argArrPOST)
     * **************************************** */

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

    /*     * ****************************************
      Function name: sendUserForgotPassword
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: Change User status.
      User instruction: $objUser->sendUserForgotPassword($argArrPOST)
     * *********************************************** */

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

                $varRandomPassword = $this->generate_random_string(5); //die;


                $varRandomKey = md5(uniqid(microtime()));
                $arrUpdateArray = array('UserAuthorizationToken' => $varRandomKey, 'UserPassword' => md5($varRandomPassword));
                $varaffectedRecord = $this->update(TABLE_USERS, $arrUpdateArray, $varUserWhere);



                $argUserName = $arrUserList[0]['UserEmail'];
                //$argPassword = $arrUserList[0]['UserPassword'];
                $argPassword = $varRandomPassword;
                $argFirstName = $arrUserList[0]['UserFirstName'];

                //Send forget Password To User
                $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo2.png' . '"/>';

                $varToUser = $argArrPOST['frmUserLoginEmail'];
                $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
                $varSubject = 'Venueset:Login Details';
                $varResetPasswordlink = '<a href="' . SITE_ROOT_URL . 'reset_password.php?userId=' . $arrUserList[0]['pkUserID'] . '&authorizationToken=' . base64_encode($varRandomKey) . '">Reset Password</a>';
                $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/user_forget_password.html');
                $varUnsubscribeLink = 'Click <a href="' . SITE_ROOT_URL . 'unsubscribe.php?user=' . md5(trim($argArrPOST['frmUserLoginEmail'])) . '" target="_blank">here</a> to unsubscribe.';

                $arrBodyKeywords = array('{USER_FIRST_NAME}', '{USER_NAME}', '{USER_PASSWORD}', '{IMAGE_PATH}', '{SITE_NAME}', '{RESET_PASSWORD_LINK}', '{UNSUBSCRIBE_LINK}');

                $arrBodyKeywordsValues = array($argFirstName, $argUserName, $argPassword, $varPath, SITE_NAME, $varResetPasswordlink, $varUnsubscribeLink);
                $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
                //echo $varBody;die;
                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);
                $objCore->setSuccessMsg(FRON_END_USER_FORGET_PASSWORD_SEND);
                return true;
            } else {
                $objCore->setErrorMsg(FRON_END_USER_EMAIL_EXIST_ERROR);
                return false;
            }
        }
    }

    /*     * ****************************************
      Function name: get country
      Return type : Associative Array
      Date created : 17 oct 2012
      Date last modified : 17 oct 2012
      Author : Aditya Pratap Singh
      Last modified by : Aditya Pratap Singh
      Comments: Returns all the venues for the given user
      User instruction: $obj->getUserVenues($argVarTable, $argArrClm = array(), $argVarWhere = '')
     * **************************************** */

    function getCountry() {
        $sql = "SELECT country_id,name FROM " . TABLE_COUNTRY . " ORDER BY name ASC";

        $arrList = $this->getArrayResult($sql);
        return $arrList;
    }
    
    function getPortal() {
        $sql = "SELECT pkAdminID,AdminCountry FROM " . TABLE_ADMIN . " WHERE AdminType = 'user-admin' ";

        $arrList = $this->getArrayResult($sql);
        //pre($arrList);
        return $arrList;
    }

    /*     * ****************************************
      Function name: get Region
      Return type : Associative Array
      Date created : 17 oct 2012
      Date last modified : 17 oct 2012
      Author : Aditya Pratap Singh
      Last modified by : Aditya Pratap Singh
      Comments: Returns all the venues for the given user
      User instruction: $obj->getUserVenues($argVarTable, $argArrClm = array(), $argVarWhere = '')
     * **************************************** */

    function getStateByCountry($argWhere) {
        
        $sql = "SELECT pkStateID,StateName FROM " . TABLE_STATE . " where " . $argWhere . " ORDER BY StateName ASC";
        $arrList = $this->getArrayResult($sql);
        return $arrList;
    }

    /*     * ****************************************
      Function name: get Region
      Return type : Associative Array
      Date created : 17 oct 2012
      Date last modified : 17 oct 2012
      Author : Aditya Pratap Singh
      Last modified by : Aditya Pratap Singh
      Comments: Returns all the venues for the given user
      User instruction: $obj->getUserVenues($argVarTable, $argArrClm = array(), $argVarWhere = '')
     * **************************************** */

    function getRegion($argWhere) {
        $sql = "SELECT pkRegionID,RegionName FROM " . TABLE_REGION . " where " . $argWhere . " ORDER BY RegionName ASC";

        $arrList = $this->getArrayResult($sql);
        return $arrList;
    }

    /*     * ****************************************
      Function name: getUserVenues
      Return type : Associative Array
      Date created : 17 oct 2012
      Date last modified : 17 oct 2012
      Author : Aditya Pratap Singh
      Last modified by : Aditya Pratap Singh
      Comments: Returns all the venues for the given user
      User instruction: $obj->getUserVenues($argVarTable, $argArrClm = array(), $argVarWhere = '')
     * **************************************** */

    function getUserfavourite_venues($argVarTable = 'user_favourite_venues', $argArrClm = 'pkFavouriteVenueID', $argVarWhere) {
        $sql = "SELECT " . $argArrClm . " FROM " . $argVarTable;

        if ($argVarWhere != '') {
            $sql .= " WHERE $argVarWhere";
        }

        $arrList = $this->getArrayResult($sql);
        return $arrList;
    }

    /*     * ****************************************
      Function name: getRecord
      Return type : String
      Date created : 17 oct 2012
      Date last modified : 17 oct 2012
      Author : Aditya Pratap Singh
      Last modified by : Aditya Pratap Singh
      Comments: Returns particulare data of given column from the given table
      User instruction: $obj->getAllVenueTypes($argVarTable, $argArrClm = array(), $argVarWhere = '')
     * **************************************** */

    function getRecord($argVarTable, $argArrClm, $argVarWhere = '') {
        $sql = "SELECT " . $argArrClm . " FROM " . $argVarTable . $argVarWhere;
        $res = $this->query($sql);

        if ($res) {
            $row = mysql_fetch_row($res);
            return $row[0];
        }
    }

    /*     * ****************************************
      Function name: generate_random_string
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: Change User status.
      User instruction: $objUser->generate_random_string($argArrPOST)
     * *********************************************** */

    function generate_random_string($name_length = 8) {
        $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return substr(str_shuffle($alpha_numeric), 0, $name_length);
    }

    /*     * ****************************************
      Function name: userLogin
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: Change User status.
      User instruction: $objUser->userLogin($argArrPOST)
     * *********************************************** */

    function userLogin($argArrPost) {
        //echo '<pre>';print_r($argArrPost);exit;

        $objValid = new Validate_fields;
        $objCore = new Core();
        $arrUserFlds = array('pkUserID', 'UserEmail', 'UserPassword', 'UserFirstName', 'UserType', 'UserStatus', 'UserLastName');
        //$varUserWhere = ' 1 AND UserEmail = \''.$argArrPost['frmUserLoginEmail'].'\' AND UserPassword = \''.md5(trim($argArrPost['frmUserLoginPassword'])).'\' AND UserStatus = "Active" AND UserType = "'.$argArrPost['frmHiddenUserType'].'"';
        $varUserWhere = ' 1 AND UserEmail = \'' . $argArrPost['frmUserLoginEmail'] . '\' AND UserPassword = \'' . md5(trim($argArrPost['frmUserLoginPassword'])) . '\'  AND UserType = "' . $argArrPost['frmHiddenUserType'] . '"';
        $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);


        if (count($arrUserList) > 0) {
            if (isset($argArrPost['frmUserActvationID']) && $argArrPost['frmUserActvationID'] <> '') {
                $varwhere = ' 1 AND pkUserID = ' . $arrUserList[0]['pkUserID'] . ' AND UserAccountActivationToken = "' . base64_decode($argArrPost['frmUserActvationToken']) . '"';
                $arrUpdateFlds = array('UserAccountActivationToken' => '', 'UserStatus' => 'Active', 'UserDateUpdated' => 'now()');
                $varaffectedRecord = $this->update(TABLE_USERS, $arrUpdateFlds, $varUserWhere);
            }
            if ($varaffectedRecord || $arrUserList[0]['UserStatus'] == 'Active') {
                $_SESSION['VenusetP_UserEmail'] = $arrUserList[0]['UserEmail'];
                $_SESSION['VenusetP_UserID'] = $arrUserList[0]['pkUserID'];
                $_SESSION['VenusetP_UserName'] = $arrUserList[0]['UserFirstName'];
                $_SESSION['Venuset_UserType'] = $arrUserList[0]['UserType'];
                $_SESSION['Venuset_UserLastName'] = $arrUserList[0]['UserLastName'];

                if (isset($_POST['frmRememberMe'])) {
                    setcookie("cook_VenusetP_UserEmail", $_SESSION['VenusetP_UserEmail'], time() + 60 * 60 * 24 * 30, "/");
                    setcookie("cook_VenusetP_UserID", $_SESSION['VenusetP_UserID'], time() + 60 * 60 * 24 * 30, "/");
                    setcookie("cook_Venueset_UserPassword", $argArrPost['frmUserLoginPassword'], time() + 60 * 60 * 24 * 30, "/");
                    setcookie("cook_Venuset_UserType", $_SESSION['Venuset_UserType'], time() + 60 * 60 * 24 * 30, "/");
                }
                return true;
            } else {
                $objCore->setErrorMsg(FRON_END_USER_ACCOUNT_DEACTIVATE_ERROR);
                return false;
            }
        } else {
            $objCore->setErrorMsg(FRON_END_USER_LOGIN_ERROR);
            return false;
        }
    }

    function checkLogin() {
        /* Check if user has been remembered */
        if (isset($_COOKIE['cook_VenusetP_UserEmail']) && isset($_COOKIE['cook_Venueset_UserPassword'])) {
            $varUserEmail = $_COOKIE['cook_VenusetP_UserEmail'];
            $varUserPassword = $_COOKIE['cook_Venueset_UserPassword'];
            /* Confirm that username and password are valid */
            $arrUserFlds = array('pkUserID', 'UserEmail', 'UserPassword', 'UserFirstName');
            $varUserWhere = ' 1 AND UserEmail = \'' . $varUserEmail . '\' AND UserPassword = \'' . md5(trim($varUserPassword)) . '\'';
            //echo '<pre>';print_r($varUserWhere);exit;
            $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);
            if (count($arrUserList) > 0) {
                /* $_SESSION['VenusetP_UserEmail'] = $arrUserList[0]['UserEmail'];
                  $_SESSION['VenusetP_UserID'] = $arrUserList[0]['pkUserID'];
                  $_SESSION['VenusetP_UserName'] = $arrUserList[0]['UserFirstName']; */
            }
            return true;
        } else {
            return false;
        }
    }

    /*     * ****************************************
      Function name: checkUserAuthorization
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: Change User status.
      User instruction: $objUser->userLogin($argArrPOST)
     * *********************************************** */

    function checkUserAuthorization($argUserID, $argAuthorizationToken) {
        $varUserAuthorizationToken = base64_decode($argAuthorizationToken);

        $objCore = new Core();
        $arrUserFlds = array('pkUserID');
        $varUserWhere = ' 1 AND pkUserID = \'' . $argUserID . '\' AND UserAuthorizationToken = \'' . $varUserAuthorizationToken . '\'';
        $arrUserList = $this->select(TABLE_USERS, $arrUserFlds, $varUserWhere);
        //echo '<pre>';print_r($arrUserList);die;
        if (count($arrUserList) > 0) {
            //blank the authorization token
            $varUsersWhere = ' pkUserID =' . $argUserID;
            $arrColumn = array(
                'UserAuthorizationToken' => ''
            );

            $varUserID = $this->update(TABLE_USERS, $arrColumn, $varUsersWhere);
            //$objCore->setSuccessMsg('Password has been changed successfully.');
            return true;
        } else {
            $objCore->setErrorMsg('You are not the authorized user or your authorization token has been expired.');
            header('location:forgot_password.php');
            exit;
        }
    }

    /*     * ****************************************
      Function name: checkUserAuthorization
      Return type : Boolean
      Date created : 20th April 2011
      Date last modified : 20th April 2011
      Author : Deepesh Pathak
      Last modified by : Deepesh Pathak
      Comments: Change User status.
      User instruction: $objUser->userLogin($argArrPOST)
     * *********************************************** */

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

        if ($arrUserList[0]['UserPassword'] == md5(trim($argArrPOST['frmUserOldPassword']))) {
            $varUsersWhere = ' pkUserID =' . $argArrPOST['frmHiddenUserID'];
            $arrColumnAdd = array(
                'UserPassword' => md5(trim($argArrPOST['frmUserNewPassword'])),
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

    /*     * ****************************************
      Function name: setDefaultAddress
      Return type : Boolean
      Date created : 22 July 2011
      Date last modified : 22 July 2011
      Author : Ghazala Anjum
      Last modified by : Ghazala Anjum
      Comments: Change address status.
      User instruction: $objUser->setDefaultAddress($argArrPOST)
     * **************************************** */

    function setDefaultAddress($argArrPOST) {
        //echo '<pre>';print_r($argArrPOST);die;
        $objCore = new Core();
        $varMessage = '';

        if ($argArrPOST['frmAddressType'] == 'Billing' && $argArrPOST['frmDefaultAddress'] <> '') {
            $varUsersWhereCon = 'pkUserBillingAddressID = \'' . $argArrPOST['frmDefaultAddress'] . '\'';
            $arrUsersClms = array('UserBillingAddressDefault' => 'Yes');
            $varaffectedRecord = $this->update(TABLE_USER_BILLING_ADDRESS, $arrUsersClms, $varUsersWhereCon);

            //set all other as No
            $varWhereClause = 'fkUserID = \'' . $_SESSION['VenusetP_UserID'] . '\' AND pkUserBillingAddressID != ' . $argArrPOST['frmDefaultAddress'];
            $arrUsersClms = array('UserBillingAddressDefault' => 'No');
            $varaffectedRecord = $this->update(TABLE_USER_BILLING_ADDRESS, $arrUsersClms, $varWhereClause);
        }

        if ($argArrPOST['frmAddressType'] == 'Shipping' && $argArrPOST['frmDefaultAddress'] <> '') {
            $varUsersWhereCon = 'pkUserShippingAddressID = \'' . $argArrPOST['frmDefaultAddress'] . '\'';
            $arrUsersClms = array('UserShippingAddressDefault' => 'Yes');
            $varaffectedRecord = $this->update(TABLE_USER_SHIPPING_ADDRESS, $arrUsersClms, $varUsersWhereCon);

            //set all other as No
            $varWhereClause = 'fkUserID = \'' . $_SESSION['VenusetP_UserID'] . '\' AND pkUserShippingAddressID != ' . $argArrPOST['frmDefaultAddress'];
            $arrUsersClms = array('UserShippingAddressDefault' => 'No');
            $varaffectedRecord = $this->update(TABLE_USER_SHIPPING_ADDRESS, $arrUsersClms, $varWhereClause);
        }


        $objCore->setSuccessMsg(SELECTED_ADDRESS_SET_DEFAULT_MSG);
        return true;
    }

}

?>