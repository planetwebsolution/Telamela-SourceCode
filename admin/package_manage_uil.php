<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PACKAGE_CTRL;
//pre($_POST);
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
        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "common/js/ajax_js.js"; ?>"></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />
        <script>
            function changePackageStatus(status,pkgid){
                var showid = '#package'+pkgid;
                $.post("ajax.php",{action:'ChangePackageStatus',status:status,pkgid:pkgid},
                function(data)
                {
                    $(showid).html(data);
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
                            <h1>Manage Packages</h1>
                        </div>

                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-package', $_SESSION['sessAdminPerMission']))
                    {
                        ?>
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
                                    <span>Manage Packages</span>

                                </li>
                            </ul>
                            <div class="close-bread">
                                <a href="#"><i class="icon-remove"></i></a>
                            </div>
                        </div>


                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div style="float:left">
                                    <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Packages </button>
                                    <a href="package_add_uil.php?type=add"><button class="btn btn-inverse">Add New Packages</button></a>
                                </div>
                                <div class="fright">
                                    <div class="import fleft">
                                        <a href="bulk_upload_uil.php?type=packages" target="_blank"><button class="btn btn-inverse">Import</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid" id="search">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Advance Search</h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onsubmit="return dateCompare('frmSearch');">
                                            <div class="row-fluid">
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Package Name:  </label>
                                                            <div class="controls">
                                                                <input type ="text" name="frmPackageName" value="<?php echo stripslashes($_GET['frmPackageName']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Products:  </label>
                                                            <div class="controls">
                                                                <input type ="text" name="frmProducts" value="<?php echo stripslashes($_GET['frmProducts']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Package Price - USD:  </label>
                                                            <div class="controls">
                                                                <input type ="text" name="frmPackagePrice" value="<?php echo stripslashes($_GET['frmPackagePrice']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <a <?php
                    if (isset($_REQUEST['frmSearch']))
                    {
                            ?> href="package_manage_uil.php"<?php
                                                    }
                                                    else
                                                    {
                            ?> onclick="showSearchBox('search', 'hide');" <?php } ?> class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></a>
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
                                            Packages List
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php
                                            if ($objPage->NumberofRows > 0)
                                            {
                                                ?>
                                                <form id="frmPackageList" name="frmPackageList" action="package_action.php" method="post">
                                                    <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateAttribute"  />
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='with-checkbox hidden-480'><input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                                                                <?php echo $objPage->varSortColumn; ?>
                                                                <th class="hidden-480">Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val)
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <td class='with-checkbox hidden-480'><input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkPackageId']; ?>" onclick="singleSelectClick(this,'singleCheck');" class="singleCheck"/></td>
                                                                    <td><?php echo $val['PackageName']; ?></td>
                                                                    <td class="hidden-1024"><?php echo $val['ProductName']; ?> </td>
                                                                    <td class="hidden-480"><?php echo $objCore->price_format($val['FinalPrice']); ?> </td>
                                                                    <td class="hidden-350"><?php echo $objCore->price_format($val['PackagePrice']); ?> </td>
                                                                    <td class='hidden-480'>
                                                                        <span id="package<?php echo $val['pkPackageId']; ?>">
                                                                            <?php
                                                                            if (empty($val['PackageStatus']))
                                                                            {
                                                                                ?><a href="javascript:void(0);" title="click for active" class="active" onclick="changePackageStatus('1',<?php echo $val['pkPackageId']; ?>)">Active</a><?php
                                                            }
                                                            else
                                                            {
                                                                echo '<span class="label label-satgreen">Active</span>';
                                                            }
                                                                            ?>
                                                                            <?php
                                                                            if (!empty($val['PackageStatus']))
                                                                            {
                                                                                ?><a href="javascript:void(0);" title="click for deactive"  class="deactive" onclick="changePackageStatus('0',<?php echo $val['pkPackageId']; ?>)">Deactive</a><?php
                                                            }
                                                            else
                                                            {
                                                                echo '<a  href="" class="label label label-lightred">Deactive</a>';
                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a class="btn" rel="tooltip" title="Edit" href="package_edit_uil.php?pkgid=<?php echo $val['pkPackageId']; ?>&type=edit"><i class="icon-edit"></i></a>
                                                                        <a class='btn' rel="tooltip" title="Delete" href="package_action.php?frmID=<?php echo $val['pkPackageId']; ?>&frmChangeAction=Delete&deleteType=sD" onClick="return fconfirm('Are you sure you want to delete this package ?',this.href)"><i class="icon-remove"></i></a>
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
                                                        <select name="frmChangeAction" onchange="javascript:return setValidAction(this.value, this.form,' Package(s)');" ata-rule-required="true">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="Delete">Delete</option>
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
    </body>
</html>