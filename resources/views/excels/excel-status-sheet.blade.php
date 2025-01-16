@include('excels.excel-header')
<table>
    <thead>
        <tr>
            <td colspan="6">Waktu Tunggu</td>
        </tr>
        <tr>
            <td colspan="3">Approved</td>
            <td colspan="3">Waiting</td>
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
            <td colspan="3" rowspan="2">{{ $sum_waiting }}</td>
        </tr>
        <tr>
            <td>Lebih 3 Jam</td>
            <td>{{ $approved->greater_than_three_hour }}</td>
            <td>{{ round($approved->persentase_greater_than_three_hour, 2) }}%</td>
        </tr>
        <tr>
            <td>Total Study</td>
            <td colspan="1">{{ $sum_approved }}</td>
            <td rowspan="2"></td>
            <td colspan="3">{{ $sum_waiting }}</td>
        </tr>
        <tr>
            <td>Total Persentase</td>
            <td colspan="1">{{ round($persentase_approved, 2) }}%</td>
            <td colspan="3">{{ round($persentase_waiting, 2) }}%</td>
        </tr>
    </thead>
</table>
