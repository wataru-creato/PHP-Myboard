<?php 

$dsn="mysql:host=localhost;dbname=myboard;charset=utf8";
$host="localhost";
$dbname="myboard";
$user="root";
$pass="83018042wtr&MySQL!";

try{
    $pdo=new PDO($dsn,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    exit("DB Error:".$e->getMessage());
}

?>