<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function request()
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
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
     * Show the data to dashboard page.
     *
     */
    public function dashboard()
    {
       // CHECK IF THE USER IS AUTHENTICATED
        if (Auth::check()) {
            $events     = [];
            $trainings  = DB::table('trainings')
                            ->whereNull('deleted_at')
                            ->get();

            foreach ($trainings as $data) {
                $start_time             = Carbon::parse($data->start_time);
                $end_time               = Carbon::parse($data->end_time);

                $formatted_start_time   = $start_time->format('h:i A');
                $formatted_end_time     = $end_time->format('h:i A');

                $events[] = [
                    'title' => $data->title . " (" . $formatted_start_time . " - " . $formatted_end_time . ") ",
                    'start' => $data->start_date_time,
                    'end'   => $data->end_date_time,
                    'color' => $this->randomColor(),
                ];
            }

            return response()->json($events);
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Function to generate a random color
     * in hexadecimal format.
     */
    private function randomColor() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}
