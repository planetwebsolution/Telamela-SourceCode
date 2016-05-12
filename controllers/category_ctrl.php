<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_PATH . 'class_category_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_shopping_cart_bll.php';

class CategoryCtrl extends Paging {
    /*
     * Variable declaration begins
     *
     * holds the heading of the page
     */

    public $varHeading = '';

    /*
     * constructor
     */

    public function __construct() {
        /*
         * Checking valid login session
         */
        $objCore = new Core();
        $objCore->setCurrencyPrice();
        //$objAdminLogin = new AdminLogin();
        //check admin session
        //$objAdminLogin->isValidAdmin();
        //************ Get Admin Email here
    }

    /**
     * function pageLoads
     *
     * This function Will be called on each page load and will check for any form submission.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $objPage->pageLoad();
     *
     * @access public
     *
     * @return void
     */
    public function pageLoad() {
        global $arrCat;
        $objCore = new Core();
        $objCategory = new Category();
        $objPaging = new Paging();
        // $objShoppingCart = new ShoppingCart();
        //pre($_POST);
        //$this->arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
        $this->arrData['arrAdsDetails'] = $objCategory->getAdsDetails();
        $this->lagyPageLimit = 60;
        //Solr Search [Start]
        //echo '<pre>';print_r();echo '</pre>';
        //if ($_SERVER['HTTP_HOST'] == "www.telamela.com.au" || $_SERVER['HTTP_HOST'] == "telamela.com.au"  || $_SERVER['HTTP_HOST'] == "54.206.47.144" || $_SERVER['HTTP_HOST'] == "i.vinove.com" || $_SERVER['HTTP_HOST'] == "localhost") {
        //print_r($_POST);

        $this->CategoryLevel = 2;
        if ($_REQUEST['type'] == 'new') {
            $whQuery = "ProductNewOld:New";
            $this->CategoryLevel = 0;
        }
//pre($_REQUEST);
        if ($_REQUEST['searchKey'] == SEARCH_FOR_BRAND)
            $_REQUEST['searchKey'] = '';
        if ($_REQUEST['searchVal'] == ENTER_KEY)
            $_REQUEST['searchVal'] = '';
        if ($_REQUEST['searchKey'] != '' || $_REQUEST['searchVal'] != '') {

            if ($_REQUEST['searchKey'] != '') {
                $searchKey = htmlentities($_REQUEST['searchKey']);
                if ($whQuery != '')
                    $whQuery .= " AND ";
                $whQuery .= '(ProductName:"' . $searchKey . '" OR ProductDescription:"' . $searchKey . '" OR CompanyName:"' . $searchKey . '" OR CategoryName:"' . $searchKey . '")';
            }
            if ($_REQUEST['searchVal'] != '') {
                $searchVal = htmlentities($_REQUEST['searchVal']);
                if ($whQuery != '')
                    $whQuery .= " AND ";
                $whQuery .= '(ProductName:"' . $searchVal . '" OR ProductDescription:"' . $searchVal . '" OR CompanyName:"' . $searchVal . '" OR CategoryName:"' . $searchVal . '")';
            }
            //$whQuery = "(ProductName:*" . $keyword . "* OR ProductDescription:*" . $keyword . "* OR CompanyName:*" . $keyword . "* OR CategoryName:*" . $keyword . "*)";                
        }
        if ($_REQUEST['cid'] > 0) {
            //pre($_REQUEST);
            $cid = (int) $_REQUEST['cid'];
            $CategoryDetails = $objCategory->getCategoryDetails($cid);
//            pre($CategoryDetails);
            
            /* HEMANT - START - FOR GET PARENT CATEGOY NAME*/
            
                $this->parentDetailsCategory = $parentDetailsCategory = $objCategory->getParentCategoryDetails($cid);
                
                //pre($parentDetailsCategory);
                
            /* HEMANT - START - FOR GET PARENT CATEGOY NAME*/
            $this->CategoryLevel = $CategoryDetails['CategoryLevel'];
            $this->varBreadcrumbs = $objCategory->getvarBreadcrumbs($CategoryDetails['CategoryHierarchy']);

            if ($whQuery != '')
                $whQuery .= " AND ";
//            $whQuery .= "(pkCategoryId:" . $_REQUEST['cid'] . " OR CategoryHierarchy:" . $_REQUEST['cid'] . "|* OR CategoryHierarchy:*|" . $_REQUEST['cid'] . "|*)";
//            $whQuery .= '(pkCategoryId:' . $cid . ' OR CategoryParentId:' . $cid . ' OR CategoryGrandParentId:' . $cid . ')';
            $whQuery .= '(pkCategoryId:' . $cid . ' OR CategoryParentId:' . $cid . ' OR CategoryGrandParentId:' . $cid . ')';
//            $whQuery .= ' AND pkProductID : 8385';
//            $whQuery .= ' AND WholesalerStatus : active ';
//            pre($whQuery);
        }else {
            //$this->CategoryLevel = 0;
        }

        if ($_REQUEST['wid'] != '' && $_REQUEST['action'] != 'SelectLeftPanel') {
            
            $whQueryWhl = '';
            $arrWhl = explode(",", $_REQUEST['wid']);
            foreach ($arrWhl as $whl) {
                if ($whQueryWhl != '')
                    $whQueryWhl .= " OR ";
                $whQueryWhl .= "pkWholesalerID:" . $whl;
            }
            if ($whQuery != '')
                $whQuery .= " AND ";
            $whQuery .= "($whQueryWhl)";
        }
        if ($this->CategoryLevel == 2) {
            if ($_REQUEST['attr'] != '' && $_REQUEST['action'] != 'SelectLeftPanel') {
                $whQueryAttr = "";
                $arrAttr = explode("#", $_REQUEST['attr']);
                foreach ($arrAttr as $strAttr) {
                    $arrAttr1 = explode(":", $strAttr);
                    if ($arrAttr1['1'] > 0) {
                        $arrAttr2 = explode(",", $arrAttr1['1']);
                        foreach ($arrAttr2 as $attrb) {
                            if ($whQueryAttr != '')
                                $whQueryAttr .= " OR ";
                            $whQueryAttr .= 'arrAttributes:*' . $attrb . '*';
                        }
                    }
                    if ($whQueryAttr != '') {
                        if ($whQuery != '')
                            $whQuery .= " AND ";
                        $whQuery .= "($whQueryAttr)";
                    }
                    $whQueryAttr = '';
                }
            }
        }
        if ($_REQUEST['frmPriceFrom'] > 0 && $_REQUEST['frmPriceTo'] > 0) {
            if ($whQuery != '' || $whQueryPrice1 != '')
                $whQueryPrice2 .= " AND ";
            $whQueryPrice2 .= "(DiscountFinalPrice:[ " . (int) $objCore->getRawPrice($_REQUEST['frmPriceFrom']) . "  TO " . $objCore->getRawPrice($_REQUEST['frmPriceTo']) . "]";
            $whQueryPrice2 .= " OR ";
            $whQueryPrice2 .= "SpecialFinalPrice:[" . (int) $objCore->getRawPrice($_REQUEST['frmPriceFrom']) . " TO " . (int) $objCore->getRawPrice($_REQUEST['frmPriceTo']) . "]";
            $whQueryPrice2 .= " OR ";
            $whQueryPrice2 .= "FinalPrice:[" . (int) $objCore->getRawPrice($_REQUEST['frmPriceFrom']) . " TO " . (int) $objCore->getRawPrice($_REQUEST['frmPriceTo']) . "])";
        }
        else if ($_REQUEST['frmPriceFrom'] > 0) {
            if ($whQuery != '' || $whQueryPrice1 != '')
                $whQueryPrice2 .= " AND ";
            $whQueryPrice2 .= "(DiscountFinalPrice:[" . $objCore->getRawPrice($_REQUEST['frmPriceFrom']) . " TO " . FILTER_PRICE_LIMIT . "]";
            $whQueryPrice2 .= " OR ";
            $whQueryPrice2 .= "SpecialFinalPrice:[" . $objCore->getRawPrice($_REQUEST['frmPriceFrom']) . " TO " . FILTER_PRICE_LIMIT . "]";
            $whQueryPrice2 .= " OR ";
            $whQueryPrice2 .= "FinalPrice:[" . $objCore->getRawPrice($_REQUEST['frmPriceFrom']) . " TO " . FILTER_PRICE_LIMIT . "])";
        }
        else if ($_REQUEST['frmPriceTo'] > 0) {
            if ($whQuery != '' || $whQueryPrice1 != '' || $whQueryPrice2 != '')
                $whQueryPrice2 .= " AND ";
                $whQueryPrice2 .= "(DiscountFinalPrice:[0 TO " . $objCore->getRawPrice($_REQUEST['frmPriceTo']) . "]";
                $whQueryPrice2 .= " OR ";
                $whQueryPrice2 .= "SpecialFinalPrice:[0 TO " . $objCore->getRawPrice($_REQUEST['frmPriceTo']) . "]";
                $whQueryPrice2 .= " OR ";
                $whQueryPrice2 .= "FinalPrice:[0 TO " . $objCore->getRawPrice($_REQUEST['frmPriceTo']) . "])";
                
        }else if ($_REQUEST['pid'] != '') {
            if ($whQuery != '')
                $whQueryPrice1 .= " AND ";
            $whQueryPrice1 .= "DiscountFinalPrice:[" . str_replace("-", " TO ", $_REQUEST['pid']) . "]";
        }

        //echo $whQuery . $whQueryPrice1 . $whQueryPrice2 . "----------------<br>";
        //$this->arrProductCategoryList = getSolrResult($whQuery.$whQueryPrice1.$whQueryPrice2);
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'productLazyLoading') {

            $varStPage = $_REQUEST['limit'];
            $whQuery . $whQueryPrice1 . $whQueryPrice2 . ' AND ProductStatus:1';
            $this->arrProductCategoryList = getSolrResult($whQuery . $whQueryPrice1 . $whQueryPrice2 . ' AND ProductStatus:1', $varStPage, $this->lagyPageLimit, $arrCat[(int) $cid]);
//            pre($this->arrProductCategoryList['productsDetails']);            
            $this->arrProductDetails = $this->arrProductCategoryList['productsDetails'];
        } else {

            if (isset($_REQUEST['page'])) {
                $varPage = $_REQUEST['page'];
            } else {
                $varPage = 0;
            }
            $varStPage = ($varPage > 0 ? ($varPage - 1) : 0) * PRODUCT_LISTING_LIMIT_PER_PAGE;
//            print_r($whQuery);
//            print_r($whQueryPrice1);
//            print_r($whQueryPrice2);
//            print_r($this->NumberofRows);
//            pre($arrCat[(int) $cid]);  AND WholesalerStatus:active 
            $this->arrProductCategoryList = getSolrResult($whQuery . $whQueryPrice1 . $whQueryPrice2 . ' AND ProductStatus:1', $varStPage, PRODUCT_LISTING_LIMIT_PER_PAGE, $arrCat[(int) $cid], 1);
//            pre($this->arrProductCategoryList);
            $this->arrProductDetails = $this->arrProductCategoryList['productsDetails'];
            //pre($this->arrProductDetails);
            $this->NumberofRows = $this->arrProductCategoryList['ProductsTotal'];
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, PRODUCT_LISTING_LIMIT_PER_PAGE);
            $this->varNumberofRows = count($this->arrProductDetails);
//            pre($this->arrProductCategoryList);
            /* Hemant Suman - For get all Wholeseller with Deactive status */
            $this->arrData['arrWholeSellerList'] = $objCategory->ListWhDeactive();
            $this->DeactiveWhID = array();
            foreach($this->arrData['arrWholeSellerList'] as $val){
                
                $this->DeactiveWhID[] = $val['pkWholesalerID'];
            }
            $this->DeactiveWhIDList = $this->DeactiveWhID;
//            pre($this->DeactiveWhIDList);
            
        }
        if (!isset($_REQUEST['action']) || $_REQUEST['action'] == 'SelectLeftPanel') {

//            print_r($whQuery);
//            print_r($whQueryPrice1);
//            print_r($whQueryPrice2);
//            print_r($this->NumberofRows);
//            pre($arrCat[(int) $cid]);
            $this->arrProductCategoryList = getSolrCategoryResult($whQuery . $whQueryPrice1 . $whQueryPrice2, 0, $this->NumberofRows, $arrCat[(int) $cid]);
//            pre($this->arrProductCategoryList);
            $this->arrData['arrAttributeDetail'] = $this->arrProductCategoryList['arrAttributeDetail'];
            //echo '<pre>';print_r($this->arrData['arrAttributeDetail']);echo '</pre>';            
            $this->arrWholeSalerList = $this->arrProductCategoryList['WholesalerDetails'];
//            pre($this->arrProductCategoryList);

            $this->CategoryChildList = $this->arrProductCategoryList['CategoryChildList'];
//            pre($this->CategoryChildList);
            if ($_REQUEST['frmPriceFrom'] < 1 && $_REQUEST['frmPriceTo'] < 1) {
                if ($whQuery != '')
                    $whQuery .= ' AND ';
                $princeRdif = 50;
                $priceLimit = 100;
                for ($k = 0, $l = -1; $k <= $priceLimit; $k+=$princeRdif, $l++) {
                    if ($k > 0) {
                        $PriceRange[$l]['from'] = $p;
                        $PriceRange[$l]['to'] = $k - 1;
                        $PriceRange[$l]['value'] = $p . "-" . ($k - 1);
                        $PriceRange[$l]['productNum'] = getSolrPriceResult($whQuery . "DiscountFinalPrice:[$p TO " . ($k - 0.001) . "]");
                    }
                    $p = $k;
                }
                $PriceRange[$l + 1]['from'] = $priceLimit;
                $PriceRange[$l + 1]['to'] = "";
                $PriceRange[$l + 1]['value'] = $priceLimit . "-" . FILTER_PRICE_LIMIT;
                $PriceRange[$l + 1]['productNum'] = getSolrPriceResult($whQuery . "DiscountFinalPrice:[$priceLimit TO " . FILTER_PRICE_LIMIT . "]");

                $this->PriceRange = $PriceRange;
            }
        }
        $this->arrPriceRange = $this->arrProductCategoryList['arrPriceRange'];
//        pre($this->arrPriceRange);
        //echo $this->CategoryLevel;
//        Solr Search [End]
        /* }else {

          if ($_REQUEST['type'] == 'new') {
          $this->arrCategoryDetails = $objCategory->NewProductCategoryList();
          $catIds = '';
          foreach ($this->arrCategoryDetails as $cat) {
          if ($catIds != '')
          $catIds.=",";
          $catIds .= $cat['fkCategoryID'];
          }
          $this->arrChildCats = $objCategory->getChildCats($catIds, $catIds);
          }
          if ($_REQUEST['cid'] > 0) {
          $this->arrCategoryDetails = $objCategory->CategoryList($_REQUEST['cid']);
          $this->arrChildCats = $objCategory->getChildCats($_REQUEST['cid'], $_REQUEST['cid']);
          $this->varBreadcrumbs = $objCategory->getvarBreadcrumbs($this->arrCategoryDetails[0]['CategoryHierarchy']);
          }

          $this->arrData['arrAttributeDetail'] = $objCategory->getAttributeByCatId($this->arrChildCats);

          $this->arrTotalProductDetails = $objCategory->ProductCategoryList($_REQUEST, $this->arrChildCats);
          $this->NumberofRows = count($this->arrTotalProductDetails['productsDetails']);
          if (isset($_REQUEST['page'])) {
          $varPage = $_REQUEST['page'];
          } else {
          $varPage = 0;
          }
          $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, PRODUCT_LISTING_LIMIT_PER_PAGE);
          $this->arrProductCategoryList = $objCategory->ProductCategoryList($_REQUEST, $this->arrChildCats, $objPaging->getPageStartLimit($varPage, PRODUCT_LISTING_LIMIT_PER_PAGE) . ',' . PRODUCT_LISTING_LIMIT_PER_PAGE);

          $this->arrProductDetails = $this->arrProductCategoryList['productsDetails'];
          $this->arrWholeSalerList = $this->arrProductCategoryList['WholesalerDetails'];
          //pre($this->arrWholeSalerList);
          $this->varNumberofRows = count($this->arrProductDetails);
          $this->catAry = array();
          foreach ($this->arrProductDetails as $product) {
          $catAry[] = $product['pkCategoryId'];
          }
          $catArry = array_unique($catAry);
          if (count($catArry))
          $this->currentCategory = implode(',', $catArry);
          } */
        /*
          if (!empty($_SESSION['MyCompare']['Product'])) {
          $this->arrData['arrCompDetails'] = $objCategory->myCompareDetails();
          $this->arrData['arrCompareDetails'] = $this->arrData['arrCompDetails']['product_details'];
          } */
    }

}

$objPage = new CategoryCtrl();
$objPage->pageLoad();
?>
