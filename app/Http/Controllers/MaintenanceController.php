<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MaintenanceController extends Controller
{
    public function optimizeClear()
    {
        Artisan::call('optimize:clear');
        return redirect()->back()->with('message', 'All caches have been cleared.');
    }
    public function storageLink()
    {
        Artisan::call('storage:link');
        return redirect()->back()->with('message', 'Storage linked successfully.');
    }
}
