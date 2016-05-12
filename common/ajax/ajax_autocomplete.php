<?php
/* * ****************************************
  Module name : Ajax Calls
  Date created : 06 June, 2013
  Date last modified : 06 June, 2013
  Author : Suraj Kumar Maurya
  Last modified by :  Suraj Kumar Maurya
  Comments : This file includes the funtions for AJAX calls.
  Copyright : Copyright (C) 1999-2011 Vinove Software and Services
 * **************************************** */
require_once '../../solarium.php';
require_once('../config/config.inc.php');
require_once CLASSES_PATH . 'class_category_bll.php';
$objCategory = new Category();
$varcase = $_REQUEST['action'];
//sleep(150);

switch ($varcase) {
    case 'searchKeyAutocomplete':

        $keyword = addslashes(trim($_REQUEST["q"]));
        $cid = trim($_REQUEST["catid"]);
		$catId = '';
		if ($cid > 0) {
			$catId = 'AND CategoryHierarchy:"|' . $cid.'|"';
		}
		$whQuery = '(CompanyName:"' . $keyword . '" ' . $catId . ' )';
        $arrRes = getSolrWholesalerNameResult($whQuery);
		if (count($arrRes) > 0) {
            echo "<div class='head'><b>Wholesaler</b></div>\n";

            
            foreach ($arrRes as $val) {
                echo '<div class="results">'.$val .'</div>'. "\n";
            }
        }
        
		$whQuery = '(CategoryName:"' . $keyword . '" ' . $catId . ' )';
        $arrRes = getSolrCategoryNameResult($whQuery);
		if (count($arrRes) > 0) {
            echo "<div class='head'><b>Category</b></div>\n";

            foreach ($arrRes as $val) {
                echo '<div class="results">'.$val .'</div>'. "\n";
            }
        }
        	$whQuery = '(ProductName:"' . $keyword . '" ' . $catId . ' )';
        $arrRes = getSolrProductNameResult($whQuery);
		if (count($arrRes) > 0) {
            echo "<div class='head'><b>Product</b></div>\n";

            foreach ($arrRes as $val) {
                echo '<div class="results">'.$val .'</div>'. "\n";
            }
        }
        
        /*
         $arrRes = $objCategory->getSearchKeyProduct($keyword,$cid);
         if (count($arrRes['Wholesaler']) > 0) {
            echo "<b>Wholesaler</b>\n";

            foreach ($arrRes['Wholesaler'] as $val) {
                echo $val['CompanyName'] . "\n";
            }getSolrProductNameResult getSolrWholesalerNameResult getSolrCategoryNameResult
        }

        if (count($arrRes['Category']) > 0) {
            echo "<b>Category</b>\n";
            foreach ($arrRes['Category'] as $val) {
                echo $val['CategoryName'] . "\n";
            }
        }

        if (count($arrRes['Product']) > 0) {
            echo "<b>Product</b>\n";
            foreach ($arrRes['Product'] as $val) {
                echo $val['ProductName'] . "\n";
            }
        }*/
        break;
        case 'searchAutocomplete':
		$searchKey = $_REQUEST['searchKey']==SEARCH_FOR_BRAND?'':$_REQUEST['searchKey'];
                $keyword = addslashes(trim($_REQUEST["q"]));
                $cid = $_REQUEST["catid"];
                $catId = '';
                if ($cid <> '' && $cid > 0) {
                    $catId = 'AND CategoryHierarchy:"|' . $cid.'|"';
                }
                if($_REQUEST['type'] == 'new'){
                    $type = 'AND ProductNewOld:New';
                }
                if ($searchKey != ''){
                	$search .= 'AND (ProductName:"' . $searchKey . '" OR ProductDescription:"' . $searchKey . '" OR CompanyName:"' . $searchKey . '" OR CategoryName:"' . $searchKey . '")';
                }
				$whQuery = '(ProductName:"' . $keyword . '" ' . $catId . $type .$search . ' )';
                $arrRes = getSolrProductNameResult($whQuery);

                foreach ($arrRes as $val) {
                    echo $val . "\n";
                }
                break;
}
?>
