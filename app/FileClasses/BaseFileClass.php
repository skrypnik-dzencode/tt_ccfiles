<?php


namespace App\FileClasses;

use App\FormatterClasses\FormatterFactory;
use App\FormatterClasses\FormatterInterface;
use InvalidArgumentException;

abstract class BaseFileClass
{
    protected string $filePath;
    protected FormatterInterface $formatter;
    protected string $fileBlobContent;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->fileBlobContent = $this->getFileContent();
        $this->formatter = $this->getFileFormatter();
    }

    public function refreshContent(): void
    {
        $this->fileBlobContent = $this->getFileContent();
    }

    public function removeItem(array $itemToRemove)
    {
        $arrItems = $this->formatterStartCondition()->getArrayContent();
        $fileCollectionContent = collect($arrItems);
        $itemsLeft = $fileCollectionContent->filter(
            function ($fItem) use ($itemToRemove) {
                return $itemToRemove !== $fItem;
            }
        )->values()->toArray();
        $arrayFormatter = app(FormatterFactory::class)->getFormatterClass('array');
        $arrayFormatter->setContent($itemsLeft);
        $itemsLeftFormatted = $arrayFormatter->getFormattedFileBlobTo(static::$extension);
        return $this->storeFileContent($itemsLeftFormatted);
    }

    public function addItem(array $itemToAdd = [])
    {
        if (empty($itemToAdd)) {
            $itemToAdd = $this->getCloneFileItem();
        }
        $arrItems = $this->formatterStartCondition()->getArrayContent();
        $arrItems[] = $itemToAdd;
        $arrayFormatter = app(FormatterFactory::class)->getFormatterClass('array');
        $arrayFormatter->setContent($arrItems);
        $newFormattedContent = $arrayFormatter->getFormattedFileBlobTo(static::$extension);
        return $this->storeFileContent($newFormattedContent);
    }

    public function updateItem(array $itemToUpdate, int $itemIndex)
    {
        $arrItems = $this->formatterStartCondition()->getArrayContent();
        if (isset($arrItems[$itemIndex])) {
            $arrItems[$itemIndex] = $itemToUpdate;
        }
        $arrayFormatter = app(FormatterFactory::class)->getFormatterClass('array');
        $arrayFormatter->setContent($arrItems);
        $newFormattedContent = $arrayFormatter->getFormattedFileBlobTo(static::$extension);
        return $this->storeFileContent($newFormattedContent);
    }

    abstract protected function getFileFormatter();

    public function getFileContent(): string
    {
        return \Storage::disk('public')->get($this->filePath);
    }

    public static function getFileExtension(string $filePath): string
    {
        return \File::extension($filePath);
    }

    public function storeFileContent($content, $filePath = null)
    {
        if (!$filePath){
            $filePath = $this->filePath;
        }
        return \Storage::disk('public')->put($filePath, $content);
    }

    public function formatterStartCondition(): FormatterInterface
    {
        $this->formatter->setContent($this->fileBlobContent);
        return $this->formatter;
    }

    public function getCloneFileItem(): array
    {
        $arrItems = $this->formatterStartCondition()->getArrayContent();
        return array_map(
            static function ($val) {
                return "new value";
            },
            head($arrItems)
        );
    }

    public static function checkFileExists($filePath): void
    {
        if (!\Storage::disk('public')->exists($filePath)) {
            throw new InvalidArgumentException(
                'File: ' . $filePath . ' is not exists.'
            );
        }
    }

}
