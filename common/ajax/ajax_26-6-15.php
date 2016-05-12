<?php

/* * ****************************************
  Module name : Ajax Calls
  Date created : 06 June, 2011
  Date last modified : 06 June, 2011
  Author : Ghazala Anjum
  Last modified by :  Ghazala Anjum
  Comments : This file includes the funtions for AJAX calls.
  Copyright : Copyright (C) 1999-2011 Vinove Software and Services
 * **************************************** */
require_once('../config/config.inc.php');
require_once(CLASSES_PATH . 'class_mailing_list_bll.php');
include(CLASSES_PATH . 'class_shipping_bll.php');
include(CLASSES_PATH . 'class_product_bll.php');
include(CLASSES_PATH . 'class_user_bll.php');
include(CLASSES_PATH . 'class_home_bll.php');

//echo '<pre>';print_r($_POST);die;
/* * ****************************************
  Return type : boolean
  Comments : This ajax call will insert the email id of the user who send the joining mailing list request.
 * **************************************** */

if ($_POST['function'] == 'addMailingListEmail')
{
    $objMailingList = new MailingList();
    $arrInserTData = array('MailingListEmail' => $_POST['MailingListEmail'], 'FormType' => 'MailingList');

    if ($objMailingList->addMailingList($arrInserTData))
    {

        echo REQUEST_DEFINE;
    }
    else
    {
        echo 0;
    }
}
else if ($_POST['function'] == 'sendFreeGiftEmail')
{
    $objMailingList = new MailingList();


    if ($objMailingList->sendFreeGiftEmail($_POST['FreeGiftUserEmail']))
    {
        echo 'Email has been sent successfully.';
    }
    else
    {
        echo 0;
    }
}
else if ($_POST['function'] == 'addGiftsetValues')
{
    $objProduct = new Product();

    //$objProduct->sendGiftsToFriend($_POST);

    if ($objProduct->sendGiftsToFriend($_POST))
    {
        echo 1;
    }
    else
    {
        echo 0;
    }
}
else if ($_POST['function'] == 'getCountryStates')
{
    //echo '<pre>';print_r($_POST);//die;
    $objShipping = new Shipping();
    $varWhereClause = ' fkCountryID=' . $_POST['countryID'];
    $varTable = TABLE_STATE;
    if ($_POST['countryID'] <> '')
    {


        $arrStates = $objShipping->getShippingInfo($varTable, array('pkStateID', 'StateName'), $varWhereClause);

        $returnHTML = '';
        $returnHTML = '<option value="">' . SEL . '</option>';

        if (count($arrStates))
        {
            if ($_POST['showName'] == 'yes')
            {
                foreach ($arrStates as $key => $val)
                {
                    if ($val['StateName'] == $_POST['selected'])
                    {
                        $selected = 'selected="selected"';
                    }
                    else
                    {
                        $selected = '';
                    }

                    $returnHTML .= '<option value="' . $val['StateName'] . '" ' . $selected . '>' . $val['StateName'] . '</option>';
                }
            }
            else
            {
                foreach ($arrStates as $key => $val)
                {
                    if ($val['pkStateID'] == $_POST['selected'])
                    {
                        $selected = 'selected="selected"';
                    }
                    else
                    {
                        $selected = '';
                    }

                    $returnHTML .= '<option value="' . $val['pkStateID'] . '" ' . $selected . '>' . $val['StateName'] . '</option>';
                }
            }
        }
        else
        {
            $returnHTML = '<option value="">' . NO_STATE . '</option>';
        }
    }
    else
    {
        $returnHTML = '<option value="">' . SEL . '</option>';
    }
    echo $returnHTML;
}
else if ($_POST['function'] == 'getSizesCondition')
{
    //echo '<pre>';print_r($_POST);//die;
    $objProduct = new Product();
    $productId = $_POST['productId'];
    $sizeId = $_POST['sizeID'];
    if ($_POST['productId'] <> '')
    {

        $arrCondition = $objProduct->getProductCondition($sizeId, $productId);

        $returnHTML = '';
        //$returnHTML = '<option value="">Select</option>';

        if (count($arrCondition))
        {

            foreach ($arrCondition as $key => $val)
            {
                $returnHTML .= '<option value="' . $val['pkProductConditionId'] . '" >' . $val['ProductCondition'] . '</option>';
            }
        }
        else
        {
            $returnHTML = '<option value="">' . NO_CONDITION . '</option>';
        }
    }
    else
    {
        $returnHTML = '<option value="">' . SEL . '</option>';
    }
    echo $returnHTML;
}
else if ($_POST['function'] == 'getSizesColor')
{
    //echo '<pre>';print_r($_POST);//die;
    $objProduct = new Product();
    $productId = $_POST['productId'];
    $conditionId = $_POST['conditionId'];
    $sizeId = $_POST['SizeId'];
    $colorIds = $objProduct->getProductColorIds($conditionId, $productId, $sizeId);
    //print_r($colorIds);
    $varColorId = $colorIds[0]['fkColorid'];
    //die;
    //print_r($colorname);
    //die;
    if ($_POST['productId'] <> '')
    {
        /* if($_POST['showName'] == 'yes')
          {
          $varWhereClause = 'StateStatus = "Active" AND CountryName = "'.trim($_POST['countryID']).'"';
          $varTable = TABLE_STATE.' as S INNER JOIN '.TABLE_COUNTRY.' as C ON S.fkCountryID=C.pkCountryID ';
          }
          else
          { */
        $varWhereClause = 'StateStatus = "Active" AND fkCountryID = ' . $_POST['countryID'];
        $varTable = TABLE_STATE;
        //}

        $arrcolorname = $objProduct->getProductColor($varColorId);

        $returnHTML = '';
        $returnHTML = '<option value="">Select</option>';

        if (count($arrcolorname))
        {

            foreach ($arrcolorname as $key => $val)
            {
                $returnHTML .= '<option value="' . $val['pkColorID'] . '" >' . $val['ColorName'] . '</option>';
            }
        }
        else
        {
            $returnHTML = '<option value="">' . NO_COLOR . '</option>';
        }
    }
    else
    {
        $returnHTML = '<option value="">' . SEL . '</option>';
    }
    echo $returnHTML;
}
else if ($_POST['function'] == 'getColorOnSizeChange')
{
    //echo '<pre>';print_r($_POST);//die;
    $objProduct = new Product();
    $productId = $_POST['productId'];
    $conditionId = $_POST['ConditionId'];
    $sizeId = $_POST['SizeId'];

    $argWhere = ' 1 AND fkProductID=' . $productId . ' AND fkSizeID=' . $sizeId . ' AND fkConditionId=' . $conditionId;
    //$argWhere=' 1 AND fkProductID='.$productId.' AND fkSizeID='.$sizeId;
    $arrProductPrice = $objProduct->getProductPrice($argWhere);
    $conditionId = $arrProductPrice[0]['fkConditionId'];
    $colorIds = $objProduct->getProductColorIds($conditionId, $productId, $sizeId);
    //print_r($colorIds);
    $varColorId = $colorIds[0]['fkColorid'];
    //die;
    //print_r($colorname);
    //die;
    if ($_POST['productId'] <> '')
    {
        /* if($_POST['showName'] == 'yes')
          {
          $varWhereClause = 'StateStatus = "Active" AND CountryName = "'.trim($_POST['countryID']).'"';
          $varTable = TABLE_STATE.' as S INNER JOIN '.TABLE_COUNTRY.' as C ON S.fkCountryID=C.pkCountryID ';
          }
          else
          { */

        //}

        $arrcolorname = $objProduct->getProductColor($varColorId);
        $totalcolor = count($arrcolorname);
        $returnHTML = '';
        $returnHTML = '<option value="">' . SEL . '</option>';

        if (count($arrcolorname))
        {

            foreach ($arrcolorname as $key => $val)
            {
                $returnHTML .= '<option value="' . $val['pkColorID'] . '" >' . $val['ColorName'] . '</option>';
            }
        }
        else
        {
            $returnHTML = '<option value="">' . NO_COLOR . '</option>';
        }
    }
    else
    {
        $returnHTML = '<option value="">' . SEL . '</option>';
    }

    echo $returnHTML;
}
else if ($_POST['function'] == 'gettotalcolor')
{
    $objProduct = new Product();
    $productId = $_POST['productId'];

    $sizeId = $_POST['SizeId'];

    $argWhere = ' 1 AND fkProductID=' . $productId . ' AND fkSizeID=' . $sizeId;

    $arrProductPrice = $objProduct->getProductPrice($argWhere);
    $conditionId = $arrProductPrice[0]['fkConditionId'];
    $colorIds = $objProduct->getProductColorIds($conditionId, $productId, $sizeId);
    $totalcolor = $colorIds[0]['fkColorid'];
    $totalcolorIds = explode(',', $totalcolor);
    //print_r($totalcolorIds);
    $total = count($totalcolorIds);
    echo $total;
}
else if ($_POST['function'] == 'getSizesprice')
{
    $objProduct = new Product();
    $productId = $_POST['productId'];
    $conditionId = $_POST['conditionId'];
    $sizeId = $_POST['SizeId'];
    $argWhere = ' 1 AND fkProductID=' . $productId . ' AND fkConditionId=' . $conditionId . ' AND fkSizeID=' . $sizeId;

    $arrProductPrice = $objProduct->getProductPrice($argWhere);
    //print_r($arrProductPrice);
    $arrProductSizeData['saleprice'] = $arrProductPrice[0]['product_sale_price'];
    $arrProductSizeData['ourprice'] = $arrProductPrice[0]['product_price'];
    $arrProductSizeData['retailprice'] = $arrProductPrice[0]['product_retail_price'];
    $arrProductSizeData['pkProductSizeID'] = $arrProductPrice[0]['pkProductSizeID'];
    $arrProductSizeData['productQuantity'] = $arrProductPrice[0]['product_quantity'];
    $arrProductSizeData['SizeName'] = $arrProductPrice[0]['SizeName'];
    $varProductSizePrice = json_encode($arrProductSizeData);

    echo $varProductSizePrice;
}
else if ($_POST['function'] == 'getPriceOnSizes')
{
    $objProduct = new Product();
    $productId = $_POST['productId'];
    //$conditionId=$_POST['conditionId'];
    $sizeId = $_POST['SizeId'];
    $conditionId = $_POST['ConditionId'];
    $argWhere = ' 1 AND fkProductID=' . $productId . ' AND fkSizeID=' . $sizeId . ' AND fkConditionId=' . $conditionId;

    $arrProductPrice = $objProduct->getProductPrice($argWhere);
    //print_r($arrProductPrice);
    //die;
    $arrProductSizeData['saleprice'] = $arrProductPrice[0]['product_sale_price'];
    $arrProductSizeData['ourprice'] = $arrProductPrice[0]['product_price'];
    $arrProductSizeData['retailprice'] = $arrProductPrice[0]['product_retail_price'];
    $arrProductSizeData['pkProductSizeID'] = $arrProductPrice[0]['pkProductSizeID'];
    $arrProductSizeData['productQuantity'] = $arrProductPrice[0]['product_quantity'];
    $arrProductSizeData['SizeName'] = $arrProductPrice[0]['SizeName'];
    $varProductSizePrice = json_encode($arrProductSizeData);

    echo $varProductSizePrice;
}
if ($_POST['function'] == 'showProductPrice')
{
    $objProduct = new Product();
    $arrProductPrice = $objProduct->getProductPrice('pkProductSizeID = ' . $_POST['sizeID']);

    $arrProductSizeData['price'] = $arrProductPrice[0]['product_price'];
    $arrProductSizeData['sizeName'] = $arrProductPrice[0]['SizeName'];
    $varProductSizeData = base64_encode(json_encode($arrProductSizeData));

    $varProductSizeData = base64_encode(json_encode($arrProductSizeData));
    if (count($arrProductPrice))
    {
        echo $arrProductPrice[0]['product_price'] . '||' . $arrProductPrice[0]['product_retail_price'] . '||' . $varProductSizeData;
    }
    else
    {
        echo 0;
    }
}

