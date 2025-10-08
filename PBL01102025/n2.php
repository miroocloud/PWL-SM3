<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas 2</title>
</head>

<body>
    <?php
    $suhuUdara = [29, 35, 38, 31, 34, 36, 39, 33, 34, 40, 35, 32, 37, 34, 31, 36, 33, 39, 30, 33, 41];

    // Rata-rata suhu
    $rata = array_sum($suhuUdara) / count($suhuUdara);

    // 5 suhu paling rendah
    sort($suhuUdara);
    $suhuRendah = array_slice($suhuUdara, 0, 5);

    // 5 suhu paling tinggi
    rsort($suhuUdara);
    $suhuTinggi = array_slice($suhuUdara, 0, 5);

    echo "Rata-rata suhu adalah " . number_format($rata, 1) . "<br>";
    echo "5 suhu paling rendah adalah " . implode(", ", $suhuRendah) . "<br>";
    echo "5 suhu paling tinggi adalah " . implode(", ", $suhuTinggi) . "<br>";
    ?>
</body>

</html>