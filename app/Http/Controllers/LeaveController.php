<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
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
        $request->validate([
            'leaveDate'     =>  'required|date_format:Y-m-d',
            'leaveType'     =>  'required',
            'dayType'       =>  'required',
            'reason'        =>  'required',
        ]);

        try {
            $id         = !empty($request->leaveRecordId) ? $request->leaveRecordId : 0;
            $userId     = Auth::id();
            $employeeId = DB::table('employees')
                            ->where('user_id', '=', $userId)
                            ->value('id');

            $data = [
                'employee_id'            =>      !empty($employeeId)                  ?   $employeeId                     :  '',
                'leave_date'             =>      !empty($request->leaveDate)          ?   $request->leaveDate             :  '',
                'leave_type'             =>      !empty($request->leaveType)          ?   $request->leaveType             :  '',
                'day_type'               =>      !empty($request->dayType)            ?   $request->dayType               :  '',
                'reason'                 =>      !empty($request->reason)             ?   $request->reason                :  '',
            ];

            if (empty($id)) {
                // CREATE OR STORE DATA
                $data['status']                 =   'Pending';
                $data['created_by']             =   $userId;
                $data['created_at']             =   now();
                $data['user_id']                =   $userId;

                $createdLeaveId = DB::table('leaves')->insertGetId($data);
                $this->logService->logGenerate(Auth::id(), 'created', 'leaves', null, $createdLeaveId);
                return response()->json(['message' => 'Successfully Added'], 200);
            } else {
                // UPDATE DATA
                $data['updated_by']     =   $userId;
                $data['updated_at']     =   now();
                DB::table('leaves')->where('id','=',$id)->update($data);

                $this->logService->logGenerate(Auth::id(), 'updated', 'leaves', null, $id);
                return response()->json(['message' => 'Successfully Updated'],200);
            }

        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        try {
            $userId = Auth::id();

            $data = DB::table('leaves as l')
                        ->select(
                            'l.id',
                            'l.user_id',
                            'l.leave_date',
                            'l.leave_type as lt_id',
                            'l.day_type',
                            'l.status',
                            'l.reason',

                            'lt.description as leave_type',
                            )
                        ->leftJoin('leave_types as lt', 'lt.id', '=', 'l.leave_type')
                        ->where('user_id', '=', $userId)
                        ->whereNull('l.deleted_at')
                        ->orderBy('l.created_at', 'desc')
                        ->paginate(5);

            $overAllCount = DB::table('leaves')
                            ->select('*')
                            ->whereNull('deleted_at')
                            ->count();

            $count = DB::table('leaves')
                    ->where('user_id', '=', $userId)
                    ->count();

            $leaveType = DB::table('leave_types')
                            ->select('*')
                            ->get();

            $indication     =   Str::random(16);
            $indication2    =   Str::random(16);
            $indication3    =   Str::random(16);
            $indication4    =   Str::random(16);

            return response()->json([
                $indication     =>  base64_encode(json_encode($data)),
                $indication2    =>  $count,
                $indication3    =>  $overAllCount,
                $indication4    =>  base64_encode(json_encode($leaveType))
            ]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        try {
            $id         =   $request->id;
            $status     =   $request->status;
            $reason     =   $request->reason;
            $userId     =   Auth::id();

            $data       = DB::table('leaves')
                            ->where('id', '=', $id)
                            ->update([
                                'status'            =>  $status,
                                'decline_reason'    =>  $reason,
                                'approver_id'       =>  $userId
                            ]);

            if ($status === 'Accepted') {
                $leaveData = DB::table('leaves as l')
                                ->select(
                                    'l.id as leave_id',
                                    'l.user_id as user_id',
                                    'l.employee_id as employee_id',
                                    'l.leave_date as leave_date',
                                    'l.day_type as day_type',

                                    'lt.id as leave_type_id',
                                    'lt.description as leave_type',
                                    )
                                ->leftJoin('leave_types as lt', 'lt.id', '=', 'l.leave_type')
                                ->where('l.id', '=', $id)
                                ->first();

                $attendanceData = [
                    'attendance_date'   =>  !empty($leaveData->leave_date)      ?   $leaveData->leave_date      :   "",
                    'created_at'        =>  now(),
                    'user_id'           =>  !empty($leaveData->user_id)         ?   $leaveData->user_id         :   "",
                    'employee_id'       =>  !empty($leaveData->employee_id)     ?   $leaveData->employee_id     :   "",
                    'notes'             =>  "File a $leaveData->leave_type on $leaveData->leave_date. ($leaveData->day_type)",
                ];

                DB::table('attendances')->insert($attendanceData);
                return response()->json(['message' => 'Successfully Accepted']);
            } else if ($status === 'Declined') {
                return response()->json(['message' => 'Successfully Declined']);
            }
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $id = !empty($request->id) ? $request->id : "";
            $data = DB::table('leaves')
                ->where('id','=', $id)
                ->update([
                    'deleted_by' => Auth::id(),
                    'deleted_at' => now(),
                ]);

            $this->logService->logGenerate(Auth::id(), 'deleted', 'leaves', null, $id);
            return response()->json(['message' => 'Successfully Deleted']);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }

    }

    /**
     * Get all leave request data and display
     * on admin / hr side
     */
    public function showAll(Request $request)
    {
        try {
            $data = DB::table('leaves as l')
                    ->select(
                        'l.id',
                        'l.user_id',
                        'l.leave_date',
                        'l.leave_type as lt_id',
                        'l.day_type',
                        'l.status',
                        'l.reason',

                        'lt.description as leave_type',

                        'e.last_name',
                        'e.first_name',
                        'e.middle_name',
                        'e.gender',
                        'e.position',
                        'e.employee_no',
                        'e.deleted_at',
                        'e.deleted_by',
                        'e.salary_grade',
                        )
                    ->leftJoin('employees as e', 'e.user_id', '=', 'l.user_id')
                    ->leftJoin('leave_types as lt', 'lt.id', '=', 'l.leave_type')
                    ->whereNull('e.deleted_at')
                    ->orderBy('l.created_at', 'desc')
                    ->get();

            $count = $data->count();

            $indication     =   Str::random(16);
            $indication2    =   Str::random(16);

            return response()->json([
                $indication  => base64_encode(json_encode($data)),
                $indication2 => $count
        ]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }

    }
}
