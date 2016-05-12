var jquerycssmenu = {
    arrowimages : {down:['downarrowclass', SITE_ROOT_URL+'common/images/trans.png', 25], right:['rightarrowclass', SITE_ROOT_URL+'common/images/arow1.png']},
    //duration of fade in/ out animation  and the starting fade out delay, in milliseconds
    fadesettings: {overduration: 350, outduration: 100, startfadeoutdelay:300},
    // you can set it false and if you set it to false the sub menu positionning will be ok but you should
    // change arrow incons position to the left side manually and .jquerycssmenu UL LI { float:left} should be set
    isRTL : true,
    buildmenu:function(menuid) {
        jQuery(document).ready(function($) {
            var mainmenu = $("#" + menuid + ">ul");
            var headers = mainmenu.find("ul").parent();
            headers.each(function(i) {
                var curobj = $(this);
                var subul = $(this).find('ul:eq(0)');
                var inMenu = false;
                this._dimensions = {w:this.offsetWidth, h:this.offsetHeight, subulw:subul.outerWidth(), subulh:subul.outerHeight()};
                this.istopheader = curobj.parents("ul").length == 1 ? true : false;
                subul.css({top:this.istopheader ? this._dimensions.h + "px" : 0});
                /*for isRTL : false set it to paddingRight*/                
                curobj.children("a:eq(0)").css(this.istopheader ? {paddingLeft: jquerycssmenu.arrowimages.down[2]} : {}).append(
                        '<img src="' + (this.istopheader ? jquerycssmenu.arrowimages.down[1] : jquerycssmenu.arrowimages.right[1])
                                + '" class="' + (this.istopheader ? jquerycssmenu.arrowimages.down[0] : jquerycssmenu.arrowimages.right[0])
                                + '" style="border:0;" />');
                curobj.hover(function(e) {
                    inMenu = true;
                    var targetul = $(this).children("ul:eq(0)");
                    this._offsets = {left:$(this).offset().left, top:$(this).offset().top};
                    var menuleft = this.istopheader ? this._dimensions.subulw - this._dimensions.w - 15 : this._dimensions.w;

                    if (jquerycssmenu.isRTL) {
                        menuleft = (this._offsets.left < this._dimensions.subulw) ? (this.istopheader ? -(this._dimensions.subulw - this._dimensions.w) : this._dimensions.subulw ) : -menuleft;
                    } else {
                        menuleft = (this._offsets.left + menuleft + this._dimensions.subulw > $(window).width()) ? (this.istopheader ? -this._dimensions.subulw + this._dimensions.w : -this._dimensions.w) : menuleft;
                    }

                    targetul.css({left:menuleft + "px"}).fadeIn(jquerycssmenu.fadesettings.overduration);
                }, function(e) {
                    inMenu = false;
                    var li = $(this);
                    setTimeout(function() {
                        if (!inMenu) {
                            li.children("ul:eq(0)").fadeOut(jquerycssmenu.fadesettings.outduration)
                        }
                    }, jquerycssmenu.fadesettings.startfadeoutdelay);
                });
            });
            mainmenu.find("ul").css({display:'none', visibility:'visible'});
        });
    }
};
