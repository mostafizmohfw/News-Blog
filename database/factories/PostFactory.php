<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'category_id' => random_int(10,12),
            'sub_category_id' => random_int(2,6),
            'description' => $this->faker->paragraph,
            'is_approved' => 1,
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'user_id' =>random_int(1,2),
            'photo' =>  $this->faker->imageUrl( 1000, 400, 'dogs'),
        ];
    }
}
