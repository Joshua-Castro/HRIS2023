<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\LeaveTypeSeeder;
use Database\Seeders\DummyDataSeeder;
use Database\Seeders\SalaryGradeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(LeaveTypeSeeder::class);
        $this->call(DummyDataSeeder::class);
        $this->call(SalaryGradeSeeder::class);
    }
}
