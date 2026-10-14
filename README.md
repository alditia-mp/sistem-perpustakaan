# Sistem Informasi Perpustakaan Sederhana

Final Project mata kuliah **Pemrograman Web Framework (SYS61645)**  
Program Studi S1 Sistem Informasi  
Universitas Singaperbangsa Karawang

---

## 📖 Deskripsi

Aplikasi web sederhana untuk mengelola perpustakaan, dibangun menggunakan **Laravel** dengan menerapkan konsep MVC, authentication, authorization, dan CRUD.

**Aktor dalam sistem:**
- **Admin** — mengelola user, kategori, buku, anggota, dan transaksi peminjaman
- **Petugas** — mengelola buku, anggota, dan transaksi peminjaman

---

## ✨ Fitur

- [ ] Authentication (Login/Logout)
- [ ] Role: Admin & Petugas
- [ ] CRUD User
- [ ] CRUD Category
- [ ] CRUD Book
- [ ] CRUD Member
- [ ] Peminjaman & Pengembalian
- [ ] Dashboard Statistik

---

## 🛠️ Tech Stack

- **Framework**: Laravel
- **Bahasa**: PHP
- **Database**: MySQL
- **Frontend**: Blade + Tailwind CSS
- **Version Control**: Git & GitHub

---

## 🚀 Cara Install

```bash
git clone https://github.com/alditia-mp/sistem-perpustakaan.git
cd sistem-perpustakaan
composer install
cp .env.example .env
php artisan key:generate
# konfigurasi database di .env
php artisan migrate
php artisan serve