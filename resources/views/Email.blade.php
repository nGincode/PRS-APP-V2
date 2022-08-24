<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <h1>Terima Kasih Telah Membeli Tiket <br> {{ $nama }}</h1>
    <br>
    Jumlah Yang anda beli : {{ $jumlah }} <br>
    Silahkan kunjungi link berikut untuk akses voucher :<br>
    {{ url('Ticket/Masuk?id=' . $kode) }}

</body>

</html>
