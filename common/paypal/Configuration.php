<?php

class Configuration {

    // For a full list of configuration parameters refer in wiki page (https://github.com/paypal/sdk-core-php/wiki/Configuring-the-SDK)
    public static function getConfig() {
        $config = array(
            // values: 'sandbox' for testing
            //		   'live' for production
            "mode" => "sandbox"

                // These values are defaulted in SDK. If you want to override default values, uncomment it and add your value.
                // "http.ConnectionTimeOut" => "5000",
                // "http.Retry" => "2",
        );
        return $config;
    }

    // Creates a configuration array containing credentials and other required configuration parameters.
    public static function getAcctAndConfig() {
        $config = array(
            // Signature Credential
            "acct1.UserName" => "piyush-facilitator_api1.planetwebsolution.com",
            "acct1.Password" => "5XHB6DRKYKXXR38F",
            "acct1.Signature" => "An5ns1Kso7MWUdW4ErQKJJJ4qi4-A5.aqE2te94Vz3H.dKlv4S5sugJO",
            "acct1.AppId" => "APP-80W284485P519543T"

                // Sample Certificate Credential
                // "acct1.UserName" => "certuser_biz_api1.paypal.com",
                // "acct1.Password" => "D6JNKKULHN3G5B8A",
                // Certificate path relative to config folder or absolute path in file system
                // "acct1.CertPath" => "cert_key.pem",
                // "acct1.AppId" => "APP-80W284485P519543T"
        );

        return array_merge($config, self::getConfig());
        ;
    }

}
