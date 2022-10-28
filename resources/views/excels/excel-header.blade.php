<table>
    <thead>
        <tr>
            <td>Tgl Periode: </td>
            <td>Dari {{ $detail['fromUpdatedTime'] }} - Hingga {{ $detail['toUpdatedTime'] }}</td>
        </tr>
            <tr>
            <td>Modality : </td>
            <td>{{ $detail['modsInStudy'] }}</td>
        </tr>
        <tr>
            <td>Keadaan Pasien : </td>
            <td>{{ $detail['priorityDoctor'] }}</td>
        </tr>
        <tr>
            <td>Tgl Penarikan : </td>
            <td>{{ $detail['dateNow'] }}</td>
        </tr>
    </thead>
</table>
