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
Class ZonePrice extends Database {

    /**
     * function __construct
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function __construct() {
//       pre($_REQUEST);
        //$objCore = new Core();
        //default constructor for this class
    }

    function zonePriceList($argWhere = '', $argLimit = '') {

        $varClms = " zonetitleid,pkpriceid,fklogisticidvalue,shippingmethod,maxlength,maxwidth,maxheight,minkg,"
                . " maxkg,costperkg,handlingcost,fragilecost,deliveryday,cubicweight,title,MethodName,pricestatus";
        $varTable = TABLE_ZONEPRICE . " LEFT JOIN " . TABLE_ZONE . " "
                . " ON zonetitleid = zoneid " . " LEFT JOIN " . TABLE_SHIPPING_METHOD . ""
                . " ON shippingmethod = pkShippingMethod ";
        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
//        $varWhere = " WHERE fklogisticidvalue = " . $argWhere . "";
        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";

        // $varOrderBy = "GROUP BY fkShippingMethodID ORDER BY ShippingType ASC,ShippingTitle ASC";

        $this->getSortColumn($_REQUEST);
        $sortable = $this->orderOptions;
//         pre($sortable);
        if (!empty($sortable)) {
            $varOrderBy = "ORDER BY " . $sortable;
        } else {
            $varOrderBy = " ORDER BY pkpriceid DESC";
        }
        // pre($varOrderBy);
        //$varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy ." " . $sortable. " " . $varLimit;
        $varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy . " " . $varLimit;
//pre($varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);

        return $arrRes;
    }

    function getPriceByID($id) {

        $varQuery = "SELECT * FROM " . TABLE_ZONEPRICE . " LEFT JOIN " . TABLE_SHIPPING_METHOD . ""
                . " ON shippingmethod = pkShippingMethod LEFT JOIN " . TABLE_ZONE . " "
                . " ON zonetitleid = zoneid"
                . " WHERE pkpriceid  = " . $id . " ";

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
//        pre($arrRes);
        return $arrRes;
    }

    function editprice($arrPost) {
//         pre($arrPost);
        global $objGeneral;
        global $objCore;

        if (!empty($arrPost['pkpriceid'])) {
            $arrLogisticdetails = $objGeneral->GetCompleteDetailsofLogisticPortalbyid($arrPost['LogisticId']);
            $logistictitle = $arrLogisticdetails[0]['logisticTitle'];
            $logisticmailid = $arrLogisticdetails[0]['logisticEmail'];
//            pre($arrLogisticdetails);
            $varQuery = "SELECT * FROM " . TABLE_ZONEPRICE . " WHERE pkpriceid != " . $arrPost['pkpriceid'] . " AND pkpriceid != " . $arrPost['prepriceid'] . " AND fklogisticidvalue = " . $arrPost['logisticId'] . " AND shippingmethod = " . $arrPost['shippingmethod'][0] . " AND zonetitleid = " . $arrPost['zoneid'][0] . "";
            $arrRes = $this->getArrayResult($varQuery);
//            pre($arrRes);
            if (count($arrRes) == 0) {

                $Query = "SELECT * FROM " . TABLE_ZONEDETAIL . " WHERE fkzoneid = " . $arrPost['zoneid'][0] . "";
                $arrRes = $this->getArrayResult($Query);
                $fIds = array();

                foreach ($arrRes as $vv1) {
                    array_push($fIds, $vv1['id']);
                }
                $fIdSting = implode(',', $fIds);

                $arrclms1 = array(
                    //'pkpriceid' => $val,
                    'zonetitleid' => $arrPost['zoneid'][0],
                    'fklogisticidvalue' => $arrPost['LogisticId'],
                    'shippingmethod' => $arrPost['shippingmethod'][0],
                    'fkcountriesid' => $arrLogisticdetails[0]['logisticportal'],
                    'fkzonedetailid' => $fIdSting,
                    'maxlength' => $arrPost['length'][0],
                    'maxwidth' => $arrPost['width'][0],
                    'maxheight' => $arrPost['height'][0],
                    'minkg' => $arrPost['minweight'][0],
                    'maxkg' => $arrPost['maxweight'][0],
                    'costperkg' => $arrPost['cost'][0],
                    'handlingcost' => $arrPost['handlingcost'][0],
                    'fragilecost' => $arrPost['fragilecost'][0],
                    'deliveryday' => $arrPost['deliveryday'][0],
                    'cubicweight' => $arrPost['cubic'][0],
                );

                $Query = "SELECT * FROM " . TABLE_ZONEPRICE . " WHERE pkpriceid = " . $arrPost['pkpriceid'] . " AND fklogisticidvalue = " . $arrPost['logisticId'] . " ";
                $Res = $this->getArrayResult($Query);
                $curDate = date('Y-m-d');
                $tomorrow = date('Y-m-d', strtotime($curDate . ' + 1 day'));
//                pre($Res);
                if ($Res[0]['created'] > $curDate) {

                    if ($arrPost['pricestatus'] == 2) {
                        $arrclms1['pricestatus'] = 1;
                        $varWhr = 'pkpriceid = ' . $arrPost['pkpriceid'];
                        $this->update(TABLE_ZONEPRICE, $arrclms1, $varWhr);
                    } else {
                        //pre($arrclms1);
                        $varWhr = 'pkpriceid = ' . $arrPost['pkpriceid'];
                        $arrclms1['pricestatus'] = 1;
                        $this->update(TABLE_ZONEPRICE, $arrclms1, $varWhr);
                    }
                } else {


                    if ($arrPost['pricestatus'] != 2) {
                        $varWhere = "pkpriceid != " . $arrPost['pkpriceid'] . " AND fklogisticidvalue = " . $arrPost['logisticId'] . " AND shippingmethod = " . $arrPost['shippingmethod'][0] . " AND zonetitleid = " . $arrPost['zoneid'][0] . "";
                        $this->delete(TABLE_ZONEPRICE, $varWhere);

                        $arrclms1['created'] = $tomorrow;
                        $arrclms1['pricestatus'] = 1;
                        $arrclms1['prepriceid'] = $arrPost['pkpriceid'];
                        $varWhr = '';
                        $this->insert(TABLE_ZONEPRICE, $arrclms1, $varWhr);
                    } else {
                        //pre($arrclms1);
                        $arrclms1['pricestatus'] = 1;
                        $varWhr = 'pkpriceid = ' . $arrPost['pkpriceid'];
                        $this->update(TABLE_ZONEPRICE, $arrclms1, $varWhr);
                    }
                }


                if ($_SERVER[HTTP_HOST] != '192.168.100.97') {
                    //Send Mail To User
                    $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png' . '"/>';
                    $varToUser = $_SESSION['sesslogisticAdminEmail'];
                    $varFromUser = SITE_EMAIL_ADDRESS;
                    $sitelink = SITE_ROOT_URL . 'logistic/';
                    $varSubject = SITE_NAME . ':Price Apporval';
                    $varBody = '
                		<table width="700" cellspacing="0" cellpadding="5" border="0">
							    <tbody>
							      <tr>
							        
							        <td width="600" style="padding-left:10px;">
							          <p>
							Welcome! <br/><br/>
							<strong>Dear Admin,</strong>
							            <br />
							            <br />
							 Please Apporved My Edited Price Application. 
							<br/><br/>
							        </p>
							         </td>
							      </tr>
							    </tbody>
							  </table>
                		';
//                 $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/admin_user_registration.html');
//                 $varUnsubscribeLink = 'Click <a href="' . SITE_ROOT_URL . 'unsubscribe.php?user=' . md5($argArrPost['frmUserEmail']) . '" target="_blank">here</a> to unsubscribe.';
//                 $varActivationLink = '';
//                 $arrBodyKeywords = array('{USER}', '{USER_NAME}', '{PASSWORD}', '{EMAIL}', '{ROLE}', '{SITE_NAME}', '{ACTIVATION_LINK}', '{IMAGE_PATH}', '{UNSUBSCRIBE_LINK}');
//                 $arrBodyKeywordsValues = array(trim(stripslashes($argArrPost['frmName'])), trim(stripslashes($argArrPost['frmName'])), trim($argArrPost['frmPassword']), trim(stripslashes($argArrPost['frmUserEmail'])), 'Country Portal', SITE_NAME, $varActivationLink, $varPath); //,$varUnsubscribeLink
//                 $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
                    $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);
                    $_SESSION['sessArrUsers'] = '';
                }
                return 1;
            } else {
                return 'exist';
            }
        }
    }

    function getZoneListByLogisticID($whr) {

        $varQuery = "SELECT * FROM " . TABLE_ZONE . ""
                . " WHERE " . $whr . " ";

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
//        pre($arrRes);
        return $arrRes;
    }

    function addprice($arrPost) {
//        pre($arrPost);
        global $objGeneral;
        global $objCore;
        if (!empty($arrPost['zoneid'])) {
            $check = array();
            foreach ($arrPost['zoneid'] as $key => $val) {

                // pre($val.'-'.$arrPost['shippingmethod'][$key]);
                //echo $val.'-'.$arrPost['shippingmethod'][$key];
                if (in_array($val . '-' . $arrPost['shippingmethod'][$key], $check)) {
                    //  echo 'ddddddddd';die;
                    return 'wrongcombination';
                    // die();
                }
                $check[] = $val . '-' . $arrPost['shippingmethod'][$key];
            }
            //pre($check);
        }

        if (!empty($arrPost['zoneid'])) {

            foreach ($arrPost['zoneid'] as $key => $val) {
                $varWhere = "zonetitleid='" . $val . "' AND  shippingmethod = '" . $arrPost['shippingmethod'][$key] . "'AND  fklogisticidvalue = '" . $_REQUEST['LogisticId'] . "' ";

                $arrMethod = $this->zoneMethodList($varWhere);
                if (count($arrMethod) != 0) {
                    return 'exist';
                }
            }
            $arrLogisticdetails = $objGeneral->GetCompleteDetailsofLogisticPortalbyid($_REQUEST['LogisticId']);
            $logistictitle = $arrLogisticdetails[0]['logisticTitle'];
            $logisticmailid = $arrLogisticdetails[0]['logisticEmail'];
//             pre($arrLogisticdetails);
            if (count($arrMethod) == 0) {
                foreach ($arrPost['zoneid'] as $key => $val) {

                    $Query = "SELECT * FROM " . TABLE_ZONEDETAIL . " WHERE fkzoneid = " . $val . "";
                    $arrRes = $this->getArrayResult($Query);
                    $fIds = array();
                    foreach ($arrRes as $vv1) {
                        array_push($fIds, $vv1['id']);
                    }
                    $fIdSting = implode(',', $fIds);
                    //pre($fIdSting);

                    $curDate = date('Y-m-d');
                    $arrclms1 = array(
                        'zonetitleid' => $val,
                        'fklogisticidvalue' => $_REQUEST['LogisticId'],
                        'fkcountriesid' => $arrLogisticdetails[0]['logisticportal'],
                        'shippingmethod' => $arrPost['shippingmethod'][$key],
                        'fkzonedetailid' => $fIdSting,
                        'maxlength' => $arrPost['length'][$key],
                        'maxwidth' => $arrPost['width'][$key],
                        'maxheight' => $arrPost['height'][$key],
                        'minkg' => $arrPost['minweight'][$key],
                        'maxkg' => $arrPost['maxweight'][$key],
                        'costperkg' => $arrPost['cost'][$key],
                        'handlingcost' => $arrPost['handlingcost'][$key],
                        'fragilecost' => $arrPost['fragilecost'][$key],
                        'deliveryday' => $arrPost['deliveryday'][$key],
                        'cubicweight' => $arrPost['cubic'][$key],
                        'created' => $curDate,
                    );
                    // pre($_SESSION['sesslogisticAdminEmail']);
                    // $_SESSION['sesslogisticAdminEmail']='avinesh.mathur@planetwebsolution.com';
                    $zonedetais_id = $this->insert(TABLE_ZONEPRICE, $arrclms1);
                    if ($_SERVER[HTTP_HOST] != '192.168.100.97') {
                        //Send Mail To User
                        $varPath = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png' . '"/>';
                        $varToUser = $_SESSION['sesslogisticAdminEmail'];
                        $varFromUser = SITE_EMAIL_ADDRESS;
                        $sitelink = SITE_ROOT_URL . 'logistic/';
                        $varSubject = SITE_NAME . ':Price Apporval';
                        $varBody = '
                		<table width="700" cellspacing="0" cellpadding="5" border="0">
							    <tbody>
							      <tr>
							        
							        <td width="600" style="padding-left:10px;">
							          <p>
							Welcome! <br/><br/>
							<strong>Dear Admin,</strong>
							            <br />
							            <br />
							 Please Apporved My Price Application. 
							            
							            
							            <br /><br />
							
							        </p>
							         </td>
							      </tr>
							    </tbody>
							  </table>
                		';
//                 $varOutput = file_get_contents(SITE_ROOT_URL . 'common/email_template/html/admin_user_registration.html');
//                 $varUnsubscribeLink = 'Click <a href="' . SITE_ROOT_URL . 'unsubscribe.php?user=' . md5($argArrPost['frmUserEmail']) . '" target="_blank">here</a> to unsubscribe.';
//                 $varActivationLink = '';
//                 $arrBodyKeywords = array('{USER}', '{USER_NAME}', '{PASSWORD}', '{EMAIL}', '{ROLE}', '{SITE_NAME}', '{ACTIVATION_LINK}', '{IMAGE_PATH}', '{UNSUBSCRIBE_LINK}');
//                 $arrBodyKeywordsValues = array(trim(stripslashes($argArrPost['frmName'])), trim(stripslashes($argArrPost['frmName'])), trim($argArrPost['frmPassword']), trim(stripslashes($argArrPost['frmUserEmail'])), 'Country Portal', SITE_NAME, $varActivationLink, $varPath); //,$varUnsubscribeLink
//                 $varBody = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
                        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varBody);
                        $_SESSION['sessArrUsers'] = '';
                    }
                }
                return $zonedetais_id;
            } else {
                return 'exist';
            }
        }
    }

    function zoneMethodList($argWhere = '', $argLimit = '') {
        $arrClms = array(
            'pkpriceid',
        );
        $varOrderBy = "";
        //pre($argWhere);
        $varTable = TABLE_ZONEPRICE;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

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
            $varSortBy = 'pkpriceid';
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
        $objOrder->addColumn('Zone', 'zoneid');
        $objOrder->addColumn('Method', 'MethodName');
        //$objOrder->addColumn('Method','CouponCode','','hidden-480');
        $objOrder->addColumn('Maximum Dimension', 'maxlength');
        $objOrder->addColumn('Minimum Weight(kg)', 'minkg', '', 'hidden-480');
        $objOrder->addColumn('Maximum Weight(kg)', 'maxkg');
        $objOrder->addColumn('Cost Per Kg($)', 'costperkg', '', 'hidden-480');
        //$objOrder->addColumn('Discount %', 'Discount','','hidden-350');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
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

        if ($cmpId) {
            $whereCon = " AND logisticportalid = " . $cmpId . " ";
        } else {
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
                } else {
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