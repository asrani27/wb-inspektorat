<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPEKTORAT KOTA BANJARMASIN</title>
</head>

<body>
    <h1>{{ $details['title'] }}</h1>
    <p>{{ $details['body'] }}</p>
    <p>NIP : {{ $details['nip'] }}</p>
    <p>NAMA : {{ $details['nama_lengkap'] }}</p>
    <p>TELP : {{ $details['telp'] }}</p>
    <p>EMAIL : {{ $details['email'] }}</p>
    <p>ADUAN : {{ $details['aduan'] }}</p>
    {{-- <p>{{ $details['bukti'] }}</p> --}}

    <p>Terima Kasih</p>
</body>

</html>