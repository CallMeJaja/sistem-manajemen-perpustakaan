# Instalasi & Setup Lokal — GramediKu

Dokumen ini menjelaskan cara menjalankan proyek GramediKu di komputer lokal Anda setelah clone dari repository GitHub.  
Target: developer, mahasiswa, atau siapa pun yang ingin menjalankan aplikasi ini secara lokal.

---

## Daftar Isi

- [Persyaratan Sistem (Prerequisites)](#persyaratan-sistem-prerequisites)
- [Opsi 1: Menggunakan DDEV (Direkomendasikan)](#opsi-1-menggunakan-ddev-direkomendasikan)
- [Opsi 2: Setup Manual (Tanpa DDEV)](#opsi-2-setup-manual-tanpa-ddev)
- [Verifikasi Instalasi](#verifikasi-instalasi)
- [Akun Default](#akun-default)
- [Troubleshooting (Masalah Umum)](#troubleshooting-masalah-umum)
- [Struktur Folder Penting](#struktur-folder-penting)

---

## Persyaratan Sistem (Prerequisites)

### Untuk DDEV (Opsional, Direkomendasikan)

- [DDEV](https://ddev.readthedocs.io/en/stable/users/install/) — minimal versi 1.23+
- Docker (diinstal otomatis oleh DDEV di Linux; di macOS pakai OrbStack/Docker Desktop)

### Untuk Setup Manual

- **PHP** >= 8.2 (dengan ekstensi: `mbstring`, `xml`, `pdo`, `pdo_mysql`, `fileinfo`, `gd`)
- **Composer** >= 2.0
- **Node.js** >= 18 & **NPM**
- **MariaDB** >= 10.4 atau **MySQL** >= 8.0

---

## Opsi 1: Menggunakan DDEV (Direkomendasikan)

DDEV akan otomatis mengonfigurasi PHP 8.4, MariaDB 11.8, dan Nginx dalam container Docker. Tidak perlu install PHP/MySQL manual.

### 1. Clone Repository

```bash
git clone https://github.com/username/sistem-manajemen-perpustakaan.git
cd sistem-manajemen-perpustakaan
```

### 2. Mulai DDEV

```bash
ddev start
```

DDEV akan membaca konfigurasi dari `.ddev/config.yaml` dan membuat container.

### 3. Install PHP Dependencies

```bash
ddev composer install
```

### 4. Install JavaScript Dependencies

```bash
ddev npm install
```

### 5. Build Frontend Assets

```bash
ddev npm run build
```

### 6. Jalankan Migrasi & Seeder

```bash
ddev artisan migrate --seed
```

### 7. Akses Aplikasi

- **URL utama:** `https://sistem-manajemen-perpustakaan.ddev.site`
- **Mailpit (email testing):** `https://sistem-manajemen-perpustakaan.ddev.site:8026`  
  (Verifikasi email akan masuk ke Mailpit saat development. Cek inbox di Mailpit untuk melihat email verifikasi.)

---

## Opsi 2: Setup Manual (Tanpa DDEV)

### 1. Clone Repository

```bash
git clone https://github.com/username/sistem-manajemen-perpustakaan.git
cd sistem-manajemen-perpustakaan
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` sesuai database lokal Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `perpustakaan` di MySQL/MariaDB Anda terlebih dahulu.

### 5. Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

### 6. Buat Storage Symlink

```bash
php artisan storage:link
```

Symlink ini memetakan `public/storage` ke `storage/app/public/` — diperlukan agar cover buku dapat ditampilkan di browser.

### 7. Install JavaScript Dependencies

```bash
npm install
```

### 8. Build Frontend Assets

```bash
npm run build
```

### 9. Mulai Development Server

```bash
php artisan serve
```

### 10. Akses Aplikasi

Buka browser: `http://localhost:8000`

---

## Verifikasi Instalasi

Setelah instalasi berhasil, Anda dapat login menggunakan akun default (lihat di bawah).

**Hal yang perlu dicek:**
1. Halaman katalog (`/catalog`) — menampilkan 25 buku dengan cover thumbnail.
2. Login admin — Dashboard menampilkan statistik.
3. Login member demo — Portal anggota muncul.
4. Cover buku tampil (bukan icon placeholder). Jika tidak tampil, periksa `php artisan storage:link`.

---

## Akun Default

| Role    | Email                   | Password   | Catatan                    |
|---------|--------------------------|------------|----------------------------|
| Admin   | `admin@perpustakaan.com` | `password` | Sudah terverifikasi + disetujui |
| Anggota | `member@perpustakaan.com`| `password` | Sudah terverifikasi + disetujui, bisa akses portal |

**Akun tambahan untuk testing reservasi:**
- `salman.alfaridzi@email.com` / `password` — punya reservasi pending (Cosmos)
- `reza.asriano.maulana@email.com` / `password` — punya reservasi pending (Python Crash Course)

---

## Troubleshooting (Masalah Umum)

### "Specified key was too long" saat migrate

Tambahkan ke `config/database.php` (MySQL connection):
```php
'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',
```
Atau gunakan MariaDB (yang sudah dikonfigurasi DDEV).

### Cover buku tidak muncul

1. Pastikan sudah menjalankan `php artisan storage:link`.
2. Periksa `public/storage/` — harus ada symlink ke `storage/app/public/`.
3. Jika tetap tidak muncul: `rm -rf public/storage && php artisan storage:link`.

### "Connection refused" ke database

1. Pastikan MySQL/MariaDB berjalan (`sudo service mysql start`).
2. Periksa kredensial di `.env`.
3. Pastikan database `perpustakaan` sudah dibuat.

### Port 8000 sudah dipakai

Jalankan artisan serve di port lain:
```bash
php artisan serve --port=8001
```

### DDEV: "bind: address already in use"

Port 80 atau 443 mungkin dipakai. Edit `.ddev/config.yaml`:
```yaml
web_extra_exposed_ports:
  - name: http
    container_port: 80
    http_port: 8080
    https_port: 8443
```

### Email verifikasi tidak muncul di Mailpit

1. Buka `https://sistem-manajemen-perpustakaan.ddev.site:8026`.
2. Cek tab **"Messages"** — email sistem akan masuk ke sini (development mode).
3. Jika kosong, coba registrasi ulang atau klik "Kirim Ulang" di `/verify-email`.

### "Akun Anda masih menunggu persetujuan admin"

Registrasi member baru sekarang melalui 3 tahap:
1. Registrasi → verifikasi email
2. Verifikasi email → status "Pending" (menunggu admin)
3. Admin approve → akun aktif

Untuk testing, login sebagai **admin** lalu buka **Manajemen Anggota**, cari anggota Anda, klik tombol centang hijau untuk approve.

---

## Struktur Folder Penting

```
sistem-manajemen-perpustakaan/
├── app/                  # Controllers, Models, Middleware
├── config/               # Konfigurasi aplikasi (database, auth, etc.)
├── database/
│   ├── migrations/       # Skema database
│   └── seeders/          # Data awal (admin, books, members, borrowings)
├── public/               # Web root (index.php, assets)
├── resources/views/      # Template Blade
├── routes/web.php        # Routing web
├── storage/
│   └── app/public/covers/# Cover buku (25 file .jpg)
├── .ddev/                # Konfigurasi DDEV
├── .env.example          # Template environment file
├── composer.json         # PHP dependencies
├── package.json          # JS dependencies
└── README.md             # Dokumentasi utama
```