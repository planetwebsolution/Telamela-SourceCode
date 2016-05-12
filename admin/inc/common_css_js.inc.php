<!-- Bootstrap -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>bootstrap.min.css">
<!-- Bootstrap responsive -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>bootstrap-responsive.min.css">
<!-- jQuery UI -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>plugins/jquery-ui/smoothness/jquery-ui.css">
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>plugins/jquery-ui/smoothness/jquery.ui.theme.css">
<!-- dataTables -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>plugins/datatable/TableTools.css">
<!-- chosen -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>plugins/chosen/chosen.css">
<!-- select2 -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>plugins/select2/select2.css">
<!-- timepicker -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>plugins/timepicker/bootstrap-timepicker.min.css">
<!-- Datepicker -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>plugins/datepicker/datepicker.css">
<!-- Daterangepicker -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>plugins/daterangepicker/daterangepicker.css">
<!-- Theme CSS -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>style.css">
<!-- Color CSS -->
<link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>themes.css">



<!-- jQuery -->
<script src="<?php echo ADMIN_JS_PATH; ?>jquery.min.js"></script>
<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script type="text/javascript">
    jQuery(document).ready(function(){
        if($(window).width()>767){ 
//            $("ul.main-nav li").mouseenter(function(){ 
//                var obc= $(this); 
//                obc.addClass("open");
//                $(this).find("ul .dropdown-menu").hover(function() { 
//                    obc.addClass("open"); 
//                });
//                $(this).find(".nodrop").hover(function() { 
//                    obc.removeClass("open"); 
//                });
//            });
//            $("ul.main-nav li").mouseleave(function(){
//                var obc= $(this);
//                obc.removeClass("open");
//                
//            });

$('ul.main-nav > li').hover(function() {    
        var obc= $(this);
        if(obc.attr('class')!='active' && obc.attr('class')!='open'){
        $('li.active ul.dropdown-menu').hide();
        }
        obc.addClass("open");
        return false;
    }, function() { 
        var obc= $(this);
        $('li.active ul.dropdown-menu').show();   
        obc.removeClass("open");
        return false;
    });

        }
    });
    function ndrop(ndrp){    
        $(ndrp).find('ul').removeClass("open");
        window.location=$(ndrp).find('a').attr('href');
    }
</script>
<script>var SITE_ROOT_URL = '<?php echo SITE_ROOT_URL; ?>';</script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH ?>message.inc.js"></script>
<script type="text/javascript" src="<?php echo VALIDATE_JS; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PATH; ?>reports_admin.js"></script>

<!-- Nice Scroll -->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/nicescroll/jquery.nicescroll.min.js"></script>
<!-- imagesLoaded -->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
<!-- jQuery UI -->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/jquery-ui/jquery.ui.core.min.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/jquery-ui/jquery.ui.widget.min.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/jquery-ui/jquery.ui.mouse.min.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/jquery-ui/jquery.ui.resizable.min.js"></script>
<!--        <script src="<?php echo ADMIN_JS_PATH; ?>plugins/jquery-ui/jquery.ui.sortable.min.js"></script>-->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/jquery-ui/jquery.ui.datepicker.min.js"></script>
<!-- slimScroll -->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/slimscroll/jquery.slimscroll.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo ADMIN_JS_PATH; ?>bootstrap.min.js"></script>
<!-- Bootbox -->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/bootbox/jquery.bootbox.js"></script>
<!-- select2 -->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/select2/select2.min.js"></script>
<?php /*
  <!-- Datepicker -->
  <script src="<?php echo ADMIN_JS_PATH; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- Daterangepicker -->
  <script src="<?php echo ADMIN_JS_PATH; ?>plugins/daterangepicker/daterangepicker.js"></script>
  <script src="<?php echo ADMIN_JS_PATH; ?>plugins/daterangepicker/moment.min.js"></script>
  <!-- Timepicker -->
  <script src="<?php echo ADMIN_JS_PATH; ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
 */ ?>
<!-- CKEditor -->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/ckeditor1/ckeditor.js"></script>
<!-- dataTables -->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/datatable/TableTools.min.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/datatable/ColReorderWithResize.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/datatable/ColVis.min.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/datatable/jquery.dataTables.columnFilter.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/datatable/jquery.dataTables.grouping.js"></script>

<!-- Flot -->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/flot/jquery.flot.min.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/flot/jquery.flot.bar.order.min.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/flot/jquery.flot.pie.min.js"></script>
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/flot/jquery.flot.resize.min.js"></script>

<!-- Chosen -->
<script src="<?php echo ADMIN_JS_PATH; ?>plugins/chosen/chosen.jquery.min.js"></script>

<!-- Theme framework -->
<script src="<?php echo ADMIN_JS_PATH; ?>eakroko.min.js"></script>
<!-- Theme scripts -->
<script src="<?php echo ADMIN_JS_PATH; ?>application.min.js"></script>
<!-- Just for demonstration -->
<script src="<?php echo ADMIN_JS_PATH; ?>demonstration.min.js"></script>


<!--[if lte IE 9]>
        <script src="<?php //echo ADMIN_JS_PATH;                      ?>plugins/placeholder/jquery.placeholder.min.js"></script>
        <script>
                $(document).ready(function() {
                        $('input, textarea').placeholder();
                });
        </script>
<![endif]-->

<!-- Favicon -->
<!--<link rel="shortcut icon" href="img/favicon.ico" />-->

<?php
//pre($_SESSION['sessLogistictype']);
if ($_SESSION['sessLogistictype'] !='') {
   ?>
<p class="avitestabc"></p>
<link rel="shortcut icon" href="../admin/img/favicon.ico" />
<?php

}
else{
?>
<p class="avitest1"></p>
<link rel="shortcut icon" href="img/favicon.ico" />
<?php
}?>
<!-- Apple devices Homescreen icon -->
<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />
