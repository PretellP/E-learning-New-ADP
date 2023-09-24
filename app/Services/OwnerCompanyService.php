<?php

namespace App\Services;

use App\Models\{OwnerCompany};
use Yajra\DataTables\Facades\DataTables;

class OwnerCompanyService
{
    public function getDataTable()
    {
        $allOwnerCompanies = DataTables::of(OwnerCompany::query()
            ->withCount('exams'))
            ->addColumn('created_at', function ($company) {
                return $company->created_at;
            })
            ->addColumn('action', function ($company) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $company->id . '" data-url="' . route('admin.ownerCompany.update', $company) . '" 
                    data-send="' . route('admin.ownerCompany.edit', $company) . '"
                    data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                    editCompany"><i class="fa-solid fa-pen-to-square"></i></button>';
                if ($company->exams_count == 0) {
                    $btn .= '<a href="javascript:void(0)" data-id="' .
                        $company->id . '" data-original-title="delete"
                        data-url="' . route('admin.ownerCompany.delete', $company) . '" class="ms-3 edit btn btn-danger btn-sm
                        deleteCompany"><i class="fa-solid fa-trash-can"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

        return $allOwnerCompanies;
    }
}
