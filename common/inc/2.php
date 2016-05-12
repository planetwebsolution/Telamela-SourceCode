<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
$objCore = new Core();
$arrCurrencyList = $objCore->currencyList();
$arrCurrencyListNew = $objCore->currencyListNew();

$objComman = new ClassCommon();
global $objGeneral;
$objGeneral->insertVisitor();
//unset($_SESSION['MyCart']);
//echo '<pre>';print_r($_SESSION['MyCart']);

?>
<link rel="stylesheet" type="text/css" href="<?php echo PATH_URL_CM;?>dp/css/msdropdown/dd.css" />
<script src="<?php echo PATH_URL_CM;?>dp/js/msdropdown/jquery.dd.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo PATH_URL_CM;?>/css/megamenu.css" />
<link rel="stylesheet" type="text/css" href="<?php echo PATH_URL_CM;?>dp/css/msdropdown/flags.css" />
<link href='http://fonts.googleapis.com/css?family=Lato:400,900,700,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
<script>
    $(document).ready(function(){
        $("#countries").msDropdown();
    });
</script>
<script>
$(document).ready(function($){
    $('.megamenu').megaMenuCompleteSet({
        menu_speed_show : 100, // Time (in milliseconds) to show a drop down
        menu_speed_hide : 200, // Time (in milliseconds) to hide a drop down
        menu_speed_delay : 5, // Time (in milliseconds) before showing a drop down
        menu_effect : 'hover_fade', // Drop down effect, choose between 'hover_fade', 'hover_slide', etc.
        menu_click_outside : 1, // Clicks outside the drop down close it (1 = true, 0 = false)
        menu_show_onload : 0, // Drop down to show on page load (type the number of the drop down, 0 for none)
        menu_responsive:1 // 1 = Responsive, 0 = Not responsive
    });
});
</script>
<div class="headerRight">
    <div class="rightTop">
        <ul class="social">
            <li><a href="<?php echo YOUTUBE_URL; ?>" target="_blank" ><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>icon1.png" alt="" /></a></li>
            <li><a href="<?php echo TWITTER_URL; ?>" target="_blank" ><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>icon2.png" alt="" /></a></li>
            <li><a href="<?php echo FACEBOOK_URL; ?>" target="_blank"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>icon3.png" alt="" /></a></li>
            <li><a href="<?php echo GPLUS_URL; ?>" target="_blank"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>icon4.png" alt="" /></a></li>
        </ul>
        
        <div class="Currency Currency_3">
            <select id="countries" onchange="changeCurrency(this.value);">
                <option><?php echo CURRENCY; ?></option>
                <?php

                 foreach ($arrCurrencyListNew as $ck => $cv) {
                    $cselected = ($_SESSION['SiteCurrencyCode'] == $ck) ? 'selected="selected"' : '';
                    echo '<option value="' . $ck . '" data-image="'.IMAGE_FRONT_PATH_URL.'blank.gif" data-imagecss="flag '.$cv[2].'" data-title="' . $ck .' '.$cv[1].'" ' . $cselected . '>' . $ck .'</option>';
                    
                }
                ?>
            </select>
        </div>
        <style type="text/css">
         #countries_msdd{width: 82px !important;} 
         .dd .ddTitle{height:26px !important}
        .goog-te-gadget-icon{display:none}
        .goog-te-banner-frame.skiptranslate {display: none !important;}
        body { top: 0px !important; }
        .SSContainerDivWrapper ul{width:240px!important;}
        #MicrosoftTranslatorWidget{display:block !important;}
        #LauncherTranslatePhrase{padding: 0px 0 0px 8px;height: auto;}
        #WidgetFloaterPanels{position:absolute !important;}
        #MSTCImprove { display: none;} 
        .ddcommon{float:right;}
        .dd.ddcommon{width:80px !important;}
     
        .reward_link_top{padding-right:20px;float:right;}
        #WidgetFloater{height:23px;}
        #WidgetLogoPanel, #CTFLinksPanel{display:none !important;}
        #FloaterProgressBar{background: transparent !important;} 
		#WidgetFloaterPanels{
