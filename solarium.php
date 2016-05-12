<?php

require(__DIR__ . '/vendor/solarium/solarium/examples/init.php');
// check solarium version available
//echo 'Solarium library version: ' . Solarium\Client::VERSION . ' - ';
// create a client instance
$objClient = new Solarium\Client($config);

function pingCheck() {
// execute the ping query
    global $objClient;

// create a ping query
    $ping = $objClient->createPing();

    try {
        $result = $objClient->ping($ping);
        return isset($result);
//var_dump($result->getData());
    } catch (Solarium\Exception $e) {
        echo 'Ping query failed';
        return 0;
    }
}

function getSolrResult($varQuery = "*:*", $varStart = 0, $varRows = 10, $catArry = array(), $noLimit = 0) {
    //pre($varQuery);
    global $objClient;

    if (pingCheck()) {
        $fields = '*';
        $_REQUEST['sortingId'] = (isset($_REQUEST['sortingId'])) ? ($_REQUEST['sortingId']) : '';
        if ($_REQUEST['sortingId'] == "Recently Added") {
            $arrSort = array("ProductDateAdded" => "desc");
        } else if ($_REQUEST['sortingId'] == 'A-Z') {
            $arrSort = array("ProductNameTAS" => "asc");
        } else if ($_REQUEST['sortingId'] == 'Z-A') {
            $arrSort = array("ProductNameTAS" => "desc");
        } else if ($_REQUEST['sortingId'] == 'Popularity') {
            $arrSort = array("Sold" => "desc");
        } else if ($_REQUEST['sortingId'] == 'Price (Low > High)') {
            //$arrSort = array("DiscountFinalPrice" => "asc", "FinalPrice" => "asc");
            $arrSort = array("FinalPrice" => "asc");
        } else if ($_REQUEST['sortingId'] == 'Price (High > Low)') {
            //$arrSort = array("DiscountFinalPrice" => "desc", "FinalPrice" => "desc");
            $arrSort = array("FinalPrice" => "desc");
        } else {
            $arrSort = array("pkProductID" => "desc");
        }
//echo '<pre>';print_r($arrSort);echo '</pre>';
        /* $varQuery = "";//*:*";//$objClient->createQuery($client::QUERY_SELECT); */
//echo $varQuery."&varStart=$varStart&rows=$varRows <br>";
// this executes the query and returns the result
//$onjResult = $objClient->execute($query);
//$varQuery .= ($varQuery!=''?" AND":"")." ProductStatus:1";
//$arrWhere = array('fields' => $fields, 'query' => $varQuery, 'start' => $varStart, 'rows' => $varRows, 'sort' => $arrSort);

        if ($noLimit == '1') {
            $arrWhere = array('fields' => $fields, 'query' => $varQuery, 'start' => $varStart, 'rows' => $varRows, 'sort' => $arrSort);
        } else {
            $arrWhere = array('fields' => $fields, 'query' => $varQuery, 'start' => $varStart, 'rows' => $varRows, 'sort' => $arrSort);
        }

        //pre($arrWhere);
        $objQuery = $objClient->createSelect($arrWhere);

//        $objQuery->addFilterQuery(array(
//            //'key' => 'fq1',
//            //'tag' => array('ProductStatus'),
//            //'query' => 'population:[1 TO 1000000]',
//        ));


//        echo "<pre>";print_r($objQuery);
        $objResult = $objClient->select($objQuery); //echo '<pre>';print_r($objResult);echo '</pre>';
//         pre($objResult);
        $arrResult = $arrDoc = $arrAttr = $arrCatsName = $arrCats = array();
        $i = 0;

        foreach ($catArry as $val) {
            $arrCats[] = $val['pkCategoryId'];
            $arrCatsName[$val['pkCategoryId']] = $val['CategoryName'];
        }
        $arrResult['ProductsTotal'] = $objResult->getNumFound();
        foreach ($objResult as $documents) {
//echo '<pre>';print_r($documents->fieldsprotected);echo '</pre>';
            foreach ($documents AS $field => $value) {
                if ($field == 'arrAttributes' || $field == 'arrproductImages')
                    $value = unserialize($value[0]);
                if ($field == 'CategoryHierarchy')
                    $value = str_replace(", ,", ":", trim($value, " "));

                $arrDoc[$field] = $value;

                if ($field == 'pkWholesalerID' || $field == 'CompanyName' || $field == 'pkProductID' || $field == 'arrAttributes' || $field == 'CategoryName') {
                    $$field = $value;
                }
            }

            $arrDoc['DiscountFinalPrice'] = $arrDoc['DiscountFinalPrice'] == $arrDoc['FinalPrice'] ? '0.00' : $arrDoc['DiscountFinalPrice'];

            $arrResult['productsDetails'][$i] = $arrDoc;
            /*
              $arrResult['WholesalerDetails'][$pkWholesalerID]['pkWholesalerID'] = $pkWholesalerID;
              $arrResult['WholesalerDetails'][$pkWholesalerID]['CompanyName'] = $CompanyName;
              $arrResult['WholesalerDetails'][$pkWholesalerID]['ProductNum'] += 1;

              if (in_array($arrDoc['pkCategoryId'], $arrCats)) {
              $arrResult['CategoryChildList'][$arrDoc['pkCategoryId']]['pkCategoryID'] = $arrDoc['pkCategoryId'];
              $arrResult['CategoryChildList'][$arrDoc['pkCategoryId']]['CategoryName'] = $arrCatsName[$arrDoc['pkCategoryId']];
              $arrResult['CategoryChildList'][$arrDoc['pkCategoryId']]['ProductNum'] += 1;
              }
              else if (in_array($arrDoc['CategoryParentId'], $arrCats)) {
              $arrResult['CategoryChildList'][$arrDoc['CategoryParentId']]['pkCategoryID'] = $arrDoc['CategoryParentId'];
              $arrResult['CategoryChildList'][$arrDoc['CategoryParentId']]['CategoryName'] = $arrCatsName[$arrDoc['CategoryParentId']];
              $arrResult['CategoryChildList'][$arrDoc['CategoryParentId']]['ProductNum'] += 1;
              }
              else if (in_array($arrDoc['CategoryGrandParentId'], $arrCats)) {
              $arrResult['CategoryChildList'][$arrDoc['CategoryGrandParentId']]['pkCategoryID'] = $arrDoc['CategoryGrandParentId'];
              $arrResult['CategoryChildList'][$arrDoc['CategoryGrandParentId']]['CategoryName'] = $arrCatsName[$arrDoc['CategoryGrandParentId']];
              $arrResult['CategoryChildList'][$arrDoc['CategoryGrandParentId']]['ProductNum'] += 1;
              }

              foreach ($arrAttributes as $k => $v) {

              $arrOpt = explode(',', $v['pkOptionID']);
              $arrTitle = explode(',', $v['OptionTitle']);
              foreach ($arrOpt as $k1 => $v1) {
              $varInd = $v['AttributeOrdering'] . '-' . $v['pkAttributeId'] . '-' . $v1;
              $arrResult['arrAttributeDetail'][$varInd]['pkAttributeId'] = $v['pkAttributeId'];
              $arrResult['arrAttributeDetail'][$varInd]['AttributeLabel'] = $v['AttributeLabel'];
              $arrResult['arrAttributeDetail'][$varInd]['AttributeInputType'] = $v['AttributeInputType'];
              $arrResult['arrAttributeDetail'][$varInd]['OptionTitle'] = $arrTitle[$k1];
              $arrResult['arrAttributeDetail'][$varInd]['pkOptionID'] = $v1;
              $arrResult['arrAttributeDetail'][$varInd]['ProductId'] .= (isset($arrResult['arrAttributeDetail'][$varInd]['ProductId']) ? ',' : '') . $pkProductID;
              }
              } */

            $i++;
        }
        if (isset($arrResult['arrAttributeDetail']))
            ksort($arrResult['arrAttributeDetail']);
//pre($arrResult);
        return $arrResult;
    }
}

function getSolrCategoryResult($varQuery = "*:*", $varStart = 0, $varRows = 10, $catArry = array()) {
    global $objClient;

    if (pingCheck()) {
        $fields = '*';

        if ($_REQUEST['sortingId'] == "Recently Added") {
            $arrSort = array("ProductDateAdded" => "desc");
        } else if ($_REQUEST['sortingId'] == 'A-Z') {
            $arrSort = array("ProductNameTAS" => "asc");
        } else if ($_REQUEST['sortingId'] == 'Z-A') {
            $arrSort = array("ProductNameTAS" => "desc");
        } else if ($_REQUEST['sortingId'] == 'Popularity') {
            $arrSort = array("Sold" => "desc");
        } else if ($_REQUEST['sortingId'] == 'Price (Low > High)') {
            //$arrSort = array("DiscountFinalPrice" => "asc", "FinalPrice" => "asc");
            $arrSort = array("FinalPrice" => "asc");
        } else if ($_REQUEST['sortingId'] == 'Price (High > Low)') {
            //$arrSort = array("DiscountFinalPrice" => "desc", "FinalPrice" => "desc");
            $arrSort = array("FinalPrice" => "desc");
        } else {
            $arrSort = array("pkProductID" => "desc");
        }
//echo '<pre>';print_r($arrSort);echo '</pre>';
        /* $varQuery = "";//*:*";//$objClient->createQuery($client::QUERY_SELECT); */
//echo $varQuery."&varStart=$varStart&rows=$varRows <br>";
// this executes the query and returns the result
//$onjResult = $objClient->execute($query);
//$varQuery .= ($varQuery!=''?" AND":"")." ProductStatus:1";
        $arrWhere = array('fields' => $fields, 'query' => $varQuery, 'start' => $varStart, 'rows' => $varRows, 'sort' => $arrSort);
        //pre($arrWhere);
        $objQuery = $objClient->createSelect($arrWhere); //echo '<pre>';print_r($objQuery);echo '</pre>';
        $objResult = $objClient->select($objQuery);
        //echo '<pre>';print_r($objResult);echo '</pre>';
        $arrResult = $arrDoc = $arrAttr = $arrCatsName = $arrCats = array();
        $i = 0;

        foreach ($catArry as $val) {
            $arrCats[] = $val['pkCategoryId'];
            $arrCatsName[$val['pkCategoryId']] = $val['CategoryName'];
        }
        $arrResult['ProductsTotal'] = $objResult->getNumFound();

        if (count($objResult) > 0)
            $arrResult['arrPriceRange'] = array('min' => 99999999, 'max' => 0);
        else
            $arrResult['arrPriceRange'] = array('min' => 0, 'max' => 0);

        foreach ($objResult as $documents) {
//echo '<pre>';print_r($documents->fieldsprotected);echo '</pre>';
            foreach ($documents AS $field => $value) {
                if ($field == 'arrAttributes' || $field == 'arrproductImages')
                    $value = unserialize($value[0]);
                if ($field == 'CategoryHierarchy')
                    $value = str_replace(", ,", ":", trim($value, " "));

                $arrDoc[$field] = $value;

                if ($field == 'pkWholesalerID' || $field == 'CompanyName' || $field == 'pkProductID' || $field == 'arrAttributes' || $field == 'CategoryName') {
                    $$field = $value;
                }
            }

            $arrDoc['DiscountFinalPrice'] = $arrDoc['DiscountFinalPrice'] == $arrDoc['FinalPrice'] ? '0.00' : $arrDoc['DiscountFinalPrice'];

//$arrResult['productsDetails'][$i] = $arrDoc;

            if ($arrDoc['SpecialFinalPrice'] > 0) {
                $price = $arrDoc['SpecialFinalPrice'];
            } else if ($arrDoc['DiscountFinalPrice'] > 0) {
                $price = $arrDoc['DiscountFinalPrice'];
            } else {
                $price = $arrDoc['FinalPrice'];
            }

            //$price = ($arrDoc['SpecialFinalPrice'] > 0) ? $arrDoc['SpecialFinalPrice'] : ($arrDoc['DiscountFinalPrice'] > 0) ? $arrDoc['DiscountFinalPrice'] : $arrDoc['FinalPrice'];
            //echo $arrDoc['SpecialFinalPrice'] . '=' . $arrDoc['DiscountFinalPrice'] . '=' . $arrDoc['FinalPrice'] . '=>' . $price . '<br>';

            $arrResult['arrPriceRange']['min'] = ($arrResult['arrPriceRange']['min'] > $price) ? $price : $arrResult['arrPriceRange']['min'];
            $arrResult['arrPriceRange']['max'] = ($arrResult['arrPriceRange']['max'] < $price) ? $price : $arrResult['arrPriceRange']['max'];

            $arrResult['WholesalerDetails'][$pkWholesalerID]['pkWholesalerID'] = $pkWholesalerID;
            $arrResult['WholesalerDetails'][$pkWholesalerID]['CompanyName'] = $CompanyName;
            $arrResult['WholesalerDetails'][$pkWholesalerID]['ProductNum'] += 1;

            if (in_array($arrDoc['pkCategoryId'], $arrCats)) {
                $arrResult['CategoryChildList'][$arrDoc['pkCategoryId']]['pkCategoryID'] = $arrDoc['pkCategoryId'];
                $arrResult['CategoryChildList'][$arrDoc['pkCategoryId']]['CategoryName'] = $arrCatsName[$arrDoc['pkCategoryId']];
                $arrResult['CategoryChildList'][$arrDoc['pkCategoryId']]['ProductNum'] += 1;
            } else if (in_array($arrDoc['CategoryParentId'], $arrCats)) {
                $arrResult['CategoryChildList'][$arrDoc['CategoryParentId']]['pkCategoryID'] = $arrDoc['CategoryParentId'];
                $arrResult['CategoryChildList'][$arrDoc['CategoryParentId']]['CategoryName'] = $arrCatsName[$arrDoc['CategoryParentId']];
                $arrResult['CategoryChildList'][$arrDoc['CategoryParentId']]['ProductNum'] += 1;
            } else if (in_array($arrDoc['CategoryGrandParentId'], $arrCats)) {
                $arrResult['CategoryChildList'][$arrDoc['CategoryGrandParentId']]['pkCategoryID'] = $arrDoc['CategoryGrandParentId'];
                $arrResult['CategoryChildList'][$arrDoc['CategoryGrandParentId']]['CategoryName'] = $arrCatsName[$arrDoc['CategoryGrandParentId']];
                $arrResult['CategoryChildList'][$arrDoc['CategoryGrandParentId']]['ProductNum'] += 1;
            }
            $_REQUEST['searchCategoryVal'] = $arrDoc['pkCategoryId'];
            foreach ($arrAttributes as $k => $v) {

                $arrOpt = explode(',', $v['pkOptionID']);
                $arrTitle = explode(',', $v['OptionTitle']);
                foreach ($arrOpt as $k1 => $v1) {
                    $varInd = $v['AttributeOrdering'] . '-' . $v['pkAttributeId'] . '-' . $v1;
                    $arrResult['arrAttributeDetail'][$varInd]['pkAttributeId'] = $v['pkAttributeId'];
                    $arrResult['arrAttributeDetail'][$varInd]['AttributeLabel'] = $v['AttributeLabel'];
                    $arrResult['arrAttributeDetail'][$varInd]['AttributeInputType'] = $v['AttributeInputType'];
                    $arrResult['arrAttributeDetail'][$varInd]['OptionTitle'] = $arrTitle[$k1];
                    $arrResult['arrAttributeDetail'][$varInd]['pkOptionID'] = $v1;
                    $arrResult['arrAttributeDetail'][$varInd]['ProductId'] .= (isset($arrResult['arrAttributeDetail'][$varInd]['ProductId']) ? ',' : '') . $pkProductID;
                }
            }

            $i++;
        }
        ksort($arrResult['arrAttributeDetail']);
        return $arrResult;
    }
}

