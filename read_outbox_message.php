<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_SUPPORT_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Read-Outbox-Message</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#reply_message_form").validationEngine();
                $('.drop_down1').sSelect();
            });
            
            function wholesalerReplyPopup(str){                
                $("."+str).colorbox({
                    inline:true,
                    width:"700px"
                });
                
                $('#compose_cancel').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            }
        </script>
    </head>
    <body>
        <style>p{margin:0 18px 0 0 !important;}</style>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"></div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%;height:50px; padding-top:16px;border-bottom:1px solid #e7e7e7;" class="wholesalerHeaderSection"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_header border_bottom"><h1>Support</h1></div>
                    <div class="body_inner_bg main_outbox_sec">
                        <div class="add_edit_pakage compose_message">
                            <div class="compose_left_outer">
                                <ul class="compose_left">
                                    <li class="compose_box"><a href="<?php echo $objCore->getUrl('wholesaler_compose_message.php', array('place' => 'compose')); ?>"><?php echo COMPOSE; ?></a></li>
                                    <li class="compose_box"><a  href="<?php echo $objCore->getUrl('wholesaler_messages_inbox.php', array('place' => 'inbox')); ?>"><?php echo INBOX; ?> </a></li>
                                    <li class="compose_active"><a style="color:#56a1f2" href="<?php echo $objCore->getUrl('wholesaler_outbox_messages.php', array('place' => 'outbox')); ?>"><?php echo OUTBOX; ?>
                                        <small><img src="common/images/ref_icon.png" alt="" style="margin-top:4px;  position: absolute;"/></small>
                                        </a></li>

                                </ul>
                            </div>
                            <div class="compose_right_outer">
                                <div class="compose_right">
                                    <h2>Read Outbox Message</h2>
                                    <?php if (count($objPage->arrMessage) > 0)
                                    { ?>
                                        <div class="read_inputbox">
                                            <ul class="compose_right_inner">
                                                <li class="first">
                                                    <p>Recipient<strong style="float:none">:</strong></p>
                                                    <span><?php echo $varTo = ($objPage->arrMessage[0]['ToUserType'] == 'admin') ? 'Admin' : $objPage->arrMessage[0]['CustomerFirstName'] . ' ' . $objPage->arrMessage[0]['CustomerLastName']; ?></span>
                                                    <div class="right_time_sec">
                                                        <img src="<?php echo IMAGES_URL ?>watch_icon.png" alt=""/>
                                                        <p><span><?php echo date('d M Y', strtotime($objPage->arrMessage[0]['SupportDateAdded'])); ?></span> <small><?php echo date('H:i a', strtotime($objPage->arrMessage[0]['SupportDateAdded'])); ?></small></p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <p class="labelP">Subject <strong>:</strong></p>
                                                    <p class="floatedMessage"><?php echo $objPage->arrMessage[0]['Subject'] ?></p>

                                                </li>
                                                <li>
                                                    <p class="labelP">Message <strong>:</strong></p>
                                                    <p class="floatedMessage"><?php echo $objPage->arrMessage[0]['Message'] ?></p>
                                                </li>
                                            </ul>
                                            <?php
                                            if (count($objPage->arrMessageThread) > 0)
                                            {
                                                foreach ($objPage->arrMessageThread as $varThread)
                                                {
                                                    ?>
                                                    <ul class="compose_right_inner">
                                                        <li class="first">
                                                            <p><?php echo $objPage->wsid == $varThread['fkFromID'] ? 'Replied To ' : 'Reply From ' ?><strong>:</strong></p>
                                                            <span><?php echo $objPage->arrMessage[0]['ToName'] ?></span>
                                                            <div class="right_time_sec">
                                                                <img src="common/images/watch_icon.png" alt=""/>
                                                                <p><span><?php echo date('d M Y', strtotime($varThread['ReplyDateAdded'])); ?></span> <small><?php echo date('H:i a', strtotime($varThread['ReplyDateAdded'])); ?></small></p>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <p>Subject <strong>:</strong></p>
                                                            <span><?php echo $varThread['ReplySubject'] ?></span>

                                                        </li>
                                                        <li>
                                                            <p>Message <strong>:</strong></p>
                                                            <span><?php echo $varThread['ReplyMessage'] ?></span>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                }
                                            }
                                            ?>
<!--                                            <a href="#reply_message" class="delete del_blue submit3" style="float:right" onclick="wholesalerReplyPopup('delete');">Reply</a>-->
                                        </div>
<?php }
else
{ ?>
    <?php echo '<br/>' . ADMIN_NO_RECORD_FOUND ?>
<?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div style="display: none;">
            <div id="reply_message" class="reply_message">
                <form name="reply_message_form" id="reply_message_form" method="POST" action="">
                    <div>
                        <div class="left_m"  style="width:91px"><label><?php echo TO; ?></label> :</div><div class="right_m"><?php echo $varTo; ?></div>
                    </div>
                    <div>
                        <div class="left_m"  style="width:91px"><label><?php echo SUBJECT; ?> <span style="color:red"> *</span></label>:</div><div class="right_m"><input value="<?php echo 'Re: ' . $objPage->arrMessage[0]['Subject'] ?>" class="validate[required]" style="width: 480px !important; " type="text" name="frmSubject" /></div>
                    </div>
                    <div>
                        <div class="left_m" style="width:91px"><label><?php echo MESSAGE; ?><span style="color:red"> *</span></label>:</div><div class="right_m"><textarea style="width: 96% ! important;" class="validate[required]" name="frmMessage" rows="9" cols="35"></textarea></div>
                    </div> 
                    <div class="left_m"  style="width:91px">&nbsp;</div>
                    <div class="right_m">
                        <input type="submit" name="submit" value="Send" class="submit3"  style=" float: left; width:130px; margin-right: 5px; line-height:40px;" />
                        <input type="button" name="cancel" class="cancel" value="Cancel" id="compose_cancel" /> 
                    </div>
                    <div class="left_m">&nbsp;</div>
                    <input type="hidden" name="frmMessageType" value="<?php echo $objPage->arrMessage[0]['SupportType'] ?>" />
                    <input type="hidden" name="frmToUserType" value="<?php echo $objPage->arrMessage[0]['FromUserType'] ?>" />
                    <input type="hidden" name="fkToUserID" value="<?php echo $objPage->arrMessage[0]['fkToUserID'] ?>" />
                    <input type="hidden" name="place" value="reply" />
                    <input type="hidden" name="thread" value="outbox" />
                    <input type="hidden" name="fkSupportID" value="<?php echo $objPage->arrMessage[0]['pkSupportID'] ?>" />
                </form>
            </div>
        </div>
<?php include_once 'common/inc/footer.inc.php'; ?>

    </body>
</html> 
