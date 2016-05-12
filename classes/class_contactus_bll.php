<?php

require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;

/**
 * Class name : ContactUs
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The ContactUs class is used to maintain ContactUs infomation details to user for several modules.
 */
class ContactUs extends Database {

    /**
     * function __construct
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function __construct() {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function supportList
     *
     * This function is used to update the supportList deatails.
     *
     * Database Tables used in this function are : tbl_support_ticket_type
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string Array
     *
     * User instruction: $objUsers->supportList()
     */
    function supportList() {
        $arrClms = array(
            'pkTicketID',
            'TicketTitle',
        );
        $arrRes = $this->select(TABLE_SUPPORT_TICKET_TYPE, $arrClms);
        
        
        
        
        $arrClms = array(
            'pkProductID','wholesalePrice'
        );
        $whrCond = " DiscountFinalPrice like '%220.50%'";
        $arrRes2 = $this->select(TABLE_PRODUCT, $arrClms, $whrCond);
        foreach($arrRes2 as $product){
            $price=$product['wholesalerPrice']-10;
            $whrCond = " pkProductID=".$product['pkProductID'];
            $arrClms=array('DiscountPrice'=>$price,'DiscountFinalPrice'=>($price*1.05));
            $arrRes2 = $this->update(TABLE_PRODUCT, $arrClms, $whrCond); 
        }
        
        
        
        
        
        return $arrRes;
    }

    /**
     * function sendContactUs
     *
     * This function is used to update the sendContactUs deatails.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string Array
     *
     * User instruction: $objContactUs->sendContactUs()
     */
    function sendContactUs($arrPost) {
        //pre($arrPost);
        $objComman = new ClassCommon();
        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $arrSuperAdmin = $objComman->getSuperAdminDetails();
        $varToUser = $arrSuperAdmin[0]['AdminEmail'];
        //$varToUser = "deepak.kumar1@mail.vinove.com";

        $arrSubjectDetails = $objComman->getTicketTitle($arrPost['frmContactUsSubject']);
        $valSubject = $arrSubjectDetails[0]['TicketTitle'];

        $varUserName = trim(strip_tags($arrPost['frmContactUsEmailId']));

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'Contact Us Email By Customer' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varMessage = "<strong>" . NAME . ":</strong> " . $arrPost['frmContactUsName'] . "<br/>";
        $varMessage .= "<strong>" . EMAIL_ADDRESS . ":</strong> " . $arrPost['frmContactUsEmailId'] . "<br/>";
        $varMessage .= "<strong>" . MOBILE_NUMBER . ":</strong> " . $arrPost['frmContactUsMobile'] . "<br/>";
        $varMessage .= "<strong>" . SUBJECT . ":</strong> " . $valSubject . "<br/>";
        $varMessage .= "<strong>" . MESSAGE . ":</strong> " . $arrPost['frmContactUsMessage'] . "<br/>";

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        //$varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{USER_NAME}', '{MESSAGE}');

        $varKeywordValues = array($varPathImage, SITE_NAME, $varUserName, $varMessage);
        //pre($varKeywordValues);
        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

        // Calling mail function


        $objCore->sendMail($varToUser, $varUserName, $varSubject, $varOutPutValues);
        //return $arrAddID;
    }

    /**
     * function submitEnquiryToDatabase
     *
     * This function is used to update the submitEnquiryToDatabase deatails.
     *
     * Database Tables used in this function are : tbl_enquiry
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string Array
     *
     * User instruction: $objContactUs->submitEnquiryToDatabase($arrPost)
     */
    function submitEnquiryToDatabase($arrPost) {
        $objComman = new ClassCommon();
        $arrSubjectDetails = $objComman->getTicketTitle($arrPost['frmContactUsSubject']);
        $valSubject = $arrSubjectDetails[0]['TicketTitle'];

        $arrClms = array(
            'EnquirySenderName' => $arrPost['frmContactUsName'],
            'EnquirySenderEmail' => $arrPost['frmContactUsEmailId'],
            'EnquirySenderMobile' => $arrPost['frmContactUsMobile'],
            'EnquirySubject' => $valSubject,
            'EnquiryComment' => $arrPost['frmContactUsMessage'],
            'EnquiryDateAdded' => date(DATE_TIME_FORMAT_DB)
        );

        $arrAddID = $this->insert(TABLE_ENQUIRY, $arrClms);
    }

    /**
     * function supportList
     *
     * This function is used to update the supportList deatails.
     *
     * Database Tables used in this function are : tbl_email_templates
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string Array
     *
     * User instruction: $objUsers->supportList()
     */
    function getEmailTempletList() {
        $arrClms = array(
            'pkEmailTemplateID',
            'EmailTemplateTitle',
            'EmailTemplateDisplayTitle',
            'EmailTemplateSubject',
            'EmailTemplateDescription',
            'EmailTemplateStatus',
            'EmailTemplateDateAdded',
            'EmailTemplateDateModified'
        );
        $arrRes = $this->select(TABLE_EMAIL_TEMPLATES, $arrClms);

        return $arrRes;
    }

}

?>