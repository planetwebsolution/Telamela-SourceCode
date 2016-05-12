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
        $(document).ready(function(){
            $('.frmRegionName').live('blur',function(){
                obj = $(this);
                $('.frmRegionName').each(function(){
                    var value = $(this).val();
                    if($(this).attr('id')!=obj.attr('id')){
                        if(value==obj.val()){
                            alert('Region Name Already Choosen!');
                            obj.focus();
                            chkAjax = false;
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
            if($('.form-horizontal .controls i').length)
                $('.form-horizontal .controls i:last').html('<a href="javascript:void(0)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a>');
            else
                $('.form-horizontal .controls #HideMe .add-rem').html('<a href="javascript:void(0)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a>');
        });
        $('#delNew').live('click',function(){
            $(this).parent().find('.delRegionID').val('1');
            $(this).parent().parent().prev().hide();
            $(this).parent().parent().hide();

            if($('.form-horizontal .controls i').length)
                $('.form-horizontal .controls i:last').html('<a href="javascript:void(0)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a>');
//            else
//                $('.form-horizontal .controls #HideMe .add-rem').html('<a href="javascript:void(0)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a>');
        });

        $('#addNew').live('click',function(){
            if($('.form-horizontal .controls i').length)
                $('.form-horizontal .controls i :first-child').html('');
            else
                $('.form-horizontal .controls #HideMe .add-rem').html('');
                   
              
            var html ='<div class="control-group"><tr class="content"><td valign="top" style="width:30%;"><label for="textfield" class="control-label">*Region: </label></td><td>   <div class="controls"><input class="frmRegionName" name="frmRegionName[]" id="frmRegionName" type="text" value="" /> <input type="hidden" class="pkRegionID" name="frmRegionId[]" value="0"  /></div></td></tr></div><div class="control-group"><tr class="content"><td valign="top" style="width:30%;"><label for="textfield" class="control-label">*Description:(List of Cities)</label></td><td>   <div class="controls"><textarea name="frmCities[]" rows="7" id="frmCities"></textarea><i><a href="javascript:void(0)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></i><span id="HideMe"><a href="javascript:void(0)" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></div> </td></tr></div>';

            // var html ='<div class="control-group"><label for="textfield" class="control-label">Region: </label><div class="controls"><input name="frmRegionName[]" id="frmRegionName'+elementCount+'" type="text" value="" class="input-xlarge"/></div></div><div class="control-group"><label for="textfield" class="control-label">*Description:(List of Cities)<span class="help-block">Seprated By comma (,):</span></label><div class="controls"><textarea name="frmCities[]" rows="10" class="input4" id="frmCities'+elementCount+'"></textarea><i><a href="javascript:void(0)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></i><span><a href="javascript:void(0)" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></span></div></div>';
            $(this).parent().parent().parent().parent().append(html);
        });

        $('#frmRegionAdd').submit(function(){

            var frmRegionName = document.getElementsByName('frmRegionName[]');
            var frmCities = document.getElementsByName('frmCities[]');
            var frmRegionImage = document.getElementById('frmRegionImage');

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
                            <h1>Manage Region</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="region_manage_uil.php">Regions</a><i class="icon-angle-right"></i></li>
                            <li><span>Edit Region</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="box box-bordered box-color top-box">
                                <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_BACK_BUTTON; ?>" style="float:right; margin:6px 2px 0 0; width:107px;"/></a>

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
                                                                Edit - Region
                                                            </h3>
                                                        </div>

                                                        <div class="box-content nopadding">

                                                            <?php require_once('javascript_disable_message.php'); ?>




                                                            <form action="" method="post" name="frmRegionAdd" id="frmRegionAdd" enctype="multipart/form-data" >
                                                                <?php
                                                                if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-regions', $_SESSION['sessAdminPerMission']))
                                                                {
                                                                    ?>

                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                            <div id="tblRegion">
                                                                                <div class="control-group">
                                                                                    <label for="textfield" class="control-label">*Country:   </label>
                                                                                    <div class="controls">
                                                                                        <?php echo $objPage->arrRow[0]['name']; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                                $varCounter = 0;
                                                                                foreach ($objPage->arrRow as $arrVal)
                                                                                {
                                                                                    $varCounter++;
                                                                                    ?>
                                                                                    <div class="control-group">
                                                                                        <label for="textfield" class="control-label">*Region: </label>
                                                                                        <div class="controls">
                                                                                            <input class="input-large" name="frmRegionName[]"  id="frmRegionName[<?php echo $arrVal['pkRegionID'] ?>]" type="text" value="<?php echo $arrVal['RegionName']; ?>" />
                                                                                            <input type="hidden" class="pkRegionID" name="frmRegionId[]" value="<?php echo $arrVal['pkRegionID'] ?>"  />


                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="control-group">
                                                                                        <label for="textfield" class="control-label">*Description:(List of Cities)<span class="help-block">Seprated By comma (,):</span></label>
                                                                                        <div class="controls" >
                                                                                            <textarea name="frmCities[]" rows="10" class="input-large" id="frmCities"><?php echo $arrVal['Cities']; ?></textarea>
                                                                                            <input type="hidden" class="delRegionID" name="delRegionID[]" value="0"  />
                                                                                            <?php
                                                                                            if ($varCounter != 1)
                                                                                            {
                                                                                                echo '<a href="javascript:void(0)" id="delNew" class="add-rem"><img src="images/minus.png" alt="Remove" title="Remove" /></a>';
                                                                                            }
                                                                                            ?>

                                                                                            <?php
                                                                                            if ($varCounter == count($objPage->arrRow))
                                                                                            {
                                                                                                echo '<span id="HideMe"><a href="javascript:void(0)" id="addNew" class="add-rem"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>

                                                                                <?php } ?>
                                                                            </div>


                                                                            <div class="control-group">
                                                                                <label for="" class="control-label">Image:</label>
                                                                                <div class="controls">

                                                                                    <input type="file" name="frmRegionImage" id="frmRegionImage" />
                                                                                   <br/>
                                                                                    <span>Max upload size is 5MB</span>    <br/>
                                                                                    <img src="<?php echo UPLOADED_FILES_URL; ?>images/regions/thumbs/<?php
                                                                            if (!empty($arrVal['image']))
                                                                            {
                                                                                echo $arrVal['image'];
                                                                            }
                                                                            else
                                                                            {
                                                                                echo "no-image.jpeg";
                                                                            }
                                                                                ?>" width="85" height="75" border="0" />

                                                                                </div>
                                                                            </div>

                                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                                            <div class="form-actions">

                                                                                <input type="submit" class="btn btn-blue" name="btnPage" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" style="float:left; margin:5px 15px 0 0; width:80px;"/>
                                                                                <a id="buttonDecoration" href="region_manage_uil.php" style="text-decoration: none;">
                                                                                    <input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="float:left; margin:5px 5px 0 0; width:80px;"/></a>
                                                                                <input type="hidden" name="frmHidenEdit" id="frmHidenEdit" value="edit" />
                                                                                <input type="hidden" name="countryId" id="countryId" value="<?php echo $_GET['countryId']; ?>" />
                                                                                <input type="hidden" name="frmRegionImage" id="frmRegionImage" value="<?php echo $objPage->arrRow[0]['image']; ?>" />

                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
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