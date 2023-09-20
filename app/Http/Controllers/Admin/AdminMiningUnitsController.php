<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use App\Models\{MiningUnit};

class AdminMiningUnitsController extends Controller
{
    public function index(Request $request)
    {   
        if($request->ajax()){
            $allMiningUnits = DataTables::of(MiningUnit::withCount('users'))
                                ->addColumn('action', function($miningUnit){
                                    $btn = '<button data-toggle="modal" data-id="'.
                                            $miningUnit->id.'" data-url="'.route('admin.mininUnits.update', $miningUnit).'" 
                                            data-send="'.route('admin.miningUnits.getDataEdit', $miningUnit).'"
                                            data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                            editMiningUnit"><i class="fa-solid fa-pen-to-square"></i></button>';
                                    if($miningUnit->users_count == 0)
                                    {
                                        $btn.= '<a href="javascript:void(0)" data-id="'.
                                                $miningUnit->id.'" data-original-title="delete"
                                                data-url="'.route('admin.miningUnits.delete', $miningUnit).'" class="ms-3 edit btn btn-danger btn-sm
                                                deleteMiningUnit"><i class="fa-solid fa-trash-can"></i></a>';
                                    }
                                
                                    return $btn;
                                })
                                ->rawColumns(['action'])
                                ->make(true);

            return $allMiningUnits;
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
