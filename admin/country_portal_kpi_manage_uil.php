<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_COUNTRY_PORTAL_KPI_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Country Portal KPIs </title>        
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />     
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />         
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" media="all" />
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>  
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "common/js/ajax_js.js"; ?>"></script>
        <script type="text/javascript">
            function changeStatus(status,emailid,id){
                var showid = '#countryPortal'+id;
                
                $.post("ajax.php",{action:'CountryPortalChangeStatus',status:status,emailid:emailid,id:id},
                function(data){
                    $(showid).html(data);
                });
            }
            
            function jscallSendWarningPopup(emailid,id,warnNo,kpi){
                $.post("ajax.php",{action:'getWarningTemplateForCountryPortal',emailid:emailid,id:id,warnNo:warnNo,kpi:kpi},
                function(data){
                    // alert(data);
                    //$('#WarningMsg').html(data);
                    $('#WarningMsg').html(data);   
                    var editor = CKEDITOR.instances['WarningMsg'];
                    if (editor) {
                        editor.destroy(true);
                    }
                    CKEDITOR.replace('WarningMsg', {                  
                    //CKEDITOR.replace('WarningMsg', {
                        enterMode: CKEDITOR.ENTER_BR,
                        toolbar :[['Bold'],['Italic'],['Strike'],['RemoveFormat'],['NumberedList'],['BulletedList'],['Link'],['Unlink'],
                            ['Table'],['TextColor'],['BGColor'],['FontSize'],['Font'],['Styles']]
                    });
                    $('#modal-1').show();
                });
               
                //$(".warning").colorbox({inline:true, width:"500px", height:"290px"});
                $('#cancelWarn').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmWarning').click(function(){

                    var WarningMsg = $('#WarningMsg').html();
                  
                    if(WarningMsg==''){
                        alert('Message is Required!');
                        $('#WarningMsg').focus();
                        return false;
                    }else{
                        $('#listed_Warning').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SendWarningToCountryPortal',msg:WarningMsg,emailid:emailid,id:id,warnNo:warnNo},
                        function(data){
                            //alert(data);
                            //$('#listed_Warning').html(data);
                            $('#listed_Warning').html('<span class="green">Warning Sent Successfully </span>');                            
                            setTimeout(function a(){$('#modal-1').hide();location.reload();}, 1500);
                            

                        });
                    }
                });
            }
            
            function jscallSendWarningPopup1(emailid,id){
                $('#modal-1').show();
                $('#frmConfirmWarning').click(function(){
                    var WarningMsg = $('#WarningMsg').val();  
                    if(WarningMsg==''){
                        alert('Message is Required!');
                        $('#WarningMsg').focus();
                        return false;
                    }else{
                        $('#listed_Warning').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SendWarningToCountryPortal',msg:WarningMsg,emailid:emailid,id:id},
                        function(data){                        
                            $('#listed_Warning').html('<span class="green">Warning Sent Successfully </span>');
                            //$('#listed_Warning').html(data);
                            setTimeout(function a(){parent.jQuery.fn.colorbox.close();location.reload();}, 1500);
                        }
                    );
                    }
                });
            }  

            function popupClose1(){
                
                $('#modal-1').hide();
                return false;
                
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
                            <h1>Manage Country Portal KPIs</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-categories', $_SESSION['sessAdminPerMission'])) { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>	
                                <li><span>Manage Country Portal KPIs </span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>					
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">                                                            	
                                    <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Country Portal </button>
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
                                        <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onsubmit="return dateCompare('frmSearch');">
                                            <div class="row-fluid">
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Country Office Name:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmName" name="frmName" value="<?php echo stripslashes($_GET['frmName']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4 ">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Country: </label>
                                                            <div class="controls">
                                                                <select name="frmCountry" class='select2-me input-large'>
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
                                                                                ?>><?php echo html_entity_decode($vCT['name']); ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>  
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Status:  </label>
                                                            <div class="controls">
                                                                <select name="frmStatus" class='select2-me input-large'>
                                                                    <option value="Active" <?php
                                                                if ($_GET['frmStatus'] == 'Active') {
                                                                    echo 'Selected';
                                                                }
                                                                    ?>>Active</option>
                                                                    <option value="Inactive" <?php
                                                                        if ($_GET['frmStatus'] == 'Inactive') {
                                                                            echo 'Selected';
                                                                        }
                                                                    ?>>Deactive</option>
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
                                                            <input type="button" onclick="location.href = 'country_portal_kpi_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />                                                                       
                                                        <?php } else { ?>
                                                            <input type="button" onclick="showSearchBox('search','hide');" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />	
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
                                            Manage Country Portal 
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">  
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) { ?>
                                                <form id="frmCountryPortalList" name="frmCountryPortalList" action="" method="post">                                           
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <?php echo $objPage->varSortColumn; ?>
                                                                <th class='hidden-480' title="Revenue KPI % = [(total sale done by wholesalers under this country portal)/Total Sales target] x 100">Revenue KPI(%)</th> 
                                                                <th class='hidden-480' title="This is the average of wholesaler's KPIs">Performance KPI(%)</th>
                                                                <th class='hidden-480'>Sales Target</th>
                                                                <th class='hidden-480'>No.of Sold Products</th>
                                                                <th class='hidden-1024'><?php echo CP_WARNING1; ?></th>
                                                                <th class='hidden-1024'><?php echo CP_WARNING2; ?></th>
                                                                <th class='hidden-1024'><?php echo CP_WARNING3; ?></th>                                                                
                                                                <th>Status</th>
                                                                <th class='hidden-480'>Comments</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>

                                                                <tr>
                                                                    <td class="hidden-480"><?php echo $val['pkAdminID']; ?></td>
                                                                    <td><?php echo $val['AdminTitle']; ?></td>
                                                                    <td class="hidden-480"><?php echo number_format($val['RevenueKpi'], 2); ?></td>
                                                                    <td class="hidden-480"><?php echo number_format($val['PerformanceKpi'], 2); ?></td>                                            
                                                                    <td class="hidden-480"><?php echo $val['SalesTarget']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['NoOfSoldItems']; ?></td>
                                                                    <td class="hidden-1024"><?php echo ($val['warning'] > 0) ? 'Sent' : 'Not Yet'; ?></td>
                                                                    <td class="hidden-1024"><?php echo ($val['warning'] > 1) ? 'Sent' : 'Not Yet'; ?></td>
                                                                    <td class="hidden-1024"><?php echo ($val['warning'] > 2) ? 'Sent' : 'Not Yet'; ?></td>

                                                                    <td>
                                                                        <span id="countryPortal<?php echo $val['pkAdminID']; ?>">
                                                                            <?php
                                                                            if ($val['AdminStatus'] == 'Active') {
                                                                                echo '<span class="label label-satgreen">Active</span> ';
                                                                            } else {
                                                                                ?>
                                                                                <a href="javascript:void(0);" class="active" onclick="changeStatus('Active','<?php echo $val['AdminEmail']; ?>',<?php echo $val['pkAdminID']; ?>)" title="Click here to active this country portal.">Active</a> 
                                                                                <?php
                                                                            }
                                                                            if ($val['AdminStatus'] == 'Inactive') {
                                                                                echo '<a  href="" class="label label label-lightred">Deactive</a>';
                                                                            } else {
                                                                                ?>
                                                                                <a href="javascript:void(0);" class="deactive" onclick="changeStatus('Inactive','<?php echo $val['AdminEmail']; ?>',<?php echo $val['pkAdminID']; ?>)" title="Click here to deactive this country portal.">Deactive</a>
                                                                                <?php
                                                                            }
                                                                            ?>

                                                                        </span>
                                                                    </td>
                                                                    <td class="hidden-480">
                                                                        <?php if ($val['warning'] > 2) { ?>
                                                                            <a href="#" onclick="return alert('Three warning has been sent to Country Portal !');"><span class="req">Send warning</span></a>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <a class="warning" href="#modal-1" onclick="jscallSendWarningPopup('<?php echo $val['AdminEmail']; ?>',<?php echo $val['pkAdminID']; ?>,<?php echo $val['warning'];?>,'<?php echo number_format($val['PerformanceKpi'], 2); ?>')"><span class="req">Send warning</span></a>

                                                                        <?php }
                                                                        ?>
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

        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  style="width:800px; height: 500px;">



            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1()">X</button>
                <h3 id="myModalLabel">Do you wish to send warning ?</h3>
            </div>
            <div id='listed_Warning'></div>
            <div class="modal-body" style="padding-left:42px;padding-right:10px;">

                <div class="rowlbinp">
                    <div class="lbl"><strong>Write Message:</strong></div><div class="inpt">
                        <textarea name="WarningMsg" id="WarningMsg" rows="8" class="input-block-level"></textarea>                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!--				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                <button class="btn btn-primary" data-dismiss="modal">Save changes</button>-->

                <input type="submit" name="frmConfirmWarning" id="frmConfirmWarning" value="Send Message" style="cursor: pointer;" class="btn btn-blue"/>
                &nbsp;&nbsp;<input type="button" class="btn" name="cancel" id="cancelWarn" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="cursor: pointer;" onclick="popupClose1()"/> 

            </div>


        </div>

    </body>
</html>