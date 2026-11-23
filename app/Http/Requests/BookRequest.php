<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],

            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books', 'title')->ignore($this->route('book')),
            ],

            'author' => ['required', 'string', 'max:255'],

            'year' => [
                'required',
                'integer',
                'min:1000',
                'max:' . date('Y'),
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],

            'isbn' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('books', 'isbn')->ignore($this->route('book')),
            ],

            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'title.required' => 'Judul wajib diisi.',
            'author.required' => 'Penulis wajib diisi.',
            'year.required' => 'Tahun terbit wajib diisi.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.max' => 'Stok buku maksimal 9999.',
            'isbn.unique' => 'ISBN sudah terdaftar.',
            'cover.image' => 'Cover harus berupa gambar.',
            'cover.mimes' => 'Format cover hanya boleh JPG, JPEG, PNG, atau WEBP.',
            'cover.max' => 'Ukuran cover maksimal 2 MB.',
        ];
    }
}
