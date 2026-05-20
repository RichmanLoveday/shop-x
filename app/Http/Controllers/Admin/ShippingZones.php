<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShippingZoneRequestCreate;
use App\Http\Requests\Admin\ShippingZoneRequestUpdate;
use App\Http\Requests\Admin\ShippingZoneRuleUpdateRequest;
use App\Services\Contracts\ShippingRuleServiceInterface;
use App\Services\Contracts\ShippingZoneServiceInterface;
use App\Services\Contracts\StatesServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

class ShippingZones extends Controller
{
    use Alert;

    public function __construct(
        public ShippingRuleServiceInterface $shippingRuleService,
        public StatesServiceInterface $stateService,
        public ShippingZoneServiceInterface $shippingZoneService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingZones = $this->shippingZoneService->getZones();
        // dd($shippingZones->toArray());
        return view('admin.shipping-zones.index', compact('shippingZones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = $this->stateService->getStates();
        // dd($states->toArray());
        $shippingRules = $this->shippingRuleService->allShippingRules();

        return view('admin.shipping-zones.create', compact('states', 'shippingRules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingZoneRequestCreate $request)
    {
        // dd($request->all());
        try {
            $shippingZones = $this->shippingZoneService->createZone($request->validated());
            $this->created('Shipping zone added successfully!');
            return redirect()->route('admin.shipping-zones.index');
        } catch (\Exception $e) {
            logger()->error('An error occurred while add zone: ' . $e->getMessage());
            $this->failed('An error occurred');
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
        $shippingZone = $this->shippingZoneService->getZone($id);
        $states = $this->stateService->getStates();
        $shippingRules = $this->shippingRuleService->allShippingRules();
        return view('admin.shipping-zones.edit', compact('shippingZone', 'states', 'shippingRules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShippingZoneRequestUpdate $request, string $id)
    {
        try {
            $shippingZones = $this->shippingZoneService->updateZone($request->validated(), $id);
            $this->updated('Shipping zone updated successfully!');
            return redirect()->route('admin.shipping-zones.index');
        } catch (\Exception $e) {
            logger()->error('An error occurred while updating zone: ' . $e->getMessage());
            $this->failed('An error occurred');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function shippingZonesRules(int $id)
    {
        $zone = $this->shippingZoneService->getZoneRules($id);
        // dd($zone);
        return view('admin.shipping-zones.rules', compact('zone'));
    }

    public function shippingZonesRulesUpdate(ShippingZoneRuleUpdateRequest $request, int $id)
    {
        try {
            $this->shippingZoneService->updateZoneRuleCharges(
                $id,
                $request->validated()['shipping_rules']
            );

            $this->updated('Shipping rule charges updated successfully!');

            return redirect()->back();
        } catch (\Exception $e) {
            logger()->error(
                'Failed to update shipping zone rule charges: ' . $e->getMessage()
            );

            $this->failed('An error occurred while updating shipping charges.');

            return redirect()->back();
        }
    }
}