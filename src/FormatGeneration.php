<?php

namespace SitemapGenerator;

enum FormatGeneration: string
{
    case Xml  = 'xml';
    case Csv  = 'csv';
    case Json = 'json';
}
