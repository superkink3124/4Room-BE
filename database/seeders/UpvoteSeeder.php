<?php

namespace Database\Seeders;

use App\Models\Upvote;
use Illuminate\Database\Seeder;

class UpvoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Upvote::factory(2000)->create();
    }
}
