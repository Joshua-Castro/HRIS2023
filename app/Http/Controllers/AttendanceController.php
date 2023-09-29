<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
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
        try {
            $time       =   $request->time ? $request->time             :   '';
            $userId     =   $request->user_id ? $request->user_id       :   '';
            $type       =   $request->type ? $request->type             :   '';

            $employee   =   DB::table('employees')->where('user_id', '=', $userId)->first();
            $data = [
                'user_id'                   =>  !empty($userId)         ?   $userId         :   '',
                'employee_id'               =>  !empty($employee->id)   ?   $employee->id   :   '',
                'time'                      =>  !empty($time)           ?   $time           :   '',
            ];

            switch ($type) {
                case 'clock-in' :
                    $result = $this->updateOrCreateAttendance('clock_in', $data);
                    return $result;
                break;
                case 'break-out' :
                    $this->updateOrCreateAttendance('break_out', $data);
                break;
                case 'break-in' :
                    $this->updateOrCreateAttendance('break_in', $data);
                break;
                case 'clock-out' :
                    $this->updateOrCreateAttendance('clock_out', $data);
                break;
            }

        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Processing to save in database
     */
    protected function updateOrCreateAttendance($column, $data)
    {
        try {
            $userId         =   !empty($data['user_id'])        ?   $data['user_id']                             :   '';
            $employeeId     =   !empty($data['employee_id'])    ?   $data['employee_id']                         :   '';
            $time           =   !empty($data['time'])           ?   date('H:i:s', strtotime($data['time']))      :   '';

            $attendance = DB::table('attendances')
                ->where('employee_id', $employeeId)
                ->whereNull($column)
                ->latest()
                ->first();

            if ($attendance === null) {
                DB::table('attendances')->insert([
                    'user_id'       =>  $userId,
                    'employee_id'   =>  $employeeId,
                    $column         =>  $time,
                    'created_at'    =>  now(),
                    'created_by'    =>  Auth::id()
                ]);

                // dd($userId, $employeeId, $time, $column);
                return response()->json(['message' => 'Successfully ' . $column]);
            } else {
                DB::table('attendances')
                    ->where('id', $attendance->id)
                    ->update([
                        $column         =>  $time,
                        'updated_at'    =>  now(),
                        'updated_by'    =>  Auth::id()
                ]);

                // return response()->json(['message' => 'Successfully ' . $column]);
            }

        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
