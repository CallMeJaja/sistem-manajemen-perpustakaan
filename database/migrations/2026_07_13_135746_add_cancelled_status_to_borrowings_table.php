<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update the enum to include 'cancelled' status
        // MySQL/MariaDB syntax
        DB::statement("ALTER TABLE borrowings MODIFY status ENUM('pending','borrowed','returned','rejected','cancelled') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // First update any cancelled records back to rejected
        DB::table('borrowings')->where('status', 'cancelled')->update(['status' => 'rejected']);
        
        // Then remove 'cancelled' from enum
        DB::statement("ALTER TABLE borrowings MODIFY status ENUM('pending','borrowed','returned','rejected') NOT NULL DEFAULT 'pending'");
    }
};