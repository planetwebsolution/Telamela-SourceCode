<?php

session_start();
require 'components/facebook/config.php';
require 'components/facebook/lib/facebook/facebook.php';
$facebook = new Facebook(array(
            'appId' => $appID,
            'secret' => $appSecret,
        ));
$user_status=false;
$user = $facebook->getUser();
if ($user) {
    $permissions = $facebook->api("/me/permissions");
    if (array_key_exists('publish_stream', $permissions['data'][0])) {
        $user_status=true;
    } else {
       $user_status=false;
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($user) {
        $access_token = $facebook->getAccessToken();
        $message = urldecode($_POST['post_content']);
        echo $status = $facebook->api('/me/feed', 'post', array('message' => $message, 'link' => LINK, 'name' => '', 'caption' => FACEBOOK_CAPTION, 'picture' => LOGO,
    'description' => FACEBOOK_DESCRIPTION, 'title' => '', 'cb' => '', 'access_token' => $access_token));
        $_SESSION['post_data_pending'] = '';
        return;
    }
}