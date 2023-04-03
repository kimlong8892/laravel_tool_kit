<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller {
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function Detail($id): View|RedirectResponse {
        $product = $this->productRepository->getDetailWeb($id);

        if (empty(env('SHOW_PRODUCT_DETAIL'))) {
            return redirect($product->getAttribute('offerLink'));
        }

        return view('web.product.detail', compact('product'));
    }
}
