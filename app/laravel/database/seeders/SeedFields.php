<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedFields extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        DB::table('fields')->insertOrIgnore([
            'id' => 1,
            'title' => 'Group content',
            'name' => 'group_content',
            'type' => '',
            'type_entity' => 'post',
            'values' => '',
            'parent_id' => null,
        ]);
    }
}
