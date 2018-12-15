<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

    <title>Крестики-нолики</title>

    <style type="text/css">

        BODY {

            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%)

        }
        TD {
            padding: 3px; /* Поля вокруг содержимого таблицы */
            border: 1px solid black;
            width: 200px;
            height: 200px;
            text-align: center;
        }
        input{
            margin-right: 10px;
        }
        TR {

        }
    </style>

</head>
<body>

<?php

$tableSize=3;

echo '<table>';

for ($i=0;$i<$tableSize;$i++){

    echo '<tr>';

    for ($j=0;$j<$tableSize;$j++){

        echo "<td>$i*$j</td>";
    }
    echo '</tr>';
}

echo '</table>';
echo '<form action="cross.php" method="get">';
echo '<input type="text" name="row" id="row" placeholder="Row">';
echo '<input type="text" name="column" id="column" placeholder="Column" >';
echo '<input type="submit" value="Make turn">';
echo '</form>';
echo '<p>';
echo '<form action="cross.php" method="get">';
echo '<input type="submit" name="Restart" value="Restart">';
echo '</form>';
?>

</body>

</html>