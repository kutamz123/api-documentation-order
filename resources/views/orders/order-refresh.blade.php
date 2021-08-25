<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Order refresh</title>
  </head>
  <body>
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
                <form action="" method="post">
                    @foreach ($orders as $order)
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
                    @endforeach
                </form>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset("assets/script.js") }}"></script>
</body>
</html>
