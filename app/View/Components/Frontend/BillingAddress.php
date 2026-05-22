<?php

namespace App\View\Components\Frontend;

use App\Models\Address;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Closure;

class BillingAddress extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Address $address,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.billing-address');
    }
}
