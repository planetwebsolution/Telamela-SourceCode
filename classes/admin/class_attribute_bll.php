<?php

/**
 * 
 * Class name : attribute
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The attribute class is used to maintain attribute infomation details for several modules.
 */
class attribute extends Database {

    /**
     * function attribute
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function attribute() {
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
     * User instruction: $objAttribute->CategoryFullDropDownList()
     */
    function CategoryFullDropDownList() {
        $arrClms = array('pkCategoryId', 'CategoryName', 'CategoryParentId');
        $varWhr = 'CategoryParentId=0 AND CategoryIsDeleted=0 ';
        $arrRes = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
        $arrRows = array();

        foreach ($arrRes as $v) {
            $arrRows[$v['pkCategoryId']] = $v['CategoryName'];
            $varWhr = 'CategoryParentId = ' . $v['pkCategoryId'] . ' AND CategoryIsDeleted=0 ';

            $arr = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
            foreach ($arr as $sv) {
                $arrRows[$sv['pkCategoryId']] = '&nbsp;&nbsp;&nbsp;' . $sv['CategoryName'];
                $varWhr = 'CategoryParentId = ' . $sv['pkCategoryId'] . ' AND CategoryIsDeleted=0 ';
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
     * function InputTypeList
     *
     * This function is used to display the InputTypeList deatails.
     *
     * Database Tables used in this function are : tbl_input_type
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string $arrRows
     *
     * User instruction: $objAttribute->InputTypeList()
     */
    function InputTypeList() {
        $arrClms = array('pkInputID', 'InputTypeAlias', 'InputTypeTitle');
        $varWhr = '1 ';
        $varOrderBy = 'InputTypeOrdering ASC';
        $arrRes = $this->select(TABLE_INPUT_TYPE, $arrClms, $varWhr, $varOrderBy);
        return $arrRes;
    }

    /**
     * function AttributeList
     *
     * This function is used to display the AttributeList deatails.
     *
     * Database Tables used in this function are : tbl_attribute, tbl_attribute_to_category, tbl_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRows
     *
     * User instruction: $objAttribute->AttributeList()
     */
    function AttributeList($argWhere = '', $argLimit = '') {
        /* $arrClms = array('pkAttributeID', 'AttributeCode', 'AttributeLabel', 'AttributeVisible', 'AttributeSearchable', 'AttributeComparable');
          $this->getSortColumn($_REQUEST);
          $varGroupBy = 'pkAttributeID';
          $varTable = " ".TABLE_ATTRIBUTE." LEFT JOIN ".TABLE_ATTRIBUTE_TO_CATEGORY." on fkAttributeId = pkAttributeId LEFT JOIN  ".TABLE_CATEGORY." on fkCategoryID = pkCategoryID ";
          $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
         */
        if ($argWhere != "") {
            $varWhere = "where 1 AND " . $argWhere . " ";
        }
        if ($argLimit) {
            $varLimit = " LIMIT " . $argLimit;
        }


        $this->getSortColumn($_REQUEST);
        $varQuery2 = "SELECT pkAttributeID, AttributeCode, AttributeLabel, AttributeOrdering,AttributeVisible, AttributeSearchable, AttributeComparable, GROUP_CONCAT(CategoryName) as CategoryNames FROM " . TABLE_ATTRIBUTE . " LEFT JOIN " . TABLE_ATTRIBUTE_TO_CATEGORY . " on fkAttributeId = pkAttributeId LEFT JOIN  " . TABLE_CATEGORY . " on fkCategoryID = pkCategoryID " . $varWhere . " group by pkAttributeID order by " . $this->orderOptions . "" . $varLimit;
        $arrRes = $this->getArrayResult($varQuery2);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function attributeExportList
     *
     * This function is used to display the attributeExportList deatails.
     *
     * Database Tables used in this function are : tbl_attribute, tbl_attribute_to_category, tbl_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRows
     *
     * User instruction: $objAttribute->attributeExportList()
     */
    function attributeExportList($argWhere = '', $argLimit = '') {
        $this->getSortColumn($_REQUEST);
        $varQuery2 = "SELECT pkAttributeID, AttributeCode, AttributeLabel, AttributeVisible, AttributeSearchable, AttributeComparable, GROUP_CONCAT(CategoryName) as CategoryNames,AttributeInputType, AttributeValidation,AttributeDateAdded  FROM " . TABLE_ATTRIBUTE . " LEFT JOIN " . TABLE_ATTRIBUTE_TO_CATEGORY . " on fkAttributeId = pkAttributeId LEFT JOIN  " . TABLE_CATEGORY . " on fkCategoryID = pkCategoryID " . $varWhere . " group by pkAttributeID order by " . $this->orderOptions . "" . $varLimit;
        $arrRes = $this->getArrayResult($varQuery2);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function CategoryToAttribute
     *
     * This function is used to display the CategoryToAttribute deatails.
     *
     * Database Tables used in this function are : tbl_attribute, tbl_attribute_to_category, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRows
     *
     * User instruction: $objAttribute->CategoryToAttribute()
     */
    function CategoryToAttribute($argcatid) {
        $arrClms = array('fkCategoryID', 'fkAttributeID');
        $varWhere = 'fkCategoryid=' . $argcatid;
        $varOrderBy = 'fkAttributeID ASC';
        $varTable = TABLE_ATTRIBUTE_TO_CATEGORY;
        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy);
        $arrRows = array();
        foreach ($arrRes as $val) {
            $arrClms = array('pkAttributeID', 'AttributeCode', 'AttributeLabel', 'AttributeInputType');
            $varOrderBy = 'pkAttributeID DESC';
            $varWher = 'pkAttributeID = ' . $val['fkAttributeID'];
            $arrRow = $this->select(TABLE_ATTRIBUTE, $arrClms, $varWher, $varOrderBy);
            $arrRows[$val['fkAttributeID']]['pkAttributeID'] = $arrRow[0]['pkAttributeID'];
            $arrRows[$val['fkAttributeID']]['AttributeCode'] = $arrRow[0]['AttributeCode'];
            $arrRows[$val['fkAttributeID']]['AttributeLabel'] = $arrRow[0]['AttributeLabel'];
            $arrRows[$val['fkAttributeID']]['AttributeInputType'] = $arrRow[0]['AttributeInputType'];

            $arrClmsOpt = array('pkOptionID', 'OptionTitle', 'OptionImage','optionColorCode');
            $varOrderByOpt = 'pkOptionID ASC';
            $varWherOpt = 'fkAttributeID = ' . $val['fkAttributeID'];
            $arrOpt = $this->select(TABLE_ATTRIBUTE_OPTION, $arrClmsOpt, $varWherOpt, $varOrderByOpt);
            $arrRows[$val['fkAttributeID']]['OptionsData'] = $arrOpt;
            $arrRows[$val['fkAttributeID']]['OptionsRows'] = count($arrOpt);
        }
        //print_r($arrRow);
        return $arrRows;
    }
    
    function GetAttIcon($optid){
        $arrClms = array('OptionImage');
        $varWhere = 'pkOptionID=' . $optid;
        //$varOrderBy = 'fkAttributeID ASC';
        $varTable = TABLE_ATTRIBUTE_OPTION;
        $arrRes = $this->select($varTable, $arrClms, $varWhere);
        return $arrRes[0];
    }

    /**
     * function addAttribute
     *
     * This function is used to add the Attribute.
     *
     * Database Tables used in this function are : tbl_attribute, tbl_attribute_to_category, tbl_category, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRows
     *
     * User instruction: $objAttribute->addAttribute($arrPost)
     */
    function addAttribute($arrPost, $arrFileName) {

        //pre($_POST);
        $varWhr = "AttributeCode = '" . addslashes($arrPost['frmAttributeCode']) . "' ";
        $arrAttributeRes = $this->AttributeList($varWhr);
        if (empty($arrAttributeRes)) {
            $arrClms = array(
                'AttributeCode' => $arrPost['frmAttributeCode'],
                'AttributeLabel' => $arrPost['frmAttributeTitle'],
                'AttributeVisible' => $arrPost['frmAttributeVisible'],
                'AttributeSearchable' => $arrPost['frmAttributeSearchable'],
                'AttributeComparable' => $arrPost['frmAttributeComparable'],
                'AttributeInputType' => $arrPost['frmInputType'],
                'AttributeValidation' => $arrPost['frmAttributeInputValidation'],
                'AttributeDateAdded' => date(DATE_TIME_FORMAT_DB)
            );
           
            $arrAddID = $this->insert(TABLE_ATTRIBUTE, $arrClms);

            $arrClmsUpdate = array('id' => $arrAddID,'name'=>$arrPost['frmAttributeTitle'],'action' => 'add','type' => 'attribute');
            $arrClmsUpdateReturn=$this->insert(TABLE_UPDATE_CATEGORY_ATTR_SHIPPING, $arrClmsUpdate);
           
            $sendUpdateToWholesaler =array('pkWholesalerID','CompanyEmail','CompanyName');
            $whrereSendUpdateToWholesaler="WholesalerAPIKey<>''";
            $sendUpdateToWholesalerReturn = $this->select(TABLE_WHOLESALER,$sendUpdateToWholesaler,$whrereSendUpdateToWholesaler);
            if(count($sendUpdateToWholesalerReturn)>0){
                
                foreach($sendUpdateToWholesalerReturn as $key=>$whlMail){
                
                $objTemplate = new EmailTemplate();
                $objCore = new Core();

                $varUserName = trim(strip_tags($whlMail['CompanyName']));
                $varPassword = trim(strip_tags($arrPost['frmPassword']));
                //pre($varUserName);
                $varToUser = $whlMail['CompanyEmail'];//'raju.khatak@mail.vinove.com';

                $varFromUser = $_SESSION['sessAdminEmail'];

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'New Attribute has been added' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '';
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}','{SITE_NAME}', '{NAME}', '{SITE_NAME}','{CATEGORY_NAME}');

                $varKeywordValues = array($varPathImage,SITE_NAME, $varUserName, SITE_NAME,$arrPost['frmAttributeTitle']);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function

                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                    
                }
                
            }

            if ($arrAddID > 0) {
                //pre($arrPost['frmCategoryId']);

                $i = 0;
                $j = 0;
                foreach ($arrPost['frmCategoryId'] as $valueCate) {
                    $arrClmsOptToCategory = array(
                        'fkAttributeID' => $arrAddID,
                        'fkCategoryID' => $valueCate,
                    );
                    if ($arrPost['frmInputType'] == 'image') {
                        $varQuery = "SELECT CategoryName FROM " . TABLE_ATTRIBUTE_TO_CATEGORY . " INNER JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeID  INNER JOIN " . TABLE_CATEGORY . " ON fkCategoryID = pkCategoryId  WHERE fkCategoryID='" . $valueCate . "' AND AttributeInputType='image' ";

                        $arrRes = $this->getArrayResult($varQuery);

                        $varNumRows = count($arrRes);
                    } else {
                        $varNumRows = 0;
                    }

                    if ($varNumRows > 0) {
                        $arrCat['exist'][] = $arrRes[0]['CategoryName'];
                        $j++;
                    } else {
                        $varQuery = "SELECT CategoryName FROM " . TABLE_CATEGORY . " WHERE pkCategoryId='" . $valueCate . "'";
                        $arrRes = $this->getArrayResult($varQuery);

                        $arrCat['new'][] = $arrRes[0]['CategoryName'];
                        $i++;
                        $this->insert(TABLE_ATTRIBUTE_TO_CATEGORY, $arrClmsOptToCategory);
                    }
                }
                if ($i > 0) {
                    foreach ($arrPost['options'] as $keyOption => $valueOption) {

                        $arrClmsOptions = array(
                            'fkAttributeId' => $arrAddID,
                            'OptionTitle' => $valueOption
                        );

                        if ($arrPost['frmInputType'] == 'image') {
                            $arrClmsOptions['OptionImage'] = $arrFileName[$keyOption];
                        }

                        if (trim($valueOption) == '') {
                            $arrClmsOptions['OptionTitle'] = $arrPost['frmAttributeTitle'];
                            
                        }
                        $arrClmsOptions['optionColorCode']=$arrPost['attributeColorCode'][$keyOption];
                       
                        $this->insert(TABLE_ATTRIBUTE_OPTION, $arrClmsOptions);
                    }
                } else {
                    $this->delete(TABLE_ATTRIBUTE, "pkAttributeID = '" . $arrAddID . "'");
                }
                $arrRet['ret'] = 'manage';

                if ($i > 0) {
                    $msg = ADMIN_ADD_SUCCUSS_MSG;

                    if ($j > 0) {
                        $varCatNew = implode(',', $arrCat['new']);
                        $varCatExist = implode(',', $arrCat['exist']);

                        $msg .= '<br/>Category [' . $varCatNew . '] Added sucessfully!';
                        $msg .= '<br/><span class="attr_err">Category [' . $varCatExist . '] Already used with image type attribute!</span>';
                    }
                } else if ($j > 0) {
                    $arrRet['ret'] = 'add';
                    $varCatExist = implode(',', $arrCat['exist']);
                    $msg .= '<br/><span class="attr_err">All Categories ' . $varCatExist . ' Already used with image type attribute!</span>';
                }
                $arrRet['msg'] = $msg;
            } else {
                $arrRet['ret'] = 'add';
                $arrRet['msg'] = '<span class="attr_err">' . ADMIN_ADD_ERROR_MSG . '</span>';
            }
        } else {
            $arrRet['ret'] = 'add';
            $arrRet['msg'] = '<span class="attr_err">Attribute Code already Exist. Please change.</span>';
        }

        return $arrRet;
    }

    /**
     * function editAttribute
     *
     * This function is used to edit the Attribute.
     *
     * Database Tables used in this function are : tbl_attribute, tbl_attribute_to_category, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrData
     *
     * User instruction: $objAttribute->editAttribute($argID)
     */
    function editAttribute($argID) {
        $varID = 'pkAttributeID =' . $argID;
        $arrClms = array('pkAttributeID', 'AttributeCode', 'AttributeLabel', 'AttributeVisible', 'AttributeSearchable', 'AttributeComparable', 'AttributeInputType', 'AttributeValidation');
        $arrData['arrAttributeData'] = $this->select(TABLE_ATTRIBUTE, $arrClms, $varID);

        $varOptID = 'fkAttributeId =' . $argID;
        $arrOptClms = array('pkOptionID', 'fkAttributeId', 'OptionTitle', 'OptionImage','optionColorCode');
        $varOrder = " pkOptionID ASC ";
        $arrData['arrAttributeOptionData'] = $this->select(TABLE_ATTRIBUTE_OPTION, $arrOptClms, $varOptID, $varOrder);

        $varCatID = 'fkAttributeId =' . $argID;
        //$arrCatClms = array('pkID', 'fkAttributeId', 'fkCategoryID');
        $arrCatClms = array('fkCategoryID');
        $catRes = $this->select(TABLE_ATTRIBUTE_TO_CATEGORY, $arrCatClms, $varCatID);
        foreach ($catRes as $val) {
            $arrData['arrAttributeCategoryData'][] = $val['fkCategoryID'];
        }

        //pre($arrData);
        return $arrData;
    }

    /**
     * function updateAttribute
     *
     * This function is used to update the Attribute.
     *
     * Database Tables used in this function are : tbl_attribute, tbl_attribute_to_category, tbl_category, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string 1
     *
     * User instruction: $objAttribute->updateAttribute($arrPost)
     */
    function updateAttribute($arrPost, $arrFileName) {

        //pre($arrPost);
        $varWhr = "pkAttributeID = '" . $_GET['attrbuteid'] . "' ";
        $varWhere = "AttributeCode = '" . addslashes($arrPost['frmAttributeCode']) . "' AND " . "pkAttributeID != '" . $_GET['attrbuteid'] . "'";
        $arrAttributeRes = $this->AttributeList($varWhere);

        if (empty($arrAttributeRes)) {

            $arrClms = array(
                'AttributeCode' => $arrPost['frmAttributeCode'],
                'AttributeLabel' => $arrPost['frmAttributeTitle'],
                'AttributeDesc' => $arrPost['frmAttributeDesc'],
                'AttributeVisible' => $arrPost['frmAttributeVisible'],
                'AttributeSearchable' => $arrPost['frmAttributeSearchable'],
                'AttributeComparable' => $arrPost['frmAttributeComparable'],
                'AttributeInputType' => $arrPost['frmInputType'],
                'AttributeValidation' => $arrPost['frmAttributeInputValidation']
            );
            //pre($arrPost);
            $arrUpdateID = $this->update(TABLE_ATTRIBUTE, $arrClms, $varWhr);
            
             $arrClmsUpdate = array('id' => $_GET['attrbuteid'],'name'=>$arrPost['frmAttributeTitle'],'action' => 'edit','type' => 'attribute');
            $arrClmsUpdateReturn=$this->insert(TABLE_UPDATE_CATEGORY_ATTR_SHIPPING, $arrClmsUpdate);
           
            $sendUpdateToWholesaler =array('pkWholesalerID','CompanyEmail','CompanyName');
            $whrereSendUpdateToWholesaler="WholesalerAPIKey<>''";
            $sendUpdateToWholesalerReturn = $this->select(TABLE_WHOLESALER,$sendUpdateToWholesaler,$whrereSendUpdateToWholesaler);
            if(count($sendUpdateToWholesalerReturn)>0){
                
                foreach($sendUpdateToWholesalerReturn as $key=>$whlMail){
                
                $objTemplate = new EmailTemplate();
                $objCore = new Core();

                $varUserName = trim(strip_tags($whlMail['CompanyName']));
                $varPassword = trim(strip_tags($arrPost['frmPassword']));
                //pre($varUserName);
                $varToUser = $whlMail['CompanyEmail'];//'raju.khatak@mail.vinove.com';

                $varFromUser = $_SESSION['sessAdminEmail'];

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'Attribute has been updated' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '';
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}','{SITE_NAME}', '{NAME}', '{SITE_NAME}','{CATEGORY_NAME}');

                $varKeywordValues = array($varPathImage,SITE_NAME, $varUserName, SITE_NAME,$arrPost['frmAttributeTitle']);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function

                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                    
                }
                
            }

            $varWhrD = "fkAttributeId = '" . $_GET['attrbuteid'] . "'";
            $this->delete(TABLE_ATTRIBUTE_OPTION, $varWhrD);


            foreach ($arrPost['options'] as $keyOption => $valueOption) {
                $arrClmsOptions = array(
                    'fkAttributeId' => $_GET['attrbuteid'],
                    'OptionTitle' => $valueOption,
                );

                if ($arrPost['frmInputType'] == 'image') {
                    $arrClmsOptions['OptionImage'] = $arrFileName[$keyOption];
                }

                if ($arrPost['optionsIds'][$keyOption] > 0) {
                    $arrClmsOptions['pkOptionID'] = $arrPost['optionsIds'][$keyOption];
                }

                if (trim($valueOption) == '') {
                    $arrClmsOptions['OptionTitle'] = $arrPost['frmAttributeTitle'];
                }
                $arrClmsOptions['optionColorCode']=$arrPost['attributeColorCode'][$keyOption];
                $this->insert(TABLE_ATTRIBUTE_OPTION, $arrClmsOptions);
            }

            $varQuery = "SELECT GROUP_CONCAT(fkCategoryID) as catids FROM " . TABLE_ATTRIBUTE_TO_CATEGORY . " WHERE " . $varWhrD . "";
            $arrOldCat = $this->getArrayResult($varQuery);
            $arrOldCat = explode(',', $arrOldCat[0]['catids']);


            $this->delete(TABLE_ATTRIBUTE_TO_CATEGORY, $varWhrD);
            $i = 0;
            $j = 0;
            $k = 0;
            foreach ($arrPost['frmCategoryId'] as $valueCate) {
                $arrClmsOptToCategory = array(
                    'fkAttributeID' => $_GET['attrbuteid'],
                    'fkCategoryID' => $valueCate,
                );
                if ($arrPost['frmInputType'] == 'image') {
                    $varQuery = "SELECT CategoryName FROM " . TABLE_ATTRIBUTE_TO_CATEGORY . " INNER JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeID  INNER JOIN " . TABLE_CATEGORY . " ON fkCategoryID = pkCategoryId  WHERE fkCategoryID='" . $valueCate . "' AND AttributeInputType='image' AND fkAttributeId != '" . $_GET['attrbuteid'] . "'";
                    $arrRes = $this->getArrayResult($varQuery);
                    $varNumRows = count($arrRes);
                } else {
                    $varNumRows = 0;
                }

                if ($varNumRows > 0) {
                    $arrCat['exist'][] = $arrRes[0]['CategoryName'];
                    $j++;
                } else {
                    $varQuery = "SELECT CategoryName FROM " . TABLE_CATEGORY . " WHERE pkCategoryId='" . $valueCate . "'";
                    $arrRes = $this->getArrayResult($varQuery);
                    if (in_array($valueCate, $arrOldCat)) {
                        $arrCat['new'][] = $arrRes[0]['CategoryName'];
                        $i++;
                    }

                    $this->insert(TABLE_ATTRIBUTE_TO_CATEGORY, $arrClmsOptToCategory);
                    $k++;
                }
            }

            $arrRet['ret'] = 'manage';
            $msg = ADMIN_UPDATE_SUCCUSS_MSG;

            if ($i > 0) {
                if ($j > 0) {
                    $varCatNew = implode(',', $arrCat['new']);
                    $varCatExist = implode(',', $arrCat['exist']);

                    $msg .= '<br/>Category [' . $varCatNew . '] Added sucessfully!';
                    $msg .= '<br/><span class="attr_err">Category [' . $varCatExist . '] Already used with image type attribute!</span>';
                }
            } else if ($j > 0) {
                $arrRet['ret'] = 'edit';
                $varCatExist = implode(',', $arrCat['exist']);
                $msg .= '<br/><span class="attr_err">Category ' . $varCatExist . ' Already used with image type attribute!</span>';
            }

            if ($k == 0) {
                foreach ($arrOldCat as $valueCate) {
                    $arrClmsOptToCategory = array(
                        'fkAttributeID' => $_GET['attrbuteid'],
                        'fkCategoryID' => $valueCate,
                    );
                    $this->insert(TABLE_ATTRIBUTE_TO_CATEGORY, $arrClmsOptToCategory);
                }
            }
            $arrRet['msg'] = $msg;
        } else {
            $arrRet['ret'] = 'edit';
            $arrRet['msg'] = '<span class="attr_err">Attribute Code already Exist. Please change.</span>';
        }

        return $arrRet;
    }

    /**
     * function removeAttribute
     *
     * This function is used to remove the Attribute.
     *
     * Database Tables used in this function are : tbl_attribute, tbl_attribute_to_category, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string 1
     *
     * User instruction: $objAttribute->removeAttribute($argPostIDs)
     */
    function removeAttribute($argPostIDs) {


        if (isset($argPostIDs['deleteType']) && $argPostIDs['deleteType'] == 'sD') {

            $varWhereSdelete = " pkAttributeID = '" . $argPostIDs['frmID'] . "'";
            $this->delete(TABLE_ATTRIBUTE, $varWhereSdelete);
            $varWhereSdelete = " fkAttributeID = '" . $argPostIDs['frmID'] . "'";

            $this->delete(TABLE_ATTRIBUTE_OPTION, $varWhereSdelete);
            $this->delete(TABLE_ATTRIBUTE_TO_CATEGORY, $varWhereSdelete);
            $this->delete(TABLE_PRODUCT_TO_OPTION, $varWhereSdelete);
            
            $arrClmsUpdate = array('id' => $argPostIDs['frmID'],'name'=>$argPostIDs['attName'],'action' => 'delete','type' => 'attribute');
            $arrClmsUpdateReturn=$this->insert(TABLE_UPDATE_CATEGORY_ATTR_SHIPPING, $arrClmsUpdate);
           
            $sendUpdateToWholesaler =array('pkWholesalerID','CompanyEmail','CompanyName');
            $whrereSendUpdateToWholesaler="WholesalerAPIKey<>''";
            $sendUpdateToWholesalerReturn = $this->select(TABLE_WHOLESALER,$sendUpdateToWholesaler,$whrereSendUpdateToWholesaler);
            if(count($sendUpdateToWholesalerReturn)>0){
                
                foreach($sendUpdateToWholesalerReturn as $key=>$whlMail){
                
                $objTemplate = new EmailTemplate();
                $objCore = new Core();

                $varUserName = trim(strip_tags($whlMail['CompanyName']));
                $varPassword = trim(strip_tags($arrPost['frmPassword']));
                //pre($varUserName);
                $varToUser = $whlMail['CompanyEmail'];//'raju.khatak@mail.vinove.com';

                $varFromUser = $_SESSION['sessAdminEmail'];

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'Attribute has been deleted' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '';
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}','{SITE_NAME}', '{NAME}', '{SITE_NAME}','{CATEGORY_NAME}');

                $varKeywordValues = array($varPathImage,SITE_NAME, $varUserName, SITE_NAME,$argPostIDs['attName']);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function

                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                    
                }
                
            }
            
            
            
            return true;
        } else {
            foreach ($argPostIDs['frmID'] as $key=> $varDeleteID) {
                $varWhereCondition = ' pkAttributeID = ' . $varDeleteID;
                $this->delete(TABLE_ATTRIBUTE, $varWhereCondition);
                $varWhereSdelete = " fkAttributeID = '" . $varDeleteID . "'";
                $this->delete(TABLE_ATTRIBUTE_OPTION, $varWhereSdelete);
                $this->delete(TABLE_ATTRIBUTE_TO_CATEGORY, $varWhereSdelete);
                $this->delete(TABLE_PRODUCT_TO_OPTION, $varWhereSdelete);
                
                
                 $arrClmsUpdate = array('id' => $varDeleteID,'name'=>$argPostIDs['attName'][$key],'action' => 'delete','type' => 'attribute');
            $arrClmsUpdateReturn=$this->insert(TABLE_UPDATE_CATEGORY_ATTR_SHIPPING, $arrClmsUpdate);
           
            $sendUpdateToWholesaler =array('pkWholesalerID','CompanyEmail','CompanyName');
            $whrereSendUpdateToWholesaler="WholesalerAPIKey<>''";
            $sendUpdateToWholesalerReturn = $this->select(TABLE_WHOLESALER,$sendUpdateToWholesaler,$whrereSendUpdateToWholesaler);
            if(count($sendUpdateToWholesalerReturn)>0){
                
                foreach($sendUpdateToWholesalerReturn as $key=>$whlMail){
                
                $objTemplate = new EmailTemplate();
                $objCore = new Core();

                $varUserName = trim(strip_tags($whlMail['CompanyName']));
                $varPassword = trim(strip_tags($arrPost['frmPassword']));
                //pre($varUserName);
                $varToUser = $whlMail['CompanyEmail'];//'raju.khatak@mail.vinove.com';

                $varFromUser = $_SESSION['sessAdminEmail'];

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'Attribute has been deleted' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '';
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}','{SITE_NAME}', '{NAME}', '{SITE_NAME}','{CATEGORY_NAME}');

                $varKeywordValues = array($varPathImage,SITE_NAME, $varUserName, SITE_NAME,$argPostIDs['attName'][$key]);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function

                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                    
                }
                
            }
            }
            return true;
        }
    }

