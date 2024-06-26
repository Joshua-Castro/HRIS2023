<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Http\Requests\PayrollRequest;

class PayrollController extends Controller
{
    protected $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    /**
     * Store a payroll data based on final payroll
     * created by the HR / ADMIN
     */
    public function store(PayrollRequest $request)
    {
        try {
            $data = $this->payrollService->storePayroll($request->validated());
            if($data['status'] == 'error') {
                return response()->json(['message' => $data['message'], 'status' => $data['status']], 201);
            } else {
                return response()->json(['message' => $data['message'], 'status' => $data['status']], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update specific payroll data
     * only for HR/ADMIN
     */
    public function update(PayrollRequest $request)
    {
        try {

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occured: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get attendance record
     * of the employee that will generate the
     * payroll
     */
    public function getEmployeeAttendance(PayrollRequest $request)
    {
        try {
            $data = $this->payrollService->employeeAttendance($request->validated());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get generated payroll and
     * display in generate-payroll view
     */
    public function getAllPayroll(PayrollRequest $request)
    {
        try {
            $data = $this->payrollService->allPayroll($request->validated());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occured: ' . $e->getMessage()], 500);
        }
    }
}
