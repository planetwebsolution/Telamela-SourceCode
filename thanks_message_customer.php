<?php require_once 'common/config/config.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thanks message - Wholesaler</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){ 
                $('.drop_down1').sSelect();
                setTimeout(function(){ window.location.href="index.php" }, 20000);
            });
        </script>
    </head>
    <body>
         <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header"><div class="layout">
               
        </div>
       </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
              

                <div class="add_pakage_outer">
                      <div class="top_header border_bottom">
    <h1>Thank You</h1>
   
</div>             
                    <div class="body_inner_bg radius">
                        <div class="thans_sec">
                            <h1>Congratulations</h1>
                            <p align="center"><strong>Thank you for submitting the Customer Register form.</strong></p>
                            <p align="center">We have send a verification email to your registered email id. Kindly verify Your email id.</p>
                            <span><img src="common/images/right_img.png" alt=""/></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <?php include_once 'common/inc/footer.inc.php';?>


    </body>
</html> 
