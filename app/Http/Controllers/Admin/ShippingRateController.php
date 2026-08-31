<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShippingRateRequestCreate;
use App\Http\Requests\Admin\ShippingRateRequestUpdate;
use App\Services\Contracts\Admin\ShippingMethodInterface;
use App\Services\Contracts\Admin\StoreServiceInterface;
use App\Services\Contracts\ShippingRateServiceInterface;
use App\Services\Contracts\ShippingZoneServiceInterface;
use App\Services\ShippingZoneService;
use App\Traits\Alert;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    use Alert;

    public function __construct(
        protected ShippingMethodInterface $shippingMethodService,
        protected ShippingZoneServiceInterface $shippingZoneService,
        protected ShippingRateServiceInterface $shippingRateService,
        protected StoreServiceInterface $storeService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingRates = $this->shippingRateService->getAllShippingRate();
        // dd($shippingRates->toArray());
        return view('admin.shipping-rate.index', compact('shippingRates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shippingMethods = $this->shippingMethodService->allShippingMethods();
        $shippingMethods = $shippingMethods['shippingMethods'];
        $shippingZones = $this->shippingZoneService->getZones();
        $stores = $this->storeService->allStore();
        // dd($stores);
        return view('admin.shipping-rate.create', compact('shippingMethods', 'shippingZones', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingRateRequestCreate $request)
    {
        // dd($request->all());
        try {
            $this->shippingRateService->addShippingRate($request->validated());
            $this->created('Shipping Rate added successfully');
            return redirect()->route('admin.shipping-rates.index');
        } catch (\Exception $e) {
            $this->failed($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shippingRate = $this->shippingRateService->getShippingRate($id);
        $shippingMethods = $this->shippingMethodService->allShippingMethods();
        $shippingMethods = $shippingMethods['shippingMethods'];
        // dd($shippingRate->originZone->name);
        return view('admin.shipping-rate.edit', compact('shippingRate', 'shippingMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShippingRateRequestUpdate $request, string|int $id)
    {
        try {
            $this->shippingRateService->updateShippingRate($request->validated(), $id);
            $this->created('Shipping Rate updated successfully');
            return redirect()->route('admin.shipping-rates.index');
        } catch (\Exception $e) {
            $this->failed($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->shippingRateService->delete($id);

            $this->deleted('Shipping Rate Deleted successfully');
            return response()->json([
                'message' => 'Shipping Rate deleted successfully',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to delete shipping rate: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting shipping rate',
            ]);
        }
    }
}
