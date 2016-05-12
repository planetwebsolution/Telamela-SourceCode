<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_REGION_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Add - Region</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <style type="text/css">
            <!--
            .style1 {color: #FF0000}
            -->
        </style>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.3.2.min.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />

    </head>
    <body>
        <script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            var frmValidate = true;
            var chkAjax = true;
            var elementCount = 1;
            $(document).ready(function(){
                $('.frmRegionName').live('blur',function(){
                    obj = $(this);
                    $('.frmRegionName').each(function(){
                        if($(this).attr('id')!=obj.attr('id')){
                            var value = $(this).val();

                            if(value==''){
                                return false;
                            }
                            if(value==obj.val()){
                                alert('Region Name Already Choosen!');
                                obj.focus();
                                chkAjax = false;
                                frmValidate = false;
                            }
                        }
                    });

                    if(chkAjax==true){
                        var regionName = $(this).val();
                        var regionId = $(this).parent().find('.pkRegionID').val();
                        $.ajax({
                            url: "ajax.php",
                            type:'POST',
                            data:{regionName:regionName,action:'checkExistRegion',regionId:regionId},
                            success:function(data) {
                                if(data!=0){
                                    frmValidate = false;
                                    alert('Region Name Already Exists \nPlease choose another!');
                                    obj.focus();
                                }else{
                                    frmValidate = true;
                                }
                            }
                        })
                    }
                });

                $('#remNew').live('click',function(){
                    $(this).parent().parent().parent().prev().remove();
                    $(this).parent().parent().parent().remove();
                    // $('#tblRegion:last i').html('<a href="javascript:void(0)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a>');
                    $('.form-horizontal .controls i:last').html('<a href="javascript:void(0)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a>');

                });

                $('#addNew').live('click',function(){

                    elementCount++;
                    $('#tblRegion:last i').html('');
                    var html ='<div class="control-group"><label for="textfield" class="control-label">Region: </label><div class="controls"><input name="frmRegionName[]" id="frmRegionName'+elementCount+'" type="text" value="" class="input-large"/></div></div><div class="control-group"><label for="textfield" class="control-label">*Description:(List of Cities)<span class="help-block">Seprated By comma (,):</span></label><div class="controls"><textarea name="frmCities[]" rows="10" class="input4" id="frmCities'+elementCount+'"></textarea><i><a href="javascript:void(0)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></i><span><a href="javascript:void(0)" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></span></div></div>';
                    $('#tblRegion').append(html);

                });

                $('#frmRegionAdd').submit(function(){
                    var frmRegionCountry = document.getElementById('frmCountry');
                    var frmRegionName = document.getElementsByName('frmRegionName[]');
                    var frmCities = document.getElementsByName('frmCities[]');
                    var frmRegionImage = document.getElementById('frmRegionImage');
                    
                    if(frmRegionCountry.value==''){
                        alert('Country is required!');
                        frmRegionCountry.focus();
                        return false;
                    }
                    
                    for(var i = 0; i < frmRegionName.length; i++) {
                        if(frmRegionName[i].value == ''){
                            alert('Region is required !');
                            frmRegionName[i].focus();
                            return false;
                        }else if(frmCities[i].value == ''){
                            alert('Description is required !');
                            frmCities[i].focus();
                            return false;
                        }
                    }
                    if(frmRegionImage.value!=''){
                        var ff = frmRegionImage.value;
                        var exte = ff.substring(ff.lastIndexOf('.') + 1);
                        var ext = exte.toLowerCase();
                        if(ext!='jpg' && ext!='jpeg' && ext!='gif' && ext!='png'){
                            alert('Accepted Image formats are: jpg, jpeg, gif, png');
                            frmRegionImage.focus();
                            return false;
                        }
                    }
                });
            });
        </script>
        <?php require_once 'inc/header_new.inc.php'; ?>



        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Add New Region</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="region_manage_uil.php">Regions</a><i class="icon-angle-right"></i></li>
                            <li><span>Add Region</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="box box-bordered box-color top-box">
                                <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_BACK_BUTTON; ?>" style="float:right; margin:6px 30px 0 0; width:107px;"/></a>

                                <div class="box-content nopadding">

                                    <div class="tab-content padding tab-content-inline tab-content-bottom">
                                        <div class="tab-pane active" id="tabs-2">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <?php
                                                    if ($objCore->displaySessMsg())
                                                    {
                                                        ?>

                                                        <?php
                                                        echo $objCore->displaySessMsg();
                                                        $objCore->setSuccessMsg('');
                                                        $objCore->setErrorMsg('');
                                                        ?>

                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="box box-color box-bordered">
                                                        <div class="box-title">
                                                            <h3>
                                                                Add - Region
                                                            </h3>
                                                        </div>

                                                        <div class="box-content nopadding">

<?php require_once('javascript_disable_message.php'); ?>




                                                            <form action="" method="post" name="frmRegionAdd" id="frmRegionAdd" enctype="multipart/form-data" >
<?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('add-regions', $_SESSION['sessAdminPerMission']))
{ ?>

                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                            <div id="tblRegion">
                                                                                <div class="control-group">
                                                                                    <label for="textfield" class="control-label">*Country:   </label>
                                                                                    <div class="controls">
                                                                                        <select name="frmCountry" id="frmCountry" class='select2-me input-large'>
                                                                                            <option value="">Select Country</option>
                                                                                            <?php
                                                                                            foreach ($objPage->varCountryList as $val)
                                                                                            {
                                                                                                echo '<option value="' . $val['country_id'] . '">' . $val['name'] . '</option>';
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="control-group">
                                                                                    <label for="textfield" class="control-label">*Region: </label>
                                                                                    <div class="controls">
                                                                                        <input name="frmRegionName[]" id="frmRegionName" type="text" value="" class="input-large"/>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="control-group">
                                                                                    <label for="textfield" class="control-label">*Description:(List of Cities)<span class="help-block">Seprated By comma (,):</span></label>
                                                                                    <div class="controls" >
                                                                                        <textarea name="frmCities[]" rows="10" class="input-large" id="frmCities"></textarea>

                                                                                        <i><a href="javascript:void(0)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></i>
                                                                                    </div>
                                                                                </div>


                                                                            </div>


                                                                            <div class="control-group">
                                                                                <label for="" class="control-label">Image:</label>
                                                                                <div class="controls">

                                                                                    <input type="FILE" name="frmRegionImage" id="frmRegionImage" />
                                                                                    <br/>
                                                                                    <span>Max upload size is 5MB</span>

                                                                                </div>
                                                                            </div>

                                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                                            <div class="form-actions">

                                                                                <input type="submit" class="btn btn-blue" name="btnPage" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" style="float:left; margin:5px 15px 0 0; width:80px;"/>
                                                                                <a id="buttonDecoration" href="region_manage_uil.php" style="text-decoration: none;">
                                                                                    <input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="float:left; margin:5px 5px 0 0; width:80px;"/></a>
                                                                                <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="add" />

                                                                            </div>


                                                                        </div>
                                                                    </div>
<?php }
else
{ ?>
                                                                    <table cellpadding="0" cellspacing="0" border="0" class="left_content" style="width:45%" >
                                                                        <tr>
                                                                            <th align="left"><br /><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                                                                        <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                                                                    </table>
<?php } ?>

                                                            </form>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

<?php require_once('inc/footer.inc.php'); ?>
        </div>

    </body>
</html>