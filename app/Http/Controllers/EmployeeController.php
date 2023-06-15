<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;



class EmployeeController extends Controller
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
        $request->validate([
            'lastName'         =>  'required',
            'firstName'        =>  'required',
            'position'         =>  'required',
            'lastPromotion'    =>  'required',
            'stationCode'      =>  'required',
            'controlNumber'    =>  'required',
            'employeeNumber'   =>  'required',
            'schoolCode'       =>  'required',
            'itemNumber'       =>  'required',
            'employeeStatus'   =>  'required',
            'salaryGrade'      =>  'required',
            'dateHired'        =>  'required',
            'sss'              =>  'required',
            'pagIbig'          =>  'required',
            'philHealth'       =>  'required',
        ]);

        try {
            Validator::make($request->all(), [
                'name'      => ['required', 'string', 'max:255'],
                'email'     => ['required', 'string', 'max:255', 'unique:users'],
                'password'  => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $id = !empty($request->recordId) ? $request->recordId : 0;

            $employeeAccount    =   [
                'name'              =>      $request->name,
                'email'             =>      $request->email,
                'password'          =>      Hash::make($request->password),
            ];

            $data = [
                'last_name'             =>      !empty($request->lastName)             ?   $request->lastName             :  '',
                'first_name'            =>      !empty($request->firstName)            ?   $request->firstName            :  '',
                'middle_name'           =>      !empty($request->middleName)           ?   $request->middleName           :  '',
                'gender'                =>      !empty($request->gender)               ?   $request->gender               :  '',
                'maiden_name'           =>      !empty($request->maidenName)           ?   $request->maidenName           :  '',
                'position'              =>      !empty($request->position)             ?   $request->position             :  '',
                'last_promotion'        =>      !empty($request->lastPromotion)        ?   $request->lastPromotion        :  '',
                'station_code'          =>      !empty($request->stationCode)          ?   $request->stationCode          :  '',
                'control_no'            =>      !empty($request->controlNumber)        ?   $request->controlNumber        :  '',
                'employee_no'           =>      !empty($request->employeeNumber)       ?   $request->employeeNumber       :  '',
                'school_code'           =>      !empty($request->schoolCode)           ?   $request->schoolCode           :  '',
                'item_number'           =>      !empty($request->itemNumber)           ?   $request->itemNumber           :  '',
                'employment_status'     =>      !empty($request->employeeStatus)       ?   $request->employeeStatus       :  '',
                'salary_grade'          =>      !empty($request->salaryGrade)          ?   $request->salaryGrade          :  '',
                'date_hired'            =>      !empty($request->dateHired)            ?   $request->dateHired            :  '',
                'sss'                   =>      !empty($request->sss)                  ?   $request->sss                  :  '',
                'pag_ibig'              =>      !empty($request->pagIbig)              ?   $request->pagIbig              :  '',
                'phil_health'           =>      !empty($request->philHealth)           ?   $request->philHealth           :  '',
            ];

            if (empty($id)) {
                    // CREATE OR STORE DATA
                    $employeeAccount['created_at'] = now();
                    $userId = DB::table('users')->insertGetId($employeeAccount);

                    $data['created_by'] = Auth::id();
                    $data['created_at'] = now();
                    $data['user_id']    = $userId;

                    DB::table('employees')->insert($data);

                    return response()->json(['message' => 'Successfully Added'], 200);
            } else {
                // UPDATE DATA
                $employeeAccount['updated_at'] = now();
                DB::table('users')->where('id','=', $request->userId)->update($employeeAccount);

                $data['updated_by'] = Auth::id();
                $data['updated_at'] = now();
                DB::table('employees')->where('id','=',$id)->update($data);

                return response()->json(['message' => 'Successfully Updated'],200);
            }
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $count = DB::table('employees')
                ->whereNull('deleted_at')
                ->count();

        $status = request('status');
        $name = request('name');
        $pagination = request('pagination');
        $usersQuery = Employee::query();

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
                ->join('users', 'employees.user_id', '=', 'users.id')
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
                    'employees.salary_grade',
                    'employees.date_hired',
                    'employees.sss',
                    'employees.pag_ibig',
                    'employees.phil_health',

                    'users.id as user_id',
                    'users.name',
                    'users.email',
                    'users.password',
                    'users.created_at',
                    )
                ->paginate($pagination);

        return response()->json(['users' => $users, 'count' => $count]);
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
        $data = DB::table('employees')
            ->where('id','=', $request->id)
            ->update([
                'deleted_by' => Auth::id(),
                'deleted_at' => now(),
            ]);
        
        $user = DB::table('users')
            ->where('id', '=', $request->userId)
            ->delete();

        return response()->json(['message' => 'Successfully Deleted']);
    }

    public function employeeView()
    {
        return view('employee-home');
    }
}
