<?php

namespace App\Http\Controllers\Aula\Common;

use App\Http\Controllers\Controller;
use App\Models\Publishing;

class AulaHomeController extends Controller
{
    public function index()
    {
        $bannerPublishings = Publishing::where('type', 'BANNER')
                            ->with('file')
                            ->where('status', 1)
                            ->select('id','publishing_order','type','title', 'content', 'status')
                            ->orderBy('publishing_order', 'ASC')
                            ->get();

        $cardPublishings = Publishing::where('type', 'CARD')
                            ->with(['user', 'file'])
                            ->where('status', 1)
                            ->select('id','user_id','type','title','content','publication_time', 'status')
                            ->orderBy('publication_time', 'DESC')
                            ->get();

        return view('aula.common.home.home', [
            'cardPublishings' => $cardPublishings,
            'bannerPublishings' => $bannerPublishings
        ]);
    }
}
