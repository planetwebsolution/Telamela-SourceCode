<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_USER_ENQUIRY_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : View Enquiry</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />

        <script src="../colorbox/jquery.colorbox.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />

        <script>
            $(document).ready(function(){
                $('#cancelSus').click(function(){
                    parent.jQuery.fn.colorbox.close();
                    return false;
                });
            });
            function jscall1(){
                $('#modal-1').show();
                //$(".suspend").colorbox({inline:true, width:"750px", height:"500px"});
                $('#cancelSus').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmSend').click(function(){

                    var ComposeMsg = $('#ComposeMsg').val();
                    //alert($('#ComposeMsg').val());
                    //if(ComposeMsg=='')
                    //{
                    //    alert('Message is Required!');
                    //    $('#ComposeMsg').focus();
                    //    return false;
                    //}

                    //else
                    //{
                        location.reload();
                    //}
                });
            }
            function popupClose(){

                $('#modal-1').hide();

            }
        </script>
    </head>
    <body>
        <!--header start-->
        <?php require_once 'inc/header_new.inc.php'; ?>
        <!--header end-->

        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>View Enquiries</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="dashboard_uil.php">Recent Enquiries</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
<!--                                <a href="user_enquiry_view_uil.php?id=<?php echo $_GET['id']; ?>&type=view">View Enquiries</a>-->
                                <span>View Enquiries</span>
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
                                                <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn" style="float:right;"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                                <!--<a class="suspend cboxElement btn" href="#listed_Suspend" onclick="return jscall1()" style="float:right; margin-right:5px;"><?php echo ADMIN_REPLY_BUTTON; ?></a>-->
                                                <h3>
                                                    View Enquiry Details
                                                </h3>
                                            </div>
                                            <div class="box-content nopadding">

                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('reply-user-enquiries', $_SESSION['sessAdminPerMission']))
                                                { //pre($objPage->arrRow);?>
                                                    <form action=""  method="post" id="frm_page" onsubmit="return validateProductAddForm(this);" enctype="multipart/form-data" >
                                                        <table class="table table-hover table-nomargin table-bordered usertable">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Sender: </td>
                                                                    <td><?php echo $objPage->arrRow[0]['fkParentID']!=0?'Admin':$objPage->arrRow[0]['EnquirySenderName']; ?>	</td>
                                                                    <td><?php echo $objCore->localDateTime($objPage->arrRow[0]['EnquiryDateAdded'], DATE_FORMAT_SITE); ?></td>


                                                                </tr>
                                                                <tr>
                                                                    <td>Email: </td>
                                                                    <td colspan="2">
    <?php echo $objPage->arrRow[0]['EnquirySenderEmail']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mobile Number: </td>
                                                                    <td colspan="2">
    <?php echo $objPage->arrRow[0]['EnquirySenderMobile']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subject: </td>
                                                                    <td colspan="2">
    <?php echo $objPage->arrRow[0]['EnquirySubject']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Message: </td>
                                                                    <td colspan="2">
    <?php echo $objPage->arrRow[0]['EnquiryComment']; ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                            <?php
                                                            if (count($objPage->arrReply) > 0)
                                                            {
                                                                foreach ($objPage->arrReply as $valReply)
                                                                {
                                                                    ?>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td colspan="3">Replied: </td>

                                                                        </tr>
                                                                        <tr>
                                                                            <td>Subject: </td>
                                                                            <td><?php echo $valReply['EnquirySubject']; ?>	</td>
                                                                            <td><?php echo $objCore->localDateTime($valReply['EnquiryDateAdded'], DATE_FORMAT_SITE); ?></td>


                                                                        </tr>
                                                                        <tr>
                                                                            <td>Message: </td>
                                                                            <td colspan="2">
            <?php echo $valReply['EnquiryComment']; ?>
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <tbody>
                                                                <tr>
                                                                    <td>&nbsp; </td>
                                                                    <td>
                                                                        <a class="suspend cboxElement" href="#modal-1" style="text-decoration:none;" onclick="return jscall1()">
                                                                            <input type="button" class="btn btn-blue" name="btnPage" value="<?php echo ADMIN_REPLY_BUTTON; ?>" style="margin:5px 15px 0 0; width:80px;"/>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<?php }
else
{ ?>
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


        <!--body container end-->

        <!--        <div id="footer">footer start
<?php //require_once('inc/footer.inc.php');   ?>
                </div>footer end-->

        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
            <form action=""  method="post" id="frm_page" enctype="multipart/form-data" >

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose()">X</button>
                    <h3 id="myModalLabel">Reply</h3>
                </div>
                <div class="modal-body" style="padding-left:42px;padding-right:10px;">
                    <div class="rowlbinp">
                        <div class="lbl"><strong>To : </strong>   <?php echo $objPage->arrRow[0]['EnquirySenderEmail']; ?></div>
                    </div>
                    <div class="rowlbinp">
                        <div class="lbl"><strong>Subject : </strong> <?php echo $objPage->arrRow[0]['EnquirySubject']; ?></div>
                    </div>
                    <div class="rowlbinp">
                        <div class="lbl"><strong>*Write Message:</strong></div><div class="inpt"><textarea class="ckeditor" name="frmMessage" id="ComposeMsg" rows="15" cols="5" style="width:600px"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    <button class="btn btn-primary" data-dismiss="modal">Save changes</button>-->


                    <input type="submit" name="frmConfirmSend" id="frmConfirmSend"  value="Send" class="messReplyBtn btn"/>
                    &nbsp;&nbsp;<input type="button" name="cancel" id="cancelSus" value="Cancel"  class="messReplyBtn btn" onclick="popupClose()"/>
                    <input type="hidden" name="frmHidenAdd" value="<?php echo ADMIN_REPLY_BUTTON; ?>" />
                    <input id="frmType" name="frmToUserEmail" type="hidden" value="<?php echo $objPage->arrRow[0]['EnquirySenderEmail']; ?>"/>
                    <input id="frmType" name="frmToUserName" type="hidden" value="<?php echo $objPage->arrRow[0]['EnquirySenderName']; ?>"/>
                    <input id="frmSupportType" name="frmEnquirySenderMobile" type="hidden" value="<?php echo $objPage->arrRow[0]['EnquirySenderMobile']; ?>"/>
                    <input type="hidden" name="frmfkParentID" value="<?php echo $objPage->arrRow[0]['pkEnquiryID']; ?>" />
                    <input type="hidden" name="frmSubject" value="<?php echo $objPage->arrRow[0]['EnquirySubject']; ?>" />
                </div>
            </form>

        </div>

    </body>
</html>