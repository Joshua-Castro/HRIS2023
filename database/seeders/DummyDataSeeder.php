<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clockIn        = '07:00:00';
        $clockOut       = '16:00:00';
        $breakIn        = '13:00:00';
        $breakOut       = '12:00:00';
        $year           = 2024;
        $month          = 4;
        $attendances    = [];

        // GENERATE ATTENDANCE RECORDS FOR EACH DAY IN APRIL 2024
        for ($day = 1; $day <= 30; $day++) {
            $date = Carbon::create($year, $month, $day)->format('Y-m-d');
            $attendances[] = [
                'user_id'          =>  4,
                'employee_id'      =>  1,
                'attendance_date'  =>  $date,
                'clock_in'         =>  $clockIn,
                'break_in'         =>  $breakIn,
                'break_out'        =>  $breakOut,
                'clock_out'        =>  $clockOut,
                'created_at'       =>  Carbon::now(),
                'updated_at'       =>  Carbon::now(),
            ];
        }

        DB::table('attendances')->insert($attendances);
    }
}
