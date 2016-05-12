<?php

/**
 * 
 * Class name : NewsLetter
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The NewsLetter class is used to maintain NewsLetter infomation details for several modules.
 */
class NewsLetter extends Database {

    /**
     * function newsLetter
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function newsLetter() {
        //$objCore = new Core();
        //default constructor for this class
    }

    //Newsletter

    /**
     * function newsLetterList
     *
     * This function is used to view the Newsletter List.
     *
     * Database Tables used in this function are : tbl_newsletters
     *
     * @access public
     *
     * @parameters 4 string
     *
     * @return $arrRes
     *
     * User instruction: $ObjNewsLetter->newsLetterList($argWhere = '', $varPortalFilter = '', $argAdmin = '', $argLimit = '')
     */
    function newsLetterList($argWhere = '', $varPortalFilter = '', $argAdmin = '', $argLimit = '') {

        $varWhere = " ((CreatedBy = 'Wholesaler' " . $varPortalFilter . ") OR (CreatedBy = 'Admin' " . $argAdmin . ")) " . $argWhere;
		
        $arrClms = array('pkNewsLetterID', 'Title', 'CreatedBy', 'DeliveryDate', 'CreatedID', 'DeliveryStatus', 'DeliveryDate', 'NewsLetterDateAdded','pkWholesalerID','CompanyName');
        $this->getSortColumn($_REQUEST);
        $varTable = TABLE_NEWSLETTER . " LEFT JOIN " . TABLE_WHOLESALER . " ON CreatedID = pkWholesalerID ";
        $arrRes = $this->select($varTable, $arrClms, $varWhere, $this->orderOptions, $argLimit);
       //echo "avi";die;
//        pre($arrRes);
        return $arrRes;
    }

    /**
     * function recipientCustomerList
     *
     * This function is used to view the recipient Customer List.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $ObjNewsLetter->recipientCustomerList()
     */
    function recipientCustomerList() {
        $varOrderBy = $_POST['sort_by'] ? "{$_POST['sort_by']} ASC" : "CustomerFirstName ASC";
        $arrClms = array('pkCustomerID', 'CustomerFirstName', 'CustomerEmail', 'CustomerLastName', 'CustomerDateAdded');
        $varTable = TABLE_CUSTOMER;
        $arrRes = $this->select($varTable, $arrClms, $varID, $varOrderBy);
        return $arrRes;
    }

    /**
     * function recipientWholesalerList
     *
     * This function is used to view the recipient Wholesaler List.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $ObjNewsLetter->recipientWholesalerList($varWhr) 
     */
    function recipientWholesalerList($varWhr) {
        $varOrderBy = $_POST['sort_by'] ? "{$_POST['sort_by']} ASC" : "CompanyName ASC";
        $arrClms = array('pkWholesalerID', 'CompanyName', 'CompanyEmail', 'WholesalerDateAdded');
        $varTable = TABLE_WHOLESALER;

        $varWhr = "1 " . $varWhr;

        $arrRes = $this->select($varTable, $arrClms, $varWhr, $varOrderBy);
        return $arrRes;
    }

    /**
     * function saveNewsLetter
     *
     * This function is used to save NewsLetter.
     *
     * Database Tables used in this function are : tbl_newsletters, tbl_newsletters_recipient
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $ObjNewsLetter->saveNewsLetter($arrData) 
     */
    function saveNewsLetter($arrData) {
    	
    	
    	$objCore = new Core();
        $wid = $_SESSION['sessUserInfo']['id'];
        $date = date('Y-m-d', strtotime($_POST['frmDeliveryDate']));
        $date = $date . " {$arrData['frmHH']}:{$arrData['frmMM']}:{$arrData['frmSS']}";
        $adminId = $this->getAdminDetails();
        if (!empty($arrData['Content']) && !empty($_FILES['template']['name']) ) {
        	$type = 'ContentAndTemplate';
        } else {
        	$type = (empty($_FILES['template']['name'])) ? 'content' : 'template';
        }
        /* echo '<pre>';
        echo $type.'<br/>';
        print_r($arrData);
        echo '</pre>';
        die; */
        /* echo '<pre>';
        print_r($arrData); print_r($_FILES); echo $type; die; */
        
        
        
        if (!empty($_FILES['template']['name'])) {
            $teplate = $this->uploadNewsleterDoc($_FILES);
        } else {
            $teplate = '';
        }
        //pre($teplate);
        $arrClms = array(
            'Title' => $arrData['frmTitle'],
            'NewsLetterType' => $type,
            'Content' => $arrData['Content'],
            'Template' => $teplate,
            'CreatedBy' => 'Admin',
            'CreatedID' => $adminId[0]['pkAdminID'],
            'DeliveryStatus' => 'Pending',
            'DeliveryDate' => $date,
            'ApprovedStatus' => 0,
            'NewsLetterDateAdded' => date(DATE_TIME_FORMAT_DB),
        );
        $arrAddID = $this->insert(TABLE_NEWSLETTER, $arrClms);
            $objCore->setSuccessMsg("Newsletter has been created successfully !");
        foreach ($arrData['recipienCustomerId'] as $val) {
            $arrClms2 = array(
                'fkNewsLetterID' => $arrAddID,
                'SendTo' => 'customer',
                'IsDelivered' => 0,
                'SendToID' => $val
            );
            $arrAddID1 = $this->insert(TABLE_NEWSLETTER_RECEPIENT, $arrClms2);
        }

        foreach ($arrData['recipienWholesalerId'] as $val2) {
            $arrClms3 = array(
                'fkNewsLetterID' => $arrAddID,
                'SendTo' => 'wholesaler',
                'IsDelivered' => 0,
                'SendToID' => $val2
            );
            $arrAddID2 = $this->insert(TABLE_NEWSLETTER_RECEPIENT, $arrClms3);
        }


        return true;
    }

