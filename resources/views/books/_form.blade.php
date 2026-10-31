<div>
    <x-input-label for="category_id" value="Kategori" />
    <select id="category_id" name="category_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        <option value="">-- Pilih kategori --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                @selected(old('category_id', $book->category_id ?? '') == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="title" value="Judul" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                  :value="old('title', $book->title ?? '')" />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="author" value="Penulis" />
    <x-text-input id="author" name="author" type="text" class="mt-1 block w-full"
                  :value="old('author', $book->author ?? '')" />
    <x-input-error :messages="$errors->get('author')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="year" value="Tahun Terbit" />
    <x-text-input id="year" name="year" type="number" class="mt-1 block w-full"
                  :value="old('year', $book->year ?? '')" />
    <x-input-error :messages="$errors->get('year')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="stock" value="Stok" />
    <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full"
                  :value="old('stock', $book->stock ?? 0)" />
    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="isbn" value="ISBN (opsional)" />
    <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full"
                  :value="old('isbn', $book->isbn ?? '')" />
    <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="cover" value="Cover Buku (opsional)" />
    <input id="cover" name="cover" type="file" accept="image/*" class="mt-1 block w-full">
    <x-input-error :messages="$errors->get('cover')" class="mt-2" />

    @if (!empty($book->cover))
        <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover saat ini" class="mt-2 h-24 rounded">
    @endif
</div>