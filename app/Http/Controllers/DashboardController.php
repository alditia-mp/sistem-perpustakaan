<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalMembers = Member::count();

        return view('dashboard', compact('totalBooks', 'totalMembers'));
    }
}