<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequestCreate;
use App\Services\Admin\BrandService;
use App\Services\Contracts\Admin\BrandServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use Alert;

    public function __construct(
        protected BrandServiceInterface $brandService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = $this->brandService->allBrands();
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequestCreate $request)
    {
        try {
            $brand = $this->brandService->addBrand($request->all());
            $this->created('Brand created successfully!');

            return redirect()->route('admin.brands.index');
        } catch (\Exception $e) {
            logger()->error('Brand upload failed: ' . $e->getMessage());
            $this->failed('Unable to create brand!');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $brand = $this->brandService->getBrand($id);
            // dd($brand);

            return view('admin.brand.edit', compact('brand'));
        } catch (\Exception $e) {
            logger()->error('Unable to fetch brand: ' . $e->getMessage());
            $this->failed('Unable to fetch brand');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $brand = $this->brandService->update($id, $request->all());
            $this->created('Brand updated successfully!');

            return redirect()->route('admin.brands.index');
        } catch (\Exception $e) {
            logger()->error('Brand upload failed: ' . $e->getMessage());
            $this->failed('Unable to create brand!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // dd($request->validated());
            $this->brandService->delete($id);

            return response()->json([
                'message' => 'Brand deleted successfully',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to delete brand: ' . $e->getMessage());

            return response()->json([
                'message' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }
}