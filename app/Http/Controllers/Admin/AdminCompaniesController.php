<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Company};
use App\Services\CompanyService;

class AdminCompaniesController extends Controller
{
    private $companyService;

    public function __construct(CompanyService $service)
    {
        $this->companyService = $service;
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            return $this->companyService->getDataTable();
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
        $id = $request['id'];
        $company = Company::where('ruc', $request['ruc'])->first();

        return  $company == null ||
                $company->id == $id ? 'true' : 'false';
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
