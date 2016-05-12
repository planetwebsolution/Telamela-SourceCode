<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_ORDERLIST_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MY_ORDER_TITLE; ?></title>
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
        <style>
            .notshow{ display: none;}
        </style>
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
                    <div class="top_container">
                       <div class="top_header border_bottom"><h1><?php echo MY; ?> <?php echo ORDERS; ?></h1></div>
                       
                    </div>

                    <div class="body_inner_bg radius">
                    
                    <div class="topname_outer space_bot">
                                <div class="topname_inner">
                                   &nbsp;     
                                </div>
                                <div class="topname_links">
                                   <a class="edit2" href="<?php echo $objCore->getUrl('coupons_used.php', array('type' => 'edit')); ?>">Coupons Used</a>
                            <a class="edit2" href="<?php echo $objCore->getUrl('assigned_gift_cards.php', array('type' => 'edit')); ?>">Assigned Gift Cards</a>
                                </div>
                            </div>
                            
                        <div class="add_edit_pakage order_wish_sec">			    
                            
                            <ul class="order_sec1">
                                <li class="heading">
                                    <span style="width:80px;" class="product"><?php echo ORDER_ID; ?></span>
                                    <span style="width:80px;" class="product notshow"><?php echo SUB_ORDER_ID; ?></span>
                                    <span style="width:234px;" class="order"><?php echo TRANJECTION_ID; ?></span>
                                    <span class="price" style="width:200px;"><?php echo TOTAL_PRICE; ?></span>
                                    <span class="order"><?php echo OR_DATE; ?></span>
                                    <span style="width:120px;" class="status"><?php echo STATUS; ?></span>
                                    <span class="rite_bd action" style="width:110px;"><?php echo INVOICE; ?></span>
                                </li>
                                <?php
                                $varCounter = 0;
                                if (count($objPage->arrOrderlistProducts) > 0) {
                                    foreach ($objPage->arrOrderlistProducts as $details) {
                                    	//pre($details);
                                        $varCounter++;
                                        $arrStatus = array('Pending' => 'Red', 'Completed' => 'green', 'Posted' => '#ffb11b', 'Partial Completed' => '#ffb11b');
                                        //echo $details['status'];
                                        ?>
                                        <li <?php echo $varCounter % 2 == 0 ? 'class="green_bg"' : '' ?>>
                                            <span class="product" style="width:80px;"><?php echo $details['pkOrderID'] ?></span>
                                            <span class="product notshow" style="width:80px;"><?php echo $details['SubOrderID'] ?></span>
                                            <span class="order" style="width:234px;"><a href="<?php echo $objCore->getUrl('my_order_details.php', array('action'=>'view','oid' => $details['pkOrderID'])); ?>" title="View Order"><?php echo $details['TransactionID']; ?>&nbsp;</a></span>
                                            <span class="price" style="width:200px;"><?php echo $objCore->getPrice($details['Amount']); ?></span>
                                            <span class="order"><?php echo $objCore->localDateTime(date($details['OrderDateAdded']), DATE_FORMAT_SITE_FRONT); ?></span>
                                            <span style="width:120px; color: <?php echo $arrStatus[$details['status']]; ?>" class="status"><?php echo $details['status']; ?></span>
                                            <span class="rite_bd" style="width:110px;">                                                
                                                <?php 
                                               // print_r($details['invoice']);die;
                                                
                                                if ($details['invoice'] > 0 && $details['invoices'][0]['InvoiceFileName']) {
                                                    foreach($details['invoices'] as $kI => $vI){
                                                    ?>
                                                <a href="<?php echo INVOICE_URL . 'customer/' . $vI['InvoiceFileName']; ?>" target="_blank" title="View Invoice for sub order <?php echo $vI['fkSubOrderID']?>" style="display:block"><i class="fa fa-eye"></i></a>

                                                <?php }} ?> 
                                            </span>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    echo '<li class="no_resutl_found">' . FRONT_CUSTOMER_ORDERLIST_ERROR_MSG1 . '</li>';
                                }
                                ?>
                            </ul>
                            <?php if (count($objPage->arrOrderlistProducts) > 0) { ?>
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
                                    </tr>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>
