<?php

if ((isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1', '83.142.106.128', '192.168.12.222')))
    && $_SERVER['REMOTE_ADDR']!="192.168.11.11"
) {
    header('HTTP/1.0 403 Forbidden');

    echo(@$_SERVER['HTTP_CLIENT_IP'])."<br/>";
    echo(@$_SERVER['HTTP_X_FORWARDED_FOR'])."<br/>";
    echo @$_SERVER['REMOTE_ADDR'];
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
include_once(dirname(__FILE__).'/FirePHP/fb.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
sfContext::createInstance($configuration)->dispatch();
