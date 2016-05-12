<?php

/**
 * 
 * Class name : category
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The category class is used to maintain category infomation details .
 */
class category extends Database {

    /**
     * function category
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function category() {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function CategoryDropDownList
     *
     * This function is used to display the CategoryDropDownList deatails.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string $arrRows
     *
     * User instruction: $objCategory->CategoryDropDownList()
     */
    function CategoryDropDownList() {
        $arrClms = array('pkCategoryId', 'CategoryName', 'CategoryParentId');
        $varWhr = 'CategoryParentId = 0 AND CategoryIsDeleted=0 ';
        $arrRes = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
        $arrRows = array('0' => 'Root Category');

        foreach ($arrRes as $v) {
            $arrRows[$v['pkCategoryId']] = '&nbsp;&nbsp;&nbsp;' . $v['CategoryName'];
            $varWhr = 'CategoryParentId = ' . $v['pkCategoryId'] . " AND CategoryIsDeleted=0 ";

            $arr = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
            foreach ($arr as $sv) {
                $arrRows[$sv['pkCategoryId']] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $sv['CategoryName'];
            }
        }
        //pre($arrRows);
        return $arrRows;
    }

    /**
     * function CategoryList
     *
     * This function is used to display the CategoryList deatails.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRows
     *
     * User instruction: $objCategory->CategoryList($argWhere = '', $argLimit = '')
     */
    function CategoryList($argWhere = '', $argLimit = '') {

        $arrClms = array('c.pkCategoryId', 'c.CategoryName', 'c.CategoryDescription', 'c.CategoryOrdering', 'c.CategoryParentId', 'p.CategoryName as CategoryParentName', 'c.CategoryStatus', 'c.CategoryLevel');
        //$varOrderBy = 'c.CategoryName ASC ';
        // $this->getSortColumn($_REQUEST);
        if (isset($_GET['frmTrashPressed'])) {
            $varOrderBy = 'c.CategoryName ASC';
        } else {
            $varOrderBy = 'c.CategoryLevel ASC,c.CategoryOrdering ASC, c.CategoryHierarchy ASC,c.CategoryName ASC';
        }
        $varTable = TABLE_CATEGORY . ' as c LEFT JOIN ' . TABLE_CATEGORY . ' as p ON c.CategoryParentId=p.pkCategoryId';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function catgoryExportList
     *
     * This function is used to Export the Category List deatails.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     *
     * User instruction: $objCategory->catgoryExportList($argWhere = '', $argLimit = '') 
     */
    function catgoryExportList($argWhere = '', $argLimit = '') {
        $arrClms = array('c.pkCategoryId', 'c.CategoryName');
        $this->getSortColumn($_REQUEST);
        $varTable = TABLE_CATEGORY . ' as c';
        $arrRes['categoryDetails'] = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        foreach ($arrRes['categoryDetails'] as $val) {
            $parentArray[$val['pkCategoryId']] = $val['CategoryName'];
        }
        $arrClms = array('c.pkCategoryId', 'c.CategoryName', 'c.CategoryDescription', 'c.CategoryOrdering', 'c.CategoryParentId', 'p.CategoryName as CategoryParentName', 'c.CategoryHierarchy', 'c.CategoryMetaTitle', 'c.CategoryMetaKeywords', 'c.CategoryMetaDescription', 'c.CategoryStatus', 'c.CategoryLevel', 'c.CategoryDateAdded', 'c.CategoryDateModified');
        //$varOrderBy = 'c.CategoryName ASC ';
        $this->getSortColumn($_REQUEST);
        $varTable = TABLE_CATEGORY . ' as c LEFT JOIN ' . TABLE_CATEGORY . ' as p ON c.CategoryParentId=p.pkCategoryId';
        $arrRes['categoryDetails'] = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        $count = 0;
        foreach ($arrRes['categoryDetails'] as $pk => $val) {
            $arrPar = explode(":", $val['CategoryHierarchy']);
            $parents = count($arrPar) - 1;
            $cnt = 0;
            if ($parents > 0) {
                foreach ($arrPar as $k => $v) {
                    if ($k < 3) {
                        if ($cnt < $parents) {
                            $arrRes['categoryDetails'][$pk]['parent_' . $k] = $parentArray[$v];
                        }
                    }
                    $cnt++;
                }
            }

            $count++;
        }
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function checkExistsCategory
     *
     * This function is used to add Category List deatails.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     *
     * User instruction: $objCategory->addCategory($arrPost)
     */
    function checkExistsCategory($catName = '') {
        $varWhere = "CategoryName = '" . addslashes($catName) . "' ";
        $arrCategoryRow = $this->select(TABLE_CATEGORY, array('pkCategoryId', 'CategoryIsDeleted'), $varWhere);
        if (count($arrCategoryRow) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function checkEditExistsCategory($catName = '', $cid = '') {
        $varWhere = "CategoryName = '" . addslashes($catName) . "' AND pkCategoryId<>'" . addslashes($cid) . "'";
        $arrCategoryRow = $this->select(TABLE_CATEGORY, array('pkCategoryId', 'CategoryIsDeleted'), $varWhere);
        if (count($arrCategoryRow) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * function addCategory
     *
     * This function is used to add Category List deatails.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     *
     * User instruction: $objCategory->addCategory($arrPost)
     */
    function addCategory($arrPost, $arrFiles) {

//        echo '<pre>';
//        print_r($arrPost);
//        pre($arrFiles);
        if ($arrPost['frmParentId'] > 0) {
            $varWhr = 'pkCategoryId=' . $arrPost['frmParentId'];
            $arrClm = array('CategoryLevel, CategoryHierarchy');
            $arrRes = $this->select(TABLE_CATEGORY, $arrClm, $varWhr);
//            $categoryLevel = $arrRes[0]['CategoryLevel'] + 1;
            $categoryLevel = $arrRes[0]['CategoryLevel'];
        } else {
            $categoryLevel = 0;
        }

        //$varWhere = "CategoryName = '" . addslashes($arrPost['frmName']) . "' and CategoryLevel=" . $categoryLevel;
        $varWhere = "CategoryName = '" . addslashes($arrPost['frmName']) . "' ";
        $varWhereNum = "and " . $varWhere;
        $varCategoryNum = $this->getNumRows(TABLE_CATEGORY, 'pkCategoryId', $varWhereNum);

        if ($varCategoryNum == 0) {
            $arrClms = array(
                'CategoryParentId' => $arrPost['frmParentId'],
                'CategoryName' => $arrPost['frmName'],
                'CategoryLevel' => $categoryLevel,
                'CategoryDescription' => $arrPost['frmCategoryDescription'],
                'CategoryOrdering' => $arrPost['frmCategoryOrdering'],
                'CategoryMetaTitle' => $arrPost['frmMetaTitle'],
                'CategoryMetaKeywords' => $arrPost['frmMetaKeywords'],
                'CategoryMetaDescription' => $arrPost['frmMetaDescription'],
                'CategoryDateAdded' => date(DATE_TIME_FORMAT_DB),
                'CategoryDateModified' => date(DATE_TIME_FORMAT_DB)
            );
            
             $varTable = TABLE_CATEGORY;
        $arrClms1 = array(
            'CategoryOrdering'
        );
        $argWhere1 = "CategoryOrdering ='" . $arrPost['frmCategoryOrdering'] . "'";
        $arrRes = $this->select($varTable, $arrClms1, $argWhere1);
        if (count($arrRes) == 0) {
             $arrAddID = $this->insert(TABLE_CATEGORY, $arrClms);

            $updClmn = array("CategoryHierarchy" => ($categoryLevel == 0 ? "" : $arrRes[0]['CategoryHierarchy'] . ":") . $arrAddID);
            $this->update(TABLE_CATEGORY, $updClmn, "`pkCategoryId` = '$arrAddID'");
            
            //Check that value is successfully inserted into database
            if ($arrAddID) {
                $varCategoryImageUrl = '';
                //Image will be upload only for the first and second lavel category
                if ($categoryLevel == 1) {
                    $varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category2/';
                    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category2/';
                } else if ($categoryLevel == 0) {
                    $varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category1/';
                    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category1/';
                }

                //Image will be upload only for the first and second lavel category
                if (!empty($arrFiles['frmCategoryImage']['name'])) {
                    $varCategoryImage = $this->imageUpload($arrFiles['frmCategoryImage'], $_GET['type'], $_GET['cid'], $varDirLocation, $categoryLevel);
                }
                //pre($varCategoryImageUrl);
                if (!empty($varCategoryImageUrl) && isset($varCategoryImage)) {
                    $arrImagesClms = array(
                        'fkCategoryId' => $arrAddID,
                        //Hemant - update $_GET['cid'] to  $arrAddID
//                        'fkCategoryId' => $_GET['cid'],
                        'categoryName' => $arrPost['frmName'],
                        'categoryImageUrl' => $varCategoryImageUrl,
                        'categoryImage' => $varCategoryImage,
                        'categoryImageAddDate' => 'now()',
                        'categoryImageUpdateDate' => 'now()'
                    );
                    $this->insert(TABLE_CATEGORY_IMAGES, $arrImagesClms);
                }
            }

            $arrClmsUpdate = array('id' => $arrAddID, 'name' => $arrPost['frmName'], 'action' => 'add', 'type' => 'category');
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

                    $varWhereTemplate = " EmailTemplateTitle= 'New category has been added' AND EmailTemplateStatus = 'Active' ";

                    $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                    $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                    $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                    $varPathImage = '';
                    $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                    $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                    $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                    $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $arrPost['frmName']);

                    $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                    // Calling mail function

                    $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                }
            }
            return $arrAddID;
          
        } else {
            return 'orderexist';
        }
           
        } else {
            $arrCategoryRow = $this->select(TABLE_CATEGORY, array('pkCategoryId', 'CategoryIsDeleted'), $varWhere);
            if ($arrCategoryRow[0]['CategoryIsDeleted'] == 1) {
                return 'trash';
            } else {
                return 'exist';
            }
        }
    }

    /**
     * function editCategory
     *
     * This function is used to edit Category.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrCategoryData
     *
     * User instruction: $objCategory->editCategory($argCategoryID)
     */
    function editCategory($argCategoryID) {
        $argID = 'pkCategoryId =' . $argCategoryID;
        
        

        $arrClms = array('pkCategoryId,categoryImage,categoryImageUrl,cat.CategoryName', 'CategoryDescription', 'CategoryParentId', 'CategoryOrdering', 'CategoryMetaTitle', 'CategoryMetaKeywords', 'CategoryMetaDescription', 'CategoryHierarchy');
        $varTable = TABLE_CATEGORY . ' as cat left join ' . TABLE_CATEGORY_IMAGES . ' as ima on  cat.pkCategoryId=ima.fkCategoryId';
        $arrCategoryData = $this->select($varTable, $arrClms, $argID);
        //echo '<pre>';print_r($arrMainNewsMediaData);die;
        //echo $varTable;
        //print_r($arrCategoryData);//die;
        return $arrCategoryData;
    }

    /**
     * function updateCategory
     *
     * This function is used to upadte Category.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrUpdateID
     *
     * User instruction: $objCategory->pdateCategory($arrPost)
     */
    function updateCategory($arrPost, $arrFiles) {
//        echo '<pre>';
//        print_r($arrPost);
//        pre($arrFiles);
        if ($arrPost['frmParentId'] > 0) {
            $varWhr = 'pkCategoryId=' . $arrPost['frmParentId'];
            $arrClm = array('CategoryLevel,CategoryHierarchy');
            $arrRes = $this->select(TABLE_CATEGORY, $arrClm, $varWhr);
            //pre($arrRes);
            //$categoryLevel = $arrRes[0]['CategoryLevel'] + 1;
            $categoryLevel = $arrRes[0]['CategoryLevel'];
        } else {
            $categoryLevel = 0;
        }

        //$varWere = " CategoryName = '" . addslashes($arrPost['frmName']) . "' and CategoryLevel=" . $categoryLevel . ' and pkCategoryId!=' . $_GET['cid'];        

        $varWere = " CategoryName = '" . addslashes($arrPost['frmName']) . "' AND pkCategoryId!='" . $_GET['cid'] . "' ";

        $varWereNum = "AND " . $varWere;
        $arrCategoryNum = $this->getNumRows(TABLE_CATEGORY, 'pkCategoryId', $varWereNum);

        $varOWhr = 'pkCategoryId=' . $_GET['cid'];
        $arrOClm = array('CategoryLevel, CategoryHierarchy');
        $arrORes = $this->select(TABLE_CATEGORY, $arrOClm, $varOWhr);

        $levelInc = $categoryLevel - $arrORes['0']['CategoryLevel'];

        if ($arrCategoryNum == 0) {
            $varWhr = 'pkCategoryId = ' . $_GET['cid'];
            $varHierarchy = ($categoryLevel == 0 ? "" : $arrRes[0]['CategoryHierarchy'] . ":") . $_GET['cid'];
            $arrClms = array(
                'CategoryParentId' => $arrPost['frmParentId'],
                'CategoryName' => $arrPost['frmName'],
                'CategoryLevel' => $categoryLevel,
                'CategoryDescription' => $arrPost['frmCategoryDescription'],
                'CategoryOrdering' => $arrPost['frmCategoryOrdering'],
                'CategoryMetaTitle' => $arrPost['frmMetaTitle'],
                'CategoryMetaKeywords' => $arrPost['frmMetaKeywords'],
                'CategoryMetaDescription' => $arrPost['frmMetaDescription'],
                'CategoryDateModified' => date(DATE_TIME_FORMAT_DB),
                'CategoryHierarchy' => $varHierarchy
            );
            
             $varTable = TABLE_CATEGORY;
        $arrClmst = array('pkCategoryId', 'CategoryOrdering');
        $argWheret = "pkCategoryId ='" . $_GET['cid'] . "' and CategoryOrdering='" . $arrPost['frmCategoryOrdering'] . "'";
        $arrRes = $this->select($varTable, $arrClmst, $argWheret);
//            echo $key;
//            echo count($arrRes);
        if (count($arrRes) == 0) {
              $varTable = TABLE_CATEGORY;
        $arrClms1 = array(
            'CategoryOrdering'
        );
        $argWhere1 = "CategoryOrdering ='" . $arrPost['frmCategoryOrdering'] . "'";
        $arrRes = $this->select($varTable, $arrClms1, $argWhere1);
        if (count($arrRes) == 0) {
             $arrUpdateID = $this->update(TABLE_CATEGORY, $arrClms, $varWhr);
            //Check that successfully updated or not
            if ($arrUpdateID) {
                $varCategoryImageUrl = '';
                $varWhrImage = 'fkCategoryId = ' . $_GET['cid'];
                //Image will be upload only for the first and second lavel category
                if ($categoryLevel == 1) {
                    $varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category2/';
                    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category2/';
                } else if ($categoryLevel == 0) {
                    $varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category1/';
                    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category1/';
                }
                /* This condition is uploadeed image when category level is excepted 0 or 1
                 * 
                 * @author : Krishna Gupta
                 * @date : Oct. 01, 2015
                 *  */
//                else{
//                	$varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category1/';
//                	$varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category1/';
//                }
                
                //Image will be upload only for the first and second lavel category
                if (!empty($arrFiles['frmCategoryImage']['name'])) {
                    $varCategoryImage = $this->imageUpload($arrFiles['frmCategoryImage'], $_GET['type'], $_GET['cid'], $varDirLocation, $categoryLevel);
                
                }
//                pre($varCategoryImageUrl);
                if (!empty($varCategoryImageUrl) && isset($varCategoryImage)) {
                    $arrImagesClms = array(
                        'fkCategoryId' => $_GET['cid'],
                        'categoryName' => $arrPost['frmName'],
                        'categoryImageUrl' => $varCategoryImageUrl,
                        'categoryImage' => $varCategoryImage,
                        'categoryImageAddDate' => 'now()',
                        'categoryImageUpdateDate' => 'now()'
                    );
                    //Check for image existance.                    
                    $varCheckExistImage = $this->select(TABLE_CATEGORY_IMAGES, array('pkCategoryImageId'), $varWhrImage);
                    if (count($varCheckExistImage) > 0)
                        $this->update(TABLE_CATEGORY_IMAGES, $arrImagesClms, $varWhrImage);
                    else
                        $this->insert(TABLE_CATEGORY_IMAGES, $arrImagesClms);
                }
            }
            $arrUpdateMID = $this->query("update " . TABLE_CATEGORY . " set `CategoryLevel` = `CategoryLevel`+$levelInc, `CategoryHierarchy` = REPLACE(`CategoryHierarchy`, '" . $arrORes['0']['CategoryHierarchy'] . ":', '" . $varHierarchy . ":') where `CategoryHierarchy` LIKE '" . $arrORes['0']['CategoryHierarchy'] . ":%'");


            $arrClmsUpdate = array('id' => $_GET['cid'], 'name' => $arrPost['frmName'], 'action' => 'edit', 'type' => 'category');
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

                    $varWhereTemplate = " EmailTemplateTitle= 'Category has been updated' AND EmailTemplateStatus = 'Active' ";

                    $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                    $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                    $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                    $varPathImage = '';
                    $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                    $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                    $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                    $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $arrPost['frmName']);

                    $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                    // Calling mail function

                    $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                }
            }

            return $arrUpdateID;
           
        } else {
            return 'ordrexit';
        }

           
        }
        else
        {
             $arrUpdateID = $this->update(TABLE_CATEGORY, $arrClms, $varWhr);
            //Check that successfully updated or not
            if ($arrUpdateID) {
                $varCategoryImageUrl = '';
                $varWhrImage = 'fkCategoryId = ' . $_GET['cid'];
                //Image will be upload only for the first and second lavel category
                if ($categoryLevel == 1) {
                    $varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category2/';
                    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category2/';
                } else if ($categoryLevel == 0) {
                    $varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category1/';
                    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category1/';
                }
                /* This condition is uploadeed image when category level is excepted 0 or 1
                 * 
                 * @author : Krishna Gupta
                 * @date : Oct. 01, 2015
                 *  */
//                else{
//                	$varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category1/';
//                	$varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category1/';
//                }
                
                //Image will be upload only for the first and second lavel category
                if (!empty($arrFiles['frmCategoryImage']['name'])) {
                    $varCategoryImage = $this->imageUpload($arrFiles['frmCategoryImage'], $_GET['type'], $_GET['cid'], $varDirLocation, $categoryLevel);
                
                }
//                pre($varCategoryImageUrl);
                if (!empty($varCategoryImageUrl) && isset($varCategoryImage)) {
                    $arrImagesClms = array(
                        'fkCategoryId' => $_GET['cid'],
                        'categoryName' => $arrPost['frmName'],
                        'categoryImageUrl' => $varCategoryImageUrl,
                        'categoryImage' => $varCategoryImage,
                        'categoryImageAddDate' => 'now()',
                        'categoryImageUpdateDate' => 'now()'
                    );
                    //Check for image existance.                    
                    $varCheckExistImage = $this->select(TABLE_CATEGORY_IMAGES, array('pkCategoryImageId'), $varWhrImage);
                    if (count($varCheckExistImage) > 0)
                        $this->update(TABLE_CATEGORY_IMAGES, $arrImagesClms, $varWhrImage);
                    else
                        $this->insert(TABLE_CATEGORY_IMAGES, $arrImagesClms);
                }
            }
            $arrUpdateMID = $this->query("update " . TABLE_CATEGORY . " set `CategoryLevel` = `CategoryLevel`+$levelInc, `CategoryHierarchy` = REPLACE(`CategoryHierarchy`, '" . $arrORes['0']['CategoryHierarchy'] . ":', '" . $varHierarchy . ":') where `CategoryHierarchy` LIKE '" . $arrORes['0']['CategoryHierarchy'] . ":%'");


            $arrClmsUpdate = array('id' => $_GET['cid'], 'name' => $arrPost['frmName'], 'action' => 'edit', 'type' => 'category');
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

                    $varWhereTemplate = " EmailTemplateTitle= 'Category has been updated' AND EmailTemplateStatus = 'Active' ";

                    $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                    $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                    $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                    $varPathImage = '';
                    $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                    $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                    $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                    $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $arrPost['frmName']);

                    $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                    // Calling mail function

                    $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                }
            }

