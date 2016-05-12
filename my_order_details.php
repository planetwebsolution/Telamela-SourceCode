<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_ORDERDETAIL_CTRL;
$arrDisputedComments = $objCore->getDisputedCommentArray();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Order Detail Page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>layout1.css"/>
        <script> $(document).ready(function(e) {
            $("select").msDropdown({roundedBorder: false});
        });</script>
        <script type="text/javascript">
        $(document).ready(function() {
            $('.drop_down1').sSelect();
            $("#frmDisputeForm").validationEngine();
        });
        var mfb = 0;
        function sendMyFeedback(productID, orderID, wholesalerID, ioid,logisticId) {
            
            if (mfb == 0) {
                mfb++;
                var Question1 = $("input:radio[name=Question1" + ioid + "]:checked").val();
                var Question2 = $("input:radio[name=Question2" + ioid + "]:checked").val();
                var Question3 = $("input:radio[name=Question3" + ioid + "]:checked").val();
                var comments = $('#comments' + ioid).val();
                // $('.reply_message').html('<div class="post_fdback"><p class="green">Sending</p></div>');

                $.post("", {
                    ajax_request: 'valid',
                    post_feedback: 'yes',
                    productID: productID,
                    orderID: orderID,
                    wholesalerID: wholesalerID,
                    logisticID: logisticId,
                    Question1: Question1,
                    Question2: Question2,
                    Question3: Question3,
                    comments: comments
                },
                function(data) {
                    $('.feedbacksuccessmessage').html('<span style="color:green;font-size:13px;margin-bottom:10px">Your feedback has been sent successfully.</span>');
                    setTimeout(function() {
                      parent.jQuery.fn.colorbox.close();
                      $('.' + ioid).remove();
                      $('.feedbacksuccessmessage').html('');
                      window.location.reload();
                    }, 5000);
                   
                });
            }
        }

        function sendFeedbackPopup(str) {
            $("." + str).colorbox({
                inline: true,
                width: "660px"
            });

            $('#compose_cancel' + str).click(function() {
                parent.jQuery.fn.colorbox.close();
            });
        }

        function sendDisputedPopup(str) {
            $("." + str).colorbox({
                inline: true,
                width: "660px",
                height: "auto"
            });

            $('#cl' + str).click(function() {
                parent.jQuery.fn.colorbox.close();
            });
        }

        function shippmentPopup(str) {
            $("." + str).colorbox({
                inline: true,
                width: "470px"
            });

            $('#compose_cancel' + str).click(function() {
                parent.jQuery.fn.colorbox.close();
            });
        }

        function disputProblem(str1, str,str2) {
            if (str1 == 'A11') {
                $("#cboxLoadedContent").height("550px");
                $('#Dis1' + str).css('display', 'block');
                $('#Dis2' + str).css('display', 'none');
                $('#frmDisputeForm').attr('onsubmit','return validateForm()');
                    
            } else {
                $("#cboxLoadedContent").height("750px");
                $('#Dis2' + str).css('display', 'block');
                $('#Dis1' + str).css('display', 'none');
                $('#frmDisputeForm').attr('onsubmit','return validateForm2()');
            }
        }
        function validateForm() {
            var resContId = $( "#resDispute option:selected" ).val();
           // alert(resContId);
            if (resContId !='') {
                $('.ErrorResCountry').css('display', 'none');
                //return false;
            }
            else {
                $('.ErrorResCountry').css('display', 'block');
                return false;
            }
                               
        }
        function validateForm2() {
            var res2Dispute = $( "#res2Dispute option:selected" ).val();//$('#res2Dispute').val();
            if (res2Dispute !='') {
                $('.ErrorResCountry2').css('display', 'none');
                //return false;
            }
            else {
                $('.ErrorResCountry2').css('display', 'block');
                return false;
            }
                
        }
        </script>	
        <style>.dd .ddTitle{ height:36px !important}
            .total_amount ul li small{ width:174px; }
            .post_disputed .dd .arrow{ background-position:8px 4px}
            .post_disputed .ddcommon .ddlabel{ font-size:11px;}

        </style>


    </head>
    <body>
        <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header"><div class="layout">

            </div>
        </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
                <div class="">

                    <?php
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
                    <?php } ?>
                </div>
                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <h1>My Orders Details</h1>

                    </div>            
                    <div class="body_inner_bg">         
                        <?php
                        $date1 = date_create($objPage->arrData['CustomerDeatails'][0]['OrderDateAdded']);
                        $date2 = date_create($objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
                        $diff = date_diff($date1, $date2);
                        $varDays = $diff->format("%r%a");
                        //echo $varDays;
                        ?>
                        <div class="add_edit_pakage order_details">
                            <div class="boxes1">

                                <h2>
                                    <a href="<?php echo $objCore->getUrl('my_orders.php'); ?>" class="back"><span>Back</span></a>
                                </h2>
                                <?php
                                if (count($objPage->arrData['CustomerDeatails']) > 0)
                                {
                                    ?>

                                    <div class="account_information">
                                        <div class="heading">
                                            <h3>Account Information</h3>
                                        </div>
                                        <ul>
                                            <li><span>Your Name <strong>   :</strong></span> <small> <?php echo $objPage->arrData['CustomerDeatails'][0]['CustomerFirstName'] . ' ' . $objPage->arrData['CustomerDeatails'][0]['BillingLastName']; ?></small></li>
                                            <li><span>Your Email <strong>   :</strong> </span><a class="linkCustomeHover" href="mailto:<?php echo $objPage->arrData['CustomerDeatails'][0]['CustomerEmail']; ?>"><?php echo $objPage->arrData['CustomerDeatails'][0]['CustomerEmail']; ?></a></li>
                                            <li><span>Mobile <strong>   :</strong> </span><small><?php echo $objPage->arrData['CustomerDeatails'][0]['CustomerPhone']; ?></small></li>
                                        </ul>
                                    </div>
                                    <div class="shipping_handling">
                                        <!--
                                        <div class="heading"> <h3>Shipping &amp; Handling Information</h3>
                                        </div>
                                        <ul>
                                            <li><span>Shipping Charges</span> : <?php //echo $objCore->getPrice($objPage->arrData['ShippingCost']);                                                                                                                                                                                    ?></li>
                                            <li><p>&nbsp;</p></li>
                                        </ul>

                                    </div> -->
                                    </div>

                                    <div class="boxes2">
                                        <div class="billing_information" style="margin-right:0px;">
                                            <div class="heading"> <h3>Billing Information</h3>
                                            </div>
                                            <ul>
                                                <?php
                                                if ($objPage->arrData['CustomerDeatails'][0]['BillingFirstName'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Recipient First Name <strong>   :</strong></span> <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingFirstName']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['BillingLastName'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Recipient Last Name<strong>   :</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingLastName']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['BillingOrganizationName'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Organization Name<strong>   :</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingOrganizationName']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['BillingAddressLine1'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Address Line 1<strong>   :</strong> </span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingAddressLine1']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['BillingAddressLine2'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Address Line 2<strong>   :</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingAddressLine2']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['BillingCountryName'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Country<strong>   :</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingCountryName']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['BillingPostalCode'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Post Code or Zip Code <strong>   :</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingPostalCode']; ?></small></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="shipping_information" style="margin-right:0px;">
                                            <div class="heading"> <h3>Shipping Information</h3>
                                            </div>
                                            <ul>
                                                <?php
                                                if ($objPage->arrData['CustomerDeatails'][0]['ShippingFirstName'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Recipient First Name <strong>   :</strong></span> <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingFirstName']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['ShippingLastName'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Recipient Last Name<strong>   :</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingLastName']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['ShippingOrganizationName'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Organization Name<strong>   :</strong></span>  <small> <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingOrganizationName']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine1'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Address Line 1<strong>   :</strong> </span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine1']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine2'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Address Line 2<strong>   :</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine2']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['ShipingCountryName'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Country<strong>   :</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShipingCountryName']; ?></small></li>
                                                    <?php
                                                }
                                                if ($objPage->arrData['CustomerDeatails'][0]['ShippingPostalCode'] <> '')
                                                {
                                                    ?>
                                                    <li><span>Post Code or Zip Code <strong>   :</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingPostalCode']; ?></small></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                    if ($objPage->arrData['orderProducts'])
                                    {
                                        ?>
                                        <div class="wish_sec"><table width="952" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <th align="center">Sub Order ID</th>
                                                    <th align="center">Items Ordered</th>
                                                    <th align="center">Items Image</th>
                                                    <th align="center">Price</th>
                                                    <!--<th align="center">Qty.</th>-->
                                                    <th align="center">Shipping</th>
                                                    <th align="center">Discount</th>
                                                    <th align="center">Grand Total</th>
                                                    <th align="center">Status</th>
                                                    <th align="center" class="last">Action</th>
                                                </tr>
                                                <?php
                                                //pre($objPage->arrData['orderProducts']); 
                                                $varCounter = 0;
                                                $arrStatus = array('Canceled' => 'red', 'Completed' => 'green', 'Disputed' => 'red', 'Pending' => 'Red', 'Posted' => 'violet');
                                                $i = 0;
                                                /* echo '<pre>';
                                                print_r($objPage->arrData['orderProducts']); die; */
                                                foreach ($objPage->arrData['orderProducts'] as $details)
                                                {
                                                    //pre($details);
                                                    if ($details['ItemType'] == 'product')
                                                    {
                                                        $path = 'products/' . $arrProductImageResizes['default'];
                                                    }
                                                    else if ($details['ItemType'] == 'package')
                                                    {
                                                        $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                                                    }
                                                    else
                                                    {
                                                        $path = 'gift_card';
                                                    }

                                                    $varSrc = $objCore->getImageUrl($details['ItemImage'], $path);

                                                    $varCounter++;
                                                    $isFeedback = 0;
                                                    ?>
                                                    <tr class="<?php echo $varCounter % 2 == 0 ? 'even' : 'odd'; ?>">
                                                        <td align="center" class="border_left"><?php echo ucwords($details['SubOrderID']); ?></td>
                                                        <td align="center"><?php echo '<b>' . $details['ItemName'] . '</b><br />' . $details['OptionDet']; ?></td>
                                                        <td align="center"><img src="<?php echo $varSrc; ?>" alt="<?php echo $details['ItemName']; ?>" style="float:none;" /></td>
                                                        <td align="center"><?php echo $objCore->getPrice($details['ItemPrice'] + ($details['AttributePrice'] / $details['Quantity'])) . ' x ' . $details['Quantity']; ?></td>
                                                        <!--<td align="center"><?PHP echo $details['Quantity']; ?></td>-->
                                                        <td align="center"><?php echo $objCore->getPrice($details['ShippingPrice']); ?></td>
                                                        <td align="center"><?php echo $objCore->getPrice(-$details['DiscountPrice']); ?></td>
                                                        <td align="center"><?php echo $objCore->getPrice($details['ItemTotalPrice']); ?></td>
                                                        <td align="center">
                                                            <?php
                                                            if ($path != 'gift_card')
                                                            {
                                                                ?>
                                                                <a style="color: <?php echo $arrStatus[$details['Status']] ?>; text-decoration: underline" href="#Shipping<?php echo $details['pkOrderItemID'] ?>" class="Shipping<?php echo $details['pkOrderItemID'] ?>" onclick="shippmentPopup('Shipping<?php echo $details['pkOrderItemID'] ?>');"><?php echo $details['Status']; ?></a> <?php }else{
                                                                    echo $details['Status'];
                                                                } ?>
                                                            <div style="display: none;">
                                                                <div id="Shipping<?php echo $details['pkOrderItemID'] ?>" style="width:300px;">
                                                                    <div class="cart_inner">
                                                                        <h3>Shipment Details</h3>
                                                                        <div class="cart_detail">
                                                                            <div class="detail_right">
                                                                                <ul style="min-height:90px;">
                                                                                    <?php
                                                                                    if (count($details['ShipTrackDetail']) > 0)
                                                                                    {
                                                                                        ?>
                                                                                        <li>
                                                                                            <small><?php echo 'Career'; ?></small>
                                                                                            <span style="text-decoration:lign-through;">: <?php echo $details['ShipTrackDetail']['ShippingTitle'] ?></span>
                                                                                        </li>
                                                                                        <li>
                                                                                            <small><?php echo 'Track No'; ?></small>
                                                                                            <span style="text-decoration:lign-through;">:
                                                                                                <?php
                                                                                                if ($details['ShipTrackDetail']['ShippingType'] == 'api' && $details['ShipTrackDetail']['ShippingAlias'] == 'UPS')
                                                                                                {
                                                                                                    $frmName = 'frm' . $details['pkOrderItemID'];
                                                                                                    ?>
                                                                                                    <a href="javascript:void(0);" onclick="document.<?php echo $frmName; ?>.submit();"><?php echo $details['ShipTrackDetail']['TransactionNo']; ?></a>
                                                                                                    <form target="_blank" action="http://wwwapps.ups.com/WebTracking/track?loc=en_US" method="post" name="<?php echo $frmName; ?>">
                                                                                                        <input type="hidden" class="inputnumber" value="<?php echo $details['ShipTrackDetail']['TransactionNo'] ?>" name="trackNums" />
                                                                                                        <input type="hidden" value="en_US" name="loc" />
                                                                                                        <input type="hidden" value="5.0" name="HTMLVersion" />
                                                                                                        <input type="hidden" value="null" name="saveNumbers" />
                                                                                                        <input type="hidden" value="Track" name="track.x" />
                                                                                                    </form>
                                                                                                    <?php
                                                                                                }
                                                                                                else if ($details['ShipTrackDetail']['ShippingType'] == 'api' && $details['ShipTrackDetail']['ShippingAlias'] == 'Fedex')
                                                                                                {
                                                                                                    ?>
                                                                                                    <a href="https://www.fedex.com/fedextrack/?tracknumbers=<?php echo $details['ShipTrackDetail']['TransactionNo']; ?>" target="_blank"><?php echo $details['ShipTrackDetail']['TransactionNo']; ?></a>
                                                                                                    <?php
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    echo $details['ShipTrackDetail']['TransactionNo'];
                                                                                                }
                                                                                                ?>
                                                                                            </span>
                                                                                        </li>
                                                                                        <li>
                                                                                            <small><?php echo 'Status'; ?></small>
                                                                                            <span style="text-decoration:lign-through;">: <?php echo $details['ShipTrackDetail']['ShippingStatus'] ?></span>
                                                                                        </li>
                                                                                        <li>
                                                                                            <small><?php echo 'Date'; ?></small>
                                                                                            <span style="text-decoration:lign-through;"> : <?php echo $objCore->localDateTime($details['ShipTrackDetail']['ShippedDate'], DATE_FORMAT_SITE_FRONT); ?></span>
                                                                                        </li>
                                                                                        <?php
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <li>
                                                                                            <small>No update till now.</small>
                                                                                        </li>
                                                                                    <?php } ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td align="center" class="last">
                                                            <?php
                                                            if ($details['Status'] != 'Completed')
                                                            {
                                                                ?>
                                                                <a href="<?php echo $objCore->getUrl('compose_message.php', array('wid' => $details['fkWholesalerID'])); ?>" class="feedback_link">Support</a>
                                                                <?php
                                                            }
                                                            else if ($details['ItemType'] == 'package')
                                                            {
                                                                ?>
                                                                <a href="<?php echo $objCore->getUrl('package.php', array('pkgid' => $details['fkItemID'])); ?>" class="order_link">Re-Order</a>
                                                                <?php
                                                                if (!$details['pkFeedbackID'])
                                                                {
                                                                    $isFeedback = 1;
                                                                }
                                                                ?>
                                                                <?php
                                                            }
                                                            else if ($details['ItemType'] == 'product')
                                                            {
                                                                ?>
                                                                <a href="<?php echo $objCore->getUrl('product.php', array('name' => 'reorder', 'id' => $details['fkItemID'])); ?>" class="order_link">Re-Order</a>
                                                                <?php
                                                                if (!$details['pkFeedbackID'])
                                                                {
                                                                    $isFeedback = 1;
                                                                }
                                                            }

                                                            if ($isFeedback == 1)
                                                            {
                                                            	/* This condition applied by Krishna Gupta (19-10-2015) */
                                                            	/* To disable the Feedback button after 30days ( if customer not provided feedback till 30days ) */
                                                            	$date1 = date_create($details['ItemDateAdded']);
                                                            	$date2 = date_create($objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
                                                            	$diff = date_diff($date1, $date2);
                                                            	$varDays = $diff->format("%r%a");
                                                            	if ($varDays < 30) {
                                                            	/* This condition applied by Krishna Gupta ends */
                                                                ?>
                                                                
                                                                <a href="#<?php echo $details['pkOrderItemID'] ?>" class="feedback_link <?php echo $details['pkOrderItemID'] ?>" onclick="sendFeedbackPopup(<?php echo $details['pkOrderItemID'] ?>);">Send Feedback</a>
                                                                <?php } 
                                                                /* if customer not provided feedback till 30days then feedback considered as a positive feedback */
                                                                else {
                                                                	$objPage->InsertFeedback($details);
                                                                }?>
                                                                <div style="display: none;">
                                                                    <div id="<?php echo $details['pkOrderItemID'] ?>" class="reply_message">
                                                                        <div class="post_disputed">
                                                                            <div class="q_text"><?php echo FRONT_FEEDBACK_QUESTION1; ?></div>
                                                                            <div class="q_ans"><input type="radio" checked name="Question1<?php echo $details['pkOrderItemID'] ?>" value="1" />Yes &nbsp;<input type="radio" name="Question1<?php echo $details['pkOrderItemID'] ?>" value="0" />No</div>
                                                                            <div class="q_text"><?php echo FRONT_FEEDBACK_QUESTION2; ?></div>
                                                                            <div class="q_ans"><input type="radio" checked name="Question2<?php echo $details['pkOrderItemID'] ?>" value="1" />Yes &nbsp;<input type="radio" name="Question2<?php echo $details['pkOrderItemID'] ?>" value="0" />No</div>
                                                                            <div class="q_text"><?php echo FRONT_FEEDBACK_QUESTION3; ?></div>
                                                                            <div class="q_ans"><input type="radio" checked name="Question3<?php echo $details['pkOrderItemID'] ?>" value="1" />Yes &nbsp;<input type="radio" name="Question3<?php echo $details['pkOrderItemID'] ?>" value="0" />No</div>
                                                                            <div class="q_text">Comments:</div>
                                                                            <div class="q_ans"><textarea name="comments" id="comments<?php echo $details['pkOrderItemID'] ?>" rows="5" cols="35" style="width: 100% ! important; border:1px solid #d2d2d2;resize: none;"></textarea></div>
                                                                            <div style="border: 0px solid;
                                                                                /*  float: right; */
                                                                                 margin-top: 20px;
                                                                                 width: 310px;">
                                                                                
                                                                                <input type="submit" onclick="sendMyFeedback('<?php echo $details['FeedbackPIDs'] ?>', '<?php echo $details['fkOrderID'] ?>', '<?php echo $details['fkWholesalerID'] ?>', '<?php echo $details['pkOrderItemID'] ?>','<?php echo $details['ShipTrackDetail']['fkShippingCarrierID'];?>');" name="submit" value="Send" class="submit button submit3" style="margin-right: 5px;
                                                                                       height: 39px;
                                                                                       width:144px !important;
                                                                                       margin-left: 1px !important;
                                                                                       padding: 10px 30px 10px 30px!important;" />
                                                                                <input type="button" name="cancel" value="Cancel" style="height: 39px; padding:10px 30px 10px 30px!important;" id="compose_cancel<?php echo $details['pkOrderItemID'] ?>" class="submit button cancel" />
                                                                            </div>
                                                                            <div class="feedbacksuccessmessage" style="clear:both"></div>
                                                                            <input type="hidden" name="post_feedback" value="yes" />
                                                                            <input type="hidden" name="customerID" value="<?php echo $_SESSION['sessUserInfo']['id'] ?>" />
                                                                            <div class="q_text">&nbsp;</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php
                                                            if (count($details['arrDisputedCommentsHistory']) > 0 && ($details['arrDisputedCommentsHistory'][$i]['fkSubOrderID'] == $details['SubOrderID']))
                                                            {
                                                                $clss = ($details['DisputedStatus'] == 'Resolved') ? 'order_link Dis' . $details['pkOrderItemID'] : 'support_sec Dis' . $details['pkOrderItemID'];
                                                                ?>
                                                                <a href="#Dis<?php echo $details['pkOrderItemID'] ?>" class="<?php echo $clss; ?>" onclick="sendDisputedPopup('Dis<?php echo $details['pkOrderItemID'] ?>');">Disputed History</a>
                                                                <div style="display: none;">
                                                                    <div id="Dis<?php echo $details['pkOrderItemID'] ?>" class="reply_message">
                                                                        <div class="post_disputed">
                                                                            <?php
                                                                            if ($details['DisputedStatus'] == 'Resolved')
                                                                            {
                                                                                ?>
                                                                                <div class="q_text green"><?php echo DISPUTE_RESOLVED; ?></div>
                                                                            <?php } ?>
                                                                            <?php
                                                                            foreach ($details['arrDisputedCommentsHistory'] as $kkk => $vvv)
                                                                            {
                                                                                ?>
                                                                                <div class="q_ans"></div>
                                                                                <div class="q_text">By <?php echo $vvv[$vvv['CommentedBy']] . '(' . $vvv['CommentedBy'] . ') <small class="green">' . $objCore->localDateTime($vvv['CommentDateAdded'], DATE_TIME_FORMAT_SITE_FRONT) . '</small>'; ?><br/><br/></div>

                                                                                <?php
                                                                                if ($vvv['CommentOn'] == 'Disputed')
                                                                                {
                                                                                    $Qdata = unserialize($vvv['CommentDesc']);
                                                                                    ?>
                                                                                    <div class="q_text"><?php echo $arrDisputedComments['Q1']; ?></div>
                                                                                    <div class="q_ans">
                                                                                        <?php echo $arrDisputedComments[$Qdata['Q1']]; ?>
                                                                                    </div>
                                                                                    <?php
                                                                                    if ($Qdata['Q1'] == 'A11')
                                                                                    {
                                                                                        ?>
                                                                                        <div class="q_text"><?php echo $arrDisputedComments['Q11']; ?></div>
                                                                                        <div class="q_ans">
                                                                                            <?php echo $Qdata['Q11']; ?>
                                                                                        </div>
                                                                                        <?php
                                                                                        $additionalCommentsQ = $arrDisputedComments['Q12'];
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <div class="q_text"><?php echo $arrDisputedComments['Q21']; ?></div>
                                                                                        <div class="q_ans">
                                                                                            <?php
                                                                                            $arrQ21 = explode(',', $Qdata['Q21']);
                                                                                            $Q21 = '';
                                                                                            foreach ($arrQ21 as $v10)
                                                                                            {
                                                                                                if (key_exists($v10, $arrDisputedComments))
                                                                                                {
                                                                                                    $Q21 .= $arrDisputedComments[$v10] . ',';
                                                                                                }
                                                                                                else
                                                                                                {
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
                                                                                }
                                                                                else
                                                                                {
                                                                                    $additionalCommentsQ = 'Feedback';
                                                                                }
                                                                                ?>
                                                                                <div class="q_text"><?php echo $additionalCommentsQ; ?></div>
                                                                                <div class="q_ans"><?php echo $vvv['AdditionalComments']; ?></div>
                                                                                <?php
                                                                            }
                                                                            $varValidation .= '$("#disFeed' . $details['pkOrderItemID'] . '").validationEngine();';
                                                                            ?><div class="q_ans"><hr/></div>
                                                                            <form method="post" id="<?php echo 'disFeed' . $details['pkOrderItemID']; ?>">
                                                                                <div class="q_text"><?php echo 'Post Your Feedback'; ?></div>
                                                                                <div class="q_ans">
                                                                                    <div class="input_star">
                                                                                        <textarea name="frmFeedback" rows="3" cols="50" class="validate[required]" style=" padding:10px;width: 469px ! important;
                                                                                                  resize: none;
                                                                                                  height: 100px;
                                                                                                  border: 1px solid #d2d2d2;resize: none;"></textarea>
                                                                                        <small class="star_icon" style=" right:1px;"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>star_icon.png" alt=""/></small>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="height: 30px;clear: both;width: 290px;float: right;">
                                                                                    <input type="submit" class="submit3" name="submit" value="Send"  style="margin-right: 5px;
                                                                                           padding: 10px 30px 10px 30px;
                                                                                           clear: left;
                                                                                           width: 140px;
                                                                                           height: 40px;
                                                                                           float: left;
                                                                                           " />
                                                                                    <input type="button" name="cancel" value="Cancel" style="float: right;" id="clDis<?php echo $details['pkOrderItemID'] ?>" class="cancel" />
                                                                                </div>
                                                                                <input type="hidden" name="type" value="disputeFeedback" />
                                                                                <input type="hidden" name="oid" value="<?php echo $details['fkOrderID']; ?>" />
                                                                                <input type="hidden" name="soid" value="<?php echo $details['SubOrderID'] ?>" />
                                                                                <div class="q_ans">&nbsp;</div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                            else if ($varDays < 30 && $details['DisputedStatus'] == 'noDisputed' && $details['Status'] <> 'Canceled')
                                                            {
                                                                ?>
                                                                <a href="#Dis<?php echo $details['pkOrderItemID'] ?>" class="support_sec Dis<?php echo $details['pkOrderItemID'] ?>" onclick="sendDisputedPopup('Dis<?php echo $details['pkOrderItemID'] ?>');">Dispute</a>
                                                                <div style="display: none;">
                                                                    <div id="Dis<?php echo $details['pkOrderItemID'] ?>" class="reply_message">
                                                                        <div class="post_disputed">

                                                                            <form method="post" id="frmDisputeForm" onsubmit="return validateForm();">
                                                                                <div class="q_text"><?php echo $arrDisputedComments['Q1']; ?></div>
                                                                                <div class="q_ans">
                                                                                    <input type="radio" checked="checked" name="Q1" value="A11" onchange="disputProblem('A11', '<?php echo $details['pkOrderItemID'] ?>','Dis<?php echo $details['pkOrderItemID'] ?>')" /> <?php echo $arrDisputedComments['A11']; ?>
                                                                                    <br/>
                                                                                    <input type="radio" name="Q1" value="A12" onchange="disputProblem('A12', '<?php echo $details['pkOrderItemID'] ?>','Dis<?php echo $details['pkOrderItemID'] ?>')" /> <?php echo $arrDisputedComments['A12']; ?>
                                                                                </div>
                                                                                <div id="Dis1<?php echo $details['pkOrderItemID'] ?>" style="display: block;">
                                                                                    <div class="q_text"><?php echo $arrDisputedComments['Q11']; ?></div>
                                                                                    <div class="input_star">
                                                                                        <div class="drop4 dropdown_2" id="res_Dispute">
                                                                                            <div class="ErrorResCountry formError" style="opacity: 0.87; position: absolute; top: 180px; display: none; margin-top: -213px; left: 273px !important;">
                                                                                                <div class="formErrorContent">* Reason Required<br>
                                                                                                </div>
                                                                                                <div class="formErrorArrow">
                                                                                                    <div class="line10"><!-- --></div>
                                                                                                    <div class="line9"><!-- --></div>
                                                                                                    <div class="line8"><!-- --></div>
                                                                                                    <div class="line7"><!-- --></div>
                                                                                                    <div class="line6"><!-- --></div>
                                                                                                    <div class="line5"><!-- --></div>
                                                                                                    <div class="line4"><!-- --></div>
                                                                                                    <div class="line3"><!-- --></div>
                                                                                                    <div class="line2"><!-- --></div>
                                                                                                    <div class="line1"><!-- --></div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="q_ans">
                                                                                            <select name="Q11" id="resDispute" style="width: 447px;
                                                                                                        clear: both;
                                                                                                        border: 1px solid #a9a9a9;
                                                                                                        height: 40px;
                                                                                                        background: #fff!important;
                                                                                                        border-radius: 0px;">
                                                                                                        <?php
                                                                                                    foreach ($objPage->arrData['arrDisputedCommentList'] as $kdi => $vdi)
                                                                                                    {
                                                                                                        ?>
																		  <option value="<?php echo $vdi['Title']; ?>"><?php echo $vdi['Title']; ?></option>
																		   <?php } ?>
																		  
																							</select>
                                                                                                
                                                                                                <!--
                                                                                                <input type="radio" checked name="Q11" value="A111" /> <?php echo $arrDisputedComments['A111']; ?>
                                                                                                <br/>
                                                                                                <input type="radio" name="Q11" value="A112" /> <?php echo $arrDisputedComments['A112']; ?>
                                                                                                -->
                                                                                            </div>
                                                                                        </div>
                                                                                        <small class="star_icon"><img src="<?php echo SITE_ROOT_URL; ?>common/images/star_icon.png" alt=""/></small>
                                                                                    </div>

                                                                                    <div class="q_text"><?php echo $arrDisputedComments['Q12']; ?><small class="red"> (Maximum 500 charecters)</small></div>
                                                                                    <div class="q_ans">
                                                                                        <textarea name="Q12" id="Q12" rows="3" cols="35" maxlength="500" style="height: 180px;
                                                                                                  width: 97% ! important;
                                                                                                  resize: none;
                                                                                                  padding: 5px;"  class="validate[required]"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div id="Dis2<?php echo $details['pkOrderItemID'] ?>" style="display: none;">
                                                                                    <div class="q_text"><?php echo $arrDisputedComments['Q21']; ?></div>
                                                                                    <div class="q_ans">
                                                                                        <input type="checkbox" name="Q21[]" value="A211" /> <?php echo $arrDisputedComments['A211']; ?><br />
                                                                                        <input type="checkbox" name="Q21[]" value="A212" /> <?php echo $arrDisputedComments['A212']; ?><br />
                                                                                        <input type="checkbox" name="Q21[]" value="A213" /> <?php echo $arrDisputedComments['A213']; ?><br />
                                                                                        <input type="checkbox" name="Q21[]" value="A214" /> <?php echo $arrDisputedComments['A214']; ?><br />
                                                                                        <input type="checkbox" name="Q21[]" value="A215" /> <?php echo $arrDisputedComments['A215']; ?><br />
                                                                                        <input type="checkbox" name="Q21[]" value="A216" /> <?php echo $arrDisputedComments['A216']; ?><br />
                                                                                        <input type="checkbox" name="Q21[]" value="A217" /> <?php echo $arrDisputedComments['A217']; ?><br />
                                                                                        <input type="checkbox" name="Q21[]" value="A218" /> <?php echo $arrDisputedComments['A218']; ?><br />
                                                                                        <?php echo $arrDisputedComments['A219']; ?> <input type="text" class="inputflds" name="Q21[]" value="" maxlength="50" placeholder="Maximum 50 characters allowed" width="195px"/>
                                                                                    </div>
                                                                                    <div class="q_text"><?php echo $arrDisputedComments['Q22']; ?></div>
                                                                                    <div class="q_ans">
                                                                                        <input type="radio" name="Q22" value="A221" checked="checked" /> <?php echo $arrDisputedComments['A221']; ?> &nbsp;
                                                                                        <input type="radio" name="Q22" value="A222" /> <?php echo $arrDisputedComments['A222']; ?>
                                                                                    </div>
                                                                                    <div class="q_text"><?php echo $arrDisputedComments['Q23']; ?></div>
                                                                                    <div class="q_ans">
                                                                                        <input type="radio" name="Q23" value="A231" checked="checked" /> <?php echo $arrDisputedComments['A231']; ?> &nbsp;
                                                                                        <input type="radio" name="Q23" value="A232" /> <?php echo $arrDisputedComments['A232']; ?>
                                                                                    </div>
                                                                                    <div class="q_ans">
                                                                                        If you have received any suspicious emails recently, please forward the suspicious email to <a href="mailto:spoof@telamela.com.au">spoof@telamela.com.au</a>.
                                                                                    </div>
                                                                                    <div class="q_text"><?php echo $arrDisputedComments['Q24']; ?></div>
                                                                                    <div class="input_star">
                                                                                        <div class="drop4 dropdown_2" id="res2_Dispute">
                                                                                            <div class="ErrorResCountry2 formError" style="opacity: 0.87; position: absolute; top: 180px; display: none; margin-top: -213px; left: 273px !important;">
                                                                                                <div class="formErrorContent">* Reason Required<br>
                                                                                                </div>
                                                                                                <div class="formErrorArrow">
                                                                                                    <div class="line10"><!-- --></div>
                                                                                                    <div class="line9"><!-- --></div>
                                                                                                    <div class="line8"><!-- --></div>
                                                                                                    <div class="line7"><!-- --></div>
                                                                                                    <div class="line6"><!-- --></div>
                                                                                                    <div class="line5"><!-- --></div>
                                                                                                    <div class="line4"><!-- --></div>
                                                                                                    <div class="line3"><!-- --></div>
                                                                                                    <div class="line2"><!-- --></div>
                                                                                                    <div class="line1"><!-- --></div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="q_ans">
                                                                                                <select name="Q24" id="res2Dispute" style="width: 447px;
                                                                                                        clear: both;
                                                                                                        border: 1px solid #a9a9a9;
                                                                                                        height: 40px;
                                                                                                        background: #fff!important;
                                                                                                        border-radius: 0px;">
                                                                                                    <option value="">Select reason</option>
                                                                                                    <?php
                                                                                                    foreach ($objPage->arrData['arrDisputedCommentList'] as $kdi => $vdi)
                                                                                                    {
                                                                                                        ?>
                                                                                                        <option value="<?php echo $vdi['Title']; ?>"><?php echo $vdi['Title']; ?></option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <small class="star_icon"><img src="<?php echo SITE_ROOT_URL; ?>common/images/star_icon.png" alt=""/></small>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="border: 0px solid;float: right;margin-top: 20px;width: 290px;">
                                                                                    <input type="submit" name="submit" value="Send" class="submit button submit3" style="margin-right: 5px; padding:10px 30px 10px 30px!important " />
                                                                                    <input type="button" name="cancel" value="Cancel" id="clDis<?php echo $details['pkOrderItemID'] ?>" class="submit button cancel" />
                                                                                </div>
                                                                                <input type="hidden" name="type" value="dispute" />
                                                                                <input type="hidden" name="oid" value="<?php echo $details['fkOrderID']; ?>" />
                                                                                <input type="hidden" name="soid" value="<?php echo $details['SubOrderID'] ?>" />
                                                                                <div class="q_ans">&nbsp;</div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>

                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    <?php } ?>
                                    <div class="last_box">
                                        <div class="comment_box">
                                            <label style="width: 200px;">Comments History</label>
                                            <div style="background-color: #ffffff; border:1px solid #d9d9d9;  margin-top:30px; padding: 5px; font: 12px/14px 'OpenSansRegular',arial;min-height: 50px;">
                                                <?php
                                                //pre($objPage->arrData['orderComments']);
                                                foreach ($objPage->arrData['orderComments'] as $key => $val)
                                                {
                                                    echo $val['Comment'] . '<br /><p style="font-weight: bold;text-align: right;">' . $val[$val['CommentedBy'] . 'Name'] . ' (' . ucwords($val['CommentedBy']) . ')</p>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="total_amount">
                                            <ul>
                                                <?php
                                                foreach ($objPage->arrData['orderTotal'] as $val)
                                                {
                                                    if ($val['Code'] <> 'total')
                                                    {
                                                        ?>
                                                        <li><small><?php echo $val['Title'] ?></small> <span><?php echo $objCore->getPrice($val['Amount']); ?> </span></li>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <li class="grand" style=""><strong>Grand  <?php echo $val['Title'] ?></strong><span><?php echo $objCore->getPrice($val['Amount']); ?></span></li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    echo FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG2;
                                }
                                ?>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
<?php echo $varValidation; ?>
        </script>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>