<?php

/**
 *
 * Class name : ShippingGatewayNew
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The ShippingGateway class is used to maintain ShippingGateway infomation details for several modules.
 */
class ShippingGatewayNew extends Database {

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
     * function shippingGatewayList
     *
     * This function is used to display the shipping Gateway List.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objShippingGateway->shippingGatewayList($argWhere = '', $argLimit = '')
     */
    function shippingGatewayList($argWhere = '', $argLimit = '') {
        $arrClms = array(
            'pkShippingGatewaysID',
            'ShippingType',
            'ShippingTitle',
            'ShippingStatus'
        );
        $varOrderBy = 'ShippingType ASC,ShippingTitle ASC ';
        $arrRes = $this->select(tbl_ship_gateways, $arrClms, $argWhere, $varOrderBy, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function shippingGatewayPriceList
     *
     * This function is used to display the shipping Gateway Price List.
     *
     * Database Tables used in this function are : tbl_shipping_gateways_pricelist, tbl_shipping_gateways, tbl_shipping_method
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objShippingGateway->shippingGatewayPriceList($argWhere = '', $argLimit = '')
     */
    function shippingGatewayPriceList($argWhere = '', $argLimit = '') {
        $varClms = "admin.pkAdminID,price.pkShippingPriceID,
            gatway.ShippingType,gatway.ShippingTitle,gatway.ShippingStatus,
            price.minWeight,price.maxWeight,price.shippingPrice,price.fkShippingGatewaysID,
            admin.AdminUserName,admin.AdminEmail,
            countryship.fkShippingGatewaysID as a,countryship.fkAdminID as b,
            mulcountry.fkshipcountryid as c,
            GROUP_CONCAT(DISTINCT country.name) as countryName, GROUP_CONCAT(DISTINCT country.country_id) as countryID
            ";
//        $varClms = "*";
        $startDate = time();
        $date = date('Y-m-d');
        $varTable = TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . " AS price LEFT JOIN " . TABLE_SHIP_GATEWAYS .
                " AS gatway ON price.fkShippingGatewaysID = gatway.pkShippingGatewaysID LEFT JOIN " . TABLE_ADMIN .
                " AS admin ON price.fkShippingPortalID = admin.pkAdminID LEFT JOIN " . TABLE_SHIP_COUNTRY .
                " AS countryship ON price.fkShippingGatewaysID = countryship.fkShippingGatewaysID AND price.fkShippingPortalID = countryship.fkAdminID LEFT JOIN " . TABLE_SHIP_MULTIPLECOUNTRY .
                " AS mulcountry ON mulcountry.fkshipcountryid = countryship.pkshipcountryid LEFT JOIN " . TABLE_COUNTRY .
                " AS country ON country.country_id =  mulcountry.fkcountry_id"
                . " WHERE countryship.pkshipcountryid = mulcountry.fkshipcountryid "
        ;
        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";
        //$varOrderBy = "GROUP BY fkShippingMethodID ORDER BY ShippingType ASC,ShippingTitle ASC";
        $varOrderBy = "GROUP BY countryship.fkShippingGatewaysID, admin.pkAdminID ORDER BY ShippingType ASC,ShippingTitle ASC";

        $varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy . " " . $varLimit;

        $arrRes = $this->getArrayResult($varQuery);
        //$this->select(TABLE_SHIPPING_GATEWAYS, $arrClms, $argWhere, $varOrderBy, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function addShippingGateway
     *
     * This function is used to add the shipping Gateway.
     *
     * Database Tables used in this function are : tbl_shipping_gateways_pricelist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objShippingGateway->addShippingGateway($arrPost)
     */
    function addShippingGateway($arrPost) {

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
                . " WHERE fkShippingPortalID = " . $arrPost['CountryPortalID'] . ""
                . " AND fkShippingGatewaysID = " . $arrPost['frmShippingGatewayID'] . "";
        $arrRes = $this->getArrayResult($varQuery);
        if (!empty($arrRes)) {
            return 'exist';
        }

        $startDate = time();
//        $date = date('Y-m-d', strtotime('+1 day', $startDate));
        $date = date('Y-m-d');

        $arrAddID = 0;
        foreach ($arrPost['frmShippingMultiCountryID'] as $key => $val) {

            if (!empty($arrPost['minWeight'][$key]) || !empty($arrPost['maxWeight'][$key]) || !empty($arrPost['price'][$key])) {

                $arrClms = array(
                    'fkShippingGatewaysID' => $arrPost['frmShippingGatewayID'],
                    'fkShippingPortalID' => $arrPost['CountryPortalID'],
                    'fkShippingCountryID' => $val,
                    'minWeight' => $arrPost['minWeight'][$key],
                    'maxWeight' => $arrPost['maxWeight'][$key],
                    'shippingPrice' => $arrPost['price'][$key],
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
     * function editShippingGateway
     *
     * This function is used to edit the shipping Gateway.
     *
     * Database Tables used in this function are : tbl_shipping_gateways_pricelist
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objShippingGateway->editShippingGateway($argSID, $argMID = 0)
     */
    function editShippingGateway($argSID, $argMID = 0) {
        $varWhrWeightPrice = "fkShippingGatewaysID =" . $argSID . " AND fkShippingPortalID = " . $argMID . ""
                . " AND currentDate = ( SELECT max(currentDate) FROM " . TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ""
                . " as NewTbl WHERE fkShippingGatewaysID =" . $argSID . " AND fkShippingPortalID = " . $argMID . ""
                . "  AND tbl_shipping_gateways_new_pricelist.fkShippingCountryID=NewTbl.fkShippingCountryID "
                . " AND tbl_shipping_gateways_new_pricelist.minWeight=NewTbl.minWeight "
                . "AND tbl_shipping_gateways_new_pricelist.maxWeight=NewTbl.maxWeight" . ")";
        $table = TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ' LEFT JOIN tbl_admin ON pkAdminID = fkShippingPortalID '
                . ' LEFT JOIN tbl_ship_gateways ON pkShippingGatewaysID = fkShippingGatewaysID '
                . ' LEFT JOIN tbl_country ON fkShippingCountryID = country_id '
                . '  ';
        $arrClmsWeightPrice = array(
            'pkShippingPriceID',
            'fkShippingGatewaysID',
            'fkShippingPortalID',
            'fkShippingCountryID',
            'minWeight',
            'maxWeight',
            'shippingPrice',
            'AdminUserName',
            'ShippingTitle',
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

    function editShippingGatewayOldEntry($argSID, $argMID = 0) {
        
        
        $varWhrWeightPrice = "fkShippingGatewaysID =" . $argSID . " AND fkShippingPortalID = " . $argMID . ""
                . " AND currentDate = ( SELECT max(currentDate) FROM " . TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ""
                . " as NewTbl WHERE fkShippingGatewaysID =" . $argSID . " AND fkShippingPortalID = " . $argMID . ""
                . "  AND tbl_shipping_gateways_new_pricelist.fkShippingCountryID=NewTbl.fkShippingCountryID "
                . " AND tbl_shipping_gateways_new_pricelist.minWeight=NewTbl.minWeight "
                . "AND tbl_shipping_gateways_new_pricelist.maxWeight=NewTbl.maxWeight" . " AND currentDate <= CURDATE() group by currentDate order by currentDate desc limit 1 )";
        $table = TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ' LEFT JOIN tbl_admin ON pkAdminID = fkShippingPortalID '
                . ' LEFT JOIN tbl_ship_gateways ON pkShippingGatewaysID = fkShippingGatewaysID '
                . ' LEFT JOIN tbl_country ON fkShippingCountryID = country_id '
                . '  ';
        $arrClmsWeightPrice = array(
            'pkShippingPriceID',
            'fkShippingGatewaysID',
            'fkShippingPortalID',
            'fkShippingCountryID',
            'minWeight',
            'maxWeight',
            'shippingPrice',
            'AdminUserName',
            'ShippingTitle',
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

    function getcountryShippingByID($argSID, $argMID = 0) {

//        echo $argSID. $argMID;die;
        $varQuery = "SELECT fkShippingGatewaysID,fkAdminID,fkcountry_id,name
            FROM " . TABLE_SHIP_COUNTRY . " LEFT JOIN " . TABLE_SHIP_MULTIPLECOUNTRY . " ON pkshipcountryid = fkshipcountryid 
            		LEFT JOIN tbl_country ON fkcountry_id = country_id";
        $argWhere = "fkShippingGatewaysID =" . $argSID . " AND fkAdminID = " . $argMID . "";
//        $argWhere = "fkShippingGatewaysID =" . $argSID . "";
        if ($argWhere <> '') {
            $varQuery .= " WHERE " . $argWhere;
        }

        //$varQuery .= " GROUP BY(pkShippingGatewaysID) DESC ";
        if ($argLimit <> '') {
            $varQuery .= " LIMIT " . $argLimit;
        }

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function updateShippingGateway
     *
     * This function is used to update the shipping Gateway.
     *
     * Database Tables used in this function are : tbl_shipping_gateways_pricelist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return 1
     *
     * User instruction: $objShippingGateway->updateShippingGateway($arrPost)
     */
    function updateShippingGateway($arrPost) {
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
//        $varWheresD = "fkShippingGatewaysID = " . $arrPost['sgid'] . " AND  fkShippingPortalID=" . $arrPost['smid'] . " AND DATE(currentDate) = '" . $date . "'";
//        
//        $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWheresD);
        //pre($pre);
//        pre($arrPost);
        //$date = date('Y-m-d');
        $arrAddID = 0;
        foreach ($arrPost['frmShippingMultiCountryID'] as $key => $val) {
            if (!empty($arrPost['minWeight'][$key]) || !empty($arrPost['maxWeight'][$key]) || !empty($arrPost['price'][$key])) {

                /* First Delete duplicate entry */
                $startDate = time();
                $dateTommorow = date('Y-m-d', strtotime('+1 day', $startDate));
                $date = date('Y-m-d');



//                $ExistingarrRes = $this->getArrayResult($varQuery);
//                pre($ExistingarrRes[0]['pkShippingPriceID']);
//                if($key == 1)
//                pre($varQuery);
//                $varWheresD11 = "fkShippingGatewaysID = " . $arrPost['sgid'] . " "
//                        . " AND  fkShippingPortalID=" . $arrPost['smid'] . ""
//                        . " AND  fkShippingCountryID=" . $val . ""
////                        ." AND  shippingPrice=" . $arrPost['price'][$key] . ""
//                        . " AND (DATE(currentDate) = '" . $date . "'"
//                        . " OR DATE(currentDate) = '" . $dateTommorow . "')";
//                $varWheresD = "pkShippingPriceID = '" . $ExistingarrRes[0]['pkShippingPriceID'] . "'";
//                //pre($varWheresD);
////                $DeleteVar = $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWheresD11);
//                $DeleteVar = $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWheresD);
                if (!isset($arrPost['pkShippingPriceID'][$key])) {
                    $arrClms = array(
                        'fkShippingGatewaysID' => $arrPost['sgid'],
                        'fkShippingPortalID' => $arrPost['smid'],
                        'fkShippingCountryID' => $val,
                        'minWeight' => $arrPost['minWeight'][$key],
                        'maxWeight' => $arrPost['maxWeight'][$key],
                        'shippingPrice' => $arrPost['price'][$key],
                        'currentDate' => $date,
                    );
                    $num = $this->insert(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $arrClms);
                } else {

                    $varQuery = "SELECT * FROM " . TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ""
                            . " WHERE fkShippingGatewaysID = " . $arrPost['sgid'] . ""
                            . " AND  pkShippingPriceID=" . $arrPost['pkShippingPriceID'][$key] . ""
                            . " AND  fkShippingPortalID=" . $arrPost['smid'] . ""
                            . " AND  minWeight=" . $arrPost['minWeight'][$key] . ""
                            . " AND  maxWeight=" . $arrPost['maxWeight'][$key] . ""
                            . " AND  shippingPrice=" . $arrPost['price'][$key] . ""
                            . " AND  fkShippingCountryID=" . $val . "";
                    $ExistingarrRes = $this->getArrayResult($varQuery);

                    if (count($ExistingarrRes))
                        continue;

                    $varQuery123 = "SELECT * FROM " . TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST . ""
                            . " WHERE fkShippingGatewaysID = " . $arrPost['sgid'] . ""
                            . " AND  pkShippingPriceID=" . $arrPost['pkShippingPriceID'][$key] . ""
                            . " AND  fkShippingPortalID=" . $arrPost['smid'] . ""
                            . " AND  minWeight=" . $arrPost['minWeight'][$key] . ""
                            . " AND  maxWeight=" . $arrPost['maxWeight'][$key] . ""
                            . " AND  shippingPrice=" . $arrPost['price'][$key] . ""
                            . " AND  fkShippingCountryID=" . $val . ""
                            . " AND  currentDate>=" . $date . "";
                    $ExistingarrRes = $this->getArrayResult($varQuery123);

                    if (!empty($ExistingarrRes)) {
                        $arrClms = array(
                            'fkShippingGatewaysID' => $arrPost['sgid'],
                            'fkShippingPortalID' => $arrPost['smid'],
                            'fkShippingCountryID' => $val,
                            'minWeight' => $arrPost['minWeight'][$key],
                            'maxWeight' => $arrPost['maxWeight'][$key],
                            'shippingPrice' => $arrPost['price'][$key],
                            'currentDate' => $dateTommorow,
                        );

                        $varWhr = 'pkShippingPriceID = ' . $arrPost['pkShippingPriceID'][$key];
                        $arrAddID = $this->update(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $arrClms, $varWhr);
                    } else {

                        $arrClms = array(
                            'fkShippingGatewaysID' => $arrPost['sgid'],
                            'fkShippingPortalID' => $arrPost['smid'],
                            'fkShippingCountryID' => $val,
                            'minWeight' => $arrPost['minWeight'][$key],
                            'maxWeight' => $arrPost['maxWeight'][$key],
                            'shippingPrice' => $arrPost['price'][$key],
                            'currentDate' => $dateTommorow,
                        );
                        $arrAddID = $this->insert(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $arrClms);
                    }
                }
//                if (empty($ExistingarrRes)) {
//                    
//                    $arrClms = array(
//                        'fkShippingGatewaysID' => $arrPost['sgid'],
//                        'fkShippingPortalID' => $arrPost['smid'],
//                        'fkShippingCountryID' => $val,
//                        'minWeight' => $arrPost['minWeight'][$key],
//                        'maxWeight' => $arrPost['maxWeight'][$key],
//                        'shippingPrice' => $arrPost['price'][$key],
//                        'currentDate' => $date,
//                    );
//                    
//                } else {
//
//                    $arrClms = array(
//                        'fkShippingGatewaysID' => $arrPost['sgid'],
//                        'fkShippingPortalID' => $arrPost['smid'],
//                        'fkShippingCountryID' => $val,
//                        'minWeight' => $arrPost['minWeight'][$key],
//                        'maxWeight' => $arrPost['maxWeight'][$key],
//                        'shippingPrice' => $arrPost['price'][$key],
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

//            $DQuery = "DELETE FROM tbl_shipping_gateways_new_pricelistWHERE pkShippingPriceID IN
//        (
//        SELECT * FROM ( SELECT pkShippingPriceID FROM `tbl_shipping_gateways_new_pricelist` 
//        WHERE `fkShippingGatewaysID` = '". $_REQUEST['GateID'] ."' 
//        AND `fkShippingPortalID` = '". $_REQUEST['PortalID'] ."' 
//        AND `fkShippingCountryID` = '". $_REQUEST['CountryID'] ."' 
//        AND `minWeight` = '". $_REQUEST['MinWg'] ."' AND `maxWeight` = '". $_REQUEST['MaxWg'] ."' 
//        ORDER BY `currentDate` ) a ) and `fkShippingGatewaysID` = '". $_REQUEST['GateID'] ."' 
//        AND `fkShippingPortalID` = '". $_REQUEST['PortalID'] ."' 
//        AND `fkShippingCountryID` = '". $_REQUEST['CountryID'] ."' 
//        AND `minWeight` = '". $_REQUEST['MinWg'] ."' AND `maxWeight` = '". $_REQUEST['MaxWg'] ."'";

            $varWhereAllD = "`fkShippingGatewaysID` = '" . $_REQUEST['GateID'] . "' 
                                AND `fkShippingPortalID` = '" . $_REQUEST['PortalID'] . "' 
                                AND `fkShippingCountryID` = '" . $_REQUEST['CountryID'] . "' 
                                AND `minWeight` = '" . $_REQUEST['MinWg'] . "' AND `maxWeight` = '" . $_REQUEST['MaxWg'] . "'";

//            $varWhereAllD = "pkShippingPriceID = '" . $argPostIDs . "'";
            $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWhereAllD);
        }
        return true;
    }
    
    function DeleteShipGatewayRow($argPostIDs) {


        if (isset($argPostIDs) && ($argPostIDs > 0)) {

            $varWhereAllD = "pkID = " . $_REQUEST['gatwayID'] . "";

//            $varWhereAllD = "pkShippingPriceID = '" . $argPostIDs . "'";
            $this->delete(TABLE_GATEWAYS_PORTAL, $varWhereAllD);
        }
        return true;
    }

    /**
     * function updateShippingGatewayStatus
     *
     * This function is used to update the shipping Gateway status.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objShippingGateway->updateShippingGatewayStatus($arrPost)
     */
    function updateShippingGatewayStatus($arrPost) {
        $varWhr = 'pkShippingGatewaysID = ' . $arrPost['sgid'];
        $arrClms = array('ShippingStatus' => $arrPost['status']);
        $arrUpdateID = $this->update(TABLE_SHIP_GATEWAYS, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function removeShippingGateway
     *
     * This function is used to remove the shipping Gateway.
     *
     * Database Tables used in this function are : tbl_shipping_gateways_pricelist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objShippingGateway->removeShippingGateway($argPostIDs)
     */
    function removeShippingGateway($argPostIDs) {


        if (isset($argPostIDs['deleteType']) && $argPostIDs['deleteType'] == 'sD') {

            $varWhereAllD = "fkShippingGatewaysID = '" . $argPostIDs['frmID'] . "' AND fkShippingPortalID='" . $argPostIDs['PortalID'] . "'";
            $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWhereAllD);
        } else {
            $ctr = 0;
            foreach ($argPostIDs['frmID'] as $varDeleteID) {
                $varWhereAllD = "fkShippingMethodID='" . $varDeleteID . "'";
                $this->delete(TABLE_SHIPPING_GATEWAYS_PRICELIST, $varWhereAllD);
            }
        }

        return true;
    }

    /**
     * function shippingMethodList
     *
     * This function is used to retrive admin user List.
     *
     * Database Tables used in this function are : tbl_shipping_method, tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 2 $string(optional), $string(optional)
     *
     * @return array $arrRes
     */
    function shippingMethodList($argWhere = '', $argLimit = '') {
        $arrClms = array(
            'pkShippingGatewaysID',
        );
        $varOrderBy = "";
        //pre($argWhere);
        $varTable = TABLE_SHIP_GATEWAYS;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    function shippingCountryPortalList($argWhere = '', $argLimit = '') {

        $arrClms = array(
            'pkShippingGatewaysID',
        );
        $varOrderBy = "";
        $varQuery = "SELECT * FROM tbl_ship_gateways LEFT JOIN tbl_gateway_portal ON fkgatewayID = pkShippingGatewaysID WHERE " . $argWhere;
        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }

    function shippingCountryAllowedList($argWhere = '', $argLimit = '') {

        $arrClms = array(
            'pkShippingGatewaysID',
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
     * This function is used to insert Shipping Method.
     *
     * Database Tables used in this function are : tbl_shipping_method
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrAddID
     */
    function addShippingMethod($arrPost) {
        global $objCore;
        $varWhere = "MethodCode='" . $arrPost['frmMethodCode'] . "' ";
        $arrMethod = $this->shippingMethodList($varWhere);
        if (count($arrMethod) == 0) {
            $arrClms = array(
                'fkShippingGatewayID' => $arrPost['frmfkShippingGatewayID'],
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
     * function getShippingMethodByID
     *
     * This function is used to get Shipping Method.
     *
     * Database Tables used in this function are : tbl_shipping_method
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrRes
     */
    function getShippingMethodByID($argID) {
        $varWhr = "pkShippingMethod ='" . $argID . "' ";
        $arrClms = array('pkShippingMethod', 'fkShippingGatewayID', 'MethodName', 'MethodCode', 'MethodDescription');
        $arrRes = $this->select(TABLE_SHIPPING_METHOD, $arrClms, $varWhr);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function updateShippingMethod
     *
     * This function is used to insert Shipping Method.
     *
     * Database Tables used in this function are : tbl_shipping_method
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrUpdateID
     */
    function updateShippingMethod($arrPost) {
        $varWhere = "MethodCode='" . $arrPost['frmMethodCode'] . "' AND  pkShippingMethod != '" . $_GET['smid'] . "' ";
        $arrMethod = $this->shippingMethodList($varWhere);
        if (count($arrMethod) == 0) {
            $arrClms = array(
                'fkShippingGatewayID' => $arrPost['frmfkShippingGatewayID'],
                'MethodName' => $arrPost['frmMethodName'],
                'MethodCode' => $arrPost['frmMethodCode'],
                'MethodDescription' => $arrPost['frmMethodDescription']
            );

            $varWhr = "pkShippingMethod = '" . $_GET['smid'] . "' ";
            $arrUpdateID = $this->update(TABLE_SHIPPING_METHOD, $arrClms, $varWhr);

            return $arrUpdateID;
        } else {
            return 'exist';
        }
    }

    /**
     * function removeShippingMethod
     *
     * This function is used to remove the shipping method.
     *
     * Database Tables used in this function are : tbl_shipping_method
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objShippingGateway->removeShippingMethod($argPostIDs)
     */
    function removeShippingMethod($argPostIDs) {
        $varWhereAllD = "pkShippingMethod = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_SHIPPING_METHOD, $varWhereAllD);
        return true;
    }

    /**
     * function shippingList
     *
     * This function is used to retrive shipping List.
     *
     * Database Tables used in this function are : tbl_shipping_method, tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 2 $string(optional), $string(optional)
     *
     * @return array $arrRes
     */
    function shippingList($argWhere = '', $argLimit = '') {
        $varQuery = "SELECT pkShippingGatewaysID, ShippingType,ShippingStatus, ShippingTitle, ShippingAlias
            FROM " . TABLE_SHIP_GATEWAYS . '';

        if ($argWhere <> '') {
            $varQuery .= " WHERE " . $argWhere;
        }

        $varQuery .= " GROUP BY(pkShippingGatewaysID) DESC ORDER BY ShippingType ASC";
        if ($argLimit <> '') {
            $varQuery .= " LIMIT " . $argLimit;
        }

        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
    }

    /**
     * function addShipping
     *
     * This function is used to insert Shipping.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrAddID
     */
    function addShipping($arrPost) {
        //pre($arrPost);
        global $objCore;
        $varWhere = "ShippingTitle='" . $arrPost['frmShippingName'] . "' ";
        $arrMethod = $this->shippingList($varWhere);

//        $ApiGateways = array('fedex','UPS','USPS');
//        if(in_array($arrPost['frmShippingName'], $ApiGateways) ){
//            return 'exist';
//        }
        //pre($arrMethod);
        if (count($arrMethod) == 0) {
            $arrClms = array(
                'ShippingType' => 'admin',
                'ShippingTitle' => $arrPost['frmShippingName'],
                'ShippingStatus' => $arrPost['frmStatus'],
                'ShippingAlias' => $arrPost['frmShippingName'],
                'ShippingDescription' => $arrPost['frmShippingDescription'],
                'ShippingDateAdded' => $objCore->serverDateTime(date(DATE_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $arrAddID = $this->insert(TABLE_SHIP_GATEWAYS, $arrClms);
            //pre($arrAddID);
            if (!empty($arrAddID)) {
                foreach ($arrPost['AdminUserName'] as $ket => $val) {
                    $combineValue = array(
                        'fkgatewayID' => $arrAddID,
                        'fkportalID' => $val,
                        'gatewayEmail' => $arrPost['gatewayEmail'][$ket],
                    );
                    $this->insert(TABLE_GATEWAYS_PORTAL, $combineValue);
                }
            }
//            Start previous cade
            $arrClmsUpdate = array('id' => $arrAddID, 'name' => $arrPost['frmShippingName'], 'action' => 'add', 'type' => 'shipping');
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

                    $varWhereTemplate = " EmailTemplateTitle= 'New Shipping gateway has been added' AND EmailTemplateStatus = 'Active' ";

                    $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                    $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                    $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                    $varPathImage = '';
                    $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                    $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                    $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                    $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $arrPost['frmShippingName']);

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

    function addShipping11($arrPost) {
        global $objCore;
        $varWhere = "ShippingAlias='" . $arrPost['frmShippingCode'] . "' ";
        $arrMethod = $this->shippingList($varWhere);
        if (count($arrMethod) == 0) {
            $arrClms = array(
                'ShippingType' => 'admin',
                'ShippingTitle' => $arrPost['frmShippingName'],
                'ShippingAlias' => $arrPost['frmShippingCode'],
                'ShippingStatus' => $arrPost['frmStatus'],
                'ShippingDateAdded' => $objCore->serverDateTime(date(DATE_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $arrAddID = $this->insert(TABLE_SHIPPING_GATEWAYS, $arrClms);

            $arrClmsUpdate = array('id' => $arrAddID, 'name' => $arrPost['frmShippingName'], 'action' => 'add', 'type' => 'shipping');
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

                    $varWhereTemplate = " EmailTemplateTitle= 'New Shipping gateway has been added' AND EmailTemplateStatus = 'Active' ";

                    $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                    $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                    $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                    $varPathImage = '';
                    $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                    $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                    $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                    $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $arrPost['frmShippingName']);

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
     * function getShippingByID
     *
     * This function is used to get Shipping.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrRes
     */
    function getShippingByID($argID) {
        $varWhr = "pkShippingGatewaysID ='" . $argID . "' AND ShippingType='admin'";
        $arrClms = array('pkShippingGatewaysID', 'ShippingTitle', 'ShippingAlias', 'ShippingStatus', 'ShippingDescription');
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
     * function updateShipping
     *
     * This function is used to insert Shipping.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters array $string
     *
     * @return string $arrUpdateID
     */
    function updateShipping($arrPost) {

//        $ApiGateways = array('fedex','UPS','USPS');
//        if(in_array($arrPost['frmShippingName'], $ApiGateways) ){
//            return 'exist';
//        }
        $varWhere = "ShippingTitle='" . $arrPost['frmShippingName'] . "' AND  pkShippingGatewaysID != '" . $_GET['smid'] . "' ";
        $arrMethod = $this->shippingMethodList($varWhere);
        //pre($arrPost);
        if (empty($arrMethod)) {

            $arrClms = array(
                'ShippingTitle' => $arrPost['frmShippingName'],
                'ShippingAlias' => $arrPost['frmShippingName'],
                'ShippingStatus' => $arrPost['frmStatus'],
                'ShippingDescription' => $arrPost['frmShippingDescription'],
            );

            $varWhr = "pkShippingGatewaysID = '" . $_GET['smid'] . "' ";
            //print_r($arrClms);
            $arrUpdateID = $this->update(TABLE_SHIP_GATEWAYS, $arrClms, $varWhr);
            //pre($arrUpdateID);

            $varWhereAllD = "fkgatewayID='" . $_GET['smid'] . "'";
            $this->delete(TABLE_GATEWAYS_PORTAL, $varWhereAllD);

            foreach ($arrPost['AdminUserName'] as $ket => $val) {
                if ((!empty($val)) && (!empty($arrPost['gatewayEmail'][$ket]))) {
                    $combineValue = array(
                        'fkgatewayID' => $_GET['smid'],
                        'fkportalID' => $val,
                        'gatewayEmail' => $arrPost['gatewayEmail'][$ket],
                    );
                    $arrInsertID = $this->insert(TABLE_GATEWAYS_PORTAL, $combineValue);
                }
            }


            $arrClmsUpdate = array('id' => $_GET['smid'], 'name' => $arrPost['frmShippingName'], 'action' => 'edit', 'type' => 'shipping');
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

                    $varWhereTemplate = " EmailTemplateTitle= 'Shipping gateway has been updated' AND EmailTemplateStatus = 'Active' ";

                    $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                    $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                    $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                    $varPathImage = '';
                    $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                    $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                    $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                    $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $arrPost['frmShippingName']);

                    $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                    // Calling mail function

                    $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                }
            }

            if ((isset($arrInsertID)) || (isset($arrUpdateID))) {
                return true;
            }
        } else {
            return 'exist';
        }
    }

    /**
     * function removeShipping
     *
     * This function is used to remove the shipping.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objShippingGateway->removeShipping($argPostIDs)
     */
    function removeShipping($argPostIDs) {
        $varWhereAllD = "pkShippingGatewaysID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_SHIP_GATEWAYS, $varWhereAllD);

        $varWhereAllD = "fkgatewayID='" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_GATEWAYS_PORTAL, $varWhereAllD);

        $arrClmsUpdate = array('id' => $argPostIDs['frmID'], 'name' => $argPostIDs['shipName'], 'action' => 'delete', 'type' => 'shipping');
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

                $varWhereTemplate = " EmailTemplateTitle= 'Shipping gateway has been deleted' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '';
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $arrPost['frmShippingName']);

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
     * This function is used to remove the shipping.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 0
     *
     * @return true
     *
     * User instruction: $objShippingGateway->getZoneCountry()
     */
    function getZoneCountry() {

        $varQuery = "SELECT zone,group_concat(' ',name) as Countries FROM " . TABLE_COUNTRY . " WHERE status='1' AND zone!='' GROUP BY(zone) ASC";

        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }

}

?>