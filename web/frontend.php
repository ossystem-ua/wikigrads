<?php
/*
ini_set("display_errors", "on");
error_reporting(E_ALL);
/**/
//$_SESSION["CURR_PAGE"] = $_SERVER['REQUEST_URI'];
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);
sfContext::createInstance($configuration)->dispatch();