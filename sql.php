<?php
/**
 * Created by PhpStorm.
 * User: Grishka_adminishka
 * Date: 16.12.2018
 * Time: 19:57
 */

class sql
{
private $servername = "127.0.0.1";
private $database = "university_lab";
private $username = "root";
private $password = "";
private $connection;

private function CreateConnection(){
     $this->connection= mysqli_connect($this->servername, $this->username, $this->password, $this->database);

// Check connection

    if (!$this->connection) {

        die("Connection failed: " . mysqli_connect_error());

    }
   // echo "Connected successfully";
}

public function AddTurn($x,$y,$turn,$gameId){
    $this->CreateConnection();
    $sql = "INSERT INTO game_data (game_id, turn, turn_place) VALUES ('$gameId','$turn','$x:$y')";
    if (mysqli_query($this->connection, $sql)) {
       // echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
    }
    mysqli_close($this->connection);
}

public function DeleteTurnOfEndedSession($gameId){
    $this->CreateConnection();
    $sql = "DELETE FROM game_data WHERE  game_id=$gameId";
    if (mysqli_query($this->connection, $sql)) {
        // echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
    }
    mysqli_close($this->connection);
}

public function AddWin($gameId,$win){
    $this->CreateConnection();
    $sql = "UPDATE user SET win=$win WHERE  game_id=$gameId";
    if (mysqli_query($this->connection, $sql)) {
        // echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
    }
    mysqli_close($this->connection);
}

}