<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_PRODUCT_CTRL;
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
require_once CLASSES_PATH . 'class_home_bll.php';
$objProduct = new Product();
$objComman = new ClassCommon();
$addCart = (isset($_REQUEST['add']) && trim($_REQUEST['add']) == 'addCart') ? 1 : 0;
$objHome = new Home();
$varPid = trim($_REQUEST['id']);
$arrData = $objHome->getQuickViewDetails($varPid);
$valTop = $arrData[0];
if ($_SESSION['sessUserInfo']['type'] == 'customer' && $_SESSION['sessUserInfo']['id'] > 0)
{
    $objProduct->productViewUpdate($varPid);
}
//pre($objPage);
$arrWholesalerDefaultTemplate=$objHome->getWholesalerDefaultTemplate();
//pre($arrWholesalerDefaultTemplate);
//echo htmlspecialchars(stripslashes("GUESS Collection Gc Bel Gent Class Chrono Gents Watch X78004G5S-RRP�460-NEW"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    
    
    
<!--        <title><?php echo PRODUCTS; ?><?php echo $objPage->arrproductDetails[0]['MetaTitle']; ?></title>-->
        <title><?php echo $objPage->arrproductDetails[0]['ProductName']; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="<?php echo $objPage->arrproductDetails[0]['MetaDescription']; ?>"/>
        <meta name="keywords" content="<?php echo $objPage->arrproductDetails[0]['MetaKeywords']; ?>"/>


        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <style>
                .top_wholesale .iframe_cotanier {
                    width:100%;
                    max-width:100% !important;
                    float:left;
                }
                .newProductPage .newthumbNails{position: absolute;top: 0; left: 0;}
				/****27/7/15D***/
				.resp-tab-content{padding-right:3px!important;}
        </style>
        <style>
            div#mcTooltip,div#mcTooltip div{display:block!important}
            .pro_info_tooltip_attr{background-color:#fff;border:1px solid #ccc;border-radius:4px;display:none;padding:3px;position:absolute;bottom:-109px;z-index:999}
            .pro_info_tooltip_arrow_attr{background:url("<?php echo SITE_ROOT_URL; ?>common/images/tooltip_arrow.png") no-repeat scroll 0 0 rgba(0,0,0,0);color:#ccc;font-size:28px;height:13px;left:53px;position:absolute;top:-13px;width:17px;z-index:9999}
        </style>
        <div id='fb-root'></div>
        <script src='http://connect.facebook.net/en_US/all.js'></script>
        <script type="text/javascript">
            //FB.init({appId: "647192451965551", status: true, cookie: true});
             FB.init({appId: "488215354680635", status: true, cookie: true});
            function postToFeed() {
                // calling the API ...
                var obj = {
                    method: 'feed',
                    redirect_uri: SITE_ROOT_URL,
                    link: '<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrproductDetails[0]['pkProductID'], 'name' => $objPage->arrproductDetails[0]['ProductName'], 'refNo' => $objPage->arrproductDetails[0]['ProductRefNo'])) ?>',
                    picture: '<?php echo $objCore->getImageUrl($objPage->arrproductDetails[0]['ImageName'], 'products/' . $arrProductImageResizes['detail']); ?>',
                    name: '<?php echo ucfirst(addslashes($objPage->arrproductDetails[0]['ProductName'])); ?>',
                    //caption: 'Reference Documentation',
                    //description: '<?php //echo ucfirst(addslashes($objPage->arrproductDetails[0]['ProductDescription']));                                                                            ?>'
                    description: $('#tab1 p').text()
                };
                function callback(response) {
                    // alert(response);
                    if (response == null) {
                        document.getElementById('msg').innerHTML = "";
                    } else {
                        //document.getElementById('msg').innerHTML = "<span style='color:green'><?php echo PRODUCT_SHARE_SUCC; ?></span>";
                        //setTimeout(function(){$('#msg').html('&nbsp')},4000);

                        $.post(SITE_ROOT_URL + "common/ajax/ajax_compare.php", {
                            action: "addSocialRewards",
                            SocialMedia: 'Facebook'
                        }, function(data) {
                            //alert(data);
                        });
                    }
                }
                FB.ui(obj, callback);
            }
        </script>
        <script type="text/javascript">
            var callback = function(e) {
                if (e && e.data) {
                    var data;
                    try {
                        data = JSON.parse(e.data);
                    } catch (e) {

                    }
                    if (data && data.params && data.params.indexOf('tweet') > -1) {
                        $.post(SITE_ROOT_URL + "common/ajax/ajax_compare.php", {
                            action: "addSocialRewards",
                            SocialMedia: 'Twitter'
                        }, function(data) {
                            //alert(data);
                        });
                        // alert('Thanks for the tweet!');


                    }
                }
            }
            window.addEventListener ? window.addEventListener("message", callback, !1) : window.attachEvent("onmessage", callback)
        </script>
        <script type="text/javascript">
            (function() {
                var po = document.createElement('script');
                po.type = 'text/javascript';
                po.async = true;
                po.src = 'https://apis.google.com/js/client:plusone.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(po, s);
            })();

            function plusOneClick(response) {
                //alert(response.state);//console.log( response );

                if (response.state == 'on') {
                    $.post(SITE_ROOT_URL + "common/ajax/ajax_compare.php", {
                        action: "addSocialRewards",
                        SocialMedia: 'Google'
                    }, function(data) {
                        //alert(data);
                    });
                }
            }
        </script> </head>
    <body>
        <div class="outer_wrapper">
            <div id="navBar">	<?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>
            <div class="header" style=" border:none">
                <div class="layout"> </div>
            </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>
            <div id="ouderContainer" class="ouderContainer_1">
                <div class="layout">
                    <div class="header">
                        <div class="successMessage">
                            <div class="addToCartMess" style="display:none;"></div>
                        </div><?php
            if ($objCore->displaySessMsg())
            {
                ?>
                            <div class="successMessage">
                                <?php
                                echo $objCore->displaySessMsg();
                                $objCore->setSuccessMsg('');
                                $objCore->setErrorMsg('');
                                ?>
                            </div>
                        <?php }
                        ?>
                        <div class="addToCart">
                            <div class="addToCartClose" onclick="addToCartClose();">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            <div class="addToCartMsg"></div>
                        </div>
                    </div>
                    <?php //pre($_SESSION);        ?>
                    <div class="add_pakage_outer">
                        <ul class="parent_top">
                            <?php
                            if ($objPage->varBreadcrumbs)
                            {
                                echo $objPage->varBreadcrumbs;
                            }
                            ?>
                        </ul>
                        <div class="body_container product_sec">
                            <div class="products_left_outer" id="addCart">
                                <input type="hidden" name="frmProductId" id="frmProductId<?php echo $_REQUEST['id'] ?>" value="<?php echo $_REQUEST['id'] ?>" />
                                <input type="hidden" name="frmProductId" id="frmProductId" value="<?php echo $_REQUEST['id'] ?>" />
                                <!--Package Product Start Here-->
                                <?php
                                if ($objPage->arrproductDetails[0]['pkProductID'] > 0)
                                {
                                    ?>
                                    <?php require_once 'product_details_quickview.php'; ?>
                                    <div class="left_product_gradient">



                                        <div class="left_products_sec">

                                            <div class="tabs_section">
                                                <div class="video_section">
                                                    <?php
                                                    if (isset($objPage->arrproductDetails[0]['YoutubeCode']) && $objPage->arrproductDetails[0]['YoutubeCode'] != '')
                                                    {
                                                        ?>
                                                        <div class="video_side">
                                                            <iframe width="300" height="315" src="https://www.youtube.com/embed/<?php echo $objPage->arrproductDetails[0]['YoutubeCode']; ?>" frameborder="0" allowfullscreen></iframe>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="tabs_side" <?php echo isset($objPage->arrproductDetails[0]['YoutubeCode']) && $objPage->arrproductDetails[0]['YoutubeCode'] != '' ? '' : 'style="width:100%"'; ?>>
                                                    <ul class="tab">
                                                        <li><a href="#tab1" class="active"><?php echo DETAILS; ?></a></li>
                                                        <li><a href="#tab2"><?php echo REC_BUY; ?></a></li>
                                                        <li><a href="#tab3"><?php echo T_M; ?></a></li>
                                                    </ul>
                                                    <div class="scroll-pane tab_content tab_container open1" id="tab1">
                                                        <p class="vedio_content_area"><?php echo nl2br($objPage->arrproductDetails[0]['ProductDescription']); ?></p>
                                                    	
                                                    	<?php /* if (isset($objPage->arrproductDetails[0]['Weight']) && !empty($objPage->arrproductDetails[0]['Weight'])) {?>
                                                        <p><strong>Weight : </strong><?php echo number_format($objPage->arrproductDetails[0]['Weight'], 2).' '.ucfirst($objPage->arrproductDetails[0]['WeightUnit']);?></p>
                                                        <?php }?>
                                                        
                                                        <?php if (isset($objPage->arrproductDetails[0]['Length']) && !empty($objPage->arrproductDetails[0]['Length'])) {?>
                                                        <p><strong>Length : </strong><?php echo number_format($objPage->arrproductDetails[0]['Length'], 2).' '.ucfirst($objPage->arrproductDetails[0]['DimensionUnit']);?></p>
                                                        <?php }?>
                                                        
                                                        <?php if (isset($objPage->arrproductDetails[0]['Width']) && !empty($objPage->arrproductDetails[0]['Width'])) {?>
                                                        <p><strong>Width : </strong><?php echo number_format($objPage->arrproductDetails[0]['Width'], 2).' '.ucfirst($objPage->arrproductDetails[0]['DimensionUnit']);?></p>
                                                        <?php }?>
                                                        
                                                        <?php if (isset($objPage->arrproductDetails[0]['Height']) && !empty($objPage->arrproductDetails[0]['Height'])) {?>
                                                        <p><strong>Height : </strong><?php echo number_format($objPage->arrproductDetails[0]['Height'], 2).' '.ucfirst($objPage->arrproductDetails[0]['DimensionUnit']);?></p>
                                                        <?php } */?>
                                                        
                                                    </div>
                                                    <div class="scroll-pane tab_content tab_container" id="tab4">
                                                        <div id="wholesaler_details">
                                                            <?php require_once 'wholesaler_details.php'; ?>
                                                        </div>
                                                    </div>
                                                    <div class="scroll-pane tab_content tab_container" id="tab2" style="height:auto">
                                                        <table width="95%" style="">
                                                            <?php
                                                            if (count($objPage->arrRecentBuyer) > 0)
                                                            {
                                                                ?>
                                                                <tr style="background:#eee; color:#000; line-height:31px; font-weight:bold; ">
                                                                    <td style="text-align:center"><?php echo BUY_NAME; ?></td>
                                                                    <td style="text-align:center"><?php echo QUANTITY; ?></td>
                                                                    <td style="text-align:center"><?php echo DATE_OF_PUR; ?></td>
                                                                </tr>
                                                                <?php
                                                                foreach ($objPage->arrRecentBuyer as $keyRecentbuyer => $valRecentBuyer)
                                                                {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php
                                                        echo $valRecentBuyer['CustomerFirstName'] . ' ' . $valRecentBuyer['CustomerLastName'];
                                                        //echo 'Customer ' . ++$keyRecentbuyer
                                                                    ?></td>
                                                                        <td><?php echo $valRecentBuyer['quantity']; ?></td>
                                                                        <td><?php echo $objCore->localDateTimeSite($valRecentBuyer['OrderDateAdded'], DATE_FORMAT_SITE_FRONT); ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="3"><?php echo NO_REC_BUYER; ?>.</td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                    <div class="scroll-pane tab_content tab_container" id="tab3">
                                                        <p> <?php echo html_entity_decode($objPage->arrproductDetails[0]['ProductTerms']); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="quick_title_11"><a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $objPage->arrproductDetails[0]['pkWholesalerID'])); ?>" class="product_name wholesaler_nme"><?php echo ucfirst($objPage->arrproductDetails[0]['CompanyName']); ?></a></div>

                                            <!--
    <a class="wholesaler_nme" style="font-style:italic; margin-top:30px; width:100%; float:left; margin-bottom:10px;" href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $objPage->arrproductDetails[0]['pkWholesalerID'])); ?>"><strong><?php echo ucfirst($objPage->arrproductDetails[0]['CompanyName']); ?></strong></a>
                                            -->     <?php
                                                        $template = $objPage->arrproductDetails[0]['fkTemplateId'];

                                                        switch ($template)
                                                        {
                                                            case 1:
                                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1520px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template1.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                case 2:
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1820px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template2.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                case 3:
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1460px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template3.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                case 4:
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1280px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template4.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                case 5:
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1260px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template5.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                case 6:
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1445px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template6.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                case 7:
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1280px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template7.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                case 8:
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1760px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template8.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                case 9:
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1100px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template9.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                case 10:
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:980px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template10.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                case 11:
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1150px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template11.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'], 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    break;
                                                default:
                                                    //echo "2";die;
                                                    $templateID=$arrWholesalerDefaultTemplate[0]['pkTemplateId'];
                                                    if($templateID==''){
                                                    ?>
                                                    <iframe id="desc_ifr" class="" style="height:1460px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template1.php', array('tmpid' => 1, 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                    <?php
                                                    }else{?>
                                                        <iframe id="desc_ifr" class="" style="height:1460px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template'.$templateID.'.php', array('tmpid' => 1, 'id' => $objPage->arrproductDetails[0]['pkProductID'])); ?>" title="Seller's description of item"></iframe>
                                                   <?php }
                                                    break;
                                            }
                                            ?>

                                            <?php
                                            //pre($objPage->arrProductPackageDetails);
                                            $varTotalCountProductPackage = count($objPage->arrProductPackageDetails);

                                            if ($varTotalCountProductPackage > 0)
                                            { 
                                            	//echo $varTotalCountProductPackage; die;
                                            	foreach ($objPage->arrProductPackageDetails as $records) {
                                            		//echo '<pre>'; print_r($records); die;
                                            		//foreach ($records as $data) {
                                            		if (!empty($records)) {
                                            		//echo '<pre>'; print_r($data); die;
                                                //pre($objPage->arrProductPackageDetails);
                                                ?>
                                                <div class="package_sec wish_sec">
                                                    <div class="quick_title_1"><span> <?php echo PACKAGE; ?> <?php echo PACKAGE1 . ' - ' . $records[0]['PackageName']; ?></span></div>
                                                    <div class="overflow_div">
                                                        <div class="overflow_1">
                                                            <ul class="offer_sec">
                                                                <?php
                                                                $totalProductPrice = 0;
                                                                $varCountProductPackage = 0; 
                                                                /* echo '<pre>';
                                                                pre($objPage->arrProductPackageDetails); */
                                                                //$pnum = count($objPage->arrProductPackageDetails);
                                                                $pnum = count($records);
                                                                $pctr = 1;
                                                                $attr = '';
                                                                foreach ($records as $valProductPackage)
                                                                {

                                                                    //if ($valProductPackage['pkProductID'] == ) {
                                                                	$arrproductAttrbuteOptionId = explode(",", $valProductPackage['attrbuteOptionId']);
                                                                    $arrproductFkAttributeId = explode(",", $valProductPackage['fkAttributeId']);
                                                                    $arrproductAttributeLabel = explode(",", $valProductPackage['AttributeLabel']);
                                                                    $arrproductOptionTitle = explode(",", $valProductPackage['OptionTitle']);
                                                                    $arrproductoptionColorCode = explode(",", $valProductPackage['optionColorCode']);
                                                                    $arrproductOptionImage = explode(",", $valProductPackage['OptionImage']);
                                                                    $arrproductOptionExtraPrice = explode(",", $valProductPackage['OptionExtraPrice']);
                                                                    $totalProductPrice +=$valProductPackage['FinalPrice'];
                                                                    // echo '<pre>',print_r($arrproductFkAttributeId);

                                                                    if (count($arrproductOptionImage) > 1)
                                                                    {
                                                                        foreach ($arrproductOptionImage as $attrImage)
                                                                        {
                                                                            if ($attrImage != '')
                                                                            {
                                                                                $varSrc = $objCore->getImageUrl($attrImage, 'products/' . $arrProductImageResizes['recomended']);
                                                                            }
                                                                            else
                                                                            {
                                                                                $varSrc = $objCore->getImageUrl($valProductPackage['ImageName'], 'products/' . $arrProductImageResizes['recomended']);
                                                                            }
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        $varSrc = $objCore->getImageUrl($valProductPackage['ImageName'], 'products/' . $arrProductImageResizes['recomended']);
                                                                    }
                                                                    ?>
                                                                    <li <?php
                                                        if ($varTotalCountProductPackage == $varCountProductPackage + 1)
                                                        {
                                                                        ?> class="equal" <?php } ?>>
                                                                        <div class="package_contion" style="position:relative;"> <span class="product_border"> <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valProductPackage['pkProductID'], 'name' => $valProductPackage['ProductName'], 'refNo' => $valProductPackage['ProductRefNo'])); ?>" parent="_blank"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valProductPackage['ProductName']; ?>"/></a> </span>
                                                                            <h4><?php echo $objCore->getProductName($valProductPackage['ProductName'], 20); ?>&nbsp;</h4>
                                                                            <small><?php echo $objCore->getProductName($valProductPackage['ProductDescription'], 20); ?>&nbsp;</small>
                                                                            <?php
                                                                            $attr.= $valProductPackage['pkProductID'] . "|";
                                                                            if (count($arrproductAttributeLabel) > 1)
                                                                            {
                                                                                ?>
                                                                                <p style="font-size:12px;cursor:pointer;" class="show_attribute_details">show Attribute details</p>
                                                                                <div class="pro_info_tooltip_attr" id="show_attribute_details_<?php echo $valProductPackage['pkProductID']; ?>" style="width:200px;"> <i class="pro_info_tooltip_arrow_attr"></i>
                                                                                    <?php
                                                                                    foreach ($arrproductAttributeLabel as $key => $attDetails)
                                                                                    {
                                                                                        //$AllAttrFormate[$valProductPackage['pkProductID']]=$arrproductFkAttributeId[$key].':'.$arrproductFkAttributeId[$key];
                                                                                        ?>
                                                                                        <div style="float:left;font-size:14px;clear:left;"><?php echo $attDetails; ?> : </div>
                                                                                        <div style="float:right;font-size:14px;clear:right;"><?php echo $arrproductOptionTitle[$key]; ?></div>
                                                                                        <?php
                                                                                        $attributes[] = $arrproductFkAttributeId[$key] . ':' . $arrproductAttrbuteOptionId[$key];
                                                                                        // pre($attributes);
                                                                                        //mail('raju.khatak@mail.vinove.com','hi',print_r($attributes,1));
                                                                                        $attr1 = $valProductPackage['pkProductID'] . '$' . implode('#', $attributes) . "|";

                                                                                        $extraP +=$arrproductOptionExtraPrice[$key];

                                                                                        //echo $valProductPackage['FinalPrice']+$extraP;
                                                                                        //pre($attr);
                                                                                    }

                                                                                    //pre($attr);
                                                                                    ?>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            $attr.=$attr1;
                                                                            $totalProductPrice +=$extraP;
                                                                            ?>
                                                                            <strong><?php echo $objCore->getPrice($valProductPackage['FinalPrice'] + $extraP); ?></strong> </div>
                                                                    </li>
                                                                    <?php echo ($pctr < $pnum) ? '<li class="last_secon">+</li>' : '' ?>
                                                                    <?php
                                                                    $pctr++;
                                                                    $varCountProductPackage++;
                                                                //}
                                            					//}
                                                                }
                                                                $varSavePrice = $totalProductPrice - $objPage->arrProductPackageDetails[0]['PackagePrice'];
                                                                //pre($attr);
                                                                ?>
                                                                <!--<li class="last_secon">=</li>-->

                                                            </ul>
                                                            <div class="package_price">
                                                                <div class="package_bg">
                                                                    <div class="equal_icon1">= </div>
                                                                    <div class="offer_price">TOTAL OFFER PRICE</div>
                                                                    <div class="left_offer">  <strong>Total price: <span style="text-decoration:line-through; font-weight:bold; padding-left:35px"><?php echo $objCore->getPrice($totalProductPrice); ?></span></strong>  <span class="packages_offer">Package price: <small><?php echo $objCore->getPrice($records[0]['PackagePrice']); ?></small> </span>
                                                                    </div>
                                                                    
                                                                    <div class="right_offer">
                                                                        <?php echo SAVE; ?>:<small style="color:#006feb"><?php echo $objCore->getPrice($varSavePrice); ?></small> <span class="kuchbhee"> <a href="javascript:void(0);" class="add_cart_link" onclick="addToCartPackage('<?php  echo $records[0]['pkPackageID']; ?>', this.className,'<?php echo $_SESSION['sessUserInfo']['type']; ?>')"><?php echo ADD_TO_CART; ?></a> </span>
                                                                        <?php
                                                                        ///pre($attr);
                                                                        ?>
                                                                        <input type="hidden" id="AllAttrFormate" value="<?php echo $attr; ?>"/>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            	}
                                            }
                                            ?>
                                        </div>

                                        <?php
                                        if ($objPage->arrproductDetails[0]['pkProductID'] > 0)
                                        {
                                            ?>
                                            <div class="wholesale_contain" style="display:none">
                                                <div class="bottom_wholesale" id="reviewSec" >
                                                    <div class="quick_title" style=" width:698px"> <span><?php echo CUSTOMER; ?> <?php echo REVIEW; ?></span></div>

                                                    <!--<div style="color: green;text-align: left;clear: both;margin-top: 20px;padding-top: 20px;" id="ajaxRatingMessage">&nbsp;</div>-->
                                                    <div class="top_customer review_1" id="top_customer">
                                                        <div class="review_sec1">
                                                            <form action="" method="post" id="frmReview" name="frmReview" >
                                                                <div class="rating" id="ajax_rating" style=" margin-top:10px;">
                                                                    <div class="rating_dispaly" style="float:left ;"><span class="red">*</span><?php echo Y_RAT; ?> :</div>
                                                                    <div class="error_msg_rate"></div>
                                                                    <?php
                                                                    $valRatingValue = (int) $objPage->arrCustomerRatingDetails[0]['Rating'];
                                                                    ?>
                                                                    <?php
                                                                    if ($valRatingValue == 0)
                                                                    {
                                                                        for ($i = 0; $i < 5; $i++)
                                                                        {
                                                                            ?>
                                                                            <a href="javascript:void(0);"  onclick="rate_value(<?php echo $i + 1; ?>, '<?php echo IMAGE_FRONT_PATH_URL; ?>')"> <img  style="margin-top:3px"  id="star0_<?php echo $i + 1; ?>" src="<?php echo IMAGE_FRONT_PATH_URL; ?>star0.png" alt=""/></a>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        $valRemainRating = (int) (5 - $valRatingValue);

                                                                        for ($i = 0; $i < $valRatingValue; $i++)
                                                                        {
                                                                            ?>
                                                                            <a href="javascript:void(0);"  onclick="jscall_star(<?php echo $i + 1; ?>, '<?php echo IMAGE_FRONT_PATH_URL; ?>')" class="star_color<?php echo $i + 1; ?>"> <img  style="margin-top:3px"   id="star0_<?php echo $i + 1; ?>" src="<?php echo IMAGE_FRONT_PATH_URL; ?>star1.png" alt=""/></a>
                                                                            <?php
                                                                        }

                                                                        for ($j = 0; $j < $valRemainRating; $j++)
                                                                        {
                                                                            ?>
                                                                            <a href="javascript:void(0);"  onclick="jscall_star(<?php echo $i + 1; ?>, '<?php echo IMAGE_FRONT_PATH_URL; ?>')" class="star_color<?php echo $i + 1; ?>"> <img  style="margin-top:3px"   id="star0_<?php echo $i + 1; ?>" src="<?php echo IMAGE_FRONT_PATH_URL; ?>star0.png" alt=""/></a>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="rating_dispaly review_txt1"><span class="red">*</span><?php echo REVIEW; ?> :</div>
                                                                <div class="error_msg"></div>
                                                                <textarea cols="2" rows="3" maxlength="<?php echo REVIEW_MESSAGE_LIMIT; ?>" name="frmMessage" id="frmMessage"><?php echo $objPage->arrCustomerRatingDetails[0]['Reviews']; ?></textarea>
                                                                <span id="maxlimit">(Maximum allowed characters are <?php echo REVIEW_MESSAGE_LIMIT; ?>)</span>
                                                                <?php
                                                                if (isset($_SESSION['sessUserInfo']) && $_SESSION['sessUserInfo']['type'] == 'customer')
                                                                {
                                                                    ?>
                                                                    <div id="ajaxReviewId"> <a href="javascript:void();" onclick="return ajax_review();">
                                                                            <input type="button" value="Submit"  class="submit3 topspace" name="frmReviewSubmit"/>
                                                                        </a> <span id="reviewSuccessMsg" style="padding-top:10px;"></span> </div>
                                                                    <input type="hidden" name="frmReviewAdd" id="frmReviewAdd" value="add" />
                                                                    <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" name="frmReviewUrl" id="frmReviewUrl" value="<?php echo $objCore->getUrl('login.php', array('pid' => $objPage->arrproductDetails[0]['pkProductID'], 'name' => $objPage->arrproductDetails[0]['ProductName'], 'refNo' => $objPage->arrproductDetails[0]['ProductRefNo'], 'review' => 'yes')); ?>" />
                                                                <input type="hidden" name="frmProductId" id="frmProductId" value="<?php echo $_REQUEST['id'] ?>" />
                                                                <input type="hidden" name="frmProductRateVal" id="frmProductRateVal" value="<?php echo $valRatingValue; ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Review popup starts from here-->
                                                <div id="show_review" >
                                                    <div class="product_review_meassage" id="showReviewMessage">&nbsp;</div>
                                                    <?php
                                                    if (count($objPage->arrproductReview) > 0)
                                                    {
                                                        foreach ($objPage->arrproductReview as $valReview)
                                                        {
                                                            ?>
                                                            <div class="top_customer"> <span class="iocn_2"><img  src="<?php echo IMAGE_FRONT_PATH_URL; ?>customer_icon.png" alt=""/></span>
                                                                <div class="review_sec1">
                                                                    <h3> <?php echo ($valReview['CustomerScreenName'] == '') ? $valReview['CustomerName'] : $valReview['CustomerScreenName']; ?> <span><?php echo $objProduct->_ago($objCore->localDateTime($valReview['ReviewDateUpdated'], DATE_TIME_FORMAT_DB)); ?></span>
                                                                        <div class="myInnerrating">
                                                                            <?php
                                                                            echo $objComman->getRatting($valReview['Rating']);
                                                                            ?>
                                                                        </div>
                                                                    </h3>
                                                                    <?php echo ucfirst($valReview['Reviews']);
                                                                    ?> </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                            //pre($objPage->arrCustomerBoughtProduct);
                                            if (count($objPage->arrCustomerBoughtProduct) > 0)
                                            {
                                                ?>
                                                <div class="demo landing">
                                                    <!--            Horizontal Tab-->
                                                    <div class="horizontalTab border_change" style="width:101% !important">
                                                        <ul class="resp-tabs-list">
                                                            <div class="quick_title1">
                                                                <span> <?php echo CUSTOMER; ?> <?php echo WHO_BOUGHT; ?></span>
                                                        </ul>
                                                        <div class="customNavigation navi1"> <a class="btn prev7"><img style="margin-left: -10px;
                                                                                                                       margin-right: 5px;" src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next7"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
                                                        <div class="resp-tabs-container">
                                                            <div>
                                                                <div id="demo">
                                                                    <div  class="owl-demo7">
                                                                        <!--   Section Start-->
                                                                        <?php
                                                                        foreach ($objPage->arrCustomerBoughtProduct as $key => $val)
                                                                        {
                                                                            if ($val['Quantity'] == 0)
                                                                            {
                                                                                $varAddCartUrl = 'class="cart2 outOfStock info"';
                                                                                $addToCart = OUT_OF_STOCK;
                                                                                $addToCartImg1 = 'outofstock_icon.png';
                                                                            }
                                                                            else
                                                                            {
                                                                                $addToCart = ADD_TO_CART;
                                                                                $addToCartImg1 = 'cart_icon.png';
                                                                                if ($val['Attribute'] == 0)
                                                                                {
                                                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                                                }
                                                                                else
                                                                                {
                                                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info cart2 addCart" ';
                                                                                }
                                                                            }

                                                                            $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ImageName'];
                                                                            //if (file_exists($varImgPath) && $val['ProductImage'] != '') {
                                                                            ?>
                                                                            <div class="item">
                                                                                <div class="view view-first">
                                                                                    <div class="image_new">
                                                                                        <?php
                                                                                        $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ImageName'];
                                                                                        if (file_exists($varImgPath) && $val['ImageName'] != '')
                                                                                        {
                                                                                            ?>
                                                                                            <img src="<?php echo $objCore->getImageUrl($val['ImageName'], 'products/208x185'); ?>" alt="<?php echo $val['ProductName'] ?>"/>
                                                                                            <?php
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            ?>
                                                                                            <img src="<?php echo IMAGES_URL; ?>guess.png" alt="">
                                                                                            <?php }
                                                                                            ?>
                                                                                            <div class="new_heading1"><?php echo $objCore->getProductName($val['ProductName'], 15); ?></div>
                                                                                            <?php
                                                                                            if ($val['discountPercent'] > 0)
                                                                                            {
                                                                                                ?>
                                                                                                <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                                                            <?php } ?>
                                                                                            <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $arrSpecialProductPrice[$val['pkProductID']]['FinalSpecialPrice'], 0, 1); ?></div>
                                                                                            <div class="unactive"><?php echo $objCore->getProductName($val['ProductDescription'], 20); ?> </div>
                                                                                            <div class="customer_rating">
                                                                                                <?php
                                                                                                $arrRatingDetails = $objProduct->myRatingDetails($val['pkProductID']);
                                                                                                $productRate = ($arrRatingDetails[0]['numRating']) / ($arrRatingDetails[0]['numCustomer']);
                                                                                                echo $objComman->getRatting($productRate);
                                                                                                ?>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="mask">
                                                                                        <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $objCore->getProductName($val['ProductName'], 15); ?></a></h2>
                                                                                        <p class="productPointer">
                                                                                            <?php //echo $objCore->getProductName($val['ProductDescription'], 20);                                                    ?>
                                                                                        </p>
                                                                                        <div class="mask_box"> <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
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
                                                                                                        <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $key . '_' . $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $key . '_' . $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
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
                                                                            <?php
//}
                                                                        }
                                                                        ?>
                                                                        <!-- End Section Start --> </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br />
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="right_section" style="width:288px; margin-left:11px; float:left;">
                                        <div class="gradient2" <?php
                                    if (count($objPage->arrData['arrCompareDetails']) == 0)
                                    {
                                        echo "style='background:none'";
                                    }
                                        ?>>
                                                 <?php //include_once(INC_PATH . 'right_side_recommend_good_search.php');       ?>
                                                 <?php include_once(INC_PATH . 'right_side_recommend_good_search_new.php'); ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="noProductAvail"><strong> <?php echo PRODUCT_NO_EXIS; ?></strong></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once INC_PATH . 'footer.inc.php'; ?>
            <script>
                $(document).ready(function() {
<?php echo $functions; ?>
    });
            </script>
            <div style="display: none;">
                <div id="loginBoxReview">
                    <div class="login_box">
                        <div class="login_inner">
                            <div class="heading">
                                <h3><?php echo SI_IN; ?> (Customer)</h3>
                            </div>
                            <div class="red" id="LoginErrorMsgRev"></div>
                            <div class="">
                                <?php /*
                                  <div class="radio_btn">
                                  <input type="radio" name="frmUserTypeLn" value="customer" class="styled" checked="checked" />
                                  <small><?php echo CUSTOMER; ?></small>
                                  </div>
                                 */ ?>
                            </div>
                            <div class="form" style="margin-top:0px;">
                                <label class="username">
                                    <span><?php echo EM_ID; ?> :</span>
                                    <input type="text" style="margin-bottom:20px;" class="saved" placeholder="Email Id" autocomplete="off" value="<?php echo isset($_COOKIE['email_id']) ? $_COOKIE['email_id'] : ''; ?>" name="frmUserEmailLn" id="frmUserEmailLnRev"/>
                                    <div class="frmUserEmailLn" style="float: left"></div>
                                </label>
                                <div style="height:30px; clear:both"></div>
                                <label class="password">
                                    <span><?php echo PASSWORD; ?> :</span>
                                    <input type="password" class="saved" placeholder="Password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" autocomplete="off" name="frmUserPasswordLn" id="frmUserPasswordLnRev"/>
                                    <div class="frmUserPasswordLn"></div>
                                </label>
                                <div class="password"> </div>
                                <input type="hidden" name="frmProductToWish" id="frmProductToWish" value=""/>
                                <div style="clear:both; display:block">
                                    <div class="remember_div">
                                        <div class="check_box" style=" margin-top:40px; clear:both;">
                                            <input type="checkbox" name="remember_me" value="yes" class="styled" <?php echo isset($_COOKIE['email_id']) ? "checked" : ''; ?>/>
                                            <small style="line-height:20px;"><?php echo REMEMBER_ME; ?></small> </div>
                                    </div>
                                    <div class="password_div"> <a style=" margin-top:-17px; " href="#forgetPassword" onclick="return jscallLoginBox('jscallForgetPasswordBox', '1');" class="jscallForgetPasswordBox save_for"><?php echo FORGOT_PASSWORD; ?></a></div>
                                </div>
                            </div>
                            <input type="button" style="display: block;
                                   margin: 0px auto;
                                   clear: both;
                                   float: none;" name="frmHidenAdd" onclick="loginActionCustomerToWish('review')" value="Sign In"  class="submit3" id="signUptoSave" saveTo="addwishlist"/>

                        </div>
                    </div>
                </div>
            </div>


    </body>
</html>

