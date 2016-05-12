<?php

/**
 * Site Product Class
 *
 * This is the Product class that will frequently used on website.
 *
 * DateCreated 18th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class Product extends Database
{

    function __construct()
    {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function getProductDetails
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_image, tbl_category, tbl_wholesaler, tbl_order_option, tbl_product_rating, tbl_special_product, tbl_festival, tbl_product_to_option, tbl_attribute, tbl_attribute_option, tbl_recent_view
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getProductDetails($argProductId)
    {
        global $objCore;

        $varWhere = "pkProductID = '" . $argProductId . "' AND ProductStatus='1'";
        $varQuery = "SELECT pkProductID,fkCategoryID,CategoryHierarchy,ProductName,FinalPrice, DiscountFinalPrice,YoutubeCode,fkPackageId,Quantity,ProductDescription,ProductTerms,HtmlEditor,ProductDateAdded,MetaTitle,MetaKeywords,MetaDescription,ImageName,count(fkAttributeId) as Attribute,pkWholesalerID,CompanyName, AboutCompany, fkTemplateId, SUM(Rating) as numRating, count(fkCustomerID) as numCustomer,fkWholesalerID, Weight, WeightUnit, Length, Width, Height, DimensionUnit FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_PRODUCT_IMAGE . " ON pkProductID = fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = fkCategoryID AND CategoryIsDeleted = '0' AND CategoryStatus = '1') INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
           LEFT JOIN " . TABLE_PRODUCT_RATING . " as rat on pkProductID = rat.fkProductID   WHERE " . $varWhere;
	   /*
	   $varQuery = "SELECT pkProductID,fkCategoryID,CategoryHierarchy,ProductName,FinalPrice, DiscountFinalPrice,YoutubeCode,fkPackageId,Quantity,ProductDescription,ProductTerms,HtmlEditor,ProductDateAdded,MetaTitle,MetaKeywords,MetaDescription,ImageName,count(fkAttributeId) as Attribute,pkWholesalerID,CompanyName, AboutCompany, fkTemplateId, SUM(Rating) as numRating, count(fkCustomerID) as numCustomer,fkWholesalerID, Weight, WeightUnit, Length, Width, Height, DimensionUnit FROM " . TABLE_PRODUCT . " LEFT JOIN " . TABLE_PRODUCT_IMAGE . " ON pkProductID = fkProductID INNER JOIN " . TABLE_CATEGORY . " ON  (pkCategoryId = fkCategoryID AND CategoryIsDeleted = '0' AND CategoryStatus = '1') INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
           LEFT JOIN " . TABLE_PRODUCT_RATING . " as rat on pkProductID = rat.fkProductID   WHERE " . $varWhere;
	   */
        $arrRes = $this->getArrayResult($varQuery);
	//pre($arrRes);
        $curDate = $objCore->serverDateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);


        $varQuerySpcl = "SELECT FinalSpecialPrice 
            FROM " . TABLE_SPECIAL_PRODUCT . " INNER JOIN " . TABLE_FESTIVAL . " ON  fkFestivalID = pkFestivalID 
            WHERE fkProductID='" . $argProductId . "' AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "'
            Group By fkProductID";
        $arrResSpcl = $this->getArrayResult($varQuerySpcl);
        $arrRes[0]['FinalSpecialPrice'] = $arrResSpcl[0]['FinalSpecialPrice'];

        $arrRes[0]['AttrQty'] = $this->getAttrQty($arrRes[0]['pkProductID']);
	//pre($arrRes);
        $varQuery2 = "SELECT pkAttributeId,AttributeLabel,AttributeDesc,AttributeInputType,GROUP_CONCAT(OptionTitle) as OptionTitle, GROUP_CONCAT(pkOptionID) as pkOptionID, GROUP_CONCAT(AttributeOptionValue) AS AttributeOptionValue,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice, GROUP_CONCAT(AttributeOptionImage) AS AttributeOptionImage,GROUP_CONCAT(IsImgUploaded) AS IsImgUploaded FROM " . TABLE_PRODUCT_TO_OPTION . " LEFT JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeId LEFT JOIN " . TABLE_ATTRIBUTE_OPTION . " ON fkAttributeOptionId = pkOptionId WHERE fkProductId = '" . $argProductId . "'
	AND `AttributeVisible`='yes' GROUP BY pkAttributeId order by AttributeOrdering ASC";
        $arrRes[0]['productAttribute'] = $this->getArrayResult($varQuery2);

        $arrRes[0]['Quantity'] = (count($arrRes[0]['productAttribute']) > 0) ? $arrRes[0]['AttrQty'] : $arrRes[0]['Quantity'];

