<?php
require_once '../config/config.inc.php';
require_once(CLASSES_PATH . 'class_common.php');
require_once(CLASSES_PATH . 'class_category_bll.php');
require_once CONTROLLERS_PATH . FILENAME_PRODUCT_CTRL;
$objClassCommon = new ClassCommon();
$objCategory = new Category();
$objCore = new Core();
$objProduct = new Product();

//Get Posted data
$case = $_POST['action'];
//pre($case);
switch ($case)
{
    case 'addToCompare':
        if (isset($_SESSION['MyCompare']['Product'][$_REQUEST['pid']]))
        {
            echo 'already';
        }
        else if (isset($_SESSION['MyCompare']['ProductCategory']) && $_SESSION['MyCompare']['ProductCategory'] <> $_REQUEST['cid'])
        {
            echo 'notSameCategory';
        }
        else
        {

            $varTotalComp = count($_SESSION['MyCompare']['Product']);

            if ($varTotalComp < 4)
            {

                $_SESSION['MyCompare']['Product'][$_REQUEST['pid']] = $_REQUEST['pid'];
                $_SESSION['MyCompare']['ProductCategory'] = $_REQUEST['cid'];

                if (!empty($_SESSION['MyCompare']['Product']))
                {
                    $arrData['arrCompDetails'] = $objCategory->myCompareDetails();
                    $arrData['arrCompareDetails'] = $arrData['arrCompDetails']['product_details'];
                    ?>
                    <div class="compare_product">
                        <div class="heading1">Compare Products  (<?php echo count($arrData['arrCompareDetails']); ?>) </div>
                        <?php
                        for ($i = 0; $i <= 3; $i++)
                    {
                     if ($arrData['arrCompareDetails'][$i][0]['pkProductID'])
                     { 
                        
                            $varSrc = $objCore->getImageUrl($arrData['arrCompareDetails'][$i][0]['ImageName'], 'products/' . $arrProductImageResizes['default']);
                            ?>
                            <div class="compare_products"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $arrData['arrCompareDetails'][$i][0]['pkProductID'], 'name' => $arrData['arrCompareDetails'][$i][0]['ProductName'], 'refNo' => $arrData['arrCompareDetails'][$i][0]['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $arrData['arrCompareDetails'][$i][0]['ProductName'] ?>" border="0" /></a>
                                <div class="name_comp"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $arrData['arrCompareDetails'][$i][0]['pkProductID'], 'name' => $arrData['arrCompareDetails'][$i][0]['ProductName'], 'refNo' => $arrData['arrCompareDetails'][$i][0]['ProductRefNo'])); ?>"> <?php echo ucfirst($objCore->getProductName($arrData['arrCompareDetails'][$i][0]['ProductName'], 55)); ?></a> </div>
                                <div class="cross_icon"><a href="javascript:void(0)" onclick="RemoveProductFromCompare(<?php echo $arrData['arrCompareDetails'][$i][0]['pkProductID']; ?>);" title="Remove">X</a></div>
                            </div>
                            <?php
                        
                    }else{
                            ?>
                            <div class="blankCompare">Add another product</div>
                            <?php
                        }
                    
                        }
                        ?>
                        <a target="_blank" href="<?php echo $objCore->getUrl('product_comparison.php'); ?>" class="compare_btn <?php echo (count($arrData['arrCompareDetails']) < 2) ? 'not-active' : '' ?>">COMPARE</a>
                    </div>

                    <?php
                }
            }
            else
            {
                echo '4';
            }
        }

        break;
        
    case 'addToCompareCategory':
        $varTotalComp = count($_SESSION['MyCompare']['Product']);

            

                $_SESSION['MyCompare']['Product'][$_REQUEST['pid']] = $_REQUEST['pid'];
                $_SESSION['MyCompare']['ProductCategory'] = $_REQUEST['cid'];

                if (!empty($_SESSION['MyCompare']['Product']))
                {
                    $arrData['arrCompDetails'] = $objCategory->myCompareDetails();
                    $arrData['arrCompareDetails'] = $arrData['arrCompDetails']['product_details'];
                    echo count($arrData['arrCompareDetails']).'+++';
                    for ($i = 0; $i <= 3; $i++) {
                                       
                                        if ($arrData['arrCompareDetails'][$i][0]['pkProductID']) {
                                            $varSrc = $objCore->getImageUrl($arrData['arrCompareDetails'][$i][0]['ImageName'], 'products/' . $arrProductImageResizes['default']);
                                            ?>
                                            <li>
                                                <div class="compare_products"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $arrData['arrCompareDetails'][$i][0]['pkProductID'], 'name' => $arrData['arrCompareDetails'][$i][0]['ProductName'], 'refNo' => $arrData['arrCompareDetails'][$i][0]['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $arrData['arrCompareDetails'][$i][0]['ProductName'] ?>" border="0" /></a>
                                                    <div class="name_comp"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $arrData['arrCompareDetails'][$i][0]['pkProductID'], 'name' => $arrData['arrCompareDetails'][$i][0]['ProductName'], 'refNo' => $arrData['arrCompareDetails'][$i][0]['ProductRefNo'])); ?>"> <?php echo ucfirst($objCore->getProductName($arrData['arrCompareDetails'][$i][0]['ProductName'], 18)); ?></a> </div>
                                                    
                                                </div>
                                                <div class="cross_icon"><a href="javascript:void(0)" onclick="RemoveProductFromCompare(<?php echo $arrData['arrCompareDetails'][$i][0]['pkProductID']; ?>);" title="Remove">X</a></div>
                                            </li>   
                                            <?php
                                        } else {
                                            ?>
                                            <li><div class="blankCompare">Add another product</div></li>
                                            <?php
                                        }
                                    }
                   
                }
            
        
   break;
    case 'RemoveProductFromCompare':
        if (count($_SESSION['MyCompare']['Product']) == 1)
        {
            unset($_SESSION['MyCompare']['ProductCategory']);
        }
        if (isset($_SESSION['MyCompare']['Product'][$_REQUEST['pid']]))
        {
            unset($_SESSION['MyCompare']['Product'][$_REQUEST['pid']]);
        }
        ?>

        <div class="comapre_product" id="comapreProductsId">
            <div class="heading1">Compare Products  (<?php echo count($_SESSION['MyCompare']['Product']); ?>) </div>

            <?php
            if (!empty($_SESSION['MyCompare']['Product']))
            {
                ?>

                <?php
                $arrData['arrCompDetails'] = $objCategory->myCompareDetails();
                $arrData['arrCompareDetails'] = $arrData['arrCompDetails']['product_details'];
                
                        for ($i = 0; $i <= 3; $i++)
                    {
                     if ($arrData['arrCompareDetails'][$i][0]['pkProductID'])
                     { 
                        
                            $varSrc = $objCore->getImageUrl($arrData['arrCompareDetails'][$i][0]['ImageName'], 'products/' . $arrProductImageResizes['default']);
                            ?>
                            <div class="compare_products"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $arrData['arrCompareDetails'][$i][0]['pkProductID'], 'name' => $arrData['arrCompareDetails'][$i][0]['ProductName'], 'refNo' => $arrData['arrCompareDetails'][$i][0]['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $arrData['arrCompareDetails'][$i][0]['ProductName'] ?>" border="0" /></a>
                                <div class="name_comp"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $arrData['arrCompareDetails'][$i][0]['pkProductID'], 'name' => $arrData['arrCompareDetails'][$i][0]['ProductName'], 'refNo' => $arrData['arrCompareDetails'][$i][0]['ProductRefNo'])); ?>"> <?php echo ucfirst($objCore->getProductName($arrData['arrCompareDetails'][$i][0]['ProductName'], 55)); ?></a> </div>
                                <div class="cross_icon"><a href="javascript:void(0)" onclick="RemoveProductFromCompare(<?php echo $arrData['arrCompareDetails'][$i][0]['pkProductID']; ?>);" title="Remove">X</a></div>
                            </div>
                            <?php
                        
                    }else{
                            ?>
                            <div class="blankCompare">Add another product</div>
                            <?php
                        }
                    
                        }
                        ?>

                <a target="_blank" href="<?php echo $objCore->getUrl('product_comparison.php'); ?>" class="compare_btn <?php echo (count($arrData['arrCompareDetails']) < 2) ? 'not-active' : '' ?>"><?php echo COMPARE; ?></a>
            <?php } ?>
        </div>
        <?php
        break;
    case 'RemoveProductFromCompareCategory':
        
            if (!empty($_SESSION['MyCompare']['Product']))
                {
                    $arrData['arrCompDetails'] = $objCategory->myCompareDetails();
                    $arrData['arrCompareDetails'] = $arrData['arrCompDetails']['product_details'];
                    echo count($arrData['arrCompareDetails']).'+++';
                    for ($i = 0; $i <= 3; $i++) {
                                       
                                        if ($arrData['arrCompareDetails'][$i][0]['pkProductID']) {
                                            $varSrc = $objCore->getImageUrl($arrData['arrCompareDetails'][$i][0]['ImageName'], 'products/' . $arrProductImageResizes['default']);
                                            ?>
                                            <li>
                                                <div class="compare_products"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $arrData['arrCompareDetails'][$i][0]['pkProductID'], 'name' => $arrData['arrCompareDetails'][$i][0]['ProductName'], 'refNo' => $arrData['arrCompareDetails'][$i][0]['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $arrData['arrCompareDetails'][$i][0]['ProductName'] ?>" border="0" /></a>
                                                    <div class="name_comp"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $arrData['arrCompareDetails'][$i][0]['pkProductID'], 'name' => $arrData['arrCompareDetails'][$i][0]['ProductName'], 'refNo' => $arrData['arrCompareDetails'][$i][0]['ProductRefNo'])); ?>"> <?php echo ucfirst($objCore->getProductName($arrData['arrCompareDetails'][$i][0]['ProductName'], 22)); ?></a> </div>
                                                    
                                                </div>
                                                <div class="cross_icon"><a href="javascript:void(0)" onclick="RemoveProductFromCompare(<?php echo $arrData['arrCompareDetails'][$i][0]['pkProductID']; ?>);" title="Remove">X</a></div>
                                            </li>   
                                            <?php
                                        } else {
                                            ?>
                                            <li><div class="blankCompare">Add another product</div></li>
                                            <?php
                                        }
                                    }
                   
                }else{
                  echo count($arrData['arrCompareDetails']).'+++';  
                  for ($i = 0; $i <= 3; $i++) { ?>
                      <li><div class="blankCompare">Add another product</div></li>
                 <?php }  
                } 
    break;   
    case 'RemoveFromComparison':
        if (count($_SESSION['MyCompare']['Product']) == 1)
        {
            unset($_SESSION['MyCompare']['ProductCategory']);
        }
        if (isset($_SESSION['MyCompare']['Product'][$_REQUEST['pid']]))
        {
            unset($_SESSION['MyCompare']['Product'][$_REQUEST['pid']]);
        }


        if (!empty($_SESSION['MyCompare']['Product']))
        {
            ?>
            <ul>
                <?php
                $arrData['arrCompDetails'] = $objCategory->myCompareDetails();
                $arrData['arrCompareDetails'] = $arrData['arrCompDetails']['product_details'];
                $arrData['arrAttributeList'] = $arrData['arrCompDetails']['category_attribute'];
                $arrData['arrCompareAttributeDetails'] = $arrData['arrCompDetails']['product_attribute'];
                $varCountComp = 0;
                foreach ($arrData['arrCompareDetails'] as $valProductCompare)
                {


                    $varSrc = $objCore->getImageUrl($valProductCompare[0]['ImageName'], 'products/' . $arrProductImageResizes['listing']);

                    $attr = array();
                    foreach ($arrData['arrCompareAttributeDetails'][$varCountComp] as $attribArray)
                    {
                        $attr[$attribArray['pkAttributeId']] = $attribArray['OptionTitle'];
                    }
                    // echo '<pre>',print_r($objPage->arrData['arrAttributeList']),'</pre>';
                    ?>
                    <li <?php
                if (($varCountComp) % 4 == 0)
                {
                        ?>class="first"<?php } ?>>

                        <div class="thumbs_comp">
                            <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valProductCompare[0]['pkProductID'], 'name' => $valProductCompare[0]['ProductName'], 'refNo' => $valProductCompare[0]['ProductRefNo'])); ?>">
                                <img align="middle" alt="" src="<?php echo $varSrc; ?>" />
                            </a>
                        </div>
                        <div class="product_detail">
                            <h4><?php echo $objCore->getProductName($valProductCompare[0]['ProductName'], 30); ?></h4>
                            <p><b>Wholesaler : </b> <?php echo ucfirst($valProductCompare[0]['WholeSalerName']); ?></p>
                            <?php
                            foreach ($arrData['arrAttributeList'][$varCountComp] as $valueAttr)
                            {
                                // pre($objPage->arrData['arrCompareAttributeDetails'][6]);

                                echo '<p><b>' . $valueAttr['AttributeLabel'] . '</b>: <br/> ';

                                if ($attr[$valueAttr['pkAttributeId']] != "")
                                {
                                    echo $attr[$valueAttr['pkAttributeId']];
                                }
                                else
                                {
                                    echo "NA";
                                }
                                echo '</p>';
                            }
                            ?>

                        </div>
                        <div class="my_compare_div">
                            <div class="product_detail">
                                <b> Price:</b><br/> <span>
                                    <?php
                                    if ($valProductCompare[0]['DiscountFinalPrice'] > 0)
                                    {
                                        echo '<small>' . $objCore->getPrice($valProductCompare[0]['FinalPrice']) . '</small><br /><strong>' . $objCore->getPrice($valProductCompare[0]['DiscountFinalPrice']) . '</strong>';
                                    }
                                    else
                                    {

                                        echo '<br /><strong>' . $objCore->getPrice($valProductCompare[0]['FinalPrice']) . '</strong>';
                                    }
                                    ?>
                                </span>
                            </div>
                            <span class="success" style="margin-left:0px;display:none" id="addCompCartSuc_<?php echo $valProductCompare[0]['pkProductID']; ?>"><?php echo PRODUCT_ADD_IN_SHOPING_CART; ?></span>
                            <a href="javascript:(void);" class="con_shoping" <?php
                    if ($valProductCompare[0]['Attribute'] == 0)
                    {
                                        ?>onclick="addToCartMsg(<?php echo $valProductCompare[0]['pkProductID']; ?>);addToCart(<?php echo $valProductCompare[0]['pkProductID']; ?>);"<?php
                }
                else
                {
                                        ?>onclick="window.location='<?php echo $objCore->getUrl('product.php', array('id' => $valProductCompare[0]['pkProductID'], 'name' => $valProductCompare[0]['ProductName'], 'refNo' => $valProductCompare[0]['ProductRefNo'], 'add' => 'addCart')); ?>#addCart';"<?php } ?>><span>Add to Cart</span></a>
                            <a href="javascript:(void);" class="con_shoping remove" onclick="RemoveFromComparison(<?php echo $valProductCompare[0]['pkProductID']; ?>);"><span>Remove from the list</span></a>
                        </div>


                    </li>
                    <?php
                    $varCountComp++;
                }
                ?>
            </ul>
            <!--
                        <ul style="float: left">
            <?php
            foreach ($arrData['arrCompareDetails'] as $keyProductCompare => $valProductCompare)
            {
                ?>

                                                                    <li <?php
                if ($keyProductCompare % 5 == 0)
                {
                    ?>class="first"<?php } ?>>


                                                                        <div class="product_detail">
                                                                            <b> Price</b><br/> <span>
                <?php
                if ($valProductCompare[0]['DiscountFinalPrice'] > 0)
                {
                    echo '<small>' . $objCore->getPrice($valProductCompare[0]['FinalPrice']) . '</small><br /><strong>' . $objCore->getPrice($valProductCompare[0]['DiscountFinalPrice']) . '</strong>';
                }
                else
                {

                    echo '<br /><strong>' . $objCore->getPrice($valProductCompare[0]['FinalPrice']) . '</strong>';
                }
                ?>
                                                                            </span>
                                                                        </div>
                                                                        <span class="success" style="margin-left:0px;display:none" id="addCompCartSuc_<?php echo $valProductCompare[0]['pkProductID']; ?>"><?php echo PRODUCT_ADD_IN_SHOPING_CART; ?></span>
                                                                        <a href="javascript:(void);" class="con_shoping" <?php
                if ($valProductCompare[0]['Attribute'] == 0)
                {
                    ?>onclick="addToCartMsg(<?php echo $valProductCompare[0]['pkProductID']; ?>);addToCart(<?php echo $valProductCompare[0]['pkProductID']; ?>);"<?php
                }
                else
                {
                    ?>onclick="window.location='<?php echo $objCore->getUrl('product.php', array('id' => $valProductCompare[0]['pkProductID'], 'name' => $valProductCompare[0]['ProductName'], 'refNo' => $valProductCompare[0]['ProductRefNo'])); ?>';"<?php } ?>><span>Add to Cart</span></a>
                                                                        <a href="javascript:(void);" class="con_shoping remove" onclick="RemoveFromComparison(<?php echo $valProductCompare[0]['pkProductID']; ?>);"><span>Remove from the list</span></a>
                                                                    </li>

            <?php }
            ?></ul>
            -->


            <?php
        }
        else
        {
            echo '';
        }

        break;

    case 'addToRecommend':
        $objCategory->myRecommendedAdd($_REQUEST);
        $arrData['arrRecommendedDetails'] = $objCategory->myRecommendedDetails();
        if (!empty($arrData['arrRecommendedDetails']))
        {
            ?>

            <?php
            foreach ($arrData['arrRecommendedDetails'] as $valRecommended)
            {

                $varSrc = $objCore->getImageUrl($valRecommended['ImgName'], 'products/' . $arrProductImageResizes['default']);
                ?>
                <li>
                    <div class="bottom_border"><div class="image"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $valRecommended['pkProductID'], 'name' => $valRecommended['ProductName'], 'refNo' => $valRecommended['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" width="40" height="38" alt="" /></a></div>
                        <div class="details">
                            <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valRecommended['pkProductID'], 'name' => $valRecommended['ProductName'], 'refNo' => $valRecommended['ProductRefNo'])); ?>"><?php echo $valRecommended['ProductName']; ?></a>
                            <h5><?php echo $objCore->getPrice($valRecommended['FinalPrice']); ?></h5>
                            <small><?php echo RECOMEN_BY; ?> <?php echo $valRecommended['numRecommend']; ?> <?php echo PEOPLE; ?></small>
                        </div>
                    </div>
                </li>
                <?php
            }
        }

        break;

    case 'addToWishlist':
        $objCategory->myWishlistAdd($_REQUEST['pid']);

        break;

    case 'removeToWishlist':
        $objCategory->myWishlistRemove($_REQUEST['pid']);

        break;

    case 'AddToReview':
        ?>
        <div class="product_review_meassage" id="showReviewMessage">&nbsp;</div>
        <?php      
        $objProduct->userReviewAdd($_REQUEST);
        $arrproductReview = $objProduct->getUserReview($_REQUEST['frmProductId']);
        if (count($arrproductReview) > 0)
        {
            foreach ($arrproductReview as $valReview)
            {
                ?>
                <div class="top_customer">
                    <span class="iocn_2"><img  src="<?php echo IMAGE_FRONT_PATH_URL; ?>customer_icon.png" alt=""/></span>
                    <div class="review_sec1">
                        <h3><?php echo $valReview['CustomerName']; ?>
                            <span><?php echo $objProduct->_ago($objCore->localDateTime($valReview['ReviewDateUpdated'], DATE_TIME_FORMAT_DB)); ?></span>
                            <?php
                            if (isset($_SESSION['sessUserInfo']['id']))
                            {
                                if ($valReview['fkCustomerID'] == $_SESSION['sessUserInfo']['id'])
                                {
                                    ?>
                                    <span style="float:right !important">
                                        <a class="reviewEdit<?php echo $valReview['pkReviewID']; ?> edit active" href="#review_details<?php echo $valReview['pkReviewID']; ?>" onclick="review_edit(<?php echo $valReview['pkReviewID']; ?>)"></a>
                                        <a class="red_cross2 active" href="javascript:void();" onclick="return reviewDelete(<?php echo $valReview['pkReviewID']; ?>,<?php echo $valReview['fkProductID']; ?>);"></a>
                                    </span>
                                    <?php
                                }
                            }
                            ?>
                        </h3>
                        <?php echo ucfirst($valReview['Reviews']); ?>
                    </div>
                </div>
                <div style='display:none'>
                    <div id='review_details<?php echo $valReview['pkReviewID']; ?>' class="quick_color" style="padding:20px;" >
                        <table id="colorBox_table">
                            <tr align="left">
                                <td><strong><?php echo REVIEW; ?>: </strong></td>
                            </tr>
                            <tr>
                                <td align="left"><textarea name="ReviewMsg" id="ReviewMsg<?php echo $valReview['pkReviewID']; ?>" rows="4" class="input4"> <?php echo ucfirst($valReview['Reviews']); ?>    </textarea></td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <input type="hidden" id="ReviewProductId<?php echo $valReview['pkReviewID']; ?>" name="ReviewProductId" value="<?php echo $valReview['fkProductID']; ?>" />
                                    <input type="button" name="frmConfirmUpdate" onclick="return confirmUpdate(<?php echo $valReview['pkReviewID']; ?>);" value="Update" style="cursor: pointer;"/>
                                    &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelUpdate<?php echo $valReview['pkReviewID']; ?>" value="Cancel" style="cursor: pointer;"/> </td>
                            </tr>

                        </table>

                    </div>
                </div>
                <?php
            }
        }
        ?>

        <?php
        break;

    case 'deleteReview':
        ?>
        <div class="product_review_meassage" id="showReviewMessage">&nbsp;</div>
        <?php
        $objProduct->userReviewDelete($_REQUEST['rid']);
        $arrproductReview = $objProduct->getUserReview($_REQUEST['pid']);
        if (count($arrproductReview) > 0)
        {
            foreach ($arrproductReview as $valReview)
            {
                ?>
                <div class="top_customer">
                    <span class="iocn_2"><img  src="<?php echo IMAGE_FRONT_PATH_URL; ?>customer_icon.png" alt=""/></span>
                    <div class="review_sec1">
                        <h3><?php echo $valReview['CustomerName']; ?>
                            <span><?php echo $objProduct->_ago($objCore->localDateTime($valReview['ReviewDateUpdated'], DATE_TIME_FORMAT_DB)); ?></span>
                            <?php
                            if (isset($_SESSION['sessUserInfo']['id']))
                            {
                                if ($valReview['fkCustomerID'] == $_SESSION['sessUserInfo']['id'])
                                {
                                    ?>
                                    <span style="float:right !important">
                                        <a class="reviewEdit<?php echo $valReview['pkReviewID']; ?> edit active" href="#review_details<?php echo $valReview['pkReviewID']; ?>" onclick="review_edit(<?php echo $valReview['pkReviewID']; ?>)"></a>
                                        <a class="red_cross2 active" href="javascript:void();" onclick="return reviewDelete(<?php echo $valReview['pkReviewID']; ?>,<?php echo $valReview['fkProductID']; ?>);"></a>
                                    </span>
                                    <?php
                                }
                            }
                            ?>
                        </h3>
                        <?php echo ucfirst($valReview['Reviews']); ?>
                    </div>
                </div>

                <div style='display:none'>
                    <div id='review_details<?php echo $valReview['pkReviewID']; ?>' class="quick_color" style="padding:20px;" >
                        <table id="colorBox_table">
                            <tr align="left">
                                <td><strong><?php echo REVIEW; ?>: </strong></td>
                            </tr>
                            <tr>
                                <td align="left"><textarea name="ReviewMsg" id="ReviewMsg<?php echo $valReview['pkReviewID']; ?>" rows="4" class="input4"> <?php echo ucfirst($valReview['Reviews']); ?>    </textarea></td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <input type="hidden" id="ReviewProductId<?php echo $valReview['pkReviewID']; ?>" name="ReviewProductId" value="<?php echo $valReview['fkProductID']; ?>" />
                                    <input type="button" name="frmConfirmUpdate" onclick="return confirmUpdate(<?php echo $valReview['pkReviewID']; ?>);" value="Update" style="cursor: pointer;"/>
                                    &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelUpdate<?php echo $valReview['pkReviewID']; ?>" value="Cancel" style="cursor: pointer;"/> </td>
                            </tr>

                        </table>

                    </div>
                </div>
                <?php
            }
        }
        ?>

        <?php
        break;


    case 'UpdateReview':
        ?>
        <div class="product_review_meassage" id="showReviewMessage">&nbsp;</div>
        <?php
        $objProduct->userReviewUpdate($_REQUEST['rid'], $_REQUEST['review']);
        $arrproductReview = $objProduct->getUserReview($_REQUEST['pid']);
        if (count($arrproductReview) > 0)
        {
            foreach ($arrproductReview as $valReview)
            {
                ?>
                <div class="top_customer">
                    <span class="iocn_2"><img  src="<?php echo IMAGE_FRONT_PATH_URL; ?>customer_icon.png" alt=""/></span>
                    <div class="review_sec1">
                        <h3><?php echo $valReview['CustomerName']; ?>
                            <span><?php echo $objProduct->_ago($objCore->localDateTime($valReview['ReviewDateUpdated'], DATE_TIME_FORMAT_DB)); ?></span>
                            <?php
                            if (isset($_SESSION['sessUserInfo']['id']))
                            {
                                if ($valReview['fkCustomerID'] == $_SESSION['sessUserInfo']['id'])
                                {
                                    ?>
                                    <span style="float:right !important">
                                        <a class="reviewEdit<?php echo $valReview['pkReviewID']; ?> edit active" href="#review_details<?php echo $valReview['pkReviewID']; ?>" onclick="review_edit(<?php echo $valReview['pkReviewID']; ?>)"></a>
                                        <a class="red_cross2 active" href="javascript:void();" onclick="return reviewDelete(<?php echo $valReview['pkReviewID']; ?>,<?php echo $valReview['fkProductID']; ?>);"></a>
                                    </span>
                                    <?php
                                }
                            }
                            ?>
                        </h3>
                        <?php echo ucfirst($valReview['Reviews']); ?>
                    </div>
                </div>

                <div style='display:none'>
                    <div id='review_details<?php echo $valReview['pkReviewID']; ?>' class="quick_color" style="padding:20px;" >
                        <table id="colorBox_table">
                            <tr align="left">
                                <td><strong><?php echo REVIEW; ?>: </strong></td>
                            </tr>
                            <tr>
                                <td align="left"><textarea name="ReviewMsg" id="ReviewMsg<?php echo $valReview['pkReviewID']; ?>" rows="4" class="input4"> <?php echo ucfirst($valReview['Reviews']); ?>    </textarea></td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <input type="hidden" id="ReviewProductId<?php echo $valReview['pkReviewID']; ?>" name="ReviewProductId" value="<?php echo $valReview['fkProductID']; ?>" />
                                    <input type="button" name="frmConfirmUpdate" onclick="return confirmUpdate(<?php echo $valReview['pkReviewID']; ?>);" value="Update" style="cursor: pointer;"/>
                                    &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelUpdate<?php echo $valReview['pkReviewID']; ?>" value="Cancel" style="cursor: pointer;"/> </td>
                            </tr>

                        </table>

                    </div>
                </div>
                <?php
            }
        }
        ?>

        <?php
        break;

    case 'addSocialRewards':
    	
		$cid = (isset($_SESSION['sessUserInfo']['id']) && $_SESSION['sessUserInfo']['type'] == 'customer') ? $_SESSION['sessUserInfo']['id'] : 0;
        $objGeneral->addRewards($cid, 'RewardOnSocialMediaSharing');

        break;
    case 'addSubscribeRewards':
        $arrCust = $objProduct->CustomerIdByEmailForSubscribe($_REQUEST['email']);
        $cid = (int) $arrCust['pkCustomerID'];
        $objGeneral->addRewards($cid, 'RewardOnNewsletterSubscribe');
        $objGeneral->updateCustomerSubscribe($cid, 1);
     break;
 
    case 'checkCompareCount':
    echo count($_SESSION['MyCompare']['Product']);    
    break;   
     
}
?>