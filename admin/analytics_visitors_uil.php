<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_REPORTS_CTRL;
require_once CLASSES_SYSTEM_PATH . 'class_session_redirect_bll.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Apple devices fullscreen -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Apple devices fullscreen -->
        <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <title><?php echo ADMIN_PANEL_NAME; ?> : Reports & Analytics</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" media="all" />
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
		<!-- Flot -->
		<script type="text/javascript" src="js/plugins/flot/jquery.flot.js"></script>
		<script src="js/plugins/flot/jquery.flot.bar.order.min.js"></script>
		<script src="js/plugins/flot/jquery.flot.pie.min.js"></script>
		<script src="js/plugins/flot/jquery.flot.resize.min.js"></script>
		<script src="js/plugins/flot/jquery.flot.stack.js"></script>
		<script src="js/plugins/flot/jquery.flot.JUMlib.js"></script>
		<script src="js/plugins/flot/jquery.flot.spider.js"></script>
		<script>
		    $(function(){
			visitorsGraph('currentLastMonth','<?php echo json_encode($objPage->arrData['content']);?>');
		    });
		</script>
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content" style="min-height:1000px">
	    <?php require_once 'inc/reports_left_menu.php'; ?>
            <div id="main" class="left_align">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Visitors</h1>
                        </div>
                    </div>
		    <div class="breadcrumbs">
			<ul>
			    <li>
				<a href="dashboard.php">Home</a>
				<i class="icon-angle-right"></i>
			    </li>
			    <li>
				<a href="analytics_uil.php">Reports & Analytics</a>
				<i class="icon-angle-right"></i>
			    </li>				
			    <li>
				<span>Visitors</span>
			    </li>
			</ul>
			<div class="close-bread">
				<a href="#"><i class="icon-remove"></i></a>
			</div>
		    </div>
		    <div class="row-fluid search_in_order">
			<div class="span12">
			    <div class="box box-color">
				<div class="box-content nopadding">				    
				    <div class="tab-content padding tab-content-inline tab-content-bottom">
					<div class="tab-pane active" id="visitorsContainer">
					    <div class="statistic-big">
						<div class="bottom">
							<div class="flot medium" id="flot-audience"></div>
						</div>
					    </div>
					</div>					
				    </div>
				</div>	
			    </div>
			</div>
		    </div>
                </div>
            </div>            
        </div>
	<?php require_once('inc/footer.inc.php'); ?>
    </body>
</html>