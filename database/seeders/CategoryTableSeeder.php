<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
            'title' => 'Pemerintahan Kab. Pekalongan',
            'slug' => 'pemerintahan-kab-pekalongan',
            'description' => 'Pemerintahan untuk Kabupaten Pekalongan',
            'thumbnail' => 'Kabupaten Pekalongan.png',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'parent_id' => null
            ],
            [
            'title' => 'DISDUKCAPIL',
            'slug' => 'disdukcapil',
            'description' => 'Dinas Kependudukan dan Pencatatan Sipil Kabupaten Pekalongan',
            'thumbnail' => 'disdukcapil.png',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'parent_id' => 1
            ],
            [
            'title' => 'DINKOMINFO',
            'slug' => 'dinkominfo',
            'description' => 'Dinas Komunikasi dan Informatika Kabupaten Pekalongan',
            'thumbnail' => 'dinkominfo.png',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'parent_id' => 1
            ],
            ]);
    }
}
