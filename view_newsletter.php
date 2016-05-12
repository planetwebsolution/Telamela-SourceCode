<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_NEWSLETTER_CTRL;

$nlDetails = $objPage->arrNewsleterDetail[0];
//pre($nlDetails['Content']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo NEWSLETTER_REVIEW_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="common/css/sajid.css"/>
        <link rel="stylesheet" type="text/css" href="common/css/sajid-css3.css"/>
        <link rel="stylesheet" type="text/css" href="common/css/css3-2.css"/>
      
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script  type="text/javascript">
            $(document).ready(function(){
                $('.drop_down1').sSelect();
            });
        </script>
								<style>.bg_view{ border-bottom:1px solid #d2d2d2; border-left:0px; border-right:0px}</style>
    </head>
    <body>
                 <em> <div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
    
        </em>
       <div class="header" style="border-bottom:none"><div class="layout"></div>
               <?php include_once INC_PATH . 'header.inc.php'; ?>
        
       </div>
      
          
        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%;height:50px; padding-top:16px;	  border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">
             
                    
            

                <div class="add_pakage_outer">
                    <div class="top_container " style="padding: 19px 0 0px 0">
                        <div class="top_header border_bottom">
                            <h1><?php echo VW; ?> <?php echo NEWSLETTER; ?></h1>
                            <a href="javascript: history.go(-1)" class="back_button">Back</a>
                        </div>
                    </div>

                    <div class="body_container_inner_bg">
                        <div class="add_edit_pakage newlatter_sec"><a href="<?php echo $objCore->getUrl('newsletter.php'); ?>" class="back"><span><?php echo BACK; ?></span></a>
                            <?php
                            if (count($nlDetails) > 0)
                            {
                                ?>
                                <div class="creats_news_letter">
                                    <div class="appored_sec">
                                        <div class="stuts_text">
                                            <strong><?php echo DATE; ?>  : </strong>
                                            <span><?php echo $objCore->localDateTime($nlDetails['DeliveryDate'], DATE_FORMAT_SITE_FRONT); ?></span>
                                            <strong><?php echo TIME; ?>  :  </strong>
                                            <span><?php echo date('H:i:s', strtotime($nlDetails['DeliveryDate'])) ?></span>
                                            <strong><?php echo STATUS; ?>  : </strong>
                                            <span><?php echo $nlDetails['DeliveryStatus']; ?></span>
                                        </div>
                                    </div>
                                    <ul class="left_sec">
                                        <li>
                                            <label class="margin_none"><?php echo TITLE; ?> <strong>:</strong></label>
                                            <p class="content_text"><?php echo $nlDetails['Title'] ?></p>
                                        </li>
                                        <li class="last">
                                            <?php
                                            if ($nlDetails['NewsLetterType'] == 'content')
                                            {
                                                ?>
                                                <label ><?php echo CONTENT; ?><strong>:</strong></label>
                                                <div class="content_text">
                                                    <?php echo html_entity_decode(stripslashes($nlDetails['Content']),null,'utf-8') ?>
                                                </div>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <label class="margin_none"><?php echo TEMPLATE; ?><strong>:</strong></label>
                                                <div class="content_text">
                                                    <a href="<?php echo UPLOADED_FILES_URL . 'images/newsletter/' . $nlDetails['Template'] ?>" target="_blank"><img width="70" height="70" src="<?php echo UPLOADED_FILES_URL . 'images/newsletter/' . $nlDetails['Template'] ?>"  /></a>
                                                </div>
                                            <?php } ?>
                                        </li>
                                        <li style="margin-top: 20px;" class="last">
                                            <label class="margin_none"><?php echo REC; ?><strong>:</strong></label>
                                            <div class="input_sec">
                                                <ul class="feebacks_sec">
                                                    <li class="heading">
                                                        <span class="read"><strong><?php echo CUSTOMER; ?></strong></span>
                                                        <span class="date"><strong><?php echo EM_ID; ?></strong></span>
                                                    </li>
                                                    <?php
                                                    if (count($nlDetails['Recipients']) > 0)
                                                    {
                                                        $varCounter = 0;
                                                        foreach ($nlDetails['Recipients'] as $val)
                                                        {                                                      
                                                            $varCounter++;
                                                            ?>
                                                            <li <?php echo $varCounter % 2 == 0 ? 'class="bg_color"' : ''; ?> class="bg_view" >
                                                                <span class="read"><?php echo $val['CustomerFirstName'] ?></span>
                                                                <span class="date"><a href="<?php echo $val['CustomerEmail'] ?>"><?php echo $val['CustomerEmail'] ?></a></span>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    else
                                                        echo "<li>No Records Found!</li>";
                                                    ?>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <?php
                            }
                            else
                            {
                                echo '<br/><br/>' . ADMIN_NO_RECORD_FOUND;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>