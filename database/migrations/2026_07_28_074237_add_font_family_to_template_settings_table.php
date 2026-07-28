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
        Schema::table('template_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('template_settings', 'font_family')) {
                $table->string('font_family')->nullable()->after('font_size');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_settings', function (Blueprint $table) {
            if (Schema::hasColumn('template_settings', 'font_family')) {
                $table->dropColumn('font_family');
            }
        });
    }
};
