<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Wholesaler list</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <style>
            .cke_reset_all input[type="text"]{
                height: 30px;
            }

        </style>
        <script>
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
                    if (editor) {
                        editor.destroy(true);
                    }
                    CKEDITOR.replace('WarningMsg', {
                    //CKEDITOR.replace('WarningMsg', {
                        
                        enterMode: CKEDITOR.ENTER_BR,
                        toolbar: [['Bold'], ['Italic'], ['Strike'], ['RemoveFormat'], ['NumberedList'], ['BulletedList'], ['Link'], ['Unlink'],
                            ['Table'], ['TextColor'], ['BGColor'], ['FontSize'], ['Font'], ['Styles']]
                    });

                    $('#modal-1').show();
                });
                //function(data){
                    // alert(data);
                    //$('#WarningMsg').html(data);
                    //$('#WarningMsg').html(data);                     
                   // CKEDITOR.replace('WarningMsg', {
                     //   enterMode: CKEDITOR.ENTER_BR,
                       // toolbar :[['Bold'],['Italic'],['Strike'],['RemoveFormat'],['NumberedList'],['BulletedList'],['Link'],['Unlink'],
                         //   ['Table'],['TextColor'],['BGColor'],['FontSize'],['Font'],['Styles']]
                    //});
                    //$('#modal-1').show();
               // });
               
                //$(".warning").colorbox({inline:true, width:"500px", height:"290px"});
                $('#cancelWarn').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmWarning').click(function(){

                    //var WarningMsg = $('#WarningMsg').html();
                    var editMsg=$('#cke_WarningMsg iframe').contents().find('.cke_editable').html();
                  
                    if(editMsg=='<br>' || editMsg=='<p><br><p>'|| editMsg=='<p><br><br></p>'){
                        alert('Message is Required!');
                        $('#WarningMsg').focus();
                        return false;
                    }else{
                        $('#listed_Warning').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SendWarningToWholesaler',msg:editMsg,emailid:emailid,id:id,warnNo:warnNo},
                        function(data){
                            //$('#listed_Warning').html(data);
                            $('#listed_Warning').html('<span class="green">Warning Sent Successfully </span>');                            
                            setTimeout(function a(){$('#modal-1').hide();location.reload();}, 1500);
                            

                        });
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
            $(document).ready(function(){
                $('#cancelSus').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            });
            function jscall1(emailid,id){
                // $(".suspend").colorbox({inline:true, width:"500px", height:"290px"});
                $('#modal-2').show();
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
                            setTimeout(function b(){$('#modal-2').hide();location.reload();}, 1500);

                        }
                    );
                    }
                });
            }

            function changeStatus(status,emailid,id){
                var showid = '#wholesaler'+id;
                $.post("ajax.php",{action:'WholesalerChangeStatus',status:status,emailid:emailid,id:id},

                function(data)
                {
                    $(showid).html(data);
                }
            );

            }

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
                            <h1>Manage Wholesaler</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-wholesalers', $_SESSION['sessAdminPerMission']))
                    {
                        ?>
                        <?php
                        if (!isset($_GET['frmTrashPressed']))
                        {
                            ?>
                            <div class="breadcrumbs">
                                <ul>
                                    <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                    <li><span>Wholesaler List</span></li>
                                </ul>
                                <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12 margin_top20">
                                    <div class="fleft">
                                        <button class="btn btn-inverse" onClick="showSearchBox('search','show');">Search </button>
                                        <a href="wholesaler_add_uil.php?type=add"><button class="btn btn-inverse">Add New</button></a>
                                    </div>
                                    <div class="fright">
                                        <div class="export fleft">
                                            <form action="" method="post">
                                                <div>
                                                    <label class="control-label" for="textfield">Export to: </label>
                                                </div>
                                                <div>
                                                    <select name="fileType" class="select2-me">
                                                        <option value="csv">CSV</option>
                                                        <option value="excel">Excel</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <input type="submit" class="btn btn-primary" name="Export" value="Export" />
                                                </div>
                                            </form>
                                        </div>
                                        <div class="import fleft">
                                            <a href="bulk_upload_uil.php?type=wholesalers" target="_blank"><button class="btn btn-inverse">Import</button></a>
                                        </div>
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
                                            <form id="frmSearch" method="get" action="" onSubmit="return dateCompare('frmSearch');" class='form-horizontal form-bordered'>
                                                <div style="float:left; width:100%; margin-bottom:5px;">
                                                    <div class="row-fluid">
                                                        <div class="span4">
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">Wholesaler Name:  </label>
                                                                <div class="controls">
                                                                    <input type ="text" name="frmName" value="<?php echo stripslashes($_GET['frmName']); ?>"  class="input-large"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span4 ">
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">Country Portal: </label>
                                                                <div class="controls">

                                                                    <select name="frmCountryPortal" class='select2-me input-large nomargin'>
                                                                        <option value="0-0-0" <?php
                    if ($_GET['frmCountryPortal'] == '0-0-0')
                    {
                        echo 'Selected';
                    }
                            ?>>All Portal</option>
                                                                                <?php
                                                                                foreach ($objPage->CountryPortal as $valCP)
                                                                                {
                                                                                    $optVal = $valCP['pkAdminID'] . '-' . $valCP['AdminCountry'] . '-' . $valCP['AdminRegion'];
                                                                                    ?>
                                                                            <option value="<?php echo $optVal; ?>" <?php
                                                                        if ($_GET['frmCountryPortal'] == $optVal)
                                                                        {
                                                                            echo 'Selected';
                                                                        }
                                                                                    ?>><?php echo $valCP['AdminUserName']; ?></option>
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

                                                                        <option value="active" <?php
                                                                        if ($_GET['frmStatus'] == 'active')
                                                                        {
                                                                            echo 'Selected';
                                                                        }
                                                                                ?>>Active</option>
                                                                        <option value="deactive" <?php
                                                                        if ($_GET['frmStatus'] == 'deactive')
                                                                        {
                                                                            echo 'Selected';
                                                                        }
                                                                                ?>>Deactive</option>
                                                                        <option value="suspend" <?php
                                                                        if ($_GET['frmStatus'] == 'suspend')
                                                                        {
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
                                                                <label for="textfield" class="control-label">Email:  </label>
                                                                <div class="controls">
                                                                    <input type ="text" name="frmEmail" value="<?php echo stripslashes($_GET['frmEmail']); ?>"  class="input-large"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span4">
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">Phone:  </label>
                                                                <div class="controls">
                                                                    <input type ="text" name="frmPhone" value="<?php echo stripslashes($_GET['frmPhone']); ?>" class="input-large"/>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span4">
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">Country:  </label>
                                                                <div class="controls">
                                                                    <select name="frmCountry" class='select2-me input-large nomargin'>
                                                                        <option value="0" <?php
                                                                        if ($_GET['frmCountry'] == '0')
                                                                        {
                                                                            echo 'Selected';
                                                                        }
                                                                                ?>>All Country</option>
                                                                                <?php
                                                                                foreach ($objPage->arrCountryList as $vCT)
                                                                                {
                                                                                    ?>
                                                                            <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                        if ($_GET['frmCountry'] == $vCT['country_id'])
                                                                        {
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
                                                                <input type="submit" name="frmSearch" value="Search" class="btn btn-blue" style="width:70px;" />
                                                                <?php
                                                                if ($_GET['frmSearch'] != '')
                                                                {
                                                                    ?>
                                                                    <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onClick="location.href = 'wholesaler_manage_uil.php'" class="btn" style="width:70px;" />
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onClick="showSearchBox('search','hide');" class="btn" style="width:70px;" />
                                                                <?php } ?>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        else if (isset($_GET['frmTrashPressed']))
                        {
                            ?>
                            <a id="buttonDecoration" href="category_manage_uil.php"><input type="button" class="button" name="btnTagSettings" value="<?php echo ADMIN_BACK_BUTTON; ?> " style="float:right; margin:6px 2px 0 0; width:107px;"/></a>
                        <?php } ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <?php
                                if ($objCore->displaySessMsg() <> '')
                                {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
                                ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>
                                            Wholesaler List
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php
                                            if ($objPage->NumberofRows > 0)
                                            {
                                                ?>
                                                <form id="frmWholesalerList" name="frmWholesalerList" action="wholesaler_action.php" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='with-checkbox hidden-480'>
                                                                    <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateOrder"  />
                                                                    <input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" />
                                                                </th>
                                                                <?php
                                                                echo $objPage->varSortColumn;
                                                                ?>
                                                                <th class='hidden-480'>Country Portal</th>
                                                                <th class='hidden-480'>KPI (%)</th>
                                                                <th class='hidden-480'>Date Registered</th>
                                                                <th class='hidden-1024'>Products</th>
                                                                <th class='hidden-1024'>Packages</th>
                                                                <th class='hidden-480'>Status</th>
                                                                <th style="width:125px">Actions</th>
                                                                <th class='hidden-1024'>Critical Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val)
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <td valign="top" class="hidden-480">
                                                                        <input style="width:20px; border:none;" type="checkbox" class="singleCheck" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkWholesalerID']; ?>" onClick="singleSelectClick(this,'singleCheck');"/>
                                                                    </td>
                                                                    <td class="hidden-480"><?php echo $val['pkWholesalerID']; ?></td>
                                                                    <td><?php echo $val['CompanyName']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['Commission']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['CountryRegionPortalUser'] . ' ' . $val['CountryRegionPortal']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['kpi']; ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['WholesalerDateAdded'], DATE_FORMAT_SITE); ?></td>
                                                                    <td class="hidden-1024"><a href="product_manage_uil.php?frmName=&frmPriceFrom=&frmPriceTo=&frmStatus=1&frmCategory=0&frmWholesaler=<?php echo $val['pkWholesalerID']; ?>&frmSearchPressed=Yes&frmSearch=Search">Click here</a></td>

                                                                    <td class="hidden-1024"><a href="package_manage_uil.php?frmPackageName=&ProductName=&PackagePrice=&frmWholesaler=<?php echo $val['pkWholesalerID']; ?>&frmSearchPressed=Yes&frmSearch=Search">Click here</a></td>

                                                                    <td class="hidden-480">
                                                                        <span id="wholesaler<?php echo $val['pkWholesalerID']; ?>">
                                                                            <?php
                                                                            if ($val['WholesalerStatus'] == 'suspend')
                                                                            {

                                                                                if ($_SESSION['sessUserType'] == 'super-admin')
                                                                                {
                                                                                    ?><a href="javascript:void(0);" class="active" onClick="changeStatus('active','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)" title="Click here to active this Wholesaler.">Active</a>
                                                                                    <?php
                                                                                }
                                                                                echo "<span class='label label-light'>Suspend</span>";
                                                                                ?>

                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <?php
                                                                                if ($_SESSION['sessUserType'] == 'super-admin')
                                                                                {

                                                                                    if ($val['WholesalerStatus'] != 'active')
                                                                                    {
                                                                                        ?><a href="javascript:void(0);" class="active" onClick="changeStatus('active','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)" title="Click here to active this Wholesaler.">Active</a><?php
                                                            }
                                                            else
                                                            {
                                                                echo "<span class='label label-satgreen'>Active</span>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            if ($val['WholesalerStatus'] == 'active')
                                                                echo ucfirst($val['WholesalerStatus']);
                                                        }
                                                                                ?>
                                                                                <?php
                                                                                if ($val['WholesalerStatus'] != 'deactive')
                                                                                {
                                                                                    ?><a href="javascript:void(0);" class="deactive" onClick="changeStatus('deactive','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)" title="Click here to deactive this Wholesaler.">Deactive</a><?php
                                                            }
                                                            else
                                                            {
                                                                echo "<span class='label label-lightred'>Deactive</span>";
                                                            }
                                                        }
                                                        ?>
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="wholesaler_view_uil.php?id=<?php echo $val['pkWholesalerID']; ?>&type=edit" class="btn" rel="tooltip" title="" data-original-title="View"><i class="icon-eye-open"></i></a>&nbsp;
                                                                        <a href="wholesaler_edit_uil.php?id=<?php echo $val['pkWholesalerID']; ?>&type=edit" class="btn" rel="tooltip" title="" data-original-title="Edit"><i class="icon-edit"></i></a>&nbsp;
                                                                        <a onClick="return fconfirm('Are you sure you want to delete this Wholesaler ?',this.href)" href="wholesaler_action.php?frmID=<?php echo $val['pkWholesalerID']; ?>&frmChangeAction=Delete" class="btn" rel="tooltip" title="" data-original-title="Delete"><i class="icon-remove"></i></a>&nbsp;
                                                                    </td>
                                                                    <td class="hidden-1024">
                                                                        <?php
                                                                        if ($val['WholesalerStatus'] <> 'suspend')
                                                                        {
                                                                            if ($val['warning'] > 2)
                                                                            {
                                                                                ?>
                                                                                <a href="#" onClick="return alert('Three warning has been sent to wholesaler !');"><span class="req">Send warning</span></a>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <a class="warning cboxElement" href="#modal-1" onClick="return jscall('<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>,<?php echo $val['warning']; ?>,'<?php echo $val['kpi']; ?>')"><span class="req">Send warning</span></a>

                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                        <span id="criA<?php echo $val['pkWholesalerID']; ?>">
                                                                            <?php
                                                                            if ($val['WholesalerStatus'] == 'suspend')
                                                                            {

                                                                                if ($_SESSION['sessUserType'] == 'super-admin')
                                                                                {
                                                                                    ?>

                                                                                    <?php
                                                                                    if ($val['WholesalerStatus'] == 'suspend')
                                                                                    {
                                                                                        ?>
                                                                                        <a href="#listed_Suspend" onClick="changeAction('active','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)"><span>Revoke Suspension</span></a>
                                                                                        <?php
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <a class="suspend cboxElement" href="#listed_Suspend" onClick="return jscall1('<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)"><span>Suspend</span></a>
                                                                                    <?php } ?>
                                                                                    <?php
                                                                                }
                                                                                echo '&nbsp;';
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <a class="suspend cboxElement" href="#modal-2" onClick="return jscall1('<?php echo $val['CompanyEmail']; ?>',<?php echo $val['pkWholesalerID']; ?>)"><span>Suspend</span></a>
            <?php } ?>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><?php
                                                            if ($objPage->varNumberPages > 1)
                                                            {
                                                                $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                            }
                                                            ?></div>
                                                    <div class="controls hidden-480" style="margin: 1%;">
                                                        <select name="frmChangeAction"  onchange="javascript: return setValidAction(this.value, this.form, 'Wholesalers(s)');" ata-rule-required="true">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="Delete All">Delete</option>
                                                        </select>
                                                        <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                    </div>

                                                </form>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
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
                    <?php
                }
                else
                {
                    ?>
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
<?php
if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes')
{
    ?>
            showSearchBox('search', 'show');
    <?php
}
else
{
    ?>
            showSearchBox('search', 'hide');
<?php } ?>
        </script>


        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px; height: 500px;">



            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose1()">X</button>
                <h3 id="myModalLabel">Do you wish to suspend this Wholesaler</h3>
            </div>
            <div class="modal-body" style="padding-left:42px;padding-right:10px;">
                <div id='listed_Warning'></div>
                <div class="rowlbinp">
                    <div class="lbl"><strong>*Write Message:</strong></div><div class="inpt"><textarea name="WarningMsg" id="WarningMsg" rows="8" class="input-block-level"></textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <!--				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                <button class="btn btn-primary" data-dismiss="modal">Save changes</button>-->

                <input type="submit" name="frmConfirmWarning" id="frmConfirmWarning" value="Send Message" style="cursor: pointer;" class="btn btn-blue"/>
                &nbsp;&nbsp;<input type="button" class="btn" name="cancel" id="cancelWarn" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="cursor: pointer;" onClick="popupClose1()"/> 

            </div>


        </div>

        <div id="modal-2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">



            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose1()">X</button>
                <h3 id="myModalLabel">Do you wish to suspend this Wholesaler?</h3>
            </div>
            <div class="modal-body" style="padding-left:42px;padding-right:10px;">
                <div id='listed_Suspend'></div>
                <div class="rowlbinp">
                    <div class="lbl"><strong>*Write Message:</strong></div><textarea name="SuspendMsg" id="SuspendMsg" rows="4" class="input4" style="width:600px"></textarea> <div class="inpt"></div>
                </div>
            </div>
            <div class="modal-footer">
                <!--				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                <button class="btn btn-primary" data-dismiss="modal">Save changes</button>-->
                <input type="submit" name="frmConfirmSuspend" id="frmConfirmSuspend" value="Suspend" style="cursor: pointer;" class="btn"/>
                &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelSus" value="Ignore" style="cursor: pointer;" class="btn" onClick="popupClose1()">




            </div>


        </div> 


    </body>
</html>
