<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_ORDER_CTRL;
//$snipat = $objPage->snipatCareer;
$arrDisputedComments = $objCore->getDisputedCommentArray();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <title><?php echo ORDER_DETAILS_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script  type="text/javascript" src="<?php echo JS_PATH ?>customer_feedback.js"></script>
        <link rel="stylesheet" type="text/css" href="common/css/layout1.css"/>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.drop_down1').sSelect();
                $('#frmDate1').datepick({dateFormat: 'dd-mm-yyyy', minDate:new Date(),showTrigger: '<img src="common/images/cal_icon.png" style="position: relative;left: -28px;top: 10px;" alt=""/>'});
                $('#frmDate2').datepick({dateFormat: 'dd-mm-yyyy', minDate:new Date(), showTrigger: '<img src="common/images/cal_icon.png" style="position: relative;left: -28px;top: 10px;" alt=""/>',onSelect:calDateCompare});
                $("#DisputedFeed").validationEngine();
            });

            function shipmentPopup(str){
                $("."+str).colorbox({inline:true,width:"700px"});

                $('.cancel').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            }

            function sendDisputedPopup(str){
                $("."+str).colorbox({
                    inline:true,
                    width:"660px",
                    height:"760px"
                });

                $('#clDis').click(function(){parent.jQuery.fn.colorbox.close();});
            }
            function calDateCompare(SelectedDates){

                var d = new Date(SelectedDates);
                var d_formatted = d.getDate() + '-' + d.getMonth() +'-' + d.getFullYear();
                var sdate = d_formatted.split("-");

                var StartDate = $('#frmDate1').val();
                var CurrDate  = StartDate.split("-");
                /*********************** From Date *****************/
                var CY = parseInt(CurrDate[2]);  //Year
                var CM = parseInt(CurrDate[1]);  //Month
                var CD = parseInt(CurrDate[0]);  //Date
                /******************* To Date *********************/

                var sY=parseInt(sdate[2]);  //Year
                var sM=parseInt(sdate[1])+1;  //Month
                var sD=parseInt(sdate[0]);  //Date

                var ctr=0;

                if(sY<CY){
                    ctr=1;
                }else if(sY==CY && sM<CM){
                    ctr=1;
                }else if(sY==CY && sM==CM && sD<CD){
                    ctr=1;
                }
                if(ctr==1){
                    $('#frmDate2').val(StartDate);
                    alert('End Date should not be less than');
                }
            }
            function testavi(){
                
                jscallTracking('trackingmail')
                }
           
            $(document).on('click', '#senddata', function (e) {
               	e.preventDefault();
                  var trackingurlid = $("#trackingurl").val();
                  var sitename =  $("#site_from").val();

                  $.ajax({
                	    type : 'POST',
                	    url : "admin/ajax.php",
                	    data : $('#trackingemailid').serialize()+ '&action=' + 'updateShipment',
                	})
                	.done(function(e) {
						  console.log(e);
						  $('.listed_Warning').html('<span class="green"> Update Shipment  Sucessfully.</span>');
						  $('#cboxClose').click();
						});
                      
//                   $.post("admin/ajax.php",
//                           {
//                 	       type : 'POST',
//                       		action:'updateShipment',
//                       		data : $('#trackingemailid').serialize() 
                      		
//                       		},
//                           function(data)
//                           {
// //                               alert(data);
//                    //$('#listed_Warning').html('<span class="green"> Update Shipment  Sucessfully.</span>');
//                          //  setTimeout(function b(){$('#modal-2').hide();location.reload();}, 1500);
//  // $('#cboxClose').click();

//                           }
//                      );
              

          });
            $(document).on('click', '#sendtrakingno', function () {
                  var Trackingid = $("#trackingno").val();
                  var DateStart = $(".frmDateStart").val();
                  var Dateend = $(".frmDate").val();
                  var shippingtitle = $("#shippingtitle1").val();
                   var customer_name = $("#customer_name").val();
                    var customer_email = $("#customer_email").val();
                    var ShippingFirstName = $("#ShippingFirstName").val();
                    var ShippingLastName = $("#ShippingLastName").val();
                    var ShippingAddressLine1 = $("#ShippingAddressLine1").val();
                    var ShippingAddressLine2 = $("#ShippingAddressLine2").val();
                    var ShippingCountry = $("#ShippingCountry").val();
                    var ShippingPostalCode = $("#ShippingPostalCode").val();
                    var ShippingPhone = $("#ShippingPhone").val();
                    var trackingurlid = $("#trackingurl").val();
					var pkOrderID=$("#pkOrderID").val();
                     var startDate = DateStart;
                    var endDate = Dateend;
                   // alert(startDate+endDate);
                    if((startDate.length == 0)  || (endDate.length == 0))
                    {
                    	 alert("Please select date");
                    	 
                     }

                    else
                    {
                    	 if (startDate > endDate){
 		                    // Do something
 		                        alert("End date should be greater than Start date");
 		                    }
 		                    else
 			                    {
 			                    	 var sitename =  $("#site_from").val();
 			                         $.post("admin/ajax.php",{action:'Sendtrackingnumber',name:customer_name,emailid:customer_email,id:Trackingid,startdate:DateStart,enddate:Dateend,shippingcompany:shippingtitle,trackingurl:trackingurlid,from:sitename,shfirst:ShippingFirstName,shlast:ShippingLastName,shadd1:ShippingAddressLine1,shadd2:ShippingAddressLine2,scountry:ShippingCountry,spcode:ShippingPostalCode,sphone:ShippingPhone,pkOrderID:pkOrderID},
 			                                 function(data)
 			                                 {
 			                                     //alert(data);
 			                                      $('.listed_Warning').html('<span class="green">Trackingid Sent Successfully.</span>');
 			                                      
 			                                      $('#cboxClose').click();
 			                                      $("input[type=text], textarea").val("");
 			                                     // setTimeout(function b(){$('#modal-2').hide();location.reload();}, 1500);
 			
 			                                 }
 			                             );
 			
 			                        }
                        
                    }
					
		                   
                    
                    //alert();
                 

 
            });

            
        </script>
        <script>
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#createNewsletter").validationEngine();
                $('.datePicker').datepick({dateFormat: 'dd-mm-yyyy',minDate:0,showTrigger:'<small><a href="javascript:void(0);"><img src="common/images/cal_icon.png" alt=""/></a></small>'});
            });

            function IsEmail(email) {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(!regex.test(email)) {
                   return false;
                }else{
                   return true;
                }
              }
        </script>
        </head>
        <body>
