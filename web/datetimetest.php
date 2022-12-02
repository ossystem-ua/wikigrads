<?php
var_dump(timezone_identifiers_list());

ini_set('display_errors', 1);

$timeZone = 'America/Los_Angeles';  // +2 hours 
    $dateSrc = '2013-02-12 01:36:49'; 
    
    $dateTime = new DateTime($dateSrc, new DateTimeZone('UTC')); 
    $dateTime->setTimeZone(new DateTimeZone($timeZone)); 
    echo 'DateTime::format(): '.$dateTime->format('H:i:s A'); 



$format = 'm/d/y h:i A';
$dt_string = '2013-02-12 01:36:49';
$timezone = 'America/Los_Angeles';
echo date_default_timezone_get();
$date = new DateTime($dt_string, new DateTimeZone(date_default_timezone_get()));
echo $date->getTimestamp();
$newDate = clone $date;
            $newDate->setTimezone(new DateTimeZone($timezone));

            echo $newDate->format($format);


$date = new DateTime('2000-01-01', new DateTimeZone('Pacific/Nauru'));
echo $date->format('Y-m-d H:i:sP') . "\n";

$date->setTimezone(new DateTimeZone('Pacific/Chatham'));
echo $date->format('Y-m-d H:i:sP') . "\n";



$tz = new DateTimeZone('America/New_York');
$date = new DateTime('Thu, 31 Mar 2011 02:05:59 ', new DateTimeZone('America/Los_Angeles'));
echo $date->format('m/d/y h:i A')."\n";
$date->setTimezone($tz);
echo $date->format('m/d/y h:i A')."\n";
