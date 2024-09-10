<?php

namespace SitemapGenerator;

use SitemapGenerator\Exceptions\FileWriteException;
use SitemapGenerator\Generators\CsvSitemapGenerator;
use SitemapGenerator\Generators\XmlSitemapGenerator;
use SitemapGenerator\Exceptions\InvalidDataException;
use SitemapGenerator\Generators\JsonSitemapGenerator;
use SitemapGenerator\Generators\SitemapGeneratorInterface;
use SitemapGenerator\Exceptions\DirectoryCreationException;

class SitemapGenerator
{
    private array $pages;

    private SitemapGeneratorInterface $generator;

    private string $filePath;

    public function __construct(array $pages, FormatGeneration $format, string $filePath)
    {
        $this->validateData($pages);

        $this->pages = $pages;
        $this->filePath = $filePath;
        $this->generator = $this->getGenerator($format);

        $this->createDirectoryIfNotExists(\dirname($filePath));
    }

    public function generate(): void
    {
        try {
            $content = $this->generator->generate($this->pages);
            if (file_put_contents($this->filePath, $content) === false) {
                throw new FileWriteException("Не удалось записать файл: {$this->filePath}");
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function validateData(array $pages): void
    {
        foreach ($pages as $page) {
            if (!isset($page['loc'], $page['lastmod'], $page['priority'], $page['changefreq'])) {
                throw new InvalidDataException("Невалидные данные: каждый элемент массива должен содержать 'loc', 'lastmod', 'priority', 'changefreq'.");
            }
        }
    }

    private function getGenerator(FormatGeneration $format): SitemapGeneratorInterface
    {
        return match ($format) {
            FormatGeneration::Xml  => new XmlSitemapGenerator(),
            FormatGeneration::Csv  => new CsvSitemapGenerator(),
            FormatGeneration::Json => new JsonSitemapGenerator(),
        };
    }

    private function createDirectoryIfNotExists(string $dir): void
    {
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                throw new DirectoryCreationException("Не удалось создать директорию: {$dir}");
            }
        }
    }
}
