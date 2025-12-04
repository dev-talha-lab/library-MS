<?php

namespace App\Services;

use App\Models\BorrowRecord;
use App\Models\Book;
use App\Models\StockAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class BorrowService
{
    public function borrow(int $memberId, int $bookId, $dueDate): BorrowRecord
    {
        return DB::transaction(function () use ($memberId, $bookId, $dueDate) {
            $book = Book::where('id', $bookId)->lockForUpdate()->firstOrFail();

            if ($book->copies_available <= 0) {
                throw new Exception("Cannot borrow: no copies available.");
            }

            $book->decrement('copies_available', 1);

            $borrow = BorrowRecord::create([
                'member_id' => $memberId,
                'book_id' => $bookId,
                'borrowed_at' => now(),
                'due_date' => $dueDate,
            ]);

            if ($book->copies_available <= 0) {
                StockAlert::create([
                    'book_id' => $book->id,
                    'copies_at_alert' => $book->copies_available,
                    'alerted_at' => now(),
                ]);

                // dispatch notification to admin via Notification or Mail
            }

            return $borrow;
        });
    }

    public function return(int $borrowId): BorrowRecord
    {
        return DB::transaction(function () use ($borrowId) {
            $borrow = BorrowRecord::lockForUpdate()->findOrFail($borrowId);

            if ($borrow->returned_at) {
                throw new Exception("Borrow record already returned.");
            }

            $book = Book::where('id', $borrow->book_id)->lockForUpdate()->firstOrFail();

            $borrow->update(['returned_at' => now()]);

            $book->increment('copies_available', 1);

            return $borrow->fresh();
        });
    }
}
