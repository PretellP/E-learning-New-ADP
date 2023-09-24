<?php

namespace App\Http\Controllers\Aula\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Course,
    File,
    Folder
};
use App\Services\FolderService;

class AulaFolderController extends Controller
{
    public function index(Course $course)
    {
        $folders = $course->folders()->where('level', 1)->get();

        return view('aula.common.courses.folders.index', [
            'course' => $course,
            'folders' => $folders
        ]);
    }

    public function show(FolderService $folderService, Course $course, Folder $folder)
    {
        $folder->loadMissing(['files', 'subfolders']);
        $parentFoldersCollection = $folderService->getParentFolders($folder->parent_folder_id, $folder->level);

        return view('aula.common.courses.folders.show', [
            'folder' => $folder,
            'parentFoldersCollection' => $parentFoldersCollection,
            'course' => $course,
        ]);
    }

    public function downloadFile(FolderService $folderService, File $file)
    {
        $storage = env('FILESYSTEM_DRIVER');

        return $folderService->downloadFile($file, $storage);
    }
}
