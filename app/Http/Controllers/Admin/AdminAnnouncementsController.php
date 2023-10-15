<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publishing;
use App\Services\AnnouncementService;
use Exception;
use Illuminate\Http\Request;

class AdminAnnouncementsController extends Controller
{
    private $annoucementService;

    public function __construct(AnnouncementService $service)
    {
        $this->annoucementService = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->annoucementService->getPublishingsDataTable();
        }

        $banners = Publishing::where('type', 'BANNER')
            ->with('file')
            ->orderBy('publishing_order', 'ASC')
            ->get();

        return view('admin.announcements.index', compact(
            'banners'
        ));
    }

    // ------------ BANNER -------------

    public function storeBanner(Request $request)
    {
        $storage = env('FILESYSTEM_DRIVER');
        $html = null;

        try {
            $this->annoucementService->storeBanner($request, $storage);
            $success = true;
            $message = config('parameters.stored_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($success) {
            $banners = $this->annoucementService->getBanners();
            $html = view('admin.announcements.partials.boxes._banners_list', compact('banners'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html
        ]);
    }

    public function editBanner(Publishing $banner)
    {
        $banner->loadImage();

        $url = verifyImage($banner->file);
        $orders = $this->annoucementService->getBanners();

        return response()->json([
            "banner" => $banner,
            "orders" => $orders,
            "url_img" => $url
        ]);
    }

    public function updateBanner(Request $request, Publishing $banner)
    {
        $banner->loadImage();

        $storage = env('FILESYSTEM_DRIVER');
        $html = null;

        try {
            $success = $this->annoucementService->updateBanner($banner, $request, $storage);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($success) {
            $banners = $this->annoucementService->getBanners();
            $html = view('admin.announcements.partials.boxes._banners_list', compact('banners'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html
        ]);
    }

    public function destroyBanner(Publishing $banner)
    {
        $banner->loadImage();

        $storage = env('FILESYSTEM_DRIVER');
        $html = null;

        try {
            $success = $this->annoucementService->destroyBanner($banner, $storage);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($success) {
            $banners = $this->annoucementService->getBanners();

            $html = view('admin.announcements.partials.boxes._banners_list', compact('banners'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html
        ]);
    }


    // ------------- CARD--------------------

    public function storeCard(Request $request)
    {
        $storage = env('FILESYSTEM_DRIVER');

        try {
            $this->annoucementService->storeCard($request, $storage);
            $success = true;
            $message = config('parameters.stored_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
        ]);
    }

    public function editCard(Publishing $card)
    {
        $card->loadImage();
        $url_img = verifyImage($card->file);

        return response()->json([
            "card" => $card,
            "url_img" => $url_img
        ]);
    }

    public function updateCard(Request $request, Publishing $card)
    {
        $card->loadImage();

        $storage = env('FILESYSTEM_DRIVER');

        try {
            $success = $this->annoucementService->updateCard($card, $request, $storage);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
        ]);
    }

    public function destroyCard(Publishing $card)
    {
        $card->loadImage();

        $storage = env('FILESYSTEM_DRIVER');

        try {
            $success = $this->annoucementService->destroyCard($card, $storage);
            $message = config('parameters.deleted_message');
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
