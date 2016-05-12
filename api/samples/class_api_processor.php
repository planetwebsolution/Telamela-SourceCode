	<?php
class APIProcessor extends Core
{
	//constructor
	function __construct()
	{

	}
     /**
	* This function escape the quoted string and will convert xml string to json string
	*
	* Date Created: 19th Dec 2012
	*
	* Date Last Modified: 19th Dec 2012
	*
    * @param integer|String
    *
	* @return String
	*/
    function replaceAndConvertToJson($varString,$varSearch='no')
    {
       if($varSearch == 'yes')
       {
           $arrFind = array('&');
           $arrReplace = array('&amp;');
           $varString = str_replace($arrFind, $arrReplace, $varString);
       }    else    {
           $varString = $varString;
       }
       return json_encode($varString);
    }
    /******************************************
	Function name :str_rand
	Return type : text
	Date created : 19th Dec 2012
	Date last modified : 21th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return rando alphanumeric text.
	User instruction : $objAPIProcessor->str_rand($length = 8, $seeds = 'alphanum');
	******************************************/
    function str_rand($length = 8)
    {
        //$text = "12344bc01dfBCDFGghpqr23tvwxyz46HJKLMNjkmnP5QRT789VWXYZ";return rand(5,$text);
        $varStr = md5(uniqid(rand(), true));
        return substr($varStr,0,$length);
    }
	/******************************************
	Function name : userLogin
	Return type : Array
	Date created : 18th Dec 2012
	Date last modified : 20h Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return username after valid login.
	User instruction : $objAPIProcessor->userLogin($arrval);
	******************************************/
	public function userLogin($arrval)
	{
        $arrSelectFlds = array('firstname','lastname','email','customer_id','customer_group_id');
        $varWhereClause = " email = '".$arrval['username']."' AND password= '".md5($arrval['password'])."' ";
        $arrDataList = $this->select(CUSTOMER_TABLE, $arrSelectFlds, $varWhereClause);

        $varWhereClause = " customer_group_id = '".$arrDataList[0]['customer_group_id']."'";
        $arrDiscountList = $this->select('customer_group_discount',array('discount'),$varWhereClause);     //'group_discount_id','customer_group_id',
        if(count($arrDataList) > 0)
        {
            $arrData = array('status'=>'200','message'=>'Succesfully Login','User_id'=>$arrDataList[0]['customer_id'],'customer_group_id'=>$arrDataList[0]['customer_group_id'],'discount_value'=>number_format($arrDiscountList[0]['discount'],2));
        }   else    {
            $arrData = array('status'=>'401','message'=>'Login Failed');
        }
        return $this->replaceAndConvertToJson($arrData);
	}
    /******************************************
	Function name : forgotPassword
	Return type : Array
	Date created : 18th Dec 2012
	Date last modified : 20th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return password/email after valid email.
	User instruction : $objAPIProcessor->forgotPassword($argArrPost);
	******************************************/
	public function forgotPassword($argArrPost)
	{
         // Check given email is exist in database or not
            $varWhr=" AND email= '".$argArrPost['email']."'";
          $varNumRows= $this->getNumRows(CUSTOMER_TABLE,$varWhr);
          if($varNumRows==0)
          {
              $arrData =array('status'=>'400','Message'=>EMAIL_NOT_EXIST);
          }   else    {
             $varWhrCon="  email= '".$argArrPost['email']."'";
             $varNewPassword=$this->str_rand(6);
             $this->update(CUSTOMER_TABLE,array('password'=>md5($varNewPassword)),$varWhrCon);
             $arrDataList = $this->select(CUSTOMER_TABLE, array('firstname','lastname','email'), $varWhrCon);
             //mail content data
             ob_start();
                require_once(SOURCE_ROOT.'common/mail/forgotpass_mail.html');
                $varOutputMail = ob_get_contents();
             ob_end_clean();
             $varKeyword = array('{FIRST_NAME}','{LAST_NAME}','{EMAIL}','{PASSWORD}');
             $varKeywordValues = array(ucfirst($arrDataList[0]['firstname']),ucfirst($arrDataList[0]['lastname']),$arrDataList[0]['email'],$varNewPassword);
             $argMessage = str_replace($varKeyword,$varKeywordValues,$varOutputMail);
             // End mail content data
             // Send mail with new password
             $this->sendMail($argArrPost['email'], MAIL_FROM, FORGOT_MAIL_SUBJECT, nl2br($argMessage),$fromname="");
             $arrData = array('status'=>'200','message'=>PASSWORD_SENT_MSG);
          }
          return $this->replaceAndConvertToJson($arrData);
	}
    /******************************************
	Function name : getCountry
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 24th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return country name ,code,id.
	User instruction : $objAPIProcessor->getCountry($argArrPost);
	******************************************/
	public function getCountry($argArrPost)
	{
        //$varWhereClause = 'country_id in (2,3,4)';
        $arrSelectFlds = array('country_id','name');//,'iso_code_2','iso_code_3'
        $arrData = $this->select(COUNTRY_TABLE, $arrSelectFlds, $varWhereClause);
        if(is_array($arrData))
        {
            $arrNewData = array("status"=>"200","country_list"=>$arrData);
        }   else    {
            $arrNewData = array("status"=>"400","message"=>"Data not found.");
        }
        return $this->replaceAndConvertToJson($arrNewData);
	}
        
         /******************************************
	Function name : getCountryName
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 29th April Dec 2012
	Author : Rakesh kumar
	Last modified by : Arvind Yadav
	Comments : This function return country name ,code,id.
	User instruction : $objAPIProcessor->getCountryName($argArrPost);
	******************************************/
	public function getCountryName($argContryId)
	{
        $varWhereClause = "country_id = '".$argContryId."'";
        $arrSelectFlds = array('name');//,'iso_code_2','iso_code_3'
        $arrData = $this->select(COUNTRY_TABLE, $arrSelectFlds, $varWhereClause); 
        return $arrData[0]['name'];
	}
        
          /******************************************
	Function name : getCountryName
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 29th April Dec 2012
	Author : Rakesh kumar
	Last modified by : Arvind Yadav
	Comments : This function return country name ,code,id.
	User instruction : $objAPIProcessor->getCountryName($argArrPost);
	******************************************/
	public function getZoneName($argZoneId)
	{
        $varWhereClause = "zone_id = '".$argZoneId."'";
        $arrSelectFlds = array('name');//,'iso_code_2','iso_code_3'
        $arrData = $this->select(ZONE_TABLE, $arrSelectFlds, $varWhereClause); 
        return $arrData[0]['name'];
	}
    /******************************************
	Function name : getCountryState
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 24th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return state anme behalf of country id.
	User instruction : $objAPIProcessor->getCountryState($argArrPost);
	******************************************/
	public function getCountryState($argArrPost)
	{
            // Check country id should be interger value and not empty
        if($argArrPost['country_id'] != '' && ctype_digit($argArrPost['country_id']))
        {
            $varWhereClause = "country_id='".$argArrPost['country_id']."'";
            $argSelectFlds = array('zone_id','code as zonecode','name as zonename');//'country_id',
            $arrData = $this->select(ZONE_TABLE, $argSelectFlds, $varWhereClause);
            if(is_array($arrData))
            {
                $arrNewData = array("status"=>"200","country_zone_list"=>$arrData);
            }   else    {
                $arrNewData = array("status"=>"400","message"=>"Data not found.");
            }
        }   else    {
            $arrNewData = array("status"=>"400","message"=>VALID_DATA." country id.");
        }
        return $this->replaceAndConvertToJson($arrNewData);
	}
    /******************************************
	Function name : userRegister
	Return type : Array
	Date created : 18th Dec 2012
	Date last modified : 26th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function add userinfo.
	User instruction : $objAPIProcessor->userRegister($argArrPost);
	******************************************/
	public function userRegister($argArrPost)
	{
        if($argArrPost['firstname'] != '' && $argArrPost['email'] != '' && $argArrPost['fax'] != '' && $argArrPost['telephone'] != '' && $argArrPost['password'])
        {
            $whr=" AND email= '".$argArrPost['email']."'";
            $varNumRows= $this->getNumRows(CUSTOMER_TABLE,$whr);
            if($varNumRows==0)
            {
                //save in customer table
                $arrUserAddFields = array('firstname'=>$argArrPost['firstname'],'lastname'=>$argArrPost['lastname'],'email'=>$argArrPost['email'],'fax'=>$argArrPost['fax'],
                'telephone'=>$argArrPost['telephone'],'password'=>md5($argArrPost['password']),'newsletter'=>  $argArrPost['newsletter'],"ip"=>$_SERVER['REMOTE_ADDR'],"date_added"=>date('Y-m-d'),"customer_group_id"=>"8","status"=>"1","approved"=>"1");
                $varRegLastId = $this->insert(CUSTOMER_TABLE,$arrUserAddFields);
                //save in customer_ip table
                $this->insert(CUSTOMER_IP_TABLE,array('customer_id'=>$varRegLastId,'ip'=>$_SERVER['REMOTE_ADDR'],'date_added'=>date('Y-m-d')));

                //save in address table
                $arrUserAddressFields=array('customer_id'=>$varRegLastId,'firstname'=>$argArrPost['firstname'],'lastname'=>$argArrPost['lastname'],'company'=>$argArrPost['company'],
                    'address_1'=>  $argArrPost['address1'],'address_2'=>  $argArrPost['address2'],'city'=>$argArrPost['city'],'postcode'=>$argArrPost['postcode'],'country_id'=>$argArrPost['country_id'],'zone_id'=>$argArrPost['zone_id']);
                $varLastAddrId = $this->insert(ADDRESS_TABLE,$arrUserAddressFields);
                //update address_id in customer table
                $varUptWhr = "customer_id='".$varRegLastId."'";
                $this->update(CUSTOMER_TABLE,array('address_id'=>$varLastAddrId),$varUptWhr);
                //if billing and shipping address are different
                if($argArrPost['DeliveryBillingStatus'] != 1)
                {
                    $varLastAddrId = $this->insert(ADDRESS_TABLE,$arrUserAddressFields);
                }
                $arrData = array('status'=>'200','Message'=>REG_SUCCESS_MSG,'User_id'=>$varRegLastId,'customer_group_id'=>'8');
                ob_start();
                    require_once(SOURCE_ROOT.'common/mail/register_mail.html');
                    $varOutputMail = ob_get_contents();
                ob_end_clean();
                $varKeyword = array('{FIRST_NAME}','{LAST_NAME}','{EMAIL}','{USERNAME}','{PASSWORD}');
                $varKeywordValues = array($argArrPost['firstname'],$argArrPost['lastname'],$argArrPost['email'],$argArrPost['email'],$argArrPost['password']);
                $argMessage = str_replace($varKeyword,$varKeywordValues,$varOutputMail);
                $this->sendMail($arrUserAddFields['email'], MAIL_FROM , 'ZeroThree:Registred successfully !' , nl2br($argMessage),$fromname="");
            }   else    {
                $arrData = array('status'=>'400','Message'=>USER_EMAIL_EXIST);
            }
        }   else    {
            $arrData = array('status'=>'400','Message'=>FIELD_ERR);
        }
        return $this->replaceAndConvertToJson($arrData);
	}
      /******************************************
	Function name : getUserProfile
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 26th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return users details.
	User instruction : $objAPIProcessor->getUserProfile($argArrPost);
	******************************************/
	public function getUserProfile($argArrPost)
	{
          // Check customer id should be interger value and not empty
        if($argArrPost['customer_id'] != '' && ctype_digit($argArrPost['customer_id']))
        {
            $argSelectFlds = array('customer_id','firstname','lastname','email','telephone','fax');
            $varWhereClause=" customer_id='".$argArrPost['customer_id']."'";
            $arrDataList = $this->select(CUSTOMER_TABLE, $argSelectFlds, $varWhereClause);
            if(count($arrDataList)>0)
            {
                $arrData = array('status'=>'200','userinfo'=>$arrDataList[0]);
            }  else    {
                $arrData = array('status'=>'400','Message'=>DATA_NOT_FOUND);
            }
        }   else    {
            $arrData = array('status'=>'400','Message'=>VALID_DATA." customer id");
        }
        return $this->replaceAndConvertToJson($arrData);
	}
    /******************************************
	Function name : updateUserProfile
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 26th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return users details.
	User instruction : $objAPIProcessor->updateUserProfile($argArrPost);
	******************************************/
	public function updateUserProfile($argArrPost)
	{
        if($argArrPost['firstname'] != '' && $argArrPost['lastname'] != '' && $argArrPost['email'] != '' && $argArrPost['fax'] != '' && $argArrPost['telephone'] != '')
        {
            if($argArrPost['customer_id'] != '')
            {
                //check if email exist !
                $whrCustID = " customer_id = '".$argArrPost['customer_id']."'";
                $arrEmailData= $this->select(CUSTOMER_TABLE,array('email'),$whrCustID);
                $whr = " AND email= '".$argArrPost['email']."'";
                $varNumRowsEmail= $this->getNumRows(CUSTOMER_TABLE,$whr);

                if($varNumRowsEmail==0)                                                             $varFlag=1;
                else if($varNumRowsEmail == 1 && $arrEmailData[0]['email']==$argArrPost['email'])   $varFlag=1;
                else                                                                                $varFlag=0;
                if($varFlag==1)
                {
                    $arrUserAddFields = array('firstname'=>$argArrPost['firstname'],'lastname'=>$argArrPost['lastname'],'email'=>$argArrPost['email'],'fax'=>$argArrPost['fax'],'telephone'=>$argArrPost['telephone']);
                    $this->update(CUSTOMER_TABLE,$arrUserAddFields,$whrCustID);
                    $arrData = array('status'=>'200','Message'=>PROFILE_UPDATE_SUCCESS_MSG);
                }   else    {
                    $arrData = array('status'=>'401','Message'=>EMAIL_EXIST);
                }
            }   else    {
                $arrData = array('status'=>'400','Message'=>VALID_DATA." customer id");
            }
         }  else    {
            $arrData = array('status'=>'400','Message'=>FIELD_ERR);
         }
         return $this->replaceAndConvertToJson($arrData);
     }
 /******************************************
	Function name : changePassword
	Return type : Array
	Date created : 26th Dec 2012
	Date last modified : 27th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return changed password.
	User instruction : $objAPIProcessor->changePassword($argArrPost);
	******************************************/
	public function changePassword($argArrPost)
	{
            // Check all fields should not be empty
        if($argArrPost['old_password'] != '' && $argArrPost['new_password'] != '' && $argArrPost['con_password'] != '')
        {
            if($argArrPost['new_password'] == $argArrPost['con_password'])// match given new password with confirm password
            {
                $varWhereClause=" AND customer_id='".$argArrPost['customer_id']."' AND password='".md5($argArrPost['old_password'])."'";
                $varNumRows= $this->getNumRows(CUSTOMER_TABLE,$varWhereClause);
                if($varNumRows>0)
                {
                    $whrcon="  customer_id= '".$argArrPost['customer_id']."' ";
                    $this->update(CUSTOMER_TABLE,array('password'=>md5($argArrPost['new_password'])),$whrcon);
                    $arrData = array('status'=>'200','Message'=>PASSWORD_CHANGED);
                }   else    {
                    $arrData = array('status'=>'400','Message'=>WRONG_OLD_PASS);
                }
             }  else    {
                $arrData = array('status'=>'400','Message'=>PASS_MATCH_ERR);
             }
         }   else    {
             $arrData = array('status'=>'400','Message'=>FIELD_ERR);
         }
         return $this->replaceAndConvertToJson($arrData);
      }

