<?php

/**
 * Site APIProcessor Class
 *
 * This is the api class is responsible for all telamela API operations.
 *
 * DateCreated 6th May, 2014
 *
 * DateLastModified 6th May, 2014
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class APIProcessor extends Database
{

    /**
     * Constructor sets up
     */
    public function __construct($wID = 0)
    {
        $this->wholesalerID = $wID;
    }

    /**
     * This function escape the quoted string and will help to avoid SQL injection and single/double quote error.
     *
     * Date Created: 6th May 2014
     *
     * Date Last Modified: 1st July 2011
     *
     * @param integer|String
     *
     * @return String
     */
    public function quoteSlashes($value)
    {
        $value = addslashes($value);

        return $value;
    }

    /**
     * This function used to generated api key.
     *
     * Date Created: 6th May 2014
     *
     * Date Last Modified: 1st July 2011
     *
     * @param integer|String
     *
     * @return String
     */
    function generateApiKey($id)
    {
        $apiToken = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $apiToken = substr(str_shuffle($apiToken), 0, 25);
        $apiToken = $id . $apiToken . $id;
        $apiToken = strtoupper(md5($apiToken));
        return $apiToken;
    }

    /**
     * function loginWholesaler
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function loginWholesaler($arrReq)
    {

        $varTbl = TABLE_WHOLESALER;

        $arrClms = array(
            'pkWholesalerID',
            'CompanyEmail',
            'WholesalerAPIKey',
            'WholesalerStatus'
        );

        $arrRes[0]['status'] = "invalid";
        $varWhr = "(CompanyEmail='" . $this->quoteSlashes($arrReq['auth']['username']) . "' AND CompanyPassword='" . $this->quoteSlashes(md5($arrReq['auth']['password'])) . "') ";

        $arrRow = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrRow) > 0)
        {

            $WholesalerAPIKey = $this->generateApiKey($arrRow[0]['pkWholesalerID']);
            $this->update($varTbl, array('WholesalerAPIKey' => $WholesalerAPIKey), "pkWholesalerID = '" . $arrRow[0]['pkWholesalerID'] . "' ");
            $arrRes[0]['status'] = "valid";
            $arrRes[0]['pkWholesalerID'] = $arrRow[0]['pkWholesalerID'];
            $arrRes[0]['CompanyEmail'] = $arrRow[0]['CompanyEmail'];
            $arrRes[0]['WholesalerAPIKey'] = $WholesalerAPIKey;
            $arrRes[0]['WholesalerStatus'] = $arrRow[0]['WholesalerStatus'];
            $arrRes[0]['TIMEZONE'] = DEFAULT_TIME_ZONE;
        }

        return $arrRes;
    }

    /**
     * function getuserId
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getuserId($token)
    {

        $varTbl = TABLE_WHOLESALER;
        $arrClms = array(
            'pkWholesalerID'
        );

        $varWhr = "WholesalerAPIKey='" . $this->quoteSlashes($token) . "' AND WholesalerAPIKey !='' ";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);
        return (int) $arrRes[0]['pkWholesalerID'];
    }

    /**
     * function getCategories
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getCategories($arrReq)
    {

        $varTbl = TABLE_CATEGORY;

        $arrClms = array(
            'pkCategoryId',
            'CategoryParentId',
            'CategoryName',
            'CategoryLevel',
            'CategoryDescription',
            'CategoryOrdering',
            'CategoryHierarchy',
            'CategoryMetaTitle',
            'CategoryMetaKeywords',
            'CategoryMetaDescription',
            'CategoryStatus',
            'CategoryIsDeleted',
            'CategoryDateAdded',
            'CategoryDateModified'
        );

        $varWhr = "(CategoryStatus='1' AND CategoryIsDeleted='0' AND CategoryLevel<3)";

        if (isset($arrReq['search']))
        {

            $custom = "";
            if (isset($arrReq['search']['custom']))
            {
                $custom = $this->quoteSlashes($arrReq['search']['custom']);
                unset($arrReq['search']['custom']);
            }

            foreach ($arrReq['search'] as $k => $v)
            {
                $varWhr .= " AND " . $this->quoteSlashes($k) . " = '" . $this->quoteSlashes($v) . "' ";
            }

            if ($custom)
            {
                $varWhr .= " AND (" . $custom . ") ";
            }
        }

        $varOrderBy = "";

        if (isset($arrReq['order']))
        {
            foreach ($arrReq['order'] as $k => $v)
            {
                $varOrderBy .= ($varOrderBy == "") ? "" : ", ";
                $varOrderBy .= $this->quoteSlashes($k) . " " . $this->quoteSlashes($v) . " ";
            }
        }
        else
        {
            $varOrderBy = "CategoryName ASC ";
        }

        $varLimit = "";
        if (isset($arrReq['limit']))
        {
            if (isset($arrReq['limit']['offset']) && isset($arrReq['limit']['rows']))
            {
                $varLimit = (int) $this->quoteSlashes($arrReq['limit']['offset']) . ", " . (int) $this->quoteSlashes($arrReq['limit']['rows']);
            }
        }

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getAttributes
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_attribute
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getAttributes($arrReq)
    {

        $varTbl = TABLE_ATTRIBUTE;

        $arrClms = array(
            'pkAttributeID',
            'AttributeCode',
            'AttributeLabel',
            'AttributeDesc',
            'AttributeOrdering',
            'AttributeVisible',
            'AttributeSearchable',
            'AttributeComparable',
            'AttributeInputType',
            'AttributeValidation',
            'AttributeDateAdded'
        );

        $varWhr = "(pkAttributeID>'0')";

        if (isset($arrReq['search']))
        {

            $custom = "";
            if (isset($arrReq['search']['custom']))
            {
                $custom = $this->quoteSlashes($arrReq['search']['custom']);
                unset($arrReq['search']['custom']);
            }

            foreach ($arrReq['search'] as $k => $v)
            {
                $varWhr .= " AND " . $this->quoteSlashes($k) . " = '" . $this->quoteSlashes($v) . "' ";
            }

            if ($custom)
            {
                $varWhr .= " AND (" . $custom . ") ";
            }
        }

        $varOrderBy = "";

        if (isset($arrReq['order']))
        {
            foreach ($arrReq['order'] as $k => $v)
            {
                $varOrderBy .= ($varOrderBy == "") ? "" : ", ";
                $varOrderBy .= $this->quoteSlashes($k) . " " . $this->quoteSlashes($v) . " ";
            }
        }
        else
        {
            $varOrderBy = "AttributeOrdering ASC ";
        }

        $varLimit = "";
        if (isset($arrReq['limit']))
        {
            if (isset($arrReq['limit']['offset']) && isset($arrReq['limit']['rows']))
            {
                $varLimit = (int) $this->quoteSlashes($arrReq['limit']['offset']) . ", " . (int) $this->quoteSlashes($arrReq['limit']['rows']);
            }
        }

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getAttributesToCategory
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_attribute_to_category
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getAttributesToCategory($arrReq)
    {

        $varTbl = TABLE_ATTRIBUTE_TO_CATEGORY;

        $arrClms = array(
            'pkID',
            'fkAttributeId',
            'fkCategoryID'
        );

        $varWhr = "(pkID>'0')";

        if (isset($arrReq['search']))
        {

            $custom = "";
            if (isset($arrReq['search']['custom']))
            {
                $custom = $this->quoteSlashes($arrReq['search']['custom']);
                unset($arrReq['search']['custom']);
            }

            foreach ($arrReq['search'] as $k => $v)
            {
                $varWhr .= " AND " . $this->quoteSlashes($k) . " = '" . $this->quoteSlashes($v) . "' ";
            }

            if ($custom)
            {
                $varWhr .= " AND (" . $custom . ") ";
            }
        }

        $varOrderBy = "";

        if (isset($arrReq['order']))
        {
            foreach ($arrReq['order'] as $k => $v)
            {
                $varOrderBy .= ($varOrderBy == "") ? "" : ", ";
                $varOrderBy .= $this->quoteSlashes($k) . " " . $this->quoteSlashes($v) . " ";
            }
        }
        else
        {
            $varOrderBy = "pkID ASC ";
        }

        $varLimit = "";
        if (isset($arrReq['limit']))
        {
            if (isset($arrReq['limit']['offset']) && isset($arrReq['limit']['rows']))
            {
                $varLimit = (int) $this->quoteSlashes($arrReq['limit']['offset']) . ", " . (int) $this->quoteSlashes($arrReq['limit']['rows']);
            }
        }

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getAttributesToOption
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_attribute_option
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getAttributesToOption($arrReq)
    {

        $varTbl = TABLE_ATTRIBUTE_OPTION;

        $arrClms = array(
            'pkOptionID',
            'fkAttributeId',
            'OptionTitle',
            'optionColorCode',
            'OptionImage'
        );

        $varWhr = "(pkOptionID>'0')";

        if (isset($arrReq['search']))
        {

            $custom = "";
            if (isset($arrReq['search']['custom']))
            {
                $custom = $this->quoteSlashes($arrReq['search']['custom']);
                unset($arrReq['search']['custom']);
            }

            foreach ($arrReq['search'] as $k => $v)
            {
                $varWhr .= " AND " . $this->quoteSlashes($k) . " = '" . $this->quoteSlashes($v) . "' ";
            }

            if ($custom)
            {
                $varWhr .= " AND (" . $custom . ") ";
            }
        }

        $varOrderBy = "";

        if (isset($arrReq['order']))
        {
            foreach ($arrReq['order'] as $k => $v)
            {
                $varOrderBy .= ($varOrderBy == "") ? "" : ", ";
                $varOrderBy .= $this->quoteSlashes($k) . " " . $this->quoteSlashes($v) . " ";
            }
        }
        else
        {
            $varOrderBy = "pkOptionID ASC ";
        }

        $varLimit = "";
        if (isset($arrReq['limit']))
        {
            if (isset($arrReq['limit']['offset']) && isset($arrReq['limit']['rows']))
            {
                $varLimit = (int) $this->quoteSlashes($arrReq['limit']['offset']) . ", " . (int) $this->quoteSlashes($arrReq['limit']['rows']);
            }
        }

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getCountries
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getCountries($arrReq)
    {

        $varTbl = TABLE_COUNTRY;

        $arrClms = array(
            'country_id',
            'name',
            'iso_code_2',
            'iso_code_3',
            'address_format',
            'postcode_required',
            'zone',
            'time_zone',
            'status'
        );

        $varWhr = "(country_id>0) ";

        $varOrderBy = "name ASC ";
        $varLimit = "";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getRegions
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_region
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getRegions($arrReq)
    {

        $varTbl = TABLE_REGION;
        $arrClms = array(
            'pkRegionID',
            'fkCountryId',
            'RegionName',
            'Image',
            'Cities',
            'DateAdded'
        );
        $varWhr = "(pkRegionID>0) ";

        $varOrderBy = "pkRegionID ASC ";
        $varLimit = "";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getFestival
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getFestival($arrReq)
    {

        $varTbl = TABLE_FESTIVAL;

        $arrClms = array(
            'pkFestivalID',
            'CountryIDs',
            'CategoryIDs',
            'FestivalTitle',
            'FestivalStartDate',
            'FestivalEndDate',
            'FestivalOrder',
            'FestivalStatus',
            'FestivalDateAdded'
        );

        $varWhr = "(pkFestivalID>0) ";

        $varOrderBy = "pkFestivalID ASC ";
        $varLimit = "";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getPackage
     *
     * This function is used to get package List.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getPackage($arrReq)
    {

        $varTbl = TABLE_PACKAGE . " INNER JOIN " . TABLE_PRODUCT_TO_PACKAGE . " ON pkPackageId=fkPackageId";

        $arrClms = array(
            'pkPackageId',
            'packageOfflineID',
            'fkWholesalerID',
            'PackageName',
            'PackageACPrice',
            'PackagePrice',
            'PackageImage',
            'PackageStatus',
            'PackageDateAdded'
        );

        $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' ";
        $varOrderBy = "pkPackageId ASC ";

        $varLimit = "";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);

        $arrClms = array('imgSync' => 0);
        $arrRes2 = $this->update($varTbl, $arrClms, $varWhr);

        return $arrRes;
    }

    /**
     * function getProducts
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getProducts($arrReq)
    {

        $varTbl = TABLE_PRODUCT;

        $arrClms = array(
            'pkProductID',
            'fkCategoryID',
            'ProductRefNo',
            'fkWholesalerID',
            'fkShippingID',
            addslashes('ProductName'),
            'ProductImage',
            'ProductSliderImage',
            'wholesalePrice',
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
            addslashes('ProductDescription'),
            addslashes('ProductTerms'),
            addslashes('YoutubeCode'),
            addslashes('MetaTitle'),
            addslashes('MetaKeywords'),
            addslashes('MetaDescription'),
            'IsFeatured',
            'ProductStatus',
            'CreatedBy',
            'fkCreatedID',
            'UpdatedBy',
            'fkUpdatedID',
            'IsAddedBulkUpload',
            'LastViewed',
            'Sold',
            'ProductDateAdded',
            'ProductDateUpdated',
            'ProductCronUpdate',
            'productOfflineID'
        );

        $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' ";
        $varOrderBy = "pkProductID ASC ";

        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);

        $pkProductIDs = '';
        foreach ($arrRes as $resultKey => $resultVal)
        {
            $pkProductIDs .= $resultVal['pkProductID'] . ',';
        }
        if ($pkProductIDs != '')
        {
            $varWhr = " fkProductID in(" . trim($pkProductIDs, ",") . ")";
            $arrClms = array('imgSync' => 0);
            $arrRes2 = $this->update(TABLE_PRODUCT_IMAGE, $arrClms, $varWhr);
        }

        return $arrRes;
    }

    /**
     * function getProductImages
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_product_image
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getProductImages($arrReq)
    {

        $varTbl = TABLE_PRODUCT_IMAGE . " INNER JOIN " . TABLE_PRODUCT . " ON (fkProductID = pkProductID AND fkWholesalerID='" . $this->wholesalerID . "')";

        $arrClms = array(
            'pkImageID',
            'fkProductID',
            'ImageName',
            'ImageDateAdded'
        );

        $varWhr = "";

        $varOrderBy = "pkImageID ASC ";

        $varLimit = "";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function downloadProductImage
     *
     * This function is used to get all product Images.
     *
     * Database Tables used in this function are : tbl_product_image
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function downloadProductImage($arrReq)
    {
        global $objCore, $arrProductImageResizes;
        $varTbl = TABLE_PRODUCT_IMAGE . " pi INNER JOIN " . TABLE_PRODUCT . " ON (fkProductID = pkProductID AND fkWholesalerID='" . $this->wholesalerID . "' AND imgSync = '0') LEFT JOIN tbl_product_to_option opt ON opt.fkProductId = pi.fkProductID";
        $arrClms = array('pkImageID,ImageName,AttributeOptionImage');
        $varWhr = "";
        $varOrderBy = "pkImageID DESC ";
        $varLimit = " 10 ";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        // echo '<pre>';print_r($arrRes);
        //pre($arrRes);
        $i = 0;
        $pkImageIDs = '';
        foreach ($arrRes as $resultKey => $resultVal)
        {
            // echo UPLOADED_FILES_SOURCE_PATH . "images/products/" . $arrProductImageResizes['detailHover'] . "/" . $resultVal['ImageName'];
            if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/products/" . $arrProductImageResizes['detailHover'] . "/" . $resultVal['ImageName']) && $resultVal['ImageName'] != '')
            {
                $path = $objCore->getImageUrl($resultVal['ImageName'], 'products/' . $arrProductImageResizes['detailHover']);
                $pathAttr = $objCore->getImageUrl($resultVal['AttributeOptionImage'], 'products/' . $arrProductImageResizes['detailHover']);
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = base64_encode($data);
                $typeAttr = pathinfo($pathAttr, PATHINFO_EXTENSION);
                $dataAttr = file_get_contents($pathAttr);
                $base64Attr = base64_encode($dataAttr);
                $arrRet[$i]['imgName'] = $resultVal['ImageName'];
                $arrRet[$i]['optionImage'] = $resultVal['AttributeOptionImage'] != "" ? $resultVal['AttributeOptionImage'] : 'noimage';
                $arrRet[$i]['ImgString'] = $base64;
                $arrRet[$i]['ImgStringOptionImage'] = $base64Attr;
                $pkImageIDs .= $resultVal['pkImageID'] . ',';
                $i++;
            }
        }
        //pre($arrRet);
        if ($pkImageIDs != '')
        {
            $varWhr = " pkImageID in(" . trim($pkImageIDs, ",") . ")";
            $arrClms = array('imgSync' => 1);
            $arrRes2 = $this->update(TABLE_PRODUCT_IMAGE, $arrClms, $varWhr);
        }
        //pre($arrRet);
        return $arrRet;
    }

    /**
     * function downloadPackageImage
     *
     * This function is used to get all product Images.
     *
     * Database Tables used in this function are : tbl_product_image
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function downloadPackageImage($arrReq)
    {
        global $objCore, $arrProductImageResizes;

        $varTbl = TABLE_PACKAGE;
        $arrClms = array(
            'pkPackageId',
            'PackageImage'
        );

        $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND imgSync = '0'";
        $varOrderBy = "pkPackageId ASC ";
        $varLimit = " 10 ";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        $i = 0;
        $pkPackageIds = '';
        foreach ($arrRes as $resultKey => $resultVal)
        {
            if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/package/" . $resultVal['PackageImage']) && $resultVal['PackageImage'] != '')
            {
                $path = $objCore->getImageUrl($resultVal['PackageImage'], 'package');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = base64_encode($data);
                $arrRet[$i]['imgName'] = $resultVal['PackageImage'];
                $arrRet[$i]['ImgString'] = $base64;
                $pkPackageIds .= $resultVal['pkPackageId'] . ',';
                $i++;
            }
        }
        if ($pkPackageIds != '')
        {
            $varWhr = " pkPackageId in(" . trim($pkPackageIds, ",") . ")";
            $arrClms = array('imgSync' => 1);
            $arrRes2 = $this->update($varTbl, $arrClms, $varWhr);
        }
        return $arrRet;
    }

    /**
     * function getProductOptionInventory
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_product_option_inventory
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getProductOptionInventory($arrReq)
    {

        $varTbl = TABLE_PRODUCT_OPTION_INVENTORY . " INNER JOIN " . TABLE_PRODUCT . " ON (fkProductID = pkProductID AND fkWholesalerID='" . $this->wholesalerID . "')";

        $arrClms = array(
            'pkInventryID',
            'fkProductID',
            'OptionIDs',
            'OptionQuantity'
        );

        $varWhr = "";
        $varOrderBy = "pkInventryID ASC ";
        $varLimit = "";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getProductToOption
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_product_to_option
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getProductToOption($arrReq)
    {

        $varTbl = TABLE_PRODUCT_TO_OPTION . " INNER JOIN " . TABLE_PRODUCT . " ON (fkProductID = pkProductID AND fkWholesalerID='" . $this->wholesalerID . "')";
        $arrClms = array(
            'pkProductAttributeId',
            'fkProductId',
            'fkAttributeId',
            'fkAttributeOptionId',
            'OptionExtraPrice',
            'OptionIsDefault',
            'AttributeOptionValue',
            'AttributeOptionImage',
            'IsImgUploaded'
        );

        $varWhr = "";
        $varOrderBy = "pkProductAttributeId ASC ";
        $varLimit = "";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getShippingGateways
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getShippingGateways($arrReq)
    {

        $varTbl = TABLE_SHIPPING_GATEWAYS;

        $arrClms = array(
            'pkShippingGatewaysID',
            'ShippingType',
            'ShippingTitle',
            'ShippingAlias',
            'ShippingStatus',
            'ShippingDateAdded'
        );

        $varWhr = "(ShippingStatus = 1) ";

        $varOrderBy = "ShippingTitle ASC ";
        $varLimit = "";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getSpecialApplication
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_special_application
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getSpecialApplication($arrReq)
    {

        $varTbl = TABLE_SPECIAL_APPLICATION;

        $arrClms = array(
            'pkApplicationID',
            'fkWholesalerID',
            'fkFestivalID',
            'fkCountryID',
            'TotalAmount',
            'TransactionID',
            'TransactionAmount',
            'IsPaid',
            'IsApproved',
            'ApplicatonDateAdded'
        );

        $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' ";
        $varOrderBy = "pkApplicationID ASC ";

        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getSpecialApplicationToCategory
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_special_application_to_category
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getSpecialApplicationToCategory($arrReq)
    {

        $varTbl = TABLE_SPECIAL_APPLICATION_TO_CATEGORY . " INNER JOIN " . TABLE_SPECIAL_APPLICATION . " ON (fkApplicationID = pkApplicationID AND fkWholesalerID='" . $this->wholesalerID . "')";

        $arrClms = array(
            'pkApplicationCatID',
            'fkApplicationID',
            'fkCategoryID',
            'ProductQty'
        );

        $varWhr = "";
        $varOrderBy = "pkApplicationCatID ASC ";
        $varLimit = "";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getSpecialProducts
     *
     * This function is used to get all product List.
     *
     * Database Tables used in this function are : tbl_special_product
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getSpecialProducts($arrReq)
    {

        $varTbl = TABLE_SPECIAL_PRODUCT;

        $arrClms = array(
            'pkSpecialID',
            'fkProductID',
            'fkCategoryID',
            'fkWholesalerID',
            'fkFestivalID',
            'SpecialPrice',
            'FinalSpecialPrice',
            'DateAdded'
        );

        $varWhr = " fkWholesalerID = '" . $this->wholesalerID . "' ";

        $varOrderBy = "pkSpecialID ASC ";
        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getProductToPackage
     *
     * This function is used to get all Products of packages.
     *
     * Database Tables used in this function are : tbl_product_to_package and tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getProductToPackage($arrReq)
    {

        $varTbl = TABLE_PRODUCT_TO_PACKAGE . " INNER JOIN " . TABLE_PACKAGE . " ON (fkPackageId = pkPackageId AND fkWholesalerID='" . $this->wholesalerID . "')";

        $arrClms = array(
            'fkPackageId',
            'fkProductId'
        );

        $varOrderBy = "fkPackageId ASC ";
        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    function packageToProductSelected($pkid)
    {
        $varQuery = "SELECT ProductName,fkCategoryID,ProductRefNo,pkProductID,pkPackageID,ProductDescription,PackageName,DiscountFinalPrice,FinalPrice,PackagePrice,ProductImage as ImageName, PackageImage,GROUP_CONCAT(AttributeLabel) as AttributeLabel,GROUP_CONCAT(AttributeOptionValue) as OptionTitle,GROUP_CONCAT(optionColorCode) as optionColorCode,GROUP_CONCAT(AttributeOptionImage) as OptionImage,GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice,GROUP_CONCAT(proOp.fkAttributeId) AS fkAttributeId,GROUP_CONCAT(attrbuteOptionId) AS attrbuteOptionId FROM tbl_package left join tbl_product_to_package pp on pkPackageId=pp.fkPackageId left join tbl_package_product_attribute_option attrOp on (productId=fkProductId and packageId=pp.fkPackageId) left join tbl_attribute on attributeId=pkAttributeID left join tbl_attribute_option on attrbuteOptionId=pkOptionID left join tbl_product_to_option proOp on (productId=proOp.fkProductId and attributeId=proOp.fkAttributeId and attrbuteOptionId=proOp.fkAttributeOptionId) inner join tbl_product tp on pp.fkProductId = pkProductID where pkPackageId='" . $pkid . "' AND PackageStatus = '1' group by pkProductID";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function getAddedPackageLive
     *
     * This function is used to get recently added packages whose offline ID is 0.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getAddedPackageLive($arrReq)
    {

        $varTbl = TABLE_PACKAGE . ' pack inner join tbl_product_to_package pp on pkPackageId=pp.fkPackageId left join tbl_package_product_attribute_option attrOp on (productId=fkProductId and packageId=pp.fkPackageId) left join tbl_attribute on attributeId=pkAttributeID left join tbl_attribute_option on attrbuteOptionId=pkOptionID left join tbl_product_to_option proOp on (productId=proOp.fkProductId and attributeId=proOp.fkAttributeId and attrbuteOptionId=proOp.fkAttributeOptionId) inner join tbl_product tp on pp.fkProductId = pkProductID';

        $arrClms = array(
            'pkPackageId',
            'pack.fkWholesalerID',
            'PackageName',
            'PackageACPrice',
            'PackagePrice',
            'PackageImage',
            'PackageStatus',
            'PackageDateAdded',
            'ProductName',
            'fkCategoryID',
            'ProductRefNo',
            'pkProductID',
            'ProductDescription',
            'DiscountFinalPrice',
            'FinalPrice',
            'PackagePrice',
            'ProductImage as ImageName',
            'PackageImage', 'GROUP_CONCAT(AttributeLabel) as AttributeLabel',
            'GROUP_CONCAT(AttributeOptionValue) as OptionTitle',
            'GROUP_CONCAT(optionColorCode) as optionColorCode', 'GROUP_CONCAT(AttributeOptionImage) as OptionImage',
            'GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice',
            'GROUP_CONCAT(proOp.fkAttributeId) AS fkAttributeId',
            'GROUP_CONCAT(attrbuteOptionId) AS attrbuteOptionId'
        );
        $varWhr = " pack.fkWholesalerID='" . $this->wholesalerID . "' AND packageOfflineID = 0 AND PackageStatus = '1' group by pkProductID,pkPackageId";
        //where pkPackageId='" . $pkid . "' AND PackageStatus = '1' group by pkProductID
        $varOrderBy = "pkPackageId ASC ";
        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        //pre($arrRes);
//        $return = array();
//        if(count($arrRes) > 0){
//            foreach($arrRes as $key=>$v){
//                $return['product']=$arrRes;
//                $return['productAttribute'][$v['pkPackageId']]=$this->packageToProductSelected($v['pkPackageId']);
//                
//            }
//        }
        //$return=array_merge($return['product'], $return['productAttribute']);
        //pre($return);
        //pre(serialize($arrRes));
        return $arrRes;
    }

    /**
     * function sendLiveAddedPackageLocalId
     *
     * This function is used to update localIDs from local response.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendLiveAddedPackageLocalId($arrReq)
    {

        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PACKAGE;
            foreach ($arrReq['data'] as $key => $value)
            {
                $varWhr = '';
                $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND pkPackageId = " . $value['liveID'];
                $arrClms = array(
                    'packageOfflineID' => $value['localID'],
                    'packageLastSyncDateTime' => date(DATE_TIME_FORMAT_DB)
                );
                $arrRes = $this->update($varTbl, $arrClms, $varWhr);
            }
            return $arrRes;
        }
    }

    /**
     * function sendAddedPackageLocal
     *
     * This function is used to get newely added packages, from local whose online ID is 0.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendAddedPackageLocal($arrReq)
    {

        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PACKAGE;

            $objClassCommon = new ClassCommon();

            foreach ($arrReq['data'] as $key => $value)
            {
                $varPackageACPrice = '';
                $varPackageACPrice = $objClassCommon->getAcCostForPackage($value['frmOfferPrice']);
                $arrClms = array(
                    'fkWholesalerID' => $value['fkWholesalerID'],
                    'PackageName' => $value['PackageName'],
                    'PackageACPrice' => $varPackageACPrice,
                    'PackagePrice' => $value['PackagePrice'],
                    'PackageImage' => $value['PackageImage'],
                    'PackageStatus' => $value['PackageStatus'],
                    'PackageDateAdded' => $value['PackageDateAdded'],
                    'packageDateUpdated' => $value['packageDateUpdated'],
                    'packageLastSyncDateTime' => date(DATE_TIME_FORMAT_DB),
                    'packageOfflineID' => $value['packageOfflineID']
                );
                $arrRes[] = array('localID' => $value['packageOfflineID'], 'liveID' => $this->insert($varTbl, $arrClms));
            }
            return $arrRes;
        }
    }

    /**
     * function getAddedSpecialApplicationLive
     *
     * This function is used to get newely added special application whose offline ID is 0.
     *
     * Database Tables used in this function are : tbl_special_application
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getAddedSpecialApplicationLive($arrReq)
    {

        $varTbl = TABLE_SPECIAL_APPLICATION;

        $arrClms = array(
            'pkApplicationID',
            'fkWholesalerID',
            'fkFestivalID',
            'fkCountryID',
            'TotalAmount',
            'TransactionID',
            'TransactionAmount',
            'IsPaid',
            'IsApproved',
            'ApplicatonDateAdded'
        );

        $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND ApplicationOfflineID = 0 ";
        $varOrderBy = " pkApplicationID ASC ";

        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);

        if (!empty($arrRes))
        {
            $i = 0;
            foreach ($arrRes as $resultKey => $resultVal)
            {
                $varTbl1 = TABLE_SPECIAL_APPLICATION_TO_CATEGORY;

                $arrClms1 = array(
                    'fkCategoryID',
                    'ProductQty'
                );

                $varWhr1 = " fkApplicationID='" . $resultVal['pkApplicationID'] . "'";
                $varOrderBy1 = " pkApplicationCatID ASC ";

                $varLimit1 = "";
                $arrRes[$i]['categories'] = $this->select($varTbl1, $arrClms1, $varWhr1, $varOrderBy1, $varLimit1);
                $i++;
            }
        }
        return $arrRes;
    }

    /**
     * function sendLiveAddedSpecialApplicationLocalId
     *
     * This function is used to update localIDs from local response.
     *
     * Database Tables used in this function are : tbl_special_application
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendLiveAddedSpecialApplicationLocalId($arrReq)
    {

        $varTbl = TABLE_SPECIAL_APPLICATION;

        if (!empty($arrReq['data']))
        {
            foreach ($arrReq['data'] as $key => $value)
            {
                $varWhr = '';
                $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND pkApplicationID = " . $value['liveID'];
                $arrClms = array(
                    'ApplicationOfflineID' => $value['localID'],
                    'ApplicationLastSyncDateTime' => date(DATE_TIME_FORMAT_DB)
                );
                $arrRes = $this->update($varTbl, $arrClms, $varWhr);
            }
            return $arrRes;
        }
    }

    /**
     * function sendAddedSpecialApplicationLocal
     *
     * This function is used to get newely added special applications, from local whose online ID is 0.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendAddedSpecialApplicationLocal($arrReq)
    {

        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_SPECIAL_APPLICATION;
            $i = 0;
            foreach ($arrReq['data'] as $key => $value)
            {
                $arrClms = array(
                    'fkWholesalerID' => $value['fkWholesalerID'],
                    'fkFestivalID' => $value['fkFestivalID'],
                    'fkCountryID' => $value['fkCountryID'],
                    'TotalAmount' => $value['TotalAmount'],
                    'TransactionID' => $value['TransactionID'],
                    'TransactionAmount' => $value['TransactionAmount'],
                    'IsPaid' => $value['IsPaid'],
                    'IsApproved' => $value['IsApproved'],
                    'ApplicatonDateAdded' => $value['ApplicatonDateAdded'],
                    'ApplicationLastSyncDateTime' => date(DATE_TIME_FORMAT_DB),
                    'ApplicationOfflineID' => $value['applicationOfflineID']
                );
                $arrRes[] = array('localID' => $value['applicationOfflineID'], 'liveID' => $this->insert($varTbl, $arrClms));

                if (!empty($value['categories']))
                {
                    foreach ($value['categories'] as $resultKey => $resultVal)
                    {
                        $varTbl1 = TABLE_SPECIAL_APPLICATION_TO_CATEGORY;
                        $arrClms1 = array(
                            'fkApplicationID' => $arrRes[$i]['liveID'],
                            'fkCategoryID' => $resultVal['fkCategoryID'],
                            'ProductQty' => $resultVal['ProductQty']
                        );
                        $this->insert($varTbl1, $arrClms1);
                    }
                }
                $i++;
            }
            return $arrRes;
        }
    }

    /**
     * function getAddedProductLive
     *
     * This function is used to get newely added products whose offline ID is 0.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getAddedProductLive($arrReq)
    {

        $varTbl = TABLE_PRODUCT;

        $arrClms = array(
            'pkProductID',
            'fkCategoryID',
            'ProductRefNo',
            'fkWholesalerID',
            'fkShippingID',
            'ProductName',
            'ProductImage',
            'ProductSliderImage',
            'wholesalePrice',
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
            addslashes('ProductDescription'),
            addslashes('ProductTerms'),
            addslashes('YoutubeCode'),
            addslashes('MetaTitle'),
            addslashes('MetaKeywords'),
            addslashes('MetaDescription'),
            'IsFeatured',
            'ProductStatus',
            'CreatedBy',
            'fkCreatedID',
            'UpdatedBy',
            'fkUpdatedID',
            'IsAddedBulkUpload',
            'LastViewed',
            'Sold',
            'ProductDateAdded',
            'ProductDateUpdated',
            'ProductCronUpdate'
        );

        $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND productOfflineID = 0 ";
        $varOrderBy = "pkProductID ASC ";

        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);

        if (!empty($arrRes))
        {
            $i = 0;
            foreach ($arrRes as $resultKey => $resultVal)
            {
                $varTbl1 = TABLE_PACKAGE;       // ========= fetching product package offline/online IDs
                $arrClms1 = array(
                    'pkPackageId',
                    'packageOfflineID'
                );
                $varWhr1 = " fkWholesalerID='" . $this->wholesalerID . "' AND pkPackageId=" . $resultVal['fkPackageId'];
                $varOrderBy1 = " pkPackageId ASC ";
                $varLimit1 = "";
                $arrRes[$i]['package'] = $this->select($varTbl1, $arrClms1, $varWhr1, $varOrderBy1, $varLimit1);


                $varTbl2 = TABLE_PRODUCT_IMAGE;     // ========= fetching product images 
                $arrClms2 = array(
                    'pkImageID',
                    'fkProductID',
                    'ImageName',
                    'ImageDateAdded'
                );
                $varWhr2 = " fkProductID=" . $resultVal['pkProductID'];
                $varOrderBy2 = " pkImageID ASC ";
                $varLimit2 = "";
                $arrRes[$i]['images'] = $this->select($varTbl2, $arrClms2, $varWhr2, $varOrderBy2, $varLimit2);


                $varTbl3 = TABLE_PRODUCT_TO_OPTION;     // ========= fetching product attributes options
                $arrClms3 = array(
                    'pkProductAttributeId',
                    'fkProductId',
                    'fkAttributeId',
                    'fkAttributeOptionId',
                    'OptionExtraPrice',
                    'OptionIsDefault',
                    'AttributeOptionValue',
                    'AttributeOptionImage',
                    'IsImgUploaded'
                );
                $varWhr3 = " fkProductId=" . $resultVal['pkProductID'];
                $varOrderBy3 = " pkProductAttributeId ASC ";
                $varLimit3 = "";
                $arrRes[$i]['options'] = $this->select($varTbl3, $arrClms3, $varWhr3, $varOrderBy3, $varLimit3);

                $varTbl4 = TABLE_PRODUCT_OPTION_INVENTORY;     // ========= fetching product inventory attribute wise 
                $arrClms4 = array(
                    'pkInventryID',
                    'fkProductID',
                    'OptionIDs',
                    'OptionQuantity'
                );
                $varWhr4 = " fkProductID=" . $resultVal['pkProductID'];
                $varOrderBy4 = " OptionIDs ASC ";
                $varLimit4 = "";
                $arrRes[$i]['optionsInventory'] = $this->select($varTbl4, $arrClms4, $varWhr4, $varOrderBy4, $varLimit4);

                $varTbl5 = TABLE_SPECIAL_PRODUCT;     // ========= fetching special product
                $arrClms5 = array(
                    'pkSpecialID',
                    'fkProductID',
                    'fkCategoryID',
                    'fkWholesalerID',
                    'fkFestivalID',
                    'SpecialPrice',
                    'FinalSpecialPrice',
                    'DateAdded'
                );
                $varWhr5 = " fkProductId=" . $resultVal['pkProductID'];
                $varOrderBy5 = " pkSpecialID ASC ";
                $varLimit5 = "";
                $arrRes[$i]['specialProduct'] = $this->select($varTbl5, $arrClms5, $varWhr5, $varOrderBy5, $varLimit5);

                $i++;
            }
        }
        return $arrRes;
    }

    /**
     * function sendLiveAddedProductLocalId
     *
     * This function is used to update localIDs from local response.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendLiveAddedProductLocalId($arrReq)
    {

        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PRODUCT;
            foreach ($arrReq['data'] as $key => $value)
            {
                $varWhr = '';
                $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND pkProductID = " . $value['liveID'];
                $arrClms = array(
                    'productOfflineID' => $value['localID'],
                    'productLastSyncDateTime' => date(DATE_TIME_FORMAT_DB)
                );
                $arrRes = $this->update($varTbl, $arrClms, $varWhr);
            }
            return $arrRes;
        }
    }

    /**
     * function sendAddedProductLocal
     *
     * This function is used to get newely added products, from local whose online ID is 0.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendAddedProductLocal($arrReq)
    {
        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PRODUCT;
            $i = 0;
            foreach ($arrReq['data'] as $key => $value)
            {
                $varPackageID = '';
                if (!empty($value['package']))
                {
                    $varPackageID = $value['package'][0]['packageOnlineID'];
                }
                $arrClms = array(
                    'fkCategoryID' => $value['fkCategoryID'],
                    'ProductRefNo' => $value['ProductRefNo'],
                    'fkWholesalerID' => $value['fkWholesalerID'],
                    'fkShippingID' => $value['fkShippingID'],
                    'ProductName' => addslashes($value['ProductName']),
                    'ProductImage' => $value['ProductImage'],
                    'ProductSliderImage' => $value['ProductSliderImage'],
                    'wholesalePrice' => $value['wholesalePrice'],
                    'FinalPrice' => $value['FinalPrice'],
                    'DiscountPrice' => $value['DiscountPrice'],
                    'DiscountFinalPrice' => $value['DiscountFinalPrice'],
                    'DateStart' => $value['DateStart'],
                    'DateEnd' => $value['DateEnd'],
                    'Quantity' => $value['Quantity'],
                    'QuantityAlert' => $value['QuantityAlert'],
                    'Weight' => $value['Weight'],
                    'WeightUnit' => $value['WeightUnit'],
                    'Length' => $value['Length'],
                    'Width' => $value['Width'],
                    'Height' => $value['Height'],
                    'DimensionUnit' => $value['DimensionUnit'],
                    'fkPackageId' => $varPackageID,
                    'ProductDescription' => addslashes($value['ProductDescription']),
                    'ProductTerms' => addslashes($value['ProductTerms']),
                    'YoutubeCode' => addslashes($value['YoutubeCode']),
                    'MetaTitle' => addslashes($value['MetaTitle']),
                    'MetaKeywords' => addslashes($value['MetaKeywords']),
                    'MetaDescription' => addslashes($value['MetaDescription']),
                    'IsFeatured' => $value['IsFeatured'],
                    'ProductStatus' => $value['ProductStatus'],
                    'CreatedBy' => $value['CreatedBy'],
                    'fkCreatedID' => $value['fkCreatedID'],
                    'UpdatedBy' => $value['UpdatedBy'],
                    'fkUpdatedID' => $value['fkUpdatedID'],
                    'IsAddedBulkUpload' => $value['IsAddedBulkUpload'],
                    'LastViewed' => $value['LastViewed'],
                    'Sold' => $value['Sold'],
                    'ProductDateAdded' => $value['ProductDateAdded'],
                    //'ProductDateUpdated' => $value['ProductDateUpdated'],
                    'ProductCronUpdate' => $value['ProductCronUpdate'],
                    'productOfflineID' => $value['productOfflineID'],
                    'productLastSyncDateTime' => date(DATE_TIME_FORMAT_DB)
                );

                $arrRes[] = array('localID' => $value['productOfflineID'], 'liveID' => $this->insert($varTbl, $arrClms));

                if (!empty($value['images']))
                {
                    foreach ($value['images'] as $resultKey => $resultVal)
                    {
                        $varTbl2 = TABLE_PRODUCT_IMAGE;     // ========= inserting product images 
                        $arrClms2 = array(
                            'fkProductID' => $arrRes[$i]['liveID'],
                            'ImageName' => $resultVal['ImageName'],
                            'ImageDateAdded' => $resultVal['ImageDateAdded']
                        );
                        $this->insert($varTbl2, $arrClms2);
                    }
                }
                if (!empty($value['options']))
                {
                    foreach ($value['options'] as $resultKey1 => $resultVal1)
                    {
                        $varTbl3 = TABLE_PRODUCT_TO_OPTION;     // ========= fetching product attributes options
                        $arrClms3 = array(
                            'fkProductId' => $arrRes[$i]['liveID'],
                            'fkAttributeId' => $resultVal1['fkAttributeId'],
                            'fkAttributeOptionId' => $resultVal1['fkAttributeOptionId'],
                            'OptionExtraPrice' => $resultVal1['OptionExtraPrice'],
                            'OptionIsDefault' => $resultVal1['OptionIsDefault'],
                            'AttributeOptionValue' => $resultVal1['AttributeOptionValue'],
                            'AttributeOptionImage' => $resultVal1['AttributeOptionImage'],
                            'IsImgUploaded' => $resultVal1['IsImgUploaded']
                        );
                        $arrRes1[] = array('localID' => $arrRes[$i]['localID'], 'liveID' => $arrRes[$i]['liveID'], 'fkAttributeOptionId' => $resultVal1['fkAttributeOptionId'], 'pkProductAttributeId' => $this->insert($varTbl3, $arrClms3));
                    }
                    $arrRes[$i]['attributes'] = ($arrRes1);
                }
                if (!empty($value['optionsInventory']))
                {
                    foreach ($value['optionsInventory'] as $resultKey1 => $resultVal1)
                    {
                        $varTbl4 = TABLE_PRODUCT_OPTION_INVENTORY;     // ========= fetching product attributes inventory
                        $arrClms4 = array(
                            'fkProductID' => $arrRes[$i]['liveID'],
                            'OptionIDs' => $resultVal1['OptionIDs'],
                            'OptionQuantity' => $resultVal1['OptionQuantity']
                        );
                        $this->insert($varTbl4, $arrClms4);
                    }
                }
                if (!empty($value['specialProduct']))
                {
                    foreach ($value['specialProduct'] as $resultKey2 => $resultVal2)
                    {
                        $varTbl5 = TABLE_SPECIAL_PRODUCT;         // ========= fetching special product
                        $arrClms5 = array(
                            'fkProductID' => $arrRes[$i]['liveID'],
                            'fkCategoryID' => $resultVal2['fkCategoryID'],
                            'fkWholesalerID' => $resultVal2['fkWholesalerID'],
                            'fkFestivalID' => $resultVal2['fkFestivalID'],
                            'SpecialPrice' => $resultVal2['SpecialPrice'],
                            'FinalSpecialPrice' => $resultVal2['FinalSpecialPrice'],
                            'DateAdded' => $resultVal2['DateAdded']
                        );
                        $this->insert($varTbl5, $arrClms5);
                    }
                }
                $i++;
            }
            return $arrRes;
        }
    }

    /**
     * function getAddedProductToPackageLive
     *
     * This function is used to get newely added products to package.
     *
     * Database Tables used in this function are : tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getAddedProductToPackageLive($arrReq)
    {

        $varTbl = TABLE_PACKAGE . ' as pak INNER JOIN ' . TABLE_PRODUCT_TO_PACKAGE . ' as prdp ON pak.pkPackageId = prdp.fkPackageId INNER JOIN ' . TABLE_PRODUCT . ' as prd ON prdp.fkProductId = prd.pkProductID ';

        $arrClms = array(
            'prdp.fkPackageId',
            'pak.packageOfflineID',
            'prdp.fkProductId',
            'prd.productOfflineID'
        );
        $varWhr = "pak.fkWholesalerID='" . $this->wholesalerID . "' AND DATE_FORMAT(pak.packageLastSyncDateTime,'%Y-%m-%d') <= STR_TO_DATE('" . date('Y-m-d') . "','%Y-%m-%d') ";
        $varOrderBy = " prdp.fkPackageId ASC ";
        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function sendAddedProductToPackageLocal
     *
     * This function is used to get newely added products to package, from local.
     *
     * Database Tables used in this function are : tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendAddedProductToPackageLocal($arrReq)
    {
        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PRODUCT_TO_PACKAGE;
            $i = 0;
            $cu = 1;
            foreach ($arrReq['data'] as $key => $value)
            {
                $arrClms = array(
                    'fkPackageId' => $value['fkPackageId'],
                    'fkProductId' => $value['fkProductId']
                );
                $arrRes = $this->insert($varTbl, $arrClms);
                $frmAttribute = count($value['pattribute_' . $cu]);
                // Add product wise attribute with attribute option
                if ($frmAttribute > 0)
                {
                    foreach ($value['pattribute_' . $cu] as $key => $valOption)
                    {
                        $getAttr = explode("_", $key);
                        $getAttr = $getAttr[0];
                        $getAttrOptionId = $value['frmAttribute_' . $key];
                        $arrClmsProPack = array(
                            'packageId' => $value['fkPackageId'],
                            'productId' => $value['fkProductId'],
                            'attributeId' => $getAttr,
                            'attrbuteOptionId' => $getAttrOptionId
                        );
                        $this->insert(TABLE_PACKAGE_PRODUCT_ATTRIBUTE_OPTION, $arrClmsProPack);
                    }
                }
                $cu++;
            }
            return $arrRes;
        }
    }

    /**
     * function uploadProductImagesLocal
     *
     * This function is used to upload newely added products images from local to live.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function uploadProductImagesLocal($arrReq)
    {
        global $arrProductImageResizes, $objCore;
        $objUpload = new upload();
        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/products/';

        if (!empty($arrReq['data']))
        {
            $i = 0;
            foreach ($arrReq['data'] as $key => $value)
            {
                $imgName = $value['imgName'];
                $imgSize = '';
                if ($imgName != '')
                {
                    $img = str_replace(" ", "+", stripslashes($value['imgString']));
                    $data = base64_decode($img);
                    file_put_contents($varDirLocation . $imgSize . "/" . $imgName, $data);
                    $arrRes[$i]['imgString'] = $img;
                    $arrRes[$i]['imgName'] = $imgName;
                    $i++;

                    $infoExt = pathinfo($imgName);
                    $ext = strtolower($infoExt['extension']);
                    if (in_array($ext, array('jpg', 'png', 'jpeg', 'gif')))
                    {
                        $objUpload->setMaxSize();
                        $objUpload->setDirectory($varDirLocation);
                        $objUpload->setFileName($imgName);

                        $objUpload->setThumbnailName('original/');
                        $objUpload->createThumbnail();

                        foreach ($arrProductImageResizes as $key => $val)
                        {
                            $thumbnailName = $val . '/';
                            list($width, $height) = explode('x', $val);
                            $objUpload->setThumbnailName($thumbnailName);
                            // create thumbnail
                            $objUpload->createThumbnail();
                            // change thumbnail size
                            $objUpload->setThumbnailSizeNew($width, $height);
                        }
                    }
                }
            }
            return $arrRes;
        }
    }

    /**
     * function uploadPackageImagesLocal
     *
     * This function is used to upload newely added package images from local to live.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function uploadPackageImagesLocal($arrReq)
    {
        global $arrSpecialPageBannerImage, $objCore;
        $objUpload = new upload();
        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/package/';
        if (!empty($arrReq['data']))
        {
            $i = 0;
            foreach ($arrReq['data'] as $key => $value)
            {
                $imgName = $value['imgName'];
                $imgSize = '';
                if ($imgName != '')
                {
                    $img = str_replace(" ", "+", stripslashes($value['imgString']));
                    $data = base64_decode($img);
                    file_put_contents($varDirLocation . $imgSize . "/" . $imgName, $data);
                    $arrRes[$i]['imgString'] = $img;
                    $arrRes[$i]['imgName'] = $imgName;
                    $i++;

                    $infoExt = pathinfo($imgName);
                    $ext = strtolower($infoExt['extension']);
                    if (in_array($ext, array('jpg', 'png', 'jpeg', 'gif')))
                    {
                        $objUpload->setMaxSize();
                        $objUpload->setDirectory($varDirLocation);
                        $objUpload->setFileName($imgName);

                        list($width, $height) = explode('x', PACKAGE_IMAGE_RESIZE1);
                        $objUpload->setThumbnailName(PACKAGE_IMAGE_RESIZE1 . '/');
                        $objUpload->createThumbnail();
                        $objUpload->setThumbnailSize($width, $height);
                    }
                }
            }
            return $arrRes;
        }
    }

    /**
     * function getUpdatedProductLive
     *
     * This function is used to get newely added products whose offline ID is 0.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getUpdatedProductLive($arrReq)
    {

        $varTbl = TABLE_PRODUCT;

        $arrClms = array(
            'pkProductID',
            'fkCategoryID',
            'ProductRefNo',
            'fkWholesalerID',
            'fkShippingID',
            'ProductName',
            'ProductImage',
            'ProductSliderImage',
            'wholesalePrice',
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
            addslashes('ProductDescription'),
            addslashes('ProductTerms'),
            addslashes('YoutubeCode'),
            addslashes('MetaTitle'),
            addslashes('MetaKeywords'),
            addslashes('MetaDescription'),
            'IsFeatured',
            'ProductStatus',
            'CreatedBy',
            'fkCreatedID',
            'UpdatedBy',
            'fkUpdatedID',
            'IsAddedBulkUpload',
            'LastViewed',
            'Sold',
            'ProductDateAdded',
            'ProductDateUpdated',
            'ProductCronUpdate'
        );

        $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND productOfflineID > 0  AND productLastSyncDateTime < ProductDateUpdated";
        $varOrderBy = "pkProductID ASC ";

        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);

        if (!empty($arrRes))
        {
            $i = 0;
            foreach ($arrRes as $resultKey => $resultVal)
            {
                // ========= fetching product package offline/online IDs
                $arrRes[$i]['package'] = array();

                $varTbl2 = TABLE_PRODUCT_IMAGE;     // ========= fetching product images 
                $arrClms2 = array(
                    'pkImageID',
                    'fkProductID',
                    'ImageName',
                    'ImageDateAdded'
                );
                $varWhr2 = " fkProductID=" . $resultVal['pkProductID'];
                $varOrderBy2 = " pkImageID ASC ";
                $varLimit2 = "";
                $arrRes[$i]['images'] = $this->select($varTbl2, $arrClms2, $varWhr2, $varOrderBy2, $varLimit2);


                $varTbl3 = TABLE_PRODUCT_TO_OPTION;     // ========= fetching product attributes options
                $arrClms3 = array(
                    'pkProductAttributeId',
                    'fkProductId',
                    'fkAttributeId',
                    'fkAttributeOptionId',
                    'OptionExtraPrice',
                    'OptionIsDefault',
                    'AttributeOptionValue',
                    'AttributeOptionImage',
                    'IsImgUploaded'
                );
                $varWhr3 = " fkProductId=" . $resultVal['pkProductID'];
                $varOrderBy3 = " pkProductAttributeId ASC ";
                $varLimit3 = "";
                $arrRes[$i]['options'] = $this->select($varTbl3, $arrClms3, $varWhr3, $varOrderBy3, $varLimit3);

                $varTbl4 = TABLE_PRODUCT_OPTION_INVENTORY;     // ========= fetching product inventory attribute wise 
                $arrClms4 = array(
                    'pkInventryID',
                    'fkProductID',
                    'OptionIDs',
                    'OptionQuantity'
                );
                $varWhr4 = " fkProductID=" . $resultVal['pkProductID'];
                $varOrderBy4 = " OptionIDs ASC ";
                $varLimit4 = "";
                $arrRes[$i]['optionsInventory'] = $this->select($varTbl4, $arrClms4, $varWhr4, $varOrderBy4, $varLimit4);

                $varTbl5 = TABLE_SPECIAL_PRODUCT;     // ========= fetching special product
                $arrClms5 = array(
                    'pkSpecialID',
                    'fkProductID',
                    'fkCategoryID',
                    'fkWholesalerID',
                    'fkFestivalID',
                    'SpecialPrice',
                    'FinalSpecialPrice',
                    'DateAdded'
                );
                $varWhr5 = " fkProductId=" . $resultVal['pkProductID'];
                $varOrderBy5 = " pkSpecialID ASC ";
                $varLimit5 = "";
                $arrRes[$i]['specialProduct'] = $this->select($varTbl5, $arrClms5, $varWhr5, $varOrderBy5, $varLimit5);

                $i++;
            }
        }
        return $arrRes;
    }

    /**
     * function sendUpdatedProductLocal
     *
     * This function is used to get newely added products, from local whose online ID is 0.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendUpdatedProductLocal($arrReq)
    {
        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PRODUCT;
            $i = 0;
            foreach ($arrReq['data'] as $key => $value)
            {
                $varPackageID = '';
                if (!empty($value['package']))
                {
                    $varPackageID = $value['package'][0]['packageOnlineID'];
                }
                $arrClms = array(
                    'fkCategoryID' => $value['fkCategoryID'],
                    'ProductRefNo' => $value['ProductRefNo'],
                    'fkWholesalerID' => $value['fkWholesalerID'],
                    'fkShippingID' => $value['fkShippingID'],
                    'ProductName' => addslashes($value['ProductName']),
                    'ProductImage' => $value['ProductImage'],
                    'ProductSliderImage' => $value['ProductSliderImage'],
                    'wholesalePrice' => $value['wholesalePrice'],
                    'FinalPrice' => $value['FinalPrice'],
                    'DiscountPrice' => $value['DiscountPrice'],
                    'DiscountFinalPrice' => $value['DiscountFinalPrice'],
                    'DateStart' => $value['DateStart'],
                    'DateEnd' => $value['DateEnd'],
                    'Quantity' => $value['Quantity'],
                    'QuantityAlert' => $value['QuantityAlert'],
                    'Weight' => $value['Weight'],
                    'WeightUnit' => $value['WeightUnit'],
                    'Length' => $value['Length'],
                    'Width' => $value['Width'],
                    'Height' => $value['Height'],
                    'DimensionUnit' => $value['DimensionUnit'],
                    'fkPackageId' => $varPackageID,
                    'ProductDescription' => addslashes($value['ProductDescription']),
                    'ProductTerms' => addslashes($value['ProductTerms']),
                    'YoutubeCode' => addslashes($value['YoutubeCode']),
                    'MetaTitle' => addslashes($value['MetaTitle']),
                    'MetaKeywords' => addslashes($value['MetaKeywords']),
                    'MetaDescription' => addslashes($value['MetaDescription']),
                    'IsFeatured' => $value['IsFeatured'],
                    'ProductStatus' => $value['ProductStatus'],
                    'CreatedBy' => $value['CreatedBy'],
                    'fkCreatedID' => $value['fkCreatedID'],
                    'UpdatedBy' => $value['UpdatedBy'],
                    'fkUpdatedID' => $value['fkUpdatedID'],
                    'IsAddedBulkUpload' => $value['IsAddedBulkUpload'],
                    'LastViewed' => $value['LastViewed'],
                    'Sold' => $value['Sold'],
                    'ProductDateAdded' => $value['ProductDateAdded'],
                    //'ProductDateUpdated' => date(DATE_TIME_FORMAT_DB),
                    'ProductCronUpdate' => $value['ProductCronUpdate'],
                    'productOfflineID' => $value['productOfflineID'],
                    'productLastSyncDateTime' => date(DATE_TIME_FORMAT_DB)
                );
                $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND productOfflineID = '" . $value['productOfflineID'] . "' AND pkProductID = '" . $value['pkProductID'] . "'";
                $this->update($varTbl, $arrClms, $varWhr);
                $arrRes[] = array('localID' => $value['productOfflineID'], 'liveID' => $value['pkProductID']);

                if (!empty($value['images']))
                {
                    $varWheredelete = " fkProductID = '" . (int) $arrRes[$i]['liveID'] . "'";
                    $varAffected = $this->delete(TABLE_PRODUCT_IMAGE, $varWheredelete);

                    foreach ($value['images'] as $resultKey => $resultVal)
                    {
                        $varTbl2 = TABLE_PRODUCT_IMAGE;     // ========= inserting product images 
                        $arrClms2 = array(
                            'fkProductID' => $arrRes[$i]['liveID'],
                            'ImageName' => $resultVal['ImageName'],
                            'ImageDateAdded' => $resultVal['ImageDateAdded']
                        );
                        $this->insert($varTbl2, $arrClms2);
                    }
                }
                if (!empty($value['options']))
                {
                    $varWheredelete = " fkProductId = '" . (int) $arrRes[$i]['liveID'] . "'";
                    $varAffected = $this->delete(TABLE_PRODUCT_TO_OPTION, $varWheredelete);

                    foreach ($value['options'] as $resultKey1 => $resultVal1)
                    {
                        $varTbl3 = TABLE_PRODUCT_TO_OPTION;     // ========= fetching product attributes options
                        $arrClms3 = array(
                            'fkProductId' => $arrRes[$i]['liveID'],
                            'fkAttributeId' => $resultVal1['fkAttributeId'],
                            'fkAttributeOptionId' => $resultVal1['fkAttributeOptionId'],
                            'OptionExtraPrice' => $resultVal1['OptionExtraPrice'],
                            'OptionIsDefault' => $resultVal1['OptionIsDefault'],
                            'AttributeOptionValue' => $resultVal1['AttributeOptionValue'],
                            'AttributeOptionImage' => $resultVal1['AttributeOptionImage'],
                            'IsImgUploaded' => $resultVal1['IsImgUploaded']
                        );
                        $arrRes1[] = array('localID' => $arrRes[$i]['localID'], 'liveID' => $arrRes[$i]['liveID'], 'fkAttributeOptionId' => $resultVal1['fkAttributeOptionId'], 'pkProductAttributeId' => $this->insert($varTbl3, $arrClms3));
                        //$this->insert($varTbl3, $arrClms3);
                    }
                    $arrRes[$i]['attributes'] = ($arrRes1);
                }
                if (!empty($value['optionsInventory']))
                {
                    $varWheredelete = " fkProductID = '" . (int) $arrRes[$i]['liveID'] . "'";
                    $varAffected = $this->delete(TABLE_PRODUCT_OPTION_INVENTORY, $varWheredelete);

                    foreach ($value['optionsInventory'] as $resultKey1 => $resultVal1)
                    {
                        $varTbl4 = TABLE_PRODUCT_OPTION_INVENTORY;     // ========= fetching product attributes inventory
                        $arrClms4 = array(
                            'fkProductID' => $arrRes[$i]['liveID'],
                            'OptionIDs' => $resultVal1['OptionIDs'],
                            'OptionQuantity' => $resultVal1['OptionQuantity']
                        );
                        $this->insert($varTbl4, $arrClms4);
                    }
                }
                if (!empty($value['specialProduct']))
                {
                    $varWheredelete = " fkProductID = '" . (int) $arrRes[$i]['liveID'] . "'";
                    $varAffected = $this->delete(TABLE_SPECIAL_PRODUCT, $varWheredelete);

                    foreach ($value['specialProduct'] as $resultKey2 => $resultVal2)
                    {
                        $varTbl5 = TABLE_SPECIAL_PRODUCT;         // ========= fetching special product
                        $arrClms5 = array(
                            'fkProductID' => $arrRes[$i]['liveID'],
                            'fkCategoryID' => $resultVal2['fkCategoryID'],
                            'fkWholesalerID' => $resultVal2['fkWholesalerID'],
                            'fkFestivalID' => $resultVal2['fkFestivalID'],
                            'SpecialPrice' => $resultVal2['SpecialPrice'],
                            'FinalSpecialPrice' => $resultVal2['FinalSpecialPrice'],
                            'DateAdded' => $resultVal2['DateAdded']
                        );
                        $this->insert($varTbl5, $arrClms5);
                    }
                }
                $i++;
            }
            return $arrRes;
        }
    }

    /**
     * function getUpdatedProductToPackageLive
     *
     * This function is used to get newely added products to package.
     *
     * Database Tables used in this function are : tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getUpdatedProductToPackageLive($arrReq)
    {

        $varTbl = TABLE_PACKAGE . ' as pak INNER JOIN ' . TABLE_PRODUCT_TO_PACKAGE . ' as prdp ON pak.pkPackageId = prdp.fkPackageId INNER JOIN ' . TABLE_PRODUCT . ' as prd ON prdp.fkProductId = prd.pkProductID ';

        $arrClms = array(
            'prdp.fkPackageId',
            'pak.packageOfflineID',
            'prdp.fkProductId',
            'prd.productOfflineID'
        );
        $varWhr = " pak.fkWholesalerID='" . $this->wholesalerID . "' AND pak.packageOfflineID > 0 AND pak.packageLastSyncDateTime < pak.packageDateUpdated";
        $varOrderBy = " prdp.fkPackageId ASC ";
        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function sendUpdatedProductToPackageLocal
     *
     * This function is used to get newely added products to package, from local.
     *
     * Database Tables used in this function are : tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendUpdatedProductToPackageLocal($arrReq)
    {
        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PRODUCT_TO_PACKAGE;
            $i = 0;
            $pkgIds = array();

            foreach ($arrReq['data'] as $key => $value)
            {
                $pkgIds[] = $value['fkPackageId'];
            }
            //pre($value);
            if (count($pkgIds) > 0)
            { //pre($pkgIds);
                $varWhr = " fkPackageId in(" . implode(",", $pkgIds) . ")";
                $arrRes = $this->delete($varTbl, $varWhr);
                $varWh = "packageId in(" . implode(",", $pkgIds) . ")";
                $this->delete(TABLE_PACKAGE_PRODUCT_ATTRIBUTE_OPTION, $varWh);
            }
            $cu = 1;
            foreach ($arrReq['data'] as $key => $value)
            {
                $arrClms = array(
                    'fkPackageId' => $value['fkPackageId'],
                    'fkProductId' => $value['fkProductId']
                );
                $arrRes = $this->insert($varTbl, $arrClms);
                $frmAttribute = count($value['pattribute_' . $cu]);
                // Add product wise attribute with attribute option
                if ($frmAttribute > 0)
                {
                    foreach ($value['pattribute_' . $cu] as $key => $valOption)
                    {
                        $getAttr = explode("_", $key);
                        $getAttr = $getAttr[0];
                        $getAttrOptionId = $value['frmAttribute_' . $key];
                        $arrClmsProPack = array(
                            'packageId' => $value['fkPackageId'],
                            'productId' => $value['fkProductId'],
                            'attributeId' => $getAttr,
                            'attrbuteOptionId' => $getAttrOptionId
                        );
                        $this->insert(TABLE_PACKAGE_PRODUCT_ATTRIBUTE_OPTION, $arrClmsProPack);
                    }
                }
                $cu++;
            }
            //return $arrRes;
        }
    }

    /**
     * function getUpdatedPackageLive
     *
     * This function is used to get recently added packages whose offline ID is 0.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getUpdatedPackageLive($arrReq)
    {

        $varTbl = TABLE_PACKAGE . ' pack inner join tbl_product_to_package pp on pkPackageId=pp.fkPackageId left join tbl_package_product_attribute_option attrOp on (productId=fkProductId and packageId=pp.fkPackageId) left join tbl_attribute on attributeId=pkAttributeID left join tbl_attribute_option on attrbuteOptionId=pkOptionID left join tbl_product_to_option proOp on (productId=proOp.fkProductId and attributeId=proOp.fkAttributeId and attrbuteOptionId=proOp.fkAttributeOptionId) inner join tbl_product tp on pp.fkProductId = pkProductID';

        $arrClms = array(
            'pkPackageId',
            'pack.fkWholesalerID',
            'PackageName',
            'PackageACPrice',
            'PackagePrice',
            'PackageImage',
            'PackageStatus',
            'packageOfflineID',
            'PackageDateAdded',
            'packageDateUpdated',
            'ProductName',
            'fkCategoryID',
            'ProductRefNo',
            'pkProductID',
            'ProductDescription',
            'DiscountFinalPrice',
            'FinalPrice',
            'PackagePrice',
            'ProductImage as ImageName',
            'PackageImage', 'GROUP_CONCAT(AttributeLabel) as AttributeLabel',
            'GROUP_CONCAT(AttributeOptionValue) as OptionTitle',
            'GROUP_CONCAT(optionColorCode) as optionColorCode', 'GROUP_CONCAT(AttributeOptionImage) as OptionImage',
            'GROUP_CONCAT(OptionExtraPrice) as OptionExtraPrice',
            'GROUP_CONCAT(proOp.fkAttributeId) AS fkAttributeId',
            'GROUP_CONCAT(attrbuteOptionId) AS attrbuteOptionId'
        );
        $varWhr = " pack.fkWholesalerID='" . $this->wholesalerID . "' AND packageOfflineID > 0 AND packageOfflineID <>'null' AND packageLastSyncDateTime < packageDateUpdated group by pkProductID,pkPackageId";
        //where pkPackageId='" . $pkid . "' AND PackageStatus = '1' group by pkProductID
        $varOrderBy = "pkPackageId ASC ";
        $varLimit = "";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        //pre($arrRes);
//        $return = array();
//        if(count($arrRes) > 0){
//            foreach($arrRes as $key=>$v){
//                $return['product']=$arrRes;
//                $return['productAttribute'][$v['pkPackageId']]=$this->packageToProductSelected($v['pkPackageId']);
//                
//            }
//        }
        //$return=array_merge($return['product'], $return['productAttribute']);
        //pre($return);
        //pre(serialize($arrRes));
        return $arrRes;
    }

//    public function getUpdatedPackageLive($arrReq) {
//
//        $varTbl = TABLE_PACKAGE;
//
//        $arrClms = array(
//            'pkPackageId',
//            'fkWholesalerID',
//            'PackageName',
//            'PackageACPrice',
//            'PackagePrice',
//            'PackageImage',
//            'PackageStatus',
//            'packageOfflineID',
//            'PackageDateAdded',
//            'packageDateUpdated'
//        );
//
//        $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND packageOfflineID > 0 AND packageOfflineID <>'null' AND packageLastSyncDateTime < packageDateUpdated";
//        $varOrderBy = "pkPackageId ASC ";
//
//        $varLimit = "";
//
//        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
//        $return = array();
//        if(count($arrRes) > 0){
//            foreach($arrRes as $key=>$v){
//                $return['product']=$arrRes;
//                $return['productAttribute'][$v['pkPackageId']]=$this->packageToProductSelected($v['pkPackageId']);
//            }
//        }
//        //pre(serialize($return));
//        return $return;
//        //return $arrRes;
//    }

    /**
     * function sendUpdatedPackageLocal
     *
     * This function is used to get newely added packages, from local whose online ID is 0.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendUpdatedPackageLocal($arrReq)
    {

        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PACKAGE;

            $objClassCommon = new ClassCommon();
            foreach ($arrReq['data'] as $key => $value)
            {
                $varPackageACPrice = '';
                $varPackageACPrice = $objClassCommon->getAcCostForPackage($value['PackageACPrice']);
                $arrClms = array(
                    'fkWholesalerID' => $value['fkWholesalerID'],
                    'PackageName' => $value['PackageName'],
                    'PackageACPrice' => $varPackageACPrice,
                    'PackagePrice' => $value['PackagePrice'],
                    'PackageImage' => $value['PackageImage'],
                    'PackageStatus' => $value['PackageStatus'],
                    'PackageDateAdded' => $value['PackageDateAdded'],
                    //'packageDateUpdated' => $value['packageDateUpdated'],
                    'packageLastSyncDateTime' => date(DATE_TIME_FORMAT_DB),
                    'packageOfflineID' => $value['packageOfflineID']
                );
                $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND pkPackageId = '" . $value['pkPackageId'] . "'";
                $this->update($varTbl, $arrClms, $varWhr);
                $arrRes[] = array('localID' => $value['packageOfflineID'], 'liveID' => $value['pkPackageId']);
            }
            return $arrRes;
        }
    }

    /**
     * function sendDeletedPackageLocal
     *
     * This function is used to get newely added packages, from local whose online ID is 0.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendDeletedPackageLocal($arrReq)
    {

        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PACKAGE;

            foreach ($arrReq['data'] as $key => $value)
            {
                $arrClms = array(
                    'pkPackageId',
                    'PackageImage'
                );
                $varWhr = " fkWholesalerID='" . $this->wholesalerID . "' AND pkPackageId=" . $value['fkPackageId'];
                $arrRes = $this->select($varTbl, $arrClms, $varWhr);
                if ($arrRes[0]['PackageImage'] != '')
                {
                    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/package/' . trim($PackageImage);
                    if (file_exists($varDirLocation))
                        unlink($varDirLocation);
                }
                $this->delete($varTbl, $varWhr);
            }
            return $arrRes;
        }
    }

    /**
     * function sendDeletedProductLocal
     *
     * This function is used to get newely added packages, from local whose online ID is 0.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendDeletedProductLocal($arrReq)
    {

        if (!empty($arrReq['data']))
        {
            $objClassWholesaler = new Wholesaler();
            $objClassWholesaler->deleteProduct();

            foreach ($arrReq['data'] as $key => $value)
            {
                $arrRes[] = $value['pkProductID'];
                $objClassWholesaler->deleteProduct($value['pkProductID'], $this->wholesalerID);
            }
            return $arrRes;
        }
    }

    /**
     * function getDeletedPackageLive
     *
     * This function is used to get newely added packages, from local whose online ID is 0.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getDeletedPackageLive($arrReq)
    {

        $varTbl = TABLE_WHOLESALER_PACKAGE_DELETE;
        $arrClms = array(
            'fkPackageId'
        );
        $varWhr = " fkWholesalerID='" . $this->wholesalerID . "'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);
        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes;
    }

    /**
     * function getDeletedProductLive
     *
     * This function is used to get newely added packages, from local whose online ID is 0.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getDeletedProductLive($arrReq)
    {
        $varTbl = TABLE_WHOLESALER_PRODUCT_DELETE;
        $arrClms = array(
            'fkProductID'
        );
        $varWhr = " fkWholesalerID='" . $this->wholesalerID . "'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);
        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes;
    }

    /**
     * function sendAddCategoryToLocal
     *
     * This function is used to get newely added category, from live.
     *
     * Database Tables used in this function are : updateCategoryAttrShipping
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendAddCategoryToLocal($arrReq)
    {

        $varTbl = TABLE_UPDATE_CATEGORY_ATTR_SHIPPING;
        $arrClms = array('id', 'name');
        $varWhr = " action='add' AND type='category'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrRes) > 0)
        {

            foreach ($arrRes as $key => $v)
            {
                $arrClmsCat = array(
                    'pkCategoryId',
                    'CategoryParentId',
                    'CategoryName',
                    'CategoryLevel',
                    'CategoryDescription',
                    'CategoryOrdering',
                    'CategoryHierarchy',
                    'CategoryMetaTitle',
                    'CategoryMetaKeywords',
                    'CategoryMetaDescription',
                    'CategoryStatus',
                    'CategoryIsDeleted',
                    'CategoryDateAdded',
                    'CategoryDateModified'
                );
                $varTblCat = TABLE_CATEGORY;
                $varWhrCat = "pkCategoryId='" . $v['id'] . "'";
                $arrRes1 = $this->select($varTblCat, $arrClmsCat, $varWhrCat);
            }
        }

        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes1;
    }

    /**
     * function sendUpdatedCategoryToLocal
     *
     * This function is used to get newely updated category, from live.
     *
     * Database Tables used in this function are : updateCategoryAttrShipping
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendUpdatedCategoryToLocal($arrReq)
    {

        $varTbl = TABLE_UPDATE_CATEGORY_ATTR_SHIPPING;
        $arrClms = array('id', 'name');
        $varWhr = " action='edit' AND type='category'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);
        if (count($arrRes) > 0)
        {

            foreach ($arrRes as $key => $v)
            {
                $arrClmsCat = array(
                    'pkCategoryId',
                    'CategoryParentId',
                    'CategoryName',
                    'CategoryLevel',
                    'CategoryDescription',
                    'CategoryOrdering',
                    'CategoryHierarchy',
                    'CategoryMetaTitle',
                    'CategoryMetaKeywords',
                    'CategoryMetaDescription',
                    'CategoryStatus',
                    'CategoryIsDeleted',
                    'CategoryDateAdded',
                    'CategoryDateModified'
                );
                $varTblCat = TABLE_CATEGORY;
                $varWhrCat = "pkCategoryId='" . $v['id'] . "'";
                $arrRes1 = $this->select($varTblCat, $arrClmsCat, $varWhrCat);
            }
        }
        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes1;
    }

    /**
     * function sendUpdatedCategoryToLocal
     *
     * This function is used to get newely updated category, from live.
     *
     * Database Tables used in this function are : updateCategoryAttrShipping
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendDeleteCategoryToLocal($arrReq)
    {

        $varTbl = TABLE_UPDATE_CATEGORY_ATTR_SHIPPING;
        $arrClms = array('id', 'name');
        $varWhr = " action='delete' AND type='category'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);
        if (count($arrRes) > 0)
        {

            foreach ($arrRes as $key => $v)
            {
                $arrClmsCat = array(
                    'pkCategoryId',
                    'CategoryIsDeleted',
                    'CategoryDateModified'
                );
                $varTblCat = TABLE_CATEGORY;
                $varWhrCat = "pkCategoryId='" . $v['id'] . "'";
                $arrRes1 = $this->select($varTblCat, $arrClmsCat, $varWhrCat);
            }
        }
        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes1;
    }

    /**
     * function sendAddAttributeToLocal
     *
     * This function is used to get newely added category, from live.
     *
     * Database Tables used in this function are : updateCategoryAttrShipping
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendAddAttributeToLocal($arrReq)
    {

        $varTbl = TABLE_UPDATE_CATEGORY_ATTR_SHIPPING;
        $arrClms = array('id', 'name');
        $varWhr = "action='add' AND type='attribute'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrRes) > 0)
        {

            foreach ($arrRes as $key => $v)
            {
                $varTblAttr = TABLE_ATTRIBUTE;

                $arrClmsAttr = array(
                    'pkAttributeID',
                    'AttributeCode',
                    'AttributeLabel',
                    'AttributeDesc',
                    'AttributeOrdering',
                    'AttributeVisible',
                    'AttributeSearchable',
                    'AttributeComparable',
                    'AttributeInputType',
                    'AttributeValidation',
                    'AttributeDateAdded'
                );
                $varWhrAttr = "pkAttributeID='" . $v['id'] . "'";
                $arrRes1 = $this->select($varTblAttr, $arrClmsAttr, $varWhrAttr);
            }
        }

        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes1;
    }

    /**
     * function sendUpdatedAttributeToLocal
     *
     * This function is used to get newely added category, from live.
     *
     * Database Tables used in this function are : updateCategoryAttrShipping
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendUpdatedAttributeToLocal($arrReq)
    {

        $varTbl = TABLE_UPDATE_CATEGORY_ATTR_SHIPPING;
        $arrClms = array('id', 'name');
        $varWhr = "action='edit' AND type='attribute'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrRes) > 0)
        {

            foreach ($arrRes as $key => $v)
            {
                $varTblAttr = TABLE_ATTRIBUTE;

                $arrClmsAttr = array(
                    'pkAttributeID',
                    'AttributeCode',
                    'AttributeLabel',
                    'AttributeDesc',
                    'AttributeOrdering',
                    'AttributeVisible',
                    'AttributeSearchable',
                    'AttributeComparable',
                    'AttributeInputType',
                    'AttributeValidation',
                    'AttributeDateAdded'
                );
                $varWhrAttr = "pkAttributeID='" . $v['id'] . "'";
                $arrRes1 = $this->select($varTblAttr, $arrClmsAttr, $varWhrAttr);
            }
        }

        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes1;
    }

    /**
     * function sendDeleteAttributeToLocal
     *
     * This function is used to get newely deleted attribute, from live.
     *
     * Database Tables used in this function are : updateCategoryAttrShipping
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendDeleteAttributeToLocal($arrReq)
    {

        $varTbl = TABLE_UPDATE_CATEGORY_ATTR_SHIPPING;
        $arrClms = array('id', 'name');
        $varWhr = "action='delete' AND type='attribute'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrRes) > 0)
        {

            foreach ($arrRes as $key => $v)
            {
                $varTblAttr = TABLE_ATTRIBUTE;

                $arrClmsAttr = array(
                    'pkAttributeID'
                );
                $varWhrAttr = "pkAttributeID='" . $v['id'] . "'";
                $arrRes1 = $this->select($varTblAttr, $arrClmsAttr, $varWhrAttr);
            }
        }

        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes1;
    }

    /**
     * function sendAddShippingToLocal
     *
     * This function is used to get newely added shipping geteway, from live.
     *
     * Database Tables used in this function are : updateCategoryAttrShipping
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendAddShippingToLocal($arrReq)
    {

        $varTbl = TABLE_UPDATE_CATEGORY_ATTR_SHIPPING;
        $arrClms = array('id', 'name');
        $varWhr = "action='add' AND type='shipping'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrRes) > 0)
        {

            foreach ($arrRes as $key => $v)
            {


                $varTblShip = TABLE_SHIPPING_GATEWAYS;

                $arrClmsShip = array(
                    'pkShippingGatewaysID',
                    'ShippingType',
                    'ShippingTitle',
                    'ShippingAlias',
                    'ShippingStatus',
                    'ShippingDateAdded'
                );
                $varWhrShip = "pkShippingGatewaysID='" . $v['id'] . "'";
                $arrRes1 = $this->select($varTblShip, $arrClmsShip, $varWhrShip);
            }
        }

        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes1;
    }

    /**
     * function sendUpdatedShippingToLocal
     *
     * This function is used to get newely updated shipping geteway, from live.
     *
     * Database Tables used in this function are : updateCategoryAttrShipping
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendUpdatedShippingToLocal($arrReq)
    {

        $varTbl = TABLE_UPDATE_CATEGORY_ATTR_SHIPPING;
        $arrClms = array('id', 'name');
        $varWhr = "action='edit' AND type='shipping'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrRes) > 0)
        {

            foreach ($arrRes as $key => $v)
            {
                $varTblShip = TABLE_SHIPPING_GATEWAYS;

                $arrClmsShip = array(
                    'pkShippingGatewaysID',
                    'ShippingType',
                    'ShippingTitle',
                    'ShippingAlias',
                    'ShippingStatus',
                    'ShippingDateAdded'
                );
                $varWhrShip = "pkShippingGatewaysID='" . $v['id'] . "'";
                $arrRes1 = $this->select($varTblShip, $arrClmsShip, $varWhrShip);
            }
        }

        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes1;
    }

    /**
     * function sendDeleteShippingToLocal
     *
     * This function is used to get newely deleted shipping geteway, from live.
     *
     * Database Tables used in this function are : updateCategoryAttrShipping
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendDeleteShippingToLocal($arrReq)
    {

        $varTbl = TABLE_UPDATE_CATEGORY_ATTR_SHIPPING;
        $arrClms = array('id', 'name');
        $varWhr = "action='delete' AND type='shipping'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrRes) > 0)
        {

            foreach ($arrRes as $key => $v)
            {
                $varTblShip = TABLE_SHIPPING_GATEWAYS;

                $arrClmsShip = array(
                    'pkShippingGatewaysID'
                );
                $varWhrShip = "pkShippingGatewaysID='" . $v['id'] . "'";
                $arrRes1 = $this->select($varTblShip, $arrClmsShip, $varWhrShip);
            }
        }

        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes1;
    }

    /**
     * function sendUpdatedMarginCostToLocal
     *
     * This function is used to get newely deleted shipping geteway, from live.
     *
     * Database Tables used in this function are : updateCategoryAttrShipping
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendUpdatedMarginCostToLocal($arrReq)
    {

        $varTbl = TABLE_UPDATE_CATEGORY_ATTR_SHIPPING;
        $arrClms = array('id', 'name');
        $varWhr = "action='edit' AND type='shippingcost'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);

        if (count($arrRes) > 0)
        {

            foreach ($arrRes as $key => $v)
            {
                $varTblShip = TABLE_DEFAULT_COMMISSION;

                $arrClmsShip = array(
                    'pkCommissionID',
                    'MarginCast'
                );
                $varWhrShip = "pkCommissionID='" . $v['id'] . "'";
                $arrRes1 = $this->select($varTblShip, $arrClmsShip, $varWhrShip);
            }
        }

        //$varAffected2 = $this->delete($varTbl,$varWhr);
        return $arrRes1;
    }

    /**
     * function sendLiveAddproductToAttributeOptionsQtyLocalId
     *
     * This function is used to add attribute quantity local to live database.
     *
     * Database Tables used in this function are : tbl_product_option_inventory, tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function sendLiveAddproductToAttributeOptionsQtyLocalId($arrReq)
    {
        global $objCore;
        //pre($arrReq);
        if (!empty($arrReq['data']))
        {


            $varTbl = TABLE_PRODUCT_OPTION_INVENTORY;
            foreach ($arrReq['data'] as $key => $value)
            {
                $num = 1;

                $varWhr = "fkProductID = '" . $value['liveID'] . "'";

                $this->delete(TABLE_PRODUCT_OPTION_INVENTORY, $varWhr);
                $qty = 0;
                // pre($arrReq);
                foreach ($value['frmOptIds'] as $key => $val)
                {
                    $tempArr = explode(',', $val);
                    sort($tempArr);

                    $optIds = implode(',', $tempArr);

                    $qty +=$val['frmQuantity'];

                    $arrClms = array(
                        'fkProductID' => $value['pid'],
                        'OptionIDs' => $val['OptionIDs'],
                        'OptionQuantity' => $val['frmQuantity']
                    );
                    $varUpdate = $this->insert(TABLE_PRODUCT_OPTION_INVENTORY, $arrClms);
                    $num +=$varUpdate;
                }
                $arrClms = array(
                    'Quantity' => $qty
                    //'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                );

                $varWhr = "pkProductID = '" . $value['liveID'] . "'";
                $this->update(TABLE_PRODUCT, $arrClms, $varWhr);

                $productOfflineID = $this->select(TABLE_PRODUCT, array('productOfflineID'), $varWhr);
                return $productOfflineID;
            }
        }
    }

    /**
     * function sendLiveAddproductToAttributeOptionsPriceLocalId
     *
     * This function is used to add attribute price local to live database.
     *
     * Database Tables used in this function are : tbl_product_option_inventory, tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function sendLiveAddproductToAttributeOptionsPriceLocalId($arrReq)
    {
        global $objCore;

        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PRODUCT_TO_OPTION;
            foreach ($arrReq['data'] as $key => $value)
            {
                $num = 1;

                foreach ($value['frmPrice'] as $key => $val)
                {
                    $default = $value['default_' . $key];


                    $def = ($default == $val['pkProductAttributeId']) ? 1 : 0;

                    $varWhr = "pkProductAttributeId = '" . $val['pkProductAttributeId'] . "'";

                    $arrClms = array(
                        'OptionExtraPrice' => $val['OptionExtraPrice'],
                        'OptionIsDefault' => $def
                    );

                    $varUpdate = $this->update(TABLE_PRODUCT_TO_OPTION, $arrClms, $varWhr);
                    $num +=$varUpdate;
                }
                $arrClmsUpdate = array(
                    'ProductDateUpdated' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                );

                $varWhrUpdate = "pkProductID = '" . $value['liveID'] . "'";
                //$this->update(TABLE_PRODUCT, $arrClmsUpdate, $varWhrUpdate);

                $productOfflineID = $this->select(TABLE_PRODUCT, array('productOfflineID'), $varWhrUpdate);
                
            }
            return $productOfflineID;
        }
    }

    /**
     * function productToAttributeOptionsQty
     *
     * This function is used to display Product To Options.
     *
     * Database Tables used in this function are : tbl_product_option_inventory, tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function productToAttributeOptionsQty($argpid, $wid)
    {
        $varSql = "SELECT pkInventryID,fkProductID,OptionIDs,OptionQuantity FROM " . TABLE_PRODUCT_OPTION_INVENTORY . " LEFT JOIN " . TABLE_PRODUCT . " ON fkProductID=pkProductID WHERE fkProductID = '" . $argpid . "' AND fkWholesalerID='" . $wid . "'";
        $arrRes = $this->getArrayResult($varSql);
        $arrRows = array();
//        foreach ($arrRes as $key => $val)
//        {
//            $arrRows[$val['OptionIDs']] = $val['OptionQuantity'];
//        }
        //pre($arrRows);
        return $arrRes;
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
    function getAttrOptions($argpid, $argaid)
    {
        $varSql = "SELECT pkProductAttributeId,fkAttributeOptionId,OptionExtraPrice,OptionIsDefault,AttributeOptionValue FROM " . TABLE_PRODUCT_TO_OPTION . " WHERE  fkAttributeId = '" . $argaid . "' AND fkProductId = '" . $argpid . "' ";
        $arrRes = $this->getArrayResult($varSql);
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
    function productToAttributeOptions($argpid, $wid)
    {
        $varSql = "SELECT pkAttributeID,AttributeCode,AttributeLabel,AttributeInputType FROM " . TABLE_ATTRIBUTE . " INNER JOIN " . TABLE_PRODUCT_TO_OPTION . " ON (fkAttributeId = pkAttributeID AND fkProductId = '" . $argpid . "') GROUP BY fkAttributeId";
        $arrRes = $this->getArrayResult($varSql);
        //$arrInputType = array('radio', 'image', 'checkbox', 'select');
        $arrRows = array();

        // $arrInputType = array('radio', 'image', 'checkbox', 'select');
        $i = 0;
        foreach ($arrRes as $key => $val)
        {

            $arrRows[$i]['options'] = $this->getAttrOptions($argpid, $val['pkAttributeID']);
            $i++;
        }
        //pre($arrRows);
        return $arrRows;
    }

    /**
     *
     *  Function Name: combineAttributesOptions()
     *
     *  Return type: array
     *
     *  Date created: 06 Nov 2013
     *
     *  Date last modified: 06 Nov 2013
     *
     *  Author: Prashant Kumar
     *
     *  Last modified by: Shardendu Singh
     *
     *  Comments: Function will replace all the special characters into unicode to store into database, so that it can displayed on browser propely.
     *
     *  User instruction: $objCore->combineAttributesOptions($argVarInputString)
     *
     */
    function combineAttributesOptions($arrAttrOpt)
    {
        $varAttrNum = count($arrAttrOpt);
        // pre($arrAttrOpt);
        $groups = array();

        foreach ($arrAttrOpt as $key => $val)
        {
            foreach ($val['options'] as $kk => $vv)
            {
                if ($val['AttributeInputType'] == 'checkbox')
                {
                    //$arrCheckBoxAttr[$val['pkAttributeID']][$kk] = $vv['fkAttributeOptionId'];
                    $arrCheckBoxAttr[] = $vv['fkAttributeOptionId'];
                }
                else
                {
                    $groups[$val['pkAttributeID']][$kk] = $vv['fkAttributeOptionId'];
                }
                $arrOptions[$vv['fkAttributeOptionId']] = $vv['AttributeOptionValue'];
            }
        }


        $arrCombineCheckBox = $this->combineCheckBoxOption($arrCheckBoxAttr);
        //pre($arrCombineCheckBox);
        $arrCombineOption = $this->combineOptions($groups, '');
        //pre($arrCombineOption);

        $i = 0;
        foreach ($arrCombineOption as $k => $v)
        {
            $str = array();
            foreach ($arrCombineCheckBox as $ck => $cv)
            {
                //  pre($cv);
                $str[] = $cv;
                $opt = $v . ',' . $cv;
                $arrCombineOption[$i] = trim($opt, ',');
                $i++;
            }
        }
        //pre($arrCombineOption);

        foreach ($arrCombineOption as $k => $v)
        {
            $tempArr = explode(',', $v);
            $arrOptVals = array();
            foreach ($tempArr as $kT => $vT)
            {
                $arrOptVals[] = $arrOptions[$vT];
            }

            $optVals = implode(',', $arrOptVals);
            sort($tempArr);
            $optIds = implode(',', $tempArr);
            $arrCombineOpt[$k]['fkAttributeOptionId'] = $optIds;
            $arrCombineOpt[$k]['AttributeOptionValue'] = $optVals;
        }

        //pre($arrCombineOpt);
        return $arrCombineOpt;
    }

    /**
     * function sendLocalAddproductToAttributeOptionsQtyLive
     *
     * This function is used to add attribute quantity local to live database.
     *
     * Database Tables used in this function are : tbl_product_option_inventory, tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function sendLocalAddproductToAttributeOptionsQtyLive($arrReq)
    {
        global $objCore;
        //pre($arrReq);
        $varWhr = "productLastSyncDateTime < ProductDateUpdated and fkWholesalerID='" . $this->wholesalerID . "'";
        $arrClms = array('pkProductID');
        $varProducts = $this->select(TABLE_PRODUCT, $arrClms, $varWhr);

        if (count($varProducts) > 0)
        {
            // $arrAttrOptQty=array();
            foreach ($varProducts as $val)
            {
                $pid = $val['pkProductID'];
                $wid = $this->wholesalerID;
                $arrAttrOptQty = $this->productToAttributeOptionsQty($pid, $wid);
                if (count($arrAttrOptQty) > 0)
                {
                    $arrAttrOptQtyToLocal[] = $arrAttrOptQty;
                }
            }
            //$returnData=array();
            foreach ($arrAttrOptQtyToLocal as $key => $v)
            {
                foreach ($v as $s)
                {
                    $returnData[] = $s;
                }
            }
            //pre(serialize($returnData));
            return $returnData;
        }
    }

    /**
     * function sendLiveAttributeOptionsQtySyncSucc
     *
     * This function is used to update productLastSyncDateTime time.
     *
     * Database Tables used in this function are : TABLE_PRODUCT
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function sendLiveAttributeOptionsQtySyncSucc($arrReq)
    {
        global $objCore;
        if (!empty($arrReq['data']))
        {


            $varTbl = TABLE_PRODUCT;
            foreach ($arrReq['data'] as $key => $value)
            {
                $num = 1;

                $arrClmsUpdate = array(
                    'pkProductID' => $value['liveID'],
                    'productOfflineID' => $value['productOfflineID'],
                    'productLastSyncDateTime' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                );

                $varWhrUpdate = "pkProductID = '" . $value['liveID'] . "'";
                $productUpdate = $this->update(TABLE_PRODUCT, $arrClmsUpdate, $varWhrUpdate);
                return $productUpdate;
            }
        }
    }

    /**
     * function sendLocalAddproductToAttributeOptionsPriceLive
     *
     * This function is used to add attribute price local to live database.
     *
     * Database Tables used in this function are : tbl_product_option_inventory, tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objProduct->ProductToOptions($argpid) 
     */
    function sendLocalAddproductToAttributeOptionsPriceLive($arrReq)
    {
        global $objCore;
        // pre($arrReq);
        $varWhr = "productLastSyncDateTime < ProductDateUpdated and fkWholesalerID='" . $this->wholesalerID . "'";
        $arrClms = array('pkProductID');
        $varProducts = $this->select(TABLE_PRODUCT, $arrClms, $varWhr);

        if (count($varProducts) > 0)
        {
            //below code return attribute details for product.
            foreach ($varProducts as $val)
            {
                $pid = $val['pkProductID'];
                $wid = $this->wholesalerID;
                $arrAttrOptQty = $this->productToAttributeOptions($pid);
                if (count($arrAttrOptQty) > 0)
                {
                    $arrAttrOptPriceToLocal[] = $arrAttrOptQty;
                }
            }
            //below code return extra price with for product.
            foreach ($arrAttrOptPriceToLocal as $key => $v)
            {
                foreach ($v as $s)
                {
                    foreach ($s as $t)
                    {
                        foreach ($t as $y)
                        {
                            $returnData[] = $y;
                        }
                    }
                }
            }
            //pre(serialize($returnData));
            return $returnData;
        }
    }

    /**
     * function getShippingToWholesaler
     *
     * This function is used to get all shipping to wholesaler.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function getShippingToWholesaler($arrReq)
    {

        $varTbl = TABLE_WHOLESALER_TO_SHIPPING_GATEWAY;
        $wid = $this->wholesalerID;
        $arrClms = array(
            'fkWholesalerID',
            'fkShippingGatewaysID');
        $varWhr = "fkWholesalerID = '" . $wid . "'";
        $arrRes = $this->select($varTbl, $arrClms, $varWhr);
        return $arrRes;
    }

    /**
     * function updateProductOptionImage
     *
     * This function is used to get all updated attribute option image  to local.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function updateProductOptionImage($arrReq)
    {
        global $objCore, $arrProductImageResizes;
        $varTbl = TABLE_PRODUCT . " LEFT JOIN tbl_product_to_option opt ON opt.fkProductId = pkProductID";
        $arrClms = array('AttributeOptionImage');
        //$varWhr = "";
        $varWhr = "fkWholesalerID='" . $this->wholesalerID . "' AND productOfflineID > 0  AND productLastSyncDateTime < ProductDateUpdated";
        $varOrderBy = "ProductDateUpdated DESC";
        //$varLimit = "10 ";

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        // echo '<pre>';print_r($arrRes);die;
        //pre($arrRes);
        $i = 0;
        $pkImageIDs = '';
        foreach ($arrRes as $resultKey => $resultVal)
        {
            // echo UPLOADED_FILES_SOURCE_PATH . "images/products/" . $arrProductImageResizes['detailHover'] . "/" . $resultVal['ImageName'];
            if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/products/" . $arrProductImageResizes['detailHover'] . "/" . $resultVal['AttributeOptionImage']) && $resultVal['AttributeOptionImage'] != '')
            {
                $pathAttr = $objCore->getImageUrl($resultVal['AttributeOptionImage'], 'products/' . $arrProductImageResizes['detailHover']);
                $typeAttr = pathinfo($pathAttr, PATHINFO_EXTENSION);
                $dataAttr = file_get_contents($pathAttr);
                $base64Attr = base64_encode($dataAttr);
                $arrRet[$i]['optionImage'] = $resultVal['AttributeOptionImage'] != "" ? $resultVal['AttributeOptionImage'] : 'noimage';
                $arrRet[$i]['ImgStringOptionImage'] = $base64Attr;
                $i++;
            }
        }
        //pre($arrRet);
        //pre($arrRet);
        return $arrRet;
    }

    /**
     * function sendLiveToVerifiedReferenceNo
     *
     * This function is used to Verified Reference No to local.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 $arrReq
     *
     * @return array $arrRes
     */
    public function sendLiveToVerifiedReferenceNo($arrReq)
    {

        if (!empty($arrReq['data']))
        {
            $varTbl = TABLE_PRODUCT;
            foreach ($arrReq['data'] as $key => $value)
            {
                $varWhr = "ProductRefNo = '" . $value['ProductRefNo'] . "'";
                $arrClms = array('pkProductID');
                $arrRes = $this->select($varTbl, $arrClms, $varWhr);
            }
            if (count($arrRes) > 0)
            {
                return 1;
            }
            else
            {
                return 0;
            }
            //return $arrRes;
        }
    }

}

?>
