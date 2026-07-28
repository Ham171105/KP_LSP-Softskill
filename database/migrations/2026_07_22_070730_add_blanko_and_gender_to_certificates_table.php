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
            if (!Schema::hasColumn('certificates', 'blanko_number')) {
                $table->string('blanko_number')->nullable()->after('certificate_number');
            }
            if (!Schema::hasColumn('certificates', 'gender')) {
                $table->enum('gender', ['L', 'P'])->nullable()->after('participant_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['blanko_number', 'gender']);
        });
    }
};