    /******************************************
	Function name : getBillingAddress
	Return type : Array
	Date created : 27th Dec 2012
	Date last modified : 27th Dec 2012
	Author : Bhavesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return customer billing address.
	User instruction : $objAPIProcessor->getBillingAddress($argArrPost);
	******************************************/
	public function getBillingAddress($argArrPost)
	{
        if($argArrPost['customer_id'] != '' && ctype_digit($argArrPost['customer_id']))
        {
            $varWhereClause=" customer_id='".$argArrPost['customer_id']."' order by address_id asc limit 1";
            $arrBillingAddress = $this->select(ADDRESS_TABLE,array('address_id','customer_id','company','address_1','address_2','city','postcode','country_id','zone_id'),$varWhereClause);
            if(count($arrBillingAddress)>0)
            {
                $arrData = array('status'=>'200','billingAddress'=>$arrBillingAddress[0]);
            }   else    {
                $arrData = array('status'=>'400','Message'=>"No address stored for this customer.");
            }
         }   else    {
             $arrData = array('status'=>'400','Message'=>"Please provide the valid Customer id.");
         }
         return $this->replaceAndConvertToJson($arrData);
    }
    /******************************************
	Function name : updateBillingAddress
	Return type : Array
	Date created : 27th Dec 2012
	Date last modified : 27th Dec 2012
	Author : Bhavesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function update customer billing address.
	User instruction : $objAPIProcessor->updateBillingAddress($argArrPost);
	******************************************/
    public function updateBillingAddress($argArrPost)
	{
        if($argArrPost['customer_id'] != '' && ctype_digit($argArrPost['customer_id']))
        {
            $varWhereClause=" customer_id='".$argArrPost['customer_id']."' order by address_id asc limit 1";
            $arrBillingAddress = $this->select(ADDRESS_TABLE,array('address_id'),$varWhereClause);
            if(count($arrBillingAddress) > 0)
            {
                $arrDataUpdate = array('company'=>$argArrPost['company'],'address_1'=>$argArrPost['address1'],'address_2'=>$argArrPost['address2'],'city'=>$argArrPost['city'],'postcode'=>$argArrPost['postcode'],'country_id'=>$argArrPost['country_id'],'zone_id'=>$argArrPost['zone_id']);
                $whrcon="  address_id = '".$arrBillingAddress[0]['address_id']."'";
                $this->update(ADDRESS_TABLE,$arrDataUpdate,$whrcon);
                $arrData = array('status'=>'200','Message'=>"Billing address data updated successfully.");
            }   else    {
                $arrData = array('status'=>'400','Message'=>"No data in database to update.");
            }
        }   else    {
             $arrData = array('status'=>'400','Message'=>"Please provide the valid Customer id.");
        }
        return $this->replaceAndConvertToJson($arrData);
    }
    /******************************************
	Function name : getShippingAddress
	Return type : Array
	Date created : 27th Dec 2012
	Date last modified : 27th Dec 2012
	Author : Bhavesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function update customer Shipping address.
	User instruction : $objAPIProcessor->getShippingAddress($argArrPost);
	******************************************/
    public function getShippingAddress($argArrPost)
	{
        if($argArrPost['customer_id'] != '' && ctype_digit($argArrPost['customer_id']))
        {
            $varWhereClause=" customer_id='".$argArrPost['customer_id']."' order by address_id desc limit 2";
            $arrShippingAddress = $this->select(ADDRESS_TABLE,array('address_id','customer_id','company','address_1','address_2','city','postcode','country_id','zone_id'),$varWhereClause);
            //echo '<pre>';print_r($arrShippingAddress);die;
            if(count($arrShippingAddress)>1)
            {
                $arrData = array('status'=>'200','billingAddress'=>$arrShippingAddress[0]);
            }
            else if(count($arrShippingAddress) == 1)
            {
                $arrData = array('status'=>'200','Message'=>"Billing & shipping address are same.");
            }   else    {
                $arrData = array('status'=>'400','Message'=>"No address stored for this customer.");
            }
         }   else    {
             $arrData = array('status'=>'400','Message'=>"Please provide the valid Customer id.");
         }
         return $this->replaceAndConvertToJson($arrData);
    }
    /******************************************
	Function name : updateShippingAddress
	Return type : Array
	Date created : 27th Dec 2012
	Date last modified : 27th Dec 2012
	Author : Bhavesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function update customer Shipping address.
	User instruction : $objAPIProcessor->updateShippingAddress($argArrPost);
	******************************************/
    public function updateShippingAddress($argArrPost)
	{
        //echo '<pre>';print_r($argArrPost);die;
        if($argArrPost['customer_id'] != '' && ctype_digit($argArrPost['customer_id']))
        {
            $varWhereClause=" customer_id='".$argArrPost['customer_id']."' order by address_id desc limit 3";
            $arrShippingAddress = $this->select(ADDRESS_TABLE,array('address_id'),$varWhereClause);
            if(count($arrShippingAddress) > 1)
            {
                $arrDataUpdate = array('company'=>$argArrPost['company'],'address_1'=>$argArrPost['address1'],'address_2'=>$argArrPost['address2'],'city'=>$argArrPost['city'],'postcode'=>$argArrPost['postcode'],'country_id'=>$argArrPost['country_id'],'zone_id'=>$argArrPost['zone_id']);
                $whrcon="  address_id = '".$arrShippingAddress[0]['address_id']."'";
                $this->update(ADDRESS_TABLE,$arrDataUpdate,$whrcon);
                $arrData = array('status'=>'200','Message'=>"Shipping address data updated successfully.");
            }   else    {
                $arrData = array('status'=>'400','Message'=>"No shipping data in database to update.");
            }
        }   else    {
             $arrData = array('status'=>'400','Message'=>"Please provide the valid Customer id.");
        }
        return $this->replaceAndConvertToJson($arrData);
    }
    /******************************************
	Function name : userOrders
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 27th Dec 2012
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return user order details .
	User instruction : $objAPIProcessor->userOrders($username,$pass);
	******************************************/
	public function userOrders($argArrPost)
	{
             // Check here given customer id is Inter value or not
            if($argArrPost['customer_id'] != '' && ctype_digit($argArrPost['customer_id']))
                 {
                    $arrPostData=array('customer_id'=>$argArrPost['customer_id']);
                    $argSelectFlds = array("od.order_id as order_number","concat('$',round(ot.value,2)) as total_price","od.date_added as date","IFNULL(ost.name,'Failed') as order_status");
                    $argTables = ORDER_TABLE.' as od INNER JOIN '.ORDER_TOTAL_TABLE.' as ot ON od.order_id=ot.order_id INNER JOIN '.ORDER_STATUS_TABLE.' ost ON od.order_status_id=ost.order_status_id ';
                    $varWhereClause=" ot.code ='total' AND od.order_status_id!=0 AND od.customer_id='".$arrPostData['customer_id']."'";
                    $arrDataList = $this->select($argTables, $argSelectFlds, $varWhereClause);
                    if(count($arrDataList)>0)
                        $arrData = array('status'=>'200','OrderInfo'=>$arrDataList);
                    else
                        $arrData = array('status'=>'400','Message'=>ORDER_NOT_FOUND);
                     return $this->replaceAndConvertToJson($arrData);
                 }else{
                  $arrData = array('status'=>'400','Message'=>VALID_DATA." customer id");
                  return $this->replaceAndConvertToJson($arrData);
                 }
	}

        /******************************************
	Function name : userOrders
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 27th Dec 2012
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return user order details .
	User instruction : $objAPIProcessor->userOrders($array);
	******************************************/
	public function userOrdersDetails($argArrPost)
	{
        // Check here given order id is Inter value or not
        if($argArrPost['order_id'] != '' && ctype_digit($argArrPost['order_id']))
        {
            $arrPostData=array('order_id'=>$argArrPost['order_id']);
            $argSelectFlds = array("od.order_id","opt.name as product_name","p.image as product_image","opt.quantity","round(opt.price,2) as price","pd.description");
            $argTables = ORDER_TABLE.' as od INNER JOIN  '.ORDER_PRODUCT_TABLE.' opt ON od.order_id=opt.order_id  LEFT JOIN '.PRODUCT_TABLE.' as p ON opt.product_id=p.product_id LEFT JOIN  '.PRODUCT_DES_TABLE.' as pd ON p.product_id=pd.product_id ';
            $varWhereClause="  od.order_id='".$arrPostData['order_id']."'";            
            mysql_query('SET CHARACTER SET utf8');
            $arrDataList = $this->select($argTables, $argSelectFlds, $varWhereClause);
            if(count($arrDataList)>0)
                $arrData = array('status'=>'200','ProductInfo'=>$arrDataList);
            else
                $arrData = array('status'=>'400','Message'=>PRODUCT_NOT_FOUND);
            return $this->replaceAndConvertToJson($arrData);
        } else {
            $arrData = array('status'=>'400','Message'=>VALID_DATA." order id");
            return $this->replaceAndConvertToJson($arrData);

        }
	}