if ($_POST['function'] == 'addUnsubscribeMail')
{
    $objUser = new User();
    $varEmail = $_SESSION['VenusetP_UserEmail'];
    $arrInserTData = array('frmUserLoginEmail' => $varEmail);

    if ($varmessage = $objUser->unsubscribeUser($arrInserTData))
    {

        echo $varmessage;
    }
    else
    {
        echo 0;
    }
}
if ($_POST['function'] == 'submitWholesellerFinalOrder')
{
    $objUser = new User();
    $varEmail = $_SESSION['VenusetP_UserEmail'];
    $arrInserTData = array('frmUserLoginEmail' => $varEmail);

    if ($varmessage = $objUser->unsubscribeUser($arrInserTData))
    {

        echo $varmessage;
    }
    else
    {
        echo 0;
    }
}

if ($_POST['action'] == 'notification')
{

    $objCore = new Core();
    echo $objCore->getNotification($_SESSION['sessUserInfo']['type'], $_SESSION['sessUserInfo']['id']);
}
if ($_POST['action'] == 'updateFeedback')
{
    $fid = $_POST['fid'];
    $objCore = new Core();
    $objCore->updateFeedback($fid);
}
if ($_POST['action'] == 'verifyEmail')
{
    $fid = $_POST['email'];
    $objCore = new Core();
    echo $objCore->verifyEmail($fid);
}
if ($_POST['action'] == 'verifyEmailWholsaler')
{
    $fid = $_POST['email'];
    $objCore = new Core();
    echo $objCore->verifyEmailWholsaler($fid);
}
if ($_POST['whlTemContactTemp'])
{
    global $objCore;
    $argSubject = 'Contact Form';
    $varEmailID =$_POST['WholesaleEmail'];
    // $varEmailID ='akhilesh.jha@mail.vinove.com';
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
//            "<b>Address:</b> " . $_POST['address'] . "<br/>" .
//            "<b>Phone:</b> " . $_POST['phone'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}

if ($_POST['whlTemContactTemp1'])
{
    global $objCore;
    $argSubject = 'Contact Form';
    $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
//            "<b>Address:</b> " . $_POST['address'] . "<br/>" .
//            "<b>Phone:</b> " . $_POST['phone'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}

if ($_POST['whlTemContactTemp2'])
{
    global $objCore;
    $argSubject = 'Contact Form';
    $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
//            "<b>Address:</b> " . $_POST['address'] . "<br/>" .
//            "<b>Phone:</b> " . $_POST['phone'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}

if ($_POST['whlTemContactTemp3'])
{
    global $objCore;
    $argSubject = 'Contact Form';
    $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
//            "<b>Address:</b> " . $_POST['address'] . "<br/>" .
//            "<b>Phone:</b> " . $_POST['phone'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}

if ($_POST['whlTemContactTemp4'])
{
    global $objCore;
    $argSubject = 'Contact Form';
   $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Name:</b> " . $_POST['name'] . "<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}
if ($_POST['whlTemContactTemp5'])
{
    global $objCore;
    $argSubject = 'Contact Form';
  $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Name:</b> " . $_POST['name'] . "<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}
if ($_POST['whlTemContactTemp6'])
{
    global $objCore;
    $argSubject = 'Contact Form';
    $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Name:</b> " . $_POST['name'] . "<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}
if ($_POST['whlTemContactTemp7'])
{
    global $objCore;
    $argSubject = 'Contact Form';
   $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Name:</b> " . $_POST['name'] . "<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}
if ($_POST['whlTemContactTemp8'])
{
    global $objCore;
    $argSubject = 'Contact Form';
   $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
//            "<b>Address:</b> " . $_POST['address'] . "<br/>" .
//            "<b>Phone:</b> " . $_POST['phone'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}
if ($_POST['whlTemContactTemp9'])
{
    global $objCore;
    $argSubject = 'Contact Form';
   $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Name:</b> " . $_POST['name'] . "<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}
if ($_POST['whlTemContactTemp10'])
{
    global $objCore;
    $argSubject = 'Contact Form';
    $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Name:</b> " . $_POST['name'] . "<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}
if ($_POST['whlTemContactTemp11'])
{
    global $objCore;
    $argSubject = 'Contact Form';
  $varEmailID =$_POST['WholesaleEmail'];
    $varFromUser = SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>';
    $varMessage = "<p style='text-align:left;margin-left:10px;'>
            Hello, <br/>A user make an enquiry, details are below:-<br/>" .
            "<b>Name:</b> " . $_POST['name'] . "<br/>" .
            "<b>Email:</b> " . $_POST['email'] . "<br/>" .
            "<b>Message:</b> " . $_POST['message'] . "<br/><br/>" .
            "</p>";
    $objCore->sendMail($varEmailID, $varFromUser, $argSubject, $varMessage);
    echo '1';
}
if($_POST['action']=='homeBannerAdvertisment'){
    $objHome =new Home();
    $varAdds=$objHome->getAds();
    if(count($varAdds)>4){
        foreach ($varAdds as $ads)
        {
            if ($ads['AdType'] == 'link' && $ads['ImageName'] != '')
            {
                ?>
                <div class="banners_new"><a href="<?php echo $ads['AdUrl']; ?>" target="_blank">
                        <img src="<?php echo UPLOADED_FILES_URL . "images/ads/276x160/" . $ads['ImageName']; ?>" src="" alt="<?php echo $ads['Title']; ?>" title="<?php echo $ads['Title']; ?>">
                    </a>
                </div>
                <?php
            }
            else if ($ads['AdType'] == 'html' && $ads['HtmlCode'] != '')
            {
                echo html_entity_decode($ads['HtmlCode']);
            }
        }
    }
        
    
}

if($_POST['action']=='getSubCategory'){
    $objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $wholesalerCompanyNeme=$objHome->wholesalrD($objWholId);
    $varAdds=$objHome->getSubCategory($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
        <div class="ContentSubmenu2">
                <div id="BG_div">
                    <div class="left_block">
                        <ul>
      <?php  foreach ($varAdds as $key=>$ads)
        { ?>
               
                            <li id="<?php echo $ads['pkCategoryId'].'_'.$objWholId;?>"><a href="javascript:void(0)" class="categorySubMenuProduct"> <?php echo $ads['CategoryName'];?></a></li>
                            <?php 
                            if($key==9){ ?>
                                <li class="childMenu" style="text-align: left;"><a target="_blank" href="<?php echo SITE_ROOT_URL;?>wholesaler_profile_customer_view/view/<?php echo $objWholId;?>">More..<span></span></a></li>
                               <?php break;
                            }
                            
                            ?>

                        
       <?php } ?>
                        </ul>
                    </div>
                </div>
               </div>
<?php
    }
        
    
}

if($_POST['action']=='getSubCategoryProduct'){
$objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $varAdds=$objHome->getSubCategoryProduct($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
<div class="products_outer">
<div class="products_box">
    
    <?php
foreach ($varAdds as $key=> $product)
{
 ?>
                            <div class="my_product <?php echo $key % 2 == 0 ? 'mlz' : ''; ?>">
                                <div class="pro_img">
                                    <div class="img_center">
                                        <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><img src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>"  title="<?php echo $product['ProductName']; ?>"   /></a>
                                    </div>
                                </div>
                                <div class="pro_details">
                                    <div class="fleft">
                                        <h3><a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><?php echo strlen($product['ProductName']) > 16 ? substr($product['ProductName'], 0, 16) . "..." : $product['ProductName']; ?></a></h3>

                                    </div>
                                    <div class="fright">
    <?php echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1); ?>
                                    </div>

                                </div>
                            </div>
<?php } ?>
</div>
    </div>
    <?php }  
}
if($_POST['action']=='getSubCategoryProductTemplate2'){
$objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $varAdds=$objHome->getSubCategoryProduct($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
<div class="padd_content">
<div class="products_box">
    
    <?php
foreach ($varAdds as $key=> $product)
{
 ?>
                            <div class="product <?php echo $key == 4 ? 'mrz' : ''; ?>">
                            <div class="myimg">
                                <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><img src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>"  title="<?php echo $product['ProductName']; ?>"   /></a>
                            </div>
                            <div class="img_details">
                                <p class="pname">
                                    <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><?php echo $objCore->getProductName($product['ProductName'], 20); ?></a>
                                </p>
                                <p class="price">
                                    <?php
                                    echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1);
                                    ?>
                                </p>
                                <div class="fullwidth">

                                    <a class="addtocart" target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>">Shop Now</a>
                                </div>

                            </div>
                            
                        </div>
<?php } ?>
</div>
    </div>
    <?php }  
}

if($_POST['action']=='getSubCategoryProductTemplate3'){
$objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $varAdds=$objHome->getSubCategoryProduct($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
<div class="padd_content">
<div class="offers">
    
    <?php
foreach ($varAdds as $key=> $v)
{
 ?>
                            <div class="offers_sec">
                                <div class="offer_img">
                                    <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $v['pkProductID'], 'name' => $v['ProductName'], 'refNo' => $v['ProductRefNo'])); ?>"><img src="<?php echo $objCore->getImageUrl($v['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $v['ProductName'] ?>"/></a>
                                </div>
                                <div class="offer_content">
                                    <h3><a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $v['pkProductID'], 'name' => $v['ProductName'], 'refNo' => $v['ProductRefNo'])); ?>"><?php echo strtoupper($v['ProductName']) ?></a></h3>
                                    <p> <?php echo strlen($v['ProductDescription']) > 200?substr($v['ProductDescription'], 0, 200) . ' ..<a target="_blank" href="'.$objCore->getUrl('product.php', array('id' => $v['pkProductID'], 'name' => $v['ProductName'], 'refNo' => $v['ProductRefNo'])).'">view details</a>':$v['ProductDescription']; ?></p>
                                    <p class="price">
                                        <?php
                                        echo $objCore->getFinalPrice($v['FinalPrice'], $v['DiscountFinalPrice'], $v['FinalSpecialPrice'], 0, 1);
                                        ?>
                                    </p>
                                </div>
                            </div>
<?php } ?>
</div>
    </div>
    <?php }  
}


if($_POST['action']=='getSubCategoryProductTemplate7'){
$objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $varAdds=$objHome->getSubCategoryProduct($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
<div class="section2 main_div" id="home">
 <div class="container">
                <div class="row space">
                    <div class="twelve columns">
    
    <?php
foreach ($varAdds as $key=> $product)
{
 ?>
                            <div class="box four columns <?php echo $key % 3 == 0 ? 'del_space' : ''; ?>">
                                <div class="img_box">
                                    <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>">
                                        <img src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>"  title="<?php echo $product['ProductName']; ?>" />
                                    </a>
                                </div>
                                <div class="detail">
                                    <h5><a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><?php echo strlen($product['ProductName']) > 14 ? substr($product['ProductName'], 0, 14) . "..." : $product['ProductName']; ?></a></h5>
                                    <div class="price">
                                        <?php echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1); ?>
                                    </div>
                                    <?php
//                                    if ($product['ProductDescription'])
//                                    {
                                    ?>
                                        <!--<p><?php // echo strlen($product['ProductDescription']) > 60 ? substr($product['ProductDescription'], 0, 60) . "..." : $product['ProductDescription'];  ?> </p>-->
                                    <?php // } ?>
                                </div>
                            </div>
<?php } ?>
</div>
                </div>
            </div>
        </div>    
    <?php }  
}
if($_POST['action']=='getSubCategoryProductTemplate8'){
$objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $varAdds=$objHome->getSubCategoryProduct($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
<div class="color_black">
 <div class="container">
                <div class="row">
                    
    
    <?php
foreach ($varAdds as $key=> $product)
{
 ?>
                            <div class="product_thumb_temp8">
                            <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>">
                                <img  src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>"  title="<?php echo $product['ProductName']; ?>" />
                            </a>
                            <h4 class="name"><a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><?php echo strlen($product['ProductName']) > 16 ? substr($product['ProductName'], 0, 15) . "..." : $product['ProductName']; ?></a></h4>
                           <div class="price">
                                <?php echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1); ?>
                            </div>
                            <?php
//                            if ($product['ProductDescription'])
//                            {
                                ?>
                                <!--<p><?php //echo strlen($product['ProductDescription']) > 18 ? substr($product['ProductDescription'], 0, 18) . "..." : $product['ProductDescription']; ?> </p>-->
                                <?php
//                            }
                            if ($product['discountPercent'] > 0 && $product['discountPercent'] < 99)
                            {
                                ?>
                                <a href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>" class="discount">
                                    <?php echo $product['discountPercent'] . '%'; ?>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
<?php } ?>

                </div>
            </div>
        </div>    
    <?php }  
}

