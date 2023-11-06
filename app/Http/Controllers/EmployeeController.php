<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Services\LogService;
use App\Services\ManualCascadeDeleteService;


class EmployeeController extends Controller
{
    protected $cascadeDelete;
    protected $logService;

    public function __construct(ManualCascadeDeleteService $ManualCascadeDeleteService, LogService $logService)
    {
        $this->cascadeDelete   = $ManualCascadeDeleteService; // DELETE ALSO THE RELATED TABLES ['images','file_uploads','users']
        $this->logService      = $logService; // LOGS ALL THE ACTION THAT HAS BEEN TAKEN
    }

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
        try {
            $request->validate([
                'lastName'         =>  'required',
                'firstName'        =>  'required',
                'position'         =>  'required',
                'lastPromotion'    =>  'required|date_format:Y-m-d',
                'stationCode'      =>  'required',
                'controlNumber'    =>  'required',
                'employeeNumber'   =>  'required',
                'schoolCode'       =>  'required',
                'itemNumber'       =>  'required',
                'employeeStatus'   =>  'required',
                'salaryGrade'      =>  'required',
                'dateHired'        =>  'required|date_format:Y-m-d',
                'sss'              =>  'required',
                'pagIbig'          =>  'required',
                'philHealth'       =>  'required',
                'userImage'        =>  'required|string'
            ]);


            Validator::make($request->all(), [
                'email'     => ['required', 'string', 'max:255', 'unique:users'],
                'password'  => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $imageData  =   '';
            $id         =   $request->input('recordId');

            $token = uniqid() . now()->timestamp;
            $employeeAccount    =   $this->prepareEmployeeAccount($request, $token);
            $employeeData       =   $this->prepareEmployeeData($request, $token);

            if (empty($id)) { // CREATE OR STORE DATA
                // HANDLE IMAGE UPLOAD AND STORAGE
                $imageData = $this->uploadImage($request->input('userImage'), null);
                $userId = $this->storeUserData($employeeAccount);
                $this->storeEmployeeData($employeeData, $userId);
                $this->storeEmployeeImage($imageData, $userId);

                $this->logService->logGenerate($userId, 'created', 'employees');
                return response()->json(['message' => 'Successfully Added'], 200);
            } else { // UPDATE DATA
                $imageData = $this->uploadImage($request->input('userImage'), $id);
                $this->updateEmployeeData($employeeData, $id);
                $this->updateEmployeeImage($imageData, $id);

                $this->logService->logGenerate($id, 'updated', 'employees');
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
    private function uploadImage($base64Image, $userId = null)
    {
        $fileName       =   null;
        $decodedImage   =   null;

        // CHECK IF THE $base64Image IS A BASE-64-ENCODED IMAGE
        if (strpos($base64Image, 'data:image/') === 0) {
            $fileName       =   time() . '_' . uniqid() . '.png';
            $decodedImage   =   base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        } else {
            $path           =   $base64Image;
            $fileName       =   basename($path);
            $decodedImage   =   file_get_contents($path);
        }

        // CHECK IF THERE IS AN EXISTING IMAGE FOR THE USER
        if ($userId) {
            $userImage = DB::table('employees as e')
                        ->select(
                            'e.id',
                            'e.user_id',

                            'i.file_path',
                            'i.file_name'
                            )
                        ->leftJoin('images as i', 'i.user_id' , '=', 'e.user_id')
                        ->where('e.id', '=', $userId)
                        ->first();

            if ($userImage) {
                Storage::disk('public')->delete($userImage->file_path);
            }
        }

        // SAVE THE NEW IMAGE TO THE STORAGE DIRECTORY
        Storage::disk('public')->put('uploads/images/' . $fileName, $decodedImage);

        return [
            'file_name' => $fileName,
            'file_path' => 'uploads/images/' . $fileName,
        ];
    }

    /**
     * Prepare Employee Account to save in users table.
     */
    private function prepareEmployeeAccount($request, $token)
    {
        return [
            'name'                  =>  $request->input('name', ''),
            'token'                 =>  $token,
            'email'                 =>  $request->input('email', ''),
            'password'              =>  Hash::make($request->input('password')),
            'role'                  =>  !empty($request->input('role')) ? $request->input('role') : 3,
            'retrieve_password'     =>  $request->input('password')
        ];
    }

    /**
     * Prepare Employee Data to save in employees table.
     */
    private function prepareEmployeeData($request, $token)
    {
        return [
            'employee_token'        =>      !empty($token)                         ?   $token                         :  '',
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

    public function updateEmployeeImage($imageData, $userId)
    {
        try {
            $imageData['updated_by']        =  Auth::id();
            $imageData['updated_at']        =  now();
            $id = DB::table('employees as e')
                        ->select(
                            'e.id as employee_id',
                            'e.user_id',

                            'i.id as image_id',
                            'i.file_path',
                            'i.file_name'
                            )
                        ->leftJoin('images as i', 'i.user_id' , '=', 'e.user_id')
                        ->where('e.id', '=', $userId)
                        ->first();

            DB::table('images')->where('id', '=', $id->image_id)->update($imageData);
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
                        'employees.employee_token',

                        'users.id as user_id',
                        'users.name',
                        'users.email',
                        'users.password',
                        'users.created_at',
                        'users.role as role',

                        'images.file_path as image_filepath',
                        'images.file_name as image_filename',
                        )
                    ->paginate($pagination);

            $indication     =   Str::random(16);
            $indication2    =   Str::random(16);
            $indication3    =   Str::random(16);
            return response()->json([
                $indication         =>  base64_encode(json_encode($users)),
                $indication2        =>  $totalEmployeesCount,
                $indication3        =>  $newEmployees
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
            $data = DB::table('employees')
                ->where('id','=', $id)
                ->update([
                    'deleted_by' => Auth::id(),
                    'deleted_at' => now(),
                ]);

            $this->cascadeDelete->delete($request);
            $this->logService->logGenerate($id, 'deleted', 'employees');
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
