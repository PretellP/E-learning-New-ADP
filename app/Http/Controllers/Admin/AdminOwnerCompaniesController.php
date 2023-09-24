<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{OwnerCompany};
use App\Services\OwnerCompanyService;

class AdminOwnerCompaniesController extends Controller
{
    private $ownerCompanyService;

    public function __construct(OwnerCompanyService $service)
    {
        $this->ownerCompanyService = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ownerCompanyService->getDataTable();
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

        if ($company == null) {
            $valid = 'true';
        } elseif ($company->id == $id) {
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
