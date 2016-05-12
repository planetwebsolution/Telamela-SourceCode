<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_FEEDBACK_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo FEEDBACK_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script  type="text/javascript" src="<?php echo JS_PATH ?>customer_feedback.js"></script>        
        <style type="text/css">.top_company .top_account li label strong{margin-top:0px;}  p{margin:0px !important;}</style>
    </head>
    <body>

        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"></div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div class="wholesalerHeaderSection" style="width:100%;height:50px; padding-top:20px;	  border-bottom:1px solid #e7e7e7;">
                <div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_container">
                    </div>

                    <div class="body_inner_bg">
                        <div class="add_edit_pakage aapplication_form aapplication_form2 wish_sec">
                            <div class="top_company">
                                <ul class="feebacks_sec" style="width: 100%!important;">
                                    <li class="heading" style="background:#0079ff">
                                        <span class="customer" style="width: 25%;"><?php echo CUS_NAME; ?></span>
                                        <span class="product" style="width: 25%;"><?php echo PRO_ID; ?></span>
                                        <span class="date" style="width: 25%;"><?php echo FEED_DATE; ?></span>
                                        <span class="read" style="width: 25%; text-align:center"><?php echo REED_FEED; ?></span>
                                    </li>

                                    <?php
                                    $varCounter = 0;
                                    $vagetiveClass = '';
                                    if (count($objPage->arrFeedbacks) > 0)
                                    {
                                        foreach ($objPage->arrFeedbacks as $details)
                                        {
                                            //pre($details);
                                            $varCounter++;
                                            $num = $varCounter % 2;
                                            $arrYesNO = array('No', 'Yes');
                                            
                                            ?>
                                            <li <?php
                                    echo ($details['IsPositive']=='1')?'': 'class="bg_color red"';
                                            ?>>
                                                <span class="customer"><?php echo ($details['feedbackUpdate']) ? $details['CustomerFirstName'] : '<strong>' . $details['CustomerFirstName'] . '</strong>'; ?></span>
                                                <span class="product" style="width:25%;"><?php echo ($details['feedbackUpdate']) ? $details['fkProductID'] : '<strong>' . $details['fkProductID'] . '</strong>'; ?></span>
                                                <span class="date" style="width:25%"><?php echo ($details['feedbackUpdate']) ? $objCore->localDateTime($details['FeedbackDateAdded'], DATE_FORMAT_SITE_FRONT) : '<strong>' . $objCore->localDateTime($details['FeedbackDateAdded'], DATE_FORMAT_SITE_FRONT) . '</strong>'; ?></span>
                                                <span class="" style="width:25%; float:left; text-align:center; padding-top:15px;">
                                                    <a title="view details" class="<?php echo $details['pkFeedbackID'] ?> viewbig" href="#<?php echo $details['pkFeedbackID'] ?>" onclick="wholesalerFeedbackPopup(<?php echo $details['pkFeedbackID'] ?>)" id="feedbackUpdate" fid="<?php echo $details['pkFeedbackID'] ?>"><i class="fa fa-eye"></i></a>

                                                </span>

                                                <div style="display: none;">
                                                    <div id="<?php echo $details['pkFeedbackID'] ?>" class="common_popup_box">
                                                        <div class="div_blank">
                                                            <div class="post_fdback">
                                                                <div class="q_text"><strong>Ques:-</strong><?php echo FRONT_FEEDBACK_QUESTION1; ?></div>
                                                                <div class="q_ans" id="answer1">Ans:- <?php echo $arrYesNO[$details['Question1']]; ?></div>
                                                                <div class="q_text">Ques:-<?php echo FRONT_FEEDBACK_QUESTION2; ?></div>
                                                                <div class="q_ans" id="answer2">Ans:- <?php echo $arrYesNO[$details['Question2']]; ?></div>
                                                                <div class="q_text">Ques:-<?php echo FRONT_FEEDBACK_QUESTION3; ?></div>
                                                                <div class="q_ans" id="answer3">Ans:-<?php echo $arrYesNO[$details['Question3']]; ?></div>
                                                                <div class="q_text"><?php echo COMMENTS; ?>:</div>
                                                                <div class="q_ans" id="answer4">Ans:- <?php echo ($details['Comment']) ? $details['Comment'] : 'NA'; ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo '<li class="no_resutl_found">' . FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG8 . '</li>';
                                    }
                                    ?>
                                </ul>
                                <?php
                                if (count($objPage->arrFeedbacks) > 0)
                                {
                                    ?>
                                    <ul>
                                        <li <?php echo $num == 1 ? 'class="bg_color"' : ''; ?>><table width="100%">
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
                                                </tr></table></li>
                                    </ul>
                                <?php } ?>
                                <!--    <div class="top_company_right" style="margin-top: 0;">
                                        <h3><?php echo KPI; ?>: <?php echo $objPage->kpi['kpi']; ?></h3>
                                        <div class="right_scroll" style="width:100%">
                                            <strong style="width:94%;"><?php echo WAR; ?></strong>
                                <?php
                                if (!empty($objPage->arrWholesalerWarnings))
                                {
                                    foreach ($objPage->arrWholesalerWarnings as $var)
                                    {
                                        echo '<p href="#' . $var['pkWarningID'] . '" class="' . $var['pkWarningID'] . ' dash-whl-kpi" onclick="wholesalerWarningPopup(' . $var['pkWarningID'] . ');">' . ucfirst(substr($var['WarningText'], 0, 60)) . ' ...' . '</p><small>' . $objCore->localDateTime($var['WarningDateAdded'], DATE_TIME_FORMAT_SITE_FRONT) . '</small>';
                                        echo '<div style="display:none;"><div id="' . $var['pkWarningID'] . '" class="common_popup_box"><div class="div_blank"><p align="justify;">' . html_entity_decode($var['WarningMsg']) . '</p></div></div></div>';
                                    }
                                }
                                else
                                {
                                    echo NO_WAR;
                                }
                                ?>
                                        </div>
                                    </div>-->
                            </div>

                            <p class="negativefeedback">*Negative feedback described as red</p>
                        </div>


                    </div>
                </div>
            </div>
        </div>        
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>