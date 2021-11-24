<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(40)
            ->has(Post::factory()
                ->count(30)
                ->state(function (array $attributes, User $user) {
                return ['user_id' => $user->id];
                }),
                "posts")
            ->create();
    }
}
