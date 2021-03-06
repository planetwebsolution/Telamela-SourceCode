<?php

/* !
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return
        array(
            "base_url" => SITE_ROOT_URL . 'components/hybridauth-2.1.2/hybridauth/',
           // "base_url" => $base_url,
            "providers" => array(
                // openid providers
                "OpenID" => array(
                    "enabled" => true
                ),
                "Yahoo" => array(
                    "enabled" => true,
                    "keys" => array("id" => "", "secret" => ""),
                ),
                "AOL" => array(
                    "enabled" => true
                ),
                "Google" => array(
                    "enabled" => true,
                    "keys" => array("id" => "16702074672.apps.googleusercontent.com", "secret" => "1v1VLj2v3lCr0PDi6ZdjO1HP"),
                    "scope" => "https://www.googleapis.com/auth/userinfo.profile " . "https://www.googleapis.com/auth/userinfo.email",
                    "access_type" => "online",
                ),
                "Facebook" => array(
                    "enabled" => true,
                    "keys" => array("id" => "647192451965551", "secret" => "9e5955acab4c7820ffce621f219b1f15"),
                    //"keys" => array("id" => "330248803764100", "secret" => "737bf5482fdbe42d3ab9b2cc77afbfde"),
                ),
                "Twitter" => array(
                    "enabled" => true,
                    "keys" => array("key" => "z661aDxuplp46tBRFUachA", "secret" => "T6vKbVMontxoXXFVRSlccyKRjJTSjstkEJlp7fj4")
                ),
                // windows live
                "Live" => array(
                    "enabled" => true,
                    "keys" => array("id" => "", "secret" => "")
                ),
                "MySpace" => array(
                    "enabled" => true,
                    "keys" => array("key" => "", "secret" => "")
                ),
                "LinkedIn" => array(
                    "enabled" => true,
                    //"keys" => array("key" => "75hfql2ge2indn", "secret" => "ilcwU2ovghFnJwXB")
                    "keys" => array("key" => "75we80l8rkny80", "secret" => "ehxeevuUd5FgmVYY")
                ),
                "Foursquare" => array(
                    "enabled" => true,
                    "keys" => array("id" => "", "secret" => "")
                ),
            ),
            // if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
            "debug_mode" => false,
            "debug_file" => "",
);
