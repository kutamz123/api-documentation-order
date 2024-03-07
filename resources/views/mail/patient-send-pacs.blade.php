@component('mail::message')
Dokter Radiologi Yang Terhormat,

Berikut detail pasien sudah selesai diperiksa dan diterima pacs :
@component('mail::table')
    <table>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td>{{ Str::title($workload->study->patient->pat_name) }}</td>
        </tr>
        <tr>
            <td>Rekam Medis</td>
            <td>:</td>
            <td>{{ $workload->study->patient->pat_id }}</td>
        </tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $workload->study->patient->pat_birthdate }}</td>
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
            <td>{{ date('d-m-Y H:i:s', strtotime($workload->study->study_datetime)) }}</td>
        </tr>
    </table>
@endcomponent

Terimakasih<br>
@endcomponent
