<?php

namespace App\Console\Commands;

use App\Repositories\AccesstradeApi\AccesstradeApiRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InsertAccesstradeCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accesstrade:insert-campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'accesstrade:insert-campaigns';

    protected AccesstradeApiRepositoryInterface $accesstradeApiRepository;

    public function __construct(AccesstradeApiRepositoryInterface $accesstradeApiRepository) {
        $this->accesstradeApiRepository = $accesstradeApiRepository;
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int {
        try {
            if ($this->accesstradeApiRepository->insertCampaigns()) {
                echo "\nInsert success\n";
            } else {
                echo "\nInsert fail\n";
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            echo $exception->getMessage();
        }

        return 0;
    }
}
