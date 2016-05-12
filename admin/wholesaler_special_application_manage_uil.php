<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_SPECIAL_APPLICATION_CTRL;
//pre($_SESSION);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Wholesalers</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        
        <script>
            $(document).ready(function(){
                $('#cancelWarn').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            });
            function jscall(emailid,id){
                $(".warning").colorbox({inline:true, width:"500px", height:"290px"});
                $('#cancelWarn').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmWarning').click(function(){

                    var WarningMsg = document.getElementById('WarningMsg');
                    if(WarningMsg.value==''){
                        alert('Message is Required!');
                        WarningMsg.focus();
                        return false;
                    }else{
                        $('#listed_Warning').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SendWarningToWholesaler',msg:WarningMsg.value,emailid:emailid,id:id},
                        function(data)
                        {
                            //$('#listed_Warning').html(data);
                            $('#listed_Warning').html('<span class="green">Warning Sent Successfully </span>');
                            setTimeout(function a(){parent.jQuery.fn.colorbox.close();location.reload();}, 1500);

                        }
                    );
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function(){
                $('#cancelSus').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            });
            function jscall1(emailid,id){
                $(".suspend").colorbox({inline:true, width:"500px", height:"290px"});
                $('#cancelSus').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmSuspend').click(function(){

                    var SuspendMsg = document.getElementById('SuspendMsg');
                    if(SuspendMsg.value==''){
                        alert('Message is Required!');
                        WarningMsg.focus();
                        return false;
                    }else{
                        $('#listed_Suspend').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SuspendingWholesaler',msg:SuspendMsg.value,emailid:emailid,id:id},
                        function(data)
                        {
                            $('#listed_Suspend').html('<span class="green">Wholesaler Suspended.</span>');
                            setTimeout(function b(){parent.jQuery.fn.colorbox.close();location.reload();}, 1500);

                        }
                    );
                    }
                });
            }
        </script>
        <script>
            function changeStatus(status,id){
                var showid = '#wholesaler'+id;
                $.post("ajax.php",{action:'SpecialApplicationChangeStatus',status:status,id:id},

                function(data)
                {
                    $(showid).html(data);
                }
            );

            }
        </script>        
        <script>
            function  setEnquiryAction(value, formname,listname)
            {
                if($("input[name='frmID[]']").serializeArray().length == 0)
                {
                    $('#modal-1').show();

                    //message = " "+DELETED_SEL+listname;
                }else if($("input[name='frmID[]']").serializeArray().length > 0){

                    $('#modal-2').show();

                }else{
                    $('#modal-1').hide();


                }
            }

            function dele(id){
                $('#deltid').val(id);
                $('#modal-3').show();


            }
            function redir(){

                document.location.href = 'wholesaler_special_action.php?frmID='+$('#deltid').val()+'&frmChangeAction=Delete';

            }
            function popupClose(){

                $('#modal-1').hide();
                $('#modal-2').hide();
                $('#modal-3').hide();

            }

            function formSubmit(){

                document.getElementById('frmWholesalerList').submit();

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
                            <h1>Special Application</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-attributes', $_SESSION['sessAdminPerMission'])) { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li>
                                    <a href="dashboard_uil.php">Home</a>
                                    <i class="icon-angle-right"></i>
                                </li>
                                <li>
                                    <span>Special Application</span>
    <!--                                <i class="icon-angle-right"></i>-->
                                </li>

                            </ul>
                            <div class="close-bread">
                                <a href="#"><i class="icon-remove"></i></a>
                            </div>
                        </div>


                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div style="float:left">
                                    <button class="btn btn-inverse" onClick="showSearchBox('search','show');">Search Application</button>
                                </div>
                                <div class="fright">
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid" id="search">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Advance Search  </h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form id="frmSearch" method="get" action="" class='form-horizontal form-bordered' onSubmit="return dateCompare('frmSearch');">
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Wholesaler Name:  </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmName" value="<?php echo stripslashes($_GET['frmName']); ?>" class="input-large" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Country:  </label>
                                                        <div class="controls">
                                                            <select name="frmCountry" id="simg" class='select2-me input-large'>
                                                                <option value="0" <?php
                    if ($_GET['frmCountry'] == '0') {
                        echo 'Selected';
                    }
                        ?>>All Country</option>
                                                                        <?php foreach ($objPage->arrCountryList as $vCT) { ?>
                                                                    <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                    if ($_GET['frmCountry'] == $vCT['country_id']) {
                                                                        echo 'Selected';
                                                                    }
                                                                            ?>><?php echo html_entity_decode($vCT['name']); ?></option>
                                                                        <?php } ?>


                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Status: </label>
                                                        <div class="controls">

                                                            <select name="frmStatus" class='select2-me input-large nomargin'>
                                                                <option value="" <?php
                                                                    if ($_GET['frmStatus'] == '') {
                                                                        echo 'Selected';
                                                                    }
                                                                        ?>>All</option>
                                                                <option value="pending" <?php
                                                                    if ($_GET['frmStatus'] == 'pending') {
                                                                        echo 'Selected';
                                                                    }
                                                                        ?>>Pending</option>
                                                                <option value="Approved" <?php
                                                                    if ($_GET['frmStatus'] == 'Approved') {
                                                                        echo 'Selected';
                                                                    }
                                                                        ?>>Approved</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="form-actions span12  search">
                                                    <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                    <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                    <?php if ($_GET['frmSearch'] != '') { ?>
                                                        <input type="button" onClick="location.href = 'wholesaler_special_application_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                    <?php } else { ?>
                                                        <input type="button" onClick="showSearchBox('search','hide');" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                    <?php } ?>

                                                </div>
                                            </div>                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <?php
                                if ($objCore->displaySessMsg() <> '') {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
                                ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>
                                            Special Application
                                        </h3>
                                    </div>

                                    <div class="box-content nopadding manage_categories">
                                    	<!-- This div is added by Krishna Gupta for perfect paggination (08-10-15) -->
                                    	<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                    	<!-- This div is added by Krishna Gupta for perfect paggination (08-10-15) ends -->
                                        <table class="table table-hover table-nomargin table-bordered usertable">
                                            <form id="frmWholesalerList" name="frmWholesalerList" action="wholesaler_special_action.php" method="post">
                                                <?php if ($objPage->NumberofRows > 0) { ?>
                                                    <th class='with-checkbox hidden-480'>
                                                        <input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" />
                                                    </th>
                                                    <?php echo $objPage->varSortColumn; ?>
                                                    <th class='hidden-480'>Status</th>
                                                    <th>Action</th>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        //pre($objPage->arrRows);    
                                                        foreach ($objPage->arrRows as $val) {
                                                            ?>

                                                            <tr>
                                                                <td class="with-checkbox hidden-480">
                                                                    <input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkApplicationID']; ?>" onClick="singleSelectClick(this,'singleCheck');" class="singleCheck"/>
                                                                </td>
                                                                <td class="hidden-480"><?php echo $val['pkApplicationID']; ?></td>
                                                                <td class="hidden-480"><?php echo $val['TransactionID']; ?></td>
                                                                <td><?php echo $val['CompanyName']; ?></td>
                                                                <!--<td class="hidden-480"><?php echo $val['FestivalTitle'];  ?></td>-->
                                                                <td><a href="<?php echo $objCore->getUrl('special.php', array('name' => $val['FestivalTitle'],'cid'=>$val['fkFestivalID'])); ?>" target="_bank" class="whl-app-link"><?php echo $val['FestivalTitle']; ?></a></td>
                                                                <td class="hidden-1024"><?php echo $val['CountryName']; ?></td>
                                                                <td class="hidden-480"><?php echo ADMIN_CURRENCY_SYMBOL . number_format($val['TotalAmount'], 2); ?></td>
                                                                <td class="hidden-1024"><?php echo $objCore->localDateTime($val['ApplicatonDateAdded'], DATE_FORMAT_SITE); ?></td>
                                                                <td class="hidden-480">
                                                                    <span id="wholesaler<?php echo $val['pkApplicationID']; ?>">
                                                                        <?php
                                                                        if ($val['IsApproved'] == 'Pending') {
                                                                            echo "<span class='label'>Pending</span>";
                                                                            ?>
                                                                            <a href="javascript:void(0);" class="active" onClick="changeStatus('Approved',<?php echo $val['pkApplicationID']; ?>)" title="Click here to approve.">Approve</a>
                                                                            <?php
                                                                        } else if ($val['IsApproved'] == 'Approved') {
                                                                            echo "<span class='label label-satgreen'>Approved</span>";
                                                                        }
                                                                        ?>
                                                                </td>
                                                                <td>
                                                                    <a class="btn" href="wholesaler_special_application_view_uil.php?id=<?php echo $val['pkApplicationID']; ?>&type=view" rel="tooltip" title="" data-original-title="View"><i class="icon-eye-open"></i></a>&nbsp;
                                                                    <a class="btn" onClick="return dele('<?php echo $val['pkApplicationID']; ?>')" rel="tooltip" title="" data-original-title="Delete"><i class="icon-remove"></i></a>&nbsp;
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>

                                                        <?php
                                                        if (is_array($objPage->arrRows)) {
                                                            ?><tr class="content"><td colspan="10">
                                                            
                                                            		<!-- <div style="float:right;"> -->
                                                            		<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate" style="float:right;">
                                                                        <?php
                                                                        if ($objPage->varNumberPages > 1) {
                                                                            $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                                        }
                                                                        ?>
                                                                    </div>
                                                            		
                                                                    <div class="controls hidden-480">
                                                                        <select name="frmChangeAction" onChange="javascript: return setEnquiryAction(this.value, this.form, 'wholesalers');" ata-rule-required="true">
                                <!--                                        <select name="aaa" id="bbb" data-rule-required="true">-->
                                                                            <option value="">-- Select Action --</option>
                                                                            <option value="Delete All">Delete</option>
                                                                        </select>
                                                                        <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                                    </div>

                                                                    
                                                                </td></tr>    
                                                        <?php }
                                                        ?>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <tr class="content">
                                                            <td colspan="10" style="text-align:center">
                                                                <strong>No record(s) found.</strong>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                        	</form>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <?php } else { ?>
                        <table width="100%">
                            <tr>
                                <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                            <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                        </table>

                    <?php } ?>

                </div>
            </div>
              <?php require_once('inc/footer.inc.php'); ?>
        </div>

        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">X</button>
                <h3 id="myModalLabel">Delete Request</h3>
            </div>
            <div class="modal-body">
                <p>Please select at least one option to delete</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">OK</button>
                <!--				<button class="btn btn-primary" data-dismiss="modal">Save changes</button>-->
            </div>
        </div>

        <div id="modal-2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">X</button>
                <h3 id="myModalLabel">Delete Request</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Application?</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" onClick="return popupClose();">Cancel</button>
                <button class="btn btn-primary" data-dismiss="modal" onClick="formSubmit()">Delete</button>
            </div>
        </div>
        <div id="modal-3" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">X</button>
                <h3 id="myModalLabel">Delete Request</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Application?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="deltid" value=""/>
                <button class="btn" data-dismiss="modal" aria-hidden="true" onClick="return popupClose();">Cancel</button>
                <button class="btn btn-primary" data-dismiss="modal" onClick="redir()">Delete</button>
            </div>
        </div>



        <div style='display:none'>
            <div id='listed_Warning'>
                <table id="colorBox_table">
                    <tr align="left">
                        <td style="font-family: Arial,Helvetica,sans-serif; font: 12px;">Write Message:</td>
                    </tr>
                    <tr>
                        <td align="left"><textarea name="WarningMsg" id="WarningMsg" rows="8" class="input4"></textarea></td>
                    </tr>
                    <tr>
                        <td align="left"><input type="submit" name="frmConfirmWarning" id="frmConfirmWarning" value="Send Message" style="cursor: pointer;"/>
                            &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelWarn" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="cursor: pointer;"/> </td>
                    </tr>

                </table>

            </div>
        </div>
        <div style='display:none'>
            <div id='listed_Suspend'>
                <table id="colorBox_table">

                    <tr align="left">
                        <td style="font-size:18px; font-weight: bold;">Do you wish to suspend this Wholesaler?</td>
                    </tr>

                    <tr align="left">
                        <td style="font-family: Arial,Helvetica,sans-serif; font:12px;">Write Message:</td>
                    </tr>
                    <tr>
                        <td align="left"><textarea name="SuspendMsg" id="SuspendMsg" rows="4" class="input4"></textarea></td>
                    </tr>
                    <tr>
                        <td align="left">
                            <input type="submit" name="frmConfirmSuspend" id="frmConfirmSuspend" value="Suspend" style="cursor: pointer;"/>
                            &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelSus" value="Ignore" style="cursor: pointer;"/> </td>
                    </tr>

                </table>

            </div>
        </div>
        <script type="text/javascript">
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') { ?>
        showSearchBox('search', 'show');
<?php } else { ?>
        showSearchBox('search', 'hide');
<?php } ?>
        </script>
    </body>
</html>