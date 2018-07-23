<?php
$servername = "localhost";
$username = "root";
$password = "";
$charset="utf8";
try{
    $connection = new PDO('mysql:host=localhost;dbname=db;', $username, $password);
    $connection->query("SET CHARSET utf8");


} catch(PDOException $e){
    echo $e.getMessage();
}

?>
