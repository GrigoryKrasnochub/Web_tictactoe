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
    //Кол-во для победы
    private $countToWin=3;
    //Массив с победкой
    private $winnerCells = array();
    //Победитель
    private  $winner;
    //счетчик ходов
    private $turnCounter=0;
    //Сообщение о конце игры
    private  $conclusionSentence;


    //Делаем ход пользователя
    public function MakeTurn ($x,$y){
    if (!$this->isEnded && $x<=$this->fieldSize && $x>0&& $y<=$this->fieldSize && $y>0 && empty($this->gameField [$x-1][$y-1])){
        $this->gameField [$x-1][$y-1]=$this->turn? 1:2;
        $this->turnCounter+=1;
        $this->WinnerSearcher();
        $this->turn=!$this->turn;

    }
    }


    //Господа, я снимаю с себя всякую ответственность, я не знаю зачем я это написал, объявляю себя королем костылей! СЛАВА КОРОЛЮ СЛАВА КОРОЛЮ (С)Григорий Красночуб :3
    private function WinnerSearcher(){
        $winCounter=$this->countToWin;
        $possibleWinner=$this->turn? 1:2;
        for ($i=0;$i<$this->fieldSize;$i++){
            for ($j=0;$j<$this->fieldSize;$j++){
                if($this->gameField [$i][$j]==$possibleWinner){

                    //вертикаль
                   for($q=0;$q<$this->fieldSize;$q++){
                       if ($this->gameField [$q][$j]==$possibleWinner){
                           $winCounter-=1;
                       }
                       if($winCounter==0){
                           $this->isEnded=true;
                       }
                   }
                    $winCounter=$this->countToWin;
                   //горизонталь
                    for($q=0;$q<$this->fieldSize;$q++){
                        if ($this->gameField [$i][$q]==$possibleWinner){
                            $winCounter-=1;
                        }
                        if($winCounter==0){
                            $this->isEnded=true;
                        }
                    }
                    $winCounter=$this->countToWin;
                    //диагональ по прямому слэшу
                    try {
                        for ($q = 0; $q < $this->fieldSize; $q++) {
                            if ($this->gameField [$i - $q][$j - $q] == $possibleWinner) {
                                $winCounter -= 1;
                            }
                            if ($winCounter == 0) {
                                $this->isEnded = true;
                            }
                        }
                    }catch(Exception $e){}
                    $winCounter=$this->countToWin;
                    //диагональ по обратному слэшу
                    try {
                    for($q=0;$q<$this->fieldSize;$q++){
                        if ($this->gameField [$i+$q][$j-$q]==$possibleWinner){
                            $winCounter-=1;
                        }
                        if($winCounter==0){
                            $this->isEnded=true;
                        }
                    }
                    }catch(Exception $e){}
                    $winCounter=$this->countToWin;

                }
                $winCounter=$this->countToWin;
            }
        }

        if($this->isEnded){
            $whoIsWin=$this->turn? "Circles":"Cross";
            $this->conclusionSentence="Winer is ".$whoIsWin;
        }
        //Ничья
        if(!$this->isEnded && $this->turnCounter==$this->fieldSize*$this->fieldSize){
            $this->isEnded=true;
            $this->conclusionSentence="Game Over";
        }
        if($this->isEnded){
            $this->ShowWinner();
        }
    }

    private function ShowWinner(){
        $end = $this->conclusionSentence;
        echo "<b>$end</b>";
    }

    public function GetCurrentTurn(){
        $result = $this->turn ? "Circle":"Cross";
        return "Turn: ".$result;
    }

    public function GetFieldSize() {return $this->fieldSize;}
    public function GetGameField() {return $this->gameField;}
}