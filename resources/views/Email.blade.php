<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <h2>Terima Kasih Telah Membeli Tiket <br><br></h2>
    <h3>{{ $nama }}</h3>
    <br>
    Jumlah Yang anda beli : {{ $jumlah }} <br>
    Silahkan kunjungi link berikut untuk akses voucher :<br>
    {{ url('Ticket/Masuk?id=' . $kode) }}

</body>

</html>
