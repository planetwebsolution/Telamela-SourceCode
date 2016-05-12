<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_SUPPORT_CTRL;
$objCore = new Core();
require_once CLASSES_PATH .'class_customer_user_bll.php';
require_once CLASSES_PATH .'class_wholesaler_bll.php';
$cus=new Customer();
$who=new Wholesaler();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>View Outbox Message</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.drop_down1').sSelect();
            });
        </script>
        <style>p{margin:0 18px 0 0 !important;} 
		.compose_sec{ width:989px; padding:13px; }
	.compose_right .back span{ color: #fff;
padding: 10px 20px 20px 30px; background-position: 1px 11px
}
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
                                  <li class="compose_box"><a href="<?php echo $objCore->getUrl('compose_message.php', array('place' => 'compose')); ?>">Compose Mail</a></li><li class="inbox"><a href="<?php echo $objCore->getUrl('messages_inbox.php', array('place' => 'inbox')); ?>">Inbox</a></li>
                                <li class="compose_active"><a  style="  color: #56a1f2;" href="<?php echo $objCore->getUrl('outbox_messages.php', array('place' => 'outbox')); ?>">Outbox<small style="margin-top:3px;" ><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>ref_icon.png" alt=""/></small></a></li>
                              

                            </ul>
                        </div>
                        <div class="compose_right_outer">
                            <div class="compose_right">
                                <h2>View Outbox Message<a href="<?php echo $objCore->getUrl('outbox_messages.php', array('place' => 'outbox')); ?>" class="back"><span>Back</span></a></h2>
                                <?php 
                                //pre($objPage->arrOutboxMessageView);
                                
                                foreach($objPage->arrOutboxMessageView as $varOutboxMessage) {
                                            
                                         if ($varOutboxMessage['ToUserType'] == "wholesaler") {
                                                $sender ='Recipient';
                                                $varRecipientName = $varOutboxMessage['CompanyName'];
                                            }else if ($varOutboxMessage['ToUserType'] == "customer") {
                                                $sender ='Sender';
                                                $getSenderDetails=$who->WholesalerDetails($varOutboxMessage['fkFromUserID']);
                                               // pre($getSenderDetails);
                                                $varRecipientName=isset($getSenderDetails) && count($getSenderDetails)>0?$getSenderDetails['CompanyName']:'';
                                            }
                                            else {
                                                $sender ='Recipient';
                                                $varRecipientName = "admin";
                                            }
                                    
                                    //echo $varRecipientName;
                                    ?>
                                <ul class="compose_right_inner">
                                    <li class="first">
                                        <p><?php echo $sender;?> <strong>:</strong></p>
                                        <span> <?php echo ucwords($varRecipientName); ?></span>
                                        <div class="right_time_sec">
                                            <img src="<?php echo IMAGE_FRONT_PATH_URL; ?>watch_icon.png" alt=""/>
                                            <p>&nbsp;</p>
                                            <p><?php echo $objCore->localDateTimeSite($varOutboxMessage['SupportDateAdded'], DATE_TIME_FORMAT_SITE_FRONT); ?></p>
                                        </div>
                                    </li>
                                    <li>
                                        <p>Subject <strong>:</strong></p>
                                        <span> <?php echo $varOutboxMessage['Subject']; ?></span>

                                    </li>
                                    <li>
                                        <p>Message <strong>:</strong></p>
                                        <span><?php echo $varOutboxMessage['Message']; ?></span>
                                    </li>
                                </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>