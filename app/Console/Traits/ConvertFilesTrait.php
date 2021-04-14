<?php


namespace App\Console\Traits;


trait ConvertFilesTrait
{
    public function convertFileTo($filePathFrom, $filePathTo, $convertTo): string
    {
        $fileClass = $this->fileClassFactory->getFileClassByPath($filePathFrom);
        $fileFormatter = $fileClass->formatterStartCondition();
        $convertedFileContent = $fileFormatter->getFormattedFileBlobTo($convertTo);
        $fileClass->storeFileContent($convertedFileContent, $filePathTo);
        return \Storage::disk('public')->url($filePathTo);

    }
}
