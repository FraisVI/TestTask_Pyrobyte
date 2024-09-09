<?php

namespace SitemapGenerator\Generators;

interface SitemapGeneratorInterface
{
    public function generate(array $pages): string;
}
