# RuangHub - Room Booking System

RuangHub adalah aplikasi berbasis web untuk mengelola pemesanan ruang meeting/ruang kerja di perusahaan, dibangun dengan arsitektur MVC menggunakan **Laravel 11**, **Tailwind CSS**, dan **Alpine.js**.

## Fitur Utama
- **Role-based Access Control**: Admin, Approver, Karyawan.
- **Manajemen Ruangan & User**: CRUD master data.
- **Sistem Booking & Approval**: Validasi jadwal bentrok secara otomatis, approval berjenjang.
- **Check-in Ruangan**: Status penggunaan ruangan secara real-time.
- **Laporan & Statistik**: Dashboard interaktif dan opsi cetak laporan (PDF).

## Instalasi

1. **Clone repository ini** (jika belum):
   ```bash
   git clone <repo-url>
   cd ruanghub-app
   ```

2. **Install dependensi PHP dan Node.js**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   Pastikan sudah ada file `.env` (bisa di-copy dari `.env.example`). Konfigurasi kredensial database Anda (default menggunakan SQLite, atau sesuaikan ke MySQL).
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Jalankan Migrasi dan Seeder** (untuk membuat tabel dan mengisi data dummy):
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Build Aset Frontend**:
   ```bash
   npm run build
   ```

6. **Jalankan Development Server**:
   ```bash
   php artisan serve
   ```
   Akses aplikasi di `http://localhost:8000`.

## Akun Dummy (Seeder)

Anda dapat menggunakan akun berikut untuk mencoba fitur di masing-masing Role:

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@ruanghub.com` | `password` |
| **Approver** | `approver1@ruanghub.com` | `password` |
| **Karyawan** | `karyawan1@ruanghub.com` | `password` |

*(Terdapat juga karyawan2 s/d karyawan15, dan approver2, approver3)*
