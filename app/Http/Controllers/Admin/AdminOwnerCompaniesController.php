<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Auth;
use App\Models\{User, OwnerCompany};

class AdminOwnerCompaniesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $allOwnerCompanies = DataTables::of(OwnerCompany::query()
                                                ->withCount('exams'))
                                ->addColumn('created_at', function($company){
                                    return $company->created_at;
                                })
                                ->addColumn('action', function($company){
                                    $btn = '<button data-toggle="modal" data-id="'.
                                    $company->id.'" data-url="'.route('admin.ownerCompany.update', $company).'" 
                                    data-send="'.route('admin.ownerCompany.edit', $company).'"
                                    data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                    editCompany"><i class="fa-solid fa-pen-to-square"></i></button>';
                                    if($company->exams_count == 0)
                                    {
                                        $btn.= '<a href="javascript:void(0)" data-id="'.
                                                $company->id.'" data-original-title="delete"
                                                data-url="'.route('admin.ownerCompany.delete', $company).'" class="ms-3 edit btn btn-danger btn-sm
                                                deleteCompany"><i class="fa-solid fa-trash-can"></i></a>';
                                    }
                                
                                    return $btn;
                                })
                                ->rawColumns(['action'])
                                ->make(true);

            return $allOwnerCompanies;
        }

        return view('admin.ownerCompanies.index');
    }


    public function registerValidate(Request $request)
    {
        $valid = OwnerCompany::where('name', $request['name'])->first() == null ? "true" : "false";

        return $valid;
    }


    public function store(Request $request)
    {
        OwnerCompany::create($request->all());

        return response()->json([
            "success" => "store successfully"
        ]);
    }

    public function edit(OwnerCompany $company)
    {
        return response()->json($company);
    }

    public function editValidate(Request $request)
    {
        $valid = 'false';
        $id = $request['id'];
        $company = OwnerCompany::where('name', $request['name'])->first();

        if($company == null){
            $valid = 'true';
        }
        elseif($company->id == $id){
            $valid = 'true';
        }

        return $valid;
    }

    public function update(Request $request, OwnerCompany $company)
    {
        $company->update($request->all());

        return response()->json([
            "success" => "updated successfully"
        ]);
    }

    public function destroy(OwnerCompany $company)
    {   
        $company->delete();

        return response()->json([
            "success" => true
        ]);
    }
}
