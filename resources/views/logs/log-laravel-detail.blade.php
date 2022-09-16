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
        <h1 class="text-center">Log Detail Laravel</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>Level</td>
                    <td>Time</td>
                    <td>Env</td>
                    <td>Description</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($datas as $data)
                <tr>
                    <td>{{  $data[3]  }}</td>
                    <td>{{  $data[1]  }}</td>
                    <td>{{  $data[2]  }}</td>
                    <td>{!! $data[4] !!}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Log Detail Empty</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @include('includes.script')
</body>
</html>
