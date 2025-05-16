<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
class userSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Satu',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'outlet_id' => 1,
        ]);

        User::create([
            'name' => 'Supervisor Satu',
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'supervisor',
            'outlet_id' => 1,
        ]);

        User::create([
            'name' => 'Karyawan Satu',
            'email' => 'karyawan@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'karyawan',
            'outlet_id' => 1,
        ]);

        User::create([
            'name' => 'Owner Satu',
            'email' => 'owner@gmail.com.com',
            'password' => Hash::make('123456'),
            'role' => 'owner',
            'outlet_id' => 1,
        ]);
        User::create([
            'name' => 'pengguna',
            'email' => 'pengguna@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'owner',
            'outlet_id' => 1,
        ]);
    }
}
