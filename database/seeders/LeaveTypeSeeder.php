<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeaveType::create([
            'description'   => 'Emergency/Sick Leave',
        ]);

        LeaveType::create([
            'description'   => 'Parental Leave',
        ]);

        LeaveType::create([
            'description'   => 'Paternity Leave',
        ]);

        LeaveType::create([
            'description'   => 'Vacation Leave',
        ]);

        LeaveType::create([
            'description'   => 'Birthday Leave',
        ]);
    }
}
