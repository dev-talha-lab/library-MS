<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowBookRequest;
use App\Http\Requests\ReturnBookRequest;
use App\Models\BorrowRecord;
use App\Services\BorrowService;

class BorrowController extends Controller
{
    private BorrowService $service;

    public function __construct(BorrowService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index()
    {
        $borrows = BorrowRecord::with(['book','member'])->latest()->paginate(20);
        return view('borrows.index', compact('borrows'));
    }

    public function store(BorrowBookRequest $request)
    {
        try {
            $borrow = $this->service->borrow(
                $request->input('member_id'),
                $request->input('book_id'),
                $request->input('due_date')
            );
            return redirect()->back()->with('success','Book borrowed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function return(ReturnBookRequest $request)
    {
        try {
            $borrow = $this->service->return($request->input('borrow_id'));
            return redirect()->back()->with('success','Book returned.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
