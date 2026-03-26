<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class InputImage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string|int $id,
        public string $name,
        public string|null $image,
        public string $previewImage
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-image');
    }
}
