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
        $payload = '{"query":"mutation{\n    generateShortLink(input:{originUrl:"https://shopee.v
n/Apple-Iphone-11-128GB-Local-Set-i.52377417.6309028319",subIds:["s1","s2","s3","s4","s5"]}){\n        shortLink\n    }\n}"}';

        // Tính toán giá trị chữ ký
        $accessKey = '17342940062';
        $secretKey = '6ERDUYBANO7VTIBSFNQOAHDTLRU3MRV6';
        $signature = hash('sha256', $accessKey . $timestamp . $payload . $secretKey);

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'SHA256 Credential=' . $accessKey . ',Timestamp=' . $timestamp . ',Signature=' . $signature,
        ];

        $test = postApi('https://open-api.affiliate.shopee.com.my/graphql', [], $headers);

        print_r($test);

        return Command::SUCCESS;
    }
}
