<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('home');
    }

    /**
     * Show the request page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function request()
    {
        return view('leave-request');
    }

    /**
     * Show the attendance page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function attendance()
    {
        return view('attendance');
    }

    /**
     * Show the trainings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function training()
    {
        return view('training');
    }
}
