<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buku</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('books.create') }}"
                   class="inline-block mb-4 px-4 py-2 bg-gray-800 text-white rounded">Tambah Buku</a>

                <table class="w-full text-left border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Judul</th>
                            <th class="p-2 border">Penulis</th>
                            <th class="p-2 border">Kategori</th>
                            <th class="p-2 border">Tahun</th>
                            <th class="p-2 border">Stok</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <td class="p-2 border">{{ $books->firstItem() + $loop->index }}</td>
                                <td class="p-2 border">{{ $book->title }}</td>
                                <td class="p-2 border">{{ $book->author }}</td>
                                <td class="p-2 border">{{ $book->category?->name ?? 'Belum ada kategori' }}</td>
                                <td class="p-2 border">{{ $book->year }}</td>
                                <td class="p-2 border">{{ $book->stock }}</td>
                                <td class="p-2 border">
                                    <a href="{{ route('books.show', $book) }}" class="text-blue-600 mr-3">Detail</a>
                                    <a href="{{ route('books.edit', $book) }}" class="text-yellow-600 mr-3">Edit</a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST"
                                          class="inline" onsubmit="return confirm('Hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="p-2 text-center">Belum ada buku.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $books->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>