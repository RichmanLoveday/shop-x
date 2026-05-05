<?php

namespace App\View\Components\Frontend;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class ProductGallery extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Product $product,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.product-gallery');
    }
}