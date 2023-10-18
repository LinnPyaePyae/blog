<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
            $description = fake()->paragraph();
            $category_id = rand(1,5);
            $user_id=1;
        return [
            "title"=>$title,
            "content"=>$description,
            "category_id"=>$category_id,
            "user_id"=>$user_id
        ];
    }
}
