<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{DynamicAlternative, DynamicQuestion};
use App\Services\{dynamicAlternativeService};
use Exception;
use Illuminate\Http\Request;

class AdminDynamicAlternativeController extends Controller
{
    private $dynamicAlternativeService;

    public function __construct(dynamicAlternativeService $service)
    {
        $this->dynamicAlternativeService = $service;
    }

    public function destroy(DynamicAlternative $alternative)
    {
        $alternative->loadRelationships();

        $success = true;
        $message = null;

        $storage = env('FILESYSTEM_DRIVER');

        try {
            $this->dynamicAlternativeService->destroy($alternative, $storage);
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message
        ]);
    }

    public function destroyFile(DynamicAlternative $alternative)
    {
        $alternative->loadImage();

        $success = true;
        $message = null;

        $storage = env('FILESYSTEM_DRIVER');

        try{
            $this->dynamicAlternativeService->destroyFile($alternative->file, $storage);
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message
        ]);
    }
}
