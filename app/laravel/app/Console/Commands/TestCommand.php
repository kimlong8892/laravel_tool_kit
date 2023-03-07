<?php

namespace App\Console\Commands;

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

        $date = new \DateTime();
        $timestamp = $date->getTimestamp(); // Lấy thời gian hiện tại ở định dạng timestamp
        // Chuỗi JSON yêu cầu API
        $payload = '{ "query": "query Fetch($page:Int){ productOfferV2( listType: 0, sortType: 2, page: $page, limit: 50 ) { nodes { commissionRate commission price productLink offerLink } } }", "operationName": null, "variables":{ "page":0 } }';

        // Tính toán giá trị chữ ký
        $accessKey = '17342940062';
        $secretKey = '6ERDUYBANO7VTIBSFNQOAHDTLRU3MRV6';
        $signature = hash('SHA256', $accessKey . $timestamp . $payload . $secretKey);

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'SHA256 Credential=' . $accessKey . ',Timestamp=' . $timestamp . ',Signature=' . $signature,
        ];

        $test = postApi('https://open-api.affiliate.shopee.vn/graphql', [], $headers);

        print_r($test);

        return Command::SUCCESS;
    }
}
