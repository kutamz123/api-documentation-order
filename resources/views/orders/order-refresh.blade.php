<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{ asset("assets/css/bootstrap.min.css")}}" rel="stylesheet" >
    <title>Order refresh</title>
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
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="" method="POST">
                        <tr v-for="(order, index) in orders">
                            <td v-text="order.mrn" :value="order.mrn"></td>
                            <td v-text="order.name"></td>
                            <td v-text="order.sex"></td>
                            <td v-text="order.xray_type_code"></td>
                            <td v-text="order.prosedur"></td>
                            <td v-text="order.dokrad_name"></td>
                            <td v-text="order.create_time"></td>
                            <td><button type="submit" @click="handleSubmit(order)" value="send" id="button">Send</button></td>
                        </tr>
                        {{-- @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->mrn }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->sex }}</td>
                                <td>{{ $order->xray_type_code }}</td>
                                <td>{{ $order->prosedur }}</td>
                                <td>{{ $order->dokrad_name }}</td>
                                <td>{{ $order->create_time }}</td>
                                <td><input type="button" value="send"></td>
                            </tr>
                        @endforeach --}}
                    </form>
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset("assets/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset("assets/js/axios.min.js") }}"></script>
    <script src="{{ asset("assets/js/vue.js") }}"></script>
    <script src="{{ asset("assets/js/script.js") }}"></script>
</body>
</html>
