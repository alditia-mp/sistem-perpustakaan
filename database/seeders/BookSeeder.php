<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'category' => 'Pemrograman',
                'title' => 'Dasar-Dasar Pemrograman',
                'author' => 'Abdul Kadir',
                'year' => 2022,
                'stock' => 10,
                'isbn' => '9786020000001',
            ],
            [
                'category' => 'Teknologi Informasi',
                'title' => 'Pengantar Sistem Informasi',
                'author' => 'Tata Sutabri',
                'year' => 2021,
                'stock' => 8,
                'isbn' => '9786020000002',
            ],
            [
                'category' => 'Basis Data',
                'title' => 'Konsep Sistem Basis Data',
                'author' => 'Edhy Sutanta',
                'year' => 2020,
                'stock' => 7,
                'isbn' => '9786020000003',
            ],
            [
                'category' => 'Pemrograman',
                'title' => 'Belajar Web dengan Laravel',
                'author' => 'Tim Perpustakaan',
                'year' => 2024,
                'stock' => 5,
                'isbn' => '9786020000004',
            ],
            [
                'category' => 'Teknologi Informasi',
                'title' => 'Pengantar Data Analytics',
                'author' => 'Tim Perpustakaan',
                'year' => 2023,
                'stock' => 6,
                'isbn' => '9786020000005',
            ],
        ];

        foreach ($books as $item) {
            $categoryName = $item['category'];
            $slug = Str::slug($categoryName);

            $category = Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => $categoryName]
            );

            Book::firstOrCreate(
                ['isbn' => $item['isbn']],
                [
                    'category_id' => $category->id,
                    'title' => $item['title'],
                    'author' => $item['author'],
                    'year' => $item['year'],
                    'stock' => $item['stock'],
                ]
            );
        }
    }
}
