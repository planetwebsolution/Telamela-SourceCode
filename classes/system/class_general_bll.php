<?php

/**
 *
 *  Module name : General
 *
 *  Parent module : None
 *
 *  Date created : 26th February 2013
 *
 *  Date last modified : 29th Oct 2013
 *
 *  Author : Charanjeet Singh
 *
 *  Last modified by : Suraj Kumar Maurya
 *
 *  Comments : The general class contains general functions for all modules.
 *
 */
class General extends Database {

    function General() {
        
    }

    /**
     *
     *      Function Name : imageUpload
     *
     *      Return type : String (image filename)
     *
     *      Date created : 26th February 2013
     *
     *      Date last modified : 26th February 2013
     *
     *      Author : Charanjeet Singh
     *
     *      Last modified by : Charanjeet Singh
     *
     *      Comments : This function will upload the image from temp folder to main folder
     *
     *      User instruction : $obj->imageUpload($argFILES,$argVarProductName)
     */
    function imageUpload($argFILES, $argVarProductName, $argVarDirLocation) {

        $objUpload = new upload();

        $objCore = new Core();



        $objUpload->setMaxSize();



// Set Directory

        $objUpload->setDirectory($argVarDirLocation);



        $varIsImage = $objUpload->IsImageValid($argFILES['type']);

        if ($varIsImage) {

            $varImageExists = 'yes';
        } else {

            $varImageExists = 'no';
        }

        if ($varImageExists == 'no') {

            $objCore->setErrorMsg("This is not a valid image.");

            return false;
        }



        if ($varImageExists == 'yes') {

            $objUpload->setTmpName($argFILES['tmp_name']);

//echo $objUpload->userTmpName;die;

            if ($objUpload->userTmpName) {

// Set file size

                $objUpload->setFileSize($argFILES['size']);



// Set File Type

                $objUpload->setFileType($argFILES['type']);

// Set File Name

                $fileName = $argVarProductName . '_' . strtolower($argFILES['name']);

//replace space with an underscore

                $fileName = str_replace(' ', '_', $fileName);

                $objUpload->setFileName($fileName);

// Start Copy Process

                $objUpload->startCopy();



// If there is error write the error message



                if ($objUpload->isError()) {

// Set a thumbnail name

                    $thumbnailName1 = '_thumb';

                    $objUpload->setThumbnailName($thumbnailName1);



// create thumbnail

                    $objUpload->createThumbnail();



// change thumbnail size

                    $objUpload->setThumbnailSize(100, 100);



//Get file name from the class public variable

                    $varFileName = $objUpload->userFileName;



//Get file extention

                    $varExt = substr(strrchr($varFileName, "."), 1);



                    $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));



//Create thumb file name

                    $varThumbFileName = $varThumbFileNameNoExt . 'thumb.' . $varExt;



//Add  fields in pictures table

                    return $varFileName;
                } else {

                    $objCore->setErrorMsg("There was an error uploading your image.");

                    return false;
                }
            }
        }
    }

    /**
     *
     * Function Name : imageCalenderIconUpload
     *
     * Return type : String (image filename)
     *
     * Date created : 26th February 2013
     *
     * Date last modified : 26th February 2013
     *
     * Author : Charanjeet Singh
     *
     * Last modified by : Charanjeet Singh
     *
     * Comments : This function will upload the image from temp folder to main folder
     *
     * User instruction : $obj->imageCalenderIconUpload($argFILES,$argVarProductName)
     *
     */
    function imageCalenderIconUpload($argFILES, $argVarProductName, $argVarDirLocation) {

        $objUpload = new upload();

        $objCore = new Core();



        $objUpload->setMaxSize();



// Set Directory

        $objUpload->setDirectory($argVarDirLocation);



        $varIsImage = $objUpload->IsImageValid($argFILES['type']);

        if ($varIsImage) {

            $varImageExists = 'yes';
        } else {

            $varImageExists = 'no';
        }

        if ($varImageExists == 'no') {

            $objCore->setErrorMsg("This is not a valid image.");

            return false;
        }



        if ($varImageExists == 'yes') {

            $objUpload->setTmpName($argFILES['tmp_name']);

//echo $objUpload->userTmpName;die;

            if ($objUpload->userTmpName) {

// Set file size

                $objUpload->setFileSize($argFILES['size']);



// Set File Type

                $objUpload->setFileType($argFILES['type']);

// Set File Name

                $fileName = $argVarProductName . '_' . strtolower($argFILES['name']);

//replace space with an underscore

                $fileName = str_replace(' ', '_', $fileName);

                $objUpload->setFileName($fileName);

// Start Copy Process

                $objUpload->startCopy();



// If there is error write the error message



                if ($objUpload->isError()) {

// Set a thumbnail name

                    $thumbnailName1 = '_thumb';

                    $objUpload->setThumbnailName($thumbnailName1);



// create thumbnail

                    $objUpload->createThumbnail();



// change thumbnail size

                    $objUpload->setThumbnailSize(40, 40);



//Get file name from the class public variable

                    $varFileName = $objUpload->userFileName;



//Get file extention

                    $varExt = substr(strrchr($varFileName, "."), 1);



                    $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));



//Create thumb file name

                    $varThumbFileName = $varThumbFileNameNoExt . 'thumb.' . $varExt;



//Add  fields in pictures table

                    return $varFileName;
                } else {

                    $objCore->setErrorMsg("There was an error uploading your image.");

                    return false;
                }
            }
        }
    }

    /**
     *
     * Function Name : getRecord
     *
     * Return type : None
     *
     * Date created : 26th February 2013
     *
     * Date last modified : 28th February 2013
     *
     * Author : Charanjeet Singh
     *
     * Modified By : Sandeep Kumar
     *
     * Comments : This is used to get informtion from any Table.
     *
     * User instruction : $objCore->getRecord();
     *
     */
    function getRecord($argTable, $argArrColums, $argVarWhr = '', $argVarOrderBy = '', $argVarLimit = '') {

        return $this->select($argTable, $argArrColums, $argVarWhr, $argVarOrderBy, $argVarLimit);
    }

    /**
     *
     * Function Name : updateRecord
     *
     * Return type : None
     *
     * Date created : 26th February 2013
     *
     * Date last modified : 28th February 2013
     *
     * Author : Charanjeet Singh
     *
     * Modified By : Sandeep Kumar
     *
     * Comments : This is used to update records in any Table.
     *
     * User instruction : $objCore->updateRecord();
     *
     */
    function updateRecord($argVarTable, $argArrColumns, $argVarWhere) {

        $this->update($argVarTable, $argArrColumns, $argVarWhere);

        return true;
    }

    /**
     *
     * Function Name : deleteImage
     *
     * Return type : Boolean
     *
     * Date created : 04th August 2013
     *
     * Date last modified : 04th August 2013
     *
     * Author : Pankaj Pandey
     *
     * Last modified by : Pankaj Pandey
     *
     * Comments : This function will delete the image from folder
     *
     * User instruction : $obj->deleteImage($argVarImageName)
     *
     */
    function deleteImage($argVarImageName) {

//set main banner directory
        if ($argDirectoryPath != '') {
            $varDirectory = $argDirectoryPath;
        } else {
            $varDirectory = SOURCE_ROOT . 'common/uploaded_files/edition/';
        }
//set image thumb here
        $arrEditionImageName = explode('.', $argVarImageName);
        $arrEditionImageName['0'] = $arrEditionImageName['0'] . '_edition_thumb';
        $varEditionImageThumb = implode('.', $arrEditionImageName);
//set popular store thumb
        $arrEditionSecondImageName = explode('.', $argVarImageName);
        $arrEditionSecondImageName['0'] = $arrEditionSecondImageName['0'] . '_edition_second_thumb';
        $varEditionSecondImageThumb = implode('.', $arrEditionSecondImageName);
//find the main file and if found then delete it
        if (file_exists($varDirectory . $argVarImageName)) {
            unlink($varDirectory . $argVarImageName);
        }
//find the thumb file and if found then delete it
        if (file_exists($varDirectory . $varEditionImageThumb)) {
            unlink($varDirectory . $varEditionImageThumb);
        }
//find the thumb file and if found then delete it
        if (file_exists($varDirectory . $varEditionSecondImageThumb)) {
            unlink($varDirectory . $varEditionSecondImageThumb);
        }
        return true;
    }

    /**
     *
     * Function Name : checkImageSize
     *
     * Return type : Boolean
     *
     * Date created : 26th February 2013
     *
     * Date last modified : 26th February 2013
     *
     * Author : Charanjeet Singh
     *
     * Last modified by : Charanjeet Singh
     *
     * Comments : This function will check the image size as per max coupon size
     *
     * User instruction : $obj->checkImageSize($argVarFile)
     *
     */
    function checkImageSize($argVarFile, $argVarMaxWidth, $argVarMaxHeight) {

//get the uploaded image size

        $arrCurrentImageDimesions = getimagesize($argVarFile);



        if (file_exists) {

//check the image size for any size violations

            if ($arrCurrentImageDimesions['0'] > argVarMaxWidth || $arrCurrentImageDimesions['1'] > argVarMaxHeight) {

                return false; // size violation.the image must be discarded.
            } else {

                return true; // no size violation.the image is ok.
            }
        }
    }

    /**
     *
     * Function Name : generateRandomKey
     *
     * Return type : None
     *
     * Date created : 28th February 2013
     *
     * Date last modified : 28th February 2013
     *
     * Author : Sandeep Kumar
     *
     * Modified BY : Sandeep Kumar
     *
     * Comments : This is used to generate random key.
     *
     * User instruction : $obj->generateRandomKey($argArr);
     *
     */
    function generateRandomKey($argLength = '', $argCharacterSet = '') {

// CHARACTER SET.

        if ($argCharacterSet == '') {

            $varCharacterSet = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } else {

            $varCharacterSet = $argCharacterSet;
        }

// CHECK FOR LENGTH OF KEY.

        if ($argLength == '') {

// DEFAULT KEY LENGTH.

            $varLength = 8;
        } else {

// USER DEFIND KEY LENGTH.

            $varLength = $argLength;
        }

        $varMax = strlen($varCharacterSet) - 1;

        $varValue = '';

        for ($i = 0; $i < $varLength; $i++) {

            $varValue .= $varCharacterSet{mt_rand(0, $varMax)};
        }

// RANDOM KEY.

        return $varValue;
    }

    /**
     *
     * Function Name : getValidRandomKey
     *
     * Return type : None
     *
     * Date created : 23th September 2013
     *
     * Date last modified : 23th September 2013
     *
     * Author : Ashok Singh Negi
     *
     * Modified BY : Ashok Singh Negi
     *
     * Comments : This is used to generate random key.
     *
     * User instruction : $obj->generateRandomKey($argArr);
     *
     */
    function getValidRandomKey($argVarTableName, $argArrColumns, $argVarWhereColumn, $argVarLength = '', $argVarCharacterSet = '', $argVarOption = '') {



        if ($argVarCharacterSet == '') {



            $argVarCharacterSet = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }



//if there is requirement to md5 or encrypt the key



        if ($argVarOption == 'md5') {



//get a random key generated and its md5 calculated



            $varRandomKey = md5($this->generateRandomKey($argVarLength, $argVarCharacterSet));
        }



        if ($argVarOption == 'combine') {



            $varRandomKeyPartOne = $this->generateRandomKey('8', '1234567890');



            $varRandomKeyPartTwo = $this->generateRandomKey('10', '23456789abcdefghijkmnpqrstuvwxyz');



            $varRandomKey = $varRandomKeyPartOne . '.' . $varRandomKeyPartTwo;
        } else {



//get a random key generated



            $varRandomKey = $this->generateRandomKey($argVarLength, $argVarCharacterSet);
        }







//check for existence of key in the database
//you can also send multiple columns here. For ex - send string like "Status = Active AND pkID". It will be generated like "Status = 'Active' AND pkID = '4ghg5tre4ty3fy5rt'"



        $varWhereCondition = $argVarWhereColumn . ' = \'' . $varRandomKey . '\'';







        if ($this->select($argVarTableName, $argArrColumns, $varWhereCondition)) {



//call this function recursively if the key generated is not unique



            getValidRandomKey($argVarTableName, $argArrColumns, $argVarWhereColumn, $argVarLength = '', $argVarCharacterSet = '', $argVarOption = '');
        } else {



            return $varRandomKey; //key is ok. return the key
        }
    }

    /**
     *
     * Function Name : random_string
     *
     * Return type : None
     *
     * Date created : 28th February 2013
     *
     * Date last modified : 28th February 2013
     *
     * Author : Prashant Kumar
     *
     * Modified BY : Prashant Kumar
     *
     * Comments : This is used to generate alpha numeric random key.
     *
     * User instruction : $obj->random_string();
     *
     */
    function random_string($type = 'alpha', $len = 8) {

        switch ($type) {

            case 'alnum' :

            case 'numeric' :

            case 'nozero' :



                switch ($type) {

                    case 'alnum' : $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                        break;

                    case 'numeric' : $pool = '0123456789';

                        break;

                    case 'nozero' : $pool = '123456789';

                        break;
                }



                $str = '';

                for ($i = 0; $i < $len; $i++) {

                    $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
                }

                return $str;

                break;

            case 'unique' : return md5(uniqid(mt_rand()));

                break;
        }
    }

    /**
     * Function Name : insertRecord
     *
     * Return type : None
     *
     * Date created : 26th Dec 2013
     *
     * Date last modified : 26 Dec. 2013
     *
     * Author : Parmjeet Singh
     *
     * Modified By : Parmjeet Singh
     *
     * Comments : This is used to insert informtion into any Table.
     *
     * User instruction : $objCore->insertRecord();
     *
     */
    function insertRecord($argTable, $argArrColums) {
        return $this->insert($argTable, $argArrColums);
    }

    /**
     * Function Name : home_string_pattern
     *
     * Return type : None
     *
     * Date created : 25th Oct 2013
     *
     * Date last modified :
     *
     * Author : Deepesh pathak
     *
     * Modified By :
     *
     * Comments :This change the string style
     *
     * User instruction : $objCore->home_string_Pattern($inputstring);
     *
     */
    function home_string_Pattern($string) {
        $string_array = explode(' ', $string);
        $result_string = $string_array[0];

        if (count($string_array) > 1) {
            $result_string = $result_string . "&nbsp;<span>";
            for ($i = 1; $i < count($string_array); $i++) {
                $result_string = $result_string . " " . $string_array[$i];
            }
            $result_string = $result_string . "</span>";
        }
        return $result_string;
    }

    /**
     * function getCommissionPeriod
     *
     * This function is used to get Commission Period.
     *
     * Database Tables used in this function are :
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrPeriod
     */
    function getCommissionPeriod() {
        $arrPeriod = array(
            '1 day' => '1 Day',
            //  '2 day' => '2 Day',
            '1 week' => '1 Week',
            //'2 week' => '2 Week',
            '1 month' => '1 Month',
            //'2 month' => '2 Month',
            '3 month' => 'Quarterly',
            // '6 month' => 'Half yearly',
            '1 year' => 'Yearly',
        );
        return $arrPeriod;
    }

    /**
     * function getCommissionPeriod
     *
     * This function is used to get Commission Period.
     *
     * Database Tables used in this function are :
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrPeriod
     */
    function getCurrentCommissionPeriodFilter($currentDate, $field = '') {
        $arrRes = $this->getDefaultCommision();
        $varPeriod = $arrRes['SalesPeriod'];

        $varField = ($field == '') ? " OrderDateAdded " : $field;

        $arrPeriod = array(
            '1 day' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '2 day' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '1 week' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '2 week' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '1 month' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '2 month' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '3 month' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '6 month' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '1 year' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")"
        );


        $varWhere = "AND " . $varField . ">=" . $arrPeriod[$varPeriod];
        $varGroupBy = $arrPeriod[$varPeriod];

        $arrPer = array(
            'where' => $varWhere,
            'groupBy' => $varGroupBy,
        );


        return $arrPer;
    }

    /**
     * function getCommissionPeriod
     *
     * This function is used to get Commission Period.
     *
     * Database Tables used in this function are :
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrPeriod
     */
    function getArchiveCommissionPeriodFilter($currentDate, $field = '') {
        $arrRes = $this->getDefaultCommision();
        $varPeriod = $arrRes['SalesPeriod'];

        $varField = ($field == '') ? " OrderDateAdded " : $field;

        $arrPeriodSelect = array(
            '1 day' => "DATE_FORMAT(" . $varField . ",'%Y-%m-%d') as Dated",
            '2 day' => "DATE_FORMAT(" . $varField . ",'%Y') as Dated",
            '1 week' => "YEARWEEK(" . $varField . ") as Dated",
            '2 week' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '1 month' => "DATE_FORMAT(" . $varField . ",'%Y-%m') as Dated",
            '2 month' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '3 month' => "QUARTER(" . $varField . ") as Dated",
            '6 month' => "DATE_FORMAT(" . $varField . ",'%Y') as Dated",
            '1 year' => " DATE_FORMAT(" . $varField . ",'%Y') as Dated"
        );

        $arrPeriodWhere = array(
            '1 day' => "",
            '2 day' => "",
            '1 week' => "",
            '2 week' => "",
            '1 month' => "",
            '2 month' => "",
            '3 month' => "",
            '6 month' => "",
            '1 year' => ""
        );

        $arrPeriodGroup = array(
            '1 day' => "Dated",
            '2 day' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '1 week' => "Dated",
            '2 week' => "Dated",
            '1 month' => "Dated",
            '2 month' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '3 month' => "Dated",
            '6 month' => "DATE_SUB('" . $currentDate . "', INTERVAL " . strtoupper($varPeriod) . ")",
            '1 year' => "Dated"
        );



        $arrPer = array(
            'select' => $arrPeriodSelect[$varPeriod],
            'where' => $arrPeriodWhere[$varPeriod],
            'groupBy' => $arrPeriodGroup[$varPeriod]
        );


        return $arrPer;
    }

    /**
     * function getDefaultCommision
     *
     * This function is used to get Default Commision.
     *
     * Database Tables used in this function are : TABLE_DEFAULT_COMMISSION
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrPeriod
     */
    function getDefaultCommision() {
        $arrRes = $this->select(TABLE_DEFAULT_COMMISSION, array('Wholesalers', 'AdminUsers', 'MarginCast', 'SalesPeriod'));
        return $arrRes[0];
    }

    /**
     * function wholesalerKpi
     *
     * This function is used to calculate wholesaler kpi in % .
     *
     * Database Tables used in this function are : TABLE_WHOLESALER,TABLE_ORDER_ITEMS
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function wholesalerKpi($whid) {

        $arrWholesalerRow = $this->getArrayResult("SELECT CompanyCountry FROM " . TABLE_WHOLESALER . " WHERE pkWholesalerID='" . $whid . "'");

        $arrKpiSettingRow = $this->getArrayResult("SELECT fkCountryID,KPIValue FROM " . TABLE_KPI_SETTING . " WHERE fkCountryID ='0' OR fkCountryID = '" . $arrWholesalerRow[0]['CompanyCountry'] . "' ORDER BY fkCountryID DESC");

        $varKpiSaleTarget = $arrKpiSettingRow[0]['KPIValue'];

        $arrSoldProduct = $this->getArrayResult("SELECT count(pkOrderItemID) as num FROM " . TABLE_ORDER_ITEMS . " WHERE fkWholesalerID='" . $whid . "'");

        $varTotalSoldProduct = $arrSoldProduct[0]['num'];

        if ($varTotalSoldProduct >= $varKpiSaleTarget) {
            $arrPostiveFeedback = $this->getArrayResult("SELECT count(pkFeedbackID) as num FROM " . TABLE_WHOLESALER_FEEDBACK . " WHERE fkWholesalerID='" . $whid . "' AND IsPositive=1 ");
            $arrTotalFeedback = $this->getArrayResult("SELECT count(pkFeedbackID) as num FROM " . TABLE_WHOLESALER_FEEDBACK . " WHERE fkWholesalerID='" . $whid . "'");


            $varTotalFeedback = $arrTotalFeedback[0]['num'];
            $varPostiveFeedback = $arrPostiveFeedback[0]['num'];
            if ($varTotalFeedback > 0) {
                $kpi = ($varPostiveFeedback / $varTotalFeedback) * 100;
            } else {
                $kpi = '100';
            }
            $kpi = number_format($kpi, 2);
        } else {
            $kpi = 'N/A';
        }

        $arrRes['kpi'] = $kpi;

        return $arrRes;
    }

    /**
     * function countryPortalFilter
     *
     * This function is used to retrive wholesaler based on country portal.
     *
     * Database Tables used in this function are :
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $varStr
     */
    function countryPortalFilter($argWids = '', $alias = '') {

        $varStr = "";
        $alias = (trim($alias)) ? $alias : 'fkWholesalerID';

        if ($argWids) {
            $varStr .= " AND " . $alias . " IN (" . $argWids . ") ";
        }

        return $varStr;
    }

    function customercountryPortalFilter($argWids = '', $alias = '') {

        $varStr = "";
        $alias = (trim($alias)) ? $alias : 'ResCountry';

        if ($argWids) {
            $varStr .= " AND " . $alias . " IN (" . $argWids . ") ";
        }

        return $varStr;
    }

    function tranactioncountryPortalFilter($argWids = '', $alias = '') {

        $varStr = "";
        $alias = (trim($alias)) ? $alias : 'pkAdminID';

        if ($argWids) {
            $varStr .= " AND " . $alias . " IN (" . $argWids . ") ";
        }

        return $varStr;
    }

    /**
     * function massConverter
     *
     * This function is used to retrive wholesaler based on country portal.
     *
     * Database Tables used in this function are :
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $varStr
     */
    function massConverter($argFromUnit = 'lb', $argToUnit = 'lbs', $weight = 0) {

        $key = strtoupper($argFromUnit . '-' . $argToUnit);

        $arrConverter = array(
            'KG-LBS' => '2.20462262',
            'G-LBS' => '0.00220462',
            'LB-LBS' => '1.00000',
            'OZ-LBS' => '0.0625',
            'KG-LB' => '2.20462262',
            'G-LB' => '0.00220462',
            'LB-LB' => '1.00000',
            'OZ-LB' => '0.0625',
        );
        $varStr = $arrConverter[$key] * $weight;

        return $varStr;
    }

    /**
     * function dimmensionConverter
     *
     * This function is used to retrive wholesaler based on country portal.
     *
     * Database Tables used in this function are :
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $varStr
     */
    function lengthConverter($argFromUnit = 'in', $argToUnit = 'in', $lenght = 0) {

        $key = strtoupper($argFromUnit . '-' . $argToUnit);

        $arrConverter = array(
            'CM-IN' => '0.393701',
            'MM-IN' => '0.0393701',
            'IN-IN' => '1.00000'
        );


        $varStr = ($arrConverter[$key] * $lenght);

        return $varStr;
    }

    /**
     * function getWholesalerAdmin
     *
     * This function is used to retrive admin details for wholesaler.
     *
     * Database Tables used in this function are : TABLE_WHOLESALER,TABLE_ADMIN
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getWholesalerAdmin($wid) {
        $varWhere = " pkWholesalerID = '" . $wid . "' ";
        $arrCls = array('CompanyCountry', 'CompanyRegion');
        $varTable = TABLE_WHOLESALER;
        $arrRes = $this->select($varTable, $arrCls, $varWhere);

        $varWhere = "AdminRegion = {$arrRes[0]['CompanyRegion']}";
        $arrClms = array('pkAdminID', 'AdminEmail');
        $varTable = TABLE_ADMIN;
        $arrRows = $this->select($varTable, $arrClms, $varWhere);

        if (empty($arrRows)) {
            $varWhere = "AdminCountry = {$arrRes[0]['CompanyCountry']}";
            $arrRows = $this->select($varTable, $arrClms, $varWhere);
            if (empty($arrRows)) {
                $varWhere = "AdminType = 'super-admin'";
                $arrRows = $this->select($varTable, $arrClms, $varWhere);
            }
        }
        return $arrRows;
    }

    /* function CategoryDropDownList($argWhere = '', $argLimit = '') {
      $arrClms = array('c.pkCategoryId', 'c.CategoryName', 'c.CategoryDescription', 'c.CategoryParentId', 'p.CategoryName as CategoryParentName', 'c.CategoryStatus', 'c.CategoryLevel');
      $varOrderBy = 'c.CategoryHierarchy ASC';
      $varTable = TABLE_CATEGORY . ' as c LEFT JOIN ' . TABLE_CATEGORY . ' as p ON c.CategoryParentId=p.pkCategoryId';
      $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
      $arrRows = array();
      foreach ($arrRes as $v) {
      $space = ' ';
      for ($s = 0; $s < $v['CategoryLevel']; $s++) {
      $space.=" .... ";
      }
      $arrRows[$v['pkCategoryId']] = $space . $v['CategoryName'];
      }
      //pre($arrRows);
      return $arrRows;


      //update `tbl_category` set `CategoryHierarchy`=`pkCategoryId` WHERE `CategoryLevel`='0'
      //update `tbl_category` set `CategoryHierarchy`=CONCAT(`CategoryParentId`,':',`pkCategoryId`) WHERE `CategoryLevel`='1'
      } */

    /**
     * function CategoryDropDownList
     *
     * This function is used to retrive category dropdown.
     *
     * Database Tables used in this function are : TABLE_CATEGORY
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return array $arrRows
     */
    function CategoryDropDownList($argWhere = '', $argLimit = '') {
        $arrClms = array('c.pkCategoryId', 'c.CategoryName', 'c.CategoryDescription', 'c.CategoryParentId', 'c.CategoryName as CategoryParentName', 'c.CategoryStatus', 'c.CategoryLevel');
        $varOrderBy = 'c.CategoryOrdering ASC';
        $varTable = TABLE_CATEGORY . ' as c';
        $argWhere .= ($argWhere != '' ? " AND " : "") . "c.CategoryParentId = '0'";
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
        $arrRows = array();
        foreach ($arrRes as $v) {
            $space = ' ';
            for ($s = 0; $s < $v['CategoryLevel']; $s++) {
                $space.=" .... ";
            }
            $arrRows[$v['pkCategoryId']] = $space . $v['CategoryName'];
            $arrRows = $this->CategoryDropDownList2("c.CategoryStatus=1 AND c.CategoryIsDeleted=0 AND c.CategoryParentId='" . $v['pkCategoryId'] . "'", $argLimit = '', $arrRows);
        }
//pre($arrRows);
        return $arrRows;
    }

    /**
     * function CategoryDropDownList2
     *
     * This function is used to retrive category dropdown.
     *
     * Database Tables used in this function are : TABLE_CATEGORY
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return array $arrRows
     */
    function CategoryDropDownList2($argWhere = '', $argLimit = '', $arrRows) {
        $arrClms = array('c.pkCategoryId', 'c.CategoryName', 'c.CategoryDescription', 'c.CategoryParentId', 'c.CategoryName as CategoryParentName', 'c.CategoryStatus', 'c.CategoryLevel');
        $varOrderBy = 'c.CategoryHierarchy ASC';
        $varTable = TABLE_CATEGORY . ' as c LEFT JOIN ' . TABLE_CATEGORY . ' as p ON c.CategoryParentId=p.pkCategoryId';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
//$arrRows = array();
        foreach ($arrRes as $v) {
            $space = ' ';
            for ($s = 0; $s < $v['CategoryLevel']; $s++) {
                $space.=" .... ";
            }
            $arrRows[$v['pkCategoryId']] = $space . $v['CategoryName'];
            $arrRows = $this->CategoryDropDownList2("c.CategoryStatus=1 AND c.CategoryIsDeleted=0 AND c.CategoryParentId='" . $v['pkCategoryId'] . "'", $argLimit = '', $arrRows);
        }
//pre($arrRows);
        return $arrRows;
    }

    /**
     * function CategoryDropDownListLevel
     *
     * This function is used to retrive category dropdown.
     *
     * Database Tables used in this function are : TABLE_CATEGORY
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return array $arrRows
     */
    function CategoryDropDownListLevel($argWhere = '', $argLimit = '') {
        $arrClms = array('c.pkCategoryId', 'c.CategoryParentId', 'c.CategoryLevel');
        $varOrderBy = 'c.CategoryHierarchy ASC';
        $varTable = TABLE_CATEGORY . ' as c ';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $argLimit);
        $arrRows = array();
        foreach ($arrRes as $v) {
            $arrRows[$v['pkCategoryId']] = $v['CategoryLevel'];
        }
