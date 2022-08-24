<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <?php
    echo '<img  width="800px" src="' . url('/uploads/ticket/' . $img_voc) . '"> <br>';
    echo '<div style="position: relative;margin-top: -245px;margin-left: 65px;">' . $barcode . '</div>';
    echo '<div style="position: relative;margin-top: -282px;font-size: 30px;width: 800px;text-align: center;font-weight: bolder;font-family: monospace;">' . $nama . '</div>';
    echo '<div style="position: absolute;font-family: fantasy;top: 43px;font-size: 50px;left: 27px;width: 77px;text-align: center;">' . $jumlah . '</div>';
    ?>
</body>

</html>
