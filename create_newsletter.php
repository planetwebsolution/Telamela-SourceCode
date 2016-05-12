<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_NEWSLETTER_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo NEWSLETTER_CREATE_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>browse.css"/> 
        <script type="text/javascript" src="<?php echo JS_PATH ?>browse.js"></script> 
        <script>
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#createNewsletter").validationEngine();
                $('.datePicker').datepick({dateFormat: 'dd-mm-yyyy',showTrigger:'<small><a href="javascript:void(0);"><img src="common/images/cal_icon.png" alt=""/></a></small>'});
            });
        </script>

        <script type="text/javascript" src="<?php echo JS_PATH ?>jPages.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>tabifier.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>newsletter.js"></script>
        <script type="text/javascript" src="<?php echo CKEDITOR_URL; ?>ckeditor.js"></script>
        <script  type="text/javascript">
            var totalRows = '<?php echo count($objPage->arrRecipientList) ?>';
           
            $(function(){
                $('.file').customFileInput1();
                $('').change();	
            });
            
        </script>
    </head>
    <body>
        <style>
            .html_editor span{padding:0px !important;} .holder{float: left;margin-left: 30px;}  .holder a{margin: 0 3px;text-decoration: underline;color:#333333; background-color:#ffffff;} .holder a:first-child{text-decoration: none !important;}.holder a:last-child{text-decoration: none !important;}.add_edit_pakage .newListSelected{border:0px solid #929291}
            .input_sec span{color: #3f3e3e;font: 13px/20px "Lato",sans-serif;height: 20px;  padding: 11px 5px;}
            .shedule{ background:#FFFFFF}
            .add_edit_pakage{background: none repeat scroll 0 0 #f5f5f5;padding: 20px 0 20px 25px; box-sizing:border-box;}
            .newlatter_sec .bottom_option{width:940px; font-size:14px; color:#666;}
            .shedule {border: 1px solid #dcdcdc;float: left;    padding: 10px 0 20px 20px;    width: 920px; margin-bottom:10px;}
            .newlatter_sec .feebacks_sec .read{text-align:center;}
            .mysorting .drop8 .newListSelected{background-position: -1px -4px;}
            .stylish-select .dropdown_3 .SSContainerDivWrapper{top: 31px !important;}
            .stylish-select .drop8 .selectedTxt {color: #3f3e3e;font: 13px/25px "Open Sans",sans-serif;height: 32px;overflow: hidden;padding: 0 25px 0 5px;width: 50px;}
            .customfile1 span{color: #fff;font: 17px/18px "Open Sans",sans-serif;}
            .newlatter_sec .sorting{padding: 12px 0px}
        </style>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header" style="border-bottom:none"><div class="layout"> </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div class="wholesalerHeaderSection" style="width:100%; height:50px; padding-top:16px;	  border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_container">

                        <div class="top_header border_bottom"><h1><?php echo CREATE; ?> <span><?php echo NEWSLETTER; ?></span></h1></div>
                    </div>

                    <form name="createNewsletter" id="createNewsletter" onsubmit="return validateNews();" action="" method="POST" enctype="multipart/form-data" >
                        <div class="body_inner_bg radius">
                            <div class="add_edit_pakage newlatter_sec">
                                <!--<div class="back_ankar_sec"><a href="<?php //echo $objCore->getUrl('newsletter.php');                ?>" class="back"><span><?php //echo BACK;               ?></span></a></div>-->
                                <small class="req_field" style="float:left !important" id="require">* <?php echo FILED_REQUIRED; ?></small>
                                <ul class="left_sec">
                                    <li>
                                        <label><?php echo TITLE; ?><span class="newsLetter_Red">*</span><strong>:</strong></label>
                                        <input name="Title" type="text" value="<?php echo @$_POST['Title'] ?>" id="frmTitle" class="validate[required] frmTitle_txt" />
                                    </li>
                                    <li>
                                        <label><?php echo CONTENT; ?>  <span class="newsLetter_Red">*</span><strong>:</strong></label>
                                        <div class="formContent formError" style="opacity: 0.87; position: absolute; top: 109px; left: 572px; margin-top: 60px; display:none"><div class="formErrorContent">* <?php echo FILED_REQUIRED; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>
                                        <div class="input_sec">
                                            <div class="html_editor news_letter_editor">
                                                <textarea name="Content" class="validate[required]" id="HtmlEditor"><?php echo $_POST['Content'] ?></textarea>
                                                <script type="text/javascript">
                                                    CKEDITOR.replace( 'HtmlEditor',
                                                    {
                                                        enterMode : CKEDITOR.ENTER_BR,
                                                        toolbar :[['Bold'],['Italic'],['Strike'],['Subscript'],['Superscript'],['RemoveFormat'],['NumberedList'],['BulletedList'],['Link'],['Unlink'],
                                                            ['Table'],['TextColor'],['BGColor'],['FontSize'],['Font'],['Styles']]   
                                                    });
                                                </script>
                                            </div>
                                            <strong class="or"><?php echo OR_COM; ?>
                                                <br/>
                                                <small class="red">Image JPEG, PNG, GIF</small>
                                            </strong>                                           
                                            <input class="customfile1-input file" type="file" id="template" name="template" style="top: -509px; left: 0px!important;"/>
                                            <div class="upload_error formError" style="opacity: 0.87; position: absolute; top: 410px; left: 466px; margin-top: 6px; display:none;"><div class="formErrorContent">* <?php echo ACCPT_IMAGE; ?> <br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>
                                        </div>
                                    </li>

                                    <li class="cb">
                                        <label><?php echo SEND_TO; ?> <span class="newsLetter_Red">*</span><strong>:</strong></label>
                                        <div class="input_sec news_table_wrap">

                                            <div class="sorting mysorting">
                                                <div class="drop8 dropdown_3" >
                                                    <select name="sort_by" id="sort_by" class="drop_down1">
                                                        <option value="0"><?php echo SORT_BY; ?></option>
                                                        <option <?php echo $_POST['sort_by'] == 'CustomerFirstName' ? 'selected' : ''; ?> value="CustomerFirstName"><?php echo AZ; ?></option>
                                                        <option <?php echo $_POST['sort_by'] == 'Purchased' ? 'selected' : ''; ?> value="Purchased"><?php echo POPULAR; ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="check_error formError" style="opacity: 0.87; position: absolute; top: 575px; left: 258px; margin-top: 6px; display:none;"><div class="formErrorContent">* <?php echo PL_SL_ONE; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>
                                            <ul class="feebacks_sec news_table" style="margin-top: 0px;">
                                                <li class="heading">
                                                    <span class="customer" id="check_status"><font id="s_all" style="cursor:pointer;">Select All</font>  <br/><font style="cursor:pointer;" id="un_all"><?php echo UN_SL_ALL; ?></font></span>
                                                    <span class="product"><?php echo SNO; ?></span>
                                                    <span class="read" style="text-align:center" ><?php echo NAME; ?></span>
                                                    <span class="date"><?php echo MAM_SIN; ?></span>
                                                </li>
                                            </ul>
                                            <ul class="feebacks_sec news_table" id="itemContainer" style="margin-top: 0px;">
                                                <?php
                                                if (count($objPage->arrRecipientList) > 0)
                                                {
                                                    $varCounter = 0;
                                                    foreach ($objPage->arrRecipientList as $varList)
                                                    {
                                                        $varCounter++;
                                                        ?>
                                                        <li <?php echo $varCounter % 2 == 0 ? 'class="bg_color"' : ''; ?> >
                                                            <span class="customer">
                                                                <span class="check_box" style="margin-left: 0;"><input type="checkbox" value="<?php echo $varList['pkCustomerID'] ?>" name="recipienId[]" class=""/></span></span>
                                                            <span class="product"><?php echo $varCounter; //$varList['pkCustomerID']                ?></span>
                                                            <span class="read" style="text-align:center"><?php echo $varList['CustomerFirstName'] . ' ' . $varList['CustomerLastName'] ?></span>
                                                            <span class="date"><?php echo $objCore->localDateTime($varList['CustomerDateAdded'], DATE_FORMAT_SITE_FRONT); ?></span>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>  
                                        </div>
                                    </li>
                                    <li style="padding-bottom: 0">
                                        <label style="visibility: hidden" class="margin_none">.</label>
                                        <div class="bottom_option" style="margin-top: 15px;padding-bottom: 25px">
                                            <div class="view viewresult"><?php echo VING; ?> <a href="#"><span id="resultCount">1-<?php echo count($objPage->arrRecipientList) > 15 ? 15 : count($objPage->arrRecipientList) ?></span></a>&nbsp;of <a href="#"><?php echo count($objPage->arrRecipientList) ?></a> <?php echo RESULT; ?></div>
                                            <div class="holder paging"></div>
                                            <!--                                            <div class="sorting mysorting" style="padding: 0px;margin-top: -5px;">
                                                                                            <div class="drop8 dropdown_3" >
                                                                                                <select name="sort_by" id="sort_by" class="drop_down1">
                                                                                                    <option value="0"><?php echo SORT_BY; ?></option>
                                                                                                    <option <?php echo $_POST['sort_by'] == 'CustomerFirstName' ? 'selected' : ''; ?> value="CustomerFirstName"><?php echo AZ; ?></option>
                                                                                                    <option <?php echo $_POST['sort_by'] == 'Purchased' ? 'selected' : ''; ?> value="Purchased"><?php echo POPULAR; ?></option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>-->
                                        </div>
                                    </li>
                                    <li>
                                        <label class="margin_none"><?php echo SCH_DEL_TIME; ?> <span class="newsLetter_Red">*</span><strong>:</strong></label>
                                        <div class="shedule mysorting">
                                            <div class="cal_outer cal_outer1">
                                                <label><?php echo SCH_DEL_DATE; ?> </label>
                                                <div class="cal_sec">
                                                    <div class="DateformError formError" style="opacity: 0.87; position: absolute; top: 0px; left: 89.1667px; margin-top: -34px;display:none"><div class="formErrorContent">* <?php echo FILED_REQUIRED; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>
                                                    <input readonly="true" style="z-index: 33; background:transparent;" id="Date" type="text" name="DeliveryDate" value="<?php echo $_POST['DeliveryDate'] ?>" class="text3 datePicker"/>
<!--                                                    <small class="datepick-trigger"><a href="javascript:void(0);"><img src="common/images/cal_icon.png" alt=""/></a></small>-->
                                                </div>
                                            </div>
                                            <div class="cal_outer width cal_outer1">
                                                <label><?php echo SCH_DEL_TIME; ?></label>
                                                <div class="drop8 dropdown_3" >
                                                    <select name="hours" class="drop_down1">
                                                        <option value="0"><?php echo HH; ?></option>
                                                        <?php
                                                        for ($hh = 1; $hh < 24; $hh++)
                                                        {
                                                            $hh1 = $hh < 10 ? '0' . $hh : $hh;
                                                            echo '<option value="' . $hh . '">' . $hh1 . '</option>';
                                                        }
                                                        ?>                                      
                                                    </select> 
                                                </div>
                                                <div class="drop8 dropdown_3">
                                                    <select name="minutes" class="drop_down1">
                                                        <option value="0"><?php echo MM; ?></option>
                                                        <?php
                                                        for ($mm = 0; $mm <= 55; $mm = $mm + 5)
                                                        {

                                                            $mm1 = $mm < 10 ? '0' . $mm : $mm;
                                                            echo '<option value="' . $mm1 . '">' . $mm1 . '</option>';
                                                        }
                                                        ?>
                                                    </select> 
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                    <li class="create_cancle_btn">
                                        <label style="visibility: hidden">.</label>
                                        <input type="hidden" id="sort" name="sort" value="" />
                                        <input type="hidden" id="place" name="place" value="save" />
                                        <input type="submit" value="Send" class="submit3" style="float:left;" />
                                        <!--<a href="<?php echo $objCore->getUrl('newsletter.php'); ?>">-->
                                            <input onclick="window.location.href='<?php echo $objCore->getUrl('newsletter.php'); ?>'" type="button" value="Cancel" class="cancel"/>
                                        <!--</a>-->
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html> 
