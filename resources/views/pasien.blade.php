<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil untuk pasien</title>
</head>

<body>
    <div class="container">
            <table class="table">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $study->patient->pat_name; }}</td>
                </tr>
                <tr>
                    <td>Tgl Lahir</td>
                    <td>:</td>
                    <td>{{ date('d-m-Y', strtotime($study->patient->pat_birthdate)); }}</td>
                </tr>
                <tr>
                    <td>Pemeriksaan</td>
                    <td>:</td>
                    <td>{{ $study->study_desc; }}</td>
                </tr>
                <tr>
                    <td>Hasil</td>
                    <td>:</td>
                    <td>{{ $study->workload->fill; }}</td>
                </tr>
            </table>
            <hr>
            <iframe src="http://{{ $_SERVER['SERVER_NAME'] . ':' }}{{ $_SERVER['SERVER_NAME'] == $hostname->ip_publik ? '92' : '91'; }}/viewer/{{ $study->study_iuid; }}" width="100%" height="700px" frameborder="0"></iframe>
            <!-- <iframe src="http://202.150.157.78:92/viewer/1.2.40.0.13.1.286424.20230127.09161597301" width="100%" height="700px" frameborder="0"></iframe> -->
    </div>
</body>

</html>
