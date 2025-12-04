<?php

namespace App\Observers;

use App\Models\Book;

use App\Models\BookActivityLog;
use App\Models\StockAlert;
use App\Notifications\StockLowNotification;
use Illuminate\Support\Facades\Notification;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        BookActivityLog::create([
            'book_id' => $book->id,
            'action' => 'created',
        ]);
        if ($book->copies_available <= 0) {
            StockAlert::create([
                'book_id' => $book->id,
                'copies_at_alert' => $book->copies_available,
                'alerted_at' => now(),
            ]);
            // optional: send notification to admin(s)
            // Notification::route('mail', config('mail.admin_address'))->notify(new StockLowNotification($book));
        }
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        BookActivityLog::create([
            'book_id' => $book->id,
            'action' => 'updated',
        ]);

        if ($book->wasChanged('copies_available') && $book->copies_available <= 0) {
            StockAlert::create([
                'book_id' => $book->id,
                'copies_at_alert' => $book->copies_available,
                'alerted_at' => now(),
            ]);
            // Notification::route('mail', config('mail.admin_address'))->notify(new StockLowNotification($book));
        }
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        BookActivityLog::create([
            'book_id' => $book->id,
            'action' => 'deleted',
        ]);
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        //
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        //
    }
}
