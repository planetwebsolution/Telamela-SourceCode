<?php

/**
 * 
 * Class name : Enquiry
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The Enquiry class is used to maintain Enquiry infomation details for several modules.
 */
class Enquiry extends Database {

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
     * function enquiryList
     *
     * This function is used to display the enquiry List.
     *
     * Database Tables used in this function are : tbl_enquiry
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     *
     * User instruction: $objEnquiry->enquiryList($varWhere = '', $varLimit='')
     */
    function enquiryList($varWhere = '', $varLimit = '') {
        $varTable = TABLE_ENQUIRY;
        $arrClms = array('pkEnquiryID', 'fkParentID', 'EnquirySenderName', 'EnquirySenderEmail', 'EnquirySenderMobile', 'EnquirySubject', 'EnquiryComment', 'EnquiryDateAdded');
        $this->getSortColumn($_REQUEST);
        // $varOrderBy = " EnquiryDateAdded DESC ";
        //$varLimit = " 0,10 ";

        $arrRes = $this->select($varTable, $arrClms, $varWhere, $this->orderOptions, $varLimit);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function viewEnquiry
     *
     * This function is used to display enquiry.
     *
     * Database Tables used in this function are : tbl_enquiry
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objEnquiry->viewEnquiry($argID)
     */
    function viewEnquiry($argID) {
        /* $varTable = TABLE_ENQUIRY;
          $arrClms = array('pkEnquiryID','pkEnquiryID','EnquirySenderName','EnquirySenderEmail','EnquirySenderMobile','EnquirySubject', 'EnquiryComment','EnquiryDateAdded');
          $varWhere = "pkEnquiryID='".$argID."'";

          $arrRes = $this->select($varTable, $arrClms, $varWhere);
          // pre($arrRes);
          return $arrRes; */

        $varTable = TABLE_ENQUIRY;
        $varClms = "pkEnquiryID,fkParentID,pkEnquiryID,EnquirySenderName,EnquirySenderEmail,EnquirySenderMobile,EnquirySubject,EnquiryComment,EnquiryDateAdded";
        $varWhere = " WHERE pkEnquiryID='" . $argID . "' ";
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere;
        $arrRes['arrEnquiryDetails'] = $this->getArrayResult($varSql);

        $varWhere2 = " WHERE fkParentID='" . $argID . "' ";
        $varSql2 = "SELECT " . $varClms . " FROM " . $varTable . $varWhere2;
        $arrRes['arrEnquiryReplyDetails'] = $this->getArrayResult($varSql2);
        return $arrRes;
    }

    /**
     * function removeEnquiry
     *
     * This function is used to remove enquiry.
     *
     * Database Tables used in this function are : tbl_enquiry
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objEnquiry->removeEnquiry($argPostIDs)
     */
    function removeEnquiry($argPostIDs) {
        $varWhere = "pkEnquiryID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_ENQUIRY, $varWhere);
        return true;
    }

    /**
     * function removeAllEnquiry
     *
     * This function is used to remove all enquiry.
     *
     * Database Tables used in this function are : tbl_enquiry
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objEnquiry->removeAllEnquiry($argPostIDs) 
     */
    function removeAllEnquiry($argPostIDs) {
        foreach ($argPostIDs['frmID'] as $valDeleteID) {
            $varWhere = "pkEnquiryID = '" . $valDeleteID . "'";
            $this->delete(TABLE_ENQUIRY, $varWhere);
            return true;
        }
    }

    /*     * ****************************************
      Function name:getSortColumn
      Return type: String
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
            $varSortBy = 'pkEnquiryID';
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
        $objOrder->addColumn('Sender Name', 'EnquirySenderName');
        $objOrder->addColumn('Sender Email', 'EnquirySenderEmail', '', 'hidden-480');
        $objOrder->addColumn('Date', 'EnquiryDateAdded', '', 'hidden-480');
        $objOrder->addColumn('Subject', 'EnquirySubject', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function sendReplyEnquiry
     *
     * This function is used to send enquiry.
     *
     * Database Tables used in this function are : tbl_enquiry
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objEnquiry->sendReplyEnquiry($arrPost)
     */
    function sendReplyEnquiry($arrPost) {
        $objComman = new ClassCommon();
        $objTemplate = new EmailTemplate();
        $objCore = new Core();
        $arrSuperAdmin = $objComman->getSuperAdminDetails();
        $varUserName = $arrSuperAdmin[0]['AdminEmail'];
        //$varToUser = "vipin.tomar@mail.vinove.com";
        $varToUser = $arrPost['frmToUserEmail'];
        $varName = $arrPost['frmToUserName'];
        $varSiteName = SITE_NAME;
        $varSubject = "Re: " . $arrPost['frmSubject'];
        $varMessage = $arrPost['frmMessage'];
        $arrClms = array(
            'fkParentID' => $arrPost['frmfkParentID'],
            'EnquirySenderName' => $varName,
            'EnquirySenderEmail' => $varToUser,
            'EnquirySenderMobile' => $arrPost['frmEnquirySenderMobile'],
            'EnquirySubject' => $varSubject,
            'EnquiryComment' => $varMessage,
            'EnquiryDateAdded' => date(DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_ENQUIRY, $arrClms);
        if ($arrAddID > 0) {
            $varWhereTemplate = " EmailTemplateTitle= 'Enquiry Email Reply By Admin' AND EmailTemplateStatus = 'Active' ";

            $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

            $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

            $varPathImage = '';
            $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

            //$varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));
            $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{MESSAGE}', '{NAME}');

            $varKeywordValues = array($varPathImage, SITE_NAME, $varMessage, $varName);
            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
            $objCore->sendMail($varToUser, $varUserName, $varSubject, $varOutPutValues);
        }

        return $arrAddID;
    }

}

?>