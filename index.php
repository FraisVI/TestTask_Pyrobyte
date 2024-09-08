<?php

require_once 'classes/Site.php';
use Classes\Site;

$file = fopen('Site.txt', 'r');
$tempArray = [];
$siteArray = [];
$i = 0;

//var_dump($siteArray);

while (!feof($file)) {
    $str = fgets($file);
    $str = trim($str);
    $tempArray = explode(';', $str);
    $siteArray[$i] = new Site($tempArray[0], $tempArray[1], $tempArray[2], $tempArray[3]);
    ++$i;
}
foreach ($siteArray as $item) {
    print_r($item);
    echo '<p>';
}
