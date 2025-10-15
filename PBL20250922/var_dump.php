<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Var_dump</title>
</head>

<body>
    <?php
    $nama = "Farid";
    $umur = 21;
    $is_mahasiswa = true;
    $hobi = array("Anime", "Kalcer", "OSS Coding");

    echo "Nama: ";
    var_dump($nama);
    echo "<br>";

    echo "Umur: ";
    var_dump($umur);
    echo "<br>";

    echo "Mahasiswa: ";
    var_dump($is_mahasiswa);
    echo "<br>";

    echo "Hobi: ";
    var_dump($hobi);
    ?>
</body>

</html>