<?php

/**
 * 
 * Class name : Ship_price
 *
 * Parent module : None
 *
 * Author : Suman
 *
 * Comments : Shipping price for admin and admin portal.
 */
Class Zone extends Database {

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
     * function listOfAllPortal
     *
     * This function is used to retrive company list.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 2 string (optional) , string (optional)
     *
     * @return string $varNum
     */
    function listOfAllPortal() {
        
        
        $varQuery = "SELECT * "
                . " FROM " . TABLE_LOGISTICPORTAL . " "
                . " WHERE logisticStatus = 1 ORDER BY logisticTitle ";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }
    
    
    /**
     * function listOfAllPortal
     *
     * This function is used to retrive company list.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 2 string (optional) , string (optional)
     *
     * @return string $varNum
     */
    function PortalDetailById($cmpId = null) {
        
        if($cmpId){
            $whereCon = " AND logisticportalid = " . $cmpId . " ";
        }else{
            $whereCon = '';
        }

        $varQuery = "SELECT * "
                . " FROM " . TABLE_LOGISTICPORTAL . " "
                . " WHERE logisticStatus = 1 " . $whereCon . " ORDER BY logisticTitle ";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function listOfAllZones
     *
     * This function is used to retrive Zone list for logistic company.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 2 string (optional) , string (optional)
     *
     * @return string $varNum
     */
    function listOfAllZones($request = null) {

        $varQuery = "SELECT * "
                . " FROM " . TABLE_ZONE . ""
//                . " LEFT JOIN " . TABLE_ZONEDETAIL . "  ON zoneid = fkzoneid "
                . " WHERE fklogisticid = " . $request['LogisticId'] . " ORDER BY title ";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function listOfAllZonesDetails
     *
     * This function is used to retrive Zone Detail(From and To Address) list for zone.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 2 string (optional) , string (optional)
     *
     * @return string $varNum
     */
    function listOfAllZonesDetails($request = null) {

        $varQuery = "SELECT * "
                . " FROM " . TABLE_ZONEDETAIL . ""
                . " LEFT JOIN " . TABLE_ZONE . "  ON zoneid = fkzoneid "
                . " WHERE fkzoneid = " . $request['zoneid'] . " ";
        $arrRes = $this->getArrayResult($varQuery);
//        pre($arrRes);
        return $arrRes;
    }

    function checkZoneWithNumber($id) {

        $varQuery = "SELECT * "
                . " FROM " . TABLE_ZONE . " "
                . " WHERE fklogisticid = " . $id . "";
        $arrRes = $this->getArrayResult($varQuery);
        $IdsValue = array();
        foreach ($arrRes as $k => $v) {
            $no = explode('zone', $v['title']);
            $noVal = (int) $no[1];
            array_push($IdsValue, $noVal);
        }
        $idName = max($IdsValue) + 1;
        return $idName;
    }

    /**
     * function addZone
     *
     * This function is used to insert Zone.
     *
     * Database Tables used in this function are : tbl_zone_gateways
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrAddID
     */
    function addZoneAdmin($arrPost) {
//         pre($arrPost);
        if (!empty($arrPost['fcountry'])) {
            //pre($arrPost['title']);

            foreach ($arrPost['title'] as $key => $val) {
                $arrClms = array(
                    'title' => $val,
                    'fklogisticid' => $arrPost['LogisticId'],
                );

                // pre($arrClms);
                $zone_id = $this->insert('tbl_zone', $arrClms);

                foreach ($arrPost['fcountry'][$key] as $i => $val2) {


                    //  echo 'hi<br>';
                    $arrclms1 = array(
                        'fkzoneid' => $zone_id,
                        'fromcountry' => $val2,
                        'fromstate' => $arrPost['fstate'][$key][$i],
                        'fromcity' => $arrPost['fcity'][$key][$i],
                        'fromdistance' => $arrPost['frmdistance'][$key][$i],
                        'tocountry' => $arrPost['tcountry'][$key][$i],
                        'tostate' => $arrPost['tstate'][$key][$i],
                        'tocity' => $arrPost['tcity'][$key][$i],
                        'todistance' => $arrPost['todistance'][$key][$i],
                    );

                    $zonedetais_id = $this->insert('tbl_zonedetail', $arrclms1);
                }
            }
            return $zonedetais_id;
            //die();
        } else {
            return 'exist';
        }
        // pre($val2);   
    }

    /**
     * function addZone
     *
     * This function is used to insert Zone.
     *
     * Database Tables used in this function are : tbl_zone_gateways
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrAddID
     */
    function editZoneDetailAdmin($arrPost) {
//        pre($arrPost);
        if (!empty($arrPost['fcountry'])) {
            //pre($arrPost['title']);

            foreach ($arrPost['fcountry'][0] as $i => $val2) {

                $arrclms1 = array(
                    //'fkzoneid' => $zone_id,
                    'fromcountry' => $val2,
                    'fromstate' => $arrPost['fstate'][0][$i],
                    'fromcity' => $arrPost['fcity'][0][$i],
                    'fromdistance' => $arrPost['frmdistance'][0][$i],
                    'tocountry' => $arrPost['tcountry'][0][$i],
                    'tostate' => $arrPost['tstate'][0][$i],
                    'tocity' => $arrPost['tcity'][0][$i],
                    'todistance' => $arrPost['todistance'][0][$i],
                );

                if (!empty($arrPost['detailzoneid'][0][$i])) {
                    $varUsersWhere = " id ='" . $arrPost['detailzoneid'][0][$i] . "'";
                    $this->update(TABLE_ZONEDETAIL, $arrclms1, $varUsersWhere);
                }else{
                    $arrclms1['fkzoneid'] = $arrPost['zoneid'];
                    $this->insert('tbl_zonedetail', $arrclms1);
                }
                
            }

            return true;
            //die();
        } else {
            return 'invalid';
        }
        // pre($val2);   
    }

    /* Old Function's From Below Here (Need to remove)
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     * *
     */

    /**
     * function ship_price_count
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
    function ship_price_count($argWhere = '') {

        $arrClms = "pkpriceid";
        $argWhr = ($argWhere <> '') ? " AND " . $argWhere : '';
        $argWhr.='ORDER BY pkpriceid DESC';
        //$argWhr = ($argWhere <> '') ?  $argWhere : '';
        //pre($argWhr);
        $varTable = TABLE_ZONEPRICE;
        $varNum = $this->getNumRows($varTable, $arrClms, $argWhr);
        return $varNum;
    }

    /**
     * function logisticPortalList
     *
     * This function is used to retrive Price list.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 2 string (optional) , string (optional)
     *
     * @return string $varNum
     */
    function shipPriceList($argWhere = '', $argLimit = '') {
        global $objGeneral;
        $this->orderOptions = 'pkpriceid DESC';

        $varQuery = "SELECT pkpriceid,zonetitleid,shippingmethod,maxlength,maxwidth,maxheight,minkg,maxkg,costperkg,"
                . " handlingcost,fragilecost,deliveryday,cubicweight,title,MethodName,created,modified,pricestatus,logisticTitle,"
                . " logisticportal "
                . " FROM " . TABLE_ZONEPRICE . " "
                . " LEFT JOIN " . TABLE_ZONE . " ON zoneid = zonetitleid "
                . " LEFT JOIN " . TABLE_LOGISTICPORTAL . " ON fklogisticidvalue = logisticportalid "
                . " LEFT JOIN " . TABLE_SHIPPING_METHOD . " ON pkShippingMethod = shippingmethod "
                . " WHERE " . $argWhere . " ORDER BY pkpriceid DESC LIMIT " . $argLimit . "";
        //pre($varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //$varTable = TABLE_ZONEPRICE;
        //$arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        return $arrRes;
    }

    /**
     * function shipPriceDetailById
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
    function shipPriceDetailById($id) {

        $varQuery = "SELECT *,c1.name as frmCountryName,c2.name as toCountryName,s1.name as fromstateName,s2.name as tostateName,"
                . "city1.name as fromcityName, city2.name as tocityName"
                . " FROM " . TABLE_ZONEPRICE . " "
                . " LEFT JOIN " . TABLE_ZONE . " ON zoneid = zonetitleid"
                . " LEFT JOIN" . TABLE_SHIPPING_METHOD . " ON pkShippingMethod = shippingmethod "
                . " LEFT JOIN " . TABLE_ZONEDETAIL . " ON zonetitleid = fkzoneid "
                . " LEFT JOIN " . TABLE_COUNTRY . " as c1 ON fromcountry = c1.country_id "
                . " LEFT JOIN " . TABLE_COUNTRY . " as c2 ON tocountry = c2.country_id "
                . " LEFT JOIN " . TABLE_STATE . " as s1 ON fromstate = s1.id "
                . " LEFT JOIN " . TABLE_STATE . " as s2 ON tostate = s2.id "
                . " LEFT JOIN " . TABLE_CITY . " as city1 ON fromcity = city1.id "
                . " LEFT JOIN " . TABLE_CITY . " as city2 ON tocity = city2.id "
                . " WHERE  pkpriceid = " . $id . "";
        $arrRes = $this->getArrayResult($varQuery);

        //return all record
        return $arrRes;
    }

    /**
     * function shipPriceAccepted
     *
     * This function is used to accept ship price.
     *
     * Database Tables used in this function are : $argVarTable
     *
     * @access public
     *
     * @parameters id
     *
     * @return $arrRes
     *
     * User instruction: $objUser->getUserList($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '', $orderby = '') 
     */
    function shipPriceAccepted($id) {

        $arrColumnUpdate = array('pricestatus' => 1);
        $varUsersWhere = " pkpriceid ='" . $id . "'";
        $this->update(TABLE_ZONEPRICE, $arrColumnUpdate, $varUsersWhere);

        //return all record
        return 1;
    }

    /**
     * function shipPriceRejected
     *
     * This function is used to reject ship price.
     *
     * Database Tables used in this function are : $argVarTable
     *
     * @access public
     *
     * @parameters id
     *
     * @return $arrRes
     *
     * User instruction: $objUser->getUserList($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '', $orderby = '') 
     */
    function shipPriceRejected($id) {

        $arrColumnUpdate = array('pricestatus' => 2);
        $varUsersWhere = " pkpriceid ='" . $id . "'";
        $this->update(TABLE_ZONEPRICE, $arrColumnUpdate, $varUsersWhere);

        //return all record
        return 1;
    }

}

?>