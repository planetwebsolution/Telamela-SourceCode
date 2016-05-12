<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_REVIEW_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo REVIEW_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <!-- select2 -->
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>
        <script src="<?php echo JS_PATH ?>select2.min.js"></script>
        <script type='text/javascript' src='<?php echo JS_PATH . "jquery.autocomplete.js"; ?>'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH . 'jquery.autocomplete.css'; ?>" />
        <script type="text/javascript" src="<?php echo JS_PATH ?>product_listing.js"></script>
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
            .sort{cursor:pointer;}
            .ratedClass{display: none;}
            .product_link{width:685px;}
            .stylish-select .drop4 .newListSelected{ width:271px !important;}
            .manage_table tr td:last-child{ width:120px; }
            .select2-container .select2-choice{height: 38px !important;padding: 4px 8px !important; font-size:13px}
            .stylish-select .drop4 .newListSelected{ height:40px;}
            .select2-container .select2-choice span {background: url("common/images/select2.png") no-repeat scroll 122% 3px #fff;
                                                     display: block;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}
            .stylish-select .drop4 .selectedTxt {background: url("common/images/select2.png") no-repeat scroll 122% 7px #fff; width:230px;            }
            .ac_results{width: 321px !important}
           .li_botspace{margin-bottom:10px; width:100%; display:inline-block;}
        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"> </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div class="wholesalerHeaderSection" style="width:100%;height:50px; padding-top:20px;border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_container " style="padding: 0px 0 19px 0">

                    </div>

                    <div class="body_inner_bg">
                        <div class="add_edit_pakage product_rev_sec wish_sec">
                            <div class="product_link">
                                <span class="add_link" id="spButton">Search Reviews</span>
                            </div>
                            <div class="order_sec" style="margin-bottom:10px; width:100%">
                                <form id="filter_form" name="searchReviews" action="" method="post">
                                    <ul class="left_sec">
                                        <li class="li_botspace">
                                            <label><?php echo PROD_NAME; ?></label>
                                            <input name="frmProductName" id="frmProductName" type="text" value="<?php echo @$_POST['frmProductName'] ?>"/>

                                        </li>
                                        <li style="margin-bottom:10px; float:left;">
                                            <label><?php echo CATEGORY_TITLE; ?></label>
                                            <div class="drop4 dropdown_2">
                                                <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmCategory', 'frmfkCategoryID', array($_POST['frmCategory']), 'Select Category', 0, 'class="select2-me" style="width:324px"', '1', '1'); ?>
                                            </div>
                                        </li>

                                        
                                        
                                    </ul>
                                    <ul class="left_sec right">
                                        <li class="cb" style="float:left; margin-bottom:6px;">
                                            <label>Product ID</label>
                                            <input name="frmProductID" type="text" class="frmProductRef" value="<?php echo @$_POST['frmProductID'] ?>"/>
                                        </li>                                     
                                    </ul>
                                   <ul class="left_sec" style="clear:left;">
                                         <li class="create_cancle_btn cb">
                                            <label>&nbsp;</label>
                                            <input type="submit" class="submit2 orange_btn" value="Search"/>
                                            <input onclick="window.location.href='<?php echo $objCore->getUrl('product_reviews.php'); ?>'" type="button" class="submit2 cancel" value="Cancel"/>
                                        </li>
                                    </ul>                                   
                                    <input type="hidden" name="search" value="1" />
                                    <input type="hidden" name="frmHidden" value="search" />
                                </form>
                            </div>

							<div class="table-responsive">
                            <table border="0" class="manage_table">
                                <tr>
                                    <th><?php echo PRO_ID; ?></th>
                                    <th><?php echo PROD_NAME; ?></th>
                                    <th><?php echo PRO_CAT; ?></th>
                                    <th><?php echo ACTION; ?></th>
                                </tr>
                                <?php
                                //pre($objPage->arrReviews);
                                $varCounter = 0;
                                if (count($objPage->arrReviews) > 0)
                                {
                                    foreach ($objPage->arrReviews as $review)
                                    {
                                        $varCounter++;
                                        ?>                       
                                        <tr class="<?php echo $varCounter % 2 == 0 ? 'even' : 'odd'; ?>">
                                            <td><?php echo ($review['ReviewWholesaler']) ? $review['pkProductID'] : '<strong>' . $review['pkProductID'] . '</strong>'; ?></td>
                                            <td><?php echo ($review['ReviewWholesaler']) ? $review['ProductName'] : '<strong>' . $review['ProductName'] . '</strong>'; ?></td>
                                            <td><?php echo ($review['ReviewWholesaler']) ? $review['CategoryName'] : '<strong>' . $review['CategoryName'] . '</strong>'; ?></td>
                                            <td><a class="viewbig" href="<?php echo $objCore->getUrl('read_reviews.php', array('pid' => $review['pkProductID'], 'place' => 'view')); ?>" title="view details"><i class="fa fa-eye"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <tr class="odd">
                                        <td colspan="3">
                                            <?php echo FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG7; ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </table>                           
							</div>
							
                            <?php
                            if (count($objPage->arrReviews) > 0)
                            {
                                ?>
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