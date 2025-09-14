<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gebaeude;

class GebaeudeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = include database_path('data/gebaeude.php');

        foreach ($rows as $row) {
            Gebaeude::updateOrCreate(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
