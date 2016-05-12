<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CUSTOMER_SUPPORT_ENQUIRY_CTRL;
$rowsNum = count($objPage->arrRow);
//pre($objPage->arrRow);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Apple devices fullscreen -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Apple devices fullscreen -->
        <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <title><?php echo ADMIN_PANEL_NAME; ?> : Customer support</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>        
    </head>
    <script>
        $(document).ready(function () {
            $('#cancelSus').click(function () {
                parent.jQuery.fn.colorbox.close();
                return false;
            });
        });
        function jscall1() {
            $('#modal-1').show();
            //$(".suspend").colorbox({inline:true, width:"750px", height:"500px"});
            $('#cancelSus').click(function () {
                parent.jQuery.fn.colorbox.close();
            });

            $('#frmConfirmSend').click(function () {

                var frmSubject = $('#frmSubject').val();
                var ComposeMsg = $('#ComposeMsg').val();
                if (frmSubject == '')
                {
                    alert('Subject is Required!');
                    $('#frmSubject').focus();
                    return false;
                }
                if (ComposeMsg.trim() == '')
                {
                    alert('Message is Required!');
                    $('#ComposeMsg').focus();
                    return false;
                }

                else
                {
                    location.reload();
                }
            });
        }
        function popupClose1() {

            $('#modal-1').hide();
            return false;

        }

    </script>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Support Enquiries</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="customer_support_enquiry_manage_uil.php">Customer Support</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="customer_support_enquiry_manage_uil.php">Inbox</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
<!--                                <a href="customer_support_enquiry_view_uil.php?id=<?php echo $_GET['id']; ?>&type=edit">View</a>-->
                                <span>View</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="tab-pane active" id="tabs-2">

                                <div class="row-fluid">

                                    <div class="span12">

                                        <div class="box box-color box-bordered">                                            

                                            <div class="box-title">
                                                <a id="buttonDecoration" href="<?php echo SITE_ROOT_URL; ?>admin/customer_support_enquiry_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                                <a class="suspend btn pull-right" href="#modal-1" onclick="return jscall1()" style="margin-right: 10px;"><?php echo ADMIN_REPLY_BUTTON; ?></a>
                                                <h3>
                                                    View Support Enquiries
                                                </h3>
                                            </div>
                                            <div class="box-content nopadding">

                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('reply-customer-support', $_SESSION['sessAdminPerMission'])) {
                                                    ?>

                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <tbody>
                                                            <?php
//                                                            pre($objPage->arrRow);
                                                            if ($rowsNum > 0) {
                                                                foreach ($objPage->arrRow as $valRows) {
                                                                    /* echo '<pre>';
                                                                      print_r($valRows);
                                                                      echo '</pre>';
                                                                      die; */
                                                                    ?>
                                                                    <tr class="content">
                                                                        <td>
                                                                            <table cellpadding="0" cellspacing="0" border="0" class="left_content" style="width:100%;" >
                                                                                <tr>
                                                                                    <td valign="top" style="width:30%;"><strong>Sender:</strong> </td>
                                                                                    <td><?php echo $valRows['customerName']; ?></td>
                                                                                    <!-- Added by Krishna Gupta starts -->
                                                                                    <td><strong>Date : </strong></td>
                                                                                    <!-- Added by Krishna Gupta ends -->
                                                                                    <td><?php echo $objCore->localDateTime($objPage->arrRow[0]['SupportDateAdded'], DATE_TIME_FORMAT_SITE); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td valign="top" style="width:30%;"><strong>Support Type:</strong> </td>
                                                                                    <td colspan=""><?php echo $valRows['SupportType']; ?></td>
                                                                                    <td colspan=""><strong>Ticket ID</strong></td>
                                                                                    <td colspan=""><?php echo $valRows['fkParentID']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td valign="top" style="width:30%;"><strong>Subject:</strong> </td>
                                                                                    <td colspan="2"><?php echo $valRows['Subject']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td valign="top" style="width:30%;"><strong>Message:</strong> </td>
                                                                                    <td colspan="2"><?php echo $valRows['Message']; ?></td>
                                                                                </tr>
                                                                            </table>

                                                                        </td>
                                                                    </tr>
        <?php } ?>
                                                                <tr class="content">
                                                                    <td style="text-align:center;">
                                                                        <a class="suspend btn btn-blue" href="#modal-1" style="text-decoration:none;" onclick="return jscall1()" ><?php echo ADMIN_REPLY_BUTTON; ?></a>
                                                                    </td>
                                                                </tr>
    <?php
    } else {
        ?>
                                                                <tr class="content">
                                                                    <td style="text-align:center;">
        <?php echo ADMIN_NO_RECORD_FOUND; ?>

                                                                    </td>
                                                                </tr>
    <?php } ?>
                                                        </tbody>


                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<?php
} else {
    ?>
                        <table width="100%">
                            <tr>
                                <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                            <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                        </table>

<?php }
?>


                </div>
            </div>


<?php require_once('inc/footer.inc.php'); ?>
        </div>





        <!-- old code -->





        <!--body container end-->

        <!--        <div id="footer">footer start
<?php //require_once('inc/footer.inc.php');    ?>
                </div>footer end-->


        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">

            <form action=""  method="post" id="frm_page" enctype="multipart/form-data" >

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1()">X</button>
                    <h3 id="myModalLabel">Reply</h3>
                </div>
                <div class="modal-body" style="padding-left:42px;padding-right:10px;">
                    <div class="rowlbinp">
                        <div class="lbl"><strong>To : </strong>   <?php echo $objPage->arrRow[0]['customerEmail']; ?></div>
                    </div>
                    <div class="rowlbinp">
                        <div class="lbl"><strong>Subject : </strong> <input type="text" size="50" name="frmSubject" id="frmSubject" value="Re: <?php echo $objPage->arrRow[0]['Subject']; ?>"></div>
                    </div>
                    <div class="rowlbinp">
                        <div class="lbl"><strong>*Write Message:</strong></div><div class="inpt"><textarea name="frmMessage" id="ComposeMsg" rows="10" class="input-block-level"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer">
                    &nbsp;&nbsp; <input type="submit" name="frmConfirmSend" id="frmConfirmSend"  value="Send" class="messReplyBtn btn btn-blue"/>
                    &nbsp;&nbsp;<input type="button" name="cancel" id="cancelSus" value="Cancel"  class="messReplyBtn btn" onclick="popupClose1()" />
                    <input type="hidden" name="frmHidenAdd" value="reply" />
                    <input id="frmType" name="fkToUserID" type="hidden" value="<?php echo $objPage->arrRow[0]['fkFromUserID']; ?>"/>
                    <input id="frmType" name="fkSupportID" type="hidden" value="<?php echo $objPage->arrRow[0]['pkSupportID']; ?>"/>
                    <input id="frmToUserType" name="frmToUserType" type="hidden" value="customer"/>
                    <input id="frmSupportType" name="frmSupportType" type="hidden" value="<?php echo $objPage->arrRow[0]['SupportType']; ?>"/>
                    <input type="hidden" name="fkParentID" value="<?php echo $objPage->arrRow[0]['fkParentID'] ?>" />

                </div>
            </form>

        </div>



    </body>
</html>