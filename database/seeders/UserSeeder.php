<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admins
        User::updateOrCreate(
            ['email' => 'lucien@soundevents.com'],
            [
                'name'     => 'Lucien',
                'password' => Hash::make('soundevents2026'),
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'sabdou@soundevents.com'],
            [
                'name'     => 'Sabdou',
                'password' => Hash::make('soundevents2026'),
                'role'     => 'admin',
            ]
        );
 // Visiteurs (lecture seule)
        User::updateOrCreate(
            ['email' => 'visiteur1@soundevents.com'],
            [
                'name'     => 'Visiteur 1',
                'password' => Hash::make('visiteur2026'),
                'role'     => 'viewer',
            ]
        );

    }
}
