(function(d,e,f){
    d.fn.jScrollPane=function(a){
        function b(br,bb){
            var bk,a9=this,a1,bF,aK,bD,a6,a0,s,aO,bi,bS,bs,aW,bh,aX,aV,bO,a5,bz,a2,aM,bw,by,bJ,bC,bl,aT,bu,bm,aI,bq,bP,aZ,be,bG=true,ba=true,bQ=false,aU=false,bA=br.clone(false,false).empty(),bM=d.fn.mwheelIntent?"mwheelIntent.jsp":"mousewheel.jsp";
            bP=br.css("paddingTop")+" "+br.css("paddingRight")+" "+br.css("paddingBottom")+" "+br.css("paddingLeft");
            aZ=(parseInt(br.css("paddingLeft"),10)||0)+(parseInt(br.css("paddingRight"),10)||0);
            function bx(i){
                var n,l,m,g,h,j,k=false,o=false;
                bk=i;
                if(a1===f){
                    h=br.scrollTop();
                    j=br.scrollLeft();
                    br.css({
                        overflow:"hidden",
                        padding:0
                    });
                    bF=br.innerWidth()+aZ;
                    aK=br.innerHeight();
                    br.width(bF);
                    a1=d('<div class="jspPane" />').css("padding",bP).append(br.children());
                    bD=d('<div class="jspContainer" />').css({
                        width:bF+"px",
                        height:"233px"
                    }).append(a1).appendTo(br)
                }else{
                    br.css("width","");
                    k=bk.stickToBottom&&bf();
                    o=bk.stickToRight&&bv();
                    g=br.innerWidth()+aZ!=bF||br.outerHeight()!=aK;
                    if(g){
                        bF=br.innerWidth()+aZ;
                        aK=br.innerHeight();
                        bD.css({
                            width:bF+"px",
                            height:aK+"px"
                        })
                    }
                    if(!g&&be==a6&&a1.outerHeight()==a0){
                        br.width(bF);
                        return
                    }
                    be=a6;
                    a1.css("width","");
                    br.width(bF);
                    bD.find(">.jspVerticalBar,>.jspHorizontalBar").remove().end()
                }
                a1.css("overflow","auto");
                if(i.contentWidth){
                    a6=i.contentWidth
                }else{
                    a6=a1[0].scrollWidth
                }
                a0=a1[0].scrollHeight;
                a1.css("overflow","");
                s=a6/bF;
                aO=a0/aK;
                bi=aO>1;
                bS=s>1;
                if(!(bS||bi)){
                    br.removeClass("jspScrollable");
                    a1.css({
                        top:0,
                        width:bD.width()-aZ
                    });
                    aR();
                    bp();
                    a8();
                    aJ()
                }else{
                    br.addClass("jspScrollable");
                    n=bk.maintainPosition&&(bh||bO);
                    if(n){
                        l=bU();
                        m=bW()
                    }
                    bR();
                    c();
                    bn();
                    if(n){
                        bc(o?(a6-bF):l,false);
                        bd(k?(a0-aK):m,false)
                    }
                    bg();
                    bI();
                    bB();
                    if(bk.enableKeyboardNavigation){
                        a7()
                    }
                    if(bk.clickOnTrack){
                        aP()
                    }
                    bt();
                    if(bk.hijackInternalLinks){
                        aS()
                    }
                }
                if(bk.autoReinitialise&&!bq){
                    bq=setInterval(function(){
                        bx(bk)
                    },bk.autoReinitialiseDelay)
                }else{
                    if(!bk.autoReinitialise&&bq){
                        clearInterval(bq)
                    }
                }
                h&&br.scrollTop(0)&&bd(h,false);
                j&&br.scrollLeft(0)&&bc(j,false);
                br.trigger("jsp-initialised",[bS||bi])
            }
            function bR(){
                if(bi){
                    bD.append(d('<div class="jspVerticalBar" />').append(d('<div class="jspCap jspCapTop" />'),d('<div class="jspTrack" />').append(d('<div class="jspDrag" />').append(d('<div class="jspDragTop" />'),d('<div class="jspDragBottom" />'))),d('<div class="jspCap jspCapBottom" />')));
                    a5=bD.find(">.jspVerticalBar");
                    bz=a5.find(">.jspTrack");
                    bs=bz.find(">.jspDrag");
                    if(bk.showArrows){
                        by=d('<a class="jspArrow jspArrowUp" />').bind("mousedown.jsp",bT(0,-1)).bind("click.jsp",bV);
                        bJ=d('<a class="jspArrow jspArrowDown" />').bind("mousedown.jsp",bT(0,1)).bind("click.jsp",bV);
                        if(bk.arrowScrollOnHover){
                            by.bind("mouseover.jsp",bT(0,-1,by));
                            bJ.bind("mouseover.jsp",bT(0,1,bJ))
                        }
                        bE(bz,bk.verticalArrowPositions,by,bJ)
                    }
                    aM=aK;
                    bD.find(">.jspVerticalBar>.jspCap:visible,>.jspVerticalBar>.jspArrow").each(function(){
                        aM-=d(this).outerHeight()
                    });
                    bs.hover(function(){
                        bs.addClass("jspHover")
                    },function(){
                        bs.removeClass("jspHover")
                    }).bind("mousedown.jsp",function(h){
                        d("html").bind("dragstart.jsp selectstart.jsp",bV);
                        bs.addClass("jspActive");
                        var g=h.pageY-bs.position().top;
                        d("html").bind("mousemove.jsp",function(i){
                            a4(i.pageY-g,false)
                        }).bind("mouseup.jsp mouseleave.jsp",bo);
                        return false
                    });
                    aQ()
                }
            }
            function aQ(){
                bz.height(aM+"px");
                bh=0;
                a2=bk.verticalGutter+bz.outerWidth();
                a1.width(bF-a2-aZ);
                try{
                    if(a5.position().left===0){
                        a1.css("margin-left",a2+"px")
                    }
                }catch(g){}
            }
            function c(){
                if(bS){
                    bD.append(d('<div class="jspHorizontalBar" />').append(d('<div class="jspCap jspCapLeft" />'),d('<div class="jspTrack" />').append(d('<div class="jspDrag" />').append(d('<div class="jspDragLeft" />'),d('<div class="jspDragRight" />'))),d('<div class="jspCap jspCapRight" />')));
                    bC=bD.find(">.jspHorizontalBar");
                    bl=bC.find(">.jspTrack");
                    aX=bl.find(">.jspDrag");
                    if(bk.showArrows){
                        bm=d('<a class="jspArrow jspArrowLeft" />').bind("mousedown.jsp",bT(-1,0)).bind("click.jsp",bV);
                        aI=d('<a class="jspArrow jspArrowRight" />').bind("mousedown.jsp",bT(1,0)).bind("click.jsp",bV);
                        if(bk.arrowScrollOnHover){
                            bm.bind("mouseover.jsp",bT(-1,0,bm));
                            aI.bind("mouseover.jsp",bT(1,0,aI))
                        }
                        bE(bl,bk.horizontalArrowPositions,bm,aI)
                    }
                    aX.hover(function(){
                        aX.addClass("jspHover")
                    },function(){
                        aX.removeClass("jspHover")
                    }).bind("mousedown.jsp",function(h){
                        d("html").bind("dragstart.jsp selectstart.jsp",bV);
                        aX.addClass("jspActive");
                        var g=h.pageX-aX.position().left;
                        d("html").bind("mousemove.jsp",function(i){
                            a3(i.pageX-g,false)
                        }).bind("mouseup.jsp mouseleave.jsp",bo);
                        return false
                    });
                    aT=bD.innerWidth();
                    bH()
                }
            }
            function bH(){
                bD.find(">.jspHorizontalBar>.jspCap:visible,>.jspHorizontalBar>.jspArrow").each(function(){
                    aT-=d(this).outerWidth()
                });
                bl.width(aT+"px");
                bO=0
            }
            function bn(){
                if(bS&&bi){
                    var h=bl.outerHeight(),g=bz.outerWidth();
                    aM-=h;
                    d(bC).find(">.jspCap:visible,>.jspArrow").each(function(){
                        aT+=d(this).outerWidth()
                    });
                    aT-=g;
                    aK-=g;
                    bF-=h;
                    bl.parent().append(d('<div class="jspCorner" />').css("width",h+"px"));
                    aQ();
                    bH()
                }
                if(bS){
                    a1.width((bD.outerWidth()-aZ)+"px")
                }
                a0=a1.outerHeight();
                aO=a0/aK;
                if(bS){
                    bu=Math.ceil(1/s*aT);
                    if(bu>bk.horizontalDragMaxWidth){
                        bu=bk.horizontalDragMaxWidth
                    }else{
                        if(bu<bk.horizontalDragMinWidth){
                            bu=bk.horizontalDragMinWidth
                        }
                    }
                    aX.width(bu+"px");
                    aV=aT-bu;
                    bK(bO)
                }
                if(bi){
                    bw=Math.ceil(1/aO*aM);
                    if(bw>bk.verticalDragMaxHeight){
                        bw=bk.verticalDragMaxHeight
                    }else{
                        if(bw<bk.verticalDragMinHeight){
                            bw=bk.verticalDragMinHeight
                        }
                    }
                    bs.height(bw+"px");
                    aW=aM-bw;
                    bL(bh)
                }
            }
            function bE(l,j,m,h){
                var g="before",k="after",i;
                if(j=="os"){
                    j=/Mac/.test(navigator.platform)?"after":"split"
                }
                if(j==g){
                    k=j
                }else{
                    if(j==k){
                        g=j;
                        i=m;
                        m=h;
                        h=i
                    }
                }
                l[g](m)[k](h)
            }
            function bT(i,g,h){
                return function(){
                    bj(i,g,this,h);
                    this.blur();
                    return false
                }
            }
            function bj(k,l,g,i){
                g=d(g).addClass("jspActive");
                var j,m,n=true,h=function(){
                    if(k!==0){
                        a9.scrollByX(k*bk.arrowButtonSpeed)
                    }
                    if(l!==0){
                        a9.scrollByY(l*bk.arrowButtonSpeed)
                    }
                    m=setTimeout(h,n?bk.initialDelay:bk.arrowRepeatFreq);
                    n=false
                };

                h();
                j=i?"mouseout.jsp":"mouseup.jsp";
                i=i||d("html");
                i.bind(j,function(){
                    g.removeClass("jspActive");
                    m&&clearTimeout(m);
                    m=null;
                    i.unbind(j)
                })
            }
            function aP(){
                aJ();
                if(bi){
                    bz.bind("mousedown.jsp",function(i){
                        if(i.originalTarget===f||i.originalTarget==i.currentTarget){
                            var k=d(this),g=k.offset(),j=i.pageY-g.top-bh,m,n=true,h=function(){
                                var p=k.offset(),o=i.pageY-p.top-bw/2,r=aK*bk.scrollPagePercent,q=aW*r/(a0-aK);
                                if(j<0){
                                    if(bh-q>o){
                                        a9.scrollByY(-r)
                                    }else{
                                        a4(o)
                                    }
                                }else{
                                    if(j>0){
                                        if(bh+q<o){
                                            a9.scrollByY(r)
                                        }else{
                                            a4(o)
                                        }
                                    }else{
                                        l();
                                        return
                                    }
                                }
                                m=setTimeout(h,n?bk.initialDelay:bk.trackClickRepeatFreq);
                                n=false
                            },l=function(){
                                m&&clearTimeout(m);
                                m=null;
                                d(document).unbind("mouseup.jsp",l)
                            };

                            h();
                            d(document).bind("mouseup.jsp",l);
                            return false
                        }
                    })
                }
                if(bS){
                    bl.bind("mousedown.jsp",function(i){
                        if(i.originalTarget===f||i.originalTarget==i.currentTarget){
                            var k=d(this),g=k.offset(),j=i.pageX-g.left-bO,m,n=true,h=function(){
                                var p=k.offset(),o=i.pageX-p.left-bu/2,r=bF*bk.scrollPagePercent,q=aV*r/(a6-bF);
                                if(j<0){
                                    if(bO-q>o){
                                        a9.scrollByX(-r)
                                    }else{
                                        a3(o)
                                    }
                                }else{
                                    if(j>0){
                                        if(bO+q<o){
                                            a9.scrollByX(r)
                                        }else{
                                            a3(o)
                                        }
                                    }else{
                                        l();
                                        return
                                    }
                                }
                                m=setTimeout(h,n?bk.initialDelay:bk.trackClickRepeatFreq);
                                n=false
                            },l=function(){
                                m&&clearTimeout(m);
                                m=null;
                                d(document).unbind("mouseup.jsp",l)
                            };

                            h();
                            d(document).bind("mouseup.jsp",l);
                            return false
                        }
                    })
                }
            }
            function aJ(){
                if(bl){
                    bl.unbind("mousedown.jsp")
                }
                if(bz){
                    bz.unbind("mousedown.jsp")
                }
            }
            function bo(){
                d("html").unbind("dragstart.jsp selectstart.jsp mousemove.jsp mouseup.jsp mouseleave.jsp");
                if(bs){
                    bs.removeClass("jspActive")
                }
                if(aX){
                    aX.removeClass("jspActive")
                }
            }
            function a4(g,h){
                if(!bi){
                    return
                }
                if(g<0){
                    g=0
                }else{
                    if(g>aW){
                        g=aW
                    }
                }
                if(h===f){
                    h=bk.animateScroll
                }
                if(h){
                    a9.animate(bs,"top",g,bL)
                }else{
                    bs.css("top",g);
                    bL(g)
                }
            }
            function bL(k){
                if(k===f){
                    k=bs.position().top
                }
                bD.scrollTop(0);
                bh=k;
                var h=bh===0,j=bh==aW,i=k/aW,g=-i*(a0-aK);
                if(bG!=h||bQ!=j){
                    bG=h;
                    bQ=j;
                    br.trigger("jsp-arrow-change",[bG,bQ,ba,aU])
                }
                aL(h,j);
                a1.css("top",g);
                br.trigger("jsp-scroll-y",[-g,h,j]).trigger("scroll")
            }
            function a3(h,g){
                if(!bS){
                    return
                }
                if(h<0){
                    h=0
                }else{
                    if(h>aV){
                        h=aV
                    }
                }
                if(g===f){
                    g=bk.animateScroll
                }
                if(g){
                    a9.animate(aX,"left",h,bK)
                }else{
                    aX.css("left",h);
                    bK(h)
                }
            }
            function bK(k){
                if(k===f){
                    k=aX.position().left
                }
                bD.scrollTop(0);
                bO=k;
                var h=bO===0,i=bO==aV,j=k/aV,g=-j*(a6-bF);
                if(ba!=h||aU!=i){
                    ba=h;
                    aU=i;
                    br.trigger("jsp-arrow-change",[bG,bQ,ba,aU])
                }
                aN(h,i);
                a1.css("left",g);
                br.trigger("jsp-scroll-x",[-g,h,i]).trigger("scroll")
            }
            function aL(h,g){
                if(bk.showArrows){
                    by[h?"addClass":"removeClass"]("jspDisabled");
                    bJ[g?"addClass":"removeClass"]("jspDisabled")
                }
            }
            function aN(h,g){
                if(bk.showArrows){
                    bm[h?"addClass":"removeClass"]("jspDisabled");
                    aI[g?"addClass":"removeClass"]("jspDisabled")
                }
            }
            function bd(g,i){
                var h=g/(a0-aK);
                a4(h*aW,i)
            }
            function bc(i,g){
                var h=i/(a6-bF);
                a3(h*aV,g)
            }
            function bN(i,n,g){
                var q,u,t,v=0,j=0,h,o,p,l,m,k;
                try{
                    q=d(i)
                }catch(r){
                    return
                }
                u=q.outerHeight();
                t=q.outerWidth();
                bD.scrollTop(0);
                bD.scrollLeft(0);
                while(!q.is(".jspPane")){
                    v+=q.position().top;
                    j+=q.position().left;
                    q=q.offsetParent();
                    if(/^body|html$/i.test(q[0].nodeName)){
                        return
                    }
                }
                h=bW();
                p=h+aK;
                if(v<h||n){
                    m=v-bk.verticalGutter
                }else{
                    if(v+u>p){
                        m=v-aK+u+bk.verticalGutter
                    }
                }
                if(m){
                    bd(m,g)
                }
                o=bU();
                l=o+bF;
                if(j<o||n){
                    k=j-bk.horizontalGutter
                }else{
                    if(j+t>l){
                        k=j-bF+t+bk.horizontalGutter
                    }
                }
                if(k){
                    bc(k,g)
                }
            }
            function bU(){
                return -a1.position().left
            }
            function bW(){
                return -a1.position().top
            }
            function bf(){
                var g=a0-aK;
                return(g>20)&&(g-bW()<10)
            }
            function bv(){
                var g=a6-bF;
                return(g>20)&&(g-bU()<10)
            }
            function bI(){
                bD.unbind(bM).bind(bM,function(i,h,j,l){
                    var k=bO,g=bh;
                    a9.scrollBy(j*bk.mouseWheelSpeed,-l*bk.mouseWheelSpeed,false);
                    return k==bO&&g==bh
                })
            }
            function aR(){
                bD.unbind(bM)
            }
            function bV(){
                return false
            }
            function bg(){
                a1.find(":input,a").unbind("focus.jsp").bind("focus.jsp",function(g){
                    bN(g.target,false)
                })
            }
            function bp(){
                a1.find(":input,a").unbind("focus.jsp")
            }
            function a7(){
                var g,j,h=[];
                bS&&h.push(bC[0]);
                bi&&h.push(a5[0]);
                a1.focus(function(){
                    br.focus()
                });
                br.attr("tabindex",0).unbind("keydown.jsp keypress.jsp").bind("keydown.jsp",function(k){
                    if(k.target!==this&&!(h.length&&d(k.target).closest(h).length)){
                        return
                    }
                    var l=bO,m=bh;
                    switch(k.keyCode){
                        case 40:case 38:case 34:case 32:case 33:case 39:case 37:
                            g=k.keyCode;
                            i();
                            break;
                        case 35:
                            bd(a0-aK);
                            g=null;
                            break;
                        case 36:
                            bd(0);
                            g=null;
                            break
                    }
                    j=k.keyCode==g&&l!=bO||m!=bh;
                    return !j
                }).bind("keypress.jsp",function(k){
                    if(k.keyCode==g){
                        i()
                    }
                    return !j
                });
                if(bk.hideFocus){
                    br.css("outline","none");
                    if("hideFocus" in bD[0]){
                        br.attr("hideFocus",true)
                    }
                }else{
                    br.css("outline","");
                    if("hideFocus" in bD[0]){
                        br.attr("hideFocus",false)
                    }
                }
                function i(){
                    var k=bO,l=bh;
                    switch(g){
                        case 40:
                            a9.scrollByY(bk.keyboardSpeed,false);
                            break;
                        case 38:
                            a9.scrollByY(-bk.keyboardSpeed,false);
                            break;
                        case 34:case 32:
                            a9.scrollByY(aK*bk.scrollPagePercent,false);
                            break;
                        case 33:
                            a9.scrollByY(-aK*bk.scrollPagePercent,false);
                            break;
                        case 39:
                            a9.scrollByX(bk.keyboardSpeed,false);
                            break;
                        case 37:
                            a9.scrollByX(-bk.keyboardSpeed,false);
                            break
                    }
                    j=k!=bO||l!=bh;
                    return j
                }
            }
            function a8(){
                br.attr("tabindex","-1").removeAttr("tabindex").unbind("keydown.jsp keypress.jsp")
            }
            function bt(){
                if(location.hash&&location.hash.length>1){
                    var h,j,i=escape(location.hash.substr(1));
                    try{
                        h=d("#"+i+', a[name="'+i+'"]')
                    }catch(g){
                        return
                    }
                    if(h.length&&a1.find(i)){
                        if(bD.scrollTop()===0){
                            j=setInterval(function(){
                                if(bD.scrollTop()>0){
                                    bN(h,true);
                                    d(document).scrollTop(bD.position().top);
                                    clearInterval(j)
                                }
                            },50)
                        }else{
                            bN(h,true);
                            d(document).scrollTop(bD.position().top)
                        }
                    }
                }
            }
            function aS(){
                if(d(document.body).data("jspHijack")){
                    return
                }
                d(document.body).data("jspHijack",true);
                d(document.body).delegate("a[href*=#]","click",function(p){
                    var h=this.href.substr(0,this.href.indexOf("#")),o=location.href,k,j,g,m,n,l;
                    if(location.href.indexOf("#")!==-1){
                        o=location.href.substr(0,location.href.indexOf("#"))
                    }
                    if(h!==o){
                        return
                    }
                    k=escape(this.href.substr(this.href.indexOf("#")+1));
                    j;
                    try{
                        j=d("#"+k+', a[name="'+k+'"]')
                    }catch(i){
                        return
                    }
                    if(!j.length){
                        return
                    }
                    g=j.closest(".jspScrollable");
                    m=g.data("jsp");
                    m.scrollToElement(j,true);
                    if(g[0].scrollIntoView){
                        n=d(e).scrollTop();
                        l=j.offset().top;
                        if(l<n||l>n+d(e).height()){
                            g[0].scrollIntoView()
                        }
                    }
                    p.preventDefault()
                })
            }
            function bB(){
                var k,l,i,j,h,g=false;
                bD.unbind("touchstart.jsp touchmove.jsp touchend.jsp click.jsp-touchclick").bind("touchstart.jsp",function(n){
                    var m=n.originalEvent.touches[0];
                    k=bU();
                    l=bW();
                    i=m.pageX;
                    j=m.pageY;
                    h=false;
                    g=true
                }).bind("touchmove.jsp",function(m){
                    if(!g){
                        return
                    }
                    var n=m.originalEvent.touches[0],o=bO,p=bh;
                    a9.scrollTo(k+i-n.pageX,l+j-n.pageY);
                    h=h||Math.abs(i-n.pageX)>5||Math.abs(j-n.pageY)>5;
                    return o==bO&&p==bh
                }).bind("touchend.jsp",function(m){
                    g=false
                }).bind("click.jsp-touchclick",function(m){
                    if(h){
                        h=false;
                        return false
                    }
                })
            }
            function aY(){
                var g=bW(),h=bU();
                br.removeClass("jspScrollable").unbind(".jsp");
                br.replaceWith(bA.append(a1.children()));
                bA.scrollTop(g);
                bA.scrollLeft(h);
                if(bq){
                    clearInterval(bq)
                }
            }
            d.extend(a9,{
                reinitialise:function(g){
                    g=d.extend({},bk,g);
                    bx(g)
                },
                scrollToElement:function(h,i,g){
                    bN(h,i,g)
                },
                scrollTo:function(h,g,i){
                    bc(h,i);
                    bd(g,i)
                },
                scrollToX:function(h,g){
                    bc(h,g)
                },
                scrollToY:function(g,h){
                    bd(g,h)
                },
                scrollToPercentX:function(h,g){
                    bc(h*(a6-bF),g)
                },
                scrollToPercentY:function(h,g){
                    bd(h*(a0-aK),g)
                },
                scrollBy:function(i,g,h){
                    a9.scrollByX(i,h);
                    a9.scrollByY(g,h)
                },
                scrollByX:function(g,i){
                    var j=bU()+Math[g<0?"floor":"ceil"](g),h=j/(a6-bF);
                    a3(h*aV,i)
                },
                scrollByY:function(g,i){
                    var j=bW()+Math[g<0?"floor":"ceil"](g),h=j/(a0-aK);
                    a4(h*aW,i)
                },
                positionDragX:function(g,h){
                    a3(g,h)
                },
                positionDragY:function(h,g){
                    a4(h,g)
                },
                animate:function(k,h,g,i){
                    var j={};

                    j[h]=g;
                    k.animate(j,{
                        duration:bk.animateDuration,
                        easing:bk.animateEase,
                        queue:false,
                        step:i
                    })
                },
                getContentPositionX:function(){
                    return bU()
                },
                getContentPositionY:function(){
                    return bW()
                },
                getContentWidth:function(){
                    return a6
                },
                getContentHeight:function(){
                    return a0
                },
                getPercentScrolledX:function(){
                    return bU()/(a6-bF)
                },
                getPercentScrolledY:function(){
                    return bW()/(a0-aK)
                },
                getIsScrollableH:function(){
                    return bS
                },
                getIsScrollableV:function(){
                    return bi
                },
                getContentPane:function(){
                    return a1
                },
                scrollToBottom:function(g){
                    a4(aW,g)
                },
                hijackInternalLinks:d.noop,
                destroy:function(){
                    aY()
                }
            });
            bx(bb)
        }
        a=d.extend({},d.fn.jScrollPane.defaults,a);
        d.each(["mouseWheelSpeed","arrowButtonSpeed","trackClickSpeed","keyboardSpeed"],function(){
            a[this]=a[this]||a.speed
        });
        return this.each(function(){
            var h=d(this),c=h.data("jsp");
            if(c){
                c.reinitialise(a)
            }else{
                d("script",h).filter('[type="text/javascript"],:not([type])').remove();
                c=new b(h,a);
                h.data("jsp",c)
            }
        })
    };

    d.fn.jScrollPane.defaults={
        showArrows:false,
        maintainPosition:true,
        stickToBottom:false,
        stickToRight:false,
        clickOnTrack:true,
        autoReinitialise:false,
        autoReinitialiseDelay:500,
        verticalDragMinHeight:0,
        verticalDragMaxHeight:99999,
        horizontalDragMinWidth:0,
        horizontalDragMaxWidth:99999,
        contentWidth:f,
        animateScroll:false,
        animateDuration:300,
        animateEase:"linear",
        hijackInternalLinks:false,
        verticalGutter:4,
        horizontalGutter:4,
        mouseWheelSpeed:0,
        arrowButtonSpeed:0,
        arrowRepeatFreq:50,
        arrowScrollOnHover:false,
        trackClickSpeed:0,
        trackClickRepeatFreq:70,
        verticalArrowPositions:"split",
        horizontalArrowPositions:"split",
        enableKeyboardNavigation:true,
        hideFocus:false,
        keyboardSpeed:0,
        initialDelay:300,
        speed:30,
        scrollPagePercent:0.8
    }
})(jQuery,this);