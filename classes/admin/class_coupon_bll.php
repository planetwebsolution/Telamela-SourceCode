<?php
 /**
     * 
     * Class name : Coupon
     *
     * Parent module : None
     *
     * Author : Vivek Avasthi
     *
     * Last modified by : Arvind Yadav
     *
     * Comments : The Coupon class is used to maintain Coupon infomation details for several modules.
     */ 

class Coupon extends Database {

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
     * function CategoryFullDropDownList
     *
     * This function is used to display the Category DropDown List deatails.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string $arrRows
     *
     * User instruction: $objCoupon->CategoryFullDropDownList() 
     */
    
    function CategoryFullDropDownList() {
        $arrClms = array('pkCategoryId', 'CategoryName', 'CategoryParentId');
        $varWhr = 'CategoryParentId=0 AND CategoryIsDeleted=0 ';
        $arrRes = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
        $arrRows = array();

        foreach ($arrRes as $v) {
            $arrRows[$v['pkCategoryId']] = $v['CategoryName'];
            $varWhr = 'CategoryParentId = ' . $v['pkCategoryId']." AND CategoryIsDeleted=0" ;

            $arr = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
            foreach ($arr as $sv) {
                $arrRows[$sv['pkCategoryId']] = '&nbsp;&nbsp;&nbsp;' . $sv['CategoryName'];
                $varWhr = 'CategoryParentId = ' . $sv['pkCategoryId'].' AND CategoryIsDeleted=0';
                $arrCatgoryL2 = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
                foreach ($arrCatgoryL2 as $ssv) {
                    $arrRows[$ssv['pkCategoryId']] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $ssv['CategoryName'];
                }
            }
        }
        //pre($arrRows);
        return $arrRows;
    }
   
   /**
     * function CountCouponCode
     *
     * This function is used to display the Count Coupon Code.
     *
     * Database Tables used in this function are : tbl_coupon
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRows
     *
     * User instruction: $objCoupon->CountCouponCode($argWhere = '') 
     */
       
     function CountCouponCode($argWhere = '') { 
        
        $arrNum = $this->getNumRows(TABLE_COUPON, 'CouponCode', $argWhere);
        return $arrNum;
    }
    
    /**
     * function CouponList
     *
     * This function is used to display the Coupon List.
     *
     * Database Tables used in this function are : tbl_coupon, tbl_admin
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     *
     * User instruction: $objCoupon->CouponList($argWhere = '', $argLimit = '')
     */
        
    function CouponList($argWhere = '', $argLimit = '') {
        $arrClms = array('pkCouponID', 'AdminUserName', 'CouponName', 'CouponCode', 'Discount', 'DateStart', 'DateEnd');
        $varOrderBy = 'pkCouponID DESC ';
        $this->getSortColumn($_REQUEST);
        $varTable = TABLE_COUPON . " INNER JOIN " . TABLE_ADMIN . " ON pkAdminId=fkAdminId";
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }
 
    /**
     * function addCoupon
     *
     * This function is used to add the Coupon.
     *
     * Database Tables used in this function are : tbl_coupon, tbl_coupon_to_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     *
     * User instruction: $objCoupon->addCoupon($arrPost)
     */
        
