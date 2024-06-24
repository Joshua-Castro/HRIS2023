<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $userId    = Auth::id();
        $userImage = DB::table('images')
            ->where('user_id', '=', $userId)
            ->first();

        $image      = $userImage ?  'storage/' . $userImage->file_path : 'template/images/default-icon.png';

        return view('home', ['image' => $image]);
    }

    /**
     * Show the request page.
     */
    public function leaveRequest()
    {
        $userId    = Auth::id();
        $userImage = DB::table('images')
            ->where('user_id', '=', $userId)
            ->first();

        $image      = $userImage ?  'storage/' . $userImage->file_path : 'template/images/default-icon.png';

        return view('leave-request', ['image' => $image]);
    }

    /**
     * Show the attendance page.
     */
    public function attendance()
    {
        $userId    = Auth::id();
        $userImage = DB::table('images')
            ->where('user_id', '=', $userId)
            ->first();

        $image      = $userImage ?  'storage/' . $userImage->file_path : 'template/images/default-icon.png';

        return view('attendance', ['image' => $image]);
    }

    /**
     * Show the trainings page.
     */
    public function training()
    {
        $userId    = Auth::id();
        $userImage = DB::table('images')
            ->where('user_id', '=', $userId)
            ->first();

        $image      = $userImage ?  'storage/' . $userImage->file_path : 'template/images/default-icon.png';

        return view('training', ['image' => $image]);
    }

     /**
     * Show the training data to dashboard page in calendar as events.
     */
    public function trainingCalendarEvents()
    {
        // CHECK IF THE USER IS AUTHENTICATED
        if (Auth::check()) {
            $events = [];
            $trainings = DB::table('trainings')
                ->whereNull('deleted_at')
                ->get();

            foreach ($trainings as $data) {
                $start_datetime = Carbon::parse($data->start_date_time . ' ' . $data->start_time);
                $end_datetime = Carbon::parse($data->end_date_time . ' ' . $data->end_time);

                $formatted_start_time = $start_datetime->format('h:i A');
                $formatted_end_time = $end_datetime->format('h:i A');

                $events[] = [
                    'title'     =>  $data->title . " (" . $formatted_start_time . " - " . $formatted_end_time . ") ",
                    'start'     =>  $start_datetime->toISO8601String(),
                    'end'       =>  $end_datetime->toISO8601String(),
                    'color'     =>  $this->randomColor(),
                ];
            }
            $indication     =   Str::random(16);
            return response()->json([
                $indication     =>  base64_encode(json_encode($events)),
            ]);
        } else {
            return redirect()-> route('login');
        }
    }

    /**
     * Function to generate a random color
     * in hexadecimal format.
     */
    private function randomColor()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Show the employee overview data to dashboard page on chart.
     */
    public function employeeOverview()
    {
        if (Auth::check()) {
            try {
                $totalEmployeesCount = DB::table('employees')
                    ->whereNull('deleted_at')
                    ->count();

                $thirtyDaysAgo = now()->subDays(30);
                $newEmployees = DB::table('employees')
                                ->where('date_hired', '>=', $thirtyDaysAgo)
                                ->whereNull('deleted_at')
                                ->count();

                $indication     =   Str::random(16);
                $indication2    =   Str::random(16);
                return response()->json([
                    $indication         =>  base64_encode(json_encode($newEmployees)),
                    $indication2        =>  base64_encode(json_encode($totalEmployeesCount)),
                ]);
            } catch (QueryException $e) {
                $errorMessage = $e->getMessage();
                return response()->json(['error' => $errorMessage], 500);
            }
        } else {
            return redirect()-> route('login');
        }
    }

    /**
     * Show the logs
     * in Developer side or Super admin side
     */
    public function activities()
    {
        try {
            $userId    = Auth::id();
            $userImage = DB::table('images')
                ->where('user_id', '=', $userId)
                ->first();

            $image      = $userImage ?  'storage/' . $userImage->file_path : 'template/images/default-icon.png';
            return view('activities', ['image' => $image]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Show the payroll page
     */
    public function payroll()
    {
        try {
            $userId    = Auth::id();
            $userImage = DB::table('images')
                ->where('user_id', '=', $userId)
                ->first();

            $image      = $userImage ?  'storage/' . $userImage->file_path : 'template/images/default-icon.png';
            return view('payroll', ['image' => $image]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Show the generated payroll page
     */
    public function generatedPayroll()
    {
        try {
            $userId    = Auth::id();
            $userImage = DB::table('images')
                ->where('user_id', '=', $userId)
                ->first();

            $image      = $userImage ?  'storage/' . $userImage->file_path : 'template/images/default-icon.png';
            return view('payroll-generated', ['image' => $image]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }
}
