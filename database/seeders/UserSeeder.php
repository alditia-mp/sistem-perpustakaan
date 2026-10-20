<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@perpus.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'petugas@perpus.test',
            'password' => bcrypt('password'),
            'role' => 'petugas',
        ]);
    }
}