//        if ($_SESSION['sessUserInfo']['type'] == 'customer' && $_SESSION['sessUserInfo']['id'] > 0)
//        {
//            $arrClms = array(
//                'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
//                'fkProductID' => $argProductId,
//                'ViewDateAdded' => date(DATE_TIME_FORMAT_DB)
//            );
//            $this->insert(TABLE_RECENT_VIEW, $arrClms);
//        }
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
     * function getProductImages
     *
     * This function is used to get product image.
     *
     * Database Tables used in this function are : tbl_product_image
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getProductImages($argpid)
    {

        $arrClms = array(
            'pkImageID',
            'ImageName'
        );
        $argWhere = "fkProductID = '" . $argpid . "' ";
        $varOrderBy = 'ImageDateAdded DESC';
        $varTable = TABLE_PRODUCT_IMAGE;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
        return $arrRes;
    }

    /**
     * function userReviewAdd
     *
     * This function is used get user review ads.
     *
     * Database Tables used in this function are : tbl_review
     *
     * @access public
     *
     *  @parameters 1 string
     *
     * @return string $arrAddID
     */
    /* function userReviewAdd($_arrPost)
      {

      global $objGeneral;
      global $objCore;
      $arrClms = array(
      'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
      'fkProductID' => $_arrPost['frmProductId'],
      'Reviews' => strip_tags($_arrPost['frmMessage']),
      'ReviewDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
      'ReviewDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
      );
      //pre($arrPost);

      $arrAddID = $this->insert(TABLE_REVIEW, $arrClms);

      //$objGeneral->addRewards($arrClms['fkCustomerID'], 'RewardOnReviewRatingProduct');
      return $arrAddID;
      } */
    function userReviewAdd($_arrPost)
    {
		
        global $objGeneral;
        global $objCore;

        $varQuery2 = "select pkRateID from " . TABLE_PRODUCT_RATING . " where fkProductID = '" . $_arrPost['frmProductId'] . "' AND fkCustomerID = '" . $_SESSION['sessUserInfo']['id'] . "' ";
        $arrRes2 = $this->getArrayResult($varQuery2);
        if (count($arrRes2) == 0)
        {
            //Insert Rating data starts from here
            $arrClms1 = array(
                'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
                'fkProductID' => $_arrPost['frmProductId'],
                'Rating' => $_arrPost['frmRateStar'],
                'RateDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $arrRes = $this->insert(TABLE_PRODUCT_RATING, $arrClms1);
            //Insert Rating data ends here
            //Insert Review data starts from here
            $arrClms2 = array(
                'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
                'fkProductID' => $_arrPost['frmProductId'],
                'Reviews' => strip_tags($_arrPost['frmMessage']),
                'ReviewDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB),
                'ReviewDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $this->insert(TABLE_REVIEW, $arrClms2);
            //Insert Review data ends here
        }
        else
        {
            //Update the Rating Table
            $varQuery = "UPDATE " . TABLE_PRODUCT_RATING . " set Rating ='" . $_arrPost['frmRateStar'] . "',RatingApprovedStatus ='Pending' where fkProductID = " . $_arrPost['frmProductId'] . " AND fkCustomerID = " . $_SESSION['sessUserInfo']['id'] . "";
            $arrRes = $this->getArrayResult($varQuery);
            //Update the Reviews Table
            $varQuery = "UPDATE " . TABLE_REVIEW . " set Reviews ='" . $_arrPost['frmMessage'] . "',ApprovedStatus ='Pending' ,ReviewDateUpdated ='" . $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB) . "' where fkProductID = " . $_arrPost['frmProductId'] . " AND fkCustomerID = " . $_SESSION['sessUserInfo']['id'] . "";
            $this->getArrayResult($varQuery);
        }
        $objGeneral->solrProductRemoveAdd("pkProductID='" . $_arrPost['frmProductId'] . "'");
       // $objGeneral->addRewards($_SESSION['sessUserInfo']['id'], 'RewardOnReviewRatingProduct');
        return $arrRes;

        //$objGeneral->addRewards($arrClms['fkCustomerID'], 'RewardOnReviewRatingProduct');
        // return $arrAddID;
    }

    /**
     * function getUserReview
     *
     * This function is used get user reviews.
     *
     * Database Tables used in this function are : tbl_review
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getUserReview($argProductId)
    {

        /*      $varWhere = "fkProductID = '" . $argProductId . "' AND ApprovedStatus = 'Allow' ";
          $varQuery = "SELECT pkReviewID,fkProductID, fkCustomerID, CustomerFirstName as CustomerName,CustomerScreenName, Reviews, ReviewDateAdded,ReviewDateUpdated FROM " . TABLE_REVIEW . " INNER JOIN " . TABLE_CUSTOMER . " ON fkCustomerID=pkCustomerID WHERE " . $varWhere . " order by ReviewDateUpdated desc";
          $arrRes = $this->getArrayResult($varQuery); */
       // $varWhere = "rat.fkProductID = '" . $argProductId . "' AND ApprovedStatus = 'Allow' AND RatingApprovedStatus = 'Allow'";
       $varWhere = "rat.fkProductID = '" . $argProductId . "' AND ApprovedStatus = 'Allow' ";
        $varQuery = "SELECT pkReviewID,Rating,rat.fkProductID,CustomerFirstName as CustomerName,CustomerScreenName, rev.Reviews,
            ReviewDateAdded,ReviewDateUpdated FROM " . TABLE_PRODUCT_RATING . " as rat LEFT JOIN " . TABLE_CUSTOMER . " ON rat.fkCustomerID=pkCustomerID LEFT JOIN "
                . TABLE_REVIEW . " as rev ON rev.pkReviewID=rat.pkRateID WHERE " . $varWhere . " group by pkCustomerID order by ReviewDateUpdated desc limit 0,10";

        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    
    function getproductdetailbyidinproducttable($productid)
    {
     $varWhere = "pkProductID = '" . $productid . "'";   
     $varQuery = "SELECT * from " . TABLE_PRODUCT ." WHERE " .$varWhere;
     $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    //new function to find customer product review
    
    function getUserReviewCustomer($argProductId,$customer_id)
    {

        /*      $varWhere = "fkProductID = '" . $argProductId . "' AND ApprovedStatus = 'Allow' ";
          $varQuery = "SELECT pkReviewID,fkProductID, fkCustomerID, CustomerFirstName as CustomerName,CustomerScreenName, Reviews, ReviewDateAdded,ReviewDateUpdated FROM " . TABLE_REVIEW . " INNER JOIN " . TABLE_CUSTOMER . " ON fkCustomerID=pkCustomerID WHERE " . $varWhere . " order by ReviewDateUpdated desc";
          $arrRes = $this->getArrayResult($varQuery); */
        $varWhere = "rat.fkProductID = '" . $argProductId. "' AND rat.fkCustomerID = '".$customer_id."' ";
//        $varQuery = "SELECT count(rat.fkCustomerID),pkReviewID,Rating,rat.fkProductID,CustomerFirstName as CustomerName,CustomerScreenName, rev.Reviews,
//            ReviewDateAdded,ReviewDateUpdated FROM " . TABLE_PRODUCT_RATING . " as rat LEFT JOIN " . TABLE_CUSTOMER . " ON rat.fkCustomerID=pkCustomerID LEFT JOIN "
//                . TABLE_REVIEW . " as rev ON rev.pkReviewID=rat.pkRateID WHERE " . $varWhere . " group by pkCustomerID order by ReviewDateUpdated desc limit 0,10";
 $varQuery = "SELECT count(rat.fkCustomerID)
             FROM " . TABLE_PRODUCT_RATING . " as rat LEFT JOIN " . TABLE_CUSTOMER . " ON rat.fkCustomerID=pkCustomerID LEFT JOIN "
                . TABLE_REVIEW . " as rev ON rev.pkReviewID=rat.pkRateID WHERE " . $varWhere . " group by pkCustomerID order by ReviewDateUpdated desc limit 0,10";
 
        //pre($varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function userReviewDelete
     *
     * This function is used to delete review.
     *
     * Database Tables used in this function are : tbl_review
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varAffected
     */
    function userReviewDelete($argReviewID)
    {
        $varWhereSdelete = " pkReviewID = " . $argReviewID . " ";
        $varAffected = $this->delete(TABLE_REVIEW, $varWhereSdelete);
        return $varAffected;
    }

    /**
     * function userReviewUpdate
     *
     * This function is used to update review.
     *
     * Database Tables used in this function are : tbl_review
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string Null
     */
    function userReviewUpdate($argReviewID, $argReview)
    {
        global $objCore;

        $varWhereSdelete = " pkReviewID = " . $argReviewID . " ";

        $arrClmsUpdate = array(
            'Reviews' => $argReview,
            'ApprovedStatus' => 'Pending',
            'ReviewDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        $arrUpdateID = $this->update(TABLE_REVIEW, $arrClmsUpdate, $varWhereSdelete);
    }

    /**
     * function myWishlistDetails
     *
     * This function is used wish list details.
     *
     * Database Tables used in this function are : tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function myWishlistDetails($argPost)
    {
        $arrClms = array('pkWishlistId');
        $varWhere = "fkUserId = '" . $_SESSION['sessUserInfo']['id'] . "' AND fkProductID =  '" . $argPost . "'";
        $varTable = TABLE_WISHLIST;
        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
        return $arrRes;
    }

    /**
     * function sendRecommendedToFriend
     *
     * This function is used to send recommend to a fried.
     *
     * Database Tables used in this function are : NO Table
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string Null
     */
    function sendPackageWarningToWholsaler($wholesaler, $wholesalerEmail, $packageName)
    {

        $objTemplate = new EmailTemplate();
        $objCore = new Core();
        $varSiteName = SITE_NAME;
        $varWhereTemplate = " EmailTemplateTitle= 'packagedeactive' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{CUSTOMER}', '{PACKAGE}', '{SITE_ROOT_URL}');

        $varKeywordValues = array($varPathImage, SITE_NAME, ucfirst($wholesaler), $packageName, SITE_ROOT_URL);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
        $objCore->sendMail($wholesalerEmail, $varFromUser, $varSubject, $varOutPutValues);

        return $proUrl;
    }

    /**
     * function getProductPackageDetails
     *
     * This function is used get product package details.
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package, tbl_product
     *
     * @access public
     *
     * @parameters 1 integer
     *
     * @return string $arrRes
     */
    function getProductPackageDetails($argPackageId)
    {
    	//group by pkPackageID ";
    	$data = explode(',', $argPackageId);
    	
    	$arrRes = array();
    	foreach ($data as $argPackageId) {
        $varQuery = "SELECT pck.fkWholesalerID,CompanyName,CompanyEmail,Quantity,
        			 ProductName,fkCategoryID,ProductRefNo,pkProductID,pkPackageID,
        			 ProductDescription,PackageName,DiscountFinalPrice,FinalPrice,
        			 PackagePrice,ProductImage as ImageName, PackageImage,
        			 GROUP_CONCAT(AttributeLabel) as AttributeLabel,
        			 GROUP_CONCAT(AttributeOptionValue) as OptionTitle,
        			 GROUP_CONCAT(optionColorCode) as optionColorCode,
        			 GROUP_CONCAT(AttributeOptionImage) as OptionImage,
        			 GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice,
        			 GROUP_CONCAT(proOp.fkAttributeId) AS fkAttributeId,
        			 GROUP_CONCAT(attrbuteOptionId) AS attrbuteOptionId 
        			 FROM tbl_package pck
        			 inner join tbl_product_to_package pp on pkPackageId=pp.fkPackageId
        			 left join tbl_package_product_attribute_option attrOp
        			 on (productId=fkProductId and packageId=pp.fkPackageId)
        			 left join tbl_attribute on attributeId=pkAttributeID
        			 left join tbl_attribute_option on attrbuteOptionId=pkOptionID
        			 left join tbl_product_to_option proOp on (productId=proOp.fkProductId
        				 and attributeId=proOp.fkAttributeId
        				 and attrbuteOptionId=proOp.fkAttributeOptionId)
        			 inner join tbl_product tp on pp.fkProductId = pkProductID
        			 left join tbl_wholesaler on pck.fkWholesalerID=pkWholesalerID
        			 where pkPackageId = '" . $argPackageId . "' AND PackageStatus = '1'
        			 group by pkProductID";
        //echo ($varQuery).'<br/><br/><br/><br/><br/>' ;
        //$varQuery = "SELECT ProductName,fkCategoryID,ProductRefNo,pkProductID,pkPackageID,ProductDescription,PackageName,DiscountFinalPrice,FinalPrice,PackagePrice,ProductImage as ImageName, PackageImage FROM " . TABLE_PACKAGE . " inner join " . TABLE_PRODUCT_TO_PACKAGE . " on pkPackageId=fkPackageId inner join " . TABLE_PRODUCT . " on fkProductId = pkProductID where pkPackageId='" . $argPackageId . "' AND PackageStatus = '1' group by pkProductID";
        $arrRes[] = $this->getArrayResult($varQuery);
        //$arrRes = $this->getArrayResult($varQuery);
       	}
		/* echo '<pre>';
        print_r($arrRes);
        die; */
        if (count($arrRes) > 0)
        {
            foreach ($arrRes as $key => $values)
            {
            	
            	foreach ($values as $val) {
            	//echo '<pre>'; print_r($val); die;
                if ($val['Quantity'] < 1)
                {
                    $upArr = array('PackageStatus' => '2');
                    $whrUp = "pkPackageId='" . $argPackageId . "'";
                    $this->update(TABLE_PACKAGE, $upArr, $whrUp);
                    $this->sendPackageWarningToWholsaler(trim($val['CompanyName']), trim($val['CompanyEmail']), trim($val['PackageName']));
                    break;
                }
            }
            }
        }
        //pre($arrRes);
        /* $argPackageId = explode(',', $argPackageId);
        foreach ($argPackageId as $id) {
	        $varQuery = "SELECT Quantity,ProductName,fkCategoryID,ProductRefNo,pkProductID,pkPackageID,ProductDescription,PackageName,PackageImage,DiscountFinalPrice,FinalPrice,PackagePrice,ProductImage as ImageName, PackageImage,GROUP_CONCAT(AttributeLabel) as AttributeLabel,GROUP_CONCAT(AttributeOptionValue) as OptionTitle,GROUP_CONCAT(optionColorCode) as optionColorCode,GROUP_CONCAT(AttributeOptionImage) as OptionImage,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice,GROUP_CONCAT(proOp.fkAttributeId) AS fkAttributeId,GROUP_CONCAT(attrbuteOptionId) AS attrbuteOptionId FROM tbl_package inner join tbl_product_to_package pp on pkPackageId=pp.fkPackageId left join tbl_package_product_attribute_option attrOp on (productId=fkProductId and packageId=pp.fkPackageId) left join tbl_attribute on attributeId=pkAttributeID left join tbl_attribute_option on attrbuteOptionId=pkOptionID left join tbl_product_to_option proOp on (productId=proOp.fkProductId and attributeId=proOp.fkAttributeId and attrbuteOptionId=proOp.fkAttributeOptionId) inner join tbl_product tp on pp.fkProductId = pkProductID where pkPackageId='" . $id . "' AND PackageStatus = '1' group by pkProductID";
	        //$varQuery = "SELECT ProductName,fkCategoryID,ProductRefNo,pkProductID,pkPackageID,ProductDescription,PackageName,DiscountFinalPrice,FinalPrice,PackagePrice,ProductImage as ImageName, PackageImage FROM " . TABLE_PACKAGE . " inner join " . TABLE_PRODUCT_TO_PACKAGE . " on pkPackageId=fkPackageId inner join " . TABLE_PRODUCT . " on fkProductId = pkProductID where pkPackageId='" . $argPackageId . "' AND PackageStatus = '1' group by pkProductID";
	        $arrRes[] = $this->getArrayResult($varQuery);
        } */
        //$varQuery = "SELECT Quantity,ProductName,fkCategoryID,ProductRefNo,pkProductID,pkPackageID,ProductDescription,PackageName,PackageImage,DiscountFinalPrice,FinalPrice,PackagePrice,ProductImage as ImageName, PackageImage,GROUP_CONCAT(AttributeLabel) as AttributeLabel,GROUP_CONCAT(AttributeOptionValue) as OptionTitle,GROUP_CONCAT(optionColorCode) as optionColorCode,GROUP_CONCAT(AttributeOptionImage) as OptionImage,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice,GROUP_CONCAT(proOp.fkAttributeId) AS fkAttributeId,GROUP_CONCAT(attrbuteOptionId) AS attrbuteOptionId FROM tbl_package inner join tbl_product_to_package pp on pkPackageId=pp.fkPackageId left join tbl_package_product_attribute_option attrOp on (productId=fkProductId and packageId=pp.fkPackageId) left join tbl_attribute on attributeId=pkAttributeID left join tbl_attribute_option on attrbuteOptionId=pkOptionID left join tbl_product_to_option proOp on (productId=proOp.fkProductId and attributeId=proOp.fkAttributeId and attrbuteOptionId=proOp.fkAttributeOptionId) inner join tbl_product tp on pp.fkProductId = pkProductID where pkPackageId='" . $argPackageId . "' AND PackageStatus = '1' group by pkProductID";
        //$varQuery = "SELECT ProductName,fkCategoryID,ProductRefNo,pkProductID,pkPackageID,ProductDescription,PackageName,DiscountFinalPrice,FinalPrice,PackagePrice,ProductImage as ImageName, PackageImage FROM " . TABLE_PACKAGE . " inner join " . TABLE_PRODUCT_TO_PACKAGE . " on pkPackageId=fkPackageId inner join " . TABLE_PRODUCT . " on fkProductId = pkProductID where pkPackageId='" . $argPackageId . "' AND PackageStatus = '1' group by pkProductID";
        //$arrRes[].= $this->getArrayResult($varQuery);
        
        /* echo '<pre>';
        print_r($arrRes);
        die; */
        return $arrRes;
    }

    /**
     * function _ago
     *
     * This function is used display time difference of submit comment.
     *
     * Database Tables used in this function are : No Table
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string Null
     */
    function _ago($tm)
    {

        $etime = time() - strtotime($tm);
        //pre($etime);
        if ($etime < 1)
        {
            return '0 seconds';
        }

        $a = array(12 * 30 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
            }
        }
    }

    /**
     * function myRatingAdd
     *
     * This function is used to add rating.
     *
     * Database Tables used in this function are : tbl_product_rating
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function myRatingAdd($_arrPost)
    {
        //Old used values $_arrPost['pid'],$_arrPost['val']
        global $objGeneral;

        $varQuery2 = "select pkRateID from " . TABLE_PRODUCT_RATING . " where fkProductID = '" . $_arrPost['pid'] . "' AND fkCustomerID = '" . $_SESSION['sessUserInfo']['id'] . "' ";
        $arrRes2 = $this->getArrayResult($varQuery2);
        if (count($arrRes2) == 0)
        {
            $arrClms = array(
                'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
                'fkProductID' => $_arrPost['pid'],
                'Rating' => $_arrPost['val'],
                'RateDateAdded' => date(DATE_TIME_FORMAT_DB)
            );

            $arrRes = $this->insert(TABLE_PRODUCT_RATING, $arrClms);
        }
        else
        {
            $varQuery = "UPDATE " . TABLE_PRODUCT_RATING . " set Rating ='" . $_arrPost['val'] . "' where fkProductID = " . $_arrPost['pid'] . " AND fkCustomerID = " . $_SESSION['sessUserInfo']['id'] . "";
            $arrRes = $this->getArrayResult($varQuery);
        }
        $objGeneral->solrProductRemoveAdd("pkProductID='" . $_arrPost['pid'] . "'");
        $objGeneral->addRewards($arrClms['fkCustomerID'], 'RewardOnReviewRatingProduct');
        return $arrRes;
    }

    /**
     * function myRatingDetails
     *
     * This function is used get rating details.
     *
     * Database Tables used in this function are : tbl_product_rating
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function myRatingDetails($_argProductId)
    {

        $varQuery = "SELECT SUM(Rating) as numRating, count(fkCustomerID) as numCustomer  FROM " . TABLE_PRODUCT_RATING . " WHERE fkProductID = '" . $_argProductId . "' ";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    
    /**
     * function getPackageProducts
     *
     * This function is used get products related to the package .
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getPackageProducts($_argProductId)
    {
		
    	//$varQuery = "SELECT pkProductID,ProductImage,ProductName  FROM " . TABLE_PRODUCT . " WHERE fkPackageId = '" . $_argProductId . "' AND ProductStatus='1'";
    	/**
    	 * Query is updated to show included products image and name in package on clicking view button
    	 * 
    	 * @author : Krishna Gupta
    	 * 
    	 * @Created : 05-11-2015
    	 */
    	$col = 'fkPackageId';
    	$varQuery = "SELECT pkProductID,ProductImage,ProductName  FROM " . TABLE_PRODUCT . " WHERE ProductStatus='1' AND find_in_set (" . $_argProductId .','. $col .")"  ;
        $arrRes = $this->getArrayResult($varQuery);
        /* Ends */
        
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function myRatingDetailsByCustomer
     *
     * This function is used customer wise rating details.
     *
     * Database Tables used in this function are : tbl_product_rating
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function myRatingDetailsByCustomer($_argProductId, $_argCustomerId)
    {

        $varQuery = "SELECT pkRateID, Rating,Reviews FROM " . TABLE_PRODUCT_RATING .
                " as rat LEFT JOIN " . TABLE_REVIEW . " as rev on rat.pkRateID=rev.pkReviewID WHERE rat.fkProductID = '" . $_argProductId . "' AND rat.fkCustomerID=" . $_argCustomerId . " AND RatingApprovedStatus='Allow'";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getproductViewUpdate
     *
     * This function is used to update product last viewed date.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getproductViewUpdate($_argPid)
    {
        $varDate = date(DATE_TIME_FORMAT_DB);
        $varQuery = "UPDATE " . TABLE_PRODUCT . " set LastViewed ='" . $varDate . "' where pkProductID='" . $_argPid . "'";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getRecentBuyer
     *
     * This function is used get recent buyer.
     *
     * Database Tables used in this function are : tbl_order, tbl_order_items
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getRecentBuyer($_argProdId)
    {

        $varQuery = "SELECT count(pkOrderID) as quantity, CustomerFirstName,CustomerLastName,OrderStatus,ItemPrice,OrderDateAdded , fkCustomerID FROM " . TABLE_ORDER . " left join  " . TABLE_ORDER_ITEMS . " on fkOrderID = pkOrderID where fkItemID ='" . $_argProdId . "' AND ItemType = 'product' group by fkCustomerID order by OrderDateAdded DESC limit 0,10 ";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function getCustomerBoughtProduct
     *
     * This function is used get customers purchased products.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order, tbl_product, tbl_category, tbl_wholesaler, tbl_order_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getCustomerBoughtProduct($_argProdId)
    {

        $varQuery = "SELECT GROUP_CONCAT(distinct(fkItemID)) as pids from " . TABLE_ORDER_ITEMS . " inner join `tbl_order` where fkCustomerID IN (SELECT GROUP_CONCAT(fkCustomerID) FROM " . TABLE_ORDER_ITEMS . " left join " . TABLE_ORDER . " on pkOrderID=fkOrderID where fkItemID='" . $_argProdId . "') AND fkItemID !='" . $_argProdId . "' AND fkItemID>0 AND ItemType = 'product'";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        $valProductID = $arrRes[0]['pids'];

        if ($valProductID <> '')
        {

            $varWhere = "pkProductID IN (" . $valProductID . ")";
            $varQuery2 = "SELECT pkProductID,ProductRefNo,discountPercent,ProductName,FinalPrice,DiscountFinalPrice,ProductDescription,pd.Quantity,ProductImage as ImageName,count(fkAttributeId) as Attribute FROM " . TABLE_PRODUCT . " pd INNER JOIN " . TABLE_CATEGORY . " ON (pkCategoryId = fkCategoryID AND ProductStatus='1' AND CategoryIsDeleted = '0' AND CategoryStatus = '1') INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " . TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId
            LEFT JOIN ". TABLE_ORDER_ITEMS ." ON fkItemID=pkProductID WHERE " . $varWhere . " group by pkProductID order by fkOrderID DESC LIMIT 0,15";
            $arrRes2 = $this->getArrayResult($varQuery2);
            //pre($arrRes);

            return $arrRes2;
        }
    }

    /**
     * function CustomerDetails
     *
     * This function is used get customer details.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function CustomerDetails($varCustomerId)
    {
        $arrClms = array(
            'CustomerFirstName',
            'CustomerLastName',
            'CustomerEmail',
        );
        $argWhere = "pkCustomerID='" . $varCustomerId . "' ";
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere);



        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function CustomerIdByEmailForSubscribe
     *
     * This function is used get customer details.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function CustomerIdByEmailForSubscribe($varCustomerEmail)
    {
        global $objCore;
        $arrClms = array(
            'pkCustomerID'
        );
        $argWhere = "CustomerEmail='" . $objCore->getFormatValue($varCustomerEmail) . "' AND IsSubscribe='0'";
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes[0];
    }

    /**
     * function sendRecommendedToFriend
     *
     * This function is used to send recommend to a fried.
     *
     * Database Tables used in this function are : NO Table
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string Null
     */
    function sendRecommendedToFriend($argArrPOST)
    {

        $this->myRecommendedAdd($argArrPOST);

        $objTemplate = new EmailTemplate();
        $objCore = new Core();
        //pre($_SESSION);
        $varUserName = trim(strip_tags($argArrPOST['frmFriendEmail']));

        $arrFriendsEmails = explode(',', $varUserName);

        $varFromUser = trim(strip_tags($argArrPOST['frmEmail']));


        $varSiteName = SITE_NAME;
        //$objCore->getUrl('product.php', array('id' => $argArrPOST['proId'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo']));
        $proUrl = $objCore->getUrl('product.php', array('id' => $argArrPOST['proId'], 'name' => $argArrPOST['proName']));

        $varWhereTemplate = " EmailTemplateTitle= 'SendRecommendedEmail' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{LINK}', '{SITE_NAME}', '{CUSTOMER}', '{SITE_ROOT_URL}', '{PROID}');

        $varKeywordValues = array($varPathImage, $argArrPOST['frmLink'], SITE_NAME, ucfirst($argArrPOST['frmName']), SITE_ROOT_URL, $proUrl);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

        // Calling mail function

        $objCore->setSuccessMsg(FRONT_USER_RECOMMEND_EMAIL_SEND);
        foreach ($arrFriendsEmails as $email)
        {
            $objCore->sendMail($email, $varFromUser, $varSubject, $varOutPutValues);
        }


        return $proUrl;
    }

    /**
     * function myRecommendedAdd 
     *
     * This function is used to add my recommends.
     *
     * Database Tables used in this function are : tbl_recommend
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     */
    function myRecommendedAdd($_arrPost)
    {
        global $objGeneral;

        //pre($_SESSION);
        $arrClms = array(
            'fkUserId' => $_SESSION['sessUserInfo']['id'],
            'fkProductId' => $_arrPost['proId'],
            'RecommendDateAdded' => date(DATE_TIME_FORMAT_DB)
        );
        //pre($arrPost);

        $arrAddID = $this->insert(TABLE_RECOMMEND, $arrClms);
        $objGeneral->addRewards($arrClms['fkUserId'], 'RewardOnRecommendProduct');
        return $arrAddID;
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
    function getAdsDetails()
    {

        $varQuery = "SELECT pkAdID,AdType,Title,AdUrl,ImageName,ImageSize,HtmlCode
            FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND `AdsPage` = 'Product Detail Page' order by rand() limit 0,1";

        $arrRes = $this->getArrayResult($varQuery);
        // pre($arrRes);
        return $arrRes;
    }

    function getmulproductDetails($pid) {
        $varID = "fkproduct_id ='" . $pid .  "'";
        $arrClms = array(
            'fkproduct_id',
            'country_id',
             'producttype',
            
        );
        $varTable = tbl_productmulcountry;
        $arrRow = $this->select($varTable, $arrClms, $varID);
        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function getBreadcrumb
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
    function getBreadcrumb($cids, $prodName = '')
    {
        $arrIds = explode(':', $cids);
        $varStr = '<li class="first"><a class="breadcurmbs" href="' . SITE_ROOT_URL . '">Home</a></li>';
        $num = count($arrIds);

        global $objCore;
        $i = 1;
        foreach ($arrIds as $val)
        {
            $varQuery = "select pkCategoryId,CategoryParentId,CategoryName from " . TABLE_CATEGORY . " where pkCategoryId ='" . $val . "'";
            $arrRes = $this->getArrayResult($varQuery);
            if ($arrRes)
            {
                //$cls = ($i == 1) ? 'class="first"' : '';
                $cls = '';
                $page = ($arrRes[0]['CategoryParentId'] > 0) ? 'category.php' : 'landing.php';
                $varStr .= '<li ' . $cls . '><a class="breadcurmbs" href="' . $objCore->getUrl($page, array('cid' => $arrRes[0]['pkCategoryId'], 'name' => $arrRes[0]['CategoryName'])) . '" >' . ucfirst($arrRes[0]['CategoryName']) . '</a></li>';

                $i++;
            }
        }

        return $varStr . "<li>" . $prodName . "</li>";
    }
  function getonlywholesalerbyproductid($wid)
  {
    $varWhere = "pkWholesalerID = '" . $wid . "' AND WholesalerStatus='active'";
        $varQuery = "SELECT * FROM " . TABLE_WHOLESALER . " WHERE " . $varWhere;  
       // pre($varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
  }
    /**
     * function getWholesalerDetails
     *
     * This function is used display wholesaler details.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getWholesalerDetails($wid)
    {
        global $objCore;

        $varWhere = "pkWholesalerID = '" . $wid . "' AND WholesalerStatus='active'";
        $varQuery = "SELECT * FROM " . TABLE_WHOLESALER . " WHERE " . $varWhere;
        $wholesaler = $this->getArrayResult($varQuery);
        $wholesaler_document = $this->getArrayResult("SELECT * FROM " . TABLE_WHOLESALER_DOCUMENTS . " WHERE fkWholesalerID='$wid'");
        $wholesaler[0]['BusinessPlan'] = $wholesaler_document;

        $argWhere = " ShippingStatus='1' AND fkWholesalerID='" . $wid . "'";
        $varOrderBy = "ShippingType ASC,ShippingTitle ASC ";
        $wholesaler_shipping = $this->getArrayResult("SELECT ShippingTitle FROM " . TABLE_SHIPPING_GATEWAYS . " INNER JOIN " . TABLE_WHOLESALER_TO_SHIPPING_GATEWAY . " on fkShippingGatewaysID=pkShippingGatewaysID WHERE $argWhere group by pkShippingGatewaysID ORDER BY $varOrderBy");
        $wholesaler[0]['Shipping'] = $wholesaler_shipping;

        $varWhere = "p.fkWholesalerID = '" . $wid . "' AND r.ApprovedStatus='Allow'";
        $wholesaler_product_review = $this->getArrayResult("SELECT r.Reviews,concat(c.CustomerFirstName,' ',c.CustomerLastName) AS customerName FROM " . TABLE_REVIEW . " AS r INNER JOIN " . TABLE_PRODUCT . " AS p ON (r.fkProductID=p.pkProductID) INNER JOIN " . TABLE_CUSTOMER . " AS c ON(r.fkCustomerID=c.pkCustomerID) WHERE $varWhere ORDER BY r.fkCustomerID DESC LIMIT 10");
        $wholesaler[0]['Testimonial'] = $wholesaler_product_review;

        $varWhere = " p.fkWholesalerID = '" . $wid . "' AND p.Quantity > '0'";
        $wholesaler_topproduct = $this->getArrayResult("SELECT p.ProductName,p.pkProductID,p.ProductRefNo,p.FinalPrice,p.DiscountFinalPrice,p.ProductImage,p.ProductDescription,s.FinalSpecialPrice FROM " . TABLE_PRODUCT . " AS p LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " AS s ON(p.pkProductID = s.fkProductID) WHERE $varWhere ORDER BY p.Sold DESC LIMIT 10");
        $wholesaler[0]['Topproduct'] = $wholesaler_topproduct;

        $wholesaler_newproduct = $this->getArrayResult("SELECT p.ProductName,p.pkProductID,p.ProductRefNo,p.FinalPrice,p.DiscountFinalPrice,p.ProductImage,p.ProductDescription,s.FinalSpecialPrice FROM " . TABLE_PRODUCT . " AS p LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " AS s ON(p.pkProductID = s.fkProductID) WHERE $varWhere ORDER BY p.pkProductID DESC LIMIT 8");
        $wholesaler[0]['Newproduct'] = $wholesaler_newproduct;
        $varWhere = " fkWholesalerId = '" . $wid . "'";

        $wholesaler_slider_image = $this->getArrayResult("SELECT sliderImage FROM " . TABLE_WHOLESALER_SLIDER_IMAGE . " WHERE $varWhere ORDER BY pkSliderId DESC LIMIT 3");
        $wholesaler[0]['Sliderimage'] = $wholesaler_slider_image;

        $varWhereRan = " p.fkWholesalerID = '" . $wid . "' AND p.Quantity > '0' AND p.Sold > '0'";
        $wholesalerRan_topproduct = $this->getArrayResult("SELECT p.ProductName,p.pkProductID,p.ProductRefNo,p.FinalPrice,p.DiscountFinalPrice,p.ProductImage,p.ProductDescription,s.FinalSpecialPrice FROM " . TABLE_PRODUCT . " AS p LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " AS s ON(p.pkProductID = s.fkProductID) WHERE $varWhereRan ORDER BY RAND(),p.Sold DESC LIMIT 1");
        $wholesaler[0]['TopproductRan'] = $wholesalerRan_topproduct;

        $varWhereRanNew = " p.fkWholesalerID = '" . $wid . "' AND p.Quantity > '0'";
        $wholesaler_newproductRan = $this->getArrayResult("SELECT p.ProductName,p.pkProductID,p.ProductRefNo,p.FinalPrice,p.DiscountFinalPrice,p.ProductImage,p.ProductDescription,s.FinalSpecialPrice FROM " . TABLE_PRODUCT . " AS p LEFT JOIN " . TABLE_SPECIAL_PRODUCT . " AS s ON(p.pkProductID = s.fkProductID) WHERE $varWhereRanNew ORDER BY RAND(),p.pkProductID DESC LIMIT 6");
        $wholesaler[0]['NewproductRan'] = $wholesaler_newproductRan;

//        $varQuerySpecial="SELECT * FROM tbl_special_product";
//        $arrRes['offer_details']=$this->getArrayResult($varQueryOffer);

        $varQuery2 = "SELECT pkProductID,ProductName,FinalPrice, DiscountFinalPrice, ProductDescription,ProductImage
            FROM " . TABLE_PRODUCT . " p INNER JOIN " . TABLE_SPECIAL_PRODUCT . " sp ON (p.fkWholesalerID = sp.fkWholesalerID AND p.pkProductID = sp.fkProductID) LIMIT 2";
        $arrRes['product_details'] = $this->getArrayResult($varQuery2);

        $wholesaler[0]['offerProduct'] = $arrRes['product_details'];

        return $wholesaler;
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
     * User instruction: $objCustomer->countryList()
     */
    function countryList()
    {
        $arrClms = array(
            'country_id',
            'name',
        );
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function updateReview
     *
     * This function is used to update review for product.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->updateReview()
     */
    function updateReview($pid = '', $wid = '')
    {
        $arrClms = array('productReview' => 1);
        $where = "fkProductID='" . $pid . "'";
        $arrRes = $this->update(TABLE_PRODUCT_RATING, $arrClms, $where);
        return $arrRes;
    }

    /**
     * function categoryTopSellingPoducts
     *
     * This function is used to update review for product.
     *
     * Database Tables used in this function are : TABLE_PRODUCT
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->categoryTopSellingPoducts()
     */
    function categoryTopSellingPoducts($wid)
    {
        //Create the common class object
        $objComman = new ClassCommon();
        //Fetch the offer product
        $varQuery = "SELECT TodayOfferID FROM `tbl_product_today_offer` ";
        $arrRes = $this->getArrayResult($varQuery);
        $todayOfferProduct = $arrRes[0]['fkProductId'];

        //Fetch all the categories
        $arrCatList = $objComman->getCategories();
        $arrCatList = $arrCatList[0];
        $arrRow = array();

        foreach ($arrCatList as $key => $val)
        {
            $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,IF(sum(atInv.OptionQuantity)>0,sum(atInv.OptionQuantity),Quantity) as Quantity,discountPercent,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute
                        FROM " . TABLE_PRODUCT . " product LEFT JOIN " .
                    TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID
                     INNER JOIN " . TABLE_CATEGORY .
                    " ON  (pkCategoryId = product.fkCategoryID AND (CategoryHierarchy like '%:" . $val['pkCategoryId'] . "' OR CategoryHierarchy like'" . $val['pkCategoryId'] . ":%' OR CategoryHierarchy ='" . $val['pkCategoryId'] . "') AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct') INNER JOIN " .
                    TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " .
                    TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " .
                    TABLE_PRODUCT_OPTION_INVENTORY . " as atInv ON pkProductID = atInv.fkProductID 
          where product.fkWholesalerID = '" . $wid . "' AND product.Quantity > '0' AND product.Sold > '0'
              Group By pkProductID  ORDER BY pkProductID DESC
          limit 50";
//            //Create memcache object
//            global $oCache;
//            //Create object key for cache object
//            $varQueryKey = md5($varQuery);
//            //Check memcache is enabled or not
//            if ($oCache->bEnabled)
//            { // if Memcache enabled
//                if (!$oCache->getData($varQueryKey))
//                {
//                    $arrRes = $this->getArrayResult($varQuery);
//                    $oCache->setData($varQueryKey, serialize($arrRes));
//                }
//                else
//                {
//                    $arrRes = unserialize($oCache->getData($varQueryKey));
//                }
//            }
//            else
//            {
            $arrRes = $this->getArrayResult($varQuery);
//            }

            if ($arrRes)
            {
                $arrRow[$val['pkCategoryId']]['arrCategory'] = $val;
                $arrRow[$val['pkCategoryId']]['arrProducts'] = $arrRes;
            }
        }
        return $arrRow;
    }

    function productViewUpdate($argProductId)
    {
        if ($_SESSION['sessUserInfo']['type'] == 'customer' && $_SESSION['sessUserInfo']['id'] > 0)
        {
            $arrClms = array(
                'fkCustomerID' => $_SESSION['sessUserInfo']['id'],
                'fkProductID' => $argProductId,
                'ViewDateAdded' => date(DATE_TIME_FORMAT_DB)
            );
            $this->insert(TABLE_RECENT_VIEW, $arrClms);
        }
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
    function getSubCategory($argProductId,$wholeId)
    {
         $varQuery="SELECT a.pkCategoryId,a.CategoryName FROM tbl_product inner join tbl_category a on fkCategoryID=a.pkCategoryId where fkWholesalerID='".(int) $wholeId."' and CategoryParentId ='".(int) $argProductId."' group by a.pkCategoryId ORDER BY a.CategoryOrdering ASC";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
       
    }
    
    
    function getSubCategoryProduct($argProductId,$wholeId){
        $varQuery = "SELECT TodayOfferID FROM `tbl_product_today_offer` ";
        $arrRes = $this->getArrayResult($varQuery);
        $todayOfferProduct = $arrRes[0]['fkProductId'];
        
        $varQuery = "SELECT pkProductID,ProductRefNo,ProductName,FinalPrice,FinalSpecialPrice,DiscountFinalPrice,IF(sum(atInv.OptionQuantity)>0,sum(atInv.OptionQuantity),Quantity) as Quantity,discountPercent,ProductDescription,ProductDateAdded,ProductImage,count(fkAttributeId) as Attribute
                        FROM " . TABLE_PRODUCT . " product LEFT JOIN " .
                    TABLE_SPECIAL_PRODUCT . " sProduct ON pkProductID=sProduct.fkProductID
                     INNER JOIN " . TABLE_CATEGORY .
                    " ON  (pkCategoryId = product.fkCategoryID AND (CategoryHierarchy like '%:" . $argProductId . "' OR CategoryHierarchy like '" . $argProductId . ":%' OR CategoryHierarchy like '%:" . $argProductId . "' OR CategoryHierarchy ='" . $argProductId. "') AND ProductStatus='1'  AND CategoryIsDeleted = '0' AND CategoryStatus = '1' AND pkProductID !='$todayOfferProduct') INNER JOIN " .
                    TABLE_WHOLESALER . " ON (product.fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active') LEFT JOIN " .
                    TABLE_PRODUCT_TO_OPTION . " as pto ON pkProductID = pto.fkProductId LEFT JOIN " .
                    TABLE_PRODUCT_OPTION_INVENTORY . " as atInv ON pkProductID = atInv.fkProductID 
          where product.fkWholesalerID = '" . (int) $wholeId . "' Group By pkProductID  ORDER BY pkProductID DESC
          limit 50";
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
    public function subCategoryMenu($argProductId=0,$wholeId=0){
        $varQuery="SELECT b.pkCategoryId,b.CategoryName FROM tbl_product inner join tbl_category a on fkCategoryID=a.pkCategoryId join tbl_category b on
a.CategoryParentId=b.pkCategoryId where fkWholesalerID='".(int) $wholeId."' and b.CategoryParentId = '".(int) $argProductId."' group by b.pkCategoryId ORDER BY b.CategoryOrdering ASC"; 
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
    public function wholesalrD($wholeId=0){
        $varQuery="SELECT CompanyName FROM tbl_wholesaler where pkWholesalerID='".(int) $wholeId."'"; 
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes[0];
    }
    
    
    

}

?>
