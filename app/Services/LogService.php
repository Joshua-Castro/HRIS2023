<?php

namespace App\Services;

use Carbon\Carbon;
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
    public function logGenerate($request, $method, $module, $path = null, $leaveId = null)
    {
        // TAKE NOTE THAT THE 'user_id' AND 'employee_id'
        // DATA IN THE LOGS TABLE ARE FROM THE DATA THAT HAS TAKEN AN ACTION EITHER (UPDATED, DELETED OR CREATED).
        // NOT THE CREATOR OF THE DATA IN LOGS TABLE.
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
                    case 'employees' :
                        $action     =   !empty($method) ? $method : "";
                        $userId     =   !empty($request) ? $request : "";
                        $message    =   $action === 'created' ? 'a new user and employee data.' : ($action === 'deleted' ? 'an employee data.' : 'an employee data.');
                        $userData   =   null;

                        if ($action === 'created') {
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

                        $description = " " . $action . " " . $message . " The employee id is: " . $userData->employee_id;

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

                    case 'file-uploads' :
                        $action         =   !empty($method) ? $method : "";
                        $employeeId     =   !empty($request) ? $request : "";
                        $message        =   $action === 'created' ? 'a new file to an employee: ' : 'a file from an employee: ';
                        $filePath       =   $path;

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

                    case 'leaves' :
                        $action     =   !empty($method) ? $method : "";
                        $userId     =   !empty($request) ? $request : "";
                        $leave = DB::table('leaves as l')
                                        ->select(
                                            'l.leave_type',
                                            'l.day_type',

                                            'lt.description as description'
                                            )
                                        ->leftJoin('leave_types as lt', 'lt.id', '=', 'l.leave_type')
                                        ->where('l.id', '=', $leaveId)
                                        ->first();
                        $message    =   $action === 'created' ? 'file a ' . $leave->description . ' request.' : ($action === 'deleted' ? ($leave->status === 'Pending' ? 'cancelled a ' . $leave->description . ' request.' : 'deleted a ' . $leave->description . ' request.') : 'updated a ' . $leave->description . ' leave request.');

                        $userData = DB::table('employees as e')
                                        ->select(
                                            'e.id as employee_id',
                                            'e.employee_no',
                                            'e.user_id',
                                            'u.id as user_id'
                                        )
                                        ->leftJoin('users as u', 'u.id', '=', 'e.user_id')
                                        ->where('u.id', '=', $userId)
                                        ->first();

                        $description = " " . $message . " Leave request ID is: " . $leaveId;

                        $data = [
                            'activity'      =>  $action,
                            'description'   =>  $description,
                            'message'       =>  $message . " Leave request ID is: " . $leaveId,
                            'creator_name'  =>  $fullName,
                            'action'        =>  $action,
                            'user_id'       =>  optional($userData)->user_id,
                            'employee_id'   =>  optional($userData)->employee_id,
                            'created_by'    =>  $logByiD,
                            'created_at'    =>  now(),
                        ];

                        DB::table('logs')->insert($data);
                    break;

                    case 'attendances' :
                        $attendance = DB::table('attendances')
                                        ->where('id', '=', $request['attendance_id'])
                                        ->first();
                        $action         =   !empty($method) ? $method : "";
                        $employeeId     =   !empty($request) ? $request['employee_id'] : "";
                        $message        =   "successfully " . $action . " at: " . Carbon::parse($request['time'])->format('h:i:s A') . " on " . Carbon::parse($attendance->attendance_date)->format('m/d/Y');

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

                        $description = " " . $message;

                        $data = [
                            'activity'      =>  $action,
                            'description'   =>  $description,
                            'message'       =>  $message,
                            'creator_name'  =>  $fullName,
                            'action'        =>  $action,
                            'user_id'       =>  optional($userData)->user_id,
                            'employee_id'   =>  optional($userData)->employee_id,
                            'created_by'    =>  $logByiD,
                            'created_at'    =>  now(),
                        ];

                        DB::table('logs')->insert($data);
                    break;

                    case 'attendance_update' :
                        $action             =   !empty($method)                 ?   $method                                                     :   "";
                        $employeeId         =   !empty($request)                ?   $request['employee_id']                                     :   "";
                        $column             =   !empty($request)                ?   $request['updated_columns']                                 :   "";
                        $clockIn            =   !empty($column['clock_in'])     ?   Carbon::parse($column['clock_in'])->format('h:i:s A')       :   "";
                        $clockOut           =   !empty($column['clock_out'])    ?   Carbon::parse($column['clock_out'])->format('h:i:s A')      :   "";
                        $updatedColumn      =   $clockIn ? $clockIn : $clockOut;
                        $messageDesc        =   $clockIn ? "clock in" : "clock out";
                        if (!empty($clockIn && $clockOut)) {
                            $updatedColumn  =   $clockIn . " and " . $clockOut;
                            $messageDesc    =   "clock in and clock out";
                        }
                        // dd($action, $employeeId, $column);
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
                        $message        =   "successfully " . $action . " the " . $messageDesc . " to " . $updatedColumn . " of this employee no. : " . $userData->employee_no;

                        $description = " " . $message;
                        $data = [
                            'activity'      =>  $action,
                            'description'   =>  $description,
                            'message'       =>  $message,
                            'creator_name'  =>  $fullName,
                            'action'        =>  $action,
                            'user_id'       =>  optional($userData)->user_id,
                            'employee_id'   =>  optional($userData)->employee_id,
                            'created_by'    =>  $logByiD,
                            'created_at'    =>  now(),
                        ];

                        DB::table('logs')->insert($data);
                    break;

                    case 'leave-status' :
                        $action     =   !empty($method)     ? $method   : "";
                        $userId     =   !empty($request)    ? $request  : "";
                        $leave = DB::table('leaves as l')
                                        ->select(
                                            'l.leave_type',
                                            'l.day_type',

                                            'lt.description as description'
                                            )
                                        ->leftJoin('leave_types as lt', 'lt.id', '=', 'l.leave_type')
                                        ->where('l.id', '=', $leaveId)
                                        ->first();
                        $message    =   $action === 'accepted' ? 'Accept the ' . $leave->description . ' request.' : 'Decline the ' . $leave->description . ' request.';

                        $userData = DB::table('employees as e')
                                        ->select(
                                            'e.id as employee_id',
                                            'e.employee_no',
                                            'e.user_id',
                                            'u.id as user_id'
                                        )
                                        ->leftJoin('users as u', 'u.id', '=', 'e.user_id')
                                        ->where('u.id', '=', $userId)
                                        ->first();

                        $description = " " . $message . " Leave request ID is: " . $leaveId;

                        $data = [
                            'activity'      =>  $action,
                            'description'   =>  $description,
                            'message'       =>  $message . " Leave request ID is: " . $leaveId,
                            'creator_name'  =>  $fullName,
                            'action'        =>  $action,
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