<style>
.boxes5 span{width:164px !important; float:left;} .datepick-popup{z-index: 9999999999999;}.boxes5 ul li small{width:130px; font-size:13px;}
		#orderdetails_box .account_information, .billing_information, .shipping_information{width:363px !important;}
		.boxes ul li span strong{float:none; margin-left:4px;}
		.back_ankar_sec{width:100%}
		
.boxes ul li a {
    color: #423d3d;
    float: left;
    line-height: 16px;
    margin-top: 4px;
    padding-left: 5px;
    width: 133px; word-wrap:break-word; font-weight:bold;}
.reply_message{clear:both; font-size:14px;}
.reply_message .left_m{width:150px !important;}
.reply_message .right_m{width:350px !important;}
.reply_message .right_m .radio_btn{margin-right:20px; float:left;}
.reply_message .left_m label {font-weight: 400; line-height:32px;}
.post_disputed{height: 660px; overflow-y:auto; overflow-x:hidden;}
#cboxLoadedContent{ height:auto !important;}
        </style>
<em>
        <div id="navBar">
  <?php include_once INC_PATH . 'top-header.inc.php'; ?>
</div>
        </em>
<div class="header" style="border-bottom:none">
          <div class="layout"></div>
          <?php include_once INC_PATH . 'header.inc.php'; ?>
        </div>
<div id="ouderContainer" class="ouderContainer_1">
          <div class="abc_div">
    <div class="btn_top">
              <?php include_once 'common/inc/wholesaler.header.inc.php'; ?>
            </div>
  </div>
          <div class="layout">
    <div>
              <div class="">
        <?php if ($objCore->displaySessMsg()) {
                        ?>
        <div class="successMessage">
                  <?php
                            echo $objCore->displaySessMsg();
                            $objCore->setSuccessMsg('');
                            $objCore->setErrorMsg('');
                            ?>
                </div>
        <?php } ?>
      </div>
              <div class="add_pakage_outer">
              
        <div class="top_container" style="padding:0px; width:100%">
                  <div class="top_header border_bottom">
            <h1><?php echo ORDERS; ?> <?php echo DETAILS; ?></h1>
             <p class="listed_Warning"></p>
             
               <!--<a href="<?php //echo SITE_ROOT_URL; ?>customer_orders.php" class="back_button">Back</a>-->  
               <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="back_button">Back</a>  

