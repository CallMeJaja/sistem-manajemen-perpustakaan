# Kontribusi & Pengembangan — GramediKu

Dokumen ini merupakan panduan teknis untuk developer yang ingin berkontribusi atau mengembangkan fitur baru pada proyek GramediKu.

---

## Daftar Isi

- [Arsitektur Aplikasi](#arsitektur-aplikasi)
- [Struktur Proyek](#struktur-proyek)
- [Branching Strategy](#branching-strategy)
- [Coding Conventions](#coding-conventions)
- [Cara Menambah Fitur Baru](#cara-menambah-fitur-baru)
- [Form Request Validation](#form-request-validation)
- [Testing](#testing)
- [Build untuk Production](#build-untuk-production)
- [Deployment Notes](#deployment-notes)

---

## Arsitektur Aplikasi

GramediKu menggunakan arsitektur **MVC (Model-View-Controller)** pada framework Laravel 11.

### Alur Request

```
Browser (View) → HTTP Request → routes/web.php
    → Middleware (auth, admin/member, verified, approved)
    → Controller
    → Form Request (validasi)
    → Eloquent Model (ORM)
    → MariaDB (database)
    → Blade Template (response)
```

### Layer Middleware (Role-Based Access)

```
Public     → tanpa middleware
            Routes: /, /catalog, /catalog/{book}

Guest      → middleware: 'guest'
            Routes: /login, /register

Auth       → middleware: 'auth'
            Routes: /logout, /verify-email/*

Member     → middleware: ['auth', 'member', 'verified', 'approved']
            Routes: /member/dashboard, /member/borrowings, /member/profile, /catalog/{book}/reserve

Admin      → middleware: ['auth', 'admin']
            Routes: /dashboard, /books/*, /members/*, /borrowings/*
```

### Database Schema

5 tabel utama (relasi via FK):

- `users` — akun (admin/member) + status approval (`pending`, `approved`, `rejected`)
- `books` — koleksi buku dengan cover image
- `members` — data anggota perpustakaan
- `borrowings` — transaksi peminjaman
- `returns` — record pengembalian

---

## Struktur Proyek

```
sistem-manajemen-perpustakaan/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # 14 controller
│   │   │   ├── Auth/             # Auth\EmailVerificationPromptController, Auth\ResendVerificationEmailController, Auth\VerifyEmailController
│   │   │   ├── AuthController.php          # Login/logout + role-based redirect
│   │   │   ├── BookController.php          # CRUD buku + cover upload
│   │   │   ├── BookReturnController.php    # Pengembalian + kalkulasi denda
│   │   │   ├── BorrowingController.php     # Peminjaman + approve/reject reservasi
│   │   │   ├── CatalogController.php       # Katalog publik
│   │   │   ├── Controller.php              # Base controller
│   │   │   ├── DashboardController.php     # Dashboard admin + statistik
│   │   │   ├── MemberController.php        # CRUD anggota + approve/reject akun
│   │   │   ├── MemberPortalController.php  # Portal anggota (self-service)
│   │   │   ├── RegisterController.php      # Registrasi member baru
│   │   │   └── ReservationController.php   # Reservasi & pembatalan buku
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php         # Gate: hanya admin
│   │   │   ├── EnsureEmailIsVerified.php    # Gate: email harus terverifikasi
│   │   │   ├── EnsureMemberIsApproved.php   # Gate: akun harus disetujui admin
│   │   │   └── MemberMiddleware.php        # Gate: hanya member
│   │   └── Requests/                       # 8 form request classes
│   │       ├── RegisterRequest.php
│   │       ├── ReserveRequest.php
│   │       ├── StoreBookRequest.php
│   │       ├── StoreBorrowingRequest.php
│   │       ├── StoreMemberRequest.php
│   │       ├── StoreReturnRequest.php
│   │       ├── UpdateBookRequest.php
│   │       └── UpdateMemberRequest.php
│   └── Models/
│       ├── Book.php
│       ├── BookReturn.php           # (table: returns)
│       ├── Borrowing.php
│       ├── Member.php
│       └── User.php
├── bootstrap/
│   └── app.php                      # Middleware alias registration
├── config/                          # Konfigurasi aplikasi
├── database/
│   ├── factories/                   # UserFactory (hanya 1)
│   ├── migrations/                  # 11 migration files
│   └── seeders/                     # 5 seeder + DatabaseSeeder (master)
├── public/                          # Web root
├── resources/
│   ├── css/                         # Tailwind directives (base)
│   ├── js/                          # Bootstrap JS import
│   └── views/                       # Blade templates
│       ├── auth/                    # login, register, verify-email, awaiting-approval
│       ├── books/                   # index, create, edit
│       ├── borrowings/              # index, create, show, print
│       ├── catalog/                 # index, show (publik)
│       ├── components/              # reusable Blade components
│       ├── dashboard/               # index (admin stats + charts)
│       ├── layouts/                 # app, member, public
│       ├── member/                  # dashboard, borrowings, profile
│       ├── members/                 # index, create, edit, show
│       └── returns/                 # create
├── routes/
│   ├── console.php
│   └── web.php                     # Semua route web
├── docs/
│   ├── screenshots/                 # 7 screenshot aplikasi
│   ├── use-cases/                   # 3 file PlantUML (admin, member, public)
│   └── user-guide/                  # Panduan pengguna
├── storage/
│   └── app/public/covers/           # Cover buku (25 file .jpg)
├── .ddev/                           # DDEV configuration
├── composer.json
├── package.json
├── vite.config.js
├── tailwind.config.js
└── phpunit.xml
```

---

## Branching Strategy

| Branch Type | Naming Convention | Purpose | Base Branch |
|-------------|-------------------|---------|-------------|
| `main` | `main` | Production-ready code | — |
| Milestone | `feature/uas-m{1-4}-<deskripsi>` | Tugas UAS per milestone | `main` |
| Feature | `feature/<nama-fitur>` | Fitur spesifik (e.g. `feature/authentication`) | `main` atau milestone |

**Workflow:**
1. Buat branch dari `main` (atau branch milestone terkait)
2. Develop & commit di branch tersebut
3. Push branch ke remote
4. Buat Pull Request ke branch parent
5. Review & merge

---

## Coding Conventions

### PHP (PSR-12)

- Indentasi: 4 spasi
- PHP opening tag: `<?php`
- Kebab-case untuk string URI
- camelCase untuk property/variable
- English untuk kode, Bahasa Indonesia untuk tampilan (views)

### Blade Templates

- Gunakan layout inheritance (`@extends`, `@section`, `@yield`)
- Format tanggal: `->format('d/m/Y')` (format Indonesia)
- Icon: Bootstrap Icons (`bi-*`) selalu dengan tag `<i>`

### Form Request Validation

- Setiap form selalu menggunakan FormRequest class (`extends FormRequest`, bukan validasi inline)
- Authorization: selalu `return auth()->check() && auth()->user()->isAdmin()` (atau variant)
- Rules merujuk ke nama tabel + kolom langsung

### Eloquent Model

- `$fillable` wajib diisi untuk mass-assignment fields
- `$casts` untuk timestamp yang perlu di-cast ke Carbon/date
- Relasi: snake_case untuk nama method (e.g. `borrowings()`, bukan `getBorrowings()`)
- `@use HasFactory` docblock untuk hint PHPStan/Larastan

### Controller

- Method: emoji minimal, fokus ke business logic
- Redirect: `->with('success', '...')` atau `->with('error', '...')` untuk flash messages
- Route: gunakan route naming convention Laravel default

---

## Cara Menambah Fitur Baru

### Step-by-step: Menambah field baru ke tabel buku

1. **Migration:**
```bash
php artisan make:migration add_<field>_to_books_table --table=books
```
Edit file migration di `database/migrations/`.

2. **Model:**
Tambah field ke `$fillable` di `App\Models\Book`. Tambah `$casts` jika perlu.

3. **Form Request:**
Tambah validation rules di `StoreBookRequest.php` dan `UpdateBookRequest.php`.

4. **Controller:**
Jika ada business logic baru, edit `BookController.php`.

5. **View:**
Tambah input field di `resources/views/books/create.blade.php` dan `edit.blade.php`.
Tampilkan di `index.blade.php` jika relevan.

6. **Seeder (opsional):**
Update `database/seeders/BookSeeder.php` dengan data baru.

7. **Test:**
Run migrasi + seeder untuk verifikasi:
```bash
php artisan migrate:fresh --seed
```

---

## Form Request Validation

Menggunakan Form Request classes terpisah:

| Request Class | Validasi | Digunakan di |
|---------------|----------|--------------|
| `RegisterRequest` | name, email (unique users+members), password min:8, phone nullable | `RegisterController` |
| `ReserveRequest` | Tidak ada input (auth-based), validasi di code: available_stock > 0 | `ReservationController` |
| `StoreBookRequest` | title, author, publisher, isbn nullable|unique, category, year min:1900, total_stock, cover nullable image 2MB | `BookController@store` |
| `UpdateBookRequest` | Sama dengan StoreBookRequest | `BookController@update` |
| `StoreMemberRequest` | member_number, name, email unique:members, phone nullable, address nullable, join_date | `MemberController@store` |
| `UpdateMemberRequest` | Sama, kecuali member_number tidak required | `MemberController@update` |
| `StoreBorrowingRequest` | member_id exists, book_id exists + available_stock > 0, due_date after borrow_date | `BorrowingController@store` |
| `StoreReturnRequest` | return_date after:borrow_date, notes nullable | `BookReturnController@store` |

---

## Testing

### PHPUnit

Jalankan test suite:
```bash
php artisan test
# atau via DDEV:
ddev artisan test
```

Konfigurasi test ada di `phpunit.xml`.

### Check Code Quality

```bash
# Cek PHP syntax error:
vendor/bin/phpstan analyze app/ --level=4

# Cek Blade syntax:
find resources/views/ -name "*.blade.php" -exec php -l {} \;
```

---

## Build untuk Production

### Frontend Build

```bash
npm run build
```

Output ke `public/build/` yang sudah di-reference di Blade via `@vite()` directive.

### Environment Production

Setting penting di `.env` untuk production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com

DB_CONNECTION=mysql
DB_HOST=...
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

MAIL_MAILER=smtp
MAIL_HOST=smtp.server.com
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=noreply@domain-anda.com
```

### Setelah Deploy

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

---

## Deployment Notes

### Persyaratan Server

- PHP >= 8.2
- Nginx / Apache
- MySQL 8.0 atau MariaDB >= 10.4
- Composer & Node.js (hanya saat build)
- Disk space untuk cover images

### Langkah Deployment

1. Clone repository ke server
2. `composer install --no-dev --optimize-autoloader`
3. `cp .env.example .env` + sesuaikan konfigurasi
4. `php artisan key:generate`
5. `php artisan migrate --seed`
6. `php artisan storage:link`
7. `npm ci && npm run build`
8. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
9. Konfigurasi Nginx/Apache root ke `public/`

### Mail Configuration di Production

Di environment production, email verifikasi akan dikirim via SMTP nyata (bukan Mailpit). Konfigurasi di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com       # contoh Gmail
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@perpustakaan.com
MAIL_FROM_NAME="GramediKu"
```

---

## Links Referensi

- [Laravel 11 Documentation](https://laravel.com/docs/11.x)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.3)
- [Chart.js Documentation](https://www.chartjs.org/docs/latest)
- [DDEV Documentation](https://ddev.readthedocs.io)