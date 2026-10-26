<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kategori</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('categories.update', $category) }}" method="POST"
                  class="bg-white shadow-sm sm:rounded-lg p-6">
                @csrf
                @method('PUT')
                <div>
                    <x-input-label for="name" value="Nama Kategori" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                  :value="old('name', $category->name)" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mt-4 flex items-center gap-3">
                    <x-primary-button>Perbarui</x-primary-button>
                    <a href="{{ route('categories.index') }}" class="text-gray-600">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>