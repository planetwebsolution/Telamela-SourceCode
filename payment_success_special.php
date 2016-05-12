<?php
require_once 'common/config/config.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thanks for Payment</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>        
								<style>#countries_child{ z-index:99999999999999999!important }</style>
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
                     <div class="top_header border_bottom">
    <h1>Thank You</h1>
   
</div>            
                    <div class="body_inner_bg radius">
                        <div class="thans_sec">
                            <h1>Congratulations</h1>
                            <p><strong>Thank you for placing special application form.</strong></p>
                            <p style="font-weight: bold;">Your application will process in 2 days.</p>
                            <span style="padding-top: 43px"><img src="common/images/right_img.png" alt=""/></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>

    </body>
</html> 