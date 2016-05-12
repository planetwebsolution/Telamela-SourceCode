<?php

/**
 * 
 * Class name : Support
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The Support class is used to maintain Support infomation details for several modules.
 */
class Support extends Database {

    /**
     * function __construct
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    public function __construct() {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function invoiceList
     *
     * This function is used to display the invoice List.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objSupport->invoiceList($argWhere = '', $argLimit = '')
     */
    function invoiceList($argWhere = '', $argLimit = '') {

        $varWhere = " WHERE 1 " . $argWhere;

        if ($argLimit) {
            $varLimit = " LIMIT " . $argLimit;
        }

        $varQuery = "SELECT pkInvoiceID,fkOrderID,CustomerName,CustomerEmail,Amount,OrderDateAdded,InvoiceDateAdded  FROM " . TABLE_INVOICE . " " . $varWhere . " ORDER BY InvoiceDateAdded DESC " . $varLimit;
        $arrRes = $this->getArrayResult($varQuery);
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
    function givMessageRead($mgsid) {

        $varID = 'pkSupportID =' . $mgsid;
        $varTable = TABLE_SUPPORT;
        $varArrUpdate = array('IsRead' => '1');

        $VarRst = $this->update($varTable, $varArrUpdate, $varID);

        return $VarRst;
    }

    /**
     * function viewSupport
     *
     * This function is used to display the view Support.
     *
     * Database Tables used in this function are : tbl_support, tbl_customer, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objRegion->viewSupport($argID)
     */
    function viewSupport($argID) {

        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON fkFromUserID = pkWholesalerID";
        $varClms = "pkSupportID,fkParentID,FromUserType,SupportType,Subject,Message,fkFromUserID,SupportType,CONCAT(CustomerFirstName,' ',CustomerLastName) customerName,CustomerEmail as customerEmail,BillingPhone as customerPhone,CompanyName as wholesalerName,CompanyEmail as wholesalerEmail,CompanyPhone as wholesalerPhone,SupportDateAdded";
        $varWhere = " WHERE pkSupportID=" . $argID;
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere;
        $arrRes = $this->getArrayResult($varSql);


        $varWhere = " WHERE FromUserType !='admin' AND (fkParentID = " . $arrRes[0]['fkParentID'] . " ) ";
        $varOrderBy = " Order by SupportDateAdded DESC";
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy;
        $arrRes = $this->getArrayResult($varSql);


        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function viewCustomerOutboxSupport
     *
     * This function is used to display the Customer Outbox Support.
     *
     * Database Tables used in this function are : tbl_support, tbl_customer, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objSupport->viewCustomerOutboxSupport($argID)
     */
    function viewCustomerOutboxSupport($argID) {


        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkToUserID = pkCustomerID ";
        $varClms = "pkSupportID,fkParentID,FromUserType,Subject,Message,fkFromUserID,fkToUserID,CONCAT(CustomerFirstName,' ',CustomerLastName) customerName,CustomerEmail as customerEmail,BillingPhone as customerPhone ,SupportDateAdded";
        $varWhere = " WHERE FromUserType ='admin' AND pkSupportID='" . $argID . "' ";
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere;
        $arrRes = $this->getArrayResult($varSql);
        if ($arrRes[0]['fkParentID'] > 0) {
            $varWhere = " WHERE (fkParentID = " . $arrRes[0]['fkParentID'] . " OR pkSupportID =" . $arrRes[0]['fkParentID'] . ") AND pkSupportID <=" . $argID . " ";
            $varOrderBy = " Order by SupportDateAdded DESC";
            $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy;
            $arrRes = $this->getArrayResult($varSql);
        }
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function viewWholesalerOutboxSupport
     *
     * This function is used to display the Wholesaler Outbox Support.
     *
     * Database Tables used in this function are : tbl_support, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objSupport->viewWholesalerOutboxSupport($argID) 
     */
    function viewWholesalerOutboxSupport($argID) {

        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkToUserID = pkWholesalerID ";
        $varClms = "pkSupportID,fkParentID,FromUserType,Subject,Message,fkFromUserID,fkToUserID,CompanyName as wholesalerName,CompanyEmail as wholesalerEmail,CompanyPhone as wholesalerPhone,SupportDateAdded";
        $varWhere = " WHERE " . $argID;
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere;
        $arrRes = $this->getArrayResult($varSql);
        if ($arrRes[0]['fkParentID'] > 0) {
            $varWhere = " WHERE (fkParentID = " . $arrRes[0]['fkParentID'] . " OR pkSupportID =" . $arrRes[0]['fkParentID'] . ") AND pkSupportID <=" . $argID . " ";
            $varOrderBy = " Order by SupportDateAdded DESC";
            $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy;
            $arrRes = $this->getArrayResult($varSql);
        }
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function viewAllSupport
     *
     * This function is used to display the All Support.
     *
     * Database Tables used in this function are : Ttbl_support, tbl_customer, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objSupport->viewAllSupport($argWhr = '', $argLimit = '')
     */
    function viewAllSupport($argWhr = '', $argLimit = '') {
        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON fkFromUserID = pkWholesalerID";
        $varClms = "pkSupportID,FromUserType,fkFromUserID,CONCAT(CustomerFirstName,' ',CustomerLastName) customerName,CustomerEmail as customerEmail,BillingPhone as customerPhone,CompanyName as wholesalerName,CompanyEmail as wholesalerEmail,CompanyPhone as wholesalerPhone,SupportDateAdded";
        $varWhere = " WHERE FromUserType !='admin' AND ToUserType='admin' AND FromUserType='customer'";
        if ($argWhr != "") {
            $varWhere .= $argWhr;
        }
        $this->getSortColumnCustomerSupport($_REQUEST);
        $varOrderBy = "order by " . $this->orderOptions . " ";
        if ($argLimit <> '') {
            $varLimit = " LIMIT " . $argLimit;
        }
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy . $varLimit;

        $arrRes = $this->getArrayResult($varSql);
        return $arrRes;
    }

    /**
     * function viewAllCustomerSupport
     *
     * This function is used to display the All Customer Support.
     *
     * Database Tables used in this function are : tbl_support, tbl_customer, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objSupport->viewAllCustomerSupport($argWhr = '', $argLimit = '')
     */
    function viewAllCustomerSupport($argWhr = '', $argLimit = '') {
    	//pre($argWhr);
        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON fkFromUserID = pkWholesalerID";
        $varClms = "pkSupportID,fkParentID,FromUserType,fkFromUserID,CONCAT(CustomerFirstName,' ',CustomerLastName) customerName,CustomerEmail as customerEmail,BillingPhone as customerPhone,CompanyName as wholesalerName,CompanyEmail as wholesalerEmail,CompanyPhone as wholesalerPhone,SupportDateAdded,Subject,IsRead";
        $varWhere = " WHERE FromUserType !='admin' AND ToUserType='admin' AND FromUserType='customer' ";
        if ($argWhr != "") {
            $varWhere .= $argWhr;
        }
        $this->getSortColumnCustomerSupport($_REQUEST);
        $varOrderBy = "order by " . $this->orderOptions . " ";
        if ($argLimit <> '') {
            $varLimit = " LIMIT " . $argLimit;
        }
       // pre($varSql);
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy . $varLimit;
        //pre($varSql);
        $arrRes = $this->getArrayResult($varSql);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function viewAllCustomerOutboxSupport
     *
     * This function is used to display the All Customer Outbox Support.
     *
     * Database Tables used in this function are : tbl_support, tbl_customer, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objSupport->viewAllCustomerOutboxSupport($argWhr = '', $argLimit = '') 
     */
    function viewAllCustomerOutboxSupport($argWhr = '', $argLimit = '') {
    	//pre($argWhr);
        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkToUserID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON fkToUserID = pkWholesalerID";
        $varClms = "pkSupportID,fkParentID,FromUserType,fkFromUserID,CONCAT(CustomerFirstName,' ',CustomerLastName) customerName,Subject,CustomerEmail as customerEmail,BillingPhone as customerPhone,CompanyName as wholesalerName,CompanyEmail as wholesalerEmail,CompanyPhone as wholesalerPhone,SupportDateAdded";
        $varWhere = " WHERE FromUserType ='admin'  AND ToUserType='customer'";
        if ($argWhr != "") {
            $varWhere .= $argWhr;
        }
        $this->getSortColumnCustomerSupport($_REQUEST);
        $varOrderBy = "order by " . $this->orderOptions . " ";
        if ($argLimit <> '') {
            $varLimit = " LIMIT " . $argLimit;
        }
       
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy . $varLimit;
       // pre($arrRes);
        $arrRes = $this->getArrayResult($varSql);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function viewAllWholesalerOutboxSupport
     *
     * This function is used to display the All Wholesaler Outbox Support.
     *
     * Database Tables used in this function are : tbl_support, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objSupport->viewAllWholesalerOutboxSupport($argWhr = '', $argLimit = '') 
     */
    function viewAllWholesalerOutboxSupport($argWhr = '', $argLimit = '') {
        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_WHOLESALER . " ON fkToUserID = pkWholesalerID";
        $varClms = "pkSupportID,fkParentID,FromUserType,fkFromUserID,CompanyName as wholesalerName,Subject,CompanyEmail as wholesalerEmail,CompanyPhone as wholesalerPhone,SupportDateAdded";
        $varWhere = " WHERE FromUserType ='admin' AND ToUserType = 'wholesaler' " . $argWhr;

        $this->getSortColumnWholesalerSupport($_REQUEST);

        $varOrderBy = "order by " . $this->orderOptions . " ";
        if ($argLimit <> '') {
            $varLimit = " LIMIT " . $argLimit;
        }

        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy . $varLimit;

        $arrRes = $this->getArrayResult($varSql);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function viewAllWholesalerSupport
     *
     * This function is used to display the All Wholesaler Support.
     *
     * Database Tables used in this function are : tbl_support, tbl_customer, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objSupport->viewAllWholesalerSupport($argWhr = '', $argLimit = '')
     */
    function viewAllWholesalerSupport($argWhr = '', $argLimit = '') {
        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON fkFromUserID = pkWholesalerID";
        $varClms = "pkSupportID,fkParentID,FromUserType,fkFromUserID,CONCAT(CustomerFirstName,' ',CustomerLastName) customerName,CustomerEmail as customerEmail,BillingPhone as customerPhone,CompanyName as wholesalerName,CompanyEmail as wholesalerEmail,CompanyPhone as wholesalerPhone,SupportDateAdded,Subject,IsRead";
        $varWhere = " WHERE ToUserType='admin' AND FromUserType='wholesaler' " . $argWhr;

        $this->getSortColumnWholesalerSupport($_REQUEST);
        $varOrderBy = "order by " . $this->orderOptions . " ";
        if ($argLimit <> '') {
            $varLimit = " LIMIT " . $argLimit;
        }
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy . $varLimit;

        $arrRes = $this->getArrayResult($varSql);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function wholeSalerList
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function wholeSalerList($varPortalFilter) {
        $arrClms = array(
            'pkWholesalerID ',
            'CompanyName',
        );
        $varWhere = "1 " . $varPortalFilter;
        $varOrderBy = 'CompanyName ASC ';
        $arrRes = $this->select(TABLE_WHOLESALER, $arrClms, $varWhere, $varOrderBy);
        return $arrRes;
    }

    /**
     * function removeInvoice
     *
     * This function is used to remove the Invoice.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objSupport->removeInvoice($argPostIDs)
     */
    function removeInvoice($argPostIDs) {
        if (isset($argPostIDs['deleteType']) && $argPostIDs['deleteType'] == 'sD') {

            $varWhereSdelete = " pkInvoiceID = '" . $argPostIDs['frmID'] . "'";
            $this->delete(TABLE_INVOICE, $varWhereSdelete);
            return true;
        }
    }

    /**
     * function removeSupport
     *
     * This function is used to remove the Support.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return true
     *
     * User instruction: $objSupport->removeSupport($argPostIDs, $varPortalFilter)
     */
    function removeSupport($argPostIDs, $varPortalFilter) {
        $core = new Core();
        $msgDelete = $core->messageDeleteRequiredForAdmin($argPostIDs['frmID']);
        if ($msgDelete == false) {
            $varWhereSdelete = " pkSupportID = '" . $argPostIDs['frmID'] . "'" . $varPortalFilter;
            $this->delete(TABLE_SUPPORT, $varWhereSdelete);
            return true;
        } else {
            $arr = array('DeletedBy' => $msgDelete);
            $varWhereSdelete = "pkSupportID = '" . $argPostIDs['frmID'] . "'";
            $varAffected = $this->update(TABLE_SUPPORT, $arr, $varWhereSdelete);
            return $varAffected;
        }
    }

    /**
     * function removeAllSupport
     *
     * This function is used to remove all Support.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return true
     *
     * User instruction: $objSupport->removeAllSupport($argPostIDs, $varPortalFilter) 
     */
    function removeAllSupport($argPostIDs, $varPortalFilter) {
        $core = new Core();

        foreach ($argPostIDs['frmID'] as $valDeleteID) {
            $msgDelete = $core->messageDeleteRequiredForAdmin($valDeleteID);
            if ($msgDelete == false) {
                $varWhereSdelete = " pkSupportID = '" . $valDeleteID . "'" . $varPortalFilter;
                $this->delete(TABLE_SUPPORT, $varWhereSdelete);
            } else {
                $arr = array('DeletedBy' => $msgDelete);
                $varWhereSdelete = "pkSupportID = '" . $valDeleteID . "'";
                $varAffected = $this->update(TABLE_SUPPORT, $arr, $varWhereSdelete);
            }
        }
        return true;
    }

    function getunrecordcustomeremail($getD) {
        $objCore = new Core();
        // $varID = "CustomerEmail LIKE '" . $email . "'"; WHERE CustomerEmail IN ($getD)
        $test = explode(",", $getD);
        // pre($test);
        $varID = "CustomerEmail IN('" . implode("', '", $test) . "')";
        $arrClms = array(
            'CustomerEmail'
        );
        $varTable = TABLE_CUSTOMER;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        // pre($arrRes);
        if (empty($arrRes)) {
            return false;
        } else {
            foreach ($arrRes as $val) {
                $emails[] = $val['CustomerEmail'];
            }

            $maildiff = array_diff($test, $emails);
            if (!empty($maildiff)) {
                // pre("test");

                $errormail = implode(",", $maildiff);
                //  echo $errormail;
                $objCore->setErrorMsg(ADMIN_SUPPORT_CUSTOMER_NOT_EXIST);
            }
            // pre($emails);

            return $emails;
        }
    }

    /**
     * function addCustomerSupport
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 1 string 
     *
     * @return string $arrAddID
     */
    function addSupport($arrPost) {
        // pre($arrPost);
        global $objGeneral;

        $getD = trim($arrPost['frmType']);
        // pre($getD);
        $verifymailid = $this->getunrecordcustomeremail($getD);

        if (empty($verifymailid)) {
            return 'no';
        }
        foreach ($verifymailid as $val) {
            $varGetDb = trim($val);

//        if (count($varD) > 1) {
//            //$varEmailD = str_replace(')', '', $varD[1]);
//            $varGetDb = trim($varEmailD);
//        } else {
//            $varGetDb = trim($varD['0']);
//        }
//pre($varGetDb);

            $objCore = new Core();
            if ($arrPost['userType'] == "customer") {

                $typeUser = $arrPost['userType'];

                $varfkToUserID = $this->getMessageRecipientUser($varGetDb);
                //  pre($varfkToUserID);
                if ($varfkToUserID == 0) {
                    return 'no';
                }
            } else if ($arrPost['frmType'] == "wholesaler") {
                $typeUser = $arrPost['frmType'];
                $varfkToUserID = $arrPost['frmWholesaler'];
            } else {
                $typeUser = 'wholesaler';
                $varfkToUserID = $arrPost['frmWholesaler'];
            }
            //pre($arrRes2);
            $arrClms = array(
                'FromUserType' => "admin",
                'fkFromUserID' => $_SESSION['sessUser'],
                'ToUserType' => $typeUser,
                'fkToUserID' => $varfkToUserID,
                'SupportType' => $arrPost['frmSupportType'],
                'Subject' => $arrPost['frmSubject'],
                'Message' => $arrPost['frmMessage'],
                'SupportDateAdded' => date(DATE_TIME_FORMAT_DB)
            );

            $arrAddID = $this->insert(TABLE_SUPPORT, $arrClms);
            $this->update(TABLE_SUPPORT, array('fkParentID' => $arrAddID), " pkSupportID='" . $arrAddID . "'");
          //  pre("stop");
            $objGeneral->sendSupportEmail($arrAddID);
            $objCore->setSuccessMsg(FRONT_SUPPORT_SUCCUSS_MSG);
        }
        return $arrAddID;
    }

    /**
     * function replyMessage
     *
     * This function is used to send replies.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return boolean
     */
    function addReplyCustomerSupport($arrPost) {
        if ($arrPost['fkParentID'] == 0) {
            $varParent = $arrPost['fkSupportID'];
        } else {
            $varParent = $arrPost['fkParentID'];
        }

        $arrClms = array(
            'fkFromUserID' => $_SESSION['sessUser'],
            'fkParentID' => $varParent,
            'FromUserType' => 'admin',
            'ToUserType' => $arrPost['frmToUserType'],
            'fkToUserID' => $arrPost['fkToUserID'],
            'Subject' => $arrPost['frmSubject'],
            'Message' => $arrPost['frmMessage'],
            'SupportType' => $arrPost['frmMessage'],
            'SupportDateAdded' => date(DATE_TIME_FORMAT_DB)
        );

        $this->update(TABLE_SUPPORT, array('IsRead' => '0'), "pkSupportID ='" . $varParent . "' ");

        $arrAddID = $this->insert(TABLE_SUPPORT, $arrClms);
        return TRUE;
    }

    /**
     * function replyMessage
     *
     * This function is used to send replies.
     *
     * Database Tables used in this function are : tbl_support
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return boolean
     */
    function addReplyWholesalerSupport($arrPost) {
        if ($arrPost['fkParentID'] == 0) {
            $varParent = $arrPost['fkSupportID'];
        } else {
            $varParent = $arrPost['fkParentID'];
        }
        $arrClms = array(
            'fkFromUserID' => $_SESSION['sessUser'],
            'fkParentID' => $varParent,
            'FromUserType' => 'admin',
            'ToUserType' => $arrPost['frmToUserType'],
            'fkToUserID' => $arrPost['fkToUserID'],
            'Subject' => $arrPost['frmSubject'],
            'Message' => $arrPost['frmMessage'],
            'SupportType' => $arrPost['frmMessage'],
            'SupportDateAdded' => date(DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_SUPPORT, $arrClms);
        return TRUE;
    }

    /**
     * function getMessageRecipientUser
     *
     * This function is used to get message for Recipient user.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
    function getMessageRecipientUser($email) {
        $objCore = new Core();
        $varID = "CustomerEmail LIKE '" . $email . "'";
        $arrClms = array(
            'pkCustomerID'
        );
        $varTable = TABLE_CUSTOMER;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        if (empty($arrRes)) {
            return FALSE;
        } else {
            return $arrRes[0]['pkCustomerID'];
        }
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
     * function getSortColumnWholesalerSupport
     *
     * This function is used to sort columns all Wholesaler Support.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objSupport->getSortColumnWholesalerSupport($argVarSortOrder)
     */
    function getSortColumnWholesalerSupport($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'fkParentID DESC,pkSupportID';
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
        $objOrder->addColumn('Ticket ID', 'pkSupportID');
        $objOrder->addColumn('Subject', 'Subject', '', 'hidden-480');
        $objOrder->addColumn('Wholesaler Name', 'wholesalerName');
        $objOrder->addColumn('Email', 'wholesalerEmail', '', 'hidden-1024');
        $objOrder->addColumn('Phone', 'wholesalerPhone', '', 'hidden-1024');
        $objOrder->addColumn('Date', 'SupportDateAdded', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function getSortColumnCustomerSupport
     *
     * This function is used to sort columns all Customer Support.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objSupport->getSortColumnCustomerSupport($argVarSortOrder)
     */
    function getSortColumnCustomerSupport($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'fkParentID DESC, pkSupportID';
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
        $objOrder->addColumn('Ticket ID', 'pkSupportID');
        $objOrder->addColumn('Subject', 'Subject', '', 'hidden-480');
        $objOrder->addColumn('Customer Name', 'customerName');
        $objOrder->addColumn('Email', 'customerEmail', '', 'hidden-1024');
        $objOrder->addColumn('Phone', 'customerPhone', '', 'hidden-1024');
        $objOrder->addColumn('Date', 'SupportDateAdded', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

}

?>
