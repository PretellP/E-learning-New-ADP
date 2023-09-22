<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Company};
use Yajra\DataTables\DataTables;

class AdminCompaniesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $allCompanies = DataTables::of(Company::query()
                                            ->withCount('users'))
                ->addColumn('status-btn', function($company){
                    $status = $company->active == 'S' ? 'active' : 'inactive';
                    $txtBtn = $status == 'active' ? 'Activo' : 'Inactivo';
                    $statusBtn = '<span class="status '.$status.'">'.$txtBtn.'</span>';

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
        return view('admin.companies.index');
    }

    public function store(Request $request)
    {
        if($request['type'] == 'validate')
        {
            $valid = Company::where('ruc', $request['ruc'])->first() == null ? "true" : "false";

            return $valid;
        }
        elseif($request['type'] == 'store')
        {
            parse_str($request['data'], $data);

            $status = 'N';

            if(array_key_exists('companyStatusCheckbox', $data))
            {
                $status = $data['companyStatusCheckbox'] == 'on' ? 'S' : 'N';
            }

            Company::create([
                "description" => $data['name'],
                "abbreviation" => $data['abreviation'],
                "ruc" => $data['ruc'],
                "address" => $data['address'],
                "telephone" => $data['phone'],
                "name_ref" => $data['referName'],
                "telephone_ref" => $data['referPhone'],
                "email_ref" => $data['referEmail'],
                "active" => $status
            ]);
    
            return response()->json([
                "success" => "store successfully"
            ]);
        }   
    }

    public function edit(Company $company)
    {
        return response()->json($company);
    }

    public function EditvalidateRuc(Request $request)
    {
        $valid = 'false';
        $id = $request['id'];
        $company = Company::where('ruc', $request['ruc'])->first();

        if($company == null)
        {
            $valid = 'true';
        }
        elseif($company->id == $id){
            $valid = 'true';
        }

        return $valid;
    }

    public function update(Request $request, Company $company)
    {
        $status = $request['companyStatusCheckbox'] == 'on' ? 'S' : 'N';

        $company->update([
            "description" => $request['name'],
            "abbreviation" => $request['abreviation'],
            "ruc" => $request['ruc'],
            "address" => $request['address'],
            "telephone" => $request['phone'],
            "name_ref" => $request['referName'],
            "telephone_ref" => $request['referPhone'],
            "email_ref" => $request['referEmail'],
            "active" => $status
        ]);

        return response()->json([
            "success" => "updated successfully"
        ]);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            "success" => true
        ]);
    }
}
