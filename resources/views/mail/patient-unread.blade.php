@component('mail::message')
Dokter Radiologi Yang Terhormat,

Berikut detail pasien belum dilakukan expertise :
@component('mail::table')
    <table>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td>{{ Str::title($workload->patient->pat_name) }}</td>
        </tr>
        <tr>
            <td>Rekam Medis</td>
            <td>:</td>
            <td>{{ $workload->patient->pat_id }}</td>
        </tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $workload->patient->pat_birthdate }}</td>
        </tr>
        <tr>
            <td>Modalitas</td>
            <td>:</td>
            <td>{{ $workload->study->mods_in_study }}</td>
        </tr>
        <tr>
            <td>Pemeriksaan</td>
            <td>:</td>
            <td>{{ $workload->study->study_desc }}</td>
        </tr>
        <tr>
            <td>Waktu Selesai Pemeriksaan</td>
            <td>:</td>
            <td>{{ date('d-m-Y H:i:s', strtotime($workload->study->updated_time)) }}</td>
        </tr>
    </table>
@endcomponent

Silahkan dokter melakukan expertise, <br />
Sebelum <b>waktu selesai pemeriksaan</b> pasien sampai dokter melakukan <b>expertise</b> melebihi dari <b>3 jam</b>

Terimakasih<br>
@endcomponent
