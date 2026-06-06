<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama'     => 'Administrator',
            'email'    => 'admin@beatbase.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'nama'     => 'Owner Studio',
            'email'    => 'owner@beatbase.com',
            'password' => Hash::make('password'),
            'role'     => 'owner',
        ]);

        User::create([
            'nama'     => 'Customer Test',
            'email'    => 'customer@beatbase.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
        ]);
    }
}