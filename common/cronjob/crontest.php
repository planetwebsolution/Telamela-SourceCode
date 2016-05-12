<?php 
require_once '../config/config.inc.php';
mail("suraj.maurya@mail.vinove.com", "crontest:" . SITE_NAME, time());
?>
