<?php

namespace App\Console\Commands;

use App\Repositories\ProductShopeeApi\ProductShopeeApiRepositoryInterface;
use Illuminate\Console\Command;

class UpdateProductPriceHistory extends Command {
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
    protected $signature = 'command:update-product-price-history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command update-product-price-history';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int {
        $this->productShopeeApiRepository->updateProductPriceHistory();
        return 1;
    }
}
