<?php

require_once '../config/config.inc.php';
require_once '../../classes/class_email_template_bll.php';

class GiftCardMail extends Database {
    /*     * ****************************************
      Function name : runCron
      Comments : This function call the cron functions one by one.
      User instruction : $res = $objClass->runCron();
     * **************************************** */

    function runGiftCardMail() {
        $this->runGiftCardCron();
    }

    /*     * ****************************************
      Function name : runrunNewsletterCron
      Comments : This function send newsletter to customer & wholesaler.
      User instruction : $res = $objClass->runNewsletterCron();
     * **************************************** */

    function runGiftCardCron() {

        $objTemplate = new EmailTemplate();
        $objCore = new Core();


        global $objGeneral;
        $varWhere = " DeliveryDate = '" . $objCore->serverDateTime(date('Y-m-d'), DATE_FORMAT_DB) . "'";
        $arrCols = array('pkGiftCardID', 'GiftCardCode', 'NameFrom', 'EmailFrom', 'NameTo', 'EmailTo', 'Message', 'TotalAmount', 'BalanceAmount', 'DeliveryDate');
        $varTbl = TABLE_GIFT_CARD . " INNER JOIN " . TABLE_GIFT_CARD_DELIVERY_DATE . " ON pkGiftCardID = fkGiftCardID ";
        $arrDeliveryDates = $this->select($varTbl, $arrCols, $varWhere);
        //pre($arrDeliveryDates);


        $fromUserName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'GiftCardNotification' AND EmailTemplateStatus = 'Active' ";
        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));
        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));


        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
        
        
        
        
        foreach ($arrDeliveryDates as $key => $val) {

            $varSubTo = 'Gift Card notification ';
            $varSubFrom = 'Gift Card notification Email sent to ' . $val['NameTo'];

            $varKeyword = array('{IMAGE_PATH}', '{SUBJECT}', '{CODE}', '{NAMEFROM}', '{NAMETO}', '{MESSAGE}', '{TOTALAMOUNT}', '{BALANCEAMOUNT}', '{SITE_NAME}');

            $varKeywordValues = array($varPathImage, $varSubTo, $val['GiftCardCode'], $val['NameFrom'], $val['NameTo'], $val['Message'], $val['TotalAmount'], $val['BalanceAmount'], SITE_NAME);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

            $varOutPutValuesTo = str_replace($varKeyword, $varKeywordValues, $varOutput);


            $objCore->sendMail($val['EmailTo'], $fromUserName, $varSubject, $varOutPutValues);


            $varKeywordValues = array($varPathImage, $varSubFrom, $val['GiftCardCode'], $val['NameFrom'], $val['NameTo'], $val['Message'], $val['TotalAmount'], $val['BalanceAmount'], SITE_NAME);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

            $varOutPutValuesTo = str_replace($varKeyword, $varKeywordValues, $varOutput);


            $objCore->sendMail($val['EmailFrom'], $fromUserName, $varSubject, $varOutPutValues);
        }
        
        $objCore->sendMail('suraj.maurya@mail.vinove.com','Telamela', 'gift card cron', 'success');
    }

}

$objGiftCard = new GiftCardMail();
$objGiftCard->runGiftCardMail();
?>