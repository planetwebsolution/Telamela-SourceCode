<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PRODUCT_REVIEW_CTRL;
//pre($_SESSION);
//echo '<pre>';
//print_r($_REQUEST);
//echo "</pre>";
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Product Review</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "common/js/ajax_js.js"; ?>"></script>
        <script>
            function jscallRe(reviewID){
                review=$('#'+reviewID).val();
                $('#modal-1').show();
                $('#ReviewMsg').html(review);
                // $(".review").colorbox({inline:true, width:"500px", height:"290px"});

                $('#cancelWarn').click(function(){
                    $('#modal-1').hide();
                });

            }

            function popupClose1(){
                $('#modal-1').hide();
                return false;

            }
        </script>

        <script>
            function changeStatus(status,id,rateID,pendind_status){
                console.log('34534');
                var showid = '#customer'+id;

                $.post("ajax.php",{action:'productReviewStatus',status:status,id:id,rateID:rateID,pendind_status:pendind_status},

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
                            <h1>Manage Product Review</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('manage-review-and-rating', $_SESSION['sessAdminPerMission']))
                    {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Manage Product Review</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Product Review</button>
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
                                        <form id="frmSearch" method="get" action="" onsubmit="return dateCompare('frmSearch');" class="form-horizontal form-bordered">
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Product ID:  </label>
                                                        <div class="controls">
                                                            <input type ="text" id="ProductId" name="ProductId" value="<?php echo stripslashes($_GET['ProductId']); ?>" class="input-large" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Product Name:  </label>
                                                        <div class="controls">
                                                            <input type ="text" id="ProductName" name="ProductName" value="<?php echo stripslashes($_GET['ProductName']); ?>" class="input-large" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Product Category:</label>
                                                        <div class="controls">
                                                            <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmParentId', 'frmParentId', array($_GET['frmParentId']), 'All Category', 0, 'class="select2-me input-large nomargin"',1,1); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <?php
                                                        if ($_GET['frmSearch'] != '')
                                                        {
                                                            ?>
                                                            <input type="button" onclick="location.href = 'product_review_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
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
                                            Product Review List
                                        </h3>
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
                                                                <?php echo $objPage->varProductSortColumn; ?>

                                                                <th class="hidden-480">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            //pre($objPage->arrRows);
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val)
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <td class="hidden-480"><?php echo $val['pkProductID']; ?></td>
                                                                    <td><?php echo $val['ProductName']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['CategoryName']; ?></td>

                                                                    <td><?php echo $val['csName']; ?></td>
<!--                                                                    <td><?php echo ($val['Rating']) ? $val['Rating'] : 'NA'; ?></td>-->
                                                                    <td><a class="review" href="#listed_Review" onclick="return jscallRe('<?php echo 'reviewText_'.$i; ?>')"><?php
                                                    if (count($val['Reviews'] > 30))
                                                    {
                                                        echo substr($val['Reviews'], 0, 30) . '..';
                                                    };
                                                                ?></a><input type="hidden" value="<?php echo $val['Reviews'];?>" id="reviewText_<?php echo $i;?>"/></td>
                                                                    <td class="hidden-480">
                                                                        <span id="customer<?php echo $val['pkReviewID']; ?>">
                                                                            <?php
                                                                            if ($val['ApprovedStatus'] == 'Pending')
                                                                            {
                                                                                echo '<span class="label label-light">Pending</span>';
                                                                            }
                                                                            ?>


                                                                            <?php
                                                                            if ($val['ApprovedStatus'] == 'Disallow' || $val['ApprovedStatus'] == 'Pending')
                                                                            {
                                                                                ?>
                                                                                <a href="javascript:void(0);" class="active" onclick="changeStatus('Allow','<?php echo $val['pkReviewID']; ?>','<?php echo $val['pkRateID'] ?>')" title="Click here to Approve this review.">Approve</a>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                echo '<span class="label label-satgreen">Approve</span>';
                                                                            }
                                                                            ?>
                                                                            <?php
                                                                            if ($val['ApprovedStatus'] == 'Allow' || $val['ApprovedStatus'] == 'Pending')
                                                                            {
                                                                                if($val['ApprovedStatus'] == 'Pending'){ $pendind_status = true; } else {$pendind_status = false;}
                                                                                ?>
                                                                                <a href="javascript:void(0);" class="deactive" onclick="changeStatus('Disallow','<?php echo $val['pkReviewID']; ?>','<?php echo $val['pkRateID'] ?>','<?php echo $pendind_status; ?>')" title="Click here to Disapprove this review.">Disapprove</a><?php
                                                            }
                                                            else
                                                            {
                                                                echo '<span class="label label-lightred">Disapprove</span>';
                                                            }
                                                                            ?>
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
        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1()">X</button>
                <h3>Product Review</h3>
            </div>
            <div class="modal-body" style="padding-left:42px;padding-right:10px; height:150px; ">

                <div class="rowlbinp">
                    <div class="lbl">
                        <div id="ReviewMsg">&nbsp;</div>
                    </div>
                </div>
            </div>

        </div>

    </body>
</html>