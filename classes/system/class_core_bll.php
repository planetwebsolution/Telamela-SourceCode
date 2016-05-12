<?php

/**
 *
 * Module name : Core
 *
 * Parent module : None
 *
 * Date created : 05th July 2013
 *
 * Date last modified :  05th July 2013
 *
 * Author :  Rupesh Parmar
 *
 * Last modified by : Rupesh Parmar
 *
 * Comments : The Core class is a multipurpose class. This is used to various functions as date, currency and price format etc.
 *
 */
class Core
{

    /**
     *
     * Variable declaration begins
     *
     */
    var $arrMonthShort = Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    var $arrMonthFull = Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    //var $arr_month_full = Array(1=>'January' , 2=>'February' , 3=>'March' , 4=>'April' , 5=>'May' , 6=>'June' , 7=>'July' , 8=>'August' , 9=>'September' , 10=>'October' , 11=>'November' , 12=>'December');
    var $arr_month_full = Array(1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'marcha', 4 => 'Abril', 5 => 'pode', 6 => 'Junho', 7 => 'julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'De outubro', 11 => 'Novembro', 12 => 'Dezembro');
    var $_GET;
    var $varGet;
    var $notify;

    /**
     *
     * Variable declaration ends
     *
     */

    /**
     *
     * Function Name : __construct
     *
     * Return Type : None
     *
     * Date Created : 05th July 2013
     *
     * Date Last Modified : 05th July 2013
     *
     * Author : Rupesh Parmar
     *
     * Last Modified By :Rupesh Parmar
     *
     * Comments : Constructor of the class, will be called in PHP5
     *
     * User Instruction : objAdmin = new Core();();
     *
     */
    function __construct()
    {
//        pre($_SESSION);
    }

    /**
     *
     * Function Name : standardRedirect
     *
     * Return type : None
     *
     * Date created : 05th July 2013
     *
     * Date last modified : 05th July 2013
     *
     * Author : Rupesh Parmar
     *
     * Last modified by :Rupesh Parmar
     *
     * Comments : It takes on argument as a file and file re direct this location.
     *
     * User instruction : $$objCore->standardRedirect($argRdrctFile);
     *
     */
    function standardRedirect($rdrctFile)
    {

        header("Location:$rdrctFile");

        exit;
    }

    /**
     *
     * Function Name : skipArray
     *
     * Return type : Array
     *
     * Date created : 05th July 2013
     *
     * Date last modified :  05th July 2013
     *
     * Author : Rupesh Parmar
     *
     * Last modified by : Rupesh Parmar
     *
     * Comments : It takes two argument as array and second argument is remove from the first array.
     *
     * User instruction : $$objCore->skipArray($argArr, $argSkip);
     *
     */
    function skipArray($arr, $arrSkip)
    {

        $arrResult = array();

        $arrResult = array_diff($arr, $arrSkip);

        return $arrResult;
    }

    /**
     *
     * Function Name : getUrl
     *
     * Return type : Array
     *
     * Date created : 20th Sept 2013
     *
     * Date last modified :  20th JSept 2013
     *
     * Author : Suraj Kumar Maurya
     *
     * Last modified by : Suraj Kumar Maurya
     *
     * Comments : It takes two argument 1st is db PageName and 2nd is query String .
     *
     * User instruction : $objCore->pageLink($argPageName,$argParam);
     *
     */
    function getUrl($argPageName, $argParam = array())
    {

        // print_r($argParam);

        $varPageStr = explode('.', $argPageName);
        $search = array('&amp;', '#', '/', '&', ' ', "'", '"', '%', '+', '!', '$', '?', '^', '*', ';', '(', ')', '`', '~');
        $replace = array('-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', 's', '-', '-', '-', '-', '-', '-', '-', '-');

        foreach ($argParam as $key => $val)
        {
            $argParam[$key] = str_replace($search, $replace, html_entity_decode(stripslashes(trim($val))));
        }
//pre($argParam);
        $varQueryString = $varPageStr[0];
        if ($argPageName == 'content.php')
        {
            if ($argParam)
            {
                $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_CONTENT);
                foreach ($arrPattern as $key => $val)
                {
                    $varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                }
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
        }
        else if ($argPageName == 'product.php')
        {
            if ($argParam)
            { 
                $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_PRODUCT);
                foreach ($arrPattern as $key => $val)
                {
                    $varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                }
                // $varQueryString .= URL_PATTERN_SEPRATER;
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
        }
        else if ($argPageName == 'category.php')
        {
            if ($argParam)
            {
                $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_CATEGORY);
                foreach ($arrPattern as $key => $val)
                {
                    $varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                }
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
        }
        else if ($argPageName == 'special.php')
        {
            //pre($argParam);
            if ($argParam)
            {
                if ($argParam['cid'] == 0)
                {
                    $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_FES);
                }
                else
                {
                    $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_SPECIAL);
                }
               // pre($arrPattern);
                 
                foreach ($arrPattern as $key => $val)
                {
                    //$varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                    $varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                    // pre(URL_PATTERN_FES);
                }
               
                
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
            //pre($varLink);
        }
        
        else if ($argPageName == 'landing.php')
        {
            if ($argParam)
            {
                $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_LANDING);
                foreach ($arrPattern as $key => $val)
                {
                    $varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                }
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
        }
        else if ($argPageName == 'package.php')
        {
            if ($argParam)
            {
                $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_PACKAGE);
                foreach ($arrPattern as $key => $val)
                {
                    $varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                }
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
        }
        else if ($argPageName == 'my_order_details.php')
        {

            if ($argParam)
            {
                $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_CUST_ORDER_DETAILS);
                foreach ($arrPattern as $key => $val)
                {
                    $varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                }
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
        }
        else if ($argPageName == 'view_inbox_message.php')
        {
            if ($argParam)
            {
                $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_CUST_VIEW_INBOX);
                foreach ($arrPattern as $key => $val)
                {
                    $varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                }
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
        }
        else if ($argPageName == 'view_outbox_message.php')
        {
            if ($argParam)
            {
                $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_CUST_VIEW_OUTBOX);
                foreach ($arrPattern as $key => $val)
                {
                    $varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                }
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
        }
        else if ($argPageName == 'wholesaler_profile_customer_view.php')
        {
            if ($argParam)
            {
                $arrPattern = explode(URL_PATTERN_SEPRATER, URL_PATTERN_WHOLSALER_VIEW);
                foreach ($arrPattern as $key => $val)
                {
                    $varQueryString .= URL_PATTERN_SEPRATER . trim($argParam[$val]);
                }
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
        }
        else
        {
            $varQueryString = $argPageName;
            if ($argParam)
            {
                $varQueryString .='?';
                foreach ($argParam as $key => $val)
                {
                    $varQueryString .= '&' . $key . '=' . $val;
                }
            }
            $varLink = SITE_ROOT_URL . $varQueryString;
        }

        return $varLink;
    }

    /**
     *
     * Function Name : localDateTime
     *
     * Return type : Array
     *
     * Date created : 05th July 2013
     *
     * Date last modified :  05th July 2013
     *
     * Author : Rupesh Parmar
     *
     * Last modified by : Rupesh Parmar
     *
     * Comments : It takes two argument 1st is db date and 2nd is date format and return local date time .
     *
     * User instruction : $$objCore->localDateTime($argDate);
     *
     */
    function localDateTime($argDate, $argDateFormat)
    {

        if ($argDate == '' || $argDate == DATE_NULL_VALUE_DB || $argDate == DATE_TIME_NULL_VALUE_DB || $argDate == DATE_NULL_VALUE_SITE || $argDate == DATE_TIME_NULL_VALUE_SITE)
        {
            $varResult = DATE_NULL_VALUE_SITE;
        }
        else
        {
            $date = new DateTime($argDate, new DateTimeZone(DEFAULT_TIME_ZONE));

            if (isset($_SESSION['sessAdminTimeZone']) && $_SESSION['sessAdminTimeZone'] <> '')
            {
                $varTimeZone = $_SESSION['sessAdminTimeZone'];
            }
            else if (isset($_SESSION['sessTimeZone']) && $_SESSION['sessTimeZone'] <> '')
            {
                $varTimeZone = $_SESSION['sessTimeZone'];
            }
            else
            {
                $varTimeZone = DEFAULT_TIME_ZONE;
            }

            $date->setTimezone(new DateTimeZone($varTimeZone));

            $varResult = $date->format($argDateFormat);
        }
        return $varResult;
    }

    /**
     *
     * function serverDateTime
     *
     * This function is used to convert local time to default datetime.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 2 $string, $string
     *
     * @return string $varResult
     *
     */
    function serverDateTime($argDate, $argDateFormat)
    {

        if ($argDate == '' || $argDate == DATE_NULL_VALUE_DB || $argDate == DATE_TIME_NULL_VALUE_DB || $argDate == DATE_NULL_VALUE_SITE || $argDate == DATE_TIME_NULL_VALUE_SITE)
        {
            $varResult = DATE_NULL_VALUE_SITE;
        }
        else
        {
            if (isset($_SESSION['sessAdminTimeZone']) && $_SESSION['sessAdminTimeZone'] <> '')
            {
                $varTimeZone = $_SESSION['sessAdminTimeZone'];
            }
            else if (isset($_SESSION['sessTimeZone']) && $_SESSION['sessTimeZone'] <> '')
            {
                $varTimeZone = $_SESSION['sessTimeZone'];
            }
            else
            {
                $varTimeZone = DEFAULT_TIME_ZONE;
            }

            $date = new DateTime($argDate, new DateTimeZone($varTimeZone));

            $date->setTimezone(new DateTimeZone(DEFAULT_TIME_ZONE));

            $varResult = $date->format($argDateFormat);

            //echo $varResult;die;
        }
        return $varResult;
    }
    function convertproductweight($WeightUnit, $Weight) {
    
    	//     	$argWhr = "pkCustomerID='" . $varID . "' ";
    	//     	$arrClms = array('CustomerFirstName,CustomerLastName');
    	//     	$arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhr, $varOrder);
    	//     	return $arrRes;
    
    	$arrProduct['WeightUnit']=$WeightUnit;
    	$arrProduct['Weight']=$Weight;
    
    	if ($arrProduct['WeightUnit'] == 'g') { // 1000 Gram = 1 kg
    		$arrProduct['Weight'] = round($arrProduct['Weight'], 2) / 1000;
    	} else if ($arrProduct['WeightUnit'] == 'lb') { // 2.20462 Pound = 1 kg
    		$arrProduct['Weight'] = round($arrProduct['Weight'], 2) / round(2.20462, 2);
    	} else if ($arrProduct['WeightUnit'] == 'oz') { // 35.274 Ounce = 1 kg
    		$arrProduct['Weight'] = round($arrProduct['Weight'], 2) / round(35.274);
    	}
    	//$arrProduct['Weight'] = round($arrProduct['Weight'], 2);
    	$productweight=$this->floatNumber($arrProduct['Weight']);
    	return $productweight;
    }
    
   
    
    function floatNumber($number) {
    	$number_array = explode('.', $number);
    	$left = $number_array[0];
    	$right = $number_array[1];
    	//number_format($number, strlen($right));
    	if (strlen($right) > 4) {
    		return round($number, 3);
    	} else {
    		return round($number, strlen($right));
    	}
    }
    
    /**
     *
     *  Function Name : getPrice
     *
     *  Return type : String Price
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : This function return formated price with currency sign. It take two argument first is require and second is optional.
     *
     *  User instruction : obj->getPrice($arg1, $arg2='')
     *
     */
    function getPrice($argPrice)
    {
    	//echo $_SESSION['SiteCurrencyPrice'];
    	//unset($_SESSION['SiteCurrencyPrice']);
    	//echo ($_SESSION);
    	$varamt = $_SESSION['SiteCurrencyPrice'] * $argPrice;
    	$varPrice =  $this->price_format($varamt);
    
    	if ($varPrice < 0)
    	{
    		return "-" . $_SESSION['SiteCurrencySign']  . str_replace('-', '', $varPrice);
    	}
    	return $_SESSION['SiteCurrencySign']  .' '. $varPrice;
    }
    /**
     *
     * function localDateTimeSite
     *
     * This function is used to convert local time to default datetime.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 2 $string, $string
     *
     * @return string $varResult
     *
     */
    function localDateTimeSite($argDate, $argDateFormat)
    {

        if ($argDate == '' || $argDate == DATE_NULL_VALUE_DB || $argDate == DATE_TIME_NULL_VALUE_DB)
        {
            $varResult = DATE_NULL_VALUE_SITE;
        }
        else
        {
            $date = new DateTime($argDate, new DateTimeZone(DEFAULT_TIME_ZONE));

            if (isset($_SESSION['sessTimeZone']) && $_SESSION['sessTimeZone'] <> '')
            {
                $varTimeZone = $_SESSION['sessTimeZone'];
            }
            else
            {
                $varTimeZone = DEFAULT_TIME_ZONE;
            }

            $date->setTimezone(new DateTimeZone($varTimeZone));

            $varResult = $date->format($argDateFormat);
        }
        return $varResult;
    }

    /**
     *
     * Function Name : defaultDateTime
     *
     * Return type : Array
     *
     * Date created : 05th July 2013
     *
     * Date last modified :  05th July 2013
     *
     * Author : Rupesh Parmar
     *
     * Last modified by : Rupesh Parmar
     *
     * Comments : It takes two argument 1st is user date and 2nd is db date format and return Standard date time .
     *
     * User instruction : $$objCore->localDateTime($argDate);
     *
     */
    function defaultDateTime($argDate, $argDateFormat)
    {

        if ($argDate == '' || $argDate == DATE_NULL_VALUE_SITE || $argDate == DATE_TIME_NULL_VALUE_SITE)
        {
            $varResult = DATE_NULL_VALUE_DB;
        }
        else
        {

            if (isset($_SESSION['sessAdminTimeZone']) && $_SESSION['sessAdminTimeZone'] <> '')
            {
                $varTimeZone = $_SESSION['sessAdminTimeZone'];
            }
            else
            {
                $varTimeZone = DEFAULT_TIME_ZONE;
            }
            $date = new DateTime($argDate, new DateTimeZone($varTimeZone));

            $date->setTimezone(new DateTimeZone(DEFAULT_TIME_ZONE));

            $varResult = $date->format($argDateFormat);
        }
        return $varResult;
    }

    /**
     *
     * Function Name : getRefineArray
     *
     * Return type : Array
     *
     * Date created : 05th July 2013
     *
     * Date last modified : 05th July 2013
     *
     * Author : Rupesh Parmar
     *
     * Last modified by :Rupesh Parmar
     *
     * Comments : Generate indexed array and reset keys. It takes one argument as array.
     *
     * User instruction : $$objCore->getRefineArray($argArray);
     *
     */
    function getRefineArray(&$argArray)
    {

        $arrRefined = array();



        for ($i = 0; $i < count($argArray); $i++)
        {

            $varElement = trim($argArray[$i]);

            if ($varElement == "")
            {

                continue;
            }
            else
            {

                $arrRefined[count($arrRefined)] = $varElement;
            }
        }

        return $arrRefined;
    }

    /**
     *
     * Function Name : removeFrm
     *
     * Return type : string
     *
     * Date created : 05th July2013
     *
     * Date last modified : 05th July2013
     *
     * Author :  Rupesh Parmar
     *
     * Last modified by :  Rupesh Parmar
     *
     * Comments : Function will remove frm fromthe form fields.
     *
     * User instruction : obj->removeFrm($varFrm);
     *
     */
    function removeFrm($varFrm)
    {

        $strFrm = substr($varFrm, 3);

        return $strFrm;
    }

    /**
     *
     *  Function Name : sortQryStr
     *
     *  Return type : String
     *
     *  Date created : 05th July2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by : Rupesh Parmar
     *
     *  Comments : Generate Query String . It takes one argument as array and another is default.
     *
     *  obj->qryStr($arr);
     *
     *  User instruction : $objCore->sortQryStr($argArray, $skip);
     *
     */
    function sortQryStr($arr, $skip1 = '', $skip2 = '')
    {

        //$varConcatStr = "?";

        $i = 0;

        foreach ($arr as $key => $value)
        {

            if ($value == $skip1 || $value == $skip2)
            {

                continue;
            }

            $varConcatStr .= "&amp;$key=$value";

            $i = 1;
        }//end of outer foreach 



        return $varConcatStr;
    }

    /**
     *
     *  Function Name : getFrmQryStr
     *
     *  Return type : String
     *
     *  Date created : 05th July2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by : Rupesh Parmar
     *
     *  Comments : Generate Query String . It takes one argument as array and another is default.
     *
     *  obj->getFrmQryStr($arr);
     *
     *  User instruction : $objCore->getFrmQryStr($argArray, $skip);
     *
     */
    function getFrmQryStr($arr, $arrskip = array())
    {

        //$varConcatStr = "?";

        $i = 0;

        foreach ($arr as $key => $value)
        {

            if (in_array("$key", $arrskip))
            {

                continue;
            }



            if (preg_match('/btn/i', "$key"))
            {

                continue;
            }



            if ($value == '')
            {

                continue;
            }

            $varConcatStr .= "&amp;$key=$value";

            $i = 1;
        }//end of outer foreach 



        return $varConcatStr;
    }

    /**
     *
     *  Function Name : qryStr
     *
     *  Return type : String
     *
     *  Date created : 05th July2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by : Rupesh Parmar
     *
     *  Comments : Generate Query String . It takes one argument as array and another is default.
     *
     *  obj->qryStr($arr);
     *
     *  User instruction : $$objCore->getRefineArray($argArray);
     *
     */
    function qryStr($arr, $skip = '')
    {

        $varConcatStr = "?";

        $i = 0;

        foreach ($arr as $key => $value)
        {

            if ($key != $skip)
            {

                if (is_array($value))
                {

                    foreach ($value as $value2)
                    {

                        if ($i == 0)
                        {

                            $varConcatStr .= "$key%5B%5D=$value2";

                            $i = 1;
                        }
                        else
                        {

                            $varConcatStr .= "&amp;$key%5B%5D=$value2";
                        }
                    }//end of inner foreach
                }
                else
                {

                    if ($i == 0)
                    {

                        $varConcatStr .= "$key=$value";

                        $i = 1;
                    }
                    else
                    {

                        $varConcatStr .= "&amp;$key=$value";
                    }
                }
            }
        }//end of outer foreach 

        return $varConcatStr;
    }

    /**
     *
     *  Function Name : getQryStr
     *
     *  Return type : Array
     *
     *  Date created : 05th July 2013
     *
     *  Date last modified : 05th July 2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : Generate array for qryStr() function . It takes two argument as array.
     *
     *  obj->getQryStr($arr);
     *
     *  User instruction : getQryStr($arrOverWriteKey = array(), $arrOverWriteValue= array())
     *
     */
    function getQryStr($arrOverWriteKey = array(), $arrOverWriteValue = array())
    {



        $varGet = $_GET;



        if (is_array($arrOverWriteKey))
        {

            $i = 0;

            foreach ($arrOverWriteKey as $key)
            {

                $varGet[$key] = $arrOverWriteValue[$i];

                $i++;
            }
        }
        else
        {

            $varGet[$arrOverWriteKey] = $arrOverWriteValue;
        }

        $varQryStr = $this->qryStr($varGet);

        return $varQryStr;
    }

    /**
     *
     *  Function Name : removePrefix
     *
     *  Return type : string
     *
     *  Date created : 05th July 2013
     *
     *  Date last modified : 05th July 2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by : Rupesh Parmar
     *
     *  Comments : Function will remove frm from the form fields.
     *
     *  User instruction : $objCore->removeArrayFrmString($argArrFrm,$argStringNum);
     *
     */
    function removePrefix($arrFrm, $argStringNum)
    { //print_r($arrFrm);exit;
        if (count($arrFrm) > 0)
        {

            foreach ($arrFrm as $keyFrm => $valFrm)
            {

                $arrKeyFrm = substr($keyFrm, $argStringNum);

                $arrValFrm[$arrKeyFrm] = stripslashes($valFrm);
            }
        }

        //print_r($arrKeyFrm);exit;

        return $arrValFrm;
    }

    /**
     *
     *  Function Name : sendMail
     *
     *  Return type : None
     *
     *  Date created : 05th July 2013
     *
     *  Date last modified : 05th July 2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by : Rupesh Parmar
     *
     *  Comments : Send mail.
     *
     *  User instruction : $objCore->sendMail($argUserMail, $argfrom , $argSubject , $argMessage )
     *
     */
    function sendMail($argUserMail, $argfrom, $argSubject, $argMessage)
    {
        //echo "hi u mail";die;
        //set html header


        $varContact = $this->getUrl('contact.php');
        $argMessage = str_replace('{CONTACT_US_LINK}', $varContact, $argMessage);

        $varPath = '<a target="_blank" href="' . SITE_ROOT_URL . '"><img src="' . IMAGES_URL . 'logo.png" alt="' . SITE_NAME . '" style="margin-left:10px;"></a>';
        $youtube = '<a target="_blank" href="' . YOUTUBE_URL . '"><img alt="Youtube" src="' . IMAGES_URL . 'youtube.gif"></a>';
        $twitter = '<a target="_blank" href="' . TWITTER_URL . '"><img alt="Twitter" src="' . IMAGES_URL . 'twitter.gif"></a>';
        $facebook = '<a target="_blank" href="' . FACEBOOK_URL . '"><img alt="Facebook" src="' . IMAGES_URL . 'facebook.gif"></a>';
        $gplus = '<a target="_blank" href="' . GPLUS_URL . '"><img alt="Gplus" src="' . IMAGES_URL . 'gplus.gif"></a>';

        $varOutput = @file_get_contents(TEMPLATE_URL . 'index.html');

        $varKeyword = array('{SITE_NAME}', '{IMAGE_PATH}', '{YOUTUBE_URL}', '{TWITTER_URL}', '{FACEBOOK_URL}', '{GPLUS_URL}', '{INNER_CONTENT}');
        $varKeywordValues = array(SITE_NAME, $varPath, $youtube, $twitter, $facebook, $gplus, $argMessage);

        $argMessage = str_replace($varKeyword, $varKeywordValues, $varOutput);

        //echo $argMessage; die;

        $headers = "MIME-Version: 1.0 \r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
        $headers .= "From: " . $argfrom . " \r\n";
        return @mail($argUserMail, $argSubject, $argMessage, $headers);
        //require_once '../classes/class.phpmailer.php';
        //require_once CLASSES_PATH . 'class.phpmailer.php';
        
        //From Here
        //require CLASSES_PATH.'PHPMailerAutoload.php';
        //
        //$mail = new PHPMailer;
        //
        ////$mail->SMTPDebug = 3;                               // Enable verbose debug output
        //
        //$mail->isSMTP();                                      // Set mailer to use SMTP
        //$mail->Host = 'smtp.live.com';  // Specify main and backup SMTP servers
        //$mail->SMTPAuth = true;                               // Enable SMTP authentication
        //$mail->Username = 'telamela@telamela.com.au';                 // SMTP username
        //$mail->Password = 'Tela7890mela';                           // SMTP password
        //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        //$mail->Port = 25;       
        //$mail->From = 'info@telamela.com';
        //$mail->FromName = SITE_NAME;
        //$mailTo = $argUserMail;
        //$mail->addAddress($mailTo);     // Add a recipient
        //
        //$mail->isHTML(true);                                  // Set email format to HTML
        //
        //$mail->Subject = $argSubject;
        //$mail->Body    = $argMessage;
        //
        //if(!$mail->send()) {
        //    echo 'Message could not be sent.';
        //    echo 'Mailer Error: ' . $mail->ErrorInfo;
        //}
    }

    /**
     *
     *  Function Name : setDefaultCurrency
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
     *  Use instruction : obj->setDefaultCurrency()
     *
     */
    function setDefaultCurrency()
    {
        //echo 'test';die;
        //pre($_SESSION);
        global $oCache;
        $myIp = $this->getUserIpAddr(); //'103.14.127.74';
        //$myIp = '110.33.122.75';//australia
        //$myIp = '201.83.41.11';//Brazil
        $arrGeopluginCurrencyCode = md5($myIp);
        
        if ($oCache->bEnabled)
        {
            if (!$oCache->getData($arrGeopluginCurrencyCode))
            {
                $userIpDetails = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $myIp));
                $oCache->setData($arrGeopluginCurrencyCode, $userIpDetails);
            }
            else
            {
                //echo 'test';
                $userIpDetails = $oCache->getData($arrGeopluginCurrencyCode);
            }
        }
        else
        {
            
            $userIpDetails = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $myIp));
            //pre($userIpDetails);
        }
        
        $userCurrency = isset($userIpDetails['geoplugin_currencyCode']) ? $userIpDetails['geoplugin_currencyCode'] : 'USD'; //geoip_country_code_by_name($objComman->getRealIpAddr);
        //pre($userCurrency);
