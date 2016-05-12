<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SLIDER_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Add Home Banner</title>
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
            var url = window.URL || window.webkitURL;
            Cal(document).ready(function(){
                Cal('.prod_img').live('change',function(){
                    var dd = $(this);
                    var name = dd.attr('name');
                    var hgt = 382;
                    var wth = 864;

                    if( this.disabled ){
                        alert('Your browser does not support File upload.');
                    }else{
                        var chosen = this.files[0];
                        var image = new Image();
                        image.onload = function() {
                            if(this.height < hgt || this.width < wth){
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
            function calDateCompare(SelectedDates){

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
            function showFestival(cid,showId,selId){

                $.post("ajax.php",{action:'showFestival',cid:cid,selId:selId},
                function(data){
                    $('#'+showId).html(data);
                });
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
                            <h1>Add Home Banner</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="slider_manage_uil.php">Home Banner</a><i class="icon-angle-right"></i></li>
                            <li><span>Add Home Banner</span></li>
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
                                        ?>
                                        <div class="box box-color box-bordered">
                                            <div class="box-title">
                                                <h3>Add Home Banner</h3>
                                            </div>
                                            <div class="box-content nopadding">
                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('add-home-slider', $_SESSION['sessAdminPerMission'])) { ?>
                                                    <form action=""  method="post" id="frm_page" onsubmit="return validateBannerPageForm(0);" enctype="multipart/form-data" > <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                <?php if (isset($_POST['frmBtnSubmit'])) { ?>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Banner:</label>
                                                                        <div class="controls">
                                                                            <?php
                                                                            $varSrc = UPLOADED_FILES_URL . 'images/banner/600x400/' . $_POST['frmImageName'];
                                                                            ?>
                                                                            <input type="hidden" name="coords1" class="canvas-area" data-image-url="<?php echo $varSrc; ?>" value="30,30,60,30,60,60,30,60" />

                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Url Links:</label>
                                                                        <div class="controls">
                                                                            <table class="table table-hover table-nomargin table-bordered usertable" style="width: auto;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Category Name</th>
                                                                                        <th>Url</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php 
                                                                                    
                                                                                   
                                                                                    
                                                                                    if(count($objPage->arrFestivalCats)==0){ ?>
                                                                                        <tr>
                                                                                            <td>All category</td>
                                                                                            <td>
                                                                                                 <?php echo $objCore->getUrl('special.php',array('fname'=>$objPage->arrRow['BannerTitle'],'cid'=>0,'fid'=>$objPage->arrRow['fkFestivalID'])); ?>
                                                                                            </td>
                                                                                        </tr>
                                                                                   <?php }else{
                                                                                    
                                                                                    foreach ($objPage->arrFestivalCats as $val) { ?> 
                                                                                        <tr>
                                                                                            <td><?php echo $val['CategoryName']; ?></td>
                                                                                            <td>
                                                                                                <?php echo $objCore->getUrl('special.php', array('name' => $val['CategoryName'], 'cid' => $val['pkCategoryId'])); ?>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php } } ?>
                                                                                </tbody>
                                                                            </table>

                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Url Linking:</label>
                                                                        <div class="controls">
                                                                            <table class="table table-hover table-nomargin table-bordered usertable" id="HomeBannerTbl">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Image Position</th>
                                                                                        <!--<th>Offer</th>-->
                                                                                        <th>Url Link <small class="req">(EX. http://www.example.com)</small></th>
                                                                                        <th>Action<i r="0"></i></th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="add" />
                                                                    <input type="hidden" name="frmHidenStep" id="frmHidenStep" value="2" />
                                                                    <input type="hidden" name="frmImageName" value="<?php echo $_POST['frmImageName']; ?>" />
                                                                    <input type="hidden" name="frmTitle" id="frmTitle" value="<?php echo $_POST['frmTitle']; ?>"/>
                                                                    <input type="hidden" name="frmBannerOrder" id="frmBannerOrder" value="<?php echo $_POST['frmBannerOrder']; ?>"/>
                                                                    <input type="hidden" name="frmDateStart"value="<?php echo $_POST['frmDateStart']; ?>" />
                                                                    <input type="hidden" name="frmDateEnd" value="<?php echo $_POST['frmDateEnd']; ?>" />
                                                                    <input type="hidden" name="frmCountry" value="<?php echo $_POST['frmCountry']; ?>" />
                                                                    <input type="hidden" name="frmFestival" value="<?php echo $_POST['frmFestival']; ?>" />
                                                                    <input type="hidden" name="frmStaus" value="<?php echo $_POST['frmStaus']; ?>" />
                                                                <?php } else { ?>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Select Festival: </label>
                                                                        <div class="controls">
                                                                            <div style="float: left;margin-right: 10px;">
                                                                                <span style="color: #555555; ">Filter By country: </span>
                                                                                <select name="frmCountry" id="frmCountry" class="select2-m input-large" onchange="showFestival(this.value,'frmFestival',0)">
                                                                                    <option value="">Select Country</option>
                                                                                    <option value="0">All Country</option>
                                                                                    <?php foreach ($objPage->arrCountry as $v) { ?>
                                                                                        <option value="<?php echo $v['country_id']; ?>"><?php echo $v['name']; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <div style="float: left">
                                                                                <select name="frmFestival" id="frmFestival" class="select2-m input-large">
                                                                                    <option value="">Select Festival</option>
                                                                                    <?php foreach($objPage->arrFestival as $val){?>
                                                                                        <option value="<?php echo $val['pkFestivalID']; ?>"><?php echo $val['FestivalTitle']; ?></option>
                                                                                    <?php }?>
                                                                                </select>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Banner Title:</label>
                                                                        <div class="controls">
                                                                            <input type="text" maxlength="50" name="frmTitle" id="frmTitle" value="" class="input-large"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Banner Image:</label>
                                                                        <div class="controls">
                                                                            <input type="file" name="frmImg" id="frmImg" class="prod_img" />&nbsp;&nbsp;<span class="req">Banner should be 864x382 px</span>
                                                                            <input type="hidden" name="frmImageName" value="" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Show Dates:</label>
                                                                        <div class="controls">
                                                                            Start Date: <input type="text" name="frmDateStart" style="margin-right:10px" id="frmDateStart" class="input-small" value="<?php echo $objCore->localDateTime(date(DATE_FORMAT_SITE), DATE_FORMAT_SITE); ?>" readonly />&nbsp;&nbsp;
                                                                            End Date: <input type="text" name="frmDateEnd" id="frmDateEnd" class="input-small" value="<?php echo $objCore->localDateTime(date(DATE_FORMAT_SITE), DATE_FORMAT_SITE); ?>" readonly />
                                                                        </div>
                                                                    </div>
                                                                    <!--
                                                                     <div class="control-group">
                                                                         <label for="textfield" class="control-label">Country: </label>
                                                                         <div class="controls">
                                                                             <select name="frmCountry[]" id="frmCountry" multiple="" style="height: 300px;width: 300px;">
                                                                                 <option value="0">Default</option>
                                                                    <?php foreach ($objPage->arrCountry as $v) { ?>
                                                                                                                                                         <option value="<?php echo $v['country_id']; ?>"><?php echo $v['name']; ?></option>
                                                                    <?php } ?>
                                                                             </select>
                                                                         </div>
                                                                     </div>
                                                                    -->
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Sort Order:</label>
                                                                        <div class="controls">
                                                                            <input type="text" name="frmBannerOrder" id="frmBannerOrder" class="input-medium" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Status:</label>
                                                                        <div class="controls">
                                                                            <input type="radio" name="frmStaus" value="1" checked="checked" />Active &nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="radio" name="frmStaus" value="0" />Deactive
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="frmHidenStep" id="frmHidenStep" value="1" />
                                                                <?php } ?>
                                                                <div class="note">Note : * Indicates mandatory fields.</div>
                                                                <div class="form-actions">
                                                                    <button name="frmBtnSubmit" type="submit" class="btn btn-blue" value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                    <a href="slider_manage_uil.php" class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></a>
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
