<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_SUPPORT_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MESSAGE_OUTBOX_TITLE;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.drop_down1').sSelect();
            });
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
                    <div class="top_container" style="padding-bottom: 18px;">
	 <div class="top_header border_bottom"><h1><?php echo SUPP;?></h1></div>
                    </div>

                    <div class="body_inner_bg main_outbox_sec"> <div class="">
                    
                   
                     <?php if ($objCore->displaySessMsg()) {
                        ?>
                       
                            <?php
                            echo $objCore->displaySessMsg();

                            $objCore->setSuccessMsg('');
                            $objCore->setErrorMsg('');
                            ?>
                          
                    <?php }
                    ?>

                </div>

                        <div class="add_edit_pakage compose_message">
                            <div class="compose_left_outer">
                                <ul class="compose_left">
                                    <li class="compose_box"><a href="<?php echo $objCore->getUrl('compose_message.php', array('place' => 'compose')); ?>"><?php echo COMPOSE;?></a></li><li class="inbox"><a href="<?php echo $objCore->getUrl('messages_inbox.php', array('place' => 'inbox')); ?>"><?php echo INBOX;?></a></li>
                                    <li class="compose_active"><a  style="  color: #56a1f2;" href="<?php echo $objCore->getUrl('outbox_messages.php', array('place' => 'outbox')); ?>"><?php echo OUTBOX;?><small><i class="fa fa-angle-right"></i></small></a></li>
                                    

                                </ul>
                            </div>
                            <div class="compose_right_outer">
                                <div class="compose_right scrollable" style="width:710px">
                                    <h2><?php echo OUTBOX;?></h2>
                                    
                                    <ul class="feebacks_sec">
                                        <li class="heading">
                                            <span class="customer"><?php echo TICK_ID;?></span>
                                            <span class="product"><?php echo SENDER;?></span>
                                            <span class="read"><?php echo SUBJECT;?></span>
                                            <span class="date"><?php echo TIME;?></span>
                                            <span class="action"><?php echo ACTION;?></span>
                                        </li>
                                        <?php
                                        $count = 0;
                                        $varPrevId=0;
                                        //pre($objPage->arrCustomerSupportList);
                                        if (count($objPage->arrCustomerSupportList) > 0) {
                                            foreach ($objPage->arrCustomerSupportList as $val) {
                                                $msgInbox ='';
                                                if($val['Subject'] !=''){
                                                    if(strlen($val['Subject']) > 60){
                                                        $msgInbox=substr($val['Subject'], 0, 60).'...';
                                                    }else{
                                                        $msgInbox=$val['Subject'];
                                                    }
                                                }        
						//$msgInbox = count($val['Subject'] > 60) ? strlen($val) > 60 ? substr($val['Subject'], 0, 60).'...' : $val['Subject'] : '';
                                                ?>
                                                <li class="<?php
                                        if ($count % 2 != 0) {
                                            echo "bg_color";
                                        }
                                        ?>">
                                                    <span class="customer"><?php echo ($val['fkParentID']<>$varPrevId)?$val['fkParentID']:'&nbsp;'; ?></span>
                                                    <?php
                                                    if ($val['CompanyName'] != "") {
                                                        $varRecipientName = $val['CompanyName'];
                                                    } else {
                                                        $varRecipientName = "admin";
                                                    }
                                                    ?>
                                                    <span class="product"><?php echo ucfirst($varRecipientName); ?></span>
                                                    <span class="read"><a title="<?php echo VIEW_MESSAGE;?>" href="<?php echo $objCore->getUrl('view_outbox_message.php', array('frmID' => $val['pkSupportID'], 'frmOutboxChangeAction' => 'view','myAction'=>'action')); ?>" style=" text-align:left;"><?php echo ucfirst($msgInbox); ?></a></span>
                                                    <span class="date"><?php echo $objCore->localDateTime(date($val['SupportDateAdded']), DATE_TIME_FORMAT_SITE_FRONT_MINUTES); ?></span>
                                                    <span class="action action2 action_icon">
                                                        <a title="<?php echo VIEW_MESSAGE;?>" href="<?php echo $objCore->getUrl('view_outbox_message.php', array('frmID' => $val['pkSupportID'], 'frmOutboxChangeAction' => 'view','myAction'=>'action')); ?>"><i class="fa fa-eye" style="font-size:16px;line-height: 35px;color: #6db61f;"></i></a>      
                                                        <a title="Delete" href="<?php echo $objCore->getUrl('message_action.php', array('frmID' => $val['pkSupportID'], 'frmChangeAction' => 'Delete')); ?>" onClick="return confirm('<?php echo WANT_DELETE;?>')"><i class="fa fa-trash-o" style="font-size: 16px; margin-left:10px;
                                                                                                                                                                                                                line-height: 35px;
                                                                                                                                                                                                                color: #7f7f7f;"></i></a>
                                                    </span>
                                                </li>
                                                <?php
                                                $count++;
                                                $varPrevId = $val['fkParentID'];
                                            }
                                        } else {
                                            echo '<li class="no_resutl_found">' . FRONT_CUSTOMER_SUPPORT_ERROR_MSG . '</li>';
                                        }
                                        ?>

                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
<?php include_once 'common/inc/footer.inc.php'; ?>


    </body>
</html>