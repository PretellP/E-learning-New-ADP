<?php

namespace App\Services;

use App\Models\{Publishing};
use Exception;
use Auth;
use Carbon\Carbon;
use Datatables;

class AnnouncementService
{
    public function storeBanner($request, $storage)
    {
        $data = $request->all();

        $data['status'] = isset($data['status']) ? 1 : 0;

        if ($data['content'] != '') {

            $target = isset($data['blank_indicator']) ? '_BLANK' : '_SELF';
            $data['content'] = '<a href="' . $data['content'] . '"  target="' . $target . '">' . $data['content'] . '</a>';
        }

        $lastOrder = Publishing::where('type', 'BANNER')->max('publishing_order');
        $publishing_order = $lastOrder == null ? 0 : $lastOrder;

        $banner = Publishing::create($data + [
            'type' => 'BANNER',
            'publishing_order' => $publishing_order + 1,
            'publication_time' => Carbon::now('America/Lima'),
            'user_id' => Auth::user()->id,
        ]);

        if ($banner && $request->hasFile('image')) {

            $file_type = 'imagenes';
            $category = 'publicaciones';
            $file = $request->file('image');
            $belongsTo = 'publicaciones';
            $relation = 'one_one';

            return app(FileService::class)->store(
                $banner,
                $file_type,
                $category,
                $file,
                $storage,
                $belongsTo,
                $relation
            );
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function updateBanner(Publishing $banner, $request, $storage)
    {
        $data = $request->all();
        $data['status'] = isset($data['status']) ? 1 : 0;

        if ($data['content'] != '') {
            $target = isset($data['blank_indicator']) ? '_BLANK' : '_SELF';
            $data['content'] = '<a href="' . $data['content'] . '"  target="' . $target . '">' . $data['content'] . '</a>';
        }

        $bannerChanged = Publishing::where('type', 'BANNER')
            ->where('publishing_order', $data['publishing_order'])
            ->update([
                "publishing_order" => $banner->publishing_order
            ]);

        if ($bannerChanged) {

            $banner->update($data);

            if ($request->hasFile('image')) {

                app(FileService::class)->destroy($banner->file, $storage);

                $file_type = 'imagenes';
                $category = 'publicaciones';
                $file = $request->file('image');
                $belongsTo = 'publicaciones';
                $relation = 'one_one';

                app(FileService::class)->store(
                    $banner,
                    $file_type,
                    $category,
                    $file,
                    $storage,
                    $belongsTo,
                    $relation
                );
            }

            return true;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function destroyBanner(Publishing $banner, $storage)
    {
        if (app(FileService::class)->destroy($banner->file, $storage)) {

            if ($banner->delete()) {
                $banners = $this->getBanners();
                $order = 1;
                foreach ($banners as $banner) {
                    $banner->update([
                        "publishing_order" => $order
                    ]);
                    $order++;
                }

                return true;
            }
        };

        throw new Exception(config('parameters.exception_message'));
    }

    public function getBanners()
    {
        return Publishing::where('type', 'BANNER')
            ->with('file')
            ->orderBy('publishing_order', 'ASC')
            ->get();
    }

    // ------------ CARD ---------------

    public function getPublishingsDataTable()
    {
        $query = Publishing::where('type', 'CARD')->with('user');

        $allPublications = Datatables::of($query)
            ->editColumn('publication_time', function ($card) {
                return $card->publication_time ?? '-';
            })
            ->editColumn('user.name', function ($card) {
                return $card->user->full_name_complete;
            })
            ->editColumn('status', function ($card) {
                $status = $card->status;
                return '<span class="status ' . getStatusClass($status) . '">' .
                    getStatusText($status) .
                    '</span>';
            })
            ->editColumn('created_at', function ($card) {
                return $card->created_at;
            })
            ->editColumn('updated_at', function ($card) {
                return $card->updated_at;
            })
            ->addColumn('action', function ($card) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $card->id . '" data-url="' . route('admin.announcements.card.update', $card) . '" 
                                data-send="' . route('admin.announcements.card.edit', $card) . '"
                                data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                editCard"><i class="fa-solid fa-pen-to-square"></i></button>';

                $btn .= '<a href="javascript:void(0)" data-id="' .
                    $card->id . '" data-original-title="delete"
                                        data-url="' . route('admin.announcements.card.delete', $card) . '" class="ms-3 edit btn btn-danger btn-sm
                                        deleteCard"><i class="fa-solid fa-trash-can"></i></a>';

                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);

        return $allPublications;
    }

    public function storeCard($request, $storage)
    {
        $data = $request->all();

        if (isset($data['status'])) {
            $data['status'] = 1;
            $data['publication_time'] = Carbon::now('America/Lima');
        } else {
            $data['status'] = 0;
        }

        $card = Publishing::create($data + [
            "type" => "CARD",
            "user_id" => Auth::user()->id
        ]);

        if ($card && $request->hasFile('image')) {

            $file_type = 'imagenes';
            $category = 'publicaciones';
            $file = $request->file('image');
            $belongsTo = 'publicaciones';
            $relation = 'one_one';

            return app(FileService::class)->store(
                $card,
                $file_type,
                $category,
                $file,
                $storage,
                $belongsTo,
                $relation
            );
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function updateCard(Publishing $card, $request, $storage)
    {
        $data = $request->all();

        if (isset($data['status'])) {
            $data['status'] = 1;
            if ($card->status == 0) {
                $data['publication_time'] = Carbon::now('America/Lima');
            }
        } else {
            $data['status'] = 0;
            $data['publication_time'] = null;
        }

        $isUpdated = $card->update($data);

        if ($isUpdated) {

            if ($request->hasFile('image')) {
                
                if(app(FileService::class)->destroy($card->file, $storage)){

                    $file_type = 'imagenes';
                    $category = 'publicaciones';
                    $file = $request->file('image');
                    $belongsTo = 'publicaciones';
                    $relation = 'one_one';
    
                    return app(FileService::class)->store(
                            $card,
                            $file_type,
                            $category,
                            $file,
                            $storage,
                            $belongsTo,
                            $relation
                        );
                }
            }

            return true;
        }

        throw new Exception(config('parameters.exception_message'));
    }


    public function destroyCard(Publishing $card, $storage)
    {
        if (app(FileService::class)->destroy($card->file, $storage)) {
            return $card->delete();
        }

        throw new Exception(config('parameters.exception_message'));
    }
}
