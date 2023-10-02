<?php

namespace App\Services;

use App\Models\{Company};
use Yajra\DataTables\Facades\DataTables;

class CompanyService
{
    public function getDataTable()
    {
        $allCompanies = DataTables::of(Company::query()
                                    ->withCount('users'))
                                    ->addColumn('status-btn', function($company){
                                        $status = $company->active;
                                        $statusBtn = '<span class="status '.getStatusClass($status).'">'.
                                                        getStatusText($status)
                                                    .'</span>';

                                        return $statusBtn;
                                    })
                                    ->addColumn('action', function($company){
                                        $btn = '<button data-toggle="modal" data-id="'.
                                                $company->id.'" data-url="'.route('admin.companies.update', $company).'" 
                                                data-send="'.route('admin.companies.edit', $company).'"
                                                data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                                editCompany"><i class="fa-solid fa-pen-to-square"></i></button>';
                                        if($company->users_count == 0)
                                        {
                                            $btn.= '<a href="javascript:void(0)" data-id="'.
                                            $company->id.'" data-original-title="delete"
                                            data-url="'.route('admin.companies.delete', $company).'" class="ms-3 edit btn btn-danger btn-sm
                                            deleteCompany"><i class="fa-solid fa-trash-can"></i></a>';
                                        }

                                        return $btn;
                                    })
                                    ->rawColumns(['status-btn', 'action'])
                                    ->make(true);

        return $allCompanies;
    }
}