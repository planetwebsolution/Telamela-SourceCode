<?php
  /**
     * 
     * Class name : cms
     *
     * Parent module : None
     *
     * Author : Vivek Avasthi
     *
     * Last modified by : Arvind Yadav
     *
     * Comments : The cms class is used to maintain cms infomation details.
     */ 

class cms extends Database {

  /**
    * function cms
    *
    * Constructor of the class, will be called in PHP5
    *
    * @access public
    *
    */ 
	
    function cms() {
        //$objCore = new Core();
        //default constructor for this class
    }
    
   /**
     * function ProductList
     *
     * This function is used to display the Product List deatails.
     *
     * Database Tables used in this function are : tbl_cms
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string $arrRes
     *
     * User instruction: $objCms->ProductList($argWhere = '', $argLimit = '')
     */
    
     function ProductList($argWhere = '', $argLimit = '') {
        
         $arrClms = array(
            'pkProductID',
            'ProductName',
            'FinalPrice',
            'fkWholesalerID'
        );
        $varOrderBy = 'ProductName ASC ';
        
        $varWhere = "ProductStatus  = '1' ".$argWhere;

        $varTable = TABLE_PRODUCT;
        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
     //   pre($arrRes);
        
        return $arrRes;
    }
    
   /**
     * function todayOffer
     *
     * This function is used to display the today Offer deatails.
     *
     * Database Tables used in this function are : tbl_product_today_offer, tbl_product, tbl_admin
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string $arrOffer
     *
     * User instruction: $objCms->todayOffer()
     */
      
    function todayOffer() {
        $varWhr = ' 1 ';
        $arrClms = array('fkAdminId','AdminUserName', 'fkProductId','CurrentPrice', 'OfferPrice', 'Description','OfferDateUpdated');

        $varTable = TABLE_PRODUCT_TODAY_OFFER." INNER JOIN ".TABLE_ADMIN." ON pkAdminId=fkAdminId";;
        $arrOffer = $this->select($varTable, $arrClms, $varWhr);
        // echo '<pre>';print_r($arrOffer);die;
        
        $arrOffer[]=$this->getArrayResult("select fkWholesalerID from ".TABLE_PRODUCT." where pkProductID='".$arrOffer[0]['fkProductId']."'");
        
        
        return $arrOffer;
        
        
//        $arrShippingDetails = $this->getArrayResult("SELECT GROUP_CONCAT(fkShippingGatewaysID) as ShippingGateway FROM " . TABLE_WHOLESALER_TO_SHIPPING_GATEWAY . " where fkWholesalerID= '" . $arrRow[0]['pkWholesalerID'] . "' GROUP BY fkWholesalerID");
//        $arrRow[0]['shippingDetails'] = explode(',', $arrShippingDetails[0]['ShippingGateway']);
//        //pre($arrRow);
//        return $arrRow;
    }
      
   /**
     * function updateOffer
     *
     * This function is used to update the today Offer deatails.
     *
     * Database Tables used in this function are : tbl_product_today_offer
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string 1
     *
     * User instruction: $objCms->updateOffer($arrPost) 
     */
     
     function updateOffer($arrPost) {

        $objClassCommon = new ClassCommon();
        $varACPrice = $objClassCommon->getAcCostForTodaysOffer($arrPost['frmOfferPrice']);
         
        $varWhr = 'TodayOfferID = 1 ';        
        $arrP = explode('vss',$arrPost['frmProductId']);        
        $arrClms = array( 
            'fkAdminId' => $_SESSION['sessUser'],
            'fkProductId' => $arrP[0],
            'CurrentPrice' => $arrP[1],
            'OfferACPrice' => $varACPrice,
            'OfferPrice' => $arrPost['frmOfferPrice'],
            'Description' => $arrPost['frmDescription'],
            'OfferDateUpdated' => date(DATE_TIME_FORMAT_DB) 
        );
        
        $this->update(TABLE_PRODUCT_TODAY_OFFER, $arrClms, $varWhr);
        
        return 1;
    }
    
    /**
     * function CmsList
     *
     * This function is used to display Cms List deatails.
     *
     * Database Tables used in this function are : tbl_cms
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     *
     * User instruction: $objCms->CmsList($argWhere = '', $argLimit = '')
     */
      
