<?php

namespace SitemapGenerator\Generators;

class JsonSitemapGenerator implements SitemapGeneratorInterface
{
    public function generate(array $pages): string
    {
        return json_encode($pages, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE);
    }
}
