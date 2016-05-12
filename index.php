<?php

require_once 'common/config/config.inc.php';

require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
require_once CONTROLLERS_PATH . FILENAME_HOME_CTRL;
$objComman = new ClassCommon();

//$objPage = new HomeCtrl();
//$objPage->pageLoad();
//pre($_SESSION);
$arrSpecialProductPrice = $objPage->arrData['arrSpecialProductPrice'];
//pre($objPage->arrData);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head class>
        <title><?php echo INDEX_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <script>
            <?php //pre($objPage); ?>
            var delayTimeHomeBanner='<?php echo $objPage->arrData['arrHomeBanner']['Setting']['delayTime'];?>';
            console.log(delayTimeHomeBanner);
        </script>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <style>
            .cartMessage, .error, .success{
                margin-top:0px !important;
            }
        </style>
    </head>
    <body>
        <em>
            <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>
        </em>
        <div class="header"> </div>
        <?php  include_once INC_PATH . 'header.inc.php'; ?>
        <div id="">
            <div class="layout">
                <?php
                if ($objCore->displaySessMsg())
                {
                    ?>
                    <div style="text-align:center; width: 1000px; color:red;">
                        <?php
                        echo $objCore->displaySessMsg();
                        $objCore->setSuccessMsg('');
                        $objCore->setErrorMsg('');
                        ?>
                    </div>
                <?php }
                ?>
                <div class="bannerBlock">
                    <div class="sliderBlock top_banners" >
                        <div class="slider">
                            <?php 
                            $varcount = 1;
                            foreach ($objPage->arrData['arrHomeBanner']['Contents'] as $valB)
                            {
                                $mapNm = 'banner' . $valB['pkBannerID'];
                                ?>
                                <div class="item  ">
                                    <?php
                                    if ($varcount == 1)
                                    {
                                        ?>
                                        <img  class="banner" src="<?php echo $objCore->getImageUrl($valB['BannerImageName'], 'banner/600x400'); ?>" alt="" usemap="#<?php echo $mapNm; ?>" />
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <img class ="banner lazy" data-src="<?php echo $objCore->getImageUrl($valB['BannerImageName'], 'banner/600x400'); ?>" src = "" alt = "<?php echo $valB['BannerTitle']; ?>" usemap = "#<?php echo $mapNm; ?>" />
                                    <?php }
                                    ?>
                                    <map name="<?php echo $mapNm; ?>">
                                        <?php
                                        foreach ($valB['arrLinks'] as $valL)
                                        {
                                            ?>
                                            <area shape="poly" coords="<?php echo $valL['linkImagePosition']; ?>" href="<?php echo $valL['UrlLinks'] ?>" alt="" />
                                        <?php } ?>
                                    </map>
                                </div>
                                <?php
                                $varcount++;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="todayOffer">
                        <?php //pre($objPage->arrData['arrTodayOfferProduct']['offer_details'][0]);          ?>
                        <h3><span class="txtStl"><?php echo TODAY; ?></span> <?php echo OFFER; ?></h3>
                        <div class="offerImgDiv">
                            <div class="offerImg"> <a href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['fkProductId'], 'name' => $objPage->arrData['arrTodayOfferProduct']['product_details'][0]['ProductName'], 'refNo' => $objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['ProductRefNo'])); ?>" class=""><img src="<?php echo $objCore->getImageUrl($objPage->arrData['arrTodayOfferProduct']['product_details'][0]['ProductImage'], 'products/' . $arrProductImageResizes['cart']); ?>" alt="<?php echo ucfirst($objPage->arrData['arrTodayOfferProduct']['product_details'][0]['ProductName']); ?>" /></a> </div>
                        </div>
                        <h4 style="text-align:center"> <a href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['fkProductId'], 'name' => $objPage->arrData['arrTodayOfferProduct']['product_details'][0]['ProductName'], 'refNo' => $objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['ProductRefNo'])); ?>" class=""> <?php echo ucfirst(substr($objPage->arrData['arrTodayOfferProduct']['product_details'][0]['ProductName'], 0, 20)).'..'; ?> </a> </h4>
                        <div class="price_new"><small><?php echo $objCore->getPrice($objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['CurrentPrice']); ?></small><strong><?php echo $objCore->getPrice($objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['OfferPrice']); ?></strong> </div>
                        <a href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['fkProductId'], 'name' => $objPage->arrData['arrTodayOfferProduct']['product_details'][0]['ProductName'], 'refNo' => $objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['ProductRefNo'])); ?>" class="">
                            <p>
                                <?php
                                if (strlen($objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['Description']) > 80)
                                {
                                    echo substr($objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['Description'], 0, 80) . "...";
                                }
                                else
                                {
                                    echo $objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['Description'];
                                }
                                ?>
                            </p>
                        </a>
                        <?php
                        $perDiff = ($objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['CurrentPrice'] - $objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['OfferPrice']);
                        $perOff = round(floor(($perDiff * 100) / ($objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['CurrentPrice'])));
                        ?>

<!--                        <a href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['fkProductId'], 'name' => $objPage->arrData['arrTodayOfferProduct']['product_details'][0]['ProductName'], 'refNo' => $objPage->arrData['arrTodayOfferProduct']['offer_details'][0]['ProductRefNo'])); ?>" class="flipMore"><img src="common/images/yellow-btn.jpg" alt=""/></a>-->
                        <?php
                        if ($perOff > 0)
                        {
                            ?>
                            <span class="offPrice">
                                <div id="offPriceText" ><span><?php echo $perOff . "%"; ?></span> <?php echo OFF; ?></div>
                            </span>
                        <?php } ?>
                    </div>
                </div>
                <?php include_once INC_PATH . 'home_middle_part.php'; ?>
            </div>
        </div>
        <?php include_once INC_PATH . 'footer.inc.php'; ?>
    </body>
</html>