    function CmsList($argWhere = '', $argLimit = '') {
        $arrClms = array('pkCmsID','AdminUserName','PageTitle','PagePrifix','PageDisplayTitle', 'PageContent', 'PageStatus', 'PageKeywords', 'PageDescription', 'PageOrdering','PageDateUpdated');
        //$varOrderBy = 'PageOrdering ASC ';
        $this->getSortColumn($_REQUEST); 
        $varTable = TABLE_CMS." INNER JOIN ".TABLE_ADMIN." ON pkAdminId=fkAdminId";
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    
    /**
     * function CmsList
     *
     * This function is used to display Cms List deatails.
     *
     * Database Tables used in this function are : tbl_cms
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     *
     * User instruction: $objCms->addCms($arrPost)
     */
       
    function addCms($arrPost) {

        $arrClms = array(
            'fkAdminId' => $_SESSION['sessUser'],
            'PageDisplayTitle' => $arrPost['frmDisplayPageTitle'],
            'PageTitle' => $arrPost['frmPageTitle'],
           'PagePrifix' => str_replace(' ','_',$arrPost['frmPagePrifix']),
            'PageContent' => $arrPost['frmPageContent'],
            'PageKeywords' => $arrPost['frmPageKeywords'],
            'PageDescription' => $arrPost['frmPageDescription'],
            'PageOrdering' => $arrPost['frmPageDisplayOrder'],
            'PageDateAdded' => date(DATE_TIME_FORMAT_DB),
            'PageDateUpdated' => date(DATE_TIME_FORMAT_DB)            
        );

        $arrAddID = $this->insert(TABLE_CMS, $arrClms);

        return $arrAddID;
    }
  
    /**
     * function editCms
     *
     * This function is used to edit Cms .
     *
     * Database Tables used in this function are : tbl_cms
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrCmsData
     *
     * User instruction: $objCms->editCms($argCmsID)
     */
       
    function editCms($argCmsID) {
        $varWhr = 'pkCmsID =' . $argCmsID;
        $arrClms =  array('pkCmsID', 'PageTitle','PagePrifix', 'PageDisplayTitle', 'PageContent', 'PageStatus', 'PageKeywords', 'PageDescription', 'PageOrdering');

        $varTable = TABLE_CMS;
        $arrCmsData = $this->select($varTable, $arrClms, $varWhr);
        // echo '<pre>';print_r($arrCmsData);die;
        return $arrCmsData;
    }

    /**
     * function updateCms
     *
     * This function is used to update Cms .
     *
     * Database Tables used in this function are : tbl_cms
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrUpdateID
     *
     * User instruction: $objCms->updateCms($arrPost) 
     */
       
    function updateCms($arrPost) {

        $varWhr = 'pkCmsID = ' . $_GET['cmsid'];

        $arrClms = array(            
            'PageDisplayTitle' => $arrPost['frmDisplayPageTitle'],
            'PageTitle' => $arrPost['frmPageTitle'],
            'PagePrifix' => str_replace(' ','_',$arrPost['frmPagePrifix']),
            'PageContent' => $arrPost['frmPageContent'],
            'PageKeywords' => $arrPost['frmPageKeywords'],
            'PageDescription' => $arrPost['frmPageDescription'],
            'PageOrdering' => $arrPost['frmPageDisplayOrder'],
            'PageDateUpdated' => date(DATE_TIME_FORMAT_DB)
        );

        $arrUpdateID = $this->update(TABLE_CMS, $arrClms, $varWhr);

        return $arrUpdateID;
    }

    /**
     * function removeCms
     *
     * This function is used to remove Cms .
     *
     * Database Tables used in this function are : tbl_cms
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     *
     * User instruction: $objCms->removeCms($argPostIDs)
     */
       
    function removeCms($argPostIDs) {
        
        $varWhere = "pkCmsID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_CMS, $varWhere);
        return true;
       
    }
       /**
     * function removeAllCms
     *
     * This function is used to remove all Cms .
     *
     * Database Tables used in this function are : tbl_cms
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     *
     * User instruction: $objCms->removeAllCms($argPostIDs)
     */
       
    function removeAllCms($argPostIDs) {
        foreach($argPostIDs['frmID'] as $valDeltetID)
        {
        $varWhere = "pkCmsID = '" . $valDeltetID . "'";
        $this->delete(TABLE_CMS, $varWhere);
        }
        return true;
       
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
            $varSortBy = 'pkCmsID';
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
        $objOrder->addColumn('Page Title','PageTitle');
         $objOrder->addColumn('Display Order','PageOrdering','','hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

}

?>