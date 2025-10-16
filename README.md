# Sistem Informasi Manajemen Anggota & Berita HIMPESDA

Aplikasi web full-stack yang dibangun menggunakan Laravel untuk mengelola keanggotaan, berita, dan informasi organisasi HIMPESDA. Aplikasi ini memiliki dua bagian utama: halaman publik informatif untuk pengunjung dan dasbor admin yang aman untuk manajemen data.

---

## ✨ Fitur Utama

### Halaman Publik (User View)
- **Beranda Dinamis:** Menampilkan profil singkat dan berita terbaru langsung dari database.
- **Halaman Profil:** Halaman terpisah untuk Sejarah, Visi & Misi, dan Struktur Organisasi yang datanya dikelola dari dasbor.
- **Arsip Berita:** Daftar semua berita dengan sistem paginasi.
- **Detail Berita:** Halaman khusus untuk membaca isi lengkap setiap artikel.
- **Formulir Pendaftaran:** Form permohonan keanggotaan dengan validasi dan upload file bukti pembayaran.

### Sistem Autentikasi
- Dibangun di atas **Laravel Breeze** untuk keamanan dan kelengkapan.
- Halaman Login, Register, dan Lupa Password yang fungsional.
- Verifikasi email dan proteksi route.

### Dasbor Admin (Admin View)
- **Dasbor Utama:** Menampilkan statistik anggota dan organisasi dalam bentuk grafik (Chart.js).
- **Manajemen Anggota:**
    - Menampilkan daftar anggota aktif dengan tabel interaktif (DataTables.net).
    - Fitur **Import Anggota** dari file Excel.
    - Halaman detail untuk setiap anggota.
    - Fitur Cetak Kartu Tanda Anggota (KTA) dengan desain vertikal.
- **Manajemen Berita (CRUD):**
    - Fungsionalitas penuh untuk Tambah, Edit, dan Hapus berita.
    - Tampilan berita disesuaikan berdasarkan hak akses pengguna.
- **Verifikasi Pendaftar:** Halaman khusus untuk admin/bendahara mengonfirmasi pendaftar baru dan mempromosikannya menjadi anggota aktif.
- **Manajemen Profil & Organisasi:**
    - Halaman khusus untuk admin mengedit profil pribadinya.
    - Halaman khusus untuk admin mengedit informasi utama organisasi.
- **Hak Akses Berbasis Peran (Role-Based Access):**
    - **Admin:** Akses penuh ke semua fitur.
    - **Operator:** Bisa mengelola berita.
    - **Bendahara:** Bisa mengakses konfirmasi pembayaran dan mengelola beritanya sendiri.
    - **Anggota:** Hanya bisa melihat beritanya sendiri di dasbor.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP 8.x, Laravel 11.x
* **Frontend:** Tailwind CSS, Alpine.js (bawaan Breeze), JavaScript
* **Database:** MySQL (dijalankan melalui Laragon)
* **Package Utama:**
    * `laravel/breeze`: Untuk sistem autentikasi.
    * `maatwebsite/excel`: Untuk fungsionalitas Import Excel.
    * `yajra/laravel-datatables-oracle`: Untuk tabel interaktif (opsional, telah diganti ke client-side).

---

## 🚀 Instalasi & Konfigurasi Lokal

Berikut adalah panduan untuk menjalankan proyek ini di lingkungan lokal menggunakan **Laragon**.

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/akhmdrdlo/himpesda_web.git himpesda-web
    cd himpesda-web
    ```

2.  **Install Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Siapkan File Environment**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    copy .env.example .env
    ```

4.  **Generate Application Key**
    Ini adalah langkah wajib untuk semua aplikasi Laravel.
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    * Buka Laragon dan klik tombol **"Database"** untuk membuka HeidiSQL/phpMyAdmin.
    * Buat database baru dengan nama `db_himpesda`.
    * Buka file `.env` dan sesuaikan konfigurasi database:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=db_himpesda
        DB_USERNAME=root
        DB_PASSWORD=
        ```

6.  **Jalankan Migrasi & Seeder**
    Perintah ini akan membuat semua tabel dan mengisinya dengan data awal.
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Buat Storage Link**
    Penting untuk membuat gambar yang di-upload bisa diakses publik.
    ```bash
    php artisan storage:link
    ```

8.  **Install Dependensi & Compile Aset Frontend**
    ```bash
    npm install
    npm run build
    npm run dev
    ```

9. **Jalankan Aplikasi**
    Buka Laragon, pastikan Apache dan MySQL berjalan. Akses proyek melalui URL yang dibuat otomatis:
    **http://himpesda-web.test**

---

## 🔑 Akun Default

Setelah menjalankan seeder, Anda bisa login menggunakan akun berikut:

* **Admin:**
    * **Email:** `admin@himpesda.org`
    * **Password:** `password`
* **Operator:**
    * **Email:** `operator@himpesda.org`
    * **Password:** `password`
* **Bendahara:**
    * **Email:** `bendahara@himpesda.org`
    * **Password:** `password`
