<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedPosts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        $arrayPostInsert = [];
        $adminId = Admin::all()->first->id;

        for ($i = 0; $i < 100; ++$i) {
            $arrayPostInsert[] = [
                'id' => $i,
                'name' => 'post number ' . $i,
                'image' => 'https://images.livemint.com/img/2020/06/03/1600x900/Valorant_1591218052835_1591218061187.jpg',
                'description' => 'description number ' . $i,
                'content' => 'content ' . $i,
                'status' => 'public',
                'admin_id' => $adminId
            ];
        }

        DB::table('posts')->insert($arrayPostInsert);
    }
}
