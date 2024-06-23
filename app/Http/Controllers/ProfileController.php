<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class ProfileController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId    = Auth::id();
        $userImage = Image::where('user_id', '=', $userId)->first();

        $image      = $userImage ?  'storage/' . $userImage->file_path : 'template/images/default-icon.png';
        return view('profile', ['image' => $image, 'userId' => $userId]);
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
    public function show(Request $request)
    {
        try {
            $userId = !empty($request->input('user_id')) ? $request->input('user_id') : "";

            $profileData = User::leftJoin('employees as e', 'e.user_id', '=', 'users.id')
                            ->where('users.id', '=', $userId)
                            ->whereNull('e.deleted_at')
                            ->select(
                                'users.id as userId',
                                'users.name as userName',
                                'users.email as userEmail',
                                'users.retrieve_password as userPassword',
                                'e.*'
                            )
                            ->first();

            $indication     =   Str::random(16);
            return response()->json([
                $indication     =>  base64_encode(json_encode($profileData)),
            ]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Update the profile of
     * each employee when they change it
     */
    public function updateInfo(Request $request)
    {
        try {
            $userId         = !empty($request->input('user_id'))        ?   $request->input('user_id')      : "";
            $userPassword   = !empty($request->input('password'))       ?   $request->input('password')     : "";
            $userName       = !empty($request->input('username'))       ?   $request->input('username')     : "";

            $data = [
                'email'                 =>  $userName,
                'retrieve_password'     =>  $userPassword,
                'password'              =>  Hash::make($userPassword),
                'updated_at'            =>  now()
            ];

            User::where('id', '=', $userId)->update($data);

            return response()->json(['message' => 'Successfully Updated'], 200);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }

    }
}
