<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'XXX'],
            [
                'name' => 'Admin',
                'password' => Hash::make('XXX'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'XXX'],
            [
                'name' => 'Editor',
                'password' => Hash::make('XXX'),
                'role' => 'editor',
            ]
        );
    }
}
