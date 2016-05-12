<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_SUPPORT_CTRL;
$objCustomer = new Customer();

//pre($_SESSION);
if (isset($_REQUEST['wid']) && $_REQUEST['wid'] > 0) {
    $arrIsW = array('selected' => 'selected="selected"', 'display' => 'Wholesaler', 'wid' => $_REQUEST['wid']);
} else {
    $arrIsW = array('selected' => '', 'display' => 'Admin', 'wid' => $_REQUEST['wid']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MESSAGE_COMPOSE_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script>

            function wholesaler_change(wholeId) {
                if (wholeId == '0') {
                    $('.ErrorwholesalerSelect').css('display', 'block');
                    return false;
                }
                else {
                    $('.ErrorwholesalerSelect').css('display', 'none');
                }
            }

            function type_change(typeId) {
                if (typeId == '0') {
                    $('.ErrorSupportType').css('display', 'block');
                    return false;
                }
                else {
                    $('.ErrorSupportType').css('display', 'none');
                }
            }

        </script>
        <script type="text/javascript">
            jQuery(document).ready(function() {

                // binds form submission and fields to the validation engine
                //jQuery("#frmCustomerRegistration").validationEngine();
<?php if ($arrIsW['display'] == 'Wholesaler') { ?>ShowAllAdmin("Wholesaler", '<?php echo $arrIsW['wid']; ?>');<?php } ?>
                $('.drop_down1').sSelect();
                $('.drop_down2').sSelect();
                $('.cancel').click(function() {
                    window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";

                });

                $('#frmHidenAdd').click(function() {

                    $(this).hide();
                    $('#frmHidenAdd2').show();

                    setTimeout(function() {
                        $('#frmHidenAdd').show();
                        $('#frmHidenAdd2').hide();

                    }, 2000);
                });
            });



            function form_validation() {
                var cWholesaler = cType = cSubject = cMessage = 1;
                function goToByScroll(id) {
                    // Remove "link" from the ID
                    id = id.replace("link", "");
                    // Scroll
                    $('html,body').animate({
                        scrollTop: $("#" + id).offset().top
                    },
                    'slow');
                }
                goToByScroll('require');
                if ($('#frmfkToUserID').val() == '0') {
                    cWholesaler = 0;
                }
                else {
                    $('.ErrorwholesalerSelect').css('display', 'none');
                }

                if ($('#frmSupportType').val() == '0') {
                    cType = 0;
                }
                else {
                    $('.ErrorSupportType').css('display', 'none');
                }

                if ($('#frmSubject').val() == '') {
                    cSubject = 0;
                }
                else {
                    $('.ErrorSubject').css('display', 'none');
                }

                if ($('#frmMessage').val() == '') {
                    cMessage = 0;
                }
                else {
                    $('.ErrorMessage').css('display', 'none');
                }
                if (cWholesaler == 0)
                    $('.ErrorwholesalerSelect').css('display', 'block');
                if (cType == 0)
                    $('.ErrorSupportType').css('display', 'block');
                if (cSubject == 0)
                    $('.ErrorSubject').css('display', 'block');
                if (cMessage == 0)
                    $('.ErrorMessage').css('display', 'block');
                if (cWholesaler == 0 || cType == 0 || cSubject == 0 || cMessage == 0)
                    return false;

            }

            function ShowAllAdmin(str, id) {

                if (str == "Wholesaler")
                {

                    $.post("common/ajax/ajax_customer.php", {action: 'ShowAdmin', id: id},
                    function(data)
                    {   //alert(data);
                        document.getElementById("wholesalerSelectId").style.display = "block";
                        $('#wholesalerSelectId .newListSelected').hide();
                        // $('.drop_down2').sSelect();
                        $('#frmfkToUserID').html(data);
                        $('#frmfkToUserID').sSelect();
                        var wholeId = $('#frmfkToUserID').val();
                        if (wholeId == '0') {
                            $('.ErrorwholesalerSelect').css('display', 'block');
                            return false;
                        }
                        else {
                            $('.ErrorwholesalerSelect').css('display', 'none');
                        }


                    }
                    );
                }

                else
                {
                    document.getElementById("wholesalerSelectId").style.display = "none";

                }

            }

        </script>
        <style>.stylish-select .drop4 .newListSelected{width: 98.5%}
            .add_edit_pakage{ background:#f5f5f5; padding:10px;}
            .compose_message .compose_right{ width:704px}
            .compose_right .back span{ color: #fff;
                                       padding: 10px 20px 20px 30px; background-position: 1px 11px}
            .stylish-select .dropdown_2 .selectedTxt{ background-position: 147px 7px; width:134PX; }
            .compose_right_inner li label strong{ margin-top:4px;}
            #frmSupportType{ position:relative}
            .stylish-select .drop4 .SSContainerDivWrapper{top: 33px!important;
                                                          width: 99.8%;
                                                          z-index: 9999999999999999999999999999999999999999;}
            </style>

        </head>
        <body>
            <em> <div id="navBar">
                    <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout">

            </div>
        </div> <?php include_once INC_PATH . 'header.inc.php'; ?>

        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">


                <div class="add_pakage_outer">
                    <div class="top_container" style="padding-bottom: 18px;">
                        <div class="top_header border_bottom"><h1><?php echo SUPP; ?></h1></div>
                    </div>

                    <div class="body_inner_bg">
                        <div class="add_edit_pakage compose_message">
                            <div class="compose_left_outer">
                                <ul class="compose_left"> <li class="compose_active"><a style="  color: #56a1f2;" href="<?php echo $objCore->getUrl('compose_message.php', array('place' => 'compose')); ?>"><?php echo COMPOSE; ?><small><i class="fa fa-angle-right"></i></small></a></li>
                                    <li class="inbox"><a href="<?php echo $objCore->getUrl('messages_inbox.php', array('place' => 'inbox')); ?>"><?php echo INBOX; ?></a></li>
                                    <li class="outbox"><a href="<?php echo $objCore->getUrl('outbox_messages.php', array('place' => 'outbox')); ?>"><?php echo OUTBOX; ?></a></li>

                                </ul>
                            </div>
                            <div class="compose_right_outer">
                                <div class="compose_right">
                                    <h2><?php echo COMPOS_MAIL; ?><a href="<?php echo $objCore->getUrl('dashboard_customer_account.php'); ?>" class="back"><span><?php echo BACK; ?></span></a></h2>
                                    <small class="req_field" style="float:left !important" id="require">* <?php echo FILED_REQUIRED; ?></small>
                                    <form name="frmCustomerRegistration" id="frmCustomerRegistration" method="post" action="" onsubmit="return form_validation();">
                                        <ul class="compose_right_inner compose_align">
                                            <li>
                                                <label> <?php echo TO; ?><strong>:</strong></label>
                                                <div class="input_sec">
                                                    <div class="drop4 newdrop4" style="position: relative; z-index: 999">
                                                        <select class="drop_down1" onchange="ShowAllAdmin(this.value, 0);" name="frmToUserType" id="frmToUserType">
                                                            <option value="Admin"><?php echo ADMIN; ?></option>
                                                            <option value="Wholesaler" <?php echo $arrIsW['selected']; ?>><?php echo WHOLESALER; ?></option>
                                                        </select>
                                                        <small class="star_icon" style="right:-129px;"><img alt="" src="common/images/star_icon.png"></small>
                                                    </div>
                                                    <div style="clear:both;">
                                                        <div class="drop4 dropdown_2" id="wholesalerSelectId" style="display: none;margin-top: 16px;" >
                                                            <div class="ErrorwholesalerSelect formError" style="opacity: 0.87; position: absolute; display: none; top: 144px; left: 548px; z-index:9999;"><div class="formErrorContent">* <?php echo FILED_REQUIRED; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>
                                                            <div class="input_star" >
                                                                <select class="drojip_down2" id="frmfkToUserID" name="frmfkToUserID" onchange="wholesaler_change(this.value);"></select>
                                                                <small class="star_icon" style="right:-3px;"><img alt="" src="common/images/star_icon.png"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li style="position:relative">
                                                <label><?php echo Type; ?> <strong>:</strong></label>
                                                <div class="drop4 newdrop4">
                                                    <div class="ErrorSupportType formError" style="opacity: 0.87; position: absolute; display: none; margin-top: -314px; z-index:9999999999999; top: 344px; left: 525px;"><div class="formErrorContent">* <?php echo FILED_REQUIRED; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>
                                                    <div class="input_star inp_star_width"><!--edit-->
                                                        <select class="drop_down1" name="frmSupportType" id="frmSupportType" onchange="type_change(this.value);">
                                                            <option value="0">--Type--</option>
                                                            <?php foreach ($objPage->arrSupportList as $val) { ?>
                                                                <option value="<?php echo $val['TicketTitle'] ?>"><?php echo $val['TicketTitle'] ?></option>
                                                            <?php } ?>

                                                        </select>
                                                        <small class="star_icon" style="right:-3px;"><img alt="" src="common/images/star_icon.png"></small>
                                                    </div>

                                                </div>
                                            </li>
                                            <li>
                                                <label><?php echo SUBJECT; ?><strong>:</strong></label>
                                                <div class="input_star inp_star_width">
                                                    <div class="ErrorSubject formError" style="opacity: 0.87; position: absolute; display: none; margin-top:-214px; top: 176px; left: 292px; z-index:9999;"><div class="formErrorContent">*<?php echo FILED_REQUIRED; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>
                                                    <input type="text" value="" onkeyup="form_validation()" name="frmSubject" id="frmSubject" style="width:484px; height:26px; max-width:100%;" class=""/>
                                                    <small class="star_icon" style="right:0px;"><img alt="" src="common/images/star_icon.png"></small>
                                                </div>
                                            </li>
                                            <li>
                                                <label><?php echo MESSAGE; ?> <strong>:</strong></label>
                                                <div class="input_star inp_star_width msg_width" >
                                                    <div class="ErrorMessage formError" style="opacity: 0.87; position: absolute; display: none; margin-top: -213px; top: 178px; left: 297px; z-index:9999;"><div class="formErrorContent">* <?php echo FILED_REQUIRED; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>
                                                    <textarea cols="5" rows="5" name="frmMessage" onkeyup="form_validation()" id="frmMessage" class="validate[required] text-input" style="height:100px;"/></textarea>
                                                    <small class="star_icon" style="right:0px;"><img alt="" src="common/images/star_icon.png"></small>
                                                </div>
                                            </li>
                                            <li class="create_cancle_btn">
                                                <label style="visibility: hidden">.</label>
                                                <input type="submit" value="Send" name="frmHidenAdd" id="frmHidenAdd" class="submit3" style=" float: left; width:130px; margin-right: 5px;"/>
                                                <input type="button" value="<?php echo SEND; ?>" name="frmHidenAdd2" id="frmHidenAdd2"  class="submit3" style=" float: left; width:130px; margin-right: 5px;display:none"/>
                                                <input type="button" value="<?php echo CANCEL; ?>" class="cancel" style="width: 131px;"/>
                                            </li>
                                        </ul>
                                    </form>
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
