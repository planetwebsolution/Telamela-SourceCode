<?php
require_once API_OFFLINE_PATH . 'class_api_processor_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

class apiProcessorCtrl {
    /*
     * Variable declaration begins
     */

    public function __construct() {

        $this->wholesalerID = 0;
        //mail('raju.khatak@mail.vinove.com', 'timeCheck', date(DATE_TIME_FORMAT_DB));
    }

    /**
     * function pageLoads
     *
     * This function Will be called on each page load and will check for any form submission.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $objPage->pageLoad();
     *
     * @access public
     *
     * @return void
     */
    public function pageLoad() { 
        $objAPIProcessor = new APIProcessor();
        $token = ($_REQUEST['token'] <> '') ? $_REQUEST['token'] : $_SERVER['PHP_AUTH_USER'];
        $json_data = urldecode($_REQUEST['json_data']);
        $arrData = json_decode(stripslashes($json_data), true);
        if ($arrData['method'] == 'loginWholesaler') {
            $arrRes = $this->getResponse($arrData);
        } else {      	
            if ($this->validToken($token)) {
                if ($this->validRequest($arrData)) {
                    $arrRes = $this->getResponse($arrData);
                } else {
                    $arrRes['response'] = $this->getInvalidRequestMsg();
                }
                // $arrRes['response'] = $this->getSuccessMsg();
                //$arrRes['data'] = array('hi');
            } else {
                $arrRes['response'] = $this->getInvalidTokenMsg();
            }
        }
        return $arrRes;
    }

