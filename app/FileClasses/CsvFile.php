<?php


namespace App\FileClasses;

use App\FormatterClasses\FormatterFactory;
use App\FormatterClasses\FormatterInterface;

class CsvFile extends BaseFileClass implements FileInterface
{
    public static string $extension = 'csv';

    public function getFileFormatter(): FormatterInterface
    {
        return (new FormatterFactory())->getFormatterClass(self::$extension);
    }
}
