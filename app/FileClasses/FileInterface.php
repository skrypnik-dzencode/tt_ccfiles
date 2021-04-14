<?php


namespace App\FileClasses;

use App\FormatterClasses\FormatterInterface;

interface FileInterface
{
    public function getFileContent(): string;

    public function storeFileContent($newFormattedContent, ?string $newFilePath);

    public function refreshContent(): void;

    public function removeItem(array $itemToRemove);

    public function getCloneFileItem(): array;

    public function addItem(array $itemToAdd);

    public function updateItem(array $itemToUpdate, int $itemIndex);

    public function getFileFormatter();

    public static function getFileExtension(string $filePath): string;

    public function formatterStartCondition(): FormatterInterface;

}
