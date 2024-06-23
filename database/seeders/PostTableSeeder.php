<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            [
                'title' => 'Judul Post Pertama',
                'slug' => 'judul-post-pertama',
                'author' => 'Penulis Pertama',
                'thumbnail' => 'path/ke/gambar.jpg',
                'description' => 'Deskripsi singkat dari post pertama.',
                'content' => 'Konten lengkap dari post pertama.',
                'category' => 'Kategori Pertama',
                'tag' => 'Tag Pertama',
                'status' => 'published'
            ],
            [
                'title' => 'HTML',
                'slug' => 'html',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'CSS',
                'slug' => 'css',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Javascript',
                'slug' => 'javascript',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Pemrograman',
                'slug' => 'pemrograman',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}