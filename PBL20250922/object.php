<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>object</title>
</head>

<body>
    <?php
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
    ?>
</body>

</html>