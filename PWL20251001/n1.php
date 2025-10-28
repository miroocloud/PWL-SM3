<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas 1</title>
</head>

<body>
    <h2>Daftar Negara dan Ibukota</h2>
    <hr>
    <?php
    $negaraAsia = [
        "Indonesia" => "Jakarta",
        "India" => "New Delhi",
        "Jepang" => "Tokyo",
        "Cina" => "Beijing",
        "Malaysia" => "Kuala Lumpur",
        "Filipina" => "Manila",
        "Korea Utara" => "Pyongyang",
        "Korea Selatan" => "Seoul",
        "Iran" => "Teheran",
        "Irak" => "Baghdad",
        "Vietnam" => "Hanoi",
        "Thailand" => "Bangkok"
    ];

    $no = 1;
    foreach ($negaraAsia as $negara => $ibukota) {
        echo "$no. $negara ibukotanya $ibukota<br>";
        $no++;
    }
    ?>
</body>

</html>