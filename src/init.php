<?php

require_once realpath('../vendor/autoload.php');
use SitemapGenerator\SitemapGenerator;
use SitemapGenerator\FormatGeneration;

$file = fopen('Site.txt', 'r');
$i = 0;

$pages = array(); // правильно ли?
while (!feof($file)) {
    $str = fgets($file);
    $str = trim($str);
    $tempArray = explode(';', $str);
    $pages[$i] = ['loc' => $tempArray[0], 'lastmod' => $tempArray[1], 'priority' => $tempArray[2], 'changefreq' => $tempArray[3]];
    ++$i;
}

fclose($file);

try {
    $generator = new SitemapGenerator($pages, FormatGeneration::xml, 'result/sitemap.' . FormatGeneration::xml->value);
    $generator->generate();
    echo "Карта сайта успешно создан!";
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
