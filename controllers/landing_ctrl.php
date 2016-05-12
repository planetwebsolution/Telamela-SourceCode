<?php

require_once CLASSES_PATH . 'class_category_bll.php';
require_once CLASSES_PATH . 'class_home_bll.php';
require_once CLASSES_PATH . 'class_common.php';
/**
 *
 * Module name : FestivalCtrl
 *
 * Parent module : None
 *
 * Date created : 10th March 2014
 *
 * Date last modified :  11th March 2014
 *
 * Author :  Suraj Kumar Maurya
 *
 * Last modified by : Suraj Kumar Maurya
 *
 * Comments : The FestivalCtrl class is used to manage special landing page banner.
 *
 */
class LandingCtrl {

    public function __construct() {
        global $objCore;
        $objCore->setCurrencyPrice();
    }

    /**
     *
     * Function Name : pageLoad
     *
     * Return type : void
     *
     * Date created : 10th March 2014
     *
     * Date last modified :  10th March 2014
     *
     * Author : Suraj Kumar Maurya
     *
     * Last modified by : Suraj Kumar Maurya
     *
     * Comments : This function Will be called on each page load and will check for any form submission.
     *
     * User instruction : $objPage->pageLoad();
     *
     */
    public function pageLoad() {
        global $objCore;
        global $arrCat;
        global $objGeneral;
        $objHome = new Home();
        $objCategory = new Category();
        $objComman = new ClassCommon();
        $cid = (int) $_REQUEST['cid'];

        if (!isset($_REQUEST['action'])) {
            $this->arrBanner = $objCategory->getSpecialBanner('landing',$cid);
        }

        $sortby = $_REQUEST['sortby'];

        $lim_from = (int) $_REQUEST['limit'];
        $this->pageLimit = 60;

        $this->arrProduct = $objCategory->getLandingProduct($cid, $sortby, $lim_from, $this->pageLimit);

        if (!isset($_REQUEST['action'])) {
            $arrLeftCat = $arrCat[$cid];


            $this->arrLeftCat = $arrLeftCat;
        }
        
        //pre($this->arrLeftCat);
        // $this->varBreadcrumbs = $objCategory->getBreadcrumbSpecial($cid);
       // $mainCat=array('pkCategoryId'=>$cid);
        $mainCat['pkCategoryId']['pkCategoryId']=$cid;
        $this->arrData['pkCategoryId']=$cid;
        //pre($mainCat);
        $this->arrData['arrSpecialProductPrice'] = $objGeneral->getAllSpecialProductPrice();
        $this->arrData['topSellingProducts'] = $objHome->getTopSellingProducts($todayOfferProduct);
        //pre($this->arrData['topSellingProducts']);
        $this->arrData['topRatedProducts'] = $objHome->getTopRatedProds('',$cid);
        $this->arrData['ads'] = $objComman->getCatAds();
       // $this->arrData['ads'] = $objHome->getAds();
        $this->arrData['arrCategoryLatestPoducts'] = $objHome->categoryLatestPoducts($todayOfferProduct,$mainCat);
       // pre($this->arrData['arrCategoryLatestPoducts']);
    }

}

$objPage = new LandingCtrl();
$objPage->pageLoad();
?>
