<?php

namespace App\Http\Controllers;

use App\FailedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class FailedJobController extends Controller
{
    public function index()
    {
        return view('jobs.jobs-failed-queue', [
            'failedJobs' => FailedJob::orderBy('failed_at', 'desc')->paginate()
        ]);
    }

    public function updateAll()
    {
        Artisan::call('queue:retry all');

        return back()->withInput();
    }

    public function update($id)
    {
        Artisan::call('queue:retry', [
            'id' => $id
        ]);

        return back()->withInput();
    }

    public function destroy($id)
    {
        Artisan::call('queue:forget', [
            'id' => $id
        ]);
        return back()->withInput();
    }

    public function destroyAll()
    {
        Artisan::call('queue:flush');
        return back()->withInput();
    }
}
