<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with([
            'member',
            'user',
            'details.book',
        ])->latest()->paginate(10);

        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $members = Member::orderBy('name')->get();
        $books = Book::where('stock', '>', 0)
            ->orderBy('title')
            ->get();

        return view('borrowings.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'qty' => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        DB::transaction(function () use ($validated) {
            $book = Book::whereKey($validated['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($book->stock < $validated['qty']) {
                throw ValidationException::withMessages([
                    'qty' => 'Stok buku tidak mencukupi. Stok tersedia: '
                        . $book->stock,
                ]);
            }

            $borrowing = Borrowing::create([
                'user_id' => auth()->id(),
                'member_id' => $validated['member_id'],
                'borrow_date' => $validated['borrow_date'],
                'due_date' => $validated['due_date'],
                'status' => 'borrowed',
            ]);

            BorrowingDetail::create([
                'borrowing_id' => $borrowing->id,
                'book_id' => $book->id,
                'qty' => $validated['qty'],
            ]);

            $book->decrement('stock', $validated['qty']);
        });

        return redirect()
            ->route('borrowings.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $borrowing = Borrowing::with([
            'member',
            'user',
            'details.book',
        ])->findOrFail($id);

        return view('borrowings.show', compact('borrowing'));
    }

    public function edit(string $id)
    {
        return redirect()
            ->route('borrowings.index')
            ->with('info', 'Untuk mengubah data, periksa peminjaman terkait terlebih dahulu.');
    }

    public function update(Request $request, string $id)
    {
        return redirect()
            ->route('borrowings.index')
            ->with('info', 'Gunakan fitur pengembalian untuk menyelesaikan peminjaman.');
    }

    public function returnBook(string $id)
    {
        DB::transaction(function () use ($id) {
            $borrowing = Borrowing::whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($borrowing->status === 'returned') {
                throw ValidationException::withMessages([
                    'borrowing' => 'Peminjaman ini sudah dikembalikan.',
                ]);
            }

            $details = BorrowingDetail::where('borrowing_id', $borrowing->id)
                ->with('book')
                ->get();

            foreach ($details as $detail) {
                $book = Book::whereKey($detail->book_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $book->increment('stock', $detail->qty);
            }

            $borrowing->update([
                'status' => 'returned',
                'return_date' => now()->toDateString(),
            ]);
        });

        return redirect()
            ->route('borrowings.index')
            ->with('success', 'Buku berhasil dikembalikan dan stok telah diperbarui.');
    }

    public function destroy(string $id)
    {
        return redirect()
            ->route('borrowings.index')
            ->with('info', 'Data peminjaman tidak dihapus agar riwayat transaksi tetap tersimpan.');
    }
}
