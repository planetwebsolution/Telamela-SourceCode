<?php 
require_once SOURCE_ROOT.'classes/class_common.php';
$common = new ClassCommon();
$logoData = $common->getLogo();
if(isset($logoData[0]['site_logo']) && $logoData[0]['site_logo'] != '')
{
	$logo = UPLOAD_FILES_IMAGES_PATH.'site_logo/'.$logoData[0]['site_logo'];
	$title = $logoData[0]['site_name'];
}else{
	$logo = IMAGE_FRONT_SOURCE_PATH.'service-logo.gif';
	$title = 'Landmark Africa';
}
?>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH ?>message.inc.js"></script>
<link href="<?php echo INC_FRONT_CSS_PATH; ?>colorbox.css" rel="stylesheet" type="text/css" media="all" />
<script src="<?php echo INC_FRONT_JS_PATH; ?>jquery.colorbox.js" type="text/javascript"></script>


<script>
			 function jscall(){
                //alert('hi');return false;
             $(".subs").colorbox({inline:true, width:"450px", height:"220px",escKey:false,overlayClose:false});
               $('#submitremarks').click(function(){
                 var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(document.getElementById('subscribe_email').value == "")
	   {
	     alert(ENTER_EMAIL);
	     document.getElementById('subscribe_email').focus() ;
	     return false;
	   }
	if(document.getElementById('subscribe_email').value != "")
	{
	    var result = document.getElementById('subscribe_email').value.split(",");
	   // alert(result);
	    for(var i = 0;i < result.length;i++)
	    {
		    if(!regEmail.test(result[i])) 
			{
			    alert(result[i]+EMAIL_SEEMS_WRONG); 		
			    document.getElementById('subscribe_email').focus();
		    	return false;
	    	}else{
               
                  	var content = document.getElementById('subscribe_email').value;   
                  	window.location =('subscribe.php?email='+content);   
                 } 
	    }
	}
                 
             });          
            }
		</script>  
        
<div class="header">
	<a href="index.php" class="logo">
	<img src="<?php echo $logo;?>" title="<?php echo $title;?>" alt="<?php echo $title;?>"/></a>
	<div class="headerRight">
	    <div class="loginBlock">
            <a class="subs" onClick="return jscall()" href="#listed_reject"><input type="submit" name="" value="Subscribe" class="s-btn service-btn"/></a>
	        <ul class="ClientLogin" style="background: none;">
				<li>
					<a class="subs" href="#"><input type="submit" name="" value="Client Login" class="s-btn service-btn"/></a>
				</li>
			</ul>
	    </div>
	    <ul class="socialIcon">
            <li><a href="#" class="icon2" title="FACEBOOK"></a></li>
            <li><a href="#" class="icon3" title="TWITTER"></a></li>
            <li class="last"><a href="#" class="icon4" title="IN"></a></li>
	    </ul>
	</div>
</div>
<div style='display:none'>
	<div id='listed_reject'>
            <table id='listed_reject_approve'>
		<tr>
                    <td style="width: 335px; float: left">Please enter your email for landmark newsletter subscription : </td>
                </tr>
            </table>
            <table id='listed_reject_approve'>
                <tr>
                    <td  valign="top" style="width: 200px; float: left; margin: 8px 0 0 19px;"><input type="text" size="21" name="subscribe_email" id="subscribe_email" value=""/></td>
                    <td valign="top" style="float: left; margin-top: 8px;"><input type="submit" name="submitremarks" id="submitremarks" value="Subscribe" style="cursor: pointer;"/></td>
                </tr>
                
            </table>
        </div>
	</div>
