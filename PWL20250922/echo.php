<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echo</title>
</head>

<body>
    <?php
    echo "Hello World!<br>";
    echo "Ini ", "adalah ", "echo ", "dengan ", "beberapa parameter.<br>";
    echo "<h1>Judul dengan echo</h1>";
    $text = "Teks dari variabel.<br>";
    echo $text;
    echo "90 + 5 = " . 90 + 5, "<br>";
    echo "Baris pertama\nBaris kedua<br>";
    $arr = ["Satu", "Dua", "Tiga"];
    echo $arr[0], ", ", $arr[1], ", ", $arr[2], "<br>";
    ?>
</body>

</html>