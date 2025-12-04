<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Book;
use App\Services\BorrowService;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 1) Create 10 members
        Member::factory()->count(10)->create();

        // 2) Create 10 books
        // ensure at least some books have copies >= 1 so borrowing works
        $books = Book::factory()->count(10)->create()->each(function ($book, $i) {
            // ensure a few books have >0 copies for borrowing
            if ($i < 6 && $book->copies_available === 0) {
                $book->copies_available = 2;
                $book->saveQuietly();
            }
        });

        // 3) Perform 5 borrow operations using the BorrowService
        /** @var BorrowService $borrowService */
        $borrowService = App::make(BorrowService::class);

        // pick 5 random member-book pairs, ensuring the chosen book has at least 1 copy
        $members = Member::all()->shuffle();
        $books = Book::where('copies_available', '>', 0)->inRandomOrder()->get();

        // If not enough books with copies, increment copies for some books
        if ($books->count() < 5) {
            $needed = 5 - $books->count();
            $candidates = Book::inRandomOrder()->take($needed)->get();
            foreach ($candidates as $c) {
                $c->copies_available = max(1, $c->copies_available);
                $c->saveQuietly();
            }
            $books = Book::where('copies_available', '>', 0)->inRandomOrder()->get();
        }

        // Create up to 5 borrows
        $count = min(5, min($members->count(), $books->count()));
        for ($i = 0; $i < $count; $i++) {
            $member = $members->get($i);
            $book = $books->get($i);

            // safe-guard: re-check copies
            if ($book->copies_available <= 0) {
                // bump copies to 1 so borrow succeeds
                $book->increment('copies_available', 1);
                $book->refresh();
            }

            try {
                // due_date: 14 days from now
                $dueDate = now()->addDays(14)->format('Y-m-d');

                $borrowService->borrow($member->id, $book->id, $dueDate);

                // optionally, you can mark some as returned as part of seed data
                // e.g., mark first two as returned
            } catch (\Exception $e) {
                // if borrow fails for any reason, log to console or continue
                $this->command->info("Borrow failed for member {$member->id} book {$book->id}: ".$e->getMessage());
            }
        }

        // Optionally, seed an additional few borrow records via factory (inactive or returned)
        // BorrowRecord::factory()->count(2)->create();
    }
}
