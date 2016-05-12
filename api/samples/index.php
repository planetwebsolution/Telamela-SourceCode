<?php 
    require_once '../common/config.inc.php';
    require_once CLASSES_PATH.'api/class_api_processor_bll.php';
    $objAPIProcessor = new APIProcessor();

    //echo microtime().'--ww<pre>';print_r($_POST);die;

    function objectsIntoArray($arrObjData, $arrSkipIndices = array())
    {
        $arrData = array();
        //if input is object, convert into array
        if(is_object($arrObjData))
        {
            $arrObjData = get_object_vars($arrObjData);
        }
        if(is_array($arrObjData))
        {
            foreach($arrObjData as $index => $value)
            {
                if(is_object($value) || is_array($value))
                {
                    $value = objectsIntoArray($value, $arrSkipIndices); //recursive call
                }
                if(in_array($index, $arrSkipIndices))   continue;
                $arrData[$index] = $value;
            }
        }
        return $arrData;
    }

    $varToken = '0BE5C32FF9C2C99670A1C013911506CF';
    if(LOCAL_MODE)
    {
          //$json_data = '{"method":"userRegister","firstname":"Rakesh","lastname":"kumar","email":"rakesh.kumar1@mail.vinove.com","password":"test","fax":"1233","telephone":"01123","address1":"delhi","address2":"asas","city":"nagloi","company":"vinove","postcode":"110041","country":"1"}';
           
        // $json_data = JSON_DATA; //commented by brajesh 
        // code snippet added by brajesh on 09 June 2014
        $json_data  = json_encode(array('method'=>$_REQUEST['method'],'category_id'=>$_REQUEST['category_id'],'category_name'=>$_REQUEST['category_name']));
        // code snippet ends here on 09 June 2014
    }
    /*else if($_SERVER['HTTPS'] != 'on')
    {
        echo json_encode(array('code'=>'400', 'message'=>'Kindly check the API url. It must contain HTTPS.'));
        die;
    }*/
    else
    {
        if($_GET['method'] != '')
        {
            $arrKey = array_keys($_GET);
            //$json_data = '{"'.$arrKey[0].'":"'.$_GET[$arrKey[0]].'","'.$arrKey[1].'":"'.$_GET[$arrKey[1]].'"}';
            $json_data = '{';
            foreach($arrKey as $val)
            {
                $json_data .= '"'.$val.'":"'.$_GET[$val].'",';
            }
            $json_data = trim($json_data,',').'}';
        }   else    {
            $json_data = ($_POST['json_data']!= '') ? $_POST['json_data'] : JSON_DATA;
        }
    }
    if($varToken != '')
    { 
        try
        {
           /*$varstrr = '';            
            @mail('sanchit.paurush@mail.vinove.com','Json data',$json_data);            
             $arrData = json_decode($json_data,true);
            if(is_array($arrData))
            {
                foreach($arrData as $key=> $val)
                {
                    $varstrr .= $key.'=>'.$val.'
                        ';
                }
            }
            @mail('sanchit.paurush@mail.vinove.com','php array',nl2br($varstrr));//echo '<pre>';print_r($arrData);die;*/
            
            $arrData = json_decode($json_data,true);
            //$arrData = json_decode(stripslashes($json_data),true);
            
            if($arrData === null || $arrData === false)
            {      
                $varError = "Failed loading JSON. Please check the requested JSON. Special characters must not be included in request.";
                echo json_encode(array('code'=>'400', 'message'=>$varError));
                die;
            }
            else if($arrData['method']!='')
            {
                $varMethod = $arrData['method'];
                $arrParamList = objectsIntoArray($arrData);
            }
            $arrNewParamList = $arrParamList;
            //echo $varMethod.'<pre>';print_r($arrNewParamList);die;
            switch($varMethod)
            {
                case 'userLogin':
                    echo $objAPIProcessor->userLogin($arrNewParamList);
                break;
                case 'forgotPassword':
                    echo $objAPIProcessor->forgotPassword($arrNewParamList);
                break;
                case 'userRegister':
                    echo $objAPIProcessor->userRegister($arrNewParamList);
                break;
                 case 'userEnquiry':
                    echo $objAPIProcessor->userEnquiry($arrNewParamList);
                break;
                 case 'newUserEnquiry':
                    echo $objAPIProcessor->newUserEnquiry($arrNewParamList);
                break;
                 case 'getCountry':
                    echo $objAPIProcessor->getCountry($arrNewParamList);
                break;
                case 'getCountryState':
                    echo $objAPIProcessor->getCountryState($arrNewParamList);
                break;
                case 'getCountryState':
                    echo $objAPIProcessor->getCountryState($arrNewParamList);
                break;
                case 'getUserProfile':
                    echo $objAPIProcessor->getUserProfile($arrNewParamList);
                break;
                 case 'updateUserProfile':
                    echo $objAPIProcessor->updateUserProfile($arrNewParamList);
                break;
                 case 'changePassword':
                    echo $objAPIProcessor->changePassword($arrNewParamList);
                break;
                case 'getBillingAddress':
                    echo $objAPIProcessor->getBillingAddress($arrNewParamList);
                break;
                case 'getShippingAddress':
                    echo $objAPIProcessor->getShippingAddress($arrNewParamList);
                break;
                case 'updateBillingAddress':
                    echo $objAPIProcessor->updateBillingAddress($arrNewParamList);
                break;
                case 'updateShippingAddress':
                    echo $objAPIProcessor->updateShippingAddress($arrNewParamList);
                break;
                case 'getSiteInfoTitle':
                    echo $objAPIProcessor->getSiteInfoTitle($arrNewParamList);
                break;
                case 'getSiteInfoTitleContent':
                    echo $objAPIProcessor->getSiteInfoTitleContent($arrNewParamList);
                break;
                case 'userOrders':
                    echo $objAPIProcessor->userOrders($arrNewParamList);
                break;
                case 'userOrdersDetails':
                    echo $objAPIProcessor->userOrdersDetails($arrNewParamList);
                break;
                case 'productCategoryListing':                     
                    echo $objAPIProcessor->productCategoryListing($arrNewParamList);
                break;
                case 'subCategoryListing': 
                    //echo '<pre> sss'; print_r($arrNewParamList); die;
                    echo $objAPIProcessor->subCategoryListing($arrNewParamList);
                break;
                case 'productListing':
                    echo $objAPIProcessor->productListing($arrNewParamList);
                break;
                case 'productSearch':
                    echo $objAPIProcessor->productSearch($arrNewParamList);
                break;
                case 'productDetails':
                    echo $objAPIProcessor->productDetails($arrNewParamList);
                break;
                case 'productOptionsList':
                    echo $objAPIProcessor->productOptionsList($arrNewParamList);
                break;
                case 'saveOrderDetails':
               echo $objAPIProcessor->saveOrderDetails($arrNewParamList);
		break;
                case 'getOrderProcessDetails':
                    echo $objAPIProcessor->getOrderProcessDetails($arrNewParamList);
                break;
		case 'sendAttachment':
               echo $objAPIProcessor->sendAttachment($arrNewParamList);
		break;
                case 'getCustomerRewards':
                    echo $objAPIProcessor->getCustomerRewards($arrNewParamList);
                break;

                default:
                    echo json_encode(array('code'=>'501', 'message'=>'Requested method is not implemented. Please try again later.'));
                    die;
            }
            $objGeneral->endScript($varToken, $varMethod);
        }
        catch(Exception $e)
        {
            echo json_encode(array('code'=>'500', 'message'=>$e->getMessage()));
            die;
        }
    }
    else
    {
       echo json_encode(array('code'=>'400', 'message'=>'Authorization Token is missing in the request. Please check the code.'));
       die;
    }?>
