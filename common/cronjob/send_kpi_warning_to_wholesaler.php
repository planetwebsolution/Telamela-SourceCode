<?php

require_once '../config/config.inc.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_wholesaler_bll.php';

/**
 * Site SendKPIWarningToWholesaler Class
 *
 * This class will used to send auto warning emails to wholesaler.
 *
 * DateCreated 1th August, 2013
 *
 * DateLastModified 10 Oct, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class SendKPIWarningToWholesaler extends Database
{

    public function __construct()
    {
        $this->run();
    }

    /**
     * function run
     *
     * This function is used to check kpi and send warning to wholesaler.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 0
     *
     * @return string : none
     */
    function run()
    {

        $objWholesaler = new Wholesaler();

        $this->varLimit = "";

        $varWhrClause = " WholesalerStatus IN ('active') ";

        $arrRes = $objWholesaler->WholesalerList($varWhrClause, $this->varLimit);


        foreach ($arrRes as $value)
        {

            if ($value['warning'] < 2)
            {
                if ($value['kpi'] < PERCENTAGE_WARNING2)
                {
                    $this->sendWarnigEmail($value);
                }
                else if ($value['kpi'] < PERCENTAGE_WARNING1)
                {
                    $this->sendWarnigEmail($value);
                }
            }
        }
        //pre($arrRes);
    }

    /**
     * function sendWarnigEmail
     *
     * This function is used to send auto warning email.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string : none
     */
    function sendWarnigEmail($arrWh)
    {
        global $objGeneral;
        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $varToUser = trim($arrWh['CompanyEmail']);

        $varFromUser = SITE_NAME;

        // $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'SendWarningToWholesalerByAdmin' AND EmailTemplateStatus = 'Active'";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
        //$varWarning = 'This is auto generated warning message. ';
        $varWarning = 'Auto generated Warning';

        $varSendDate = $objCore->serverDateTime(date('d-m-Y'), DATE_FORMAT_SITE);

        $varKeyword = array('{IMAGE_PATH}', '{SENDDATE}', '{WHOLESALER}', '{SITE_NAME}');

        $varKeywordValues = array($varPathImage, $varSendDate, $arrWh['CompanyName'], SITE_NAME);

//        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));
//
//        $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{MESSAGE}', '{SITE_NAME}');
//        $varKeywordValues = array($varPathImage, $varToUser, $varWarning, SITE_NAME);
        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

        $arrClms = array(
            'fkWholesalerID' => $arrWh['pkWholesalerID'],
            'WarningText' => $varWarning,
            'WarningMsg' => $varOutPutValues,
            'WarningDateAdded' => date(DATE_TIME_FORMAT_DB)
        );
         $this->addWarning($arrClms);
        // Calling mail function
        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);

        $arrAdmin = $objGeneral->getWholesalerAdmin($arrWh['pkWholesalerID']);


        foreach ($arrAdmin as $v)
        {
            $varSubject = 'Wholesaler Performance(Kpi)';
            $varWarning = 'Hi  '.$v['AdminUserName'].',<br/>There are some performance(Kpi) issue with the wholesaler <br/><br/>Name:' . $arrWh['CompanyName'] . '<br/> Email:' . $arrWh['CompanyEmail'] . '<br/><br/>
                Please review to wholesaler.';
//            $varKeywordValues = array($varPathImage, $varToUser, $varWarning, SITE_NAME);
//            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
            $objCore->sendMail($v['AdminEmail'], $varFromUser, $varSubject, $varWarning);
        }
    }

    /**
     * function addWarning
     *
     * This function is used to add warning text.
     *
     * Database Tables used in this function are : TABLE_WHOLESALER_WARNING 
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string : string
     */
    function addWarning($arrClms)
    {
        $arrAddID = $this->insert(TABLE_WHOLESALER_WARNING, $arrClms);
        return $arrAddID;
    }

}

$objPage = new SendKPIWarningToWholesaler();
//$objPage->run();
?>