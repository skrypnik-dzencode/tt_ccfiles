<?php


namespace App\FormatterClasses;

use App\FileClasses\FileFactory;
use InvalidArgumentException;

abstract class BaseFormatter
{

    public const CSV = 'csv';
    public const JSON = 'json';
    public const XML = 'xml';
    /**
     * @var array | string
     */
    public $content;

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getArrayFormattedContent($filePath): array
    {
        $fileClass = (new FileFactory())->getFileClassByPath($filePath);
        $fileBlobContent = $fileClass->getFileContent();
        $fileExtension = $fileClass::$extension;
        $formatterClass = (new FormatterFactory())->getFormatterClass($fileExtension);
        $formatterClass->setContent($fileBlobContent);
        return $formatterClass->getArrayContent();
    }

    public function getFormattedFileBlobTo(string $format): string
    {
        switch (strtolower($format)) {
            case self::CSV:
                $blob = $this->toCsv();
                break;
            case self::JSON:
                $blob = $this->toJson();
                break;
            case self::XML:
                $blob = $this->toXml();
                break;
            default:
                throw new InvalidArgumentException(
                    'make function only accepts [csv, json, xml] for $format but ' . $format . ' was provided.'
                );
        }
        return $blob;
    }
}
