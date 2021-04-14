<?php


namespace App\FileClasses;

use InvalidArgumentException;

class FileFactory
{
    private function getFileClass($extension, $filePath): FileInterface
    {
        $extension = strtolower($extension);
        switch ($extension) {
            case 'xml':
                return new XmlFile($filePath);
            case 'csv':
                return new CsvFile($filePath);
            case 'json':
                return new JsonFile($filePath);
            default:
                throw new InvalidArgumentException(
                    'make function only accepts [csv, json, xml] for $extension but ' . $extension . ' was provided.'
                );
        }
    }

    public function getFileClassByPath($filePath): FileInterface
    {
        BaseFileClass::checkFileExists($filePath);
        $extension = BaseFileClass::getFileExtension($filePath);
        return $this->getFileClass($extension, $filePath);
    }
}
