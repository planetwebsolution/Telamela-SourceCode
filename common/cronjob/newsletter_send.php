<?php

//include '../config/config.inc.php';
require_once(dirname(dirname(__FILE__)).'/config/config.inc.php'); 
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_newsletter_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;


class Newsletter_mail extends Database {
    /*     * ****************************************
      Function name : runCron
      Comments : This function call the cron functions one by one.
      User instruction : $res = $objClass->runCron();
     * **************************************** */

    function runNewsletter() {
        $this->runNewsletterCron();
    }

    /*     * ****************************************
      Function name : runrunNewsletterCron
      Comments : This function send newsletter to customer & wholesaler.
      User instruction : $res = $objClass->runNewsletterCron();
     * **************************************** */

    function runNewsletterCron() {
    	//mysql_query('insert into abc (`name`) values (NOW())');
        $objNewsLetter = new NewsLetter();
        
        $objTemplate = new EmailTemplate();
       
        $objCore = new Core();
//         $this->varLimit = "0" . "," . NEWSLETTER_SEND_LIMIT;

        $this->varLimit = "0" . "," . 80;
        $this->arrNewsletter = $objNewsLetter->newsLetterSendList($varWhr, $this->varLimit);
        //echo '<pre>'; print_r ($this->arrNewsletter); die;

        foreach ($this->arrNewsletter AS $valNewsletter) {
        	
        	
        	if ($valNewsletter['NewsLetterType'] == 'ContentAndTemplate') {
        		$content = $valNewsletter['Content'];
        		$content .= '<img src="' . $objCore->getImageUrl($valNewsletter['Template'], 'newsletter') . '" />';
        	}
        	
            elseif ($valNewsletter['NewsLetterType'] == 'template') {
                $content = '<img src="' . $objCore->getImageUrl($valNewsletter['Template'], 'newsletter') . '" />';
            } else {
                $content = $valNewsletter['Content'];
            } 
           
            $title = $valNewsletter['Title'];
         
            $this->arrRows = $objNewsLetter->getNewsletterRecipientList($valNewsletter['pkNewsLetterID']);
           
            foreach ($this->arrRows as $k => $arrRow) {
            
                if ($arrRow['SendTo'] == "customer") {
                
                    $varToUser = $arrRow['CustomerEmail'];
                    $varUserName = trim(strip_tags($arrRow['CustomerFirstName']));
                } else if ($arrRow['SendTo'] == "wholesaler") {
                	
                    $varToUser = $arrRow['CompanyEmail'];
                    $varUserName = trim(strip_tags($arrRow['CompanyName']));
                }
                
                if($arrRow['CompanyEmail']=='')
                {
                	//continue;
                }

                $fromUserName = SITE_NAME;
                $varSiteName = SITE_NAME;
                $varWhereTemplate = " EmailTemplateTitle= 'SendNewsletterEmail' AND EmailTemplateStatus = 'Active' ";
                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" />';
                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));
                $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{USERNAME}','{TITLE}', '{MESSAGE}');

                $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName,$title, html_entity_decode($content));

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);
               

              $s=$objCore->sendMail($varToUser, $fromUserName, $varSubject, $varOutPutValues);
             
             
                
                $objNewsLetter->updateLetterSendList($valNewsletter['pkNewsLetterID']);
                $objNewsLetter->updateNewsletterRecipientList($valNewsletter['pkNewsLetterID']);

            }
        }

    }

}

$objNewsletter = new Newsletter_mail();
$objNewsletter->runNewsletter();
?>