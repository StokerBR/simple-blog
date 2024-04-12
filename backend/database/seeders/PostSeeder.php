<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $qty = 20;
        $users = User::all()->pluck('id')->toArray();
        $categories = PostCategory::all()->pluck('id')->toArray();

        Post::factory()->create([
            'author_id' => 1,
            'category_id' => 1,
        ]);

        // Cria posts com autores aleatórios
        for ($i = 0; $i < $qty; $i++) {
            $authorId = $users[array_rand($users)];
            $categoryId = $categories[array_rand($categories)];

            Post::factory()->create([
                'author_id' => $authorId,
                'category_id' => $categoryId,
            ]);
        }
    }
}
