<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_SUPPORT_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MESSAGE_COMPOSE_TITLE;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#compose_message").validationEngine();
            
                $('.drop_down1').sSelect();
                
                $('#frmHidenAdd').click(function(){                    
                    
                    $(this).hide();
                    $('#frmHidenAdd2').show();
                    
                    setTimeout(function(){
                        $('#frmHidenAdd').show();
                        $('#frmHidenAdd2').hide();
                        
                    }, 2000);
                });
                
                $('.drop_down1').change(function(){
                    var type = $(this).val();
                    if(type=='admin'){
                        $('#frmMessageTo').removeClass();
                        $(this).parent().parent().find('.frmMessageToformError').remove();
                    }else{
                        $('#frmMessageTo').addClass('validate[required,custom[email]]');
                    }
                });
            });
            function ShowAllAdmin(str){
                   
                if(str=='admin'){
                    document.getElementById("frmMessageTo").style.display="none";
                }else{
                    document.getElementById("frmMessageTo").style.display="Block";
                }
            }
        </script>
		<style>
.stylish-select .drop4 .selectedTxt{ line-height:35px !important }
.stylish-select ul.newList *{ line-height:14px !important}
</style>
    </head>
    <body>
          <em> <div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
    
        </em>
       <div class="header" style="border-bottom:none"><div class="layout"></div>
               <?php include_once INC_PATH . 'header.inc.php'; ?>
        
       </div>
      
          
        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%;height:50px; padding-top:16px;border-bottom:1px solid #e7e7e7;" class="wholesalerHeaderSection"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">
             
                    
            
           
                <div class="add_pakage_outer">
                    <div class="top_container" style="padding-bottom: 18px;">

                      
                    </div>
                  
                     <div class="body_inner_bg main_outbox_sec">
                        <div class="add_edit_pakage compose_message">
                            <form id="compose_message" name="compose_message" action="" method="POST" onSubmit="return validateFormSUpport()">
                                <div class="compose_left_outer">
                                  <ul class="compose_left">
								  <li  class="compose_active"><a style=" color: #56a1f2;"  href="<?php echo $objCore->getUrl('wholesaler_compose_message.php', array('place' => 'compose')); ?>"><?php echo COMPOSE; ?><small><i class="fa fa-angle-right"></i></small></a></li>
                                    <li class="inbox"><a href="<?php echo $objCore->getUrl('wholesaler_messages_inbox.php', array('place' => 'inbox')); ?>"><?php echo INBOX; ?></a></li>
                                    <li class="outbox"><a href="<?php echo $objCore->getUrl('wholesaler_outbox_messages.php', array('place' => 'outbox')); ?>"><?php echo OUTBOX; ?></a></li>
                                  
                                </ul>
                                </div>
                                <div id="compose_right_section" class="compose_right_outer">
                                    <div class="compose_right">
                                        <h2>Compose Mail</h2>
                                        <ul class="compose_right_inner">
                                            <?php if ($_POST['error_mgs'] && $_POST['error_mgs'] != '') { ?>
                                                <li><div style="color:red"><?php echo $_POST['error_mgs'] ?></div></li>
                                                <?php
                                                $_POST['error_mgs'] = '';
                                            }
                                            ?>
																																												<li><small class="req_field" style=" float:left !important; clear:both;padding-bottom:20px;">* <?php echo FILED_REQUIRED; ?> </small></li>
                                            <li>
                                                <label style="clear:left">To <span style="color:red">*</span></label>
                                                <div class="input_sec">
                                                    <div class="drop4" style="padding:0px; margin-bottom:10px;">
                                                        <select name="frmToUserType" class="drop_down1" onchange="ShowAllAdmin(this.value);">
                                                           <!-- <option value="0"><?php echo PLZ_SEL;?></option>-->
                                                            <option value="admin"><?php echo ADMIN;?></option>
                                                            <option value="customer"><?php echo CUSTOMER;?></option>
                                                        </select> 
                                                    </div>
                                                    <input placeholder="Enter Email" id="frmMessageTo" style="width:99.6%;display: none " class="validate[required,custom[email]] pop_txt1" name="frmMessageTo" type="text" value="<?php echo @$_POST['frmMessageTo'] ?>"/>
                                                </div>
                                            </li>
                                            <li class="cb">
                                                <label><?php echo TYPE;?> <span style="color:red">*</span></label>
                                               <div class="input_sec">
						<div class="drop4" style="padding:0px; margin-bottom:10px;">
						    <div class="ErrorShippingCountry formError" style="display: none;left: 963px;margin-top: 25px;opacity: 0.87;position: absolute;top: 180px;">
							<div class="formErrorContent">* <?php echo TYPE_REQ_MSG; ?><br>
						    </div>
						    <div class="formErrorArrow">
							<div class="line10"><!-- --></div>
							<div class="line9"><!-- --></div>
							<div class="line8"><!-- --></div>
							<div class="line7"><!-- --></div>
							<div class="line6"><!-- --></div>
							<div class="line5"><!-- --></div>
							<div class="line4"><!-- --></div>
							<div class="line3"><!-- --></div>
							<div class="line2"><!-- --></div>
							<div class="line1"><!-- --></div>
						    </div>
						</div>
                                                    <select name="frmMessageType"  class="drop_down1 validate[required]" id="supportType"> 
							<option value="0"><?php echo PLZ_SEL;?></option>
                                                        <?php
                                                        foreach ($objPage->arrMessageType as $var) {
                                                            echo '<option value="' . $var['TicketTitle'] . '">' . $var['TicketTitle'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
											</li>
                                            <li class="cb">
                                                <label><?php echo SUBJECT;?> <span style="color:red">*</span></label>
                                                <div class="input_sec"><input class="validate[required] pop_txt1" name="frmSubject" type="text" value="<?php echo @$_POST['frmSubject'] ?>" style="margin-bottom:10px;"/>
                                            </div>
											
											</li>
                                            <li class="cb">
                                                <label><?php echo MESSAGE;?> <span style="color:red">*</span></label>
                                                <div class="input_sec"><textarea class="validate[required]" cols="5" name="frmMessage" rows="5"><?php echo @$_POST['frmMessage'] ?></textarea>
                                            </div>
											</li>
                                            <li class="create_cancle_btn cb" style="float:left;">
                                                <label style="visibility: hidden">.</label>
                                                <input type="submit" value="Send" name="frmHidenAdd" id="frmHidenAdd" style=" float:left;" class="submit3"/>
                                                <input type="button" style="display: none" value="<?php echo SEND;?>" name="frmHidenAdd2" id="frmHidenAdd2" class="submit3"/>
                                                <a href="<?php echo $objCore->getUrl('wholesaler_messages_inbox.php', array('place' => 'inbox')); ?>"><input type="button" value="<?php echo CANCEL;?>" class="cancel"/></a>
                                                
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <input type="hidden" name="send" value="1" />
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
	<script>
	    function validateFormSUpport() {
		var supportType = $('#supportType').val();
                if(supportType != 0){
                    $('.ErrorShippingCountry').css('display','none');                    
                    return true;
                }
                else{
		    //alert("d");
                    $('.ErrorShippingCountry').css('display','block');
		    return false;
                }
	    }
	</script>
    </body>
</html> 