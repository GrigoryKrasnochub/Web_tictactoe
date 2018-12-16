<?php
/**
 * Created by PhpStorm.
 * User: Grishka_adminishka
 * Date: 16.12.2018
 * Time: 10:26
 */

class game
{
    //Размер поля
    private $fieldSize = 3;
    //Чей ход Кресты это враки
    private $turn = false;
    //Окончена ли игра
    private $isEnded = false;
    //Игровое поле
    private $gameField = array();

    //Делаем ход пользователя
    public function MakeTurn ($x,$y){
    if (!$this->isEnded && $x<=$this->fieldSize && $x>0&& $y<=$this->fieldSize && $y>0 && empty($this->gameField [$x-1][$y-1])){
        $this->gameField [$x-1][$y-1]=$this->turn? 1:2;
        $this->turn=!$this->turn;
    }
    }

    public function GetCurrentTurn(){
        $result = $this->turn ? "Circle":"Cross";
        return "Turn: ".$result;
    }

    public function GetFieldSize() {return $this->fieldSize;}
    public function GetGameField() {return $this->gameField;}
}