<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Contracts\User\ProductServiceInterface;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $productService,
    ) {}

    public function index()
    {
        $products = $this->productService->productListing();
        // dd($products->toArray());
        return view('frontend.pages.product', compact('products'));
    }

    public function show(string $slug)
    {
        $product = $this->productService->getProduct($slug);
        $relatedProducts = $this->productService->getRelatedProducts($slug);
        // dd($product->toArray());
        // dd($relatedProducts->toArray());
        return view('frontend.pages.product-details', compact('product', 'relatedProducts'));
    }

    public function getProduct(string $type, int $id)
    {
        try {
            $product = $this->productService->getProductById($id, $type);
            $modal = view('components.frontend.quick-view-product-modal', compact('product'))->render();

            return response()->json([
                'modal' => $modal,
                'status' => true,
            ]);
        } catch (\Exception $e) {
        }
    }
}
