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
    public function store(Request $request, $employeeToken)
    {
        try {
            DB::beginTransaction();

            // VALIDATE THE UPLOADED FIELS
            $request->validate([
                'filepond' => 'required|array',
            ]);

            $uploadedFiles  = $request->file('filepond');
            $token          = $employeeToken;
            $fileData   = [];

            foreach ($uploadedFiles as $file) {
                // STORE THE FILE IN THE "UPLOADS" DIRECTORY WITHIN THE "PUBLIC" DISK
                $fileName   =   $file->getClientOriginalName();
                $path       =   $file->storeAs('uploads/tmp', $token . $fileName, 'public');
            }

            DB::commit();
            return response()->json(['message' => 'Files uploaded successfully']);
        } catch (QueryException $e) {
            DB::rollBack();

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
                $token      =   $request->input('employee_token') ? $request->input('employee_token') : '';
                $fileName   =   $file->getClientOriginalName();
                $fileId     =   $request->input('file_id') ? $request->input('file_id') : '';
                $path       =   $fileName ? 'uploads/tmp/' . $token . $fileName : '';

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
     * Processing the revert or delete file
     */
    public function delete(Request $request)
    {
        try {
            if(!$request->file('filepond')) {
                return response()->json(['message' => 'Removing File...']);
            } else {
                return response()->json(['message' => 'Something went wrong.']);
            }
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Remove the file from the Directory as well
     * as on the Database. Base on the employee id and
     * file unique id
     */
    public function revert(Request $request)
    {
        try {
            $fileId         =   $request->input('file_id')      ? $request->input('file_id')        :   $request->file_id;
            $employeeId     =   $request->input('employee_id')  ? $request->input('employee_id')    :   $request->employee_id;

            $file = DB::table('file_uploads')
                ->select(
                    'file_path',
                    'file_unique_id',
                    'employee_id'
                    )
                ->where('file_unique_id', $fileId)
                ->where('employee_id', $employeeId)
                ->first();

            if ($file === null) {
                return response()->json(['error' => 'File not found'], 404);
            }

            // Delete the file from storage
            Storage::disk('public')->delete($file->file_path);

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
     * file unique id
     */
    public function getAll (Request $request)
    {
        try {
            $files = DB::table('file_uploads')
                ->select('*')
                ->where('employee_id', '=', $request->employeeId)
                ->whereNull('deleted_at')
                ->get();

            return response()->json(['files' => $files]);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileUpload $fileUpload)
    {
        //
    }
}
