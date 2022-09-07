Dokter Radiologi Yang Terhormat,

Berikut detail pasien belum dilakukan expertise :

`Nama Pasien : {{ Str::title($patient->name) }}
Rekam Medis : {{ $patient->mrn }}
Tanggal Lahir : {{ $patient->birth_date }}
Modalitas : {{ $patient->xray_type_code }}
Pemeriksaan : {{ $patient->prosedur }}
Waktu Pemeriksaan : {{ date('d-m-Y H:i:s', strtotime($patient->updated_time)) }}`

Silahkan dokter melakukan expertise,
Sebelum *waktu selesai pemeriksaan* pasien sampai dokter melakukan *expertise* melebihi dari *3 jam*

Terimakasih
