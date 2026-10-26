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
            'title' => ['required', 'string', 'max:255', 'unique:books,title'],
            'author'      => ['required', 'string', 'max:255'],
            'year'        => ['required', 'integer', 'min:1000', 'max:' . date('Y')],
            'stock'       => ['required', 'integer', 'min:0'],
            'isbn'        => [
                'nullable', 'string', 'max:20',
                Rule::unique('books', 'isbn')->ignore($this->route('book')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'title.required'       => 'Judul wajib diisi.',
            'author.required'      => 'Penulis wajib diisi.',
            'year.required'        => 'Tahun terbit wajib diisi.',
            'stock.required'       => 'Stok wajib diisi.',
            'isbn.unique'          => 'ISBN sudah terdaftar.',
        ];
    }
}