//pre($arrRows);
        return $arrRows;
    }

    /**
     * function CategoryHtml
     *
     * This function is used to retrive category dropdown.
     *
     * Database Tables used in this function are : TABLE_CATEGORY
     *
     * @access public
     *
     * @parameters 9 string
     *
     * @return array $html
     */
    function CategoryHtml($catAry, $catName, $catID, $selVal, $defVal = 'All Category', $multiple = 0, $parameters = '', $isfront = '1', $isOptGrp = 0, $FrmWhr = null) {
        // Hemant - Add last perametr -  $FrmWhr = '';
        //pre($selVal);
//        pre($isfront);
//        pre($isOptGrp);
        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='<script type="text/javascript">
                            $(document).ready(function() {
                                $("select#' . $catID . '").searchable({
                                maxListSize: "' . count($catAry) . '",
                                maxMultiMatch: "' . round(count($catAry) / 2) . '"
                                });
                                });
                                        /*$(document).ready(function() {
                                            $("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
                                });*/
                        </script>';
            }
        }
        $html.='<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        if ($defVal != '') {
            $html.='<option value="0" ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }
        if (is_array($catAry[0])) {
            foreach ($catAry[0] as $cat) {

                if (empty($cat['CategoryName']))
                    continue;


                if ($isOptGrp == '1' && $cat['CategoryLevel'] == '0') {
                    $html.='<optgroup label="' . $cat['CategoryName'] . '">
                    <option value="" class="dNone"></option>';
                } else if ($isOptGrp == '2' && $cat['CategoryLevel'] == '0') {
                    $html.='<optgroup label="' . $cat['CategoryName'] . '">';
                } else {
                    $main = in_array($cat['pkCategoryId'], $selVal) ? 'Selected' : '';
                    $html.='<option value="' . $cat['pkCategoryId'] . '" ' . ($main) . '>' . $cat['CategoryName'] . '</option>';
                }
                //echo '<pre>';print_r($catAry);
                //echo '<pre>';print_r($cat['pkCategoryId']);
                //echo '<pre>';print_r($selVal);
                $html.= $this->CategoryHtml2($catAry, $cat['pkCategoryId'], $selVal, '....', $isOptGrp, $FrmWhr);

                if ($isOptGrp == '1' && $cat['CategoryLevel'] == '0') {
                    $html.='</optgroup>';
                } else if ($isOptGrp == '2' && $cat['CategoryLevel'] == '0') {
                    $html.='</optgroup>';
                }
//$html .='<option value="' . $keySelect . '" ' . (in_array($keySelect, $selVal) ? 'Selected' : '') . ' class="catOpt ' . ($levlAry[$keySelect] == 0 ? 'level1' : ($levlAry[$keySelect] > 1 ? 'level2' : '')) . '">' . $valSelect . '</option>';
            }
        }
        $html.='
    </select>';
        //echo $html;die();
        return $html;
    }

    /**
     * function CategoryDropDownList
     *
     * This function is used to retrive category dropdown.
     *
     * Database Tables used in this function are : TABLE_CATEGORY
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return array $arrRows
     */
    function CategoryHtml2(&$catAry, $CategoryParentId, $selVal, $separator, $isOptGrp = 0, $FrmWhr = null) {
        if (is_array($catAry[$CategoryParentId])) {

            foreach ($catAry[$CategoryParentId] as $cat) {
                if ($isOptGrp == '1' && $cat['CategoryLevel'] == '1') {
                    $html.='<optgroup label="' . $separator . $cat['CategoryName'] . '">';
                } else {
                    $sbCate = in_array($cat['pkCategoryId'], $selVal) ? 'Selected' : '';
                    $html.='<option value="' . $cat['pkCategoryId'] . '" ' . ($sbCate) . '>' . $separator . $cat['CategoryName'] . '</option>';
                }

                if (count($catAry[$cat['pkCategoryId']]) > 0)
//                    Hemant -  Child level categogy will not show TW-129
                    if ($FrmWhr != 'fromCategory') {
                        $html.= $this->CategoryHtml2($catAry, $cat['pkCategoryId'], $selVal, '.... ....');
                    }
                if ($isOptGrp == '1' && $cat['CategoryLevel'] == '1') {
                    $html.='</optgroup>';
                }
            }
        }
        return $html;
    }

    function CategoryHtml_serach($catAry, $catName, $catID, $selVal, $defVal = 'All Category', $multiple = 0, $parameters = '', $isfront = '1', $isOptGrp = 0, $FrmWhr = null) {
        // Hemant - Add last perametr -  $FrmWhr = '';
        //pre($catAry);
//        pre($isfront);
//        pre($isOptGrp);
        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='<script type="text/javascript">
                            $(document).ready(function() {
                                $("select#' . $catID . '").searchable({
                                maxListSize: "' . count($catAry) . '",
                                maxMultiMatch: "' . round(count($catAry) / 2) . '"
                                });
                                });
                                        /*$(document).ready(function() {
                                            $("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
                                });*/
                        </script>';
            }
        }
        $html.='<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        if ($defVal != '') {
            $html.='<option value="0" ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }

        if (is_array($catAry[0])) {

            $qwe = 0;
            foreach ($catAry[0] as $cat) {

                if (empty($cat['CategoryName']))
                    continue;


                if ($isOptGrp == '1' && $cat['CategoryLevel'] == '0') {

                    if ($qwe == 0) {
                        $html.='<optgroup label="' . $cat['CategoryName'] . '">
                    <option value="" class="dNone"></option>';
                    } else {
                        $html.='<optgroup label="' . $cat['CategoryName'] . '">
                    ';
                    }

                    $qwe++;
                } else if ($isOptGrp == '2' && $cat['CategoryLevel'] == '0') {
                    $html.='<optgroup label="' . $cat['CategoryName'] . '">';
                } else {
                    $main = in_array($cat['pkCategoryId'], $selVal) ? 'Selected' : '';
                    $html.='<option value="' . $cat['pkCategoryId'] . '" ' . ($main) . '>' . $cat['CategoryName'] . '</option>';
                }
                //echo '<pre>';print_r($catAry);
                //echo '<pre>';print_r($cat['pkCategoryId']);
                //echo '<pre>';print_r($selVal);
                $html.= $this->CategoryHtml2($catAry, $cat['pkCategoryId'], $selVal, '....', $isOptGrp, $FrmWhr);

                if ($isOptGrp == '1' && $cat['CategoryLevel'] == '0') {
                    $html.='</optgroup>';
                } else if ($isOptGrp == '2' && $cat['CategoryLevel'] == '0') {
                    $html.='</optgroup>';
                }
//$html .='<option value="' . $keySelect . '" ' . (in_array($keySelect, $selVal) ? 'Selected' : '') . ' class="catOpt ' . ($levlAry[$keySelect] == 0 ? 'level1' : ($levlAry[$keySelect] > 1 ? 'level2' : '')) . '">' . $valSelect . '</option>';
            }
        }
        $html.='
    </select>';
        //echo $html;die();
        return $html;
    }

    /**
     * function CategoryHtml_old
     *
     * This function is used to retrive category dropdown.
     *
     * Database Tables used in this function are : TABLE_CATEGORY
     *
     * @access public
     *
     * @parameters 9 string
     *
     * @return string $html
     */
    function CategoryHtml_old($catAry, $levlAry, $catName, $catID, $selVal, $defVal = 'All Category', $multiple = 0, $parameters = '', $isfront = '1') {
        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='
	<script type="text/javascript">
		$(document).ready(function() {
$("select#' . $catID . '").searchable({
maxListSize: "' . count($catAry) . '",
maxMultiMatch: "' . round(count($catAry) / 2) . '"
});
});
		/*$(document).ready(function() {
			$("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
		});*/
	</script>';
            }
        }
        $html .='
	<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        if ($defVal != '') {
            $html .='
	<option value="0" ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }
        if (is_array($catAry)) {
            foreach ($catAry as $keySelect => $valSelect) {
                $html .='<option value="' . $keySelect . '" ' . (in_array($keySelect, $selVal) ? 'Selected' : '') . ' class="catOpt ' . ($levlAry[$keySelect] == 0 ? 'level1' : ($levlAry[$keySelect] > 1 ? 'level2' : '')) . '">' . $valSelect . '</option>';
            }
        }
        $html .='
    </select>';
        return $html;
    }

    /**
     * function sendDisputedEmail
     *
     * This function is used to send notification email.
     *
     * Database Tables used in this function are :TABLE_ORDER, TABLE_ORDER_ITEMS,
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $string
     */
    function sendDisputedEmail($arrOrderDetail, $isDisputed) {

        $strDisputedComments = $this->getDisputedTemplateForm($arrOrderDetail['SubOrderId'], $isDisputed);

        $this->SentEmailToCustomer($arrOrderDetail, $strDisputedComments);
        $this->SentEmailToWholesaler($arrOrderDetail, $strDisputedComments);
        $this->SentEmailToCountryPortal($arrOrderDetail, $strDisputedComments);
        $this->SentEmailToSuperAdmin($arrOrderDetail, $strDisputedComments);
    }

    /**
     * function SentEmailToCustomer
     *
     * This function Will be called on Sent Email To Customer.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SentEmailToCustomer($arrOrderDetail, $strDisputedComments = '') {
        global $objCore;
        global $arrProductImageResizes;

        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";

        if ($arrOrderDetail['SubOrderId'] <> '') {
            $varWhr .= " AND SubOrderID = '" . $arrOrderDetail['SubOrderId'] . "'";
        }

        $arrOrderItems = $this->GetItemDetails($varWhr);

        $varEmailOrderDetails = '<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td>' . $arrOrderDetail['EmailSubject'] . ':  </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
        $varEmailOrderDetails .= '<tr><th colspan="2">' . ORDER_ID . '</th><td colspan="2">&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th colspan="2">' . TRANJECTION_ID . '</th><td colspan="1">&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="7">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>' . SUB_ORDER_ID . '</th><th>' . ITEM . '</th><th>' . ITEM_IMAGE . '</th><th width="10%">' . PRICE . '</th><th>' . SHIPPING_CHARGE . '</th><th>' . DISCOUNT . '</th><th>' . SUBTOTAL . '</th></tr>';
        $varTotal = 0;
        foreach ($arrOrderItems as $k => $v) {
            $varTotal += $v['ItemTotalPrice'];

            if ($v['ItemType'] == 'product') {
                $path = 'products/' . $arrProductImageResizes['default'];
            } else if ($v['ItemType'] == 'package') {
                $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
            } else {
                $path = 'gift_card';
            }

            $varSrc = $objCore->getImageUrl($v['ItemImage'], $path);

            $varEmailOrderDetails .= '<tr><td align="center">' . $v['SubOrderID'] . '</td><td align="center"><b>' . $v['ItemName'] . '</b><br />' . $v['OptionDet'] . '</td>';
            $varEmailOrderDetails .='<td align="center"><img src="' . $varSrc . '" alt="' . $v['ItemName'] . '"/></td>';
            $varEmailOrderDetails .='<td align="center">' . $v['Quantity'] . 'x $ ' . number_format(($v['ItemPrice'] + ($v['AttributePrice'] / $v['Quantity'])), 2, '.', ',') . '</td>
                                        <td align="center" width="10%">$ ' . number_format($v['ShippingPrice'], 2, '.', ',') . '</td>
                                        <td align="center" width="10%">$ ' . number_format($v['DiscountPrice'], 2, '.', ',') . '</td>
                                        <td align="center" width="10%">$ ' . number_format($v['ItemTotalPrice'], 2, '.', ',') . '</td>
                                      </tr>';
        }

        $varEmailOrderDetails .= '<tr bgcolor="#cccccc"><th align="right" width="20%" colspan="6">' . GRAND_TOTAL . '</th><td align="center">$&nbsp;' . number_format($varTotal, 2) . '</td></tr>';

        $varEmailOrderDetails .='</table>' . $strDisputedComments;

        $varCustomerName = $arrOrderDetail['CustomerFirstName'] . ' ' . $arrOrderDetail['CustomerLastName'];

        $varCustomerEmail = $arrOrderDetail['CustomerEmail'];
        $varSubject = ORDER_DETAILS;

        $varFrom = SITE_NAME;
        $EmailTemplates = $this->SentEmailTemplatesDisputed();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');

        $varKeywordValues = array($varCustomerName, $varEmailOrderDetails);

        $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

// Calling mail function
        $objCore->sendMail($varCustomerEmail, $varFrom, $varSubject, $varEmailMessage);
    }

    /**
     * function SendOrderStatusEmailToCustomer
     *
     * This function Will be called to Send Order Status Email To Customer.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SendOrderStatusEmailToCustomer($arrOrderDetail, $strDisputedComments = '') {
        global $objCore;
        global $arrProductImageResizes;

        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";

        if ($arrOrderDetail['SubOrderId'] <> '') {
            $varWhr .= " AND SubOrderID = '" . $arrOrderDetail['SubOrderId'] . "'";
        }

        $arrOrderItems = $this->GetItemDetails($varWhr);

        $varEmailOrderDetails = '<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td>' . $arrOrderDetail['EmailSubject'] . ':  </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
        $varEmailOrderDetails .= '<tr><th colspan="2">' . ORDER_ID . '</th><td colspan="2">&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th colspan="2">' . TRANJECTION_ID . '</th><td colspan="1">&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><th colspan="2">' . STATUS . '</th><td colspan="5">&nbsp;&nbsp;' . $arrOrderDetail['OrderStatus'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="7">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>' . SUB_ORDER_ID . '</th><th>' . ITEM . '</th><th>' . ITEM_IMAGE . '</th><th width="10%">' . PRICE . '</th><th>' . SHIPPING_CHARGE . '</th><th>' . DISCOUNT . '</th><th>' . SUBTOTAL . '</th></tr>';
        $varTotal = 0;
        foreach ($arrOrderItems as $k => $v) {
            $varTotal += $v['ItemTotalPrice'];

            if ($v['ItemType'] == 'product') {
                $path = 'products/' . $arrProductImageResizes['default'];
            } else if ($v['ItemType'] == 'package') {
                $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
            } else {
                $path = 'gift_card';
            }

            $varSrc = $objCore->getImageUrl($v['ItemImage'], $path);

            $varEmailOrderDetails .= '<tr><td align="center">' . $v['SubOrderID'] . '</td><td align="center"><b>' . $v['ItemName'] . '</b><br />' . $v['OptionDet'] . '</td>';
            $varEmailOrderDetails .='<td align="center"><img src="' . $varSrc . '" alt="' . $v['ItemName'] . '"/></td>';
            $varEmailOrderDetails .='<td align="center">' . $v['Quantity'] . 'x $ ' . number_format(($v['ItemPrice'] + ($v['AttributePrice'] / $v['Quantity'])), 2, '.', ',') . '</td>
                                        <td align="center" width="10%">$ ' . number_format($v['ShippingPrice'], 2, '.', ',') . '</td>
                                        <td align="center" width="10%">$ ' . number_format($v['DiscountPrice'], 2, '.', ',') . '</td>
                                        <td align="center" width="10%">$ ' . number_format($v['ItemTotalPrice'], 2, '.', ',') . '</td>
                                      </tr>';
        }

        $varEmailOrderDetails .= '<tr bgcolor="#cccccc"><th align="right" width="20%" colspan="6">' . GRAND_TOTAL . '</th><td align="center">$&nbsp;' . number_format($varTotal, 2) . '</td></tr>';

        $varEmailOrderDetails .='</table>' . $strDisputedComments;

        $varCustomerName = $arrOrderDetail['CustomerFirstName'] . ' ' . $arrOrderDetail['CustomerLastName'];

        $varCustomerEmail = $arrOrderDetail['CustomerEmail'];
        $varSubject = ORDER_DETAILS;

        $varFrom = SITE_NAME;
        $EmailTemplates = $this->SentEmailTemplatesDisputed();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');

        $varKeywordValues = array($varCustomerName, $varEmailOrderDetails);

        $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

// Calling mail function
        $objCore->sendMail($varCustomerEmail, $varFrom, $varSubject, $varEmailMessage);
    }

    /**
     * function SentEmailToWholesaler
     *
     * This function Will be called on Sent Email To Wholesaler.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SentEmailToWholesaler($arrOrderDetail, $strDisputedComments = '') {

        global $objCore;
        global $arrProductImageResizes;
        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>' . $arrOrderDetail['EmailSubject'] . ' : </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';

        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";

        if ($arrOrderDetail['SubOrderId'] <> '') {
            $varWhr .= " AND SubOrderID = '" . $arrOrderDetail['SubOrderId'] . "'";
        }


        $arrWholesalerDetails = $this->GetWholesalerDetails($varWhr);


        $EmailTemplates = $this->SentEmailTemplatesDisputed();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');
        $varSubject = ORDER_STATUS_CHANGES;
        $varFrom = SITE_NAME;

        foreach ($arrWholesalerDetails as $k => $v) {

            $varWhre = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' AND fkWholesalerID = '" . $v['fkWholesalerID'] . "'";
            $arrOrderItems = $this->GetItemDetails($varWhre);

            $varEmailOrderDetail = '<tr><th>' . ORDER_ID . '</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>' . SUB_ORDER_ID . '</th><td>&nbsp;&nbsp;' . $arrOrderItems[0]['SubOrderID'] . '</td><th>' . TRANJECTION_ID . '</th><td>&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
            $varEmailOrderDetail .= '<tr><td colspan="6">&nbsp;</td></tr>';
            $varEmailOrderDetail .= '<tr><th>' . ITEM . '</th><th>' . ITEM_IMAGE . '</th><th>' . PRICE . '</th><th>' . SHIPPING_CHARGE . '</th><th>' . DISCOUNT . '</th><th>' . SUBTOTAL . '</th></tr>';
            $varTotal = 0;
            foreach ($arrOrderItems as $k2 => $v2) {
                $varTotal += $v2['ItemTotalPrice'];

                if ($v2['ItemType'] == 'product') {
                    $path = 'products/' . $arrProductImageResizes['default'];
                } else if ($v2['ItemType'] == 'package') {
                    $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                } else {
                    $path = 'gift_card';
                }

                $varSrc = $objCore->getImageUrl($v2['ItemImage'], $path);


                $varEmailOrderDetail .= '<tr><td align="center"><b>' . $v2['ItemName'] . '</b><br />' . $v2['OptionDet'] . '</td>';
                $varEmailOrderDetail .='<td align="center"><img src="' . $varSrc . '" alt="' . $v2['ItemName'] . '"></td>';
                $varEmailOrderDetail .='<td align="center">' . $v2['Quantity'] . 'x $ ' . number_format(($v2['ItemPrice'] + ($v2['AttributePrice'] / $v2['Quantity'])), 2, '.', ',') . '</td>
                    <td align="center" width="10%">$ ' . number_format($v2['ShippingPrice'], 2, '.', ',') . '</td>
                    <td align="center" width="10%">$ ' . number_format($v2['DiscountPrice'], 2, '.', ',') . '</td>
                    <td align="center" width="10%">$ ' . number_format($v2['ItemTotalPrice'], 2, '.', ',') . '</td>

</tr>';
            }

            $varEmailOrderDetailss = $varEmailOrderDetails . $varEmailOrderDetail . '<tr bgcolor="#cccccc"><th colspan="5" align="right">' . GRAND_TOTAL . '</th><td align="center" width="20%">&nbsp;&nbsp;$ ' . number_format($varTotal, 2, ".", ",") . '</td></tr>';

            $varEmailOrderDetailss .='</table>' . $strDisputedComments;
            $varName = $v['CompanyName'];
            $varEmail = $v['CompanyEmail'];

            $varKeywordValues = array($varName, $varEmailOrderDetailss);
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

// Calling mail function
            $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
        }
    }

    /**
     * function SentEmailToCountryPortal
     *
     * This function Will be called on Sent Sent Email To Country Portal.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SentEmailToCountryPortal($arrOrderDetail, $strDisputedComments = '') {

        global $objCore;
        global $arrProductImageResizes;
        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>' . $arrOrderDetail['EmailSubject'] . ' : </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
        $varEmailOrderDetails .= '<tr><th>' . ORDER_ID . '</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>' . TRANJECTION_ID . '</th><td colspan="2">&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="5">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>' . SUB_ORDER_ID . '</th><th>' . ITEM . '</th><th>' . ITEM_IMAGE . '</th><th>' . QUANTITY . '</th><th>' . PRICE . '</th></tr>';


        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";

        if ($arrOrderDetail['SubOrderId'] <> '') {
            $varWhr .= " AND SubOrderID = '" . $arrOrderDetail['SubOrderId'] . "'";
        }
        $arrWholesalerDetails = $this->GetWholesalerDetails($varWhr);

        $EmailTemplates = $this->SentEmailTemplatesDisputed();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');
        $varSubject = ORDER_DETAILS;
        $varFrom = SITE_NAME;

        foreach ($arrWholesalerDetails as $k => $v) {
            $varWhre = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' AND fkWholesalerID = '" . $v['fkWholesalerID'] . "'";
            $arrOrderItems = $this->GetItemDetails($varWhre);


            $varEmailOrderDetail = '';
            $varTotal = 0;
            foreach ($arrOrderItems as $k2 => $v2) {
                $varTotal += $v2['ItemTotalPrice'];

                if ($v2['ItemType'] == 'product') {
                    $path = 'products/' . $arrProductImageResizes['default'];
                } else if ($v2['ItemType'] == 'package') {
                    $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                } else {
                    $path = 'gift_card';
                }

                $varSrc = $objCore->getImageUrl($v2['ItemImage'], $path);

                $varEmailOrderDetails .= '<tr><td align="center">' . $v2['SubOrderID'] . '</td><td align="center"><b>' . $v2['ItemName'] . '</b><br />' . $v2['OptionDet'] . '</td>';
                $varEmailOrderDetails .='<td align="center"><img src="' . $varSrc . '" alt="' . $v2['ItemName'] . '"></td>';
                $varEmailOrderDetails .='<td align="center">' . $v2['Quantity'] . '</td><td align="center">$ ' . number_format($v2['ItemTotalPrice'], 2, '.', ',') . '</td></tr>';
            }

            $varWhere = "AdminCountry = '" . $v['CompanyCountry'] . "'";

            $AdminData = $this->GetAdminDetails($varWhere);
            $varCtr = 0;

            foreach ($AdminData as $val) {

                if ($val['AdminRegion'] == $v['CompanyRegion']) {
                    $varEmail = $val['AdminEmail'];
                    $varName = $val['AdminUserName'];
                    $varCtr = $varCtr++;
                } else if ($val['AdminCountry'] == $v['CompanyCountry'] && $varCtr == 0) {
                    $varEmail = $val['AdminEmail'];
                    $varName = $val['AdminUserName'];
                } else {

                    continue;
                }

                $varEmailOrderDetailss = $varEmailOrderDetails . $varEmailOrderDetail . '<tr bgcolor="#cccccc"><th colspan="4" align="right">' . GRAND_TOTAL . '</th><td align="center">&nbsp;&nbsp;$&nbsp;' . number_format($varTotal, 2, ".", ",") . '</td></tr>';

                $varEmailOrderDetailss .='</table>' . $strDisputedComments;

                $varKeywordValues = array($varName, $varEmailOrderDetailss);
                $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);
// Calling mail function
                $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
            }
        }
    }

    /**
     * function SentEmailToSuperAdmin
     *
     * This function Will be called on Sent Email To SuperAdmin.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SentEmailToSuperAdmin($arrOrderDetail, $strDisputedComments = '') {

        global $objCore;
        global $arrProductImageResizes;
        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";

        if ($arrOrderDetail['SubOrderId'] <> '') {
            $varWhr .= " AND SubOrderID = '" . $arrOrderDetail['SubOrderId'] . "'";
        }

        $arrOrderItems = $this->GetItemDetails($varWhr);

        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>' . $arrOrderDetail['EmailSubject'] . ' : </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
        $varEmailOrderDetails .= '<tr><th>' . ORDER_ID . '</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>' . TRANJECTION_ID . '</th><td colspan="2">&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="5">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>' . SUB_ORDER_ID . '</th><th>' . ITEM . '</th><th>' . ITEM_IMAGE . '</th><th>' . QUANTITY . '</th><th>' . PRICE . '</th></tr>';
        $varTotal = 0;
        foreach ($arrOrderItems as $k => $v) {
            $varTotal += $v['ItemTotalPrice'];

            if ($v['ItemType'] == 'product') {
                $path = 'products/' . $arrProductImageResizes['default'];
            } else if ($v['ItemType'] == 'package') {
                $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
            } else {
                $path = 'gift_card';
            }

            $varSrc = $objCore->getImageUrl($v['ItemImage'], $path);

            $varEmailOrderDetails .= '<tr><td align="center">' . $v['SubOrderID'] . '</td><td align="center"><b>' . $v['ItemName'] . '</b><br />' . $v['OptionDet'] . '</td>';
            $varEmailOrderDetails .='<td align="center"><img src="' . $varSrc . '" alt="' . $v['ItemName'] . '"></td>';
            $varEmailOrderDetails .='<td align="center">' . $v['Quantity'] . '</td><td align="center">$ ' . number_format($v['ItemTotalPrice'], 2, '.', ',') . '</td></tr>';
        }

        $varEmailOrderDetails .= '<tr bgcolor="#cccccc"><th colspan="4" align="right">' . GRAND_TOTAL . '</th><td align="center">&nbsp;&nbsp;$ ' . number_format($varTotal, 2, ".", ",") . '</td></tr>';

        $varEmailOrderDetails .='</table>' . $strDisputedComments;

        $varWhre = "AdminType = 'super-admin' ";
        $arrAdminDetails = $this->GetAdminDetails($varWhre);

        $EmailTemplates = $this->SentEmailTemplatesDisputed();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');
        $varSubject = 'Order details';
        $varFrom = SITE_NAME;
        foreach ($arrAdminDetails as $admink => $adminv) {

            $varName = $adminv['AdminUserName'];
            $varEmail = $adminv['AdminEmail'];
            $varKeywordValues = array($varName, $varEmailOrderDetails);
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

// Calling mail function
            $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
        }
    }

    /**
     * function SentEmailToSuperAdmin
     *
     * This function Will be called on Sent Email To SuperAdmin.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters
     *
     * @return String $varEmailTemplate
     */
    function getDisputedTemplateForm($soid, $isDisputed = 0) {
        global $objCore;


        $arrRes = $this->disputedCommentsHistory($soid);


        $strDisputedComments = '';
        $arrData = $objCore->getDisputedCommentArray();
        if ($isDisputed) {

            $strDisputedComments = '<br/><br/><table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>Disputed Comments : </p></td></tr></table>';
            $strDisputedComments .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
            foreach ($arrRes as $k => $v) {

                if ($v['CommentOn'] == 'Disputed') {
                    $Qdata = unserialize($v['CommentDesc']);
                    $strDisputedComments .= '<tr><th align="left" colspan="2">By ' . $v[$v['CommentedBy']] . ' (' . $v['CommentedBy'] . ') <small class="green">' . $objCore->localDateTime($v['CommentDateAdded'], DATE_TIME_FORMAT_SITE_FRONT) . '</small></th></tr>';
                    $strDisputedComments .= '<tr><th align="left">Ques</th><th align="left">' . $arrData['Q1'] . '</th></tr><tr><th align="left">Ans</th><td align="left">' . $arrData[$Qdata['Q1']] . '</td></tr>';


                    if ($Qdata['Q1'] == 'A11') {
                        $ans = ($Qdata['Q11'] == '') ? 'N/A' : $Qdata['Q11'];

                        $strDisputedComments .= '<tr><th align="left">Ques</th><th align="left">' . $arrData['Q11'] . '</th></tr><tr><th align="left">Ans</th><td align="left">' . $ans . '</td></tr>';
                        $ans = ($v['AdditionalComments'] == '') ? 'N/A' : $v['AdditionalComments'];
                        $strDisputedComments .= '<tr><th align="left">Ques</th><th align="left">' . $arrData['Q12'] . '</th></tr><tr><th align="left">Ans</th><td align="left">' . $ans . '</td></tr>';
                    } else {
                        $arrQ21 = explode(',', $Qdata['Q21']);
                        $Q21 = '';
                        foreach ($arrQ21 as $v10) {
                            if (key_exists($v10, $arrData)) {
                                $Q21 .= $arrData[$v10] . ',';
                            } else {
                                $Q21 .= $v10 . ',';
                            }
                        }
                        $Q21 = trim($Q21, ',');
                        $ans = ($Q21 == '') ? 'N/A' : $Q21;
                        $strDisputedComments .= '<tr><th align="left">Ques</th><th align="left">' . $arrData['Q21'] . '</th></tr><tr><th align="left">Ans</th><td align="left">' . $ans . '</td></tr>';
                        $ans = ($arrData[$Qdata['Q22']] == '') ? 'N/A' : $arrData[$Qdata['Q22']];
                        $strDisputedComments .= '<tr><th align="left">Ques</th><th align="left">' . $arrData['Q22'] . '</th></tr><tr><th align="left">Ans</th><td align="left">' . $ans . '</td></tr>';
                        $strDisputedComments .= '<tr><th align="left">Ques</th><th align="left">' . $arrData['Q23'] . '</th></tr><tr><th align="left">Ans</th><td align="left">' . $arrData[$Qdata['Q23']] . '</td></tr>';
                        $ans = ($v['AdditionalComments'] == '') ? 'N/A' : $v['AdditionalComments'];
                        $strDisputedComments .= '<tr><th align="left">Ques</th><th align="left">' . $arrData['Q24'] . '</th></tr><tr><th align="left">Ans</th><td align="justify">' . $ans . '</td></tr>';
                    }
                } else {
                    $strDisputedComments .= '<tr><td align="justify" colspan="2"><b>By ' . $v[$v['CommentedBy']] . ' (' . $v['CommentedBy'] . ') <small class="green">' . $objCore->localDateTime($v['CommentDateAdded'], DATE_TIME_FORMAT_SITE_FRONT) . '</small></b><br/><br/>' . $v['AdditionalComments'] . '</td></tr>';
                }
            }

            $strDisputedComments .='</table>';
        }

        //pre($strDisputedComments);
        return $strDisputedComments;
    }

    /**
     * function disputedCommentsHistory
     *
     * This function is used to insert disputed comments.
     *
     * Database Tables used in this function are :TABLE_ORDER_DISPUTED_COMMENTS
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return null
     */
    function disputedCommentsHistory($soid) {
        global $objCore;
        $arrClms = array(
            'pkDisputedID',
            'fkOrderID',
            'fkSubOrderID',
            'CommentedBy',
            'CommentedID',
            'CustomerFirstName as customer',
            'CompanyName wholesaler',
            'AdminTitle admin',
            'CommentOn',
            'CommentDesc',
            'AdditionalComments',
            'CommentDateAdded'
        );
        $varWhr = " fkSubOrderID ='" . $soid . "' ";
        $varOrd = " CommentDateAdded ASC ";
        $varTable = TABLE_ORDER_DISPUTED_COMMENTS . " LEFT JOIN " . TABLE_CUSTOMER . " ON CommentedID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON CommentedID=pkWholesalerID LEFT JOIN " . TABLE_ADMIN . " ON CommentedID=pkAdminID";
        $arrRes = $this->select($varTable, $arrClms, $varWhr, $varOrd);


//pre($arrRes);
        return $arrRes;
    }

    /**
     * function SentEmailToSuperAdmin
     *
     * This function Will be called on Sent Email To SuperAdmin.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters
     *
     * @return String $varEmailTemplate
     */
    function SentEmailTemplates() {
        $varEmailTemplate = '<table width="100%" cellspacing="0" cellpadding="5" border="0">
                <tr><td width="25"><br /></td><td width="600"><p><strong>Congratulations {EMAIL} ,</strong></p></td></tr>
                <tr><td width="25"></td><td width="98%">{EMAILDETAILS}</td></tr>
                <tr><td width="25"><br /></td><td width="98%"> All the best,<br />The ' . SITE_NAME . ' Team</td></tr>
                </table>';
        return $varEmailTemplate;
    }

    /**
     * function SentEmailToSuperAdmin
     *
     * This function Will be called on Sent Email To SuperAdmin.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters
     *
     * @return String $varEmailTemplate
     */
    function SentEmailTemplatesDisputed() {
        $varEmailTemplate = '<table width="100%" cellspacing="0" cellpadding="5" border="0">
                <tr><td width="25"><br /></td><td width="600"><p><strong>Hi {EMAIL} ,</strong></p></td></tr>
                <tr><td width="25"></td><td width="98%">{EMAILDETAILS}</td></tr>
                </table>';
        return $varEmailTemplate;
    }

    /**
     * function GetItemDetails
     *
     * This function is used GetItemDetails.
     *
     * Database Tables used in this function are : TABLE_ORDER_ITEMS
     *
     * @access public
     *
     * @parameters 1 $argWhere
     *
     * @return array $arrRes
     */
    function GetItemDetails($argWhere) {
        $arrClms = array('pkOrderItemID', 'SubOrderID', 'ItemType', 'ItemName', 'ItemImage', 'ItemPrice', 'Quantity', 'AttributePrice', 'ShippingPrice', 'DiscountPrice', 'ItemDetails', 'ItemTotalPrice', 'fkItemID');
        $arrRes = $this->select(TABLE_ORDER_ITEMS, $arrClms, $argWhere);

        foreach ($arrRes as $k => $v) {
            if ($v['ItemType'] <> 'gift-card') {
                $jsonDet = json_decode(html_entity_decode($v['ItemDetails']));
                $varDet = '';
                foreach ($jsonDet as $jk => $jv) {
                    $varDet .= $jv->ProductName;
                    $arrCols = array('AttributeLabel', 'OptionValue');
                    $argWhr = " fkOrderItemID = '" . $v['pkOrderItemID'] . "' AND fkProductID = '" . $jv->pkProductID . "'";
                    $arrOpt = $this->select(TABLE_ORDER_OPTION, $arrCols, $argWhr);
                    if ($arrOpt) {
                        $varDet .= ' (';
                        foreach ($arrOpt as $ok => $ov) {
                            $varDet .= $ov['AttributeLabel'] . ' # ' . str_replace('@@@', ',', $ov['OptionValue']) . ' ,';
                        }

                        $varDet .= ')';
                    }
                    $varDet .= '<br />';
                    if ($v['ItemType'] == 'product') {
                        $getImage = $this->select(TABLE_PRODUCT, array('ProductImage'), 'pkProductID="' . $jv->pkProductID . '"');
                        $arrRes[$k]['ProductImage'] = $getImage[0]['ProductImage'];
                    } else if ($v['ItemType'] == 'package') {
                        $getImage = $this->select(TABLE_PACKAGE, array('PackageImage'), 'pkPackageId="' . $v['fkItemID'] . '"');
                        $arrRes[$k]['ProductImage'] = $getImage[0]['PackageImage'];
                    }
                }
                $arrRes[$k]['OptionDet'] = $varDet;
//pre($arrRes);
            } else {
                $arrRes[$k]['OptionDet'] = 'Gift Card';
            }
        }


//pre($arrRes);
        return $arrRes;
    }

    /**
     * function GetTotalDetails
     *
     * This function is used GetTotalDetails.
     *
     * Database Tables used in this function are : TABLE_ORDER_TOTAL
     *
     * @access public
     *
     * @parameters 1 $argWhere
     *
     * @return array $arrRes
     */
    function GetTotalDetails($argWhere) {
        $arrClms = array('Code', 'Title', 'Amount');
        $varOrder = " SortOrder ASC";
        $arrRes = $this->select(TABLE_ORDER_TOTAL, $arrClms, $argWhere, $varOrder);
// pre($arrRes);
        return $arrRes;
    }

    /**
     * function getCouponNum
     *
     * This function is used to get num of records.
     *
     * Database Tables used in this function are : TABLE_ORDER
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     */
    function GetWholesalerDetails($argOrderID) {

        $query = "SELECT fkWholesalerID,CompanyName, CompanyEmail,CompanyCountry,CompanyRegion FROM " . TABLE_ORDER_ITEMS . " INNER JOIN  " . TABLE_WHOLESALER . " ON fkWholesalerID=pkWholesalerID WHERE " . $argOrderID . " GROUP BY fkWholesalerID";
        $arrRes = $this->getArrayResult($query);
//pre($arrRes);
        return $arrRes;
    }

    /**
     * function GetAdminDetails
     *
     * This function is used GetAdminDetails.
     *
     * Database Tables used in this function are : TABLE_ADMIN
     *
     * @access public
     *
     * @parameters 1 $argWhere
     *
     * @return array $arrRes
     */
    function GetAdminDetails($argWhere) {
        $arrClms = array('AdminUserName', 'AdminEmail', 'AdminCountry', 'AdminRegion');
        $arrRes = $this->select(TABLE_ADMIN, $arrClms, $argWhere);
//pre($arrRes);
        return $arrRes;
    }

    /**
     * function Email verification encode
     *
     * This function is used GetAdminDetails.
     *
     * Database Tables used in this function are : TABLE_ADMIN
     *
     * @access public
     *
     * @parameters 1 $argWhere
     *
     * @return array $arrRes
     */
    function getEmailVerificationEncode($str) {
        $strEn = base64_encode($str);
        return $strEn;
    }

    /**
     * function Email verification encode
     *
     * This function is used GetAdminDetails.
     *
     * Database Tables used in this function are : TABLE_ADMIN
     *
     * @access public
     *
     * @parameters 1 $argWhere
     *
     * @return array $arrRes
     */
    function getEmailVerificationDecode($str) {
        $strDe = base64_decode($str);
        return $strDe;
    }

    /**
     * function solrProductRemoveAdd
     *
     * This function is used to maintain product will remove from solr.
     *
     * Database Tables used in this function are : TABLE_ORDER_TOTAL
     *
     * @access public
     *
     * @parameters 1 $argWhere
     *
     * @return array $arrRes
     */
    function solrProductRemoveAdd($argWhere) {
        if ($argWhere <> '') {
            $varWhere = "WHERE " . $argWhere;
            $varQuery = "REPLACE INTO " . TABLE_PRODUCT_DELETE . " (fkProductID) SELECT pkProductID FROM " . TABLE_PRODUCT . " " . $varWhere;
            //pre($varQuery);
            $arrRes = $this->query($varQuery);
        }
    }

    /**
     *
     * Function Name : getSetting
     *
     * Return type : String Price
     *
     * Date created : 05th July 2013
     *
     * Date last modified : 05th July 2013
     *
     * Author :Rupesh Parmar
     *
     * Last modified by : Rupesh Parmar
     *
     * Comments : This function return currency sign. It take one argument.
     *
     * Use instruction : obj->getCountryByIp()
     *
     */
    function getSetting($argWhere = '') {

        $arrClms = array('pkSettingID', 'SettingAliasName', 'SettingValue');
        $varWhere = ($argWhere <> '') ? "SettingAliasName = '" . $argWhere . "'" : "";
        $arrRow = $this->select(TABLE_SETTING, $arrClms, $varWhere);
        foreach ($arrRow as $v) {
            $arrRes[$v['SettingAliasName']] = $v;
        }
        return $arrRes;
    }

    /**
     *
     * Function Name : insertVisitor
     *
     * Return type : String Price
     *
     * Date created : 05th July 2013
     *
     * Date last modified : 05th July 2013
     *
     * Author :Suraj Kumar Maurya
     *
     * Last modified by :Suraj Kumar Maurya
     *
     * Comments : This function return currency sign. It take one argument.
     *
     * Use instruction : obj->insertVisitor()
     *
     */
    function insertVisitor() {
        global $objCore;

        if (!isset($_SESSION['visitor'])) {

            $arrClms = array(
                'VisitorIP' => $_SERVER['REMOTE_ADDR'],
                'Visitor_Date_Added' => $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB)
            );
            $arrRow = $this->insert(TABLE_VISITOR, $arrClms);
            $_SESSION['visitor'] = '1';
        }
    }

    /**
     *
     * Function Name : getCountryByIp
     *
     * Return type : String Price
     *
     * Date created : 05th July 2013
     *
     * Date last modified : 05th July 2013
     *
     * Author :Rupesh Parmar
     *
     * Last modified by : Rupesh Parmar
     *
     * Comments : This function return currency sign. It take one argument.
     *
     * Use instruction : obj->getCountryByIp()
     *
     */
    function getCountryByIp() {

        $varRes = '';
        if (isset($_SESSION['sessUserInfo']['countryid'])) {

            $country = (int) $_SESSION['sessUserInfo']['countryid'];
        } else {

            // add new api --- start()
            //echo "55555555";
            $remoteIp = $_SERVER['REMOTE_ADDR'];
            $dif = explode('.', $remoteIp);
            $fst = $dif[0];
            $sec = $dif[1];
            $remoteIp = $fst . '.' . $sec;

            if ($remoteIp == '192.168') { //192.168.100.1 -- this is the dothejob Ip in our office Original Ip is 203.100.77.135
                $remoteIp = '203.100.77.135';
            } else {
                $remoteIp = $_SERVER['REMOTE_ADDR'];
            }

            $userIpDetails = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $remoteIp));
            //print_r($userIpDetails);
            $CountryCode = isset($userIpDetails['geoplugin_countryCode']) ? $userIpDetails['geoplugin_countryCode'] : 'US';
            // add new api --- end()

            $arrRes = $this->select(TABLE_COUNTRY, array('country_id'), "iso_code_2='" . $CountryCode . "'");
            //pre($arrRes);
            $country = (int) $arrRes[0]['country_id'];
        }

        $varRes = $country;
        return $varRes;
    }

    /**
     * function sendSpecialFormNotificationEmail
     *
     * This function is used to send Special Application Form Notification Email.
     *
     * Database Tables used in this function are :  tbl_special_application,tbl_special_application_to_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return none
     */
    function statelistbycountryid($country_id) {
        $arrRes = array();
        $arrClms = array(
            'id', 'name',
        );
        // $argWhere="country_id=".$country_id;
        if (!empty($country_id)) {
            $varOrderBy = "";
            $varQuery = "SELECT * FROM states  WHERE country_id = " . $country_id;

            $arrRes = $this->getArrayResult($varQuery);


            return $arrRes;
        } else
            return $arrRes;
    }

    function statelistbycurrentlogincountry($country_id) {
        $arrRes = array();
        $arrClms = array(
            'id', 'name',
        );
        // $argWhere="country_id=".$country_id;
        if (!empty($country_id)) {
            $varOrderBy = "";
            $varQuery = "SELECT * FROM states  WHERE country_id=" . $country_id;
            //  pre($varQuery);
            $arrRes = $this->getArrayResult($varQuery);


            return $arrRes;
        } else
            return $arrRes;
    }

    function countrylistbystateid($state_id) {
        $arrRes = array();
        $arrClms = array(
            'id', 'name',
        );
        // $argWhere="country_id=".$country_id;
        if (!empty($state_id)) {
            $varOrderBy = "";
            $varQuery = "SELECT * FROM cities  WHERE " . $state_id;
            // pre($varQuery);
            $arrRes = $this->getArrayResult($varQuery);


            return $arrRes;
        } else
            return $arrRes;
    }

    function countrylistbynewstateid($state_id) {
        $arrRes = array();
        $arrClms = array(
            'id', 'name',
        );
        // $argWhere="country_id=".$country_id;
        if (!empty($state_id)) {
            $varOrderBy = "";
            $varQuery = "SELECT * FROM cities  WHERE state_id= " . $state_id;
            // pre($varQuery);
            $arrRes = $this->getArrayResult($varQuery);


            return $arrRes;
        } else
            return $arrRes;
    }

    function sendSpecialFormNotificationEmail($applicationIds, $arrSubject) {

        $arrDetails = $this->getApplicationDetails($applicationIds);
        $this->SentNotificationEmailToWholesaler($arrDetails, $arrSubject['wholesalerSubject']);
        $this->SentNotificationEmailToCountryPortal($arrDetails, $arrSubject['adminSubject']);
        $this->SentNotificationEmailToSuperAdmin($arrDetails, $arrSubject['adminSubject']);
    }

    /**
     * function SentNotificationEmailToWholesaler
     *
     * This function Will be called on Sent Email To Wholesaler.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SentNotificationEmailToWholesaler($arrDetails, $subject) {

        global $objCore;

        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td><p>' . $subject . '</p>
            <p>It\'s a pleasure to confirm that your request for special application has been approved. You can refer to the below mentioned details for further reference:
            </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';


        $EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');
        $varSubject = SPECIAL_EMAIL_SUBJECT;
        $varFrom = SITE_NAME;

        $varEmailOrderDetails .= '<tr><td colspan="5">&nbsp;</td></tr>';
        $varEmailOrderDetails .= '<tr><th>' . APPLICATION_ID . '</th><th>' . TRANJECTION_ID . '</th><th>' . QUANTITY . '</th><th>' . STATUS . '</th><th>' . PRICE . '</th></tr>';
        $varTotal = 0;
        foreach ($arrDetails as $k => $v) {
            $varTotal += $v['TotalAmount'];
            $varEmailOrderDetails .= '<tr><td align="center">' . $v['pkApplicationID'] . '</td><td align="center">' . $v['TransactionID'] . '</td>';
            $varEmailOrderDetails .='<td align="center">' . $v['pQty'] . '</td><td align="center">' . $v['IsApproved'] . '</td><td align="center">$ ' . number_format($v['TotalAmount'], 2, '.', ',') . '</td></tr>';
        }

        $varEmailOrderDetailss = $varEmailOrderDetails . '<tr bgcolor="#cccccc"><th colspan="4" align="right">' . GRAND_TOTAL . '</th><td align="center" width="20%">&nbsp;&nbsp;$ ' . number_format($varTotal, 2, ".", ",") . '</td></tr>';

        $varEmailOrderDetailss .='</table>';

        $varName = $arrDetails[0]['CompanyName'];
        $varEmail = $arrDetails[0]['CompanyEmail'];

        $varKeywordValues = array($varName, $varEmailOrderDetailss);
        $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

// Calling mail function
        $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
    }

    /**
     * function SentEmailToCountryPortal
     *
     * This function Will be called on Sent Sent Email To Country Portal.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters $arrOrderDetail
     *
     * @return none
     */
    function SentNotificationEmailToCountryPortal($arrDetails, $subject) {

        global $objCore;

        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>' . $subject . ' : </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
//$varEmailOrderDetails .= '<tr><th>' . ORDER_ID . '</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>' . TRANJECTION_ID . '</th><td colspan="2">&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="5">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>' . APPLICATION_ID . '</th><th>' . TRANJECTION_ID . '</th><th>' . QUANTITY . '</th><th>' . STATUS . '</th><th>' . PRICE . '</th></tr>';


        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";

        if ($arrOrderDetail['SubOrderId'] <> '') {
            $varWhr .= " AND SubOrderID = '" . $arrOrderDetail['SubOrderId'] . "'";
        }
        $arrWholesalerDetails = $this->GetWholesalerDetails($varWhr);

        $EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');
        $varSubject = SPECIAL_EMAIL_SUBJECT;
        $varFrom = SITE_NAME;

        $varTotal = 0;
        foreach ($arrDetails as $k => $v) {
            $varTotal += $v['TotalAmount'];
            $varEmailOrderDetails .= '<tr><td align="center">' . $v['pkApplicationID'] . '</td><td align="center">' . $v['TransactionID'] . '</td>';
            $varEmailOrderDetails .='<td align="center">' . $v['pQty'] . '</td><td align="center">' . $v['IsApproved'] . '</td><td align="center">$ ' . number_format($v['TotalAmount'], 2, '.', ',') . '</td></tr>';
        }

        $varWhere = "AdminCountry = '" . $arrDetails[0]['CompanyCountry'] . "'";

        $AdminData = $this->GetAdminDetails($varWhere);
        $varCtr = 0;

        foreach ($AdminData as $val) {

            if ($val['AdminRegion'] == $arrDetails[0]['CompanyRegion']) {
                $varEmail = $val['AdminEmail'];
                $varName = $val['AdminUserName'];
                $varCtr = $varCtr++;
            } else if ($val['AdminCountry'] == $arrDetails[0]['CompanyCountry'] && $varCtr == 0) {
                $varEmail = $val['AdminEmail'];
                $varName = $val['AdminUserName'];
            } else {

                continue;
            }

            $varEmailOrderDetailss = $varEmailOrderDetails . '<tr bgcolor="#cccccc"><th colspan="4" align="right">' . GRAND_TOTAL . '</th><td align="center">&nbsp;&nbsp;$&nbsp;' . number_format($varTotal, 2, ".", ",") . '</td></tr>';

            $varEmailOrderDetailss .='</table>';

            $varKeywordValues = array($varName, $varEmailOrderDetailss);
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

// Calling mail function
            $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
        }
    }

    /**
     * function SentNotificationEmailToSuperAdmin
     *
     * This function Will be called on Sent Email To SuperAdmin.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return none
     */
    function SentNotificationEmailToSuperAdmin($arrDetails, $subject) {

        global $objCore;
        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>' . $subject . ': </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
// $varEmailOrderDetails .= '<tr><th>' . APPLICATION_ID . '</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>' . TRANJECTION_ID . '</th><td colspan="2">&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="5">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>' . APPLICATION_ID . '</th><th>' . TRANJECTION_ID . '</th><th>' . QUANTITY . '</th><th>' . STATUS . '</th><th>' . PRICE . '</th></tr>';
        $varTotal = 0;
        foreach ($arrDetails as $k => $v) {
            $varTotal += $v['TotalAmount'];
            $varEmailOrderDetails .= '<tr><td align="center">' . $v['pkApplicationID'] . '</td><td align="center">' . $v['TransactionID'] . '</td>';
            $varEmailOrderDetails .='<td align="center">' . $v['pQty'] . '</td><td>' . $v['IsApproved'] . '</td><td align="center">$ ' . number_format($v['TotalAmount'], 2, '.', ',') . '</td></tr>';
        }

        $varEmailOrderDetails .= '<tr bgcolor="#cccccc"><th colspan="4" align="right">' . GRAND_TOTAL . '</th><td align="center">&nbsp;&nbsp;$ ' . number_format($varTotal, 2, ".", ",") . '</td></tr>';

        $varEmailOrderDetails .='</table>';

        $varWhre = "AdminType = 'super-admin' ";
        $arrAdminDetails = $this->GetAdminDetails($varWhre);

        $EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');
        $varSubject = SPECIAL_EMAIL_SUBJECT;
        $varFrom = SITE_NAME;
        foreach ($arrAdminDetails as $admink => $adminv) {

            $varName = $adminv['AdminUserName'];
            $varEmail = $adminv['AdminEmail'];
            $varKeywordValues = array($varName, $varEmailOrderDetails);
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

// Calling mail function
            $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
        }
    }

    /**
     * function getApplicationDetails
     *
     * This function is used to get Special Application Form details.
     *
     * Database Tables used in this function are :  tbl_special_application,tbl_special_application_to_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return none
     */
    function getApplicationDetails($argIds) {
        $arrClms = "pkApplicationID,fkWholesalerID,fkFestivalID,fkCountryID,GROUP_CONCAT(fkCategoryID) as fkCategoryIds ,sum(ProductQty) as pQty,TotalAmount,TransactionID,TransactionAmount,IsPaid,IsApproved,CompanyName,CompanyEmail,CompanyCountry,CompanyRegion";

        $varWhr = "pkApplicationID IN (" . $argIds . ") AND IsPaid = '1'";
        $varTable = TABLE_SPECIAL_APPLICATION . " INNER JOIN " . TABLE_SPECIAL_APPLICATION_TO_CATEGORY . " ON pkApplicationID=fkApplicationID LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID";

        $varQuery = "Select " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhr . " GROUP BY pkApplicationID";
        $arrRes = $this->getArrayResult($varQuery);

        /*
          foreach ($arrRes as $k => $v) {

          } */

//pre($arrRes);
        return $arrRes;
    }

    /**
     * function getAllSpecialProductPrice
     *
     * This function is used to get all Special Product Price.
     *
     * Database Tables used in this function are :  tbl_special_application,tbl_special_application_to_category
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getAllSpecialProductPrice($pids = '') {

        global $objCore;
        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);

        $varWhr = " AND FestivalStartDate <='" . $curDate . "' AND FestivalEndDate>='" . $curDate . "'";

        if ($pids) {
            $varWhr .= " AND fkProductID IN ('" . $pids . "'))";
        } else {
            $varWhr .= ")";
        }

        $varQuerySpcl = "SELECT fkProductID,SpecialPrice,FinalSpecialPrice
            FROM " . TABLE_SPECIAL_PRODUCT . " INNER JOIN " . TABLE_FESTIVAL . " ON (fkFestivalID = pkFestivalID " . $varWhr . " Group By fkProductID";
        $arrResSpcl = $this->getArrayResult($varQuerySpcl);

        $arrRes = array();
        foreach ($arrResSpcl as $v) {
            $arrRes[$v['fkProductID']]['SpecialPrice'] = $v['SpecialPrice'];
            $arrRes[$v['fkProductID']]['FinalSpecialPrice'] = $v['FinalSpecialPrice'];
        }

        return $arrRes;
    }

    function getCountryPortal($argWhr = ' AdminType = "user-admin" ') {
        //die("here");
        //fkAdminRollId != 0 AND
        $arrClms = array('pkAdminID', 'AdminUserName');
        $varOrder = "";
        $arrRes = $this->select(TABLE_ADMIN, $arrClms, $argWhr, $varOrder);
//pre($arrRes);
        return $arrRes;
    }

    function getcurrentCountryPortal($country_id) {
        //die("here");
        $argWhr = "AdminCountry='" . $country_id . "' ";
        $arrClms = array('pkAdminID', 'AdminUserName');
        $varOrder = "";
        $arrRes = $this->select(TABLE_ADMIN, $arrClms, $argWhr, $varOrder);
        //pre($arrRes);
        return $arrRes;
    }

    function CountryPortalHtml($catAry, $catName, $catID, $selVal = null, $defVal = 'All Country Portal', $multiple = 0, $parameters = '', $isfront = '1', $isOptGrp = 0, $FrmWhr = null) {
        // Hemant - Add last perametr -  $FrmWhr = '';
        //pre($selVal);
//        pre($isfront);
//        pre($isOptGrp);
        //echo gettype($selVal); die;
        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='<script type="text/javascript">
                            $(document).ready(function() {
                                $("select#' . $catID . '").searchable({
                                maxListSize: "' . count($catAry) . '",
                                maxMultiMatch: "' . round(count($catAry) / 2) . '"
                                });
                                });
                                        /*$(document).ready(function() {
                                            $("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
                                });*/
                        </script>';
            }
        }
        $html.='<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        if ($defVal != '') {
            $html.='<option value=" " ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }
        // pre($catAry);
        if (is_array($catAry)) {
            foreach ($catAry as $key => $cat) {
//pre($cat);
                if (empty($cat['AdminUserName']))
                    continue;
                // pre($selVal);
//$main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
//pre($cat['pkAdminID']);
//                 if (in_array($cat['pkAdminID'], $selVal)) {
//                     $main = 'Selected';
//                 } else {
//                     $main = 'abc';          // $main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
//                 }
                if ($cat['pkAdminID'] == $selVal)
                    $main = 'Selected';
                else
                    $main = '';

                // $html.='<option "'.$main. $selVal.'" value="' . $cat['pkAdminID'] . '" ' . ($main) . '>' . $cat['AdminUserName'] . '</option>';
                $html.='<option value="' . $cat['pkAdminID'] . '" ' . ($main) . '>' . $cat['AdminUserName'] . '</option>';
            }
        }
        $html.='
    </select>';
        //echo $html;die();
        return $html;
    }

    function CountryPortalHtmlcountries($catAry, $catName, $catID, $selVal = null, $defVal = 'All Country Portal', $multiple = 0, $parameters = '', $isfront = '1', $isOptGrp = 0, $FrmWhr = null) {
        // Hemant - Add last perametr -  $FrmWhr = '';
        //pre($selVal);
        //        pre($isfront);
        //        pre($isOptGrp);
        //echo gettype($selVal); die;
        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='<script type="text/javascript">
                            $(document).ready(function() {
                                $("select#' . $catID . '").searchable({
                                maxListSize: "' . count($catAry) . '",
                                maxMultiMatch: "' . round(count($catAry) / 2) . '"
                                });
                                });
                                        /*$(document).ready(function() {
                                            $("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
                                });*/
                        </script>';
            }
        }
        $html.='<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        if ($defVal != '') {
            $html.='<option value="0" ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }
        //pre($catAry);
        if (is_array($catAry)) {
            foreach ($catAry as $key => $cat) {
                //pre($cat);
                if (empty($cat['AdminUserName']))
                    continue;

                //$main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
                //pre($cat['pkAdminID']);
                if ($cat['pkAdminID'] == $selVal)
                    $main = 'Selected';
                else
                    $main = '';
                // $html.='<option "'.$main. $selVal.'" value="' . $cat['pkAdminID'] . '" ' . ($main) . '>' . $cat['AdminUserName'] . '</option>';
                $html.='<option value="' . $cat['pkAdminID'] . '" ' . ($main) . '>' . $cat['AdminUserName'] . '</option>';
            }
        }
        $html.='
    </select>';
        //echo $html;die();
        return $html;
    }

    function CountryHtmlRemaining($catAry, $catName, $catID, $selVal = null, $defVal = 'All Country', $multiple = 0, $parameters = '', $isfront = '1', $isOptGrp = 0, $FrmWhr = null) {
        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='<script type="text/javascript">
                            $(document).ready(function() {
                                $("select#' . $catID . '").searchable({
                                maxListSize: "' . count($catAry) . '",
                                maxMultiMatch: "' . round(count($catAry) / 2) . '"
                                });
                                });
                                        /*$(document).ready(function() {
                                            $("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
                                });*/
                        </script>';
            }
        }
        $html.='<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        if ($defVal != '') {
            $html.='<option value="0" ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }
        //pre($catAry);
        if (is_array($catAry)) {
            foreach ($catAry as $key => $cat) {
//pre($cat);
                if (empty($cat['fkcountry_id']))
                    continue;

//$main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
//pre($cat['pkAdminID']);
                if (in_array($cat[$catID], $selVal)) {
                    $main = 'Selected';
                } else {
                    $main = '';          // $main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
                }
                // $html.='<option "'.$main. $selVal.'" value="' . $cat['pkAdminID'] . '" ' . ($main) . '>' . $cat['AdminUserName'] . '</option>';
                $html.='<option value="' . $cat['fkcountry_id'] . '" ' . ($main) . '>' . $cat['name'] . '</option>';
            }
        }
        $html.='
    </select>';
        //echo $html;die();
        return $html;
    }

    function getCountrygatway($argWhr = '') {
        //die("here");
        $arrClms = array('pkShippingGatewaysID', 'ShippingTitle');
        $varOrder = "";
        $arrRes = $this->select(TABLE_SHIP_GATEWAYS, $arrClms, $argWhr, $varOrder);
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

    function getportalnamebyid($varID, $varPortalFilter) {

        $argWhr = "pkAdminID='" . $varID . "' ";
        $arrClms = array('AdminUserName');
        $arrRes = $this->select(TABLE_ADMIN, $arrClms, $argWhr, $varOrder);

        //pre($arrRes);
        return $arrRes;
    }

    function getCustomername($varID, $varPortalFilter) {

        $argWhr = "pkCustomerID='" . $varID . "' ";
        $arrClms = array('CustomerFirstName,CustomerLastName');
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhr, $varOrder);
        //$argWhere = "pkCustomerID ='" . ' 21 ' . "' ";
        //$varQuery = "SELECT CustomerFirstName,CustomerLastName FROM " . TABLE_CUSTOMER .  " where " .  $argWhere ;
        // pre($varQuery);
        //$arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    function convertproductdimention($DimentionUnit, $Dimenion) {


        if ($DimentionUnit == 'mm') { // 10 mm = 1 cm
            $DimenionReturn = round($Dimenion, 2) / 10;
        } else if ($DimentionUnit == 'in') { // 0.393701 inch = 1 cm
            $DimenionReturn = round($Dimenion, 2) * round(2.54, 2);
        }
        $DimenionReturn = $this->floatNumber($DimenionReturn);

        return $DimenionReturn;
    }

    function convertproductweight($WeightUnit, $Weight) {

//     	$argWhr = "pkCustomerID='" . $varID . "' ";
//     	$arrClms = array('CustomerFirstName,CustomerLastName');
//     	$arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhr, $varOrder);
//     	return $arrRes;

        $arrProduct['WeightUnit'] = $WeightUnit;
        $arrProduct['Weight'] = $Weight;



        if ($arrProduct['WeightUnit'] == 'g') { // 1000 Gram = 1 kg
            $arrProduct['Weight'] = round($arrProduct['Weight'], 2) / 1000;
            //pre( $arrProduct['Weight']);
        } else if ($arrProduct['WeightUnit'] == 'lb') { // 2.20462 Pound = 1 kg
            $arrProduct['Weight'] = round($arrProduct['Weight'], 2) / round(2.20462, 2);
        } else if ($arrProduct['WeightUnit'] == 'oz') { // 35.274 Ounce = 1 kg
            $arrProduct['Weight'] = round($arrProduct['Weight'], 2) / round(35.274);
        }
        $productweight = $this->floatNumber($arrProduct['Weight']);
        // $arrProduct['Weight'] = round($arrProduct['Weight'], 2);
        //$arrProduct['Weight'] =number_format($arrProduct['Weight'], 2, '.', '');
        //pre( $arrProduct['Weight']);
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

    function getCountrygatwaymethod($argWhr = '') {
        //die("here");
        $arrClms = array('pkShippingGatewaysID', 'ShippingTitle');
        $argWhr = "ShippingTitle='" . $arrPost['frmShippingName'] . "' ";
        $varOrder = "";
        $arrRes = $this->select(TABLE_SHIP_GATEWAYS, $arrClms, $argWhr, $varOrder);
        //pre($arrRes);
        return $arrRes;
    }

    function CountryGatwaylHtml($catAry, $catName, $catID, $selVal = null, $defVal = 'Select shipping Gateway', $multiple = 0, $parameters = '', $isfront = '1', $isOptGrp = 0, $FrmWhr = null) {
        // Hemant - Add last perametr -  $FrmWhr = '';
        //pre($catAry);
        //        pre($isfront);
        //        pre($isOptGrp);
        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='<script type="text/javascript">
                            $(document).ready(function() {
                                $("select#' . $catID . '").searchable({
                                maxListSize: "' . count($catAry) . '",
                                maxMultiMatch: "' . round(count($catAry) / 2) . '"
                                });
                                });
                                        /*$(document).ready(function() {
                                            $("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
                                });*/
                        </script>';
            }
        }
        $html.='<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        if ($defVal != '') {
            $html.='<option value="0" ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }
        //pre($selVal);
        if (is_array($catAry)) {
            foreach ($catAry as $key => $cat) {
                //pre($cat);
                if (empty($cat['ShippingTitle']))
                    continue;
                $main = in_array($cat['pkShippingGatewaysID'], $selVal) ? 'Selected' : '';
                $html.='<option value="' . $cat['pkShippingGatewaysID'] . '" ' . ($main) . '>' . $cat['ShippingTitle'] . '</option>';
            }
        }
        $html.='
    </select>';
        //echo $html;die();
        return $html;
    }

    /**
     * function getCountry
     *
     * This function is used to get all country.
     *
     * Database Tables used in this function are :  tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getCountry($argWhr = '') {
        //die("here");
        $arrClms = array('country_id', 'name');
        $varOrder = "name asc";
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms, $argWhr, $varOrder);
//pre($arrRes);
        return $arrRes;
    }

    function getCountrynamebyid($varID) {
        //die("here");
        $argWhr = "country_id='" . $varID . "' ";
        $arrClms = array('name');
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms, $argWhr, $varOrder);
        //pre($arrRes);
        return $arrRes;
    }

    function getshippingmethodnamebyid($varID) {
        //die("here");
        $argWhr = "pkShippingMethod='" . $varID . "' ";
        $arrClms = array('MethodName');
        $arrRes = $this->select(TABLE_SHIPPING_METHOD, $arrClms, $argWhr, $varOrder);
        //pre($arrRes);
        return $arrRes;
    }

    function checkmethodisusedinzoneprice($methodid) {
        $argWhr = "shippingmethod='" . $methodid . "' ";
        $arrClms = array('shippingmethod');
        $arrRes = $this->select(TABLE_ZONEPRICE, $arrClms, $argWhr, $varOrder);
        //pre($arrRes);
        return $arrRes;
    }

    function checklogisticportalidzoneprice($logisticid) {
        $argWhr = "fklogisticidvalue='" . $logisticid . "' ";
        $arrClms = array('fklogisticidvalue');
        $arrRes = $this->select(TABLE_ZONEPRICE, $arrClms, $argWhr, $varOrder);
        //pre($arrRes);
        return $arrRes;
    }

    function CountryHtml($catAry, $catName, $catID, $selVal = null, $defVal = 'All Country', $multiple = 0, $parameters = '', $isfront = '1', $isOptGrp = 0, $FrmWhr = null) {
        // Hemant - Add last perametr -  $FrmWhr = '';
        //pre($selVal);
//        pre($isfront);
//        pre($isOptGrp);
        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='<script type="text/javascript">
                            $(document).ready(function() {
                                $("select#' . $catID . '").searchable({
                                maxListSize: "' . count($catAry) . '",
                                maxMultiMatch: "' . round(count($catAry) / 2) . '"
                                });
                                });
                                        /*$(document).ready(function() {
                                            $("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
                                });*/
                        </script>';
            }
        }
        $html.='<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        // pre($defVal);
        if ($defVal != '') {
            $html.='<option value="0" ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }
        //pre($catAry);
        if (is_array($catAry)) {
            foreach ($catAry as $key => $cat) {
//pre($cat);
                if (empty($cat['name']))
                    continue;



                /* if ($isOptGrp == '1' && $cat['CategoryLevel'] == '0') {
                  $html.='<optgroup label="' . $cat['CategoryName'] . '">
                  <option value="" class="dNone"></option>';

                  } else if ($isOptGrp == '2' && $cat['CategoryLevel'] == '0') {
                  $html.='<optgroup label="' . $cat['CategoryName'] . '">';
                  } else { */
                $main = in_array($cat['country_id'], $selVal) ? 'Selected' : '';
                $html.='<option value="' . $cat['country_id'] . '" ' . ($main) . '>' . $cat['name'] . '</option>';
                //}
                //$html.='<option value="' . $cat['country_id'] . '" ' . ($main) . '>' . $cat['name'] . '</option>';
                //echo '<pre>';print_r($catAry);
                //echo '<pre>';print_r($cat['pkCategoryId']);
                //echo '<pre>';print_r($selVal);
                //$html.= $this->CategoryHtml2($catAry, $cat['pkCategoryId'], $selVal, '....', $isOptGrp, $FrmWhr);
                //if ($isOptGrp == '1' && $cat['CategoryLevel'] == '0') {
                //$html.='</optgroup>';
                //} else if ($isOptGrp == '2' && $cat['CategoryLevel'] == '0') {
                //$html.='</optgroup>';
                //}
//$html .='<option value="' . $keySelect . '" ' . (in_array($keySelect, $selVal) ? 'Selected' : '') . ' class="catOpt ' . ($levlAry[$keySelect] == 0 ? 'level1' : ($levlAry[$keySelect] > 1 ? 'level2' : '')) . '">' . $valSelect . '</option>';
            }
        }
        $html.='
    </select>';
        //echo $html;die();
        return $html;
    }

    function CountryNameLogistic($catAry, $catName, $catID, $selVal = null, $defVal = 'All Country Name', $multiple = 0, $parameters = '', $isfront = '1', $isOptGrp = 0, $FrmWhr = null) {

        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='<script type="text/javascript">
                            $(document).ready(function() {
                                $("select#' . $catID . '").searchable({
                                maxListSize: "' . count($catAry) . '",
                                maxMultiMatch: "' . round(count($catAry) / 2) . '"
                                });
                                });
                                        /*$(document).ready(function() {
                                            $("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
                                });*/
                        </script>';
            }
        }
        $html.='<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        if ($defVal != '') {
            $html.='<option value=" " ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }
        // pre($catAry);
        if (is_array($catAry)) {
            foreach ($catAry as $key => $cat) {
//pre($cat);
                if (empty($cat['name']))
                    continue;
                // pre($selVal);
//$main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
//pre($cat['pkAdminID']);
//                 if (in_array($cat['pkAdminID'], $selVal)) {
//                     $main = 'Selected';
//                 } else {
//                     $main = 'abc';          // $main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
//                 }
                if ($cat['country_id'] == $selVal)
                    $main = 'Selected';
                else
                    $main = '';

                // $html.='<option "'.$main. $selVal.'" value="' . $cat['pkAdminID'] . '" ' . ($main) . '>' . $cat['AdminUserName'] . '</option>';
                $html.='<option value="' . $cat['country_id'] . '" ' . ($main) . '>' . $cat['name'] . '</option>';
            }
        }
        $html.='
    </select>';
        //echo $html;die();
        return $html;
    }

    function getmethodnamebylogisticid($logisticid, $currentcountryid) {
        $varClms = "MethodName,pkShippingMethod";

        $varTable = TABLE_SHIPPING_METHOD . " LEFT JOIN " . TABLE_ZONEPRICE . " ON pkShippingMethod = shippingmethod ";
        $argWhere = "fklogisticidvalue = " . $logisticid . " AND pricestatus=1 AND MethodStatus=1" . " AND fkcountriesid=" . $currentcountryid;
        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";

        // $varOrderBy = "GROUP BY fkShippingMethodID ORDER BY ShippingType ASC,ShippingTitle ASC";
        $varOrderBy = "GROUP BY MethodName ORDER BY MethodName ASC";

        $varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy . "  " . $varLimit;

        $arrRes = $this->getArrayResult($varQuery);
        //pre($varQuery);
        return $arrRes;
    }

    function getshippingpricedetailbymethod($logisticid, $currentcountryid, $shippinggatwayid) {

        $varQuery = "SELECT *,c1.name as frmCountryName,c2.name as toCountryName,title from " . TABLE_ZONEPRICE . ""
                . " LEFT JOIN " . TABLE_SHIPPING_METHOD . " ON shippingmethod = pkShippingMethod "
                . " LEFT JOIN " . TABLE_ZONEDETAIL . " ON zonetitleid = fkzoneid"
                . " LEFT JOIN " . TABLE_ZONE . " ON zonetitleid = zoneid "
                . " LEFT JOIN " . TABLE_COUNTRY . " as c1 ON fromcountry = c1.country_id "
                . " LEFT JOIN " . TABLE_COUNTRY . " as c2 ON tocountry = c2.country_id "
                . " WHERE fkcountriesid =" . $currentcountryid . " AND shippingmethod =" . $shippinggatwayid . ""
                . " AND DATE(created) = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE "
                . " fklogisticidvalue =" . $logisticid . " AND newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid "
                . " AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod )"
                . " group by pkpriceid order by date(`created`) desc";
//        $varQuery = "SELECT *,c1.name as frmCountryName,c2.name as toCountryName,title"
//               
//                . " FROM " . TABLE_ZONEPRICE . " "
//                . " LEFT JOIN " . TABLE_ZONEDETAIL . " ON zonetitleid = fkzoneid"
//                . " LEFT JOIN" . TABLE_SHIPPING_METHOD . " ON pkShippingMethod = shippingmethod"
//                . " LEFT JOIN " . TABLE_ZONE . " ON zonetitleid = zoneid "
//                . " LEFT JOIN " . TABLE_COUNTRY . " as c1 ON fromcountry = c1.country_id "
//                . " LEFT JOIN " . TABLE_COUNTRY . " as c2 ON tocountry = c2.country_id "
//             
//                . " WHERE  fklogisticidvalue = " . $logisticid . " AND fkcountriesid =".$currentcountryid." AND shippingmethod =".$shippinggatwayid."";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    function getlogisticnamebyarea($currentcountryid, $convertweight, $locationvalue, $Lengthvalue, $Widthvalue, $Heightvalue, $multiplecountriesvid, $DimensionUnit) {
        //echo $Lengthvalue . ' ' .$Widthvalue .' '. $Heightvalue . ' '. $DimensionUnit .'<br>';
            
        if ($DimensionUnit != 'cm') {
            $Lengthvalue = $this->convertproductdimention($DimensionUnit, $Lengthvalue);
            $Widthvalue = $this->convertproductdimention($DimensionUnit, $Widthvalue);
            $Heightvalue = $this->convertproductdimention($DimensionUnit, $Heightvalue);
            //  $arrProduct['DimensionUnit'] = 'cm';
        }
      //  echo $Lengthvalue . ' ' .$Widthvalue .' '. $Heightvalue . ' '. $DimensionUnit .'<br>';
        $varClms = "logisticportalid,logisticTitle,logisticgatwaytype";
 $date = date('Y-m-d');
        $varTable = TABLE_LOGISTICPORTAL . " LEFT JOIN " . TABLE_ZONEPRICE . " ON logisticportalid = fklogisticidvalue  LEFT JOIN " . TABLE_ZONEDETAIL . " ON zonetitleid = fkzoneid";
        if ($locationvalue == 'local') {
            // $argWhere = "logisticportal = " . $currentcountryid . " AND pricestatus=1 AND logisticStatus=1 AND fromcountry=" . $currentcountryid . " AND tocountry=" . $currentcountryid . " AND minkg <=" . $convertweight . " AND maxkg >=" . $convertweight . " AND maxlength >=" . $Lengthvalue . " AND maxwidth >=" . $Widthvalue . " AND maxheight >=" . $Heightvalue;
            $argWhere = "logisticportal = " . $currentcountryid .
                    " AND DATE(created) = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE 
                    newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod AND DATE(created) <= '" . $date . "' )
                    AND pricestatus=1 AND logisticStatus=1 AND fromcountry=" . $currentcountryid .
                    " AND tocountry=" . $currentcountryid . " AND minkg <=" . $convertweight . " "
                    . "AND maxkg >=" . $convertweight . " AND maxlength >=" . $Lengthvalue . " "
                    . "AND maxwidth >=" . $Widthvalue . " AND maxheight >=" . $Heightvalue;
        }

        if ($locationvalue == 'gloabal') {
            //$argWhere = "logisticportal = " . $currentcountryid . " AND pricestatus=1 AND logisticStatus=1 AND fromcountry=" . $currentcountryid . " AND minkg <=" . $convertweight . " AND maxkg >=" . $convertweight . " AND maxlength >=" . $Lengthvalue . " AND maxwidth >=" . $Widthvalue . " AND maxheight >=" . $Heightvalue;
            $argWhere = "logisticportal = " . $currentcountryid .
                    " AND DATE(created) = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE
                  newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod AND DATE(created) <= '" . $date . "' )
                 AND pricestatus=1 AND logisticStatus=1 AND fromcountry=" . $currentcountryid .
                    " AND minkg <=" . $convertweight . " AND maxkg >=" . $convertweight . " AND maxlength >="
                    . $Lengthvalue . " AND maxwidth >=" . $Widthvalue . " AND maxheight >=" . $Heightvalue;
        }

        if ($locationvalue == 'multiple') {

            //$argWhere = "logisticportal = " . $currentcountryid . " AND pricestatus=1 AND logisticStatus=1 AND fromcountry=" . $currentcountryid . " AND tocountry IN (" . implode(",", $multiplecountriesvid) . " ) AND minkg <=" . $convertweight . " AND maxkg >=" . $convertweight . " AND maxlength >=" . $Lengthvalue . " AND maxwidth >=" . $Widthvalue . " AND maxheight >=" . $Heightvalue;
            $argWhere = "logisticportal = " . $currentcountryid .
                    " AND DATE(created) = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE
                  newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod AND DATE(created) <= '" . $date . "' )    
                 AND pricestatus=1 AND logisticStatus=1 AND fromcountry=" . $currentcountryid .
                    " AND tocountry IN (" . implode(",", $multiplecountriesvid) . " ) "
                    . "AND minkg <=" . $convertweight . " AND maxkg >=" . $convertweight . " AND maxlength >=" . $Lengthvalue . " AND maxwidth >=" . $Widthvalue . " AND maxheight >=" . $Heightvalue;
        }
        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";

        // $varOrderBy = "GROUP BY fkShippingMethodID ORDER BY ShippingType ASC,ShippingTitle ASC";
        //GROUP BY logisticTitle ORDER BY logisticTitle ASC
        $varOrderBy = "group by logisticportalid order by date(`created`) desc ";

        $varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy . "  " . $varLimit;
