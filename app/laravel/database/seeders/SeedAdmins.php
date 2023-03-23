<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SeedAdmins extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        DB::table('admins')->insertOrIgnore([
            'name' => 'Admin1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('123')
        ]);
        DB::table('admins')->insertOrIgnore([
            'name' => 'Admin2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('123')
        ]);
    }
}
