@extends('admin.index')

@section('title', 'Jobs Failed Laravel')

@section('content')
    <h1 class="text-center">Jobs Failed Queue</h1>
    <form action="{{ route('queue-flush') }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">Delete All</button>
    </form>
    <form action="{{ route('queue-retry-all') }}" method="POST">
        @csrf
        <button class="btn btn-info">Retry All</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <td>Aksi</td>
                <td>Id</td>
                <td>Connection</td>
                <td>Queue</td>
                <td>Payload</td>
                <td>Exception</td>
                <td>failed_at</td>
            </tr>
        </thead>
        <tbody>
            @forelse ($failedJobs as $failedJob)
            <tr>
                <form action="{{ route('queue-retry-id', $failedJob->id) }}" method="POST">
                    @csrf
                    <td>
                        <button class="btn btn-info">Retry</button>
                    </td>
                </form>
                <form action="{{ route('queue-forget-id', $failedJob->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <td>
                        <button class="btn btn-info">Delete</button>
                    </td>
                </form>
                <td>{{ $failedJob->id }}</td>
                <td>
                    {{ $failedJob->connection }}
                </td>
                <td>{{ $failedJob->queue }}</td>
                <td class="overflow-scroll">{{ $failedJob->payload }}</td>
                <td>{{ $failedJob->exception }}</td>
                <td>{{ $failedJob->failed_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Queue Failed Empty</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection
