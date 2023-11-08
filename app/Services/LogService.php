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
    public function logGenerate($request, $method, $module, $path = null)
    {
        try {
            DB::beginTransaction();
                $logByiD = Auth::id();
                $logByUserData = DB::table('employees')
                    ->select('*')
                    ->where('user_id', '=', $logByiD)
                    ->first();

                $fullName = !empty($logByUserData)
                    ? $logByUserData->first_name . " " . ($logByUserData->middle_name ? $logByUserData->middle_name : " ") . " " .$logByUserData->last_name
                    : DB::table('users')
                        ->select('name')
                        ->where('id', '=', $logByiD)
                        ->value('name');

                switch ($module) {
                    case 'employees':
                        $action     =   !empty($method) ? $method : "";
                        $userId     =   !empty($request) ? $request : "";
                        $message    =   '';
                        $userData   =   null;

                        if ($action === 'created') {
                            $message    = 'a new user and employee data.';
                            $userData   = DB::table('employees as e')
                                            ->select(
                                                'e.id as employee_id',
                                                'e.last_name',
                                                'e.first_name',
                                                'e.middle_name',
                                                'u.id as user_id'
                                            )
                                            ->leftJoin('users as u', 'u.id', '=', 'e.user_id')
                                            ->where('u.id', '=', $userId)
                                            ->first();
                        } elseif ($action === 'updated' || $action === 'deleted') {
                            $message    = 'an employee data.';
                            $userData   = DB::table('users as u')
                                            ->select(
                                                'e.id as employee_id',
                                                'e.last_name',
                                                'e.first_name',
                                                'e.middle_name',
                                                'u.id as user_id'
                                            )
                                            ->leftJoin('employees as e', 'e.user_id', '=', 'u.id')
                                            ->where('e.id', '=', $userId)
                                            ->first();
                        }

                        $description = " " . $action . " " . $message;

                        $data = [
                            'activity'          =>  $action,
                            'description'       =>  $description,
                            'message'           =>  $message,
                            'creator_name'      =>  $fullName,
                            'action'            =>  $action,
                            'user_id'           =>  optional($userData)->user_id,
                            'employee_id'       =>  optional($userData)->employee_id,
                            'created_by'        =>  $logByiD,
                            'created_at'        =>  now(),
                        ];

                        DB::table('logs')->insert($data);
                    break;

                    case 'file-uploads':
                        $employeeId     =   !empty($request) ? $request : "";
                        $message        =   '';
                        $userData       =   null;
                        $filePath       =   $path;

                        if ($method === 'created') {
                            $message = 'a new file to an employee: ';
                        } elseif ($method === 'deleted') {
                            $message = 'a file from an employee: ';
                        }

                        $userData = DB::table('employees as e')
                                        ->select(
                                            'e.id as employee_id',
                                            'e.employee_no',
                                            'e.user_id',
                                            'u.id as user_id'
                                        )
                                        ->leftJoin('users as u', 'u.id', '=', 'e.user_id')
                                        ->where('e.id', '=', $employeeId)
                                        ->first();

                        $description = " " . $method . " " . $message . $userData->employee_no . ". The file path: " . $filePath;

                        $data = [
                            'activity'      =>  $method,
                            'description'   =>  $description,
                            'message'       =>  $message . $userData->employee_no,
                            'creator_name'  =>  $fullName,
                            'action'        =>  $method,
                            'user_id'       =>  optional($userData)->user_id,
                            'employee_id'   =>  optional($userData)->employee_id,
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
