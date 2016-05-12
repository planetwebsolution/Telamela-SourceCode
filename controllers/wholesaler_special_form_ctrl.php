<?php

/**
 *
 * Module name : WholesalerSpecialFormCtrl
 *
 * Parent module : None
 *
 * Date created : 7th March 2014
 *
 * Date last modified :  11th March 2014
 *
 * Author :  Suraj Kumar Maurya
 *
 * Last modified by : Suraj Kumar Maurya
 *
 * Comments : The WholesalerSpecialFormCtrl class is used for wholesaler can submit aplication form manage.
 *
 */
require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

class WholesalerSpecialFormCtrl extends Paging {

    public function __construct() {
        if ($_SESSION['sessUserInfo']['id'] && $_SESSION['sessUserInfo']['type'] == 'wholesaler') {
            
        } else {
            header('location:' . SITE_ROOT_URL);
            die;
        }
    }

    /**
     * function pageLoad
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
        global $objGeneral;
        $objCore = new Core();
        $wid = $_SESSION['sessUserInfo']['id'];
        $this->wid = $wid;
        $objWholesaler = new Wholesaler();
        $objClassCommon = new ClassCommon();



        if (isset($_REQUEST['action'])) {

            if ($_REQUEST['action'] == 'showEvent') {
                $row = $_REQUEST['numRow'];
                $arrData = $objWholesaler->getEvent($_REQUEST['countryId']);
                $str = '<div class="errors" style="display: block;"></div><select name="frmEvent[]" id="frmEvent' . $row . '" class="drop_down1" onchange="showDates(this.value,' . "'" . $row . "'" . ');"><option value="0">' . SEL_EVENT . '</option>';

                foreach ($arrData as $k => $v) {
                    $str .= '<option value="' . $v['pkFestivalID'] . '">' . $v['FestivalTitle'] . '</option>';
                }
                $str.='</select>';
                echo $str;
                die;
            } else if ($_REQUEST['action'] == 'showEventDate') {

                $arrData = $objWholesaler->getEventDate($_REQUEST['eventId']);
                $str = $objCore->localDateTime($arrData['FestivalStartDate'], DATE_FORMAT_SITE) . '##' . $objCore->localDateTime($arrData['FestivalEndDate'], DATE_FORMAT_SITE);

                echo $str;
                die;
            } else if ($_REQUEST['action'] == 'showEventCategory') {
                $row = $_REQUEST['numRow'];

                $arrData = $objWholesaler->getEventCategory($_REQUEST['eventId']);
                $varStr = $objGeneral->CategoryHtml($arrData, 'frmCategory_' . $row . '[]', '', '', SEL_CAT, '', 'class="select2-me" style="width: 429px"', '1','1');
                $str = '<li><div>
                <label>' . CATEGORY_TITLE . '<strong>:</strong></label>
                <div class="input_sec input_star">
                    <div class="drop14 dropdown_12" style="width: 429px">                  
                        <div class="errors" style="display: block;"></div>' . $varStr . '<div class="errorsP" style="display: block;"></div>
                        <small class="star_icon special_qty"><img src="common/images/star_icon.png" alt=""/></small><input type="text"name="frmProduct_' . $row . '[]" style="width: 100px; margin-top: 2px; float: right;" /><span style="float: right;margin: 14px;">Quantity</span>
                    </div>
                    <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                </div>
                </div>';
                if ($_REQUEST['firstCat'] == '0') {
                    $str .='<a href="#" class="delete_icon3 remove_cat" title="Remove category"></a>';
                }
                $str .='</li>';

                echo $str;
                die;
            } else if ($_POST['action'] == 'submit') {
                //pre($_POST);
                $this->arrSetting = $objGeneral->getSetting();
            } else if ($_POST['action'] == 'finalSubmit') {
                $this->arrSetting = $objGeneral->getSetting();
                $this->insertId = $objWholesaler->addApplicationForm($_POST, $wid);
            } else if ($_REQUEST['action'] == 'add') {
                $this->arrCountryList = $objWholesaler->countryList();
                $this->arrWholesalerDetails = $objWholesaler->WholesalerDetails($this->wid);
            }
        } else {
            $this->arrRes = $objWholesaler->wholesalerSpecialList($wid);
            $this->paging($this->arrRes);

            $this->arrRes = $objWholesaler->wholesalerSpecialList($wid, $this->varLimit);
        }
    }

    function paging($arrRecords) {
        $objPaging = new Paging();
        $this->varPageLimit = LIST_VIEW_RECORD_LIMIT;
        if (isset($_GET['page'])) {
            $varPage = $_GET['page'];
        } else {
            $varPage = '';
        }
        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
    }

}

$objPage = new WholesalerSpecialFormCtrl();
$objPage->pageLoad();
?>
