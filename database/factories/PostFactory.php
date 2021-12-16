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
        $content = "# Random\n"
            ."\n### 1. Part 1 \n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."\n### 2. Part 2 \n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."\n### 3. Part 3 \n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."\n### 4. Part 4 \n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."+ ".VNFaker::paragraphs()."\n"
            ."\n## Overview \n"
            ."+ https://hackr.io/blog/types-of-software-testing"."\n"
            ."\n## End";
        return [
            'user_id' => rand(1, User::count()),
            'title' => VNFaker::colorName(),
            'content' => $content,
            'updated_at' => $date,
            'created_at' => $date
        ];
    }
}
