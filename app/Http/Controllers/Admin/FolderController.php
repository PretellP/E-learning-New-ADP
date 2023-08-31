<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\{Folder, Course, Document};

class FolderController extends Controller
{

    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Course $course)
    {
        $folderName = $request->input('foldername');

        $folder = Folder::create([
            'name' => $folderName,
            'id_course' => $course->id,
            'level' => 1
        ]);

        $folder->update(['folder_path' => 'folders/'.$folder->id.'/']);

        Storage::makeDirectory('folders/'.$folder->id);

        return back();
    }

    public function createSubfolder(Request $request, Folder $folder)
    {
        $subFolderName = $request->input('subfoldername');

        $subfolder = Folder::create([
            'name' => $subFolderName,
            'id_course' => $folder->id_course,
            'parent_folder_id' => $folder->id,
            'level' => $folder->level + 1
        ]);

        $subfolder->update(['folder_path' => $folder->folder_path.$subfolder->id.'/']);

        Storage::makeDirectory($subfolder->folder_path);

        return back()->with('flash_message', 'added');
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
        $folder = $folder->where('id', $folder->id)
                        ->with(['documents', 'subfolders'])
                        ->first();
        $parentFoldersCollection = collect();
        $lastFolderId = $folder->parent_folder_id;

        for($i=1; $i<$folder->level; $i++)
        {
            $parentFolder = Folder::where('id', $lastFolderId)->first();
            $parentFoldersCollection = $parentFoldersCollection->push($parentFolder);
            $lastFolderId = $parentFolder->parent_folder_id;
        }

        return view('admin.courses.folders.show', [
            'folder' => $folder,
            'parentFoldersCollection' => $parentFoldersCollection->reverse(),
            'course' => $course,
            'files' => $folder->documents,
            'subfolders' => $folder->subfolders
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
    public function update(Request $request, Folder $folder)
    {
        $folder->update([
            'name' => $request->input('foldername')
        ]);

        return back()->with('flash_message', 'updated');
    }

    public function destroy(Folder $folder)
    {
        $course = $folder->course;

        Storage::deleteDirectory($folder->folder_path);
        $parentFolder = $folder->parent_folder_id;
        $deleted_folders_ids = array($folder->id);
        $i = 0;

        while(true)
        {
            if(array_key_exists($i, $deleted_folders_ids))
            {
                $subFolders = Folder::where('parent_folder_id', $deleted_folders_ids[$i])->get();

                if(!$subFolders->isEmpty())
                {
                    foreach($subFolders as $subFolder)
                    {
                        array_push($deleted_folders_ids, $subFolder->id);
                    }
                }
                $i++;
            }
            else
            {
                break;
            }
        }  
        
        foreach($deleted_folders_ids as $deleted_folder_id)
        {
            Folder::findOrFail($deleted_folder_id)->delete();
        }

        if($folder->level != 1)
        {
            $parent = Folder::findOrFail($parentFolder);

            return redirect()->route('admin.courses.folder.view', [$course, $parent])->with('flash_message', 'deleted');
        }
        else{
            return redirect()->route('admin.courses.show', $course)->with('flash_message', 'deleted');
        }
    }
}
