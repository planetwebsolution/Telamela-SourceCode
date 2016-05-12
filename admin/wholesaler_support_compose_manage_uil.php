<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_SUPPORT_ENQUIRY_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Wholesaler support</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />

        <script src="../colorbox/jquery.colorbox.js"></script>	
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            function showType(str){
                if(str=="wholesaler")
                {
          
                    $('.showCustomerEmail').css('display','none');
                    $('.showWholesalerList').css('display','block'); 
                }
                else
                {
         
                    $('.showCustomerEmail').css('display','block');
                    $('.showWholesalerList').css('display','none'); 
                }
            } 
        </script>

    </head>    
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1> Wholesaler Support Compose</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="wholesaler_support_enquiry_manage_uil.php">Wholesaler Support</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <span> Wholesaler Support Compose</span>
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
                                                            <h3> Wholesaler Support Compose</h3>                                                            
                                                        </div>
                                                        <div class="box-content nopadding">
                                                            <?php require_once('javascript_disable_message.php'); ?>
                                                            <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('reply-customer-support', $_SESSION['sessAdminPerMission'])) { ?>		

                                                            <form action=""  method="post" id="frm_page" onsubmit="return validateWholesalerCompose();" >
                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*To:</label>
                                                                            <div class="controls">
                                                                                <select name="frmWholesaler" id="frmWholesaler" class='select2-me input-large'>
                                                                                    <option value="">Select Wholesaler</option>

                                                                                    <?php
                                                                                    foreach ($objPage->varWholesalerList as $valWholesalerList) {
                                                                                    ?>
                                                                                    <option value="<?php echo $valWholesalerList['pkWholesalerID']; ?>" <?php
                                                                                    if ($valWholesalerList['pkWholesalerID'] == $_GET['id']) {
                                                                                    echo 'selected="selected"';
                                                                                    };
                                                                                    ?>><?php echo $valWholesalerList['CompanyName']; ?></option>
<?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*Type: </label>
                                                                            <div class="controls">
                                                                                <select name="frmSupportType" name="frmSupportType" class='select2-me input-large'>
                                                                                    <?php
                                                                                    foreach ($objPage->arrMessageType as $var) {
                                                                                    echo '<option value="' . $var['TicketTitle'] . '">' . $var['TicketTitle'] . '</option>';
                                                                                    }
                                                                                    ?>                                                              </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*Subject:</label>
                                                                            <div class="controls">
                                                                                <input type="text" name="frmSubject" id="frmSubject" value="" class="input-large">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        <div class="control-group">
                                                                            <label for="" class="control-label">*Message:</label>
                                                                            <div class="controls">
                                                                                <textarea name="frmMessage" id="frmMessage" class="input-block-level" id="textarea" rows="4"></textarea>
                                                                            </div>  
                                                                        </div>
                                                                        <div class="note">Note : * Indicates mandatory fields.</div>

                                                                        <div class="form-actions">                        
                                                                            <input type="hidden" name="frmHidenAdd" value="message" />
                                                                            <button name="frmBtnSubmit" type="submit" class="btn btn-blue" style="width:80px;"  value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>  
                                                                            <a id="buttonDecoration" href="wholesaler_support_enquiry_manage_uil.php"><button name="frmCancel" type="button" value="Cancel" style="width:80px;"  class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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


<?php require_once('inc/footer.inc.php'); ?>
        </div>


    </body>
</html>