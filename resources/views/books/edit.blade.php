<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Buku</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data"
                class="bg-white shadow-sm sm:rounded-lg p-6">
                @csrf
                @method('PUT')
                @include('books._form')
                <div class="mt-6 flex items-center gap-3">
                    <x-primary-button>Perbarui</x-primary-button>
                    <a href="{{ route('books.index') }}" class="text-gray-600">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>