    /**
     * function validToken
     *
     * This function Will validate taken.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $this->validToken();
     *
     * @access private
     *
     * @parameters 1 $token
     *
     * @return boolean
     */
    private function validToken($token = '') {
        if (trim($token) <> '') {
            $objAPIProcessor = new APIProcessor();

            $this->wholesalerID = $objAPIProcessor->getuserId($token);

            if ($this->wholesalerID > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * function validRequest
     *
     * This function Will validate request data.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $this->validRequest();
     *
     * @access private
     *
     * @parameters 1 $arrRequest
     *
     * @return boolean
     */
    private function validRequest($arrRequest = '') {
        return ($arrRequest === null || $arrRequest === false || $arrRequest['method'] == '') ? false : true;
    }

    /**
     * function getInvalidTokenMsg
     *
     * This function Will return error message.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $this->getInvalidTokenMsg();
     *
     * @access private
     *
     * @parameters none
     *
     * @return array
     */
    private function getInvalidTokenMsg() {
        return array('code' => '400', 'status' => 'error', 'message' => 'Authorization Token is missing in the request. Please check the code.');
    }

    /**
     * function getInvalidRequestMsg
     *
     * This function Will return error message.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $this->getInvalidRequestMsg();
     *
     * @access private
     *
     * @parameters none
     *
     * @return array
     */
    public function getInvalidRequestMsg($token) {
        return array('code' => '400', 'status' => 'error', 'message' => 'Failed loading JSON. Special characters must not be included in the request. Please check the requested JSON.');
    }

    /**
     * function getInvalidMethodMsg
     *
     * This function Will return error message.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $this->getInvalidMethodMsg();
     *
     * @access private
     *
     * @parameters none
     *
     * @return array
     */
    private function getInvalidMethodMsg($token) {
        return array('code' => '501', 'status' => 'error', 'message' => 'Requested method is not valid.');
    }

    /**
     * function getSuccessMsg
     *
     * This function Will return success message.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $this->getSuccessMsg();
     *
     * @access private
     *
     * @parameters none
     *
     * @return array
     */
    private function getSuccessMsg($token) {
        return array('code' => '200', 'status' => 'success', 'message' => 'Successful');
    }

    /**
     * function getResponse
     *
     * This function will check request method and return response data.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $this->getResponse();
     *
     * @access private
     *
     * @parameters 1 $arrRequest
     *
     * @return array
     */
    private function getResponse($arrRequest) {
        $objAPIProcessor = new APIProcessor($this->wholesalerID);
        $method = $arrRequest['method'];

        $arrRes['response'] = $this->getSuccessMsg();


        switch ($method) {
            case 'loginWholesaler';
                $arrRes['data'] = $objAPIProcessor->loginWholesaler($arrRequest);
                break;
            /**  ONE TIME SYNC TO LOCAL / DATA ADD TO LOCAL  **/
            case 'getCategories';
                $arrRes['data'] = $objAPIProcessor->getCategories($arrRequest);
                break;
            case 'getAttributes';
                $arrRes['data'] = $objAPIProcessor->getAttributes($arrRequest);
                break;
            case 'getAttributesToCategory';
                $arrRes['data'] = $objAPIProcessor->getAttributesToCategory($arrRequest);
                break;
            case 'getAttributesToOption';
                $arrRes['data'] = $objAPIProcessor->getAttributesToOption($arrRequest);
                break;
            case 'getCountries';
                $arrRes['data'] = $objAPIProcessor->getCountries($arrRequest);
                break;
            case 'getRegions';
                $arrRes['data'] = $objAPIProcessor->getRegions($arrRequest);
                break;
            case 'getFestival';
                $arrRes['data'] = $objAPIProcessor->getFestival($arrRequest);
                break;     
            case 'getShippingGateways';
                $arrRes['data'] = $objAPIProcessor->getShippingGateways($arrRequest);
                break;
            
            case 'getShippingToWholesaler';
                $arrRes['data'] = $objAPIProcessor->getShippingToWholesaler($arrRequest);
                break;
           /**  ONE TIME SYNC TO LOCAL / DATA ADD TO LOCAL  **/
                
           
           /**  ONE TIME SYNC TO LOCAL  **/
            case 'getPackage';
                $arrRes['data'] = $objAPIProcessor->getPackage($arrRequest);
                break;
            case 'getProducts';
                $arrRes['data'] = $objAPIProcessor->getProducts($arrRequest);
                break;
            case 'getProductImages';
                $arrRes['data'] = $objAPIProcessor->getProductImages($arrRequest);
                break;
            case 'getProductOptionInventory';
                $arrRes['data'] = $objAPIProcessor->getProductOptionInventory($arrRequest);
                break;
            case 'getProductToOption';
                $arrRes['data'] = $objAPIProcessor->getProductToOption($arrRequest);
                break;            
            case 'getSpecialApplication';
                $arrRes['data'] = $objAPIProcessor->getSpecialApplication($arrRequest);
                break;
            case 'getSpecialApplicationToCategory';
                $arrRes['data'] = $objAPIProcessor->getSpecialApplicationToCategory($arrRequest);
                break;
            case 'getSpecialProducts';
                $arrRes['data'] = $objAPIProcessor->getSpecialProducts($arrRequest);
                break;
            case 'getProductToPackage';
                $arrRes['data'] = $objAPIProcessor->getProductToPackage($arrRequest);
                break;                
            /**  PRODUCT IMAGE ADD - BOTH SIDE  **/    
            case 'downloadProductImage';
                $arrRes['data'] = $objAPIProcessor->downloadProductImage($arrRequest);
                break;
            case 'downloadPackageImage';
                $arrRes['data'] = $objAPIProcessor->downloadPackageImage($arrRequest);
                break;                        
            case 'uploadProductImagesLocal';                // upload new added product images from local to live
                $arrRes['data'] = $objAPIProcessor->uploadProductImagesLocal($arrRequest);
                break; 
            case 'uploadPackageImagesLocal';                // upload new added package images from local to live
                $arrRes['data'] = $objAPIProcessor->uploadPackageImagesLocal($arrRequest);
                break; 
            /**  PRODUCT IMAGE ADD - BOTH SIDE  **/     
           /**  ONE TIME SYNC TO LOCAL  **/
            
                
           /**  DATA ADD - BOTH SIDE  **/
                
            case 'getAddedPackageLive';				// send live new added packages to local
                $arrRes['data'] = $objAPIProcessor->getAddedPackageLive($arrRequest);
                break;
            case 'sendLiveAddedPackageLocalId';				// get localIDs of recently added packages in local
                $arrRes['data'] = $objAPIProcessor->sendLiveAddedPackageLocalId($arrRequest);
                break;
            case 'sendAddedPackageLocal';				// get local new added packages to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendAddedPackageLocal($arrRequest);
                break;
          

            case 'getAddedSpecialApplicationLive';				// send live added Special application to local
                $arrRes['data'] = $objAPIProcessor->getAddedSpecialApplicationLive($arrRequest);
                break;
            case 'sendLiveAddedSpecialApplicationLocalId';				// get localIDs of recently added Special Application in local
                $arrRes['data'] = $objAPIProcessor->sendLiveAddedSpecialApplicationLocalId($arrRequest);
                break;
            case 'sendAddedSpecialApplicationLocal';				// get local new added special application to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendAddedSpecialApplicationLocal($arrRequest);
                break;
                
                
            case 'getAddedProductLive';				// send live added products to local
                $arrRes['data'] = $objAPIProcessor->getAddedProductLive($arrRequest);
                break;
            case 'sendLiveAddedProductLocalId';				// get localIDs of recently added product in local
                $arrRes['data'] = $objAPIProcessor->sendLiveAddedProductLocalId($arrRequest);
                break;
            case 'sendAddedProductLocal';				// get local new added product to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendAddedProductLocal($arrRequest);
                break;
            case 'getAddedProductToPackageLive';                // get live new added product to package to local
                $arrRes['data'] = $objAPIProcessor->getAddedProductToPackageLive($arrRequest);
                break;
            case 'sendAddedProductToPackageLocal';                // get local new added product to package to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendAddedProductToPackageLocal($arrRequest);
                break; 
            case 'sendAddCategoryToLocal';                // get local new added category to category to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendAddCategoryToLocal($arrRequest);
                break;
            case 'sendAddAttributeToLocal';                // get local new added Attribute to Attribute to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendAddAttributeToLocal($arrRequest);
                break;
            case 'sendAddShippingToLocal';                // get local new added Shipping geteway to Attribute to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendAddShippingToLocal($arrRequest);
                break;
            
            case 'sendLiveAddproductToAttributeOptionsQtyLocalId';                // This function is used to add attribute quantity Local to live database
                $arrRes['data'] = $objAPIProcessor->sendLiveAddproductToAttributeOptionsQtyLocalId($arrRequest);
                break;
            case 'sendLocalAddproductToAttributeOptionsQtyLive';                // This function is used to add attribute quantity Live to local database
                $arrRes['data'] = $objAPIProcessor->sendLocalAddproductToAttributeOptionsQtyLive($arrRequest);
                break;
            case 'sendLiveAttributeOptionsQtySyncSucc';                // This function is used to update product productLastSyncDateTime time
                $arrRes['data'] = $objAPIProcessor->sendLiveAttributeOptionsQtySyncSucc($arrRequest);
                break;
            case 'sendLiveAddproductToAttributeOptionsPriceLocalId';                // get local new added Shipping geteway to Attribute to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendLiveAddproductToAttributeOptionsPriceLocalId($arrRequest);
                break;
             case 'sendLocalAddproductToAttributeOptionsPriceLive';                // get local new added Shipping geteway to Attribute to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendLocalAddproductToAttributeOptionsPriceLive($arrRequest);
                break;
            
            case 'sendLiveToVerifiedReferenceNo';				// get localIDs of recently added packages in local
                $arrRes['data'] = $objAPIProcessor->sendLiveToVerifiedReferenceNo($arrRequest);
                break;
            
            /**  DATA ADD - BOTH SIDE  **/
                
            /**  DATA UPDATE - BOTH SIDE  **/

            case 'getUpdatedPackageLive';                // send live new updated packages to local
                $arrRes['data'] = $objAPIProcessor->getUpdatedPackageLive($arrRequest);
                break;
            case 'sendUpdatedPackageLocal';                // get local new updated packages to live
                $arrRes['data'] = $objAPIProcessor->sendUpdatedPackageLocal($arrRequest);
                break;


            case 'getUpdatedProductLive';                // send live updated products to local
                $arrRes['data'] = $objAPIProcessor->getUpdatedProductLive($arrRequest);
                break;
            case 'sendUpdatedProductLocal';                // get local new updated product to live
                $arrRes['data'] = $objAPIProcessor->sendUpdatedProductLocal($arrRequest);
                break;
            case 'getUpdatedProductToPackageLive';                // get live new added product to package to local
                $arrRes['data'] = $objAPIProcessor->getUpdatedProductToPackageLive($arrRequest);
                break;
            case 'sendUpdatedProductToPackageLocal';                // get local new added product to package to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendUpdatedProductToPackageLocal($arrRequest);
                break;
            case 'sendUpdatedCategoryToLocal';                // get local new added category to category to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendUpdatedCategoryToLocal($arrRequest);
                break;
             case 'sendUpdatedAttributeToLocal';                // get local new added Attribute to Attribute to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendUpdatedAttributeToLocal($arrRequest);
                break;
            case 'sendUpdatedShippingToLocal';                // get local new added Shipping geteway to Attribute to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendUpdatedShippingToLocal($arrRequest);
                break;
            case 'sendUpdatedMarginCostToLocal';                // get local new added Shipping geteway to Attribute to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendUpdatedMarginCostToLocal($arrRequest);
                break;
             case 'sendLiveAddproductToAttributeOptionsQtyLocalId';                // get local new added product attribute option quantity to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendLiveAddproductToAttributeOptionsQtyLocalId($arrRequest);
                break;
            case 'sendLocalAddproductToAttributeOptionsQtyLive';                // get local update product attribute option quantity to local AND return corresponding array as response
                $arrRes['data'] = $objAPIProcessor->sendLocalAddproductToAttributeOptionsQtyLive($arrRequest);
                break;
            case 'sendLiveAddproductToAttributeOptionsPriceLocalId';                // get local new added Shipping geteway to Attribute to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendLiveAddproductToAttributeOptionsPriceLocalId($arrRequest);
                break;
             case 'sendLocalAddproductToAttributeOptionsPriceLive';                // get local new added Shipping geteway to Attribute to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendLocalAddproductToAttributeOptionsPriceLive($arrRequest);
                break;
            case 'updateProductOptionImage';
                $arrRes['data'] = $objAPIProcessor->updateProductOptionImage($arrRequest);
                break;

            /**  DATA UPDATE - BOTH SIDE  **/  

            /**  DATA DELETE - BOTH SIDE  **/
		case 'getDeletedPackageLive';                // send live new Deleted packages to local
                $arrRes['data'] = $objAPIProcessor->getDeletedPackageLive($arrRequest);
                break;
            case 'sendDeletedPackageLocal';                // get local new Deleted packages to live
                $arrRes['data'] = $objAPIProcessor->sendDeletedPackageLocal($arrRequest);
                break;


            case 'getDeletedProductLive';                // send live updated products to local
                $arrRes['data'] = $objAPIProcessor->getDeletedProductLive($arrRequest);
                break;
            case 'sendDeletedProductLocal';                // get local new updated product to live
                $arrRes['data'] = $objAPIProcessor->sendDeletedProductLocal($arrRequest);
                break;   
            case 'sendDeleteCategoryToLocal';                // get local new added category to category to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendDeleteCategoryToLocal($arrRequest);
                break;
            case 'sendDeleteAttributeToLocal';                // get local new added category to category to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendDeleteAttributeToLocal($arrRequest);
                break;
            case 'sendDeleteShippingToLocal';                // get local new added category to category to live AND return corresponding live IDs as response
                $arrRes['data'] = $objAPIProcessor->sendDeleteShippingToLocal($arrRequest);
                break;
            /**  DATA DELETE - BOTH SIDE  **/        

            default:
                $arrRes['response'] = $this->getInvalidMethodMsg();
                break;
        }
        return $arrRes;
    }

}

?>
