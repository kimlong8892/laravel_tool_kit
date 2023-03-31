<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\View\View;

class ProductController extends Controller {
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function Detail($id): View {
        $product = $this->productRepository->getDetailWeb($id);

        return view('web.product.detail', compact('product'));
    }
}
