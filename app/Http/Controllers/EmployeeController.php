<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\LogService;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Services\ManualCascadeDeleteService;


class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService   = $employeeService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        try {
            $message = $this->employeeService->storeEmployee((object) $request->validated());
            return response()->json(['message' => $message], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display employee data on
     * HR or ADMIN SIDE. Used in employee
     * and payroll side
     */
    public function show(Request $request, Employee $employee)
    {
        try {
            $request->validate([
                'name'          =>  'nullable|string',
                'status'        =>  'nullable|in:all,Male,Female',
                'pagination'    =>  'nullable|integer',
            ]);

            $totalEmployeesCount = DB::table('employees')
                ->whereNull('deleted_at')
                ->count();

            $thirtyDaysAgo = now()->subDays(30);
            $newEmployees = DB::table('employees')
                            ->where('date_hired', '>=', $thirtyDaysAgo)
                            ->whereNull('deleted_at')
                            ->count();

            $status         =   $request->input('status');
            $name           =   $request->input('name');
            $pagination     =   $request->input('pagination');
            $usersQuery     =   Employee::query();

            if ($name) {
                $usersQuery->where(function ($query) use ($name) {
                    $query->whereRaw("CONCAT(first_name,' ',COALESCE(middle_name, ''),' ',last_name) like ?", ["%{$name}%"])
                        ->orWhereRaw("CONCAT(last_name,' ',COALESCE(middle_name, ''),' ',first_name) like ?", ["%{$name}%"])
                        ->orWhereRaw("CONCAT(first_name,' ',last_name) like ?", ["%{$name}%"])
                        ->orWhereRaw("CONCAT(last_name,' ',first_name) like ?", ["%{$name}%"]);
                });
            }
            if ($status !== 'all') {
                $usersQuery->where('employees.gender', $status);
            }
            $users = $usersQuery
                    ->leftJoin('users', 'employees.user_id', '=', 'users.id')
                    ->leftJoin('images', 'images.user_id', '=', 'users.id')
                    ->leftJoin('salary_grades as sg', 'sg.id', '=', 'employees.salary_grade')
                    ->select(
                        'employees.id as employee_id',
                        'employees.last_name',
                        'employees.first_name',
                        'employees.middle_name',
                        'employees.gender',
                        'employees.maiden_name',
                        'employees.position',
                        'employees.last_promotion',
                        'employees.station_code',
                        'employees.control_no',
                        'employees.employee_no',
                        'employees.school_code',
                        'employees.item_number',
                        'employees.employment_status',
                        'employees.date_hired',
                        'employees.sss',
                        'employees.pag_ibig',
                        'employees.phil_health',
                        'employees.employee_token',

                        'users.id as user_id',
                        'users.name',
                        'users.email',
                        'users.password',
                        'users.created_at',
                        'users.role as role',

                        'images.file_path as image_filepath',
                        'images.file_name as image_filename',

                        'sg.description as salary_grade',
                        'sg.value as salary',
                        )
                    ->paginate($pagination);

            $salaryGrade    =   DB::table('salary_grades')
                                    ->select('*')
                                    ->get();

            $indication     =   Str::random(16);
            $indication2    =   Str::random(16);
            $indication3    =   Str::random(16);
            $indication4    =   Str::random(16);
            return response()->json([
                $indication         =>  base64_encode(json_encode($users)),
                $indication2        =>  $totalEmployeesCount,
                $indication3        =>  $newEmployees,
                $indication4        =>  base64_encode(json_encode($salaryGrade))
            ]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $id   = !empty($request->id) ? $request->id : "";
            $this->logService->logGenerate($id, 'deleted', 'employees');
            $data = DB::table('employees')
                ->where('id','=', $id)
                ->update([
                    'deleted_by' => Auth::id(),
                    'deleted_at' => now(),
                ]);

            $this->cascadeDelete->delete($request);
            return response()->json(['message' => 'Successfully Deleted']);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    public function employeeView()
    {
        return view('employee-home');
    }
}
