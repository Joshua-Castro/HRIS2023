<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ArtisanController extends Controller
{
     /**
     * Run clear artisan command cache:clear
     */
    public function runCacheClear()
    {
        Artisan::call('cache:clear');
        return response()->json(['message' => 'Cache cleared successfully']);
    }

    /**
     * Run command artisan database migrate
     */
    public function migrate()
    {
        Artisan::call('migrate');
        return response()->json(['message' => 'Database migrated successfully']);
    }

    /**
     * Run command artisan database seed
     */
    public function seed()
    {
        Artisan::call('db:seed');
        return response()->json(['message' => 'Database seeded successfully']);
    }
}
