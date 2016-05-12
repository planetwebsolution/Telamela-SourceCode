<?php

require_once '../config/config.inc.php';

class UpdateCurrency extends Database {

    /******************************************
      Function name : runCron
      Comments : This function call the cron functions one by one.
      User instruction : $res = $objClass->runCron();
     * **************************************** */
    public function __construct() {
        $objCore = new Core();
        $this->setCurrency();
        //mail('raju.khatak@mail.vinove.com','hi','hi');
    }

    /**
     *
     *  Function Name : currencyList
     *
     *  Return type : String Price
     *
     *  Date created : 05th July 2013
     *
     *  Date last modified : 05th July 2013
     *
     *  Author :Rupesh Parmar
     *
     *  Last modified by : Rupesh Parmar
     *
     *  Comments : This function return currency sign. It take one argument.
     *
     *  Use instruction : obj->setCurrency($argCurrencyCode)
     *
     */
    function currencyList($argCurrencyCode = '') {
        $arrCurrency = array(
            'USD' => 'US&#36;',
            'AED' => 'AED',
            'ARS' => 'AR&#36;',
            'AUD' => 'AU&#36;',
            'BGN' => '&#960;&Beta;',
            'BOB' => 'Bs.',
            'BRL' => 'BR&#36;',
            'CAD' => 'CA&#36;',
            'CHF' => 'Fr',
            'CLP' => 'CL&#36;',
            'CNY' => '&yen;',
            'COP' => 'CO&#36;',
            'CZK' => 'Kc',
            'DKK' => 'kr',
            'EGP' => '&pound;',
            'EUR' => '&euro;',
            'GBP' => '&pound;',
            'HKD' => 'HK&#36;',
            'HRK' => 'kn',
            'HUF' => 'Ft',
            'IDR' => 'Rp',
            'ILS' => 'ILS',
            'INR' => 'Rs.',
            'JPY' => '&yen;',
            'KRW' => 'W',
            'KWD' => 'KWD',
            'LTL' => 'Lt',
            'MAD' => 'MAD',
            'MXN' => 'MX&#36;',
            'MYR' => 'RM',
            'NOK' => 'kr',
            'NZD' => 'NZ&#36;',
            'PEN' => 'S.',
            'PHP' => 'P',
            'PKR' => 'Rs.',
            'PLN' => 'z&iacute;',
            'RON' => 'L',
            'RSD' => 'din.',
            'RUB' => 'p.',
            'SAR' => 'SAR',
            'SEK' => 'kr',
            'SGD' => 'SG&#36;',
            'THB' => '&Beta;',
            'TWD' => 'TW&#36;',
            'UAH' => '&sect;',
            'VEF' => 'Bs',
            'VND' => 'VND',
            'ZAR' => 'R',
        );
        //echo count($arrCurrency);die;
        return $arrCurrency;
    }

    /**
     * function setCurrency
     *
     * This function is used for get currency price via yahoo api.
     *
     * Database Tables used in this function are : tbl_currency_price
     *
     * @access public
     *
     * @parameters 1
     *
     * @return String $arrRes
     */
    function setCurrency($argCurrencyCode) {

        $arrCurrencySign = $this->currencyList();
       
        foreach ($arrCurrencySign as $key => $val) {
            $from = 'USD';
            $to = $key; //$argCurrencyCode;
            //make string to be put in API        
            //$google_url = "http://www.google.com/ig/calculator?hl=en&q=" . $string;     //Call Google API
            $string = $from . $to;
            $yahoo_url = 'http://download.finance.yahoo.com/d/quotes.csv?s=' . $string . '=X&f=nl1d1t1';
            $result[] = file_get_contents($yahoo_url);
        }
        //pre($result);
        $this->delete(TABLE_CURRENCY_PRICE,1);
        foreach($result as $results){
          $varLoopResults=explode(',', $results);
          if ($varLoopResults[1] > 0){
              $convertToReplaceWith=  str_replace('"', ' ', $varLoopResults[0]);
              $dbArray=array('currencyToconvert'=>$convertToReplaceWith,'currencyPrice'=>$varLoopResults[1]);
              $this->insert(TABLE_CURRENCY_PRICE,$dbArray);
          }
            
        }
      
    }

}

$objGiftCard = new UpdateCurrency();
//$objGiftCard->runGiftCardMail();
?>