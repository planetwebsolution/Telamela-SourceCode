<?php

/**
 * 
 * Class name : Product
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The Paypal_email class is used to maintain Paypal_email infomation details for several modules.
 */
class Product extends Database {

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
     * function CategoryFullDropDownList
     *
     * This function is used to display the Category DropDown List.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRows
     *
     * User instruction: $objProduct->CategoryFullDropDownList()
     */
    function CategoryFullDropDownList() {
        $arrClms = array('pkCategoryId', 'CategoryName', 'CategoryParentId');
        $varWhr = 'CategoryParentId=0 AND CategoryIsDeleted=0 ';
        $arrRes = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
        $arrRows = array();

        foreach ($arrRes as $v) {
            $arrRows[$v['pkCategoryId']] = $v['CategoryName'];
            $varWhr = 'CategoryParentId = ' . $v['pkCategoryId'] . " AND CategoryIsDeleted=0";

            $arr = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
            foreach ($arr as $sv) {
                $arrRows[$sv['pkCategoryId']] = '&nbsp;&nbsp;&nbsp;' . $sv['CategoryName'];
                $varWhr = 'CategoryParentId = ' . $sv['pkCategoryId'] . ' AND CategoryIsDeleted=0';
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
     * function WholesalerFullDropDownList
     *
     * This function is used to display the Wholesaler Full DropDown List.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->WholesalerFullDropDownList($varPortalFilter)
     */
    function WholesalerFullDropDownList($varPortalFilter) {
        $arrClms = array('pkWholesalerID', 'CompanyName');
        $varWhr = "WholesalerStatus IN ('active','deactive','suspend') " . $varPortalFilter;
        $varOrderBy = ' CompanyName ASC ';
        $arrRes = $this->select(TABLE_WHOLESALER, $arrClms, $varWhr, $varOrderBy);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function WholesalerShippingGatwaysList
     *
     * This function is used to display the Wholesaler ShippingGatways List.
     *
     * Database Tables used in this function are : tbl_shipping_gateways, tbl_wholesaler_to_shipping_gateway
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->WholesalerShippingGatwaysList($argWhr) 
     */
    function WholesalerShippingGatwaysList($argWhr) {
        $arrClms = array('pkShippingGatewaysID', 'ShippingTitle');
        $varOrderBy = 'ShippingTitle ASC ';
        $varWhr = "";
        $varTbl = TABLE_WHOLESALER_TO_SHIPPING_GATEWAY . " INNER JOIN " . TABLE_SHIPPING_GATEWAYS . " ON (fkShippingGatewaysID=pkShippingGatewaysID AND fkWholesalerID = '" . $argWhr . "' AND ShippingStatus = 1)";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy);

        if (!$arrRes) {
            $arrRes = $this->select(TABLE_SHIPPING_GATEWAYS, $arrClms, "ShippingStatus = 1 ", $varOrderBy);
        }

        return $arrRes;
    }

    /**
     * function countryList
     *
     * This function is used to display the country List.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->countryList() 
     */
    function countryList() {
        $arrClms = array('country_id', 'name');
        $varWhr = '1 ';
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms, $varWhr, $varOrderBy);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function WholesalerListBYCountry
     *
     * This function is used to display the Wholesaler List BY Country.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->WholesalerListBYCountry($varPortalFilter)
     */
    function WholesalerListBYCountry($varPortalFilter) {
        $arrClms = array('pkWholesalerID', 'CompanyName');
        $varWhere = "WholesalerStatus IN ('active','deactive','suspend') " . $varPortalFilter;
        $varOrderBy = 'CompanyName ASC ';

        $arrRes = $this->select(TABLE_WHOLESALER, $arrClms, $varWhere, $varOrderBy);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function PackageFullDropDownList
     *
     * This function is used to display the Package Full DropDown List.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->PackageFullDropDownList($varPortalFilter = '') 
     */
    function PackageFullDropDownList($varPortalFilter = '') {
        $arrClms = array('pkPackageId', 'PackageName');
        $varWhr = " PackageStatus = '1' " . $varPortalFilter;
        $varOrderBy = 'PackageName ASC ';
        $arrRes = $this->select(TABLE_PACKAGE, $arrClms, $varWhr, $varOrderBy);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function ProductListForPackage
     *
     * This function is used to display the Product List For Package.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductListForPackage($argWhere = '', $argLimit = '') 
     */
    function ProductListForPackage($argWhere = '', $argLimit = '') {
        $arrClms = array(
            'pkProductID',
            'ProductRefNo',
            'ProductName',
            'FinalPrice'
        );
        $varOrderBy = 'pkProductID DESC';
        $varTable = TABLE_PRODUCT;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
        return $arrRes;
    }

    /**
     * function ProductPriceForPackage
     *
     * This function is used to display the Product Price For Package.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductPriceForPackage($argWhere = '', $argLimit = '')
     */
    function ProductPriceForPackage($argWhere = '', $argLimit = '') {
        $arrClms = array(
            'WholesalePrice',
            'FinalPrice'
        );
        $varOrderBy = 'pkProductID DESC';
        $varTable = TABLE_PRODUCT;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
        return $arrRes;
    }

    /**
     * function CountProductRefNo
     *
     * This function is used to display the Count Product Ref No.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrNum
     *
     * User instruction: $objProduct->CountProductRefNo($argWhere = '', $argLimit = '')
     */
    function CountProductRefNo($argWhere = '', $argLimit = '') {
        $arrClms = 'ProductRefNo';
        $varTable = TABLE_PRODUCT;
        $arrNum = $this->getNumRows($varTable, $arrClms, $argWhere);
        return $arrNum;
    }

    /**
     * function getImages
     *
     * This function is used to get images.
     *
     * Database Tables used in this function are : tbl_product_image
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->getImages($argpid)
     */
    function getImages($argpid) {
        $arrClms = array(
            'pkImageID',
            'ImageName'
        );
        $argWhere = 'fkProductID = ' . $argpid;
        $varOrderBy = 'ImageDateAdded DESC';
        $varTable = TABLE_PRODUCT_IMAGE;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
        return $arrRes;
    }

    /**
     * function deleteImage
     *
     * This function is used to delete images.
     *
     * Database Tables used in this function are : tbl_product_image
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varAffected
     *
     * User instruction: $objProduct->deleteImage($argImgId)
     */
    function deleteImage($argImgId) {
        $varWhereSdelete = " pkImageID = '" . $argImgId . "'";
        $varAffected = $this->delete(TABLE_PRODUCT_IMAGE, $varWhereSdelete);
        return $varAffected;
    }

    /**
     * function CategoryToAttribute
     *
     * This function is used to display Category To Attribute.
     *
     * Database Tables used in this function are : tbl_attribute_to_category, tbl_attribute, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRows
     *
     * User instruction: $objProduct->CategoryToAttribute($argcatid) 
     */
    function CategoryToAttribute($argcatid) {
        $arrClms = array('fkCategoryID', 'fkAttributeID');
        $varWhere = "fkCategoryid='" . $argcatid . "'";
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

            $arrClmsOpt = array('pkOptionID', 'OptionTitle', 'OptionImage');
            $varOrderByOpt = 'pkOptionID ASC';
            $varWherOpt = 'fkAttributeID = ' . $val['fkAttributeID'];
            $arrOpt = $this->select(TABLE_ATTRIBUTE_OPTION, $arrClmsOpt, $varWherOpt, $varOrderByOpt);
            $arrRows[$val['fkAttributeID']]['OptionsData'] = $arrOpt;
            $arrRows[$val['fkAttributeID']]['OptionsRows'] = count($arrOpt);
        }
        //pre($arrRows);
        return $arrRows;
    }

    /**
     * function ProductToOptions
     *
     * This function is used to display Product To Options.
     *
     * Database Tables used in this function are : tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function ProductToOptions($argpid) {
        $varSql = "SELECT GROUP_CONCAT(AttributeOptionValue) as optval,GROUP_CONCAT(fkAttributeOptionId) as optid,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice,GROUP_CONCAT(AttributeOptionValue SEPARATOR ';;') as AttributeOptionValue,GROUP_CONCAT(AttributeOptionImage) as optimg FROM " . TABLE_PRODUCT_TO_OPTION . " where fkProductId = '" . $argpid . "' GROUP BY fkProductId";
        $arrRes = $this->getArrayResult($varSql);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function productToAttributeOptions
     *
     * This function is used to display Product To Options.
     *
     * Database Tables used in this function are : tbl_attribute, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function productToAttributeOptions($argpid) {
        $varSql = "SELECT pkAttributeID,AttributeCode,AttributeLabel,AttributeInputType FROM " . TABLE_ATTRIBUTE . " INNER JOIN " . TABLE_PRODUCT_TO_OPTION . " ON (fkAttributeId = pkAttributeID AND fkProductId = '" . $argpid . "') GROUP BY fkAttributeId";
        $arrRes = $this->getArrayResult($varSql);
        $arrRows = array();

        $arrInputType = array('radio', 'image', 'checkbox', 'select','colorpicker');
        $i = 0;
        foreach ($arrRes as $key => $val) {
            if (in_array($val['AttributeInputType'], $arrInputType)) {
                $arrRows[$i] = $val;
                $arrRows[$i]['options'] = $this->getAttrOptions($argpid, $val['pkAttributeID']);
                $i++;
            }
        }
        return $arrRows;
    }

    /**
     * function productToAttributeOptionsQty
     *
     * This function is used to display Product To Options.
     *
     * Database Tables used in this function are : tbl_product_option_inventory
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function productToAttributeOptionsQty($argpid) {
        $varSql = "SELECT OptionIDs,OptionQuantity FROM " . TABLE_PRODUCT_OPTION_INVENTORY . " WHERE fkProductID = '" . $argpid . "'";
        $arrRes = $this->getArrayResult($varSql);
        $arrRows = array();
        foreach ($arrRes as $key => $val) {
            $arrRows[$val['OptionIDs']] = $val['OptionQuantity'];
        }
        //pre($arrRows);
        return $arrRows;
    }

    /**
     * function getAttrOptions
     *
     * This function is used to display Product To Options.
     *
     * Database Tables used in this function are : tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function getAttrOptions($argpid, $argaid) {
        $varSql = "SELECT pkProductAttributeId,fkAttributeOptionId,OptionExtraPrice,OptionIsDefault,AttributeOptionValue FROM " . TABLE_PRODUCT_TO_OPTION . " WHERE  fkAttributeId = '" . $argaid . "' AND fkProductId = '" . $argpid . "' ";
        $arrRes = $this->getArrayResult($varSql);
        return $arrRes;
    }

    /**
     * function showPackageProduct
     *
     * This function is used to display Package Product.
     *
     * Database Tables used in this function are : tbl_product_to_option, tbl_product, tbl_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->showPackageProduct($argpkg) 
     */
    function showPackageProduct($argpkg) {
        $argWhere = 'pkg.fkPackageId = ' . $argpkg;

        $arrClms = array(
            'pkProductID',
            'ProductRefNo',
            'ProductName',
            'FinalPrice',
            'PackagePrice'
        );
        $varOrderBy = 'fkProductId ASC';
        $varTable = TABLE_PRODUCT_TO_PACKAGE . ' as pkg INNER JOIN ' . TABLE_PRODUCT . ' as p ON  pkg.fkProductId = p.pkProductID inner join ' . TABLE_PACKAGE . ' on pkPackageId = pkg.fkPackageId';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
        //pre($arrRes);        
        return $arrRes;
    }

    /**
     * function RecentReviewProductList
     *
     * This function is used to display the Recent Review Product List.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_recent_view
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->RecentReviewProductList($argWhere = '', $argLimit = '') 
     */
    function RecentReviewProductList($argWhere = '', $argLimit = '') {

        $arrClms = array(
            'pkProductID', 'ProductRefNo', 'ProductName', 'CategoryName', 'CategoryIsDeleted', 'CompanyName', 'WholesalePrice', 'FinalPrice',
            'ProductStatus', 'pkRecentViewID', 'fkCustomerID', 'fkProductID', 'ViewDateAdded');
        // $varOrderBy = 'pkProductID DESC';
        $this->getSortColumn($_REQUEST);

        $varTable = TABLE_PRODUCT . ' LEFT JOIN ' . TABLE_CATEGORY . ' ON fkCategoryID=pkCategoryId LEFT JOIN ' . TABLE_WHOLESALER . ' ON fkWholesalerID = pkWholesalerID LEFT JOIN ' . TABLE_RECENT_VIEW . ' ON pkProductID=fkProductID';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);

        // Check this product will included in iny package or not for product delete 
//        foreach ($arrRes as $k => $val) {
//            $varSql = "SELECT distinct(fkPackageId) as pkgid FROM " . TABLE_PRODUCT_TO_PACKAGE . " where fkProductId = '" . $val['pkProductID'] . "' GROUP BY fkProductId";
//            $arrPTP = $this->getArrayResult($varSql);
//            $arrRes[$k]['pkgid'] = $arrPTP[0]['pkgid'];
//        }
        //pre($arrRes);        
        return $arrRes;
    }

    /**
     * function ProductList
     *
     * This function is used to display the Product List.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductList($argWhere = '', $argLimit = '')
     */
    function ProductList($argWhere = '', $argLimit = '') {
        $this->getSortColumn($_REQUEST);
        if ($argLimit != '') {
            $varCol = "pkProductID, ProductRefNo, ProductName, CategoryName, CategoryIsDeleted, CompanyName, WholesalePrice, FinalPrice, ProductStatus, count(ptp.fkPackageId) as pkgid, ptp.fkPackageId";
            $varTable = TABLE_PRODUCT . ' LEFT JOIN ' . TABLE_CATEGORY . ' ON fkCategoryID=pkCategoryId LEFT JOIN ' . TABLE_WHOLESALER . ' ON fkWholesalerID = pkWholesalerID LEFT JOIN ' . TABLE_PRODUCT_TO_PACKAGE . ' as ptp ON ptp.fkProductId=pkProductID';
            $varSql = "SELECT $varCol FROM $varTable " . ($argWhere != '' ? "WHERE $argWhere" : "") . " GROUP BY pkProductID ORDER BY " . $this->orderOptions . " LIMIT $argLimit";
            $arrRes = $this->getArrayResult($varSql);
        } else {
            $arrClms = array(
                'pkProductID'
            );
            $varTable = TABLE_PRODUCT . ' LEFT JOIN ' . TABLE_CATEGORY . ' ON fkCategoryID=pkCategoryId LEFT JOIN ' . TABLE_WHOLESALER . ' ON fkWholesalerID = pkWholesalerID ';
            $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        }
        // Check this product will included in iny package or not for product delete 
        /* if($argLimit!='')
          {
          $productsID='';
          foreach ($arrRes as $k => $val) {
          $productsID .= $val['pkProductID'] .",";
          }
          $productsID = trim($productsID,",");
          if($productsID!==''){
          $varSql = "SELECT distinct(fkPackageId) as pkgid FROM " . TABLE_PRODUCT_TO_PACKAGE . " where fkProductId IN($productsID) GROUP BY fkProductId";
          $arrPTP = $this->getArrayResult($varSql);
          /*pre($arrPTP);
          foreach ($arrRes as $k => $val) {
          $arrRes[$k]['pkgid'] = $arrPTP[0]['pkgid'];
          }
          }
          }
          pre($arrRes); */
        return $arrRes;
    }

    /**
     * function productExportList
     *
     * This function is used to display the Product Export List.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_image
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->productExportList($argWhere = '', $argLimit = '')
     */
    function productExportList($argWhere = '', $argLimit = '') {
        $varClms = "pkProductID,ProductRefNo,CompanyName,ProductName,ProductSliderImage,ProductImage,group_concat(ImageName) as ImageNames,CategoryName,fkShippingID,WholesalePrice,FinalPrice,DiscountPrice,DiscountFinalPrice,DateStart,DateEnd,Quantity,QuantityAlert,Weight,WeightUnit,Length,Width,Height,DimensionUnit,ProductDescription,ProductTerms,YoutubeCode,HtmlEditor,MetaTitle,MetaKeywords,MetaDescription,LastViewed,ProductDateAdded,ProductDateUpdated";

        $this->getSortColumn($_REQUEST);

        $varTable = TABLE_PRODUCT . ' LEFT JOIN ' . TABLE_CATEGORY . ' ON fkCategoryID=pkCategoryId LEFT JOIN ' . TABLE_WHOLESALER . ' ON fkWholesalerID = pkWholesalerID LEFT JOIN ' . TABLE_PRODUCT_IMAGE . " ON fkProductID=pkProductID ";

        $order = "GROUP BY fkProductID ORDER BY " . $this->orderOptions;
        $argLimit = ($argLimit <> '') ? " LIMIT " . $argLimit : " ";
        $argWhere = ($argWhere <> '') ? " WHERE " . $argLimit : " ";

        $varQuery = "SELECT " . $varClms . " FROM " . $varTable . " " . $argWhere . " " . $order . " " . $argLimit;
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function addProduct
     *
     * This function is used to add product list.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrAddID
     *
     * User instruction: $objProduct->addProduct($arrPost, $arrFileName)
     */
    function addProduct($arrPost, $arrFileName, $arrFileNameAttr) {

        $objCore = new Core();
        $varDateStart = $objCore->defaultDateTime($arrPost['frmDateStart'], DATE_FORMAT_DB);
        $varDateEnd = $objCore->defaultDateTime($arrPost['frmDateEnd'], DATE_FORMAT_DB);

        $IsFeatured = (isset($arrPost['frmIsFeatured'])) ? '1' : '0';
        $varWhereNum = "and ProductRefNo = '" . addslashes($arrPost['frmProductRefNo']) . "' ";
        $varRefNum = $this->getNumRows(TABLE_PRODUCT, 'ProductRefNo', $varWhereNum);
        $frmShippingGateway = implode(',', $arrPost['frmShippingGateway']);

        $varProductImage = $arrPost['default'];


        if ($varRefNum == 0) {
            $arrClms = array(
                'fkCategoryID' => $arrPost['frmfkCategoryID'],
                'ProductRefNo' => $arrPost['frmProductRefNo'],
                'fkWholesalerID' => $arrPost['frmfkWholesalerID'],
                'fkShippingID' => $frmShippingGateway,
                'ProductName' => $arrPost['frmProductName'],
                'ProductImage' => $varProductImage,
                'WholesalePrice' => $arrPost['frmWholesalePriceInUSD'],
                'FinalPrice' => $arrPost['frmProductPrice'],
                'DiscountPrice' => $arrPost['frmDiscountPriceInUSD'],
                'DiscountFinalPrice' => $arrPost['frmDiscountFinalPriceInUSD'],
                'DateStart' => $varDateStart,
                'DateEnd' => $varDateEnd,
                'Quantity' => $arrPost['frmQuantity'],
                'QuantityAlert' => $arrPost['frmQuantityAlert'],
                'Weight' => $arrPost['frmWeight'],
                'WeightUnit' => $arrPost['frmWeightUnit'],
                'Length' => $arrPost['frmLength'],
                'Width' => $arrPost['frmWidth'],
                'Height' => $arrPost['frmHeight'],
                'DimensionUnit' => $arrPost['frmDimensionUnit'],
                'fkPackageId' => $arrPost['frmfkPackageId'],
                'ProductDescription' => $arrPost['frmProductDescription'],
                'ProductTerms' => $arrPost['frmProductTerms'],
                'YoutubeCode' => $arrPost['frmYoutubeCode'],
                'HtmlEditor' => $arrPost['frmHtmlEditor'],
                'MetaTitle' => $arrPost['frmMetaTitle'],
                'MetaKeywords' => $arrPost['frmMetaKeywords'],
                'MetaDescription' => $arrPost['frmMetaDescription'],
                'IsFeatured' => $IsFeatured,
                'fkCreatedID' => $_SESSION['sessUser'],
                'LastViewed' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                'ProductDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $arrAddID = $this->insert(TABLE_PRODUCT, $arrClms);

            if ($arrAddID > 0) {
                //Insert Images for products
                if (isset($arrFileName)) {
                    foreach ($arrFileName as $valueImg) {
                        $arrClmsImg = array(
                            'fkProductID' => $arrAddID,
                            'ImageName' => $valueImg,
                            'ImageDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                        );
                        if ($valueImg <> '') {
                            $this->insert(TABLE_PRODUCT_IMAGE, $arrClmsImg);
                        }
                    }
                }



                // Add attribute for this products
                if (isset($arrPost['frmAttribute'])) {
                    foreach ($arrPost['frmAttribute'] as $keyAttr => $valueAttr) {
                        foreach ($valueAttr as $keyOpt => $valueOpt) {
                            $imgNm = isset($arrFileNameAttr[$valueOpt]['imgnm']) ? $arrFileNameAttr[$valueOpt]['imgnm'] : '';
                            $isImgUploaded = isset($arrFileNameAttr[$valueOpt]['isImgUploaded']) ? $arrFileNameAttr[$valueOpt]['isImgUploaded'] : 0;
                            $varOptionCaption = $arrPost['frmOptCaption'][$valueOpt];

                            $arrClmsOpt = array(
                                'fkProductId' => $arrAddID,
                                'fkAttributeId' => $keyAttr,
                                'fkAttributeOptionId' => $valueOpt,
                                'AttributeOptionValue' => $varOptionCaption,
                                'AttributeOptionImage' => $imgNm,
                                'IsImgUploaded' => $isImgUploaded
                            );

                            $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsOpt);
                        }
                    }
                }

                if (isset($arrPost['frmAttributeText'])) {
                    foreach ($arrPost['frmAttributeText'] as $keyTextOpt => $valuetextOpt) {
                        $atrOpt = explode('-', $keyTextOpt);

                        $arrClmsTextOpt = array(
                            'fkProductId' => $arrAddID,
                            'fkAttributeId' => $atrOpt[0],
                            'fkAttributeOptionId' => $atrOpt[1],
                            'AttributeOptionValue' => $valuetextOpt
                        );

                        $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextOpt);
                    }
                }
                if (isset($arrPost['frmAttributeTextArea'])) {

                    foreach ($arrPost['frmAttributeTextArea'] as $keyTextAreaOpt => $valuetextAreaOpt) {
                        $atrOpt = explode('-', $keyTextAreaOpt);

                        $arrClmsTextAreaOpt = array(
                            'fkProductId' => $arrAddID,
                            'fkAttributeId' => $atrOpt[0],
                            'fkAttributeOptionId' => $atrOpt[1],
                            'AttributeOptionValue' => $valuetextAreaOpt,
                        );
                        $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextAreaOpt);
                    }
                }
            }
            return $arrAddID;
        } else {
            return 0;
        }
    }

    /**
     * function addMultipleProduct
     *
     * This function is used to add multiple product list.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $i
     *
     * User instruction: $objProduct->addMultipleProduct($arrPost, $arrFileName) 
     */
    function addMultipleProduct($arrPost, $arrFileName, $arrFileNameAttr) {

        $objCore = new Core();
        $i = 0;
        $frmShippingGateway = implode(',', $arrPost['frmShippingGateway']);
        foreach ($arrPost['frmProductName'] as $key => $value) {

            $varWhereNum = "and ProductRefNo = '" . addslashes($arrPost['frmProductRefNo'][$key]) . "' ";
            $varRefNum = $this->getNumRows(TABLE_PRODUCT, 'ProductRefNo', $varWhereNum);

            if ($varRefNum == 0) {
                $i++;

                $varDateStart = $objCore->defaultDateTime($arrPost['frmDateStart'][$key], DATE_FORMAT_DB);
                $varDateEnd = $objCore->defaultDateTime($arrPost['frmDateEnd'][$key], DATE_FORMAT_DB);
                $IsFeatured = (isset($arrPost['frmIsFeatured'][$key])) ? '1' : '0';
                $varProductImage = $arrPost['default'][$i];

                $arrClms = array(
                    'fkCategoryID' => $arrPost['frmfkCategoryID'][$key],
                    'ProductRefNo' => $arrPost['frmProductRefNo'][$key],
                    'fkWholesalerID' => $arrPost['frmfkWholesalerID'],
                    'fkShippingID' => $frmShippingGateway,
                    'ProductName' => $arrPost['frmProductName'][$key],
                    'ProductImage' => $varProductImage,
                    'WholesalePrice' => $arrPost['frmWholesalePrice'][$key],
                    'FinalPrice' => $arrPost['frmProductPrice'][$key],
                    'DiscountPrice' => $arrPost['frmDiscountPrice'][$key],
                    'DiscountFinalPrice' => $arrPost['frmDiscountFinalPrice'][$key],
                    'DateStart' => $varDateStart,
                    'DateEnd' => $varDateEnd,
                    'Quantity' => $arrPost['frmQuantity'][$key],
                    'QuantityAlert' => $arrPost['frmQuantityAlert'][$key],
                    'Weight' => $arrPost['frmWeight'][$key],
                    'WeightUnit' => $arrPost['frmWeightUnit'][$key],
                    'Length' => $arrPost['frmLength'][$key],
                    'Width' => $arrPost['frmWidth'][$key],
                    'Height' => $arrPost['frmHeight'][$key],
                    'DimensionUnit' => $arrPost['frmDimensionUnit'][$key],
                    'fkPackageId' => $arrPost['frmfkPackageId'][$key],
                    'ProductDescription' => $arrPost['frmProductDescription'][$key],
                    'ProductTerms' => $arrPost['frmProductTerms'][$key],
                    'YoutubeCode' => $arrPost['frmYoutubeCode'][$key],
                    'HtmlEditor' => $arrPost['frmHtmlEditor'][$key],
                    'MetaTitle' => $arrPost['frmMetaTitle'][$key],
                    'MetaKeywords' => $arrPost['frmMetaKeywords'][$key],
                    'MetaDescription' => $arrPost['frmMetaDescription'][$key],
                    'IsFeatured' => $IsFeatured,
                    'fkCreatedID' => $_SESSION['sessUser'],
                    'LastViewed' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                    'ProductDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                    'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                );

                $arrAddID = $this->insert(TABLE_PRODUCT, $arrClms);

                if ($arrAddID > 0) {
                    //Add Images for products
                    if (isset($arrFileName)) {
                        foreach ($arrFileName[$i] as $kimg => $vimg) {

                            $arrClmsImg = array(
                                'fkProductID' => $arrAddID,
                                'ImageName' => $vimg,
                                'ImageDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                            );
                            if ($vimg <> '') {
                                $this->insert(TABLE_PRODUCT_IMAGE, $arrClmsImg);
                            }
                        }
                    }

                    // Add attribute for this products
                    if (isset($arrPost['frmAttribute'])) {
                        foreach ($arrPost['frmAttribute'][$key] as $keyAttr => $valueAttr) {
                            foreach ($valueAttr as $keyOpt => $valueOpt) {

                                $imgNm = isset($arrFileNameAttr[$key][$valueOpt]['imgnm']) ? $arrFileNameAttr[$key][$valueOpt]['imgnm'] : '';
                                $isImgUploaded = isset($arrFileNameAttr[$key][$valueOpt]['isImgUploaded']) ? $arrFileNameAttr[$key][$valueOpt]['isImgUploaded'] : 0;
                                $varOptionCaption = $arrPost['frmOptCaption'][$key][$valueOpt];

                                $arrClmsOpt = array(
                                    'fkProductId' => $arrAddID,
                                    'fkAttributeId' => $keyAttr,
                                    'fkAttributeOptionId' => $valueOpt,
                                    'AttributeOptionValue' => $varOptionCaption,
                                    'AttributeOptionImage' => $imgNm,
                                    'IsImgUploaded' => $isImgUploaded
                                );
                                $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsOpt);
                            }
                        }
                    }

                    if (isset($arrPost['frmAttributeText'][$key])) {
                        foreach ($arrPost['frmAttributeText'][$key] as $keyTextOpt => $valuetextOpt) {
                            $atrOpt = explode('-', $keyTextOpt);

                            $arrClmsTextOpt = array(
                                'fkProductId' => $arrAddID,
                                'fkAttributeId' => $atrOpt[0],
                                'fkAttributeOptionId' => $atrOpt[1],
                                'AttributeOptionValue' => $valuetextOpt
                            );

                            $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextOpt);
                        }
                    }
                    if (isset($arrPost['frmAttributeTextArea'][$key])) {

                        foreach ($arrPost['frmAttributeTextArea'][$key] as $keyTextAreaOpt => $valuetextAreaOpt) {
                            $atrOpt = explode('-', $keyTextAreaOpt);

                            $arrClmsTextAreaOpt = array(
                                'fkProductId' => $arrAddID,
                                'fkAttributeId' => $atrOpt[0],
                                'fkAttributeOptionId' => $atrOpt[1],
                                'AttributeOptionValue' => $valuetextAreaOpt,
                            );
                            $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextAreaOpt);
                        }
                    }
                }
            }
        }
        return $i;
    }

    /**
     * function editProduct
     *
     * This function is used to edit product.
     *
     * Database Tables used in this function are : tbl_product, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRow
     *
     * User instruction: $objProduct->editProduct($argID, $varPortalFilter)
     */
    function editProduct($argID, $varPortalFilter) {
        $varID = 'pkProductID =' . $argID . $varPortalFilter;
        $arrClms = array(
            'pkProductID',
            'fkCategoryID',
            'ProductRefNo',
            'fkWholesalerID',
            'fkShippingID',
            'CompanyCountry',
            'ProductName',
            'ProductImage',
            'ProductSliderImage',
            'WholesalePrice',
            'FinalPrice',
            'DiscountPrice',
            'DiscountFinalPrice',
            'DateStart',
            'DateEnd',
            'Quantity',
            'QuantityAlert',
            'Weight',
            'WeightUnit',
            'Length',
            'Width',
            'Height',
            'DimensionUnit',
            'fkPackageId',
            'ProductDescription',
            'ProductTerms',
            'YoutubeCode',
            'HtmlEditor',
            'MetaTitle',
            'MetaKeywords',
            'MetaDescription',
            'IsFeatured'
        );
        $varTable = TABLE_PRODUCT . ' LEFT JOIN ' . TABLE_WHOLESALER . ' ON  fkWholesalerID=pkWholesalerID ';
        $arrRow = $this->select($varTable, $arrClms, $varID);
        //echo '<pre>';print_r($arrMainNewsMediaData);die;
        return $arrRow;
    }

    /**
     * function viewProduct
     *
     * This function is used to view product.
     *
     * Database Tables used in this function are :  tbl_product, tbl_category, tbl_wholesaler, tbl_package, tbl_admin
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->viewProduct($argID, $varPortalFilter)
     */
    function viewProduct($argID, $varPortalFilter) {
        $argWhere = 'pkProductID =' . $argID . $varPortalFilter;
        $arrClms = array(
            'pkProductID',
            'fkCategoryID',
            'CategoryName',
            'CompanyName',
            'fkShippingID',
            'ProductRefNo',
            'ProductName',
            'ProductImage',
            'ProductSliderImage',
            'WholesalePrice',
            'FinalPrice',
            'DiscountPrice',
            'DiscountFinalPrice',
            'DateStart',
            'DateEnd',
            'Quantity',
            'QuantityAlert',
            'Weight',
            'WeightUnit',
            'Length',
            'Width',
            'Height',
            'DimensionUnit',
            'PackageName',
            'ProductDescription',
            'ProductTerms',
            'YoutubeCode',
            'HtmlEditor',
            'MetaTitle',
            'MetaKeywords',
            'MetaDescription',
            'IsFeatured',
            'ProductStatus',
            'ProductDateUpdated',
            'CreatedBy',
            'fkCreatedID',
            'UpdatedBy',
            'fkUpdatedID', 'fkPackageId'
        );
        $varTable = TABLE_PRODUCT . ' as p LEFT JOIN  ' . TABLE_CATEGORY . ' ON fkCategoryID = pkCategoryId LEFT JOIN ' . TABLE_WHOLESALER . ' ON fkWholesalerID = pkWholesalerID  LEFT JOIN ' . TABLE_PACKAGE . ' ON fkPackageId = pkPackageId ';
        $arrRes = $this->select($varTable, $arrClms, $argWhere);

        if ($arrRes[0]['CreatedBy'] == 'admin') {
            $varTblCreated = TABLE_ADMIN;
            $varClm = 'AdminUserName as CreatedBy ';
            $varWhr = "pkAdminID = '" . $arrRes[0]['fkCreatedID'] . "' ";
        } else {
            $varTblCreated = TABLE_WHOLESALER;
            $varClm = 'CompanyName as CreatedBy ';
            $varWhr = "pkWholesalerID = '" . $arrRes[0]['fkCreatedID'] . "' ";
        }
        $arrCreatedBy = $this->getArrayResult("SELECT " . $varClm . " FROM " . $varTblCreated . " WHERE " . $varWhr);

        if ($arrRes[0]['fkUpdatedID'] > 0) {
            if ($arrRes[0]['UpdatedBy'] == 'admin') {
                $varTblUpdated = TABLE_ADMIN;
                $varClm = 'AdminUserName as UpdatedBy ';
                $varWhr = "pkAdminID = '" . $arrRes[0]['fkUpdatedID'] . "' ";
            } else {
                $varTblUpdated = TABLE_WHOLESALER;
                $varClm = 'CompanyName as UpdatedBy ';
                $varWhr = "pkWholesalerID = '" . $arrRes[0]['fkUpdatedID'] . "'";
            }
            $arrUpdatedBy = $this->getArrayResult("SELECT " . $varClm . " FROM " . $varTblUpdated . " WHERE " . $varWhr);
        } else {
            $arrUpdatedBy[0]['UpdatedBy'] = 'N/A';
        }
        $arrRes[0]['CreatedByName'] = $arrCreatedBy[0]['CreatedBy'];
        $arrRes[0]['UpdatedByName'] = $arrUpdatedBy[0]['UpdatedBy'];

        $query = "SELECT pkAttributeId,AttributeLabel,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle,AttributeOptionValue,GROUP_CONCAT(AttributeOptionImage) as AttributeOptionImage FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId WHERE fkProductId = '" . $arrRes[0]['pkProductID'] . "' GROUP BY pkAttributeId ASC";

        $arrRes[0]['productAttribute'] = $this->getArrayResult($query);

        //pre($arrRes[0]['productAttribute']);
        return $arrRes;
    }

    /**
     * function updateProduct
     *
     * This function is used to update product.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return 1
     *
     * User instruction: $objProduct->updateProduct($arrPost, $arrFileName)
     */
    function updateProduct($arrPost, $arrFileName, $arrFileNameAttr) {


        $objCore = new Core();
        $varDateStart = $objCore->defaultDateTime($arrPost['frmDateStart'], DATE_FORMAT_DB);
        $varDateEnd = $objCore->defaultDateTime($arrPost['frmDateEnd'], DATE_FORMAT_DB);
        $IsFeatured = (isset($arrPost['frmIsFeatured'])) ? '1' : '0';
        $frmShippingGateway = implode(',', $arrPost['frmShippingGateway']);

        $varProductImage = $arrPost['default'];

        $arrClms = array(
            'fkCategoryID' => $arrPost['frmfkCategoryID'],
            'fkWholesalerID' => $arrPost['frmfkWholesalerID'],
            'fkShippingID' => $frmShippingGateway,
            'ProductName' => $arrPost['frmProductName'],
            'ProductImage' => $varProductImage,
            'WholesalePrice' => $arrPost['frmWholesalePriceInUSD'],
            'FinalPrice' => $arrPost['frmProductPrice'],
            'DiscountPrice' => $arrPost['frmDiscountPriceInUSD'],
            'DiscountFinalPrice' => $arrPost['frmDiscountFinalPriceInUSD'],
            'DateStart' => $varDateStart,
            'DateEnd' => $varDateEnd,
            'Quantity' => $arrPost['frmQuantity'],
            'QuantityAlert' => $arrPost['frmQuantityAlert'],
            'Weight' => $arrPost['frmWeight'],
            'WeightUnit' => $arrPost['frmWeightUnit'],
            'Length' => $arrPost['frmLength'],
            'Width' => $arrPost['frmWidth'],
            'Height' => $arrPost['frmHeight'],
            'DimensionUnit' => $arrPost['frmDimensionUnit'],
            'fkPackageId' => $arrPost['frmfkPackageId'],
            'ProductDescription' => $arrPost['frmProductDescription'],
            'ProductTerms' => $arrPost['frmProductTerms'],
            'YoutubeCode' => $arrPost['frmYoutubeCode'],
            'HtmlEditor' => $arrPost['frmHtmlEditor'],
            'MetaTitle' => $arrPost['frmMetaTitle'],
            'MetaKeywords' => $arrPost['frmMetaKeywords'],
            'MetaDescription' => $arrPost['frmMetaDescription'],
            'IsFeatured' => $IsFeatured,
            'fkUpdatedID' => $_SESSION['sessUser'],
            'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );

        $varWhr = 'pkProductID = ' . $_GET['id'];
        $this->update(TABLE_PRODUCT, $arrClms, $varWhr);

        $arrAddID = $_GET['id'];
        if ($arrAddID > 0) {
            //Insert Images for products
            if (isset($arrFileName)) {
                foreach ($arrFileName as $valueImg) {
                    $arrClmsImg = array(
                        'fkProductID' => $arrAddID,
                        'ImageName' => $valueImg,
                        'ImageDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                    );
                    if ($valueImg <> '') {
                        $this->insert(TABLE_PRODUCT_IMAGE, $arrClmsImg);
                    }
                }
            }

            // Delete attribute for this products
            $varWhereCondition = " fkProductId = '" . $arrAddID . "'";
            $this->delete(TABLE_PRODUCT_TO_OPTION, $varWhereCondition);

            // Add attribute for this products
            if (isset($arrPost['frmAttribute'])) {
                foreach ($arrPost['frmAttribute'] as $keyAttr => $valueAttr) {
                    foreach ($valueAttr as $keyOpt => $valueOpt) {
                        $imgNm = isset($arrFileNameAttr[$valueOpt]['imgnm']) ? $arrFileNameAttr[$valueOpt]['imgnm'] : '';
                        $isImgUploaded = isset($arrFileNameAttr[$valueOpt]['isImgUploaded']) ? $arrFileNameAttr[$valueOpt]['isImgUploaded'] : 0;
                        $varOptionCaption = $arrPost['frmOptCaption'][$valueOpt];
                        $OptionExtraPrice = (float) $arrPost['frmOptExtraPrice'][$valueOpt];
                        $defaultPrice = ($OptionExtraPrice > 0) ? 0 : 1;


                        $arrClmsOpt = array(
                            'fkProductId' => $arrAddID,
                            'fkAttributeId' => $keyAttr,
                            'fkAttributeOptionId' => $valueOpt,
                            'OptionExtraPrice' => $OptionExtraPrice,
                            'OptionIsDefault' => $defaultPrice,
                            'AttributeOptionValue' => $varOptionCaption,
                            'AttributeOptionImage' => $imgNm,
                            'IsImgUploaded' => $isImgUploaded
                        );
                        $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsOpt);
                    }
                }
            }

            if (isset($arrPost['frmAttributeText'])) {
                foreach ($arrPost['frmAttributeText'] as $keyTextOpt => $valuetextOpt) {
                    $atrOpt = explode('-', $keyTextOpt);

                    $arrClmsTextOpt = array(
                        'fkProductId' => $arrAddID,
                        'fkAttributeId' => $atrOpt[0],
                        'fkAttributeOptionId' => $atrOpt[1],
                        'AttributeOptionValue' => $valuetextOpt
                    );

                    $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextOpt);
                }
            }
            if (isset($arrPost['frmAttributeTextArea'])) {

                foreach ($arrPost['frmAttributeTextArea'] as $keyTextAreaOpt => $valuetextAreaOpt) {
                    $atrOpt = explode('-', $keyTextAreaOpt);

                    $arrClmsTextAreaOpt = array(
                        'fkProductId' => $arrAddID,
                        'fkAttributeId' => $atrOpt[0],
                        'fkAttributeOptionId' => $atrOpt[1],
                        'AttributeOptionValue' => $valuetextAreaOpt,
                    );
                    $this->insert(TABLE_PRODUCT_TO_OPTION, $arrClmsTextAreaOpt);
                }
            }
        }
        return 1;
    }

    /**
     * function updateProductStatus
     *
     * This function is used to update product status.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_to_package, tbl_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objProduct->updateProductStatus($argPost)
     */
    function updateProductStatus($argPost) {
        global $objGeneral;
        global $objCore;

        $varWhr = 'pkProductID = ' . $argPost['pid'];
        $arrClms = array(
            'ProductStatus' => $argPost['status'],
            'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        $arrUpdateID = $this->update(TABLE_PRODUCT, $arrClms, $varWhr);

        if ($argPost['status'] == 0) {
            $objGeneral->solrProductRemoveAdd($varWhr);

            $varWhr = "fkProductID = '" . $argPost['pid'] . "'";
            $arrClms = array('fkPackageId');
            $arrRow = $this->select(TABLE_PRODUCT_TO_PACKAGE, $arrClms, $varWhr);
            foreach ($arrRow AS $key => $packageId) {
                $varWhr = "pkPackageId = '" . $packageId['fkPackageId'] . "'";
                $arrClms = array(
                    'PackageStatus' => $argPost['status'],
                );
                $this->update(TABLE_PACKAGE, $arrClms, $varWhr);
            }
        }
        return $arrUpdateID;
    }

    /**
     * function updateProductOptPrice
     *
     * This function is used to update product status.
     *
     * Database Tables used in this function are : tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objProduct->updateProductStatus($argPost)
     */
    function updateProductOptPrice($pid, $argPost) {

        $num = 1;

        foreach ($argPost['frmPrice'] as $key => $val) {
            $default = $argPost['default_' . $key];

            foreach ($val as $k => $v) {
                $def = ($default == $k) ? 1 : 0;

                $varWhr = "pkProductAttributeId = '" . $k . "'";

                $arrClms = array(
                    'OptionExtraPrice' => $v,
                    'OptionIsDefault' => $def
                );

                $varUpdate = $this->update(TABLE_PRODUCT_TO_OPTION, $arrClms, $varWhr);
                $num +=$varUpdate;
            }
        }
        return $num;
    }

    /**
     * function updateProductOptInventory
     *
     * This function is used to update product status.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_option_inventory
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objProduct->updateProductStatus($argPost)
     */
    function updateProductOptInventory($pid, $argPost) {
        //pre($argPost);
        global $objCore; 
        $num = 1;

        $varWhr = "fkProductID = '" . $pid . "'";

        $this->delete(TABLE_PRODUCT_OPTION_INVENTORY, $varWhr);
        $qty = 0;
        foreach ($argPost['frmOptIds'] as $key => $val) {
            $tempArr = explode(',', $val);
            sort($tempArr);

            $optIds = implode(',', $tempArr);
            $qty += $argPost['frmQuantity'][$key];
            $arrClms = array(
                'fkProductID' => $pid,
                'OptionIDs' => $optIds,
                'OptionQuantity' => $argPost['frmQuantity'][$key]
            );
            $varUpdate = $this->insert(TABLE_PRODUCT_OPTION_INVENTORY, $arrClms);
            $num +=$varUpdate;
        }

        $arrClms = array(
            'Quantity' => $qty,
            'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );

        $varWhr = "pkProductID = '" . $pid . "'";
        $this->update(TABLE_PRODUCT, $arrClms, $varWhr);

        return $num;
    }

    /**
     * function addPackage
     *
     * This function is used to add Package.
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objProduct->addPackage($arrPost)
     */
    function addPackage($arrPost) {
        $arrClms = array(
            'fkWholesalerID' => $arrPost['fkWholesalerID'],
            'PackageName' => $arrPost['PackageName'],
            'PackageACPrice' => $arrPost['PackageACPrice'],
            'PackagePrice' => $arrPost['OfferPrice'],
            'PackageDateAdded' => date(DATE_TIME_FORMAT_DB)
        );

        $arrAddID = $this->insert(TABLE_PACKAGE, $arrClms);
        if ($arrAddID > 0) {
            //Insert products for package
            if (isset($arrPost['ProIds'])) {
                $arrProductId = explode('-vss-', $arrPost['ProIds']);
                foreach ($arrProductId as $keyPkg => $valPkg) {
                    $arrClmsPro = array(
                        'fkPackageId' => $arrAddID,
                        'fkProductId' => $valPkg
                    );
                    if ($valPkg <> 0 && $valPkg <> '') {
                        $this->insert(TABLE_PRODUCT_TO_PACKAGE, $arrClmsPro);
                    }
                }
            }
        }
       return $arrAddID; 
        
    }

    /**
     * function removeProduct
     *
     * This function is used to remove Product.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image, tbl_product_rating, tbl_product_to_option, tbl_product_to_package, tbl_recommend, tbl_review, tbl_wishlist
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $ctr
     *
     * User instruction: $objProduct->removeProduct($argPostIDs, $varPortalFilter) 
     */
    function removeProduct($argPostIDs, $varPortalFilter) {
        global $objGeneral;
        $ctr = 0;
        
        $arrRes = $this->select(TABLE_PRODUCT,array('fkWholesalerID'), " pkProductID='".$argPostIDs['frmID']."'");
        $this->insert(TABLE_WHOLESALER_PRODUCT_DELETE,array('fkProductID' => $argPostIDs['frmID'], 'fkWholesalerID' => $arrRes[0]['fkWholesalerID']));
        
        if (isset($argPostIDs['deleteType']) && $argPostIDs['deleteType'] == 'sD') {
            $varWhereSdelete = " pkProductID = '" . $argPostIDs['frmID'] . "' " . $varPortalFilter;

            $objGeneral->solrProductRemoveAdd($varWhereSdelete);

            $num = $this->delete(TABLE_PRODUCT, $varWhereSdelete);
            if ($num > 0) {
                $ctr++;

                $varWhr = " fkProductID = '" . $argPostIDs['frmID'] . "' ";

                $this->delete(TABLE_PRODUCT_IMAGE, $varWhr);
                $this->delete(TABLE_PRODUCT_RATING, $varWhr);
                $this->delete(TABLE_PRODUCT_TO_OPTION, $varWhr);
                $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWhr);
                $this->delete(TABLE_RECOMMEND, $varWhr);
                $this->delete(TABLE_REVIEW, $varWhr);
                $this->delete(TABLE_WISHLIST, $varWhr);
            }
        } else {
            foreach ($argPostIDs['frmID'] as $varDeleteID) {
                $varWhereCondition = " pkProductID = '" . $varDeleteID . "' " . $varPortalFilter;

                $objGeneral->solrProductRemoveAdd($varWhereCondition);

                $num = $this->delete(TABLE_PRODUCT, $varWhereCondition);
                if ($num > 0) {
                    $ctr++;
                    $varWhr = " fkProductID = '" . $varDeleteID . "' ";
                    $this->delete(TABLE_PRODUCT_IMAGE, $varWhr);
                    $this->delete(TABLE_PRODUCT_RATING, $varWhr);
                    $this->delete(TABLE_PRODUCT_TO_OPTION, $varWhr);
                    $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWhr);
                    $this->delete(TABLE_RECOMMEND, $varWhr);
                    $this->delete(TABLE_REVIEW, $varWhr);
                    $this->delete(TABLE_WISHLIST, $varWhr);
                }
            }
        }
        return $ctr;
    }

    /**
     * function getSortColumn
     *
     * This function is used to sort columns.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objProduct->getSortColumn($argVarSortOrder) 
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
            $varSortBy = 'pkProductID';
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
        $objOrder->addColumn('Name', 'ProductName');
        $objOrder->addColumn('Ref No.', 'ProductRefNo', '', 'hidden-480');
        $objOrder->addColumn('Category', 'CategoryName', '', 'hidden-480');
        $objOrder->addColumn('Wholesaler', 'CompanyName', '', 'hidden-480');
        $objOrder->addColumn('Wholesale Price ($)', 'WholesalePrice', '', 'hidden-480');
        $objOrder->addColumn('Final Price ($)', 'FinalPrice');

        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function varProductSortColumn
     *
     * This function is used to sort product columns.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objProduct->varProductSortColumn($argVarSortOrder) 
     */
    function varProductSortColumn($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'pkReviewID';
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
        $objOrder->addColumn('Product Id', 'pkProductID', '', 'hidden-480');
        $objOrder->addColumn('Product Name', 'ProductName');
        $objOrder->addColumn('Product Category', 'CategoryName', '', 'hidden-480');
        $objOrder->addColumn('Customer Name', 'CustomerFirstName');
        $objOrder->addColumn('Review', 'Reviews');

//        $objOrder->addColumn('Action');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function customerReviewList
     *
     * This function is used to view customer list.
     *
     * Database Tables used in this function are : tbl_review, tbl_customer, tbl_product, tbl_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->customerReviewList($argWhere = '', $argLimit = '')
     */
    function customerReviewList($argWhere = '', $argLimit = '') {
        if ($argLimit != "") {
            $limit = $argLimit . " ";
        } else {
            $limit = "";
        }
        $varWhere = "1 AND " . $argWhere . "";
        //$varOrderBy = 'pkReviewID DESC';
        /* To show recently provided reviews list in descending order by Krishna Gupta */
        $varOrderBy = 'ReviewDateUpdated DESC';
        $varArrayColoum = array('pkReviewID', 'fkCustomerID', 'fkProductID', 'Reviews', 'ApprovedStatus', 'ReviewDateAdded', 'pkCustomerID', 'concat(CustomerFirstName," ",CustomerLastName) as csName', 'pkProductID', 'ProductName', 'pkCategoryId', 'CategoryName');


        $varTable = TABLE_REVIEW . ' AS TR LEFT JOIN ' . TABLE_CUSTOMER . ' AS TC  ON TR.fkCustomerID=TC.pkCustomerID LEFT JOIN ' . TABLE_PRODUCT . ' AS TP ON TR.fkProductID=TP.pkProductID LEFT JOIN ' . TABLE_CATEGORY . ' as TCAT ON TP.fkCategoryID=TCAT.pkCategoryId';

        $arrRes = $this->select($varTable, $varArrayColoum, $varWhere, $varOrderBy, $limit);
       // pre($arrRes);

        return $arrRes;
    }

    /**
     * function updateReviewStatus
     *
     * This function is used to update review list.
     *
     * Database Tables used in this function are : tbl_review
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objProduct->updateReviewStatus($varStatus, $varId)
     */
    function updateReviewStatus($varStatus, $varId,$pendind_status = null) {
       // pre($pendind_status);
		global $objGeneral;
		
        $varWhr = 'pkReviewID=' . $varId;
        $arrUpdateID = $this->update(TABLE_REVIEW, $varStatus, $varWhr);
        
    	if($varStatus['ApprovedStatus']=='Allow')
    	{
    		$varArray = array('fkCustomerID');
        	$list = $this->select(TABLE_REVIEW, $varArray, $varWhr);
    		if($list[0]['fkCustomerID']>0)
    		$objGeneral->addRewards($list[0]['fkCustomerID'], 'RewardOnReviewRatingProduct');
    	}
        elseif($varStatus['ApprovedStatus']=='Disallow' && $pendind_status==null)
        {
            $varArray = array('fkCustomerID');
        	$list = $this->select(TABLE_REVIEW, $varArray, $varWhr);
    		if($list[0]['fkCustomerID']>0)
    		$objGeneral->diductRewards($list[0]['fkCustomerID'], 'RewardOnReviewRatingProduct');
            
        }

        return $arrUpdateID;
    }

    /**
     * function getAjaxProductDetails
     *
     * This function is used to get Ajax Product Details.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $list
     *
     * User instruction: $objProduct->getAjaxProductDetails($whList='')
     */
    function getAjaxProductDetails($whList = '') {

        $varArray = array('pkProductID', 'ProductName', 'FinalPrice');

        $whr = "fkWholesalerID='" . $whList . "'";

        $list = $this->select(TABLE_PRODUCT, $varArray, $whr);

        return $list;
    }

    /**
     * function findCategory
     *
     * This function is used to find Category.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->findCategory($argCat)
     */
    function findCategory($argCat) {
        $varID = "pkCategoryId = '" . $argCat . "'";
        $arrClms = array('CategoryName');
        $varTable = TABLE_CATEGORY;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['CategoryName'];
    }

    /**
     * function findShippingGateway
     *
     * This function is used to find Shipping Gateway.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->findShippingGateway($argShipping)
     */
    function findShippingGateway($argShipping) {
        $varID = "pkShippingGatewaysID = '" . $argShipping . "'";
        $arrClms = array('ShippingTitle');
        $varTable = TABLE_SHIPPING_GATEWAYS;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['ShippingTitle'];
    }

    /**
     * function findAttribute
     *
     * This function is used to find Attribute.
     *
     * Database Tables used in this function are : tbl_order_option, tbl_attribute, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrPTP
     *
     * User instruction: $objProduct->findAttribute($argProductID)
     */
    function findAttribute($argProductID) {
        $varQuery = "SELECT AttributeCode,GROUP_CONCAT(OptionTitle) as OptionTitle FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId WHERE fkProductId = '" . $argProductID . "' GROUP BY pkAttributeId";
        $arrPTP = $this->getArrayResult($varQuery);
        return $arrPTP;
    }

}

?>