    /**
     * function uploadNewsleterDoc
     *
     * This function is used to update upload Newsleter Doc.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $file_name
     *
     * User instruction: $ObjNewsLetter->uploadNewsleterDoc($FILES)
     */
    function uploadNewsleterDoc($FILES) {
        $objCore = new Core();
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $temp = explode(".", $_FILES["template"]["name"]);
        $extension = end($temp);
        
        
        
        if ($_FILES["template"]["name"]) {
            if (($_FILES["template"]["size"] < 2000000) && in_array($extension, $allowedExts)) {
                if ($_FILES["template"]["error"] > 0) {
                    return $_FILES["template"]["error"];
                } else {
                    $file_name = md5(time()) . '.' . end($temp);
                    //$this->imageUpload($arrFile, $_GET['type'], $id = '', 1);
                    move_uploaded_file($_FILES["template"]["tmp_name"], UPLOADED_FILES_SOURCE_PATH . "images/newsletter/" . $file_name);
                    $objCore->setSuccessMsg("Newsletter has been created successfully !");
                    return $file_name;
                }
            } else {
                $objCore->setErrorMsg("Uploaded Invalid files !");
                header('location:newsletter_add_uil.php');
                die;
            }
        }
    }

    /**
     * function getNewsletterList
     *
     * This function is used to get upload Newsleter List.
     *
     * Database Tables used in this function are : tbl_newsletters, tbl_newsletters_recipient, tbl_customer, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $ObjNewsLetter->getNewsletterList($_argNewsLetterID)
     */
    function getNewsletterList($_argNewsLetterID) {

        $argWhere = "pkNewsLetterID = " . $_argNewsLetterID . " ";
        $varQuery1 = "SELECT pkNewsLetterID,Title,Template, Content,CreatedBy,DeliveryDate,CreatedID,pkWholesalerID,CompanyName FROM " . TABLE_NEWSLETTER . " LEFT JOIN " . TABLE_WHOLESALER . " ON CreatedID = pkWholesalerID " . "  WHERE " . $argWhere . " ";
        $arrRes['newsDetails'] = $this->getArrayResult($varQuery1);
        

        $arrClms2 = array('SendTo', 'CustomerFirstName', 'CustomerEmail', 'CompanyName', 'CompanyEmail');
        $argWhere2 = "fkNewsLetterID = " . $_argNewsLetterID . " ";
        $varOrderBy3 = " pkSendID ";
        $varTable2 = TABLE_NEWSLETTER_RECEPIENT . " LEFT JOIN " . TABLE_CUSTOMER . " ON SendToID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON SendToID = pkWholesalerID " ;
        $arrRes['RecipientDetails'] = $this->select($varTable2, $arrClms2, $argWhere2, $varOrderBy2);
//        pre($arrRes);
        return $arrRes;
    }

    /**
     * function getAdminDetails
     *
     * This function is used to get admin details.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $ObjNewsLetter->getAdminDetails()
     */
    function getAdminDetails() {
        $varID = "AdminEmail = '" . $_SESSION['sessAdminEmail'] . "' ";
        $arrClms = array('pkAdminID', 'AdminUserName');
        $varTable = TABLE_ADMIN;
        $arrRes = $this->select($varTable, $arrClms, $varID, $varOrderBy);
        return $arrRes;
    }

