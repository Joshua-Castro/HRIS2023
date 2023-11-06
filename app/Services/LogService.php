<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LogService
{
    /**
     * Put the activities on
     * Logs table
     */
    public function logGenerate($request, $method, $module)
    {
        try {
            DB::beginTransaction();
                $table   = !empty($module) ? $module : "";
                $action  = !empty($method) ? $method : "";
                switch ($table) {
                    case ('employees') :
                        $logByiD        =   Auth::id(); // ID OF THE ONE THAT CREATED THE NEW EMPLOYEE OR USER DATA
                        $userId         =   !empty($request) ? $request : ""; // ID OF THE NEWLY CREATED EMPLOYEE OR USER DATA
                        $fullName       =   "";
                        $message        =   "";
                        $description    =   "";
                        $logByUserData  =   DB::table('employees')
                                                ->select('*')
                                                ->where('user_id', '=', $logByiD)
                                                ->first();

                        $userData       =   DB::table('employees as e')
                                                ->select(
                                                    'e.id as employee_id',
                                                    'e.last_name',
                                                    'e.first_name',
                                                    'e.middle_name',

                                                    'u.id as userId'
                                                )
                                                ->leftJoin('users as u', 'u.id', '=', 'e.user_id')
                                                ->where('e.user_id', '=', $userId)
                                                ->first();

                        // CHECK IF THE SUPER ADMIN CREATED THE HR EMPLOYEE OR JUST EMPLOYEE ONLY
                        if (!empty($logByUserData)) {
                            $fullName       =   $logByUserData->first_name . " " . ($logByUserData->middle_name ? $logByUserData->middle_name : " ") . $logByUserData->last_name;
                        } else {
                            $logByUserAdmin = DB::table('users')
                                                ->select('*')
                                                ->where('id', '=', $logByiD)
                                                ->first();
                            $fullName       = !empty($logByUserAdmin->name) ? $logByUserAdmin->name : "";
                        }

                        switch ($action) {
                            case ('created') :
                                $message    =   'a new user and employee data.';
                            break;

                            case ('updated') :
                                $message    =   'a employee data.';
                            break;

                            case ('deleted') :
                                $message    =   'a user and employee data.';
                            break;
                            default:
                                // CODE TO HANDLE DEFAULT CASE (IF NONE OF THE ABOVE CASES MATCH)
                                // YOU CAN SET A DEFAULT MESSAGE OR PERFORM SOME FALLBACK ACTIONS
                                $message = 'Unknown action.';
                            break;
                        }

                        $description    =   $fullName . " " . $action . " " . $message;

                        // INITIALIZE THE DATA THAT WILL BE SAVED IN THE 'logs' TABLE
                        $data = [
                            'activity'      =>  !empty($action) ? $action : "",
                            'description'   =>  $description,
                            'message'       =>  $message,
                            'creator_name'  =>  $fullName,
                            'action'        =>  !empty($action)                     ?   $action                     :   "",
                            'user_id'       =>  !empty($userId)                     ?   $userId                     :   "",
                            'employee_id'   =>  !empty($userData->employee_id)      ?   $userData->employee_id      :   "",
                            'created_by'    =>  $logByiD,
                            'created_at'    =>  now(),
                        ];

                        DB::table('logs')->insert($data);
                        break;
                }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }
}
