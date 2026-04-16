# Modul Aplikasi Aii Library

## 1. Gambaran Umum

Aii Library adalah aplikasi web perpustakaan sederhana berbasis Laravel yang digunakan untuk mengelola proses peminjaman buku secara digital. Aplikasi ini memisahkan hak akses menjadi dua peran utama, yaitu `admin` dan `user`.

Secara umum, aplikasi ini digunakan untuk:

- melakukan login ke sistem,
- melihat dashboard sesuai peran pengguna,
- menampilkan daftar buku yang tersedia,
- mengajukan peminjaman buku,
- memproses persetujuan peminjaman oleh admin,
- melakukan pengembalian buku,
- menampilkan profil dan riwayat aktivitas pengguna.

## 2. Tujuan Aplikasi

Tujuan dari aplikasi ini adalah membantu proses peminjaman buku menjadi lebih teratur, mudah dipantau, dan lebih efisien dibanding pencatatan manual. Sistem ini juga membantu admin memeriksa permintaan peminjaman dan membantu pengguna melihat status pinjaman mereka secara langsung.

## 3. Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan:

- Laravel sebagai framework utama,
- PHP untuk logika backend,
- Blade untuk tampilan halaman,
- Bootstrap untuk antarmuka,
- MySQL atau database relasional lain yang didukung Laravel untuk penyimpanan data,
- session sebagai penyimpanan status login pengguna.

## 4. Peran Pengguna

### Admin

Admin memiliki akses untuk:

- melihat dashboard admin,
- melihat seluruh data peminjaman,
- menyetujui atau menolak permintaan peminjaman,
- menambah data buku,
- mengubah data buku,
- menghapus data buku.

### User

User memiliki akses untuk:

- login ke aplikasi,
- melihat dashboard pengguna,
- melihat daftar buku,
- mengajukan peminjaman buku,
- mengembalikan buku yang sedang dipinjam,
- melihat profil dan riwayat peminjaman pribadi.

## 5. Modul Utama Aplikasi

### 5.1 Modul Login

Modul login digunakan sebagai pintu masuk ke aplikasi. Pengguna memasukkan email dan password, lalu sistem akan memeriksa data pengguna pada tabel `users`.

Jika data benar:

- sistem membuat session pengguna,
- sistem menyimpan informasi `id`, `name`, `email`, dan `role`,
- pengguna diarahkan ke halaman dashboard.

Jika data salah:

- sistem menampilkan pesan kesalahan login.

Selain login, pada backend juga tersedia proses registrasi user baru. User yang mendaftar akan otomatis memiliki peran `user`.

## 6. Modul Dashboard

Setelah berhasil login, pengguna akan diarahkan ke dashboard.

### Dashboard User

Dashboard user menampilkan ringkasan:

- total buku,
- jumlah peminjaman yang masih `pending`,
- jumlah peminjaman aktif yang sudah `approved` tetapi belum dikembalikan.

Dashboard user juga menyediakan akses cepat ke:

- halaman peminjaman,
- halaman pengembalian,
- halaman profil.

### Dashboard Admin

Dashboard admin menampilkan ringkasan:

- total buku,
- jumlah permintaan peminjaman yang menunggu persetujuan.

Dashboard admin juga menyediakan akses cepat ke:

- kelola buku,
- kelola peminjaman,
- profil.

## 7. Modul Buku

Modul buku berfungsi untuk menampilkan koleksi buku yang tersedia di perpustakaan.

Data buku yang digunakan meliputi:

- judul buku,
- pengarang,
- penerbit,
- tahun terbit,
- stok,
- kategori.

### Pada sisi user

User hanya dapat melihat daftar buku yang tersedia beserta informasi stok dan kategori. Dari halaman ini user dapat melanjutkan ke proses pengajuan peminjaman.

### Pada sisi admin

Admin dapat mengelola data buku melalui fitur:

- tambah buku,
- edit buku,
- hapus buku.

Saat admin menambahkan atau mengubah buku, sistem melakukan validasi pada semua data penting seperti judul, pengarang, penerbit, tahun, stok, dan kategori.

## 8. Modul Peminjaman

Modul peminjaman digunakan oleh user untuk mengajukan permintaan pinjam buku.

Langkah prosesnya adalah:

1. User membuka halaman peminjaman.
2. Sistem menampilkan daftar buku yang stoknya masih lebih dari nol.
3. User memilih buku, tanggal pinjam, dan tanggal jatuh tempo.
4. Sistem menyimpan data peminjaman ke tabel `loans`.
5. Status awal peminjaman disimpan sebagai `pending`.
6. Permintaan tersebut menunggu pemeriksaan admin.

Pada saat user mengajukan peminjaman:

- data `user_id` diambil dari session login,
- data `loaned_at` dan `due_at` juga disimpan agar waktu pinjam dan jatuh tempo tercatat lebih lengkap,
- stok buku belum langsung berkurang pada tahap pengajuan.

## 9. Modul Persetujuan Peminjaman oleh Admin

