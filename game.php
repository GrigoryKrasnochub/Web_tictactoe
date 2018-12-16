<?php
require_once(dirname(__FILE__) . '/sql.php');
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
    //счетчик ходов
    private $turnCounter=0;
    //Сообщение о конце игры
    private  $conclusionSentence;
    // стиль для зачеркивания
    private  $crossStyle;
    // Был ли счетчик обновлен
    private $isUpdated=false;
    //sql
    private $sql;

    //Делаем ход пользователя
    public function MakeTurn ($x,$y){
    if (!$this->isEnded && $x<=$this->fieldSize && $x>0&& $y<=$this->fieldSize && $y>0 && empty($this->gameField [$x-1][$y-1])){
        $this->gameField [$x-1][$y-1]=$this->turn? 1:2;
        $this->turnCounter+=1;
        $this->sql=isset($this->sql)?$this->sql:new sql();
        $this->sql->AddTurn($x,$y,$this->turn,1);
        $this->WinnerSearcher();
        if(!$this->isEnded)$this->turn=!$this->turn;

    }
    }


    //Господа, я снимаю с себя всякую ответственность, я не знаю зачем я это написал, объявляю себя королем костылей! СЛАВА КОРОЛЮ СЛАВА КОРОЛЮ (С)Григорий Красночуб :3
    private function WinnerSearcher(){
        $winCounter=$this->countToWin;
        $possibleWinner=$this->turn? 1:2;
        $this->crossStyle = '';
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
												 $this->crossStyle = 'column_' . ($j+1);
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
													$this->crossStyle = 'row_' . ($i+1);
                        }
                    }
                    $winCounter=$this->countToWin;
                    //диагональ по прямому слэшу \
                    try {
                        for ($q = 0; $q < $this->fieldSize; $q++) {
                            if ($this->gameField [$i - $q][$j - $q] == $possibleWinner) {
                                $winCounter -= 1;
                            }
                            if ($winCounter == 0) {
                                $this->isEnded = true;
																$this->crossStyle = 'left_diag';
														}
                        }
                    }catch(Exception $e){}
                    $winCounter=$this->countToWin;
                    //диагональ по обратному слэшу /
                    try {
                    for($q=0;$q<$this->fieldSize;$q++){
                        if ($this->gameField [$i+$q][$j-$q]==$possibleWinner){
                            $winCounter-=1;
                        }
                        if($winCounter==0){
                            $this->isEnded=true;
                            $this->crossStyle = 'right_diag';
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
            $this->conclusionSentence="Winner is ".$whoIsWin;
        }
        //Ничья
        if(!$this->isEnded && $this->turnCounter==$this->fieldSize*$this->fieldSize){
            $this->isEnded=true;
            $this->conclusionSentence="Game Over";
        }
    }

    public function ShowWinner(){
        if ($this->isEnded) {
					$end = $this->conclusionSentence;
					echo "<h1>$end</h1>";
				}
    }

    public function UpdateWinCounter(){

        if($this->isEnded&&!$this->isUpdated){
        $this->isUpdated=true;
        $this->incrementWinCounter();
        }
        $win_number=$_SESSION['win'];
        echo "<h1>Circle $win_number Cross</h1>";
    }

    public function incrementWinCounter(){

        $gameData=explode(":",$_SESSION['win']);

        if($this->turn){
            $gameData[0]=(int)$gameData[0]+1;
        }
        else{
            $gameData[1]=(int)$gameData[1]+1;
        }
        $_SESSION['win']=$gameData[0].":".$gameData[1];
    }

    public function GetCurrentTurn(){
        $result = $this->turn ? "Circle":"Cross";
        return "Turn: ".$result;
    }

    public function GetFieldSize() {return $this->fieldSize;}
    public function GetGameField() {return $this->gameField;}
    public function GetСrossStyle() {return $this->crossStyle;}
}