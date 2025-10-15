<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>array</title>
</head>

<body>
    <?php
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
    ?>
</body>

</html>