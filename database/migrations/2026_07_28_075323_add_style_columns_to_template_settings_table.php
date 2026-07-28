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
            if (!Schema::hasColumn('template_settings', 'is_bold')) {
                $table->boolean('is_bold')->default(false)->after('font_family');
            }
            if (!Schema::hasColumn('template_settings', 'is_italic')) {
                $table->boolean('is_italic')->default(false)->after('is_bold');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_settings', function (Blueprint $table) {
            if (Schema::hasColumn('template_settings', 'is_bold')) {
                $table->dropColumn('is_bold');
            }
            if (Schema::hasColumn('template_settings', 'is_italic')) {
                $table->dropColumn('is_italic');
            }
        });
    }
};
