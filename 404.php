<?php
require_once 'common/config/config.inc.php';
require_once CLASSES_PATH . 'class_common.php';
$objComman = new ClassCommon ();
$arrCategoryData = $objComman->getCategories ();
// Set here category listing array
$arrCategoryData = $arrCategoryData [0];
// pre($arrCategoryData);
global $objCore;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo INDEX_TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>      
        <style>
.error_page {
	background: url(common/images/map.png) no-repeat;
	width: 1140px;
	height: 563px;
}
</style>
</head>
<body>
	<div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
	<div class="header">
		<div class="layout"></div>
	</div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
		<div class="layout">


			<div class="add_pakage_outer">
				<div class="body_inner_bg radius">
					<div class=" 404_page">

						<div class="error_page">
							<p align="center" class="lost">Let's guide you!</p>
							<p align="center" class="market">
								Go to home page, <a href="<?php echo SITE_ROOT_URL; ?>"
									class="link_404">click here</a>
							</p>
							<div class="girl">
								<img src="common/images/girl.png" alt="">
							
							</div>
							<div class="sections_cat">
                                    <?php
																																				foreach ( $arrCategoryData as $val ) {
																																					?>
                                        <a
									href="<?php echo $objCore->getUrl('landing.php', array('cid' => $val['pkCategoryId'], 'name' => $val['CategoryName'])) ?>"
									class="cat_sec"><?php echo $val['CategoryName']; ?></a>
                                        <?php
																																				}
																																				?>
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
