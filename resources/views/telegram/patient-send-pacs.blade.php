Dokter Radiologi Yang Terhormat,

Berikut detail pasien sudah selesai diperiksa dan diterima pacs :

`Nama Pasien : {{ Str::title($workload->study->patient->pat_name) }}
Rekam Medis : {{ $workload->study->patient->pat_id }}
Tanggal Lahir : {{ $workload->study->patient->pat_birthdate }}
Modalitas : {{ $workload->study->mods_in_study }}
Pemeriksaan : {{ $workload->study->study_desc }}
Waktu Selesai Pemeriksaan : {{ date('d-m-Y H:i:s', strtotime($workload->study_datetime_pacsio)) }}`

Terimakasih
