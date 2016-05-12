<!--<style>.owl_main > .owl-wrapper-outer> .owl-wrapper > .owl-item{ width:266px !important }</style>-->
<script type="text/javascript">
    function addToWishlistCheckCustLogin(ID){
        $('.msgCustNot_'+ID).show();
        $('.msgCustNot_'+ID).html('<span class="red">Please login as customer.</span>');
        setTimeout(function(){
            $('.msgCustNot_'+ID).hide();
        },3000);
    }
</script>
<style>
.blankCompare{width:100%;text-indent:75px;padding: 29px 0 ;font-size: 12px !important;background:#fff;color:#b3b3b3;border:1px solid #eee;margin-bottom:23px;}
.not-active { pointer-events: none;cursor: default;background:#e9e9e9;}
.compare_products img{ float:left;}
.name_comp a {
    color: #000;
    text-decoration: none;
    font-size:12px; 
}
.name_comp a:hover{
color: #1f7a99;
    text-decoration: underline;

}

</style>
<div id="right">
    <!---start slider--->
    <?php
            if (count($objPage->arrData['arrRecommendedDetails']) > 0)
            {
                ?>
    <div class="quick_title"><span>YOU MAY ALSO LIKE</span></div>
    <div id="owl-demo" class="owl-carousel owl_main" style="/*height:510px;*/ position:relative">
        <div class="item">
            
                <?php
                $counter = 0;
                foreach ($objPage->arrData['arrRecommendedDetails'] as $key => $valRecommended)
                {
                    $counter++;
                    $varSrc = $objCore->getImageUrl($valRecommended['ImgName'], 'products/' . $arrProductImageResizes['recomended']);
                    ?>
                    <div class="sections">
                        <div class="items"> <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valRecommended['pkProductID'], 'name' => $valRecommended['ProductName'], 'refNo' => $valRecommended['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valRecommended['ProductName']; ?>" border="0"/></a> </div>
                        <div class="txt_left">
                            <div class="name"><a style="color:gray" href="<?php echo $objCore->getUrl('product.php', array('id' => $valRecommended['pkProductID'], 'name' => $valRecommended['ProductName'], 'refNo' => $valRecommended['ProductRefNo'])); ?>"><?php echo $objCore->getProductName($valRecommended['ProductName'], 12); ?></a></div>
                            <div class="price"><?php echo $objCore->getFinalPrice($valRecommended['FinalPrice'], $valRecommended['DiscountFinalPrice'], 0, 0, 1); ?></div>
                            <div class="star">
                                <div class="inner_rating avg_rating">
                                    <?php
                                    $arrRatingDetails = $objProduct->myRatingDetails($valRecommended['pkProductID']);
                                    $productRate = ($arrRatingDetails[0]['numRating']) / ($arrRatingDetails[0]['numCustomer']);
                                    echo $objComman->getRatting($productRate);
                                    ?>
                                </div>
                            </div>
                            <?php
                            if ($_SESSION['sessUserInfo']['type'] == 'customer')
                            {
                                if (in_array($valRecommended['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true))
                                {
                                    ?>
                                    <a href='javascript:void(0)' class='info afterSavedInWishList' style='background: red;color: white;padding: 5px 20px 5px 20px;float: left;'>Saved</a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="javascript:void(0)" class="info saveTowishlist cart_right" id="<?php echo $valRecommended['pkProductID']; ?>" Pid="<?php echo $valRecommended['pkProductID']; ?>" tp="recomended">Save</a>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
<!--                                <a href="javascript:void(0)" onclick="addToWishlistCheckCustLogin('<?php echo $valRecommended['pkProductID']; ?>')" class="info saveTowishlistCustomer cart_right" id="<?php echo $valRecommended['pkProductID']; ?>" tp="recomended">Save</a>-->
                                    <a class="jscallLoginBox style_login" onclick="return jscallLoginBox('jscallLoginBox');" href="#loginBox">Login</a>
                            <!--<a href="#loginBoxReview" class="info jscallLoginBoxReview cart_right" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview','wish',<?php echo ($val['pkProductID']) ? $val['pkProductID'] : $valRecommended['pkProductID']; ?>);" >Save</a>-->
                                <span class="msgCustNot_<?php echo $valRecommended['pkProductID']; ?>" style="display: none;">&nbsp;</span>
                            <?php } ?>
        <!--												<a href="#" class="cart"><i class="fa fa-shopping-cart"></i>ADD TO CART</a> </div>-->
                        </div>
                    </div>
                    <?php
                    if (count($objPage->arrData['arrRecommendedDetails']) == $counter)
                    {
                        echo '</div>';
                        break;
                    }
                    if ($counter % 3 == 0)
                    {
                        echo '</div><div class="item">';
                    }
                }
            //}
            ?>
        </div>
        <?php } ?>
        <!--end slider-->

        <div  id="ajaxAddToCompare">
            <?php
            if (count($objPage->arrData['arrCompareDetails']) > 0)
            {
                ?>
                <div class="compare_product">
                    <div class="heading1">Compare Products  (<?php echo count($objPage->arrData['arrCompareDetails']); ?>) </div>
                    <?php
                    for ($i = 0; $i <= 3; $i++)
                    {
                     if ($objPage->arrData['arrCompareDetails'][$i][0]['pkProductID'])
                     {   
                    
                        $varSrc = $objCore->getImageUrl($objPage->arrData['arrCompareDetails'][$i][0]['ImageName'], 'products/' . $arrProductImageResizes['default']);
                        ?>
                        <div class="compare_products"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrData['arrCompareDetails'][$i][0]['pkProductID'], 'name' => $objPage->arrData['arrCompareDetails'][$i][0]['ProductName'], 'refNo' => $objPage->arrData['arrCompareDetails'][$i][0]['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $objPage->arrData['arrCompareDetails'][$i][0]['ProductName'] ?>" border="0" /></a>
                            <div class="name_comp"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrData['arrCompareDetails'][$i][0]['pkProductID'], 'name' => $objPage->arrData['arrCompareDetails'][$i][0]['ProductName'], 'refNo' => $objPage->arrData['arrCompareDetails'][$i][0]['ProductRefNo'])); ?>"> <?php echo ucfirst($objCore->getProductName($objPage->arrData['arrCompareDetails'][$i][0]['ProductName'], 55)); ?></a> </div>
                            <div class="cross_icon"><a href="javascript:void(0)" onclick="RemoveProductFromCompare(<?php echo $objPage->arrData['arrCompareDetails'][$i][0]['pkProductID']; ?>);" title="Remove">X</a></div>
                        </div>
                        <?php
                    
                     }else
                        {
                            ?>
                            <div class="blankCompare">Add another product</div>
                            <?php
                        }
                    }
                    ?>
                    <a target="_blank" href="<?php echo $objCore->getUrl('product_comparison.php'); ?>" class="compare_btn <?php echo (count($objPage->arrData['arrCompareDetails']) < 2) ? 'not-active' : '' ?>">COMPARE</a>
                </div>
            <?php } ?>
        </div>

        <div class="heading1">Search goods in Store</div>
        <div class="form">
            <form class="left_section" action="<?php echo $objCore->getUrl('category.php'); ?>" method="post" name="frmGoodsSearch" onsubmit="return goodsSearchSubmit();" >
                <p id="goodsMsg" class="red" style="display:none;">Please enter your search keywords</p>
                <p id="goodsMsgEr" class="red" style="display:none;">Please enter valid Keyword</p>
                <label><?php echo KEYWORDS; ?></label>
                <input type="text" value=""  name="searchKey" id="frmKey" placeholder="search"/>
                <label><?php echo PRICE; ?></label>
                <input type="text" value="" class="small" name="frmPriceFrom" id="frmPriceFrom" placeholder="$">
                <span class="two">to</span>
                <input type="text" value="" name="frmPriceTo" class="small" id="frmPriceTo" placeholder="$" />
                <br />
                <div class="compare_btn_11">
                    <input type="submit" value="SUBMIT"/>
                </div>
                <input type="hidden" name="frmSearch" id="frmSearch" value="<?php echo SEND; ?>" />
            </form>
        </div>
        <div class="banner_block">
            <div class="ad">
                <?php
                if ($objPage->arrData['arrAdsDetails'][0]['AdType'] == 'link')
                {
                    ?>
                    <a href="<?php echo $objPage->arrData['arrAdsDetails'][0]['AdUrl'] ?>" target="_blank"><img src="<?php echo UPLOADED_FILES_URL; ?>images/ads/264x207/<?php echo $objPage->arrData['arrAdsDetails'][0]['ImageName'] ?>" alt="<?php echo $objPage->arrData['arrAdsDetails'][0]['Title'] ?>" border="0" title="<?php echo $objPage->arrData['arrAdsDetails'][0]['Title'] ?>"  width="258px" height="207px"/></a>
                    <?php
                }
                else
                {
                    ?>
                    <?php echo html_entity_decode(stripslashes($objPage->arrData['arrAdsDetails'][0]['HtmlCode'])); ?>
                <?php } ?>
            </div>
        </div>
        <div class="product_banner_detail"><img src="<?php echo SITE_ROOT_URL; ?>common/images/banner_3.jpg" width="264" /></div>
        
        <div class="product_banner_detail"><img src="<?php echo SITE_ROOT_URL; ?>common/images/banner_05.jpg" width="264" /></div>
    </div>
    <script>
        $(document).ready(function() {

            var owl = $("#owl-demo");

            owl.owlCarousel({
                itemsCustom : [
                    [0, 1],
                    [450, 1],
                    [600, 1],
                    [700, 1],
                    [1000, 1],
                    [1200, 1],
                    [1400, 1],
                    [1600, 1]
                ],
                navigation : true

            });

        });
    </script>