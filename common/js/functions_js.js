function resetDate(){
    document.getElementById("frmDate").value=FROM,document.getElementById("frmToDate").value=TO
    }
    function resetaddedDate(){
    document.getElementById("addedDate").value=SEL_DATE
    }
    function dateCompare(e){
    var t=document.getElementById(e).frmToDate.value.split("-"),n=document.getElementById(e).frmDate.value.split("-"),r=n[0],a=n[1],o=n[2],l=t[0],i=t[1],d=t[2];
    if(document.getElementById(e).frmDate.value!=FROM&&document.getElementById(e).frmToDate.value!=TO){
        if(r>l)return alert(TO_DATE_GREATER_FROM),!1;
        if(i==a&&o>d&&l==r)return alert(TO_DATE_GREATER_FROM),!1;
        if(a>i&&l==r)return alert(TO_DATE_GREATER_FROM),!1
            }
            return!0
    }
    function validateAddVenueForm(e){
    if(validateForm(e,"frmVenueName","Venue Name","R","frmOwner_name","Owner Name","R","frmOwner_email","Email Address","RisEmail","frmProperty_Type","Property Type","R","frmVenueAddressFirst","Address","R","frmVenueCapacity","R")){
        {
            document.getElementById("frmVenueCapacity").value
            }
            return!0
        }
        return!1
    }
    function showSearchBox(e,t){
    document.getElementById(e).style.display="show"==t?"block":"none"
    }
    function checkCapsLock(e,t){
    var n=0,r=!1,a=CAPS_LOCK_TRUN_OFF;
    return document.all?(n=e.keyCode,r=e.shiftKey):document.layers?(n=e.which,r=16==n?!0:!1):document.getElementById&&(n=e.which,r=16==n?!0:!1),0==document.getElementById(t).value.length?(n>=65&&90>=n&&!r?alert(a):n>=97&&122>=n&&r&&alert(a),!1):void 0
    }
    function checkUserName(){
    var e=/^[0-9a-zA-Z_@.]+$/,t=document.getElementById("frm_login").frmAdminUserName.value,n=new Array,r="";
    for(i=0;i<t.length;i++)n[i]=t.charAt(i);
    for(i=0;i<n.length;i++)n[i].match(e)&&(r+=n[i]);
    ""!=r&&checkUserEmail(r)
    }
    function checkUserEmail(e){
    doAjax("ajax_act.php","type=signUp&userEmail="+e,"showUserEmail","GET")
    }
    function showUserEmail(e){
    document.getElementById("showUserName").style.display=e?"none":"inline"
    }
    function validateAdminLogin(e){
    return validateForm(e,"frmAdminUserName","Username (Email)","R","frmAdminPassword","Password","R")?!0:!1
    }
    function validateForm(){
    var e,t,n,r,a="",o=validateForm.arguments;
    j=0;
    var l=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,i=/[^\s]/,d=/^([a-zA-Z0-9-/_!#@]+)/,m=/^([a-zA-Z0-9_#@]+)$/,u=/^([a-zA-Z]+)$/,c=/^([0-9]+)$/,f=/^([0-9]{0,20}\.?[0-9]{1,2})$/;
    for(e=1;e<o.length-2;e+=3)if(mesg=o[e+1],r=o[e+2],val=document.forms[""+o[0]].elements[""+o[e]]){
        if(n=mesg,noVal=val,val=val.value,i.test(val))if(-1!=r.indexOf("isEqual"))result=trim(val),0==result.length?a+="- "+n+IS_REQUIRED+".\n":(equal_obj_val=r.substring(8,r.indexOf(":")),mesg_string=r.substring(r.indexOf(":")+1),val!=document.forms[""+o[0]].elements[""+equal_obj_val].value&&(a+="- "+n+AND+mesg_string+MUST_BE_SAME+".\n"));
            else if(-1!=r.indexOf("isAlphaNum"))result=trim(val),0==result.length?a+="- "+n+IS_REQUIRED+".\n":m.test(val)||(a+="- "+n+IS_NOT_VALID+" .\n");
            else if(-1!=r.indexOf("isNumeric"))c.test(val)||(a+="- "+n+MUST_CONTAIN_NUMRIC+" .\n");
            else if(-1!=r.indexOf("isMin"))val.length<6&&(a+="- "+n+MUST_CONTAIN_SIX+" .\n");
            else if(-1!=r.indexOf("isDecimal"))f.test(val)||(a+="- "+n+MUST_CONTAIN_NUMRIC+" .\n");
            else if(-1!=r.indexOf("isSpace"))result=trim(val),0==result.length?a+="- "+n+IS_REQUIRED+" .\n":d.test(val)||(a+="- "+n+IS_NOT_VALID+" .\n");
            else if(-1!=r.indexOf("isEmail"))t=val.indexOf("@"),s=val.indexOf("."),1>t||t==val.length-1?a+="- "+n+MUST_CONTAIN_VALID_EMAIL+" .\n":l.test(val)||(a+="- "+n+MUST_CONTAIN_VALID_EMAIL+".\n");
            else if(-1!=r.indexOf("isUrl"))t=val.indexOf("http://"),s=val.indexOf("."),0>t||t==val.length-1?a+="- "+n+MUST_CONTAIN_VALID_URL+" \n":(t>s||s==val.length-1)&&(a+="- "+n+MUST_CONTAIN_VALID_URL+" \n");
            else if(-1!=r.indexOf("isAdvertiserUrl"))val=HTTP+val,t=val.indexOf(HTTP),s=val.indexOf("."),0>t||t==val.length-1?a+="- "+n+MUST_CONTAIN_VALID_URL+" \n":(t>s||s==val.length-1)&&(a+="- "+n+MUST_CONTAIN_VALID_URL+" \n");
            else if(-1!=r.indexOf("isChar")){
            null==val.match(u)&&(a+="- "+n+MUST_CONTAIN_CORREC+" .\n")
            }else if(-1!=r.indexOf("isCheckbox")){
            var E=noVal.checked;
            E||(a+="- "+ACCPT_TC+" \n")
            }else"R"==r.charAt(0)&&(result=trim(val),0==result.length&&(a+="- "+n+IS_REQUIRED+" .\n"));else"R"==r.charAt(0)&&(result=trim(val),0==result.length&&(a+="- "+n+IS_REQUIRED+" .\n"));
        if(-1!=r.indexOf("isDate")){
            t=val.indexOf("-");
            {
                var v=val.split("-"),_=new Date,g=_.getFullYear(),I=_.getMonth(),R=_.getDate();
                _.getHours()
                }
                I+=1,9>=I&&(I="0"+I),9>=R&&(R="0"+R);
            var h=v[0],p=v[1],y=v[2];
            h>1&&(g>h?a+="- "+n+GREATER_THEN_CURR_DATE+" .\n":p==I&&R>y&&h==g?a+="- "+n+GREATER_THEN_CURR_DATE+".\n":I>p&&h==g&&(a+="- "+n+GREATER_THEN_CURR_DATE+" .\n"))
            }
            ""!=a&&0>=j&&(focusitem=document.forms[""+o[0]].elements[""+o[e]],j++)
        }
        if(a){
        var T=getMasterString();
        return alert(T+"\n"+a),focusitem.focus(),!1
        }
        return!0
    }
    function validateEmailChange(e){
    if(validateForm(e,"frmAdminEmail","Email","RisEmail")){
        var t=confirm(R_U_SURE_CHANGE_NOTIFICATION_EMAIL);
        return t?!0:!1
        }
        return!1
    }
    function validateChangePassword(e){
    if(validateForm(document.getElementById(e).id,"frmAdminOldPassword","Current Password","RisSpace","frmAdminNewPassword","New Password","RisMin","frmAdminConfirmPassword","Confirm New Password","RisEqualfrmAdminNewPassword:New Password")){
        var t=confirm(R_U_SURE_CHANGE_PASS);
        return t?!0:!1
        }
        return!1
    }
    function validateTicketForm(){
    for(var e=document.getElementsByName("frmSupportTicket[]"),t=0;t<e.length;t++)if(""==e[t].value)return alert(TICKET_TYPE_R),e[t].focus(),!1;return!0
    }
    function validateDisputedForm(){
    for(var e=document.getElementsByName("frmDisputedCommentTitle[]"),t=0;t<e.length;t++)if(""==e[t].value)return alert(DISPUTED_TITLE_R),e[t].focus(),!1;return!0
    }
    function validateResetPassword(e){
    return validateForm(document.getElementById(e).id,"frmNewPassword","New Password","RisSpace","frmConfirmNewPassword","Confirm New Password","RisEqualfrmNewPassword:New Password")?!0:!1
    }
    function validateForgotPassword(e){
    return validateForm(e,"frmUserName"," E-mail Address","RisEmail","frmSecurityCode","Verification code","R")?!0:!1
    }
    function ltrim(e){
    for(var t=0;t<e.length&&isWhitespace(e.charAt(t));t++);
    return e.substring(t,e.length)
    }
    function rtrim(e){
    for(var t=e.length-1;t>=0&&isWhitespace(e.charAt(t));t--);
    return e.substring(0,t+1)
    }
    function trim(e){
    return ltrim(rtrim(e))
    }
    function isWhitespace(e){
    var t=" 	\n\r\f";
    return-1!=t.indexOf(e)
    }
    function checkError(e){
    var t=!1,n=getMasterString();
    return""!=e&&(n+=e,t=!0),1==t?(falert(n),!1):!0
    }
    function getMasterString(){
    return SORRY_CANT_COMPLETE_REQUEST
    }
    function toggleOption(e){
    var t=e.checked,n=e;
    for(elm=n.form.elements,i=0;i<elm.length;i++)"checkbox"==elm[i].type&&elm[i].id!=n.id&&(elm[i].checked=0==t?!1:!0)
        }
     
    function toggleShippingOption(e){
    var t=e.checked,n=e;
    if(t==true){
     checkByParent('shippingGateways', true);   
    }else{
        checkByParent('shippingGateways', false);   
    }
    
    
    }
        
    function checkByParent(aId, aChecked) {
    var collection = document.getElementById(aId).getElementsByTagName('INPUT');
    for (var x=0; x<collection.length; x++) {
    if (collection[x].type.toUpperCase()=='CHECKBOX')
        collection[x].checked = aChecked;
    }
    }
        
        function setValidAction(e,t,n){
    "Delete"==e||e.indexOf("Delete")>-1?message=" "+DELETED_SEL+" "+n:e==EXPORT_EXCEL?(document.getElementById("frmAction").value="Export",t.submit()):message=" "+SEL_STATUS_CHANGE+n;
    var r=validator(message,t);
    if(!r){
        if("Wholesalers(s)"!=n&&"Enquiry(s)"!=n)for(t.frmChangeAction.value="",document.getElementById("Main").checked=!1,elm="wholesaler support(s)"==n||"Role(s)"==n||"Section(s)"==n||"News(s)"==n||"Edition(s)"==n||"MagazineArticle(s)"==n||"DisplayCategory(s)"==n||"Article(s)"==n||"Shipping Price(s)"==n?document.forms[1].elements:"Category(s)"==n?document.forms[1].elements:document.forms[0].elements,i=0;i<elm.length;i++)"checkbox"==elm[i].type&&(elm[i].checked=!1);
        return!1
        }
        t.submit()
    }
    function validator(e,t){
    var n=t,r="",a=0,o=n.elements.length,l=0;
    for(l=0;o>l;l++)if("checkbox"==n.elements[l].type){
        if(n.elements[l].checked)return askConfirm(e,n.id);
        a=1
        }
        return 1==a&&(r+="<br />"+SEL_ONE_RECORD),checkError(r)
    }
    function askConfirm(e,t){
    var n=" "+R_U_SURE_WANT+e+"?";
    return fconfirm(n,t,1)?!0:!1
    }
    function dateEditionCompare(e){
    {
        var t=parseInt(document.getElementById(e).frmEditionYearFrom.value),n=parseInt(document.getElementById(e).frmEditionMonthFrom.value),r=parseInt(document.getElementById(e).frmEditionYearTo.value),a=parseInt(document.getElementById(e).frmEditionMonthTo.value),o=new Date;
        o.getMonth()+1,o.getFullYear()
        }
        return t>r?(alert(TO_DATE_GREATER_FROM),!1):n>a&&r==t?(alert(TO_DATE_GREATER_FROM),!1):!0
    }
    function showProducts(e,t,n){
    return""==t&&(t=0),""==e&&""!=t?(alert("Please select the product category."),$("#frmSimilarProductBrandID_"+n).val(""),$("#frmSimilarProductDivID_"+n).html(""),!1):""!=e&&""==t?($("#frmSimilarProductDivID_"+n).html(""),!1):(doAjax("ajax_act.php","type=showProducts&categoryID="+e+"&brandID="+t+"&TempCount="+n,"showProductList","GET"),void 0)
    }
    function showProductList(e){
    varResponseCount=0;
    var t=e.split("###"),n=t[0];
    varResponseCount=t[1],n!='<select name="frmSimilarProducts[]" id="frmSimilarProducts_'+varResponseCount+'" MULTIPLE></select>'?$("#frmSimilarProductDivID_"+varResponseCount).html(n):$("#frmSimilarProductDivID_"+varResponseCount).html(NO_PRODUCT_FOUND)
    }
    function showRecommendedProducts(e,t,n){
    return""==e&&""!=t?(alert("Please select the product category."),$("#frmRecommendedProductBrandID_"+n).val(""),$("#frmRecommendedProductDivID_"+n).html(""),!1):""!=e&&""==t?($("#frmRecommendedProductDivID_"+n).html(""),!1):(doAjax("ajax_act.php","type=showRecommendedProducts&categoryID="+e+"&brandID="+t+"&TempCount_R="+n,"showRecomendedProductList","GET"),void 0)
    }
    function showRecomendedProductList(e){
    varResponseCount=0;
    var t=e.split("###"),n=t[0];
    varResponseCount=t[1],n!='<select name="frmRecommendedProducts[]" id="frmRecommendedProducts_'+varResponseCount+'" MULTIPLE></select>'?$("#frmRecommendedProductDivID_"+varResponseCount).html(n):$("#frmRecommendedProductDivID_"+varResponseCount).html(NO_PRODUCT_FOUND)
    }
    function removeSimilarProduct(e,t){
    return e&&t?(location.href="product_action.php?frmProcess=deleteSimilarProduct&productID="+e+"&similarProductID="+t,void 0):!1
    }
    function removeRecommendedProduct(e,t){
    return e&&t?(location.href="product_action.php?frmProcess=deleteRecommendedProduct&productID="+e+"&RecommendedProductID="+t,void 0):!1
    }
    function selectToRemove(e){
    var t=0,n=0,r="",a=document.getElementsByName("frmDeleteSimilarRecord");
    for(r="&ProductID="+e+"&fkSimilarProductID=",n=0;n<a.length;n++)"checkbox"===a[n].type&&a[n].checked===!0&&(t++,r=r+a[n].value+",");
    t>0?(r=r.substr(1),doAjax("ajax_act.php","type=deleteSimiLarItems&"+r,"showResultRestItems","GET")):alert(SEL_ONE_TO_DELETE)
    }
    function selectToRemoveRecommended(e){
    var t=0,n=0,r="",a=document.getElementsByName("frmDeleteRecommendedRecord");
    for(r="&ProductID="+e+"&fkRecommendedProductID=",n=0;n<a.length;n++)"checkbox"===a[n].type&&a[n].checked===!0&&(t++,r=r+a[n].value+",");
    t>0?(r=r.substr(1),doAjax("ajax_act.php","type=deleteRecommendedItems&"+r,"showResultRestItems","GET")):alert(SEL_ONE_TO_DELETE)
    }
    function addMoreFiles(){
    var e=$("#addimage-fields").parent().find("input").length;
    return e>10?(alert(ADD_MAX_10_IMAGES),$("#addmore").hide(),!1):($("#addimage-fields").append('<br /><input type="file" name="frmVenueImage[]" id="frmVenueImage" />'),void 0)
    }
    function validateEnquiryForm(){
    if(""==document.getElementById("purpose").value)return alert(PUR_REQ),document.getElementById("purpose").focus(),!1;
    if(""==document.getElementById("UserFirstName").value||document.getElementById("UserFirstName").value==F_NAME)return alert(USER_NAME_REQ),document.getElementById("UserFirstName").focus(),!1;
    if(document.getElementById("UserPhone").value==P_NO)return alert(PHONE_NO_NUMRIC_REQ),document.getElementById("UserPhone").focus(),!1;
    var e=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(""==document.getElementById("UserEmail").value||"Email*:"==document.getElementById("UserEmail").value)return alert(ENTER_EMAIL),document.getElementById("UserEmail").focus(),!1;
    if(""!=document.getElementById("UserEmail").value)for(var t=document.getElementById("UserEmail").value.split(","),n=0;n<t.length;n++)if(!e.test(t[n]))return alert(t[n]+EMAIL_SEEMS_WRONG+" "),document.getElementById("UserEmail").focus(),!1
        }
        function validateContact(){
    if(""==document.getElementById("name").value||"Name*"==document.getElementById("name").value)return alert(NAME_REQ),document.getElementById("name").focus(),!1;
    if(""==document.getElementById("company").value||"Company*"==document.getElementById("company").value)return alert(COMPANY_NAME_REQ),document.getElementById("company").focus(),!1;
    if(""==document.getElementById("location").value||"Location*"==document.getElementById("location").value)return alert(LOCATION_REQ),document.getElementById("location").focus(),!1;
    var e=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(""==document.getElementById("email").value||"Email:*"==document.getElementById("email").value)return alert(ENTER_EMAIL),document.getElementById("email").focus(),!1;
    if(""!=document.getElementById("email").value)for(var t=document.getElementById("email").value.split(","),n=0;n<t.length;n++)if(!e.test(t[n]))return alert(t[n]+EMAIL_SEEMS_WRONG+" "),document.getElementById("email").focus(),!1
        }
        function singleSelectClick(e,t){
    var n=1;
    e.checked||(document.getElementById("Main").checked=!1);
    for(var r=document.getElementsByClassName(t),a=0;a<r.length;a++)if(!r[a].checked){
        n=0;
        break
    }
    n&&(document.getElementById("Main").checked=!0)
    }
    function popClose(e,t,n){
    if($("#"+e).remove(),$("#modalOverlay").remove(),1==n&&void 0!=n)document.getElementById(t).submit();
    else{
        if(""==t||void 0==t)return!1;
        document.location.href=t
        }
    }
function falert(e){
    $("body").append('<div id="modalOverlay"> </div>'),$("body").append('<div id="modal--1" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popClose(\'modal--1\')">X</button><h3 id="myModalLabel">!</h3></div><div class="modal-body"><p>'+e+'</p></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true" onclick="return popClose(\'modal--1\')">OK</button></div></div>')
    }
    function fconfirm(e,t,n){
    return $("body").append('<div id="modalOverlay"> </div>'),$("body").append('<div id="modal--1" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-header box-title"><button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popClose(\'modal--1\')">X</button><h3 id="myModalLabel">!</h3></div><div class="modal-body"><p>'+e+'</p></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true" onclick="return popClose(\'modal--1\',\''+t+"',"+n+')">OK</button><button class="btn" data-dismiss="modal" aria-hidden="true" onclick="popClose(\'modal--1\')">Cancel</button></div></div>'),!1
    }
    var btnType;