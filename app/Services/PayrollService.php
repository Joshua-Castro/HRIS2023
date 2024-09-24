<?php

namespace App\Services;

use App\Models\Payroll;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PayrollService
{
    /**
     * Business logic for storing
     * data in payroll controller.
     */
    public function storePayroll(array $data)
    {
        $rtrn = [];
        // Check for duplicate if the request is already created. (Reference: Payroll from - to date)
        $checkDuplicate = Payroll::whereDate('payroll_date_from', $data['payroll'][6])
                              ->whereDate('payroll_date_to', $data['payroll'][7])
                              ->where('employee_id', $data['payroll'][2])
                              ->first();

        // If it has already data, return an error.
        if($checkDuplicate) {
          $rtrn = [
              'message' => 'Already created a payroll from ' . $data['payroll'][6] . ' to ' . $data['payroll'][7] . ' in this employee.',
              'status' => 'error'
            ];
        } else {
          $payroll = new Payroll();
          $payroll->employee_id           =  $data['payroll'][2];
          $payroll->basic_salary          =  $data['payroll'][0];
          $payroll->hourly_rate           =  $data['payroll'][1];
          $payroll->total_deductions      =  $data['payroll'][4];
          $payroll->sss                   =  $data['payroll'][3]['sss']             ??  null;
          $payroll->pagibig               =  $data['payroll'][3]['pagIbig']         ??  null;
          $payroll->philhealth            =  $data['payroll'][3]['philHealth']      ??  null;
          $payroll->tax                   =  $data['payroll'][3]['withHoldingTax']  ??  null;
          $payroll->absences              =  $data['payroll'][3]['absences']        ??  null;
          $payroll->net_salary            =  $data['payroll'][5];
          $payroll->payroll_date_from     =  $data['payroll'][6];
          $payroll->payroll_date_to       =  $data['payroll'][7];
          $payroll->status                =  'Generated';
          $payroll->created_by            =  Auth::id();
          $payroll->save();
          $rtrn = [
              'message' => 'Payroll successfully generated',
              'status' => 'success'
            ];
        }

        return $rtrn;
    }

    /**
     * Business logic for showing
     * all the employee attendance based on seleceted
     * date, and initialize payroll data.
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

    /**
     * Business logic for updating
     * generated payroll, either update the data
     * or update the status. [FROM GENERATED->PUBLISHED]
     */
    public function updateGeneratedPayroll(array $request)
    {

    }

    /**
     * Get all the payroll and filter
     * it based on the user's needs.
     */
    public function allPayroll(array $request)
    {
      // dd(Auth::user()->role);
      $name = $request['name'] ?? 'Guevarra';
      $payrollQuery = Payroll::join('employees as e', 'e.id', '=', 'payrolls.employee_id');

      if ($name) { // COALESCING to handle null values in middle name
        $payrollQuery->where(function ($query) use ($name) {
            $query->whereRaw("TRIM(CONCAT(e.first_name, ' ', COALESCE(e.middle_name, ''), ' ', e.last_name)) like ?", ["%{$name}%"])
                  ->orWhereRaw("TRIM(CONCAT(e.last_name, ' ', COALESCE(e.middle_name, ''), ' ', e.first_name)) like ?", ["%{$name}%"])
                  ->orWhereRaw("TRIM(CONCAT(e.first_name, ' ', e.last_name)) like ?", ["%{$name}%"])
                  ->orWhereRaw("TRIM(CONCAT(e.last_name, ' ', e.first_name)) like ?", ["%{$name}%"]);
        });
      }

      $payrolls = $payrollQuery->select(
                      DB::raw("TRIM(CONCAT(e.first_name, ' ', COALESCE(e.middle_name, ''), ' ', e.last_name)) as full_name"),
                      'e.position',
                      'payrolls.payroll_date_from',
                      'payrolls.payroll_date_to',
                      'payrolls.status'
                  )->get();

      return $payrolls;
    }
}
