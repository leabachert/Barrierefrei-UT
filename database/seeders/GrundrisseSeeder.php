<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grundrisse;


class GrundrisseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = include database_path('data/grundrisse.php');

        foreach ($rows as $row) {
            Grundrisse::updateOrCreate(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
