<?php

namespace SitemapGenerator\Generators;

class XmlSitemapGenerator implements SitemapGeneratorInterface
{
    public function generate(array $pages): string
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $dom->appendChild($urlset);

        foreach ($pages as $page) {
            $url = $dom->createElement('url');

            $loc = $dom->createElement('loc', htmlspecialchars($page['loc']));
            $url->appendChild($loc);

            $lastmod = $dom->createElement('lastmod', htmlspecialchars($page['lastmod']));
            $url->appendChild($lastmod);

            $priority = $dom->createElement('priority', htmlspecialchars($page['priority']));
            $url->appendChild($priority);

            $changefreq = $dom->createElement('changefreq', htmlspecialchars($page['changefreq']));
            $url->appendChild($changefreq);

            $urlset->appendChild($url);
        }

        return $dom->saveXML();
    }
}
