<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Rodenastyle\StreamParser\StreamParser;
use SoapBox\Formatter\Formatter;
use Tightenco\Collect\Support\Collection;
use InvalidArgumentException;

class FileContentController extends BaseFileController
{

    public function getFileItems(Request $request)
    {
        $request->validate(['path' => 'required|string']);
        $filePath = $request->path;
        if (!$this->checkFileExists($filePath)) {
            return response()->json(['errors' => $this->errors], 422);
        }
        $fileClass = $this->fileFactory->getFileClassByPath($filePath);
        return $fileClass->formatterStartCondition()->getArrayContent();
    }

    public function downloadFile(Request $request)
    {
        $extensionTo = $request->extension;
        $filePath = $request->filepath;
        if (!$this->checkFileExists($filePath)) {
            return response()->json(['errors' => $this->errors], 422);
        }
        $fileClass = $this->fileFactory->getFileClassByPath($filePath);
        $fileFormatter = $fileClass->formatterStartCondition();
        return $fileFormatter->getFormattedFileBlobTo($extensionTo);
    }

    /**
     * @throws \JsonException
     */
    public function removeFileItem(Request $request)
    {
        $filePath = $request->filepath;
        if (!$this->checkFileExists($filePath)) {
            return response()->json(['errors' => $this->errors], 422);
        }
        $itemToRemove = json_decode($request->item, true, 512, JSON_THROW_ON_ERROR);
        $fileClass = $this->fileFactory->getFileClassByPath($filePath);
        return $fileClass->removeItem($itemToRemove);

    }

    /**
     * @throws \JsonException
     */
    public function addFileItem(Request $request)
    {
        $filePath = $request->filepath;
        $newItem = json_decode($request->get('newItem', '[]'), true, 512, JSON_THROW_ON_ERROR);
        if (!$this->checkFileExists($filePath)) {
            return response()->json(['errors' => $this->errors], 422);
        }
        $fileClass = $this->fileFactory->getFileClassByPath($filePath);
        return $fileClass->addItem($newItem);
    }

    /**
     * @throws \JsonException
     */
    public function updateFileItem(Request $request)
    {
        $filePath = $request->filepath;
        $item = json_decode($request->item, true, 512, JSON_THROW_ON_ERROR);
        $index = $request->index;
        $fileClass = $this->fileFactory->getFileClassByPath($filePath);
        return $fileClass->updateItem($item, $index);
    }

}