//        unset($_SESSION['SiteCurrencyCode']);
        //pre($_SESSION['SiteCurrencyCode']);
        if (!isset($_SESSION['SiteCurrencyCode']))
        {
            $this->setCurrency($userCurrency);
        }
        //pre($_SESSION);
        if (!isset($_SESSION['SiteCurrencyCountryID']))
        {   //die;
            $this->setCurrencyCountryID($userIpDetails['geoplugin_countryCode']);
        }
        //pre($_SESSION);
        //pre('12');
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
    function currencyList($argCurrencyCode = '')
    {
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
        return $arrCurrency;
    }

    function currencyListNew($argCurrencyCode = '')
    {
        $arrCurrency = array(
            'USD' => array('US&#36;', 'American Samoa', 'us'),
            'AED' => array('AED', 'United Arab Emirates', 'ae'),
            'ARS' => array('AR&#36;', 'Argentina', 'ar'),
            'AUD' => array('AU&#36;', 'Australia', 'au'),
            'BGN' => array('&#960;&Beta;', 'Bulgaria', 'bg'),
            'BOB' => array('Bs.', 'Bolivia', 'bo'),
            'BRL' => array('BR&#36;', 'Brazil', 'br'),
            'CAD' => array('CA&#36;', 'Canada', 'ca'),
            'CHF' => array('Fr', 'Switzerland', 'ch'),
            'CLP' => array('CL&#36;', 'Chile', 'cl'),
            'CNY' => array('&yen;', 'China', 'cn'),
            'COP' => array('CO&#36;', 'Colombia', 'co'),
            'CZK' => array('Kc', 'Czech Republic', 'cs'),
            'DKK' => array('kr', 'Faroe Islands', 'fo'),
            'EGP' => array('&pound;', 'Egypt', 'eg'),
            'EUR' => array('&euro;', 'Spain', 'es'),
            'GBP' => array('&pound;', 'Great Britain - UK', 'uk'),
            'HKD' => array('HK&#36;', 'Hong Kong', 'hk'),
            'HRK' => array('kn', 'Croatia', 'hr'),
            'HUF' => array('Ft', 'Hungary', 'hu'),
            'IDR' => array('Rp', 'Indonesia', 'id'),
            'ILS' => array('ILS', 'Israel', 'il'),
            'INR' => array('Rs.', 'India', 'in'),
            'JPY' => array('&yen;', 'Japan', 'jp'),
            'KRW' => array('W', 'South Korea', 'kr'),
            'KWD' => array('KWD', 'Kuwait', 'kw'),
            'LTL' => array('Lt', 'Lithuania', 'lt'),
            'MAD' => array('MAD', 'Morocco', 'ma'),
            'MXN' => array('MX&#36;', 'Bolivia', 'bo'),
            'MYR' => array('RM', 'Malaysia', 'my'),
            'NOK' => array('kr', 'Norway', 'no'),
            'NZD' => array('NZ&#36;', 'New Zealand', 'nz'),
            'PEN' => array('S.', 'Peru', 'pe'),
            'PHP' => array('P', 'Philippines', 'ph'),
            'PKR' => array('Rs.', 'Pakistan', 'pk'),
            'PLN' => array('z&iacute;', 'Poland', 'pl'),
            'RON' => array('L', 'Romania', 'ro'),
            'RSD' => array('din.', 'Serbia', 'rs'),
            'RUB' => array('p.', 'Soviet Union', 'ru'),
            'SAR' => array('SAR', 'Saudi Arabia', 'sa'),
            'SEK' => array('kr', 'Sweden', 'se'),
            'SGD' => array('SG&#36;', 'Singapore', 'sg'),
            'THB' => array('&Beta;', 'Thailand', 'th'),
            'TWD' => array('TW&#36;', 'Taiwan', 'tw'),
            'UAH' => array('&sect;', 'Ukraine', 'ua'),
            'VEF' => array('Bs', 'Venezuela', 've'),
            'VND' => array('VND', 'Vietnam', 'vn'),
            'ZAR' => array('R', 'South Africa', 'za'),
        );
        return $arrCurrency;
    }

    /**
     *
     *  Function Name : setCurrency
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
    function setCurrency($argCurrencyCode)
    {
        //print_r($argCurrencyCode);die;
        $db = new Database();
        $arrCurrencySign = $this->currencyList();
        //pre($arrCurrencySign);
        $from = 'USD to '.$argCurrencyCode;
        $from2 = 'USD/'.$argCurrencyCode;
        $where = "currencyToconvert like '%$from%' OR currencyToconvert like '%$from2%'";
        $varSelectedArray=array('currencyToconvert','currencyPrice');
        $varResult=$db->select(TABLE_CURRENCY_PRICE,$varSelectedArray,$where);
       
        if(count($varResult)>0){
            $_SESSION['SiteCurrencyCode'] = $argCurrencyCode;
            $_SESSION['SiteCurrencySign'] = $arrCurrencySign[$argCurrencyCode];
        }
//        echo '<pre>';
//        print_r($_SESSION);
//       echo  $to = $argCurrencyCode;
        
        //$_SESSION['SiteCurrencyCode'] = $argCurrencyCode;
        //$_SESSION['SiteCurrencySign'] = $arrCurrencySign[$argCurrencyCode];
        
        //make string to be put in API        
        //$google_url = "http://www.google.com/ig/calculator?hl=en&q=" . $string;     //Call Google API
        //$string = $from . $to;
        //$yahoo_url = 'http://download.finance.yahoo.com/d/quotes.csv?s=' . $string . '=X&f=nl1d1t1';
        //$result = file_get_contents($yahoo_url);
        //$result = explode(',', $result);

//        if ($result[1] > 0 && $result[2] <> 'N/A')
//        {
//            $_SESSION['SiteCurrencyCode'] = $argCurrencyCode;
//            $_SESSION['SiteCurrencySign'] = $arrCurrencySign[$argCurrencyCode];
//        }
    }
    
    
    function setCurrencyCountryID($argCurrencyCode)
    {
        //print_r($argCurrencyCode);die;
        $db = new Database();
        //$arrCurrencySign = $this->currencyList();
        //pre($arrCurrencySign);
        $from = $argCurrencyCode;
        $where = "iso_code_2 like '%$from%'";
        $varSelectedArray=array('country_id');
        $varResult=$db->select(TABLE_COUNTRY,$varSelectedArray,$where);
        //pre($varResult);
        if(count($varResult)>0){
            if(!empty($varResult[0]['country_id'])){
                $_SESSION['SiteCurrencyCountryID'] = $varResult[0]['country_id'];
            }else{
                $_SESSION['SiteCurrencyCountryID'] = 223;// Deault for United State
            }
            //$_SESSION['SiteCurrencySign'] = $arrCurrencySign[$argCurrencyCode];
        }
       
    }
    
    function setCurrencyForMob($argCurrencyCode)
    {
        $db = new Database();
        $arrCurrencySign = $this->currencyList();
        $from = 'USD to '.$argCurrencyCode;
        $from2 = 'USD/'.$argCurrencyCode;
        $where = "currencyToconvert like '%$from%' OR currencyToconvert like '%$from2%'";
        $varSelectedArray=array('currencyToconvert','currencyPrice');
        $varResult=$db->select(TABLE_CURRENCY_PRICE,$varSelectedArray,$where);
       
       if(count($varResult)>0){
            $currCode['currencyCode'] = $argCurrencyCode;
            $currCode['currencySign'] = $arrCurrencySign[$argCurrencyCode];
            $currCode['currencyPrice'] = $varResult[0]['currencyPrice'];
        }
        return $currCode;
    }
    function getCountrynamebyid($varID) {
    	//die("here");
    	$db = new Database();
    	$argWhr = "country_id='" . $varID . "' ";
    	$arrClms = array('name');
    	$arrRes = $db->select(TABLE_COUNTRY, $arrClms, $argWhr, $varOrder);
    	//pre($arrRes);
    	return $arrRes;
    }
    /**
     *
     *  Function Name : setCurrencyPrice
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
     *  Use instruction : obj->setCurrencyPrice($argCurrencyCode)
     *
     */
    function setCurrencyPrice($argCurrencyCode = '')
    {

        //$from = 'USD';
        //$to = $_SESSION['SiteCurrencyCode'];
        
        $db = new Database();
        $from = 'USD to '.$_SESSION['SiteCurrencyCode'];
        $from2 = 'USD/'.$_SESSION['SiteCurrencyCode'];
        $where = "currencyToconvert like '%$from%' OR currencyToconvert like '%$from2%'";
        //$where = "currencyToconvert like '%$from%'";
        $varSelectedArray=array('currencyToconvert','currencyPrice');
        $varResult=$db->select(TABLE_CURRENCY_PRICE,$varSelectedArray,$where);
        //pre($varResult);
        //make string to be put in API       
       // $string = $from . $to;
        //$yahoo_url = 'http://download.finance.yahoo.com/d/quotes.csv?s=' . $string . '=X&f=nl1d1t1';
        //$google_url = "http://www.google.com/ig/calculator?hl=en&q=" . $string;     //Call Google API

        //$result = file_get_contents($yahoo_url);                             //Get and Store API results into a variable      
        //$result = explode(',', $result);                                      //Explode result to convert into an array

        $converted_amount = (float) $varResult[0]['currencyPrice'];
        if ($converted_amount > 0)
        {
            $_SESSION['SiteCurrencyPrice'] = $converted_amount;
        }
           //print_r($_SESSION['SiteCurrencyPrice']);
    }

    /**
     *
     *  Function Name : getRawPrice
     *
     *  Return type : String Price
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : This function return formated price with currency sign. It take two argument first is require and second is optional.
     *
     *  User instruction : obj->getPrice($arg1, $arg2='')
     *
     */
    function getRawPrice($argPrice, $InUSD = '1')
    {
        if ($InUSD)
        {
            $varPrice = $argPrice / $_SESSION['SiteCurrencyPrice'];
        }
        else
        {
            $varPrice = $argPrice * $_SESSION['SiteCurrencyPrice'];
        }
        return round($varPrice, 2);
    }

    
    
    /**
     *
     *  Function Name : getProductCalCurrencyPrice
     *
     *  Return type : String Price
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : This function return formated price with currency sign. It take two argument first is require and second is optional.
     *
     *  User instruction : obj->getPrice($arg1, $arg2='')
     *
     */
    function getProductCalCurrencyPrice($argPrice)
    {
        //echo $_SESSION['SiteCurrencyPrice']* 25.25*2;
        //echo $_SESSION['SiteCurrencyPrice'].'==='.$argPrice;
       
        $varamt = $_SESSION['SiteCurrencyPrice'] * $argPrice;
        $varPrice = $this->price_format($varamt);
        if ($varPrice < 0)
        {
            return "-" . str_replace('-', '', $varPrice);
        }
        return $varPrice;
    }

    /**
     * function getFinalPrice
     *
     * This function is used to get quick view Details.
     *
     * @access public
     *
     * @parameters 4 $productPrice, $discountPrice, $specialPrice, $isShowStrike
     *
     * @return string $varStr
     */
    function getFinalPrice($pPrice, $dPrice = 0, $sPrice = 0, $isOnlyPrice = 0, $isShowStrike = 0)
    {

        $varStr = '';

        if ($isOnlyPrice)
        {
            if ($sPrice > 0)
            {
                $varStr = $sPrice;
            }
            else if ($dPrice > 0)
            {
                $varStr = $dPrice;
            }
            else
            {
                $varStr = $pPrice;
            }
        }
        else
        {
            if ($sPrice > 0)
            {
                if ($isShowStrike)
                {
                    $varStr = '<small>' . $this->getPrice($pPrice) . '</small>';
                }
                $varStr .= '<strong> ' . $this->getPrice($sPrice) . '</strong>';
            }
            else if ($dPrice > 0)
            {
                if ($isShowStrike)
                {
                    $varStr = '<small>' . $this->getPrice($pPrice) . '</small>';
                }
                $varStr .= '<strong> ' . $this->getPrice($dPrice) . '</strong>';
            }
            else
            {
                $varStr = '<strong> ' . $this->getPrice($pPrice) . '</strong>';
            }
        }


        return $varStr;
    }

    /**
     * function getFinalPriceWithOffer
     *
     * This function is used to get get Final Price With Offer.
     *
     * @access public
     *
     * @parameters 4 $productPrice, $discountPrice, $specialPrice
     *
     * @return string $varStr
     */
    function getFinalPriceWithOffer($pPrice, $dPrice = 0, $sPrice = 0)
    {

        $arrPrice = array();


        if ($sPrice > 0)
        {
            $price = $this->getPrice($sPrice);
            $off = (($pPrice - $sPrice) / $pPrice) * 100;
        }
        else if ($dPrice > 0)
        {
            $price = $this->getPrice($dPrice);
            $off = (($pPrice - $dPrice) / $pPrice) * 100;
        }
        else
        {
            $price = $this->getPrice($pPrice);
            $off = 0;
        }

        $arrPrice['off'] = round($off);
        $arrPrice['price'] = $price;


        return $arrPrice;
    }

    /**
     *
     *  Function Name : getPoints
     *
     *  Return type : String Price
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : This function return formated points. It take two argument first is require and second is optional.
     *
     *  User instruction : obj->setPriceFormat($arg1, $arg2='')
     *
     */
    function getPoints($argPrice)
    {
        return $this->price_format($argPrice); 
    }

    /**
     *
     *  Function Name : getProductName
     *
     *  Return type : String Price
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : This function return formated price with currency sign. It take two argument first is require and second is optional.
     *
     *  User instruction : obj->setPriceFormat($arg1, $arg2='')
     *
     */
    function getProductName($val = '', $length = 0)
    {
        $val = ucfirst(trim(html_entity_decode($val)));
        if (strlen($val) > $length)
        {
            $varStr = substr($val, 0, $length) . ' ..';
        }
        else
        {
            $varStr = $val;
        }

        return $varStr;
    }

    /**
     *
     *  Function Name : getImageUrl
     *
     *  Return type : String Price
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : This function return formated price with currency sign. It take two argument first is require and second is optional.
     *
     *  User instruction : obj->getImageUrl($arg1, $arg2='')
     *
     */
    function getImageUrl($name = '', $path = '')
    { //echo $name;echo $path;
        $name = ($name == '') ? 'default.jpg' : $name;
        $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/' . $path . '/' . $name;
        //echo file_exists($varImgPath);
        $nm = file_exists($varImgPath) ? $name : 'default.jpg';
        $varImgUrl = UPLOADED_FILES_URL . 'images/' . $path . '/' . $nm;
        return $varImgUrl;
    }

    /**
     *
     *  Function Name : getvalidImage
     *
     *  Return type : String Price
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : This function return formated price with currency sign. It take two argument first is require and second is optional.
     *
     *  User instruction : obj->getvalidImage($arg1, $arg2='')
     *
     */
    function getvalidImage($attributeImage = '', $productImage = '', $path = '')
    {
        if ($attributeImage == '')
        {
            $img = $productImage;
        }
        else
        {
            $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/' . $path . '/' . $attributeImage;
            $img = file_exists($varImgPath) ? $attributeImage : $productImage;
        }
        //pre($img);
        return $img;
    }

    /**
     *
     *  Function Name : getDisputedCommentArray
     *
     *  Return type : String Price
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : This function return formated price with currency sign. It take two argument first is require and second is optional.
     *
     *  User instruction : obj->getDisputedCommentArray($arg1, $arg2='')
     *
     */
    function getDisputedCommentArray()
    {
        $arrRow = array(
            'Q1' => 'What type of problem would you like to address?',
            'A11' => 'I have a problem with an item I purchased.',
            'A12' => 'I want to report a transaction that I didn\'t authorize.',
            'Q11' => 'I\'m opening this dispute because ?',
            'A111' => '',
            //'A111' => 'I haven\'t received my item.',
            //'A112' => 'I received my item, but it is significantly not as described.',
            'Q12' => 'Additional reason to support the case',
            'A121' => '',
            'Q21' => 'Please indicate which unauthorized changes, if any, were made to your account.',
            'A211' => 'Password',
            'A212' => 'Security questions & answers',
            'A213' => 'Email address',
            'A214' => 'Shipping address',
            'A215' => 'Phone numbers',
            'A216' => 'Upgraded to Business or Premier account',
            'A217' => 'Credit cards added',
            'A218' => 'Bank accounts added',
            'A219' => 'Other',
            'Q22' => 'Have you changed your password since this happened?',
            'A221' => 'Yes',
            'A222' => 'No',
            'Q23' => 'Have you changed your security questions since this happened?',
            'A231' => 'Yes',
            'A232' => 'No',
            'Q24' => 'Additional reason to support the case',
            'A241' => ''
        );

        return $arrRow;
    }

    /**
     *
     *  Function Name : getFileName
     *
     *  Return type : String  file name
     *
     *  Date created : 05th July2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by : Rupesh Parmar
     *
     *  Comments : This function return file name.
     *
     *  User instruction : obj->getFileName($argPath)
     *
     */
    function getFileName($argPath)
    {

        $varFileName = substr(strrchr($_SERVER['HTTP_REFERER'], "/"), 1);



        return $varFileName;
    }