    /******************************************
	Function name : productCategoryListing
	Return type : Array
	Date created : 20th Dec 2012
	Date last modified : 20th Dec 2012
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return product category name listing .
	User instruction : $objAPIProcessor->productCategoryListing($arrList);
	******************************************/
	public function productCategoryListing($argArrPost)
	{
        $argSelectFlds = array("name as category_name","C.category_id");
        $argTables = CATEGORY_DES.' as CD INNER JOIN '.CATEGORY_TABLE.' as C ON CD.category_id= C.category_id ';
        $varWhereClause="  C.status=1 AND C.parent_id = 0 order by sort_order asc";//AND C.top=1            
            mysql_query('SET CHARACTER SET utf8');            
            $arrDataList = $this->select($argTables, $argSelectFlds, $varWhereClause);
            if(count($arrDataList)>0)
                $arrData = array('status'=>'200','Product Category'=>$arrDataList);
            else
             $arrData = array('status'=>'400','Message'=>PRODUCT_NOT_FOUND);

            return $this->replaceAndConvertToJson($arrData);
	}
         /******************************************
	Function name : subCategoryListing
	Return type : Array
	Date created : 09 June 2014
	Date last modified : 09 June 2014
	Author : Brajesh kumar Singh
	Last modified by : Brajesh kumar Singh
	Comments : This function returns all subcategory based on passed category ID
	User instruction : $objAPIProcessor->productCategoryListing($catId);
	******************************************/
	public function subCategoryListing($argArrPost)
	{
           if($argArrPost['category_id']!="" && $argArrPost['category_id']!=0){
            $catId = (int)$argArrPost['category_id'];
            $argSelectFlds = array("name as category_name","C.category_id");
            $argTables = CATEGORY_DES.' as CD INNER JOIN '.CATEGORY_TABLE.' as C ON CD.category_id= C.category_id ';
            $varWhereClause="C.parent_id= $catId AND C.status=1 order by sort_order asc";//AND C.top=1            
                mysql_query('SET CHARACTER SET utf8');               
                $arrDataList = $this->select($argTables, $argSelectFlds, $varWhereClause);               
                if(count($arrDataList)>0){
                  $arrData = array('status'=>'200','Product Category'=>$arrDataList);  
                }    
                else{
                    $argSelectFlds = array("name as category_name","C.category_id");
                    $argTables = CATEGORY_DES.' as CD INNER JOIN '.CATEGORY_TABLE.' as C ON CD.category_id= C.category_id ';
                    $varWhereClause="C.category_id= $catId AND C.status=1 order by sort_order asc limit 1";//AND C.top=1 
                     mysql_query('SET CHARACTER SET utf8');               
                     $arrDataList = $this->select($argTables, $argSelectFlds, $varWhereClause);
                     if(count($arrDataList)>0){
                         $arrData = array('status'=>'200','Product Category'=>$arrDataList);  
                    }else{
                        $arrData = array('status'=>'400','Message'=>CATEGORY_NOT_FOUND);  
                    }                    
                }
                return $this->replaceAndConvertToJson($arrData);   
           }else{
               $arrData = array('status'=>'400','Message'=>DATA_NOT_FOUND);
               return $this->replaceAndConvertToJson($arrData);   
           }
       
	}
        /******************************************
	Function name : productListing
	Return type : Array
	Date created : 20th Dec 2012
	Date last modified : 27th Dec 2012
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return product  listing  behalf of category id.
	User instruction : $objAPIProcessor->productListing($arrList);
	******************************************/
	public function productListing($argArrPost)
	{
        // Check here given category id is Inter value or not
        if($argArrPost['category_id'] != '' && ctype_digit($argArrPost['category_id']))
        {
            $arrPostData=array("category_id"=>    $argArrPost['category_id'],"category_name"=>   $argArrPost['category_name']);
            $argSelectFlds = array('pd.name as product_name','p.price as product_price','p.product_id','p.image as product_image','p.group_discount as group_discount_id');//round(p.price,2)
            $argTables = PRODUCT_TABLE.' as p INNER JOIN '.PRODUCT_CAT.' as pc ON p.product_id= pc.product_id LEFT JOIN '.PRODUCT_DES_TABLE.' as pd ON p.product_id=pd.product_id';
            $varWhereClause=" p.status=1 AND  pc.category_id='".$arrPostData['category_id']."'";            
            mysql_query('SET CHARACTER SET utf8');
            $arrDataList = $this->select($argTables, $argSelectFlds, $varWhereClause);

            for($i=0; $i< count($arrDataList); $i++)
            {
                $varWhereClause = " product_id='".$arrDataList[$i]['product_id']."'";
                $arrOptionList = $this->select(PRODUCT_OPTION, array('product_option_id'), $varWhereClause);// List of product options
                $arrDataList[$i]['optionExist'] = (count($arrOptionList) > 0) ? '1' :'0';
            }
            if(count($arrDataList)>0)
                $arrData = array('status'=>'200','Category name'=>$arrPostData['category_name'],'Products info'=>$arrDataList);
            else
                $arrData = array('status'=>'400','Message'=>PRODUCT_NOT_FOUND);

            return $this->replaceAndConvertToJson($arrData);
        }  else    {
            $arrData = array('status'=>'400','Message'=>VALID_DATA."category id");
            return $this->replaceAndConvertToJson($arrData);
        }
	}
/******************************************
	Function name : productDetails
	Return type : Array
	Date created : 2nd Jan 2013
	Date last modified : 2nd Jan 2013
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return serach product details   behalf of text.
	User instruction : $objAPIProcessor->productDetails($arrList);
	******************************************/
	public function productDetails($argArrPost)
	{
        //Check here given product id is Inter value or not
        if($argArrPost['product_id'] != '' && ctype_digit($argArrPost['product_id']))
        {
            $arrPostData=array('product_id'=>$argArrPost['product_id']);
            $argSelectFlds = array('pd.name as product_name','p.product_id','p.model','p.price as product_price','p.image as product_small_image','pi.image as product_big_image','pd.description as product_description','p.group_discount as group_discount_id');//round(p.price,2)
            $argTables = PRODUCT_TABLE.' as p LEFT JOIN  '.PRODUCT_DES_TABLE.' as pd ON p.product_id=pd.product_id LEFT JOIN  '.PRODUCT_IMAGE.' as pi ON p.product_id=pi.product_id';
            $varWhereClause=" p.product_id='".$arrPostData['product_id']."'";//p.status=1 AND            
            mysql_query('SET CHARACTER SET utf8');
            $arrDataList = $this->select($argTables, $argSelectFlds, $varWhereClause);
            //Code to apply optionlist exist or not
            $varWhereClause = " product_id='".$arrPostData['product_id']."'";
            $arrOptionList = $this->select(PRODUCT_OPTION, array('product_option_id'), $varWhereClause);// List of product options
            $arrDataList[0]['optionExist'] = (count($arrOptionList) > 0) ? '1' :'0';
            //End of Code to apply optionlist exist or not
            if(count($arrDataList)>0)
             $arrData = array('status'=>'200','Products info'=>$arrDataList);
            else
             $arrData = array('status'=>'400','Message'=>PRODUCT_NOT_FOUND);
            return $this->replaceAndConvertToJson($arrData);
         }  else    {
            $arrData = array('status'=>'400','Message'=>VALID_DATA." product id");
            return $this->replaceAndConvertToJson($arrData);
         }
	}

         /******************************************
	Function name : productSearch
	Return type : Array
	Date created : 2nd Jan 2013
	Date last modified : 2nd Jan 2013
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return serach product details   behalf of text.
	User instruction : $objAPIProcessor->productSearch($arrList);
	******************************************/
	public function productSearch($argArrPost)
	{
        // Check here given product id is Inter value or not
        if($argArrPost['keywords'] != '')
        {
            $arrPostData=array('type'=>strtolower($argArrPost['keywords']));

            $argSelectFlds = array('pd.name as product_name','p.product_id','p.price as product_price','p.image as product_image','pd.description as product_description'); //round(p.price,2)
            $argTables = PRODUCT_TABLE.' as p LEFT JOIN  '.PRODUCT_DES_TABLE.' as pd ON p.product_id=pd.product_id ';
            $varWhereClause=" (LOWER(pd.name) LIKE  '%".$arrPostData['type']."%' or LOWER(pd.description) LIKE  '%".$arrPostData['type']."%') AND p.status = 1 ";            
            mysql_query('SET CHARACTER SET utf8');
            $arrDataList = $this->select($argTables, $argSelectFlds, $varWhereClause);
            for($i=0; $i< count($arrDataList); $i++)
            {
                $varWhereClause = " product_id='".$arrDataList[$i]['product_id']."'";
                $arrOptionList = $this->select(PRODUCT_OPTION, array('product_option_id'), $varWhereClause);// List of product options
                $arrDataList[$i]['optionExist'] = (count($arrOptionList) > 0) ? '1' :'0';
            }
            if(count($arrDataList)>0)
                $arrData = array('status'=>'200','Products info'=>$arrDataList);
            else
                $arrData = array('status'=>'400','Message'=>PRODUCT_NOT_FOUND);
                return $this->replaceAndConvertToJson($arrData);
         }  else    {
            $arrData = array('status'=>'400','Message'=>VALID_DATA." serch text");
            return $this->replaceAndConvertToJson($arrData);
         }
	}

