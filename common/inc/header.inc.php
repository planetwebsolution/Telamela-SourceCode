<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
$objComman = new ClassCommon();
global $objGeneral;
//$objGeneral->insertVisitor();

?>
<div class="tpsction">
	<div class="top_header_section">
		<div class="headerRight">
			<div class="rightBottom">
				<form action="<?php echo $objCore->getUrl('category.php'); ?>" name="frmkeysearch" method="post" onsubmit="return catKeySubmit();">
                                    
					<div class="searchBlock">
						<div class="categories">
							<select name="cid" id="searchcid" class="my-dropdown">
								<option value="0"><?php echo SL_CAT; ?></option>
								<?php
                            foreach ($objPage2->arrData['arrCategoryListing'] as $cateKey => $cateVal) {
                                ?>
								<option value="<?php echo $cateVal['pkCategoryId']; ?>" <?php
                            if ($_GET['cid'] == $cateVal['pkCategoryId']) {
                                echo "selected";
                            }
                                ?>><?php echo $cateVal['CategoryName']; ?></option>
								<?php } ?>
							</select>
						</div>
						<input type="text" name="searchKey" id="searchKey" onclick="if(this.value=='<?php echo SEARCH_FOR_BRAND; ?>'){this.value = '';}" onfocus="if(this.value=='<?php echo SEARCH_FOR_BRAND; ?>'){this.value = '';}" onblur="if(this.value==''){this.value = '<?php echo SEARCH_FOR_BRAND; ?>';}" value="<?php echo (isset($_REQUEST['searchKey']) && $_REQUEST['searchKey'] <> '') ? $_REQUEST['searchKey'] : SEARCH_FOR_BRAND; ?>"/>
						<input type="submit" value="" class="search_icon"/>
                                                <div id="goodsMsgErMain" class="red" style="clear:both;display:none;width:100%;
                                 float:left;text-align:center;">Please enter valid Keyword</div>
					</div>
                                    
				</form>
                            
			</div>
		</div>
		<a class="logo" title="<?php echo SITE_NAME; ?>" href="<?php echo SITE_ROOT_URL; ?>"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>logo.png" alt="logo" border="0" /></a>
		<?php if (isset($menuHide)) { ?>
		<div class="spacial_img"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>spacial.png" alt="" border="0"/></div>
		<?php } else { ?>
	</div>
	<div class="navSection">
		<ul class="menu">
			<?php echo $objPage2->arrData['arrtopMenuTree'];?>
			<li class="last"> <a href="#">More >></a>
				<div class="dropdowns_outer">
					<div class="dropdowns_inner"> <?php echo $objPage2->arrData['arrtopDropTree']; ?> </div>
				</div>
			</li>
		</ul>
	</div>
	<?php } ?>
</div>
<script>
    (function () {
        // Create mobile element
        var mobile = document.createElement('div');
        mobile.className = 'nav-mobile';
        document.querySelector('.navSection').appendChild(mobile);

        // hasClass
        function hasClass(elem, className) {
            return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
        }

        // toggleClass
        function toggleClass(elem, className) {
            var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, ' ') + ' ';
            if (hasClass(elem, className)) {
                while (newClass.indexOf(' ' + className + ' ') >= 0) {
                    newClass = newClass.replace(' ' + className + ' ', ' ');
                }
                elem.className = newClass.replace(/^\s+|\s+$/g, '');
            } else {
                elem.className += ' ' + className;
            }
        }

        // Mobile nav function
        var mobileNav = document.querySelector('.nav-mobile');
        var toggle = document.querySelector('.menu');
        mobileNav.onclick = function () {
            toggleClass(this, 'nav-mobile-open');
            toggleClass(toggle, 'nav-active');
        };
		
        
    })();
     
</script>
<div class="cartMessage" id ="myCartMassage"></div>
