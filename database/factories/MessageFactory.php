<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Buihuycuong\Vnfaker\VNFaker;


class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween("-1 year", "now");
        return [
            'user_id' => rand(1, User::count()),
            'room_id' => rand(1, Room::count()),
            'content' => VNFaker::company(),
            'updated_at' => $date,
            'created_at' => $date
        ];
    }
}
