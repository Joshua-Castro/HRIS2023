<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
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
        //
    }

    /**
     * Display the payroll data of a employee
     * based on their salay grade.
     */
    public function show(Request $request)
    {
        try {
            $employeeId = !empty($request->employeeId) ? $request->employeeId : "";

            $payrollData = DB::table('employees as e')
                            ->select(
                                'e.id as employee_id',
                                'e.position',
                                'e.station_code',
                                'e.employee_no',
                                'e.employment_status',
                                'e.date_hired',
                                'e.sss',
                                'e.pag_ibig',
                                'e.phil_health',
                                'e.salary_grade as salary_grade',

                                'sg.value as basic_salary',
                            )
                            ->leftJoin('salary_grades as sg', 'sg.id', '=', 'e.salary_grade')
                            ->where('e.id', '=', $employeeId)
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

            $attendanceData = DB::table('attendances')
                                    ->select('*')
                                    ->where('employee_id', '=', $employeeId)
                                    ->whereDate('attendance_date', '>=', $request->dateFrom)
                                    ->whereDate('attendance_date', '<=', $request->dateTo)
                                    ->orderBy('attendance_date', 'ASC')
                                    ->paginate(5);

            $indication     =   Str::random(16);

            return response()->json([$indication => base64_encode(json_encode($attendanceData))]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);

        }
    }
}