            return $arrUpdateID;
          
        }
            
//             $varTable = TABLE_CATEGORY;
//        $arrClms1 = array(
//            'CategoryOrdering'
//        );
//        $argWhere1 = "CategoryOrdering ='" . $arrPost['frmCategoryOrdering'] . "'";
//        $arrRes = $this->select($varTable, $arrClms1, $argWhere1);
//        if (count($arrRes) == 0) {
//            $arrUpdateID = $this->update(TABLE_CATEGORY, $arrClms, $varWhr);
//            //Check that successfully updated or not
//            if ($arrUpdateID) {
//                $varCategoryImageUrl = '';
//                $varWhrImage = 'fkCategoryId = ' . $_GET['cid'];
//                //Image will be upload only for the first and second lavel category
//                if ($categoryLevel == 1) {
//                    $varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category2/';
//                    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category2/';
//                } else if ($categoryLevel == 0) {
//                    $varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category1/';
//                    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category1/';
//                }
//                /* This condition is uploadeed image when category level is excepted 0 or 1
//                 * 
//                 * @author : Krishna Gupta
//                 * @date : Oct. 01, 2015
//                 *  */
////                else{
////                	$varCategoryImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category1/';
////                	$varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/category/main_category1/';
////                }
//                
//                //Image will be upload only for the first and second lavel category
//                if (!empty($arrFiles['frmCategoryImage']['name'])) {
//                    $varCategoryImage = $this->imageUpload($arrFiles['frmCategoryImage'], $_GET['type'], $_GET['cid'], $varDirLocation, $categoryLevel);
//                
//                }
////                pre($varCategoryImageUrl);
//                if (!empty($varCategoryImageUrl) && isset($varCategoryImage)) {
//                    $arrImagesClms = array(
//                        'fkCategoryId' => $_GET['cid'],
//                        'categoryName' => $arrPost['frmName'],
//                        'categoryImageUrl' => $varCategoryImageUrl,
//                        'categoryImage' => $varCategoryImage,
//                        'categoryImageAddDate' => 'now()',
//                        'categoryImageUpdateDate' => 'now()'
//                    );
//                    //Check for image existance.                    
//                    $varCheckExistImage = $this->select(TABLE_CATEGORY_IMAGES, array('pkCategoryImageId'), $varWhrImage);
//                    if (count($varCheckExistImage) > 0)
//                        $this->update(TABLE_CATEGORY_IMAGES, $arrImagesClms, $varWhrImage);
//                    else
//                        $this->insert(TABLE_CATEGORY_IMAGES, $arrImagesClms);
//                }
//            }
//            $arrUpdateMID = $this->query("update " . TABLE_CATEGORY . " set `CategoryLevel` = `CategoryLevel`+$levelInc, `CategoryHierarchy` = REPLACE(`CategoryHierarchy`, '" . $arrORes['0']['CategoryHierarchy'] . ":', '" . $varHierarchy . ":') where `CategoryHierarchy` LIKE '" . $arrORes['0']['CategoryHierarchy'] . ":%'");
//
//
//            $arrClmsUpdate = array('id' => $_GET['cid'], 'name' => $arrPost['frmName'], 'action' => 'edit', 'type' => 'category');
//            $arrClmsUpdateReturn = $this->insert(TABLE_UPDATE_CATEGORY_ATTR_SHIPPING, $arrClmsUpdate);
//
//            $sendUpdateToWholesaler = array('pkWholesalerID', 'CompanyEmail', 'CompanyName');
//            $whrereSendUpdateToWholesaler = "WholesalerAPIKey<>''";
//            $sendUpdateToWholesalerReturn = $this->select(TABLE_WHOLESALER, $sendUpdateToWholesaler, $whrereSendUpdateToWholesaler);
//            if (count($sendUpdateToWholesalerReturn) > 0) {
//
//                foreach ($sendUpdateToWholesalerReturn as $key => $whlMail) {
//
//                    $objTemplate = new EmailTemplate();
//                    $objCore = new Core();
//
//                    $varUserName = trim(strip_tags($whlMail['CompanyName']));
//                    $varPassword = trim(strip_tags($arrPost['frmPassword']));
//                    //pre($varUserName);
//                    $varToUser = $whlMail['CompanyEmail']; //'raju.khatak@mail.vinove.com';
//
//                    $varFromUser = $_SESSION['sessAdminEmail'];
//
//                    $varSiteName = SITE_NAME;
//
//                    $varWhereTemplate = " EmailTemplateTitle= 'Category has been updated' AND EmailTemplateStatus = 'Active' ";
//
//                    $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
//
//                    $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
//
//                    $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));
//
//                    $varPathImage = '';
//                    $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
//
//                    $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));
//
//                    $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');
//
//                    $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $arrPost['frmName']);
//
//                    $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
//
//                    // Calling mail function
//
//                    $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
//                }
//            }
//
//            return $arrUpdateID;
//            
//        } else {
//            return 'ordrexit';
//        }
            
        } else {
            $arrCategoryRow = $this->select(TABLE_CATEGORY, array('pkCategoryId', 'CategoryIsDeleted'), $varWhere);
            if ($arrCategoryRow[0]['CategoryIsDeleted'] == 1) {
                return 'trash';
            } else {
                return 'exist';
            }
        }
    }

    /**
     * function updateCategoryStatus
     *
     * This function is used to update Category Status.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrUpdateID
     *
     * User instruction: $objCategory->updateCategoryStatus($argPost) 
     */
    function updateCategoryStatus($argPost) {
        global $objGeneral;

        $varWhr = 'pkCategoryId = ' . $argPost['catid'];
        $arrClms = array(
            'CategoryStatus' => $argPost['status'],
            'CategoryDateModified' => date(DATE_TIME_FORMAT_DB)
        );

        if ($argPost['status'] == 0) {
            $objGeneral->solrProductRemoveAdd("fkCategoryID= '" . $argPost['catid'] . "'");
        }
        $arrUpdateID = $this->update(TABLE_CATEGORY, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function removeCategory
     *
     * This function is used to remove Category.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $varAffected
     *
     * User instruction: $objCategory->removeCategory($argPostIDs,$argSelect='')
     */
    function removeCategory($argPostIDs, $argSelect = '') {


        global $objGeneral;

        if ($argSelect == "") {
            if ($argPostIDs['frmID'] > 0) {

                $varWhr = 'pkCategoryId =' . $argPostIDs['frmID'];
                $arrClm = array('CategoryHierarchy');
                $arrRes = $this->select(TABLE_CATEGORY, $arrClm, $varWhr);

                $varWhereSdelete = "CategoryHierarchy LIKE '" . $arrRes[0]['CategoryHierarchy'] . "%' ";
                $arrClms = array('CategoryIsDeleted' => '1', 'CategoryDateModified' => date(DATE_TIME_FORMAT_DB));
                $varAffected = $this->update(TABLE_CATEGORY, $arrClms, $varWhereSdelete);

                $objGeneral->solrProductRemoveAdd("fkCategoryID='" . $argPostIDs['frmID'] . "'");

                $arrClmsUpdate = array('id' => $argPostIDs['frmID'], 'name' => $argPostIDs['name'], 'action' => 'delete', 'type' => 'category');
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

                        $varWhereTemplate = " EmailTemplateTitle= 'Category has been moved to trash' AND EmailTemplateStatus = 'Active' ";

                        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                        $varPathImage = '';
                        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                        $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                        $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $argPostIDs['name']);

                        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                        // Calling mail function

                        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                    }
                }
            }
        } else {
            foreach ($argPostIDs['frmID'] as $key => $varDeleteID) {
                $varWhr = 'pkCategoryId =' . $varDeleteID;
                $arrClm = array('CategoryHierarchy');
                $arrRes = $this->select(TABLE_CATEGORY, $arrClm, $varWhr);
                $varWhereSdelete = "CategoryHierarchy LIKE '" . $arrRes[0]['CategoryHierarchy'] . "%' ";
                $arrClms = array('CategoryIsDeleted' => '1', 'CategoryDateModified' => date(DATE_TIME_FORMAT_DB));
                $varAffected = $this->update(TABLE_CATEGORY, $arrClms, $varWhereSdelete);
                $objGeneral->solrProductRemoveAdd("fkCategoryID='" . $varDeleteID . "'");

                $arrClmsUpdate = array('id' => $varDeleteID, 'name' => $argPostIDs['catName'][$key], 'action' => 'delete', 'type' => 'category');
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

                        $varWhereTemplate = " EmailTemplateTitle= 'Category has been moved to trash' AND EmailTemplateStatus = 'Active' ";

                        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                        $varPathImage = '';
                        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                        $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                        $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $argPostIDs['catName'][$key]);

                        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                        // Calling mail function

                        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                    }
                }
            }
        }



        return $varAffected;
    }

    /**
     * function restoreCategory
     *
     * This function is used to restore Category.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varAffected
     *
     * User instruction: $objCategory->restoreCategory($argPostIDs) 
     */
    function restoreCategory($argPostIDs) {
        if ($argPostIDs['frmID'] > 0) {
            $varWhr = 'pkCategoryId =' . $argPostIDs['frmID'];
            $arrClm = array('CategoryParentId, CategoryHierarchy');
            $arrRes = $this->select(TABLE_CATEGORY, $arrClm, $varWhr);


            /* $varQuery = "SELECT ssc.pkCategoryId as sscid,sc.pkCategoryId as scid,c.pkCategoryId as cid FROM ".TABLE_CATEGORY." as ssc left join ".TABLE_CATEGORY." as sc on ssc.CategoryParentId = sc.pkCategoryId left join ".TABLE_CATEGORY." as c on sc.CategoryParentId = c.pkCategoryId where ssc.pkCategoryId =".$argPostIDs['frmID'];
              $arrCate = $this->getArrayResult($varQuery);


              $arrIds = array();
              foreach($arrCate as $k=>$val){
              foreach($val as $v){
              if($v<>''){ array_push($arrIds,(int)$v); }
              }
              }
              $arrIds = array_unique($arrIds);
              $varIds = implode(',', $arrIds);
             */

            //pre($arrRes);
            if ($arrRes['0']['CategoryParentId'] == 0) {
                $varWhereSdelete = "pkCategoryID = " . $argPostIDs['frmID'];
            } else {
                $varWhereSdelete = "pkCategoryID IN (" . str_replace(':', ',', $arrRes['0']['CategoryHierarchy']) . ") ";
            }
            $arrClms = array('CategoryIsDeleted' => '0', 'CategoryDateModified' => date(DATE_TIME_FORMAT_DB));
            $varAffected = $this->update(TABLE_CATEGORY, $arrClms, $varWhereSdelete);


            $arrClmsUpdate = array('id' => $argPostIDs['frmID'], 'name' => $argPostIDs['name'], 'action' => 'edit', 'type' => 'category');
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

                    $varWhereTemplate = " EmailTemplateTitle= 'Category has been moved from trash to main' AND EmailTemplateStatus = 'Active' ";

                    $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                    $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                    $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                    $varPathImage = '';
                    $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                    $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                    $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{NAME}', '{SITE_NAME}', '{CATEGORY_NAME}');

                    $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, SITE_NAME, $argPostIDs['name']);

                    $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                    // Calling mail function

                    $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
                }
            }

            return $varAffected;
        }
    }

    /**
     * function updateHierarchy
     *
     * This function is used to update Hierarchy.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string ''
     *
     * User instruction: $objCategory->updateHierarchy($parentId, $catId)
     */
    function updateHierarchy($parentId, $catId) {
        if ($parentId > 0) {
            $varWhr = "pkCategoryId ='$parentId' ";
            $arrClm = array('CategoryParentId, CategoryHierarchy');
            $arrRes = $this->select(TABLE_CATEGORY, $arrClm, $varWhr);

            $arrClms = array('CategoryHierarchy' => $arrRes[0]['CategoryHierarchy'] . ":" . $catId);
            $varAffected = $this->update(TABLE_CATEGORY, $arrClms, "pkCategoryId='$catId' AND CategoryLevel = '2'");
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
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'pkCategoryId';
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
        $objOrder->addColumn('Category Name', '');
        // $objOrder->addColumn('Description', '', '', 'hidden-1024');
        //$objOrder->addColumn('Parent Category Name', '', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function editCategory
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string, string(optional)
     *
     * @return string $stringMessage
     */
    function updateCategoryOrder($argPost) {
//        $count = 0;
//        foreach ($argPost['order'] as $valOrder) {
//            $argWhere = 'pkCategoryId =' . $argPost['orderId'][$count];
//            $arrClms = array(
//                'CategoryOrdering' => $valOrder
//            );
//            $varTable = TABLE_CATEGORY;
//            $this->update($varTable, $arrClms, $argWhere);
//            $count++;
//        }
//        return true;
         $message_order = array();
        $count = 0;
        $count1 = 0;
       pre($argPost);
        foreach ($argPost['order'] as $key => $valOrder) {
            // $valOrder;
            // $argPost['orderId'][$key];
            $varTable = TABLE_CATEGORY;
            $arrClms = array('pkCategoryId', 'CategoryOrdering');
            $argWhere = "pkCategoryId ='" . $argPost['orderId'][$key] . "' and CategoryOrdering='" . $valOrder . "'";
            $arrRes = $this->select($varTable, $arrClms, $argWhere);
           
//            echo $key;
//            echo count($arrRes);
            if (count($arrRes) == 0) {
//                if(!empty($argPost['CategoryParentId']))
//                {
                    $varWheree = "CategoryParentId = '" . $argPost['CategoryParentId'] . "' ";
        $arrCategoryRow = $this->select(TABLE_CATEGORY, array('CategoryLevel'), $varWheree,'','','',true);
        pre($arrCategoryRow);
        $category_level= $arrCategoryRow[0];
        pre($category_level);
//                }
//                else
//                {
//                    $category_level= 0;
//                }
                
               // $category_level=findcatLavel();
                $varTable = TABLE_CATEGORY;
                $argWhere = "CategoryOrdering ='" . $valOrder . "'and CategoryParentId='".$argPost['CategoryParentId']."'";
                //pre($argWhere);
                $argWhere1 = "pkCategoryId ='" . $argPost['orderId'][$key] . "'";
                $arrClms1 = array(
                    'CategoryOrdering'
                );
                $arrClms2 = array(
                    'CategoryOrdering' => $valOrder
                );

                $arrRes1 = $this->select($varTable, $arrClms1, $argWhere);
                 //pre($arrRes1);
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

    /**
     *
     * Function Name : imageUpload
     *
     * Return type : string
     *
     * Date created : 10th March 2014
     *
     * Date last modified :  10th March 2014
     *
     * Author : Suraj Kumar Maurya
     *
     * Last modified by : Suraj Kumar Maurya
     *
     * Comments : This function store image and return stored image name.
     *
     * User instruction : $this->imageUpload();
     *
     */
    function imageUpload($argFILES, $argType, $argId, $varDirLocation, $categoryLavel) {
        $objCore = new Core();
        $objUpload = new upload();
        
        //echo $varDirLocation;die;

        $infoExt = pathinfo($argFILES['name']);
        $arrName = basename($argFILES['name'], '.' . $infoExt['extension']);
        $ImageName = preg_replace('/\s\s+/', '_', $arrName);
        $ImageName = date('Ymd_his') . '_' . rand() . '.' . $infoExt['extension'];
        $objUpload->setMaxSize();

        // Set Directory
        $objUpload->setDirectory($varDirLocation);
        // CHECKING FILE TYPE.
        $varIsImage = $objUpload->IsImageValid($argFILES['type']);

        if ($varIsImage) {
            $varImageExists = 'yes';
        } else {
            $varImageExists = 'no';
        }

        if ($varImageExists == 'no') {
            $objCore->setErrorMsg("Invalid Image, Use image formats : jpg, png, gif");
            if ($argType == 'add') {
//                header('location:category_add_uil.php?type=' . $argType);
                header('location:category_edit_uil.php?type=' . $argType . '&cid=' . $argId);
                die;
            } else if ($argType == 'edit') {
                header('location:category_edit_uil.php?type=' . $argType . '&cid=' . $argId);
                die;
            }
        }

        if ($argFILES['error'] != 0) {
            $objCore->setErrorMsg('File upload error. Kindly try again.');
            if ($argType == 'add') {
//                header('location:category_add_uil.php?type=' . $argType);
                header('location:category_edit_uil.php?type=' . $argType . '&cid=' . $argId);
                die;
            } else if ($argType == 'edit') {
                header('location:category_edit_uil.php?type=' . $argType . '&cid=' . $argId);
                die;
            }
        } else if (trim($argFILES['size']) > 5242880) {
            $varError = true;
            $objCore->setErrorMsg('File size exceeds the given limit of 5 MB.');
            if ($argType == 'add') {
//                header('location:category_add_uil.php?type=' . $argType);
                header('location:category_edit_uil.php?type=' . $argType . '&cid=' . $argId);
                die;
            } else if ($argType == 'edit') {
                header('location:category_edit_uil.php?type=' . $argType . '&cid=' . $argId);
                die;
            }
        }
        if ($varImageExists == 'yes') {        	
            $objUpload->setTmpName($argFILES['tmp_name']);
            if ($objUpload->userTmpName) {
                $objUpload->setFileSize($argFILES['size']);
                // Set File Type
                $objUpload->setFileType($argFILES['type']);

                $varRand = rand();
                // Set File Name
                $fileName = strtolower($ImageName);
                $objUpload->setFileName($fileName);
                // Start Copy Process
                $objUpload->startCopy();
                // If there is error write the error message
               
                if ($objUpload->isError()) {
                    // resizing the file
                    $objUpload->resize();
                    $varFileName = $objUpload->userFileName;

                    if ($categoryLavel == 1) {
                        $objUpload->setThumbnailName('186x293/');
                        $objUpload->createThumbnail();
                        $objUpload->setThumbnailSize('186', '293');
                    } else if ($categoryLavel == 0) {
                        $objUpload->setThumbnailName('345x308/');
                        $objUpload->createThumbnail();
                        $objUpload->setThumbnailSize('345', '308');
                    }
                    //Get file extention
                    $varExt = substr(strrchr($varFileName, "."), 1);
                    $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));
                    //Create thumb file name
                    $varThumbFileName = $varThumbFileNameNoExt . '.' . $varExt;
                    return $varFileName;
                } else {
                    return 'image upload faield';
                }
            }
        }
    }

    /**
     * function findcatLavel
     *
     * This function is used to find the selected category lavel.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     *
     * User instruction: $objCategory->addCategory($arrPost)
     */
    function findcatLavel($catID = '') {
        $varWhere = "pkCategoryId = '" . $catID . "' ";
        $arrCategoryRow = $this->select(TABLE_CATEGORY, array('CategoryLevel'), $varWhere);
        return $arrCategoryRow[0];
    }
    
    
    

}

?>
