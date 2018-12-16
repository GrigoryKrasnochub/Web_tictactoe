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

        body {
            font-family: Arial;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #board {
            margin: 30px 0 30px 0;
            border-collapse: collapse;
        }

        td {
            border: 1px solid black;
            width: 22vh;
            height: 22vh;
            text-align: center;
        }

        td span {
            font-size: 13vh;
        }

        /* убираем внешние границы*/
        td:first-of-type {
            border-left-color: transparent;
            border-top-color: transparent;
        }
        td:nth-of-type(2) {
            border-top-color: transparent;
        }
        td:nth-of-type(3) {
            border-right-color: transparent;
            border-top-color: transparent;
        }
        tr:nth-of-type(3) td {
            border-bottom-color: transparent;
        }

        h1 {
            text-align: center;
        }

        input{
            margin-right: 10px;
        }

    </style>

</head>
<body>
<div>

<?php
//Получили размер поля
$tableSize=$game->GetFieldSize();
//Получили заполненное игровое полк
$gameField=$game->GetGameField();

$userHint=$game->GetCurrentTurn();

echo "<h1>$userHint</h1>";

echo '<table id="board">';

for ($i=0;$i<$tableSize;$i++){

    echo '<tr>';

    for ($j=0;$j<$tableSize;$j++){
        $result="";
        if($gameField[$i][$j]==2){
            $result = "<span>X</span>";
        }
        if($gameField[$i][$j]==1){
            $result = "<span>O</span>";
        }
        echo "<td>$result</td>";
    }
    echo '</tr>';
}

echo '</table>';
?>

<form action="index.php?action=move" method="post">
<input type="text" name="row" id="row" placeholder="Row">
<input type="text" name="column" id="column" placeholder="Column" >
<input type="submit" value="Make turn">
</form>
<a href="?action=Restart">Restart</a>

</div>
</body>

</html>