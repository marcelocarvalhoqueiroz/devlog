<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Services\ExperienceService;

class ExperienceController extends Controller
{
    public function __construct(private ExperienceService $experienceService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = $this->experienceService->getExperiences();
        return response()->json($res, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExperienceRequest $request)
    {
        $res = $this->experienceService->create($request->validated());
        return response()->json($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = $this->experienceService->findByUuid($id);
        return response()->json($res, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExperienceRequest $request, string $id)
    {
        $res = $this->experienceService->update($request->validated(), $id);
        return response()->json($res, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = $this->experienceService->delete($id);
        return response()->noContent();
    }
}
