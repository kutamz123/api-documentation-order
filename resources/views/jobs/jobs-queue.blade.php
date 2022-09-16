<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jobs Laravel</title>
    @include('includes.style')
</head>
<body>
    <div class="container">
        <h1 class="text-center">Jobs Queue</h1>
        <form action="{{ route('queue-clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Hapus Semua</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <td>Queue</td>
                    <td>Payload</td>
                    <td>Attempts</td>
                    <td>reserved_at</td>
                    <td>available_at</td>
                    <td>created_at</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobs as $job)
                <tr>
                    <td>{{ $job->queue }}</td>
                    <td class="overflow-scroll">
                        {{ $job->payload }}
                    </td>
                    <td>{{ $job->attempts }}</td>
                    <td>{{ $job->reserved_at }}</td>
                    <td>{{ $job->available_at }}</td>
                    <td>{{ $job->created_at }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Queue Empty</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @include('includes.script')
</body>
</html>