        /******************************************
	Function name : productOptionsList
	Return type : Array
	Date created : 24th Dec 2012
	Date last modified : 27th Dec 2012
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return product options list   behalf of product id.
	User instruction : $objAPIProcessor->productOptionsList($arrList);
	******************************************/
	public function productOptionsList($argArrPost)
	{
       // Check here given product id is Inter value or not
       if($argArrPost['product_id'] != '' && ctype_digit($argArrPost['product_id']))
       {
            $arrPostData=array('product_id'=>$argArrPost['product_id']);
            $argSelectFlds = array('od.name as option_name','od.option_id','o.type');

            $argTables .= PRODUCT_OPTION.' as po INNER JOIN  '.OPTION_TABLE.' AS o ON po.option_id = o.option_id ';
            $argTables.= 'INNER JOIN '.OPTION_DES_TABLE.' AS od ON o.option_id = od.option_id ';
            $varWhereClause="  po.product_id='".$arrPostData['product_id']."'";
            $arrOptionList = $this->select($argTables, $argSelectFlds, $varWhereClause);// List of product options

            //Check If product has any option
            if(count($arrOptionList)>0)
            {
             $arrOptionData=array();
             foreach($arrOptionList as $data)
             {
                 $argSelectFlds = array('ovd.name','ovd.option_value_id','round(pov.price,2) as value_price');
                  $varWhereClause="  od.option_id='".$data['option_id']."' and p.product_id='".$arrPostData['product_id']."' group by  ovd.option_value_id";
                  $argTables =OPTION_DES_TABLE.' AS od INNER JOIN '.OPTION_VAL_DES_TABLE.' AS ovd ON od.option_id = ovd.option_id INNER  JOIN '.PRODUCT_OPTION_VAL.' as pov ON ovd.option_value_id = pov.option_value_id INNER JOIN '.PRODUCT_TABLE.' as p ON p.product_id=pov.product_id ';
                  $arrList = $this->select($argTables, $argSelectFlds, $varWhereClause);
      $key=$data['option_id'].'_'.$data['option_name'];
                  $arrOptionData[$key]=$arrList;
                 }
                 if(count($arrList)>0)
                 $arrData =array('status'=>'200','Product Id'=>$argArrPost['product_id'],'Options List'=>$arrOptionData);
                 else
                 $arrData =array('status'=>'400','Message'=>OPTION_NOT_FOUND);
                return $this->replaceAndConvertToJson($arrData);

           } else  {
              $arrData = array('status'=>'400','Message'=>OPTION_NOT_FOUND);
              return $this->replaceAndConvertToJson($arrData);
              }

         }else{

           $arrData = array('status'=>'400','Message'=>VALID_DATA."product id");
           return $this->replaceAndConvertToJson($arrData);

         }
	}

/******************************************
	Function name : saveCreditCardDetail
	Return type : None
	Date created : 5th Mar 2013
	Date last modified : 5th Mar 2013
	Author : Bhavesh kumar
	Last modified by: Bhavesh kumar
	Comments : This function save credit card details.
	User instruction : $objAPIProcessor->saveCreditCardDetail($argArrPost);
	******************************************/
    public function saveCreditCardDetail($arrArgPost)
    {
        //echo "<pre>", print_r($varJsonArr);die;
        if($arrArgPost['customer_id'] != '' && $arrArgPost['OrderId'] != '')
        {
            $arrCreditCard = $arrArgPost['Credit_card_detail'];
            $arrCCDetail = array('fkCustomerID'=>$arrArgPost['customer_id'],'fkOrderID'=>$arrArgPost['OrderId'],'CreditCardNumber'=>$arrCreditCard['CardNumber'],'CreditCardCVV'=>$arrCreditCard['CardCVVNo'],'CreditCardMonth'=>$arrCreditCard['CardExpiryMonth'],'CreditCardYear'=>$arrCreditCard['CardExpiryYear'],'CreditCardType'=>$arrCreditCard['CardType'],'CreditCardCustomerName'=>$arrCreditCard['NameOnCard']);
            $this->insert(CREDIT_CARD_DETAIL ,$arrCCDetail);
            return true;
        }   else return false;
    }
    /******************************************
	Function name : saveOrderDetails
	Return type : Array
	Date created : 26th Dec 2012
	Date last modified : 26th Dec 2012
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function save order details after successful payment .
	User instruction : $objAPIProcessor->saveOrderDetails($argArrPost);
	******************************************/
    public function saveOrderDetails($varJsonArr)
    {
        //echo "asd<pre>", print_r($varJsonArr);die;
        $argArrCustomer=$this->getCustomerInfo($varJsonArr['customer_id']);
        $invoceID = $this->getInvoiceID();
        $varOrderStatusID = ($varJsonArr['payment_method'] == 'paypal') ? '44' : '1';
        $final_total =$varJsonArr['finalOrderTotal']+$varJsonArr['shipping_cost'];
        //echo $varJsonArr['order_total']."<br/>".$final_total."<br/>".$varSurcharge = (($final_total*2.9)/100); die;
        if(is_array($argArrCustomer) && is_array($varJsonArr))
        {   
            $k = count($argArrCustomer) - 1;
            if($varJsonArr['delivery_flag']==0)
            {
            $arrAddOrderFields = array('invoice_no'=>              $invoceID,
                                   'store_name'=>                  'ZeroThree 1300 03 MACS (1300 03 6227)',
                                   'store_url'=>                   'http://www.zerothree.com.au/',
                                   'customer_id'=>                  $varJsonArr['customer_id'],
                                   'customer_group_id'=>           $argArrCustomer[0]['customer_group_id'],
                                   'firstname'=>                   $argArrCustomer[0]['firstname'],
                                   'lastname'=>                    $argArrCustomer[0]['lastname'],
                                   'email'=>                       $argArrCustomer[0]['email'],
                                   'telephone'=>                   $argArrCustomer[0]['telephone'],
                                   'fax'=>                         $argArrCustomer[0]['fax'],
                                   'payment_firstname'=>           $argArrCustomer[0]['payment_firstname'],
                                   'payment_lastname'=>            $argArrCustomer[0]['payment_lastname'],
                                   'payment_company'=>             $argArrCustomer[0]['payment_company'],
                                   'payment_address_1'=>           $argArrCustomer[0]['payment_address_1'],
                                   'payment_address_2'=>           $argArrCustomer[0]['payment_address_2'],
                                   'payment_city'=>                $argArrCustomer[0]['payment_city'],
                                   'payment_postcode'=>            $argArrCustomer[0]['payment_postcode'],
                                   'payment_country'=>             $this->getCountryName($argArrCustomer[0]['country_id']),
                                   'payment_country_id'=>          $argArrCustomer[0]['country_id'],
                                   'payment_zone'=>                $this->getZoneName($argArrCustomer[0]['zone_id']),
                                   'payment_zone_id'=>             $argArrCustomer[0]['zone_id'],
                                   'payment_method'=>              $varJsonArr['payment_method'],
                                   //'payment_method'=>'PayPal Express (including Credit Cards and Debit Cards)',
                                   'shipping_firstname'=>          $argArrCustomer[$k]['payment_firstname'],
                                   'shipping_lastname'=>           $argArrCustomer[$k]['payment_lastname'],
                                   'shipping_company'=>            $argArrCustomer[$k]['payment_company'],
                                   'shipping_address_1'=>          $argArrCustomer[$k]['payment_address_1'],
                                   'shipping_address_2'=>          $argArrCustomer[$k]['payment_address_2'],
                                   'shipping_city'=>               $argArrCustomer[$k]['payment_city'],
                                   'shipping_postcode'=>           $argArrCustomer[$k]['payment_postcode'],
                                   'shipping_country'=>            $this->getCountryName($argArrCustomer[$k]['country_id']),
                                   'shipping_country_id'=>         $argArrCustomer[$k]['country_id'],
                                   'shipping_zone'=>               $this->getZoneName($argArrCustomer[$k]['zone_id']),
                                   'shipping_zone_id'=>            $argArrCustomer[$k]['zone_id'],
                                   'shipping_method'=>             $varJsonArr['shipping_method'],
                                   'total'=>                       round($final_total,2),
                                   'order_status_id'=>             $varOrderStatusID,
                                   'language_id'=>                 '1',
                                   'currency_id'=>                 '2',
                                   'currency_code'=>               'AUD',
                                   'currency_value'=>              '1.00',
                                   'date_added'=>                  date('Y-m-d H:m:s'),
                                   'date_modified'=>                  date('Y-m-d H:m:s'),
                                   'ip'=>                          $varJsonArr['IP']);
            }
            else  if($varJsonArr['delivery_flag']==1)
            {
            $arrAddOrderFields = array('invoice_no'=>              $invoceID,
                                   'store_name'=>                  'ZeroThree 1300 03 MACS (1300 03 6227)',
                                   'store_url'=>                   'http://www.zerothree.com.au/',
                                   'customer_id'=>                  $varJsonArr['customer_id'],
                                   'customer_group_id'=>           $argArrCustomer[0]['customer_group_id'],
                                   'firstname'=>                   $argArrCustomer[0]['firstname'],
                                   'lastname'=>                    $argArrCustomer[0]['lastname'],
                                   'email'=>                       $argArrCustomer[0]['email'],
                                   'telephone'=>                   $argArrCustomer[0]['telephone'],
                                   'fax'=>                         $argArrCustomer[0]['fax'],
                                   'payment_firstname'=>           $argArrCustomer[0]['payment_firstname'],
                                   'payment_lastname'=>            $argArrCustomer[0]['payment_lastname'],
                                   'payment_company'=>             $argArrCustomer[0]['payment_company'],
                                   'payment_address_1'=>           $argArrCustomer[0]['payment_address_1'],
                                   'payment_address_2'=>           $argArrCustomer[0]['payment_address_2'],
                                   'payment_city'=>                $argArrCustomer[0]['payment_city'],
                                   'payment_postcode'=>            $argArrCustomer[0]['payment_postcode'],
                                   'payment_country'=>             $this->getCountryName($argArrCustomer[0]['country_id']),
                                   'payment_country_id'=>          $argArrCustomer[0]['country_id'],
                                   'payment_zone'=>                $this->getZoneName($argArrCustomer[0]['zone_id']),
                                   'payment_zone_id'=>             $argArrCustomer[0]['zone_id'],
                                   'payment_method'=>              $varJsonArr['payment_method'],
                                   //'payment_method'=>'PayPal Express (including Credit Cards and Debit Cards)',
                                   'shipping_firstname'=>          $varJsonArr['delivery_detail']['delivery_firstname'],
                                   'shipping_lastname'=>           $varJsonArr['delivery_detail']['delivery_lastname'],
                                   'shipping_company'=>            $varJsonArr['delivery_detail']['delivery_company'],
                                   'shipping_address_1'=>          $varJsonArr['delivery_detail']['delivery_address_1'],
                                   'shipping_address_2'=>          $varJsonArr['delivery_detail']['delivery_address_2'],
                                   'shipping_city'=>               $varJsonArr['delivery_detail']['delivery_city'],
                                   'shipping_postcode'=>           $varJsonArr['delivery_detail']['delivery_postcode'],
                                   'shipping_country'=>            $this->getCountryName($varJsonArr['delivery_detail']['delivery_country_id']),
                                   'shipping_country_id'=>         $varJsonArr['delivery_detail']['delivery_country_id'],
                                   'shipping_zone'=>               $this->getZoneName($varJsonArr['delivery_detail']['delivery_zone_id']),
                                   'shipping_zone_id'=>            $varJsonArr['delivery_detail']['delivery_zone_id'],
                                   'shipping_method'=>             $varJsonArr['shipping_method'],
                                   'total'=>                       round($final_total,2),
                                   'order_status_id'=>             $varOrderStatusID,
                                   'language_id'=>                 '1',
                                   'currency_id'=>                 '2',
                                   'currency_code'=>               'AUD',
                                   'currency_value'=>              '1.00',
                                   'date_added'=>                  date('Y-m-d H:m:s'),
                                   'date_modified'=>                  date('Y-m-d H:m:s'),
                                   'ip'=>                          $varJsonArr['IP']);
            } 
        }
       else
        {
           if($varJsonArr['delivery_flag']==1)
            {
            $arrAddOrderFields = array('invoice_no'=>              $invoceID,
                                   'store_name'=>                  'ZeroThree 1300 03 MACS (1300 03 6227)',
                                   'store_url'=>                   'http://www.zerothree.com.au/',
                                   'customer_id'=>                 $varJsonArr['customer_id'],
                                   'customer_group_id'=>           '8',
                                   'firstname'=>                   $varJsonArr['billing_detail']['billing_firstname'],
                                   'lastname'=>                    $varJsonArr['billing_detail']['billing_lastname'],
                                   'email'=>                       $varJsonArr['billing_detail']['email'],
                                   'telephone'=>                   $varJsonArr['billing_detail']['telephone'],
                                   'fax'=>                         $varJsonArr['billing_detail']['fax'],
                                   'payment_firstname'=>           $varJsonArr['billing_detail']['billing_firstname'],
                                   'payment_lastname'=>            $varJsonArr['billing_detail']['billing_lastname'],
                                   'payment_company'=>             $varJsonArr['billing_detail']['billing_company'],
                                   'payment_address_1'=>           $varJsonArr['billing_detail']['billing_address_1'],
                                   'payment_address_2'=>           $varJsonArr['billing_detail']['billing_address_2'],
                                   'payment_city'=>                $varJsonArr['billing_detail']['billing_city'],
                                   'payment_postcode'=>            $varJsonArr['billing_detail']['billing_postcode'],
                                   'payment_country'=>             $this->getCountryName($varJsonArr['billing_detail']['billing_country_id']),
                                   'payment_country_id'=>          $varJsonArr['billing_detail']['billing_country_id'],
                                   'payment_zone'=>                $this->getZoneName($varJsonArr['billing_detail']['billing_zone_id']),
                                   'payment_zone_id'=>             $varJsonArr['billing_detail']['billing_zone_id'],
                                   'payment_method'=>              $varJsonArr['payment_method'],
                                   //'payment_method'=>'PayPal Express (including Credit Cards and Debit Cards)',
                                   'shipping_firstname'=>          $varJsonArr['delivery_detail']['delivery_firstname'],
                                   'shipping_lastname'=>           $varJsonArr['delivery_detail']['delivery_lastname'],
                                   'shipping_company'=>            $varJsonArr['delivery_detail']['delivery_company'],
                                   'shipping_address_1'=>          $varJsonArr['delivery_detail']['delivery_address_1'],
                                   'shipping_address_2'=>          $varJsonArr['delivery_detail']['delivery_address_2'],
                                   'shipping_city'=>               $varJsonArr['delivery_detail']['delivery_city'],
                                   'shipping_postcode'=>           $varJsonArr['delivery_detail']['delivery_postcode'],
                                   'shipping_country'=>            $this->getCountryName($varJsonArr['delivery_detail']['delivery_country_id']),
                                   'shipping_country_id'=>         $varJsonArr['delivery_detail']['delivery_country_id'],
                                   'shipping_zone'=>               $this->getZoneName($varJsonArr['delivery_detail']['delivery_zone_id']),
                                   'shipping_zone_id'=>            $varJsonArr['delivery_detail']['delivery_zone_id'],
                                   'shipping_method'=>             $varJsonArr['shipping_method'],
                                   'total'=>                       round($final_total,2),
                                   'order_status_id'=>             $varOrderStatusID,
                                   'language_id'=>                 '1',
                                   'currency_id'=>                 '2',
                                   'currency_code'=>               'AUD',
                                   'currency_value'=>              '1.00',
                                   'date_added'=>                  date('Y-m-d H:m:s'),
                                   'date_modified'=>               date('Y-m-d H:m:s'),
                                   'ip'=>                          $varJsonArr['IP']);
            }
            else if($varJsonArr['delivery_flag']==0)
            {
            $arrAddOrderFields = array('invoice_no'=>              $invoceID,
                                   'store_name'=>                  'ZeroThree 1300 03 MACS (1300 03 6227)',
                                   'store_url'=>                   'http://www.zerothree.com.au/',
                                   'customer_id'=>                 $varJsonArr['customer_id'],
                                   'customer_group_id'=>           '8',
                                   'firstname'=>                   $varJsonArr['billing_detail']['billing_firstname'],
                                   'lastname'=>                    $varJsonArr['billing_detail']['billing_lastname'],
                                   'email'=>                       $varJsonArr['billing_detail']['email'],
                                   'telephone'=>                   $varJsonArr['billing_detail']['telephone'],
                                   'fax'=>                         $varJsonArr['billing_detail']['fax'],
                                   'payment_firstname'=>           $varJsonArr['billing_detail']['billing_firstname'],
                                   'payment_lastname'=>            $varJsonArr['billing_detail']['billing_lastname'],
                                   'payment_company'=>             $varJsonArr['billing_detail']['billing_company'],
                                   'payment_address_1'=>           $varJsonArr['billing_detail']['billing_address_1'],
                                   'payment_address_2'=>           $varJsonArr['billing_detail']['billing_address_2'],
                                   'payment_city'=>                $varJsonArr['billing_detail']['billing_city'],
                                   'payment_postcode'=>            $varJsonArr['billing_detail']['billing_postcode'],
                                   'payment_country'=>             $this->getCountryName($varJsonArr['billing_detail']['billing_country_id']),
                                   'payment_country_id'=>          $varJsonArr['billing_detail']['billing_country_id'],
                                   'payment_zone'=>                $this->getZoneName($varJsonArr['billing_detail']['billing_zone_id']),
                                   'payment_zone_id'=>             $varJsonArr['billing_detail']['billing_zone_id'],
                                   'payment_method'=>              $varJsonArr['payment_method'],
                                   //'payment_method'=>'PayPal Express (including Credit Cards and Debit Cards)',
                                   'shipping_firstname'=>          $varJsonArr['billing_detail']['billing_firstname'],
                                   'shipping_lastname'=>           $varJsonArr['billing_detail']['billing_lastname'],
                                   'shipping_company'=>            $varJsonArr['billing_detail']['billing_company'],
                                   'shipping_address_1'=>          $varJsonArr['billing_detail']['billing_address_1'],
                                   'shipping_address_2'=>          $varJsonArr['billing_detail']['billing_address_2'],
                                   'shipping_city'=>               $varJsonArr['billing_detail']['billing_city'],
                                   'shipping_postcode'=>           $varJsonArr['billing_detail']['billing_postcode'],
                                   'shipping_country'=>            $this->getCountryName($varJsonArr['billing_detail']['billing_country_id']),
                                   'shipping_country_id'=>         $varJsonArr['billing_detail']['billing_country_id'],
                                   'shipping_zone'=>               $this->getZoneName($varJsonArr['billing_detail']['billing_zone_id']),
                                   'shipping_zone_id'=>            $varJsonArr['billing_detail']['billing_zone_id'],
                                   'shipping_method'=>             $varJsonArr['shipping_method'],
                                   'total'=>                       round($final_total,2),
                                   'order_status_id'=>             $varOrderStatusID,
                                   'language_id'=>                 '1',
                                   'currency_id'=>                 '2',
                                   'currency_code'=>               'AUD',
                                   'currency_value'=>              '1.00',
                                   'date_added'=>                  date('Y-m-d H:m:s'),
                                   'date_modified'=>               date('Y-m-d H:m:s'),
                                   'ip'=>                          $varJsonArr['IP']);
            }
         }
         
        $varLastOrderId = $this->insert(ORDER_TABLE,$arrAddOrderFields); 
        if($varLastOrderId)
        {
            //store credit card detail - if payment method is creditcard
            if($varJsonArr['payment_method'] == 'credit_card')
            {
                $varJsonArr['OrderId'] = $varLastOrderId;
                $this->saveCreditCardDetail($varJsonArr);

                $arrCreditCard = $varJsonArr['Credit_card_detail'];
                $varSecondMailContent =   " Dear Admin,

Please find Credit Card details for Order number $varLastOrderId as follows.

                Credit Card First Four Digit :  ". substr($arrCreditCard['CardNumber'],0,4) .",
                Credit Card First Four Digit :  ". substr($arrCreditCard['CardNumber'],-4)."

                Regards
ZeroThree";

                $varThirdMailContent =   " Dear Admin,

Please find Credit Card details for Order number $varLastOrderId as follows.

                Credit Card Middle Digits of the number:  ".  substr($arrCreditCard['CardNumber'],4,-4).",
                CVV:  ". $arrCreditCard['CardCVVNo'].",
                Month:  ".$arrCreditCard['CardExpiryMonth'].",
                Year:  ".$arrCreditCard['CardExpiryYear'].",
                Type:  ".$arrCreditCard['CardType'].",
                Name on Card:  ".$arrCreditCard['NameOnCard']."

Regards
ZeroThree";
            }//echo nl2br($varSecondMailContent.'++++'.$varThirdMailContent);die;
            //Save in customer transction table
            $arrAddCustomerTrans= array('customer_id'=>        $varJsonArr['customer_id'],
                                       'order_id'=>            $varLastOrderId,
                                       'amount'=>              round($varJsonArr['order_total'],2),
                                       'description'=>         $varJsonArr['customer_id'],
                                       'date_added'=>          date('Y-m-d H:m:s'));
           $this->insert(CUSTOMER_TRANSCTION,$arrAddCustomerTrans);
           //Save in product order table
           foreach( $varJsonArr['Product_details'] as $argArrPost)
           {
            $arrProId=array('product_id'=>$argArrPost['product_id']);
            $arrProduct=$this->productDetailsInfo($arrProId);
            $arrOrderProductFields= array('order_id'=>      $varLastOrderId,
                                           'product_id'=>    $arrProduct[0]['product_id'],
                                           'name'=>         $arrProduct[0]['product_name'],
                                           'model'=>        $arrProduct[0]['model'],
                                           'quantity'=>    $argArrPost['qty'],
                                           'price'=>        round($argArrPost['price'],2),
                                           'total'=>        round(($argArrPost['qty']*$argArrPost['price']),2),
                                           'tax'=>         $varJsonArr['tax']);//model - 24 , quantity-4


            $this->insert(ORDER_PRODUCT_TABLE ,$arrOrderProductFields);
            //Save in product options table
            //open this comment when option value will corrent by Mobile team
                if($argArrPost['flag']==1){
                   foreach($argArrPost['options_details'] as $argArrOption)
                   {
                   //echo $argArrOption->product_option_id;
                        $arrOptionData= $this->getOptionsInfo($argArrOption['product_option_value_id']);
                        $arrAddOptionFields=array(   'order_id'=>            $varLastOrderId,
                                                'order_product_id'=>    $argArrPost['product_id'],
                                                'product_option_id'=>   $argArrOption['product_option_id'],
                                                'product_option_value_id'=>$argArrOption['product_option_value_id'],
                                                'name'=>$arrOptionData[0]['name'],
                                                'value'=>$arrOptionData[0]['value'],
                                                'type'=>$arrOptionData[0]['type']
                                                );

                        $this->insert(ORDER_OPTION_TABLE,$arrAddOptionFields);
                     }
                } // open this comment when option value will corrent by Mobile team*/
         }
         //Save order Total
         $arrOrderTotal=array('order_id'=>$varLastOrderId,'code'=>'sub_total','title'=>'Sub-Total:','text'=>'$'.round($varJsonArr['order_total'],2),'value'=>round($varJsonArr['order_total'],2),'sort_order'=>1);
         $arrOrderTotal_sort3= array('order_id'=>$varLastOrderId,'code'=>'shipping','title'=>$varJsonArr['shipping_method'],'text'=>'$'.round($varJsonArr['shipping_cost'],2),'value'=>round($varJsonArr['shipping_cost'],2),'sort_order'=>3); 
         $arrOrderTotal_sort5= array('order_id'=>$varLastOrderId,'code'=>'tax','title'=>'GST:','text'=>'$'.round($varJsonArr['tax'],2),'value'=>round($varJsonArr['tax'],2),'sort_order'=>5);
         /* Shifting downword due to total with surcharge
$arrOrderTotal_sort9=array('order_id'=>$varLastOrderId,'code'=>'total','title'=>'Total:','text'=>'$'.round($final_total,2),'value'=>round($final_total,2),'sort_order'=>9);
*/
         $this->insert(ORDER_TOTAL,$arrOrderTotal);
         $this->insert(ORDER_TOTAL,$arrOrderTotal_sort3);
         $this->insert(ORDER_TOTAL,$arrOrderTotal_sort5);
        // $this->insert(ORDER_TOTAL,$arrOrderTotal_sort9);
        if($varJsonArr['payment_method'] == 'credit_card')
         {
            if($varJsonArr['Credit_card_detail']['CardType'] =='American Express 2.9%')
            {
                $varSurcharge = (($final_total*2.9)/100);
            }
            else if($varJsonArr['Credit_card_detail']['CardType'] == 'Diners 2.9%')
            {
                $varSurcharge = (($final_total*2.9)/100);
            }
            else if($varJsonArr['Credit_card_detail']['CardType'] == 'Master Card 0%' || $varJsonArr['Credit_card_detail']['CardType'] == 'Visa 0%')
            {
                $varSurcharge = '0';
            }
            
             $varSurcharge = round($varSurcharge,2);
             $arrOrderTotal_sort4=array('order_id'=>$varLastOrderId,'code'=>'offline_cc_surcharge','title'=>$varJsonArr['Credit_card_detail']['CardType'],'text'=>'$'.$varSurcharge,'value'=>$varSurcharge,'sort_order'=>4);
             $this->insert(ORDER_TOTAL,$arrOrderTotal_sort4);
         }
         else if($varJsonArr['payment_method'] == 'paypal')
         {
               $varSurcharge = (($final_total*2.2)/100);
               $varSurcharge = round($varSurcharge,2);
               $arrOrderTotal_sort4=array('order_id'=>$varLastOrderId,'code'=>'offline_paypal_surcharge','title'=>'paypal','text'=>'$'.$varSurcharge,'value'=>$varSurcharge,'sort_order'=>4);
               $this->insert(ORDER_TOTAL,$arrOrderTotal_sort4);
         }

$arrOrderTotal_sort9=array('order_id'=>$varLastOrderId,'code'=>'total','title'=>'Total:','text'=>'$'.round(($final_total+$varSurcharge),2),'value'=>round(($final_total+$varSurcharge),2),'sort_order'=>9);
$this->insert(ORDER_TOTAL,$arrOrderTotal_sort9);
         /**************************data insertion completed****************************/
            if($varJsonArr['payment_method'] == 'bank_transfer')     {
                $varStrFinalMsg = "Thanks for your order. Please use your name and/or order I.D. as a reference when depositing. We will confirm once your payment is received and process your order.";
            }
            else if($varJsonArr['payment_method'] == 'credit_card')  {
                $varStrFinalMsg = "Your card is not automatically billed by ZeroThree. We will now carefully check your order and card details and process your order. We'll update you once done.";
            }
            else if($varJsonArr['payment_method'] == 'cash_on_collection')    {
                $varStrFinalMsg = 'Thanks for your order. Payment on Collection is by arrangement only. If you have not arranged this method, please call 1300 03 6227 to organise.';
            }
            else if($varJsonArr['payment_method'] == 'paypal')      {
                $varStrFinalMsg = 'Thank you for placing the order with us.';
            }
            else if($varJsonArr['payment_method'] == 'FedEx' || $varJsonArr['payment_method'] ==  'post')      {
                $varStrFinalMsg = 'Your order has now been submitted. We will contact you shortly with a shipping cost quotation for your chosen method and invoice accordingly for your approval.';
            }   else    {
                $varStrFinalMsg = 'Order placed successfully';
            }
            if($varJsonArr['payment_method'] == 'cash_on_collection')    {
                $varJsonArr['payment_message'] = 'Thanks for your order. Please use your name and/or order I.D. as a reference when depositing. We will confirm once your payment is received and process your order. ';
            }   else    {
                $varJsonArr['payment_message'] = $varStrFinalMsg;
            }
            //Send mail functionality
            if(is_array($argArrCustomer))
            {
            $argMessage=$this->getOrderInfo($varLastOrderId,$varJsonArr);
            $this->sendMail($argArrCustomer[0]['email'], MAIL_FROM,'ZeroThree Order Placed' , nl2br($argMessage),$fromname="");
            }
            else
            {
            $argMessage=$this->getGuestOrderInfo($varLastOrderId,$varJsonArr);
            $this->sendMail($varJsonArr['billing_detail']['email'], MAIL_FROM,'ZeroThree Order Placed' , nl2br($argMessage),$fromname="");    
            }
            $this->sendMail('orders@zerothree.com.au', MAIL_FROM,'ZeroThree Order Placed' , nl2br($argMessage),$fromname="");
          if($varSecondMailContent!='')
            $this->sendMail('orders@zerothree.com.au', MAIL_FROM,"ZeroThree credit card details for order number: $varLastOrderId" , nl2br($varSecondMailContent),$fromname="");
         if($varThirdMailContent!='')
           $this->sendMail('orders@zerothree.com.au', MAIL_FROM,"ZeroThree credit card details for order number: $varLastOrderId" , nl2br($varThirdMailContent),$fromname="");
//orders@zerothree.com.au   bhavesh.kumar@mail.vinove.com

            $arrData = array('status'=>'200','order_id'=>$varLastOrderId, 'Message'=>$varStrFinalMsg);
        }   else    {
            $arrData = array('status'=>'200','Message'=>'Error:No data found');
        }
        return $this->replaceAndConvertToJson($arrData);
  }
    /******************************************
	Function name : getOrderInfo
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 26th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : get Order Info.
	User instruction : $objAPIProcessor->getOrderInfo($argArrPost);
	******************************************/
    public function getOrderInfo($varOrderId,$arrArgPost)
    {
        if($varOrderId == '') return false;

        $varWhereClause = " o.order_id ='".$varOrderId."'";
        $varTable = ORDER_TABLE.' as o INNER JOIN '.CUSTOMER_TABLE.' as c ON o.customer_id=c.customer_id INNER JOIN '.ORDER_PRODUCT_TABLE .' as op ON o.order_id=op.order_id';
        $arrDataList = $this->select($varTable,array('c.firstname','c.lastname','c.email','c.telephone','op.name','op.quantity','round(op.price,2) as price','o.date_added','op.product_id','o.shipping_firstname','o.shipping_lastname','o.shipping_company','o.shipping_address_1','o.shipping_address_2','o.shipping_city','o.shipping_postcode','o.shipping_country','o.shipping_zone','o.payment_firstname','o.payment_lastname','o.payment_company','o.payment_address_1','o.payment_address_2','o.payment_city','o.payment_postcode','o.payment_country','o.payment_zone'),$varWhereClause);
        $arryDetails=array();
        $arryDetails['customer']=array('custName'=>$arrDataList[0]['firstname'].' '.$arrDataList[0]['lastname'],
                                        'custEmail'=>$arrDataList[0]['email'],
                                        'custPhone'=>$arrDataList[0]['telephone'],
                                        'custOrderID'=>$varOrderId);
        // Order value
        $orderTotal = $arrArgPost['order_total'] + $arrArgPost['shipping_cost'];
        $tax        = ($arrArgPost['tax']!='') ? number_format($arrArgPost['tax'],2) : 'NA';
        $shipcost   = ($arrArgPost['shipping_cost']!='') ? number_format($arrArgPost['shipping_cost'],2) : 'NA';
        $i=0;
        while($i < count($arrDataList))
        {
            $arryDetails['product'][$i]=array('Name'=>$arrDataList[$i]['name'],'Quantity'=>$arrDataList[$i]['quantity'],'Price'=>number_format($arrDataList[$i]['price'],2));
            $varWhereClause = " order_id ='".$varOrderId."' AND order_product_id='".$arrDataList[$i]['product_id']."' ";
            $arryDetails['product'][$i]['options']= $this->select(ORDER_OPTION_TABLE,array('name','value','order_product_id'),$varWhereClause);
            $i++;
        }
        //Generate product email string
        $productHtml = "<table width=100%><tr bgcolor=#99CCFF><td width=50% >Product Name</td><td width=25%>Quantity</td><td width=25%>Price</td></tr>";
        $i=0;
        while($i < count($arryDetails['product']))
        {
            $varProductName=$arryDetails['product'][$i]['Name'];
            $varProductQty=$arryDetails['product'][$i]['Quantity'];
            $varProductPrice= $arryDetails['product'][$i]['Price'];
            //Show product options
            $k=0;
            $productHtmlOptions='';
            if($arryDetails['product'][$i]['options']){
                $productHtml.="<tr><td width=50%>$varProductName</td><td width=25%>$varProductQty</td><td width=25%>$varProductPrice</td></tr>";

			 $productHtmlOptions = "<table width=50% align=left><tr bgcolor=#99CCFF><td width=25% >Options Name</td><td width=25%>Options Value</td></tr>";
			 while($k < count($arryDetails['product'][$i]['options']))
	       	 {
                $varName=$arryDetails['product'][$i]['options'][$k]['name'];
                $varValue=$arryDetails['product'][$i]['options'][$k]['value'];
                $productHtmlOptions.="<tr><td width=25%>$varName</td><td width=25%>$varValue</td></tr>";
                $k++;
             }
             $productHtmlOptions.="<tr><td colspan=2><hr /></td></tr></table>";
             $productHtml.="<tr><td colspan=3>$productHtmlOptions</td></tr>";
            }   else    {
        		$productHtml.="<tr><td width=50%>$varProductName</td><td width=25%>$varProductQty</td><td width=25%>$varProductPrice</td></tr>";
            }
            $i++;
        }
        $productHtml.="</table>";
        $final_details = "<table width=100%><tr bgcolor=#99CCFF><td width=25% >OrderID</td><td width=25%>$varOrderId</td></tr>";
        $final_details .= "<tr bgcolor=#99CCFF><td width=25% >Final Order Amount</td><td width=25%>".number_format($orderTotal,2)."</td></tr>";
        $final_details .="</table>";
        
        ob_start();
            require_once(SOURCE_ROOT.'common/mail/order_mail.html');
            $varOutputMail = ob_get_contents();
        ob_end_clean();
        $varOrderStatus = ($arrArgPost['payment_method'] == 'paypal') ? 'Completed' : 'Pending';
        $varShippingMehod = $arrArgPost['shipping_method'];
        $varFinalOrderAmount = '';
        if($varShippingMehod == 'FedEX' || $varShippingMehod == 'post')//Pickup From Store
        {
            $varPaymentMeth = '-';
        }   else    {
            $varPaymentMeth = $arrArgPost['payment_method'];
        }
        if($arrArgPost['payment_method'] == 'bank_transfer')
        {
            $varPaymentMeth .=  '
                Account details ZeroThree:  BSB 063156, Account 10098718';
        }
        else if($arrArgPost['payment_method'] == 'paypal')
        {
            $varFinalOrderAmount = 'Extra Charge:   +2.2%';
        }
        else if($arrArgPost['payment_method'] == 'credit_card')
        {
            if($arrArgPost['Credit_card_detail']['CardType'] =='American Express 2.9%')
            {
                $varFinalOrderAmount = 'Surcharge:    +2.9%';
            }
            else if($arrArgPost['Credit_card_detail']['CardType'] == 'Diners 2.9%')
            {
                $varFinalOrderAmount = 'Surcharge:    +2.9%';
            }
            else if($arrArgPost['Credit_card_detail']['CardType'] == 'Master Card 0%' || $arrArgPost['Credit_card_detail']['CardType'] == 'Visa 0%')
            {
                $varFinalOrderAmount = 'Surcharge:  +0%';
            }
        }
        $varFinalOrderAmount .= '
            Order Total:    '.number_format($arrArgPost['finalOrderTotal'],2);
        $varKeyword = array('{ORDERID}','{FIRST_NAME}','{NAME}','{EMAIL}','{PHONE}','{PRODUCT}','{ORDER_STATUS}','{PAYMENT_METHOD}','{SHIPPING_METHOD}','{ORDER_DATE}','{ORDER_MESSAGE}','{ORDER_TOTAL}','{TAX}','{SHIP_COST}','{FINAL_ORDER_AMOUNT}','{BNAME}','{BLAST}','{BCOMPANY}','{BADDRESS1}','{BADDRESS2}','{BCITY}','{BPOST}','{BCOUNTRY}','{BZONE}','{CNAME}','{CLAST}','{CCOMPANY}','{CADDRESS1}','{CADDRESS2}','{CCITY}','{CPOST}','{CCOUNTRY}','{CZONE}','{FINAL_DETAILS}');
        $varKeywordValues = array($varOrderId,ucfirst($arrDataList[0]['firstname']),$arryDetails['customer']['custName'],$arryDetails['customer']['custEmail'],$arryDetails['customer']['custPhone'],$productHtml,$varOrderStatus,$varPaymentMeth,$varShippingMehod,substr($arrDataList[0]['date_added'],0,10),$arrArgPost['payment_message'],  number_format($orderTotal,2),$tax,$shipcost,$varFinalOrderAmount,$arrDataList[0]['payment_firstname'],$arrDataList[0]['payment_lastname'],$arrDataList[0]['payment_company'],$arrDataList[0]['payment_address_1'],$arrDataList[0]['payment_address_2'],$arrDataList[0]['payment_city'],$arrDataList[0]['payment_postcode'],$arrDataList[0]['payment_country'],$arrDataList[0]['payment_zone'],$arrDataList[0]['shipping_firstname'],$arrDataList[0]['shipping_lastname'],$arrDataList[0]['shipping_company'],$arrDataList[0]['shipping_address_1'],$arrDataList[0]['shipping_address_2'],$arrDataList[0]['shipping_city'],$arrDataList[0]['shipping_postcode'],$arrDataList[0]['shipping_country'],$arrDataList[0]['shipping_zone'],$final_details);
        $argMessage = str_replace($varKeyword,$varKeywordValues,$varOutputMail);//die(nl2br($argMessage));

     return $argMessage;
    }
    
