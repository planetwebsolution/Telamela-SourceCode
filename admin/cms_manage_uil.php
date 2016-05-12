<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CMS_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Cms</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
          <!--<script type="text/javascript" src="<?php // echo JS_PATH;        ?>jquery-1.3.2.min.js"></script>-->
        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>	
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "components/cal/calendar.js"; ?>"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "components/cal/lang/calendar-en.js"; ?>"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "components/cal/calendar-setup.js"; ?>"></script>
    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Manage Cms</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-cms', $_SESSION['sessAdminPerMission']))
                    { ?>

                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Cms List</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onClick="showSearchBox('search','show');">Search  Cms</button>
                                    <a href="cms_add_uil.php?type=add"><button class="btn btn-inverse">Add New Page</button></a>
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

                                            <div style="float:left; width:100%; margin-bottom:5px;">
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Page Title:  </label>
                                                            <div class="controls">
                                                                <input type="text" name="frmTitle" id="frmTitle" value="<?php echo $_GET['frmTitle']; ?>" class="input-large"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4 ">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Author: </label>
                                                            <div class="controls">
                                                                <input type="text" name="frmAuthor" id="frmAuthor" value="<?php echo $_GET['frmAuthor']; ?>" class="input-large"/>

                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">

                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn" style="width:70px;" />
                                                        <?php if ($_GET['frmSearch'] != '')
                                                        { ?>
                                                            <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onClick="location.href = 'cms_manage_uil.php'" class="btn" style="width:70px;" />
                                                        <?php }
                                                        else
                                                        { ?>
                                                            <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onClick="showSearchBox('search','hide');" class="btn" style="width:70px;" />
    <?php } ?>

                                                    </div>
                                                </div>


                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row-fluid" style="width:98%;margin:10px;">
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
                                        Cms List
                                    </h3>
                                </div>
                                <div class="box-content nopadding manage_categories">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
    <?php if ($objPage->NumberofRows > 0)
    { ?>
                                            <form id="frmAdsList" name="frmAdsList" action="cms_action.php" method="post">
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

                                                            <th class="hidden-480">Author</th>
                                                            <th class="hidden-1024">Updated Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
        <?php
        foreach ($objPage->arrRows as $val)
        {
            ?>
                                                            <tr>
                                                                <td valign="top" class="hidden-480">
                                                                    <input style="width:20px; border:none;" type="checkbox" class="singleCheck" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkCmsID']; ?>" onClick="singleSelectClick(this,'singleCheck');"/>
                                                                </td>

                                                                <td><?php echo $val['PageTitle'] ?></td>
                                                                <td class="hidden-480"><?php echo $val['PageOrdering']; ?></td>
                                                                <td class="hidden-480"><?php echo $val['AdminUserName']; ?></td>
                                                                <td class="hidden-1024"><?php echo $objCore->localDateTime($val['PageDateUpdated'], DATE_FORMAT_SITE); ?></td>

                                                                <td>

                                                                    <a href="cms_view_uil.php?cmsid=<?php echo $val['pkCmsID']; ?>&type=edit" class="btn" rel="tooltip" title="" data-original-title="View"><i class="icon-eye-open"></i></a>&nbsp;
                                                                    <a href="cms_edit_uil.php?cmsid=<?php echo $val['pkCmsID']; ?>&type=edit" class="btn" rel="tooltip" title="" data-original-title="Edit"><i class="icon-edit"></i></a>&nbsp;
                                                                    <a onClick="return fconfirm('Are you sure you want to delete this CMS ?',this.href)" href="cms_action.php?frmID=<?php echo $val['pkCmsID']; ?>&frmChangeAction=Delete" class="btn" rel="tooltip" title="" data-original-title="Delete"><i class="icon-remove"></i></a>&nbsp;
                                                                </td>

                                                            </tr>
                                                        <?php
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
                                                    <select name="frmChangeAction" onChange="javascript:return setValidAction(this.value, this.form,'CMS(s)');" ata-rule-required="true">
                                                        <option value="">-- Select Action --</option>
                                                        <option value="Delete All">Delete</option>
                                                    </select>
                                                    <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                </div>

                                            </form>
    <?php }
    else
    { ?>
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

            <?php }
            else
            { ?>
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
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes')
{ ?>
        showSearchBox('search', 'show');
<?php }
else
{ ?>
        showSearchBox('search', 'hide');
<?php } ?>
        </script>


    </body>
</html>