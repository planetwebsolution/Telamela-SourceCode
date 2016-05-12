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
    <div class="navSection">
        <ul class="menu">
            <li class="home"><a href="<?php echo SITE_ROOT_URL; ?>"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>home_icon.png" alt="" /></a></li>
            <?php echo $objPage2->arrData['arrtopMenuTree']; ?>
            <li class="last">
                <a href="#" class="setting"></a>
                <div class="dropdowns_outer right">
                    <div class="dropdowns_inner">
                        <?php echo $objPage2->arrData['arrtopDropTree']; ?>
                    </div>

                </div>
            </li>
        </ul>
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