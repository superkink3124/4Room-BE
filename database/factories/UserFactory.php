<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Buihuycuong\Vnfaker\VNFaker;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('hehehe123'),
            'name_in_forum' => VNFaker::fullname(),
            'bio' => VNFaker::city(),
            'avatar_id' => rand(1, 10) .".png"
        ];
    }
}
