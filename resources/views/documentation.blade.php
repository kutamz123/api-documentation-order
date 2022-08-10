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
            <div class="card-body">
                <div style="position:relative; top:200px; margin-bottom:700px;">
                    <img class="img-fluid" src="{{ asset("assets/img/Rispacs none bridging SIMRS & modality worklist@2x.png") }}"
                        alt="">
                </div>
            </div>
            <div class="card-header">
                <h5 class="card-title"><br><br><br>Api Json<br><br><br></h5>
            </div>
            <div class="row">
            <div class="col">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td>Link api</td>
                        <td>:</td>
                        <td>http://192.168.0.192:8000/api/documentation</td>
                    </tr>
                    <tr>
                        <td>Method</td>
                        <td>:</td>
                        <td>POST</td>
                    </tr>
                    <tr>
                        <td>Format</td>
                        <td>:</td>
                        <td>JSON</td>
                    </tr>
                    <tr>
                        <td>Key</td>
                        <td>:</td>
                        <td>Nilai default</td>
                    </tr>
                    <tr>
                        <td>Value</td>
                        <td>:</td>
                        <td>Data PASIEN DARI SIM RS (untuk value dibawah hanya contoh data)</td>
                    </tr>
                    <tr>
                        <td>Comment</td>
                        <td>:</td>
                        <td>Keterangan data sim RS</td>
                    </tr>
                </table>