    /******************************************
	Function name : getOrderInfo
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 26th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : get Order Info.
	User instruction : $objAPIProcessor->getOrderInfo($argArrPost);
	******************************************/
    public function getGuestOrderInfo($varOrderId,$arrArgPost)
    {
        if($varOrderId == '') return false;

        $varWhereClause = " o.order_id ='".$varOrderId."'";
        $varTable = ORDER_TABLE.' as o INNER JOIN '.ORDER_PRODUCT_TABLE .' as op ON o.order_id=op.order_id';
        $arrDataList = $this->select($varTable,array('o.firstname','o.lastname','o.email','o.telephone','op.name','op.quantity','round(op.price,2) as price','o.date_added','op.product_id','o.shipping_firstname','o.shipping_lastname','o.shipping_company','o.shipping_address_1','o.shipping_address_2','o.shipping_city','o.shipping_postcode','o.shipping_country','o.shipping_zone','o.payment_firstname','o.payment_lastname','o.payment_company','o.payment_address_1','o.payment_address_2','o.payment_city','o.payment_postcode','o.payment_country','o.payment_zone'),$varWhereClause);
        $arryDetails=array();
        $arryDetails['customer']=array('custName'=>$arrDataList[0]['firstname'].' '.$arrDataList[0]['lastname'],
                                        'custEmail'=>$arrDataList[0]['email'],
                                        'custPhone'=>$arrDataList[0]['telephone'],
                                        'custOrderID'=>$varOrderId);
        // Order value
        $orderTotal = $arrArgPost['order_total'] + $arrArgPost['shipping_cost'];
        $tax        = ($arrArgPost['tax']!='') ? number_format($arrArgPost['tax'],2) : 'NA';
        $shipcost   = ($arrArgPost['shipping_cost']!='') ? number_format($arrArgPost['shipping_cost'],2) : 'NA';
        $i=0;
        while($i < count($arrDataList))
        {
            $arryDetails['product'][$i]=array('Name'=>$arrDataList[$i]['name'],'Quantity'=>$arrDataList[$i]['quantity'],'Price'=>number_format($arrDataList[$i]['price'],2));
            $varWhereClause = " order_id ='".$varOrderId."' AND order_product_id='".$arrDataList[$i]['product_id']."' ";
            $arryDetails['product'][$i]['options']= $this->select(ORDER_OPTION_TABLE,array('name','value','order_product_id'),$varWhereClause);
            $i++;
        }
        //Generate product email string
        $productHtml = "<table width=100%><tr bgcolor=#99CCFF><td width=50% >Product Name</td><td width=25%>Quantity</td><td width=25%>Price</td></tr>";
        $i=0;
        while($i < count($arryDetails['product']))
        {
            $varProductName=$arryDetails['product'][$i]['Name'];
            $varProductQty=$arryDetails['product'][$i]['Quantity'];
            $varProductPrice= $arryDetails['product'][$i]['Price'];
            //Show product options
            $k=0;
            $productHtmlOptions='';
            if($arryDetails['product'][$i]['options']){
                $productHtml.="<tr><td width=50%>$varProductName</td><td width=25%>$varProductQty</td><td width=25%>$varProductPrice</td></tr>";

			 $productHtmlOptions = "<table width=50% align=left><tr bgcolor=#99CCFF><td width=25% >Options Name</td><td width=25%>Options Value</td></tr>";
			 while($k < count($arryDetails['product'][$i]['options']))
	       	 {
                $varName=$arryDetails['product'][$i]['options'][$k]['name'];
                $varValue=$arryDetails['product'][$i]['options'][$k]['value'];
                $productHtmlOptions.="<tr><td width=25%>$varName</td><td width=25%>$varValue</td></tr>";
                $k++;
             }
             $productHtmlOptions.="<tr><td colspan=2><hr /></td></tr></table>";
             $productHtml.="<tr><td colspan=3>$productHtmlOptions</td></tr>";
            }   else    {
        		$productHtml.="<tr><td width=50%>$varProductName</td><td width=25%>$varProductQty</td><td width=25%>$varProductPrice</td></tr>";
            }
            $i++;
        }
        $productHtml.="</table>";
        $final_details = "<table width=75%><tr bgcolor=#99CCFF><td width=25% >OrderID</td><td width=25%>$varOrderId</td></tr>";
        $final_details .= "<tr bgcolor=#99CCFF><td width=25% >Final Order Amount</td><td width=25%>".number_format($orderTotal,2)."</td></tr>";
        $final_details .="</table>";
        ob_start();
            require_once(SOURCE_ROOT.'common/mail/order_mail.html');
            $varOutputMail = ob_get_contents();
        ob_end_clean();
        $varOrderStatus = ($arrArgPost['payment_method'] == 'paypal') ? 'Completed' : 'Pending';
        $varShippingMehod = $arrArgPost['shipping_method'];
        $varFinalOrderAmount = '';
        if($varShippingMehod == 'FedEX' || $varShippingMehod == 'post')//Pickup From Store
        {
            $varPaymentMeth = '-';
        }   else    {
            $varPaymentMeth = $arrArgPost['payment_method'];
        }
        if($arrArgPost['payment_method'] == 'bank_transfer')
        {
            $varPaymentMeth .=  '
                Account details ZeroThree:  BSB 063156, Account 10098718';
        }
        else if($arrArgPost['payment_method'] == 'paypal')
        {
            $varFinalOrderAmount = 'Extra Charge:   +2.2%';
        }
        else if($arrArgPost['payment_method'] == 'credit_card')
        {
            if($arrArgPost['Credit_card_detail']['CardType'] =='American Express 2.9%')
            {
                $varFinalOrderAmount = 'Surcharge:    +2.9%';
            }
            else if($arrArgPost['Credit_card_detail']['CardType'] == 'Diners 2.9%')
            {
                $varFinalOrderAmount = 'Surcharge:    +2.9%';
            }
            else if($arrArgPost['Credit_card_detail']['CardType'] == 'Master Card 0%' || $arrArgPost['Credit_card_detail']['CardType'] == 'Visa 0%')
            {
                $varFinalOrderAmount = 'Surcharge:  +0%';
            }
        }
        $varFinalOrderAmount .= '
            Order Total:    '.number_format($arrArgPost['finalOrderTotal'],2);

       $varKeyword = array('{ORDERID}','{FIRST_NAME}','{NAME}','{EMAIL}','{PHONE}','{PRODUCT}','{ORDER_STATUS}','{PAYMENT_METHOD}','{SHIPPING_METHOD}','{ORDER_DATE}','{ORDER_MESSAGE}','{ORDER_TOTAL}','{TAX}','{SHIP_COST}','{FINAL_ORDER_AMOUNT}','{BNAME}','{BLAST}','{BCOMPANY}','{BADDRESS1}','{BADDRESS2}','{BCITY}','{BPOST}','{BCOUNTRY}','{BZONE}','{CNAME}','{CLAST}','{CCOMPANY}','{CADDRESS1}','{CADDRESS2}','{CCITY}','{CPOST}','{CCOUNTRY}','{CZONE}','{FINAL_DETAILS}');
        $varKeywordValues = array($varOrderId,ucfirst($arrDataList[0]['firstname']),$arryDetails['customer']['custName'],$arryDetails['customer']['custEmail'],$arryDetails['customer']['custPhone'],$productHtml,$varOrderStatus,$varPaymentMeth,$varShippingMehod,substr($arrDataList[0]['date_added'],0,10),$arrArgPost['payment_message'],  number_format($orderTotal,2),$tax,$shipcost,$varFinalOrderAmount,$arrDataList[0]['payment_firstname'],$arrDataList[0]['payment_lastname'],$arrDataList[0]['payment_company'],$arrDataList[0]['payment_address_1'],$arrDataList[0]['payment_address_2'],$arrDataList[0]['payment_city'],$arrDataList[0]['payment_postcode'],$arrDataList[0]['payment_country'],$arrDataList[0]['payment_zone'],$arrDataList[0]['shipping_firstname'],$arrDataList[0]['shipping_lastname'],$arrDataList[0]['shipping_company'],$arrDataList[0]['shipping_address_1'],$arrDataList[0]['shipping_address_2'],$arrDataList[0]['shipping_city'],$arrDataList[0]['shipping_postcode'],$arrDataList[0]['shipping_country'],$arrDataList[0]['shipping_zone'],$final_details);
        $argMessage = str_replace($varKeyword,$varKeywordValues,$varOutputMail);//die(nl2br($argMessage));

     return $argMessage;
    }
    /******************************************
	Function name : userEnquiry
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 26th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function save enquiry content.
	User instruction : $objAPIProcessor->userEnquiry($argArrPost);
	******************************************/
	public function userEnquiry($argArrPost)
	{
        if($argArrPost['name'] != '' && $argArrPost['email'] != '' && $argArrPost['enquiryMessage'] != '')
        {
            $arrPostData = array('first_name'=>$argArrPost['name'],'email'=>$argArrPost['email'],
                                 'enquiry_content'=>$argArrPost['enquiryMessage'],'ip_address'=>$_SERVER['REMOTE_ADDR']);
            $varRes = $this->insert(ENQUIRY_TABLE,$arrPostData);
            if($varRes)
            {
                //Admin mail content
                ob_start();
                    require_once(SOURCE_ROOT.'common/mail/enquiry_mail.html');
                    $varOutputAdminMail = ob_get_contents();
                ob_end_clean();
                //user mail content
                ob_start();
                    require_once(SOURCE_ROOT.'common/mail/enquiry_user_mail.html');
                    $varOutputUserMail = ob_get_contents();
                ob_end_clean();
                $varKeyword = array('{NAME}','{EMAIL}','{MESSAGE}');
                $varKeywordValues = array($argArrPost['name'],$argArrPost['email'],$argArrPost['enquiryMessage']);
                $varAdminMessage = str_replace($varKeyword,$varKeywordValues,$varOutputAdminMail);
                $varUserMessage  = str_replace($varKeyword,$varKeywordValues,$varOutputUserMail);

                $varAdminMail = $this->sendMail(ADMIN_MAIL_ID,$argArrPost['email'],'ZeroThree: Contact us Enquiry',nl2br($varAdminMessage),$fromname="");
                $varUserMail =  $this->sendMail($argArrPost['email'],ADMIN_MAIL_ID,'ZeroThree: Enquiry sent' , nl2br($varUserMessage),$fromname="");
                $arrData = array('status'=>'200','Message'=>ENQUIRY_SUCCESS_MSG);
            }   else    {
                $arrData = array('status'=>'203','Message'=>"Some error to save the data.");
            }
        } else {
            $arrData = array('status'=>'203','Message'=>FIELD_ERR);
        }
        return $this->replaceAndConvertToJson($arrData);
	}
 /******************************************
	Function name : newUserEnquiry
	Return type : Array
	Date created : 2nd Jun 2014
	Date last modified : 2nd Jun 2014
	Author : Suraj Kumar Maurya
	Last modified by : Suraj kumar Maurya
	Comments : This function save enquiry content.
	User instruction : $objAPIProcessor->userEnquiry($argArrPost);
	******************************************/
	public function newUserEnquiry($argArrPost)
	{
        if($argArrPost['name'] != '' && $argArrPost['phone']!='' && $argArrPost['email'] != ''  && $argArrPost['enquiryMessage'] != '')
        {
            $arrPostData = array('first_name'=>$argArrPost['name'],'email'=>$argArrPost['email'],
                                 'enquiry_content'=>$argArrPost['enquiryMessage'],'ip_address'=>$_SERVER['REMOTE_ADDR']);
            $varRes = $this->insert(ENQUIRY_TABLE,$arrPostData);
            if($varRes)
            {
                //Admin mail content
                ob_start();
                    require_once(SOURCE_ROOT.'common/mail/new_enquiry_mail.html');
                    $varOutputAdminMail = ob_get_contents();
                ob_end_clean();
                //user mail content
                ob_start();
                    require_once(SOURCE_ROOT.'common/mail/new_enquiry_user_mail.html');
                    $varOutputUserMail = ob_get_contents();
                ob_end_clean();
                $varKeyword = array('{NAME}','{COMPANY}','{PHONE}','{EMAIL}','{MESSAGE}');
                $varKeywordValues = array($argArrPost['name'], $argArrPost['company'], $argArrPost['phone'], $argArrPost['email'], $argArrPost['enquiryMessage']);
                $varAdminMessage = str_replace($varKeyword,$varKeywordValues,$varOutputAdminMail);
                $varUserMessage  = str_replace($varKeyword,$varKeywordValues,$varOutputUserMail);
//define('ADMIN_TRADE_IN_MAIL_ID','trade-ins@03.com.au');
                $varAdminMail = $this->sendMail(ADMIN_TRADE_IN_MAIL_ID,$argArrPost['email'],'ZeroThree: Trade-in Enquiry',nl2br($varAdminMessage),$fromname=""); 
                $varUserMail =  $this->sendMail($argArrPost['email'],ADMIN_MAIL_ID,'ZeroThree: Trade-in Enquiry sent' , nl2br($varUserMessage),$fromname="");
                $arrData = array('status'=>'200','Message'=>NEW_ENQUIRY_SUCCESS_MSG);
            }   else    {
                $arrData = array('status'=>'203','Message'=>"Some error to save the data.");
            }
        } else {
            $arrData = array('status'=>'203','Message'=>FIELD_ERR);
        }
        return $this->replaceAndConvertToJson($arrData);
	}
    /******************************************
	Function name : getSiteInfoTitle
	Return type : Array
	Date created : 19th Dec 2012
	Date last modified : 21th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return site info title eg About Us,Education store etc.
	User instruction : $objAPIProcessor->getSiteInfoTitle($argArrPost);
	******************************************/
	public function getSiteInfoTitle($argArrPost)
	{
         // Page id which want to show (comma seperated)
        $varInfoID = '4,34,36,50,49,37,46,41';
        $varWhereClause = " information_id IN($varInfoID)";
        $arrData = $this->select(INFO_DESCRIPTION,array('title','information_id'),$varWhereClause);
        if(is_array($arrData))
        {
            $arrNewData = array("status"=>"200","siteTitleList"=>$arrData);
        }   else    {
            $arrNewData = array("status"=>"400","message"=>"List not found");
        }
        return $this->replaceAndConvertToJson($arrNewData);
	}
    /******************************************
	Function name : getSiteInfoTitleContent
	Return type : Array
	Date created : 24th Dec 2012
	Date last modified : 26th Dec 2012
	Author : Rakesh kumar
	Last modified by : Bhavesh kumar
	Comments : This function return site info description .
	User instruction : $objAPIProcessor->getSiteInfoTitleContent($argArrPost);
	******************************************/
	public function getSiteInfoTitleContent($argArrPost)
	{
        if($argArrPost['info_title_id'] != '')
        {
            $varWhereClause=" information_id ='".$argArrPost['info_title_id']."'";
            $arrDataList = $this->select(INFO_DESCRIPTION,array('description','title'), $varWhereClause);
            if($arrDataList[0]['description']!='')
            {
                $arrNewData = array('status'=>'200','SiteInfo'=>$arrDataList[0]);
            } else {
                $arrNewData = array('status'=>'400','Message'=>PAGE_NOT_FOUND);
            }
        }   else    {
            $arrNewData = array('status'=>'400','Message'=>"Please Provide the Page ID.");
        }
        return $this->replaceAndConvertToJson($arrNewData);
    }


