<?php

/**
 * Site Category Class
 *
 * This is the Category class that will frequently used on website.
 *
 * DateCreated 18th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class Category extends Database {

    function __construct() {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function myCartDetails
     *
     * This function is used get cart details.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function myCartDetails() {

        $varCount = (int) $_SESSION['MyCart']['Total'];
        if ($varCount > 0) {
            $varCartIDS = implode(',', array_keys($_SESSION['MyCart']['Product']));
            $varCartIDS=$varCartIDS!=''?$varCartIDS:0;
            
            $varQuery = "SELECT pkProductID,ProductName,FinalPrice,ProductDescription,ImageName
            FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_PRODUCT_IMAGE . " ON pkProductID = fkProductID
            WHERE pkProductID IN (" .$varCartIDS . ") Group By pkProductID";

            $arrRes = $this->getArrayResult($varQuery);
        }
        $arrRes[0]['CartCount'] = $varCount;
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function myCompareDetails
     *
     * This function is used to get compare details.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_product, tbl_product_to_option, tbl_attribute, tbl_attribute_option, tbl_attribute_to_category
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function myCompareDetails() {
      //  pre($_SESSION['MyCompare']);
        //unset($_SESSION['MyCompare']);
        $varCartIDS = implode(',', array_keys($_SESSION['MyCompare']['Product']));

        // pre($varCartIDS);

        $atrrCount = 0;
        foreach ($_SESSION['MyCompare']['Product'] as $valProductId) {
            $varQuery = "SELECT (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,pkProductID,CategoryName,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,ProductDescription,count(fkAttributeId) as Attribute,ProductImage as ImageName,(select CompanyName from " . TABLE_WHOLESALER . " where pkWholesalerID = fkWholesalerID) as WholeSalerName
            FROM " . TABLE_PRODUCT . " LEFT JOIN "
                      . TABLE_CATEGORY . " as cat ON pkCategoryId = fkCategoryId LEFT JOIN "
                    . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
            WHERE pkProductID = '" . $valProductId . "' Group By pkProductID";
            $arrRes['product_details'][$atrrCount] = $this->getArrayResult($varQuery);
            $varQuery2 = "SELECT fkProductID, pkAttributeId,AttributeLabel,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle, GROUP_CONCAT(pkOptionID) as pkOptionID, AttributeOptionValue FROM " . TABLE_PRODUCT_TO_OPTION . " FULL JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId WHERE fkProductID = " . $valProductId . " GROUP BY pkAttributeId ASC";
            //pre($varQuery2);
            $arrRes['product_attribute'][$atrrCount] = $this->getArrayResult($varQuery2);

            $varQuery3 = "SELECT pkProductID, pro.fkCategoryID,fkAttributeId,AttributeLabel,pkAttributeId FROM " . TABLE_PRODUCT . " as pro  left join " . TABLE_ATTRIBUTE_TO_CATEGORY . " as catAttr on pro.fkCategoryID = catAttr.fkCategoryID left join " . TABLE_ATTRIBUTE . " on pkAttributeID = catAttr.fkAttributeId WHERE pkProductID = " . $valProductId . " AND `AttributeComparable`='yes' GROUP BY pkAttributeId order by AttributeOrdering ASC";
            $arrRes['category_attribute'][$atrrCount] = $this->getArrayResult($varQuery3);
            $atrrCount++;
        }

        return $arrRes;
    }

    /**
     *
     * function myRecommendedAdd 
     *
     * This function is used add my recommended.
     *
     * Database Tables used in this function are : tbl_recommend
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     */
    function myRecommendedAdd($_arrPost) {
        //pre($_SESSION);
        $arrClms = array(
            'fkUserId' => $_SESSION['sessUserInfo']['id'],
            'fkProductId' => $_arrPost['pid'],
            'RecommendDateAdded' => date(DATE_TIME_FORMAT_DB)
        );
        //pre($arrPost);

        $arrAddID = $this->insert(TABLE_RECOMMEND, $arrClms);
        return $arrAddID;
    }

    /**
     * function myRecommendedDetails
     *
     * This function is used to get my recommended details.
     *
     * Database Tables used in this function are : tbl_recommend, tbl_product
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function myRecommendedDetails($pid=0) {
        
        $varSelectCatId =$this->select(TABLE_PRODUCT,array('fkCategoryID'),'pkProductID="'.$pid.'"'); 
        $fkCategoryID=($varSelectCatId[0]['fkCategoryID']!='' || $varSelectCatId[0]['fkCategoryID']!=0)?$varSelectCatId[0]['fkCategoryID']:1;
        $varQuery = "SELECT pkProductID,ProductName,FinalPrice,DiscountFinalPrice,Quantity,ProductDescription,ProductImage as ImgName
            FROM " . TABLE_PRODUCT . " LEFT JOIN ".TABLE_WHOLESALER." ON fkWholesalerID=pkWholesalerID where fkCategoryID='".$fkCategoryID."' and  pkProductID<>'".$pid."' AND WholesalerStatus<>'deactive' Group By pkProductID order by pkProductID DESC limit 0,15";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function myWishlistAdd
     *
     * This function is used to add my wishlist.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     */
    function myWishlistAdd($_arrPostId) {
        //pre($_SESSION);
        $whereWith="fkProductId='".$_arrPostId."' AND fkUserId='".$_SESSION['sessUserInfo']['id']."'";
        $verifyWishlist=$this->select(TABLE_WISHLIST,array('pkWishlistId'),$whereWith);
        if(count($verifyWishlist)==0){
        $arrClms = array(
            'fkUserId' => $_SESSION['sessUserInfo']['id'],
            'fkProductId' => $_arrPostId,
            'WishlistDateAdded' => date(DATE_TIME_FORMAT_DB)
        );
        //pre($arrPost);

        $arrAddID = $this->insert(TABLE_WISHLIST, $arrClms);
        }
        return $arrAddID;
    }

    /**
     * function myWishlistRemove
     *
     * This function is used to remove my wishlist.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    function myWishlistRemove($argPostId) {
        $varWhere = "fkUserId = '" . $_SESSION['sessUserInfo']['id'] . "' AND fkProductID =  '" . $argPostId . "'";
        $this->delete(TABLE_WISHLIST, $varWhere);
        return true;
    }

    /**
     * function getAdsDetails
     *
     * This function is used to get add details.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function getAdsDetails() {
        global $objCore;

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
        $catid = mysql_escape_string(trim($this->getParentCategory($_GET['cid'])));
        $varQuery = "SELECT pkAdID,AdType,Title,AdUrl,ImageName,ImageSize,HtmlCode
            FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND AdsStartDate<='" . $curDate . "' AND AdsEndDate >='" . $curDate . "' AND AdsPage = 'Product Listing Page' AND find_in_set('" . $catid . "',`CategoryPages`)  order by rand() limit 0,2";
        $arrRes = $this->getArrayResult($varQuery);
        // pre($arrRes);
        return $arrRes;
    }

    
    
    /**
     * function ListWhDeactive
     *
     * This function is used to get WholeSellers details with Deactive status.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function ListWhDeactive() {
        global $objCore;

        $varQuery = "SELECT pkWholesalerID,WholesalerStatus
            FROM " . TABLE_WHOLESALER . " WHERE WholesalerStatus <> 'active' "; //order by rand() limit 0,2
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    
    
    
    /**
     * function CategoryList
     *
     * This function is used get category list.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 2 string optional
     *
     * @return string $arrRes
     */
    function CategoryList($argCatId = '', $argLimit = '') {
        $arrClms = array('pkCategoryId', 'CategoryName', 'CategoryMetaTitle', 'CategoryMetaKeywords', 'CategoryHierarchy', 'CategoryMetaDescription');
        $varOrderBy = 'CategoryName ASC ';
        $varWhere = 'pkCategoryId IN(' . $argCatId . ')';
        $varTable = TABLE_CATEGORY;
        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function ProductCategoryList
     *
     * This function is used get product and category list.
     *
     * Database Tables used in this function are : tbl_product_to_option, tbl_product, tbl_category, tbl_wholesaler, tbl_product_rating, tbl_review, tbl_product_image
     *
     * @access public
     *
     * @parameters 3 string 
     *
     * @return string $arrRes
     */
    function ProductCategoryList($arrList, $arrProductIds, $argLimit) {

        if ($arrList['sortingId'] == "Recently Added") {
            $varOrderBy = 'ProductDateUpdated DESC';
        } else if ($arrList['sortingId'] == 'A-Z') {
            $varOrderBy = 'ProductName ASC';
        } else if ($arrList['sortingId'] == 'Z-A') {
            $varOrderBy = 'ProductName DESC';
        } else if ($arrList['sortingId'] == 'Popularity') {
            $varOrderBy = 'Sold DESC';
        } else if ($arrList['sortingId'] == 'Price (High > Low)') {
            $varOrderBy = 'FinalPrice DESC';
        } else if ($arrList['sortingId'] == 'Price (Low > High)') {
            $varOrderBy = 'FinalPrice ASC';
        } else {
            $varOrderBy = 'ProductDateUpdated DESC';
        }

        if ($argLimit != "") {
            $varLimit = ' limit ' . $argLimit . '';
        }

        $varWhere = "ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' ";
        if (isset($arrList['type']) && $arrList['type'] == 'new') {
            $varWhere .=" AND DATEDIFF(CURDATE(), `ProductDateAdded`) <= " . WHATS_NEW_BASED_ON_NUBER_OF_DAYS . " ";
        }
        $searchKey = mysql_escape_string(trim($arrList['searchKey']));
        if ($searchKey != '') {
            if (strlen($searchKey) < 5)
                $varWhere .=" AND (ProductName LIKE '%" . $searchKey . "%' OR CategoryName LIKE '%" . $searchKey . "%' OR CompanyName LIKE '%" . $searchKey . "%')";
            else
                $varWhere .=" AND MATCH(ProductName, CategoryName, CompanyName) AGAINST('*+" . str_replace(' ', '*|*+', $searchKey) . "*' IN BOOLEAN MODE) ";
        }


        if ($arrProductIds != "") {
            $varWhere .= ' AND fkCategoryID IN (' . $arrProductIds . ')';
        }
        if ($arrList['wid'] != "") {

            $varWhere .= ' AND fkWholesalerID IN (' . $arrList['wid'] . ')';
        }
        if ($arrList['pid'] != "") {
            $this->arrPriceDetails = urldecode($_REQUEST['pid']);
            $this->varPriceRange = explode('-', $this->arrPriceDetails);
            $varWhere .= ' AND FinalPrice >= ' . $this->varPriceRange[0] . ' AND FinalPrice <= ' . $this->varPriceRange[1] . '';
        }
        $attributeCond = '';
        $attributeOption = '';
        //pre($_REQUEST['attr']);
        if ($_REQUEST['attr'] != "") {
            $Atrr = explode("#", $_REQUEST['attr']);
            $AttrCount = count($Atrr);
            $count = 0;

            foreach ($Atrr as $valAttr) {
                //$count++;
                $AtrrOption = explode(":", $valAttr);
                $attributeId = $AtrrOption[0];
                if ($attributeOption != '')
                    $attributeOption .= ',';
                $attributeOption .= $AtrrOption[1];

                /* if($AttrCount == $count)
                  {
                  $AttrOptionVal[$count] = $AtrrOption[1];
                  }
                  else
                  {
                  $AttrOptionVal[$count]  = $AtrrOption[1];
                  } */
            }

            //$AttrOptionValues = implode(",",$AttrOptionVal);
            //$varWhere2 = " AND pkProductID in (select group_concat(pto2.fkProductId) from ".TABLE_PRODUCT_TO_OPTION." as pto2 where ".$attributeCond." having count(distinct concat(pto2.fkProductId,':',po2.fkAttributeId)>".($AttrCount-1)." )";
            $varAttrQuery = "SELECT fkProductId, COUNT( * ) AS attribute_count FROM " . TABLE_PRODUCT_TO_OPTION . ($attributeOption != 'undefined' && $attributeOption != '' ? " where  fkAttributeOptionId IN($attributeOption)" : "") . " GROUP BY fkProductId HAVING attribute_count = $AttrCount";
            $attributeRes = $this->getArrayResult($varAttrQuery);

            $optProductIds = '';
            foreach ($attributeRes as $row) {
                if ($optProductIds != '')
                    $optProductIds.=",";
                $optProductIds .= $row['fkProductId'];
            }
            $varWhere2 = " AND pkProductID in (" . ($optProductIds != '' ? $optProductIds : 0) . ")";
        }


        if ($arrList['searchVal'] != "") {
            $varWhere .= " AND ProductName LIKE '%" . $arrList['searchVal'] . "%'";
        }

        if ($arrList['frmKey'] != "") {
            $varWhere .= " AND ProductName LIKE '%" . $arrList['frmKey'] . "%'";
        }

        if (($arrList['frmPriceTo'] != "") && ($arrList['frmPriceFrom'] != "")) {
            $varWhere .= ' AND FinalPrice >= ' . $arrList['frmPriceFrom'] . ' AND FinalPrice <= ' . $arrList['frmPriceTo'] . '';
        }


        $varQuery = "SELECT pkProductID,ProductName,FinalPrice,ProductDescription,pkWholesalerID,CompanyName,ProductImage,DiscountFinalPrice,count(fkAttributeId) as Attribute, avg(Rating) as numRating, count(rev.pkReviewID) as custReview, count(rat.fkCustomerID) as numCustomer 
            FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
            LEFT JOIN " . TABLE_PRODUCT_RATING . " as rat on pkProductID = rat.fkProductID LEFT JOIN " . TABLE_REVIEW . " as rev on pkProductID = rev.fkProductID where  " . $varWhere . " " . $varWhere2 . " Group By pkProductID " . $varWhere3 . " ORDER BY " . $varOrderBy . "" . $varLimit . "";

        $arrRes['productsDetails'] = $this->getArrayResult($varQuery);
        $i = 0;
        foreach ($arrRes['productsDetails'] AS $prod) {
            $varQuery = "SELECT ImageName FROM " . TABLE_PRODUCT_IMAGE . " WHERE fkProductID = '" . $prod['pkProductID'] . "'";
            $arrProdImg = $this->getArrayResult($varQuery);
            $arrRes['productsDetails'][$i]['arrproductImages'] = $arrProdImg;
            $arrRes['productsDetails'][$i]['arrAttributes'] = $this->getAttributeDetails($prod['pkProductID']);
            $i++;
        }


        $varQuery2 = "SELECT  pkWholesalerID,CompanyName,COUNT(pkProductID) as ProductNum 
                   FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID where  " . $varWhere . " Group By pkWholesalerID ORDER BY CompanyName ";
        $arrRes['WholesalerDetails'] = $this->getArrayResult($varQuery2);
        //pre($arrRes['productsDetails']);
        return $arrRes;
    }

    /**
     * function getChildCats
     *
     * This function is used to get child categories.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 2 string 
     *
     * @return string $c
     */
    function getChildCats($arrList, $str) {
        $varQuery = "select pkCategoryId from " . TABLE_CATEGORY . " where CategoryParentId IN(" . $arrList . ")";
        $arrRes = $this->getArrayResult($varQuery);
        $raws = array($arrList);
        $str .= ',' . $arrList;
        foreach ($arrRes as $valRes) {
            $str = $this->getChildCats($valRes['pkCategoryId'], $str);
        }

        $a = explode(",", $str);
        $b = array_unique($a);
        $c = implode(",", $b);
        //pre($raws);
        return $c;
    }

    /**
     * function getvarBreadcrumbs
     *
     * This function is used get breadcrumbs details.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 2 string 
     *
     * @return string $c
     */
    function getvarBreadcrumbs($cids) {

        $arrIds = explode(':', $cids);
        $varStr =   '<li class="first"><a class= breadcurmbs" href="' . SITE_ROOT_URL.'">Home</a></li>';
        $num = count($arrIds);

        global $objCore;
        $i = 1;
        foreach ($arrIds as $val) {
            $varQuery = "select pkCategoryId,CategoryParentId,CategoryName from " . TABLE_CATEGORY . " where pkCategoryId ='" . $val . "'";
            $arrRes = $this->getArrayResult($varQuery);

            //$cls = ($i == 1) ? 'class="first"' : '';
             $cls = '';
            if ($num == $i) {
                  $varStr .= '<li ' . $cls . '>' . ucfirst($arrRes[0]['CategoryName']) . '</li>';                 
            } else if ($arrRes[0]['CategoryParentId'] == '0') {
                $varStr .= '<li ' . $cls . '><a class="breadcurmbs" href="' . $objCore->getUrl('landing.php', array('cid' => $arrRes[0]['pkCategoryId'], 'name' => $arrRes[0]['CategoryName'])) . '" >' . ucfirst($arrRes[0]['CategoryName']) . '</a></li>';
            } else {
                $varStr .= '<li ' . $cls . '><a class="ajax_category breadcurmbs" href="' . $arrRes[0]['pkCategoryId'] . '" >' . ucfirst($arrRes[0]['CategoryName']) . '</a></li>';
            }
            $i++;
        }

        return $varStr;
    }

    /**
     * function wholeSalerList
     *
     * This function is used to get wholesaler list.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_product
     *
     * @access public
     *
     * @parameters 1 string 
     *
     * @return string $arrRes
     */
    function wholeSalerList($argCatIds) {
        $varWhere = "WholesalerStatus = 'active' AND fkCategoryID IN(" . $argCatIds . ") ";
        $varQuery = 'SELECT pkWholesalerID,CompanyName,COUNT(pkProductID) as ProductNum FROM ' . TABLE_WHOLESALER . ' as whl LEFT JOIN ' . TABLE_PRODUCT . ' as prd ON whl.pkWholesalerID=prd.fkWholesalerID where ' . $varWhere . ' GROUP BY pkWholesalerID order by CompanyName';
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function wholeSalerDetails
     *
     * This function is used get wholesaler details.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string 
     *
     * @return string $arrRes
     */
    function wholeSalerDetails($varWhlId) {

        $varQuery = 'SELECT pkWholesalerID,CompanyName FROM ' . TABLE_WHOLESALER . ' where pkWholesalerID=' . $varWhlId . '';
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getAttributeByCatId
     *
     * This function is used to get attribute by category.
     *
     * Database Tables used in this function are : tbl_attribute_to_category, tbl_attribute, tbl_attribute_option, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 string 
     *
     * @return string $arrRes
     */
    function getAttributeByCatId($argCatId) {
        $varQuery = "SELECT pkAttributeId, AttributeLabel,AttributeInputType, OptionTitle, pkOptionID, GROUP_CONCAT(distinct fkProductId) as ProductId FROM " . TABLE_ATTRIBUTE_TO_CATEGORY . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId  LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " as attrOpt ON attrOpt.fkAttributeId = pkAttributeId INNER JOIN " . TABLE_PRODUCT_TO_OPTION . " ON pkOptionID = fkAttributeOptionId  where " . ($argCatId == '' ? '' : "`fkCategoryID` IN(" . $argCatId . ") AND") . " `AttributeInputType` IN( 'select','radio','checkbox') AND `AttributeVisible`='yes' AND `AttributeSearchable`='yes' group by attrOpt.pkOptionID order by  pkAttributeId ";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function NewProductCategoryList
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 0 string 
     *
     * @return string 
     */
    function NewProductCategoryList() {
        $varQuery = "SELECT fkCategoryID FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID WHERE DATEDIFF(CURDATE(), `ProductDateAdded`) <= " . WHATS_NEW_BASED_ON_NUBER_OF_DAYS . " AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active'";
        return $this->getArrayResult($varQuery);
    }

    /**
     * function getAttributeDetails
     *
     * This function is used to get Attribute Details for products.
     *
     * Database Tables used in this function are : tbl_product_to_option ,tbl_attribute, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getAttributeDetails($argPId = 0) {
        $varQuery2 = "SELECT pkAttributeId,AttributeLabel,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle, GROUP_CONCAT(pkOptionID) as pkOptionID, AttributeOptionValue, AttributeOrdering FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId WHERE fkProductId = '" . $argPId . "' AND `AttributeVisible`='yes' GROUP BY pkAttributeId ASC";
        $arrRes = $this->getArrayResult($varQuery2);
        return $arrRes;
    }

    /**
     * function ProductSolrList
     *
     * This function is used get product list from solr server.
     *
     * Database Tables used in this function are : tbl_product, tbl_wholesaler, tbl_category, tbl_attribute, tbl_product_to_option, tbl_product_rating
     *
     * @access public
     *
     * @parameters 0 string 
     *
     * @return string $arrRes
     */
    function ProductSolrList($limit = 100) {
        global $objCore;
        $varOrderBy = 'ProductDateUpdated DESC';
        $varWhere2 = $varWhere3 = '';
        $varLimit = " LIMIT $limit";
        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

        $varWhere = "`ProductDateUpdated` > `ProductCronUpdate`";
        $varQuery = "SELECT pkProductID,ProductName,FinalPrice,ProductDescription,ProductImage,DiscountFinalPrice,discountPercent,(select FinalSpecialPrice from tbl_special_product INNER JOIN tbl_festival ON (fkFestivalID=pkFestivalID) where fkProductID=pkProductID AND FestivalStartDate<='".$curDate."' AND FestivalEndDate>='".$curDate."') as SpecialFinalPrice,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,pkWholesalerID,CompanyName, CategoryParentId, pkCategoryId, CategoryName, Quantity, AVG(rat.Rating) as numRating, count(rat.fkCustomerID) as numCustomer, CategoryHierarchy,CategoryLevel, IF(DATEDIFF(CURDATE(), `ProductDateAdded`) <= " . WHATS_NEW_BASED_ON_NUBER_OF_DAYS . ",'New','Old') AS ProductNewOld, Sold, ProductDateAdded, ProductStatus, CategoryIsDeleted, CategoryStatus, WholesalerStatus 
	FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID LEFT JOIN " . TABLE_PRODUCT_RATING . " as rat on pkProductID = rat.fkProductID where  " . $varWhere . " Group By pkProductID ORDER BY " . $varOrderBy . "" . $varLimit . "";

        $arrRes['productsDetails'] = $this->getArrayResult($varQuery);
        $i = 0;
        foreach ($arrRes['productsDetails'] AS $prod) {
            $arrRes['productsDetails'][$i]['ProductStatus'] = ($prod['ProductStatus'] == '1' && $prod['CategoryIsDeleted'] == '0' && $prod['CategoryStatus'] == '1' && $prod['WholesalerStatus'] == 'active') ? '1' : '0';
            $arrRes['productsDetails'][$i]['arrAttributes'] = $this->getAttributeDetails($prod['pkProductID']);
            $arrRes['productsDetails'][$i]['perentCategoryName']= $this->getParentCategoryName($prod['pkCategoryId']);
            $i++;
        }
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function ProductSolrListCronUpdate
     *
     * This function is used update the products added into solr.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_deleted
     *
     * @access public
     *
     * @parameters 0 string 
     *
     * @return string $arrRes
     */
    function ProductSolrListCronUpdate($ids, $arrClmsUpdate) {
        $varWhere = "pkProductID IN($ids)";
        $arrRes = $this->update(TABLE_PRODUCT, $arrClmsUpdate, $varWhere);
        $this->delete(TABLE_PRODUCT_DELETE, "1");

        return $arrRes;
    }

    /**
     * function ProductDeletedList
     *
     * This function is used to delete the products added into solr.
     *
     * Database Tables used in this function are : tbl_product_deleted
     *
     * @access public
     *
     * @parameters 0 string 
     *
     * @return string $arrRes
     */
    function ProductDeletedList() {
        $varQuery = "SELECT fkProductID FROM " . TABLE_PRODUCT_DELETE;
        $arrRes = $this->getArrayResult($varQuery);

        return $arrRes;
    }

    /**
     * function getSearchKeyProduct
     *
     * This function is used to get product search key.
     *
     * Database Tables used in this function are : tbl_product, tbl_wholesaler, tbl_category, tbl_attribute, tbl_product_to_option, tbl_product_rating
     *
     * @access public
     *
     * @parameters 0 string 
     *
     * @return string $arrRes
     */
    function getSearchKeyProduct($q, $cid) {
       // pre()

        $varQueryWho = "SELECT CompanyName FROM " . TABLE_WHOLESALER . " WHERE WholesalerStatus = 'active' AND CompanyName Like '%" . $q . "%' ";
        $arrResWho = $this->getArrayResult($varQueryWho);


        $varWhrPro = "WHERE ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' AND ProductName Like '%" . $q . "%' ";

        if ($cid > 0) {
            $varQueryPCat = "SELECT group_concat(pkCategoryId) as catIds FROM " . TABLE_CATEGORY . " WHERE CategoryIsDeleted = '0' AND CategoryStatus = '1' AND CategoryHierarchy Like '" . $cid . "%' ";
            $arrResPCat = $this->getArrayResult($varQueryPCat);
            if ($arrResPCat[0]['catIds'] <> '') {
                $varWhrPro .= " AND fkCategoryID in(" . $arrResPCat[0]['catIds'] . ")";
            }
        } else {
            $varQueryCat = "SELECT CategoryName FROM " . TABLE_CATEGORY . " WHERE CategoryIsDeleted = '0' AND CategoryStatus = '1' AND CategoryName Like '%" . $q . "%' ";
            $arrResCat = $this->getArrayResult($varQueryCat);
        }

        $varQueryPro = "SELECT ProductName FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID " . $varWhrPro;
        $arrResPro = $this->getArrayResult($varQueryPro);

        $arrRes['Category'] = $arrResCat;
        $arrRes['Product'] = $arrResPro;
        $arrRes['Wholesaler'] = $arrResWho;
        return $arrRes;
    }

    /**
     * function getSearchProduct
     *
     * This function is used get searched product.
     *
     * Database Tables used in this function are : tbl_product, tbl_wholesaler, tbl_category, tbl_attribute, tbl_product_to_option, tbl_product_rating
     *
     * @access public
     *
     * @parameters 0 string 
     *
     * @return string $arrRes
     */
    function getSearchProduct($q) {

        $varQuery = "SELECT ProductName FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID  WHERE ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' AND ProductName Like '%" . $q . "%' ";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function CategoryChildList
     *
     * This function is used display Child category list.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 int optional
     *
     * @return string $arrRes
     */
    function CategoryChildList($argCatId = '') {
        $arrClms = array('pkCategoryId');
        $varOrderBy = 'CategoryName ASC ';
        if ($argCatId > 0)
            $varWhere = 'CategoryParentId =' . $argCatId;
        else
            $varWhere = 'CategoryLevel =0';
        $varTable = TABLE_CATEGORY;
        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
        $retRes = array();
        foreach ($arrRes as $val) {
            $retRes[] = $val['pkCategoryId'];
        }
        //pre($retRes);
        return $retRes;
    }

    /**
     * function getCategoryDetails
     *
     * This function is used display category details.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 int optional
     *
     * @return string $arrRes
     */
    function getCategoryDetails($CatId = '0') {
        $varQuery = "SELECT CategoryLevel,CategoryHierarchy FROM " . TABLE_CATEGORY . " WHERE pkCategoryId = '$CatId' LIMIT 1";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes[0];
    }
    
    /**
     * function getCategoryName
     *
     * This function is used display category details.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 int optional
     *
     * @return string $arrRes
     */
    function getCategoryName($CatId = '0') {
        $varQuery = "SELECT CategoryName FROM " . TABLE_CATEGORY . " WHERE pkCategoryId = '$CatId' LIMIT 1";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes[0];
    }

    /**
     * function getSpecialBanner
     *
     * This function is used get special page banner.
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getSpecialBanner($page = 'special',$cId=0) {
        global $objCore;
        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
        $whereCid=$cId!='' || $cId!=0 ?' AND fkCategoryId="'.$cId.'"':''; 
        $varQuery = "SELECT pkBannerID,BannerTitle,BannerImageName,UrlLinks FROM " . TABLE_BANNER . " WHERE BannerStatus='1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' $whereCid AND BannerPage='" . $page . "' ORDER BY BannerOrder ASC,pkBannerID desc LIMIT 10";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    
    function getSpecialBann($page = 'special',$fId=0) {
        global $objCore;
        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
        $whereCid=$fId!='' || $fId!=0 ?' AND fkFestivalID="'.$fId.'"':''; 
        $varQuery = "SELECT pkBannerID,BannerTitle,BannerImageName FROM " . TABLE_BANNER . " WHERE BannerStatus='1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' $whereCid AND BannerPage='" . $page . "' ORDER BY BannerOrder ASC,pkBannerID desc LIMIT 10";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getSpecialProduct
     *
     * This function is used get special products.
     *
     * Database Tables used in this function are : tbl_banner, tbl_special_product,tbl_festival,tbl_product,tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    function getSpecialProduct($fid=0) {
        
        global $objCore;
        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
        $varQuery = "SELECT fkCategoryID,CategoryName FROM " . TABLE_SPECIAL_PRODUCT . " INNER JOIN " . TABLE_FESTIVAL . " on fkFestivalID=pkFestivalID INNER JOIN " . TABLE_CATEGORY . " ON fkCategoryID=pkCategoryID  WHERE FestivalStatus='1' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "' AND fkFestivalID='$fid' GROUP BY fkCategoryID";
        //echo $fid.'<br>'.$varQuery;
        $arrCat = $this->getArrayResult($varQuery);
        //pre($arrCat);

        $arrRows = array();
        foreach ($arrCat as $key => $val) {
            $arrRows[$key] = $val;

//            if ($val['fkCategoryID'] == $cid) {
//                $strCat = "pkCategoryId ='" . $val['fkCategoryID'] . "'";
//            } else {
//                $strCat = "CategoryHierarchy like'%:" . $val['fkCategoryID'] . ":%' OR CategoryHierarchy like'%:" . $val['fkCategoryID'] . "' OR CategoryHierarchy like'" . $val['fkCategoryID'] . ":%' OR CategoryHierarchy ='" . $val['fkCategoryID'] . "'";
//            }
            $strCat = "CategoryHierarchy like'%:" . $val['fkCategoryID'] . ":%' OR CategoryHierarchy like'%:" . $val['fkCategoryID'] . "' OR CategoryHierarchy like'" . $val['fkCategoryID'] . ":%' OR CategoryHierarchy ='" . $val['fkCategoryID'] . "'";
            $varQuery = "SELECT pkProductID,discountPercent,ProductRefNo,sp.fkCategoryID,sp.fkWholesalerID,ProductName,ProductImage,FinalPrice,DiscountFinalPrice,FinalSpecialPrice,Quantity,ProductDescription,count(fkAttributeId) as Attribute 
                FROM " . TABLE_SPECIAL_PRODUCT . " as sp INNER JOIN " . TABLE_FESTIVAL . " on sp.fkFestivalID=pkFestivalID INNER JOIN " . TABLE_PRODUCT . " ON fkProductID=pkProductID INNER JOIN " . TABLE_CATEGORY . " ON pkCategoryId = sp.fkCategoryID LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
                    WHERE FestivalStatus='1' AND sp.fkFestivalID='".$fid."' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "' AND ProductStatus='1' AND (" . $strCat . ") 
                        Group By pkProductID LIMIT 0,10";
            $arrPro = $this->getArrayResult($varQuery);

            $arrRows[$key]['Products'] = $arrPro;
        }
        //pre($arrRows);
        return $arrRows;
    }

    /**
     * function getBreadcrumbSpecial
     *
     * This function is used get breadcrumbs details.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 int 
     *
     * @return string $varStr
     */
    function getBreadcrumbSpecial($cid) {
        global $objCore;

        $varQuery = "select pkCategoryId,CategoryName,CategoryHierarchy from " . TABLE_CATEGORY . " where pkCategoryId ='" . $cid . "' ORDER BY CategoryHierarchy ASC";
        $arrRes = $this->getArrayResult($varQuery);
        $arrIds = explode(':', $arrRes['0']['CategoryHierarchy']);
        $varStr = '';
        $num = count($arrIds);

        global $objCore;
        $i = 1;
        foreach ($arrIds as $val) {
            $varQuery = "select pkCategoryId,CategoryName from " . TABLE_CATEGORY . " where pkCategoryId ='" . $val . "'";
            $arrRes = $this->getArrayResult($varQuery);
            if ($num == $i) {
                $varStr .= ucfirst($arrRes[0]['CategoryName']);
            } else {
                $varStr .= '<a class="ajax_special breadcurmbs" href="' . $arrRes[0]['pkCategoryId'] . '" >' . ucfirst($arrRes[0]['CategoryName']) . '</a> >> ';
            }
            $i++;
        }

        return $varStr;
    }

    /**
     * function getLandingProduct
     *
     * This function is used get landing products.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    function getLandingProduct($cid = 0, $sortby = 'pkProductID DESC', $lim_from, $lim_row) {
        global $objCore;

        $arrSort = array(
            'Recently Added' => 'pkProductID DESC',
            'A-Z' => 'ProductName ASC',
            'Z-A' => 'ProductName DESC',
            'Price (Low > High)' => 'price ASC',
            'Price (High > Low)' => 'price DESC'
        );

        $sortby = $arrSort[$sortby];
        $sortby = ($sortby) ? $sortby : 'pkProductID DESC';

        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,product.fkCategoryID,CategoryLevel,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,IF(DiscountFinalPrice >0, DiscountFinalPrice, FinalPrice) as price,  Quantity,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute
          FROM " . TABLE_PRODUCT . " product LEFT JOIN ".TABLE_SPECIAL_PRODUCT." sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = product.fkCategoryID AND (CategoryHierarchy like'" . $cid . ":%' OR CategoryHierarchy ='" . $cid . "') AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1') INNER JOIN " . TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
          Group By pkProductID ORDER BY " . $sortby . " 
          limit " . $lim_from . "," . $lim_row;

        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }
    
    /**
     * function getParentCategory
     *
     * This function is used get landing products.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    
    public function getParentCategory($cid=0){
       
     $pCategory=array('CategoryParentId');   
     $tb = TABLE_CATEGORY;
     $wh = "pkCategoryId='".$cid."'";
     $arrRes = $this->select($tb,$pCategory,$wh); 
     return $arrRes[0]['CategoryParentId'];
    }
    
    
    
    /**
     * function getParentCategory
     *
     * This function is used get landing products.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    
    public function getParentCategoryName($cid=0){
       
     $pCategory=array('CategoryParentId');   
     $tb = TABLE_CATEGORY;
     $wh = "pkCategoryId='".$cid."'";
     $arrRes = $this->select($tb,$pCategory,$wh); 
      $whName = "pkCategoryId='".$arrRes[0]['CategoryParentId']."'";
      $pCategoryName=array('CategoryName');   
      $reParent =$this->select($tb,$pCategoryName,$whName); 
      return $reParent[0]['CategoryName'];
    }
    
    
    /**
     * function getParentCategoryDetails
     *
     * This function is used get .
     * HEMANT SUMAN
     */
    
    public function getParentCategoryDetails($cid=0){
       
     $pCategory=array('CategoryParentId');   
     $tb = TABLE_CATEGORY;
     $varQuery = "SELECT b.CategoryParentId,a.pkCategoryId,b.pkCategoryId,b.CategoryName as CategoryChildName, a.CategoryName as CategoryParentName FROM tbl_category a INNER JOIN tbl_category b ON b.CategoryParentId = a.pkCategoryId WHERE b.pkCategoryId = ' $cid ' ";
     $arrRes = $this->getArrayResult($varQuery); 
     //pre($arrRes);
     //$arrRes = getParentCategoryName($arrResId[0]['CategoryParentId']); 
     return $arrRes;
    }
    
    
    
    /**
     * function parentCategoryMenu
     *
     * This function is used get landing products.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    
    public function parentCategoryMenu($id=0){
       $varQuery="SELECT c.pkCategoryId,c.CategoryName FROM tbl_product inner join tbl_category a on fkCategoryID=a.pkCategoryId join tbl_category b on (a.CategoryParentId=b.pkCategoryId) join tbl_category c on (b.CategoryParentId=c.pkCategoryId and c.CategoryLevel=0) where fkWholesalerID='".(int) $id."' group by c.pkCategoryId"; 
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }
    /**
     * function subCategoryMenu
     *
     * This function is used get landing products.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    public function subCategoryMenu($id=0){
       $varQuery="SELECT b.pkCategoryId,b.CategoryName FROM tbl_product inner join tbl_category a on fkCategoryID=a.pkCategoryId join tbl_category b on
a.CategoryParentId=b.pkCategoryId where fkWholesalerID='".(int) $id."' group by b.pkCategoryId"; 
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }
    
    /**
     * function getMonthPremium
     *
     * This function is used get monthly premium wholesaler.
     *
     * Database Tables used in this function are : tbl_premium_monthly_wholesaler, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    public function getMonthPremium($id=0){
      $varQuery="SELECT pkWholesalerID, CompanyName, AboutCompany, Services, CompanyPhone, wholesalerLogo,pw.fkWholesalerID,totalAmount,productSale,positiveFeedback,wholesalerKpi FROM tbl_product p inner join tbl_premium_monthly_wholesaler pw on p.fkWholesalerID=pw.fkWholesalerID inner join tbl_wholesaler a on pw.fkWholesalerID=a.pkWholesalerID where fkCategoryPremiumID='{$id}' AND WholesalerStatus='active' group by a.pkWholesalerID order by totalAmount DESC,wholesalerKpi DESC limit 6";
      
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }
    
    /**
     * function getMonthPremium
     *
     * This function is used get monthly premium wholesaler.
     *
     * Database Tables used in this function are : tbl_premium_monthly_wholesaler, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    public function getCategoryId($id=0){
       $varQuery="SELECT pkCategoryId FROM tbl_category where CategoryName='".mysql_real_escape_string($id)."' AND CategoryStatus='1' AND CategoryIsDeleted='0'";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes[0]['pkCategoryId'];
    }
    
    
    
    /**
     * function wholesalerKpi
     *
     * This function is used to calculate wholesaler kpi in % .
     *
     * Database Tables used in this function are : TABLE_WHOLESALER,TABLE_ORDER_ITEMS
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function wholesalerKpi($catId=0) {
        // Fetch all wholesaler who product has been sold.
       $arrKpiSettingRowSold = $this->getArrayResult("SELECT productSold,KPIValue FROM " . TABLE_KPI_PRE_SETTING . " WHERE 1"); 
       $varWholesalerFetchQuery = "SELECT distinct(OI.fkWholesalerID) as fkWholesalerID,TIMESTAMPDIFF(MONTH, WholesalerDateAdded, NOW()) as life,sum( OI.Quantity) AS orders FROM " . TABLE_ORDER_ITEMS . " OI INNER JOIN " . TABLE_WHOLESALER . " ON OI.fkWholesalerID=pkWholesalerID INNER JOIN ".TABLE_PRODUCT."  product ON (fkItemID=product.pkProductID) WHERE product.fkCategoryID='".(int) $catId."' GROUP BY fkWholesalerID HAVING orders >='{$arrKpiSettingRowSold[0]['productSold']}'";
        $arrOrderedWholesaler = $this->getArrayResult($varWholesalerFetchQuery);
        //mail('raju.khatak@mail.vinove.com','whol',print_r($arrOrderedWholesaler,1));
        if (count($arrOrderedWholesaler) > 0) {

            foreach ($arrOrderedWholesaler as $key => $whid) {
                $varKpiSaleTarget = $arrKpiSettingRowSold[0]['productSold'];
                $varKpiKpiTarget = $arrKpiSettingRowSold[0]['KPIValue'];
                $arrSoldProduct = $this->getArrayResult("SELECT sum(OI.Quantity) as num,sum(ItemPrice*OI.Quantity) ItemPrice FROM " . TABLE_ORDER_ITEMS . " OI INNER JOIN ".TABLE_PRODUCT."  product ON (fkItemID=product.pkProductID) WHERE OI.fkWholesalerID='" . $whid['fkWholesalerID'] . "' AND product.fkCategoryID='".(int) $catId."'");
                $varTotalSoldProduct = $arrSoldProduct[0]['num']; // get total number of sold product
                $varTotalSoldProductPrice = $arrSoldProduct[0]['ItemPrice']; // get total number price of sold product
                $varWholesalerLife=$whid['life']>0?$whid['life']:1;// get life of wholesaler in month
                //mail('raju.khatak@mail.vinove.com','sold',$varTotalSoldProduct);
                //mail('raju.khatak@mail.vinove.com','sale',$varKpiSaleTarget);

                if (trim($varTotalSoldProduct) >= trim($varKpiSaleTarget)) {
                    // get total positive feedback
                    $arrPostiveFeedback = $this->getArrayResult("SELECT count(pkFeedbackID) as num FROM " . TABLE_WHOLESALER_FEEDBACK . " wh INNER JOIN ".TABLE_PRODUCT."  product ON (fkProductID=product.pkProductID) WHERE wh.fkWholesalerID='" . $whid['fkWholesalerID'] . "' AND IsPositive='1' AND product.fkCategoryID='".(int) $catId."'");
                    // get total feedback
                    $arrTotalFeedback = $this->getArrayResult("SELECT count(pkFeedbackID) as num FROM " . TABLE_WHOLESALER_FEEDBACK . " wh INNER JOIN ".TABLE_PRODUCT."  product ON (fkProductID=product.pkProductID) WHERE wh.fkWholesalerID='" . $whid['fkWholesalerID'] . "' AND product.fkCategoryID='".(int) $catId."'");
//                    mail('raju.khatak@mail.vinove.com','PostiveFeedback',print_r($arrPostiveFeedback,1));
//                    mail('raju.khatak@mail.vinove.com','TotalFeedback',print_r($arrTotalFeedback,1));
//                     mail('vishal.choudhary@mail.vinove.com','PostiveFeedback',print_r($arrPostiveFeedback,1));
//                    mail('vishal.choudhary@mail.vinove.com','TotalFeedback',print_r($arrTotalFeedback,1));
                    
                   


                    $varTotalFeedback = $arrTotalFeedback[0]['num'];
                    $varPostiveFeedback = $arrPostiveFeedback[0]['num'];
                    $kpi = ($varPostiveFeedback / $varTotalFeedback) * 100; // get kpi in %
                    $kpi = number_format($kpi, 2);
//                    mail('raju.khatak@mail.vinove.com','kpi',$kpi);
//                    mail('raju.khatak@mail.vinove.com','whol',$whid['fkWholesalerID']);
//                    mail('vishal.choudhary@mail.vinove.com','whol',$whid['fkWholesalerID']);
//                    mail('vishal.choudhary@mail.vinove.com','kpi',$kpi);
                    
                    
                    
                    // business condition
                    if (trim($kpi) >= trim($varKpiKpiTarget)) {
                        $arrRes['details'][$whid['fkWholesalerID']]['kpi'] = $kpi;
                        $arrRes['details'][$whid['fkWholesalerID']]['productSale'] = $varTotalSoldProduct;
                        $arrRes['details'][$whid['fkWholesalerID']]['totalAmount'] = $varTotalSoldProductPrice;
                        $arrRes['details'][$whid['fkWholesalerID']]['positiveFeedback'] = $varPostiveFeedback;
                    }
                    if (count($arrRes) >= 50) {
                        break;
                    }
                }
            }
        }
        $queryDelete = "DELETE FROM tbl_premium_wholesaler";
        $this->getArrayResult($queryDelete);

        if (count($arrRes['details']) > 0) {
            $counter = 1;
            $query = 'INSERT INTO tbl_premium_wholesaler VALUES';
            foreach ($arrRes['details'] as $key => $value) {
                $fkWholesalerID = trim($key);
                $totalAmount = trim($value['totalAmount']);
                $productSale = trim($value['productSale']);
                $positiveFeedback = trim($value['positiveFeedback']);
                $wholesalerKpi = trim($value['kpi']);
                $query.=" ({$fkWholesalerID},{$totalAmount},{$productSale},{$positiveFeedback},{$wholesalerKpi})";
                if (count($arrRes['details']) > $counter) {
                    $query.=",";
                }
                $counter++;
            }
            $getData = $this->getArrayResult("SELECT fkWholesalerID FROM tbl_premium_wholesaler");
            if (count($getData) == 0) {
                $arrResData = $this->getArrayResult($query);
            }
        }
       
        return $arrResData;
    }
    
    
    /**
     * function getWeekPremium
     *
     * This function is used get weekly premium wholesaler.
     *
     * Database Tables used in this function are : tbl_premium_wholesaler, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    public function getWeekPremium($id=0){
       $varQuery="SELECT pkWholesalerID, CompanyName, AboutCompany, Services, CompanyPhone, wholesalerLogo,pw.fkWholesalerID,totalAmount,productSale,positiveFeedback,wholesalerKpi FROM tbl_product p inner join tbl_premium_wholesaler pw on p.fkWholesalerID=pw.fkWholesalerID inner join tbl_wholesaler a on pw.fkWholesalerID=a.pkWholesalerID where p.fkCategoryID='{$id}' AND WholesalerStatus='active' group by a.pkWholesalerID order by totalAmount DESC , wholesalerKpi DESC limit 50"; 
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }
    

}

?>
