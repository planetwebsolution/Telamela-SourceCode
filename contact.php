<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CONTACTUS_CTRL;
$objCore = new Core();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>
            <?php echo CONTACT_TITLE; ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script  type="text/javascript">
            $(document).ready(function(){
        
                $('.dropdown_1').sSelect();
                $('#frmContactUsSubject').change(function(){
                    var cid = parseInt($(this).val());
          
                    if(cid>0){
                        $('.ErrorContactUsSubject').css('display','none');
                    }
                    else{
                        $('.ErrorContactUsSubject').css('display','block');
                    }
                }
            );
            }
        );
        </script>
        <script>
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#frmContactUs").validationEngine('attach', {
                    scroll: false,
                    'custom_error_messages': {
                        'custom[integer]': {
                            'message': "*Contact number should be like 2123456458"
                        }                      
                    }
                }
            );
                jQuery('#resetForm').click(function(){
          
                    jQuery('#success_nessage').css('display','none');
                    jQuery('#frmContactUs .selectedTxt').html('Select Subject');
                    jQuery('.formError').each(function(){
                        if($(this).hasClass('ErrorContactUsSubject'))
                        {
                            this.style.display = 'none';
                        }
                        else
                        {
                            this.parentNode.removeChild(this);
                        }
            
                    }
                );
                }
            );
        
                jQuery('.submit1').click(function(){
                    jQuery('#success_nessage').css('display','none');
                }
            );
        
            }
        );
      
            /**
             *
             * @param {
    jqObject}
    the field where the validation applies
             * @param {
    Array[String]}
    validation rules for this field
             * @param {
    int}
    rule index
             * @param {
    Map}
    form options
             * @return an error string if validation failed
             */
            function checkHELLO(field, rules, i, options){
                if (field.val() != "HELLO") {
                    // this allows to use i18 for the error msgs
                    return options.allrules.validate2fields.alertText;
                }
            }
            function validateForm(){
                var contId = $('#frmContactUsSubject').val();
                if(contId=='0' || contId==''){
                    $('.ErrorContactUsSubject').css('display','block');
                    return false;
                }
            }
        
        </script>
        <style>.star_icon{  position: absolute !important;
                     right: 1px !important;
                     top: 1px !important;
}
.stylish-select ul.newList{ max-height:340px!important;}

        </style>
    </head>
    <body>
        <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>

        </div>
        <div class="header">
            <div class="layout">
            </div>
        </div>
        <?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <h1>
                            <?php echo CONTACT_TITLE; ?>

                            <?php echo US; ?>
                        </h1>
                    </div>
                    <div class="body_inner_bg radius">
                        <div class="add_edit_pakage contact_sec">
                            <div style="clear:both; height:30px;">
                                <small class="req_field" style="float:left!important;">
                                    *
                                    <?php echo FILED_REQUIRED; ?>

                                </small>
                            </div>
                            <?php
                            if ($objCore->
                                            displaySessMsg()
                                    <>
                                    '')
                            {
                                ?>

                                <div style=" width: 320px; color:green" id="success_nessage">
                                    <?php
                                    echo $objCore->
                                            displaySessMsg();
                                    $objCore->
                                            setSuccessMsg('');
                                    $objCore->
                                            setErrorMsg('');
                                    ?>
                                </div>
                            <?php } ?>
                            <form name="frmContactUs" id="frmContactUs" method="post" action="" onsubmit="return validateForm();">
                                <ul class="left_sec">
                                    <li>
                                        <label>
                                            <?php echo NAME; ?>

                                            <strong>
                                                :
                                            </strong>
                                        </label>
                                        <span class="input_star">
                                            <input type="text" name="frmContactUsName" id="frmContactUsName" value="" class="validate[required,maxSize[25]] text-input" maxlength="25"/>
                                            <small class="star_icon">
                                                <img src="common/images/star_icon.png" alt="">
                                            </small>
                                        </span>
                                    </li>
                                    <li>
                                        <label>
                                            <?php echo EMAIL; ?>

                                            <strong>
                                                :
                                            </strong>
                                        </label>
                                        <span class="input_star">
                                            <input type="text" name="frmContactUsEmailId" id="frmContactUsEmailId" value="" class="validate[required,custom[email]] text-input"/>
                                            <small class="star_icon">
                                                <img src="common/images/star_icon.png" alt="">
                                            </small>
                                        </span>
                                    </li>
                                    <li>
                                        <label>
                                            <?php echo MOBILE_NUMBER; ?>

                                            <strong>
                                                :
                                            </strong>
                                        </label>
                                        <span class="input_star">
                                            <input type="text" name="frmContactUsMobile" maxlength="10" id="frmContactUsMobile" value="" class="validate[required,custom[integer],maxSize[10]]] text-input"/>
                                            <small class="star_icon">
                                                <img src="common/images/star_icon.png" alt="">
                                            </small>
                                        </span>
                                    </li>
                                    <li>
                                        <label>
                                            <?php echo SUBJECT; ?>

                                            <strong>
                                                :
                                            </strong>
                                        </label>
                                        
                                        <div class="drop4 input_star" ><div style="opacity: 0.87; position: absolute;top: -40px; left: 397px; display:none;" class="ErrorContactUsSubject formError">
                                            <div class="formErrorContent">
                                                *
                                                <?php echo FILED_REQUIRED; ?>
                                                <br>
                                            </div>
                                            <div class="formErrorArrow">
                                                <div class="line10">
                                                    <!-- -->
                                                </div>
                                                <div class="line9">
                                                    <!-- -->
                                                </div>
                                                <div class="line8">
                                                    <!-- -->
                                                </div>
                                                <div class="line7">
                                                    <!-- -->
                                                </div>
                                                <div class="line6">
                                                    <!-- -->
                                                </div>
                                                <div class="line5">
                                                    <!-- -->
                                                </div>
                                                <div class="line4">
                                                    <!-- -->
                                                </div>
                                                <div class="line3">
                                                    <!-- -->
                                                </div>
                                                <div class="line2">
                                                    <!-- -->
                                                </div>
                                                <div class="line1">
                                                    <!-- -->
                                                </div>
                                            </div>
                                        </div>
                                            <select class="validate[required] dropdown_1" name="frmContactUsSubject" id="frmContactUsSubject" style="width:130px">
                                                <option value="">
                                                    <?php echo SEL_SUB; ?>
                                                </option>
                                                <?php
                                                foreach ($objPage->
                                                arrSupportList as $v)
                                                {
                                                    ?>
                                                    <option value="<?php echo $v['pkTicketID']; ?>"><?php echo $v['TicketTitle']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <small class="star_icon" style="right:27px;">
                                                <img src="common/images/star_icon.png" alt="">
                                            </small>
                                        </div>
                                    </li>
                                    <li>
                                        <label>
                                            <?php echo MESSAGE; ?>

                                            <strong>
                                                :
                                            </strong>
                                        </label>
                                        <span class="input_star">
                                            <textarea cols="5" rows="5" style="width:425px; height:100px" name="frmContactUsMessage" id="frmContactUsMessage" class="validate[required] text-input"></textarea>
                                            <small class="star_icon" style=" right:26px;">
                                                <img src="common/images/star_icon.png" alt="">
                                            </small>
                                        </span>
                                    </li>
                                    <li class="create_cancle_btn">
                                        <label style="visibility: hidden; float:none; margin:0px; padding-top:0px">
                                            .
                                        </label>


                                        <input type="submit" class="add_link submit3 countinue_shopping " value="<?php echo SUBMIT; ?>"/> <input type="reset"  value="<?php echo RESET; ?>" class="add_link compare_btn_sh" id="resetForm"/>
                                        <input type="hidden" name="frmHidenSend" id="frmHidenSend" value="Send" />

                                    </li>
                                </ul>
                                <div class="right_sec"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3153.0104017081067!2d144.93956599999999!3d-37.789795999999996!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d21e46eb7ab%3A0x273f2ca48b0241f7!2s155-161+Boundary+Rd!5e0!3m2!1sen!2sau!4v1403053507198" width="525" height="200" frameborder="0" style="border:0"></iframe>
                                    </iframe>
                                    <h3>

                                        <?php echo OFFICE_ADD; ?>
                                    </h3>
                                    <ul class="profile_left">

                                        <li>
                                            <p>
                                                <strong style="float:left"> <?php echo ADD1; ?></strong><br />
                                                <?php echo DUMMY_TEXT; ?>
                                            </p>

                                        </li>
                                        <!--  <li>
                                            <p>
                                        <?php echo ADD2; ?>
                                              <strong>
                                                :
                                              </strong>
                                            </p>
                                            <small>
                                        <?php echo DUMMY_TEXT; ?>
                                            </small>
                                          </li>-->
                                        <li>
                                            <p>
                                                <?php echo EMAIL; ?> :
                                                <a href="mailto:<?php echo CONTACT_EMAIL; ?>?Subject=Telamela" class="linkCustomeHover">
                                                    <?php echo CONTACT_EMAIL; ?>
                                                </a>
                                            </p>

                                        </li>
                                        <li>
                                            <p>
                                                <?php echo MOBILE_NUMBER; ?> :
                                                <?php echo CONTACT_PHONE; ?>


                                            </p>

                                        </li>
                                    </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>