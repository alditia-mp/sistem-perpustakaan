<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <p class="text-sm text-gray-500 mt-2">Selamat Datang, {{ Auth::user()->name }}</p>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-3 gap-4">

                <div class="col-span-2 flex flex-col gap-4">

                    <div class="bg-white shadow-sm sm:rounded-lg px-6 py-4 flex-1">

                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold">Koleksi Buku</h3>
                            <a href="{{ route('books.index') }}" class="text-sm text-blue-600 hover:underline">Lihat buku</a>
                        </div>

                        <div class="grid grid-cols-2">

                            <div>
                                <p class="text-gray-500">Jumlah Judul Buku</p>
                                <p class="text-3xl font-bold">{{ $totalBooks }}</p>
                            </div>

                            <div>
                                <p class="text-gray-500">Jumlah Stok Buku</p>
                                <p class="text-3xl font-bold">{{ $totalStock }}</p>
                            </div>

                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-4 flex-1">

                        <div class="bg-white shadow-sm sm:rounded-lg px-6 py-4">
                            <p class="text-gray-500">Jumlah Member</p>
                            <p class="text-3xl font-bold">{{ $totalMembers }}</p>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-lg px-6 py-4">
                            <p class="text-gray-500">Sedang Dipinjam</p>
                            <p class="text-3xl font-bold">{{ $totalBorrowed }}</p>
                        </div>

                    </div>

                </div>

                <div class="bg-white shadow-sm sm:rounded-lg px-6 py-4">
                    
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-semibold">Peminjaman Terbaru</h3>
                        <a href="{{ route('borrowings.index') }}" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
                    </div>

                    @foreach ($latestBorrowings as $borrowing)
                        <div class="mb-3">
                            <p class="font-medium">{{ $borrowing->member->name }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $borrowing->borrow_date->format('d-m-Y') }} - {{ $borrowing->status }}
                            </p>
                        </div>
                    @endforeach

                    @if ($latestBorrowings->isEmpty())
                        <p class="text-gray-500">Belum ada peminjaman.</p>
                    @endif
                </div>

            </div>

            <div class="mt-8">
                <h3 class="font-semibold text-lg mb-2">Peminjaman Terlambat</h3>

                @if ($overdueBorrowings->isEmpty())
                    <p class="text-gray-500">Tidak ada peminjaman terlambat.</p>
                @else
                    <table class="w-full text-left">
                        <tr class="border-b-2 text-gray-600">
                            <th class="py-2">Anggota</th>
                            <th class="py-2">Tanggal Pinjam</th>
                            <th class="py-2">Batas Kembali</th>
                        </tr>
                        @foreach ($overdueBorrowings as $borrowing)
                            <tr class="border-b">
                                <td class="py-2">{{ $borrowing->member->name }}</td>
                                <td class="py-2">{{ $borrowing->borrow_date->format('d-m-Y') }}</td>
                                <td class="py-2 text-red-600">{{ $borrowing->due_date->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>