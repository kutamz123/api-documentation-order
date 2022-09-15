<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log Laravel</title>
    @include('includes.style')
</head>
<body>
    <div class="container">
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
                    <td colspan="4">File Tidak Ada</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @include('includes.script')
</body>
</html>
