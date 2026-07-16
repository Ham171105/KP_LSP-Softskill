<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin LSP Soft Skill',
            'email' => 'admin@lspsoftskill.com',
            'password' => Hash::make('password123'),
        ]);

        // Categories
        Category::create([
            'name' => 'Kepemimpinan',
            'code' => 'KPM',
            'description' => 'Sertifikasi Bidang Kepemimpinan',
        ]);

        Category::create([
            'name' => 'Komunikasi',
            'code' => 'KOM',
            'description' => 'Sertifikasi Bidang Komunikasi',
        ]);

        Category::create([
            'name' => 'Pemecahan Masalah',
            'code' => 'PM',
            'description' => 'Sertifikasi Bidang Pemecahan Masalah',
        ]);
    }
}
