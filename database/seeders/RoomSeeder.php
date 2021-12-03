<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ["beach", "city", "fantasy", "library", "lofi", "natural",
                "piano", "rain", "live-study"];
        foreach ($names as $name) {
            Room::factory()->state([
                'name' => $name,
            ])->create();
        }
    }
}
