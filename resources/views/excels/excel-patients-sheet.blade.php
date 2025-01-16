@include('excels.excel-header')

<table>
    <thead>
        <tr>
            <th rowspan="3">No</th>
            <th rowspan="3">Nama Pasien</th>
            <th rowspan="3">No Rekam <br /> Medis</th>
            <th rowspan="3">Jenis <br /> Kelamin</th>
            <th rowspan="3">No Foto</th>
            <th rowspan="3">Nama <br /> Radiografer</th>
            <th rowspan="3">Tanggal <br /> Lahir</th>
            <th rowspan="3">Umur</th>
            <th rowspan="3">Ruangan</th>
            <th rowspan="3">Modality</th>
            <th rowspan="3">Pemeriksaan</th>
            <th colspan="6">Film</th>
            <th colspan="4" rowspan="2">Exposed</th>
            <th rowspan="3">Status <br /> Pasien</th>
            <th rowspan="3">Pembayaran</th>
            <th rowspan="3">Waktu Pendaftaran <br /> Pasien</th>
            <th rowspan="3">Waktu Mulai <br /> Pemeriksaan</th>
            <th rowspan="3">Waktu Selesai <br /> Pemeriksaan</th>
            <th rowspan="3">Waktu Baca <br /> Pasien</th>
            <th rowspan="3">Menghabiskan <br /> Waktu</th>
            <th rowspan="3">Status Baca</th>
        </tr>
        <tr>
            <th colspan="3">Digunakan</th>
            <th colspan="3">Gagal</th>
        </tr>
        <tr>
            <th>Small</th>
            <th>Medium</th>
            <th>Large</th>
            <th>Small</th>
            <th>Medium</th>
            <th>Large</th>
            <th colspan="2">KV</th>
            <th colspan="2">MAS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $excel)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $excel->pat_name }}</td>
                <td>{{ $excel->pat_id }}</td>
                <td>{{ $excel->pat_sex }}</td>
                <td>{{ $excel->patientid }}</td>
                <td>{{ $excel->radiographer_name }}</td>
                <td>{{ $excel->pat_birthdate }}</td>
                <td>{{ $excel->age }}</td>
                <td>{{ $excel->name_dep }}</td>
                <td>{{ $excel->mods_in_study }}</td>
                <td>{{ $excel->study_desc }}</td>
                <td>{{ $excel->film_small }}</td>
                <td> {{ $excel->film_medium }} </td>
                <td>{{ $excel->film_large }}</td>
                <td>{{ $excel->film_reject_small }}</td>
                <td> {{ $excel->film_reject_medium }} </td>
                <td>{{ $excel->film_reject_large }}</td>
                <td colspan="2">{{ $excel->kv }}</td>
                <td colspan="2">{{ $excel->mas }}</td>
                <td>{{ $excel->priority_doctor }}</td>
                <td>{{ $excel->payment }}</td>
                <td>{{ $excel->create_time }}</td>
                <td>{{ $excel->study_datetime }}</td>
                <td>{{ $excel->study_datetime }}</td>
                <td>{{ $excel->approved_at }}</td>
                <td>{{ $excel->spend_time }}</td>
                <td>{{ $excel->status }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="11">Jumlah</td>
            <td>{{ $sum->film_small }}</td>
            <td>{{ $sum->film_medium }}</td>
            <td>{{ $sum->film_large }}</td>
            <td>{{ $sum->film_reject_small }}</td>
            <td>{{ $sum->film_reject_medium }}</td>
            <td>{{ $sum->film_reject_large }}</td>
            <td colspan="4"></td>
        </tr>
    </tbody>
</table>
