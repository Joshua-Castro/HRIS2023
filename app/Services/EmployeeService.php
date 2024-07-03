<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Str;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\ManualCascadeDeleteService;

class EmployeeService
{
    protected $cascadeDelete;
    protected $logService;

    public function __construct(ManualCascadeDeleteService $ManualCascadeDeleteService, LogService $logService)
    {
        $this->cascadeDelete   = $ManualCascadeDeleteService; // DELETE ALSO THE RELATED TABLES ['images','file_uploads','users']
        $this->logService      = $logService; // LOGS ALL THE ACTION THAT HAS BEEN TAKEN
    }

    /**
     * Business logic for storing
     * data in employee controller.
     */
    public function storeEmployee($request)
    {
        $imageData  =   '';
        $id         =   !empty($request->recordId) ? $request->recordId : null;
        $message    =   '';

        $token = uniqid() . now()->timestamp;
        $employeeAccount    =   $this->prepareEmployeeAccount($request, $token);
        $employeeData       =   $this->prepareEmployeeData($request, $token);

        if (empty($id)) { // CREATE OR STORE DATA
            // HANDLE IMAGE UPLOAD AND STORAGE
            $imageData = $this->uploadImage($request->userImage, null);
            $userId = $this->storeUserData($employeeAccount);
            $this->storeEmployeeData($employeeData, $userId);
            $this->storeEmployeeImage($imageData, $userId);

            $this->logService->logGenerate($userId, 'created', 'employees');
            $message = "Successfully Added";
            return $message;
        } else { // UPDATE DATA
            $imageData = $this->uploadImage($request->userImage, $id);
            $this->updateEmployeeData($employeeData, $id, $request->role);
            $this->updateEmployeeImage($imageData, $id);

            $this->logService->logGenerate($id, 'updated', 'employees');
            $message = "Successfully Updated";
            return $message;
        }
    }

    /**
     * Prepare Employee Account to save in users table.
     */
    private function prepareEmployeeAccount($request, $token)
    {
        return [
            'name'                  =>  $request->name,
            'token'                 =>  $token,
            'email'                 =>  $request->email,
            'password'              =>  Hash::make($request->password),
            'role'                  =>  !empty($request->role) ? $request->role : 3,
            'retrieve_password'     =>  $request->password
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
            $userImage = Employee::leftJoin('images as i', 'i.user_id', '=', 'employees.user_id')
                                ->where('employees.id', '=', $userId)
                                ->select(
                                    'i.file_path',
                                    'i.file_name'
                                )
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
     * Update employee image
     * when user edit the employee data
     */
    private function updateEmployeeImage($imageData, $employeeId)
    {
        try {
            $imageData['updated_by']        =  Auth::id();
            $imageData['updated_at']        =  now();
            $id = Employee::leftJoin('images as i', 'i.user_id', '=', 'employees.user_id')
                            ->where('employees.id', '=', $employeeId)
                            ->value('i.id');

            DB::table('images')->where('id', '=', $id)->update($imageData);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Update Employee Data from employees table.
     */
    private function updateEmployeeData($employeeData, $id, $role = null)
    {
        try {
            $employeeData['updated_by']     =  Auth::id();
            $employeeData['updated_at']     =  now();
            $userId = DB::table('employees')
                        ->select('user_id')
                        ->where('id', '=', $id)
                        ->value('user_id');

            DB::table('employees')->where('id', '=', $id)->update($employeeData);
            DB::table('users')->where('id', '=', $userId)->update(['role' => $role]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }
}
