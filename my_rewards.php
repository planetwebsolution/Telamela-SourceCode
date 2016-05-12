<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_REWARD_CTRL;
$varAction=$_GET['action'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MY_REWARDS_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="common/css/layout1.css"/>
        <link rel="stylesheet" type="text/css" href="common/css/css3-2.css"/>         
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>product.css"/>
        <script src="<?php echo JS_PATH ?>jquery_cr.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH ?>jquery.jqzoom-core.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>skin.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
        <script src="<?php echo JS_PATH ?>jQueryRotate.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
           <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel2.js"></script>
        <script type="text/javascript">
            
            
            $(document).ready(function(){                
                $('.jqzoom').jqzoom({
                    zoomType: 'standard',
                    lens:true,
                    preloadImages: false,
                    alwaysOn:false
                });
                /*$('.product_img .jcarousel-clip ul').each(function(i){
                    $(this).jcarousel();
                });*/
            });
            
            function deleteFromWishList(pid,wishId)
            {
                $.post('<?php echo SITE_ROOT_URL; ?>common/ajax/ajax_customer.php',{pid:pid,wishId:wishId, action: "deleteFromWishlist"}, function(data){
                    if(data){
                        $('#wishlist_item'+pid).hide();
                    }
                });
            }
        </script>
		
    </head>
    <body>
        <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header" style=" border:none"><div class="layout">
               
            </div>
            </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
                 <div class="add_pakage_outer">
                   <div class="top_header border_bottom">
    <h1><?php echo MY_REWARDS; ?>  <span> <?php echo SUMMERY; ?></span></h1>
    </div>
<div class="cust_border">
    <div class="topname_links">  
        <a class="edit2 <?php if($varAction=='credit') echo 'edit2active'; ?>" href="<?php echo $objCore->getUrl('my_rewards.php', array('action' => 'credit')); ?>"><?php echo CREDIT_REWARDS; ?></a>
        <a class="edit2 <?php if($varAction=='debit') echo 'edit2active'; ?>" href="<?php echo $objCore->getUrl('my_rewards.php', array('action' => 'debit')); ?>"><?php echo DEBIT_REWARDS; ?></a>
        <a class="edit2 <?php if($varAction=='') echo 'edit2active'; ?>" href="<?php echo $objCore->getUrl('my_rewards.php'); ?>"><?php echo REWARDS_SUMMERY; ?></a>
    </div>
</div>

                    <div class="body_inner_bg radius">
                        <div class="add_edit_pakage wish_sec">                            
                            <ul class="order_sec1 ">
                                <li class="heading">
                                    <span class="product product1" style="width:168px"><?php echo POINTS; ?></span>
                                    <span class="price price1" style="width:168px"><?php echo TRANSTION_TYPE; ?></span>
                                    <span class="order order1" style="width:168px"> <?php echo DATE; ?></span>
                                    <span class="action action1"><?php echo SUMMERY; ?></span>
                                </li>
                                <?php
                                $varCounter = 0;
                                if (count($objPage->arrRes) > 0) {
                                    foreach ($objPage->arrRes as $arrDetail) {
                                        $varCounter++;
                                        ?>
                                        <li <?php echo $varCounter % 2 == 0 ? 'class="green_bg"' : '' ?>>
                                            <span class="product product1" style="width:168px"><?php echo $arrDetail['Points'] ?></span>
                                            <span class="price price1" style="width:168px"><?php echo ucwords($arrDetail['TransactionType']); ?></span>
                                            <span class="order order1" style="width:168px"><?php echo $objCore->localDateTime(date($arrDetail['RewardDateAdded']), DATE_FORMAT_SITE_FRONT); ?></span>
                                            <span class="action action1"><?php echo $arrDetail['Description'] ?></span>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    echo '<li class="no_resutl_found">' . ADMIN_NO_RECORD_FOUND . '</li>';
                                }
                                ?>
                            </ul>
                            <?php if (count($objPage->arrRes) > 0) { ?>
                                <table width="100%">
                                    <tr><td colspan="10">&nbsp;</td></tr>
                                    <tr>
                                        <td colspan="10">
                                            <table width="100%" border="0" align="center">
                                                <tr>
                                                    <td style="font-weight:bolder; text-align:right;" colspan="10" align="right">
                                                        <?php
                                                        if ($objPage->varNumberPages > 1) {
                                                            $objPage->displayFrontPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr></table>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>

    </body>
</html>