    function addCoupon($arrPost) {
        
        $objCore = new Core();
        $varDateStart = $objCore->defaultDateTime($arrPost['frmDateStart'],DATE_FORMAT_DB);
        $varDateEnd = $objCore->defaultDateTime($arrPost['frmDateEnd'],DATE_FORMAT_DB);
             
        $varNum = $this->CountCouponCode(" AND CouponCode = '".$arrPost['frmCouponCode']."'");
        if($varNum==0){
        $arrClms = array(
            'fkAdminId' => $_SESSION['sessUser'],
            'CouponName' => $arrPost['frmCouponName'],
            'CouponCode' => $arrPost['frmCouponCode'],
            'Discount' => $arrPost['frmDiscount'],
            'DateStart' => $varDateStart,
            'DateEnd' => $varDateEnd,
            'IsApplyAll' => $arrPost['frmApplyOn'],
            'DateAdded' => date(DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_COUPON, $arrClms);

        if ($arrAddID > 0 && $arrPost['frmApplyOn'] == 0) {
            
            foreach ($arrPost['frmProductId'] as $k => $v) {
                $arrPID = explode('vss', $v);
                $varPID = $arrPID[0];
                $arrCls = array(
                    'fkCouponID' => $arrAddID,
                    'fkProductID' => $varPID
                );

                $this->insert(TABLE_COUPON_TO_PRODUCT, $arrCls);
            }
        }
        return $arrAddID;
        }else{
            return 0;
        }
    }

    /**
     * function editCoupon
     *
     * This function is used to edit the Coupon.
     *
     * Database Tables used in this function are : tbl_coupon, tbl_coupon_to_product, tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRow
     *
     * User instruction: $objCoupon->editCoupon($argID)
     */
        
    function editCoupon($argID) {
        $varWhr = 'pkCouponID =' . $argID;
        $arrClms = array('pkCouponID', 'CouponName', 'CouponCode', 'Discount', 'DateStart', 'DateEnd', 'IsApplyAll');

        $varTable = TABLE_COUPON;
        $arrRow = $this->select($varTable, $arrClms, $varWhr);
        $varWhrP = 'fkCouponID =' . $argID;
        $varTableP = TABLE_COUPON_TO_PRODUCT.' LEFT JOIN '.TABLE_PRODUCT.' ON fkProductID=pkProductID';
        $arrRow[0]['CouponToproduct'] = $this->select($varTableP, array('fkCouponID','fkProductID','fkCategoryID'), $varWhrP);
        foreach($arrRow[0]['CouponToproduct'] as $keyP=>$valP){             
            $varWhre = "fkCategoryID='".$valP['fkCategoryID']."'";
            $arrRow[0]['CouponToproduct'][$keyP]['Products'] = $this->select(TABLE_PRODUCT, array('pkProductID','ProductName','FinalPrice'), $varWhre);            
         }
         //echo '<pre>';print_r($arrRow);die;
        return $arrRow;
    }

    
    /**
     * function updateCoupon
     *
     * This function is used to update the Coupon.
     *
     * Database Tables used in this function are : tbl_coupon, tbl_coupon_to_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRow
     *
     * User instruction: $objCoupon->updateCoupon($arrPost) 
     */
        
    
    function updateCoupon($arrPost) {

        $varWhr = 'pkCouponID = ' . $_GET['id'];

        $objCore = new Core();
        $varDateStart = $objCore->defaultDateTime($arrPost['frmDateStart'],DATE_FORMAT_DB);
        $varDateEnd = $objCore->defaultDateTime($arrPost['frmDateEnd'],DATE_FORMAT_DB);
             
        $varNum = $this->CountCouponCode(" AND CouponCode = '".$arrPost['frmCouponCode']."' AND pkCouponID !=".$_GET['id']);
        if($varNum==0){
        $arrClms = array(
            'fkAdminId' => $_SESSION['sessUser'],
            'CouponName' => $arrPost['frmCouponName'],
            'CouponCode' => $arrPost['frmCouponCode'],
            'Discount' => $arrPost['frmDiscount'],
            'DateStart' => $varDateStart,
            'DateEnd' => $varDateEnd,
            'IsApplyAll' => $arrPost['frmApplyOn']
        );

        $arrUpdateID = $this->update(TABLE_COUPON, $arrClms, $varWhr);
        
        $varWhere = "fkCouponID = ".$_GET['id'];
        $this->delete(TABLE_COUPON_TO_PRODUCT, $varWhere);
        
        if ($arrPost['frmApplyOn'] == 0) {            
            foreach ($arrPost['frmProductId'] as $k => $v) {
                $arrPID = explode('vss', $v);
                $varPID = $arrPID[0];
                $arrCls = array(
                    'fkCouponID' => $_GET['id'],
                    'fkProductID' => $varPID
                );

                $this->insert(TABLE_COUPON_TO_PRODUCT, $arrCls);
            }
        }

            return 1;
        }else{
         return 0;   
            
        }
    }

    
    /**
     * function removeCoupon
     *
     * This function is used to remove the Coupon.
     *
     * Database Tables used in this function are : tbl_coupon, tbl_coupon_to_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objCoupon->removeCoupon($argPostIDs)
     */
        
    
    function removeCoupon($argPostIDs) {
        if (isset($argPostIDs['deleteType']) && $argPostIDs['deleteType'] == 'sD') {
            
        $varWhere = "fkCouponID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_COUPON_TO_PRODUCT, $varWhere);
       $varWhere1 = "pkCouponID = '" . $argPostIDs['frmID'] . "'";
       $this->delete(TABLE_COUPON, $varWhere1);
       function myErrorHandler($errno, $errstr, $errfile, $errline)
       {
       	switch ($errno) {
       		case E_USER_ERROR:
       			echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
       			echo "  Fatal error on line $errline in file $errfile";
       			echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
       			echo "avi";die;
       					echo "Aborting...<br />\n";
       							exit(1);
       							break;
       
       							case E_USER_WARNING:
       							echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
       							break;
       
       							case E_USER_NOTICE:
       							echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
       							break;
       
       							default:
       							echo "Unknown error type: [$errno] $errstr<br />\n";
       							break;
       	}
       
       	/* Don't execute PHP internal error handler */
       	return true;
       }
        return true;
        }
        else
        {
           foreach ($argPostIDs['frmID'] as $varDeleteID) {
                    $varWhere = "fkCouponID = " . $varDeleteID . "";
                    $this->delete(TABLE_COUPON_TO_PRODUCT, $varWhere);
                    $varWhere = "pkCouponID = " . $varDeleteID . "";
                    $this->delete(TABLE_COUPON, $varWhere);
                                
                    return true;
        }
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
            $varSortBy = 'pkCouponID';
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
        $objOrder->addColumn('Coupon Name', 'CouponName');
        $objOrder->addColumn('Coupon Code','CouponCode','','hidden-480');
        $objOrder->addColumn('Discount %', 'Discount','','hidden-350');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

}

?>