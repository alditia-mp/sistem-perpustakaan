
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

                    <div class="mb-6">
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
                        <h3 class="font-semibold text-gray-800">
                            Pilih Buku
                        </h3>
                        <p class="mb-3 text-sm text-gray-500">
                            Masukkan jumlah buku yang ingin dipinjam. Isi 0 jika tidak dipinjam.
                        </p>

                        @forelse ($books as $book)
                            <div class="mb-3 flex items-center justify-between gap-4 rounded border p-3">
                                <div>
                                    <p class="font-medium text-gray-800">
                                        {{ $book->title }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Stok tersedia: {{ $book->stock }}
                                    </p>
                                </div>

                                <div class="w-24">
                                    <label for="items_{{ $book->id }}"
                                           class="mb-1 block text-sm">
                                        Jumlah
                                    </label>
                                    <input
                                        type="number"
                                        name="items[{{ $book->id }}]"
                                        id="items_{{ $book->id }}"
                                        min="0"
                                        max="{{ $book->stock }}"
                                        value="{{ old('items.' . $book->id, 0) }}"
                                        class="w-full rounded border-gray-300"
                                    >
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-red-600">
                                Belum ada buku dengan stok tersedia.
                            </p>
                        @endforelse
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
