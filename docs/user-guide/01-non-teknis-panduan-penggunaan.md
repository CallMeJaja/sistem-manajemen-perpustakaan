# Panduan Penggunaan Aplikasi GramediKu (Non-Teknis)

Dokumen ini menjelaskan cara menggunakan aplikasi GramediKu dari sisi pengguna akhir (end-user) melalui web browser.  
Tidak ada pengetahuan teknis yang dibutuhkan.

---

## Daftar Isi

- [Pengenalan Aplikasi](#pengenalan-aplikasi)
- [Roles & Akses](#roles--akses)
- [Sebagai Pengunjung Publik](#sebagai-pengunjung-publik)
- [Sebagai Anggota (Member)](#sebagai-anggota-member)
    - [Registrasi Akun Baru](#registrasi-akun-baru)
    - [Verifikasi Email](#verifikasi-email)
    - [Menunggu Persetujuan Admin](#menunggu-persetujuan-admin)
    - [Login](#login)
    - [Dashboard Anggota](#dashboard-anggota)
    - [Melihat & Mencari Buku di Katalog](#melihat--mencari-buku-di-katalog)
    - [Reservasi Buku](#reservasi-buku)
    - [Membatalkan Reservasi](#membatalkan-reservasi)
    - [Melihat Riwayat Peminjaman](#melihat-riwayat-peminjaman)
    - [Mengedit Profil](#mengedit-profil)
- [Sebagai Admin](#sebagai-admin)
    - [Dashboard Admin](#dashboard-admin)
    - [Manajemen Buku](#manajemen-buku)
    - [Manajemen Anggota](#manajemen-anggota)
    - [Menambah Peminjaman](#menambah-peminjaman)
    - [Menyetujui / Menolak Reservasi](#menyetujui--menolak-reservasi)
    - [Memproses Pengembalian](#memproses-pengembalian)
    - [Cetak Struk Peminjaman](#cetak-struk-peminjaman)
    - [Menyetujui / Menolak Akun Anggota Baru](#menyetujui--menolak-akun-anggota-baru)
- [FAQ](#faq)

---

## Pengenalan Aplikasi

GramediKu adalah sistem informasi perpustakaan digital berbasis web. Anda dapat mengaksesnya melalui browser di alamat yang disediakan oleh operator perpustakaan.

**Fitur utama:**
- Katalog buku lengkap dengan gambar cover
- Sistem peminjaman & pengembalian buku secara digital
- Reservasi buku oleh anggota (dengan persetujuan admin)
- Dasbor statistik untuk admin
- Autentikasi anggota via registrasi online + persetujuan admin

---

## Roles & Akses

| Role | Deskripsi | Akses |
|------|-----------|-------|
| **Public** | Pengunjung tanpa login | Melihat katalog, mencari dan melihat detail buku |
| **Member** | Anggota terdaftar (disetujui admin) | Semua akses Public + reservasi buku, dashboard, riwayat peminjaman, edit profil |
| **Admin** | Petugas perpustakaan | Kelola buku & anggota, catat peminjaman & pengembalian, setujui/tolak reservasi, setujui/tolak akun anggota baru, lihat dashboard statistik |

---

## Sebagai Pengunjung Publik

### Halaman Katalog (`/catalog`)

1. Buka halaman katalog di browser Anda.
2. Anda akan melihat daftar buku dalam bentuk kartu (cover, judul, penulis, stok tersedia).
3. **Mencari buku:** Gunakan kolom pencarian di bagian atas untuk mencari berdasarkan **judul**, **penulis**, atau **kategori**.
4. **Filter:** Gunakan dropdown **Kategori** dan **Ketersediaan** untuk memfilter buku.
5. Klik pada buku untuk melihat **halaman detail** yang berisi:
   - Cover buku (gambar sampul)
   - Judul, penulis, penerbit, ISBN, tahun terbit
   - Kategori, lokasi rak
   - Stok total dan stok tersedia

---

## Sebagai Anggota (Member)

### Registrasi Akun Baru

1. Buka halaman `/register` (atau klik tautan "Daftar" di navbar).
2. Isi formulir:
   - **Nama Lengkap** — nama Anda
   - **Email** — alamat email yang valid (akan digunakan untuk verifikasi)
   - **Telepon** — opsional, nomor HP
   - **Password** — minimal 8 karakter, masukkan dua kali
3. Klik **"Daftar"**.
4. Anda akan langsung login dan diarahkan ke halaman **verifikasi email**.
5. **Cek inbox email Anda** — buka link verifikasi yang dikirim oleh sistem.

### Verifikasi Email

Setelah registrasi, sistem mengirim email verifikasi ke alamat email Anda.

1. **Cek inbox** email Anda (cari email dari GramediKu).
2. Klik **link verifikasi** dalam email tersebut.
3. Anda akan melihat halaman **"Menunggu Persetujuan Admin"** — email sudah terverifikasi, namun akun belum aktif.

> **Catatan:** Jika tidak menerima email, cek folder spam. Anda juga dapat klik "Kirim Ulang" di halaman `/verify-email`.

### Menunggu Persetujuan Admin

Setelah email terverifikasi, akun Anda berstatus **Pending**. Admin perpustakaan akan meninjau dan menyetujui atau menolak akun Anda.

- **Sambil menunggu**, Anda tetap dapat melihat katalog buku (`/catalog`).
- **Jika disetujui:** Anda akan dapat login dan mengakses semua fitur anggota.
- **Jika ditolak:** Saat login, Anda akan melihat pesan penolakan. Silakan hubungi admin perpustakaan.

### Login

1. Buka halaman `/login`.
2. Masukkan **email** dan **password** yang terdaftar.
3. Klik **"Masuk"**.
4. Anda akan diarahkan ke **Dashboard Anggota**.

> **Catatan:** Akun harus **disetujui admin** terlebih dahulu sebelum dapat mengakses portal anggota.

### Dashboard Anggota (`/member/dashboard`)

Setelah login, Anda akan melihat dashboard pribadi:

- **Total Reservasi Pending** — jumlah reservasi yang menunggu persetujuan admin.
- **Total Buku Dipinjam** — jumlah buku yang sedang Anda pinjam (aktif).
- **Total Buku Dikembalikan** — jumlah buku yang telah dikembalikan.
- **Total Denda** — akumulasi denda dari keterlambatan pengembalian (Rp 1.000/hari).
- **Tabel Peminjaman Aktif** — buku yang sedang Anda pinjam, termasuk batas waktu dan status terlambat.

### Melihat & Mencari Buku di Katalog

1. Buka halaman `/catalog`.
2. Gunakan **search bar** untuk mencari buku berdasarkan judul, penulis, atau kategori.
3. Gunakan **filter dropdown** untuk menyaring berdasarkan kategori atau ketersediaan.
4. Klik buku yang ingin dilihat — halaman detail akan menampilkan informasi lengkap dan tombol **"Reservasi"**.

### Reservasi Buku

Dari halaman detail buku (`/catalog/{book}`):

1. Klik tombol **"Reservasi Sekarang"** (tombol hijau).
2. Sistem akan membuat permintaan reservasi dengan status **Pending**.
3. Admin akan meninjau reservasi Anda — jika disetujui, status berubah menjadi **Borrowed** dan stok buku turun.

> **Catatan:** Anda hanya dapat mereservasi buku yang memiliki stok tersedia (`available_stock > 0`). Anda tidak dapat mereservasi buku yang sudah Anda pinjam.

### Membatalkan Reservasi

Anda dapat membatalkan reservasi yang masih berstatus **Pending** (belum disetujui admin):

1. Buka halaman **Pinjaman Saya** (`/member/borrowings`).
2. Cari reservasi dengan status "Pending".
3. Klik tombol **"Batalkan"**.
4. Status berubah menjadi **Rejected** — stok buku tidak terpengaruh.

### Melihat Riwayat Peminjaman (`/member/borrowings`)

1. Buka halaman **Pinjaman Saya**.
2. Gunakan **filter status** untuk melihat: Semua, Pending, Dipinjam, Dikembalikan, Ditolak.
3. Setiap baris menampilkan: Nomor peminjaman, judul buku, status, tanggal pinjam, tanggal jatuh tempo.
4. Riwayat ditampilkan per halaman (10 data per halaman) — gunakan navigasi halaman di bawah.

### Mengedit Profil (`/member/profile`)

1. Buka halaman **Profil**.
2. Anda dapat mengedit:
   - **Telepon** — nomor HP terbaru
   - **Alamat** — alamat tempat tinggal
3. Klik **"Simpan Perubahan"**.
4. Data nama, email, dan nomor anggota tidak dapat diubah sendiri (hubungi admin).

---

## Sebagai Admin

### Dashboard Admin (`/dashboard`)

Dashboard admin menampilkan:

- **Kartu Statistik** — Total buku, buku tersedia, total anggota, peminjaman aktif, dikembalikan, keterlambatan.
- **Grafik Batang** — Tren peminjaman per bulan (6 bulan terakhir).
- **Grafik Donat** — Distribusi buku per kategori.
- **Tabel Keterlambatan** — Peminjaman yang overdue (melewati batas waktu).
- **Transaksi Terbaru** — 5 peminjaman terakhir.

### Manajemen Buku (`/books`)

#### Melihat Daftar Buku
1. Buka menu **Buku** di sidebar.
2. Anda melihat tabel buku dengan thumbnail cover, judul, penulis, stok, dan kategori.
3. **Search bar** di atas tabel untuk mencari buku.
4. Setiap buku memiliki tombol **Detail**, **Edit**, **Hapus**.

#### Menambah Buku Baru
1. Klik tombol **"Tambah Buku"** di pojok kanan atas.
2. Isi formulir:
   - **Judul** — judul buku
   - **Cover** — (opsional) upload gambar cover (JPG/PNG/WEBP, maks 2MB)
   - **Penulis** — nama penulis
   - **Penerbit** — nama penerbit
   - **ISBN** — (opsional) nomor ISBN, harus unik
   - **Kategori** — pilih kategori dari dropdown
   - **Tahun** — tahun terbit
   - **Total Stok** — jumlah total buku
   - **Lokasi** — kode rak (opsional)
3. Klik **"Simpan"**.
4. `available_stock` akan otomatis sama dengan `total_stock` saat buku baru dibuat.

#### Mengedit Buku
1. Klik tombol **Edit** (pensil) pada buku.
2. Ubah data yang diperlukan. Cover saat ini akan ditampilkan.
3. **Penting:** Jika Anda mengubah `total_stock`, `available_stock` akan otomatis disesuaikan (tidak boleh melebihi total).

#### Menghapus Buku
1. Klik tombol **Hapus** (tong sampah) pada buku.
2. Konfirmasi penghapusan. Cover image juga akan dihapus dari storage.

### Manajemen Anggota (`/members`)

#### Melihat Daftar Anggota
1. Buka menu **Anggota** di sidebar.
2. Anda melihat tabel anggota dengan nomor anggota, nama, email, telepon, tanggal bergabung, **status akun**, dan status peminjaman.
3. **Status akun:**
   - `Disetujui` (hijau) — akun aktif
   - `Pending` (kuning) — menunggu persetujuan
   - `Ditolak` (merah) — akun ditolak
   - `Belum Ada Akun` (abu-abu) — anggota legacy tanpa akun login
4. **Search bar** untuk mencari anggota berdasarkan nama, email, atau nomor anggota.

#### Menambah Anggota Baru
1. Klik tombol **"Tambah Anggota"**.
2. Isi formulir — nomor anggota dan tanggal bergabung akan otomatis terisi.
3. Klik **"Simpan"**.

#### Mengedit Anggota
1. Klik tombol **Edit** (pensil).
2. Ubah data yang diperlukan.
3. Klik **"Simpan"**.

#### Melihat Detail Anggota
1. Klik tombol **Detail** (mata).
2. Melihat informasi lengkap + daftar peminjaman yang terkait.

#### Menyetujui/Menolak Akun Anggota Baru
Untuk anggota yang akunnya berstatus **Pending**:

1. Di tabel anggota, lihat kolom **Status Akun**.
2. **Untuk menyetujui:** Klik tombol centang hijau.
3. **Untuk menolak:** Klik tombol silang merah (konfirmasi muncul).
4. Setelah disetujui, anggota dapat login dan mengakses portal.

> **Catatan fitur approval:** Anggota baru mendaftar via `/register` → verifikasi email → status akun "Pending". Admin perlu menyetujui akun secara manual agar anggota dapat menggunakan fitur portal anggota.

#### Menghapus Anggota
1. Klik tombol **Hapus** (tong sampah).
2. Konfirmasi. **Tidak bisa hapus jika anggota punya peminjaman aktif.**

### Menambah Peminjaman

1. Buka menu **Peminjaman** → klik **"Tambah Peminjaman"**.
2. Pilih **anggota** dan **buku** dari dropdown.
3. **Tanggal pinjam** otomatis hari ini.
4. **Tanggal jatuh tempo** otomatis 7 hari setelah pinjam.
5. Nomor peminjaman auto-generate format `PJ/YYYYMMDD/XXXX`.
6. Klik **"Simpan"** — stok buku otomatis berkurang.

### Menyetujui / Menolak Reservasi

Ketika anggota mereservasi buku, statusnya adalah **Pending**.

1. Buka menu **Peminjaman** — lihat daftar.
2. Cari peminjaman dengan status **Pending**.
3. **Untuk menyetujui:** Klik tombol **Approve** → status berubah menjadi **Borrowed**, stok buku turun 1, tanggal pinjam diset.
4. **Untuk menolak:** Klik tombol **Reject** → status berubah menjadi **Rejected**, stok buku tidak berubah.

### Memproses Pengembalian

1. Buka menu **Peminjaman** — cari peminjaman yang masih berstatus **Borrowed**.
2. Klik tombol **Return** (kembalikan).
3. Sistem otomatis menghitung:
   - **Telat (hari)** — selisih antara tanggal kembali dengan tanggal jatuh tempo
   - **Denda** — Rp 1.000 × jumlah hari telat
4. Anda dapat menambahkan **catatan** (opsional).
5. Klik **"Proses Pengembalian"**.
6. Status berubah → **Returned**, stok buku naik 1.

### Cetak Struk Peminjaman

1. Buka halaman detail peminjaman (klik tombol **Detail**).
2. Klik tombol **"Cetak Struk"**.
3. Halaman struk siap cetak akan muncul dengan informasi:
   - Logo GramediKu
   - Nomor peminjaman
   - Data anggota (nama, nomor anggota)
   - Data buku (judul, penulis)
   - Tanggal pinjam & jatuh tempo
   - Status peminjaman
4. Gunakan `Ctrl+P` (atau Cmd+P) untuk mencetak.

---

## FAQ

### Umum

**Q: Saya lupa password. Bagaimana cara reset?**  
*A:* Klik link **"Lupa password?"** di halaman login. Masukkan email Anda, lalu sistem akan mengirimkan tautan reset password ke email tersebut. Buka tautan dari email, masukkan password baru, dan login dengan password baru Anda.

**Q: Apakah aplikasi ini bisa diakses dari HP?**  
*A:* Ya, tampilan sudah responsif (mobile-friendly) menggunakan Bootstrap 5.

**Q: Berapa lama masa peminjaman buku?**  
*A:* Standar 7 hari sejak tanggal pinjam. Untuk reservasi yang disetujui, 7 hari sejak tanggal persetujuan admin.

### Anggota

**Q: Mengapa saya tidak bisa login padahal email sudah diverifikasi?**  
*A:* Akun Anda mungkin masih menunggu persetujuan admin (`Pending`). Setelah admin menyetujui, Anda akan bisa mengakses portal anggota.

**Q: Saya tidak menerima email verifikasi. Apa yang harus dilakukan?**  
*A:* Cek folder **spam**. Jika tetap tidak ada, buka halaman `/verify-email` dan klik **"Kirim Ulang Email Verifikasi"**.

**Q: Bisakah saya meminjam buku yang stoknya 0?**  
*A:* Tidak. Buku dengan stok 0 tidak dapat direservasi. Harap tunggu hingga ada yang mengembalikan.

**Q: Bagaimana jika saya telat mengembalikan buku?**  
*A:* Denda otomatis dihitung Rp 1.000 per hari keterlambatan. Denda akan muncul di dashboard Anda.

### Admin

**Q: Bagaimana cara melihat anggota yang perlu persetujuan akun?**  
*A:* Di halaman **Manajemen Anggota**, lihat kolom **Status Akun**. Anggota dengan badge `Pending` (kuning) perlu disetujui.

**Q: Apa yang terjadi jika saya menghapus buku?**  
*A:* Buku akan dihapus beserta cover imagenya dari storage. Peminjaman terkait buku tersebut akan IKUT TERHAPUS (`cascadeOnDelete`).

**Q: Bagaimana jika anggota punya peminjaman aktif tapi ingin dihapus?**  
*A:* Sistem akan menolak penghapusan dengan pesan error. Selesaikan dulu semua peminjaman aktif anggota tersebut.