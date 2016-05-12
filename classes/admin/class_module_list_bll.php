<?php

/**
 *
 * Class name : ModuleList
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The ModuleList class is used to maintain ModuleList infomation details.
 */
Class ModuleList extends Database {

    /**
     * function ModuleList
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function ModuleList() {
        //default constructor
    }

    /**
     * function getModuleList
     *
     * This function is used to display the module List.
     *
     * Database Tables used in this function are : tbl_module_list
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string $arrResults
     *
     * User instruction: $ObjModuleList->shippingGatewayList()
     */
    
    function getModuleList() {

        $arrClms = array('pkModuleId', 'ModuleName', 'ModuleAlias', 'ModuleParentId', 'ModuleOrder');
        $varOrderBy = 'ModuleOrder ASC ';
        $varWhere = "ModuleParentId='0' AND ModuleStatus='1'";

        $arrResultsL1 = $this->select(TABLE_MODULE_LIST, $arrClms, $varWhere, $varOrderBy);
        $arrRows = $arrResultsL1;

        foreach ($arrResultsL1 as $k => $v) {

            $varWhereL1 = "ModuleParentId='" . $v['pkModuleId'] . "' AND ModuleStatus='1'";
            $arrResultsL2 = $this->select(TABLE_MODULE_LIST, $arrClms, $varWhereL1, $varOrderBy);
            $arrRows[$k]['l1'] = $arrResultsL2;
            foreach ($arrResultsL2 as $kk => $vv) {

                $varWhereL2 = "ModuleParentId='" . $vv['pkModuleId'] . "' AND ModuleStatus='1' ";
                $arrResultsL3 = $this->select(TABLE_MODULE_LIST, $arrClms, $varWhereL2, $varOrderBy);
                $arrRows[$k]['l1'][$kk]['l2'] = $arrResultsL3;
            }
        }
        //echo $i;
        //pre($arrRows);

        return $arrRows;
    }

    /**
     * function getRollList
     *
     * This function is used to display the Roll List.
     *
     * Database Tables used in this function are : tbl_admin_roll
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string $arrResults
     *
     * User instruction: $ObjModuleList->shippingGatewayList()
     */
    function getRollList() {

        $arrClms = array('pkAdminRoleId', 'AdminRoleName', 'AdminRollDateAdded');
        $varOrderBy = 'AdminRoleName ASC ';
        $varWhere = '1 AND AdminRoleName != "DefaultCountryPortal" ';
        $arrResults = $this->select(TABLE_ADMIN_ROLL, $arrClms, $varWhere, $varOrderBy);
        //pre($arrResults);
        return $arrResults;
    }
    
    function getRollID() {

        $arrClms = array('pkAdminRoleId');
        $varOrderBy = 'AdminRoleName ASC ';
        $varWhere = '1 AND AdminRoleName = "DefaultCountryPortal" ';
        $arrResults = $this->select(TABLE_ADMIN_ROLL, $arrClms, $varWhere, $varOrderBy);
        return $arrResults[0]['pkAdminRoleId'];
//        return $arrResults;
    }

    /**
     * function addRoll
     *
     * This function is used to add the Roll.
     *
     * Database Tables used in this function are : tbl_admin_roll
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     *
     * User instruction: $ObjModuleList->addRoll($arrPost)
     */
    function addRoll($arrPost) {

        if ($arrPost['permission']) {
            $varPermission = implode(',', $arrPost['permission']);
        } else {
            $varPermission = '';
        }
        $arrClms = array(
            'AdminRoleName' => $arrPost['frmRollName'],
            'AdminRolePermission' => $varPermission,
            'AdminRollDateAdded' => date(DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_ADMIN_ROLL, $arrClms);
        return $arrAddID;
    }

    /**
     * function editRoll
     *
     * This function is used to edit the Roll.
     *
     * Database Tables used in this function are : tbl_admin_roll
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRollData
     *
     * User instruction: $ObjModuleList->editRoll($argRollID)
     */
    function editRoll($argRollID) {
        $argID = 'pkAdminRoleId =' . $argRollID;
        $arrClms = array('AdminRoleName', 'AdminRolePermission');
        $arrRollData = $this->select(TABLE_ADMIN_ROLL, $arrClms, $argID);
        //echo '<pre>';print_r($arrRollData);die;
        return $arrRollData;
    }

    /**
     * function updateRoll
     *
     * This function is used to update the Roll.
     *
     * Database Tables used in this function are : tbl_admin_roll
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrUpdateID
     *
     * User instruction: $ObjModuleList->updateRoll($arrPost)
     */
    function updateRoll($arrPost) {

        if ($arrPost['permission']) {
            $varPermission = implode(',', $arrPost['permission']);
        } else {
            $varPermission = '';
        }
        $arrClms = array('AdminRoleName' => $arrPost['frmRollName'], 'AdminRolePermission' => $varPermission);

        $varWhr = 'pkAdminRoleId = ' . $_GET['rollid'];
        $arrUpdateID = $this->update(TABLE_ADMIN_ROLL, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function removeRoll
     *
     * This function is used to remove the Roll.
     *
     * Database Tables used in this function are : tbl_admin_roll
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $ObjModuleList->removeRoll($argPostIDs)
     */
    function removeRoll($argPostIDs) {


        if (isset($argPostIDs['deleteType']) && $argPostIDs['deleteType'] == 'sD') {

            if ($argPostIDs['frmID'] > 0) {
                $varWhereDelete = " fkAdminRollId = '" . $argPostIDs['frmID'] . "'";
                $this->delete(TABLE_ADMIN, $varWhereDelete);
                $varWhereSdelete = " pkAdminRoleId = '" . $argPostIDs['frmID'] . "'";
                $this->delete(TABLE_ADMIN_ROLL, $varWhereSdelete);

                return true;
            } else {
                return false;
            }
        } else {
            foreach ($argPostIDs['frmID'] as $varDeleteID) {
                $varWhereDelete = "fkAdminRollId = '" . $varDeleteID . "'";
                $this->delete(TABLE_ADMIN, $varWhereDelete);

                $varWhereCondition = " pkAdminRoleId = '" . $varDeleteID . "'";
                $this->delete(TABLE_ADMIN_ROLL, $varWhereCondition);
            }
            return true;
        }
    }

    /**
     * function getSortColumn
     *
     * This function is used to sorting the Roll.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $ObjModuleList->getSortColumn($argVarSortOrder)
     */
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
            $varSortBy = 'pkAdminID';
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
        $objOrder->addColumn('Name', 'AdminUserName');
        $objOrder->addColumn('Email', 'AdminEmail');
        $objOrder->addColumn('Role', 'AdminRoleName');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

}

?>