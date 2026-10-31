<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalStock = Book::sum('stock');
        $totalMembers = Member::count();
        $totalBorrowed = Borrowing::where('status', 'borrowed')->count();

        $latestBorrowings = Borrowing::with(['member', 'details.book'])
            ->latest()
            ->take(3)
            ->get();
        
        $overdueBorrowings = Borrowing::with(['member', 'details.book'])
            ->where('status', 'borrowed')
            ->whereDate('due_date', '<', today())
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBooks',
            'totalStock',
            'totalMembers',
            'totalBorrowed',
            'latestBorrowings',
            'overdueBorrowings'
            ));
    }
}