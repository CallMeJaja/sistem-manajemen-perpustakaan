# Panduan Pengguna — Sistem Manajemen Perpustakaan GramediKu

Selamat datang di GramediKu, aplikasi manajemen perpustakaan digital berbasis Laravel.  
Panduan ini mencakup seluruh aspek penggunaan aplikasi — baik untuk pengguna non-teknis (anggota, admin) maupun pengembang yang ingin menjalankan proyek ini secara lokal.

---

## Daftar Isi

| Dokumen | Target | Deskripsi |
|---------|--------|-----------|
| [01 — Panduan Penggunaan Aplikasi (Non-Teknis)](01-non-teknis-panduan-penggunaan.md) | Anggota, Admin, Pengunjung | Cara menggunakan aplikasi melalui website — registrasi, login, katalog, reservasi, manajemen admin |
| [02 — Instalasi & Setup Lokal (Teknis)](02-teknis-instalasi-lokal.md) | Developer, Mahasiswa | Cara clone repository, setup development environment, dan menjalankan aplikasi di komputer lokal |
| [03 — Kontribusi & Pengembangan (Teknis)](03-teknis-contributing.md) | Developer | Panduan developer: struktur proyek, branching strategy, coding conventions, testing, deployment |

---

## Sekilas Tentang GramediKu

GramediKu adalah sistem informasi perpustakaan digital yang dikembangkan untuk mempermudah operasional perpustakaan:

- **Admin** dapat mengelola koleksi buku, data anggota, peminjaman, pengembalian, dan dashboard statistik.
- **Anggota (Member)** dapat mendaftar online, browse katalog, reservasi buku, dan melihat riwayat peminjaman.
- **Pengunjung Publik** dapat melihat katalog buku tanpa perlu login.

### Akses Cepat

| Role    | Email                     | Password   | URL Start              |
|---------|---------------------------|------------|------------------------|
| Admin   | admin@perpustakaan.com    | password   | Dashboard Admin        |
| Anggota | member@perpustakaan.com   | password   | Dashboard Anggota      |

---

## Teknologi

- **Framework:** Laravel 11
- **Bahasa Backend:** PHP 8.4
- **Database:** MariaDB 11.8
- **CSS Framework:** Bootstrap 5.3
- **Charts:** Chart.js 4.4
- **Development Environment:** DDEV (opsional)