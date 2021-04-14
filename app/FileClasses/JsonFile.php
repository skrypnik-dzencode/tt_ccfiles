<?php


namespace App\FileClasses;

use App\FormatterClasses\FormatterFactory;
use App\FormatterClasses\FormatterInterface;

class JsonFile extends BaseFileClass implements FileInterface
{
    public static string $extension = 'json';

    public function getFileFormatter(): FormatterInterface
    {
        return (new FormatterFactory())->getFormatterClass(self::$extension);
    }
}
