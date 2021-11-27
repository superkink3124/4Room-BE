<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CommentSeeder::class,
            UpvoteSeeder::class,
            FollowSeeder::class,
            RoomSeeder::class,
            MessageSeeder::class
        ]);
    }
}
