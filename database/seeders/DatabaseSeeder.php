<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GebaeudeSeeder::class,
            AdressenSeeder::class,
            InfosAussenSeeder::class,
            InfosInnenSeeder::class,
            GrundrisseSeeder::class,
            UserSeeder::class,
        ]);
    }
}
