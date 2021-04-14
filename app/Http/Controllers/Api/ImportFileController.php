<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\FileUploadRequest;
use App\Http\Requests\StoreFileRequest;
use Illuminate\Http\Request;

class ImportFileController extends BaseFileController
{

    public function uploadFile(FileUploadRequest $request): array
    {
        $file = $request->file('file');
        $path = $file->storeAs('public/files', $file->getClientOriginalName());
        return [
            'filename' => $file->getClientOriginalName(),
            'filepath' => $path,
        ];
    }

    public function getFileContent(Request $request)
    {
        $request->validate(['path' => 'required|string']);
        if (!$this->checkFileExists($request->path)){
            return response()->json(['errors' => $this->errors], 422);
        }
        $fileContent = \Storage::disk('public')->get($request->path);
        return [
            'fileContent' => $fileContent,
        ];
    }

    public function storeFileContent(StoreFileRequest $request)
    {
        if (!$this->checkFileExists($request->path)){
            return response()->json(['errors' => $this->errors], 422);
        }
        \Storage::disk('public')->put($request->path, $request->fileContent);
        return [
            'fileContent' => \Storage::disk('public')->get($request->path),
        ];
    }

    public function getFileList(): string
    {
        return collect(\Storage::disk('public')->files('files'))->map(
            function ($item) {
                return [
                    'filename' => basename($item),
                    'filepath' => $item,
                ];
            }
        )->toJson();
    }

}