Setelah ada permintaan dari user, admin dapat membuka halaman kelola peminjaman.

Di halaman ini admin dapat melihat:

- data user peminjam,
- data buku yang dipinjam,
- tanggal pinjam,
- tanggal jatuh tempo,
- status peminjaman.

Admin memiliki dua tindakan:

- `approve` untuk menyetujui peminjaman,
- `reject` untuk menolak peminjaman.

Jika admin menyetujui:

- status berubah menjadi `approved`,
- stok buku berkurang satu.

Jika admin menolak:

- status berubah menjadi `rejected`,
- stok buku tidak berubah.

Peminjaman yang sudah pernah diproses tidak dapat diproses ulang melalui alur ini.

## 10. Modul Pengembalian

Modul pengembalian digunakan oleh user untuk mengembalikan buku yang sudah disetujui admin dan masih aktif dipinjam.

Alurnya adalah:

1. User membuka halaman pengembalian.
2. Sistem menampilkan daftar pinjaman aktif milik user.
3. User menekan tombol pengembalian.
4. Sistem memeriksa apakah data pinjaman tersebut benar-benar milik user, sudah berstatus `approved`, dan belum pernah dikembalikan.
5. Sistem mengisi waktu pengembalian.
6. Sistem menghitung denda jika terlambat.
7. Sistem menambah kembali stok buku.

Denda dihitung dengan aturan:

- keterlambatan dihitung berdasarkan selisih hari dari `due_at`,
- denda sebesar `Rp 1.000` per hari keterlambatan.

Jika tidak terlambat, denda bernilai `0`.

## 11. Modul Profil

Modul profil menampilkan informasi akun pengguna yang sedang login.

Informasi yang ditampilkan meliputi:

- nama,
- email,
- role,
- tanggal bergabung.

Selain itu, halaman profil juga menampilkan ringkasan aktivitas:

- total peminjaman,
- jumlah peminjaman pending,
- jumlah peminjaman aktif,
- jumlah peminjaman yang sudah selesai.

Di bagian bawah profil terdapat riwayat peminjaman terakhir agar pengguna dapat melihat aktivitas terbaru mereka.

## 12. Alur Keseluruhan Sistem

Berikut alur utama aplikasi dari awal sampai akhir:

1. Pengguna membuka aplikasi.
2. Jika belum login, pengguna diarahkan ke halaman login.
3. Setelah login berhasil, sistem menyimpan session pengguna.
4. Pengguna masuk ke dashboard sesuai role.
5. User melihat daftar buku lalu mengajukan peminjaman.
6. Sistem menyimpan permintaan dengan status `pending`.
7. Admin membuka halaman kelola peminjaman.
8. Admin menyetujui atau menolak permintaan.
9. Jika disetujui, stok buku berkurang dan pinjaman menjadi aktif.
10. User membuka halaman pengembalian saat ingin mengembalikan buku.
11. Sistem menghitung denda bila terlambat dan menambah stok buku kembali.
12. Riwayat peminjaman user tetap dapat dilihat di halaman profil.

## 13. Struktur Data Utama

Beberapa data utama yang dipakai pada alur aplikasi saat ini adalah:

### Tabel `users`

Menyimpan data akun pengguna:

- nama,
- email,
- password,
- role.

### Tabel `books`

Menyimpan data buku:

- title,
- author,
- publisher,
- year,
- stock,
- category.

### Tabel `loans`

Menyimpan data transaksi peminjaman:

- book_id,
- user_id,
- loan_date,
- loaned_at,
- due_date,
- due_at,
- return_date,
- returned_at,
- fine,
- status.

## 14. Keamanan Akses

Aplikasi ini menggunakan middleware untuk membatasi akses:

- `AuthSessionMiddleware` memastikan hanya pengguna yang sudah login yang bisa masuk ke halaman utama,
- `RoleMiddleware` memastikan hanya admin yang bisa masuk ke area admin.

Dengan cara ini, halaman admin tidak dapat diakses oleh user biasa.

## 15. Catatan Penting dari Project Saat Ini

Penjelasan modul ini disusun berdasarkan alur yang aktif pada route utama aplikasi saat ini.

Di dalam project memang masih terdapat file `MemberController`, `LoanController`, model `Member`, dan beberapa view tambahan untuk CRUD anggota atau peminjaman versi lain. Namun, bagian tersebut tidak menjadi alur utama yang sedang dipakai oleh route web aktif sekarang. Karena itu, modul ini difokuskan pada fitur yang benar-benar berjalan pada aplikasi utama Aii Library saat ini.

## 16. Kesimpulan

Aii Library adalah aplikasi perpustakaan sederhana dengan alur kerja yang jelas. User dapat login, melihat buku, mengajukan peminjaman, dan mengembalikan buku. Admin dapat mengelola buku serta memverifikasi peminjaman. Dengan pembagian peran ini, proses peminjaman menjadi lebih tertata, stok buku lebih mudah dipantau, dan aktivitas pengguna dapat dilihat dengan lebih rapi.
