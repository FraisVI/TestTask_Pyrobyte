<?php

namespace SitemapGenerator;

use SitemapGenerator\Generators\SitemapGeneratorInterface;
use SitemapGenerator\Generators\XmlSitemapGenerator;
use SitemapGenerator\Generators\CsvSitemapGenerator;
use SitemapGenerator\Generators\JsonSitemapGenerator;
use SitemapGenerator\Exceptions\InvalidDataException;
use SitemapGenerator\Exceptions\DirectoryCreationException;
use SitemapGenerator\Exceptions\FileWriteException;

class SitemapGenerator
{
    private $pages;
    private $generator;
    private $filePath;

    public function __construct(array $pages, string $format, string $filePath)
    {
        $this->validateData($pages);

        $this->pages = $pages;
        $this->filePath = $filePath;
        $this->generator = $this->getGenerator($format);

        $this->createDirectoryIfNotExists(dirname($filePath));
    }

    private function validateData(array $pages)
    {
        foreach ($pages as $page) {
            if (!isset($page['loc'], $page['lastmod'], $page['priority'], $page['changefreq'])) {
                throw new InvalidDataException("Невалидные данные: каждый элемент массива должен содержать 'loc', 'lastmod', 'priority', 'changefreq'.");
            }
        }
    }

    private function getGenerator(string $format): SitemapGeneratorInterface
    {
        switch (strtolower($format)) {
            case 'xml':
                return new XmlSitemapGenerator();
            case 'csv':
                return new CsvSitemapGenerator();
            case 'json':
                return new JsonSitemapGenerator();
            default:
                throw new InvalidDataException("Неподдерживаемый формат: $format");
        }
    }

    private function createDirectoryIfNotExists(string $dir)
    {
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                throw new DirectoryCreationException("Не удалось создать директорию: $dir");
            }
        }
    }

    public function generate()
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
}
