<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\{Folder, Document};

class DocumentController extends Controller
{
    public function index(Request $request, Folder $folder)
    {
        if($request->ajax())
        {
            $allFiles = DataTables::of(Document::query()
                                ->with('folder')
                                ->where('folder_id', $folder->id))
                                ->addColumn('filename', function($file){
                                    return '<a href="'.route('file.download', $file).'">'.
                                                $file->filename
                                            .'</a> ';
                                })
                                ->addColumn('parent_folder', function($file){
                                    return $file->folder->name;
                                })
                                ->addColumn('created_at', function($file){
                                            return $file->created_at;
                                })
                                ->addColumn('updated_at', function($file){
                                            return $file->updated_at;
                                })
                                ->addColumn('action', function($file){
                               
                                    $btn = '<a href="javascript:void(0)" data-id="'.
                                            $file->id.'" data-original-title="delete"
                                            data-url="'.route('file.destroy', $file).'" class="ms-3 edit btn btn-danger btn-sm
                                            deleteFile"><i class="fa-solid fa-trash-can"></i></a>';
                                      
                                    return $btn;
                                })
                                ->rawColumns(['filename','action'])
                                ->make(true);

            return $allFiles;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Folder $folder)
    {
        $file = $request->file('file');
        $uuid = $file->hashName();
        $name = $request->input('filename');
        $filename = $name.".".$file->extension();

        Document::create([
            'uuid' => $uuid,
            'name' => $name,
            'filename' => $filename,
            'size' => $file->getSize(),
            'folder_id' => $folder->id
        ]);

        Storage::putFileAs($folder->folder_path, $file, $uuid);

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

    public function download(Document $file)
    {
        $folder = $file->folder;
        $pathToFile = $folder->folder_path.$file->uuid;

        return Storage::download($pathToFile, $file->filename);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $file)
    {
        $folder=$file->folder;
        $pathToFile=$folder->folder_path.$file->uuid;

        $file->delete();
        Storage::delete($pathToFile);

        return response()->json([
            "success" => true
        ]);
    }
}
