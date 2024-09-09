<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Storage;


class FileManager
{
    public function store($file, $model)
    {
        $path = $file->store('files');
        $fileModel = new File([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'path' => $path
        ]);
        $model->files()->save($fileModel);
    }

    public function delete(File $file)
    {
        Storage::delete($file->path);
        $file->delete();
    }
}
