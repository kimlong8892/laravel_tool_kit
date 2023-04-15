<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedEcSites extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        DB::table('ec_sites')->insert([
            [
                'name' => 'Shopee'
            ],
            [
                'name' => 'Tiki'
            ],
            [
                'name' => 'Lazada'
            ]
        ]);
    }
}
