<?php

/**
 * ClassCommon class 
 *
 * The Common class contains all the functions that are commonly used in different modules.
 *
 * @DateCreated 23th March 2010
 * 
 * @DateLastModified  07 May, 2010
 *
 * @copyright Copyright (C) 2010-2011 Vinove Software and Services
 *
 * @version  1.1
 */
class ClassCommon extends Database
{
    /**
     *
     * Constant Variable Start
     *
     */

    /** Holds the number of records per page */
    public $arrRecordsPerPage = array('5' => '5', '10' => '10', '15' => '15', '20' => '20', '25' => '25', '50' => '50');

    /** Holds the settings date formats */
    public $arrDateFormats = array('d-m-Y' => 'dd-mm-yyyy', 'd/m/Y' => 'dd/mm/yyyy', 'Y-m-d' => 'yyyy-mm-dd', 'Y/m/d' => 'yyyy/mm/dd', 'm-d-Y' => 'mm-dd-yyyy', 'm/d/Y' => 'mm/dd/yyyy', 'd/m/y' => 'dd/mm/yy', 'd-m-y' => 'dd-mm-yy', 'm/d/y' => 'mm/dd/yy', 'm-d-y' => 'mm-dd-yy');

    /** Holds the listing date formats */
    public $arrListingDateFormats = array('%d/%m/%Y' => 'dd/mm/yyyy', '%d/%m/%y' => 'dd/mm/yy', '%d/%M/%Y' => 'dd/month/yyyy', '%D/%m/%Y' => '1st/mm/yyyy', '%d/%M/%y' => 'dd/month/yy');
    public $arrTimeFormats = array();
    public $arrDateFormatsPhpMySql = array();
    public $arrTimeFormatsPhpMySql = array();
    public $arrMonthShortName = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    public $arrNumericMonths = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
    public $arrMonthFullName = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    public $arrNumKeyMonthFullName = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
    public $arrNumKeyMonthShortName = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'July', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
    public $arrDayFullName = array('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday');

    /**
     *
     * Constant Variable End
     *
     */
    /**
     * function __construct
     *
     * This function is used initialize variables.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */

    /** constructor	of ClassCommon class */
    public function __construct()
    {
        $this->arrDateFormatsPhpMySql['d-m-Y||%d-%m-%Y'] = 'dd-mm-yyyy' . ' (' . date('d-m-Y') . ')';
        //$this->arrDateFormatsPhpMySql['d/m/Y||%d/%m/%Y'] = 'dd/mm/yyyy'.' ('.date('d/m/Y').')';
        $this->arrDateFormatsPhpMySql['Y-m-d||%Y-%m-%d'] = 'yyyy-mm-dd' . ' (' . date('Y-m-d') . ')';
        $this->arrDateFormatsPhpMySql['Y/m/d||%Y/%m/%d'] = 'yyyy/mm/dd' . ' (' . date('Y/m/d') . ')';
        //$this->arrDateFormatsPhpMySql['m-d-Y||%m-%d-%Y'] = 'mm-dd-yyyy'.' ('.date('m-d-Y').')';
        $this->arrDateFormatsPhpMySql['m/d/Y||%m/%d/%Y'] = 'mm/dd/yyyy' . ' (' . date('m/d/Y') . ')';
        //$this->arrDateFormatsPhpMySql['d/m/y||%d/%m/%y'] = 'dd/mm/yy'.'   ('.date('d/m/y').')';
        // $this->arrDateFormatsPhpMySql['d-m-y||%d-%m-%y'] = 'dd-mm-yy'.'   ('.date('d-m-y').')';
        $this->arrDateFormatsPhpMySql['m/d/y||%m/%d/%y'] = 'mm/dd/yy' . '   (' . date('m/d/y') . ')';
        //$this->arrDateFormatsPhpMySql['m-d-y||%m-%d-%y'] = 'mm-dd-yy'.'   ('.date('m-d-y').')';

        $this->arrDateFormatsPhpMySql['M j Y||%b %e. %Y'] = 'mm dd yyyy' . '   (' . date('M j Y') . ')';

        $this->arrDateFormatsPhpMySql['D, M j. Y||%a, %b %e. %Y'] = 'dd, mm dd yyyy' . '   (' . date('D, M j. Y') . ')';

        $this->arrDateFormatsPhpMySql['j M Y||%e %b %Y'] = 'dd mm yyyy' . '   (' . date('j M Y') . ')';

        $this->arrDateFormatsPhpMySql['Y/m/j||%Y/%m/%e'] = 'yyyy/mm/dd' . '   (' . date('Y/m/j') . ')';
        $this->arrDateFormatsPhpMySql['m/j/Y||%m/%e/%Y'] = 'mm/dd/yyyy' . '   (' . date('m/j/Y') . ')';


        //set timeformat array for settings page(used in php and mysql)
        $this->arrTimeFormatsPhpMySql['H:i:s||%H:%i:%s'] = 'HH:MM:SS' . '   (' . date('H:i:s') . ')';
        $this->arrTimeFormatsPhpMySql['H:i||%H:%i'] = 'HH:MM' . '   (' . date('H:i') . ')';
        $this->arrTimeFormatsPhpMySql['h:i:s A||%h:%i:%s %p'] = 'HH:MM:SS' . '   (' . date('h:i:s A') . ')';
        $this->arrTimeFormatsPhpMySql['h:i A||%h:%i %p'] = 'HH:MM' . '   (' . date('h:i A') . ')';



        $this->arrTimeFormats = array(
            '12:00' => '12:00',
        );
    }

    /**
     * function getMarginCast
     *
     * This function is used get margin cost.
     *
     * Database Tables used in this function are : TABLE_DEFAULT_COMMISSION
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    public function getMarginCast()
    {
        $db = new Database();
        $arrCols = array('MarginCast');
        $getData = $db->select(TABLE_DEFAULT_COMMISSION, $arrCols, $where);

        //echo "<pre>";print_r($getData);die;

        return $getData;
    }

    /**
     * function getAcCostForPackage
     *
     * This function is used get package cost.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    public function getAcCostForPackage($price)
    {
        $arrRow = $this->getMarginCast();
        $varMarginCost = $price - ($price * $arrRow[0]['MarginCast'] / 100);
        $varAcPrice = round($varMarginCost, 4);
        return $varAcPrice;
    }

    /**
     * function getAcCostForTodaysOffer
     *
     * This function is used get todays offer cost.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 1 decimal
     *
     * @return string $arrRes
     */
    public function getAcCostForTodaysOffer($price)
    {
        $arrRow = $this->getMarginCast();
        $varMarginCost = $price - ($price * $arrRow[0]['MarginCast'] / 100);
        $varAcPrice = round($varMarginCost, 4);
        return $varAcPrice;
    }

    /**
     * function getProduct
     *
     * This function is used get ticket title.
     *
     * Database Tables used in this function are : TABLE_PRODUCT
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    public function getProduct($arrCols, $where)
    {
        $db = new Database();
        $varTbl = TABLE_PRODUCT . " ";
        $varQuery = "SELECT " . $arrCols . " FROM " . TABLE_PRODUCT . " where " . $where . " Group By pkProductID";
        $getData = $db->getArrayResult($varQuery);
        return $getData;
    }

    /**
     * function countCoupon
     *
     * This function is used get coupon count.
     *
     * Database Tables used in this function are : TABLE_COUPON_TO_PRODUCT
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    public function countCoupon($arrCols, $where)
    {
        $db = new Database();
        $getRes = $db->getNumRows(TABLE_COUPON_TO_PRODUCT, $arrCols, $where);
        return $getRes;
    }

    /**
     * function getCoupon
     *
     * This function is used get coupon.
     *
     * Database Tables used in this function are : TABLE_COUPON
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    public function getCoupon($arrCols, $where)
    {
        $db = new Database();
        $getRes = $db->select(TABLE_COUPON, $arrCols, $where);
        return $getRes;
    }

    /**
     * function getMonthArray
     *
     * This function creates the month array.
     *
     * @DateCreated 28th May 2010
     * 
     * @DateLastModified 28th May 2010
     *
     * @return array
     */
    public function getMonthArray($argSelected = '', $argMonthKeyType = '', $argMonthOptionType = '')
    {
        $arrMonthKey = array();
        $arrMonthValue = array();
        if ($argMonthKeyType == 'Numeric')
        {
            $arrMonthKey = $this->arrNumericMonths;
        }
        elseif ($argMonthKeyType == 'Short')
        {
            $arrMonthKey = $this->arrMonthShortName;
        }
        else
        {
            $arrMonthKey = $this->arrMonthFullName;
        }


        if ($argMonthOptionType == 'Numeric')
        {
            $arrMonthValue = $this->arrNumericMonths;
        }
        elseif ($argMonthOptionType == 'Short')
        {
            $arrMonthValue = $this->arrMonthShortName;
        }
        else
        {
            $arrMonthValue = $this->arrMonthFullName;
        }


        $arrMonthOptions = array_combine($arrMonthKey, $arrMonthValue);

        return $arrMonthOptions;
    }

