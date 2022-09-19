@extends('admin.index')

@section('title', 'Log Laravel')

@section('content')
    <h1 class="text-center">Log Laravel</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>File Name</td>
                <td>Size</td>
                <td>Time</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
            <tr>
                <td>{{ $log }}</td>
                <td>{{ Storage::disk('log')->size($log); }} kb</td>
                <td>{{ date('d-m-Y H:i', Storage::disk('log')->lastModified($log)); }}</td>
                <td>
                    <a href="{{ route('log-laravel-detail', $log) }}">Lihat</a>
                    <a href="{{ route('log-laravel-download', $log) }}">Download</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">File Empty</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection
