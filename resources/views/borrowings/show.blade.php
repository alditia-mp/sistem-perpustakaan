
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <p class="mb-3">
                    <strong>Anggota:</strong>
                    {{ $borrowing->member->name }}
                </p>

                <p class="mb-3">
                    <strong>Petugas:</strong>
                    {{ $borrowing->user->name }}
                </p>

                <p class="mb-3">
                    <strong>Tanggal Pinjam:</strong>
                    {{ $borrowing->borrow_date->format('d-m-Y') }}
                </p>

                <p class="mb-3">
                    <strong>Batas Pengembalian:</strong>
                    {{ $borrowing->due_date->format('d-m-Y') }}
                </p>

                <p class="mb-5">
                    <strong>Status:</strong>
                    {{ $borrowing->status === 'borrowed' ? 'Dipinjam' : 'Dikembalikan' }}
                </p>

                <h3 class="mb-3 text-lg font-semibold">Daftar Buku</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-3 text-left">Judul Buku</th>
                                <th class="border p-3 text-left">Jumlah</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($borrowing->details as $detail)
                                <tr>
                                    <td class="border p-3">
                                        {{ $detail->book->title }}
                                    </td>
                                    <td class="border p-3">
                                        {{ $detail->qty }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('borrowings.index') }}"
                   class="mt-5 inline-block rounded bg-gray-200 px-4 py-2 hover:bg-gray-300">
                    Kembali ke Daftar
                </a>

            </div>
        </div>
    </div>
</x-app-layout>

