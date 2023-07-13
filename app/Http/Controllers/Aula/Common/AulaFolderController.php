<?php

namespace App\Http\Controllers\Aula\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Course,
    Folder
};

class AulaFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course)
    {
        $folders = $course->folders()->where('level', 1)->get();

        return view('aula.common.courses.folders.index', [
            'course' => $course,
            'folders' => $folders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, Folder $folder)
    {
        $files = $folder->documents()->get();
        $subFolders = Folder::where('parent_folder_id', $folder->id)->get();
        $parentFoldersCollection = collect();
        $lastFolderId = $folder->parent_folder_id;

        for($i=1; $i<$folder->level; $i++)
        {
            $parentFolder = Folder::where('id', $lastFolderId)->first();
            $parentFoldersCollection = $parentFoldersCollection->push($parentFolder);
            $lastFolderId = $parentFolder->parent_folder_id;
        }

        return view('aula.common.courses.folders.show', [
            'folder' => $folder,
            'parentFoldersCollection' => $parentFoldersCollection->reverse(),
            'course' => $course,
            'files' => $files,
            'subFolders' => $subFolders
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