<pre class="pretty">
<ol>
<li><span class="mid">{</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"uid"</span> <span class="mid">:</span> <span class="value">"1.2.40.0.13.1.770804.20200710.20070715224",</span><span> //1.2.40.0.13.1.NORM.TANGGALSEKARANG.NOPERIKSA & KODETINDAKAN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"acc"</span> <span class="mid">:</span> <span class="value">"2008241035",</span><span> //DATETIME HARI INI FORMAT : y-m-d + angkarandom</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"patientid"</span> <span class="mid">:</span> <span class="value">"X10710",</span><span> //KODE TRANSAKSI TINDAKAN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"mrn"</span> <span class="mid">:</span> <span class="value">"343690",</span><span> //NORM (REKAM MEDIS)</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"name"</span> <span class="mid">:</span> <span class="value">"AGUS SUPRIADI, TN",</span><span> //NAMA PASIEN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"address"</span> <span class="mid">:</span> <span class="value">"BANDUNG",</span><span> //ALAMAT PASIEN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"sex"</span> <span class="mid">:</span> <span class="value">"M",</span><span> //JENIS KELAMIN PASIEN CONTOH : M/F/O</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"birth_date"</span> <span class="mid">:</span> <span class="value">"1967-05-23",</span><span> //TANGGAL LAHIR PASIEN FORMAT Y-M-D</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"weight"</span> <span class="mid">:</span> <span class="value">"50",</span><span> //BERAT BADAN PASIEN - NULL</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"name_dep"</span> <span class="mid">:</span> <span class="value">"Poli Gigi",</span><span> //Nama poli / ruangan</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"xray_type_code"</span> <span class="mid">:</span> <span class="value">"CR",</span><span> //NAMA MODALITAS / NAMA ALAT CONTOH CR/CT DLL</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"typename"</span> <span class="mid">:</span> <span class="value">"Computed Radiography",</span><span> //KEPANJANGAN NAMA ALAT - NULL</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"prosedur"</span> <span class="mid">:</span> <span class="value">"Thorax",</span><span> //NAMA PEMERIKSAAN PASIEN / PROCEDUR. CONTOH : THORAX / CT HEAD</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokterid"</span> <span class="mid">:</span> <span class="value">"Y0026",</span><span> //KODE DOKTER PENGIRIM / DOKTER DIRUANGAN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"named"</span> <span class="mid">:</span> <span class="value">"YOSUA NUGRAHA PRATAMA. dr",</span><span> //NAMA DOKTER PENGIRIM / DOKTER DIRUANGAN. NOTE : JIKA DOKTER PENGIRIM TIDAK ADA ISI VALUE Dokter Luar</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokradid"</span> <span class="mid">:</span> <span class="value">"W0004",</span><span> //KODE DOKTER RADIOLOGY YANG MEMBUAT EXPERTISE</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokrad_name"</span> <span class="mid">:</span> <span class="value">"WAWAN KUSTIAWAN,dr.Sp.RAD",</span> // NAMA DOKTER RADIOLOGY YANG MEMBUAT EXPERTISE<span></span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"create_time"</span> <span class="mid">:</span> <span class="value">"2020-06-28 08:14:45",</span><span> //	TANGGAL DAN JAM SAAT REGISTRASI PASIEN DIFRONTDESK FORMAT Y-M-D H:i:s</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"schedule_date"</span> <span class="mid">:</span> <span class="value">"2020-06-28",</span><span> //TANGGAL PEMERIKSAAN PASIEN</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"schedule_time"</span> <span class="mid">:</span> <span class="value">"00:58:45",</span><span> //JAM PEMERIKSAAN PASIEN DAN DITAMBAH 10MENIT</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"priority"</span> <span class="mid">:</span> <span class="value">"Cito",</span><span> //prioritas pasien CITO / NORMAL</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"pat_state"</span> <span class="mid">:</span> <span class="value">"Rawat Jalan",</span><span> //RAWAT JALAN / RAWA INAP</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"spc_needs"</span> <span class="mid">:</span> <span class="value">"TB paru ?",</span><span> //KELUHAN PASIEN - NULL</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"payment"</span> <span class="mid">:</span> <span class="value">"Tunai",</span><span> //PEMBAYARAN PASIEN MENGGUNAKAN ?</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"fromorder"</span> <span class="mid">:</span> <span class="value">"SIMRS",</span><span> //Default value SIMRS</span></li>
<li><span class="mid">}</span></li>
</ol>
</pre>
{{-- <pre class="prettyprint linenums">
    {
    &nbsp;&nbsp;&nbsp; <span class="kwd">"uid"</span> : "1.2.40.0.13.1.770804.20200710.20070715224"
    &nbsp;&nbsp;&nbsp; "acc" : "J200619505"
    &nbsp;&nbsp;&nbsp; "patientid" : "X10710"
    &nbsp;&nbsp;&nbsp; "mrn" : "343690"
    &nbsp;&nbsp;&nbsp; "name" : "AGUS SUPRIADI, TN"
    &nbsp;&nbsp;&nbsp; "address" : "BANDUNG"
    &nbsp;&nbsp;&nbsp; "sex" : "M"
    &nbsp;&nbsp;&nbsp; "birth_date" : "1967-05-23"
    &nbsp;&nbsp;&nbsp; "weight" : "50"
    &nbsp;&nbsp;&nbsp; "name_dep" : "Poli Gigi"
    &nbsp;&nbsp;&nbsp; "xray_type_code" : "CR"
    &nbsp;&nbsp;&nbsp; "typename" : "Computed Radiography"
    &nbsp;&nbsp;&nbsp; "prosedur" : "Thorax"
    &nbsp;&nbsp;&nbsp; "dokterid" : "Y0026"
    &nbsp;&nbsp;&nbsp; "named" : "YOSUA NUGRAHA PRATAMA. dr"
    &nbsp;&nbsp;&nbsp; "dokradid" : "W0004"
    &nbsp;&nbsp;&nbsp; "dokrad_name" : "WAWAN KUSTIAWAN,dr.Sp.RAD"
    &nbsp;&nbsp;&nbsp; "create_time" : "2020:06:28 08:14:45"
    &nbsp;&nbsp;&nbsp; "schedule_date" : "2020-06-28"
    &nbsp;&nbsp;&nbsp; "schedule_time" : "00:58:45"
    &nbsp;&nbsp;&nbsp; "priority" : "Cito"
    &nbsp;&nbsp;&nbsp; "pat_state" : "Rawat Jalan"
    &nbsp;&nbsp;&nbsp; "spc_needs" : "TB paru ?"
    &nbsp;&nbsp;&nbsp; "payment" : "Tunai"
    &nbsp;&nbsp;&nbsp; "fromorder" : "SIMRS"
    }
    </pre> --}}
                {{-- <table class="table table-striped">
                    <tr>
                        <td>{</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"uid"</td>
                        <td>:</td>
                        <td class="v">"1.2.40.0.13.1.770804.20200710.20070715224"</td>
                        <td class="c">1.2.40.0.13.1.NORM.TANGGALSEKARANG.NOPERIKSA & KODETINDAKAN</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"acc"</td>
                        <td>:</td>
                        <td class="v">"J200619505"</td>
                        <td class="c">KODEKUNJUNGAN</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"patientid"</td>
                        <td>:</td>
                        <td class="v">"X10710"</td>
                        <td class="c">KODE TRANSAKSI TINDAKAN</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"mrn"</td>
                        <td>:</td>
                        <td class="v">"343690"</td>
                        <td class="c">NORM (REKAM MEDIS)</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"name"</td>
                        <td>:</td>
                        <td class="v">"AGUS SUPRIADI, TN."</td>
                        <td class="c">NAMA PASIEN</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"address"</td>
                        <td>:</td>
                        <td class="v">"BANDUNG"</td>
                        <td class="c">ALAMAT PASIEN</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"sex"</td>
                        <td>:</td>
                        <td class="v">"M"</td>
                        <td class="c">JENIS KELAMIN PASIEN CONTOH : M/F/O</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"birth_date"</td>
                        <td>:</td>
                        <td class="v">"1967-05-23"</td>
                        <td class="c">TANGGAL LAHIR PASIEN FORMAT Y-M-D</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"weight"</td>
                        <td>:</td>
                        <td class="v">"NULL"</td>
                        <td class="c">BERAT BADAN PASIEN - NULL</td>
                    </tr>
					<tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"name_dep"</td>
                        <td>:</td>
                        <td class="v">"Poli Gigi"</td>
                        <td class="c">Nama poli / ruangan</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"xray_type_code"</td>
                        <td>:</td>
                        <td class="v">"CR"</td>
                        <td class="c">NAMA MODALITAS / NAMA ALAT CONTOH CR/CT DLL</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"typename"</td>
                        <td>:</td>
                        <td class="v">"Computed Radiography"</td>
                        <td class="c">KEPANJANGAN NAMA ALAT - NULL</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"prosedur"</td>
                        <td>:</td>
                        <td class="v">"Thorax"</td>
                        <td class="c">NAMA PEMERIKSAAN PASIEN / PROCEDUR. CONTOH : THORAX / CT HEAD</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"dokterid"</td>
                        <td>:</td>
                        <td class="v">"Y0026"</td>
                        <td class="c">KODE DOKTER PENGIRIM / DOKTER DIRUANGAN</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"named"</td>
                        <td>:</td>
                        <td class="v">"YOSUA NUGRAHA PRATAMA. dr"</td>
                        <td class="c">NAMA DOKTER PENGIRIM / DOKTER DIRUANGAN. <br> NOTE : JIKA DOKTER PENGIRIM
                            TIDAK
                            ADA ISI
                            VALUE
                            Dokter Luar</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"dokradid"</td>
                        <td>:</td>
                        <td class="v">"W0004"</td>
                        <td class="c">KODE DOKTER RADIOLOGY YANG MEMBUAT EXPERTISE</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"dokrad_name"</td>
                        <td>:</td>
                        <td class="v">"WAWAN KUSTIAWAN,dr.Sp.RAD"</td>
                        <td class="c">NAMA DOKTER RADIOLOGY YANG MEMBUAT EXPERTISE</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"create_time"</td>
                        <td>:</td>
                        <td class="v">"2020:06:28 08:14:45"</td>
                        <td class="c">TANGGAL DAN JAM SAAT REGISTRASI PASIEN DIFRONTDESK FORMAT Y-M-D H:i:s</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"schedule_date"</td>
                        <td>:</td>
                        <td class="v">"2020-06-28"</td>
                        <td class="c">TANGGAL PEMERIKSAAN PASIEN</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"schedule_time"</td>
                        <td>:</td>
                        <td class="v">"00:58:45"</td>
                        <td class="c">JAM PEMERIKSAAN PASIEN DAN DITAMBAH 10MENIT</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"priority"</td>
                        <td>:</td>
                        <td class="v">"Cito"</td>
                        <td class="c">prioritas pasien CITO / NORMAL</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"pat_state"</td>
                        <td>:</td>
                        <td class="v">"Rawat Jalan"</td>
                        <td class="c">RAWAT JALAN / RAWA INAP</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"spc_needs"</td>
                        <td>:</td>
                        <td class="v">"TB paru ?"</td>
                        <td class="c">KELUHAN PASIEN - NULL</td>
                    </tr>
                    <tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"payment"</td>
                        <td>:</td>
                        <td class="v">"Tunai"</td>
                        <td class="c">PEMBAYARAN PASIEN MENGGUNAKAN ?</td>
                    </tr>
					<tr>
                        <td class="k">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"fromorder"</td>
                        <td>:</td>
                        <td class="v">"SIMRS"</td>
                        <td class="c">Default value SIMRS</td>
                    </tr>
                    <tr>
                        <td>}</td>
                    </tr>
                </table> --}}
            </div>
        </div>
        {{-- <div class="card-header">
            <h5 class="card-title"><br><br><br> Get status expertise dokter<br><br><br></h5>
        </div>
        <table>
            <tr>
                <td>Link api</td>
                <td>:</td>
                <td>http://192.168.0.192:8000/api/workloads/{UID = 1.2.40.0.13.1.770804.20200710.20070715224}</td>
            </tr>
            <tr>
                <td>Method</td>
                <td>:</td>
                <td>GET</td>
            </tr>
            <tr>
                <td>Format</td>
                <td>:</td>
                <td>JSON</td>
            </tr>
        </table>
        <table class="table table-striped table-sm">
            <tr>
                <td>
<pre class="pretty">
<ol>
<li><span class="mid">{</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"uid"</span> <span class="mid">:</span> <span class="value">"1.2.40.0.13.1.770804.20200710.20070715224",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"acc"</span> <span class="mid">:</span> <span class="value">"2008241035",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"patientid"</span> <span class="mid">:</span> <span class="value">"X10710",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"mrn"</span> <span class="mid">:</span> <span class="value">"343690",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"name"</span> <span class="mid">:</span> <span class="value">"AGUS SUPRIADI, TN",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"address"</span> <span class="mid">:</span> <span class="value">"BANDUNG",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"sex"</span> <span class="mid">:</span> <span class="value">"M",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"birth_date"</span> <span class="mid">:</span> <span class="value">"1967-05-23",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"weight"</span> <span class="mid">:</span> <span class="value">"50",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"name_dep"</span> <span class="mid">:</span> <span class="value">"Poli Gigi",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"xray_type_code"</span> <span class="mid">:</span> <span class="value">"CR",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"typename"</span> <span class="mid">:</span> <span class="value">"Computed Radiography",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"prosedur"</span> <span class="mid">:</span> <span class="value">"Thorax",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokterid"</span> <span class="mid">:</span> <span class="value">"Y0026",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"named"</span> <span class="mid">:</span> <span class="value">"YOSUA NUGRAHA PRATAMA. dr",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokradid"</span> <span class="mid">:</span> <span class="value">"W0004",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"dokrad_name"</span> <span class="mid">:</span> <span class="value">"WAWAN KUSTIAWAN,dr.Sp.RAD",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"create_time"</span> <span class="mid">:</span> <span class="value">"2020-06-28 08:14:45",</span><span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"schedule_date"</span> <span class="mid">:</span> <span class="value">"2020-06-28",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"schedule_time"</span> <span class="mid">:</span> <span class="value">"00:58:45",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"priority"</span> <span class="mid">:</span> <span class="value">"Cito",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"pat_state"</span> <span class="mid">:</span> <span class="value">"Rawat Jalan",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"spc_needs"</span> <span class="mid">:</span> <span class="value">"TB paru ?",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"payment"</span> <span class="mid">:</span> <span class="value">"Tunai",</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"status"</span> <span class="mid">:</span> <span class="value">"APPROVED",</span></li>
<li><span class="mid">}</span></li>
</ol>
</pre> --}}
{{-- <pre> --}}
                        {{-- <code class="language-html"><br />
{
    "uid": "27.10.21.08.2321395316.83.20190923.96754183924378119",
    "acc": "2321395316",
    "patientid": "016887",
    "mrn": "016887",
    "name": "JUMIATI    ",
    "lastname": "",
    "address": null,
    "sex": "F",
    "birth_date": "19900630",
    "weight": null,
    "name_dep": null,
    "xray_type_code": "CR",
    "typename": null,
    "type": null,
    "prosedur": "ABDOMEN",
    "dokterid": null,
    "named": "JHON HARUN NAPITUPULU,DR.SPB    ",
    "lastnamed": null,
    "email": null,
    "radiographer_id": "",
    "radiographer_name": "",
    "radiographer_lastname": "",
    "dokradid": null,
    "dokrad_name": null,
    "dokrad_lastname": null,
    "create_time": "2019-09-23 10:03:36",
    "schedule_date": "2019-09-23 10:03:36",
    "schedule_time": "10:03:36",
    "contrast": null,
    "priority": null,
    "pat_state": null,
    "contrast_allergies": null,
    "spc_needs": null,
    "payment": null,
    "status": "APPROVED"
}
                        </code>
                    </pre>
                </td>
            </tr>
            <tr>
                <td>
                    Dokter sudah baca status :<br><br>
                    <pre><code class="language-html">
{
    "status":"APPROVED"
}
                </code></pre> --}}
                {{-- </td>
            </tr>
            <tr>
                <td>
                    Dokter belum baca pasien, status :
                    <pre class="pretty">
<ol>
<li><span class="mid">{</span></li>
<li>&nbsp;&nbsp;&nbsp;<span class="key">"status"</span> <span class="mid">:</span> <span class="value">"ready to approve"</span></li>
<li><span class="mid">}</span>
</ol>
            </pre>
                </td>
            </tr>
        </table> --}}
        <div class="card-header">
            <h5 class="card-title"><br><br><br> Sim RS : Get data url<br><br><br></h5>
        </div>
        <table class="table table-striped table-sm">
            <tr>
                <td>Hal yang dilakukan dari aplikasi SIMRS : </td>
            </tr>
            <tr>
                <td>1. Buat button untuk melihat hasil expertise dokter <br>
                    &nbsp; &nbsp; - Berikut link url untuk membuka hasil expertise dokter : <br>
                    <div class="v">&nbsp; &nbsp; &nbsp; http://192.168.0.192:8089/intiwid/radiology/pdf/testpdf4.php?uid=
                    </div><br>
                    &nbsp; &nbsp; - Dengan parameter UID get database simrs <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; 1.2.40.0.13.1.NORM.TANGGALSEKARANG.NOPERIKSA & KODETINDAKAN
                    </div><br>
                    &nbsp; &nbsp; - Jadi link digabung dengan parameter UID hasilnya adalah <br>
                    <div class="v">&nbsp; &nbsp; &nbsp; http://192.168.0.192:8089/intiwid/radiology/pdf/testpdf4.php?uid=
                        <div class="c" style="display:inline">1.2.40.0.13.1.770804.20200710.20070715224</div>
                    </div>
                    <div>
                        <br>
                        <img class="img-fluid" src="{{ asset("assets/img/pdf.png") }}" alt="">
                    </div>
                </td>
            </tr>
            <tr>
                <td>2. Buat button untuk melihat hasil gambar dicom versi 1<br>
                    &nbsp; &nbsp; - Berikut link url untuk membuka hasil gambar dicom : <br>
                    <div class="v">&nbsp; &nbsp; &nbsp; http://192.168.0.192:19898/intiwid/viewer.html?studyUID=
                    </div><br>
                    &nbsp; &nbsp; - Dengan parameter UID get database simrs <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; 1.2.40.0.13.1.NORM.TANGGALSEKARANG.NOPERIKSA & KODETINDAKAN
                    </div><br>
                    &nbsp; &nbsp; - Jadi link digabung dengan parameter UID hasilnya adalah <br>
                    <div class="v">&nbsp; &nbsp; &nbsp; http://192.168.0.192:19898/intiwid/viewer.html?studyUID=<div
                            class="c" style="display:inline">1.2.40.0.13.1.770804.20200710.20070715224</div>
                    </div>
                    <div>
                        <br><img class="img-fluid" src="{{ asset("assets/img/dicom1.png") }}" alt="">
                    </div>
                </td>
            </tr>
            <tr>
                <td>3. Buat button untuk melihat hasil gambar dicom versi 2 <br>
                    &nbsp; &nbsp; - Berikut link url untuk membuka hasil gambar dicom : <br>
                    <div class="v">&nbsp; &nbsp; &nbsp; http://192.168.0.192:3000/viewer/
                    </div><br>
                    &nbsp; &nbsp; - Dengan parameter UID get database simrs <br>
                    <div class="c">&nbsp; &nbsp; &nbsp; 1.2.40.0.13.1.NORM.TANGGALSEKARANG.NOPERIKSA & KODETINDAKAN
                    </div><br>
                    &nbsp; &nbsp; - Jadi link digabung dengan parameter UID hasilnya adalah <br>
                    <div class="v">&nbsp; &nbsp; &nbsp; http://192.168.0.192:3000/viewer/<div class="c"
                            style="display:inline">1.2.40.0.13.1.770804.20200710.20070715224</div>
                    </div>
                    <div>
                        <br><img class="img-fluid" src="{{ asset("assets/img/dicom2.png") }}" alt="">
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
    </div>
    </div>
    @include('includes.script');
</body>

</html>