if($_POST['action']=='getSubCategoryProductTemplate9'){
$objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $varAdds=$objHome->getSubCategoryProduct($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
<div class="color_black">
 <div class="container">
                <div class="row">
          <ul class="tabs">          
    
    <?php
foreach ($varAdds as $key=> $product)
{
 ?>
                      <li class="first <?php echo $key % 3 == 0 ? ' del_space' : ''; ?>">
                                <a href="#<?php echo strtoupper($product['ProductName']); ?>">
                                    <div class="cat">
                                        <?php echo $product['ProductName']; ?>
                                    </div>
                                    <div class="image">
                                        
                                       
                                            <img style="width:153px;height:154px;"  src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $product['ProductName']; ?>"/>
                                          
                                    </div>
                                     <div class="price">
                                <?php echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1); ?>
                            </div>
                            <?php
//                            if ($product['ProductDescription'])
//                            {
                                ?>
                                <!--<p><?php //echo strlen($product['ProductDescription']) > 18 ? substr($product['ProductDescription'], 0, 18) . "..." : $product['ProductDescription']; ?> </p>-->
                                <?php
//                            }
                            
                            ?>
                                    <!--<h5 onclick="">Learn More</h5>-->

                                </a>
                            </li>
<?php } ?>
</ul>

                </div>
            </div>
        </div>    
    <?php }  
}


