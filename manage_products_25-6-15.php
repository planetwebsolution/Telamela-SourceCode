<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_MANAGE_PRODUCT_CTRL;
global $objCore;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MANAGE_PRODUCT_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script type='text/javascript' src='<?php echo JS_PATH . "jquery.autocomplete.js"; ?>'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH . 'jquery.autocomplete.css'; ?>" />
        <script type="text/javascript" src="<?php echo JS_PATH ?>product_listing.js"></script>
        <!-- select2 -->
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>           
        <script src="<?php echo JS_PATH ?>select2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.order_sec').addClass('<?php echo count($_POST) ? "show" : "hide"; ?>');
                $(".select2-me").select2();
                $('body').on('click', '#rtButton', function() {
                    $('.ratedClass').toggle();
                });
            });
        </script>
        <style type="text/css">
            .sort{
                cursor:pointer;
            }
            .ratedClass{
                display: none;
            }
            .product_link{
                width:685px; 
            }
            .stylish-select .drop4 .newListSelected{ width:271px !important;}
            .manage_table tr td:last-child{ width:120px; }
            .select2-container .select2-choice{height: 38px !important;
                                               padding: 4px 8px !important; font-size:13px}
            .stylish-select .drop4 .newListSelected{ height:40px;}
            .select2-container .select2-choice span {
                background: url("common/images/select2.png") no-repeat scroll 122% 3px #fff;
                display: block;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .stylish-select .drop4 .selectedTxt {
                background: url("common/images/select2.png") no-repeat scroll 122% 7px #fff; width:230px;
            }
            .ac_results{width:320px !important}
        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout">

            </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>
        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%;height:50px; padding-top:16px;border-bottom:1px solid #e7e7e7;" class="wholesalerHeaderSection"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">

                <?php
                if ($objCore->displaySessMsg()) {
                    ?>
                    <div style="text-align:center; color:red;">
                        <?php
                        echo $objCore->displaySessMsg();
                        $objCore->setSuccessMsg('');
                        $objCore->setErrorMsg('');
                        ?>
                    </div>
                <?php }
                ?>
                <div class="add_pakage_outer">
                    <div class="top_container " style="padding:0 0 19px 0">

                        <?php
                        if ($objCore->displaySessMsg()) {
                            echo '<div style="text-align:center; color:#629F20;">' . $objCore->displaySessMsg() . '</div>';
                            $objCore->setSuccessMsg('');
                            $objCore->setErrorMsg('');
                        }
                        ?>
                    </div>

                    <div class="body_inner_bg">
                        <div class="add_edit_pakage aapplication_form aapplication_form2 manage_product wish_sec">
                            <div class="product_link">
                                <a href="<?php echo $objCore->getUrl('add_edit_product.php', array('action' => 'add')); ?>" class="add_link"><?php echo ADD; ?> <?php echo PRODUCTS; ?></a>
                                <a  href="<?php echo $objCore->getUrl('bulk_uploads.php', array('action' => 'addMutiple')); ?>" class="multiple_link"><?php echo BULK_UPLOAD_TITLE; ?>  </a>
                                <span class="add_link" id="spButton"><?php echo SRCH_PRODUCTS; ?></span>

                                <?php
                                if (count($objPage->arrProductRatedList) > 0) {
                                    ?>
                                    <span class="add_link" id="rtButton">Rated Product</span>
                                <?php } ?>
                            </div>
                            <div class="order_sec" style="margin-bottom:10px; width:100%">
                                <form id="filter_form" action="" method="post">
                                    <ul class="left_sec">
                                        <li style="margin-bottom:6px">
                                            <label><?php echo PROD_NAME; ?></label>
                                            <input name="frmProductName" id="frmProductName" type="text" value="<?php echo @$_POST['frmProductName'] ?>"/>

                                        </li>
                                        <li style="margin-bottom:10px; float:left;">
                                            <label><?php echo CATEGORY_TITLE; ?></label>
                                            <div class="drop4 dropdown_2">
                                                <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmCategory', 'frmfkCategoryID', array($_POST['frmCategory']), 'Select Category', 0, 'class="select2-me" style="width:324px"', '1', '1'); ?>
                                            </div>
                                        </li>

                                        <li class="create_cancle_btn cb">
                                            <label>&nbsp;</label>
                                            <input type="submit" class="submit2 orange_btn" value="Search"/>
                                            <!--<a href="<?php echo $objCore->getUrl('manage_products.php'); ?>">-->
                                                <input onclick="window.location.href='<?php echo $objCore->getUrl('manage_products.php'); ?>'" type="button" class="submit2 cancel" value="Cancel"/>
                                            <!--</a>-->
                                        </li>
                                    </ul>
                                    <ul class="left_sec right">
                                        <li class="cb" style="float:left; margin-bottom:6px;">
                                            <label><?php echo IN_STOCK; ?></label>
                                            <div class="drop4">
                                                <select name="frmInStock" class="drop_down1">
                                                    <option <?php echo $_POST['frmInStock'] ? 'selected' : ''; ?> value="1">Yes</option>
                                                    <option <?php echo isset($_POST['frmInStock']) && (!$_POST['frmInStock']) ? 'selected' : ''; ?> value="0">No</option>
                                                </select>
                                            </div>
                                        </li>
                                        <li class="cb" style="margin-top:10px;">
                                            <label><?php echo PRO_REF_NO; ?></label>
                                            <input name="frmProductRef" type="text" class="frmProductRef" value="<?php echo @$_POST['frmProductRef'] ?>"/>
                                        </li>
                                    </ul>
                                    <input type="hidden" name="sort_column" id="sort_column" value="" />
                                    <input type="hidden" name="sort_order" id="sort_order" value="desc" />
                                    <input type="hidden" name="search" value="1" />
                                    <input type="hidden" name="frmHidden" value="search" />
                                </form>
                            </div>


                            <ul id="rated_pro_table" class="feebacks_sec feebacks_sec2 ratedClass">
                                <li class="heading">

                                    <span class="product prod_name">Rated <?php echo PROD_NAME; ?></span>
                                    <span class="date category"><?php echo CATEGORY_TITLE; ?></span>
                                    <span class="read dis"><?php echo DIS_PRICE; ?></span>
                                    <span class="status price"><?php echo PRICE; ?></span>
                                    <span class="status stock"><?php echo IN_STOCK; ?></span>
                                    <span class="action">Action</span>

                                </li>
                                <?php
                                if (count($objPage->arrProductRatedList) > 0) {
                                    $varCounter = 0;
                                    foreach ($objPage->arrProductRatedList as $varProduct) {
                                        $varCounter++;
                                        ?>
                                        <li <?php echo $varCounter % 2 == 0 ? 'class="bg_color gre"' : ''; ?> >
                                            <!--<span class="customer"><?php //echo $varProduct['ProductRefNo']            ?></span>-->
                                            <span class="product prod_name"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $varProduct['pkProductID'], 'name' => $varProduct['ProductName'], 'refNo' => $varProduct['ProductRefNo'])); ?>" target="_bank"><?php echo $varProduct['ProductName'] ?></a></span>
                                            <span class="date category"><?php echo $varProduct['CategoryName'] ?></span>
                                            <span class="read dis sort"><?php echo ($varProduct['DiscountFinalPrice'])>0?'$' . number_format($varProduct['DiscountFinalPrice'], 2):'$' . number_format($varProduct['FinalPrice'], 2) ?></span>
                                            <span class="status price sort"><?php echo '$' . number_format($varProduct['FinalPrice'], 2) ?></span>
                                            <span class="status stock"><?php echo $varProduct['Quantity']; ?></span>
                                            <span class="action action1 action2 ac<?php echo $varCounter; ?>">
                                                <a title="Edit Product" href="<?php echo $objCore->getUrl('add_edit_product.php', array('action' => 'edit', 'pid' => $varProduct['pkProductID'])); ?>" class="edit active" style="margin-left:60px;"></a>
                                                <?php
                                                if (!$varProduct['pkgid']) {
                                                    ?>
                                                    <a title="Delete Product" class="red_cross2 active" href="<?php echo $objCore->getUrl('manage_products.php', array('action' => 'delete', 'pid' => $varProduct['pkProductID'])); ?>" onClick="return confirm('<?php echo SURE_DEL_PRODUCT; ?>')"></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a title="Edit Package" class="red_cross2 active" href="<?php echo $objCore->getUrl('edit_package.php', array('action' => 'edit', 'pkid' => $varProduct['pkgid'])); ?>" onClick="return confirm('<?php echo THIS_PRODUCT_USE_IN_PACKAGE; ?>')"></a>
                                                <?php } ?>
                                            </span>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>

							<div class="table-responsive">
                            <table border="0" class="manage_table">
                                <tr>
                                    <th class="sort linkCustomeHover" order="<?php echo $_POST['sort_order'] == 'desc' ? 'asc' : 'desc' ?>" col="ProductRefNo"><?php echo PRO_REF_NO; ?>.</th>
                                    <th class="sort linkCustomeHover" order="<?php echo $_POST['sort_order'] == 'desc' ? 'asc' : 'desc' ?>" col="ProductName"><?php echo PROD_NAME; ?></th>
                                    <th><?php echo CATEGORY_TITLE; ?></th>
                                    <th class="sort linkCustomeHover" order="<?php echo $_POST['sort_order'] == 'desc' ? 'asc' : 'desc' ?>" col="DiscountFinalPrice"><?php echo DIS_PRICE; ?></th>
                                    <th class="sort linkCustomeHover" order="<?php echo $_POST['sort_order'] == 'desc' ? 'asc' : 'desc' ?>" col="FinalPrice"><?php echo PRICE; ?></th>
                                    <th><?php echo IN_STOCK; ?></th>
                                    <th><?php echo ACTION; ?></th>
                                </tr>
                                <?php
//pre($objPage->arrProductList);
                                if (count($objPage->arrProductList) > 0) {
                                    $varCounter = 0;
                                    foreach ($objPage->arrProductList as $varProduct) {
                                        $varCounter++;
                                        $countAttr=$objCore->getProductAttribute($varProduct['pkProductID']);
                                        ?>
                                        <tr class="<?php echo $varCounter % 2 == 0 ? 'even' : 'odd'; ?>">
                                            <td><?php echo $varProduct['ProductRefNo'] ?></td>
                                            <td><a class="manage-pro-name" title="view details" href="<?php echo $objCore->getUrl('product.php', array('id' => $varProduct['pkProductID'], 'name' => $varProduct['ProductName'], 'refNo' => $varProduct['ProductRefNo'])); ?>" target="_bank"><?php echo $varProduct['ProductName'] ?></a></td>
                                            <td style="width:260px;"><?php echo $varProduct['CategoryName'] ?></td>
                                            <td><?php echo ($varProduct['DiscountFinalPrice'])>0?'$' . number_format($varProduct['DiscountFinalPrice'], 2):'$' . number_format($varProduct['FinalPrice'], 2) ?></td>
                                            <?php if($countAttr>0){ ?>
                                            <td><a class="manage-pro-name" href="<?php echo $objCore->getUrl('add_edit_product_price.php', array('action' => 'price', 'pid' => $varProduct['pkProductID'])); ?>" class="active" title="You can enter attribute wise price from here"><?php echo '$' . number_format($varProduct['FinalPrice'], 2) ?></a></td>
                                            <?php }else{ ?>
                                            <td><?php echo '$' . number_format($varProduct['FinalPrice'], 2) ?></td>
                                            <?php } ?>
                                            <?php if($countAttr>0){ ?>
                                            <td><a class="manage-pro-name" href="<?php echo $objCore->getUrl('add_edit_product_inventory.php', array('action' => 'inventory', 'pid' => $varProduct['pkProductID'])); ?>" class="active" title="Manage product inventory"><?php echo $varProduct['Quantity']; ?></a></td>
                                            <?php }else{ ?>
                                            <td><?php echo $varProduct['Quantity']; ?></td>
                                            <?php } ?>
                                            <td><a title="Edit Product"  href="<?php echo $objCore->getUrl('add_edit_product.php', array('action' => 'edit', 'pid' => $varProduct['pkProductID'])); ?>" class="edit active"></a>
                                                <?php
                                                if($varProduct['offer']>0){ ?>
                                                    <a title="Delete Product" class="red_cross2 active" href="javascript:;" onClick="return confirm('<?php echo OFFER_DEL_PRODUCT; ?>')"></a>
                                               <?php }
                                                else if (!$varProduct['pkgid']) {
                                                    ?>
                                                    <a title="Delete Product" class="red_cross2 active" href="<?php echo $objCore->getUrl('manage_products.php', array('action' => 'delete', 'pid' => $varProduct['pkProductID'])); ?>" onClick="return confirm('<?php echo SURE_DEL_PRODUCT; ?>')"></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a title="Edit Package" class="red_cross2 active" href="<?php echo $objCore->getUrl('edit_package.php', array('action' => 'edit', 'pkid' => $varProduct['pkgid'])); ?>" onClick="return confirm('<?php echo THIS_PRODUCT_USE_IN_PACKAGE; ?>')"></a>
                                                <?php } ?> </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr class="odd">
                                        <td colspan="7"><?php
                                            if ($_POST['search']) {
                                                echo FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG2;
                                            } else {
                                                echo FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG1;
                                            }
                                            ?></td>
                                    </tr>

                                <?php } ?>
                            </table>
                            </div>
							<?php
                            if (count($objPage->arrProductList) > 0) {
                                ?>
                                <table width="100%">
                                    <tr><td colspan="10">&nbsp;</td></tr>
                                    <tr>
                                        <td colspan="10">
                                            <table width="100%" border="0" align="center">
                                                <tr>
                                                    <td style=" text-align:right;" colspan="10" align="right">
                                                        <?php
                                                        if ($objPage->varNumberPages > 1) {
                                                            $objPage->displayFrontPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr></table>
                            <?php } ?>


                            <div class="product_link">
                                <a href="<?php echo $objCore->getUrl('add_edit_product.php', array('action' => 'add')); ?>" class="add_link"><?php echo ADD; ?> <?php echo PRODUCTS; ?></a>
                                <a  href="<?php echo $objCore->getUrl('bulk_uploads.php'); ?>" class="multiple_link"><?php echo BULK_UPLOAD_TITLE; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>