    /******************************************
	Function name : getCustomerInfo
	Return type : Array
	Date created : 15 Jan 2013
	Date last modified : 15 jan 2013
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return site info description .
	User instruction : $objAPIProcessor->getCustomerInfo($argArrPost);
	******************************************/
	public function getCustomerInfo($argArrPost)
	{

           $varWhereClause=" c.customer_id ='".$argArrPost."'";
            $varTable=CUSTOMER_TABLE.' as c LEFT JOIN '.ADDRESS_TABLE.' as a ON c.customer_id=a.customer_id ';
            $arrDataList = $this->select($varTable,array('c.firstname','c.lastname','c.email','c.telephone','c.fax','c.customer_group_id','a.firstname as payment_firstname','a.lastname as payment_lastname','a.company as payment_company','a.address_1 as payment_address_1', 'a.address_2 as payment_address_2','a.city as payment_city','a.postcode as payment_postcode','a.country_id','a.zone_id'), $varWhereClause);
           return $arrDataList;
    }

    /******************************************
	Function name : getOptionsInfo
	Return type : Array
	Date created : 16 Jan 2013
	Date last modified : 16 jan 2013
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return site info description .
	User instruction : $objAPIProcessor->getOptionsInfo($argArrPost);
	******************************************/
	public function getOptionsInfo($argArrPost)
	{

           $varWhereClause=" ov.option_value_id ='".$argArrPost."'";
           $varTable=OPTION_VAL_DES_TABLE.' as ov INNER JOIN '.OPTION_TABLE.' as o ON ov.option_id=o.option_id INNER JOIN '.OPTION_DES_TABLE .' as od ON o.option_id=od.option_id';
            $arrDataList = $this->select($varTable,array('o.type','ov.name as value','od.name'), $varWhereClause);
           return $arrDataList;
    }