//end of function

    /**
     *
     *  Function Name : creditDateFormat
     *
     *  Return type : String.
     *
     *  Date created : 05th July2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :  Rupesh Parmar
     *
     *  Last modified by : Rupesh Parmar
     *
     *  Comments : This function return formated  date. It take two argument first is require and second is optional.
     *
     *  User instruction : $objCore->creditDateFormat($argDate, $argFormat = 'us', $argSeperator = '-')
     *
     */
    function creditDateFormat($date, $displayLength = 'short', $format = 'us', $seperator = '-')
    {

        if ($displayLength == 'short')
        {

            $arrMonth = $this->arrMonthShort;
        }
        else
        {

            $arrMonth = $this->arrMonthFull;
        }



        if (strlen($date) >= 6)
        {

            if ($date == '0000-00')
            {

                return 'N/A';
            }
            else
            {

                if (strtolower($format) == 'us')
                {

                    return $arrMonth[substr($date, 5, 2) - 1] . ', ' . substr($date, 0, 4);
                }
                else if (strtolower($format) == 'eu')
                {



                    return substr($date, 5, 2) . $seperator . substr($date, 0, 4);
                }
            }
        }
        else
        {

            return $s;
        }
    }

    /**
     *
     *  Function Name : setSuccessMsg
     *
     *  Return type : None
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July 2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : Pass any message and set session for this message.
     *
     *  User instruction : $objCore->setSuccessMsg($argSessMsg)
     *
     */
    function setSuccessMsg($sessMsg)
    {

        if ($sessMsg == "")
        {
            $_SESSION['sessMsg'] = '';
        }
        else
        {
            $_SESSION['sessMsg'] = '<div class="success">' . $sessMsg . '</div>';
        }
    }
