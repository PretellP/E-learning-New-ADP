<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{File};
use Illuminate\Http\Request;

use App\Services\FilesService;

class FileController extends Controller
{
    private $filesService;

    public function __construct(FilesService $service)
    {
        $this->filesService = $service;
    }

    public function store(Request $request)
    {
        
    }


    public function show(File $file)
    {
        
    }


    public function update(Request $request, File $file)
    {
        //
    }


    public function destroy()
    {
        
    }
}
