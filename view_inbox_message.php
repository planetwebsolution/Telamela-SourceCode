<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_SUPPORT_CTRL;
$objCore = new Core();
require_once CLASSES_PATH .'class_customer_user_bll.php';
$cus=new Customer();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MESSAGE_VIEW_INBOX_TITLE;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#reply_message_form").validationEngine();
                $('.drop_down1').sSelect();
            });
            
            function ReplyPopup(str){
                $("."+str).colorbox({inline:true,width:"700px"});                
                $('#compose_cancel').click(function(){parent.jQuery.fn.colorbox.close();});
            }
        </script>
        <style>
		
		.compose_sec{ width:989px; padding:13px; }
	.compose_right .back span{ color: #fff;padding: 10px 20px 20px 30px; background-position: 1px 11px
}
.main_outbox_sec .feebacks_sec{ width:714px !important}
	#cboxLoadedContent{ height:240px }
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
                      <div class="top_header border_bottom">
                            <h1>Customer Account</h1>
                        </div> <div class="add_edit_pakage compose_sec">
                        <div class="compose_left_outer">
                            <ul class="compose_left">
                                  <li class="compose_box"><a href="<?php echo $objCore->getUrl('compose_message.php', array('place' => 'compose')); ?>"><?php echo COMPOSE;?></a></li><li class="inbox"><a href="<?php echo $objCore->getUrl('messages_inbox.php', array('place' => 'inbox')); ?>"><?php echo INBOX;?><small style="margin-top:4px"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>ref_icon.png" alt=""/></small></a></li>
                                <li class="outbox"><a href="<?php echo $objCore->getUrl('outbox_messages.php', array('place' => 'outbox')); ?>"><?php echo OUTBOX;?></a></li>
                              

                            </ul>
                        </div>
                        <div class="compose_right_outer">
                            <div class="compose_right">
                                <?php //pre($objPage->arrInboxMessageView);?>
                                <h2><?php echo MESSAGE_VIEW_INBOX_TITLE;?><a href="<?php echo $objCore->getUrl('messages_inbox.php', array('place' => 'inbox')); ?>" class="back"><span><?php echo BACK;?></span></a></h2>
                                <?php foreach ($objPage->arrInboxMessageView as $valInboxMeassage) { ?>
                                    <ul class="compose_right_inner">
                                        <li class="first">
                                            <p><?php echo SENDER;?> <strong> :</strong></p>
                                            <?php
                                            if ($valInboxMeassage['FromUserType'] == "wholesaler") {
                                                $varSenderName = $valInboxMeassage['CompanyName'];
                                            }else if ($valInboxMeassage['FromUserType'] == "customer") {
                                                $getSenderDetails=$cus->CustomerDetails($valInboxMeassage['fkFromUserID']);
                                                $varSenderName=isset($getSenderDetails) && count($getSenderDetails)>0?$getSenderDetails[0]['CustomerFirstName']." ".$getSenderDetails[0]['CustomerLastName']:'';
                                            }
                                            else {
                                                $varSenderName = "admin";
                                            }
                                            ?>
                                            <span><?php echo ucwords($varSenderName); ?>  </span>
                                            <div class="right_time_sec">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL; ?>watch_icon.png" alt=""/>
                                                <p>&nbsp;</p>
                                                <p><?php echo $objCore->localDateTimeSite($valInboxMeassage['SupportDateAdded'], DATE_TIME_FORMAT_SITE_FRONT); ?></p>
                                            </div>
                                        </li>
                                        <li>
                                            <p class="labelP" ><?php echo SUPPORT_TYPE;?> <strong> :</strong></p>
                                            <p class="floatedMessage"><?php echo $valInboxMeassage['SupportType'] ?></p>

                                        </li>
                                        <li>
                                            <p class="labelP" ><?php echo SUBJECT;?> <strong> :</strong></p>
                                            <p class="floatedMessage"><?php echo $valInboxMeassage['Subject'] ?></p>

                                        </li>
                                        <li>
                                           <p class="labelP" ><?php echo MESSAGE;?><strong> :</strong></p>
                                            <p class="floatedMessage"><?php echo $valInboxMeassage['Message'] ?></p>
                                        </li>
                                       
                                    </ul>
                                <?php } ?>
								<?php if(count($objPage->arrInboxMessageView)>0){ ?>
                                <div class="simple-Box">
								<a style=" margin-left: 10px; margin-top: 10px;" href="#reply_message" class="delete del_blue submit3" onclick="ReplyPopup('delete');"><?php echo ADMIN_REPLY_BUTTON;?></a></div>
								<?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: none;">
            <div id="reply_message" class="reply_message">
                <form name="reply_message_form" id="reply_message_form" method="POST" action="">
                    <?php
                    //pre($objPage->arrInboxMessageView);
                    if ($objPage->arrInboxMessageView[0]['CompanyName'] != "") {
                        $varSenderName = $objPage->arrInboxMessageView[0]['CompanyName'];
                    } else {
                        $varSenderName = "admin";
                    }
                    ?>
                    <div class="left_m"><label><?php echo TO;?></label> :</div><div class="right_m" style="margin-top:10px;"><?php echo $varSenderName; ?></div>


                    <div class="left_m"><label><?php echo SUBJECT;?><span style="color:#FF0000"> <span style="color:#FF0000"> *</span></span></label> :</div>
                    <div class="right_m"><input class="validate[required]" value="<?php echo 'Re: ' . $objPage->arrInboxMessageView[0]['Subject'] ?>" type="text" name="frmSubject" /></div>

                    <div class="left_m" ><label><?php echo MESSAGE;?> <span style="color:#FF0000"> *</span></label> :</div>
                    <div class="right_m"><textarea class="validate[required]" name="frmMessage" rows="9" cols="35"></textarea></div>

                    <div class="left_m">&nbsp;</div><div class="right_m" style="
    width: 343px !important;"><input type="submit" name="frmHidenSend" class="submit3 extra_btn"  style="padding:0px;" value="<?php echo SEND;?>" /><input type="button" name="cancel" value="<?php echo CANCEL;?>" class="cancel" id="compose_cancel" /></div>                    

                    <input type="hidden" name="frmMessageType" value="<?php echo $objPage->arrInboxMessageView[0]['SupportType'] ?>" />
                    <input type="hidden" name="frmToUserType" value="<?php echo $objPage->arrInboxMessageView[0]['FromUserType'] ?>" />
                    <input type="hidden" name="fkToUserID" value="<?php echo $objPage->arrInboxMessageView[0]['fkFromUserID'] ?>" />
                    <input type="hidden" name="place" value="reply" />
                    <input type="hidden" name="thread" value="inbox" />
                    <input type="hidden" name="fkSupportID" value="<?php echo $objPage->arrInboxMessageView[0]['pkSupportID'] ?>" />
                    <input type="hidden" name="fkParentID" value="<?php echo $objPage->arrInboxMessageView[0]['fkParentID'] ?>" />
                </form>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>


    </body>
</html>