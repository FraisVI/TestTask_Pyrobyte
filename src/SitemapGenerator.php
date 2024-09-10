<?php

namespace SitemapGenerator;

use SitemapGenerator\Generators\SitemapGeneratorInterface; //зачем?
use SitemapGenerator\Generators\XmlSitemapGenerator;
use SitemapGenerator\Generators\CsvSitemapGenerator;
use SitemapGenerator\Generators\JsonSitemapGenerator;
use SitemapGenerator\Exceptions\InvalidDataException;
use SitemapGenerator\Exceptions\DirectoryCreationException;
use SitemapGenerator\Exceptions\FileWriteException;

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

    /**
     * @throws InvalidDataException
     */
    private function getGenerator(FormatGeneration $format): SitemapGeneratorInterface
    {
        return match ($format) {
            FormatGeneration::xml => new XmlSitemapGenerator(),
            FormatGeneration::csv => new CsvSitemapGenerator(),
            FormatGeneration::json => new JsonSitemapGenerator(),
            default => throw new InvalidDataException("Неподдерживаемый формат: "),
        };
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