if($_POST['action']=='getSubCategoryProductTemplate10'){
$objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $varAdds=$objHome->getSubCategoryProduct($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
<div class="color_black">
 <div class="container">
                <div class="row">
                    
    
    <?php
foreach ($varAdds as $key=> $product)
{
 ?>
                            <div class="product_thumb four columns box<?php echo $key % 3 == 0 ? ' del_space' : ''; ?>">
                            <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>">
                                <img  src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>"  title="<?php echo $product['ProductName']; ?>" />
                            </a>
                            <h4 class="name"><a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><?php echo strlen($product['ProductName']) > 16 ? substr($product['ProductName'], 0, 15) . "..." : $product['ProductName']; ?></a></h4>
                            <div class="price">
                                <?php echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1); ?>
                            </div>
                            <?php
//                            if ($product['ProductDescription'])
//                            {
                                ?>
                                <!--<p><?php //echo strlen($product['ProductDescription']) > 18 ? substr($product['ProductDescription'], 0, 18) . "..." : $product['ProductDescription']; ?> </p>-->
                                <?php
//                            }
                            if ($product['discountPercent'] > 0 && $product['discountPercent'] < 99)
                            {
                                ?>
                                <a href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>" class="discount">
                                    <?php echo $product['discountPercent'] . '%'; ?>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
<?php } ?>

                </div>
            </div>
        </div>    
    <?php }  
}

