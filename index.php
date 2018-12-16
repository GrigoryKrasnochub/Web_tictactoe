<?php
//Подключили класс
require_once(dirname(__FILE__) . '/game.php');

//Выгрузили сессию
session_start();

//Присвоили переменной экземпляр
$game = isset($_SESSION['game'])? $_SESSION['game']: null;

//Сделали экземпляр, если в сессии было пусто
if(!$game || !is_object($game)) {
    $game = new game();
}
//Обрабатываем запросы
$params = $_GET + $_POST;
if(isset($params['action'])) {
    $action = $params['action'];

    if($action == 'move') {
        // Обрабатываем ход пользователя.
        $game->MakeTurn((int)$params['row'], (int)$params['column']);

    } else if($action == 'Restart') {
        // Пользователь решил начать новую игру.
        $game = new game();
    }
}

//Записали в сессию
$_SESSION['game'] = $game;





?>


<html lang="eng">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>TicTacToe</title>

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
            padding: 3px;
            border: 1px solid black;
            width: 200px;
            height: 200px;
            text-align: center;
        }
        input{
            margin-right: 10px;
        }
        Tcross {

        }
        Tcircle {

        }
    </style>

</head>
<body>

<?php
//Получили размер поля
$tableSize=$game->GetFieldSize();
//Получили заполненное игровое полк
$gameField=$game->GetGameField();

$userHint=$game->GetCurrentTurn();

echo "<a>$userHint</a>";

echo '<table>';

for ($i=0;$i<$tableSize;$i++){

    echo '<tr>';

    for ($j=0;$j<$tableSize;$j++){
        $result="";
        if($gameField[$i][$j]==2){
            $result = "<Tcross>КРЕСТ</Tcross>";
        }
        if($gameField[$i][$j]==1){
            $result = "<Tcircle>НОЛЬ</Tcircle>";
        }
        echo "<td>$result</td>";
    }
    echo '</tr>';
}

echo '</table>';
echo '<form action="index.php?action=move" method="post">';
echo '<input type="text" name="row" id="row" placeholder="Row">';
echo '<input type="text" name="column" id="column" placeholder="Column" >';
echo '<input type="submit" value="Make turn">';
echo '</form>';
echo '<p>';
echo '<br/><a href="?action=Restart">Restart</a>';
?>

</body>

</html>