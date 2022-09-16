<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class JobController extends Controller
{
    public function index()
    {
        return view('jobs.jobs-queue', [
            'jobs' => Job::paginate()
        ]);
    }

    public function destroy()
    {
        Artisan::call('queue:clear');
        return back()->withInput();
    }
}
