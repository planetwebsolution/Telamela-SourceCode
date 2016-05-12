<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CATEGORY_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Category</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" media="all" />
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.js"; ?>'></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        
        <script type="text/javascript" src="js/category_admin.js"></script>
        
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid manage_page">
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    //pre($_SESSION);
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-categories', $_SESSION['sessAdminPerMission']))
                    {
                        ?>

                        <?php
                        if (isset($_GET['frmTrashPressed']))
                        {
                            ?>
                            <div class="breadcrumbs">
                                <ul>
                                    <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                    <li><a href="category_manage_uil.php">Manage Category</a><i class="icon-angle-right"></i></li>
                                    <!--                                    <li><a href="category_manage_uil.php?frmTrashPressed=Yes&frmSearch=Search">Trashed Categories</a></li>-->
                                    <li><span>Trashed Categories</span></li>
                                </ul>
                                <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="breadcrumbs">
                                <ul>
                                    <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                    <li><a href="category_manage_uil.php">Manage Categories</a></li>
                                </ul>
                                <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                            </div>
                            <div class="page-header">
                                <div class="pull-left">
                                    <h1>Manage Categories</h1>
                                </div>
                                <div class="fright">
                                    <!-- <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Category </button>-->
                                    <a href="category_add_uil.php?type=add"><button class="btn btn-inverse">Add New Category</button></a>
                                    <a href="category_manage_uil.php?frmTrashPressed=Yes&frmSearch=Search"><button class="btn btn-inverse">Trash Categories</button></a>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="box box-color box-bordered mng_catgry">
                                        <div class="box-title gray_border gray_bg" style="margin-top: 0">
                                            <h3>Grand Parent Catagory</h3>
                                            <a href="category_manage_uil.php?action=reset" style="float: right;margin-right: 20px; color: #fff; text-decoration: underline;"><b title="Reset Filter">(Reset)</b></a>
                                        </div>
                                        <div class="box-content nopadding gray_border">
                                            <ul class="mng_catgry_inner">
                                                <?php
                                                foreach ($objPage->arrCategoryDropDown[0] as $key => $val)
                                                {
                                                    if ($_SESSION['cat']['gcid'] == $val['pkCategoryId'])
                                                    {
                                                        $cls = 'clicked';
                                                        //$varScript = '<script>getChildCat()</script>';
                                                    }
                                                    else
                                                    {
                                                        $cls = '';
                                                    }
                                                    ?>
                                                    <li><a href="<?php echo $val['pkCategoryId'] ?>" level="<?php echo $val['CategoryLevel'] ?>" class="parentCat <?php echo $cls ?>"><?php echo $val['CategoryName'] ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="left_arrow"><img src="images/left_arrow.png" alt=""/></div>
                                    <div class="box box-color box-bordered mng_catgry right">
                                        <div class="box-title gray_border gray_bg" style="margin-top: 0">
                                            <h3>Parent Catagory</h3>
                                        </div>
                                        <div class="box-content nopadding gray_border">
                                            <ul class="mng_catgry_inner" id="parentCat">
                                                <?php
                                                if (isset($_SESSION['cat']['gcid']))
                                                {
                                                    if (count($objPage->arrSubCat) > 0)
                                                    {
                                                        foreach ($objPage->arrSubCat as $key => $val)
                                                        {
                                                            if ($_SESSION['cat']['pcid'] == $val['pkCategoryId'])
                                                            {
                                                                $cls = 'clicked';
                                                                $varScript = '<script>getSubChildCat(' . $val['pkCategoryId'] . ',' . $val['CategoryLevel'] . ')</script>';
                                                            }
                                                            else
                                                            {
                                                                $cls = '';
                                                            }
                                                            ?>
                                                            <li><a href="<?php echo $val['pkCategoryId'] ?>" level="<?php echo $val['CategoryLevel'] ?>" class="parentCat <?php echo $cls ?>"><?php echo $val['CategoryName'] ?></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo '<li><a>' . ADMIN_NO_RECORD_FOUND . '</a></li>';
                                                    }
                                                }
                                                else
                                                {
                                                    ?>
                                                    <li><a>Click on grand parent category&nbsp;</a></li>

                                                <?php }
                                                ?>

                                            </ul>
                                        </div>
                                    </div>
                                    <input type="hidden" name="pcat" id="pcat" lavel="0" value="<?php echo $_SESSION['cat']['gcid'] ?>" />
                                    <?php echo $varScript ?>
                                </div>
                            </div>
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
                                            Category List <?php
                            if (!isset($_GET['frmTrashPressed']))
                            {
                                echo '<span id="catName">(Parent)</span>';
                            }
                                ?>
                                        </h3>

                                        <?php
                                        
                                        if (isset($_GET['frmTrashPressed']))
                                        {
                                            $isTrashed = 'yes';
                                            ?>
                                            <a class="btn pull-right" href="category_manage_uil.php" id="buttonDecoration"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                            <?php
                                        }
                                        else
                                        {
                                            $isTrashed = 'no';
                                            ?>
                                            <a href="javascript:void(0)" onClick="addNew()" style="float: right;margin-right: 20px; color: #fff; text-decoration: underline;"><b title="Add New Category">(Add New Category)</b></a>
                                            <?php
                                        }
                                        ?>
                                        <input type="hidden" id="isTrashed" value="<?php echo $isTrashed; ?>">
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php
                                            if ($objPage->NumberofRows > 0)
                                            {
                                                ?>
                                                <form id="frmCategoryList" name="frmCategoryList" action="" method="post">
                                                   
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <?php
                                                                if (!isset($_GET['frmTrashPressed']))
                                                                {
                                                                    ?>
                                                                    <th class='with-checkbox hidden-480'><input style="width:15px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                                                                <?php } ?>
                                                                <?php echo $objPage->varSortColumn; ?>
                                                                <th class='hidden-1024'>Description</th>
                                                                <th class='hidden-480'>Parent Category Name</th>
                                                                <?php
                                                                if (!isset($_GET['frmTrashPressed']))
                                                                {
                                                                    ?>
                                                                    <th class='hidden-1024'>Display Order <a title="Save Order" class="saveorder" href="javascript: void(0);"></a></th>
                                                                    <th class='hidden-480'>Status</th>
                                                                <?php } ?>
                                                                <th style="width: 65px;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val)
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <?php
                                                                    if (!isset($_GET['frmTrashPressed']))
                                                                    {
                                                                        ?>
                                                                        <td class='with-checkbox hidden-480'>
                                                                            <input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkCategoryId']; ?>" onClick="singleSelectClick(this,'singleCheck');" class="singleCheck"/>
                                                                            <input type="hidden" name="catName[]" id="catName[]"  value="<?php echo $val['CategoryName']; ?>"/></td>
                                                                    <?php } ?>
                                                                    <td><?php echo $val['CategoryName']; ?></td>
                                                                    <td class="hidden-1024"><?php echo $val['CategoryDescription']; ?> </td>
                                                                    <td class="hidden-480"><?php
                                                        if ($val['CategoryParentName'] <> '')
                                                        {
                                                            echo $val['CategoryParentName'];
                                                        }
                                                        else
                                                        {
                                                            echo 'Parent';
                                                        }
                                                                    ?> 
                                                                    <input type="hidden" name="CategoryParentId[]" id="catlevel[]"  value="<?php echo $val['CategoryParentId']; ?>"/>
                                                                    </td>
                                                                    <?php
                                                                    if (!isset($_GET['frmTrashPressed']))
                                                                    {
                                                                        ?>
                                                                        <td class='hidden-1024'>
                                                                            <input type="text" onBlur="return order_validation(this.value,'frmOrderId<?php echo $val['pkCategoryId']; ?>')" id="frmOrderId<?php echo $val['pkCategoryId']; ?>" class="input-small" value="<?php echo $val['CategoryOrdering']; ?>" size="5" name="order[]"><input type="hidden" value="<?php echo $val['pkCategoryId']; ?>" size="5" name="orderId[]">
                                                                        </td>
                                                                        <td class='hidden-480'>
                                                                            <span id="cat<?php echo $val['pkCategoryId']; ?>">
                                                                                <?php
                                                                                if (empty($val['CategoryStatus']))
                                                                                {
                                                                                    ?><a href="javascript:void(0);" title="click for active" class="active" onClick="changeStatus('1',<?php echo $val['pkCategoryId']; ?>)">Active</a><?php
                                                            }
                                                            else
                                                            {
                                                                echo '<span class="label label-satgreen">Active</span>';
                                                            }
                                                                                ?>
                                                                                <?php
                                                                                if (!empty($val['CategoryStatus']))
                                                                                {
                                                                                    ?><a href="javascript:void(0);" title="click for deactive"  class="deactive" onClick="changeStatus('0',<?php echo $val['pkCategoryId']; ?>)">Deactive</a><?php
                                                            }
                                                            else
                                                            {
                                                                echo '<a  href="" class="label label label-lightred">Deactive</a>';
                                                            }
                                                                                ?>
                                                                            </span>
                                                                        </td>
                                                                    <?php } ?>
                                                                    <td>
                                                                        <?php
                                                                        if (isset($_GET['frmTrashPressed']))
                                                                        {
                                                                            ?>
                                                                            <a class='btn' data-original-title="Restore" rel="tooltip" title="" href="category_action.php?frmID=<?php echo $val['pkCategoryId']; ?>&name=<?php echo $val['CategoryName']; ?>&frmChangeAction=restore" onClick='return fconfirm("Are you sure you want to restore this category?\nThis category and its sub category will be restore to category list and category will be visible on the front end !",this.href)'><i class="icon-restore"></i></a>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <a class="btn" data-original-title="Edit" rel="tooltip" title="" href="category_edit_uil.php?type=edit&cid=<?php echo $val['pkCategoryId']; ?>"><i class="icon-edit"></i></a>
                                                                            <a class='btn' data-original-title="Delete" rel="tooltip" title="" href="category_action.php?frmID=<?php echo $val['pkCategoryId']; ?>&name=<?php echo $val['CategoryName']; ?>&frmChangeAction=delete" onClick='return fconfirm("Are you sure you want to delete this category? "+"\n"+"This category and its sub category will be moved to trash and Product will no longer visible on the front end !",this.href);'><i class="icon-remove"></i></a>
                                                                        <?php } ?>
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
                                                    if ($objPage->varNumberPages > 1)
                                                    {
                                                        $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                    }
                                                            ?></div>
                                                    <?php
                                                    /* if (!isset($_GET['frmTrashPressed']))
                                                    { */
                                                        ?>
                                                        <div class="controls hidden-480">
                                                            <div class="fleft">
                                                                <select name="frmChangeAction" onChange="javascript:return setValidAction(this.value, this.form,'Category(s)');" ata-rule-required="true">
                                                                    <option value="">-- Select Action --</option>
                                                                    <option value="Delete All">Delete</option>
                                                                </select>
                                                                <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                            </div>
                                                            <div class="export fright hidden-480">
                                                                <!--   <form action="" method="post">-->
                                                                <div>
                                                                    <label class="control-label" for="textfield" style="margin: 4px 0 0 10px">Export to: </label>
                                                                </div>
                                                                <div>
                                                                    <select name="fileType" class="select2-me2 input-small">
                                                                        <option value="csv">CSV</option>
                                                                        <option value="excel">Excel</option>
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <input type="submit" class="btn btn-blue" name="Export" value="Export" />
                                                                </div>
                                                                <!--</form>-->
                                                                <div class="import fleft">
                                                                    <a href="bulk_upload_uil.php?type=category" target="_blank" class="btn btn-inverse">Import</a>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    <?php //} ?>
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
    </body>
</html>