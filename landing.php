<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
$objComman = new ClassCommon();
require_once CONTROLLERS_PATH . FILENAME_LANDING_CTRL;
require_once CLASSES_PATH . 'class_home_bll.php';
$arrSpecialProductPrice = $objPage->arrData['arrSpecialProductPrice'];
 //echo $objPage->varBreadcrumbs;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo CATEGORY_LANDING_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script type="text/javascript">var pageLimit = <?php echo $objPage->pageLimit; ?>;</script>
        <style>
/*            .owl-carousel .owl-wrapper-outer{margin-left:-1px!important}.view img{margin:0 auto;text-align:center}.customNavigation{width:78px;float:right;margin-top:0}.prev8{width:39px;float:left}.next8{width:39px;float:left}.prev7{width:39px;float:left}.next7{width:39px;float:left}.owl-carousel{width:104%}*/
            .scroll-pane{height:233px !important;}
        </style>
        <script>
            $(function(){
              $('.scroll-pane').jScrollPane();  
            });
        </script>
    </head>
    <body>
        <div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
        <div class="header">	<div class="layout"> </div></div>
        <?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="bg">
            <div class="layout">
                <div class="successMessage">
                    <div class="addToCartMess" style="display:none;"></div>
                </div>
                <?php
                if ($objCore->displaySessMsg())
                {
                    ?>
                    <div class="successMessage">
                        <?php
                        echo $objCore->displaySessMsg();
                        $objCore->setSuccessMsg('');
                        $objCore->setErrorMsg('');
                        ?>
                    </div>
                <?php }  
                ?>
                <div class="addToCart">
                    <div class="addToCartClose" onclick="addToCartClose();">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <div class="addToCartMsg"></div>
                </div>
            </div>
        </div>
        <div class="layout">
            <?php include_once INC_PATH . 'landing_middle_part.php'; ?>
        </div><?php include_once INC_PATH . 'footer.inc.php'; ?>
    </body>
</html>