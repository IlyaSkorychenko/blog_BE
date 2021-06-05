<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        Post::all()->each(function ($post) use ($users) {
            Comment::factory()
                ->count(3)
                ->for($users->random())
                ->for($post)
                ->create();
        });
    }
}
