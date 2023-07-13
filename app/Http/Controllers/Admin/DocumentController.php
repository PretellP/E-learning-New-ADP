<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\{Folder, Document};

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        return back();
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
        $folder = $file->folder()->get()->first();
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
        $folder=$file->folder()->get()->first();
        $pathToFile=$folder->folder_path.$file->uuid;

        $file->delete();
        Storage::delete($pathToFile);

        return back();
    }
}
