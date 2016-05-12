<?php

/* * ****************************************
  Module name : Ajax Calls
  Date created : 06 June, 2013
  Date last modified : 06 June, 2013
  Author : Suraj Kumar Maurya
  Last modified by :  Suraj Kumar Maurya
  Comments : This file includes the funtions for AJAX calls.
  Copyright : Copyright (C) 1999-2011 Vinove Software and Services
 * **************************************** */
require_once('../config/config.inc.php');
require_once(CLASSES_PATH . 'class_wholesaler_bll.php');

$varcase = $_REQUEST['action'];
switch ($varcase)
{
    case 'getRegion':
        $countryID = $_POST['cid'];
        $objWholesaler = new Wholesaler();
        $arrRows = $objWholesaler->regionList($countryID);
        echo '<select name="frmCompany1Region" id="frmCompany1Region" class="drop_down1"><option value="">' . SEL_REG . '</option>';
        foreach ($arrRows as $k => $v)
        {
            echo '<option value="' . $v['pkRegionID'] . '">' . $v['RegionName'] . '</option>';
        }

        echo '</select>';
        die;
        break;

    case 'ShowCategoryForPackage':
        $showId = $_REQUEST['row'];
        $varcategoryDrop = '<select name="frmCategoryId[]" onchange="ShowProductForPackage(this.value,' . $showId . ');" style="width:170px;"><option value="0">' . SEL_CAT . '</option>';
        foreach ($objPage->arrCategoryDropDown as $keySelect => $valSelect)
        {
            $varcategoryDrop .='<option value="' . $keySelect . '">' . str_replace("'", '', $valSelect) . '</option>';
        }
        $varcategoryDrop .='</select>';
        echo $varcategoryDrop;
        break;

    case 'updateReviewStatus':
        $reviewId = $_POST['id'];
        $varRateID = $_POST['rateID'];
        $status = $_POST['status'];
        $objWholesaler = new Wholesaler();
        $objWholesaler->updateReviewStatus($reviewId, $status, $varRateID);
        echo 'updated';
        die;
        break;

    case 'delteReview':
        $reviewId = $_POST['id'];
        $varRateID = $_POST['rateID'];
        $objWholesaler = new Wholesaler();
        $objWholesaler->deleteReview($reviewId,$varRateID);
        echo 'deleted';
        die;
        break;

    case 'ShowRecipientListForNewsletter':
        $showId = $_REQUEST['sort_by'];
        $objWholesaler = new Wholesaler();
        $arrRecipientList = $objWholesaler->recipientList();
        $varString = '';
        $varCounter = 0;
        foreach ($arrRecipientList as $varList)
        {
            $varCounter++;
            $cls = $varCounter % 2 == 0 ? 'class="bg_color"' : '';
            $varString .= '<li ' . $cls . '>
                <span class="customer"><span class="check_box" style="margin-left: 0;"><input type="checkbox" value="' . $varList['pkCustomerID'] . '" name="recipienId[]" class=""/></span></span>
                <span class="product">' . $varCounter . '</span>
                <span class="read">' . $varList['CustomerFirstName'] . ' ' . $varList['CustomerLastName'] . '</span>
                <span class="date">' . $objCore->localDateTime($varList['CustomerDateAdded'], DATE_FORMAT_SITE_FRONT) . '</span>
            </li>';
        }


        echo $varString;
        break;

    case 'ProductAutocomplete':
        $objWholesaler = new Wholesaler();
        $varID = "ProductName LIKE '%" . addslashes(trim($_REQUEST["q"])) . "%' AND fkWholesalerID='" . $_SESSION['sessUserInfo']['id'] . "'";
        $arrClms = array('ProductName');
        $varTable = TABLE_PRODUCT;
        $arrRes = $objWholesaler->select($varTable, $arrClms, $varID);
        foreach ($arrRes as $val)
        {
            echo  '<div class="results">'.$val['ProductName'] .'</div>'. "\n";
        }
        break;
    case 'wholesalerWarningData':
        $objWholesaler = new Wholesaler();
        $varID = "pkWarningID ='" . $_REQUEST["id"] . "'";
        $arrClms = array('WarningText');
        $varTable = TABLE_WHOLESALER_WARNING;
        $arrRes = $objWholesaler->select($varTable, $arrClms, $varID);

        echo '<div class="cart_inner" style="min-height:200px;"><p>' . ucfirst(stripcslashes($arrRes[0]['WarningText'])) . '</p></div>';
        break;

    case 'showSpecialEvents':
        $cid = $_REQUEST['catid'];
        $objWholesaler = new Wholesaler();
        $wid = $_SESSION['sessUserInfo']['id'];
        $arrRows = $objWholesaler->getSpecialEvents($cid, $wid);

        $varStr = '';
        if (count($arrRows) > 0)
        {
            $varStr = '<label><b>' . SPECIAL_EVENT . '</b><strong>:</strong></label><div class="check_box" style="margin-top: 10px;">';
            foreach ($arrRows as $key => $val)
            {
                $varStr .= '<input style="float:left;" type="radio" name="frmSpecialEvents" value="' . $val['fkFestivalID'] . '" /><small style="margin-top: -3px; font-weight:bold;">' . $val['FestivalTitle'] . '</small><br/>';
            }
            $varStr .='</div>';
        }
        echo $varStr;
        break;
    case 'deleteWholesalerSliderImage':
        $objWholesaler = new Wholesaler();
        $wid = $_SESSION['sessUserInfo']['id'];

        $varTable = TABLE_WHOLESALER_SLIDER_IMAGE;
        $where = "pkSliderId ='" . $_REQUEST["id"] . "' AND fkWholesalerId='$wid'";
        $varTable = TABLE_WHOLESALER_SLIDER_IMAGE;
        $arrClms = array('sliderImage');
        $arrRes = $objWholesaler->select($varTable, $arrClms, $where);

        if ($arrRes[0]['sliderImage'] != '' && file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_slider/" . $arrRes[0]['sliderImage']))
        {
            @unlink(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_slider/" . $arrRes[0]['sliderImage']);
        }
        $arrRes = $objWholesaler->delete($varTable, $where);

        echo 'deleted';
        break;
        
    case 'varifyDuplicatePackage':
    $objWholesaler = new Wholesaler();
    $packD=trim($_REQUEST['pk']);
    $packageId=trim($_REQUEST['package']);
    $wherePackageIdExists=$packageId>0?" AND pkPackageId!='".$packageId."'":'';
    $wherePackage="PackageName='".$packD."' $wherePackageIdExists";
    echo $objWholesaler->varifyDuplicatePackage($wherePackage);
    break;  

    case 'checkCurrentPassword':
    $objWholesaler = new Wholesaler();
    $currentP=trim($_REQUEST['pid']);
    echo $objWholesaler->varifyCurrentPassword($currentP);
    break;    
    
    case 'removeShip':
    $objWholesaler = new Wholesaler();
    $removeShip=trim($_REQUEST['cid']);
    echo $objWholesaler->removeShipp($removeShip);    
    break;    
}
?>