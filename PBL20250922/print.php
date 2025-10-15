<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
</head>

<body>
    <?php
    print "Hello World!<br>";
    print "Ini adalah print dengan satu parameter.<br>";
    print "<h1>Judul dengan print</h1>";
    $text = "Teks dari variabel.<br>";
    print $text;
    print "90 + 5 = " . (90 + 5) . "<br>";
    print "Baris pertama\nBaris kedua<br>";
    $arr = ["Satu", "Dua", "Tiga"];
    print $arr[0] . ", " . $arr[1] . ", " . $arr[2] . "<br>";
    ?>
</body>

</html>