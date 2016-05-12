<?php

require_once CLASSES_PATH . 'class_category_bll.php';

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
class SpecialCtrl {

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
        $objCategory = new Category();
        $cid = (int) $_REQUEST['cid'];
        $fid = (int) $_REQUEST['fid'];

        $this->arrBanner = $objCategory->getSpecialBanner();
        $this->arrProduct = $objCategory->getSpecialProduct($cid,$fid);

        $arrLeftCat = $arrCat[$cid];
        $arrTempLeftCat = array();
        foreach ($arrLeftCat as $val) {
            $arrTempLeftCat[$val['pkCategoryId']] = $val;
        }

        $this->arrLeftCat = array();
        foreach ($this->arrProduct as $v) {
            if ($arrTempLeftCat[$v['fkCategoryID']]) {
                $this->arrLeftCat[$v['fkCategoryID']] = $arrTempLeftCat[$v['fkCategoryID']];
            }
        }

        $this->varBreadcrumbs = $objCategory->getBreadcrumbSpecial($cid);
    }

}

$objPage = new SpecialCtrl();
$objPage->pageLoad();
?>
