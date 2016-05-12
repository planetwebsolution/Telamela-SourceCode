<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_KPI_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Wholesalers Kpi</title>        
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#cancelWarn').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            });
            function jscall(emailid,id,warnNo,kpi){
                $.post("ajax.php",{action:'getWarningTemplateForWholesaler',emailid:emailid,id:id,warnNo:warnNo,kpi:kpi},
                		function (data) {
                    $('#WarningMsg').html(data);
                    var editor = CKEDITOR.instances['WarningMsg'];
					//var editor = CKEDITOR.editor.replace('WarningMsg');
					
                    if (editor) {
					
                        editor.destroy(true);
                    }
                    CKEDITOR.replace('WarningMsg', {
                    //CKEDITOR.replace('WarningMsg', {
                        
                        enterMode: CKEDITOR.ENTER_BR,
                        toolbar: [['Bold'], ['Italic'], ['Strike'], ['RemoveFormat'], ['NumberedList'], ['BulletedList'], ['Link'], ['Unlink'],
                            ['Table'], ['TextColor'], ['BGColor'], ['FontSize'], ['Font'], ['Styles']]
                    });

                    $('#modal-2').show();
                });
                //function(data){
                    // alert(data);
                    //$('#WarningMsg').html(data);
                   // $('#WarningMsg').html(data);                     
                    //CKEDITOR.replace('WarningMsg', {
                      //  enterMode: CKEDITOR.ENTER_BR,
                        //toolbar :[['Bold'],['Italic'],['Strike'],['RemoveFormat'],['NumberedList'],['BulletedList'],['Link'],['Unlink'],
                          //  ['Table'],['TextColor'],['BGColor'],['FontSize'],['Font'],['Styles']]
                    //});
                   // $('#modal-2').show();
                //});
               
                //$(".warning").colorbox({inline:true, width:"500px", height:"290px"});
                $('#cancelWarn').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmWarning').click(function(){
					
					 //var value = CKEDITOR.instances['DOM-ID-HERE'].getData()
                    var WarningMsg = CKEDITOR.instances.WarningMsg.getData(); //$('#WarningMsg').html();
                    //alert(WarningMsg);
                  
                    if(WarningMsg==''){
                        alert('Message is Required!');
                        $('#WarningMsg').focus();
                        return false;
                    }else{
                        $('#listed_Warning').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SendWarningToWholesaler',msg:WarningMsg,emailid:emailid,id:id,warnNo:warnNo},
                        function(data){
                            $('#listed_Warning').html(data);
                            $('#listed_Warning').html('<span class="green">Warning Sent Successfully </span>');                            
                            setTimeout(function a(){$('#modal-2').hide();location.reload();}, 1500);
                            

                        });
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
                $('#modal-1').show();
                // $(".suspend").colorbox({inline:true, width:"500px", height:"290px"});
                $('#cancelSus').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmSuspend').click(function(){

                    var SuspendMsg = document.getElementById('SuspendMsg');
                    if(SuspendMsg.value==''){
                        alert('Message is Required!');
                        SuspendMsg.focus();
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
            function popupClose1(){
            
                $('#modal-1').hide();
                $('#modal-2').hide();
            
                return false;
            
            }
        </script>
        <script>
            function changeStatus(status,emailid,id){
                var showid = '#wholesaler'+id;
                $.post("ajax.php",{action:'WholesalerChangeStatus',status:status,emailid:emailid,id:id},

                function(data)
                {
                    $(showid).html(data);
                }
            );

            }
        </script>
        <script>
            function changeAction(status,emailid,id){

                $.post("ajax.php",{action:'WholesalerChangeStatus',status:status,emailid:emailid,id:id},

                function(data)
                {
                    //$('#criA'+id).html(data);
                    location.reload();

                }
            );

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
                            <h1>Wholesalers Kpi</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-wholesalers', $_SESSION['sessAdminPerMission'])) { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>	
                                <li><span>Wholesalers Kpi</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>					
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">                                                            	
                                    <button class="btn btn-inverse" onClick="showSearchBox('search','show');">Search</button>

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
                                        <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered">    
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Wholesaler Name:  </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmName" value="<?php echo stripslashes($_GET['frmName']); ?>" class="input-large"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span3">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label"> Country Portal: </label>
                                                        <div class="controls">
                                                            <select name="frmCountryPortal" class="select2-me input-large">
                                                                <option value="0-0-0" <?php
                    if ($_GET['frmCountryPortal'] == '0-0-0') {
                        echo 'Selected';
                    }
                        ?>>All Portal</option>
                                                                        <?php
                                                                        foreach ($objPage->CountryPortal as $valCP) {
                                                                            $optVal = $valCP['pkAdminID'] . '-' . $valCP['AdminCountry'] . '-' . $valCP['AdminRegion'];
                                                                            ?>
                                                                    <option value="<?php echo $optVal; ?>" <?php
                                                                    if ($_GET['frmCountryPortal'] == $optVal) {
                                                                        echo 'Selected';
                                                                    }
                                                                            ?>><?php echo $valCP['AdminUserName']; ?></option>
                                                                        <?php } ?>
                                                            </select>

                                                        </div>  
                                                    </div>
                                                </div>

                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Status: </label>
                                                        <div class="controls">
                                                            <select name="frmStatus" class="select2-me input-large">
                                                                <option value="active" <?php
                                                                    if ($_GET['frmStatus'] == 'active') {
                                                                        echo 'Selected';
                                                                    }
                                                                        ?>>Active</option>
                                                                <option value="deactive" <?php
                                                                    if ($_GET['frmStatus'] == 'deactive') {
                                                                        echo 'Selected';
                                                                    }
                                                                        ?>>Deactive</option>
                                                                <option value="suspend" <?php
                                                                    if ($_GET['frmStatus'] == 'suspend') {
                                                                        echo 'Selected';
                                                                    }
                                                                        ?>>Suspend</option>
                                                            </select>

                                                        </div>  
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Email: </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmEmail" value="<?php echo stripslashes($_GET['frmEmail']); ?>"  class="input-large"/>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span3">
                                                    <div class="control-group" class="select2-container input-xlarge nomargin">
                                                        <label for="textfield" class="control-label">Country: </label>
                                                        <div class="controls">
                                                            <select name="frmCountry" class="input-large select2-me">
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
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">     
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <?php if ($_GET['frmSearch'] != '') { ?>
                                                            <input type="button" onClick="location.href = 'wholesaler_kpi_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />                                                                       
                                                        <?php } else { ?>
                                                            <input type="button" onClick="showSearchBox('search','hide');" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />	
                                                        <?php } ?>
                                                    </div>
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
                                            Wholesaler Kpi
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">  
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) { ?>
                                                <form id="frmWholesalerList" name="frmWholesalerList" action="wholesaler_action.php" method="post">                                         
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>    
                                                            <tr>
                                                                <?php echo $objPage->varSortColumn; ?>
                                                                <th class='hidden-1024'>Country Portal</th>
                                                                <th class='hidden-480'>KPI (%)</th>
                                                                <th class='hidden-480'><?php echo WARNING1; ?></th>
                                                                <th class='hidden-480'><?php echo WARNING2; ?></th>
                                                                <th class='hidden-480'><?php echo WARNING3; ?></th>
                                                                <th>Status</th>
                                                                <th class="hidden-480">Actions</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $val['pkWholesalerID']; ?></td>
                                                                    <td><?php echo $val['CompanyName']; ?></td>
                                                                    <td class="hidden-1024"><?php echo $val['CountryRegionPortalUser'] . ' ' . $val['CountryRegionPortal']; ?></td>                                            
                                                                    <td class="hidden-480"><?php echo $val['kpi']; ?></td>
                                                                    <td class="hidden-480"><?php echo ($val['warning'] > 0) ? 'Sent' : 'Not Yet'; ?></td>
                                                                    <td class="hidden-480"><?php echo ($val['warning'] > 1) ? 'Sent' : 'Not Yet'; ?></td>
                                                                    <td class="hidden-480"><?php echo ($val['warning'] > 2) ? 'Sent' : 'Not Yet'; ?></td>
                                                                    <td>
                                                                        <span id="wholesaler<?php echo $val['pkWholesalerID']; ?>">
                                                                            <?php
                                                                            if ($val['WholesalerStatus'] == 'reject') {
                                                                                echo "<span class='red'>Rejected</span>";
                                                                                ?>
                                                                                <a href="javascript:void(0);" class="active" onClick="changeStatus('approve','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)" title="Click here to approve this wholesaler.">Approve</a>
                                                                                <?php
                                                                            } elseif ($val['WholesalerStatus'] == 'pending') {
                                                                                echo "<span class='yellow'>Pending</span>";
                                                                                ?>
                                                                                <a href="javascript:void(0);" class="active" onClick="changeStatus('approve','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)" title="Click here to approve this wholesaler.">Approve</a>
                                                                                <a href="javascript:void(0);" class="active" onClick="changeStatus('reject','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)" title="Click here to reject this wholesaler.">Reject</a>
                                                                            <?php } else { ?>
                                                                                <?php if ($val['WholesalerStatus'] != 'active') { ?><a href="javascript:void(0);" class="active" onClick="changeStatus('active','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)" title="Click here to active this wholesaler.">Active</a><?php
                                                            } else {
                                                                echo "<span class='label label-satgreen'>Active</span>";
                                                            }
                                                                                ?>
                                                                                <?php if ($val['WholesalerStatus'] != 'deactive') { ?><a href="javascript:void(0);" class="deactive" onClick="changeStatus('deactive','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)" title="Click here to deactive this wholesaler.">Deactive</a><?php
                                                            } else {
                                                                echo "<span class='label label-lightred'>Deactive</span>";
                                                            }
                                                                                ?>
                                                                                <?php
                                                                                if ($val['WholesalerStatus'] == 'suspend') {
                                                                                    echo "<span class='label'>Suspend</span>";
                                                                                }
                                                                                ?>
                                                                            <?php } ?>

                                                                    </td>

                                                                    <td class="hidden-480">
                                                                        <?php if ($val['warning'] > 2) { ?>
                                                                            <a href="#" onClick="return alert('Three warning has been sent to wholesaler !');"><span class="req">Send warning</span></a>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <a class="warning cboxElement" href="#listed_Warning" onClick="return jscall('<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>,<?php echo $val['warning']; ?>,'<?php echo $val['kpi']; ?>')"><span class="req">Send warning</span></a>

                                                                        <?php }
                                                                        ?>

                                                                        <br>
                                                                        <span id="criA<?php echo $val['pkWholesalerID']; ?>">
                                                                            <?php if ($val['WholesalerStatus'] == 'suspend') { ?><a href="#listed_Suspend" onClick="changeAction('active','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)"><span>Revoke Suspension</span></a>
                                                                            <?php } else { ?>
                                                                                <a class="suspend cboxElement" href="#listed_Suspend" onClick="return jscall1('<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)"><span>Suspend</span></a>
                                                                            <?php } ?></span>

                                                                    </td>
                                                                </tr>

                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                        </tbody>                                       
                                                    </table>
                                                    <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><?php
                                                    if ($objPage->varNumberPages > 1) {
                                                        $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                    }
                                                            ?></div>                            
                                                </form>
                                            <?php } else { ?>
                                                <table class="table table-hover table-nomargin table-bordered usertable">
                                                    <tr class="content">
                                                        <td colspan="10" style="text-align:center">
                                                            <strong>No record(s) found.</strong>
                                                        </td>
                                                    </tr>
                                                </table>        
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <table width="100%">
                        <tr>
                            <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th>
                        </tr>
                        <tr>
                            <td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td>
                        </tr>
                    </table>
                <?php } ?>
            </div>
            <?php require_once('inc/footer.inc.php'); ?>
        </div>
        <script type="text/javascript">
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') { ?>
        showSearchBox('search', 'show');
<?php } else { ?>
        showSearchBox('search', 'hide');
<?php } ?>
        </script>


        <div id="modal-2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px; height: 500px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose1()">X</button>
                <h3 id="myModalLabel">Do you wish to send warning to this Wholesaler?</h3>
            </div>
            <div id="listed_Warning"></div>
            <div class="modal-body" style="padding-left:42px;padding-right:10px;">
                <div class="rowlbinp">
                    <div class="lbl"><strong>*Write Message:</strong></div>
                    <textarea name="WarningMsg" id="WarningMsg" rows="8" class="input-block-level"></textarea>
                </div>
            </div>
            <div class="modal-footer">

                <input  class="btn btn-primary" type="submit" name="frmConfirmWarning" id="frmConfirmWarning" value="Send Message" style="cursor: pointer;"/>
                &nbsp;&nbsp;<input class="btn" type="submit" name="cancel" id="cancelWarn" onClick="popupClose1()" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="cursor: pointer;"/>

            </div>
        </div>

        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose1()">X</button>
                <h3 id="myModalLabel">Do you wish to suspend this Wholesaler?</h3>
            </div>
            <div id="listed_Suspend"></div>
            <div class="modal-body" style="padding-left:42px;padding-right:10px;">
                <div class="rowlbinp">
                    <div class="lbl"><strong>*Write Message:</strong></div>
                    <textarea name="SuspendMsg" id="SuspendMsg" rows="4" class="input-block-level"></textarea>
                    <script type="text/javascript">
                        CKEDITOR.replace('WarningMsg1', {
                            enterMode: CKEDITOR.ENTER_BR,
                            toolbar :[['Bold'],['Italic'],['Strike'],['Subscript'],['Superscript'],['RemoveFormat'],['NumberedList'],['BulletedList'],['Link'],['Unlink'],
                                ['Table'],['TextColor'],['BGColor'],[['FontSize'],['Font'],['Styles']]]
                        });
                    </script>
                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" name="frmConfirmSuspend" id="frmConfirmSuspend" value="Suspend" style="cursor: pointer;"/>
                &nbsp;&nbsp;<input class="btn" type="submit" name="cancel" id="cancelSus" value="Ignore" style="cursor: pointer;" onClick="popupClose1()"/>

            </div>
        </div>

    </body>
</html>