background:transparent;
}
#WidgetFloaterPanels input[type="text"]{
background:transparent !important;
}
#WidgetFloaterPanels *{
background-color:transparent !important;
}
#WidgetFloaterPanels span.DDStyle:hover{
color:#000 !important;
}
#WidgetFloaterPanels span.DDStyle a:hover, #WidgetFloaterPanels .DDStyle a, .DDStyle a:visited, #WidgetFloaterPanels div.DDStyle td a:hover{
color:#000 !important;
}
#WidgetFloaterPanels div.DDStyle{
padding:0 !important;
}
#WidgetFloaterPanels #LanguageMenu{
background-color:#fff !important;
}
#LanguageMenuPanel{
height:30px !important;
background:transparent !important;
}
#WidgetFloaterPanels span.DDStyle{
    padding:0 6px; !important;
	color:#454545 !important;
	text-align:left !important;
	 font: 300 13px/25px "Lato",sans-serif !important;
	
}

#WidgetFloaterPanels{

box-shadow:none !important;
}
#WidgetFloater{
border:0px  !important;
border:none !important;
width:100px;
border-radius: 0px !important;
height:25px; 
} 
        
.language {
    
    height: 30px;
    width: 100px;
    position: relative;
}
#WidgetFloaterPanels{
    right:0;
}
        </style>
        
        <div class="language">
            
            <span id="ldr"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>zoomloader.gif"/></span>
            <script src="http://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>
            <script type="text/javascript">
            document.onreadystatechange = function () {
            if (document.readyState == 'complete') { Microsoft.Translator.Widget.Translate('en', 'en', null, null, null, null, 2000);}    
            }
            </script>

        </div>
        <div class="reward_link_top">
            <?php
            if (isset($_SESSION['sessUserInfo']['type'])) {
                if ($_SESSION['sessUserInfo']['type'] == 'customer') {
                    ?>
                    <a href="<?php echo $objCore->getUrl('my_rewards.php'); ?>"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>reward-image.png" /></a>
                    <?php
                }
            } else {
                ?>
                <a href="<?php echo $objCore->getUrl('rewards.php'); ?>"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>reward-image.png" /></a>
            <?php } ?>
        </div>
    </div>
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
                <input type="submit" value=""/>

            </div>
        </form>
    </div>