<!--             <a href="javascript: history.go(-1)" class="back_button">Back</a>  -->
             <!--<a href="javascript:void(0);" onclick="window.history.back();" class="back_button">Back</a>--> 
            <!--<input action="action" type="button" value="Back" onclick="window.history.go(-1); return false;" />-->
            </div>
                </div>
        <div class="body_inner_bg">
                  <?php $data = $objPage->arrOrderDetail; 
                      // pre($data);
                        ?>
                  <div class="add_edit_pakage order_detail">
            <div class="back_ankar_sec"> 
                      <!--                             <table class="track-row"> --> 
                      <!--                               <tr> --> 
                      <!--                                  <td> Tracking Id</td> &nbsp;&nbsp; --> 
                      <!--                                  <td>  --> 
                      
                      <!--                                  <input type="text" name="frmTrackingNo" id="trackingno334545" value="" class="input-medium" /> --> 
                      
                      <!--                                  </td>&nbsp;&nbsp;   --> 
                      <!--                                  <td><input type="button" class="btn btn-blue" name="Submit" id="sendtrakingno" value="Send Mail"/> </td> --> 
                      <!--                               </tr> --> 
                      <!--                             </table> -->
                      <?php
                                if ($data['product_detail'][0]['DisputedStatus'] <> 'Disputed' && $data['product_detail'][0]['Status'] <> 'Canceled' && (count($data['product_detail']) > 0)) {
                                    if ($data['IsInvoiceSent'] == 0) {
                                        ?>
                      <a href="<?php echo $objCore->getUrl('customer_orders.php', array('soid' => $_REQUEST['soid'], 'place' => 'sendInvoice')); ?>" class="send_invoice"><span><?php echo SEND_INVOICE_TELA; ?></span></a>
                      <?php } else { ?>
                      <a href="<?php echo INVOICE_URL . 'wholesaler/' . $objPage->arrInvoiceId[0]['InvoiceFileName'] ?>" target="_blank" class="send_invoice" title="<?php echo VIEW_INV; ?>"><span><?php echo VIEW_INV; ?></span></a>
                      <?php
                                    }
                                }
                                ?>
                      <?php
                                if (count($data['arrDisputedCommentsHistory']) > 0) {
                                    ?>
                      <a href="#DisputedHistory" class="send_invoice DisputedHistory" onclick="sendDisputedPopup('DisputedHistory');"><span><?php echo 'Disputed history'; ?></span></a>
                      <div style="display: none;">
                <div id="DisputedHistory" class="reply_message">
                          <div class="post_disputed">
                    <?php if ($data['product_detail'][0]['DisputedStatus'] == 'Resolved') { ?>
                    <div class="q_text green"><?php echo DISPUTE_RESOLVED; ?></div>
                    <?php } ?>
                    <?php
                                                foreach ($data['arrDisputedCommentsHistory'] as $kkk => $vvv) {
                                                    ?>
                    <div class="q_ans">
                              <hr/>
                            </div>
                    <div class="q_text">By <?php echo $vvv[$vvv['CommentedBy']] . '(' . $vvv['CommentedBy'] . ') <small class="green">' . $objCore->localDateTime($vvv['CommentDateAdded'], DATE_TIME_FORMAT_SITE_FRONT) . '</small>'; ?><br/>
                              <br/>
                            </div>
                    <?php
                                                    if ($vvv['CommentOn'] == 'Disputed') {
                                                        $Qdata = unserialize($vvv['CommentDesc']);
                                                        ?>
                    <div class="q_text"><?php echo $arrDisputedComments['Q1']; ?></div>
                    <div class="q_ans"> <?php echo $arrDisputedComments[$Qdata['Q1']]; ?> </div>
                    <?php if ($Qdata['Q1'] == 'A11') { ?>
                    <div class="q_text"><?php echo $arrDisputedComments['Q11']; ?></div>
                    <div class="q_ans"> <?php echo $Qdata['Q11']; ?> </div>
                    <?php
                                                            $additionalCommentsQ = $arrDisputedComments['Q12'];
                                                        } else {
                                                            ?>
                    <div class="q_text"><?php echo $arrDisputedComments['Q21']; ?></div>
                    <div class="q_ans">
                              <?php
                                                                $arrQ21 = explode(',', $Qdata['Q21']);
                                                                $Q21 = '';
                                                                foreach ($arrQ21 as $v10) {
                                                                    if (key_exists($v10, $arrDisputedComments)) {
                                                                        $Q21 .= $arrDisputedComments[$v10] . ',';
                                                                    } else {
                                                                        $Q21 .= $v10 . ',';
                                                                    }
                                                                }
                                                                echo trim($Q21, ',');
                                                                ?>
                            </div>
                    <div class="q_text"><?php echo $arrDisputedComments['Q22']; ?></div>
                    <div class="q_ans"><?php echo $arrDisputedComments[$Qdata['Q22']]; ?></div>
                    <div class="q_text"><?php echo $arrDisputedComments['Q23']; ?></div>
                    <div class="q_ans"><?php echo $arrDisputedComments[$Qdata['Q23']]; ?></div>
                    <?php
                                                            $additionalCommentsQ = $arrDisputedComments['Q24'];
                                                        }
                                                    } else {
                                                        $additionalCommentsQ = 'Feedback';
                                                    }
                                                    ?>
                    <div class="q_text"><?php echo $additionalCommentsQ; ?></div>
                    <div class="q_ans"><?php echo $vvv['AdditionalComments']; ?></div>
                    <?php } ?>
                    <form method="post" id="DisputedFeed">
                              <div class="q_text"><?php echo 'Post Your Feedback'; ?></div>
                              <div class="q_ans">
                        <div class="input_star">
                                  <textarea name="frmFeedback" rows="3" cols="35" class="validate[required]" style="width:390px! important;resize: none;"></textarea>
                                  <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                      </div>
                              <div style="height: 30px; clear:both;">
                        <input type="submit" name="submit" value="Send" class="submit button submit3" style="margin-right: 5px; padding:11px 30px !important; float:left" />
                        <input type="button" name="cancel" value="Cancel" id="clDis" class="submit button cancel" style="padding:11px 30px !important;" />
                      </div>
                              <input type="hidden" name="type" value="disputeFeedback" />
                              <input type="hidden" name="oid" value="<?php echo $data['product_detail'][0]['fkOrderID']; ?>" />
                              <input type="hidden" name="soid" value="<?php echo $data['product_detail'][0]['SubOrderID'] ?>" />
                              <div class="q_ans">&nbsp;</div>
                            </form>
                  </div>
                        </div>
              </div>
                      <?php } ?>
                    </div>
            <?php if (count($data['product_detail']) > 0) { 
            	//pre($data);
                                 //pre($data['customer_detail']);
                                
                                ?>
            <div id="orderdetails_box" class="boxes boxes5">
                      <div class="account_information">
                <div class="heading">
                          <h3><?php echo AC_INFO; ?></h3>
                        </div>
                <ul>
                          <li><span><?php echo CUS_NAME; ?><strong>:</strong></span> <small> <?php echo $data['customer_detail']['CustomerFirstName'].' '.$data['customer_detail']['CustomerLastName'] ?></small></li>
                          <li><span><?php echo CUS_EMAIL; ?><strong>:</strong></span> <a class="link3" href="mailto:<?php echo $data['customer_detail']['CustomerEmail'] ?>"> <?php echo $data['customer_detail']['CustomerEmail'] ?></a></li>
                          <li><span><?php echo PHONE; ?><strong>:</strong></span> <small> <?php echo $data['customer_detail']['CustomerPhone'] ?></small></li>
                        </ul>
              </div>
                      <div class="billing_information">
                <div class="heading">
                          <h3><?php echo BILL_INFO; ?></h3>
                        </div>
                <ul>
                          <?php if($data['customer_detail']['BillingFirstName']<>''){ ?>
                          <li><span><?php echo RECIPIENT_FIRST_NAME; ?><strong>:</strong></span> <small> <?php echo $data['customer_detail']['BillingFirstName'] ?></small></li>
                          <?php } if($data['customer_detail']['BillingLastName']<>''){ ?>
                          <li><span><?php echo REC_LAST_NAME; ?><strong>:</strong></span> <small> <?php echo $data['customer_detail']['BillingLastName'] ?></small></li>
                          <?php } if($data['customer_detail']['BillingOrganizationName']<>''){ ?>
                          <li><span><?php echo ORG_NAME; ?><strong>:</strong></span> <small> <?php echo $data['customer_detail']['BillingOrganizationName'] ?></small></li>
                          <?php } if($data['customer_detail']['BillingAddressLine1']<>''){ ?>
                          <li><span><?php echo ADD_1_ADDRESS; ?><strong>:</strong> </span> <small> <?php echo $data['customer_detail']['BillingAddressLine1'] ?></small></li>
                          <?php } if($data['customer_detail']['BillingAddressLine2']<>''){ ?>
                          <li><span><?php echo ADD_2_ADDRESS; ?> <strong>:</strong></span> <small> <?php echo $data['customer_detail']['BillingAddressLine2'] ?></small></li>
                          <?php } if($data['customer_detail']['BillingCountryName']<>''){ ?>
                          <li><span><?php echo COUNTRY; ?><strong>:</strong></span> <small> <?php echo $data['customer_detail']['BillingCountryName'] ?></small></li>
                          <?php } if($data['customer_detail']['BillingPostalCode']<>''){ ?>
                          <li><span><?php echo POSTAL_CODE_ZIP; ?><strong>:</strong> </span> <small> <?php echo $data['customer_detail']['BillingPostalCode'] ?></small></li>
                          <?php } ?>
                        </ul>
              </div>
                      <div class="shipping_information">
                <div class="heading">
                          <h3><?php echo SHIPP_INFO; ?></h3>
                        </div>
                <ul>
                          <?php if($data['customer_detail']['ShippingFirstName']<>''){ ?>
                          <li><span><?php echo RECIPIENT_FIRST_NAME; ?> <strong>:</strong></span> <small> <?php echo $data['customer_detail']['ShippingFirstName'] ?></small></li>
                          <?php } if($data['customer_detail']['ShippingLastName']<>''){ ?>
                          <li><span><?php echo REC_LAST_NAME; ?> <strong>:</strong></span><small> <?php echo $data['customer_detail']['ShippingLastName'] ?></small></li>
                          <?php } if($data['customer_detail']['ShippingOrganizationName']<>''){ ?>
                          <li><span><?php echo ORG_NAME; ?> <strong>:</strong></span> <small> <?php echo $data['customer_detail']['ShippingOrganizationName'] ?></small></li>
                          <?php } if($data['customer_detail']['ShippingAddressLine1']<>''){ ?>
                          <li><span><?php echo ADD_1_ADDRESS; ?> <strong>:</strong></span> <small> <?php echo $data['customer_detail']['ShippingAddressLine1'] ?></small></li>
                          <?php } if($data['customer_detail']['ShippingAddressLine2']<>''){ ?>
                          <li><span><?php echo ADD_2_ADDRESS; ?><strong>:</strong></span> <small> <?php echo $data['customer_detail']['ShippingAddressLine2'] ?></small></li>
                          <?php } if($data['customer_detail']['ShipingCountryName']<>''){ ?>
                          <li><span><?php echo COUNTRY; ?><strong>:</strong></span> <small> <?php echo $data['customer_detail']['ShipingCountryName'] ?></small></li>
                          <?php } if($data['customer_detail']['ShippingPostalCode']<>''){ ?>
                          <li><span><?php echo POSTAL_CODE_ZIP; ?><strong>:</strong></span> <small> <?php echo $data['customer_detail']['ShippingPostalCode'] ?></small></li>
                          <?php }?>
                        </ul>
              </div>
                    </div>
            <div class="boxes2"></div>
            <?php
                                if ($data['product_detail']) {
                                    ?>
            <div class="responsiveTbl">
                      <table width="100%" style="width:1132px;" border="0" cellpadding="0" cellspacing="0">
                <tr>
                          <th align="center"><?php echo SUB_ORDER_ID; ?></th>
                          <th align="center"><?php echo ITEM; ?> <?php echo NAME; ?></th>
                          <th align="center"><?php echo ITEM_IMAGE; ?></th>
                          <th align="center"><?php echo PRICE; ?></th>
                          <th align="center"><?php echo QTY; ?>.</th>
                          <th align="center"><?php echo DIS_PRICE; ?></th>
                          <th align="center">Sub Total</th>
                          <th align="center" class="last"><?php echo 'Shipment'; ?></th>
<!--                          <th align="center">Send mail</th>-->
                        </tr>
                <?php
                                        $varOrderTotal = 0;
                                        $varShipingTotal = 0;
                                        $varSubTotal = 0;

                                        $varCounter = 1;
                                        $varRows = count($data['product_detail']);

                                        foreach ($data['product_detail'] as $products) {
                                           
                                            $varSubTotal =(trim($products['ItemSubTotal'])+trim($products['AttributePrice']))-$products['DiscountPrice'];
                                            $varSubTotal2[] =$varSubTotal;
                                            $varOrderTotal =(trim($products['ItemSubTotal'])+trim($products['AttributePrice']) + $products['ShippingPrice'])- $products['DiscountPrice'];
                                           $varOrderTotal2[]=$varOrderTotal;
                                            $varShipingTotal+=$products['ShippingPrice'];
                                            $varACTotal = $products['ItemSubTotal'] + $products['AttributePrice'] - $products['DiscountPrice'];
                                            
                                            $varClass = ($varRows == $varCounter) ? 'bottom' : '';


                                            if ($products['ItemType'] == 'product') {
                                                $path = 'products/' . $arrProductImageResizes['default'];
                                            } else if ($products['ItemType'] == 'package') {
                                                $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                                            } else {
                                                $path = 'gift_card';
                                            }

                                            $varSrc = $objCore->getImageUrl($products['ItemImage'], $path);
                                            ?>
                <tr <?php echo $varCounter % 2 == 0 ? 'class="even"' : 'class="odd"'; ?>>
                          <td class="<?php echo $varClass; ?> border_left"><?php echo ucwords($products['SubOrderID']) ?></td>
                          <td class="<?php echo $varClass; ?>" align="center"><?php echo '<b>' . $products['ItemName'] . '</b><br />' . $products['OptionDet']; ?></td>
                          <td class="<?php echo $varClass; ?>" align="center"><img src="<?php echo $varSrc; ?>" alt="<?php echo $products['ItemName']; ?>" style="float:none;" /></td>
                          <td class="<?php echo $varClass; ?>" align="center"><?php echo $objCore->getPrice($products['ItemPrice'] + ($products['AttributePrice'] / $products['Quantity'])); ?></td>
                          <td class="<?php echo $varClass; ?>" align="center"><?php echo $products['Quantity']; ?></td>
                          <td class="<?php echo $varClass; ?>" align="center"><?php echo $objCore->getPrice($products['DiscountPrice']) ?></td>
                          <td class="<?php echo $varClass; ?>" align="center"><?php echo $objCore->getPrice($varSubTotal) ?></td>
                          <td class="<?php echo $varClass; ?> last" align="center"><?php
                                                    $varPopClass = $products['pkOrderItemID'];
                                                    $varPopID = 'reply_message' . $products['pkOrderItemID'];
                                                    $varValidation .= '$("#shippment' . $products['pkOrderItemID'] . '").validationEngine();';
                                                    ?>
                    <a href="javascript:void()" class="button <?php echo $varPopClass; ?>" style="margin-left: 10px;"><span><?php echo ($products['Status'] <> '') ? $products['Status'] : 'Pending'; ?></span></a> 
                    
                   
                    </td>
<!--                          <td id=""><a class="trackingmail" onclick="testavi();" href="#trackingmail" style="color: #56A0F2;text-decoration: none;margin-left: 0px;">Send Tracking</a></td>-->
                        </tr>
                <?php
                                            $varCounter++;
                                        }
                                        
                                       
                                        ?>
              </table>
                    </div>
            <?php }
                                //print_r($varOrderTotal2);
                                ?>
            <div class="last_box">
                      <div class="comment_box">
                <label style="width:180px;"><?php echo COMM_HIS; ?> </label>
                <form action="#">
                          <div style="background-color: #ffffff; border:1px solid #d9d9d9;  margin-top:30px; padding: 5px; font: 12px/14px 'OpenSansRegular',arial;min-height: 50px;">
                    <?php
                                                foreach ($data['product_comments'] as $key => $val) {
                                                    echo $val['Comment'] . '<br /><p style="font-weight: bold;text-align: right;">' . $val[$val['CommentedBy'] . 'Name'] . ' (' . ucwords($val['CommentedBy']) . ')</p>';
                                                }
                                                ?>
                    &nbsp; </div>
                        </form>
              </div>
                      <div class="total_amount total_amountbox">
                <ul>
                          <li><small><?php echo SUBTOTAL; ?></small> <span><?php echo $objCore->getPrice(array_sum($varSubTotal2)); ?></span></li>
                          <li><small><?php echo SHIPP_HAND; ?></small> <span><?php echo $objCore->getPrice($varShipingTotal); ?></span></li>
                          <li class="grand"><strong><?php echo GRAND_TOTAL; ?></strong><span>
                            <?php
                                            $varGRandTotal=array_sum($varSubTotal2)+$varShipingTotal;
                                            echo $objCore->getPrice($varGRandTotal); ?>
                            </span></li>
                          <!-- <li class="pay_button"><a href="#">Pay Now</a></li> -->
                        </ul>
              </div>
                    </div>
            <?php } else {
                                            echo ADMIN_NO_RECORD_FOUND;
                                        } ?>
          </div>
                </div>
      </div>
            </div>
  </div>
        </div>
