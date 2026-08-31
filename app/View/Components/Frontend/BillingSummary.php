<?php

namespace App\View\Components\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Closure;

class BillingSummary extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $cartItems,
        public ?array $shippingMethods,
        public ?array $shipping,
        public ?array $appliedCoupon,
        public float|int $cartSubTotal,
        public float|int $total,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.billing-summary');
    }
}
