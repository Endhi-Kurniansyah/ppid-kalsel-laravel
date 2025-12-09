<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@ppid.com',
            'password' => Hash::make('password'), // Passwordnya 'password'
        ]);
    }
}
