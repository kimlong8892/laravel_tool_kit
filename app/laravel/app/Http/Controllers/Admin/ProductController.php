<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ProductShopeeApi\ProductShopeeApiRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected ProductShopeeApiRepositoryInterface $productShopeeApiRepository;

    public function __construct(ProductShopeeApiRepositoryInterface $productShopeeApiRepository) {
        $this->productShopeeApiRepository = $productShopeeApiRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View {
        $search = $request->get('search');
        $page = $request->get('page') ?? 1;
        $listProductShopeeData = [];

        if (!empty($search)) {
            $listProductShopee = $this->productShopeeApiRepository->getListProductApi($search, $page);
            $listProductShopeeData = $listProductShopee['data']['productOfferV2']['nodes'] ?? [];
        }

        return view('admin.product.index', compact('listProductShopeeData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
