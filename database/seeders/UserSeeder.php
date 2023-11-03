<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'                  => 'SuperAdmin',
            'token'                 => uniqid() . now()->timestamp,
            'email'                 => 'superadmin@admin.com',
            'role'                  => '1',
            'retrieve_password'     => 'admin1234',
            'password'              => Hash::make('admin1234'),
        ]);

        User::create([
            'name'                  => 'SuperAdmin2',
            'token'                 => uniqid() . now()->timestamp,
            'email'                 => 'superadmin2@admin.com',
            'role'                  => '1',
            'retrieve_password'     => 'admin1234',
            'password'              => Hash::make('admin1234'),
        ]);

        User::create([
            'name'                  => 'SuperAdmin3',
            'token'                 => uniqid() . now()->timestamp,
            'email'                 => 'superadmin3@admin.com',
            'role'                  => '1',
            'retrieve_password'     => 'admin1234',
            'password'              => Hash::make('admin1234'),
        ]);
    }
}
