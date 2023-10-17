<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
