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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('schema_code')->nullable()->after('code');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->integer('sequence_number')->default(0)->after('certificate_number');
            $table->string('registration_number')->nullable()->after('sequence_number');
        });

        // Initialize schema codes
        DB::table('categories')->where('code', 'KPM')->update(['schema_code' => '1219']);
        DB::table('categories')->where('code', 'KOM')->update(['schema_code' => '2421']);
        DB::table('categories')->where('code', 'PM')->update(['schema_code' => '2421']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('schema_code');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['sequence_number', 'registration_number']);
        });
    }
};
