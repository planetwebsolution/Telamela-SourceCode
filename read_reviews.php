<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_REVIEW_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title> <?php echo READ_REVIEW_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script  type="text/javascript" src="<?php echo JS_PATH; ?>read_review.js"></script>
        <style>.stylish-select .drop9 .selectedTxt{ border:1px solid #d2d2d2}
            .delete_icon1{ background: url(common/images/cross-hover.png) no-repeat 0 0;}
        </style>
        <script>
            $('.linkPop').live("click",function(){
                var inputID=$(this).attr('popinputID');
                var dataContent=$('#'+inputID).val();
                $.colorbox({html:'<div style="width:1000px;">'+dataContent+'</div>',
                           scrolling:true,
                           });
            });
        </script>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"></div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%;height:50px; padding-top:16px;border-bottom:1px solid #e7e7e7;" class="wholesalerHeaderSection"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_container " style="padding:20px 0 15px">
                        <div class="top_header border_bottom">
                            <h1><?php echo READ; ?> <span><?php echo REVIEW; ?></span></h1>
                            <a href="javascript: history.go(-1)" class="back_button">Back</a>

                        </div>
                    </div>
                    <?php include_once 'common/inc/wholesaler.header.inc.php'; ?>
                    <div class="body_container_inner_bg">
                        <div class="add_edit_pakage review_sec wish_sec">
                            <!-- <div class="back_ankar_sec">
                                 <a href="<?php //echo $objCore->getUrl('product_reviews.php');   ?>" class="back"><span><?php //echo BACK;   ?></span></a>
                             </div>-->
                            <?php if ($objPage->NumberofRows > 0)
                            {
                                ?>
                                <ul class="red_review_table"><!--change class="newsletter_sec"-->
                                    <li class="heading">
                                        <span class="date"><?php echo REVIEWER_NAME; ?></span>
                                        <span class="title"><?php echo DATE; ?></span>
                                        <span class="title">Rating</span>
                                        <span class="status"><?php echo COMMENTS; ?></span>
                                        <span class="action">Status</span>
<!--                                        <span class="action"><?php echo ACTION; ?></span>-->
                                    </li>
                                    <?php
                                    $varCounter = 0;
                                    foreach ($objPage->arrReviewDetail as $detail)
                                    {
                                        $varCounter++;
                                        $msgReview = count($detail['Reviews'] > 80) ? strlen($detail['Reviews']) > 80 ? substr($detail['Reviews'], 0, 80).'...' : $detail['Reviews'] : '';
                                        ?>
                                        <li <?php echo $varCounter % 2 == 0 ? '' : 'class="blue_bg"' ?>>
                                            <span class="date"><?php echo $detail['CustomerFirstName'] ?></span>
                                            <span class="title"><?php echo $objCore->localDateTime($detail['ReviewDateAdded'], DATE_FORMAT_SITE_FRONT); ?></span>
                                            <span class="title"><?php echo $detail['Rating']; ?></span>
                                            <span class="status"><a href="javascript:void(0)" class="linkPop " popinputID="<?php echo 'input_'.$varCounter;?>"><?php echo $msgReview; ?></a></span>
                                            <input id="<?php echo 'input_'.$varCounter;?>" value="<?php echo $detail['Reviews'];?>" type="hidden"/>
                                            <span class="action"><?php 
                                            if($detail['ApprovedStatus']== 'Pending'){ echo 'Pending';}else if($detail['ApprovedStatus']== 'Allow'){ echo 'Approved';}else if($detail['ApprovedStatus']== 'Disallow'){ echo 'Disapproved';}
                                            ?></span>
<!--                                            <span class="action msg_box_allw">
                                                <c id="msg<?php echo $detail['pkReviewID']; ?>" class="green"></c>
                                                <span class="drop9 bd_none">
                                                    <select style="float:left;margin-top:7px;" disabled class="update_status"  id="<?php echo $detail['pkReviewID'] . "_" . $detail['pkRateID']; ?>">
                                                        <option value="" <?php echo $detail['ApprovedStatus'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                        <option value="Allow" <?php echo $detail['ApprovedStatus'] == 'Allow' ? 'selected' : '' ?>><?php echo ALLOW ?></option>
                                                        <option value="Disallow" <?php echo $detail['ApprovedStatus'] == 'Disallow' ? 'selected' : '' ?>><?php echo DISALLOW; ?></option>
                                                    </select>

                                                    <a style="width:45px;" class="red_cross2 delete_icon1 margin_img" id="<?php echo $detail['pkReviewID'] . "_" . $detail['pkRateID']; ?>" href="#" title="Remove"></a>
                                                </span>

                                            </span>-->
                                        </li>

                                <?php } ?>
                                </ul>
                            <?php
                            }
                            else
                            {
                                ?>
                                <?php echo ADMIN_NO_RECORD_FOUND; ?>
                            <?php } ?>

<?php if (count($objPage->arrReviewDetail) > 0)
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