</div>
<a class="logo" title="<?php echo SITE_NAME; ?>" href="<?php echo SITE_ROOT_URL; ?>"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>logo.png" alt="logo" /></a>
<?php if (isset($menuHide)) { ?>
    <div class="spacial_img"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>spacial.png" alt=""/></div>
<?php } else { ?>
    <div class="megamenu_container megamenu_dark_bar megamenu_light"><!-- Begin Menu Container -->

        
        <ul class="megamenu"><!-- Begin Mega Menu -->
           

            <li class="megamenu_button" style="display: none;"><a href="#_">Mega Menu</a></li>

        
            <li style="display: list-item;"><a href="#_" class="megamenu_drop"><img src="http://localhost/telamela/common/images/home_icon.png" alt="" /></a><!-- Begin Item -->
            
            
                <div class="dropdown_fullwidth" style="display: none; left: -1px; top: auto;"><!-- Begin Item Container -->
                <div class="col_3">

                       
                       <ul class="navi_1">  <a>asdasdsa</a><li>dsfdsfdsf</li>
                       <li>dsfdsfdsf</li>
                       <li>dsfdsfdsf</li>
                       <li>dsfdsfdsf</li>
                       <li>dsfdsfdsf</li>
                       <li>dsfdsfdsf</li>
                       
                       
                       </ul>
                       
                      <ul class="navi_1"> <a>asdasdsa</a><li>dsfdsfdsf</li>
                       <li>dsfdsfdsf</li>
                       <li>dsfdsfdsf</li>
                       <li>dsfdsfdsf</li>
                       <li>dsfdsfdsf</li>
                       <li>dsfdsfdsf</li>
                       
                       
                       </ul>

                    </div>
                    
                    <div class="col_4">

                        <h3>Full Width Drop Down !</h3>
                        <p>This is an example of a full width drop down. It expands automatically and seamlessly to fit exactly under the menu bar.</p>
                        <p>You can use other drop downs aswell and you can choose between 12 different sizes, from the smallest to the full width.</p>
                        <p>Tested on the most commons browsers, this menu works under Internet Explorer, Firefox, Safari, Chrome and Opera and on mobiles.</p>

                    </div>
                    
                    <div class="col_4">

                        <h3>Simple List Examples</h3>

                    </div>

                    <div class="col_2 responsive_halfs">

                        <ul class="list_unstyled">
                            <li><a href="#_">Mega Menu</a></li>
                            <li><a href="#_">CSS3 Effects</a></li>
                            <li><a href="#_">Responsive</a></li>
                            <li><a href="#_">Easy to use</a></li>
                            <li><a href="#_">Cross-browser</a></li>
                            <li><a href="#_">Mega Dropdowns</a></li>
                            <li><a href="#_">Any content</a></li>
                            <li><a href="#_">Transitions</a></li>
                            <li><a href="#_">Full Width</a></li>
                            <li><a href="#_">Clean Markup</a></li>
                            <li><a href="#_">Documented</a></li>
                        </ul> 

                    </div>

                    <div class="col_2 responsive_halfs">

                        <ul class="list_unstyled">
                            <li><a href="#_">Typography</a></li>
                            <li><a href="#_">Columns</a></li>
                            <li><a href="#_">CSS Grid</a></li>
                            <li><a href="#_">Videos</a></li>
                            <li><a href="#_">Images</a></li>
                            <li><a href="#_">Iframes</a></li>
                            <li><a href="#_">Explorer</a></li>
                            <li><a href="#_">Chrome</a></li>
                            <li><a href="#_">Firefox</a></li>
                            <li><a href="#_">Safari</a></li>
                            <li><a href="#_">Opera</a></li>
                        </ul>   

                    </div>

                    <div class="col_12">
                        <hr>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_dribble"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_forrst"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_facebook"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_ember"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_you_tube"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_vimeo"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_flickr"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_google"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_rss"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_skype"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_tumblr"></span></a>
                    </div>

                    <div class="col_1 responsive_sixths">
                        <a href="#_"><span class="social_icon social_icon_twitter"></span></a>
                    </div>
                          
                
                </div><!-- End Item Container -->
                
            
            </li><!-- End Item -->
            
            
            
            <li style="display: list-item;"><a href="#_" class="megamenu_drop">Men's</a><!-- Begin Item -->
            
            
                <div class="dropdown_10columns dropdown_container" style="display: none; left: auto; top: auto;"><!-- Begin Item Container -->
                
                
                    <div class="col_12">

                        <h2>Typography Examples</h2>

                    </div>
                    
                    <div class="col_7 clearfix">

                        <p>Sed est nisi, ornare eget rutrum a, porta non enim. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed euismod, nunc eu accumsan volutpat, nibh augue ultrices orci, eget tincidunt turpis dolor quis lacus. Suspendisse at mi sem, id accumsan quam. Nullam dapibus, tellus et.</p>

                    </div>
                    
                    <div class="col_5">

                        <p class="black_box">The content of this menu is hidden by using an absolute positioning and remains SEO friendly, add as much content as you want. Donec ac blandit turpis. Nunc dapibus, elit vitae mollis pretium, elit nunc interdum nisi.</p>

                    </div>
                    
                    <div class="col_6 clearfix">
                    
                        <h3>Texts with Icons</h3>
                    
                        <p class="paragraph_icon"><span class="mini_icon ic_archive"></span>This is a paragraph with a settings icon. Curabitur lorem nulla, imperdiet quisque at metus a libero.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_bookmark"></span>This is a paragraph with a favorite icon. Praesent id nulla eu risus rhoncus. Donec tortor sem</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_brush"></span>This is a paragraph with a lock icon. Ut pulvinar mauris at nunc vestibulum venenatis diam sit.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_cloud"></span>This is a paragraph with a bookmark icon. Nulla tincidunt, purus at luctus praesent id nulla.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_favorite"></span>This is a paragraph with a info icon. Vestibulum venenatis diam sit amet curabitur lorem nulla.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_graph"></span>This is a paragraph with a bubble icon. Quisque at metus a libero sodales cras sagittis, tortor at.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_picture"></span>This is a paragraph with a screen icon. Donec tortor sem, venenatis mauris quis augue lectus. </p>
                    
                    </div>
                    
                    <div class="col_6">
                    
                        <h3>Other Examples</h3>
                    
                        <p class="paragraph_icon"><span class="mini_icon ic_attachment"></span>This is a paragraph with a cloud icon. Curabitur lorem nulla, imperdiet quisque at metus a libero.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_calc"></span>This is a paragraph with a tag icon. Praesent id nulla eu risus rhoncus. Donec tortor sem.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_chat"></span>This is a paragraph with a layers icon. Ut pulvinar mauris at nunc vestibulum venenatis diam sit.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_edit"></span>This is a paragraph with a book icon. Nulla tincidunt, purus at luctus praesent id nulla eu.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_folder"></span>This is a paragraph with a paint icon. Vestibulum venenatis diam sit amet curabitur lorem nulla.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_list"></span>This is a paragraph with a search icon. Quisque at metus a libero sodales cras sagittis, tortor at.</p>
                        <p class="paragraph_icon"><span class="mini_icon ic_zoom"></span>This is a paragraph with a photo icon. Donec tortor sem, venenatis mauris quis augue lectus. </p>
                    
                    </div>
                    
                
                </div><!-- End Item Container -->
                
            
            </li><!-- End Item -->
            
            
            
            <li style="display: list-item;"><a href="#_" class="megamenu_drop">Women's</a><!-- Begin Item -->
            
            
                <div class="dropdown_8columns dropdown_container" style="display: none; left: auto; top: auto;"><!-- Begin Item Container -->
                
                            
                    <div class="col_12">
                        <h2>Additional Lists</h2>
                    </div>
                    
                    <div class="col_3 responsive_halfs">
                    
                        <ol class="num">
                            <li><a href="#_">ThemeForest</a></li>
                            <li><a href="#_">GraphicRiver</a></li>
                            <li><a href="#_">ActiveDen</a></li>
                            <li><a href="#_">VideoHive</a></li>
                            <li><a href="#_">3DOcean</a></li>
                        </ol>   
                         
                    </div>
            
                    <div class="col_3 responsive_halfs">
                    
                        <ol class="num2">
                            <li><a href="#_">NetTuts</a></li>
                            <li><a href="#_">VectorTuts</a></li>
                            <li><a href="#_">PsdTuts</a></li>
                            <li><a href="#_">PhotoTuts</a></li>
                            <li><a href="#_">ActiveTuts</a></li>
                        </ol>   
                         
                    </div>
            
                    <div class="col_3 responsive_halfs">
                    
                        <ul class="list">
                            <li><a href="#_">FreelanceSwitch</a></li>
                            <li><a href="#_">Creattica</a></li>
                            <li><a href="#_">WorkAwesome</a></li>
                            <li><a href="#_">Mac Apps</a></li>
                            <li><a href="#_">Web Apps</a></li>
                        </ul>   
                         
                    </div>
            
                    <div class="col_3 responsive_halfs">
                    
                        <ul class="list2">
                            <li><a href="#_">Design</a></li>
                            <li><a href="#_">Logo</a></li>
                            <li><a href="#_">Flash</a></li>
                            <li><a href="#_">Illustration</a></li>
                            <li><a href="#_">More...</a></li>
                        </ul>   
                         
                    </div>
                                       
                    <div class="col_12">

                        <h2>Paragraphs with Borders</h2>              
                        <p class="blue">Nulla quis metus a dolor feugiat porta. Phasellus sapien magna, gravida congue fermentum vel, gravida sit amet sapien. Quisque elit est, ullamcorper ac hendrerit eget, porta id enim.</p>
                        <p class="grey">Praesent a dolor sem. Sed scelerisque, tellus id pulvinar tristique, erat eros rutrum mi, id adipiscing arcu sem vel est. Ut ac turpis ipsum. Mauris leo nulla, vestibulum id bibendum.</p>
                        <p class="orange">Nulla quis metus a dolor feugiat porta. Phasellus sapien magna, gravida congue fermentum vel, gravida sit amet sapien. Quisque elit est, ullamcorper ac hendrerit eget, porta id enim.</p>
                        <p class="dark">Curabitur vulputate, massa sit amet mollis sodales, arcu quam scelerisque augue, ac elementum velit mauris ac tellus. Nunc dapibus mollis ante a sollicitudin. Nullam adipiscing.</p>
                        <p class="purple">Quisque varius, erat nec fermentum aliquam, erat urna venenatis orci, in semper lorem ante at dolor. Quisque scelerisque mattis magna ut lobortis. Cras porttitor scelerisque.</p>
                    
                    </div>
                    
                
                </div><!-- End Item container -->
                
            
            </li><!-- End Item -->
            
            
            
            <li style="display: list-item;"><a href="#_" class="megamenu_drop">Kids</a><!-- Begin Item -->
            
            
                <div class="dropdown_fullwidth" style="display: none; left: -1px; top: auto;"><!-- Begin Item container -->
                
                    
                    <div class="col_6">
                    
                        <h2>This is a dark table</h2>
            
                        <table class="table_dark">
                          <tbody><tr><th>Title 1</th><th>Title 2</th><th>Title 3</th><th>Title 4</th></tr>
                          <tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td><td>Cell 4</td></tr>
                          <tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td><td>Cell 4</td></tr>
                          <tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td><td>Cell 4</td></tr>
                          <tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td><td>Cell 4</td></tr>
                        </tbody></table>

                        <h2>This is a light table</h2>

                        <table class="table_light">
                          <tbody><tr><th>Title 1</th><th>Title 2</th><th>Title 3</th><th>Title 4</th></tr>
                          <tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td><td>Cell 4</td></tr>
                          <tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td><td>Cell 4</td></tr>
                          <tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td><td>Cell 4</td></tr>
                          <tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td><td>Cell 4</td></tr>
                        </tbody></table>
            
                    </div>

                    <div class="col_6">
                    
                        <h2>Add videos aswell !</h2>
                        <p>Sed at justo justo. Nunc pretium laoreet tincidunt. Curabitur ac ipsum vel quam vulputate tempor in eu nulla. Duis sodales tortor ut arcu dictum tincidunt.</p>
                        <div class="video_container">
                            <iframe src="http://player.vimeo.com/video/32001208?portrait=0&amp;badge=0"></iframe>
                        </div>
                        <p>Phasellus molestie facilisis orci ut bibendum. Aliquam accumsan eros sit amet metus egestas porta. Aenean at sapien leo. Aliquam dapibus sem ac arcu bibendum dignissim. Ut ac sapien ligula, et convallis diam.</p>
            
                    </div>
                                
                
                </div><!-- End Item Container -->
                
                
            </li><!-- End Item -->
            
            
            
            <li style="display: list-item;"><a href="#_" class="megamenu_drop">Baby</a><!-- Begin Item -->
            
            
                <div class="dropdown_4columns dropdown_container" style="display: none; left: auto; top: auto;"><!-- Begin Item Container -->
                

                    <div class="col_12">

                        <h3>Contact us !</h3>
                        <p>Phasellus molestie facilisis orci ut bibendum. Aliquam accumsan eros sit amet metus egestas porta.</p>
                    
                        <form id="megamenu_form" name="contact" method="post" novalidate>

                            <fieldset>  

                                <label for="name">Name <span class="required">*</span></label>
                                <input class="form-input" type="text" name="name" id="name" value="" required>

                                <label for="email">Email <span class="required">*</span></label>
                                <input class="form-input" type="text" name="email" id="email" value="" required>

                                <label for="message">Message <span class="required">*</span></label>
                                <textarea name="message" id="message" required></textarea>

                                <label for="captcha">3 + 2 = <span class="required">*</span></label>
                                <input class="form-input form-captcha" type="text" name="captcha" id="captcha" value="" required>

                                <ul class="form-buttons">
                                    <li><input id="submit" type="submit" name="submit" value="Send"></li>
                                    <li><input id="reset" type="reset" name="reset" value="Reset"></li>
                                </ul>

                            </fieldset>  

                            <div id="success">
                                Your message was sent successfully! I will be in touch as soon as I can.
                            </div>

                            <div id="error">
                                Something went wrong, try refreshing and submitting the form again.
                            </div>

                        </form>

                    </div>
                    
                
                </div><!-- End Item Container -->
                
            
            </li><!-- End Item -->
            
            
            
            <li style="display: list-item;"><a href="#_" class="megamenu_drop">Electronics</a><!-- Begin Item -->
            
            
                <div class="dropdown_2columns dropdown_container" style="display: none; left: auto; top: auto;"><!-- Begin Item Container -->
                

                    <ul class="dropdown_flyout">
                    
                        <li><a href="#_">Level 1</a></li>
                        
                        <li class="dropdown_parent"><a href="#_">Level 1</a>

                            <ul class="dropdown_flyout_level" style="display: none; left: 95%; top: -21px;">

                                <li><a href="#_">Level 2</a></li>
                                <li><a href="#_">Level 2</a></li>
                                <li><a href="#_">Level 2</a></li>

                            </ul>

                        </li>
                        
                        <li class="dropdown_parent"><a href="#_">Level 1</a>

                            <ul class="dropdown_flyout_level" style="display: none; left: 95%; top: -21px;">

                                <li><a href="#_">Level 2</a></li>
                                <li><a href="#_">Level 2</a></li>
                                <li><a href="#_">Level 2</a></li>

                                <li class="dropdown_parent"><a href="#_">Level 2</a>

                                    <ul class="dropdown_flyout_level dropdown_flyout_level_left" style="display: none; top: -21px; left: -108%; right: 100%;">

                                        <li><a href="#_">Level 3</a></li>
                                        <li><a href="#_">Level 3</a></li>
                                        <li><a href="#_">Level 3</a></li>

                                        <li class="dropdown_parent"><a href="#_">Level 3</a>

                                            <ul class="dropdown_flyout_level" style="display: none; left: 95%; top: -21px;">

                                                <li><a href="#_">Level 4</a></li>
                                                <li><a href="#_">Level 4</a></li>
                                                <li><a href="#_">Level 4</a></li>

                                            </ul>

                                        </li>

                                    </ul>

                                </li>

                            </ul>
                            
                        </li>
                        
                        <li><a href="#_">Level 1</a></li>
                        
                        <li class="dropdown_parent"><a href="#_">Level 1</a>

                            <ul class="dropdown_flyout_level" style="display: none; left: 95%; top: -21px;">

                                <li><a href="#_">Level 2</a></li>
                                <li><a href="#_">Level 2</a></li>

                                <li class="dropdown_parent"><a href="#_">Level 2</a>

                                    <ul class="dropdown_flyout_level dropdown_flyout_level_left" style="display: none; top: -21px; left: -108%; right: 100%;">

                                        <li><a href="#_">Level 3</a></li>
                                        <li><a href="#_">Level 3</a></li>
                                        <li><a href="#_">Level 3</a></li>
                                        <li><a href="#_">Level 3</a></li>

                                    </ul>

                                </li>

                            </ul>

                        </li>
                        
                        <li><a href="#_">Level 1</a></li>
                        <li><a href="#_">Level 1</a></li>
                        
                    </ul>                       
                
                </div><!-- End Item Container -->
                
            
            </li><!-- End Item -->
        
        
        
            <li style="display: list-item;"><a href="http://codecanyon.net/user/Pixelworkshop/portfolio">Sports</a></li>
 <li style="display: list-item;"><a href="http://codecanyon.net/user/Pixelworkshop/portfolio">Toys</a></li>
  <li style="display: list-item;"><a href="http://codecanyon.net/user/Pixelworkshop/portfolio">Home & Travel</a></li>
  <li style="display: list-item;"><a href="http://codecanyon.net/user/Pixelworkshop/portfolio">Health & Fit</a></li>


            <li class="megamenu_right" style="display: list-item;"><a href="#_" class="megamenu_drop">Right Item</a><!-- Begin Right Item -->
            
                
                <div class="dropdown_2columns dropdown_right dropdown_container droplast_right" style="display: none; left: auto; top: auto;"><!-- Begin Right Item Container -->
            
                    <div class="col_12">
                    
                        <ul class="list_unstyled">
                            <li><a href="#_">FreelanceSwitch</a></li>
                            <li><a href="#_">Creattica</a></li>
                            <li><a href="#_">WorkAwesome</a></li>
                            <li><a href="#_">Mac Apps</a></li>
                            <li><a href="#_">Web Apps</a></li>
                            <li><a href="#_">NetTuts</a></li>
                            <li><a href="#_">VectorTuts</a></li>
                            <li><a href="#_">PsdTuts</a></li>
                            <li><a href="#_">PhotoTuts</a></li>
                            <li><a href="#_">ActiveTuts</a></li>
                            <li><a href="#_">Design</a></li>
                            <li><a href="#_">Logo</a></li>
                            <li><a href="#_">Flash</a></li>
                            <li><a href="#_">Illustration</a></li>
                            <li><a href="#_">More...</a></li>
                        </ul>   
                         
                    </div>
                
                </div><!-- End Right Item Container -->
                
                  
            </li><!-- End Right Item -->
        
        
        </ul><!-- End Mega Menu -->


    </div>
<?php } ?>

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
    (function($) {
    $.fn.hoverIntent = function(handlerIn,handlerOut,selector) {

        // default configuration values
        var cfg = {
            interval: 100,
            sensitivity: 6,
            timeout: 0
        };

        if ( typeof handlerIn === "object" ) {
            cfg = $.extend(cfg, handlerIn );
        } else if ($.isFunction(handlerOut)) {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerOut, selector: selector } );
        } else {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerIn, selector: handlerOut } );
        }

        // instantiate variables
        // cX, cY = current X and Y position of mouse, updated by mousemove event
        // pX, pY = previous X and Y position of mouse, set by mouseover and polling interval
        var cX, cY, pX, pY;

        // A private function for getting mouse position
        var track = function(ev) {
            cX = ev.pageX;
            cY = ev.pageY;
        };

        // A private function for comparing current and previous mouse position
        var compare = function(ev,ob) {
            ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
            // compare mouse positions to see if they've crossed the threshold
            if ( Math.sqrt( (pX-cX)*(pX-cX) + (pY-cY)*(pY-cY) ) < cfg.sensitivity ) {
                $(ob).off("mousemove.hoverIntent",track);
                // set hoverIntent state to true (so mouseOut can be called)
                ob.hoverIntent_s = true;
                return cfg.over.apply(ob,[ev]);
            } else {
                // set previous coordinates for next time
                pX = cX; pY = cY;
                // use self-calling timeout, guarantees intervals are spaced out properly (avoids JavaScript timer bugs)
                ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
            }
        };

        // A private function for delaying the mouseOut function
        var delay = function(ev,ob) {
            ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
            ob.hoverIntent_s = false;
            return cfg.out.apply(ob,[ev]);
        };

        // A private function for handling mouse 'hovering'
        var handleHover = function(e) {
            // copy objects to be passed into t (required for event object to be passed in IE)
            var ev = $.extend({},e);
            var ob = this;

            // cancel hoverIntent timer if it exists
            if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }

            // if e.type === "mouseenter"
            if (e.type === "mouseenter") {
                // set "previous" X and Y position based on initial entry point
                pX = ev.pageX; pY = ev.pageY;
                // update "current" X and Y position based on mousemove
                $(ob).on("mousemove.hoverIntent",track);
                // start polling interval (self-calling timeout) to compare mouse coordinates over time
                if (!ob.hoverIntent_s) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}

                // else e.type == "mouseleave"
            } else {
                // unbind expensive mousemove event
                $(ob).off("mousemove.hoverIntent",track);
                // if hoverIntent state is true, then call the mouseOut function after the specified delay
                if (ob.hoverIntent_s) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
            }
        };

        // listen for mouseenter and mouseleave
        return this.on({'mouseenter.hoverIntent':handleHover,'mouseleave.hoverIntent':handleHover}, cfg.selector);
    };
})(jQuery);
   
</script>
<div class="cartMessage" id ="myCartMassage"></div>