# Sewa Kos - Aplikasi Manajemen Kos

Aplikasi manajemen dan penyewaan kamar kos berbasis Laravel. Proyek ini mempermudah pemilik kos (Admin), petugas operasional (Pegawai), dan penyewa (Penyewa) dalam melakukan transaksi, pelaporan keluhan, pelayanan, dan administrasi harian.

---

## 👥 Peran Pengguna (User Roles)

Aplikasi memiliki 3 peran pengguna utama yang diatur dalam database:

### 1. Admin
*   **Dashboard Utama**: Statistik keuangan, properti, pesanan, dan pengguna.
*   **Manajemen Properti**: CRUD kamar dan tipe kamar kos.
*   **Manajemen Layanan**: CRUD layanan tambahan (Catering, Laundry, Cleaning Service).
*   **Manajemen Akun**: CRUD data pengguna (Penyewa dan Pegawai).
*   **Penugasan Layanan (Assign Task)**: Mendelegasikan pemesanan layanan tambahan dari penyewa ke Pegawai operasional.
*   **Laporan Masalah**: Memverifikasi dan meneruskan keluhan fasilitas dari penyewa ke Pegawai pelaksana.

### 2. Pegawai (Staf Operasional) `[NEW]`
*   **Dashboard Analitik**: Melihat rangkuman tugas aktif dan laporan kerusakan yang didelegasikan.
*   **Tugas Layanan (My Tasks)**:
    *   Melihat daftar pesanan layanan tambahan kamar (laundry, catering, dll) yang harus dikerjakan.
    *   Filter status pekerjaan (Semua, Belum Dikerjakan, Sedang Dikerjakan, Selesai).
    *   Mengubah status tugas secara real-time (`Mulai` / `Selesai`).
*   **Laporan Kerusakan (Maintenance Requests)**:
    *   Melihat komplain kerusakan fasilitas kamar yang ditugaskan oleh Admin.
    *   Melihat detail keluhan, lokasi kamar, pelapor, dan foto bukti masalah (dengan popup zoomable modal).
    *   Filter status komplain.
    *   Mengubah status penanganan kerusakan (`Proses` / `Selesai`).
*   **Profil Saya**: Memperbarui informasi personal pegawai (Nama, Email, No. HP, Jenis Kelamin, Tanggal Lahir) serta opsi mengganti kata sandi.

### 3. Penyewa
*   **Eksplorasi Kamar**: Pencarian dan filter kamar berdasarkan fasilitas atau harga.
*   **Pemesanan**: Reservasi kamar kos online dengan opsi integrasi pembayaran Midtrans.
*   **Keluhan (Report)**: Mengajukan komplain kerusakan fasilitas kamar dengan deskripsi dan foto bukti.
*   **Layanan Tambahan**: Menambahkan pemesanan catering, laundry, atau cleaning service ke kamar.
*   **Profil & Verifikasi**: Mengunggah foto KTP dan selfie untuk verifikasi identitas (KYC).

---

## 🛠️ Tech Stack & Integrasi

*   **Backend**: Laravel 12 (PHP 8.4)
*   **Frontend**: Blade Templates, Tailwind CSS (via CDN), Font Awesome 6
*   **Database**: SQLite / MySQL (dengan Eloquent ORM & Query Scopes)
*   **Pembayaran**: Midtrans Payment Gateway integration
*   **Testing**: Pest Framework / PHPUnit

---

## 🚀 Cara Menjalankan Project & Seeder Pegawai

1.  **Clone repositori & Install dependensi**:
    ```bash
    git clone https://github.com/mraynar/sewa-kos.git
    cd sewa-kos
    composer install
    npm install
    ```

2.  **Konfigurasi Environment**:
    Salin file `.env.example` ke `.env` dan konfigurasikan database serta kredensial Midtrans Anda.

3.  **Migrasi & Seed Awal**:
    ```bash
    php artisan migrate --seed
    ```

4.  **Seed Data Demo Pegawai Baru**:
    Jalankan seeder khusus untuk membuat 2 akun staf pegawai operasional baru untuk uji coba:
    ```bash
    php artisan db:seed --class=PegawaiSeeder
    ```
    Akun demo pegawai yang dibuat:
    *   **Pegawai 1**: `budi@gmail.com` (password: `password`)
    *   **Pegawai 2**: `ani@gmail.com` (password: `password`)

5.  **Jalankan Server Lokal**:
    ```bash
    php artisan serve
    npm run dev
    ```

---

## 🧪 Pengujian (Testing)

Jalankan rangkaian pengujian otomatis dengan Pest/PHPUnit menggunakan perintah:
```bash
php artisan test
```
