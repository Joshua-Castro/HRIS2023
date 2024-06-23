<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a payroll data based on final payroll
     * created or will create by the HR / ADMIN
     */
    public function store(Request $request)
    {
        try {
            $payroll = new Payroll();
            $payroll->employee_id           = $request->items['employee_id'];
            $payroll->basic_salary          = '';
            $payroll->overtime_hours        = '';
            $payroll->bonuses               = '';
            $payroll->total_deductions      = $request->items['total_deductions'];
            $payroll->sss                   = $request->items['deductions']['sss'];
            $payroll->pagibig               = $request->items['deductions']['pagIbig'];
            $payroll->philhealth            = $request->items['deductions']['philHealth'];
            $payroll->absences              = $request->items['deductions']['absences'];
            $payroll->tax                   = $request->items['deductions']['withHoldingTax'];
            $payroll->allowances            = '';
            $payroll->net_salary            = $request->items['net_pay'];
            $payroll->payroll_date_from     = '';
            $payroll->payroll_date_to       = '';
            $payroll->payment_date          = '';
            $payroll->payment_method        = '';
            dd($request->all(), $payroll, 'PAYROLL CONTROLLER');
            // $payroll->save();
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Display the payroll data of a employee
     * based on their salay grade.
     */
    public function show(Request $request)
    {
        try {
            $employeeId = !empty($request->employeeId) ? $request->employeeId : "";

            $payrollData = Employee::leftJoin('salary_grades as sg', 'sg.id', '=', 'employees.salary_grade')
                                    ->where('employees.id', '=', $employeeId)
                                    ->select('employees.*', 'sg.value as basic_salary')
                                    ->get();

        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        //
    }

    /**
     * Get attendance record
     * of the employee that will generate the
     * payroll
     */
    public function getEmployeeAttendance(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'dateFrom' => 'required|date_format:Y-m-d',
                'dateTo'   => 'required|date_format:Y-m-d',
            ]);

            $employeeId = !empty($request->employeeId) ? $request->employeeId : "";

            $attendanceData = Attendance::where('employee_id', '=', $employeeId)
                                    ->whereDate('attendance_date', '>=', $request->dateFrom)
                                    ->whereDate('attendance_date', '<=', $request->dateTo);

            $totalWorkingHours  =   $attendanceData->sum('regular_hours');
            $attendanceData     =   $attendanceData->orderBy('attendance_date', 'ASC')->paginate(10);
            $indication         =   Str::random(16);
            $indication2        =   Str::random(16);

            return response()->json([
                $indication => base64_encode(json_encode($attendanceData)),
                $indication2 => base64_encode(json_encode($totalWorkingHours))
            ]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);

        }
    }
}
