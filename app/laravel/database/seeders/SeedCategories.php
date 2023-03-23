<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedCategories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        $arrayCategoryInsert = [];

        for ($i = 0; $i < 20; ++$i) {
            $arrayCategoryInsert[] = [
                'id' => $i,
                'name' => 'category ' . $i,
                'description' => 'description ' . $i,
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/8/85/Logo-Test.png'
            ];
        }

        DB::table('categories')->insertOrIgnore($arrayCategoryInsert);
    }
}