if($_POST['action']=='getSubCategoryProductTemplate11'){
$objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $varAdds=$objHome->getSubCategoryProduct($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
<div class="color_black">
 <div class="container">
                <div class="row">
                    
    
    <?php
foreach ($varAdds as $key=> $product)
{
 ?>
                            <div class="product_thumb11 four columns box<?php echo $key % 3 == 0 ? ' del_space' : ''; ?>">
                            <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>">
                                <img  src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>"  title="<?php echo $product['ProductName']; ?>" />
                            </a>
                            <h4 class="name"><a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><?php echo strlen($product['ProductName']) > 16 ? substr($product['ProductName'], 0, 15) . "..." : $product['ProductName']; ?></a></h4>
                            <div class="price">
                                <?php echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1); ?>
                            </div>
                            <?php
//                            if ($product['ProductDescription'])
//                            {
                                ?>
                                <!--<p><?php //echo strlen($product['ProductDescription']) > 18 ? substr($product['ProductDescription'], 0, 18) . "..." : $product['ProductDescription']; ?> </p>-->
                                <?php
//                            }
                            if ($product['discountPercent'] > 0 && $product['discountPercent'] < 99)
                            {
                                ?>
                                <a href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>" class="discount">
                                    <?php echo $product['discountPercent'] . '%'; ?>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
<?php } ?>

                </div>
            </div>
        </div>    
    <?php }  
}

