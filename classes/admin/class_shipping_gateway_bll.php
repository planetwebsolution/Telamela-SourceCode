<?php

/**
 *
 * Class name : ShippingGateway
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The ShippingGateway class is used to maintain ShippingGateway infomation details for several modules.
 */
class ShippingGateway extends Database {

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
        $arrRes = $this->select(TABLE_SHIPPING_GATEWAYS, $arrClms, $argWhere, $varOrderBy, $argLimit);
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
        $varClms = "fkShippingGatewaysID,fkShippingMethodID,ShippingType,ShippingTitle,ShippingStatus,MethodName,MethodCode";
        $varTable = TABLE_SHIPPING_GATEWAYS_PRICELIST . " LEFT JOIN " . TABLE_SHIPPING_GATEWAYS . " ON fkShippingGatewaysID = pkShippingGatewaysID LEFT JOIN " . TABLE_SHIPPING_METHOD . " ON fkShippingMethodID = pkShippingMethod";
        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";
        $varOrderBy = "GROUP BY fkShippingMethodID ORDER BY ShippingType ASC,ShippingTitle ASC";

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

        $arrAddID = 0;
        foreach ($arrPost['frmWeight'] as $key => $val) {
            $arrClms = array(
                'fkShippingGatewaysID' => $arrPost['frmShippingGatewayID'],
                'fkShippingMethodID' => $arrPost['frmShippingMethodID'],
                'Weight' => $val,
                'ZoneA' => $arrPost['frmA'][$key],
                'ZoneB' => $arrPost['frmB'][$key],
                'ZoneC' => $arrPost['frmC'][$key],
                'ZoneD' => $arrPost['frmD'][$key],
                'ZoneE' => $arrPost['frmE'][$key],
                'ZoneF' => $arrPost['frmF'][$key],
                'ZoneG' => $arrPost['frmG'][$key],
                'ZoneH' => $arrPost['frmH'][$key],
                'ZoneI' => $arrPost['frmI'][$key],
                'ZoneJ' => $arrPost['frmJ'][$key],
                'ZoneK' => $arrPost['frmK'][$key]
            );
            $num = $this->insert(TABLE_SHIPPING_GATEWAYS_PRICELIST, $arrClms);
            $arrAddID += $num;
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
        $varWhrWeightPrice = "fkShippingGatewaysID ='" . $argSID . "' AND fkShippingMethodID='" . $argMID . "'";

        $arrClmsWeightPrice = array(
            'pkWeightPriceID',
            'fkShippingGatewaysID',
            'fkShippingMethodID',
            'Weight',
            'ZoneA',
            'ZoneB',
            'ZoneC',
            'ZoneD',
            'ZoneE',
            'ZoneF',
            'ZoneG',
            'ZoneH',
            'ZoneI',
            'ZoneJ',
            'ZoneK'
        );
        $arrRes = $this->select(TABLE_SHIPPING_GATEWAYS_PRICELIST, $arrClmsWeightPrice, $varWhrWeightPrice, ' Weight ASC ');
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

        $varWheresD = "fkShippingGatewaysID = '" . $_GET['sgid'] . "' AND  fkShippingMethodID='" . $_GET['smid'] . "'";
        $this->delete(TABLE_SHIPPING_GATEWAYS_PRICELIST, $varWheresD);


        foreach ($arrPost['frmWeight'] as $key => $val) {
            $arrClms = array(
                'fkShippingGatewaysID' => $arrPost['frmShippingGatewayID'],
                'fkShippingMethodID' => $arrPost['frmShippingMethodID'],
                'Weight' => $val,
                'ZoneA' => $arrPost['frmA'][$key],
                'ZoneB' => $arrPost['frmB'][$key],
                'ZoneC' => $arrPost['frmC'][$key],
                'ZoneD' => $arrPost['frmD'][$key],
                'ZoneE' => $arrPost['frmE'][$key],
                'ZoneF' => $arrPost['frmF'][$key],
                'ZoneG' => $arrPost['frmG'][$key],
                'ZoneH' => $arrPost['frmH'][$key],
                'ZoneI' => $arrPost['frmI'][$key],
                'ZoneJ' => $arrPost['frmJ'][$key],
                'ZoneK' => $arrPost['frmK'][$key]
            );
            //pre($arrClms);
            $this->insert(TABLE_SHIPPING_GATEWAYS_PRICELIST, $arrClms);
        }
        return 1;
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
        $arrUpdateID = $this->update(TABLE_SHIPPING_GATEWAYS, $arrClms, $varWhr);
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

            $varWhereAllD = "fkShippingGatewaysID = '" . $argPostIDs['frmID'] . "' AND fkShippingMethodID='" . $argPostIDs['smid'] . "'";
            $this->delete(TABLE_SHIPPING_GATEWAYS_PRICELIST, $varWhereAllD);
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
            'ShippingTitle',
            'ShippingType',
            'pkShippingMethod',
            'MethodName',
            'MethodCode',
            'MethodStatus',
            'fkShippingGatewayID',
            'MethodDescription'
        );
        $varOrderBy = " ShippingType DESC, pkShippingMethod DESC";
        $varTable = TABLE_SHIPPING_METHOD . " LEFT JOIN " . TABLE_SHIPPING_GATEWAYS . " ON fkShippingGatewayID = pkShippingGatewaysID";
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    function shippingMethodName($argWhere = '', $argLimit = '') {
        $arrClms = array(
            'MethodName',
        );
        //$varOrderBy = " ShippingType DESC, pkShippingMethod DESC";
        $varTable = TABLE_SHIPPING_METHOD;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
        //pre($arrRes[0]['MethodName']);
        return $arrRes[0]['MethodName'];
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
        //pre($arrPost);
        global $objCore;
        $varWhere = "MethodName='" . $arrPost['frmMethodName'] . "' ";
        $arrMethod = $this->shippingMethodName($varWhere);
        // pre($arrMethod);
        //if (count($arrMethod) == 0)
        if (empty($arrMethod)) {
            $arrClms = array(
                //'fkShippingGatewayID' => $arrPost['frmfkShippingGatewayID'],
                'MethodName' => $arrPost['frmMethodName'],
                'MethodStatus' => $arrPost['frmStatus'],
                'MethodDescription' => $arrPost['frmMethodDescription'],
                'shippingportal' => $arrPost['shippingportal'],
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
        $arrClms = array('pkShippingMethod', 'fkShippingGatewayID', 'MethodName', 'MethodCode', 'MethodStatus', 'MethodDescription');
        $arrRes = $this->select(TABLE_SHIPPING_METHOD, $arrClms, $varWhr);
        //pre($arrRes);
        return $arrRes;
    }

    function updateshippingmethodsStatus($arrPost) {
        global $objGeneral;
        global $objCore;
        $arrcheckmethod = $objGeneral->checkmethodisusedinzoneprice($arrPost['sgid']);
        //pre($arrcheckmethod);

        if ($arrPost['status'] == 0) {
            if ($arrcheckmethod[0]['shippingmethod'] > 0) {
                // pre("here");
                $arrUpdateID = 'exist';
                return $arrUpdateID;
//         $objCore->setErrorMsg(" This Method is used not Deactivated.");
                die();
            }
        }
        // pre("herekk");
        $varWhr = 'pkShippingMethod = ' . $arrPost['sgid'];
        $arrClms = array('MethodStatus' => $arrPost['status']);
        $arrUpdateID = $this->update(TABLE_SHIPPING_METHOD, $arrClms, $varWhr);
        return true;
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
        global $objGeneral;
        $varWhere = "MethodName='" . $arrPost['frmMethodName'] . "' AND  pkShippingMethod != '" . $_GET['smid'] . "' ";
        $arrMethod = $this->shippingMethodName($varWhere);
        $arrcheckmethod = $objGeneral->checkmethodisusedinzoneprice($_GET['smid']);
        if ($arrcheckmethod[0]['shippingmethod'] > 0) {
            return 'notdeacative';
        }
        if (count($arrMethod) == 0) {
            $arrClms = array(
                // 'fkShippingGatewayID' => $arrPost['frmfkShippingGatewayID'],
                'MethodName' => $arrPost['frmMethodName'],
                'MethodStatus' => $arrPost['frmStatus'],
                'shippingportal' => $arrPost['shippingportal'],
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
        $varQuery = "SELECT pkShippingGatewaysID,ShippingTitle,count(fkShippingGatewayID) as noOfMethods, ShippingAlias, ShippingType,ShippingStatus
            FROM " . TABLE_SHIPPING_GATEWAYS . " LEFT JOIN" . TABLE_SHIPPING_METHOD . " ON pkShippingGatewaysID = fkShippingGatewayID";

        if ($argWhere <> '') {
            $varQuery .= " WHERE " . $argWhere;
        }

        $varQuery .= " GROUP BY(pkShippingGatewaysID) DESC ";
        if ($argLimit <> '') {
            $varQuery .= " LIMIT " . $argLimit;
        }

        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
    }

    function shippingListcountries($argWhere = '', $argLimit = '') {
//     	$varQuery = "SELECT *
//             FROM " . TABLE_SHIP_COUNTRY ;
//     	$varQuery = "SELECT pkShippingGatewaysID,ShippingTitle,count(fkShippingGatewayID) as noOfMethods, ShippingAlias, ShippingType,ShippingStatus
//             FROM " . TABLE_SHIPPING_GATEWAYS . " LEFT JOIN" . TABLE_SHIPPING_METHOD . " ON pkShippingGatewaysID = fkShippingGatewayID";
//    $varQuery = "SELECT fkShippingGatewaysID,AdminUserName,GROUP_CONCAT(name)as country
//             FROM " . TABLE_SHIP_COUNTRY . " LEFT JOIN " . TABLE_ADMIN . " 
//             		ON fkshippingGatewaysid = pkAdminID ". " 
//             				LEFT JOIN " . TABLE_COUNTRY . " 
//             		ON fkcountry_id = country_id ". " LEFT JOIN " 
//             				. TABLE_SHIP_GATEWAYS . " 
//             		ON pkShippingGatewaysID = fkShippingGatewaysID ";
        $varQuery = "SELECT ShippingTitle,pkshipcountryid,AdminUserName,GROUP_CONCAT(name)as country
            FROM " . TABLE_SHIP_COUNTRY . " LEFT JOIN " . TABLE_SHIP_GATEWAYS . "
            		ON fkShippingGatewaysID = pkShippingGatewaysID " . "
            				LEFT JOIN " . TABLE_ADMIN . "
            		ON fkAdminID = pkAdminID " . " LEFT JOIN "
                . TABLE_SHIP_MULTIPLECOUNTRY . "
            		ON pkshipcountryid = fkshipcountryid " . " LEFT JOIN "
                . TABLE_COUNTRY . "
            		ON fkcountry_id = country_id ";

        if ($argWhere <> '') {
            $varQuery .= " WHERE " . $argWhere;
        }

        $varQuery .= " GROUP BY(fkshipcountryid)  ";
        if ($argLimit <> '') {
            $varQuery .= " LIMIT " . $argLimit;
        }

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    function shippingcountryList($argWhere = '', $argLimit = '') {
        $varQuery = "SELECT *
            FROM " . TABLE_SHIP_COUNTRY;

        if ($argWhere <> '') {
            $varQuery .= " WHERE " . $argWhere;
        }

        //$varQuery .= " GROUP BY(fkcountry_id)  ";
        if ($argLimit <> '') {
            $varQuery .= " LIMIT " . $argLimit;
        }

        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
//     	$arrClms = array(
//     			'pkshipcountryid',
//     			'fkShippingGatewaysID',
//     			'fkAdminID',
//     			'fkcountry_id'
//     	);
//     	$varOrderBy = 'pkshipcountryid ASC ';
//     	$arrRes = $this->select(TABLE_SHIP_COUNTRY, $arrClms, $argWhere, $varOrderBy, $argLimit);
//     	//pre($arrRes);
//     	return $arrRes;
    }

    function shippingCountryPortalList($argWhere = '', $argLimit = '') {

        $arrClms = array(
            'pkShippingGatewaysID',
        );
        $varOrderBy = "";
        $varQuery = "SELECT pkShippingGatewaysID,ShippingTitle FROM tbl_ship_gateways LEFT JOIN tbl_gateway_portal ON fkgatewayID = pkShippingGatewaysID WHERE " . $argWhere;
        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
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
        //pre($arrMethod);
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

    function addShippingcountries($arrPost) {
//        pre($arrPost);
        global $objCore;
//     	$varWhere = "ShippingTitle='" . $arrPost['frmShippingName'] . "' ";
//     	$arrMethod = $this->shippingList($varWhere);
//     	//pre($arrMethod);
        $varQuery = " SELECT * FROM " . TABLE_SHIP_COUNTRY . " WHERE fkShippingGatewaysID = " . $arrPost['countriesgatway'] .
                " AND fkAdminID = " . $arrPost['countriesportal'] . "";

        $arrRes = $this->getArrayResult($varQuery);
        if (!empty($arrRes)) {
            return 'exist';
        }
        if (!empty($arrPost['name'])) {


            //pre($arrPost);
//            foreach ($arrPost['name'] as $k => $v) {
//                $varQuery = " SELECT name,pkshipcountryid,fkShippingGatewaysID,fkAdminID,pkmulid,fkshipcountryid,fkcountry_id"
//                        . " FROM " . TABLE_SHIP_COUNTRY .
//                        " LEFT JOIN " . TABLE_SHIP_MULTIPLECOUNTRY . 
//                        " ON pkshipcountryid = fkshipcountryid LEFT JOIN " . TABLE_COUNTRY . 
//                        " ON fkcountry_id = country_id" .
//                        " WHERE fkShippingGatewaysID = " . $arrPost['countriesgatway'] . " AND fkcountry_id = " . $v . "" ;
//                
//                $arrRes = $this->getArrayResult($varQuery);
//
//                //print_r($arrRes);
//                //echo '<br>';
//                if (!empty($arrRes)) {
////                    pre($arrRes);
//                    return $arrRes;
//                }
//            }
            //pre();

            $arrClms = array(
                'fkShippingGatewaysID' => $arrPost['countriesgatway'],
                'fkAdminID' => $arrPost['countriesportal'],
            );

            $arrAddID1 = $this->insert(TABLE_SHIP_COUNTRY, $arrClms);

            foreach ($arrPost['name'] as $val) {
                $arrClms = array(
                    'fkshipcountryid' => $arrAddID1,
                    'fkcountry_id' => $val,
                );

                $arrAddID = $this->insert(TABLE_SHIP_MULTIPLECOUNTRY, $arrClms);
            }


//    countriesportal 		$arrClmsUpdate = array('id' => $arrAddID,'name'=>$arrPost['frmShippingName'],'action' => 'add','type' => 'shipping');
//     		$arrClmsUpdateReturn=$this->insert(TABLE_UPDATE_CATEGORY_ATTR_SHIPPING, $arrClmsUpdate);
//     		$sendUpdateToWholesaler =array('pkWholesalerID','CompanyEmail','CompanyName');
//     		$whrereSendUpdateToWholesaler="WholesalerAPIKey<>''";
//     		$sendUpdateToWholesalerReturn = $this->select(TABLE_WHOLESALER,$sendUpdateToWholesaler,$whrereSendUpdateToWholesaler);
//     		if(count($sendUpdateToWholesalerReturn)>0){
//     			foreach($sendUpdateToWholesalerReturn as $key=>$whlMail){
//     				$objTemplate = new EmailTemplate();
//     				$objCore = new Core();
//     				$varUserName = trim(strip_tags($whlMail['CompanyName']));
//     				$varPassword = trim(strip_tags($arrPost['frmPassword']));
//     				//pre($varUserName);
//     				$varToUser = $whlMail['CompanyEmail'];//'raju.khatak@mail.vinove.com';
//     				$varFromUser = $_SESSION['sessAdminEmail'];
//     				$varSiteName = SITE_NAME;
//     				$varWhereTemplate = " EmailTemplateTitle= 'New Shipping gateway has been added' AND EmailTemplateStatus = 'Active' ";
//     				$arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
//     				$varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
//     				$varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));
//     				$varPathImage = '';
//     				$varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
//     				$varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));
//     				$varKeyword = array('{IMAGE_PATH}','{SITE_NAME}', '{NAME}', '{SITE_NAME}','{CATEGORY_NAME}');
//     				$varKeywordValues = array($varPathImage,SITE_NAME, $varUserName, SITE_NAME,$arrPost['frmShippingName']);
//     				$varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
//     				// Calling mail function
//     				$objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
//     			}
//     		}

            return $arrAddID;
        } else {
            return 'exist';
        }
    }

    function updateShippingcountries($arrPost) {
        //pre($arrPost);
        global $objCore;
        //     	$varWhere = "ShippingTitle='" . $arrPost['frmShippingName'] . "' ";
        //     	$arrMethod = $this->shippingList($varWhere);
        //      pre($arrPost);

        $varQuery = " SELECT * FROM " . TABLE_SHIP_COUNTRY . " WHERE fkShippingGatewaysID = " . $arrPost['countriesgatway'] .
                " AND fkAdminID = " . $arrPost['countriesportal'] . " AND pkshipcountryid != " . $arrPost['PkEditId'] . "";
        $arrRes = $this->getArrayResult($varQuery);
        if (!empty($arrRes)) {
            return 'exist';
        }

        if (!empty($arrPost['name'])) {

//            foreach ($arrPost['name'] as $k => $v) {
//                $varQuery = " SELECT name,pkshipcountryid,fkShippingGatewaysID,fkAdminID,pkmulid,fkshipcountryid,fkcountry_id"
//                        . " FROM " . TABLE_SHIP_COUNTRY .
//                        " LEFT JOIN " . TABLE_SHIP_MULTIPLECOUNTRY . 
//                        " ON pkshipcountryid = fkshipcountryid LEFT JOIN " . TABLE_COUNTRY . 
//                        " ON fkcountry_id = country_id" .
//                        " WHERE fkShippingGatewaysID = " . $arrPost['countriesgatway'] . " AND fkcountry_id = " . $v . " AND pkshipcountryid != " . $arrPost['PkEditId'] . "" ;
//                
//                $arrRes = $this->getArrayResult($varQuery);
//
//                if (!empty($arrRes)) {
//                    return $arrRes;
//                }
//            }

            $varWhereAllD = "pkshipcountryid = '" . $_GET['smid'] . "'";
            $this->delete(TABLE_SHIP_COUNTRY, $varWhereAllD);

            $ForIn = join(', ', $arrPost['name']);


            $varWhereAllDPrice = "fkShippingGatewaysID = '" . $arrPost['countriesgatway'] . "' AND fkShippingPortalID = '" . $arrPost['countriesportal'] . "'  AND fkShippingCountryID NOT IN($ForIn)";
            //pre($varWhereAllDPrice);
            $this->delete(TABLE_SHIPPING_GATEWAYS_NEW_PRICELIST, $varWhereAllDPrice);



//
            $arrClms = array(
                'fkShippingGatewaysID' => $arrPost['countriesgatway'],
                'fkAdminID' => $arrPost['countriesportal'],
            );

            $arrAddID1 = $this->insert(TABLE_SHIP_COUNTRY, $arrClms);
            $varWhereAllD = "fkshipcountryid = '" . $_GET['smid'] . "'";
            $this->delete(TABLE_SHIP_MULTIPLECOUNTRY, $varWhereAllD);
            foreach ($arrPost['name'] as $val) {
                $arrClms = array(
                    'fkshipcountryid' => $arrAddID1,
                    'fkcountry_id' => $val,
                );

                $arrAddID = $this->insert(TABLE_SHIP_MULTIPLECOUNTRY, $arrClms);
            }


            //    countriesportal 		$arrClmsUpdate = array('id' => $arrAddID,'name'=>$arrPost['frmShippingName'],'action' => 'add','type' => 'shipping');
            //     		$arrClmsUpdateReturn=$this->insert(TABLE_UPDATE_CATEGORY_ATTR_SHIPPING, $arrClmsUpdate);
            //     		$sendUpdateToWholesaler =array('pkWholesalerID','CompanyEmail','CompanyName');
            //     		$whrereSendUpdateToWholesaler="WholesalerAPIKey<>''";
            //     		$sendUpdateToWholesalerReturn = $this->select(TABLE_WHOLESALER,$sendUpdateToWholesaler,$whrereSendUpdateToWholesaler);
            //     		if(count($sendUpdateToWholesalerReturn)>0){
            //     			foreach($sendUpdateToWholesalerReturn as $key=>$whlMail){
            //     				$objTemplate = new EmailTemplate();
            //     				$objCore = new Core();
            //     				$varUserName = trim(strip_tags($whlMail['CompanyName']));
            //     				$varPassword = trim(strip_tags($arrPost['frmPassword']));
            //     				//pre($varUserName);
            //     				$varToUser = $whlMail['CompanyEmail'];//'raju.khatak@mail.vinove.com';
            //     				$varFromUser = $_SESSION['sessAdminEmail'];
            //     				$varSiteName = SITE_NAME;
            //     				$varWhereTemplate = " EmailTemplateTitle= 'New Shipping gateway has been added' AND EmailTemplateStatus = 'Active' ";
            //     				$arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
            //     				$varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
            //     				$varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));
            //     				$varPathImage = '';
            //     				$varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
            //     				$varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));
            //     				$varKeyword = array('{IMAGE_PATH}','{SITE_NAME}', '{NAME}', '{SITE_NAME}','{CATEGORY_NAME}');
            //     				$varKeywordValues = array($varPathImage,SITE_NAME, $varUserName, SITE_NAME,$arrPost['frmShippingName']);
            //     				$varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
            //     				// Calling mail function
            //     				$objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
            //     			}
            //     		}

            return $arrAddID;
        } else {
            return 'exist';
        }
    }

    function removeShippingcountries($argPostIDs) {
        $varWhereAllD = "pkshipcountryid = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_SHIP_COUNTRY, $varWhereAllD);

        $varWhereAllD1 = "fkshipcountryid = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_SHIP_MULTIPLECOUNTRY, $varWhereAllD1);
//     	$varWhereAllD = "pkShippingMethod = '" . $argPostIDs['frmID'] . "'";
//     	$this->delete(TABLE_SHIPPING_METHOD, $varWhereAllD);
        return true;
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
        $arrClms = array('pkShippingGatewaysID', 'ShippingTitle', 'ShippingAlias', 'ShippingStatus');
        $arrRes = $this->select(TABLE_SHIPPING_GATEWAYS, $arrClms, $varWhr);
        //pre($arrRes);
        return $arrRes;
    }

    function getcountryShippingByIDNew($argID) {
        $varQuery = "SELECT fkShippingGatewaysID,fkAdminID,fkcountry_id
             FROM " . TABLE_SHIP_COUNTRY . " LEFT JOIN " . TABLE_SHIP_MULTIPLECOUNTRY . " ON pkshipcountryid = fkshipcountryid";
        $argWhere = "pkshipcountryid ='" . $argID . "'";
        if ($argWhere <> '') {
            $varQuery .= " WHERE " . $argWhere;
        }

//         //$varQuery .= " GROUP BY(pkShippingGatewaysID) DESC ";
        if ($argLimit <> '') {
            $varQuery .= " LIMIT " . $argLimit;
        }

        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
    }

//    function getcountryShippingByID($argSID, $argMID = 0) {
//    	
////        echo $argSID. $argMID;die;
//        $varQuery = "SELECT fkShippingGatewaysID,fkAdminID,fkcountry_id,name
//            FROM " . TABLE_SHIP_COUNTRY . " LEFT JOIN " . TABLE_SHIP_MULTIPLECOUNTRY . " ON pkshipcountryid = fkshipcountryid 
//            		LEFT JOIN tbl_country ON fkcountry_id = country_id";
//        $argWhere = "fkShippingGatewaysID =" . $argSID . " AND fkAdminID = " . $argMID . "";
////        $argWhere = "fkShippingGatewaysID =" . $argSID . "";
//        if ($argWhere <> '') {
//            $varQuery .= " WHERE " . $argWhere;
//        }
//
//        //$varQuery .= " GROUP BY(pkShippingGatewaysID) DESC ";
//        if ($argLimit <> '') {
//            $varQuery .= " LIMIT " . $argLimit;
//        }
//
//        $arrRes = $this->getArrayResult($varQuery);
//        //pre($arrRes);
//        return $arrRes;
//    }

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
        $varWhere = "ShippingAlias='" . $arrPost['frmShippingCode'] . "' AND  pkShippingGatewaysID != '" . $_GET['smid'] . "' ";
        $arrMethod = $this->shippingMethodList($varWhere);
        if (count($arrMethod) == 0) {
            $arrClms = array(
                'ShippingTitle' => $arrPost['frmShippingName'],
                'ShippingAlias' => $arrPost['frmShippingCode'],
                'ShippingStatus' => $arrPost['frmStatus'],
            );

            $varWhr = "pkShippingGatewaysID = '" . $_GET['smid'] . "' ";
            $arrUpdateID = $this->update(TABLE_SHIPPING_GATEWAYS, $arrClms, $varWhr);

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

            return $arrUpdateID;
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
        $this->delete(TABLE_SHIPPING_GATEWAYS, $varWhereAllD);

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