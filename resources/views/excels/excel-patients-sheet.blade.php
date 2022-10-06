@include('excels.excel-header')

<table>
    <thead>
    <tr>
        <th rowspan="3">No</th>
        <th rowspan="3">Nama Pasien</th>
        <th rowspan="3">Jenis Kelamin</th>
        <th rowspan="3">ID Pasien</th>
        <th rowspan="3">No Rekam Medis</th>
        <th rowspan="3">Nama Radiografer</th>
        <th rowspan="3">Tanggal Lahir</th>
        <th rowspan="3">Umur</th>
        <th rowspan="3">Ruangan</th>
        <th rowspan="3">Modality</th>
        <th rowspan="3">Pemeriksaan</th>
        <th colspan="4">Film</th>
        <th colspan="4">Exposed</th>
        <th rowspan="3">Status Pasien</th>
        <th rowspan="3">Pembayaran</th>
        <th rowspan="3">Waktu Pendaftaran Pasien</th>
        <th rowspan="3">Waktu Mulai Pemeriksaan</th>
        <th rowspan="3">Waktu Selesai Pemeriksaan</th>
        <th rowspan="3">Waktu Baca Pasien</th>
        <th rowspan="3">Menghabiskan Waktu</th>
        <th rowspan="3">Status Baca</th>
    </tr>
    <tr>
        <th colspan="2">Digunakan</th>
        <th colspan="2">Gagal</th>
        <th colspan="2">KV</th>
        <th colspan="2">MAS</th>
    </tr>
    <tr>
        <th>Film 8</th>
        <th>Film 10</th>
        <th>Film 8</th>
        <th>Film 10</th>
        <th colspan="4"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($datas as $excel)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $excel->name }}</td>
            <td>{{ $excel->sex }}</td>
            <td>{{ $excel->patientid }}</td>
            <td>{{ $excel->mrn }}</td>
            <td>{{ $excel->radiographer_name }}</td>
            <td>{{ $excel->birth_date }}</td>
            <td>{{ $excel->age }}</td>
            <td>{{ $excel->name_dep }}</td>
            <td>{{ $excel->xray_type_code }}</td>
            <td>{{ $excel->prosedur }}</td>
            <td>{{ $excel->filmsize8 }}</td>
            <td>{{ $excel->filmsize10 }}</td>
            <td>{{ $excel->filmreject8 }}</td>
            <td>{{ $excel->filmreject10 }}</td>
            <td colspan="2">{{ $excel->kv }}</td>
            <td colspan="2">{{ $excel->mas }}</td>
            <td>{{ $excel->patienttype }}</td>
            <td>{{ $excel->payment }}</td>
            <td>{{ $excel->create_time }}</td>
            <td>{{ $excel->arrive_date . ' ' . $excel->arrive_time }}</td>
            <td>{{ $excel->updated_time }}</td>
            <td>{{ $excel->approve_date . ' '  . $excel->approve_time }}</td>
            <td>{{ $excel->spend_time }}</td>
            <td>{{ $excel->status }}</td>
        </tr>
    @endforeach
        <tr>
            <td colspan="11">Jumlah</td>
            <td>{{ $sum->filmsize8 }}</td>
            <td>{{ $sum->filmsize10 }}</td>
            <td>{{ $sum->filmreject8 }}</td>
            <td>{{ $sum->filmreject10 }}</td>
            <td colspan="4"></td>
        </tr>
    </tbody>
</table>
