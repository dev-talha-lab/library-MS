<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function update(Book $book, array $data): Book
    {
        $book->update($data);
        return $book->fresh();
    }

    public function softDelete(Book $book): void
    {
        $book->delete();
    }

    public function findOrFail(int $id): Book
    {
        return Book::findOrFail($id);
    }
}