<div style="display: none;">
         
          <div class="quick_color popup-tracking-form" id="trackingmail">
          <form name="trackingmail" id="trackingemailid" method="post">
   
    <table cellspacing="0" cellpadding="0" border="0" width="100%" id="colorBox_table">
     <h2 style="text-align: center; margin-bottom: 10px; font-weight: 500;">Send Tracking Mail</h2>
     <?php 
     if($data['product_detail'][0]['Status']=='Delivered')
     {
     ?>
     <P style="font-weight:500;"> Following Status is <b>Delivered</b> </P>
       <?php 
     }?>       <tr>
        <td>Shipping Gateway</td>
        <td><?php $shippingtitle=$objGeneral->getshippingcompanyname($data['product_detail'][0]['fkShippingIDs']);
                                      echo $shippingtitle[0]['ShippingTitle']; ?>
                  <input type="hidden" name="shippingtitlename" id="shippingtitle1" value="<?php $shippingtitle=$objGeneral->getshippingcompanyname($data['product_detail'][0]['fkShippingIDs']); echo $shippingtitle[0]['ShippingTitle'];?>" class="input-medium" /></td>
      </tr>
              <tr>
        <td>Tracking Id</td>
        <td><input type="text" name="frmTrackingNo" id="trackingno"  class="input-medium empty" />
                  <input type="hidden" name="customer_name" id="customer_name"value="<?php echo $data['customer_detail']['CustomerFirstName']; ?> <?php echo $data['customer_detail']['CustomerLastName']; ?>"/>
                  <input type="hidden" name="customer_email" id="customer_email" value="<?php echo $data['customer_detail']['CustomerEmail']; ?>"/>
                  <input type="hidden" name="customer_email" id="site_from" value="<?php echo SITE_NAME . '<' . SITE_EMAIL_ADDRESS . '>'; ?>"/></td>
      </tr>
      
       <tr>
        <td> Url For Tracking Id</td>
        <td>
     
        <textarea rows="" cols="" name="frmTrackingemail" id="trackingurl" class="empty"></textarea>
         <input type="hidden" name="ShippingFirstName" id="ShippingFirstName" value="<?php echo $data['customer_detail']['ShippingFirstName']; ?>"/>
          <input type="hidden" name="ShippingLastName" id="ShippingLastName" value="<?php echo $data['customer_detail']['ShippingLastName']; ?>"/>
           <input type="hidden" name="ShippingAddressLine1" id="ShippingAddressLine1" value="<?php echo $data['customer_detail']['ShippingAddressLine1']; ?>"/>
            <input type="hidden" name="ShippingAddressLine2" id="ShippingAddressLine2" value="<?php echo $data['customer_detail']['ShippingAddressLine2'];
             ?>"/>
            <input type="hidden" name="ShippingCountry" id="ShippingCountry" value="<?php
            $countryname=$objGeneral->getCountrynamebyid($data['customer_detail']['ShippingCountry']);
            echo $countryname[0]['name'];
            ?>"/>
           <input type="hidden" name="ShippingPostalCode" id="ShippingPostalCode" value="<?php echo $data['customer_detail']['ShippingPostalCode']; ?>"/>
            <input type="hidden" name="ShippingPhone" id="ShippingPhone" value="<?php echo $data['customer_detail']['ShippingPhone']; ?>"/>
                         
                   </tr>
              <tr>
        <td>Date</td>
        <td><div class="dp-col"><span class="dd-mm-label">Start</span>
            <input type="text" name="frmDateFrom" value="<?php echo ($item['Shipments']['ShipStartDate']) ? $objCore->localDateTime($item['Shipments']['ShipStartDate'], DATE_FORMAT_SITE) : ''; ?>" readonly="true" class=" datePicker frmDateStart input-small empty" />
          </div>
                  <div class="dp-col end-dp-col"> <span class="dd-mm-label end-label"> End</span>
            <input type="text" name="frmDateTo" value="<?php echo ($item['Shipments']['ShippedDate']) ? $objCore->localDateTime($item['Shipments']['ShippedDate'], DATE_FORMAT_SITE) : ''; ?>" readonly="true" class=" datePicker frmDate input-small empty" />
          </div></td>
      </tr>
              <tr>
        <td>Status</td>
        <td><select name="frmShippingStatus" class="select2-me input-medium">
        <?php 
                                                   if ($data['product_detail'][0]['Status'] == 'Pending')
                                                   {
                                                   ?>
                                                   <option value="Pending" <?php echo $data['product_detail'][0]['Status'] == 'Pending' ? 'selected' : '' ?>><?php echo "Pending"; ?></option> 
                                                    <option value="Processing" <?php echo $data['product_detail'][0]['Status'] == 'Processing' ? 'selected' : '' ?>><?php echo "Processing"; ?></option> 
                                                     <option value="Processed" <?php echo $data['product_detail'][0]['Status'] == 'Processed' ? 'selected' : '' ?>><?php echo "Processed"; ?></option> 
                                                      <option value="Shipped" <?php echo $data['product_detail'][0]['Status'] == 'Shipped' ? 'selected' : '' ?>><?php echo "Shipped"; ?></option> 
                                                    <?php }
                                                   ?>
                                                   
                                                   <?php 
                                                   if ($data['product_detail'][0]['Status'] == 'Processing')
                                                   {
                                                   ?>
                                                  
                                                    <option value="Processing" <?php echo $data['product_detail'][0]['Status'] == 'Processing' ? 'selected' : '' ?>><?php echo "Processing"; ?></option> 
                                                     <option value="Processed" <?php echo $data['product_detail'][0]['Status'] == 'Processed' ? 'selected' : '' ?>><?php echo "Processed"; ?></option> 
                                                      <option value="Shipped" <?php echo $data['product_detail'][0]['Status'] == 'Shipped' ? 'selected' : '' ?>><?php echo "Shipped"; ?></option> 
                                                    <?php }
                                                   ?>
                                                   
                                                   <?php 
                                                   if ($data['product_detail'][0]['Status'] == 'Processed')
                                                   {
                                                   ?>
                                                  
                                                     <option value="Processed" <?php echo $data['product_detail'][0]['Status'] == 'Processed' ? 'selected' : '' ?>><?php echo "Processed"; ?></option> 
                                                      <option value="Shipped" <?php echo $data['product_detail'][0]['Status'] == 'Shipped' ? 'selected' : '' ?>><?php echo "Shipped"; ?></option> 
                                                    <?php }
                                                   ?>
                                                    <?php 
                                                   if ($data['product_detail'][0]['Status'] == 'Shipped')
                                                   {
                                                   ?>
                                                  <option value="Shipped" <?php echo $data['product_detail'][0]['Status'] == 'Shipped' ? 'selected' : '' ?>><?php echo "Shipped"; ?></option> 
                                                    <?php }
                                                   ?>
                                                                                                
          </select></td>
      </tr>
            </table>
    <div class="modal-footer track-modal-footer">
              <div class="modal-footer-inner">
              <?php 
              if($data['product_detail'][0]['Status']=='Shipped')
              	$btnstatus='enable';
              else 
              	$btnstatus='disabled';
              
              if($data['product_detail'][0]['Status']=='Delivered')
              	$submitstatus='disabled';
             
              ?>
        <input type="hidden" name="frmShipmentGatways" value="<?php echo $data['product_detail'][0]['fkShippingIDs']; ?>" />
        <input type="hidden" name="frmOrderItemID" value="<?php echo $data['product_detail'][0]['pkOrderItemID']; ?>" />
        <input type="hidden" name="frmOrderDateAdded" value="<?php echo $data['product_detail'][0]['Shipments']['OrderDate'] ?>" />
        <input type="hidden" name="frmShipmentID" value="<?php echo $data['product_detail'][0]['fkShippingIDs'] ?>" />
         <input type="hidden" name="frmTransactionNo" value="<?php echo $data['product_detail'][0]['Shipments']['TransactionNo'] ?>" />
         <input type="hidden" name="suborderid" value="<?php echo $data['product_detail'][0]['SubOrderID']; ?>" />
         <input type="hidden" name="gatewaymail" value="<?php echo $data['gatwaymail'] ?>" />
          <input type="hidden" name="pkOrderID" id="pkOrderID" value="<?php echo $data['customer_detail']['pkOrderID']; ?>"/>
		 <input type="hidden" name="ShippingTitle" value="<?php 
		 $shippingtitle=$objGeneral->getshippingcompanyname($data['product_detail'][0]['fkShippingIDs']);
		 echo $shippingtitle[0]['ShippingTitle'];
		 ?>" />
        <input type="hidden" name="frmShippment" value="Update" />
        
         <button type="button" <?php echo $btnstatus?> class="btn btn-blue" name="Submitmail" id="sendtrakingno">Send Mail</button>
        
        &nbsp;&nbsp;
        
        <input type="button" class="btn btn-blue" <?php echo $submitstatus;?> name="Submit" id="senddata" value="Submit"/>
        &nbsp;&nbsp; </div>
           
           </form>
            </div>
    <p class="Allpricedata"></p>
  </div>
        </div>
<script type="text/javascript">
        <?php echo $varValidation; ?>
        </script>
<?php include_once 'common/inc/footer.inc.php'; ?>
</body>
</html>