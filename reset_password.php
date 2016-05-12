<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_RESET_PASSWORD_CTRL;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Reset Password</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>	   
        <script type="text/javascript">        
            $(document).ready(function(){ 
                $("#frmCustomerRegistration").validationEngine();
                $('.drop_down1').sSelect();
                $('.cancel1').click(function(){
                    window.location.href = "<?php echo SITE_ROOT_URL ?>";		    
                });
            });
        </script>
		<style>. text-input{  	border: 1px solid #d2d2d2;
    color: #535353;
    font-size: 12px;
    font-weight: 300;
    height: 28px;
    padding: 5px;
    width: 398px;}
	
	.btn{   clear: both;
display: block;
width: 310px;
margin: 30px auto;}
	
	</style>
    </head>
    <body>       
         <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header"><div class="layout">
               
        </div>
       </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
               
                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
    <h1>Reset My Password</h1>
   
</div>                       <div class="body_inner_bg radius">
                        <div class="add_edit_pakage aapplication_form">
                            <form name="frmCustomerRegistration" id="frmCustomerRegistration" method="post" action="">                    
                                <div class="com_address_sec edit_acc">
                                    <small class="req_field" style="float:left !important;">* Fields are required </small>
                                    <?php if ($objCore->displaySessMsg()) {
                                        ?>  
                                        <div class="req_field" style="text-align:center; width: 1000px;float:left !important">
                                            <?php
                                            echo $objCore->displaySessMsg();

                                            $objCore->setSuccessMsg('');
                                            $objCore->setErrorMsg('');
                                            ?>
                                        </div>
                                    <?php }
                                    ?>
                                    <ul class="left_sec" style="margin-bottom:30px;">
                                        <li>
                                            <label style="width:100%">New Password:</label>
                                            <div class="input_star">
                                                <input tabindex="5" type="password" value="" name="frmNewCustomerPassword" id="frmNewCustomerPassword"  class="validate[required,minSize[6]] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                              <label style="width:100%">Confirm New Password:</label>
                                            <div class="input_star">
                                                <input tabindex="5" type="password" value="" name="frmConfirmNewCustomerPassword" id="frmConfirmNewCustomerPassword"  class="validate[required,equals[frmNewCustomerPassword],minSize[6]] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>

                                    <span class="btn" style="margin-top:20px;">
                                        <input type="submit"  name="frmHidenCustomerPasswordEdit" value="Update" class="update_btn1"/>     
                                        <input class="cancel1 update_btn1" value="Cancel" type="reset" name="frmCancel"/>
                                    </span>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html> 
