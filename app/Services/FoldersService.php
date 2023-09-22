<?php

namespace App\Services;

use App\Models\{File, Folder};
use Exception;
use Storage;
use Yajra\DataTables\Facades\DataTables;

class FoldersService
{

    public function store($request, int $course_id)
    {
        $folder = Folder::create($request + [
            "id_course" => $course_id,
            "level" => 1,
        ]);

        if ($folder) {
            $folder->update([
                "folder_path" => "folders/" . $folder->id,
            ]);

            Storage::makeDirectory('folders/' . $folder->id);

            return $folder;
        }

        throw new Exception('No es posible completar la solicitud');
    }

    public function getParentFolders(?int $folder_id, int $folder_level)
    {
        $parent_folder_collection = collect();
        $last_folder_id = $folder_id;

        for ($i = 1; $i < $folder_level; $i++) {
            $parent_folder = Folder::where('id', $last_folder_id)
                ->select('id', 'name', 'parent_folder_id')
                ->first();
            $parent_folder_collection = $parent_folder_collection->push($parent_folder);
            $last_folder_id = $parent_folder->parent_folder_id;
        }

        return $parent_folder_collection->reverse();
    }

    public function storeSubfolder($request, $course_id, $folder_id, $folder_level, $folder_path)
    {
        $subfolder = Folder::create($request + [
            'id_course' => $course_id,
            'parent_folder_id' => $folder_id,
            'level' => $folder_level + 1
        ]);

        if ($subfolder) {
            $subfolder->update(['folder_path' => $folder_path . '/' . $subfolder->id]);
            Storage::makeDirectory($subfolder->folder_path);

            return $subfolder;
        }
    }

    public function destroy($folder_path, int $folder_id)
    {
        $deleted_folders_ids = array($folder_id);
        $i = 0;

        while (array_key_exists($i, $deleted_folders_ids)) {
            $subFolders = Folder::where('parent_folder_id', $deleted_folders_ids[$i])->get();

            if (!$subFolders->isEmpty()) {
                foreach ($subFolders as $subFolder) {
                    array_push($deleted_folders_ids, $subFolder->id);
                }
            }
            $i++;
        }

        $isDeleted = Folder::whereIn('id', $deleted_folders_ids)->delete();

        if ($isDeleted) {
            Storage::deleteDirectory($folder_path);
        }

        return $isDeleted;
    }

    public function getFilesDataTables(Folder $folder)
    {
        $allFiles = DataTables::of($folder->files())
                    ->addColumn('filename', function ($file) {
                        return '<a href="'.route('admin.folders.file.download', $file).'">' .
                            basename($file->file_path)
                            . '</a> ';
                    })
                    ->editColumn('file_type', function ($file) {
                        return ucwords($file->file_type);
                    })
                    ->editColumn('category', function ($file) {
                        return ucwords($file->category);
                    })
                    ->addColumn('parent_folder', function ($file) use ($folder) {
                        return $folder->name;
                    })
                    ->editColumn('created_at', function ($file) {
                        return $file->created_at;
                    })
                    ->editColumn('updated_at', function ($file) {
                        return $file->updated_at;
                    })
                    ->addColumn('action', function ($file) {

                        $btn = '<a href="javascript:void(0)" data-id="' .
                            $file->id . '" data-original-title="delete"
                                        data-url="'.route('admin.folders.file.destroy', $file).'" class="ms-3 edit btn btn-danger btn-sm
                                        deleteFile"><i class="fa-solid fa-trash-can"></i></a>';

                        return $btn;
                    })
                    ->rawColumns(['filename', 'action'])
                    ->make(true);

        return $allFiles;
    }

    public function storeFile(Folder $folder, $file, $storage)
    {
        $file_type = 'archivos';
        $category = 'cursos';
        $belongsTo = 'folder';

        return app(FilesService::class)->store(
            $folder,
            $file_type,
            $category,
            $file,
            $storage,
            $belongsTo
        );
    }

    public function destroyFile(File $file, $storage)
    {
        return app(FilesService::class)->destroy($file, $storage);
    }

    public function downloadFile(File $file, $storage)
    {
        return app(FilesService::class)->download($file, $storage);
    }
}
