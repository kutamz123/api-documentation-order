@component('mail::message')
Dokter Radiologi Yang Terhormat,

Berikut detail pasien belum dilakukan expertise :
@component('mail::table')
    <table>
        <tr>
            <th>Nama Pasien</th>
            <th>Rekam Medis</th>
            <th>Tanggal Lahir</th>
            <th>Modalitas</th>
            <th>Pemeriksaan</th>
            <th>Waktu Pemeriksaan</th>
        </tr>
        @foreach ($patients as $patient)
            <tr>
                <td>{{ Str::title($patient->name) }}</td>
                <td>{{ $patient->mrn }}</td>
                <td>{{ $patient->birth_date }}</td>
                <td>{{ $patient->xray_type_code }}</td>
                <td>{{ $patient->prosedur }}</td>
                <td>{{ date('d-m-Y H:i:s', strtotime($patient->updated_time)) }}</td>
            </tr>
        @endforeach
    </table>
@endcomponent

Silahkan dokter melakukan expertise, <br />
Sebelum <b>waktu selesai pemeriksaan</b> pasien sampai dokter melakukan <b>expertise</b> melelebihi dari <b>3 jam</b>

Terimakasih<br>
@endcomponent
