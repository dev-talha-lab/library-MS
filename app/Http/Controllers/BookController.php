<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Services\BookService;

class BookController extends Controller
{
    private BookService $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index()
    {
        $books = Book::latest()->paginate(15);
        return view('books.index', compact('books'));
    }

    public function store(StoreBookRequest $request)
    {
        $book = $this->service->create($request->validated());
        return redirect()->route('books.index')->with('success', 'Book created.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $this->service->update($book, $request->validated());
        return redirect()->back()->with('success', 'Book updated.');
    }

    public function destroy(Book $book)
    {
        $this->service->softDelete($book);
        return redirect()->route('books.index')->with('success', 'Book deleted (soft).');
    }
}
