<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_MANAGE_PACKAGE_CTRL;
//pre($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MANAGE_PACKAGE_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		        
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script  type="text/javascript">
            $(document).ready(function(){ 
                $('.drop_down1').sSelect();
                $('.sort').click(function(){
                    var order = $(this).attr('order');
                    var col = $(this).attr('col');
                    $('#sort_order').val(order);
                    $('#sort_column').val(col);
                    $('#filter_form').submit();
                });
                $("#spButton").click(function() {
                    $('.order_sec').slideToggle('slow');
                });
                $('.order_sec').addClass("<?php echo count($_POST) ? 'show' : 'hide'; ?>");
            });
        </script>
        <script>
            $('.linkPop').live("click",function(){
                var packageID=$(this).attr('popPackageID');
                $.ajax({
                    url: SITE_ROOT_URL+"common/ajax/ajax.php",
                    data: {action: 'getPackageRelatedProducts',pid: packageID},
                    type: 'post',
                    async: false,
                    success: function(data) { //alert(data);return false;
                        $.colorbox({html:'<div style="width:500px;padding:20px 0px;">'+data+'</div>',
                           scrolling:true,
                        });
                    }
                });
                
            });
        </script>
    </head>
    <body>
        <style>.sort{cursor:pointer;}
            .manage_sec .feebacks_sec li .package_name{
                width: 247px;
            }
            .manage_sec .feebacks_sec li .product_name{
                width: 347px !important;
            }
            /* .left_sec{
                 width: 100%;
             }
             .left_sec li{
                 width: 50%;
             }*/
            .order_sec{ margin-bottom:10px;}

        </style>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"> </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div class="wholesalerHeaderSection" style="width:100%;height:50px; padding-top:16px;	  border-bottom:1px solid #e7e7e7"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_container " style="padding: 0px 0 19px 0">

                        <?php
                        if ($objCore->displaySessMsg())
                        {
                            echo '<div style="text-align:center;color:#629F20;">' . $objCore->displaySessMsg() . '</div>';
                            $objCore->setSuccessMsg('');
                            $objCore->setErrorMsg('');
                        }
                        ?>
                    </div>
                    <div class="body_inner_bg">
                        <div class="add_edit_pakage manage_sec wish_sec">
                            <div class="product_link"><a style="margin-right:8px;"  href="<?php echo $objCore->getUrl('add_new_package.php', array('action' => 'add')); ?>" class="multiple_link"><?php echo CREATE_NEW_PACKAGE; ?></a>
                                <span class="add_link" id="spButton"><?php echo SEARCH_PACKAGE; ?></span>
                            </div>
                            <div class="order_sec">
                                <form action="" method="post" name="order_filter" id="order_filter" >
                                    <ul class="left_sec">
                                        <li>
                                            <label><?php //echo PACKAGE;  ?>Package <?php echo NAME; ?></label>
                                            <input class="ac_input_txt" type="text" value="<?php echo $_POST['PackageName'] ?>" name="PackageName" style="width:320px;" />
                                            <input type="submit" class="submit2 submit3" value="Search" style="margin-top:10px; float:left;" />
                                            <!--<a href="<?php echo $objCore->getUrl('manage_packages.php'); ?>" style="margin-top:10px;float:left;">-->
                                                <input style="margin-top:10px;float:left;" type="button" onclick="window.location.href='<?php echo $objCore->getUrl('manage_packages.php'); ?>'" class="submit2 cancel" value="Cancel"/>
                                            <!--</a>-->
                                        </li>
                                    </ul>
                                    <ul class="left_sec right"
                                        <li>
                                            <label><?php echo PROD_NAME; ?> </label>
                                            <input class="ac_input_txt" type="text" value="<?php echo $_POST['ProductName'] ?>" name="ProductName" style="width:320px;" />

                                        </li>


                                    </ul>

                                    <input type="hidden" name="search" value="search" />
                                </form>
                            </div>   

                            <form id="filter_form" action="" method="post">
                                <input type="hidden" name="sort_column" id="sort_column" value="" />
                                <input type="hidden" name="sort_order" id="sort_order" value="desc" />
                            </form>

							
							<div class="table-responsive">
                            <table border="0" class="manage_table">
                                <tr>
                                    <th class="sort linkCustomeHover" order="<?php echo $_POST['sort_order'] == 'desc' ? 'asc' : 'desc' ?>" col="PackageName"><?php echo PACKAGE_NAME; ?></th>
                                    <th><?php echo PROD_NAME; ?></th>
                                    <th><?php echo PROD_PACKAGE; ?></th>
                                    <th class="sort linkCustomeHover" order="<?php echo $_POST['sort_order'] == 'desc' ? 'asc' : 'desc' ?>" col="PackagePrice"><?php echo PACK_PRICE; ?></th>
                                    <th><?php echo ACTION; ?></th>
                                </tr>
                                <?php
                                if (count($objPage->arrPackageList) > 0)
                                {
                                    $varCounter = 0;
                                    foreach ($objPage->arrPackageList as $val)
                                    {
                                        $varCounter++;
                                        ?>    
                                        <tr class="<?php echo $varCounter % 2 == 0 ? 'even' : 'odd'; ?>">
                                            <td><?php echo $val['PackageName'] ?></td>
                                            <td  style="width:500px;"><?php echo $val['ProductName'] ?></td>
                                            <td align="center" ><a href="javascript:void(0)" style="margin-left:51px;height: 8px;margin-left: 51px;padding: 8px 9px 15px;" class="linkPop multiple_link" popPackageID="<?php echo $val['pkPackageId'];?>">View</a></td>
                                            <td><?php echo $objCore->getPrice($val['PackagePrice']); ?></td>
                                            <td><a title="Edit package" href="<?php echo $objCore->getUrl('edit_package.php', array('action' => 'edit', 'pkid' => $val['pkPackageId'])); ?>" class="edit active"></a>
                                                <a title="Delete package" href="<?php echo $objCore->getUrl('manage_packages.php', array('action' => 'delete', 'pkid' => $val['pkPackageId'])); ?>" onclick="return confirm('<?php echo R_U_SURE_DELETE_PACKAGE; ?>');" class="red_cross2 active"></a></td>
                                        </tr>
    <?php }
}
else
{
    ?>
                                    <tr class="odd">
                                        <td colspan="4"><?php echo FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG3; ?></td>

                                    </tr>
<?php } ?>    
                            </table>
</div>							

<?php if (count($objPage->arrPackageList) > 0)
{ ?>
                                <table width="100%">
                                    <tr><td colspan="10">&nbsp;</td></tr>
                                    <tr>
                                        <td colspan="10">
                                            <table width="100%" border="0" align="center">
                                                <tr>
                                                    <td style="font-weight:bolder; text-align:right;" colspan="10" align="right">
    <?php
    if ($objPage->varNumberPages > 1)
    {
        $objPage->displayFrontPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
    }
    ?>
                                                    </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr></table>
        <?php } ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html> 
