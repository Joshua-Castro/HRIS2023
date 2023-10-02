<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Storage;
use function Symfony\Component\HttpKernel\DataCollector\getMessage;

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
            $time       =   $request->time         ?    $request->time          :   '';
            $userId     =   $request->user_id      ?    $request->user_id       :   '';
            $type       =   $request->type         ?    $request->type          :   '';

            $employee   =   DB::table('employees')->where('user_id', '=', $userId)->first();
            $data = [
                'user_id'                   =>  !empty($userId)         ?   $userId         :   '',
                'employee_id'               =>  !empty($employee->id)   ?   $employee->id   :   '',
                'time'                      =>  !empty($time)           ?   $time           :   '',
            ];

            switch ($type) {
                case 'clock-in' :
                    $clockInResult = $this->updateOrCreateAttendance('clock_in', $data);
                    return $clockInResult;
                break;
                case 'break-out' :
                    $breakOutResult = $this->updateOrCreateAttendance('break_out', $data);
                    return $breakOutResult;
                break;
                case 'break-in' :
                    $breakInResult = $this->updateOrCreateAttendance('break_in', $data);
                    return $breakInResult;
                break;
                case 'clock-out' :
                    $clockOutResult = $this->updateOrCreateAttendance('clock_out', $data);
                    return $clockOutResult;
                break;
            }

        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Processing to save the time that the employee or user
     * take action on web bundy in database
     */
    protected function updateOrCreateAttendance($column, $data)
    {
        try {
            $action         =   '';
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

                $action = $column === 'clock_in' ? 'Clock In!' : '';
                return response()->json(['message' => 'Successfully ' . $action]);
            } else {
                DB::table('attendances')
                    ->where('id', $attendance->id)
                    ->update([
                        $column         =>  $time,
                        'updated_at'    =>  now(),
                        'updated_by'    =>  Auth::id()
                    ]);

                switch ($column) {
                    case 'break_out' :
                        $action = 'Break Out!';
                        return response()->json(['message' => 'Successfully ' . $action]);
                    break;
                    case 'break_in' :
                        $action = 'Break In!';
                        return response()->json(['message' => 'Successfully ' . $action]);
                    break;
                    case 'clock_out' :
                        $action = 'Clock Out!';
                        return response()->json(['message' => 'Successfully ' . $action]);
                    break;
                }
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

    /**
     * Get Employee Today's Attendance
     */
    public function dailyAttendance()
    {
        try {
            $user   =   Auth::user();
            $today  =   Carbon::now();

            $dailyAttendance = DB::table('attendances')
                    ->where('user_id', $user->id)
                    ->whereDate('created_at', '>=', $today->startOfDay())
                    ->whereDate('created_at', '<=', $today->endOfDay())
                    ->first();

            return response()->json(['message' => 'Daily Attendance : ', 'dailyAttendance' => $dailyAttendance]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['message' => $errorMessage], 500);
        }
    }

    /**
     * Get all attendace of each employee base on the
     * date they pick
     */
    public function attendanceRecord(Request $request)
    {
        try {
            $user = Auth::user();
            // $date = $request->date ? $request->date : '';
            $validatedData = $request->validate([
                'date' => 'required|date_format:Y-m-d',
            ]);

            $attendance = DB::table('attendances')
                    ->where('user_id', $user->id)
                    ->whereNull('deleted_at')
                    ->whereDate('created_at', 'LIKE', $validatedData['date'] . '%')
                    ->get();

            return response()->json(['message' => 'Fetched Attendance', 'attendance' => $attendance]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['message' => $errorMessage], 500);
        }
    }
}
