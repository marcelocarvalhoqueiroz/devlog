<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;
use App\Services\CompanyService;

class CompanyController extends Controller
{
    public function __construct(private CompanyService $companyService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = $this->companyService->getCompanies();

        return response()->json($res, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request){
        $res = $this->companyService->create($request->validated());

        return response()->json($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = $this->companyService->findByUuid($id);
        return response()->json($res, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, string $id)
    {
        $res = $this->companyService->update($request->validated(), $id);
        return response()->json($res, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = $this->companyService->delete($id);
        return response()->noContent();
    }
}
