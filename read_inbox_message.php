<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_SUPPORT_CTRL;
require_once CLASSES_PATH .'class_wholesaler_bll.php';
$wholesaler=new Wholesaler();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MESSAGE_READ_INBOX_TITLE;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#reply_message_form").validationEngine();
                $('.drop_down1').sSelect();
            });
            function wholesalerReplyPopup(str){                
                $("."+str).colorbox({inline:true,width:"700px"});
                
                $('#compose_cancel').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            }            
        </script>
    </head>
    <body>
        <style>
		.add_edit_pakage{ background:#f5f5f5; padding:10px; }
		.compose_message .compose_right{ width:707px;}
		 </style>
          <em> <div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
    
        </em>
       <div class="header" style="border-bottom:none"><div class="layout"></div>
               <?php include_once INC_PATH . 'header.inc.php'; ?>
        
       </div>
      
          
        <div id="ouderContainer" class="ouderContainer_1"><div class="wholesalerHeaderSection" style="width:100%; height:50px; padding-top:16px;	  border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">
             
                
                <div class="add_pakage_outer">
                    <div class="top_container" style="padding-bottom: 18px;">
                        
                        
                        <!--<a href="<?php // echo $objCore->getUrl('wholesaler_messages_inbox.php', array('place' => 'inbox')); ?>" class="back"><span><?php //echo BACK;?></span></a>-->
                    </div>
                 
                    <div class="body_inner_bg">
                        <div class="add_edit_pakage compose_message">
                            <div class="compose_left_outer">
                                <ul class="compose_left">
								  <li class="compose_box"><a href="<?php echo $objCore->getUrl('wholesaler_compose_message.php', array('place' => 'compose')); ?>"><?php echo COMPOSE; ?></a></li>
                                    <li class="inbox"><a style="color:#56a1f2" href="<?php echo $objCore->getUrl('wholesaler_messages_inbox.php', array('place' => 'inbox')); ?>"><?php echo INBOX; ?><small><i class="fa fa-angle-right"></i></small> </a></li>
                                    <li class="outbox"><a href="<?php echo $objCore->getUrl('wholesaler_outbox_messages.php', array('place' => 'outbox')); ?>"><?php echo OUTBOX; ?></a></li>
                                  
                                </ul>
                            </div>
                            <div id="compose_right_section" class="compose_right_outer">
                                <div class="compose_right" style="margin-top:7px">
                                    <h2><?php echo MESSAGE_READ;?></h2>
                                     <?php if(count($objPage->arrMessage)>0){?>
                                    <div class="read_inputbox">
                                        <?php foreach ($objPage->arrMessage as $varMessage) { ?>

                                            <?php
                                            if ($varMessage['FromUserType'] == "admin") {
                                                $varSenderName = 'Admin';
                                            }else if ($varMessage['FromUserType'] == "wholesaler") {
                                               $getSenderDetails=$wholesaler->WholesalerDetails($varMessage['fkFromUserID']);
                                               $varSenderName=isset($getSenderDetails) && count($getSenderDetails)>0?$getSenderDetails['CompanyName']:'';
                                            } else {
                                                $varSenderName = $varMessage['CustomerFirstName']." ".$varMessage['CustomerLastName'];
                                            }
                                            ?>
                                            <ul class="compose_right_inner">
                                                <li class="first">
                                                    <p><?php echo SENDER;?> <strong>:</strong></p>
                                                    <span><?php echo $varSenderName; ?></span>
                                                    <div class="right_time_sec">
                                                        <img src="common/images/watch_icon.png" alt=""/>
                                                        <p><span><?php echo date('d M Y', strtotime($objPage->arrMessage[0]['SupportDateAdded'])); ?></span> <small><?php echo date('H:i a', strtotime($objPage->arrMessage[0]['SupportDateAdded'])); ?></small></p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <p class="labelP" ><?php echo SUBJECT;?><strong>:</strong></p>
                                                    <p class="floatedMessage"><?php echo $varMessage['Subject'] ?></p>
                                                </li>
                                                <li>
                                                    <p class="labelP" ><?php echo MESSAGE;?> <strong>:</strong></p>
                                                    <p class="floatedMessage"><?php echo $varMessage['Message'] ?></p>
                                                </li>
                                            </ul>
                                        <?php } ?>
                                        <div class="simple_box ulsubmittButton">
										<a href="#reply_message" class="delete del_blue submit3" onclick="wholesalerReplyPopup('delete');"><?php echo REPLY;?></a>
										</div>
	 </div>
                                     <?php }else{?>
                                    <?php echo '<br/>'.ADMIN_NO_RECORD_FOUND?>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: none;">
            <div id="reply_message" class="reply_message">

                <form name="reply_message_form" id="reply_message_form" method="POST" action="" class="rpy_frm_fld">

                    <div class="left_m"><label><?php echo TO;?></label> :</div><div class="right_m"><?php echo $varSenderName; ?>&nbsp;</div>                    

                    <div class="left_m"><label><?php echo SUBJECT;?> <span style="color:#FF0000"> *</span></label>:</div><div class="right_m"><input style="width:408px" class="validate[required]" value="<?php echo 'Re: ' . $objPage->arrMessage[0]['Subject'] ?>" type="text" name="frmSubject" /></div>

                    <div class="left_m"><label><?php echo MESSAGE;?><span style="color:#FF0000"> *</span></label>:</div><div class="right_m"><textarea class="validate[required]" name="frmMessage" rows="9" cols="35"></textarea></div>

                    <div class="left_m">&nbsp;</div><div class="right_m" style="width:311px !important"><input type="button" style="float:right" name="cancel" value="Cancel" class="cancel" id="compose_cancel" /><input type="submit" name="submit" value="Send" class="submit3" /></div>
                    
                    <input type="hidden" name="frmMessageType" value="<?php echo $objPage->arrMessage[0]['SupportType'] ?>" />
                    <input type="hidden" name="frmToUserType" value="<?php echo $objPage->arrMessage[0]['FromUserType'] ?>" />
                    <input type="hidden" name="fkToUserID" value="<?php echo $objPage->arrMessage[0]['fkFromUserID'] ?>" />
                    <input type="hidden" name="place" value="reply" />
                    <input type="hidden" name="thread" value="inbox" />
                    <input type="hidden" name="fkSupportID" value="<?php echo $objPage->arrMessage[0]['pkSupportID'] ?>" />
                    <input type="hidden" name="fkParentID" value="<?php echo $objPage->arrMessage[0]['fkParentID'] ?>" />
                </form>
            </div>
        </div>

        <?php include_once 'common/inc/footer.inc.php'; ?>

    </body>
</html> 
