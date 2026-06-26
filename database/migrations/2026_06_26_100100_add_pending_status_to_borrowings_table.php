<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Perluas status peminjaman untuk alur reservasi anggota:
     *   pending  -> reservasi diajukan anggota, menunggu persetujuan
     *   borrowed -> disetujui admin, buku sedang dipinjam
     *   returned -> sudah dikembalikan
     *   rejected -> reservasi ditolak admin / dibatalkan
     *
     * MySQL/MariaDB pakai ENUM. SQLite (untuk testing) tidak mendukung
     * MODIFY ENUM dan punya CHECK constraint dari migration awal, jadi
     * kolomnya direbuild jadi string biasa (validasi nilai ditegakkan di
     * Form Request / aplikasi).
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE borrowings MODIFY status ENUM('pending','borrowed','returned','rejected') NOT NULL DEFAULT 'pending'");
        } else {
            Schema::table('borrowings', function (Blueprint $table) {
                $table->string('status')->default('pending')->change();
            });
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE borrowings MODIFY status ENUM('borrowed','returned') NOT NULL DEFAULT 'borrowed'");
        } else {
            Schema::table('borrowings', function (Blueprint $table) {
                $table->string('status')->default('borrowed')->change();
            });
        }
    }
};
