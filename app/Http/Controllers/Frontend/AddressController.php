<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddressRequestCreate;
use App\Http\Requests\Frontend\AddressRequestUpdate;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\ShippingZoneResolverServiceInterface;
use App\Services\Contracts\StatesServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AddressController extends Controller
{
    use Alert;

    public function __construct(
        public AddressServiceInterface $addressService,
        public StatesServiceInterface $stateService,
        public ShippingZoneResolverServiceInterface $shippingZoneResolverService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('web')->user();
        $addresses = $this->addressService->allAddress($user);
        // dd($addresses[0]->city);
        return view('frontend.dashboard.address.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $states = $this->stateService->getStates();
        return view('frontend.dashboard.address.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequestCreate $request)
    {
        try {
            $user = Auth::guard('web')->user();
            $address = $this->addressService->createAddress($user, $request->validated());
            $this->created('Address added successfully!');
            return to_route('address.index');
        } catch (\Exception $e) {
            logger()->error('Failed to add address: ' . $e->getMessage());
            $this->failed('Unable to add address');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = auth()->user();
        $address = $this->addressService->getAddress($user, $id);
        $states = $this->stateService->getStates();
        return view('frontend.dashboard.address.edit', compact('address', 'states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressRequestUpdate $request, string $id)
    {
        try {
            $user = Auth::guard('web')->user();
            $address = $this->addressService->updateAddress($user, $id, $request->validated());
            $this->created('Address updated successfully!');
            return to_route('address.index');
        } catch (\Exception $e) {
            logger()->error('Failed to update address: ' . $e->getMessage());
            $this->failed('Unable to update address');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Auth::guard('web')->user();
            $this->addressService->deleteAddress($user, $id);
            $this->deleted('Address Deleted successfully');

            return response()->json([
                'message' => 'Address deleted successfully',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to delete address: ' . $e);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting address',
            ]);
        }
    }

    public function getCities(int $id)
    {
        try {
            $state = $this->stateService->getState($id);

            return response()->json([
                'status' => true,
                'state_cities' => $state,
                'message' => 'Cities retrived successfully'
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to delete state'
            ]);
        }
    }

    public function estimatedDeliveryFee(int $cityId)
    {
        try {
            $estimatedDelivery = $this->shippingZoneResolverService->calculatedEstimatedDeliveryCost($cityId);
            // dd($estimatedDelivery);

            return response()->json($estimatedDelivery);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch estimated delivery'
            ]);
        }
    }

    public function setDefault(int $id)
    {
        $user = auth()->user();
        $this->addressService->setDefault($user, $id);

        return response()->json([
            'status' => true,
            'message' => 'Default address updated successfully'
        ]);
    }
}
