<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{MiningUnit};
use App\Services\MiningUnitService;

class AdminMiningUnitsController extends Controller
{
    private $miningUnitService;

    public function __construct(MiningUnitService $service)
    {
        $this->miningUnitService = $service;
    }

    public function index(Request $request)
    {   
        if($request->ajax()){
            return $this->miningUnitService->getDataTable();
        }else{
            return view('admin.miningUnits.index'); 
        }
    }

    public function store(Request $request)
    {
        MiningUnit::create($request->all());

        return response()->json([
            "success" => true
        ]);
    }

    public function getDataEdit(MiningUnit $miningUnit)
    {
        return response()->json($miningUnit);
    }   

    public function update(Request $request, MiningUnit $miningUnit)
    {
        $miningUnit->update($request->all());

        return response()->json([
            "success" => true
        ]);
    }

    public function destroy(MiningUnit $miningUnit)
    {
        $miningUnit->delete();

        return response()->json([
            "success" => true
        ]);
    }
}
