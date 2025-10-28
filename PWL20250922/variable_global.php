<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>variable global</title>
</head>

<body>
    <?php
    $a = 20;
    $b = 30;

    function tambahNilai()
    {
        $GLOBALS['b'] = $GLOBALS['a'] + $GLOBALS['b'];
    }

    tambahNilai();
    echo $b;
    ?>
</body>

</html>