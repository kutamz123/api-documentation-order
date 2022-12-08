<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="1.png" />
    @include('includes.style');
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
                    <td>One Modalitas To Many Study</td>
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
                        <td><a href="http://103.111.207.70:5000/api/documentation">http://103.111.207.70:5000/api/orders</a></td>
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
                </table>
<pre class="pretty">
<ol>
<li><span class="mid">{</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"uid"</span> <span class="mid">:</span> <span class="value">"1.2.40.0.13.1.770804.20200710.20070715224",</span><span> (primary key) 1.2.40.0.13.1.NORM.TANGGALSEKARANG.NOPERIKSA & KODETINDAKAN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"acc"</span> <span class="mid">:</span> <span class="value">"2008241035",</span><span> (unique, max 12 angka) DATETIME HARI INI FORMAT : y-m-d + 4 angkarandom / increment</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"patientid"</span> <span class="mid">:</span> <span class="value">"X10710",</span><span> NO FOTO RADIOLOGI (JIKA TIDAK ADA ISI NORM (REKAM MEDIS))</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"mrn"</span> <span class="mid">:</span> <span class="value">"343690",</span><span> NORM (REKAM MEDIS)</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"name"</span> <span class="mid">:</span> <span class="value">"AGUS SUPRIADI, TN",</span><span> NAMA PASIEN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"address"</span> <span class="mid">:</span> <span class="value">"BANDUNG",</span><span> ALAMAT PASIEN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"sex"</span> <span class="mid">:</span> <span class="value">"M",</span><span> JENIS KELAMIN PASIEN FORMAT : M/F/O</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"birth_date"</span> <span class="mid">:</span> <span class="value">"1967-05-23",</span><span> TANGGAL LAHIR PASIEN FORMAT Y-M-D</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"weight"</span> <span class="mid">:</span> <span class="value">"50",</span><span> BERAT BADAN PASIEN - 0</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dep_id"</span> <span class="mid">:</span> <span class="value">"10",</span><span> KODE POLI / RUANGAN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"name_dep"</span> <span class="mid">:</span> <span class="value">"Poli Gigi",</span><span> Nama poli / ruangan</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"id_modality"</span> <span class="mid">:</span> <span class="value">"101",</span><span> KODE MODALITAS / ALAT </span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"xray_type_code"</span> <span class="mid">:</span> <span class="value">"CR",</span><span> NAMA MODALITAS / NAMA ALAT CONTOH CR/CT/US</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"id_prosedur"</span> <span class="mid">:</span> <span class="value">"202",</span><span> KODE PEMERIKSAAN PASIEN / STUDY </span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"prosedur"</span> <span class="mid">:</span> <span class="value">"Thorax",</span><span> NAMA PEMERIKSAAN PASIEN / STUDY. CONTOH : THORAX / CT HEAD</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"harga_prosedur"</span> <span class="mid">:</span> <span class="value">"200000",</span><span> BIAYA PEMERIKSAAN PASIEN (Tanpa karakter , dan .)</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"radiographer_id"</span> <span class="mid">:</span> <span class="value">"9471",</span><span> KODE RADIOGRAFER</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"radiographer_name"</span> <span class="mid">:</span> <span class="value">"SERIOSA CELINE",</span><span> NAMA RADIOGRAFER</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokterid"</span> <span class="mid">:</span> <span class="value">"Y0026",</span><span> KODE DOKTER PENGIRIM / DOKTER DIRUANGAN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"named"</span> <span class="mid">:</span> <span class="value">"YOSUA NUGRAHA PRATAMA. dr",</span><span> NAMA DOKTER PENGIRIM / DOKTER DIRUANGAN. NOTE : JIKA DOKTER PENGIRIM TIDAK ADA ISI VALUE Dokter Luar</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokradid"</span> <span class="mid">:</span> <span class="value">"W0004",</span><span> KODE DOKTER RADIOLOGY YANG MEMBUAT EXPERTISE</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokrad_name"</span> <span class="mid">:</span> <span class="value">"WAWAN KUSTIAWAN,dr.Sp.RAD",</span> NAMA DOKTER RADIOLOGY YANG MEMBUAT EXPERTISE<span></span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"create_time"</span> <span class="mid">:</span> <span class="value">"2020-06-28 08:14:45",</span><span> TANGGAL DAN JAM SAAT REGISTRASI PASIEN DIFRONTDESK FORMAT Y-M-D H:i:s</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"schedule_date"</span> <span class="mid">:</span> <span class="value">"2020-06-28",</span><span> TANGGAL PEMERIKSAAN PASIEN FORMAT Y-m-d</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"schedule_time"</span> <span class="mid">:</span> <span class="value">"00:58:45",</span><span> JAM PEMERIKSAAN PASIEN DAN DITAMBAH 10MENIT FORMAT H:i:s</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"priority"</span> <span class="mid">:</span> <span class="value">"Cito",</span><span> prioritas pasien CITO / NORMAL</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"pat_state"</span> <span class="mid">:</span> <span class="value">"Rawat Jalan",</span><span> RAWAT JALAN / RAWAT INAP</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"spc_needs"</span> <span class="mid">:</span> <span class="value">"TB paru ?",</span><span> KLINIS/KELUHAN PASIEN - NULL</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"payment"</span> <span class="mid">:</span> <span class="value">"Tunai",</span><span> PEMBAYARAN PASIEN MENGGUNAKAN ?</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"fromorder"</span> <span class="mid">:</span> <span class="value">"SIMRS",</span><span> Default value SIMRS</span></li>
<li><span class="mid">}</span></li>
</ol>
</pre>
<p>&nbsp;&nbsp;<b>Catatan </b> : simrs POST JSON 1 uid untuk 1 pemeriksaan/study <br />
    &nbsp;&nbsp;jika ada 1 pasien 3 pemeriksaan maka simrs mengirimkan 3 POST JSON
