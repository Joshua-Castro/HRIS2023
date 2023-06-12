<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        $id = !empty($request->recordId) ? $request->recordId : 0;
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
                $data['created_by'] = Auth::id();
                $data['created_at'] = now();
                DB::table('employees')->insert($data);

                return response()->json(['message' => 'Successfully Added'], 200);
        } else {
            // UPDATE DATA
            $data['updated_by'] = Auth::id();
            $data['updated_at'] = now();
            DB::table('employees')->where('id','=',$id)->update($data);

            return response()->json(['message' => 'Successfully Updated'],200);
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $data = DB::table('employees')
                ->select('*')
                ->whereNull('deleted_at')
                ->get();

        $count = DB::table('employees')
                ->whereNull('deleted_at')
                ->count();

        // $status = request('status');
        // $name = request('name');
        // $pagination = request('pagination');
        // $usersQuery = User::query();

        // // Include the company name in the query using a join
        // $usersQuery->join('companies', 'users.company_id', '=', 'companies.id')
        //     ->select('users.*', 'companies.name as company_name');

        // if ($name) {
        //     $usersQuery->where(function ($query) use ($name) {
        //         $query->whereRaw("CONCAT(firstname,' ',COALESCE(middlename, ''),' ',lastname) like ?", ["%{$name}%"])
        //             ->orWhereRaw("CONCAT(lastname,' ',COALESCE(middlename, ''),' ',firstname) like ?", ["%{$name}%"])
        //             ->orWhereRaw("CONCAT(firstname,' ',lastname) like ?", ["%{$name}%"])
        //             ->orWhereRaw("CONCAT(lastname,' ',firstname) like ?", ["%{$name}%"]);
        //     });
        // }
        // if ($status !== 'all') {
        //     $usersQuery->where('users.status', $status);
        // }
        // $users = $usersQuery->paginate($pagination);
        // return $users;
        
        return response()->json(['data' => $data, 'count' => $count]);
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
        $data = DB::table('employees')->where('id','=',$request->id)
            ->update([
                'deleted_by' => Auth::id(),
                'deleted_at' => now(),
            ]);

        return response()->json(['message' => 'Successfully Deleted']);
    }
}
