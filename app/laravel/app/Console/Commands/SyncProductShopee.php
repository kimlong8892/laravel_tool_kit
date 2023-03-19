<?php

namespace App\Console\Commands;

use App\Repositories\ProductShopeeApi\ProductShopeeApiRepositoryInterface;
use Illuminate\Console\Command;

class SyncProductShopee extends Command
{
    protected ProductShopeeApiRepositoryInterface $productShopeeApiRepository;

    public function __construct(ProductShopeeApiRepositoryInterface $productShopeeApiRepository) {
        $this->productShopeeApiRepository = $productShopeeApiRepository;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync-product-shopee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int {
        $listProductShopeeData = $this->productShopeeApiRepository->getListProductApi();

        print_r($listProductShopeeData);

        return 0;
    }
}
