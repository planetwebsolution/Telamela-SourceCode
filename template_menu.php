	<div class="Menubar">
		<ul class="MainMenu">
                    <?php
                    if(count($objPage->arrParentCategoryMenu)>0){ 
                        foreach($objPage->arrParentCategoryMenu as $menu){?>
                            <li id="<?php echo trim($menu['pkCategoryId']);?>"><a href="javascript:void(0)" class="categorySubMen"><?php echo trim($menu['CategoryName']);?><span></span></a></li>
                       <?php }
                    }
                    ?>
		</ul>
	</div>
