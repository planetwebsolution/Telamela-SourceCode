(function(e){
    e.fn.canvasAreaDraw=function(e){
        this.each(function(n,r){
            t.apply(r,[n,r,e])
        })
    };
        
    var t=function(t,r,i){
        var s,o,u,a,f,l,c,h,p,d,v,m,g,y,b;
        u=e.extend({
            imageUrl:e(this).attr("data-image-url")
        },i),e(this).val().length?s=e(this).val().split(",").map(function(e){
            return parseInt(e,10)
        }):s=[],a=e('<button type="button" class="btn">Clear</button>&nbsp;<button type="button" class="btn" onclick="addDynamicRowToTableForHomeBanner()">Add</button>'),f=e("<canvas>"),l=f[0].getContext("2d"),c=new Image,m=function(){
            f.attr("height",c.height).attr("width",c.width),h()
        },e(c).load(m),c.src=u.imageUrl,c.loaded&&m(),f.css({
            background:"url("+c.src+")",
            border:"1px solid #368EE0",
            margin:"10px 0 0 0"
        }),e(document).ready(function(){
            e(r).after("<br>",f,"<br>",a),a.click(g),f.bind("mousedown",p),f.bind("contextmenu",y),f.bind("mouseup",d)
        }),g=function(){
            s=[],h()
        },v=function(t){
            t.offsetX||(t.offsetX=t.pageX-e(t.target).offset().left,t.offsetY=t.pageY-e(t.target).offset().top),s[o]=Math.round(t.offsetX),s[o+1]=Math.round(t.offsetY),h()
        },d=function(){
            e(this).unbind("mousemove"),b(),o=null
        },y=function(t){
            t.preventDefault(),t.offsetX||(t.offsetX=t.pageX-e(t.target).offset().left,t.offsetY=t.pageY-e(t.target).offset().top);
            var n=t.offsetX,r=t.offsetY;
            for(var i=0;i<s.length;i+=2){
                dis=Math.sqrt(Math.pow(n-s[i],2)+Math.pow(r-s[i+1],2));
                if(dis<6)return s.splice(i,2),h(),b(),!1
            }
            return!1
        },p=function(t){
            var r,i,u,a,f=s.length;
            if(t.which===3)return!1;
            t.preventDefault(),t.offsetX||(t.offsetX=t.pageX-e(t.target).offset().left,t.offsetY=t.pageY-e(t.target).offset().top),r=t.offsetX,i=t.offsetY;
            for(var l=0;l<s.length;l+=2){
                u=Math.sqrt(Math.pow(r-s[l],2)+Math.pow(i-s[l+1],2));
                if(u<6)return o=l,e(this).bind("mousemove",v),!1
            }
            for(var l=0;l<s.length;l+=2)l>1&&(a=n(r,i,s[l],s[l+1],s[l-2],s[l-1],!0),a<6&&(f=l));
            return console.log(s),s.splice(f,0,Math.round(r),Math.round(i)),o=f,e(this).bind("mousemove",v),h(),b(),!1
        },h=function(){
            l.canvas.width=l.canvas.width;
            if(s.length<2)return!1;
            l.globalCompositeOperation="destination-over",l.fillStyle="rgb(255,255,255)",l.strokeStyle="rgb(255,20,20)",l.lineWidth=1,l.beginPath(),l.moveTo(s[0],s[1]);
            for(var e=0;e<s.length;e+=2)l.fillRect(s[e]-2,s[e+1]-2,4,4),l.strokeRect(s[e]-2,s[e+1]-2,4,4),s.length>2&&e>1&&l.lineTo(s[e],s[e+1]);
            l.closePath(),l.fillStyle="rgba(255,0,0,0.3)",l.fill(),l.stroke(),b()
        },b=function(){
            e(r).val(s.join(","))
        }
    };
    
    e(document).ready(function(){
        e(".canvas-area[data-image-url]").canvasAreaDraw()
    });
    var n=function(e,t,n,r,i,s,o){
        function u(e,t,n,r){
            return Math.sqrt((e-=n)*e+(t-=r)*t)
        }
        if(o&&!(o=function(e,t,n,r,i,s){
            if(!(i-n))return{
                x:n,
                y:t
            };
        
            if(!(s-r))return{
                x:e,
                y:r
            };
        
            var o,u=-1/((s-r)/(i-n));
            return{
                x:o=(i*(e*u-t+r)+n*(e*-u+t-s))/(u*(i-n)+r-s),
                y:u*o-u*e+t
            }
        }(e,t,n,r,i,s),o.x>=Math.min(n,i)&&o.x<=Math.max(n,i)&&o.y>=Math.min(r,s)&&o.y<=Math.max(r,s))){
            var a=u(e,t,n,r),f=u(e,t,i,s);
            return a>f?f:a
        }
        var l=r-s,c=i-n,h=n*s-r*i;
        return Math.abs(l*e+c*t+h)/Math.sqrt(l*l+c*c)
    }
})(jQuery);