<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ATTRIBUTE_CTRL;
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_session_redirect_bll.php';
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Attributes</title>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.js"; ?>'></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />
         
        <script type="text/javascript">
            AutoCom=jQuery.noConflict();
            AutoCom(document).ready(function(){                
                
                AutoCom("#autoFilledAttributeLable").autocomplete("ajax.php?action=attributeLableAutocomplete", {
                    width: 222,
                    matchContains: true,
                    selectFirst: false,
                });
                
                AutoCom("#autoFilledAttributeCode").autocomplete("ajax.php?action=attributeCodeAutocomplete", {
                    width: 222,
                    matchContains: true,
                    selectFirst: false,
                });                      

                AutoCom('.saveorder').click(function(){
                    AutoCom("#frmUsersList").submit();
                });

            });
        </script>

        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />      
        <script src="../colorbox/jquery.colorbox.js"></script>	


        <script>
            function  setEnquiryAction(value, formname,listname)
            {
                if($("input[name='frmID[]']").serializeArray().length == 0) {
                    $('#modal-1').show();          
                }else if($("input[name='frmID[]']").serializeArray().length > 0){                
                    $('#modal-2').show();                
                }else{
                    $('#modal-1').hide();                 
                }
            }
            function popupClose(){            
                $('#modal-1').hide();
                $('#modal-2').hide();
                $('#modal-3').hide(); 
            
            }  
        </script>
        <style>
            .dNone{display:none !important;}
        </style>
    </head>
    <body>  
    </div> 
    <?php require_once 'inc/header_new.inc.php'; ?>
    <div class="container-fluid" id="content">

        <div id="main">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="pull-left">
                        <h1>Manage Attributes</h1>
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
                                <a href="catalog_manage_uil.php">Catalog</a>	
                                <i class="icon-angle-right"></i>
                            </li>	
                            <li>
                                <span>Manage Attributes</span>

                            </li>	
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>


                    <div class="row-fluid">
                        <div class="span12 margin_top20">
                            <div style="float:left">                                                            	
                                <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Attributes </button>
                                <a href="attribute_add_uil.php?type=add"><button class="btn btn-inverse">Add New Attributes</button></a>
                            </div>
                            <div style="float:right;" class="hidden-480">
                                <div class="export" style="float:left;">
                                    <form action="" method="post">
                                        <div>
                                            <div style="float:left;padding-right:10px;">
                                                <label class="control-label" for="textfield">Export to: </label>
                                            </div>
                                            <div style="float:left;padding-right:10px;">		                               
                                                <select name="fileType" class="select2-me input-small">
                                                    <option value="csv">CSV</option>
                                                    <option value="excel">Excel</option>
                                                </select>
                                            </div>
                                            <div style="float:left;padding-right:10px;">    
                                                <input type="submit" class="btn btn-primary" name="Export" value="Export" />
                                            </div>
                                        </div>
                                    </form>
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
                                    <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onsubmit="return dateCompare('frmSearch');">
                                        <div class="row-fluid">
                                            <div class="row-fluid" style="margin-bottom:5px ">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Attribute Code:  </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmCode" id="autoFilledAttributeCode" value="<?php echo stripslashes($_GET['frmCode']); ?>" class="input-large" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Attribute Label:  </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmLabel" id="autoFilledAttributeLable" value="<?php echo stripslashes($_GET['frmLabel']); ?>" class="input-large" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Category: </label>
                                                        <div class="controls">
                                                            <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategory', 'frmCategory', array($_GET['frmCategory']), 'All Category', 0, 'class="select2-me input-large"',1,1); ?>
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Visible: </label>
                                                        <div class="controls">
                                                            <select name="frmVisible" class='select2-me input-large'>
                                                                <option value="yes" <?php
                                                        if ($_GET['frmVisible'] == 'yes') {
                                                            echo 'Selected';
                                                        }
                                                            ?>>Yes</option>
                                                                <option value="no" <?php
                                                                    if ($_GET['frmVisible'] == 'no') {
                                                                        echo 'Selected';
                                                                    }
                                                            ?>>No</option>   
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Comparable: </label>
                                                        <div class="controls">
                                                            <select name="frmComparable" class='select2-me input-large'>
                                                                <option value="yes" <?php
                                                                    if ($_GET['frmComparable'] == 'yes') {
                                                                        echo 'Selected';
                                                                    }
                                                            ?>>Yes</option>
                                                                <option value="no" <?php
                                                                    if ($_GET['frmComparable'] == 'no') {
                                                                        echo 'Selected';
                                                                    }
                                                            ?>>No</option>   
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Searchable: </label>
                                                        <div class="controls">
                                                            <select name="frmSearchable" class='select2-me input-large'>
                                                                <option value="yes" <?php
                                                                    if ($_GET['frmSearchable'] == 'yes') {
                                                                        echo 'Selected';
                                                                    }
                                                            ?>>Yes</option>
                                                                <option value="no" <?php
                                                                    if ($_GET['frmSearchable'] == 'no') {
                                                                        echo 'Selected';
                                                                    }
                                                            ?>>No</option>   
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="form-actions span12  search">     
                                                    <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                    <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                    <a <?php if (isset($_REQUEST['frmSearch'])) { ?> href="attribute_manage_uil.php"<?php } else { ?> onclick="showSearchBox('search', 'hide');" <?php } ?> class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></a>

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

                            <div class="box box-color box-bordered">
                                <?php
                                if ($objCore->displaySessMsg() <> '') {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
                                ?>
                                <div class="box-title">
                                    <h3>
                                        Attributes List
                                    </h3>
                                </div>
                                <div class="box-content nopadding manage_categories">  
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                        <?php if ($objPage->NumberofRows > 0) { ?>
                                            <form id="frmUsersList" name="frmUsersList" action="attribute_action.php" method="post">  
                                                <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateAttribute"  />                                         
                                                <table class="table table-hover table-nomargin table-bordered usertable">
                                                    <thead>
                                                        <tr>
                                                            <th class='with-checkbox hidden-480'><input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                                                            <?php echo $objPage->varSortColumn; ?>
                                                            <th class='hidden-300'>Visible</th>
                                                            <th class='hidden-300'>Searchable</th> 
                                                            <th class='hidden-300'>Comparable</th>
                                                            <th class='hidden-1024'><span>Display Order&nbsp;<a title="Save Order" class="saveorder" href="javascript: void(0);"></a></span></th> 
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($objPage->arrRows as $val) {
                                                            ?>
                                                            <tr>
                                                                <td class='with-checkbox hidden-480'><input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkAttributeID']; ?>" onclick="singleSelectClick(this,'singleCheck');" class="singleCheck"/>
                                                                <input type="hidden" name="attName[]" id="attName[]"  value="<?php echo $val['AttributeLabel']; ?>"/>
                                                                </td>
                                                                <td><?php echo $val['AttributeCode']; ?></td>
                                                                <td class="hidden-480"><?php echo $val['AttributeLabel']; ?> </td>
                                                                <td class='hidden-1024'><?php echo $val['CategoryNames']; ?> </td>
                                                                <td class="hidden-300"><?php echo ucfirst($val['AttributeVisible']); ?> </td>
                                                                <td class="hidden-300" ><?php echo ucfirst($val['AttributeSearchable']); ?> </td>
                                                                <td class="hidden-300" ><?php echo ucfirst($val['AttributeComparable']); ?> </td>
                                                                <td class='hidden-1024'><input type="text" onblur="return order_validation(this.value,'frmOrderId<?php echo $val['pkAttributeID']; ?>')" id="frmOrderId<?php echo $val['pkAttributeID']; ?>" class="input-small" value="<?php echo $val['AttributeOrdering']; ?>" size="5" name="order[]">
                                                                    <input type="hidden" value="<?php echo $val['pkAttributeID']; ?>" size="5" name="orderId[]">
                                                                <td>	
                                                                    <a class="btn" rel="tooltip" data-original-title="Edit" href="attribute_edit_uil.php?type=edit&attrbuteid=<?php echo $val['pkAttributeID']; ?>"><i class="icon-edit"></i></a>                                        
                                                                    <a class='btn' rel="tooltip"data-original-title="Delete" href="attribute_action.php?frmID=<?php echo $val['pkAttributeID']; ?>&attName=<?php echo $val['AttributeLabel']; ?>&frmProcess=ManipulateAttribute&frmChangeAction=Delete&deleteType=sD" onClick="return confirm('Are you sure you want to delete this Attribute ?',this.href)"><i class="icon-remove"></i></a>
                                                                    <input type="hidden" name="frmUpdateOrder" id="frmUpdateOrder" value="order" />
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
                                                <div class="controls hidden-480" style="margin: 1%;">
                                                    <select name="frmChangeAction" onchange="javascript:return setValidAction(this.value, this.form,'Attribute(s)');" ata-rule-required="true">
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
</body>
</html>