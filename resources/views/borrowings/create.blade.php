
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Peminjaman Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-100 p-3 text-red-800">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('borrowings.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="member_id" class="mb-1 block font-medium">
                            Anggota
                        </label>

                        <select name="member_id" id="member_id" required
                                class="w-full rounded border-gray-300">
                            <option value="">-- Pilih Anggota --</option>

                            @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} - {{ $member->email }}
                                </option>
                            @endforeach
                        </select>

                        @if ($members->isEmpty())
                            <p class="mt-1 text-sm text-red-600">
                                Belum ada anggota. Tambahkan anggota terlebih dahulu.
                            </p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="book_id" class="mb-1 block font-medium">
                            Buku
                        </label>

                        <select name="book_id" id="book_id" required
                                class="w-full rounded border-gray-300">
                            <option value="">-- Pilih Buku --</option>

                            @foreach ($books as $book)
                                <option value="{{ $book->id }}"
                                    {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }} (Stok: {{ $book->stock }})
                                </option>
                            @endforeach
                        </select>

                        @if ($books->isEmpty())
                            <p class="mt-1 text-sm text-red-600">
                                Belum ada buku dengan stok tersedia.
                            </p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="qty" class="mb-1 block font-medium">
                            Jumlah Buku
                        </label>

                        <input type="number" name="qty" id="qty"
                               min="1" value="{{ old('qty', 1) }}" required
                               class="w-full rounded border-gray-300">
                    </div>

                    <div class="mb-4">
                        <label for="borrow_date" class="mb-1 block font-medium">
                            Tanggal Peminjaman
                        </label>

                        <input type="date" name="borrow_date" id="borrow_date"
                               value="{{ old('borrow_date', now()->format('Y-m-d')) }}"
                               required class="w-full rounded border-gray-300">
                    </div>

                    <div class="mb-6">
                        <label for="due_date" class="mb-1 block font-medium">
                            Batas Pengembalian
                        </label>

                        <input type="date" name="due_date" id="due_date"
                               value="{{ old('due_date', now()->addDays(7)->format('Y-m-d')) }}"
                               required class="w-full rounded border-gray-300">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                                {{ $members->isEmpty() || $books->isEmpty() ? 'disabled' : '' }}>
                            Simpan Peminjaman
                        </button>

                        <a href="{{ route('borrowings.index') }}"
                           class="rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">
                            Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
