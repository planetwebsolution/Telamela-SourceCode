<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_SUPPORT_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MESSAGE_OUTBOX_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){ 
                $('.drop_down1').sSelect();
            });
        </script>
        <style>.compose_message .compose_right{ width:697px;}</style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"></div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>


        <div id="ouderContainer" class="ouderContainer_1"><div class="wholesalerHeaderSection" style="width:100%; height:50px; padding-top:16px;	  border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">
                <div class="" style="border-top:none">

                    <?php
                    if ($objCore->displaySessMsg())
                    {

                        echo $objCore->displaySessMsg();
                        $objCore->setSuccessMsg('');
                        $objCore->setErrorMsg('');
                    }
                    ?>
                </div>

                <div class="add_pakage_outer">
                    <div class="top_container" style="padding-bottom: 18px;">


                    </div>

                    <div class="body_inner_bg main_outbox_sec">
                        <div class="add_edit_pakage compose_message">
                            <div class="compose_left_outer">
                                <ul class="compose_left">
                                    <li class="compose_box"><a href="<?php echo $objCore->getUrl('wholesaler_compose_message.php', array('place' => 'compose')); ?>"><?php echo COMPOSE; ?></a></li>
                                    <li class="compose_box"><a href="<?php echo $objCore->getUrl('wholesaler_messages_inbox.php', array('place' => 'inbox')); ?>"><?php echo INBOX; ?> </a></li>
                                    <li class="compose_active"><a  style="color:#56a1f2"  href="<?php echo $objCore->getUrl('wholesaler_outbox_messages.php', array('place' => 'outbox')); ?>"><?php echo OUTBOX; ?></a><small><img src="common/images/ref_icon.png" alt="" style="margin-top:4px;position: absolute;
                                                                                                                                                                                                        "/></small></li>

                                </ul>
                            </div>
                            <div id="compose_right_section" class="compose_right_outer">
                                <div class="compose_right scrollable">
                                    <ul class="feebacks_sec ">
                                        <li class="heading">
                                            <span class="customer"><?php echo TICK_ID; ?></span>
                                            <span class="product"><?php echo SENDER; ?></span>
                                            <span class="read"><?php echo SUBJECT; ?></span>
                                            <span class="date"><?php echo TIME; ?></span>
                                            <span class="action"><?php echo ACTION; ?></span>
                                        </li>
                                        <?php
                                        if (count($objPage->arrOutbox) > 0)
                                        {
                                            $varcounter = 0;
                                            $varPrevId = 0;
                                            foreach ($objPage->arrOutbox as $var)
                                            {
                                                //$msgInbox = count($var['Subject'] > 70) ? substr($var['Subject'], 0, 70).'...' : '';
                                                $msgInbox = count($var['Subject'] > 60) ? strlen($var['Subject']) > 60 ? substr($var['Subject'], 0, 60).'...' : $var['Subject'] : '';
                                                $varcounter++;
                                                ?>
                                                <li <?php echo $varcounter % 2 == 0 ? 'class="bg_color"' : '' ?> >
                                                    <span class="customer"><?php echo ($var['fkParentID'] <> $varPrevId) ? $var['fkParentID'] : $var['fkParentID'] . '&nbsp;'; ?></span>
                                                    <span class="product"><?php echo ($var['ToUserType'] == 'admin') ? 'Admin' : $var['ToName']; ?></span>
                                                    <span class="read"><a href="<?php echo $objCore->getUrl('read_outbox_message.php', array('place' => 'readOutbox', 'mgsid' => $var['pkSupportID'])); ?>"><?php echo $msgInbox; ?></a> </span>
                                                    <span class="date"><?php echo $objCore->localDateTime(date($var['SupportDateAdded']), DATE_TIME_FORMAT_SITE_FRONT_MINUTES); ?></span>
                                                    <span class="action action2">
                                                        <a title="Click to view message" href="<?php echo $objCore->getUrl('read_outbox_message.php', array('place' => 'readOutbox', 'mgsid' => $var['pkSupportID'])); ?>">
                                                            <i class="fa fa-eye" style="font-size:16px;line-height: 35px;color: #6db61f;"></i></a>
                                                        <a  href="<?php echo $objCore->getUrl('read_inbox_message.php', array('place' => 'outbox', 'action' => 'delete', 'mgsid' => $var['pkSupportID'])); ?>" onclick="return confirm('<?php echo WANT_DELETE; ?>')">
                                                            <i class="fa fa-trash-o" style="font-size: 16px; margin-left:10px;line-height: 35px;color: #7f7f7f;"></i></a>
                                                </li>
                                                <?php
                                                $varPrevId = $var['fkParentID'];
                                            }
                                        }
                                        else
                                        {
                                            echo '<li class="no_resutl_found">' . FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG4 . '</li>';
                                        }
                                        ?>
                                    </ul>

                                </div>

                                <?php
                                if (count($objPage->arrOutbox) > 0)
                                {
                                    ?>
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
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html> 
