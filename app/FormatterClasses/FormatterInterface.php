<?php


namespace App\FormatterClasses;

interface FormatterInterface
{
    public function getArrayContent(): array;

    public function toJson(): string;

    public function toXml(): string;

    public function toCsv(): string;

    public function setContent(string $fileBlobContent);

    public function getArrayFormattedContent($filePath): array;

    public function getFormattedFileBlobTo(string $format): string;
}
