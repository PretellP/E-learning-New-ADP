<?php

namespace App\Services;

use App\Models\{MiningUnit};
use Yajra\DataTables\Facades\DataTables;

class MiningUnitService
{
    public function getDataTable()
    {
        $allMiningUnits = DataTables::of(MiningUnit::withCount('users'))
            ->addColumn('action', function ($miningUnit) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $miningUnit->id . '" data-url="' . route('admin.mininUnits.update', $miningUnit) . '" 
                    data-send="' . route('admin.miningUnits.getDataEdit', $miningUnit) . '"
                    data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                    editMiningUnit"><i class="fa-solid fa-pen-to-square"></i></button>';
                if ($miningUnit->users_count == 0) {
                    $btn .= '<a href="javascript:void(0)" data-id="' .
                        $miningUnit->id . '" data-original-title="delete"
                        data-url="' . route('admin.miningUnits.delete', $miningUnit) . '" class="ms-3 edit btn btn-danger btn-sm
                        deleteMiningUnit"><i class="fa-solid fa-trash-can"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

        return $allMiningUnits;
    }
}
