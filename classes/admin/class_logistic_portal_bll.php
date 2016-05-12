<?php

/**
 * 
 * Class name : User
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The User class is used to maintain User infomation details for several modules.
 */
Class logistic extends Database {

    /**
     * function __construct
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function __construct() {
//       pre($_POST);
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function getUserList
     *
     * This function is used to get user list.
     *
     * Database Tables used in this function are : $argVarTable
     *
     * @access public
     *
     * @parameters 5 string, array, string, string, string
     *
     * @return $arrRes
     *
     * User instruction: $objUser->getUserList($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '', $orderby = '') 
     */
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

    /**
     * function getSortColumn
     *
     * This function is used to sort column.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->getSortColumn($argVarSortOrder) 
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
        $objOrder->addColumn('Name', 'UserFirstName');
//			$objOrder->addColumn('User Type', 'UserType');
        $objOrder->addColumn('Email', 'UserEmail');
        $objOrder->addColumn('Role & Permission');
        $objOrder->addColumn('Status', 'AdminUserStatus');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function getUserString
     *
     * This function is used to make valid string.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $varSearchWhere
     *
     * User instruction: $objUser->getUserString($argArrPost)
     */
    function getUserString($argArrPost) {
        //echo '<pre>';print_r($argArrPost); die;
        $varSearchWhere = " AND (AdminType = 'user-moderator' OR AdminType = 'super-admin') ";
        if ($argArrPost['frmSearchUserNameResult'] != '') {
            $varSearchWhere .= ' AND AdminUserName LIKE \'%' . trim(addslashes($argArrPost['frmSearchUserNameResult'])) . '%\'';
        }

        if ($argArrPost['frmSearchUserMailResult'] != '') {
            $varSearchWhere .= ' AND AdminEmail LIKE \'%' . trim(addslashes($argArrPost['frmSearchUserMailResult'])) . '%\'';
        }

        if ($argArrPost['frmRoll'] > 0) {
            $varSearchWhere .= ' AND fkAdminRollId = \'' . $argArrPost['frmRoll'] . '\'';
        }
//      pre($varSearchWhere);
        return $varSearchWhere;
    }

    /**
     * function deleteUser
     *
     * This function is used to delete user records.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->deleteUser($argArrPOST) 
     */
    function deleteUser($argArrPOST) {
        $objCore = new Core();

        $varID = $argArrPOST['frmUserID'];

        $varWhere = "pkAdminID = '" . $varID . "'";

        $this->delete(TABLE_ADMIN, $varWhere);

        $responce = mysql_affected_rows();


        if ($responce) {
            $objCore->setSuccessMsg('User deleted Successfully ');
            return true;
        } else {
            $objCore->setErrorMsg('User not deleted ');
            return true;
        }
    }

    /**
     * function getUserInfo
     *
     * This function is used to get user details.
     *
     * Database Tables used in this function are : $argVarTable
     *
     * @access public
     *
     * @parameters 3 string, array, string
     *
     * @return $arrList
     *
     * User instruction: $objUser->getUserInfo($argVarTable, $argArrClm = array(), $argVarWhere = '') 
     */
    function getUserInfo($argVarTable, $argArrClm = array(), $argVarWhere = '') {
        if (count($argArrClm) > 0) {
            $arrFlds = $argArrClm;
        } else {
            $arrFlds = array();
        }
        $arrList = $this->select($argVarTable, $arrFlds, $argVarWhere);
        return $arrList;
    }

    /**
     * function checkUserValidation
     *
     * This function is used to validate user details.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->checkUserValidation($argArrPost) 
     */
    function checkUserValidation($argArrPost) {


        $objValid = new Validate_fields;
        $objCore = new Core();
        $objValid->check_4html = true;
        $_SESSION['sessArrUsers'] = array();
        $objValid->add_text_field('User Name', strip_tags($argArrPost['frmFirstName']), 'text', 'y', 100);

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
     * function EditModeratorUser
     *
     * This function is used to edit user.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->EditModeratorUser($argArrPost) 
     */
    function EditModeratorUser($argArrPost) {
//        pre($argArrPost);
        //@extract($argArrPost);
        $objCore = new Core;
        $varName = $argArrPost['frmName'];
        $varEmail = $argArrPost['frmUserEmail'];

        $varUserWhere = " pkAdminID != " . $argArrPost['frmUserID'] . " AND ( AdminUserName='" . $argArrPost['frmName'] . "' OR AdminEmail='" . $argArrPost['frmUserEmail'] . "')";
        $arrClms = array('pkAdminID', 'AdminUserName', 'AdminPassword', 'AdminEmail', 'AdminOldPass', 'AdminCountry', 'AdminRegion');
        $arrUserList = $this->select(TABLE_ADMIN, $arrClms, $varUserWhere);
        //echo '<pre>';print_r($arrUserList);die;
        if (isset($arrUserList[0]['pkAdminID']) && $arrUserList[0]['pkAdminID'] <> '') {
            $arrUserName = array();
            $arrUserEmail = array();
            foreach ($arrUserList as $key => $val) {
                if ($val['AdminUserName'] == $varName) {
                    $arrUserName[] = $val['AdminUserName'];
                }
                if ($val['AdminEmail'] == $varEmail) {
                    $arrUserEmail[] = $val['AdminEmail'];
                }
            }
            $varCountName = count($arrUserName);
            $varCountEmail = count($arrUserEmail);
            if ($varCountName > 0) {
                //$_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg(ADMIN_USER_NAME_ALREADY_EXIST);
                return false;
            } else if ($varCountEmail > 0) {
                //$_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg(ADMIN_USE_EMAIL_ALREADY_EXIST);
                return false;
            }
        } else {
            //$varPass = trim($argArrPost['frmPassword']);
            //$varUserPass = $arrUserList[0]['oldPass'];
            if (trim($argArrPost['frmPassword']))
                $varUsersWhere = ' pkAdminID =' . $argArrPost['frmUserID'];
            $arrUser = $this->select(TABLE_ADMIN, array('AdminPassword', 'AdminOldPass'), $varUsersWhere);
            //pre($arrUser);

            if ($arrUser[0]['AdminPassword'] == $argArrPost['frmPassword']) {
                $adminPassword = $arrUser[0]['AdminPassword'];
                $adminOldPass = $arrUser[0]['AdminOldPass'];
                $finalPass = '';
            } else {
                $adminPassword = md5(trim($argArrPost['frmPassword']));
                $adminOldPass = $arrUser[0]['AdminPassword'];
                $finalPass = $argArrPost['frmPassword'];
            }

            $varUserWhere = " pkAdminRoleId='" . $argArrPost['frmAdminRoll'] . "'";
            $arrClms = array('AdminRoleName');
            $arrRoleName = $this->select(TABLE_ADMIN_ROLL, $arrClms, $varUserWhere);
            //pre($arrRoleName[0]['AdminRoleName']);

            $arrColumnAdd = array(
                'AdminTitle' => trim($argArrPost['frmTitle']),
                'AdminUserName' => trim(stripslashes($argArrPost['frmName'])),
                'AdminEmail' => trim(stripslashes($argArrPost['frmUserEmail'])),
                'AdminPassword' => $adminPassword,
                'fkAdminRollId' => $argArrPost['frmAdminRoll'],
                'AdminOldPass' => $adminOldPass,
                'AdminCountry' => trim($argArrPost['frmCountry']),
            );
            //pre($arrColumnAdd);
            $this->update(TABLE_ADMIN, $arrColumnAdd, $varUsersWhere);

            if ($_SERVER[HTTP_HOST] != '192.168.100.97') {
                //Send Mail To User
                $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png' . '"/>';
                $varToUser = $argArrPost['frmUserEmail'];
                $varFromUser = SITE_EMAIL_ADDRESS;
                $varSubject = SITE_NAME . ':Updated Login Details';
                $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/admin_user_edit.html');
                $varUnsubscribeLink = 'Click <a href="' . SITE_ROOT_URL . 'unsubscribe.php?user=' . md5($argArrPost['frmUserEmail']) . '" target="_blank">here</a> to unsubscribe.';
                $arrBodyKeywords = array('{USER}', '{USER_NAME}', '{PASSWORD}', '{EMAIL}', '{ROLE}', '{SITE_NAME}', '{ACTIVATION_LINK}', '{IMAGE_PATH}', '{UNSUBSCRIBE_LINK}');
                $arrBodyKeywordsValues = array(trim(stripslashes($argArrPost['frmName'])), trim(stripslashes($argArrPost['frmName'])), trim($finalPass), trim(stripslashes($argArrPost['frmUserEmail'])), $arrRoleName[0]['AdminRoleName'], SITE_NAME, $varActivationLink, $varPath); //,$varUnsubscribeLink
                $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);
                $_SESSION['sessArrUsers'] = '';
            }
            $objCore->setSuccessMsg(ADMIN_USER_UPDATE_SUCCUSS);
            return true;
        }
    }

    /**
     * function insertArchive
     *
     * This function is used to add user archive details.
     *
     * Database Tables used in this function are : tbl_admin_commission_archive, tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->insertArchive($argArrPost) 
     */
    function insertArchive($argArrPost) {
        $objCore = new Core;
        global $objGeneral;

        $varUserWhere = "StartDate ='" . $argArrPost['frmStartDate'] . "' AND EndDate='" . $argArrPost['frmEndDate'] . "'";
        $arrClms = array('pkArchiveID');
        $arrUserList = $this->select(TABLE_ADMIN_COMMISSION_ARCHIVE, $arrClms, $varUserWhere);

        $varNum = count($arrUserList);

        if ($varNum > 0) {
            $objCore->setErrorMsg(ADMIN_COMMISION_ARCHIVE_ALREADY_EXIST);
            return false;
        } else {

            $arrRes = $this->achivedTarget($argArrPost);
            $AchivedTarget = $arrRes['NoOfSoldItems'];
            $TotalAmount = $arrRes['TotalSoldAmount'];

            $startDate = $objCore->serverDateTime($argArrPost['frmStartDate'], DATE_FORMAT_DB);
            $endDate = $objCore->serverDateTime($argArrPost['frmEndDate'], DATE_FORMAT_DB);

            $arrColumnAdd = array(
                'fkAdminID' => $argArrPost['frmUserID'],
                'StartDate' => $startDate,
                'EndDate' => $endDate,
                'SalesTarget' => $argArrPost['frmSalesTarget'],
                'AchivedTarget' => $AchivedTarget,
                'TotalAmount' => $TotalAmount,
                'Commission' => $argArrPost['frmCommission'],
                'ArchiveDateAdded' => $objCore->serverDateTime(date('Y-m-d H:i:s'), DATE_TIME_FORMAT_DB)
            );

            $this->insert(TABLE_ADMIN_COMMISSION_ARCHIVE, $arrColumnAdd);

            $stdate = strtotime('1 day', strtotime($endDate));
            $SalesTargetStartDate = date('Y-m-j', $stdate);
            $SalesTargetStartDate = $objCore->serverDateTime($SalesTargetStartDate, DATE_FORMAT_DB);

            $arrPer = $objGeneral->getDefaultCommision();

            $eddate = strtotime($arrPer['SalesPeriod'], strtotime($endDate));
            $SalesTargetEndDate = date('Y-m-j', $eddate);
            $SalesTargetEndDate = $objCore->serverDateTime($SalesTargetEndDate, DATE_FORMAT_DB);

            $arrColumnUpdate = array(
                'SalesTargetStartDate' => $SalesTargetStartDate,
                'SalesTargetEndDate' => $SalesTargetEndDate
            );


            $varUsersWhere = " pkAdminID ='" . $argArrPost['frmUserID'] . "'";
            $this->update(TABLE_ADMIN, $arrColumnUpdate, $varUsersWhere);

            $objCore->setSuccessMsg(ADMIN_COMMISION_ARCHIVE_ADD_SUCCESS);
            return true;
        }
    }

    /**
     * function achivedTarget
     *
     * This function is used to get user achived Target.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->achivedTarget($arrDetails) 
     */
    function achivedTarget($arrDetails) {
        $objCountryPortal = new CountryPortal();
        $objCore = new Core;
        $varWhids = $objCountryPortal->getAdminWholesalers($arrDetails['frmUserID']);
        $arrDet = array('whids' => $varWhids, 'salesTarget' => $arrDetails['frmSalesTarget'], 'fromDate' => $objCore->serverDateTime($arrDetails['frmStartDate'], DATE_FORMAT_DB), 'toDate' => $objCore->serverDateTime($arrDetails['frmEndDate'], DATE_FORMAT_DB));

        $arrRes = $objCountryPortal->countryPortalRevenue($arrDet);
        return $arrRes;
    }

    /**
     * function addUser
     *
     * This function is used to add user .
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->addUser($argArrPost) 
     */
    function addUser($argArrPost) {
        //pre($argArrPost);
        //pre("hello");

        $objCore = new Core;
        $varName = addslashes($argArrPost['frmTitle']);
        $logisticUserName = addslashes($argArrPost['frmName']);
        $varEmail = $argArrPost['frmUserEmail'];
        $varpassword = $argArrPost['frmPassword'];



        $varUserWhere = " logisticTitle='" . $varName . "' OR logisticEmail='" . $argArrPost['frmUserEmail'] . "'OR logisticUserName='" . $argArrPost['frmName'] . "'";
        $arrClms = array('logisticportalid', 'logisticTitle', 'logisticEmail', 'logisticUserName');
        $arrUserList = $this->select(TABLE_LOGISTICPORTAL, $arrClms, $varUserWhere);

        if (isset($arrUserList[0]['logisticportalid']) && $arrUserList[0]['logisticportalid'] <> '') {


            $arrUserName = array();
            $arrUserEmail = array();
            $arrUserNames = array();
            foreach ($arrUserList as $key => $val) {
                if ($val['logisticTitle'] == $varName) {
                    $arrUserName[] = $val['logisticTitle'];
                }
                if ($val['logisticEmail'] == $varEmail) {
                    $arrUserEmail[] = $val['logisticEmail'];
                }
                if ($val['logisticUserName'] == $logisticUserName) {
                    $arrUserNames[] = $val['$logisticUserName'];
                }
            }
            $varCountName = count($arrUserName);
            $varCountEmail = count($arrUserEmail);
            $varCountusername = count($arrUserNames);
            if ($varCountName > 0) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg('Logistic Portal Company Name Already Exist ');
                return false;
            } else if ($varCountEmail > 0) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg('Logistic Portal Email Already Exist ');
                return false;
            } else if ($varCountusername > 0) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg('Logistic Portal User Name Already Exist ');
                return false;
            }
        } else {

            // pre($argArrPost);
//            
            //Get Roll ID for DefaultCountryPortal Admin
            require_once CLASSES_ADMIN_PATH . 'class_module_list_bll.php';
            $arrDefaultRollID = moduleList::getRollID();

            $arrColumnAdd = array(
                'logisticTitle' => trim($argArrPost['frmTitle']),
                'logisticUserName' => trim(stripslashes($argArrPost['frmName'])),
                'logisticEmail' => trim(stripslashes($argArrPost['frmUserEmail'])),
                'logisticPassword' => md5(trim($argArrPost['frmPassword'])),
                'logisticportal' => trim($argArrPost['CountryPortalID']),
                'logisticStatus' => trim($argArrPost['frmStatus']),
            );
            //if($argArrPost['frmCountry'] == 0){ $arrColumnAdd['AdminType'] = 'super-admin';}
            // pre($varFromUser);
            $varUserID = $this->insert(TABLE_LOGISTICPORTAL, $arrColumnAdd);
            if ($_SERVER[HTTP_HOST] != '192.168.100.97') {
                //Send Mail To User
                $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png' . '"/>';
                $varToUser = $argArrPost['frmUserEmail'];
                $varFromUser = SITE_EMAIL_ADDRESS;
                $sitelink = SITE_ROOT_URL . 'logistic/';
                $varSubject = SITE_NAME . ':Login Details for Logistic Portal';
                $varBody = '
                		<table width="700" cellspacing="0" cellpadding="5" border="0">
							    <tbody>
							      <tr>
							        
							        <td width="600" style="padding-left:10px;">
							          <p>
							Welcome! <br/><br/>
							<strong>Dear ' . $varName . ',</strong>
							            <br />
							            <br />
							We are pleased to inform that your Logistic Portal account has been successfully created with ' . $sitelink . '. 
							            
							            <br />
							            <br />Here is your access information:
							            <br />Username/Email : ' . $varEmail . '                       
							            <br />Password : ' . $varpassword . '
							            <br /><br />
							If there is anything that we can do to enhance your Tela Mela experience, please feel free to <a href="{CONTACT_US_LINK}">contact us</a>.
							<br/><br/>
							        </p>
							         </td>
							      </tr>
							    </tbody>
							  </table>
                		';
//                 $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/admin_user_registration.html');
//                 $varUnsubscribeLink = 'Click <a href="' . SITE_ROOT_URL . 'unsubscribe.php?user=' . md5($argArrPost['frmUserEmail']) . '" target="_blank">here</a> to unsubscribe.';
//                 $varActivationLink = '';
//                 $arrBodyKeywords = array('{USER}', '{USER_NAME}', '{PASSWORD}', '{EMAIL}', '{ROLE}', '{SITE_NAME}', '{ACTIVATION_LINK}', '{IMAGE_PATH}', '{UNSUBSCRIBE_LINK}');
//                 $arrBodyKeywordsValues = array(trim(stripslashes($argArrPost['frmName'])), trim(stripslashes($argArrPost['frmName'])), trim($argArrPost['frmPassword']), trim(stripslashes($argArrPost['frmUserEmail'])), 'Country Portal', SITE_NAME, $varActivationLink, $varPath); //,$varUnsubscribeLink
//                 $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);
                $_SESSION['sessArrUsers'] = '';
            }

            $objCore->setSuccessMsg("Logistic Portal details have added successfully.");
            return true;
        }
    }

    /**
     * function editUser
     *
     * This function is used to edit user.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->editUser($argArrPost)
     */
    function editUser($argArrPost) {

        //  pre($argArrPost);
        //@extract($argArrPost);
        $objCore = new Core;
        global $objGeneral;
        $varName = $argArrPost['frmName'];
        $varEmail = $argArrPost['frmUserEmail'];
        $logisticUserName = addslashes($argArrPost['frmName']);

        $arrcheckmethod = $objGeneral->checklogisticportalidzoneprice($argArrPost['frmUserID']);
        if ($argArrPost['frmStatus'] == 0) {
          if ($arrcheckmethod[0]['fklogisticidvalue'] > 0) {
            $_SESSION['sessArrUsers'] = $argArrPost;
            $objCore->setErrorMsg('Logistic Portal Name Used,Can"t Deactive. ');
            return false;
        }  
        }
        $varUserWhere = " logisticportalid != " . $argArrPost['frmUserID'] . " AND ( logisticTitle='" . $argArrPost['frmTitle'] . "' OR logisticEmail='" . $argArrPost['frmUserEmail'] . "'OR logisticUserName='" . $argArrPost['frmName'] . "')";
        //$varUserWhere = " logisticTitle='" . $varName . "' OR logisticEmail='" . $argArrPost['frmUserEmail'] . "'OR logisticUserName='" . $argArrPost['frmName'] . "'";
        $arrClms = array('logisticportalid', 'logisticTitle', 'logisticEmail', 'logisticUserName');
        $arrUserList = $this->select(TABLE_LOGISTICPORTAL, $arrClms, $varUserWhere);

        //  pre($arrUserList);
        //echo '<pre>';print_r($arrUserList);die;
        if (isset($arrUserList[0]['logisticportalid']) && $arrUserList[0]['logisticportalid'] <> '') {

            //pre('here');
            $arrUserName = array();
            $arrUserEmail = array();
            $arrUserNames = array();
            foreach ($arrUserList as $key => $val) {
                if ($val['logisticTitle'] == $varName) {
                    $arrUserName[] = $val['logisticTitle'];
                }
                if ($val['logisticEmail'] == $varEmail) {
                    $arrUserEmail[] = $val['logisticEmail'];
                }
                if ($val['logisticUserName'] == $logisticUserName) {
                    $arrUserNames[] = $val['$logisticUserName'];
                }
            }
            $varCountName = count($arrUserName);
            $varCountEmail = count($arrUserEmail);
            $varCountusername = count($arrUserNames);
            if ($varCountName > 0) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg('Logistic Portal Company Name Already Exist ');
                return false;
            } else if ($varCountEmail > 0) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg('Logistic Portal Email Already Exist ');
                return false;
            } else if ($varCountusername > 0) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg('Logistic Portal User Name Already Exist ');
                return false;
            }
        } else {
            //$varPass = trim($argArrPost['frmPassword']);
            //$varUserPass = $arrUserList[0]['oldPass'];
            if (trim($argArrPost['frmPassword']))
                $varUsersWhere = ' logisticportalid =' . $argArrPost['frmUserID'];
            $arrUser = $this->select(TABLE_LOGISTICPORTAL, array('logisticPassword', 'logisticOldPass'), $varUsersWhere);
//            pre($arrUser);

            if ($arrUser[0]['logisticPassword'] == $argArrPost['frmPassword']) {
                $adminPassword = $arrUser[0]['logisticPassword'];
                $adminOldPass = $arrUser[0]['logisticOldPass'];
                $finalPass = '';
            } else {
                $adminPassword = md5(trim($argArrPost['frmPassword']));
                $adminOldPass = $argArrPost['frmPassword'];
                $finalPass = $argArrPost['frmPassword'];
            }



            $arrColumnAdd = array(
                'logisticTitle' => trim($argArrPost['frmTitle']),
                'logisticUserName' => trim(stripslashes($argArrPost['frmName'])),
                'logisticEmail' => trim(stripslashes($argArrPost['frmUserEmail'])),
                'logisticPassword' => $adminPassword,
                'logisticportal' => trim($argArrPost['CountryPortalID']),
                'logisticStatus' => trim($argArrPost['frmStatus']),
                'logisticOldPass' => $adminOldPass,
            );
//            pre($arrColumnAdd);

            $this->update(TABLE_LOGISTICPORTAL, $arrColumnAdd, $varUsersWhere);

            if ($_SERVER[HTTP_HOST] != '192.168.100.97') {
                //Send Mail To User
                $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png' . '"/>';
                $varToUser = $argArrPost['frmUserEmail'];
                $varFromUser = SITE_EMAIL_ADDRESS;
                $sitelink = SITE_ROOT_URL . 'logistic/';
                $varSubject = SITE_NAME . ':Login Details for Logistic Portal';
                $varBody = '
                		<table width="700" cellspacing="0" cellpadding="5" border="0">
							    <tbody>
							      <tr>
							        
							        <td width="600" style="padding-left:10px;">
							          <p>
							Welcome! <br/><br/>
							<strong>Dear ' . $varName . ',</strong>
							            <br />
							            <br />
							Your Logistic Portal account has been successfully updated  with ' . $sitelink . '. 
							            
							            <br />
							            <br />Here is your access information:
							            <br />Username/Email : ' . $varEmail . '  ';
                if (!empty($finalPass)) {
                    $varBody .= '<br />Password : ' . $finalPass;
                }

                $varBody .= '<br /><br />
							If there is anything that we can do to enhance your Tela Mela experience, please feel free to <a href="{CONTACT_US_LINK}">contact us</a>.
							<br/><br/>
							        </p>
							         </td>
							      </tr>
							    </tbody>
							  </table>
                		';
//                 $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/admin_user_registration.html');
//                 $varUnsubscribeLink = 'Click <a href="' . SITE_ROOT_URL . 'unsubscribe.php?user=' . md5($argArrPost['frmUserEmail']) . '" target="_blank">here</a> to unsubscribe.';
//                 $varActivationLink = '';
//                 $arrBodyKeywords = array('{USER}', '{USER_NAME}', '{PASSWORD}', '{EMAIL}', '{ROLE}', '{SITE_NAME}', '{ACTIVATION_LINK}', '{IMAGE_PATH}', '{UNSUBSCRIBE_LINK}');
//                 $arrBodyKeywordsValues = array(trim(stripslashes($argArrPost['frmName'])), trim(stripslashes($argArrPost['frmName'])), trim($argArrPost['frmPassword']), trim(stripslashes($argArrPost['frmUserEmail'])), 'Country Portal', SITE_NAME, $varActivationLink, $varPath); //,$varUnsubscribeLink
//                 $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);
                $_SESSION['sessArrUsers'] = '';
            }

            $objCore->setSuccessMsg("Logistic Portal details have been updated successfully.");
            return true;
        }
    }

    /**
     * function addModeratorUser
     *
     * This function is used to add user Moderator .
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->addUser($argArrPost) 
     */
    function addModeratorUser($argArrPost) {
//        pre($argArrPost);
        $objCore = new Core;
        $varName = addslashes($argArrPost['frmName']);
        $varEmail = $argArrPost['frmUserEmail'];

        $varUserWhere = " AdminUserName='" . $varName . "' OR AdminEmail='" . $argArrPost['frmUserEmail'] . "'";
        $arrClms = array('pkAdminID', 'AdminUserName', 'AdminEmail');
        $arrUserList = $this->select(TABLE_ADMIN, $arrClms, $varUserWhere);


        if (isset($arrUserList[0]['pkAdminID']) && $arrUserList[0]['pkAdminID'] <> '') {


            $arrUserName = array();
            $arrUserEmail = array();
            foreach ($arrUserList as $key => $val) {
                if ($val['AdminUserName'] == $varName) {
                    $arrUserName[] = $val['AdminUserName'];
                }
                if ($val['AdminEmail'] == $varEmail) {
                    $arrUserEmail[] = $val['AdminEmail'];
                }
            }
            $varCountName = count($arrUserName);
            $varCountEmail = count($arrUserEmail);
            if ($varCountName > 0) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg(ADMIN_USER_NAME_ALREADY_EXIST);
                return false;
            } else if ($varCountEmail > 0) {
                $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setErrorMsg(ADMIN_USE_EMAIL_ALREADY_EXIST);
                return false;
            }
        } else {

            $varUserWhere = " pkAdminRoleId='" . $argArrPost['frmAdminRoll'] . "'";
            $arrClms = array('AdminRoleName');
            $arrRoleName = $this->select(TABLE_ADMIN_ROLL, $arrClms, $varUserWhere);
            //pre($arrRoleName[0]['AdminRoleName']);

            $arrColumnAdd = array(
                'AdminTitle' => trim($argArrPost['frmTitle']),
                'AdminUserName' => trim(stripslashes($argArrPost['frmName'])),
                'AdminEmail' => trim(stripslashes($argArrPost['frmUserEmail'])),
                'AdminPassword' => md5(trim($argArrPost['frmPassword'])),
                'fkAdminRollId' => $argArrPost['frmAdminRoll'],
                'AdminOldPass' => trim($argArrPost['frmPassword']),
                'AdminCountry' => trim($argArrPost['frmCountry']),
                'AdminType' => 'user-moderator',
                //'AdminRegion' => trim($argArrPost['frmRegion']),
                'AdminDateAdded' => date(DATE_TIME_FORMAT_DB)
            );
            //pre($arrColumnAdd);
            $varUserID = $this->insert(TABLE_ADMIN, $arrColumnAdd);
            if ($_SERVER[HTTP_HOST] != '192.168.100.97') {

                //Send Mail To User
                $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png' . '"/>';
                $varToUser = $argArrPost['frmUserEmail'];
                $varFromUser = SITE_EMAIL_ADDRESS;
                $varSubject = SITE_NAME . ':Login Details';
                $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/admin_user_registration.html');
                $varUnsubscribeLink = 'Click <a href="' . SITE_ROOT_URL . 'unsubscribe.php?user=' . md5($argArrPost['frmUserEmail']) . '" target="_blank">here</a> to unsubscribe.';
                $varActivationLink = '';
                $arrBodyKeywords = array('{USER}', '{USER_NAME}', '{PASSWORD}', '{EMAIL}', '{ROLE}', '{SITE_NAME}', '{ACTIVATION_LINK}', '{IMAGE_PATH}', '{UNSUBSCRIBE_LINK}');
                $arrBodyKeywordsValues = array(trim(stripslashes($argArrPost['frmName'])), trim(stripslashes($argArrPost['frmName'])), trim($argArrPost['frmPassword']), trim(stripslashes($argArrPost['frmUserEmail'])), $arrRoleName[0]['AdminRoleName'], SITE_NAME, $varActivationLink, $varPath); //,$varUnsubscribeLink
                $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);
                $_SESSION['sessArrUsers'] = '';
            }
            $objCore->setSuccessMsg(ADMIN_USER_ADD_SUCCUSS_MSG);
            return true;
        }
    }

    /**
     * function changeUserPassword
     *
     * This function is used to change user password.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->changeUserPassword($argArrPOST) 
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

    /**
     * function setUserStatus
     *
     * This function is used to change user status.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return boolean
     *
     * User instruction: $objUser->setUserStatus($argArrPOST) 
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
     * function removeUserInformation
     *
     * This function is used to remove user .
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->removeUserInformation($argArrPOST) 
     */
    function removeUserInformation($argArrPOST) {
        $objCore = new Core();
        foreach ($argArrPOST['frmUsersID'] as $varDeleteUsersID) {
            $varWhereCondition = " pkAdminID = '" . $varDeleteUsersID . "'";
            //Listing related child category
            $this->delete(TABLE_ADMIN, $varWhereCondition);
        }

        $objCore->setSuccessMsg(ADMIN_USER_DELETE_MESSAGE);

        return true;
    }

    /**
     * function sendUserForgotPassword
     *
     * This function is used to send User ForgotPassword.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->getUserList($argArrPOST) 
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

    /**
     * function getRecord
     *
     * This function is used to get user list.
     *
     * Database Tables used in this function are : $argVarTable
     *
     * @access public
     *
     * @parameters 5 string, array, string
     *
     * @return $arrRes
     *
     * User instruction: $objUser->getRecord($argVarTable, $argArrClm, $argVarWhere = '') 
     */
    function getRecord($argVarTable, $argArrClm, $argVarWhere = '') {
        $sql = "SELECT " . $argArrClm . " FROM " . $argVarTable . $argVarWhere;
        $res = $this->query($sql);

        if ($res) {
            $row = mysql_fetch_row($res);
            return $row[0];
        }
    }

    /**
     * function generate_random_string
     *
     * This function is used to generate random string.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 5 string, array, string, string, string
     *
     * @return string
     *
     * User instruction: $objUser->generate_random_string($name_length) 
     */
    function generate_random_string($name_length = 8) {
        $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return substr(str_shuffle($alpha_numeric), 0, $name_length);
    }

    /**
     * function userLogin
     *
     * This function is used to user Login.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 5 string, array, string, string, string
     *
     * @return $arrRes
     *
     * User instruction: $objUser->userLogin($argArrPost) 
     */
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

    /**
     * function checkLogin
     *
     * This function is used to check Login.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters none
     *
     * @return $arrRes
     *
     * User instruction: $objUser->checkLogin() 
     */
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

    /**
     * function checkUserAuthorization
     *
     * This function is used to check User Authorization.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return $arrRes
     *
     * User instruction: $objUser->getUserList($argUserID, $argAuthorizationToken)
     */
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

    /**
     * function resetUserPassword
     *
     * This function is used to reset User Password.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrRes
     *
     * User instruction: $objUser->resetUserPassword($argArrPOST) 
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

    /**
     * function logisticPortalCount
     *
     * This function is used to retrive no of records.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 string (optional)
     *
     * @return string $varNum
     */
    function logicalPortalCount($argWhere = '') {

        $arrClms = "logisticportalid";
        $argWhr = ($argWhere <> '') ? " AND " . $argWhere : '';
        $argWhr.='ORDER BY logisticportalid DESC';
        //$argWhr = ($argWhere <> '') ?  $argWhere : '';
        //pre($argWhr);
        $varTable = TABLE_LOGISTICPORTAL;
        $varNum = $this->getNumRows($varTable, $arrClms, $argWhr);
        return $varNum;
    }

    /**
     * function logisticPortalList
     *
     * This function is used to retrive Country Portal List.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 2 string (optional) , string (optional)
     *
     * @return string $varNum
     */
    function logicalPortalList($argWhere = '', $argLimit = '', $varCurrentPeriodFilter = '') {
        global $objGeneral;
        $this->orderOptions = 'logisticportalid DESC';
        $arrClms = array(
            'logisticportalid',
            'logisticUserName',
            'logisticEmail',
            'logisticTitle',
            'logisticStatus',
            'logisticportal',
        );

        //pre($argWhere);
        $varTable = TABLE_LOGISTICPORTAL;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
//     	$arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit,'',true);
//     	pre($arrRes);

        return $arrRes;
    }

    function getlogisticInfo($argWhere) {

        $arrClms = $arrClms = array(
            'logisticportalid',
            'logisticUserName',
            'logisticEmail',
            'logisticTitle',
            'logisticStatus',
            'logisticPassword',
            'logisticportal',
        );
        $varTable = TABLE_LOGISTICPORTAL;
        $varWhere = '1 ' . $argWhere;

        $arrAdminResults = $this->select($varTable, $arrClms, $varWhere);

        return $arrAdminResults;
    }

    /**
     * function updateShippingGatewayStatus
     *
     * This function is used to update the shipping Gateway status.
     *
     * Database Tables used in this function are : TABLE_LOGISTICPORTAL
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objShippingGateway->updatelogicalStatus($arrPost)
     */
    function updatelogicalportalStatus($arrPost) {
           global $objGeneral;
             $objCore = new Core;
        $varWhr = 'logisticportalid = ' . $arrPost['sgid'];
        $arrcheckmethod = $objGeneral->checklogisticportalidzoneprice($arrPost['sgid']);
        
        if ($arrPost['status'] == 0) {
            if ($arrcheckmethod[0]['fklogisticidvalue'] > 0) {
                // pre("here");
                $arrUpdateID = 'exist';
                return $arrUpdateID;
//         $objCore->setErrorMsg(" This Method is used not Deactivated.");
                die();
            }
        }
        
        $arrClms = array('logisticStatus' => $arrPost['status']);
        $arrUpdateID = $this->update(TABLE_LOGISTICPORTAL, $arrClms, $varWhr);
        return $arrUpdateID;
    }

}

?>