    /**
     * function getSortColumn
     *
     * This function is used to sorting of newsletter list.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $ObjNewsLetter->getSortColumn($argVarSortOrder) 
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
            $varSortBy = 'pkNewsLetterID';
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
        //$objOrder->addColumn('Date', 'DeliveryDate', '', 'hidden-480');
        /* Created date column made up by Krishna Gupta (13-10-15) */
        $objOrder->addColumn('Created Date', 'NewsLetterDateAdded', '', 'hidden-480');
        /* Created date column made up by Krishna Gupta (13-10-15) ends*/
        $objOrder->addColumn('Title', 'Title');
        $objOrder->addColumn('Created By', 'CreatedBy', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function removeNewsLetter
     *
     * This function is used to remove the news letter.
     *
     * Database Tables used in this function are : tbl_newsletters, tbl_newsletters_recipient
     *
     * @access public
     *
     * @parameters 3 string
     *
     * @return $num
     *
     * User instruction: $ObjNewsLetter->removeNewsLetter($argPostIDs, $varPortalFilter, $varAdmin) 
     */
    function removeNewsLetter($argPostIDs, $varPortalFilter, $varAdmin) {
        $varWhere = "pkNewsLetterID = '" . $argPostIDs['frmID'] . "' AND ((CreatedBy = 'Wholesaler' " . $varPortalFilter . ") OR (CreatedBy = 'Admin' " . $varAdmin . "))";

        $num = $this->delete(TABLE_NEWSLETTER, $varWhere);
        if ($num > 0) {
            $varWh = "fkNewsLetterID = '" . $argPostIDs['frmID'] . "'";
            $this->delete(TABLE_NEWSLETTER_RECEPIENT, $varWh);
        }
        return $num;
    }

    /**
     * function removeAllNewsLetter
     *
     * This function is used to remove all newsletter.
     *
     * Database Tables used in this function are : tbl_newsletters, tbl_newsletters_recipient
     *
     * @access public
     *
     * @parameters 3 string
     *
     * @return $ctr
     *
     * User instruction: $ObjNewsLetter->removeAllNewsLetter($argPostIDs, $varPortalFilter, $varAdmin)
     */
    function removeAllNewsLetter($argPostIDs, $varPortalFilter, $varAdmin) {

        $ctr = 0;

        foreach ($argPostIDs['frmID'] as $valDeleteID) {
            $varWhere = "pkNewsLetterID = '" . $valDeleteID . "' AND ((CreatedBy = 'Wholesaler' " . $varPortalFilter . ") OR (CreatedBy = 'Admin' " . $varAdmin . "))";
            $num = $this->delete(TABLE_NEWSLETTER, $varWhere);
            if ($num > 0) {
                $ctr++;
                $varWh = "fkNewsLetterID = '" . $valDeleteID . "'";
                $this->delete(TABLE_NEWSLETTER_RECEPIENT, $varWh);
            }
        }
        return $ctr;
    }

    /**
     * function newsLetterSendList
     *
     * This function is used to view the newsLetter Send List .
     *
     * Database Tables used in this function are : tbl_newsletters
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $ObjNewsLetter->newsLetterSendList($argWhere = '', $argLimit = '')
     */
    function newsLetterSendList($argWhere = '', $argLimit = '') {
        global $objCore;

        $arrClms = array('pkNewsLetterID','Title','NewsLetterType', 'Template', 'Content', 'CreatedBy');
        $varTable = TABLE_NEWSLETTER;
        $orderBy = "DeliveryDate ASC";
        $date1 = str_replace('-', '/', date(DATE_TIME_FORMAT_DB));
        $tomorrow = date('d-m-Y',strtotime($date1. "+1 days"));
       // $argWhere = "DeliveryStatus = 'Active' AND DeliveryDate <= '" . $objCore->serverDateTime($tomorrow, 'Y-m-d 23:59:59') . "' ";
        $argWhere = "DeliveryStatus = 'Active' AND DeliveryDate <= now()- INTERVAL 14 MINUTE";
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $orderBy, $argLimit);
        //echo "avi"; die;
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
       //pre($arrRes);
        return $arrRes;
    }

    /**
     * function updateNewsletterRecipientList
     *
     * This function is used to update the newsLetter Recipient List .
     *
     * Database Tables used in this function are : tbl_newsletters_recipient
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $ObjNewsLetter->updateNewsletterRecipientList($argPostID)
     */
    function updateNewsletterRecipientList($argPostID) {

        $varWhr = "fkNewsLetterID = '" . $argPostID . "' ";

        $arrClmsUpdate = array(
            'IsDelivered' => "1",
        );
        $arrUpdateID = $this->update(TABLE_NEWSLETTER_RECEPIENT, $arrClmsUpdate, $varWhr);
        return true;
    }

    /**
     * function updateLetterSendList
     *
     * This function is used to update the newsLetter Send List .
     *
     * Database Tables used in this function are : tbl_newsletters
     *
     * @access public
     * tbl_newsletters
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $ObjNewsLetter->updateLetterSendList($argPostID)
     */
    function updateLetterSendList($argPostID) {
        $varWhr = "pkNewsLetterID = '" . $argPostID . "' ";

        $arrClmsUpdate = array(
            'DeliveryStatus' => "Delivered",
        );
        $arrUpdateID = $this->update(TABLE_NEWSLETTER, $arrClmsUpdate, $varWhr);
        return true;
    }

    /**
     * function UpdateNewsletterStatus
     *
     * This function is used to update the newsLetter Status .
     *
     * Database Tables used in this function are : tbl_newsletters
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return true
     *
     * User instruction: $ObjNewsLetter->UpdateNewsletterStatus($status, $argPostID)
     */
    function UpdateNewsletterStatus($status, $argPostID) {
        $varWhr = "pkNewsLetterID = '" . $argPostID . "' ";

        $arrClmsUpdate = array(
            'DeliveryStatus' => $status,
        );
        $arrUpdateID = $this->update(TABLE_NEWSLETTER, $arrClmsUpdate, $varWhr);
    }

}

?>