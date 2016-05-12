<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo COMPOSE_TITLE;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <link rel="stylesheet" type="text/css" href="common/css/layout.css"/>  
        <link rel="stylesheet" type="text/css" href="common/css/fonts.css"/>		
        <link rel="stylesheet" type="text/css" href="common/css/css3.css"/> 
        <link rel="stylesheet" type="text/css" href="common/css/stylish-select.css"/>       
        <script type="text/javascript" src="common/js/jquery.js"></script>        
        <script type="text/javascript" src="common/js/dropdownjs.js"></script>        
        <script type="text/javascript" src="common/js/custom.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){ 
                $('.drop_down1').sSelect();
            });
        </script>
    </head>
    <body>
        <div id="navBar">
            <div class="topBar">
                <div class="layout">
                    <div class="navBlock">
                        <div class="navRight">
                            <div class="myCart">
                                <span class="cart"><?php echo MY_CART;?></span>
                                <span class="cartValue"><?php echo COMPOSE_NO;?></span>
                            </div>
                            <ul class="topMenu">
                                <li class="link1"><a href="#"><?php echo SEND_GIFT;?></a></li>
                                <li class="link2"><a href="#"><?php echo SUBSCRIBE;?></a></li>
                                <li class="link4"><a href="#"><?php echo MY_AC;?></a></li> 
                                <li class="link5"><a href="#">  <?php echo MY_OR;?></a></li> 
                                <li class="link6"><a href="#"><?php echo MY_WISH;?></a></li> 
                                <li class="link7"><a href="#"> <?php echo MESSAGE;?></a></li> 
                            </ul>
                            <div class="newBlock">
                                <small><?php echo WH_NEW;?></small>
                            </div>
                        </div>
                        <ul class="loginBlock">
                            <li class="signIn signOut"><a href="#"><?php echo SI_OUT;?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="ouderContainer">
            <div class="layout">
                <div class="header">
                    <div class="headerRight">
                        <div class="rightTop">
                            <ul class="social">
                                <li><a href="#"><img src="common/images/icon1.gif" alt="" /></a></li>
                                <li><a href="#"><img src="common/images/icon2.gif" alt="" /></a></li>
                                <li><a href="#"><img src="common/images/icon3.gif" alt="" /></a></li>
                                <li><a href="#"><img src="common/images/icon4.gif" alt="" /></a></li>
                            </ul> 
                            <div class="Currency">
                                <select class="my-dropdown">
                                    <option><?php echo CURRENCY;?></option>
                                    <option>1</option>
                                    <option>2</option>                                            
                                </select>
                            </div>							
                            <div class="language">
                                <select class="my-dropdown">
                                    <option><?php echo LAN;?></option>
                                    <option>1</option>
                                    <option>2</option>                                            
                                </select>
                            </div>                            
                        </div> 
                        <div class="rightBottom">
                            <form action="" method="get">
                                <div class="searchBlock">
                                    <div class="categories">
                                        <select class="my-dropdown">
                                            <option><?php echo ALL_CAT;?></option>
                                            <option><?php echo CAT_1;?></option>
                                            <option><?php echo CAT_2;?></option>                                            
                                        </select>
                                    </div>

                                    <input type="text" value="<?php echo SEARCH_FOR_BRAND;?>" onfocus="if(this.value=='<?php echo SEARCH_FOR_BRAND;?>')this.value=''" onblur="if(this.value=='')this.value='<?php echo SEARCH_FOR_BRAND;?>'"/>
                                    <input type="submit" value=""/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a class="logo" title="logo" href="#"><img src="common/images/logo.png" alt="logo" /></a>
                    <div class="navSection">
                        <ul class="menu">
                            <li class="home"><a href="#"><img src="common/images/home_icon.png" alt="" /></a></li>
                            <li><a href="#"><?php echo MENS;?></a></li>
                            <li><a href="#"><?php echo WOMENS;?></a></li>
                            <li><a href="#"><?php echo BABY;?></a></li>
                            <li><a href="#"><?php echo KID;?></a></li>
                            <li><a href="#"><?php echo TOYS;?></a></li>
                            <li><a href="#"><?php echo HOM_TRA;?></a></li>
                            <li><a href="#"><?php echo HEALTH_FIT;?></a></li>
                            <li><a href="#"><?php echo SPOR;?></a></li>
                            <li><a href="#"><?php echo ELEC;?></a></li>
                            <li class="last"><a href="#"><?php echo AUTO;?></a></li>
                        </ul>
                        <a href="#" class="setting"></a>
                        <span class="flower_icon"><img src="common/images/flower_icon.png" alt=""/></span>
                        <div class="dropBlock">
                            <ul class="dropList">
                                <li><a href="#"><?php echo PHA_EQES;?></a></li>
                                <li><a href="#"><?php echo ACC_RHO;?></a></li>
                                <li><a href="#"><?php echo CRAS_BLA;?></a></li>
                                <li><a href="#"><?php echo LIB_DAP;?></a></li>
                                <li><a href="#"><?php echo CRAS_FEU;?></a></li>
                                <li><a href="#"><?php echo QUI_LOB;?></a></li>
                                <li><a href="#"><?php echo SED_CON;?></a></li>
                                <li><a href="#"><?php echo FUS_MAL;?></a></li>
                                <li><a href="#"><?php echo LAC_TEM;?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="add_pakage_outer">
                    <div class="top_container" style="padding: 20px 0 18px;">
                     
                        <h2 class="man_icon"><?php echo CUSTOMER;?> <span><?php echo AC;?></span></h2>
                    </div>
                    
                    
                        <div class="add_edit_pakage compose_sec">
                            <div class="compose_left_outer">
                                <ul class="compose_left">
                                    <li class="inbox"><a href="#"><?php echo INBOX;?></a></li>
                                    <li class="outbox"><a href="#"><?php echo OUTBOX;?></a></li>
                                    <li class="compose_box"><a href="#"><?php echo COMPOSE;?><small><img src="common/images/ref_icon.png" alt=""/></small></a></li>
                                </ul>
                                </div>
                                <div class="compose_right_outer">
                                    <div class="compose_right">
                                        <h2><?php echo COMPOS_MAIL;?></h2>
                                        <ul class="compose_right_inner">
                                <li>
                                    <label><?php echo TO;?> <strong>:</strong></label>
                                    <div class="input_sec">
                                    <input type="text" value=""/>
                                    <div class="drop4">
                                            <select class="drop_down1">
                                                <option><?php echo WHOLESALER;?></option>
                                                <option><?php echo WHOLESALER;?></option>
                                                <option><?php echo WHOLESALER;?></option>
                                            </select> 
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <label><?php echo TYPE;?> <strong>:</strong></label>
                                        <input type="text" value=""/>
                                </li>
                                <li>
                                    <label><?php echo SUBJECT;?> <strong>:</strong></label>
                                    <input type="text" value=""/>
                                </li>
                                            <li>
                                    <label><?php echo MESSAGE;?> <strong>:</strong></label>
                                    <textarea cols="5" rows="5"></textarea>
                                </li>
                                            <li class="create_cancle_btn">
                                    <label style="visibility: hidden">.</label>
                                    <input type="button" value="Send" class="update_btn update2"/>
                                    <input type="button" value="Cancel" class="cancel"/>
                                </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        
                    
                </div>
            </div>
        </div>
        <div id="outerFooter">
            <div class="layout">
                <div class="footerRight">
                    <a class="logo" title="logo" href="#"><img src="common/images/footer-logo.png" alt="" /></a>
                    <ul class="footSocial">
                        <li><a href="#"><img src="common/images/t_icon.png" alt="" /></a></li>
                        <li><a href="#"><img src="common/images/f_icon.png" alt="" /></a></li>
                        <li><a href="#"><img src="common/images/g_icon.png" alt="" /></a></li>
                        <li><a href="#"><img src="common/images/r_icon.png" alt="" /></a></li> 
                    </ul>
                    <span class="follow"></span>
                </div>
                <div class="footerLeft">
                    <h3><?php echo CATEGORY_TITLE;?></h3>
                    <div class="footerLink">
                        <div class="linkBlock">
                            <ul>
                                <li><a href="#"><?php echo MENS;?></a></li>
                                <li><a href="#"><?php echo WOMENS;?></a></li>
                                <li><a href="#"><?php echo BABY;?></a></li>                                
                            </ul>
                        </div>
                        <div class="linkBlock b2">
                            <ul>                                
                                <li><a href="#"><?php echo KID;?></a></li>
                                <li><a href="#"><?php echo TOYS;?></a></li>
                                <li><a href="#"><?php echo HOM_TRA;?></a></li>                                
                            </ul>
                        </div>
                        <div class="linkBlock b3">
                            <ul>                               
                                <li><a href="#"><?php echo HEALTH_FIT;?></a></li>
                                <li><a href="#"><?php echo LOREM;?></a></li>
                                <li><a href="#"><?php echo AUTO;?></a></li>
                            </ul>
                        </div>
                        <div class="linkBlock b4">
                            <ul>                               
                                <li><a href="#"><?php echo SPOR;?></a></li>
                                <li><a href="#"><?php echo ELEC;?></a></li>
                                <li class="moreLink"><a href="#"><?php echo MORE;?></a></li>
                            </ul>
                        </div>                        
                    </div>
                    <ul class="footLink">
                        <li class="first"><a href="#"><?php echo ABOUT_US;?></a></li>
                        <li><a href="#"><?php echo HELP_CEN;?></a></li>
                        <li><a href="#"><?php echo CONTACT_US;?></a></li>
                        <li><a href="#"><?php echo TC;?></a></li>
                        <li class="last"><a href="#"><?php echo PRI_POL;?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="subscribe">
            <div class="layout">
                <div class="newsletter">
                    <p><?php echo ALL_RESERVE;?></p>
                    <small class="nwLtr"><?php echo NEWSLETTER;?> <span><?php echo SUBSCRIPTION;?></span></small>
                    <form action="" method="get">
                        <input type="text" value="<?php echo ENTER_EMAIL;?>" onfocus="if(this.value=='<?php echo ENTER_EMAIL;?>')this.value=''" onblur="if(this.value=='')this.value='<?php echo ENTER_EMAIL;?>'"/>
                        <input type="submit" value="Subscribe"/>
                    </form>
                </div>
            </div>
        </div>


    </body>
</html> 