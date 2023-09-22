<?php

namespace App\Http\Controllers\Aula\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Course,
    File,
    Folder
};
use App\Services\FoldersService;

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

    public function show(FoldersService $foldersService, Course $course, Folder $folder)
    {
        $folder = $folder->loadMissing(['files', 'subfolders']);
        $parentFoldersCollection = $foldersService->getParentFolders($folder->parent_folder_id, $folder->level);

        return view('aula.common.courses.folders.show', [
            'folder' => $folder,
            'parentFoldersCollection' => $parentFoldersCollection,
            'course' => $course,
        ]);
    }

    public function downloadFile(FoldersService $foldersService, File $file)
    {
        $storage = env('FILESYSTEM_DRIVER');

        return $foldersService->downloadFile($file, $storage);
    }
}
