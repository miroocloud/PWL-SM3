<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas 3</title>
</head>

<body>
    <?php
    $rate = [
        'usd' => 14367,
        'jpy' => 1192,
        'cny' => 2262,
        'krw' => 11.87,
        'myr' => 3416,
        'sgd' => 10621,
        'gbp' => 19074,
        'eur' => 15891
    ];

    function konversiRupiah($jumlah, $mataUang, $rate)
    {
        if (isset($rate[$mataUang])) {
            $hasil = $jumlah * $rate[$mataUang];
            echo "$jumlah $mataUang dikonversi menjadi Rp " . number_format($hasil, 0, ',', '.') . "<br>";
        } else {
            echo "Mata uang $mataUang tidak ditemukan.<br>";
        }
    }

    konversiRupiah(8, 'usd', $rate);
    konversiRupiah(7, 'jpy', $rate);
    konversiRupiah(10, 'cny', $rate);
    konversiRupiah(1000, 'krw', $rate);
    ?>
</body>

</html>