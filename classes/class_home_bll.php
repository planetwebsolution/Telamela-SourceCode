<?php

/**
 * Site homePage Class
 *
 * This is the home page class it will used on website for home page.
 *
 * DateCreated 1th August, 2013
 *
 * DateLastModified 1st Sept, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class Home extends Database
{

    function __construct()
    {
        $this->homeSliderLimit = 8; //In Multiple Of 4
        $this->topSellingProductDisplayLimit = 18; //Multiple Of 3
        $this->recentlyViewedProductsDisplayLimit = 6; //Multiple Of 3
        $this->featureProductsDisplayLimit = 6; //Multiple Of 3
        $this->topRatedProductDisplayLimit = 5;
        $this->topRatedCategoryDisplayLimit = 9;
        $this->homePageAdsDisplayLimit = 5;
        $this->latestProductDisplayLimit = 10;
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function featureProducts
     *
     * This function is used to retrive feature Products details.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function featureProducts($todayOfferProduct)
    {
        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,Quantity,ProductDescription,ProductImage,count(fkAttributeId) as Attribute
            FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = fkCategoryID AND IsFeatured = '1' AND ProductStatus='1' AND (DateStart='0000-00-00' OR DateStart<='2013-12-19') AND (DateEnd='0000-00-00' OR DateEnd>='2013-12-19') AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
            INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
            Group By pkProductID ORDER BY ProductDateUpdated DESC
            limit 0," . $this->featureProductsDisplayLimit;

        $arrRes = $this->getArrayResult($varQuery);
        /*
          $i = 0;
          foreach ($arrRes AS $prod) {
          $varQuery = "SELECT ImageName FROM " . TABLE_PRODUCT_IMAGE . " WHERE fkProductID = '" . $prod['pkProductID'] . "'";
          $arrProdImg = $this->getArrayResult($varQuery);
          $arrRes[$i]['arrproductImages'] = $arrProdImg;
          $arrRes[$i]['arrAttributes'] = $this->getAttributeDetails($prod['pkProductID']);
          $i++;
          }
         */
        //  pre($arrRes);
        return $arrRes;
    }

    /**
     * function RecentlyViewedProducts
     *
     * This function is used to retrive Recently Viewed Products details.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function RecentlyViewedProducts($todayOfferProduct)
    {

        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice, DiscountFinalPrice,discountPercent,Quantity,ProductDescription,ProductImage
            FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON (pkCategoryId = product.fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
            INNER JOIN " . TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
            Group By pkProductID ORDER BY LastViewed DESC
            limit 0," . $this->recentlyViewedProductsDisplayLimit;

        $arrRes = $this->getArrayResult($varQuery);


        /*
          $i = 0;
          foreach ($arrRes AS $prod) {
          $varQuery = "SELECT ImageName FROM " . TABLE_PRODUCT_IMAGE . " WHERE fkProductID = '" . $prod['pkProductID'] . "'";
          $arrProdImg = $this->getArrayResult($varQuery);
          $arrRes[$i]['arrproductImages'] = $arrProdImg;
          $arrRes[$i]['arrAttributes'] = $this->getAttributeDetails($prod['pkProductID']);
          $i++;
          }

         */
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getAdsDetails
     *
     * This function is used to get Ads Details .
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getAdsDetails()
    {
        $varQuery = "SELECT pkAdID,AdType,Title,AdUrl,ImageName,HtmlCode
            FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND `AdsPage` = 'Home Page' order by rand() limit 0,2";

        $arrRes = $this->getArrayResult($varQuery);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function getTodayOfferProduct
     *
     * This function is used to get get Today's Offer Product Details.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getTodayOfferProduct()
    {
        $varQuery = "SELECT * FROM `tbl_product_today_offer` ";

        $arrRes['offer_details'] = $this->getArrayResult($varQuery);

        $varQuery2 = "SELECT pkProductID,ProductName,FinalPrice, DiscountFinalPrice, ProductDescription,ProductImage
            FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON (pkCategoryId = fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID = '" . $arrRes['offer_details'][0]['fkProductId'] . "')
            INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LIMIT 1";


        $arrRes['product_details'] = $this->getArrayResult($varQuery2);

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getHomeBanners
     *
     * This function is used to get Home page banner.
     *
     * Database Tables used in this function are : tbl_home_banner, tbl_festival, tbl_home_banner_links
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getHomeBanners()
    {
        global $objCore;
        global $objGeneral;

        $varCountry = $objGeneral->getCountryByIp();
		//echo $varCountry; die;
        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
        //$varQuery = "SELECT BannerOrder,pkBannerID,BannerTitle,BannerImageName,FestivalTitle,pkFestivalID FROM " . TABLE_HOME_BANNER . " INNER JOIN " . TABLE_FESTIVAL . " as f ON fkFestivalID = pkFestivalID  WHERE BannerStatus = '1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' AND FestivalStatus='1' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "' AND (FIND_IN_SET('" . $varCountry . "',f.CountryIDs) OR FIND_IN_SET('0',f.CountryIDs)) ORDER BY BannerOrder ASC  limit 0," . $this->homeSliderLimit;
        
        $varQuery = "SELECT BannerOrder,pkBannerID,BannerTitle,BannerImageName,FestivalTitle,pkFestivalID FROM " . TABLE_HOME_BANNER . " as b INNER JOIN " . TABLE_FESTIVAL . " as f ON fkFestivalID = pkFestivalID  WHERE BannerStatus = '1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' AND FestivalStatus='1' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "' AND b.CountryIDs IN('" . $varCountry . "','0') ORDER BY BannerOrder ASC  limit 0," . $this->homeSliderLimit;
       //pre($varQuery);
        //Create memcache object
        global $oCache;
        //Create object key for cache object
        $varQueryKey = md5($varQuery);
        //Check memcache is enabled or not
        if ($oCache->bEnabled)
        { // if Memcache enabled
            if (!$oCache->getData($varQueryKey))
            {
                $arrRes1 = $this->getArrayResult($varQuery);
                $oCache->setData($varQueryKey, serialize($arrRes1));
            }
            else
            {
                $arrRes1 = unserialize($oCache->getData($varQueryKey));
            }
        }
        else
        {
            $arrRes1 = $this->getArrayResult($varQuery);
        }


        if (count($arrRes1) == 0)
        {
            $varQuery = "SELECT BannerOrder,pkBannerID,BannerTitle,BannerImageName,FestivalTitle,pkFestivalID FROM " . TABLE_HOME_BANNER . " INNER JOIN " . TABLE_FESTIVAL . " as f ON fkFestivalID = pkFestivalID  WHERE  BannerStatus = '1' AND BannerStartDate <='" . $curDate . "' AND BannerEndDate>='" . $curDate . "' AND FestivalStatus='1' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "' AND FIND_IN_SET('0',f.CountryIDs) ORDER BY BannerOrder ASC  limit 0," . $this->homeSliderLimit;

            //Create object key for cache object
            $varQueryKey = md5($varQuery);
            //Check memcache is enabled or not
            if ($oCache->bEnabled)
            { // if Memcache enabled
                if (!$oCache->getData($varQueryKey))
                {
                    $arrRes1 = $this->getArrayResult($varQuery);
                    $oCache->setData($varQueryKey, serialize($arrRes1));
                }
                else
                {
                    $arrRes1 = unserialize($oCache->getData($varQueryKey));
                }
            }
            else
            {
                $arrRes1 = $this->getArrayResult($varQuery);
            }
        }

        $arrRow = array();
        $arrBIds = array();
        foreach ($arrRes1 as $k => $v)
        {
            $arrBIds[] = $v['pkBannerID'];
            $arrRow[$v['pkBannerID']] = $v;
        }

        $ids = implode(',', $arrBIds);
        if ($ids <> '')
        {
            $varQuery = "SELECT fkBannerID,UrlLinks,Offer,linkImagePosition FROM " . TABLE_HOME_BANNER_LINKS . " WHERE  fkBannerID IN(" . $ids . ") ";

            //Create object key for cache object
            $varQueryKey = md5($varQuery);
            //Check memcache is enabled or not
            if ($oCache->bEnabled)
            { // if Memcache enabled
                if (!$oCache->getData($varQueryKey))
                {
                    $arrRes2 = $this->getArrayResult($varQuery);
                    $oCache->setData($varQueryKey, serialize($arrRes2));
                }
                else
                {
                    $arrRes2 = unserialize($oCache->getData($varQueryKey));
                }
            }
            else
            {
                $arrRes2 = $this->getArrayResult($varQuery);
            }



            foreach ($arrRes2 as $val)
            {
                $arrRow[$val['fkBannerID']]['arrLinks'][] = $val;
            }
        }
      //  pre($arrRow);
        return $arrRow;
    }

    /**
     * function getLatestProducts
     *
     * This function is used to get Latest Products Details.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getLatestProducts($todayOfferProduct)
    {
        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,ProductDescription,ProductImage,ProductSliderImage
            FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
            INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')
            ORDER BY pkProductID DESC
            limit 0," . $this->latestProductDisplayLimit;


        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getTopSellingProducts
     *
     * This function is used to get Top Selling Products Details.
     *
     * Database Tables used in this function are : tbl_product, tbl_order_items, tbl_category, tbl_wholesaler, tbl_product_to_option, tbl_product_rating
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getTopSellingProducts($todayOfferProduct)
    {
        global $objCore;

//        $updateProduct="select pkProductID,FinalPrice,DiscountFinalPrice from " . TABLE_PRODUCT . "";
//        $updateProductQuery = $this->getArrayResult($updateProduct);
//        foreach($updateProductQuery as $updateProductQueryVal){
//        $productDiscountPercent=$objCore->getProductDiscount(trim($updateProductQueryVal['FinalPrice']),trim($updateProductQueryVal['DiscountFinalPrice']));
//        mysql_query("update " . TABLE_PRODUCT . " set discountPercent=".$productDiscountPercent." where pkProductID=".$updateProductQueryVal['pkProductID']."");
//        }

        $dateAfter = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
        $varQuery = "SELECT p.Sold,p.pkProductID,sum(oi.Quantity) as pnum,p.ProductRefNo,p.ProductName,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,p.FinalPrice,FinalSpecialPrice,p.DiscountFinalPrice,discountPercent,p.Quantity,p.ProductDescription,p.ProductDateAdded,p.ProductImage
            FROM " . TABLE_PRODUCT . " as p LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID
                INNER JOIN " . TABLE_ORDER_ITEMS . " as oi ON  (pkProductID = fkItemID AND ItemDateAdded<= '" . $dateAfter . "' AND ItemType='product')
                    INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = p.fkCategoryID AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')
                        INNER JOIN " . TABLE_WHOLESALER . " ON (p.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')
                            LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON p.pkProductID = pto.fkProductId
                                
            Group By pkProductID HAVING p.Sold>1 ORDER BY p.Sold DESC
            limit 0," . $this->topSellingProductDisplayLimit;

        $arrRes = $this->getArrayResult($varQuery);


//        $arrRows = array();
//        $i = 0;
//        foreach ($arrRes as $key => $val) {
//            $arrRows[$i][] = $val;
//            if ($key % 2 == 1) {
//                $i++;
//            }
//        }
        //pre($arrRows);
        return $arrRes;
    }

    /**
     * function categoryLatestPoducts
     *
     * This function is used to get Latest Products Details.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
//    function categoryLatestPoducts($todayOfferProduct, $arrMainCat) {
//
//        $arrRow = array();
//
//        foreach ($arrMainCat as $key => $val) {
//            $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,DiscountFinalPrice,Quantity,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute
//          FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = fkCategoryID AND (CategoryHierarchy like'" . $val['pkCategoryId'] . ":%' OR CategoryHierarchy ='" . $val['pkCategoryId'] . "') AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct') INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
//          Group By pkProductID ORDER BY pkProductID DESC
//          limit 0," . $this->latestProductDisplayLimit;
//
//
//            $arrRes = $this->getArrayResult($varQuery);
//            if ($arrRes) {
//                $arrRow[$val['pkCategoryId']]['arrCategory'] = $val;
//                $arrRow[$val['pkCategoryId']]['arrProducts'] = $arrRes;
//            }
//        }
//
//        //pre($arrRow);
//        return $arrRow;
//    }


    function categoryLatestPoducts($todayOfferProduct, $arrMainCat)
    {

        $arrRow = array();
        

        foreach ($arrMainCat as $key => $val)
        { //pre($val);
            //$categoryIds= is_array($val['pkCategoryId'])?$val['pkCategoryId']:$val;
            $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,IF(sum(atInv.OptionQuantity)>0,sum(atInv.OptionQuantity),Quantity) as Quantity,discountPercent,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
          FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = product.fkCategoryID AND (CategoryHierarchy like'" . $val['pkCategoryId'] . ":%' OR CategoryHierarchy ='" . $val['pkCategoryId'] . "') AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct') INNER JOIN " . TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_PRODUCT_OPTION_INVENTORY . " as atInv ON pkProductID = atInv.fkProductID
          Group By pkProductID  ORDER BY pkProductID DESC
          limit 0," . $this->latestProductDisplayLimit;
            //Create memcache object
            global $oCache;
            //Create object key for cache object
            $varQueryKey = md5($varQuery);
            //Check memcache is enabled or not
            if ($oCache->bEnabled)
            { // if Memcache enabled
                if (!$oCache->getData($varQueryKey))
                {
                    $arrRes = $this->getArrayResult($varQuery);
                    $oCache->setData($varQueryKey, serialize($arrRes));
                }
                else
                {
                    $arrRes = unserialize($oCache->getData($varQueryKey));
                }
            }
            else
            {
                $arrRes = $this->getArrayResult($varQuery);
            }

            if ($arrRes)
            {
                $arrRow[$val['pkCategoryId']]['arrCategory'] = $val;
                $arrRow[$val['pkCategoryId']]['arrProducts'] = $arrRes;
            }
        }

        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function getTopRatedProds
     *
     * This function is used to get Top Rated Product Details.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_rating
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getTopRatedProds($todayOfferProduct, $cid = 0,$module=null, $arrMainCat=null)
    {
        if($module=="home"){
            $arrRow = array();
            //pre($arrMainCat);die;
            $finalResult = array();
            foreach ($arrMainCat as $key => $val)
            { //pre($val);
                //$categoryIds= is_array($val['pkCategoryId'])?$val['pkCategoryId']:$val;
                    
                //$varQuery = "SELECT Quantity,avg(Rating) AS Rating, pkCategoryId,CategoryName,CategoryHierarchy,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as parentCID FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . "  ON (pkCategoryId = fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')  INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') INNER JOIN " . TABLE_PRODUCT_RATING . " AS pr ON pkProductID=pr.fkProductID where RatingApprovedStatus='Allow' Group By parentCID ORDER BY pr.Rating DESC limit 0," . $this->topRatedCategoryDisplayLimit;
                    
                $varQuery = "SELECT Quantity,avg(Rating) AS Rating, pkCategoryId,CategoryName,CategoryHierarchy,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as parentCID
                  FROM " . TABLE_PRODUCT . " product INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = product.fkCategoryID AND (CategoryHierarchy like'" . $val['pkCategoryId'] . ":%' OR CategoryHierarchy ='" . $val['pkCategoryId'] . "') AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct') INNER JOIN " . TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') INNER JOIN " . TABLE_PRODUCT_RATING . " AS pr ON pkProductID=pr.fkProductID where RatingApprovedStatus='Allow' Group By parentCID ORDER BY pr.Rating DESC limit 0," . $this->topRatedCategoryDisplayLimit;
                    
                //echo $varQuery.'<br>===============================================================<br>';
                //Create memcache object
                global $oCache;
                //Create object key for cache object
                $varQueryKey = md5($varQuery);
                //Check memcache is enabled or not
                if ($oCache->bEnabled)
                { // if Memcache enabled
                    if (!$oCache->getData($varQueryKey))
                    {
                        $arrResCate = $this->getArrayResult($varQuery);
                        $oCache->setData($varQueryKey, serialize($arrResCate));
                    }
                    else
                    {
                        $arrResCate = unserialize($oCache->getData($varQueryKey));
                    }
                }
                else
                {
                    $arrResCate = $this->getArrayResult($varQuery);
                }
        
        
                //pre($arrResCate);
                //echo '<br>===============================================================<br>';
                //echo  $this->topRatedCategoryDisplayLimit;
                //die;
                $lim = (count($arrResCate) < $this->topRatedCategoryDisplayLimit) ? count($arrResCate) : $this->topRatedCategoryDisplayLimit;
                $i = 0;
                
                while ($i < $lim)
                {
        
                    $arrResCate[$i]['parentCID'] = $cid <> 0 ? $cid : $arrResCate[$i]['parentCID'];
                    $varQuery = "SELECT (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,discountPercent,ProductImage,Quantity, avg(Rating) AS Rating,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as pkCategoryId, (SELECT CategoryName from " . TABLE_CATEGORY . " WHERE pkCategoryId = '" . $arrResCate[$i]['parentCID'] . "' ) as CategoryName
                    FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID
                    WHERE ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' AND pkProductID !='$todayOfferProduct' AND (CategoryHierarchy = '" . $arrResCate[$i]['parentCID'] . "' OR CategoryHierarchy like '" . $arrResCate[$i]['parentCID'] . ":%')
                    AND RatingApprovedStatus='Allow' Group By pkProductID ORDER BY avg(Rating) DESC
                    limit 0," . $this->topRatedProductDisplayLimit;
                    //echo $varQuery.'<br>===============================================================<br>';
                    //Create memcache object
                    global $oCache;
                    //Create object key for cache object
                    $varQueryKey = md5($varQuery);
                    //Check memcache is enabled or not
                    if ($oCache->bEnabled)
                    { // if Memcache enabled
                        if (!$oCache->getData($varQueryKey))
                        {
                            $arrResProd = $this->getArrayResult($varQuery);
                            $oCache->setData($varQueryKey, serialize($arrResProd));
                        }
                        else
                        {
                            $arrResProd = unserialize($oCache->getData($varQueryKey));
                        }
                    }
                    else
                    {
                        $arrResProd = $this->getArrayResult($varQuery);
                    }
                    //echo "<pre>";
                    //print_r($arrResProd);
                    $finalResult[] = $arrResProd;
                    $i++;
                }
            }
            //echo "<pre>";
            //print_r($finalResult);
            //die;
            //
        }else{
            $varQuery = "SELECT Quantity,avg(Rating) AS Rating, pkCategoryId,CategoryName,CategoryHierarchy,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as parentCID FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . "  ON (pkCategoryId = fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct')  INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') INNER JOIN " . TABLE_PRODUCT_RATING . " AS pr ON pkProductID=pr.fkProductID where RatingApprovedStatus='Allow' Group By parentCID ORDER BY pr.Rating DESC limit 0," . $this->topRatedCategoryDisplayLimit;
    
            //Create memcache object
            global $oCache;
            //Create object key for cache object
            $varQueryKey = md5($varQuery);
            //Check memcache is enabled or not
            if ($oCache->bEnabled)
            { // if Memcache enabled
                if (!$oCache->getData($varQueryKey))
                {
                    $arrResCate = $this->getArrayResult($varQuery);
                    $oCache->setData($varQueryKey, serialize($arrResCate));
                }
                else
                {
                    $arrResCate = unserialize($oCache->getData($varQueryKey));
                }
            }
            else
            {
                $arrResCate = $this->getArrayResult($varQuery);
            }
    
    
            //pre($arrResCate);
            $lim = (count($arrResCate) < $this->topRatedCategoryDisplayLimit) ? count($arrResCate) : $this->topRatedCategoryDisplayLimit;
            $i = 0;
            $finalResult = array();
            while ($i < $lim)
            {
    
                $arrResCate[$i]['parentCID'] = $cid <> 0 ? $cid : $arrResCate[$i]['parentCID'];
                $varQuery = "SELECT (select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice,pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,discountPercent,ProductImage,Quantity, avg(Rating) AS Rating,SUBSTRING_INDEX(CategoryHierarchy, ':',1) as pkCategoryId, (SELECT CategoryName from " . TABLE_CATEGORY . " WHERE pkCategoryId = '" . $arrResCate[$i]['parentCID'] . "' ) as CategoryName
                FROM " . TABLE_PRODUCT . " product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON product.fkWholesalerID = pkWholesalerID INNER JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID
                WHERE ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' AND pkProductID !='$todayOfferProduct' AND (CategoryHierarchy = '" . $arrResCate[$i]['parentCID'] . "' OR CategoryHierarchy like '" . $arrResCate[$i]['parentCID'] . ":%')
                AND RatingApprovedStatus='Allow' Group By pkProductID ORDER BY avg(Rating) DESC
                limit 0," . $this->topRatedProductDisplayLimit;
    
                //Create memcache object
                global $oCache;
                //Create object key for cache object
                $varQueryKey = md5($varQuery);
                //Check memcache is enabled or not
                if ($oCache->bEnabled)
                { // if Memcache enabled
                    if (!$oCache->getData($varQueryKey))
                    {
                        $arrResProd = $this->getArrayResult($varQuery);
                        $oCache->setData($varQueryKey, serialize($arrResProd));
                    }
                    else
                    {
                        $arrResProd = unserialize($oCache->getData($varQueryKey));
                    }
                }
                else
                {
                    $arrResProd = $this->getArrayResult($varQuery);
                }
    
    
                $finalResult[$i] = $arrResProd;
                $i++;
            }
        }
        //pre($finalResult);
        return $finalResult;
    }

    /**
     * function getAds
     *
     * This function is used to get ads Details.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getAds()
    {
        global $objCore;
        global $objGeneral;
       $varCountry = $objGeneral->getCountryByIp();

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

       $varQuery = "SELECT AdType, Title, AdUrl, ImageName, HtmlCode,(select count(addOrder) from tbl_advertisement where addOrder='1') as one,(select count(addOrder) from tbl_advertisement where addOrder='2') as two,(select count(addOrder) from tbl_advertisement where addOrder='3') as three,(select count(addOrder) from tbl_advertisement where addOrder='4') as four,(select count(addOrder) from tbl_advertisement where addOrder='5') as five FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND AdsStartDate<='" . $curDate . "' AND AdsEndDate >='" . $curDate . "' AND AdsPage = 'Home Page' AND (FIND_IN_SET('$varCountry',countryIds) OR countryIds=0) ORDER BY RAND() LIMIT " . $this->homePageAdsDisplayLimit;
       //mail('raju.khatak@mail.vinove.com','TestQuery',$varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    
    /**
     * function getAds
     *
     * This function is used to get ads Details.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getAdsOne()
    {
        global $objCore;
        global $objGeneral;
       $varCountry = $objGeneral->getCountryByIp();

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

       $varQuery = "SELECT AdType, Title, AdUrl, ImageName, HtmlCode FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND addOrder='1' AND AdsStartDate<='" . $curDate . "' AND AdsEndDate >='" . $curDate . "' AND AdsPage = 'Home Page' AND (FIND_IN_SET('$varCountry',countryIds) OR countryIds=0) ORDER BY RAND() LIMIT 1";
       //mail('raju.khatak@mail.vinove.com','TestQuery',$varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    
    /**
     * function getAds
     *
     * This function is used to get ads Details.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getAdsTwo()
    {
        global $objCore;
        global $objGeneral;
       $varCountry = $objGeneral->getCountryByIp();

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

       $varQuery = "SELECT AdType, Title, AdUrl, ImageName, HtmlCode FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND addOrder='2' AND AdsStartDate<='" . $curDate . "' AND AdsEndDate >='" . $curDate . "' AND AdsPage = 'Home Page' AND (FIND_IN_SET('$varCountry',countryIds) OR countryIds=0) ORDER BY RAND() LIMIT 1";
       //mail('raju.khatak@mail.vinove.com','TestQuery',$varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    /**
     * function getAds
     *
     * This function is used to get ads Details.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getAdsThree()
    {
        global $objCore;
        global $objGeneral;
       $varCountry = $objGeneral->getCountryByIp();

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

       $varQuery = "SELECT AdType, Title, AdUrl, ImageName, HtmlCode FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND addOrder='3' AND AdsStartDate<='" . $curDate . "' AND AdsEndDate >='" . $curDate . "' AND AdsPage = 'Home Page' AND (FIND_IN_SET('$varCountry',countryIds) OR countryIds=0) ORDER BY RAND() LIMIT 1";
       //mail('raju.khatak@mail.vinove.com','TestQuery',$varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    /**
     * function getAds
     *
     * This function is used to get ads Details.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getAdsFour()
    {
        global $objCore;
        global $objGeneral;
       $varCountry = $objGeneral->getCountryByIp();

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

       $varQuery = "SELECT AdType, Title, AdUrl, ImageName, HtmlCode FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND addOrder='4' AND AdsStartDate<='" . $curDate . "' AND AdsEndDate >='" . $curDate . "' AND AdsPage = 'Home Page' AND (FIND_IN_SET('$varCountry',countryIds) OR countryIds=0) ORDER BY RAND() LIMIT 1";
       //mail('raju.khatak@mail.vinove.com','TestQuery',$varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    /**
     * function getAds
     *
     * This function is used to get ads Details.
     *
     * Database Tables used in this function are : tbl_advertisement
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getAdsFive()
    {
        global $objCore;
        global $objGeneral;
       $varCountry = $objGeneral->getCountryByIp();

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

       $varQuery = "SELECT AdType, Title, AdUrl, ImageName, HtmlCode FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND addOrder='5' AND AdsStartDate<='" . $curDate . "' AND AdsEndDate >='" . $curDate . "' AND AdsPage = 'Home Page' AND (FIND_IN_SET('$varCountry',countryIds) OR countryIds=0) ORDER BY RAND() LIMIT 1";
       //mail('raju.khatak@mail.vinove.com','TestQuery',$varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getAttributeDetails
     *
     * This function is used to get Attribute Details for products.
     *
     * Database Tables used in this function are : tbl_product_to_option, tbl_attribute, tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getAttributeDetails($argPId = 0)
    {
//        $varQuery2 = "SELECT pkAttributeId,AttributeLabel,AttributeDesc,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle, GROUP_CONCAT(pkOptionID) as pkOptionID, GROUP_CONCAT(AttributeOptionValue) AS AttributeOptionValue,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice, GROUP_CONCAT(AttributeOptionImage) AS AttributeOptionImage,GROUP_CONCAT(optionColorCode) as colorcode,GROUP_CONCAT(IsImgUploaded) AS IsImgUploaded FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId LEFT JOIN ".TABLE_PRODUCT_OPTION_INVENTORY."  WHERE fkProductId = '" . $argPId . "' AND `AttributeVisible`='yes' GROUP BY pkAttributeId  order by AttributeOrdering ASC";
        
        $varQuery2 = "SELECT pkAttributeId,AttributeLabel,AttributeDesc,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle, GROUP_CONCAT(fkAttributeOptionId) as pkOptionID, GROUP_CONCAT(AttributeOptionValue) AS AttributeOptionValue,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice, GROUP_CONCAT(AttributeOptionImage) AS AttributeOptionImage,GROUP_CONCAT(optionColorCode) as colorcode,GROUP_CONCAT(IsImgUploaded) AS IsImgUploaded FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId  WHERE fkProductId = '" . $argPId . "' AND `AttributeVisible`='yes' GROUP BY pkAttributeId  order by AttributeOrdering ASC";
        
        global $oCache;
        //Create object key for cache object
        $varQueryKey = md5($varQuery2);
        //Check memcache is enabled or not
        if ($oCache->bEnabled)
        { // if Memcache enabled
            if (!$oCache->getData($varQueryKey))
            {
                $arrRes = $this->getArrayResult($varQuery2);
                $oCache->setData($varQueryKey, serialize($arrRes));
            }
            else
            {
                $arrRes = unserialize($oCache->getData($varQueryKey));
            }
        }
        else
        {
            $arrRes = $this->getArrayResult($varQuery2);
        }

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getQuickViewDetails
     *
     * This function is used to get quick view Details.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option, tbl_product_rating, tbl_review,tbl_product_today_offer, tbl_special_product, tbl_festival, tbl_product_image
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getQuickViewDetails($pid)
    {
        global $objCore;
        
//        $varQuery = "SELECT pkProductID,fkCategoryID,ProductRefNo,ProductName,FinalPrice, DiscountFinalPrice,Quantity, ProductDescription,fkWholesalerID,CompanyName,ProductImage,count(fkAttributeId) as Attribute, avg(Rating) AS Rating,count(pkReviewID) AS customerReviews
//            FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " . TABLE_PRODUCT_RATING . " AS pr  ON pkProductID=pr.fkProductID LEFT JOIN " . TABLE_REVIEW . " AS rev  ON pkProductID=rev.fkProductID
//            WHERE pkProductID='" . $pid . "'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active' AND pkProductID !=(SELECT fkProductId FROM " . TABLE_PRODUCT_TODAY_OFFER . " )
//            Group By pkProductID";
//Today's offer product details was not coming
        $varQuery = "SELECT pkProductID,fkCategoryID,ProductRefNo,ProductName,FinalPrice, DiscountFinalPrice,Quantity, ProductDescription,fkWholesalerID,CompanyName,ProductImage,count(fkAttributeId) as Attribute,
            (select avg(Rating) from " . TABLE_PRODUCT_RATING . " where fkProductID=pkProductID AND RatingApprovedStatus='Allow') AS Rating,
            (select count(pkReviewID) from " . TABLE_REVIEW . " where fkProductID=pkProductID AND ApprovedStatus='Allow') AS customerReviews,(select OfferPrice from tbl_product_today_offer where fkProductId=pkProductID) as offerPrice
            FROM " . TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = fkCategoryID INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId  WHERE pkProductID='" . $pid . "'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND WholesalerStatus = 'active'
            Group By pkProductID";
//        pre($varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        
        if (count($arrRes) > 0)
        {
            
            $curDate = $objCore->serverDateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
            $arrRes[0]['AttrQty'] = $this->getAttrQty($arrRes[0]['pkProductID']);

            $varQuerySpcl = "SELECT FinalSpecialPrice
            FROM " . TABLE_SPECIAL_PRODUCT . " INNER JOIN " . TABLE_FESTIVAL . " ON  fkFestivalID = pkFestivalID 
            WHERE fkProductID='" . $pid . "' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "'
            Group By fkProductID";
            $arrResSpcl = $this->getArrayResult($varQuerySpcl);
            
            $arrRes[0]['FinalSpecialPrice'] = $arrResSpcl[0]['FinalSpecialPrice'];
            //$arrRes[0]['FinalPrice'] = $arrResSpcl[0]['FinalSpecialPrice'];
            
            $varQuery = "SELECT ImageName FROM " . TABLE_PRODUCT_IMAGE . " WHERE fkProductID = '" . $pid . "' order by ImageDateAdded DESC";
            
            $arrProdImg = $this->getArrayResult($varQuery);
            
            
            
            $arrProdImages=array();
            $count=1;
            foreach($arrProdImg as $images){
                
                if($images['ImageName']==$arrRes[0]['ProductImage']){
                    $arrProdImages[0]=$images;
                }else{
                    $arrProdImages[$count]=$images;
                }
                $count++;
            }
            
            ksort($arrProdImages);
            $arrRes[0]['arrproductImages'] = $arrProdImages;
            //mail('sandeep.sharma@mail.vinove.com','hello',print_r($arrProdImages,1));
            //mail('sandeep.sharma@mail.vinove.com','hi',print_r($arrRes[0]['arrproductImages'],1));
            
            
            $arrRes[0]['arrAttributes'] = $this->getAttributeDetails($pid);
            //pre($arrRes[0]['arrAttributes']);
            $arrRes[0]['Quantity'] = (count($arrRes[0]['productAttribute']) > 0) ? $arrRes[0]['AttrQty'] : $arrRes[0]['Quantity'];
            //pre($arrRes[0]);
            
        }
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getAttrQty
     *
     * This function is used to get product image.
     *
     * Database Tables used in this function are :  tbl_product_option_inventory
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getAttrQty($pid)
    {
        $arrClms = array(
            'sum(OptionQuantity) as AttrQty'
        );
        $argWhere = "fkProductID = '" . $pid . "' ";

        $varTable = TABLE_PRODUCT_OPTION_INVENTORY;
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        return (int) $arrRes[0]['AttrQty'];
    }
    
    /**
     * function getWholesalerDefaultTemplate
     *
     * This function is used to get wholesaler default template name
     *
     * Database Tables used in this function are :  tbl_wholesaler_template
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getWholesalerDefaultTemplate()
    {
        $arrClms = array('pkTemplateId', 'templateName');
        $varWhere = ' templateDefault="1"';
        $arrRowsRecords = $this->select(TABLE_WHOLESALER_TEMPLATE, $arrClms, $varWhere);
        /*$arrRows = array();
        foreach ($arrRowsRecords as $valKPI) {
            $arrRows[$valKPI['fkCountryID']] = $valKPI['KPIValue'];
        }*/        
        return $arrRowsRecords;
    }

    /**
     * function getAllWholesalerDetails
     *
     * This function is used to retrive Wholesaler Details.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_country, tbl_region, tbl_wholesaler_to_shipping_gateway
     *
     * @access public
     *
     * @parameters 1 WholesalerId
     *
     * @return array $arrRes
     */
    function getAllWholesalerDetails()
    {

        $arrClms = array(
            'pkWholesalerID',
            'CompanyName',
            'AboutCompany',
            'Services',
            'Commission',
            'CompanyAddress1',
            'CompanyAddress2',
            'CompanyCity',
            'CompanyCountry',
            'c1.name as CompanyCountryName',
            'CompanyRegion',
            'RegionName',
            'CompanyPostalCode',
            'CompanyWebsite',
            'CompanyEmail',
            'CompanyPassword',
            'PaypalEmail',
            'CompanyPhone',
            'CompanyFax',
            'ContactPersonName',
            'ContactPersonPosition',
            'ContactPersonPhone',
            'ContactPersonEmail',
            'ContactPersonAddress',
            'OwnerName',
            'OwnerPhone',
            'OwnerEmail',
            'OwnerAddress',
            'Ref1Name',
            'Ref1Phone',
            'Ref1Email',
            'Ref1CompanyName',
            'Ref1CompanyAddress',
            'Ref2Name',
            'Ref2Phone',
            'Ref2Email',
            'Ref2CompanyName',
            'Ref2CompanyAddress',
            'Ref3Name',
            'Ref3Phone',
            'Ref3Email',
            'Ref3CompanyName',
            'Ref3CompanyAddress',
            'WholesalerStatus',
            'fkTemplateId',
            'wholesalerLogo'
        );
        $varWhr = "WholesalerStatus='active' order by pkWholesalerID DESC limit 5";

        $varTable = TABLE_WHOLESALER . " LEFT JOIN " . TABLE_COUNTRY . " as c1 ON CompanyCountry = country_id LEFT JOIN " . TABLE_REGION . " ON CompanyRegion = pkRegionID ";
        $arrRes = $this->select($varTable, $arrClms, $varWhr);
        return $arrRes;
    }

    /**
     * function getAllWholesalerDetailsHomePage
     *
     * This function is used to retrive Wholesaler Details on home page.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 WholesalerId
     *
     * @return array $arrRes
     */
    function getAllWholesalerDetailsHomePage()
    {
        $arrClms = array(
            'pkWholesalerID', 'CompanyName', 'AboutCompany', 'Services', 'CompanyPhone', 'wholesalerLogo'
        );
        $varWhr = "WholesalerStatus='active' order by pkWholesalerID DESC limit 5";

        $varTable = TABLE_WHOLESALER;
        $arrRes = $this->select($varTable, $arrClms, $varWhr);
        return $arrRes;
    }

    /**
     * function getAllHotDeals
     *
     * This function is used to get host deals( top discounted) product.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getAllHotDeals($arrMainCat)
    {
        //get category wise product
        //$arrMainCat all parent category array
        foreach ($arrMainCat as $key => $val)
        {
            $tableDiscounted = TABLE_PRODUCT . " as product LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID INNER JOIN " . TABLE_WHOLESALER . "  ON  ( product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active' ) INNER JOIN " . TABLE_CATEGORY . " ON  pkCategoryId = product.fkCategoryID";
            $arrDiscountedClms = array('pkProductID', 'Quantity', 'ProductName', 'FinalPrice', 'FinalSpecialPrice', 'DiscountFinalPrice', 'ProductImage', 'discountPercent');
            $whereDiscounted = "product.ProductStatus='1' AND floor( (FinalPrice - DiscountFinalPrice) / FinalPrice *100 ) >20 AND floor( (FinalPrice - DiscountFinalPrice) / FinalPrice *100 ) <=99 AND (CategoryHierarchy like'" . $val['pkCategoryId'] . ":%' OR CategoryHierarchy ='" . $val['pkCategoryId'] . "')";
            $orderDiscounted = "discountPercent DESC limit 10";
            $getDiscountedData = $this->select($tableDiscounted, $arrDiscountedClms, $whereDiscounted, $orderDiscounted);
            if ($getDiscountedData)
            {
                $arrRow[$val['pkCategoryId']]['arrCategory'] = $val;
                $arrRow[$val['pkCategoryId']]['arrProducts'] = $getDiscountedData;
            }
        }
        return $arrRow;
    }

    /**
     * function getAllWishListOfCustomer
     *
     * This function is used to get all wish list deatils for login customer.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getAllWishListOfCustomer()
    {
        //get wish list details

        $table = TABLE_WISHLIST;
        $arr = array('fkProductId');
        $where = "fkUserId='" . (int) $_SESSION['sessUserInfo']['id'] . "'";
        $arrRow = $this->select($table, $arr, $where);
        if (count($arrRow) > 0)
        {
            foreach ($arrRow as $key => $v)
            {
                $pids[] = $v['fkProductId'];
            }
        }
        return $pids;
    }

    /**
     * function getCategoryImage
     *
     * This function is used to get category image.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public static function getCategoryImage($id = 0)
    {

        $db = new Database();
        $table = TABLE_CATEGORY_IMAGES;
        $arr = array('pkCategoryImageId', 'categoryImageUrl', 'categoryImage');
        $arrWhere = "fkCategoryId='" . $id . "'";
        $arrRow = $db->select($table, $arr, $arrWhere);
        return $arrRow[0];
    }

    /**
     * function getAttributeViewDetails
     *
     * This function is used to get Attribute details.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option, tbl_product_rating, tbl_review,tbl_product_today_offer, tbl_special_product, tbl_festival, tbl_product_image
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public function getAttributeViewDetails($argPId = 0, $pid = 0)
    {

        $varQuery2 = "SELECT pkAttributeId,AttributeLabel,AttributeDesc,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle, GROUP_CONCAT(DISTINCT pkOptionID) as pkOptionID, GROUP_CONCAT(DISTINCT AttributeOptionValue) AS AttributeOptionValue,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice, GROUP_CONCAT(AttributeOptionImage) AS AttributeOptionImage,GROUP_CONCAT(optionColorCode) as colorcode,GROUP_CONCAT(IsImgUploaded) AS IsImgUploaded FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId WHERE pkAttributeId = '" . $argPId . "' AND fkProductId='" . $pid . "' AND `AttributeVisible`='yes' GROUP BY pkAttributeId  order by AttributeOrdering ASC";
        $arrRes = $this->getArrayResult($varQuery2);
        return $arrRes;
    }

    /**
     * function getAttributeViewDetails
     *
     * This function is used to get Attribute details.
     *
     * Database Tables used in this function are : tbl_product, tbl_category, tbl_wholesaler, tbl_product_to_option, tbl_product_rating, tbl_review,tbl_product_today_offer, tbl_special_product, tbl_festival, tbl_product_image
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     */
    public static function getAttributeStaticViewDetails($argPId = 0, $pid = 0)
    {
        $db = new Database();
        $varQuery2 = "SELECT pkAttributeId,AttributeLabel,AttributeDesc,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle, GROUP_CONCAT(DISTINCT pkOptionID) as pkOptionID, GROUP_CONCAT(DISTINCT AttributeOptionValue) AS AttributeOptionValue,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice, GROUP_CONCAT(AttributeOptionImage) AS AttributeOptionImage,GROUP_CONCAT(optionColorCode) as colorcode,GROUP_CONCAT(IsImgUploaded) AS IsImgUploaded FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId WHERE pkAttributeId = '" . $argPId . "' AND fkProductId='" . $pid . "' AND `AttributeVisible`='yes' GROUP BY pkAttributeId  order by AttributeOrdering ASC";
        $arrRes = $db->getArrayResult($varQuery2);
        return $arrRes;
    }

}

?>