function getSolrProductNameResult($varQuery = "*:*") {
    global $objClient;

    if (pingCheck()) {
        $varStart = 0;
        $varRows = 10;
        $arrSort = array("ProductName" => "asc");
        $fields = array("ProductName");
//echo $varQuery;
        $varQuery .= ($varQuery != '' ? " AND" : "") . " ProductStatus:1";
        $arrWhere = array('fields' => $fields, 'query' => $varQuery, 'start' => $varStart, 'rows' => $varRows, 'sort' => $arrSort);
        $objQuery = $objClient->createSelect($arrWhere);
        $objResult = $objClient->select($objQuery);

        $arrResult = array();

        foreach ($objResult as $documents) {
            foreach ($documents AS $field => $value) {
                if ($field == 'ProductName') {
                    $arrResult[] = $value;
                }
            }
        }
        return $arrResult;
    }
}

function getSolrHierarchyResult($varQuery = "*:*") {
    global $objClient;

    if (pingCheck()) {
        $varStart = 0;
        $varRows = 1;
        $arrSort = array("CategoryHierarchy" => "asc");
        $fields = array("CategoryHierarchy");
        $varQuery .= ($varQuery != '' ? " AND" : "") . " ProductStatus:1";
        $arrWhere = array('fields' => $fields, 'query' => $varQuery, 'start' => $varStart, 'rows' => $varRows, 'sort' => $arrSort);
        $objQuery = $objClient->createSelect($arrWhere);
        $objResult = $objClient->select($objQuery);

        $arrResult = '';

        foreach ($objResult as $documents) {
            foreach ($documents AS $field => $value) {
                if ($field == 'CategoryHierarchy') {
                    $arrResult = str_replace(", ,", ":", trim($value, ","));
                }
            }
        }

        return $arrResult;
    }
}

