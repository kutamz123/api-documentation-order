@extends('admin.index')

@section('title', 'Jobs Failed Laravel')

@section('content')
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
@endsection
