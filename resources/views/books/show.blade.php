<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Buku</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">

                @if ($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover {{ $book->title }}" class="mx-auto mb-4 h-48 rounded">
                @endif

                <dl class="space-y-4">
                    <div><dt class="font-semibold">Judul</dt><dd>{{ $book->title }}</dd></div>
                    <div><dt class="font-semibold">Penulis</dt><dd>{{ $book->author }}</dd></div>
                    <div><dt class="font-semibold">Kategori</dt>
                        <dd>{{ $book->category?->name ?? 'Belum ada kategori' }}</dd></div>
                    <div><dt class="font-semibold">Tahun</dt><dd>{{ $book->year }}</dd></div>
                    <div><dt class="font-semibold">Stok</dt><dd>{{ $book->stock }}</dd></div>
                    <div><dt class="font-semibold">ISBN</dt><dd>{{ $book->isbn ?? '-' }}</dd></div>
                </dl>
                <div class="mt-6 flex justify-center gap-3">
                    <a href="{{ route('books.index') }}" class="rounded-md bg-gray-200 px-4 py-2 text-gray-800">Kembali</a>
                    <a href="{{ route('books.edit', $book) }}" class="rounded-md bg-yellow-500 px-4 py-2 text-white">Edit</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>