    /******************************************
	Function name : getInvoiceID
	Return type : Array
	Date created : 15 Jan 2013
	Date last modified : 15 jan 2013
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return site info description .
	User instruction : $objAPIProcessor->getInvoiceID($argArrPost);
	******************************************/
	public function getInvoiceID()
	{
       $varWhereClause=' 1 = 1';
       $arrDataList = $this->select(ORDER_TABLE,array('MAX(invoice_no) as invoice_no'), $varWhereClause);
       return $arrDataList[0]['invoice_no'] + 1;
    }
   	/******************************************
	Function name : productDetailsInfo
	Return type : Array
	Date created : 16th Jan 2013
	Date last modified : 16th Jan 2013
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return serach product details   behalf of text.
	User instruction : $objAPIProcessor->productDetailsInfo($arrList);
	******************************************/
	public function productDetailsInfo($argArrPost)
	{
        $arrPostData=array('product_id'=>$argArrPost['product_id']);
        $argSelectFlds = array('pd.name as product_name','p.product_id','p.model','p.price as product_price','p.image as product_small_image','pi.image as product_big_image','pd.description as product_description');//round(p.price,2)
        $argTables = PRODUCT_TABLE.' as p INNER JOIN  '.PRODUCT_DES_TABLE.' as pd ON p.product_id=pd.product_id LEFT JOIN  '.PRODUCT_IMAGE.' as pi ON p.product_id=pi.product_id';
        $varWhereClause=" p.status=1 AND  p.product_id='".$arrPostData['product_id']."' group by p.product_id";           
        mysql_query('SET CHARACTER SET utf8');
        $arrDataList = $this->select($argTables, $argSelectFlds, $varWhereClause);
        return $arrDataList;
	}
    /******************************************
	Function name : productDetailsInfo
	Return type : Array
	Date created : 16th Jan 2013
	Date last modified : 16th Jan 2013
	Author : Rakesh kumar
	Last modified by : Rakesh kumar
	Comments : This function return serach product details   behalf of text.
	User instruction : $objAPIProcessor->productDetailsInfo($arrList);
	******************************************/
	public function getOrderProcessDetails($argArrPost)
	{
        $varOrderId = $argArrPost['order_id'];
        if($varOrderId == '' || $argArrPost['customer_id'] == '')
        {
            $arryDetails = array('status'=>'400','Message'=>"Please Provide order id and customer id.");
        }   else    {
        $varWhereClause = " o.order_id ='".$varOrderId."' and o.customer_id = '".$argArrPost['customer_id']."'";
        $varTable = ORDER_TABLE.' as o INNER JOIN '.ORDER_PRODUCT_TABLE .' as op ON o.order_id=op.order_id inner join product p on p.product_id = op.product_id inner join order_status os on o.order_status_id = os.order_status_id';
        $arrDataList = $this->select($varTable,array('p.image','o.order_id','o.total','o.order_status_id','o.date_added','op.name','op.quantity','op.price','op.product_id','os.name as status_name'),$varWhereClause);
        if(count($arrDataList) > 0)
        {
            $arryDetails=array();
            $arryDetails['status'] = '200';
            $arryDetails['orderID'] = $arrDataList[0]['order_id'];
            $arryDetails['orderTotal'] = number_format($arrDataList[0]['total'],2);
            $arryDetails['statusID'] = $arrDataList[0]['order_status_id'];
            $arryDetails['statusName'] = $arrDataList[0]['status_name'];
            $arryDetails['Date'] = substr($arrDataList[0]['date_added'],0,10);
            $i=0;
            while($i < count($arrDataList))
            {
                $arryDetails['product'][$i]=array('Image'=>$arrDataList[$i]['image'],'Name'=>$arrDataList[$i]['name'],'Quantity'=>$arrDataList[$i]['quantity'],'Price'=>number_format($arrDataList[$i]['price'],2));
                $varWhereClause = " order_id ='".$varOrderId."' AND order_product_id='".$arrDataList[$i]['product_id']."' ";
                $arrOptions = $this->select(ORDER_OPTION_TABLE,array('name','value','order_product_id'),$varWhereClause);
                if(count($arrOptions) > 0) $arryDetails['product'][$i]['options'] = $arrOptions;
                $i++;
            }
        }   else    {
            $arryDetails = array('status'=>'400','Message'=>"No order placed");
        }
      }//echo '<pre>';print_r($arryDetails);die;
      return $this->replaceAndConvertToJson($arryDetails);
	}
        

