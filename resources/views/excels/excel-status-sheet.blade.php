@include('excels.excel-header')
<table>
    <thead>
        <tr>
            <td colspan="6">Waktu Tunggu</td>
        </tr>
        <tr>
            @foreach ($statuses as $status)
                <td colspan="3">{{ $status->status }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Status</td>
            <td>Study</td>
            <td>persentase</td>
            <td colspan="3">Study</td>
        </tr>
        <tr>
            <td>Kurang 3 Jam</td>
            <td>{{ $approved->less_than_three_hour }}</td>
            <td>{{ round($approved->persentase_less_than_three_hour, 2) }}%</td>
            <td colspan="3" rowspan="2">{{ $statuses[1]['jumlah'] }}</td>
        </tr>
        <tr>
            <td>Lebih 3 Jam</td>
            <td>{{ $approved->greater_than_three_hour }}</td>
            <td>{{ round($approved->persentase_greater_than_three_hour, 2) }}%</td>
        </tr>
        <tr>
            <td>Total Study</td>
            <td colspan="1">{{ $statuses[0]['jumlah'] }}</td>
            <td rowspan="2"></td>
            <td colspan="3">{{ $statuses[1]['jumlah'] }}</td>
        </tr>
        <tr>
            <td>Total Persentase</td>
            <td colspan="1">{{ round($statuses[0]['persentase'], 2) }}%</td>
            <td colspan="3">{{ round($statuses[1]['persentase'], 2) }}%</td>
        </tr>
    </thead>
    {{-- <tbody>
        @foreach ($statuses as $status)
            <tr>
                <td>{{ $status->status }}</td>
                <td>{{ $status->jumlah }}</td>
                <td>{{ round($status->persentase, 2) }}%</td>
            </tr>
        @endforeach
    </tbody> --}}
</table>
{{-- <table>
    <thead>
        <tr>
            <td>Kurang 3 Jam</td>
            <td>Lebih 3 jam</td>
            <td>Persentase Approved 3 jam</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $approved->less_than_three_hour }}</td>
            <td>{{ $approved->greater_than_three_hour }}</td>
            <td>{{ round($approved->persentase_approved, 2) }}%</td>
        </tr>
    </tbody>
</table> --}}
