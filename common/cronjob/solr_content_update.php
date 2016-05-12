<?php

ini_set("display_errors", 1);
require_once '../config/config.inc.php';
require(SOURCE_ROOT . '/vendor/solarium/solarium/examples/init.php');
require_once CLASSES_PATH . 'class_category_bll.php';
$objCategory = new Category();
global $objGeneral;
$ProductSolrList = $objCategory->ProductSolrList(1500);
$ProductDeldList = $objCategory->ProductDeletedList();
$pkProductIDs = '';
//mail('sandeep.sharma@mail.vinove.com','Solr Data',print_r($documents,1)); 
//echo '<pre>';print_r($ProductSolrList);echo '</pre>';die;
//echo '<pre>';print_r($ProductDeldList);echo '</pre>';
$arrSpecialProductPrice = $objGeneral->getAllSpecialProductPrice();

if (count($ProductSolrList)) {
    // if data is posted add it to solr
    // create a client instance
    $objClient = new Solarium\Client($config);

    // get an update query instance
    $objUpdate = $objClient->createUpdate();

    if (isset($_GET['action']) && $_GET['action'] == 'alldelete') {
        //Remove Old Data
        $objUpdate->addDeleteQuery('*:*');
        $objUpdate->addCommit();
        // this executes the query and returns the result
        $objResult = $objClient->update($objUpdate);
    } else {
        //die;
        //Remove the deleted products from solr
        foreach ($ProductDeldList as $Prd) {
            $objUpdate->addDeleteQuery('pkProductID:' . $Prd['fkProductID']);
            if ($pkProductIDs != '')
                $pkProductIDs .= ",";
            $pkProductIDs .= $Prd['fkProductID'];
        }
        $objUpdate->addCommit();
        if ($pkProductIDs != '')
            $ProductSolrLists = $objCategory->ProductSolrListCronUpdate($pkProductIDs, $arrClmsUpdate = array('ProductCronUpdate' => date('Y-m-d H:i:s')));
        $pkProductIDs = '';

        $i = 0;
        $arrayDoc = array();
        foreach ($ProductSolrList['productsDetails'] as $Prd) {
           $varPname =$Prd['perentCategoryName']." ".$Prd['CategoryName']; 
           //echo '<pre>';print_r($Prd);die;
            //
    	//$i++;
            // create a new document for the data
            // please note that any type of validation is missing in this example to keep it simple!

            $Prd['SpecialFinalPrice'] = isset($arrSpecialProductPrice[$Prd['pkProductID']]['FinalSpecialPrice']) ? $arrSpecialProductPrice[$Prd['pkProductID']]['FinalSpecialPrice'] : '0.00';

            $objDoc = $objUpdate->createDocument();
            $objDoc->id = $Prd['pkProductID'];
            $objDoc->pkProductID = $Prd['pkProductID'];
            $objDoc->ProductName = trim($Prd['ProductName']);
            $objDoc->FinalPrice = ($Prd['FinalPrice'] > 0 ? $Prd['FinalPrice'] : '0.00');
            $objDoc->ProductDescription = $Prd['ProductDescription'];
            $objDoc->ProductImage = $Prd['ProductImage'];
            $objDoc->DiscountFinalPrice = $Prd['DiscountFinalPrice'] > 0 ? $Prd['DiscountFinalPrice'] : 0;
            $objDoc->SpecialFinalPrice = $Prd['SpecialFinalPrice'] > 0 ? $Prd['SpecialFinalPrice'] : 0;
            $objDoc->DiscountPercent = $Prd['discountPercent'] > 0 ? $Prd['discountPercent'] : 0;
            $objDoc->offerPrice = $Prd['offerPrice']>0?$Prd['offerPrice']:0;
            $objDoc->pkWholesalerID = $Prd['pkWholesalerID'];
            $objDoc->CompanyName = trim($Prd['CompanyName']);
            $objDoc->CategoryLevel = trim($Prd['CategoryLevel']);
            $objDoc->CategoryGrandParentId = ($Prd['CategoryParentId'] > 0 ? substr($Prd['CategoryHierarchy'], 0, strpos($Prd['CategoryHierarchy'], ":")) : 0);
            $objDoc->CategoryParentId = $Prd['CategoryParentId'];
            $objDoc->pkCategoryId = $Prd['pkCategoryId'];
            $objDoc->CategoryName = $varPname;
            $objDoc->CategoryHierarchy = "," . str_replace(":", ", ,", $Prd['CategoryHierarchy']) . ",";
            $objDoc->arrAttributes = serialize($Prd['arrAttributes']);
            $objDoc->numRating = ($Prd['numRating'] > 0 ? $Prd['numRating'] : 0);
            $objDoc->numCustomer = ($Prd['numCustomer'] > 0 ? $Prd['numCustomer'] : 0);
            $objDoc->Quantity = ($Prd['Quantity'] > 0 ? $Prd['Quantity'] : 0);
            $objDoc->arrproductImages = ''; //serialize($Prd['arrproductImages']);
            $objDoc->ProductNewOld = $Prd['ProductNewOld'];
            $objDoc->Sold = $Prd['Sold'];
            $objDoc->ProductDateAdded = $Prd['ProductDateAdded'];
            $objDoc->custReview = 0; //($Prd['custReview']>0?$Prd['custReview']:0);
            $objDoc->ProductStatus = $Prd['ProductStatus'];
            if ($pkProductIDs != '')
                $pkProductIDs .= ",";
            $pkProductIDs .= $Prd['pkProductID'];

            //$arrayDoc[] = $objDoc;
            //pre($objDoc);
            $objUpdate->addDocument($objDoc);
        }
       // echo '<pre>';print_r($objDoc);echo '</pre>';
        $objUpdate->addCommit();
        $objResult = $objClient->update($objUpdate);
        $objUpdate->addCommit();
    }
    echo '<b>Update query executed</b><br/>';
    echo 'Query status: ' . $objResult->getStatus() . '<br/>';
    echo 'Query time: ' . $objResult->getQueryTime();

    if ($pkProductIDs != '')
        $ProductSolrList = $objCategory->ProductSolrListCronUpdate($pkProductIDs, $arrClmsUpdate = array('ProductCronUpdate' => date('Y-m-d H:i:s')));
}
?>
