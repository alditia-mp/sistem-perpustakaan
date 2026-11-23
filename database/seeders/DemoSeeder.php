<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Akun dan 5 buku dasar (idempotent, aman dipanggil ulang)
        $this->call([
            UserSeeder::class,
            BookSeeder::class,
        ]);

        if (DB::table('borrowings')->exists()) {
            $this->command->warn('Data peminjaman sudah ada. Jalankan migrate:fresh dulu kalau mau mengulang.');
            return;
        }

        $staff = User::where('email', 'petugas@perpus.test')->first();

        $category = fn (string $name) => Category::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name]
        );

        // 15 buku tambahan -> total 20 bersama BookSeeder
        $extraBooks = [
            ['Pemrograman', 'Algoritma Tanpa Drama', 'Rina Kusuma', 2023, 6],
            ['Pemrograman', 'PHP Modern untuk Pemula', 'Andi Wijaya', 2022, 7],
            ['Basis Data', 'SQL Itu Gampang Kok', 'Hendra Gunawan', 2021, 5],
            ['Basis Data', 'Desain Database yang Waras', 'Dimas Prakoso', 2020, 6],
            ['Fiksi', 'Misteri Kopi yang Menghilang', 'Laras Ayu', 2022, 8],
            ['Fiksi', 'Kucing yang Jadi Presiden', 'Nur Hidayah', 2024, 6],
            ['Fiksi', 'Cinta di Antara Rak Buku', 'Bayu Pratama', 2018, 5],
            ['Sejarah', 'Sejarah Singkat Nusantara', 'Prof. Wahyu', 2015, 7],
            ['Sejarah', 'Kerajaan yang Terlupakan', 'Sekar Wangi', 2014, 5],
            ['Sains', 'Fisika untuk yang Takut Fisika', 'Dr. Indra', 2020, 6],
            ['Sains', 'Astronomi Santai', 'Galih Permana', 2022, 8],
            ['Sains', 'Kimia di Dapur Ibu', 'Maya Sari', 2021, 5],
            ['Kuliner', 'Resep Mie Instan Level Dewa', 'Chef Anto', 2023, 7],
            ['Kuliner', 'Rahasia Sambal Nenek', 'Nenek Yati', 2016, 6],
            ['Kuliner', 'Nasi Goreng Seribu Rasa', 'Bu Tini', 2018, 5],
        ];

        foreach ($extraBooks as $i => [$cat, $title, $author, $year, $stock]) {
            Book::firstOrCreate(
                ['isbn' => '9786020001' . str_pad($i + 1, 3, '0', STR_PAD_LEFT)],
                [
                    'category_id' => $category($cat)->id,
                    'title'       => $title,
                    'author'      => $author,
                    'year'        => $year,
                    'stock'       => $stock,
                ]
            );
        }

        $books = Book::orderBy('id')->get()->values(); // 20 buku

        // 5 anggota
        $memberData = [
            ['Budi Santoso',    'budi@example.com',  '081234567801', 'Jl. Melati No. 1, Karawang'],
            ['Siti Rahmawati',  'siti@example.com',  '081234567802', 'Jl. Kenanga No. 7, Karawang'],
            ['Agus Kopi Pahit', 'agus@example.com',  '081234567803', 'Gg. Senja No. 3, Bekasi'],
            ['Dewi Anti Mager', 'dewi@example.com',  '081234567804', 'Jl. Sawo No. 12, Karawang'],
            ['Rizky Kucing',    'rizky@example.com', '081234567805', 'Perum Indah Blok C4, Cikampek'],
        ];

        $members = collect($memberData)->map(fn ($m) => Member::firstOrCreate(
            ['email' => $m[1]],
            ['name' => $m[0], 'phone' => $m[2], 'address' => $m[3]]
        ))->values();

        // 9 peminjaman: 3 lewat batas, 2 berjalan, 4 sudah kembali; 4 di antaranya berisi dua buku
        // ago = berapa hari lalu dipinjam, back = hari ke berapa dikembalikan (null = belum)
        $borrowings = [
            ['m' => 0, 'ago' => 20, 'back' => null, 'items' => [0 => 1, 1 => 1]],   // lewat batas, 2 buku
            ['m' => 1, 'ago' => 15, 'back' => null, 'items' => [2 => 1, 3 => 1]],   // lewat batas, 2 buku
            ['m' => 2, 'ago' => 12, 'back' => null, 'items' => [4 => 1]],            // lewat batas
            ['m' => 3, 'ago' => 5,  'back' => null, 'items' => [5 => 1, 6 => 1]],   // berjalan, 2 buku
            ['m' => 4, 'ago' => 2,  'back' => null, 'items' => [7 => 1]],            // berjalan
            ['m' => 0, 'ago' => 30, 'back' => 5,    'items' => [8 => 1, 9 => 1]],   // kembali, 2 buku
            ['m' => 1, 'ago' => 25, 'back' => 7,    'items' => [10 => 1]],           // kembali
            ['m' => 2, 'ago' => 18, 'back' => 4,    'items' => [11 => 1]],           // kembali
            ['m' => 3, 'ago' => 10, 'back' => 6,    'items' => [12 => 1]],           // kembali
        ];

        foreach ($borrowings as $row) {
            $borrowDate = Carbon::today()->subDays($row['ago']);
            $returned   = $row['back'] !== null;

            $borrowingId = DB::table('borrowings')->insertGetId([
                'user_id'     => $staff->id,
                'member_id'   => $members[$row['m']]->id,
                'borrow_date' => $borrowDate->toDateString(),
                'due_date'    => $borrowDate->copy()->addDays(7)->toDateString(),
                'return_date' => $returned ? $borrowDate->copy()->addDays($row['back'])->toDateString() : null,
                'status'      => $returned ? 'returned' : 'borrowed',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            foreach ($row['items'] as $bookIndex => $qty) {
                DB::table('borrowing_details')->insert([
                    'borrowing_id' => $borrowingId,
                    'book_id'      => $books[$bookIndex]->id,
                    'qty'          => $qty,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);

                // Stok berkurang hanya untuk buku yang belum dikembalikan
                if (! $returned) {
                    $books[$bookIndex]->decrement('stock', $qty);
                }
            }
        }
    }
}