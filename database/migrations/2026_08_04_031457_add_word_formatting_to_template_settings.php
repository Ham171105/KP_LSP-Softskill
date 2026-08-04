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
            $table->string('text_align')->nullable()->after('is_italic');
            $table->string('color')->nullable()->after('text_align');
            $table->boolean('is_underline')->default(false)->after('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_settings', function (Blueprint $table) {
            $table->dropColumn(['text_align', 'color', 'is_underline']);
        });
    }
};
