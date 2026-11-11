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
            'items' => 'required|array',
            'items.*' => 'required|integer|min:0',
        ]);

        $items = collect($validated['items'])
            ->filter(fn ($qty) => $qty > 0);

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'Pilih minimal satu buku untuk dipinjam.',
            ]);
        }

        DB::transaction(function () use ($validated, $items) {
            $books = Book::whereIn('id', $items->keys())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($items as $bookId => $qty) {
                $book = $books->get($bookId);

                if (!$book) {
                    throw ValidationException::withMessages([
                        'items' => 'Buku yang dipilih tidak ditemukan.',
                    ]);
                }

                if ($book->stock < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Stok buku {$book->title} tidak mencukupi. Stok tersedia: {$book->stock}.",
                    ]);
                }
            }

            $borrowDate = now()->toDateString();
            $dueDate = now()->addDays(7)->toDateString();

            $borrowing = Borrowing::create([
                'user_id' => auth()->id(),
                'member_id' => $validated['member_id'],
                'borrow_date' => $borrowDate,
                'due_date' => $dueDate,
                'status' => 'borrowed',
            ]);

            foreach ($items as $bookId => $qty) {
                BorrowingDetail::create([
                    'borrowing_id' => $borrowing->id,
                    'book_id' => $bookId,
                    'qty' => $qty,
                ]);

                $books->get($bookId)->decrement('stock', $qty);
            }
        });

        return redirect()
            ->route('borrowings.index')
            ->with('success', 'Peminjaman beberapa buku berhasil ditambahkan.');
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
