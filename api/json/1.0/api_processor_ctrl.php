<?php

require_once API_PATH . 'class_api_processor_bll.php';

class apiProcessorCtrl {
    /*
     * Variable declaration begins
     */
    
    public function __construct() {
        
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
    private function validToken($token) {

        if ($token == 'E567F8D2A42ADC1F1D3FE75A20319B58') {
            // $this->varAccessType = 'wholesaler';
            $this->varAccessId = '5';

            return true;
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
        $objAPIProcessor = new APIProcessor();
        $method = $arrRequest['method'];        

        $arrRes['response'] = $this->getSuccessMsg();

        switch ($method) {
            case 'getProducts';
                $arrRes['data'] = $objAPIProcessor->getProducts($arrRequest);
                break;
            case 'getAllCategories';                
                $arrRes['data'] = $objAPIProcessor->getCategories($arrRequest);
                break;
            case 'getChildCategories';                
                $arrRes['data'] = $objAPIProcessor->getCategories($arrRequest);
                break;
            case 'getCategoryByID';                
                $arrRes['data'] = $objAPIProcessor->getCategories($arrRequest);
                break;
             case 'getAllAttributes';                
                $arrRes['data'] = $objAPIProcessor->getCategories($arrRequest);
                break;
            
            
            default:
                $arrRes['response'] = $this->getInvalidMethodMsg();
                break;
        }
        return $arrRes;
    }

}

?>
