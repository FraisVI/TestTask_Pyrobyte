<?php

require_once realpath('../vendor/autoload.php');
use SitemapGenerator\FormatGeneration;
use SitemapGenerator\SitemapGenerator;

$file = fopen('Site.txt', 'rb');
$i = 0;

$pages = [];
while (! feof($file)) {
    $str = fgets($file);
    $str = trim($str);
    $tempArray = explode(';', $str);
    $pages[$i] = ['loc' => $tempArray[0], 'lastmod' => $tempArray[1], 'priority' => $tempArray[2], 'changefreq' => $tempArray[3]];
    ++$i;
}

fclose($file);

if (! empty($pages)) {
    try {
        $generator = new SitemapGenerator($pages, FormatGeneration::Json, 'result/sitemap.' . FormatGeneration::Json->value);
        $generator->generate();
        echo 'Карта сайта успешно создан!';
    } catch (Exception $e) {
        echo 'Ошибка: ' . $e->getMessage();
    }
}
