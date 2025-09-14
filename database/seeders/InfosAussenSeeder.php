<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InfosAussen;


class InfosAussenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = include database_path('data/infos_aussen.php');

        foreach ($rows as $row) {
            InfosAussen::updateOrCreate(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
