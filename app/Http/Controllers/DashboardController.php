<?php

namespace App\Http\Controllers;

use App\Models\BorrowRecord;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 1. Top 5 most borrowed books
        $topBooks = BorrowRecord::select('book_id', DB::raw('count(*) as total'))
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->with('book')
            ->limit(5)
            ->get();

        // 2. Last 5 borrow records
        $lastBorrows = BorrowRecord::with(['book','member'])->latest()->limit(5)->get();

        // 3. Books with stock ≤ 3
        $lowStock = Book::where('copies_available','<=',3)->get();

        // 4. Total active borrows
        $totalActive = BorrowRecord::whereNull('returned_at')->count();

        return view('dashboard', compact('topBooks','lastBorrows','lowStock','totalActive'));
    }
}