//            pre($varQuery);
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    function countryshippingGatewayList($countryid) {

        $varClms = "logisticportalid,logisticTitle,logisticgatwaytype";

        $varTable = TABLE_LOGISTICPORTAL . " LEFT JOIN " . TABLE_ZONEPRICE . " ON logisticportalid = fklogisticidvalue ";
        $argWhere = "logisticportal = " . $countryid . " AND pricestatus=1 AND logisticStatus=1";
        $varWhere = ($argWhere <> '') ? "WHERE " . $argWhere : "";
        $varLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";

        // $varOrderBy = "GROUP BY fkShippingMethodID ORDER BY ShippingType ASC,ShippingTitle ASC";
        $varOrderBy = "GROUP BY logisticTitle ORDER BY logisticTitle ASC";

        $varQuery = " SELECT " . $varClms . " FROM " . $varTable . " " . $varWhere . " " . $varOrderBy . "  " . $varLimit;
        // pre($varQuery);
        $arrRes = $this->getArrayResult($varQuery);


        //pre($arrRes);
        return $arrRes;
    }

    function zonelistofcurrentlogist($varID) {
        //die("here");
        $argWhr = "fklogisticid='" . $varID . "' ";
        $arrClms = array('zoneid', 'title');
        $arrRes = $this->select(TABLE_ZONE, $arrClms, $argWhr, $varOrder);
        //pre($arrRes);
        return $arrRes;
    }

    function GetCompleteDetailsofLogisticPortalbyid($varID) {
        //die("here");
        $argWhr = "logisticportalid='" . $varID . "' ";
        $arrClms = array('logisticEmail', 'logisticTitle', 'logisticStatus', 'logisticgatwaytype','logisticportal');
        $arrRes = $this->select(TABLE_LOGISTICPORTAL, $arrClms, $argWhr, $varOrder);
        //pre($arrRes);
        return $arrRes;
    }

    function zonelistofcurrentlogistichtml($catAry, $catName, $catID, $selVal = null, $defVal = 'All Country Name', $multiple = 0, $parameters = '', $isfront = '1', $isOptGrp = 0, $FrmWhr = null) {

        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='<script type="text/javascript">
                            $(document).ready(function() {
                                $("select#' . $catID . '").searchable({
                                maxListSize: "' . count($catAry) . '",
                                maxMultiMatch: "' . round(count($catAry) / 2) . '"
                                });
                                });
                                        /*$(document).ready(function() {
                                            $("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
                                });*/
                        </script>';
            }
        }
        $html.='<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        if ($defVal != '') {
            $html.='<option value=" " ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }
        // pre($catAry);
        if (is_array($catAry)) {
            foreach ($catAry as $key => $cat) {
//pre($cat);
                if (empty($cat['title']))
                    continue;
                // pre($selVal);
//$main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
//pre($cat['pkAdminID']);
//                 if (in_array($cat['pkAdminID'], $selVal)) {
//                     $main = 'Selected';
//                 } else {
//                     $main = 'abc';          // $main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
//                 }
                if ($cat['zoneid'] == $selVal)
                    $main = 'Selected';
                else
                    $main = '';

                // $html.='<option "'.$main. $selVal.'" value="' . $cat['pkAdminID'] . '" ' . ($main) . '>' . $cat['AdminUserName'] . '</option>';
                $html.='<option value="' . $cat['zoneid'] . '" ' . ($main) . '>' . $cat['title'] . '</option>';
            }
        }
        $html.='
    </select>';
        //echo $html;die();
        return $html;
    }

    function shippingmethodlist() {
        //die("here");
        //$argWhr = "fklogisticid='" . $varID . "' ";
        $argWhr = "MethodStatus=1";
        $arrClms = array('pkShippingMethod', 'MethodName');
        $varOrderBy = " ORDER BY MethodName ASC";
        $varOrder = " MethodName ASC ";
        $arrRes = $this->select(TABLE_SHIPPING_METHOD, $arrClms, $argWhr, $varOrder);
        // pre($arrRes);
        return $arrRes;
    }

    function shippingmethodlisthtml($catAry, $catName, $catID, $selVal = null, $defVal = 'All Country Name', $multiple = 0, $parameters = '', $isfront = '1', $isOptGrp = 0, $FrmWhr = null) {

        $html = '';
        if ($multiple == 0) {
            if ($isfront <> '1') {
                $html .='<script type="text/javascript">
                            $(document).ready(function() {
                                $("select#' . $catID . '").searchable({
                                maxListSize: "' . count($catAry) . '",
                                maxMultiMatch: "' . round(count($catAry) / 2) . '"
                                });
                                });
                                        /*$(document).ready(function() {
                                            $("select#' . $catID . '").searchable({maxListSize : ' . count($catAry) . '});
                                });*/
                        </script>';
            }
        }
        $html.='<select name="' . $catName . '" id="' . $catID . '" ' . ($multiple ? 'multiple' : '') . ' ' . $parameters . '>';
        if ($defVal != '') {
            $html.='<option value=" " ' . (in_array(0, $selVal) ? 'Selected' : '') . '>' . $defVal . '</option>';
        }
        // pre($catAry);
        if (is_array($catAry)) {
            foreach ($catAry as $key => $cat) {
//pre($cat);
                if (empty($cat['MethodName']))
                    continue;
                // pre($selVal);
//$main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
//pre($cat['pkAdminID']);
//                 if (in_array($cat['pkAdminID'], $selVal)) {
//                     $main = 'Selected';
//                 } else {
//                     $main = 'abc';          // $main = in_array($cat['pkAdminID'], $selVal) ? 'Selected' : '';
//                 }
                if ($cat['pkShippingMethod'] == $selVal)
                    $main = 'Selected';
                else
                    $main = '';

                // $html.='<option "'.$main. $selVal.'" value="' . $cat['pkAdminID'] . '" ' . ($main) . '>' . $cat['AdminUserName'] . '</option>';
                $html.='<option value="' . $cat['pkShippingMethod'] . '" ' . ($main) . '>' . $cat['MethodName'] . '</option>';
            }
        }
        $html.='
    </select>';
        //echo $html;die();
        return $html;
    }

    /**
     * function dashboardKPI
     *
     * This function is used to get dashboard KPI details chart.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_wholesaler_feedback.
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function dashboardKPI($arrRequest) {

// print_r($arrRequest);
        if ($arrRequest['timeWise'] == 'year') {

            $varWhere = "WHERE CompanyCountry ='" . addslashes($arrRequest['ct']) . "' AND YEAR(FeedbackDateAdded)='" . addslashes($arrRequest['timeYear']) . "' AND IsPositive = '1'";

            $varQuery = "SELECT count(pkFeedbackID) as num, DATE_FORMAT(FeedbackDateAdded,'%b') as months FROM " . TABLE_WHOLESALER_FEEDBACK . " INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID " . $varWhere . " GROUP BY months";
            $arrRes = $this->getArrayResult($varQuery);

            $arrFeedback = array();
            $arrPostiveFeedback = array();
            foreach ($arrRes as $key => $val) {
                $arrPostiveFeedback[$val['months']] = $val;
                $arrFeedback[$val['months']]['months'] = $val['months'];
            }

            $varWhere = "WHERE CompanyCountry ='" . addslashes($arrRequest['ct']) . "' AND YEAR(FeedbackDateAdded)='" . addslashes($arrRequest['timeYear']) . "' ";
            $varQuery = "SELECT count(pkFeedbackID) as num, DATE_FORMAT(FeedbackDateAdded,'%b') as months FROM " . TABLE_WHOLESALER_FEEDBACK . " INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID " . $varWhere . " GROUP BY months";
            $arrRes = $this->getArrayResult($varQuery);

            $arrTotalFeedback = array();


            foreach ($arrRes as $key => $val) {
                $arrTotalFeedback[$val['months']] = $val;
                $arrFeedback[$val['months']]['months'] = $val['months'];
            }


            foreach ($arrFeedback as $key => $val) {
                $arrFeedback[$val['months']]['pos'] = (int) $arrPostiveFeedback[$val['months']]['num'];
                $arrFeedback[$val['months']]['tot'] = (int) $arrTotalFeedback[$val['months']]['num'];
            }

            foreach ($arrFeedback as $key => $val) {

                if ($val['tot'] > 0) {
                    $kpi = ($val['pos'] / $val['tot']) * 100;
                } else {
                    $kpi = '100';
                }

                $kpi = number_format($kpi, 2);

                $arrFeedback[$val['months']]['kpi'] = $kpi;
            }


            $arrdt = array();
            $i = 0;
            foreach ($arrFeedback as $key => $val) {
                $arrdt[$i] = array('c' => array('0' => array('v' => $val['months']), '1' => array('v' => $val['kpi'])));
                $i++;
            }

            $arrRows = array(
                'cols' => array(
                    '0' => array('label' => 'Month', 'type' => 'string'),
                    '1' => array('label' => 'KPI %', 'type' => 'number')
                ),
                'rows' => $arrdt
            );

// pre($arrRows);
            return $arrRows;
        } else {

            $yearMonth = $arrRequest['timeYear'] . '-' . str_pad($arrRequest['timeMonth'], 2, '0', STR_PAD_LEFT);

            $varWhere = "WHERE CompanyCountry ='" . addslashes($arrRequest['ct']) . "' AND DATE_FORMAT(FeedbackDateAdded,'%Y-%m')='" . addslashes($yearMonth) . "' AND IsPositive = '1'";
            $varQuery = "SELECT count(pkFeedbackID) as num, (WEEK(FeedbackDateAdded,5)-WEEK(DATE_SUB(FeedbackDateAdded, INTERVAL DAYOFMONTH(FeedbackDateAdded)-1 DAY),5)+1) as weeks  FROM " . TABLE_WHOLESALER_FEEDBACK . " INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID " . $varWhere . " GROUP BY weeks";
            $arrRes = $this->getArrayResult($varQuery);

            $arrFeedback = array();
            $arrPostiveFeedback = array();
            foreach ($arrRes as $key => $val) {
                $arrPostiveFeedback[$val['weeks']] = $val;
                $arrFeedback[$val['weeks']]['weeks'] = $val['weeks'];
            }


            $varWhere = "WHERE CompanyCountry ='" . addslashes($arrRequest['ct']) . "' AND DATE_FORMAT(FeedbackDateAdded,'%Y-%m')='" . addslashes($yearMonth) . "'";
            $varQuery = "SELECT count(pkFeedbackID) as num, (WEEK(FeedbackDateAdded,5)-WEEK(DATE_SUB(FeedbackDateAdded, INTERVAL DAYOFMONTH(FeedbackDateAdded)-1 DAY),5)+1) as weeks  FROM " . TABLE_WHOLESALER_FEEDBACK . " INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID " . $varWhere . " GROUP BY weeks";
            $arrRes = $this->getArrayResult($varQuery);

            $arrTotalFeedback = array();


            foreach ($arrRes as $key => $val) {
                $arrTotalFeedback[$val['weeks']] = $val;
                $arrFeedback[$val['weeks']]['weeks'] = $val['weeks'];
            }


            foreach ($arrFeedback as $key => $val) {
                $arrFeedback[$val['weeks']]['pos'] = (int) $arrPostiveFeedback[$val['weeks']]['num'];
                $arrFeedback[$val['weeks']]['tot'] = (int) $arrTotalFeedback[$val['weeks']]['num'];
            }



            foreach ($arrFeedback as $key => $val) {

                if ($val['tot'] > 0) {
                    $kpi = ($val['pos'] / $val['tot']) * 100;
                } else {
                    $kpi = '100';
                }

                $kpi = number_format($kpi, 2);

                $arrFeedback[$val['weeks']]['kpi'] = $kpi;
            }


            $arrdt = array();
            $i = 0;
            foreach ($arrFeedback as $key => $val) {
                $arrdt[$i] = array('c' => array('0' => array('v' => $val['weeks'] . ' week'), '1' => array('v' => $val['kpi'])));
                $i++;
            }

            $arrRows = array(
                'cols' => array(
                    '0' => array('label' => 'Week', 'type' => 'string'),
                    '1' => array('label' => 'KPI %', 'type' => 'number')
                ),
                'rows' => $arrdt
            );

// pre($arrRows);
            return $arrRows;
        }
    }

    /**
     * function getCustomerByRewardId
     *
     * This function is used to get customer id.
     *
     * Database Tables used in this function are :  tbl_reward_point
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getCustomerByRewardId($rid) {
        $arrClms = array('fkCustomerID');
        $arrRes = $this->select(TABLE_REWARD_POINT, $arrClms, "pkRewardPointID='" . $rid . "'");
        return $arrRes[0]['fkCustomerID'];
    }

    /**
     * function updateCustomerRewards
     *
     * This function is used to update customer balanced points.
     *
     * Database Tables used in this function are :  tbl_reward_point, tbl_customer
     *
     * @access public
     *
     * @parameters 2 string, string
     *
     * @return array $arrRes
     */
    function updateCustomerRewards($rid = 0, $cid = 0) {
        $varWhr = "";

        if ($cid == 0) {
            $cid = $this->getCustomerByRewardId($rid);
        }

        if ($cid > 0) {
            $varWhr = " AND fkCustomerID='" . $cid . "' ";

            $varQuery = "SELECT (SELECT sum(Points) FROM " . TABLE_REWARD_POINT . " WHERE TransactionType='credit' " . $varWhr . ") as credit, (SELECT sum(Points) FROM " . TABLE_REWARD_POINT . " WHERE TransactionType='debit' " . $varWhr . ") as debit";
            $arrRes = $this->getArrayResult($varQuery);
            $points = $arrRes[0]['credit'] - $arrRes[0]['debit'];

            $arrClms = array('BalancedRewardPoints' => $points);
            $varWhr = "pkCustomerID='" . $cid . "'";
            $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
        }
        return true;
    }

    /**
     * function addRewards
     *
     * This function is used to add rewards points.
     *
     * Database Tables used in this function are :  tbl_reward_point
     *
     * @access public
     *
     * @parameters 5 string,string,string,string,string
     *
     * @return array $arrRes
     */
    function addRewards($cid = 0, $key = 'Others', $points = 0, $type = 'credit', $status = 'Approved', $varOrderID1 = '') {
        global $objCore;


        $arrSett = $this->getSetting('RewardStatus');


        if ($cid > 0 && $arrSett['RewardStatus']['SettingValue'] == '1') {
            $arrRewardList = $objCore->getRewardList();

            $varDesc = (key_exists($key, $arrRewardList)) ? $arrRewardList[$key] : $key;

            if ($points <= 0 && key_exists($key, $arrRewardList)) {
                $arrSett = $this->getSetting($key);

                $points = (int) $arrSett[$key]['SettingValue'];
            }
            if ($varDesc == 'Place an order') {
                $arrSett = $arrRewardList = $this->getSetting('ordertime');
                $orderday = $arrSett['ordertime']['SettingValue'];
                $enddate = date('Y-m-d', strtotime("+$orderday days"));
                $arrClms = array(
                    'fkCustomerID' => $cid,
                    'fkOrderID' => $varOrderID1,
                    'TransactionType' => 'pending',
                    'Description' => $varDesc,
                    'Points' => $points,
                    'RewardStatus' => 'Approved',
                    'RewardEndDate' => $enddate,
                    'RewardDateAdded' => $objCore->serverdateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                );
                $rid = $this->insert(TABLE_REWARD_POINT, $arrClms);

                $this->updateCustomerRewards($rid, $cid);
            }
            if ($points > 0 && $varDesc != 'Place an order') {

                $arrClms = array(
                    'fkCustomerID' => $cid,
                    'TransactionType' => $type,
                    'Description' => $varDesc,
                    'Points' => $points,
                    'RewardStatus' => $status,
                    'RewardDateAdded' => $objCore->serverdateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                );

                $rid = $this->insert(TABLE_REWARD_POINT, $arrClms);

                $this->updateCustomerRewards($rid, $cid);
            }
        }
        return true;
    }

    function diductRewards($cid = 0, $key = 'Others', $points = 0, $type = 'debit', $status = 'Approved') {
        global $objCore;


        $arrSett = $this->getSetting('RewardStatus');


        if ($cid > 0 && $arrSett['RewardStatus']['SettingValue'] == '1') {
            $arrRewardList = $objCore->getRewardList();

            $varDesc = (key_exists($key, $arrRewardList)) ? $arrRewardList[$key] : $key;

            if ($points <= 0 && key_exists($key, $arrRewardList)) {
                $arrSett = $this->getSetting($key);

                $points = (int) $arrSett[$key]['SettingValue'];
            }
            if ($points > 0) {
//                if ($cid > 0) {
//                    $arrClms = array('BalancedRewardPoints');
//                    $varWhr = "pkCustomerID ='" . $cid . "'";
//                    $arrRow = $this->select(TABLE_CUSTOMER, $arrClms, $varWhr);
//                    $balancepoints = $arrRow[0]['BalancedRewardPoints'];
//                }
//                $balancepoints=$balancepoints-$points;
//                if ($balancepoints >= $points) {
//                    pre("yes");
//                    $points = $balancepoints-$points;
//                } else {
//                    pre("yesll");
//                    $points = 0;
//                }
//                 $arrClms = array('BalancedRewardPoints' => $points);
//        $varWhr = " pkCustomerID='" . $cid . "' ";    
//        $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
//               $type = 'debit';
//               $status = 'Approved';

                $arrClms = array(
                    'fkCustomerID' => $cid,
                    'TransactionType' => $type,
                    'Description' => $varDesc,
                    'Points' => $points,
                    'RewardStatus' => $status,
                    'RewardDateAdded' => $objCore->serverdateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
                );

                $rid = $this->insert(TABLE_REWARD_POINT, $arrClms);

                $this->updateCustomerRewards($rid, $cid);
            }
        }
        return true;
    }

