<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class LogDailyLaravelController extends Controller
{
    public function index()
    {

        $logs = Storage::disk('log')->allFiles();

        return view('logs.log-laravel', [
            'logs' => $logs
        ]);
    }

    public function show($id)
    {
        if (Storage::disk('log')->missing($id)) {
            abort(404);
        } else {
            $logs = Storage::disk('log')->get($id);
            preg_match_all('/(\[[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}]) ([a-z]*).([a-zA-Z]*): (.*)/', $logs, $datas, PREG_SET_ORDER);
        }
        return view('logs.log-laravel-detail', [
            'datas' => $datas
        ]);
    }

    public function download($id)
    {
        if (Storage::disk('log')->missing($id)) {
            abort(404);
        } else {
            $download = Storage::disk('log')->download($id);
        }

        return $download;
    }
}
