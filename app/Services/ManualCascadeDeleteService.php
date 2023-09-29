<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class ManualCascadeDeleteService
{
    /**
     * Delete other related data when
     * deleting employee
     */
    public function delete($data)
    {
        try {
            DB::beginTransaction();

            // DELETE THE USER ACCOUNT
            DB::table('users')->where('id', $data->userId)->delete();

            // UPDATE THE FILE UPLOADS RELATED TO THE EMPLOYEE
            DB::table('file_uploads')
                ->where('employee_id', $data->id)
                ->update([
                    'deleted_by' => Auth::id(),
                    'deleted_at' => now(),
                ]);

            // UPDATE THE IMAGES RELATED TO THE EMPLOYEE
            DB::table('images')
                ->where('user_id', $data->userId)
                ->update([
                    'deleted_by' => Auth::id(),
                    'deleted_at' => now(),
                ]);

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }
}
