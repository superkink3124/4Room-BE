<?php

namespace Database\Seeders;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sources = User::all();
        $all_ids = range(1, User::count());
        foreach ($sources as $source) {
            $source_id = $source->id;
            shuffle($all_ids);
            $target_ids = array_slice($all_ids, 0, 10);
            foreach ($target_ids as $target_id) {
                if ($source_id == $target_id) {
                    continue;
                }
                Follow::factory()->state([
                    'source_id' => $source_id,
                    'target_id' => $target_id
                ])->create();
            }
        }
    }
}
