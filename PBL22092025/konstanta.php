<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>konstanta</title>
</head>

<body>
    <?php
    define("SALAM", "Selamat Pagi");
    define("PI", 3.14159);

    define("WARNA", [
        "Merah",
        "Hijau",
        "Biru"
    ]);

    define("ANGKA", [1, 2, 3, 4, 5]);

    function salam()
    {
        echo SALAM;
    }

    function hitungLuas($jariJari)
    {
        return PI * $jariJari * $jariJari;
    }

    salam();
    echo "<br>";
    echo "Warna pertama: " . WARNA[0];
    echo "<br>";
    echo "Angka ketiga: " . ANGKA[2];
    echo "<br>";
    echo "Luas lingkaran (r=5): " . hitungLuas(5);
    ?>
</body>

</html>