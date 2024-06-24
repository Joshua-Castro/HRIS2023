<?php

namespace App\Services;

use App\Models\Payroll;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PayrollService
{

    /**
     * Business logic for storing
     * data in payroll controller.
     * @param array $data
     * @return void
     */
    public function storePayroll(array $data)
    {
        $payroll = new Payroll();
        $payroll->employee_id       =  $data['payroll'][1];
        $payroll->basic_salary      =  $data['payroll'][0];
        $payroll->total_deductions  =  $data['payroll'][3];
        $payroll->sss               =  $data['payroll'][2]['sss']          ??  null;
        $payroll->pagibig           =  $data['payroll'][2]['pagibig']      ??  null;
        $payroll->philhealth        =  $data['payroll'][2]['philhealth']   ??  null;
        $payroll->tax               =  $data['payroll'][2]['tax']          ??  null;
        $payroll->net_salary        =  $data['payroll'][4];
        $payroll->status            =  'Pending';
        $payroll->created_by        =  Auth::id();
        $payroll->save();

        return $payroll;
    }

    /**
     * Business logic for showing
     * all the employee attendance based on seleceted
     * date, and initialize payroll data.
     * @param array $data
     * @return void
     */
    public function employeeAttendance(array $request)
    {
      $attendanceData = Attendance::where('employee_id', '=', $request['employeeId'])
                              ->whereDate('attendance_date', '>=', $request['dateFrom'])
                              ->whereDate('attendance_date', '<=', $request['dateTo']);

      $totalWorkingHours          =   $attendanceData->sum('regular_hours');
      $attendanceData             =   $attendanceData->orderBy('attendance_date', 'ASC')->paginate(10);
      $encodedAttendanceData      =   base64_encode(json_encode($attendanceData));
      $encodedTotalWorkingHours   =   base64_encode(json_encode($totalWorkingHours));

      $data = [
        Str::random(16)  => $encodedAttendanceData,
        Str::random(16)  => $encodedTotalWorkingHours
      ];

      return $data;
    }
}