    /*     * ****************************************
      Function name:getSortColumn
      Return type: String
      Author : Aditya Pratap Singh
      Last modified by : Aditya Pratap Singh
      Comments: sort coloum for Enquiries
      User instruction: $objEnquiries->getSortColumn($argVarSortOrder)
     * **************************************** */

    function getSortColumn($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
//        if ($argVarSortOrder['orderBy'] == '') {
//            $varOrderBy = 'DESC';
//        } else {
//            $varOrderBy = $argVarSortOrder['orderBy'];
//        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            //$varSortBy = 'pkAttributeID';
             $varSortBy = 'AttributeOrdering ASC';
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
        $objOrder->addColumn('Attribute Code', 'AttributeCode');
        $objOrder->addColumn('Attribute Label (Name)', 'AttributeLabel', '', 'hidden-480');
        $objOrder->addColumn('Category', 'CategoryNames', '', 'hidden-1024');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function editAttribute
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_attribute
     *
     * @access public
     *
     * @parameters 1 string, string(optional)
     *
     * @return string $stringMessage
     */
    function updateAttributeOrder($argPost) {
        
//        $count = 0;
//        foreach ($argPost['order'] as $valOrder) {
//            $argWhere = 'pkAttributeID =' . $argPost['orderId'][$count];
//            $arrClms = array(
//                'AttributeOrdering' => $valOrder
//            );
//            $varTable = TABLE_ATTRIBUTE;
//            $this->update($varTable, $arrClms, $argWhere);
//            $count++;
//        }
//        return true;
        
        $message_order = array();
        $count = 0;
        $count1 = 0;
      // pre($argPost);
        foreach ($argPost['order'] as $key => $valOrder) {
            // $valOrder;
            // $argPost['orderId'][$key];
            $varTable = TABLE_ATTRIBUTE;
            $arrClms = array('pkAttributeID', 'AttributeOrdering');
            $argWhere = "pkAttributeID ='" . $argPost['orderId'][$key] . "' and AttributeOrdering='" . $valOrder . "'";
            $arrRes = $this->select($varTable, $arrClms, $argWhere);
//            echo $key;
//            echo count($arrRes);
            if (count($arrRes) == 0) {

                $varTable = TABLE_ATTRIBUTE;
                $argWhere = "AttributeOrdering ='" . $valOrder . "'";
                //pre($argWhere);
                $argWhere1 = "pkAttributeID ='" . $argPost['orderId'][$key] . "'";
                $arrClms1 = array(
                    'AttributeOrdering'
                );
                $arrClms2 = array(
                    'AttributeOrdering' => $valOrder
                );

                $arrRes1 = $this->select($varTable, $arrClms1, $argWhere);

                if (count($arrRes1) == 0) {
                    $this->update($varTable, $arrClms2, $argWhere1);
                    $message_order['success'][$count] = $valOrder;
                    $count++;
                } else {
                    $message_order['error'][$count1] = $valOrder;
                    $count1++;
                }
            }
        }

        //return true;
        return $message_order;
    }

}

?>
