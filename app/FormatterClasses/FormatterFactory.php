<?php


namespace App\FormatterClasses;

use App\FileClasses\FileFactory;
use InvalidArgumentException;

class FormatterFactory
{
    public function getFormatterClass($extension): FormatterInterface
    {
        $extension = strtolower($extension);
        switch ($extension) {
            case 'xml':
                return new XmlFormatter();
            case 'csv':
                return new CsvFormatter();
            case 'json':
                return new JsonFormatter();
            case 'array':
                return new ArrayFormatter();
            default:
                throw new InvalidArgumentException(
                    'make function only accepts [csv, json, xml] for $extension but ' . $extension . ' was provided.'
                );
        }
    }

    public function getFormatterByFilePath(string $filePath): FormatterInterface
    {
        $fileClass = (new FileFactory())->getFileClassByPath($filePath);
        return $this->getFormatterClass($fileClass::$extension);
    }
}
