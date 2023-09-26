<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="1.png" />
    @include('includes.style')
    <title>Documentation Api</title>
</head>
<style>
    .k {
        color: #e06762;
    }

    .c {
        color: #201aa2;

    }

    .v {
        color: #267810;
    }

    .pretty{
    background:#2d2d2d;
    font-family:Menlo,Bitstream Vera Sans Mono,DejaVu Sans Mono,Monaco,Consolas,monospace;border:0!important
    }

    span.key{
        color: #e06762;
    }

    span.value{
        color: #9c9;
    }

    span.mid{
        color: whitesmoke;
    }
    ol li{
        color: #999999;
        margin-top:-18px;
    }

    a{
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><br><br><br>Workflow / Flowchart<br><br><br></h5>
            </div>
            <div class="card-body justify-content-center text-center">
                <div style="position:relative;">
                    <img class="img-fluid" width="500" src="{{ asset("assets/img/Rispacs none bridging SIMRS & modality worklist@2x.png") }}"
                        alt="">
                </div>
            </div>
            <div class="card-header">
                <h5 class="card-title"><br><br><br>Step 1 : Mapping alat radiologi (modalitas) dengan pemeriksaan<br><br><br></h5>
            </div>
            <table class="table table-striped table-sm">
                <tr>
                    <td>Relasi Tabel One Modalitas To Many Study.
                        <br>Buat kolom id dan alat radiologi yang tersedia di rumah sakit dan relasi ke pemeriksaan / tindakan radiologi.
                        <br>Untuk mapping alat dengan pemeriksaan bisa dikoordinasikan ke pihak radiologi.</td>
                </tr>
                <tr>
                    <td>
                        <img src="{{ asset("assets/img/mapping.svg") }}" alt="">
                    </td>
                </tr>
            </table>
            <div class="card-header">
                <h5 class="card-title"><br><br><br>Step 2 : POST data pasien ke alat radiologi<br><br><br></h5>
            </div>
            <div class="row">
            <div class="col">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td>Link api</td>
                        <td>:</td>
                        <td><a href="/api/documentation"><?= $_SERVER['HTTP_HOST']; ?>/api/orders</a></td>
                    </tr>
                    <tr>
                        <td>Method</td>
                        <td>:</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Headers</td>
                        <td>:</td>
                        <td>Accept - Application/json</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>Content-Type - Application/json</td>
                    </tr>
                    <tr>
                        <td>Authorization</td>
                        <td>:</td>
                        <td>Bearer Token</td>
                    </tr>
                    <tr>
                        <td>Body</td>
                        <td>:</td>
                        <td>raw (JSON)</td>
                    </tr>
                    <tr>
                        <td>Key</td>
                        <td>:</td>
                        <td>Nilai default</td>
                    </tr>
                    <tr>
                        <td>Value</td>
                        <td>:</td>
                        <td>Data Pasien SIMRS</td>
                    </tr>
                    <tr>
                        <td>Comment</td>
                        <td>:</td>
                        <td>Keterangan data SIMRS</td>
                    </tr>
                    <tr>
                        <td>Documentation Postman</td>
                        <td>:</td>
                        <td><a href="https://documenter.getpostman.com/view/10209530/2s93RWNAZP" target="_blank">Postman</a></td>
                    </tr>
                </table>
<pre class="pretty">
<ol>
<li><span class="mid">{</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"acc"</span> <span class="mid">:</span> <span class="value">"343695000001",</span><span> (unique, max 12 angka) FORMAT : no rekam medis + karakter acak. NOTE : 1 pemeriksaan 1 acc, 2 pemeriksaan 2 acc. dst</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"patientid"</span> <span class="mid">:</span> <span class="value">"10710923",</span><span> NO FOTO RADIOLOGI (JIKA TIDAK ADA ISI NORM (REKAM MEDIS))</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"mrn"</span> <span class="mid">:</span> <span class="value">"343695",</span><span> NORM (REKAM MEDIS) REQUIRED INT</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"name"</span> <span class="mid">:</span> <span class="value">"AGUS SUPRIADI, TN",</span><span> NAMA PASIEN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"address"</span> <span class="mid">:</span> <span class="value">"BANDUNG",</span><span> ALAMAT PASIEN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"sex"</span> <span class="mid">:</span> <span class="value">"M",</span><span> JENIS KELAMIN PASIEN FORMAT : M/F/O</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"birth_date"</span> <span class="mid">:</span> <span class="value">"1967-05-23",</span><span> TANGGAL LAHIR PASIEN FORMAT Y-M-D</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"weight"</span> <span class="mid">:</span> <span class="value">"50",</span><span> BERAT BADAN PASIEN - NOTE : JIKA TIDAK ADA VALUE 0</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dep_id"</span> <span class="mid">:</span> <span class="value">"10",</span><span> KODE POLI / RUANGAN - NOTE : DEFAULT JIKA PASIEN TAMU / DARI LUAR VALUE 0</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"name_dep"</span> <span class="mid">:</span> <span class="value">"Poli Gigi",</span><span> NAMA POLI / RUANGAN - NOTE : DEFAULT JIKA PASIEN TAMU / DARI LUAR VALUE Ruangan Lainnya</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"id_modality"</span> <span class="mid">:</span> <span class="value">"101",</span><span> KODE MODALITAS / ALAT dari simrs</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"xray_type_code"</span> <span class="mid">:</span> <span class="value">"CR",</span><span> NAMA MODALITAS / NAMA ALAT CONTOH CR/CT/US</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"id_prosedur"</span> <span class="mid">:</span> <span class="value">"202",</span><span> KODE PEMERIKSAAN STUDY REQUIRED INT</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"prosedur"</span> <span class="mid">:</span> <span class="value">"Thorax",</span><span> NAMA PEMERIKSAAN STUDY. CONTOH : THORAX / CT HEAD</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"harga_prosedur"</span> <span class="mid">:</span> <span class="value">"200000",</span><span> BIAYA PEMERIKSAAN PASIEN (Tanpa karakter , dan .)</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"radiographer_id"</span> <span class="mid">:</span> <span class="value">"9471",</span><span> KODE RADIOGRAFER</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"radiographer_name"</span> <span class="mid">:</span> <span class="value">"SERIOSA CELINE",</span><span> NAMA RADIOGRAFER</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokterid"</span> <span class="mid">:</span> <span class="value">"Y0026",</span><span> KODE DOKTER PENGIRIM / DOKTER DIRUANGAN. - NOTE : DEFAULT JIKA PASIEN TAMU / DARI LUAR VALUE 0</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"named"</span> <span class="mid">:</span> <span class="value">"YOSUA NUGRAHA PRATAMA. dr",</span><span> NAMA DOKTER PENGIRIM / DOKTER DIRUANGAN. NOTE : DEFAULT JIKA PASIEN TAMU / DARI LUAR VALUE Dokter Lainnya</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokradid"</span> <span class="mid">:</span> <span class="value">"W0004",</span><span> KODE DOKTER RADIOLOGY YANG MEMBUAT EXPERTISE</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokrad_name"</span> <span class="mid">:</span> <span class="value">"WAWAN KUSTIAWAN,dr.Sp.RAD",</span> NAMA DOKTER RADIOLOGY YANG MEMBUAT EXPERTISE<span></span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"create_time"</span> <span class="mid">:</span> <span class="value">"2020-06-28 08:14:45",</span><span> TANGGAL DAN JAM SAAT REGISTRASI PASIEN DIFRONTDESK FORMAT Y-M-D H:i:s</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"schedule_date"</span> <span class="mid">:</span> <span class="value">"2020-06-28",</span><span> TANGGAL PEMERIKSAAN PASIEN FORMAT Y-m-d</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"schedule_time"</span> <span class="mid">:</span> <span class="value">"00:58:45",</span><span> JAM PEMERIKSAAN PASIEN DAN DITAMBAH 10MENIT FORMAT H:i:s</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"priority"</span> <span class="mid">:</span> <span class="value">"Cito",</span><span> prioritas pasien CITO / NORMAL</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"pat_state"</span> <span class="mid">:</span> <span class="value">"Rawat Jalan",</span><span> INSTALASI RAWAT JALAN/RAWAT INAP/IGD - NOTE : DEFAULT JIKA PASIEN TAMU / DARI LUAR VALUE Instalasi Lainnya</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"spc_needs"</span> <span class="mid">:</span> <span class="value">"TB paru ?",</span><span> KLINIS/KELUHAN PASIEN - NOTE : DEFAULT JIKA TIDAK ADA BOLEH KOSONG</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"id_payment"</span> <span class="mid">:</span> <span class="value">"BPI",</span><span> ID PEMBAYARAN ? CONTOH : BPI / DNS </span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"payment"</span> <span class="mid">:</span> <span class="value">"BPJS (PBI)",</span><span> PEMBAYARAN PASIEN MENGGUNAKAN ? CONTOH : BPJS (PBI) / Dinas Sosial</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"fromorder"</span> <span class="mid">:</span> <span class="value">"SIMRS",</span><span> DEFAULT value SIMRS</span></li>
<li><span class="mid">}</span></li>
</ol>
</pre>
<p>&nbsp;&nbsp;<b>Catatan </b> : simrs POST JSON 1 acc untuk 1 pemeriksaan/study <br />
    &nbsp;&nbsp;jika ada 1 pasien 3 pemeriksaan maka simrs mengirimkan 3 POST JSON dan 3 acc berbeda
</p>
            </div>
        </div>
        <div class="card-header">
            <h5 class="card-title"><br><br><br>2.1 : Menampilkan Order SIMRS<br><br><br></h5>
        </div>
        <table class="table table-striped table-sm">
            <tr>
                <td>- Menampilkan ORDER pasien dari SIMRS berdasarkan acc dan mrn</td>
            </tr>
            <tr>
                <td>&nbsp; &nbsp; - Parameter : <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; acc : 343695000001</div>
                    <div class="k">&nbsp; &nbsp; &nbsp; mrn : 10710923</div>
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm">
            <tr>
                <td>Link api</td>
                <td>:</td>
                <td><a href="/api/documentation"><?= $_SERVER['HTTP_HOST']; ?>/api/orders/{acc}/{mrn}</a></td>
            </tr>
            <tr>
                <td>Method</td>
                <td>:</td>
                <td>GET</td>
            </tr>
            <tr>
                <td>Headers</td>
                <td>:</td>
                <td>Accept - Application/json</td>
            </tr>
            <tr>
                <td></td>
                <td>:</td>
                <td>Content-Type - Application/json</td>
            </tr>
            <tr>
                <td>Authorization</td>
                <td>:</td>
                <td>Bearer Token</td>
            </tr>
            <tr>
                <td>Documentation Postman</td>
                <td>:</td>
                <td><a href="https://documenter.getpostman.com/view/10209530/2s93RWNAZP" target="_blank">Postman</a></td>
            </tr>
        </table>
        <table class="table table-striped table-sm">
            <tr>
                <td>- Menampilkan ORDER pasien dari SIMRS berdasarkan tanggal hari ini</td>
            </tr>
            <tr>
                <td>&nbsp; &nbsp; - Parameter : <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; examed_at : 2023-03-31 (Y-m-d)</div>
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm">
            <tr>
                <td>Link api</td>
                <td>:</td>
                <td><a href="/api/documentation"><?= $_SERVER['HTTP_HOST']; ?>/api/orders/one-day</a></td>
            </tr>
            <tr>
                <td>Method</td>
                <td>:</td>
                <td>POST</td>
            </tr>
            <tr>
                <td>Headers</td>
                <td>:</td>
                <td>Accept - Application/json</td>
            </tr>
            <tr>
                <td></td>
                <td>:</td>
                <td>Content-Type - Application/json</td>
            </tr>
            <tr>
                <td>Authorization</td>
                <td>:</td>
                <td>Bearer Token</td>
            </tr>
            <tr>
                <td>Documentation Postman</td>
                <td>:</td>
                <td><a href="https://documenter.getpostman.com/view/10209530/2s93RWNAZP" target="_blank">Postman</a></td>
            </tr>
        </table>
        <div class="card-header">
            <h5 class="card-title"><br><br><br>2.2 : DELETE Order SIMRS dan Worklist Modality<br><br><br></h5>
        </div>
        <table class="table table-striped table-sm">
            <tr>
                <td>&nbsp; &nbsp; - Parameter : <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; acc : 343695000001</div>
                    <div class="k">&nbsp; &nbsp; &nbsp; mrn : 10710923</div>
                    &nbsp; &nbsp; - Note : Ketika pasien sudah diperiksa, tidak bisa dihapus dari simrs<br />
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm">
            <tr>
                <td>Link api</td>
                <td>:</td>
                <td><a href="/api/documentation"><?= $_SERVER['HTTP_HOST']; ?>/api/orders/{acc}/{mrn}</a></td>
            </tr>
            <tr>
                <td>Method</td>
                <td>:</td>
                <td>DELETE</td>
            </tr>
            <tr>
                <td>Headers</td>
                <td>:</td>
                <td>Accept - Application/json</td>
            </tr>
            <tr>
                <td></td>
                <td>:</td>
                <td>Content-Type - Application/json</td>
            </tr>
            <tr>
                <td>Authorization</td>
                <td>:</td>
                <td>Bearer Token</td>
            </tr>
            <tr>
                <td>Documentation Postman</td>
                <td>:</td>
                <td><a href="https://documenter.getpostman.com/view/10209530/2s93RWNAZP" target="_blank">Postman</a></td>
            </tr>
        </table>
        <div class="card-header">
            <h5 class="card-title"><br><br><br>Step 3 : GET Hasil gambar radiologi & Hasil expertise dokter radiologi menggunakan LINK URL / JSON<br><br><br></h5>
        </div>
        <table class="table table-striped table-sm">
            <tr>
                <td>Hal yang dilakukan dari aplikasi SIMRS ada 2 metode yaitu link static atau get JSON: </td>
            </tr>
            <tr>
                <td>1. Buat button untuk melihat hasil expertise dokter <br>
                    &nbsp; &nbsp; - Parameter : <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; acc : 343695000001</div>
                    <div class="k">&nbsp; &nbsp; &nbsp; mrn : 10710923</div><br>
                    &nbsp; &nbsp; - Berikut link url untuk membuka hasil expertise dokter (.pdf) : <br>
                    <a href="/simrs-expertise/343695000001/10710923" target="_blank">
                        <div class="v">&nbsp; &nbsp; &nbsp; <?= $_SERVER['HTTP_HOST'] ?>/simrs-expertise/<div class="c" style="display:inline">343695000001</div>/<div class="k" style="display:inline">10710923</div>
                        </div>
                    </a>
                    <br />
                    &nbsp; &nbsp; - Validasi notifikasi : <br />
                    &nbsp; &nbsp; ketika acc number tidak cocok : Pasien belum bridging dengan simrs <br>
                    &nbsp; &nbsp; ketika acc number cocok dan belum dilakukan expertise : Pasien belum diexpertise <br>
                </td>
                <br>
                <td>2. Buat button untuk melihat hasil gambar dicom<br>
                    &nbsp; &nbsp; - Parameter : <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; acc : 343695000001</div>
                    <div class="k">&nbsp; &nbsp; &nbsp; mrn : 10710923</div><br>
                    &nbsp; &nbsp; - Berikut link url untuk membuka hasil gambar dicom (URL) <br>
                    <a href="/simrs-dicom/343695000001/10710923" target="_blank">
                        <div class="v">&nbsp; &nbsp; &nbsp; <?= $_SERVER['HTTP_HOST'] ?>/simrs-dicom/<div class="c" style="display:inline">343695000001</div>/<div class="k" style="display:inline">10710923</div>
                    </div>
                    </a>
                    <br />
                    &nbsp; &nbsp; - Validasi notifikasi : <br />
                    &nbsp; &nbsp; ketika acc number tidak cocok : Pasien belum bridging dengan simrs <br>
                </td>
            </tr>
            <tr>
                <td>2. GET metode JSON</td>
            </tr>
        </table>
        <table class="table table-borderless table-sm">
            <tr>
                <td>Link api</td>
                <td>:</td>
                <td><a href="/api/documentation"><?= $_SERVER['HTTP_HOST']; ?>/api/simrs/{acc}/{mrn}</a></td>
            </tr>
            <tr>
                <td>Method</td>
                <td>:</td>
                <td>GET</td>
            </tr>
            <tr>
                <td>Headers</td>
                <td>:</td>
                <td>Accept - Application/json</td>
            </tr>
            <tr>
                <td></td>
                <td>:</td>
                <td>Content-Type - Application/json</td>
            </tr>
            <tr>
                <td>Authorization</td>
                <td>:</td>
                <td>Bearer Token</td>
            </tr>
            <tr>
                <td>Key</td>
                <td>:</td>
                <td>Nilai default</td>
            </tr>
            <tr>
                <td>Value</td>
                <td>:</td>
                <td>Data Pasien</td>
            </tr>
            <tr>
                <td>Comment</td>
                <td>:</td>
                <td>Keterangan data </td>
            </tr>
            <tr>
                <td>Documentation Postman</td>
                <td>:</td>
                <td><a href="https://documenter.getpostman.com/view/10209530/2s93RWNAZP" target="_blank">Postman</a></td>
            </tr>
        </table>
<pre class="pretty">
<ol>
<li><span class="mid">{</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"acc"</span> <span class="mid">:</span> <span class="value">"343695000001",</span><span> kode unique acc</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"mrn"</span> <span class="mid">:</span> <span class="value">"10710923",</span><span> no rekam medis</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"pat_name"</span> <span class="mid">:</span> <span class="value">"ENNI MARLINA PANJAITAN /65 THN",</span><span> nama pasien</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"pat_sex"</span> <span class="mid">:</span> <span class="value">"F",</span><span> jenis kelamin</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"study_iuid"</span> <span class="mid">:</span> <span class="value">"1.2.840.113564.1921681010.20191015084726754890",</span><span> kode unique study</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"mods_in_study"</span> <span class="mid">:</span> <span class="value">"CR",</span><span> kode unique study</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"study_desc"</span> <span class="mid">:</span> <span class="value">"THORAX",</span><span> nama pemeriksaan / tindakan radiologi</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"updated_time"</span> <span class="mid">:</span> <span class="value">"25-10-2021 16:55",</span><span> waktu pasien dikirim ke pacs / selesai diperiksa</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"status"</span> <span class="mid">:</span> <span class="value">"approved",</span><span> status : status bacaan pasien : waiting belum dibaca. approved sudah dibaca</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"approved_at"</span> <span class="mid">:</span> <span class="value">"03-04-2023 15:26",</span><span> waktu dokter radiologi melakukan expertise</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"fill"</span> <span class="mid">:</span> <span class="value">"KLINIS&nbsp; : OSTEOPOROSIS
    ANALISIS TEKNIK :
    - Lumbal center, posisi baik, tak tampak sklerotik end plate
    - Antebrachii kiri, distal radius ulna tak tampak sklerotik
    - Hip joint kiri, acetabulum kiri tampak sklerotik
    - Femur&nbsp; kiri, caput femoris kiri tampak sklerotik

    LUMBAL SPINE L1-L4 [BMD ( gr / cm 2)1.040] [T-SCORE- 1,2] [Z-SCORE 0.7]

    Digunakan analisis Lumbal Spine (L1-L4) karena selisih nilai BMD &lt; 10%
    Digunakan analisis T-score karena usia penderita &gt; 50 tahun (-1,2)
    Berdasarkan klasifikasi WHO memenuhi kriteria OSTEOPENIA",</span><span> hasil expertise </span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"link_dicom"</span> <span class="mid">:</span> <span class="value">"http://{{ $_SERVER['HTTP_HOST']; }}/simrs-dicom/343695000001/10710923",</span><span> link hasil dicom</span></li>
<li><span class="mid">}</span></li>
</ol>
</pre>
        {{-- <div class="card-header">
            <h5 class="card-title"><br><br><br>Step 4 : POST Hasil & waktu expertise dokter radiologi ke SIMRS<br><br><br></h5>
        </div>
        <table class="table table-striped table-sm">
            <tr>
            </tr>
            <tr>
                <td>- SIMRS membuat web service / API untuk menerima data dari RISPACS.
                    <br>
                    *require method PUT, update data pasien dengan parameter ACC
                </td>
            </tr>
        </table> --}}
        {{-- <div class="card-header">
            <h5 class="card-title"><br><br><br>Step 5 : Update UID SIMRS<br><br></h5>
        </div>
        <table class="table table-striped table-sm">
            <tr>
                <td>Antisipasi ketika ada pasien registrasi manual atau tidak terintegrasi SIMRS, SIMRS tidak bisa buka gambar radiologi dan hasil expertise dikarenakan kode UID generate dari alat <br />
                    solusinya adalah RISPACS UPDATE uid ke SIMRS dengan catatan SIMRS membuat web servis / API. update uid dengan parameter acc & mrn
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
        </table> --}}
    </div>
    </div>
    @include('includes.script');
</body>

</html>
