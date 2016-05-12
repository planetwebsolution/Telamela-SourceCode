<?php
ob_start();
require_once API_MOBILE_PATH . 'class_api_processor_bll.php';

class apiProcessorCtrl
{
    /*
     * Variable declaration begins
     */

    public function __construct()
    {

        $this->pkCustomerID = 0;
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
//    public function pageLoad() {
//        $objAPIProcessor = new APIProcessor();
//        
//        $token = ($_REQUEST['token'] <> '') ? $_REQUEST['token'] : $_SERVER['PHP_AUTH_USER'];
//        $json_data = urldecode($_REQUEST['json_data']);
//        $arrData = json_decode(stripslashes($json_data), true);
//
//
//        if ($this->validToken($token)) {
//
//            if ($this->validRequest($arrData)) {
//
//                $arrRes = $this->getResponse($arrData);
//            } else {
//                $arrRes['response'] = $this->getInvalidRequestMsg();
//            }
//
//
//            // $arrRes['response'] = $this->getSuccessMsg();
//            //$arrRes['data'] = array('hi');
//        } else {
//            $arrRes['response'] = $this->getInvalidTokenMsg();
//        }
//        return $arrRes;
//    }


    public function pageLoad()
    {
        $objAPIProcessor = new APIProcessor();
        $json_data = urldecode($_REQUEST['json_data']);
        $arrData = json_decode(stripslashes($json_data), true);
        if ($arrData['method'] == 'getLogin' || $arrData['method'] == 'getPassword' || $arrData['method'] == 'registerUser' || $arrData['method'] == 'getCountryList'
                || $arrData['method'] == 'updatePassword' || $arrData['method'] == 'getStaticData' || $arrData['method'] == 'getProducts'
                || $arrData['method'] == 'getProductSize' || $arrData['method'] == 'applyCode' || $arrData['method'] == 'getCategories'
                || $arrData['method'] == 'getCategoryProducts' || $arrData['method'] == 'contactUs' || $arrData['method'] == 'getHotDeals'
                || $arrData['method'] == 'getMostTrending' || $arrData['method'] == 'getRecentlyViewed' || $arrData['method'] == 'getProductDetails'
                || $arrData['method'] == 'getMegaMenu' || $arrData['method'] == 'getParentMenu' || $arrData['method'] == 'getHomeScreenData' || $arrData['method'] == 'getTodayOffer'
                || $arrData['method'] == 'getBestSeller' || $arrData['method'] == 'getSearchResults' || $arrData['method'] == 'getAutoSuggest'
                || $arrData['method'] == 'getFestivalBanner' || $arrData['method'] == 'getProfile' || $arrData['method'] == 'updateprofile'
                || $arrData['method'] == 'cms' || $arrData['method'] == 'getWholeSalerInfo' || $arrData['method'] == 'socialRegisterLogin'
                || $arrData['method'] == 'getRewards' || $arrData['method'] == 'getCreditRewards' || $arrData['method'] == 'getDebitRewards' || $arrData['method'] == 'getWishList' || $arrData['method'] == 'getLatestProducts'
                || $arrData['method'] == 'getCustomerReview' || $arrData['method'] == 'getIphoneMegaMenu' || $arrData['method'] == 'getSupport'
                || $arrData['method'] == 'checkMegaMenuUpdate' || $arrData['method'] == 'cartDetails' || $arrData['method'] == 'savelist' || $arrData['method'] =='wholesalerProducts' || $arrData['method'] =='getAlsoLike' || $arrData['method']=='cartManage' || $arrData['method']=='savelistAdd' || $arrData['method']=='myWishlistDelete' || $arrData['method']=='addWishlist' || $arrData['method']=='delWishlist' || $arrData['method']=='getWishListProductDetails' || $arrData['method']=='getTopRatedById' || $arrData['method']=='getLatestProductByCatId' || $arrData['method']=='getSpecialBanner' || $arrData['method']=='getProductDetailsBySubCat' || $arrData['method']=='clearWishlist' || $arrData['method']=='addCart' || $arrData['method']=='getFilterResults' || $arrData['method']=='addCustomerReview' || $arrData['method']=='getCustomerOrderlist')
        {
            $arrRes = $this->getResponse($arrData);
        }
        else
        {
            $token = (isset($arrData['token'])) ? $arrData['token'] : $_SERVER['PHP_AUTH_USER'];
            if ($this->validToken($token))
            {
                if ($this->validRequest($arrData))
                {
                    $arrRes = $this->getResponse($arrData);
                }
                else
                {
                    $arrRes = $this->getInvalidRequestMsg();
                }


                // $arrRes['response'] = $this->getSuccessMsg();
                //$arrRes['data'] = array('hi');
            }
            else
            {
                $arrRes = $this->getInvalidTokenMsg();
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
//    private function validToken($token) {
//
//        if ($token == 'E567F8D2A42ADC1F1D3FE75A20319B58') {
//            // $this->varAccessType = 'wholesaler';
//            $this->varAccessId = '5';
//
//            return true;
//        } else {
//            return false;
//        }
//    }

    private function validToken($token)
    {

        $objAPIProcessor = new APIProcessor();

        $this->pkCustomerID = $objAPIProcessor->getuserId($token);
        //echo pre($this->pkCustomerID);die;
        if ($this->pkCustomerID > 0)
        {
            return true;
        }
        else
        {
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
    private function validRequest($arrRequest = '')
    {
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
    private function getInvalidTokenMsg()
    {
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
    public function getInvalidRequestMsg($token)
    {
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
    private function getInvalidMethodMsg($token)
    {
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
    private function getSuccessMsg($token)
    {
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
    private function getResponse($arrRequest)
    {
        
        $objAPIProcessor = new APIProcessor($this->pkCustomerID);
        $method = $arrRequest['method'];

        $arrRes['response'] = $this->getSuccessMsg('');

        switch ($method)
        {
            case 'getLogin':
                $arrRes['data'] = $objAPIProcessor->login($arrRequest);
                break;
            case 'getPassword';
                $arrRes['data'] = $objAPIProcessor->getPassword($arrRequest);
                break;
            case 'registerUser';
                $arrRes['data'] = $objAPIProcessor->registerUser($arrRequest);
                break;
            case 'socialRegisterLogin';
                $arrRes['data'] = $objAPIProcessor->socialRegisterLogin($arrRequest);
                break;
            case 'updatePassword';
                $arrRes['data'] = $objAPIProcessor->updatePassword($arrRequest);
                break;
            case 'getStaticData';
                $arrRes['data'] = $objAPIProcessor->getStaticData($arrRequest);
                break;
            case 'getProducts';
                $arrRes['data'] = $objAPIProcessor->getProducts($arrRequest);
                break;
            case 'getProductSize';
                $arrRes['data'] = $objAPIProcessor->getProductSize($arrRequest);
                break;
            case 'getCustomerReview';
                $arrRes['data'] = $objAPIProcessor->getCustomerReview($arrRequest);
                break;
            case 'applyCode';
                $arrRes['data'] = $objAPIProcessor->applyCode($arrRequest);
                break;
            case 'getCategories';
                $arrRes['data'] = $objAPIProcessor->getCategories($arrRequest);
                break;
            case 'getCategoryProducts';
                $arrRes['data'] = $objAPIProcessor->getCategoryProducts($arrRequest);
                break;
            case 'getWishList';
                $arrRes['data'] = $objAPIProcessor->getWishList($arrRequest);
                break;
            case 'contactUs';
                $arrRes['data'] = $objAPIProcessor->contactUs($arrRequest);
                break;
            case 'getRewards';
                $arrRes['data'] = $objAPIProcessor->getRewards($arrRequest);
                break;
            case 'getCreditRewards';
                $arrRes['data'] = $objAPIProcessor->getCreditRewards($arrRequest);
                break;
            case 'getDebitRewards';
                $arrRes['data'] = $objAPIProcessor->getDebitRewards($arrRequest);
                break;
            case 'getProfile';
                $arrRes['data'] = $objAPIProcessor->getProfile($arrRequest);
                break;
            case 'updateprofile';
                $arrRes['data'] = $objAPIProcessor->updateprofile($arrRequest);
                break;
            case 'getHotDeals';
                $arrRes['data'] = $objAPIProcessor->getHotDeals($arrRequest);
                break;
            case 'getMostTrending';
                $arrRes['data'] = $objAPIProcessor->getMostTrending($arrRequest);
                break;
            case 'getRecentlyViewed';
                $arrRes['data'] = $objAPIProcessor->getRecentlyViewed($arrRequest);
                break;
            case 'getFestivalBanner';
                $arrRes['data'] = $objAPIProcessor->getFestivalBanner($arrRequest);
                break;
            case 'myorders';
                $arrRes['data'] = $objAPIProcessor->myorders($arrRequest);
                break;
            case 'makeReview';
                $arrRes['data'] = $objAPIProcessor->makeReview($arrRequest);
                break;
            case 'makeOrder';
                $arrRes['data'] = $objAPIProcessor->makeOrder($arrRequest);
                break;
            case 'getProductDetails';
                $arrRes['data'] = $objAPIProcessor->getProductDetails($arrRequest);
                break;
            case 'getMegaMenu';
                $arrRes['data'] = $objAPIProcessor->getMegaMenu($arrRequest);
                break;
            case 'getParentMenu';
                $arrRes['data'] = $objAPIProcessor->getParentMenu($arrRequest);
                break;
            case 'getHomeScreenData';
                $arrRes['data'] = $objAPIProcessor->getHomeScreenData($arrRequest);
                break;
            case 'getTodayOffer';
                $arrRes['data'] = $objAPIProcessor->getTodayOffer($arrRequest);
                break;
            case 'getBestSeller';
                $arrRes['data'] = $objAPIProcessor->getBestSeller($arrRequest);
                break;
            case 'getSearchResults';
                $arrRes['data'] = $objAPIProcessor->getSearchResults($arrRequest);
                break;
            case 'getAutoSuggest';
                $arrRes['data'] = $objAPIProcessor->getAutoSuggest($arrRequest);
                break;
            case 'cms';
                $arrRes['data'] = $objAPIProcessor->cms($arrRequest);
                break;
            case 'getWholeSalerInfo';
                $arrRes['data'] = $objAPIProcessor->getWholeSalerInfo($arrRequest);
                break;
            case 'getCountryList';
                $arrRes['data'] = $objAPIProcessor->getCountryList($arrRequest);
                break;
            case 'getLatestProducts';
                $arrRes['data'] = $objAPIProcessor->getLatestProducts($arrRequest);
                break;
            case 'getIphoneMegaMenu';
                $arrRes['data'] = $objAPIProcessor->getIphoneMegaMenu($arrRequest);
                break;
            case 'getSupport';
                $arrRes['data'] = $objAPIProcessor->getSupport($arrRequest);
                break;
            case 'checkMegaMenuUpdate';
                $arrRes['data'] = $objAPIProcessor->checkMegaMenuUpdate($arrRequest);
                break;
            case 'cartDetails';
                $arrRes['data'] = $objAPIProcessor->cartDetails($arrRequest);
                break;
            case 'savelist';
                $arrRes['data'] = $objAPIProcessor->savelist($arrRequest);
                break;
            case 'wholesalerProducts';
                $arrRes['data'] = $objAPIProcessor->wholesalerProducts($arrRequest);
                break;
            case 'getAlsoLike';
                $arrRes['data'] = $objAPIProcessor->getAlsoLike($arrRequest);
                break;
            case 'cartManage';
                $arrRes['data'] = $objAPIProcessor->cartManage($arrRequest);
                break;
            case 'savelistAdd';
                $arrRes['data'] = $objAPIProcessor->savelistAdd($arrRequest);
                break;
            case 'myWishlistDelete';
                $arrRes['data'] = $objAPIProcessor->myWishlistDelete($arrRequest);
                break;
            case 'addWishlist';
                $arrRes['data'] = $objAPIProcessor->addWishlist($arrRequest);
                break;
            case 'delWishlist';
                $arrRes['data'] = $objAPIProcessor->delWishlist($arrRequest);
                break;
            case 'getWishListProductDetails';
                $arrRes['data'] = $objAPIProcessor->getWishListProductDetails($arrRequest);
                break;
            case 'getTopRatedById';
                $arrRes['data'] = $objAPIProcessor->getTopRatedById($arrRequest);
                break;
            case 'getLatestProductByCatId';
                $arrRes['data'] = $objAPIProcessor->getLatestProductByCatId($arrRequest);
                break;
            case 'getSpecialBanner';
                $arrRes['data'] = $objAPIProcessor->getSpecialBanner($arrRequest);
                break;
            case 'getProductDetailsBySubCat';
                $arrRes['data'] = $objAPIProcessor->getProductDetailsBySubCat($arrRequest);
                break;
            case 'clearWishlist';
                $arrRes['data'] = $objAPIProcessor->clearWishlist($arrRequest);
                break;
            case 'addCart';
                $arrRes['data'] = $objAPIProcessor->addCart($arrRequest);
                break;
            case 'getFilterResults';
                $arrRes['data'] = $objAPIProcessor->getFilterResults($arrRequest);
                break;
            case 'addCustomerReview';
                $arrRes['data'] = $objAPIProcessor->addCustomerReview($arrRequest);
                break;
            case 'getCustomerOrderlist';
                $arrRes['data'] = $objAPIProcessor->getCustomerOrderlist($arrRequest);
                break;
            
            
            default:
                $arrRes = $this->getInvalidMethodMsg();
                break;
        }
        return $arrRes;
    }

}

?>
