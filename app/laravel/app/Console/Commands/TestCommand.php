<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

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
    public function handle()
    {
        $appId = '17342940062';
        $apiKey = '6ERDUYBANO7VTIBSFNQOAHDTLRU3MRV6';
        $date = new \DateTime();
        $timestamp = $date->getTimestamp();
        $body = '{"query":"{\\n  productOfferV2{\\n    nodes {\\n      productName\\n    }\\n  }\\n}","variables":null,"operationName":null}';
        $signature = hash('sha256', $appId . $timestamp . $body . $apiKey);
        $headers = [
            'authorization' => 'SHA256 Credential=' . $appId . ', Timestamp=' . $timestamp . ', Signature=' . $signature,
            'content-type' => 'application/json',
        ];
        $data = postApiShopee('https://open-api.affiliate.shopee.vn/graphql', $body, $headers);


        print_r($data);

        return 0;
    }
}
