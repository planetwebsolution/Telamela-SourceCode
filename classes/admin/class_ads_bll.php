<?php

/**
 * Class name : Ads
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The Ads class is used to maintain Ads infomation details to user for several modules.
 */
class Ads extends Database {

    /**
     * function Ads
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function Ads() {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function adsList
     *
     * This function is used to display the adsList deatails.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     *
     * User instruction: $objAds->adsList()
     */
    function adsList($argWhere = '', $argLimit = '') {
        $arrClms = array('pkAdID', 'AdType', 'Title', 'AdUrl', 'ImageName', 'AdsPage', 'ImageSize', 'HtmlCode', 'AdStatus', 'AdsStartDate', 'AdsEndDate', 'AdDateAdded');
        $this->getSortColumn($_REQUEST);

        $varTable = TABLE_ADVERTISEMENT;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function addAds
     *
     * This function is used to display the addAds deatails.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     *
     * User instruction: $objAds->addAds($arrPost) 
     */
    function addAds($arrPost) {
        $objCore = new Core();

        if (empty($arrPost['frmCategoryId'][0]) || $arrPost['frmAdsPage'] == 'Home Page' || $arrPost['frmAdsPage'] == 'Product Detail Page') {
            $categoryIDs = '';
        } else {
            $categoryIDs = implode(',', $arrPost['frmCategoryId']);
        }

        $varDateStart = $objCore->defaultDateTime($arrPost['frmDateStart'], DATE_FORMAT_DB);
        $varDateEnd = $objCore->defaultDateTime($arrPost['frmDateEnd'], DATE_FORMAT_DB);


        //pre($arrPost);
        if ($arrPost['frmAdType'] == 'html') {

            $arrClms = array(
                'AdType' => $arrPost['frmAdType'],
                'Title' => $arrPost['frmTitle'],
                'HtmlCode' => $arrPost['frmHtmlCode'],
                'AdsPage' => $arrPost['frmAdsPage'],
                'CategoryPages' => $categoryIDs,
                'AdsStartDate' => $varDateStart,
                'AdsEndDate' => $varDateEnd,
                'AdsPrice' => $arrPost['frmAdsPrice'],
                'AdStatus' => $arrPost['frmStaus'],
                'AdDateAdded' => date(DATE_TIME_FORMAT_DB)
            );
        } else {
            $arrClms = array(
                'AdType' => $arrPost['frmAdType'],
                'Title' => $arrPost['frmTitle'],
                'AdUrl' => $arrPost['frmAdUrl'],
                'ImageName' => $arrPost['frmImageName'],
                'ImageSize' => $arrPost['frmImageSize'],
                'AdsPage' => $arrPost['frmAdsPage'],
                'CategoryPages' => $categoryIDs,
                'AdsStartDate' => $varDateStart,
                'AdsEndDate' => $varDateEnd,
                'AdsPrice' => $arrPost['frmAdsPrice'],
                'AdStatus' => $arrPost['frmStaus'],
                'AdDateAdded' => date(DATE_TIME_FORMAT_DB)
            );
        }

        $arrAddID = $this->insert(TABLE_ADVERTISEMENT, $arrClms);

        return $arrAddID;
    }

    /**
     * function editAds
     *
     * This function is used to display the editAds deatails.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objAds->editAds($argID) 
     */
    function editAds($argID) {
        $varWhr = 'pkAdID =' . $argID;
        $arrClms = array('pkAdID', 'AdType', 'Title', 'AdUrl', 'AdsPage', 'CategoryPages', 'ImageName', 'ImageSize', 'HtmlCode', 'AdStatus', 'AdsStartDate', 'AdsEndDate', 'AdsPrice');
        $varTable = TABLE_ADVERTISEMENT;
        $arrRes = $this->select($varTable, $arrClms, $varWhr);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function updateAds
     *
     * This function is used to update the updateAds deatails.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objAds->editAds($argID) 
     */
    function updateAds($arrPost) {
        $objCore = new Core();

        $varWhr = 'pkAdID = ' . $_GET['id'];
        if (empty($arrPost['frmCategoryId'][0]) || $arrPost['frmAdsPage'] == 'Home Page' || $arrPost['frmAdsPage'] == 'Product Detail Page') {
            $categoryIDs = '';
        } else {
            $categoryIDs = implode(',', $arrPost['frmCategoryId']);
        }

        $varDateStart = $objCore->defaultDateTime($arrPost['frmDateStart'], DATE_FORMAT_DB);
        $varDateEnd = $objCore->defaultDateTime($arrPost['frmDateEnd'], DATE_FORMAT_DB);

        if ($arrPost['frmAdType'] == 'html') {

            $arrClms = array(
                'AdType' => $arrPost['frmAdType'],
                'Title' => $arrPost['frmTitle'],
                'AdUrl' => '',
                'ImageName' => '',
                'ImageSize' => '',
                'HtmlCode' => $arrPost['frmHtmlCode'],
                'AdsPage' => $arrPost['frmAdsPage'],
                'CategoryPages' => $categoryIDs,
                'AdsStartDate' => $varDateStart,
                'AdsEndDate' => $varDateEnd,
                'AdsPrice' => $arrPost['frmAdsPrice'],
                'AdStatus' => $arrPost['frmStaus']
            );
        } else {
            $arrClms = array(
                'AdType' => $arrPost['frmAdType'],
                'Title' => $arrPost['frmTitle'],
                'AdUrl' => $arrPost['frmAdUrl'],
                'ImageName' => $arrPost['frmImageName'],
                'ImageSize' => $arrPost['frmImageSize'],
                'HtmlCode' => '',
                'AdsPage' => $arrPost['frmAdsPage'],
                'CategoryPages' => $categoryIDs,
                'AdsStartDate' => $varDateStart,
                'AdsEndDate' => $varDateEnd,
                'AdsPrice' => $arrPost['frmAdsPrice'],
                'AdStatus' => $arrPost['frmStaus']
            );
        }

        $arrUpdateID = $this->update(TABLE_ADVERTISEMENT, $arrClms, $varWhr);

        return $arrUpdateID;
    }

    /**
     * function removeAds
     *
     * This function is used to remove the Ads deatails.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     *
     * User instruction: $objAds->removeAds($argPostIDs) 
     */
    function removeAds($argPostIDs) {

        $varWhere = "pkAdID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_ADVERTISEMENT, $varWhere);
        return true;
    }

    /**
     * function removeAllAds
     *
     * This function is used to remove the Ads deatails.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     *
     * User instruction: $objAds->removeAllAds($argPostIDs) 
     */
    function removeAllAds($argPostIDs) {
        foreach ($argPostIDs['frmID'] as $valDeleteID) {
            $varWhere = "pkAdID = '" . $valDeleteID . "'";
            $this->delete(TABLE_ADVERTISEMENT, $varWhere);
        }
        return true;
    }

    /**
     * function updateAdsStatus
     *
     * This function is used to update ads status.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrUpdateID
     *
     * User instruction: $objAds->updateAdsStatus($argPost)
     */
    function updateAdsStatus($argPost) {

        $varWhr = 'pkAdID = ' . $argPost['bid'];
        $arrClms = array('AdStatus' => $argPost['status']);
        $arrUpdateID = $this->update(TABLE_ADVERTISEMENT, $arrClms, $varWhr);
        return $arrUpdateID;
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
            $varSortBy = 'pkAdID';
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
        $objOrder->addColumn('Type', 'AdType', '', 'hidden-480');
        $objOrder->addColumn('Page', 'AdsPage');
        $objOrder->addColumn('Title', 'Title', '', 'hidden-480');
        $objOrder->addColumn('Start Date', 'AdsStartDate', '', 'hidden-480');
        $objOrder->addColumn('End Date', 'AdsEndDate', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

}

?>
