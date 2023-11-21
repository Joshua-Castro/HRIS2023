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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Payroll $payroll)
    {
        try {
            $validatedData = $request->validate([
                'dateFrom' => 'required|date_format:Y-m-d',
                'dateTo' => 'required|date_format:Y-m-d',
            ]);

            $employeeId     =   !empty($request->employeeId)            ?   $request->employeeId            :   "";
            $dateFrom       =   !empty($validatedData['dateFrom'])      ?   Carbon::parse($validatedData['dateFrom'])      :   "";
            $dateTo         =   !empty($validatedData['dateTo'])        ?   Carbon::parse($validatedData['dateTo'])        :   "";

            $employeeAttendance = DB::table('attendances as a')
                                ->select(
                                    'a.clock_in',
                                    'a.clock_out',
                                    'a.break_in',
                                    'a.break_out',
                                    'a.total_hours',
                                    'a.attendance_date',
                                )
                                ->where('a.employee_id', '=', $employeeId)
                                ->whereDate('a.attendance_date', '>=', $dateFrom)
                                ->whereDate('a.attendance_date', '<=', $dateTo)
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
