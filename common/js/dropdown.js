function selectedSelectBox(b,a,c){if(document.getElementById(b)){if(c!="reset"){document.getElementById(b).innerHTML=c;document.getElementById(a).style.display="none"}else{alert("reset")}}}function showList(a){if(document.getElementById(a).style.display=="block"){document.getElementById(a).style.display="none"}else{document.getElementById(a).style.display="block"}}function dropDown(e,d,a,b){objTarget=document.getElementById(e);hideDropDown(e);assignButtonClick(objTarget,a);assignChildNodeClick(objTarget,e,d,b);if(!document.getElementById("openDropDown")){var c=document.createElement("input");c.setAttribute("type","hidden");c.setAttribute("id","openDropDown");document.body.appendChild(c)}}function hideDropDown(a){objEL=document.getElementById(a);if(objEL){if(objEL.style.display=="block"||!objEL.style.display){objEL.style.display="none"}}else{alert(PROBLEM_WITH_DROP_DOWN+a)}}function assignButtonClick(b,a){actionButton=document.getElementById(a);actionButton.onclick=function(){currentOpenDD=document.getElementById("openDropDown").value;if(currentOpenDD!=""&&currentOpenDD==(b.id+";;"+a)){document.getElementById("openDropDown").value=""}else{if(currentOpenDD!=""){values=currentOpenDD.split(";;");hideDropDown(values[0]);document.getElementById("openDropDown").value=b.id+";;"+a}else{document.getElementById("openDropDown").value=b.id+";;"+a}}if(b.style.display=="block"||!b.style.display){b.style.display="none"}else{b.style.display="block"}}}function assignChildNodeClick(b,c,a,d){arrListElements=b.getElementsByTagName("LI");for(i=0;i<arrListElements.length;i++){arrAnchorChild=arrListElements[i].getElementsByTagName("A");for(j=0;j<arrAnchorChild.length;j++){currentNode=arrAnchorChild[j];currentNode.onclick=function(){if(d){d.call(this,this,c,a)}else{processClick(this,c,a)}}}}}function processClick(a,d,c){document.getElementById(d).style.display="none";document.getElementById(c).innerHTML=trim(a.innerHTML);var b=trim(a.id);arr=b.split("_")}if(window.document.addEventListener){window.document.addEventListener("click",captureClick,false)}else{if(window.document.attachEvent){window.document.attachEvent("onclick",captureClick)}}function captureClick(a){if(window.event){target=window.event.srcElement}else{target=a.target?a.target:a.srcElement}if(document.getElementById("openDropDown").value!=""){arrValues=document.getElementById("openDropDown").value.split(";;");if(!checkParent(target,arrValues[0])){if(target.id!=arrValues[1]){hideDropDown(arrValues[0]);document.getElementById("openDropDown").value=""}}}}function loadEvents(){if(document.getElementById("drop_list_1")!=null){dropDown("drop_list_1","drop_box_1","drop_image_1")}if(document.getElementById("drop_list_2")!=null){dropDown("drop_list_2","drop_box_2","drop_image_2")}if(document.getElementById("drop_list_3")!=null){dropDown("drop_list_3","drop_box_3","drop_image_3")}if(document.getElementById("drop_list_4")!=null){dropDown("drop_list_4","drop_box_4","drop_image_4")}if(document.getElementById("drop_list_5")!=null){dropDown("drop_list_5","drop_box_5","drop_image_5")}if(document.getElementById("drop_list_6")!=null){dropDown("drop_list_6","drop_box_6","drop_image_6")}if(document.getElementById("drop_list_7")!=null){dropDown("drop_list_7","drop_box_7","drop_image_7")}if(document.getElementById("drop_list_8")!=null){dropDown("drop_list_8","drop_box_8","drop_image_8")}}function extraCallback(){var a=arguments[0];var c=arguments[1];var d=arguments[2];myParent=a.parentNode;arrListItems=myParent.parentNode.getElementsByTagName("LI");for(i=0;i<arrListItems.length;i++){children=arrListItems[i].childNodes;if(children[0].nodeName=="SPAN"){arrListItems[i].innerHTML=children[0].innerHTML}}var b=a.parentNode.innerHTML;a.parentNode.innerHTML="<span>"+b+"</span>";arrImgItems=document.getElementById(d).getElementsByTagName("IMG");arrImgItems[0].src=arrImgItems[0].src.replace(/flag(.*).gif/ig,"flag_"+a.className+".gif")}function addMultipleLoadEvents(a){var b=window.onload;if(typeof window.onload!="function"){window.onload=a}else{window.onload=function(){if(b){b()}a()}}}function checkParent(b,a){if(b.parentNode.id==a){return true}else{if(b.parentNode.nodeName=="BODY"){return false}else{return checkParent(b.parentNode,a)}}}addMultipleLoadEvents(loadEvents);function trim(e,d){var b,a=0,c=0;e+="";if(!d){b=" \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000"}else{d+="";b=d.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g,"$1")}a=e.length;for(c=0;c<a;c++){if(b.indexOf(e.charAt(c))===-1){e=e.substring(c);break}}a=e.length;for(c=a-1;c>=0;c--){if(b.indexOf(e.charAt(c))===-1){e=e.substring(0,c+1);break}}return b.indexOf(e.charAt(0))===-1?e:""};