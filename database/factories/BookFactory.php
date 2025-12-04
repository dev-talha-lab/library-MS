<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    public function definition()
    {
        $isbnDigits = $this->faker->numerify('#############');

        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'isbn' => $isbnDigits,
            'published_year' => $this->faker->year(),
            'copies_available' => $this->faker->numberBetween(0, 5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
