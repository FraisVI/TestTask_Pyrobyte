<?php

namespace SitemapGenerator\Generators;

class CsvSitemapGenerator implements SitemapGeneratorInterface
{
    public function generate(array $pages): string
    {
        $output = fopen('php://memory', 'r+b');
        fputcsv($output, ['loc', 'lastmod', 'priority', 'changefreq'], ';');

        foreach ($pages as $page) {
            fputcsv($output, $page, ';');
        }

        rewind($output);

        return stream_get_contents($output);
    }
}
