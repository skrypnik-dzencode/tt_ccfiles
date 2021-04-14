<?php

namespace App\Http\Controllers\Api;

use App\FileClasses\FileFactory;
use App\FormatterClasses\FormatterFactory;
use App\Http\Controllers\Controller;

class BaseFileController extends Controller
{
    public array $errors;
    protected FormatterFactory $formatterFactory;
    protected FileFactory $fileFactory;

    public function __construct()
    {
        $this->formatterFactory = new FormatterFactory();
        $this->fileFactory = new FileFactory();
    }

    public function checkFileExists($filePath)
    {
        $fileExist = \Storage::disk('public')->exists($filePath);
        if (!$fileExist) {
            $this->errors = [
                'file' => [
                    "File $filePath not exists"
                ]
            ];
        }
        return $fileExist;
    }

    protected function getFileExtension($filepath)
    {
        return \File::extension($filepath);
    }
}
