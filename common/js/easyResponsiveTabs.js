(function(e){e.fn.extend({easyResponsiveTabs:function(t){var n={type:"default",width:"auto",fit:true,closed:false,activate:function(){}};var t=e.extend(n,t);var r=t,i=r.type,s=r.fit,o=r.width,u="vertical",a="accordion";var f=window.location.hash;var l=!!(window.history&&history.replaceState);e(this).bind("tabactivate",function(e,n){if(typeof t.activate==="function"){t.activate.call(n,e)}});this.each(function(){function h(){if(i==u){n.addClass("resp-vtabs")}if(s==true){n.css({width:"100%",margin:"0px"})}if(i==a){n.addClass("resp-easy-accordion");n.find(".resp-tabs-list").css("display","none")}}var n=e(this);var r=n.find("ul.resp-tabs-list");var c=n.attr("id");n.find("ul.resp-tabs-list li").addClass("resp-tab-item");n.css({display:"block",width:o});n.find(".resp-tabs-container > div").addClass("resp-tab-content");h();var p;n.find(".resp-tab-content").before("<h2 class='resp-accordion' role='tab'><span class='resp-arrow'></span></h2>");var d=0;n.find(".resp-accordion").each(function(){p=e(this);var t=n.find(".resp-tab-item:eq("+d+")");var r=n.find(".resp-accordion:eq("+d+")");r.append(t.html());r.data(t.data());p.attr("aria-controls","tab_item-"+d);d++});var v=0,m;n.find(".resp-tab-item").each(function(){$tabItem=e(this);$tabItem.attr("aria-controls","tab_item-"+v);$tabItem.attr("role","tab");var t=0;n.find(".resp-tab-content").each(function(){m=e(this);m.attr("aria-labelledby","tab_item-"+t);t++});v++});var g=0;if(f!=""){var y=f.match(new RegExp(c+"([0-9]+)"));if(y!==null&&y.length===2){g=parseInt(y[1],10)-1;if(g>v){g=0}}}e(n.find(".resp-tab-item")[g]).addClass("resp-tab-active");if(t.closed!==true&&!(t.closed==="accordion"&&!r.is(":visible"))&&!(t.closed==="tabs"&&r.is(":visible"))){e(n.find(".resp-accordion")[g]).addClass("resp-tab-active");e(n.find(".resp-tab-content")[g]).addClass("resp-tab-content-active").attr("style","display:block")}else{e(n.find(".resp-tab-content")[g]).addClass("resp-tab-content-active resp-accordion-closed")}n.find("[role=tab]").each(function(){var t=e(this);t.click(function(){var t=e(this);var r=t.attr("aria-controls");if(t.hasClass("resp-accordion")&&t.hasClass("resp-tab-active")){n.find(".resp-tab-content-active").slideUp("",function(){e(this).addClass("resp-accordion-closed")});t.removeClass("resp-tab-active");return false}if(!t.hasClass("resp-tab-active")&&t.hasClass("resp-accordion")){n.find(".resp-tab-active").removeClass("resp-tab-active");n.find(".resp-tab-content-active").slideUp().removeClass("resp-tab-content-active resp-accordion-closed");n.find("[aria-controls="+r+"]").addClass("resp-tab-active");n.find(".resp-tab-content[aria-labelledby = "+r+"]").slideDown().addClass("resp-tab-content-active")}else{n.find(".resp-tab-active").removeClass("resp-tab-active");n.find(".resp-tab-content-active").removeAttr("style").removeClass("resp-tab-content-active").removeClass("resp-accordion-closed");n.find("[aria-controls="+r+"]").addClass("resp-tab-active");n.find(".resp-tab-content[aria-labelledby = "+r+"]").addClass("resp-tab-content-active").attr("style","display:block")}t.trigger("tabactivate",t);if(l){var i=window.location.hash;var s=c+(parseInt(r.substring(9),10)+1).toString();if(i!=""){var o=new RegExp(c+"[0-9]+");if(i.match(o)!=null){s=i.replace(o,s)}else{s=i+"|"+s}}else{s="#"+s}}})});e(window).resize(function(){n.find(".resp-accordion-closed").removeAttr("style")})})}})})(jQuery)