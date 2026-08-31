<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShippingMethodRequestCreate;
use App\Http\Requests\Admin\ShippingMethodRequestUpdate;
use App\Services\Contracts\Admin\ShippingMethodInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

class ShippingMethodsController extends Controller
{
    use Alert;

    public function __construct(
        protected ShippingMethodInterface $shippingMethodService,
    ) {}

    public function index()
    {
        $shippingMethods = $this->shippingMethodService->allShippingMethods();
        // dd($shippingMethods);
        return view('admin.shipping-methods.index', compact('shippingMethods'));
    }

    public function create()
    {
        return view('admin.shipping-methods.create');
    }

    public function store(ShippingMethodRequestCreate $request)
    {
        try {
            $this->shippingMethodService->addShippingMethod($request->validated());

            $this->created('Shipping method created successfully.');
            return redirect()->route('admin.shipping-methods.index');
        } catch (\Exception $e) {
            $this->failed('Failed to create shipping method: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit(int $id)
    {
        $shippingMethod = $this->shippingMethodService->getShippingMethod($id);
        // dd($shippingMethod->toArray());
        return view('admin.shipping-methods.edit', compact('shippingMethod'));
    }

    public function update(ShippingMethodRequestUpdate $request, int $id)
    {
        try {
            $this->shippingMethodService->updateShippingMethod($id, $request->validated());

            $this->updated('Shipping method updated successfully.');
            return redirect()->route('admin.shipping-methods.index');
        } catch (\Exception $e) {
            $this->failed('Failed to update shipping method: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(int $id)
    {
        try {
            // dd($request->validated());
            $this->shippingMethodService->delete($id);

            return response()->json([
                'message' => 'Shipping Method deleted successfully',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to delete shipping method: ' . $e->getMessage());

            return response()->json([
                'message' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }
}
