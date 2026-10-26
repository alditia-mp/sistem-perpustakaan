<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Buku</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <dl class="space-y-2">
                    <div><dt class="font-semibold">Judul</dt><dd>{{ $book->title }}</dd></div>
                    <div><dt class="font-semibold">Penulis</dt><dd>{{ $book->author }}</dd></div>
                    <div><dt class="font-semibold">Kategori</dt>
                        <dd>{{ $book->category?->name ?? 'Belum ada kategori' }}</dd></div>
                    <div><dt class="font-semibold">Tahun</dt><dd>{{ $book->year }}</dd></div>
                    <div><dt class="font-semibold">Stok</dt><dd>{{ $book->stock }}</dd></div>
                    <div><dt class="font-semibold">ISBN</dt><dd>{{ $book->isbn ?? '-' }}</dd></div>
                </dl>
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('books.index') }}" class="text-gray-600">Kembali</a>
                    <a href="{{ route('books.edit', $book) }}" class="text-yellow-600">Edit</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>