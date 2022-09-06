@component('mail::message')
Dokter Radiologi Yang Terhormat,

Berikut detail pasien belum dilakukan expertise :
@component('mail::table')
    <table>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td>{{ Str::title($patient->name) }}</td>
        </tr>
        <tr>
            <td>Rekam Medis</td>
            <td>:</td>
            <td>{{ $patient->mrn }}</td>
        </tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $patient->birth_date }}</td>
        </tr>
        <tr>
            <td>Modalitas</td>
            <td>:</td>
            <td>{{ $patient->xray_type_code }}</td>
        </tr>
        <tr>
            <td>Pemeriksaan</td>
            <td>:</td>
            <td>{{ $patient->prosedur }}</td>
        </tr>
        <tr>
            <td>Waktu Pemeriksaan</td>
            <td>:</td>
            <td>{{ date('d-m-Y H:i:s', strtotime($patient->updated_time)) }}</td>
        </tr>
    </table>
@endcomponent

Silahkan dokter melakukan expertise, <br />
Sebelum <b>waktu selesai pemeriksaan</b> pasien sampai dokter melakukan <b>expertise</b> melelebihi dari <b>3 jam</b>

Terimakasih<br>
@endcomponent
