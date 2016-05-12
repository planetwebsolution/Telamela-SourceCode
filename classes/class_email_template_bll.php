<?php

/**
*
* Module name : EmailTemplate
*
* Parent module : None
*
* Date created : 17th January 2013
*
* Date last modified : 17th January 2013
*
* Author : Vivek Avasthi
*
* Last modified by : Vivek Avasthi
*
* Comments : The EmailTemplate class is used to maintain email templates
*
*/ 	

class EmailTemplate extends Database

{

   	/**
	*
	* Function name : EmailTemplate
	*
	* Return type : none
	*
	* Date created : 17th January 2013
	*
	* Date last modified : 17th January 2013
	*
	* Author : Vivek Avasthi
	*
	* Last modified by : Vivek Avasthi
	*
	* Comments : Constructor of EmailTemplate class. It is automatically call when object is created.
	*
	* User instruction : $objEmailTemplate = new EmailTemplate();
	*
	*/

	function EmailTemplate()

	{

	   //default constructor		 

	} 

	

	/**
	*
	* Function Name : getTemplateInfo
	*
	* Return type : array
	*
	* Date created : 17th January 2013
	*
	* Date last modified : 17th January 2013
	*
	* Author : Vivek Avasthi
	*
	* Last modified by : Vivek Avasthi
	*
	* Comments : This is used to return mail template information.
	*
	* User instruction : objEmailTemplate->getTemplateInfo($argWhere)
	*
	*/ 

	function getTemplateInfo($argWhere) 

	{

		$arrClms = array('pkEmailTemplateID', 'EmailTemplateTitle', 'EmailTemplateSubject', 'EmailTemplateDescription', 'EmailTemplateStatus', 'EmailTemplateDateAdded', 'EmailTemplateDateModified');

		$varWhere = $argWhere;

		$arrResults = $this->select(TABLE_EMAIL_TEMPLATES, $arrClms, $varWhere);

		return $arrResults;

	}
     /**
     * function sendContactUsQuery
     *
     * This function is used to send contact us query.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 1 string optional
     *
     * @return string messages
     */
	function sendContactUsQuery($argArrPost)
	{
		$objValid = new Validate_fields;	
		$objCore = new Core();
		$objValid->check_4html = true;
		
		$objValid->add_text_field('Name', strip_tags($argArrPost['frmName']), 'text', 'y');
		$objValid->add_text_field('Email', strip_tags($argArrPost['frmEmail']), 'email', 'y');

		if($objValid->validation()) 
		{
			$errorMsgFirst = 'Please enter required fields!'; 
		} 
		else 
		{
			 $errorMsg = $objValid->create_msg();
		}
		if($errorMsg) 
		{ 
			$_SESSION['arrContactUs']= $argArrPost;
			$objCore->setErrorMsg($errorMsg);	
			return false;
		}
		else
		{
		
			$argWhereEmail = " EmailTemplateTitle ='Contact Us'";
			$varImagePath = '<img src="'.SITE_ROOT_URL.'common/images/logo.png'.'"/>';					
			$varFromUser 		= 	SITE_NAME.'<'.SITE_EMAIL_ADDRESS.'>';						
			$varSubject 		= 'Venueset:: Query/Comments ';
			$displayTitle = 'Venueset:: Query/Comments ';
			
			$varOutput = file_get_contents(SITE_ROOT_URL.'common/email_template/html/front_end_contact_us_letter.html');
					
			$arrEmailConstants = array('{NAME}','{EMAIL}','{PHONE}','{TITLE}','{CONTENT}','{IMAGE_PATH}','{SITE_NAME}');
			$arrReplaces = array($argArrPost['frmName'],$argArrPost['frmEmail'],$argArrPost['frmPhone'],$displayTitle,$arrPostData['frmcomments'],$varImagePath,SITE_NAME);
			$emailContent = str_replace($arrEmailConstants, $arrReplaces,$varOutput);
			
			if($objCore->sendMail(SITE_EMAIL_ADDRESS, $argArrPost['frmEmail'], $varSubject, $emailContent))
			{
			  $objCore->setSuccessMsg(CONTACT_US_QUERY_SEND_SUCCESS);
			  return true;
			}
			else
			{
			$_SESSION['arrContactUs']= $argArrPost;
			$objCore->setErrorMsg(CONTACT_US_QUERY_SEND_FAIL);
			return false;
			}
		
		}
		
	}

}// end of class


?>
