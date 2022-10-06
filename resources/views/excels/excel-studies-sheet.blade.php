@include('excels.excel-header')
<table>
    <thead>
        <tr>
            <td>No</td>
            <td>Pemeriksaan</td>
            <td>Jumlah</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($studies as $study)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $study->prosedur }}</td>
                <td>{{ $study->jumlah }}</td>
            </tr>
        @endforeach
            <tr>
                <td></td>
                <td>Total Pemeriksaan</td>
                <td>{{ $countStudies }}</td>
            </tr>
    </tbody>
</table>
