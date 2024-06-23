<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

use Illuminate\Http\Request;

class LogController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Log $log)
    {
        try {
            $logs = Log::leftJoin('images as i', 'i.user_id', '=', 'logs.created_by')
                        ->whereNull('logs.deleted_by')
                        ->select(
                            'logs.*',
                            'i.file_path as image_filepath',
                            'i.file_name as image_filename'
                        )
                        ->orderBy('logs.created_at', 'DESC')
                        ->get();

            $indication     =   Str::random(16);
            return response()->json([
                $indication         =>  base64_encode(json_encode($logs)),
            ]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Log $log)
    {
        //
    }
}
