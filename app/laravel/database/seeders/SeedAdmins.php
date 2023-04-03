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
            'email' => 'longshare9201@gmail.com',
            'password' => Hash::make('kimlong@Admin123')
        ]);
        DB::table('admins')->insertOrIgnore([
            'name' => 'Admin2',
            'email' => 'trankimhoang11052000@gmail.com',
            'password' => Hash::make('kimhoang@Admin123')
        ]);
    }
}
