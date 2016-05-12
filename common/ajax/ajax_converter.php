<?php
require_once '../config/config.inc.php';
require_once(CLASSES_PATH.'class_common.php');
$objClassCommon = new ClassCommon();
$objCore = new Core();

//Get Posted data
$case = $_POST['action'];

switch ($case) {
    case 'showCurrency' :
        //echo 'test';
        $amount = $_POST['amount'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        //make string to be put in API
        //$string = "1" . $from . "=?" . $to;

        //$google_url = "http://www.google.com/ig/calculator?hl=en&q=" . $string;     //Call Google API
        //$result = file_get_contents($google_url);                             //Get and Store API results into a variable
        //$result = explode('"', $result);                                      //Explode result to convert into an array

        $string = $from . $to;

        $yahoo_url = 'http://download.finance.yahoo.com/d/quotes.csv?s=' . $string . '=X&f=nl1d1t1';      

        $result = file_get_contents($yahoo_url);                             //Get and Store API results into a variable      
        $result = explode(',', $result);           
        
        $converted_amount = $result[1];
        $conversion = $converted_amount;
        $conversion = $conversion * $amount;
        $conversion = round($conversion,4);
        
        
        //Calculate Final cost=AC+MC
        $arrRow = $objClassCommon->getMarginCast();
        $varMarginCost = $conversion+($conversion*$arrRow[0]['MarginCast']/100);
        $varMarginCost = round($varMarginCost,4);
        echo $conversion.'--'.$varMarginCost;
        break;

    case 'ChangeCurrency':
        
         $objCore->setCurrency($_REQUEST['currencyCode']);
         print_r($_SESSION);
         //$objCore->setCurrencyCountryID($_REQUEST['currencyCode']);
    break;
    
    case 'currencyConvert':
    echo $objCore->getRawPrice($_REQUEST['amount'],0);
    break;    
        
}
?>