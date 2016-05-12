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
class ZonePriceNew extends Database {

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

    function zonepriceCount($argWhere = '') {

        $arrClms = array(
            'pkpriceid',
        );
        $argWhr = ($argWhere <> '') ? $argWhere : '';
        //$argWhr.='ORDER BY pkpriceid DESC';
        //$argWhr = ($argWhere <> '') ?  $argWhere : '';
        // pre($argWhr);
        $varTable = TABLE_ZONEPRICE;
        //$varNum = $this->getNumRows($varTable, $arrClms, $argWhr);
        $arrRes = $this->select(TABLE_ZONEPRICE, $arrClms, $argWhr, $varOrderBy, $argLimit);
        $countvalue = count($arrRes);
        //pre($countvalue);
        return $countvalue;
    }

    function addprice($arrPost) {
        //pre($_SESSION);
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

            $varWhere = "zonetitleid='" . $val . "' AND  shippingmethod = '" . $arrPost['shippingmethod'][$key] . "'AND  fklogisticidvalue = '" . $_SESSION['sessLogistic'] . "' ";
            $arrMethod = $this->zoneMethodList($varWhere);
            $arrLogisticdetails = $objGeneral->GetCompleteDetailsofLogisticPortalbyid($_SESSION['sessLogistic']);
            $logistictitle = $arrLogisticdetails[0]['logisticTitle'];
            $logisticmailid = $arrLogisticdetails[0]['logisticEmail'];
            // pre($arrLogisticdetails);
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
                        'fklogisticidvalue' => $_SESSION['sessLogistic'],
                        'fkcountriesid' => $_SESSION['sessLogisticPortal'],
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

    function removezonepric($argPostIDs) {
        $varWhere = "pkpriceid = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_ZONEPRICE, $varWhere);
    }

    function editprice($arrPost) {
//         pre($arrPost['zoneid']);
        global $objGeneral;
        global $objCore;

        if (!empty($arrPost['pkpriceid'])) {
            $arrLogisticdetails = $objGeneral->GetCompleteDetailsofLogisticPortalbyid($_SESSION['sessLogistic']);
            $logistictitle = $arrLogisticdetails[0]['logisticTitle'];
            $logisticmailid = $arrLogisticdetails[0]['logisticEmail'];

            $varQuery = "SELECT * FROM " . TABLE_ZONEPRICE . " WHERE pkpriceid != " . $arrPost['pkpriceid'] . " AND pkpriceid != " . $arrPost['prepriceid'] . " AND fklogisticidvalue = " . $_SESSION['sessLogistic'] . " AND shippingmethod = " . $arrPost['shippingmethod'][0] . " AND zonetitleid = " . $arrPost['zoneid'][0] . "";
            $arrRes = $this->getArrayResult($varQuery);

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
                    'fklogisticidvalue' => $_SESSION['sessLogistic'],
                    'shippingmethod' => $arrPost['shippingmethod'][0],
                    'fkcountriesid' => $_SESSION['sessLogisticPortal'],
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

                $Query = "SELECT * FROM " . TABLE_ZONEPRICE . " WHERE pkpriceid = " . $arrPost['pkpriceid'] . " AND fklogisticidvalue = " . $_SESSION['sessLogistic'] . " ";
                $Res = $this->getArrayResult($Query);
                $curDate = date('Y-m-d');
                $tomorrow = date('Y-m-d', strtotime($curDate . ' + 1 day'));
                //pre($Res);
                if ($Res[0]['created'] > $curDate) {

                    if ($arrPost['pricestatus'] == 2) {
                        $arrclms1['pricestatus'] = 0;
                        $varWhr = 'pkpriceid = ' . $arrPost['pkpriceid'];
                        $this->update(TABLE_ZONEPRICE, $arrclms1, $varWhr);
                    } else {
                        //pre($arrclms1);
                        $varWhr = 'pkpriceid = ' . $arrPost['pkpriceid'];
                        $arrclms1['pricestatus'] = 0;
                        $this->update(TABLE_ZONEPRICE, $arrclms1, $varWhr);
                    }
                } else {


                    if ($arrPost['pricestatus'] != 2) {
                        $varWhere = "pkpriceid != " . $arrPost['pkpriceid'] . " AND fklogisticidvalue = " . $_SESSION['sessLogistic'] . " AND shippingmethod = " . $arrPost['shippingmethod'][0] . " AND zonetitleid = " . $arrPost['zoneid'][0] . "";
                        $this->delete(TABLE_ZONEPRICE, $varWhere);

                        $arrclms1['created'] = $tomorrow;
                        $arrclms1['prepriceid'] = $arrPost['pkpriceid'];
                        $varWhr = '';
                        $this->insert(TABLE_ZONEPRICE, $arrclms1, $varWhr);
                    } else {
                        //pre($arrclms1);
                        $arrclms1['pricestatus'] = 0;
                        $varWhr = 'pkpriceid = ' . $arrPost['pkpriceid'];
                        $this->update(TABLE_ZONEPRICE, $arrclms1, $varWhr);
                    }
                }

                return 1;
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
            } else {
                return 'exist';
            }
        }
    }

    function getZoneCountry() {

        $varQuery = "SELECT zone,group_concat(' ',name) as Countries FROM " . TABLE_COUNTRY . " WHERE status='1' AND zone!='' GROUP BY(zone) ASC";

        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }

    function getPriceByID($id) {

        $varQuery = "SELECT * FROM " . TABLE_ZONEPRICE . " LEFT JOIN " . TABLE_SHIPPING_METHOD . ""
                . " ON shippingmethod = pkShippingMethod LEFT JOIN " . TABLE_ZONE . " "
                . " ON zonetitleid = zoneid"
                . " WHERE pkpriceid  = " . $id . " And fklogisticidvalue=" . $_SESSION['sessLogistic'] . "";

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        //pre($arrRes);
        return $arrRes;
    }

    function zonePriceList($argWhere = '', $argLimit = '') {

        $varClms = " zonetitleid,pkpriceid,fklogisticidvalue,shippingmethod,maxlength,maxwidth,maxheight,minkg,maxkg,costperkg,handlingcost,fragilecost,deliveryday,cubicweight,title,MethodName,pricestatus";
        $varTable = TABLE_ZONEPRICE . " LEFT JOIN " . TABLE_ZONE . " "
                . " ON zonetitleid = zoneid " . " LEFT JOIN " . TABLE_SHIPPING_METHOD . ""
                . " ON shippingmethod = pkShippingMethod ";
        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";

        // $varOrderBy = "GROUP BY fkShippingMethodID ORDER BY ShippingType ASC,ShippingTitle ASC";
//        pre($_REQUEST);
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

}

?>