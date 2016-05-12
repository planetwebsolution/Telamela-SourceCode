<?php
    require_once '../config/config.inc.php';
    require_once CLASSES_PATH . 'class_email_template_bll.php';
    require_once CONTROLLERS_PATH.FILENAME_COMMON_CTRL;
    class CronJob extends Database {
        
        /******************************************
        Function name : runCron
        Comments : This function call the cron functions one by one.
        User instruction : $res = $objClass->runCron();
        ******************************************/
        function runCron()
        {
            $this->runUploadedWholesalerCron();
            $this->runUploadedCustomerCron();
        }
        
        /******************************************
        Function name : runUploadedWholesalerCron
        Comments : This function send the username and password to newly uploaded wholesaler.
        User instruction : $res = $objClass->runUploadedWholesalerCron();
        ******************************************/
        function runUploadedWholesalerCron()
        {
            $arrClms = array('pkWholesalerID','CompanyName','CompanyEmail');
            $varId = "WholesalerStatus = 'active' AND CompanyPassword=''";
            $varTable = TABLE_WHOLESALER;
            $arrRes = $this->select($varTable, $arrClms, $varId);
            
            foreach($arrRes AS $wholesaler)
            {
                $nonMD5password = substr(str_shuffle(str_replace(".",'s',$wholesaler['pkWholesalerID'].$wholesaler['CompanyEmail'].rand(1000,9999))),0,8);
                $password = md5($nonMD5password);
                $arrClms = array('CompanyPassword' => $password);
                $varId = "pkWholesalerID = '".$wholesaler['pkWholesalerID']."'";
                $varTable = TABLE_WHOLESALER;
                $this->update($varTable, $arrClms, $varId);
                $objComman = new ClassCommon();
                $objTemplate = new EmailTemplate();
                $objCore = new Core();
                
                $varToUser = $wholesaler['CompanyEmail'];
                $varUserName = trim(strip_tags($wholesaler['CompanyName']));
                $varSiteName = SITE_NAME;
                $varWhereTemplate = " EmailTemplateTitle= 'WholeSalerAddedByAdmin' AND EmailTemplateStatus = 'Active' ";
                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));
                $varPathImage = '<img src="'.SITE_ROOT_URL.'common/images/logo.png" >';
                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));
                $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{USER_NAME}','{PASSWORD}','{WHOLESALER}');

                $varKeywordValues = array($varPathImage, SITE_NAME, $varToUser, $nonMD5password,$varUserName);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function
                

                $objCore->sendMail($varToUser, $varUserName, $varSubject, $varOutPutValues);
                //return $arrAddID;
            }
        }
        
        
        /******************************************
        Function name : runUploadedCustomerCron
        Comments : This function send the username and password to newly uploaded Customers.
        User instruction : $res = $objClass->runUploadedCustomerCron();
        ******************************************/
        function runUploadedCustomerCron()
        {
            $arrClms = array('pkCustomerID','CustomerFirstName','CustomerEmail');
            $varId = " CustomerStatus = 'active' AND CustomerPassword='' ";
            $varTable = TABLE_CUSTOMER;
            $arrRes = $this->select($varTable, $arrClms, $varId);
            foreach($arrRes AS $customer)
            {
                $nonMD5password = substr(str_shuffle(str_replace(".",'s',$customer['pkCustomerID'].$customer['CustomerEmail'].rand(1000,9999))),0,8);
                $password = md5($nonMD5password);
                $arrClms = array('CustomerPassword' => $password);
                $varId = "pkCustomerID = '".$customer['pkCustomerID']."'";
                $varTable = TABLE_CUSTOMER;
                $this->update($varTable, $arrClms, $varId);
                $objComman = new ClassCommon();
                $objTemplate = new EmailTemplate();
                $objCore = new Core();
                
                $varToUser = $customer['CustomerEmail'];
                $varUserName = trim(strip_tags($customer['CustomerFirstName']));
                $varSiteName = SITE_NAME;
                $varWhereTemplate = " EmailTemplateTitle= 'CustomerAddedByAdmin' AND EmailTemplateStatus = 'Active' ";
                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));
                $varPathImage = '<img src="'.SITE_ROOT_URL.'common/images/logo.png" >';
                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));
                $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{USER_NAME}','{PASSWORD}','{CUSTOMER_NAME}');

                $varKeywordValues = array($varPathImage, SITE_NAME, $varToUser, $nonMD5password,$varUserName);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function
                

                $objCore->sendMail($varToUser, $varUserName, $varSubject, $varOutPutValues);
                //return $arrAddID;
            }
        }
    }
    
    $objCron = new CronJob();    
    $objCron->runCron();
?>