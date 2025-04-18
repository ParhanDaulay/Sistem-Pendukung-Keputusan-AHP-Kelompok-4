<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user dummy (boleh tetap atau dihapus)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Tambahkan ini untuk jalankan KriteriaSeeder
        $this->call([
            KriteriaSeeder::class,
        ]);
    }
}
