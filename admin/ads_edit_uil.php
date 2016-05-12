<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ADS_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Add Advertisement </title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
            Cal=jQuery.noConflict();
            Cal(document).ready(function(){
                Cal('#frmDateStart').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif"  alt="Popup" style=" margin: -1px 0 0 -31px;" class="trigger">',onSelect:calEqual,minDate: new Date()});
                Cal('#frmDateEnd').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" style=" margin:-1px 0 0 -25px"  class="trigger">',onSelect:calDateCompare,minDate: new Date()});
                   
            });
        </script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            function showFormDetails(str){
                var cd;
                if(str=='html'){
                    cd = ' <div class="control-group"><label for="textfield" class="control-label">*Html Code:</label><div class="controls"><textarea name="frmHtmlCode" id="frmHtmlCode" class="input-block-level" rows="6" ></textarea></div></div>';
                }else{
                    cd = '<div class="control-group"><label for="textfield" class="control-label">*URL Link:</label><div class="controls"><input type="text" name="frmAdUrl" id="frmAdUrl" value="" class="input4"/><span class="req">EX. http://www.example.com</span></div></div><div class="control-group"><label for="textfield" class="control-label">*Image:</label><div class="controls"><input type="file" name="frmImg" id="frmImg" value="" /></div></div>';
                }          
                $('#showDetails').html(cd);
            }  
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
                    alert('End Date should be less than or equal to Start Date');
                }
            }
        </script>
        <script type="text/javascript">
            $(function() {
                var addDiv = $('#addDropDown');
                var i = $('#addDropDown p').size() + 1;
                var asc ='';
                
                $('#addNewDrop').live('click', function() {
                    $('#addDropDown p:last span').html('');   
                    $.post("ajax.php",{action:'ShowCategory'},
                    function(data)
                    {asc = data;   
                        $('<p>'+asc+'&nbsp;<span><a href="#" id="addNewDrop"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNewDrop"><img src="images/minus.png" alt="Remove" title="Remove" /></a> </p>').appendTo(addDiv);
                    }
                );
                   
                    i++;
	 
                    return false;
                });
	 
                $('#remNewDrop').live('click', function() {
                    if( i > 2 ) {
                        $(this).parents('p').remove();
                        i--;
                        $("#addDropDown p:last span").html('<span><a href="#" id="addNewDrop"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>');
                    }
                    return false;
                });
            });
            function getCategoryPagesDropDown(page)
            {
                var frmImageSize = "";
		
                if(page=='Home Page') frmImageSize = "<?php echo ADS_IMAGE_RESIZE1; ?>";
                if(page=='Product Listing Page') frmImageSize = "<?php echo ADS_IMAGE_RESIZE2; ?>";
                if(page=='Menu Category Image') frmImageSize = "<?php echo ADS_IMAGE_RESIZE3; ?>";
                if(page=='Product Detail Page') frmImageSize = "<?php echo ADS_IMAGE_RESIZE4; ?>";
                document.getElementById('frmImageSize').value = frmImageSize;
                if(page!='Home Page'){
                    document.getElementById('countryIds').style.display = 'none';
                }else{
                    document.getElementById('countryIds').style.display = 'block';
                }
                if(page == 'Product Listing Page' || page == 'Menu Category Image')
                {
                    document.getElementById('categoryPages').style.display = ''; 
                }
                else
                {
                    document.getElementById('categoryPages').style.display = 'none'; 
                }
            }
	 
        </script>
        <script type="text/javascript">
            var url = window.URL || window.webkitURL;
            $(document).ready(function(){
                var getAll='<?php echo $objPage->arrRow[0]['countryIds'];?>';
                if(getAll==0){
                  $('#frmCountry').find('option:eq(0)').text('Reset Country');
                 $('#frmCountry').find('option:gt(0)').attr('disabled','disabled'); 
                }
                $('.prod_img').live('change',function(){
                    var dd = $(this);
                    var name = dd.attr('name'); 
                    var Img = $('#frmAdsPage').val();
                    if(Img == 'Product Listing Page')
                    {
                        var hgt = 117;
                        var wth = 158;
                    }
                    else if(Img == 'Menu Category Image')
                    {
                        var hgt = 117;
                        var wth = 243;
                    }
                    else if(Img == 'Product Detail Page')
                    {
                        var hgt = 207;
                        var wth = 264;
                    }
                    else 
                    {
                        var hgt = 160;
                        var wth = 276;
                    }
                    if( this.disabled ){
                        alert('Your browser does not support File upload.');
                    }else{
                        var chosen = this.files[0];
                        var image = new Image();
                        image.onload = function() {
                            if(this.height > hgt || this.width > wth ||this.height < hgt || this.width < wth ){
                                alert('Please upload image of ('+wth+')px width and ('+hgt+')px height!');
                                $('#frmImg').val('');
                                this.focus(); 
                            }
			 
                        };
                        image.onerror = function() {
                            alert('Accepted Image formats are: jpg, jpeg, gif, png ');
                            $('#frmImg').val('');
                        };
                        image.src = url.createObjectURL(chosen); 
                    }    
                });
                $('#frmCountry').change(function(){ 
                 var str=""+$(this).val()+"";
                 var nStr=str.split(',');
                 if($(this).val()==0 || nStr[1]==0){
                 $('#frmCountry').find('option:eq(0)').text('Reset Country');
                 $('#frmCountry').find('option:gt(1)').removeAttr('selected');     
                 $('#frmCountry').find('option:gt(1)').attr('disabled','disabled');    
                     
                 }
                 if($(this).val()==''){
                 $('#frmCountry').find('option:gt(0)').removeAttr('disabled');
                 $('#frmCountry').find('option:eq(0)').text('Select Country');
                 }
                });
            });    
        </script>
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Edit Advertisement </h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="ads_manage_uil.php">Advertisement </a><i class="icon-angle-right"></i></li>
                            <!--<li><a href="ads_edit_uil.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>">Edit Advertisement </a></li>-->
                            <li><span>Edit Advertisement </span></li>
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
                                        if ($objCore->displaySessMsg())
                                        {
                                            echo $objCore->displaySessMsg();
                                            $objCore->setSuccessMsg('');
                                            $objCore->setErrorMsg('');
                                        }
                                        ?>
                                        <div class="box box-color box-bordered">
                                            <div class="box-title">
                                                <h3>Edit Advertisement</h3>                                                            
                                            </div>

                                            <div class="box-content nopadding"> 