      /******************************************
	Function name : getCustomerRewards
	Return type : Array
	Date created : 30th Oct 2013
	Date last modified : 30th Oct 2013
	Author : Vipin Tomar
	Last modified by : Vipin Tomar
	Comments : This function return Total rewards points of the customer.
	User instruction : $objAPIProcessor->getCustomerRewards($arrList);
	******************************************/
	public function getCustomerRewards($argArrPost)
	{
	 $total = 0;
	 $arryDetails = array();
        // Check here given product id is Inter value or not
        if($argArrPost['customer_id'] != '')
        {
	    $argSelectFlds = array('sum(points) AS totalRewards');
            $argTables = CUSTOMER_REWARD_TABLE.' as c ';
            $varWhereClause=" c.customer_id = '".$argArrPost['customer_id']."' GROUP BY '".$argArrPost['customer_id']."' ";
            $arrDataList = $this->select($argTables, $argSelectFlds, $varWhereClause);
            if(count($arrDataList)>0){
	       $total = $arrDataList[0]['totalRewards'];
	       $arryDetails['status'] = '200';
	       if(!$total){
		  $total = "0";
	       }
	       $arryDetails['customer_points'] = $total;
	    }else{
	       $arryDetails = array('status'=>'400','Message'=>"Customer Not Found.");
	    }
	}else{
	       $arryDetails = array('status'=>'400','Message'=>"Please Provide customer id");
        }
	return $this->replaceAndConvertToJson($arryDetails);
	}
}?>
