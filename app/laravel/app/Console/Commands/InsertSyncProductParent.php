<?php

namespace App\Console\Commands;

use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertSyncProductParent extends Command
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) {
        $this->productRepository = $productRepository;

        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insert-sync-product-parent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command insert-sync-product-parent';

    /**
     * Execute the console command.
     *
     * @return boolean
     */
    public function handle(): bool {
        $productIds = DB::table('products')
            ->where('parent_id', '!=', null)
            ->pluck('parent_id');

        $listProduct = DB::table('products')
            ->whereNotIn('id', $productIds)
            ->get();

        foreach ($listProduct as $product) {
            $productName = $product->productName;

            $this->productRepository->searchProductTiki($productName);

        }



        return true;
    }
}
