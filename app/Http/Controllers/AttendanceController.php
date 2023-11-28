<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Services\LogService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Storage;
use function Symfony\Component\HttpKernel\DataCollector\getMessage;

class AttendanceController extends Controller
{
    protected $logService;

    public function __construct(LogService $logService)
    {
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
            $time       =   $request->time         ?    $request->time          :   '';
            $userId     =   $request->user_id      ?    $request->user_id       :   '';
            $type       =   $request->type         ?    $request->type          :   '';

            $employee   =   DB::table('employees')
                                ->where('user_id', '=', $userId)
                                ->first();
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
            $now = Carbon::now('Asia/Manila');

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
                $attendanceId = DB::table('attendances')->insertGetId([
                    'user_id'               =>  $userId,
                    'employee_id'           =>  $employeeId,
                    $column                 =>  $time,
                    'created_at'            =>  $now,
                    'attendance_date'       =>  date('Y-m-d', strtotime($now)),
                    'created_by'            =>  Auth::id()
                ]);

                $requestDataLogs = [
                    'employee_id'   => $data['employee_id'],
                    'time'          => $time,
                    'attendance_id' => $attendanceId
                ];

                $action = $column === 'clock_in' ? 'Clock In!' : '';
                $this->logService->logGenerate($requestDataLogs, 'clocked in', 'attendances');
                return response()->json(['message' => 'Successfully ' . $action]);
            } else {
                DB::table('attendances')
                    ->where('id', $attendance->id)
                    ->update([
                        $column         =>  $time,
                        'updated_at'    =>  $now,
                        'updated_by'    =>  Auth::id()
                    ]);

                if ($column == 'clock_out') {
                    // SOLVE THE TOTAL HOURS AND SAVE TO THE DATABASE
                    $attendanceClockInData = DB::table('attendances')
                                                ->select('*')
                                                ->where('id', $attendance->id)
                                                ->first();

                    $diffInMinutes = Carbon::parse($time)->diffInMinutes(Carbon::parse($attendanceClockInData->clock_in));
                    $totalWorkingHours = number_format($diffInMinutes / 60, 2);

                    DB::table('attendances')
                        ->where('id', $attendance->id)
                        ->update([
                            $column         =>  $time,
                            'total_hours'   =>  $totalWorkingHours,
                            'updated_at'    =>  $now,
                            'updated_by'    =>  Auth::id()
                        ]);
                }

                $requestDataLogs = [
                    'employee_id'   => $data['employee_id'],
                    'time'          => $time,
                    'attendance_id' => $attendance->id
                ];

                switch ($column) {
                    case 'break_out' :
                        $action = 'Break Out!';
                        $this->logService->logGenerate($requestDataLogs, 'break out', 'attendances');
                        return response()->json(['message' => 'Successfully ' . $action]);
                    break;
                    case 'break_in' :
                        $action = 'Break In!';
                        $this->logService->logGenerate($requestDataLogs, 'break in', 'attendances');
                        return response()->json(['message' => 'Successfully ' . $action]);
                    break;
                    case 'clock_out' :
                        $action = 'Clock Out!';
                        $this->logService->logGenerate($requestDataLogs, 'clocked out', 'attendances');
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
     * Update or correct
     * the employee attendance in
     * HR / Admin side.
     */
    public function update(Request $request, Attendance $attendance)
    {
        try {
            $employeeId     = !empty($request->employeeId) ? $request->employeeId : "";
            $attendanceId   = !empty($request->attendanceId) ? $request->attendanceId : "";

            $attendance = Attendance::find($attendanceId);

            $oldData = $attendance->toArray(); // Get the old data as an array

            $data = [
                'clock_in'     => !empty($request->clockIn) ? date('H:i:s', strtotime($request->clockIn)) : '',
                'clock_out'    => !empty($request->clockOut) ? date('H:i:s', strtotime($request->clockOut)) : '',
                'break_in'     => !empty($request->breakIn) ? date('H:i:s', strtotime($request->breakIn)) : '',
                'break_out'    => !empty($request->breakOut) ? date('H:i:s', strtotime($request->breakOut)) : '',
                'updated_at'   => now(),
                'updated_by'   => Auth::id(),
            ];

            $attendance->update($data);
            $updatedColumns = array_diff_assoc($data, $oldData);
            if (array_key_exists("clock_out", $updatedColumns)) {
                // SOLVE THE TOTAL HOURS AND SAVE TO THE DATABASE
                $clockInData = DB::table('attendances')
                                            ->select('*')
                                            ->where('id', $attendanceId)
                                            ->first();


                $diffInMinutes = Carbon::parse($data['clock_out'])->diffInMinutes(Carbon::parse($clockInData->clock_in));
                $totalWorkingHours = number_format($diffInMinutes / 60, 2);
                $data['total_hours']     =  $totalWorkingHours;

                DB::table('attendances')
                    ->where('id', $attendanceId)
                    ->update($data);

            } else {
                // dd('LOGICAL ERROR || OR CLOCK OUT DIDNT UPDATE', $updatedColumns);
            }


            return response()->json(['message' => 'Attendance successfully Updated!', 'updated_columns' => $updatedColumns]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['message' => $errorMessage], 500);
        }
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
            $today  =   Carbon::now('Asia/Manila');

            $dailyAttendance = DB::table('attendances')
                    ->where('user_id', $user->id)
                    ->whereDate('attendance_date', '>=', $today->startOfDay())
                    ->whereDate('attendance_date', '<=', $today->endOfDay())
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
            $validatedData = $request->validate([
                'date' => 'required|date_format:Y-m-d',
            ]);

            $attendance = DB::table('attendances')
                    ->where('user_id', $user->id)
                    ->whereNull('deleted_at')
                    ->whereDate('attendance_date', 'LIKE', $validatedData['date'] . '%')
                    ->get();

            return response()->json(['message' => 'Fetched Attendance', 'attendance' => $attendance]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['message' => $errorMessage], 500);
        }
    }

    /**
     * Get all attendace of employees
     */
    public function getAllAttendance(Request $request)
    {
        try {
            $this->validate($request, [
                'employee-number-hidden'        =>  'nullable|string',
                'attendance-pagination-hidden'  =>  'nullable|integer',
                'date-from'                     =>  'nullable|date',
                'date-to'                       =>  'nullable|date|after_or_equal:date-from',
            ]);

            $employeeNumberName       =   $request->input('employee-number-hidden');
            $pagination               =   $request->input('attendance-pagination-hidden');
            $attendanceQuery          =   Attendance::query();
            $dateFrom                 =   !empty($request->input('date-from')) ? $request->input('date-from')   : '';
            $dateTo                   =   !empty($request->input('date-to'))   ? $request->input('date-to')     : $dateFrom;

            if (!empty($employeeNumberName)) {
                $attendanceQuery->leftJoin('employees as e', 'e.id', '=', 'attendances.employee_id');
                $attendanceQuery->where(function ($query) use ($employeeNumberName) {
                    $query->whereRaw("CONCAT(e.first_name,' ',COALESCE(e.middle_name, ''),' ',e.last_name) like ?", ["%{$employeeNumberName}%"])
                        ->orWhereRaw("CONCAT(e.last_name,' ',COALESCE(e.middle_name, ''),' ',e.first_name) like ?", ["%{$employeeNumberName}%"])
                        ->orWhereRaw("CONCAT(e.first_name,' ',e.last_name) like ?", ["%{$employeeNumberName}%"])
                        ->orWhereRaw("CONCAT(e.last_name,' ',e.first_name) like ?", ["%{$employeeNumberName}%"])
                        ->orWhere('e.employee_no', 'like', "%{$employeeNumberName}%");
                });
            }

            if (!empty($dateFrom) && !empty($dateTo)) {
                $attendanceQuery->where(function ($query) use ($dateFrom, $dateTo) {
                    $query->whereDate('attendances.attendance_date', '>=', $dateFrom)
                        ->whereDate('attendances.attendance_date', '<=', $dateTo);
                });
            }

            $data = $attendanceQuery
                    ->leftJoin('employees', 'employees.id', '=', 'attendances.employee_id')
                    ->select(
                        'employees.id as employee_id',
                        'employees.last_name',
                        'employees.first_name',
                        'employees.middle_name',
                        'employees.gender',
                        'employees.maiden_name',
                        'employees.position',
                        'employees.employee_no',

                        'attendances.id as attendance_id',
                        'attendances.clock_in',
                        'attendances.clock_out',
                        'attendances.break_in',
                        'attendances.break_out',
                        'attendances.created_at',
                        'attendances.attendance_date',
                        )
                    ->whereNull('attendances.deleted_at')
                    ->orderBy('attendances.attendance_date', 'DESC')
                    ->paginate($pagination);

            return response()->json(['attendance' => $data]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['message' => $errorMessage], 500);
        }
    }
}
