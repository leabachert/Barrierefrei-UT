<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InfosInnen;


class InfosInnenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = include database_path('data/infos_innen.php');

        foreach ($rows as $row) {
            InfosInnen::updateOrCreate(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
