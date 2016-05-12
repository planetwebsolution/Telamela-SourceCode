<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SUPPORT_ENQUIRY_CTRL;
//pre($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo ADMIN_PANEL_NAME; ?></title>
        <link href="<?php echo ADMIN_CSS; ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo VALIDATE_JS; ?>"></script>
        <script>var SITE_ROOT_URL = '<?php echo SITE_ROOT_URL; ?>';</script>
          <!--<script type="text/javascript" src="<?php // echo JS_PATH;    ?>jquery-1.3.2.min.js"></script>-->
        <link rel="stylesheet" href="css/colorbox.css" />
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script src="../colorbox/jquery.colorbox.js"></script>	
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "components/cal/calendar.js"; ?>"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "components/cal/lang/calendar-en.js"; ?>"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "components/cal/calendar-setup.js"; ?>"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "common/js/ajax_js.js"; ?>"></script>
        

    </head>
    <body>
        <div class="header"><!--header start-->
            <?php require_once 'inc/header.inc.php'; ?>
        </div><!--header end-->
        <div class="body_container"><!--body container start-->
            <div class="container_left">
                <div class="container_left_title">
                    <div class="content_title">
                        <div id="submenu"><!--submenu start-->
                            <ul>
                                <li><a class="current">Support Enquiries</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="container_left_content">
                    <?php require_once('javascript_disable_message.php'); ?>
                    
                        <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-cms', $_SESSION['sessAdminPerMission'])) { ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px;" >
                        <?php
                    if ($objCore->displaySessMsg()) {
                        ?>  
                            <tr><td colspan="2">&nbsp;</td></tr>
                            <tr>
                                <td colspan="2" valign="top" style="padding:8px 0 8px 0;border:#B4B4B4 4px solid; background-color:#F0F0F0;">
                                    <?php
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                    ?>	  </td>
                            </tr>
                            <tr><td colspan="2">&nbsp;</td></tr><?php
                            }
                                ?>
                    </table>
                    <table width="99%" border="0" cellspacing="0" cellpadding="0" style="float:left;" class="left_content">
                         <form id="frmUserEnquiryList" name="frmUserEnquiryList" action="support_enquiry_action.php" method="post">
                        <tr><td class="dashboard_title" colspan="8">User Enquiries</td></tr>
                         <?php
                            if ($objPage->NumberofRows>0) {?>
                         <tr class="heading">
                            <td>
                            <input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" />
                           </td>
                            <?php
                            echo $objPage->varSortColumn;
                            ?>
                            <td><strong>Action</strong></td>

                        </tr>
                                <?php
                                $i=1;

                            foreach ($objPage->arrRows as $val) {
                                ?>
                                <tr class="content">
                                    <td valign="top">
                                    <input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkSupportID']; ?>" onclick="singleSelectClick(this,'singleCheck');" class="singleCheck"/>
                                    </td> 
                                     <td><?php echo $val['FromUserType']; ?></td>
                                                    <td><?php echo $val[$val['FromUserType'] . 'Name']; ?></td>
                                                    <td><?php echo $val[$val['FromUserType'] . 'Email']; ?></td>
                                                    <td><?php echo $val[$val['FromUserType'] . 'Phone']; ?></td>
                                                    <td><?php echo $objCore->localDateTime($val['SupportDateAdded'], DATE_FORMAT_SITE); ?></td>
				    <td>
                                        <a href="support_enquiry_view_uil.php?id=<?php echo $val['pkSupportID']; ?>&type=edit"><img src="<?php echo SITE_ROOT_URL . 'admin/images/view.gif'; ?>" alt="View" title="View" /></a>
                                       <a class='delete' href="support_enquiry_action.php?frmID=<?php echo $val['pkSupportID']; ?>&frmChangeAction=Delete" onClick="return confirm('Are you sure you want to delete this enquiry ?')"><img src="<?php echo SITE_ROOT_URL . 'admin/images/cross.png'; ?>" alt="Delete" title="Delete" /></a>
                                       &nbsp;</td>
                                </tr>
                                    <?php $i++;
                                        }?>
                                            
                                            <?php 
                                    } else {
                                        ?>
                            <tr class="content">
                                <td colspan="10" style="text-align:center">
                                    <strong>No record(s) found.</strong>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php 
                    if (is_array($objPage->arrRows)) {
                        ?>
                        <table>
                            <tr><td colspan="10">&nbsp;</td></tr>
                             <tr>
                                                <td colspan="10">
                                                    <table width="100%">
                                                        <tr>
                                                            <td>
                                                                <select name="frmChangeAction" onchange="javascript: return setValidAction(this.value, this.form, 'Enquiries(s)');">
                                                                    <option value="">--Select Action--</option>
                                                                    <!-- <option value="Active">Activate</option>
                                                                    <option value="Inactive">Deactivate</option> -->
                                                                    <option value="Delete All">Delete</option>
                                                                </select>&nbsp;&nbsp;This action will be performed on the above selected record(s).
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                 </tr> 
                            <tr>

                                <td colspan="10">
                                    <table width="100%">
                                        <tr>
                                            <td style="font-weight:bold;" colspan="10">
                                                <?php
                                                if ($objPage->varNumberPages > 1) {
                                                    $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr></table><?php }
                                            ?>
                         </form>
                    <div >&nbsp;</div>
                    
                <?php     }else{?> 
                    <table width="100%">
                            <tr>
                                <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE;?></th></tr>
                                 <tr><td><?php echo ADMIN_USER_PERMISSION_MSG;?></td></tr>
                </table>
                                
<?php                             }
?>
                </div>
            </div>
        </div>
        <!--body container end-->
<script type="text/javascript">
<?php
if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
    ?>
            showSearchBox('search', 'show');<?php
} else {
    ?>
            showSearchBox('search', 'hide');<?php }
?>
        </script>
        <div id="footer"><!--footer start-->
            <?php require_once('inc/footer.inc.php'); ?>
        </div><!--footer end-->
        
    </body>
</html>