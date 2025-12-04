<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member;
use App\Models\Book;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BorrowRecord>
 */
class BorrowRecordFactory extends Factory
{
    public function definition()
    {
        $book = Book::inRandomOrder()->first() ?? Book::factory()->create();
        $member = Member::inRandomOrder()->first() ?? Member::factory()->create();

        return [
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrowed_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'due_date' => $this->faker->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d'),
            'returned_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