function getSolrWholesalerNameResult($varQuery = "*:*") {
    global $objClient;

    if (pingCheck()) {
        $varStart = 0;
        $varRows = 5;
        $arrSort = array("CompanyName" => "asc");
        $fields = array("CompanyName");
//$groups = array("CompanyName");
//echo $varQuery;
        $varQuery .= ($varQuery != '' ? " AND" : "") . " ProductStatus:1";
        $arrWhere = array('fields' => $fields, 'query' => $varQuery, 'start' => $varStart, 'rows' => $varRows, 'sort' => $arrSort);
        $objQuery = $objClient->createSelect($arrWhere);
        $objResult = $objClient->select($objQuery);

        $arrResult = array();

        foreach ($objResult as $documents) {
            foreach ($documents AS $field => $value) {
                if ($field == 'CompanyName' && !in_array($value, $arrResult)) {
                    $arrResult[] = $value;
                }
            }
        }
        return $arrResult;
    }
}

function getSolrCategoryNameResult($varQuery = "*:*") {
    global $objClient;

    if (pingCheck()) {
        $varStart = 0;
        $varRows = 5;
        $arrSort = array("CategoryName" => "asc");
        $fields = array("CategoryName");
//echo $varQuery;
        //$varQuery .= ($varQuery != '' ? " AND" : "");
        $arrWhere = array('fields' => $fields, 'query' => $varQuery, 'start' => $varStart, 'rows' => $varRows, 'sort' => $arrSort);
        $objQuery = $objClient->createSelect($arrWhere);
        $objResult = $objClient->select($objQuery);
//$objResult = $objClient->getGrouping();
        $arrResult = array();

        foreach ($objResult as $documents) {
            foreach ($documents AS $field => $value) {
                if ($field == 'CategoryName' && !in_array($value, $arrResult)) {
                    $arrResult[] = $value;
                }
            }
        }
        return $arrResult;
    }
}

function getSolrPriceResult($varQuery = "*:*") {
    global $objClient;

    if (pingCheck()) {
        $varStart = 0;
        $varRows = 1000;
        $arrSort = array("ProductName" => "asc");
        $fields = array("ProductName", "FinalPrice", "DiscountFinalPrice");
//echo $varQuery."<br>";
        $varQuery .= ($varQuery != '' ? " AND" : "") . " ProductStatus:1";
        $arrWhere = array('fields' => $fields, 'query' => $varQuery, 'start' => $varStart, 'rows' => $varRows, 'sort' => $arrSort);
        $objQuery = $objClient->createSelect($arrWhere);
        $objResult = $objClient->select($objQuery);

        /* foreach ($objResult as $documents) {
          echo "<pre>";print_r($documents);echo "</pre>";
          } */
        return $objResult->getNumFound();
    }
}

/* $result = getSolrResult("ProductName:*Video* AND (FinalPrice:[100 TO 99999999])");
  echo '<pre>';print_r($result);echo '</pre>'; */
?>
