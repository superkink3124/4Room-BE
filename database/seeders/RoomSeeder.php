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
        $names = ["Beach", "City", "Fantasy", "Library", "Lofi", "Natural",
                "Piano", "Rain", "Study With Me"];
        foreach ($names as $name) {
            Room::factory()->state([
                'name' => $name,
            ])->create();
        }
    }
}
