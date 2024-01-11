<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>create ttd tangan dokter radiologi</title>
</head>
<body>
    <iframe src="http://<?= $_SERVER['HTTP_HOST']; ?>/dokter-radiology/{{ $dokterRadiology->pk }}" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto"></iframe>
    <form action="/dokter-radiology/{{ $dokterRadiology->pk }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <span>{{ $dokterRadiology->dokrad_name . ' ' . $dokterRadiology->dokrad_lastname }}</span> <br> <hr>
        <input type="file" name="dokrad_img" accept="image/png, image/PNG, image/jpeg, image/jpg, image/JPG"> <br> <br>
        <input type="submit" value="send">
    </form>
</body>
</html>
