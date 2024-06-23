<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\LogService;
use Illuminate\Support\Carbon;
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
                return response()->json(['message' => 'Successfully Submitted'], 200);
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
    public function show()
    {
        try {
            $userId = Auth::id();

            $data = Leave::join('leave_types as lt', 'lt.id', '=', 'leaves.leave_type')
                ->where('leaves.user_id', '=', $userId)
                ->whereNull('leaves.deleted_at')
                ->orderByDesc('leaves.created_at')
                ->select([
                    'leaves.id',
                    'leaves.user_id',
                    'leaves.leave_date',
                    'leaves.leave_type as lt_id',
                    'leaves.day_type',
                    'leaves.status',
                    'leaves.reason',
                    'leaves.decline_reason',
                    'lt.description as leave_type',
                ])
                ->paginate(5);

            $count = Leave::where('user_id', $userId)->count();
            $overAllCount = Leave::whereNull('deleted_at')->count();
            $leaveType = LeaveType::all();

            $indication     =   Str::random(16);
            $indication2    =   Str::random(16);
            $indication3    =   Str::random(16);
            $indication4    =   Str::random(16);

            return response()->json([
                $indication => base64_encode(json_encode($data)),
                $indication2 => $count,
                $indication3 => $overAllCount,
                $indication4 => base64_encode(json_encode($leaveType)),
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
            $clockIn    =   null;
            $clockOut   =   null;
            $breakOut   =   null;
            $breakIn    =   null;

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

                if ($leaveData->day_type == 'Whole Day') {
                    $clockIn    =   Carbon::parse('07:00:00');
                    $clockOut   =   Carbon::parse('16:00:00');
                    $breakOut   =   Carbon::parse('12:00:00');
                    $breakIn    =   Carbon::parse('13:00:00');
                } else {
                    $clockIn    =   Carbon::parse('07:00:00');
                    $clockOut   =   Carbon::parse('12:00:00');
                    $breakOut   =   null;
                    $breakIn    =   null;
                }

                $attendanceData = [
                    'attendance_date'   =>  !empty($leaveData->leave_date)     ?   $leaveData->leave_date      :   null,
                    'clock_in'          =>  !empty($clockIn)                   ?   $clockIn                    :   null,
                    'clock_out'         =>  !empty($clockOut)                  ?   $clockOut                   :   null,
                    'break_out'         =>  !empty($breakOut)                  ?   $breakOut                   :   null,
                    'break_in'          =>  !empty($breakIn)                   ?   $breakIn                    :   null,
                    'created_at'        =>  now(),
                    'user_id'           =>  !empty($leaveData->user_id)        ?   $leaveData->user_id         :   null,
                    'employee_id'       =>  !empty($leaveData->employee_id)    ?   $leaveData->employee_id     :   null,
                    'notes'             =>  "File a $leaveData->leave_type on $leaveData->leave_date. ($leaveData->day_type)",
                ];

                DB::table('attendances')->insert($attendanceData);
                $this->logService->logGenerate(Auth::id(), 'accepted', 'leave-status', null, $id);
                return response()->json(['message' => 'Successfully Accepted']);
            } else if ($status === 'Declined') {
                $this->logService->logGenerate(Auth::id(), 'declined', 'leave-status', null, $id);
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
            $data = Leave::join('employees as e', 'e.user_id', '=', 'leaves.user_id')
                        ->join('leave_types as lt', 'lt.id', '=', 'leaves.leave_type')
                        ->whereNull('e.deleted_at')
                        ->orderByDesc('leaves.created_at')
                        ->get([
                            'leaves.id',
                            'leaves.user_id',
                            'leaves.leave_date',
                            'leaves.leave_type as lt_id',
                            'leaves.day_type',
                            'leaves.status',
                            'leaves.reason',
                            'e.last_name',
                            'e.first_name',
                            'e.middle_name',
                            'e.gender',
                            'e.position',
                            'e.employee_no',
                            'e.salary_grade',
                            'lt.description as leave_type',
                        ]);
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