</p>
            </div>
        </div>
        <div class="card-header">
            <h5 class="card-title"><br><br><br>Step 3 : POST Hasil & waktu expertise dokter radiologi ke SIMRS<br><br><br></h5>
        </div>
        <table class="table table-striped table-sm">
            <tr>
            </tr>
            <tr>
                <td>- SIMRS membuat web service / API untuk menerima data dari RISPACS.
                    <br>
                    *require method PUT, update data pasien dengan parameter UID
                </td>
            </tr>
        </table>
        <div class="card-header">
            <h5 class="card-title"><br><br><br>Step 4 : GET Hasil gambar radiologi & Hasil expertise dokter radiologi menggunakan LINK URL<br><br><br></h5>
        </div>
        <table class="table table-striped table-sm">
            <tr>
                <td>Hal yang dilakukan dari aplikasi SIMRS : </td>
            </tr>
            <tr>
                <td>1. Buat button untuk melihat hasil expertise dokter <br>
                    &nbsp; &nbsp; - Berikut link url untuk membuka hasil expertise dokter : <br>
                    <div class="v">&nbsp; &nbsp; &nbsp; http://103.111.207.70:8089/intiwid/radiology/pdf/expertise.php?uid=
                    </div><br>
                    &nbsp; &nbsp; - Dengan parameter UID get database simrs <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; 1.2.40.0.13.1.661877.20210921.118427
                    </div><br>
                    &nbsp; &nbsp; - Jadi link digabung dengan parameter UID hasilnya adalah <br>
                    <a href="http://103.111.207.70:8089/intiwid/radiology/pdf/expertise.php?uid=1.2.40.0.13.1.661877.20210921.118427" target="_blank">
                        <div class="v">&nbsp; &nbsp; &nbsp; http://103.111.207.70:8089/intiwid/radiology/pdf/expertise.php?uid=<div
                            class="c" style="display:inline">1.2.40.0.13.1.661877.20210921.118427</div>
                        </div>
                    </a>
                    <div>
                        <br>
                        <img class="img-fluid" src="{{ asset("assets/img/pdf.png") }}" alt="">
                    </div>
                </td>
            </tr>
            <tr>
                <td>2. Buat button untuk melihat hasil gambar dicom versi 1<br>
                    &nbsp; &nbsp; - Berikut link url untuk membuka hasil gambar dicom : <br>
                    <div class="v">&nbsp; &nbsp; &nbsp; http://103.111.207.70:19898/intiwid/viewer.html?studyUID=
                    </div><br>
                    &nbsp; &nbsp; - Dengan parameter UID get database simrs <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; 1.2.840.113564.1921681011.20191015083858984410
                    </div><br>
                    &nbsp; &nbsp; - Jadi link digabung dengan parameter UID hasilnya adalah <br>
                    <a href="http://103.111.207.70:19898/intiwid/viewer.html?studyUID=1.2.840.113564.1921681011.20191015083858984410" target="_blank">
                        <div class="v">&nbsp; &nbsp; &nbsp; http://103.111.207.70:19898/intiwid/viewer.html?studyUID=<div
                                class="c" style="display:inline">1.2.840.113564.1921681011.20191015083858984410</div>
                        </div>
                    </a>
                    <div>
                        <br><img class="img-fluid" src="{{ asset("assets/img/dicom1.png") }}" alt="">
                    </div>
                </td>
            </tr>
            {{-- <tr>
                <td>3. Buat button untuk melihat hasil gambar dicom versi 2 <br>
                    &nbsp; &nbsp; - Berikut link url untuk membuka hasil gambar dicom : <br>
                    <div class="v">&nbsp; &nbsp; &nbsp; http://103.111.207.70:92/viewer/
                    </div><br>
                    &nbsp; &nbsp; - Dengan parameter UID get database simrs <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; 1.2.840.113564.1921681011.20191015083858984410
                    </div><br>
                    &nbsp; &nbsp; - Jadi link digabung dengan parameter UID hasilnya adalah <br>
                    <a href="http://103.111.207.70:92/viewer/1.2.840.113564.1921681011.20191015083858984410" target="_blank">
                        <div class="v">&nbsp; &nbsp; &nbsp; http://103.111.207.70:92/viewer/<div class="c"
                            style="display:inline">1.2.840.113564.1921681011.20191015083858984410</div>
                        </div>
                    </a>
                    <div>
                        <br><img class="img-fluid" src="{{ asset("assets/img/dicom2.png") }}" alt="">
                    </div>
                </td>
            </tr> --}}
        </table>
    </div>
    </div>
    @include('includes.script');
</body>

</html>
