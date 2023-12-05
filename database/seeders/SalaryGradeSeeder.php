<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SalaryGrade;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class SalaryGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salaryValues = [
            '13000',
            '13819',
            '14678',
            '15586',
            '16543',
            '17553',
            '18620',
            '19744',
            '21211',
            '23176',
            '27000',
            '29165',
            '31320',
            '33843',
            '36619',
            '39672',
            '43030',
            '46725',
            '51357',
            '57347',
            '63997',
            '71511',
            '80003',
            '90078',
            '102690',
            '116040',
            '131124',
            '148171',
            '167432',
            '189199',
            '278434',
            '331954',
            '419144',
        ];

        foreach ($salaryValues as $i => $salaryValue) {
            $monthlySalary = (float) $salaryValue;

            SalaryGrade::create([
                'description' => 'Grade ' . ($i + 1),
                'value' => $monthlySalary,
            ]);
        }
    }
}