if($_POST['action']=='getMainSubCategory'){
    $objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $wholesalerCompanyNeme=$objHome->wholesalrD($objWholId);
    //pre($wholesalerCompanyNeme);
    $varAdds=$objHome->subCategoryMenu($objCatId,$objWholId); 
    ?>
<div id="contentBox" class="contentBox_<?php echo $objCatId;?>">
                <ul class="submenu1">
                    <?php
                                        if(count($varAdds)>0){
                                           foreach($varAdds as $key=> $menuSub){ ?>
                                               <li class="childMenu" style="text-align: left;" id="<?php echo trim($menuSub['pkCategoryId']);?>"><a href="javascript:void(0)"><?php echo trim($menuSub['CategoryName']);?><span></span></a></li>
                                              <?php if($key==9){ ?>
                                               <li class="childMenu" style="text-align: left;"><a target="_blank" href="<?php echo SITE_ROOT_URL;?>wholesaler_profile_customer_view/view/<?php echo $objWholId;?>">More..<span></span></a></li>
                                              <?php    
                                break; }
                                           }
                                        }
                                        ?>
                              </ul>
            </div>
<?php
}if($_POST['action']=='getSubCategoryProductMiniShop'){
$objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $varAdds=$objHome->getSubCategoryProduct($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
<div class="products_outer">
<div class="products_box">
    
    <?php
foreach ($varAdds as $key=> $val)
{
 ?>
                            <div class="item">
                                                        <div class="view view-first">
                                                            <div class="image_new">
                                                                <?php
                                                                $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];
                                                                ?>
                                                                <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" src="" alt="<?php echo $val['ProductName'] ?>"/>


                                                                <div class="new_heading">
                                                                    <?php
                                                                    echo $objCore->getProductName($val['ProductName'], 39);
                                                                    ?>
                                                                </div>
                                                                <?php
                                                                if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                                {
                                                                    ?>
                                                                    <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                                <?php } ?>
                                                                <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                                                <!--<div class="unactive"><?php // echo $objCore->getProductName($val['ProductDescription'], 20);                                                    ?> </div>-->
                                                            </div>
                                                            <div class="mask">
                                                                <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php
                                                echo $val['ProductName'];
                                                                ?></a></h2>
                                                                <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 40);                                                    ?></p>
                                                                <div class="mask_box">
                                                                    <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info qckView quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                                    <?php
                                                                    if ($addToCart == OUT_OF_STOCK)
                                                                    {
                                                                        ?>
                                                                        <a <?php echo $varAddCartUrl; ?> title="<?php echo $addToCart; ?>"><?php echo $addToCart; ?></a>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        if ($_SESSION['sessUserInfo']['type'] == 'customer')
                                                                        {
                                                                            if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true))
                                                                            {
                                                                                ?>
                                                                                <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <a href="#loginBoxReview" class="info jscallLoginBoxReview" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview', 'wish',<?php echo $val['pkProductID']; ?>);" >Save</a>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
<?php } ?>
</div>
    </div>
    <?php }  
}

