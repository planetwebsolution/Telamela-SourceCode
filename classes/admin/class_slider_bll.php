<?php

/**
 * Site Slider Class
 *
 * This is the Slider class that will used on website for backend to manage homepage banner.
 *
 * DateCreated 20th Jan, 2014
 *
 * DateLastModified 20th Jan, 2014
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class Slider extends Database {

    /**
     * function countryList
     *
     * This function is used to retrive country List.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function getCountry() {
        $arrClms = array(
            'country_id',
            'name',
        );
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms);
        return $arrRes;
    }

    /**
     * function sliderCountList
     *
     * This function is used to count number of rows.
     *
     * Database Tables used in this function are : tbl_home_banner, tbl_festival
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function sliderCountList($argWhere = '', $argLimit = '') {
        $varTable = TABLE_HOME_BANNER . " LEFT JOIN " . TABLE_FESTIVAL . " as f ON fkFestivalID = pkFestivalID";
        $varNum = $this->getNumRows($varTable, 'pkBannerID', $argWhere);
        return $varNum;
    }

    /**
     * function sliderList
     *
     * This function is used to retrive slider List.
     *
     * Database Tables used in this function are : tbl_home_banner, tbl_festival
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function sliderList($argWhere = '', $argLimit = '') {
        $arrClms = array('pkBannerID', 'fkFestivalID', 'FestivalTitle', 'f.CountryIDs', 'BannerTitle', 'BannerOrder', 'BannerStatus', 'BannerStartDate', 'BannerEndDate');
        $this->getSortColumn($_REQUEST);

        $varTable = TABLE_HOME_BANNER . " LEFT JOIN " . TABLE_FESTIVAL . " as f ON fkFestivalID = pkFestivalID";
        $varWhere = "1 " . $argWhere;

        $arrRes = $this->select($varTable, $arrClms, $varWhere, $this->orderOptions, $argLimit);


        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function addSlider
     *
     * This function is used to insert the Home page slider deatails.
     *
     * Database Tables used in this function are : tbl_home_banner, tbl_home_banner_links
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string $arrAddID
     *
     * User instruction: $objSlider->addSlider($arrPost)
     */
    function addSlider($arrPost) {
        global $objCore;

        $arrClms = array(
            'CountryIDs' => $arrPost['frmCountry'],
            'fkFestivalID' => $arrPost['frmFestival'],
            'BannerTitle' => $arrPost['frmTitle'],
            'BannerImageName' => $arrPost['frmImageName'],
            'BannerOrder' => $arrPost['frmBannerOrder'],
            'BannerStatus' => $arrPost['frmStaus'],
            'BannerStartDate' => $objCore->serverDateTime($arrPost['frmDateStart'], DATE_TIME_FORMAT_DB),
            'BannerEndDate' => $objCore->serverDateTime($arrPost['frmDateEnd'], DATE_TIME_FORMAT_DB),
            'BannerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );

        $arrAddID = $this->insert(TABLE_HOME_BANNER, $arrClms);
        if ($arrAddID > 0) {
            foreach ($arrPost['frmCoOrdinates'] as $key => $val) {

                //$CategoryIds = implode(',', $arrPost['frmCategoryId'][$key]);

                echo $varLinkUrl = $arrPost['frmUrl'][$key];

                $arrClms = array(
                    'fkBannerID' => $arrAddID,
                    'UrlLinks' => $varLinkUrl,
                    'Offer' => $arrPost['frmOffer'][$key],
                    'linkImagePosition' => $val
                );

                $this->insert(TABLE_HOME_BANNER_LINKS, $arrClms);
            }
        }
        return $arrAddID;
    }

    /**
     * function getSliderDetail
     *
     * This function is used to get Slider Details.
     *
     * Database Tables used in this function are : tbl_home_banner, tbl_home_banner_links
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objSlider->getSliderDetail($argID)
     */
    function getSliderDetail($argID) {
        $varWhr = 'pkBannerID =' . $argID;
        $arrClms = array('pkBannerID', 'fkFestivalID', 'CountryIDs', 'BannerTitle', 'BannerImageName', 'BannerOrder', 'BannerStatus', 'BannerStartDate', 'BannerEndDate');
        $arrRes = $this->select(TABLE_HOME_BANNER, $arrClms, $varWhr);

        $varWhr1 = 'fkBannerID =' . $argID;
        $arrClms1 = array('pkBannerLinkID', 'LinkType', 'UrlLinks', 'Offer', 'linkImagePosition');
        $arrRes1 = $this->select(TABLE_HOME_BANNER_LINKS, $arrClms1, $varWhr1);
        $arrRes[0]['arrLinks'] = $arrRes1;
        return $arrRes;
    }

    /**
     * function updateSlider
     *
     * This function is used to update the update Slider deatails.
     *
     * Database Tables used in this function are : tbl_home_banner, tbl_home_banner_links
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objSlider->updateSlider($arrPost)
     */
    function updateSlider($arrPost) {
        global $objCore;

        $varWhr = 'pkBannerID = ' . $_GET['id'];

        $arrClms = array(
            'fkFestivalID' => $arrPost['frmFestival'],
            'CountryIDs' => $arrPost['frmCountry'],
            'BannerTitle' => $arrPost['frmTitle'],
            'BannerImageName' => $arrPost['frmImageName'],
            'BannerOrder' => $arrPost['frmBannerOrder'],
            'BannerStatus' => $arrPost['frmStaus'],
            'BannerStartDate' => $objCore->serverDateTime($arrPost['frmDateStart'], DATE_TIME_FORMAT_DB),
            'BannerEndDate' => $objCore->serverDateTime($arrPost['frmDateEnd'], DATE_TIME_FORMAT_DB)
        );

        $this->update(TABLE_HOME_BANNER, $arrClms, $varWhr);

        $varWhere = "fkBannerID = '" . $_GET['id'] . "'";
        $this->delete(TABLE_HOME_BANNER_LINKS, $varWhere);

        foreach ($arrPost['frmCoOrdinates'] as $key => $val) {
            //$CategoryIds = implode(',', $arrPost['frmCategoryId'][$key]);
            $varLinkUrl = $arrPost['frmUrl'][$key];

            $arrClms = array(
                'fkBannerID' => $_GET['id'],
                'UrlLinks' => $varLinkUrl,
                'Offer' => $arrPost['frmOffer'][$key],
                'linkImagePosition' => $val
            );

            $this->insert(TABLE_HOME_BANNER_LINKS, $arrClms);
        }
        return 1;
    }

    /**
     * function updateBannerStatus
     *
     * This function is used to update banner status.
     *
     * Database Tables used in this function are : tbl_home_banner
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrUpdateID
     *
     * User instruction: $objSlider->updateBannerStatus($argPost)
     */
    function updateBannerStatus($argPost) {

        $varWhr = 'pkBannerID = ' . $argPost['bid'];
        $arrClms = array('BannerStatus' => $argPost['status']);
        $arrUpdateID = $this->update(TABLE_HOME_BANNER, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function removeAllSlider
     *
     * This function is used to remove the home banner..
     *
     * Database Tables used in this function are : tbl_home_banner, tbl_home_banner_links
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string true
     *
     * User instruction: $objSlider->removeAllSlider($argPostIDs)
     */
    function removeSlider($argPostIDs) {
        $varWhere = "pkBannerID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_HOME_BANNER, $varWhere);
        $varWhere = "fkBannerID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_HOME_BANNER_LINKS, $varWhere);
        return true;
    }

    /**
     * function removeAllSlider
     *
     * This function is used to remove the home banner..
     *
     * Database Tables used in this function are : tbl_home_banner, tbl_home_banner_links
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string true
     *
     * User instruction: $objSlider->removeAllSlider($argPostIDs)
     */
    function removeAllSlider($argPostIDs) {
        foreach ($argPostIDs['frmID'] as $valDeleteID) {
            $varWhere = "pkBannerID = '" . $valDeleteID . "'";
            $this->delete(TABLE_HOME_BANNER, $varWhere);
            $varWhere = "fkBannerID = '" . $valDeleteID . "'";
            $this->delete(TABLE_HOME_BANNER_LINKS, $varWhere);
        }
        return true;
    }

    /**
     * function getSortColumn
     *
     * This function is used to sort column.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string true
     *
     * User instruction: $objSlider->getSortColumn($argPostIDs)
     */
    function getSortColumn($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
//        if ($argVarSortOrder['orderBy'] == '') {
//            $varOrderBy = 'DESC';
//        } else {
//            $varOrderBy = $argVarSortOrder['orderBy'];
//        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'BannerOrder ASC';
        } else {
            $varSortBy = $argVarSortOrder['sortBy'];
        }
        //Create sort class object
        $objOrder = new CreateOrder($varSortBy, $varOrderBy);
        unset($argVarSortOrder['PHPSESSID']);
        //This function return  query  string. When we will array.
        $varQryStr = $objCore->sortQryStr($argVarSortOrder, $varOrderBy, $varSortBy);
        //print_r($varQryStr);
        //Pass query string in extra function for add in sorting
        $objOrder->extra($varQryStr);
        //Prepage sorting heading
        $objOrder->append(' ');
        $objOrder->addColumn('Banner Title', 'BannerTitle', '', '');
        $objOrder->addColumn('Start Date', 'BannerStartDate', '', 'hidden-480');
        $objOrder->addColumn('End Date', 'BannerEndDate', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    function getsliderorderno($orderno) {
        $varTable = TABLE_HOME_BANNER;
        $argWhere = "BannerOrder ='" . $orderno . "'";
        //pre($argWhere);

        $arrClms1 = array(
            'BannerOrder'
        );

        $arrRes1 = $this->select($varTable, $arrClms1, $argWhere);

        if (count($arrRes1) == 0) {
            return 1;
        } else {
            return 0;
        }
    }
    
    function getsliderordercheck($orderno,$orderid)
    {
         $varTable = TABLE_HOME_BANNER;
         $arrClms1 = array('pkBannerID', 'BannerOrder');
            $argWhere = "pkBannerID ='" . $orderid . "' and BannerOrder='" . $orderno . "'";

        $arrRes1 = $this->select($varTable, $arrClms1, $argWhere);

        if (count($arrRes1) == 0) {
            return 1;
        } else {
            return 0;
        }
        
    }

    /**
     * function editCategory
     *
     * This function is used to update order.
     *
     * Database Tables used in this function are : tbl_home_banner
     *
     * @access public
     *
     * @parameters 1 string, string(optional)
     *
     * @return string $stringMessage
     */
    function updateOrder($argPost) {
        //  pre($argPost);

        $message_order = array();
        $count = 0;
        $count1 = 0;
        // pre($argPost);
        foreach ($argPost['order'] as $key => $valOrder) {
            // $valOrder;
            // $argPost['orderId'][$key];
            $varTable = TABLE_HOME_BANNER;
            $arrClms = array('pkBannerID', 'BannerOrder');
            $argWhere = "pkBannerID ='" . $argPost['orderId'][$key] . "' and BannerOrder='" . $valOrder . "'";
            $arrRes = $this->select($varTable, $arrClms, $argWhere);
//            echo $key;
//            echo count($arrRes);
            if (count($arrRes) == 0) {

                $varTable = TABLE_HOME_BANNER;
                $argWhere = "BannerOrder ='" . $valOrder . "'";
                //pre($argWhere);
                $argWhere1 = "pkBannerID ='" . $argPost['orderId'][$key] . "'";
                $arrClms1 = array(
                    'BannerOrder'
                );
                $arrClms2 = array(
                    'BannerOrder' => $valOrder
                );

                $arrRes1 = $this->select($varTable, $arrClms1, $argWhere);

                if (count($arrRes1) == 0) {
                    $this->update($varTable, $arrClms2, $argWhere1);
                    $message_order['success'][$count] = $valOrder;
                    $count++;
                } else {
                    $message_order['error'][$count1] = $valOrder;
                    $count1++;
                }
            }
        }

        //return true;
        return $message_order;






//        $count = 0;
//        foreach ($argPost['order'] as $valOrder) {
//            $argWhere = "pkBannerID ='" . $argPost['orderId'][$count] . "'";
//            $arrClms = array(
//                'BannerOrder' => $valOrder
//            );
//            $varTable = TABLE_HOME_BANNER;
//            $this->update($varTable, $arrClms, $argWhere);
//            $count++;
//        }
//        return true;
    }

    function checkOrdersequesce($argPost) {
        $count = 0;
        //pre($argPost);
        foreach ($argPost['order'] as $key => $valOrder) {
            // $valOrder;
            // $argPost['orderId'][$key];
            $varTable = TABLE_HOME_BANNER;
            $arrClms = array('pkBannerID', 'BannerOrder');
            $argWhere = "pkBannerID ='" . $argPost['orderId'][$key] . "' and BannerOrder='" . $valOrder . "'";
            $arrRes = $this->select($varTable, $arrClms, $argWhere);
            if (count($arrRes) == 0) {

                $varTable = TABLE_HOME_BANNER;
                $argWhere = "BannerOrder ='" . $valOrder . "'";
                $arrClms1 = array(
                    'BannerOrder'
                );

                $arrRes1 = $this->select($varTable, $arrClms1, $argWhere);
                if (count($arrRes1) > 0) {
                    return false;
                } else {
                    return true;
                }
            }

            //  return true;
        }
//        foreach ($argPost['order'] as $valOrder) {
//
//            $varTable = TABLE_HOME_BANNER;
//            $arrClms = array('pkBannerID', 'BannerOrder');
//            $argWhere = "pkBannerID ='" . $argPost['orderId'][$count] . "' and BannerOrder='" . $valOrder . "'";
//            $arrRes = $this->select($varTable, $arrClms, $argWhere);
//           // pre($arrRes);
//            if (empty($arrRes)) {
//               // continue;
//                $varTable = TABLE_HOME_BANNER;
//                $argWhere = "BannerOrder ='" . $valOrder . "'";
//                $arrClms1 = array(
//                    'BannerOrder'
//                );
//
//                $arrRes1 = $this->select($varTable, $arrClms1, $argWhere);
//                //pre($arrRes1);
//                if (!empty($arrRes1)) {
//                    //echo 'here';
//                   return false;
//                } else {
//                  // echo 'there';
//                    return true;
//                    
//                }
//            } 
//            
////            else {
////                echo "there";
//////                $varTable = TABLE_HOME_BANNER;
//////                $argWhere = "BannerOrder ='" . $valOrder . "'";
//////                $arrClms1 = array(
//////                    'BannerOrder'
//////                );
//////
//////                $arrRes1 = $this->select($varTable, $arrClms1, $argWhere);
//////                //pre($arrRes1);
//////                if (!empty($arrRes1)) {
//////                    echo $argPost['orderId'][$count].'if';
//////                  // return false;
//////                } else {
//////                    echo $argPost['orderId'][$count];
//////                   // return true;
//////                    
//////                }
////            }
//            //echo "here";
//            //$this->update($varTable, $arrClms, $argWhere);
//            $count++;
//        }
        //return true;
    }

    /**
     * function bannerCountList
     *
     * This function is used to count number of rows.
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function bannerCountList($argWhere = '', $argLimit = '') {
        $varTable = TABLE_BANNER;
        $varNum = $this->getNumRows($varTable, 'pkBannerID', $argWhere);
        return $varNum;
    }

    /**
     * function bannerList
     *
     * This function is used to retrive banner List.
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function bannerList($argWhere = '', $argLimit = '') {
        $arrClms = array('pkBannerID', 'BannerPage', 'BannerTitle', 'BannerOrder', 'BannerStatus', 'BannerStartDate', 'BannerEndDate');
        $this->getSortColumnBanner($_REQUEST);

        $varTable = TABLE_BANNER;
        $varWhere = "1 " . $argWhere;

        $arrRes = $this->select($varTable, $arrClms, $varWhere, $this->orderOptions, $argLimit);


        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getSortColumnBanner
     *
     * This function is used to sort column.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string true
     *
     * User instruction: $objSlider->getSortColumnBanner($argVarSortOrder)
     */
    function getSortColumnBanner($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
//        if ($argVarSortOrder['orderBy'] == '') {
//            $varOrderBy = 'DESC';
//        } else {
//            $varOrderBy = $argVarSortOrder['orderBy'];
//        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            //$varSortBy = 'pkBannerID';
            $varSortBy = 'BannerOrder ASC';
        } else {
            $varSortBy = $argVarSortOrder['sortBy'];
        }
        //Create sort class object
        $objOrder = new CreateOrder($varSortBy, $varOrderBy);
        unset($argVarSortOrder['PHPSESSID']);
        //This function return  query  string. When we will array.
        $varQryStr = $objCore->sortQryStr($argVarSortOrder, $varOrderBy, $varSortBy);
        //print_r($varQryStr);
        //Pass query string in extra function for add in sorting
        $objOrder->extra($varQryStr);
        //Prepage sorting heading
        $objOrder->append(' ');
        $objOrder->addColumn('Banner Title', 'BannerTitle');
        $objOrder->addColumn('Banner Page', 'BannerPage', '', 'hidden-480');
        $objOrder->addColumn('Start Date', 'BannerStartDate', '', 'hidden-480');
        $objOrder->addColumn('End Date', 'BannerEndDate', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function addBanner
     *
     * This function is used to insert the Home page slider deatails.
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string $arrAddID
     *
     * User instruction: $objSlider->addBanner($arrPost)
     */
    function addBanner($arrPost) {
        global $objCore;

        $arrClms = array(
            'BannerPage' => $arrPost['frmBannerPage'],
            'BannerTitle' => $arrPost['frmTitle'],
            'BannerImageName' => $arrPost['frmImageName'],
            'UrlLinks' => $arrPost['frmLink'],
            'BannerOrder' => $arrPost['frmBannerOrder'],
            'BannerStatus' => $arrPost['frmStaus'],
            'fkCategoryId' => $arrPost['frmCategoryId'],
            'BannerStartDate' => $objCore->serverDateTime($arrPost['frmDateStart'], DATE_TIME_FORMAT_DB),
            'BannerEndDate' => $objCore->serverDateTime($arrPost['frmDateEnd'], DATE_TIME_FORMAT_DB),
            'BannerDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );

        //pre($arrClms);
        $varTable = TABLE_BANNER;
        $arrClms1 = array(
            'BannerOrder'
        );
        $argWhere1 = "BannerOrder ='" . $arrPost['frmBannerOrder'] . "'";
        $arrRes = $this->select($varTable, $arrClms1, $argWhere1);
        if (count($arrRes) == 0) {
            $arrAddID = $this->insert(TABLE_BANNER, $arrClms);
            return $arrAddID;
        } else {
            return 'error';
        }
    }

    /**
     * function getBannerDetail
     *
     * This function is used to get Slider Details.
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objSlider->getSliderDetail($argID)
     */
    function getBannerDetail($argID) {
        $varWhr = 'pkBannerID =' . $argID;
        $arrClms = array('pkBannerID', 'fkCategoryId', 'BannerPage', 'BannerTitle', 'BannerImageName', 'UrlLinks', 'BannerOrder', 'BannerStatus', 'BannerStartDate', 'BannerEndDate');
        $arrRes = $this->select(TABLE_BANNER, $arrClms, $varWhr);

        return $arrRes;
    }

    /**
     * function updateBanner
     *
     * This function is used to update the update banner deatails.
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objSlider->updateSlider($arrPost)
     */
    function updateBanner($arrPost) {
        global $objCore;

        $varWhr = 'pkBannerID = ' . $_GET['id'];

        $arrClms = array(
            'fkCategoryId' => $arrPost['frmCategoryId'],
            'BannerPage' => $arrPost['frmBannerPage'],
            'BannerTitle' => $arrPost['frmTitle'],
            'BannerImageName' => $arrPost['frmImageName'],
            'UrlLinks' => $arrPost['frmLink'],
            'BannerOrder' => $arrPost['frmBannerOrder'],
            'BannerStatus' => $arrPost['frmStaus'],
            'BannerStartDate' => $objCore->serverDateTime($arrPost['frmDateStart'], DATE_TIME_FORMAT_DB),
            'BannerEndDate' => $objCore->serverDateTime($arrPost['frmDateEnd'], DATE_TIME_FORMAT_DB)
        );
        
        $varTable = TABLE_BANNER;
        $arrClmst = array('pkBannerID', 'BannerOrder');
        $argWheret = "pkBannerID ='" . $_GET['id'] . "' and BannerOrder='" . $arrPost['frmBannerOrder'] . "'";
        $arrRes = $this->select($varTable, $arrClmst, $argWheret);
//            echo $key;
//            echo count($arrRes);
        if (count($arrRes) == 0) {
              $varTable = TABLE_BANNER;
        $arrClms1 = array(
            'BannerOrder'
        );
        $argWhere1 = "BannerOrder ='" . $arrPost['frmBannerOrder'] . "'";
        $arrRes = $this->select($varTable, $arrClms1, $argWhere1);
        if (count($arrRes) == 0) {
            $this->update(TABLE_BANNER, $arrClms, $varWhr);
            return 1;
        } else {
            return 2;
        }

           
        }
        else
        {
           $this->update(TABLE_BANNER, $arrClms, $varWhr);
            return 1; 
        }
//        $varTable = TABLE_BANNER;
//        $arrClms1 = array(
//            'BannerOrder'
//        );
//        $argWhere1 = "BannerOrder ='" . $arrPost['frmBannerOrder'] . "'";
//        $arrRes = $this->select($varTable, $arrClms1, $argWhere1);
//        if (count($arrRes) == 0) {
//            $this->update(TABLE_BANNER, $arrClms, $varWhr);
//            return 1;
//        } else {
//            return 2;
//        }
//        pre($arrClms);
//        $this->update(TABLE_BANNER, $arrClms, $varWhr);
//
//        return 1;
    }

    /**
     * function updateStatus
     *
     * This function is used to update banner status.
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrUpdateID
     *
     * User instruction: $objSlider->updateStatus($argPost)
     */
    function updateStatus($argPost) {

        $varWhr = 'pkBannerID = ' . $argPost['bid'];
        $arrClms = array('BannerStatus' => $argPost['status']);
        $arrUpdateID = $this->update(TABLE_BANNER, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function updateBannerOrder
     *
     * This function is used to update banner order.
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 1 string, string(optional)
     *
     * @return string $stringMessage
     */
    function updateBannerOrder($argPost) {
        $message_order = array();
        $count = 0;
        $count1 = 0;
        foreach ($argPost['order'] as $key => $valOrder) {
            // $valOrder;
            // $argPost['orderId'][$key];
            $varTable = TABLE_BANNER;
            $arrClms = array('pkBannerID', 'BannerOrder');
            $argWhere = "pkBannerID ='" . $argPost['orderId'][$key] . "' and BannerOrder='" . $valOrder . "'";
            $arrRes = $this->select($varTable, $arrClms, $argWhere);
//            echo $key;
//            echo count($arrRes);
            if (count($arrRes) == 0) {

                $varTable = TABLE_BANNER;
                $argWhere = "BannerOrder ='" . $valOrder . "'";
                //pre($argWhere);
                $argWhere1 = "pkBannerID ='" . $argPost['orderId'][$key] . "'";
                $arrClms1 = array(
                    'BannerOrder'
                );
                $arrClms2 = array(
                    'BannerOrder' => $valOrder
                );

                $arrRes1 = $this->select($varTable, $arrClms1, $argWhere);

                if (count($arrRes1) == 0) {
                    $this->update($varTable, $arrClms2, $argWhere1);
                    $message_order['success'][$count] = $valOrder;
                    $count++;
                } else {
                    $message_order['error'][$count1] = $valOrder;
                    $count1++;
                }
            }
        }

        //return true;
        return $message_order;
//        $count = 0;
//        foreach ($argPost['order'] as $valOrder) {
//            $argWhere = "pkBannerID ='" . $argPost['orderId'][$count] . "'";
//            $arrClms = array(
//                'BannerOrder' => $valOrder
//            );
//            $varTable = TABLE_BANNER;
//            $this->update($varTable, $arrClms, $argWhere);
//            $count++;
//        }
//        return true;
    }

    /**
     * function removeBanner
     *
     * This function is used to remove the home banner..
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string true
     *
     * User instruction: $objSlider->removeBanner($argPostIDs)
     */
    function removeBanner($argPostIDs) {
        $varWhere = "pkBannerID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_BANNER, $varWhere);
        return true;
    }

    /**
     * function removeAllBanner
     *
     * This function is used to remove the home banner..
     *
     * Database Tables used in this function are : tbl_banner
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string true
     *
     * User instruction: $objSlider->removeAllBanner($argPostIDs)
     */
    function removeAllBanner($argPostIDs) {
        foreach ($argPostIDs['frmID'] as $valDeleteID) {
            $varWhere = "pkBannerID = '" . $valDeleteID . "'";
            $this->delete(TABLE_BANNER, $varWhere);
        }
        return true;
    }

    /**
     * function sliderCountList
     *
     * This function is used to count number of rows.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function festivalCountList($argWhere = '', $argLimit = '') {
        $varTable = TABLE_FESTIVAL;
        $varNum = $this->getNumRows($varTable, 'pkFestivalID', $argWhere);
        return $varNum;
    }

    /**
     * function festivalList
     *
     * This function is used to retrive festival List.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function festivalList($argWhere = '', $argLimit = '') {
        $arrClms = array('pkFestivalID', 'CountryIDs', 'CategoryIDs', 'FestivalTitle', 'FestivalStartDate', 'FestivalEndDate', 'FestivalOrder', 'FestivalStatus');
        $this->getSortColumnFestival($_REQUEST);

        $varTable = TABLE_FESTIVAL;
        $varWhere = "1 " . $argWhere;
        $arrRes = $this->select($varTable, $arrClms, $varWhere, $this->orderOptions, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getSortColumnFestival
     *
     * This function is used to sort column.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string true
     *
     * User instruction: $objSlider->getSortColumnFestival($argVarSortOrder)
     */
    function getSortColumnFestival($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
//        if ($argVarSortOrder['orderBy'] == '') {
//            $varOrderBy = 'DESC';
//        } else {
//            $varOrderBy = $argVarSortOrder['orderBy'];
//        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            //$varSortBy = 'pkFestivalID';
            $varSortBy = 'FestivalOrder ASC';
        } else {
            $varSortBy = $argVarSortOrder['sortBy'];
        }
        //Create sort class object
        $objOrder = new CreateOrder($varSortBy, $varOrderBy);
        unset($argVarSortOrder['PHPSESSID']);
        //This function return  query  string. When we will array.
        $varQryStr = $objCore->sortQryStr($argVarSortOrder, $varOrderBy, $varSortBy);
        //print_r($varQryStr);
        //Pass query string in extra function for add in sorting
        $objOrder->extra($varQryStr);
        //Prepage sorting heading
        $objOrder->append(' ');
        $objOrder->addColumn('Festival ID', 'FestivalID', '', 'hidden-480');
        $objOrder->addColumn('Title', 'FestivalTitle');
      
        $objOrder->addColumn('Start Date', 'FestivalStartDate', '', 'hidden-480');
        $objOrder->addColumn('End Date', 'FestivalEndDate', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function addFestival
     *
     * This function is used to insert the Home page slider deatails.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string $arrAddID
     *
     * User instruction: $objSlider->addFestival($arrPost)
     */
    function addFestival($arrPost) {
        global $objCore;

        $cids = implode(',', $arrPost['frmCountry']);
        $catids = implode(',', $arrPost['frmCategoryId']);

        $arrClms = array(
            'CountryIDs' => $cids,
            'CategoryIDs' => $catids,
            'FestivalTitle' => $arrPost['frmTitle'],
            'FestivalOrder' => $arrPost['frmBannerOrder'],
            'FestivalStatus' => $arrPost['frmStaus'],
            'FestivalStartDate' => $objCore->serverDateTime($arrPost['frmDateStart'], DATE_TIME_FORMAT_DB),
            'FestivalEndDate' => $objCore->serverDateTime($arrPost['frmDateEnd'], DATE_TIME_FORMAT_DB),
            'FestivalDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        $varTable = TABLE_FESTIVAL;
        $arrClms1 = array(
            'FestivalOrder'
        );
        $argWhere1 = "FestivalOrder ='" . $arrPost['frmBannerOrder'] . "'";
        $arrRes = $this->select($varTable, $arrClms1, $argWhere1);
        if (count($arrRes) == 0) {
            $arrAddID = $this->insert(TABLE_FESTIVAL, $arrClms);
            return $arrAddID;
        } else {
            return 'error';
        }
    }

    /**
     * function getFestivalDetail
     *
     * This function is used to get festival Details.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objSlider->getFestivalDetail($argID)
     */
    function getFestivalDetail($argID) {
        $varWhr = 'pkFestivalID =' . $argID;
        $arrClms = array('pkFestivalID', 'CountryIDs', 'CategoryIDs', 'FestivalTitle', 'FestivalStartDate', 'FestivalEndDate', 'FestivalOrder', 'FestivalStatus');
        $arrRes = $this->select(TABLE_FESTIVAL, $arrClms, $varWhr);

        return $arrRes;
    }

    /**
     * function getFestivalCats
     *
     * This function is used to get Festival category  Details.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objSlider->getFestivalCats($argID)
     */
    function getFestivalCats($argID) {

        $arrRes = $this->getFestivalDetail($argID);
        $arrRows = array();
        if ($arrRes[0]['CategoryIDs']) {
            $varWhr = "pkCategoryId IN (" . $arrRes[0]['CategoryIDs'] . ")";
            $arrClms = array('pkCategoryId', 'CategoryName');
            $arrRows = $this->select(TABLE_CATEGORY, $arrClms, $varWhr);
        }
        return $arrRows;
    }

    /**
     * function getFestivalByCountry
     *
     * This function is used to get festival Details.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objSlider->getFestivalByCountry($argID)
     */
    function getFestivalByCountry($argID) {
        if ($argID <> '') {
            $varWhr = " FIND_IN_SET(" . addslashes($argID) . ", CountryIDs) ";
        } else {
            $varWhr = "1";
        }
        $arrClms = array('pkFestivalID', 'CountryIDs', 'CategoryIDs', 'FestivalTitle');
        $arrRes = $this->select(TABLE_FESTIVAL, $arrClms, $varWhr);

        return $arrRes;
    }

    /**
     * function updateFestival
     *
     * This function is used to update festival details.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objSlider->updateFestival($arrPost)
     */
    function updateFestival($arrPost) {
        global $objCore;
        //pre($arrPost);
        $varWhr = 'pkFestivalID = ' . $_GET['id'];
        $cids = implode(',', $arrPost['frmCountry']);
        $catids = implode(',', $arrPost['frmCategoryId']);

        $arrClms = array(
            'CountryIDs' => $cids,
            'CategoryIDs' => $catids,
            'FestivalTitle' => $arrPost['frmTitle'],
            'FestivalOrder' => $arrPost['frmBannerOrder'],
            'FestivalStatus' => $arrPost['frmStaus'],
            'FestivalStartDate' => $objCore->serverDateTime($arrPost['frmDateStart'], DATE_TIME_FORMAT_DB),
            'FestivalEndDate' => $objCore->serverDateTime($arrPost['frmDateEnd'], DATE_TIME_FORMAT_DB)
        );
        $varTable = TABLE_FESTIVAL;
        $arrClmst = array('pkFestivalID', 'FestivalOrder');
        $argWheret = "pkFestivalID ='" . $_GET['id'] . "' and FestivalOrder='" . $arrPost['frmBannerOrder'] . "'";
        $arrRes = $this->select($varTable, $arrClmst, $argWheret);
//            echo $key;
//            echo count($arrRes);
        if (count($arrRes) == 0) {
              $varTable = TABLE_FESTIVAL;
        $arrClms1 = array(
            'FestivalOrder'
        );
        $argWhere1 = "FestivalOrder ='" . $arrPost['frmBannerOrder'] . "'";
        $arrRes = $this->select($varTable, $arrClms1, $argWhere1);
        if (count($arrRes) == 0) {
            $this->update(TABLE_FESTIVAL, $arrClms, $varWhr);
            return 1;
        } else {
            return 2;
        }

           
        }
        else
        {
           $this->update(TABLE_FESTIVAL, $arrClms, $varWhr);
            return 1; 
        }

      
    }

    /**
     * function updateFestivalStatus
     *
     * This function is used to update festival status.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return $arrUpdateID
     *
     * User instruction: $objSlider->updateFestivalStatus($argPost)
     */
    function updateFestivalStatus($argPost) {

        $varWhr = 'pkFestivalID = ' . $argPost['bid'];
        $arrClms = array('FestivalStatus' => $argPost['status']);
        $arrUpdateID = $this->update(TABLE_FESTIVAL, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function updateFestivalOrder
     *
     * This function is used to update Festival Orders.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string true
     */
    function updateFestivalOrder($argPost) {

        //pre($argPost);
        $message_order = array();
        $count = 0;
        $count1 = 0;
        foreach ($argPost['order'] as $key => $valOrder) {
            // $valOrder;
            // $argPost['orderId'][$key];
            $varTable = TABLE_FESTIVAL;
            $arrClms = array('pkFestivalID', 'FestivalOrder');
            $argWhere = "pkFestivalID ='" . $argPost['orderId'][$key] . "' and FestivalOrder='" . $valOrder . "'";
            $arrRes = $this->select($varTable, $arrClms, $argWhere);
//            echo $key;
//            echo count($arrRes);
            if (count($arrRes) == 0) {

                $varTable = TABLE_FESTIVAL;
                $argWhere = "FestivalOrder ='" . $valOrder . "'";
                //pre($argWhere);
                $argWhere1 = "pkFestivalID ='" . $argPost['orderId'][$key] . "'";
                $arrClms1 = array(
                    'FestivalOrder'
                );
                $arrClms2 = array(
                    'FestivalOrder' => $valOrder
                );

                $arrRes1 = $this->select($varTable, $arrClms1, $argWhere);

                if (count($arrRes1) == 0) {
                    $this->update($varTable, $arrClms2, $argWhere1);
                    $message_order['success'][$count] = $valOrder;
                    $count++;
                } else {
                    $message_order['error'][$count1] = $valOrder;
                    $count1++;
                }
            }
        }

        //return true;
        return $message_order;
//        $count = 0;
//        foreach ($argPost['order'] as $valOrder) {
//            $argWhere = "pkFestivalID ='" . $argPost['orderId'][$count] . "'";
//            $arrClms = array(
//                'FestivalOrder' => $valOrder
//            );
//            $varTable = TABLE_FESTIVAL;
//            $this->update($varTable, $arrClms, $argWhere);
//            $count++;
//        }
//        return true;
    }

    /**
     * function removeFestival
     *
     * This function is used to remove the remove festival.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string true
     *
     * User instruction: $objSlider->removeFestival($argPostIDs)
     */
    function removeFestival($argPostIDs) {
        $varWhere = "pkFestivalID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_FESTIVAL, $varWhere);
        return true;
    }

    /**
     * function removeAllFestival
     *
     * This function is used to remove selected festival.
     *
     * Database Tables used in this function are : tbl_festival
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string true
     *
     * User instruction: $objSlider->removeAllFestival($argPostIDs)
     */
    function removeAllFestival($argPostIDs) {
        foreach ($argPostIDs['frmID'] as $valDeleteID) {
            $varWhere = "pkFestivalID = '" . $valDeleteID . "'";
            $this->delete(TABLE_FESTIVAL, $varWhere);
        }
        return true;
    }

}

?>
