<?php

namespace App\Http\Controllers;

use App\Models\Training;
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

            $trainingStartDate  =   !empty($request->input('trainingStartDate'))       ?    $request->input('trainingStartDate')    :   '';
            $trainingEndDate    =   !empty($request->input('trainingEndDate'))         ?    $request->input('trainingEndDate')      :   '';
            $trainingStartTime  =   !empty($request->input('trainingStartTime'))       ?    $request->input('trainingStartTime')    :   '';
            $trainingEndTime    =   !empty($request->input('trainingEndTime'))         ?    $request->input('trainingEndTime')      :   '';

            $startDate  =   Carbon::parse($trainingStartDate);
            $endDate    =   Carbon::parse($trainingEndDate);
            $endTime    =   Carbon::createFromFormat('h:i A', $trainingEndTime);
            $startTime  =   Carbon::createFromFormat('h:i A', $trainingStartTime);

            $durationInDays     =   $startDate->diffInDays($endDate);
            $durationInHours    =   $startTime->diffInHours($endTime);
            $totalDays          =   $durationInDays + 1;
            $totalHours         =   $durationInHours * $totalDays;

            dd($durationInDays, $durationInHours, $totalDays, $totalHours);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['message' => $errorMessage], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Training $training)
    {
        //
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
    public function destroy(Training $training)
    {
        //
    }
}