//    function updateDiductRewards($rid = 0, $cid = 0,$points) {
//        $varWhr = "";
//
//        if ($cid == 0) {
//            $cid = $this->getCustomerByRewardId($rid);
//        }
//
//        if ($cid > 0) {
//            $arrClms = array('Points' => $points);
//        $varWhr = "  fkCustomerID='" . $cid . "' ";    
//        $this->update(TABLE_REWARD_POINT, $arrClms, $varWhr);
//        
//         $arrClms = array('BalancedRewardPoints' => $points);
//        $varWhr = " pkCustomerID='" . $cid . "' ";    
//        $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
//            
////            $varWhr = " AND fkCustomerID='" . $cid . "' ";
////
////            $varQuery = "SELECT (SELECT sum(Points) FROM " . TABLE_REWARD_POINT . " WHERE TransactionType='credit' " . $varWhr . ") as credit, (SELECT sum(Points) FROM " . TABLE_REWARD_POINT . " WHERE TransactionType='debit' " . $varWhr . ") as debit";
////            $arrRes = $this->getArrayResult($varQuery);
////            $points = $arrRes[0]['credit'] - $arrRes[0]['debit'];
////
////            $arrClms = array('BalancedRewardPoints' => $points);
////            $varWhr = "pkCustomerID='" . $cid . "'";
////            $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
//        }
//        return true;
//    }

    /**
     * function updateCustomerSubscribe
     *
     * This function is used to update customer subscription.
     *
     * Database Tables used in this function are :  tbl_customer
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return boolean
     */
    function updateCustomerSubscribe($cid = 0, $isSub = 1) {
        //global $objCore;

        if ($cid > 0) {
            $arrClms = array('IsSubscribe' => $isSub);
            $varWhr = "pkCustomerID ='" . $cid . "'";
            $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
        }
        return true;
    }

    /**
     * function createReferalId
     *
     * This function is used to create customer referal id.
     *
     * Database Tables used in this function are :  tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return  boolean
     */
    function createReferalId($cid = 0) {
        if ($cid > 0) {
            $refID = 1000000 + $cid;

            $arrClms = array('ReferalID' => $refID);
            $varWhr = "pkCustomerID ='" . $cid . "'";
            $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
        }
        return true;
    }

    /**
     * function getRewardAndValues
     *
     * This function is used to get reward points and price value.
     *
     * Database Tables used in this function are :  tbl_customer
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return boolean
     */
    function getRewardAndValues($cid = 0, $points = 0) {
        //global $objCore;
        $arrSett = $this->getSetting();

        $arrRes['RewardStatus'] = $arrSett['RewardStatus']['SettingValue'];



        $arrRes['RewardPointsBalance'] = 0;

        if ($cid > 0) {
            $arrClms = array('BalancedRewardPoints');
            $varWhr = "pkCustomerID ='" . $cid . "'";
            $arrRow = $this->select(TABLE_CUSTOMER, $arrClms, $varWhr);
            $points = $arrRow[0]['BalancedRewardPoints'];
        }

        $arrRes['RewardPoints'] = $points;
        $arrRes['RewardCanRedeem'] = ($points >= $arrSett['RewardMinimumPointToBuy']['SettingValue']) ? 1 : 0;

        $arrRes['RewardValue'] = $arrSett['RewardPointValue']['SettingValue'] * $arrRes['RewardPoints'];
        $arrRes['RewardPointsBalance'] = $points;

        return $arrRes;
    }

    /**
     * function getRemovedAppliedPoints
     *
     * This function is used to get reward points and price value.
     *
     * Database Tables used in this function are :  none
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return boolean
     */
    function getRemovedAppliedPoints($arrReward) {
        $arrReward['RewardPointsBalance'] = $arrReward['RewardPoints'];
        $arrReward['RewardPoints'] = 0;
        $arrReward['RewardValue'] = 0;

        return $arrReward;
    }

    /**
     * function getAppliedPoints
     *
     * This function is used to get reward points and price value.
     *
     * Database Tables used in this function are :  tbl_customer
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return boolean
     */
    function getAppliedPoints($arrReward, $CartTotalPrice, $product_array = null) {
        //global $objCore;
        //echo '<pre>';
        //print_r($arrReward);
        // print_r($product_array);
        //pre($CartTotalPrice);
        //
        //calculate Total item No. per including quantity
        $arrResForRegard['TotalItemCount'] = 0;
        $CountNoOfItem = count($product_array['arrCartDetails']['Product']);
        foreach ($product_array['arrCartDetails']['Product'] as $key => $value) {
            $arrResForRegard['TotalItemCount'] += $value['qty'];
        }
        foreach ($product_array['arrCartDetails']['Product'] as $key => $value) {
            $arrResForRegard['arrayOfPrice'][] = $value['FinalPrice'];
        }
//        $CountNoOfItem = 1;
        $MinPriceItem = min($arrResForRegard['arrayOfPrice']);
        if ($CartTotalPrice > 0) {
            //if there is one product in cart then use Reward Points
            if ($CountNoOfItem == 1) {
//                echo '<pre>';
//        print_r($arrReward);
//         print_r($product_array);
//        pre($CartTotalPrice);
                //	$CartTotalPrice=10;
                //	$arrReward['RewardValue']=40;

                if ($CartTotalPrice < $arrReward['RewardValue']) {
                    $remPrice = $arrReward['RewardValue'] - $CartTotalPrice;
                    $remPoints = $remPrice / ($arrReward['RewardValue'] / $arrReward['RewardPoints']);
                    //pre($remPoints);
                    $arrReward['RewardPointsBalance'] = (int) $remPoints;
                    $arrReward['singleDeductionAmount'] = $CartTotalPrice;
                    $arrReward['RewardValue'] = $CartTotalPrice;
                    $arrReward['RewardPoints'] = $arrReward['RewardPoints'] - $arrReward['RewardPointsBalance'];
                } else {
                    //print_r($arrReward['RewardPointsBalance']);
                    //pre($arrReward['RewardPoints']);
                    // $arrReward['RewardPointsBalance'] = $arrReward['RewardPoints'];
                    $arrReward['RewardPointsBalance'] = $arrReward['RewardPointsBalance'] - $arrReward['RewardPoints'];
                    $arrReward['singleDeductionAmount'] = $arrReward['RewardValue'];
                    //$arrReward['RewardPoints'] = 0;
                    //$arrReward['RewardValue'] = 0;
                }
//                pre($arrReward);
            } else if ($arrReward['RewardValue'] > $CartTotalPrice) {
                //pre($CartTotalPrice);
                //If there are more than one product in cart, then follow these steps
                //Compare the Total Cart Value with Reward Value 
                //If Reward Value is greater than Total Cart Value, 
                //then subtract Total Cart value from Reward value or vice versa.
                $remPrice = $arrReward['RewardValue'] - $CartTotalPrice;

                //Compare the Remainder with the Min Product price
                if ($remPrice < $MinPriceItem) {
                    //If Remainder is less than Price, then divide it by 2.
                    $singleDeductionAmount = $remPrice / 2;
                } else {
                    //If the Min Price is greater than Remainder, then Divide min price by 2. 
                    $singleDeductionAmount = $MinPriceItem / 2;
                }

                //price - (FinalDiscountPrice * Total Item)
                $totalDiductionAmount = $singleDeductionAmount * $arrResForRegard['TotalItemCount'];
                $priceAfterDiduction = $arrReward['RewardValue'] - $totalDiductionAmount;
                //pre($priceAfterDiduction);
                $remPoints = $priceAfterDiduction / ($arrReward['RewardValue'] / $arrReward['RewardPoints']);
                $arrReward['RewardPointsBalance'] = (int) $remPoints;
//                pre($totalDiductionAmount);
                $arrReward['RewardValue'] = $totalDiductionAmount;
                $arrReward['singleDeductionAmount'] = $singleDeductionAmount;
//                pre($arrReward['RewardPoints']);
//                pre($arrReward['RewardPointsBalance']);
                $arrReward['RewardPoints'] = $arrReward['RewardPoints'] - $arrReward['RewardPointsBalance'];
                //$arrReward['RewardPointsBalance']=$arrReward['RewardPointsBalance']-$arrReward['RewardPoints'];
                //pre($arrReward);
            } else {
                //($arrReward['RewardValue'] < $CartTotalPrice)
                //If there are more than one product in cart, then follow these steps
                //Compare the Total Cart Value with Reward Value 
                //If Reward Value is greater than Total Cart Value, 
                //then subtract Total Cart value from Reward value or vice versa.
                $remPrice = $CartTotalPrice - $arrReward['RewardValue'];
                $remPrice = ($remPrice == 0) ? $CartTotalPrice : $remPrice;
                //Compare the Remainder with the Min Product price
                if ($remPrice < $MinPriceItem) {
                    //If Remainder is less than Price, then divide it by 2.
                    $singleDeductionAmount = $remPrice / 2;
                } else {
                    //If the Min Price is greater than Remainder, then Divide min price by 2. 
                    $singleDeductionAmount = $MinPriceItem / 2;
                }
//                pre($arrReward['RewardValue']);
                //price - (FinalDiscountPrice * Total Item)
                $totalDiductionAmount = $singleDeductionAmount * $arrResForRegard['TotalItemCount'];
                $priceAfterDiduction = $arrReward['RewardValue'] - $totalDiductionAmount;
                $remPoints = $priceAfterDiduction / ($arrReward['RewardValue'] / $arrReward['RewardPoints']);
                $arrReward['RewardPointsBalance'] = (int) $remPoints;
//                pre($totalDiductionAmount);
                $arrReward['RewardValue'] = $totalDiductionAmount;
                $arrReward['singleDeductionAmount'] = $singleDeductionAmount;
//                pre($arrReward['RewardPoints']);
//                pre($arrReward['RewardPointsBalance']);
                $arrReward['RewardPoints'] = $arrReward['RewardPoints'] - $arrReward['RewardPointsBalance'];
                //pre($arrReward);
            }
        } else {
            $arrReward['RewardPointsBalance'] = $arrReward['RewardPoints'];
            $arrReward['singleDeductionAmount'] = 0;
            $arrReward['RewardPoints'] = 0;
            $arrReward['RewardValue'] = 0;
        }
        // pre($arrReward);
        return $arrReward;
    }

    /**
     * function sendSupportEmail
     *
     * This function is used to get reward points and price value.
     *
     * Database Tables used in this function are :  tbl_support
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return boolean
     */
    function sendSupportEmail($supportID) {

        global $objCore;

        $varQuery = "SELECT pkSupportID,fkParentID,FromUserType,fkFromUserID,ToUserType,fkToUserID,SupportType,Subject,Message FROM " . TABLE_SUPPORT . " WHERE pkSupportID='" . $supportID . "'";
        $arrRes = $this->getArrayResult($varQuery);
        $arrSupport = $arrRes[0];
        $arrFrom = $this->getFromSupportDetails($arrSupport['FromUserType'], $arrSupport['fkFromUserID']);
        $arrTo = $this->getToSupportDetails($arrSupport['ToUserType'], $arrSupport['fkToUserID']);

        $varName = $arrTo['name'];
        $varEmail = $arrTo['email'];
        $varFrom = SITE_NAME;
        $varSubject = SUPPORT_EMAIL_SUBJECT . ':' . $arrSupport['SupportType'];
        $varEmailMessage = '';

        $varEmailMessage .= '<table width="94%" align="center" border="0" cellpadding="8" cellspacing="0"><tr><td>Dear ' . $varName . ',</td></tr><tr><td>You have received a support email from ' . ucwords($arrSupport['FromUserType']) . '.</td></tr></table><table width="94%" align="center" border="1" cellpadding="8" cellspacing="0"><tr><th colspan="2">' . $varSubject . '</th></tr><tr><th>From</th><td><b>' . $arrSupport['FromUserType'] . ': </b>' . $arrFrom['name'] . ' (' . $arrFrom['email'] . ')</td></tr><tr><th>Support&nbsp;Type</th><td>' . $arrSupport['SupportType'] . '</td></tr><tr><th>Subject</th><td>' . $arrSupport['Subject'] . '</td></tr><tr><th>Message</th><td>' . $arrSupport['Message'] . '</td></tr></table>';

        //pre($varEmailMessage);
        $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
    }

    /**
     * function getFromSupportdetails
     *
     * This function is used to get reward points and price value.
     *
     * Database Tables used in this function are :  tbl_support
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return boolean
     */
    function getFromSupportDetails($FromUserType, $fkFromUserID) {

        $case = $FromUserType;
        $arrRes[0] = array();
        switch ($case) {

            case 'customer':
                $arrRes = $this->select(TABLE_CUSTOMER, array('CustomerFirstName as name', 'CustomerEmail as email'), "pkCustomerID='" . $fkFromUserID . "'");
                break;
            case 'wholesaler':
                $arrRes = $this->select(TABLE_WHOLESALER, array('CompanyName as name', 'CompanyEmail as email'), "pkWholesalerID='" . $fkFromUserID . "'");
                break;
            case 'admin':
                $arrRes = $this->select(TABLE_ADMIN, array('AdminTitle as name', 'AdminEmail as email'), "pkAdminID='" . $fkFromUserID . "'");
                break;
        }
        return $arrRes[0];
    }

    /**
     * function getToSupportDetails
     *
     * This function is used to get reward points and price value.
     *
     * Database Tables used in this function are :  tbl_support
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return boolean
     */
    function getToSupportDetails($ToUserType, $fkToUserID) {

        $case = $ToUserType;
        $arrRes[0] = array();
        switch ($case) {

            case 'customer':
                $arrRes = $this->select(TABLE_CUSTOMER, array('CustomerFirstName as name', 'CustomerEmail as email'), "pkCustomerID='" . $fkToUserID . "'");
                break;
            case 'wholesaler':
                $arrRes = $this->select(TABLE_WHOLESALER, array('CompanyName as name', 'CompanyEmail as email'), "pkWholesalerID='" . $fkToUserID . "'");
                break;
            case 'admin':
                $arrRes = $this->select(TABLE_ADMIN, array('AdminTitle as name', 'AdminEmail as email'), "pkAdminID='" . $fkToUserID . "'");
                break;
        }
        return $arrRes[0];
    }

}

?>