<?php require_once('javascript_disable_message.php'); ?>


                                                <?php
                                                if ($_SESSION['sessUserType'] == 'super-admin' || in_array('add-ads', $_SESSION['sessAdminPerMission']))
                                                {

                                                    $isImg = ($objPage->arrRow[0]['ImageName'] == '') ? 0 : 1;
                                                    ?>
                                                    <form action=""  method="post" id="frm_page" onsubmit="return validateAdsAddPageForm('frm_page',<?php echo $isImg; ?>);" enctype="multipart/form-data" > <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Type:   </label>
                                                                    <div class="controls">
                                                                        <input type="radio" name="frmAdType" value="link" <?php
                                                    if ($objPage->arrRow[0]['AdType'] == 'link')
                                                    {
                                                        echo 'checked="checked"';
                                                    }
                                                    ?> onclick="showFormDetails('link')" checked="checked" class="input-large" />Custom Ads &nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <input type="radio" name="frmAdType" value="html" <?php
                                                                    if ($objPage->arrRow[0]['AdType'] == 'html')
                                                                    {
                                                                        echo 'checked="checked"';
                                                                    }
                                                                    ?> onclick="showFormDetails('html')"  class="input-large" />Html Code
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Title: </label>
                                                                    <div class="controls">
                                                                        <input type="text" maxlength="50" name="frmTitle" id="frmTitle" value="<?php echo $objPage->arrRow[0]['Title'] ?>" class="input-large"/>

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Page: </label>
                                                                    <div class="controls">
                                                                        <select name="frmAdsPage" id="frmAdsPage" style="width: 272px;" onchange="getCategoryPagesDropDown(this.value);" class='select2-me input-large'>
                                                                            <option value="Home Page" <?php
                                                                    if ($objPage->arrRow[0]['AdsPage'] == 'Home Page')
                                                                    {
                                                                        echo 'selected="selected"';
                                                                    }
                                                    ?>>Home Page(<?php echo ADS_IMAGE_RESIZE1; ?>)</option>
                                                                            <option value="Product Listing Page" <?php
                                                                                if ($objPage->arrRow[0]['AdsPage'] == 'Product Listing Page')
                                                                                {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>>Product Listing Page(<?php echo ADS_IMAGE_RESIZE2; ?>)</option>
                                                                            <option value="Menu Category Image" <?php
                                                                                if ($objPage->arrRow[0]['AdsPage'] == 'Menu Category Image')
                                                                                {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>>Menu Category Image(<?php echo ADS_IMAGE_RESIZE3; ?>)</option>
                                                                            <option value="Product Detail Page" <?php
                                                                                if ($objPage->arrRow[0]['AdsPage'] == 'Product Detail Page')
                                                                                {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>>Product Detail Page(<?php echo ADS_IMAGE_RESIZE4; ?>)</option>
                                                                        </select>
                                                                        <input type="hidden" name="frmImageSize" id="frmImageSize" value="<?php echo isset($objPage->arrRow[0]['ImageSize']) && $objPage->arrRow[0]['ImageSize'] != '' ? $objPage->arrRow[0]['ImageSize'] : ADS_IMAGE_RESIZE1; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="control-group" id="countryIds" style="<?php echo $objPage->arrRow[0]['AdsPage']!='Home Page'?"display:none":"display:block" ?>">
                                                                    
                                                                    <label for="textfield" class="control-label">*Select country: </label>
                                                                            <div class="controls">
                                                                                <?php  $varCountries=explode(',', $objPage->arrRow[0]['countryIds']);?>
                                                                                <select name="frmCountry[]" id="frmCountry" class="select2-m input-large" style="width:200px;height:300px;" multiple>
                                                                                    <option value="">Reset Country</option>
                                                                                    <option value="0" <?php echo $objPage->arrRow[0]['countryIds']==0 && $objPage->arrRow[0]['countryIds']!=''?'selected="selected"':'';?>>All Country</option>
                                                                                    <?php foreach ($objPage->arrCountry as $v) { ?>
                                                                                    <option value="<?php echo $v['country_id']; ?>" <?php echo in_array($v['country_id'], $varCountries)?'selected="selected"':''?>><?php echo $v['name']; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                           
                                                                            
                                                                        </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Advertisement Details:</label>
                                                                </div>
                                                                <div id="showDetails">
                                                                    <?php if ($objPage->arrRow[0]['AdType'] == 'html')
                                                                    { ?>
                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*Html Code: </label>
                                                                            <div class="controls">
                                                                                <textarea name="frmHtmlCode" id="frmHtmlCode" rows="10" class="input7"><?php echo $objPage->arrRow[0]['HtmlCode'] ?></textarea>
                                                                                <span class="req">EX. http://www.example.com</span>
                                                                            </div>
                                                                        </div>
    <?php }
    else
    { ?>
                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*URL Link: </label>
                                                                            <div class="controls">
                                                                                <input type="text" name="frmAdUrl" id="frmAdUrl" value="<?php echo $objPage->arrRow[0]['AdUrl'] ?>" class="input4"/>
                                                                                <span class="req">EX. http://www.example.com</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*Image:  </label>
                                                                            <div class="controls">
                                                                                <input type="file" name="frmImg" id="frmImg" class="prod_img"/>
                                                                                <input type="hidden" name="frmImageName" value="<?php echo $objPage->arrRow[0]['ImageName']; ?>"/>
                                                                    <?php
                                                                    $imgUrl = UPLOADED_FILES_URL . "images/ads/" . $objPage->arrRow[0]['ImageSize'] . "/" . $objPage->arrRow[0]['ImageName'];
                                                                    ?>
                                                                                <img src="<?php echo $imgUrl; ?>" width="30" height="30"/>

                                                                            </div>
                                                                        </div>
                                                                                <?php } ?>
                                                                </div>
                                                                <div class="control-group" id="categoryPages" <?php
                                                                            if ($objPage->arrRow[0]['AdsPage'] == 'Product Detail Page' || $objPage->arrRow[0]['AdsPage'] == 'Home Page')
                                                                            {
                                                                                echo "style='display:none'";
                                                                            }
                                                                            ?> ">
                                                                    <label for="textfield" class="control-label">*Select Category:  </label>
                                                                    <div class="controls">
                                                                        <div id="addDropDown">
                                                                            <p>
    <?php
    $categoryPages = explode(',', $objPage->arrRow[0]['CategoryPages']);
    echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', 'frmCategory', $categoryPages, '', 1, 'style="height:350px;width:300px"');
    //echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', 'frmCategory', $categoryPages, SEL_CAT, 1,'style="height:350px;width:300px"','1','2');
    //echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmCategoryId[]', '', array(0), SEL_CAT, 0, 'onchange="ShowProductForPackage(this.value,2);" class="select2-me" style="width:415px"', '1', '1');
    ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Date:</label>
                                                                    <div class="controls">
    <?php
    $varDateStart = $objCore->localDateTime($objPage->arrRow['0']['AdsStartDate'], DATE_FORMAT_SITE);
    $varDateEnd = $objCore->localDateTime($objPage->arrRow['0']['AdsEndDate'], DATE_FORMAT_SITE);
    ?>
                                                                        Start Date: <input type="text" name="frmDateStart" id="frmDateStart" style="margin-right:10px" class="input-small" value="<?php echo $varDateStart; ?>" readonly />&nbsp;&nbsp;
                                                                        End Date: <input type="text" name="frmDateEnd" id="frmDateEnd" class="input-small" value="<?php echo $varDateEnd; ?>" readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Ads Amount:<br><span class="req">(Price per day) </span> </label>
                                                                    <div class="controls">
                                                                        <input type="text" maxlength="50" name="frmAdsPrice" id="frmAdsPrice" value="<?php echo $objPage->arrRow['0']['AdsPrice']; ?>" class="input-small"/>
                                                                    </div>
                                                                </div>
                                                                 <div class="control-group" id="addOrderIds">
                                                                    <label for="textfield" class="control-label">Add Order: </label>
                                                                    <div class="controls">
                                                                        <select name="addOrder" id="addOrder" class='select2-me input-xlarge'>
                                                                            <option value="1" <?php echo ($objPage->arrRow['0']['addOrder']==1)?'selected="selected"':'';?>>1</option>
                                                                            <option value="2" <?php echo ($objPage->arrRow['0']['addOrder']==2)?'selected="selected"':'';?>>2</option>
                                                                            <option value="3" <?php echo ($objPage->arrRow['0']['addOrder']==3)?'selected="selected"':'';?>>3</option>
                                                                            <option value="4" <?php echo ($objPage->arrRow['0']['addOrder']==4)?'selected="selected"':'';?>>4</option>
                                                                            <option value="5" <?php echo ($objPage->arrRow['0']['addOrder']==5)?'selected="selected"':'';?>>5</option>
                                                                        </select>
<!--                                                                        <input type="hidden" name="frmImageSize" id="frmImageSize" value="<?php echo ADS_IMAGE_RESIZE1; ?>">-->
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Status:</label>
                                                                    <div class="controls">
                                                                        <input type="radio" name="frmStaus" value="1" <?php
    if ($objPage->arrRow[0]['AdStatus'] == 1)
    {
        echo 'checked="checked"';
    }
    ?> />Active &nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <input type="radio" name="frmStaus" value="0" <?php
    if ($objPage->arrRow[0]['AdStatus'] == 0)
    {
        echo 'checked="checked"';
    }
    ?> />Deactive
                                                                    </div>
                                                                </div>
                                                                <div class="note">Note : * Indicates mandatory fields.</div>

                                                                <div class="form-actions">
                                                                    <button name="btnPage" type="submit" class="btn btn-blue" style="width:80px;"  value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                    <a id="buttonDecoration" href="ads_manage_uil.php"><button name="frmCancel" type="button" value="Cancel" style="width:80px;"  class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>
                                                                    <input type="hidden" name="frmHidenEdit" id="frmHidenEdit" value="edit" />
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

    </body>
</html>
