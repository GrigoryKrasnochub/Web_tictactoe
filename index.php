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

    } else if($action == 'restart') {
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
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="container">
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
<a href="?action=restart">Restart</a>

</div>
</div>
</body>

</html>