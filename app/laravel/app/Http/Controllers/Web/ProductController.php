<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use SebastianBergmann\Diff\Exception;

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

    public function searchProduct(Request $request): View {
        try {
            $search = $request->get('search');
            $this->productRepository->insertListProductWithSearch($search);
            $listProduct = $this->productRepository->searchListProduct($search);

            return view('web.search_product.index', compact('listProduct'));
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return view('web.search_product.index');
        }
    }
}
