<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orders</title>
    @include('includes.style')
</head>
<body>
    <div id="orders">
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">MRN/Patient ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Modalitas</th>
                        <th scope="col">Prosedur</th>
                        <th scope="col">Nama Dokter</th>
                        <th scope="col">Waktu Order</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(order, index) in orders">
                        <td v-text="order.mrn" :value="order.mrn"></td>
                        <td v-text="order.name"></td>
                        <td v-text="order.sex"></td>
                        <td v-text="order.xray_type_code"></td>
                        <td v-text="order.prosedur"></td>
                        <td v-text="order.dokrad_name"></td>
                        <td v-text="order.create_time"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @include('includes.script')
    <script src="{{ asset("assets/js/script-order.js") }}"></script>
</body>
</html>
