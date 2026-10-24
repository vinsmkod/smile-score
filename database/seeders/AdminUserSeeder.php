<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Akun Superadmin
        User::updateOrCreate(
            ['email' => 'superadmin@smilescore.id'],
            [
                'name' => 'Superadmin Smile Score',
                'password' => Hash::make('superadmin123!@#$'),
            ]
        );

        // Akun Administrator
        User::updateOrCreate(
            ['email' => 'admin@smilescore.id'],
            [
                'name' => 'Administrator Penelitian',
                'password' => Hash::make('admin12345'),
            ]
        );
    }
}
