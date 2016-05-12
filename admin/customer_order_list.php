<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CUSTOMER_CTRL;
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
        <link rel="stylesheet" href="css/colorbox.css" />
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script src="../colorbox/jquery.colorbox.js"></script>        
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "common/js/ajax_js.js"; ?>"></script>
        <script>
            $(document).ready(function(){
                $('#cancelWarn').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            });
            function jscall(emailid,id){
                $(".warning").colorbox({inline:true, width:"500px", height:"290px"});
                $('#cancelWarn').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            
                $('#frmConfirmWarning').click(function(){
                   
                    var WarningMsg = document.getElementById('WarningMsg');
                    if(WarningMsg.value==''){                        
                        alert('Message is Required!');
                        WarningMsg.focus();
                        return false;
                    }else{ 
                        $('#listed_Warning').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SendWarningToWholesaler',msg:WarningMsg.value,emailid:emailid,id:id},
                        function(data)
                        { 
                             //$('#listed_Warning').html(data);
                            $('#listed_Warning').html('<span class="green">Warning Sent Successfully </span>');
                            setTimeout(function a(){parent.jQuery.fn.colorbox.close();location.reload();}, 1500);
                                
                        }
                    );                    
                    }
                }); 
            }            
        </script>
    
        <script>
            function changeStatus(status,emailid,id){
                
                $.post("ajax.php",{action:'customerChangeStatus',status:status,emailid:emailid,id:id},
                
                function(data)
                {
                    //$('#criA'+id).html(data); 
                    location.reload();
                         
                }
            );
              
            }          
        </script>
        
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
                                <li><a class="current">Customer</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="container_left_content">
                    <?php require_once('javascript_disable_message.php'); ?>

                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('orderList_customer', $_SESSION['sessAdminPerMission'])) { ?>
                      <table width="99%" border="0" cellspacing="0" cellpadding="0" style="float:left;" class="left_content">
                            <tr><td class="dashboard_title" colspan="11">Order List</td></tr>
                            <?php  if ($objPage->NumberofRows > 0) { ?>
                            <tr class="heading">

                                    <td style="text-align:center;">Order ID #</td>
                                    <td style="text-align:center;">Product Name</td>
                                    <td style="text-align:center;">Wholesaler</td>
                                    <td style="text-align:center;">Date</td>
                                    <td style="text-align:center;">Price</td>
                                    <td style="text-align:center;">Status</td>
                                    <td style="text-align:center;">Actions</td>  
                                  </tr>
                              <?php
       
                                 foreach ($objPage->arrRows as $val) { ?>
                                    <tr class="content">
                                        <td style="text-align:center;"><?php echo $val['pkOrderID']; ?></td>                                    
                                        <td style="text-align: center;"><?php echo $val['ProductName']; ?></td>
                                        <td style="text-align: center;"><?php echo $val['CompanyName']; ?></td>
                                        <td style="text-align: center;"><?php echo $objCore->localDateTime($val['OrderDateAdded'],DATE_FORMAT_SITE); ?></td>
                                        <td style="text-align: center;"><?php echo $val['TotalPrice']; ?></td>
                                        <td style="text-align: center;">
                                           <select onchange="changeStatus(this.value,'',<?php echo $val['pkOrderID'];?>);">
                                                <option value="Posted" <?php
                                            if ($val['OrderStatus'] == 'Posted') {
                                                echo 'selected';
                                            }
                                            ?>>Posted</option>
                                                <option value="Pending" <?php
                                            if ($val['CustomerStatus'] == 'Pending') {
                                                echo 'selected';
                                            } ?>>Pending</option>
            ?>>Deactive</option>
                                         </select>
                                        </td>
                                        <td style="text-align: center;">
                                         <a href="customer_view_order_details.php?orderId=<?php echo $val['pkOrderID']; ?>&cusId=<?php echo $GET['id']; ?>">View Order Details</a>
                                       </td>
                                        
                                    </tr>
            <?php
        }
    } else {
        ?>
                                <tr class="content">
                                    <td colspan="7" style="text-align:center">
                                        <strong>No record(s) found.</strong>
                                    </td>
                                </tr>
    <?php } ?>
                        </table>
    <?php
    if (is_array($objPage->arrRows)) {
        ?>
                            <table>
                                <tr><td colspan="7">&nbsp;</td></tr>
                                <tr>

                                    <td colspan="7">
                                        <table width="100%">
                                            <tr>
                                                <td style="font-weight:bold;" colspan="6">
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

                        <div >&nbsp;</div>

<?php } else { ?> 
                        <table width="100%">
                            <tr>
                                <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                            <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                        </table>

<?php }
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

        <div style='display:none'>
            <div id='listed_Warning'>
                <table id="colorBox_table">
                    <tr align="left">
                        <td style="font-family: Arial,Helvetica,sans-serif; font: 12px;">Write Message:</td>
                    </tr>
                    <tr>
                        <td align="left"><textarea name="WarningMsg" id="WarningMsg" rows="8" class="input4"></textarea></td>
                    </tr>
                    <tr>
                        <td align="left"><input type="submit" name="frmConfirmWarning" id="frmConfirmWarning" value="Send Message" style="cursor: pointer;"/>
                            &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelWarn" value="cancel" style="cursor: pointer;"/> </td>
                    </tr>

                </table>

            </div>
        </div>
        <div style='display:none'>
            <div id='listed_Suspend'>
                <table id="colorBox_table">

                    <tr align="left">
                        <td style="font-size:18px; font-weight: bold;">Do you wish to suspend this Wholesaler?</td>
                    </tr>

                    <tr align="left">
                        <td style="font-family: Arial,Helvetica,sans-serif; font:12px;">Write Message:</td>
                    </tr>
                    <tr>
                        <td align="left"><textarea name="SuspendMsg" id="SuspendMsg" rows="4" class="input4"></textarea></td>
                    </tr>
                    <tr>
                        <td align="left">
                            <input type="submit" name="frmConfirmSuspend" id="frmConfirmSuspend" value="Suspend" style="cursor: pointer;"/>
                            &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelSus" value="Ignore" style="cursor: pointer;"/> </td>
                    </tr>

                </table>

            </div>
        </div>

    </body>
</html>
