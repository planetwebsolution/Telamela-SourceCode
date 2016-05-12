<?php

/**
 *
 * Class name : ZoneGatewayNew
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The ZoneGateway class is used to maintain ZoneGateway infomation details for several modules.
 */
class ZoneGatewayNew extends Database {

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
     * function zoneGatewayList
     *
     * This function is used to display the zone Gateway List.
     *
     * Database Tables used in this function are : tbl_zone_gateways
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objZoneGateway->zoneGatewayList($argWhere = '', $argLimit = '')
     */
    function zoneGatewayList($argWhere = '', $argLimit = '') {
        $arrClms = array(
            'pkZoneGatewaysID',
            'ZoneType',
            'ZoneTitle',
            'ZoneStatus'
        );
        $varOrderBy = 'ZoneType ASC,ZoneTitle ASC ';
        $arrRes = $this->select(tbl_ship_gateways, $arrClms, $argWhere, $varOrderBy, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function zoneGatewayPriceList
     *
     * This function is used to display the zone Gateway Price List.
     *
     * Database Tables used in this function are : tbl_zone_gateways_pricelist, tbl_zone_gateways, tbl_zone_method
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objZoneGateway->zoneGatewayPriceList($argWhere = '', $argLimit = '')
     */
    function zoneGatewayPriceList($argWhere = '', $argLimit = '') {
        $varClms = "admin.pkAdminID,price.pkZonePriceID,
            gatway.ZoneType,gatway.ZoneTitle,gatway.ZoneStatus,
            price.minWeight,price.maxWeight,price.zonePrice,price.fkZoneGatewaysID,
            admin.AdminUserName,admin.AdminEmail,
            countryship.fkZoneGatewaysID as a,countryship.fkAdminID as b,
            mulcountry.fkshipcountryid as c,
            GROUP_CONCAT(DISTINCT country.name) as countryName, GROUP_CONCAT(DISTINCT country.country_id) as countryID
            ";
//        $varClms = "*";
        $startDate = time();
        $date = date('Y-m-d');
        $varTable = TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . " AS price LEFT JOIN " . TABLE_SHIP_GATEWAYS .
                " AS gatway ON price.fkZoneGatewaysID = gatway.pkZoneGatewaysID LEFT JOIN " . TABLE_ADMIN .
                " AS admin ON price.fkZonePortalID = admin.pkAdminID LEFT JOIN " . TABLE_SHIP_COUNTRY .
                " AS countryship ON price.fkZoneGatewaysID = countryship.fkZoneGatewaysID AND price.fkZonePortalID = countryship.fkAdminID LEFT JOIN " . TABLE_SHIP_MULTIPLECOUNTRY .
                " AS mulcountry ON mulcountry.fkshipcountryid = countryship.pkshipcountryid LEFT JOIN " . TABLE_COUNTRY .
                " AS country ON country.country_id =  mulcountry.fkcountry_id"
                . " WHERE countryship.pkshipcountryid = mulcountry.fkshipcountryid "
        ;
        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";
        //$varOrderBy = "GROUP BY fkZoneMethodID ORDER BY ZoneType ASC,ZoneTitle ASC";
        $varOrderBy = "GROUP BY countryship.fkZoneGatewaysID, admin.pkAdminID ORDER BY ZoneType ASC,ZoneTitle ASC";

        $varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy . " " . $varLimit;

        $arrRes = $this->getArrayResult($varQuery);
        //$this->select(TABLE_SHIPPING_GATEWAYS, $arrClms, $argWhere, $varOrderBy, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function addZoneGateway
     *
     * This function is used to add the zone Gateway.
     *
     * Database Tables used in this function are : tbl_zone_gateways_pricelist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objZoneGateway->addZoneGateway($arrPost)
     */
    function addZoneGateway($arrPost) {

        //pre($arrPost);
        foreach ($arrPost['price'] as $key => $val) {

            if (empty($val)) {
                return 'EmptyPrice';
            }
        }
        foreach ($arrPost['minWeight'] as $key => $val) {

            if ((!empty($val)) && ($val >= $arrPost['maxWeight'][$key])) {
                return 'weightError';
            }
        }

        $varQuery = " SELECT * FROM " . TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ""
                . " WHERE fkZonePortalID = " . $arrPost['CountryPortalID'] . ""
                . " AND fkZoneGatewaysID = " . $arrPost['frmZoneGatewayID'] . "";
        $arrRes = $this->getArrayResult($varQuery);
        if (!empty($arrRes)) {
            return 'exist';
        }

        $startDate = time();
//        $date = date('Y-m-d', strtotime('+1 day', $startDate));
        $date = date('Y-m-d');

        $arrAddID = 0;
        foreach ($arrPost['frmZoneMultiCountryID'] as $key => $val) {

            if (!empty($arrPost['minWeight'][$key]) || !empty($arrPost['maxWeight'][$key]) || !empty($arrPost['price'][$key])) {

                $arrClms = array(
                    'fkZoneGatewaysID' => $arrPost['frmZoneGatewayID'],
                    'fkZonePortalID' => $arrPost['CountryPortalID'],
                    'fkZoneCountryID' => $val,
                    'minWeight' => $arrPost['minWeight'][$key],
                    'maxWeight' => $arrPost['maxWeight'][$key],
                    'zonePrice' => $arrPost['price'][$key],
                    'currentDate' => $date,
                );
                //pre($arrClms);
                $num = $this->insert(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $arrClms);
                $arrAddID += $num;
            }
        }
        return $arrAddID;
    }

    /**
     * function editZoneGateway
     *
     * This function is used to edit the zone Gateway.
     *
     * Database Tables used in this function are : tbl_zone_gateways_pricelist
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objZoneGateway->editZoneGateway($argSID, $argMID = 0)
     */
    function editZoneGateway($argSID, $argMID = 0) {
        $varWhrWeightPrice = "fkZoneGatewaysID =" . $argSID . " AND fkZonePortalID = " . $argMID . ""
                . " AND currentDate = ( SELECT max(currentDate) FROM " . TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ""
                . " as NewTbl WHERE fkZoneGatewaysID =" . $argSID . " AND fkZonePortalID = " . $argMID . ""
                . "  AND tbl_zone_gateways_new_pricelist.fkZoneCountryID=NewTbl.fkZoneCountryID "
                . " AND tbl_zone_gateways_new_pricelist.minWeight=NewTbl.minWeight "
                . "AND tbl_zone_gateways_new_pricelist.maxWeight=NewTbl.maxWeight" . ")";
        $table = TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ' LEFT JOIN tbl_admin ON pkAdminID = fkZonePortalID '
                . ' LEFT JOIN tbl_ship_gateways ON pkZoneGatewaysID = fkZoneGatewaysID '
                . ' LEFT JOIN tbl_country ON fkZoneCountryID = country_id '
                . '  ';
        $arrClmsWeightPrice = array(
            'pkZonePriceID',
            'fkZoneGatewaysID',
            'fkZonePortalID',
            'fkZoneCountryID',
            'minWeight',
            'maxWeight',
            'zonePrice',
            'AdminUserName',
            'ZoneTitle',
            'name',
            'country_id',
            'currentDate',
        );
//        $arrRes = $this->select(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $arrClmsWeightPrice, $varWhrWeightPrice, ' Weight ASC ');
        $arrRes = $this->select($table, $arrClmsWeightPrice, $varWhrWeightPrice, 'date(`currentDate`) desc,  name ASC, minWeight ASC');
//        $arrRes = $this->select($table, $arrClmsWeightPrice, $varWhrWeightPrice, 'date(`currentDate`) desc,  name ASC, minWeight ASC','','',true);
//        pre($arrRes);
        return $arrRes;
    }

    function editZoneGatewayOldEntry($argSID, $argMID = 0) {


        $varWhrWeightPrice = "fkZoneGatewaysID =" . $argSID . " AND fkZonePortalID = " . $argMID . ""
                . " AND currentDate = ( SELECT max(currentDate) FROM " . TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ""
                . " as NewTbl WHERE fkZoneGatewaysID =" . $argSID . " AND fkZonePortalID = " . $argMID . ""
                . "  AND tbl_zone_gateways_new_pricelist.fkZoneCountryID=NewTbl.fkZoneCountryID "
                . " AND tbl_zone_gateways_new_pricelist.minWeight=NewTbl.minWeight "
                . "AND tbl_zone_gateways_new_pricelist.maxWeight=NewTbl.maxWeight" . " AND currentDate <= CURDATE() group by currentDate order by currentDate desc limit 1 )";
        $table = TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ' LEFT JOIN tbl_admin ON pkAdminID = fkZonePortalID '
                . ' LEFT JOIN tbl_ship_gateways ON pkZoneGatewaysID = fkZoneGatewaysID '
                . ' LEFT JOIN tbl_country ON fkZoneCountryID = country_id '
                . '  ';
        $arrClmsWeightPrice = array(
            'pkZonePriceID',
            'fkZoneGatewaysID',
            'fkZonePortalID',
            'fkZoneCountryID',
            'minWeight',
            'maxWeight',
            'zonePrice',
            'AdminUserName',
            'ZoneTitle',
            'name',
            'country_id',
            'currentDate',
        );
//        $arrRes = $this->select(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $arrClmsWeightPrice, $varWhrWeightPrice, ' Weight ASC ');
        $arrRes = $this->select($table, $arrClmsWeightPrice, $varWhrWeightPrice, 'date(`currentDate`) desc,  name ASC, minWeight ASC');
//        $arrRes = $this->select($table, $arrClmsWeightPrice, $varWhrWeightPrice, 'date(`currentDate`) desc,  name ASC, minWeight ASC','','',true);
//        pre($arrRes);
        return $arrRes;
    }

    function getcountryZoneByID($argSID, $argMID = 0) {

//        echo $argSID. $argMID;die;
        $varQuery = "SELECT fkZoneGatewaysID,fkAdminID,fkcountry_id,name
            FROM " . TABLE_SHIP_COUNTRY . " LEFT JOIN " . TABLE_SHIP_MULTIPLECOUNTRY . " ON pkshipcountryid = fkshipcountryid 
            		LEFT JOIN tbl_country ON fkcountry_id = country_id";
        $argWhere = "fkZoneGatewaysID =" . $argSID . " AND fkAdminID = " . $argMID . "";
//        $argWhere = "fkZoneGatewaysID =" . $argSID . "";
        if ($argWhere <> '') {
            $varQuery .= " WHERE " . $argWhere;
        }

        //$varQuery .= " GROUP BY(pkZoneGatewaysID) DESC ";
        if ($argLimit <> '') {
            $varQuery .= " LIMIT " . $argLimit;
        }

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function updateZoneGateway
     *
     * This function is used to update the zone Gateway.
     *
     * Database Tables used in this function are : tbl_zone_gateways_pricelist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return 1
     *
     * User instruction: $objZoneGateway->updateZoneGateway($arrPost)
     */
    function updateZoneGateway($arrPost) {
        // pre($arrPost);


        foreach ($arrPost['minWeight'] as $key => $val) {

            //echo $val;
            if ((!empty($val)) && ($val >= $arrPost['maxWeight'][$key])) {
                return 'weightError';
            }
        }
//        $startDate = time();
//        $date = date('Y-m-d', strtotime('+1 day', $startDate));
////        $date = date('Y-m-d');
//        
//        $varWheresD = "fkZoneGatewaysID = " . $arrPost['sgid'] . " AND  fkZonePortalID=" . $arrPost['smid'] . " AND DATE(currentDate) = '" . $date . "'";
//        
//        $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWheresD);
        //pre($pre);
//        pre($arrPost);
        //$date = date('Y-m-d');
        $arrAddID = 0;
        foreach ($arrPost['frmZoneMultiCountryID'] as $key => $val) {
            if (!empty($arrPost['minWeight'][$key]) || !empty($arrPost['maxWeight'][$key]) || !empty($arrPost['price'][$key])) {

                /* First Delete duplicate entry */
                $startDate = time();
                $dateTommorow = date('Y-m-d', strtotime('+1 day', $startDate));
                $date = date('Y-m-d');



//                $ExistingarrRes = $this->getArrayResult($varQuery);
//                pre($ExistingarrRes[0]['pkZonePriceID']);
//                if($key == 1)
//                pre($varQuery);
//                $varWheresD11 = "fkZoneGatewaysID = " . $arrPost['sgid'] . " "
//                        . " AND  fkZonePortalID=" . $arrPost['smid'] . ""
//                        . " AND  fkZoneCountryID=" . $val . ""
////                        ." AND  zonePrice=" . $arrPost['price'][$key] . ""
//                        . " AND (DATE(currentDate) = '" . $date . "'"
//                        . " OR DATE(currentDate) = '" . $dateTommorow . "')";
//                $varWheresD = "pkZonePriceID = '" . $ExistingarrRes[0]['pkZonePriceID'] . "'";
//                //pre($varWheresD);
////                $DeleteVar = $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWheresD11);
//                $DeleteVar = $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWheresD);
                if (!isset($arrPost['pkZonePriceID'][$key])) {
                    $arrClms = array(
                        'fkZoneGatewaysID' => $arrPost['sgid'],
                        'fkZonePortalID' => $arrPost['smid'],
                        'fkZoneCountryID' => $val,
                        'minWeight' => $arrPost['minWeight'][$key],
                        'maxWeight' => $arrPost['maxWeight'][$key],
                        'zonePrice' => $arrPost['price'][$key],
                        'currentDate' => $date,
                    );
                    $num = $this->insert(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $arrClms);
                } else {

                    $varQuery = "SELECT * FROM " . TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ""
                            . " WHERE fkZoneGatewaysID = " . $arrPost['sgid'] . ""
                            . " AND  pkZonePriceID=" . $arrPost['pkZonePriceID'][$key] . ""
                            . " AND  fkZonePortalID=" . $arrPost['smid'] . ""
                            . " AND  minWeight=" . $arrPost['minWeight'][$key] . ""
                            . " AND  maxWeight=" . $arrPost['maxWeight'][$key] . ""
                            . " AND  zonePrice=" . $arrPost['price'][$key] . ""
                            . " AND  fkZoneCountryID=" . $val . "";
                    $ExistingarrRes = $this->getArrayResult($varQuery);

                    if (count($ExistingarrRes))
                        continue;

                    $varQuery123 = "SELECT * FROM " . TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ""
                            . " WHERE fkZoneGatewaysID = " . $arrPost['sgid'] . ""
                            . " AND  pkZonePriceID=" . $arrPost['pkZonePriceID'][$key] . ""
                            . " AND  fkZonePortalID=" . $arrPost['smid'] . ""
                            . " AND  minWeight=" . $arrPost['minWeight'][$key] . ""
                            . " AND  maxWeight=" . $arrPost['maxWeight'][$key] . ""
                            . " AND  zonePrice=" . $arrPost['price'][$key] . ""
                            . " AND  fkZoneCountryID=" . $val . ""
                            . " AND  currentDate>=" . $date . "";
                    $ExistingarrRes = $this->getArrayResult($varQuery123);

                    if (!empty($ExistingarrRes)) {
                        $arrClms = array(
                            'fkZoneGatewaysID' => $arrPost['sgid'],
                            'fkZonePortalID' => $arrPost['smid'],
                            'fkZoneCountryID' => $val,
                            'minWeight' => $arrPost['minWeight'][$key],
                            'maxWeight' => $arrPost['maxWeight'][$key],
                            'zonePrice' => $arrPost['price'][$key],
                            'currentDate' => $dateTommorow,
                        );

                        $varWhr = 'pkZonePriceID = ' . $arrPost['pkZonePriceID'][$key];
                        $arrAddID = $this->update(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $arrClms, $varWhr);
                    } else {

                        $arrClms = array(
                            'fkZoneGatewaysID' => $arrPost['sgid'],
                            'fkZonePortalID' => $arrPost['smid'],
                            'fkZoneCountryID' => $val,
                            'minWeight' => $arrPost['minWeight'][$key],
                            'maxWeight' => $arrPost['maxWeight'][$key],
                            'zonePrice' => $arrPost['price'][$key],
                            'currentDate' => $dateTommorow,
                        );
                        $arrAddID = $this->insert(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $arrClms);
                    }
                }
//                if (empty($ExistingarrRes)) {
//                    
//                    $arrClms = array(
//                        'fkZoneGatewaysID' => $arrPost['sgid'],
//                        'fkZonePortalID' => $arrPost['smid'],
//                        'fkZoneCountryID' => $val,
//                        'minWeight' => $arrPost['minWeight'][$key],
//                        'maxWeight' => $arrPost['maxWeight'][$key],
//                        'zonePrice' => $arrPost['price'][$key],
//                        'currentDate' => $date,
//                    );
//                    
//                } else {
//
//                    $arrClms = array(
//                        'fkZoneGatewaysID' => $arrPost['sgid'],
//                        'fkZonePortalID' => $arrPost['smid'],
//                        'fkZoneCountryID' => $val,
//                        'minWeight' => $arrPost['minWeight'][$key],
//                        'maxWeight' => $arrPost['maxWeight'][$key],
//                        'zonePrice' => $arrPost['price'][$key],
//                        'currentDate' => $dateTommorow,
//                    );
//                }
                //$num = $this->insert(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $arrClms);
                $arrAddID += $num;
            }
        }

//        return $arrAddID;
        return 1;
    }

    function DeleteShipPriceRow($argPostIDs) {


        if (isset($argPostIDs) && ($argPostIDs > 0)) {

//            $DQuery = "DELETE FROM tbl_zone_gateways_new_pricelistWHERE pkZonePriceID IN
//        (
//        SELECT * FROM ( SELECT pkZonePriceID FROM `tbl_zone_gateways_new_pricelist` 
//        WHERE `fkZoneGatewaysID` = '". $_REQUEST['GateID'] ."' 
//        AND `fkZonePortalID` = '". $_REQUEST['PortalID'] ."' 
//        AND `fkZoneCountryID` = '". $_REQUEST['CountryID'] ."' 
//        AND `minWeight` = '". $_REQUEST['MinWg'] ."' AND `maxWeight` = '". $_REQUEST['MaxWg'] ."' 
//        ORDER BY `currentDate` ) a ) and `fkZoneGatewaysID` = '". $_REQUEST['GateID'] ."' 
//        AND `fkZonePortalID` = '". $_REQUEST['PortalID'] ."' 
//        AND `fkZoneCountryID` = '". $_REQUEST['CountryID'] ."' 
//        AND `minWeight` = '". $_REQUEST['MinWg'] ."' AND `maxWeight` = '". $_REQUEST['MaxWg'] ."'";

            $varWhereAllD = "`fkZoneGatewaysID` = '" . $_REQUEST['GateID'] . "' 
                                AND `fkZonePortalID` = '" . $_REQUEST['PortalID'] . "' 
                                AND `fkZoneCountryID` = '" . $_REQUEST['CountryID'] . "' 
                                AND `minWeight` = '" . $_REQUEST['MinWg'] . "' AND `maxWeight` = '" . $_REQUEST['MaxWg'] . "'";

//            $varWhereAllD = "pkZonePriceID = '" . $argPostIDs . "'";
            $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWhereAllD);
        }
        return true;
    }

    function DeleteShipGatewayRow($argPostIDs) {


        if (isset($argPostIDs) && ($argPostIDs > 0)) {

            $varWhereAllD = "pkID = " . $_REQUEST['gatwayID'] . "";

//            $varWhereAllD = "pkZonePriceID = '" . $argPostIDs . "'";
            $this->delete(TABLE_GATEWAYS_PORTAL, $varWhereAllD);
        }
        return true;
    }

    /**
     * function updateZoneGatewayStatus
     *
     * This function is used to update the zone Gateway status.
     *
     * Database Tables used in this function are : tbl_zone_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objZoneGateway->updateZoneGatewayStatus($arrPost)
     */
    function updateZoneGatewayStatus($arrPost) {
        $varWhr = 'pkZoneGatewaysID = ' . $arrPost['sgid'];
        $arrClms = array('ZoneStatus' => $arrPost['status']);
        $arrUpdateID = $this->update(TABLE_SHIP_GATEWAYS, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function removeZoneGateway
     *
     * This function is used to remove the zone Gateway.
     *
     * Database Tables used in this function are : tbl_zone_gateways_pricelist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objZoneGateway->removeZoneGateway($argPostIDs)
     */
    function removeZoneGateway($argPostIDs) {


        if (isset($argPostIDs['deleteType']) && $argPostIDs['deleteType'] == 'sD') {

            $varWhereAllD = "fkZoneGatewaysID = '" . $argPostIDs['frmID'] . "' AND fkZonePortalID='" . $argPostIDs['PortalID'] . "'";
            $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWhereAllD);
        } else {
            $ctr = 0;
            foreach ($argPostIDs['frmID'] as $varDeleteID) {
                $varWhereAllD = "fkZoneMethodID='" . $varDeleteID . "'";
                $this->delete(TABLE_SHIPPING_GATEWAYS_PRICELIST, $varWhereAllD);
            }
        }

        return true;
    }

    /**
     * function zoneMethodList
     *
     * This function is used to retrive admin user List.
     *
     * Database Tables used in this function are : tbl_zone_method, tbl_zone_gateways
     *
     * @access public
     *
     * @parameters 2 $string(optional), $string(optional)
     *
     * @return array $arrRes
     */
    function zoneMethodList($argWhere = '', $argLimit = '') {
        $arrClms = array(
            'pkZoneGatewaysID',
        );
        $varOrderBy = "";
        //pre($argWhere);
        $varTable = TABLE_SHIP_GATEWAYS;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    function zoneCountryPortalList($argWhere = '', $argLimit = '') {

        $arrClms = array(
            'pkZoneGatewaysID',
        );
        $varOrderBy = "";
        $varQuery = "SELECT * FROM tbl_ship_gateways LEFT JOIN tbl_gateway_portal ON fkgatewayID = pkZoneGatewaysID WHERE " . $argWhere;
        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }

    function zoneCountryAllowedList($argWhere = '', $argLimit = '') {

        $arrClms = array(
            'pkZoneGatewaysID',
        );
        $varOrderBy = "";
        $varQuery = "SELECT * FROM tbl_ship_countries LEFT JOIN tbl_ship_multiplecountries ON fkshipcountryid = pkshipcountryid
        		  LEFT JOIN tbl_country ON fkcountry_id = country_id WHERE " . $argWhere;
        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function adminList
     *
     * This function is used to insert Zone Method.
     *
     * Database Tables used in this function are : tbl_zone_method
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrAddID
     */
    function addZoneMethod($arrPost) {
        global $objCore;
        $varWhere = "MethodCode='" . $arrPost['frmMethodCode'] . "' ";
        $arrMethod = $this->zoneMethodList($varWhere);
        if (count($arrMethod) == 0) {
            $arrClms = array(
                'fkZoneGatewayID' => $arrPost['frmfkZoneGatewayID'],
                'MethodName' => $arrPost['frmMethodName'],
                'MethodCode' => $arrPost['frmMethodCode'],
                'MethodDescription' => $arrPost['frmMethodDescription'],
                'MethodDateAdded' => $objCore->serverDateTime(date(DATE_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $arrAddID = $this->insert(TABLE_SHIPPING_METHOD, $arrClms);
            return $arrAddID;
        } else {
            return 'exist';
        }
    }

    /**
     * function getZoneMethodByID
     *
     * This function is used to get Zone Method.
     *
     * Database Tables used in this function are : tbl_zone_method
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrRes
     */
    function getZoneMethodByID($argID) {
        $varWhr = "pkZoneMethod ='" . $argID . "' ";
        $arrClms = array('pkZoneMethod', 'fkZoneGatewayID', 'MethodName', 'MethodCode', 'MethodDescription');
        $arrRes = $this->select(TABLE_SHIPPING_METHOD, $arrClms, $varWhr);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function updateZoneMethod
     *
     * This function is used to insert Zone Method.
     *
     * Database Tables used in this function are : tbl_zone_method
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrUpdateID
     */
    function updateZoneMethod($arrPost) {
        $varWhere = "MethodCode='" . $arrPost['frmMethodCode'] . "' AND  pkZoneMethod != '" . $_GET['smid'] . "' ";
        $arrMethod = $this->zoneMethodList($varWhere);
        if (count($arrMethod) == 0) {
            $arrClms = array(
                'fkZoneGatewayID' => $arrPost['frmfkZoneGatewayID'],
                'MethodName' => $arrPost['frmMethodName'],
                'MethodCode' => $arrPost['frmMethodCode'],
                'MethodDescription' => $arrPost['frmMethodDescription']
            );

            $varWhr = "pkZoneMethod = '" . $_GET['smid'] . "' ";
            $arrUpdateID = $this->update(TABLE_SHIPPING_METHOD, $arrClms, $varWhr);

            return $arrUpdateID;
        } else {
            return 'exist';
        }
    }

    /**
     * function removeZoneMethod
     *
     * This function is used to remove the zone method.
     *
     * Database Tables used in this function are : tbl_zone_method
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objZoneGateway->removeZoneMethod($argPostIDs)
     */
    function removeZoneMethod($argPostIDs) {
        $varWhereAllD = "pkZoneMethod = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_SHIPPING_METHOD, $varWhereAllD);
        return true;
    }

    /**
     * function zoneList
     *
     * This function is used to retrive zone List.
     *
     * Database Tables used in this function are : tbl_zone_method, tbl_zone_gateways
     *
     * @access public
     *
     * @parameters 2 $string(optional), $string(optional)
     *
     * @return array $arrRes
     */
    function zoneList($argWhere = '', $argLimit = '') {
        $varQuery = "SELECT zoneid, title
            FROM " . TABLE_ZONE . '';

        if ($argWhere <> '') {
            $varQuery .= " WHERE " . $argWhere;
        }

        //$varQuery .= " GROUP BY(pkZoneGatewaysID) DESC ORDER BY ZoneType ASC";
        $varQuery .= "   GROUP BY(title)ORDER BY zoneid DESC ";
        if ($argLimit <> '') {
            $varQuery .= " LIMIT " . $argLimit;
        }

        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
    }

    function zoneeditList($argWhere) {
//         if ($argWhere <> '') {
//            $varQuery .= " fklogisticid=" . $fklogisticid;
//        }
//        $varClms = "zoneid, title,id,fkzoneid, fromcountry,fromstate, fromcity,fromdistance, tocountry,tostate, tocity,todistance";
//        $varTable = TABLE_ZONE . " LEFT JOIN " . TABLE_ZONEDETAIL . " "
//                . " ON zoneid = id ";
//        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
//        $varOrderBy="ORDER BY id ASC";
//        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";
//        $varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy . " " . $varLimit;
//
//        $arrRes = $this->getArrayResult($varQuery);
//       // pre($arrRes);
//        return $arrRes;
        $fklogisticid = $argWhere;
        $varQuery = "SELECT zoneid, title
            FROM " . TABLE_ZONE . '';

        if ($argWhere <> '') {
            $varQuery .= " WHERE fklogisticid=" . $fklogisticid;
        }

        // $varQuery .= "   GROUP BY(title)ORDER BY zoneid DESC ";
        $varQuery .= "   GROUP BY(title) ";
        if ($argLimit <> '') {
            $varQuery .= " LIMIT " . $argLimit;
        }
        // $arrResdata=array();
        $arrRes = $this->getArrayResult($varQuery);

        foreach ($arrRes as $key => $val) {

            $pkzoneid = $val['zoneid'];
            $pkzonetitle = $val['title'];


            $varQuery = "SELECT id,fkzoneid, fromcountry,fromstate, fromcity,fromdistance, tocountry,tostate, tocity,
                        todistance
                        FROM " . TABLE_ZONEDETAIL . '';
            $varQuery .= " WHERE fkzoneid=" . $pkzoneid;

            $varQuery .= " ORDER BY id ASC ";
            //$varQuery .= "   GROUP BY(title) ";
            if ($argLimit <> '') {
                $varQuery .= " LIMIT " . $argLimit;
            }
            //$arrResdata[$key]=$pkzonetitle;
            $arrResdata[] = $this->getArrayResult($varQuery);
            $TitleData[$key]['title'] = $pkzonetitle;
            $zoneidData[$key]['pkzoneid'] = $pkzoneid;
        }

        foreach ($arrResdata as $key => $value) {
            foreach ($value as $k => $val) {
                $arrResdata[$key][$k]['title'] = $TitleData[$key]['title'];
                $arrResdata[$key][$k]['pkzoneid'] = $zoneidData[$key]['pkzoneid'];
            }
        }
        //    pre($arrResdata);

        return $arrResdata;
    }

    function updatezonetitlebyid($title_id, $title_name) {
        global $objCore;
        $title_namewithzone = 'zone' . $title_name;
        $arrClms = array(
            'title' => $title_namewithzone,
        );
        $varUserWhere = " title='" . $title_namewithzone . "' And fklogisticid='" . $_SESSION['sessLogistic'] . "'";

        $arrClms1 = array('title',);
        $arrUserList = $this->select(TABLE_ZONE, $arrClms1, $varUserWhere);

        $varCountName = count($arrUserList[0]['title']);
        // pre($varCountName);
        if ($varCountName > 0) {
            // $_SESSION['sessArrUsers'] = $argArrPost;
            $objCore->setErrorMsg('Zone Title Name Already Exists ');
            return false;
        } else {
            $varWhr = "zoneid = '" . $title_id . "' ";
            //pre($arrClms);
            //print_r($arrClms);
            $arrUpdateID = $this->update(TABLE_ZONE, $arrClms, $varWhr); // pre($title_name);
            if ($arrUpdateID > 0) {
                // $_SESSION['sessArrUsers'] = $argArrPost;
                $objCore->setSuccessMsg('Title updated successfully ');
                return false;
            }
        }
    }

    function removezonetabledataid($id) {
        global $objCore;


        $varUserWhere = " id=" . $id . "";

        $arrClms1 = array('fkzoneid',);
        $arrUserList = $this->select(TABLE_ZONEDETAIL, $arrClms1, $varUserWhere);
//        pre($arrUserList[0]['fkzoneid']);


        $varWhereAllD = "id = " . $id . "";
        $arrDeleteID = $this->delete(TABLE_ZONEDETAIL, $varWhereAllD);
        // $arrUpdateID = $this->update(TABLE_ZONE, $arrClms, $varWhr);// pre($title_name);
        if ($arrDeleteID > 0) {

            /* update detail table with detail ids */
            $Query = "SELECT * FROM " . TABLE_ZONEDETAIL . " WHERE fkzoneid = " . $arrUserList[0]['fkzoneid'] . "";
            $arrRes = $this->getArrayResult($Query);
            $fIds = array();
            foreach ($arrRes as $vv1) {
                array_push($fIds, $vv1['id']);
            }
            $fIdSting = implode(',', $fIds);

            $clm = array('fkzonedetailid' => $fIdSting);
            $varWh = "zonetitleid = '" . $arrUserList[0]['fkzoneid'] . "' ";
            $arrUpdateID = $this->update('tbl_zoneprice', $clm, $varWh);




            // $_SESSION['sessArrUsers'] = $argArrPost;
            $objCore->setSuccessMsg('Record Deleted Successfully ');
            return true;
        }
    }

    function removezonecompletedataid($id) {
        //pre($id);
        global $objCore;
        $varWhereAllD1 = "zoneid = '" . $id . "'";
        $arrDeleteID1 = $this->delete(TABLE_ZONE, $varWhereAllD1);
        // pre($arrDeleteID1);
        $varWhereAllD2 = "fkzoneid = '" . $id . "'";
        // pre($varWhereAllD2);
        //$arrDeleteID =$this->delete(TABLE_ZONEDETAIL, $varWhereAllD);
        $this->delete(TABLE_ZONEDETAIL, $varWhereAllD2);
        // $arrUpdateID = $this->update(TABLE_ZONE, $arrClms, $varWhr);// pre($title_name);
        if ($arrDeleteID1 > 0) {
            // $_SESSION['sessArrUsers'] = $argArrPost;
            $objCore->setSuccessMsg('Record Deleted Successfully ');
            return true;
        }
    }

    function checkzonecreateonece($arrPost) {

        $varQuery = "SELECT zoneid, title
            FROM " . TABLE_ZONE . '';
        $argWhere = " fklogisticid = " . $_SESSION['sessLogistic'];

        $varQuery .= " WHERE " . $argWhere;



        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
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
    function addZone($arrPost) {
        // pre($arrPost);
        if (!empty($arrPost['fcountry'])) {
            //pre($arrPost['title']);

            foreach ($arrPost['title'] as $key => $val) {
                $arrClms = array(
                    'title' => $val,
                    'fklogisticid' => $_SESSION['sessLogistic'],
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
        }
        // pre($val2);   
    }

    function addZone11($arrPost) {
        global $objCore;
        $varWhere = "ZoneAlias='" . $arrPost['frmZoneCode'] . "' ";
        $arrMethod = $this->zoneList($varWhere);
        if (count($arrMethod) == 0) {
            $arrClms = array(
                'ZoneType' => 'admin',
                'ZoneTitle' => $arrPost['frmZoneName'],
                'ZoneAlias' => $arrPost['frmZoneCode'],
                'ZoneStatus' => $arrPost['frmStatus'],
                'ZoneDateAdded' => $objCore->serverDateTime(date(DATE_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $arrAddID = $this->insert(TABLE_SHIPPING_GATEWAYS, $arrClms);

            $arrClmsUpdate = array('id' => $arrAddID, 'name' => $arrPost['frmZoneName'], 'action' => 'add', 'type' => 'zone');
            $arrClmsUpdateReturn = $this->insert(TABLE_UPDATE_CATEGORY_ATTR_SHIPPING, $arrClmsUpdate);

            $sendUpdateToWholesaler = array('pkWholesalerID', 'CompanyEmail', 'CompanyName');
            $whrereSendUpdateToWholesaler = "WholesalerAPIKey<>''";
            $sendUpdateToWholesalerReturn = $this->select(TABLE_WHOLESALER, $sendUpdateToWholesaler, $whrereSendUpdateToWholesaler);
            if (count($sendUpdateToWholesalerReturn) > 0) {

                foreach ($sendUpdateToWholesalerReturn as $key => $whlMail) {

                    $objTemplate = new EmailTemplate();
                    $objCore = new Core();

                    $varUserName = trim(strip_tags($whlMail['CompanyName']));
                    $varPassword = trim(strip_tags($arrPost['frmPassword']));
                    //pre($varUserName);
                    $varToUser = $whlMail['CompanyEmail']; //'raju.khatak@mail.vinove.com';

                    $varFromUser = $_SESSION['sessAdminEmail'];

                    $varSiteName = SITE_NAME;

                    $varWhereTemplate = " EmailTemplateTitle= 'New Zone gateway has been added' AND EmailTemplateStatus = 'Active' ";

                    $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                    $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                    $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                    $varPathImage = '';
                    $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                    $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                    $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                    $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $arrPost['frmZoneName']);

                    $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                    // Calling mail function

                    $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                }
            }

            return $arrAddID;
        } else {
            return 'exist';
        }
    }

    /**
     * function getZoneByID
     *
     * This function is used to get Zone.
     *
     * Database Tables used in this function are : tbl_zone_gateways
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrRes
     */
    function getZoneByID($argID) {
        $varWhr = "pkZoneGatewaysID ='" . $argID . "' AND ZoneType='admin'";
        $arrClms = array('pkZoneGatewaysID', 'ZoneTitle', 'ZoneAlias', 'ZoneStatus', 'ZoneDescription');
        $arrRes = $this->select(TABLE_SHIP_GATEWAYS, $arrClms, $varWhr);
        //pre($arrRes);
        return $arrRes;
    }

    function getSelectedPortal($argID) {

        $varQuery = "SELECT pkID,fkgatewayID,fkportalID,gatewayEmail,AdminUserName FROM tbl_gateway_portal LEFT JOIN tbl_admin ON pkAdminID = fkportalID WHERE fkgatewayID = '$argID'";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function updateZone
     *
     * This function is used to insert Zone.
     *
     * Database Tables used in this function are : tbl_zone_gateways
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrUpdateID
     */
    function updateZone($arrPost) {
//        pre($arrPost);
        if (!empty($arrPost['fcountry'])) {
            //pre($arrPost['title']);
//                $arrClms = array(
//                    //'title' => $val,
//                    'fklogisticid' => $_SESSION['sessLogistic'],
//                );
//                $varWhereAllD = "zoneid='" . $arrPost['zoneid'][$key] . "'";
//                //pre($varWhereAllD);
//                $this->delete(TABLE_ZONE, $varWhereAllD);
//                 
//                $zone_id = $this->insert(TABLE_ZONE, $arrClms);
            //pre($arrPost);
            foreach ($arrPost['fcountry'] as $key => $value) {

                if (!empty($arrPost['zoneid'][$key])) {
                    //pre($arrPost['zoneid'][$key]);
                    foreach ($arrPost['fcountry'][$key] as $k => $v) {

                        if (!empty($arrPost['detailzoneid'][$key][$k])) {

                            $arrclms0 = array(
                                //'fkzoneid' => $arrPost['zoneid'][$key],
                                'fromcountry' => $arrPost['fcountry'][$key][$k],
                                'fromstate' => $arrPost['fstate'][$key][$k],
                                'fromcity' => $arrPost['fcity'][$key][$k],
                                'fromdistance' => $arrPost['frmdistance'][$key][$k],
                                'tocountry' => $arrPost['tcountry'][$key][$k],
                                'tostate' => $arrPost['tstate'][$key][$k],
                                'tocity' => $arrPost['tcity'][$key][$k],
                                'todistance' => $arrPost['todistance'][$key][$k],
                            );
                            //$varWhr = "fkzoneid = '" . $arrPost['zoneid'][$key] . "' ";
                            $varWhr = "id = '" . $arrPost['detailzoneid'][$key][$k] . "' ";
                            $arrUpdateID = $this->update('tbl_zonedetail', $arrclms0, $varWhr);
                        } else {

                            $arrclms1 = array(
                                'fkzoneid' => $arrPost['zoneid'][$key],
                                'fromcountry' => $arrPost['fcountry'][$key][$k],
                                'fromstate' => $arrPost['fstate'][$key][$k],
                                'fromcity' => $arrPost['fcity'][$key][$k],
                                'fromdistance' => $arrPost['frmdistance'][$key][$k],
                                'tocountry' => $arrPost['tcountry'][$key][$k],
                                'tostate' => $arrPost['tstate'][$key][$k],
                                'tocity' => $arrPost['tcity'][$key][$k],
                                'todistance' => $arrPost['todistance'][$key][$k],
                            );
                            $varWhr = "fkzoneid = '" . $arrPost['zoneid'][$key] . "' ";
                            $arrUpdateID = $this->insert('tbl_zonedetail', $arrclms1, $varWhr);
                        }
                    }
                } else {
                    $arrClms = array(
                        'title' => $arrPost['title'][$key],
                        'fklogisticid' => $_SESSION['sessLogistic'],
                    );
                    $zone_id = $this->insert(TABLE_ZONE, $arrClms);

                    foreach ($arrPost['fcountry'][$key] as $k1 => $v1) {
                        $arrClms2 = array(
                            'fkzoneid' => $zone_id,
                            'fromcountry' => $arrPost['fcountry'][$key][$k1],
                            'fromstate' => $arrPost['fstate'][$key][$k1],
                            'fromcity' => $arrPost['fcity'][$key][$k1],
                            'fromdistance' => $arrPost['frmdistance'][$key][$k1],
                            'tocountry' => $arrPost['tcountry'][$key][$k1],
                            'tostate' => $arrPost['tstate'][$key][$k1],
                            'tocity' => $arrPost['tcity'][$key][$k1],
                            'todistance' => $arrPost['todistance'][$key][$k1],
                        );

                        $arrUpdateID = $this->insert('tbl_zonedetail', $arrClms2);
                    }
//                    pre($arrClms2);
                }

                if (!empty($arrPost['zoneid'][$key])) {
                    $Query = "SELECT * FROM " . TABLE_ZONEDETAIL . " WHERE fkzoneid = " . $arrPost['zoneid'][$key] . "";
                    $arrRes = $this->getArrayResult($Query);
                    $fIds = array();
                    foreach ($arrRes as $vv1) {
                        array_push($fIds, $vv1['id']);
                    }
                    $fIdSting = implode(',', $fIds);

                    $clm = array('fkzonedetailid' => $fIdSting);
                    $varWh = "zonetitleid = '" . $arrPost['zoneid'][$key] . "' ";

                    $arrUpdateID = $this->update('tbl_zoneprice', $clm, $varWh);
                }
            }

//                foreach ($arrPost['fcountry'][$key] as $i => $val2) {
//
//
//                    //  echo 'hi<br>';
//                    $arrclms1 = array(
//                        'fkzoneid' => $zone_id,
//                        'fromcountry' => $val2,
//                        'fromstate' => $arrPost['fstate'][$key][$i],
//                        'fromcity' => $arrPost['fcity'][$key][$i],
//                        'fromdistance' => $arrPost['frmdistance'][$key][$i],
//                        'tocountry' => $arrPost['tcountry'][$key][$i],
//                        'tostate' => $arrPost['tstate'][$key][$i],
//                        'tocity' => $arrPost['tcity'][$key][$i],
//                        'todistance' => $arrPost['todistance'][$key][$i],
//                    );
//                    $varWhereAll = "fkzoneid='" . $arrPost['zoneid'][$key] . "'";
//                    //pre($varWhereAllD);
//                    $this->delete('tbl_zonedetail', $varWhereAll);
//                  // pre($arrclms1);
//                    $zonedetais_id = $this->insert('tbl_zonedetail', $arrclms1);
//                }

            return 1;
            //die();
        } else {
            return 'exist';
        }
    }

    /**
     * function removeZone
     *
     * This function is used to remove the zone.
     *
     * Database Tables used in this function are : tbl_zone_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objZoneGateway->removeZone($argPostIDs)
     */
    function removeZone($argPostIDs) {
        $varWhereAllD = "pkZoneGatewaysID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_SHIP_GATEWAYS, $varWhereAllD);

        $varWhereAllD = "fkgatewayID='" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_GATEWAYS_PORTAL, $varWhereAllD);

        $arrClmsUpdate = array('id' => $argPostIDs['frmID'], 'name' => $argPostIDs['shipName'], 'action' => 'delete', 'type' => 'zone');
        $arrClmsUpdateReturn = $this->insert(TABLE_UPDATE_CATEGORY_ATTR_SHIPPING, $arrClmsUpdate);

        $sendUpdateToWholesaler = array('pkWholesalerID', 'CompanyEmail', 'CompanyName');
        $whrereSendUpdateToWholesaler = "WholesalerAPIKey<>''";
        $sendUpdateToWholesalerReturn = $this->select(TABLE_WHOLESALER, $sendUpdateToWholesaler, $whrereSendUpdateToWholesaler);
        if (count($sendUpdateToWholesalerReturn) > 0) {

            foreach ($sendUpdateToWholesalerReturn as $key => $whlMail) {

                $objTemplate = new EmailTemplate();
                $objCore = new Core();

                $varUserName = trim(strip_tags($whlMail['CompanyName']));
                $varPassword = trim(strip_tags($arrPost['frmPassword']));
                //pre($varUserName);
                $varToUser = $whlMail['CompanyEmail']; //'raju.khatak@mail.vinove.com';

                $varFromUser = $_SESSION['sessAdminEmail'];

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'Zone gateway has been deleted' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '';
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $arrPost['frmZoneName']);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function

                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
            }
        }

        return true;
    }

    /**
     * function getZoneCountry
     *
     * This function is used to remove the zone.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 0
     *
     * @return true
     *
     * User instruction: $objZoneGateway->getZoneCountry()
     */
    function getZoneCountry() {

        $varQuery = "SELECT zone,group_concat(' ',name) as Countries FROM " . TABLE_COUNTRY . " WHERE status='1' AND zone!='' GROUP BY(zone) ASC";

        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }

}

?>