    /**
     * function encrypt
     *
     * This function encrypts the specified string with the given key.
     *
     * @DateCreated 22 May, 2010
     * 
     * @DateLastModified 22 May, 2010
     *
     * @return string 
     */
    public function encrypt($argString, $argKey = '')
    {
        if ($argKey == '')
        {
            $argKey = ENCODE_KEY;
        }
        $result = '';
        for ($i = 0; $i < strlen($argString); $i++)
        {
            $char = substr($argString, $i, 1);
            $keychar = substr($argKey, ($i % strlen($argKey)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result.=$char;
        }
        return base64_encode($result);
    }

    public function decrypt($argString, $argKey = '')
    {
        if ($argKey == '')
        {
            $argKey = ENCODE_KEY;
        }
        $result = '';
        $argString = base64_decode($argString);
        for ($i = 0; $i < strlen($argString); $i++)
        {
            $char = substr($argString, $i, 1);
            $keychar = substr($argKey, ($i % strlen($argKey)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result.=$char;
        }
        return $result;
    }

    /**
     * function getCurrencySymbols
     *
     * This function creates the HTML select options for currency symbols.
     *
     * @DateCreated 22 June, 2010
     * 
     * @DateLastModified 22 June, 2010
     *
     * @return string
     */
    public function getCurrencySymbols($argSelected = '', $argShowSelect = true)
    {
        $returnHtml = '';
        foreach ($this->arrCurrencySymbols as $key => $value)
        {
            if (!$argShowSelect && $key == '')
            {
                continue;
            }
            if ($key == $argSelected)
            {
                $select = 'selected';
            }
            else
            {
                $select = '';
            }


            $returnHtml .= '<option value="' . $key . '" ' . $select . '>' . $value . '</option>';
        }
        return $returnHtml;
    }

    /**
     * function drawComboOptionsMultiArray
     *
     * This function creates the HTML select options from the multidimensional array.
     *
     * @DateCreated 05 May, 2010
     * 
     * @DateLastModified 05 May, 2010
     *
     * @return string
     */
    public function drawComboOptionsMultiArray($argArrComboOptions, $argKey, $argValue, $argSelected = '')
    {
        $returnHtml = '';
        foreach ($argArrComboOptions as $key => $value)
        {
            if (is_array($argSelected))
            {
                if (in_array($value[$argKey], $argSelected))
                {
                    $select = 'selected';
                }
                else
                {
                    $select = '';
                }
            }
            else
            {
                if ($value[$argKey] == $argSelected)
                {
                    $select = 'selected';
                }
                else
                {
                    $select = '';
                }
            }
            $returnHtml .= '<option value="' . $value[$argKey] . '" ' . $select . '>' . $value[$argValue] . '</option>';
        }
        return $returnHtml;
    }

    /**
     * function getMultiLevelArrayOptions
     *
     * This function creates the HTML select options from the multidimensional array.
     *
     * @DateCreated 6th April 2010
     * 
     * @DateLastModified 1st September 2010
     *
     * @return string
     */
    public function getMultiLevelArrayOptions($arrMultidimensionalOptionArray, $selected = '')
    {
        $selectedValue = trim($selected);
        foreach ($arrMultidimensionalOptionArray as $key => $val)
        {
            $varOptions .= '<optgroup label="' . $key . '"></optgroup>';
            foreach ($val as $key => $val)
            {
                if ($selectedValue == $val)
                    $selected = 'selected';
                else
                    $selected = '';
                $varOptions .= '<option ' . $selected . '  value="' . $val . '">' . $val . '</option>';
            }
        }
        return $varOptions;
    }

    /**
     * function getMultiLevelArrayOptions
     *
     * This function returns the single dimension array from multiple dimensional array.
     *
     * @DateCreated 21 April, 2010
     * 
     * @DateLastModified 21 April, 2010
     *
     * @return array
     */
    public function convertMultipleToSingleArray($arrMultipleDimensionArray)
    {
        $arrSingleDimension = array();
        foreach ($arrMultipleDimensionArray as $key => $value)
        {
            foreach ($value as $eleKey => $eleValue)
            {
                $arrSingleDimension[] = $eleValue;
            }
        }
        return $arrSingleDimension;
    }

    /**
     * function convertMultipleToSingleArrayWithKey
     *
     * This function returns the single dimension array from multiple dimensional array with its key.
     *
     * @DateCreated 21 April, 2010
     * 
     * @DateLastModified 21 April, 2010
     *
     * @return array
     */
    public function convertMultipleToSingleArrayWithKey($arrMultipleDimensionArray, $argKey, $argValue)
    {
        $arrSingleDimension = array();
        foreach ($arrMultipleDimensionArray as $key => $value)
        {
            $arrSingleDimension[$value[$argKey]] = $value[$argValue];
        }
        return $arrSingleDimension;
    }

    /**
     * function setNumericArray
     *
     * This function creates an array of the given range and interval, also attach the value 0 if the fourth argument is set to true.
     *
     * @DateCreated 21 April, 2010
     * 
     * @DateLastModified 21 April, 2010
     *
     * @return array
     */
    public function setNumericArray($argStart, $argEnd, $argRange, $argZeroFill = false)
    {
        //return range($start, $end, $range);
        $numArray = array();
        for ($i = $argStart; $i <= $argEnd; $i = $i + $argRange)
        {

            if ($argZeroFill)
            {
                $n = sprintf('%02d', $i);
                $numArray[$n] = $n;
            }
            else
            {
                $numArray[$i] = $i;
            }
        }
        return $numArray;
    }

    /**
     * function setMinuteArray
     *
     * This function creates an array of minutes of the specified range.
     *
     * @DateCreated 21 April, 2010
     * 
     * @DateLastModified 21 April, 2010
     *
     * @return array
     */
    public function setMinuteArray($argStart, $argEnd)
    {
        $numArray = array();
        for ($i = $argStart; $i <= $argEnd; $i++)
        {
            $numArray[$i] = sprintf('%02d', $i);
        }
        return $numArray;
    }

    /**
     * function drawDropDownHourOptions
     *
     * This is used to return options of dropdowns for hours.
     *
     * @DateCreated 21 April, 2010
     * 
     * @DateLastModified 21 April, 2010
     *
     * @return string
     */
    public function drawDropDownHourOptions($argSelectedValue = '', $argHrFrom = 0, $argHrTo = 23)
    {
        $hours = range($argHrFrom, $argHrTo);
        $returnOptionsHtml = '';


        $returnOptionsHtml .= '<option value="">HH</option>';

        foreach ($hours as $value)
        {
            $selected = '';

            if ($value === $argSelectedValue)
            {
                $selected = 'selected="selected"';
            }

            $returnOptionsHtml .= '<option  ' . $selected . '  value=' . $value . '>' . sprintf("%02d", $value) . '</option>';
            /* 			 
              if(empty($argSelectedValue))
              {&& !empty($argSelectedValue)
              $selected = 'selected="selected"';
              }
             */
        }
        return $returnOptionsHtml;
    }

    /**
     * function drawDropDownMinuteOptions
     *
     * This function creates the dropdown options for minutes.
     *
     * @DateCreated 30 September 2010
     * 
     * @DateLastModified 04th May, 2010
     *
     * @return string
     */
    public function drawDropDownMinuteOptions($selectedValue = '', $argMinFrom = 0, $argMinTo = 55, $argSteps = 5)
    {
        $minutes = range($argMinFrom, $argMinTo, $argSteps);
        $returnOptionsHtml = '';


        $returnOptionsHtml .= '<option value="">MM</option>';
        foreach ($minutes as $value)
        {
            $selected = '';
            if ($value === $selectedValue)
            {
                $selected = 'selected="selected"';
            }

            $returnOptionsHtml .= '<option  ' . $selected . '  value=' . $value . '>' . sprintf("%02d", $value) . '</option>';
        }
        return $returnOptionsHtml;

        /*
          if(empty($selectedValue))
          {&& !empty($selectedValue)
          $selected = ' selected="selected"';
          } */
    }

    /**
     * function generateMediaFileName
     *
     * This function generates the alphanumeric file name of the specified extension.
     *
     * @DateCreated 01 February 2010
     * 
     * @DateLastModified 01 February 2010
     *
     * @return string
     */
    public function generateMediaFileName($argFileExt = '')
    {
        $strAlphaNumeric = self::getRandomAlphaNumeric(8) . '-' . self::getRandomAlphaNumeric(4) . '-' . self::getRandomAlphaNumeric(12) . $argFileExt;
        return $strAlphaNumeric;
    }

    /**
     * function getRandomAlphaNumeric
     *
     * This function generates the random alphanumeric string of the specified length, by default it generates string of 16 chars.
     *
     * @DateCreated 01 February 2010
     * 
     * @DateLastModified 01 February 2010
     *
     * @return string
     */
    public function getRandomAlphaNumeric($argIntpLength = 16)
    {
        $arrAlphaNumeric = array();
        $arrAlpha = range('A', 'Z');
        $arrNumeric = range(0, 9);

        $arrAlphaNumeric = array_merge($arrAlphaNumeric, $arrAlpha, $arrNumeric);

        mt_srand((double) microtime() * 1234567);
        shuffle($arrAlphaNumeric);

        $strAlphaNumeric = '';
        for ($x = 0; $x < $argIntpLength; $x++)
        {
            $strAlphaNumeric .= $arrAlphaNumeric[mt_rand(0, (sizeof($arrAlphaNumeric) - 1))];
        }
        return $strAlphaNumeric;
    }

    /**
     * function convertDateFormat
     *
     * This function converts the date in the specified format.
     *
     * @DateCreated 8th April 2010
     * 
     * @DateLastModified 8th April 2010
     *
     * @param $argDate = date to convert
     *
     * @param $argDateFormat = specified date format
     *
     * @return date
     */
    public function convertDateFormat($argDate = '', $argDateFormat = '')
    {
        if (empty($argDateFormat) || !isset($argDateFormat))
        {
            return date("Y/m/d", strtotime($argDate));
        }
        else
        {
            return date($argDateFormat, strtotime($argDate));
        }
    }

    /**
     * function getformatDate
     *
     * This function converts the date in the specified format.
     *
     * @DateCreated 8th April 2010
     * 
     * @DateLastModified 8th April 2010
     *
     * @return date
     */
    public function getformatDate($szFormat, $szDate = NULL)
    {
        if (!isset($szDate))
            $szDate = date("Y-m-d H:i:s");

        $szTemp = "00-00-0000";
        $arryMatch = Array();
        if (preg_match('%(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])%', $szDate, $arryMatch))
        {
            // Date is in the format of Y-m-d
            $arryTemp = preg_split('%[- /.]%', $arryMatch[0]);
            $arryDate['m'] = $arryTemp[1];
            $arryDate['d'] = $arryTemp[2];
            $arryDate['Y'] = $arryTemp[0];
            //$szTemp = .'-'.$arryTemp[2].'-'.$arryTemp[0];
        }
        elseif (preg_match('%(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d%', $szDate, $arryMatch))
        {
            // Date is in the format of m-d-Y
            $arryTemp = preg_split('%[- /.]%', $arryMatch[0]);
            $arryDate['m'] = $arryTemp[0];
            $arryDate['d'] = $arryTemp[1];
            $arryDate['Y'] = $arryTemp[2];
            //$szTemp = $arryTemp[0].'-'.$arryTemp[1].'-'.$arryTemp[2];
        }
        elseif (preg_match('%(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d%', $szDate, $arryMatch))
        {
            // Date is in the format of d-m-Y
            $arryTemp = preg_split('%[- /.]%', $arryMatch[0]);
            $arryDate['m'] = $arryTemp[1];
            $arryDate['d'] = $arryTemp[0];
            $arryDate['Y'] = $arryTemp[2];
            //$szTemp = $arryTemp[1].'-'.$arryTemp[2].'-'.$arryTemp[2];
        }

        if (!checkdate($arryDate['m'], $arryDate['d'], $arryDate['Y']))
        {
            return -1;
        }

        $nJD = gregoriantojd($arryDate['m'], $arryDate['d'], $arryDate['Y']);

        $szTemp = str_replace('Y', $arryDate['Y'], $szFormat);
        $szTemp = str_replace('m', $arryDate['m'], $szTemp);
        $szTemp = str_replace('d', $arryDate['d'], $szTemp);
        $szTemp = str_replace('D', jddayofweek($nJD, 2), $szTemp);
        $szTemp = str_replace('F', jdmonthname($nJD, 1), $szTemp);

        //echo $szTemp;
        return $szTemp;
    }

    /**
     * function DateFormat
     *
     * This function returns the formatted date.
     *
     * @DateCreated 8th April 2010
     * 
     * @DateLastModified 8th April 2010
     *
     * @return date
     */
    public function DateFormat($argDateFormat = '', $argDate = '')
    {
        if (empty($argDateFormat) || !isset($argDateFormat))
        {
            return date("Y/m/d", strtotime($argDate));
        }
        else
        {
            return date($argDateFormat, strtotime($argDate));
        }
    }

    /**
     * function isValidDate
     *
     * This function check if the specified date is valid or not and returns the date if valid or false if invalid.
     *
     * @DateCreated 8th April 2010
     * 
     * @DateLastModified 8th April 2010
     *
     * @return mixed 
     */
    public function isValidDate($argDate = '')
    {
        if (preg_match("/^[0-9[:punct:]]{1,}$/", $argDate))
        {
            return $argDate;
        }
        else
        {
            return false;
        }
    }

    /**
     * function changeDateTimeDisplayFormat
     *
     * This function converts the specified datetime value according to the specified datetimezone.
     *
     * @DateCreated 27 Oct 2010
     * 
     * @DateLastModified 27 Oct 2010
     *
     * @return mixed 
     */
    public function changeDateTimeDisplayFormat($argDateTime, $formatDisplay)
    {
        $dateTime = new DateTime($argDateTime, new DateTimeZone('GMT'));
        $date = $dateTime->format($formatDisplay) . '(' . $dateTime->format('H:i') . ')';
        return $date;
    }

    /**
     * function unlinkFile
     *
     * This function unlinks a file on the specified path.
     *
     * @DateCreated 22 May, 2010
     * 
     * @DateLastModified 22 May, 2010
     *
     * @return boolean 
     */
    public function unlinkFile($argFilePath)
    {
        //echo $argFilePath;	die;
        if (!empty($argFilePath))
        {
            if (is_file($argFilePath))
            {
                unlink($argFilePath);
            }
            return true;
        }
    }

    /**
     * function getDateDifference
     *
     * This function calculates the difference between two dates of the specified parameter(day, month, year).
     *
     * @DateCreated 22 May, 2010
     * 
     * @DateLastModified 22 May, 2010
     *
     * @return date 
     */
    public static function getDateDifference($interval, $dateTimeBegin, $dateTimeEnd)
    {
        $dateTimeBegin = strtotime($dateTimeBegin);
        $dateTimeEnd = strtotime($dateTimeEnd);

        if ($dateTimeBegin === -1)
        {
            return("..begin date Invalid");
        }
        elseif ($dateTimeEnd === -1)
        {
            return("..end date Invalid");
        }


        $dif = $dateTimeEnd - $dateTimeBegin;

        switch ($interval)
        {
            case "d"://days
                return(floor($dif / 86400)); // 86400 seconds = 1 day

            case "m": //similar result "m" dateDiff Microsoft
                $monthBegin = (date("Y", $dateTimeBegin) * 12) + date("n", $dateTimeBegin);
                $monthEnd = (date("Y", $dateTimeEnd) * 12) + date("n", $dateTimeEnd);
                $monthDiff = $monthEnd - $monthBegin;
                return($monthDiff);
            case "yyyy": //similar result "yyyy" dateDiff Microsoft
                return(date("Y", $dateTimeEnd) - date("Y", $dateTimeBegin));
            default:
                return(floor($dif / 86400)); //86400s=1d
        }
    }

    /**
     * function drawNumericDropDownOptions
     *
     * This function returns options of dropdowns as HTML string.
     *
     * @DateCreated 25 Oct 2010
     * 
     * @DateLastModified 25 Oct 2010
     *
     * @return string 
     */
    public function drawNumericDropDownOptions($argStart, $argEnd, $argRange, $argSelectedValue = '')
    {

        $arrNumericArray = $this->setNumericArray($argStart, $argEnd, $argRange);
        return $this->drawComboOptions($arrNumericArray, $argSelectedValue);
    }

    /**
     * function drawDropDownYear
     *
     * This function returns options of dropdowns for years as HTML string.
     *
     * @DateCreated 24 Nov 2010
     * 
     * @DateLastModified 24 Nov 2010
     *
     * @return string 
     */
    public function drawDropDownYear($selectedValue = '')
    {

        $year = date('Y');
        $lastYear = $year + 20;

        $years = range($year, $lastYear);
        $returnOptionsHtml = '';

        $selected = '';
        if ($value == $selectedValue)
        {
            $selected = ' selected="selected"';
        }

        $returnOptionsHtml .= '<option ' . $selected . '  value="">Year</option>';
        foreach ($years as $value)
        {
            $selected = '';
            if ($value == $selectedValue)
            {
                $selected = 'selected="selected"';
            }

            $returnOptionsHtml .= '<option  ' . $selected . '  value=' . $value . '>' . $value . '</option>';
        }

        return $returnOptionsHtml;
    }

    public function checkValidAdmin($argRecordID, $argTable, $argColName)
    {
        $objCore = new Core;
        if ($_SESSION['sessAdminType'] == 'sub')
        {
            $argSelectFlds = array('fkAdminID');
            $varWhereClause = $argColName . '=' . $argRecordID;
            $arrAdmin = $this->select($argTable, $argSelectFlds, $varWhereClause); //echo '<pre>';print_r($arrAdmin);die('sss');
            if ($arrAdmin[0]['fkAdminID'] == $_SESSION['sessUser'])
            {
                return $arrAdmin[0]['fkAdminID'];
            }
            else
            {
                $objCore->setErrorMsg('You are not a valid admin.');
                return false;
            }
        }
        else
        {
            return true;
        }
    }

    /**
     * function drawDropDownYear
     *
     * This function returns options of dropdowns for years as HTML string.
     *
     * @DateCreated 24 Nov 2010
     * 
     * @DateLastModified 24 Nov 2010
     *
     * @return string 
     */
    public function getArrayValue($argArray, $argKey)
    {
        $arrTemp = array_flip($argArray);
        $varValue = array_search($argKey, $arrTemp);
        return $varValue;
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
    function getRealIpAddr()
    {
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
        }
        return $ip;
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
    function IPtoLatLng($ip)
    {
        $latlngValue = array();
        $dom = new DOMDocument();
        $ipcheck = ip2long($ip);

        if ($ipcheck == -1 || $ipcheck === false)
        {
            echo "ERROR: INVALID IP";
            exit;
        }
        else
            $uri = "http://api.hostip.info/?ip=$ip&position=true";

        $dom->load($uri);
        $name = $dom->getElementsByTagNameNS('http://www.opengis.net/gml', 'name')->item(1)->nodeValue;
        $coordinates = $dom->getElementsByTagNameNS('http://www.opengis.net/gml', 'coordinates')->item(0)->nodeValue;
        $temp = explode(",", $coordinates);
        $latlngValue['LNG'] = $temp[0];
        $latlngValue['LAT'] = $temp[1];
        $latlngValue['NAME'] = $name;
        return $latlngValue;
    }

    /**
     * function getDistance
     *
     * This function returns the ip address of the visitors.
     *
     * @DateCreated 14 Nov 2011
     *
     * @DateLastModified 14 Nov 2011
     *
     * @return string
     */
    function getDistance($lat1, $lon1, $lat2, $lon2, $unit)
    {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K")
        {
            return ($miles * 1.609344);
        }
        else if ($unit == "N")
        {
            return ($miles * 0.8684);
        }
        else
        {
            return $miles;
        }
    }

    /**
     * create_time_range 
     * 
     * @param mixed $start start time, e.g., 9:30am or 9:30
     * @param mixed $end   end time, e.g., 5:30pm or 17:30
     * @param string $by   1 hour, 1 mins, 1 secs, etc.
     * @access public
     * @return void
     */
    function create_time_range($start, $end, $by = '30 mins')
    {

        $start_time = strtotime($start);
        $end_time = strtotime($end);

        $current = time();
        $add_time = strtotime('+' . $by, $current);
        $diff = $add_time - $current;

        $times = array();
        while ($start_time < $end_time)
        {
            $times[] = $start_time;
            $start_time += $diff;
        }
        $times[] = $start_time;
        return $times;
    }

    /**
     * function getCategories
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : TABLE_ADVERTISEMENT
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    //category Listing
    function getCategories($varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1')
    {
        $arrClms = " pkCategoryId,cat.CategoryName,CategoryParentId,CategoryHierarchy,CategoryLevel,categoryImage,categoryImageUrl,CategoryDescription";
        //$varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1';
        $varOrderBy = 'CategoryLevel ASC,CategoryOrdering ASC, CategoryHierarchy ASC,`CategoryName` ASC';
        $varTable = TABLE_CATEGORY . " as cat LEFT JOIN " . TABLE_CATEGORY_IMAGES . " as cim on cim.fkCategoryId=pkCategoryId";
        $varLimit = "";
        $varQuery = "SELECT " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhere . " ORDER BY " . $varOrderBy . " " . $varLimit;
        //Create memcache object
        global $oCache;
        //Create object key for cache object
        $varQueryKey = md5($varQuery);
        //Check memcache is enabled or not
        if ($oCache->bEnabled)
        { // if Memcache enabled
            if (!$oCache->getData($varQueryKey))
            {
                $arrRes = $this->getArrayResult($varQuery);
                $oCache->setData($varQueryKey, serialize($arrRes));
            }
            else
            {
                $arrRes = unserialize($oCache->getData($varQueryKey));
            }
        }
        else
        {
            $arrRes = $this->getArrayResult($varQuery);
        }

        $arrCat = array();
        foreach ($arrRes as $v)
        {
            $arrCat[$v['CategoryParentId']][] = array('pkCategoryId' => $v['pkCategoryId'], 'CategoryName' => $v['CategoryName'], 'CategoryHierarchy' => $v['CategoryHierarchy'], 'CategoryLevel' => $v['CategoryLevel'],'categoryImage'=>$v['categoryImage'],'categoryImageUrl'=>$v['categoryImageUrl'],'CategoryDescription'=>$v['CategoryDescription']);
            
        }
       
        return $arrCat;
    }

    /**
     * function getCategoriesChild
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : TABLE_PRODUCT & TABLE_CATEGORY
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    //category Listing
    function getCategoriesChild($varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel = 2')
    {
        $arrClms = " pkCategoryId,CategoryName,CategoryParentId,CategoryHierarchy,CategoryLevel";
        //$varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1';
        $varOrderBy = 'CategoryLevel ASC,CategoryOrdering ASC, CategoryHierarchy ASC,`CategoryName` ASC';
        $varTable = TABLE_PRODUCT . " INNER JOIN " . TABLE_CATEGORY . " ON(fkCategoryId = pkCategoryId)";
        $varLimit = "";
        $varQuery = "SELECT " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhere . " GROUP BY fkCategoryId ORDER BY " . $varOrderBy . " " . $varLimit;
        //Create memcache object
        global $oCache;
        //Create object key for cache object
        $varQueryKey = md5($varQuery);
        //Check memcache is enabled or not
        if ($oCache->bEnabled)
        { // if Memcache enabled
            if (!$oCache->getData($varQueryKey))
            {
                $arrRes = $this->getArrayResult($varQuery);
                $oCache->setData($varQueryKey, serialize($arrRes));
            }
            else
            {
                $arrRes = unserialize($oCache->getData($varQueryKey));
            }
        }
        else
        {
            $arrRes = $this->getArrayResult($varQuery);
        }


        $arrCat = array();
        foreach ($arrRes as $v)
        {
            $arrCat[$v['CategoryParentId']][] = array('pkCategoryId' => $v['pkCategoryId'], 'CategoryName' => $v['CategoryName'], 'CategoryHierarchy' => $v['CategoryHierarchy'], 'CategoryLevel' => $v['CategoryLevel']);
        }
        return $arrCat;
    }

    /**
     * function getCatAds
     *
     * This function is used get ads.
     *
     * Database Tables used in this function are : TABLE_ADVERTISEMENT
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    //category Listing
    function getCatAds()
    {
        global $objCore;

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

        $varQuery = "SELECT pkAdID,AdType,Title,AdUrl,ImageName,ImageSize,HtmlCode, CategoryPages
            FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND AdsStartDate<='" . $curDate . "' AND AdsEndDate >='" . $curDate . "' AND `AdsPage` = 'Menu Category Image'";

        //Create memcache object
        global $oCache;
        //Create object key for cache object
        $varQueryKey = md5($varQuery);
        //Check memcache is enabled or not
        if ($oCache->bEnabled)
        { // if Memcache enabled
            if (!$oCache->getData($varQueryKey))
            {
                $arrRes = $this->getArrayResult($varQuery);
                $oCache->setData($varQueryKey, serialize($arrRes));
            }
            else
            {
                $arrRes = unserialize($oCache->getData($varQueryKey));
            }
        }
        else
        {
            $arrRes = $this->getArrayResult($varQuery);
        }


        $addStr = '';
        $catAds = $ads = $arrCat = $tmpAry = array();
        if (count($arrRes) > 0)
        { //$objPage->arrData['arrAdsDetails'][0]['AdType']=='link'
            //$addStr .='<div class="img_sec">';
            foreach ($arrRes as $addAry)
            {
                if ($addAry['AdType'] == 'link')
                {
                    $ads[$addAry['pkAdID']] = '<div class="adimg"><a href="' . $addAry['AdUrl'] . '" target="_blank"><img src="' . UPLOADED_FILES_URL . '/images/ads/243x117/' . $addAry['ImageName'] . '" alt="' . $addAry['Title'] . '" title="' . $addAry['Title'] . '"/></a></div>';
                }
                else
                {
                    $ads[$addAry['pkAdID']] = html_entity_decode(stripslashes($addAry['HtmlCode']));
                }
                $tmpAry = explode(",", $addAry['CategoryPages']);
                foreach ($tmpAry as $cat)
                {
                    $catAds[$cat][] = $addAry['pkAdID'];
                }
            }
            //$addStr .='</div>';
        }
        //pre($ads);
        return array($ads, $catAds);
    }

    /**
     * function CategoryList
     *
     * This function is used get category.
     *
     * Database Tables used in this function are : TABLE_CATEGORY
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function CategoryList($argWhere = '', $argLimit = '')
    {
        /*
          $arrClms = array('pkCategoryId', 'CategoryName');
          $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId=0';
          $varOrderBy = 'CategoryOrdering ASC, CategoryName ASC';
          $varTable = TABLE_CATEGORY. " LEFT JOIN ".TABLE_PRODUCT." ON pkCategoryId=fkCategoryID" ;
          $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
         */

        /* $arrClms = array('c.pkCategoryId', 'c.CategoryName', 'c.CategoryDescription', 'c.CategoryParentId', 'p.CategoryName as CategoryParentName', 'c.CategoryStatus', 'c.CategoryLevel');
          $varOrderBy = 'c.CategoryHierarchy, c.CategoryName ASC ';
          $argWhere= 'c.CategoryIsDeleted = 0 AND c.CategoryStatus = 1';
          $varTable = TABLE_CATEGORY . ' as c LEFT JOIN ' . TABLE_CATEGORY . ' as p ON c.CategoryParentId=p.pkCategoryId';
          $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit); */

        $arrClms = " pkCategoryId,CategoryName ";
        $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId=0';
        $varOrderBy = 'CategoryOrdering ASC, CategoryName ASC';
        $varTable = TABLE_CATEGORY;
        $varLimit = ($argLimit <> '') ? " LIMIT " . $argLimit : "";
        $varQuery = "SELECT " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhere . " GROUP BY pkCategoryId ORDER BY " . $varOrderBy . " " . $varLimit;

        $arrRes = $this->getArrayResult($varQuery);




        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function CmsList
     *
     * This function is used get content list.
     *
     * Database Tables used in this function are : TABLE_CMS
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function CmsList()
    {
        $arrClms = array('pkCmsID', 'PageTitle', 'PageDisplayTitle', 'PageContent', 'PagePrifix');
        $varTable = TABLE_CMS;
        $argWhere = 'PageStatus = "Publish"';
        $varOrderBy = 'PageOrdering ASC ';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
        return $arrRes;
    }

    /**
     * function ceilHalf
     *
     * This function is used get ceil.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function ceilHalf($number)
    {
        $div = round($number / .5);
        $mod = $number % .5;

        if ($mod > 0)
            $add = .5;
        else
            $add = 0;

        return $div * .5 + $add;
    }

    /**
     * function getRatting
     *
     * This function is used get rating.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function getRatting($ratting)
    {

        if (!empty($ratting))
        {
            $ratting = $this->ceilHalf($ratting);
            $top = 18 * ($ratting / .5) - 18;
            $top = "-" . $top;
        }
        else
        {
            $top = 0;
        }
        return '<div class="inner_rating avg_rating" style="background: url(\'' . SITE_ROOT_URL . 'common/images/star_ratting.png\') no-repeat 0px ' . $top . 'px;"></div>';
    }

    /**
     * function dateDiffInDays
     *
     * This function is used get date difference.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 2 date
     *
     * @return string $arrRes
     */
    function dateDiffInDays($date1, $date2)
    {
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
        $seconds_diff = $ts2 - $ts1;
        return floor($seconds_diff / 3600 / 24);
    }

    /**
     * function getSuperAdminDetails
     *
     * This function is used get super admin details.
     *
     * Database Tables used in this function are : TABLE_ADMIN
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function getSuperAdminDetails()
    {
        $arrClms = array('AdminUserName', 'AdminEmail');
        $varTable = TABLE_ADMIN;
        $argWhere = 'AdminType = "super-admin"';
        $varOrderBy = 'pkAdminID ASC ';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
        return $arrRes;
    }

    /**
     * function getTicketTitle
     *
     * This function is used get ticket title.
     *
     * Database Tables used in this function are : TABLE_SUPPORT_TICKET_TYPE
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function getTicketTitle($ticketId)
    {
        $arrClms = array('pkTicketID', 'TicketTitle');
        $varTable = TABLE_SUPPORT_TICKET_TYPE;
        $argWhere = 'pkTicketID = "' . trim($ticketId) . '"';
        $varOrderBy = 'pkTicketID ASC ';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
        return $arrRes;
    }

    /**
     * function topMenuTree
     *
     * This function is used get category.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 3 array
     *
     * @return string $arrRes
     */
    function topMenuTree(&$arrCat, &$arrCatChild, &$arrCatAds)
    {
        $objCore = new Core();
        $res = '';
        $count = 0;
        //Create memcache object
        global $oCache;
        //Create object key for cache object
        //Check memcache is enabled or not

        for ($i = 0; $i < TOP_MENU_LIMIT; $i++)
        {
            $v = $arrCat[0][$i];
            $count++;
            $countMenuSubTree = $this->countMenuSubTree($v['pkCategoryId']);
            $varQueryKey = md5($v['pkCategoryId']);
            $retRes = $this->topMenuSubTree($arrCat, $arrCatChild, $arrCatAds, $v['pkCategoryId'], $v['CategoryName'], $countMenuSubTree['pkCategoryId']);
            if ($oCache->bEnabled)
            { // if Memcache enabled
                if (!$oCache->getData($varQueryKey))
                {
                    $tt = $this->tree($arrCat, $arrCatChild, $arrCatAds, $v['pkCategoryId'], $v['CategoryName']);
                    //$arrRes = $this->getArrayResult($varQuery);
                    $oCache->setData($varQueryKey, serialize($tt));
                }
                else
                {
                    $tt = unserialize($oCache->getData($varQueryKey));
                }
            }
            else
            {
                $tt = $this->tree($arrCat, $arrCatChild, $arrCatAds, $v['pkCategoryId'], $v['CategoryName']);
            }

            //print_r($tt);
            $res .= '<li ' . ($count == (TOP_MENU_LIMIT + 1) ? ' class="last"' : '') . '><a class="childimg" href="' . $objCore->getUrl('landing.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '" ' . ($retRes != '' ? 'rel="ddsubmenu' . $count . '"' : '') . '>' . ucfirst($v['CategoryName']) . '</a>' . $tt . '</li>';
        }
        // pre($res);
        return $res;
    }

    function tree(&$arrCat, &$arrCatChild, &$arrCatAds, $parent, $parentName)
    {
        //This function use to display secound lavel category
        $objCore = new Core();
        $count = $mcount = 0;

        if (count($arrCat[$parent]) > 0)
        {
            $res .= '<div class="dropdowns_outer"><div class="dropdowns_inner">';
            foreach ($arrCat[$parent] as $key => $v)
            {
                $retRes = $this->topMenuSubSubTree($arrCatChild, $v['pkCategoryId'], $v['CategoryName']);
                if ($retRes != '')
                {

                    $mcount++;
                    //pre($arrCatAds[1][$parent][0]);
                    //echo '<br>';
                    //Limit was set here only 3 due to which 3 banners was coming on the frontend.
                    $addStr = '<div class="img_sec">';
                    for ($a = 0; $a < 4; $a++)
                    {

                        $addStr.= $arrCatAds[0][$arrCatAds[1][$parent][$a]];
                    }
                    $addStr.= '</div>';

                    $getSeoundLavelCategoryChildProducts = $this->getSeoundLavelCategoryChildProducts($v['pkCategoryId']);
                    //echo '<pre>';print_r($getSeoundLavelCategoryChildProducts[0]);
                    //echo $getSeoundLavelCategoryChildProducts[0]['pkProductID'].'--'.$v['CategoryName'];
                    if ((int) $getSeoundLavelCategoryChildProducts[0]['pkProductID'] > 1)
                    {
                        $count++;
                        //echo $getSeoundLavelCategoryChildProducts[0]['pkProductID'].'--'.$v['pkCategoryId'].'--'.$v['CategoryName'].'<br>';
                        if ($count % 2 == 1)
                            $res .= '<div class="section_1">';
                        $res .= '<a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '" class="h4_menu"><h4>' . ucfirst($v['CategoryName']) . '</h4></a>' . $retRes;

                        if ($count % 2 == 0)
                            $res .= '</div>';
                    }
                }

                if ($count == 8)
                {
                    break;
                }
            }
            if ($count % 2 == 1)
                $res .= '</div>';
            $res .= '<div class="section_1" style="float:right">' . $addStr . '</div>';
            $res .='</div></div>';
        }

        //pre($res);
        return $res;
    }

    function countMenuSubTree($catId)
    {

        $arrV = array('count(pkCategoryId) as pkCategoryId');
        $where = "CategoryParentId='" . $catId . "'";
        $res = $this->select(TABLE_CATEGORY, $arrV, $where);
        return $res[0];
    }

    /* This function use to get if category or child category have products;
     * 
     *  */

    function getSeoundLavelCategoryChildProducts($catId)
    {
        $arrV = array('GROUP_CONCAT(pkCategoryId) AS pkCategoryId');
        $where = "CategoryParentId='" . $catId . "'";
        $res = $this->select(TABLE_CATEGORY, $arrV, $where);
        if (count($res))
        {
            $arrCategorys = array('count(pkProductID) as pkProductID');
            $whereCategorys = "fkCategoryID in (" . $res[0]['pkCategoryId'] . ")";
            //Create memcache object
            global $oCache;
            //Create object key for cache object
            $varQueryKey = md5($whereCategorys);
            //Check memcache is enabled or not
            if ($oCache->bEnabled)
            { // if Memcache enabled
                if (!$oCache->getData($varQueryKey))
                {
                    $resCategorys = $this->select(TABLE_PRODUCT, $arrCategorys, $whereCategorys);
                    $oCache->setData($varQueryKey, serialize($resCategorys));
                }
                else
                {
                    $resCategorys = unserialize($oCache->getData($varQueryKey));
                }
            }
            else
            {
                $resCategorys = $this->select(TABLE_PRODUCT, $arrCategorys, $whereCategorys);
            }
        }
        //pre($resCategorys);
        return $resCategorys;
    }

    function topDropTreeLst(&$arrCat, &$arrCatAds)
    { //pre($arrCat);
        $objCore = new Core();
        $res = '';
        $addStr = '';
        $count = $mcount = 0;
        for ($i = TOP_MENU_LIMIT; $i < count($arrCat[0]); $i++)
        {
            $v = $arrCat[0][$i];
            $parent = $v['pkCategoryId'];
            $parentName = $v['CategoryName'];
            //echo $v['CategoryName'];
            $count++;

            $addStr = '<div class="img_sec">';
            for ($a = 0; $a < 4; $a++)
            {
                $addStr.= $arrCatAds[0][$arrCatAds[1][$parent][$a]];
            }
            $addStr.= '</div>';

            //echo $v['CategoryName'];
            //$addStr = $this->getAdsDetails($v['pkCategoryId'], 3);
            $retRes = $this->topDropMenuSubTreeLast($arrCat, $v['pkCategoryId'], $parentName);
            if ($count % 2 == 1)
            {
                $res .= '<div class="section_1">';
                $res .= '<a class="childimg" href="' . $objCore->getUrl('landing.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '" class="h4_menu"><h4>' . ucfirst($v['CategoryName']) . '</h4></a>' . $retRes;
            }
            else
            {
                $res .= '<a class="childimg" href="' . $objCore->getUrl('landing.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '" class="h4_menu"><h4>' . ucfirst($v['CategoryName']) . '</h4></a>' . $retRes;
            }
            if ($count % 2 == 0)
            {
                $res .= '</div>';
            }

            if ($count == 8)
            {
                break;
            }
        }

        if ($count % 2 == 1)
        {
            $res .= '</div>';
            $res .= '<div class="section_1" style="float:right">' . $addStr . '</div>';
        }
        return $res;
    }

    function topDropMenuSubTreeLast(&$arrCat, $parent, $parentName = '')
    {
        $objCore = new Core();
        $res = '';
        $count = 0;
        if (count($arrCat[$parent]) > 0)
        {
            foreach ($arrCat[$parent] as $key => $v)
            {
                $count++;
                if ($count > 6)
                {
                    $res .= '<a href="' . $objCore->getUrl('category.php', array('cid' => $parent, 'name' => $parentName)) . '" class="more_cat">more...</a>';
                    break;
                }
                else
                {
                    $res .= '<a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '">' . ucfirst($v['CategoryName']) . '</a>';
                }
            }
        }
        return $res;
    }

    /**
     * function topMenuSubTree
     *
     * This function is used get category tree.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 5 array
     *
     * @return string $arrRes
     */
    function topMenuSubTree(&$arrCat, &$arrCatChild, &$arrCatAds, $parent, $parentName, $coutSub)
    {
        $objCore = new Core();
        $res = '';

        $count = $mcount = 0;
        //echo count($arrCat[$parent]).'<br>';
        if (count($arrCat[$parent]) > 0)
        {
            $res .= '<div class="dropdowns_outer"><div class="dropdowns_inner">';
            foreach ($arrCat[$parent] as $v)
            { //pre($v);
                //mail('raju.khatak@mail.vinove.com','hi',$coutSub);
                $count++;
                //$count > 10
                //echo $count.'<br>';




                if ($count > 10)
                {
                    $mcount++;
                    if (count($arrCat[$parent]) > 34 && $mcount > 23)
                    {
                        $retResMore .= '<a href="' . $objCore->getUrl('category.php', array('cid' => $parent, 'name' => $parentName)) . '">more...</a>';
                        break;
                    }
                    $retResMore .= '<div class="section_1"><a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '">' . ucfirst($v['CategoryName']) . '</a></div>';
                    if ($mcount % 12 == 0)
                    {
                        $retResMore .= '</div><div class="section_1">';
                    }
                }
                else
                {
                    $addStr = '<div class="img_sec">';
                    for ($a = 0; $a < 4; $a++)
                    {
                        $addStr .= $arrCatAds[0][$arrCatAds[1][$v['pkCategoryId']][$a]];
                    }
                    $addStr .= '</div>';

                    //$addStr = $this->getAdsDetails($v['pkCategoryId'], 3);
                    $retRes = $this->topMenuSubSubTree($arrCatChild, $v['pkCategoryId'], $v['CategoryName']);
                    if ($retRes != '')
                    {
                        $res .= '<div class="section_1"><a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '"><h4>' . ucfirst($v['CategoryName']) . '</h4></a>' . $retRes . $addStr . '</div>';
                    }
                }
            }
            //if ($count <= 10)
            if ($count > 10)
            {
                $res .= '<a href="' . $objCore->getUrl('category.php', array('cid' => $parent, 'name' => $parentName)) . '">more...</a>' . $retResMore . '';
            }
            $res .= '</div></div>';
        }
        return $res;
    }

    /**
     * function topMenuSubSubTree
     *
     * This function is used get category tree.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 3 array
     *
     * @return string $arrRes
     */
    function topMenuSubSubTree(&$arrCat, $parent, $parentName)
    {

        //This function  use to show third lavel category
        $objCore = new Core();
        $res = '';

        $count = 0;
        if (count($arrCat[$parent]) > 0)
        {
            //$res .= '<ul class="dropdetail_inner">';
            foreach ($arrCat[$parent] as $v)
            {
                $count++;
                if ($count > 6)
                {
                    $res .= '<a href="' . $objCore->getUrl('category.php', array('cid' => $parent, 'name' => $parentName)) . '" class="more_cat">more...</a>';
                    break;
                }
                else
                {
                    $res .= '<a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '">' . ucfirst($v['CategoryName']) . '</a>';
                }
            }
            //$res .= '</ul>';
        }
        return $res;
    }

    /* function topMenuSubTree($parent, $count) {
      $objCore = new Core();
      $arrClms = array('pkCategoryId', 'CategoryParentId', 'CategoryName', 'CategoryLevel', 'CategoryDescription', 'CategoryOrdering', 'CategoryHierarchy', 'CategoryStatus', 'CategoryIsDeleted', 'CategoryDateAdded', 'CategoryDateModified');
      $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId=' . $parent;
      $varOrderBy = 'CategoryOrdering ASC, CategoryHierarchy ASC, CategoryLevel ASC';
      $varTable = TABLE_CATEGORY;
      $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
      if (count($arrRes) > 0) {
      $res .= '<ul class="ddsubmenustyle" id="ddsubmenu' . $count . '">';
      foreach ($arrRes as $v) {
      $count++;
      $retRes = $this->topMenuSubTree($v['pkCategoryId'], $count);
      $res .= '<li><a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '" ' . ($retRes != '' ? 'rel="ddsubmenu' . $count . '"' : '') . '>' . ucfirst($v['CategoryName']) . '</a>' . $retRes . '</li>';
      }
      $res .= '</ul>';
      }
      return $res;
      } */

    /**
     * function topDropTree
     *
     * This function is used get category tree.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 5 array
     *
     * @return string $arrRes
     */
    function topDropTree(&$arrCat, &$arrCatAds)
    {
        $objCore = new Core();
        /*
          $arrClms = array('pkCategoryId', 'CategoryParentId', 'CategoryName', 'CategoryLevel', 'CategoryDescription', 'CategoryOrdering', 'CategoryHierarchy', 'CategoryStatus', 'CategoryIsDeleted', 'CategoryDateAdded', 'CategoryDateModified');
          $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId=0';
          $varOrderBy = 'CategoryOrdering ASC';
          $varTable = TABLE_CATEGORY;
          $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
         */

        /* $arrClms = " pkCategoryId,CategoryParentId,CategoryName,CategoryLevel,CategoryDescription,CategoryOrdering ";
          $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId=0';
          $varOrderBy = 'CategoryOrdering ASC, CategoryName ASC';
          $varTable = TABLE_CATEGORY;
          $varLimit = ($argLimit <> '') ? " LIMIT " . $argLimit : "";

          $varQuery = "SELECT " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhere . " GROUP BY pkCategoryId ORDER BY " . $varOrderBy . " " . $varLimit;

          $arrRes = $this->getArrayResult($varQuery); */


        $res = '';
        $count = $mcount = 0;
        for ($i = TOP_MENU_LIMIT; $i < count($arrCat[0]); $i++)
        {
            $v = $arrCat[0][$i];
            $count++;
            if ($count > 10)
            {
                $mcount++;
                if (count($arrRes) > 46 && $mcount > 35)
                {
                    $retResMore .= '<li><a href="' . $objCore->getUrl('category.php', array('cid' => $parent, 'name' => $parentName)) . '">more...</a></li>';
                    break;
                }
                $retResMore .= '<li><a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '">' . ucfirst($v['CategoryName']) . '</a></li>';

                if ($mcount % 12 == 0)
                {
                    $retResMore .= '</ul><ul class="dropdetail_inner">';
                }
            }
            else
            {
                $addStr = '<div class="img_sec">';
                for ($a = 0; $a < 4; $a++)
                {
                    $addStr .= $arrCatAds[0][$arrCatAds[1][$v['pkCategoryId']][$a]];
                }
                $addStr .= '</div>';
                $parent = $v['pkCategoryId'];
                $parentName = $v['CategoryName'];
                //$addStr = $this->getAdsDetails($v['pkCategoryId'], 3);
                $retRes = $this->topDropMenuSubTree($arrCat, $v['pkCategoryId']);
                $res .= '<li><a class="childimg" href="' . $objCore->getUrl('landing.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '">' . ucfirst($v['CategoryName']) . '</a><div class="dropdetail_outer">' . $retRes . $addStr . '</div></li>';
            }
        }
        if ($count > 10)
        {
            $res .= '<li><a href="' . $objCore->getUrl('category.php', array('cid' => $parent, 'name' => $parentName)) . '">more...</a><div class="dropdetail_outer"><ul class="dropdetail_inner">' . $retResMore . '</ul></div></li>';
        }
        return $res;
    }

    /**
     * function topDropMenuSubTree
     *
     * This function is used get category sub tree.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 5 array
     *
     * @return string $arrRes
     */
    function topDropMenuSubTree(&$arrCat, $parent, $parentName = '')
    {
        $objCore = new Core();
        $res = '';
        /*
          $arrClms = array('pkCategoryId', 'CategoryParentId', 'CategoryName', 'CategoryLevel', 'CategoryDescription', 'CategoryOrdering', 'CategoryHierarchy', 'CategoryStatus', 'CategoryIsDeleted', 'CategoryDateAdded', 'CategoryDateModified');
          $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel = 1 AND CategoryParentId=' . $parent;
          $varOrderBy = 'CategoryOrdering ASC, CategoryHierarchy ASC, CategoryLevel ASC';
          $varTable = TABLE_CATEGORY;
          $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
         */

        /* $arrClms = " pkCategoryId,CategoryParentId,CategoryName,CategoryLevel,CategoryDescription,CategoryOrdering ";
          $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel = 1 AND CategoryParentId=' . $parent;
          $varOrderBy = 'CategoryOrdering ASC, CategoryHierarchy ASC, CategoryLevel ASC';
          $varTable = TABLE_CATEGORY;
          // $varLimit = ($argLimit <> '') ? " LIMIT " . $argLimit : "";

          $varQuery = "SELECT " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhere . " GROUP BY pkCategoryId ORDER BY " . $varOrderBy;

          $arrRes = $this->getArrayResult($varQuery); */


        $count = 0;
        if (count($arrCat[$parent]) > 0)
        {
            $res .= '<ul class="dropdetail_inner">';
            foreach ($arrCat[$parent] as $v)
            {
                $count++;
                //$retRes = $this->topDropMenuSubSubTree($v['pkCategoryId'] , $v['CategoryName']);
                //$res .= '<li class="first"><h3><a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '">' . ucfirst($v['CategoryName']) . '</a></h3></li>'.$retRes;

                if (count($arrRes) > 24 && $count > 23)
                {
                    $res .= '<li><a href="' . $objCore->getUrl('category.php', array('cid' => $parent, 'name' => $parentName)) . '">more...</a></li>';
                    break;
                }
                $res .= '<li><a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '">' . ucfirst($v['CategoryName']) . '</a></li>';

                if ($count % 12 == 0)
                {
                    $res .= '</ul><ul class="dropdetail_inner">';
                }
            }
            $res .= '</ul>';
        }
        return $res;
    }

    /**
     * function topDropMenuSubSubTree
     *
     * This function is used get category tree.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 2 array
     *
     * @return string $arrRes
     */
    function topDropMenuSubSubTree($parent, $parentName)
    {
        $objCore = new Core();
        $arrClms = array('pkCategoryId', 'CategoryParentId', 'CategoryName', 'CategoryLevel', 'CategoryDescription', 'CategoryOrdering');
        $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryLevel = 2 AND CategoryParentId=' . $parent;
        $varOrderBy = 'CategoryOrdering ASC, CategoryHierarchy ASC, CategoryLevel ASC';
        $varTable = TABLE_CATEGORY;
        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
        $count = 0;
        if (count($arrRes) > 0)
        {
            foreach ($arrRes as $v)
            {
                $count++;
                $res .= '<li>' . $count . '<a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '">' . ucfirst($v['CategoryName']) . '</a>' . $retRes . '</li>';
                if ($count > 10)
                {
                    $res .= '<li><a href="' . $objCore->getUrl('category.php', array('cid' => $parent, 'name' => $parentName)) . '">more...</a></li>';
                    break;
                    return $res;
                }
            }
        }
        return $res;
    }

    /* function topDropMenuSubTree($parent, $count) {
      $objCore = new Core();
      $arrClms = array('pkCategoryId', 'CategoryParentId', 'CategoryName', 'CategoryLevel', 'CategoryDescription', 'CategoryOrdering', 'CategoryHierarchy', 'CategoryStatus', 'CategoryIsDeleted', 'CategoryDateAdded', 'CategoryDateModified');
      $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId=' . $parent;
      $varOrderBy = 'CategoryOrdering ASC, CategoryHierarchy ASC, CategoryLevel ASC';
      $varTable = TABLE_CATEGORY;
      $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
      if (count($arrRes) > 0) {
      $res .= '<ul>';
      foreach ($arrRes as $v) {
      $count++;
      $retRes = $this->topDropMenuSubTree($v['pkCategoryId'], $count);
      $res .= '<li><a href="' . $objCore->getUrl('category.php', array('cid' => $v['pkCategoryId'], 'name' => $v['CategoryName'])) . '">' . ucfirst($v['CategoryName']) . '</a>' . $retRes . '</li>';
      }
      $res .= '</ul>';
      }
      return $res;
      } */

    /**
     * function leftMenuTree
     *
     * This function is used get category tree.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string $arrRes
     */
    function leftMenuTree($parent)
    {
        /*
          $arrClms = array('pkCategoryId', 'CategoryParentId', 'CategoryName', 'CategoryLevel', 'CategoryDescription', 'CategoryOrdering', 'CategoryHierarchy', 'CategoryStatus', 'CategoryIsDeleted', 'CategoryDateAdded', 'CategoryDateModified');
          $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId=' . $parent;
          $varOrderBy = 'CategoryOrdering ASC' . ($parent > 0 ? ', CategoryHierarchy ASC, CategoryLevel ASC' : '');
          $varTable = TABLE_CATEGORY;
          $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
         */

        $arrClms = " pkCategoryId,CategoryParentId,CategoryName,CategoryLevel,CategoryDescription,CategoryOrdering ";
        $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId=' . $parent;

        $varOrderBy = 'CategoryOrdering ASC' . ($parent > 0 ? ', CategoryHierarchy ASC, CategoryLevel ASC' : '');
        $varTable = TABLE_CATEGORY;
        // $varLimit = ($argLimit <> '') ? " LIMIT " . $argLimit : "";

        $varQuery = "SELECT " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhere . " GROUP BY pkCategoryId ORDER BY " . $varOrderBy;

        $arrRes = $this->getArrayResult($varQuery);

        $res = '';
        $count = 0;
        foreach ($arrRes as $v)
        {
            $count++;
            $retRes = $this->leftMenusubTree($v['pkCategoryId'], $count);
            $res .= '<li ' . (count($arrRes) == $count ? ' class="last"' : '') . '><a href="' . $v['pkCategoryId'] . '" ' . ($retRes != '' ? 'rel="ddsubmenuside' . $count . '"' : '') . ' class="ajax_category">' . ucfirst($v['CategoryName']) . '</a>' . $retRes . '</li>';
        }
        return $res;
    }

    /**
     * function leftMenusubTree
     *
     * This function is used get category tree.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 2 array
     *
     * @return string $arrRes
     */
    function leftMenusubTree($parent, $count)
    {
        $res = '';
        /*
          $arrClms = array('pkCategoryId', 'CategoryParentId', 'CategoryName', 'CategoryLevel', 'CategoryDescription', 'CategoryOrdering', 'CategoryHierarchy', 'CategoryStatus', 'CategoryIsDeleted', 'CategoryDateAdded', 'CategoryDateModified');
          $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId=' . $parent;
          $varOrderBy = 'CategoryOrdering ASC, CategoryHierarchy ASC, CategoryLevel ASC';
          $varTable = TABLE_CATEGORY;
          $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $argLimit);
         */

        $arrClms = " pkCategoryId,CategoryParentId,CategoryName,CategoryLevel,CategoryDescription,CategoryOrdering ";
        $varWhere = 'CategoryIsDeleted = 0 AND CategoryStatus = 1 AND CategoryParentId=' . $parent;
        $varOrderBy = 'CategoryOrdering ASC, CategoryHierarchy ASC, CategoryLevel ASC';
        $varTable = TABLE_CATEGORY;
        // $varLimit = ($argLimit <> '') ? " LIMIT " . $argLimit : "";

        $varQuery = "SELECT " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhere . " GROUP BY pkCategoryId ORDER BY " . $varOrderBy;

        $arrRes = $this->getArrayResult($varQuery);

        if (count($arrRes) > 0)
        {
            $res .= '<ul class="top_nav_inner" style="padding-left: 10%; width:90%" id="ddsubmenuside' . $count . '">';
            foreach ($arrRes as $v)
            {
                $count++;
                $retRes = $this->leftMenusubTree($v['pkCategoryId'], $count);
                $res .= '<li><a href="' . $v['pkCategoryId'] . '" ' . ($retRes != '' ? 'rel="ddsubmenuside' . $count . '"' : '') . ' class="ajax_category">' . ucfirst($v['CategoryName']) . ($retRes != '' ? '<img src="' . SITE_ROOT_URL . 'common/images/arrow-right.gif" style="width: 12px; height: 12px; left: 155px;" class="rightarrowpointer">' : '') . '</a>' . $retRes . '</li>';
            }
            $res .= '</ul>';
        }
        return $res;
    }

    /**
     * function getAdsDetails
     *
     * This function is used ads details.
     *
     * Database Tables used in this function are : TABLE_ADVERTISEMENT
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function getAdsDetails($catid, $limit)
    {
        $varQuery = "SELECT pkAdID,AdType,Title,AdUrl,ImageName,ImageSize,HtmlCode
            FROM " . TABLE_ADVERTISEMENT . " WHERE AdStatus = '1' AND `AdsPage` = 'Menu Category Image' AND find_in_set('" . $catid . "',`CategoryPages`)  order by rand() limit 0,$limit";
        $arrRes = $this->getArrayResult($varQuery);
        $addStr = '';
        if (count($arrRes) > 0)
        { //$objPage->arrData['arrAdsDetails'][0]['AdType']=='link'
            $addStr .='<div class="img_sec">';
            foreach ($arrRes as $addAry)
            {
                if ($addAry['AdType'] == 'link')
                {
                    $addStr .='<div class="adimg"><a href="' . $addAry['AdUrl'] . '" target="_blank"><img src="' . UPLOADED_FILES_URL . '/images/ads/243x117/' . $addAry['ImageName'] . '" alt="' . $addAry['Title'] . '" title="' . $addAry['Title'] . '" width="243" height="117"  /></a></div>';
                }
                else
                {
                    $addStr .=html_entity_decode(stripslashes($addAry['HtmlCode']));
                }
            }
            $addStr .='</div>';
        }
        //if($catid==345) echo $addStr;
        return $addStr;
    }

    /**
     * function getProductFeedbacks
     *
     * This function is used get product feedback.
     *
     * Database Tables used in this function are : TABLE_WHOLESALER_FEEDBACK
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    //category Listing
    function getProductFeedbacks($fkProductID)
    {
        $varQuery = "SELECT sum(IF(IsPositive=1,1,0)) AS positive, sum(IF(IsPositive=0,1,0)) AS negative
            FROM " . TABLE_WHOLESALER_FEEDBACK . " WHERE fkProductID = '$fkProductID' GROUP BY fkProductID";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function checkCmsExists
     *
     * This function is used veryfy cms details.
     *
     * Database Tables used in this function are : TABLE_WHOLESALER_FEEDBACK
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    //category Listing
    function checkCmsExists($arrPost)
    {
        $where = '';
        if ($arrPost['title'] == 'display title')
        {
            $where = "PageDisplayTitle='" . $arrPost['checkExist'] . "'";
        }
        if ($arrPost['title'] == 'Page title')
        {
            $where = "PageTitle='" . $arrPost['checkExist'] . "'";
        }
        if ($arrPost['title'] == 'Page Prifix')
        {
            $where = "PagePrifix='" . $arrPost['checkExist'] . "'";
        }

        $varQuery = "SELECT pkCmsID FROM " . TABLE_CMS . " WHERE $where";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return count($arrRes) > 0 ? '1' : '0';
    }

    /**
     * function myRatingDetails
     *
     * This function is used get rating details.
     *
     * Database Tables used in this function are : tbl_product_rating
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function myRatingDetails($_argProductId)
    {
        //$varQuery = "SELECT SUM(Rating) as numRating, count(fkCustomerID) as numCustomer  FROM " . TABLE_PRODUCT_RATING . " WHERE fkProductID = '" . $_argProductId . "' ";
        $varQuery = "SELECT SUM(rat.Rating) as numRating, count(rat.fkCustomerID) as numCustomer FROM " . TABLE_PRODUCT_RATING .
                " as rat LEFT JOIN " . TABLE_REVIEW . " as rev on rat.pkRateID=rev.pkReviewID WHERE rat.fkProductID = '" . $_argProductId . "' AND RatingApprovedStatus='Allow'";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    
    /**
     *  calculateMonthDate
     *  This function is used to calculate the date depending on months count and date required
     *  @param integer $date Date that will be used in this process to which number of months will be added/subtracted and the its required day's date will be calculated.
     *  @param integer $period number of months that wil be added/subtracted to $date variable.
     *  @param integer $day day whose date is required.
     *  @param char $operator either + or -.
     *  @return string 
     */
    
    public function calculateMonthDate($date, $period, $day, $operator){
        //echo $date.'=='.$period.'=='.$day.'=='.$operator;
        $resultDate='';
        $resultDate=date('Y-m-'.$day,strtotime(date('Y-m-d', strtotime($operator.$period." months", strtotime($date)))));
        return $resultDate;        
    }
    /**
     *  calculateCustomYearMonthDate
     *  This function is used to calculate the month date of years(either previous or upcoming)
     *  @param integer $format format of date returned.
     *  @param integer $periodYear number of years that wil be added/subtracted to current date
     *  @param integer $day first/last date according to the value.
     *  @param integer $month month according to the value.
     *  @return string 
     */
    
    public function calculateCustomYearMonthDate($format,$periodYear,$operator,$day,$month){
        if($periodYear=="" || $periodYear==0){
            $retVal=date($format, mktime(0, 0, 0, $month, $day, date("Y")));    
        }else{
            if($operator=="+"){
                $retVal=date($format, mktime(0, 0, 0, $month, $day, date("Y")+$periodYear));
            }else{
                $retVal=date($format, mktime(0, 0, 0, $month, $day, date("Y")-$periodYear));
            }
        }
        return $retVal;
    }
    
    /**
     *  compareDate
     *  This function is used to compare date which will be get by adding number of months to the date sent to this function.
     *  @param integer $dateToCompare Date that will be used in this process to compare with current date.
     *  @param integer $month number of months that wil be added to dateToCompare variable.
     *  @return boolean 
     */
    public function compareDate($dateToCompare, $month ,$days){          
        if ($month == 'next'){
            $date=date('Y-m-d',strtotime(date('Y-m-10', strtotime("+1 months", strtotime($dateToCompare)))));
            //echo $dateToCompare.'=='.$date;
            //die;
            if(strtotime($date) > strtotime(date('Y-m-d',time()))){
                return true;
            }else{
                return false;
            }
        }  
    }
    
    public function getlastWeekDates(){          
        $lastWeek = array();
        
        $prevMon = abs(strtotime("previous monday"));
        $currentDate = abs(strtotime("today"));
        $seconds = 86400; //86400 seconds in a day
     
        $dayDiff = ceil( ($currentDate-$prevMon)/$seconds );
     
        if( $dayDiff < 7 )
        {
            $dayDiff += 1; //if it's monday the difference will be 0, thus add 1 to it
            $prevMon = strtotime( "previous monday", strtotime("-$dayDiff day") );
        }
     
        $prevMon = date("Y-m-d",$prevMon);
     
        // create the dates from Monday to Sunday
        for($i=0; $i<7; $i++)
        {
            $d = date("Y-m-d", strtotime( $prevMon." + $i day") );
            $lastWeek[]=$d;
        }
     
        return $lastWeek;
    }
    
    public function getWeeks($month,$year){
        $month = intval($month);	//force month to single integer if '0x'
        $suff = array('st','nd','rd','th','th','th'); //week suffixes
        $end = date('t',mktime(0,0,0,$month,1,$year)); //last date day of month: 28 - 31
        $start = date('w',mktime(0,0,0,$month,1,$year)); //1st day of month: 0 - 6 (Sun - Sat)
        $last = 7 - $start; //get last day date (Sat) of first week
        $noweeks = ceil((($end - ($last + 1))/7) + 1);	//total no. weeks in month
        $output = "";	//initialize string
        $monthlabel = str_pad($month, 2, '0', STR_PAD_LEFT);
        for($x=1;$x<$noweeks+1;$x++){	
            if($x == 1){
                $startdate = "$year-$monthlabel-01";
                $day = $last - 6;
            }else{
                $day = $last + 1 + (($x-2)*7);
                $day = str_pad($day, 2, '0', STR_PAD_LEFT);
                $startdate = "$year-$monthlabel-$day";
            }
            if($x == $noweeks){
                $enddate = "$year-$monthlabel-$end";
            }else{
                $dayend = $day + 6;
                $dayend = str_pad($dayend, 2, '0', STR_PAD_LEFT);
                $enddate = "$year-$monthlabel-$dayend";
            }
            $arrWeeks[$x]['startDate']=$startdate;
            $arrWeeks[$x]['endDate']=$enddate;
            //$output .= "{$x}{$suff[$x-1]} week -> Start date=$startdate End date=$enddate <br />";	
        }
        return $arrWeeks;
    }

}

//end class
?>
