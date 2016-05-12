<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CMS_CTRL;
?> 
<?php //pre($objPage->arrCmsDetails);                 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo strip_tags($objPage->arrCmsDetails[0]['PageTitle']); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="description" content="<?php echo strip_tags($objPage->arrCmsDetails[0]['PageDescription']); ?>"/>
        <meta name="keywords" content="<?php echo strip_tags($objPage->arrCmsDetails[0]['PageKeywords']); ?>"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.js"></script>
        <script type="text/javascript">
            $(function(){
                $('.scroll-pane').jScrollPane();
            });
        </script>
        <style>
            .scroll-pane{height:400px; }
        </style>

    </head>
    <body>
        <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <?php include_once INC_PATH . 'header.inc.php'; ?>

        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <h1><?php echo strip_tags($objPage->arrCmsDetails[0]['PageTitle']); ?></h1>

                    </div> <div class="body_inner_bg radius">
                        <div class="add_pakage content_sec">
                            <div class="scroll-pane">
                                <div class="content_inner">
                                    <?php echo stripslashes($objPage->arrCmsDetails[0]['PageContent']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html> 
