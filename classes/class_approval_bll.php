<?php

require_once $arrConfig['sourceRoot'].'classes/class_email_template_bll.php';
Class Approval extends Database
{
    	
		function Approval()
		{
			//default constructor
		}
        
        
        /******************************************
		Function name:getAppovaldata
		Return type: Associated array
		Date created : 8th jan 2013
		Date last modified : 8th jan 2013
		Author : Raju khatak
		Last modified by : Raju khatak
		******************************************/
        function getAppovaldata($tablename="",$columnname="",$wheredata=""){
            
         $arrApprovalCount = $this->select($tablename,$columnname, $wheredata); 	
          return $arrApprovalCount;   
        }
        
        /******************************************
		Function name:getData
		Return type: Associated array
		Date created : 8th jan 2013
		Date last modified : 8th jan 2013
		Author : Raju khatak
		Last modified by : Raju khatak
		******************************************/
        
         function getData($tablename="",$columnname="",$whereData="",$orderData="",$varDataLimit=""){
            
         $arrData = $this->select($tablename,$columnname,$whereData, $orderData,$varDataLimit); 	
          return $arrData;   
        }
        /******************************************
		Function name:getEnquiriesList
		Return type: Associated array
		Date created : 16th Oct 2012
		Date last modified : 16th Oct 2012
		Author : Aditya Pratap Singh
		Last modified by : Aditya Pratap Singh
		Comments: show listing of Enquiries 
		User instruction: $objEnquiriest->getEnquiriesList($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '')
		******************************************/	
		function getApprovalList($argVarTable,$argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '')
		{
			if(count($argArrRequest) > 0) {
				$arrProductFlds = $argArrRequest;
			} else {
				$arrProductFlds = array();
			}
			//Call getSortColumn function to get column name and sort option $this->orderOptions;
			$this->getSortColumn($_REQUEST);
			
			//echo $argVarSearchWhere;die;
			$varProductWhere = ' 1 '.$argVarSearchWhere;
			//echo $argVarEndLimit;
			$arrEnquiriesList = $this->select($argVarTable, $arrProductFlds, $varProductWhere, $this->orderOptions, $argVarEndLimit); 	
			
			//return all record
			return $arrEnquiriesList;
		}
        
        
        /******************************************
		Function name:getLatestEnquirieVenues
		Return type: Associated array
		Date created : 18th Oct 2012
		Date last modified : 18th Oct 2012
		Author : Aditya Pratap Singh
		Last modified by : Aditya Pratap Singh
		Comments: returns listing of venues which are getted latest Enquiries 
		User instruction: $objEnquiriest->getLatestEnquirieVenues($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '')
		******************************************/	
		function getLatestEnquirieVenues($argVarTable, $arrProductFlds, $argVarEndLimit='', $orderOptions, $argVarSearchWhere = '')
		{			
			//Prepare where condition
			$varProductWhere = ' 1 '.$argVarSearchWhere;
            
            $sql = "SELECT DISTINCT $arrProductFlds FROM $argVarTable WHERE $varProductWhere ORDER BY $orderOptions  LIMIT ".$argVarEndLimit;
            
            $arrEnquiriesVenueList = $this->getArrayResult($sql);
			return $arrEnquiriesVenueList;
		}
        
        /******************************************
		Function name:getUnreadEnquiriesByVenue
		Return type: Associated array
		Date created : 18th Oct 2012
		Date last modified : 18th Oct 2012
		Author : Aditya Pratap Singh
		Last modified by : Aditya Pratap Singh
		Comments: returns listing of venues which are not read yet by venue
		User instruction: $objEnquiriest->getUnreadEnquiriesByVenue($argVarTable, $argArrRequest = array(), $argVarEndLimit, $argVarSearchWhere = '')
		******************************************/	
		function getUnreadEnquiriesByVenue($argVarTable, $arrProductFlds, $argVarEndLimit, $orderOptions, $argVarSearchWhere = ' EnquiryViewStatus = 0')
		{			
			//Prepare where condition
			$varProductWhere = ' 1 '.$argVarSearchWhere;
			
			$arrEnquirieList = $this->select($argVarTable, $arrProductFlds, $varProductWhere, $orderOptions, $argVarEndLimit); 	
			
			//return all record
			return $arrEnquirieList;
		}
		
		/******************************************
		Function name:getSortColumn
		Return type: String
		Date created : 17 Oct 2012
		Date last modified : 17 Oct 2012
		Author : Aditya Pratap Singh
		Last modified by : Aditya Pratap Singh
		Comments: sort coloum for Enquiries 
		User instruction: $objEnquiries->getSortColumn($argVarSortOrder)
		******************************************/	
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
				$varSortBy = 'PageDateAdded';
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
            $objOrder->addColumn('PageName', 'PageName');
			$objOrder->addColumn('DateAdded', 'PageDateAdded');
            $objOrder->addColumn('Author', 'AdminUserName');
            $objOrder->addColumn('Reviewer', 'AdminUserName');
            $objOrder->addColumn('Action');
            $this->orderOptions = $objOrder->orderOptions();
	
			//This string column name with  link.
			$varStrLnkSrtClmn = $objOrder->orderBlock();
			return $varStrLnkSrtClmn;
		}
        
		/******************************************
		Function Name: getEnquiriesString
		Return type: String
		Date created : 17 Oct 2012
		Date last modified : 17 Oct 2012
		Author : Aditya Pratap Singh
		Last modified by : Aditya Pratap Singh
		Comments: Generates a querystring for the Enquiries table that will be used in judge search where condition.
		User instruction: $objEnquiries->getEnquiriesString($argArrPost)
		******************************************/
        
		function getEnquiriesString($argArrPost)
		{
			//print_r($argArrPost); die;
			$varSearchWhere = ' ';
			if($argArrPost['frmSearchUserNameResult'] != '')
			{
				$varSearchWhere .= 'AND (UserFirstName LIKE \'%'.trim(addslashes($argArrPost['frmSearchUserNameResult'])).'%\' OR UserLastName LIKE \'%'.trim(addslashes($argArrPost['frmSearchUserNameResult'])).'%\')'; 
			}
		
			if($argArrPost['frmSearchUserEmailResult'] != '')
			{
				$varSearchWhere .= ' AND UserEmail LIKE \'%'.$argArrPost['frmSearchUserEmailResult'].'%\''; 
			}
			
			if($argArrPost['frmDate'] != '' && $argArrPost['frmDate'] != 'From')
			{	
					
				$varFromDate = $argArrPost['frmDate'];
				$varSearchWhere .= ' AND (DATE_FORMAT(EnquiryDateAdded, \'%Y-%m-%d\') >= STR_TO_DATE(\''.$varFromDate.'\', \'%Y-%m-%d\')';
				if($argArrPost['frmToDate'] != '' && $argArrPost['frmToDate'] != 'To')
				 {
					$varToDate = $argArrPost['frmToDate'];  
					$varSearchWhere .= ' AND DATE_FORMAT(EnquiryDateAdded, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$varToDate.'\',\'%Y-%m-%d\'))';
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
					$varSearchWhere .= ' AND DATE_FORMAT(EnquiryDateAdded, \'%Y-%m-%d\') <= STR_TO_DATE(\''.$varToDate.'\',\'%Y-%m-%d\')';
				 }
			}
			return $varSearchWhere;
		}
		
        
        /******************************************
		Function name: deleteEnquirie
		Return type : Boolean
		Date created : 17 Oct 2012
		Date last modified : 17 Oct 2012
		Author : Aditya Pratap Singh
		Last modified by : Aditya Pratap Singh
		Comments: delete Enquiries and save in deleted_Enquiries table
		User instruction: $obj->deleteEnquirie($argArrPost)
		******************************************/
        
		function deleteEnquirie($argArrPost)
		{	
			$objCore = new Core;
			$objCommon = new ClassCommon();

			$varWhereClause = 'pkEnquiryID = "'.$argArrPost['frmEnquirieID'].'"';
            
            
            $checksql = "Select pkEnquiryID from ".TABLE_DELETED_ENQUIRY." where pkEnquiryID = ".$argArrPost['frmEnquirieID'];
            
            $num_rows = mysql_num_rows($this->query($checksql));

            if($num_rows <= 0) {
                $varWhere = 'pkEnquiryID = \''.$argArrPost['frmEnquirieID'].'\'';
            
                $sql = 'INSERT INTO ' . TABLE_DELETED_ENQUIRY . ' SELECT * FROM '. TABLE_ENQUIRY .' WHERE  ' . $varWhere;

                $this->query($sql);
                $responce = mysql_affected_rows();
                $this->delete(TABLE_ENQUIRY, $varWhereClause);

            }else {
                $this->delete(TABLE_ENQUIRY, $varWhereClause);
                $responce = mysql_affected_rows();
            }
            
            if($responce) {
                $objCore->setSuccessMsg(ENQUIRY_REJECTED_SUCCESSFULLY);
                return true;
            } else {
                $objCore->setErrorMsg(ENQUIRY_REJECTION_FAILED);
                return true;
            }
            
			return true;
		}
        
        /******************************************
		Function name: ChangeEnquirieViewStatus
		Return type : Boolean
		Date created : 19 Oct 2012
		Date last modified : 19 Oct 2012
		Author : Aditya Pratap Singh
		Last modified by : Aditya Pratap Singh
		Comments: Change Enquirie View Status status.
		User instruction: $obj->ChangeEnquirieViewStatus($argArrPOST)
		******************************************/		
		function ChangeEnquirieViewStatus($argArrPOST)
		{
			$objCore = new Core();
			$objCommon = new ClassCommon();
			$varID = $argArrPOST['EnqurieID'];
            
            $varWhereCon = 'pkEnquiryID = \''.$varID.'\'';
            $arrClms = array('EnquiryViewStatus' => '1','EnquiryDateUpdated' =>'now()');
            $varaffectedRecord = $this->update(TABLE_ENQUIRY, $arrClms, $varWhereCon);
            return true;
		}
        
        /******************************************
		Function name: ChangeCMSPageStatus
		Return type : Boolean
		Date created : 9 jan 2013
		Date last modified : 9 jan 2013
		Author : Raju khatak
		Last modified by : Raju khatak
		Comments: Change Enquirie View Status status.
		User instruction: $obj->ChangeEnquirieViewStatus($argArrPOST)
		******************************************/		
		function ChangeApproveStatus($argArrPOST)
		{
            $objCore = new Core();
            $objTemplate = new EmailTemplate();
            $varWhereCon = 'PageName='."'$argArrPOST'";
            //echo $varWhereCon;die;
            $arrClms = array('PageStatus' => 'Approve','PageDateModified' =>'now()');
            $varaffectedRecord = $this->update(TABLE_PAGES, $arrClms, $varWhereCon);
            $row =  mysql_affected_rows();
            
            if($row > 0){
            
            $varFrom = TABLE_PAGES." AS TP LEFT JOIN ".TABLE_ADMIN." AS TA ON TP.pkAdminID = TA.pkAdminID";    
            
            $arrColumn = array('pkPageID', 'TP.pkAdminID','PageName','PageTitle', 'PageDisplayTitle', 'PageContent','PageStatus','PageKeywords','PageDescription','PageDateAdded','PageDateModified','TA.pkAdminID','AdminUserName','AdminEmail');    
            
            $getMailData= $this->select($varFrom,$arrColumn,$varWhereCon);
            
            $mailTo =$getMailData[0][AdminEmail];
            
            $from = SITE_NAME.'<'.$varToAdmin.'>';
            
            $varSiteName =SITE_NAME; 
            
            $varWhereTemplate = ' EmailTemplateTitle = binary \'Regarding Reject page\' AND EmailTemplateStatus = \'Active\' ';

            $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
            
            $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

            $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

			$varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{USER_NAME}', '{PASSWORD}');

            $varKeywordValues = array($varPath, $varSiteName, $varAdminUserName, $varAdminUserPass);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

            $varSubject = str_replace('{SITE_NAME}', $varSiteName, $varSubject);
            
           $objCore->sendMail($mailTo, $from, $varSubject, $varOutPutValues);
            
           return true;
            }
            
		}
        /******************************************
		Function name: ChangeReviewStatus
		Return type : Boolean
		Date created : 9 jan 2013
		Date last modified : 9 jan 2013
		Author : Raju khatak
		Last modified by : Raju khatak
		Comments: Change Enquirie View Status status.
		User instruction: $obj->ChangeEnquirieViewStatus($argArrPOST)
		******************************************/		
		function ChangeReviewStatus($argArrPOST)
		{
            
            $varWhereCon = 'PageName='."'$argArrPOST'";
            //echo $varWhereCon;die;
            $arrClms = array('PageStatus' => 'Review','PageDateModified' =>'now()');
            $varaffectedRecord = $this->update(TABLE_PAGES, $arrClms, $varWhereCon);
            return true;
		}
        
        /******************************************
		Function name: ChangePublishStatus
		Return type : Boolean
		Date created : 9 jan 2013
		Date last modified : 9 jan 2013
		Author : Raju khatak
		Last modified by : Raju khatak
		Comments: Change Enquirie View Status status.
		User instruction: $obj->ChangeEnquirieViewStatus($argArrPOST)
		******************************************/		
		function ChangePublishStatus($argArrPOST)
		{
            
            $varWhereCon = 'PageName='."'$argArrPOST'";
            //echo $varWhereCon;die;
            $arrClms = array('PageStatus' => 'Publish','PageDateModified' =>'now()');
            
            $varaffectedRecord = $this->update(TABLE_PAGES, $arrClms, $varWhereCon);
            
            return true;
		}
        
        /******************************************
		Function name: ChangeRejectStatus
		Return type : Boolean
		Date created : 9 jan 2013
		Date last modified : 9 jan 2013
		Author : Raju khatak
		Last modified by : Raju khatak
		Comments: Change Enquirie View Status status.
		User instruction: $obj->ChangeEnquirieViewStatus($argArrPOST)
		******************************************/		
		function ChangeRejectStatus($argArrPOST="",$cont="")
		{
            $objCore = new Core();
            $objTemplate = new EmailTemplate();
            $varWhereCon = 'PageName='."'$argArrPOST'";
            //echo $varWhereCon;die;
            $arrClms = array('PageStatus' => 'Reject','PageDateModified' =>'now()','PageRejectContent'=>$cont);
            
            $varaffectedRecord = $this->update(TABLE_PAGES, $arrClms, $varWhereCon);
            
            $row =  mysql_affected_rows();
            
            if($row > 0){
            
            $varFrom = TABLE_PAGES." AS TP LEFT JOIN ".TABLE_ADMIN." AS TA ON TP.pkAdminID = TA.pkAdminID";    
            
            $arrColumn = array('pkPageID', 'TP.pkAdminID','PageName','PageTitle', 'PageDisplayTitle', 'PageContent','PageStatus','PageKeywords','PageDescription','PageDateAdded','PageDateModified','TA.pkAdminID','AdminUserName','AdminEmail');    
            
            $getMailData= $this->select($varFrom,$arrColumn,$varWhereCon);
            
            $mailTo =$getMailData[0][AdminEmail];
            
            $from = SITE_NAME.'<'.$varToAdmin.'>';
            
            $varSiteName =SITE_NAME; 
            
            $varWhereTemplate = ' EmailTemplateTitle = binary \'Regarding Reject page\' AND EmailTemplateStatus = \'Active\' ';

            $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);
            
            $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

            $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

			$varKeyword = array('{IMAGE_PATH}', '{SITE_NAME}', '{USER_NAME}', '{PASSWORD}');

            $varKeywordValues = array($varPath, $varSiteName, $varAdminUserName, $varAdminUserPass);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

            $varSubject = str_replace('{SITE_NAME}', $varSiteName, $varSubject);
            
           $objCore->sendMail($mailTo, $from, $varSubject, $varOutPutValues);
            
           return true;
            }
            
		}
        
} //ending of class
?>
