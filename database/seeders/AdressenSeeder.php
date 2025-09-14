<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adressen;


class AdressenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = include database_path('data/adressen.php');

        foreach ($rows as $row) {
            Adressen::updateOrCreate(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
