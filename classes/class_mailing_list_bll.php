<?php
/**
 * MailingList class 
 *
 * The Common class contains all the functions that are commonly used in different mails.
 *
 * @DateCreated 23th March 2013
 * 
 * @DateLastModified  07 May, 2013
 *
 * @copyright Copyright (C) 2013-2013 Vinove Software and Services
 *
 * @version  1.1
 */
Class MailingList extends Database
{
    	
		function MailingList()
		{
			//default constructor
		}
	/**	
	*
	* Function name:getUsersList
	*
	* Return type: Associated array
	*
	* Date created : 20th April 2013
	*
	* Date last modified : 20th April 2013
	*
	* Author : Deepesh Pathak
	*
	* Last modified by : Deepesh Pathak
	*
	* Comments: show listing of Users 
	*
	* User instruction: $objUsers->getUsersList($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '')
	*
	*/ 
		function getMailingList($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '')
		{
			if(count($argArrRequest) > 0)
			{
				$arrUserFlds = $argArrRequest;
			}
			else
			{
				$arrUserFlds = array();
			}
			//Call getSortColumn function to get column name and sort option $this->orderOptions;
			$this->getSortColumn($_REQUEST);
			
			//Prepare where condition
			$varUserWhere = ' 1 '.$argVarSearchWhere;
			
			$arrUserList = $this->select($argVarTable, $arrUserFlds, $varUserWhere, $this->orderOptions, $argVarEndLimit); 	
			
			//return all record
			return $arrUserList;
		}
	/**	
	*
	* Function name:getSortColumn
	*
	* Return type: String
	*
	* Date created : 20th April 2013
	*
	* Date last modified : 20th April 2013
	*
	* Author : Deepesh Pathak
	*
	* Last modified by : Deepesh Pathak
	*
	* Comments: sort coloum for Users 
	*
	* User instruction: $objUsers->getSortColumn($argVarSortOrder)
	*
	*/ 
		function getSortColumn($argVarSortOrder)
		{
			
			$objCore = new Core();			
			//Default order by setting
			if ($argVarSortOrder['orderBy'] == '')
			{
				 $varOrderBy = 'DESC';
			}
			else 
			{	
				 $varOrderBy = $argVarSortOrder['orderBy'];
			}
			//Default sort by setting
			if ($argVarSortOrder['sortBy'] == '')
			{
				$varSortBy = 'MailingListDateAdded';
			}
			else
			{
				$varSortBy = $argVarSortOrder['sortBy'];
			}
			//Create sort class object
			$objOrder = new CreateOrder($varSortBy, $varOrderBy);
			unset($argVarSortOrder['PHPSESSID']);
			//This function return  query  string. When we will array.
			$varQryStr = $objCore->sortQryStr($argVarSortOrder, $varOrderBy, $varSortBy );
			//print_r($varQryStr);
			//Pass query string in extra function for add in sorting
			$objOrder->extra($varQryStr);
			//Prepage sorting heading
			$objOrder->append(' ');
			$objOrder->addColumn('Email', 'MailingListEmail');
			$objOrder->addColumn('Request Date', 'MailingListDateAdded');
			$objOrder->addColumn('Date Modified', 'MailingListDateUpdated');
			$objOrder->addColumn('Status', 'MailingListStatus');
			$this->orderOptions = $objOrder->orderOptions();
	
			//This string column name with  link.
			$varStrLnkSrtClmn = $objOrder->orderBlock();
			return $varStrLnkSrtClmn;
		}
	/**	
	*
	* Function name:getMailingListString
	*
	* Return type: String
	*
	* Date created : 20th April 2013
	*
	* Date last modified : 20th April 2013
	*
	* Author : Deepesh Pathak
	*
	* Last modified by : Deepesh Pathak
	*
	* Comments: sort coloum for Users 
	*
	* User instruction: $objUsers->getMailingListString($argArrPost)
	*
	*/ 
		function getMailingListString($argArrPost)
		{
			//print_r($argArrPost); die;
			$varSearchWhere = ' ';
			if($argArrPost['frmSearchEmail'] != '')
			{
				$varSearchWhere .= 'AND MailingListEmail LIKE \'%'.trim(addslashes($argArrPost['frmSearchEmail'])).'%\''; 
			}
		
			if($argArrPost['frmSearchRequestStatus'] != '')
			{
				$varSearchWhere .= 'AND MailingListStatus = \''.$argArrPost['frmSearchRequestStatus'].'\''; 
			}
			if($argArrPost['frmDate'] != '' && $argArrPost['frmDate'] != 'From')
			{	
					
				$varFromDate = $argArrPost['frmDate'];
				$varSearchWhere .= ' AND (DATE_FORMAT(MailingListDateAdded, \'%Y-%m-%d\') >= STR_TO_DATE(\''.$varFromDate.'\', \'%Y-%m-%d\')';
				if($argArrPost['frmToDate'] != '' && $argArrPost['frmToDate'] != 'To')
				 {
					$varToDate = $argArrPost['frmToDate'];  
					$varSearchWhere .= ' AND DATE_FORMAT(MailingListDateAdded, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$varToDate.'\',\'%Y-%m-%d\'))';
				 }
				 else
				 {
					$varSearchWhere .= ')';
				 }
			 }
			if($argArrPost['frmDate'] == '' || $argArrPost['frmDate'] == 'From')
			{
				if($argArrPost['frmToDate'] != '' && $argArrPost['frmToDate'] != 'To')
				 {
					$varToDate = $argArrPost['frmToDate'];
					$varSearchWhere .= ' AND DATE_FORMAT(MailingListDateAdded, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$varToDate.'\',\'%Y-%m-%d\')';
				 }
			}
			return $varSearchWhere;
		}
	/**	
	* 	Function name: getUsersInfo
	*
	* 	Return type : Boolean
	*
	* 	Date created : 20th April 2013
	*
	* 	Date last modified : 20th April 2013
	*
	* 	Author : Deepesh Pathak
	*
	* 	Last modified by : Deepesh Pathak
	*
	* 	Comments: general Users function
	*
	* 	User instruction: $objUsers->getUsersInfo$argVarTable, $argArrClm = array(), $argVarWhere = '')
	*
	*/
		function getUserInfo($argVarTable, $argArrClm = array(), $argVarWhere = '')
		{
			if(count($argArrClm) > 0)
			{
				$arrFlds = $argArrClm;
			}
			else
			{
				$arrFlds = array();
			}
			$arrList = $this->select($argVarTable, $arrFlds, $argVarWhere); 	
			return $arrList;
		}
		
		
	/**	
	*
	* Function name: setUserStatus
	*
	* Return type : Boolean
	*
	* Date created : 20th April 2013
	*
	* Date last modified : 20th April 2013
	*
	* Author : Deepesh Pathak
	*
	* Last modified by : Deepesh Pathak
	*
	* Comments: Change User status.
	*
	* User instruction: $objUser->setUserStatus($argArrPOST)	*
	* 
	*/ 	
		function setUserStatus($argArrPOST)
		{ 
		        $objCore = new Core();
				$varMessage='';
			foreach($argArrPOST['frmUsersID'] as $varUsersID)
			{
				/* To get the page status */
				
				//Listing related child category
				$varUsersWhereCon = 'pkMailingList = \''.$varUsersID.'\'';
				$arrUsersClms = array('MailingListStatus' => $argArrPOST['frmChangeAction'],'MailingListDateUpdated' =>'now()');
				$varaffectedRecord = $this->update(TABLE_MAILING_LIST, $arrUsersClms, $varUsersWhereCon);
					
			        
				
			}
			if($argArrPOST['frmChangeAction'] == 'Approve')
			{
				$objCore->setSuccessMsg(ADMIN_MAILING_REQUEST_STATUS_APPROVE_SUCCESS_MSG);
				return true;
			}
			else
			{
				$objCore->setSuccessMsg(ADMIN_MAILING_REQUEST_STATUS_DISAPPROVE_SUCCESS_MSG);
				
				return true;
			}
		}
		
	
	
	
	/**	
	*
	* Function name : removeMailingListRequest
	*
	* Return type : Boolean
	*
	* Date created : 20th April 2013
	*
	* Date last modified : 20th April 2013
	*
	* Author : Deepesh Pathak
	*
	* Last modified by : Deepesh Pathak
	*
	* Comments : Remove Users information.
	*
	* User instruction :  $objUser->removeMailingListRequest($argArrPOST)
	*
	*/
	function removeMailingListRequest($argArrPOST)
	{
		$objCore = new Core();
		$objGeneral = new General();
		$varMessage='';
		foreach($argArrPOST['frmUsersID'] as $varDeleteUsersID)
		{
			
			$varWhereCondition=' pkMailingList = \''.$varDeleteUsersID.'\'';
			
			//Listing related child category
			$this->delete(TABLE_MAILING_LIST, $varWhereCondition);
			
			
		}
		
		$objCore->setSuccessMsg(ADMIN_MAILING_REQUEST_DELETE_SUCCUSS);	
		
		
		return true;
	}
	
	
	
	/**	
	*
	* Function name: addMailingList
	*
	* Return type : Boolean
	*
	* Date created : 13th September 2013
	*
	* Date last modified : 13th September 2013
	*
	* Author : Ghazala Anjum
	*
	* Last modified by : Ghazala Anjum
	*
	* Comments: Add mailing list request.
	*
	* User instruction: $objMailingList->addMailingList($argArrPost)
	*
	*/ 
	function addMailingList($argArrInsertData)
	{	
		$objCore = new Core;
		//$_SESSION['sessArrProducts'] = array();
		//print_r($argArrInsertData);
		//die;
					
		$arrColumnAdd = array(
						'MailingListEmail' => $argArrInsertData['MailingListEmail'],
                                                'FormType' => $argArrInsertData['FormType'],
                                                'MailingListStatus' => 'Disapprove'
						 );
		$varMailingListId=$this->insert(TABLE_MAILING_LIST, $arrColumnAdd);
		
		
		//get admin email
		$varUserWhere = '1';
		$arrAdminDetail = $this->select(TABLE_ADMIN, array('AdminEmail'), $varUserWhere); 	
		
		// Send Mail to admin
						
		$varPath = '<img src="'.SITE_ROOT_URL.'common/images/logo2.png'.'"/>';
		$varFromUser		= $argArrInsertData['MailingListEmail'];
		$varSubject 		= SITE_NAME.':Join Our Mailing List';
		$varOutput 		= file_get_contents(SITE_ROOT_URL.'common/email_template/html/user_request.html');
		
		$varMailContent =NEW_MAILING_LIST;
		
		$arrBodyKeywords 	= array('{USER_EMAIL}','{REQUEST_DATE}','{SITE_NAME}','{IMAGE_PATH}','{MAIL_CONTENT}');
		$arrBodyKeywordsValues  = array($argArrInsertData['MailingListEmail'], date('d-m-Y'), SITE_NAME, $varPath, $varMailContent);
		$varBody 	        = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
		//echo $varToUser;echo $varBody;//die;
		//$objCore->sendMail(ADMIN_CONTACT_EMAIL, $varFromUser, $varSubject, $varBody);
		$objCore->sendMail($arrAdminDetail[0]['AdminEmail'], $varFromUser, $varSubject, $varBody);
		
		$exists=$this->checkUserUnsubscribe($argArrInsertData['MailingListEmail']);
		if($exists==0)
		{
		// Send Mail to user
		$varPath 		= '<img src="'.SITE_ROOT_URL.'common/images/logo2.png'.'"/>';
		$varFromUser 		= SITE_NAME.'<'.SITE_EMAIL_ADDRESS.'>';	
		$varSubject 		= SITE_NAME.':Join Our Mailing List';
		$varOutput 		= file_get_contents(SITE_ROOT_URL.'common/email_template/html/user_mailing_list_request.html');
		$varUnsubscribeLink = 'Click <a href="'.SITE_ROOT_URL.'unsubscribe.php?user='.md5($argArrInsertData['MailingListEmail']).'" target="_blank">here</a> to unsubscribe.';
		$arrBodyKeywords 	= array('{USER_EMAIL}','{REQUEST_DATE}','{SITE_NAME}','{IMAGE_PATH}','{UNSUBSCRIBE_LINK}');
		$arrBodyKeywordsValues  = array($argArrInsertData['MailingListEmail'], date('d-m-Y'), SITE_NAME, $varPath, $varUnsubscribeLink);
		$varBody 	        = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
		//echo $varToUser;//echo $varBody;
		//die;
		$objCore->sendMail($argArrInsertData['MailingListEmail'], $varFromUser, $varSubject, $varBody);
		}
		
		$objCore->setSuccessMsg(FRONT_USER_ADD_SUCCUSS_MSG);
		return true;
			
			
	}
	
	
	
	/**	
	*
	* Function name: sendFreeGiftEmail
	*
	* Return type : Boolean
	*
	* Date created : 20th April 2013
	*
	* Date last modified : 20th April 2013
	*
	* Author : Deepesh Pathak
	*
	* Last modified by : Deepesh Pathak
	*
	* Comments: add Products
	*
	* User instruction: $objProduct->sendFreeGiftEmail($argArrPost)
	*
	*/
	function sendFreeGiftEmail($argEmailID)
	{	
		$objCore = new Core;


                $arrColumnAdd = array(
						'MailingListEmail' => $argEmailID,
                                                'FormType' => 'RedeemGift',
                                                'MailingListStatus' => 'Active'
						 );
		$varMailingListId=$this->insert(TABLE_MAILING_LIST, $arrColumnAdd);


                //get admin email
		$varUserWhere = '1';
		$arrAdminDetail = $this->select(TABLE_ADMIN, array('AdminEmail'), $varUserWhere);
		

		// Send Mail to admin
						
		$varPath = '<img src="'.SITE_ROOT_URL.'common/images/logo2.png'.'"/>';
		$varFromUser		= $argEmailID;
		$varSubject 		= SITE_NAME.':Redeem a free gift';
		$varOutput 		= file_get_contents(SITE_ROOT_URL.'common/email_template/html/user_request.html');
		
		$varMailContent = REQUEST_RECEIVED;
		
		$arrBodyKeywords 	= array('{USER_EMAIL}','{REQUEST_DATE}','{SITE_NAME}','{IMAGE_PATH}','{MAIL_CONTENT}');
		$arrBodyKeywordsValues  = array($argEmailID, date('d-m-Y'), SITE_NAME, $varPath, $varMailContent);
		$varBody 	        = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
		//echo $varToUser;echo $varBody;die;
		$objCore->sendMail($arrAdminDetail[0]['AdminEmail'], $varFromUser, $varSubject, $varBody);


                // Send Mail to user
		
		$exists=$this->checkUserUnsubscribe($argEmailID);
		if($exists==0)
		{
		
		$varPath 		= '<img src="'.SITE_ROOT_URL.'common/images/logo2.png'.'"/>';
		$varFromUser 		= SITE_NAME.'<'.SITE_EMAIL_ADDRESS.'>';
		$varSubject 		= SITE_NAME.':Redeem a free gift';
		$varOutput 		= file_get_contents(SITE_ROOT_URL.'common/email_template/html/user_redeem_free_gift.html');
                $varUnsubscribeLink = 'Click <a href="'.SITE_ROOT_URL.'unsubscribe.php?user='.md5($argEmailID).'" target="_blank">here</a> to unsubscribe.';
                
		$arrBodyKeywords 	= array('{USER_EMAIL}','{REQUEST_DATE}','{SITE_NAME}','{IMAGE_PATH}','{UNSUBSCRIBE_LINK}');
		$arrBodyKeywordsValues  = array($argEmailID, date('d-m-Y'), SITE_NAME, $varPath, $varUnsubscribeLink);
		$varBody 	        = str_replace($arrBodyKeywords, $arrBodyKeywordsValues, $varOutput);
		//echo $varToUser;echo $varBody;die;
		$objCore->sendMail($argEmailID, $varFromUser, $varSubject, $varBody);
		}

		$objCore->setSuccessMsg(FRONT_USER_ADD_SUCCUSS_MSG);
		return true;
			
			
	}
	/**	
	*
	* Function name: checkUserUnsubscribe
	*
	* Return type : integer
	*
	* Date created : 20th April 2013
	*
	* Date last modified : 20th April 2013
	*
	* Author : Deepesh Pathak
	*
	* Last modified by : Deepesh Pathak
	*
	* Comments: add Products
	*
	* User instruction: $objProduct->checkUserUnsubscribe($emailId)
	*
	*/
	function checkUserUnsubscribe($emailId)
	{
	  $arrSelectColumn=array('pkUnsubscribeUserID');
	   $varWhere=" UnsubscribeUserEmail='$emailId'";
	 
	  $arrExistsUser = $this->select(TABLE_UNSUBSCRIBED_USER, $arrSelectColumn, $varWhere);
          $exists=count($arrExistsUser);
	 
	  return $exists;
	}
	
	
}
?>
