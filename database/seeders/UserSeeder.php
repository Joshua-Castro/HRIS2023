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
            'name'      => 'Admin',
            'token'     => uniqid() . now()->timestamp,
            'email'     => 'admin',
            'is_admin'  => '1',
            'password'  => Hash::make('admin1234'),
        ]);

        User::create([
            'name'      => 'Admin2',
            'token'     => uniqid() . now()->timestamp,
            'email'     => 'admin2',
            'is_admin'  => '1',
            'password'  => Hash::make('admin1234'),
        ]);

        User::create([
            'name'      => 'Admin3',
            'token'     => uniqid() . now()->timestamp,
            'email'     => 'admin3',
            'is_admin'  => '1',
            'password'  => Hash::make('admin1234'),
        ]);
    }
}
