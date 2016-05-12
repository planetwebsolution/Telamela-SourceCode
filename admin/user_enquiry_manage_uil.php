<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_USER_ENQUIRY_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : User Enquiry</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <script>
            function  setEnquiryAction(value, formname,listname){
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

                document.location.href = 'user_enquiry_action.php?frmID='+$('#deltid').val()+'&frmChangeAction=Delete';

            }
            function popupClose(){

                $('#modal-1').hide();
                $('#modal-2').hide();
                $('#modal-3').hide();

            }

            function formSubmit(){

                document.getElementById('frmUserEnquiryList').submit();

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
                            <h1>User Enquiries</h1>
                        </div>

                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-user-enquiries', $_SESSION['sessAdminPerMission'])) { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li>
                                    <a href="dashboard_uil.php">Home</a>
                                    <i class="icon-angle-right"></i>
                                </li>
                                <li>
                                    <span>User Enquiries</span>
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

                                    <button class="btn btn-inverse" onClick="showSearchBox('search','show');">Search Enquiries</button>
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
                                        <form id="frmSearch" method="get" action="" class='form-horizontal form-bordered'>
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Sender Name:  </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmSenderName" id="frmSenderName" value="<?php echo stripslashes($_GET['frmSenderName']); ?>" class="input-large" />

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Sender Email: </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmEmail" id="frmEmail" value="<?php echo stripslashes($_GET['frmEmail']); ?>" class="input-large"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Subject: </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmSubjectCode" id="frmSubjectCode" value="<?php echo stripslashes($_GET['frmSubjectCode']); ?>" class="input-large"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">                                                                                                       <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <?php if ($_GET['frmSearch'] != '') { ?>
                                                            <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onClick="location.href = 'user_enquiry_manage_uil.php'" class="btn" />
                                                        <?php } else { ?>
                                                            <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onClick="showSearchBox('search','hide');" class="btn" />
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
                                            User Enquiries
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">  
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <form id="frmUserEnquiryList" name="frmUserEnquiryList" action="user_enquiry_action.php" method="post">
                                                <table class="table table-hover table-nomargin table-bordered usertable">

                                                    <?php if ($objPage->NumberofRows > 0) { ?>


                                                        <th class='with-checkbox hidden-480'>
                                                            <input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" />
                                                        </th>
                                                        <?php echo $objPage->varSortColumn; ?>
                                                        <th>Action</th>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            //pre($objPage->arrRows);
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>
                                                                <tr>
                                                                    <td class="with-checkbox hidden-480">
                                                                        <input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkEnquiryID']; ?>" onClick="singleSelectClick(this,'singleCheck');" class="singleCheck"/>
                                                                    </td>
                                                                    <td><?php echo $val['fkParentID']!=0 ? 'Admin':$val['EnquirySenderName']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['EnquirySenderEmail']; ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['EnquiryDateAdded'], DATE_FORMAT_SITE); ?></td>
                                                                    <td class='hidden-480'><?php echo $val['EnquirySubject']; ?></td>
                                                                    <td>
                                                                        <a class="btn" href="user_enquiry_view_uil.php?id=<?php echo $val['pkEnquiryID']; ?>&type=view" rel="tooltip" title="" data-original-title="View"><i class="icon-eye-open"></i></a>
                                                                        <a class='btn' data-original-title="Delete" rel="tooltip" title="" href="user_enquiry_action.php?frmID=<?php echo $val['pkEnquiryID']; ?>&frmChangeAction=Delete&deleteType=sD" onClick='return fconfirm("Are you sure want to delete this user enquiry !",this.href);'><i class="icon-remove"></i></a>
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
                                                            ?>
                                                    </div>                            
                                                    <div class="controls hidden-480" style="margin: 1%;">
                                                        <select name="frmChangeActionAll" onChange="javascript:return setValidAction(this.value, this.form,'User Enquirie(s)');" ata-rule-required="true">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="Delete All">Delete</option>
                                                        </select>
                                                        <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                    </div>

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
                            <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                        <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
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
    </body>

</html>
