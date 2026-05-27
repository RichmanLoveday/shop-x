<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\BillingInfoRequest;
use App\Services\Contracts\User\CartServiceInterface;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\CheckOutServiceInterface;
use App\Services\Contracts\ShippingRuleServiceInterface;
use App\Services\Contracts\ShippingZoneServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
            $cartItems = $this->cartService->getCartItemsByStores($user);

            // dd($cartItems);

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

    public function billingInfo(BillingInfoRequest $request)
    {
        // dd($request->all());

        // store billing info in session
        Session::put('billing_info', [
            'billing_address_id' => $request->billing_address_id,
            'shipping_address_id' => $request->shipping_address_id,
            'shipping_method_id' => $request->shipping_method_id,
            'zone_id' => $request->zone_id,
        ]);
    }
}
