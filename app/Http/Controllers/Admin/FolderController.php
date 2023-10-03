<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\{FileRequest, FolderRequest};
use App\Services\{FolderService};
use Exception;

use App\Models\{Folder, Course, File};

class FolderController extends Controller
{
    private $folderService;

    public function __construct(FolderService $service)
    {
        $this->folderService = $service;
    }

    public function store(FolderRequest $request, Course $course)
    {
        $storage = env('FILESYSTEM_DRIVER');
        try {
            $this->folderService->store($request->validated(), $course->id, $storage);
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }

        return redirect()->route('admin.courses.show', $course);
    }

    public function show(Folder $folder)
    {
        $folder->loadMissing(['subfolders', 'course']);
        $course = $folder->course;

        $parent_folder_collection = $this->folderService->getParentFolders($folder->parent_folder_id, $folder->level);

        return view('admin.courses.folders.show', compact(
            'folder',
            'parent_folder_collection',
            'course',
        ));
    }

    public function update(FolderRequest $request, Folder $folder)
    {
        $folder->update($request->validated());

        return redirect()->route('admin.courses.folder.view', $folder)
            ->with('flash_message', 'updated');
    }

    public function storeSubfolder(FolderRequest $request, Folder $folder)
    {
        $storage = env('FILESYSTEM_DRIVER');

        $this->folderService->storeSubfolder(
            $request->validated(),
            $folder->id_course,
            $folder->id,
            $folder->level,
            $folder->folder_path,
            $storage
        );

        return redirect()->route('admin.courses.folder.view', $folder)
            ->with('flash_message', 'updated');
    }

    public function destroy(Folder $folder)
    {
        $folder->loadFiles();
        
        $storage = env('FILESYSTEM_DRIVER');

        $isDeleted = $this->folderService->destroy(
            $folder->folder_path,
            $folder,
            $storage
        );

        if ($folder->level != 1) {
            $parent = Folder::findOrFail($folder->parent_folder_id);
            return redirect()->route('admin.courses.folder.view', $parent)->with('flash_message', 'deleted');
        }

        $course = $folder->course;
        return redirect()->route('admin.courses.show', $course)->with('flash_message', 'deleted');
    }

    public function showFiles(Folder $folder)
    {
        return $this->folderService->getFilesDataTables($folder);
    }

    public function storeFile(FileRequest $request, Folder $folder)
    {
        $storage = env('FILESYSTEM_DRIVER');
        $stored = $this->folderService->storeFile($folder, $request->file('file'), $storage);

        if ($stored) {
            return redirect()->route('admin.courses.folder.view', $folder)->with('flash_message', 'added');
        } else {
            abort(500, 'No es posible completar la solicitud');
        }
    }

    public function destroyFile(File $file)
    {
        $storage = env('FILESYSTEM_DRIVER');

        $this->folderService->destroyFile($file, $storage);

        return response()->json([
            "success" => true
        ]);
    }

    public function downloadFile(File $file)
    {
        $storage = env('FILESYSTEM_DRIVER');

        return $this->folderService->downloadFile($file, $storage);
    }
}
