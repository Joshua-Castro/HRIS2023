<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;



class TrainingController extends Controller
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
            $request->validate([
                'trainingTitle'         =>  'required',
                'trainingDesc'          =>  'required',
                'trainingLocation'      =>  'required',
                'trainingStartDate'     =>  'required|date_format:Y-m-d',
                'trainingEndDate'       =>  'required|date_format:Y-m-d',
                'trainingStartTime'     =>  'required',
                'trainingEndTime'       =>  'required',
            ]);

            $id = !empty($request->trainingRecordId) ? $request->trainingRecordId : 0;

            // INITIALIZE AND SET THE PROPER DATA TYPE OF EACH COLUMN. DATE OR TIME
            $trainingStartDate      =   !empty($request->input('trainingStartDate'))       ?    Carbon::parse($request->input('trainingStartDate'))                         :   '';
            $trainingEndDate        =   !empty($request->input('trainingEndDate'))         ?    Carbon::parse($request->input('trainingEndDate'))                           :   '';
            $trainingStartTime      =   !empty($request->input('trainingStartTime'))       ?    Carbon::createFromFormat('h:i A', $request->input('trainingStartTime'))     :   '';
            $trainingEndTime        =   !empty($request->input('trainingEndTime'))         ?    Carbon::createFromFormat('h:i A', $request->input('trainingEndTime'))       :   '';

            // CALCULATION TO GET THE TOTAL DAYS AND HOURS OR DURATION OF THE TRAINING
            $durationInDays         =   $trainingStartDate->diffInDays($trainingEndDate);
            $durationInHours        =   $trainingStartTime->diffInHours($trainingEndTime);
            $totalDays              =   $durationInDays + 1;
            $totalHours             =   $durationInHours * $totalDays;

            $data = [
                'start_date_time'           =>  !empty($trainingStartDate)                          ?    $trainingStartDate                                         :   '',
                'end_date_time'             =>  !empty($trainingEndDate)                            ?    $trainingEndDate                                           :   '',
                'start_time'                =>  !empty($trainingStartTime)                          ?    $trainingStartTime                                         :   '',
                'end_time'                  =>  !empty($trainingEndTime)                            ?    $trainingEndTime                                           :   '',
                'location'                  =>  !empty($request->input('trainingLocation'))         ?    $request->input('trainingLocation')                        :   '',
                'description'               =>  !empty($request->input('trainingDesc'))             ?    $request->input('trainingDesc')                            :   '',
                'duration'                  =>  (!empty($totalDays) && !empty($totalHours))         ?    $totalDays . " Day/s. " . $durationInHours . " Hour/s a day"   :   '',
                'title'                     =>  !empty($request->input('trainingTitle'))            ?    $request->input('trainingTitle')                           :   '',
                'cost'                      =>  '',
                'status'                    =>  '',
                'trainer_instructor'        =>  '',
            ];

            if (empty($id)) {
                // STORE DATA TO 'trainings' TABLE
                $data['created_at']     =   now();
                $data['created_by']     =   Auth::id();

                DB::table('trainings')->insert($data);

                return response()->json(['message' => 'Successfully Added'], 200);
            } else {
                // UPDATE DATA WHENEVER THE $id IS NOT EMPTY
                $data['updated_by']     =   Auth::id();
                $data['updated_at']     =   now();
                DB::table('trainings')->where('id', '=', $id)->update($data);

                return response()->json(['message' => 'Successfully Updated'], 200);
            }
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['message' => $errorMessage], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $this->validate($request, [
                'training-title'                =>  'nullable|string',
                'training-pagination-hidden'    =>  'nullable|integer',
            ]);

            $trainingTitle            =   $request->input('training-title');
            $pagination               =   $request->input('training-pagination-hidden');
            $trainingQuery            =   Training::query();

            if (!empty($trainingTitle)) {
                $trainingQuery->where(function ($query) use ($trainingTitle) {
                    $query->whereRaw("title like ?", ["%{$trainingTitle}%"]);
                });
            }

            $data = $trainingQuery
                        ->select('*')
                        ->whereNull('deleted_at')
                        ->paginate($pagination);

            $indication = Str::random(16);
            return response()->json([$indication => base64_encode(json_encode($data))]);
        } catch (QueryException $e) {

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Training $training)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Training $training)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $data = DB::table('trainings')
                ->where('id','=', $request->id)
                ->update([
                    'deleted_by' => Auth::id(),
                    'deleted_at' => now(),
                ]);

            return response()->json(['message' => 'Successfully Deleted']);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }
}
