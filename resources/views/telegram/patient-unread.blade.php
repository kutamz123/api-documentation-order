Dokter Radiologi Yang Terhormat,

Berikut detail pasien belum dilakukan expertise :

`Nama Pasien : {{ Str::title($workload->patient->pat_name) }}
Rekam Medis : {{ $workload->patient->pat_id }}
Tanggal Lahir : {{ $workload->patient->pat_birthdate }}
Modalitas : {{ $workload->study->mods_in_study }}
Pemeriksaan : {{ $workload->study->study_desc }}
Waktu Selesai Pemeriksaan : {{ date('d-m-Y H:i:s', strtotime($workload->updated_time_pacsio)) }}`

Silahkan dokter melakukan expertise,
Sebelum *waktu selesai pemeriksaan* pasien sampai dokter melakukan *expertise* melebihi dari *3 jam*

Terimakasih
