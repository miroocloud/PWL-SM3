<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tipe data</title>
</head>

<body>
    <?php
    // string
    $nama = "Farid";
    echo "Nama saya $nama";
    echo "<br>";
    echo 'Nama saya $nama';
    echo "<br>";
    echo 'Nama saya ' . $nama;
    echo "<br>";

    // integer
    $nilai = 100;
    var_dump($nilai);
    echo "<br>";
    $negatif = -100;
    var_dump($negatif);
    echo "<br>";

    // float
    $nilaiDesimal = 10.5;
    var_dump($nilaiDesimal);
    echo "<br>";
    $nilaiNegatif = -10.5;
    var_dump($nilaiNegatif);
    echo "<br>";

    // boolean
    $benar = true;
    var_dump($benar);
    echo "<br>";
    $salah = false;
    var_dump($salah);
    echo "<br>";

    // array
    $buah = array("Mangga", "Pisang", "Jeruk");

    echo "Buah pertama: " . $buah[0] . "<br>";
    echo "Buah kedua: " . $buah[1] . "<br>";
    echo "Buah ketiga: " . $buah[2] . "<br>";

    $buah[] = "Apel";
    echo "Buah keempat: " . $buah[3] . "<br>";

    echo "Daftar Buah:<br>";
    foreach ($buah as $item) {
        echo "- " . $item . "<br>";
    }

    // object
    class Mobil
    {
        public $warna;
        public $merk;

        public function __construct($warna, $merk)
        {
            $this->warna = $warna;
            $this->merk = $merk;
        }

        public function info()
        {
            return "Mobil ini berwarna " . $this->warna . " dan bermerek " . $this->merk . ".";
        }
    }

    $mobilSaya = new Mobil("merah", "Toyota");
    echo $mobilSaya->info();

    // null
    $kosong = null;
    var_dump($kosong);
    echo "<br>";
    $data = "hello...";
    $data = null;
    var_dump($data);
    ?>
</body>

</html>