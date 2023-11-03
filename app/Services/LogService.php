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
                        $logByUserData  =   DB::table('employees')
                                                ->select('*')
                                                ->where('user_id', '=', $logByiD)
                                                ->first();
                        $userData       =   DB::table('employees as e')
                                                ->select(
                                                    'e.last_name',
                                                    'e.first_name',
                                                    'e.middle_name',

                                                    'u.id as userId'
                                                )
                                                ->leftJoin('users as u', 'u.id', '=', 'e.user_id')
                                                ->where('e.user_id', '=', $userId)
                                                ->first();

                        $fullName       =   $logByUserData->first_name . " " . ($logByUserData->middle_name ? $logByUserData->middle_name : " ") . $logByUserData->last_name;
                        $data = [
                            'activity'      => !empty($action) ? $action : "",
                            'creator_name'  => $fullName,
                            'message'       => ' a new user and employee data.',
                            'description'   => $fullName . " " . $action . ' a new user and employee data.',
                            'action'        => !empty($action) ? $action : "",
                            'created_by'    => $logByiD,
                            'created_at'    => now(),
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
