<?php


namespace App\FileClasses;

use App\FormatterClasses\FormatterFactory;
use App\FormatterClasses\FormatterInterface;

class XmlFile extends BaseFileClass implements FileInterface
{
    public static string $extension = 'xml';

    public function getFileFormatter(): FormatterInterface
    {
        return (new FormatterFactory())->getFormatterClass(self::$extension);
    }
}
