<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FilesService
{
    public function store($model, $file_type, $category,  $file, $storage, $belongsTo)
    {
        $directory = $this->makeDirectory($model, $file_type, $category, $belongsTo);
        $filename = $this->getFileName($directory, $file, $storage);

        $file_data = $this->storeInStorage($directory, $filename, $file, $storage);

        $stored_file = new File([
            "file_path" => $file_data[0],
            "file_url" => $file_data[1],
            "file_type" => $file_type,
            "category" => $category,
        ]);

        return $model->files()->save($stored_file);
    }

    public function destroy(File $file, $storage)
    {
        if($file){
            if(Storage::disk($storage)->exists($file->file_path)){
                Storage::disk($storage)->delete($file->file_path);
            }
            return $file->delete();
        }

        return false;
    }

    private function makeDirectory($model, $file_type, $category, $belongsTo)
    {
        $directory = $file_type . '/' . $category;
        if ($belongsTo == 'folder') {
            $directory .= '/' . $model->folder_path;
        }

        return $directory;
    }

    private function getFileName($directory, $file, $storage)
    {
        $filename = $file->getClientOriginalName();
        $name_array = explode('.',$filename);
        $origin_filename = $name_array[0];
        $extension = $name_array[1];

        $count = 1;
        while (Storage::disk($storage)->exists($directory . '/' . $filename)) {
            $filename = $origin_filename . ' (' . $count++ . ').' . $extension;
        }

        return $filename;
    }

    private function storeInStorage($directory, $filename, $file, $storage)
    {
        $file_path = Storage::disk($storage)->putFileAs($directory, $file, $filename);
        $file_url = Storage::disk($storage)->url($file_path);

        return array($file_path, $file_url);
    }

    public function download($file, $storage)
    {
        if(Storage::disk($storage)->exists($file->file_path)){
            return Storage::disk($storage)->download($file->file_path);
        }

        return false;
    }

}
