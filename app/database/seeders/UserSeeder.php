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
        User::firstOrCreate(
            ['email' => 'shilconsultancy@gmail.com'],
            [
                'name' => 'SHIL Consultancy',
                'password' => Hash::make('password'),
                'email_verified_at' => now(), // Optional: Mark email as verified
            ]
        );
    }
}