
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Peminjaman dan Pengembalian
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if (session('success'))
                    <div class="mb-4 rounded bg-green-100 p-3 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-4 rounded bg-blue-100 p-3 text-blue-800">
                        {{ session('info') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-100 p-3 text-red-800">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="mb-5">
                    <a href="{{ route('borrowings.create') }}"
                       class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                        + Tambah Peminjaman
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-3 text-left">No.</th>
                                <th class="border p-3 text-left">Anggota</th>
                                <th class="border p-3 text-left">Buku</th>
                                <th class="border p-3 text-left">Jumlah</th>
                                <th class="border p-3 text-left">Tanggal Pinjam</th>
                                <th class="border p-3 text-left">Batas Kembali</th>
                                <th class="border p-3 text-left">Tanggal Kembali</th>
                                <th class="border p-3 text-left">Status</th>
                                <th class="border p-3 text-left">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($borrowings as $borrowing)
                                <tr>
                                    <td class="border p-3">
                                        {{ $borrowings->firstItem() + $loop->index }}
                                    </td>

                                    <td class="border p-3">
                                        {{ $borrowing->member->name }}
                                    </td>

                                    <td class="border p-3">
                                        @foreach ($borrowing->details as $detail)
                                            <div>{{ $detail->book->title }}</div>
                                        @endforeach
                                    </td>

                                    <td class="border p-3">
                                        @foreach ($borrowing->details as $detail)
                                            <div>{{ $detail->qty }}</div>
                                        @endforeach
                                    </td>

                                    <td class="border p-3">
                                        {{ $borrowing->borrow_date->format('d-m-Y') }}
                                    </td>

                                    <td class="border p-3">
                                        {{ $borrowing->due_date->format('d-m-Y') }}
                                    </td>

                                    <td class="border p-3">
                                        {{ $borrowing->return_date
                                            ? $borrowing->return_date->format('d-m-Y')
                                            : '-' }}
                                    </td>

                                    <td class="border p-3">
                                        @if ($borrowing->status === 'borrowed')
                                            <span class="rounded bg-yellow-100 px-2 py-1 text-yellow-800">
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="rounded bg-green-100 px-2 py-1 text-green-800">
                                                Dikembalikan
                                            </span>
                                        @endif
                                    </td>

                                    <td class="border p-3">
                                        <a href="{{ route('borrowings.show', $borrowing) }}"
                                           class="mb-2 inline-block rounded bg-gray-600 px-3 py-2 text-white">
                                            Detail
                                        </a>

                                        @if ($borrowing->status === 'borrowed')
                                            <form action="{{ route('borrowings.return', $borrowing) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Proses pengembalian buku ini?')">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="rounded bg-green-600 px-3 py-2 text-white hover:bg-green-700">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="border p-5 text-center text-gray-500">
                                        Belum ada data peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $borrowings->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
