<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'lastName'         =>  'required',
    //         'firstName'        =>  'required',
    //         'position'         =>  'required',
    //         'lastPromotion'    =>  'required',
    //         'stationCode'      =>  'required',
    //         'controlNumber'    =>  'required',
    //         'employeeNumber'   =>  'required',
    //         'schoolCode'       =>  'required',
    //         'itemNumber'       =>  'required',
    //         'employeeStatus'   =>  'required',
    //         'salaryGrade'      =>  'required',
    //         'dateHired'        =>  'required',
    //         'sss'              =>  'required',
    //         'pagIbig'          =>  'required',
    //         'philHealth'       =>  'required',
    //         'userImage'        =>  'required|string'
    //     ]);

    //     // DECODE THE BASE64 IMAGE DATA TO SAVE IN DATABASE
    //     $base64Image    =   $request->input('userImage');
    //     $decodedImage   =   base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

    //     // GENERATE UNIQUE FILE NAME FOR THE IMAGE
    //     $fileName       =   time() . '_' . uniqid() . '.png';

    //     // SAVE THE IMAGE TO STORAGE OR PUBLIC DIRECTORY
    //     $filePath = public_path('images/' . $fileName);
    //     file_put_contents($filePath, $decodedImage);

    //     try {
    //         Validator::make($request->all(), [
    //             // 'name'      => ['required', 'string', 'max:255'],
    //             'email'     => ['required', 'string', 'max:255', 'unique:users'],
    //             'password'  => ['required', 'string', 'min:8', 'confirmed'],
    //         ]);

    //         $id = !empty($request->recordId) ? $request->recordId : 0;

    //         $employeeAccount    =   [
    //             'name'              =>      $request->name,
    //             'email'             =>      $request->email,
    //             'password'          =>      Hash::make($request->password),
    //         ];

    //         $data = [
    //             'last_name'             =>      !empty($request->lastName)             ?   $request->lastName             :  '',
    //             'first_name'            =>      !empty($request->firstName)            ?   $request->firstName            :  '',
    //             'middle_name'           =>      !empty($request->middleName)           ?   $request->middleName           :  '',
    //             'gender'                =>      !empty($request->gender)               ?   $request->gender               :  '',
    //             'maiden_name'           =>      !empty($request->maidenName)           ?   $request->maidenName           :  '',
    //             'position'              =>      !empty($request->position)             ?   $request->position             :  '',
    //             'last_promotion'        =>      !empty($request->lastPromotion)        ?   $request->lastPromotion        :  '',
    //             'station_code'          =>      !empty($request->stationCode)          ?   $request->stationCode          :  '',
    //             'control_no'            =>      !empty($request->controlNumber)        ?   $request->controlNumber        :  '',
    //             'employee_no'           =>      !empty($request->employeeNumber)       ?   $request->employeeNumber       :  '',
    //             'school_code'           =>      !empty($request->schoolCode)           ?   $request->schoolCode           :  '',
    //             'item_number'           =>      !empty($request->itemNumber)           ?   $request->itemNumber           :  '',
    //             'employment_status'     =>      !empty($request->employeeStatus)       ?   $request->employeeStatus       :  '',
    //             'salary_grade'          =>      !empty($request->salaryGrade)          ?   $request->salaryGrade          :  '',
    //             'date_hired'            =>      !empty($request->dateHired)            ?   $request->dateHired            :  '',
    //             'sss'                   =>      !empty($request->sss)                  ?   $request->sss                  :  '',
    //             'pag_ibig'              =>      !empty($request->pagIbig)              ?   $request->pagIbig              :  '',
    //             'phil_health'           =>      !empty($request->philHealth)           ?   $request->philHealth           :  '',
    //         ];

    //         // Store the file path or URL in your database
    //         $imageData = [
    //             'file_name' => $fileName,
    //             'file_path' => '/images/' . $fileName,
    //         ];

    //         if (empty($id)) { // CREATE OR STORE DATA
    //                 // STORE NEWLY CREATED EMPLOYEE'S ACCOUNT TO USERS TABLE
    //                 $employeeAccount['created_at'] = now();
    //                 $userId = DB::table('users')->insertGetId($employeeAccount);

    //                 // STORE EMPLOYEE'S DATA TO EMPLOYEES TABLE
    //                 $data['created_by'] = Auth::id();
    //                 $data['created_at'] = now();
    //                 $data['user_id']    = $userId;
    //                 DB::table('employees')->insert($data);

    //                 // STORE EMPLOYEE || USER IMAGE TO IMAGES TABLE
    //                 $imageData['created_by']    =   Auth::id();
    //                 $imageData['created_at']    =   now();
    //                 $imageData['user_id']       =   $userId;
    //                 DB::table('images')->insert($imageData);

    //                 return response()->json(['message' => 'Successfully Added'], 200);
    //         } else { // UPDATE DATA
    //             // UPDATE USER ACCOUNT IF NEEDED
    //             $employeeAccount['updated_at'] = now();
    //             DB::table('users')->where('id','=', $request->userId)->update($employeeAccount);

    //             // UPDATE EMPLOYEE DATA WHEN THEY WANT TO CHANGE IN THEIR PREFERENCES
    //             $data['updated_by'] = Auth::id();
    //             $data['updated_at'] = now();
    //             DB::table('employees')->where('id','=',$id)->update($data);

    //             return response()->json(['message' => 'Successfully Updated'],200);
    //         }
    //     } catch (QueryException $e) {
    //         $errorMessage = $e->getMessage();
    //         return response()->json(['error' => $errorMessage], 500);
    //     }
    // }

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
            'userImage'        =>  'required|string'
        ]);

        // HANDLE IMAGE UPLOAD AND STORAGE
        $imageData = $this->uploadImage($request->input('userImage'));

        try {
            Validator::make($request->all(), [
                'email'     => ['required', 'string', 'max:255', 'unique:users'],
                'password'  => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $id = $request->input('recordId');

            $employeeAccount    =   $this->prepareEmployeeAccount($request);
            $employeeData       =   $this->prepareEmployeeData($request, $imageData);

            if (empty($id)) { // CREATE OR STORE DATA
                $userId = $this->storeUserData($employeeAccount);
                $this->storeEmployeeData($employeeData, $userId);
                $this->storeEmployeeImage($imageData, $userId);

                return response()->json(['message' => 'Successfully Added'], 200);
            } else { // UPDATE DATA
                $this->updateEmployeeData($employeeData, $id);

                return response()->json(['message' => 'Successfully Updated'], 200);
            }
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Handle uploading image function.
     */
    private function uploadImage($base64Image)
    {
        $decodedImage   =   base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $fileName       =   time() . '_' . uniqid() . '.png';
        // Save the image to the storage directory
        Storage::disk('public')->put('uploads/images/' . $fileName, $decodedImage);
        return [
            'file_name'     =>  $fileName,
            'file_path'     =>  'uploads/images/' . $fileName,
        ];
    }

    /**
     * Prepare Employee Account to save in users table.
     */
    private function prepareEmployeeAccount($request)
    {
        return [
            'name'      =>  $request->input('name', ''),
            'email'     =>  $request->input('email', ''),
            'password'  =>  Hash::make($request->input('password')),
        ];
    }

    /**
     * Prepare Employee Data to save in employees table.
     */
    private function prepareEmployeeData($request, $imageData)
    {
        return [
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
    }

    /**
     * Store Employee Account to users table.
     */
    private function storeUserData($employeeAccount)
    {
        try {
            $employeeAccount['created_at'] = now();
            return DB::table('users')->insertGetId($employeeAccount);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Store Employee Data to employees table.
     */
    private function storeEmployeeData($employeeData, $userId)
    {
        try {
            $employeeData['created_by']     =  Auth::id();
            $employeeData['created_at']     =  now();
            $employeeData['user_id']        =  $userId;
            DB::table('employees')->insert($employeeData);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Store Employee Image to images table. Reference user_id
     */
    private function storeEmployeeImage($imageData, $userId)
    {
        try {
            $imageData['created_by']        =  Auth::id();
            $imageData['created_at']        =  now();
            $imageData['user_id']           =  $userId;
            DB::table('images')->insert($imageData);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Update Employee Data from employees table.
     */
    private function updateEmployeeData($employeeData, $id)
    {
        try {
            $employeeData['updated_by']     =  Auth::id();
            $employeeData['updated_at']     =  now();
            DB::table('employees')->where('id', '=', $id)->update($employeeData);
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
        try {
            $totalEmployeesCount = DB::table('employees')
                ->whereNull('deleted_at')
                ->count();

            $thirtyDaysAgo = now()->subDays(30);
            $newEmployees = DB::table('employees')
                            ->where('date_hired', '>=', $thirtyDaysAgo)
                            ->whereNull('deleted_at')
                            ->count();

            $status         =   request('status');
            $name           =   request('name');
            $pagination     =   request('pagination');
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

                        'images.file_path as image_filepath',
                        'images.file_name as image_filename',
                        )
                    ->paginate($pagination);

            return response()->json([
                'users'             =>  $users,
                'count'             =>  $totalEmployeesCount,
                'newEmployees'      =>  $newEmployees
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
