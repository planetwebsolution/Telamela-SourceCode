<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SPECIAL_BANNER_CTRL;
$arrRow = $objPage->arrRow;
list($width, $height) = explode('x', $arrSpecialPageBannerImage['big']);
list($rwidth, $rheight) = explode('x', $arrSpecialPageBannerImage['reward']);

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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Edit Banner</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript" src="<?php echo ADMIN_JS_PATH; ?>jquery_002.js"></script>
        <script type="text/javascript">
            Cal=jQuery.noConflict();
            Cal(document).ready(function(){
                Cal('#frmDateStart').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif"  alt="Popup" style=" margin: -1px 0 0 -31px;" class="trigger">',onSelect:calEqual,minDate: new Date()});
                Cal('#frmDateEnd').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" style=" margin:-1px 0 0 -25px"  class="trigger">',onSelect:calDateCompare,minDate: new Date()});
            });
        </script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            //Hemant - create new variable msg0 = null
            var msgR = 'Banner should be <?php echo $arrSpecialPageBannerImage['reward']; ?> px';
            var msgO = 'Banner should be <?php echo $arrSpecialPageBannerImage['big']; ?> px';
            var url = window.URL || window.webkitURL;
            Cal(document).ready(function(){
                Cal('#frmBannerPage').live('change',function(){ 
                    Cal('#frmImg').val('');
                    if($(this).val()=='reward'){
                        $('#bannerMsg').html(msgR);
                        $('#frmCategory').val(0);
                        $('#categoryPages').hide();
                        $('#eventPages').hide();
                    }else if($(this).val().valueOf()=='special'){
                        $('#bannerMsg').html(msgO);
                        $('#frmCategory').val(0);
                        $('#eventPages').show();
                        $('#categoryPages').hide();
                    }else{
                        $('#bannerMsg').html(msgO);
                        $('#categoryPages').show();
                        $('#eventPages').hide();
                    }
                });
                
                
                Cal('.prod_img').live('change',function(){
                    var dd = $(this);
                    var name = dd.attr('name');
                    var hgt = <?php echo $height; ?>;
                    var wth = <?php echo $width; ?>;
                    var rhgt = <?php echo $rheight; ?>;
                    var rwth = <?php echo $rwidth; ?>;

                    if( this.disabled ){
                        alert('Your browser does not support File upload.');
                    }else{
                        var chosen = this.files[0];
                        var image = new Image();
                        image.onload = function() {
                            if($('#frmBannerPage').val()=='reward' ){
                                if(this.height < rhgt || this.width < rwth){
                                    alert('Please upload image of ('+rwth+')px width and ('+rhgt+')px height!');
                                    Cal('#frmImg').val('');
                                    this.focus();
                                }
                            }else if(this.height < hgt || this.width < wth){
                                alert('Please upload image of ('+wth+')px width and ('+hgt+')px height!');
                                Cal('#frmImg').val('');
                                this.focus();
                            }

                        };
                        image.onerror = function() {
                            alert('Accepted Image formats are: jpg, jpeg, gif, png ');
                            Cal('#frmImg').val('');
                        };
                        image.src = url.createObjectURL(chosen);
                    }
                });
            });
            function calEqual(stDt,enDt)
			{
				$('#frmDateEnd').val($('#frmDateStart').val());
			}
            function calDateCompare(SelectedDates)
            {

                var d = new Date(SelectedDates);
                var d_formatted = d.getDate() + '-' + d.getMonth() +'-' + d.getFullYear();
                var sdate = d_formatted.split("-");

                var StartDate = $('#frmDateStart').val();
                var CurrDate  = StartDate.split("-");
                /*********************** From Date *****************/
                var CY = parseInt(CurrDate[2]);  //Year
                var CM = parseInt(CurrDate[1]);  //Month
                var CD = parseInt(CurrDate[0]);  //Date
                /******************* To Date *********************/

                var sY=parseInt(sdate[2]);  //Year
                var sM=parseInt(sdate[1])+1;  //Month
                var sD=parseInt(sdate[0]);  //Date

                var ctr=0;

                if(sY<CY){
                    ctr=1;
                }else if(sY==CY && sM<CM){
                    ctr=1;
                }else if(sY==CY && sM==CM && sD<CD){
                    ctr=1;
                }
                if(ctr==1){
                    $('#frmDateEnd').val(StartDate);
                    alert('End Date should be greater than or equal to Start Date');

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
                            <h1>Edit Banner</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>                            
                            <li><a href="cms_manage_uil.php">Content</a><i class="icon-angle-right"></i></li>
                            <li><a href="special_banner_manage_uil.php">Manage Banner</a><i class="icon-angle-right"></i></li>                            
<!--                            <li><a href="special_banner_edit_uil.php?id=<?php echo $_GET['id']; ?> &type=edit">Edit Banner</a></li>-->
                            <li><span>Edit Banner</span></li>
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
                                        <?php
                                        if ($objCore->displaySessMsg()) {
                                            echo $objCore->displaySessMsg();
                                            $objCore->setSuccessMsg('');
                                            $objCore->setErrorMsg('');
                                        }
                                        //pre($arrRow);
                                        ?>
                                        <div class="box box-color box-bordered">
                                            <div class="box-title">
                                                <h3>Edit Banner</h3>
                                            </div>
                                            <div class="box-content nopadding">
                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-home-slider', $_SESSION['sessAdminPerMission'])) { ?>
                                                    <form action="" method="post" id="frm_page" onsubmit="return validateBannerSpclPageForm(1);" enctype="multipart/form-data" > <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Banner Title:</label>
                                                                    <div class="controls">
                                                                        <input type="text" maxlength="50" name="frmTitle" id="frmTitle" value="<?php echo $arrRow[0]['BannerTitle']; ?>" class="input-large"/>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Banner Page:</label>
                                                                    <div class="controls">
                                                                        <select name="frmBannerPage" id="frmBannerPage" class="input-large">
                                                                            <option value="special" <?php if ($arrRow[0]['BannerPage'] == 'special') echo 'selected="selected"'; ?>>Special Page</option>
                                                                            <option value="landing" <?php if ($arrRow[0]['BannerPage'] == 'landing') echo 'selected="selected"'; ?>>Landing Page</option>
                                                                            <option value="reward" <?php if ($arrRow[0]['BannerPage'] == 'reward') echo 'selected="selected"'; ?>>Reward Page</option>
                                                                        </select>                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="control-group" id="eventPages" style="display:<?php echo $arrRow[0]['fkFestivalID']!=0?'block':'none';?>;">
                                                                    <label for="textfield" class="control-label">*Select Event:  </label>
                                                                    <div class="controls">
                                                                        <select name="frmBannerEvent" id="frmBannerEvent" class="input-large frmBannerEvent">
                                                                            <option value="Select Event">Select Event</option>
                                                                            <?php
                                                                            foreach($objPage->arrEventDropDown as $event){ ?>
                                                                             <option value="<?php echo $event['pkFestivalID'];?>" <?php echo ($arrRow[0]['fkFestivalID']==$event['pkFestivalID'])?'selected':'';?>><?php echo $event['FestivalTitle'];?></option>   
                                                                           <?php }
                                                                            ?>
                                                                        </select>  
                                                                       
                                                                    </div>
                                                                </div>
                                                                <div class="control-group" id="categoryPages" style="display:<?php echo $arrRow[0]['fkCategoryId']!=0?'block':'none';?>;" >
                                                                    <label for="textfield" class="control-label">*Select Category:  </label>
                                                                    <div class="controls">
                                                                        <?php
                                                                        $categoryPages = explode(',', $arrRow[0]['fkCategoryId']);
                                                                        echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId', 'frmCategory',$categoryPages, 'Select Category', '', '', 'style="height:350px;width:300px"');
                                                                        //echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', 'frmCategory', '', SEL_CAT, 1,'style="height:350px;width:300px"','1','2');
                                                                            ?>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Banner Image:</label>
                                                                    <div class="controls">
                                                                        <?php
                                                                        $varSrc = UPLOADED_FILES_URL . 'images/banner/' . $arrSpecialPageBannerImage['thumb'] . '/' . $arrRow[0]['BannerImageName'];
                                                                        ?>
                                                                        <img src="<?php echo $varSrc; ?>" /><br/>
                                                                        <input type="file" name="frmImg" id="frmImg" class="prod_img" />&nbsp;&nbsp;<span class="req" id="bannerMsg">Banner should be <?php echo ($arrRow[0]['BannerPage']=='reward')?$arrSpecialPageBannerImage['reward']:$arrSpecialPageBannerImage['big']; ?> px</span>
                                                                        <input type="hidden" name="frmImageName" value="<?php echo $arrRow[0]['BannerImageName']; ?>" />
                                                                    </div>
                                                                </div>
                                                                 <div class="control-group">
                                                                    <label for="textfield" class="control-label">Banner Link:</label>
                                                                    <div class="controls">
                                                                        <input type="url" maxlength="100" name="frmLink" id="frmLink" value="<?php echo $arrRow[0]['UrlLinks'];?>" class="input-large"/>&nbsp;&nbsp;<span class="req" id="bannerMsg">Banner link should be http://www.telamela.com.au</span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Show Dates:</label>
                                                                    <div class="controls">
                                                                        Start Date: <input type="text" name="frmDateStart" style="margin-right:10px" id="frmDateStart" class="input-small" value="<?php echo $objCore->localDateTime($arrRow[0]['BannerStartDate'], DATE_FORMAT_SITE); ?>" readonly />&nbsp;&nbsp;
                                                                        End Date: <input type="text" name="frmDateEnd" id="frmDateEnd" class="input-small" value="<?php echo $objCore->localDateTime($arrRow[0]['BannerEndDate'], DATE_FORMAT_SITE); ?>" readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Sort Order:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="frmBannerOrder" id="frmBannerOrder" value="<?php echo $arrRow[0]['BannerOrder'] ?>" class="input-medium" />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Status:</label>
                                                                    <div class="controls">
                                                                        <input type="radio" name="frmStaus" value="1" <?php
                                                                    if ($arrRow[0]['BannerStatus'] == 1) {
                                                                        echo 'checked="checked"';
                                                                    }
                                                                        ?> />Active &nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <input type="radio" name="frmStaus" value="0" <?php
                                                                           if ($arrRow[0]['BannerStatus'] == 0) {
                                                                               echo 'checked="checked"';
                                                                           }
                                                                        ?> />Deactive
                                                                    </div>
                                                                </div>

                                                                <div class="note">Note : * Indicates mandatory fields.</div>
                                                                <div class="form-actions">
                                                                    <input type="hidden" name="frmHidenEdit" value="edit" />
                                                                    <button name="frmBtnSubmit" type="submit" class="btn btn-blue" value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                    <a href="special_banner_manage_uil.php" class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></a>
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
                        <div style="display: none;">
                            <div id="col1"><textarea name="frmCoOrdinates[]" readonly="readonly"></textarea></div>
                            <div id="col2">
                                <select name="frmLinkType[]" class="input-small">
                                    <option value="">Select</option>
                                    <option value="Festival">Festival</option>
                                    <option value="Category">Category</option>
                                </select>
                            </div>
                            <div id="col3">
                                <input type="text" name="frmOffer[]" />
                            </div>
                            <div id="col4">
                                <textarea name="frmUrl[]" class="frm_url"></textarea>
                                <?php
                                //echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[][]', '', '', '', 1, 'style="height:200px;width:300px"');
                                ?>&nbsp;
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
