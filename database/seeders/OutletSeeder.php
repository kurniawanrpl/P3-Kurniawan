<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Outlet;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Outlet::create([
            'nama_outlet' => 'Laundry Ceria',
            'alamat' => 'Jl. Kebersihan No. 1',
            'telepon' => '081234567890',
        ]);

        Outlet::create([
            'nama_outlet' => 'Laundry Bersih',
            'alamat' => 'Jl. Wangi No. 2',
            'telepon' => '082233445566',
        ]);

        Outlet::create([
            'nama_outlet' => 'Laundry Harum',
            'alamat' => 'Jl. Melati No. 3',
            'telepon' => '083344556677',
        ]);
    }
}
