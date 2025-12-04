@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="card p-4">
            <h2 class="font-semibold">Top 5 Most Borrowed</h2>
            <ul>
                @foreach($topBooks as $b)
                    <li>{{ $b->book?->title ?? '—' }} ({{ $b->total }})</li>
                @endforeach
            </ul>
        </div>

        <div class="card p-4">
            <h2 class="font-semibold">Last 5 Borrows</h2>
            <ul>
                @foreach($lastBorrows as $borrow)
                    <li>{{ $borrow->member->name }} borrowed {{ $borrow->book->title }} at {{ $borrow->borrowed_at->format('Y-m-d') }}</li>
                @endforeach
            </ul>
        </div>

        <div class="card p-4">
            <h2 class="font-semibold">Low Stock (≤ 3)</h2>
            <ul>
                @foreach($lowStock as $book)
                    <li>{{ $book->title }} — {{ $book->copies_available }}</li>
                @endforeach
            </ul>
        </div>

        <div class="card p-4">
            <h2 class="font-semibold">Total Active Borrows</h2>
            <div class="text-4xl font-bold">{{ $totalActive }}</div>
        </div>
    </div>
</div>
@endsection
