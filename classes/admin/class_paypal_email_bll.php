<?php

/**
 *
 * Class name : Paypal_email
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The Paypal_email class is used to maintain Paypal_email infomation details for several modules.
 */
class Paypal_email extends Database {

    /**
     * function paypal_email
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function paypal_email() {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function countryList
     *
     * This function is used to display the country List.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objPaypal->countryList()
     */
    function countryList() {
        $arrClms = array(
            'country_id',
            'name',
        );
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms);
        //pre($arrRes) //;
        return $arrRes;
    }

    /**
     * function addEmail
     *
     * This function is used to add email.
     *
     * Database Tables used in this function are : tbl_paypal
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objPaypal->addEmail($arrPost)
     */
    function addEmail($arrPost) {

        $varEmail = $arrPost['frmEmail'];
        $varCountryId = $arrPost['frmCompanyCountry'];
        $varCustomerWhere = "fkCountryID = " . $varCountryId . " ";
        $arrClms = array('pkPaypalID');
        $arrList = $this->select(TABLE_PAYPAL, $arrClms, $varCustomerWhere);
        if (count($arrList) == 0) {
            $arrClms = array(
                'fkCountryID' => $arrPost['frmCompanyCountry'],
                'EmailId' => $arrPost['frmEmail'],
                'EmailDateAdded' => date(DATE_TIME_FORMAT_DB)
            );

            $arrAddID = $this->insert(TABLE_PAYPAL, $arrClms);

            return $arrAddID;
        } else {
            return false;
        }
    }

    /**
     * function EmailList
     *
     * This function is used to display email list.
     *
     * Database Tables used in this function are : tbl_paypal, tbl_country
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objPaypal->EmailList($varWhr, $limit = '')
     */
    function EmailList($varWhr, $limit = '') {
        $this->getSortColumn($_REQUEST);
        if ($varWhr != '') {
            $varWhere = "where " . $varWhr . " ";
        } else {
            $varWhere = "";
        }
        if ($limit != '') {
            $varLimit = "limit " . $limit . " ";
        } else {
            $varLimit = " ";
        }
        $varOrder = " order by " . $this->orderOptions . " ";
        $varSql = "SELECT pkPaypalID,EmailId,EmailDateAdded,name as countryName FROM " . TABLE_PAYPAL . " LEFT JOIN " . TABLE_COUNTRY . " ON fkCountryID = country_id " . $varWhere . " " . $varOrder . " " . $varLimit . " ";
        $arrRes = $this->getArrayResult($varSql);
        return $arrRes;
    }

    /**
     * function removePaypal
     *
     * This function is used to remove paypal accounts.
     *
     * Database Tables used in this function are : tbl_paypal
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objPaypal->removePaypal($argPostIDs)
     */
    function removePaypal($argPostIDs) {

        $varWhere = "pkPaypalID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_PAYPAL, $varWhere);
        return true;
    }

    /**
     * function removeAllPaypal
     *
     * This function is used to remove all paypal accounts.
     *
     * Database Tables used in this function are : tbl_paypal
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objPaypal->removeAllPaypal($argPostIDs)
     */
    function removeAllPaypal($argPostIDs) {
        foreach ($argPostIDs['frmID'] as $valDeltetID) {
            $varWhere = "pkPaypalID = '" . $valDeltetID . "'";
            $this->delete(TABLE_PAYPAL, $varWhere);
        }
        return true;
    }

    /**
     * function editPaypal
     *
     * This function is used to edit paypal accounts.
     *
     * Database Tables used in this function are : tbl_paypal, tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objPaypal->editPaypal($argCmsID)
     */
    function editPaypal($argCmsID) {
        $varWhr = 'pkPaypalID =' . $argCmsID;
        $varSql = "SELECT pkPaypalID,fkCountryID,EmailId,EmailDateAdded,name as countryName FROM " . TABLE_PAYPAL . " LEFT JOIN " . TABLE_COUNTRY . " ON fkCountryID = country_id where " . $varWhr . " ";
        $arrRes = $this->getArrayResult($varSql);
        return $arrRes;
    }

    /**
     * function updatePaypal
     *
     * This function is used to update paypal accounts.
     *
     * Database Tables used in this function are : tbl_paypal
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objPaypal->updatePaypal($arrPost)
     */
    function updatePaypal($arrPost) {

        $varEmail = $arrPost['frmEmail'];
        $varCountryId = $arrPost['frmCompanyCountry'];
        $varCustomerWhere = "fkCountryID = " . $varCountryId . " AND pkPaypalID !='" . $arrPost['paypalId'] . "'";
        $arrClms = array('pkPaypalID');
        $arrList = $this->select(TABLE_PAYPAL, $arrClms, $varCustomerWhere);
        if (count($arrList) == 0) {
            $varWhr = 'pkPaypalID =' . $arrPost['paypalId'];

            $arrClms = array(
                'fkCountryID' => $arrPost['frmCompanyCountry'],
                'EmailId' => $arrPost['frmEmail'],
                'PaypalDateUpdated' => date(DATE_TIME_FORMAT_DB)
            );

            $arrUpdateID = $this->update(TABLE_PAYPAL, $arrClms, $varWhr);

            return $arrUpdateID;
        } else {
            return false;
        }
    }

    /**
     * function getSortColumn
     *
     * This function is used to sort the columns.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objPaypal->getSortColumn($argVarSortOrder)
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
            $varSortBy = 'pkPaypalID';
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
        $objOrder->addColumn('Email Id', 'EmailId', '', 'hidden-350');
        $objOrder->addColumn('Date Added', 'EmailDateAdded', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function getCountryPaypalId
     *
     * This function is used to get the Country Paypal Id.
     *
     * Database Tables used in this function are : tbl_paypal
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrList
     *
     * User instruction: $objPaypal->getCountryPaypalId($varCountryId=0)
     */
    function getCountryPaypalId($varCountryId = 0) {
        $varCustomerWhere = "fkCountryID IN (0," . $varCountryId . ")";
        $arrClms = array('EmailId');
        $varOrderBy = "fkCountryID DESC";
        $arrList = $this->select(TABLE_PAYPAL, $arrClms, $varCustomerWhere, $varOrderBy);
        return $arrList['0']['EmailId'];
    }

}

?>