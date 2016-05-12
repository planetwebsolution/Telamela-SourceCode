<?php
/**
     * 
     * Class name : region
     *
     * Parent module : None
     *
     * Author : Vivek Avasthi
     *
     * Last modified by : Arvind Yadav
     *
     * Comments : The region class is used to maintain region infomation details for several modules.
     */ 

class region extends Database {
	/**
    * function region
    *
    * Constructor of the class, will be called in PHP5
    *
    * @access public
    *
    */ 
	
    function region() {
        //default constructor for this class
    }

    
  /**
     * function RegionList
     *
     * This function is used to display the Region List.
     *
     * Database Tables used in this function are : tbl_region, tbl_country
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objRegion->RegionList($argWhere = '', $argLimit = '') 
     */
    
    
    function RegionList($argWhere = '', $argLimit = '') {
        $arrRes = $this->getArrayResult('SELECT r.pkRegionID,r.fkCountryId,Image,GROUP_CONCAT(r.Cities SEPARATOR " || ") as Cities,GROUP_CONCAT(r.RegionName SEPARATOR " || ") as RegionName,c.name FROM '.TABLE_REGION.' as r LEFT JOIN ' .TABLE_COUNTRY.' as c ON c.country_id=r.fkCountryId GROUP BY r.fkCountryId ORDER BY r.pkRegionID DESC');
        //pre($arrRes);
        return $arrRes;
    }
    
    
  /**
     * function CountryList
     *
     * This function is used to display the Country List.
     *
     * Database Tables used in this function are : tbl_region, tbl_country
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objRegion->CountryList()
     */
    
    
    function CountryList(){
        $arrRes = $this->getArrayResult('SELECT country_id,name FROM '.TABLE_COUNTRY.' WHERE country_id NOT IN(SELECT DISTINCT(fkCountryId) FROM '.TABLE_REGION.')');
        return $arrRes;
    }
   
  /**
     * function addRegion
     *
     * This function is used to add region.
     *
     * Database Tables used in this function are : tbl_region
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objRegion->addRegion($arrPost) 
     */
    
    
    function addRegion($arrPost) {
     
        if ($arrPost['frmCountry']){
            foreach($arrPost['frmRegionName'] as $key=>$val){
                 $arrClms = array(
                    'fkCountryId'=>$arrPost['frmCountry'],
                    'Image'=>$arrPost['varRegionImageName'],
                    'RegionName'=>$val,
                    'Cities'=>$arrPost['frmCities'][$key],
                    'DateAdded'=>date(DATE_TIME_FORMAT_DB)
                 );                
                 $arrAddID = $this->insert(TABLE_REGION, $arrClms);
            }
            return $arrAddID;
        } else {
            return 'exist';
        }
    }

      
  /**
     * function editRegion
     *
     * This function is used to edit region.
     *
     * Database Tables used in this function are : tbl_region, tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objRegion->editRegion($argCountryID) 
     */
    
    function editRegion($argCountryID) {
        $arrRes = $this->getArrayResult('SELECT r.pkRegionID,r.fkCountryId,r.Cities,r.RegionName,c.name,r.image FROM '.TABLE_REGION.' as r LEFT JOIN ' .TABLE_COUNTRY.' as c ON c.country_id=r.fkCountryId WHERE r.fkCountryId='.$argCountryID.' ORDER BY r.fkCountryId ASC');
        //pre($arrRes)
        return $arrRes;
    }
    
        
  /**
     * function updateRegion
     *
     * This function is used to update region.
     *
     * Database Tables used in this function are : tbl_region
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return 1
     *
     * User instruction: $objRegion->updateRegion($arrPost)
     */
   
    
    function updateRegion($arrPost){
        if ($arrPost['countryId']){
            foreach($arrPost['frmRegionName'] as $key=>$val){
                $varPKey = $arrPost['frmRegionId'][$key];
                if($arrPost['delRegionID'][$key]){
                    $varWhere = "pkRegionID = " .$varPKey;
                    $this->delete(TABLE_REGION, $varWhere);
                }else if($arrPost['frmRegionId'][$key]){
                $varWhr = 'pkRegionID = ' . $varPKey;
                 $arrClms = array(
                    'RegionName'=>$val,
                    'Cities'=>$arrPost['frmCities'][$key],
                    'Image'=>$arrPost['varRegionImageName']
                 );
                 $arrUpdateID = $this->update(TABLE_REGION, $arrClms, $varWhr);
              }else{
                 $arrClms = array(
                    'fkCountryId'=>$arrPost['countryId'],
                    'RegionName'=>$val,
                    'Cities'=>$arrPost['frmCities'][$key],
                    'Image'=>$arrPost['varRegionImageName'],
                    'DateAdded'=>date(DATE_TIME_FORMAT_DB)
                 );
                 $arrAddID = $this->insert(TABLE_REGION, $arrClms);
              }
            }
            return 1;
        } else {
            return 'exist';
        }
    }
            
  /**
     * function removeRegion
     *
     * This function is used to remove region.
     *
     * Database Tables used in this function are : tbl_region
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objRegion->removeRegion($argPostIDs)
     */
   
    
    function removeRegion($argPostIDs){
        if(is_array($argPostIDs['frmfkCountryId'])){
          $varWhere = "fkCountryId IN(" . implode($argPostIDs['frmfkCountryId'],',') . ")";
        }else{
          $varWhere = "fkCountryId = '" . $argPostIDs['frmfkCountryId'] . "'";
        }
        $this->delete(TABLE_REGION, $varWhere);
        return true;
    }
               
  /**
     * function IsRegionExist
     *
     * This function is used to region Exist.
     *
     * Database Tables used in this function are : tbl_region
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objRegion->IsRegionExist($argRegionName,$argRegionId)
     */
   
  
    function IsRegionExist($argRegionName,$argRegionId){
        $varWhr =1;
        if($argRegionId){
          $varWhr = " pkRegionID!=".$argRegionId;
        }
        $arrRes = $this->getArrayResult("SELECT count(pkRegionID) as ids FROM ".TABLE_REGION." WHERE ".$varWhr." AND RegionName like '".$argRegionName."'");
        return $arrRes;
    }

}

?>