if($_POST['action']=='getSubCategoryMiniShop'){
    $objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $wholesalerCompanyNeme=$objHome->wholesalrD($objWholId);
    $varAdds=$objHome->getSubCategory($objCatId,$objWholId);
    if(count($varAdds)>0){ ?>
        <div class="ContentSubmenu2">
                <div id="BG_div">
                    <div class="left_block">
                        <ul>
      <?php  foreach ($varAdds as $key=>$ads)
        { ?>
               
                            <li id="<?php echo $ads['pkCategoryId'].'_'.$objWholId;?>"><a href="javascript:void(0)" class="categorySubMenuProduct"> <?php echo $ads['CategoryName'];?></a></li>
       <?php } ?>
                        </ul>
                    </div>
                </div>
               </div>
<?php
    }
        
    
}

if($_POST['action']=='getMainSubCategoryMiniShop'){
    $objHome =new Product();
    $objCatId =trim($_POST['cid']);
    $objWholId =trim($_POST['wid']);
    $wholesalerCompanyNeme=$objHome->wholesalrD($objWholId);
    //pre($wholesalerCompanyNeme);
    $varAdds=$objHome->subCategoryMenu($objCatId,$objWholId); 
    ?>
<div id="contentBox" class="contentBox_<?php echo $objCatId;?>">
                <ul class="submenu1">
                    <?php
                                        if(count($varAdds)>0){
                                           foreach($varAdds as $key=> $menuSub){ ?>
                                               <li class="childMenu" style="text-align: left;" id="<?php echo trim($menuSub['pkCategoryId']);?>"><a href="javascript:void(0)"><?php echo trim($menuSub['CategoryName']);?><span></span></a></li>
                                              <?php
                                           }
                                        }
                                        ?>
                              </ul>
            </div>
<?php
}


?>
