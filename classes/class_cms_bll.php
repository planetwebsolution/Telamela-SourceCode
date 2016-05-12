<?php

     /**
     * Class name : Club
     *
     * Parent module : None
     *
     * Author : Vivek Avasthi
     *
     * Last modified by : Arvind Yadav
     *
     * Comments : The Cms class is used to maintain Cms infomation details to user for several modules.
     */ 
class Cms extends Database {

    /**
    * function __construct
    *
    * Constructor of the class, will be called in PHP5
    *
    * @access public
    *
    */ 
    function __construct() {
        //$objCore = new Core();
        //default constructor for this class
    }
 
    
  /**
     * function CmsDetails
     *
     * This function is used to update the Cms deatails.
     *
     * Database Tables used in this function are : tbl_cms
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string Array
     *
     * User instruction: $objUsers->CmsDetails($argArrPost)
     */
    
    function CmsDetails($varCmsId) {
        $arrClms = array('pkCmsID', 'PageTitle','PageDisplayTitle','PagePrifix', 'PageContent','PageStatus', 'PageKeywords','PageDescription', 'PageOrdering',);
        $varTable = TABLE_CMS;
        $argWhere= "PagePrifix='".$varCmsId."'";
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        return $arrRes;
    }
    
    /**
     * function getRewardBanner
     *
     * This function is used get special page banner.
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getRewardBanner() {
        global $objCore;
        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
        $varQuery = "SELECT pkBannerID,BannerTitle,BannerImageName FROM " . TABLE_BANNER . " WHERE BannerStatus='1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' AND BannerPage='reward' ORDER BY BannerOrder ASC,pkBannerID desc LIMIT 10";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

}

?>
