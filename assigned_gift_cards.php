<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_ASSIGNED_GIFTCARDS_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MY_GIFT_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="common/css/layout1.css"/>        
        <script type="text/javascript">
            $(document).ready(function(){
                $('.drop_down1').sSelect();
                $('#compose_cancel').click(function(e){
                    $('#post_feeadback').css('display','none');
                    e.preventDefault();
                });
            });            
            function viewMyInvoice(){                
                $(".my_inv").colorbox({transition:"none", width:"1000px", height:"100%"});
                //  alert($('.'+str).attr('href'));
                // $("."+str).colorbox({iframe:true,innerWidth:900,innerHeight:700});
                
               
            }
            
        </script>
    </head>
    <body>
       
        <em> <div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
    
        </em>
       <div class="header"><div class="layout">
              
        </div>
       </div> <?php include_once INC_PATH . 'header.inc.php'; ?>
      
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
                
               

                <div class="add_pakage_outer">
                    <div class="top_container" style="padding-bottom:0px">
                        <div class="top_header border_bottom"><h1><?php echo MY; ?> <?php echo GIFTS; ?></h1></div>
                    </div>

                    <div class="body_inner_bg radius">
                    
                     <div class="topname_outer space_bot">
                                <div class="topname_inner">
                                   &nbsp;     
                                </div>
                                <div class="topname_links">
                                 <a class="edit2" href="<?php echo $objCore->getUrl('coupons_used.php', array('type' => 'edit')); ?>">Coupons Used</a>
                            <a class="edit2" href="<?php echo $objCore->getUrl('my_orders.php'); ?>"><?php echo MY_ORDER_TITLE ?></a>
                                </div>
                            </div>
                    
                        <div class="add_edit_pakage wish_sec">
                            
                            <ul class="order_sec1">
                                <li class="heading">
                                    <span style="width:150px;" class="price"><?php echo TRANJECTION_ID; ?></span>
                                    <span class="price" style="width:300px;"><?php echo GIFT_TITLE; ?></span>
                                    <span class="price" style="width:220px;"><?php echo GIFT_PRICE; ?></span>
                                    <span class="read"><?php echo OR_DATE; ?></span>

                                </li>

                                <?php
                                $varCounter = 0;
                                if (count($objPage->arrGiftList) > 0) {
                                    foreach ($objPage->arrGiftList as $details) {
                                        $varCounter++;
                                        $arrStatus = array('Pending' => 'Red', 'Completed' => 'green', 'Posted' => 'violet', 'Partial Completed' => 'violet');
                                        ?>
                                        <li <?php echo $varCounter % 2 == 0 ? 'class="green_bg"' : '' ?>>
                                            <span class="price" style="width:150px;"><a href="<?php echo $objCore->getUrl('my_order_details.php', array('action' => 'view', 'oid' => $details['pkOrderID'])); ?>" title="View Order"><?php echo $details['TransactionID']; ?>&nbsp;</a></span>
                                            <span class="price" style="width:300px;"><?php echo $details['Title']; ?></span>
                                            <span class="price" style="width:220px;"><?php echo $objCore->getPrice($details['Amount']); ?></span>
                                            <span class="read"><?php echo $objCore->localDateTime(date($details['OrderDateAdded']), DATE_FORMAT_SITE_FRONT); ?></span>                                            
                                        </li>
                                        <?php
                                    }
                                } else {
                                    echo '<li class="no_resutl_found">' . FRONT_CUSTOMER_ORDERLIST_ERROR_MSG1 . '</li>';
                                }
                                ?>
                            </ul>
                            <?php if (count($objPage->arrGiftNum) > 0) { ?>
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
