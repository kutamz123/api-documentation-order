<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>create kop surat</title>
</head>
<body>
    <form action="/kop-surat" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="kode_image" value="1">
        <input type="file" name="image" accept="image/png, image/PNG, image/jpeg, image/jpg, image/JPG">
        <input type="submit" value="send">
    </form>
</body>
</html>
