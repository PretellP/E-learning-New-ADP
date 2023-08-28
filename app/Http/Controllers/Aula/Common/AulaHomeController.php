<?php

namespace App\Http\Controllers\Aula\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Publishing;

class AulaHomeController extends Controller
{
    public function index()
    {
        $bannerPublishings = Publishing::where('type', 'BANNER')
                            ->orderBy('publishing_order', 'ASC')
                            ->select('id','publishing_order','url_img','type','title')
                            ->get();

        $cardPublishings = Publishing::where('type', 'CARD')
                            ->with('user:id,name')
                            ->select('id','user_id','type','title','content','url_img','publication_time')
                            ->orderBy('publication_time', 'DESC')->get();

        return view('aula.common.home.home', [
            'cardPublishings' => $cardPublishings,
            'bannerPublishings' => $bannerPublishings
        ]);
    }
}
