<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\CartEmptyException;
use App\Exceptions\InvalidShippingMethodException;
use App\Exceptions\MissingDeliveryAddressException;
use App\Exceptions\MissingShippingMethodException;
use App\Http\Controllers\Controller;
use App\Services\Contracts\User\CartServiceInterface;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\CheckOutServiceInterface;
use App\Services\Contracts\PaymentServiceInterface;
use App\Services\Contracts\ShippingZoneServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    use Alert;

    public function __construct(
        public CartServiceInterface $cartService,
        // public ShippingRuleServiceInterface $shippingRule,
        public ShippingZoneServiceInterface $shippingZoneService,
        public AddressServiceInterface $addressService,
        public PaymentServiceInterface $paymentService,
    ) {}

    public function index()
    {
        try {
            $user = Auth::user();

            [
                'cartItems' => $cartItems,
                'cartSubTotal' => $cartSubTotal,
                'appliedCoupon' => $appliedCoupon,
                'total' => $total,
                'shipping' => $shipping,
            ] = $this->paymentService->getItems($user);

            $addresses = $this->addressService->allAddress($user);
            $cartItems = $this->cartService->getCartItemsByStores($user);

            return view('frontend.pages.payment', compact(
                'cartItems',
                'cartSubTotal',
                'appliedCoupon',
                'total',
                'shipping',
                'addresses'
            ));
        } catch (
            MissingDeliveryAddressException|MissingShippingMethodException|InvalidShippingMethodException $e
        ) {
            $this->failed($e->getMessage());

            return redirect()->route('checkout.index');
        }
    }
}
