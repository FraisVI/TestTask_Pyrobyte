<?php

namespace SitemapGenerator;

enum FormatGeneration:string
{
    case xml = 'xml';
    case csv = 'csv';
    case json = 'json';

    private function getType(): string
    {
        return $this->value;
    }
}