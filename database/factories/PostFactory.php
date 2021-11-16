<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Buihuycuong\Vnfaker\VNFaker;


class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween("-1 year", "now");
        return [
            'user_id' => rand(1, User::count()),
            'content' => VNFaker::paragraphs(),
            'updated_at' => $date,
            'created_at' => $date
        ];
    }
}
