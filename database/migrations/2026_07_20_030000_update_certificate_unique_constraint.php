<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Hapus unique constraint lama di certificate_number saja
            $table->dropUnique('certificates_certificate_number_unique');
            
            // Tambah composite unique: certificate_number + category_id
            // Supaya KOM dan PM bisa punya nomor urut sendiri-sendiri
            $table->unique(['certificate_number', 'category_id'], 'certificates_number_category_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropUnique('certificates_number_category_unique');
            $table->unique('certificate_number', 'certificates_certificate_number_unique');
        });
    }
};
