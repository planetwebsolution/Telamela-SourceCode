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
class APIProcessor extends Database {

    /**
     * Constructor sets up
     */
    public function __construct() {
        
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
    public function quoteSlashes($value) {
        $value = addslashes($value);

        return $value;
    }

    /**
     * function getAllProduct
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
    public function getProducts($arrReq) {

        $varTbl = TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON (fkCategoryID = pkCategoryId AND CategoryStatus='1' AND CategoryIsDeleted = '0') INNER JOIN " . TABLE_WHOLESALER . " ON (fkWholesalerID = pkWholesalerID AND WholesalerStatus = 'active')";

        $arrClms = array(
            'pkProductID',
            'fkCategoryID',
            'CategoryName',
            'fkWholesalerID',
            'CompanyName',
            'ProductRefNo',
            'ProductName',
            'FinalPrice',
            'DiscountFinalPrice',
            'Quantity',
            'ProductImage'
        );

        $varWhr = "ProductStatus='1' ";

        if (isset($arrReq['search'])) {
            
            $custom = "";
            if (isset($arrReq['search']['custom'])) {
                $custom = $this->quoteSlashes($arrReq['search']['custom']);
                unset($arrReq['search']['custom']);
            }
            
            
            
            foreach ($arrReq['search'] as $k => $v) {
                $varWhr .= " AND " . $this->quoteSlashes($k) . " = '" . $this->quoteSlashes($v) . "' ";
            }
            
            if ($custom) {
                $varWhr .= " AND (" . $custom . ") ";
            }
        }

        $varOrderBy = "";
        if (isset($arrReq['order'])) {
            foreach ($arrReq['order'] as $k => $v) {
                $varOrderBy .= ($varOrderBy == "") ? "" : ", ";
                $varOrderBy .= $this->quoteSlashes($k) . " " . $this->quoteSlashes($v) . " ";
            }
        } else {
            $varOrderBy = "pkProductID ASC ";
        }


        $varLimit = "";
        if (isset($arrReq['limit'])) {
            if (isset($arrReq['limit']['offset']) && isset($arrReq['limit']['rows'])) {
                $varLimit = (int) $this->quoteSlashes($arrReq['limit']['offset']) . ", " . (int) $this->quoteSlashes($arrReq['limit']['rows']);
            }
        }


        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

    /**
     * function getAllProduct
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
    public function getCategories($arrReq) {

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

        if (isset($arrReq['search'])) {

            $custom = "";
            if (isset($arrReq['search']['custom'])) {
                $custom = $this->quoteSlashes($arrReq['search']['custom']);
                unset($arrReq['search']['custom']);
            }

            foreach ($arrReq['search'] as $k => $v) {
                $varWhr .= " AND " . $this->quoteSlashes($k) . " = '" . $this->quoteSlashes($v) . "' ";
            }

            if ($custom) {
                $varWhr .= " AND (" . $custom . ") ";
            }
        }

        $varOrderBy = "";

        if (isset($arrReq['order'])) {
            foreach ($arrReq['order'] as $k => $v) {
                $varOrderBy .= ($varOrderBy == "") ? "" : ", ";
                $varOrderBy .= $this->quoteSlashes($k) . " " . $this->quoteSlashes($v) . " ";
            }
        } else {
            $varOrderBy = "CategoryName ASC ";
        }

        $varLimit = "";
        if (isset($arrReq['limit'])) {
            if (isset($arrReq['limit']['offset']) && isset($arrReq['limit']['rows'])) {
                $varLimit = (int) $this->quoteSlashes($arrReq['limit']['offset']) . ", " . (int) $this->quoteSlashes($arrReq['limit']['rows']);
            }
        }

        $arrRes = $this->select($varTbl, $arrClms, $varWhr, $varOrderBy, $varLimit);
        return $arrRes;
    }

}

?>