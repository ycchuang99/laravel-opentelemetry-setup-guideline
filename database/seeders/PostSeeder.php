<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Post 1',
                'content' => 'Content 1',
                'author' => 'Author 1',
            ],
            [
                'title' => 'Post 2',
                'content' => 'Content 2',
                'author' => 'Author 2',
            ],
            [
                'title' => 'Post 3',
                'content' => 'Content 3',
                'author' => 'Author 3',
            ],
        ];

        foreach ($posts as $post) {
            \App\Models\Post::create($post);
        }
    }
}
