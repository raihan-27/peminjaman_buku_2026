<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Member;
use App\Models\Loan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // User
User::create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => bcrypt('user'),
            'role' => 'user',
        ]);

        // Books - User provided + extras
        $userBooks = [
            // History Of The World War
            ['title' => 'History Of The World War, Sejarah Perang Dunia', 'author' => 'Saut Pasaribu', 'publisher' => 'Alexander Books', 'year' => 2020, 'stock' => 5, 'category' => 'Sejarah'],
            // Nineteenth Century Questions
            ['title' => 'Nineteenth Century Questions Sejarah Dunia Abad Ke-19', 'author' => 'James Freeman Clarke', 'publisher' => 'Indoliterasi', 'year' => 2022, 'stock' => 8, 'category' => 'Sejarah'],
            // Menjadi Istri Bahagia
            ['title' => 'Menjadi Istri Bahagia dan Membahagiakan Keluarga', 'author' => 'Jumriyah, M.Pd.I.', 'publisher' => 'Silda Impika', 'year' => 2024, 'stock' => 10, 'category' => 'Keluarga'],
            // Learn English Practically
            ['title' => 'Learn English Practically', 'author' => 'Dionisius Hargen', 'publisher' => 'Silda Impika', 'year' => 2024, 'stock' => 7, 'category' => 'Bahasa'],
            // Adab Di Atas Ilmu 5
            ['title' => 'Adab Di Atas Ilmu 5', 'author' => 'Syekh Ibnu Jama\'ah', 'publisher' => 'Diva Press', 'year' => 2024, 'stock' => 6, 'category' => 'Agama'],
            // Keutamaan Umat Nabi Muhammad Saw
            ['title' => 'Keutamaan-Keutamaan Umat Nabi Muhammad Saw', 'author' => 'Sayyid Muhammad Alawi Al-Maliki', 'publisher' => 'Diva Press', 'year' => 2022, 'stock' => 12, 'category' => 'Agama'],
            // Bangun Brandmu Sendiri
            ['title' => 'Bangun Brandmu Sendiri; Strategi Jitu Membangun Brand di Era Digital', 'author' => 'Galih F.H.', 'publisher' => 'Silda Impika', 'year' => 2024, 'stock' => 9, 'category' => 'Bisnis'],
            // Seni Mengatur Keuangan
            ['title' => 'Seni Mengatur Keuangan; Bebas Finansial di Usia Muda', 'author' => 'G. S. Perkasa', 'publisher' => 'Silda Impika', 'year' => 2024, 'stock' => 11, 'category' => 'Keuangan'],
            // 20 Peristiwa Penting
            ['title' => '20 Peristiwa Penting yang Mengubah Dunia', 'author' => 'Toha Amar', 'publisher' => 'Silda Impika', 'year' => 2024, 'stock' => 8, 'category' => 'Sejarah'],
            // Jejak Festival
            ['title' => 'Jejak Festival; Menyusuri Tradisi dan Kemeriahan Dunia', 'author' => 'E. Kasiana', 'publisher' => 'Tirta Buana Media', 'year' => 2025, 'stock' => 4, 'category' => 'Budaya'],
            // Suara Gen Z
            ['title' => 'Suara Gen Z Suara Ilahi', 'author' => 'Tim Society 5.0', 'publisher' => 'Silda Impika', 'year' => 2024, 'stock' => 15, 'category' => 'Motivasi'],
            // Buku Pintar Berorganisasi
            ['title' => 'Buku Pintar Berorganisasi untuk Remaja', 'author' => 'T. Utami', 'publisher' => 'Gema Buku', 'year' => 2025, 'stock' => 6, 'category' => 'Pendidikan'],
            ['title' => 'Mengenal Dunia Melalui Peta', 'author' => 'R. S. Putra', 'publisher' => 'Silda Impika', 'year' => 2024, 'stock' => 7, 'category' => 'Geografi'],
        ];

        foreach ($userBooks as $data) {
            Book::create($data);
        }

        // Additional sample books
        $extraBooks = [
            ['title' => 'Laravel Documentation', 'author' => 'Taylor Otwell', 'publisher' => 'Laravel LLC', 'year' => 2024, 'stock' => 3, 'category' => 'Teknologi'],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'publisher' => 'Prentice Hall', 'year' => 2008, 'stock' => 5, 'category' => 'Teknologi'],
        ];

        foreach ($extraBooks as $data) {
            Book::create($data);
        }

        $this->call(ImageSeeder::class);

        // Members
        $members = [
            ['name' => 'Ahmad Rahman', 'address' => 'Jl. Sudirman 123, Jakarta', 'phone' => '081234567890'],
            ['name' => 'Siti Nurhaliza', 'address' => 'Jl. Thamrin 456, Bandung', 'phone' => '081234567891'],
            ['name' => 'Budi Santoso', 'address' => 'Jl. Malioboro 789, Yogyakarta', 'phone' => '081234567892'],
            ['name' => 'Indah Permata', 'address' => 'Jl. Diponegoro 321, Semarang', 'phone' => '081234567893'],
            ['name' => 'Rudi Hartono', 'address' => 'Jl. Gatot Subroto 654, Surabaya', 'phone' => '081234567894'],
        ];

        foreach ($members as $data) {
            Member::create($data);
        }

        // Sample Loans (after books & members exist)
        $books = Book::all();
        $membersList = Member::all();

    }
}
