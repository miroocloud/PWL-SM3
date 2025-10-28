<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>variable static</title>
</head>

<body>
    <?php
    function tampilAngka()
    {
        static $angka = 1;
        echo $angka;
        $angka++;
    }

    tampilAngka();
    echo "<br>";
    tampilAngka();
    echo "<br>";
    tampilAngka();
    ?>
</body>

</html>