function setMultipleSuccessMsg($varUpdateCategoryOrder)
    {
    $messs = '';
    if(!empty($varUpdateCategoryOrder['success']))
    {
    foreach($varUpdateCategoryOrder['success']as $val)
    {
       $messs .= '<div class="success"> This Order No. '. $val . ' Update successfully</div>'; 
    }
    }
    if(!empty($varUpdateCategoryOrder['error']))
    {
    foreach($varUpdateCategoryOrder['error']as $val)
    {
       $messs .= '<div class="error"> This Order No. '. $val . '  Already Exists</div>'; 
    }
    }
     $_SESSION['sessMsg'] = $messs;

//        if ($sessMsg == "")
//        {
//            $_SESSION['sessMsg'] = '';
//        }
//        else
//        {
//            $_SESSION['sessMsg'] = '<div class="success">' . $sessMsg . '</div>';
//        }
    }

    /**
     *
     *  Function Name : setErrorMsg
     *
     *  Return type : None
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July 2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : Pass any message and set session for this message.
     *
     *  User instruction : $objCore->setErrorMsg($argSessMsg)
     *
     */
    function setErrorMsg($sessMsg)
    {

        if ($sessMsg == "")
        {
            $_SESSION['sessIsError'] = '';
            $_SESSION['sessMsg'] = '';
        }
        else
        {
            //echo "hh";die;
            $_SESSION['sessIsError'] = 'yes';
            $_SESSION['sessMsg'] = '<div class="error" style="border:none!important; float:none; display:block;">' . $sessMsg . '</div>';
        }
    }

    /**
     *
     *  Function Name : setUploadErrorMsg
     *
     *  Return type : None
     *
     *  Date created :19th September 2013
     *
     *  Date last modified : 19th September 2013
     *
     *  Author : Vipin Tomar
     *
     *  Last modified by :Vipin Tomar
     *
     *  Comments : Pass any message and set session for this message.
     *
     *  User instruction : $objCore->setUploadErrorMsg($argSessMsg)
     *
     */
    function setUploadErrorMsg($sessMsg)
    {

        if ($sessMsg == "")
        {
            $_SESSION['sessIsError'] = '';
            $_SESSION['sessMsg'] = '';
        }
        else
        {
            //echo "hh";die;
            $_SESSION['sessIsError'] = 'yes';
            $_SESSION['sessMsg'] .= '<div class="error" style="border:none!important; float:none; display:block;">' . $sessMsg . '</div>';
        }
    }

    /**
     *
     *  Function Name : displaySessMsg
     *
     *  Return type : None
     *
     *  Date created : 05th July2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :  Rupesh Parmar
     *
     *  Last modified by : Rupesh Parmar
     *
     *  Comments : Display sessage message.
     *
     *  User instruction : $$objCore->displaySessMsg()
     *
     */
    function displaySessMsg()
    {
        return $_SESSION['sessMsg'];
    }

    /**
     *
     *  Function Name : prepareStringValue
     *
     *  Return type : Value of variable
     *
     *  Date created : 05th July2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by : Rupesh Parmar
     *
     *  Comments : This is used to return a variable's value with adding slashes and remove spaces properly.
     *
     */
    function prepareStringValue($value)
    {

        $new_value = (!get_magic_quotes_gpc()) ? addslashes($value) : $value;

        $new_value = ($value != "") ? trim($value) : "";

        return $new_value;
    }

    /**
     *
     *  Function Name : generateUniqueID
     *
     *  Return type : integer
     *
     *  Date created : 05th July 2013
     *
     *  Date last modified : 05th July 2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : This function to generate unique ID.
     *
     *  User instruction : obj->generateUniqueID()
     *
     */
    function generateUniqueID()
    {

        return md5(uniqid(rand(), true));
    }

    /**
     *
     *  Function name : export_delimited_file
     *
     *  Return type : void
     *
     *  Date created : 14th june 2013
     *
     *  Date last modified : 26th july 2013
     *
     *  Author : Ashok Singh Negi
     *
     *  Last modified by : Viney Goel
     *
     *  Comments : function to export data from database to a comma separated file.
     *
     *  User instruction : $objCore->export_delimited_file($sql, $arr_columns, $file_name, $ext)
     *
     */
    function export_delimited_file($sql, $arr_columns, $file_name, $ext)
    {

        if ($ext == "csv")
            $sep = ",";

        else
            $sep = "\t";

        $fileName = $file_name . time() . "." . $ext;





        header("Content-type: application/txt");

        header("Content-disposition: attachment; filename=$fileName");

        header("Pragma: no-cache");

        header("Expires: 0");



        $finalHeader = '';

        $arr_headers = array();

        $arr_headers = array_values($arr_columns);

        $num_cols = count($arr_columns);

        foreach ($arr_headers as $header)
        {

            echo $header . $sep;
        }



        $result = $this->executeQuery($sql);

        $i = 0;

        while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
        {

            echo "\r\n";

            $i++;

            echo $i . $sep;

            foreach ($line as $key => $value)
            {

                $value = str_replace("\n", "", $value);

                $value = str_replace("\r", "", $value);

                $value = str_replace($sep, "", $value);

                if (is_array($arr_substitutes[$key]))
                {

                    $value = $arr_substitutes[$key][$value];
                }

                if (isset($arr_tpls[$key]))
                {

                    $code = str_replace('{1}', $value, $arr_tpls[$key]);

                    eval("\$value = $code;");
                }

                echo $value . $sep;
            }
        }
    }

    /**
     *
     *  Function name : getThumbImageName
     *
     *  Return type : void
     *
     *  Date created : 14th june 2013
     *
     *  Date last modified : 26th july 2013
     *
     *  Author : Ashok Singh Negi
     *
     *  Last modified by : Viney Goel
     *
     *  Comments : function to export data from database to a comma separated file.
     *
     *  User instruction : $objCore->getThumbImageName($sql, $arr_columns, $file_name, $ext)
     *
     */
    function getThumbImageName($argImageName)
    {

        //Get file extention	

        if ($argImageName != '')
        {

            $varExt = substr(strrchr($argImageName, "."), 1);



            $varImageFileName = substr($argImageName, 0, -(strlen($varExt) + 1));

            if ($varExt == 'jpeg')
            {
                $varExt = 'jpg';
            }

            //Create thumb file name

            $varImageNameThumb = $varImageFileName . '_thumb.' . $varExt;
        }

        return $varImageNameThumb;
    }

    /**
     *
     *  Function name :  executeQuery
     *
     *  Return type : void
     *
     *  Date created : 14th june 2013
     *
     *  Date last modified : 26th july 2013
     *
     *  Author : Ashok Singh Negi
     *
     *  Last modified by : Viney Goel
     *
     *  Comments : function to execute query.Normal sql query wiil be passed as an argument.
     *
     *  User instruction : $objCore->executeQuery($sql)
     *
     */
    function executeQuery($sql)
    {

        return mysql_query($sql);
    }

    /**
     *
     *  Function Name : datetime_format
     *
     *  Return type : string
     *
     *  Date created : 25th October 2013
     *
     *  Date last modified : 27 july 2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by : Viney Goel
     *
     *  Comments : This function return formated Date.
     *
     */
    function datetime_format($date, $format = 'us', $seperator = '-')
    {

        global $arr_month_short;



        $arr_month = Array('All', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

        $arr_month_short = Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');



        if (strlen($date) > 10)
        {

            if ($date == '0000-00-00' || $date == '0000-00-00 00:00:00')
            {

                return 'N/A';
            }
            else
            {

                $hour = substr($date, 11, 2);

                if ($hour > 11)
                {

                    $ampm = "PM";

                    $hour -= 12;
                }
                else
                {

                    $ampm = "AM";
                }



                if ($hour == 0)
                {

                    $hour = 12;
                }

                $hour = str_pad($hour, 2, "0", STR_PAD_LEFT);

                if (strtolower($format) == 'us')
                {

                    return $arr_month_short[substr($date, 5, 2) - 1] . ' ' . substr($date, 8, 2) . ', ' . substr($date, 0, 4) . ' ' . $hour . ':' . substr($date, 14, 2) . ' ' . $ampm;
                }
                else if (strtolower($format) == 'eu')
                {

                    return substr($date, 8, 2) . $seperator . substr($date, 5, 2) . $seperator . substr($date, 0, 4) . ' ' . $hour . ':' . substr($date, 14, 2) . ' ' . $ampm;
                }
            }
        }
        else
        {

            if ($date == '0000-00-00' || $date == '0000-00-00 00:00:00')
            {

                return 'N/A';
            }
            else
            {

                if (strtolower($format) == 'us')
                {



                    return $arr_month_short[substr($date, 5, 2) - 1] . ' ' . substr($date, 8, 2) . ', ' . substr($date, 0, 4) . '';
                }
                else if (strtolower($format) == 'eu')
                {

                    return substr($date, 8, 2) . $seperator . substr($date, 5, 2) . $seperator . substr($date, 0, 4) . ' ';
                }
            }
        }
    }

//end of function
    /**
     *
     *  Function Name : getActiveInactiveImage
     *
     *  Return type : string
     *
     *  Date created : 25th October 2013
     *
     *  Date last modified : 27 july 2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by : Viney Goel
     *
     *  Comments : This function return formated Date.
     *
     */
    function getActiveInactiveImage($argStatus)
    {

        if ($argStatus == 'Active')
        {

            $arrImage['name'] = 'active.jpg';

            $arrImage['alt'] = 'Active';
        }
        else
        {

            $arrImage['name'] = 'deactive.jpg';

            $arrImage['alt'] = 'Inactive';
        }



        return $arrImage;
    }

//end function
    /**
     *
     *  Function Name : getModelType
     *
     *  Return type : string
     *
     *  Date created : 25th October 2013
     *
     *  Date last modified : 27 july 2013
     *
     *  Author : Rupesh Parmar
     *
     *  Last modified by : Viney Goel
     *
     *  Comments : This function return formated Date.
     *
     */
    function getModelType($argStatus)
    {

        if ($argStatus == 'Model')
        {

            $arrModelImage['name'] = 'model.gif';

            $arrModelImage['alt'] = 'Model';
        }
        else
        {

            $arrModelImage['name'] = 'training.gif';

            $arrModelImage['alt'] = 'In Training';
        }



        return $arrModelImage;
    }

//end function

    /**
     *
     *  Function Name: getDefaultLang
     *
     *  Return type: Array
     *
     *  Date created: 19th March 2013
     *
     *  Date last modified: 19th March 2013
     *
     *  Author: Ashok Singh Negi
     *
     *  Last modified by: Ashok Singh Negi
     *
     *  Comments: This function is used to return default language.
     *
     *  User instruction: $objCore->getDefaultLang();
     *
     */
    function getDefaultLang()
    {

        if ($_COOKIE['cook_lang'] == '')
        {

            $varCookLang = 'english';

            setcookie('cook_lang', 'english', time() + 60 * 60 * 24 * 265);
        }
        else
        {

            $varCookLang = $_COOKIE['cook_lang'];
        }

        return $varCookLang;
    }

    /**
     *
     *  Function Name : setDefaultLanguage
     *
     *  Return type : Array
     *
     *  Date created : 19th March 2013
     *
     *  Date last modified : 19th March 2013
     *
     *  Author :  Ashok Singh Negi
     *
     *  Last modified by : Ashok Singh Negi
     *
     *  Comments : This function is used to set language of the site.
     *
     *  User instruction : $objCore->setDefaultLanguage($argArrPost);
     *
     */
    function setDefaultLanguage($argArrPost)
    {

        $varCookLang = $argArrPost['Language'];

        setcookie('cook_lang', $varCookLang, time() + 60 * 60 * 24 * 265);



        if ($_COOKIE['cook_lang'] == '')
        {

            $varCookLang = 'english';

            setcookie('cook_lang', 'english', time() + 60 * 60 * 24 * 265);
        }
        else
        {

            $varCookLang = $_COOKIE['cook_lang'];
        }

        return $varCookLang;
    }

    /**
     *
     *  Function Name : generateValidateString
     *
     *  Return type : void
     *
     *  Date created : 29th Oct 2013
     *
     *  Date last modified : 28th November 2013
     *
     *  Author : Ashok Singh Negi
     *
     *  Last modified by : Ashok Singh Negi
     *
     *  Comments : This function return html validate string
     *
     *  User instruction : obj->generateValidateString($varQryStr)
     *
     */
    function generateValidateString($varQryStr, $skip = '')
    {

        $varQryStr = str_replace('?&page', '?page', $varQryStr);

        $varQryStr = str_replace('&page', '&amp;page', $varQryStr);

        $varQryStr = str_replace('&', '&amp;', $varQryStr);

        $varQryStr = str_replace('&amp;amp;', '&amp;', $varQryStr);



        if (ereg('^(&amp;|&)', $varQryStr))
        {

            $varQryStr = ereg_replace('(&amp;|&){1,}', '', $varQryStr);
        }



        if (trim($skip) != '')
        {

            $varQryStr = ereg_replace('(' . $skip . ')=[0-9]{1,}(&amp;)|(' . $skip . ')=[0-9]{1,}(&)|(' . $skip . ')=[0-9]{1,}', '', $varQryStr);

            $varQryStr = ereg_replace('(' . $skip . ')=[a-zA-Z_\.]{1,}(&amp;)|(' . $skip . ')=[a-zA-Z_\.]{1,}(&)|(' . $skip . ')=[a-zA-Z_\.]{1,}', '', $varQryStr);



            //$varQryStr = trim($varQryStr, '&amp;');

            $varQryStr = trim($varQryStr, '&');
        }

        //echo $varQryStr;

        return $varQryStr;
    }

    /**
     *
     *  Function Name: addPrefix($arrFrm, $argPrefix)
     *
     *  Return type: array
     *
     *  Date created: 25th March 2013
     *
     *  Date last modified: 25th March 2013
     *
     *  Author: Ashok Singh Negi
     *
     *  Last modified by: Ashok Singh Negi
     *
     *  Comments: Function will add prefix in the array key of associative array.
     *
     *  User instruction: $objCore->addPrefix($arrFrm, $argPrefix)
     *
     */
    function addPrefix($arrFrm, $argPrefix = '')
    {

        if (count($arrFrm) > 0)
        {

            foreach ($arrFrm as $keyFrm => $valFrm)
            {

                $arrKeyFrm = $argPrefix . $keyFrm;

                $arrValFrm[$arrKeyFrm] = $valFrm;
            }
        }

        return $arrValFrm;
    }

    /**
     *
     *  Function Name: getDate($arrFrm, $argPrefix)
     *
     *  Return type: array
     *
     *  Date created: 25th March 2013
     *
     *  Date last modified: 25th March 2013
     *
     *  Author: Ashok Singh Negi
     *
     *  Last modified by: Ashok Singh Negi
     *
     *  Comments: Function will add prefix in the array key of associative array.
     *
     *  User instruction: $objCore->getDate($arrFrm, $argPrefix)
     *
     */
    function getDate($argVarOption = '')
    {

        if ($argVarOption != '')
        {

            $varDateTime = date("Y-m-d");
        }
        else
        {

            $varDateTime = date("Y-m-d H:i:s");
        }

        return $varDateTime;
    }

    function isFloat($n)
    {

        return ( $n == strval(floatval($n)) ) ? true : false;
    }

    /**
     *
     *  Function Name: birthday($arrFrm, $argPrefix)
     *
     *  Return type: array
     *
     *  Date created: 11 Nov 2013
     *
     *  Date last modified:
     *
     *  Author: Prashant Kumar
     *
     *  Last modified by:
     *
     *  Comments: Function will get the current age.
     *
     *  User instruction: $objCore->birthday($arrFrm, $argPrefix)
     *
     */
    function birthday($birthday)
    {

        list($month, $day, $year) = explode("/", $birthday);

        $year_diff = date("Y") - $year;

        $month_diff = date("m") - $month;

        $day_diff = date("d") - $day;

        if ($month_diff < 0)
            $year_diff--;

        elseif (($month_diff == 0) && ($day_diff < 0))
            $year_diff--;

        return $year_diff;
    }

    /**
     *
     *  Function Name: trimUnicodeString($arrFrm, $argPrefix)
     *
     *  Return type: array
     *
     *  Date created: 11 Nov 2013
     *
     *  Date last modified:
     *
     *  Author: Prashant Kumar
     *
     *  Last modified by:
     *
     *  Comments: Function will get the current age.
     *
     *  User instruction: $objCore->trimUnicodeString($argVarUnicodeString, $argVarStringLength)
     *
     */
    function trimUnicodeString($argVarUnicodeString, $argVarStringLength)
    {
        //relace all the &amp; into &

        $argVarUnicodeString = preg_replace('/\&amp\;/', '&', $argVarUnicodeString);
        $varReturnString = '';
        //check whether any unicode character exists in the string
        if (preg_match('/(\&\#[0-9]+\;)/si', $argVarUnicodeString))
        {
            //explode the unicode string from ;
            $arrUnicodeString = explode(';', $argVarUnicodeString);
            $varUnicodeString = '';
            foreach ($arrUnicodeString as $key => $varValue)
            {
                if ($argVarStringLength <= 0)
                {
                    $varReturnString .= '...';
                    break;
                }

                if ($varValue != '')
                {
                    $varValue = $varValue . ';';
                    preg_match_all('/(\&\#[0-9]+\;)/si', $varValue, $result, PREG_PATTERN_ORDER);
                    $result = $result[0];
                    $varUnicodeCharsFound = count($result);

                    $varNormalCharsFound = strlen(preg_replace('/(\&\#[0-9]+\;)/si', '', $varValue));
                    if (($varNormalCharsFound + $varUnicodeCharsFound) <= $argVarStringLength)
                    {
                        $varReturnString .= $varValue;
                    }
                    else
                    {
                        $varReturnString .= substr($varValue, 0, $argVarStringLength);
                    }
                    $argVarStringLength = $argVarStringLength - ($varNormalCharsFound + $varUnicodeCharsFound);

                    //create something
                }
                else
                {
                    $varReturnString .= $varValue;
                    $argVarStringLength = $argVarStringLength - strlen($varValue);
                }
            }
        }
        else
        {
            $varReturnString = substr($argVarUnicodeString, 0, $argVarStringLength);
            if (strlen($argVarUnicodeString) > $argVarStringLength)
            {
                $varReturnString .= '...';
            }
        }
        if (substr($varReturnString, (strlen($varReturnString) - 1), 1) == ';')
        {
            return rtrim($varReturnString, ';');
        }
        else
        {
            return $varReturnString;
        }
    }

    /**
     *
     *  Function Name: getFormatedCharacters()
     *
     *  Return type: array
     *
     *  Date created: 06 Nov 2013
     *
     *  Date last modified: 06 Nov 2013
     *
     *  Author: Prashant Kumar
     *
     *  Last modified by: Shardendu Singh
     *
     *  Comments: Function will replace all the special characters into unicode to store into database, so that it can displayed on browser propely.
     *
     *  User instruction: $objCore->getFormatedCharacters($arrFrm, $argPrefix)
     *
     */
    function getFormatedCharacters($argStr)
    {
        //$argStr = '�';//exit;// = 'C�Њ�C� �';
        $arrUnicodeCharacters = array(
            '�' => '&#192;', '�' => '&#193;', '�' => '&#194;', '�' => '&#195;', '�' => '&#196;', '�' => '&#197;',
            '�' => '&#200;', '�' => '&#201;', '�' => '&#202;', '�' => '&#203;', '�' => '&#204;', '�' => '&#205;',
            '�' => '&#206;', '�' => '&#207;', '�' => '&#208;', '�' => '&#209;', '�' => '&#210;', '�' => '&#211;',
            '�' => '&#212;', '�' => '&#213;', '�' => '&#214;', '�' => '&#216;', '�' => '&#217;', '�' => '&#218;',
            '�' => '&#219;', '�' => '&#220;', '�' => '&#221;', '�' => '&#222;', '�' => '&#223;', '�' => '&#223;',
            '�' => '&#224;', '�' => '&#225;', '�' => '&#226;', '�' => '&#227;', '�' => '&#228;', '�' => '&#229;',
            '�' => '&#230;', '�' => '&#231;', '�' => '&#232;', '�' => '&#233;', '�' => '&#234;', '�' => '&#235;',
            '�' => '&#236;', '�' => '&#237;', '�' => '&#238;', '�' => '&#239;', '�' => '&#240;', '�' => '&#241;',
            '�' => '&#242;', '�' => '&#243;', '�' => '&#244;', '�' => '&#245;', '�' => '&#246;', '�' => '&#247;',
            '�' => '&#248;', '�' => '&#249;', '�' => '&#250;', '�' => '&#251;', '�' => '&#252;', '�' => '&#253;',
            '�' => '&#254;', '�' => '&#255;', '�' => '&#338;', '�' => '&#339;', '�' => '&#352;', '�' => '&#353;',
            '�' => '&#376;', 'F' => '&#934;', '?' => '&#936;', 'O' => '&#937;', 'a' => '&#945;', '�' => '&#946;',
            '?' => '&#947;', 'd' => '&#948;', 'e' => '&#949;', '?' => '&#950;', '?' => '&#951;', '?' => '&#952;',
            '?' => '&#953;', '?' => '&#954;', 'C' => '&#262;', 'c' => '&#263;', 'C' => '&#268;', 'c' => '&#269;',
            '�' => '&#272;', 'd' => '&#273;', '�' => '&#352;', '�' => '&#353;', '�' => '&#381;', '�' => '&#382;',
            '�' => '&#165;');

        if ($arrUnicodeCharacters)
        {
            foreach ($arrUnicodeCharacters as $varLangCharKey => $varLangCharValue)
            {
                //echo $argStr;die;
                if (strstr($argStr, $varLangCharKey))
                {
                    $argStr = str_replace($varLangCharKey, $varLangCharValue, $argStr);
                }
            }
        }
        return $argStr;
    }

    /**
     *
     *  Function Name: getFormatedCharactersWithoutUnicode()
     *
     *  Return type: array
     *
     *  Date created: 06 Nov 2013
     *
     *  Date last modified: 06 Nov 2013
     *
     *  Author: Prashant Kumar
     *
     *  Last modified by: Shardendu Singh
     *
     *  Comments: Function will replace all the special characters into unicode to store into database, so that it can displayed on browser propely.
     *
     *  User instruction: $objCore->getFormatedCharactersWithoutUnicode($argVarInputString)
     *
     */
    function getFormatedCharactersWithoutUnicode($argVarInputString)
    {
        $arrUnicodeCharacters = array(
            '�' => '&#192;', '�' => '&#193;', '�' => '&#194;', '�' => '&#195;', '�' => '&#196;', '�' => '&#197;',
            '�' => '&#200;', '�' => '&#201;', '�' => '&#202;', '�' => '&#203;', '�' => '&#204;', '�' => '&#205;',
            '�' => '&#206;', '�' => '&#207;', '�' => '&#208;', '�' => '&#209;', '�' => '&#210;', '�' => '&#211;',
            '�' => '&#212;', '�' => '&#213;', '�' => '&#214;', '�' => '&#216;', '�' => '&#217;', '�' => '&#218;',
            '�' => '&#219;', '�' => '&#220;', '�' => '&#221;', '�' => '&#222;', '�' => '&#223;', '�' => '&#223;',
            '�' => '&#224;', '�' => '&#225;', '�' => '&#226;', '�' => '&#227;', '�' => '&#228;', '�' => '&#229;',
            '�' => '&#230;', '�' => '&#231;', '�' => '&#232;', '�' => '&#233;', '�' => '&#234;', '�' => '&#235;',
            '�' => '&#236;', '�' => '&#237;', '�' => '&#238;', '�' => '&#239;', '�' => '&#240;', '�' => '&#241;',
            '�' => '&#242;', '�' => '&#243;', '�' => '&#244;', '�' => '&#245;', '�' => '&#246;', '�' => '&#247;',
            '�' => '&#248;', '�' => '&#249;', '�' => '&#250;', '�' => '&#251;', '�' => '&#252;', '�' => '&#253;',
            '�' => '&#254;', '�' => '&#255;', '�' => '&#338;', '�' => '&#339;', '�' => '&#352;', '�' => '&#353;',
            '�' => '&#376;', 'F' => '&#934;', '?' => '&#936;', 'O' => '&#937;', 'a' => '&#945;', '�' => '&#946;',
            '?' => '&#947;', 'd' => '&#948;', 'e' => '&#949;', '?' => '&#950;', '?' => '&#951;', '?' => '&#952;',
            '?' => '&#953;', '?' => '&#954;', 'C' => '&#262;', 'c' => '&#263;', 'C' => '&#268;', 'c' => '&#269;',
            '�' => '&#272;', 'd' => '&#273;', '�' => '&#352;', '�' => '&#353;', '�' => '&#381;', '�' => '&#382;',
            '�' => '&#165;');

        if ($arrUnicodeCharacters)
        {
            $j = 1;
            foreach ($arrUnicodeCharacters as $varLangCharKey => $varLangCharValue)
            {
                if (strstr($argVarInputString, $varLangCharValue))
                {
                    $argVarInputString = str_replace($varLangCharValue, $varLangCharKey, $argVarInputString);
                    $j++;
                }
            }
        }
        if ($j == 1)
        {
            return $arrReturedArray = array('string' => $argVarInputString, 'stringFindCount' => 0);
        }
        else
        {
            return $arrReturedArray = array('string' => $argVarInputString, 'stringFindCount' => $varIncr);
        }
    }

    /**
     *
     *  Function Name: combineAttributesOptions()
     *
     *  Return type: array
     *
     *  Date created: 06 Nov 2013
     *
     *  Date last modified: 06 Nov 2013
     *
     *  Author: Prashant Kumar
     *
     *  Last modified by: Shardendu Singh
     *
     *  Comments: Function will replace all the special characters into unicode to store into database, so that it can displayed on browser propely.
     *
     *  User instruction: $objCore->combineAttributesOptions($argVarInputString)
     *
     */
    function combineAttributesOptions($arrAttrOpt)
    {
        $varAttrNum = count($arrAttrOpt);
        // pre($arrAttrOpt);
        $groups = array();
        //pre($arrAttrOpt);

        foreach ($arrAttrOpt as $key => $val) 
        { 
            foreach ($val['options'] as $kk => $vv)
            {
                if ($val['AttributeInputType'] == 'checkbox')
                {
                    //$arrCheckBoxAttr[$val['pkAttributeID']][$kk] = $vv['fkAttributeOptionId'];
                    $arrCheckBoxAttr[] = $vv['fkAttributeOptionId'];
                }
                else
                {
                    $groups[$val['pkAttributeID']][$kk] = $vv['fkAttributeOptionId'];
                }
                $arrOptions[$vv['fkAttributeOptionId']] = $vv['AttributeOptionValue'];
            }
        }
        //echo '<pre>';print_r($groups);
        //pre($groups);
        //pre($arrOptions);

        $arrCombineCheckBox = $this->combineCheckBoxOption($arrCheckBoxAttr);
        //pre($arrCombineCheckBox);
        $arrCombineOption = $this->combineOptions($groups, '');
        //pre($arrCombineOption);

        $i = 0;
        foreach ($arrCombineOption as $k => $v)
        {
            $str = array();
            foreach ($arrCombineCheckBox as $ck => $cv)
            {
                //  pre($cv);
                $str[] = $cv;
                $opt = $v . ',' . $cv;
                $arrCombineOption[$i] = trim($opt, ',');
                $i++;
            }
        }
        //pre($arrCombineOption);

        foreach ($arrCombineOption as $k => $v)
        {
            $tempArr = explode(',', $v);
            $arrOptVals = array();
            foreach ($tempArr as $kT => $vT)
            {
                $arrOptVals[] = $arrOptions[$vT];
            }

            $optVals = implode(',', $arrOptVals);
            sort($tempArr);
            $optIds = implode(',', $tempArr);
            $arrCombineOpt[$k]['fkAttributeOptionId'] = $optIds;
            $arrCombineOpt[$k]['AttributeOptionValue'] = $optVals;
        }

        //pre($arrCombineOpt);
        return $arrCombineOpt;
    }

    /**
     *
     *  Function Name: combineOptions()
     *
     *  Return type: array
     *
     *  Date created: 06 Nov 2013
     *
     *  Date last modified: 06 Nov 2013
     *
     *  Author: Prashant Kumar
     *
     *  Last modified by: Shardendu Singh
     *
     *  Comments: Function will replace all the special characters into unicode to store into database, so that it can displayed on browser propely.
     *
     *  User instruction: $objCore->combineOptions($groups, $prefix)
     *
     */
    function combineOptions($groups, $prefix = '')
    {
        $result = array();
        $group = array_shift($groups);
        //echo '<pre>';print_r($group);
        //pre($group);
        foreach ($group as $selected)
        { //pre($selected);
            if ($groups)
            {
                //pre($selected);
                $result = array_merge($result, $this->combineOptions($groups, $prefix . $selected . ','));
                //pre($result);
            }
            else
            {
                $result[] = $prefix . $selected;
            }
        }
        return $result;
    }

    /**
     *
     *  Function Name: combineCheckBoxOption()
     *
     *  Return type: array
     *
     *  Date created: 06 Nov 2013
     *
     *  Date last modified: 06 Nov 2013
     *
     *  Author: Prashant Kumar
     *
     *  Last modified by: Shardendu Singh
     *
     *  Comments: Function will replace all the special characters into unicode to store into database, so that it can displayed on browser propely.
     *
     *  User instruction: $objCore->combineCheckBoxOption($words)
     *
     */
    function combineCheckBoxOption($words)
    {
        // $words = array('red', 'blue', 'green');
        $arrRes = array();
        $num = count($words);

//The total number of possible combinations 
        $total = pow(2, $num);

//Loop through each possible combination  
        for ($i = 0; $i < $total; $i++)
        {
            //For each combination check if each bit is set 
            $arrTemp = array();
            for ($j = 0; $j < $num; $j++)
            {
                //Is bit $j set in $i?                 
                if (pow(2, $j) & $i)
                    $arrTemp[] = $words[$j];
            }
            if (count($arrTemp) > 0)
                $arrRes[] = implode(',', $arrTemp);
        }
        return $arrRes;
    }

    /**
     *
     * Function Name : getPercentage
     *
     * Return type : Array
     *
     * Date created : 05th July 2013
     *
     * Date last modified :  05th July 2013
     *
     * Author : Rupesh Parmar
     *
     * Last modified by : Rupesh Parmar
     *
     * Comments : It takes two argument 1st is $cur and 2nd is $prev and return percentage .
     *
     * User instruction : $$objCore->getPercentage($argDate);
     *
     */
    function getPercentage($cur, $prev)
    {

        $varPercentage = 0;
        if ($cur > 0 && $prev > 0)
        {
            $varPercentage = (($cur - $prev) / $prev) * 100;
        }
        else if ($cur > 0)
        {
            $varPercentage = $cur;
        }
        else
        {
            $varPercentage = '-' . $prev;
        }
        return $this->price_format($varPercentage);
    }

    /**
     *
     * Function Name : getPercentage
     *
     * Return type : Array
     *
     * Date created : 05th July 2013
     *
     * Date last modified :  05th July 2013
     *
     * Author : Rupesh Parmar
     *
     * Last modified by : Rupesh Parmar
     *
     * Comments : It takes two argument 1st is $cur and 2nd is $prev and return percentage .
     *
     * User instruction : $$objCore->getPercentage($argDate);
     *
     */
    function getFormatValue($str = '')
    {
        return addslashes($str);
    }

    /**
     *
     * Function Name : stripTags
     *
     * Return type : Array
     *
     * Date created : 05th July 2013
     *
     * Date last modified :  05th July 2013
     *
     * Author : Rupesh Parmar
     *
     * Last modified by : Rupesh Parmar
     *
     * Comments : It takes two argument 1st is $cur and 2nd is $prev and return percentage .
     *
     * User instruction : $$objCore->getPercentage($argDate);
     *
     */
    function stripTags($str = '')
    {
        return strip_tags($str);
    }

    /**
     *
     * Function Name : getRewardList
     *
     * Return type : Array
     *
     * Date created : 05th July 2013
     *
     * Date last modified :  05th July 2013
     *
     * Author : Rupesh Parmar
     *
     * Last modified by : Rupesh Parmar
     *
     * Comments : It will return array
     *
     * User instruction : $$objCore->getRewardList();
     *
     */
    function getRewardList()
    {
        $arr = array(
            'RewardOnCustomerRegistration' => 'Registration',
            'RewardOnNewsletterSubscribe' => 'Newsletter Subscribe',
            'RewardOnRecommendProduct' => 'Recommend Product',
            'RewardOnSocialMediaSharing' => 'Social Media Sharing',
            'RewardOnReviewRatingProduct' => 'Review/Rating Product',
            'RewardOnOrderFeedback' => 'Order Feedback',
            'RewardOnOrder' => 'Placed an order',
            'RewardOnReferal' => 'Refer friend'
        );

        return $arr;
    }

    /**
     *
     * Function Name : getNotification
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $$objCore->getNotification();
     *
     * Parameter $type,$toNotificationId,$userType
     */
    function getNotification($userType = '', $id = '')
    {
        $return = '';
        $db = new Database();
        if ($userType == 'wholesaler' && $id != '')
        {
            $varID = "ToUserType='wholesaler' AND fkToUserID ='" . $id . "' AND DeletedBy!=fkToUserID AND IsRead='0'";
            $arrClms = array('count(pkSupportID) as pkSupportID');
            $varTable = TABLE_SUPPORT;
            $arrRes = $db->select($varTable, $arrClms, $varID);
            $return['wholesalerSupport'] = $arrRes[0]['pkSupportID'] > 0 ? $arrRes[0]['pkSupportID'] : '';
            //order section start
            $varID = "fkWholesalerID='" . $id . "' and Status ='pending'  GROUP BY  `fkOrderID`";
            $arrClms = array(' count(fkOrderID) as fkOrderID');
            
            $varTable = TABLE_ORDER_ITEMS;
            $arrRes = $db->select($varTable, $arrClms, $varID);
            $total_order=count($arrRes);
            //pre($arrRes);
            //echo $arrRes[0]['fkOrderID']; die;
            //$return['wholesalerOrder'] = $arrRes[0]['fkOrderID'] > 0 ? $arrRes[0]['fkOrderID'] : '';
            $return['wholesalerOrder'] = $total_order > 0 ? $total_order : '';
            //review section start
            $varID = "p.fkWholesalerID='" . $id . "' and ReviewWholesaler ='0' group by fkProductID";
            $arrClms = array('pkReviewID');
            $varTable = TABLE_REVIEW . " as a LEFT JOIN " . TABLE_PRODUCT . " as p ON p.pkProductID=a.fkProductID";
            $arrRes = $db->select($varTable, $arrClms, $varID);

            $return['wholesaleReview'] = count($arrRes) > 0 ? count($arrRes) : '';

            //feedback section start
            $varID = " fkWholesalerID='" . $id . "' and feedbackUpdate ='0'";
            $arrClms = array('count(pkFeedbackID) as pkFeedbackID');
            $varTable = TABLE_WHOLESALER_FEEDBACK;
            $arrRes = $db->select($varTable, $arrClms, $varID);
            $return['wholesaleFeedback'] = $arrRes[0]['pkFeedbackID'] > 0 ? $arrRes[0]['pkFeedbackID'] : '';
            //invoice section start
            $varID = " fkWholesalerID='" . $id . "' and TransactionStatus='Pending'";
            $arrClms = array('count(pkInvoiceID) as pkInvoiceID');
            $varTable = TABLE_INVOICE;
            $arrRes = $db->select($varTable, $arrClms, $varID);
            $return['wholesaleInvoive'] = $arrRes[0]['pkInvoiceID'] > 0 ? $arrRes[0]['pkInvoiceID'] : '';
            //rating section start
            $rat = $this->productListRating($id);
            $return['wholesaleProductRating'] = count($rat) > 0 ? count($rat) : '';
            //pre($rat);
        }

        if ($userType == 'customer' && $id != '')
        {
            $varID = "ToUserType='customer' AND fkToUserID ='" . $id . "' AND DeletedBy!=fkToUserID AND IsRead='0'";
            $arrClms = array('count(pkSupportID) as pkSupportID');
            $varTable = TABLE_SUPPORT;
            $arrRes = $db->select($varTable, $arrClms, $varID);
            $return['customerSupport'] = $arrRes[0]['pkSupportID'] > 0 ? $arrRes[0]['pkSupportID'] : '';
        }

        return json_encode(array('wholesalerSupport' => $return['wholesalerSupport'], 'wholesalerOrder' => $return['wholesalerOrder'], 'customerSupport' => $return['customerSupport'], 'wholesaleReview' => $return['wholesaleReview'], 'wholesaleFeedback' => $return['wholesaleFeedback'], 'wholesaleInvoive' => $return['wholesaleInvoive'], 'wholesaleProductRating' => $return['wholesaleProductRating']));
    }

    function productListRating($wid)
    {
        $db = new Database();
        $varWhere = "pkWholesalerID='" . $wid . "' AND productReview='0'";
        $arrClms = array('pkRateID', 'pkProductID', 'Quantity', 'ProductRefNo', 'ProductName', 'CategoryName', 'CategoryIsDeleted', 'CompanyName', 'WholesalePrice', 'FinalPrice', 'ProductStatus', 'DiscountFinalPrice', 'DiscountPrice');
        $varTable = TABLE_PRODUCT . ' LEFT JOIN ' . TABLE_CATEGORY . ' ON fkCategoryID=pkCategoryId LEFT JOIN ' . TABLE_WHOLESALER . ' ON fkWholesalerID = pkWholesalerID INNER JOIN ' . TABLE_PRODUCT_RATING . ' ON fkProductID=pkProductID';
        $arrRes = $db->select($varTable, $arrClms, $varWhere);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     *
     * Function Name : messageDeleteRequired()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->messageDeleteRequired();
     *
     * Parameter $type,$toNotificationId,$userType
     */
    function messageDeleteRequired($id = '')
    {
        $return = '';
        $db = new Database();
        if ($id != '')
        {
            $varID = "pkSupportID ='" . $id . "' AND DeletedBy!='0'";
            $arrClms = array('count(pkSupportID) as pkSupportID');
            $varTable = TABLE_SUPPORT;
            $arrRes = $db->select($varTable, $arrClms, $varID);
            $return = $arrRes[0]['pkSupportID'];
        }
        return $return > 0 ? true : false;
    }

    /**
     *
     * Function Name : messageDeleteRequiredForAdmin()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->messageDeleteRequiredForAdmin();
     *
     * Parameter $type,$toNotificationId,$userType
     */
    function messageDeleteRequiredForAdmin($id = '')
    {
        $return = '';
        $db = new Database();
        if ($id != '')
        {
            $varID = "pkSupportID ='" . $id . "' AND DeletedBy='0'";
            $arrClms = array('FromUserType', 'fkFromUserID', 'ToUserType', 'fkToUserID');
            $varTable = TABLE_SUPPORT;
            $arrRes = $db->select($varTable, $arrClms, $varID);
            if (count($arrRes) > 0)
            {
                if ($arrRes[0]['FromUserType'] == 'admin' && $arrRes[0]['fkFromUserID'] <> '')
                {
                    $return = $arrRes[0]['fkFromUserID'];
                }
                else if ($arrRes[0]['ToUserType'] == 'admin' && $arrRes[0]['fkToUserID'] <> '')
                {
                    $return = $arrRes[0]['fkToUserID'];
                }
            }
        }
        return $return > 0 ? $return : false;
    }

    /**
     *
     * Function Name : updateFeedback()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->updateFeedback();
     *
     */
    function updateFeedback($id = '')
    {
        $db = new Database();
        $varID = "pkFeedbackID ='" . $id . "' AND feedbackUpdate='0'";
        $arrClms = array('feedbackUpdate' => 1);
        $varTable = TABLE_WHOLESALER_FEEDBACK;
        $arrRes = $db->update($varTable, $arrClms, $varID);

        return true;
    }

    /**
     * function getRealIpAddr
     *
     * This function returns the ip address of the visitors.
     *
     * @DateCreated 14 Nov 2011
     *
     * @DateLastModified 14 Nov 2011
     *
     * @return string
     */
    function getUserIpAddr()
    {
        //pre('hi');
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
            $dif = explode('.',$ip);
            $fst = $dif[0];
            $sec = $dif[1];
            $ip = $fst.'.'.$sec;

            if($ip == '192.168'){ //192.168.100.1 -- this is the dothejob Ip in our office Original Ip is 203.100.77.135
                $ip = '203.100.77.135';
            }else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            
        }
        return $ip;
    }

    /**
     *
     * Function Name : verifyEmail()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->verifyEmail();
     *
     */
    function verifyEmail($email = '')
    {
        $db = new Database();
        $varCustomerWhere = "CustomerEmail='" . trim($email) . "'";
        $arrClms = array('pkCustomerID');
        $arrUserList = $db->select(TABLE_CUSTOMER, $arrClms, $varCustomerWhere);
        if (count($arrUserList) > 0)
        {
            return json_encode(array('exist' => $email));
        }
        else
        {
            return json_encode(array('notExist' => $email));
        }
    }

    /**
     * function findcatLavel
     *
     * This function is used to find the selected category lavel.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrAddID
     *
     * User instruction: $objCategory->addCategory($arrPost)
     */
    function findcatLavel($catID = '')
    {
        $db = new Database();
        $varWhere = "pkCategoryId = '" . $catID . "' ";
        $arrCategoryRow = $db->select(TABLE_CATEGORY, array('CategoryParentId'), $varWhere);
        return $arrCategoryRow[0]['CategoryParentId'];
    }

    function findParentcatName($catID = '')
    {
        $db = new Database();
        $varWhere = "pkCategoryId = (SELECT CategoryParentId FROM tbl_category WHERE pkCategoryId = '" . $catID . "')";
        $arrCategoryRow = $db->select(TABLE_CATEGORY, array('pkCategoryId', 'CategoryName'), $varWhere);
        return $arrCategoryRow;
    }

    /**
     *
     * Function Name : verifyEmail()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->verifyEmail();
     *
     */
    function verifyEmailLogistic($email = '')
    {
        $db = new Database();
        $varCustomerWhere = "CompanyEmail='" . trim($email) . "'";
        $arrClms = array('pkLogisticID');
        $arrUserList = $db->select(TABLE_LOGISTIC, $arrClms, $varCustomerWhere);
        if (count($arrUserList) > 0)
        {
            return json_encode(array('exist' => $email));
        }
        else
        {
            return json_encode(array('notExist' => $email));
        }
    }
    
    
    /**
     *
     * Function Name : verifyEmail()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->verifyEmail();
     *
     */
    function verifyEmailWholsaler($email = '')
    {
        $db = new Database();
        $varCustomerWhere = "CompanyEmail='" . trim($email) . "'";
        $arrClms = array('pkWholesalerID');
        $arrUserList = $db->select(TABLE_WHOLESALER, $arrClms, $varCustomerWhere);
        if (count($arrUserList) > 0)
        {
            return json_encode(array('exist' => $email));
        }
        else
        {
            return json_encode(array('notExist' => $email));
        }
    }

    /**
     *
     * Function Name : verifyProductQuantity()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->verifyProductQuantity();
     *
     */
    function verifyProductQuantity($id = 0, $qua = 0)
    {
        $db = new Database();
        $varCustomerWhere = "pkProductID='" . trim($id) . "' AND Quantity < '" . trim($qua) . "'";
        $arrClms = array('pkProductID');
        $arrUserList = $db->select(TABLE_PRODUCT, $arrClms, $varCustomerWhere);
        return $arrUserList[0]['pkProductID'];
    }

    /**
     *
     * Function Name : verifyPackageQuantity()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->verifyProductQuantity();
     *
     */
    function verifyPackageQuantity($id = 0, $qua = 0)
    {
        $db = new Database();
        $varCustomerWhere = "fkPackageId='" . trim($id) . "'";
        $arrClms = array('fkProductId');
        $arrUserList = $db->select(TABLE_PRODUCT_TO_PACKAGE, $arrClms, $varCustomerWhere);
        $products = array();
        $packQua = '';
        if (count($arrUserList) > 0)
        {
            foreach ($arrUserList as $key => $v)
            {
                $varCustomerWhere = "pkProductID='" . trim($v['fkProductId']) . "' AND Quantity < '" . trim($qua) . "'";
                $arrClms = array('pkProductID');
                $products = $db->select(TABLE_PRODUCT, $arrClms, $varCustomerWhere);
                if ($products[0]['pkProductID'] != '')
                {
                    $packQua[] = $products[0]['pkProductID'];
                }
            }
        }
        return $packQua;
    }

    /**
     *
     * Function Name : verifyGiftCartQuantity()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->verifyProductQuantity();
     *
     */
    function verifyGiftCartQuantity($id = 0, $qua = 0)
    {
        $db = new Database();
        $varCustomerWhere = "pkGiftCardID='" . trim($id) . "'  AND Quantity < '" . trim($qua) . "'";
        $arrClms = array('pkGiftCardID');
        $arrUserList = $db->select(TABLE_GIFT_CARD, $arrClms, $varCustomerWhere);
        return $arrUserList[0]['pkGiftCardID'];
    }

    /**
     *
     * Function Name : getCustomerOder()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->getCustomerOder();
     *
     */
    function getCustomerOder()
    {
        $db = new Database();

        /*
        Old 

        */
        $varCustomerWhere = "fkCustomerID='" . (int) $_SESSION['sessUserInfo']['id'] . "' AND OrderStatus='Pending'";
        //$varCustomerWhere = "fkCustomerID='" . (int) $_SESSION['sessUserInfo']['id'] . "'";
        $arrClms = array('count(pkOrderID) as orders');
        $arrUserList = $db->select(TABLE_ORDER, $arrClms, $varCustomerWhere);
       // pre($arrUserList);
        return $arrUserList[0]['orders'];
        

        /*
        New update on 24 dec

        */

        // $userId=$_SESSION['sessUserInfo']['id'];
        // $query = "SELECT * FROM tbl_order as o
        // INNER JOIN tbl_order_items as oi
        // ON (o.pkOrderID = oi.fkOrderID AND o.fkCustomerID = '$userId' )
        // GROUP BY o.pkOrderID ";

        // $order=$db->getArrayResult($query);

        // return count($order);
    }

    /**
     *
     * Function Name : getCustomerSavedItems()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->getCustomerSavedItems();
     *
     */
    function getCustomerSavedItems()
    {
        $db = new Database();
        $varCustomerWhere = "fkUserId='" . (int) $_SESSION['sessUserInfo']['id'] . "'";
        $arrClms = array('count(pkWishlistId) as savedItems');
        $arrUserList = $db->select(TABLE_WISHLIST, $arrClms, $varCustomerWhere);
        return $arrUserList[0]['savedItems'];
    }

    /**
     *
     * Function Name : getCustomerSavedItems()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return array
     *
     * User instruction : $objCore->getCustomerSavedItems();
     *
     */
    function getProductDiscount($acPrice, $dPrice,$sPrice)
    {
        //$discount = floor(($dPrice / $acPrice) * 100);
        $discount=0;
        if($sPrice>0){
        $discount = $sPrice!='' && $sPrice!=0?floor(($acPrice-$sPrice)/($acPrice/100)):0;    
        }else{
        $discount = $dPrice!='' && $dPrice!=0?floor(($acPrice-$dPrice)/($acPrice/100)):0;
        }
        return $discount;
    }

    /**
     *
     * Function Name : getProductAttribute()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return count of attribute related to the product
     *
     * User instruction : $objCore->getCustomerSavedItems();
     *
     */
    function getProductAttribute($_argProductId)
    {
        $db = new Database();
        $aray = array('count(fkAttributeId) as attr');
        $varGetProductAtt = $db->select(TABLE_PRODUCT_TO_OPTION, $aray, 'fkProductId="' . $_argProductId . '"');
        return $varGetProductAtt[0]['attr'];
    }

    /**
     *
     * Function Name : getProductAttribute()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : It will return count of attribute related to the product
     *
     * User instruction : $objCore->getCustomerSavedItems();
     *
     */
    function price_format($val='')
    {
        return number_format($val, 2, '.', '');
    }
    
     /**
     *
     * Function Name : getCusName()
     *
     * Return type : Array
     *
     * Date created : 19th sep 2014
     *
     * Date last modified :  19th sep 2014
     *
     * Author : Raju khatak
     *
     * Last modified by : Raju khatak
     *
     * Comments : This function use to return customer first name
     *
     * User instruction : $objCore->getCusName();
     *
     */
    function getCusName($id)
    {
        $db = new Database();
        $aray = array('	CustomerFirstName');
        $varGetProductAtt = $db->select(TABLE_CUSTOMER, $aray, 'pkCustomerID="' . $id . '"');
        return $varGetProductAtt[0]['CustomerFirstName'];
    }
    
    
    function getSavePrice($discountPrice,$specialPrice){
        return $specialPrice>0?$specialPrice:$discountPrice;
    }
    
    /**
     * function countryList
     *
     * This function is used to retrive country List.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function countryList()
    {
        $db = new Database();
        $arrClms = array(
            'country_id',
            'name',
        );
        $varOrderBy = 'name ASC ';
        $arrRes = $db->select(TABLE_COUNTRY, $arrClms);
        return $arrRes;
    }
    
    /**
     * function getZoneCountry
     *
     * This function is used to remove the shipping.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 0
     *
     * @return true
     *
     * User instruction: $objShippingGateway->getZoneCountry()
     */
    function getZoneCountry()
    {
        $db = new Database();
        $arr=array('zone','group_concat(" ",country_id) as Countries');
        $where ="status='1' AND zone!='' GROUP BY(zone) ASC"; 
        $gorup="GROUP BY(zone) ASC";
        $arrRes = $db->select(TABLE_COUNTRY,$arr,$where);
        //$varQuery = mysql_query("SELECT zone,group_concat(' ',name) as Countries FROM " . TABLE_COUNTRY . " WHERE status='1' AND zone!='' GROUP BY(zone) ASC");

        //$arrRes = $db->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }
    function getshippingcompanyname($varID, $varPortalFilter) {
    
    	$argWhr = "pkShippingGatewaysID='" . $varID . "' ";
    	$arrClms = array('ShippingTitle');
    	$arrRes = $this->select(TABLE_SHIP_GATEWAYS, $arrClms, $argWhr, $varOrder);
    
    	//pre($arrRes);
    	return $arrRes;
    }
    /**
     *
     *  Function Name : getCurPrice
     *
     *  Return type : String Price
     *
     *  Date created :05th July 2013
     *
     *  Date last modified : 05th July2013
     *
     *  Author :Rupesh Parmar
     *
     *  Last modified by :Rupesh Parmar
     *
     *  Comments : This function return formated price with currency sign. It take two argument first is require and second is optional.
     *
     *  User instruction : obj->getPrice($arg1, $arg2='')
     *
     */
    function getCurPrice($argPrice)
    {
        if ($argPrice < 0)
        {
            return "-" . $_SESSION['SiteCurrencySign']  . str_replace('-', '', $argPrice);
        }
        return $_SESSION['SiteCurrencySign']  .' '. $argPrice;
    }
    
    
    function timeZone($date=null,$zone=null){
        $UTC = new DateTimeZone("GMT");
        $newTZ = new DateTimeZone($zone);
        $date = new DateTime( $date, $UTC );
        $date->setTimezone( $newTZ );
        $convertedDate= $date->format('Y-m-d H:i:s');
        return $convertedDate;
    }
    
    public static function nofication($case){
        $db =new Database; 
        
        switch ($case){
            case 'logistic':
            $where="logisticIsVerified='0'";    
            $res =$db->select(TABLE_LOGISTIC,array('count(pkLogisticID) as notify'),$where);     
            break;    
        }
        
        return $res[0]['notify'];
    }

}

// End of class	
?>
