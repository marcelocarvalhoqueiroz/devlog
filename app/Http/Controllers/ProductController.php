<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = $this->productService->getProducts();

        return response()->json($res, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $res = $this->productService->create($request->validated());

        return response()->json($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = $this->productService->findByUuid($id);
        return response()->json($res, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $res = $this->productService->update($request->validated(), $id);
        return response()->json($res, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = $this->productService->delete($id);
        return response()->noContent();
    }
}
