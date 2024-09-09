<?php

require_once realpath('../vendor/autoload.php');
use SitemapGenerator\SitemapGenerator;


$file = fopen('Site.txt', 'r');
$i = 0;

while (!feof($file)) {
    $str = fgets($file);
    $str = trim($str);
    $tempArray = explode(';', $str);
    $pages[$i] = ['loc' => $tempArray[0], 'lastmod' => $tempArray[1], 'priority' => $tempArray[2], 'changefreq' => $tempArray[3]];
    ++$i;
}

try {
    $generator = new SitemapGenerator($pages, 'xml', 'result/sitemap.xml');
    $generator->generate();
    echo "Sitemap успешно создан!";
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
