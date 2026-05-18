<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ShippingRulesType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShippingRuleRequestCreate;
use App\Http\Requests\Admin\ShippingRuleRequestUpdate;
use App\Services\ShippingRuleService;
use App\Traits\Alert;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{
    use Alert;

    public function __construct(
        public ShippingRuleService $shippingRuleService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingRules = $this->shippingRuleService->allShippingRules();
        // dd($shippingRules->toArray());
        return view('admin.shipping-rule.index', compact('shippingRules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping-rule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingRuleRequestCreate $request)
    {
        try {
            $shippingRule = $this->shippingRuleService->createShippingRule($request->validated());
            $this->created('Shipping rule created successfully!');
            return to_route('admin.shipping-rules.index');
        } catch (\Exception $e) {
            $this->failed('An error occurred while creating shipping rule');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $shippingRule = $this->shippingRuleService->getShippingRule($id);
            return view('admin.shipping-rule.edit', compact('shippingRule'));
        } catch (\Exception $e) {
            logger()->error('Unable to fetch shipping rule: ' . $e->getMessage());
            $this->failed('An error occurred while fetching shipping rule');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShippingRuleRequestUpdate $request, string $id)
    {
        try {
            $shippingRule = $this->shippingRuleService->updateShippingRule($id, $request->validated());
            $this->updated('Shipping rule updated successfully!');
            return to_route('admin.shipping-rules.index');
        } catch (\Exception $e) {
            logger()->error('Unable to update shipping rule: ' . $e->getMessage());
            $this->failed('An error occurred while updating shipping rule');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->shippingRuleService->deleteShippingRule($id);

            $this->deleted('Shipping Rule Deleted successfully');
            return response()->json([
                'message' => 'Shipping Rule deleted successfully',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to delete shipping rule: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting shipping rule',
            ]);
        }
    }
}
