<?php

/**
 *
 * Class name : Package
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The Package class is used to maintain Package infomation details for several modules.
 */
class Package extends Database {

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
     * function WholesalerList
     *
     * This function is used to display the Wholesaler List.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objPackage->WholesalerList($varPortalFilter)
     */
    function WholesalerList($varPortalFilter) {
        $arrClms = array(
            'pkWholesalerID',
            'CompanyName',
        );
        $argWhere = "WholesalerStatus IN ('active','deactive','suspend') " . $varPortalFilter;
        $varOrderBy = ' CompanyName ASC ';

        $varTable = TABLE_WHOLESALER;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function packageList
     *
     * This function is used to display the package List.
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package, tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objPackage->packageList($argWhere = '', $argLimit = '')
     */
    function packageList($argWhere = '', $argLimit = '') {
        $varLimit = ($argLimit <> '') ? 'LIMIT ' . $argLimit : '';
        $varWhere = ($argWhere <> '') ? 'WHERE ' . $argWhere : '';
        $this->getSortColumn($_REQUEST);
        $varQuery = 'SELECT pkg.pkPackageId,pkg.PackageName,pkg.PackagePrice,pkg.PackageStatus,GROUP_CONCAT(ProductName SEPARATOR ", ") as ProductName,sum(FinalPrice) as FinalPrice FROM ' . TABLE_PACKAGE . ' as pkg LEFT JOIN ' . TABLE_PRODUCT_TO_PACKAGE . ' as ptp ON pkg.pkPackageId=ptp.fkPackageId LEFT JOIN ' . TABLE_PRODUCT . ' as pro on fkProductId = pkProductID ' . $varWhere . ' GROUP BY
        pkPackageId DESC order by ' . $this->orderOptions . ' ' . $varLimit;
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function addPackage
     *
     * This function is used to add the package.
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objPackage->addPackage($arrPost)
     */
    function addPackage($arrPost) {

        $objClassCommon = new ClassCommon();
        $varPackageACPrice = $objClassCommon->getAcCostForPackage($arrPost['frmOfferPrice']);

        $arrClms = array(
            'fkWholesalerID' => $arrPost['frmWholesalerId'],
            'PackageName' => $arrPost['frmPackageName'],
            'PackageACPrice' => $varPackageACPrice,
            'PackagePrice' => $arrPost['frmOfferPrice'],
            'PackageImage' => $arrPost['PackageImage'],
            'PackageDateAdded' => date(DATE_TIME_FORMAT_DB)
        );


        $arrAddID = $this->insert(TABLE_PACKAGE, $arrClms);

        if ($arrAddID > 0) {
            foreach ($arrPost['frmProductId'] as $val) {
                $arrClmsPro = array(
                    'fkPackageId' => $arrAddID,
                    'fkProductId' => $val
                );

                /**
                 * This query is used update package id for mantioned products in package in product table.
                 *
                 * @author : Krishna Gupta
                 *
                 * @Created : 06-11-2015
                 */
                $includedInAnyPackage = $this->getArrayResult("select fkPackageId from tbl_product where pkProductID=" . $arrClmsPro['fkProductId'] . "");
                if (empty($includedInAnyPackage[0]['fkPackageId']) || ($includedInAnyPackage[0]['fkPackageId'] == 0)) {
                    $query = mysql_query("Update tbl_product set fkPackageId=" . $arrClmsPro['fkPackageId'] . " where pkProductID=" . $arrClmsPro['fkProductId'] . "");
                } else {
                    $packageId = $includedInAnyPackage[0]['fkPackageId'] . ',' . $arrClmsPro['fkPackageId'];
                    $query = mysql_query("Update tbl_product set fkPackageId=" . "'" . $packageId . "'" . " where pkProductID=" . $arrClmsPro['fkProductId'] . "");
                }
                /* Ends */

                $this->insert(TABLE_PRODUCT_TO_PACKAGE, $arrClmsPro);
            }
        }
        return $arrAddID;
    }

    /**
     * function editPackage
     *
     * This function is used to add the package.
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package, tbl_product, tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objPackage->addPackage($arrPost)
     */
    function editPackage($argPkgID, $varPortalFilter) {
        $varWhr = 'pkPackageId =' . $argPkgID . $varPortalFilter;
        $arrClms = array('pkPackageId', 'fkWholesalerID', 'PackageName', 'PackagePrice', 'PackageImage');
        $arrPackage = $this->select(TABLE_PACKAGE, $arrClms, $varWhr);

        $varWhrTo = 'ptp.fkPackageId =' . $argPkgID;
        $varTable = TABLE_PRODUCT_TO_PACKAGE . ' as ptp INNER JOIN ' . TABLE_PRODUCT . ' as p ON ptp.fkProductId=p.pkProductID INNER JOIN ' . TABLE_CATEGORY . ' ON fkCategoryID = pkCategoryId ';

        $arrClmsTo = array('fkProductId', 'fkCategoryID', 'fkWholesalerID');
        $arrRowTo = $this->select($varTable, $arrClmsTo, $varWhrTo);
        foreach ($arrRowTo as $k => $val) {
            $varWhrPro = 'fkCategoryID =' . $val['fkCategoryID'] . ' AND ProductStatus = 1 AND fkWholesalerID = "' . $val['fkWholesalerID'] . '"';
            $arrClmsPro = array('pkProductID', 'ProductName', 'FinalPrice');
            $arrRowTo[$k]['ProductList'] = $this->select(TABLE_PRODUCT, $arrClmsPro, $varWhrPro);
        }
        $arrRow['Package'] = $arrPackage;
        $arrRow['PackageToProduct'] = $arrRowTo;
        return $arrRow;
    }

    /**
     * function updatePackage
     *
     * This function is used to update the package.
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return 1
     *
     * User instruction: $objPackage->addPackage($arrPost)
     */
    function updatePackage($arrPost) {
        //echo '<pre>'; print_r($arrPost); die;
        /**
         * Update package id for already existing product for that perticular package
         *
         * @author : Krishna Gupta
         *
         * @Created : 06-11-2015
         */
        $col = 'fkPackageId';
        $checkExistacyOfPackage = mysql_query("select pkProductID, fkPackageId from tbl_product where find_in_set (" . $_GET['pkgid'] . ' , ' . $col . ")");


        $updatedPackages = '';
        while ($result = mysql_fetch_assoc($checkExistacyOfPackage)) {
            $alreadyExistingProducts[] = $result['pkProductID'];

            /* Condition if product is existing in updated package then no need to update anything. */
            if (in_array($result['pkProductID'], $arrPost['frmProductId'])) {
                $query = mysql_query("Update tbl_product set fkPackageId = " . "'" . $updatedPackage . "'" . " where pkProductID=" . $result['pkProductID'] . "");
            }
            /* Condition if product is not existing ( removed after updation ) in updated package */ else {
                /* Make an array of packages for that particular removed product from package */
                $package = explode(',', $result['fkPackageId']);
                foreach ($package as $packages) {
                    $updatedPackages = 'NA';
                    /* If package id is not equals to updated package. */
                    if ($packages != $arrPost['pkid']) {
                        $updatedPackages .= $packages . ',';
                    }
                }

                /* Update data into db */
                if (isset($updatedPackages) && !empty($updatedPackages)) {
                    if ($updatedPackages == 'NA') {
                        $updatedPackage = '';
                        $query = mysql_query("Update tbl_product set fkPackageId = " . "'" . $updatedPackage . "'" . " where pkProductID=" . $result['pkProductID'] . "");
                    } else {
                        $updatedPackage = rtrim($updatedPackages, ',');
                        $query = mysql_query("Update tbl_product set fkPackageId = " . "'" . $updatedPackage . "'" . " where pkProductID=" . $result['pkProductID'] . "");
                    }
                }
            }
        }

        foreach ($arrPost['frmProductId'] as $newproducts) {
            /* Condition if updated package product's are already existing ( not changed ) then no need to update anything. */
            if (in_array($newproducts, $alreadyExistingProducts)) {
                //$query=mysql_query("Update tbl_product set fkPackageId = " ."'". $updatedPackage ."'". " where pkProductID=".$newproducts."");
            }
            /* If some new products are added or replaced in package then update values. */ else {
                $newProductsPackage = mysql_query("select fkPackageId from tbl_product where pkProductID = " . $newproducts . "");
                $result = mysql_fetch_assoc($newProductsPackage);
                $updatedPackageIds = $result['fkPackageId'] . ',' . $_GET['pkgid'];
                $query = mysql_query("Update tbl_product set fkPackageId = " . "'" . $updatedPackageIds . "'" . " where pkProductID=" . $newproducts . "");
            }
        }
        /* Ends */



        $varWhr = 'pkPackageId = ' . $_GET['pkgid'];

        $objClassCommon = new ClassCommon();
        $varPackageACPrice = $objClassCommon->getAcCostForPackage($arrPost['frmOfferPrice']);

        $arrClms = array(
            'fkWholesalerID' => $arrPost['frmWholesalerId'],
            'PackageName' => $arrPost['frmPackageName'],
            'PackageACPrice' => $varPackageACPrice,
            'PackagePrice' => $arrPost['frmOfferPrice'],
            'PackageImage' => $arrPost['PackageImage'],
            'imgSync' => '0',
            'packageDateUpdated' => date(DATE_TIME_FORMAT_DB)
        );

        $arrUpdateID = $this->update(TABLE_PACKAGE, $arrClms, $varWhr);

        $varWheresD = "fkPackageId = " . $_GET['pkgid'] . " ";
        $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWheresD);

        foreach ($arrPost['frmProductId'] as $val) {
            $arrClmsPro = array(
                'fkPackageId' => $_GET['pkgid'],
                'fkProductId' => $val
            );


            /**
             * This query is used update package id for mantioned products in package in product table.
             *
             * @author : Krishna Gupta
             *
             * @Created : 06-11-2015
             */
            $includedInAnyPackage = $this->getArrayResult("select fkPackageId from tbl_product where pkProductID=" . $arrClmsPro['fkProductId'] . "");

            if ($includedInAnyPackage[0]['fkPackageId'] == 0) {

                $query = mysql_query("Update tbl_product set fkPackageId=" . $arrClmsPro['fkPackageId'] . " where pkProductID=" . $arrClmsPro['fkProductId'] . "");
            } else {
                $packageId = $includedInAnyPackage[0]['fkPackageId'] . ',' . $arrClmsPro['fkPackageId'];
                $query = mysql_query("Update tbl_product set fkPackageId=" . "'" . $packageId . "'" . " where pkProductID=" . $arrClmsPro['fkProductId'] . "");
            }
            /* Ends */

            $this->insert(TABLE_PRODUCT_TO_PACKAGE, $arrClmsPro);
        }
        return 1;
    }

    /* function updatePackage($arrPost) {

      $varWhr = 'pkPackageId = ' . $_GET['pkgid'];

      $objClassCommon = new ClassCommon();
      $varPackageACPrice = $objClassCommon->getAcCostForPackage($arrPost['frmOfferPrice']);

      $arrClms = array(
      'fkWholesalerID' => $arrPost['frmWholesalerId'],
      'PackageName' => $arrPost['frmPackageName'],
      'PackageACPrice' => $varPackageACPrice,
      'PackagePrice' => $arrPost['frmOfferPrice'],
      'PackageImage' => $arrPost['PackageImage'],
      'imgSync' => '0',
      'packageDateUpdated'=>date(DATE_TIME_FORMAT_DB)
      );

      $arrUpdateID = $this->update(TABLE_PACKAGE, $arrClms, $varWhr);

      $varWheresD = "fkPackageId = " . $_GET['pkgid'] . " ";
      $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWheresD);

      foreach ($arrPost['frmProductId'] as $val) {
      $arrClmsPro = array(
      'fkPackageId' => $_GET['pkgid'],
      'fkProductId' => $val
      );
      $this->insert(TABLE_PRODUCT_TO_PACKAGE, $arrClmsPro);
      }
      return 1;
      } */

    /**
     * function removePackage
     *
     * This function is used to remove the package.
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $ctr
     *
     * User instruction: $objPackage->removePackage($argPostIDs, $varPortalFilter)
     */
    function removePackage($argPostIDs, $varPortalFilter) {
        //pre($argPostIDs);
        /* To remove deleted package id from that products by Krishna Gupta (06-11-2015) starts */
        foreach ($argPostIDs['frmID'] as $value) {
            $productsIncludedInPackage = $this->getArrayResult("select fkProductId from tbl_product_to_package where fkPackageId=" . $value . "");
            //pre($productsIncludedInPackage);
            foreach ($productsIncludedInPackage as $val) {
                $data = $this->getArrayResult("select fkPackageId from tbl_product where pkProductID=" . $val['fkProductId'] . "");
                $packages = explode(',', $data[0]['fkPackageId']);
                foreach ($packages as $package) {
                    if ($package != $pkid) {
                        $updatedPackageId .= $package . ',';
                    }
                }
                $updatedPackage = rtrim($updatedPackageId, ',');
                $query = mysql_query("Update tbl_product set fkPackageId=" . "'" . $updatedPackage . "'" . " where pkProductID=" . $val['fkProductId'] . "");
            }
        }
        /* To remove deleted package id from that products by Krishna Gupta (06-11-2015) ends */

        $ctr = 0;

        $arrRes = $this->select(TABLE_PACKAGE, array('fkWholesalerID'), " pkPackageId='" . $argPostIDs['frmID'] . "'");
        $this->insert(TABLE_WHOLESALER_PACKAGE_DELETE, array('fkPackageId' => $argPostIDs['frmID'], 'fkWholesalerID' => $arrRes[0]['fkWholesalerID']));

        if (isset($argPostIDs['deleteType']) && $argPostIDs['deleteType'] == 'sD') {

            $varWhereAllD = " pkPackageId = '" . $argPostIDs['frmID'] . "'" . $varPortalFilter;
            $num = $this->delete(TABLE_PACKAGE, $varWhereAllD);
            if ($num > 0) {
                $ctr++;
                $varWhere = "fkPackageId = '" . $argPostIDs['frmID'] . "'";
                $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWhere);
            }
        } else {
            $ctr = 0;
            foreach ($argPostIDs['frmID'] as $varDeleteID) {

                $varWhereAllD = "pkPackageId  = '" . $varDeleteID . "'" . $varPortalFilter;
                $num = $this->delete(TABLE_PACKAGE, $varWhereAllD);
                if ($num > 0) {
                    $ctr++;
                    $varWhere = "fkPackageId = '" . $varDeleteID . "'";
                    $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWhere);
                }
            }
        }
        return $ctr;
    }

    /**
     * function getSortColumn
     *
     * This function is used to sort column.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objPackage->getSortColumn($argVarSortOrder)
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
            $varSortBy = 'pkPackageId';
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
        $objOrder->addColumn('Package Name', 'PackageName');
        $objOrder->addColumn('Products', 'ProductName', '', 'hidden-1024');
        $objOrder->addColumn('Actual Price-USD', 'FinalPrice', '', 'hidden-480');
        $objOrder->addColumn('Package Price - USD', 'PackagePrice', '', 'hidden-350');

        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function updatePackageStatus
     *
     * This function is used to change package status.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $ctr
     *
     * User instruction: $objPackage->removePackage($argPostIDs, $varPortalFilter)
     */
    function updatePackageStatus($argPost) {

        $varWhr = 'pkPackageID = ' . $argPost['pkgid'];
        $arrClms = array(
            'PackageStatus' => $argPost['status'],
            'packageDateUpdated' => date(DATE_TIME_FORMAT_DB)
        );
        //pre($arrClms);
        //echo date('Y-m-d h:i:s'); die;
        $arrUpdateID = $this->update(TABLE_PACKAGE, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function CheckExistancyOfPackage
     *
     * This function is used to to check that new package is already existing or not.
     *
     * Database Tables used in this function are : tbl_package_product_attribute_option
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return boolean
     *
     * User instruction: $objWholesaler->CheckExistancyOfPackage($condition, $count)
     *
     * @author : Krishna Gupta
     *
     * @created : 29-10-2015
     *
     * @Modified : 05-11-2015
     */
    function CheckExistancyOfPackage($ids, $count, $type = null) {

        if ($type != 'add') {
            $cond = $ids . ' AND fkPackageId != ' . $_REQUEST['pkgid'];
            $varQuery = "SELECT group_concat(fkProductId) as productId, count(fkProductId) as total,fkPackageId FROM `tbl_product_to_package` group by fkPackageId HAVING 1=1 AND " . $cond;
        } else {
            $varQuery = "SELECT group_concat(fkProductId) as productId, count(fkProductId) as total,fkPackageId FROM `tbl_product_to_package` group by fkPackageId HAVING 1=1 AND " . $ids;
        }
        //$varQuery = "SELECT group_concat(productId), count(productId) as total,packageId FROM `tbl_package_product_attribute_option` group by packageId HAVING 1=1 AND " . $ids;
        $arrRes = $this->getArrayResult($varQuery);


        foreach ($arrRes as $data) {
            //pre($data);
            if ($data['total'] == $count) {
                return true;
            }
        }
        return false;
    }

}

?>