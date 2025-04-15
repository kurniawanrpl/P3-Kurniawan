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
            'email' => 'admin@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'outlet_id' => 1,
        ]);

        User::create([
            'name' => 'Supervisor Satu',
            'email' => 'supervisor@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'outlet_id' => 1,
        ]);

        User::create([
            'name' => 'Karyawan Satu',
            'email' => 'karyawan@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'outlet_id' => 1,
        ]);

        User::create([
            'name' => 'Owner Satu',
            'email' => 'owner@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'outlet_id' => 1,
        ]);
    }
}
