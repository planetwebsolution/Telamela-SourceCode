<?php require_once 'common/config/config.inc.php';
require_once CLASSES_PATH . 'class_contactus_bll.php';

$objContactUs = new ContactUs();
$objCore = new Core();

$arrRes  = $objContactUs->getEmailTempletList();

foreach($arrRes as $val){
    echo '<b>Subject:</b>   '.html_entity_decode(stripslashes($val['EmailTemplateSubject'])).'<br/><br/>';
    echo '<b>Email Content:</b> ';
    echo html_entity_decode(stripslashes($val['EmailTemplateDescription'])).'';
    echo '<hr/>';
}
?> 

