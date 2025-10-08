<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print_r</title>
</head>

<body>
    <?php
    print_r("Hello World!<br>");
    print_r("Ini adalah print_r dengan satu parameter.<br>");
    print_r("<h1>Judul dengan print_r</h1>");
    $text = "Teks dari variabel.<br>";
    print_r($text);
    print_r("90 + 5 = " . (90 + 5) . "<br>");
    print_r("Baris pertama\nBaris kedua<br>");
    $arr = array("Satu", "Dua", "Tiga");
    print_r($arr);
    echo "<br>";
    ?>
</body>

</html>