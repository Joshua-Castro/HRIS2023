<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $employeeId)
    {
        try {
            // Validate the uploaded files
            $request->validate([
                'filepond' => 'required|array',
            ]);

            $uploadedFiles = $request->file('filepond');

            $filePaths  = [];
            $fileData   = [];

            foreach ($uploadedFiles as $file) {
                // STORE THE FILE IN THE "UPLOADS" DIRECTORY WITHIN THE "PUBLIC" DISK
                $fileName   =   $file->getClientOriginalName() . $employeeId . now();
                $path       =   $file->storeAs('uploads/tmp', uniqid() . '_' . $file->getClientOriginalName(), 'public');

                // SAVE THE FILE PATH FOR FUTURE USE (e.g., database storage)
                $filePaths[] = $path;
                // PREPARE DATA FOR BATCH INSERT
                $fileData[] = [
                    'employee_id'   =>  $employeeId,
                    'file_path'     =>  $path,
                    'file_name'     =>  $fileName,
                    'created_at'    =>  now(),
                ];
            }

            // PERFORM BATCH INSERT TO AVOID LOOP QUERY
            DB::table('file_uploads')->insert($fileData);

            // You can return the file paths if needed for further processing
            return response()->json(['message' => 'Files uploaded successfully']);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    public function uploadFiles(Request $request)
    {
        try {
            $request->validate([
                'filepond' => 'required|array',
                'filepond.*' => 'mimes:jpeg,png,pdf', // Adjust allowed file types.
            ]);

            if ($request->hasFile('filepond')) {
                $uploadedFiles = $request->file('filepond');
                $fileData = [];

                foreach ($uploadedFiles as $file) {
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->store('uploads', 'public');

                    $fileData[] = [
                        'employee_id'   =>  $request->employee_id,
                        'file_name'     =>  $fileName,
                        'file_path'     =>  $filePath,
                        'created_at'    =>  now(),
                    ];
                }

                // Insert all uploaded files into the database in a single query to optimize performance.
                DB::table('file_uploads')->insert($fileData);

                return redirect()->back()->with('success', 'Files uploaded successfully');
            } else {
                dd('error');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'File upload failed: ' . $e->getMessage());
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
