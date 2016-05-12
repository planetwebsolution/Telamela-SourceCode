<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_ORDER_CTRL;
$objWholesaler = new Wholesaler();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title> <?php echo CUS_ORDER_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script  type="text/javascript">
            $(document).ready(function(){
                $('.drop_down1').sSelect();
                $('#DateStart').datepick({dateFormat: 'dd-mm-yyyy',showTrigger:'<small><a href="javascript:void(0)"><img src="common/images/cal_icon.png" alt=""  class="trigger"/></a></small>'});
                $('#DateEnd').datepick({dateFormat: 'dd-mm-yyyy',showTrigger:'<small><a href="javascript:void(0)"><img src="common/images/cal_icon.png" alt=""  class="trigger"/></a></small>'});
               // $( document ).on("change",".order_status",function() {
                	 $('.order_status').change(function(){
                //$('.order_status').change(function(){
                    var status = $(this).val();
                    var currentstatus=$(this).attr('currentstatus');
                   // var selectedetxt = $("option:selected", this).text();
                    // console.log(status.toLowerCase(), selectedetxt.toLowerCase());
					if(status.toLowerCase() == currentstatus.toLowerCase()){
						return false;
					}
					
                    var orderId = $(this).attr('id');
                    var posted = $(this).attr('pid');
                    var portalmail = $(this).attr('portalmail');
                    var gatwayname = $(this).attr('gatwayname');
                   
                    //alert(portalmail);
                   
                    if(posted=='1' && status=='Disputed'){
                        //alert('Order Posted You can not '+status+' this Order');
                        $('#s'+orderId).html('<span class="red">Order Posted. You can not '+status+' this Order.</span>');
                        setTimeout(function(){$('#s'+orderId).html('');},1500);
                    }else{
                        if(status=='Disputed'){
                            $('#'+orderId).siblings('.newListSelected').find('.newList').css('height','26px');
                            $('#'+orderId).siblings('.newListSelected').find('.newList').html('<li><a href="JavaScript:void(0);">'+status+'</a></li>');                    
                        }
                        $.ajax({
                        	type: "POST",
                        	url: "admin/ajax.php",
                        	data: 'status=' + status + '&soid=' + orderId + '&portalmail=' +portalmail + '&gatwayname=' +gatwayname +'&action=changeOrderStatus',
                         	success:function(data){
                                $('#s'+orderId).html('<?php echo UPDATE_SUCC; ?>.');      
                                                          
                                  setTimeout(function(){$('#s'+orderId).html('');},1500);
                                  alert('Order status has been updated successfully.');
                                  location.reload();
                              }
                        	
                        	});
//                         $.ajax({
//                         	 type : 'POST',
//                             url:"ajax.php",
//                             //data : $('#trackingemailid').serialize()+ '&action=' + 'updateShipment',
//                            //data:{status:status,soid:orderId,mail:portalmail + '&action=' +'changeOrderStatus'},
//                             data : {status:status}+ '&action=' + 'changeOrderStatus',
//                             success:function(data){
                               // $('#s'+orderId).html('<?php echo UPDATE_SUCC; ?>.');                                
//                                 setTimeout(function(){$('#s'+orderId).html('');},1500);
//                                 //alert('Order status has been updated successfully.');
//                             }
//                         });
                    }
                });

                $("#spButton").click(function() {
                    $('.order_sec').slideToggle('slow');
                });
                $('.order_sec').addClass("<?php echo count($_POST) ? 'show' : 'hide'; ?>");
            });
        </script>
        <style>
            .order_sec{margin-bottom:20px; }
            .cal_sec small{ z-index:9999999999; right:5px;}
            .stylish-select .drop4 .selectedTxt {
                background: url("common/images/select2.png") no-repeat scroll 126% 5px #fff;width: 265px;
            }
            .manage_table .selectedTxt{ background-position:161% 0px}/*24/7/15D***/
            .SSContainerDivWrapper ul.newList{width:222px !important; margin-top:4px; text-align:left; border:1px solid #e7e7e7;}
            .stylish-select .drop4 .newListSelected{width:323px;}

            .stylish-select .SSContainerDivWrapper{top:30px !important;}
        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"> </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div class="wholesalerHeaderSection" style="width:100%; height:50px; padding-top:20px;border-bottom:1px solid #e7e7e7"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_container">
                    </div>
                    <div class="body_inner_bg">
                        <div class="add_edit_pakage aapplication_form aapplication_form2 wish_sec">
                            <div class="product_link">
                                <span class="add_link" id="spButton"><?php echo SEARCH_ORDER; ?></span>
                            </div>
                            <div class="order_sec">
                                <form action="" method="post" name="order_filter" id="order_filter" class="order_filter_input" >
									
                                    <ul class="left_sec">
                                        <li>
                                            <label><?php echo ORDER_ID; ?></label>
                                            <input type="text" value="<?php echo @$_POST['pkOrderID'] ?>" name="pkOrderID" id="pkOrderID" />
                                        </li>                                                                             
                                    </ul>
                                    <ul class="left_sec right">
                                     <li>
                                            <label><?php echo CUSTOMER; ?> <?php echo NAME; ?></label>
                                            <input type="text" value="<?php echo $_POST['CustomerFirstName'] ?>" name="CustomerFirstName"/>
                                        </li>
                                    </ul>

                                     <ul class="left_sec">
                                      <li class="cb">
                                            <label><?php echo ORDER_STATUS; ?></label>
                                            <div class="drop4">
                                                <select class="drop_down1" name="OrderStatus" id="OrderStatus">
                                                    <option value=""><?php echo SEL_ORDER_STATUS; ?></option>
                                                    <option <?php echo $_POST['OrderStatus'] == 'Pending' ? 'selected' : '' ?> value="Pending"><?php echo PEN; ?></option>
                                                    <!--<option <?php echo $_POST['OrderStatus'] == 'Posted' ? 'selected' : '' ?> value="Posted"><?php echo DEL; ?></option>-->
                                                    <option <?php echo $_POST['OrderStatus'] == 'Processing' ? 'selected' : '' ?> value="Processing"><?php echo "Processing"; ?></option>
                                                    <option <?php echo $_POST['OrderStatus'] == 'Processed' ? 'selected' : '' ?> value="Processed"><?php echo "Processed"; ?></option>
                                                    <option <?php echo $_POST['OrderStatus'] == 'Shipped' ? 'selected' : '' ?> value="Shipped"><?php echo "Shipped"; ?></option>
                                                    <option <?php echo $_POST['OrderStatus'] == 'Delivered' ? 'selected' : '' ?> value="Delivered"><?php echo "Delivered"; ?></option>
                                                  <option <?php echo $_POST['OrderStatus'] == 'Completed' ? 'selected' : '' ?> value="Completed"><?php echo COM; ?></option>
                                                    <option <?php echo $_POST['OrderStatus'] == 'Canceled' ? 'selected' : '' ?> value="Canceled"><?php echo CANCELED; ?></option>
                                                </select>
                                            </div>
                                        </li>  
                                     </ul>


                                    <ul class="left_sec right">
                                       
                                        <li class="cb">
                                            <label><?php echo OR_DATE; ?></label>
                                            <div class="input_sec input_sec2">
                                                <div class="cal_sec">
                                                    <!--<span><?php echo ST_DATE; ?></span>-->
                                                    <input id="DateStart" style="z-index: 33; " type="text" value="<?php echo $_POST['StartDate'] ?>" name="StartDate" class="text3"/>
<!--                                                    <small><a href="#"><img src="common/images/cal_icon.png" alt=""  class="trigger"/></a></small>-->
                                                </div>
                                                <div class="cal_sec">
                                                    <span><?php echo TO; ?></span>
                                                    <input type="text" style="z-index: 33;" id="DateEnd" value="<?php echo $_POST['EndDate'] ?>" name="EndDate" class="text3"/>
                                                    <!--<small><a href="#"><img src="common/images/cal_icon.png" alt=""/></a></small>-->
                                                </div>
                                            </div>
                                        </li>
                                    </ul>


                                    <ul class="left_sec">
                                    <li class="cb">
                                            <label>&nbsp;</label>
                                            <input type="submit" class="submit2 submit3 my_submit_btn" value="Search"/>
                                            <!--<a href="<?php echo $objCore->getUrl('customer_orders.php'); ?>">-->
                                            <input onclick="window.location.href='<?php echo $objCore->getUrl('customer_orders.php'); ?>'" type="button" class="submit2 cancel" value="Cancel" style="margin-top:7px; height:39px;"/>
                                            <!--</a>-->
                                        </li>
                                    </ul>
                                    <input type="hidden" name="search" value="search" />
                                </form>
                            </div>

							<div class="table-responsive">
                            <table border="0" class="manage_table">
                                <tr>
                                    <th><?php echo ORDER_ID; ?></th>                                    
                                    <th><?php echo OR_DATE; ?></th>
                                    <th><?php echo ITEM; ?></th>
                                    <th><?php echo GRAND_TOTAL; ?></th>
                                    <th><?php echo CUSTOMER . ' ' . NAME; ?></th>
                                    <th><?php echo ORDER_STATUS; ?></th>
                                    <th><?php echo ACTION; ?></th>
                                </tr>
                                
                                <?php
                                $varCounter = 0;
                                
                                if (count($objPage->arrOrders) > 0)
                                {
                                    foreach ($objPage->arrOrders as $order)
                                    {
                                        //pre($objPage->arrOrders);
                                    	$wholesaler= $objWholesaler->wholesaleridshippingidfront($order['pkOrderItemID']);
                                    	//pre($wholesaler);
                                    	$wholesalerid=$wholesaler[0]['fkWholesalerID'];
                                    	$fkShippingIDs=$wholesaler[0]['fkShippingIDs'];
                                    	$wholesalercountryid= $objWholesaler->wholesalercountryfront($wholesalerid);
                                    	$wholesalercountry = $wholesalercountryid[0]['CompanyCountry'];
                                    		
                                    	$wholesalercountryportalid= $objWholesaler->wholesalercountryportalfront($wholesalercountry);
                                    	$portalid=$wholesalercountryportalid[0]['pkAdminID'];
                                    	// 									//pre($portalid);
                                    	// 									//echo $portalid .'&'. $fkShippingIDs;
//                                    	$gatwaymailid=$objWholesaler->getwaymailidusingportalfront($portalid,$fkShippingIDs);
//                                    	$portalmail=$gatwaymailid[0]['gatewayEmail'];
//                                    	$gatwaynamearray=$objGeneral->getshippingcompanyname($fkShippingIDs);
//                                    	$gatwayname= $gatwaynamearray[0]['ShippingTitle'];
                                   	$gatwaymailid=$objGeneral->GetCompleteDetailsofLogisticPortalbyid($order['fkShippingIDs']);
                                                                //pre($gatwaymailid);
                                                            	$portalmail=$gatwaymailid[0]['logisticEmail'];
                                                            	$gatwaynamearray=$objGeneral->getshippingcompanyname($fkShippingIDs);
                                                            	//$gatwayname= $gatwaynamearray[0]['ShippingTitle'];
                                                            	$gatwayname= $gatwaymailid[0]['logisticTitle'];
                                    	//echo $portalmail;
                                        $varCounter++;
                                        $arrStatus = array('Pending' => 'Red', 'Completed' => 'green', 'Posted' => '#ffb11b', 'Partial Completed' => '#ffb11b');
                                        ?>
                                        <tr class="<?php echo $varCounter % 2 == 0 ? 'even' : 'odd'; ?>">
                                            <td><?php echo $order['SubOrderID'] ?></td>
                                            
                                            <td><?php echo $objCore->localDateTime(date($order['OrderDateAdded']), DATE_FORMAT_SITE_FRONT); ?></td>
                                            <td><?php echo $order['ItemName'] ?></td>
                                            <td><?php echo $objCore->getPrice($order['total']); ?></td>
                                            <td><?php echo $order['CustomerName']; ?></td>
        <?php $isPosted = ($order['Status'] == 'Posted') ? 1 : 0; ?>
                                            <td><span id="s<?php echo $order['SubOrderID'] ?>" class="green"></span>
                                                <!--<span style="width:120px; color: <?php echo $arrStatus[$order['Status']]; ?>" class="status"><?php echo $order['Status']; ?></span>-->
                                                <select id="<?php echo $order['SubOrderID'] ?>" class="drop_down1 order_status" pid="<?php echo $isPosted; ?>" portalmail="<?php echo trim($portalmail); ?>" gatwayname="<?php echo trim($gatwayname); ?>" currentstatus="<?php echo trim($order['Status']); ?>">
                                                   <?php 
                                                   if ($order['Status'] == 'Pending')
                                                   {
                                                   ?>
                                                   <option value="Pending" <?php echo $order['Status'] == 'Pending' ? 'selected' : '' ?>><?php echo "Pending"; ?></option>
                                                   <option value="Processing" <?php echo $order['Status'] == 'Processing' ? 'selected' : '' ?>><?php echo "Processing"; ?></option>
                                                    <option value="Processed" <?php echo $order['Status'] == 'Processed' ? 'selected' : '' ?>><?php echo "Processed"; ?></option>
                                                    <option value="Shipped" <?php echo $order['Status'] == 'Shipped' ? 'selected' : '' ?>><?php echo "Shipped"; ?></option>
                                                   <option value="Delivered" <?php echo $order['Status'] == 'Delivered' ? 'selected' : '' ?>><?php echo "Delivered"; ?></option>
                                                   <?php }
                                                   ?>
                                                   
                                                   <?php 
                                                    if ($order['Status'] == 'Processing')
                                                   {
                                                   ?>
                                                     <option value="Processing" <?php echo $order['Status'] == 'Processing' ? 'selected' : '' ?>><?php echo "Processing"; ?></option>
                                                    <option value="Processed" <?php echo $order['Status'] == 'Processed' ? 'selected' : '' ?>><?php echo "Processed"; ?></option>
                                                    <option value="Shipped" <?php echo $order['Status'] == 'Shipped' ? 'selected' : '' ?>><?php echo "Shipped"; ?></option>
                                                   <option value="Delivered" <?php echo $order['Status'] == 'Delivered' ? 'selected' : '' ?>><?php echo "Delivered"; ?></option>
                                                   <?php }
                                                   ?>
                                                   
                                                    <?php 
                                                    if ($order['Status'] == 'Processed')
                                                   {
                                                   ?>
                                                     <option value="Processed" <?php echo $order['Status'] == 'Processed' ? 'selected' : '' ?>><?php echo "Processed"; ?></option>
                                                    <option value="Shipped" <?php echo $order['Status'] == 'Shipped' ? 'selected' : '' ?>><?php echo "Shipped"; ?></option>
                                                   <option value="Delivered" <?php echo $order['Status'] == 'Delivered' ? 'selected' : '' ?>><?php echo "Delivered"; ?></option>
                                                   <?php }
                                                   ?>
                                                   
                                                    <?php 
                                                   if ($order['Status'] == 'Shipped')
                                                   {
                                                   ?>
                                                    <option value="Shipped" <?php echo $order['Status'] == 'Shipped' ? 'selected' : '' ?>><?php echo "Shipped"; ?></option>
                                                   <option value="Delivered" <?php echo $order['Status'] == 'Delivered' ? 'selected' : '' ?>><?php echo "Delivered"; ?></option>
                                                   <?php }
                                                   ?>
                                                    <?php 
                                                   if ($order['Status'] == 'Delivered')
                                                   {
                                                   ?>
                                                 <option value="Delivered" <?php echo $order['Status'] == 'Delivered' ? 'selected' : '' ?>><?php echo "Delivered"; ?></option>
                                                  
                                                   <?php }
                                                   ?>
                                                    
                                                   <?php if ($order['Status'] == 'Completed')
                                                    { ?>
                                                        <option value="Completed" <?php echo $order['Status'] == 'Completed' ? 'selected' : '' ?>><?php echo COM; ?></option>
                                                    <?php }
                                                  
                                                     if ($order['Status'] == 'Pending')
                                                    { ?>
                                                        <option value="Canceled" <?php echo $order['Status'] == 'Canceled' ? 'selected' : '' ?>><?php echo CANCELED; ?></option>
                                                    <?php }
                                                    else if ($order['Status'] == 'Canceled')
                                                    { ?>
                                                        <option value="Canceled" <?php echo $order['Status'] == 'Canceled' ? 'selected' : '' ?>><?php echo CANCELED; ?></option>
                                                <?php }
                                                ?>
                                                </select></td>
                                            <td><a title="view details" href="<?php echo $objCore->getUrl('order_details.php', array('soid' => $order['SubOrderID'], 'place' => 'view')); ?>" class="viewbig active"><i class="fa fa-eye"></i></a>
                                                <?php
                                                if ($order['DisputedStatus'] == 'Disputed')
                                                {
                                                    echo '<span class="alert active" title="Disputed" alt="Disputed"> </span>';
                                                }
                                                if ($order['DisputedStatus'] == 'Resolved')
                                                {
                                                    echo '<span class="alert_green active" title="Disputed order resolved" alt="Disputed order resolved"> </span>';
                                                }
                                                ?></td>
                                        </tr>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                    <tr class="odd">
                                        <td colspan="7"><?php
                                            if ($_POST['search'])
                                            {
                                                echo FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG2;
                                            }
                                            else
                                            {
                                                echo FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG1;
                                            }
                                            ?></td>
                                    </tr>

<?php } ?>                      
							</table> 
							</div>

                                                    <?php if (count($objPage->arrOrders) > 0)
                                                    { ?>
                                <table width="100%">
                                    <tr><td colspan="10">&nbsp;</td></tr>
                                    <tr>
                                        <td colspan="10">
                                            <table width="100%" border="0" align="center">
                                                <tr>
                                                    <td style="font-weight:bolder; text-align:right;" colspan="10" align="right">
    <?php
    if ($objPage->varNumberPages > 1)
    {
    	//echo $_GET['page'].' '.$objPage->varNumberPages;
        $objPage->displayFrontPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
    }
    ?>
                                                    </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr></table>
<?php } ?>
                            <!-- <div class="product_link">
                                <a href="#" class="add_link">Add Product</a>
                                <a  href="#" class="multiple_link">Add Multiple Products</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>
