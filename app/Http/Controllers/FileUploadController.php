<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class FileUploadController extends Controller
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
     * Store the files to the public storage path
     */
    public function store(Request $request)
    {
        try {
            // VALIDATE THE UPLOADED FIELS
            $request->validate([
                'filepond' => 'required|array',
            ]);

            $uploadedFiles = $request->file('filepond');

            // $filePaths  = [];
            $fileData   = [];

            foreach ($uploadedFiles as $file) {
                // STORE THE FILE IN THE "UPLOADS" DIRECTORY WITHIN THE "PUBLIC" DISK
                $fileName   =   $file->getClientOriginalName();
                $path       =   $file->storeAs('uploads/tmp', $file->getClientOriginalName(), 'public');
            }

            return response()->json(['message' => 'Files uploaded successfully']);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Store the files to the database 'file_uploads'
     */
    public function upload(Request $request)
    {
        try {
            // VALIDATE THE UPLOADED FIELS
            $request->validate([
                'filepond' => 'required|array',
            ]);

            $files      = $request->file('filepond');
            $fileData   = [];
            foreach ($files as $file) {
                $fileName   =   $file->getClientOriginalName();
                $fileId     =   $request->input('file_id') ? $request->input('file_id') : '';
                $path       =   $fileName ? 'uploads/tmp/' . $fileName : '';

                $fileData[] = [
                    'employee_id'       =>  $request->input('employee_id'),
                    'file_path'         =>  $path,
                    'file_name'         =>  $fileName,
                    'file_unique_id'    =>  $fileId,
                    'created_at'        =>  now(),
                    'created_by'        =>  Auth::id(),
                ];
            }

            // PERFORM BATCH INSERT TO AVOID LOOP QUERY
            DB::table('file_uploads')->insert($fileData);

            return response()->json(['message' => 'Files uploaded successfully']);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }

    }

    /**
     * Remove the file from the database as well
     * as on the Database. Base on the employee id and
     * file unique id
     */
    public function revert(Request $request)
    {
        try {
            $fileId         =   $request->input('file_id');
            $employeeId     =   $request->input('employee_id');

            $file = DB::table('file_uploads')
                ->select(
                    'file_path',
                    'file_unique_id',
                    'employee_id'
                    )
                ->where('file_unique_id', $fileId)
                ->where('employee_id', $employeeId)
                ->first();
            dd($file);

            if ($file === null) {
                return response()->json(['error' => 'File not found'], 404);
            }

            // Delete the file from storage
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }


            // // Delete the file from storage
            // Storage::disk('public')->delete($file->file_path);

            // Delete the record from the database
            DB::table('file_uploads')
                ->where('file_unique_id', $fileId)
                ->where('employee_id', $employeeId)
                ->delete();

            return response()->json(['message' => 'Successfully Removed!']);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FileUpload $fileUpload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileUpload $fileUpload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FileUpload $fileUpload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileUpload $fileUpload)
    {
        //
    }
}
