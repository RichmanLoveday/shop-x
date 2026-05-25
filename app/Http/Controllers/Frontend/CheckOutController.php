<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Contracts\User\CartServiceInterface;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\CheckOutServiceInterface;
use App\Services\Contracts\ShippingRuleServiceInterface;
use App\Services\Contracts\ShippingZoneServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
{
    use Alert;

    public function __construct(
        public CartServiceInterface $cartService,
        public ShippingRuleServiceInterface $shippingRule,
        public ShippingZoneServiceInterface $shippingZoneService,
        public AddressServiceInterface $addressService,
        public CheckOutServiceInterface $checkOutService,
    ) {}

    public function index()
    {
        try {
            $user = Auth::guard('web')->user();
            [
                'cartItems' => $cartItems,
                'cartSubTotal' => $cartSubTotal,
                'appliedCoupon' => $appliedCoupon,
                'total' => $total,
                'shipping' => $shipping,
            ] = $this->checkOutService->getItems($user);

            $shippingMethods = $this->shippingZoneService->getShippingMethodsByCity($user);
            $addresses = $this->addressService->allAddress($user);

            // dd($shippingMethods);

            // dd($appliedCoupon);
            return view('frontend.pages.checkout', compact('cartItems',
                'cartSubTotal',
                'appliedCoupon', 'total',
                'shippingMethods', 'shipping', 'addresses'));
        } catch (\RuntimeException $e) {
            $this->failed($e->getMessage());
            return redirect()->route('login');
        } catch (\Exception $e) {
            logger()->error('Failed to load cart items: ' . $e->getMessage());
            $this->failed('Failed to load cart items');
            return redirect()->back();
        }
    }

    public function getShipping(int $ruleId, int $zoneId)
    {
        try {
            $user = Auth::guard('web')->user();
            $shippingDetail = $this->shippingRule->saveShippingMethod($user, $ruleId, $zoneId);

            return response()->json([
                'data' => $shippingDetail,
                'status' => true,
                'message' => 'Shipping detail retrived successfully',
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}
